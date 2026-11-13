# M3-01 P04 — Stack, Hosting and Cost Decision Dossier

**Date:** 2026-11-12  
**Status:** Evidence dossier for Product Owner decision; no selection approved  
**Planning authority:** M3-01 P04  
**Related architecture:** M2-S04 technology evaluation; M2-S09 operations/hosting/recovery; M3-01 AI-era architecture readiness review  
**Implementation authorization:** NOT ISSUED  
**Spend authorization:** NONE — no new spend

## 1. Executive assessment

The existing M2-S04 comparison is a useful baseline. The AI-era review does not require the core application to be written in Python, nor does it justify a separate AI microservice from day one. The safest initial direction remains a **modular monolith, server-rendered HTML-first public experience, relational source of truth, and replaceable capability adapters**.

The leading database candidate remains PostgreSQL with PostGIS evaluated for geography. Search should begin with structured/database-native capabilities; vector retrieval, a dedicated search engine, queues, agent runtime and model providers remain optional and evidence-triggered.

The backend choice cannot responsibly be finalized from framework features alone. This is a solo-founder project. The owner's actual hands-on proficiency, preferred deployment/maintenance model, hosting capability and approved budget are decision-critical evidence and are not established by this repository review. A numerical winner would therefore create false precision.

**Recommendation for P04:** retain Laravel 13/PHP, Django/Python and NestJS/TypeScript as candidates; make a skills-and-operability decision before final selection; preserve a provider-neutral AI boundary regardless of backend; use PostgreSQL 18/PostGIS as the leading database proof-of-fit candidate; keep hosting unselected until provider/region/restore/cost evidence exists.

## 2. AI-era architecture impact on stack selection

The 20 AI-ARCH requirements translate into these stack-selection tests:

| Concern | Stack implication | Selection guardrail |
|---|---|---|
| Provider/model independence | Internal capability interface and isolated adapters | Do not let provider SDK types enter domain contracts or canonical records |
| AI-off resilience | AI must be optional to the core request path | Public discovery and core steward workflows must work with AI disabled |
| RAG/evidence grounding | Retrieval must return authorized evidence identifiers, timestamps and citation metadata | Do not let a model become the source of truth |
| Vector search | Optional retrieval adapter; embeddings versioned/rebuildable | No vector database until bilingual relevance and cost benchmarks justify it |
| Agents/tools | Separate execution boundary with deterministic authorization | No agent runtime in Candidate A; no unrestricted shell, SQL or network tools |
| Prompt/evaluation lifecycle | Versioned configuration and repeatable test harness | Keep prompts/configuration out of business logic and source-controlled secrets |
| Observability/cost | Provider-neutral telemetry and budget enforcement | Redact sensitive inputs; hard limits before any paid activation |
| API/interoperability | Versioned internal contracts; bounded external tool gateway | MCP is an option to evaluate, not a mandatory platform dependency |
| Multilingual | Unicode/Urdu/RTL/transliteration testability | Do not assume framework choice alone solves search relevance |
| Portability | Canonical data and evidence remain exportable | Avoid vendor-specific authoritative state |

AI capability is an architectural boundary, not a reason to over-engineer the first release. A future Python worker may be considered if actual model/data-processing workloads justify it, even if the core application is implemented in another language. That split is not approved or required now.

## 3. Backend candidate comparison

| Candidate | Solo-builder/product strengths | AI-era fit | Main risks / unknowns | Current disposition |
|---|---|---|---|---|
| Laravel 13 / PHP 8.3+ | Integrated web framework, ORM, validation, queues, cache, auth ecosystem and conventional server-rendered web delivery | Provider-neutral HTTP/API adapters are feasible; separate AI worker can be added later if justified | Owner's Laravel/PHP proficiency and actual target-hosting support are not verified; package lifecycle/security governance still required | Strong candidate if owner skill and hosting fit are highest |
| Django 5.2 LTS / Python 3 | Mature admin/workflow/data tooling, ORM, validation and broad AI/data ecosystem; natural option for future Python-based retrieval/evaluation workers | Strong ecosystem for data/AI tasks; provider SDKs still must remain behind internal interfaces | Django 6.1 has a shorter support horizon than 5.2 LTS; admin is not the complete steward UX; owner Python proficiency and deployment support unknown | Strong candidate if Python/data-workflow skill is highest; evaluate supported LTS baseline |
| NestJS / TypeScript on Node 26 LTS | Typed modular architecture and one language across backend/frontend; good adapter and async integration patterns | Provider-neutral clients and tool interfaces are feasible; AI orchestration can remain behind interfaces | More assembly and package decisions; admin/workflow and data-governance conventions require deliberate design; owner TypeScript proficiency unknown | Strong candidate if TypeScript skill and modular discipline are highest |

### 3.1 Release lifecycle implications (research snapshot 2026-11-12)

- **Django:** official download/support information lists 5.2 LTS with extended support through April 2028, Django 6.1 with extended support through December 2027, and Django 6.2 LTS planned for April 2027 with extended support through April 2030. If Django is selected before 6.2 LTS is available, 5.2 LTS is the conservative long-support baseline to evaluate; re-check the official support table at decision time. Sources: [Django downloads/support](https://www.djangoproject.com/download/), [Django 6.1 release notes](https://docs.djangoproject.com/en/6.1/releases/6.1/), [Django annual release-cycle announcement](https://www.djangoproject.com/weblog/2026/aug/10/annual-release-cycle/).
- **Laravel:** Laravel 13 requires PHP 8.3 or higher. Confirm the selected hosting runtime and current official support policy before choosing a release line. Sources: [Laravel 13 deployment requirements](https://laravel.com/framework/docs/deployment), [Laravel release policy](https://laravel.com/framework/docs/releases).
- **Node.js:** Node 26 is Active LTS from 28 October 2026 and is scheduled to reach end of life in April 2029. Reconfirm the official release schedule at implementation authorization. Source: [Node.js release schedule](https://github.com/nodejs/Release).

These are lifecycle facts, not a ranking. A current supported patch/minor must be chosen only at the time of authorized implementation.

## 4. Database and retrieval recommendation

| Component | Candidate | Assessment / gate |
|---|---|---|
| Primary relational store | PostgreSQL 18 | Leading candidate for relational integrity, transactional workflows, JSON needs and mature extension ecosystem; confirm target-hosting support and restore/backup terms |
| Geography | PostGIS | Evaluate as an extension to PostgreSQL; confirm extension availability on the chosen host and test coordinate provenance/precision |
| Vector retrieval | pgvector | Optional; benchmark against structured/lexical search using a bilingual synthetic corpus; assess index rebuild, privacy, backup, operational load and extension support |
| Initial search | PostgreSQL structured + lexical/full-text/trigram approach | Lowest operational complexity baseline; test Urdu/English names, aliases, spelling variants, transliteration, filters and locality |
| Dedicated search | Meilisearch or OpenSearch | Add only when measured search quality/scale requires it and the additional service can be operated, secured, backed up and paid for |
| Background processing | Framework-native durable jobs initially | External broker only after actual workload and retry/reliability requirements justify it |

PostgreSQL's official version policy lists PostgreSQL 18 as supported through 14 November 2030. Source: [PostgreSQL versioning policy](https://www.postgresql.org/support/versioning/). Hosting/extension support still needs verification.

## 5. Architecture and application delivery

**Preferred direction for evaluation:**
- Modular monolith; no initial microservices or Kubernetes.
- Server-rendered HTML-first public experience with progressive enhancement.
- Clear module boundaries for domain, evidence/provenance, publication, identity, search/geography, audit and AI capabilities.
- Internal versioned contracts; provider SDKs isolated behind adapters.
- Deterministic business rules and authorization outside model instructions.
- AI features disabled by default and independently kill-switchable.
- No public discovery dependency on AI, maps, geolocation or external search.

The same architecture principles can be implemented in Laravel, Django or NestJS. Framework selection should optimize the founder's ability to build, test, secure, maintain and recover the product—not maximize the number of AI packages available.

## 6. Hosting evaluation — provider remains unselected

Do not equate “supports PHP/Python/Node” with being suitable for this platform. A candidate host must be evaluated against all of the following:

1. Runtime versions and patching responsibility for the chosen backend.
2. PostgreSQL 18 and PostGIS availability, connection limits and extension lifecycle.
3. Region/data location, cross-border transfers, subprocessors and contractual data terms.
4. TLS, private networking, secret management, least-privilege access and auditability.
5. Backup frequency, PITR, independent export, restore process and evidence of restore testing.
6. Worker/cron support, durable job execution, outbound network controls and object storage.
7. Logs/metrics export, alerts, incident response, support hours and escalation.
8. Pakistan user latency, regional availability, bandwidth/egress and CDN behaviour.
9. Portability, complete data export, migration path and provider exit costs.
10. Full recurring cost including app, database, storage, backups, bandwidth, logs, support, taxes and currency conversion.

No host or region is selected. No hosting account, trial, deployment, DNS change or new service is authorized.

## 7. Cost model — assumptions, not invented quotes

No numerical monthly estimate is responsibly available until traffic, storage, region, backup retention, availability target, support needs and service topology are defined. The project has approved **no new spend**.

A future vendor-neutral worksheet must model at least:

| Cost line | Baseline case | Growth case | Evidence needed |
|---|---|---|---|
| Application compute | Single modest app instance assumption | Horizontal/worker capacity assumption | Runtime, CPU/RAM, request profile and provider quote |
| Database | Managed PostgreSQL or owner-operated alternative | Storage/IO/connection growth | PostgreSQL/PostGIS availability, storage, backup/PITR quote |
| Backups and recovery | Retention and export assumption | Longer retention/restore capacity | Backup pricing, egress and restore procedure |
| Search | Database-native baseline | Dedicated search only if benchmarked | Service resources/licensing/operations |
| Maps/geocoding | No mandatory external provider | Optional usage-based service | Terms, quota, region, privacy and price |
| AI | Disabled / zero provider spend | Explicitly capped, task-based usage only after approval | Provider terms, model pricing, token estimates, retention, region, hard caps |
| Storage/bandwidth/CDN/logs | Synthetic/local planning only now | Public traffic and evidence growth | Usage assumptions and vendor quotes |
| Support/operations | Founder-operated bounded model | Additional support/administration | Owner capacity and service support terms |

**Hard rule:** no paid trial, subscription, API, cloud resource, procurement or spend without separate explicit approval and a numeric ceiling.

## 8. Solo-founder operability and decision gate

The owner is the sole human builder for the initial bounded V2 build; ChatGPT is an assistant, not an independent accountable engineer or security certifier. The selected stack must therefore minimize the number of technologies the owner must independently operate.

The repository does not establish the owner's actual proficiency in PHP/Laravel, Python/Django or TypeScript/NestJS. Before selecting a backend, record a short owner-confirmed skills inventory: languages/frameworks used hands-on, ability to debug and deploy them, and which one the owner can maintain without relying on an unaccountable third party. Do not infer proficiency from ownership of a website or use of GitHub.

A non-production technical proof-of-fit, if needed, remains prohibited until separately authorized. It must use synthetic fixtures, no paid services, no external data and an exact approved scope. Documentation-only comparison can proceed now.

## 9. Conditional recommendation and unresolved decision

1. Keep modular monolith + HTML-first + provider-neutral capability boundaries as the preferred architecture direction.
2. Keep PostgreSQL 18/PostGIS as the leading database candidate, subject to hosting/extension/restore evidence.
3. Choose the backend based primarily on verified solo-founder proficiency and operational fit among Laravel 13, Django (prefer a supported LTS line) and NestJS/Node 26.
4. Do not choose Python solely because the future platform may use AI. Keep AI integrations provider-neutral; add a separate Python worker only if later workload evidence justifies it.
5. Start with database-native search. Do not select pgvector, Meilisearch/OpenSearch, a queue broker or an agent runtime until measured needs justify the operational cost.
6. Keep hosting unselected until region, data terms, PostGIS, backup/PITR, restore, security, support, latency, portability and complete cost are evidenced.
7. No stack/hosting decision is final until the Product Owner explicitly records it.

**P04 status:** Evidence dossier delivered for owner review; stack, host, region, budget and vendors remain unselected. P04 is not closed.

## 10. Source register

- Django supported versions and roadmap: https://www.djangoproject.com/download/
- Django 6.1 release/support: https://docs.djangoproject.com/en/6.1/releases/6.1/
- Django annual release cycle: https://www.djangoproject.com/weblog/2026/aug/10/annual-release-cycle/
- Laravel 13 deployment requirements: https://laravel.com/framework/docs/deployment
- Laravel support policy: https://laravel.com/framework/docs/releases
- Node.js release schedule: https://github.com/nodejs/Release
- PostgreSQL versioning/support policy: https://www.postgresql.org/support/versioning/

Re-check all lifecycle and provider facts immediately before any later stack or implementation decision. This dossier is a research snapshot, not a guarantee of future availability or support.


## Product Owner preferred direction and skill evidence — 2026-11-13

The Product Owner confirmed that their current development model mainly relies on ChatGPT for writing, understanding and debugging code. This is not evidence of hands-on proficiency in Python/Django, PHP/Laravel or TypeScript/NestJS and must not be represented as such.

The Product Owner agreed with the recommended preferred planning direction: **Python/Django backend; PostgreSQL primary database; PostGIS geography; modular monolith; HTML-first server-rendered frontend with progressive enhancement; provider-neutral AI boundary with AI-off core operation; database-native search initially.** This is recorded in [M3-01 P04 Product Owner Preferred Technology Direction](M3-01_P04_OWNER_PREFERRED_TECHNOLOGY_DIRECTION_2026-11-13.md).

Django is preferred because of its integrated application capabilities and useful future data/AI ecosystem, not because the owner is already proficient in Python. Laravel/PHP and NestJS/TypeScript remain credible alternatives, not technically rejected. The delivery plan must mitigate the owner's learning/maintenance burden through small changes, explanatory documentation, automated tests, protected PRs, lifecycle checks and human approval of consequential actions.

This is a **preferred planning direction**, not final approval of framework/runtime/database versions or a hosting stack. Provider, region, PostgreSQL/PostGIS availability, backup/PITR, restore, data terms, support, latency, portability, dated quotes and total costs remain open. P04 is advanced but **not closed**. No implementation, package installation, environment activation, account, trial, procurement, spend or external/production access is authorized. Implementation authorization remains NOT ISSUED.


## Superseding owner hosting constraint — 2026-11-13

The Product Owner has directed that initial V2 planning use only resources included in the existing Hostinger Premium Web Hosting subscription. No VPS, upgrade, paid add-on, external managed database, paid API or other new infrastructure spend is approved. The hPanel screenshots supplied on 2026-11-13 show Premium Web Hosting, 25 GB disk, 2048 MB RAM, 1 CPU core, 80 maximum processes, 40 PHP workers, Singapore server location, Mumbai backup location, weekly backups and PHP 8.5 displayed in the dashboard. SSH, Composer, cron, database engine/version, CLI runtime and exact deployment limits remain unverified.

This supersedes the earlier Django/PostgreSQL/PostGIS preferred initial deployment direction. Python/Django and PostgreSQL/PostGIS are not candidates for direct deployment on this Premium plan according to Hostinger's published support guidance. The initial candidate direction is PHP with Laravel subject to exact version/runtime/Composer/extensions/routing verification, and the MySQL/MariaDB database service already included with the hosting plan, subject to engine/version/limits verification. Do not infer that the PHP 8.5 dashboard reading proves CLI or Laravel compatibility. Keep HTML-first server-rendered delivery, modular monolith, AI-off operation and database-native search. Defer PostGIS, dedicated search, external queues/workers, paid maps/geocoding and AI providers. Record locality and coordinates only in a portable form if supported by the approved logical model.

The new owner constraint and verification gates are recorded in [M3-01 P04 Existing Hostinger Premium Constraint](M3-01_P04_EXISTING_HOSTINGER_PREMIUM_CONSTRAINT_2026-11-13.md). P04 remains open until exact plan compatibility, deployment/SSH/cron, database, backup/restore, isolation and synthetic resource-headroom evidence are established. No implementation, technical spike, package installation, environment activation, production/V1 access, database change, account change, deployment or spend is authorized.
