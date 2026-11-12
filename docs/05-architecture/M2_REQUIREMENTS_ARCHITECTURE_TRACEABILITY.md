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
