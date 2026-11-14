# M3-07 D1 — Field Registry Contract and Definition Lifecycle

**Date:** 2026-11-14  
**Repository:** mattari20/listing-v2  
**Workstream:** M3-07 nationwide education information and continuous data-agent readiness  
**Depends on:** M3-07 extensible institution information model; existing M3-03 governance and M3-04 provider management  
**Status:** D1 logical contract drafted for owner review. Documentation/design only; no physical schema or application implementation authorized.

## 1. Purpose and decisions

This contract defines how the directory can add new kinds of institution information over time without adding a database column for every field or creating an uncontrolled arbitrary-attribute store.

The contract applies across Pakistan's education-provider landscape, including public and private schools, small/local schools, colleges, universities, academies, coaching providers, professional institutions, technical/vocational providers, early-learning providers and other approved categories. Institution/provider category is not the same thing as legal status, registration, recognition, accreditation or quality.

**Core decisions:**

1. A field definition is a governed, versioned metadata object; a field value is a claim about a specific directory entity.
2. Field definitions and institution values have separate lifecycles and separate approval requirements.
3. A field key is immutable and never reused for a different meaning.
4. Every claim version must be interpretable against the exact field-definition version that validated it.
5. Values use deterministic typed validation; arbitrary unvalidated JSON is prohibited.
6. Fields declare allowed entity types, provider categories, scope, cardinality, privacy, evidence requirements, freshness, visibility and search behavior.
7. A new field definition does not create values for institutions and does not authorize access to any source.
8. An AI agent may recommend a definition or value change, but cannot create/activate a definition, adjudicate, publish, retire or erase records.
9. Existing M3-03 claims/evidence/adjudication/publication/audit services remain the authoritative governance lifecycle.
10. Physical persistence, schema and migration choices are D2 decisions and require separate implementation authorization.

## 2. Two distinct registries and lifecycles

### 2.1 Field-definition registry

The registry describes what a kind of information means and how it may be handled. Examples include an institution's official display name, school grade range, admissions contact channel, programme duration or fee schedule amount.

A field definition does not assert that any institution has that information.

### 2.2 Field-value claims

A value is a proposed, evidenced, time-aware assertion about one subject entity. It enters the existing claim/version/evidence/adjudication/publication lifecycle.

Examples:
- one fictional school has a proposed grade_range value;
- one fictional academy has a proposed delivery_mode value;
- one fictional programme has a proposed duration value.

The field registry controls validation and interpretation. It does not replace claims or evidence.

## 3. Immutable field identity and versioning

Each field definition has:
- field_key: globally unique, lowercase, stable identifier;
- definition_version: monotonically increasing positive integer;
- status: proposed, approved, active, deprecated, retired or rejected;
- semantic_version: controlled change classification;
- created_at, effective_from, optional effective_to;
- proposer, reviewers, approver and rationale references;
- optional successor field key and explicit migration mapping.

### 3.1 Key rules

- Recommended key syntax: lowercase ASCII snake_case, 3–80 characters, starting with a letter.
- Keys are globally unique and never recycled, even after retirement.
- A key must represent one stable semantic concept.
- Display labels may be localized or revised without changing the key when meaning is unchanged.
- A material semantic change requires a new definition version or a new key; it must not silently reinterpret historical values.
- A retired key remains reserved permanently.
- Aliases are explicit metadata and cannot be used to bypass validation.

### 3.2 Definition-version rules

- Every approved version is immutable.
- A draft can be edited before approval, with audit history.
- An approved definition version cannot be overwritten.
- New versions require a change rationale and compatibility classification.
- Existing claim versions retain their original definition-version binding.
- A new version does not automatically revalidate, rewrite or republish old values.
- Any migration/revalidation is a separate, auditable operation with a preview and human approval.
- Rollback means activating a prior compatible version through a new decision, not deleting history.

### 3.3 Compatibility classes

| Change | Compatibility class | Required treatment |
|---|---|---|
| Correct localized label/help text without semantic change | Presentation-only | New definition version; existing values retain meaning |
| Add an allowed provider category without changing value meaning | Applicability expansion | Review scope, permissions and exposure; new version |
| Tighten validation or change normalization | Validation-breaking | New version; revalidate future values; old values retain prior rule version |
| Change type, units, cardinality or semantic meaning | Semantic-breaking | Usually new field key plus explicit successor mapping |
| Change privacy or public/search visibility | Policy-sensitive | Explicit policy review; new version; projection reevaluation |
| Retire a field | Retirement | Stop new proposals; preserve historical interpretation subject to retention policy |

## 4. Required definition contract

Every active field definition version must declare all required properties below. Unknown or missing policy values fail closed.

| Property | Contract |
|---|---|
| Identity | Immutable field_key, definition_version, status and semantic version |
| Presentation | Section key, label key, help key, optional localized display metadata |
| Meaning | Plain-language definition, inclusion/exclusion rules and synthetic examples |
| Subject entity types | Explicit allowlist such as institution, campus, programme or authority |
| Provider categories | Explicit allowlist or explicit universal applicability; never infer from name |
| Scope | Entity-level, campus-level, programme-level, admission-cycle-level, fee-schedule-level or another approved scope |
| Cardinality | Exactly one, zero-or-one, or bounded many; define uniqueness key for repeated values |
| Value type | One supported type from Section 6 |
| Validation | Deterministic constraints, normalization and schema version |
| Localization | Whether language-specific values are allowed/required and how language is represented |
| Units/currency | Required unit/currency and conversion/display rules where relevant |
| Temporal behavior | Valid-time, observed-time, expiry/freshness policy and session applicability |
| Privacy | Classification, prohibited data, retention class and audience restrictions |
| Evidence | Required evidence classes, minimum evidence conditions and source authorization context |
| Visibility | Internal-only, restricted editorial, or public-eligible after approval |
| Search | Explicitly searchable/filterable/sortable flags and approved query strategy |
| Lifecycle | Activation, deprecation, retirement and successor mapping rules |
| Governance | Required proposer/reviewer/approver capabilities and separation of duties |

The registry must not contain credentials, API keys, access tokens or source content.

## 5. Provider-category and entity-scope applicability

### 5.1 Provider category is taxonomy, not identity

Provider categories should be governed taxonomy values, not a reason to create a separate physical table for every type of school or academy.

Illustrative categories (not a final exhaustive taxonomy):
- school: public, private, community or other approved subcategory;
- college: intermediate, degree, constituent, affiliated or independent;
- university/higher education institution;
- academy/coaching/tutoring provider;
- technical/vocational/skills provider;
- professional/specialist institution;
- preschool/early-learning provider;
- distance/online education provider;
- madrasah/deeni education category under its existing separate default-OFF policy.

A category does not prove registration, approval, recognition, accreditation or legal status. Those are separate claims/relationships with their own competent authority, evidence and review.

### 5.2 Applicability contract

Each field declares:
- permitted directory subject entity types;
- permitted provider categories;
- optional exclusions;
- required parent/relationship context;
- whether applicability is inherited or explicitly assigned.

Default inheritance is off. A field allowed for an institution does not automatically apply to every campus or programme. The field must explicitly allow the subject entity type and scope.

### 5.3 Scope examples

| Information concept | Correct subject/scope |
|---|---|
| Institution display name | Institution entity |
| Campus address or campus facilities | Campus/delivery-site entity |
| Programme title or duration | Programme entity |
| Programme offered at a campus for an intake | Cycle-scoped programme offer |
| Fee amount and payment period | Fee schedule or explicitly scoped fee claim |
| Institution-level general contact channel | Institution entity |
| Campus-specific contact channel | Campus entity |
| Authority recognition relationship | Typed authority relationship with scope and valid dates |

Do not attach campus-specific facts to the institution merely because the institution owns that campus. Do not use names as entity identifiers.

## 6. Supported value types

Only the following bounded type families may be activated initially. Each field selects one type and an explicit validation schema.

| Type | Representation rules |
|---|---|
| short_text | UTF-8 string with length and normalization limits |
| long_text | Bounded plain text; no executable markup or untrusted HTML |
| integer | Whole number with optional minimum/maximum |
| decimal | Fixed precision and explicit scale/range |
| boolean | True/false; missing is not false |
| date | ISO calendar date with explicit temporal meaning |
| date_range | Start/end with explicit inclusive/exclusive rule |
| url | Validated HTTP(S) URL; no script/data/file schemes; source URL publication separately controlled |
| email | Institutional contact only; no personal email unless explicitly justified and approved |
| phone | Institutional contact only, normalized with country context where known |
| enum | Stable allowed codes with localized labels; unknown values fail closed |
| money | Decimal amount, ISO currency, fee period/component and applicable dates |
| duration | Numeric amount plus controlled unit |
| language_code | Approved language code with optional localized text |
| entity_reference | Existing stable entity ID plus permitted target entity types |
| bounded_object | Versioned, allowlisted object schema with depth, key-count and byte limits |
| bounded_collection | Bounded list with explicit item schema and cardinality |

### 6.1 Explicitly prohibited

- arbitrary executable code, scripts, formulas or macros;
- untrusted HTML, embedded iframes or active content;
- arbitrary object keys or unbounded nested JSON;
- binary files or whole website/social feed content stored as field values;
- credentials, passwords, tokens or secrets;
- student/applicant/child records, identity documents, marksheets, personal health/disability data, personal addresses or unrelated personal information;
- free-form fields that invite sensitive personal data.

### 6.2 Missing and empty semantics

The system must distinguish:
- not supplied;
- unknown;
- not applicable;
- pending verification;
- expired;
- intentionally hidden/restricted;
- withdrawn;
- false;
- zero;
- empty string (only where allowed).

A missing value must not be synthesized as false, zero, empty or not applicable. Completeness scoring must not convert missing into a negative assertion.

## 7. Cardinality and repeated information

Cardinality is declared per field:
- one: exactly one value where required;
- zero_or_one: optional single value;
- many: bounded repeatable values with an explicit maximum and uniqueness rule.

A repeatable value must define:
- item identity/uniqueness strategy;
- ordering behavior, if meaningful;
- whether each item has its own valid-time and evidence;
- whether items can be corrected/withdrawn independently.

If an item has an independent identity, relationships, lifecycle or substantial query needs, promote it to a first-class entity rather than hiding it in an opaque JSON array. Examples potentially include campus, programme, admission cycle, fee schedule or scholarship offer after domain review.

## 8. Privacy, evidence and source requirements

### 8.1 Privacy classification

Every definition must declare one classification:
- public_eligible: may be considered for public publication after all claim-level approvals;
- editorial_restricted: visible only to authorized internal editorial workflows;
- sensitive_prohibited: prohibited from collection/storage in this directory scope.

A public_eligible classification is not publication permission. Claim-level human adjudication, publication decision, current evidence/source eligibility, suppression and projection policy remain mandatory.

### 8.2 Evidence policy

Every field declares:
- whether evidence is mandatory;
- accepted evidence classes;
- minimum source independence/quality requirements where needed;
- whether multiple sources are required for high-impact claims;
- freshness/expiry and re-verification rules;
- whether manual verification is permitted;
- whether the field may be sourced from an institution-controlled channel, competent authority or other approved source class.

The source authorization is separate and exact. A field definition cannot authorize a source, platform, method, purpose, territory, volume or retention action. An approved source family cannot automatically authorize every field or purpose.

### 8.3 Freshness

Freshness must be field-specific. Examples:
- institution legal identity: event-driven review plus periodic confirmation;
- current admissions deadline: short-lived and intake-scoped;
- fee schedule: session/effective-date scoped;
- campus address: event-driven with periodic confirmation;
- programme description: slower review cadence.

These are illustrative classes only; actual time thresholds must be approved in D1/D2 or later source-specific operations. Never infer current truth merely because a value is the latest recorded value.

## 9. Visibility, search and projection contract

- Each definition explicitly declares whether it can be public-eligible.
- Search/filter/sort must be individually allowlisted; default is not searchable.
- Only approved, current, non-suppressed projections may serve anonymous directory reads.
- Internal claim values, evidence references, source authorization metadata and editorial notes never flow directly into public responses.
- Dynamic field values must be normalized and query-bounded; do not build SQL identifiers or query expressions from user-supplied field names.
- No blanket JSON-key indexing. Query-critical repeatable concepts may be promoted to first-class entities after measured need and review.
- Public projections must preserve the distinction between unverified, unknown, expired, disputed and approved facts where the product design exposes such status.
- Existing Deeni Madaris default-OFF policy remains binding across definitions, templates, search and projections.

## 10. Definition proposal, approval and activation

A new definition follows this workflow:

1. Proposer submits immutable key proposal, semantic definition, provider/entity applicability, type, cardinality, validation, privacy, evidence, freshness, visibility, search and rationale.
2. Registry validation checks key syntax/uniqueness, duplicate meaning, scope compatibility, supported type/schema and prohibited data.
3. Domain review checks whether the concept already exists as a claim predicate or first-class entity.
4. Privacy/security/source-rights review checks collection risk, public exposure and evidence/source needs.
5. Independent human approver accepts, rejects or requests changes; proposer cannot approve their own definition.
6. Approval creates an immutable approved definition version.
7. Activation is a distinct controlled transition after policy and compatibility checks.
8. The definition becomes available only to permitted provider/entity contexts.
9. Audit records the definition version, actors, rationale and policy version.

The AI agent may produce a proposal package with rationale and synthetic validation examples. It cannot reserve a production key, approve or activate the definition.

## 11. Value proposal and change workflow

1. Resolve the active approved definition version.
2. Check field is active and applicable to the subject entity and provider category.
3. Validate typed value, cardinality, units, locale, dates, size and normalization.
4. Enforce privacy/prohibited-value policy.
5. Check evidence reference and exact source authorization for the requested processing/retention/use.
6. Register a proposed claim/version bound to the definition version.
7. Run deterministic domain validation, conflict and freshness checks.
8. Submit through existing editorial review and persisted adjudication.
9. Require a distinct human publication decision for public use.
10. Generate/refresh only approved allowlisted projections.
11. Record audit/outbox events with idempotency and correlation.

The generic claim-registration entry point must not remain a bypass around the field-aware validator for dynamic fields. The D2/D3 design must decide how legacy/non-registry predicates are explicitly allowlisted during transition.

## 12. Field and value retirement/change operations

| Operation | Target | Rules |
|---|---|---|
| Correct value | One claim | New successor claim version, evidence and reason; preserve prior history |
| Withdraw value | One claim/value | Human-reviewed withdrawal; remove from current projection only after approved governance transition |
| Retire field | One field key/version | Stop new proposals; preserve historical definition and interpretation |
| Deprecate field | One field key/version | Warn and prevent new use after effective date; migration window explicit |
| Replace field | Old key to successor key | Explicit mapping, validation and human-approved migration; no silent copy |
| Restore field | Retired/deprecated field | New human decision; revalidate current privacy, evidence and compatibility policy |
| Erase under legal/privacy policy | Defined records/retention scope | Separate authorized retention/deletion workflow; not ordinary editor CRUD |

Field retirement must not silently withdraw every historical claim or delete evidence. Conversely, withdrawing one institution's value must not retire the field globally.

## 13. Institution profile templates and completeness

Templates are views over the registry, not separate data stores.

A template may define:
- recommended sections for a provider category;
- required versus optional fields;
- conditional fields;
- expected entity scope;
- completeness weighting/version.

Templates must support optional sections and multiple provider categories without forcing every school, academy, college or university to supply the same fields.

Completeness and verification are separate:
- completeness: whether expected information is present;
- verification: whether a particular claim has passed evidence and human governance.

A complete profile may contain unverified values; a verified profile may legitimately omit non-applicable optional fields. Neither score may imply accreditation, quality or endorsement.

## 14. Definition and value audit contract

Every definition change and value lifecycle action records:
- actor ID/class and capability;
- action and target key/version/entity/claim version;
- prior and resulting state;
- reason code and rationale reference;
- timestamp and correlation/idempotency key;
- applicable policy and validator versions;
- evidence/source authorization references where relevant.

Audit metadata must be minimized and must not copy source content, credentials or sensitive personal data.

## 15. Minimum D1 synthetic acceptance matrix

| ID | Scenario | Expected result |
|---|---|---|
| D1-01 | New unique field key with supported type | Definition proposal accepted for review, not active |
| D1-02 | Duplicate key or key reuse after retirement | Rejected |
| D1-03 | Same key, semantic meaning changed | Requires new key or explicit successor decision |
| D1-04 | Unsupported type or missing required policy | Rejected |
| D1-05 | School-only field on a university | Rejected unless explicitly applicable |
| D1-06 | Institution field attached to campus without inheritance | Rejected |
| D1-07 | Campus-specific value on correct campus ID | Accepted as proposal if all other rules pass |
| D1-08 | Boolean false versus missing | Distinct representations |
| D1-09 | Money without currency/period where required | Rejected |
| D1-10 | Unknown enum value | Rejected or quarantined as unsupported; never silently coerced |
| D1-11 | Unbounded object, executable markup or excessive payload | Rejected |
| D1-12 | Definition activated without independent approval | Rejected |
| D1-13 | Field definition treated as source permission | Rejected |
| D1-14 | Expired/revoked source authorization | Value proposal/processing blocked |
| D1-15 | Correct one value | New claim version; old version retained |
| D1-16 | Withdraw one institution value | Only that value's eligible projection withdrawn |
| D1-17 | Retire field | New proposals blocked; history remains interpretable |
| D1-18 | Replace field without explicit mapping | Rejected |
| D1-19 | Private field sent to public projection/search | Rejected |
| D1-20 | Agent attempts definition activation, adjudication or publication | Rejected |
| D1-21 | Completeness score used as verification status | Rejected |
| D1-22 | Deeni Madaris definition/projection path | Existing default-OFF enforcement retained |
| D1-23 | Duplicate concurrent definition/value command | Idempotent, auditable result |
| D1-24 | Historical claim loaded after a new definition version | Interpreted using its originally bound definition version |

Fixtures must be entirely fictional and synthetic. No real institution data, source URLs, people or contact details are required.

## 16. D1 outputs and remaining D2 decisions

D1 establishes the logical contract. D2 must now decide:
- physical registry representation and version storage;
- exact relationship between field definition version and claim version (foreign key, immutable mapping record or another explicit durable association);
- whether registry tables are required and their minimum normalized structure;
- transaction/idempotency and concurrency boundaries;
- migration/backfill strategy for existing predicates;
- schema portability and query/index strategy;
- whether any field family requires specialized first-class entities;
- exact initial synthetic pilot scope.

No database migration or application implementation follows automatically from this document.

## 17. Authorization and safety boundary

This D1 package is documentation/design only. It does not authorize:
- schema or migration changes, application code, UI or dynamic CRUD;
- source browsing, scraping, API calls, institution contact or real data collection;
- AI model, connector, crawler, agent or scheduler activation;
- production, V1, Hostinger/hPanel, live database, deployment or public release;
- procurement, paid service or additional spend.

Existing M3-07 G2-G9 gates remain blocking for any external source access or agent activation. A separate explicit bounded authorization is required for local/CI-only field-registry implementation. Human review and publication controls remain mandatory.
