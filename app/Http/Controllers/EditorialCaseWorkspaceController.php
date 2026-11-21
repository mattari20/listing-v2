<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Authorization\ScopedAuthorization;
use App\Models\RoleAssignment;
use App\Models\User;
use App\Services\Directory\AdministrationWorkspaceQueryService;
use App\Services\Directory\UniversityRepresentativeWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

final class EditorialCaseWorkspaceController extends Controller
{
    public function show(
        Request $request,
        string $institution,
        string $case,
        ScopedAuthorization $authorization,
        UniversityRepresentativeWorkflowService $workflow,
        AdministrationWorkspaceQueryService $workspace,
    ): Response {
        $user = $request->user();
        abort_unless($user instanceof User && $user->is_active && $user->email_verified_at !== null, 403);
        abort_unless($workflow->isUniversityInstitution($institution), 404);

        $assignment = RoleAssignment::query()
            ->where('user_id', $user->getKey())
            ->where('role', 'data_reviewer')
            ->where('scope_type', 'institution')
            ->where('scope_id', $institution)
            ->whereNull('revoked_at')
            ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->exists();

        abort_unless($assignment && $authorization->allows($user, 'claim.review', 'institution', $institution), 403);
        abort_unless($workflow->editorialCaseBelongsToInstitution($case, $institution), 404);

        $actorId = 'user:'.$user->getKey();
        $details = $workspace->editorialCaseDetails($case, $actorId);
        abort_unless($details !== null, 404);

        $requestedLocale = $request->query('lang', $request->session()->get('directory_locale', 'en'));
        $locale = is_string($requestedLocale) && in_array($requestedLocale, ['en', 'ur'], true) ? $requestedLocale : 'en';
        $request->session()->put('directory_locale', $locale);
        App::setLocale($locale);

        return response()->view('workspace.case', [
            'locale' => $locale,
            'direction' => $locale === 'ur' ? 'rtl' : 'ltr',
            'institution' => $institution,
            'case' => $details,
        ])->header('Cache-Control', 'private, no-store, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
