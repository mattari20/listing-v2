# RCV-B07 — Bounded Implementation Authorization: Fail-Closed SEO and Crawl Controls

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Baseline main:** a7209161fb1a35fb56d0e20b8a8212605c37d5fa  
**Branch:** feat/rcv-b07-fail-closed-seo-controls  
**Status:** Product Owner policy decisions approved; implementation authorized for this exact repository-only slice.

## 1. Product Owner decisions recorded

The Product Owner approved:
1. No indexing until a public canonical origin and public-release decision are separately approved. In a later approved release, only the stable directory landing and eligible public profiles may be indexed. Search, filter, pagination and session comparison are non-indexable.
2. English and Urdu may be independently indexable equivalents only when their stable URLs are verified as the same underlying public resource. Hreflang must not be inferred for unverified equivalence.
3. Numeric performance SLOs remain unset until a synthetic measurement report and its assumptions are reviewed. M2-S09 provisional values are not adopted.

## 2. Exact authorized implementation

Repository/local/GitHub CI only. Implement a first-party, fail-closed SEO visibility layer:
- Add explicit configuration for indexing enablement and a trusted canonical origin. Both default to disabled/unset.
- Validate canonical origin strictly as an HTTPS origin with no credentials, path, query or fragment. Do not derive it from request Host, APP_URL, or any other inferred domain.
- Add a global response middleware that emits X-Robots-Tag: noindex, follow while indexing is disabled or the canonical origin is invalid/unset.
- When private preview is enabled, emit the stricter X-Robots-Tag: noindex, nofollow for all responses, including authentication failures; preserve HTTP Basic authentication as the actual access boundary.
- Only if indexing is explicitly enabled and a valid trusted origin is configured may stable, clean directory landing/profile pages become indexable. Search/filter/pagination variants, comparison, health, authenticated and mutation routes remain non-indexable.
- Emit canonical and hreflang links only for those clean stable landing/profile pages, using the trusted origin and the verified English/Urdu query variants. Do not include user search terms, filters, pagination, shortlist IDs or session data.
- Keep all HTML titles/descriptions escaped and localized. Do not generate profile descriptions from unapproved facts.
- Preserve current search, locality, filters, shortlist, comparison, language session and public-projection behavior.
- Add focused feature tests for defaults, invalid origin, request Host poisoning, preview authentication responses, stable vs query-variant indexability, comparison non-indexability and English/Urdu canonical/hreflang equivalence using a reserved synthetic test domain.

## 3. Exact expected files

- config/seo.php — new fail-closed configuration.
- app/Http/Middleware/SearchEngineVisibility.php — response-level crawl/indexability policy.
- app/Services/Directory/DirectorySeoMetadata.php — trusted-origin validation and stable canonical/alternate URL construction.
- bootstrap/app.php — register middleware in an order that also decorates private-preview denial responses.
- app/Http/Controllers/PublicDirectoryController.php — pass safe metadata to stable landing/profile views only.
- resources/views/directory/index.blade.php, show.blade.php, compare.blade.php — render conditional canonical/hreflang and page-specific robots metadata without changing page behavior.
- tests/Feature/DirectorySeoMetadataTest.php — synthetic-only acceptance coverage.
- docs/04-roadmap/RCV-B07_IMPLEMENTATION_RECORD_2026-11-20.md — implementation evidence and exclusions.

No other application files should change without an amended scope.

## 4. Explicitly not authorized in this slice

- No public hostname selection, production URL, public indexing activation, search-engine submission, deployment, cutover, Hostinger/V1/production access.
- No sitemap generation or robots.txt policy that assumes a public origin. Sitemap is deferred until public origin and public-release eligibility are separately approved and a safe bounded public-projection enumeration contract is verified.
- No real institution/source/student/guardian/staff data, external source access, crawling or scraping.
- No analytics, tracking pixels, CDN, external SEO tools, monitoring vendors, load-testing services, external APIs, AI or new dependencies.
- No numeric SLO, production capacity claim, production telemetry or hosting change.
- No database, migration, schema, publication, suppression, rate-limit or Deeni Madaris policy changes.
- No automatic translation of source facts.

## 5. Validation and merge protocol

- Exact-head Project documentation validation and FND-01 PHP 8.5 foundation CI must both pass.
- Run the full synthetic-only test suite; record test count, assertions and warnings.
- Fix in-scope failures on the same branch and rerun exact-head checks.
- Merge automatically when the exact PR head is mergeable and both required workflows pass.
- Update the roadmap, documentation catalogue, README, traceability and progress report after implementation merge.
- No deployment follows merge.

## 6. Follow-on agenda

Sitemap generation remains gated on a future approved canonical origin and a verified bounded enumeration of currently eligible public projections. The synthetic performance workload/measurement harness is a separate follow-on implementation slice; its results must not be represented as production capacity. Numeric SLOs remain unset pending review.