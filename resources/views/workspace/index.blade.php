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
                            <strong dir="auto">{{ $submission['entity_name'] }}</strong>
                            <span class="pill">{{ str_replace('_', ' ', $submission['status']) }}</span>
                        </div>
                        @if ($submission['entity_type'] !== 'institution')
                            <p class="meta">{{ $locale === 'ur' ? 'بنیادی ادارہ' : 'Parent institution' }}: {{ $submission['institution_name'] }}</p>
                        @endif
                        <p>{{ $locale === 'ur' ? 'فیلڈ' : 'Field' }}: <code>{{ $submission['predicate'] }}</code></p>
                        <p class="meta">{{ $locale === 'ur' ? 'ورژن' : 'Version' }} {{ $submission['version_number'] }} · {{ $submission['created_at'] }}</p>
                        <p class="meta"><strong>{{ $locale === 'ur' ? 'اگلا قدم' : 'Next step' }}:</strong>
                            {{ $locale === 'ur' ? match ($submission['next_action']) {
                                'correct_and_resubmit' => 'درستگی کرکے دوبارہ جمع کریں',
                                'successor_submitted' => 'نیا ورژن جمع ہو چکا ہے',
                                'awaiting_editorial_review' => 'ادارتی جائزے کا انتظار',
                                'under_editorial_review' => 'ادارتی جائزہ جاری ہے',
                                'awaiting_separate_adjudication' => 'الگ فیصلہ سازی کا انتظار',
                                'held_for_follow_up' => 'مزید کارروائی کے لیے روکا گیا',
                                'withdrawn_no_action' => 'واپس لے لیا گیا؛ کوئی کارروائی درکار نہیں',
                                default => 'کیس کی موجودہ حالت دیکھیں',
                            } : match ($submission['next_action']) {
                                'correct_and_resubmit' => 'Correct and resubmit',
                                'successor_submitted' => 'Successor version submitted',
                                'awaiting_editorial_review' => 'Awaiting editorial review',
                                'under_editorial_review' => 'Under editorial review',
                                'awaiting_separate_adjudication' => 'Awaiting separate adjudication',
                                'held_for_follow_up' => 'Held for follow-up',
                                'withdrawn_no_action' => 'Withdrawn; no action required',
                                default => 'Check case status',
                            } }}
                        </p>
                    </article>
                @endforeach
            @endif
        </section>
    @endif

    @if ($reviewer)
        <section class="panel" aria-labelledby="review-heading">
            <h2 id="review-heading">{{ $locale === 'ur' ? 'ادارتی جائزے کی قطار' : 'Editorial review queue' }}</h2>
            <p class="meta">{{ $locale === 'ur' ? 'نئی تجاویز اور صرف آپ کے سپرد کردہ جاری جائزے دکھائے گئے ہیں۔ اپنی جمع کردہ تجاویز اور اپنے فراہم کردہ شواہد شامل نہیں ہیں۔' : 'New submissions and only reviews currently assigned to you are shown. Your own submissions and proposals with evidence you registered are excluded.' }}</p>
            @if ($reviewQueue === [])
                <div class="empty"><p>{{ $locale === 'ur' ? 'اس وقت جائزے کے لیے کوئی نئی تجویز موجود نہیں۔' : 'There are no new proposals available for your review.' }}</p></div>
            @else
                @foreach ($reviewQueue as $case)
                    <article class="case" data-case-reference="{{ $case['case_id'] }}">
                        <div class="topline">
                            <strong dir="auto">{{ $case['entity_name'] }}</strong>
                            <span class="pill">{{ $locale === 'ur' ? ($case['status'] === 'in_review' ? 'جائزے میں' : 'جمع شدہ') : ($case['status'] === 'in_review' ? 'In review' : 'Submitted') }}</span>
                        </div>
                        @if ($case['entity_type'] !== 'institution')
                            <p class="meta">{{ $locale === 'ur' ? 'بنیادی ادارہ' : 'Parent institution' }}: {{ $case['institution_name'] }}</p>
                        @endif
                        <p>{{ $locale === 'ur' ? 'فیلڈ' : 'Field' }}: <code>{{ $case['predicate'] }}</code></p>
                        <p class="meta">{{ $locale === 'ur' ? 'ورژن' : 'Version' }} {{ $case['version_number'] }} · {{ $case['created_at'] }}</p>
                        <p class="meta"><strong>{{ $locale === 'ur' ? 'اگلا قدم' : 'Next step' }}:</strong>
                            {{ $locale === 'ur' ? ($case['status'] === 'in_review' ? 'اپنا سپرد کردہ جائزہ جاری رکھیں' : 'نئی تجویز کا جائزہ شروع کریں') : ($case['status'] === 'in_review' ? 'Continue your assigned review' : 'Start reviewing this submission') }}
                        </p>
                        <p><a href="{{ route('institutions.editorial-cases.show', ['institution' => $case['institution_id'], 'case' => $case['case_id'], 'lang' => $locale]) }}">{{ $locale === 'ur' ? 'کیس اور شواہد دیکھیں' : 'Inspect case and evidence metadata' }}</a></p>
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
