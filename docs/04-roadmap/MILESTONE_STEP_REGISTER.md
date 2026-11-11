# Milestone and Step Register

**Status key:** Not started · In progress · Blocked · Complete · Accepted  
**Progress:** Planning estimate only until actual tasks and weights are baselined.

## Progress calculation
Each step is decomposed into measurable tasks with weights totaling 100%. Task completion is 0% until its evidence-based acceptance criteria pass; partial percentages may be used only when the task explicitly supports measurable sub-criteria.

`Step progress = sum(task weight × task completion)`

Each milestone assigns weights to its steps, totaling 100%.

`Milestone progress = sum(step weight × step progress)`

Do not count PRs as progress units. Progress is not acceptance: mandatory gates must pass even at 100%.

## M0 — Repository, documentation and governance
**Milestone outcome:** A verified, durable project control system exists before application coding.

| Step | Scope | Target / acceptance evidence | Dependencies | Status |
|---|---|---|---|---|
| M0-S01 | Bootstrap repository and founding decisions | Repo identity, README, constitution and decision records | None | In progress |
| M0-S02 | Preserve and classify legacy knowledge | Source inventory with paths/SHAs; approved requirements adapted with provenance; historical reports labelled | S01 | Not started |
| M0-S03 | Establish project controller and planning documents | Controller, roadmap, step register, traceability, progress and next-step rules | S01 | In progress |
| M0-S04 | Establish engineering and AI governance | Engineering standards, AI protocol, definition of done, authorization boundaries | S01 | In progress |
| M0-S05 | Configure repository workflow | PR templates, issue templates, ownership, branch rules, required checks, auto-merge settings | S03-S04 | Not started |
| M0-S06 | Verify delivery workflow | Test PR demonstrates required checks, merge policy, evidence update and next-step selection | S05 | Not started |
| M0-S07 | M0 acceptance and closeout | All mandatory M0 evidence reviewed; controller points to M1-S01 | S01-S06 | Not started |

Initial M0 step weights (subject to baseline review): S01 10%, S02 15%, S03 20%, S04 15%, S05 20%, S06 10%, S07 10%.

## M1 — Student requirements, provider and reuse research
| Step | Scope | Target / acceptance evidence |
|---|---|---|
| M1-S01 | Student/user research and journey | Personas, journey, use cases and acceptance criteria |
| M1-S02 | Institution taxonomy and national coverage | Level/type/sector/geography matrix and inclusion rules |
| M1-S03 | Official government/regulator provider research | Source register with access, rights and freshness |
| M1-S04 | Private provider and institution-source research | Provincial/private source inventory and gaps |
| M1-S05 | Programme/admissions information model research | Programme, campus, fees, admission and scholarship fields |
| M1-S06 | GitHub software and dataset discovery | Candidate inventory across all research categories |
| M1-S07 | License, data-rights and security assessment | Per-candidate evidence and reuse decision |
| M1-S08 | AI data-agent workflow and scheduling requirements | Source-specific lifecycle and human review requirements |
| M1-S09 | Comparison, review and trust research | Rating rubric, moderation, privacy and abuse cases |
| M1-S10 | M1 synthesis and acceptance | Research report, gap register and approved inputs to M2 |

## M2–M12 step planning
Before each milestone starts, create detailed numbered steps, task weights, dependencies, acceptance criteria, PR/test evidence and target dates or duration estimates where supportable. Do not invent calendar commitments without capacity and dependency estimates.

## Step closeout fields
Step ID; scope; task list and weights; status; branch/PR; head SHA; merged SHA; required checks and exact results; evidence links; defects; progress; blockers; next step; update date.
