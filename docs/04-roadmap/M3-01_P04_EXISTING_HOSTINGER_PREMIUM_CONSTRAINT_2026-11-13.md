# M3-01 P04 — Existing Hostinger Premium Hosting Constraint and Owner Direction

**Date:** 2026-11-13  
**Decision authority:** Product Owner  
**Status:** Owner-directed initial hosting constraint; framework/database choice remains subject to compatibility verification  
**Implementation authorization:** NOT ISSUED  
**Spend authorization:** NONE — no new spend

## 1. Owner direction

The Product Owner directed that the initial V2 implementation should use only resources already available in the existing Hostinger Premium Web Hosting subscription. Do not purchase or activate a VPS, hosting upgrade, paid add-on, external managed database, paid API or other infrastructure for the initial scope. If a required capability is unavailable, defer it rather than incur new cost. Preserve a practical future upgrade path where this can be achieved without adding present complexity or cost.

This supersedes the earlier 2026-11-13 preferred Django/PostgreSQL planning direction as the initial deployment constraint. It does not authorize implementation.

## 2. Evidence supplied from Hostinger hPanel

The Product Owner supplied screenshots of the estudent.pk Hostinger hPanel on 2026-11-13. The screenshots identify:

| Item | Screenshot evidence |
|---|---|
| Plan | Premium Web Hosting |
| Disk allowance | 25 GB |
| RAM | 2048 MB |
| CPU | 1 core |
| Maximum processes | 80 |
| PHP workers | 40 |
| Websites/addons | 25 |
| Bandwidth | Unlimited (as displayed by hPanel) |
| Server location | Asia (Singapore) |
| Backup location | India (Mumbai) |
| Backup cadence | Weekly (shown on dashboard) |
| Current disk use | 9.3 GB / 25 GB (dashboard snapshot) |
| PHP version | 8.5 (dashboard snapshot) |
| SSH access | Not yet verified from a dedicated SSH Access screen |
| Composer / cron / deployment limits | Not yet verified for this exact subscription |

These are dated screenshots, not a live host audit. Resource usage is a snapshot and may change. The plan's current renewal price/date has not yet been captured and is not needed for the zero-new-spend constraint, but remains useful for total-cost planning.

## 3. Initial platform direction under the constraint

| Area | Initial planning direction | Gate / limitation |
|---|---|---|
| Hosting | Existing Premium Web Hosting only | No VPS, upgrade, new service or spend |
| Backend | PHP; evaluate Laravel only after exact compatibility checks | PHP 8.5 shown in dashboard; verify Laravel release support, CLI, Composer, extensions, routing, document root and deployment constraints |
| Database | Existing-hosting-compatible MySQL | Verify available MySQL/MariaDB engine/version, limits, backup/export and isolation; no production database changes |
| Frontend | HTML-first server-rendered pages with progressive enhancement | Keep client-side JavaScript modest |
| Architecture | Modular monolith | Avoid microservices, containers and external brokers in initial scope |
| Search | Native database queries/indexes and bounded PHP implementation | Defer dedicated search infrastructure |
| Geography | Store normalized locality and optional coordinates as ordinary fields if supported by the approved logical model | Defer PostGIS, geospatial extensions and paid geocoding/maps |
| Background work | Small bounded cron/scheduled tasks only if exact plan supports them | No always-on workers or external queue assumed |
| AI | Disabled in initial scope; retain a provider-neutral interface only where low-cost and useful | No API calls, model, agent, vector store or spend |
| Storage/media | Existing plan storage only; conservative quotas and formats | No paid object storage/CDN assumed |

The exact framework version is not selected. Do not assume that a PHP version shown in WordPress dashboard proves all CLI/runtime, extension, Composer or Laravel deployment requirements. A synthetic-only compatibility check may be proposed for later authorization, but is not authorized by this decision.

## 4. Hostinger compatibility evidence and limits

Hostinger's official guidance states that Python/Django and PostgreSQL are VPS-only on its hosting products, while PHP/Laravel is supported on eligible Web/Cloud hosting plans. The exact Laravel version and deployment workflow must still be checked against this specific Premium subscription.

- Hostinger supported languages/frameworks: https://www.hostinger.com/support/which-programming-languages-and-frameworks-are-supported/
- Hostinger Django support: https://www.hostinger.com/support/is-django-supported/
- Hostinger PostgreSQL support: https://www.hostinger.com/support/is-postgresql-supported/
- Hostinger database support: https://www.hostinger.com/support/which-databases-are-supported-at-hostinger/
- Hostinger SSH guidance: https://www.hostinger.com/support/how-to-access-ssh-in-hostinger/

Do not infer SSH, Composer, cron, CLI or deployment capability solely from the hPanel screenshots. Verify these only through read-only plan documentation or a separately authorized synthetic test.

## 5. Future portability without present over-engineering

The initial design should:
1. Keep business/domain rules separate from framework-specific controllers and views.
2. Use clear repository/service boundaries for database access, without introducing unnecessary abstraction layers.
3. Avoid depending on proprietary Hostinger-only features for authoritative business logic.
4. Use portable SQL and documented export/import procedures; do not claim MySQL-to-PostgreSQL compatibility without later migration tests.
5. Keep coordinates, source provenance and geographic semantics explicit so a later PostGIS migration is possible.
6. Keep AI/search/geocoding optional and disabled; define replaceable interfaces only where they do not complicate the initial build.
7. Document resource limits and monitor CPU, RAM, storage, inode, process and database constraints.
8. Keep V2 isolated from the V1 website, its database, files, APIs and operational procedures.

Future upgrade options (VPS, PostgreSQL/PostGIS, dedicated search, external workers or AI providers) are deferred and require a separate owner decision, compatibility assessment and explicit spend approval. The architecture must not promise a frictionless migration; later migrations require rehearsed export, mapping, validation and rollback.

## 6. P04 remaining verification gates

P04 remains open until the following are evidenced without modifying production:
- Exact PHP CLI/runtime version and required extensions available to the V2 deployment context.
- Composer availability and supported deployment method on Premium.
- SSH access and least-privilege deployment workflow, if required.
- Cron availability/limits and whether scheduled tasks are sufficient.
- MySQL/MariaDB engine/version, database count/size/connection limits and backup/export options.
- Rewrite/routing/document-root support for an isolated V2 subdirectory or separately isolated web root.
- File permissions, secret/configuration boundaries and safe deployment/rollback.
- Actual resource headroom under synthetic load appropriate to the first slice.
- Backup/restore evidence for V2-owned synthetic data; weekly backup alone is not a verified recovery plan.
- Host terms, data location, support scope and current subscription terms.

Any compatibility check must be documentation-only or use synthetic data in an isolated non-production environment after separate explicit authorization. No access to V1 production data or database, no production DDL/DML, no DNS changes, no deployment, no package installation and no account changes.

## 7. Scope and authorization boundary

This record changes planning constraints only. It does not authorize:
- application code, technical spikes or environment activation;
- package installation or changes to the Hostinger account;
- production/V1 access, production database inspection or changes;
- real data, source collection, scraping or ingestion;
- external APIs, models, agents, paid services or procurement;
- schema/migrations, deployment, pilot or launch.

**Decision summary:** Plan the first V2 release around the existing Premium Web Hosting resources only. Prefer a lightweight PHP-based modular monolith with an existing-hosting-compatible relational database, subject to verification. Defer unavailable capabilities. Preserve future portability where practical. No additional spend and no implementation authorization.
