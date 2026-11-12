# M3 Master Step Plan — Mobilization, Implementation and Controlled Release

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Baseline:** M0, M1 and M2 accepted and closed; M2 = 100%  
**Current milestone:** M3 — Mobilization and Controlled Implementation  
**Current step:** M3-00 — Mobilization and Decision Closure  
**Plan status:** Proposed execution baseline, owner-authorized for documentation/planning only  
**Application implementation:** Not authorized by this plan or by M2 acceptance

## 1. Purpose and governance

This plan converts the accepted M2 architecture into a controlled, step-by-step implementation programme. It supersedes the earlier high-level M3 sequencing in M2-S10 where the two differ; M2 remains closed and is not reopened. The M2 architecture, M1 requirements, G01-G20 controls and V2-DEC-006 remain binding.

A step is complete only when its deliverables, tests/evidence, dependencies, risk disposition and owner acceptance criteria are met. A merged PR is delivery evidence, not automatic owner acceptance. Progress must be evidence-based; do not assign completion percentages merely because documents or PRs exist.

**M3-00 and M3-01 are planning/authorization steps.** No application coding begins until M3-01 has a separate explicit owner implementation-start authorization. The authorization must define exactly which implementation scope is allowed. Approval of this roadmap does not approve procurement, source access, production access, physical schema/migrations, deployment, launch or URL cutover.

## 2. M3 milestone outcome

Deliver a secure, maintainable, independently built V2 education discovery platform through documented decision gates, implementation, testing, controlled pilot and separately authorized release. The platform must preserve evidence provenance, human publication controls, privacy/minor safeguards, low-bandwidth anonymous discovery and Deeni Madaris suppression.

## 3. M3 step roadmap and milestone weights

Weights are planning allocations for the M3 programme and total 100%. They may be adjusted only through a documented owner-approved change before affected work begins. M3-11 is a conditional production-release gate; its weight does not authorize launch.

| Step | Name | Weight | Main outcome | Dependency |
|---|---|---:|---|---|
| M3-00 | Mobilization and Decision Closure | 5% | Team/capacity, budget, stack/hosting decision evidence, legal/security gates and implementation readiness register | M2 accepted |
| M3-01 | Implementation Planning and Authorization | 7% | Detailed backlog, scope, acceptance/test/release plan and explicit implementation-start decision | M3-00 |
| M3-02 | Platform Foundation | 10% | Approved repository/application foundation, CI, non-production environments and engineering controls | M3-01 authorization |
| M3-03 | Core Data and Governance | 12% | Approved domain model implementation, provenance, audit, validation, adjudication and publication controls | M3-02 |
| M3-04 | Provider Management | 8% | Provider/institution/campus/programme administration and controlled editorial workflows | M3-03 |
| M3-05 | Public Directory and Search | 10% | Anonymous public browsing, search, filters, profile pages and clear unknown/stale states | M3-03; M3-04 |
| M3-06 | Geography and Discovery | 7% | Locality-aware discovery, geo-quality/privacy controls and optional replaceable map integration | M3-05 |
| M3-07 | AI Data-Agent | 10% | Quarantined evidence workflow, deterministic checks, entity resolution, human review and evaluation | M3-03; source-specific gates |
| M3-08 | Identity, Reviews and Security | 10% | Least-privilege accounts, moderation, appeals, safeguarding and security controls; reviews remain post-launch | M3-02; M3-03 |
| M3-09 | Quality and Operational Hardening | 8% | Functional, accessibility, performance, security, resilience, backup/restore and operational evidence | M3-04 through M3-08 as applicable |
| M3-10 | Pilot and Launch Readiness | 7% | Bounded pilot, defect closure, operational acceptance and launch decision pack | M3-09; separate pilot approval |
| M3-11 | Controlled Production Launch | 6% | Production release and monitored operation after separate explicit production/launch authorization | M3-10; separate written launch approval |

## 4. Step definitions and acceptance evidence

### M3-00 — Mobilization and Decision Closure
**Scope:** Documentation and planning only.

Tasks (weights total 100%):
- T01 — Reconcile accepted M0/M1/M2 baseline and open decisions (10%).
- T02 — Define required roles, skills, responsibility boundaries and decision owners (15%).
- T03 — Establish realistic availability, capacity, delivery cadence and continuity assumptions (10%).
- T04 — Establish budget range, recurring/one-time cost categories and an owner-approved spend ceiling (15%).
- T05 — Prepare evidence-based stack decision pack, proof-of-fit criteria and explicit owner decision record (15%).
- T06 — Prepare hosting/region/vendor comparison, data-location questions, operational fit and cost evidence (10%).
- T07 — Establish legal, privacy, minor-safeguarding, source-rights, security and AI activation decision gates (15%).
- T08 — Define M3 implementation scope boundaries, dependencies, risks, testing/release governance and the M3-01 authorization pack (10%).

**Exit evidence:** completed mobilization register; confirmed team/roles/capacity; cost model and owner ceiling or explicit defer/block; stack and hosting decision records or explicit unresolved blockers; legal/privacy/source/security gate register; prioritized implementation scope; test/release plan; and owner review of readiness. Unknown facts must remain open, not invented.

### M3-01 — Implementation Planning and Authorization
**Scope:** Planning, backlog and approval package; technical spikes only if separately authorized within a defined non-production, synthetic-data scope.

**Exit evidence:** implementation-ready work breakdown; architecture/decision traceability; acceptance criteria per vertical slice; test strategy and CI gates; security/privacy threat and verification plan; environments and rollback approach; source/data fixtures plan; staffing/capacity and budget fit; explicit owner authorization naming the permitted implementation scope. Without that authorization, stop before application code.

### M3-02 — Platform Foundation
**Scope after authorization:** initialize application structure and approved stack; repository protections; automated quality/security checks; non-production configuration and secret handling; environment separation; observability baseline. No production connection.

**Exit evidence:** reproducible local/CI build; protected PR checks; documented configuration and secret boundaries; environment isolation; smoke tests; reviewed architecture conformance.

### M3-03 — Core Data and Governance
Implement only the owner-approved logical model. Establish provenance, source authorization records, evidence quarantine, deterministic validation, audit history, human adjudication, publication, correction, withdrawal and rollback. Physical schema/migrations require the M3-01 scope approval and separate safeguards.

**Exit evidence:** tests for lineage, temporal facts, conflicts, authorization, auditability, publication/withdrawal and rollback; no unauthorized source data.

### M3-04 — Provider Management
Implement provider and institution identity, campuses/delivery sites, programmes, affiliation/authority relationships, status history, editorial review and role-appropriate management.

**Exit evidence:** tested lifecycle workflows, deduplication controls, permissions, audit history and clear distinctions among provider, institution, campus, programme and authority.

### M3-05 — Public Directory and Search
Deliver anonymous-first directory pages, search, categories, filters and institution profiles. Preserve unknown, conflicting, stale and unverified states. Public output must derive only from approved publication state.

**Exit evidence:** user-journey tests, search correctness, accessibility checks, low-bandwidth behavior, freshness display and public/private boundary tests.

### M3-06 — Geography and Discovery
Implement locality quality, approximate location handling, distance/search behavior and optional map/geocoder adapters. Core discovery must work without precise location, maps or third-party geography services.

**Exit evidence:** geo-quality tests, privacy tests, graceful degradation and Deeni Madaris suppression tests across all affected public surfaces.

### M3-07 — AI Data-Agent
Implement only after model/provider and each source-specific access/reuse approval. AI remains proposal-only. Capture is bounded and quarantined; deterministic validation and human adjudication precede publication.

**Exit evidence:** prompt-injection and malicious-file tests, least-privilege tests, provenance completeness, extraction evaluation, human approval enforcement, cost limits and source-specific authorization proof. No blanket source authorization.

### M3-08 — Identity, Reviews and Security
Implement least-privilege identity and contextual authorization, moderation, appeal and safeguarding workflows. Reviews are post-launch only; login is not proof of attendance. No pre-launch participant surveys/interviews/recruitment unless the owner explicitly changes that decision.

**Exit evidence:** authorization matrix tests, account/privacy controls, abuse and moderation tests, appeal audit, safeguarding/legal review and security verification.

### M3-09 — Quality and Operational Hardening
Run functional/regression, accessibility, performance/load, security, privacy, backup/restore, incident-response and operational exercises. Convert provisional M2 quality hypotheses into evidence-based targets only after owner approval.

**Exit evidence:** reproducible test reports, defect disposition, security findings, timed restore evidence, monitoring/alerting checks, operational runbooks and owner-approved residual-risk register.

### M3-10 — Pilot and Launch Readiness
Prepare a bounded pilot only after its scope, participants, data and operational safeguards are separately approved. Do not conduct deferred student research as an implied pilot. Complete support, moderation, incident and rollback readiness.

**Exit evidence:** pilot acceptance report, defect closure or approved exceptions, operational ownership, legal/privacy/security sign-off and a launch recommendation. This step does not authorize production deployment.

### M3-11 — Controlled Production Launch
Conditional step. Requires separate explicit written approval for production access, data handling, deployment, backup/recovery safeguards, monitoring, public release and any URL cutover. Execute only the approved release scope with rollback and incident controls.

**Exit evidence:** approved deployment record, production smoke tests, monitoring and rollback verification, incident ownership and post-release acceptance. No launch by implication.

## 5. Binding controls and non-negotiable invariants

1. V2 remains independent. Do not inspect, copy, adapt, port or depend on legacy Listing V1 code, schema, data, workflows or operational patterns.
2. M1 G01-G20 and accepted M0/M1 controls remain binding.
3. V2-DEC-006: Show Deeni Madaris defaults OFF. When OFF, no exposure in public search, browse, maps, recommendations, counts, facets, sitemaps, exports, caches, APIs or direct public identifier lookup. No sect/maslak discovery filters.
4. External source families remain RESEARCH ONLY until source-specific rights, security, privacy and operational assessment plus explicit owner authorization. Public accessibility is not permission.
5. No scraping, bulk download, source-owner outreach, permission request, connector activation or ingestion without the applicable separate authorization.
6. AI output is proposal-only; no autonomous high-impact fact publication.
7. Anonymous-first discovery, data minimization, privacy and minor safeguarding remain mandatory.
8. Student interviews, surveys, recruitment and outreach remain deferred during construction.
9. Reviews are post-launch only; authentication does not prove attendance.
10. No procurement, new spend, production access, destructive data changes, deployment, launch or URL cutover without separate explicit approval.
11. No unapproved stack, vendor, legal compliance claim, numeric SLO, RPO/RTO or cost ceiling may be presented as settled.

## 6. Decision register required by M3-00

| ID | Decision | Required evidence / owner input | Default until resolved |
|---|---|---|---|
| M3-D01 | Delivery roles and skills | Named roles, skills, accountable owners and gaps | Unconfirmed; no staffing assumption |
| M3-D02 | Availability/capacity | Weekly capacity, schedule, continuity and review time | Unconfirmed; no delivery-date promise |
| M3-D03 | Budget/spend ceiling | One-time and recurring cost worksheet; explicit ceiling | No new spend authorized |
| M3-D04 | Technology stack | Team fit, maintainability, proof-of-fit and security evidence | M2 conditional direction only; no final stack |
| M3-D05 | Hosting/region | Quotes, data location, Pakistan latency, legal and recovery evidence | No provider/region selected |
| M3-D06 | Identity/model/map vendors | Privacy/data terms, quality, security, exit strategy and cost | No vendor or service activated |
| M3-D07 | Legal/privacy/minors | Qualified review of applicable obligations and safeguarding | Open; no compliance claim |
| M3-D08 | Source-specific rights | Terms, rights, privacy, security, permitted methods and scope | Research-only; no collection |
| M3-D09 | Accessibility/SLO/RPO/RTO | Owner target plus audit/load/restore evidence | M2 hypotheses remain provisional |
| M3-D10 | Review policy and staffing | Eligibility, moderation, appeals, anti-abuse and staffing | Reviews post-launch only |
| M3-D11 | Implementation start | Approved M3-01 package and explicit written authorization | Not authorized |
| M3-D12 | Production/launch | Separate release scope, recovery safeguards and explicit approval | Not authorized |

## 7. Change control and reporting

- Update the project controller, milestone register, roadmap, documentation catalogue and progress report after material M3 decisions and each accepted step.
- Keep a decision log with evidence, options, recommendation, owner decision, date and scope.
- Report exact branch, PR, commit SHA, required CI result and merge status. Never infer CI or merge success.
- Keep blocked items visible with the precise owner input or external evidence required.
- Do not reopen M2 unless a material defect is found; any correction must be tracked separately without silently changing accepted scope.

## 8. Current execution status

- M0: Accepted and closed.
- M1: Accepted and closed; primary participant research deferred.
- M2: 100% owner-accepted and closed.
- M3-00: In progress at 10% weighted completion (T01 complete; T02 in progress after owner-approved owner-led/ChatGPT-assisted delivery model; T03-T08 open); owner acceptance pending.
- M3-01 onward: Not started.
- Application implementation: Not authorized.
- Production access/deployment/launch: Not authorized.

**M3-00 supporting artifact:** `M3-00_OWNER_DECISION_PACK.md` contains the owner/team input and decision templates. **Next eligible work:** resolve the open owner inputs and decision gates, then complete M3-00 readiness evidence. Do not begin M3-01 implementation work or application coding until the required authorization is recorded.
