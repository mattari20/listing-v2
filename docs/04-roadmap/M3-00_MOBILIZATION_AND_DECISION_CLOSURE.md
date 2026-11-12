# M3-00 — Mobilization and Decision Closure

**Status:** In progress — documentation/planning only  
**Step completion:** 75% evidence-based (T01-T06 complete, with T02-T06 closed through explicit owner-approved deferrals; T07-T08 open). M3 overall weighted progress: 3.75%.  
**Dependency:** M2 accepted and closed at 100%  
**Governing plan:** [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md)  
**Implementation authorization:** Not granted

## 1. Objective

Establish the people, capacity, budget, technology, hosting, legal/privacy/security and delivery-governance conditions needed to plan Listing V2 implementation responsibly. This step must expose unknowns and blockers rather than fill them with assumptions.

## 2. Verified starting baseline

- M0 is accepted and closed.
- M1-S01 through M1-S10 are accepted and closed; G01-G20 remain binding.
- M2 is formally accepted and closed at 100% under the M2 final owner acceptance record dated 2026-11-12.
- M2 left stack, hosting, model/vendor, source rights, legal/privacy, accessibility, review policy and operational targets unresolved where evidence or owner decisions were outstanding.
- V2-DEC-006 remains binding.
- Application implementation, source access/ingestion, procurement, production access and deployment remain unauthorized.
- Listing V2 remains independent of legacy Listing V1.

## 3. M3-00 task register

| Task | Weight | Required output | Current status |
|---|---:|---|---|
| T01 Baseline and handover reconciliation | 10% | M0-M2 accepted baseline, open-decision inventory and binding-control checklist | **Complete — PR #100 merged; controller, roadmap, step register and status reconciled** |
| T02 Roles, skills and accountability | 15% | Role/capability matrix, decision owners and skills gaps | **Complete for M3-00 planning — owner-led/ChatGPT-assisted model retained; named human implementers, maintainers, independent reviewers and skill coverage explicitly deferred as gaps (M3-DEC-003). Must be resolved before relevant M3-01 authorization.** |
| T03 Capacity and availability | 10% | Capacity, cadence, review time and continuity assumptions | **Complete for M3-00 planning — owner's 10–15 hours/week baseline and demand-led approvals recorded; other human delivery capacity and continuity explicitly deferred (M3-DEC-004). No engineering capacity is inferred.** |
| T04 Budget and cost ceiling | 15% | One-time/recurring cost categories, scenarios and explicit ceiling | **Complete for M3-00 planning — no-new-spend posture explicitly accepted; numeric ceilings, quotes, tax/FX assumptions and paid-service policy deferred (M3-DEC-005). No spend is authorized.** |
| T05 Technology stack decision pack | 15% | Evidence matrix, proof-of-fit criteria, options and owner decision record | **Complete for M3-00 planning — candidate comparison framework delivered; stack selection explicitly deferred pending human skill, support/security, hosting and cost evidence (M3-DEC-006). No spike or installation authorized.** |
| T06 Hosting and vendor decision pack | 10% | Hosting/region/cost/data-location/latency/recovery comparison | **Complete for M3-00 planning — hosting/operations framework and candidate research delivered; provider/region/plan selection explicitly deferred pending service, data, cost, latency, recovery and operations evidence (M3-DEC-007). No account, trial or spend authorized.** |
| T07 Legal, privacy, source-rights and security gates | 15% | Gate register, review owners, source-specific approval protocol | **Open — T07 gate register delivered; qualified review owners, applicable legal/privacy/security evidence and source-specific decisions remain pending; no source/vendor/service activation** |
| T08 Scope, test/release and authorization pack | 10% | M3-01 backlog outline, acceptance gates, test/release plan and authorization request | **Open — T08 readiness framework delivered; detailed scope, human roles, upstream decisions, reviewer evidence and owner acceptance remain open; implementation authorization not issued** |

Task weights total 100%. No task is marked complete solely because a template or checklist has been drafted.

## 4. Required owner/team inputs

The following are intentionally unanswered until confirmed. No assumptions about staffing, budget or vendor preferences are made.

| Input | Needed to close | Why it matters |
|---|---|---|
| Delivery model | **Owner decision recorded:** user is Product Owner/final decision-maker; ChatGPT assists step by step with planning, documentation, architecture, code drafting only after authorization, test design and reporting; qualified specialists may be engaged for legal/privacy/security review when needed. Named human implementers, maintainers and independent reviewers still need confirmation. | Separates decision accountability, AI assistance and specialist assurance without assuming a staffed engineering/operations team |
| Availability | **Owner confirmed 10–15 hours/week as a planning baseline, with flexibility according to project demand and priority. Reviews/approvals are demand-led rather than limited to a fixed weekly meeting (2026-11-12).** Other human team capacity and continuity assumptions remain pending. | Supports realistic sequencing without treating owner time as engineering capacity or assuming an implementation team |
| Budget ceiling | **Budget framework prepared; no new spend is authorized.** Numeric one-time/recurring ceilings, annual/contingency assumptions and paid-service policy remain pending owner decision. | Prevents unapproved commitments; see [M3-00 Budget and Cost Scenarios](M3-00_BUDGET_AND_COST_SCENARIOS.md) |
| Technology constraints | Existing team expertise, preferred/unsupported languages or frameworks, maintainability constraints | Informs evidence-based stack selection |
| Hosting constraints | Preferred hosting geography, data-location requirements and operational ownership | Informs legal, latency, cost and recovery evaluation |
| Decision cadence | Expected time for owner reviews and approvals | Prevents silent assumptions about acceptance timing |

These inputs can be supplied gradually. The owner has now explicitly accepted the bounded T02–T06 deferrals recorded in the Owner Decision Pack. The underlying staffing, budget, stack and hosting questions remain unresolved and must be revisited before the relevant M3-01 implementation authorization.

## 5. Decision gates

### Stack
M2's conditional direction (modular monolith, HTML-first, PostgreSQL/PostGIS proof-of-fit, database-native search initially, replaceable map/tile/geocoder adapters) is a candidate baseline, not a final selection. Compare options against team skills, total cost, security, maintainability, migration/exit risk, Pakistan user performance and test evidence. Do not install or procure a paid service as part of this planning step.

### Hosting
Compare provider/region options using verified quotes, data location and transfer terms, Pakistan latency, backup/restore capability, security controls, support and total cost. No provider or region is selected.

### Legal, privacy and source rights
Obtain qualified review where needed. Public availability does not grant reuse rights. Each external source requires its own rights, terms, privacy, security and permitted-method assessment and explicit authorization. No source-owner outreach, permission request, scraping, bulk download, connector activation or ingestion is included here.

### AI and third-party services
No AI model, identity provider, map/tile/geocoder, search SaaS or other third-party service is activated. Evaluation must cover data terms, privacy, security, quality, cost caps, portability and exit strategy.

### Security, privacy and safeguarding
Carry forward least privilege, anonymous-first discovery, data minimization, minor safeguarding, prompt-injection defenses, human publication gates, auditability and incident/recovery design. No claim of legal compliance or completed security certification is made.

## 6. M3-00 exit criteria

M3-00 can be submitted for owner review only when:
1. M0-M2 baseline and all binding controls are reconciled.
2. Team roles, skills, accountability and capacity are confirmed or explicit gaps/dependencies are accepted.
3. Budget scenarios and a spend ceiling are documented, or the owner explicitly records that no spend is authorized and which choices remain blocked.
4. Stack and hosting options have evidence-based comparisons and explicit owner decisions, or are explicitly deferred with a reason and a safe next proof-of-fit.
5. Legal/privacy/minor/source-rights/security gates have named review responsibilities and clear no-go conditions.
6. M3 scope, dependencies, step acceptance criteria, testing, release and rollback governance are documented.
7. All unresolved decisions are visible in the decision register.
8. The owner explicitly accepts the M3-00 readiness baseline.

M3-00 acceptance does **not** authorize application implementation. M3-01 must prepare a separate implementation-start authorization naming the exact permitted scope.

## 7. Explicit non-authorizations

No application code; no physical database schema or migrations; no live source retrieval, scraping, bulk download or ingestion; no source-owner outreach or permission request; no connector/agent/model activation; no procurement or new spend; no production credentials or production access; no production data operation; no deployment, pilot with real users, launch or URL cutover.

## 8. Current next actions

1. Convert the accepted owner-led/ChatGPT-assisted delivery model into a named human role/capability matrix; confirm who will own implementation, maintenance, QA and operations, and identify any specialist review gaps.
2. Complete T03 by confirming continuity assumptions and any other human delivery capacity; owner availability and demand-led review/approval cadence are recorded.
3. Complete T04 by recording the owner's numeric one-time/recurring ceilings or an explicit deferral; no paid evaluation or spend is authorized meanwhile.
4. Complete T05/T06 evidence-based stack and hosting comparisons using the [Technology Stack Decision Framework](M3-00_TECHNOLOGY_STACK_DECISION_FRAMEWORK.md) and Owner Decision Pack; any proof-of-fit requires separate synthetic-data-only authorization.
5. Complete T06 hosting comparison using the [Hosting and Operations Decision Framework](M3-00_HOSTING_AND_OPERATIONS_DECISION_FRAMEWORK.md); verify exact service/region support, current terms, costs and Pakistan latency without account creation or procurement.
6. Identify qualified legal/privacy/security review responsibilities and keep all sources research-only.
6. Complete M3-00 readiness evidence and request owner acceptance before M3-01.

**Current decision (2026-11-12):** The owner explicitly approved conservative deferrals M3-DEC-003 through M3-DEC-007. T01–T06 are complete for M3-00 planning/decision-record purposes (75% weighted completion); T07 and T08 remain open pending qualified review responsibilities/evidence and detailed scope/readiness acceptance. M3-01 and all implementation steps remain gated.

## Supporting owner decision pack

The [M3-00 Owner Decision Pack](M3-00_OWNER_DECISION_PACK.md) contains the role/skills matrix, capacity and budget inputs, stack and hosting evaluation criteria, legal/privacy/source/security gates and a decision record. Blank values remain unknown; the pack authorizes no spend or service activation.

## Evidence-based progress

- T01: 100% complete — accepted M0-M2 baseline and reconciled project controls delivered in PR #100.
- T02: 100% of its M3-00 planning output — delivery model and unresolved human role/skills gaps explicitly recorded and accepted as a pre-implementation dependency (15%).
- T03: 100% of its M3-00 planning output — owner capacity/cadence recorded; other human capacity and continuity explicitly deferred (10%).
- T04: 100% of its M3-00 planning output — no-new-spend posture and blocked budget choices explicitly accepted (15%).
- T05: 100% of its M3-00 planning output — technology selection explicitly deferred with evidence-based reopening conditions (15%).
- T06: 100% of its M3-00 planning output — hosting/provider selection explicitly deferred with evidence-based reopening conditions (10%).
- T07-T08: Open; no weighted completion claimed until their acceptance outputs and required evidence are satisfied.
- M3-00: 75% (T01 10% + T02 15% + T03 10% + T04 15% + T05 15% + T06 10%).
- M3 overall: 3.75% (M3-00 milestone weight 5% × M3-00 completion 75%).
- M3-00 step acceptance remains pending owner review; task progress is not milestone acceptance.


The [M3-00 Budget and Cost Scenarios](M3-00_BUDGET_AND_COST_SCENARIOS.md) document provides T04's cost categories, scenario framework, calculation rules and no-spend controls. It is not a budget approval or procurement authorization.


The [M3-00 Technology Stack Decision Framework](M3-00_TECHNOLOGY_STACK_DECISION_FRAMEWORK.md) is the T05 working artifact. It retains the M2 candidate baseline without selecting a stack or authorizing installation, a technical spike or implementation.


The [M3-00 Hosting and Operations Decision Framework](M3-00_HOSTING_AND_OPERATIONS_DECISION_FRAMEWORK.md) is the T06 working artifact. It is research/documentation only and does not select a vendor or authorize an account, trial, procurement or deployment.


## Owner-approved deferral update — 2026-11-12

The Product Owner approved M3-DEC-003 through M3-DEC-007 as explicit, bounded deferrals for T02–T06. These tasks are complete for M3-00 planning purposes only; named human staffing, other human capacity, numeric budget ceilings, technology selection and hosting selection remain unresolved dependencies before relevant M3-01 authorization. T07 and T08 remain open. M3-00 is 75%; M3 overall is 3.75%. No implementation, technical spike, source/production access, procurement, spend, deployment, pilot or launch is authorized.


## Current audit update — 2026-11-12 (after PR #110)

GitHub verification confirms PRs #102–#110 are all closed and merged and each required Project documentation validation passed on its exact head. PR #110 reconciliation merged as `a328a8272b086cac6270dc625d53ea6c3bbc1fa7`. T01 remains Complete; T02-T06 remain In progress; T07-T08 remain Open. T04, T05 and T06 frameworks are delivered, but their owner decisions/evidence are not complete. M3-00 remains 10% and M3 overall 0.5%; no partial task percentages are claimed. No application implementation, spend, procurement, source/production access or deployment is authorized.


## T07 documentation delivery — 2026-11-12

The [T07 Legal, Privacy, Source-Rights and Security Gate Register](M3-00_T07_LEGAL_PRIVACY_SOURCE_RIGHTS_SECURITY_GATES.md) has been drafted and indexed. It defines twelve deny-by-default gates, source-specific approval records, required human review roles, no-go conditions, reassessment triggers and T07 completion criteria. It is a delivered framework, not a completed legal/security review. Qualified reviewer assignments and evidence remain open; T07 remains Open and no source, model, connector, vendor or service is approved.


## T08 documentation delivery — 2026-11-12

The [T08 Implementation Scope, Test/Release Governance and M3-01 Authorization Pack](M3-00_T08_IMPLEMENTATION_SCOPE_TEST_RELEASE_AUTHORIZATION_PACK.md) has been drafted and indexed. It defines readiness inputs, a dependency-oriented planning backlog, work-item Definition of Ready, test/evidence contract, CI/review controls, release/rollback governance and a deliberately unissued authorization record. T08 remains Open; upstream T02–T07 decisions and qualified reviews remain pending. No implementation is authorized.
