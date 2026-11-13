# Implementation Traceability Matrix

| Requirement ID | Requirement | Specification | Step | PR / commit | Test / evidence | Status |
|---|---|---|---|---|---|---|
| GOV-001 | Independent greenfield repository | Project Constitution | M0-S01 | Bootstrap commit; PR #1 merged as `0f2165f3d18e43f10cf6d6f717f145d3433769a4` | Repository metadata; founding documentation present | Accepted — M0 closeout |
| GOV-002 | Documentation-driven execution and status tracking | AI Execution Protocol; Project Master Control; Documentation Catalogue | M0-S03 | PR #1–#4 merged | Controller, step register, catalogue and progress-report links | Delivered — acceptance review pending |
| GOV-003 | Protected PR workflow and eligible automatic merging | Repository Governance Setup; Engineering Standards; DEC-002 | M0-S05/S06 | PR #1 merged; ruleset `main` ID 27043221 active | Required check `Validate project control documents`; auto-merge enabled; PR #2 required check passed on exact head; squash merge SHA `975cd672378e8d30982d44d54d12e195e9c57d5d`; auto-merge execution not independently tested | M0 protected-PR workflow verified through PR #2; repository auto-merge enabled but automatic execution untested |
| PROD-001 | Student-first discovery and decision support | Product Vision; Student Discovery Requirements; M1 Student Journey Research | M1-S01 | PR #1 baseline; PR #6–#11 initial desk-research and timing decision; PR #71 merged as `64bd568d522e41452b8b46db8652ec8df48a2d8b`; exact head `2982bdf421e09e82c03b76c223adb1b6ecc0b180`; validation run #43166985628 | PBS/PIE, PBS HIES, Punjab HED, IBCC, HEC and published Pakistan-focused student-choice research; provisional journey; SR-01–SR-14 with acceptance scenarios; primary research explicitly deferred | Delivered — owner acceptance pending; 100% weighted documentation tasks; not participant-validated |
| SR-01 | Pathway-led and direct search | Student Discovery Requirements; M1 Student Journey Research | M1-S01 | PR #71 merged (`64bd568d522e41452b8b46db8652ec8df48a2d8b`); exact head `2982bdf421e09e82c03b76c223adb1b6ecc0b180`; validation run #43166985628 | Optional stage/qualification and intended next step; direct search remains possible | Delivered — owner acceptance pending |
| SR-02 | Search institution, campus, programme, subject and locality | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Entity type and exact/approximate match distinctions specified | Ready for owner acceptance |
| SR-03 | Nearby discovery with optional location permission | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Manual locality search works if location denied; permission is opt-in | Ready for owner acceptance |
| SR-04 | Evidence-backed filters | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Filters limited to supported fields; missing values not misrepresented | Ready for owner acceptance |
| SR-05 | Like-for-like shortlist comparison | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Missing, stale and incomparable fields remain visible | Ready for owner acceptance |
| SR-06 | Programme/admission facts and evidence | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Campus/programme-level eligibility, fees, dates and recognition show source/as-of context | Ready for owner acceptance |
| SR-07 | Distinguish official, provider, AI, estimate and opinion data | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Verification/source state is explicit | Ready for owner acceptance |
| SR-08 | Official next action | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Official contact/application route; no implied V2 application submission | Ready for owner acceptance |
| SR-09 | Shortlist, sharing and opt-in updates | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Save/share and opt-in/opt-out requirements specified | Ready for owner acceptance |
| SR-10 | Corrections and post-launch authenticated reviews | Student Discovery Requirements; owner timing decision | M1-S01/M1-S09 | PR #10/#11; S01 closeout PR pending | Review login requirement and post-launch timing; detailed moderation later | Requirement recorded — design pending |
| SR-11 | Constrained digital access | Student Discovery Requirements; PBS HIES 2024–25; PIE PES 2023–24 | M1-S01 | S01 closeout PR pending | Text-first/mobile/low-bandwidth scenarios; numeric thresholds deferred to M2/M11 | Ready for owner acceptance |
| SR-12 | Language and accessibility evaluation | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | English/Urdu and accessibility needs recorded as open validation/design questions | Ready for owner acceptance |
| SR-13 | Student personal-data minimization | Student Discovery Requirements; research safeguards | M1-S01 | S01 closeout PR pending | No government ID, roll number, marksheet or exact home address required for browse/compare | Ready for owner acceptance |
| SR-14 | Discovery without precise location | Student Discovery Requirements | M1-S01 | S01 closeout PR pending | Province/district/city/locality/manual name search retained | Ready for owner acceptance |
| DATA-001 | Multi-source lawful data catalogue | Education Data Strategy | M1-S02–S08 | PR #1 merged | Provider/rights register requires source evidence expansion | Delivered — research/acceptance pending |
| OSS-001 | Lawful open-source and dataset reuse | Open-Source Reuse Audit | M1-S06/S07 | PR #1 merged | Candidate research and license/security scorecards pending | Delivered — research pending |
| TRUST-001 | Account-based ratings and reviews after launch | Comparison, Reviews and Trust | M1-S09 | PR #1 baseline; clarified in current documentation PR | Owner direction: login required to submit; post-launch collection; moderation, privacy and age safeguards still need detailed design | Product requirement recorded — detailed design pending |
| TAX-001 | Pakistan provider taxonomy, coverage and recognition/affiliation distinctions | M1 Institution Taxonomy Research; M1 Official Institution Source Coverage Matrix | M1-S02 | PR #10 merged as `11bb356f678e8559e9cd17940a68ab35dcf131b5`; supplemental source coverage review delivered in PR #33 (merged as `f6c22c70d4128784b2e3b76cd4115113ad7e5329`; exact head `09a3051043bf47825360cf03ea220c11eff121f7`; required check run #43151991943) | HEC, PMDC, PNMC, PCP, PEC, NCEAC, NACTE, NCH, Punjab/Sindh special education, provincial school EMIS/regulator portals and NAVTTC source families identified; jurisdiction, rights and freshness gaps recorded; dated public-terms review added for HEC, PM&DC, PNMC, KP-PSRA, ICT-PEIRA and Sindh RSU/SEMIS; TVET/QAB source map added; no directory-specific reuse permission established | In progress — source discovery baseline delivered; verification and owner acceptance pending |

Add one row for every approved requirement. Do not mark accepted without verifiable evidence.

## M1 owner decision and current research
No survey, interviews, recruitment or outreach during construction. Account-based ratings and reviews are a post-launch product feature. M1-S02 taxonomy desk research is documented in `docs/03-research/M1_INSTITUTION_TAXONOMY_RESEARCH.md`; it is an initial baseline, not a complete national inventory or final approved taxonomy.

## M0 closeout evidence
PR #4 merged as `4d1122d182961f3842803036f917ce39cd11b4c6`; required check passed on exact head `64da261546b034129af3aebfa38fb91f939732b6`. PR #4 records M0-S01–S07 acceptance and points the controller to M1-S01. M0-S02 remains explicitly scoped to a targeted, metadata-only, non-exhaustive exclusion audit.

## PR #15 evidence
PR #15 merged as `df60fbe592801e86c2126554c57f6b21ffae36f7`; exact head `b85393c22a2768cf6beb56699aeead5a16d13373`; required documentation check passed (run #43139676215). It expanded special-education and professional programme source discovery; rights and status verification remain open.

## PR #14 evidence
PR #14 merged as `f5d185209d96233dc26f5da2c4efd4d8fd1cdf03`; exact head `f5fcfc1c8d6e8722dd7046b2b87d9b5a8e4c1476`; required documentation check passed (run #43138852699). It added AJK and non-formal education source leads; complete coverage remains unverified.

## PR #13 evidence
PR #13 merged as `a0a5f891bdcffdc2ae0de59624358a02f2a9d15f`; exact head `f5dc4f9cbdb76bbb6133191ad676f833995967d9`; required documentation check passed (run #43138669791). It added official source leads for Sindh, ICT and GB; complete coverage and reuse rights remain unverified.

## PR #12 evidence
PR #12 merged as `6646889954e20bab95a33d92f6bb2abab266ec59`; exact head `ca5f28e2edeb3ccd6088d4cdacad8a5440aaea90`; required documentation check passed (run #43138431960). The source coverage matrix is a research baseline only; no source is approved for ingestion by this merge.

## PR #11 evidence
PR #11 merged as `e39137e14f152fa82fe2acb284a631cb84438998`; exact head `b11e03020a46269d9b04674822182933c569082e`; required documentation check passed (run #43136568996).

## PR #17 source-rights evidence
PR #17 merged as `52481df5d18c60cb9e24ee3a32e7977db3669770`; exact head `8520aedbd9360bb190819dc85423b475bbb40497`; required project documentation validation passed (run #43143724535). It records initial HEC/PM&DC/PNMC public-terms findings. No directory-specific reuse permission was established; all source families remain research-only.

## PR #16 source-rights register delivery
PR #16 merged as `fdcfb6bd26bc3f0cd1b7467e4f506c7ca40bf2c4`; exact head `902d0af180152b78c42f1bb816545617afcd6b37`; required documentation validation passed (run #43139966390).

## PR #20 TVET/QAB research evidence
PR #20 merged as `3d66f643cc06054d3caeb2d004da4217b3d86e9d`; exact head `01262d6df0dedf1593487d3df39b5151e041ca9d`; required documentation validation passed (run #43144611231). It mapped provider/QAB/assessment/accreditation distinctions and official TVET directory leads; all sources remain research-only pending rights review.

## PR #19 school-source rights evidence
PR #19 merged as `b1a38aab46822d3d877a720e04cb19a6164a623b`; exact head `01567f2a4c597b1a3a136fe14f5fc82249a767b1`; required documentation validation passed (run #43144376429).

## PR #18 documentation history reconciliation
PR #18 merged as `8aebd2df27de2a3bedfddb9b83bf32241e4d7135`; exact head `1655c9fdd75777b6106e3c4dbcdf4cb68b4b94f6`; required documentation validation passed (run #43143898130).

## PR #21 documentation evidence reconciliation
PR #21 merged as `56530e2e6b6ad562cad961ca0675f77ad5bb0e0b`; exact head `013b17c2080d9ca9b787ba55190af287f2c1b148`; required `Project documentation validation` check passed (run #43144752274). It reconciled the catalogue, progress report and traceability records for PRs #18–#20.


## PR #22 NAVTTC source clarification evidence
PR #22 merged as `2faeba2ba7637a6b4972079d5de3be2b56a7a5dd`; exact head `773c4c20165f51098ba8f01a24dd0c06ede44b57`; required `Project documentation validation` check passed (run #43145057750). It distinguished NAVTTC production TIS/NSIS/NVQF routes, institute registration and NAC-TVS accreditation; recorded published accreditation validity/renewal/score criteria; excluded staging/test directory evidence; and preserved research-only rights and privacy boundaries.
## 2026-11-12 NAVTTC registration/accreditation clarification
The production NAVTTC site links TIS, NSIS and NVQF Registry; separate official pages describe institute registration and NAC-TVS accreditation. NAVTTC's accreditation process page states three-year validity, renewal application at least six months before expiry and a 700/1000 minimum assessment score. These are distinct claims and must not be collapsed into a single provider-recognition status. The registration workflow requests sensitive institutional/individual documentation; such material is excluded from public institution discovery. Punjab TEVTA's RTI page is an access-to-information route, not a blanket reuse license. No directory-specific reuse permission was established; all sources remain research-only. Sources: https://navttc.gov.pk/; https://navttc.gov.pk/accreditation-process/; https://reg.navttc.gov.pk/; https://tms.navttc.gov.pk/nsis/institute_help/info; https://tevta.gop.pk/right-to-information/.

## PR #23 evidence reconciliation
PR #23 merged as `2a94f8caced03142fee56c5b6e6fc1afa2f6df65`; exact head `737ec6838dc85d4ba1becc600af661d998074c0a`; required `Project documentation validation` check passed (run #43145140802). It reconciled PR #22 merge evidence in the catalogue, progress report and controller. M1-S02 remains in progress.

## PR #24 evidence reconciliation
PR #24 merged as `1c2004186a834f5fc06af82d75bf883e26900762`; exact head `1995f3c1d63a44f1673ac29ba76b2a09ac6e8d93`; required `Project documentation validation` check passed (run #43145235157). It reconciled PR #23 evidence across the project control records.

## M1-S02 national coverage synthesis draft
`docs/03-research/M1_NATIONAL_INSTITUTION_COVERAGE_SYNTHESIS.md` consolidates the current official-source discovery baseline and unresolved sector/jurisdiction, status, freshness, privacy and reuse-rights gaps. It is a draft input to S02-C08, not evidence of completed source verification or owner acceptance. No source is approved for collection or reuse.

## PR #25 national coverage synthesis evidence
PR #25 merged as `b06b669627d299ccd5d84416b787274a8e1dac76`; exact head `703fc553aca6d06e354849a7a0d6a69bc71e53e7`; required `Project documentation validation` passed (run #43145378929). It added the draft national institution coverage synthesis, linked/catalogued it and marked S02-C08 in progress. The synthesis is not a final coverage inventory or source-reuse approval.

## PR #26 evidence reconciliation
PR #26 merged as `246c75f66e41dca83202ad555fe7739d7e5cf5a1`; exact head `3af965f161a3d823eb00c9dd2056236056715025`; required `Project documentation validation` passed (run #43145461579). It reconciled PR #25 evidence across project control documents.

## M1-S02 expanded source-verification evidence
The coverage matrix, taxonomy, national synthesis and rights register were expanded with professional programme authorities (HEC council map, PM&DC, PNMC, PCP, PEC, NCEAC, NACTE, NBEAC, NTC, NCH), school-source distinctions (Punjab public OpenPunjab vs private PEPRIS, KPPSRA district status, Sindh ASC 2024–25, Balochistan EMIS), TVET production-source semantics and non-formal/special-education gaps. Data-quality, freshness and privacy warnings are recorded. All sources remain research-only; no permission request or ingestion approval exists. S02-C09 remains an explicit owner-approval gate.

## PR #27 evidence reconciliation
PR #27 merged as `180a6cc19195362caabc3a029dc54c4cc5fc01da`; exact head `8890198905204d07e84c9825ce58b524b7ac27f7`; required `Project documentation validation` passed (run #43147371049). It expanded M1-S02 source/rights evidence and reconciled PR #26.

## M1-S02 owner acceptance evidence
`docs/03-research/M1_S02_OWNER_ACCEPTANCE_REVIEW.md` is a decision-ready review pack, not an approval record. It sets out a recommended limited research-baseline closeout and the alternative of keeping S02 open. Owner decision remains pending. Additional PBC and PVMC source-family evidence is documented; PCATP, NCT, NAEAC and AHPC remain verification gaps. No source-use permission is implied.

## PR #28 evidence reconciliation
PR #28 merged as `2254d52f8799c137ad64e0c28502913453e6d218`; exact head `bbf694ed0d7e372b3e8d4c754b29e3773adbb9c4`; required `Project documentation validation` passed (run #43147548460). It added PBC/PVMC professional-source evidence and the M1-S02 owner acceptance review pack, and reconciled PR #27.

## M1-S02 owner acceptance gate
The current S02 research/documentation package is ready for owner review. S02-C09 remains pending; the AI must not self-approve the taxonomy or close the step without the owner's explicit choice. All sources remain research-only and no collection/reuse is authorized.

## PR #29 evidence reconciliation
PR #29 merged as `8e88443a9d7da11fb1414774ad4766256033d16c`; exact head `52ed405a11b14e2698e046ebb407d3a53b8542ff`; required `Project documentation validation` passed (run #43147641844). It reconciled PR #28 evidence and confirmed that S02-C09 remains an owner-only acceptance gate.

## PR #30 evidence reconciliation
PR #30 merged as `3553d75a5afd84e8fcfab372324342f7acad7456`; exact head `4ca9d571206072064294f7fb163584db174669f8`; required `Project documentation validation` passed (run #43147756202). It repaired the S02 task register's Markdown table structure without changing weights or status decisions, and reconciled PR #29.

## PR #31 evidence reconciliation
PR #31 merged as `63d9386a8d93a12cb3f609480f6d101b890bade0`; exact head `1f92b1d2c1021b3a2dc93ad9f00e8082b7158b2a`; required `Project documentation validation` passed (run #43147833542). Final verification confirmed the S02 task table has four columns on each of nine rows and weights total 100%.

## Documentation catalogue maintenance

`DOCUMENTATION_CATALOG.md` is the owner-facing inventory for documentation delivery and acceptance. Reconcile it on every documentation PR update and merge. Keep delivery status separate from content acceptance; update PR/head/check/merge evidence and links.


## M1-S02 supplemental research evidence — 2026-11-12

The additional AJK, Balochistan, NFEMIS, GB EMIS, HEC PQR/allied-health NOC and historical special-education findings are documented in docs/03-research/M1_S02_SUPPLEMENTAL_SOURCE_COVERAGE_REVIEW_2026-11-12.md. This strengthens TAX-001 source-family evidence and records material data-quality warnings, including NFEMIS dashboard/inventory totals differing by two and GB EMIS zero-valued summary metrics. It does not establish complete coverage, source reuse rights or S02 acceptance. All sources remain research-only; S02-C09 remains owner approval only.


## PR #33 supplemental source evidence

PR #33 added the dated AJK private-institution register lead, Balochistan EMIS field/scope evidence, NFEMIS dashboard/inventory discrepancy, GB EMIS zero-valued summary warning, HEC PQR/allied-health NOC distinctions and historical-only KP special-education lead. Exact head `09a3051043bf47825360cf03ea220c11eff121f7` passed required documentation validation (run #43151991943); merge commit `f6c22c70d4128784b2e3b76cd4115113ad7e5329`. TAX-001 remains in progress; S02-C09 remains an owner-only gate.


## PR #34 reconciliation evidence

PR #34 merged as `569ef14f0cc4ef72bb07cf0313965e13250eac3d`; exact head `fce8164fe73bf435aa7c021ac3b8eb7e521c89a7` passed required Project documentation validation (run #43152117268). It reconciled PR #33 merge evidence across the documentation source of truth. TAX-001 remains in progress pending remaining S02 evidence and owner acceptance.


## M1-S02 professional-council and special-education evidence — 2026-11-12

The second supplemental review documents PCATP, NCT, AHPC, NTC, NAEAC and ICT/KP special-education evidence. It strengthens TAX-001 source-family evidence and records crucial status semantics: applied-for recognition is not granted recognition; zero/interim phase is not final accreditation; and historical special-education lists are not current coverage. S02-C03/C06/C07 and TAX-001 remain in progress. No source-use permission is implied.

## PR #35 final reconciliation evidence

PR #35 merged as `0cb1c8cf1dba9fb0b90b1fa8bda16123d57c65f6`; exact head `48626561f492c03baab9ce72fb79e7a24a01640f` passed required Project documentation validation (run #43152199340). It reconciled PR #34 merge evidence; TAX-001 remains in progress pending S02 acceptance.


## PR #36 council/special-education evidence

PR #36 merged as `c0a5e0cc743336610b0eef5d5e56fde5406d92db`; exact head `fb629563b395a29b4d02df443acaa63c4cd38f01` passed required Project documentation validation (run #43152421589). TAX-001 remains in progress; application-versus-approval and zero/interim-versus-final-accreditation distinctions are now explicit in the research supplement.


## M1-S02 deep jurisdiction and TVET evidence — 2026-11-12

The new review strengthens TAX-001 source-family discovery for special education and TVET, including Punjab/Sindh/GB facility leads, KP-TEVTA's 33-institute aggregate, STEVTA region/district filters, Punjab TEVTA's 2024 list and B-TEVTA/NAVTTC scope discrepancy. It records staging/sample-data exclusion, source-status limitations and privacy minimization. It does not establish a complete provider census, rights clearance or owner acceptance. S02-C04/C05/C06/C07/C08 and TAX-001 remain in progress.

## M1-S02 ICT PEIRA and Madaris taxonomy evidence — 2026-11-12

The ICT PEIRA register improves S02-C04 jurisdiction evidence. DGRE's nationwide Madaris registration mandate adds a distinct provider family for S02-C01, while IBCC QAB recognition versus specific qualification equivalence strengthens S02-C05 relationship semantics. Current DGRE register freshness and source rights remain open; no sensitive maslak field is included in the general V2 discovery taxonomy. No acceptance or source-use permission is inferred.

## PR #38 deep jurisdiction/TVET delivery evidence

PR #38 merged as `a38fa149d10be99903ca6bb44236bd1e68565e6a`; exact head `f1f7aa59424b5161ec91a3f3ae60ff20471edba2` passed required Project documentation validation (run #43153839019). It adds S02-C04/C05/C06 source-family evidence; record-level completeness and rights remain open.


## M1-S02 examination-board and PMF evidence — 2026-11-12

The IBCC board roster and Punjab BISE network strengthen assessment/awarding-body relationship evidence; Punjab Medical Faculty strengthens S02-C03 provincial allied-health affiliation evidence; DGRE jurisdiction and multi-region lists strengthen S02-C01 provider taxonomy and coverage. Record-level freshness/anomalies and source rights remain unresolved. No board membership or affiliation is treated as accreditation or source-use authorization.

## PR #39 ICT PEIRA/Madaris evidence delivery

PR #39 merged as `0ace505ec67a420b8c2eb8fedd13ba1a2499f84c`; exact head `cf4d54967cad1f2114cd1f43dfccec5184d1b759` passed required Project documentation validation (run #43154066994). It strengthens ICT coverage and the Deeni Madaris provider taxonomy; source freshness and rights remain open.


## M1-S02 HEC affiliation/study-centre and programme status evidence — 2026-11-12

HEC 2024 policy adds explicit approved study-centre/MoU relationship requirements; current affiliated-college continuation is DAI/programme-specific. PM&DC and PCP provide session-specific programme/admission status examples; PNMC freshness limitations remain. These findings strengthen taxonomy and verification requirements but do not close record-level research or rights work.

## PR #40 board, PMF and DGRE delivery evidence

PR #40 merged as `c92d96613dcb510762be5a0a615a73e856861f9b`; final exact head `cc2cc7eaa615e4fe762f808e51918b6b10b5e235` passed required Project documentation validation (run #43154387281). The research strengthens assessment-board, affiliation, programme and territorial relationships but does not close remaining record-level verification or rights requirements.


## M1-S02 national rights/privacy framework evidence — 2026-11-12

MoITT draft policy/Bill status, RTI access-versus-reuse distinction, Copyright Ordinance compilation/data distinction and PBS's scoped open-license example are documented in the data-rights review. This improves S02-C07 requirements but does not provide source-specific legal clearance. Privacy minimization remains mandatory; no source is approved for reuse.

## PR #41 reconciliation evidence

PR #41 merged as `c56200bdf66a5fdf615de0da6281495e50c39f92`; exact head `2c11bfc7fe74da6bed4dc04d17c4c80a664990b0` passed required Project documentation validation (run #43154481312). It reconciled PR #40 merge evidence; M1-S02 remains in progress.


## M1-S02 school-jurisdiction source evidence — 2026-11-12

AJK public/private census streams, GB EMIS/BECS/college lists, Sindh district-to-UC institution checker and Punjab PEPRIS eLicense caveats strengthen S02-C04/C06 source-family coverage. Data-system differences, freshness, completeness and source rights remain unresolved. Personal teacher/contact/identity/student data is excluded.

## PR #42 data-rights/privacy delivery evidence

PR #42 merged as `a6b35abcb091965f90e492e36378750b2f20ebad`; exact head `80a85a42418ee0176f3fad6ad63e0220f1978c8b` passed required Project documentation validation (run #43154673045). It improves S02-C07 evidence but does not establish source-specific legal clearance.


## M1-S02 private-school register status evidence — 2026-11-12

Sindh DIRPIS/SPEI-EMIS and KPPSRA district registers strengthen S02-C04 private-provider coverage and status semantics. Sindh census freshness and KP district completeness remain unresolved; no source reuse permission is inferred.

## PR #42 data-rights/privacy delivery evidence

PR #42 merged as `a6b35abcb091965f90e492e36378750b2f20ebad`; exact head `80a85a42418ee0176f3fad6ad63e0220f1978c8b` passed required Project documentation validation (run #43154673045). It improves S02-C07 evidence but does not establish source-specific legal clearance.


## M1-S02 regulator/status and source-terms evidence — 2026-11-12

The latest review strengthens private-school registration and board-affiliation semantics for KP/Sindh and clarifies HEC/NAVTTC source scope. It does not establish source-specific reuse rights or full coverage.

## PR #43 school-source delivery evidence

PR #43 merged as `a8dfd8018fa33588a4d35166c953b18f89e39c43`; final exact head `56923aca98123dce6b8a574e0cf9f9c244b036b4` passed required Project documentation validation (run #43155004215). It strengthens S02-C04/C06 source coverage; record-level completeness and rights remain open.


## M1-S02 KP/ICT/AJK public-sector coverage evidence — 2026-11-12

KP role-based iEMIS, ICT FDE aggregate-only portal and AJK HED 178/180 college discrepancy strengthen the explicit coverage-gap record for S02-C02/C04. No unauthorized access, count selection or source reuse is inferred.

## PR #44 regulator/terms delivery evidence

PR #44 merged as `11ee337d823731d71a9c0ca00782728ad1994398`; exact head `0b5fe6429a1f6bc8bb383d1db1278d632ae04f08` passed required Project documentation validation (run #43155204020). It improves S02-C04/C05/C07 evidence but does not establish complete coverage or source rights.


## M2 architecture traceability baseline — 2026-11-12

The architecture-specific traceability matrix is established at `../05-architecture/M2_REQUIREMENTS_ARCHITECTURE_TRACEABILITY.md`. M2-S01 will expand the stable requirement identifiers and map each accepted M1 requirement and G01-G20 item to architecture elements, ADRs, risks/controls and future verification scenarios.

This initial scaffold is not a claim that every requirement is already designed or tested. Any unresolved mapping must remain visibly pending, deferred or owner-gated.


## M2 architecture traceability baseline — 2026-11-12

The architecture-specific traceability matrix is established at `../05-architecture/M2_REQUIREMENTS_ARCHITECTURE_TRACEABILITY.md`. M2-S01 will expand stable requirement identifiers and map accepted M1 requirements and G01-G20 to architecture elements, ADRs, risks/controls and future verification scenarios.

This initial scaffold is not a claim that every requirement is already designed or tested. Unresolved mapping must remain visibly pending, deferred or owner-gated.


## M3-01 AI-era requirement traceability — 2026-11-12

The AI-era review adds AI-ARCH-01 through AI-ARCH-20. These are planning requirements, not accepted implementation requirements or test results. The authoritative definitions and minimum acceptance criteria are in `../05-architecture/M3-01_AI_ERA_ARCHITECTURE_READINESS_REVIEW_2026-11-12.md`.

| Requirement ID | Requirement | Specification | Step | PR / commit | Test / evidence | Status |
|---|---|---|---|---|---|---|
| AI-ARCH-01 | Provider/model independence | M3-01 AI-era architecture readiness review §4 | M3-01 P04 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future provider-adapter substitution test | Proposed — owner review pending |
| AI-ARCH-02 | AI-optional operation | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future AI-off and provider-outage test | Proposed — owner review pending |
| AI-ARCH-03 | Evidence-grounded RAG | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future citation, freshness, conflict and abstention tests | Proposed — owner review pending |
| AI-ARCH-04 | Optional vector retrieval | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future retrieval benchmark and rebuild/portability tests | Proposed — owner review pending |
| AI-ARCH-05 | Controlled agent execution | Same §4 | M3-01 P04/P05/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future allowlist, least-privilege and tool-abuse tests | Proposed — owner review pending |
| AI-ARCH-06 | Human approval/publication integrity | Same §4 | M3-01 P05/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future no-model-to-publication bypass test | Proposed — owner review pending |
| AI-ARCH-07 | Prompt/configuration lifecycle | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future version pin, review and rollback evidence | Proposed — owner review pending |
| AI-ARCH-08 | AI evaluation/regression | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future synthetic evaluation suite and owner-approved thresholds | Proposed — owner review pending |
| AI-ARCH-09 | Prompt-injection and RAG threat protection | Same §4 | M3-01 P05/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future adversarial retrieval/tool/data-exfiltration tests | Proposed — owner review pending |
| AI-ARCH-10 | Observability and cost controls | Same §4 | M3-01 P04/P05/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future redaction, quotas, alert and hard-stop tests | Proposed — owner review pending |
| AI-ARCH-11 | Versioned API/contracts | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future compatibility and contract validation tests | Proposed — owner review pending |
| AI-ARCH-12 | Bounded interoperability/MCP evaluation | Same §4 | M3-01 P04/P05 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future external-server trust and permission tests | Proposed — owner review pending |
| AI-ARCH-13 | Asynchronous work/event discipline | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future idempotency/retry/dead-letter tests if jobs are justified | Proposed — owner review pending |
| AI-ARCH-14 | Data portability/provider exit | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future export, provider replacement and index rebuild tests | Proposed — owner review pending |
| AI-ARCH-15 | English/Urdu and transliteration readiness | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future Unicode, RTL, bilingual and transliteration corpus | Proposed — owner review pending |
| AI-ARCH-16 | AI data minimization/privacy | Same §4 | M3-01 P05/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future data-flow, redaction and prohibited-data tests | Proposed — owner review pending |
| AI-ARCH-17 | Policy and context isolation | Same §4 | M3-01 P05/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future cross-scope and Deeni Madaris zero-exposure tests | Proposed — owner review pending |
| AI-ARCH-18 | Replaceable search/geospatial services | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future adapter/outage/manual-locality tests | Proposed — owner review pending |
| AI-ARCH-19 | Release rollback and kill switch | Same §4 | M3-01 P04/P06/P07 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future capability-disable, rollback and incident shutdown test | Proposed — owner review pending |
| AI-ARCH-20 | AI dependency lifecycle governance | Same §4 | M3-01 P04/P06 | PR #124; merge 4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5 | Future support/security/upgrade/retirement review | Proposed — owner review pending |
 
All twenty entries remain planning proposals until owner acceptance and later scope-specific verification. No PR merge or document presence is treated as implementation evidence.


## FND-01 implementation traceability — PR #136

| Requirement ID | Requirement | Specification | Step | PR / commit | Test / evidence | Status |
|---|---|---|---|---|---|---|
| FND-01 | Reproducible Laravel 13 / PHP 8.5 local foundation | M3-01 P07 FND-01 authorization; FND-01 implementation record | M3-01 P07 (bounded package) | PR #136; merge f61b4d17492294d45518493337f3fcd58fd78487; exact head d9b8eb8bb04c394d2b08e1a451fcb2d338158662 | Locked Composer install, Composer validation/audit, Pint, Laravel bootstrap/route list, PHPUnit, artifact hygiene | Delivered and merged; exact-head CI passed |
| FND-02 | Fixed non-sensitive health endpoint | FND-01 implementation record | M3-01 P07 | PR #136; merge f61b4d17492294d45518493337f3fcd58fd78487 | Health endpoint feature test | Delivered; exact-head CI passed |
| FND-03 | Deeni Madaris visibility seam defaults off and fails closed | FND-01 implementation record | M3-01 P07 | PR #136; merge f61b4d17492294d45518493337f3fcd58fd78487 | Synthetic unit tests for default-off and unset/null behavior | Delivered; exact-head CI passed; does not certify future surfaces |
| FND-04 | Database-free local/CI defaults and no migrations | FND-01 implementation record | M3-01 P07 | PR #136; merge f61b4d17492294d45518493337f3fcd58fd78487 | PHPUnit config inspection and CI artifact hygiene; no database commands run | Delivered within bounded scope |
| FND-05 | Protected, read-only GitHub CI quality checks | FND-01 implementation record | M3-01 P07 | PR #136; merge f61b4d17492294d45518493337f3fcd58fd78487 | CI run #43380176340 and docs validation run #43380176524 | Exact-head checks passed |

FND-01 traceability applies only to the bounded local/CI package. It does not satisfy the separate M3-02 exit criteria or authorize Hostinger, production, database, source-data, external-service or deployment work.


## M3-02 foundation hardening traceability — implementation candidate

| Requirement ID | Requirement | Specification | Step | PR / commit | Test / evidence | Status |
|---|---|---|---|---|---|---|
| ENV-01 | Local/test/CI environment boundary and variable inventory | M3-02 Environment Configuration and Diagnostics Baseline | M3-02 | Pending PR; branch `feature/m3-02-foundation-hardening` | Environment matrix and non-secret variable inventory documented | Delivered in candidate; CI/review pending |
| ENV-02 | Safe local/CI runtime defaults | Same | M3-02 | Pending PR | PHPUnit asserts testing/debug-off, array cache/session, sync queue, local filesystem, no database config, array mail and null broadcasting | Delivered in candidate; CI pending |
| LOG-01 | Privacy-safe, non-verbose default logging | Same | M3-02 | Pending PR | Warning-level fallback and tests for local stack, warning threshold, null deprecation channel and disabled traces | Delivered in candidate; CI pending |
| SEC-ENV-01 | Secret lifecycle and no production credentials in CI | Same | M3-02 | Pending PR | Documentation inventory; existing workflow remains contents:read and requires no secrets | Documented; exact-head workflow review pending |
| GOV-PR-01 | Read-only audit of effective default-branch ruleset | Same | M3-02 | Read-only audit 2026-11-13 | Active ruleset ID 27043221 inspected; PHP foundation check not currently required; no settings changed | Audit delivered; governance change not authorized |

These rows describe only the bounded M3-02 candidate and do not represent full M3-02 exit acceptance.



## M3-02 traceability status correction — PR #139 merged (2026-11-13)

This addendum supersedes the candidate/pending-PR statuses in the M3-02 foundation hardening rows above. ENV-01, ENV-02 and LOG-01 are delivered in merged PR #139 (merge bab5d7458b2820be2f93f242b925eaed2ae0ece0; final PR head b5f8761f0d1607571bf85dd10f259e4a159ab099). PHP 8.5 foundation CI run #43389214026 and Project documentation validation run #43389213905 passed on that exact head. SEC-ENV-01 is documented for local/CI only; it is not evidence of production secret handling. GOV-PR-01 read-only audit is delivered: active ruleset 27043221 does not require PHP foundation CI, and no settings were changed.

These entries represent bounded local/CI delivery, not full M3-02 acceptance. Architecture conformance, V2-specific environment isolation, operational observability beyond local/CI diagnostics and any required owner decisions remain open. See the M3-02 Step 1–2 Reconciliation and Repository Governance Audit for criterion-level status.
