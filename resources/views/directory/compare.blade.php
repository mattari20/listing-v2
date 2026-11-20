<!doctype html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('directory.meta_compare') }}">
    <title>{{ __('directory.compare_heading') }} — {{ __('directory.directory_title') }}</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.55; }
        main { max-width: 76rem; margin: 0 auto; padding: 1.25rem; }
        .panel, .empty { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1rem; }
        .table-wrap { overflow-x: auto; margin-top: 1rem; background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; }
        table { border-collapse: collapse; width: 100%; min-width: 42rem; }
        th, td { padding: .8rem; border-bottom: 1px solid #d9dee7; text-align: start; vertical-align: top; }
        th { background: #f1f4f8; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; inset-inline-start: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
        th:first-child { min-width: 10rem; }
        .meta { color: #4b5563; font-size: .92rem; }
        .state { font-weight: 600; }
        form { display: inline; }
        button { min-height: 2.5rem; padding: .45rem .7rem; border: 1px solid #667085; border-radius: .35rem; background: #fff; color: #172033; font: inherit; cursor: pointer; }
        a { color: #174ea6; }
        a:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; scroll-margin-block: 1rem; }
        button:disabled { opacity: 1; background: #e5e7eb; color: #374151; border-color: #667085; cursor: not-allowed; }
        .language-switch { margin-block-end: .75rem; }
        .offers { display: grid; gap: .8rem; }
        .offer { border: 1px solid #d9dee7; border-radius: .4rem; padding: .7rem; }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">{{ __('directory.skip') }}</a>
<main id="main-content" tabindex="-1">
    <nav class="language-switch" aria-label="{{ __('directory.language') }}">
        <span>{{ __('directory.language') }}:</span>
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" @if ($locale === 'en') aria-current="page" @endif>{{ __('directory.english') }}</a>
        <span aria-hidden="true">|</span>
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'ur']) }}" @if ($locale === 'ur') aria-current="page" @endif>{{ __('directory.urdu') }}</a>
    </nav>
    <p><a href="{{ route('directory.index', ['lang' => $locale]) }}">← {{ __('directory.back_directory') }}</a></p>
    <h1>{{ __('directory.compare_heading') }}</h1>
    <p class="meta">{{ __('directory.temporary_notice') }}</p>
    @if (count($profiles) < 2)
        <section class="empty">
            <h2>{{ __('directory.select_two') }}</h2>
            <p>{{ __('directory.add_two') }}</p>
            <a href="{{ route('directory.index', ['lang' => $locale]) }}">{{ __('directory.browse_directory') }}</a>
        </section>
    @else
        <div class="table-wrap" role="region" aria-label="{{ __('directory.comparison_region') }}" tabindex="0">
            <table>
                <thead><tr>
                    <th scope="col">{{ __('directory.comparison_detail') }}</th>
                    @foreach ($profiles as $profile)
                        <th scope="col">
                            <a href="{{ route('directory.show', ['entity' => $profile['id'], 'lang' => $locale]) }}" dir="auto">{{ $profile['name'] }}</a>
                            <div class="meta">{{ __('directory.types.'.$profile['type']) }}</div>
                            <form method="post" action="{{ route('directory.shortlist.remove', ['entity' => $profile['id']]) }}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="lang" value="{{ $locale }}">
                                <button type="submit" aria-label="{{ __('directory.remove_named', ['name' => $profile['name']]) }}">{{ __('directory.remove') }}</button>
                            </form>
                        </th>
                    @endforeach
                </tr></thead>
                <tbody>
                    @forelse ($rows as $row)
                        <tr>
                            <th scope="row" dir="auto">{{ $row['label'] }}</th>
                            @foreach ($profiles as $profile)
                                @php($cell = $row['values'][$profile['id']])
                                <td>
                                    @if ($cell['state'] === 'not_stated')
                                        <span class="state">{{ __('directory.not_stated_public') }}</span>
                                    @else
                                        <span dir="auto">{{ $cell['value'] }}</span>
                                        @if ($cell['observed_at'] !== null)
                                            <div class="meta">{{ __('directory.observed', ['date' => $cell['observed_at']]) }}; {{ __('directory.freshness_note') }}</div>
                                        @else
                                            <div class="meta">{{ __('directory.observation_unavailable') }}</div>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($profiles) + 1 }}">{{ __('directory.no_comparable') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (collect($profiles)->contains(fn (array $profile): bool => ($profile['programme_offers'] ?? []) !== []))
            <section class="panel" aria-labelledby="offer-comparison-heading" style="margin-top: 1rem">
                <h2 id="offer-comparison-heading">{{ __('directory.programme_offers') }}</h2>
                <p class="meta">{{ __('directory.offers_explainer') }}</p>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th scope="col">{{ __('directory.programme') }}</th><th scope="col">{{ __('directory.published_offers') }}</th></tr></thead>
                        <tbody>
                            @foreach ($profiles as $profile)
                                <tr><th scope="row" dir="auto">{{ $profile['name'] }}</th><td>
                                    @if (($profile['programme_offers'] ?? []) === [])
                                        {{ __('directory.no_offers') }}
                                    @else
                                        <div class="offers">
                                            @foreach ($profile['programme_offers'] as $offer)
                                                <section class="offer">
                                                    <strong dir="auto">{{ $offer['admission_cycle'] }}</strong>
                                                    <div class="meta">{{ $offer['delivery_location_type'] === 'Campus' ? __('directory.delivery_locations.campus') : __('directory.delivery_locations.delivery_site') }}</div>
                                                    <ul>
                                                        @foreach ($offer['facts'] as $fact)
                                                            <li>
                                                                <strong dir="auto">{{ $fact['label'] }}:</strong>
                                                                @if ($fact['state'] === 'unknown')
                                                                    {{ __('directory.unknown') }}
                                                                @elseif ($fact['state'] === 'not_stated')
                                                                    {{ __('directory.not_stated') }}
                                                                @elseif ($fact['state'] === 'not_applicable')
                                                                    {{ __('directory.not_applicable') }}
                                                                @elseif ($fact['state'] === 'conflicting')
                                                                    {{ __('directory.conflicting') }}
                                                                @elseif ($fact['state'] === 'stale')
                                                                    {{ __('directory.stale') }}
                                                                    <span dir="auto">{{ is_array($fact['value']) ? json_encode($fact['value'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $fact['value'] }}</span>
                                                                @else
                                                                    <span dir="auto">{{ is_array($fact['value']) ? json_encode($fact['value'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $fact['value'] }}</span>
                                                                @endif
                                                                @if ($fact['observed_at'] !== null)
                                                                    <span class="meta">({{ __('directory.evidence_observed', ['date' => $fact['observed_at']]) }})</span>
                                                                @endif
                                                                @if ($fact['valid_from'] !== null || $fact['valid_to'] !== null)
                                                                    <span class="meta">({{ __('directory.effective_period', ['from' => $fact['valid_from'] ?? __('directory.not_specified'), 'to' => $fact['valid_to'] ?? __('directory.not_specified')]) }})</span>
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
    <p><a href="{{ route('directory.index', ['lang' => $locale]) }}">{{ __('directory.return_search') }}</a></p>
</main>
</body>
</html>
