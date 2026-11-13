# M3-02 — Environment Configuration and Diagnostics Baseline

**Status:** Implemented for local/CI foundation; pending exact-head CI and Product Owner review  
**Scope:** Local workstation and GitHub-hosted CI only  
**Data:** Synthetic fixtures only  
**Spend:** None  
**Production / Hostinger / V1:** Prohibited  
**Database:** No database configuration, connection, schema or migration is part of this baseline

## 1. Environment boundary

| Environment | Permitted purpose | Configuration boundary | Data / credentials |
|---|---|---|---|
| Developer local workstation / Codespace | Build, inspect and test the V2 repository | Local untracked `.env`; no production URL or remote service endpoints | Synthetic fixtures only; developer-generated local APP_KEY; never commit secrets |
| PHPUnit | Deterministic automated tests | `APP_ENV=testing`; synthetic APP_KEY in `phpunit.xml`; array cache/session, sync queue, array mail, null broadcast | Synthetic fixtures only; no production secrets |
| GitHub Actions CI | Reproducible PR checks | Workflow uses read-only `contents: read`; PHP 8.5 / Composer 2; no repository secrets required by the current job | Synthetic tests only; no Hostinger/V1/production credentials or external service calls |
| Hostinger / V1 / production | Out of scope | No environment is configured or accessed by this work | Prohibited |

A local `.env` is private and ignored by Git. Copying `.env.example` is only a local setup action. Generate a unique local APP_KEY with Laravel's local tooling; never reuse the deterministic PHPUnit key outside tests. Do not paste secrets into issues, pull requests, logs or chat.

## 2. Environment variable inventory

The committed `.env.example` contains only non-secret local placeholders:

| Variable | Purpose | Safe baseline / handling |
|---|---|---|
| `APP_NAME` | Local display name | V2 application name |
| `APP_ENV` | Runtime environment label | `local` in example; `testing` in PHPUnit |
| `APP_KEY` | Local encryption key | Blank placeholder; generate locally; test key is synthetic and test-only |
| `APP_DEBUG` | Detailed error display | `false`; never enable on a public service |
| `APP_URL` | Local URL generation | `http://localhost`; do not replace with production URL |
| `APP_LOCALE`, `APP_FALLBACK_LOCALE` | Locale defaults | `en` pending later product localization work |
| `LOG_CHANNEL` | Default log destination | `stack` with local single-file channel |
| `LOG_LEVEL` | Minimum emitted log severity | `warning`; do not lower to debug for shared/public use |
| `CACHE_STORE` | Cache backend | `array` for isolated non-persistent foundation operation |
| `SESSION_DRIVER` | Session backend | `array`; no persistent user session store |
| `QUEUE_CONNECTION` | Queue backend | `sync`; no worker or external queue |
| `FILESYSTEM_DISK` | Default file storage | `local`; no cloud disk configured for use |
| `MAIL_MAILER` | Mail transport | `log` in local example; PHPUnit overrides to `array`; no email sending is authorized |

The Laravel framework contains dormant configuration examples for optional drivers. Their presence is not permission to activate them. Do not add DB, Redis, S3, SMTP, Slack, Papertrail, cloud, telemetry or other remote credentials/endpoints without a separate approved scope.

## 3. Secret lifecycle and handling rules

- Keep the real `.env` untracked and ignored. Do not commit backups, production env files, keys, tokens, certificates or credential exports.
- Use only developer-generated local keys and the deterministic synthetic key defined in PHPUnit configuration.
- Do not add GitHub Actions secrets to the current foundation workflow. Its permissions remain `contents: read`.
- Do not echo environment variables, dump configuration arrays, print request headers, cookies, authorization values or secret-bearing exception context in CI output.
- If a credential is accidentally exposed, stop, report the exposure and request owner direction; do not rotate or access any production credential as part of this package.
- No secrets are needed for Composer audit, formatting, route listing or synthetic PHPUnit tests.

## 4. Logging and diagnostics policy

The application logging configuration now defaults to `warning` rather than `debug` when `LOG_LEVEL` is absent. The default channel remains a local stack containing the single-file channel. Deprecation logging defaults to the null channel and trace capture remains disabled.

Permitted diagnostics in this stage:
- CI step outcomes and test assertion failures.
- PHP/Laravel version and Composer version.
- Fixed route listing and non-sensitive health response.
- Warning/error diagnostics needed to investigate synthetic test failures.

Never log:
- Request or response bodies by default.
- Authorization headers, cookies, session identifiers, APP_KEY, tokens or credentials.
- Student, child, staff, institute contact or other personal data.
- Source documents, scraped content, private records or unreviewed evidence.
- Full environment dumps, database connection strings or secrets in exception context.

Do not add external telemetry, tracing exporters, error-reporting SaaS, analytics, webhook log channels or outbound log shipping. Do not claim a production monitoring/alerting capability; none exists in this scope. A local log file is diagnostic output, not an approved long-term retention system. Keep logs out of commits and PR attachments.

## 5. Automated verification

`FoundationEnvironmentDefaultsTest` asserts:
- PHPUnit is running in the `testing` environment and debug mode is off.
- Cache and session defaults are in-memory array stores.
- Queue default is synchronous.
- Filesystem default is local.
- Logging defaults to the local stack/single channel at warning level.
- Deprecation logging is disabled by default and trace capture is off.

The existing CI additionally checks Composer manifest/lock integrity, dependency advisories, Pint formatting, Laravel bootstrap and route listing, the full synthetic PHPUnit suite, tracked-artifact hygiene and project documentation links.

No PHPStan/Psalm or other static-analysis package is added in this slice. The current repository does not contain an approved static-analysis baseline; adding a new dependency would require a separate maintenance/value decision. Existing deterministic quality checks are retained without adding paid services or network integrations.

## 6. Read-only repository protection audit

Read-only GitHub API inspection on 2026-11-13 found one active repository ruleset targeting the default branch:
- Ruleset ID: `27043221`, name `main`, enforcement `active`.
- Rules: deletion blocked; non-fast-forward updates blocked; pull requests required; required review-thread resolution; extra approval for unattributed changes; linear history required.
- Required status check: `Validate project control documents`.
- Required approving review count: `0`.
- Allowed merge methods: merge, squash and rebase.
- Bypass actors: none; current user cannot bypass.

The GitHub integration could not read the legacy branch-protection endpoint (HTTP 403). The ruleset is visible and active, but the effective protection configuration should be rechecked by an authorized repository owner in GitHub settings. Importantly, the active ruleset does **not** currently require `PHP 8.5 foundation checks`; the workflow runs on PRs but is not listed as a required ruleset status check. This is a governance gap, not a CI failure.

No ruleset, branch protection or repository setting was changed in this work. Requiring the PHP foundation check, setting a non-zero approval count, or changing bypass/merge rules are proposed governance changes and need separate owner approval before implementation.

## 7. Explicit exclusions and limitations

This baseline does not provide:
- Hostinger, V1 or production runtime/environment isolation evidence.
- Database configuration, connectivity, migrations, schema or persistent storage.
- Authentication, user accounts, real user sessions or authorization workflows.
- Production log retention, centralized observability, metrics, traces, alerts or incident response.
- Independent security certification, legal/privacy/safeguarding sign-off or production readiness.

Any step that needs a live service, real data, remote credentials, a database, external endpoint, paid service, deployment or material policy change is outside this authorization and must stop for a new owner decision.
