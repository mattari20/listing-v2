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


## 8. Official Hostinger compatibility research — 2026-11-13

This section records public documentation findings only. It is not a live inspection of the Product Owner's account or server.

| Capability | Official Hostinger evidence | Planning assessment |
|---|---|---|
| PHP on Web Premium | Web/Cloud PHP support; dashboard supports PHP versions 8.2–8.5 according to current PHP version guidance | Compatible in principle; hPanel screenshot shows PHP 8.5, but CLI/runtime parity and the exact V2 folder runtime must be verified |
| Laravel | Hostinger's current framework guidance describes Laravel 12.x Auto Installer availability on eligible hosting plans; older version article describes Laravel 10.x. Laravel 13 official deployment docs require PHP >=8.3 | PHP version is sufficient in principle if PHP 8.5 applies to the app. Hostinger's Auto Installer version information is inconsistent across its articles; do not rely on Auto Installer. Composer-based Laravel 13 installation is a candidate only after CLI, Composer, extensions, routing and document-root verification |
| SSH | Hostinger says SSH is available on Premium Web and higher; user enables it in hPanel's SSH Access page | Strong documented support; actual account enablement, endpoint and access method still require user confirmation |
| Composer | Hostinger says Composer 1 and Composer 2 are pre-installed on Premium Web, Business and Cloud; Composer commands run over SSH | Strong documented support; verify composer2 --version read-only in the account |
| Cron | Hostinger says Premium and higher have no fixed cron-job count cap; Web/Cloud scheduled tasks are dashboard-managed and consume CPU/RAM | Suitable for low-frequency bounded scheduled work; not an always-on worker or queue substitute |
| PHP extensions | Hostinger exposes installed/enableable extensions in PHP Configuration and PHP Info; Laravel 13 requires Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer and XML | Must verify each required extension is enabled for the actual V2 PHP handler; avoid changing global PHP configuration while V1 shares the plan |
| MySQL access | Hostinger supports MySQL with MySQLi, PDO and pdo_mysql on Web/Cloud plans | Compatible in principle; actual server engine/version and database limits remain account-specific |
| PostgreSQL / Redis / MongoDB | Hostinger classifies these standalone services as VPS-only; PostgreSQL not available on Web/Cloud | Not in initial scope; defer |
| Web resource ceilings | Published plan-limit tables vary by hosting-plan generation and have changed. Current documentation includes Premium variants with 1 CPU core, 2 GB RAM, 20 GB storage, 40 PHP workers, and a separate table with 3 GB per-DB cap and 50 connections per DB user; older tables show 25 GB storage and different resource values | Treat the supplied hPanel snapshot as the primary evidence for this subscription. Confirm exact generation and live values in hPanel; do not apply generic limits as a contract |
| Database limits | Hostinger's published limits have included 3 GB per MySQL database and 200 MB import cap for some Web plan generations; newer plan tables differ | Conservative planning ceiling only until exact subscription-specific limits are confirmed |
| PHP routing / document root | Laravel's deployment guidance requires web requests to be routed to the application's public/index.php; Hostinger offers folder/subdomain PHP handling guidance | A safe subfolder deployment is not yet proven. Prefer a separately isolated site/subdomain or carefully configured V2 web root if available without cost; never expose the Laravel project root, .env, vendor internals or storage files |

### Official references reviewed

- Hostinger plan limits: https://www.hostinger.com/support/6976044-parameters-and-limits-of-hosting-plans-in-hostinger/
- Hostinger cron limits: https://www.hostinger.com/support/1583765-how-many-cron-jobs-can-you-set-up-in-hostinger/
- Hostinger Composer: https://www.hostinger.com/support/5792078-how-to-use-composer-at-hostinger/
- Hostinger SSH: https://www.hostinger.com/support/1583245-how-to-connect-to-a-hosting-plan-via-ssh-in-hostinger/
- Hostinger supported languages/frameworks: https://www.hostinger.com/support/which-programming-languages-and-frameworks-are-supported-at-hostinger/
- Hostinger PHP version configuration: https://www.hostinger.com/support/1575755-how-to-change-the-php-version-of-your-hosting-plan/
- Hostinger PHP extensions: https://www.hostinger.com/support/which-php-extensions-and-configuration-options-are-supported-at-hostinger/
- Hostinger PHP Info: https://www.hostinger.com/support/1583467-how-to-check-the-php-information-of-your-website-in-hostinger/
- Hostinger database support: https://www.hostinger.com/support/which-databases-and-data-tools-are-supported-at-hostinger/
- Hostinger database size limits: https://www.hostinger.com/support/5534251-what-to-do-if-the-database-size-limit-has-been-reached/
- Laravel 13 deployment requirements: https://laravel.com/framework/docs/deployment
- Laravel release/support matrix: https://laravel.com/framework/docs/13.x/releases

### Interpretation

The public documentation makes the Premium plan a credible candidate for a small PHP/Laravel + MySQL modular monolith without buying a VPS. It does not prove the complete V2 platform will fit the plan. The one-core CPU, shared 2 GB RAM shown by hPanel, shared storage already used by estudent.pk, 40 PHP workers and per-database limits mean the initial release must be deliberately lean. No persistent queue workers, Redis, PostgreSQL, PostGIS, vector database, containers or always-on agent processes are assumed.

A useful first directory slice is technically plausible on this plan if V2 remains isolated, uses server-rendered pages, indexed bounded queries, small media, few scheduled tasks and modest concurrency. Capacity cannot be certified until an authorized synthetic load test is designed and run in a separate V2-only environment. No load test is performed as part of this documentation investigation.

## 9. Exact account checks needed to close P04

The owner can provide the following screenshots from hPanel (hide account email, username, IP address, domain credentials and any secrets):

1. **Websites → Manage site → Advanced → SSH Access:** show whether SSH is enabled and the plan's connection details with host/IP and username obscured.
2. **Websites → Manage site → Advanced → PHP Configuration / PHP Info:** show PHP 8.5 and the enabled extensions list. Do not change or save any settings.
3. **Websites → Manage site → Databases → Management:** show database engine/version if exposed, database size/limit and current V2-free database availability. Do not create, alter or open the V1 database.
4. **Websites → Manage site → Advanced → Cron Jobs:** show available cron interface and restrictions. Do not create a job.
5. **Websites → Manage site → Resource Usage / Plan details:** show current CPU/RAM/process/inode usage and the exact subscription generation/limits.

If SSH is already enabled and the owner is comfortable running read-only commands, these commands only print versions/configuration and do not install, modify or start services:

```sh
php -v
php -m
composer2 --version
which php
```

Do not run composer install, composer update, Artisan commands, migrations, SQL writes, package managers, deployment commands or any command that changes files or services. The CLI php -v output may not prove the PHP handler version assigned to a subfolder; compare with hPanel PHP Info. Never paste passwords, private keys, tokens, full SSH commands or database credentials into chat.

For database version, the owner may inspect only the hPanel database management metadata. Do not connect to or inspect the existing V1 database. A future V2-owned synthetic database test would need a separate explicit authorization and must not be created under this current read-only investigation.

## 10. Current P04 gate status

| Gate | Status |
|---|---|
| Public PHP/Laravel compatibility | **Provisionally supported** by Hostinger docs; exact Laravel 13 deployment path unverified |
| SSH | **Documented for Premium; account enablement unverified** |
| Composer 2 | **Documented pre-installed; account command unverified** |
| Cron | **Documented for Premium; exact UI/limits unverified** |
| Required PHP extensions | **Not verified in this account** |
| MySQL/PDO support | **Documented; server engine/version and actual limits unverified** |
| Isolated V2 web root/subfolder routing | **Not verified** |
| Backup/restore | **Weekly backup shown; restore evidence not available** |
| Shared resource headroom | **Not measured** |
| Exact renewal cost / plan generation | **Not confirmed** |

**Interim conclusion:** The existing Premium plan is a credible zero-new-spend hosting candidate for a carefully scoped initial V2 directory. It is not yet a proven fit for the complete roadmap or for production launch. P04 remains OPEN until the account-specific checks and an authorized V2-only synthetic capacity/recovery test are completed. No stack version is finally selected, and this research does not authorize implementation, installation, account changes, production access, database creation/inspection, deployment or spend.

## 11. Product Owner confirmation of existing-host capabilities — 2026-11-13

The Product Owner has confirmed that the hosting capabilities previously listed as requiring screenshots or account checks are already available and in use for the existing V1 website on the same Hostinger Premium hosting environment. This confirmation is accepted as owner-supplied operational evidence for the shared hosting account; no V1 files, configuration, database, credentials or production service were accessed for this update.

For planning purposes, the following shared-host capabilities are treated as **owner-confirmed present and operational in the current hosting environment**: PHP execution/CLI, Composer, required PHP-extension support, the hosted MySQL-compatible database service, SSH, scheduled cron capability and the existing hosting deployment/file-management workflow.

This confirmation does **not** establish the exact PHP CLI version, exact enabled extension list for a future V2 web root, exact MySQL versus MariaDB engine/version, exact database quota/connection limits, Laravel-specific compatibility, or that V2 can safely share V1's current document root, files, database, configuration or resource allocation. No values are inferred from V1 and no V1 inspection is authorized or required.

### Updated evidence treatment

| Item | Revised evidence status | V2-specific treatment |
|---|---|---|
| PHP / PHP CLI | Owner-confirmed used on the current hosting environment; hPanel screenshot previously showed PHP 8.5 | Confirm CLI/web-handler parity and supported Laravel target at the V2 boundary before implementation |
| Composer | Owner-confirmed used/available | Confirm exact Composer 2 invocation/version only if required by the selected build workflow |
| PHP extensions | Owner-confirmed extension capability is in use | Check the selected framework's exact required extensions against the V2 PHP runtime; do not change shared/global settings |
| MySQL-compatible database | Owner-confirmed hosted database service is in use | Exact engine/version and free isolated database/quota remain V2 planning inputs; never inspect or reuse the V1 database |
| SSH | Owner-confirmed available/in use | Define least-privilege V2 deployment access; do not share credentials in chat |
| Cron | Owner-confirmed available/in use | Keep initial scheduled work low-frequency and bounded; no persistent workers |
| Deployment/file management | Owner-confirmed existing workflow is in use | Define a separate V2 path/document root, secrets, permissions, release and rollback boundaries |
| V2 isolation | Not proven by V1 usage | Must be designed and verified independently |
| V2 resource headroom | Not proven by V1 usage | Requires an authorized V2-only synthetic capacity test before launch |
| V2 backup/restore | Weekly plan backup is visible, but V2 restore evidence is absent | Define and rehearse V2-owned synthetic-data recovery after separate authorization |

### Revised P04 interpretation

The prior request for screenshots merely to prove that PHP, Composer, extensions, database service, SSH, cron and basic deployment capability exist is withdrawn. The Product Owner's confirmation is sufficient to proceed with architecture planning and to avoid unnecessary V1 access.

P04 is **advanced but remains OPEN** because exact framework/runtime compatibility, V2 isolation/routing, V2 resource headroom, V2 recovery evidence and final owner approval of the initial versioned stack are still outstanding. These are V2-specific gates, not requests to audit V1.

The current zero-new-spend direction remains binding. The next planning output should define a lean Laravel/PHP + MySQL-compatible modular monolith candidate, a V2-only directory/deployment boundary, and a staged schedule. No implementation, technical spike, package installation, account change, database creation, V1 inspection, deployment, production access or spend is authorized by this owner confirmation.
