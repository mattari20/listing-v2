# M3-11-03 / M3-11-05 — SEC-06 Bounded Logging Policy Design

**Date:** 2026-11-19  
**Status:** CHANNEL AND 30-DAY RETENTION POLICY APPROVED; ACTIVE-LOG DELETION RULE PROPOSED; TARGET STORAGE/ACCESS AND IMPLEMENTATION AUTHORIZATION PENDING  
**Repository:** `mattari20/listing-v2`  
**Scope:** Private V2 development and future private acceptance; synthetic fixtures only

## 1. Purpose

Resolve the repository-side design gap identified by SEC-06 before any future environment provisioning or reviewer access. This record defines the decisions and controls required for a bounded application logging policy. It does not claim that the current runtime is configured safely, that logs have been inspected, or that a hosted environment is ready.

The M3-11-03 Product Owner desk review records that the current default channel resolves to `stack` / `single`, the single-file channel has no rotation limit, the daily channel exists but is not the default, and the effective runtime channel, content, access, forwarding, retention and deletion are unknown.

## 2. Existing repository configuration — source observation

The inspected `config/logging.php` contains:
- Default channel: `env('LOG_CHANNEL', 'stack')`.
- Stack channel defaults to `single`.
- Single and daily file handlers both write to `storage/logs/laravel.log`.
- Single has no configured maximum file count.
- Daily uses `LOG_DAILY_DAYS`, defaulting to 14.
- Monthly uses a fixed maximum of 3 files.
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

These are design requirements; no implementation or log inspection is claimed.

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
| Deletion | Automatically remove rotated application log files older than 30 days from the active V2 log directory; do not assume this also deletes backup-held copies | **PROPOSED OPERATIONAL RULE; BACKUP-COPY HANDLING PENDING TARGET/BACKUP REVIEW** |
| Incident evidence | Preserve only the minimum sanitized evidence under an approved incident process | OWNER/PROCESS NOT ASSIGNED |

The Product Owner approved a 30-day retention period. The proposed operational rule is to remove active V2 rotated log files older than 30 days automatically. This does not establish deletion of any copies held in backups; backup inclusion, retention and expiry must be checked separately against the eventual private V2 backup behavior. The weekly Hostinger backup preference is a backup cadence decision; it does not itself define log retention.

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
- Proposed active-log deletion rule: automatically remove rotated files older than 30 days from the active V2 log directory.
- Backup-held copies are not covered by that rule; their inclusion, retention and expiry behavior must be checked against the eventual private V2 backup process before hosted acceptance.
- Confirmation of the approved private V2 storage location and filesystem permissions after the target is identified.
- Named human owner for log access, retention/deletion and incident evidence.
- Exact implementation authorization for a local/CI-only code-and-test change.
- Later exact-scope environment authorization before any hosted configuration or runtime verification.

Do not infer these decisions from this proposal, the current `LOG_DAILY_DAYS=14` default, or the accepted weekly backup policy.

## 7. Explicit boundaries

This design note authorizes no code/configuration change, dependency, external logging service, environment provisioning, Hostinger/hPanel access, live database connection, backup operation, migration, deployment, DNS/URL change, real/source/personal data, participant activity, public activation, pilot, release candidate or additional spend.

V2 repository-only preparation continues. No V1 or existing eStudent.pk resources may be modified.

## 8. Handoff

The daily rotating channel, disabled external forwarding, 30-day retention period and Warning-and-above hosted log level are approved. The proposed active-log deletion rule is automatic removal of rotated files older than 30 days from the active V2 log directory; backup-held copies remain outside this rule until their handling is verified. Storage/access details must be defined against the private V2 target. A separate explicit authorization for the narrow local/CI implementation remains required. Hosted configuration and online verification remain a later gate after the GitHub–Hostinger deployment connection is established and exact hosted actions are separately authorized.

**SEC-06 disposition:** DAILY ROTATING DEFAULT, DISABLED EXTERNAL FORWARDING, 30-DAY RETENTION AND WARNING-AND-ABOVE HOSTED LOG LEVEL APPROVED; ACTIVE-LOG DELETION RULE PROPOSED; BACKUP-COPY HANDLING AND STORAGE/ACCESS DETAILS PENDING; IMPLEMENTATION NOT AUTHORIZED.  
**M3-11-05:** BLOCKED / NOT ACCEPTED.  
**M3-11 overall:** BLOCKED / NOT ACCEPTED.
