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
| M0-S01 | Bootstrap V2 repository and founding decisions | Repo identity, README, V2 constitution and decision records | None | In progress |
| M0-S02 | Establish strict legacy non-interference audit | Explicit exclusion policy, metadata-only source inventory, no copied artifacts; audit scope limitations recorded | S01 | In progress |
| M0-S03 | Establish project controller and planning documents | Controller, roadmap, step register, traceability, progress and next-step rules | S01 | In progress |
| M0-S04 | Establish engineering and AI governance independently for V2 | Engineering standards, AI protocol, definition of done, authorization boundaries | S01 | In progress |
| M0-S05 | Configure V2 repository workflow | PR/issue templates, validation CI, owner settings, active main ruleset and required check | S03-S04 | Complete — PR #1 merged; public repo, auto-merge enabled, active `main` ruleset and required CI check verified 2026-11-11 |
| M0-S06 | Verify V2 delivery workflow | Separate test PR demonstrates latest-head checks, active ruleset/required-check enforcement, controlled merge, evidence update and next-step selection | S05 | Complete — PR #2 passed required check on exact head `9ad0d3b361d6641dca2e94c3c9a52ac2fb4d1597`, merged as `975cd672378e8d30982d44d54d12e195e9c57d5d`; automatic merge execution not independently demonstrated |
| M0-S07 | M0 acceptance and closeout | All mandatory M0 evidence reviewed; controller points to M1-S01 | S01-S06 | Not started |

Initial M0 step weights (planning baseline, to be reviewed): S01 10%, S02 15%, S03 20%, S04 15%, S05 20%, S06 10%, S07 10%.

## Documentation tracking requirement
Maintain `DOCUMENTATION_CATALOG.md` as the owner-facing inventory. Reconcile it on every documentation PR update and merge. Distinguish delivered, updated, accepted and planned content; do not equate merge with acceptance.

## M1 — Student requirements and independent research
| Step | Scope | Target / acceptance evidence |
|---|---|---|
| M1-S01 | Student/user research and journey | Personas, journey, use cases and measurable acceptance criteria based on V2 owner direction and new research |
| M1-S02 | Institution taxonomy and coverage requirements | Independently researched level/type/sector/geography matrix and inclusion rules |
| M1-S03 | Official government/regulator provider research | New source register with access, rights, coverage and freshness evidence |
| M1-S04 | Private provider and institution-source research | New provider inventory and documented gaps |
| M1-S05 | Programme/admissions information research | Student-required programme, campus, fees, admission and scholarship information |
| M1-S06 | Independent GitHub software and dataset discovery | Candidate inventory across crawler, data, search, geo, workflow and education-data categories |
| M1-S07 | License, data-rights and security assessment | Per-candidate evidence and independent reuse decision |
| M1-S08 | V2 AI data-agent workflow requirements | Source-specific collection, verification, scheduling and human-review requirements |
| M1-S09 | Comparison, review and trust research | Rating rubric, moderation, privacy and abuse cases |
| M1-S10 | M1 synthesis and acceptance | Research report, gap register and approved inputs to M2 |

## M2–M12 step planning
Before each milestone starts, create detailed numbered steps, task weights, dependencies, acceptance criteria, PR/test evidence and target dates or duration estimates where supportable. Do not invent calendar commitments without capacity and dependency estimates.

## Step closeout fields
Step ID; scope; task list and weights; status; branch/PR; head SHA; merged SHA; required checks and exact results; evidence links; defects; progress; blockers; next step; update date.

## Mandatory independence check
Every step must record that its inputs are V2 owner requirements, new research or approved V2 decisions. Any legacy-derived implementation, architecture, data, workflow or process pattern is prohibited and must be removed before the step can pass.
