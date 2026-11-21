<!doctype html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $locale === 'ur' ? 'ادارتی کیس کا جائزہ' : 'Editorial case review' }} — eStudent</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; color: #172033; background: #f7f8fa; line-height: 1.6; }
        main { max-width: 68rem; margin: 0 auto; padding: 1.25rem; }
        header, section, .notice { background: #fff; border: 1px solid #d9dee7; border-radius: .7rem; padding: 1rem; margin-block: 1rem; }
        h1, h2 { line-height: 1.3; }
        dt { font-weight: 700; margin-block-start: .6rem; }
        dd { margin-inline-start: 0; overflow-wrap: anywhere; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: start; vertical-align: top; padding: .55rem; border-block-end: 1px solid #d9dee7; overflow-wrap: anywhere; }
        input, select, textarea, button { font: inherit; max-width: 100%; }
        textarea { width: 100%; min-height: 6rem; }
        label { display: block; margin-block: .6rem; font-weight: 600; }
        button { padding: .55rem .9rem; border: 1px solid #174ea6; border-radius: .35rem; background: #174ea6; color: #fff; cursor: pointer; }
        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible { outline: 3px solid #005fcc; outline-offset: 3px; }
        .muted { color: #4b5563; }
        .skip-link { position: absolute; top: 1rem; inset-inline-start: 1rem; transform: translateY(-200%); background: white; padding: .7rem; }
        .skip-link:focus { transform: translateY(0); }
        @media (max-width: 42rem) { main { padding: .7rem; } table { display: block; overflow-x: auto; } }
    </style>
</head>
<body>
<a class="skip-link" href="#main-content">{{ $locale === 'ur' ? 'مرکزی مواد پر جائیں' : 'Skip to main content' }}</a>
<main id="main-content" tabindex="-1">
    <p><a href="{{ route('workspace.index', ['lang' => $locale]) }}">{{ $locale === 'ur' ? 'ورک اسپیس پر واپس جائیں' : 'Back to workspace' }}</a></p>
    <header>
        <h1>{{ $locale === 'ur' ? 'ادارتی کیس کا جائزہ' : 'Editorial case review' }}</h1>
        <p>{{ $locale === 'ur' ? 'یہ معلومات صرف مجاز اور آزاد جائزہ کار کے لیے ہیں۔' : 'This case is visible only to an authorised, independent reviewer.' }}</p>
        <p><strong>{{ $case['entity_label'] }}</strong> · <code>{{ $case['case_id'] }}</code></p>
        <p>{{ $locale === 'ur' ? 'حیثیت' : 'Status' }}: <strong>{{ str_replace('_', ' ', $case['status']) }}</strong></p>
    </header>

    <section aria-labelledby="proposal-heading">
        <h2 id="proposal-heading">{{ $locale === 'ur' ? 'تجویز کی تفصیلات' : 'Proposal details' }}</h2>
        <dl>
            <dt>{{ $locale === 'ur' ? 'فیلڈ' : 'Field' }}</dt><dd><code>{{ $case['predicate'] }}</code></dd>
            <dt>{{ $locale === 'ur' ? 'ورژن' : 'Version' }}</dt><dd>{{ $case['version_number'] }}</dd>
            <dt>{{ $locale === 'ur' ? 'مجوزہ قدر' : 'Proposed value' }}</dt><dd><pre dir="auto">{{ json_encode($case['proposed_value'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre></dd>
            <dt>{{ $locale === 'ur' ? 'مؤثر ہونے کی تاریخ' : 'Valid from' }}</dt><dd>{{ $case['valid_from'] ?? '—' }}</dd>
            <dt>{{ $locale === 'ur' ? 'میعاد ختم ہونے کی تاریخ' : 'Valid to' }}</dt><dd>{{ $case['valid_to'] ?? '—' }}</dd>
            <dt>{{ $locale === 'ur' ? 'جمع کرانے کا وقت' : 'Submitted at' }}</dt><dd>{{ $case['submitted_at'] }}</dd>
        </dl>
    </section>

    <section aria-labelledby="evidence-heading">
        <h2 id="evidence-heading">{{ $locale === 'ur' ? 'شواہد کے حوالہ جات' : 'Evidence references' }}</h2>
        <p class="muted">{{ $locale === 'ur' ? 'صرف حوالہ جاتی میٹا ڈیٹا دکھایا گیا ہے۔ اصل دستاویزات، مواد، لنکس اور فائلیں اس ورک اسپیس میں دستیاب نہیں۔' : 'Metadata only. Original documents, evidence content, URLs and files are not available in this workspace.' }}</p>
        @if ($case['evidence'] === [])
            <p>{{ $locale === 'ur' ? 'اس ورژن کے ساتھ کوئی حوالہ منسلک نہیں۔' : 'No evidence references are linked to this version.' }}</p>
        @else
            <table>
                <thead><tr>
                    <th>{{ $locale === 'ur' ? 'حوالہ' : 'Reference' }}</th>
                    <th>{{ $locale === 'ur' ? 'قسم' : 'Kind' }}</th>
                    <th>{{ $locale === 'ur' ? 'ذریعے کی قسم' : 'Source type' }}</th>
                    <th>{{ $locale === 'ur' ? 'حوالہ کی حیثیت' : 'Reference status' }}</th>
                    <th>{{ $locale === 'ur' ? 'اجازت' : 'Authorization' }}</th>
                    <th>{{ $locale === 'ur' ? 'مواد شامل؟' : 'Content included?' }}</th>
                    <th>{{ $locale === 'ur' ? 'مشاہدہ / اندراج' : 'Observed / recorded' }}</th>
                </tr></thead>
                <tbody>
                @foreach ($case['evidence'] as $evidence)
                    <tr>
                        <td><code>{{ $evidence['reference_id'] }}</code><br><span class="muted">{{ $evidence['relationship_type'] }}</span></td>
                        <td>{{ $evidence['reference_kind'] }}</td>
                        <td>{{ $evidence['source_type'] }}</td>
                        <td>{{ $evidence['evidence_status'] }}</td>
                        <td>{{ $evidence['authorization_status'] }}<br>{{ $evidence['authorization_revoked'] ? ($locale === 'ur' ? 'منسوخ' : 'Revoked') : ($locale === 'ur' ? 'منسوخ نہیں' : 'Not revoked') }}<br><span class="muted">{{ $evidence['authorization_valid_from'] ?? '—' }} → {{ $evidence['authorization_valid_to'] ?? '—' }}</span></td>
                        <td>{{ $evidence['content_included'] ? ($locale === 'ur' ? 'ہاں' : 'Yes') : ($locale === 'ur' ? 'نہیں' : 'No') }}</td>
                        <td>{{ $evidence['observed_at'] ?? '—' }}<br>{{ $evidence['recorded_at'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <section aria-labelledby="correction-history-heading">
        <h2 id="correction-history-heading">{{ $locale === 'ur' ? 'درستگی کی سابقہ تاریخ' : 'Correction history' }}</h2>
        @if ($case['correction_history'] === [])
            <p>{{ $locale === 'ur' ? 'اس ورژن سے پہلے کوئی سابقہ ورژن منسلک نہیں۔' : 'This is the first recorded version in this correction chain.' }}</p>
        @else
            <ol>
            @foreach ($case['correction_history'] as $version)
                <li>{{ $locale === 'ur' ? 'ورژن' : 'Version' }} {{ $version['version_number'] }} — {{ $version['disposition'] }}; {{ $version['case_status'] ?? ($locale === 'ur' ? 'ادارتی کیس دستیاب نہیں' : 'No linked editorial case') }}; {{ $version['case_created_at'] ?? '—' }}</li>
            @endforeach
            </ol>
        @endif
    </section>

    <section aria-labelledby="history-heading">
        <h2 id="history-heading">{{ $locale === 'ur' ? 'ادارتی تاریخ' : 'Editorial history' }}</h2>
        @if ($case['history'] === [])
            <p>{{ $locale === 'ur' ? 'ابھی کوئی سابقہ حیثیتی تبدیلی درج نہیں۔' : 'No previous editorial status transitions are recorded.' }}</p>
        @else
            <ol>
            @foreach ($case['history'] as $event)
                <li>{{ str_replace('_', ' ', $event['event_type']) }} — {{ $event['previous_status'] ?? '—' }} → {{ $event['new_status'] }}; {{ $event['reason_code'] }}; {{ $event['actor_class'] }}; {{ $event['occurred_at'] }}</li>
            @endforeach
            </ol>
        @endif
    </section>

    @if ($case['status'] === 'submitted')
        <section aria-labelledby="start-heading">
            <h2 id="start-heading">{{ $locale === 'ur' ? 'جائزہ شروع کریں' : 'Start review' }}</h2>
            <p class="muted">{{ $locale === 'ur' ? 'جائزہ شروع کرنے سے پہلے نظام آپ کی جمع کرائی گئی تجویز اور شواہد میں کردار کی دوبارہ جانچ کرے گا۔' : 'The server rechecks reviewer independence before assigning this case.' }}</p>
            <form method="post" action="{{ route('institutions.editorial-cases.review.start', ['institution' => $institution, 'case' => $case['case_id']]) }}">
                @csrf
                <label for="start-key">{{ $locale === 'ur' ? 'درخواست کی منفرد کلید' : 'Idempotency key' }}</label>
                <input id="start-key" name="idempotency_key" required maxlength="100" value="{{ old('idempotency_key') }}">
                <button type="submit">{{ $locale === 'ur' ? 'جائزہ شروع کریں' : 'Start review' }}</button>
            </form>
        </section>
    @elseif ($case['status'] === 'in_review')
        <section aria-labelledby="complete-heading">
            <h2 id="complete-heading">{{ $locale === 'ur' ? 'جائزے کا نتیجہ درج کریں' : 'Record review outcome' }}</h2>
            <p class="muted">{{ $locale === 'ur' ? 'یہ صرف ادارتی جائزے کا نتیجہ ہے؛ فیصلہ سازی اور اشاعت الگ مراحل ہیں۔' : 'This records an editorial review outcome only. Adjudication and publication remain separate.' }}</p>
            <form method="post" action="{{ route('institutions.editorial-cases.review.complete', ['institution' => $institution, 'case' => $case['case_id']]) }}">
                @csrf
                @method('PATCH')
                <label for="outcome">{{ $locale === 'ur' ? 'نتیجہ' : 'Outcome' }}</label>
                <select id="outcome" name="outcome" required>
                    <option value="ready_for_adjudication">{{ $locale === 'ur' ? 'فیصلہ سازی کے لیے تیار' : 'Ready for adjudication' }}</option>
                    <option value="changes_requested">{{ $locale === 'ur' ? 'درستگی درکار ہے' : 'Changes requested' }}</option>
                    <option value="held">{{ $locale === 'ur' ? 'روک دیا گیا' : 'Held' }}</option>
                </select>
                <label for="reason">{{ $locale === 'ur' ? 'وجہ کا کوڈ' : 'Reason code' }}</label>
                <input id="reason" name="reason_code" required maxlength="80">
                <label for="rationale">{{ $locale === 'ur' ? 'تفصیلی وضاحت' : 'Rationale' }}</label>
                <textarea id="rationale" name="rationale" required minlength="10" maxlength="1000"></textarea>
                <label for="complete-key">{{ $locale === 'ur' ? 'درخواست کی منفرد کلید' : 'Idempotency key' }}</label>
                <input id="complete-key" name="idempotency_key" required maxlength="100">
                <button type="submit">{{ $locale === 'ur' ? 'جائزہ محفوظ کریں' : 'Save review outcome' }}</button>
            </form>
        </section>
    @endif

    <p class="notice">{{ $locale === 'ur' ? 'یہاں سے فیصلہ سازی، اشاعت، اشاعت روکنے، بحال کرنے یا براہ راست کیٹلاگ میں ترمیم کی اجازت نہیں ہے۔' : 'Adjudication, publication, suppression, restoration and direct catalogue editing are not available here.' }}</p>
</main>
</body>
</html>
