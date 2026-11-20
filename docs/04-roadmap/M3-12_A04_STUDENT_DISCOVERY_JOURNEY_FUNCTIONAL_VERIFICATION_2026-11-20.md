# M3-12 Agenda 04 — Student Discovery Journey Functional Verification

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline main:** `44397a2b65da77541cf1ff1358518c4278a2e865`  
**Work type:** Read-only repository source, route, view and synthetic-test inventory  
**Status:** COMPLETE for bounded repository-level functional verification; full student journey and browser acceptance are not established.

## 1. Purpose and boundary

Verify the existing student-facing discovery path without rebuilding capabilities already delivered by RCV-B02 through RCV-B08. This agenda checks public discovery, filters, manual locality, profiles, programme-offer facts, temporary comparison, account-owned saved items and their privacy boundaries.

This is a source/test review, not a fresh test execution or live user study. Only synthetic fixtures and repository evidence were examined. No real student, institute or source data was accessed.

## 2. Evidence examined

- `routes/web.php` and `PublicDirectoryController`.
- `PublicDirectoryQueryService`, `PublicDirectoryComparisonService` and `PublicProgrammeOfferFactsQueryService`.
- `AccountSessionController` and `AccountSavedItemsController`.
- Directory index, profile, comparison and saved-items Blade views.
- `PublicDirectoryTest` (33 test methods), `ProgrammeOfferFactWorkflowTest` (7), `AccountSavedItemsTest` (7) and `AccountSessionTest` (7).
- RCV-B02, RCV-B03, RCV-B04 and RCV-B08 implementation closeouts and accepted scope records.
- Current M3-05 and M3-06 implementation records.

Test-method counts are an inventory of source declarations; they are not a new test run, branch-coverage result or proof of browser acceptance.

## 3. Findings

### 3.1 Discover and narrow results

- Anonymous `GET /directory` supports text search, entity category, manual province/district/city/locality and up to 12 registry-backed filters.
- Search facts are restricted by approved public projection and exact field-definition search/filter flags. Unknown or unavailable filter values fail closed.
- Search and locality are bounded substring matching. The documented product boundary excludes fuzzy/typo correction, transliteration, semantic search and relevance ranking.
- Category facets, active-filter display, clear-all and pagination preservation have synthetic regression coverage.
- Deeni Madaris remains excluded from results, facets, profiles and shortlist.

**Disposition:** PASS for the implemented bounded search/filter contract; PARTIAL for a broader guided or semantic discovery journey.

### 3.2 Inspect profiles and admissions facts

- Public profiles resolve only currently eligible approved public facts.
- Programme-offer facts are cycle- and offer-specific and retain delivery-location association, effective/observation context and explicit known/unknown/not-stated/conflicting/withdrawn states.
- Synthetic tests cover offer isolation, zero-fee semantics, stale facts, correction/supersession, withdrawal, unknown-state distinction and source-authorization revocation.
- The current surface is informational. It is not an admissions application, eligibility calculator, fee estimator, scholarship application, deadline reminder or messaging workflow.

**Disposition:** PASS for read-only approved synthetic profile and offer-fact projection; PARTIAL for a complete student admissions decision service.

### 3.3 Shortlist, compare and save

- Anonymous shortlist is session-only, same-entity-type and bounded by a configurable maximum.
- Comparison uses approved public profiles and provides a like-for-like table; missing values are shown as not stated rather than treated as zero.
- Account-owned saved items are separate from the anonymous session shortlist. They require an existing pre-provisioned active/verified account; guests are denied.
- Saved items are owner-scoped, idempotent, bounded, rechecked against the current public projection and private/no-store/noindex. Stale records do not disclose old profile details.
- Public registration, account recovery/closure UI, public sharing, alerts and external notification delivery remain deferred.

**Disposition:** PASS for the delivered session-only shortlist/comparison and private saved-item slices; PARTIAL for the broader long-term save/share/alert goals.

## 4. Residual gaps

1. No pathway wizard or guided next-step journey is evidenced.
2. No fuzzy, transliterated, semantic or relevance-ranked discovery is implemented.
3. No device geolocation, distance sorting, maps, geocoder or authoritative locality hierarchy is active.
4. No application submission, applicant workflow, payment, messaging, reminder or alert delivery exists.
5. Account access is limited to existing pre-provisioned active/verified accounts; public self-registration and recovery are absent.
6. No real-world institute/admissions fact accuracy or source freshness validation was performed.
7. No browser/end-to-end, usability or manual accessibility review was performed by this agenda.
8. No live user/student/guardian research or participant testing was performed or authorized.

## 5. Acceptance criteria and result

| Criterion | Result |
|---|---|
| Reconcile discovery routes, filters, profiles and locality against current code | MET |
| Verify public projection and restricted-category boundaries in test source | MET |
| Reconcile offer-scoped admissions facts and explicit unknown/zero semantics | MET |
| Verify shortlist/comparison and saved-item privacy contracts in test source | MET |
| Distinguish implemented slices from deferred student journey goals | MET |
| Freshly execute the test suite or perform browser/participant acceptance | NOT PERFORMED |

**Agenda disposition:** COMPLETE for repository-level functional verification of the bounded student discovery foundation. This does not constitute complete student journey acceptance or M3-11 release acceptance.

## 6. Follow-through

- Preserve the current approved-public-projection and offer-scoped governance boundaries.
- Do not duplicate search, comparison, locality, admissions facts or saved-item implementations.
- Carry pathway guidance, semantic search, account lifecycle, applications and notifications as explicit residual product gaps; do not silently treat them as delivered.
- Continue with M3-12 Agenda 05 — Administration and Editorial Operations Verification.

## 7. Explicit exclusions

No application/schema changes, migration execution, database connection, real/source/student/institute data, source retrieval, external API/AI, maps/geocoding, user or participant contact, Hostinger/hPanel/V1/production access, backup/restore, deployment, public launch, new dependency/vendor or spend.

**Final result:** BOUNDED STUDENT DISCOVERY FOUNDATION VERIFIED BY SOURCE AND TEST INVENTORY; FULL STUDENT JOURNEY AND BROWSER ACCEPTANCE NOT ESTABLISHED.
