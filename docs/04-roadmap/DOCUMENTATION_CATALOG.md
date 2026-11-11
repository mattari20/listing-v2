# Documentation Completion Catalogue

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Baseline:** PR #1 merged into `main`  
**Baseline merge commit:** `0f2165f3d18e43f10cf6d6f717f145d3433769a4`  
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
| [Project Master Control](../00-foundation/PROJECT_MASTER_CONTROL.md) | Authoritative project state, boundaries and session operating rules | Delivered — review pending |
| [Project Constitution](../00-foundation/PROJECT_CONSTITUTION.md) | V2 principles, independence and non-interference commitments | Delivered — review pending |
| [AI Execution Protocol](../00-foundation/AI_EXECUTION_PROTOCOL.md) | AI autonomy, authorization and execution boundaries | Delivered — review pending |
| [Engineering Standards](../00-foundation/ENGINEERING_STANDARDS.md) | V2 engineering quality and delivery standards | Delivered — review pending |
| [Definition of Done](../00-foundation/DEFINITION_OF_DONE.md) | Completion and acceptance expectations | Delivered — review pending |
| [Decision Register](../00-foundation/DECISION_REGISTER.md) | Durable record of approved and pending decisions | Delivered — review pending |
| [Repository Governance Setup](../00-foundation/REPOSITORY_GOVERNANCE_SETUP.md) | PR, branch rules, CI and merge configuration evidence | Updated — review pending in PR #2 |

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

### E. Roadmap, traceability and progress

| Document | Purpose | Status |
|---|---|---|
| [Master Roadmap](PROJECT_MASTER_ROADMAP.md) | M0–M12 milestone outcomes and dependencies | Delivered — review pending |
| [Milestone and Step Register](MILESTONE_STEP_REGISTER.md) | Numbered milestones, steps and acceptance evidence | Updated — review pending in PR #2 |
| [Implementation Traceability Matrix](IMPLEMENTATION_TRACEABILITY_MATRIX.md) | Requirement-to-delivery traceability | Delivered — review pending |
| [Project Progress Report](PROJECT_PROGRESS_REPORT.md) | Verified current status, blockers and next actions | Updated — review pending in PR #2 |
| [Documentation Completion Catalogue](DOCUMENTATION_CATALOG.md) | Owner-facing documentation inventory and PR-by-PR history | New in this PR — review pending |

### F. Independence and legacy exclusion

| Document | Purpose | Status |
|---|---|---|
| [Legacy Repository Isolation Audit](../99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md) | Records the V2 exclusion boundary and limited metadata-only audit scope | Delivered — review pending |

### G. Repository-level delivery support

| File | Purpose | Status |
|---|---|---|
| [README](../../README.md) | Repository entry point | Delivered — review pending |
| [Documentation Index](../README.md) | Navigation across V2 documentation | Updated — review pending in PR #2 |
| [Pull Request Template](../../.github/pull_request_template.md) | Standard PR scope, safety and evidence prompts | Delivered — review pending |
| [Task Issue Template](../../.github/ISSUE_TEMPLATE/task.yml) | Structured V2 task intake | Delivered — review pending |
| [Documentation Validation Workflow](../../.github/workflows/project-docs-validation.yml) | Automated documentation validation on PRs | Delivered — passed on PR #1 head |
| [Documentation Validator](../../scripts/validate_project_docs.py) | Required-file and local-link validation | Delivered — passed on PR #1 head |

## PR delivery history

| PR | Scope | Merge / head evidence | Status |
|---|---|---|---|
| [#1](https://github.com/mattari20/listing-v2/pull/1) | Founding documentation, V2 governance, product/data requirements, roadmap, isolation audit and repository templates/CI | Merged as `0f2165f3d18e43f10cf6d6f717f145d3433769a4`; 36 commits; 26 changed files; one required check passed | Merged |
| [#2](https://github.com/mattari20/listing-v2/pull/2) | Living documentation catalogue, index/controller/roadmap reconciliation, governance and progress updates | Open; current head and required-check evidence are tracked in the PR | In progress — CI passed on initial head; final head verification pending |

## Remaining documentation work

1. Review every delivered founding document against V2 owner requirements and its own acceptance criteria; record accepted items individually.
2. Expand student and institution requirements using new, independent V2 research.
3. Expand the provider register with verifiable source access, coverage, update cadence, data rights and provenance evidence.
4. Complete independent candidate research and license/security assessment before approving reuse.
5. Refine M1 acceptance and task weights only after research scope and evidence are clear.
6. Keep M2 architecture and technology decisions unapproved until M1 research is accepted.
7. Maintain the strict rule that no legacy implementation, architecture, data, workflows or operating patterns influence V2.

## Current acceptance position

PR #1 establishes the initial documentation set and is merged. The inventory is a delivery record, not a claim that every document is fully researched or accepted. M0 closeout remains subject to M0-S06 delivery-workflow verification and M0-S07 evidence-based acceptance.
