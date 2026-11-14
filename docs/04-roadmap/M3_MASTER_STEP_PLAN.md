# M3 Master Step Plan — Mobilization, Implementation and Controlled Release

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Baseline:** M0, M1 and M2 accepted and closed; M2 = 100%  
**Current milestone:** M3 — Mobilization and Controlled Implementation  
**Current step:** M3-03 — Core Data and Governance; Agendas 1–10 delivered within their separately authorized bounded scopes; G-04 deterministic-oracle traceability reconciled and awaiting Product Owner acceptance  
**Plan status:** Agendas 4 Slices A/B and 5–10 were separately authorized, delivered and evidence-reconciled within bounded scopes; G-01–G-03 closed for synthetic local/CI scope; G-04 traceability delivered with partial/deferred cases explicitly retained  
**Application implementation:** Local/CI-only synthetic implementation has been separately authorized and completed for the bounded Agendas 4, 6–10 scopes. G-04 is documentation-only; it adds no code or tests. Real/source data, external services, production and deployment remain separately gated.

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
- M3-00: In progress at 10% weighted completion (T01 complete; T02 in progress after owner-approved owner-led/ChatGPT-assisted delivery model; T03 in progress after owner confirmed 10–15 hours/week as a planning baseline, flexible according to project demand and priority, with demand-led reviews/approvals; T02-T06 in progress with supporting frameworks delivered for T04-T06; T07-T08 open); owner acceptance pending.
- M3-01 onward: Not started.
- Application implementation: Not authorized.
- Production access/deployment/launch: Not authorized.

**M3-00 supporting artifact:** `M3-00_OWNER_DECISION_PACK.md` contains the owner/team input and decision templates. **Next eligible work:** resolve the open owner inputs and decision gates, then complete M3-00 readiness evidence. Do not begin M3-01 implementation work or application coding until the required authorization is recorded.


## PR #102 merge reconciliation — 2026-11-12

PR [#102](https://github.com/mattari20/listing-v2/pull/102) recorded M3-DEC-001 (owner-led, ChatGPT-assisted delivery model) and M3-DEC-002 (owner availability of 10–15 hours/week as a flexible planning baseline, with demand-led review/approval cadence). Exact PR head `2cce569bd6e63dcf204f5c11d987a8d544373b2d` passed **Project documentation validation** workflow run [#43198671760](https://github.com/mattari20/listing-v2/actions/runs/43198671760); job `Validate project control documents` and all steps completed successfully. PR #102 was squash-merged as `cc5a4966cca74df5e15de7f15277814ddb86d6d9`.

T02 and T03 are In progress; no partial task percentages are claimed because named human role coverage, other delivery capacity and continuity evidence remain incomplete. T01 remains complete; T04-T08 remain open. M3-00 remains 10% weighted completion and M3 overall remains 0.5%. This merge confirms documentation delivery and CI validation, not M3-00 acceptance or implementation authorization. No hiring, procurement, spend, source access, production access, application code, schema/migrations, deployment or launch is authorized.


## M3-00 T04 supporting budget framework

The [M3-00 Budget and Cost Scenarios](M3-00_BUDGET_AND_COST_SCENARIOS.md) document defines comparable cost categories, no-new-spend/open-source/managed-service planning scenarios, calculation rules and mandatory spend controls. No numeric budget ceiling or paid-service permission is approved. T04 remains in progress pending owner decisions and dated cost evidence. No procurement or spend is authorized.


## M3-00 T05 supporting technology framework

The [M3-00 Technology Stack Decision Framework](M3-00_TECHNOLOGY_STACK_DECISION_FRAMEWORK.md) compares candidate backend, frontend, database, search, geography and background-processing approaches against common criteria. It preserves the M2 conditional baseline but selects no technology. Named implementer/maintainer skill fit, support/security evidence, cost and hosting fit remain dependencies. No technical spike, installation or implementation is authorized.


## M3-00 T06 supporting hosting and operations framework

The [M3-00 Hosting and Operations Decision Framework](M3-00_HOSTING_AND_OPERATIONS_DECISION_FRAMEWORK.md) records provider-region research and operating-model comparisons, with explicit verification requirements for exact service support, Pakistan latency, data location/transfer, backups/restore, security, support and total cost. No provider or region is selected; no account, trial, procurement or deployment is authorized.


## Current-status audit — 2026-11-12 (after PR #110)

PRs #102–#110 are closed and merged; each required Project documentation validation passed on its exact PR head. The latest reconciliation PR #110 merged as `a328a8272b086cac6270dc625d53ea6c3bbc1fa7`. Current M3-00 task status: T01 Complete; T02-T06 In progress; T07-T08 Open. T04-T06 have delivered decision frameworks, not final decisions or completed tasks. M3-00 remains 10%; M3 overall remains 0.5%. No partial task percentages are claimed. See [Project Progress Report](PROJECT_PROGRESS_REPORT.md) and [M3-00 Mobilization](M3-00_MOBILIZATION_AND_DECISION_CLOSURE.md) for blockers and evidence. No implementation, spend or production authorization is created.


## Superseding M3-00 owner acceptance — 2026-11-12

The Product Owner explicitly accepted all three bounded closeout decisions: T07 as a deny-by-default planning/control framework only, T08 as a planning framework only, and M3-00 formal closure on those conditions. The authoritative [M3-00 Final Owner Acceptance and Closure Record](M3-00_FINAL_OWNER_ACCEPTANCE_AND_CLOSURE_RECORD_2026-11-12.md) supersedes earlier pending/open snapshots. M3-00 is **Accepted — 100% of planning deliverables**; M3 overall weighted progress is **5%**. Qualified reviews, staffing, stack, hosting, source rights and spend decisions remain open. M3-01 planning begins under [M3-01 Work Plan](M3-01_IMPLEMENTATION_PLANNING_AND_AUTHORIZATION_WORK_PLAN.md); implementation authorization is **NOT ISSUED**. No application coding, technical spike, source/production access, DB changes, procurement, spend, deployment, pilot or launch is authorized.


## M3-03 Agenda 1 — Logical Domain Model and Provenance Work Package (2026-11-13)

A bounded Product Owner authorization permits repository-local documentation and synthetic-only deterministic specification in `mattari20/listing-v2`. The agenda deliverables are:
- `M3-03_LOGICAL_DOMAIN_MODEL_AND_GOVERNANCE.md` — logical entities/relationships, temporal claim/version contract, provenance/source-authorization contract, deterministic validation, conflict handling, human adjudication, audit, correction, withdrawal, rollback and publication controls.
- `M3-03_SYNTHETIC_FIXTURES.json` — fabricated fixture catalogue only; no real/source/personal data.
- `M3-03_SYNTHETIC_FIXTURES_AND_DETERMINISTIC_TEST_SPEC.md` — 24 deterministic test vectors and expected outcomes.

The fixture JSON was parsed and structurally checked: 11 entities, 11 relationships, 5 claims, 2 evidence references, 2 synthetic authorization fixtures and 24 test IDs; all relationship endpoints, claim-evidence links and evidence-authorization references resolve; restricted category default is false. These are fixture integrity checks, not application/runtime test execution.

Agenda 1 deliverables are prepared for review. The focused M1 SR-01–SR-14 / M1 G-control / M2 AR-001–AR-025 crosswalk was completed against canonical M1 product/acceptance records and M2-S01/S02/S05/S10 architecture documents. The fixture JSON structural review passed with 11 entities, 11 relationships, 5 claims, 2 evidence references, 2 authorization fixtures and 24 test IDs; all endpoints and provenance references resolve and the restricted category default is false. These are specification and fixture-integrity results, not application/runtime test execution. No physical schema, migrations, database connection, persistence, application code, real/source/personal data, source collection, external services/AI, hosting, deployment or new spend was performed or authorized. M3-03 as a whole remains in progress; this agenda completes only the bounded Agenda 1 work package.


## M3-03 Agenda 2 — Logical Model Review and Governance Decision Closure (2026-11-13)

The Agenda 1 logical model, synthetic fixtures, 24-vector test specification and evidence record were reviewed against their own invariants and the focused accepted M1/M2 traceability baseline. The review found the model directionally aligned and did not recommend restart. Seven clarifications were recorded: Provider–Institution cardinality; canonical claim disposition versus lifecycle events; identity candidate/merge/split governance; controlled authority relationship vocabulary; downstream consequences of source-authorization revocation; minimum separation-of-duties/role matrix; and missing synthetic edge-case oracles.

The review and five Product Owner decision prompts are recorded in `M3-03_AGENDA_02_LOGICAL_MODEL_REVIEW_AND_GOVERNANCE_DECISIONS.md`, merged through PR [#153](https://github.com/mattari20/listing-v2/pull/153) as `9d83d0a21b9ae5e741196a5b49326d1295edc240`. PR #153 exact head `86470c3d76fe886e506f0895f285616fc5611cda` passed Project documentation validation run #364 (GitHub run ID 43444709815) and FND-01 foundation CI run #54 (GitHub run ID 43444709623); no review threads were outstanding.

**Agenda disposition:** review activity delivered and merged; Product Owner design-baseline acceptance remains pending. The review recommendation is not owner acceptance. M3-03 remains In progress. No physical schema, migrations, persistence, real/source/personal data, source acquisition, external services/AI, hosting, deployment, pilot, launch or spend is authorized. P04/P05/P06 gates remain separate and open as applicable.


## M3-03 Agenda 2 — Product Owner design-baseline acceptance (2026-11-13)

The Product Owner accepted D-01 through D-05 in the Agenda 2 review. R-01–R-06 are incorporated as logical-model invariants; R-07 is addressed by extending the synthetic deterministic specification from 24 to 32 cases (T-025–T-032). The accepted design baseline includes explicit Provider–Institution cardinality, normalized claim disposition/version lineage, human-controlled reversible identity resolution, distinct authority relationship predicates, authorization revocation consequences and minimum separation-of-duties rules.

The acceptance record is in `M3-03_AGENDA_02_LOGICAL_MODEL_REVIEW_AND_GOVERNANCE_DECISIONS.md`; revised artifacts are the logical model, synthetic fixture manifest v1.1.0 and 32-vector test specification. This acceptance is **design-only**. It does not authorize physical schema, migrations, persistence, application implementation, real/source/personal data, source acquisition, external services/AI, hosting, deployment, pilot, launch or spend. M3-03 remains In progress; the next implementation-related scope requires a separate explicit Product Owner authorization.


## M3-03 Agenda 3 — Physical Implementation Scope and Authorization Pack (2026-11-13)

Following Product Owner acceptance of the logical design baseline, a documentation-only authorization pack was prepared at `M3-03_AGENDA_03_PHYSICAL_IMPLEMENTATION_AUTHORIZATION_PACK.md`. It proposes a staged local/CI-only, synthetic-only first increment (physical schema/migration contract, then synthetic persistence/invariant tests), defines exclusions, preconditions and acceptance criteria, and explicitly requests a separate Product Owner authorization.

This is a proposal only. No physical schema, migrations, persistence, database provisioning/connection, application code or runtime work has begun. No implementation authorization is issued. M3-03 remains In progress; the next gate is the Product Owner's explicit decision on the exact implementation scope and disposable test-database method.


## M3-03 Agenda 4 — Local/CI synthetic persistence foundation closeout (2026-11-13)

Agenda 4 Slices A and B are **Completed** within the exact Product Owner authorization: repository `mattari20/listing-v2`, local development and GitHub CI only, fabricated synthetic values only, and disposable SQLite `:memory:` only. No V1, Hostinger, hPanel, production/live database, real/source/personal/institute data, source acquisition, external API/AI, public surface, deployment, procurement, new spend or GitHub protection/ruleset change was performed.

PR [#157](https://github.com/mattari20/listing-v2/pull/157) was merged into `main` as `1587cd9b2d05b033c18f0b0570b13d37b872bfce`. Exact PR head: `a3636709a6a299e7e264b315c07a323fa4ff85d3`. Exact-head Project documentation validation run #378 (GitHub run ID 43448575503) passed. Exact-head FND-01 foundation CI run #64 (GitHub run ID 43448575509) passed, including PHP 8.5 setup, SQLite/PDO SQLite verification, Composer validation, dependency advisory checks, PHP formatting, Laravel bootstrap/routes, synthetic persistence tests and artifact hygiene. No outstanding review threads were present. The PR was squash-merged; the first default merge-method attempt was rejected because merge commits are disabled, then the repository-supported squash method succeeded without bypassing protections.

The migration creates eight tables: `directory_entities`, `entity_relationships`, `source_authorizations`, `evidence_references`, `claims`, `claim_versions`, `claim_evidence_links` and `audit_events`. It uses UUID keys, foreign-key restrictions, temporal fields, distinct authorization scopes, metadata-only quarantined evidence references, claim disposition/version lineage separation and audit metadata. The migration includes a reverse-order `down()`. Synthetic tests cover schema presence, invalid relationship endpoints, distinct authorization scopes/evidence quarantine, claim version supersession/disposition separation and audit event fields. SQLite is configured to default to `:memory:`; PHPUnit and CI explicitly use `:memory:`, and tracked database files remain prohibited.

**Acceptance boundary:** This is a local/CI persistence foundation, not the complete governance service, adjudication/publication workflow, institute listing product, legal/privacy/source-rights clearance, public release or production readiness. The Agenda 4 authorization is exhausted at closeout. Agenda 5 or any further implementation requires a new, explicit Product Owner authorization. M3-03 as a whole remains **In progress**; no unsupported weighted completion percentage is claimed.


## M3-03 Agenda 5 — Governance Service Boundary and Enforcement Design closeout (2026-11-13)

Agenda 5 was separately authorized by the Product Owner as the next bounded design activity. The design is recorded in `M3-03_AGENDA_05_GOVERNANCE_SERVICE_BOUNDARY_AND_ENFORCEMENT_DESIGN.md`; the completion/evidence record is `M3-03_AGENDA_05_COMPLETION_AND_EVIDENCE_RECORD.md`.

The design defines logical application-service boundaries in a modular monolith; conceptual commands and decision contracts; authorization/evidence/claim state transitions; provenance, quarantine, human adjudication and publication invariants; revocation and suppression propagation; audit, atomicity, idempotency, concurrency and fail-closed behavior; entry-point bypass prevention; a minimum separation-of-duties capability model; 32 synthetic acceptance-test scenarios (GS-001–GS-032); M1/M2/Agenda 2/Agenda 4 traceability; and explicit residual risks.

**Agenda disposition:** design activity completed and closed. The 32 GS scenarios are specifications only, not executed application tests. No service code, role provisioning, runtime enforcement, physical schema change, source access, real data, external integration, public surface, deployment, procurement or spend was performed or authorized. The detailed role/permission matrix, human coverage, specialist clearances, source-specific rights, retention policy, projection architecture and runtime transaction/recovery evidence remain open.

M3-03 remains **In progress**; no whole-step weighted completion percentage is claimed. Agenda 5 authorization is exhausted. Any implementation-readiness or service implementation activity requires a new explicit Product Owner authorization.


## M3-03 Agenda 6 — completed bounded governance service-contract implementation (2026-11-13)

PR [#160](https://github.com/mattari20/listing-v2/pull/160) merged as `9fd14f069f71e17d34a5392caf6977df9674fd4d` after exact-head validation of `8648781689ebe2fe28ba7ee033ccff4d3066d143`.

- PHP 8.5 foundation CI run #87 (`43453989536`) passed all steps, including Pint, Laravel bootstrap/routes, synthetic tests and artifact hygiene.
- Project documentation validation run #404 (`43453989517`) passed.
- No unresolved review threads remained at merge.
- The test suite recorded 104 assertions and 22 non-fatal warnings from existing test harness attempts to read an absent local `.env` file.

Agenda 6 is **Complete** for the bounded local/CI synthetic policy/service-contract scope. The GS-001–GS-032 matrix is policy-level verification, not 32 end-to-end workflows. Persisted adjudication/publication decisions, snapshots/projections, outbox/queue delivery, suppression propagation and restoration persistence remain deferred and require separate authorization. M3-03 remains **In progress**; no whole-step completion percentage is claimed.


## M3-03 Agenda 7 — Persisted Adjudication and Publication Workflows (2026-11-13)

The Product Owner authorized the next bounded local/CI-only synthetic implementation increment. PR [#162](https://github.com/mattari20/listing-v2/pull/162) adds persistence for adjudication cases/decisions and appeal lineage, publication decisions and immutable snapshots, internal public-projection state, transactional outbox events, emergency suppression and restoration. The service implements human adjudication and publication gates, evidence/authorization rechecks, actor separation, source-authorization revocation propagation, idempotent projection processing and audit/outbox atomicity.

The implementation candidate and scope/limitations record is `M3-03_AGENDA_07_PERSISTED_ADJUDICATION_AND_PUBLICATION_WORKFLOWS.md`. Synthetic feature tests cover the new workflows. Exact-head PHP 8.5 foundation CI and documentation validation are pending; do not mark Agenda 7 complete or merge until both pass, review threads are clear and the exact head is rechecked. No public route, real role provisioning, real/source data, production, external services, deployment or spend is included. M3-03 remains in progress; no whole-step completion percentage is claimed.


## M3-03 Agenda 7 — completed bounded persisted workflow implementation (2026-11-13)

The Product Owner authorized Agenda 7 and the bounded local/CI synthetic implementation is complete. PR [#163](https://github.com/mattari20/listing-v2/pull/163) merged as `a16d6564e5f5190a841c5596ddb47638d1ec735c` from exact head `ede649e53878facd8906e19b6a57e2d5019caaed`.

- PHP 8.5 foundation CI run #111 (`43458056872`): **success**; all configured steps passed, including Pint, Laravel bootstrap/routes, dependency audit, synthetic tests and artifact hygiene.
- Project documentation validation run #430 (`43458057006`): **success**.
- Synthetic tests: 137 assertions, no failures; 32 existing missing-local-`.env` warnings. No `.env` or database artifact was created.
- Review threads: none unresolved. PR #162 was closed as superseded by validated PR #163.

Agenda 7 is **COMPLETED** for its bounded scope. The detailed completion/evidence record is `M3-03_AGENDA_07_COMPLETION_AND_EVIDENCE_RECORD.md`. M3-03 overall remains **IN PROGRESS**; no whole-step completion percentage is claimed. Production queue/recovery, real role/permission coverage, retention/deletion, specialist reviews, public surfaces and deployment remain separate gates.


## M3-03 Agenda 8 — Transactional Outbox Reliability and Recovery Hardening (2026-11-14)

The Product Owner authorized Agenda 8 for bounded local/CI-only synthetic hardening of the Agenda 7 transactional outbox. The candidate adds claim-token fencing, short-transaction event claiming, stale-lease recovery, per-event transactional application, bounded retry/backoff, terminal dead-letter disposition, fail-closed unknown-event handling, latest-snapshot ordering and suppression/restoration race safeguards. The scope record is `M3-03_AGENDA_08_OUTBOX_RELIABILITY_AND_RECOVERY.md`.

Implementation and synthetic tests are on `feature/m3-03-agenda-08-outbox-reliability`. Exact-head PHP 8.5 foundation CI, documentation validation, review reconciliation and merge are pending. This does not prove production multi-process concurrency, broker delivery, exactly-once external effects or production recovery. No production, source data, external service, deployment or spend is included. M3-03 remains **IN PROGRESS**.

## M3-03 Agenda 8 — completed bounded outbox reliability implementation (2026-11-14)

The Product Owner authorized Agenda 8. PR [#165](https://github.com/mattari20/listing-v2/pull/165) merged as `3f547ca7b925c5445c296c5a6311bac2fa7d744d` from exact validated head `e11abda10ed8a2aefe69e66c9740544c9bdb4d2a`.

- PHP 8.5 foundation CI run #43527123064: **success**, all configured steps passed, including Pint, Laravel bootstrap/routes, synthetic-only tests and artifact hygiene.
- Project documentation validation run #43527123066: **success**.
- No unresolved review threads; no review submissions were present. Exact-head SHA was rechecked and guarded at merge.
- Completion/evidence record: `M3-03_AGENDA_08_COMPLETION_AND_EVIDENCE_RECORD.md`.

Agenda 8 is **COMPLETED** for its bounded local/CI synthetic reliability/recovery scope. Production multi-process locking, broker/worker operations, downstream exactly-once effects, dead-letter operator tooling, real role coverage, specialist reviews, public surfaces and deployment remain separate gates. M3-03 remains **IN PROGRESS**.

## M3-03 Agenda 9 — Claim Version Lifecycle, Correction and Withdrawal (2026-11-14)

A repository audit against the M3-03 exit evidence identified that the persisted workflow service did not yet expose immutable claim-version successor creation or a claim withdrawal command. The existing schema already contains version lineage and effective-date fields; the existing adjudication workflow already persists the `disputed` outcome. Agenda 9 is therefore scoped to complete those bounded local/CI lifecycle behaviors without adding a conflict table or automated conflict resolution.

The implementation candidate is on `feature/m3-03-agenda-09-claim-lifecycle`. It adds human-gated correction with temporal successor lineage, eligible synthetic evidence links, idempotency and stale-version publication denial; explicit human withdrawal with audit, dependent snapshot suppression and outbox propagation; and synthetic tests for disputed-state publication denial. Scope and evidence records: `M3-03_AGENDA_09_CLAIM_VERSION_LIFECYCLE_CORRECTION_AND_WITHDRAWAL.md` and `M3-03_AGENDA_09_COMPLETION_AND_EVIDENCE_RECORD.md`.

Agenda 9 remains in progress pending exact-head PHP 8.5 foundation CI, Project documentation validation, review reconciliation, merge and final evidence update. No real/source data, source access, real roles, production, external services/AI, public endpoint, deployment or spend is included. M3-03 remains in progress.


## M3-03 Agenda 9 — final completion reconciliation (2026-11-14)

Agenda 9 is **COMPLETED** for its bounded authorized synthetic local/CI scope. PR [#167](https://github.com/mattari20/listing-v2/pull/167) merged as `91c15204fb41ba5cc5a29b99a2dca80e983adc9d` from exact validated head `3d01e87643aa838e55e07a1a20c67ada9078415b`.

Exact-head PHP 8.5 foundation CI run [#43529328306](https://github.com/mattari20/listing-v2/actions/runs/43529328306) and Project documentation validation run [#43529328427](https://github.com/mattari20/listing-v2/actions/runs/43529328427) both passed. The synthetic test suite reported 176 assertions and no failures, with 42 non-fatal missing-local-`.env` warnings from the existing test harness. Review threads were clear, no review submissions were present and merge used an expected-head SHA guard.

Delivered behavior includes human-gated immutable correction successors with effective dates and evidence lineage, idempotency, superseded-version publication denial, explicit disputed-state denial, and human-only withdrawal with audit, dependent suppression records, projection freeze and outbox propagation. Global temporal-overlap policy, automated conflict resolution, real roles, retention/deletion, specialist approvals, production concurrency, public surfaces and deployment remain separate gates. M3-03 overall remains **IN PROGRESS**.


## M3-03 step-level exit reconciliation — 2026-11-14

Following completion of Agenda 9, the original M3-03 exit evidence was reconciled against the accepted logical model, merged schema/services/workflows and existing synthetic feature tests. The step remains **IN PROGRESS**. The exit criteria explicitly require evidence for lineage, temporal facts, conflicts, authorization, auditability, publication/withdrawal, rollback and no unauthorized source data.

The reconciliation found bounded evidence for lineage, authorization, auditability, publication/withdrawal and synthetic-only handling. Temporal conflict evaluation is partial; conflict detection/disputed adjudication is present but a persisted first-class conflict/candidate lifecycle is not demonstrated; and explicit rollback to a prior approved snapshot is not implemented/tested (suppression restoration is not equivalent). The full oracle matrix also remains a specification plus selected policy/feature tests, not 32 persisted end-to-end workflows.

Authoritative record: [M3-03 Exit-Criteria Reconciliation and M3-04 Entry Gate](M3-03_EXIT_CRITERIA_RECONCILIATION_AND_M3-04_ENTRY_GATE.md).

**Recommended next bounded scope:** M3-03 Agenda 10 — Persisted Conflict Lifecycle, Temporal Conflict Evaluation and Prior-Snapshot Rollback. This is a proposal only and requires separate explicit Product Owner authorization before code, schema or tests are changed. M3-04 Provider Management remains blocked until M3-03 exit evidence is satisfied and accepted. No M3-04 implementation, production, real data, source access, external services/AI, deployment or spend is authorized by this reconciliation.


## M3-03 Agenda 10 — authorized persisted conflict and rollback implementation (2026-11-14)

The Product Owner authorized the exact bounded scope in Section 4 of the M3-03 exit reconciliation. Implementation is on \`feature/m3-03-agenda-10-conflicts-rollback\`.

The candidate adds persisted conflict/candidate records, pairwise valid-time overlap evaluation that retains recorded-time provenance without selecting a winner, candidate-specific human adjudication linkage and independent resolution, and a separate prior-approved-snapshot rollback record with current-policy rechecks and outbox-driven projection. Synthetic tests cover overlap/non-overlap, recorded-time conflict, candidate preservation, human resolution, automated-action denial, audit atomicity, rollback idempotency, projection and authorization recheck.

The detailed scope and implementation record is \`M3-03_AGENDA_10_PERSISTED_CONFLICT_LIFECYCLE_TEMPORAL_EVALUATION_AND_ROLLBACK.md\`. Exact-head PHP 8.5 foundation CI, Project documentation validation, review reconciliation and expected-head merge remain pending. Agenda 10 is not yet closed.

This closes the implementation design for reconciliation gaps G-01 through G-03 if exact-head tests pass. G-04 — full deterministic oracle traceability — remains a separate evidence task. M3-03 remains **IN PROGRESS** and M3-04 Provider Management remains blocked pending full M3-03 exit acceptance. No production, V1, Hostinger, real/source data, external services/AI, public endpoints, deployment or spend is included.


## M3-03 Agenda 10 — completed bounded persisted conflict and rollback implementation (2026-11-14)

Agenda 10 is **COMPLETED** for its explicitly authorized synthetic local/CI scope. Implementation PR [#170](https://github.com/mattari20/listing-v2/pull/170) merged as \`1a4f37303913163a4866f660c469078802a7a4ed\` from exact validated head \`390bead3f28ccc64520d92b7c636455c08fd93a4\`.

Exact-head FND-01 PHP 8.5 foundation CI [#43531770613](https://github.com/mattari20/listing-v2/actions/runs/43531770613) and Project documentation validation [#43531770710](https://github.com/mattari20/listing-v2/actions/runs/43531770710) passed. The synthetic suite reported 209 assertions with no failures and 50 non-fatal missing-local-\`.env\` warnings. No review threads or review submissions were present; merge used the expected-head SHA guard.

Delivered first-class persisted conflict/candidate lifecycle, pairwise valid-time conflict evaluation with recorded-time provenance and no automatic winner, candidate-specific human adjudication and independent resolution, and distinct prior-approved-snapshot rollback with audit/outbox lineage and current-policy rechecks. The existing synthetic authorization fixture was extended by one day to avoid a midnight expiry in CI; application policy was not changed.

Authoritative record: [M3-03 Agenda 10 Completion and Evidence Record](M3-03_AGENDA_10_COMPLETION_AND_EVIDENCE_RECORD.md).

Agenda 10 closes reconciliation gaps G-01, G-02 and G-03 for the bounded scope. G-04 deterministic-oracle traceability remains open. M3-03 remains **IN PROGRESS** and M3-04 Provider Management remains blocked until the complete M3-03 exit evidence is accepted. No production, source data, external service/AI, public endpoint, deployment or spend is included.


## M3-03 G-04 — deterministic oracle traceability reconciliation (2026-11-14)

The G-04 traceability record is delivered in [M3-03 G-04 Deterministic Oracle Traceability Reconciliation](M3-03_G04_DETERMINISTIC_ORACLE_TRACEABILITY_RECONCILIATION.md). It maps all T-001–T-032 and GS-001–GS-032 to exact runtime test methods/assertion groups or explicit partial/deferred dispositions. The matrix distinguishes policy-only assertions from persisted workflows and identifies remaining deferred model/publication/identity/offer/fee behaviors.

**Status:** traceability deliverable prepared; Product Owner acceptance pending. G-01–G-03 remain closed for bounded synthetic scope. M3-03 remains **IN PROGRESS** until the owner reviews the G-04 dispositions and the final step-level exit evidence. M3-04 Provider Management remains blocked/not started. No application code, test behavior, M3-04 work, production, source access, external service/AI, deployment or spend is authorized by this documentation reconciliation.


### G-04 final delivery evidence

PR [#172](https://github.com/mattari20/listing-v2/pull/172) merged as `f8d9613eec6dca8356b0780ea871245104365736` from exact validated head `0f6f8a961133d1cf3bac5a4f1e0a62b228114c85`. Exact-head Project documentation validation run #43533801162 and PHP 8.5 foundation CI run #43533801164 both passed. The unchanged synthetic suite reported 209 assertions, no failures and 50 non-fatal missing-local-`.env` warnings. Review threads and submissions were absent; expected-head merge guard used.

G-04 traceability is delivered and merged. Product Owner acceptance and final M3-03 exit acceptance remain pending; M3-04 remains blocked/not started.
