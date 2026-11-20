# M3-11 LPS-23 — GAP-02 Schema-Level Data-Class and Payload Inventory

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `d089b34937df15a360e75d1d3b14b77ed131c62c` (main after LPS-22 programme reconciliation)  
**Agenda:** LPS-23 — GAP-02 schema-level data-class and payload inventory  
**Work type:** Repository-only schema, route, controller, model and configuration inspection; no runtime or external access  
**Status:** **SCHEMA-LEVEL INVENTORY RECORDED — 51 DECLARED TABLES MAPPED; COMPLETE DATA LIFECYCLE / RETENTION / DELETION ACCEPTANCE REMAINS OPEN**

## 1. Purpose and decision boundary

LPS-23 closes one specifically bounded item in LPS-19's backlog: a schema-to-data-class worksheet with one entry for every declared table and explicit treatment of payload-bearing fields. It expands the 51-table count into a reviewable inventory of table purpose, data classes, likely subject/identity implications, payload concerns and deletion dependencies.

This is not a complete operational data inventory, data protection impact assessment, legal opinion, approved retention schedule, deletion certification, processor inventory or proof of deployed behavior. Schema semantics support a provisional risk review only; they do not establish actual contents, population, sensitivity, purpose necessity, lawful basis, retention or runtime location.

**Restrictions retained:** synthetic/fictional fixtures only; no V1/production/Hostinger/hPanel/hosted access; no live database, migration execution, backup inspection, restore or deletion action; no real institute/source/student/child/guardian/personal data; no source contact/access/collection/copying/scraping/crawling/ingestion; no external API, AI/model/provider, crawler or live agent; no public complaint/UGC/review/rating/appeal activation; no deployment, pilot, release candidate or participant activity; no new dependency, paid service, hosting upgrade or additional spend. Deeni Madaris remains default-OFF/zero exposure.

## 2. Method and evidence standard

Inspected the current-main Git tree and the 15 migration files, the public and authenticated web routes, the account/session/saved-item and institution proposal controllers, the User model, and database/session/cache/queue/filesystem/logging configuration. The migration inventory contains **51 explicit `Schema::create` declarations**. This is a repository declaration count only—not a live database table count.

Evidence labels used here:

- **CONFIRMED-REPOSITORY:** directly visible in a named current-main migration, route, controller, model or config file.
- **PROVISIONAL-CLASSIFICATION:** likely data class/risk inferred from field names and application purpose; must be confirmed by the accountable owner and qualified reviewer.
- **UNKNOWN-UNINSPECTED:** runtime, hosted, provider, actual payload or uninspected storage fact not established.
- **NOT-APPROVED:** no purpose expansion, retention duration, deletion exception, source permission or publication authorization is implied.

No production or hosted system was queried. No database, storage directory, log content, session content, cache, queue, backup, secret or environment override was inspected.

## 3. Schema-level inventory — all 51 declared tables

The field groups below are taken from migration declarations. “Payload / review concern” identifies fields whose contents may carry more information than their type or name reveals. It is not a claim that such content exists.

| # | Table | Declared data classes / principal fields | Provisional subject or risk review | Payload / lifecycle concern |
|---:|---|---|---|---|
| 1 | `directory_entities` | UUID, entity type, label, timestamps | Primarily institution/entity directory facts; label may identify a natural person if misused | Label minimization; entity relationships and claims depend on entity ID |
| 2 | `entity_relationships` | From/to entity IDs, relationship type, scope, jurisdiction, validity dates | Institutional relationships; scope/jurisdiction can become sensitive when over-specific | Relationship history and both parent entities are restrict-delete dependencies |
| 3 | `source_authorizations` | Source family, status, permitted purposes/methods/territories/scopes JSON, validity and revocation fields | Source-owner/rights governance metadata; actor not directly stored in this table | JSON arrays require controlled vocabulary and version history; revocation must affect downstream evidence use |
| 4 | `evidence_references` | Authorization ID, reference kind/type, integrity digest, status, content-included flag, observed/recorded timestamps | Source/provenance metadata; a reference may indirectly identify a source or person | No binary object store is declared here; external evidence-object location and retention remain unknown |
| 5 | `claims` | Subject entity ID, predicate, timestamps | Institution/entity attribute index | Depends on subject entity; claim versions and evidence links must be considered together |
| 6 | `claim_versions` | Claim ID, version number, field-definition version, JSON value, validity/recorded dates, disposition, supersedes ID, correction reason | Institution facts, potentially contact/location/fee/admission details; classification depends on field definition and actual JSON value | High-priority arbitrary JSON payload; version history and restrictive references complicate deletion |
| 7 | `claim_evidence_links` | Claim-version ID, evidence-reference ID, relationship type | Provenance linkage | Referential metadata may need retention even when source material is removed; requires approved minimization rule |
| 8 | `audit_events` | Actor class, action, target type/ID, reason code, occurred-at, JSON metadata | Actor and target activity metadata | JSON metadata can accidentally duplicate personal/source payload; audit retention and redaction are unset |
| 9 | `adjudication_cases` | Claim-version ID, status, opener actor ID, case kind, parent case, idempotency key | Human/service actor identifiers and workflow history | Actor IDs and linked claim history; retention/subject-access implications need review |
| 10 | `adjudication_decisions` | Case ID, outcome, actor ID/class, rationale code/text, policy version, decision time | Actor identity reference; rationale may contain personal or confidential narrative | Free-text rationale is a payload field; minimization, redaction and retention required |
| 11 | `publication_decisions` | Claim-version ID, decision, surface/audience, actor ID/class, adjudication decision, policy version, reason code, timestamps | Actor and publication-governance metadata | Decision history links to claim and adjudication records; public surface is not proof of publication |
| 12 | `publication_snapshots` | Decision ID, claim-version ID, snapshot version, JSON payload, digest, surface/audience/status/time | May contain publishable institution facts and derived content | High-priority duplicated JSON payload; suppression/deletion must reach every projection/cache/export |
| 13 | `public_projections` | Snapshot ID, projection key, surface/audience/status, Deeni Madaris flag, projected time | Derived public-facing record metadata | Projection is a secondary copy; invalidation and cache/edge propagation unverified; default-OFF boundary remains |
| 14 | `governance_outbox` | Event/aggregate identifiers, JSON payload, idempotency key, status, attempts, availability/processed times, last error, claim token/time | System workflow metadata; aggregate IDs can link to records/actors | JSON payload and free-text last_error may duplicate sensitive content; retry/dead-letter purge is not established |
| 15 | `publication_suppressions` | Snapshot ID, reason code, rationale text, actor ID/class, status, suppressed time | Actor and case rationale | Free-text rationale and linked publication history need minimization/retention rules |
| 16 | `publication_restorations` | Suppression/snapshot IDs, actor ID/class, policy version, reason code, restored time | Actor and governance history | Linked to suppressed snapshot; restoration must not silently recreate deleted/restricted content |
| 17 | `claim_conflicts` | Claim ID, conflict kind/status/fingerprint/idempotency, evaluated time, resolved candidate/decision IDs, actor ID, resolution rationale, resolved time | Actor and conflict-resolution history | Free-text rationale; links to all candidate versions; retention cannot be inferred from restrict-delete constraints |
| 18 | `claim_conflict_candidates` | Conflict ID, claim-version ID, validity/recorded dates, value digest | Derived value/provenance metadata | Digest may remain linkable; candidate versions are restrictive dependencies |
| 19 | `publication_rollbacks` | Current/target snapshot IDs, actor ID/class, policy version, reason code, idempotency key, rollback time | Actor and publication-control history | References two snapshots; rollback is not deletion and must not resurrect a deleted/restricted value |
| 20 | `directory_campuses` | Entity/institution IDs, location label, status, validity dates, claim-version ID | Institution location; potentially precise location data | Location-label granularity and source justification require review; entity/claim dependencies |
| 21 | `directory_delivery_sites` | Entity/institution IDs, location label, status, validity dates, claim-version ID | Institution delivery-site location | Same location minimization and downstream projection concerns as campuses |
| 22 | `programme_catalogue_entries` | Entity/institution IDs, title, description text, level, status, claim-version ID | Programme/institution facts | Free-text description may include unnecessary personal or copyrighted material; review content boundaries |
| 23 | `programme_qualification_links` | Programme, qualification and awarding-body entity IDs, status, claim-version ID | Institutional/qualification relationship facts | Multiple restrictive entity references; deletion/correction requires link reconciliation |
| 24 | `programme_offers` | Programme and delivery-location IDs, admission cycle, status, validity dates, claim-version ID | Programme availability/admission-cycle facts | Time-sensitive derived fact; downstream projections and stale copies require propagation rules |
| 25 | `authority_profiles` | Entity ID, authority type/status, registered-by actor ID, timestamps | Authority/representative governance metadata | Actor identifier and authority status history; no proof of real identity verification from schema alone |
| 26 | `editorial_review_cases` | Entity/claim IDs, status, submitter/reviewer actor IDs, adjudication/publication references, idempotency/fingerprint | Human reviewer/submitter identifiers and workflow | Actor IDs and cross-workflow links; correction, access and retention rules required |
| 27 | `directory_status_history` | Entity/claim/review IDs, event and previous/new status, actor ID/class, reason code, idempotency/fingerprint, JSON metadata, occurred-at | Actor and entity status history | JSON metadata may duplicate content; immutable history vs deletion obligations require qualified decision |
| 28 | `field_definitions` | Stable field key, timestamps | System metadata | Field key itself is not user data, but can expose product taxonomy; lifecycle follows version records |
| 29 | `field_definition_versions` | Definition ID/version, lifecycle and semantic/compatibility classes, value type/cardinality/scope, privacy/visibility classes, search/filter/sort flags, JSON validation/presentation/evidence/freshness policies, effective dates, successor, proposer actor, rationale reference | Actor reference and governance metadata; schema/policy content | Multiple JSON policy payloads; future extensibility can change data sensitivity/retention and requires LPS-10 impact review |
| 30 | `field_definition_version_entity_types` | Field-definition-version ID, entity type | Taxonomy/configuration metadata | Restrictive version dependency; changes should be versioned, not silently overwritten |
| 31 | `field_definition_version_provider_categories` | Field-definition-version ID, provider category | Taxonomy/configuration metadata | Restrictive version dependency; no live provider categorization authority implied |
| 32 | `directory_provider_category_assignments` | Entity ID, provider category, assigned-by actor ID, reason code, idempotency/fingerprint, assigned time | Institution classification plus actor reference | Assignment history/actor attribution; correction and deletion behavior need explicit rules |
| 33 | `field_definition_review_cases` | Field-definition-version ID, submitter/reviewer actor IDs, status, idempotency key, command fingerprint | Human reviewer/submitter references | Workflow metadata and actor identity; no reviewer appointment/qualification is proven |
| 34 | `field_definition_review_decisions` | Review-case ID, outcome, actor ID/class, rationale code/text, policy version, idempotency/fingerprint, decision time | Actor and review rationale | Free-text rationale; retention and redaction rules required |
| 35 | `users` | Numeric ID, unique email, password hash, email verification time, active flag, remember token, timestamps | Direct account identifier and authentication secret material | High-risk account data; password/remember token must never enter logs/exports; account lifecycle and session invalidation need policy |
| 36 | `role_assignments` | User/grantor IDs, role, scope type/ID, expiry/revocation, timestamps | Direct link to account and privileged role history | User deletion cascades; grantor null-on-delete; access/audit retention and recertification remain undefined |
| 37 | `privileged_action_audits` | Actor user ID, action, subject type/ID, scope, reason code, JSON metadata, created time | Privileged actor and subject activity | JSON metadata can duplicate sensitive payload; actor null-on-delete does not itself anonymize all references |
| 38 | `moderation_cases` | Scope, category/status, reporter/reviewer user IDs, outcome/reason codes, synthetic reference, timestamps | Account-linked moderation workflow; current design is synthetic-only | Schema uses codes/references rather than free-text complaint body; no real intake authorized |
| 39 | `moderation_appeals` | Moderation-case ID, appellant/reviewer user IDs, status, outcome/reason codes, synthetic reference, timestamps | Account-linked appeal workflow; current design is synthetic-only | Cascades from case; no public appeals operation or real personal data authorized |
| 40 | `moderation_events` | Case/appeal/actor IDs, event type, from/to states, reason code, created time | Account-linked workflow event history | Event timeline may preserve actor references; cascade/null behavior and retention require policy |
| 41 | `programme_offer_fact_freshness_policies` | Policy key/idempotency, category, freshness days, owner actor ID, policy version/status/approval and validity timestamps | Governance policy and actor reference | Approved policy metadata; expiry/versioning and audit retention required |
| 42 | `programme_offer_facts` | Programme-offer ID, fact key, category, timestamps | Programme-offer fact index | Fact key/category taxonomy; linked offer restrict-delete |
| 43 | `programme_offer_fact_versions` | Fact ID/version, idempotency, JSON value, fact state/disposition, observed/valid/recorded times, freshness policy/days, supersedes ID, correction reason | Programme/admission/fee/other fact payload; actual category controls risk | High-priority arbitrary JSON value; may contain personal or sensitive details if schema governance fails |
| 44 | `programme_offer_fact_evidence_links` | Fact-version ID, evidence-reference ID, relationship type | Provenance linkage | Evidence links and fact versions are restrictive dependencies |
| 45 | `programme_offer_fact_adjudication_cases` | Fact-version ID, status, opener actor ID, idempotency, timestamps | Actor/workflow metadata | Links to fact-version history; actor identity and retention need review |
| 46 | `programme_offer_fact_adjudication_decisions` | Case ID, outcome, actor ID/class, rationale code/text, policy version, decision time | Actor and decision rationale | Free-text rationale; same minimization/retention concern as general adjudication |
| 47 | `programme_offer_fact_publication_decisions` | Fact-version ID, decision, surface/audience, actor ID/class, adjudication decision, policy/reason/idempotency, decision time | Actor and publication governance | Publication decision is not proof that a real public surface is enabled |
| 48 | `programme_offer_fact_publication_snapshots` | Decision/fact-version IDs, snapshot version, JSON payload, digest, surface/audience/status/created time | Derived programme/admission fact copy | High-priority duplicate JSON payload; suppression/deletion must propagate to projection/cache/export |
| 49 | `programme_offer_fact_public_projections` | Snapshot ID, projection key, surface/audience/status/projected time | Derived public-facing fact metadata | Secondary copy; projection invalidation and public cache behavior unknown |
| 50 | `programme_offer_fact_publication_suppressions` | Snapshot ID, reason code, rationale text, actor ID/class, status/suppressed time | Actor and suppression rationale | Free-text rationale and linked snapshot; no real public suppression service activated |
| 51 | `saved_directory_items` | User ID, entity ID, created/updated timestamps | Direct account-to-institution preference relationship | User/entity deletes cascade in this table only; account export/deletion, session/cache copies and backup propagation not proven |

## 4. Non-table persistence and request/session surfaces

These surfaces are visible in current repository code/config but are not included in the 51 migration-table count:

| Surface | Repository evidence | Data class / concern | Status |
|---|---|---|---|
| Browser session | `config/session.php`; account login regenerates session and logout invalidates it | Authentication/session identifiers, CSRF token, locale and shortlist values; file/database/cache backend is configurable | Config defaults only; actual runtime driver and session expiry/sweeper behavior unknown |
| Directory shortlist | `PublicDirectoryController` stores UUID entity IDs under `directory_shortlist` in session | User-selected institution IDs; potentially linkable preference data | Confirmed code path; session storage/retention follows unknown runtime driver |
| Locale preference | Public/account controllers store `directory_locale` in session | Language preference | Confirmed code path; retention follows session policy |
| Account saved-item view | `AccountSavedItemsController` returns saved IDs and profile data with private/no-store headers | Authenticated user preferences and linked institution details | Confirmed route/controller; HTTP cache headers do not govern browser screenshots, exports or backups |
| Login request | `AccountSessionController` validates email/password and creates authenticated session | Email and credential input; password checked against stored hash | Confirmed code path; request-body logging and upstream logs not established |
| Institution proposal/correction | `UniversityRepresentativeWorkflowController` accepts field key, definition version, JSON-like value, evidence-reference UUIDs, validity dates and correction rationale | Potential institution facts, actor identity, evidence linkage and free-text rationale | Confirmed authenticated route/controller; payload classification and log/error hygiene require tests |
| Public search/filter requests | `PublicDirectoryController` accepts query, type, locality, filters and page | Search intent and possible location preference | Request parameters are visible in code; access-log/query-string retention and analytics not established |
| Local/private/public files | `config/filesystems.php` defines private local, public local and optional S3 disks | Unknown file/object payloads | Config possibilities only; no runtime object inventory |
| Cache | `config/cache.php` defines array default and file/database/Redis/Memcached/DynamoDB/storage options | Arbitrary cached application/query/session values | Runtime store, TTL, keys and invalidation unknown |
| Queue / failed jobs | `config/queue.php` defines sync default and database/Redis/SQS/etc. options; failed jobs default to database UUID driver | Serialized job payloads, exception details and failed-job metadata | Runtime driver and actual jobs unknown |
| Logs / telemetry | `config/logging.php` includes daily rotating local handler and optional external channels | Messages, stack traces, actor IDs, request context and provider copies | Existing 30-day cleaner is limited to matching rotated local files; no universal log retention |
| Backups / replicas / exports / temporary files / processors | Not exhaustively established by inspected repository paths | Potential full or partial copies of any data class | UNKNOWN-UNINSPECTED / EXTERNAL-REVIEW-REQUIRED |

## 5. High-priority payload and minimization register

The following fields require explicit payload review before any real-data or hosted proposal. They are not automatically unsafe, but their unconstrained or narrative content can exceed the intended data class.

| Priority | Fields / tables | Required bounded synthetic review |
|---|---|---|
| P0 | `claim_versions.value`; `programme_offer_fact_versions.value` | Confirm field-definition allowlists, type/size bounds, nested-value constraints, privacy class enforcement and rejection of synthetic forbidden markers |
| P0 | `publication_snapshots.payload`; `programme_offer_fact_publication_snapshots.payload` | Confirm only approved fields are projected; no hidden/internal/identity/evidence payload; suppression and correction invalidation paths |
| P0 | `governance_outbox.payload`; `governance_outbox.last_error` | Confirm event payload minimization, no secrets/credentials/personal identifiers, redacted errors and bounded retries/dead-letter expiry design |
| P0 | `users.email`, `users.password`, `users.remember_token` | Confirm secret exclusion from logs/errors/exports; account deletion/session revocation design and access restrictions |
| P1 | `adjudication_decisions.rationale`, `publication_suppressions.rationale`, `claim_conflicts.resolution_rationale`, `field_definition_review_decisions.rationale`, `programme_offer_fact_adjudication_decisions.rationale`, `programme_offer_fact_publication_suppressions.rationale` | Synthetic tests for no real names, contact details, secrets or copied source content; define structured reason codes and narrow rationale rules |
| P1 | `audit_events.metadata`, `directory_status_history.metadata`, `privileged_action_audits.metadata` | Schema allowlists, maximum sizes, actor/subject reference minimization and no arbitrary request-body duplication |
| P1 | `source_authorizations` JSON policy fields; `field_definition_versions` JSON policy fields | Versioned schemas, controlled values, no secret/credential storage, and change-impact review |
| P1 | `programme_catalogue_entries.description`, `directory_entities.label`, campus/site `location_label` | Content length, factual necessity, source-rights and precise-location minimization review |

No runtime payload inspection was performed. No synthetic marker test is claimed to have been run as part of LPS-23.

## 6. Referential and derived-copy implications

1. Many core and governance records use `restrictOnDelete`; this prevents selected parent deletion while dependent records exist, but it is not a retention policy and does not justify indefinite retention.
2. User role assignments and saved items include cascade behavior; some actor references use null-on-delete. These rules affect only the declared foreign-key relationships and do not remove logs, sessions, caches, files, exports, backups or processor copies.
3. Publication snapshots and public projections, including the parallel programme-offer fact path, create derived copies. Any future correction, restriction or deletion design must map each snapshot, projection, cache, export and backup separately.
4. Outbox, audit, decision, rationale and history tables can preserve identifiers or duplicated payload after a primary value is changed or removed.
5. A rollback/restoration operation is not deletion and must not reintroduce content that has been suppressed, restricted or deleted under an approved policy.
6. The `saved_directory_items` cascade is a narrow relationship rule only; it does not prove full account deletion.
7. No table-level cascade/restrict/null behavior can determine legal retention. A qualified reviewer and accountable owner must approve the eventual policy.

## 7. Inventory coverage and unresolved questions

| Inventory requirement | LPS-23 result |
|---|---|
| One entry for every declared table | **COMPLETE — 51/51** |
| Data-bearing and identity/actor fields recorded | **COMPLETE at schema-name/type level** |
| JSON, text and other payload-bearing fields identified | **COMPLETE for declared schema fields inspected** |
| Non-table session/request/config surfaces identified | **PARTIAL — code/config surfaces listed; runtime locations unknown** |
| Data subject and sensitivity classifications | **PROVISIONAL ONLY — qualified/owner validation outstanding** |
| Purpose and necessity for every field | **NOT APPROVED — requires Product Owner and qualified review** |
| Runtime/hosted store, region, processors and actual copies | **UNKNOWN / NOT INSPECTED / NOT AUTHORIZED** |
| Approved retention triggers and durations | **NOT RECEIVED — all durations remain UNSET** |
| Deletion, de-identification and downstream propagation | **NOT IMPLEMENTED / NOT VERIFIED END-TO-END** |
| Backup expiry, restore and deletion replay | **NOT RECEIVED / NOT AUTHORIZED** |
| Qualified privacy/legal/safeguarding assessment | **NOT RECEIVED** |

## 8. Required next work and acceptance criteria

The next bounded repository agenda may address only synthetic verification and design gaps that do not require invented policy:

1. Add synthetic payload-minimization tests for JSON values, rationale fields, outbox payload/error, audit metadata and publication snapshots.
2. Trace all explicit application write/read call sites for these payload fields and record exact paths/symbols.
3. Define synthetic lifecycle test cases for correction, suppression, rollback, saved-item removal and projection invalidation without creating a real-data deletion service.
4. Keep retention durations, legal holds, audit expiry and backup expiry unset until approved by the accountable Product Owner after qualified review.
5. Maintain a separate runtime/processor/backup evidence intake list; do not inspect those systems under this agenda.

Acceptance for LPS-23 is limited to: all 51 declared tables represented; payload fields identified; non-table request/session/config surfaces distinguished from tables; deletion dependencies and unknowns explicit; no invented retention durations; and all scope restrictions preserved.

## 9. GAP-02 disposition after LPS-23

- [x] 51/51 migration-declared tables mapped to provisional data classes.
- [x] JSON/text payload and identity/actor field groups identified.
- [x] Request/session and configurable storage surfaces separated from schema table inventory.
- [x] Referential and derived-copy deletion implications documented.
- [x] Unknown runtime/hosted/processor/backup surfaces retained as unknown.
- [x] No retention duration or legal basis invented or approved.
- [ ] Complete operational data inventory — OPEN.
- [ ] Qualified validation of subject/sensitivity/purpose/necessity — OPEN.
- [ ] Runtime/hosted store and processor inventory — NOT INSPECTED / NOT AUTHORIZED.
- [ ] Approved retention schedule — NOT RECEIVED.
- [ ] Deletion propagation implementation and end-to-end evidence — NOT ESTABLISHED.
- [ ] Backup expiry/restore/deletion replay evidence — NOT RECEIVED.
- [ ] Qualified privacy/legal review — NOT RECEIVED.
- [ ] GAP-02 closure — NOT ACCEPTED.

**Final disposition:** LPS-23 is complete as a repository-only schema-level inventory. GAP-02 advances from PARTIALLY MAPPED to **SCHEMA-LEVEL INVENTORY COMPLETE / OPERATIONAL LIFECYCLE INCOMPLETE / OPEN / NOT CLOSED**. M3-11-02 remains BLOCKED / NOT ACCEPTED; all ten M3-11 gate dispositions remain unchanged. No real data, hosted access, migration, backup inspection, deletion action, external processor, deployment or additional spend occurred or is authorized. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.

## 10. Source files inspected

- `database/migrations/2026_11_13_000001_create_core_governance_tables.php`
- `database/migrations/2026_11_13_000002_create_persisted_governance_workflows.php`
- `database/migrations/2026_11_14_000001_add_outbox_claim_leases.php`
- `database/migrations/2026_11_14_000002_create_persisted_conflicts_and_rollbacks.php`
- `database/migrations/2026_11_14_000003_link_relationship_projections_to_claim_versions.php`
- `database/migrations/2026_11_14_000004_create_campus_programme_catalogue.php`
- `database/migrations/2026_11_14_000005_create_authority_profiles.php`
- `database/migrations/2026_11_14_000006_create_editorial_review_and_status_history.php`
- `database/migrations/2026_11_14_000007_create_field_registry_tables.php`
- `database/migrations/2026_11_14_000008_add_provider_category_assignments_and_claim_field_binding.php`
- `database/migrations/2026_11_16_000001_create_field_definition_review_workflows.php`
- `database/migrations/2026_11_16_000002_create_identity_and_authorization_tables.php`
- `database/migrations/2026_11_16_000003_create_synthetic_moderation_workflow_tables.php`
- `database/migrations/2026_11_18_000001_create_programme_offer_fact_governance.php`
- `database/migrations/2026_11_20_000001_create_saved_directory_items_table.php`
- `routes/web.php`
- `app/Http/Controllers/AccountSavedItemsController.php`
- `app/Http/Controllers/AccountSessionController.php`
- `app/Http/Controllers/PublicDirectoryController.php`
- `app/Http/Controllers/UniversityRepresentativeWorkflowController.php`
- `app/Models/User.php`
- `config/session.php`, `config/cache.php`, `config/queue.php`, `config/filesystems.php`, `config/logging.php`, `config/database.php`

**No runtime, database, storage, log, session, cache, queue, backup, processor or hosted-system evidence is asserted by this document.**
