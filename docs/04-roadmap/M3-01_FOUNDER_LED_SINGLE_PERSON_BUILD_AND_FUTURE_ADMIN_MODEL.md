# M3-01 — Founder-Led Single-Person Build and Future Administration Model

**Date:** 2026-11-12  
**Owner decision:** Product Owner confirms they are the only person building the system at the current stage. Additional team members will be added after completion as operational needs require, including at least two administrators and other personnel.  
**Status:** Delivery-model decision recorded; implementation authorization NOT ISSUED.

## 1. Current delivery model

The current build is founder-led and single-person:

- **Product Owner / Founder / sole builder:** the user. The owner makes product and scope decisions and is the only human currently assigned to build the system.
- **ChatGPT:** an AI assistant supporting planning, documentation, architecture, code drafting after separate authorization, test design, review support and step-by-step guidance. ChatGPT is not a human engineer, independent reviewer, legal adviser, security certifier or operations person.
- **No other human implementer, maintainer, QA reviewer or operations owner is currently assigned.**

This decision supersedes the assumption that a separate human implementation team must be recruited before a bounded initial build can be considered. It does not assert any unverified professional qualifications, skills, hours, or experience for the owner.

## 2. Current build versus future operations

| Area | Current build stage | Future post-completion operations |
|---|---|---|
| Product ownership | Owner | Owner or formally delegated successor |
| Build/implementation | Owner is sole human builder, assisted by ChatGPT | Maintainers/developers added as needed |
| Technical administration | Owner only where technically capable and explicitly authorized | At least two separately accountable administrators |
| Content/data operations | No real-source ingestion or public data operations in Candidate A | Staff roles added only after policy, access and training design |
| QA/security | Owner may perform documented self-checks; these are not independent reviews | Independent qualified review coverage added as needed |
| Legal/privacy/safeguarding | No clearance implied | Qualified specialist review when applicable |
| Operations/incident response | Not yet assigned as a separate operational function | Named operational and incident responsibilities before production |
| Support/moderation | Not in Candidate A | Roles and escalation paths defined before relevant features launch |

The future minimum of two administrators is a product/operations staffing requirement for the later operating model. It does not mean two admin accounts should be created now, and it does not authorize user accounts, roles, authentication or admin functionality in Candidate A.

## 3. Single-person build safeguards

A single-person build increases concentration risk. Before any implementation authorization, the scope-specific plan must therefore include:

1. Owner-controlled repository access with protected main and required PR validation; no direct bypass.
2. Reproducible build and test instructions so work can be reviewed or handed over later.
3. Least-privilege credentials and secret handling; no secrets in source, logs or fixtures.
4. Documented decisions, architecture, setup, tests, known limitations and recovery/rollback instructions.
5. A clear separation between owner self-review and any independent review required for security, privacy, legal, safeguarding or release decisions.
6. No reliance on ChatGPT as an accountable human operator or independent approver.
7. A handover-ready structure so future maintainers and at least two administrators can be added without sharing personal credentials.

## 4. Effect on M3-01 P03

P03 is partially clarified, not fully closed:

- The sole human builder and Product Owner role is identified as the user.
- ChatGPT's supporting role is explicitly non-human and non-accountable.
- Future administrator staffing is deferred until post-completion, with a minimum of two administrators to be planned before operational handover.
- The owner's technical skill/experience evidence, realistic build capacity and continuity arrangements are not asserted by this decision.
- Independent QA/security/legal/privacy/safeguarding review and production operations coverage remain separate gates where applicable.

This decision permits M3-01 to plan around a single-person initial build rather than waiting for a team. It does not by itself authorize implementation or clear all P03 readiness criteria.

## 5. Boundaries remain unchanged

Candidate A remains the only approved planning candidate: isolated V2 foundation, synthetic fixtures only. No V1 reuse, real/public data, source access, scraping/ingestion, external APIs, models/agents, accounts/reviews, personal-data processing, physical database schema/migrations, hosting activation, procurement/new spend, deployment, pilot or launch.

Deeni Madaris Show default-OFF and zero exposure across all public surfaces and side channels remains binding. All external sources remain RESEARCH ONLY.

**Implementation authorization: NOT ISSUED.**
