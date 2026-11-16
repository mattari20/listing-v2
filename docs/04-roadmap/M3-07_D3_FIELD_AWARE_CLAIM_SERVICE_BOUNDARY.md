# M3-07 D3 — Field-Aware Claim Service Boundary and Governance Contract

**Date:** 2026-11-14  
**Repository:** mattari20/listing-v2  
**Depends on:** D1 Field Registry Contract; D2 Field Registry Storage Decision; existing M3-03 and M3-04 governance services  
**Status:** Service-boundary design proposal only. No application implementation or schema change authorized.

## 1. Purpose

Define the only permitted application boundary for adding, correcting, withdrawing and reading registry-managed institution information. The design prevents arbitrary JSON claim registration from bypassing field definitions, provider/entity applicability, evidence authorization, human review, publication and audit.

The service boundary must support future institution categories and new fields without requiring a physical column for every optional fact. It must not create a parallel claims or approval system.

## 2. Required service responsibilities

| Component | Responsibility | Must not do |
|---|---|---|
| FieldDefinitionRegistryReader | Resolve immutable field key/version and lifecycle state | Activate definitions or modify values |
| FieldApplicabilityPolicy | Check subject entity type, provider category, scope and relationships | Infer category/status from institution name |
| TypedFieldValueValidator | Validate type, cardinality, units, locale, size, dates and structured schema | Fetch sources or approve claims |
| FieldEvidencePolicy | Enforce field evidence requirements and source authorization context | Grant source permissions |
| FieldAwareClaimProposalService | Coordinate field validation and call existing claim governance registration | Adjudicate or publish |
| PersistedGovernanceWorkflowService | Existing correction, adjudication, publication, suppression and restoration | Bypass field-definition binding for registry claims |
| EditorialReviewService | Existing human proposal review lifecycle | Treat automated extraction as human approval |
| FieldDefinitionReviewService (new bounded domain service) | Review/approve/activate definition versions under distinct human capabilities | Create institution values or publish facts |
| Projection policy/materializer | Build approved allowlisted public projections | Read raw/unreviewed claims directly |

These are logical responsibilities; class names are proposed and may be adjusted after implementation planning.

## 3. Single authoritative write path

### 3.1 New value proposal

A registry-managed value must follow this sequence:

1. Authenticate actor class and require the narrowly scoped proposal capability.
2. Resolve field key and exact definition version.
3. Require approved/active status and effective-time eligibility.
4. Resolve subject entity and its provider-category context from governed records.
5. Check explicit entity-type, provider-category, scope and parent-relationship applicability.
6. Validate typed value, cardinality, locale, units, dates, bounded payload and missing-state semantics.
7. Enforce privacy and prohibited-data policy.
8. Verify source authorization for the requested acquisition/processing/retention/use context.
9. Verify all evidence references exist, are admissible for the requested operation and are linked to the proposal.
10. Create proposed claim and claim version with immutable field-definition-version binding.
11. Create claim-evidence links and audit/outbox events in the same transaction.
12. Submit through the existing editorial review lifecycle.
13. Stop. No adjudication, publication, projection or autonomous materialization occurs in this command.

### 3.2 Required atomicity

The following must be transactionally consistent:
- claim row;
- claim version and exact definition-version binding;
- evidence links;
- idempotency record/fingerprint;
- audit event;
- outbox event where used.

If any validation or write fails, none of the above should be partially committed.

## 4. Preventing generic claim-registration bypass

The inspected GovernanceCommandService currently accepts a predicate and array value and registers a proposed claim after subject/evidence/source-processing checks. The inspected method does not itself demonstrate field-registry validation.

D3 requires an explicit two-path policy:

### Registry-managed predicates
- The predicate must resolve to a registered immutable field key.
- The claim version must bind to one exact approved definition version.
- FieldAwareClaimProposalService validation is mandatory.
- Generic registration must reject registry-managed predicates unless it receives a trusted, validated definition-version context from the field-aware service.
- Callers cannot self-assert that validation occurred through a caller-supplied boolean or arbitrary metadata.

### Legacy/specialized predicates
- Existing controlled predicates may continue through their existing domain services during migration.
- A finite, reviewed compatibility allowlist must identify them.
- Unknown predicates fail closed.
- The allowlist must not become a permanent path for new dynamic fields.
- A specialized entity predicate such as campus or programme must continue to use its domain materializer and existing evidence/adjudication checks.

The implementation plan must not simply add a public wrapper while leaving an unrestricted bypass open.

## 5. Definition lifecycle is a separate write path

Field definitions are not claims about institutions. They must not be submitted through the ordinary institution claim service.

Definition lifecycle:
1. Propose field key and version draft.
2. Validate uniqueness, semantics, type, applicability, privacy, evidence and projection policy.
3. Open a field-definition review case.
4. Require independent human review and approval.
5. Activate through a separate capability and audited transition.
6. Retire/deprecate through a separate human decision.
7. Keep immutable history and successor mappings.

No field definition activation creates or updates institution values.

## 6. Actor capability contract

Proposed capabilities (final names subject to owner/security review):

| Actor/action | Permitted capability | Restrictions |
|---|---|---|
| Human editor proposes a value | propose_field_value | Must meet entity and field scope; cannot approve own proposal |
| AI extraction agent proposes a value | submit_agent_field_proposal | Proposal-only, approved source/field scope, bounded quotas; cannot review/adjudicate/publish |
| Human reviewer | review_field_value_proposal | Distinct from submitter and evidence submitters |
| Human adjudicator | adjudicate_claim | Existing high-impact separation rules remain |
| Human publisher | authorize_publication | Existing independent publisher rules remain |
| Human field steward | propose_field_definition | Cannot approve own definition |
| Independent definition reviewer | review_field_definition | Distinct actor from proposer |
| Authorized definition approver | approve_field_definition | Human-only, distinct reviewer/proposer where policy requires |
| Authorized registry steward | activate_field_definition / retire_field_definition | Separate audited action after approval |
| Privacy/legal retention authority | authorize_erasure | Separate policy-controlled workflow |

An agent may not:
- create or activate a field definition;
- modify provider/entity taxonomy;
- adjudicate or resolve conflicts;
- approve publication;
- withdraw or erase a value directly;
- retire or restore a field;
- grant source permissions or extend an authorization.

## 7. Correction and withdrawal service boundaries

### Correction
- Resolve the original claim and its definition-version binding.
- Validate the new value against an active compatible definition version.
- Require evidence and reason/rationale.
- Create a successor claim version using existing correction lifecycle.
- Preserve original definition binding on the old version and bind the new version to the selected definition version.
- Resubmit through editorial review and adjudication.

### Withdraw one value
- Require a human actor and a distinct capability.
- Identify exact claim/value and affected projection(s).
- Record withdrawal reason, rationale and evidence/source implications.
- Use the existing governed claim withdrawal/suppression semantics after confirming exact lifecycle support.
- Remove only the affected value from current eligible projection after approval.
- Preserve permitted historical record and audit.

### Retire one field
- Operates on the field definition, not an institution claim.
- Stops new proposals after effective time.
- Does not automatically withdraw all values.
- Requires separate projection reevaluation and successor mapping where needed.

### Legal/privacy erasure
- Must be a separate authorized workflow.
- Requires retention/legal policy, scope, approver, deletion evidence and audit minimization.
- Must not be implemented as ordinary editor delete.

## 8. Read and profile assembly boundary

Profile assembly must:
- load stable institution/entity identity;
- load only current approved claim versions with valid publication decisions;
- resolve each value using its exact field-definition version;
- apply field visibility, privacy, suppression and Deeni Madaris policy;
- apply profile template rules for the provider category;
- represent missing, unknown, not applicable, expired, disputed and unverified states accurately;
- exclude internal notes, source content and authorization metadata;
- use only explicitly allowlisted fields for search/filter/sort.

A new definition is not automatically visible in a profile. A value is not public because its field is marked public-eligible; claim approval and publication remain mandatory.

## 9. Idempotency, concurrency and error contract

Every write command requires:
- stable idempotency key;
- actor identity/class;
- canonical command fingerprint;
- exact entity, field key/version and value/evidence references;
- policy/validator version.

Expected behavior:
- same key and same fingerprint returns the original logical result;
- same key with different actor or payload is rejected;
- concurrent duplicate proposals do not create duplicate claims;
- a stale definition version is rejected or routed to an explicit compatibility policy;
- an expired/revoked source authorization blocks the affected operation;
- unsupported type, scope, privacy or evidence policy fails closed;
- errors expose safe reason codes, not source content or sensitive values.

## 10. Synthetic test contract

At minimum:
1. Valid field proposal uses exact active definition version.
2. Missing definition or retired field is rejected.
3. Entity/provider category mismatch is rejected.
4. Wrong scope (institution vs campus/programme) is rejected.
5. Unsupported type/cardinality/schema is rejected.
6. Generic claim registration cannot bypass field-aware validation.
7. Legacy allowlisted predicates continue through approved specialized services.
8. Unknown predicate fails closed.
9. Missing/revoked/expired source authorization blocks proposal.
10. Evidence links are bound to the exact claim version.
11. Agent can submit proposal only within approved synthetic scope.
12. Agent cannot define, activate, review, adjudicate, publish, withdraw, retire or erase.
13. Human review requires separation from submitter/evidence submitters.
14. Human adjudication and publication preserve existing M3-03 rules.
15. Correction creates a successor version with preserved history and definition binding.
16. Withdrawal affects only the targeted value/projection.
17. Field retirement does not delete values or evidence.
18. Internal/private fields cannot enter public projections or search.
19. Definition version changes do not reinterpret historical claim versions.
20. Audit/outbox/claim/evidence writes are atomic and idempotent.
21. Profile completeness is distinct from verification.
22. Deeni Madaris remains default-OFF.
23. Concurrent duplicate proposals produce deterministic outcomes.
24. All fixtures and adapters are synthetic; no external source/API/model call is made.

## 11. Implementation sequencing proposal

After owner approval of D1/D2 and a separate bounded local/CI implementation authorization:

- P1: registry persistence and immutable definition-version reader.
- P2: applicability and typed validator.
- P3: field-aware claim proposal service and generic bypass guard.
- P4: definition review/approval/activation lifecycle.
- P5: value correction/withdrawal and profile assembly integration.
- P6: synthetic agent proposal adapter with no adjudication/publication capability.
- P7: adversarial, concurrency, migration and full regression validation.

Each package must have its own acceptance criteria, isolated branch/PR, exact-head PHP 8.5 CI and documentation validation. No package grants external source access or production operation.

## 12. Authorization and safety boundary

This D3 record is service-boundary design only. No application code, migration, schema, UI, source access, real data, external model/API/connector/scheduler, production operation, V1/Hostinger/hPanel change, deployment, procurement or additional spend has been performed or authorized.

G2-G9 remain blocking for live source access or agent activation. A separate explicit bounded authorization is required before local/CI implementation. Human review, adjudication and publication remain mandatory.
