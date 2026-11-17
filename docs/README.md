# Documentation Index

This documentation is the governing source of truth for eStudent Institutes V2. Read the project controller first.

## Foundational controls
- [Project Master Control](00-foundation/PROJECT_MASTER_CONTROL.md)
- [Project Constitution](00-foundation/PROJECT_CONSTITUTION.md)
- [AI Execution Protocol](00-foundation/AI_EXECUTION_PROTOCOL.md)
- [Engineering Standards](00-foundation/ENGINEERING_STANDARDS.md)
- [Definition of Done](00-foundation/DEFINITION_OF_DONE.md)
- [Decision Register](00-foundation/DECISION_REGISTER.md)
- [Repository Governance Setup](00-foundation/REPOSITORY_GOVERNANCE_SETUP.md)

## Product
- [Product Vision and Student Journey](01-product/PRODUCT_VISION_AND_STUDENT_JOURNEY.md)
- [Student Discovery Requirements](01-product/STUDENT_DISCOVERY_REQUIREMENTS.md)
- [Institution and Programme Requirements](01-product/INSTITUTION_AND_PROGRAMME_REQUIREMENTS.md)
- [Comparison, Reviews and Student Trust](01-product/COMPARISON_REVIEWS_AND_TRUST.md)

## Data strategy
- [Education Data Strategy](02-data-strategy/EDUCATION_DATA_STRATEGY.md)
- [Provider Register](02-data-strategy/EDUCATION_DATA_PROVIDER_REGISTER.md)
- [AI Data Agent Requirements](02-data-strategy/AI_DATA_AGENT_REQUIREMENTS.md)
- [Data Rights and Provenance](02-data-strategy/DATA_RIGHTS_AND_PROVENANCE.md)
- [M1 Source Rights, Access and Provenance Evidence Register](03-research/M1_SOURCE_RIGHTS_ACCESS_EVIDENCE_REGISTER.md)

## Roadmap and implementation records
- [M3-09 Quality and Operational Hardening](04-roadmap/M3-09_QUALITY_OPERATIONAL_HARDENING_RECORD.md)
- [M3-10 Pilot and Launch Readiness Work Plan](04-roadmap/M3-10_PILOT_AND_LAUNCH_READINESS_WORK_PLAN.md)
- [M3-10 Readiness Acceptance Verification Record](04-roadmap/M3-10_READINESS_ACCEPTANCE_VERIFICATION_RECORD.md) — verifies framework delivery and records why pilot readiness/go/no-go remains blocked
- [M3-10 Final Readiness Gate Reconciliation](04-roadmap/M3-10_FINAL_READINESS_GATE_RECONCILIATION.md) — canonical current status of Option B proposal-only decision, merged university workflow, adversarial tests and all M10 readiness gates
- [M3-10 University Workflow Adversarial Hardening Record](04-roadmap/M3-10_UNIVERSITY_WORKFLOW_ADVERSARIAL_HARDENING_RECORD.md) — synthetic-only tests for revoked/expired roles, forged request fields, invalid evidence, replay conflicts, atomic audit rollback and audit integrity

## Documentation tracking
- [Documentation Completion Catalogue](04-roadmap/DOCUMENTATION_CATALOG.md) — owner-facing list of delivered, reviewed, accepted and planned documents; updated after every documentation PR update and merge.

## Implementation records
- [FND-01 Laravel 13 Foundation Implementation Record](05-implementation/FND-01_IMPLEMENTATION_RECORD.md) — local/CI-only foundation, synthetic tests and safety boundaries
- [M3-05 Public Directory and Search Work Plan](04-roadmap/M3-05_PUBLIC_DIRECTORY_SEARCH_WORK_PLAN.md) — completed public browsing/search scope, allowlist and acceptance contract
- [M3-05 Public Directory and Search Implementation Record](04-roadmap/M3-05_PUBLIC_DIRECTORY_SEARCH_IMPLEMENTATION_RECORD.md) — merged anonymous directory routes, query service, profile pages and exact-head CI evidence
- [M3-06 Geography and Discovery Work Plan](04-roadmap/M3-06_GEOGRAPHY_AND_DISCOVERY_WORK_PLAN.md) — bounded Pakistan-first text locality search scope, privacy controls and explicit geospatial deferrals
- [M3-06 Geography and Discovery Implementation Record](04-roadmap/M3-06_GEOGRAPHY_AND_DISCOVERY_IMPLEMENTATION_RECORD.md) — merged locality filtering, synthetic verification and exact-head CI evidence
- [M3-07 AI Data-Agent Work Plan](04-roadmap/M3-07_AI_DATA_AGENT_WORK_PLAN.md) — source/model authorization gates, proposal-only workflow, threat controls and synthetic-only test plan
- [M3-07 AI Data-Agent Readiness Review Record](04-roadmap/M3-07_AI_DATA_AGENT_READINESS_REVIEW_RECORD.md) — documented readiness blockers and explicit no-activation decision
- [M3-08 Identity, Reviews and Security Scope / Architecture Preflight](04-roadmap/M3-08_IDENTITY_REVIEWS_SECURITY_PREFLIGHT.md) — merged preflight and governing post-launch review/security constraints
- [M3-08A/B Identity, Session Authentication and Scoped Authorization Implementation Record](04-roadmap/M3-08A_B_IDENTITY_AUTHORIZATION_IMPLEMENTATION_RECORD.md) — owner-authorized first-party session/authz implementation, additive identity schema and synthetic tests; PR #232 merged with exact-head CI passed
- [M3-08C/D Synthetic Moderation, Appeals and Privacy/Security Implementation Record](04-roadmap/M3-08C_D_IMPLEMENTATION_RECORD.md) — synthetic-only moderation/appeals state foundations, privacy boundaries, no-public-route tests and exact-head CI evidence; PR #234 merged
- [M3-07 R1 Pakistan National Education Source Master Inventory](04-roadmap/M3-07_R1_PAKISTAN_NATIONAL_EDUCATION_SOURCE_MASTER_INVENTORY.md) — consolidated national source families, seven-jurisdiction coverage, institution-controlled update sources, gaps and source-authorization boundaries
- [M3-07 I5 Value Correction, Withdrawal and Profile Integration Implementation Record](04-roadmap/M3-07_I5_IMPLEMENTATION_RECORD.md) — merged I5-A through I5-C scope, exact-head CI, synthetic acceptance evidence and safety boundaries

## Research and delivery
- [Open-Source Reuse Audit](03-research/OPEN_SOURCE_REUSE_AUDIT.md)
- [M1 Student Journey Research](03-research/M1_STUDENT_JOURNEY_RESEARCH.md)
- [M1 Student Research Instruments](03-research/M1_STUDENT_RESEARCH_INSTRUMENTS.md) — archived draft; pre-launch participant research deferred by owner
- [M1-S03 Official Government and Regulator Provider Source Register](03-research/M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md) — source-specific authority, access, coverage, freshness, rights and privacy evidence
- [M1-S03 NFE, Special-Education and GB Source Review](03-research/M1_S03_NFE_SPECIAL_ED_GB_SOURCE_REVIEW_2026-11-12.md) — NFEMIS, DGSE, Sindh DEPD, GB EMIS/college routes and data-quality/privacy limitations
- [M1-S03 Professional Regulator Source Review](03-research/M1_S03_PROFESSIONAL_REGULATOR_SOURCE_REVIEW_2026-11-12.md) — PMDC, PCP, PNMC, NCEAC, NACTE, PEC, NTC, PVMC and PBC source scope and status semantics
- [M1-S03 AJK Education Source Review](03-research/M1_S03_AJK_EDUCATION_SOURCE_REVIEW_2026-11-12.md) — E&SE/EMIS/PEIRA and HED routes, access limits and 178/180 college discrepancy
- [M1-S03 TVET and QAB Source Review](03-research/M1_S03_TVET_QAB_SOURCE_REVIEW_2026-11-12.md) — NAVTTC QABs, Punjab TEVTA/PSDA/TTB, Sindh STEVTA, KPTEVTA and B-TEVTA/BSIS
- [M1-S03 Federal Data and FBISE Source Review](03-research/M1_S03_FEDERAL_DATA_FBISE_SOURCE_REVIEW_2026-11-12.md) — PIE/NEMIS source lineage, private-college data gaps, Wafaq reporting caveats and FBISE affiliation
- [M1-S03 FDE/FGEI Source Review](03-research/M1_S03_FDE_FGEI_SOURCE_REVIEW_2026-11-12.md) — FDE ICT network and FGEI cantonment/garrison schools/colleges as separate federal source families
- [M1-S03 Jurisdictional School Authority Source Matrix](03-research/M1_S03_JURISDICTIONAL_SCHOOL_SOURCE_MATRIX_2026-11-12.md) — public/private school authority and EMIS/register routes across Punjab, Sindh, KP, Balochistan, ICT, AJK and GB
- [M1-S03 Additional Accreditation Council Review](03-research/M1_S03_ADDITIONAL_ACCREDITATION_COUNCIL_REVIEW_2026-11-12.md) — HEC council map, NBEAC, NCH, PCATP, AHPC and NAEAC status/freshness limitations
- [M1-S03 Task Acceptance Evidence Audit](03-research/M1_S03_TASK_ACCEPTANCE_EVIDENCE_AUDIT_2026-11-12.md) — task-by-task completion evidence, remaining limitations and owner-only acceptance gate
- [M1 Institution Taxonomy Research](03-research/M1_INSTITUTION_TAXONOMY_RESEARCH.md)
- [M1 Official Institution Source Coverage Matrix](03-research/M1_OFFICIAL_INSTITUTION_SOURCE_COVERAGE_MATRIX.md)
- [M1 National Institution Coverage Synthesis](03-research/M1_NATIONAL_INSTITUTION_COVERAGE_SYNTHESIS.md) — draft national sector/jurisdiction coverage, quality assessment and unresolved gaps
- [M1-S02 Owner Acceptance Review](03-research/M1_S02_OWNER_ACCEPTANCE_REVIEW.md) — decision-ready closeout recommendation and limitations; pending owner decision
- [M1-S02 Supplemental Official-Source Coverage Review](03-research/M1_S02_SUPPLEMENTAL_SOURCE_COVERAGE_REVIEW_2026-11-12.md) — AJK, Balochistan, NFEMIS, GB EMIS, HEC qualification/NOC and special-education evidence supplement
- [M1-S02 Supplemental Professional-Council and Special-Education Review](03-research/M1_S02_SUPPLEMENTAL_PROFESSIONAL_COUNCIL_SPECIAL_EDUCATION_REVIEW_2026-11-12.md) — PCATP, NCT, AHPC, NTC, NAEAC and ICT/KP special-education findings
- [M1 Source Rights, Access and Provenance Evidence Register](03-research/M1_SOURCE_RIGHTS_ACCESS_EVIDENCE_REGISTER.md)
- [Master Roadmap](04-roadmap/PROJECT_MASTER_ROADMAP.md)
- [Milestone and Step Register](04-roadmap/MILESTONE_STEP_REGISTER.md)
- [Traceability Matrix](04-roadmap/IMPLEMENTATION_TRACEABILITY_MATRIX.md)
- [Progress Report](04-roadmap/PROJECT_PROGRESS_REPORT.md)
- [M3-00 Owner Closeout Review and Decision Pack](04-roadmap/M3-00_OWNER_CLOSEOUT_REVIEW_AND_DECISION_PACK.md) — final M3-00 evidence, bounded planning dispositions and explicit owner acceptance gates
- [M3-00 T07 Legal, Privacy, Source-Rights and Security Gate Register](04-roadmap/M3-00_T07_LEGAL_PRIVACY_SOURCE_RIGHTS_SECURITY_GATES.md) — deny-by-default gates; review ownership and source-specific approvals remain open
- [Legacy Repository Isolation Audit](99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md)

## Governance rule
A proposal in a document is not automatically an approved implementation choice. Record material decisions in the Decision Register. Update the controller, step register, traceability and progress report as work advances. Legacy repository artifacts are explicitly excluded from V2; see the isolation audit.

- [M1-S02 Deep Jurisdiction, Special-Education and TVET Review](03-research/M1_S02_DEEP_JURISDICTION_SPECIAL_ED_TVET_REVIEW_2026-11-12.md) — Punjab/Sindh/GB special-education leads, provincial TVET directory evidence, data-quality and privacy boundaries
- [M1-S02 ICT PEIRA, Madaris and QAB Review](03-research/M1_S02_ICT_PEIRA_MADARIS_QAB_REVIEW_2026-11-12.md) — ICT PEIRA register, DGRE Madaris source and IBCC qualification-awarding/equivalence distinctions
- [M1-S02 Examination Boards, PMF and DGRE Jurisdiction Review](03-research/M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md) — examination boards, Punjab Medical Faculty affiliation and DGRE regional register evidence
- [M1-S02 Examination Boards, PMF and DGRE Jurisdiction Review](03-research/M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md) — IBCC board roster, Punjab BISE/PMF affiliations, DGRE regional coverage and HEC affiliation/study-centre rules
- [M1-S02 Data Rights, Public-Information Access and Privacy Framework Review](03-research/M1_S02_DATA_RIGHTS_PRIVACY_FRAMEWORK_REVIEW_2026-11-12.md) — national policy status, reuse rights, copyright, RTI and privacy safeguards
- [M1-S02 AJK, GB, Sindh and Punjab School Register Review](03-research/M1_S02_AJK_GB_SINDH_SCHOOL_REGISTER_REVIEW_2026-11-12.md) — additional public/private school source coverage and data-quality limits
- [M1-S02 School Regulator Status and Terms Review](03-research/M1_S02_SCHOOL_REGULATOR_STATUS_TERMS_REVIEW_2026-11-12.md) — KP/Sindh regulator status, HEC publisher-license scope and NAVTTC count distinctions
- [M1-S02 KP, ICT and AJK College Coverage Review](03-research/M1_S02_KP_ICT_AJK_COLLEGE_COVERAGE_REVIEW_2026-11-12.md) — public-sector school/college coverage gaps and AJK count discrepancy
- [M1-S02 Consolidated National Institution Coverage and Gap Matrix](03-research/M1_S02_CONSOLIDATED_NATIONAL_COVERAGE_GAP_MATRIX_2026-11-12.md) — reconciled national coverage snapshot and remaining evidence gaps


## M2 architecture and design

- [M2 Architecture Documentation Index](05-architecture/README.md)
- [M2 Architecture and Design Charter](05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md)
- [M2 Step Plan](05-architecture/M2_STEP_PLAN.md)
- [M2 Architecture Documentation Plan](05-architecture/M2_ARCHITECTURE_DOCUMENTATION_PLAN.md)
- [M2 Requirements-to-Architecture Traceability](05-architecture/M2_REQUIREMENTS_ARCHITECTURE_TRACEABILITY.md)
- [M2 Architecture Decision Register](05-architecture/M2_ARCHITECTURE_DECISION_REGISTER.md)
- [ADR Template](05-architecture/decisions/ADR_TEMPLATE.md)
- [Diagram Conventions](05-architecture/diagrams/README.md)

M2 is owner-authorized and active as a documentation/design milestone. Application implementation remains gated until final M2 acceptance.


## M2 architecture and design

- [M2 Architecture Documentation Index](05-architecture/README.md)
- [M2 Architecture and Design Charter](05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md)
- [M2 Step Plan](05-architecture/M2_STEP_PLAN.md)
- [M2 Architecture Documentation Plan](05-architecture/M2_ARCHITECTURE_DOCUMENTATION_PLAN.md)
- [M2 Requirements-to-Architecture Traceability](05-architecture/M2_REQUIREMENTS_ARCHITECTURE_TRACEABILITY.md)
- [M2 Architecture Decision Register](05-architecture/M2_ARCHITECTURE_DECISION_REGISTER.md)
- [ADR Template](05-architecture/decisions/ADR_TEMPLATE.md)
- [Diagram Conventions](05-architecture/diagrams/README.md)

M2 is owner-authorized and active as a documentation/design milestone. Application implementation remains gated until final M2 acceptance.


### M2-S01 — System requirements and architecture boundaries
- [System Requirements and Architecture Boundaries](05-architecture/M2-S01_SYSTEM_REQUIREMENTS_AND_BOUNDARIES.md)
- [System Context and Capability Boundary](05-architecture/M2-S01_SYSTEM_CONTEXT.md)
- [Quality Attribute Scenarios and Targets](05-architecture/M2-S01_QUALITY_SCENARIOS.md)

### M2 architecture and design — current S04-S10 status

- [M2-S04/S05/S06 Owner Acceptance Record](05-architecture/M2-S04-S06_OWNER_ACCEPTANCE_RECORD_2026-11-12.md)
- [M2-S07 AI Data-Agent Technical Architecture](05-architecture/M2-S07_AI_DATA_AGENT_TECHNICAL_ARCHITECTURE.md)
- [M2-S08 Identity, Authorization, Reviews, Privacy and Security](05-architecture/M2-S08_IDENTITY_AUTHORIZATION_REVIEWS_PRIVACY_SECURITY.md)
- [M2-S09 Performance, Operations, Hosting and Recovery](05-architecture/M2-S09_PERFORMANCE_OPERATIONS_HOSTING_RECOVERY.md)
- [M2-S07/S08/S09 Joint Architecture Validation](05-architecture/M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md)
- [M2-S10 Final Architecture Synthesis and M3 Roadmap](05-architecture/M2-S10_FINAL_ARCHITECTURE_SYNTHESIS_M3_ROADMAP.md)
- [M2 Progress Report](05-architecture/M2_PROGRESS_REPORT.md)

S04-S06 are owner-accepted and closed. S07-S09 design tasks are complete; S10 final owner acceptance remains pending. Weighted M2 design progress is 98.6%. M3 implementation is not authorized.


### M2 final acceptance and closeout

- [M2 Final Owner Acceptance and Closure Record](05-architecture/M2_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md)
- [M2 Final Progress and Closeout Report](05-architecture/M2_FINAL_PROGRESS_AND_CLOSEOUT_REPORT_2026-11-12.md)

M2 is 100% complete, owner-accepted and closed. M3 implementation requires separate authorization.


## M3-02 platform foundation gap assessment
- [M3-02 Platform Foundation — FND-01 Gap Assessment](04-roadmap/M3-02_PLATFORM_FOUNDATION_FND01_GAP_ASSESSMENT_2026-11-13.md) — maps merged FND-01 evidence to M3-02 exit criteria, identifies remaining gaps and preserves the separate implementation authorization gate.

## M3 — Mobilization and implementation roadmap

- [M3 Master Step Plan](04-roadmap/M3_MASTER_STEP_PLAN.md) — authoritative M3 steps, weights, dependencies, task/acceptance criteria, binding controls and authorization gates.
- [M3-00 Mobilization and Decision Closure](04-roadmap/M3-00_MOBILIZATION_AND_DECISION_CLOSURE.md) — current step, owner/team inputs, decision gates and exit criteria.
- [M3-00 Owner Decision Pack](04-roadmap/M3-00_OWNER_DECISION_PACK.md) — role/skills, capacity, budget, stack, hosting and legal/privacy/security decision worksheets.
- [M3-00 T07 Legal, Privacy, Source-Rights and Security Gate Register](04-roadmap/M3-00_T07_LEGAL_PRIVACY_SOURCE_RIGHTS_SECURITY_GATES.md) — deny-by-default legal, privacy, source and security gates.
- [M3-00 T08 Implementation Scope, Test/Release Governance and M3-01 Authorization Pack](04-roadmap/M3-00_T08_IMPLEMENTATION_SCOPE_TEST_RELEASE_AUTHORIZATION_PACK.md) — planning framework and unissued implementation authorization record.

M0, M1 and M2 are accepted and closed. M3-00 is documentation/planning only. Application implementation requires separate explicit authorization after M3-01 readiness review. The M3 Master Step Plan supersedes older high-level M3 sequencing where they differ; it does not reopen M2 or relax any binding control.

**Current status correction:** any earlier text in this index describing M2 as active, in progress, 98.6%, or awaiting owner acceptance is historical and superseded by the [M2 Final Owner Acceptance and Closure Record](05-architecture/M2_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md) and [M2 Final Progress and Closeout Report](05-architecture/M2_FINAL_PROGRESS_AND_CLOSEOUT_REPORT_2026-11-12.md).


## Current M3 acceptance and next step — 2026-11-12
- [M3-00 Final Owner Acceptance and Closure Record](04-roadmap/M3-00_FINAL_OWNER_ACCEPTANCE_AND_CLOSURE_RECORD_2026-11-12.md) — owner accepted M3-00 at 100% for bounded planning outputs; substantive gates retained
- [M3-01 Implementation Planning and Authorization Work Plan](04-roadmap/M3-01_IMPLEMENTATION_PLANNING_AND_AUTHORIZATION_WORK_PLAN.md) — next planning step; implementation authorization NOT ISSUED

Earlier M3-00 open/75% statements in this index are historical and superseded by the final acceptance record. M3 overall weighted progress is 5%.


## M3-01 planning evidence
- [M3-01 Detailed Planning Evidence Pack](04-roadmap/M3-01_DETAILED_PLANNING_EVIDENCE_PACK.md) — baseline reconciliation, proposed first-slice options, blocker matrix and synthetic-only test/release plan; no implementation authorization


## M3-02 implementation
- [M3-02 Local/CI Foundation Hardening Implementation Record](05-implementation/M3-02_LOCAL_CI_FOUNDATION_HARDENING_IMPLEMENTATION_RECORD.md) — bounded environment defaults, safe diagnostics/logging and read-only repository-protection audit; no production or database scope.
- [M3-02 Environment Configuration and Diagnostics Baseline](05-implementation/M3-02_ENVIRONMENT_CONFIGURATION_AND_DIAGNOSTICS.md) — local/test/CI matrix, environment variable inventory, secret-handling and privacy-safe diagnostics rules.


## M3-02 reconciliation and governance audit — 2026-11-13
- [M3-02 Step 1–2 Reconciliation and Repository Governance Audit](04-roadmap/M3-02_STEP_01_02_RECONCILIATION_AND_GOVERNANCE_AUDIT_2026-11-13.md) — reconciles PR #139 merge, maps current M3-02 exit evidence, and records the read-only active ruleset audit and separately gated recommendations.

PR #139 is merged. M3-02 remains in progress and is not formally accepted; governance settings were not changed.


## M3-02 Step 3 — architecture conformance review (2026-11-13)
- [M3-02 Step 3 Architecture Conformance Review](04-roadmap/M3-02_STEP_03_ARCHITECTURE_CONFORMANCE_REVIEW_2026-11-13.md) — compares the current merged Laravel foundation against accepted M2 logical architecture and AI-era readiness criteria; records implemented, partial, not-implemented and unverified areas. Read-only review; no application changes.

Step 3 is complete as a review/documentation deliverable. The repository remains a foundation-only scaffold; M3-02 remains in progress and is not formally accepted.


## M3-02 Step 4 — final exit review and acceptance pack (2026-11-13)
- [M3-02 Step 4 Final Exit Review and Acceptance Pack](04-roadmap/M3-02_STEP_04_FINAL_EXIT_REVIEW_AND_ACCEPTANCE_PACK_2026-11-13.md) — final criterion-by-criterion evidence reconciliation and closure decision.

Step 4 is complete as a documentation/evidence deliverable. M3-02 remains in progress, not accepted and not closed: PHP foundation CI is not a required main ruleset check, and V2-specific environment isolation/recovery evidence remains unverified. The local/CI diagnostics baseline is accepted only at that bounded level.


## M3-03 Agenda 6 — Governance Service Contracts
- [Agenda 6 Governance Service Contract Implementation](04-roadmap/M3-03_AGENDA_06_GOVERNANCE_SERVICE_CONTRACT_IMPLEMENTATION.md) — bounded synthetic service/policy implementation, acceptance matrix, CI gate and explicit deferrals.

- [M3-03 Agenda 6 Completion and Evidence Record](04-roadmap/M3-03_AGENDA_06_COMPLETION_AND_EVIDENCE_RECORD.md) — final owner authorization, merged PR, exact-head CI evidence, bounded completion and deferred gates.


## M3-03 Agenda 7 — persisted adjudication and publication workflows
- [M3-03 Agenda 7 Persisted Adjudication and Publication Workflows](04-roadmap/M3-03_AGENDA_07_PERSISTED_ADJUDICATION_AND_PUBLICATION_WORKFLOWS.md) — bounded synthetic implementation scope, persistence/workflow safeguards, separation-of-duties feasibility and remaining technical/approval gates.

PR #162 contains the implementation candidate. Exact-head CI and documentation validation remain pending; Agenda 7 is not yet closed.


## M3-03 Agenda 7 — persisted governance workflow closeout
- [M3-03 Agenda 7 Persisted Adjudication and Publication Workflows](04-roadmap/M3-03_AGENDA_07_PERSISTED_ADJUDICATION_AND_PUBLICATION_WORKFLOWS.md) — completed bounded local/CI synthetic implementation.
- [M3-03 Agenda 7 Completion and Evidence Record](04-roadmap/M3-03_AGENDA_07_COMPLETION_AND_EVIDENCE_RECORD.md) — merged PR #163, exact-head CI/test evidence, limitations and remaining approval gates.

PR #163 is merged. Exact-head PHP 8.5 foundation CI run #111 and Project documentation validation run #430 passed. Agenda 7 is complete for its authorized scope; M3-03 remains in progress.


## M3-03 Agenda 8 — transactional outbox reliability and recovery
- [M3-03 Agenda 8 Outbox Reliability and Recovery](04-roadmap/M3-03_AGENDA_08_OUTBOX_RELIABILITY_AND_RECOVERY.md) — bounded synthetic claim leasing, stale-worker recovery, retries, dead-letter handling, event ordering and suppression race safeguards.

Agenda 8 is in progress on `feature/m3-03-agenda-08-outbox-reliability`; exact-head CI, documentation validation, review and merge evidence remain pending.

## M3-03 Agenda 8 — outbox reliability closeout
- [M3-03 Agenda 8 Outbox Reliability and Recovery](04-roadmap/M3-03_AGENDA_08_OUTBOX_RELIABILITY_AND_RECOVERY.md) — completed bounded local/CI synthetic claim, retry, recovery and projection-ordering safeguards.
- [M3-03 Agenda 8 Completion and Evidence Record](04-roadmap/M3-03_AGENDA_08_COMPLETION_AND_EVIDENCE_RECORD.md) — PR #165 merge SHA, exact-head CI runs, review reconciliation, limitations and remaining gates.

PR #165 merged as `3f547ca7b925c5445c296c5a6311bac2fa7d744d`. Exact-head PHP 8.5 foundation CI run #43527123064 and Project documentation validation run #43527123066 passed. Agenda 8 is complete for its authorized scope; M3-03 remains in progress.

## M3-03 Agenda 9 — Claim Version Lifecycle, Correction and Withdrawal
- [Agenda 9 Claim Version Lifecycle, Correction and Withdrawal](04-roadmap/M3-03_AGENDA_09_CLAIM_VERSION_LIFECYCLE_CORRECTION_AND_WITHDRAWAL.md)
- [Agenda 9 Completion and Evidence Record](04-roadmap/M3-03_AGENDA_09_COMPLETION_AND_EVIDENCE_RECORD.md)


Agenda 9 is completed for its bounded synthetic local/CI scope. PR #167 merged as `91c15204fb41ba5cc5a29b99a2dca80e983adc9d`; exact-head PHP 8.5 foundation CI and Project documentation validation passed. See the [Agenda 9 Completion and Evidence Record](04-roadmap/M3-03_AGENDA_09_COMPLETION_AND_EVIDENCE_RECORD.md).


## M3-03 Exit Reconciliation
- [M3-03 Exit-Criteria Reconciliation and M3-04 Entry Gate](04-roadmap/M3-03_EXIT_CRITERIA_RECONCILIATION_AND_M3-04_ENTRY_GATE.md)


## M3-03 Agenda 10 — persisted conflicts, temporal evaluation and rollback
- [M3-03 Agenda 10 Persisted Conflict Lifecycle, Temporal Evaluation and Prior-Snapshot Rollback](04-roadmap/M3-03_AGENDA_10_PERSISTED_CONFLICT_LIFECYCLE_TEMPORAL_EVALUATION_AND_ROLLBACK.md) — authorized synthetic-only implementation candidate, schema/service behavior, acceptance tests and retained gates.

Agenda 10 is authorized and under exact-head CI/review validation. M3-03 remains in progress; G-04 deterministic-oracle traceability and M3-03 owner acceptance remain open. M3-04 Provider Management remains blocked.


## M3-03 Agenda 10 — completed persisted conflict and rollback
- [Agenda 10 Persisted Conflict Lifecycle, Temporal Evaluation and Prior-Snapshot Rollback](04-roadmap/M3-03_AGENDA_10_PERSISTED_CONFLICT_LIFECYCLE_TEMPORAL_EVALUATION_AND_ROLLBACK.md) — completed bounded synthetic implementation.
- [Agenda 10 Completion and Evidence Record](04-roadmap/M3-03_AGENDA_10_COMPLETION_AND_EVIDENCE_RECORD.md) — PR #170 merge, exact-head CI, 209 assertions, review and acceptance evidence.

Agenda 10 is complete. M3-03 remains in progress solely for G-04 deterministic-oracle traceability and final exit acceptance; M3-04 Provider Management remains blocked.


## M3-03 G-04 — deterministic oracle traceability reconciliation
- [M3-03 G-04 Deterministic Oracle Traceability Reconciliation](04-roadmap/M3-03_G04_DETERMINISTIC_ORACLE_TRACEABILITY_RECONCILIATION.md) — complete T-001–T-032 and GS-001–GS-032 mapping to runtime tests, partial coverage and explicit deferrals; Product Owner acceptance remains pending.

M3-03 remains in progress pending G-04 owner acceptance and final exit review. M3-04 Provider Management remains blocked/not started.


G-04 traceability closeout: PR [#172](https://github.com/mattari20/listing-v2/pull/172) merged as `f8d9613eec6dca8356b0780ea871245104365736`; exact-head Project documentation validation #43533801162 and PHP 8.5 foundation CI #43533801164 passed. Product Owner acceptance remains pending; M3-03 is not yet accepted.


## M3-03 final acceptance and M3-04 planning
- [M3-03 Final Owner Acceptance and Exit Review](04-roadmap/M3-03_FINAL_OWNER_ACCEPTANCE_AND_EXIT_REVIEW_2026-11-14.md) — Product Owner acceptance of G-04 and final M3-03 closure for bounded synthetic local/CI scope; deferred cases remain explicit residual risk.
- [M3-04 Provider Management Work Plan](04-roadmap/M3-04_PROVIDER_MANAGEMENT_WORK_PLAN.md) — planning delivered for P01–P04; P01 implementation is delivered and validated in PR #176, while P02–P04 remain separately gated.

- [M3-04 P01 — Provider/Institution Identity and Typed Relationship Contract](04-roadmap/M3-04_P01_PROVIDER_INSTITUTION_IDENTITY_AND_RELATIONSHIP_CONTRACT.md) — selected claim/version integration, endpoint/predicate matrix, temporal/evidence rules and broader synthetic acceptance contract.
- [M3-04 P01 Implementation Record](04-roadmap/M3-04_P01_IMPLEMENTATION_RECORD.md) — implemented Provider–Institution relationship projection, governance lifecycle, synthetic test coverage, validation evidence and deferred scope.


## M3-04 P03 — Authority, Affiliation and Recognition Relationships
- [M3-04 Provider Management Work Plan](04-roadmap/M3-04_PROVIDER_MANAGEMENT_WORK_PLAN.md) — P03 implementation is separately authorized and submitted for exact-head CI/review; P04 remains separately gated.
- [M3-04 P03 Implementation Record](04-roadmap/M3-04_P03_IMPLEMENTATION_RECORD.md) — authority-type vocabulary, relationship endpoint compatibility, evidence/adjudication/audit contract, tests and exclusions.


P03 closeout: PR [#179](https://github.com/mattari20/listing-v2/pull/179) merged as `727cc3c91f9761bbb24954b8777e033f577ec75c`. Exact-head PHP 8.5 foundation CI #43555121150 and Project documentation validation #43555121154 passed. See [M3-04 P03 Implementation Record](04-roadmap/M3-04_P03_IMPLEMENTATION_RECORD.md). P04 remains separately gated.


## M3-04 P04 — Status History and Editorial Review

- [M3-04 P04 Implementation Record](04-roadmap/M3-04_P04_STATUS_HISTORY_EDITORIAL_REVIEW_IMPLEMENTATION_RECORD.md) — implementation scope, capability matrix, separation-of-duties rules, synthetic test coverage and validation status.


## M3-04 P04 — Status History and Editorial Review

- [M3-04 P04 Implementation Record](04-roadmap/M3-04_P04_STATUS_HISTORY_EDITORIAL_REVIEW_IMPLEMENTATION_RECORD.md) — merged PR #187, exact-head CI evidence, capability matrix, independent review/adjudication/publisher roles and synthetic-only limits.

P01–P04 are delivered and validated for their bounded synthetic local/CI scopes. M3-05 requires a separate scope review and authorization.


## M3-07 R1 and R2 — source and model decision readiness

- [R1 Pakistan National Education Source Master Inventory](04-roadmap/M3-07_R1_PAKISTAN_NATIONAL_EDUCATION_SOURCE_MASTER_INVENTORY.md) — merged in PR #204 as `08f2a7c68e327058b34fc8a9b49ec90e616a65c3`; exact-head PHP 8.5 foundation CI #43815723304 and documentation validation #43815723282 passed. The inventory is a research/decision baseline, not a national census or source-use permission.
- [R2 HEC Source-Specific Decision Pack](04-roadmap/M3-07_R2_SOURCE_SPECIFIC_DECISION_PACK_HEC_RECOGNISED_UNIVERSITIES.md) — desk assessment of GOV-04 HEC Recognised Universities/DAIs page; remains RESEARCH ONLY, with G2 rights and G4 retrieval gates blocked.
- [R2 Model and Provider Decision Pack](04-roadmap/M3-07_R2_MODEL_PROVIDER_DECISION_PACK.md) — options and approval criteria; no model/provider selected, no external inference, no spend.
- [R2 Completion and Decision Record](04-roadmap/M3-07_R2_COMPLETION_AND_DECISION_RECORD.md) — records R2 preparation completion and the remaining owner/qualified-review decisions.

R2 is complete as documentation/decision-pack preparation only. R3 is complete as a no-activation source-rights/model-feasibility reconciliation. GOV-04 remains RESEARCH ONLY, no model/provider is selected, and G2-G7 remain blocked. No source access, permission request, model activation, connector, scheduler, production activity or spend is authorized.


## M3-07 — Pakistan-wide discovery architecture and dynamic field governance
- [M3-07 National Education Coverage and Continuous Agent Plan](04-roadmap/M3-07_NATIONAL_EDUCATION_COVERAGE_AND_CONTINUOUS_AGENT_PLAN.md) — Pakistan-wide provider coverage, student lifecycle information, multi-source evidence, freshness and source-specific approval gates.
- [M3-07 Student-first Discovery Architecture and Dynamic Field Governance](04-roadmap/M3-07_STUDENT_DISCOVERY_PLATFORM_ARCHITECTURE_AND_DYNAMIC_FIELD_GOVERNANCE.md) — Search/AI Data-Agent/Central Database separation, dynamic field lifecycle and student-facing discovery principles.
- [M3-07 D1 Field Registry Contract](04-roadmap/M3-07_D1_FIELD_REGISTRY_CONTRACT.md) — immutable field identity/versioning, applicability, types, privacy, evidence, visibility and lifecycle rules; see linked D2-D5 records for storage, service boundaries, synthetic pilot and implementation proposal.
- [M3-07 R3 Source-Rights and Model-Feasibility Reconciliation](04-roadmap/M3-07_R3_SOURCE_RIGHTS_AND_MODEL_FEASIBILITY_RECONCILIATION.md) — no-activation disposition, R1/R2 gate status and I1-I3 delivery reconciliation.

I1-I3 are merged for bounded synthetic local/CI scopes. I4 was delivered and merged through PR #210 as `88345f0cfaea66bbdd841b0c18222b83307efac3`; exact-head PHP 8.5 foundation CI and documentation validation passed. I5-A through I5-C are delivered and merged in PRs #213–#216; see the I5 implementation record. I6's bounded synthetic adapter implementation is delivered, validated and merged in PR #220. I7's canonical D5 scope/design preflight is merged in PR #222; its authorized full regression/hardening test implementation is delivered, exact-head validated and merged in PRs #224–#225. Live source access and AI/provider activation remain blocked by G2-G9.

- [I4 Field Definition Governance Lifecycle Proposal](04-roadmap/M3-07_I4_FIELD_DEFINITION_GOVERNANCE_LIFECYCLE_PROPOSAL.md) — owner-authorized bounded scope.
- [I4 Implementation Record](04-roadmap/M3-07_I4_FIELD_DEFINITION_GOVERNANCE_IMPLEMENTATION_RECORD.md) — merged implementation, lifecycle controls, 17 synthetic test methods and exact-head validation evidence.


## M3-07 I5 — Value correction, withdrawal and profile integration

- [I5 Value Correction, Withdrawal and Profile Integration Preflight](04-roadmap/M3-07_I5_VALUE_CORRECTION_WITHDRAWAL_PROFILE_INTEGRATION_PREFLIGHT.md) — current-main reconciliation, exact definition-version correction binding, value-specific withdrawal/reinstatement, registry-aware allowlisted profile design, synthetic acceptance matrix and separate implementation authorization gate.
- [I6 Synthetic Agent Proposal Adapter Preflight](04-roadmap/M3-07_I6_SYNTHETIC_AGENT_PROPOSAL_ADAPTER_PREFLIGHT.md) — deterministic offline synthetic fixture adapter, fixed agent identity, narrow proposal-only submission path, human-review boundary, 22 acceptance criteria and separate implementation authorization gate.
- [I6 Synthetic Agent Proposal Adapter Implementation Record](04-roadmap/M3-07_I6_IMPLEMENTATION_RECORD.md) — fixed one-fixture implementation, one-capability agent identity, I3/editorial integration, denial audit, synthetic tests and exact-head CI evidence.
- [I7 Full Regression and Hardening Preflight](04-roadmap/M3-07_I7_FULL_REGRESSION_HARDENING_PREFLIGHT.md) — test-only I1-I6 regression scope, adversarial/concurrency/migration/rollback/privacy/performance coverage, acceptance gates and separate implementation authorization.
- [I7 Full Regression and Hardening Implementation Record](04-roadmap/M3-07_I7_IMPLEMENTATION_RECORD.md) — authorized synthetic-only test additions, 11-migration disposable-SQLite rollback/reinstall, independent-connection uniqueness/writer-lock checks, deterministic query-count regression, exact-head CI and concurrency limitations.

I5-A through I5-C are complete and merged in PRs #213–#216. The exact-version correction, withdrawal/reinstatement and registry-aware profile scope is closed for bounded synthetic/local/CI use; see [I5 Implementation Record](04-roadmap/M3-07_I5_IMPLEMENTATION_RECORD.md). I6's bounded deterministic synthetic adapter is implemented, exact-head validated and merged in PR #220 as `8acf05082187f854597aa6dd2d852d64e01e5581`; see [I6 Implementation Record](04-roadmap/M3-07_I6_IMPLEMENTATION_RECORD.md). I7's test-only full regression/hardening package is implemented, exact-head validated and merged in PRs #224–#225; see [I7 Implementation Record](04-roadmap/M3-07_I7_IMPLEMENTATION_RECORD.md). This does not complete or activate the live AI Data-Agent. G2-G9 continue to block live source access and AI/provider activation; connectors/schedulers, production/V1/Hostinger, deployment and additional spend remain excluded.


## M3-07 I8 — Synthetic Agent Readiness and Evaluation

- [I8 Synthetic Agent Readiness and Evaluation](04-roadmap/M3-07_I8_SYNTHETIC_AGENT_READINESS_EVALUATION.md) — bounded deterministic evaluation of eight source-authorization denial states against the fixed synthetic I6 adapter; records zero-write acceptance criteria and confirms that live source/model activation remains blocked.

I8-A adds synthetic feature-test coverage only. It does not add a model, source connector, external API, crawler, scheduler or autonomous publication capability. I8-A was implemented, exact-head validated and merged in PR #228; the live AI Data-Agent remains blocked by G2-G9.
- [M3-10 Owner Decision and Qualified Review Pack](04-roadmap/M3-10_OWNER_DECISION_AND_QUALIFIED_REVIEW_PACK.md) — Product Owner path decision, bounded charter, human accountability and qualified review evidence requests; no pilot approval implied

- [M3-10 Option B Bounded Pilot Proposal](04-roadmap/M3-10_OPTION_B_BOUNDED_PILOT_PROPOSAL.md) — provisional narrowly bounded proposal; for owner and qualified review only, not authorization to conduct


## M3-10 university workflow verification
- [M3-10 University Workflow Verification Record](04-roadmap/M3-10_UNIVERSITY_WORKFLOW_VERIFICATION_RECORD.md) — confirms the university category and synthetic service-layer governance controls, identifies the missing user-facing correction/review route, and defines the non-human synthetic tabletop boundary.


- [M3-10 University Synthetic Workflow Tabletop and Acceptance Evidence](04-roadmap/M3-10_UNIVERSITY_SYNTHETIC_WORKFLOW_TABLETOP.md) — non-human synthetic scenario and evidence map; prepared only, not executed, and not a usability pilot.


## M3-10 acceptance-gap reconciliation and agenda closeout — 2026-11-17
- [M3-10 Acceptance-Gap Reconciliation and Agenda Closeout](04-roadmap/M3-10_ACCEPTANCE_GAP_RECONCILIATION_AND_AGENDA_CLOSEOUT.md) — consolidated package/gate register, delivery traceability, university HTTP workflow gap, synthetic tabletop limitations and final blocked-readiness disposition. The authorized documentation/readiness-preparation package is complete; pilot readiness is not accepted and M3-11 remains unauthorized.


## M3-10 university representative workflow implementation
- [M3-10 University Representative Workflow Implementation Record](04-roadmap/M3-10_UNIVERSITY_REPRESENTATIVE_WORKFLOW_IMPLEMENTATION_RECORD.md) — authenticated university-only institution-scoped proposal/correction routes, separate reviewer workflow, synthetic-only source context, immutable correction successor and HTTP feature tests. Merged in PR #248 with exact-head PHP 8.5 CI and documentation validation passing; no pilot, public publication or launch authorized.


## M3-10 reviewer handoff and decision preparation

- [M3-10 Reviewer Handoff and Decision Preparation](04-roadmap/M3-10_REVIEWER_HANDOFF_AND_DECISION_PREPARATION.md) — owner and qualified-review evidence index, reviewer question packets, human accountability requirements and open-decision register. Documentation-only; no reviewer appointments, approvals, pilot activity or M3-11 authorization.

- [M3-10 External Review Response and Gate Reconciliation](04-roadmap/M3-10_EXTERNAL_REVIEW_RESPONSE_AND_GATE_RECONCILIATION.md) — controlled intake, finding response and evidence-based M10-G01–G14 reconciliation; documentation only, no approvals inferred, pilot readiness NOT ACCEPTED

- [M3-10 Governance Ledger and Roadmap Reconciliation](04-roadmap/M3-10_GOVERNANCE_LEDGER_AND_ROADMAP_RECONCILIATION.md) — current authoritative project-state reconciliation; M3-10 pilot readiness NOT ACCEPTED; M3-11 NOT AUTHORIZED


## M3-10 two-person synthetic rehearsal

- [M3-10 Two-Person Synthetic University Workflow Rehearsal Checklist](04-roadmap/M3-10_TWO_PERSON_SYNTHETIC_REHEARSAL_CHECKLIST.md) — paper-based, non-human tabletop guide for the Product Owner and ordinary-experience administrative assistant; synthetic values only, not executed, not a software test or usability pilot. Pilot readiness remains NOT ACCEPTED.


## M3-10 R13 documentary desk review and authorized agenda closeout — 2026-11-17

The R13 repository desk review assessed all twelve scenarios (R01–R12) in the two-person synthetic university workflow checklist against the merged representative API implementation, adversarial hardening evidence and governance records. Result: **12 CLEAR, 0 UNCLEAR, 0 BLOCKED** for documentary clarity only. No new application execution, software test, human usability evidence or specialist approval is claimed. See [M3-10 R13 Desk Review and Final Agenda Closeout](04-roadmap/M3-10_R13_DESK_REVIEW_AND_FINAL_AGENDA_CLOSEOUT.md).

**Authorized M3-10 readiness-preparation agenda: COMPLETE / CLOSED** for the repository-only, synthetic/local/CI and documentation scope authorized to date. The two-person tabletop remains NOT EXECUTED; M10-G01–G14 retain their existing open/blocked dispositions; pilot readiness remains NOT ACCEPTED; no pilot go/no-go is issued; human/participant activity and real-data processing remain NOT AUTHORIZED; M3-11 remains NOT AUTHORIZED. No standing restriction is relaxed.
