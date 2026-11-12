# M3-00 — Technology Stack Decision Framework

**Status:** Evaluation framework prepared; no final stack selected  
**Related task:** M3-00 T05 — Technology stack decision pack  
**Inputs:** Accepted M2 architecture baseline; M3-00 delivery/capacity and budget records  
**Scope:** Documentation and decision preparation only

## 1. Decision boundary

This document evaluates candidate technologies against Listing V2's documented requirements and delivery constraints. It does not select or install a framework, create an application, authorize a technical spike, provision infrastructure, activate a service, or approve spending.

M2's technology-neutral architecture remains binding. Candidate directions below are evaluation inputs, not decisions. A final selection requires evidence about the actual human implementer/maintainer skill profile, support and security lifecycle, hosting fit, total cost, and a separately approved synthetic-data proof-of-fit if one is needed.

## 2. Binding architecture and product constraints

The selected stack must preserve:

- Independent V2 implementation; no copying/adapting legacy V1 code, schema, APIs, data, architecture, UI or operational practices.
- Modular boundaries and explicit domain ownership; avoid premature microservices.
- Anonymous-first, low-bandwidth, search-engine-friendly public discovery with accessible HTML-first journeys.
- Multilingual Pakistan education data, including English/Urdu names, aliases, uncertain and time-bound assertions.
- Relational integrity, provenance, audit history, source-specific rights and human publication gates.
- Geography as a replaceable capability with privacy-conscious locality discovery.
- Deeni Madaris as a separate provider family, hidden by default in public outputs, with the authorized configuration control required by V2-DEC-006.
- Data minimization, minor safeguarding, least privilege, secure file/content handling, observability, backup/restore and a credible exit path.
- Maintainability by the confirmed delivery team, not just technical elegance.

## 3. Candidate comparison

### 3.1 Backend

| Candidate | Potential strengths | Risks / validation questions | Required evidence |
|---|---|---|---|
| Laravel / PHP | Integrated web framework, validation, queues, ORM and mature web ecosystem | Actual Laravel expertise; package governance; security patch discipline; long-term maintainer availability | Named implementer experience, supported-version policy, dependency audit plan, synthetic workflow proof-of-fit |
| Django / Python | Mature data/admin workflow ecosystem, ORM, validation and security facilities | Actual Django expertise; operational capability; admin/public UX separation; background-task choices | Named implementer experience, support policy, dependency audit plan, synthetic workflow proof-of-fit |
| NestJS / TypeScript | Typed modular service structure and shared language across tiers | More assembly for admin/workflow conventions; runtime and dependency governance; operational experience | Named implementer experience, support policy, dependency audit plan, synthetic service proof-of-fit |

**Current position:** no backend framework is selected. Do not decide based on language popularity or assumed owner skills. The first criterion is who can safely build, review, patch and maintain it.

### 3.2 Frontend rendering

| Candidate | Fit to V2 | Decision gate |
|---|---|---|
| Server-rendered HTML/templates with progressive enhancement | Strong default for SEO, low bandwidth, accessibility and simpler operations | Demonstrate public browse/search/profile journeys with JavaScript unavailable |
| Hybrid/partial enhancement | Suitable for filters, comparison and selected interactive workflows | Demonstrate measurable UX benefit without degrading keyboard access, performance or fallback behaviour |
| Full React/Next.js SSR application | Candidate only if product interaction complexity justifies another runtime/build system | Show a material user benefit that outweighs staffing, runtime, security and operational cost |

**Provisional direction:** HTML-first public surfaces with progressive enhancement. This is an architectural preference to validate, not a framework selection.

### 3.3 Database and geography

| Candidate | Fit | Decision gate |
|---|---|---|
| PostgreSQL with PostGIS | Strong candidate for relational integrity, complex relationships and spatial queries | Verify hosting support, version lifecycle, backup/restore, Urdu/English search needs, spatial query plans and team operations skill |
| MySQL-compatible / MariaDB | Possible alternative if team or hosting capability materially favours it | Verify constraints, spatial semantics, full-text behaviour, migration/exit risk and exact version support |

**Provisional direction:** PostgreSQL + PostGIS remains the M2 proof-of-fit candidate, not an approved physical schema or final database choice. No schema, migration or production database work is authorized.

### 3.4 Search

- Begin with database-native full-text and trigram/alias matching as a candidate baseline.
- Validate Urdu/English names, spelling variation, transliteration, locality and provider type, including Deeni Madaris default-OFF behavior.
- Add a dedicated search service only if representative synthetic-data tests show a material relevance, scale or latency need that outweighs synchronization, security and operations cost.
- Ranking must explain coverage and missing data; do not imply that unverified records are authoritative.

### 3.5 Maps, geocoding and background processing

- Keep maps, tiles and geocoding behind replaceable adapters; no provider is selected.
- Assess Pakistan coverage, terms, attribution, privacy, rate limits, caching, cost caps and fallback behaviour before a provider decision.
- Select a queue/background-processing mechanism only after the chosen framework, workload and operations ownership are evidenced.
- No third-party account, API key, connector, paid trial or service is activated by this evaluation.

## 4. Evaluation criteria and evidence standard

Do not use numerical scores where facts are missing. Compare each candidate against the same criteria:

1. Human skill fit: named implementer and maintainer experience, independent review capability and continuity.
2. Security lifecycle: supported versions, patch cadence, dependency advisories, secure defaults and vulnerability response.
3. Maintainability: clear module boundaries, testability, upgrade complexity and ease of handover.
4. Product fit: anonymous discovery, accessible HTML-first UX, multilingual search, data governance and geography.
5. Operations: hosting compatibility, deployment repeatability, backup/restore, monitoring and incident response.
6. Performance: representative Pakistan network conditions, low-bandwidth behaviour and expected data/query volume.
7. Total cost: engineering, hosting, storage, backups, bandwidth, monitoring, support, tax/FX and exit costs.
8. Portability: standard data export, replaceable integrations and manageable migration/exit path.
9. Legal/privacy: data location, processor terms, retention, access control, minor safeguarding and applicable review.
10. Evidence quality: official support documentation, current vendor terms, repeatable test results and dated quotes.

Evidence status must be labelled: Verified, Owner-confirmed, Measured, Quoted, Assumption, or Unknown. An unknown is not a pass.

## 5. Current provisional recommendation

Retain the M2 candidate baseline for further evaluation:

- Modular monolith, not microservices by default.
- HTML-first public rendering with progressive enhancement.
- Backend framework undecided among Laravel/PHP, Django/Python and NestJS/TypeScript until actual human skill coverage is known.
- PostgreSQL + PostGIS as proof-of-fit candidate; not final selection.
- Database-native search initially; dedicated search only if evidence requires it.
- Replaceable map/tile/geocoder adapters; provider undecided.
- Queue/background processing selected with the framework and operations owner, not in isolation.

This recommendation is conditional and creates no implementation authorization.

## 6. Decision dependencies and blockers

| Dependency | Current state | Effect |
|---|---|---|
| Named backend implementer and maintainer | Not confirmed | Blocks responsible backend framework selection |
| QA and security review capability | Not confirmed | Blocks implementation readiness |
| Owner budget ceiling / paid-service policy | Not decided; no new spend authorized | Blocks paid tools, hosting selection and cost-dependent choices |
| Hosting capability and current terms | Not verified | Blocks final database/provider compatibility decision |
| Pakistan performance and low-bandwidth measurements | Not measured | Blocks performance claims |
| Synthetic-data proof-of-fit authorization | Not granted | No spike or code is permitted |
| Legal/privacy review responsibility | Not named | Blocks data processor and service approval |

## 7. T05 acceptance criteria

T05 may be submitted for owner review when:

- Candidate options and trade-offs are compared against the same criteria.
- The actual human implementer/maintainer skill profile is recorded or explicitly accepted as a blocker.
- Support/security lifecycle and hosting compatibility evidence are recorded for shortlisted options.
- Cost and operational consequences are connected to T04/T06 without fabricated figures.
- Any proof-of-fit is separately scoped, synthetic-data-only and explicitly authorized before work.
- The owner records a selection or explicitly defers it with rationale and next evidence.

Until then, T05 remains **In progress**. No partial completion percentage is claimed and no technology is selected.

## 8. Explicit non-authorizations

No framework installation, application code, technical spike, physical schema, migration, production database access, vendor account, paid service, source ingestion, deployment or launch is authorized.
