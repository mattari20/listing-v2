# M3-07 — Student Education Discovery Platform Architecture and Dynamic Field Governance

**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-15  
**Parent workstream:** M3-07 Pakistan-wide Education Information Ecosystem  
**Branch:** `docs/m3-07-national-education-coverage`  
**Status:** Owner-directed product/architecture clarification; documentation only. No source access, data collection, agent activation, application implementation, schema change, migration, deployment or additional spend is authorized by this document.

## 1. Product purpose — student-first discovery

The product's primary purpose is to help students and families discover suitable education providers and understand the actual learning options available to them. It is not merely a static institution-name directory.

A student should be able to discover institutions near a chosen/current location and answer questions such as:

- Which schools, colleges, universities, academies and training centres are nearby?
- Which subjects, courses, qualifications and degree programmes are offered?
- At which campus or branch is a particular programme actually available?
- What are the admission, tuition, semester, annual, examination and other applicable fees?
- What are the eligibility requirements, admission dates and official application routes?
- How far is the campus from the student's selected location?
- What is the institution's relevant recognition, registration, affiliation or accreditation status, and which competent authority supports that claim?

The product must distinguish verified facts, institution-provided information, unknown/missing information and stale information. It must not invent a fee, programme, recognition status, distance or admission date.

## 2. Confirmed logical architecture — three independent systems plus student experience

The architecture has three separate systems with controlled interfaces. They may initially be deployed within one application/repository and existing hosting footprint; logical separation does not require premature microservices or additional paid infrastructure.

### 2.1 Search and Discovery System

Responsibilities:
- Student-facing search by location, distance, provider type, subject, course/programme, qualification level, fee range and other approved filters.
- Read approved, current data from a dedicated search read model/projection or index.
- Support institution, campus and programme-level result cards and profiles.
- Resolve location and distance using approved coordinates and a separately approved routing/geospatial method where required.
- Keep query execution separate from AI source research and data-writing permissions.

It must not crawl sources during a student search, make up missing facts, or read unapproved/pending claims as public facts. Search must not write to the system of record.

### 2.2 AI Data-Agent System

Responsibilities:
- Work only on approved source/asset/method manifests and active field definitions.
- Discover candidate institutions and official source pages from approved inputs.
- Extract student-relevant facts from approved sources into structured proposals.
- Resolve possible institution/campus/programme matches with evidence and route ambiguous cases to human review.
- Compare new observations with current approved values and history.
- Detect additions, changes, removals, stale facts and source failures.
- Propose new field definitions as separate schema/catalogue change requests; it cannot activate fields itself.
- Submit change proposals to the existing claim/evidence/adjudication/publication governance lifecycle.

The agent is a proposal and monitoring system, not the authoritative database and not an autonomous publisher. Source content is untrusted data, not instructions.

### 2.3 Central Database System

Responsibilities:
- Maintain stable identities for institutions, campuses, departments, programmes, courses, admission cycles, fee schedules, authorities and sources.
- Store field definitions and their versions.
- Store approved current values, pending proposals, evidence, verification decisions and historical versions.
- Preserve who/what changed a value, why, when, on what evidence and under which field-definition version.
- Expose controlled read models to Search and controlled proposal/approval interfaces to the AI workflow.

The existing M3-03 claim/evidence/adjudication/publication/audit lifecycle must be reused. Do not create a parallel approval path or duplicate existing governance tables without an evidenced gap.

### 2.4 Student-facing website

The website is the user experience, not a fourth data authority. It calls the Search interface and displays only approved, currently eligible projections. It does not expose agent queues, source credentials, private evidence or internal-only fields.

## 3. End-to-end data flow

1. **Discover:** an approved official registry or permitted discovery source identifies an institution/campus candidate.
2. **Resolve identity:** match the candidate to an existing provider/campus record or propose a new one; ambiguous matches go to human adjudication.
3. **Find original sources:** identify the institution's official website, prospectus, programme pages, fee schedule, admission notices and official publications.
4. **Check authorization:** each exact source asset, access method, field scope, cadence and permitted action must have an active source authorization manifest.
5. **Extract:** the AI agent reads only allowed content and creates structured field-level assertions with source evidence and observed/published/effective dates.
6. **Validate:** deterministic checks validate field key/version, value type, units/currency, academic session, entity scope, dates, provider type, source permission and privacy classification.
7. **Compare:** compare the proposed value with current approved value and all relevant history. Classify as new, changed, unchanged, missing, withdrawn, conflicting or stale.
8. **Review:** a human reviewer sees old value, proposed value, source evidence, source dates, affected entity and impact. Recognition, affiliation, material fee and ambiguous identity claims receive the appropriate higher review.
9. **Approve or reject:** only an authorized reviewer/adjudicator can approve. Rejection leaves the current approved value unchanged and preserves the decision record.
10. **Commit a new version:** approval appends a new assertion/version and closes or supersedes the previous current version without deleting it.
11. **Refresh search projection:** a separate controlled publisher updates the public read model/index from approved current data only. The update is idempotent and auditable.
12. **Continue monitoring:** the next source check runs only at the approved source-specific cadence and within its quotas.

A source outage, missing page or failed fetch is not proof that an institution closed or that a previous fact remains current. Preserve the last approved value and mark freshness/source availability appropriately.

## 4. Dynamic information model — no fixed field ceiling

The information catalogue must evolve as institutions introduce new course attributes, fee components, subjects, delivery modes, learning formats, admissions requirements, facilities or other student-relevant information.

The system must support:
- adding a field or information section at any time through a governed field registry;
- enabling a field for selected provider types and entity scopes only;
- hiding a field from public profiles without deleting its data;
- disabling a field from new collection or new entry while retaining existing values/history;
- excluding a field from public search/filtering independently of whether it remains visible on a profile;
- retiring or deprecating a field with effective date and reason;
- replacing, splitting, combining or renaming fields through a successor definition and explicit mapping;
- restoring a retired field only through authorized review;
- adding new fields to institution, campus, department, programme, course, intake/admission, fee schedule or other approved scopes;
- keeping institution-specific and provider-type-specific profile templates.

A new field does not require a new physical database column by default. Stable entities and high-value relationships remain normalized first-class records; optional/evolving attributes use versioned definitions and typed, governed values connected to the existing claim lifecycle.

### 4.1 Field-definition registry

Each field definition should include:
- immutable machine key and stable label key;
- section/category and description;
- supported provider types and entity scope;
- value type, cardinality, units/currency and validation constraints;
- applicability rules and required/optional status;
- localization rules;
- public visibility, internal-only, searchable and filterable flags as separate controls;
- source/evidence requirements and permitted source classes;
- privacy/data classification;
- freshness class, effective-date and expiry behavior;
- definition version, lifecycle state, activation/retirement dates and successor mapping;
- proposer, reviewer, approver, rationale and audit reference.

Suggested field states: `proposed`, `approved`, `active`, `hidden`, `collection_disabled`, `deprecated`, `retired`. State transitions must be explicit and permission-controlled. Hiding a field is a presentation decision; retiring a field is a lifecycle decision; deleting data is a separate policy/legal operation.

### 4.2 Safe field lifecycle

**Add:** propose key, purpose, scope, type, validation, privacy, source requirements, freshness, display/search settings and synthetic examples. Check for duplicates. Review compatibility. Approve and version the definition. Only then enable it for selected entity/provider contexts.

**Collect:** the AI agent may extract the field only if both the definition is active and the exact source authorization allows that field and method. A field definition is not source permission.

**Show/hide:** an authorized administrator can independently control public profile visibility and search/filter eligibility. Hiding a field must not erase values, source evidence or historical versions. Internal-only fields must never enter public projections.

**Disable collection:** stop new agent/editor proposals for that field while retaining the field and its history. Existing current values may remain visible only if policy says so.

**Retire:** stop accepting new values under the retired definition, remove it from active forms/default profiles and preserve historical values and definition versions as permitted.

**Change meaning/type:** create a new definition version or successor field. Do not silently reinterpret old values. Define and test a mapping/migration, preserve lineage and exceptions, and review search projection changes.

**Delete/erase:** distinguish ordinary hide/retire from legally required erasure. Use a separate approved retention/privacy process; do not promise indefinite retention of personal data or source assets.

### 4.3 Example of future field evolution

An institution currently publishes programme name, duration and tuition fee. Later it adds:
- delivery mode (on-campus/hybrid/online);
- lab or studio charges;
- course accreditation status;
- internship requirement;
- revised credit-hour structure.

The source-monitoring workflow can detect these new attributes or a changed page structure. If the field already exists and is authorized, the agent proposes a value update. If the field does not exist, the agent raises a field-definition proposal; it must not silently create or publish a new field. Once the field is reviewed, approved and enabled for the relevant programme/campus/provider contexts, subsequent source observations can populate it. New values and field-definition versions are preserved with provenance.

## 5. Current values, previous values and history

Previous approved information must remain available as historical records. Never silently overwrite a fee, course structure, subject list, admission deadline, programme status or other time-sensitive value.

Each approved value/version should retain, as applicable:
- entity and field-definition/version identifiers;
- normalized and original observed values;
- language, unit, currency and period;
- academic year/intake and valid-from/valid-to;
- source/asset and exact evidence locator;
- published date, observed date and effective date;
- verification decision, reviewer, approver and timestamp;
- supersedes/superseded-by links and correction/withdrawal reason.

The current value is a derived selection of the latest approved and currently eligible assertion, not the only stored value. Rejected proposals do not replace current data. Corrections append a new decision/version and preserve the earlier record subject to lawful retention rules.

Example only:
- 2025 semester fee: Rs. 50,000 — historical
- 2026 semester fee: Rs. 60,000 — historical
- 2027 semester fee: Rs. 70,000 — current after approval

Fee records must always carry currency, fee period, campus/programme scope, academic session and effective date where available. Do not compare annual and semester fees as if they were equivalent.

## 6. Search/index separation and field controls

Search is a read-optimized subsystem, not the system of record. It consumes approved projections and maintains only the fields explicitly allowlisted for:
- full-text search;
- location/geospatial queries;
- filters/facets;
- sorting;
- public profile display.

A new field is not automatically searchable or filterable. Search enablement requires a field-type decision, normalization, privacy review, query-safety review, indexing decision and test. Hidden/internal fields are excluded. Retiring or hiding a field triggers a controlled, auditable projection update; historical data remains in the central database but is not automatically exposed.

Search index rebuilds must be deterministic and reversible. A projection/index failure must not corrupt the authoritative database. Search results must indicate freshness and verification state for time-sensitive facts.

## 7. Global reference models and implementation lessons

The following systems are research references, not systems to copy wholesale and not permission to reuse their data.

| Reference | Transferable lesson |
|---|---|
| India's UDISE+ | School identity, provider self-reporting, official validation and GIS-oriented data workflow |
| England's GIAS | Central provider registry, controlled updates and reusable authoritative identifiers |
| US College Navigator / College Scorecard | Student search by location, programme, cost and qualification; institution/programme distinction |
| UK National Careers Service Find a Course | Course-level records with provider, location, delivery mode, duration and cost |
| Studyportals | Programme discovery and university-source based programme details |
| Study2India | Source-backed fees and explicit handling of unavailable/unverified values |
| Australia's My School / Singapore MOE | Structured institution profiles and well-separated information domains |

### 7.1 Technical design lessons from authoritative documentation

- **Schema evolution:** Confluent Schema Registry documents versioned schema compatibility (backward, forward, full and transitive) and unique schema versions. The transferable principle is to version field definitions and test compatibility before activation; this project does not require adopting Confluent or its infrastructure.  
  https://docs.confluent.io/platform/current/schema-registry/fundamentals/schema-evolution.html
- **Dynamic search mappings:** OpenSearch supports strict, disabled and template-controlled dynamic mapping. Its documentation recommends explicit mappings for consistency and warns that automatically inferred field types can be inappropriate. The transferable principle is that newly detected attributes must not automatically become indexed/searchable fields; require approved definitions and controlled mapping templates.  
  https://docs.opensearch.org/latest/mappings/mapping-parameters/dynamic/  
  https://docs.opensearch.org/latest/mappings/dynamic-templates/
- **Flexible structured storage:** PostgreSQL documents JSONB validation, operators and indexes, but JSON storage is not a substitute for stable entities, typed field definitions, provenance or history. The project must choose storage based on the existing supported database and architecture, not assume PostgreSQL.  
  https://www.postgresql.org/docs/current/datatype-json.html
- **Historical change records and projections:** Microsoft's Event Sourcing guidance describes append-only events and materialized read projections, while warning that full event sourcing adds complexity in schema evolution, concurrency and querying. The transferable principle is immutable change history plus derived read models; do not adopt full event sourcing unless the existing architecture and measured need justify it.  
  https://learn.microsoft.com/en-us/azure/architecture/patterns/event-sourcing
- **Search filters:** Meilisearch's filterable-attribute specification shows that filter/facet eligibility is an explicit index setting, not an automatic consequence of a field existing. The transferable principle is separate field existence, profile visibility and filterability.  
  https://specs.meilisearch.dev/specifications/text/0123-filterable-attributes-setting-api.html

No search engine, database product, hosted service, model provider or paid API is selected or approved by these references.

## 8. Proposed implementation sequence

All steps below are planning targets. Each package requires its own explicit owner authorization and must pass the existing M3-07 gates.

1. **R1 — National source master inventory:** map official source owners, jurisdiction, institution category, available student-useful fields, identifiers, access method, freshness and unresolved rights/access questions.
2. **R2 — Product and data contract:** define student search use cases, provider taxonomy, entity relationships, campus/programme/fee scopes, field registry contract and history requirements.
3. **R3 — Architecture reconciliation:** inspect existing M3-03/M3-04 claim, evidence, adjudication, publication, audit, directory and geography components. Reuse them; document gaps before proposing additive changes.
4. **R4 — Synthetic field lifecycle:** design/test add, version, hide, disable, retire, restore, successor mapping and history using fictional institutions and fake sources only.
5. **R5 — Search projection contract:** define allowlisted profile/search/filter fields, location query behavior, freshness labels, index update and rollback using synthetic data.
6. **R6 — AI agent contract:** define discovery, source resolution, extraction, comparison, proposal, review and monitoring interfaces. No live model or source until separately approved.
7. **R7 — Bounded pilot proposal:** choose a small representative geography and provider mix only after source inventory, rights, privacy, security, cost and governance gates are satisfied.
8. **National expansion:** expand source-by-source and jurisdiction-by-jurisdiction after pilot acceptance and separate authorization.

## 9. Acceptance criteria for this architecture

- Search, AI-agent and central database responsibilities and permissions are separate and testable.
- AI cannot approve, publish or directly overwrite current approved data.
- A student search can combine location, distance, provider type, programme/subject and fee criteria using approved current data.
- Campus-specific programme availability and fee scope are represented correctly.
- Adding a field does not require a new physical database column by default.
- A field can be hidden from profile display, excluded from search/filtering, disabled for collection or retired independently.
- Field definitions are versioned; successor mappings preserve meaning and lineage.
- Adding a field does not authorize a source or collection method.
- Every approved value has field-level provenance, dates and review status.
- Previous approved values remain historically available subject to retention/privacy rules.
- A fee/course update creates a new version and does not destroy the old one.
- Rejected proposals do not change current values.
- Search projections contain approved allowlisted fields only and can be rebuilt.
- Synthetic tests cover schema compatibility, invalid types, duplicate keys, hide/retire behavior, old/new value history, field-scope rules, unauthorized source fields, stale data, false matches and publication denial.

## 10. Safety and authorization boundary

This document records product and architecture direction only. It does not authorize:
- live access to HEC, regulators, institution websites, social accounts, map platforms or other sources;
- scraping, crawling, API calls, external connectors or third-party dataset ingestion;
- live AI/model/provider activation, autonomous schedules or background agents;
- real institution, student, applicant, staff or personal data collection;
- database schema changes, migrations, application code, admin UI or search-engine deployment;
- production/V1/Hostinger access, deployment or new spending.

The existing source-rights, privacy, security, model/provider, cost, governance, synthetic-evaluation and owner-activation gates remain conjunctive. Any implementation requires a separate explicit owner authorization for its exact bounded scope.

## 11. Related M3-07 documents

- `M3-07_NATIONAL_EDUCATION_COVERAGE_AND_CONTINUOUS_AGENT_PLAN.md`
- `M3-07_EXTENSIBLE_INSTITUTION_INFORMATION_MODEL.md`
- `M3-07_EXISTING_ARCHITECTURE_RECONCILIATION_AND_STORAGE_DECISION.md`
- `M3-07_D1_FIELD_REGISTRY_CONTRACT.md`
- `M3-07_D2_FIELD_REGISTRY_STORAGE_DECISION.md`
- `M3-07_D3_FIELD_AWARE_CLAIM_SERVICE_BOUNDARY.md`
- `M3-07_D4_SYNTHETIC_EXTENSIBLE_INSTITUTION_PILOT_SPECIFICATION.md`
- `M3-07_D5_IMPLEMENTATION_READINESS_AND_BOUNDED_AUTHORIZATION_PROPOSAL.md`
