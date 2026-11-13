# M3-03 Agenda 5 — Governance Service Boundary and Enforcement Design

**Date:** 2026-11-13  
**Repository:** `mattari20/listing-v2`  
**Status:** **Design deliverable completed — no application implementation authorized**  
**Depends on:** Accepted M3-03 logical design baseline; merged Agenda 4 local/CI synthetic persistence foundation  
**Authorization:** Product Owner authorized preparation and closeout of the next agenda as described in the prior closeout recommendation: define how source authorization, evidence quarantine, claim validation, audit, human decisions and publication controls are enforced by application services.

## 1. Agenda scope and decision

This agenda defines application-service responsibilities, command boundaries, invariants, state transitions, failure behavior, audit requirements and a deterministic synthetic acceptance-test plan for M3-03 governance.

The result is an application-level design contract only. It is not executable application code, a service implementation, a role matrix, a deployment topology, a public API, a source-access approval or production authorization.

**Design decision:** retain a modular-monolith application boundary for the first V2 implementation. The named services below are logical application components within the existing application, not separately deployed microservices. They must coordinate through explicit commands and domain outcomes rather than directly changing one another's records.

## 2. Binding constraints

- Repository: `mattari20/listing-v2` only.
- Design and synthetic specification only; fabricated examples only.
- Preserve the accepted M1/M2 requirements, M3-03 logical model and Agenda 2 owner decisions.
- Agenda 4's eight-table SQLite `:memory:` foundation is a persistence baseline, not proof that all governance workflows exist.
- No V1 inspection/modification, Hostinger, hPanel, SSH, production/live database or deployment.
- No real/source/personal/institute data, source retrieval, scraping, download, copying, evidence-content ingestion or source-owner outreach.
- No external API, connector, AI provider, agent, telemetry service, paid service, procurement or new spend.
- No public directory, search, map, sitemap, API, export, pilot or launch.
- No GitHub protection/ruleset/required-check changes.
- No role assignment or claim of legal, privacy, source-rights, safeguarding or security clearance.
- No further implementation is authorized by this agenda. Any code/service workflow requires a new explicit Product Owner authorization.

## 3. Service-boundary map

All components are logical modules in the same application boundary. The database remains behind repositories/persistence adapters; HTTP controllers, jobs and CLI entry points must not implement governance rules themselves.

| Logical application service | Sole responsibility | Permitted input | Required outcome |
|---|---|---|---|
| Source Authorization Service | Assess and maintain scoped authorization decisions and status | Source identifier, proposed purpose/method/territory/retention/processing/reuse/publication scope, validity, decision actor | Explicit allow/deny/expired/suspended/revoked decision with scope and audit |
| Evidence Intake / Quarantine Service | Register permitted evidence-reference metadata and quarantine state | Authorization decision reference, minimal locator/metadata, synthetic or later separately authorized payload reference | Quarantined evidence reference; no claim of admissibility or publication |
| Claim Registration Service | Register immutable claim versions and temporal/provenance links | Subject, predicate, typed value, valid-time, evidence links, provenance | Proposed or needs-evidence claim version with lineage |
| Validation Service | Execute deterministic, versioned structural, semantic, temporal and authorization rules | Claim version and rule-set version | Findings and validation outcome; never a publication approval |
| Conflict Detection Service | Identify incompatible concurrent claims and preserve alternatives | Validated claim versions and predicate multiplicity rules | Conflict record/candidate set; no newest-wins resolution |
| Adjudication Service | Route and record human decisions under a separately approved permission policy | Review case, evidence/claims, decision, rationale, actor capability | Append-only decision, disposition update and audit |
| Publication Policy Service | Evaluate whether an adjudicated claim version is eligible for a specific audience/surface | Approved claim version, decision, authorization state, category visibility, policy version | Allow/deny with reason codes; default deny |
| Publication Snapshot Service | Create a versioned set of eligible facts after explicit publication decision | Authorized publication decision and eligible claim versions | Immutable snapshot identifier and eligible fact set |
| Projection Delivery Service | Deliver approved snapshot changes to downstream read models after a later release authorization | Snapshot and projection version | Idempotent delivery outcome and reconciliation record; not a source of truth |
| Audit Service | Record material governance and privileged actions | Actor class, action, target, reason, correlation and outcome | Append-only audit event; must not contain secrets or unnecessary personal data |
| Correction / Withdrawal Service | Coordinate correction, suppression, revocation and rollback effects | Material issue, authorization change, adjudication or withdrawal decision | Freeze/review/suppress/revalidate instructions with preserved history |

**Boundary rule:** a service may request another service's operation through a documented command/contract. It must not bypass that service by directly mutating its owned state. Shared database transactions may enforce atomicity, but they do not erase service ownership.

## 4. Command and decision contracts

The following are conceptual command contracts, not implemented endpoints or class names.

### 4.1 Authorization commands

- `AssessSourceAuthorization`: record an assessment with exact source, purpose, method, territory/jurisdiction, retention, processing, reuse, publication, effective period, evidence basis and accountable decision.
- `ReassessSourceAuthorization`: record a new assessment when terms, owner, endpoint, method, purpose or risk changes.
- `SuspendSourceAuthorization` / `RevokeSourceAuthorization` / `ExpireSourceAuthorization`: record the reason, effective time and actor; trigger downstream quarantine/revalidation/publication review.

Authorization is granular. Permission for retrieval does not imply retention, processing, reuse or publication. Permission for one source, dataset, endpoint, purpose, method, territory or time window does not extend to another.

### 4.2 Evidence commands

- `RegisterEvidenceReference`: create minimum metadata only after the relevant authorization gate passes.
- `QuarantineEvidenceReference`: keep content inaccessible and mark status/reason.
- `ChangeEvidenceDisposition`: allow only an explicitly permitted state transition with reason and audit.

No evidence payload handling is in scope. An evidence reference is not an assertion, a validation result or a publication decision.

### 4.3 Claim and validation commands

- `RegisterClaimVersion`: create a new immutable version; never overwrite prior assertions.
- `LinkClaimEvidence`: attach typed supports/contradicts/qualifies/contextualizes links.
- `ValidateClaimVersion`: run a named, versioned deterministic rule set and record findings.
- `DetectClaimConflict`: retain all incompatible candidates; no recency-only winner.
- `SupersedeClaimVersion`: create successor lineage with reason; do not encode supersession as a claim disposition.

### 4.4 Human decision and publication commands

- `OpenAdjudicationCase`, `RecordAdjudicationDecision`, `RequestFurtherEvidence`, `DeferAdjudication`.
- `EvaluatePublicationEligibility`: policy evaluation only; no state change to public.
- `AuthorizePublication`: explicit, versioned human decision with actor capability, scope, evidence basis, audience, surfaces, effective time and policy version.
- `BuildPublicationSnapshot`: include only allowlisted claim versions covered by the approved decision.
- `WithdrawPublication` / `SuppressPublication` / `RestorePriorSnapshot`: record decision, reason, affected surfaces and verification outcome.

Automated validation, confidence scores, extraction or conflict ranking must never invoke `AuthorizePublication`.

## 5. Canonical state and transition rules

The logical state vocabulary below is authoritative for service design. State transitions must be explicit, validated and audited; this agenda does not add a new physical status column or migration.

### 5.1 Source authorization

| State | Meaning | Allowed next outcomes |
|---|---|---|
| unassessed | No completed assessment | assessed, denied |
| assessed | Scope and evidence reviewed, decision not yet approved | approved_for_defined_purpose_and_method, denied |
| approved_for_defined_purpose_and_method | Exact scoped activities allowed until expiry/review | suspended, revoked, expired, reassessed |
| denied | Proposed scope not approved | reassessed |
| suspended | Temporary stop pending review | reassessed, revoked, expired |
| revoked | Approval withdrawn | reassessed only as a new decision; prior grant remains historical |
| expired | Validity ended | reassessed as a new time-bounded decision |

A missing, unknown, ambiguous, out-of-scope or stale authorization is **deny**. Expiry/revocation blocks new acquisition/processing immediately. Existing evidence and dependent claims enter quarantine/revalidation; publication is reviewed and suppressed where the continuing right or safety basis is absent. Preserve only the minimum audit lineage lawfully retainable.

### 5.2 Evidence reference

| State | Meaning |
|---|---|
| quarantined | Default; not admissible for claim acceptance or publication |
| eligible_for_review | Metadata and applicable authorization gate have passed for a permitted review activity; not publication approval |
| restricted | Access/use limited by recorded rights or privacy controls |
| withdrawn | No further use; downstream links reviewed and publication assessed |
| deletion_pending / deleted | Retention/deletion action recorded; retain only permitted minimal audit lineage |

Unknown or absent content-rights/authorization state fails closed. Agenda 5 does not authorize changing the default quarantine behavior.

### 5.3 Claim disposition versus version lineage

Canonical claim dispositions remain: `proposed`, `needs_evidence`, `under_review`, `accepted`, `rejected`, `disputed`, `deferred`, `stale`, `withdrawn`.

Version lineage is separate: initial version, successor/supersedes relationship, superseded-by relationship and reason. Supersession is not a disposition. A later recorded claim does not automatically supersede an earlier valid-time fact.

| Current disposition | Example permitted transition | Guard |
|---|---|---|
| proposed | needs_evidence, under_review, deferred, withdrawn | Registration and provenance checks |
| needs_evidence | under_review, deferred, rejected, withdrawn | Evidence link or explicit decision |
| under_review | accepted, rejected, disputed, needs_evidence, deferred | Authorized human adjudication |
| accepted | disputed, stale, withdrawn; new version may supersede | New evidence/review or time/authorization event; never silent overwrite |
| disputed | under_review, accepted, rejected, deferred, withdrawn | Human resolution with rationale |
| deferred | proposed, needs_evidence, under_review, withdrawn | Explicit re-open reason |
| rejected | new version/proposal only; historical rejection retained | No direct mutation of rejected history |
| stale | under_review, disputed, withdrawn; successor version | Freshness/revalidation rule |
| withdrawn | new claim/version only; historical withdrawal retained | Reinstatement requires a new explicit decision |

No claim is accepted solely because a source is official, a value is recent, a validation run is green or an AI/extraction confidence is high.

## 6. Mandatory invariants at every service boundary

1. **Authorization-before-action:** no source-related action proceeds without a current authorization covering the exact action and scope.
2. **Purpose separation:** acquisition, retention, processing, reuse and publication are independent permissions.
3. **Quarantine by default:** an evidence reference cannot support an accepted or public fact while quarantined/restricted/withdrawn.
4. **Provenance completeness:** every accepted claim has an admissible evidence path or a separately approved, auditable human exception; no implicit exception.
5. **Immutable history:** claim versions, adjudication decisions, publication decisions and material audit events are append-only logical history.
6. **Time integrity:** valid time and recorded time remain distinct; intervals are half-open; unknown dates are not invented.
7. **No latest-wins:** conflicts remain explicit until a human decision; authority and temporal scope are fact-specific.
8. **Human publication gate:** no automated process can accept high-impact claims or authorize publication.
9. **Separation of duties:** acquisition/authorization, validation, adjudication and publication are distinct capabilities. Detailed role assignment, incompatible-role rules, emergency powers and compensating review must be approved before real workflows.
10. **Least privilege and fail closed:** missing actor capability, role mapping, policy version, authorization, category flag or surface rule results in deny/suppress.
11. **Restricted-category suppression:** Deeni Madaris default is OFF. Unknown/missing state is OFF. Apply suppression before every public projection and every derivative index, count, facet, map, sitemap, export, cache, API or direct identifier lookup. No sect/maslak filters.
12. **Privacy minimization:** no student/child/staff personal data in this core governance workflow unless separately justified and authorized; no secrets in audit/logs.
13. **Revocation propagation:** revocation/suspension/expiry triggers dependent evidence quarantine, claim revalidation and publication review; stale projections must not remain visible when continuing use is not authorized.
14. **Idempotency:** retries must not duplicate adjudication decisions, snapshots, audit actions or projection changes; use stable command/correlation/idempotency identifiers.
15. **No bypass:** controllers, jobs, administrators and internal tools must use the same policy boundary; no hidden privileged route that skips governance.

## 7. Transaction, consistency and failure-handling design

- A single command that changes authoritative governance state must be atomic: state transition, lineage/audit reference and any required outbox intent either commit together or none do.
- External projection delivery, if separately authorized in a later agenda, is asynchronous and idempotent. It must not become the authority for claim or publication state.
- A projection is eligible only from an explicit approved snapshot. If projection delivery is delayed or fails, record the lag/failure and keep the authoritative decision unchanged.
- Revocation/suppression is safety-prioritized. Mark affected publication state blocked/frozen in the authoritative record before attempting downstream cleanup; verify every downstream surface before declaring propagation complete.
- Retry transient delivery failures with bounded retry policy and dead-letter/reconciliation record. Do not silently drop events.
- Duplicate command submissions return the original decision/result or a deterministic conflict; they must not create a second approval.
- Concurrent incompatible claim updates create a conflict or optimistic-concurrency failure; never silently overwrite.
- Unknown policy version, missing role mapping, unavailable audit persistence or failed authorization check causes a fail-closed outcome for high-impact operations.
- Audit failure blocks the associated high-impact state transition; a non-audited publication or revocation action is prohibited.
- A rollback restores a prior approved snapshot only after policy re-evaluation; it does not erase intervening errors, decisions or audit history.

This section defines expected behavior, not a chosen queue, outbox table, event broker, cache, search engine or deployment service.

## 8. Minimum authorization matrix gate (not yet approved)

The following is a capability-separation model, not an assigned role matrix. No real roles/users are provisioned by this agenda.

| Capability | Must be separately controlled from |
|---|---|
| Source authorization decision | Source acquisition; publication approval |
| Source acquisition / evidence registration | High-impact adjudication; publication approval |
| Deterministic validation administration | Human adjudication; publication approval |
| High-impact claim adjudication | Its own evidence acquisition where practical; publication approval |
| Publication approval | Acquisition and validation; must be an explicit delegated capability |
| Emergency suppression | Restoration/republication; requires reason and retrospective independent review |
| System administration | Claim adjudication/publication approval by default |

Before real source handling, editorial workflows or any public surface, a Product Owner-approved role/permission matrix must specify: named role classes, allowed commands, resource/scope constraints, incompatible combinations, delegation, emergency suppression, dual control, compensating review, revocation, break-glass audit and test coverage. This agenda deliberately does not invent who holds these roles or assert that the sole current builder can safely satisfy incompatible controls.

## 9. Application entry-point policy

Future HTTP controllers, queue jobs, scheduled tasks, administrative commands and internal tools must be thin adapters:

1. Authenticate the caller where the use case requires identity.
2. Resolve actor class and delegated capability from an approved policy.
3. Validate request shape and idempotency/correlation metadata.
4. Invoke the relevant application command/service.
5. Return a decision/result without leaking restricted evidence or personal data.
6. Record access denial and material outcome through the audit boundary.

No controller/job/command may write governance tables directly or implement its own authorization/publication rules. Anonymous public reads, if separately authorized in a later step, must consume only approved public projections and never query internal claims/evidence directly.

## 10. Synthetic acceptance-test catalogue

These are design-level expected-result scenarios. They are not executed application tests. Each must be implemented as a synthetic-only test before the corresponding future workflow can be accepted.

| ID | Scenario | Expected result |
|---|---|---|
| GS-001 | Authorization missing | Deny source-related operation |
| GS-002 | Authorization expired | Deny new activity; trigger dependent review |
| GS-003 | Method differs from approved method | Deny |
| GS-004 | Purpose differs from approved purpose | Deny |
| GS-005 | Territory or source scope differs | Deny |
| GS-006 | Retention permitted but publication not permitted | Keep evidence non-public; publication denied |
| GS-007 | Evidence reference registered | Default quarantined |
| GS-008 | Quarantined evidence linked to claim | Claim cannot become accepted/publishable |
| GS-009 | Deterministic validation passes | Findings recorded; no human approval implied |
| GS-010 | Conflicting claims with different recorded times | Preserve both; open conflict; no latest-wins |
| GS-011 | High-impact claim has no admissible evidence | Deny acceptance/publication |
| GS-012 | Actor lacks adjudication capability | Deny and audit |
| GS-013 | Same actor attempts incompatible acquisition and publication capabilities | Deny unless approved compensating control explicitly applies |
| GS-014 | Automated job attempts publication | Deny |
| GS-015 | Claim version corrected | Create successor; retain prior version and reason |
| GS-016 | Authorization revoked after claim acceptance | Quarantine dependent evidence; revalidate; review/suppress publication |
| GS-017 | Deeni Madaris flag missing/unknown | Suppress from every public surface |
| GS-018 | Restricted category reaches search/map/count/export projection | Block projection and record failure |
| GS-019 | Publication decision lacks surface/audience scope | Deny |
| GS-020 | Projection delivery retried | Idempotent result; no duplicate snapshot or public fact |
| GS-021 | Audit write fails during publication | Abort publication transaction |
| GS-022 | Concurrent incompatible claim versions | Preserve both and raise conflict/concurrency outcome |
| GS-023 | Duplicate adjudication command | Return original decision or deterministic duplicate response |
| GS-024 | Stale or superseded version included in new snapshot | Deny unless explicitly revalidated and newly approved |
| GS-025 | Suppression request received | Freeze affected projection first; preserve decision history |
| GS-026 | Prior snapshot rollback requested | Re-evaluate policy; restore only an eligible prior snapshot |
| GS-027 | Unknown policy version or missing role mapping | Fail closed |
| GS-028 | Evidence withdrawal/deletion request | Apply retention/right assessment; remove content where required; preserve only lawful minimal audit lineage |
| GS-029 | Controller attempts direct persistence mutation | Architecture/test guard rejects bypass |
| GS-030 | Public read attempts internal claim/evidence store | Deny; public reads require approved projection |
| GS-031 | Authorization changes while intake command is in flight | Recheck authorization at commit boundary; deny if no longer valid |
| GS-032 | Revocation projection delivery is delayed | Authoritative state remains suppressed/frozen; reconciliation remains pending and visible |

## 11. Traceability and dependencies

| Baseline | Agenda 5 design coverage |
|---|---|
| M1 institution/programme and student-discovery requirements | Distinct entities, claim accuracy, unknown/stale states, anonymous-safe public projection boundary |
| M1 trust/comparison requirements | Evidence-backed facts, conflict handling, human decisions, correction and audit |
| M1 G02/G03/G05/G08/G09/G14/G16/G17/G20 | Rights gates, privacy/minimization, source-specific authorization, human review, audit, Deeni Madaris default-OFF and security |
| M2-S02 core domain model | Entity/relationship/claim/version separation and temporal semantics |
| M2-S05 data architecture/provenance/publication | Source authorization, evidence, validation, adjudication, publication snapshot and withdrawal lineage |
| M2-S10 architecture synthesis | Modular bounded implementation, independent V2, anonymous discovery and staged gates |
| M3-03 Agenda 2 D-02 | Human-controlled, reversible identity resolution; no automatic merge |
| M3-03 Agenda 2 D-03 | Distinct authority relationship types; no inference by name similarity |
| M3-03 Agenda 2 D-04 | Quarantine, revalidation and publication review on authorization revocation |
| M3-03 Agenda 2 D-05 | Separation-of-duties baseline and mandatory later role matrix |
| M3-03 Agenda 4 | Persistence baseline only; service rules remain to be implemented and tested after separate authorization |

## 12. Risks, open decisions and explicit deferrals

| ID | Risk / open item | Disposition |
|---|---|---|
| GSD-R01 | Detailed role/permission matrix, named human role coverage and dual-control feasibility | **Deferred / blocking before real workflows or public release** |
| GSD-R02 | Legal/privacy/source-rights and child-safeguarding review | **Open independent gate; no compliance claim** |
| GSD-R03 | Source-specific authorization evidence and permitted retention/deletion rules | **Open; no source access** |
| GSD-R04 | Exact evidence retention schedule and deletion/audit conflict handling | **Open; specialist/owner decision required** |
| GSD-R05 | Outbox, queue, projection consistency and cache/index architecture | **Conceptual only; decide in a later implementation design** |
| GSD-R06 | Human identity resolution staffing and appeal/reconsideration policy | **Open; no automatic merge** |
| GSD-R07 | Emergency suppression authority and restoration dual control | **Proposed minimum control; owner approval required before workflow** |
| GSD-R08 | Public projection architecture and Deeni Madaris cross-surface test harness | **Not implemented; must precede any public surface** |
| GSD-R09 | Audit retention, tamper-evidence and operational monitoring | **Open; no vendor/service or retention duration selected** |
| GSD-R10 | Transactional behavior, concurrency and retry semantics | **Design contract only; runtime proof required later** |

No numeric SLO, RPO, RTO, retention period, staffing assumption, budget or vendor is selected here.

## 13. Agenda 5 exit review

| Exit criterion | Evidence / disposition |
|---|---|
| Service boundaries and ownership explicit | Sections 3–4 |
| Canonical state and transitions explicit | Section 5 |
| Authorization, quarantine, provenance and human publication gates explicit | Sections 4–6 |
| Revocation, correction, suppression and rollback behavior explicit | Sections 5–7 |
| Audit, transaction, idempotency and fail-closed expectations explicit | Sections 6–7 |
| Separation-of-duties gate preserved without inventing role assignments | Section 8 |
| Entry-point bypass prevention defined | Section 9 |
| Synthetic acceptance scenarios specified | GS-001–GS-032 |
| M1/M2/Agenda 2/Agenda 4 traceability recorded | Section 11 |
| Residual risks and deferrals visible | Section 12 |
| Scope exclusions and no-implementation boundary preserved | Sections 1–2 and 14 |

## 14. Closeout decision and next gate

**Agenda 5 design activity:** Completed.  
**Application/service implementation:** Not authorized by this agenda.  
**M3-03 overall:** In progress; no whole-step weighted percentage is claimed.  
**Agenda authorization:** Exhausted at this closeout.

The next eligible work is a separately scoped implementation-readiness decision: determine whether a bounded, local/CI-only synthetic service-contract/test harness should be proposed, while first resolving or explicitly accepting the role-separation, audit-failure and transaction-boundary risks. This document does not authorize that work. Any subsequent implementation requires a new explicit Product Owner authorization.

No V1/Hostinger/production access, real/source/personal data, source acquisition, external services/AI, public surface, deployment, procurement, spend, pilot or launch occurred.
