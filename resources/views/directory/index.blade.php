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
        form { display: grid; grid-template-columns: minmax(0, 1fr) minmax(10rem, .45fr) auto; gap: .75rem; align-items: end; }
        label { display: block; font-weight: 600; margin-bottom: .25rem; }
        input, select, button { width: 100%; min-height: 2.75rem; padding: .55rem; border: 1px solid #8b95a5; border-radius: .35rem; font: inherit; }
        button { cursor: pointer; background: #172033; color: #fff; border-color: #172033; }
        a { color: #174ea6; }
        .results { display: grid; gap: .75rem; margin-top: 1rem; }
        .meta, .notice { color: #4b5563; font-size: .94rem; }
        .facets { margin-top: 1rem; }
        .facets a { margin-right: .8rem; }
        @media (max-width: 42rem) { form { grid-template-columns: 1fr; } main { padding: .85rem; } }
    </style>
</head>
<body>
<main>
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
        <button type="submit">Search</button>
    </form>

    @if ($facets !== [])
        <nav class="facets" aria-label="Available categories">
            <strong>Categories:</strong>
            @foreach ($facets as $key => $count)
                <a href="{{ route('directory.index', ['q' => $query, 'type' => $key]) }}">{{ $typeOptions[$key] ?? $key }} ({{ $count }})</a>
            @endforeach
        </nav>
    @endif

    <section class="results" aria-labelledby="results-heading">
        <h2 id="results-heading">Directory results</h2>
        @forelse ($results as $result)
            <article class="result">
                <h3><a href="{{ route('directory.show', ['entity' => $result['id']]) }}">{{ $result['name'] }}</a></h3>
                <p class="meta">{{ $result['type_label'] }}</p>
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
        <p class="notice">Only current, approved anonymous-directory projections are shown. Map and location-based discovery are not part of this directory view.</p>
    </footer>
</main>
</body>
</html>
