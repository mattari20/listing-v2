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
| System context, actors, capabilities and quality scenarios | S01 | Planned |
| Domain glossary and conceptual model | S02 | Planned |
| C4 context/container, components and runtime views | S03 | Planned |
| Technology options and recommendation | S04 | Planned |
| Data provenance and publication model | S05 | Planned |
| Search, maps and geospatial design | S06 | Planned |
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
