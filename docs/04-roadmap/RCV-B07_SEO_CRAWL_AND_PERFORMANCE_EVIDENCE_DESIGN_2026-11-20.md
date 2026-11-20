# RCV-B07 — SEO, Crawl Controls and Performance Evidence Design

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline main:** `2e24fd4e2b48b23a49a3dc012d48523103612d65`  
**Status:** Product Owner policy approved; fail-closed SEO/crawl controls implemented and merged in PR #335; sitemap and synthetic performance measurement remain gated follow-on slices.

## 1. Design principles

- **No implied public launch:** SEO metadata and sitemap design do not authorize production URL selection, deployment, search-engine submission or indexing.
- **Trusted origin:** canonical and sitemap URLs must be built from a deliberately configured canonical origin. Never trust an arbitrary inbound Host header to generate canonical links.
- **Fail-closed indexability:** if public indexing is not explicitly enabled or the trusted origin is absent/invalid, do not emit indexable canonical/sitemap URLs.
- **Publication is authoritative:** only currently approved public projections are candidates for indexing. Internal claims, evidence, audit, restricted categories, suppressed records and stale/unpublished states never become sitemap entries.
- **Stable resource identity:** directory/profile URLs may be indexable only under a future accepted URL contract. Search terms, filters, facets, pagination state and session comparison are not stable content identities.
- **Language truthfulness:** language metadata describes the rendered UI language; hreflang is emitted only for verified equivalent resources, never as a claim that institution-provided facts were translated.
- **Preview privacy:** HTTP Basic authentication and environment isolation are security controls. robots.txt and meta directives are advisory crawl controls, not confidentiality controls.
- **No third-party requirement:** first-party HTML metadata and static robots/sitemap output should not require analytics, remote assets, external SEO vendors or paid services.

## 2. Candidate URL policy

| Resource | Candidate indexing disposition | Rationale |
|---|---|---|
| Unfiltered directory landing | Index only after public-origin and release approval | Stable entry point, subject to public content approval |
| Individual public profile | Index only when current published projection is eligible | Stable public resource; must exclude suppressed/restricted entities |
| Search query URL | noindex, follow | User-generated query variant, not a unique editorial landing page |
| Filter/facet URL | noindex, follow by default | Avoid uncontrolled duplicate/crawl spaces; future curated landing pages need separate decision |
| Pagination page greater than first | noindex, follow by default; canonical policy to be confirmed | Avoid indexing arbitrary pagination variants; do not canonicalize distinct content incorrectly |
| Session comparison | noindex, nofollow | Derived from private visitor session; not a stable public resource |
| Shortlist mutation endpoints | Never index | State-changing POST/DELETE actions, not content |
| Health endpoints and authenticated routes | Never index | Operational/authenticated surface |

This table is a proposal for owner decision, not current runtime behavior.

## 3. Metadata contract

### Directory landing
- Localized title and concise localized description.
- Canonical link only when trusted canonical origin and public indexing are enabled.
- Optional Open Graph/Twitter metadata only if useful and fully first-party; no external image dependency.
- Robots directive derived from explicit environment/indexability policy.

### Profile
- Escaped title derived from the approved public display name plus a stable site descriptor.
- Description assembled only from safe, approved public projection fields; do not concatenate unbounded claims or internal evidence.
- Canonical link uses the stable profile route and trusted origin.
- No structured data until field mapping, entity types and freshness semantics are verified against a supported schema.

### Search and comparison
- Search/filter/pagination variants use explicit non-indexable policy.
- Comparison is session-dependent and must remain non-indexable.
- Do not expose shortlist IDs, session state or selected entities in canonical or sitemap URLs.

### English and Urdu
- Rendered `lang` and `dir` remain authoritative for each page.
- Hreflang requires a verified alternate URL for the same underlying public entity or directory landing. If either equivalent is unavailable, omit the alternate rather than fabricate it.

## 4. Crawl-control contract

- A future public `robots.txt` may advertise a sitemap only after the trusted canonical origin is configured and indexing is explicitly enabled.
- A private preview should remain authenticated; an environment-level noindex response header is an additional safeguard.
- Do not place secrets, private paths or credentials in robots.txt.
- Do not disallow a route as a substitute for authentication.
- Sitemap generation must be deterministic, bounded and based on the public read model, not raw claim/evidence tables.
- Sitemap entries should be excluded immediately when publication eligibility is revoked or suppression is applied; a sitemap must never become an alternate disclosure path.

## 5. Performance evidence contract

### Workload
Synthetic workload scenarios should cover:
- anonymous directory landing;
- common text search;
- category and locality filters;
- combined registry filters;
- profile reads with ordinary and offer-fact content;
- pagination at first and later pages;
- comparison read path with a synthetic session shortlist.

### Dataset
Use only fabricated fixture records and a versioned manifest. Define fixture tiers and entity/fact distributions before the benchmark. Do not use live institution counts or infer national capacity from a small preview fixture.

### Measurements
Capture, where available:
- request latency distributions (p50/p95/p99);
- requests per second and concurrency;
- HTTP status/error rate;
- database query count and slow-query identity;
- response body bytes (compressed and uncompressed);
- peak memory and CPU context;
- PHP/runtime/dependency versions and database driver;
- warm/cold cache state and exact fixture size.

### Reporting and thresholds
- Separate functional regression tests from benchmark measurements.
- Repeat runs and report variation; do not fail ordinary CI on noisy absolute wall-clock values.
- Use deterministic query-count/response-size bounds only where a stable, justified baseline exists.
- Do not treat GitHub-hosted CI timings as Hostinger capacity evidence.
- M2-S09 values (availability 99.5%, search/profile p95 1.5 s, p99 3 s, etc.) remain draft proposals and are not approved SLOs.
- The Product Owner approves numeric thresholds only after reviewing the workload assumptions and measured evidence.

## 6. Security, privacy and content safety

- Preserve global preview access middleware, security headers, rate limits and publication suppression.
- Do not cache restricted or suppressed data in a public layer.
- Do not add visitor analytics or user-level tracking to measure SEO/performance.
- Avoid storing full search terms or session shortlist values in benchmark telemetry.
- Do not add external scripts, pixels, fonts, maps or CDN dependencies.
- Do not publish sitemap URLs for session-dependent, unpublished, withdrawn, restricted or Deeni Madaris entities.

## 7. Implementation staging proposal

1. Product Owner confirmed indexability and language-alternate policy on 2026-11-20.
2. Owner identifies a future canonical public origin only when a public-release decision is appropriate; until then origin remains unset.
3. Prepare exact files and tests for first-party metadata, noindex preview behavior, robots output and sitemap eligibility.
4. Separately authorize a synthetic benchmark harness and fixture tiers; keep measurements explicitly local/CI.
5. Present results and assumptions for numeric SLO decision; do not implement production monitoring or capacity changes in this agenda.

The B07-B fail-closed SEO/crawl implementation was separately authorized and merged in PR #335. Sitemap and performance harness implementation remain separate gated slices.
