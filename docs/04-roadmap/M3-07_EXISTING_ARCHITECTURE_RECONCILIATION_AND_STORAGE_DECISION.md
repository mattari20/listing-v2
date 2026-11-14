# M3-07 — Existing Architecture Reconciliation and Extensible Storage Decision

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Baseline inspected:** `main` at `87d0a5ca3a34b8f46a5027c02a678198f143eabe`  
**Related proposal:** `M3-07_EXTENSIBLE_INSTITUTION_INFORMATION_MODEL.md`  
**Status:** Read-only architecture inspection and design recommendation. No application code, schema, migration, UI, source access or agent activation is authorized by this record.

## 1. Executive finding

The current repository already contains the correct governance backbone for extensible institution information:

- stable directory identities and typed relationships;
- generic claims and immutable claim versions;
- source authorization and evidence references;
- evidence-to-claim-version links;
- persisted adjudication and publication decisions;
- publication snapshots, projections, suppressions and restorations;
- conflicts, correction/withdrawal and rollback workflows;
- editorial review and append-only status history;
- specialized campus, delivery-site, programme and authority records.

**Recommendation:** extend this existing claim/evidence/adjudication/publication/audit lifecycle. Do not build a parallel attribute-value workflow, and do not create a physical database column for every optional institution fact.

The main missing capability is not basic storage. It is a governed, versioned field-definition registry and a deterministic validator that binds each field to allowed provider/entity types, subject scope, value type, cardinality, privacy, source/evidence rules, freshness, visibility and search behavior. The current generic claim value is JSON, but the inspected command path does not demonstrate a complete field-registry/type/scope validation contract.

## 2. Inspected baseline and evidence

The following existing files were inspected on `main`:

| Existing artifact | Observed responsibility | M3-07 reuse |
|---|---|---|
| `database/migrations/2026_11_13_000001_create_core_governance_tables.php` | `directory_entities`, `entity_relationships`, `source_authorizations`, `evidence_references`, `claims`, `claim_versions`, `claim_evidence_links`, `audit_events` | Identity, claim/version, evidence and provenance foundation |
| `database/migrations/2026_11_13_000002_create_persisted_governance_workflows.php` | Adjudication cases/decisions, publication decisions/snapshots, public projections, outbox, suppressions and restorations | Reuse all existing human governance and projection gates |
| `database/migrations/2026_11_14_000002_create_persisted_conflicts_and_rollbacks.php` | Claim conflicts/candidates and publication rollback | Preserve competing assertions and reversible publication |
| `database/migrations/2026_11_14_000004_create_campus_programme_catalogue.php` | Campus, delivery site, programme catalogue, qualification links and cycle-scoped programme offers | Keep independently identifiable repeatable structures first-class |
| `database/migrations/2026_11_14_000005_create_authority_profiles.php` | Typed authority profiles | Reuse authority identity and typed oversight relationships |
| `database/migrations/2026_11_14_000006_create_editorial_review_and_status_history.php` | Editorial review cases and append-only directory status history | Reuse review, actor separation, audit and lifecycle |
| `app/Services/Governance/GovernanceCommandService.php` | Generic proposed claim/version registration; checks subject existence, evidence references and source authorization for processing | Candidate common entry point for typed field proposals, after adding registry validation |
| `app/Services/Governance/PersistedGovernanceWorkflowService.php` | Adjudication, publication, correction and related persisted lifecycle | Continue using as the authority for claim decisions |
| `app/Services/Directory/EditorialReviewService.php` | Human submit/review/correction workflow with distinct actors | Reuse for field-value proposal workflow |
| `app/Services/Directory/CampusProgrammeCatalogueService.php` | Materializes selected accepted catalogue predicates into specialized records | Reuse the pattern for genuinely first-class entities only |
| `app/Domain/Governance/GovernancePolicy.php` | Source authorization, evidence, adjudication, publication, suppression/restoration policy | Extend through explicit field policy; do not bypass |
| `docs/04-roadmap/M3-03_LOGICAL_DOMAIN_MODEL_AND_GOVERNANCE.md` | Accepted logical separation of identity, assertions, evidence, review and publication | Remains the governing conceptual model |
| `docs/04-roadmap/M3-04_PROVIDER_MANAGEMENT_WORK_PLAN.md` and P04 implementation record | Provider/institution taxonomy, entity lifecycle and editorial controls | Preserve current provider management contracts |

This was a repository-code/document inspection only. It did not connect to a database or environment, execute migrations, inspect production records, or access any external source.

## 3. Existing architecture mapped to the extensible information design

| M3-07 requirement | Existing mechanism | Finding |
|---|---|---|
| Stable institution/campus/programme identity | `directory_entities` plus typed catalogue tables | Present for current supported entity vocabulary |
| A fact attached to an entity | `claims.subject_entity_id` and `claims.predicate` | Present |
| Versioned fact value | `claim_versions.value` JSON, version number, valid dates and supersession link | Present as a generic container |
| Source/evidence provenance | `source_authorizations`, `evidence_references`, `claim_evidence_links` | Present |
| Human review and adjudication | Editorial review and persisted adjudication services | Present |
| Human publication approval | Publication decisions, snapshots and projections | Present |
| Correction and conflict handling | Claim correction/version lineage, conflicts and rollback | Present |
| Suppress/restore | Publication suppressions/restorations | Present |
| Audit/status history | `audit_events` and `directory_status_history` | Present |
| Governed field definitions and definition versions | No dedicated field registry identified in inspected schema | Gap |
| Deterministic field type/cardinality validation | Claim value is JSON; generic registration path accepts an array | Gap; must be added before general-purpose dynamic fields |
| Provider/entity applicability and subject-scope enforcement per field | Generic claim registration confirms subject exists; field-specific applicability not demonstrated | Gap |
| Field-level privacy/public visibility/search allowlist | Publication controls exist, but no dynamic field policy registry identified | Gap |
| Field-level freshness/expiry and localization rules | Claim valid-time exists; full field-specific policy not demonstrated | Partial/gap |
| Safe field retirement and successor mapping | Claim version history exists; field-definition retirement/migration registry not identified | Gap |
| Profile templates/completeness by provider type | No governed template/completeness registry identified in inspected paths | Gap |
| Agent proposal-only access | Human-only controls exist in selected services; no agent is implemented | Future capability; do not activate |

## 4. Important implementation details and constraints

### 4.1 Claims are the right assertion primitive

The core migration defines:

- `claims.subject_entity_id` referencing a stable `directory_entities.id`;
- `claims.predicate` as a string key;
- `claim_versions.value` as JSON;
- immutable version numbering and a `supersedes_version_id` lineage;
- valid-time dates and recorded-time;
- evidence links to each claim version.

The generic claim-registration service verifies that the subject entity exists, validates evidence references and source authorization for processing, and creates a proposed claim version. It does not, in the inspected method, resolve a field definition or prove the JSON value conforms to a registered type/cardinality/provider-scope/privacy contract.

Therefore the generic claim mechanism is reusable, but **must not be exposed as unrestricted arbitrary JSON CRUD**. The field registry and validator must be enforced before a claim version can be registered.

### 4.2 Subject scope should use entity identity, not copied institution labels

A value about a campus should be a claim on that campus entity; a programme fact should be on its programme entity; a cycle-specific admission deadline should be attached to a first-class admission-cycle/offer entity when that entity exists. Institution-level facts remain attached to the institution.

Do not encode campus/programme/intake scope only as an arbitrary text property inside the value. Do not use institution name as a foreign key. For entity types not yet represented, first decide whether they require independent identity/lifecycle or can safely remain a bounded typed claim on an existing entity.

### 4.3 First-class records remain appropriate for independent lifecycles

The campus/programme migration demonstrates the existing pattern: create a typed entity and materialize an accepted claim version into a specialized table. Continue this only for concepts with independent identity, relationships, lifecycle or frequent query requirements (for example, admission cycle, fee schedule, course or scholarship offer after domain review).

Do not create a separate table for every optional scalar such as library hours, transport availability or contact label. Those are candidates for governed typed claims unless query/performance evidence later justifies promotion.

### 4.4 Entity vocabulary is currently controlled and finite

The inspected provider/institution policy currently permits a finite set of entity types (provider, institution, campus, delivery site, programme, qualification, authority and awarding body). The nationwide scope must not assume that the current list already covers every possible provider sub-type or child entity.

Recommended distinction:

- Keep `institution` as a stable identity type for schools, colleges, universities, academies and similar education institutions where their identity/lifecycle semantics are the same.
- Represent institution/provider category and sub-type as governed, versioned taxonomy facts (for example, school, private school, college, academy, vocational centre), not as an ever-growing set of unrelated database tables.
- Add a new first-class entity type only when it has independent identity, relationships or lifecycle (for example, campus, programme, course, intake or fee schedule).
- Keep provider category, ownership, operating status, registration, recognition, accreditation and affiliation as distinct facts/relationships. Directory inclusion is not proof of legal or regulatory status.
- A taxonomy change must be reviewed and versioned; it must not silently reinterpret historical records.

This approach supports small private schools and academies without making each institution subtype a new storage architecture.

## 5. Recommended target design

### 5.1 Reuse the claim lifecycle for field values

The intended write path should be:

1. Resolve the active field definition and its version.
2. Validate that the subject entity type and provider category are allowed.
3. Validate scope, type, cardinality, locale, units/currency, date semantics and bounded structured payload.
4. Enforce privacy classification, prohibited-value rules and source/evidence requirements.
5. Check exact source/asset/method authorization independently of the field definition.
6. Register a proposed claim/version through the existing governance command boundary.
7. Run deterministic domain validation and conflict/freshness checks.
8. Submit through the existing editorial review and persisted adjudication process.
9. Require a distinct human publication decision.
10. Generate public/search projections only from approved, current, allowlisted fields.
11. Record audit/outbox events with idempotency and correlation.

No direct agent or editor write may skip these steps.

### 5.2 Field-definition registry: design before physical choice

A field definition should have an immutable key and explicit versions. Each version should define:

- display/section keys and help text identifiers;
- allowed entity types and provider categories;
- subject scope and cardinality;
- value type and deterministic validation schema;
- localization, units, currency and effective-date rules;
- privacy class, prohibited-value rules and retention class;
- source/evidence requirements and allowed source classes;
- freshness/expiry policy;
- internal/public visibility and explicit search/filter allowlist;
- active/retired state, effective dates and successor mapping;
- proposer/reviewer/approver and change rationale.

The registry may be persisted as additive tables or another reviewed representation, but this choice must follow a bounded schema/service design and tests. The registry must not duplicate claim versions, evidence, adjudication, publication or audit records.

### 5.3 Typed JSON is acceptable only behind a strict registry

The current JSON value column can support varied types without one physical column per field, but only if every value is validated against the active field definition before it reaches the claim lifecycle.

- Scalars must use deterministic types and normalization.
- Money must include amount, currency and applicable period.
- Durations must include units.
- Dates and ranges must be validated and tied to valid-time/session semantics.
- Repeatable values need explicit cardinality and stable item identity when items have independent lifecycle.
- Structured values must use bounded, versioned schemas and depth/size limits.
- Unknown types, arbitrary executable content, unbounded nesting and untrusted HTML must fail closed.
- Missing, unknown, false, zero, empty, not applicable, expired, pending review and intentionally hidden must remain distinguishable.

Do not automatically index every JSON key. Search/filter fields must be explicitly allowlisted and query-safe.

## 6. Add, edit, retire, restore and delete semantics

| User/admin action | Required domain operation | Expected behavior |
|---|---|---|
| Add a new information field | Propose and approve a new field-definition version | Does not add a value to every institution and does not grant source permission |
| Add information for one institution | Propose a claim version under an active field definition | Requires valid subject scope, type and evidence/source basis |
| Edit/correct a value | Create a successor claim version through existing correction workflow | Preserve previous value, evidence, reason and lineage |
| Remove one value from current profile | Human-reviewed claim withdrawal/retirement | Remove from current projection after approved decision; preserve permitted history |
| Retire a field globally | Retire the field definition version | Stop new proposals; preserve historical interpretation and values under retention policy |
| Replace/split/merge a field | Create successor field definition and explicit mapping | No silent reinterpretation; record migration exceptions and approvals |
| Restore a retired value/field | Explicit policy-checked human workflow | Revalidate current source, definition, evidence and publication eligibility |
| Legal/privacy erasure | Separate approved retention/deletion workflow | Not an ordinary editor hard-delete; retain only what policy/law permits |

The existing claim correction and publication suppression/restore mechanisms are useful building blocks, but field-definition lifecycle and legal erasure need their own explicit contracts. Do not claim that existing publication restore automatically restores a retired field definition.

## 7. Recommended implementation sequence (not yet authorized)

**D0 — Design reconciliation (this record):** map existing tables/services, identify reuse and gaps.

**D1 — Field registry contract:** finalize immutable field keys, definition versions, type/cardinality, applicability, privacy, evidence, freshness, visibility, retirement and migration rules. Deliver synthetic examples and threat/abuse cases.

**D2 — Storage decision and migration proposal:** compare (a) registry tables + existing claim values, (b) versioned config/catalogue plus claims, and (c) specialized typed tables for independent entities. Choose the smallest design that satisfies auditability, database portability and query needs. No migration until separately authorized.

**D3 — Validator/service boundary:** design a single field-aware claim proposal service that delegates to existing governance workflows. Ensure generic claim entry cannot be used to bypass registry validation.

**D4 — Synthetic-only implementation pilot:** after separate explicit authorization, implement a narrow synthetic field family and tests on an isolated branch; no live sources or production.

**D5 — Lifecycle and profile templates:** add field retirement/successor mapping, institution-type-specific optional sections, completeness/verification separation and public projection allowlists.

**D6 — Agent proposal adapter:** only after G2-G9 gates and a separate activation decision; deterministic fake adapter first, proposal-only permissions, no direct adjudication/publication.

## 8. Required synthetic acceptance cases before code

At minimum, tests must prove:

1. A new approved field definition can be introduced without adding a physical column.
2. A duplicate immutable field key or invalid definition version is rejected.
3. Unknown types, invalid cardinality, out-of-scope entity types and malformed structured values fail closed.
4. A school-only field cannot be attached to a university or academy unless its applicability explicitly permits it.
5. Campus and programme facts attach to their own entity IDs, not the parent institution by mistake.
6. Repeated admission cycles/fee schedules remain separate and time-bounded.
7. Missing, unknown, false, zero, empty and not-applicable remain distinct.
8. A field definition does not authorize acquisition from a source.
9. An expired/revoked source authorization blocks the proposal/processing path.
10. Agent/service actors cannot create/activate definitions, adjudicate, publish, retire or erase records.
11. Correction creates a successor claim version and preserves evidence/history.
12. Withdrawal removes a value only from the eligible current projection after required human decisions.
13. Field retirement blocks new proposals but preserves historical interpretation.
14. Successor field mapping is explicit, versioned and auditable.
15. Private/internal fields cannot enter anonymous projections or dynamic search.
16. Dynamic search uses only explicitly approved, typed, bounded fields.
17. Concurrent updates and duplicate submissions remain idempotent and auditable.
18. Profile completeness is distinct from verification quality.
19. Deeni Madaris default-OFF behavior remains intact across all new templates/projections.
20. Retention/deletion requests follow a separate policy-controlled workflow.

All tests must use fictional institutions, fabricated values, synthetic evidence and deterministic adapters. No real source or institution data is required.

## 9. Open design decisions

The following must be decided in D1/D2 rather than guessed:

- Which fields are universal core facts versus optional provider-type templates?
- Which entity types need first-class identity in addition to the existing catalogue?
- Whether field definitions are stored in dedicated registry tables or a versioned catalogue artifact.
- Exact JSON schema dialect, supported types, maximum nesting/size and localization representation.
- Whether a field's definition version is stored directly with each claim version or resolved through an immutable predicate/version relation.
- How field-definition approval uses the existing review workflow without treating a field definition as an institution claim.
- How value withdrawal is represented distinctly from ordinary correction and publication suppression.
- Retention, erasure, evidence-reference withdrawal and audit minimization policy.
- Dynamic query/index strategy and database portability/performance thresholds.
- Initial synthetic pilot field family and institution profile templates.

## 10. Authorization boundary

This record authorizes no implementation. It is based on read-only inspection of repository files on `main`.

Not performed: database connection, migration execution, schema change, code change, admin UI, source retrieval, web scraping, institution contact, real-data import, API/connector/model/crawler/scheduler activation, deployment, V1/Hostinger/hPanel access, production operation, procurement or additional spend.

M3-07 application implementation and live collection remain blocked by the existing source-rights, privacy, security, model/provider, cost, governance, synthetic evaluation and owner activation gates. A future local/CI-only field-registry implementation requires its own explicit bounded authorization and exact-head CI validation.
