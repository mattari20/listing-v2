# Project Master Control

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Status:** M0 accepted and closed; M1-S01 through M1-S10 accepted and closed; M2 authorized and in progress  
**Last reconciled:** 2026-11-12

## Authoritative current position
- Public V2 repository visibility verified; owner selected public visibility on 2026-11-11.
- Repository auto-merge is enabled; active `main` ruleset requires the documentation validation check.
- Founding documentation PR #1 merged into `main` as `0f2165f3d18e43f10cf6d6f717f145d3433769a4`.
- Documentation Completion Catalogue: `../04-roadmap/DOCUMENTATION_CATALOG.md`; update after every documentation PR update and merge.
- No application code, database schema or migrations have been approved or started.
- Legacy repository inspection is read-only and limited to a metadata inventory for explicit exclusion.
- No connection to legacy production systems or data is permitted.
- No production deployment, URL cutover or replacement is authorized.

## Project objective
Build a student-first education discovery, admissions information and comparison platform, initially focused on Pakistan, supported by a lawful, multi-source, continuously refreshed and evidence-based education data catalogue.

## Documentation visibility
The Documentation Completion Catalogue is the owner-facing inventory of delivered, updated, accepted and planned documents. A merged PR records delivery, not automatic content acceptance. Every documentation PR update and merge must reconcile the catalogue, index, controller, step register, traceability and progress report.

## Current milestone
**M2 — Architecture and Design**

## M0 closeout
M0 was accepted after review of the founding controls, strict legacy non-interference boundary, project planning records, repository rules and the PR delivery workflow. Evidence is recorded in the catalogue, progress report and traceability matrix. M0-S02 acceptance is limited to the documented metadata-only exclusion audit; it is not an exhaustive inventory of the legacy repository. Repository auto-merge is enabled, but automatic merge execution has not yet been independently demonstrated. Production access, deployment and cutover remain unauthorized.

## Strict legacy non-interference rule
Legacy work must not influence V2 in any style or form: no code, schema, migrations, APIs, data, architecture, technology choices, UI patterns, workflows, tests, fixes, deployment practices, historical statuses or operational workarounds may be copied, adapted, ported, treated as templates or used as implicit design inputs. Legacy access is read-only for exclusion/audit purposes. V2 decisions must originate from V2 owner requirements, independent research and V2 validation. See `../99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md`.

## Research timing decision
The owner has directed that no student survey, interview, recruitment or research outreach be conducted during platform construction. The draft adult research instruments are retained as unapproved preparation material only and must not be distributed. The product will include account-based ratings and reviews; eligible visitors must log in to submit them after launch. This is a product feature, not a pre-launch research survey. Review eligibility, moderation, privacy and age-related safeguards remain design requirements to resolve before implementation and release.

## Next-step operating rule
At the beginning of every work session, the AI must:
1. Read this file and the current milestone/step register.
2. Inspect V2 repository state, open PRs, latest main commit and relevant CI.
3. Identify the first eligible, incomplete V2 step whose dependencies are satisfied.
4. Continue existing V2 work rather than restart or duplicate it.
5. Work only within the step's documented scope.
6. Confirm all task inputs comply with the strict legacy non-interference rule.

At the end of each step, update this controller with status, evidence, progress and the exact next authorized V2 step. Current state as of 2026-11-12: M1-S01 through M1-S07 are accepted and closed as research/documentation baselines. S06/S07 acceptance is recorded in `../03-research/M1_S06_S07_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`; no third-party code or dataset is approved for import or reuse. Joint S08/S09 research packages are delivered at 95% weighted completion each, with owner acceptance pending: `../03-research/M1_S08_AI_DATA_AGENT_WORKFLOW_RESEARCH_2026-11-12.md` and `../03-research/M1_S09_COMPARISON_REVIEWS_TRUST_RESEARCH_2026-11-12.md`. No agent or connector is activated, no source is accessed, no user review is collected and no pre-launch participant research occurs. No scraping, bulk download, ingestion, application implementation, database/schema changes, production access, deployment or legacy-repository interaction is authorized.

## Latest documentation delivery evidence
PR #23 reconciled PR #22's NAVTTC research update across the catalogue, progress report and traceability. Exact head `737ec6838dc85d4ba1becc600af661d998074c0a` passed required documentation validation (run #43145140802); merge commit `2a94f8caced03142fee56c5b6e6fc1afa2f6df65`. M1-S02 remains active; no source has been approved for reuse or ingestion.

## M1-S02 national synthesis status
A draft national institution coverage synthesis is now being prepared to consolidate the official-source discovery baseline and unresolved gaps across higher education, professional education, schools, TVET, non-formal and special education. S02-C08 is in progress; owner review (S02-C09) has not occurred. The synthesis does not establish complete national coverage or authorize collection/reuse. Continue source verification and gap closure before requesting owner acceptance.

## Latest M1-S02 delivery
PR #25 delivered a draft national institution coverage synthesis and updated the index, catalogue, step register, traceability and progress report. Exact head `703fc553aca6d06e354849a7a0d6a69bc71e53e7` passed required documentation validation (run #43145378929); merge commit `b06b669627d299ccd5d84416b787274a8e1dac76`. S02-C08 remains in progress; source verification and S02-C09 owner review remain outstanding. No source is approved for collection or reuse.

## M1-S02 current closeout position — 2026-11-12
Expanded source verification and national synthesis are documented in the coverage matrix, taxonomy, rights register and national synthesis. The weighted task register remains authoritative. S02-C01–C08 remain in progress where owner approval, complete jurisdiction coverage, source-specific terms, freshness or rights evidence remains unresolved. S02-C09 is not complete: the owner must review and explicitly accept the taxonomy, coverage limitations and research-only boundary. No source is approved for collection, ingestion, republication or commercial reuse. PR #26 merged as `246c75f66e41dca83202ad555fe7739d7e5cf5a1` after exact-head validation passed (run #43145461579).

## M1-S02 owner decision pending
PR #27 completed the current expanded desk-research/documentation pass and merged as `180a6cc19195362caabc3a029dc54c4cc5fc01da`; exact head `8890198905204d07e84c9825ce58b524b7ac27f7` passed required documentation validation (run #43147371049). The owner acceptance pack is `../03-research/M1_S02_OWNER_ACCEPTANCE_REVIEW.md`. M1-S02 remains In progress until the owner explicitly chooses whether to accept the research baseline with limitations carried forward or keep the step open. No source is approved for collection, manual verification, ingestion, republication or commercial reuse. M2 remains unauthorized.

## Latest M1-S02 review state
PR #28 merged as `2254d52f8799c137ad64e0c28502913453e6d218`; exact head `bbf694ed0d7e372b3e8d4c754b29e3773adbb9c4` passed required documentation validation (run #43147548460). The research package and owner acceptance review are complete as documentation deliverables. M1-S02 remains in progress pending the owner's explicit S02-C09 decision recorded in `../03-research/M1_S02_OWNER_ACCEPTANCE_REVIEW.md`. All candidate sources remain research-only. Do not begin M1-S03 until the owner resolves this acceptance gate; do not begin M2 or implementation.

## PR #29 evidence
PR #29 reconciled the PR #28 owner-review pack delivery. Exact head `52ed405a11b14e2698e046ebb407d3a53b8542ff` passed required documentation validation (run #43147641844); merge commit `8e88443a9d7da11fb1414774ad4766256033d16c`. A register formatting correction is being made separately; no task weights or acceptance decisions are changed. M1-S02 remains in progress pending owner decision.

## PR #30 evidence
PR #30 repaired the S02 task table formatting and reconciled PR #29. Exact head `4ca9d571206072064294f7fb163584db174669f8` passed required documentation validation (run #43147756202); merge commit `3553d75a5afd84e8fcfab372324342f7acad7456`. All nine task weights remain unchanged; S02-C09 still requires owner approval.

## PR #31 evidence
PR #31 reconciled PR #30 task-register correction evidence. Exact head `1f92b1d2c1021b3a2dc93ad9f00e8082b7158b2a` passed required documentation validation (run #43147833542); merge commit `63d9386a8d93a12cb3f609480f6d101b890bade0`. The S02 task table is verified at four columns per row with weights totaling 100%; the owner acceptance gate remains open.

## Completion status
M0 is accepted and closed. Future milestones require their own evidence-based acceptance and closeout.

## Progress rules
Use weighted step progress as defined in `../04-roadmap/MILESTONE_STEP_REGISTER.md`. Progress percentages are planning indicators, not substitutes for acceptance. A milestone closes only when all mandatory acceptance criteria pass.

## Safety boundaries
- Do not modify `mattari20/estudent-listing`, its databases, hosting, credentials, workflows or the live `https://estudent.pk/institutes/` service.
- Do not transfer legacy artifacts or patterns into V2.
- No production reads requiring credentials, production writes, migrations, backfills, deployment or cutover without separate explicit authorization and documented safeguards.
- Never expose secrets, private student data or credentials in issues, PRs or logs.

## Change control
Only this controller and approved V2 decision records define the current V2 plan. Legacy documentation, historical reports and implementation results are excluded and do not silently override V2 requirements.


## M1-S02 supplemental research continuation — 2026-11-12

The latest documentation-only pass added AJK private-school register evidence, Balochistan EMIS field/scope clarifications, NFEMIS national NFE inventory/dashboard evidence with a two-record total discrepancy, a GB EMIS zero-valued summary warning, HEC PQR/allied-health NOC distinctions, and historical-only KP special-education evidence. The detailed supplement is ../03-research/M1_S02_SUPPLEMENTAL_SOURCE_COVERAGE_REVIEW_2026-11-12.md. S02-C04/C06/C07/C08 remain in progress; S02-C09 still requires the owner's explicit decision. No source is approved for collection or reuse, and M1-S03/M2 remain unauthorized until the owner acceptance gate is resolved.


## PR #33 latest delivery evidence — 2026-11-12

PR #33's supplemental official-source coverage review merged as `f6c22c70d4128784b2e3b76cd4115113ad7e5329`. Exact head `09a3051043bf47825360cf03ea220c11eff121f7` passed the required Project documentation validation check (run #43151991943). The source matrix, rights register, synthesis, owner review pack and project control records were updated. M1-S02 remains active; the owner acceptance gate is unresolved. Do not begin M1-S03 or M2, and do not collect or reuse source data.


## PR #34 final reconciliation evidence — 2026-11-12

PR #34 reconciled PR #33's supplemental source review evidence and merged as `569ef14f0cc4ef72bb07cf0313965e13250eac3d`. Exact head `fce8164fe73bf435aa7c021ac3b8eb7e521c89a7` passed required Project documentation validation (run #43152117268). M1-S02 remains active; do not begin M1-S03 or M2 until the owner resolves S02-C09. All sources remain research-only.


## M1-S02 second supplemental research pass — 2026-11-12

A further source review added PCATP programme-state evidence, NCT FTJ/BEMS routes, AHPC applications-versus-recognition distinction, NTC zero/interim and intake-batch evidence, the unresolved NAEAC register, and ICT DGSE mandate information. Current complete special-education registers for KP, Balochistan, AJK and GB remain unverified; historical material is not treated as current. The detail is in ../03-research/M1_S02_SUPPLEMENTAL_PROFESSIONAL_COUNCIL_SPECIAL_EDUCATION_REVIEW_2026-11-12.md. S02-C03/C06/C07 remain active; S02-C09 remains an owner-only gate. All sources remain research-only.

## PR #35 final reconciliation evidence — 2026-11-12

PR #35 reconciled PR #34 merge evidence and merged as `0cb1c8cf1dba9fb0b90b1fa8bda16123d57c65f6`; exact head `48626561f492c03baab9ce72fb79e7a24a01640f` passed required Project documentation validation (run #43152199340). M1-S02 remains active and owner acceptance is still pending.


## PR #36 latest research delivery — 2026-11-12

PR #36 merged the professional-council and special-education supplement as `c0a5e0cc743336610b0eef5d5e56fde5406d92db`; exact head `fb629563b395a29b4d02df443acaa63c4cd38f01` passed required Project documentation validation (run #43152421589). M1-S02 remains active; source families remain research-only, and S02-C09 requires the owner's explicit decision.


## M1-S02 deep jurisdiction and TVET research — 2026-11-12

A further documentation-only pass adds Punjab/Sindh/GB special-education source leads; Balochistan proposed-versus-operational facility distinction; KP-TEVTA, STEVTA, Punjab TEVTA and B-TEVTA institute evidence; and excludes NAVTTC's staging/sample directory from evidence. HEC Digital Library and PASTIC are discovery leads only. Full findings are in `../03-research/M1_S02_DEEP_JURISDICTION_SPECIAL_ED_TVET_REVIEW_2026-11-12.md`. S02-C04/C05/C06/C07/C08 remain active; S02-C09 remains owner-only. No source reuse or collection is authorized.

## M1-S02 ICT PEIRA and Madaris continuation — 2026-11-12

Latest research adds ICT-PEIRA's paginated private-education register/status model, DGRE's nationwide Deeni Madaris registration authority and IBCC's QAB-versus-qualification-equivalence distinction. Deeni Madaris are a distinct provisional provider family; DGRE registration, awarding-body recognition and credential equivalence remain separate. DGRE maslak data is excluded from general discovery. Detailed findings are in `../03-research/M1_S02_ICT_PEIRA_MADARIS_QAB_REVIEW_2026-11-12.md`. S02-C01/C04/C05/C07/C08 remain active; S02-C09 remains owner-only; all sources remain research-only.

## PR #38 latest delivery evidence — 2026-11-12

PR #38 merged as `a38fa149d10be99903ca6bb44236bd1e68565e6a`; exact head `f1f7aa59424b5161ec91a3f3ae60ff20471edba2` passed required Project documentation validation (run #43153839019). Deep jurisdiction and TVET evidence is incorporated; M1-S02 remains active and S02-C09 remains owner-only.


## M1-S02 examination-board and DGRE jurisdiction research — 2026-11-12

The latest pass adds IBCC board categories, Punjab BISE jurisdictions, Punjab Medical Faculty affiliated institute routes, and DGRE regional jurisdiction plus 2024 registered-Madaris lists across multiple territories. Record anomalies and freshness limits are documented; board affiliation, examination jurisdiction, provider registration and qualification equivalence remain separate. Full review: `../03-research/M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md`. S02-C01/C03/C05/C07/C08 remain active; S02-C09 owner-only.

## PR #39 latest delivery evidence — 2026-11-12

PR #39 merged as `0ace505ec67a420b8c2eb8fedd13ba1a2499f84c`; exact head `cf4d54967cad1f2114cd1f43dfccec5184d1b759` passed required Project documentation validation (run #43154066994). ICT PEIRA, DGRE Madaris and IBCC QAB evidence is incorporated; M1-S02 remains active and owner acceptance is pending.


## M1-S02 HEC affiliation and programme status continuation — 2026-11-12

HEC's 2024 affiliation policy covers approved study centres and MoU-operated centres as well as affiliated colleges; current continuation must be verified at DAI/college/programme level. PM&DC, PCP and PNMC examples reinforce time/session-specific programme statuses and freshness checks. See the examination-board/PMF/DGRE review. S02-C02/C03/C07/C08 remain active; owner gate remains pending.

## PR #40 latest research delivery — 2026-11-12

PR #40 merged as `c92d96613dcb510762be5a0a615a73e856861f9b`; final exact head `cc2cc7eaa615e4fe762f808e51918b6b10b5e235` passed required Project documentation validation (run #43154387281). Board, PMF, DGRE and HEC affiliation/study-centre evidence is now incorporated. M1-S02 remains active; S02-C09 is still owner-only.


## M1-S02 national rights and privacy review — 2026-11-12

The latest desk review clarifies that the National Data Governance Policy 2026 and Personal Data Protection Bill May 2023 remain listed as drafts by MoITT; RTI access is not a general reuse license; copyright in compilations and underlying data must be distinguished; and PBS's open license is limited to PBS products/tiers. The detailed source-rights framework is in `../03-research/M1_S02_DATA_RIGHTS_PRIVACY_FRAMEWORK_REVIEW_2026-11-12.md`. S02-C07/C08 remain active; no education source is approved for collection/reuse.

## PR #41 final reconciliation evidence — 2026-11-12

PR #41 reconciled PR #40 delivery evidence and merged as `c56200bdf66a5fdf615de0da6281495e50c39f92`; exact head `2c11bfc7fe74da6bed4dc04d17c4c80a664990b0` passed required Project documentation validation (run #43154481312). M1-S02 remains active and S02-C09 remains owner-only.


## M1-S02 school-jurisdiction research continuation — 2026-11-12

Latest review adds AJK public/private census and 6,019 aggregate; GB EMIS details, BECS community-school list and public colleges; Sindh's region-to-UC institution checker; and Punjab PEPRIS eLicense caveats. Full evidence is in `../03-research/M1_S02_AJK_GB_SINDH_SCHOOL_REGISTER_REVIEW_2026-11-12.md`. S02-C04/C06/C07/C08 remain active; S02-C09 remains owner-only.

## PR #42 latest rights research delivery — 2026-11-12

PR #42 merged as `a6b35abcb091965f90e492e36378750b2f20ebad`; exact head `80a85a42418ee0176f3fad6ad63e0220f1978c8b` passed required Project documentation validation (run #43154673045). National rights/privacy context is documented, but no source-specific reuse permission is granted. M1-S02 remains active.


## M1-S02 Sindh private and KP registration-state evidence — 2026-11-12

The school-source review now includes Sindh DIRPIS/SPEI-EMIS private registration/census as a distinct stream and KPPSRA ACTIVE/BLOCKED/DORMANT/CLOSED statuses. District/jurisdiction completeness, freshness and rights remain open. See the AJK/GB/Sindh review supplement. S02-C04/C07/C08 remain active.

## PR #42 latest rights research delivery — 2026-11-12

PR #42 merged as `a6b35abcb091965f90e492e36378750b2f20ebad`; exact head `80a85a42418ee0176f3fad6ad63e0220f1978c8b` passed required Project documentation validation (run #43154673045). National rights/privacy context is documented, but no source-specific reuse permission is granted. M1-S02 remains active.


## M1-S02 school regulator and terms research — 2026-11-12

KPPSRA registration/renewal versus BISE affiliation, Sindh DIRPIS safety notices versus complete register, HEC Digital Library publisher license scope and NAVTTC aggregate count scope are now documented. Full evidence is in `../03-research/M1_S02_SCHOOL_REGULATOR_STATUS_TERMS_REVIEW_2026-11-12.md`. S02-C04/C05/C07/C08 remain active; S02-C09 owner-only.

## PR #43 latest school-source delivery — 2026-11-12

PR #43 merged as `a8dfd8018fa33588a4d35166c953b18f89e39c43`; final exact head `56923aca98123dce6b8a574e0cf9f9c244b036b4` passed required Project documentation validation (run #43155004215). AJK/GB/Sindh/Punjab school-source evidence is incorporated; M1-S02 remains active and owner acceptance remains pending.


## M1-S02 KP/ICT/AJK public-sector coverage continuation — 2026-11-12

The latest review records KP public iEMIS as role-based, FDE ICT as aggregate-only (432 institutions) and AJK HED's unresolved 178/180 college aggregate discrepancy. Full findings: `../03-research/M1_S02_KP_ICT_AJK_COLLEGE_COVERAGE_REVIEW_2026-11-12.md`. S02-C02/C04/C07/C08 remain active; S02-C09 remains owner-only.

## PR #44 latest delivery evidence — 2026-11-12

PR #44 merged as `11ee337d823731d71a9c0ca00782728ad1994398`; exact head `0b5fe6429a1f6bc8bb383d1db1278d632ae04f08` passed required Project documentation validation (run #43155204020). School-regulator status and terms distinctions are incorporated; M1-S02 remains active.


## Authoritative update — M1-S02 accepted; M1-S03 active (2026-11-12)

M1-S02 was explicitly accepted by the owner and closed at 100% weighted task completion. The acceptance record is `../03-research/M1_S02_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`; the final task register and progress report are reconciled. The next authorized step is **M1-S03 — Official Government and Regulator Provider Research**, now in progress. Its weighted task breakdown is in `../04-roadmap/MILESTONE_STEP_REGISTER.md`; the initial official-source register is `../03-research/M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md`.

Owner product requirement V2-DEC-006: Deeni Madaris are included in the underlying provider scope but hidden from public listings by default at launch. A configurable `Show Deeni Madaris` setting is required, default OFF; only an authorized administration/configuration path may change it. Exact UI and roles are deferred to M2 design. No implementation is authorized.

M1-S03 remains documentation/research-only. No scraping, bulk download, source-owner contact, permission requests, source ingestion, connectors, application code, database/schema changes, production access, deployment, legacy-repository interaction, M1-S04 or M2 work is authorized.


## M1-S03 supplemental research update — 2026-11-12

The M1-S03 official-source register has been expanded with NFEMIS, DGSE, Sindh DEPD, GB EMIS school details and GB public-college routes. New quality findings include unstable NFEMIS dashboard totals, a DGSE ministry-attribution discrepancy across official pages, Sindh DEPD's mixed education/rehabilitation provider rows and exposed staff personal contacts, and GB EMIS administrative-office rows plus a zero-valued summary dashboard despite populated school details. See `../03-research/M1_S03_NFE_SPECIAL_ED_GB_SOURCE_REVIEW_2026-11-12.md`. S03-C02 and S03-C05 remain in progress; M1-S03 remains documentation/research-only. No ingestion, scraping, source-owner contact, permission request, implementation, database/schema changes, production access or deployment is authorized.


## M1-S03 professional regulator research update — 2026-11-12

The official-source register now includes professional regulator routes for PMDC, PCP, PNMC, NCEAC, NACTE, PEC, NTC, PVMC and PBC. New findings reinforce programme/batch-specific approval, time-bounded accreditation, admissions stoppage, under-discussion and zero/interim distinctions; some public pages have stale/inconsistent fields or unclear reuse terms. See `../03-research/M1_S03_PROFESSIONAL_REGULATOR_SOURCE_REVIEW_2026-11-12.md`. S03-C03 remains in progress. No source reuse, ingestion, scraping, source-owner contact, permission request or implementation is authorized.


## M1-S03 AJK education source update — 2026-11-12

The AJK E&SE/EMIS/PEIRA and HED college routes have been verified and added to the official provider source register. The 6,019-school homepage aggregate lacks a clear as-of date; the private register announcement links to a sign-in-gated file; HED public pages report 180 versus 178 colleges. See `../03-research/M1_S03_AJK_EDUCATION_SOURCE_REVIEW_2026-11-12.md`. S03-C02 remains in progress; no source reuse, access bypass or ingestion is authorized.


## M1-S03 TVET and QAB source research — 2026-11-12

The official-source register now includes NAVTTC's 14 production QAB routes, Punjab TEVTA/PSDA/TTB, Sindh STEVTA, KPTEVTA and B-TEVTA/BSIS. Key findings: QABs assess/certify and are not necessarily providers; Punjab TTB has separate TEVTA, non-TEVTA, Deeni Madaris and jail-centre lists; Sindh STEVTA is filter-driven; KPTEVTA tables combine institutes and courses; B-TEVTA's six-versus-16 counts and BSIS 413-versus-112 categories remain unreconciled. Some Deeni Madaris are listed in vocational training arrangements, but this does not change their hidden-by-default requirement. Cross-category visibility of a separately registered TVET provider at a Madrasah location is deferred to M2 design. Full note: `docs/03-research/M1_S03_TVET_QAB_SOURCE_REVIEW_2026-11-12.md`.

S03-C04 remains in progress. All sources remain RESEARCH ONLY; no scraping, bulk download, source-owner contact, permission request, ingestion, implementation, database/schema changes or production access is authorized.


## M1-S03 federal data source update — 2026-11-12

PIE's official mandate confirms federal coordination and support to provincial/regional EMIS units. Pakistan Education Statistics 2024 states that private-college data are not maintained by most jurisdictions except Punjab and KP. The 2021–22 report records Wafaq-based Madaris aggregates and repeated data for some non-reporting Wafaqs. FBISE's public affiliated-institution table displayed 3,315 records across multiple jurisdictions and overseas locations; this is examination affiliation, not institutional recognition. See `../03-research/M1_S03_FEDERAL_DATA_FBISE_SOURCE_REVIEW_2026-11-12.md`. S03-C01 remains in progress.


## M1-S03 FDE/FGEI distinction — 2026-11-12

FDE's current portal displays 432 ICT institutions and has separate admissions and GIS/EMIS routes. FGEI C/G is a separate federal directorate under IGT&E; indexed official pages report 311 schools and 49 colleges across cantonment/garrison regions, but record-level pages were access-limited. FDE, FGEI and FBISE must remain distinct source/authority relationships. See `../03-research/M1_S03_FDE_FGEI_SOURCE_REVIEW_2026-11-12.md`. S03-C02 remains in progress.


## M1-S03 jurisdictional source matrix update — 2026-11-12

A consolidated public/private school-source matrix now covers Punjab, Sindh, KP, Balochistan, ICT, AJK and GB, with source routes, access, freshness, rights and remaining gaps. The source register adds Punjab PMIU/PEPRIS, Sindh private-school registration criteria and KP public iEMIS/KPPSRA. Full matrix: `../03-research/M1_S03_JURISDICTIONAL_SCHOOL_SOURCE_MATRIX_2026-11-12.md`. S03-C02 remains in progress pending task-by-task acceptance audit.


## M1-S03 additional accreditation-council research — 2026-11-12

Additional official routes have been reviewed for HEC's accreditation-council map, NBEAC, NCH, PCATP, AHPC and NAEAC. The register distinguishes NBEAC's programme/department accreditation and session status; NCH's recognized-college list and freshness limitations; PCATP's programme accreditation/NOC and professional registration routes; AHPC's applicant-only list (not approval); and NAEAC's agriculture-programme scope and current-register gap. See `../03-research/M1_S03_ADDITIONAL_ACCREDITATION_COUNCIL_REVIEW_2026-11-12.md`. S03-C03 remains in progress.


## M1-S03 task acceptance audit

The 48-source official provider register, jurisdictional school matrix and eight supplemental research notes have been assessed in `../03-research/M1_S03_TASK_ACCEPTANCE_EVIDENCE_AUDIT_2026-11-12.md`. S03-C01 to C08 meet their stated research/documentation criteria with limitations; the owner accepted C09 on 2026-11-12. M1-S03 is accepted and closed at 100% weighted task completion as a research baseline only. This does not authorize source reuse or ingestion.


## M1-S03 owner acceptance and closeout — 2026-11-12

The owner explicitly approved M1-S03 after review of the 48-source official provider register, jurisdictional school-source matrix, eight supplemental reviews, task acceptance evidence audit and documented limitations. C09 is accepted and M1-S03 is closed at **100% weighted task completion** as a research baseline only. The acceptance record is `../03-research/M1_S03_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`.

The accepted research does not establish a complete national institution census or blanket source-reuse rights. Only the previously documented narrow SED Balochistan headline/district aggregate permission remains. All other sources remain RESEARCH ONLY. V2-DEC-006 remains binding: Deeni Madaris are in underlying provider scope but hidden from public listings by default, with a configurable authorized `Show Deeni Madaris` setting default OFF. No source ingestion, scraping, implementation, database/schema changes, production access, deployment, M1-S04 or M2 work is authorized by this acceptance. The next M1 step requires separate owner authorization.


## PR #69 closeout delivery evidence — 2026-11-12

PR [#69](https://github.com/mattari20/listing-v2/pull/69) merged as `4c6d076fef9d09a2900ca8e9e265ea6176ed5d6c`; exact head `c6120094139e2f2a7296fd4e59649928c0ddc161` passed required Project documentation validation (run [#43163951606](https://github.com/mattari20/listing-v2/actions/runs/43163951606)). The owner acceptance record and final 100% task status are now part of the default-branch control documents.


## Authoritative update — M1-S01 closeout package ready for owner acceptance (2026-11-12)

The M1-S01 desk-research and requirements closeout package is merged to `main` by PR [#71](https://github.com/mattari20/listing-v2/pull/71), merge commit `64bd568d522e41452b8b46db8652ec8df48a2d8b`. Exact PR head `2982bdf421e09e82c03b76c223adb1b6ecc0b180` passed required Project documentation validation (run [#43166985628](https://github.com/mattari20/listing-v2/actions/runs/43166985628)). The updated journey research has eight evidence items, including PBS HIES 2024–25 and Pakistan Education Statistics 2023–24; it separates source findings from hypotheses and limitations. The student discovery specification defines SR-01–SR-14 with measurable, implementation-neutral acceptance scenarios. Product Vision, traceability, step register, progress report, roadmap and catalogue are reconciled.

M1-S01 weighted documentation tasks total 100% (T01 35%, T02 15%, T04 25%, T05 25%). T03 primary interviews/survey is explicitly owner-deferred and has 0% weight. No interviews, surveys, recruitment, outreach, usability testing or participant validation are claimed or authorized. The archived instrument kit must remain inactive.

The closeout review pack is `../03-research/M1_S01_CLOSEOUT_REVIEW_2026-11-12.md`. M1-S01 remains **Ready for owner acceptance**, not Accepted, until the owner reviews and explicitly accepts the package. After acceptance, M1-S04 remains the next planned step and requires separate owner authorization. M2, implementation, production access and deployment remain outside this closeout.


## Authoritative update — M1-S01 accepted; M1-S04 active (2026-11-12)

The owner explicitly accepted M1-S01 as a completed construction-stage desk-research and requirements baseline. Acceptance is recorded in `../03-research/M1_S01_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`; primary student research remains deferred.

M1-S04's initial private-provider source register is delivered and merged in PR [#73](https://github.com/mattari20/listing-v2/pull/73), merge commit `a66400189b2f2216e3743fe7b40a7f672cfb240a`. Exact PR head `099f99289399bc95b6cdd2ca9aafdb023bf5a352` passed required Project documentation validation (run [#43169707414](https://github.com/mattari20/listing-v2/actions/runs/43169707414)). The register records 21 source families and a seven-jurisdiction coverage assessment. Its weighted task register is 95% complete, with T09 owner acceptance pending. The register is research-only; no scraping, bulk download, source-owner contact, permission request, data ingestion or reuse approval has occurred. M1-S04 does not authorize M2, implementation, production access or deployment.


## Authoritative update — M1-S04 accepted; M1-S05 active (2026-11-12)

The owner explicitly accepted M1-S04 as the private-provider research baseline, with its documented jurisdictional gaps and source-rights limitations. See `../03-research/M1_S04_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`.

M1-S05 is now active. Its 22-source research register and federated programme/admissions evidence model are in `../03-research/M1_S05_PROGRAMME_ADMISSIONS_SOURCE_RESEARCH_2026-11-12.md`. T01–T09 are complete at 95% weighted research/documentation completion; T10 owner acceptance remains pending. No applicant data has been collected and all source families remain RESEARCH ONLY. No source collection, reuse, ingestion, M2 architecture, application implementation, database/schema work, production access or deployment is authorized.


## M1-S05 delivery evidence — PR #75

PR [#75](https://github.com/mattari20/listing-v2/pull/75) merged as `cb3adbfef07c49d61f2532026e51a817f3e43afb`. Exact PR head `164744a948d33c3484cc1e611901e3902718fe7b` passed required Project documentation validation (run [#43170713563](https://github.com/actions/runs/43170713563)). The programme/admissions research baseline is delivered; owner acceptance remains pending. No source collection, applicant data collection, reuse, ingestion or connector activation is authorized.


## M1-S06/S07 acceptance and M1-S08/S09 current position — 2026-11-12

The owner explicitly accepted M1-S05 and authorized joint continuation to S06/S07. Formal S05 acceptance record: `../03-research/M1_S05_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. S06 and S07 research packages are delivered at 90% weighted completion each, with owner acceptance pending. Candidate dispositions are documented; no external software or dataset is approved for reuse. The next research steps after owner review are M1-S08 and M1-S09, followed by M1-S10 synthesis. M2 remains blocked until M1 is completed and accepted.


## PR #77 merge and exact-head validation evidence — 2026-11-12

PR [#77](https://github.com/mattari20/listing-v2/pull/77) merged into `main` as `71e71ce74a57b854724027a1b106befe826b14fa`. The final PR head `deef364831cf4f0d902128ce9933897b17f9649c` passed the required **Project documentation validation** check (run [#43171586968](https://github.com/mattari20/listing-v2/actions/runs/43171586968)); the job completed successfully. The merge delivered the S05 owner-acceptance record and S06/S07 research packages, plus reconciled project-control documents. S06 and S07 remain owner-acceptance pending at 90% weighted completion each. This delivery does not authorize source collection, code/data import, reuse, ingestion, connector activation or implementation.


M1-S06 and M1-S07 have been accepted and closed as research baselines. The owner authorized joint S08/S09 research. Both packages are delivered at 95% weighted completion; owner acceptance remains pending. M1-S10 is the next step after S08/S09 acceptance. M2 remains blocked until the complete M1 synthesis and owner acceptance. See the progress report and step register for exact task evidence.


## PR #79 merge and exact-head validation evidence — 2026-11-12

PR [#79](https://github.com/mattari20/listing-v2/pull/79) merged into `main` as `59ab010830182a169fd609172618002ee8327fd3`. The exact PR head `4fed8a8d9f49c361539042f1f109102b9d6f4df2` passed the required **Project documentation validation** check (run [#43174230801](https://github.com/actions/runs/43174230801)); the validation job completed successfully. The merge delivered S08/S09 research, aligned product/data requirements and project controls, and recorded S06/S07 owner acceptance. S08 and S09 remain at 95% weighted completion each, with owner acceptance pending. No implementation or source access is authorized.


## Authoritative update — S08/S09 accepted; M1-S10 ready for final acceptance (2026-11-12)

The owner explicitly accepted M1-S08 and M1-S09. Formal record: `../03-research/M1_S08_S09_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. Both steps are Accepted and Closed at 100% weighted task completion as research/documentation baselines. Their open policy decisions and limitations remain binding and are carried into M2.

M1-S10 final synthesis is delivered in `../03-research/M1_S10_FINAL_SYNTHESIS_CLOSEOUT_REVIEW_2026-11-12.md`. It reconciles S01–S09, maps cross-step requirements, consolidates G01–G20, defines M2 entry requirements and records exclusions. S10 is 95% complete; the 5% owner acceptance task is pending. **M1 remains open pending explicit owner acceptance of S10.**

Upon S10 acceptance, M1 may be marked Accepted and Closed and M2 architecture/design may be separately authorized. This does not authorize application implementation, source access/ingestion, database/schema changes, production access, deployment or URL cutover. Application implementation remains prohibited until M2 is completed and accepted. V2-DEC-006 (Deeni Madaris public visibility default OFF), no primary research during construction, post-launch reviews, deny-by-default source rights and all privacy/security safeguards remain binding.


## PR #81 delivery and exact-head validation evidence — 2026-11-12

PR [#81](https://github.com/mattari20/listing-v2/pull/81) delivered the S08/S09 owner-acceptance record and M1-S10 final synthesis package. Exact PR head `5d421241b2e643fb8291ff9f183aaa3205005a89` passed required **Project documentation validation** (run [#43175231085](https://github.com/mattari20/listing-v2/actions/runs/43175231085)); the `Validate project control documents` job and all steps completed successfully. PR #81 was squash-merged as `8ab22c7b2ca759db741660fbafd6a0c36edcce6d`.

S08 and S09 are accepted and closed at 100% weighted task completion each. S10 is delivered at 95%; its final 5% owner-acceptance task remains pending. M1 is therefore **Ready for final owner acceptance, not yet formally closed**. No M2 work or implementation is authorized by this merge.


## Authoritative update — M1-S10 accepted; M1 closed (2026-11-12)

The owner explicitly accepted the final M1-S10 synthesis and authorized closure of M1. Formal record: `../03-research/M1_S10_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. S10-T10 is accepted; S10 is 100% and Accepted and Closed. All M1 steps S01–S10 are now accepted and closed. **M1 is formally Accepted and Closed as a research/documentation milestone.**

G01–G20 and all limitations remain carried forward; acceptance is not a waiver of rights, privacy, quality or product-policy controls. V2-DEC-006 remains binding (Deeni Madaris public visibility defaults OFF); primary participant research remains deferred during construction; reviews remain post-launch; unapproved external sources and third-party software/data remain RESEARCH ONLY. No source collection/ingestion, connector or agent activation, application implementation, database/schema change, production access, deployment or URL cutover is authorized.

M2 architecture/design is **Planned, not started**. It requires separate explicit owner authorization. Application implementation remains prohibited until M2 is completed and separately accepted.


## PR #83 delivery and exact-head validation evidence — 2026-11-12

PR [#83](https://github.com/mattari20/listing-v2/pull/83) recorded final owner acceptance of M1-S10 and formal M1 closeout. Exact PR head `30d5c7ecfc929cd680c3da8d076774904ec2d67a` passed required **Project documentation validation** (run [#43175799695](https://github.com/mattari20/listing-v2/actions/runs/43175799695)); the `Validate project control documents` job and all steps completed successfully. PR #83 was squash-merged as `af88a88693e66e9fb0a459d14ba1028e5fd3f97d`.

S10-T10 is accepted; S10 is 100%. M1-S01 through M1-S10 are all Accepted and Closed. M1 is formally **Accepted and Closed** as a research/documentation milestone. M2 remains Planned and requires separate explicit owner authorization; no application implementation is authorized.


## Authoritative M2 current position — 2026-11-12

The owner explicitly authorized M2 architecture/design on 2026-11-12. M0 is accepted and closed. M1-S01 through M1-S10 are all accepted and closed; the formal owner acceptance record is `../03-research/M1_S10_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`, and the final synthesis is `../03-research/M1_S10_FINAL_SYNTHESIS_CLOSEOUT_REVIEW_2026-11-12.md`.

**Current milestone: M2 — Architecture and Design.** M2 is authorized and active, with M2-S00 (baseline reconciliation and architecture documentation controls) as the first step. The governing charter and step plan are `../05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md` and `../05-architecture/M2_STEP_PLAN.md`.

This current-position section supersedes older chronological entries in this controller that say M1 acceptance was pending or M2 was unauthorized/planned. Those entries are retained as historical delivery records, not current status.

M2 authorizes research, analysis and documentation only. Application implementation, physical database/schema design or migrations, production access, source retrieval/ingestion, connector/agent activation, procurement/new spend, deployment and URL cutover remain unauthorized. No legacy V1 artifacts or practices may be used as design inputs.

All M1 G01-G20 limitations and owner decisions remain in force. In particular, V2-DEC-006 requires Deeni Madaris to remain in underlying provider scope with public visibility default OFF; while OFF, exclude the category from public search, browse, maps, recommendations, counts, sitemaps, exports and public APIs, without deleting records or exposing sect/maslak attributes. All unapproved source families and third-party software/data remain RESEARCH ONLY. Primary participant research remains deferred during construction; reviews remain post-launch.

The next eligible step after M2-S00 is M2-S01 — System Requirements and Architecture Boundaries. M3 implementation remains gated until the complete M2 architecture package is separately accepted by the owner.


## M2-S00 completion and PR #85 merge evidence — 2026-11-12

M2-S00 is complete (100% task completion) as a documentation/control step. PR [#85](https://github.com/mattari20/listing-v2/pull/85) merged to `main` as `17a2e3ad43ba1fd5ca3cb7a163670a2f19dd3783`. Exact PR head `650f5dfe11b9f1f76c2c005c3914186a8c41e23b` passed required Project documentation validation, workflow run [#43180488082](https://github.com/mattari20/listing-v2/actions/runs/43180488082), job “Validate project control documents” — success.

The M2 charter, 11-step weighted plan, architecture documentation structure, ADR template/register, diagram conventions and initial traceability scaffold are on main. README, controller, roadmap, step register, progress report, catalogue, documentation index, decision register and M1 synthesis were reconciled. M1 remains Accepted and Closed; M2 is active; no application stack or production architecture has been selected.

**Next eligible step: M2-S01 — System Requirements and Architecture Boundaries.** M2 remains documentation/design only. M3 implementation remains gated until final M2 owner acceptance.


## M2-S01 current work — 2026-11-12

M2-S01 is now in progress. Draft deliverables are in `../05-architecture/M2-S01_SYSTEM_REQUIREMENTS_AND_BOUNDARIES.md`, `../05-architecture/M2-S01_SYSTEM_CONTEXT.md` and `../05-architecture/M2-S01_QUALITY_SCENARIOS.md`. Architecture-level AR-001–AR-025 and an initial traceability map have been established. Four of five equal-weight S01 tasks are drafted (80%); review, validation and delivery evidence remain pending. No technology or external service is selected.


## M2-S01 current disposition — 2026-11-12

The M2-S01 draft package has been delivered and merged. PR [#87](https://github.com/mattari20/listing-v2/pull/87) merged as `a9a8320dadc339cb15c7d75ac430301941abbd57`; exact-head documentation validation passed (run [#43181003815](https://github.com/mattari20/listing-v2/actions/runs/43181003815)). AR-001–AR-025, system actors/boundaries, context view, quality scenarios and explicit SR-to-AR mapping are on main. T01-T04 are drafted; T05 awaits owner review. S01 remains 80% and In Progress. Do not advance dependent S02 as complete until this owner review gate is resolved.


## PR #88 delivery reconciliation — 2026-11-12

PR [#88](https://github.com/mattari20/listing-v2/pull/88) reconciled the M2-S01 draft delivery and owner-review status. Exact PR head `9d05c8f4b35462b935886b78f4aa9aa45c770dc3` passed required Project documentation validation (run [#43181135205](https://github.com/mattari20/listing-v2/actions/runs/43181135205)); PR #88 merged as `226f573d21a03b51caa4ccb46f2a68293fb84be2`. M2-S01 remains 80% and In Progress pending explicit owner review; CI success and merge are not acceptance.


## PR #89 delivery reconciliation — 2026-11-12

PR [#89](https://github.com/mattari20/listing-v2/pull/89) reconciled PR #88's exact-head validation and merge evidence. Exact PR head `5c038bb8d4662acc590121bf87723a89127ab5b6` passed required Project documentation validation (run [#43181267319](https://github.com/mattari20/listing-v2/actions/runs/43181267319)); PR #89 merged as `a119514862b74d4ec8135409375dc7960f924e2a`. M2-S01 remains 80% and In Progress pending owner review; no acceptance is implied.


## M2-S01 owner acceptance — 2026-11-12

The owner explicitly accepted the M2-S01 system requirements, actors, system boundaries and quality scenarios as the working baseline and directed continuation to S02/S03 jointly. Formal record: ../05-architecture/M2-S01_OWNER_ACCEPTANCE_RECORD_2026-11-12.md. S01 is Accepted and Closed at 100%. This acceptance does not approve the proposed WCAG target, numeric SLOs, technology stack, vendors or implementation.

## M2-S02/S03 joint documentation delivery — 2026-11-12

The coordinated S02/S03 documentation package is available in ../05-architecture/: S02 conceptual domain model (glossary, entity relationships, identity/deduplication, affiliation/recognition, lifecycle, temporal semantics, uncertainty and visibility invariants); S03 logical application/integration architecture (context, logical containers, component responsibilities, integration gates, runtime flows and failure/degraded-mode behaviours); and the joint validation/owner review checklist.

Current progress: S02 80% (T05 review pending); S03 85% (T05 review pending). These are delivered drafts and are not accepted/closed. The next action is owner review of the joint package. The work remains documentation/design only; no stack, vendor, physical schema, API, application code, source retrieval/ingestion, production access or deployment is authorized. M2 weighted progress is 32.8%.


## PR #91 exact-head validation and merge evidence — 2026-11-12

PR [#91](https://github.com/mattari20/listing-v2/pull/91) delivered the M2-S01 owner-acceptance record and coordinated M2-S02/S03 documentation package. Exact PR head `7a58f7ddb93cd693874e7debd3fa730b5db1d1ea` passed the required **Project documentation validation** workflow (run [#43188475213](https://github.com/mattari20/listing-v2/actions/runs/43188475213)); the `Validate project control documents` job and all steps completed successfully. PR #91 was squash-merged as `0881719c3b0d98893dc0e88a9c4f929cae89aea1`.

S01 is Accepted and Closed at 100%. S02 is delivered at 80% draft task completion and S03 at 85%; their T05 owner-review gates remain open. Merge and CI evidence confirm delivery and documentation validation, not owner acceptance of S02/S03. M2 weighted progress remains 32.8%.


## Authoritative update — M2-S02/S03 accepted; S04/S05/S06 jointly active — 2026-11-12

The owner explicitly accepted M2-S02 and M2-S03 as the conceptual domain and logical application/integration architecture baselines and directed closure. Formal record: ../05-architecture/M2-S02-S03_OWNER_ACCEPTANCE_RECORD_2026-11-12.md. S02 and S03 are Accepted and Closed at 100%.

The owner authorized joint documentation work on M2-S04 Technology Stack Evaluation, M2-S05 Data Architecture/Provenance/Publication Governance and M2-S06 Search/Discovery/Geography Architecture. Their coordinated package and separate owner-review gates are documented in ../05-architecture/M2-S04-S06_JOINT_VALIDATION_AND_OWNER_REVIEW.md.

Current task completion: S04 80%, S05 85%, S06 85%; T05 owner-review/decision gates remain pending. Weighted M2 progress is 62.0%. The work remains documentation and research only. No technology/vendor selection, procurement/new spend, source access/copying/ingestion, connector activation, physical schema, application code, production access, deployment or cutover is authorized. No legacy V1 artifact may inform design. V2-DEC-006 and all M1 G01-G20 restrictions remain binding.


## PR #93 exact-head validation and merge evidence — 2026-11-12

PR [#93](https://github.com/mattari20/listing-v2/pull/93) recorded the owner's acceptance and closure of S02/S03 and delivered the coordinated S04/S05/S06 architecture documentation. Exact PR head `17a77885eca53fd1a8c8d3d516f26741d10fc39a` passed required **Project documentation validation** (workflow run [#43189688854](https://github.com/mattari20/listing-v2/actions/runs/43189688854)); job `Validate project control documents` and all steps completed successfully. PR #93 was squash-merged as `4a100030a2ea491b0061ac80a543f723b03fdea4`.

S02 and S03 are Accepted and Closed at 100%. S04 remains 80%, S05 85% and S06 85% pending their separate owner-review/decision gates. Weighted M2 progress is 62.0%. CI and merge establish delivery and documentation validation, not owner acceptance of S04-S06.


## PR #94 exact-head validation and merge evidence — 2026-11-12

PR [#94](https://github.com/mattari20/listing-v2/pull/94) reconciled PR #93 delivery. Exact PR head `9c369a4a6f5b78d794feb2e38d9c4afd1b4875e8` passed required **Project documentation validation** (workflow run [#43189848614](https://github.com/mattari20/listing-v2/actions/runs/43189848614)); job `Validate project control documents` and all steps completed successfully. PR #94 was squash-merged as `0a5f65258ea04c52b8e79b314f7cda04c8d3e65c`.

This reconciliation confirms PR #93's merge evidence and does not alter content acceptance: S02/S03 remain accepted/closed; S04 80%, S05 85% and S06 85% remain owner-review/decision pending. Weighted M2 progress remains 62.0%.

## M2-S04/S05/S06 acceptance and S07-S10 continuation — 2026-11-12

The owner accepted S04 Technology Stack Evaluation, S05 Data Architecture/Provenance/Publication Governance and S06 Search/Discovery/Geography as working design baselines, directing that unresolved stack, vendor, legal, operational and ranking choices be carried forward. Formal record: ../05-architecture/M2-S04-S06_OWNER_ACCEPTANCE_RECORD_2026-11-12.md. S04-S06 are Accepted and Closed at 100%; no stack, vendor, procurement or implementation is approved.

S07-S10 documentation drafts have been prepared:
- S07 AI data-agent technical architecture: 85%; T05 review pending.
- S08 identity, authorization, reviews, privacy and security: 80%; T05 review pending.
- S09 performance, operations, hosting and recovery: 80%; T05 cost/operations review pending; all numerical targets are provisional.
- S10 integrated synthesis and conditional M3 roadmap: 80%; explicit final owner acceptance pending.

Weighted M2 draft progress is 93.9%. The next eligible work is complete T05 validation/reconciliation for S07-S10, then request the owner's explicit final M2 acceptance. M3 implementation remains prohibited until that acceptance and a separate M3 start authorization. No source retrieval/ingestion, connector/agent activation, procurement, production access, deployment, launch or legacy-repository interaction is authorized.


## M2-S07/S08/S09 design validation closeout — 2026-11-12

The design-level T05 reviews for S07 threat/cost/failure, S08 security/cross-step consistency and S09 cost/operations limitations are complete. Joint review: ../05-architecture/M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md. S07, S08 and S09 are design-task complete at 100%. S10 remains 80% because the explicit final owner acceptance gate is not delegated to the document author. Weighted M2 design progress is 98.6%; see ../05-architecture/M2_PROGRESS_REPORT.md. The only remaining M2 gate is the owner's final acceptance of the integrated architecture. M3 remains unauthorized.
