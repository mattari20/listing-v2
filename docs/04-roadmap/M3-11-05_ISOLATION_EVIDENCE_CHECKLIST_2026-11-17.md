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
