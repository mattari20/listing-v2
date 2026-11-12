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
- M0 closeout next step was M1-S01; current authorized work is M1-S02 official institution taxonomy and source-coverage research.

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
| S02-C01 Taxonomy and entity distinctions | 15% | Owner-reviewed categories and provider/campus/programme/regulator/affiliation distinctions | In progress — expanded provisional taxonomy and inclusion/exclusion boundary documented; explicit owner approval pending |
| S02-C02 Higher-education and campus sources | 10% | Current HEC institution, campus and affiliated-college scope verified with limitations | In progress — HEC institution/campus/affiliation/adverse-status routes reviewed; record-level freshness, study-centre scope and rights remain |
| S02-C03 Professional council sources | 15% | Current PMDC, PNMC, PCP and other relevant council status semantics documented | In progress — HEC council map and PM&DC, PNMC, PCP, PEC, NCEAC, NACTE, NBEAC, NTC, NCH, PBC and PVMC evidence added; PCATP, NCT, NAEAC and AHPC remain source-family leads; current scope and source rights remain |
| S02-C04 School-source jurisdiction coverage | 15% | Official source register across provinces/territories, public/private scope and geography gaps | In progress — Punjab public/private, KP private, Sindh ASC 2024–25, Balochistan EMIS, ICT, AJK and GB routes mapped; complete district/public-private coverage and rights remain |
| S02-C05 TVET and awarding relationships | 10% | NAVTTC, provincial TEVTAs, boards, assessment and awarding-body map | In progress — NAVTTC production registration/QAB/accreditation distinctions and provincial directory leads mapped; current provider/trade coverage, freshness and rights remain |
| S02-C06 Non-formal and special education | 10% | Official provider-source inventory and explicit coverage gaps | In progress — BECS/NFEMIS, Balochistan NFE and Punjab/Sindh special-education sources mapped; remaining jurisdictions, status and rights remain |
| S02-C07 Source rights and access | 10% | Terms, licenses, permission, access method, update cadence and privacy assessment for each source | In progress — expanded source-by-source access/status/privacy/freshness review recorded; no reuse license or written permission established; applicable terms and owner/legal review remain |
| S02-C08 National coverage synthesis | 10% | Reviewed coverage matrix, unresolved gaps and source-quality assessment | In progress — synthesis updated with expanded professional-council and jurisdiction evidence; final reconciliation after C02–C07 remains |
| S02-C09 Owner review and step acceptance | 5% | Owner-reviewed taxonomy and coverage acceptance record; no ingestion implied | Not started — requires explicit owner review and approval; no source ingestion implied |

**Progress rule:** The source-discovery matrix is delivered, but no S02 task is marked complete until its specific acceptance evidence is verified. Do not convert document delivery into a completion percentage.

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