# Milestone and Step Register

**Status key:** Not started · In progress · Blocked · Complete · Accepted  
**Progress:** Evidence-based; do not report a percentage until task weights and accepted evidence are verified.

## Progress calculation
Each step is decomposed into measurable tasks with weights totaling 100%. Task completion is 0% until its evidence-based acceptance criteria pass; partial percentages may be used only when the task explicitly supports measurable sub-criteria.

`Step progress = sum(task weight × task completion)`

Each milestone assigns weights to its steps, totaling 100%.

`Milestone progress = sum(step weight × step progress)`

Do not count PRs as progress units. Progress is not acceptance: mandatory gates must pass even at 100%.

## M0 — Repository, documentation and governance
**Milestone outcome:** A verified, durable project control system exists before application coding, with strict separation from all legacy work.

| Step | Scope | Target / acceptance evidence | Dependencies | Status |
|---|---|---|---|---|
| M0-S01 | Bootstrap V2 repository and founding decisions | Repo identity, current README, V2 constitution and decision records reviewed and consistent | None | Accepted — PR #1 baseline; README/decision consistency corrected in PR #3 |
| M0-S02 | Establish strict legacy non-interference audit | Explicit exclusion policy, metadata-only source inventory, no copied artifacts; audit scope limitations recorded | S01 | Accepted — strict exclusion boundary documented; inventory explicitly limited and non-exhaustive |
| M0-S03 | Establish project controller and planning documents | Controller, roadmap, step register, traceability, progress and next-step rules reviewed and linked through the catalogue | S01 | Accepted — current source-of-truth records reviewed and reconciled through PR #4 |
| M0-S04 | Establish engineering and AI governance independently for V2 | Engineering standards, AI protocol, definition of done, authorization boundaries reviewed | S01 | Accepted — V2-authored governance documents reviewed; production/approval boundaries explicit |
| M0-S05 | Configure V2 repository workflow | PR/issue templates, validation CI, owner settings, active main ruleset and required check | S03-S04 | Complete — PR #1 merged; public repo, auto-merge enabled, active `main` ruleset and required CI check verified 2026-11-11 |
| M0-S06 | Verify V2 delivery workflow | Separate test PR demonstrates latest-head checks, active ruleset/required-check enforcement, controlled merge, evidence update and next-step selection | S05 | Complete — PR #2 passed required check on exact head `9ad0d3b361d6641dca2e94c3c9a52ac2fb4d1597`, merged as `975cd672378e8d30982d44d54d12e195e9c57d5d`; automatic merge execution not independently demonstrated |
| M0-S07 | M0 acceptance and closeout | All mandatory M0 evidence reviewed; controller points to M1-S01 | S01-S06 | Accepted — PR #4 records M0 closeout; all mandatory steps have evidence and remaining limitations are explicit |

Initial M0 step weights (planning baseline, to be reviewed): S01 10%, S02 15%, S03 20%, S04 15%, S05 20%, S06 10%, S07 10%.

## Documentation tracking requirement
Maintain `DOCUMENTATION_CATALOG.md` as the owner-facing inventory. Reconcile it on every documentation PR update and merge. Distinguish delivered, updated, accepted and planned content; do not equate merge with acceptance.

## M0 closeout record
- M0 accepted after review of the founding documentation, isolation boundary, project controls and protected-PR delivery workflow.
- M0-S02 acceptance is limited to the documented metadata-only exclusion audit; it does not claim exhaustive inspection of the legacy repository.
- Repository auto-merge setting is enabled, but automatic merge execution itself remains untested.
- No application implementation, database schema/migrations, production access, deployment or URL cutover is authorized by M0 acceptance.
- M0 closeout next step was M1-S01; current authorized work is M1-S03 official government and regulator provider research.

## M1 — Student requirements and independent research
| Step | Scope | Target / acceptance evidence |
|---|---|---|
| M1-S01 | Student journey desk research and requirements baseline | Independent desk-research synthesis and provisional journey hypotheses; primary participant research is explicitly deferred during construction by owner |
| M1-S02 | Institution taxonomy and coverage requirements | Independent level/type/sector/geography matrix, recognition/affiliation distinctions and inclusion rules; see `../03-research/M1_INSTITUTION_TAXONOMY_RESEARCH.md` and `../03-research/M1_OFFICIAL_INSTITUTION_SOURCE_COVERAGE_MATRIX.md` |
| M1-S03 | Official government/regulator provider research | New source register with access, rights, coverage and freshness evidence |
| M1-S04 | Private provider and institution-source research | New provider inventory and documented gaps |
| M1-S05 | Programme/admissions information research | Student-required programme, campus, fees, admission and scholarship information |
| M1-S06 | Independent GitHub software and dataset discovery | Candidate inventory across crawler, data, search, geo, workflow and education-data categories |
| M1-S07 | License, data-rights and security assessment | Per-candidate evidence and independent reuse decision |
| M1-S08 | V2 AI data-agent workflow requirements | Source-specific collection, verification, scheduling and human-review requirements |
| M1-S09 | Comparison, review and trust research | Rating rubric, moderation, privacy and abuse cases |
| M1-S10 | M1 synthesis and acceptance | Research report, gap register and approved inputs to M2 |

### M1-S01 task breakdown (weights total 100%; primary research deferred by owner)
| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S01-T01 Desk research and evidence register | 35% | Independent source synthesis with limitations and dated references | Delivered — initial desk-research baseline in PR #6 |
| S01-T02 Participant segments and research protocol | 15% | Clearly labeled segment hypotheses and research safeguards; no recruitment during construction | Delivered as draft preparation only — PR #7; owner deferred fieldwork |
| S01-T03 Primary interviews/survey | 0% | No pre-launch survey or interview under current owner direction | Deferred — not part of construction scope |
| S01-T04 Journey mapping and synthesis | 25% | Desk-research journey and explicit evidence gaps, without claiming participant validation | In progress — provisional baseline only |
| S01-T05 Requirements and acceptance criteria | 25% | Traceable product requirements and owner decisions; unresolved assumptions identified | In progress — continue alongside M1 work |

### M1-S02 task breakdown (weights total 100%)
| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S02-C01 Taxonomy and entity distinctions | 15% | Owner-reviewed categories and provider/campus/programme/regulator/affiliation distinctions | **Completed — owner approved 2026-11-12**; provisional taxonomy and documented distinctions accepted as the M1-S02 research baseline |
| S02-C02 Higher-education and campus sources | 10% | Current HEC institution, campus and affiliated-college scope verified with limitations | Completed — HEC institution/campus/affiliation/PQR/NOC/study-centre scope mapped with limitations; record-level freshness and source rights remain documented gaps |
| S02-C03 Professional council sources | 15% | Current PMDC, PNMC, PCP and other relevant council status semantics documented | Completed — major council source families and status semantics mapped; current-register/freshness gaps for selected councils and source-rights limits documented |
| S02-C04 School-source jurisdiction coverage | 15% | Official source register across provinces/territories, public/private scope and geography gaps | Completed — official source families mapped across all jurisdictions; role-based/aggregate-only/login-only gaps, private/public scope and district coverage limitations explicitly documented |
| S02-C05 TVET and awarding relationships | 10% | NAVTTC, provincial TEVTAs, boards, assessment and awarding-body map | Completed — NAVTTC/QAB, provincial TEVTAs, boards, assessment and awarding relationships mapped; provider-count/scope and freshness discrepancies documented |
| S02-C06 Non-formal and special education | 10% | Official provider-source inventory and explicit coverage gaps | Completed — NFE/community and special-education source inventory mapped; partial/missing registers, operational status and privacy limits documented |
| S02-C07 Source rights and access | 10% | Terms, licenses, permission, access method, update cadence and privacy assessment for each source | Completed — source-by-source access, terms, privacy and freshness assessment recorded; no general reuse permission established, with only the narrow SED dashboard aggregate license identified |
| S02-C08 National coverage synthesis | 10% | Reviewed coverage matrix, unresolved gaps and source-quality assessment | Completed — consolidated national coverage/gap matrix and corrections addenda delivered; source-quality discrepancies and remaining gaps explicitly assessed |
| S02-C09 Owner review and step acceptance | 5% | Owner-reviewed taxonomy and coverage acceptance record; no ingestion implied | **Accepted — owner approval recorded 2026-11-12**; acceptance is limited to the documented research baseline and does not authorize ingestion or reuse |

**Progress rule:** Completion is based on each task's stated research/documentation acceptance evidence, not PR count or document volume. C02–C08 are complete with limitations documented; C01 and C09 were owner-approved on 2026-11-12. M1-S02 is therefore **Accepted (100% weighted task completion)** as a research baseline only. Acceptance does not establish a complete national census, source reuse permission, or authorization to ingest data.



### M1-S03 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S03-C01 Federal education governance and national data authorities | 12% | Verified authority/mandate map for MoFEPT, PIE/NEMIS, federal education bodies and national source routes, with scope and limitations | In progress — initial MoFEPT and PIE/NEMIS official routes verified; national source coverage and freshness review continues |
| S03-C02 Provincial and territorial school authorities/EMIS | 18% | Source-by-source official authority, public/private scope, route, visible fields, geography, update date and access constraints for all jurisdictions | In progress — AJK E&SE/EMIS/PEIRA and HED college routes now verified; 6,019 aggregate lacks an as-of date, private-list file prompts sign-in, and HED 178/180 totals conflict; GB private coverage remains open |
| S03-C03 Higher education and professional regulators | 14% | Verified source register for HEC and relevant professional councils/accreditation bodies, including exact approval scope and status semantics | In progress — PMDC, PCP, PNMC, NCEAC, NACTE, PEC, NTC, PVMC and PBC routes reviewed; programme/batch scope, current validity, stale records and source rights remain under verification |
| S03-C04 TVET, technical boards and qualification-awarding bodies | 12% | Verified NAVTTC registration, QAB, provincial board and accreditation routes with provider-versus-awarder distinctions | In progress — NAVTTC registration, affiliation/QAB and NAC-TVS accreditation routes recorded; provincial QAB follow-up continues |
| S03-C05 Non-formal and special-education authorities | 8% | Official authority/source inventory, coverage level, operational-status and privacy limitations | In progress — NFEMIS, DGSE and Sindh DEPD official routes reviewed; fluctuating NFE totals, DGSE mandate discrepancy, mixed service categories and personal-data exclusions documented |
| S03-C06 Deeni Madaris registration and qualification pathways | 8% | Verified DGRE registration, IBCC QAB and HEC equivalence distinctions; provider and qualification statuses separated | In progress — DGRE, IBCC and HEC official routes verified; current public DGRE register completeness and source rights remain open |
| S03-C07 Access, rights, freshness and privacy assessment | 13% | Per-source access class, source terms/license evidence, last checked/as-of date, privacy exclusions and reuse decision | In progress — no blanket rights inferred; source-specific checks and access classification continue |
| S03-C08 Consolidated official provider-source register and gap analysis | 10% | Deduplicated source register with evidence, jurisdiction/sector coverage, limitations and unresolved gaps | In progress — initial register delivered as research draft; not yet complete or accepted |
| S03-C09 Owner review and step acceptance | 5% | Owner-reviewed official source register, gaps and limitations; explicit acceptance record | Not started — owner-only acceptance gate |

**Progress rule:** M1-S03 progress is evidence-based. The initial source register is a draft delivery and does not complete any task by itself. Do not count source pages or PRs as progress units. All sources remain RESEARCH ONLY unless a specific reuse permission is recorded. No source collection, ingestion or implementation is implied.

## Owner-approved research timing
No student survey, interviews, recruitment or outreach will occur during platform construction. The existing adult interview/survey kit is an unapproved draft retained for record only. Ratings and reviews are a post-launch authenticated product feature.

## M2–M12 step planning
Before each milestone starts, create detailed numbered steps, task weights, dependencies, acceptance criteria, PR/test evidence and target dates or duration estimates where supportable. Do not invent calendar commitments without capacity and dependency estimates.

## Step closeout fields
Step ID; scope; task list and weights; status; branch/PR; head SHA; merged SHA; required checks and exact results; evidence links; defects; progress; blockers; next step; update date.

## Mandatory independence check
Every step must record that its inputs are V2 owner requirements, new research or approved V2 decisions. Any legacy-derived implementation, architecture, data, workflow or process pattern is prohibited and must be removed before the step can pass.


## M1-S02 supplemental evidence note — 2026-11-12

The supplemental review adds AJK's dated private-institution register announcement; Balochistan EMIS legal-status and separate private/NFE routes; NFEMIS dashboard/inventory evidence with a two-record displayed-total discrepancy; a zero-valued GB EMIS dashboard warning; HEC PQR and allied-health NOC distinctions; and historical-only KP special-education evidence. These are research leads and quality warnings, not completeness or reuse approvals. S02-C04, C06, C07 and C08 remain **In progress**; S02-C09 remains **Not started** pending explicit owner decision. The weighted task table above remains authoritative and unchanged (15/10/15/15/10/10/10/10/5 = 100%).


## PR #33 delivery evidence — 2026-11-12

PR [#33](https://github.com/mattari20/listing-v2/pull/33) merged the supplemental official-source coverage review as `f6c22c70d4128784b2e3b76cd4115113ad7e5329`; exact head `09a3051043bf47825360cf03ea220c11eff121f7` passed required Project documentation validation (run #43151991943). Nine S02 task rows and original weights remain unchanged. Delivery does not satisfy the remaining acceptance criteria: S02-C04/C06/C07/C08 remain in progress and S02-C09 remains pending explicit owner decision.


## PR #34 reconciliation evidence — 2026-11-12

PR #34 reconciled PR #33 delivery evidence and merged as `569ef14f0cc4ef72bb07cf0313965e13250eac3d`; exact head `fce8164fe73bf435aa7c021ac3b8eb7e521c89a7` passed required Project documentation validation (run #43152117268). No task weights or statuses were changed by this reconciliation. S02-C09 remains pending owner decision.


## M1-S02 professional-council and special-education evidence note — 2026-11-12

The second supplemental review adds PCATP programme-state evidence; NCT FTJ/BEMS routes; AHPC applications-versus-granted-recognition distinction; NTC zero/interim and intake-batch status semantics; the NAEAC public-register gap; and ICT DGSE mandate evidence. Current special-education registers for KP, Balochistan, AJK and GB remain unverified; historical KP material is not treated as current. S02-C03, C06 and C07 remain In progress; S02-C09 remains Not started pending owner approval. Task weights are unchanged.

## PR #35 final reconciliation evidence — 2026-11-12

PR #35 reconciled PR #34 and merged as `0cb1c8cf1dba9fb0b90b1fa8bda16123d57c65f6`; exact head `48626561f492c03baab9ce72fb79e7a24a01640f` passed required Project documentation validation (run #43152199340). No task weights or acceptance states changed.


## PR #36 delivery evidence — 2026-11-12

PR #36 merged the professional-council and special-education supplement as `c0a5e0cc743336610b0eef5d5e56fde5406d92db`; exact head `fb629563b395a29b4d02df443acaa63c4cd38f01` passed required Project documentation validation (run #43152421589). S02-C03/C06/C07 remain In progress; S02-C09 remains Not started pending explicit owner approval. Task weights are unchanged.


## M1-S02 deep jurisdiction and TVET evidence note — 2026-11-12

The deep review strengthens S02-C04/C05/C06 with Punjab/Sindh/GB special-education source leads, KP-TEVTA's 33-institute aggregate, STEVTA's district/region filter-driven list, Punjab TEVTA's 2024 institute PDF and B-TEVTA's 16-record directory versus NAVTTC's 80+ overview estimate. It records the GB location discrepancy, Balochistan proposed-versus-operational distinction, privacy exclusions and explicit exclusion of NAVTTC staging/sample directory data. Full evidence is in `docs/03-research/M1_S02_DEEP_JURISDICTION_SPECIAL_ED_TVET_REVIEW_2026-11-12.md`. S02-C04/C05/C06/C07/C08 remain In progress; S02-C09 remains Not started pending owner approval. Task weights unchanged.

## M1-S02 ICT PEIRA and Madaris research note — 2026-11-12

The latest review strengthens ICT private-school evidence through PEIRA's paginated active register and separate renewal/unregistered states, adds DGRE's nationwide Deeni Madaris registration family and 16 regional offices (public lists located dated March 2024), and documents IBCC's QAB recognition versus qualification-equivalence distinction. Deeni Madaris are added to the provisional provider taxonomy; DGRE maslak data is excluded from general discovery. See `docs/03-research/M1_S02_ICT_PEIRA_MADARIS_QAB_REVIEW_2026-11-12.md`. S02-C01/C04/C05/C07/C08 remain in progress; S02-C09 remains owner-only.

## PR #38 delivery evidence — 2026-11-12

PR #38 merged the deep jurisdiction and TVET review as `a38fa149d10be99903ca6bb44236bd1e68565e6a`; exact head `f1f7aa59424b5161ec91a3f3ae60ff20471edba2` passed required Project documentation validation (run #43153839019). It strengthens S02-C04/C05/C06 but does not close their remaining acceptance evidence. Task weights and owner gate are unchanged.


## M1-S02 examination-board and PMF research note — 2026-11-12

The latest review adds IBCC forum-member board categories, Punjab's nine BISE jurisdictions, Punjab Medical Faculty's separate public/private affiliated-institute lists, and DGRE regional jurisdiction plus 2024 regional Madaris lists. DGRE record anomalies and freshness limitations are explicit. Examination/assessment jurisdiction, institution-board affiliation, PMF affiliation, provider registration and accreditation remain distinct. See `docs/03-research/M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md`. S02-C01/C03/C05/C07/C08 remain in progress; S02-C09 remains owner-only.

## PR #39 delivery evidence — 2026-11-12

PR #39 merged the ICT PEIRA, Madaris and IBCC QAB review as `0ace505ec67a420b8c2eb8fedd13ba1a2499f84c`; exact head `cf4d54967cad1f2114cd1f43dfccec5184d1b759` passed required Project documentation validation (run #43154066994). It strengthens S02-C01/C04/C05 but does not resolve remaining current-register, rights or acceptance evidence.


## M1-S02 HEC affiliation and programme-status note — 2026-11-12

HEC Institutional Affiliation Policy 2024 applies to affiliated colleges and approved study centres, including regular-class/MoU centres; current continuation must be verified per DAI/college/programme. PM&DC seat allocations/court-order admissions, PCP Active/Stoppage of Admissions and PNMC freshness/programme irregularities reinforce the need for session-specific programme status. HEC affiliate-college rows require duplicate/variant reconciliation. S02-C02/C03/C07/C08 remain in progress; S02-C09 remains owner-only.

## PR #40 delivery evidence — 2026-11-12

PR #40 merged the examination-board, PMF, DGRE jurisdiction and HEC affiliation/study-centre review as `c92d96613dcb510762be5a0a615a73e856861f9b`; final exact head `cc2cc7eaa615e4fe762f808e51918b6b10b5e235` passed required Project documentation validation (run #43154387281). S02-C01/C02/C03/C05/C07/C08 remain in progress pending specific acceptance evidence; S02-C09 remains owner-only.


## M1-S02 data-rights and privacy research note — 2026-11-12

MoITT's official registers identify the National Data Governance Policy 2026 and Personal Data Protection Bill May 2023 as Draft; RTI access does not confer blanket reuse rights; copyright compilation and underlying data/material require separate review; and PBS's open license is limited to PBS products/tiers. No blanket education-directory reuse permission is established. See `docs/03-research/M1_S02_DATA_RIGHTS_PRIVACY_FRAMEWORK_REVIEW_2026-11-12.md`. S02-C07/C08 remain In progress; S02-C09 remains owner-only.

## PR #41 reconciliation evidence — 2026-11-12

PR #41 reconciled PR #40 and merged as `c56200bdf66a5fdf615de0da6281495e50c39f92`; exact head `2c11bfc7fe74da6bed4dc04d17c4c80a664990b0` passed required Project documentation validation (run #43154481312). No task status, weight or owner gate was changed.


## M1-S02 AJK/GB/Sindh school-source research note — 2026-11-12

New evidence adds AJK public/private census streams and 6,019 aggregate; GB government EMIS details, BECS community-school list (776, June 2025) and public college list; Sindh region-to-UC school checker; and Punjab PEPRIS eLicense/DEA-upload caveats. Teacher names, CNIC/mobile identifiers and student data remain excluded. See `docs/03-research/M1_S02_AJK_GB_SINDH_SCHOOL_REGISTER_REVIEW_2026-11-12.md`. S02-C04/C06/C07/C08 remain In progress; S02-C09 remains owner-only.

## PR #42 delivery evidence — 2026-11-12

PR #42 merged the national data-rights and privacy review as `a6b35abcb091965f90e492e36378750b2f20ebad`; exact head `80a85a42418ee0176f3fad6ad63e0220f1978c8b` passed required Project documentation validation (run #43154673045). S02-C07 remains In progress pending per-source terms/permissions; S02-C09 remains owner-only.

## M1-S02 Sindh private/KP school-register status note — 2026-11-12

Sindh DIRPIS/SPEI-EMIS private-school registration/census is separate from the public institution checker; older official documents note registered/unregistered providers and data-update needs. KPPSRA district records expose ACTIVE/BLOCKED/DORMANT/CLOSED states; full district coverage and freshness remain open. S02-C04/C07/C08 remain in progress; S02-C09 owner-only.

## PR #42 delivery evidence — 2026-11-12

PR #42 merged the national data-rights and privacy review as `a6b35abcb091965f90e492e36378750b2f20ebad`; exact head `80a85a42418ee0176f3fad6ad63e0220f1978c8b` passed required Project documentation validation (run #43154673045). S02-C07 remains In progress pending per-source terms/permissions; S02-C09 remains owner-only.


## M1-S02 school regulator status and terms note — 2026-11-12

KPPSRA registration/renewal and BISE affiliation must be separate; Sindh DIRPIS 2026 safety notices are not a complete register; HEC Digital Library publisher licenses do not govern HEC institution directories; NAVTTC aggregate claims have distinct scopes. See `docs/03-research/M1_S02_SCHOOL_REGULATOR_STATUS_TERMS_REVIEW_2026-11-12.md`. S02-C04/C05/C07/C08 remain in progress; S02-C09 owner-only.

## PR #43 delivery evidence — 2026-11-12

PR #43 merged the AJK/GB/Sindh/Punjab school-source review as `a8dfd8018fa33588a4d35166c953b18f89e39c43`; final exact head `56923aca98123dce6b8a574e0cf9f9c244b036b4` passed required Project documentation validation (run #43155004215). S02-C04/C06 remain in progress; C07/C08 and owner C09 remain open.


## M1-S02 KP/ICT/AJK coverage note — 2026-11-12

KP public-school iEMIS is role-based rather than a public directory; FDE ICT reports 432 institutions but no record-level public list was verified; AJK HED publishes college lists with conflicting official aggregates (178/180) and possible category overlap. See `docs/03-research/M1_S02_KP_ICT_AJK_COLLEGE_COVERAGE_REVIEW_2026-11-12.md`. S02-C02/C04/C07/C08 remain in progress; S02-C09 owner-only.

## PR #44 delivery evidence — 2026-11-12

PR #44 merged the school-regulator status and terms review as `11ee337d823731d71a9c0ca00782728ad1994398`; exact head `0b5fe6429a1f6bc8bb383d1db1278d632ae04f08` passed required Project documentation validation (run #43155204020). S02-C04/C05/C07/C08 remain in progress; S02-C09 owner-only.

## M1-S02 task acceptance audit — 2026-11-12

The task-by-task audit is recorded in `docs/03-research/M1_S02_TASK_ACCEPTANCE_EVIDENCE_AUDIT_2026-11-12.md`. S02-C02 through S02-C08 are marked **Completed — limitations documented** because their stated research/documentation outputs have been delivered. This does not imply a complete national census or authorize source reuse. S02-C01 remains In progress pending owner review of the provisional taxonomy; S02-C09 remains Not started pending explicit owner acceptance. The overall M1-S02 step therefore remains In progress / awaiting owner acceptance.


## M1-S02 owner acceptance and closeout — 2026-11-12

The owner explicitly approved the proposed institution taxonomy and accepted the M1-S02 research baseline with its documented limitations. This closes S02-C01 (15%) and S02-C09 (5%). Together with the previously completed S02-C02 through S02-C08 tasks (80%), all weighted S02 tasks are complete (100%).

**Accepted outcome:** Pakistan institution/provider taxonomy and national source-coverage research baseline, including the documented entity distinctions, jurisdiction/source map, rights/access findings, privacy exclusions, freshness and data-quality warnings, and unresolved coverage gaps.

**Acceptance limitations:** This is not a complete national census or a verified production dataset. All source families remain RESEARCH ONLY unless a source-specific permission is explicitly documented. The only scoped reuse permission remains SED Balochistan dashboard headline metrics and district breakdowns, with attribution and an as-of date; it does not extend to school-level records or other datasets.

**Authorization boundary:** This owner acceptance closes M1-S02 documentation/research only. It does not authorize source ingestion, scraping, bulk download, source-owner contact, permission requests, application implementation, database/schema changes, production access, deployment, legacy-repository interaction, M1-S03 or M2. Any next step requires separate owner authorization.

**Decision record:** `docs/03-research/M1_S02_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`.


## M1-S03 authorization and Deeni Madaris visibility requirement — 2026-11-12

The owner authorized moving forward after M1-S02 acceptance. M1-S03 is now active, limited to official government/regulator provider-source research and documentation. Its weighted task breakdown is recorded above. No ingestion, scraping, source-owner contact, permission request, implementation, database/schema change, production access, deployment, legacy-repository interaction, M1-S04 or M2 work is authorized.

The owner also directed that Deeni Madaris remain in V2's underlying provider scope but be hidden from the public listing by default at initial launch. A configurable `Show Deeni Madaris` setting is required, default OFF, with changes through an authorized administration/configuration path. The setting's UI and roles remain for M2 design. See V2-DEC-006 and the institution/programme requirements. This is not implementation authorization.


## M1-S03 supplemental source verification — 2026-11-12

The second M1-S03 research pass adds NFEMIS national NFE, DGSE, Sindh DEPD, GB EMIS school details and GB public-college sources. S03-C02 and S03-C05 remain in progress. NFEMIS fluctuating dashboard counts are not treated as reconciled totals; DGSE's official ministry attribution differs between government pages; Sindh DEPD mixes education and rehabilitation/vocational units and exposes staff contacts that are excluded; GB EMIS includes administrative office rows and its summary dashboard can show zero despite populated school details. Full findings are in `../03-research/M1_S03_NFE_SPECIAL_ED_GB_SOURCE_REVIEW_2026-11-12.md`. No source reuse, ingestion or implementation is authorized.


## M1-S03 professional regulator verification — 2026-11-12

A third M1-S03 research pass verifies official source routes for PMDC, PCP, PNMC, NCEAC, NACTE, PEC, NTC, PVMC and PBC. S03-C03 remains in progress. The register records programme/batch-specific approval, expiry, admissions stoppage, under-discussion, zero/interim and recognition-date semantics; no regulator directory is treated as blanket institution approval or reuse permission. Full analysis is in `../03-research/M1_S03_PROFESSIONAL_REGULATOR_SOURCE_REVIEW_2026-11-12.md`.


## M1-S03 AJK education authority review — 2026-11-12

The AJK source review identifies E&SE's public 6,019-school aggregate, login-only EMIS, a 5-Nov-2025 private-register announcement whose linked PDF prompts sign-in, and HED's degree/inter/education college lists. HED's official pages conflict between 180 and 178 colleges; E&SE quick-overview cards show zero while other dashboard aggregates are populated. S03-C02 remains in progress. Full findings are in `../03-research/M1_S03_AJK_EDUCATION_SOURCE_REVIEW_2026-11-12.md`.
