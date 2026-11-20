<!doctype html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('directory.saved_items_title') }} — {{ __('directory.directory_title') }}</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.6; }
        main { max-width: 58rem; margin: 0 auto; padding: 1.25rem; }
        .item, .empty { background: #fff; border: 1px solid #d9dee7; border-radius: .65rem; padding: 1rem; margin-block: .8rem; }
        .meta { color: #4b5563; font-size: .94rem; }
        a { color: #174ea6; }
        button { min-height: 2.6rem; padding: .5rem .8rem; border: 1px solid #667085; border-radius: .35rem; background: #fff; color: #172033; font: inherit; cursor: pointer; }
        a:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; inset-inline-start: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">{{ __('directory.skip') }}</a>
<main id="main-content" tabindex="-1">
    <p><a href="{{ route('directory.index', ['lang' => $locale]) }}">← {{ __('directory.back_directory') }}</a></p>
    <h1>{{ __('directory.saved_items_title') }}</h1>
    <p>{{ __('directory.saved_items_intro') }}</p>
    <p class="meta">{{ __('directory.saved_items_limit', ['limit' => $limit]) }}</p>
    @if (session('saved_items_status'))<p role="status">{{ session('saved_items_status') }}</p>@endif
    @if (count($items) === 0)
        <section class="empty"><p>{{ __('directory.saved_items_empty') }}</p></section>
    @else
        @foreach ($items as $item)
            <article class="item">
                @if ($item['profile'] !== null)
                    <h2><a href="{{ route('directory.show', ['entity' => $item['entity_id'], 'lang' => $locale]) }}" dir="auto">{{ $item['profile']['name'] }}</a></h2>
                    <p class="meta">{{ __('directory.types.'.$item['profile']['type']) }}</p>
                @else
                    <p role="status">{{ __('directory.saved_item_unavailable') }}</p>
                @endif
                <p class="meta">{{ __('directory.saved_on', ['date' => $item['created_at']]) }}</p>
                <form method="post" action="{{ route('account.saved-items.destroy', ['entity' => $item['entity_id']]) }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="lang" value="{{ $locale }}">
                    <button type="submit">{{ __('directory.remove_saved_item') }}</button>
                </form>
            </article>
        @endforeach
    @endif
</main>
</body>
</html>
