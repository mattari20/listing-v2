# RCV-B07 — Public SEO and Performance Evidence: Scope and Acceptance Pack

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` after RCV-B06 closeout merge `2e24fd4e2b48b23a49a3dc012d48523103612d65`  
**Agenda:** RCV-B07 — Public SEO and Performance Evidence  
**Status:** Repository inventory and policy decisions COMPLETE; fail-closed SEO controls (B07-B) and synthetic performance measurement (B07-D) IMPLEMENTED AND MERGED in PRs #335 and #337. Sitemap generation remains gated on a future approved public origin/release; numeric SLO adoption remains pending representative evidence and owner review. No public indexing activation or production URL is authorized.

## 1. Why this agenda is next

RCV-01 lists RCV-B07 as the next P2 residual package after RCV-B06. Its defined scope is metadata/canonical/sitemap strategy, crawl controls, representative load/capacity methodology and an owner-approved SLO.

The RCV-01 precondition is explicit: no production URL/cutover, and numeric SLOs require owner approval and capacity evidence. This pack is repository planning and evidence review only.

## 2. Repository baseline inspected

### 2.1 Public routes and rendered pages

- `GET /directory` is the anonymous search/listing route, named `directory.index`, with a 60-per-minute route throttle.
- `GET /directory/{entity}` is the anonymous profile route, named `directory.show`, with a 60-per-minute route throttle.
- `GET /directory/compare` is session-dependent comparison, named `directory.compare`, with a 30-per-minute route throttle.
- Shortlist add/remove are session-mutating POST/DELETE routes; they are not content pages for indexing.
- Search accepts bounded query parameters for text, type, locality, registry filters and page; pagination preserves query parameters.
- The three public directory views are server-rendered HTML, include a title and meta description, and contain no required external JavaScript or remote asset dependency.
- Directory and comparison titles/descriptions are generic localized strings. Profile title includes the profile name, while its description is a generic profile description.
- The inspected page heads contain no canonical link, hreflang alternate, Open Graph or Twitter card metadata, robots meta directive or structured-data markup.

### 2.2 Crawl and URL controls

- `public/robots.txt` exists but is empty.
- No `sitemap.xml` file, route, generator or sitemap test was found in the inspected repository tree.
- No trusted canonical-origin configuration or canonical URL builder was found.
- Language selection uses the `lang` query parameter and the English/Urdu views declare the corresponding HTML language and text direction.
- The comparison page is derived from the visitor's temporary session shortlist and is not a stable public resource.
- Search, filter and pagination URLs can produce many query-string variants of the same directory route.

### 2.3 Private-preview and security controls

- `PrivatePreviewAccess` is global middleware.
- `PRIVATE_PREVIEW_ENABLED` defaults to false; when enabled, requests require configured HTTP Basic credentials.
- Failed/unconfigured preview authentication responses use `Cache-Control: no-store`; the inspected middleware does not add an `X-Robots-Tag` response header.
- Robots directives are not access control. A private preview must remain protected by authentication and environment isolation; crawl directives are supplementary only.
- The repository contains response security-header tests, including a restrictive Permissions-Policy that disables geolocation.

### 2.4 Existing performance evidence

- `PublicDirectoryTest` contains a deterministic query-count regression proving that query count remains constant as the synthetic result set grows.
- M3-09 Q03 records an empty-directory database query-count ceiling of eight.
- The existing public directory is paginated at 20 results per page.
- Route throttles are present on directory, profile and comparison GET endpoints.
- `config/cache.php` defaults to the in-memory `array` cache store.
- M2-S09 proposes a performance/capacity measurement model and provisional targets, but explicitly labels those targets hypotheses, not approved SLOs.
- No representative HTTP load test, production-like traffic model, measured latency distribution, approved throughput/capacity, browser real-user measurement, production telemetry or numeric owner-approved SLO was found.

These are repository observations. No public website, search engine, hosting account, production service, real dataset or external performance service was accessed.

## 3. Product and crawl policy — Product Owner approved

Recommended conservative first policy:

1. Keep all SEO/indexing behavior disabled until a future public canonical origin and separate public-release authorization are recorded.
2. For any separately approved public release, make only stable, approved public directory/profile resources eligible for indexing.
3. Mark query-string search, filtered/faceted, paginated variants and session-dependent comparison pages as non-indexable; preserve ordinary navigation and user functionality.
4. Generate a sitemap only after a trusted canonical origin is approved. Include only current, approved, publicly visible entities; exclude unpublished, suppressed, restricted, withdrawn, Deeni Madaris and session-dependent resources.
5. Build canonical URLs from an explicitly configured trusted origin, never from an arbitrary request Host header.
6. Keep English and Urdu language metadata truthful. Add hreflang only when stable, equivalent language URLs exist and can be verified; do not imply translated source facts.
7. During any private preview, retain authentication as the security boundary and add noindex/no-follow response protection as defense in depth. Do not rely on robots.txt to hide a protected preview.
8. Do not introduce analytics, tracking pixels, external SEO services, CDNs, paid tools or remote assets as part of this agenda.

No production hostname is inferred from other project domains or prior hosting discussions.

## 4. Proposed performance evidence method

Use a staged, reproducible, synthetic-only method without adding a paid service or dependency:

- **Functional baseline:** retain existing query-count regression, pagination tests, response/header tests and route behavior.
- **Dataset tiers:** define small, representative and stress synthetic fixture profiles. Their sizes and mix must be agreed before claiming representativeness; do not substitute real institutions or scraped data.
- **Workload model:** cover anonymous directory landing, common search, locality/filter search, profile reads, pagination and comparison reads. Keep mutating shortlist operations separate from anonymous read traffic.
- **Measurements:** record PHP/application response time, database query count, response status/error rate, compressed and uncompressed HTML bytes, memory use where available, and concurrency level.
- **Repeatability:** record exact commit, PHP/Composer version, fixture manifest, command, warm/cold state, concurrency, repetitions and environment limitations.
- **Interpretation:** distinguish local/CI microbenchmarks from production capacity. Do not extrapolate CI timing to hosting capacity.
- **SLO decision:** present measured baselines and assumptions to the Product Owner. Set numeric p50/p95/p99, throughput, error-rate, availability or payload budgets only after owner approval and capacity evidence.

Do not add brittle wall-clock assertions to ordinary unit tests. A performance regression threshold must be justified by repeatable baseline evidence and explicit owner acceptance.

## 5. Implementation slice status

| Slice | Candidate deliverable | Authorization status |
|---|---|---|
| B07-A | Trusted canonical-origin and metadata design, indexability rules, language alternate policy | APPROVED; design recorded |
| B07-B | Environment-aware robots/noindex controls and canonical metadata with tests | IMPLEMENTED AND MERGED in PR #335 |
| B07-C | Conditional sitemap generation from approved public projections, with suppression/visibility tests | DEFERRED pending approved public origin/release and verified safe enumeration contract |
| B07-D | Reproducible synthetic workload/measurement harness and baseline report | IMPLEMENTED AND MERGED in PR #337; seven synthetic scenarios measured; no capacity claim |
| B07-E | Owner-approved SLO and capacity acceptance record | BLOCKED pending synthetic measurement review and separate owner approval |

Any code stage must be separately bounded to repository/local/GitHub CI, synthetic fixtures only, with exact files, test coverage and no production URL/cutover.

## 6. Acceptance criteria for RCV-B07

1. SEO metadata is accurate, localized and escaped; it does not expose internal fields or invent institutional facts.
2. Canonical URLs use a trusted configured origin and cannot be poisoned by the request Host header.
3. Indexability is explicit for directory landing, profiles, search/filter/pagination variants and comparison.
4. Sitemap output, if authorized, contains only eligible public URLs and excludes suppressed, unpublished, withdrawn, restricted and session-specific resources.
5. Preview authentication remains mandatory when enabled; robots/noindex is defense in depth, not access control.
6. Existing manual locality, search, filters, shortlist and comparison behavior is preserved.
7. English/Urdu language alternates are emitted only when URL equivalence is established.
8. Performance methodology uses documented synthetic fixture tiers and reproducible workload assumptions.
9. Query count, response bytes, latency distributions, errors and concurrency are reported with environment context.
10. Numeric SLOs are explicitly owner-approved and supported by representative capacity evidence; M2-S09 draft targets are not silently adopted.
11. No new external dependency, analytics, CDN, vendor, paid tool or spend.
12. No production/V1/Hostinger access, production URL, deployment, cutover or public indexing activation.

## 7. Explicit exclusions

- No production domain or canonical hostname selection by inference.
- No production URL, search-engine submission, indexing request or cutover.
- No production/Hostinger/V1 access or deployment.
- No real institution/source/student/guardian/staff data or external source access.
- No third-party crawler, SEO SaaS, analytics, CDN, monitoring vendor or load-testing service.
- No new dependency or spend.
- No numeric SLO adoption from M2-S09 draft proposals without owner approval.
- No weakening of preview authentication, security headers, rate limits, publication eligibility or Deeni Madaris default-OFF behavior.

## 8. Product Owner decisions — approved 2026-11-20

1. Confirm the proposed indexability policy: no indexing until a public origin/release is separately approved; later index stable public directory/profile pages only; noindex search/filter/pagination/compare.
2. Confirm whether the eventual public site should expose both English and Urdu as independently indexable equivalents, subject to verified equivalent URLs.
3. Confirm that numeric SLOs remain unset until the synthetic measurement report is reviewed; do not adopt M2-S09's provisional values automatically.

The Product Owner approved all three decisions unchanged. This approval enabled the exact bounded B07-B implementation authorization recorded in `RCV-B07_BOUNDED_IMPLEMENTATION_AUTHORIZATION_2026-11-20.md`. It does not authorize sitemap generation, public indexing activation, public-origin selection, production URL/cutover, performance SLO adoption or deployment.

## 9. Current disposition

The repository-only inventory, B07-B fail-closed crawl/SEO controls and B07-D synthetic measurement harness are complete for the approved scope. Indexing remains disabled by default and the canonical origin remains unset. The seven-entity SQLite microbenchmark is documented in the performance measurement record; it does not establish production capacity or SLOs. Sitemap generation is deferred pending an approved public origin/release and safe eligible-projection enumeration. Numeric SLOs remain unset pending owner review and representative capacity evidence. No deployment or public indexing activation is authorized.
