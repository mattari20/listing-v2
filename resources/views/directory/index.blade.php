<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Search publicly approved education provider and institution information.">
    <title>Education Directory</title>
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
        a:focus-visible, input:focus-visible, select:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; left: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
        .results { display: grid; gap: .75rem; margin-top: 1rem; }
        .meta, .notice { color: #4b5563; font-size: .94rem; }
        .facets { margin-top: 1rem; }
        .facets a { margin-right: .8rem; }
        @media (max-width: 42rem) { form { grid-template-columns: 1fr; } main { padding: .85rem; } }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<main id="main-content" tabindex="-1">
    <header>
        <h1>Education Directory</h1>
        <p>Find providers, institutions, campuses, programmes and qualifications using publicly approved information.</p>
    </header>

    <form method="get" action="{{ route('directory.index') }}">
        <div>
            <label for="q">Search by name or published detail</label>
            <input id="q" name="q" type="search" maxlength="120" value="{{ $query }}" autocomplete="off">
        </div>
        <div>
            <label for="type">Category</label>
            <select id="type" name="type">
                <option value="">All categories</option>
                @foreach ($typeOptions as $key => $label)
                    <option value="{{ $key }}" @selected($type === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="locality">Province, district, city or locality</label>
            <input id="locality" name="locality" type="search" maxlength="120" value="{{ $locality }}" autocomplete="off">
        </div>
        @foreach ($filterOptions as $key => $option)
            <div>
                <label for="filter-{{ $key }}">{{ $option['label'] }}</label>
                <select id="filter-{{ $key }}" name="filters[{{ $key }}]">
                    <option value="">All {{ strtolower($option['label']) }}</option>
                    @foreach ($option['values'] as $value)
                        <option value="{{ $value }}" @selected(($filters[$key] ?? null) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
        <button type="submit">Search</button>
    </form>

    @if ($facets !== [])
        <nav class="facets" aria-label="Available categories">
            <strong>Categories:</strong>
            @foreach ($facets as $key => $count)
                <a href="{{ route('directory.index', ['q' => $query, 'type' => $key, 'locality' => $locality, 'filters' => $filters]) }}">{{ $typeOptions[$key] ?? $key }} ({{ $count }})</a>
            @endforeach
        </nav>
    @endif

    <section class="results" aria-labelledby="results-heading">
        <h2 id="results-heading">Directory results</h2>
        @forelse ($results as $result)
            <article class="result">
                <h3><a href="{{ route('directory.show', ['entity' => $result['id']]) }}">{{ $result['name'] }}</a></h3>
                <p class="meta">{{ $result['type_label'] }}</p>
                @php($locationFacts = collect($result['facts'])->whereIn('key', ['province', 'district', 'city', 'locality']))
                @if ($locationFacts->isNotEmpty())
                    <p class="meta">{{ $locationFacts->pluck('value')->implode(', ') }}</p>
                @endif
                @php($overview = collect($result['facts'])->firstWhere('key', 'overview'))
                @if ($overview !== null)
                    <p dir="auto">{{ $overview['value'] }}</p>
                @endif
                @if ($result['last_observed_at'] !== null)
                    <p class="meta">Evidence observed: {{ $result['last_observed_at'] }}</p>
                @else
                    <p class="meta">Observation date not supplied; freshness is not assessed.</p>
                @endif
            </article>
        @empty
            <p>No publicly approved matches were found. Missing or unpublished information is not treated as a negative fact.</p>
        @endforelse
        {{ $results->links() }}
    </section>
    <footer>
        <p class="notice">Only current, approved anonymous-directory projections are shown. Locality search uses published text only; precise device location, distance sorting and maps are not enabled.</p>
    </footer>
</main>
</body>
</html>
