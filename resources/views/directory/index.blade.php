<!doctype html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('directory.meta_directory') }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    @if ($seo['canonical'] !== null)
        <link rel="canonical" href="{{ $seo['canonical'] }}">
        @foreach ($seo['alternates'] as $language => $alternateUrl)
            <link rel="alternate" hreflang="{{ $language }}" href="{{ $alternateUrl }}">
        @endforeach
    @endif
    <title>{{ __('directory.directory_title') }}</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.55; }
        main { max-width: 58rem; margin: 0 auto; padding: 1.25rem; }
        h1, h2 { line-height: 1.2; }
        form, .result, .facets { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1rem; }
        form { display: grid; grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr)); gap: .75rem; align-items: end; }
        label { display: block; font-weight: 600; margin-bottom: .25rem; }
        input, select, button { width: 100%; min-height: 2.75rem; padding: .55rem; border: 1px solid #8b95a5; border-radius: .35rem; font: inherit; }
        button { cursor: pointer; background: #172033; color: #fff; border-color: #172033; }
        a { color: #174ea6; }
        a:focus-visible, input:focus-visible, select:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; scroll-margin-block: 1rem; }
        button:disabled { opacity: 1; background: #e5e7eb; color: #374151; border-color: #667085; cursor: not-allowed; }
        .language-switch { margin-block-end: .75rem; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; inset-inline-start: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
        .results { display: grid; gap: .75rem; margin-top: 1rem; }
        .meta, .notice { color: #4b5563; font-size: .94rem; }
        .facets { margin-top: 1rem; }
        .facets a { margin-inline-end: .8rem; }
        fieldset { border: 1px solid #d9dee7; border-radius: .5rem; padding: .75rem; min-width: 0; }
        .filter-help { color: #4b5563; font-size: .92rem; margin: .25rem 0 .6rem; }
        .study-facts { margin: .55rem 0; padding-inline-start: 1.2rem; }
        .empty-guidance { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1rem; }
        legend { font-weight: 700; padding: 0 .3rem; }
        .active-filters { margin: .8rem 0; padding: .75rem; background: #eef3fa; border-radius: .5rem; }
        .active-filters span { display: inline-block; margin: .2rem .45rem .2rem 0; }
        @media (max-width: 42rem) { form { grid-template-columns: 1fr; } main { padding: .85rem; } }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">{{ __('directory.skip') }}</a>
<main id="main-content" tabindex="-1">
    <header>
        <nav class="language-switch" aria-label="{{ __('directory.language') }}">
            <span>{{ __('directory.language') }}:</span>
            <a href="{{ $languageUrls['en'] }}" @if ($locale === 'en') aria-current="page" @endif>{{ __('directory.english') }}</a>
            <span aria-hidden="true">|</span>
            <a href="{{ $languageUrls['ur'] }}" @if ($locale === 'ur') aria-current="page" @endif>{{ __('directory.urdu') }}</a>
        </nav>
        <h1>{{ __('directory.directory_title') }}</h1>
        <p>{{ __('directory.directory_intro') }}</p>
        <p><a href="/directory/compare?lang={{ $locale }}">{{ __('directory.compare_shortlist', ['count' => $shortlistCount, 'limit' => $shortlistLimit]) }}</a></p>
        @auth
            <p><a href="{{ route('account.saved-items.index', ['lang' => $locale]) }}">{{ __('directory.saved_items_title') }}</a></p>
        @endauth
        @if (session('saved_items_status'))<p role="status">{{ session('saved_items_status') }}</p>@endif
        @if (session('shortlist_status'))<p role="status">{{ session('shortlist_status') }}</p>@endif
        @if ($errors->any())
            <div role="alert" aria-labelledby="search-errors-heading">
                <h2 id="search-errors-heading">{{ __('directory.validation_summary') }}</h2>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
    </header>

    <form method="get" action="{{ route('directory.index') }}">
        <input type="hidden" name="lang" value="{{ $locale }}">
        <div>
            <label for="q">{{ __('directory.search_label') }}</label>
            <input id="q" name="q" type="search" dir="auto" maxlength="120" value="{{ $query }}" autocomplete="off">
        </div>
        <div>
            <label for="type">{{ __('directory.category') }}</label>
            <select id="type" name="type">
                <option value="">{{ __('directory.all_categories') }}</option>
                @foreach ($typeOptions as $key => $label)
                    <option value="{{ $key }}" @selected($type === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="locality">{{ __('directory.locality_label') }}</label>
            <input id="locality" name="locality" type="search" dir="auto" maxlength="120" value="{{ $locality }}" autocomplete="off">
        </div>
        @foreach ($filterGroups as $groupLabel => $groupOptions)
            <fieldset>
                <legend>{{ $filterGroupLabels[$groupLabel] ?? $groupLabel }}</legend>
                <p class="filter-help">{{ __('directory.filter_help') }}</p>
                @foreach ($groupOptions as $key => $option)
                    <div>
                        <label for="filter-{{ $key }}">{{ $option['label'] }}</label>
                        <select id="filter-{{ $key }}" name="filters[{{ $key }}]">
                            <option value="">{{ __('directory.all_values', ['label' => mb_strtolower($option['label'])]) }}</option>
                            @foreach ($option['values'] as $value)
                                <option value="{{ $value }}" dir="auto" @selected(($filters[$key] ?? null) === $value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </fieldset>
        @endforeach
        <button type="submit">{{ __('directory.search') }}</button>
    </form>

    @if ($query !== '' || $type !== null || $locality !== '' || $filters !== [])
        <section class="active-filters" aria-label="{{ __('directory.active_search') }}" aria-live="polite">
            <strong>{{ __('directory.active_search') }}</strong>
            @if ($query !== '')<span>{{ __('directory.words', ['value' => $query]) }}</span>@endif
            @if ($type !== null)<span>{{ __('directory.category_value', ['value' => $typeOptions[$type] ?? $type]) }}</span>@endif
            @if ($locality !== '')<span>{{ __('directory.location', ['value' => $locality]) }}</span>@endif
            @foreach ($filters as $key => $value)
                <span>{{ $filterOptions[$key]['label'] ?? $key }}: {{ $value }}</span>
            @endforeach
            <a href="/directory?lang={{ $locale }}">{{ __('directory.clear_all') }}</a>
        </section>
    @endif

    @if ($facets !== [])
        <nav class="facets" aria-label="{{ __('directory.categories') }}">
            <strong>{{ __('directory.categories') }}</strong> <span class="meta">{{ __('directory.facet_note') }}</span>
            @foreach ($facets as $key => $count)
                <a href="/directory?{{ http_build_query(['q' => $query, 'type' => $key, 'locality' => $locality, 'filters' => $filters, 'lang' => $locale]) }}">{{ $typeOptions[$key] ?? $key }} ({{ $count }})</a>
            @endforeach
        </nav>
    @endif

    <section class="results" aria-labelledby="results-heading">
        <h2 id="results-heading">{{ __('directory.results_heading') }}</h2>
        @forelse ($results as $result)
            <article class="result">
                <h3><a href="/directory/{{ $result['id'] }}?lang={{ $locale }}" dir="auto">{{ $result['name'] }}</a></h3>
                <p class="meta">{{ $typeOptions[$result['type']] ?? $result['type_label'] }}</p>
                @php($locationFacts = collect($result['facts'])->whereIn('key', ['province', 'district', 'city', 'locality']))
                @if ($locationFacts->isNotEmpty())
                    <p class="meta" dir="auto">{{ $locationFacts->pluck('value')->implode(', ') }}</p>
                @endif
                @php($studyFacts = collect($result['facts'])->filter(fn (array $fact): bool => in_array($fact['key'], ['education_level', 'programme_title', 'programme_level', 'institution_subject', 'subject', 'qualification_title', 'qualification_level', 'admission_status', 'admission_cycle'], true)))
                @if ($studyFacts->isNotEmpty())
                    <ul class="study-facts" aria-label="{{ __('directory.study_options') }}">
                        @foreach ($studyFacts as $studyFact)
                            <li dir="auto"><strong>{{ $studyFact['label'] }}:</strong> {{ $studyFact['value'] }}</li>
                        @endforeach
                    </ul>
                @endif
                @php($overview = collect($result['facts'])->firstWhere('key', 'overview'))
                @if ($overview !== null)
                    <p dir="auto">{{ $overview['value'] }}</p>
                @endif
                <form method="post" action="{{ route('directory.shortlist.add', ['entity' => $result['id']]) }}">
                    @csrf
                    <input type="hidden" name="lang" value="{{ $locale }}">
                    <button type="submit" @disabled($shortlistCount >= $shortlistLimit)>{{ __('directory.add_shortlist') }}</button>
                </form>
                @auth
                    @if (in_array($result['id'], $savedEntityIds, true))
                        <p role="status">{{ __('directory.saved_in_account') }}</p>
                    @else
                        <form method="post" action="{{ route('account.saved-items.store', ['entity' => $result['id']]) }}">
                            @csrf
                            <input type="hidden" name="lang" value="{{ $locale }}">
                            <button type="submit">{{ __('directory.save_to_account') }}</button>
                        </form>
                    @endif
                @endauth
                @if ($result['last_observed_at'] !== null)
                    <p class="meta">{{ __('directory.observed', ['date' => $result['last_observed_at']]) }}</p>
                @else
                    <p class="meta">{{ __('directory.observation_missing') }}</p>
                @endif
            </article>
        @empty
            <div class="empty-guidance" role="status">
                <p>{{ __('directory.no_matches') }}</p>
                <p>{{ __('directory.no_matches_guidance') }}</p>
                <p><a href="/directory?{{ http_build_query(array_filter(['q' => $query !== '' ? $query : null, 'lang' => $locale])) }}">{{ __('directory.broaden_search') }}</a></p>
                <p><a href="/directory?lang={{ $locale }}">{{ __('directory.clear_all') }}</a></p>
            </div>
        @endforelse
        {{ $results->links() }}
    </section>
    <footer>
        <p class="notice">{{ __('directory.search_limits') }}</p>
    </footer>
</main>
</body>
</html>
