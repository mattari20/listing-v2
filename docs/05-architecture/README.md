# Architecture Documentation Index

M2 architecture and design documentation. Documentation-only until M2 is separately accepted.

## Governing documents
- [M2 Charter](M2_ARCHITECTURE_DESIGN_CHARTER.md)
- [M2 Step Plan](M2_STEP_PLAN.md)
- [Architecture Documentation Plan](M2_ARCHITECTURE_DOCUMENTATION_PLAN.md)
- [Requirements-to-Architecture Traceability](M2_REQUIREMENTS_ARCHITECTURE_TRACEABILITY.md)
- [Architecture Decision Register](M2_ARCHITECTURE_DECISION_REGISTER.md)
- [ADR Template](decisions/ADR_TEMPLATE.md)
- [Diagram Conventions](diagrams/README.md)

## Planned artifacts
| Artifact | Step | Status |
|---|---|---|
| System context, actors, capabilities and quality scenarios | S01 | Accepted and closed |
| Domain glossary and conceptual model | S02 | Accepted and closed |
| C4 context/container, components and runtime views | S03 | Accepted and closed |
| Technology options and conditional recommendation | S04 | Delivered — owner decision pending |
| Data provenance and publication model | S05 | Delivered — owner review pending |
| Search, maps and geospatial design | S06 | Delivered — owner review pending |
| AI data-agent architecture | S07 | Planned |
| Identity, reviews, privacy and security | S08 | Planned |
| Operations, deployment and recovery design | S09 | Planned |
| Final synthesis and M3 roadmap | S10 | Planned |

Keep decisions in ADRs, link stable requirement IDs, and update this index and project catalogue as artifacts evolve. A proposal or merged document is not automatically an approved implementation choice.


## M2-S01 deliverables — system requirements and boundaries
- [System Requirements and Architecture Boundaries](M2-S01_SYSTEM_REQUIREMENTS_AND_BOUNDARIES.md) — architecture-level AR-001–AR-025 requirements, actors, boundaries, constraints and S01 acceptance criteria.
- [System Context and Capability Boundary](M2-S01_SYSTEM_CONTEXT.md) — logical context view, trust boundaries and explicit candidate-only external relationships.
- [Quality Attribute Scenarios and Targets](M2-S01_QUALITY_SCENARIOS.md) — 20 quality scenarios, proposed accessibility baseline and targets deferred to S09 where scale/cost evidence is needed.


## M2-S01 owner acceptance — 2026-11-12

- [M2-S01 Owner Acceptance Record](M2-S01_OWNER_ACCEPTANCE_RECORD_2026-11-12.md) — owner accepted AR-001–AR-025, actors, system boundaries and quality scenarios as the working baseline. WCAG target, numeric service targets, stack and implementation remain unapproved.

## M2-S02 / M2-S03 joint documentation package — 2026-11-12

- [M2-S02 Core Domain and Conceptual Information Model](M2-S02_CORE_DOMAIN_CONCEPTUAL_MODEL.md) — glossary, conceptual relationships, identity/deduplication, affiliation/recognition, temporal semantics, lifecycle and uncertainty.
- [M2-S03 Overall Application and Integration Architecture](M2-S03_APPLICATION_INTEGRATION_ARCHITECTURE.md) — context/container/component/runtime/failure views, logical boundaries and deny-by-default integration gates.
- [M2-S02/S03 Joint Validation and Owner Review](M2-S02-S03_JOINT_VALIDATION_AND_OWNER_REVIEW.md) — separate task evidence, cross-step consistency and owner review checklist.

S02 and S03 are delivered as coordinated drafts. Owner review and acceptance remain pending; do not treat merge or CI as acceptance. No stack, physical schema, API, vendor or deployment topology is selected.


## M2-S02/S03 owner acceptance — 2026-11-12

- [M2-S02/S03 Owner Acceptance Record](M2-S02-S03_OWNER_ACCEPTANCE_RECORD_2026-11-12.md) — owner accepted both conceptual/logical baselines; S02 and S03 closed at 100%.

## M2-S04/S05/S06 joint documentation package — 2026-11-12

- [S04 Technology Stack Evaluation](M2-S04_TECHNOLOGY_STACK_EVALUATION.md) — sourced options and conditional recommendation; no stack selected.
- [S05 Data Architecture, Provenance and Publication Governance](M2-S05_DATA_ARCHITECTURE_PROVENANCE_PUBLICATION.md) — logical data domains, rights gates, lineage, validation, publication and rollback.
- [S06 Search, Discovery and Geography Architecture](M2-S06_SEARCH_DISCOVERY_GEOGRAPHY_ARCHITECTURE.md) — search pipeline, projections, maps, geospatial privacy and Deeni Madaris negative requirements.
- [S04/S05/S06 Joint Validation and Owner Review](M2-S04-S06_JOINT_VALIDATION_AND_OWNER_REVIEW.md) — separate task progress, cross-step checks and owner review checklist.

S04 is 80%, S05 85%, S06 85% drafted. Owner review and S04 consequential choice decisions remain pending. These deliverables do not approve procurement, source access, implementation or deployment.

## M2-S04/S05/S06 owner acceptance — 2026-11-12

- [M2-S04/S05/S06 Owner Acceptance Record](M2-S04-S06_OWNER_ACCEPTANCE_RECORD_2026-11-12.md) — accepted as working architecture baselines; S04-S06 are Accepted and Closed at 100%, with unresolved technology, vendor, legal, operational and ranking decisions carried forward.

## M2-S07 through M2-S10 documentation package — 2026-11-12

- [M2-S07 AI Data-Agent Technical Architecture](M2-S07_AI_DATA_AGENT_TECHNICAL_ARCHITECTURE.md) — twelve-stage evidence workflow, source authorization, quarantine, extraction, validation, entity resolution, human review, publication, threat and failure controls.
- [M2-S08 Identity, Authorization, Reviews, Privacy and Security](M2-S08_IDENTITY_AUTHORIZATION_REVIEWS_PRIVACY_SECURITY.md) — identity classes, scoped authorization, review/moderation, minors' safeguarding, privacy and security validation.
- [M2-S09 Performance, Operations, Hosting and Recovery](M2-S09_PERFORMANCE_OPERATIONS_HOSTING_RECOVERY.md) — provisional quality targets, environments, observability, resilience, hosting evaluation and restore design.
- [M2-S10 Final Architecture Synthesis and M3 Roadmap](M2-S10_FINAL_ARCHITECTURE_SYNTHESIS_M3_ROADMAP.md) — integrated invariants, decision gates, validation and conditional M3 sequence.

S07-S10 are documentation drafts pending task-level validation and owner review. M3 implementation remains gated until explicit final M2 acceptance and separate M3 authorization.


- [M2-S07/S08/S09 Joint Architecture Validation](M2-S07-S09_JOINT_ARCHITECTURE_VALIDATION.md) — cross-step threat/failure review, design task closure and explicit operational evidence limitations.
- [M2 Progress Report](M2_PROGRESS_REPORT.md) — weighted step status and final owner-acceptance gate.

S07, S08 and S09 are design-task complete at 100%; S10 remains 80% pending explicit final owner acceptance. Weighted M2 design progress is 98.6%.
