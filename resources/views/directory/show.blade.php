<!doctype html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('directory.meta_profile') }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    @if ($seo['canonical'] !== null)
        <link rel="canonical" href="{{ $seo['canonical'] }}">
        @foreach ($seo['alternates'] as $language => $alternateUrl)
            <link rel="alternate" hreflang="{{ $language }}" href="{{ $alternateUrl }}">
        @endforeach
    @endif
    <title>{{ $profile['name'] }} — {{ __('directory.directory_title') }}</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.6; }
        main { max-width: 54rem; margin: 0 auto; padding: 1.25rem; }
        article { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1.25rem; }
        dl { display: grid; grid-template-columns: minmax(9rem, .35fr) minmax(0, 1fr); gap: .8rem 1rem; }
        dt { font-weight: 700; }
        dd { margin: 0; overflow-wrap: anywhere; }
        a { color: #174ea6; }
        a:focus-visible, input:focus-visible, select:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; scroll-margin-block: 1rem; }
        button:disabled { opacity: 1; background: #e5e7eb; color: #374151; border-color: #667085; cursor: not-allowed; }
        .language-switch { margin-block-end: .75rem; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; inset-inline-start: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
        .meta { color: #4b5563; font-size: .94rem; }
        @media (max-width: 38rem) { dl { grid-template-columns: 1fr; gap: .2rem; } dd { margin-bottom: .8rem; } main { padding: .85rem; } }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">{{ __('directory.skip') }}</a>
<main id="main-content" tabindex="-1">
    <nav class="language-switch" aria-label="{{ __('directory.language') }}">
        <span>{{ __('directory.language') }}:</span>
        <a href="{{ $languageUrls['en'] }}" @if ($locale === 'en') aria-current="page" @endif>{{ __('directory.english') }}</a>
        <span aria-hidden="true">|</span>
        <a href="{{ $languageUrls['ur'] }}" @if ($locale === 'ur') aria-current="page" @endif>{{ __('directory.urdu') }}</a>
    </nav>
    <p><a href="/directory?lang={{ $locale }}">← {{ __('directory.back_search') }}</a></p>
    <p><a href="/directory/compare?lang={{ $locale }}">{{ __('directory.compare_shortlist', ['count' => $shortlistCount, 'limit' => $shortlistLimit]) }}</a></p>
    @auth
        <p><a href="{{ route('account.saved-items.index', ['lang' => $locale]) }}">{{ __('directory.saved_items_title') }}</a></p>
    @endauth
    @if ($isShortlisted)
        <form method="post" action="{{ route('directory.shortlist.remove', ['entity' => $profile['id']]) }}">@csrf @method('delete')<input type="hidden" name="lang" value="{{ $locale }}"><button type="submit">{{ __('directory.remove_shortlist') }}</button></form>
    @else
        <form method="post" action="{{ route('directory.shortlist.add', ['entity' => $profile['id']]) }}">@csrf<input type="hidden" name="lang" value="{{ $locale }}"><button type="submit" @disabled($shortlistCount >= $shortlistLimit)>{{ __('directory.add_shortlist') }}</button></form>
    @endif
    @auth
        @if ($isSavedItem)
            <p role="status">{{ __('directory.saved_in_account') }}</p>
        @else
            <form method="post" action="{{ route('account.saved-items.store', ['entity' => $profile['id']]) }}">
                @csrf
                <input type="hidden" name="lang" value="{{ $locale }}">
                <button type="submit">{{ __('directory.save_to_account') }}</button>
            </form>
        @endif
    @endauth
    @if (session('saved_items_status'))<p role="status">{{ session('saved_items_status') }}</p>@endif
    @if (session('shortlist_status'))<p role="status">{{ session('shortlist_status') }}</p>@endif
    @if ($errors->has('shortlist'))<p role="alert">{{ $errors->first('shortlist') }}</p>@endif
    <article>
        <p class="meta">{{ __('directory.types.'.$profile['type']) }}</p>
        <h1 dir="auto">{{ $profile['name'] }}</h1>
        @if ($profile['last_observed_at'] !== null)
            <p class="meta">{{ __('directory.latest_observation', ['date' => $profile['last_observed_at']]) }}</p>
        @else
            <p class="meta">{{ __('directory.observation_missing') }}</p>
        @endif
        <p class="meta" role="note">{{ __('directory.observation_is_not_verification') }}</p>

        <h2>{{ __('directory.public_info') }}</h2>
        @if ($profile['facts'] === [] && ($profile['type'] ?? null) !== 'programme')
            <p>{{ __('directory.no_details') }}</p>
        @elseif (($profile['type'] ?? null) === 'programme')
            @php
                $programmeSectionLabels = [
                    'identity' => __('directory.profile_sections.identity'),
                    'academic' => __('directory.profile_sections.academic'),
                    'admissions' => __('directory.profile_sections.admissions'),
                    'fees' => __('directory.profile_sections.fees'),
                    'financial_aid' => __('directory.profile_sections.financial_aid'),
                    'recognition' => __('directory.profile_sections.recognition'),
                    'additional_information' => __('directory.profile_sections.additional_information'),
                ];
                $programmeFactGroups = collect($profile['facts'])->groupBy(
                    fn (array $fact): string => array_key_exists($fact['section'] ?? '', $programmeSectionLabels)
                        ? $fact['section']
                        : 'additional_information'
                );
            @endphp
            @foreach ($programmeSectionLabels as $sectionKey => $sectionLabel)
                <section aria-labelledby="programme-section-{{ $sectionKey }}">
                    <h3 id="programme-section-{{ $sectionKey }}">{{ $sectionLabel }}</h3>
                    @if ($programmeFactGroups->has($sectionKey))
                        <dl>
                            @foreach ($programmeFactGroups->get($sectionKey) as $fact)
                                <dt dir="auto">{{ $fact['label'] }}</dt>
                                <dd dir="auto">
                                    @if ($fact['is_external_url'])
                                        <a href="{{ $fact['value'] }}" target="_blank" rel="noopener noreferrer">{{ $fact['value'] }}</a>
                                    @else
                                        {{ $fact['value'] }}
                                    @endif
                                    <div class="meta">
                                        @if ($fact['observed_at'] !== null)
                                            {{ __('directory.evidence_observed', ['date' => $fact['observed_at']]) }}
                                        @else
                                            {{ __('directory.observation_not_supplied') }}
                                        @endif
                                    </div>
                                </dd>
                            @endforeach
                        </dl>
                    @else
                        <p class="meta">{{ __('directory.programme_section_no_approved_details') }}</p>
                    @endif
                </section>
            @endforeach
            <p class="meta" role="note">{{ __('directory.programme_profile_sections_note') }}</p>
        @else
            <dl>
                @foreach ($profile['facts'] as $fact)
                    <dt dir="auto">{{ $fact['label'] }}</dt>
                    <dd dir="auto">
                        @if ($fact['is_external_url'])
                            <a href="{{ $fact['value'] }}" target="_blank" rel="noopener noreferrer">{{ $fact['value'] }}</a>
                        @else
                            {{ $fact['value'] }}
                        @endif
                        <div class="meta">
                            @if ($fact['observed_at'] !== null)
                                {{ __('directory.evidence_observed', ['date' => $fact['observed_at']]) }}
                            @else
                                {{ __('directory.observation_not_supplied') }}
                            @endif
                        </div>
                    </dd>
                @endforeach
            </dl>
        @endif
        @if (($profile['type'] ?? null) === 'programme' && !empty($profile['programme_catalogue']))
            <section aria-labelledby="programme-details-heading">
                <h2 id="programme-details-heading">{{ __('directory.programme_details_heading') }}</h2>
                @if ($profile['programme_catalogue']['level'] !== null)
                    <p><strong>{{ __('directory.programme_level_label') }}:</strong> {{ $profile['programme_catalogue']['level'] }}</p>
                @endif
                @if ($profile['programme_catalogue']['description'] !== null)
                    <p dir="auto">{{ $profile['programme_catalogue']['description'] }}</p>
                @endif
                <p>
                    <strong>{{ __('directory.institution_label') }}:</strong>
                    <a href="{{ route('directory.show', ['entity' => $profile['programme_catalogue']['institution_entity_id'], 'lang' => $locale]) }}" dir="auto">{{ $profile['programme_catalogue']['institution_name'] }}</a>
                </p>
                @if ($profile['programme_catalogue']['offers'] !== [])
                    <h3>{{ __('directory.admission_offers_heading') }}</h3>
                    <ul>
                        @foreach ($profile['programme_catalogue']['offers'] as $catalogueOffer)
                            <li dir="auto">{{ $catalogueOffer['admission_cycle'] }} — <a href="{{ route('directory.show', ['entity' => $catalogueOffer['location_entity_id'], 'lang' => $locale]) }}">{{ $catalogueOffer['location'] }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </section>
        @endif

        @if (!empty($profile['catalogue']['campuses']) || !empty($profile['catalogue']['delivery_sites']) || !empty($profile['catalogue']['programmes']))
            <section aria-labelledby="campuses-heading">
                @if (!empty($profile['catalogue']['campuses']))
                    <h2 id="campuses-heading">{{ __('directory.campuses_heading') }}</h2>
                    <ul>
                        @foreach ($profile['catalogue']['campuses'] as $campus)
                            <li dir="auto">
                                <a href="{{ route('directory.show', ['entity' => $campus['id'], 'lang' => $locale]) }}">{{ $campus['name'] }}</a>
                                @if (!empty($campus['location_label']))<span class="meta"> — {{ $campus['location_label'] }}</span>@endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if (!empty($profile['catalogue']['delivery_sites']))
                    <h2 id="delivery-sites-heading">{{ __('directory.delivery_sites_heading') }}</h2>
                    <ul>
                        @foreach ($profile['catalogue']['delivery_sites'] as $site)
                            <li dir="auto">
                                <a href="{{ route('directory.show', ['entity' => $site['id'], 'lang' => $locale]) }}">{{ $site['name'] }}</a>
                                @if (!empty($site['location_label']))<span class="meta"> — {{ $site['location_label'] }}</span>@endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if (!empty($profile['catalogue']['programmes']))
                    <h2 id="programmes-heading">{{ __('directory.programmes_offers_heading') }}</h2>
                    @foreach ($profile['catalogue']['programmes'] as $programme)
                        <section>
                            <h3 dir="auto"><a href="{{ route('directory.show', ['entity' => $programme['id'], 'lang' => $locale]) }}">{{ $programme['name'] }}</a></h3>
                            @if ($programme['offers'] !== [])
                                <ul>
                                    @foreach ($programme['offers'] as $offer)
                                        <li dir="auto">{{ $offer['admission_cycle'] }} — <a href="{{ route('directory.show', ['entity' => $offer['location_entity_id'], 'lang' => $locale]) }}">{{ $offer['location'] }}</a></li>
                                    @endforeach
                                </ul>
                            @else
                                <p>{{ __('directory.no_current_offers') }}</p>
                            @endif
                        </section>
                    @endforeach
                @endif
            </section>
        @endif
        @if (!empty($profile['location_catalogue']))
            <section aria-labelledby="location-institution-heading">
                <h2 id="location-institution-heading">{{ __('directory.institution_label') }}</h2>
                <p><a href="{{ route('directory.show', ['entity' => $profile['location_catalogue']['institution_entity_id'], 'lang' => $locale]) }}" dir="auto">{{ $profile['location_catalogue']['institution_name'] }}</a></p>
            </section>
        @endif

        @if (($profile['programme_offers'] ?? []) !== [])
            <section aria-labelledby="admissions-heading">
                <h2 id="admissions-heading">{{ __('directory.admissions_info') }}</h2>
                @foreach ($profile['programme_offers'] as $offer)
                    <section aria-labelledby="offer-{{ $loop->index }}-heading">
                        <h3 id="offer-{{ $loop->index }}-heading" dir="auto">{{ $offer['admission_cycle'] }}</h3>
                        <p class="meta">{{ __('directory.delivery_location', ['value' => $offer['delivery_location_type'] === 'Campus' ? __('directory.delivery_locations.campus') : __('directory.delivery_locations.delivery_site')]) }}</p>
                        <dl>
                            @foreach ($offer['facts'] as $offerFact)
                                <dt dir="auto">{{ $offerFact['label'] }}</dt>
                                <dd dir="auto">
                                    @if ($offerFact['state'] === 'unknown')
                                        {{ __('directory.unknown') }}
                                    @elseif ($offerFact['state'] === 'not_stated')
                                        {{ __('directory.not_stated') }}
                                    @elseif ($offerFact['state'] === 'not_applicable')
                                        {{ __('directory.not_applicable') }}
                                    @elseif ($offerFact['state'] === 'conflicting')
                                        {{ __('directory.conflicting') }}
                                    @elseif ($offerFact['state'] === 'stale')
                                        <strong>{{ __('directory.stale') }}:</strong>
                                        @if ($offerFact['category'] === 'deadline')
                                            {{ $offerFact['value']['date'] ?? __('directory.date_unavailable') }}
                                        @elseif ($offerFact['category'] === 'fee')
                                            {{ $offerFact['value']['component'] }}:
                                            {{ $offerFact['value']['amount'] }} {{ $offerFact['value']['currency'] }}
                                        @else
                                            {{ $offerFact['value']['text'] ?? __('directory.information_unavailable') }}
                                        @endif
                                    @elseif ($offerFact['category'] === 'deadline')
                                        {{ $offerFact['value']['date'] ?? __('directory.date_unavailable') }}
                                    @elseif ($offerFact['category'] === 'fee')
                                        {{ $offerFact['value']['component'] }}:
                                        {{ $offerFact['value']['amount'] }} {{ $offerFact['value']['currency'] }}
                                    @else
                                        {{ $offerFact['value']['text'] ?? __('directory.information_unavailable') }}
                                    @endif
                                    @if ($offerFact['observed_at'] !== null)
                                        <div class="meta">{{ __('directory.evidence_observed', ['date' => $offerFact['observed_at']]) }}</div>
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
