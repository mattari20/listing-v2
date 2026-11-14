# M3-07 I1 — Field Registry Persistence and Immutable Read Path

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Branch:** `feature/m3-07-i1-field-registry`  
**Base main SHA:** `87d0a5ca3a34b8f46a5027c02a678198f143eabe`  
**Authorization:** Explicit Product Owner authorization received 2026-11-14 in the conversation; limited to I1 exactly as proposed in D5.  
**D5 source revision:** `a3cbd8ef19d932b4dd21a8d6cdb0925be22bc9bc`  
**Status:** Implementation candidate; acceptance pending exact-head CI and review.

## 1. Authorized scope

This branch implements only:
- four additive field-registry persistence tables;
- a read-only exact-definition-version and applicability reader;
- synthetic-only feature tests for persistence, exact version selection, lifecycle/effective dates, explicit applicability, scope, privacy metadata, non-mutation and disposable migration down/up behavior.

No claim writes, claim schema binding, generic claim-service changes, definition review/activation UI, public profile/search changes, agent implementation, source access, external APIs/models/connectors/schedulers, production/V1/Hostinger access, deployment, new spend or scope expansion is included.

PR #197 remains a separate documentation/design PR and is not merged or modified by this implementation branch.

## 2. Verified repository preflight

The branch was created from verified `main` SHA `87d0a5ca3a34b8f46a5027c02a678198f143eabe`.

Read-only inspection confirmed:
- Laravel 13 / PHP foundation and Composer PSR-4 autoload for `App\\ => app/`;
- SQLite `:memory:` test configuration with foreign keys enabled;
- migration inventory through `2026_11_14_000006_create_editorial_review_and_status_history.php`;
- existing stable identity and governance tables: `directory_entities`, `claims`, `claim_versions`, evidence and audit tables;
- existing directory entity types include `institution`, `campus`, `delivery_site`, `programme`, `qualification`, `authority` and other controlled types;
- existing provider/campus/governance services use the `App\\Services\\Directory` and `App\\Services\\Governance` namespaces.

The I1 migration is therefore ordered as `2026_11_14_000007`. No existing migration is edited.

## 3. Physical schema

The additive migration creates exactly:
1. `field_definitions` — stable UUID identity and unique immutable field key.
2. `field_definition_versions` — immutable version identity, lifecycle/effective metadata, type/cardinality/scope/privacy/visibility/search flags and bounded JSON policy metadata.
3. `field_definition_version_entity_types` — normalized explicit entity-type applicability.
4. `field_definition_version_provider_categories` — normalized explicit provider-category applicability.

Database constraints cover unique field keys, unique version numbers per field, foreign-key integrity and duplicate applicability rows. Indexes support lifecycle/effective and applicability reads.

The migration does not alter `claims`, `claim_versions`, evidence, adjudication, publication, audit, outbox, provider entities or public projections. In particular, it does not add the proposed future `claim_versions.field_definition_version_id` binding; D5 assigns that to I3 with the field-aware write path and bypass guard.

## 4. Read path

`FieldDefinitionRegistryReader` provides:
- exact field-key + version lookup;
- ordered version listing for one field key;
- fail-closed applicability resolution using exact entity type and provider category;
- active-state and effective-time checks, with inclusive `effective_from` and exclusive `effective_to` boundaries;
- stable denial reasons for missing, inactive, not-yet-effective, expired and inapplicable definitions.

The reader exposes definition metadata only. It has no write methods, does not create or mutate definitions, does not read institution claim values, and does not create public/search output. Applicability is explicit; no inheritance or inference is performed.

## 5. Synthetic test coverage

The I1 feature tests cover:
- exact-version lookup without latest-version fallback;
- field-key and per-field version uniqueness;
- proposed/retired/inactive and effective-time rejection;
- effective boundary behavior;
- entity-type and provider-category allow/deny behavior;
- explicit applicability across the four D4 pilot categories;
- school-only and campus-only applicability without implicit inheritance;
- internal-only metadata with no value payload;
- unchanged pre-existing synthetic claim and claim-version rows, and absence of claim-version binding;
- down/up of only the four I1-owned tables in the disposable SQLite test database.

All records use synthetic identifiers and metadata. No live institution, person, source URL, address, contact or student data is used.

## 6. Specification reconciliation note

D1 recommends lowercase ASCII snake_case field keys, while D4's illustrative pilot catalogue uses dotted keys such as `institution.display_name`. I1 stores the key as an opaque unique string and deliberately does not implement key-format validation or field-definition creation. This inconsistency must be resolved before I2 introduces typed definition validation; it does not justify silently choosing one convention in I1.

Provider-category values are stored as explicit taxonomy strings because the inspected main schema has no separate governed provider-category registry to reference. No category is inferred from entity labels, names or recognition status.

## 7. Validation and remaining gates

The required exact-head PHP 8.5 foundation CI and project documentation validation must pass before I1 can be accepted. The CI result, exact PR head, review state and final diff must be recorded in this file after those checks complete.

I1 is not accepted and must not be merged if any acceptance criterion fails. I2 remains unauthorized until separate owner approval.

## 8. Safety statement

Only repository-local implementation and disposable local/CI test databases are in scope. No production, V1, Hostinger, hPanel, live database, source website, real data, external service, model, connector, scheduler, deployment or additional spend was accessed or used. No live data was collected or changed.
