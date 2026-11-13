# M3-01 — Implementation Planning and Authorization Work Plan

**Status:** Documentation/planning in progress — no implementation authorized  
**Dependency:** M3-00 accepted/closed for planning deliverables on 2026-11-12  
**M3 weight:** 7%  
**Owner:** Product Owner (final decisions); ChatGPT assists with documentation and planning  
**Implementation authorization:** NOT ISSUED

## 1. Objective

Convert accepted M2 architecture and M3-00 controls into a safe, reviewable, narrowly scoped first implementation plan. The objective is a **decision-ready authorization request**, not to write or execute application code. M0/M1/M2 are closed; do not reopen or import anything from legacy Listing V1.

## 2. Weighted planning tasks (total 100%)

| ID | Weight | Deliverable | Acceptance evidence | Current status |
|---|---:|---|---|---|
| P01 | 10% | Baseline, dependency and blocker reconciliation | M2 requirements/architecture and M3-00 decisions mapped, no-go list current | Delivered for owner review — detailed evidence pack |
| P02 | 15% | First implementation slice and explicit exclusions | Traceable, bounded scope and owner decision; no hidden scope | Candidate options documented; owner approval pending |
| P03 | 15% | Human roles, capacity and security/review accountability | Named qualified humans or explicit blocker; AI not substituted for staff | Blocked pending owner/human input |
| P04 | 15% | Stack, hosting and cost decision evidence | Owner-approved selections or no-go decision; no-spend enforced | Blocked pending evidence/decisions |
| P05 | 15% | Legal/privacy/source-rights/safeguarding/security preconditions | Scope-specific qualified reviews or excluded work; deny-by-default | Blocked pending reviewers/evidence |
| P06 | 15% | Environment, tests, CI, release and rollback plan | Synthetic-only test boundaries, acceptance tests, severity gates, secrets, stop/recovery plan | Synthetic-only framework delivered for review; environment not selected/activated |
| P07 | 10% | Narrow implementation authorization request | Exact branch, package, activities, exclusions, spend, named humans, tests, stop/expiry | Not started |
| P08 | 5% | Final owner review and M3-01 decision record | Explicit owner decision; authorization separately issued or refused | Not started |

No task receives completion credit from a PR alone. An unresolved critical blocker must remain visible even if its planning document is delivered. M3-01 may be fully documented yet **blocked** from implementation.

## 3. Proposed first slice for owner review — NOT APPROVED\n\nDetailed options, boundaries, traceability and acceptance questions are in [M3-01 Detailed Planning Evidence Pack](M3-01_DETAILED_PLANNING_EVIDENCE_PACK.md).

**Candidate P0:** Independent V2 non-production repository and CI foundation using synthetic fixtures only, with no provider data, external APIs, connectors, models, source collection, production access, database migrations or deployment. This is a candidate for analysis, **not an authorized implementation package**. Even this candidate requires named accountability, approved stack/environment, review/testing boundaries and explicit implementation-start approval.

## 4. Required owner decisions before implementation authorization

1. Who will be accountable for implementation, maintenance, QA, independent security review and operations? Record real named humans or keep the work blocked.
2. What exact bounded work package and excluded activities does the owner approve?
3. What stack, hosting/environment and no-spend or numeric spend limits are approved, supported by evidence?
4. Which legal/privacy/security/safeguarding gates apply to the slice, and which qualified reviewers have cleared them?
5. What acceptance tests, rollback/stop criteria and expiry/review trigger apply?

Do not infer decisions from the instruction to finish M3. Owner reviews are demand-led; the 10–15 hours/week baseline is not engineering staffing.

## 5. Authorization form — intentionally unissued

| Field | Current value |
|---|---|
| Implementation work package | NOT APPROVED |
| Repository / branch / environment | V2 repository known; implementation branch and environment NOT APPROVED |
| Allowed actions | NONE |
| Exclusions | All implementation and external/production activity prohibited pending approval |
| Human implementer / reviewer / operations owner | NOT ASSIGNED |
| Qualified gate decisions | NOT CLEARED |
| Spend ceiling | NO NEW SPEND; no paid service authorized |
| Tests / acceptance | TO BE REVIEWED |
| Stop conditions and expiry | TO BE APPROVED |
| Explicit Product Owner implementation-start decision | **NOT ISSUED** |

## 6. Governing controls

See [M3-00 T07 Gates](M3-00_T07_LEGAL_PRIVACY_SOURCE_RIGHTS_SECURITY_GATES.md), [M3-00 T08 Authorization Pack](M3-00_T08_IMPLEMENTATION_SCOPE_TEST_RELEASE_AUTHORIZATION_PACK.md), [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md), and [M3-00 Final Owner Acceptance](M3-00_FINAL_OWNER_ACCEPTANCE_AND_CLOSURE_RECORD_2026-11-12.md). No application coding, technical spike, source/production access, DB migration, procurement, new spend, deployment, pilot or launch without separate explicit approval.


## 7. Latest planning evidence — 2026-11-12

The [M3-01 Detailed Planning Evidence Pack](M3-01_DETAILED_PLANNING_EVIDENCE_PACK.md) delivers P01 baseline/dependency reconciliation for owner review, documents P02 first-slice options without selecting or approving one, and drafts P06 synthetic-only testing/CI/release controls. P03–P05 remain blocked by unassigned human roles, unselected stack/hosting/budget and unperformed qualified legal/privacy/security/safeguarding reviews. P07/P08 remain not ready. No M3-01 task completion percentage is claimed until its acceptance evidence is reviewed. Implementation authorization remains NOT ISSUED.


## P03 owner decision reconciliation — 2026-11-12

PR #122 records the Product Owner's explicit solo-founder model and was squash-merged after the required exact-head validation passed. The Product Owner is the sole human builder and accountable owner for the initial bounded V2 build; ChatGPT assists with planning, documentation, architecture, code drafting, debugging, test design and review support. No additional human developer/team is a prerequisite for Candidate A. Future operational staffing, including at least two administrators, is deferred until after completion.

P03 is therefore **resolved for the Candidate A synthetic/offline foundation planning model**, not as proof of independent security certification or production-operational readiness. ChatGPT is not an independent accountable human reviewer or certifier. Candidate A must remain offline, synthetic-only and no-spend; any later scope involving personal/child data, real source data, external services, public release or production operations requires its own applicable qualified review and explicit owner gate. P04–P08 remain open. Implementation authorization remains NOT ISSUED.

## M3-01 AI-era architecture requirements — 2026-11-12

The AI-era readiness review was added in PR #124 and merged as `4dd6cd8807b40b11f6693ae1cd98b63ca1a362f5`. It introduces AI-ARCH-01–20 as proposed planning requirements. The work plan now treats them as P04 architecture/technology evaluation inputs and P05/P06 security/verification considerations. This is not a stack decision or implementation authorization. AI remains optional, provider-independent and disabled unless separately approved; RAG, vectors, agents, MCP, queues and external search are not baseline dependencies. P04–P08 remain open; implementation authorization NOT ISSUED.


## M3-01 P04 stack/hosting/cost decision evidence — 2026-11-12

The [P04 Stack, Hosting and Cost Decision Dossier](M3-01_P04_STACK_HOSTING_COST_DECISION_DOSSIER_2026-11-12.md) reconciles the existing M2-S04 options with AI-ARCH-01–20. It compares Laravel 13/PHP, Django/Python and NestJS/Node 26; refines Django lifecycle guidance toward a supported LTS line; evaluates PostgreSQL 18/PostGIS, optional pgvector and database-native search; and defines hosting, portability, restore and cost evidence requirements.

This dossier does not select a backend, database, hosting provider/region, model, vendor or budget. The owner's hands-on framework proficiency and provider/operational evidence remain required. No numerical cost is invented; no new spend is authorized. P04 remains open pending owner decision and evidence.


## P04 Product Owner preferred technology direction — 2026-11-13

The Product Owner confirmed a ChatGPT-assisted development model (mainly relying on ChatGPT for writing, understanding and debugging code) and agreed with the preferred planning direction recorded in [M3-01 P04 Product Owner Preferred Technology Direction](M3-01_P04_OWNER_PREFERRED_TECHNOLOGY_DIRECTION_2026-11-13.md): Django/Python, PostgreSQL, PostGIS, modular monolith, HTML-first server-rendered frontend and provider-neutral/AI-off architecture.

P04 is advanced but remains **Open** pending hosting/provider/region, PostgreSQL/PostGIS compatibility, backup/restore, data terms, operational support, dated cost evidence and final version decisions. This owner preference does not establish hands-on framework proficiency and does not authorize a technical spike or implementation. P05 and P06 retain their independent gates; P07/P08 are not ready. No M3-01 weighted completion percentage is claimed; M3 remains 5%; implementation authorization NOT ISSUED.


## P04 owner hosting constraint update — 2026-11-13

The Product Owner directed that initial V2 use only the existing Hostinger Premium Web Hosting resources, with no VPS, upgrade or new paid infrastructure. The earlier Django/PostgreSQL/PostGIS preferred direction is superseded for initial deployment. PHP/Laravel and the plan's MySQL/MariaDB service are only candidates pending exact runtime, Composer, extensions, routing, SSH/cron, database-engine and resource-headroom verification. Keep modular monolith and HTML-first delivery; defer PostGIS, dedicated search, external workers, paid maps/geocoding and AI providers. See [Existing Hostinger Premium Constraint](M3-01_P04_EXISTING_HOSTINGER_PREMIUM_CONSTRAINT_2026-11-13.md).

P04 remains open until compatibility, isolation, backup/restore and synthetic resource-headroom evidence is available. P05–P08 remain independently gated. This is planning only: no implementation, technical spike, package installation, environment activation, production/V1 access, database changes, deployment or spend is authorized.

## P04 owner confirmation and next planning action — 2026-11-13

The Product Owner confirmed that PHP execution/CLI, Composer, PHP-extension support, the hosted MySQL-compatible database service, SSH, cron and the current deployment/file-management workflow are already available and in use for V1 on the same Hostinger Premium environment. This is owner-supplied operational evidence; no V1 inspection or access was performed.

P04 is advanced from "account capability unknown" to "shared-host capabilities owner-confirmed." Exact versions/limits, Laravel-specific compatibility, isolated V2 routing/configuration, V2 resource headroom and V2 backup/restore remain unverified. The next planning action is to produce the conditional versioned stack recommendation, V2 isolation/deployment design and realistic solo-founder delivery schedule. No M3-01 weighted completion is claimed from this confirmation alone. Implementation authorization remains NOT ISSUED.
