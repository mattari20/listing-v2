# M3-11-03 / M3-11-05 — SEC-06 Bounded Logging Policy Design

**Date:** 2026-11-19  
**Status:** POLICY APPROVED; LOCAL/CI IMPLEMENTATION AUTHORIZED AND VALIDATED IN PR #312; HOSTED STORAGE/ACCESS AND VERIFICATION PENDING  
**Repository:** `mattari20/listing-v2`  
**Scope:** Private V2 development and future private acceptance; synthetic fixtures only

## 1. Purpose

Resolve the repository-side design gap identified by SEC-06 before any future environment provisioning or reviewer access. This record defines the decisions and controls required for a bounded application logging policy. It does not claim that the current runtime is configured safely, that logs have been inspected, or that a hosted environment is ready.

The M3-11-03 Product Owner desk review found that the then-current default resolved to `stack` / `single`, with no single-file rotation limit. PR #312 subsequently changed the repository default to bounded daily local-file logging. Effective hosted runtime channel, content, access, forwarding, retention and deletion remain unverified.

## 2. Existing repository configuration — source observation

The pre-implementation `config/logging.php` inspected for this policy contained:
- Default channel: `env('LOG_CHANNEL', 'stack')`.
- Stack channel defaulted to `single`.
- Single and daily file handlers both wrote to `storage/logs/laravel.log`.
- Single had no configured maximum file count.
- Daily used `LOG_DAILY_DAYS`, defaulting to 14.
- Monthly used a fixed maximum of 3 files.

PR #312 changes the default to the custom daily rotating handler with explicit age-based active-directory cleanup. See its implementation evidence note for exact-head CI and limitations.
- Slack, Papertrail, stderr, syslog and errorlog channel definitions exist.
- The repository configuration alone does not prove that any external channel is active or that any runtime environment uses these settings.

No log files, live runtime, hosting account, production/V1 resource or real data were accessed for this design note.

## 3. Mandatory data-minimization rules for any future implementation

The application must not deliberately log:
- Passwords, password hashes, authentication tokens, session IDs, cookies, authorization headers, API keys, database credentials, private keys or other secrets.
- Full request/response bodies or arbitrary form payloads.
- Raw evidence contents, source documents, private reviewer material, internal claim payloads or unfiltered entity records.
- Personal contact details, student/guardian/staff records, precise location or any real personal/sensitive data.
- Full SQL bindings or exception context that could reproduce secrets or protected records.

Where diagnostic correlation is required, use a non-sensitive event code and a generated correlation identifier. Do not place raw user-controlled strings into structured log context without length limits and safe encoding. Error responses to users must not expose stack traces or secrets.

These are design requirements. The local/CI implementation is recorded in PR #312; no real log inspection or hosted verification is claimed.

## 4. Approved channel and retention decisions — target verification pending

The channel, log-level, retention and forwarding decisions below have Product Owner approval for the future private V2 acceptance target. Their effective runtime behavior remains unverified until a separately authorized private V2 environment exists. Storage, permissions, access and operational deletion details remain pending:

| Decision | Proposed baseline | Current disposition |
|---|---|---|
| Default file channel | Daily rotating local file handler, rather than unbounded single file | **APPROVED BY PRODUCT OWNER — 2026-11-19** |
| Log level | Warning and above for hosted private acceptance; local development may use a separately configured level | **APPROVED BY PRODUCT OWNER — 2026-11-19** |
| Retention | 30 days | **APPROVED BY PRODUCT OWNER — 2026-11-19** |
| External forwarding | Disabled; no Slack, Papertrail, syslog service or third-party log vendor | **APPROVED TO REMAIN DISABLED — 2026-11-19** |
| File location | V2-only private storage outside public document root | TARGET PATH NOT VERIFIED |
| File permissions | Least-privilege read/write for the V2 runtime identity; no public/static access | NOT VERIFIED |
| Access | Named authorized operators only; access evidence retained in restricted operational records | NOT ASSIGNED |
| Deletion | Automatically remove rotated application log files older than 30 days from the active V2 log directory; do not assume this also deletes backup-held copies | **APPROVED BY PRODUCT OWNER — 2026-11-19; BACKUP-COPY HANDLING PENDING TARGET/BACKUP REVIEW** |
| Incident evidence | Preserve only the minimum sanitized evidence under an approved incident process | OWNER/PROCESS NOT ASSIGNED |

The Product Owner approved a 30-day retention period and, on 2026-11-19, approved automatic removal of active V2 rotated log files older than 30 days. This does not establish deletion of any copies held in backups; backup inclusion, retention and expiry must be checked separately against the eventual private V2 backup behavior. The weekly Hostinger backup preference is a backup cadence decision; it does not itself define log retention.

## 5. Required negative controls and verification

Before environment acceptance, a separately authorized implementation and verification package must demonstrate:

1. The effective runtime channel is the approved bounded channel, not an unbounded single-file fallback.
2. Rotation and maximum retention are enforced as configured.
3. External forwarding is disabled unless a future separate owner decision authorizes a specific destination and data-processing review.
4. Representative synthetic requests and exceptions do not log passwords, cookies, session IDs, authorization headers, request bodies, raw claim/evidence payloads or synthetic contact fields.
5. Correlation identifiers are generated safely and do not embed user-supplied personal data.
6. Log files are outside the public document root and cannot be fetched through direct HTTP paths.
7. File ownership and permissions restrict access to the V2 runtime and explicitly authorized operators.
8. Application errors returned to clients do not expose stack traces, SQL, filesystem paths or secrets.
9. Rotation and deletion of active V2 log files older than 30 days is documented and tested; backup inclusion, retention and expiry behavior is separately evidenced without touching V1 or production resources.
10. A sanitized test report identifies exact commit, configuration, test commands, results and limitations.

No hosted or browser verification is claimed. The online checks will be performed after the GitHub–Hostinger deployment connection and the separately authorized private V2 deployment are established.

## 6. Decisions and evidence still required

- Approved 2026-11-19: use the daily rotating local-file handler as the intended private V2 default; keep external forwarding disabled.
- Product Owner approved a 30-day application-log retention period on 2026-11-19.
- Product Owner approved Warning and above as the hosted private V2 log level on 2026-11-19; local development may use a separately configured level.
- Product Owner approved 2026-11-19: automatically remove rotated application log files older than 30 days from the active V2 log directory.
- Backup-held copies are not covered by that rule; their inclusion, retention and expiry behavior must be checked against the eventual private V2 backup process before hosted acceptance.
- Confirmation of the approved private V2 storage location and filesystem permissions after the target is identified.
- Named human owner for log access, retention/deletion and incident evidence.
- Local/CI implementation authorization: APPROVED BY PRODUCT OWNER — 2026-11-19; implementation is recorded in PR #312.
- Later exact-scope environment authorization before any hosted configuration or runtime verification.

Do not infer these decisions from this proposal, the current `LOG_DAILY_DAYS=14` default, or the accepted weekly backup policy.

## 7. Explicit boundaries

This design note authorizes no code/configuration change, dependency, external logging service, environment provisioning, Hostinger/hPanel access, live database connection, backup operation, migration, deployment, DNS/URL change, real/source/personal data, participant activity, public activation, pilot, release candidate or additional spend.

V2 repository-only preparation continues. No V1 or existing eStudent.pk resources may be modified.

## 8. Handoff

The daily rotating channel, disabled external forwarding, 30-day retention period, Warning-and-above hosted log level and automatic removal of rotated active-directory log files older than 30 days are approved. Backup-held copies remain outside this rule; backup-held copies remain outside this rule until their handling is verified. Storage/access details must be defined against the private V2 target. The narrow local/CI implementation was separately authorized by the Product Owner on 2026-11-19 and is recorded in PR #312. Hosted configuration and online verification still require a later exact-scope authorization. Hosted configuration and online verification remain a later gate after the GitHub–Hostinger deployment connection is established and exact hosted actions are separately authorized.

**SEC-06 disposition:** DAILY ROTATING DEFAULT, DISABLED EXTERNAL FORWARDING, 30-DAY RETENTION, WARNING-AND-ABOVE HOSTED LOG LEVEL AND AUTOMATIC DELETION OF ACTIVE-DIRECTORY ROTATED LOGS OLDER THAN 30 DAYS APPROVED; LOCAL/CI IMPLEMENTATION AUTHORIZED AND VALIDATED IN PR #312; BACKUP-COPY HANDLING AND HOSTED STORAGE/ACCESS DETAILS PENDING.  
**M3-11-05:** BLOCKED / NOT ACCEPTED.  
**M3-11 overall:** BLOCKED / NOT ACCEPTED.
