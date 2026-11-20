# M3-11-05 — V2 Environment Isolation Evidence Checklist

**Status:** TEMPLATE — NO HOSTED ENVIRONMENT TESTED

| ID | Evidence item | Required result | Current status |
|---|---|---|---|
| ISO-01 | Exact target identity and owner | Named V2-only account/project/resource identifiers | NOT PROVIDED |
| ISO-02 | Provider/account boundary | No V1/production resource sharing | NOT VERIFIED |
| ISO-03 | Runtime boundary | Dedicated V2 app/runtime/configuration | NOT VERIFIED |
| ISO-04 | Database boundary | Dedicated V2 database and credentials | NOT VERIFIED |
| ISO-05 | Storage boundary | Dedicated V2 file/object storage and keys | NOT VERIFIED |
| ISO-06 | Cache/session/queue boundary | Dedicated V2 state stores/credentials | NOT VERIFIED |
| ISO-07 | Secret separation | Unique V2 secrets; no legacy secret reuse | NOT VERIFIED |
| ISO-08 | Ingress | Private allowlist; no public anonymous ingress | NOT VERIFIED |
| ISO-09 | Egress | Deny by default; no unapproved external destinations | NOT VERIFIED |
| ISO-10 | Identity/access | Named approved identities, least privilege, expiry/revocation | NOT VERIFIED |
| ISO-11 | Synthetic data | Fixtures only; no real/source/production data | NOT VERIFIED |
| ISO-12 | Email/notifications/integrations | Disabled or safely synthetic-only; no external delivery | NOT VERIFIED |
| ISO-13 | Logs/telemetry | Redacted, access-controlled and retention-bounded | NOT VERIFIED |
| ISO-14 | Backup boundary | V2-only backup destination, credentials and encryption | NOT VERIFIED |
| ISO-15 | Negative isolation checks | No V2 access to V1/production; tested only against safe controlled endpoints | NOT RUN |
| ISO-16 | Independent security review | Written review of design, evidence and findings | NOT RECEIVED |
| ISO-17 | Human operations acceptance | Provisioning, operations, security and recovery owners accept roles | NOT RECEIVED |
| ISO-18 | Product Owner acceptance | Dated acceptance of exact environment and residual risks | NOT RECEIVED |

## Evidence handling rules

- Attach only redacted, synthetic-safe evidence.
- Never commit secrets, access tokens, private keys, connection strings or personal data.
- Each evidence item must include date, environment identifier, responsible human, method, result and reviewer.
- A screenshot without a traceable resource identifier and method is insufficient.
- A CI pass or repository configuration check is not proof of hosted isolation.
- Do not test connectivity against V1 or production. Negative checks must use controlled synthetic endpoints/resources.

**Current count:** 0/18 items verified. This records missing evidence, not a claim that an environment is insecure; no target environment has been inspected.


## 2026-11-20 — historical resource-readiness evidence reconciliation

This addendum classifies previously recorded owner-provided evidence and the bounded 2026-11-19 CLI verification against the 18 isolation items. It does not authorize or report any new Hostinger/hPanel access, HTTP request, database connection, deployment, migration, backup operation or environment test.

| ID | Reconciled evidence status | Evidence boundary / remaining gap |
|---|---|---|
| ISO-01 | PARTIAL — candidate resources identified in historical owner-provided records | A selected V2 folder and dedicated database resources were recorded. Complete provider/account ownership, exact resource inventory and acceptance-target identity are not independently verified. |
| ISO-02 | NOT VERIFIED | A dedicated database was recorded, but no complete V1/production non-sharing proof or negative isolation test exists. |
| ISO-03 | PARTIAL — runtime/CLI evidence | PHP 8.5.12, Composer 2.9.8, locked dependency installation, platform checks and a synthetic in-memory SQLite Laravel CLI boot were recorded. HTTP/LiteSpeed entry point, web runtime and full isolation remain untested. |
| ISO-04 | PARTIAL — dedicated database resource observed | Database/user creation was recorded. No Laravel connection, query, schema operation, credential isolation proof or negative V1 connectivity test was performed. |
| ISO-05 | NOT VERIFIED | No complete V2 storage namespace, path exposure, ownership, permissions or object/file isolation evidence. |
| ISO-06 | PARTIAL — repository defaults documented | Session/cache/queue defaults are now reconciled in the DP-06 addendum. Effective hosted stores, credentials, prefixes and non-sharing remain unknown. |
| ISO-07 | NOT VERIFIED | A dedicated database user was recorded; complete V2 secret inventory, uniqueness, storage and absence of legacy-secret reuse are not proven. No secret values belong in this register. |
| ISO-08 | PARTIAL — configuration directive observed | Basic Auth directives were visible in owner-provided evidence. Actual enforcement across all routes/static assets, child-path behavior and direct credential-file denial remain untested. |
| ISO-09 | NOT VERIFIED | No target egress policy or controlled negative egress test evidence. |
| ISO-10 | NOT VERIFIED | No complete named environment access roster, MFA evidence, least-privilege review, expiry or revocation evidence. |
| ISO-11 | PARTIAL — synthetic CLI smoke conditions recorded | The CLI smoke test used ephemeral/synthetic values and in-memory SQLite. No full target data inventory or hosted fixture-state inspection. |
| ISO-12 | NOT VERIFIED | No complete target-level proof of disabled/sinkholed email, notifications or all outbound integrations. |
| ISO-13 | PARTIAL — repository/local-CI logging controls | DP-03/SEC-06 source implementation is documented; hosted log path, access, redaction, forwarding and backup copies remain unverified. |
| ISO-14 | PARTIAL — owner policy only | Existing weekly automated backups were accepted for the current development stage. V2-only backup source/destination, encryption, retention, restore and recovery boundary are not verified. |
| ISO-15 | NOT RUN | No controlled negative isolation test has been performed; do not probe V1/production. |
| ISO-16 | NOT RECEIVED | No independent assessment of the actual environment/isolation evidence. |
| ISO-17 | NOT RECEIVED | Required human environment/operations/security/recovery role acceptances are not evidenced. |
| ISO-18 | NOT ACCEPTED | No dated acceptance of a fully evidenced exact environment and residual risks. |

**Count:** 0/18 items are fully verified for environment-isolation acceptance. Several items have partial historical/source evidence; this is more precise than describing every item as having no evidence. Partial evidence does not promote an item to verified and does not make the environment accepted.

The existing weekly-backup cadence, no-additional-spend preference and selected directory-password-protection approach remain recorded owner decisions. They are not reopened. Their technical effectiveness and V2-only isolation remain evidence questions, not new owner decisions.

No additional hosted action is authorized by this reconciliation.
