# Documentation Completion Catalogue

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Baseline:** PR #1 merged into `main`  
**Baseline merge commit:** `0f2165f3d18e43f10cf6d6f717f145d3433769a4`  
**M0 closeout merge commit:** `4d1122d182961f3842803036f917ce39cd11b4c6`  
**Last reconciled:** 2026-11-11

## Purpose and maintenance rule

This is the owner-facing record of documentation delivered, reviewed, accepted and still outstanding. It is updated on every documentation PR update and merge. A file being present or a PR being merged means it was delivered; it does not automatically mean its content has passed final acceptance.

For every PR update:
1. Reconcile the changed documentation files against this catalogue.
2. Record the PR number, branch, current head SHA, CI result and review state.
3. Mark changed items as `Updated — review pending` until reviewed.
4. Do not mark an item `Accepted` without checking its acceptance criteria and evidence.

For every merge:
1. Record the PR number, merge commit SHA and successful required check(s).
2. Update each affected document's status and the catalogue's PR history.
3. Reconcile the documentation index, master controller, step register, traceability and progress report.
4. Recalculate progress only from defined weighted tasks and accepted evidence.

## Status definitions

- **Delivered — review pending:** file exists in the default branch; content-level acceptance has not yet been recorded.
- **Updated — review pending:** changed in an open or newly updated PR; review is outstanding.
- **Accepted:** content and its stated acceptance criteria have been reviewed and evidence recorded.
- **Planned:** required documentation has not yet been created.
- **Not required:** explicitly excluded by an approved V2 decision.

## Current documentation inventory

### A. Foundation and governance

| Document | Purpose | Status |
|---|---|---|
| [Project Master Control](../00-foundation/PROJECT_MASTER_CONTROL.md) | Authoritative project state, boundaries and session operating rules | Accepted — M0 closeout |
| [Project Constitution](../00-foundation/PROJECT_CONSTITUTION.md) | V2 principles, independence and non-interference commitments | Accepted — M0 closeout |
| [AI Execution Protocol](../00-foundation/AI_EXECUTION_PROTOCOL.md) | AI autonomy, authorization and execution boundaries | Accepted — M0 closeout |
| [Engineering Standards](../00-foundation/ENGINEERING_STANDARDS.md) | V2 engineering quality and delivery standards | Accepted — M0 baseline; implementation-specific details remain subject to M2 design |
| [Definition of Done](../00-foundation/DEFINITION_OF_DONE.md) | Completion and acceptance expectations | Accepted — M0 closeout |
| [Decision Register](../00-foundation/DECISION_REGISTER.md) | Durable record of approved and pending decisions | Accepted — M0 closeout |
| [Repository Governance Setup](../00-foundation/REPOSITORY_GOVERNANCE_SETUP.md) | PR, branch rules, CI and merge configuration evidence | Accepted — settings and protected-PR workflow verified; auto-merge execution not independently tested |

### B. Product requirements

| Document | Purpose | Status |
|---|---|---|
| [Product Vision and Student Journey](../01-product/PRODUCT_VISION_AND_STUDENT_JOURNEY.md) | Product purpose and student journey | Delivered — review pending |
| [Student Discovery Requirements](../01-product/STUDENT_DISCOVERY_REQUIREMENTS.md) | Student discovery needs and requirements | Delivered — review pending |
| [Institution and Programme Requirements](../01-product/INSTITUTION_AND_PROGRAMME_REQUIREMENTS.md) | Institution, campus and programme information requirements | Delivered — review pending |
| [Comparison, Reviews and Trust](../01-product/COMPARISON_REVIEWS_AND_TRUST.md) | Comparison, ratings, reviews and trust requirements | Delivered — review pending |

### C. Data strategy and rights

| Document | Purpose | Status |
|---|---|---|
| [Education Data Strategy](../02-data-strategy/EDUCATION_DATA_STRATEGY.md) | V2 education data approach | Delivered — review pending |
| [Education Data Provider Register](../02-data-strategy/EDUCATION_DATA_PROVIDER_REGISTER.md) | Candidate data-source/provider register | Delivered — research and evidence expansion pending |
| [AI Data Agent Requirements](../02-data-strategy/AI_DATA_AGENT_REQUIREMENTS.md) | Requirements for AI-assisted data collection and verification | Delivered — review pending |
| [Data Rights and Provenance](../02-data-strategy/DATA_RIGHTS_AND_PROVENANCE.md) | Source permissions, provenance and data handling principles | Delivered — review pending |

### D. Independent research and reuse

| Document | Purpose | Status |
|---|---|---|
| [Open-Source Reuse Audit](../03-research/OPEN_SOURCE_REUSE_AUDIT.md) | Independent evaluation framework for external software and datasets | Delivered — candidate research pending |
| [M1 Student Journey Research](../03-research/M1_STUDENT_JOURNEY_RESEARCH.md) | Desk-research synthesis, student segment hypotheses, journey and primary-research protocol | Accepted as initial desk-research baseline; primary research pending |
| [M1 Student Research Instruments](../03-research/M1_STUDENT_RESEARCH_INSTRUMENTS.md) | Draft adult interview guide, consent script and survey instrument | Delivered — preparation only; owner approval required before fieldwork |

### E. Roadmap, traceability and progress

| Document | Purpose | Status |
|---|---|---|
| [Master Roadmap](PROJECT_MASTER_ROADMAP.md) | M0–M12 milestone outcomes and dependencies | Accepted — M0/M1 sequencing baseline |
| [Milestone and Step Register](MILESTONE_STEP_REGISTER.md) | Numbered milestones, steps and acceptance evidence | Accepted — M0 closeout; M1 step execution pending |
| [Implementation Traceability Matrix](IMPLEMENTATION_TRACEABILITY_MATRIX.md) | Requirement-to-delivery traceability | Accepted for M0 baseline; M1 requirement evidence pending |
| [Project Progress Report](PROJECT_PROGRESS_REPORT.md) | Verified current status, blockers and next actions | Accepted — current M0 closeout state |
| [Documentation Completion Catalogue](DOCUMENTATION_CATALOG.md) | Owner-facing documentation inventory and PR-by-PR history | Accepted — M0 tracking baseline |

### F. Independence and legacy exclusion

| Document | Purpose | Status |
|---|---|---|
| [Legacy Repository Isolation Audit](../99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md) | Records the V2 exclusion boundary and limited metadata-only audit scope | Accepted — targeted metadata-only scope; non-exhaustive limitation explicit |

### G. Repository-level delivery support

| File | Purpose | Status |
|---|---|---|
| [README](../../README.md) | Repository entry point | Accepted — corrected and linked to current documentation |
| [Documentation Index](../README.md) | Navigation across V2 documentation | Accepted — M0 documentation navigation |
| [Pull Request Template](../../.github/pull_request_template.md) | Standard PR scope, safety and evidence prompts | Accepted — M0 delivery controls |
| [Task Issue Template](../../.github/ISSUE_TEMPLATE/task.yml) | Structured V2 task intake | Accepted — M0 task intake controls |
| [Documentation Validation Workflow](../../.github/workflows/project-docs-validation.yml) | Automated documentation validation on PRs | Accepted — required check passed on PRs #1–#3 latest heads |
| [Documentation Validator](../../scripts/validate_project_docs.py) | Required-file and local-link validation | Accepted — PR #4 required-check success on exact head; catalogue and governance files required |

## PR delivery history

| PR | Scope | Merge / head evidence | Status |
|---|---|---|---|
| [#1](https://github.com/mattari20/listing-v2/pull/1) | Founding documentation, V2 governance, product/data requirements, roadmap, isolation audit and repository templates/CI | Merged as `0f2165f3d18e43f10cf6d6f717f145d3433769a4`; 36 commits; 26 changed files; one required check passed | Merged |
| [#2](https://github.com/mattari20/listing-v2/pull/2) | Living documentation catalogue, index/controller/roadmap reconciliation, governance and progress updates | Merged as `975cd672378e8d30982d44d54d12e195e9c57d5d`; exact head `9ad0d3b361d6641dca2e94c3c9a52ac2fb4d1597`; required check passed ([run #43057131618](https://github.com/mattari20/listing-v2/actions/runs/43057131618)) | Merged |
| [#3](https://github.com/mattari20/listing-v2/pull/3) | Correct legacy non-interference wording, repository status and M0 workflow evidence | Merged as `035503a3c0772f7b542d2986b3fa66b3fce970d6`; exact head `6571c678a5fdeff456257a01c6fc38576367a506`; required check passed ([run #43058113045](https://github.com/mattari20/listing-v2/actions/runs/43058113045)) | Merged |
| [#4](https://github.com/mattari20/listing-v2/pull/4) | M0 acceptance and closeout; M0 statuses and validator coverage reconciliation | Merged as `4d1122d182961f3842803036f917ce39cd11b4c6`; exact head `64da261546b034129af3aebfa38fb91f939732b6`; required check passed ([run #43058607549](https://github.com/mattari20/listing-v2/actions/runs/43058607549)) | Merged |
 
| [#5](https://github.com/mattari20/listing-v2/pull/5) | Final M0 closeout merge evidence reconciliation | Merged as `e1a3da011f29f99f546b812f564869cc33d34e05`; required check passed on exact head `3365a2bae83b90b31011fa170bb77ff6389fc91c` ([run #43058850736](https://github.com/mattari20/listing-v2/actions/runs/43058850736)) | Merged |
| [#6](https://github.com/mattari20/listing-v2/pull/6) | M1-S01 desk-research synthesis, provisional student segments, journey and research protocol | Merged as `94936177012f924efe36fe29cf0dba3cba094081`; exact head `4f29050a234dbc6c4eed0968408fe89805526476`; required check passed ([run #43059386299](https://github.com/mattari20/listing-v2/actions/runs/43059386299)) | Merged |
| [#7](https://github.com/mattari20/listing-v2/pull/7) | Draft adult participant interview guide, consent script and survey; research evidence reconciliation | Merged as `bf3e1ef0054b337466884fb5a731141ce03d3ec0`; exact head `943766fee66e7dfcda46ebdd5a3d3049d02ddbba`; required check passed ([run #43059725757](https://github.com/mattari20/listing-v2/actions/runs/43059725757)) | Merged |
| [#8](https://github.com/mattari20/listing-v2/pull/8) | Reconcile PR #7 instrument delivery, task status and evidence | Merged as `612a4edfdcd43721407e01e26e79569631684c12`; exact head `552e3f60722d35a96c6d353661b561838d68b4ae`; required check passed ([run #43059961030](https://github.com/mattari20/listing-v2/actions/runs/43059961030)) | Merged |
| [#7](https://github.com/mattari20/listing-v2/pull/7) | Draft adult participant interview guide, consent script and survey; research evidence reconciliation | Merged as `bf3e1ef0054b337466884fb5a731141ce03d3ec0`; exact head `943766fee66e7dfcda46ebdd5a3d3049d02ddbba`; required check passed ([run #43059725757](https://github.com/mattari20/listing-v2/actions/runs/43059725757)) | Merged — instruments remain draft and require owner approval before fieldwork |

## Remaining documentation work

1. Review every delivered founding document against V2 owner requirements and its own acceptance criteria; record accepted items individually.
2. Expand student and institution requirements using new, independent V2 research.
3. Expand the provider register with verifiable source access, coverage, update cadence, data rights and provenance evidence.
4. Complete independent candidate research and license/security assessment before approving reuse.
5. Refine M1 acceptance and task weights only after research scope and evidence are clear.
6. Keep M2 architecture and technology decisions unapproved until M1 research is accepted.
7. Maintain the strict rule that no legacy implementation, architecture, data, workflows or operating patterns influence V2.

## Initial consistency review findings

The first review identified and corrected three stale or conflicting statements in PR #3: the README's suggestion that legacy historical knowledge could be preserved into V2; the Decision Register's similar allowance; and the controller's outdated private-repository status. The strict V2 non-interference rule remains binding. These corrections do not constitute full acceptance of all founding documents.

## Current acceptance position

M0 founding controls are accepted and closed. Product, provider and open-source research documents remain initial baselines; they are not evidence of completed M1 research or approval of a data source, software dependency, architecture or implementation. The targeted legacy metadata inventory remains explicitly non-exhaustive.
