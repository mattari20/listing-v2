# M3-03 Agenda 1 — Logical Domain Model and Governance Work Package

**Repository:** `mattari20/listing-v2`  
**Agenda:** M3-03 — Core Data and Governance, Agenda 1  
**Status:** Work-package design complete; physical implementation not authorized  
**Baseline:** accepted M1 requirements and M2 architecture remain binding; M3-02 is accepted as Laravel platform foundation only  
**Execution boundary:** repository documentation and synthetic-only deterministic specification; no DB, persistence, real data, external services, hosting or spend

## 1. Purpose and decision

This package defines the logical information model and governance rules that must precede physical schema or application implementation. It is a design contract, not an ORM model, database schema, migration, repository, service, API or production workflow.

The model is designed around the M3 roadmap outcome: preserve evidence provenance, human publication controls, privacy/minor safeguards, low-bandwidth anonymous discovery and Deeni Madaris suppression. Public output must be derived only from approved publication state. Unknown, conflicting, stale and unverified information must remain distinguishable.

**Decision:** adopt the logical concepts and invariants in this document as the M3-03 design baseline for subsequent Product Owner review. Do not infer that physical implementation has been authorized.

## 2. Design principles and invariants

1. **Separate real-world subjects from assertions about them.** An institution is not the same thing as a claim about its name, status, location or affiliation.
2. **Evidence is not truth.** Evidence supports or contradicts a claim; it does not itself publish or establish a fact.
3. **Authorization precedes acquisition and use.** A source/evidence reference may be handled only under a recorded, applicable authorization. This package contains synthetic metadata only and grants no source permission.
4. **Preserve history.** Claims, evidence links, validation outcomes, adjudications and publication decisions are append-only logical events. Corrections supersede; they do not silently overwrite.
5. **Model time explicitly.** Distinguish when a fact is asserted to be true in the world (valid time) from when the system learned or recorded it (recorded time).
6. **Conflicts are first-class.** Conflicting, stale, incomplete or unverified claims are not silently collapsed into a single value.
7. **Human adjudication controls publication.** Automated validation may flag, rank or route claims; it cannot independently approve publication.
8. **Publication is a separate, versioned projection.** Internal claims and evidence never become public merely because they exist.
9. **Privacy by minimization.** No student, child, staff personal profile, contact detail or sensitive personal data is required by this core institute model.
10. **Deeni Madaris remain suppressed by default.** No public exposure until the required explicit policy decision and cross-surface enforcement are separately evidenced.
11. **Anonymous discovery is a downstream read concern.** The core model does not require a public user account or precise user location.
12. **Provider, institution, campus/site, programme and authority are distinct concepts.** They must not be merged into a generic “school” record.

## 3. Logical bounded context

The model has five conceptual areas:

- **Directory identity:** Provider, Institution, Campus/Delivery Site, Programme, Authority and typed relationships.
- **Assertion and provenance:** Claim, Claim Version, Evidence Reference, Source Authorization and Claim-Evidence Link.
- **Quality and adjudication:** Validation Run, Validation Finding, Conflict, Adjudication Case and Adjudication Decision.
- **Governance and history:** Audit Event, Correction, Withdrawal and policy decision.
- **Publication:** Publication Decision, Publication Snapshot and Public Projection.

These are logical concepts only. They do not prescribe tables, columns, indexes, foreign keys, ORM classes or storage technology.

## 4. Entity and relationship glossary

| Concept | Meaning | Key rules |
|---|---|---|
| Provider | A legal, administrative or operating organization that provides or coordinates education services | May operate or administer multiple institutions/sites; not synonymous with regulator |
| Institution | A named education institution or organizational unit represented in the directory | Has a stable internal identity; can have multiple sites and programmes |
| Campus / Delivery Site | A physical or delivery location associated with an institution | Address/location claims are separately evidenced and time-bounded; avoid precise public coordinates by default |
| Programme | A structured course of study/training catalogued by an institution and offered at one or more sites | Distinct from a qualification/award; campus availability is expressed through a cycle-scoped offer |
| Qualification | An award, credential or level resulting from successful study/assessment | May be issued by a body other than the teaching provider |
| Awarding Body | Entity legally/officially responsible for issuing a qualification | Distinct from teaching provider, regulator and recognizing authority |
| Admission Cycle | Named intake/session/window for a programme or campus | Eligibility, deadlines and fees may vary by cycle |
| Programme Offer | A programme's availability at a campus for a specific admission cycle | A general programme catalogue entry is not proof of current campus availability |
| Fee Component | A named charge with amount, currency, frequency, applicability and effective period | Do not collapse one-time and recurring costs or unscoped totals |
| Scholarship / Aid Offer | Financial support with eligibility, coverage, value, period and conditions | Advertised availability is not a guaranteed award |
| Authority | A regulator, accreditor, examining body, government department or other authority | Authority relationship type and scope must be explicit; affiliation is not inferred from a name similarity |
| Entity Relationship | A typed, time-bounded relationship between two directory entities | Examples: operates, owns, administers, affiliated_with, recognized_by, delivers_at; relationship itself requires evidence and review |
| Claim | A normalized assertion about an entity or relationship | Has a predicate, value, subject, valid-time interval, recorded-time and status; never overwrite history |
| Claim Version | An immutable revision of an assertion | Supersedes a prior version while retaining the earlier version and reason |
| Evidence Reference | A minimal reference/metadata record describing evidence relevant to a claim | Content is quarantined/out of scope here; requires authorization, provenance and integrity metadata before any later acquisition |
| Source Authorization | A scoped permission record governing a source family, purpose, method, territory, time and permitted use | Must be explicit, current, reviewable and revocable; no blanket authorization |
| Claim-Evidence Link | A typed relation between a claim version and evidence reference | Supports, contradicts, qualifies or contextualizes; evidence may support multiple claims |
| Validation Run | A deterministic execution of named validation rules against a defined claim version and fixture/input set | Records rule-set version, inputs, outcome and findings; not a publication decision |
| Validation Finding | A machine-checkable result such as missing evidence, invalid interval, unauthorized source or conflicting value | Must be reproducible and attributable to a rule version |
| Conflict | A detected incompatibility between two or more claims/versions | Retains all competing claims; no silent “latest wins” rule |
| Adjudication Case | A human-review container for a conflict or high-impact/exceptional claim | Has assigned role, status, evidence set, rationale and resolution history |
| Adjudication Decision | A human decision to accept, reject, qualify, defer or request further evidence | Must identify decision-maker role, rationale, timestamp, scope and affected versions |
| Audit Event | An immutable record of a material governance action | Includes actor class, action, target, timestamp, reason/reference and correlation; avoid unnecessary personal data |
| Publication Decision | A human-authorized decision to publish, retain, correct, withdraw or suppress a defined set of approved claim versions | Must include policy checks and effective time |
| Publication Snapshot | A versioned, reproducible set of approved public facts at a point in time | Contains only allowlisted public fields; supports rollback to a prior snapshot |
| Public Projection | A read-only, anonymous-safe representation generated from an approved snapshot | Must never read directly from unreviewed claims or evidence |

### Relationship cardinalities (logical)

- Provider 1 — 0..N Institution; an institution may have 0..N provider relationships over time.
- Institution 1 — 0..N Campus/Delivery Site.
- Institution 1 — 0..N Programme catalogue entries.
- Programme 0..N — 0..N Qualification; Awarding Body 1 — 0..N Qualifications.
- Campus 0..N — 0..N Programme Offers; each Programme Offer is scoped to one campus, one programme and one Admission Cycle.
- Admission Cycle 1 — 0..N Programme Offers; each Programme Offer may have 0..N Fee Components and 0..N Scholarship/Aid Offers.
- Authority 0..N — 0..N Institution through a typed, evidenced, time-bounded relationship.
- Any directory entity 1 — 0..N Claims; each claim has exactly one subject and one predicate/value assertion.
- Claim Version 1 — 0..N Claim-Evidence Links; Evidence Reference 1 — 0..N links.
- Claim Version 1 — 0..N Validation Runs; a run yields 0..N Findings.
- Conflict 1 — 2..N conflicting claim versions.
- Adjudication Case 1 — 1..N decisions/events; one current disposition may be active while prior decisions remain historical.
- Publication Snapshot 1 — 1..N approved claim versions; each published fact must trace to an approved snapshot and decision.
- Every material state transition emits an Audit Event.

## 5. Claim and temporal-fact contract

A claim version is logically described by:

- subject reference and subject type;
- predicate from a controlled vocabulary;
- typed value (or explicit unknown/withheld state);
- language/locale where relevant;
- valid-from and valid-to (world validity; either bound may be unknown);
- recorded-at and superseded-at (system history);
- assertion status: proposed, needs_evidence, under_review, accepted, rejected, disputed, stale, withdrawn;
- confidence is optional and must never replace evidence or human decision;
- provenance links and validation state;
- correction/supersession reason.

**Temporal rules:**
- Valid intervals are half-open: `[valid_from, valid_to)`; end must be later than start when both are known.
- Unknown time is represented as unknown, not fabricated from ingestion time.
- Recorded time is system-controlled and immutable.
- A later recorded claim does not automatically invalidate an earlier valid-time claim.
- Overlapping claims with incompatible values create a conflict unless the predicate explicitly permits multiple simultaneous values.
- A correction creates a new version and a supersession link; it does not mutate the historical assertion.
- “Current” is a derived view requiring explicit valid-time and status rules, not a stored magic flag.

## 6. Provenance and source authorization contract

Each evidence reference must carry, at minimum, the following logical metadata before any later authorized acquisition or processing:

- stable evidence-reference identifier;
- source-family identifier and source type;
- source authorization identifier and authorization status;
- permitted purpose, acquisition method, territory/jurisdiction, validity window and permitted reuse/retention;
- reference locator or internal reference (not source content in this package);
- observed/published date where known, and recorded-at timestamp;
- collector/actor class and acquisition process/version where applicable;
- integrity digest and media/type metadata where content handling is later approved;
- chain-of-custody events, quarantine status and deletion/withdrawal state;
- linked claim versions and relationship type (supports, contradicts, qualifies, contextualizes).

**Authorization gate:** no evidence may be acquired, fetched, scraped, downloaded, copied, transformed, stored, reused or republished unless a separately approved source-specific authorization covers that exact activity. This package performs none of those activities.

**Provenance invariant:** every accepted claim must have at least one admissible evidence path or an explicitly approved exception with a recorded human rationale. A claim with no admissible evidence cannot become publishable.

## 7. Deterministic validation contract

Validation is versioned, repeatable and side-effect-free. Given the same rule-set version and same synthetic input, it must produce the same findings.

Minimum rule groups:

- identity: subject exists in the logical fixture set; entity type and relationship endpoints are compatible;
- vocabulary: predicate and relationship types are controlled and recognized;
- temporal: interval ordering, valid-time overlap and supersession consistency;
- provenance: evidence link exists, authorization is applicable/current, evidence is not withdrawn, integrity/reference metadata is present when required;
- conflict: incompatible concurrent assertions are flagged, not silently resolved;
- policy: restricted categories and Deeni Madaris default-off suppression are enforced before publication;
- publication: only human-approved, accepted, non-stale, non-disputed claim versions enter a publication snapshot;
- audit: every material transition has an audit event and reason;
- privacy: no prohibited personal/child/staff attributes appear in the public projection;
- rollback: prior snapshots remain reproducible and a withdrawal/correction removes affected facts from the current projection without destroying history.

Validation can block or route. It cannot adjudicate or publish.

## 8. Human adjudication and publication state machine

### Claim lifecycle

`proposed → needs_evidence → under_review → accepted | rejected | disputed | deferred`

Accepted claims may later become `stale`, `superseded` or `withdrawn` through explicit events. Rejected/disputed claims remain in history and are not public.

### Adjudication case lifecycle

`open → assigned → evidence_review → decided | deferred | closed`

A decision must record: case, claim versions, evidence considered, outcome, rationale, actor role, decision time, policy/rule-set version and any conditions or expiry. Reversal is a new decision event, not an edit.

### Publication lifecycle

`not_eligible → eligible_for_human_decision → approved | suppressed | deferred`

After approval: `published → corrected | withdrawn | superseded`. Only a designated human editorial role may approve publication. Validation and automated agents cannot grant that role or perform the approval.

### Separation of duties

- A source collector may submit evidence but cannot alone approve a high-impact claim and publish it.
- Automated validation may flag but cannot decide a contested fact.
- Publication approval is separate from claim acceptance.
- The system must preserve who/what class acted and why without requiring unnecessary personal data in the domain record.

## 9. Audit, correction, withdrawal and rollback

Audit events are append-only and cover at least: authorization grant/revocation; evidence intake/quarantine/release/deletion; claim creation/version/supersession; validation; conflict creation; adjudication assignment/decision/reversal; publication approval/suppression; publication/correction/withdrawal; snapshot creation/rollback; policy changes.

Correction flow:
1. Record the correction request or new contradictory evidence.
2. Preserve the currently published snapshot while the case is triaged, unless an urgent safety/privacy suppression rule requires immediate removal.
3. Open or update a conflict/adjudication case.
4. Record a new claim version and validation outcome.
5. Obtain human adjudication and a separate publication decision.
6. Generate a new snapshot; retain prior snapshot and link the correction reason.
7. Verify public projection no longer exposes withdrawn or superseded facts.
8. Retain audit lineage according to a separately approved retention policy.

Withdrawal flow:
- suppress affected public facts promptly under the approved withdrawal policy;
- preserve minimum non-public audit lineage where legally/operationally permitted;
- mark evidence authorization and content-handling status appropriately;
- never treat withdrawal as proof the historical claim was false.

Rollback restores a prior approved snapshot as a new recorded publication event; it does not erase intervening audit events or claim history.

## 10. Publication allowlist and prohibited data

Public projection may include only explicitly approved, low-risk directory attributes such as institution display name, approved institution type/category, approved programme descriptors, broad locality and approved status/freshness indicators.

Public projection must exclude by default:
- student/child identities or records;
- staff personal contact details or personal profiles;
- personal phone numbers, private email, home addresses and exact residential coordinates;
- private source documents, raw evidence and internal reviewer notes;
- unadjudicated claims, conflict details and internal risk labels;
- credentials, access tokens or operational secrets;
- any field prohibited by applicable policy or an unresolved specialist gate.

Exact public fields, retention and lawful basis require later review before real data processing or release.

## 11. Synthetic fixture and deterministic test package

The companion `M3-03_SYNTHETIC_FIXTURES_AND_DETERMINISTIC_TEST_SPEC.md` defines fabricated records and expected outcomes. The fixtures are intentionally fictional and contain no real addresses, contact details, people, source URLs or institution names.

## 12. Traceability and unresolved gates

| Source / control baseline | M3-03 design response | Traceability |
|---|---|---|
| M1 SR-01; M2 AR-002 | Keep pathway/direct discovery independent; logical identity does not require a pathway profile | Direct |
| M1 SR-02; M2 AR-003; M2-S02 | Separate provider, institution, campus, delivery site and programme identities; typed relationships | Direct |
| M1 SR-03/SR-14; M2 AR-004/AR-024 | Manual locality remains viable; this model does not require precise location | Direct design constraint; geography details deferred to M3-06 |
| M1 SR-04/SR-07; M2 AR-005/AR-019 | Evidence-backed attributes, explicit unknown/stale/disputed/partial states; no null/zero/false coercion | Direct |
| M1 SR-05; M2 AR-008 | Preserve comparable units, scope and missing/stale/disputed states for later comparison | Direct design constraint; comparison UI deferred to M3-05 |
| M1 SR-06; M2 AR-006; M2-S02 | Programme, campus, admission cycle, programme offer, fee and scholarship are separately scoped; material facts retain evidence and time | Direct |
| M1 SR-07; M2 AR-007 | Distinguish official evidence, provider-submitted claims, AI-discovered candidates, estimates and opinions | Direct |
| M1 SR-08; M2 AR-009 | Official application/contact route remains external; no V2 application submission concept is introduced | Direct boundary |
| M1 SR-10; M2 AR-011 | Reviews are a separate post-launch user-opinion domain, not official evidence or proof of attendance | Direct boundary; implementation deferred |
| M1 SR-11/SR-12; M2 AR-021/AR-022 | Text-first, low-bandwidth and language/accessibility requirements remain presentation-level constraints; no language/UX assumptions embedded in facts | Direct boundary |
| M1 SR-13; M2 AR-012 | Minimize personal data; no student/child/staff personal record in the core directory model | Direct |
| M2-S02 | Preserve qualification vs programme, awarding body vs regulator, recognition vs affiliation, cycle-scoped offer, identity candidate and time/uncertainty semantics | Direct conceptual-model alignment |
| M2-S05; M2 AR-005–AR-007, AR-013–AR-015, AR-019, AR-023–AR-025 | Source rights before retrieval; evidence/assertion/publication separation; conflict, correction, withdrawal, rollback, audit and audience-scoped projection | Direct |
| M1 G01/G03/G05 | No national completeness inference; coverage, freshness, scope and missingness remain explicit | Direct |
| M1 G02/G16; M2 AR-013 | Source-specific authorization before acquisition/reuse; deny by default | Direct |
| M1 G07; V2-DEC-006; M2 AR-016–AR-018 | Deeni Madaris default-OFF across all public surfaces; no sect/maslak discovery attribute | Direct |
| M1 G08/G09/G14/G17; M2 AR-014/AR-015/AR-023 | AI is proposal-only; provenance, conflict and material governance actions are auditable and human-controlled | Direct |
| M1 G12–G15; M2 AR-011/AR-012 | Reviews remain post-launch; login is not attendance proof; privacy/minor safeguards remain mandatory | Direct |
| M1 G20; M2 AR-025 | Operational audit/recovery/rollback requirements are preserved as later gates, not claimed as implemented | Direct boundary |
| M3-02 accepted foundation | Design is persistence-agnostic and makes no schema, migration or runtime changes | Direct |
| M3 master step plan, M3-03 definition | Domain model, provenance, validation, audit, adjudication, publication, correction, withdrawal and rollback; no unauthorized source data | Direct |

**Canonical source references reviewed:** `docs/01-product/STUDENT_DISCOVERY_REQUIREMENTS.md`; `docs/01-product/INSTITUTION_AND_PROGRAMME_REQUIREMENTS.md`; `docs/01-product/COMPARISON_REVIEWS_AND_TRUST.md`; `docs/03-research/M1_S10_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`; `docs/03-research/M1_S10_FINAL_SYNTHESIS_CLOSEOUT_REVIEW_2026-11-12.md`; `docs/05-architecture/M2-S01_SYSTEM_REQUIREMENTS_AND_BOUNDARIES.md`; `docs/05-architecture/M2-S02_CORE_DOMAIN_CONCEPTUAL_MODEL.md`; `docs/05-architecture/M2-S05_DATA_ARCHITECTURE_PROVENANCE_PUBLICATION.md`; `docs/05-architecture/M2-S10_FINAL_ARCHITECTURE_SYNTHESIS_M3_ROADMAP.md`.

The canonical M1 and M2 files were subsequently located and reviewed. The crosswalk above maps the relevant M1 SR IDs, M1 G controls and M2 AR IDs. It is a focused M3-03 crosswalk, not a claim that every SR/AR requirement is implemented by this agenda.

### Unresolved gates (not completed by this package)

- Exact M1 requirement and M2 architecture ID crosswalk.
- Qualified legal/privacy/safeguarding/security review before applicable real-data, source, public or identity activity.
- Source-family authorization and rights review before any acquisition/reuse.
- Exact public field allowlist and retention/deletion policy.
- Independent human role coverage for sensitive adjudication, security certification and operations where required.
- Deeni Madaris policy decision and cross-surface default-off enforcement proof before any public surface.
- P04 V2 hosted runtime/isolation/capacity/recovery proof-of-fit.
- P06 hosted backup/restore, deployment and recovery evidence.
- Separate Product Owner authorization for physical schema/migrations, persistence, real data, external sources/services, hosting or deployment.

## 13. Non-goals and stop conditions

This package does not create:
- physical database schema, tables, columns, constraints, indexes or migrations;
- ORM models, repositories, services, APIs, controllers or persistence;
- seeders, production-like records or importers;
- scraping, source connectors, external APIs, AI agents or paid services;
- public pages, search, accounts, user research, pilot or launch.

Stop and seek a separate scope decision if a next action requires any excluded activity. This package's bounded authorization expires when this work package is accepted/closed or on any scope change.

## 14. Acceptance checklist

- [x] Logical concepts and relationships defined.
- [x] Entity glossary and cardinality rules defined.
- [x] Provenance/source-authorization contract defined.
- [x] Temporal validity and immutable claim-version rules defined.
- [x] Deterministic validation and conflict rules specified.
- [x] Human adjudication and publication separation defined.
- [x] Audit, correction, withdrawal and rollback rules defined.
- [x] Synthetic fixture/test specification companion prepared.
- [x] Unresolved gates and exclusions stated.
- [x] Focused M1 SR / M1 G / M2 AR crosswalk completed against canonical accepted source documents.
- [x] Internal design consistency review and synthetic fixture structural validation completed.
- [ ] Product Owner review of this work-package baseline — pending.


## 15. Alignment refinements from canonical M1/M2 source review

The canonical M2-S02 model also requires explicit distinction among Programme, Qualification, Awarding Body, Admission Cycle, Programme Offer, Fee Component and Scholarship/Aid Offer. These concepts and their cycle/campus scope have been incorporated in the glossary and cardinality rules above. Recognition, accreditation, licensing and affiliation remain distinct authority-scoped relationships. Identity candidates and ambiguous merges remain subject to human review. The M1-S01 requirements SR-01–SR-14 and relevant M1 G01–G20 controls are mapped in Section 12 to the corresponding M2 AR identifiers.
