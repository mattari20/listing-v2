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
- M0 closeout next step was M1-S01; subsequent current-step status and authorizations are recorded in the authoritative M1 current-position section below.

## M1 — Student requirements and independent research
| Step | Scope | Target / acceptance evidence |
|---|---|---|
| M1-S01 | Student journey desk research and requirements baseline | Independent desk-research synthesis and provisional journey hypotheses; primary participant research is explicitly deferred during construction by owner |
| M1-S02 | Institution taxonomy and coverage requirements | Independent level/type/sector/geography matrix, recognition/affiliation distinctions and inclusion rules; see `../03-research/M1_INSTITUTION_TAXONOMY_RESEARCH.md` and `../03-research/M1_OFFICIAL_INSTITUTION_SOURCE_COVERAGE_MATRIX.md` |
| M1-S03 | Official government/regulator provider research | New source register with access, rights, coverage and freshness evidence |
| M1-S04 | Private provider and institution-source research | `../03-research/M1_S04_PRIVATE_PROVIDER_SOURCE_REGISTER_2026-11-12.md` — 21 source families, seven-jurisdiction coverage assessment and documented gaps |
| M1-S05 | Programme/admissions information research | 22-source-family federated programme/admissions evidence model; formal owner acceptance record `../03-research/M1_S05_OWNER_ACCEPTANCE_RECORD_2026-11-12.md` — **Accepted and Closed 2026-11-12** |
| M1-S06 | Independent GitHub software and dataset discovery | `../03-research/M1_S06_GITHUB_SOFTWARE_DATASET_DISCOVERY_2026-11-12.md` — independent software/dataset candidate register, transferability and exclusions; **Accepted and Closed 2026-11-12** |
| M1-S07 | License, data-rights and security assessment | `../03-research/M1_S07_SOURCE_RIGHTS_SECURITY_ASSESSMENT_2026-11-12.md` — source/asset rights, privacy, security gates and candidate dispositions; **Accepted and Closed 2026-11-12** |
| M1-S08 | V2 AI data-agent workflow requirements | Source-specific collection, verification, scheduling and human-review requirements |
| M1-S09 | Comparison, review and trust research | Rating rubric, moderation, privacy and abuse cases |
| M1-S10 | M1 synthesis and acceptance | Research report, gap register and approved inputs to M2 |

### M1-S01 task breakdown (weights total 100%; primary research deferred by owner)
| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S01-T01 Desk research and evidence register | 35% | Independent dated source synthesis; claim-to-source mapping and limitations | **Completed** — eight evidence items across official statistics, official admission/equivalence routes and published Pakistan-focused choice research; primary sources and limitations recorded |
| S01-T02 Participant segments and research protocol | 15% | Provisional segments and documented research safeguards; no recruitment during construction | **Completed for preparation scope** — hypotheses and safeguards documented; adult instrument archived and inactive; owner deferred fieldwork |
| S01-T03 Primary interviews/survey | 0% | No pre-launch survey or interview under current owner direction | **Deferred by owner** — 0% weight; no fieldwork, recruitment or outreach during construction |
| S01-T04 Journey mapping and synthesis | 25% | Desk-research journey with actors, stages, questions, decision points, evidence needs and gaps; no validation claim | **Completed** — end-to-end provisional desk-research journey and deferred-validation backlog documented |
| S01-T05 Requirements and acceptance criteria | 25% | Stable requirement IDs, traceability, measurable acceptance scenarios and unresolved assumptions | **Completed** — SR-01–SR-14 documented; product vision and traceability reconciled; implementation-neutral tests and open questions recorded |

**M1-S01 weighted documentation completion:** 100% (T01 35% + T02 15% + T04 25% + T05 25%). T03 is an explicitly owner-deferred zero-weight activity and is not represented as completed. **M1-S01 is Accepted and Closed by owner decision on 2026-11-12** as a construction-stage desk-research and requirements baseline. Primary participant validation remains deferred and is not implied by this percentage.

### M1-S01 owner acceptance evidence

The closeout review is `../03-research/M1_S01_CLOSEOUT_REVIEW_2026-11-12.md`; the formal acceptance record is `../03-research/M1_S01_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. PR [#71](https://github.com/mattari20/listing-v2/pull/71) merged as `64bd568d522e41452b8b46db8652ec8df48a2d8b`; exact PR head `2982bdf421e09e82c03b76c223adb1b6ecc0b180` passed required Project documentation validation (run [#43166985628](https://github.com/mattari20/listing-v2/actions/runs/43166985628)). PR [#72](https://github.com/mattari20/listing-v2/pull/72) reconciled merge evidence. Owner acceptance confirms the desk-research baseline, provisional nature of segments/journey, SR-01–SR-14, explicit deferral of primary research and carried-forward limitations. It does not authorize implementation, participant research, source reuse or ingestion.

### M1-S04 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S04-T01 Scope, provider categories and evidence protocol | 10% | Private/non-state provider scope, source classes, evidence standards and boundaries | **Completed** — scope and evidence rules documented; private commercial, NGO/community, provider-operated, TVET and specialist categories distinguished |
| S04-T02 Private school sources by jurisdiction | 20% | Official source inventory across provinces/territories with fields, access, freshness and gaps | **Completed with limitations** — Punjab PEPRIS, KP-PSRA, ICT-PEIRA, AJK PEIRA, Sindh DIRPIS and Balochistan BPEIRRA/EMIS routes assessed; GB private-school register remains unverified |
| S04-T03 Private colleges and higher-education providers | 15% | Private college, university, campus and regulator sources with entity/recognition distinctions | **Completed with limitations** — HEC, Punjab HED, Sindh private-college directorate and KP HERA mapped; Sindh visible records are dated and other jurisdictional gaps remain |
| S04-T04 Private TVET and vocational providers | 15% | NAVTTC and regional TEVTA provider/registration/accreditation routes with evidence limitations | **Completed with limitations** — national registration and provincial TEVTA source families mapped; public record-level private-provider coverage not established; sample/staging data excluded |
| S04-T05 Private professional and specialist providers | 10% | Private provider cross-links to competent councils, boards and programme approval sources | **Completed at source-family level** — S02/S03 regulator routes cross-referenced; provider/campus/programme/session linkage remains for later reconciliation |
| S04-T06 NGO, community, faith-based, online and other non-state providers | 10% | Category definitions, source leads and inclusion/recognition boundaries | **Completed at baseline level** — provider types distinguished; category-specific regulator and inclusion gaps recorded; Deeni Madaris default-OFF decision preserved |
| S04-T07 Coverage, access, privacy, freshness and data-quality assessment | 10% | Cross-jurisdiction gap matrix and source-native status, personal-data and rights limitations | **Completed with limitations** — seven-jurisdiction confidence matrix, status lifecycle and privacy constraints recorded; all sources remain RESEARCH ONLY |
| S04-T08 Consolidated private-provider inventory and gap analysis | 5% | Deduplicated source-family register, actionable gaps and research conclusion | **Completed** — 21 source-family records and seven-jurisdiction coverage assessment documented |
| S04-T09 Owner review and step acceptance | 5% | Owner-reviewed source register, limitations, gap analysis and research-only boundary | **Accepted — owner approval recorded 2026-11-12** |

**M1-S04 weighted research/documentation completion:** 100% (T01–T08 research tasks complete and T09 accepted by owner on 2026-11-12). This is not a private-provider census, legal clearance or source-reuse approval. No provider records were scraped, bulk-downloaded or ingested.

### M1-S04 owner acceptance evidence

Review `../03-research/M1_S04_PRIVATE_PROVIDER_SOURCE_REGISTER_2026-11-12.md` and formal [M1-S04 Owner Acceptance Record](../03-research/M1_S04_OWNER_ACCEPTANCE_RECORD_2026-11-12.md). The owner explicitly accepted the 21 source-family inventory, seven-jurisdiction coverage assessment, status/recognition distinctions, major coverage gaps, privacy safeguards and RESEARCH ONLY boundary. PR [#73](https://github.com/mattari20/listing-v2/pull/73) merged as `a66400189b2f2216e3743fe7b40a7f672cfb240a`; PR [#74](https://github.com/mattari20/listing-v2/pull/74) reconciled delivery evidence and merged as `8fda2dc21aa2fe12b606b2b4cb877fe229401e52`. Required checks passed on both exact PR heads (runs [#43169707414](https://github.com/mattari20/listing-v2/actions/runs/43169707414) and [#43169826241](https://github.com/mattari20/listing-v2/actions/runs/43169826241)). All source families remain RESEARCH ONLY; acceptance does not authorize source collection, reuse, ingestion or connector activation.

### M1-S05 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S05-T01 Scope, programme lifecycle and evidence taxonomy | 10% | Programme, campus, award, admission cycle, eligibility, fee and scholarship concepts distinguished | **Completed** — federated evidence model and separate programme/admission/financial-aid objects documented |
| S05-T02 Official programme and provider offer sources | 15% | Representative official provider programme/catalogue/prospectus sources and limits | **Completed with limitations** — HEC recognition, PU, UET, UMT, Sindh Agriculture University and University of Baltistan source patterns mapped; no national programme catalogue established |
| S05-T03 Eligibility, prerequisites and qualification equivalence | 15% | Official admission criteria, subject combinations, equivalence and regulator rules | **Completed with limitations** — UHS/NUMS/PM&DC, IBCC and institution-specific criteria mapped; criteria remain programme/session/category scoped |
| S05-T04 Admission cycles, application routes and selection stages | 15% | Centralized and institution-run admission schedules, notices, deadlines and portals | **Completed with limitations** — Punjab OCAS, UHS, NUMS and provider portals mapped; full provincial/territorial authority coverage remains open |
| S05-T05 Fee structures and cost components | 15% | Official fee schedules, categories, billing units and uncertainty rules | **Completed at baseline level** — UET and representative provider schedules mapped; province/sector coverage and total-cost completeness remain open |
| S05-T06 Scholarships, grants and financial aid | 10% | National/provincial/institution source families and eligibility/coverage distinctions | **Completed with limitations** — HEC Need-Based, HEC catalogue and PEEF/institution routes mapped; current windows and full provincial coverage remain open |
| S05-T07 TVET, professional and specialist programme routes | 10% | NAVTTC/NVQF and relevant professional-regulator programme/admission distinctions | **Completed with limitations** — NAVTTC student/programme routes and S02/S03 regulator cross-references documented; batch/campus/session approval requires exact verification |
| S05-T08 Freshness, provenance, privacy and conflict rules | 5% | Source hierarchy, notice revisions, deadline precision, privacy and stale-record handling | **Completed** — versioned evidence, status and conflict rules documented; no applicant data copied |
| S05-T09 Consolidated source register, gaps and product implications | 5% | Research synthesis, 22 source families and actionable open-gap list | **Completed** — 22 source families, federated model, data/evidence requirements and 10 follow-up gaps documented |
| S05-T10 Owner review and step acceptance | 5% | Owner-reviewed research register and explicit acceptance record | **Accepted — owner approval recorded 2026-11-12** |

**M1-S05 weighted research/documentation completion:** 100% (T01–T09 complete and T10 accepted by owner on 2026-11-12). This is not a national programme catalogue, current admissions inventory, legal clearance or source-reuse approval. No applicant data was collected, no source was scraped/bulk-downloaded and no records were ingested.

### M1-S05 owner acceptance evidence

The owner explicitly accepted the 22-source-family programme/admissions research baseline, federated evidence model, documented gaps and RESEARCH ONLY boundary on 2026-11-12. See `../03-research/M1_S05_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. Acceptance closes S05 as a research baseline only; it does not authorize source collection, reuse, ingestion or connector activation.

### M1-S06 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S06-T01 Define discovery categories and screening criteria | 10% | Scope and relevance categories documented | Completed |
| S06-T02 Discover institution-directory and search software | 20% | Independent public repository candidates screened | Completed — metadata/README level only |
| S06-T03 Discover datasets and geography/statistics references | 20% | Independent dataset candidates screened | Completed — metadata/README level only |
| S06-T04 Assess Pakistan relevance and transferability | 15% | Pakistan-specific and comparative-only uses distinguished | Completed |
| S06-T05 Record provenance, quality and coverage caveats | 15% | Candidate source claims and limitations documented | Completed |
| S06-T06 Rank candidates and document exclusions | 10% | Candidate dispositions and review conditions recorded | Completed |
| S06-T07 Owner review and step acceptance | 10% | Owner acceptance of candidate inventory and limitations | **Accepted — owner approval recorded 2026-11-12** |

**M1-S06 weighted research/documentation completion:** 100%; T01–T06 complete and T07 owner acceptance recorded 2026-11-12. This closes S06 as a research baseline only. No candidate code or data has been imported or executed.

### M1-S07 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S07-T01 Rights, access and asset taxonomy | 15% | Code/data/upstream/media/personal-data distinctions | Completed |
| S07-T02 Pakistan legal and policy context | 15% | Copyright, PBS and ODP references with scope caveats | Completed — desk research only |
| S07-T03 Candidate license and upstream rights review | 20% | Candidate-specific rights evidence and HOLD dispositions | Completed — no blanket permission inferred |
| S07-T04 Source-by-source rights evidence record | 15% | Required metadata and approval fields specified | Completed |
| S07-T05 Software supply-chain/security review framework | 15% | OpenSSF/Scorecard/GitHub controls documented | Completed — no code audit performed |
| S07-T06 Privacy and sensitive-data controls | 10% | Data minimization, sensitive location and Deeni Madaris restrictions reaffirmed | Completed |
| S07-T07 Owner review and step acceptance | 10% | Owner acceptance of rights/security framework and dispositions | **Accepted — owner approval recorded 2026-11-12** |

**M1-S07 weighted research/documentation completion:** 100%; T01–T06 complete and T07 owner acceptance recorded 2026-11-12. This closes S07 as a research baseline only. No source is approved for collection, ingestion, redistribution or commercial reuse.


### M1-S06/S07 owner acceptance evidence

The owner explicitly accepted the independent software/dataset discovery baseline and the deny-by-default rights/security assessment on 2026-11-12. See `../03-research/M1_S06_S07_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. S06 and S07 are accepted and closed as research baselines at 100% weighted task completion; candidate repositories and datasets remain unapproved for import or reuse. PR [#77](https://github.com/mattari20/listing-v2/pull/77) merged as `71e71ce74a57b854724027a1b106befe826b14fa`; exact head `deef364831cf4f0d902128ce9933897b17f9649c` passed required validation (run [#43171586968](https://github.com/actions/runs/43171586968)). PR [#78](https://github.com/mattari20/listing-v2/pull/78) reconciled merge evidence as `611e5677ceac67bff5b1cf5ae26f505e1596e82d`; exact head `df9d5aea93ccbdd6dbd7536eadc0f3ca000d7ead` passed required validation (run [#43171678247](https://github.com/actions/runs/43171678247)). No collection, cloning, execution, ingestion or source activation is authorized.

### M1-S08 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S08-T01 Agent mission, scope and hard boundaries | 10% | Discovery, retrieval and publication separated; rights-first/no-V1/no-live-activity controls | Completed |
| S08-T02 Source authorization and rights manifests | 15% | Asset-specific approval, permitted method, expiry and suspension controls | Completed |
| S08-T03 Workflow stages and provenance | 15% | End-to-end workflow and assertion-level provenance documented | Completed |
| S08-T04 Extraction, validation and entity resolution | 15% | Source-faithful extraction, deterministic validation and ambiguous-match gates | Completed |
| S08-T05 Conflict, confidence, freshness and publication | 15% | Evidence/risk separation, human review and reversible publication rules | Completed |
| S08-T06 Security, privacy and prompt-injection controls | 15% | Least privilege, hostile-source handling, data minimization and sensitive-data exclusions | Completed |
| S08-T07 Human governance, monitoring and acceptance scenarios | 10% | Roles, metrics and ten testable acceptance scenarios | Completed |
| S08-T08 Owner review and step acceptance | 5% | Owner acceptance of workflow requirements and limitations | **Accepted — owner approval recorded 2026-11-12** |

**M1-S08 weighted research/documentation completion:** 100%; T01–T07 complete and T08 accepted by owner on 2026-11-12. M1-S08 is Accepted and Closed as a research baseline only. No agent, connector, crawler, scheduler or live source access was activated.

### M1-S09 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S09-T01 Comparison purpose, entities and student use cases | 10% | Institution/campus/programme/intake comparison units documented | Completed |
| S09-T02 Comparison dimensions and data comparability | 15% | Programme, eligibility, admissions, cost, recognition, facilities and review dimensions | Completed |
| S09-T03 Ranking, sorting, sponsorship and transparency | 10% | Explainability, coverage, missing-data and paid-placement safeguards | Completed |
| S09-T04 Review account and eligibility policy | 10% | Login requirement preserved; experience-verification decision left open | Completed |
| S09-T05 Rating dimensions, authenticity and manipulation | 15% | Candidate dimensions and fake/incentivized/conflict rules | Completed |
| S09-T06 Moderation, institution reply, complaints and appeals | 15% | Fair process, reasons, appeals and no unilateral institution deletion | Completed |
| S09-T07 Privacy, minors, safeguarding and sensitive categories | 10% | Data minimization and legal review gates | Completed |
| S09-T08 Trust signals, legal research and open decisions | 10% | Source-backed trust model and M2 decision register | Completed |
| S09-T09 Owner review and step acceptance | 5% | Owner acceptance of comparison/review/trust research and limitations | **Accepted — owner approval recorded 2026-11-12** |

**M1-S09 weighted research/documentation completion:** 100%; T01–T08 complete and T09 accepted by owner on 2026-11-12. M1-S09 is Accepted and Closed as a research baseline only. Reviews remain a post-launch feature; no pre-launch participant research or review collection is authorized.







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
| S03-C01 Federal education governance and national data authorities | 12% | Verified authority/mandate map for MoFEPT, PIE/NEMIS, federal education bodies and national source routes, with scope and limitations | **Completed — limitations documented**; federal source map and source-year/coverage gaps recorded |
| S03-C02 Provincial and territorial school authorities/EMIS | 18% | Source-by-source official authority, public/private scope, route, visible fields, geography, update date and access constraints for all jurisdictions | **Completed — limitations documented**; all jurisdictions mapped with explicit public/private access, freshness, rights and register gaps |
| S03-C03 Higher education and professional regulators | 14% | Verified source register for HEC and relevant professional councils/accreditation bodies, including exact approval scope and status semantics | **Completed — limitations documented**; regulator scope, programme/batch statuses, application-versus-approval and incomplete current registers recorded |
| S03-C04 TVET, technical boards and qualification-awarding bodies | 12% | Verified NAVTTC registration, QAB, provincial board and accreditation routes with provider-versus-awarder distinctions | **Completed — limitations documented**; provider/QAB/assessment/awarder relationships and provincial count/scope discrepancies recorded |
| S03-C05 Non-formal and special-education authorities | 8% | Official authority/source inventory, coverage level, operational-status and privacy limitations | **Completed — limitations documented**; NFEMIS, DGSE, provincial/territorial source leads, mixed service types and privacy gaps recorded |
| S03-C06 Deeni Madaris registration and qualification pathways | 8% | Verified DGRE registration, IBCC QAB and HEC equivalence distinctions; provider and qualification statuses separated | **Completed — limitations documented**; DGRE registration, Wafaq/QAB and qualification equivalence distinguished; current register gaps remain explicit |
| S03-C07 Access, rights, freshness and privacy assessment | 13% | Per-source access class, source terms/license evidence, last checked/as-of date, privacy exclusions and reuse decision | **Completed — limitations documented**; source-by-source access/rights status and privacy exclusions recorded; no blanket reuse license established |
| S03-C08 Consolidated official provider-source register and gap analysis | 10% | Deduplicated source register with evidence, jurisdiction/sector coverage, limitations and unresolved gaps | **Completed — limitations documented**; 48 source records and consolidated jurisdiction/sector gap register delivered; remaining overlaps and completeness limits documented |
| S03-C09 Owner review and step acceptance | 5% | Owner-reviewed official source register, gaps and limitations; explicit acceptance record | **Accepted — owner approval recorded 2026-11-12** |

**Progress rule:** M1-S03 progress is evidence-based. C01–C08 meet their research/documentation criteria with limitations documented; C09 was explicitly accepted by the owner on 2026-11-12. M1-S03 is **Accepted — 100% weighted task completion** as a research baseline only. Do not count source pages or PRs as progress units. All sources remain RESEARCH ONLY unless a specific reuse permission is recorded. No source collection, ingestion or implementation is implied.

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


## M1-S03 TVET and QAB source verification — 2026-11-12

The TVET/QAB review adds GOV-31 to GOV-35 for NAVTTC, Punjab TEVTA/PSDA/TTB, Sindh STEVTA, KPTEVTA and B-TEVTA/BSIS. It records separate training-provider, QAB, regulator, assessment and certification relationships, plus B-TEVTA six-versus-16 and BSIS 413-versus-112 displayed-count discrepancies. Punjab TTB/TEVTA pages also list Deeni Madaris vocational training relationships; the owner-approved default-hidden Madaris rule remains unchanged, while separate vocational-provider visibility is an M2 design question. Full note: `../03-research/M1_S03_TVET_QAB_SOURCE_REVIEW_2026-11-12.md`.


## M1-S03 federal statistics and FBISE review — 2026-11-12

The federal-source review adds FBISE's affiliated-institution directory (3,315 displayed rows) and PIE's Pakistan Education Statistics 2024 methodology. The 2024 report states that private-college data are not maintained by most provincial/regional departments except Punjab and KP. The historical 2021–22 report says Deeni Madaris statistics came from Wafaqs and some non-reporting Wafaqs had repeated data. These are source-lineage limitations, not current provider counts. S03-C01 remains in progress. Full note: `../03-research/M1_S03_FEDERAL_DATA_FBISE_SOURCE_REVIEW_2026-11-12.md`.


## M1-S03 federal data and FBISE source review

- [M1-S03 Federal Data and FBISE Source Review](../03-research/M1_S03_FEDERAL_DATA_FBISE_SOURCE_REVIEW_2026-11-12.md) — PIE/NEMIS mandate, private-college data gaps, historical Wafaq reporting and FBISE affiliated-institution register; **Delivered — review pending; M1-S03 in progress.**
- [M1-S03 Official Government and Regulator Provider Source Register](../03-research/M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md) — updated with GOV-36 and GOV-37; **Updated — review pending.**


## M1-S03 FDE and FGEI source review — 2026-11-12

FDE's current Education Transformation Portal displays 432 ICT institutions, while its admissions portal and GIS-based EMIS have separate session-specific and operational data scopes. FGEI C/G is a separate directorate under IGT&E, not FDE; indexed official pages report 311 schools and 49 colleges (35 degree, 12 intermediate, two postgraduate), but direct record pages were access-limited. Do not combine FDE, FGEI and FBISE counts. Full note: `../03-research/M1_S03_FDE_FGEI_SOURCE_REVIEW_2026-11-12.md`.


## M1-S03 jurisdictional school authority/source matrix — 2026-11-12

The jurisdictional source matrix now consolidates public/private school authorities and EMIS/register routes for Punjab, Sindh, KP, Balochistan, ICT, AJK and GB. It records visible fields, data scope, access class, freshness, rights and explicit gaps. Key limitations include Punjab PMIU "free/open" wording without a verified license and PEPRIS owner-CNIC/mobile search; Sindh's public school checker versus separate private DIRPIS; role-based KP public iEMIS; Balochistan's 15,368/14,709 denominator discrepancy and separate private/BEF/ALP layers; ICT's FDE aggregate and PEIRA login route; AJK's 6,019 aggregate and sign-in-gated private list; and GB's office rows/zero summary and missing private register. Full matrix: `../03-research/M1_S03_JURISDICTIONAL_SCHOOL_SOURCE_MATRIX_2026-11-12.md`.


## M1-S03 additional accreditation-council review — 2026-11-12

The professional-regulator register is expanded with HEC's accreditation-council map, NBEAC, NCH, PCATP, AHPC and NAEAC. S03-C03 remains in progress pending final audit. Critical distinctions: AHPC's 16-Nov-2025 list is an applicant list, not an approval register; NBEAC status/session is programme/department-specific; NCH's recognized-college page lacks clear freshness and includes personal contacts; PCATP and NAEAC current full programme registers were not verified. Full review: `../03-research/M1_S03_ADDITIONAL_ACCREDITATION_COUNCIL_REVIEW_2026-11-12.md`.


## M1-S03 task acceptance audit — 2026-11-12

The task-by-task audit is recorded in `../03-research/M1_S03_TASK_ACCEPTANCE_EVIDENCE_AUDIT_2026-11-12.md`. S03-C01 through S03-C08 are **Completed — limitations documented** based on their source-mapping, authority, status-semantics, access/rights/privacy and consolidated-gap acceptance criteria. The owner accepted S03-C09 on 2026-11-12. M1-S03 is **Accepted — 100% weighted task completion** as a research baseline only. This does not mean a complete national census or source reuse permission.


## M1-S03 owner acceptance and closeout — 2026-11-12

The owner explicitly approved the consolidated official provider-source register, jurisdictional school-source matrix, task acceptance audit and documented limitations. S03-C09 (5%) is accepted; C01–C08 remain completed with limitations documented. M1-S03 is **Accepted — 100% weighted task completion** as a documentation/research baseline. This acceptance is not a complete national institution census, does not grant additional data-reuse rights and does not authorize source ingestion, scraping, implementation, production access, M1-S04 or M2. The Deeni Madaris requirement V2-DEC-006 remains unchanged: included in underlying provider scope, public visibility default OFF, with authorized configurable `Show Deeni Madaris` control.


## PR #69 closeout delivery evidence — 2026-11-12

PR [#69](https://github.com/mattari20/listing-v2/pull/69) merged as `4c6d076fef9d09a2900ca8e9e265ea6176ed5d6c`; exact head `c6120094139e2f2a7296fd4e59649928c0ddc161` passed required Project documentation validation (run [#43163951606](https://github.com/mattari20/listing-v2/actions/runs/43163951606)). M1-S03 is accepted and closed at 100% weighted task completion as a research baseline only.


## PR #77 merge and exact-head validation evidence — 2026-11-12

PR [#77](https://github.com/mattari20/listing-v2/pull/77) merged into `main` as `71e71ce74a57b854724027a1b106befe826b14fa`. The final PR head `deef364831cf4f0d902128ce9933897b17f9649c` passed the required **Project documentation validation** check (run [#43171586968](https://github.com/mattari20/listing-v2/actions/runs/43171586968)); the job completed successfully. The merge delivered the S05 owner-acceptance record and S06/S07 research packages, plus reconciled project-control documents. S06 and S07 remain owner-acceptance pending at 90% weighted completion each. This delivery does not authorize source collection, code/data import, reuse, ingestion, connector activation or implementation.


## PR #79 merge and exact-head validation evidence — 2026-11-12

PR [#79](https://github.com/mattari20/listing-v2/pull/79) merged into `main` as `59ab010830182a169fd609172618002ee8327fd3`. The exact PR head `4fed8a8d9f49c361539042f1f109102b9d6f4df2` passed the required **Project documentation validation** check (run [#43174230801](https://github.com/actions/runs/43174230801)); the validation job completed successfully. The merge delivered S08/S09 research, aligned product/data requirements and project controls, and recorded S06/S07 owner acceptance. S08 and S09 remain at 95% weighted completion each, with owner acceptance pending. No implementation or source access is authorized.


## M1-S08/S09 owner acceptance — 2026-11-12

The owner explicitly accepted the S08 AI data-agent workflow research and S09 comparison/reviews/trust research. Formal record: `../03-research/M1_S08_S09_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. S08-T08 and S09-T09 are accepted; both steps are **Accepted and Closed at 100% weighted task completion** as M1 research/documentation baselines. Open S09 policy decisions, source rights, technical choices and legal-review requirements remain carried forward; acceptance does not resolve them or authorize implementation, source access or ingestion.

## M1-S10 task breakdown (weights total 100%)

| Task | Weight | Acceptance evidence | Status |
|---|---:|---|---|
| S10-T01 Verify accepted status and evidence of S01–S09 | 15% | Step register and owner acceptance records reconciled | Completed |
| S10-T02 Cross-audit product requirements against research | 15% | Student, taxonomy, provider, programme, AI and trust requirements reconciled | Completed |
| S10-T03 Build cross-step traceability | 15% | Requirement/decision families mapped to evidence steps and M2 obligations | Completed |
| S10-T04 Consolidate source, coverage and rights gaps | 10% | Coverage, source rights and reuse limitations consolidated | Completed |
| S10-T05 Consolidate AI, data quality and provenance controls | 10% | S08 controls and source-conflict rules consolidated | Completed |
| S10-T06 Consolidate comparison, review and trust decisions | 10% | S09 policy decisions and safeguards consolidated | Completed |
| S10-T07 Reconcile owner decisions and hard constraints | 5% | Deeni Madaris default-OFF, deferred primary research, post-launch reviews and approval gates preserved | Completed |
| S10-T08 Define M2 entry criteria and exclusions | 5% | M2 entry requirements and prohibited implied authorizations documented | Completed |
| S10-T09 Prepare M1 closeout and evidence links | 10% | Final synthesis, gap register and project-control updates delivered | Completed |
| S10-T10 Owner review and formal M1 acceptance | 5% | Explicit owner acceptance of final M1 synthesis | Pending owner acceptance |
| **Total** | **100%** | | **95%** |

**M1-S10 weighted synthesis/documentation completion:** 95%; T01–T09 complete and T10 awaits explicit owner acceptance. M1 is not formally closed until S10 acceptance is recorded.

## M1-S10 closeout review — 2026-11-12

The final synthesis, cross-step traceability, G01–G20 gap/decision register, M2 entry requirements and exclusions are delivered in `../03-research/M1_S10_FINAL_SYNTHESIS_CLOSEOUT_REVIEW_2026-11-12.md`. S01–S09 are owner-accepted. S10 is ready for owner acceptance; M2 remains gated until this final M1 acceptance and separate M2 authorization.


## PR #81 delivery and exact-head validation evidence — 2026-11-12

PR [#81](https://github.com/mattari20/listing-v2/pull/81) delivered the S08/S09 owner-acceptance record and M1-S10 final synthesis package. Exact PR head `5d421241b2e643fb8291ff9f183aaa3205005a89` passed required **Project documentation validation** (run [#43175231085](https://github.com/mattari20/listing-v2/actions/runs/43175231085)); the `Validate project control documents` job and all steps completed successfully. PR #81 was squash-merged as `8ab22c7b2ca759db741660fbafd6a0c36edcce6d`.

S08 and S09 are accepted and closed at 100% weighted task completion each. S10 is delivered at 95%; its final 5% owner-acceptance task remains pending. M1 is therefore **Ready for final owner acceptance, not yet formally closed**. No M2 work or implementation is authorized by this merge.
