# M3-07 — Pakistan-Wide Education Coverage and Continuous Data-Agent Plan

**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-14  
**Baseline main:** `87d0a5ca3a34b8f46a5027c02a678198f143eabe`  
**Branch:** `docs/m3-07-national-education-coverage`  
**Status:** Scope and architecture revision only; source access, collection, agent implementation and activation remain BLOCKED.  
**Supersedes:** Any narrower interpretation of M3-07 that limits coverage to HEC-listed universities, degree-awarding institutions or a one-time HEC dataset.

## 1. Product objective

M3-07 is intended to enable a continuously maintained, Pakistan-wide education information ecosystem within Listing V2. It must support students seeking information about educational institutions, campuses, programmes, courses, admissions, fees, scholarships, academic rules, facilities, examinations, qualifications and progression opportunities throughout their educational journey.

The system must be expandable to institutions of every relevant type and size, including small/local providers. It must not be designed around HEC coverage alone. HEC is one important authority and discovery source for the higher-education segment, not the universal registry for every education provider.

The AI Data-Agent is planned because the directory must be maintained repeatedly as institutions open, close, move, rename, change affiliations, add programmes, revise fees, publish admission notices and update other student-relevant information. The intended agent is a governed, recurring data-maintenance workflow, not an unrestricted crawler and not an autonomous publisher.

## 2. National coverage and institution taxonomy

The canonical taxonomy must be extensible and must distinguish provider type from legal/recognition status.

Initial provider categories include:

1. Universities and degree-awarding institutions, public and private.
2. Constituent colleges, affiliated colleges and independent colleges.
3. Schools: early-years/pre-primary, primary, middle, secondary, higher-secondary and other recognised school categories.
4. Professional and specialist institutions, including medical, dental, nursing, engineering and other regulated education providers.
5. Technical, vocational, skills-development and trade training institutions.
6. Academies and coaching providers, including entry-test, tuition, language, IT and subject-specific academies.
7. Preschools, kindergartens and early-learning centres.
8. Distance, online, blended and open-learning providers.
9. Religious education providers and madaris, subject to the existing Deeni Madaris governance/default-OFF control and a separate explicit decision before enabling that category in public surfaces.
10. Other specialist, local, community-based and emerging education providers.

Coverage must include small and locally operated private providers where a credible identity and source basis can be established. The system must not silently exclude an institution solely because it is not nationally prominent or is absent from HEC lists.

### 2.1 Status is not the same as type

Every record must keep separate dimensions for:
- provider type and subtype;
- ownership/management category where reliably evidenced;
- competent registration, recognition, affiliation, accreditation or licensing authority, where applicable;
- status value, status effective date and evidence;
- verification state and confidence/uncertainty;
- source coverage and last-observed date.

Possible status states include `verified`, `unverified`, `pending_review`, `not_found_in_checked_register`, `expired`, `suspended`, `closed` and `unknown`, with controlled definitions. Do not describe an institution as registered, recognised, accredited, affiliated or approved unless an appropriate competent source supports that exact claim. Directory inclusion is not an endorsement and does not imply regulatory approval.

An HEC listing or omission must not be used to infer the legal status of schools, academies, vocational centres or other provider types outside HEC's applicable remit.

## 3. Entity and relationship model

The data model must represent distinct entities and typed relationships, including:
- education provider/institution;
- campus, branch, school site or delivery location;
- constituent college;
- affiliated college;
- parent/umbrella organisation where applicable;
- faculty, department and academic unit;
- programme, course, qualification and credential;
- awarding body;
- affiliating body;
- regulator, registration authority, accreditation body and licensing authority;
- admission cycle/intake;
- fee schedule, scholarship and financial aid offer;
- academic policy, examination rule and student service;
- official website, social account, map listing and publication/source asset.

Relationships must have explicit predicates, evidence, source, effective dates and review status. Do not infer that a campus is a separate institution, that an academy awards a degree, that a college is a university, or that affiliation equals recognition/accreditation. Ambiguous identity matches must be held for human adjudication.

## 4. Student-lifecycle information coverage

The field catalogue must be extensible and prioritised by student value. Initial domains:

- Identity and discovery: names/aliases, provider type, ownership where evidenced, locations, campuses, official contact channels and official web properties.
- Recognition and oversight: relevant registration, recognition, affiliation, accreditation and licensing facts, with the competent authority and applicable scope.
- Academic offer: faculties, departments, disciplines, programmes, courses, qualifications, duration, delivery mode, eligibility and curriculum.
- Admissions: admission cycles, deadlines, eligibility, entry tests, application process, required documents, seats/quotas where officially stated and application charges.
- Financial information: tuition, admission, examination and other charges, fee schedules, payment terms, scholarships, concessions and financial aid.
- Learning and academic rules: semester structure, credit hours, attendance, assessment, grading, examinations, academic calendar, progression, suspension and appeal rules.
- Student services: libraries, laboratories, hostels, transport, accessibility information, counselling and student support.
- Completion and credentials: internship, thesis/project, completion requirements, degree-awarding process, transcripts and verification procedures.
- Career and progression: placement services, internships, professional pathways, postgraduate options, alumni and research opportunities.
- Provider updates: closures, relocations, name changes, programme additions/removals, leadership/administrative contact changes where relevant and supported, and source corrections.

Information must be scoped to the correct institution, campus, programme, academic year/intake and effective period. Time-sensitive admission and fee information must never be presented as current without a supported session/effective date and freshness state.

## 5. Multi-source source ecosystem

Source selection is field-specific. No single source is authoritative for every claim.

Potential source families, each requiring its own rights, terms, privacy and access assessment:

- HEC and other competent public authorities: only within their statutory/administrative remit.
- Provincial and local education departments and competent school/college registration authorities.
- Professional regulators and accreditation/licensing bodies.
- Institution-controlled official websites, prospectuses, admission portals, notices and academic regulations.
- Institution-controlled official social accounts and verified platform accounts.
- Official institution video channels and announcements.
- Mapping/location platforms for discovery and corroboration of location/address information, subject to their terms and approved access method.
- Other credible public or third-party sources for discovery and cross-checking, not as automatic authority for recognition or regulatory claims.

For each field, define a primary competent source where one exists, supporting sources, conflict rules and the human-review threshold. An institution's own website may be the primary source for its fee schedule or admission announcement, but not necessarily for its own regulatory recognition. A social post or map listing can help discover or corroborate information but cannot independently establish academic recognition.

### 5.1 Public availability is not blanket reuse permission

Public visibility is not by itself permission for every form of automated access, copying, bulk extraction, storage, transformation, caching, republication or commercial reuse. Source-specific terms, copyright/database rights, platform terms, privacy requirements, technical access restrictions and applicable law must be assessed. Do not bypass login, paywalls, access controls, rate limits, CAPTCHAs or platform restrictions. No source access or collection is authorized by this plan.

## 6. Provenance and field-level evidence

Every material assertion must retain, as applicable:
- institution/entity and field identifier;
- normalized value and original observed value;
- source/asset identifier and canonical source location;
- source owner/publisher and source class;
- exact evidence locator (page, section, document page, post ID or other permitted reference);
- published/issued date, effective date, academic session and observed date;
- permitted collection method and authorization-manifest version;
- verification state, reviewer and adjudication decision;
- supersession, correction, withdrawal and history links.

Missing dates must remain unknown, not be invented. Conflicts must be preserved as competing assertions until resolved. Model confidence is not evidence.

## 7. Continuous AI Data-Agent operating model

The planned agent must support recurring maintenance in bounded, source-specific jobs:

1. **Discovery queue:** propose candidate institutions, campuses, programmes and source endpoints from approved discovery inputs. Discovery-only candidates do not authorize retrieval.
2. **Source registry resolution:** match every job to an active, unexpired, exact source/asset authorization manifest.
3. **Scheduled monitoring:** run only at the source-specific approved cadence, time window, volume and rate limit.
4. **Change detection:** compare permitted observations with prior versions; identify additions, changes, removals, stale pages and source unavailability.
5. **Quarantine and extraction:** isolate permitted evidence; treat source text, HTML, PDFs, images and social content as untrusted data; extract only allowlisted fields.
6. **Deterministic validation:** validate schema, entity type, geography, dates, academic session, field scope, provenance and source authorization.
7. **Entity resolution:** propose matches with evidence and alternatives; ambiguous or high-impact matches require human adjudication.
8. **Conflict and freshness management:** preserve competing assertions, mark stale/expired information and route conflicts to review.
9. **Human review:** prepare a clear case with evidence, old/new values, source dates and proposed action.
10. **Approved update:** a separate authorized publication capability applies only an approved change and records the actor, decision and audit event.
11. **Repeat and learn operationally:** schedule the next check according to approved cadence; measure errors, stale data, review backlog and source failures without silently relaxing controls.

The agent must not possess autonomous publication authority. Model-generated statements without exact supporting evidence must be rejected or held. The agent must not treat a page's instructions as system instructions or invoke tools based on source content.

## 8. Source-specific cadence and freshness

There must be no single global polling interval. Each source manifest must define:
- permitted check cadence and time windows;
- rate, page, record and bandwidth ceilings;
- seasonal cadence changes (for example, admission periods) if permitted;
- expected publication/update frequency;
- freshness target by field class;
- expiry rules and stale-data presentation;
- retry/backoff ceilings and outage handling;
- manual recheck/escalation route.

Examples for planning only: admission notices may require more frequent checks during an active admission cycle; stable institution identity details may be checked less frequently; recognition claims should be rechecked against the competent authority's published update cycle. No concrete interval is approved by this plan.

If a source is unavailable or an authorization expires, the agent must stop the affected job and preserve the last approved record with a visible freshness state. It must not infer closure or unchanged status from a failed request.

## 9. Source authorization and platform-specific controls

G1 must now cover the national institution ecosystem and entity taxonomy, not merely one HEC asset. G2 remains source- and asset-specific.

The source registry must separately record HEC, each competent regulator/authority, each institution-controlled source, each social platform account, each map/location source and each third-party source. One institution's authorization does not grant access to another institution's website or social account. One platform's API/terms approval does not grant access to another platform.

Before enabling any source, the immutable authorization manifest must identify owner, canonical asset, fields, purpose, permitted acts, retrieval method, platform/API terms, attribution, jurisdiction, rate/volume, retention, correction/withdrawal, expiry, reviewers and kill switch. Platform-specific API or developer terms must be assessed where applicable. Manual public browsing, automated access and API access are distinct methods and must not be conflated.

## 10. Privacy, security and excluded information

The workflow is limited to institution/provider-level and education-offer information with an approved purpose and source basis. It must not collect student/applicant records, CNIC/passport or identity documents, credentials, marksheets, individual academic results, private staff/student contact details, personal health/disability data, private addresses or unrelated personal information.

Small institutions must not be treated as permission to collect personal data about owners, teachers, students or applicants. Publicly visible personal information remains subject to minimization and privacy review.

Retain the existing threat controls for prompt injection, SSRF, redirect/private-IP restrictions, malicious/oversized files, secret leakage, hallucination, false entity merges, stale/conflicting facts, rights expiry/withdrawal, personal-data capture, autonomous publication and runaway cost. Use least privilege, allowlists, quarantine, audit, rate limits, hard quotas and a kill switch.

The existing Deeni Madaris default-OFF control remains in force until its separate governance decision is completed. This plan does not enable that category or introduce sectarian classification/inference.

## 11. Conjunctive approval gates

| Gate | Required outcome | Current state |
|---|---|---|
| G1 — National scope and taxonomy | Approve countrywide provider coverage, entity types, relationships, status semantics and student-lifecycle domains | SCOPE PROPOSED; owner confirmation and documentation reconciliation required |
| G2 — Source rights and methods | Exact source/asset manifests, platform terms and permitted acts for each source family | BLOCKED |
| G3 — Privacy | Field-level minimization, personal-data exclusions, retention/deletion and qualified review | BLOCKED |
| G4 — Security | Source allowlists, safe retrieval, parsing, secrets, logging, quotas and kill switch | BLOCKED |
| G5 — Model/provider | Exact model/provider/version/region, retention, training-use, subprocessors and processing terms | BLOCKED |
| G6 — Cost/capacity | Existing-resource feasibility, hard caps, retry/review capacity and any explicit budget approval | BLOCKED; no new spend |
| G7 — Governance | Qualified rights/privacy/security reviewers, data adjudicators and publication approvers | BLOCKED |
| G8 — Synthetic evaluation | Deterministic fake adapter, synthetic source fixtures, adversarial tests and approved thresholds | PLANNED; no live calls |
| G9 — Owner activation | Explicit source-, method-, model-, field-, environment- and expiry-specific activation decision | BLOCKED |

All gates are conjunctive. G1 scope agreement does not approve a source. A public URL does not approve collection. An approved source does not approve AI processing. A model approval does not approve publication. No implementation or activation may proceed merely because this plan is merged.

## 12. Synthetic evaluation and operational metrics

Tests must use synthetic institutions, synthetic websites/documents/posts and deterministic fake model adapters. No live model, source URL, platform API, real provider/student data or production service may be called.

Test new institution discovery, duplicate candidates, small/local provider identity, affiliated/constituent relationships, provider type/status separation, authority scope mismatch, source-specific manifest expiry, source-specific cadence, change detection, deletion/closure ambiguity, conflicting fields, stale admission/fee notices, prompt injection, unsafe URLs/files, personal data rejection, false entity merges, human review, publication denial, correction/withdrawal, audit, quotas and kill switch.

Evaluation metrics should include:
- field-level extraction precision/recall and unsupported-claim rate;
- institution duplicate and false-merge rates;
- correct provider-type and relationship classification;
- freshness/stale-information detection;
- conflict and human-escalation rates;
- human override/rejection rate;
- source availability and failed-job rate;
- time/cost per accepted change and review backlog.

Thresholds must be approved by the owner and qualified reviewers against synthetic evaluation evidence; this plan invents no passing thresholds.

## 13. Delivery sequence

1. G1-Final: approve nationwide coverage, taxonomy, relationship semantics and student-lifecycle field domains.
2. G2-Registry: define source-family and per-asset authorization manifests; start with HEC as one source family, then institution-controlled sources and relevant authorities.
3. G3/G4: finalize privacy and security controls for multi-source, multi-platform collection.
4. G5/G6: select a model/provider only if it meets data-handling requirements and explicit cost constraints; retain a non-AI/manual fallback.
5. G7: assign qualified review and publication responsibilities.
6. G8: implement synthetic fixtures and deterministic evaluation before any live integration.
7. G9: obtain explicit owner authorization for a narrowly scoped pilot.
8. Pilot: only the approved sources, institution types, fields, methods, environment, cadence and limits.
9. Expand by source family and provider category after measured acceptance; never infer blanket authorization from a successful pilot.
10. Operate continuous monitoring with source-specific schedules, periodic reauthorization, freshness review, incident handling and audit.

## 14. Explicit non-actions and binding constraints

This plan is a documentation and architecture revision only. It does not authorize:
- HEC or any institution website/social account/Maps listing access, browsing, scraping, retrieval, download or collection;
- contact with HEC, institutions, platforms or other source owners;
- API, connector, crawler, scheduler, model or agent activation;
- model/provider procurement, paid service or additional spend;
- use of real source, student, applicant or provider data in tests;
- code/schema/migration implementation for the agent;
- production, V1, Hostinger/hPanel, live database, deployment or public release.

Existing project constraints remain binding: synthetic/local/CI-only work until separately authorized; no production writes or deployment; no new spend; no external APIs/AI; human approval before publication; preserve provenance, correction, withdrawal, suppression and audit safeguards.

## 15. G1 decision requested

The owner is asked to confirm the following G1 direction:
- Pakistan-wide coverage across the provider types listed in Section 2, including small/private schools, colleges, academies and training providers;
- HEC is one discovery/recognition authority, not the sole institution universe;
- institution websites and official accounts are distinct source families;
- each source and platform requires its own authorization assessment;
- the data-agent's core purpose is recurring, source-specific monitoring and maintenance;
- unverified status is explicit and inclusion is not endorsement;
- no source collection, AI activation, spending or publication is authorized by this scope decision.

Until G1 is confirmed and G2–G9 are separately satisfied, M3-07 remains in planning/readiness and implementation remains blocked.


## 16. Extensible information storage and lifecycle

The detailed field registry, typed value, entity-scope, add/edit/correct/retire/restore/remove, profile-template, completeness, search/projection and AI-agent constraints are specified in [M3-07 Extensible Institution Information Model and Change Lifecycle](M3-07_EXTENSIBLE_INSTITUTION_INFORMATION_MODEL.md). This is a design artifact only. It does not authorize schema changes, migrations, application code, admin UI, dynamic field CRUD or agent activation. Implementation must reuse the existing claim/evidence/adjudication/publication/audit governance boundary and first inspect the current schema before choosing any additive persistence structure.


## 17. Existing architecture reconciliation

The repository baseline was inspected read-only. The current identity, claim/version, evidence, source authorization, adjudication, publication, audit, correction/withdrawal, conflict and editorial-review mechanisms should be reused. The main identified gap is a governed, versioned field-definition registry with deterministic type, cardinality, entity-scope, privacy, freshness and public/search validation. See [M3-07 Existing Architecture Reconciliation and Extensible Storage Decision](M3-07_EXISTING_ARCHITECTURE_RECONCILIATION_AND_STORAGE_DECISION.md) for the inspected files, reuse/gap matrix, recommended design and implementation sequence. This inspection made no code/schema changes and does not lift any M3-07 approval gate.


## 18. D1 field registry contract

The logical field-definition contract, immutable key/version rules, provider/entity applicability, supported typed values, privacy/evidence/freshness policy, visibility/search allowlists, approval/activation and retirement semantics are specified in [M3-07 D1 Field Registry Contract and Definition Lifecycle](M3-07_D1_FIELD_REGISTRY_CONTRACT.md). D1 is a design artifact; D2 must select the physical representation and exact immutable association between a field-definition version and each claim version. No schema or application implementation is authorized by D1.


## 19. D2 field registry storage decision

The recommended physical architecture is a normalized field-definition registry plus the existing claims/claim-version store, with each registry-managed claim version bound to the exact immutable definition version used for validation. The proposal compares alternatives, defines additive migration boundaries, review workflow, indexes, concurrency, compatibility and synthetic acceptance criteria in [M3-07 D2 Field Registry Physical Storage Decision](M3-07_D2_FIELD_REGISTRY_STORAGE_DECISION.md). This remains a design proposal only; no migration or code change is authorized.


## 20. D3 field-aware service boundary

The required single write path for registry-managed institution facts, generic claim-registration bypass prevention, definition/value lifecycle separation, actor capabilities, correction/withdrawal, profile assembly and synthetic acceptance tests are specified in [M3-07 D3 Field-Aware Claim Service Boundary and Governance Contract](M3-07_D3_FIELD_AWARE_CLAIM_SERVICE_BOUNDARY.md). This is design only; code changes require separate bounded authorization.

## 21. Owner-confirmed source strategy and initial coverage decision

**Owner direction recorded:** 2026-11-15. The owner confirmed that M3-07 must not compromise its core objective: a comprehensive, expandable, Pakistan-wide education information database. HEC is an initial reference for the higher-education institution universe, not the boundary of the directory and not the sole source of information.

### 21.1 Coverage decision

The initial national catalogue must be designed to include both:
- HEC-recognized universities and degree-awarding institutions; and
- their separately identifiable campuses, linked to the relevant parent institution.

This does not mean every campus is a separate university or degree-awarding institution. Campus identity, parent relationship, location and applicable recognition scope must remain distinct and evidence-backed.

The wider catalogue remains open to public/private schools (including small/local providers), colleges (including affiliated and constituent colleges), academies, coaching and tuition providers, technical/vocational institutions, professional/specialist providers, early-learning centres and other relevant education providers. HEC omission must never be used to exclude or classify providers outside HEC's remit.

### 21.2 Practical source hierarchy by information type

The following is a source-selection policy, not blanket permission to access or reuse any source:

| Information / claim | Preferred competent source | Role of other sources |
|---|---|---|
| Initial discovery of universities, degree-awarding institutions and HEC-recognized campuses | HEC reference/register, within HEC's remit | Other competent authorities and institution sources may identify omissions, changes or additional entities |
| Institution's own programmes, admissions, eligibility, fee schedules, academic calendar, facilities and official notices | The institution's own official website, prospectus, admission portal or official publication | Relevant regulator/awarding/affiliating authority where the fact falls within its remit; other sources may corroborate |
| Recognition, charter, accreditation, licensing or regulatory status | The competent government authority, regulator or accreditation body for that exact status | Institution website may provide a lead or supporting document, but does not independently settle the regulator's decision |
| College affiliation and awarding relationship | The competent affiliating or awarding university/body | Institution website may corroborate the relationship and identify the claimed programme |
| Campus identity, address and campus-specific offer | The institution's official campus page or official campus publication, with relevant authority records where applicable | Mapping/location sources may support location discovery/corroboration only, subject to their own terms |
| School registration and local/provider status | The competent provincial/local education or registration authority | School's official website/publication may provide its own programme, admission and fee information |
| Academy/training-provider identity and course offer | The provider's official source for its own offer; competent regulator where regulated | Third-party listings may support discovery, not automatically establish recognition or quality |

The field registry must therefore support more than one source class and must preserve the source's authority scope. No source is universally authoritative for every field.

### 21.3 Source-by-source authorization remains mandatory

HEC, each institution-controlled website or portal, each regulator/authority, each social account, each mapping platform and each third-party source must have its own source/asset assessment and authorization manifest before any retrieval or collection. The owner’s confirmation of the product's broad source strategy does not grant legal permission, platform permission or technical authorization.

The initial source decision pack may evaluate HEC as the first proposed reference and institution official websites as a first-class source family for institution-specific student information. It must not access those sources, contact source owners, retrieve content, or activate a connector, crawler, model or scheduler. Each candidate asset, intended fields, access method, permitted acts, privacy/security controls, retention, reviewers and expiry must be assessed separately.

### 21.4 G1 status and unchanged blockers

The owner's 2026-11-15 direction confirms the product-scope principles in G1: Pakistan-wide provider coverage; HEC is not the sole directory universe; institution-controlled official sources are central to institution-specific information; campuses are separately modelled and linked; and student-lifecycle information remains the core product objective.

**G1 scope direction: OWNER-CONFIRMED; documentation reconciliation/PR review remains.** G2 source rights and methods, G3 privacy, G4 security, G5 model/provider, G6 cost/capacity, G7 qualified governance, G8 synthetic evaluation thresholds and G9 exact owner activation remain separate gates and are not approved by this decision.

No source access, collection, external contact, model/API/connector/scheduler activation, real data use, production/V1/Hostinger operation, migration, deployment, release or additional spend is authorized by this owner direction.



## 18. Student-first discovery architecture clarification

The product owner has clarified that M3-07 is primarily a student-facing discovery platform: students must be able to find nearby institutions and compare relevant programmes, subjects, fees, admissions and campus locations. The system must keep Search/Discovery, AI Data-Agent and Central Database as separate logical components with controlled interfaces. Search reads approved projections only; the AI agent proposes evidence-backed changes only; the central database retains approved current values, pending proposals and historical versions. Student-facing publication is a separate controlled projection step.

The information model must be dynamically extensible. Authorized administrators must be able to add new field definitions, hide fields/sections, independently control search/filter eligibility, disable future collection, retire/restore definitions and introduce successor versions. Hiding or retiring a field must not silently erase its values or history. New source attributes require field-definition review before collection/publication. See [M3-07 Student Education Discovery Platform Architecture and Dynamic Field Governance](M3-07_STUDENT_DISCOVERY_PLATFORM_ARCHITECTURE_AND_DYNAMIC_FIELD_GOVERNANCE.md) and section 18 of [M3-07 Extensible Institution Information Model](M3-07_EXTENSIBLE_INSTITUTION_INFORMATION_MODEL.md).

This clarification is documentation-only. Existing M3-07 source-rights, privacy, security, model/provider, cost, governance, synthetic-evaluation and owner-activation gates remain conjunctive; no live source access, data collection, agent activation, schema/application implementation, deployment, V1/Hostinger access or new spend is authorized.


## R1-R3 and I1-I3 reconciliation — 2026-11-16

R1 was delivered and merged in PR #204; R2 source-specific and model/provider decision packs were delivered and merged in PR #206. R3 reconciles those decisions and records a no-activation disposition: GOV-04 HEC recognised universities/DAIs remains RESEARCH ONLY; no model/provider is selected; deterministic fake-adapter use remains synthetic-CI-only; G2-G7 remain blocked and G9 is not authorized. See `M3-07_R3_SOURCE_RIGHTS_AND_MODEL_FEASIBILITY_RECONCILIATION.md`.

The field-registry foundations I1-I3 are separately delivered in PRs #198, #199 and #203 for bounded synthetic local/CI scopes. These packages do not authorize source access, external inference, connectors, schedulers, production or additional spend. The next eligible package is I4 — Field Definition Governance Lifecycle — but its implementation requires a separate explicit owner authorization.
