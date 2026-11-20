# M3-11 LPS-14 — GAP-02 Data Lifecycle Inventory, Retention and Deletion Framework

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Planning baseline:** `a40daf212a21bdbb1c61dfc3e855a13a308db441` (main after LPS-13 / PR #371)  
**Agenda type:** Repository-only assessment framework and documentation  
**Status:** **FRAMEWORK DEFINED — INVENTORY MODEL, LIFECYCLE, RETENTION, DELETION PROPAGATION AND VERIFICATION REQUIREMENTS RECORDED; GAP-02 NOT CLOSED; NO IMPLEMENTATION OR REAL-DATA AUTHORITY CREATED**

## 1. Purpose and decision boundary

LPS-14 turns GAP-02 from LPS-12 into a practical, evidence-led framework for inventorying data flows and governing retention, deletion and backup expiry. It provides a repeatable way to identify data from the point it is created or received through validation, use, disclosure, derived copies, archival and final disposal.

This is a repository-side framework and initial evidence reconciliation only. It is not a completed operational data inventory, legal opinion, privacy impact assessment, retention schedule approval, deletion certification, backup review or proof of hosted behavior. It does not close GAP-02 or M3-11-02.

**Current boundary remains unchanged:** private repository/local/GitHub CI work; synthetic/fictional fixtures only; no V1/production/Hostinger/hPanel/hosted access; no live database, migration, backup inspection, restore or deletion action; no real institute/source/student/guardian/personal data; no source contact, access, copying, scraping or ingestion; no external API, AI/model/provider, crawler or live agent; no public complaint/UGC/review/rating/appeal activation; no deployment, pilot, release candidate or participant activity; no new dependency, paid service, hosting upgrade or additional spend. Deeni Madaris remains default-OFF/zero exposure.

## 2. Governing rules

1. Inventory the complete lifecycle, not just the primary application table or visible user interface.
2. Record each data surface separately, including copies, derivatives, metadata, temporary files, logs, exports, caches, backups and processors.
3. Do not infer that a data surface does not exist merely because it was not found in the inspected repository paths.
4. Distinguish confirmed implementation evidence, documented design, unknown/uninspected surfaces and external/hosted facts.
5. Every data item/class must have a defined purpose, necessity, accountable owner, access boundary, retention trigger, retention period, disposal method and exception rule before real-data activity is proposed.
6. Retention periods must be justified by the exact purpose, applicable obligations, operational need and qualified advice. This framework does not invent or approve durations.
7. Deletion must cover derived and downstream copies where applicable. A successful primary-row delete is not proof that logs, exports, caches, backups or processors have been handled.
8. Backup-held copies require an explicit expiry/restore policy. A restore must not silently reintroduce data that was validly deleted before the backup was taken.
9. Legal holds, security investigations and other exceptions must be narrow, documented, access-controlled, time-bounded and reviewed; they must not become indefinite default retention.
10. A policy document, synthetic test or repository inspection cannot prove actual hosted configuration, real-world legal compliance or deletion from an uninspected system.

## 3. Evidence classification

Use one of these labels for every inventory assertion:

| Label | Meaning | Acceptable evidence |
|---|---|---|
| CONFIRMED-REPOSITORY | Directly identified in current repository code/config/schema/tests | Exact path, symbol, migration/config/test reference and commit |
| DOCUMENTED-DESIGN | Requirement or intended behavior exists only in governance/architecture documentation | Exact document and section; do not describe as enforced |
| PARTIAL | A control exists but does not cover the full data lifecycle or all relevant surfaces | Code/test evidence plus an explicit coverage limitation |
| UNKNOWN-UNINSPECTED | Repository review did not establish whether the surface exists or how it behaves | Named uncertainty and the future evidence needed |
| EXTERNAL-REVIEW-REQUIRED | Fact requires hosted access, processor evidence, operational observation or qualified professional review | Named evidence owner/type; no assumption of completion |
| NOT-APPLICABLE-JUSTIFIED | Demonstrably irrelevant to the precisely bounded system/scope | Written rationale and approving accountable human; never use to bypass a required gate |

A blank, missing or inaccessible source is UNKNOWN-UNINSPECTED, not “does not exist.” A file path or test name alone is not proof that a control is active in a deployed environment.

## 4. Inventory register — required fields

Every distinct data class and processing surface receives a stable inventory ID. Split entries when purpose, sensitivity, location, access, retention or deletion behavior differs.

| Field | Required content |
|---|---|
| Inventory ID / version | Stable identifier, version, date, status and change history |
| Data class | Exact fields or data categories; distinguish content, identifiers, metadata and derived values |
| Data subjects | Institution, representative, account holder, student/child, guardian, staff, visitor, or none; mark unknown explicitly |
| Sensitivity / privacy class | Applicable repository privacy class and any higher-risk classification; never downgrade by aggregation |
| Purpose and necessity | Specific purpose, why each field is needed, less-intrusive alternative considered, and prohibited secondary uses |
| Collection / creation point | UI, API, import, job, operator action, generated event, file upload, log or system process; exact route/job if known |
| Source and authority | Origin, rights/permission basis, source owner, collection method and scope; no live source activity is implied |
| Processing | Validation, normalization, matching, enrichment, moderation, publication, analytics, automation or other transformations |
| Primary storage | Exact logical store, table/column/document/object path or file class; identify encryption and region only when evidenced |
| Derived / secondary stores | Search index, materialized projection, outbox, audit trail, analytics, thumbnails, temporary work files or replicas |
| Logs and telemetry | Application, security, access, error, debug, job and provider logs; record whether payloads or identifiers may appear |
| Sessions and tokens | Session records, cookies, authentication tokens, reset tokens and expiry/revocation behavior |
| Exports and disclosures | CSV/PDF/downloads, email, support copies, public projection, downstream recipients and processors |
| Cache and temporary copies | Application/query/cache stores, browser/local files, queues, temp directories and generated artifacts |
| Backup / recovery copies | Backup scope, schedule, encryption/access, expiry, restore process and deletion replay/suppression mechanism |
| Location and jurisdiction | Hosting region, processor location and cross-border transfer status; UNKNOWN until evidenced |
| Access and roles | Human/service identities, least-privilege boundary, access logging, privileged access and review cadence |
| Retention trigger | Event that starts the clock: creation, last use, expiry, correction, withdrawal, account closure, contract end or other justified event |
| Retention period | Approved duration and rationale, or explicitly UNSET / REVIEW REQUIRED |
| Disposal / deletion method | Logical delete, physical purge, cryptographic erasure, overwrite, expiry or processor request; exact mechanism |
| Propagation requirements | Downstream copies, caches, exports, logs, backups, replicas and processors that must be addressed |
| Exceptions / legal holds | Basis, approver, scope, start/end/review date, access restriction and release procedure |
| Accountable owner | Named human role and deputy/coverage; “project owner” alone is not an operational appointment |
| Evidence / test | Exact source, test, run, dated observation and limitations |
| Open questions / decision | Unknowns, dependency, required reviewer and explicit disposition |

## 5. Lifecycle model

Every inventory entry must map the applicable stages below. A stage may be marked not applicable only with a recorded rationale.

1. **Create or receive:** identify the initiating actor/process, source, purpose and minimum fields.
2. **Validate and classify:** apply schema, privacy class, provenance, authority and eligibility checks before persistence or use.
3. **Store:** identify primary and secondary persistence, encryption, location, access and replication.
4. **Use and transform:** record each purpose, derived value, matching, moderation, analytics or automated processing step.
5. **Disclose or export:** identify audience, fields, recipients, download paths, processors and onward-use restrictions.
6. **Correct or restrict:** identify how inaccurate, disputed, stale or unauthorized data is amended, suppressed or access-restricted while preserving only justified audit evidence.
7. **Archive or retain under exception:** specify why active use has ended but a narrowly defined copy must remain, who can access it and when it is reviewed.
8. **Delete or de-identify:** execute the approved method across applicable stores and record evidence without retaining the deleted payload in the evidence record.
9. **Expire backup copies:** allow backup copies to expire under the approved schedule and ensure restoration cannot silently revive a deletion or restriction.
10. **Verify and close:** test the expected absence or inaccessibility across all applicable surfaces and record residual exceptions.

Lifecycle state vocabulary: PROPOSED, ACTIVE, RESTRICTED, DISPUTED, SUPERSEDED, ARCHIVED, DELETION-PENDING, DELETED-VERIFIED, BACKUP-EXPIRY-PENDING, EXCEPTION-HELD and CLOSED. State transitions must be authorized, timestamped and auditable. A state label alone is not technical enforcement.

## 6. Initial repository evidence reconciliation

This section records only what the prior LPS-11 repository mapping established. It is not a fresh claim that every source file, runtime configuration or deployed environment has been exhaustively inspected.

| Surface / control | Initial evidence position | Classification | What remains unknown |
|---|---|---|---|
| Typed field privacy classes and prohibited data classes | LPS-11 identified `app/Services/Directory/TypedFieldValueValidator.php` and selected privacy-boundary tests | PARTIAL / CONFIRMED-REPOSITORY per LPS-11 | Complete data-flow coverage, all persistence paths, real-data behavior and deployed configuration |
| Public projection privacy gate | LPS-11 identified `app/Services/Directory/PublicDirectoryQueryService.php` requiring public-eligible visibility and privacy classification | PARTIAL / CONFIRMED-REPOSITORY per LPS-11 | Every public/derived/export path and actual hosted enforcement |
| Audit history and publication decisions | LPS-11 identified persisted governance workflow, audit history and publication snapshots | PARTIAL / CONFIRMED-REPOSITORY per LPS-11 | Complete audit payload inventory, retention, deletion, access and backup lifecycle |
| Application log cleaner | LPS-11 identified SEC-06 bounded local logging and a 30-day rotated-log cleaner | PARTIAL / CONFIRMED-REPOSITORY per LPS-11 | Full log-message/payload audit, actual runtime schedule, hosted log copies, processor logs and backup copies |
| Sessions and authentication | LPS-11 noted session controls and security headers | PARTIAL / CONFIRMED-REPOSITORY per LPS-11 | Exact session store, cookie/session expiry, revocation, logs, hosted configuration and downstream copies |
| Evidence metadata and files | Evidence-linked claim and provenance workflows were identified | PARTIAL / CONFIRMED-REPOSITORY per LPS-11 | Exact complete evidence storage map, binary/object storage, access, retention, deletion and backup behavior |
| Database and schema | Selected schema/privacy tests and application persistence are documented by LPS-11 | PARTIAL / UNKNOWN-UNINSPECTED for full inventory | Complete current schema-to-data-class map, all columns/JSON payloads, replicas and deployed database |
| Exports, caches, temporary files and queues | GAP-02 expressly identified these as inventory requirements; no complete evidence map was established | UNKNOWN-UNINSPECTED | Whether each surface exists, exact contents, location, access, TTL and deletion behavior |
| Backups and restore | Weekly automated backup cadence is an accepted development-stage decision in the controlled intake record | DOCUMENTED-DESIGN / EXTERNAL-REVIEW-REQUIRED | V2-only scope/isolation, contents, retention, encryption, restore behavior, deletion replay, RPO/RTO and rehearsal |
| Third-party processors | No processor is authorized under the current scope | DOCUMENTED SCOPE EXCLUSION | Any future processor requires separate assessment; do not infer “none exists” in all environments without evidence |

**Important:** the known 30-day rotated-log cleaner is one bounded log-retention control only. It must not be generalized to database records, evidence, audit history, sessions, exports, caches, backups or processor-held copies. The accepted weekly backup cadence is not a retention period and is not proof of backup isolation or deletion behavior.

## 7. Data-class and retention schedule template

Create one schedule row per data class and storage surface. Retention must be approved for the exact scope before real-data processing.

| Schedule ID | Data class / surface | Purpose | Retention trigger | Proposed period | Rationale / authority | Disposal method | Backup expiry rule | Owner / approval | Status |
|---|---|---|---|---|---|---|---|---|---|
| SYN-EXAMPLE-01 | Fictional test fixture | Automated test only | Test completion | Test-run lifecycle only; no production retention claim | Synthetic fixture policy | Delete workspace artifact under test cleanup | Not applicable only if no backup surface exists for the test run | Test owner; synthetic scope | EXAMPLE ONLY |

Required status values: UNASSESSED, PROPOSED, QUALIFIED-REVIEW-PENDING, OWNER-APPROVAL-PENDING, APPROVED, IMPLEMENTED, TESTED, EXCEPTION-HELD, EXPIRED and RETIRED. Do not mark APPROVED or IMPLEMENTED without corresponding evidence and accountable human approval.

## 8. Deletion and propagation matrix

For each deletion/correction trigger, map every applicable copy. Record NOT PRESENT only when supported by evidence; otherwise use UNKNOWN.

| Surface | Required action | Verification evidence | Common failure mode |
|---|---|---|---|
| Primary database / object store | Delete or restrict exact records/objects under approved policy | Scoped query/result or storage audit, with payload excluded from retained proof | Primary record deleted but related rows or blobs remain |
| Derived projections / search indexes | Rebuild, suppress or delete dependent facts and indexes | Query/projection test showing absence or restriction | Stale projection continues exposing a deleted fact |
| Audit history | Retain only the minimum justified accountability record; redact/pseudonymize payload where required by approved policy | Field-level audit retention test and access review | Audit log becomes an indefinite duplicate of deleted content |
| Application/security logs | Remove or expire payload/identifiers under approved schedule; preserve only justified security metadata | Log scan/retention test on synthetic identifiers | Sensitive values copied into messages, exception traces or external logs |
| Sessions / tokens | Revoke applicable sessions and credentials; expire associated state | Session invalidation and replay-denial test | Deleted account/data remains accessible through active session |
| Exports / downloads | Expire controlled exports and define handling of copies already downloaded/disclosed | Export expiry/access test; recipient disposition where applicable | Untracked local/email copies persist |
| Caches / temporary files / queues | Invalidate, purge or allow bounded TTL; prevent stale jobs from recreating data | Cache miss/absence test and queue/job reconciliation | Cache or delayed job restores deleted content |
| Backups / replicas | Expire copies according to approved schedule; prevent restore from reintroducing validly deleted data | Backup policy evidence, restore rehearsal and deletion replay/suppression proof | Restore resurrects data that was deleted after backup creation |
| Processors / recipients | Send authorized deletion/restriction request and capture response where contractually/legal required | Processor/recipient attestation and dated record | Downstream copy remains outside operator visibility |

Deletion completion must be reported as a scoped result, for example: “verified for the listed repository-controlled surfaces on [date]; backup expiry and named external copies remain pending.” Never claim universal deletion if any relevant surface is unknown or unverified.

## 9. Request, correction and exception handling requirements

Before a real service is proposed, define an accountable human process for:
- receiving and authenticating a valid request without collecting unnecessary identity evidence;
- distinguishing access, correction, objection, restriction, deletion and complaint requests;
- identifying the affected data subject, representative authority and exact data scope;
- assessing applicable rights, lawful exceptions, retention duties and source/third-party constraints with qualified advice;
- preventing disclosure of another person's information during response;
- applying approved changes consistently to primary and derived stores;
- communicating scope, outcome, limitations and any permitted appeal route;
- recording minimal evidence of the decision without retaining unnecessary request documents or sensitive payloads.

A request workflow is not authorized or activated by this document. Public complaint, appeal, UGC or student/child-facing intake remains disabled.

**Exception / legal-hold register fields:** hold ID; authority/basis; exact data classes and systems; scope limitation; approving qualified/accountable role; start date; review date; expiry/release condition; access list; preservation method; deletion actions deferred; release verification; audit reference. No blanket or indefinite hold.

## 10. Verification and acceptance criteria for GAP-02

GAP-02 can be considered for closure only when all applicable criteria below are evidenced for the exact proposed operating scope:

1. A reconciled inventory maps every collection/creation point to all primary, derived, temporary, log, audit, export, cache, session, backup, replica and processor surfaces.
2. Each data class has an approved purpose/necessity, subject/privacy classification, owner, access boundary, location/jurisdiction, retention trigger/period and disposal method.
3. Retention periods have a documented rationale and qualified privacy/legal review where required; no unexplained or unbounded retention remains.
4. A deletion/propagation matrix covers all applicable copies and explicitly records unresolved/unknown surfaces.
5. Backup retention, isolation, restore and deletion replay/suppression behavior are evidenced; no restoration may silently reintroduce deleted/restricted data.
6. Access, correction, objection, restriction and deletion request handling is defined for the exact service and has named, competent human ownership before activation.
7. Synthetic tests cover retention boundaries, deletion propagation, cache/queue behavior, session revocation, export expiry and backup-restore deletion replay where those mechanisms are implemented and separately authorized.
8. Test evidence is tied to the exact candidate/configuration and includes limitations; synthetic tests are not represented as proof of real-world legal compliance.
9. Qualified reviewers assess the complete inventory and proposed processing/retention model; their findings and limitations are recorded through the controlled evidence intake.
10. Product Owner accepts the exact residual risks and scope only after the preceding prerequisites are satisfied.

**Automatic stop conditions:** unknown data store or processor; unbounded retention; unexplained collection; unclear access; deletion that does not propagate; backup restore that resurrects deleted data; logs containing unreviewed sensitive payloads; missing accountable owner; missing qualified review; or any request to access production/Hostinger, inspect backups, process real data or activate a service without new exact-scope authorization.

## 11. Work sequence and evidence intake

The recommended future sequence is:
1. Build the inventory from a frozen, exact repository/candidate baseline and approved architecture/configuration artifacts.
2. Reconcile schema, code paths, file/object storage, logs, sessions, jobs, exports, caches and backups; classify each assertion using §3.
3. Obtain exact target/environment and processor evidence only under a separate explicit authorization and appropriate safeguards.
4. Complete data-class necessity and retention proposals; leave durations UNSET until justified and reviewed.
5. Complete deletion/propagation and backup-restore behavior design.
6. Obtain qualified privacy/legal review of the complete inventory and exact operating model.
7. Implement only after separate scope authorization; add synthetic tests first and keep real-data testing separately gated.
8. Submit evidence through the existing controlled acceptance intake. Receipt is not acceptance.

Confidential legal advice, security details, credentials, personal information and raw data must not be placed in this repository or ordinary chat. Record only a non-sensitive evidence ID, reviewer qualification/status, scope, date, outcome and restricted-storage reference.

## 12. Relationship to LPS-12 and LPS-13

- LPS-12 GAP-02 remains P0 and open. LPS-14 supplies the inventory/lifecycle/retention/deletion framework requested by that plan.
- LPS-13 supplies the C0–C3 change-impact governance process. Any future change to data classes, collection, purposes, storage, retention, processors, deletion or backup behavior must be classified and assessed under LPS-13 before implementation or activation.
- LPS-11 remains the source of the initial partial evidence map; this document does not upgrade its findings to fully implemented.
- LPS-01–LPS-10 policy decisions remain accepted for the existing scope; LPS-14 does not change them.

## 13. Final disposition

**LPS-14 agenda: COMPLETE as a repository-only framework and initial evidence reconciliation.**  
**GAP-02: FRAMEWORK DEFINED / NOT IMPLEMENTED / NOT CLOSED / OPEN.**  
**M3-11-02: BLOCKED pending qualified legal/privacy/safeguarding assessment and other applicable evidence.**  
**M3-11 overall: BLOCKED / NOT ACCEPTED.**  
**Overall M3: OPEN / PARTIALLY COMPLETE — NOT CLOSED.**

No code, schema, migration, runtime configuration, retention setting, deletion job, backup policy or hosted control was changed. No real data was accessed or processed. No production, V1, Hostinger/hPanel, live database, backup/restore, external processor, AI/API, deployment, pilot, release, participant activity or additional spend is authorized.

---
