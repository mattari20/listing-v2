<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Compare selected education directory options using approved public information.">
    <title>Compare options — Education Directory</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.55; }
        main { max-width: 76rem; margin: 0 auto; padding: 1.25rem; }
        .panel, .empty { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1rem; }
        .table-wrap { overflow-x: auto; margin-top: 1rem; background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; }
        table { border-collapse: collapse; width: 100%; min-width: 42rem; }
        th, td { padding: .8rem; border-bottom: 1px solid #d9dee7; text-align: left; vertical-align: top; }
        th { background: #f1f4f8; }
        th:first-child { min-width: 10rem; }
        .meta { color: #4b5563; font-size: .92rem; }
        .state { font-weight: 600; }
        form { display: inline; }
        button { min-height: 2.5rem; padding: .45rem .7rem; border: 1px solid #667085; border-radius: .35rem; background: #fff; color: #172033; font: inherit; cursor: pointer; }
        a { color: #174ea6; }
        a:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; }
        .offers { display: grid; gap: .8rem; }
        .offer { border: 1px solid #d9dee7; border-radius: .4rem; padding: .7rem; }
    </style>
</head>
<body>
<main>
    <p><a href="{{ route('directory.index') }}">← Back to directory</a></p>
    <h1>Compare selected options</h1>
    <p class="meta">This temporary shortlist belongs only to your current browsing session. It is not saved to an account or shared with anyone.</p>
    @if (count($profiles) < 2)
        <section class="empty">
            <h2>Select at least two options</h2>
            <p>Add two or more options from the same category to compare their approved public information.</p>
            <a href="{{ route('directory.index') }}">Browse the directory</a>
        </section>
    @else
        <div class="table-wrap" role="region" aria-label="Side-by-side comparison" tabindex="0">
            <table>
                <thead><tr>
                    <th scope="col">Comparison detail</th>
                    @foreach ($profiles as $profile)
                        <th scope="col">
                            <a href="{{ route('directory.show', ['entity' => $profile['id']]) }}">{{ $profile['name'] }}</a>
                            <div class="meta">{{ $profile['type_label'] }}</div>
                            <form method="post" action="{{ route('directory.shortlist.remove', ['entity' => $profile['id']]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" aria-label="Remove {{ $profile['name'] }} from shortlist">Remove</button>
                            </form>
                        </th>
                    @endforeach
                </tr></thead>
                <tbody>
                    @forelse ($rows as $row)
                        <tr>
                            <th scope="row">{{ $row['label'] }}</th>
                            @foreach ($profiles as $profile)
                                @php($cell = $row['values'][$profile['id']])
                                <td>
                                    @if ($cell['state'] === 'not_stated')
                                        <span class="state">Not stated in approved public information</span>
                                    @else
                                        <span dir="auto">{{ $cell['value'] }}</span>
                                        @if ($cell['observed_at'] !== null)
                                            <div class="meta">Evidence observed: {{ $cell['observed_at'] }}; freshness is not independently assessed for this field.</div>
                                        @else
                                            <div class="meta">Observation date unavailable; freshness is not assessed.</div>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($profiles) + 1 }}">No comparable published details are currently available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (collect($profiles)->contains(fn (array $profile): bool => ($profile['programme_offers'] ?? []) !== []))
            <section class="panel" aria-labelledby="offer-comparison-heading" style="margin-top: 1rem">
                <h2 id="offer-comparison-heading">Programme offers and admission-cycle facts</h2>
                <p class="meta">Offers are shown separately for each programme. Different offer or cycle records are not merged into a like-for-like row.</p>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th scope="col">Programme</th><th scope="col">Published offers</th></tr></thead>
                        <tbody>
                            @foreach ($profiles as $profile)
                                <tr><th scope="row">{{ $profile['name'] }}</th><td>
                                    @if (($profile['programme_offers'] ?? []) === [])
                                        No approved offer facts are currently published.
                                    @else
                                        <div class="offers">
                                            @foreach ($profile['programme_offers'] as $offer)
                                                <section class="offer">
                                                    <strong>{{ $offer['admission_cycle'] }}</strong>
                                                    <div class="meta">{{ $offer['delivery_location'] }} ({{ $offer['delivery_location_type'] }})</div>
                                                    <ul>
                                                        @foreach ($offer['facts'] as $fact)
                                                            <li>
                                                                <strong>{{ $fact['label'] }}:</strong>
                                                                @if ($fact['state'] === 'unknown')
                                                                    Not verified
                                                                @elseif ($fact['state'] === 'not_stated')
                                                                    Not stated
                                                                @elseif ($fact['state'] === 'not_applicable')
                                                                    Not applicable
                                                                @elseif ($fact['state'] === 'conflicting')
                                                                    Conflicting information — not verified
                                                                @elseif ($fact['state'] === 'stale')
                                                                    Stale — verify before relying
                                                                    <span dir="auto">{{ is_array($fact['value']) ? json_encode($fact['value'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $fact['value'] }}</span>
                                                                @else
                                                                    <span dir="auto">{{ is_array($fact['value']) ? json_encode($fact['value'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $fact['value'] }}</span>
                                                                @endif
                                                                @if ($fact['observed_at'] !== null)
                                                                    <span class="meta">(observed {{ $fact['observed_at'] }})</span>
                                                                @endif
                                                                @if ($fact['valid_from'] !== null || $fact['valid_to'] !== null)
                                                                    <span class="meta">(effective {{ $fact['valid_from'] ?? 'not specified' }} to {{ $fact['valid_to'] ?? 'not specified' }})</span>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </section>
                                            @endforeach
                                        </div>
                                    @endif
                                </td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    @endif
    <p><a href="{{ route('directory.index') }}">Return to directory search</a></p>
</main>
</body>
</html>
