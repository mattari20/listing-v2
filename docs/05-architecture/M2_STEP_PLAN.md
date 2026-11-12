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
