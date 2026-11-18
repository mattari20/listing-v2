# M3-11-03 SEC-06 — Local/CI Implementation Authorization Package

**Date:** 2026-11-19  
**Status:** IMPLEMENTATION AUTHORIZATION REQUESTED — NOT AUTHORIZED  
**Depends on:** SEC-06 policy decisions recorded in PR #308, commit `2f26bf058356799f342f992f02f3e373304dc504`  
**Repository:** `mattari20/listing-v2`  
**Scope requested:** Local workstation and GitHub CI only; synthetic fixtures only

## 1. Purpose and decision sought

This package translates the Product Owner-approved SEC-06 logging policy into a bounded repository implementation proposal. It is an authorization request, not an implementation and not evidence that the runtime or any hosted target is configured.

**Decision requested:** authorize only the repository-side configuration and regression-test work described in Sections 3–6, performed locally and in GitHub CI using synthetic fixtures. No hosted configuration, live runtime, Hostinger/hPanel, V1/production, database, backup, deployment, migration, public activation, external service, or additional spend is included.

No implementation begins until the Product Owner gives a separate, explicit approval of this exact scope.

## 2. Approved policy baseline

The Product Owner has approved the following for future private V2 hosting:

1. Daily rotating local-file logging as the intended hosted private V2 default.
2. Warning and above as the hosted private V2 log level. Local development may use a separately configured level.
3. Thirty-day application-log retention.
4. External log forwarding disabled.
5. Automatically remove rotated application log files older than 30 days from the active V2 log directory.
6. The active-directory deletion rule does not automatically cover backup-held copies. Backup inclusion, retention and expiry must be verified separately against the eventual private V2 backup process.

These policy decisions do not establish the actual hosted path, permissions, effective environment values, backup behavior or operational access.

## 3. Repository observations informing the proposal

The current `config/logging.php` on `main` has these relevant defaults:

- `LOG_CHANNEL` defaults to `stack`.
- `stack` defaults to `single`.
- The `daily` channel exists and uses `LOG_DAILY_DAYS`, currently defaulting to 14.
- The single-file handler has no rotation limit.
- Third-party and external handler definitions exist in configuration, but their presence does not prove they are active.

The approved private-hosting policy is therefore not yet reflected by the current default configuration. No log files, runtime, Hostinger account, V1/production resource or real data were inspected.

## 4. Proposed local/CI implementation boundary

If separately authorized, the repository implementation should be limited to:

### 4.1 Logging configuration

- Make the application’s safe default resolve to the daily local-file channel, while preserving an explicit environment override for local development and future target-specific configuration.
- Set the daily retention configuration baseline to 30 days.
- Ensure the hosted private V2 baseline uses Warning and above; local development may override the level deliberately.
- Ensure the default stack does not include external forwarding handlers.
- Do not remove third-party channel definitions merely because they exist; prove they are not selected by the approved default path.
- Keep configuration free of credentials, webhook URLs, tokens or other secrets.

The exact default/override implementation must be reviewed against the repository’s Laravel configuration conventions before editing. No production or hosted environment variables are to be changed.

### 4.2 Retention semantics — important technical distinction

Laravel’s daily Monolog handler uses a maximum-file-count setting (`max_files`); a count of 30 is not automatically equivalent to an exact calendar-age rule when files are missing, irregularly created, or retained under unexpected names.

The implementation must not claim that setting `max_files=30` alone proves “delete every rotated file older than 30 days.” Before coding, verify the installed Monolog version and its actual rotation/cleanup semantics from the locked dependency source or package documentation. Then choose and test a mechanism that enforces the approved age-based rule safely.

Any cleanup mechanism must:
- Operate only within the configured active V2 log directory.
- Match only the application’s expected rotated log filename pattern.
- Use file modification/rotation dates consistently and document the chosen age boundary.
- Never traverse parent directories, follow arbitrary symlinks, or delete unrelated files.
- Avoid deleting the current active log file.
- Fail safely and report a sanitized operational error if the directory is unavailable or permissions are insufficient.
- Have deterministic tests using temporary directories and synthetic files, including boundary dates, unexpected names, nested paths, symlinks where supported, and backup-like files outside the active directory.

No actual host log cleanup or backup operation is part of this scope.

### 4.3 Data minimization and safe logging

- Add focused regression tests for representative synthetic log records.
- Assert that passwords, password hashes, tokens, session identifiers, cookies, authorization headers, API keys, request/response bodies, raw claim/evidence payloads, and synthetic contact fields are not emitted by application logging paths covered by the tests.
- Prefer allowlisted event context, generated correlation identifiers and bounded/safely encoded values.
- Do not log arbitrary request payloads, SQL bindings or full exception context that could reproduce secrets or protected data.
- Do not add real personal data or real source records to fixtures.

Tests must be based on actual logging entry points and existing application behavior; do not introduce a broad logging abstraction or refactor unrelated features.

### 4.4 Storage and access boundaries

- Repository tests may verify that the configured application log path is not the public document root and is not a public asset path.
- Do not claim that this proves the eventual Hostinger path is outside the public document root.
- Actual V2-only storage path, filesystem ownership, permissions, named authorized operators, web-server reachability and backup-copy behavior remain deferred until the private V2 target is identified and separately authorized for inspection.

## 5. Expected files and change limits

Expected implementation touchpoints, subject to repository inspection at the time authorization is granted:

- `config/logging.php`
- One or more narrowly scoped feature/unit tests under `tests/`
- A short evidence note under `docs/04-roadmap/` recording exact commit, commands, results and limitations

Permitted scope:
- Existing dependencies only.
- Synthetic test fixtures only.
- Local workstation and GitHub CI only.
- No production data, credentials, external APIs, external logging destinations or new spend.

Not permitted:
- Hostinger/hPanel or any hosted runtime access.
- V1, eStudent.pk production or production database access.
- Any database/schema/migration change.
- Deployment, DNS/URL change, public activation, pilot or release-candidate declaration.
- Backup creation, download, deletion, restoration or alteration.
- External telemetry, logging forwarding, analytics or monitoring services.
- New packages/dependencies, hosting upgrades or paid services.
- Changes outside the named logging configuration, focused tests and evidence documentation without a new scope decision.

## 6. Required local/CI acceptance evidence

The implementation is not complete unless the exact implementation commit has evidence for all applicable checks:

1. Configuration resolves to the intended daily local-file channel by default.
2. The hosted private V2 level baseline resolves to Warning and above; explicit local overrides remain possible.
3. The default channel graph contains no external forwarding destination.
4. Daily rotation is exercised with synthetic temporary files.
5. Age-based deletion removes only eligible rotated files older than 30 days from the active test directory.
6. Boundary-age, current-file, unexpected-name, unrelated-file, nested-path and symlink cases are tested as applicable.
7. Secret/data-minimization regression tests demonstrate that representative synthetic secret values are not written.
8. Log path tests establish only the repository-level path property they can actually prove; they make no hosted-path claim.
9. Existing project tests, PHP lint/formatting and required project documentation validation pass.
10. Exact-head GitHub CI is green; report warnings and skipped tests rather than calling the run warning-free.
11. Evidence identifies the exact commit, commands, results, changed files, test limitations and any unresolved issue.

Any failed safety test, unexpected filesystem traversal, secret leakage, external handler activation, or ambiguity about deletion scope is a stop condition. Do not weaken or skip a test to obtain a pass.

## 7. Stop conditions and change control

Stop and report without proceeding if:
- The installed Monolog behavior does not support the approved age-based deletion rule safely without a new dependency or broader architecture change.
- The configured log directory cannot be safely constrained to the active V2 log directory.
- A test would require real data, hosted access, credentials, external services or additional spend.
- The implementation would affect unrelated application behavior or require a database, deployment or production change.
- Exact scope cannot be preserved.

A new authorization is required for any scope expansion, dependency, host operation, backup operation, external destination, deployment or production action.

## 8. Deferred hosted acceptance work

The following remain later, separately authorized activities after the GitHub–Hostinger deployment connection and private V2 target are established:

- Confirm the actual V2-only log directory is outside the public document root.
- Verify effective hosted channel, level, rotation and retention.
- Verify filesystem ownership, permissions and direct-HTTP inaccessibility.
- Identify authorized human operators and restricted access evidence.
- Determine whether backups include active/rotated logs and verify backup-held copy retention/expiry.
- Verify recovery and incident evidence handling without touching V1/production.

The approved weekly Hostinger backup cadence does not establish backup retention duration or log-copy expiry.

## 9. Product Owner authorization record

**Requested decision:** authorize the exact local-workstation/GitHub-CI implementation scope in Sections 3–7, with synthetic fixtures only and all exclusions preserved.

**Current disposition:** NOT AUTHORIZED. No code or configuration implementation may begin based on this request alone.

**SEC-06 policy:** approved as recorded in the dependent policy PR.  
**SEC-06 implementation:** pending separate explicit authorization.  
**Hosted verification:** deferred and not authorized.  
**M3-11-05:** BLOCKED / NOT ACCEPTED.  
**M3-11 overall:** BLOCKED / NOT ACCEPTED.
