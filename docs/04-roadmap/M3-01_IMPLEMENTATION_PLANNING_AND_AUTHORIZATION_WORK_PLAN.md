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
| P01 | 10% | Baseline, dependency and blocker reconciliation | M2 requirements/architecture and M3-00 decisions mapped, no-go list current | Not started |
| P02 | 15% | First implementation slice and explicit exclusions | Traceable, bounded scope and owner decision; no hidden scope | Not started |
| P03 | 15% | Human roles, capacity and security/review accountability | Named qualified humans or explicit blocker; AI not substituted for staff | Blocked pending owner/human input |
| P04 | 15% | Stack, hosting and cost decision evidence | Owner-approved selections or no-go decision; no-spend enforced | Blocked pending evidence/decisions |
| P05 | 15% | Legal/privacy/source-rights/safeguarding/security preconditions | Scope-specific qualified reviews or excluded work; deny-by-default | Blocked pending reviewers/evidence |
| P06 | 15% | Environment, tests, CI, release and rollback plan | Synthetic-only test boundaries, acceptance tests, severity gates, secrets, stop/recovery plan | Not started |
| P07 | 10% | Narrow implementation authorization request | Exact branch, package, activities, exclusions, spend, named humans, tests, stop/expiry | Not started |
| P08 | 5% | Final owner review and M3-01 decision record | Explicit owner decision; authorization separately issued or refused | Not started |

No task receives completion credit from a PR alone. An unresolved critical blocker must remain visible even if its planning document is delivered. M3-01 may be fully documented yet **blocked** from implementation.

## 3. Proposed first slice for owner review — NOT APPROVED

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
