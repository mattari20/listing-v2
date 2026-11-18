<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Publicly approved education directory profile.">
    <title>{{ $profile['name'] }} — Education Directory</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.6; }
        main { max-width: 54rem; margin: 0 auto; padding: 1.25rem; }
        article { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1.25rem; }
        dl { display: grid; grid-template-columns: minmax(9rem, .35fr) minmax(0, 1fr); gap: .8rem 1rem; }
        dt { font-weight: 700; }
        dd { margin: 0; overflow-wrap: anywhere; }
        a { color: #174ea6; }
        a:focus-visible, input:focus-visible, select:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; left: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
        .meta { color: #4b5563; font-size: .94rem; }
        @media (max-width: 38rem) { dl { grid-template-columns: 1fr; gap: .2rem; } dd { margin-bottom: .8rem; } main { padding: .85rem; } }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<main id="main-content" tabindex="-1">
    <p><a href="{{ route('directory.index') }}">← Back to directory search</a></p>
    <article>
        <p class="meta">{{ $profile['type_label'] }}</p>
        <h1 dir="auto">{{ $profile['name'] }}</h1>
        @if ($profile['last_observed_at'] !== null)
            <p class="meta">Latest evidence observation: {{ $profile['last_observed_at'] }}</p>
        @else
            <p class="meta">Observation date not supplied; freshness is not assessed.</p>
        @endif

        <h2>Publicly approved information</h2>
        @if ($profile['facts'] === [])
            <p>No additional public details are available.</p>
        @else
            <dl>
                @foreach ($profile['facts'] as $fact)
                    <dt>{{ $fact['label'] }}</dt>
                    <dd dir="auto">
                        @if ($fact['is_external_url'])
                            <a href="{{ $fact['value'] }}" target="_blank" rel="noopener noreferrer">{{ $fact['value'] }}</a>
                        @else
                            {{ $fact['value'] }}
                        @endif
                        <div class="meta">
                            @if ($fact['observed_at'] !== null)
                                Evidence observed: {{ $fact['observed_at'] }}
                            @else
                                Observation date not supplied
                            @endif
                        </div>
                    </dd>
                @endforeach
            </dl>
        @endif

        @if (!empty($profile['catalogue']['campuses']) || !empty($profile['catalogue']['programmes']))
            <section aria-labelledby="campuses-heading">
                @if (!empty($profile['catalogue']['campuses']))
                    <h2 id="campuses-heading">Campuses</h2>
                    <ul>
                        @foreach ($profile['catalogue']['campuses'] as $campus)
                            <li>{{ $campus['name'] }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (!empty($profile['catalogue']['programmes']))
                    <h2 id="programmes-heading">Programmes and admission offers</h2>
                    @foreach ($profile['catalogue']['programmes'] as $programme)
                        <section>
                            <h3>{{ $programme['name'] }}</h3>
                            @if ($programme['offers'] !== [])
                                <ul>
                                    @foreach ($programme['offers'] as $offer)
                                        <li>{{ $offer['admission_cycle'] }} — {{ $offer['location'] }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No currently published admission offers are available.</p>
                            @endif
                        </section>
                    @endforeach
                @endif
            </section>
        @endif
    </article>
</main>
</body>
</html>
