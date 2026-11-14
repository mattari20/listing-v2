# M3-07 D5 — Implementation Readiness and Bounded Authorization Proposal

**Date:** 2026-11-14  
**Repository:** mattari20/listing-v2  
**Depends on:** D1 Field Registry Contract; D2 Field Registry Storage Decision; D3 Field-Aware Claim Service Boundary; D4 Synthetic Extensible-Institution Pilot Specification; current M3-03/M3-04 implementation  
**Status:** Readiness proposal only. No application implementation, schema change, migration or database operation is authorized by this document.

## 1. Decision requested

D5 recommends a staged, local/CI-only implementation, beginning with one deliberately narrow package:

**I1 — Field Registry Persistence and Immutable Read Path.**

I1 creates the minimum normalized registry persistence and a read-only application boundary for resolving field definitions and applicability. It does not yet accept institution field values, write claims, change public profiles/search, or run an agent. This separates the highest-risk claim lifecycle integration from the initial storage foundation and makes the registry contract testable before it can affect institution records.

A separate explicit owner authorization is required before I1 starts. This D5 document is not that authorization. Any later I2+ package requires its own scope review and approval.

## 2. Implementation principles

1. Reuse the existing claims, claim versions, evidence, source authorization, adjudication, publication, suppression, restoration and audit lifecycles.
2. Do not create a second EAV/value store or a column for every optional institution field.
3. Keep field definitions separate from institution facts.
4. Make approved definition versions immutable and bind future registry-managed claim versions to the exact definition version.
5. Keep the first package read-only at the application-service level after migration/fixture setup.
6. Use only synthetic fixture definitions and deterministic local/CI tests.
7. Preserve all existing M3-03/M3-04 behavior and legacy records; do not infer/backfill registry bindings.
8. Fail closed for unknown or malformed field definitions and applicability.
9. No new dependencies, paid services, external APIs, AI/model calls, connectors, schedulers or additional infrastructure.
10. No production, V1, Hostinger/hPanel or live database access.

## 3. Proposed staged delivery

| Package | Scope | Write capability | Gate |
|---|---|---|---|
| I1 — Registry persistence and immutable read path | Normalized definition/version/applicability persistence, constraints, repository/reader, synthetic seed fixtures | Schema migration and test-fixture setup only; application read-only | Separate bounded authorization |
| I2 — Typed validation and applicability | Pure validators for type, cardinality, entity/provider scope, locale, units, date/freshness and privacy | No claim writes | I1 accepted; separate package authorization |
| I3 — Field-aware proposal and bypass guard | Single field-aware proposal path, exact definition binding, generic registration bypass prevention, atomic claim/evidence/audit/outbox | Proposed synthetic claim writes in local/CI only | I1/I2 accepted; separate package authorization |
| I4 — Definition governance lifecycle | Definition review cases/decisions, independent human approval and activation/retirement | Definition lifecycle writes in local/CI only | Capability and separation-of-duties review |
| I5 — Value correction/withdrawal/profile integration | Governed value lifecycle and allowlisted profile projection | Synthetic claim lifecycle and projection changes | Existing workflow compatibility proven |
| I6 — Synthetic agent proposal adapter | Deterministic fake adapter with proposal-only capability | Synthetic proposals only | All preceding packages accepted; no external model |
| I7 — Full regression and hardening | Adversarial, concurrency, migration, rollback, privacy, performance and regression suite | Test-only | Exact-head acceptance review |

No package automatically authorizes the next package. I1 must not expand into I2-I7 during implementation.

## 4. I1 exact scope

### 4.1 New persistence objects

Subject to exact repository/schema inspection before implementation, I1 may add only:

- **field_definitions:** stable immutable field identity and unique field key;
- **field_definition_versions:** versioned definition metadata, lifecycle state, bounded validation/presentation/evidence/freshness metadata and effective dates;
- **field_definition_version_entity_types:** normalized entity-type applicability;
- **field_definition_version_provider_categories:** normalized provider-category applicability.

Use the exact columns, constraints and invariants from the approved D2 decision after reconciling them against current repository conventions. Do not silently add review/decision tables in I1; those belong to I4 after capability design.

**Do not add the D2 proposed nullable foreign key to claim_versions in I1.** No claim-value write path is being implemented yet. The binding migration belongs with I3, when the exact field-aware write contract and generic bypass guard can be delivered atomically. This reduces the risk of a partially enforced registry.

### 4.2 New application responsibilities

I1 may add only the minimum components needed to:

- load a field definition by immutable field key and exact version;
- list/read its lifecycle and effective state without mutation;
- resolve explicit entity-type/provider-category applicability;
- return a typed, safe result or a stable not-found/inactive/inapplicable reason;
- expose no source content, private values or arbitrary dynamic SQL.

Proposed names (final names must follow repository conventions):

- **FieldDefinitionRegistryReader**;
- **FieldDefinitionRepository**;
- **FieldApplicabilityReader** or an equivalent pure policy.

Do not create a public/admin controller, CRUD UI, dynamic profile editor, public API route, background job or agent command in I1.

### 4.3 Synthetic fixtures

Seed only reserved synthetic definitions for D4's fictional provider categories and a small subset of fields needed to prove versioning and applicability. Mark all fixtures synthetic and load them only into disposable test databases or test factories. Do not seed live institutions or use real source URLs, contacts, addresses or authority names.

I1 must include:
- one active version;
- one proposed/inactive version;
- one retired definition version;
- one field applicable to all four pilot categories;
- one school-only field;
- one campus-scoped field;
- one internal-only field.

The fixtures are test inputs, not production catalogue content.

## 5. Explicit file and touch-point boundary

The implementation branch must begin from the then-current verified main head, not from a stale PR head. Before editing, inspect and record the actual repository paths and current contents for:

- migration conventions and latest migration timestamp/ordering;
- model/repository/service namespaces and autoload rules;
- entity/provider category representation in M3-04;
- current schema/table names and database portability constraints;
- existing governance policy and test fixture conventions;
- Composer/PHP version constraints and CI commands.

No assumed path or class name in this proposal overrides the actual repository structure.

Expected new-file categories only:

1. one or more additive migration files for the four I1 registry tables;
2. registry definition/version model or persistence mapping, only if consistent with current architecture;
3. repository/reader and applicability read policy;
4. synthetic factory/fixture definitions;
5. focused unit/integration tests;
6. a short implementation note recording schema and rollback behavior.

Existing files may be modified only where strictly necessary for dependency registration, model conventions or test bootstrapping. Every modified existing file must be listed and justified before the change. Do not edit existing migrations.

I1 must not modify:
- existing claim registration or governance write services;
- claim_versions schema or claim value data;
- publication snapshots, public routes, directory search/facets or profile rendering;
- provider identity, campus/programme catalogue or existing M3-03/M3-04 behavior;
- source authorization manifests or production configuration;
- deployment, Hostinger, V1 or environment files.

If implementation requires any excluded touch point, stop and propose a revised package for approval rather than expanding scope.

## 6. Migration and rollback strategy

### 6.1 Preflight

Before writing a migration, record:

- exact base main SHA;
- clean worktree and branch;
- current migration inventory and ordering;
- supported test database drivers and versions;
- current table/column/index naming conventions;
- whether foreign-key constraints and JSON columns are portable in supported test environments;
- existing provider/entity category identifiers and referential integrity.

No production database or Hostinger connection is permitted for this preflight.

### 6.2 Migration requirements

- Add new tables only; do not rewrite or squash historical migrations.
- Use database-enforced unique constraints for field key and (field identity, version number).
- Use foreign keys for definition identity and applicability references where supported by the project's portability baseline.
- Bound metadata JSON size/depth at application validation and keep schema semantics versioned.
- Include explicit indexes for field key, definition version, lifecycle/effective state and applicability lookups.
- Avoid vendor-specific JSON indexes as a correctness dependency.
- Avoid destructive down migrations.
- Do not insert any real or production field definitions.

### 6.3 Rollback and data safety

I1 is intended for disposable local/CI databases only.

- Before any migration test, use a disposable database created by the test harness.
- Verify migration up, fresh install, repeated test bootstrap and the documented down behavior where safe.
- A down migration may drop only I1-owned tables in a disposable database after confirming no dependent records exist.
- If any non-test environment has been populated, do not automatically drop tables or data. Stop and use a separately reviewed forward migration/repair plan.
- Never run destructive reset/rollback/truncate commands against a shared, staging, production or Hostinger database.
- Do not claim rollback safety merely because a down method exists; demonstrate it against disposable CI fixtures.
- Preserve the exact migration logs and schema assertions as CI evidence.

I1 contains no claim data, so rollback is simpler than later I3+ packages. Later packages that bind or write claim versions must define their own forward-recovery strategy and must not delete historical evidence/claims on rollback.

## 7. Test strategy and commands

Use the repository's existing scripts and CI workflow after confirming them on the target branch. Do not invent a new test command or modify Composer scripts solely for convenience.

Minimum I1 tests:

1. field key uniqueness;
2. immutable identity key behavior;
3. unique version number per field;
4. definition version lookup by key + exact version;
5. no implicit selection of a newer version when an exact version is requested;
6. proposed/inactive/retired versions are not treated as active;
7. effective-from/effective-to boundaries use a fixed test clock;
8. entity-type applicability allow and deny;
9. provider-category applicability allow and deny;
10. school-only field rejects college/academy/university;
11. campus scope cannot be treated as institution scope;
12. internal-only metadata never becomes public output;
13. malformed/oversized metadata rejected;
14. unknown field and unknown category fail closed;
15. synthetic fixtures contain no live URLs or real personal data;
16. migration from empty disposable database;
17. migration with pre-existing synthetic M3-03 claims remains non-destructive and leaves claim schema/data unchanged;
18. migration up/down on disposable database only;
19. existing M3-03/M3-04 test suites remain green;
20. no network/API/model/connector/scheduler calls occur.

Run focused tests first, then the full existing synthetic suite, PHP formatting/static checks, Laravel bootstrap/routes validation, documentation validation and artifact hygiene exactly as defined by repository CI. Capture command, environment, exact commit and result for every check.

## 8. I1 acceptance gates

I1 may be considered accepted only when all are true:

- **I1-AC-01:** exact approved schema shape is implemented additively with no edits to historical migrations.
- **I1-AC-02:** field identity and definition-version uniqueness are enforced by the database.
- **I1-AC-03:** approved definition versions cannot be silently mutated.
- **I1-AC-04:** exact-version reads never drift to the latest definition.
- **I1-AC-05:** entity/provider applicability is explicit and fail-closed.
- **I1-AC-06:** no claim, claim version, evidence, publication or public projection is written or changed by I1.
- **I1-AC-07:** no claim_versions binding or generic claim-registration change is made in I1.
- **I1-AC-08:** synthetic fixture data only; no real source, institution or personal data.
- **I1-AC-09:** migration tests are disposable and demonstrate safe rollback boundaries.
- **I1-AC-10:** existing M3-03/M3-04 and repository CI remain green on the exact PR head.
- **I1-AC-11:** no external network/API/model/connector/scheduler, production or Hostinger operation.
- **I1-AC-12:** exact-head documentation validation and PHP 8.5 foundation CI both pass.
- **I1-AC-13:** PR diff contains only approved I1 paths and documented justifications.
- **I1-AC-14:** implementation report records base/head SHA, files, migration IDs, tests, CI run IDs and any deviations.

Any failed acceptance gate blocks merge and blocks I2.

## 9. Required stop conditions

Stop immediately and seek owner approval if:

- current repository architecture differs materially from D1-D4 assumptions;
- a migration would require rewriting existing schema/data or guessing a backfill;
- a claim write or public projection change is needed to make I1 appear functional;
- existing legacy predicates cannot be safely classified without broad refactoring;
- tests require a live database, real institution/source data or external services;
- a dependency upgrade, new service, paid feature or new spend appears necessary;
- a change touches production, V1, Hostinger/hPanel, deployment or public release;
- a security/privacy review identifies a new prohibited data class or source-processing requirement.

Do not resolve a stop condition by broadening scope, weakening controls or silently changing D1-D4.

## 10. Owner authorization template for I1

The following is a proposed decision record. It must be explicitly accepted by the owner before implementation. Silence, a general request to continue the roadmap or approval of this D5 design is not sufficient.

**Proposed authorization statement:**

> I authorize only I1 — Field Registry Persistence and Immutable Read Path — on a new branch from the then-current verified main in mattari20/listing-v2, limited to the four registry persistence tables, read-only definition/applicability reader, synthetic fixtures and I1 tests described in D5. I authorize additive migrations only in disposable local/CI databases. I do not authorize claim writes, claim schema binding, generic claim-service changes, definition review/activation UI, public profile/search changes, agent implementation, source access, external APIs/models/connectors/schedulers, production/V1/Hostinger access, deployment, new spend or scope expansion. Any deviation requires a new explicit approval.

If accepted, record the authorization date, exact D5 revision, authorized branch/base SHA and scope in a separate implementation authorization record before code changes.

## 11. Binding safety and status

D5 is a readiness and authorization proposal only. No code, schema, migration, UI, database, production operation, source access, external API/model/connector/scheduler, procurement, deployment or additional spend has been performed or authorized.

G2-G9 remain blocking for real source access and live agent activation. Human review, adjudication and publication remain mandatory. M3-07 is not complete until its approved implementation, synthetic evaluation and separate governance/activation gates are addressed; D5 does not declare the milestone complete.
