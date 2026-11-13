# M3-01 P04 — Hostinger-Constrained V2 Architecture and Delivery Schedule

**Date:** 2026-11-13  
**Status:** Conditional planning recommendation — Product Owner versioned-stack approval pending  
**Hosting constraint:** Existing Hostinger Premium only; no new spend  
**Implementation authorization:** NOT ISSUED  
**Data boundary:** Synthetic fixtures only for any future initially authorized build

## 1. Purpose and decision context

This document converts the accepted M2 logical architecture, the Product Owner's existing-host capability confirmation and the zero-new-spend hosting constraint into a practical V2 implementation direction.

The Product Owner confirmed that PHP/CLI, Composer, PHP-extension support, the hosted MySQL-compatible database service, SSH, cron and the current deployment/file-management workflow are already used by V1 on the same Hostinger Premium environment. This is owner-supplied evidence only. V1 is not accessed and must not be inspected or modified.

The confirmation is sufficient to continue architecture planning. It does not prove exact versions/limits, V2 isolation, spare capacity, V2 backup/restore, or Laravel-specific compatibility.

## 2. Recommended initial technical direction

| Layer | Conditional recommendation | Decision status / guardrail |
|---|---|---|
| Hosting | Existing Hostinger Premium Web Hosting | Owner-approved no-new-spend constraint; no upgrade/VPS/add-on |
| Backend | Laravel 13 on PHP 8.5 | Recommended target, not yet final; confirm PHP CLI/web parity and Laravel 13 extension/runtime requirements before implementation |
| Compatibility fallback | Laravel 12 only if Laravel 13 cannot be supported on the actual V2 runtime | Requires explicit owner decision; do not silently change framework major version |
| Database | Hostinger-provided MySQL-compatible service (MySQL or MariaDB as actually supplied) | Product family accepted as candidate; exact engine/version, quotas and separate V2 database availability remain to be checked |
| Application shape | Modular monolith | Retain M2 logical module boundaries; one deployable application initially |
| Public frontend | Laravel server-rendered Blade/HTML with progressive enhancement | Keep JavaScript small; no SPA requirement |
| Search | Database-native indexed search and bounded query patterns | No Elasticsearch/OpenSearch/vector database initially; benchmark bilingual/Urdu relevance later |
| Geography | Normalized province/district/locality fields; optional coordinates only if approved and lawfully sourced | No PostGIS, paid geocoding or mandatory map dependency |
| Background tasks | Bounded cron-triggered commands only where essential | No always-on workers, Redis, queue broker or agent process |
| AI | Fully disabled in the initial build | No model/API/agent/vector store; core directory and steward workflows must operate without AI |
| Media | Existing hosting storage with conservative upload limits and approved formats | No paid object storage/CDN; uploads remain disabled until rights/security controls are approved |

**Recommendation:** use Laravel 13/PHP 8.5 + the existing Hostinger MySQL-compatible database as the leading initial candidate, with server-rendered HTML and a modular monolith. This is a planning recommendation, not a final versioned-stack decision or implementation authorization.

## 3. V2 isolation and deployment boundary

The V2 application must be independently isolated even though V1 and V2 may share one hosting subscription.

### Required separation

1. **Code:** V2 source and dependencies live in a V2-only directory/repository checkout. No V1 source files are copied or modified.
2. **Web exposure:** only the V2 framework's public entry directory may be web-accessible. Application source, dependency internals, logs, cache, uploads not intended for public access and environment files must remain outside the public document root.
3. **Routing:** prefer a dedicated V2 subdomain/document root mapped to the V2 public directory if the existing plan supports it without additional spend. A path-prefix subfolder is a fallback only after confirming it can route safely without changing V1 behavior or exposing the Laravel project root.
4. **Database:** V2 must use a newly provisioned, separately named V2 database and a dedicated least-privilege database user. Never reuse, connect to, query, export or alter the V1 database.
5. **Configuration/secrets:** V2-only environment configuration, credentials and application keys. No secrets in GitHub, source files, public directories, screenshots or chat.
6. **File permissions:** V2-only writable storage/cache paths; no shared writable application directories with V1.
7. **Scheduled tasks:** any future cron entry must call only V2-owned code and use V2-only configuration. No task is created during planning.
8. **Deployment:** V2-only release process, pre-deployment checks, backup of V2-owned state, smoke checks and rollback plan. Do not modify V1's deployment process.
9. **Observability:** V2-specific logs and resource monitoring with credentials and personal data excluded.
10. **Stop condition:** if V2 isolation requires risky changes to V1 routing, shared PHP settings, V1 files or V1 database, stop and redesign. No V1 change is an acceptable shortcut.

### Preferred topology (conceptual only)

```text
Existing Hostinger Premium subscription
|
+-- V1: existing website (untouched; no access)
|
+-- V2: dedicated isolated application area
    +-- private application source and dependencies
    +-- public document root -> V2 public entry point only
    +-- V2-only environment/secrets
    +-- V2-only MySQL-compatible database + DB user
    +-- V2-only storage/cache/log paths
    +-- optional bounded V2 cron (only if later approved)
```

The topology is a target design, not a verified Hostinger configuration. Do not create a subdomain, directory, database, user, cron job, deployment or PHP setting as part of this planning task.

## 4. Application module boundaries

Keep one deployable Laravel application while enforcing explicit code and authorization boundaries:

| Module | Initial responsibility | Initial exclusions |
|---|---|---|
| Public directory | Anonymous browse, search, institution/campus/programme profile projections | No accounts required for discovery; no private evidence |
| Education domain | Institution, campus, programme and qualification concepts | No bulk import or real provider records |
| Evidence and provenance | Synthetic evidence references, source metadata model and temporal assertions | No external source access or ingestion |
| Review and publication | Human approval state transitions and publication eligibility | No automatic AI publication |
| Policy and visibility | Centralized publication/suppression policy | Deeni Madaris Show remains default-OFF; no public side-channel exposure |
| Administration | Restricted synthetic-data stewardship interface | No public admin route or shared V1 login |
| Search | Bounded database-native queries and indexes | No external search provider |
| Operations | Health checks, structured privacy-minimized logs and bounded maintenance tasks | No always-on process or external monitoring spend |

Do not implement every future module in the first slice. The first authorized build should prove the repository/application foundation and safety boundaries before domain features are added.

## 5. Security, privacy and governance invariants

- Anonymous-first public discovery; collect no student personal data in the initial build.
- No child accounts, reviews, user-generated content, messaging, payments or admissions submission in the initial slice.
- Deeni Madaris Show is default-OFF and must be excluded from public search, browse, counts, facets, maps, recommendations, sitemaps, exports, caches, APIs and direct-ID lookups.
- No universal institute score or opaque ranking.
- Synthetic fixtures only; do not use copied, transformed or anonymized V1 records.
- Source families remain RESEARCH ONLY; no scraping, automated collection or republication.
- AI, maps, geocoding, vector search and external APIs remain disabled.
- Human approval is required for high-impact facts and publication.
- Keep audit trails for privileged actions; logs must not contain secrets or unnecessary personal data.
- Any later personal/child data, real source data, public release or production operation requires applicable qualified review and a separate owner gate.

## 6. First implementation slice after separate authorization

The recommended first package is a bounded **V2 foundation only**:

**Included, if separately authorized**
- Independent V2 application scaffold in the V2 repository.
- Selected Laravel/PHP runtime baseline and reproducible dependency lock.
- Local development and CI configuration using synthetic fixtures only.
- Configuration/secret boundaries and a documented environment template without real secrets.
- Minimal module skeleton and a safe public health endpoint.
- Static/documentation checks, dependency/lifecycle checks and minimal automated smoke tests.
- Synthetic-only test data and tests for default-OFF suppression.
- Build and deployment documentation; no actual Hostinger deployment in this package.

**Excluded**
- V1 access or changes; production data or source data.
- Real institute records, scraping, source ingestion or personal data.
- Database schema/migrations or creation of a live Hostinger database.
- Public directory launch, admin users, reviews, identity, uploads or messaging.
- AI, external APIs, maps, geocoding, vector search, persistent workers or paid services.
- DNS/subdomain creation, account changes, production deployment, pilot or launch.

The exact branch, files, commands, package versions, environment and acceptance tests must be listed in a separate implementation authorization. This document does not issue that authorization.

## 7. Delivery sequence and realistic planning range

The schedule below is a planning range for one Product Owner/builder using ChatGPT assistance, with an availability baseline of approximately 10–15 hours per week that is flexible and is **not** treated as proven engineering capacity. Actual elapsed time depends on learning, review cycles, hosting constraints and qualified external assessments.

| Stage | Indicative effort | Indicative calendar range | Exit evidence |
|---|---:|---:|---|
| A. Close M3-01 planning gates | 15–30 focused hours plus reviewer lead time | 2–5 weeks | P04 stack direction accepted; P05 applicable review dispositions; P06 final environment/test plan; P07/P08 owner decision |
| B. V2 foundation (after authorization) | 25–45 focused hours | 3–6 weeks | Reproducible local/CI build, isolated configuration model, synthetic fixtures, smoke tests and documented stop conditions |
| C. Core data governance and steward workflow (separate scope approval) | 35–60 focused hours | 4–8 weeks | Synthetic domain/evidence workflow, temporal facts, human review and publication policy tests |
| D. Public directory and database-native search (separate scope approval) | 35–60 focused hours | 4–8 weeks | Anonymous HTML-first browse/search/profile with suppression and privacy regression tests |
| E. Hardening and pilot-readiness assessment | 30–50 focused hours plus qualified review time | 4–7 weeks | Security/accessibility/performance/recovery evidence, defect closure and a separate pilot decision |

Stages C–E are not automatically authorized by approval of Stage B. They require scope review and their own gates. The calendar ranges are not promises and should be recalibrated after Stage B has actual build/test data. A first synthetic foundation may be achievable in roughly 1–1.5 months after authorization; a controlled directory pilot is more plausibly a multi-month effort after all legal, source, security, capacity and recovery gates are satisfied. Public production launch is not scheduled by this document.

## 8. Remaining P04 closure evidence

P04 can be recommended for owner acceptance once the following are resolved:

- Owner explicitly approves or changes the conditional Laravel 13/PHP + MySQL-compatible stack direction.
- At implementation time, read-only checks confirm the V2 PHP CLI/web runtime, required extensions, Composer version and actual DB engine/version/limits.
- A safe V2 public document-root/subdomain or path-prefix strategy is evidenced without modifying V1.
- A separate V2 database and least-privilege DB identity are confirmed available before any schema work.
- Resource headroom is assessed with a V2-only synthetic test under a separately authorized scope.
- V2 backup/restore design is documented and later rehearsed with V2-owned synthetic data under separate authorization.
- No-new-spend remains feasible; any shortfall is deferred rather than solved by an unapproved purchase.

The Product Owner's confirmation removes the need for screenshots to prove general PHP/Composer/SSH/cron/database/deployment availability. Any future linking of the Hostinger account or safe command output should be requested only when a specific version, quota, isolation or recovery fact is genuinely required.

## 9. Decisions requested from the Product Owner

1. Accept Laravel 13/PHP 8.5 + the existing Hostinger MySQL-compatible database as the **preferred conditional initial stack**, subject to the exact V2 checks above; or request a change.
2. Accept the isolation principle: dedicated V2 public document root/subdomain preferred; V2-only code, secrets, database/user and storage; V1 untouched.
3. Accept the staged schedule as a planning baseline only, to be recalibrated after the first authorized build.

No response to this document, including approval of its planning direction, will itself authorize implementation. A separate explicit implementation-start authorization is still mandatory.

## 10. Authorization status

**Implementation authorization: NOT ISSUED.**  
**Spend authorization: NONE — no new spend.**  
**P04 status: OPEN pending owner stack decision and V2-specific evidence.**  
**M3 overall progress: 5%; no M3-01 weighted completion claimed.**
