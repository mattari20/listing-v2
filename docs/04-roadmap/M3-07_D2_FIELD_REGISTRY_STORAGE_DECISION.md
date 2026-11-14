# M3-07 D2 — Field Registry Physical Storage Decision

**Date:** 2026-11-14  
**Repository:** mattari20/listing-v2  
**Depends on:** D1 Field Registry Contract; M3-03 claim/evidence/governance lifecycle; M3-04 provider identity and catalogue  
**Status:** Architecture decision proposal only. No schema, migration or application code is authorized.

## 1. Decision summary

**Recommended approach: normalized field-definition registry tables plus the existing claims and claim-version store.**

Keep one authoritative value lifecycle. Do not introduce a second entity-attribute-value system.

- Store stable field identity and immutable definition versions in dedicated registry tables.
- Store each institution fact as a normal existing claim/claim-version value.
- Bind each registry-managed claim version to the exact field-definition version that validated it.
- Keep evidence, source authorization, adjudication, publication, conflicts, correction/withdrawal and audit in their existing M3-03 services/tables.
- Keep independently identifiable concepts (campus, programme, admission cycle, fee schedule where justified) as first-class entities with their own lifecycle.
- Use bounded, versioned JSON only for typed field schemas and validated values; do not allow arbitrary keys, executable content or unbounded nesting.

This is the smallest architecture that supports extensibility while preserving the project's existing governance guarantees.

## 2. Alternatives evaluated

| Option | Benefits | Problems | Decision |
|---|---|---|---|
| Versioned configuration files only | Simple initial authoring; no registry tables | Weak runtime governance, actor approvals, concurrent editing, database audit and field lifecycle; unsuitable for admin-managed expansion | Reject as primary registry |
| Dedicated field registry + existing claims | Clear immutable definitions; field values reuse existing evidence and review; additive schema | Requires registry and claim-binding migrations plus validator | **Recommend** |
| Separate generic EAV value store | Flexible field/value rows | Duplicates claims, versions, evidence, correction, adjudication, publication and audit; creates competing truth stores | Reject |
| Physical column/table for every optional field | Strong typed columns and familiar SQL | Schema explosion, frequent migrations, inconsistent provider-specific growth, high maintenance | Reject for optional attributes |
| One large JSON profile per institution | Flexible and initially fast | Weak field-level provenance, validation, version history, query safety, correction and privacy boundaries | Reject |

## 3. Logical physical components

This section defines a proposed normalized shape, not executable migration instructions.

### 3.1 field_definitions — stable field identity

One row per immutable field key.

Proposed columns:
- id: UUID primary key;
- field_key: unique immutable key;
- created_at, updated_at.

Rules:
- field_key is unique and never reused;
- no semantic metadata is overwritten on this identity row;
- retirement does not delete or release the key.

### 3.2 field_definition_versions — immutable definition content

One row per approved or proposed version of a field.

Proposed columns:
- id: UUID primary key;
- field_definition_id: FK to stable field identity;
- version_number: positive integer, unique per field;
- lifecycle_state: proposed, approved, active, deprecated, retired or rejected;
- semantic_version and compatibility_class;
- value_type and cardinality;
- scope_key and privacy_class;
- visibility_class and searchable/filterable/sortable flags;
- validation_schema: bounded JSON;
- presentation_metadata: bounded JSON with localization keys;
- evidence_policy and freshness_policy: bounded, versioned JSON;
- effective_from and effective_to;
- successor_field_definition_id: nullable FK;
- proposer/reviewer/approver actor references and rationale reference;
- created_at and updated_at.

Constraints:
- unique(field_definition_id, version_number);
- active version must have complete required policy;
- approved versions are immutable;
- state transitions are audit events, not silent updates to semantic content;
- no secret or source content is stored in metadata JSON.

### 3.3 Applicability relations

Use normalized relation tables rather than embedding unrestricted provider/entity applicability in one opaque JSON list.

Proposed tables:
- field_definition_version_entity_types: definition version + allowed directory entity type;
- field_definition_version_provider_categories: definition version + allowed provider category;
- optional field_definition_version_exclusions: explicit excluded category/entity combinations only if D1 review finds they are necessary.

Rules:
- zero implicit inheritance;
- an explicit universal marker is allowed only if represented unambiguously and reviewed;
- applicability relations are immutable for approved versions;
- no category or entity type is inferred from institution name.

### 3.4 Exact binding from claim version to definition version

**Recommended binding:** add a nullable field-definition-version foreign key to claim_versions in a new additive migration, while retaining the existing claim predicate as the stable field key.

Invariant for registry-managed claims:
- claims.predicate must equal the field key of the bound definition version;
- claim_versions.field_definition_version_id must identify the exact definition version used for validation;
- the referenced definition version must be active/approved at proposal time and applicable to the claim subject;
- later retirement or a newer definition version must not alter historical interpretation.

Why nullable:
- existing M3-03 claims and legacy controlled predicates may predate the registry;
- no bulk backfill should be invented;
- the field-aware service must require the binding for all new registry-managed fields;
- the compatibility allowlist for existing non-registry predicates must be explicit and finite.

Do not rely on resolving a claim version against whichever definition happens to be current when it is read. That would reinterpret history after field changes.

Alternative rejected: a separate many-to-many claim-version/definition link table. A claim version represents one predicate/value assertion, so a single immutable definition-version binding is expected. A link table would allow ambiguous multiple-definition associations without adding useful capability.

### 3.5 Typed claim value

Continue using the existing claim_versions.value JSON column for registry-managed values, but validate it strictly before registration.

Rules:
- the active definition version supplies the exact type/schema and size limits;
- JSON is a transport/storage envelope, not an untyped free-for-all;
- scalar values should remain scalar where practical;
- money, duration, date ranges and bounded collections use explicit versioned object schemas;
- no arbitrary keys, unbounded nesting, executable markup, uploaded binaries or source documents;
- missing/unknown/not-applicable states must be represented distinctly from false, zero and empty;
- query-critical fields are promoted only after measured need and review.

This avoids duplicating claim values in a second attribute table.

## 4. Definition review and activation workflow

Field definitions are not institution claims. Existing editorial review cases require a directory entity and claim version, so they should not be misused to approve a registry definition.

Recommended bounded governance extension:
- field_definition_review_cases: target definition version, submitter, assigned reviewer, status, idempotency key and fingerprint;
- field_definition_review_decisions: case, outcome, human actor, rationale, policy version and timestamp;
- use the existing GovernancePolicy capability and separation-of-duties principles;
- write all transitions to existing audit_events and transactional outbox;
- proposer, reviewer and approver must be distinct where policy requires;
- no automated actor may approve or activate;
- activation is a distinct, audited transition after approval and compatibility checks.

This is a separate review target, not a second claim adjudication system. It must not copy or fork source/evidence/publication lifecycle logic.

## 5. Lifecycle operations and storage effects

| Operation | Registry effect | Claim/value effect |
|---|---|---|
| Propose field | Create draft identity/version or draft version | None |
| Approve field | Append decision; definition version becomes approved | None |
| Activate field | Audited activation transition | New claims may reference this version |
| Add institution value | None | New proposed claim version bound to active definition |
| Correct value | None | Successor claim version bound to chosen compatible definition version |
| Withdraw value | None | Governed claim withdrawal/suppression path; retain history per policy |
| Deprecate field | New lifecycle event/version with end-of-use window | New claims restricted according to effective date |
| Retire field | Stop new proposals; reserve key | Historical claims remain interpretable; projection policy reevaluated |
| Replace field | Create successor field/version and explicit mapping | Optional migration creates new claims with provenance and review |
| Legal erasure | Policy-controlled registry/value/evidence retention action | Separate retention/deletion workflow; no ordinary hard-delete |

Definition retirement must not automatically delete values. Value withdrawal must not retire the field globally.

## 6. Existing architecture reuse map

| Existing component | Continue to use for |
|---|---|
| directory_entities | Stable provider, institution, campus, programme and other entity identities |
| claims / claim_versions | All institution information assertions and immutable value history |
| claim_evidence_links / evidence_references | Field-value evidence provenance |
| source_authorizations | Exact source, purpose, method, territory, retention and processing authorization |
| GovernanceCommandService | Proposed claim registration, after field-aware validation is enforced |
| PersistedGovernanceWorkflowService | Claim correction, adjudication, publication, suppression and restoration |
| EditorialReviewService | Institution claim editorial submission/review lifecycle |
| claim_conflicts / conflict candidates | Conflicting field-value assertions |
| audit_events / governance_outbox | Auditable transitions and reliable downstream events |
| publication snapshots/projections | Approved public values only |
| directory_campuses / programme catalogue | Independent lifecycle/query needs that warrant first-class entities |

Do not create new evidence, adjudication, publication or audit tables for field values.

## 7. Migration and compatibility strategy

When separately authorized, migrations must be additive and isolated:

1. Create field identity and definition-version tables.
2. Create normalized applicability relation tables.
3. Add nullable definition-version binding to claim_versions.
4. Add indexes and foreign-key constraints with safe rollback behavior.
5. Add field-definition review/decision records only after capability contract is finalized.
6. Do not rewrite existing migrations already merged to main.
7. Do not backfill existing claims by guessing field definitions.
8. Inventory existing predicates and classify each as registry-managed, specialized entity predicate or explicitly legacy-controlled.
9. New dynamic fields must use the field-aware proposal service; generic registration cannot bypass the registry.
10. Add synthetic migration tests from an empty database and a database containing pre-registry claims.
11. Preserve portability across the project's supported database/test environments; avoid vendor-specific JSON indexing as a correctness dependency.

No migration is included in this D2 proposal.

## 8. Indexing and performance strategy

Initial indexes should support:
- unique field key;
- unique field/version pair;
- definition status/effective-time lookup;
- applicability lookup by definition version and provider/entity type;
- claim subject + predicate lookup;
- claim version + exact definition-version lookup;
- existing evidence, adjudication and publication joins.

Do not index arbitrary JSON paths or every dynamic field. Search/filter fields must be explicitly allowlisted. If a field becomes a high-volume filter, evaluate a typed projection or dedicated query structure after profiling synthetic workloads. Do not let dynamic field keys become SQL identifiers.

## 9. Transaction, concurrency and idempotency invariants

- Definition version creation, review decision, activation event and audit/outbox writes must be transactionally consistent.
- Definition key/version uniqueness must be enforced at the database level.
- Only one compatible active version per field key should be available for new proposals at a given effective time unless an explicitly reviewed staged rollout is designed.
- A value proposal binds to one immutable definition version before validation.
- Claim version, evidence links, review case and audit events must retain existing transactional/idempotency safeguards.
- Concurrent duplicate proposals must return the same logical result or a deterministic conflict; never create silent duplicate definitions.
- A stale form/client cannot submit against a retired or superseded definition version without explicit policy.
- Definition activation must not silently change current public projections; projection reevaluation is a separate governed event.

## 10. Security and privacy controls

- Treat labels, help text, enum labels and validation metadata as untrusted authored content; render safely.
- Never allow dynamic field names to become SQL identifiers, file paths, template names or executable expressions.
- Enforce value-size, nesting-depth, collection-count and string-length limits.
- Do not accept arbitrary HTML, JavaScript, formulas or uploaded file payloads.
- Do not collect student, child, applicant or staff personal data in the institution profile scope.
- Internal-only values must be excluded from public snapshots and search.
- Source authorization is checked at acquisition, processing, retention and use as applicable; field activation never substitutes for source permission.
- Keep Deeni Madaris default-OFF and ensure no new registry route can bypass it.

## 11. D2 synthetic acceptance matrix

1. Unique field identity and version constraints are enforced.
2. Retired keys cannot be reused.
3. Approved definition content cannot be mutated.
4. Applicability relations reject disallowed provider/entity types.
5. Claim predicate and bound definition field key must match.
6. Claim version retains exact definition version after a newer version activates.
7. Legacy claim without registry binding remains readable under an explicit compatibility path.
8. New dynamic claim without definition binding is rejected.
9. JSON value fails if it violates registered type/schema/size/cardinality.
10. Field definition approval and activation require distinct authorized human actors.
11. Agent actor cannot approve/activate or adjudicate/publish.
12. Correction creates successor claim version and preserves evidence lineage.
13. Field retirement blocks new proposals but preserves history.
14. Value withdrawal does not retire the field globally.
15. Public/search projection excludes internal-only and non-allowlisted fields.
16. Definition change does not automatically republish old values.
17. Duplicate/concurrent definition and value commands remain idempotent.
18. Fresh database migration and pre-registry synthetic database migration both pass.
19. Deeni Madaris default-OFF behavior remains enforced.
20. No real sources, provider data, external services or production resources are used.

## 12. Remaining decisions before implementation

The following still require explicit owner/domain/security review before code:
- exact field-definition review capability names and role separation;
- whether policy metadata JSON needs additional normalized tables for the first pilot;
- whether any field type requires a dedicated value representation beyond claim_versions.value;
- exact supported database portability targets and index limits;
- initial synthetic pilot field family and provider templates;
- compatibility allowlist for existing predicates;
- retention/deletion policy and evidence withdrawal interaction;
- whether D2 should include the minimal field-definition review workflow in the first migration or stage it separately.

The recommended physical shape is sufficiently defined for a future bounded implementation proposal, but these decisions must be resolved rather than silently assumed.

## 13. Authorization and safety boundary

This D2 record is a storage architecture proposal only. No code, migration, schema, UI, data import, source access, model/agent/connector/scheduler activation, production operation, V1/Hostinger/hPanel change, deployment, procurement or additional spend has been performed or authorized.

Any local/CI-only implementation requires separate explicit bounded authorization and exact-head PHP 8.5 foundation CI plus documentation validation. G2-G9 remain blocking for live source access or agent activation.
