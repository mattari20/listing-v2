# M3-00 — Mobilization and Decision Closure

**Status:** Started — documentation/planning only  
**Step completion:** 10% evidence-based (T01 complete; T02-T08 remain open). M3 overall weighted progress: 0.5%.  
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
| T02 Roles, skills and accountability | 15% | Role/capability matrix, decision owners and skills gaps | **In progress — owner approved the owner-led/ChatGPT-assisted delivery model; named human implementers, maintainers, independent reviewers and skill-gap assessment remain open** |
| T03 Capacity and availability | 10% | Capacity, cadence, review time and continuity assumptions | **In progress — owner confirmed 10–15 hours/week as a planning baseline, with flexibility according to project demand and priority; reviews/approvals are demand-led rather than limited to a fixed weekly meeting; other human delivery capacity and continuity assumptions remain open** |
| T04 Budget and cost ceiling | 15% | One-time/recurring cost categories, scenarios and explicit ceiling | Open — awaiting owner budget decision |
| T05 Technology stack decision pack | 15% | Evidence matrix, proof-of-fit criteria, options and owner decision record | Decision pack prepared; owner/team fit and explicit selection remain open |
| T06 Hosting and vendor decision pack | 10% | Hosting/region/cost/data-location/latency/recovery comparison | Decision framework prepared; current quotes, constraints and selection remain open |
| T07 Legal, privacy, source-rights and security gates | 15% | Gate register, review owners, source-specific approval protocol | Open — qualified review owners and applicable evidence pending; no source/vendor activation |
| T08 Scope, test/release and authorization pack | 10% | M3-01 backlog outline, acceptance gates, test/release plan and authorization request | Partially outlined in master plan; detailed M3-01 pack remains open |

Task weights total 100%. No task is marked complete solely because a template or checklist has been drafted.

## 4. Required owner/team inputs

The following are intentionally unanswered until confirmed. No assumptions about staffing, budget or vendor preferences are made.

| Input | Needed to close | Why it matters |
|---|---|---|
| Delivery model | **Owner decision recorded:** user is Product Owner/final decision-maker; ChatGPT assists step by step with planning, documentation, architecture, code drafting only after authorization, test design and reporting; qualified specialists may be engaged for legal/privacy/security review when needed. Named human implementers, maintainers and independent reviewers still need confirmation. | Separates decision accountability, AI assistance and specialist assurance without assuming a staffed engineering/operations team |
| Availability | **Owner confirmed 10–15 hours/week as a planning baseline, with flexibility according to project demand and priority. Reviews/approvals are demand-led rather than limited to a fixed weekly meeting (2026-11-12).** Other human team capacity and continuity assumptions remain pending. | Supports realistic sequencing without treating owner time as engineering capacity or assuming an implementation team |
| Budget ceiling | Maximum acceptable one-time setup and recurring monthly/annual spend; whether paid services are permitted at all | Prevents unapproved commitments and unsuitable architecture choices |
| Technology constraints | Existing team expertise, preferred/unsupported languages or frameworks, maintainability constraints | Informs evidence-based stack selection |
| Hosting constraints | Preferred hosting geography, data-location requirements and operational ownership | Informs legal, latency, cost and recovery evaluation |
| Decision cadence | Expected time for owner reviews and approvals | Prevents silent assumptions about acceptance timing |

These inputs can be supplied gradually. Until then, affected decisions remain **OPEN / BLOCKED ON OWNER INPUT**.

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
3. Confirm one-time and recurring budget ceilings and whether paid evaluation services are allowed.
4. Review the stack and hosting options in the [Owner Decision Pack](M3-00_OWNER_DECISION_PACK.md); then complete proof-of-fit planning without procuring services.
5. Identify qualified legal/privacy/security review responsibilities and keep all sources research-only.
6. Complete M3-00 readiness evidence and request owner acceptance before M3-01.

**Current decision (2026-11-12):** M3-00 planning remains at 10% weighted completion. T01 is complete; T02 is in progress following the owner's delivery-model decision; T03 is in progress following the owner's 10–15 hours/week planning baseline and demand-led availability/review confirmation; T04-T08 remain open. M3-01 and all implementation steps remain gated.

## Supporting owner decision pack

The [M3-00 Owner Decision Pack](M3-00_OWNER_DECISION_PACK.md) contains the role/skills matrix, capacity and budget inputs, stack and hosting evaluation criteria, legal/privacy/source/security gates and a decision record. Blank values remain unknown; the pack authorizes no spend or service activation.

## Evidence-based progress

- T01: 100% complete — accepted M0-M2 baseline and reconciled project controls delivered in PR #100.
- T02: In progress — delivery-model decision accepted; named human role coverage, skills and accountability evidence remain outstanding. No task percentage is claimed until its full measurable acceptance output is evidenced.
- T03: In progress — owner availability recorded at 10–15 hours/week with demand-led flexibility and review cadence; other human team capacity and continuity evidence remain outstanding. No partial task percentage is claimed.
- T04-T08: 0% complete — required owner/team inputs, explicit decisions or supporting evidence remain outstanding.
- M3-00: 10% (10% task weight × 100% completion).
- M3 overall: 0.5% (M3-00 milestone weight 5% × M3-00 completion 10%).
- M3-00 step acceptance remains pending owner review; task progress is not milestone acceptance.
