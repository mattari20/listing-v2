# M3-12 Agenda 02 — Database Foundation Verification

**Prepared:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Immutable review baseline:** b685bf75895b68180b4e0b8e4808183c8ee722eb  
**Review type:** Read-only database configuration, migration and synthetic-test evidence review  
**Status:** LOCAL/CI SQLITE FOUNDATION VERIFIED BY EXISTING SYNTHETIC TEST EVIDENCE; MYSQL/HOSTED DATABASE ACCEPTANCE NOT ESTABLISHED.

## 1. Purpose and safety boundary

This agenda verifies the repository's existing database foundation and migration evidence. It does not create a database, execute a migration in this review, connect to MySQL, inspect credentials, access Hostinger/hPanel, or touch V1/production/shared data. The only migration lifecycle evidence relied on is the existing automated test that creates and deletes a disposable temporary SQLite file within the synthetic test suite.

## 2. Configuration findings

- config/database.php defaults to SQLite and defaults the SQLite database to :memory:.
- The SQLite connection enables foreign-key constraints and defines a bounded busy timeout.
- A MySQL connection template exists with environment-driven host, port, database, username and password; it uses utf8mb4 and strict mode.
- The presence of MySQL configuration is not proof of a successful MySQL connection, migration compatibility on a live MySQL version, TLS configuration, hosted permissions or V2/V1 isolation.
- FoundationEnvironmentDefaultsTest verifies the test environment uses SQLite in memory, array cache/session/mail, sync queue and local filesystem defaults with debug disabled.
- SubfolderDatabaseConfigurationTest verifies the SQLite defaults and a wholly synthetic MySQL configuration plus a synthetic subfolder session-cookie setting. It does not open a MySQL connection.

## 3. Migration inventory

The pinned tree contains 15 ordered migration files and 51 Schema::create table definitions. They cover:

1. Core directory entities, relationships, source authorizations, evidence references, claims, claim versions, claim/evidence links and audit events.
2. Adjudication and publication workflows, immutable snapshots, public projections, outbox, suppressions and restorations.
3. Outbox claim/lease support and persisted conflict/candidate/rollback records.
4. Campus, delivery-site, programme, qualification-link and programme-offer catalogue structures.
5. Authority profiles, editorial review and directory status history.
6. Versioned field definitions, entity/provider-category bindings and field-definition review workflows.
7. Identity, role assignments and privileged-action audit records.
8. Synthetic moderation case, appeal and event foundations.
9. Programme-offer fact freshness, versioning, evidence, adjudication, publication, projection and suppression structures.
10. Account-owned saved directory items.

The schema uses UUID-based domain identifiers, foreign-key relationships, restrictive deletion for important evidence/claim/publication lineage, explicit cascade/null behavior for selected account relationships, uniqueness constraints for identities/version/idempotency, and indexes for common state/time/lookup paths. The schema is not represented as a final production-optimized design; query-plan and representative load evidence are outside this agenda.

## 4. Existing synthetic database test evidence

| Test | What it verifies | What it does not prove |
|---|---|---|
| I7DisposableSqliteMigrationTest | Runs all 15 migrations on a temporary disposable SQLite file; checks 26 named core tables, empty PRAGMA foreign_key_check, independent connections, unique outbox idempotency, SQLite writer contention, full rollback and clean re-migration | MySQL migration compatibility, hosted database behavior, backup/restore or production isolation |
| CoreGovernancePersistenceTest | Core tables, invalid relationship endpoint rejection, separation of source authorization and evidence metadata, claim-version supersession and audit-event persistence | Real-source rights, external data correctness or live database controls |
| PersistedGovernanceWorkflowTest | Persisted adjudication/appeal lineage, publication snapshots, outbox projection idempotency and related governance contracts | Staffed human review operations or production availability |
| ProgrammeOfferFactWorkflowTest | Offer-scoped fact publication, cycle boundaries, evidence/adjudication workflow and preservation of a zero-valued fee | Real fee accuracy or external institution verification |
| AccountSavedItemsTest | Guest denial, account ownership isolation, idempotent save/remove and private/noindex response behavior | Production identity provider, email verification or real-user operations |
| PrivatePreviewDirectorySeederTest and preview access tests | Synthetic preview data behavior, idempotence and fail-closed environment/database guards | Permission to seed any shared or hosted database |
| ModerationPrivacyBoundaryTest | Synthetic moderation schema/workflow privacy boundaries | Public moderation activation or staffed appeals |

The exact PR #349 head cb9783ecef734ff3560d84e7871eee0c817fcdf0 passed PHP 8.5 foundation CI run #690, including the synthetic-only test suite, and project documentation validation. The new review records are documentation-only and will receive their own fresh exact-head CI before merge.

## 5. Findings and disposition

- **DB-01 — Local/CI safe default: PASS.** SQLite in-memory is the configured default and is asserted by the environment-default test.
- **DB-02 — Migration lifecycle: PASS for disposable SQLite.** The full migration sequence, rollback and re-install are exercised against a temporary test file, not a persistent/shared database.
- **DB-03 — Referential integrity/idempotency: PASS for tested SQLite contracts.** Foreign-key checks, invalid relationship rejection, uniqueness and outbox idempotency are covered.
- **DB-04 — Synthetic preview boundary: PASS for tested guards.** Preview seeders require local/testing and SQLite; the stricter local preview seeder additionally requires its dedicated filename and explicit opt-in. These guards do not authorize hosted seeding.
- **DB-05 — MySQL configuration: PARTIAL.** A configurable connection template and synthetic configuration test exist, but no MySQL server connection or full MySQL migration suite has been run in this agenda.
- **DB-06 — Hosted V2 database separation/security: NOT VERIFIED / BLOCKED.** Resource ownership, database grants, credentials, network restrictions, TLS, backups, restore, retention and V2/V1 isolation require a separately authorized environment and qualified human verification.
- **DB-07 — Production performance/recovery: NOT VERIFIED.** No representative query-plan/load acceptance, backup/restore rehearsal or measured RPO/RTO is claimed.

**Overall result:** LOCAL/CI SQLITE DATABASE FOUNDATION VERIFIED WITH SYNTHETIC TEST EVIDENCE; MYSQL AND HOSTED DATABASE READINESS REMAIN PARTIAL/BLOCKED. No database changes are required to close this repository-only verification agenda.

## 6. Required follow-through

- Keep SQLite in-memory as the local/CI default.
- Preserve the disposable SQLite migration lifecycle test and synthetic-only preview seeder guards.
- Do not claim MySQL compatibility beyond the configuration-level evidence until a separately authorized, disposable V2-only MySQL validation target exists.
- Do not run hosted migrations, create/access backups, restore, inspect production grants or credentials, or alter hosting/database resources under this agenda.

## 7. Explicit exclusions

No database provisioning, connection, credentials, schema change, migration execution outside the existing CI test, seeding, backup/restore, production/Hostinger/hPanel/V1 access, real/source/personal data, external service/AI, deployment, vendor/dependency or spend.

**Agenda 02 disposition:** Database foundation verification COMPLETE for the existing local/CI SQLite evidence. MySQL live validation and hosted isolation remain outside scope and not accepted.
