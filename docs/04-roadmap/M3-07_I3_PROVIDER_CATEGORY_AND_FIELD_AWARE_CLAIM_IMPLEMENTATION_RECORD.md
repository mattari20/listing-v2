# M3-07 I3 — Governed Provider Category and Field-Aware Claim Integration

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Base:** `f767bcb8f8b5e55a4d80225ce05c4f3842d8295d`  
**Authorization:** Owner approved Option A in chat on 2026-11-14.  
**Status:** Implementation candidate on a feature branch; pending exact-head CI and review.

## 1. Bounded authorization and scope

Option A authorizes a narrow additive, human-governed provider-category assignment/resolution mechanism so I3 can prove field applicability without trusting request payloads or inferring from names.

Included:
- a single current provider-category assignment per institution entity;
- human-only assignment capability and audit history;
- an initial controlled vocabulary limited to D4's four synthetic pilot categories: `private_school`, `college`, `academy`, `university`;
- institution-entity and `institution`-scope proposals only; campus, delivery-site and programme scopes remain excluded;
- exact field-definition-version binding on new registry-managed claim versions;
- typed, privacy, scope, entity-type, provider-category, evidence and source-processing validation;
- a single field-aware proposal service and generic claim-registration bypass guard;
- atomic claim/version/evidence/editorial submission/audit/outbox persistence;
- synthetic-only tests and local/CI migration validation.

Excluded:
- taxonomy administration UI or any public/admin route;
- automated category inference, external source access, AI/agent adapters or source crawling;
- category assignment for non-institution entities or inherited category rules;
- definition governance/approval/activation (I4);
- correction/withdrawal/profile projection (I5);
- search, filters, public read paths, deployment, production/V1/Hostinger access, real institution/student data, additional spend or external APIs/connectors/schedulers.

The four-category pilot vocabulary is intentionally not an exhaustive Pakistan taxonomy. Adding public/community school variants, technical/vocational, early-learning, professional, online/distance, madrasah or other categories requires a separately reviewed taxonomy change. Category is not evidence of registration, recognition, accreditation, legal status or quality.

## 2. Provider-category assignment model

Migration `2026_11_14_000008_add_provider_category_assignments_and_claim_field_binding.php` adds `directory_provider_category_assignments` with one current row per institution entity. The row records category, assigning human actor, reason, idempotency key/fingerprint and assignment timestamp.

Each assignment or reclassification also writes a `provider_category_assigned` audit event containing the prior category and new category. The audit log preserves transition history while the assignment table remains the authoritative current lookup.

`ProviderCategoryAssignmentService`:
- requires actor class `human` and capability `assign_provider_category`;
- rejects unknown categories and non-institution subjects;
- requires a reason code and idempotency key;
- serializes assignment against the institution entity row;
- returns idempotently for an identical command and rejects key reuse with a different command.

`FieldDefinitionRegistryReader::providerCategoryForEntity()` resolves only the persisted current assignment. It returns null when no governed assignment exists. It never reads category from the request or institution label.

## 3. Field-aware proposal path

`FieldAwareClaimProposalService` is the only new path for registry-managed claims. It requires a human actor with both `propose_field_value` and `submit_directory_proposal`. This initial I3 path accepts institution entities and `institution` scope only; campus, delivery-site and programme scopes require a later bounded package.

Before writing, it:
1. validates the canonical I2 lowercase snake_case field key;
2. resolves the exact requested immutable definition version and requires active/effective status;
3. resolves entity type and provider category from governed database records;
4. loads the explicit entity-type and provider-category allowlists;
5. validates typed value, cardinality, scope, privacy, locale and freshness using I2;
6. validates validity dates, bounded unique evidence references and each evidence source's processing authorization;
7. enforces the field's accepted evidence-reference kinds when configured.

The transaction then creates the claim, proposed claim version with `field_definition_version_id`, evidence links, editorial review case, audit event and identifier-only outbox event. The existing editorial review lifecycle is entered and the command stops. It does not adjudicate, publish, project or materialize the claim.

The proposal transaction re-locks the institution and current category assignment, then rechecks exact definition applicability before inserting. The outbox worker also verifies aggregate type, payload claim-version identity, proposed disposition, exact definition binding and submitted editorial-case status before marking the event processed. Existing claim versions remain nullable/unbound; there is no backfill.

## 4. Generic bypass prevention

`GovernanceCommandService::registerProposedClaim()` now rejects any predicate that matches a registered field key. It also rejects predicates outside the finite legacy compatibility allowlist, currently `display_name`, preserving the existing synthetic legacy test path while preventing arbitrary new predicates.

This allowlist is intentionally minimal. Any additional legacy predicate must be justified by a reviewed existing caller and added through a separate bounded change; it must not become an extensible dynamic-field path.

## 5. Outbox behavior

The new event type `field_claim.proposal.submitted` contains only the claim-version ID, exact definition-version ID and editorial review case ID. The existing worker verifies that the proposed claim version remains proposed, retains its field binding and has the matching editorial review case. The handler performs no adjudication, publication, projection or external notification. It then marks the integrity-checked event processed using the existing lease protocol.

## 6. Tests added/updated

- `ProviderCategoryAssignmentTest`: no inference, human capability, category allowlist, institution-only assignment, idempotency, reassignment and audit history.
- `FieldAwareClaimProposalTest`: exact binding, evidence and editorial submission, category mismatch, missing category, inactive definition, scope mismatch, invalid typed value/date, source-processing denial, synthetic-only source enforcement, generic bypass rejection, outbox integrity processing and idempotent retry.
- `FieldDefinitionRegistryReaderTest`: updated for the additive I3 claim-version binding and exercises I1 rollback only after temporarily removing I3's dependent schema in the disposable test database.

All fixtures are synthetic. The migration is additive; its down path is only exercised in disposable CI/test databases. It must never be run against a shared or production database.

## 7. Known design constraints

- I1 contains legacy dotted field-key fixtures. I2's canonical validator rejects dotted keys; I3 therefore accepts only canonical snake_case keys and does not alias or normalize dotted keys. Existing dotted fixtures are not eligible for I3 proposals.
- The provider category is a human-governed classification, not a verified legal/recognition status.
- The assignment table stores the current category; immutable transitions are recorded in `audit_events`. I4 is not part of this work.
- The proposal outbox event is intentionally a no-op integrity checkpoint. No downstream automation is activated.

## 8. Acceptance gates

Do not merge until:
- exact-head PHP 8.5 foundation CI and documentation validation pass;
- focused I3 tests and the full synthetic suite pass;
- migration up/down behavior is demonstrated only in disposable test databases;
- generic registration tests prove registry and unknown predicates cannot bypass the field-aware path;
- exact-head PR diff and repository state are reviewed;
- no production, V1, Hostinger, deployment, external API/AI, real data or spend activity has occurred.

I3 completion does not authorize I4 or any later package.
