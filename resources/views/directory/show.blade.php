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
        @if (($profile['programme_offers'] ?? []) !== [])
            <section aria-labelledby="admissions-heading">
                <h2 id="admissions-heading">Programme admissions information</h2>
                @foreach ($profile['programme_offers'] as $offer)
                    <section aria-labelledby="offer-{{ $loop->index }}-heading">
                        <h3 id="offer-{{ $loop->index }}-heading">{{ $offer['admission_cycle'] }}</h3>
                        <p class="meta">Delivery location: {{ $offer['delivery_location'] }}</p>
                        <dl>
                            @foreach ($offer['facts'] as $offerFact)
                                <dt>{{ $offerFact['label'] }}</dt>
                                <dd dir="auto">
                                    @if ($offerFact['state'] === 'unknown')
                                        Not verified
                                    @elseif ($offerFact['state'] === 'not_stated')
                                        Not stated
                                    @elseif ($offerFact['state'] === 'not_applicable')
                                        Not applicable
                                    @elseif ($offerFact['state'] === 'conflicting')
                                        Conflicting information — not verified
                                    @elseif ($offerFact['state'] === 'stale')
                                        <strong>Stale — verify before relying:</strong>
                                        @if ($offerFact['category'] === 'deadline')
                                            {{ $offerFact['value']['date'] ?? 'Date unavailable' }}
                                        @elseif ($offerFact['category'] === 'fee')
                                            {{ $offerFact['value']['component'] }}:
                                            {{ $offerFact['value']['amount'] }} {{ $offerFact['value']['currency'] }}
                                        @else
                                            {{ $offerFact['value']['text'] ?? 'Information unavailable' }}
                                        @endif
                                    @elseif ($offerFact['category'] === 'deadline')
                                        {{ $offerFact['value']['date'] ?? 'Date unavailable' }}
                                    @elseif ($offerFact['category'] === 'fee')
                                        {{ $offerFact['value']['component'] }}:
                                        {{ $offerFact['value']['amount'] }} {{ $offerFact['value']['currency'] }}
                                    @else
                                        {{ $offerFact['value']['text'] ?? 'Information unavailable' }}
                                    @endif
                                    @if ($offerFact['observed_at'] !== null)
                                        <div class="meta">Evidence observed: {{ $offerFact['observed_at'] }}</div>
                                    @endif
                                </dd>
                            @endforeach
                        </dl>
                    </section>
                @endforeach
            </section>
        @endif
    </article>
</main>
</body>
</html>
