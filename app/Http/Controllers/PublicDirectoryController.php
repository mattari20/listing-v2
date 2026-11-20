<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Directory\PublicDirectoryComparisonService;
use App\Services\Directory\PublicDirectoryQueryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class PublicDirectoryController extends Controller
{
    private const SHORTLIST_SESSION_KEY = 'directory_shortlist';

    public function index(Request $request, PublicDirectoryQueryService $directory): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'type' => ['nullable', 'string', 'max:40'],
            'locality' => ['nullable', 'string', 'max:120'],
            'filters' => ['nullable', 'array', 'max:12'],
            'filters.*' => ['nullable', 'string', 'max:120'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = trim((string) ($validated['q'] ?? ''));
        $type = ($validated['type'] ?? '') !== '' ? (string) $validated['type'] : null;
        $locality = trim((string) ($validated['locality'] ?? ''));
        $filterOptions = $directory->filterOptions();
        $filters = [];
        foreach (($validated['filters'] ?? []) as $key => $value) {
            if (isset($filterOptions[$key]) && in_array($value, $filterOptions[$key]['values'], true)) {
                $filters[$key] = $value;
            }
        }
        $data = $directory->search($query, $type, $locality, $filters);
        $perPage = 20;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = new LengthAwarePaginator(
            array_slice($data['results'], ($page - 1) * $perPage, $perPage),
            count($data['results']),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('directory.index', [
            'query' => $query,
            'type' => $type,
            'locality' => $locality,
            'filters' => $filters,
            'filterOptions' => $filterOptions,
            'filterGroups' => collect($filterOptions)->groupBy('group', true),
            'typeOptions' => $directory->typeOptions(),
            'facets' => $data['facets'],
            'results' => $results,
            'shortlistCount' => count($this->sessionShortlist($request)),
            'shortlistLimit' => (int) config('directory.shortlist_limit', 5),
        ]);
    }

    public function addToShortlist(Request $request, string $entity, PublicDirectoryQueryService $directory): RedirectResponse
    {
        $profile = $directory->find($entity);
        abort_if($profile === null, 404);

        $ids = $this->sessionShortlist($request);
        if (in_array($entity, $ids, true)) {
            return back()->with('shortlist_status', 'This option is already in your temporary shortlist.');
        }

        $profiles = array_values(array_filter(array_map(
            static fn (string $id): ?array => $directory->find($id),
            $ids
        )));
        $ids = array_column($profiles, 'id');
        $request->session()->put(self::SHORTLIST_SESSION_KEY, $ids);
        foreach ($profiles as $selectedProfile) {
            if ($selectedProfile['type'] !== $profile['type']) {
                return back()->withErrors(['shortlist' => 'Choose the same category for every comparison.'])->withInput();
            }
        }

        $limit = max(2, min(10, (int) config('directory.shortlist_limit', 5)));
        if (count($ids) >= $limit) {
            return back()->withErrors(['shortlist' => 'Your temporary shortlist is full. Remove an option before adding another.'])->withInput();
        }

        $ids[] = $entity;
        $request->session()->put(self::SHORTLIST_SESSION_KEY, array_values(array_unique($ids)));

        return back()->with('shortlist_status', 'Added to your temporary shortlist.');
    }

    public function removeFromShortlist(Request $request, string $entity): RedirectResponse
    {
        $ids = array_values(array_filter(
            $this->sessionShortlist($request),
            static fn (string $id): bool => $id !== $entity
        ));
        $request->session()->put(self::SHORTLIST_SESSION_KEY, $ids);

        return back()->with('shortlist_status', 'Removed from your temporary shortlist.');
    }

    public function compare(
        Request $request,
        PublicDirectoryQueryService $directory,
        PublicDirectoryComparisonService $comparison
    ): View {
        $ids = $this->sessionShortlist($request);
        $profiles = array_values(array_filter(array_map(
            static fn (string $id): ?array => $directory->find($id),
            $ids
        )));
        $validIds = array_column($profiles, 'id');
        if ($validIds !== $ids) {
            $request->session()->put(self::SHORTLIST_SESSION_KEY, $validIds);
        }

        $types = array_values(array_unique(array_column($profiles, 'type')));
        abort_if(count($types) > 1, 409, 'Only like-for-like directory options can be compared.');

        $comparisonData = $comparison->compare($profiles);

        return view('directory.compare', [
            'profiles' => $profiles,
            'rows' => $comparisonData['rows'],
            'shortlistLimit' => (int) config('directory.shortlist_limit', 5),
        ]);
    }

    public function show(string $entity, PublicDirectoryQueryService $directory): View
    {
        $profile = $directory->find($entity);
        abort_if($profile === null, 404);

        $ids = request()->session()->get(self::SHORTLIST_SESSION_KEY, []);
        if (is_array($ids) === false) {
            $ids = [];
        }

        return view('directory.show', [
            'profile' => $profile,
            'shortlistCount' => count($ids),
            'shortlistLimit' => (int) config('directory.shortlist_limit', 5),
            'isShortlisted' => in_array($entity, $ids, true),
        ]);
    }

    /** @return array<int, string> */
    private function sessionShortlist(Request $request): array
    {
        $ids = $request->session()->get(self::SHORTLIST_SESSION_KEY, []);
        if (is_array($ids) === false) {
            return [];
        }

        return array_values(array_unique(array_filter(
            $ids,
            static fn (mixed $id): bool => is_string($id) && preg_match('/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/iD', $id) === 1
        )));
    }
}
