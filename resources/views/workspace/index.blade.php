<!doctype html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $locale === 'ur' ? 'ادارہ جاتی ورک اسپیس' : 'Institute workspace' }} — eStudent</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.6; }
        main { max-width: 68rem; margin: 0 auto; padding: 1.25rem; }
        header, .panel, .empty { background: #fff; border: 1px solid #d9dee7; border-radius: .7rem; padding: 1rem; }
        header { margin-block-end: 1rem; }
        .panel { margin-block: 1rem; }
        .panel h2 { margin-block-start: 0; }
        .case { border-block-start: 1px solid #e3e7ee; padding-block: .8rem; }
        .case:first-of-type { border-block-start: 0; }
        .meta { color: #4b5563; font-size: .94rem; }
        a { color: #174ea6; }
        a:focus-visible, button:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; }
        .skip-link { position: absolute; z-index: 10; top: 1rem; inset-inline-start: 1rem; padding: .75rem 1rem; color: #005fcc; background: #fff; border: 2px solid #005fcc; border-radius: .35rem; transform: translateY(-200%); }
        .skip-link:focus { transform: translateY(0); }
        .topline { display: flex; flex-wrap: wrap; justify-content: space-between; gap: .6rem; align-items: center; }
        .pill { display: inline-block; border: 1px solid #aab4c2; border-radius: 99px; padding: .1rem .6rem; font-size: .85rem; }
        @media (max-width: 42rem) { main { padding: .75rem; } }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">{{ $locale === 'ur' ? 'مرکزی مواد پر جائیں' : 'Skip to main content' }}</a>
<main id="main-content" tabindex="-1">
    <header>
        <div class="topline">
            <p><a href="{{ route('directory.index', ['lang' => $locale]) }}">{{ $locale === 'ur' ? 'طلبہ کی ڈائریکٹری' : 'Student directory' }}</a></p>
            <nav aria-label="{{ $locale === 'ur' ? 'زبان' : 'Language' }}">
                <a href="{{ route('workspace.index', ['lang' => 'en']) }}" @if ($locale === 'en') aria-current="page" @endif>English</a>
                <span aria-hidden="true">|</span>
                <a href="{{ route('workspace.index', ['lang' => 'ur']) }}" @if ($locale === 'ur') aria-current="page" @endif>اردو</a>
            </nav>
        </div>
        <h1>{{ $locale === 'ur' ? 'ادارہ جاتی ورک اسپیس' : 'Institute workspace' }}</h1>
        <p>{{ $locale === 'ur' ? 'یہ محفوظ ورک اسپیس صرف آپ کے موجودہ کردار اور ادارہ جاتی دائرۂ اختیار کے مطابق معلومات دکھاتا ہے۔' : 'This private workspace shows information only within your active role and assigned institution scopes.' }}</p>
        <p class="meta">{{ $locale === 'ur' ? 'صرف دیکھنے کی سہولت — اس صفحے سے کوئی تبدیلی یا اشاعت نہیں ہوتی۔' : 'Read-only workspace — this page does not change or publish any information.' }}</p>
    </header>

    @if ($representative)
        <section class="panel" aria-labelledby="submissions-heading">
            <h2 id="submissions-heading">{{ $locale === 'ur' ? 'میری جمع کردہ تجاویز' : 'My submissions' }}</h2>
            <p class="meta">{{ $locale === 'ur' ? 'صرف آپ کی اپنی تجاویز اور آپ کے مجاز اداروں کی معلومات دکھائی گئی ہیں۔' : 'Only proposals submitted by your account for institutions assigned to you are shown.' }}</p>
            @if ($submissions === [])
                <div class="empty"><p>{{ $locale === 'ur' ? 'ابھی کوئی جمع کردہ تجویز موجود نہیں۔' : 'You have no submitted proposals in your assigned institution scopes.' }}</p></div>
            @else
                @foreach ($submissions as $submission)
                    <article class="case" data-case-reference="{{ $submission['case_id'] }}">
                        <div class="topline">
                            <strong dir="auto">{{ $submission['institution_name'] }}</strong>
                            <span class="pill">{{ str_replace('_', ' ', $submission['status']) }}</span>
                        </div>
                        <p>{{ $locale === 'ur' ? 'فیلڈ' : 'Field' }}: <code>{{ $submission['predicate'] }}</code></p>
                        <p class="meta">{{ $locale === 'ur' ? 'ورژن' : 'Version' }} {{ $submission['version_number'] }} · {{ $submission['created_at'] }}</p>
                    </article>
                @endforeach
            @endif
        </section>
    @endif

    @if ($reviewer)
        <section class="panel" aria-labelledby="review-heading">
            <h2 id="review-heading">{{ $locale === 'ur' ? 'ادارتی جائزے کی قطار' : 'Editorial review queue' }}</h2>
            <p class="meta">{{ $locale === 'ur' ? 'صرف آپ کے مجاز اداروں کی نئی تجاویز دکھائی گئی ہیں۔ اپنی جمع کردہ تجاویز اور اپنے فراہم کردہ شواہد شامل نہیں ہیں۔' : 'Only new proposals in your assigned institution scopes are shown. Your own submissions and proposals with evidence you registered are excluded.' }}</p>
            @if ($reviewQueue === [])
                <div class="empty"><p>{{ $locale === 'ur' ? 'اس وقت جائزے کے لیے کوئی نئی تجویز موجود نہیں۔' : 'There are no new proposals available for your review.' }}</p></div>
            @else
                @foreach ($reviewQueue as $case)
                    <article class="case" data-case-reference="{{ $case['case_id'] }}">
                        <div class="topline">
                            <strong dir="auto">{{ $case['institution_name'] }}</strong>
                            <span class="pill">{{ $locale === 'ur' ? 'جمع شدہ' : 'Submitted' }}</span>
                        </div>
                        <p>{{ $locale === 'ur' ? 'فیلڈ' : 'Field' }}: <code>{{ $case['predicate'] }}</code></p>
                        <p class="meta">{{ $locale === 'ur' ? 'ورژن' : 'Version' }} {{ $case['version_number'] }} · {{ $case['created_at'] }}</p>
                    </article>
                @endforeach
            @endif
        </section>
    @endif

    <footer class="meta">
        {{ $locale === 'ur' ? 'اشاعت، فیصلہ سازی اور ادارہ جاتی ریکارڈ میں ترمیم اس مرحلے میں دستیاب نہیں۔' : 'Publication, adjudication and direct institution-record editing are not available in this phase.' }}
    </footer>
</main>
</body>
</html>
