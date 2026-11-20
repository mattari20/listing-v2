<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Directory\PublicDirectoryQueryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

final class AccountSavedItemsController extends Controller
{
    public function index(Request $request, PublicDirectoryQueryService $directory): Response
    {
        $locale = $this->applyLocale($request);
        $rows = DB::table('saved_directory_items')
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get(['id', 'entity_id', 'created_at']);

        $items = $rows->map(static function (object $row) use ($directory): array {
            return [
                'id' => (int) $row->id,
                'entity_id' => (string) $row->entity_id,
                'created_at' => (string) $row->created_at,
                'profile' => $directory->find((string) $row->entity_id),
            ];
        })->all();

        return response()->view('account.saved-items', [
            'items' => $items,
            'locale' => $locale,
            'direction' => $locale === 'ur' ? 'rtl' : 'ltr',
            'limit' => $this->savedItemsLimit(),
        ])->header('Cache-Control', 'private, no-store, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function store(Request $request, string $entity, PublicDirectoryQueryService $directory): RedirectResponse
    {
        $this->applyLocale($request);
        abort_if($directory->find($entity) === null, 404);

        $userId = $request->user()->getAuthIdentifier();
        $limit = $this->savedItemsLimit();
        $result = DB::transaction(function () use ($userId, $entity, $limit): string {
            abort_if(DB::table('users')->where('id', $userId)->lockForUpdate()->first() === null, 401);

            if (DB::table('saved_directory_items')->where('user_id', $userId)->where('entity_id', $entity)->exists()) {
                return 'exists';
            }

            if (DB::table('saved_directory_items')->where('user_id', $userId)->count() >= $limit) {
                return 'full';
            }

            $now = now();
            DB::table('saved_directory_items')->insert([
                'user_id' => $userId,
                'entity_id' => $entity,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return 'saved';
        });

        return back()->with('saved_items_status', match ($result) {
            'exists' => __('directory.saved_item_exists'),
            'full' => __('directory.saved_items_full', ['limit' => $limit]),
            default => __('directory.saved_item_added'),
        });
    }

    public function destroy(Request $request, string $entity): RedirectResponse
    {
        $this->applyLocale($request);
        DB::table('saved_directory_items')
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('entity_id', $entity)
            ->delete();

        return back()->with('saved_items_status', __('directory.saved_item_removed'));
    }

    private function savedItemsLimit(): int
    {
        return max(1, min(100, (int) config('directory.saved_items_limit', 50)));
    }

    private function applyLocale(Request $request): string
    {
        $requested = $request->input('lang', $request->session()->get('directory_locale', 'en'));
        $locale = is_string($requested) && in_array($requested, ['en', 'ur'], true) ? $requested : 'en';
        $request->session()->put('directory_locale', $locale);
        App::setLocale($locale);

        return $locale;
    }
}
