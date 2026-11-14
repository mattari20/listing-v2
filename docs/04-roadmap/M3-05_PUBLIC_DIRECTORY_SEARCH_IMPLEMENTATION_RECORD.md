# M3-05 — Public Directory and Search Implementation Record

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Status:** MERGED AND VALIDATED — PR #189; exact-head PHP 8.5 foundation CI and Project documentation validation passed  
**Baseline:** `1dd0b89084a45c3b89ad2663760964522b5c6ff6`  
**Branch:** `feature/m3-05-public-directory-search`
**Validated PR head:** `1e4bd3be1d92ca1ba3a06fd7190d3a20de340c58`
**Merged commit:** `8a89c5666501e5cc1f8565b32fd40a2a3370d634`

## 1. Authorization and boundaries

The Product Owner authorized M3-05 implementation and closeout on 2026-11-14 for the bounded scope in the M3 master plan. Work is limited to repository-local application code, synthetic fixtures and local/CI validation. It does not authorize real/source data, production access, V1, Hostinger/hPanel, external services, public release, deployment or additional spend.

## 2. Delivered candidate

- Anonymous `GET /directory` browse/search route and UUID profile route.
- Server-rendered, responsive HTML with native search/category controls, semantic structure and no external assets.
- Read-only `PublicDirectoryQueryService` over approved public projections.
- Explicit allowlist for identity, overview, public contact/location and education classification predicates.
- Eligibility checks for approved projection/decision, directory/anonymous surface, projected snapshot, accepted current claim version, latest snapshot, active suppression, eligible evidence and current source authorization.
- Fail-closed exclusion for Deeni Madaris, authority-only entities, unapproved/unknown predicates and ambiguous public names.
- Category facets are derived from the eligible anonymous population. Observation dates are displayed only when present; no freshness threshold is invented.

## 3. Validation and merge evidence

Both required checks passed on exact PR head `1e4bd3be1d92ca1ba3a06fd7190d3a20de340c58`:

| Check | Run | Result |
|---|---:|---|
| FND-01 PHP 8.5 foundation CI | [#43557559498](https://github.com/mattari20/listing-v2/actions/runs/43557559498) | **SUCCESS** |
| Project documentation validation | [#43557559518](https://github.com/mattari20/listing-v2/actions/runs/43557559518) | **SUCCESS** |

Foundation CI passed Composer manifest/install, dependency advisory audit, Pint formatting, Laravel bootstrap/routes, the synthetic suite and repository artifact hygiene. The full suite reported **351 assertions, no test failures and 107 non-fatal warnings** caused by the existing test harness attempting to read the intentionally absent local `.env` file. No `.env`, database or dependency artifact was added.

The first CI attempt exposed a missing tracked Blade compiled-view directory. The branch added `storage/framework/views/.gitignore`; the rerun passed. Review-thread inspection found no unresolved threads and no submitted reviews. PR #189 was squash-merged with expected-head SHA `1e4bd3be1d92ca1ba3a06fd7190d3a20de340c58`, producing merge commit `8a89c5666501e5cc1f8565b32fd40a2a3370d634`.

M3-05 is complete for its bounded synthetic local/CI scope.

## 4. Deferred boundaries

M3-06 owns geography, locality hierarchy, precise-location privacy and maps. Search engine selection, transliteration/fuzzy matching, ranking, recommendations, comparison, reviews, accounts, saved lists, alerts and admissions application remain outside this step. M3-09 owns performance/load, formal accessibility, security and operational hardening. Production release remains separately gated.

## 5. Safety declaration

No V1, Hostinger/hPanel, production/live database, real/source/provider/student/person data, source acquisition, external API/AI, map/geocoder, deployment, procurement or additional spend was used.
