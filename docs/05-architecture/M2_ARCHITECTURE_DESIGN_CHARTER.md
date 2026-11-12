# M2 Architecture and Design Charter

**Owner authorization:** 2026-11-12  
**Status:** Active — documentation and design only  
**Baseline:** M0 accepted; M1-S01 through M1-S10 accepted and closed  
**Repository:** `mattari20/listing-v2`

## Purpose and outcome
Translate the accepted M1 student, provider, rights, source research, AI workflow, comparison and trust baseline into a coherent, evidence-based technical blueprint and sequenced M3 implementation plan.

## Goals
- Define system requirements, actors, boundaries and measurable quality scenarios.
- Design conceptual domain and information relationships, including identity, affiliation, status and temporal semantics.
- Define application modules, interfaces, data ownership and important runtime flows.
- Evaluate technology options and costs transparently.
- Design source provenance, rights gates, validation, human review and publication controls.
- Design discovery, search, maps, comparison, AI workflow, identity, authorization, reviews, privacy and security.
- Define operational, performance, backup and recovery requirements.
- Produce a traceable M3 roadmap.

## Non-goals
No application implementation, physical schema/migrations, production access, source retrieval or ingestion, external connector/agent activation, procurement, participant research, pre-launch reviews, deployment or URL cutover.

## Authoritative inputs
Use accepted V2 documentation under `docs/01-product`, `docs/02-data-strategy`, `docs/03-research` and the Decision Register. M1 final acceptance is `../03-research/M1_S10_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`; final synthesis and G01-G20 are `../03-research/M1_S10_FINAL_SYNTHESIS_CLOSEOUT_REVIEW_2026-11-12.md`.

Legacy V1 code, schemas, architecture, data, workflows, fixes and operational practices are excluded as design inputs.

## Documentation method
- C4 views for system context, containers and selected complex components/runtime interactions.
- arc42-inspired organization for goals, constraints, context, solution structure, runtime, deployment, cross-cutting concepts, quality goals and risks.
- Text-based, version-controlled diagrams.
- ADRs for consequential, expensive-to-reverse or high-risk decisions.
- Traceability from requirement to architecture element, decision, risk/control and future verification.

This method does not preselect an application stack or service topology.

## Decision status
Researching; Proposed; Accepted for M2 baseline; Approved for implementation; Deferred; Rejected; Superseded. Document merge does not equal owner approval.

## Binding M1 constraints
- Deeni Madaris remain in underlying provider scope; **Show Deeni Madaris defaults OFF**. While OFF, exclude from public search, browse, maps, recommendations, counts, sitemaps, exports and public APIs. Retain records and provenance. No sect/maslak discovery filters, ratings or profiling.
- Unapproved source families and third-party software/datasets remain RESEARCH ONLY. Public accessibility is not permission.
- No scraping, bulk download, ingestion, source-owner contact, permission request or connector activation.
- AI output is a proposal, never evidence or publication authority. High-impact facts require authoritative evidence and human review; preserve conflicts/history.
- Primary participant research remains deferred during construction. Reviews remain post-launch; login alone is not proof of attendance.
- No complete Pakistan-wide institution or programme census is claimed.
- Carry forward all M1 G01-G20 limitations and decisions.

## Separate approval gates
Explicit approval is required for material scope changes, new spend/procurement, final technology choices with significant lock-in or external commitments, source access/reuse/ingestion, changes to adopted owner decisions, production access, database changes, deployment, cutover and release.

## M2 completion
M2 closes only after S00-S10 are evidenced, views and decisions are consistent, all carried-forward gaps have dispositions, security/privacy/rights controls are testable, the M3 roadmap is complete and the owner explicitly accepts the architecture. M3 implementation remains gated until that acceptance.
