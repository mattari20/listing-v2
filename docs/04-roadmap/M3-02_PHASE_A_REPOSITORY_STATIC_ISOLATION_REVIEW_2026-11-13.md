# M3-02 Phase A — Repository-Only Static Isolation Review

**Review date:** 2026-11-13  
**Repository:** `mattari20/listing-v2`  
**Branch reviewed:** `main`  
**Exact baseline:** `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`  
**Plan:** `M3-02_V2_ONLY_NON_PRODUCTION_ISOLATION_VERIFICATION_PLAN_2026-11-13.md`  
**Review type:** Read-only repository snapshot review  
**Status:** Phase A review completed for the inspected snapshot; Phase A evidence is partial where historical or runtime facts cannot be established from the current tree.

## 1. Executive result

The current V2 repository snapshot is consistent with a small, database-independent Laravel foundation and does not show a direct V1 runtime dependency in the inspected application, configuration or workflow files. The tracked tree contains 209 entries, including directories, and no tracked `.env`, `config/database.php`, `database/` directory, database file, runtime log, `vendor/` or `node_modules/` tree.

The repository keeps the Laravel front controller at `public/index.php`; application code, bootstrap, configuration, storage and dependency paths are siblings outside `public/`. This is a sound source-tree layout **if and only if** the deployed document root is mapped to this `public/` directory. The repository cannot prove that host-level mapping, symlink resolution, permissions or shared-account isolation are correct.

The active local/test defaults are conservative: debug false, array cache and sessions, synchronous queue, local filesystem, warning-level logs and log/array mail transports. However, Laravel's checked-in configuration templates include optional database-backed cache and queue drivers, database queue batching/failure stores, remote mail transports and cloud/remote logging examples. These are dormant examples, not evidence of active connections. They must not be selected or supplied credentials under the current no-database/no-external-service boundary.

**Phase A conclusion:** no confirmed direct V1 dependency or committed secret was identified in the inspected snapshot. Repository-level separation is supported by the current tree and files, but historical exhaustive absence and all host/runtime isolation remain unproven. This review does not pass ISO-06 through ISO-12.

## 2. Scope and method

Inspected the current `main` tree and selected source files at the exact baseline above:

- Complete recursive repository tree (209 entries; GitHub reported `truncated=false`).
- Root environment example, ignore rules and Composer manifest.
- Laravel bootstrap, front controller, public rewrite rules, routes and service provider.
- Application visibility policy and its tests.
- App, cache, filesystem, queue, session, services, directory, logging and mail configuration.
- PHPUnit environment configuration and foundation/health tests.
- Both GitHub Actions workflows.
- Existing legacy-repository isolation audit.
- M3-02 isolation plan, environment/diagnostics record, M3 roadmap and master-control documents.

Targeted repository code searches were made for the legacy repository name, Hostinger references, common database credential variable names, path helper references and deployment/workflow terms. These searches returned no matches for those exact query groups. Search results are supporting evidence only; they are not a substitute for inspecting every historical commit or every runtime environment.

No source or files were read from the legacy repository during this review. The existing V2 legacy-isolation audit was inspected as a V2 policy document only.

## 3. Findings

### A-01 — V2 repository and baseline identity
**Disposition:** Verified.

- Repository: `mattari20/listing-v2`.
- Default branch: `main`.
- Exact reviewed commit: `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`.
- The recursive tree contained 209 entries and was not truncated.
- PR #143 is merged; its merge commit is the reviewed `main` baseline.

### A-02 — No committed environment secret or database setup found
**Disposition:** Pass for current tracked snapshot; not a historical or runtime attestation.

- `.env.example` contains placeholders only; `APP_KEY` is blank.
- `.gitignore` excludes `.env`, `.env.backup` and `.env.production`.
- No tracked `.env` or production environment file was present in the tree.
- No `config/database.php`, `database/` directory, tracked `.sqlite`/`.db` file or database artifact was present.
- Composer declares Laravel framework dependencies and autoload namespace mappings for future factory/seeder directories, but the mapped `database/factories` and `database/seeders` directories are not present in the current tree.
- The PHPUnit environment test explicitly asserts that `config/database.php` does not exist.

This supports the claim that the current tracked foundation has no project database configuration. It does not prove the absence of untracked local files, GitHub secrets, external credentials or runtime database settings. Those are not inspected by this static source review.

### A-03 — Public entry-point separation
**Disposition:** Source layout pass; host document-root mapping unverified.

- `public/index.php` loads `../vendor/autoload.php` and `../bootstrap/app.php`.
- `app/`, `bootstrap/`, `config/`, `storage/` and `vendor/` are outside the `public/` directory in the repository layout.
- `public/.htaccess` routes non-file/non-directory requests to the front controller and disables directory indexes when the relevant Apache modules are available.
- No root-level `.htaccess` or host routing configuration is present in the repository tree.

**Risk / required follow-up:** The layout is only safe if the V2 web document root is set to the V2 `public/` directory and no alias, symlink, parent document root or alternate route exposes the repository root. This cannot be verified from GitHub. Do not infer deployed isolation from the source tree.

### A-04 — Database-capable framework templates remain dormant but need an activation guard
**Disposition:** Finding; no database activation observed or permitted.

Current defaults in `.env.example` and PHPUnit use:
- `CACHE_STORE=array`
- `SESSION_DRIVER=array`
- `QUEUE_CONNECTION=sync`
- `FILESYSTEM_DISK=local`
- `MAIL_MAILER=log` in the example and `array` in PHPUnit.

But checked-in Laravel configuration retains optional backends:
- `config/cache.php` defines database cache and a failover store whose first backend is database.
- `config/queue.php` defines a database queue; the failover queue lists database before deferred; batching and failed-job stores name database-backed defaults.
- `config/session.php` includes database/Redis session options.
- No project database connection configuration is committed.

The current defaults do not select these optional paths, and this review did not run any command that connects to a database. Nevertheless, future environment/configuration changes must not activate a database-backed store, batching or failed-job path until a separate database scope is approved. Do not create database configuration as part of Phase A or B.

### A-05 — CI boundary is narrow; documentation workflow action tags are mutable
**Disposition:** Mostly pass, with supply-chain hardening observation.

- Both workflows use `pull_request` triggers for `main` and declare `permissions: contents: read`.
- FND-01 foundation CI pins `actions/checkout` and `shivammathur/setup-php` to immutable commit SHAs.
- Foundation CI validates Composer, installs only locked dependencies, audits dependencies, runs Pint, validates Laravel bootstrap/routes, runs synthetic tests and checks tracked artifact hygiene.
- The documentation workflow uses `actions/checkout@v4` and `actions/setup-python@v5` mutable version tags rather than immutable commit SHAs.
- The documentation workflow's `workflow_dispatch` trigger is a manual documentation-validation trigger; no deployment step or deployment workflow was found in the inspected workflow tree.
- Neither inspected workflow declares a deployment environment or uses repository secrets.

**Recommendation:** Consider pinning the two documentation-workflow actions to reviewed immutable SHAs in a separately scoped workflow-hardening change. This is not an isolation failure and is not changed by this review.

### A-06 — Remote service examples exist in framework config, but are not active defaults
**Disposition:** Pass for current defaults; future activation must be separately governed.

- `config/services.php` contains conventional Postmark, Resend, SES and Slack credential slots.
- `config/mail.php` contains SMTP, SES, Postmark, Resend and other mailer examples.
- `config/logging.php` contains optional Slack, Papertrail, syslog and stderr channels.
- The committed example defaults to local log mail; PHPUnit uses array mail.
- The current application code does not show a mail dispatch, outbound service client, webhook, telemetry exporter or AI/provider integration.

These are framework templates, not proof that a remote service is configured or contacted. No credentials or external service activation are authorized.

### A-07 — Current application surface is narrow
**Disposition:** Verified as a source snapshot.

- The only application route inspected is fixed `GET /health` metadata.
- The route returns a fixed, non-sensitive JSON object; its feature test asserts the exact response.
- The Deeni Madaris visibility policy reads a configuration value with a false fallback; unit tests cover false and unset states.
- No public discovery, search, profile, map, export, sitemap, API, authentication, admin or publication route exists in the inspected tree.

The policy is a default-off seam only. It is not wired into public query/projection surfaces because those surfaces are not present. This is not an end-to-end suppression proof and must remain a future release gate.

### A-08 — Documentation status drift
**Disposition:** Documentation reconciliation needed.

The root `README.md` contains older project-status statements, including references to M3-00 as the current step, old feature-branch status and older PR/acceptance language. `docs/00-foundation/PROJECT_MASTER_CONTROL.md` also describes M3-01 as the current milestone step and says the M3-02 hardening is in progress. The current M3-02 Step 4 pack, isolation plan and current GitHub history show later M3-02 work, including merged PR #143.

This is documentation drift rather than a runtime isolation defect. Reconcile the README, master control, roadmap register, documentation catalogue, traceability and progress report when the Phase A findings are recorded, preserving the distinction between delivery and owner acceptance.

### A-09 — Legacy non-interference evidence remains deliberately bounded
**Disposition:** Policy present; no new legacy-repository inspection performed.

The V2 `LEGACY_REPOSITORY_ISOLATION_AUDIT.md` expressly prohibits legacy code, schema, data, workflows, deployment practices and architecture from influencing V2. It describes its earlier source inventory as targeted metadata only, not exhaustive enumeration. The current V2 snapshot contains the policy document and no direct legacy repository name match in the targeted search.

This review does not claim an exhaustive historical diff or prove that no similar implementation pattern exists. The binding rule remains: V2 work must be based on V2 requirements, independent research and V2 decisions, not legacy artifacts.

## 4. ISO evidence register update

| Evidence ID | Phase A observation | Phase A disposition |
|---|---|---|
| ISO-01 | Repository, default branch and exact commit recorded | **Pass** |
| ISO-02 | Current tracked paths, config and workflow snapshot reviewed; no direct V1 dependency or committed secret found in inspected scope | **Pass for current snapshot, with historical/runtime limitation** |
| ISO-03 | PHP/Composer local runtime not inspected in this GitHub-only phase | **Not verified — Phase B** |
| ISO-04 | Committed example and PHPUnit environment defaults reviewed; no V1 values found | **Partial — local effective config requires Phase B** |
| ISO-05 | Existing CI definition and tests reviewed; this phase did not rerun local tests or prove a database-free local run | **Partial — use existing CI evidence; local confirmation in Phase B** |
| ISO-06 | Public source-tree layout reviewed; actual V2 document root not observable from repository | **Not verified — separate runtime authorization would be required** |
| ISO-07 | No committed secret/config found; runtime secret ownership and web accessibility unknown | **Not verified at runtime** |
| ISO-08 | Local default paths are V2 application-relative; actual runtime storage/cache/session/queue isolation unknown | **Partial / not verified at runtime** |
| ISO-09 | Static health route and exact-response test exist; no live V2 non-production endpoint checked | **Partial — no live test authorized** |
| ISO-10 | No host capacity metadata in repository can prove runtime capacity | **Not verified** |
| ISO-11 | Planning docs describe recovery requirements; no V2 runtime restore/recovery evidence | **Not verified** |
| ISO-12 | This review performed repository reads only; no V1/production/DB writes, deployment or spend | **Pass for this review activity only; not a runtime attestation** |

## 5. Risk and remediation register

| ID | Risk | Severity | Recommended treatment | Change made |
|---|---|---|---|---|
| A-R01 | Actual document root could expose paths outside `public/` if mapped incorrectly | High | Keep as runtime blocker; verify only in a separately authorized V2-only non-production target | None |
| A-R02 | Future environment change could activate database-backed queue/cache/session options | High under current no-DB boundary | Keep database access/configuration prohibited; add explicit database-free configuration assertions only under separate code-change authorization | None |
| A-R03 | Runtime V2 paths/secrets/services may be shared with V1 or production | High | Requires separate target-specific authorization; stop if shared or ambiguous | None |
| A-R04 | Documentation workflow actions are not pinned to immutable SHAs | Medium | Separate workflow-hardening decision/PR | None |
| A-R05 | README/master-control status statements lag current M3-02 state | Medium | Reconcile governing docs and catalogue in a documentation-only follow-up | None |
| A-R06 | Deeni Madaris policy seam is not connected to future public surfaces | High before any public discovery surface | Preserve default OFF; require central policy and cross-surface negative tests before public discovery implementation | None |

## 6. Phase A exit decision

**Phase A — Repository-only static boundary review: COMPLETE for the current `main` snapshot.**

This completion means the planned repository snapshot inventory and findings have been recorded. It does **not** mean:
- historical repository contents have been exhaustively audited;
- local/Codespaces runtime has been verified;
- V2 document-root, host configuration, secrets, storage, sessions, cache or queue are isolated at runtime;
- Hostinger compatibility, capacity or recovery has been proven;
- the environment-isolation M3-02 criterion is met.

No application code, dependencies, environment files, database configuration, workflows, GitHub settings, hosting configuration or runtime resources were changed. No database command or connection, external API, AI provider, telemetry destination, deployment, V1/production access or spend occurred.

## 7. Next permitted action

Proceed to Phase B only within an existing V2 local/Codespaces workspace controlled by the Product Owner. First confirm the exact repository remote, branch and commit. Use only the repository's already declared lockfile dependencies and synthetic local values. Run only documented database-free checks. Do not copy any V1/hosting configuration and do not access Hostinger, V1, production, SSH, hPanel, DNS, deployment or any database.

Phase C remains **NOT AUTHORIZED** and requires a separate explicit Product Owner authorization naming the exact V2-only non-production target, access method, permitted actions, time window and stop conditions.
