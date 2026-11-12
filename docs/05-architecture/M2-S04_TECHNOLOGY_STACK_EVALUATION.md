# M2-S04 — Technology Stack Evaluation

**Status:** Sourced evaluation and conditional recommendation; owner decision pending  
**Research snapshot:** 2026-11-12  
**Depends on:** Accepted S01, S02 and S03  
**Scope:** Technology options evaluation only. No framework, vendor, hosting provider, purchase or implementation is approved by this document.

## 1. Decision context and constraints

The platform is a Pakistan-first, student-facing education discovery service with a data-stewardship back office, evidence-backed facts, multilingual names and content, geographic discovery, low-bandwidth access, public SEO requirements, and strict source-rights and privacy gates. The architecture baseline separates domain, evidence, publication, discovery and identity responsibilities.

Important unknowns remain: the actual delivery team's language/framework expertise, available operating budget, expected traffic and catalogue size, hosting constraints, support model, and service-level targets. Therefore, a numerical weighted score would create false precision. This evaluation uses explicit criteria, trade-offs and conditional recommendations. A small proof-of-fit using synthetic or independently authorized test data is required before final technology selection.

## 2. Evaluation criteria

| Criterion | Weight | What good looks like |
|---|---:|---|
| Domain fit and integrity | 20% | Strong transaction boundaries, validation, workflow and audit support |
| Maintainability and ecosystem | 15% | Mature documentation, stable release/support policy, predictable upgrades |
| Team operability | 15% | Skills availability, debugging, deployment and hiring fit; currently unknown |
| Security and privacy controls | 15% | Mature authentication/authorization options, safe defaults, security updates |
| SEO, performance and accessibility | 10% | Server rendering, cacheable public pages, efficient mobile delivery |
| Total cost of ownership | 10% | Hosting, managed services, backups, operations and engineering time |
| Extensibility/integration | 10% | Search, geospatial, async work and controlled adapters |
| Portability and lock-in | 5% | Replaceable services, open formats, portable data and exit path |

The criteria are evaluation priorities, not measured scores. Team operability and TCO cannot be finalized without owner/team evidence.

## 3. Backend framework options

| Candidate | Strengths for V2 | Trade-offs / risks | Fit disposition |
|---|---|---|---|
| Laravel 13 / PHP 8.3–8.5 | Productive integrated web framework; queues, cache, validation, ORM, auth ecosystem; annual major cadence; strong fit for conventional data-heavy web applications | PHP ecosystem conventions and package governance need team fit; framework support window requires planned upgrades; complex domain governance still needs explicit module boundaries | Strong candidate if PHP/Laravel expertise and hosting support are confirmed |
| Django 6.1 / supported Python | Mature batteries-included framework, admin capability, ORM, security controls and strong fit for data curation/workflows; official docs recommend PostgreSQL for production | Python ecosystem choice and async/background architecture require operational competence; admin is not a substitute for carefully designed steward UX | Strong candidate if Python/data workflow expertise is available |
| NestJS on Node.js 26 LTS / TypeScript | Strong typed modular structure; consistent language across frontend/backend; adapters and async integrations; Nest supports Express/Fastify | More architectural assembly than batteries-included options; more package/dependency decisions; team must own validation, admin and workflow conventions | Strong candidate where TypeScript skills and explicit modular architecture are strengths |

Official release/support snapshots:
- Laravel 13 was released 17 March 2026; official policy lists bug fixes through Q3 2027 and security fixes through 17 March 2028, with PHP 8.3–8.5 support. [Laravel release/support policy](https://laravel.com/framework/docs/releases)
- Django's official download/support page lists Django 6.1.3 and the 5.2 LTS line (extended support through April 2028); the official production database guidance recommends PostgreSQL. [Django downloads and support](https://www.djangoproject.com/download/) · [Django database guidance](https://docs.djangoproject.com/en/6.0/faq/install/)
- Node.js 26 entered Active LTS on 28 October 2026 and is scheduled through April 2029. NestJS is TypeScript-first and supports Express or Fastify adapters. [Node.js release schedule](https://github.com/nodejs/Release) · [NestJS overview](https://docs.nestjs.com/overview)

No framework is selected. Compare the team's real experience and deployability before deciding.

## 4. Frontend and rendering options

| Option | Benefits | Risks / considerations | Evaluation |
|---|---|---|---|
| Server-rendered templates within selected backend | Simplest runtime and deployment; strong HTML-first SEO; low JS payload; straightforward progressive enhancement | Rich map/filter interactions require carefully scoped client components | Best baseline for content/search/profile pages and low-bandwidth support |
| React with server rendering (e.g. Next.js) | Rich interaction, component ecosystem, SSR/streaming and independent frontend capability | Additional runtime/build/deployment and dependency surface; avoid client-only rendering for SEO-critical pages | Candidate if interaction complexity justifies operational overhead |
| Hybrid/partial enhancement (HTMX or small client islands) | HTML-first and progressive enhancement; targeted interactivity without a full SPA | Requires discipline about where state and validation live; ecosystem may be less standardized | Strong low-complexity option, dependent on team familiarity |

React 19.3 is the current official version snapshot; Next.js recommends production use of its Active or Maintenance LTS channels, not canary. [React versions](https://react.dev/versions) · [Next.js support policy](https://nextjs.org/support-policy)

**Provisional direction:** HTML-first server rendering for public discovery and institution/programme pages, with selective client-side enhancement for filters and maps. A full SPA is not justified by current requirements alone.

## 5. Primary data and transaction store options

| Option | Strengths | Risks / considerations | Evaluation |
|---|---|---|---|
| PostgreSQL 18 | Strong relational integrity, JSON support, mature indexing and extensible geospatial path through PostGIS; supported major versions have published lifecycle | Requires operational backup/restore, upgrades and query/index discipline; managed-service cost unknown | Preferred candidate for evaluation and proof-of-fit |
| MySQL 8.x / compatible managed variants | Mature relational engine; broad hosting availability and operator familiarity | Spatial, JSON, constraints and vendor-variant behaviour need explicit compatibility testing; avoid assuming all forks behave identically | Viable alternative if existing team/hosting capability is decisive |
| MariaDB 11.x | Mature open-source relational engine; familiar MySQL-like ecosystem | Compatibility differences and extension ecosystem require validation; geospatial fit and managed availability need proof | Viable alternative where team operational experience is strong |

PostgreSQL's official support table (checked 2026-11-12) lists versions 14–18 as supported, with PostgreSQL 18 supported through November 2030. [PostgreSQL versioning policy](https://www.postgresql.org/support/versioning/)

**Provisional direction:** Evaluate PostgreSQL 18 with PostGIS first. Do not approve a production major version until hosting support, extension availability, restore testing and performance tests are confirmed. This is not a physical schema decision.

## 6. Search, maps and asynchronous processing options

These concerns are evaluated here at stack level and specified in detail by S06.

| Capability | Candidate approaches | Trade-offs | Provisional direction |
|---|---|---|---|
| Initial text search | PostgreSQL full-text/trigram and normalized search projections | Lowest operational complexity; ranking, typo tolerance and multilingual/tokenization may be limited | Start with database-native search as baseline for proof-of-fit |
| Dedicated search | Meilisearch Community Edition; OpenSearch | Dedicated relevance/filtering and scaling; extra service, backup, monitoring and synchronization burden | Add only if bilingual relevance, typo tolerance or query volume tests justify it |
| Geospatial | PostGIS; external geocoding/tile providers | PostGIS supports first-party spatial querying; external services add privacy, terms, availability and cost concerns | Keep coordinates/provenance in authoritative data; evaluate PostGIS |
| Maps UI | MapLibre GL JS with an independently selected compliant tile source | Open renderer does not provide free unlimited map data/hosting; tiles and geocoding are separate contracts | Keep renderer/provider abstraction; no OSM public service assumed |
| Background work | Framework-native jobs/queues first; dedicated broker later if evidence requires | Broker adds operational complexity; synchronous workflows can be simpler initially | Begin with bounded durable job abstraction; broker decision deferred to proof-of-fit |

Meilisearch Community Edition is MIT-licensed and self-hostable; its Enterprise Edition has separate commercial/BSL terms. Managed cloud pricing is usage/resource-dependent (official pricing page currently shows a $20/month starting point; actual cost depends on workload and region). [Meilisearch licensing](https://www.meilisearch.com/open-source) · [Meilisearch pricing](https://www.meilisearch.com/pricing) · [Meilisearch repository licensing](https://github.com/meilisearch/meilisearch)

OpenSearch is Apache 2.0 licensed and is a heavier distributed-search option whose operational footprint should be justified by scale and search requirements. [OpenSearch project licence](https://github.com/opensearch-project/opensearch)

## 7. Architecture style and module boundaries

**Provisional recommendation: modular monolith first**, with explicit internal capability boundaries corresponding to S03:
- Identity and authorization
- Education domain
- Evidence, rights and provenance
- Review, moderation and publication
- Public discovery/read projections
- Search/geography adapter boundary
- Audit and operations

Rationale: it limits early infrastructure and coordination overhead while preserving testable domain boundaries and future extraction options. A distributed microservice topology is not justified without measured scale, independent team ownership or fault-isolation requirements. This is a recommendation for owner review, not a selected architecture style.

## 8. Hosting, cost and operability

No provider is selected. Evaluate:
- PHP/Python/Node runtime support and version pinning.
- PostgreSQL major version and PostGIS extension availability.
- Managed backup, point-in-time recovery, restore exportability and geographic location.
- Private networking, TLS, secrets, role separation and audit access.
- Queue/worker support, cron reliability, object storage and outbound network policy.
- Logs/metrics export, incident response, support and service limits.
- Data residency, subprocessors, privacy terms and exit/migration path.
- Monthly baseline plus growth scenarios for database, app, search, map tiles/geocoding, storage, backups, bandwidth and support.

A vendor price quote is not comparable without traffic, storage, region, retention, backup, egress and support assumptions. The project has not approved any new spend. Hosting evaluation is continued in S09.

## 9. Conditional recommendation and decision status

1. Retain a modular-monolith logical architecture with an HTML-first public experience.
2. Use PostgreSQL/PostGIS as the first database proof-of-fit candidate.
3. Run a time-boxed comparison of Laravel 13, Django 6.1 and NestJS/Node 26 against the same synthetic domain workflow and deployment constraints.
4. Start with database-native search; benchmark bilingual English/Urdu name search, spelling variants, transliteration, filters and locality queries before adding Meilisearch/OpenSearch.
5. Keep map rendering, tiles and geocoding as separate replaceable interfaces; do not depend on community tile/geocoder endpoints as an assumed production SLA.
6. Select final stack only after team skill inventory, hosting capability/cost evidence, security review, restore test and owner decision.

**Owner decision required:** choose or request a change to the backend/frontend/data/search direction after the missing team and cost evidence is supplied. No stack or vendor is approved by this recommendation.

## 10. S04 exit checklist

- Criteria and weights are explicit.
- Backend/frontend/data/search/maps/async options are compared.
- Release/support and licensing evidence is linked.
- Cost and operability assumptions are exposed rather than invented.
- Conditional recommendation is traceable to S01-S03.
- Owner decision and implementation approval remain separate.
