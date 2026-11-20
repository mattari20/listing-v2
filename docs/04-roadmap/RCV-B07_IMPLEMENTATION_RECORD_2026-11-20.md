# RCV-B07 — Fail-Closed SEO and Crawl Controls Implementation Record

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Branch:** feat/rcv-b07-fail-closed-seo-controls  
**Status:** Implementation submitted for exact-head validation; no deployment or indexing activation.

## 1. Approved policy

The Product Owner approved: (a) indexing stays disabled until a public canonical origin and release are separately approved; (b) stable English/Urdu equivalents may be indexed only when URL equivalence is verified; and (c) numeric SLOs remain unset pending synthetic measurements and review.

## 2. Delivered implementation

- Added config/seo.php with SEO_INDEXING_ENABLED default false and SEO_CANONICAL_ORIGIN default empty.
- Added DirectorySeoMetadata to validate an HTTPS origin and construct canonical/hreflang URLs exclusively from that trusted origin. It rejects URL credentials, non-root paths, query strings and fragments, invalid hosts and invalid ports.
- Added SearchEngineVisibility global middleware. It sets X-Robots-Tag on every response, including private-preview denials. Private preview receives noindex,nofollow; disabled/unconfigured indexing fails closed to noindex,follow; non-indexable routes and comparison remain noindex,nofollow.
- Registered the visibility middleware outside the private-preview gate so authentication-denial responses receive crawl-protection headers while Basic authentication remains the actual access boundary.
- Added conditional canonical and English/Urdu alternate links to directory landing/profile views only when indexing is explicitly enabled, a valid trusted origin exists, the route is stable and the query contains no search/filter/pagination parameters.
- Search/filter/pagination variants have no canonical or hreflang and remain noindex. Session-based comparison is always noindex,nofollow and has no canonical/alternate metadata.
- Request Host and APP_URL are not used to build canonical links. No source facts are used to construct new descriptions.
- Added synthetic-only feature tests for default-off behavior, preview denial response headers, trusted-origin canonical and alternates, profile equivalence, search query variants, invalid origin and comparison exclusion.

## 3. Explicitly deferred

- No sitemap generator or sitemap route: it remains gated on a future approved public origin/release and a verified bounded enumeration of eligible current public projections.
- No public robots.txt crawl policy, production URL, search-engine submission, public indexing activation, deployment or cutover.
- No performance benchmark harness in this code slice; a synthetic-only measurement harness is a separately bounded follow-on. No numeric SLO or capacity claim is made.
- No analytics, external SEO tool, CDN, vendor, dependency, paid service, real/source data, production/Hostinger/V1 access, database/schema/migration changes or Deeni Madaris policy changes.

## 4. Validation record

Pending exact-head Project documentation validation and FND-01 PHP 8.5 CI. Final test count, assertions, warnings, run IDs and merge commit will be recorded after required checks complete.