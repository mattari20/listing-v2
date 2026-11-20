# M3-11-02 — Child Safeguarding and Sensitive-Data Repository Review

**Date:** 2026-11-18  
**Review type:** AI-assisted repository/code/test inspection for Product Owner decision  
**Status:** PRODUCT OWNER SCOPE DECISION RECORDED — SYNTHETIC-ONLY DEVELOPMENT; PUBLIC SOURCE REPOSITORY; NO CHILD DATA OR CHILD-DIRECTED SCOPE  
**Scope:** Public GitHub source-repository development and separate restricted/private acceptance target category; synthetic fixtures only; no production or live environment inspected  
**Repository baseline inspected:** `main` at `5e68ac4ba70db0461a902832cb6ed483640b9a4c`

## 1. Scope and limitations

This review checks repository evidence relevant to child/minor data, sensitive-data exposure, anonymous public directory projections and the Deeni Madaris default-OFF boundary. It is not a legal applicability determination, child-safeguarding assessment, privacy impact assessment, penetration test, accessibility audit or review of a running environment.

The Product Owner's accepted boundary is: public GitHub source-repository development and local/GitHub CI, with the application acceptance environment remaining a separate restricted/private target category; synthetic/fictional fixtures only; no real students, institutions or personal records; no public launch or participant testing; Deeni Madaris excluded and default-OFF. No child, student, guardian or research participant is to be recruited, contacted or asked to test.

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
- That test is a bounded schema assertion; it is not a full inventory of every JSON payload, audit metadata field, log, export, cache, backup or future schema change.
- The inspected public registry formatter supports generic institution/provider field types such as `date`, `email` and `phone` when a registry definition explicitly marks a field public-eligible. These generic types do not themselves imply child data; their intended use in this scope is institution/provider facts only.
- The current Product Owner scope decision prohibits child/student/guardian records and any child-related data collection. The current private scope uses fictional fixtures only. No child-directed feature or child participation is planned.

**Interpretation:** generic institution/provider contact and date fields are not child records. They remain constrained to fictional values in private acceptance. The product boundary excludes child-related data altogether; no child-data capability should be added under the present authorization.

### 3.4 Contact and participation surface

- The inspected public routes do not provide student/guardian messaging, registration, public review, rating, moderation or appeal intake.
- The moderation privacy test asserts the absence of public moderation/appeal/rating routes and requires authentication for the two editorial review routes.
- Institution/provider public contact fields can exist in the directory projection. They are not evidence of a student contact feature, but their provenance, ownership, publication rights and suitability would need review before any real-world content is published.
- No participant testing, child recruitment, surveys, interviews or public pilot is part of the accepted private scope.

## 4. Product Owner scope decision and finding dispositions — 2026-11-18

The Product Owner has clarified and confirmed the current product boundary:

- Children are not an intended audience for the current private V2 scope.
- No child/student/guardian accounts, profiles, personal records, child-directed content, participation or child-related data collection are in scope or planned.
- Child-related fields/capabilities previously identified as risks have been removed from the intended scope; no such capability may be reintroduced without a new, explicit scope decision.
- Private acceptance remains fictional/synthetic-only. Generic institution/provider date, email and phone field types are not child data and may only carry fictional values in this private scope.
- Deeni Madaris remains excluded and default-OFF with zero public exposure.

| ID | Product Owner disposition | Binding limitation |
|---|---|---|
| CS-01 | ACCEPT as bounded evidence | The inspected anonymous directory path excludes Deeni Madaris, including when the config is forced true in its regression test. This is not a claim about uninspected future surfaces. |
| CS-02 | ACCEPT as partial synthetic evidence | The selected sensitive fields are absent from the tested tables. No real child/student/guardian data is permitted. This test is not represented as a complete inventory of logs, exports, caches or backups. |
| CS-03 | ACCEPT WITH SCOPE CLARIFICATION | Generic date/email/phone types are institution/provider facts only in this scope, not child/student/guardian information. Fictional values only. No child-data taxonomy or collection feature is to be introduced. |
| CS-04 | ACCEPT FOR FICTIONAL FIXTURES ONLY | No real institution/provider contact details or external source acquisition under the current private scope. |
| CS-05 | ACCEPT CURRENT BOUNDARY | No child/student/guardian communication, registration, UGC, reviews, moderation intake or participant activity. Any new feature requires separate authorization. |

This is an internal Product Owner scope decision, not a legal conclusion about age-related applicability in all jurisdictions and not a professional safeguarding certification. The product does not target children or plan to collect child data; the repository review remains bounded to the inspected baseline and current feature paths.

This repository review cannot establish:
- Applicable child/minor age definitions or legal obligations in any jurisdiction.
- Whether the eventual product is legally considered child-directed or likely to be accessed by children.
- Whether any future dataset contains personal, sensitive, education, religious-affiliation or child-related information.
- Whether every field registry, source-ingestion, export, log, backup, cache, admin or future API path applies equivalent controls.
- Actual hosting region, processors, runtime configuration, log destinations, access roster, retention or deletion behavior.
- Whether future content publication has adequate source rights, institutional authority, accuracy and contact-safety review.

No assumption about these matters should be inferred from synthetic tests or the current unprovisioned state.

## 6. Continuing controls

- Keep current development and any separately authorized acceptance activity synthetic-only and institution/provider-only.
- Do not add child/student/guardian fields, accounts, profile types, registration, messaging, tracking, content or participation features.
- Keep Deeni Madaris default-OFF and excluded from anonymous public projections.
- Treat any future proposal to change these boundaries as a new scope request requiring explicit owner authorization and a fresh review.

## 7. Current gate status

M3-11-02 remains IN PROGRESS for the wider privacy package. The Product Owner has explicitly excluded children and child-related data from the current product scope, so a child-data collection feature is not a pending product decision. The repository evidence is bounded to the inspected code/tests and does not establish target-specific privacy facts or complete every possible future data path.

No environment provisioning, real-data processing, participant activity, external service, spend, deployment, public pilot or launch is authorized. Deeni Madaris remains default-OFF with zero public exposure.


## 8. Product Owner review and repository visibility reconciliation — 2026-11-20

The Product Owner's internal ten-question review and Decisions 1–3 are complete and consolidated in [M3-11-02 Product Owner Internal Data and Privacy Review](M3-11-02_OWNER_INTERNAL_DATA_PRIVACY_REVIEW_2026-11-18.md). The Product Owner reaffirmed that the current scope excludes child/student/guardian data and child participation; this is an owner scope decision, not a jurisdiction-wide legal conclusion or independent safeguarding certification.

The GitHub source repository remains PUBLIC throughout development and WILL be changed to PRIVATE when development is complete under the binding Product Owner visibility decision. This source-repository visibility does not make the application public, authorize a pilot or release, or alter the separate restricted/private acceptance-environment boundary.

The inspected repository evidence remains bounded to the files, routes, tests and baseline identified in this review. No uninspected route, export, log, backup, runtime, hosted environment or future product surface is certified by this record.

**Owner review status:** COMPLETE for the decisions recorded in the consolidated owner review. **Independent safeguarding/legal/privacy assessment:** not represented as completed by this owner exercise. Any gate that explicitly requires independent professional assessment remains evidence-dependent; the owner is not asked to repeat accepted scope decisions.
