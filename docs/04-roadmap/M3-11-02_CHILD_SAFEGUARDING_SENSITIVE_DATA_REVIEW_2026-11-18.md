# M3-11-02 — Child Safeguarding and Sensitive-Data Repository Review

**Date:** 2026-11-18  
**Review type:** AI-assisted repository/code/test inspection for Product Owner decision  
**Status:** PRELIMINARY EVIDENCE REVIEW — OWNER DISPOSITIONS PENDING  
**Scope:** Private V2 development/acceptance; synthetic fixtures only; no production or live environment inspected  
**Repository baseline inspected:** `main` at `5e68ac4ba70db0461a902832cb6ed483640b9a4c`

## 1. Scope and limitations

This review checks repository evidence relevant to child/minor data, sensitive-data exposure, anonymous public directory projections and the Deeni Madaris default-OFF boundary. It is not a legal applicability determination, child-safeguarding assessment, privacy impact assessment, penetration test, accessibility audit or review of a running environment.

The Product Owner's accepted boundary remains: private V2 development/acceptance only; synthetic/fictional fixtures only; no real students, institutions or personal records; no public launch or participant testing; Deeni Madaris excluded and default-OFF. No child, student, guardian or research participant is to be recruited, contacted or asked to test.

## 2. Evidence inspected

- `app/Policies/DeeniMadarisVisibilityPolicy.php`
- `config/directory.php`
- `app/Http/Controllers/PublicDirectoryController.php`
- `app/Services/Directory/PublicDirectoryQueryService.php`
- `routes/web.php`
- `tests/Feature/PublicDirectoryTest.php`
- `tests/Feature/ModerationPrivacyBoundaryTest.php`
- `resources/views/directory/index.blade.php`
- `resources/views/directory/show.blade.php`
- Existing M3-11-02 legal/privacy/safeguarding review pack and M3-08C/D implementation record

No live data, external source, hosting environment, logs, backups, user account or production/V1 resource was accessed.

## 3. Verified observations

### 3.1 Deeni Madaris default-OFF and public exclusion

- `config/directory.php` defaults `directory.deeni_madaris_public` to `false`, including when the environment variable is absent.
- `DeeniMadarisVisibilityPolicy::isPubliclyVisible()` also defaults the configuration lookup to false.
- The public directory query independently requires `public_projections.is_deeni_madaris = false`, requires the payload flag `is_deeni_madaris === false`, and limits entity types to the public directory's five ordinary categories. The query does not rely only on the configuration toggle.
- `PublicDirectoryTest::test_deeni_madaris_never_appears_in_results_facets_or_direct_profile` deliberately sets the configuration to true and still expects the synthetic Deeni Madaris entity to remain absent from search, facets and direct profile.
- The policy class is not visibly invoked by the inspected public query service; the hard exclusion in the query and the regression test are the direct evidence for the inspected anonymous directory path.

**Interpretation:** the inspected public directory path is fail-closed for Deeni Madaris, including when the config flag is forced true in the test. This is bounded code/test evidence, not proof that every future route, export, admin screen, API or data pipeline has the same behavior.

### 3.2 Public directory output boundary

- The anonymous routes are limited in `routes/web.php` to `GET /directory` and `GET /directory/{entity}`, with throttling.
- The query service reads current approved anonymous-directory projections, excludes active suppressions, superseded claim versions and non-current snapshots, and rechecks source authorization eligibility.
- It uses a legacy public-field allowlist and requires registry-managed fields to have both public-eligible visibility and privacy classifications.
- The returned fact objects are reduced to display fields; internal search/filter/sort flags are removed before reaching the views.
- Blade output uses escaped interpolation for names, labels and values. The tests cover internal-note exclusion, hostile HTML, invalid URL schemes, unpublished/suppressed/revoked/expired facts and ambiguous names.

**Interpretation:** useful defence-in-depth exists for the inspected directory projection. It does not prove every future field definition or all possible data classes are safe for public publication.

### 3.3 Child/minor and identity fields

- `ModerationPrivacyBoundaryTest` checks that selected fields are absent from the moderation case, appeal, event and user tables, including birth date, age, age verification, guardian consent, student status, phone, identity document and enrollment document.
- That test is explicitly a bounded schema assertion. It does not inventory every table, JSON payload, audit metadata field, log, export, cache, backup or future schema change.
- The reviewed public directory schema path includes public contact phone/email fields, and the generic registry scalar formatter supports public-eligible `date`, `email` and `phone` values when the corresponding registry definition permits them.
- No complete semantic denylist or automated child/minor-data classifier was established by the inspected files. A field's `public_eligible` classification and a synthetic-only fixture rule do not by themselves prove that real child-related or personal data cannot be entered later.

**Interpretation:** the current synthetic-only restriction is essential. Before any real data or public access is considered, the owner must decide the prohibited data classes and verify enforcement across registry definitions, legacy fields, all persistence paths and outputs.

### 3.4 Contact and participation surface

- The inspected public routes do not provide student/guardian messaging, registration, public review, rating, moderation or appeal intake.
- The moderation privacy test asserts the absence of public moderation/appeal/rating routes and requires authentication for the two editorial review routes.
- Institution/provider public contact fields can exist in the directory projection. They are not evidence of a student contact feature, but their provenance, ownership, publication rights and suitability would need review before any real-world content is published.
- No participant testing, child recruitment, surveys, interviews or public pilot is part of the accepted private scope.

## 4. Preliminary findings for Product Owner disposition

| ID | Severity | Finding | Recommended internal disposition |
|---|---|---|---|
| CS-01 | Low / controlled | Inspected anonymous directory path excludes Deeni Madaris by configuration default, projection flag, payload flag and entity-type allowlist; a test forces config true and still expects exclusion. | ACCEPT as bounded synthetic CI/code evidence for this path only; retain default-OFF and zero-public-exposure requirement; do not generalize to uninspected surfaces. |
| CS-02 | Medium | Selected child/identity fields are absent from specific tested tables, but the test is not a complete schema/data-flow/log/export/backup review. | ACCEPT as partial synthetic evidence only; retain prohibition on real child/student/guardian data. |
| CS-03 | High | Generic public registry scalar handling can expose public-eligible date, email and phone values; no complete child/minor semantic denylist was established in this review. | DEFER any real-data/public-use decision; require a documented prohibited-data taxonomy and enforcement/test coverage before any scope expansion. |
| CS-04 | Medium | Public institution/provider contact fields are supported; their real-world provenance, rights, owner and contact-safety implications are not established for an actual dataset. | ACCEPT only for fictional fixtures in this private scope; no real contact details or external source acquisition. |
| CS-05 | Medium | The inspected routes/tests support no public student/guardian communication, registration, UGC, review or moderation intake, but route and UI evidence is bounded to the current repository baseline. | ACCEPT as current synthetic implementation boundary; any new route, UI, ingestion or participant activity requires separate authorization and review. |

## 5. Explicit unknowns

This repository review cannot establish:
- Applicable child/minor age definitions or legal obligations in any jurisdiction.
- Whether the eventual product is legally considered child-directed or likely to be accessed by children.
- Whether any future dataset contains personal, sensitive, education, religious-affiliation or child-related information.
- Whether every field registry, source-ingestion, export, log, backup, cache, admin or future API path applies equivalent controls.
- Actual hosting region, processors, runtime configuration, log destinations, access roster, retention or deletion behavior.
- Whether future content publication has adequate source rights, institutional authority, accuracy and contact-safety review.

No assumption about these matters should be inferred from synthetic tests or the current unprovisioned state.

## 6. Owner decisions requested

1. Confirm CS-01: accept the Deeni Madaris exclusion as bounded evidence for the inspected anonymous directory path only; keep default-OFF and zero public exposure binding.
2. Confirm CS-02 and CS-05: accept the current tests/routes only as partial synthetic evidence; keep real child/student/guardian data, public participation and UGC disabled.
3. Confirm CS-03 and CS-04: defer all real-data/public-use decisions; require a prohibited-data taxonomy and field-level enforcement review, and allow only fictional contact values in the current private scope.

These are Product Owner internal decisions only. They do not constitute legal advice, a safeguarding determination or professional certification.

## 7. Current gate status

M3-11-02 remains IN PROGRESS / BLOCKED. The repository evidence supports the bounded synthetic-only private development scope, but does not complete child-safeguarding applicability, a full sensitive-data inventory, target-specific privacy review or any release gate.

No environment provisioning, real-data processing, participant activity, external service, spend, deployment, public pilot or launch is authorized. Deeni Madaris remains default-OFF with zero public exposure.
