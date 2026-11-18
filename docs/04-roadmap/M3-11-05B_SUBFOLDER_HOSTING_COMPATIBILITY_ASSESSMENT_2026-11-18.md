# M3-11-05B — Subfolder Hosting Compatibility Assessment

**Date:** 2026-11-18  
**Package:** M3-11-05 runtime/environment separation  
**Base reviewed:** main after PR #293 merge, commit `83f5fa6ce2cffcf35ae7f3b0e9007dab42ef8ddd`  
**Status:** REPOSITORY REVIEW COMPLETE; HOSTING COMPATIBILITY BLOCKED PENDING HOSTINGER EVIDENCE

## 1. Purpose and scope

Assess the current Laravel repository against the Product Owner's preferred private V2 deployment shape:

- V2 served from a subfolder, not a subdomain.
- A separate V2 database.
- Dedicated V2 file storage.
- No public website navigation/link to the V2 URL during private development.

This is a repository/configuration review only. No Hostinger/hPanel access, V1/production access, provisioning, database creation, DNS, deployment, hosted request, real data, or spend occurred.

## 2. Executive result

The repository is a Laravel 13 application requiring PHP `^8.3`. The repository can be prepared for a subfolder URL, but it is **not currently ready to connect to the intended separate MySQL/MariaDB database**: the committed database configuration defines SQLite only and defaults to SQLite. The application also has no global private-preview access gate; several routes, including health and directory routes, are intentionally anonymous.

A subfolder URL and an unlinked navigation item do not make the application private. Before any hosted preview, the design must put an access-control gate in front of every route, including health, directory, and static/application entry points, and verify it from an unauthenticated request.

**Disposition:** Do not provision or deploy yet. First complete repository database-driver and subfolder configuration work, then inspect the exact hosting plan and verify a supported access-control mechanism.

## 3. Repository findings

| Area | Evidence from repository | Assessment |
|---|---|---|
| Framework/runtime | `composer.json`: Laravel `^13.17`, PHP `^8.3` | Hosting PHP must satisfy the project requirement and required extensions must be checked against Composer platform requirements |
| Database | `config/database.php` defines SQLite only; default is `sqlite` | **BLOCKER:** no MySQL/MariaDB connection is configured for the intended separate hosted database |
| Environment template | `.env.example` has no DB host/name/user/password keys | **BLOCKER:** hosted DB settings cannot yet be documented as a supported environment configuration |
| App URL | `config/app.php` reads `APP_URL` | Supports an environment-specific URL value, but subfolder URL generation must be tested end-to-end |
| Web entry point | `public/.htaccess` rewrites non-file/non-directory requests to `index.php` | Standard Laravel front-controller rewrite exists; actual subfolder mapping and rewrite inheritance depend on Hostinger's document-root layout |
| Sessions | `config/session.php` defaults cookie path to `/` | **Isolation concern:** V2 should use a scoped cookie path (e.g. the final V2 URL prefix) so its session cookie is not unnecessarily sent to the whole domain |
| Cache | `config/cache.php` supports a configurable `CACHE_PREFIX` | A unique V2 prefix is available if a shared cache backend is ever used; shared writable cache remains disallowed unless separately assessed |
| Queue | `config/queue.php` defaults to `sync` | Keep synchronous processing for private synthetic preview unless a dedicated V2 queue is explicitly approved |
| Filesystem | `config/filesystems.php` roots local storage at `storage/app/private`; public disk maps to `storage/app/public` and a public storage symlink | Keep private data outside the web document root. Do not create a public storage symlink for private acceptance data. Actual physical path and permissions need hosting evidence |
| Routes/access | `routes/web.php`: `/health` and `/directory` routes are anonymous; other workflow routes use `auth` | **BLOCKER for private preview:** no application-wide preview access gate is present |
| Environment defaults | `.env.example`: `APP_DEBUG=false`, array cache/session, sync queue, log mail | Safe development-oriented defaults in part, but deployment must explicitly set production-safe values and unique secrets |

## 4. Required repository changes before hosted setup

### 4.1 Separate database driver support

- Add a standard Laravel MySQL connection configuration without removing SQLite support for local/CI tests.
- Add documented `DB_CONNECTION=mysql`, host, port, database, username and password placeholders to `.env.example`; never commit real values.
- Keep SQLite as the test/local default unless a test explicitly selects another driver.
- Add configuration-level tests proving the MySQL connection resolves environment values and SQLite remains available.
- Confirm migrations and application queries are compatible with the selected MySQL/MariaDB version using a disposable local/CI database only. Do not connect CI to Hostinger.

### 4.2 Subfolder URL and cookie isolation

- Document the final `APP_URL` including the chosen V2 path prefix (exact path remains unselected).
- Configure a V2-scoped `SESSION_PATH` matching that path; use a unique session cookie name and unique `APP_KEY`.
- Verify route generation, redirects, CSRF/session behavior, asset URLs, health route and directory routes under a simulated subfolder base path.
- Do not hardcode the final subfolder name until the owner confirms the exact path.

### 4.3 Private-preview access gate

- Add an explicit preview-only access gate that runs before all web routes, not just authenticated workflow routes.
- Ensure health, directory listing, directory profiles, error pages and any enabled static/application endpoints cannot bypass the gate.
- Gate must be disabled by default in repository/production configuration and enabled only by an explicit local/private-preview setting; no secret value may be committed.
- Add feature tests asserting unauthenticated requests are denied across representative public and authenticated route groups when the gate is enabled, and normal local synthetic preview behavior remains available when it is disabled.
- Prefer a hosting-supported outer HTTP access control as an additional layer if available. Do not treat the unlinked URL, robots.txt, obscurity or an application health route as access control.

### 4.4 Storage and deployment layout

- Keep Laravel application code, `.env`, `vendor`, `storage`, logs, sessions, cache and backups outside the publicly served document root wherever the hosting layout permits.
- Only Laravel's `public/` directory should be web-served.
- If Hostinger's subfolder model forces any sensitive directory under a served path, deny direct HTTP access and verify the denial with safe synthetic files before use.
- Do not run `storage:link` for private acceptance data.
- Require a V2-only deployment path and V2-only writable directories; no V1 file/configuration edits or shared writable paths.

## 5. Hostinger facts that cannot be established from GitHub

The repository does not identify the active Hostinger plan, PHP selector/runtime, available PHP extensions, database engine/version and limits, number of databases/users, database host grants, filesystem ownership/permissions, document-root mapping, Apache/LiteSpeed rewrite behavior, HTTP password protection/IP restrictions, cron/worker availability, or backup boundaries.

These are account/hosting facts. They cannot be inferred from Laravel source code or the fact that a subdomain/database option appears in hPanel. They require redacted hPanel evidence or a separately authorized read-only inspection.

## 6. Minimum read-only evidence needed from hPanel

1. Hosting plan name and current resource/feature limits.
2. PHP version selector and enabled extensions (no secrets).
3. Database management screen showing database engine and available database/user capacity; hide database names if desired.
4. File Manager view showing the current website document root and whether a V2 application directory can be placed without changing V1.
5. Permission/ownership controls for directories, without changing them.
6. Any available directory/password protection or IP restriction feature.
7. Backup scope information showing whether a V2-only restore boundary is possible.

Do not send passwords, tokens, private keys, database credentials, or unredacted configuration files. Screenshots are for planning only; they do not authorize changes.

## 7. Decision matrix

| Requirement | Repository status | Hosting status | Next action |
|---|---|---|---|
| PHP `^8.3` and extensions | Requirement identified | Unknown | Compare hPanel runtime/extensions to Composer requirements |
| Separate MySQL/MariaDB database | Not configured in app | Owner says separate DB can be created; not created | Add MySQL config; later verify database/user isolation |
| V2 subfolder URL | APP_URL is configurable; no hosted path test | Owner says subfolder available | Implement and test base-path behavior; confirm document-root mapping |
| Scoped V2 session | Configurable; current default path is `/` | Unknown | Add scoped setting and tests |
| Dedicated private storage | Laravel local private root exists | Physical path/permissions unknown | Verify storage outside web root or tested deny rules |
| Private URL access | No global preview gate | No control confirmed | Implement app gate; verify hosting-level option |
| Runtime/filesystem separation | Not provable from repo | Unknown | hPanel evidence and safe architecture review |
| Backup isolation | Not established | Unknown | Inspect hosting backup boundaries; no rehearsal yet |

## 8. Acceptance criteria for this assessment

- [x] Owner's subfolder/no-subdomain preference recorded.
- [x] Repository source inspected for database, URL, session, storage, routing and runtime settings.
- [x] Code-level blockers and required follow-up work documented.
- [x] No production/V1/Hostinger access or changes.
- [ ] MySQL/MariaDB configuration implemented and tested on disposable CI/local database.
- [ ] Subfolder URL and scoped-session behavior tested.
- [ ] Preview-wide access gate implemented and tested.
- [ ] Hostinger plan/runtime/database/storage/access-control facts evidenced.
- [ ] Exact resource and provisioning authorization completed separately.

## 9. Final disposition

**Repository compatibility assessment:** COMPLETE.  
**Subfolder architecture:** FEASIBLE IN PRINCIPLE, NOT YET IMPLEMENTED OR HOST-VERIFIED.  
**Separate database:** OWNER-INTENDED; APPLICATION CONFIGURATION CURRENTLY SQLITE-ONLY.  
**Private access:** NOT ESTABLISHED; unlinked URL is insufficient.  
**Storage isolation:** NOT VERIFIED.  
**Hostinger plan compatibility:** UNKNOWN pending hPanel evidence.  
**Provisioning/deployment:** NOT PERFORMED OR AUTHORIZED.  
**M3-11-05:** BLOCKED / NOT ACCEPTED.

Next repository package should implement MySQL/MariaDB configuration, subfolder-aware URL/session settings, and a preview-wide access gate with synthetic tests. Hosted setup remains separately gated by the exact hosting evidence and owner authorization.
