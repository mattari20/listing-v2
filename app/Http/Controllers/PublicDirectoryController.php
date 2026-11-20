<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Directory\DirectorySeoMetadata;
use App\Services\Directory\PublicDirectoryComparisonService;
use App\Services\Directory\PublicDirectoryQueryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

final class PublicDirectoryController extends Controller
{
    private const SHORTLIST_SESSION_KEY = 'directory_shortlist';

    public function index(Request $request, PublicDirectoryQueryService $directory, DirectorySeoMetadata $seoMetadata): View
    {
        $locale = $this->applyDirectoryLocale($request);
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'type' => ['nullable', 'string', 'max:40'],
            'locality' => ['nullable', 'string', 'max:120'],
            'filters' => ['nullable', 'array', 'max:12'],
            'filters.*' => ['nullable', 'string', 'max:120'],
            'page' => ['nullable', 'integer', 'min:1'],
        ], [
            'q.max' => __('directory.validation_search_max'),
            'type.max' => __('directory.validation_category_max'),
            'locality.max' => __('directory.validation_locality_max'),
            'filters.max' => __('directory.validation_filters_max'),
            'filters.*.string' => __('directory.validation_filter_value'),
            'filters.*.max' => __('directory.validation_filter_value'),
            'page.integer' => __('directory.validation_page'),
            'page.min' => __('directory.validation_page'),
        ]);

        $query = trim((string) ($validated['q'] ?? ''));
        $type = ($validated['type'] ?? '') !== '' ? (string) $validated['type'] : null;
        $locality = trim((string) ($validated['locality'] ?? ''));
        $filterOptions = $directory->filterOptions();
        foreach ($filterOptions as $fieldKey => &$filterOption) {
            $translationKey = 'directory.fields.'.$fieldKey;
            $translatedLabel = __($translationKey);
            if ($translatedLabel !== $translationKey) {
                $filterOption['label'] = $translatedLabel;
            }
        }
        unset($filterOption);
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
            'filterGroupLabels' => [
                'Academic options' => __('directory.filter_groups.academic'),
                'Admissions' => __('directory.filter_groups.admissions'),
                'Institution details' => __('directory.filter_groups.institution'),
                'Additional approved filters' => __('directory.filter_groups.additional'),
            ],
            'typeOptions' => collect($directory->typeOptions())->mapWithKeys(
                static fn (string $label, string $key): array => [$key => __('directory.types.'.$key)]
            )->all(),
            'locale' => $locale,
            'seo' => $seoMetadata->forDirectoryLanding($request, $locale),
            'direction' => $locale === 'ur' ? 'rtl' : 'ltr',
            'languageUrls' => $this->directoryLanguageUrls($request),
            'facets' => $data['facets'],
            'results' => $results,
            'shortlistCount' => count($this->sessionShortlist($request)),
            'shortlistLimit' => (int) config('directory.shortlist_limit', 5),
            'savedEntityIds' => auth()->check()
                ? auth()->user()->savedDirectoryItems()->whereIn('entity_id', $results->getCollection()->pluck('id')->all())->pluck('entity_id')->all()
                : [],
        ]);
    }

    public function addToShortlist(Request $request, string $entity, PublicDirectoryQueryService $directory): RedirectResponse
    {
        $this->applyDirectoryLocale($request);
        $profile = $directory->find($entity);
        abort_if($profile === null, 404);

        $ids = $this->sessionShortlist($request);
        if (in_array($entity, $ids, true)) {
            return back()->with('shortlist_status', __('directory.shortlist_exists'));
        }

        $profiles = array_values(array_filter(array_map(
            static fn (string $id): ?array => $directory->find($id),
            $ids
        )));
        $ids = array_column($profiles, 'id');
        $request->session()->put(self::SHORTLIST_SESSION_KEY, $ids);
        foreach ($profiles as $selectedProfile) {
            if ($selectedProfile['type'] !== $profile['type']) {
                return back()->withErrors(['shortlist' => __('directory.shortlist_same_type')])->withInput();
            }
        }

        $limit = max(2, min(10, (int) config('directory.shortlist_limit', 5)));
        if (count($ids) >= $limit) {
            return back()->withErrors(['shortlist' => __('directory.shortlist_full')])->withInput();
        }

        $ids[] = $entity;
        $request->session()->put(self::SHORTLIST_SESSION_KEY, array_values(array_unique($ids)));

        return back()->with('shortlist_status', __('directory.shortlist_added'));
    }

    public function removeFromShortlist(Request $request, string $entity): RedirectResponse
    {
        $this->applyDirectoryLocale($request);
        $ids = array_values(array_filter(
            $this->sessionShortlist($request),
            static fn (string $id): bool => $id !== $entity
        ));
        $request->session()->put(self::SHORTLIST_SESSION_KEY, $ids);

        return back()->with('shortlist_status', __('directory.shortlist_removed'));
    }

    public function compare(
        Request $request,
        PublicDirectoryQueryService $directory,
        PublicDirectoryComparisonService $comparison,
        DirectorySeoMetadata $seoMetadata
    ): View {
        $locale = $this->applyDirectoryLocale($request);
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
            'seo' => $seoMetadata->forComparison(),
            'rows' => $comparisonData['rows'],
            'shortlistLimit' => (int) config('directory.shortlist_limit', 5),
            'locale' => $locale,
            'direction' => $locale === 'ur' ? 'rtl' : 'ltr',
            'languageUrls' => $this->directoryLanguageUrls($request),
        ]);
    }

    public function show(Request $request, string $entity, PublicDirectoryQueryService $directory, DirectorySeoMetadata $seoMetadata): View
    {
        $locale = $this->applyDirectoryLocale($request);
        $profile = $directory->find($entity);
        abort_if($profile === null, 404);

        $ids = $request->session()->get(self::SHORTLIST_SESSION_KEY, []);
        if (is_array($ids) === false) {
            $ids = [];
        }

        return view('directory.show', [
            'profile' => $profile,
            'seo' => $seoMetadata->forProfile($request, $entity, $locale),
            'shortlistCount' => count($ids),
            'shortlistLimit' => (int) config('directory.shortlist_limit', 5),
            'isShortlisted' => in_array($entity, $ids, true),
            'isSavedItem' => auth()->check() && auth()->user()->savedDirectoryItems()->where('entity_id', $entity)->exists(),
            'locale' => $locale,
            'direction' => $locale === 'ur' ? 'rtl' : 'ltr',
            'languageUrls' => $this->directoryLanguageUrls($request),
        ]);
    }

    /** @return array{en: string, ur: string} */
    private function directoryLanguageUrls(Request $request): array
    {
        $urls = [];
        foreach (['en', 'ur'] as $locale) {
            $query = $request->query();
            $query['lang'] = $locale;
            $queryString = http_build_query($query);
            $urls[$locale] = $request->getPathInfo().($queryString === '' ? '' : '?'.$queryString);
        }

        return $urls;
    }

    private function applyDirectoryLocale(Request $request): string
    {
        if ($request->exists('lang')) {
            $requested = $request->input('lang');
            $locale = is_string($requested) && in_array($requested, ['en', 'ur'], true) ? $requested : 'en';
        } else {
            $stored = $request->session()->get('directory_locale', 'en');
            $locale = in_array($stored, ['en', 'ur'], true) ? $stored : 'en';
        }

        $request->session()->put('directory_locale', $locale);
        App::setLocale($locale);

        return $locale;
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
