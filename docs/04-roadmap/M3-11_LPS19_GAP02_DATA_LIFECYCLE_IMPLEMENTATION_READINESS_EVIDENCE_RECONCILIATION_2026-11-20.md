# M3-11 LPS-19 — GAP-02 Data Lifecycle Implementation-Readiness and Evidence Reconciliation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `892d1ab7c2250560d80bea1117928968045dd683` (main after LPS-18 / PR #376)  
**Agenda:** LPS-19 — GAP-02 repository evidence reconciliation and implementation-readiness assessment  
**Work type:** Repository-only inspection of current-main code, migrations, configuration and tests; synthetic-only evidence  
**Status:** **RECONCILIATION COMPLETE — PARTIAL REPOSITORY CONTROLS CONFIRMED; FULL LIFECYCLE INVENTORY AND RETENTION/DELETION ACCEPTANCE REMAIN OPEN**

## 1. Purpose and boundary

LPS-19 updates the initial LPS-14 repository evidence map using the current `main` tree. It identifies data-bearing schema and code surfaces, distinguishes implemented bounded controls from configuration options and unknown operational surfaces, and converts remaining uncertainty into a prioritized evidence backlog.

This is not a complete data inventory, privacy impact assessment, legal opinion, retention schedule approval, deletion certification, processor inventory or hosted-runtime assessment. Repository configuration is not proof of effective runtime configuration. Migration declarations are not proof that a migration has been applied to any database. Tests are not proof of deployed behavior.

**Restrictions retained:** synthetic/fictional fixtures only; no V1/production/Hostinger/hPanel/hosted access; no live database, migrations, backup inspection, restore or deletion action; no real institute/source/student/child/guardian/personal data; no source contact/access/collection/copying/scraping/crawling/ingestion; no external API, AI/model/provider, crawler or live agent; no public complaint/UGC/review/rating/appeal activation; no deployment, pilot, release candidate or participant activity; no new dependency, paid service, hosting upgrade or additional spend. Deeni Madaris remains default-OFF/zero exposure in the current private acceptance scope.

## 2. Inspection method and evidence standard

- Inspected the current `main` Git tree at baseline `892d1ab7c2250560d80bea1117928968045dd683`.
- Enumerated repository migration files and extracted explicit `Schema::create` declarations.
- Inspected selected schema migrations, models, logging implementation, retention tests, privacy-boundary tests, and Laravel database/session/cache/queue/filesystem/logging configuration.
- Inspected `routes/console.php` for repository-defined console scheduling/commands in that file.
- Did not execute application code against any live or hosted system, query a database, inspect runtime environment variables, inspect secrets, inspect storage contents or access backup artifacts.

Evidence labels:
- **CONFIRMED-REPOSITORY:** directly visible in current repository code/config/migration/test.
- **PARTIAL:** a bounded implementation exists but does not cover the complete lifecycle.
- **DOCUMENTED-DESIGN:** requirement or intended behavior exists in documentation only.
- **UNKNOWN-UNINSPECTED:** repository inspection does not establish existence, location or behavior.
- **EXTERNAL-REVIEW-REQUIRED:** requires authorized hosted/operational observation or qualified human review.
- **NOT-APPLICABLE-JUSTIFIED:** only when exact scope and rationale support it; not used to bypass unknowns.

## 3. Current repository inventory findings

### 3.1 Schema inventory

The current repository contains **15 migration files** with **51 explicit `Schema::create` declarations**. This is a count of create-table declarations in repository migrations only—not a count of live database tables, applied migrations, all storage surfaces or a complete deployed schema.

The declared tables group into these data domains:

| Domain | Declared tables |
|---|---|
| Core directory, source and claim provenance | `directory_entities`, `entity_relationships`, `source_authorizations`, `evidence_references`, `claims`, `claim_versions`, `claim_evidence_links`, `audit_events` |
| Adjudication and publication | `adjudication_cases`, `adjudication_decisions`, `publication_decisions`, `publication_snapshots`, `public_projections`, `governance_outbox`, `publication_suppressions`, `publication_restorations` |
| Conflicts and rollback | `claim_conflicts`, `claim_conflict_candidates`, `publication_rollbacks` |
| Campus and programme catalogue | `directory_campuses`, `directory_delivery_sites`, `programme_catalogue_entries`, `programme_qualification_links`, `programme_offers` |
| Authority and editorial history | `authority_profiles`, `editorial_review_cases`, `directory_status_history` |
| Field-definition registry and review | `field_definitions`, `field_definition_versions`, `field_definition_version_entity_types`, `field_definition_version_provider_categories`, `field_definition_review_cases`, `field_definition_review_decisions` |
| Provider categorization | `directory_provider_category_assignments` |
| Identity and privileged access | `users`, `role_assignments`, `privileged_action_audits` |
| Synthetic moderation workflow | `moderation_cases`, `moderation_appeals`, `moderation_events` |
| Programme-offer facts and publication | `programme_offer_fact_freshness_policies`, `programme_offer_facts`, `programme_offer_fact_versions`, `programme_offer_fact_evidence_links`, `programme_offer_fact_adjudication_cases`, `programme_offer_fact_adjudication_decisions`, `programme_offer_fact_publication_decisions`, `programme_offer_fact_publication_snapshots`, `programme_offer_fact_public_projections`, `programme_offer_fact_publication_suppressions` |
| Student saved items | `saved_directory_items` |

This inventory establishes that the repository contains multiple data-bearing workflow domains requiring lifecycle coverage. It does not establish which tables are populated in any runtime, whether all declared migrations are applied, or what real data exists.

### 3.2 Confirmed data-bearing payload and metadata patterns

Current migration/model evidence includes:
- `claim_versions.value`, `publication_snapshots.payload`, `governance_outbox.payload`, `privileged_action_audits.metadata`, and `evidence_references.integrity_digest`;
- adjudication decision `rationale` text and policy/version metadata;
- moderation case/appeal/event reason codes, state transitions and synthetic references;
- user email/password hash and verification/session-related identity fields;
- source authorization purpose/method/territory/scope JSON and validity/revocation fields;
- programme offer fact values, versions, evidence links and publication snapshots;
- saved-item relationships between users and directory entities.

These are data classes and payload locations that must be individually classified. Their actual payload contents, sensitivity, population, retention, access and backup copies are not established by the migration declarations alone. JSON/text fields require explicit payload minimization and schema-level review because their contents may evolve.

### 3.3 Referential deletion behavior

The inspected migrations include a mixture of restrictive and cascading foreign-key behavior:
- core claim/source/evidence relationships use restrictive deletion constraints in several paths;
- user-owned role assignments and saved items include cascade behavior;
- synthetic moderation appeals/events include cascade behavior tied to moderation cases;
- some user references use null-on-delete behavior.

Foreign-key behavior is not a complete deletion policy. Restricting a parent delete can prevent accidental loss but does not define lawful retention or eventual disposal. Cascading a row does not prove deletion of logs, exports, caches, sessions, files, backups or processor-held copies. Each relationship must be assessed against the approved LPS-14 retention and deletion matrix before any real-data operation.

## 4. Repository control evidence matrix

| Surface/control | Current repository evidence | Classification | Lifecycle limitation / required next evidence |
|---|---|---|---|
| Claims and immutable-ish value versions | Core migrations define claims, JSON value versions, supersession and evidence links | CONFIRMED-REPOSITORY / PARTIAL | Retention, correction history, deletion and payload classification not fully mapped |
| Source authorization and evidence references | Source purpose/method/scope, validity/revocation and evidence metadata tables | CONFIRMED-REPOSITORY / PARTIAL | No complete evidence-file/object store map, source-rights lifecycle, retention or deletion proof |
| Publication snapshots/projections | Persisted snapshots, public projections, suppressions and restorations | CONFIRMED-REPOSITORY / PARTIAL | Public/derived copies, cache invalidation, export and backup propagation not fully reconciled |
| Adjudication and audit | Cases, decisions, rationales, audit events, privileged action audits | CONFIRMED-REPOSITORY / PARTIAL | Rationale/metadata payload sensitivity, audit access, retention and deletion remain unapproved |
| Governance outbox | JSON payload, attempts, error text, status and timestamps | CONFIRMED-REPOSITORY / PARTIAL | Payload minimization, error redaction, retry/dead-letter retention and purge behavior not established |
| Identity and role assignments | Users, role scope, expiry/revocation, privileged action audit | CONFIRMED-REPOSITORY / PARTIAL | Session/token lifecycle, user-data requests, access recertification and audit retention incomplete |
| Moderation cases/appeals/events | Synthetic workflow tables with reason/state metadata and no free-text/identity-document columns in inspected test | CONFIRMED-REPOSITORY / PARTIAL | The feature test validates selected schema exclusions, not every data surface, retention or deployed population |
| Saved directory items | User/entity relation with cascade foreign keys | CONFIRMED-REPOSITORY / PARTIAL | Account closure, export, deletion propagation, backup expiry and cache invalidation not proven |
| Rotated application logs | Age-based daily handler and cleaner remove matching rotated files strictly older than 30 days; tests cover matching, symlink and boundary behavior | CONFIRMED-REPOSITORY / PARTIAL | Applies only to matching local rotated files when rotation invokes cleanup; not all logs/messages, hosted logs, provider logs, backups or other data |
| Structured log context | Processor retains bounded `event_code` and `correlation_id` context keys | CONFIRMED-REPOSITORY / PARTIAL | Processor does not sanitize log message text; code must still avoid secrets/personal data in messages |
| Database configuration | Repository config defaults to SQLite and includes MySQL connection configuration | CONFIRMED-REPOSITORY | Environment-specific runtime connection, credentials, host, region and actual deployed database remain UNKNOWN-UNINSPECTED |
| Session configuration | Default file driver and 120-minute idle lifetime; configurable database/cache alternatives and cookie options | CONFIRMED-REPOSITORY / PARTIAL | Actual environment override, session file lifecycle/sweeper behavior, backups and deletion propagation unknown |
| Cache configuration | Default array store; file/database/Redis/Memcached and other configurable stores are defined | CONFIRMED-REPOSITORY / PARTIAL | Actual selected store, keys/payloads, TTLs, hosted cache, invalidation and deletion behavior unknown |
| Queue and failed jobs | Default sync queue; database/Redis/SQS/etc. options and database failed-job configuration are present | CONFIRMED-REPOSITORY / PARTIAL | Runtime driver, actual jobs, payload contents, failed-job retention, queue backend and external provider use unknown |
| Filesystems | Default local disk points to private storage; public local disk and optional S3 disk are configured | CONFIRMED-REPOSITORY / PARTIAL | Actual disk selection, stored objects, public exposure, ACLs, region, retention and deletion unknown |
| Console schedule/cleanup | Inspected `routes/console.php` contains only the Inspire command; no scheduled retention/deletion task is defined there | CONFIRMED-REPOSITORY for inspected file only | Other runtime scheduler/host cron configuration and hosted job execution remain UNKNOWN-UNINSPECTED |
| Temporary files, browser/local downloads, exports, replicas, external processors | No complete surface register established in this repository reconciliation | UNKNOWN-UNINSPECTED / EXTERNAL-REVIEW-REQUIRED | Must be inventoried from exact authorized system/data-flow scope before real-data activity |

### 4.1 Important interpretation

The 30-day cleaner is a specific bounded control, not a global retention policy. It:
- targets daily rotated files matching the configured basename/extension;
- retains files exactly 30 days old and removes only files strictly older than the cutoff;
- skips symlinks and non-matching files;
- is invoked after log rotation by the configured handler.

It does not by itself prove cleanup of current log files, other channels, arbitrary log providers, database audit data, session files, cache entries, queue payloads, exports, backups or external processor logs. The safe-context processor filters structured context only; application log messages must still be authored without secrets or personal information.

### 4.2 Configuration is not runtime evidence

Repository defaults currently show:
- database default: SQLite, with MySQL also configured;
- cache default: array;
- queue default: sync;
- session default: file with a 120-minute idle lifetime;
- filesystem default: local private disk, with a separate public disk and optional S3 disk;
- logging default: daily local file channel with the age-based handler.

These are configuration defaults and available options, not observations of a deployed environment. Environment overrides, scheduled tasks, external provider activation, actual storage contents, access rules and backup behavior remain unverified.

## 5. Updated lifecycle inventory coverage

| Lifecycle stage | Repository evidence | Current result |
|---|---|---|
| Create/receive | Migrations and services establish entity, claim, source, evidence, identity, workflow and saved-item creation surfaces | PARTIAL; all creation routes/jobs and real-world sources not exhaustively mapped |
| Validate/classify | Typed field validation, source authorization and field registry controls identified in LPS-11 and current tree | PARTIAL; payload-level classification and all write paths need reconciliation |
| Store | 51 migration create declarations; local file/session/log config and configurable stores | PARTIAL; runtime and hosted surfaces unknown |
| Use/transform | Claim versioning, adjudication, projections, outbox, catalogue and programme facts | PARTIAL; every derivation/consumer not fully mapped |
| Disclose/export | Public projection/snapshot model and public query service exist | PARTIAL; exports, recipient copies, browser downloads and caches unknown |
| Correct/restrict | Claim versions, conflict/suppression/rollback, editorial and moderation workflows | PARTIAL; full deletion/correction propagation not proven |
| Archive/exception | Version history and audit structures exist | PARTIAL; no complete approved retention/hold schedule |
| Delete/de-identify | Referential cascade/restrict/null rules and one log cleanup implementation | PARTIAL; no complete application-level deletion orchestration or verification evidence |
| Backup expiry/restore | Weekly development backup cadence is recorded as an owner decision | DOCUMENTED-DESIGN / EXTERNAL-REVIEW-REQUIRED; scope, retention, restore and deletion replay unknown |
| Verify/close | Selected synthetic tests for logging and privacy boundaries | PARTIAL; no complete lifecycle end-to-end tests or hosted verification |

## 6. GAP-02 evidence gaps and priority

| ID | Priority | Gap | Required evidence / decision |
|---|---|---|---|
| DLR-01 | P0 | Complete data-class and payload inventory | Field-level map for all declared schema tables, JSON/text payloads, data subjects, sensitivity, purpose and necessity |
| DLR-02 | P0 | Runtime storage and environment mapping | Exact authorized inventory of DB, sessions, cache, queue, filesystem, logs, temporary files, exports, replicas and processors; no hosted access authorized now |
| DLR-03 | P0 | Approved retention schedule | Justified triggers/durations/owners and qualified privacy/legal review; durations remain UNSET until approved |
| DLR-04 | P0 | Deletion/correction propagation | Per-class propagation across primary, derived, audit, log, session, queue, cache, export, file and backup surfaces |
| DLR-05 | P0 | Backup expiry and restore behavior | V2-only backup scope, retention, restore and deletion replay/suppression evidence under separate authorization |
| DLR-06 | P1 | Payload minimization and log/error hygiene | Review JSON/text/rationale/outbox/error fields; test synthetic sensitive-marker exclusion from logs and error payloads |
| DLR-07 | P1 | Scheduled cleanup and operational ownership | Establish which cleanup tasks exist, who owns them, failure alerting, execution evidence and exception handling; do not infer scheduler from code defaults |
| DLR-08 | P1 | End-to-end synthetic lifecycle tests | Create → classify → store → derive → disclose → correct/restrict → delete → verify, including cache/queue/log/export/backup simulation |
| DLR-09 | P1 | Evidence and audit retention policy | Distinguish necessary minimal accountability metadata from duplicate copies of deleted content; set access and expiry |
| DLR-10 | P0 | Qualified privacy assessment | Qualified review of exact data inventory, subjects, purposes, flows, retention, deletion, jurisdiction and processors before real-data activity |

P0 means a prerequisite before the relevant real-data/hosted/operational activity, not permission to begin it. No retention duration or legal basis is approved by LPS-19.

## 7. Bounded repository-only backlog

The following items may be considered in a later separately scoped repository agenda, using synthetic fixtures only:
1. Add a schema-to-data-class inventory worksheet with one row per table and payload field.
2. Add synthetic marker tests to verify that log messages, exception details and outbox error fields do not persist forbidden synthetic markers.
3. Add a code-level inventory of explicit filesystem, cache, queue, session and export call sites.
4. Define a synthetic lifecycle test matrix for claim correction, publication suppression, saved-item removal and derived projection invalidation.
5. Add a retention-policy configuration contract only after an owner-approved retention schedule exists; do not invent defaults.
6. Add a deletion orchestration design only after data classes, dependencies and deletion semantics are approved.

No code implementation is authorized by this reconciliation itself. Any implementation agenda must identify a narrow requirement, synthetic acceptance criteria, exact files and stop conditions; it must not access real data or hosted systems.

## 8. Updated GAP-02 disposition

- [x] Current-main migration inventory enumerated.
- [x] 51 explicit `Schema::create` declarations identified across 15 migration files.
- [x] Major persisted workflow and payload domains classified.
- [x] Database/session/cache/queue/filesystem/logging configuration defaults reconciled.
- [x] Existing 30-day rotated-log cleanup scope and limitations recorded.
- [x] Selected logging and moderation privacy tests reviewed.
- [x] Unknown/uninspected and external/hosted surfaces explicitly retained as unknown.
- [x] Prioritized evidence gaps and bounded synthetic-only backlog recorded.
- [ ] Complete field-level data-class inventory — NOT COMPLETE.
- [ ] Runtime/hosted storage and processor inventory — NOT INSPECTED / NOT AUTHORIZED.
- [ ] Approved retention schedule — NOT RECEIVED.
- [ ] Complete deletion/propagation implementation and tests — NOT ESTABLISHED.
- [ ] Backup expiry, restore and deletion replay evidence — NOT RECEIVED.
- [ ] Qualified privacy/legal review — NOT RECEIVED.
- [ ] GAP-02 closure — NOT ACCEPTED.

**Final disposition:** LPS-19 is COMPLETE as repository-only evidence reconciliation. GAP-02 is **PARTIALLY MAPPED / NOT IMPLEMENTED END-TO-END / OPEN / NOT CLOSED**. M3-11-02 remains BLOCKED / NOT ACCEPTED; all ten M3-11 gate dispositions remain unchanged. No real data, hosted access, migration, backup inspection, deletion action, external processor, deployment or additional spend occurred or is authorized. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
