# M3-11 LPS-25 — GAP-02 Persistence and Payload Call-Site Reconciliation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `58b68e5ea5ba27b9e8fdf4ddc6886d1e76563fe8` (main after LPS-24 merge)  
**Agenda:** LPS-25 — persistence and payload call-site reconciliation  
**Work type:** Repository-only source inspection and evidence mapping  
**Status:** **PRIMARY REPOSITORY CALL-SITES MAPPED — RUNTIME AND COMPLETE DATA-FLOW COVERAGE REMAIN UNKNOWN**

## 1. Purpose and boundary

LPS-25 follows the 51-table schema inventory (LPS-23) and synthetic structured-log-context tests (LPS-24). It identifies the principal current repository methods that create, transform, audit, project, read or remove payload-bearing records and their secondary copies.

This is a static repository map, not a runtime trace, exhaustive proof of all framework internals or deployed data flow. It does not establish which configured backend is active, what data exists, what logs/exports/backups/processor copies are present, or whether every call site has been discovered.

All existing restrictions remain in force: synthetic/fictional fixtures only; no V1/production/Hostinger/hosted access; no live database or migrations; no real/source/student/child/guardian/personal data; no source retrieval/contact/collection; no external APIs/AI/providers; no public complaint/UGC activation; no deployment/pilot/release; no new dependencies or spend. No retention period or legal basis is approved.

## 2. Primary write and transformation call-sites

| Domain | File / method | Persisted surfaces and fields | Payload / lifecycle implications |
|---|---|---|---|
| Field-aware claim proposal | `app/Services/Directory/FieldAwareClaimProposalService.php::submit` | Inserts `claims`, `claim_versions.value`, `claim_evidence_links`, `audit_events.metadata`, `governance_outbox.payload` | Validates against a registry definition before writing; the value is encoded as JSON; audit metadata and outbox event are additional copies of identifiers/metadata |
| Field-aware correction | `app/Services/Directory/FieldAwareClaimCorrectionService.php::correct` | Delegates successor creation to `PersistedGovernanceWorkflowService::correctClaimVersion`; submits successor to editorial review | Correction creates a successor version and review case; predecessor and successor history remain linked; rationale/evidence/audit paths need separate lifecycle treatment |
| Generic/legacy claim command | `app/Services/Governance/GovernanceCommandService.php::registerProposedClaim` | Inserts legacy `claim_versions.value`, evidence links and audit metadata | Legacy path is restricted to a small predicate allowlist and refuses registry-managed fields; still creates JSON payload and audit copy |
| Evidence reference registration | `app/Services/Governance/GovernanceCommandService.php::registerEvidenceReference` | Inserts metadata-only `evidence_references` and audit event | Explicitly rejects content-included metadata; evidence reference is quarantined; source authorization and retention action checks are code-level controls, not proof of external source rights |
| Claim adjudication | `app/Services/Governance/PersistedGovernanceWorkflowService.php::decideAdjudication` | Inserts `adjudication_decisions.rationale`; updates case and claim-version disposition; writes audit event | Free-text rationale and actor reference are persisted; decision state changes do not delete predecessor payload |
| Claim correction core | `app/Services/Governance/PersistedGovernanceWorkflowService.php::correctClaimVersion` | Inserts successor `claim_versions.value`, evidence links and correction audit metadata | Value, rationale, reason, evidence IDs and idempotency fingerprint are part of the correction command; history remains |
| Editorial review | `app/Services/Directory/EditorialReviewService.php::completeReview` and history helper | Updates `editorial_review_cases`; records `directory_status_history.metadata` and rationale-related history | Submitter/reviewer actor references and review history are retained; history metadata needs allowlisting/minimization |
| Publication decision/snapshot | `app/Services/Governance/PersistedGovernanceWorkflowService.php` publication methods | Inserts publication decision, JSON `publication_snapshots.payload`, digest and `public_projections` | Snapshot duplicates selected claim value; projection is a further derived reference/copy; suppression must reach both |
| Conflict analysis | `app/Services/Governance/PersistedConflictAndRollbackService.php::detectConflict` | Reads claim values, computes digests, inserts `claim_conflicts` and `claim_conflict_candidates` | Digests and candidate references persist; resolution rationale and actor metadata are additional history |
| Publication rollback | `app/Services/Governance/PersistedConflictAndRollbackService.php::requestPublicationRollback` / apply method | Inserts rollback and outbox records; changes projection pointer | Rollback is a pointer/state change, not deletion; a previous snapshot can become visible again if policy permits |
| Programme offer facts | `app/Services/Governance/ProgrammeOfferFactWorkflowService.php` submit/adjudicate/publish/suppress methods | Inserts `programme_offer_fact_versions.value`, evidence links, decision/rationale, snapshots and public projections; writes audit | Parallel payload lifecycle to general claims; JSON fact value is copied into a publication snapshot; suppression updates snapshot and projection status |
| Synthetic agent proposal | `app/Services/Directory/AgentFieldProposalSubmissionService.php` | Reads prior audit metadata and writes audit metadata for fixed synthetic adapter path | Static repository-only adapter; no live agent/provider is enabled by this call site |
| Account saved items | `app/Http/Controllers/AccountSavedItemsController.php::store/destroy` | Creates/deletes `saved_directory_items` | User-to-entity preference relation; deletion is narrow to this table and does not imply account/session/cache/backup erasure |
| Role assignment | `app/Services/Identity/RoleAssignmentService.php` | Creates/revokes `role_assignments`; privileged audit records | Account privilege and grantor identifiers; revoke is not account erasure |
| Synthetic moderation | `app/Services/Moderation/SyntheticModerationWorkflow.php` | Creates/updates moderation case, appeal and event tables | Existing workflow is explicitly synthetic; no public intake or real complaint processing is authorized |

## 3. Read, disclosure and derived-copy call-sites

| Read/disclosure path | File / method | Source and filtering | Remaining lifecycle concern |
|---|---|---|---|
| Anonymous directory | `app/Services/Directory/PublicDirectoryQueryService.php::publishedEntities` / public profile builder | Reads approved anonymous directory projections joined to snapshots, publication decisions and claim versions; excludes non-approved/suppressed/newer or Deeni Madaris projections | Decodes snapshot JSON payload and assembles public profile; public caches, CDN, browser copies and exports are not established |
| Programme fact directory | `app/Services/Directory/PublicProgrammeOfferFactsQueryService.php::forProgramme` | Reads approved anonymous programme fact projections, snapshots, decisions, adjudication, offer/programme/institution/location and freshness policy | Decodes version values and evidence metadata; projection/snapshot are duplicate representations |
| Public controller | `app/Http/Controllers/PublicDirectoryController.php::index/show/compare` | Validates query/type/locality/filter inputs, calls query/comparison services and renders views | Search inputs may appear in URLs/request logs; actual web-server/access-log and analytics retention unknown |
| Account saved items | `app/Http/Controllers/AccountSavedItemsController.php::index` | Reads authenticated user's saved rows and resolves public profile | Sends private/no-store and noindex headers; this does not govern browser captures, account exports or backup copies |
| Account authentication | `app/Http/Controllers/AccountSessionController.php::store/destroy` | Reads user email/active/verified/password hash and role assignments; regenerates or invalidates session | Runtime session backend and request-body/error logging are unknown; no account export/deletion workflow established |
| Institute correction endpoints | `app/Http/Controllers/UniversityRepresentativeWorkflowController.php` | Authenticated route to claim proposal/correction and editorial review services | Request JSON values, rationale and evidence references flow into service persistence; caller logs/error middleware not fully traced |
| SEO and rendered output | `app/Services/Directory/DirectorySeoMetadata.php` and directory views | Builds metadata from public directory output | Search-engine caches and external indexing are outside repository evidence |

## 4. Non-table persistence and asynchronous/configurable surfaces

| Surface | Repository call-site/config | Current evidence | Unknown |
|---|---|---|---|
| Session | `config/session.php`; controllers store shortlist/locale and login state | Session values and authentication lifecycle are explicit in code | Runtime driver, storage location, session sweeper, expiration, backup and deletion propagation |
| Cache | `config/cache.php` | Config supports array/file/database/Redis/Memcached/DynamoDB/storage; default is array | Actual runtime store, TTL, keys, cache tags, query/view cache and invalidation |
| Queue/failed jobs | `config/queue.php` | Config supports sync/database/Redis/SQS and other drivers; failed jobs default to database UUIDs | No application Job/listener/queue-consumer class appeared in the inspected `app/` tree; actual runtime queue and framework/provider hooks unknown |
| Filesystem | `config/filesystems.php` | Private local, public local and optional S3 disks declared | Actual disk selection, stored object classes, public exposure, access logs, lifecycle and deletion unknown |
| Logs | `config/logging.php`, `SafeLogContextProcessor`, rotating handler | Daily channel uses context allowlist processor; optional channels are defined | Message text is not sanitized; not all channels necessarily use processor; external copies, exception handling and runtime channel unknown |
| Scheduled cleanup | `routes/console.php` | Inspected console routes contain only the framework Inspire command | Host cron, scheduler invocation, hosted jobs and external cleanup not inspected |
| Export/temp/replica/backup/processor | No complete call-site inventory found in inspected application tree | No complete application export/replication subsystem established by this pass | Browser downloads, framework/runtime temp files, deployment packaging, backups, replicas and processors remain UNKNOWN-UNINSPECTED |

## 5. Key findings

1. **Two major payload lineages exist:** general claim values and programme-offer fact values. Both have adjudication, publication snapshots and public projections.
2. **Secondary copies are first-class lifecycle objects:** snapshots, projections, audit metadata, outbox payloads, decision rationales and history metadata may preserve or duplicate content or identifiers.
3. **Suppression is not deletion:** repository methods mark publication records/projections suppressed; they do not demonstrate complete deletion from all downstream systems.
4. **Correction is versioned:** correction creates a successor and retains predecessor history. A policy must define which minimal accountability metadata may remain and when payload copies must be removed or de-identified.
5. **Rollback can restore visibility:** rollback changes the active projection pointer. Any future deletion/restriction mechanism must prevent a rollback from resurrecting a prohibited or deleted value.
6. **The outbox has no identified application consumer in the inspected application tree:** the database table and writes exist, but no application job/listener consumer was found in this bounded tree inspection. Runtime/provider integration remains unknown; no assumption of delivery or cleanup is justified.
7. **Log context filtering is deliberately narrow:** it removes unapproved structured context; it does not sanitize message text, exception messages, external access logs or channels that do not use the processor.
8. **Account deletion is not implemented end-to-end by the saved-item delete route:** it removes one user/entity relation only.
9. **Configured drivers are possibilities, not observations:** no actual environment/backend was inspected.

## 6. Next synthetic verification targets

The following targets are suitable for LPS-26 without inventing retention rules or implementing destructive data deletion:

- Create synthetic claim and programme-fact fixtures; verify correction creates successor versions and links without overwriting the predecessor.
- Verify publication suppression marks the intended snapshot and projection and that public query services exclude suppressed records.
- Verify rollback rejects a suppressed target and cannot move a projection to a disallowed snapshot.
- Verify saved-item removal removes only the selected user/entity row and that the UI no longer returns it.
- Verify synthetic outbox/audit/history records contain identifiers and approved metadata only, not source payloads or credential markers.
- Verify no cache/queue/export/backup behavior beyond the repository test harness is inferred.

Retention duration, legal hold, audit expiry, backup expiry, de-identification and account-erasure semantics must remain unset until approved by the accountable owner after qualified review.

## 7. Acceptance disposition

- [x] Primary write and transformation methods mapped.
- [x] Primary public read/projection methods mapped.
- [x] Account/session/saved-item paths mapped.
- [x] Configurable session/cache/queue/filesystem/log surfaces recorded.
- [x] Suppression, correction, rollback and deletion limitations recorded.
- [x] Unknown runtime, hosted, external processor, export, replica and backup surfaces retained as unknown.
- [ ] Exhaustive framework/runtime write/read trace — NOT ESTABLISHED.
- [ ] Actual runtime storage and processor inventory — NOT INSPECTED / NOT AUTHORIZED.
- [ ] End-to-end deletion implementation and evidence — NOT ESTABLISHED.
- [ ] Approved retention schedule and qualified review — NOT RECEIVED.
- [ ] GAP-02 closure — NOT ACCEPTED.

**Final disposition:** LPS-25 is complete as a repository-only primary call-site reconciliation. GAP-02 advances to **SCHEMA INVENTORY + PRIMARY CALL-SITE MAP COMPLETE / OPERATIONAL LIFECYCLE INCOMPLETE / OPEN / NOT CLOSED**. M3-11 Gate 02 remains BLOCKED / NOT ACCEPTED; all ten M3-11 gate dispositions remain unchanged. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.

## 8. Inspected source paths

- `app/Http/Controllers/AccountSavedItemsController.php`
- `app/Http/Controllers/AccountSessionController.php`
- `app/Http/Controllers/PublicDirectoryController.php`
- `app/Http/Controllers/UniversityRepresentativeWorkflowController.php`
- `app/Logging/SafeLogContextProcessor.php`
- `app/Services/Directory/AgentFieldProposalSubmissionService.php`
- `app/Services/Directory/EditorialReviewService.php`
- `app/Services/Directory/FieldAwareClaimCorrectionService.php`
- `app/Services/Directory/FieldAwareClaimProposalService.php`
- `app/Services/Directory/FieldAwareClaimReinstatementService.php`
- `app/Services/Directory/PublicDirectoryQueryService.php`
- `app/Services/Directory/PublicProgrammeOfferFactsQueryService.php`
- `app/Services/Governance/GovernanceCommandService.php`
- `app/Services/Governance/PersistedConflictAndRollbackService.php`
- `app/Services/Governance/PersistedGovernanceWorkflowService.php`
- `app/Services/Governance/ProgrammeOfferFactWorkflowService.php`
- `app/Services/Identity/RoleAssignmentService.php`
- `app/Services/Moderation/SyntheticModerationWorkflow.php`
- `routes/console.php`, `routes/web.php`
- `config/session.php`, `config/cache.php`, `config/queue.php`, `config/filesystems.php`, `config/logging.php`

No runtime or external-system evidence is asserted.
