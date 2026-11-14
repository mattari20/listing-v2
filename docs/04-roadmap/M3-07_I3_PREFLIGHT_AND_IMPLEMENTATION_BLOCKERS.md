# M3-07 I3 — Field-Aware Claim Integration Preflight and Blockers

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Package:** I3 — Field-aware proposal path, exact definition binding and generic registration bypass guard  
**Base:** `f767bcb8f8b5e55a4d80225ce05c4f3842d8295d`  
**Status:** Preflight started. Implementation is paused at a D5 stop condition pending an owner decision. No application code, migration or test behavior has been changed in this record.

## 1. Authorized I3 boundary

This preflight follows the I3 package described in the M3-07 D5 proposal:

- one field-aware proposal path;
- exact immutable field-definition-version binding on each registry-managed claim version;
- prevention of generic claim-registration bypass;
- atomic claim, claim-version, evidence-link, audit and outbox handling;
- synthetic proposed-claim writes in disposable local/CI databases only;
- submission to the existing editorial review lifecycle, then stop.

I3 does not include definition review/activation (I4), value correction/withdrawal/profile projection (I5), agent adapters (I6), search changes, public routes, deployment or production activity.

The D5 proposal currently exists on the open draft design PR #197; this record treats its I3 row and D3 service contract as the design reference, not as a merged implementation authorization.

## 2. Verified repository baseline

The current `main` head at preflight start is `f767bcb8f8b5e55a4d80225ce05c4f3842d8295d`. I1 and I2 are merged. Relevant existing components include:

- `app/Services/Governance/GovernanceCommandService.php`
- `app/Services/Directory/FieldDefinitionRegistryReader.php`
- `app/Services/Directory/TypedFieldValueValidator.php`
- `app/Services/Directory/EditorialReviewService.php`
- `app/Services/Governance/PersistedGovernanceWorkflowService.php`
- `database/migrations/2026_11_13_000001_create_core_governance_tables.php`
- `database/migrations/2026_11_13_000002_create_persisted_governance_workflows.php`
- `database/migrations/2026_11_14_000007_create_field_registry_tables.php`

### 2.1 Existing generic claim path

`GovernanceCommandService::registerProposedClaim()` accepts a caller-supplied predicate and array value. It checks the actor's `register_claim` capability, subject existence, evidence-reference existence and processing authorization, then transactionally inserts a claim, proposed claim version, evidence links and audit event.

It does not currently:
- resolve a field key or exact field-definition version;
- invoke `TypedFieldValueValidator`;
- bind a claim version to a field-definition version;
- reject a registry-managed predicate from the generic path;
- create an editorial review case as part of proposal registration.

This confirms the bypass-control work is necessary. The new field-aware path must submit through the existing `EditorialReviewService`; generic claim registration must not remain an alternate route for registry-managed fields.

### 2.2 Missing authoritative provider-category assignment

The current `directory_entities` table stores `id`, `entity_type` and `label`. The inspected M3-04 provider/institution relationship policy controls entity types and relationship predicates, but does not persist a provider category such as school, college, academy or university.

The I1 registry applicability table stores the provider-category allowlist declared by a field definition. It does not identify the actual category of a subject entity. The current `FieldDefinitionRegistryReader::resolveApplicable()` requires a provider category as an input; it cannot derive that category from the subject entity.

D3 requires the service to resolve provider-category context from governed records and prohibits inferring it from an institution name or accepting an untrusted caller assertion. There is therefore no safe way, on the current schema, to enforce provider-category applicability for a claim proposal.

**Stop condition:** do not implement I3 by trusting a caller-supplied `provider_category`, guessing from labels, or silently treating all entities as one category.

### 2.3 Field-key contract mismatch

I2's `TypedFieldValueValidator::validateFieldKey()` accepts lowercase ASCII snake_case keys and rejects dotted keys. However, the I1 reader feature tests and D4 examples use dotted identifiers such as `institution.display_name`.

I3 must follow the D1/I2 canonical snake_case contract. Before registry-managed proposal writes are enabled, synthetic field identifiers and examples must be reconciled to snake_case. No dotted-to-snake-case aliasing or implicit normalization may occur at the write boundary.

### 2.4 Claim-version binding and outbox contract

The current `claim_versions` table has no `field_definition_version_id` column. I3 therefore needs a new additive migration for a nullable foreign-key binding; existing claim versions must remain unbound, with no guessed backfill.

The current outbox worker handles publication snapshot lifecycle events. It does not currently define a field-claim proposal event contract. D5 calls for claim/evidence/audit/outbox atomicity. Before adding a proposal outbox event, I3 must define its event type, minimal identifier-only payload, idempotency key and safe worker behavior. It must not enqueue an event that the current worker will classify as unsupported or dead-letter.

## 3. Required implementation design after blocker resolution

Once the provider-category source is authoritatively defined, implementation should proceed in this order:

1. Inventory every production-code caller and predicate passed to `registerProposedClaim()`; classify the finite legacy/specialized compatibility allowlist and fail closed for unknown predicates.
2. Add an additive nullable `claim_versions.field_definition_version_id` foreign key and lookup index. Do not backfill existing versions.
3. Add a field-aware proposal boundary that resolves the subject, exact active definition version, entity type, provider category and scope from governed records; validates the field key and value using I2; checks privacy/evidence/source authorization; and rejects inapplicable or malformed requests.
4. Harden generic claim registration so registry-managed predicates cannot use it and unknown predicates cannot become an unrestricted dynamic-field path. Preserve only the reviewed finite legacy/specialized allowlist.
5. Persist claim, claim version with exact definition binding, evidence links, idempotency/audit and the approved outbox event atomically.
6. Submit the proposed claim version to the existing editorial review workflow. Do not adjudicate, publish, project, materialize or activate any agent.
7. Add synthetic feature tests for valid proposal, exact-version binding, missing/inactive definition, invalid type, category mismatch, scope mismatch, prohibited privacy class, evidence/source authorization failure, idempotent retry, generic bypass rejection and preservation of legacy specialized callers.

## 4. Stop conditions and safety

Implementation remains blocked until the provider-category source is resolved. Stop and seek owner direction if resolving it requires a new taxonomy/assignment table or a broader M3-04 change not already included in I3 authorization.

All tests must use synthetic fixtures and disposable local/CI databases only. No production database, V1, Hostinger/hPanel, real institution/student data, source access, external API/model/connector/scheduler, deployment, public release or additional spend is permitted. No I4 or later package is authorized by this record.

## 5. Owner decision required to unblock I3

Choose one:

- **Option A — Extend I3 narrowly:** authorize a minimal additive, human-governed provider-category assignment/resolution mechanism for directory entities, with no UI, external source access, automated inference or public projection. The exact data model and actor/audit controls must be documented before implementation.
- **Option B — Keep I3 strictly within its current D5 boundary:** defer provider-category-dependent field proposals until M3-04 provides an authoritative category assignment source. I3 may proceed only for definitions whose applicability can be safely proven without a provider category, if D1/D3 explicitly permit that restricted mode; otherwise the package remains blocked.

No provider category will be trusted from request payloads under either option.

## 6. Validation status

This is a repository-inspection and documentation-only preflight record. It does not claim I3 implementation or test completion. The draft PR's documentation and PHP foundation workflows must pass on its exact head before this preflight record is considered complete.
