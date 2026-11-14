# M3-07 — Extensible Institution Information Model and Change Lifecycle

**Repository:** `mattari20/listing-v2`  
**Date:** 2026-11-14  
**Parent plan:** `M3-07_NATIONAL_EDUCATION_COVERAGE_AND_CONTINUOUS_AGENT_PLAN.md`  
**Status:** Domain/storage design proposal; no schema, migration, application code or source collection is authorized by this document.

## 1. Objective

Listing V2 must be able to store a broad and evolving range of student-relevant information for every supported education-provider type. New fields and information sections must be addable without redesigning the database for every new student need. Existing fields and values must be correctable, retireable and, where appropriate, removable from current presentation without destroying the audit/history needed to explain past decisions.

The design must support:
- universities, colleges, affiliated/constituent colleges, schools, small private schools, academies, training centres, professional institutions and other extensible provider categories;
- institution-, campus-, department-, programme-, course-, intake- and academic-session-scoped information;
- scalar, structured, repeatable, multilingual, dated and source-backed information;
- optional and institution-type-specific sections;
- controlled additions, corrections, retirement, restoration and removal;
- source provenance, evidence, validity, review, publication and audit;
- recurring AI-assisted discovery and update proposals without autonomous publication.

## 2. Core design principle: stable entities plus governed extensibility

Do not store the whole institution profile as one unvalidated JSON document and do not add a new physical database column for every optional field.

Use a hybrid model:

1. **Stable, first-class entities and relationships** for records with identity, lifecycle, relationships or independent search needs: provider, institution, campus/site, faculty/department, programme, course, qualification, admission cycle, fee schedule, scholarship, authority and source asset.
2. **Versioned field/attribute definitions** for extensible facts whose vocabulary and requirements can evolve.
3. **Typed, governed assertion/value records** connected to the existing claims, claim-version, evidence, adjudication, publication and audit lifecycle. Reuse the existing M3-03 governance boundary; do not create a parallel path that bypasses it.
4. **Purpose-built projections/read models** for public profile sections, filters and search. Projections are derived from approved current assertions and definitions, never directly from unreviewed values.

The existing core schema and services must be inspected during a separately authorized implementation package before deciding whether a proposed attribute registry can be represented through existing claim predicates and typed claim values or needs additive tables. Do not duplicate existing claim/evidence/version tables without an evidenced gap.

## 3. Field definition registry

Each extensible field requires a versioned definition with at least:

- immutable field key (machine identifier) and stable display label key;
- section/category and supported provider/entity types;
- subject scope: provider, institution, campus/site, department, programme, course, qualification, admission cycle, fee schedule or other registered entity type;
- value type and cardinality;
- optional/required applicability rules by provider type and context;
- validation schema, bounds, allowed values and unit/format rules;
- localization policy and supported language tags;
- whether the field is student-facing, searchable, filterable or internal-only;
- source/evidence requirements and permitted source classes;
- privacy/data classification and explicit prohibited-value rules;
- freshness class, effective-date behavior and expiry policy;
- public visibility policy and review requirement;
- definition version, activation date, retirement date, successor/mapping and change rationale;
- authorized proposer, reviewer and approver evidence.

Suggested types include:
- short text, long text, rich text only where sanitized and permitted;
- integer, decimal, boolean;
- date, date-time and date range;
- URL, email, phone (institutional channels only, subject to policy);
- enumerated value and controlled multi-select;
- money with currency and applicable period;
- duration with unit;
- location/address references;
- entity references and typed relationships;
- structured records and repeatable child collections.

Every type must have deterministic normalization and validation. Unknown types fail closed. Arbitrary executable content, scripts, HTML, formulas and unbounded nested objects are not permitted.

## 4. Field values and context

A field value must not be attached merely to an institution name string. It must point to a stable entity identifier and its registered subject scope.

Examples:
- institution-level: official website, institution type, general contact channel;
- campus-level: campus address, facilities and opening hours;
- programme-level: duration, eligibility and curriculum;
- admission-cycle-level: application deadline, entry test and intake;
- fee-schedule-level: amount, currency, academic session and effective date;
- course-level: course description, credits and prerequisites.

A value should support, where applicable:
- typed normalized value;
- original observed representation;
- language/locale;
- unit and currency;
- academic year/session;
- valid-from and valid-to;
- published-at and observed-at;
- source and exact evidence locator;
- authorization manifest/version and retrieval method;
- verification/review state;
- assertion/version lineage and correction/withdrawal state.

Do not use a single institution-wide field for facts that vary by campus, programme or intake. Do not overwrite an old fee or admission deadline with a new one; preserve effective periods and historical assertions.

## 5. Cardinality and repeatable information

Support explicit cardinality:
- zero-or-one;
- exactly-one only where justified and validated;
- zero-or-many;
- ordered list where order is meaningful;
- localized values;
- time-bounded series.

Repeatable structures with independent identity or lifecycle should become first-class child entities, not opaque arrays. Examples include campuses, departments, programmes, courses, admission cycles, fee schedules, scholarships, hostel facilities and official source accounts.

A repeated item must have its own identity, scope, dates, evidence and status. Deleting one item must not delete the institution or unrelated items.

## 6. Adding information

Adding a new field or information section is a governed schema/catalogue operation, distinct from adding a value to one institution.

### 6.1 Add a new field definition

1. Propose a field key, purpose and student use case.
2. Check whether an existing field or entity already represents the information.
3. Define applicable entity/provider types and scope.
4. Specify type, cardinality, validation, localization, privacy class and source/evidence requirements.
5. Define freshness, visibility, search/filter behavior and review policy.
6. Provide synthetic examples and invalid cases.
7. Review compatibility with existing records and projections.
8. Approve and version the definition.
9. Enable it only for the approved entity/provider contexts.
10. Record the actor, rationale, version and audit event.

New field definitions must not automatically authorize collecting that field from any source. Source authorization remains separate.

### 6.2 Add a value to an institution

A value may be proposed by an authorized editor or generated as an agent proposal. It must pass field validation, entity-scope validation, source/evidence checks and the existing human review/adjudication/publication controls. Missing or unsupported information remains empty/unknown; the agent must not fabricate a value to fill a profile.

## 7. Editing, correction and replacement

Editing an approved value creates a new assertion/version or correction successor; it does not silently mutate the historical record. Retain:
- prior and proposed values (subject to retention policy);
- reason for change;
- source evidence and observation/effective dates;
- proposer and reviewer/adjudicator/publisher;
- decision and timestamp;
- downstream projection/outbox/audit references.

The current displayed value is selected only through the existing approved governance lifecycle and current eligibility rules. Conflicting claims remain visible to reviewers until resolved. AI may propose a correction but cannot approve it.

## 8. Removing information: four distinct operations

The user-facing and administrative model must distinguish the following actions because they have different consequences.

### A. Remove a value from one institution

Examples: an institution no longer offers a facility or an old contact channel is invalid. Retire/withdraw the value through a human-reviewed event. Remove it from the current public projection after the required decision, while preserving the permitted historical audit and provenance.

### B. Retire a field definition

Use when a field is no longer required. Mark its definition as retired with effective date and reason. Stop accepting new values under that definition, except controlled historical corrections. Remove it from active entry forms and default profile views. Preserve historical values and definition versions according to retention policy.

### C. Replace or migrate a field

If a field is renamed, split, combined or changes meaning, create a successor definition and an explicit mapping/migration plan. Do not reinterpret old values silently. Preserve old-to-new lineage, validation results, exceptions and human approval.

### D. Erasure or deletion required by policy/law

A legal/privacy deletion request is not the same as ordinary retirement. Route it through a separately approved retention/deletion process. Preserve only what is legally permitted and necessary; do not promise indefinite retention of personal or source material. No general hard-delete capability should be exposed to ordinary editors.

## 9. Institution profile configuration and optional sections

Different provider types need different profile templates. Use configurable section templates and applicability rules rather than requiring every institution to fill every field.

Examples:
- school: grades/classes, curriculum, academic calendar, school fees, transport, school facilities;
- university: faculties, departments, programmes, semester fees, admissions and research;
- affiliated college: affiliating university, affiliation scope, programmes and campus;
- academy: subjects/coaching categories, course duration, schedule, fee and delivery mode;
- vocational centre: trades, certifications, practical facilities and awarding/recognition body.

Templates are presentation and completeness guidance, not evidence of registration or recognition. A field marked required for completeness must not be fabricated if no verified information exists. The UI must distinguish not applicable, not supplied, unknown, pending verification, expired and intentionally hidden.

Allow a field to be enabled for a provider type without forcing all existing records to contain it. Adding a new provider type or sub-type must be possible through a governed taxonomy change, not a code assumption that only universities exist.

## 10. Information completeness and student usefulness

Track completeness by profile section and context, not by a single misleading percentage alone.

Report:
- applicable fields;
- populated fields;
- source-backed fields;
- verified/current fields;
- stale/expired fields;
- missing/unknown fields;
- not-applicable fields;
- pending-review fields.

A profile may be rich but poorly verified. Show completeness and verification separately. Weighting, if introduced, must be documented and must not hide missing critical facts such as recognition status, admission deadline or fee validity.

## 11. Search, filtering and public projection

Only approved, currently eligible values can enter public projections. Search and filters must use a controlled allowlist of fields with normalized data types. Sensitive/internal-only fields are never exposed or searchable publicly.

Dynamic fields should be searchable only after an explicit indexability decision, validation and query-safety review. Do not automatically make every newly added field a public filter. Index rebuilds and projection changes must be deterministic, auditable and reversible.

## 12. AI-agent interaction with extensible information

The agent must:
- read only active field definitions and source authorization manifests;
- propose a new field only as a schema-change request, never create/activate it itself;
- extract only fields approved for the exact source/asset/method;
- validate values against the field's current version;
- identify likely missing, stale, changed or conflicting information;
- propose add/correct/retire actions with exact evidence;
- never infer that missing data means false, zero, closed or not applicable;
- never delete fields or institution values autonomously;
- never publish directly;
- stop when field definition or source authorization is missing, expired or ambiguous.

A new source or field family requires its own authorization assessment. A field registry entry is not a source permission.

## 13. Governance and permissions

Proposed capabilities (to be reconciled with the existing M3-04 P04 and M3-03 governance model):
- propose field definition;
- review/approve/retire field definition;
- propose institution value;
- correct or withdraw a value;
- review/adjudicate evidence and conflicts;
- approve public projection;
- inspect audit/history;
- request policy-based deletion;
- restore a retired definition/value where permitted.

Separation of duties remains mandatory for material claims. The submitter/agent, reviewer, adjudicator and publisher must be distinct where the existing policy requires it. Agent/service actors may submit proposals only and must be denied review, adjudication and publication capabilities.

## 14. Storage and performance considerations

The later implementation design must evaluate:
- normalized first-class entities for high-value repeatable structures;
- typed values rather than a single untyped text column;
- database indexes for entity, field key/version, scope, validity, status and common search dimensions;
- bounded JSON only for explicitly defined structured value types with schema validation;
- pagination and lazy loading for large profiles;
- query plans for common filters and dynamic search;
- retention/archival and source-evidence storage boundaries;
- transactionality across value version, adjudication, projection/outbox and audit;
- idempotency and concurrency on agent proposals;
- portability across the project's supported database/CI environment.

Do not store full copied websites, social feeds, videos, images or large documents as a side effect of collecting facts. Evidence storage and retention must be separately authorized and minimized; references/metadata may be preferable where legally and operationally appropriate.

## 15. Synthetic acceptance scenarios

Before implementation, define and test synthetic cases for:
1. Add a new field without a schema migration.
2. Reject a duplicate/conflicting field key.
3. Reject an unknown value type.
4. Enforce provider-type and entity-scope applicability.
5. Add a value to an institution and to a campus independently.
6. Store multiple programme/intake/fee schedule records without overwriting.
7. Preserve dates, currency, units and language.
8. Reject invalid date ranges and invalid enumerated values.
9. Keep missing/unknown distinct from false/zero/empty.
10. Retire a value and remove it from the current projection while preserving allowed history.
11. Retire a field definition and prevent new writes under it.
12. Create a successor definition and preserve mapping/lineage.
13. Restore a retired definition/value only through authorized workflow.
14. Route a deletion request through retention/privacy controls.
15. Deny agent-created field definitions and direct publication.
16. Deny unapproved source fields even when a matching field definition exists.
17. Keep private/internal fields out of public search and projection.
18. Handle stale/conflicting facts and historical academic sessions.
19. Preserve audit atomicity, idempotency and concurrent correction safety.
20. Keep profile completeness separate from verification quality.

Use fictional institutions, fictional field values and deterministic synthetic evidence only. No real institution/source/student/provider data, live model, API, network call or production service.

## 16. Open decisions before implementation

- Confirm the exact existing claim/claim-version representation and whether typed attribute values fit it without duplication.
- Decide whether the field registry needs dedicated additive tables or can be represented by a governed registry artifact plus existing claims.
- Define allowed structured-value depth and localization strategy.
- Define deletion/retention rules with qualified privacy/legal review.
- Define dynamic search allowlists and indexing limits.
- Define which provider-type templates ship in the first bounded pilot.
- Approve validation and completeness metrics using synthetic data.
- Reconcile capabilities with current M3-03/M3-04 services and prevent a parallel governance path.

## 17. Authorization boundary

This document is a design proposal only. It does not authorize schema changes, migrations, application code, admin UI, dynamic field CRUD, source access, real data, agent/model/connector/scheduler activation, production, V1, Hostinger, deployment or new spend. Any implementation requires a separate explicit owner authorization naming the bounded local/CI synthetic scope and exact files/behaviors.
