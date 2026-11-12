# M2 Requirements-to-Architecture Traceability

**Status:** Initial scaffold; M2-S01 expands stable requirement IDs. A mapping is not complete until its architecture element, decision, risk/control and future verification are identified.

| Requirement family | M1 source | Planned architecture | Risk/control | Future verification | Status |
|---|---|---|---|---|---|
| SR-01–SR-14 student requirements | M1-S01 | S01 capability/context; feature views | G18 participant validation deferred | Scenario acceptance; field research separately authorized | Pending |
| Provider/institution/campus | M1-S02–S05 | S02 domain model | G04 identity/relationship errors | Domain invariants | Pending |
| Recognition/affiliation | M1-S02–S05 | S02/S05 | G03/G04/G09 | Scope-specific evidence tests | Pending |
| Admissions/fees/scholarships | M1-S05 | S02/S05 | G05 stale or misleading facts | Temporal/staleness tests | Pending |
| Geography/discovery | M1-S02–S04 | S02/S06 | G06 location quality/privacy | Coordinate provenance and search tests | Pending |
| Source rights/provenance | M1-S03–S08 | S05/S07 | G02/G08/G16 | Rights-gate and lineage tests | Pending |
| Governed AI workflow | M1-S08 | S07 | G08/G09 | Prompt-injection and human-review tests | Pending |
| Comparison transparency | M1-S09 | S06 and comparison design | G10/G11 | Missing-data/sponsorship tests | Pending |
| Reviews and moderation | M1-S09 | S08 | G12-G15 | Authentication, abuse, moderation and privacy tests | Pending |
| Deeni Madaris default OFF | V2-DEC-006 | S02/S06/S08 | G07 | Negative tests on all public surfaces and APIs | Binding |
| Privacy and minors | M1-S07/S09 | S08 | G15/G17 | Privacy/security and safeguarding review | Pending |
| Operations and recovery | M1 baseline / M0 controls | S09 | Operational risks | Restore and failure tests | Pending |

## G01-G20 disposition rule
Every accepted M1 gap/decision must be marked designed in M2, carried into M3 with a named gate, owner decision required, legal review required, source-specific authorization required, deferred with rationale or excluded by explicit owner decision. No gap is closed by silence.

This scaffold is not a claim of complete requirements traceability.


## M2-S01 architecture requirement mapping — initial draft

| Architecture requirement | Product requirement / decision | Architecture view / step | Verification obligation | Status |
|---|---|---|---|---|
| AR-001–AR-002 | SR-01, SR-08 | S01 context; S03/S06 public discovery | Anonymous direct/pathway discovery scenarios | Drafted |
| AR-003 | SR-02; G04 | S02 domain; S03/S06 search | Entity identity and exact/approximate match tests | Drafted |
| AR-004 | SR-03, SR-14; G06 | S01 context; S06 geo | Location denial/manual locality tests | Drafted |
| AR-005–AR-007 | SR-04, SR-06, SR-07; G03/G05/G08/G09 | S02/S05/S07 | Missing/stale/conflict and provenance tests | Drafted |
| AR-008 | SR-05; G10/G11 | S06 | Like-for-like comparison and sponsorship separation tests | Drafted |
| AR-009–AR-012 | SR-08–SR-10, SR-13; G12-G15 | S06/S08 | Official route, auth, review and privacy tests | Drafted |
| AR-013–AR-015 | M1-S07/S08; G02/G08/G09/G16 | S05/S07 | Rights gate, adversarial input, history and human-approval tests | Drafted |
| AR-016–AR-018 | V2-DEC-006; G07 | S02/S06/S08 | Zero-public-exposure tests while setting OFF; no sect/maslak fields | Binding |
| AR-019–AR-020 | SR-07; G01/G10/G11 | S05/S06 | Coverage-state and sponsored-placement tests | Drafted |
| AR-021–AR-022 | SR-11/SR-12 | S01/S08/S09/M11 | Low-bandwidth, Unicode/RTL and accessibility tests | Drafted |
| AR-023–AR-025 | M1 governance; G14/G17/G20 | S05/S08/S09 | Audit, degraded-mode and recovery tests | Drafted |

Full definitions and priorities are in `M2-S01_SYSTEM_REQUIREMENTS_AND_BOUNDARIES.md`; detailed scenarios are in `M2-S01_QUALITY_SCENARIOS.md`. This is an initial mapping; S01-T05 and M2-S10 still require review and reconciliation.


## M2-S02/S03 conceptual and logical architecture mapping — draft

| Requirement | Domain/architecture element | Risk/control | Future verification | Status |
|---|---|---|---|---|
| AR-003 | Provider, institution, campus, programme and qualification are distinct domain concepts; discovery/query boundary | G04 false merge or wrong scope; stable identity and human adjudication | Duplicate/split/branch and scope test cases | Drafted |
| AR-005–AR-007, AR-015, AR-019 | Assertion/evidence/provenance, uncertainty, valid/observed/recorded/publication time; governed read projection | G03/G05/G08/G09; preserve source and history | Temporal, conflict, stale and missing-state tests | Drafted |
| AR-006 | Programme offer scoped to campus and admission cycle; fee/scholarship scoped to offer | Misleading generic or stale admissions facts | Cycle and effective-period scenarios | Drafted |
| AR-013–AR-014 | Source authorization gate, evidence workflow, AI proposal and human publication | G02/G08/G09/G16; deny by default | Unauthorized-source negative tests and approval audit | Drafted |
| AR-016–AR-018 / V2-DEC-006 | Platform-wide policy applied to public query and all derived surfaces | G07; fail closed on partial propagation | Negative tests for search, browse, maps, recommendations, counts, sitemap, exports and APIs | Binding — design carried |
| AR-011 | Identity and post-launch review workflow separate from factual evidence | G12–G15; login is not proof of attendance | Auth, moderation, appeal and review-target tests | Drafted |
| AR-021–AR-024 | Responsive public experience, request boundary and degraded discovery | Low bandwidth, location denial and optional service outage | Anonymous/manual-locality/failure scenarios | Drafted |
| AR-023–AR-025 | Audit, privileged configuration, persistence and recovery boundaries | G14/G17/G20 | Audit integrity, restore and incident tests | Drafted |

S02 supplies the domain vocabulary and lifecycle semantics consumed by S03's logical components and runtime scenarios. S04–S09 must deepen the technology, data, search, AI, security and operational designs. This mapping is not a physical schema, API specification or implementation verification.


## M2-S04/S05/S06 technology, data and discovery mapping — draft (2026-11-12)

| Requirement / decision | Architecture element | Risk/control | Future verification | Status |
|---|---|---|---|---|
| AR-001–AR-003, AR-021–AR-022 | S04 backend/frontend options; HTML-first public experience; modular capability boundaries | SEO, low bandwidth, maintainability and team skill unknowns | Same synthetic domain workflow across backend candidates; HTML/JS payload and accessibility tests | Drafted; stack owner decision pending |
| AR-005–AR-007, AR-013–AR-015, AR-019 | S05 evidence lineage, assertion history, source rights gate and publication decision | G02/G03/G05/G08/G09/G16; public access is not reuse permission | Source authorization negative tests, provenance completeness, conflict and withdrawal replay | Drafted |
| AR-006–AR-007, AR-015, AR-023 | S05 cycle-scoped data, temporal validity, audit and correction history | Stale/mis-scoped admissions, fees and recognition claims | Effective-date, supersession, audit and rollback tests | Drafted |
| AR-001–AR-010, AR-021–AR-022 | S06 public search/browse/map/list discovery and comparison | Misleading result, hidden missingness, location privacy | Anonymous, manual-locality, bilingual query, comparison and degraded-mode tests | Drafted |
| AR-016–AR-018 / V2-DEC-006 | S05 publication eligibility plus S06 all-surface discovery enforcement | G07; category leakage via counts, facets, cache, maps or API | Zero-exposure negative suite for every public surface and side channel while OFF | Binding — design carried |
| AR-004, AR-021, AR-024 | S06 geospatial quality and optional geolocation | Inaccurate pins, privacy leakage, external service outage | Coordinate provenance/precision tests; location-denial and map-outage tests | Drafted |
| AR-008, AR-019–AR-020 | S06 ranking, freshness, completeness and sponsorship separation | Biased comparison, paid ranking opacity, unknown treated as negative | Relevance evaluation, missingness and sponsored-label tests | Drafted |

S04-S06 designs consume accepted S02/S03 concepts. S07 refines AI-assisted evidence workflow; S08 refines identity/privacy/safeguarding; S09 establishes quantitative operations, capacity, retention and recovery targets. This mapping is a design obligation, not implementation test evidence.

## M2-S07/S08/S09/S10 mapping — draft (2026-11-12)

| Requirement / decision | Architecture element | Risk/control | M3 verification / gate | Status |
|---|---|---|---|---|
| AR-005–AR-007, AR-013–AR-015, G02/G08/G09/G16 | S07 source authorization, evidence quarantine, typed extraction, validation and provenance contract | Deny-by-default source access; prompt injection; hallucination; provenance gaps | Unauthorized-source negative tests, evidence-span checks, extraction evaluation, rights expiry/revocation replay | Drafted |
| AR-003, AR-005–AR-007, G03/G04/G05 | S07 entity resolution and conflict workflow | False merge/split, stale or mis-scoped facts | Synthetic duplicate/split/affiliation/temporal test suite; mandatory human adjudication for ambiguity | Drafted |
| AR-013–AR-015, G08/G09/G16 | S07 human review and publication separation | AI-only publication, unauthorized tools, silent overwrite | Verify no model-to-publication path; role separation and publication audit | Binding design invariant |
| AR-009–AR-012, G12-G15 | S08 identity, scoped authorization, review integrity, moderation and appeal | Account takeover, IDOR, brigading, self-dealing | Authentication/authorization matrix, abuse and moderation tests | Drafted |
| AR-021–AR-022, G17 | S08 privacy/minor safeguarding and anonymous-first discovery | Personal data leakage, unsafe adult-minor contact, precise location exposure | Privacy impact, safeguarding, log/cache/export leakage and location-denial tests | Drafted |
| V2-DEC-006, AR-016–AR-018, G07 | S08 privileged configuration plus S06 all-surface suppression | Deeni Madaris side-channel leakage | Zero-exposure negative suite across public surfaces, caches, APIs, counts and exports | Binding |
| AR-021–AR-025, G14/G17/G20 | S09 SLO hypotheses, observability, environments, backup/recovery and incident design | Outage, data loss, unverified backup, cost exhaustion | Load tests, timed restore, incident exercise and cost worksheet | Drafted; targets unapproved |
| All AR-001–AR-025 and G01-G20 | S10 integrated architecture and conditional M3 roadmap | Cross-step contradiction or unowned gap | Complete traceability audit, threat review, ADR audit, owner acceptance | Pending final owner acceptance |

G01-G20 are not closed merely because a design paragraph exists. Each remains linked to an explicit M3 verification, owner/legal decision, source-specific authorization or documented deferral. This mapping is a design obligation, not implementation test evidence.


## M3-01 AI-era architecture requirements — 2026-11-12

The documentation-only review `M3-01_AI_ERA_ARCHITECTURE_READINESS_REVIEW_2026-11-12.md` proposes AI-ARCH-01 through AI-ARCH-20 as additional M3 planning requirements. They supplement accepted M2 decisions; they do not reopen M2 or authorize implementation. Map each requirement to the review's architecture layers, risk controls and future verification matrix. All 20 remain **proposed / owner review pending** until explicitly accepted. Provider/model independence, AI-off resilience, evidence-grounded RAG, optional vector retrieval, controlled agent execution, human publication approval, prompt lifecycle, evaluation, prompt-injection protection, observability/cost limits, versioned APIs, bounded interoperability, durable jobs, portability, English/Urdu readiness, privacy minimization, policy isolation, replaceable search/geospatial services, kill switches and lifecycle governance are mandatory planning topics. No model, agent, MCP server, API, vector service, queue or vendor is selected or activated.
