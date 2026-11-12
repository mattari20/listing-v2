# Implementation Traceability Matrix

| Requirement ID | Requirement | Specification | Step | PR / commit | Test / evidence | Status |
|---|---|---|---|---|---|---|
| GOV-001 | Independent greenfield repository | Project Constitution | M0-S01 | Bootstrap commit; PR #1 merged as `0f2165f3d18e43f10cf6d6f717f145d3433769a4` | Repository metadata; founding documentation present | Accepted — M0 closeout |
| GOV-002 | Documentation-driven execution and status tracking | AI Execution Protocol; Project Master Control; Documentation Catalogue | M0-S03 | PR #1–#4 merged | Controller, step register, catalogue and progress-report links | Delivered — acceptance review pending |
| GOV-003 | Protected PR workflow and eligible automatic merging | Repository Governance Setup; Engineering Standards; DEC-002 | M0-S05/S06 | PR #1 merged; ruleset `main` ID 27043221 active | Required check `Validate project control documents`; auto-merge enabled; PR #2 required check passed on exact head; squash merge SHA `975cd672378e8d30982d44d54d12e195e9c57d5d`; auto-merge execution not independently tested | M0 protected-PR workflow verified through PR #2; repository auto-merge enabled but automatic execution untested |
| PROD-001 | Student-first discovery and decision support | Product Vision; M1 Student Journey Research | M1-S01 | PR #1 baseline; PR #6 desk research merged; PR #7 adult instruments and PR #8 evidence reconciliation merged | PBS, Punjab HED and published Pakistan-focused student-choice research; draft adult interview/survey kit prepared; primary research pending | In progress — desk research baseline only |
| DATA-001 | Multi-source lawful data catalogue | Education Data Strategy | M1-S02–S08 | PR #1 merged | Provider/rights register requires source evidence expansion | Delivered — research/acceptance pending |
| OSS-001 | Lawful open-source and dataset reuse | Open-Source Reuse Audit | M1-S06/S07 | PR #1 merged | Candidate research and license/security scorecards pending | Delivered — research pending |
| TRUST-001 | Account-based ratings and reviews after launch | Comparison, Reviews and Trust | M1-S09 | PR #1 baseline; clarified in current documentation PR | Owner direction: login required to submit; post-launch collection; moderation, privacy and age safeguards still need detailed design | Product requirement recorded — detailed design pending |
| TAX-001 | Pakistan provider taxonomy, coverage and recognition/affiliation distinctions | M1 Institution Taxonomy Research; M1 Official Institution Source Coverage Matrix | M1-S02 | PR #10 merged as `11bb356f678e8559e9cd17940a68ab35dcf131b5`; source coverage addendum prepared in current PR | HEC, PMDC, PNMC, PCP, PEC, NCEAC, NACTE, NCH, Punjab/Sindh special education, provincial school EMIS/regulator portals and NAVTTC source families identified; jurisdiction, rights and freshness gaps recorded; dated public-terms review added for HEC, PM&DC, PNMC, KP-PSRA, ICT-PEIRA and Sindh RSU/SEMIS; TVET/QAB source map added; no directory-specific reuse permission established | In progress — source discovery baseline delivered; verification and owner acceptance pending |

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

## Documentation catalogue maintenance

`DOCUMENTATION_CATALOG.md` is the owner-facing inventory for documentation delivery and acceptance. Reconcile it on every documentation PR update and merge. Keep delivery status separate from content acceptance; update PR/head/check/merge evidence and links.
