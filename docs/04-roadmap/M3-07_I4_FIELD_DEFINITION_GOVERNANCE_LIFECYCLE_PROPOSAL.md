# M3-07 I4 — Field Definition Governance Lifecycle: Bounded Implementation Proposal

**Prepared:** 2026-11-16  
**Repository:** mattari20/listing-v2  
**Depends on:** D1-D5; merged I1 field registry, I2 typed validator and I3 field-aware claim proposal  
**Status:** Proposal only — implementation NOT AUTHORIZED

## 1. Decision requested

Authorize a narrowly bounded, synthetic local/CI-only implementation of I4 — Field Definition Governance Lifecycle.

I4 completes the missing human-governed lifecycle for field definitions already persisted by I1. It keeps definition governance separate from institution-value claims and does not activate sources, AI, connectors, public routes or production systems.

Approval of this proposal is not implementation authorization. Code, migration and tests must not be changed until the owner explicitly approves the exact I4 scope below.

## 2. Current baseline

I1 PR #198, I2 PR #199 and I3 PR #203 are merged for bounded synthetic local/CI scopes.

The existing field_definition_versions table already stores lifecycle state, immutable version number, semantic version, compatibility class, value type, cardinality, scope, privacy, visibility, search/filter/sort flags, validation/presentation/evidence/freshness metadata, effective dates, successor pointer, proposer and rationale references.

The registry does not yet have a dedicated persisted definition-review case/decision lifecycle. Existing editorial review is claim-version-centric and must not be reused for a definition because a field definition is not an institution claim.

## 3. Proposed I4 objective

Provide a controlled path for a human to propose a new field definition or successor version, submit it for independent review, approve it, activate it separately, and later deprecate/retire or restore it through a new reviewed version.

I4 must guarantee:
1. definition content is validated before review;
2. proposer, reviewer, approver and activator are human actors with distinct capabilities;
3. approval does not automatically activate;
4. activation does not create institution values or publish anything;
5. only one active version per field key is allowed at a time in the initial policy;
6. semantic definition content is immutable after approval;
7. changed meaning or type requires a new immutable version;
8. retirement blocks new proposals but does not delete or withdraw existing values;
9. restore requires a new version and a new review/approval/activation path;
10. every transition is idempotent, audited and transactionally recorded.

## 4. Exact proposed implementation scope

### 4.1 Persistence

One additive migration, tentatively named:

2026_11_16_000001_create_field_definition_review_workflows.php

Create only the minimum review records recommended by D2.

**field_definition_review_cases**
- UUID primary key and exact field_definition_version_id foreign key;
- submitting human actor ID and assigned reviewer actor ID;
- case status: submitted, in_review, changes_requested, approved, rejected or closed;
- bounded idempotency key and command fingerprint;
- submitted/created/updated timestamps;
- unique idempotency and appropriate case/version/status indexes.

**field_definition_review_decisions**
- UUID primary key and review-case foreign key;
- decision outcome: recommend_approval, request_changes, reject or approve;
- human actor ID/class, rationale code and bounded rationale;
- policy version and decision timestamp;
- append-only decision history; no update/delete API.

Finalize column lengths, foreign-key rules, indexes and portability details in implementation preflight. Do not add a parallel claims, evidence, adjudication or publication schema. Reuse existing audit_events and governance_outbox.

### 4.2 Application service

Add one bounded service: app/Services/Directory/FieldDefinitionGovernanceService.php

It may expose only these I4 commands:
- propose a new field key/version or successor version;
- edit a proposal only while it remains in a pre-approval changes-requested/draft state, with audit history;
- submit/resubmit a definition version for review;
- assign an independent reviewer;
- record review recommendation, changes-requested or rejection;
- record independent approval;
- activate an approved, effective and compatible version;
- deprecate/retire an active version with rationale and optional successor mapping;
- initiate restoration only by creating a new version under the reserved key and routing it through review, approval and activation.

No direct generic CRUD, arbitrary JSON mutation or bypass command is permitted.

### 4.3 Capabilities and actor separation

Use narrow capabilities aligned with D3:
- propose_field_definition
- review_field_definition
- approve_field_definition
- activate_field_definition
- retire_field_definition

All actions require actor_class=human. Service/agent actors must be denied even if a capability string is supplied.

Minimum separation:
- proposer cannot review or approve their own proposal;
- reviewer cannot be the proposer;
- approver must be distinct from proposer and reviewer;
- activator must be a separate human actor from proposer and approver.

The service validates capabilities and separation but does not provision real accounts or roles. CI uses distinct fabricated actor IDs only. Real role provisioning and staffing remain separate work.

### 4.4 State transitions

| Current state | Command | Next state | Required guard |
|---|---|---|---|
| Proposed | Submit for review | Submitted case | Definition validation and unique key/version |
| Submitted | Assign reviewer | In review | Human reviewer, not proposer |
| In review | Request changes | Changes requested | Human reviewer and rationale |
| In review | Recommend approval | Awaiting approval | Human reviewer, not proposer |
| Awaiting approval | Approve | Approved | Human approver distinct from proposer/reviewer |
| Approved | Activate | Active | Separate human activator, effective-date and compatibility checks |
| Active | Deprecate | Deprecated | Human steward, rationale and effective boundary |
| Active/Deprecated | Retire | Retired | Human steward, rationale; successor mapping if applicable |
| Retired | Restore | New proposed version | Never reactivate retired version in place; full review path required |

Unknown or unsupported transitions fail closed.

### 4.5 Version immutability and successor rules

- Stable field keys are unique and never recycled.
- Definition versions increment monotonically under a locked field-definition row.
- Proposed content may be corrected only through the bounded changes-requested path and is fully audited.
- Once approved, semantic content (type, scope, applicability, validation, privacy, evidence and presentation policy) is immutable.
- A semantic change creates a new version; historical versions are not rewritten.
- Only one active version per field key is allowed at a time in this initial package.
- A successor pointer is recorded once during an audited retirement transition and cannot be silently rewritten.
- Restore creates a new version under the same reserved key or an explicitly approved successor key. It never flips a retired version back to active.

### 4.6 Audit and outbox

Every proposal, assignment, review, approval, activation, deprecation, retirement and restore initiation writes an audit_events record with actor, target, rationale, prior/new state, policy version and idempotency metadata, plus an identifier-only governance_outbox event in the same transaction.

The outbox handler verifies event type, target version, review case/decision identity and current lifecycle state. It performs no source retrieval, notification, claim creation, adjudication, publication or projection mutation. Unknown event types remain fail-closed.

## 5. Explicit exclusions

I4 does not include:
- admin UI, public routes, API endpoints or role/account provisioning;
- profile template editing, dynamic search/filter UI or projection changes;
- changing institution claim values, claims or claim-version evidence;
- bulk migration/backfill of existing values or automatic field successor migration;
- provider-category taxonomy expansion;
- source authorization, source browsing, manual verification, scraping, downloads or ingestion;
- AI/model/provider, agent, connector, crawler, scheduler or external API activation;
- real institution/provider/student/applicant/child/staff data;
- production, V1, Hostinger/hPanel, live database or deployment;
- procurement, paid services or additional spend;
- I5, I6, I7 or scope expansion.

Field activation must not silently change public projections. Field retirement must not silently remove values or delete history. Search/publication projection policy remains a separate governed concern.

## 6. Synthetic acceptance matrix

All tests use fictional field keys, fabricated metadata and distinct synthetic human actor IDs.

| ID | Scenario | Expected result |
|---|---|---|
| I4-01 | Propose unique new field key/version | Proposed version and review case created atomically |
| I4-02 | Duplicate or recycled field key | Rejected |
| I4-03 | Unsupported type/schema/privacy/scope | Rejected before review |
| I4-04 | Service/agent actor proposes definition | Rejected |
| I4-05 | Proposer attempts own review/approval | Rejected |
| I4-06 | Reviewer equals proposer | Rejected |
| I4-07 | Approver equals proposer or reviewer | Rejected |
| I4-08 | Activator equals proposer or approver | Rejected |
| I4-09 | Review requests changes | Case transitions; proposal edit is audited |
| I4-10 | Rejected definition | Cannot be activated |
| I4-11 | Approved but not activated definition | I3 proposal path still denies it |
| I4-12 | Activate approved version | Active only after independent human activation |
| I4-13 | Activate expired/future-ineligible version | Rejected |
| I4-14 | Two active versions for same key | Second activation rejected |
| I4-15 | Edit semantic content after approval | Rejected; new version required |
| I4-16 | Retire active field | New I3 proposals denied; history retained |
| I4-17 | Retire field with existing claims | Claims and public projection are not silently deleted/changed |
| I4-18 | Restore retired field | New version and full review path required |
| I4-19 | Successor mapping changed after retirement | Rejected or separately versioned/audited |
| I4-20 | Duplicate command/idempotency retry | Same result; no duplicate decisions/events |
| I4-21 | Concurrent review/approval/activation | Row locking and stale-state checks prevent double transition |
| I4-22 | Outbox event mismatch or unknown type | Fail closed; no side effect |
| I4-23 | Audit/outbox atomicity failure | Entire transition rolls back |
| I4-24 | Activation/retirement | No claim, adjudication, publication or projection mutation |
| I4-25 | Restricted-category field fixture | Existing Deeni Madaris default-OFF and no-inference invariants remain unchanged |

## 7. Required validation and review

Before I4 can be accepted:
- focused I4 feature tests and full synthetic suite pass;
- migration up/down is exercised only on disposable local/CI SQLite databases;
- Pint, Composer/dependency checks, Laravel bootstrap/routes and artifact hygiene pass;
- exact-head PHP 8.5 FND-01 CI and Project documentation validation pass;
- concurrency, idempotency, actor separation, immutable versioning and outbox fail-closed behavior are tested;
- exact-head diff contains only approved I4 files and necessary documentation;
- no unresolved review threads remain;
- exact head, check run IDs, test assertions/warnings, merge SHA and final status are recorded.

No test may contact a live source, use a live model, access production or rely on real provider data.

## 8. Stop conditions

Stop and seek a new decision if implementation requires changing I1-I3 semantics or backfilling claim versions; public routes/admin UI/real roles; claim adjudication/publication or public projections; source retrieval/model/API/connector/scheduler activation; real data; production/V1/Hostinger; deployment/spend; provider taxonomy expansion; or weakening actor separation, immutable versioning, audit or fail-closed behavior.

## 9. Proposed owner authorization — NOT YET APPROVED

> I authorize only M3-07 I4 — Field Definition Governance Lifecycle — in mattari20/listing-v2, on a new branch from the then-current verified main, limited to the two field-definition review tables, the bounded FieldDefinitionGovernanceService, explicit human-only capabilities and actor-separation rules, transactional audit/outbox lifecycle transitions, synthetic-only I4 tests and the I4 implementation record described in this proposal. I authorize additive migrations only in disposable local/CI databases. I do not authorize admin/public UI or routes, real role provisioning, claim/value changes, projection changes, source access, AI/model/provider/connector/scheduler activation, production/V1/Hostinger access, deployment, procurement, new spend, I5-I7 or scope expansion. Any deviation requires a new explicit approval.

## 10. Binding safety boundary

This is a documentation and authorization proposal only. No application code, migration, schema, test behavior, live source, model/provider, connector, scheduler, production system, V1, Hostinger/hPanel, deployment or spend was accessed or changed. I4 remains NOT AUTHORIZED until the owner explicitly approves the exact statement above.
