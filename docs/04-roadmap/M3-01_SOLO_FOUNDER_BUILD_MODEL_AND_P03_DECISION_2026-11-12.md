# M3-01 — Solo-Founder Build Model and Revised P03 Disposition

**Date:** 2026-11-12  
**Owner clarification:** The Product Owner is the only human builder for the initial system and intends to build it with ChatGPT assistance. No additional people are required for the initial build. A future operating team, including at least two administrators and other roles as needed, will be added after the system is completed.  
**Status:** Owner decision recorded; P03 planning disposition revised; implementation authorization NOT ISSUED.

## 1. Authoritative delivery model

The initial V2 build is a solo-founder project:

- **Product Owner / sole human builder:** the user. The owner controls scope, priorities, decisions, repository access and acceptance.
- **ChatGPT:** AI development assistant for step-by-step planning, documentation, architecture, code drafting, debugging assistance, test design and review support when separately authorized.
- **No additional human developer, implementer, QA team, administrator or operations team is a prerequisite for the bounded initial build.**
- The owner may use ChatGPT-generated work products, but remains responsible for reviewing and accepting changes. ChatGPT is not an independently accountable human engineer, security certifier, legal adviser or production operator.

This supersedes any prior assumption that named additional human builders or a delivery team must be recruited before the initial build can be planned.

## 2. Future operating team

The future team is deliberately deferred until the system is completed and its operational requirements are known. The future model must provide at least two separately accountable administrators, plus other personnel as required.

This future staffing target does not authorize creating accounts, admin functionality, permissions, moderation, staff data or production operations in Candidate A. No shared credentials; future administrators must receive separate identities and least-privilege access.

## 3. Revised P03 task disposition

| P03 component | Owner decision | Status |
|---|---|---|
| Product ownership and build responsibility | Owner is sole human builder and decision-maker | Defined |
| AI development assistance | ChatGPT assists; owner reviews and accepts work | Defined |
| Additional human developers for initial build | Not required by owner for initial bounded build | Deferred; not a blocker |
| Future administrators | At least two planned after completion | Future operating requirement |
| Owner technical capability and learning needs | Not independently evidenced in this decision | To be handled through step-by-step build and verification; stop if a task exceeds safe capability |
| Independent legal/security/privacy certification | Not supplied by ChatGPT or owner self-review | Not claimed; required only if later scope or law makes it applicable |
| Production operations/incident coverage | Not part of Candidate A | Required before production launch |

**P03 conclusion:** The staffing model for the initial build is now owner-decided and does not require a team. P03 may be treated as accepted for the bounded Candidate A planning model, while independent assurance and future production operations remain separate release gates. Do not treat the future two-administrator plan as a current implementation prerequisite.

## 4. Assurance model for a solo build

ChatGPT can help create checklists, threat models, test cases, code review suggestions and reproducible evidence. The owner can run and inspect those checks. Neither the owner nor ChatGPT should claim independent certification from self-review.

For the strictly bounded Candidate A foundation:
- use fabricated synthetic fixtures only;
- keep build and tests offline by default;
- avoid personal data, public/source data and real institutional records;
- do not activate third-party services, AI APIs, analytics, maps, messaging or identity services;
- maintain protected PR validation, minimal permissions, secret hygiene and documented rollback;
- preserve an auditable record of decisions and test results.

If a future change introduces real data, personal data, children’s data, external sources, paid services, public exposure or production operation, pause that change and perform the relevant legal/privacy/security/safeguarding review before proceeding.

## 5. No-change boundaries

This decision does not select a stack, database, host, region or vendor. It does not approve spend. It does not authorize application code, technical spikes, package installation, environment activation, production/source access, scraping/ingestion, external APIs/models/agents, personal-data processing, physical database schema/migrations, procurement, deployment, pilot or launch.

V2 remains independent of V1. Deeni Madaris Show default-OFF and zero exposure across public surfaces and side channels remains binding. External source families remain RESEARCH ONLY.

## 6. Next M3-01 work

1. Reconcile this owner decision into P03 and the M3-01 register.
2. Finish Candidate A's technology-neutral implementation plan without installing or activating anything.
3. Make the stack/environment/cost decision a separate explicit owner decision based on M2 requirements and no-new-spend constraints.
4. Complete a scope-specific risk and verification plan and identify which assurance gates are not applicable to an offline synthetic-only foundation versus which remain pre-production gates.
5. Prepare P07 only when the bounded scope, technical choices, tests, rollback and stop conditions are explicit.
6. Obtain a separate owner authorization before implementation begins.

**Implementation authorization: NOT ISSUED.**
