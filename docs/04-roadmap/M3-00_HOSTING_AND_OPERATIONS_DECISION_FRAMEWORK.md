# M3-00 — Hosting and Operations Decision Framework

**Status:** Regional research and evaluation framework prepared; no host, region or vendor selected  
**Related task:** M3-00 T06 — Hosting and vendor decision pack  
**Research date:** 2026-11-12  
**Scope:** Documentation/research only; no account setup, trial, procurement or deployment

## 1. Decision boundary

This document compares hosting approaches and records an initial region research snapshot for a Pakistan-focused public education platform. It does not select a provider, establish legal compliance, prove Pakistan latency, approve a data location, authorize account creation, activate a paid/free trial, procure a service, access production or deploy anything.

No new project spend is authorized. Provider selection requires a separately approved budget posture, current plan-specific quotes, service/region compatibility evidence, legal/privacy review and an accountable human operations owner.

## 2. Requirements

A hosting decision must account for:

- Representative latency and reliability for users in Pakistan, measured from multiple Pakistani networks and cities rather than inferred from geographic distance.
- Data residency, storage, backups, support access, subprocessors, cross-border transfer and contractual terms.
- Supported PostgreSQL/PostGIS versions and extensions if the M2 database candidate remains in consideration.
- Backup frequency, retention, point-in-time recovery, restore testing and recovery objectives.
- Network isolation, identity/access controls, secrets handling, patching, audit logs, vulnerability response and incident notification.
- Availability, support coverage, escalation, service limits and maintenance windows.
- Compute, storage, egress, backup, monitoring, support, tax, FX, renewal and exit costs.
- Exportability, portable backups, termination process and practical provider exit.
- Human skills and operational capacity to patch, monitor, restore, secure and operate the selected platform.

## 3. Initial region research snapshot

The following facts are from provider-published region/location documentation reviewed on 2026-11-12. They are region availability signals only, not proof that every required service, SKU, database extension or support tier is available in every region.

| Provider / option | Published South Asia location evidence | Relevance and caveats |
|---|---|---|
| AWS | Asia Pacific (Mumbai) `ap-south-1`; Asia Pacific (Hyderabad) `ap-south-2` | Both are India regions; Hyderabad is listed as opt-in in AWS region management documentation. Verify service-by-service availability, RDS PostgreSQL/PostGIS support, account region enablement, data terms and current quote. |
| Microsoft Azure | Central India (Pune), India South Central (Hyderabad), West India (Mumbai) appear in the region catalogue | Azure explicitly warns that individual services may not support all region capabilities. Verify Azure Database for PostgreSQL service, extensions, zones, backup/restore and current commercial terms for the selected region. |
| Google Cloud | Cloud SQL for PostgreSQL lists Mumbai (`asia-south1`) and Delhi (`asia-south2`) among regional locations | Google states the instance and data are stored in the selected region and that instance location cannot be changed after creation. Verify PostGIS extension/version support, backup locations, service terms and quote before any decision. |
| Hostinger | Published hosting/VPS location lists include India, with plan-specific location availability | This may be a lower-complexity candidate for comparison, but the exact plan, server location, database control, managed PostgreSQL/PostGIS support, isolation, backups, restore, SLA and operations responsibilities must be verified. Existing familiarity with Hostinger is not evidence of V2 suitability. |

**Geography finding:** the provider region references above identify India and other nearby regions, not a confirmed Pakistan cloud region. This research is not a complete survey of every provider and does not establish that no Pakistan-based data centre exists. Do not infer data residency or legal transfer acceptability from region names alone.

## 4. Candidate operating models

| Model | Potential benefit | Main risk / evidence needed | Current status |
|---|---|---|---|
| Managed application hosting + managed PostgreSQL | Less routine server/database administration; clearer managed backup and patching options | Higher recurring cost; exact extension/version support, region, service limits, data terms and recovery proof must be verified | Evaluation candidate only |
| VPS / self-managed application and database | Greater control and potentially lower fixed entry cost | Owner/team must patch OS, harden network, manage database, backups, restore, monitoring and incident response; operational burden can exceed apparent savings | Evaluation candidate only |
| Split hosting (application and database services separated) | Independent scaling and managed database options | Network latency, private connectivity, egress, firewall configuration and multi-service failure modes | Evaluation candidate only |
| Existing shared/web hosting plan | Familiar control panel and possibly simpler initial operations | May not support required runtime, queue workers, isolation, database extensions, deployment automation or reliable restore process | Not presumed suitable |

No model is selected. A VPS must not be called "managed" unless the provider's exact support responsibilities are verified.

## 5. Required comparison and evidence checklist

For each shortlisted provider and exact plan/SKU, record:

1. Provider, product, plan/SKU, region and dated quote URL/document.
2. Application runtime, worker/queue and deployment support.
3. PostgreSQL version, PostGIS extension/version, backup and point-in-time recovery availability.
4. Availability zones and failover characteristics for the exact services.
5. Storage and backup location; cross-region copies; retention and deletion behaviour.
6. Data processing terms, subprocessors, support access, data transfer and breach notification.
7. Network controls, private connectivity, TLS, secrets, IAM, audit logging and patch ownership.
8. Monitoring, support tier, response commitments and escalation route.
9. Pakistan latency tests across multiple networks, including p50/p95 and packet loss; do not substitute a single ping.
10. One-time and recurring cost including compute, database, storage, backups, bandwidth/egress, IPv4, monitoring, support, taxes and FX.
11. Backup export, restore rehearsal, data export, cancellation, termination and exit cost.
12. Named human operations owner and tested capability to maintain the service.

Mark every item Verified, Measured, Quoted, Owner-confirmed, Assumption or Unknown. Unknown is not a pass.

## 6. Provisional direction

- Do not select hosting yet.
- Shortlist at least one managed PostgreSQL option and one VPS/self-managed option for a like-for-like, no-procurement comparison.
- Keep application and database deployment topology open until M3-05 technology and operations evidence is complete.
- Require a human operations owner and documented restore capability before production readiness.
- Prefer a region based on measured Pakistan user performance, legal/data-transfer review, service support and total cost—not map distance alone.
- Do not use the existing eStudent.pk hosting account or production environment for V2 by assumption. V2 remains independent and requires separately reviewed access, isolation and authorization.

## 7. T06 acceptance criteria

T06 may be submitted for owner review when:

- At least two feasible operating models and provider/region candidates are compared using the same checklist.
- Exact service-level support for the required application runtime, PostgreSQL/PostGIS and backup/restore is verified.
- Data location, transfer, security, support and contractual terms are recorded for each finalist.
- Pakistan latency evidence is measured or explicitly deferred with a safe test plan.
- Dated quotes and total-cost calculations are recorded, or owner explicitly defers provider selection and accepts the blocker.
- A named human operations owner and recovery responsibility are identified or explicitly accepted as unresolved.

Until then, T06 remains **In progress**. No partial task percentage is claimed and no provider is selected.

## 8. Explicit non-authorizations

No hosting account, cloud project, paid or free trial, subscription, server, database, credential, connector, deployment, production access, data transfer, procurement or spend is authorized.
 
## 9. Official sources reviewed

- AWS Regions and Availability Zones: https://docs.aws.amazon.com/global-infrastructure/latest/regions/aws-regions.html
- AWS India infrastructure: https://aws.amazon.com/local/india/
- AWS region enablement: https://docs.aws.amazon.com/accounts/latest/reference/manage-acct-regions.html
- Microsoft Azure region list: https://learn.microsoft.com/azure/reliability/regions-list
- Google Cloud SQL for PostgreSQL locations: https://docs.cloud.google.com/sql/docs/postgres/locations
- Hostinger server locations: https://www.hostinger.com/support/1583267-where-are-hostinger-servers-located

Provider documentation can change. Re-check the exact service, plan, region and contract before any future approval.
