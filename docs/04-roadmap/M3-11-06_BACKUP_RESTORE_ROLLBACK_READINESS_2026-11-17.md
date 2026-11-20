# M3-11-06 — Backup, Restore and Rollback Readiness Preparation

**Date:** 2026-11-17  
**Package:** M3-11-06  
**Scope:** Private V2 acceptance environment only; synthetic data only  
**Status:** REPOSITORY PREPARATION DELIVERED; RECOVERY READINESS BLOCKED

## 1. Purpose and limits

Define the recovery controls and evidence required before any future private V2 acceptance activity or release candidate can be accepted. This record separates backup, restore, application rollback and data recovery because they solve different failure modes.

This is documentation-only preparation. No environment has been identified or authorized, no backup has been created or accessed, no database or storage snapshot has been taken, no restore or rollback has been rehearsed, and no RPO/RTO has been measured. Do not infer recovery capability from provider features, GitHub history, CI success or a written plan.

## 2. Recovery objectives — owner decision required

The Product Owner and accountable human operations/recovery owners must set and accept measurable objectives before any rehearsal.

| Objective | Meaning | Current value |
|---|---|---|
| RPO — Recovery Point Objective | Maximum acceptable data loss measured as elapsed time between last recoverable consistent point and incident | NOT SET |
| RTO — Recovery Time Objective | Maximum acceptable elapsed time from declared recovery start to verified service restoration | NOT SET |
| Backup frequency | Maximum interval between successful, consistent backups | WEEKLY automated backups — owner-accepted for the current development stage only; V2-only recovery coverage is not verified |
| Retention | Approved number/age of recovery points and deletion schedule | NOT SET |
| Restore verification frequency | How often a restore is tested and evidence refreshed | NOT SET |
| Backup integrity check | Required checksum/manifest/restore validation method | NOT SET |
| Recovery access | Named humans permitted to initiate, approve and verify recovery | NOT ASSIGNED |

Do not select arbitrary RPO/RTO numbers or claim they are achievable. Proposed targets must be supported by actual system design, provider capabilities, human coverage, cost approval and measured rehearsal results.

## 3. Required backup boundaries

Before any backup operation is authorized, prove:
- Backup source is the exact V2-only environment and resource inventory accepted under M3-11-05.
- Backup destination, account/project, storage namespace, encryption/key boundary and credentials are dedicated to V2.
- No V1 or production database, storage, snapshot, secret or personal data is included.
- Backup includes the explicitly approved application data and required metadata only; exclusions and consistency model are documented.
- Database and file/object storage are captured consistently or the consistency gap is understood and accepted.
- Encryption at rest/in transit, access controls, retention, deletion, integrity checks and audit evidence are documented and verified.
- Backup credentials are least-privilege and separate from application credentials where supported.
- Backup failures are detected and escalated to an accepted human owner.
- Recovery copies cannot be overwritten or deleted by the same ordinary application identity where supported by the approved platform.
- Any provider capability or cost not already available requires separate approval; do not enable paid add-ons or new vendors.

## 4. Restore requirements

A restore rehearsal must occur only after separate exact authorization and on an isolated, disposable V2-only target with synthetic data.

Required sequence:
1. Identify the exact approved backup, creation time, source environment, schema/application version and integrity manifest.
2. Verify backup identity and integrity without exposing secrets or personal data.
3. Confirm target is disposable, isolated and not connected to V1/production or public ingress.
4. Record pre-restore target state and approved recovery-point selection.
5. Restore database and file/object assets using the documented order and consistency procedure.
6. Apply only the migration/version alignment steps explicitly included in the approved rehearsal plan; do not migrate production or live systems.
7. Verify application boot, routes, synthetic fixture integrity, relationship consistency, authorization boundaries and default-OFF features.
8. Measure elapsed restore time and effective data-loss window.
9. Record defects, missing assets, integrity failures, manual steps and residual risks.
10. Destroy or reset the disposable target only under an approved cleanup plan; retain sanitized evidence.

A successful database import alone is not a successful service restore. A restore is accepted only after the application and relevant synthetic workflows are verified.

## 5. Application rollback versus data recovery

- **Application rollback:** return application code/configuration to a known prior release candidate. Requires an immutable artifact/version reference, compatible configuration and tested rollback command/procedure.
- **Database/data recovery:** recover a consistent data point from an approved V2-only backup. It may lose writes after the recovery point and may not be safely reversible.
- **Forward fix:** deploy a corrective application change when reverting code would worsen data compatibility or security.
- **Full environment rebuild:** recreate the approved V2-only runtime/resources from controlled configuration and restore only approved synthetic V2 data.

Never assume application rollback reverses database migrations or restores deleted/changed data. Never run a destructive rollback, reset or restore against V1/production or an unapproved environment.

## 6. Recovery authority and separation of duties

The recovery plan must name and obtain written acceptance from:
- Recovery Owner — accountable for recovery plan and evidence.
- Operations Lead — coordinates service state and handover.
- Incident Commander — declares incident and coordinates severity/containment.
- Database/application operator — executes only approved steps.
- Independent verifier — checks integrity and service recovery.
- Product Owner — accepts residual risk and recovery outcome.

The person executing a high-risk restore must not be the sole approver and verifier. If independent verification or a required role is unavailable, stop. The assistant can prepare documentation and analyze supplied sanitized evidence but cannot act as the accountable operator or independent reviewer.

## 7. Recovery rehearsal acceptance criteria

A future authorized synthetic-only rehearsal must demonstrate:
- Correct V2-only source and destination identity.
- Backup integrity and recoverable consistency.
- Successful restore to an isolated disposable V2-only target.
- Successful application startup and representative synthetic workflow checks.
- Measured RPO and RTO against owner-approved thresholds.
- Documented failure modes, manual steps, gaps and remediation.
- Tested application rollback to a pinned artifact without accidental data rollback.
- Independent human verification and Product Owner disposition.
- Evidence retention and cleanup of disposable resources.

No rehearsal is claimed in this package.

## 8. Stop conditions

Stop immediately if:
- Source, destination or target environment identity is uncertain.
- Any V1/production resource, secret, database, storage or real data is implicated.
- Backup integrity, consistency or encryption cannot be established.
- Restore target is not disposable and isolated.
- The action could overwrite, delete or expose data outside the exact approved synthetic scope.
- RPO/RTO thresholds are missing or the measured result exceeds the approved target.
- Required human recovery, operations, incident or independent verification roles are unassigned/unavailable.
- New spend, paid feature, vendor, dependency or external service is required without approval.
- A critical/high security, privacy or integrity finding remains open.

## 9. Acceptance checklist — currently not satisfied

- [ ] M3-11-05 target environment is separately authorized and isolation is independently verified.
- [ ] Named Recovery Owner, Operations Lead, Incident Commander, executor and independent verifier accept responsibilities.
- [ ] Owner-approved RPO/RTO and backup/retention/integrity objectives are documented.
- [ ] V2-only backup source, destination, encryption, credentials and retention are verified.
- [ ] Synthetic-only backup and disposable restore target are authorized.
- [ ] Restore and application rollback procedures are pinned and reviewed.
- [ ] Synthetic-only restore/rollback rehearsal is completed and independently verified.
- [ ] Measured RPO/RTO meet approved targets.
- [ ] Product Owner accepts results, residual risks and recovery runbook.

## 10. Current disposition

**Repository preparation:** DELIVERED.  
**Environment and backup source:** NOT IDENTIFIED / NOT AUTHORIZED.  
**Backup creation:** NOT PERFORMED.  
**Restore/rollback rehearsal:** NOT PERFORMED.  
**RPO/RTO:** NOT SET OR MEASURED.  
**M3-11-06:** BLOCKED / NOT ACCEPTED.

Related artifacts:
- [Recovery Rehearsal Evidence Register](M3-11-06_RECOVERY_REHEARSAL_EVIDENCE_REGISTER_2026-11-17.md)
- [Status and Handoff](M3-11-06_STATUS_AND_HANDOFF_2026-11-17.md)

M3-11 overall remains BLOCKED / NOT ACCEPTED. This document authorizes no environment access, backup, restore, rollback, pilot, production or release action.


## Superseding backup cadence decision — 2026-11-20

The Product Owner accepted the existing weekly automated backup cadence for the current development stage and declined a paid upgrade or increased frequency. This supersedes only the earlier “Backup frequency: NOT SET” policy field. It does not establish the actual V2-only backup source/destination, backup consistency/integrity, retention/deletion, encryption/key custody, recovery owner, approved RPO/RTO, successful restore or rollback rehearsal. No backup or restore was performed or authorized by this clarification.

## 11. Superseding owner backup-frequency decision reconciliation — 2026-11-20

The Product Owner's existing decision accepts the current **weekly automated backup cadence** for the current development stage and does not approve a paid backup upgrade, additional backup product or increased frequency. The earlier “Backup frequency: NOT SET” entry in §2 is superseded for this limited current-stage policy question.

This decision does **not** set or imply an RPO, RTO, retention period, restore-verification cadence, integrity standard or production recovery objective. It does not prove that the observed weekly backup includes the V2 folder/database, is a consistent V2-only recovery point, has an isolated destination, uses verified encryption/key custody, or can be restored. The weekly cadence is a policy decision, not technical recovery evidence.

The following remain **NOT SET / NOT VERIFIED**: RPO, RTO, retention/deletion, restore verification cadence, integrity verification method, recovery evidence retention, backup source/destination, V2-only inclusion, consistency, encryption, access controls and successful restore. REC-01–REC-14 remain blocked/not run/not measured as recorded in the recovery evidence register.

No backup was inspected, downloaded, created, changed, restored or deleted. No Hostinger/hPanel or live database access was performed. No new spend or provider is authorized. The existing owner decisions are preserved without reopening them.

**M3-11-06 status:** repository policy reconciliation complete; technical recovery readiness remains BLOCKED / NOT ACCEPTED pending the separately authorized M3-11-05 environment boundary, accepted human recovery roles, approved measurable recovery objectives and a separately authorized synthetic-only rehearsal.
