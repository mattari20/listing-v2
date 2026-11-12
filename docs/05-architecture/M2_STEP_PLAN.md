# M2 Step Plan — Architecture and Design

**Status:** Owner-authorized and active (2026-11-12). **Scope:** Documentation/design only.

## Outcome
A coherent architecture blueprint and sequenced M3 roadmap. A merge is delivery evidence, not automatic owner acceptance.

## Steps and weights (total 100%)

| Step | Scope | Weight | Dependencies |
|---|---|---:|---|
| M2-S00 | Baseline reconciliation and architecture documentation controls | 5% | M1 accepted |
| M2-S01 | System requirements and architecture boundaries | 8% | S00 |
| M2-S02 | Core domain and conceptual information model | 12% | S01 |
| M2-S03 | Overall application and integration architecture | 12% | S01-S02 |
| M2-S04 | Technology stack evaluation | 10% | S01-S03 |
| M2-S05 | Data architecture, provenance and publication governance | 12% | S02-S04 |
| M2-S06 | Search, discovery and geography architecture | 8% | S02-S04 |
| M2-S07 | AI data-agent technical architecture | 10% | S03-S05 |
| M2-S08 | Identity, authorization, reviews, privacy and security | 10% | S01-S07 |
| M2-S09 | Performance, operations, hosting and recovery design | 6% | S03-S08 |
| M2-S10 | Architecture validation, final synthesis and owner acceptance | 7% | S00-S09 |

## Task breakdown and exit evidence

Each step's task weights total 100%.

| Step | Task allocation | Exit evidence |
|---|---|---|
| S00 | T01 baseline verification 20%; T02 status reconciliation 20%; T03 charter/plan 20%; T04 documentation/ADR/traceability structure 20%; T05 CI and PR evidence 20% | Current controls reconciled; charter, plan, index, templates and traceability scaffold; exact-head CI passes |
| S01 | T01 requirement inventory 20%; T02 actors/context 20%; T03 functional/quality scenarios 20%; T04 constraints/trust boundaries 20%; T05 review 20% | Stable architecture requirements, context and measurable scenarios |
| S02 | T01 glossary 15%; T02 entity/relationship model 25%; T03 identity/deduplication/affiliation 20%; T04 lifecycle/temporal semantics 20%; T05 review 20% | Conceptual domain model, glossary and edge-case rules |
| S03 | T01 context view 15%; T02 container view 25%; T03 component boundaries 25%; T04 runtime/failure scenarios 20%; T05 review 15% | System/container/component/runtime architecture views |
| S04 | T01 criteria 15%; T02 backend/frontend 20%; T03 data/search/maps/async options 25%; T04 hosting/cost/operability 20%; T05 recommendation/owner decision 20% | Sourced options matrix and explicit recommendation/approval status |
| S05 | T01 data domains 20%; T02 provenance 25%; T03 rights/retention/privacy 15%; T04 validation/publication/conflict/rollback 25%; T05 review 15% | Conceptual data lifecycle and governed evidence/publication model |
| S06 | T01 discovery capabilities 20%; T02 geo quality/privacy 20%; T03 indexing/freshness/relevance 20%; T04 Deeni Madaris enforcement 25%; T05 review 15% | Search/map architecture and default-OFF negative requirements |
| S07 | T01 12-stage mapping 20%; T02 source/connector authorization 20%; T03 extraction/validation/entity resolution 20%; T04 human review/publication/rollback 25%; T05 threat/cost/failure 15% | Governed AI data-agent technical design |
| S08 | T01 identity 15%; T02 authorization 20%; T03 reviews/moderation 20%; T04 privacy/minors/safeguarding 25%; T05 security validation 20% | Identity, role/action, review, privacy and threat architecture |
| S09 | T01 quality/capacity 20%; T02 environments/deployment 20%; T03 observability 20%; T04 backup/recovery 25%; T05 cost/operations 15% | Measurable operations, resilience and cost design |
| S10 | T01 traceability audit 20%; T02 consistency/threat review 20%; T03 ADR/risk audit 20%; T04 M3 roadmap 20%; T05 owner acceptance 20% | Final architecture package and explicit M2 owner acceptance |

## Five work packages
- WP1: S00-S01 — baseline and system requirements.
- WP2: S02-S03 — domain and system architecture.
- WP3: S04-S05 — technology and data architecture.
- WP4: S06-S08 — discovery, AI, identity and security.
- WP5: S09-S10 — operations, validation and acceptance.

Parallelize independent research, but consolidate decisions centrally. Batch related docs into coherent PRs. Do not reopen accepted M1 research without a specific correction. Keep unresolved low-impact choices visible rather than blocking unrelated work.

## Hard boundaries
No application code, physical schema/migrations, production access, source collection/ingestion, connector/agent activation, procurement/new spend, deployment, participant research or pre-launch review collection. No legacy V1 materials may inform design.

## Completion gate
All step evidence complete; all M1 requirements and G01-G20 disposed; architecture/data/security/operations views consistent; consequential choices recorded; traceability gaps explained; M3 roadmap ready; explicit owner acceptance recorded. M3 implementation cannot start before acceptance.


**M2-S00 closeout:** 100% task completion. PR [#85](https://github.com/mattari20/listing-v2/pull/85) merged as `17a2e3ad43ba1fd5ca3cb7a163670a2f19dd3783`; exact-head required documentation validation passed (run [#43180488082](https://github.com/mattari20/listing-v2/actions/runs/43180488082)). Next step: M2-S01.


## M2-S01 task progress — 2026-11-12

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| S01-T01 Requirement inventory and stable identifiers | 20% | AR-001–AR-025 introduced and linked to SR-01–SR-14 / M1 decisions | Complete — draft |
| S01-T02 Actors, capabilities and system context | 20% | Actor matrix, boundary definition and context diagram | Complete — draft |
| S01-T03 Functional and quality requirements | 20% | 25 architecture requirements and 20 quality scenarios | Complete — draft |
| S01-T04 Constraints, exclusions and trust boundaries | 20% | Rights, privacy, minor, source, production, V1 and Deeni Madaris controls mapped | Complete — draft |
| S01-T05 Owner/design review and S01 completion | 20% | Cross-document review, exact-head CI and delivery evidence | Pending |

**Current S01 task completion:** 80% (four of five equal-weight tasks drafted; review/validation remains). This is task progress, not S01 acceptance.


### M2-S01 delivery and validation evidence — 2026-11-12

PR [#87](https://github.com/mattari20/listing-v2/pull/87) merged as `a9a8320dadc339cb15c7d75ac430301941abbd57`. Exact PR head `b759e08e9e4c0ae3c9bdaf9e449e7da751d7b80f` passed required Project documentation validation (run [#43181003815](https://github.com/mattari20/listing-v2/actions/runs/43181003815)). T01-T04 are drafted (80%); T05 validation passed, but explicit owner review remains pending. **S01 remains In Progress at 80%, not accepted.**


## PR #88 delivery reconciliation — 2026-11-12

PR [#88](https://github.com/mattari20/listing-v2/pull/88) reconciled the M2-S01 draft delivery and owner-review status. Exact PR head `9d05c8f4b35462b935886b78f4aa9aa45c770dc3` passed required Project documentation validation (run [#43181135205](https://github.com/mattari20/listing-v2/actions/runs/43181135205)); PR #88 merged as `226f573d21a03b51caa4ccb46f2a68293fb84be2`. M2-S01 remains 80% and In Progress pending explicit owner review; CI success and merge are not acceptance.


## PR #89 delivery reconciliation — 2026-11-12

PR [#89](https://github.com/mattari20/listing-v2/pull/89) reconciled PR #88's exact-head validation and merge evidence. Exact PR head `5c038bb8d4662acc590121bf87723a89127ab5b6` passed required Project documentation validation (run [#43181267319](https://github.com/mattari20/listing-v2/actions/runs/43181267319)); PR #89 merged as `a119514862b74d4ec8135409375dc7960f924e2a`. M2-S01 remains 80% and In Progress pending owner review; no acceptance is implied.


## M2-S01 owner acceptance — 2026-11-12

The owner explicitly accepted the system requirements, actors, boundaries and quality scenarios as the working baseline. Formal record: [M2-S01 Owner Acceptance Record](M2-S01_OWNER_ACCEPTANCE_RECORD_2026-11-12.md). S01-T05 is complete; S01 is Accepted and Closed at 100%. Acceptance does not approve the proposed WCAG 2.2 AA target, numeric SLOs, stack, vendor or implementation.

## M2-S02 / M2-S03 joint work package — 2026-11-12

S02 and S03 were authored as a coordinated documentation package while retaining separate step weights, task evidence and acceptance gates.

### S02 task progress

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Domain glossary | 15% | M2-S02 section 2 | Complete — draft |
| T02 Entity and relationship model | 25% | M2-S02 section 3 and conceptual ER view | Complete — draft |
| T03 Identity, deduplication and affiliation | 20% | M2-S02 section 4 and relationship rules | Complete — draft |
| T04 Lifecycle and temporal semantics | 20% | M2-S02 sections 5–7 | Complete — draft |
| T05 Review and validation | 20% | Joint cross-step validation; owner review pending | Pending |

**S02 draft task completion: 80%.** S02 owner acceptance remains pending.

### S03 task progress

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Context view | 15% | M2-S03 section 2 | Complete — draft |
| T02 Logical container view | 25% | M2-S03 section 3 | Complete — draft |
| T03 Component boundaries | 25% | M2-S03 section 4 | Complete — draft |
| T04 Runtime and failure scenarios | 20% | M2-S03 sections 6–8 | Complete — draft |
| T05 Review and validation | 15% | Joint cross-step validation; owner review pending | Pending |

**S03 draft task completion: 85%.** S03 owner acceptance remains pending.

### Joint package boundary

The package does not choose a monolith/modular monolith/services, framework, language, database, queue, search engine, map provider, identity vendor, AI provider, hosting provider or deployment topology. These remain for S04/S07/S09 and explicit owner decisions. No physical schema, API implementation, production access, source retrieval/ingestion, connector activation or deployment is authorized.

Owner review checklist and decision request: [M2-S02/S03 Joint Validation and Owner Review](M2-S02-S03_JOINT_VALIDATION_AND_OWNER_REVIEW.md).


## PR #91 exact-head validation and merge evidence — 2026-11-12

PR [#91](https://github.com/mattari20/listing-v2/pull/91) delivered the M2-S01 owner-acceptance record and coordinated M2-S02/S03 documentation package. Exact PR head `7a58f7ddb93cd693874e7debd3fa730b5db1d1ea` passed the required **Project documentation validation** workflow (run [#43188475213](https://github.com/mattari20/listing-v2/actions/runs/43188475213)); the `Validate project control documents` job and all steps completed successfully. PR #91 was squash-merged as `0881719c3b0d98893dc0e88a9c4f929cae89aea1`.

S01 is Accepted and Closed at 100%. S02 is delivered at 80% draft task completion and S03 at 85%; their T05 owner-review gates remain open. Merge and CI evidence confirm delivery and documentation validation, not owner acceptance of S02/S03. M2 weighted progress remains 32.8%.



## Authoritative update — S02/S03 accepted and closed; S04/S05/S06 jointly active — 2026-11-12

The owner explicitly accepted the S02 conceptual domain model and S03 logical application/integration architecture and directed both steps to close. Formal record: [M2-S02/S03 Owner Acceptance Record](M2-S02-S03_OWNER_ACCEPTANCE_RECORD_2026-11-12.md). S02-T05 and S03-T05 are complete; **S02 and S03 are Accepted and Closed at 100% each**. Their conceptual/technology-neutral qualifications remain binding.

The owner authorized the next coordinated documentation work package: S04 Technology Stack Evaluation, S05 Data Architecture/Provenance/Publication Governance and S06 Search/Discovery/Geography Architecture. They are authored jointly for consistency but retain separate task weights and owner-acceptance gates.

### S04 task progress (10% M2 weight)

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Evaluation criteria | 15% | S04 section 2 | Complete — draft |
| T02 Backend/frontend options | 20% | S04 sections 3–4 | Complete — draft |
| T03 Data/search/maps/async options | 25% | S04 sections 5–6 | Complete — draft |
| T04 Hosting/cost/operability | 20% | S04 section 8 | Complete — draft |
| T05 Recommendation/owner decision | 20% | S04 section 9; owner decision pending | Pending |

**S04 draft task completion: 80%.** No technology/vendor/hosting choice is approved. The recommendation is conditional and requires team-skill, hosting and cost evidence plus explicit owner decision.

### S05 task progress (12% M2 weight)

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Data domains | 20% | S05 section 2 | Complete — draft |
| T02 Provenance | 25% | S05 section 3 | Complete — draft |
| T03 Rights/retention/privacy | 15% | S05 section 4 | Complete — draft |
| T04 Validation/publication/conflict/rollback | 25% | S05 sections 5–7 | Complete — draft |
| T05 Review | 15% | Joint consistency and owner review pending | Pending |

**S05 draft task completion: 85%.** No source access, copying, collection, ingestion or reuse is authorized.

### S06 task progress (8% M2 weight)

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Discovery capabilities | 20% | S06 section 2 | Complete — draft |
| T02 Geo quality/privacy | 20% | S06 sections 6–7 | Complete — draft |
| T03 Indexing/freshness/relevance | 20% | S06 sections 3–5 and 9 | Complete — draft |
| T04 Deeni Madaris enforcement | 25% | S06 section 8 | Complete — draft |
| T05 Review | 15% | Joint consistency and owner review pending | Pending |

**S06 draft task completion: 85%.** V2-DEC-006 remains binding and the negative test requirements cover every public surface and side channel.

### Joint package and current weighted progress

Deliverables: M2-S04_TECHNOLOGY_STACK_EVALUATION.md, M2-S05_DATA_ARCHITECTURE_PROVENANCE_PUBLICATION.md, M2-S06_SEARCH_DISCOVERY_GEOGRAPHY_ARCHITECTURE.md, and M2-S04-S06_JOINT_VALIDATION_AND_OWNER_REVIEW.md.

Weighted M2 progress: S00 5% + S01 8% + S02 12% + S03 12% + S04 8% + S05 10.2% + S06 6.8% = **62.0%**. S04/S05/S06 are delivered drafts, not accepted/closed. Owner review is pending.

The S04 evaluation compares Laravel 13, Django 6.1 and NestJS/Node 26, HTML-first versus React SSR/partial enhancement, PostgreSQL/MySQL/MariaDB, database-native search/Meilisearch/OpenSearch, and map/geocoder boundaries. The modular-monolith, HTML-first and PostgreSQL/PostGIS directions are conditional recommendations only. No procurement or implementation approval is implied.


## PR #93 exact-head validation and merge evidence — 2026-11-12

PR [#93](https://github.com/mattari20/listing-v2/pull/93) recorded the owner's acceptance and closure of S02/S03 and delivered the coordinated S04/S05/S06 architecture documentation. Exact PR head `17a77885eca53fd1a8c8d3d516f26741d10fc39a` passed required **Project documentation validation** (workflow run [#43189688854](https://github.com/mattari20/listing-v2/actions/runs/43189688854)); job `Validate project control documents` and all steps completed successfully. PR #93 was squash-merged as `4a100030a2ea491b0061ac80a543f723b03fdea4`.

S02 and S03 are Accepted and Closed at 100%. S04 remains 80%, S05 85% and S06 85% pending their separate owner-review/decision gates. Weighted M2 progress is 62.0%. CI and merge establish delivery and documentation validation, not owner acceptance of S04-S06.


## PR #94 exact-head validation and merge evidence — 2026-11-12

PR [#94](https://github.com/mattari20/listing-v2/pull/94) reconciled PR #93 delivery. Exact PR head `9c369a4a6f5b78d794feb2e38d9c4afd1b4875e8` passed required **Project documentation validation** (workflow run [#43189848614](https://github.com/mattari20/listing-v2/actions/runs/43189848614)); job `Validate project control documents` and all steps completed successfully. PR #94 was squash-merged as `0a5f65258ea04c52b8e79b314f7cda04c8d3e65c`.

This reconciliation confirms PR #93's merge evidence and does not alter content acceptance: S02/S03 remain accepted/closed; S04 80%, S05 85% and S06 85% remain owner-review/decision pending. Weighted M2 progress remains 62.0%.

## M2 owner acceptance and S07-S10 delivery status — 2026-11-12

### S04/S05/S06 accepted and closed
The owner accepted S04 technology evaluation, S05 data/provenance/publication governance and S06 search/discovery/geography baselines as working design documents. Formal record: [M2-S04/S05/S06 Owner Acceptance Record](M2-S04-S06_OWNER_ACCEPTANCE_RECORD_2026-11-12.md). T05 review gates are complete for the accepted scope. S04, S05 and S06 are Accepted and Closed at 100% each. Unresolved stack/vendor, legal, operational, ranking, hosting and provider decisions remain open; acceptance is not procurement or implementation approval.

### S07 — AI data-agent technical architecture (10% M2 weight)
Deliverable: [M2-S07 AI Data-Agent Technical Architecture](M2-S07_AI_DATA_AGENT_TECHNICAL_ARCHITECTURE.md). T01-T04 drafted: 12-stage workflow, source authorization, extraction/validation/entity resolution, human review/publication/rollback. T05 threat/cost/failure and cross-step design review complete; see [S07-S09 Joint Architecture Validation](M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md). S07 design tasks are 100% complete; final M2 owner acceptance remains pending. No agent, connector, model or source is activated.

### S08 — Identity, authorization, reviews, privacy and security (10% M2 weight)
Deliverable: [M2-S08 Identity, Authorization, Reviews, Privacy and Security](M2-S08_IDENTITY_AUTHORIZATION_REVIEWS_PRIVACY_SECURITY.md). T01-T04 drafted: identity, scoped authorization, post-launch reviews/moderation, privacy/minors/safeguarding. T05 security and cross-step design review complete; see [S07-S09 Joint Architecture Validation](M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md). S08 design tasks are 100% complete; legal and policy gates remain open for M3. No identity provider, review collection, legal compliance claim or production control is approved.

### S09 — Performance, operations, hosting and recovery (6% M2 weight)
Deliverable: [M2-S09 Performance, Operations, Hosting and Recovery](M2-S09_PERFORMANCE_OPERATIONS_HOSTING_RECOVERY.md). T01-T04 drafted: quality/capacity, environment/release boundaries, observability/incident design, backup/recovery. T05 cost/operations design review complete with evidence limitations recorded; see [S07-S09 Joint Architecture Validation](M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md). S09 design tasks are 100% complete; provider quotes, workload tests and owner approval remain deferred. Proposed availability, latency, payload, RPO/RTO and freshness values are hypotheses, not approved SLOs. No hosting vendor or spend is selected.

### S10 — Final architecture validation, synthesis and owner acceptance (7% M2 weight)
Deliverable: [M2-S10 Final Architecture Synthesis and M3 Roadmap](M2-S10_FINAL_ARCHITECTURE_SYNTHESIS_M3_ROADMAP.md). T01-T04 drafted: traceability audit, consistency/threat review, ADR/risk disposition and conditional M3 roadmap. T05 explicit final owner acceptance pending. Draft completion: 80%; S10 cannot self-accept the architecture.

### Weighted progress
S00 100% (5.0) + S01 100% (8.0) + S02 100% (12.0) + S03 100% (12.0) + S04 100% (10.0) + S05 100% (12.0) + S06 100% (8.0) + S07 100% (10.0) + S08 100% (10.0) + S09 100% (6.0) + S10 80% (5.6) = **98.6% weighted M2 draft progress**.

M2 is not closed. Remaining work is task-level validation/reconciliation and explicit owner acceptance of S07-S10 and the integrated S10 package. Application implementation remains prohibited until M2 final acceptance and separate M3 authorization.


### S07-S09 design validation closeout — 2026-11-12

The joint design-level review is recorded in [M2-S07/S08/S09 Joint Architecture Validation](M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md). S07 T05 threat/cost/failure review, S08 T05 security/cross-step review and S09 T05 cost/operations review are complete as documentation tasks. S07, S08 and S09 are each 100% design-complete. This does not constitute M2 owner acceptance, legal review, live security testing, performance testing, restore testing, procurement or activation.

## PR #96 exact-head validation and merge evidence — 2026-11-12

PR [#96](https://github.com/mattari20/listing-v2/pull/96) delivered the S04-S06 owner acceptance record, S07-S10 architecture package and project-control reconciliation. Exact PR head 0ffa6b4ecad567457af79a4846dd1a03d41af954 passed the required **Project documentation validation** workflow (run [#43191493502](https://github.com/mattari20/listing-v2/actions/runs/43191493502)); the Validate project control documents job and all steps completed successfully. PR #96 was squash-merged as 3df10565711e66ff21bb6afb3a7917bf5deb7e99.

S04-S06 are accepted/closed at 100%; S07-S09 design tasks are complete at 100%; S10 remains 80% pending explicit final owner acceptance. Weighted M2 design progress is 98.6%. CI and merge verify delivery and documentation validation, not final M2 owner acceptance or M3 implementation authorization.
