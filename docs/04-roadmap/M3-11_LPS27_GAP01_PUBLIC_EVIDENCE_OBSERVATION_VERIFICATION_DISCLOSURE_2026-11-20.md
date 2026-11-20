# M3-11 LPS-27 — GAP-01 Public Evidence Transparency: Observation and Verification Disclosure

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `2d6acfd67edf25844614f5648065bbeaea91220c` (main after LPS-26 merge)  
**Agenda:** LPS-27 — GAP-01 bounded public evidence transparency implementation  
**Status:** **PROFILE DISCLOSURE IMPLEMENTED WITH SYNTHETIC ENGLISH/URDU TEST — CI PENDING**

## 1. Purpose and boundary

LPS-27 implements one safe, supportable element of LPS-16: make the meaning of an observation date explicit on public directory profile pages. A date when evidence was observed or recorded is not, by itself, independent verification.

The notice is displayed in English and Urdu. It does not add source attribution, source links, verification badges, confidence scores or source descriptions because the current public profile query does not expose a rights-reviewed public source identity and disclosure decision for each field.

No source was accessed or assessed. No real institute or personal data was used. No public launch, deployment, pilot, new service or external integration is authorized.

## 2. Implementation

Updated `resources/views/directory/show.blade.php` to display a neutral note below the latest observation date.

Added translations:
- `lang/en/directory.php`: “An observation date shows when evidence was recorded; it does not mean the information has been independently verified.”
- `lang/ur/directory.php`: “مشاہدے کی تاریخ صرف یہ بتاتی ہے کہ شواہد کب درج کیے گئے؛ اس کا مطلب یہ نہیں کہ معلومات کی آزادانہ تصدیق ہو چکی ہے۔”

Added `PublicDirectoryTest::test_profile_explains_that_observation_date_is_not_independent_verification_in_both_languages`, using a fabricated institution fixture, to assert the notice appears in both locales.

No source attribution is fabricated, no evidence state is upgraded, and no new verification assertion is made. The existing public projection allowlist, publication eligibility and Deeni Madaris default-OFF behavior are unchanged.

## 3. Why source attribution is not added yet

LPS-16 requires public attribution to resolve to a source record and a current source-specific rights decision that covers the exact public disclosure/use. LPS-15 and LPS-20 prepared the assessment and handoff requirements, but no qualified source-specific assessment or approval has been received.

The current profile read model exposes evidence observation dates and publication-approved field values, but does not establish that public source names, canonical URLs, source authority claims, quotations or verification methods are authorized for disclosure. Therefore LPS-27 deliberately does not expose those details.

## 4. Validation

- Synthetic-only feature test added.
- English and Urdu wording is asserted in the feature test.
- Foundation CI and documentation validation must pass on the exact PR head.
- CI execution remains pending until GitHub Actions completes.
- No real source, live record, external service or hosted system was accessed.

## 5. Acceptance disposition

- [x] Public profile communicates that observation date is not independent verification.
- [x] English and Urdu translations added.
- [x] Synthetic feature test added for both languages.
- [x] No unsupported source attribution or verification claim introduced.
- [ ] Exact-head Foundation CI passes.
- [ ] Exact-head documentation validation passes.
- [ ] Rights-approved field-level public source attribution implemented — NOT APPROVED / NOT IMPLEMENTED.
- [ ] Complete field-level verification state, freshness and correction transparency implemented — PARTIAL / OPEN.
- [ ] GAP-01 closure — NOT ACCEPTED.

**Final disposition:** LPS-27 is a bounded public-profile transparency improvement only. GAP-01 remains **PARTIALLY IMPLEMENTED / OPEN / NOT CLOSED** pending source-specific rights decisions, complete field-level evidence/verification metadata, approved freshness rules and correction transparency. M3-11 Gate 02 remains BLOCKED / NOT ACCEPTED; all other gate dispositions remain unchanged. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
