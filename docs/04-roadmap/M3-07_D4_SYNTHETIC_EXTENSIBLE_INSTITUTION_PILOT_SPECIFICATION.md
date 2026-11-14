# M3-07 D4 — Synthetic Extensible-Institution Pilot Specification

**Date:** 2026-11-14  
**Repository:** mattari20/listing-v2  
**Depends on:** D1 Field Registry Contract; D2 Field Registry Storage Decision; D3 Field-Aware Claim Service Boundary; existing M3-03/M3-04 governance  
**Status:** Synthetic test-design specification only. No application implementation, schema change, source access or agent activation is authorized.

## 1. Purpose and boundary

D4 defines a deterministic, entirely fictional pilot that exercises the proposed extensible institution-information architecture before any implementation decision. It tests whether one governed field registry and the existing claim/evidence/review/publication lifecycle can support different provider types, campus/programme scopes, changing information and controlled field lifecycle operations.

The pilot is not a representative sample of real Pakistani institutions and must not be populated from real websites, registers, social accounts, maps, prospectuses or other real-world records. All names, identifiers, locations, contacts, dates, prices, source assets, evidence and events below are synthetic placeholders.

D4 authorizes only documentation and later design review. It does not authorize code, migrations, schema changes, UI, scraping, browsing, source contact, external APIs, models, connectors, schedulers, production, deployment, new spend or public release.

## 2. Pilot objectives

The synthetic pilot must demonstrate:

1. One extensible field registry can serve different institution categories without one database column per optional field.
2. Stable institution identity remains distinct from campuses, programmes, delivery sites and relationships.
3. A field definition controls type, cardinality, scope, provider applicability, privacy, evidence, freshness, visibility and search eligibility.
4. Field values use the existing claim/version/evidence/adjudication/publication/audit lifecycle.
5. A value can be proposed, corrected, withdrawn and restored only through governed actions.
6. A field definition can be proposed, reviewed, approved, activated, superseded and retired independently of individual values.
7. A field's retirement does not silently delete or withdraw institution values.
8. Different profile templates can expose appropriate optional sections without implying completeness or recognition.
9. Only approved/current/non-suppressed facts enter public projections and explicitly allowlisted search facets.
10. Agent-like synthetic proposals cannot define fields, adjudicate, publish or bypass human review.

## 3. Fictional provider fixtures

Use stable reserved fixture identifiers such as `SYN-PROV-001`; do not use real institution names or real contact details.

| Fixture | Provider category | Fictional structure | Intended coverage |
|---|---|---|---|
| SYN-PROV-001 | Private school | One institution, two campuses, primary and secondary sections | Grades, academic calendar, admissions, fee schedule, facilities, contact channels |
| SYN-PROV-002 | College | One institution, one main campus, two academic departments and three programmes | Affiliation relationship as a synthetic claim, programme details, eligibility, duration, admissions and fees |
| SYN-PROV-003 | Academy/coaching provider | One provider, two delivery sites, several short courses | Course catalogue, schedule, delivery mode, fees, facilities and contact |
| SYN-PROV-004 | University | One institution, two campuses, two faculties and multiple programmes | Campus-scoped facilities, programme-scoped eligibility/duration, admissions, fee schedule, scholarships and official contact |

The fixtures must include deliberately incomplete profiles. No fixture is presumed registered, recognised, accredited, licensed or affiliated merely because it exists in the test directory. Any regulatory/affiliation assertion must use a separately typed synthetic authority relationship and evidence fixture, with a clear synthetic status label.

### 3.1 Entity and relationship graph

Create only synthetic entities and explicit typed relationships:

- each provider has a stable institution entity;
- SYN-PROV-001 has Campus A and Campus B, each linked to the same institution;
- SYN-PROV-002 has one campus, two departments and three programmes;
- SYN-PROV-003 has two delivery sites and multiple course offerings;
- SYN-PROV-004 has two campuses, two faculties and programme records assigned to an explicit campus/faculty scope;
- the college may have a synthetic affiliation assertion to a fictional awarding/affiliating body, but the relationship must not be conflated with recognition or accreditation;
- the university may have a synthetic authority-status assertion, but its scope and effective dates must be explicit.

Reject implicit relationships based only on matching names. Include one ambiguous duplicate candidate and require human adjudication rather than automatic merge.

## 4. Synthetic source and evidence fixtures

Represent sources as local fixture identifiers, not fetchable URLs:

- `SYN-SRC-INSTITUTION-001`: fictional school prospectus revision 1 and revision 2;
- `SYN-SRC-INSTITUTION-002`: fictional college programme catalogue;
- `SYN-SRC-INSTITUTION-003`: fictional academy course/fee notice;
- `SYN-SRC-INSTITUTION-004`: fictional university admissions and fee schedule;
- `SYN-SRC-AUTHORITY-001`: fictional authority-register extract used only for a synthetic status/affiliation case.

Each evidence object must carry a synthetic marker, fixture source ID, document/page/section locator, observed date, published/effective date where supplied, source class, permitted-use fixture state and immutable content fingerprint. These fixtures must never contain live URLs or instructions to retrieve a source.

Provide source-authorization fixtures in three states: active synthetic authorization, expired authorization and revoked authorization. They are test inputs only and grant no real-world permission. Proposals tied to expired or revoked fixtures must fail closed.

## 5. Field registry seed catalogue

Use stable field keys and versioned definitions. The following is a minimum pilot catalogue, not a final national taxonomy.

| Field key | Value type | Scope | Applicability | Cardinality | Public/search intent |
|---|---|---|---|---|---|
| `institution.display_name` | short_text | institution | all four categories | one | public; exact-name search |
| `institution.official_website` | url | institution | all four categories | zero_or_one | public only after review; not a source permission |
| `institution.public_contact_email` | institutional email | institution | all four categories | zero_or_one | public if explicitly approved; no personal mailbox |
| `institution.public_phone` | institutional phone | institution | all four categories | zero_or_one | public if explicitly approved |
| `campus.public_address_label` | short_text | campus | all four categories | zero_or_one | public display; no private residence |
| `campus.facility_tags` | enum | campus | school, college, academy, university | many | allowlisted public filter only if approved |
| `school.grade_range` | bounded_collection | institution/campus | private school | one | public display; filter only after policy review |
| `academic.academic_year` | short_text | institution | school, college, university | zero_or_one | public display; freshness-sensitive |
| `admissions.application_deadline` | date | programme/intake | school, college, academy, university | zero_or_one | public display; expiry/freshness required |
| `admissions.eligibility_summary` | long_text | programme/intake | college, academy, university | zero_or_one | public display; not search by raw text |
| `programme.duration_months` | integer | programme | college, academy, university | zero_or_one | public display; bounded validation |
| `programme.delivery_mode` | enum | programme/course | college, academy, university | many | allowlisted filter |
| `fees.tuition_amount` | money | programme/intake | school, college, academy, university | zero_or_one | public only with currency/session/effective period |
| `fees.admission_charge` | money | institution/programme/intake | all four categories | zero_or_one | public only with currency/session/effective period |
| `scholarship.availability` | boolean | institution/programme/intake | college, university | zero_or_one | public display; false distinct from unknown |
| `scholarship.summary` | long_text | programme/intake | college, university | zero_or_one | public display after review |
| `campus.library_available` | boolean | campus | school, college, university | zero_or_one | public display |
| `campus.laboratory_tags` | enum | campus | school, college, university | many | public display/filter only if approved |
| `institution.profile_note_internal` | long_text | institution | all four categories | zero_or_one | internal only; never public/search |

Every definition must additionally specify provider/entity applicability, value constraints, units/currency, locale, effective-time rules, freshness/expiry policy, privacy class, evidence policy, visibility, search/sort/filter flags, lifecycle and reviewer/approver capabilities. No public/search behavior may be inferred from the table alone.

Do not seed student, applicant, teacher or owner personal data; identity numbers; marksheets; credentials; health data; private contact details; or private addresses. Internal notes must be synthetic and non-sensitive.

## 6. Provider-specific profile templates

Templates are presentation/configuration rules, not separate storage systems:

- **School:** identity, grade range, campuses, admissions, academic year, fee information, facilities and public contacts.
- **College:** identity, affiliation/status claims where applicable, departments, programmes, eligibility, duration, admissions, fees and campus facilities.
- **Academy:** identity, delivery sites, short courses, delivery mode, schedules, fees and public contacts. Do not imply degree-awarding authority.
- **University:** identity, campuses, faculties, programmes, admissions, eligibility, fees, scholarships, facilities and competent authority/status claims where applicable.

Each template must support optional sections and fields. A field absent from a template is not necessarily unsupported; a field shown as empty is not evidence that the institution lacks that service. Profile completeness must be computed separately from verification, confidence and recognition status.

## 7. Required end-to-end scenarios

### S01 — Initial field definition lifecycle
Propose a new synthetic field definition `school.grade_range` version 1. Validate key uniqueness, type, scope, provider applicability, privacy, evidence, freshness and projection policy. A distinct human reviewer reviews it; a separate authorized human approves and activates it. The proposal actor cannot approve its own definition.

**Expected:** immutable definition version and audit trail; no institution value is created by activating the field.

### S02 — Valid value proposal
Propose a grade range for SYN-PROV-001 using the active synthetic source fixture and an institution-scoped or campus-scoped subject as specified by the definition.

**Expected:** exact definition-version binding, typed validation, evidence link, proposed claim/version and audit/outbox record; value remains unpublished pending human review.

### S03 — Provider applicability rejection
Attempt to attach `school.grade_range` to SYN-PROV-003 (academy).

**Expected:** rejected with safe reason code; no claim, claim version, evidence link or projection mutation.

### S04 — Scope mismatch rejection
Attempt to attach a campus-only facility value to an institution entity, or a programme deadline to a campus without a programme/intake relationship.

**Expected:** rejected; caller cannot override scope with arbitrary metadata.

### S05 — Type/cardinality validation
Submit a text string where a date is required, a negative duration, a malformed money object, duplicate enum values where disallowed, and a second value for a single-cardinality field.

**Expected:** deterministic rejection; no partial write.

### S06 — Fee value with temporal context
Propose a tuition amount with currency, academic session, effective date, source date and expiry/freshness metadata.

**Expected:** amount is never presented without its required context; expired values leave the current projection according to policy and remain historically traceable.

### S07 — Correction and successor version
Correct the school fee or university admission deadline using a later synthetic evidence revision.

**Expected:** new successor claim version, exact new definition binding, preserved prior version/evidence/audit, rationale and renewed review; no in-place overwrite.

### S08 — Withdraw one value
Withdraw one synthetic public phone value using the required human capability, reason and review path.

**Expected:** only the targeted value is removed from eligible current projection after governed approval; other institution/campus contacts remain unaffected; history/audit is retained.

### S09 — Restore a withdrawn value
Restore only where the existing lifecycle supports a valid restoration decision and the underlying evidence/source basis remains admissible. Otherwise create a new proposal rather than silently resurrecting an old assertion.

**Expected:** explicit restoration decision, actor, reason and audit; no bypass of review/publication.

### S10 — Retire a field definition
Retire a test-only optional field after its effective date and provide a successor mapping where relevant.

**Expected:** no new proposals after retirement; existing claims/evidence are not automatically deleted or withdrawn; projection treatment follows an explicit migration/visibility decision.

### S11 — Definition version change
Create version 2 of a field with a changed validation rule or label.

**Expected:** historical claim versions retain version 1 binding and interpretation; new proposals use version 2 after activation; no silent reinterpretation/backfill.

### S12 — Source authorization expiry/revocation
Attempt proposals using expired and revoked synthetic authorization fixtures.

**Expected:** fail closed for affected processing; existing approved facts are not falsely marked changed/closed; the system records a safe blocked reason.

### S13 — Conflicting evidence
Provide two incompatible synthetic fee or affiliation assertions from different synthetic source classes.

**Expected:** preserve both candidates and provenance; route to human adjudication; do not average, choose by model confidence or publish automatically.

### S14 — Duplicate institution candidate
Create two similar synthetic names with insufficient evidence to determine identity.

**Expected:** candidate match only; no automatic merge or transfer of values/relationships.

### S15 — Search/projection allowlist
Attempt to expose `institution.profile_note_internal`, raw eligibility prose and unapproved fee values in public projection/search facets.

**Expected:** internal/unapproved fields are excluded; only explicitly allowlisted, approved/current values are projected; public filters cannot be generated dynamically from arbitrary fields.

### S16 — Missing-state semantics
Represent unknown, not supplied, not applicable, pending review, expired, disputed and withdrawn separately from false, zero, empty string or empty collection.

**Expected:** UI/profile and tests preserve each meaning; absence is never converted into a negative assertion.

### S17 — Agent proposal-only boundary
A deterministic fake agent adapter submits a valid proposal within an approved synthetic fixture scope, then attempts to create a field, activate a definition, review, adjudicate, publish, withdraw, retire or erase.

**Expected:** only the bounded proposal action is accepted; all privileged actions are denied and audited. No external model is called.

### S18 — Generic claim bypass
Call the generic claim-registration path directly with a registry-managed predicate and untrusted caller-supplied “validated” metadata.

**Expected:** rejected unless invoked with a trusted field-aware validation context; unknown predicates fail closed; finite legacy/specialized predicates retain their approved domain path.

### S19 — Atomicity and idempotency
Repeat an identical proposal with the same idempotency key; then reuse the key with a different actor or payload. Inject failures between claim, evidence, audit and outbox writes.

**Expected:** same command returns same logical result; conflicting reuse is rejected; transaction leaves no partial records.

### S20 — Deeni Madaris default-OFF
Attempt to add a synthetic provider in the restricted category to public template/search.

**Expected:** existing default-OFF policy remains enforced; no category activation through D4.

## 8. Synthetic data matrix and minimum coverage

The test suite should cover all four provider fixtures, at least two campus/site scopes, at least three programme/course scopes, all field value types selected for the pilot, single and multiple cardinality, each lifecycle transition, each authorization state, public/internal visibility and current/expired evidence.

Use deterministic fixtures and fixed clock values. Avoid random values, current-time dependencies, network access and nondeterministic model outputs. Every fixture must be labeled synthetic in its data and test metadata.

## 9. Acceptance criteria

D4 is considered design-complete only when reviewers can trace each requirement to a scenario and expected outcome:

- **AC-01:** Four distinct provider categories are represented without conflating type and recognition status.
- **AC-02:** Institution, campus, delivery site, department/faculty and programme scopes are distinguishable.
- **AC-03:** Field definitions are versioned, immutable once activated and independently governed.
- **AC-04:** Field applicability, type, cardinality, privacy, temporal and evidence constraints are testable.
- **AC-05:** New values use the existing claim/evidence/governance lifecycle and bind to the exact definition version.
- **AC-06:** Correction preserves history; withdrawal is value-specific; restoration is explicit; retirement does not delete values.
- **AC-07:** Generic registration cannot bypass field-aware validation.
- **AC-08:** Only approved/current/non-suppressed/allowlisted data reaches public profiles and search.
- **AC-09:** Completeness, verification, recognition and freshness remain separate concepts.
- **AC-10:** Synthetic agent has proposal-only authority; all privileged actions are denied.
- **AC-11:** Source expiry/revocation, conflicts, duplicate identity and missing-state semantics fail safely.
- **AC-12:** Atomicity, idempotency, concurrency and audit behavior are deterministic.
- **AC-13:** All tests run offline against synthetic fixtures and fake adapters.
- **AC-14:** No real institution/student/provider data, external source/API/model, production system or new spend is used.

## 10. Out of scope and stop conditions

D4 does not choose a live source, authorize collection, set production freshness targets, select an AI provider/model, approve a budget, establish legal conclusions, or approve agent activation. It does not implement dynamic field CRUD, admin screens, migrations, database tables, claim services or search changes.

Stop and seek a separate decision if implementation would require:
- changing existing production or V1 data;
- accessing real provider or student information;
- retrieving or storing material from a real source;
- external APIs, model inference, connectors or scheduled jobs;
- new infrastructure, paid services or spend;
- weakening source authorization, human review, evidence, audit, suppression or publication controls;
- enabling Deeni Madaris or any restricted category.

## 11. Next decision after D4

After review of D1-D4, prepare a separate D5 implementation-readiness and bounded authorization proposal. D5 must identify the smallest local/CI-only slice, exact files/tables/services in scope, migration rollback strategy, test commands, acceptance gates and explicit non-actions. No schema or application implementation begins until the owner separately approves that bounded package. G2-G9 remain blocking for real source access and live agent activation.

## 12. Binding safety statement

This document uses fictional data and describes tests only. No code, schema, migration, UI, production operation, source access, external API/model/connector/scheduler, procurement, deployment or additional spend has been performed or authorized. Human review, adjudication and publication remain mandatory.
