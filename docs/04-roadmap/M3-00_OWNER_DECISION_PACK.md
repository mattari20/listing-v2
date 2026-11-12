# M3-00 Owner Decision Pack — Team, Budget, Stack and Hosting

**Status:** Prepared for owner input; no decisions are silently assumed  
**Related step:** [M3-00 Mobilization and Decision Closure](M3-00_MOBILIZATION_AND_DECISION_CLOSURE.md)  
**Governing plan:** [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md)

## 1. How to use this pack

This pack collects the owner decisions and facts needed to close M3-00. Blank fields mean **unknown / pending**, not zero, approval or rejection. An evaluation recommendation is not a procurement or implementation authorization. No spend is approved by this pack.

## 2. Delivery team and capability

### 2.1 Roles to assign

| Role | Responsibility | Required capability/evidence | Assigned person/team | Availability |
|---|---|---|---|---|
| Product owner | Scope, priority, policy and final acceptance | Product decisions and domain knowledge | Pending | Pending |
| Technical lead/architect | Architecture conformance, stack and technical decisions | Selected stack, security and system design experience | Pending | Pending |
| Backend engineer | Domain services, workflows, data integrity and APIs | Framework, relational DB, testing | Pending | Pending |
| Frontend engineer | Accessible HTML-first public experience | SSR, responsive UI, performance and accessibility | Pending | Pending |
| Data engineer/steward | Provenance, validation, source governance and adjudication | Data quality, lineage, controlled workflows | Pending | Pending |
| QA/test engineer | Test design, automation, regression and release evidence | CI, test strategy, risk-based QA | Pending | Pending |
| Security/privacy reviewer | Threat, privacy, minors and source review | Qualified security/privacy competence | Pending | Pending |
| Operations owner | Hosting, observability, backup, restore and incident response | Linux/cloud operations, recovery and monitoring | Pending | Pending |
| Legal adviser (as required) | Applicable law, privacy, source terms and contracts | Qualified jurisdiction-relevant advice | Pending | Pending |

One person may cover multiple roles only where capability and separation-of-duties risks are explicitly assessed. High-impact publication, access approval and release approval must retain appropriate independent controls.

### 2.2 Owner confirmation

- Delivery model: **Owner-led, ChatGPT-assisted, with qualified external specialists engaged only where a review requires expertise not otherwise available — accepted by owner on 2026-11-12.**
- Product ownership and final decisions: **The user remains Product Owner and final decision-maker.**
- Technical assistance: **ChatGPT will assist step by step with planning, architecture documentation, code drafting when separately authorized, test design, review support and progress reporting. ChatGPT is an assistant, not an independently accountable operator or a substitute for human production ownership.**
- External specialist coverage: **Qualified legal, privacy and security specialists may be identified/engaged when needed; no engagement, procurement or spend is authorized by this decision.**
- Named human implementers/maintainers and independent reviewers: **Pending confirmation.**
- Skills already available and gaps: **Pending assessment.**
- Owner's available project time: **10–15 hours per week as the current planning baseline, with flexibility to participate according to project demand and priority — confirmed by owner on 2026-11-12. This is owner decision/review and project participation time, not a claim of 10–15 engineering hours or a staffed development team.**
- Other human team capacity and named implementer/maintainer availability: **Pending confirmation.**
- Preferred review/approval cadence: **Demand-led, not restricted to a fixed weekly meeting. The owner is available to review and decide as project priorities and decision gates require, with reasonable notice and consolidated decision packs where practical — confirmed 2026-11-12.**

## 3. Budget and cost ceiling

No numeric cost ceiling or paid-service permission is currently approved. **No new project spend is authorized.** See [M3-00 Budget and Cost Scenarios](M3-00_BUDGET_AND_COST_SCENARIOS.md) for scenario definitions, cost categories, calculation rules and spend controls. A zero-spend authorization state is not a lifetime budget ceiling.

| Cost category | One-time estimate (PKR) | Recurring estimate (PKR/month) | Evidence/source | Status |
|---|---:|---:|---|---|
| Development labour/contracting | Pending | Pending | Team model and quotes | Open |
| Hosting/compute | Pending | Pending | Provider quote and workload assumptions | Open |
| Database/storage/backups | Pending | Pending | Provider quote and retention assumptions | Open |
| Email/SMS/identity | Pending | Pending | Vendor terms and expected volumes | Open |
| Maps/geocoding/tiles | Pending | Pending | Usage model, terms and cost limits | Open |
| AI/model/API usage | Pending | Pending | Evaluation, data terms and hard limits | Open |
| Search/monitoring/security tools | Pending | Pending | Product fit and vendor quote | Open |
| Legal/privacy/security review | Pending | Pending | Scope and qualified adviser quote | Open |
| Contingency/tax/FX | Pending | Pending | Explicit assumptions and date | Open |

### Owner decisions required
- Maximum one-time setup/development budget: **Pending owner decision; no new spend authorized**
- Maximum recurring monthly spend: **Pending owner decision; no new spend authorized**
- Currency and tax/FX assumptions: **Pending**
- Are paid third-party services allowed for evaluation? **Not authorized pending separate explicit owner approval**
- Are paid third-party services allowed in production? **Not authorized pending separate explicit owner approval**
- Is a zero-cost/open-source-first constraint required? **Pending**

A budget figure, if supplied, sets a ceiling only. It does not authorize a purchase, subscription or contract.

## 4. Technology stack decision pack

M2-S04 compared candidates and recommended a proof-of-fit, not a final selection. The following are candidates to evaluate against the actual delivery team's skills and cost constraints.

### 4.1 Backend framework

| Candidate | Strengths to validate | Risks/questions | Evidence needed |
|---|---|---|---|
| Laravel / PHP | Integrated web framework, queues, validation, mature web ecosystem | Actual PHP/Laravel expertise, package/security operations, hosting support | Small synthetic-data vertical spike, testability and deployment proof |
| Django / Python | Mature data/admin workflow ecosystem, ORM and security facilities | Actual Python expertise, steward UX boundaries, operational support | Small synthetic-data workflow spike and operations proof |
| NestJS / TypeScript | Typed modular services and shared language across web tiers | More assembly of admin/workflow conventions, dependency governance | Small synthetic-data service spike and maintainability review |

No framework is selected. Compare team proficiency, hiring/contracting availability, support horizon, security posture, maintainability, deployment complexity and total cost. Do not use an arbitrary numerical score when evidence is missing.

### 4.2 Frontend approach

| Candidate | Provisional fit | Decision test |
|---|---|---|
| Server-rendered templates / HTML-first | Strong baseline for SEO, low bandwidth and simple operations | Test public directory/profile/search journeys without JavaScript |
| Hybrid/partial enhancement | Strong candidate for selective filters and interaction | Test accessibility and progressive enhancement |
| Full React/Next.js SSR application | Candidate if interaction complexity justifies additional runtime | Demonstrate material UX benefit that outweighs cost/complexity |

### 4.3 Data, search and geography

| Area | M2 candidate baseline | Decision test |
|---|---|---|
| Primary relational store | PostgreSQL 18 + PostGIS proof-of-fit candidate | Integrity, multilingual data, spatial queries, backup/restore, hosting support and total cost |
| Alternatives | MySQL-compatible or MariaDB if team/hosting evidence justifies | Compatibility, constraints, spatial behaviour, support and migration/exit risk |
| Initial search | Database-native full-text/trigram search | Urdu/English names, aliases, spelling variation, ranking and query latency |
| Dedicated search | Add only if evidence demonstrates a need | Benchmark relevance/latency against operational and synchronization cost |
| Map/geocoder | Replaceable adapters; optional service | Terms, privacy, Pakistan coverage, usage limits, graceful degradation and cost |

### 4.4 Stack decision record

- Preferred backend: **Pending owner decision**
- Frontend rendering approach: **Pending owner decision**
- Primary database and spatial extension: **Pending owner decision**
- Initial search approach: **Pending owner decision**
- Queue/background processing approach: **Pending**
- Identity approach/provider: **Pending**
- Map/tile/geocoder provider: **Pending**
- Proof-of-fit scope and approval: **Pending**
- Decision rationale and rejected alternatives: **Pending**

Any technical spike must be separately scoped and authorized, isolated from production, use synthetic data and create no paid commitments unless explicitly approved.

## 5. Hosting and operations decision pack

| Criterion | Evidence required | Current status |
|---|---|---|
| Hosting provider and region | Shortlisted provider(s), current quote and region details | Not selected |
| Pakistan user latency | Measured tests from representative Pakistan locations | Not measured |
| Data location/transfer | Contract terms, storage/backup locations and qualified legal review | Open |
| Database support | Supported PostgreSQL/PostGIS version, extensions and upgrade path | Not verified |
| Backup and recovery | Backup frequency, retention, restore process, tested recovery capability | Not verified |
| Security | Access control, patching, network isolation, audit logs, incident notification | Not verified |
| Availability/support | Published support terms, service status and escalation | Not selected |
| Total cost | Compute, storage, egress, backups, monitoring, support, taxes and FX | Not priced |
| Exit/portability | Export formats, data ownership, migration and termination terms | Not assessed |

**Hosting decision:** no provider or region selected. No credentials, account setup, paid trial or procurement is authorized by this evaluation pack.

## 6. Legal, privacy, source and security gates

| Gate | Required reviewer/evidence | No-go condition |
|---|---|---|
| Applicable Pakistan law and contractual obligations | Qualified legal/privacy review | Unresolved material legal basis or obligations |
| Personal data and minors | Data minimization, age/safeguarding review, retention and incident plan | Unnecessary sensitive/minor data or unsafe public exposure |
| External source rights | Per-source terms, license, permitted methods, commercial/republication scope | No explicit applicable permission/authority |
| Source security | File/content threat handling, isolation, provenance and least privilege | Untrusted content can execute or bypass controls |
| AI/model provider | Data-use terms, retention, privacy, security, evaluation and cost caps | Unacceptable data handling or uncontrolled publication |
| Identity/reviews | Abuse, moderation, appeals, eligibility and privacy plan | No accountable moderation/safeguarding capacity |
| Accessibility | Owner-approved target and independent evaluation | Critical accessibility barriers remain unresolved |
| Production readiness | Threat model, recovery proof, incident ownership and explicit approval | Missing safeguards or no rollback |

Publicly accessible data is not automatically reusable. No scraping, bulk download, source-owner contact, permission request, connector activation or ingestion is authorized by this pack.

## 7. Owner response record

Record only confirmed decisions. A decision can be deferred with rationale and next evidence; blank fields must not be interpreted as approval.

| Decision ID | Owner decision | Rationale/evidence | Date |
|---|---|---|---|
| M3-D01 Delivery model and roles | Owner-led; user is Product Owner/final decision-maker; ChatGPT provides step-by-step technical assistance; qualified specialists may be engaged for legal/privacy/security review when needed. Named human implementers, maintainers and reviewers remain pending. | Owner confirmation in this conversation, 2026-11-12; human staffing/capability gaps still to be identified | 2026-11-12 |
| M3-D02 Capacity and availability | Owner availability: 10–15 hours/week as a planning baseline, with flexibility according to project demand and priority. Reviews/approvals are demand-led rather than limited to a fixed weekly meeting. Other human delivery capacity and continuity assumptions remain pending. | Owner confirmation in this conversation, 2026-11-12; availability does not imply engineering staffing or authorize spend | 2026-11-12 |
| M3-D03 Budget and spend ceiling | Pending | Pending | Pending |
| M3-D04 Technology stack | Pending | Pending | Pending |
| M3-D05 Hosting provider/region | Pending | Pending | Pending |
| M3-D06 Third-party services | Pending | Pending | Pending |
| M3-D07 Legal/privacy/security review scope | Pending | Pending | Pending |
| M3-D08 Source-specific access/reuse | Research-only; no source approved | Per-source assessment required | Pending |
| M3-D09 Accessibility and operational targets | Pending | M2 targets remain provisional | Pending |
| M3-D10 Review policy and staffing | Post-launch only; details pending | M1/M2 baseline | Pending |
| M3-D11 M3 implementation start | Not authorized | Requires M3-01 package and separate explicit approval | Pending |
| M3-D12 Production/launch | Not authorized | Requires separate release approval | Pending |

## 8. Decision boundary

Completing this pack does not select a stack, approve spending, authorize source access, activate a connector/model, approve a production account, authorize physical schema/migrations, or authorize deployment or launch. Those actions require their own explicit approvals and safeguards.


### T04 planning posture
The budget framework is prepared in `M3-00_BUDGET_AND_COST_SCENARIOS.md`. Scenario A (no-new-spend planning) is the only currently permitted posture. Open-source/low-fixed-cost and managed-service scenarios are comparison cases only; numeric ceilings, dated quotes, taxes/FX and paid-service policy remain undecided. No paid evaluation, procurement or contract is authorized.
