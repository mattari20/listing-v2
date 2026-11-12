# Decision Register

Decisions are recorded with ID, date, status, context, decision, consequences and review trigger. A proposal is not approved until its status is changed through a documented review.

## V2-DEC-001 — Independent greenfield rebuild
- **Date:** 2026-11-11
- **Status:** Adopted as project baseline
- **Decision:** Develop V2 independently in `mattari20/listing-v2`. No legacy knowledge, requirements, historical findings, source artifacts or processes may influence V2. V2 must originate only from direct V2 owner requirements, independent research and independently validated V2 decisions.
- **Consequences:** Architecture, schema, tests, CI and deployment approach are independently designed. Legacy and live production remain untouched.

## V2-DEC-002 — Automatic PR merge after verified checks
- **Date:** 2026-11-11
- **Status:** Policy adopted; repository auto-merge setting enabled; required-check/PR workflow demonstrated by PR #2; automatic merge execution itself not yet independently demonstrated
- **Decision:** Eligible PRs should merge automatically after all required checks pass on the exact latest head SHA and all branch protection, review, conflict and policy conditions are satisfied.
- **Exceptions:** Architecture/scope approvals, destructive data operations, production database work, deployment/cutover and security exceptions require separate approval where specified.
- **Consequence:** Auto-merge is available at repository level, but enable it on individual PRs only after the exact latest-head check and all policy gates pass. Do not claim an automatic merge execution has been proven until a PR actually merges through that mechanism.

## V2-DEC-003 — Documentation-driven step execution
- **Date:** 2026-11-11
- **Status:** Adopted
- **Decision:** Every milestone is decomposed into small numbered steps with measurable targets, dependencies, PRs, tests and acceptance evidence. At every step boundary, calculate progress and update the controller to identify the next eligible step.

## V2-DEC-004 — Student-first education discovery platform
- **Date:** 2026-11-11
- **Status:** Product direction adopted; detailed requirements to be refined in M1
- **Decision:** The platform helps students discover nearby institutions, explore classes/programmes and admission information, compare institutions, shortlist choices and contribute ratings/reviews under a trust and moderation framework.

## V2-DEC-005 — Multi-source, recurring education data strategy
- **Date:** 2026-11-11
- **Status:** Product direction adopted; source rights and technical design pending
- **Decision:** Build a multi-provider education data catalogue and AI-assisted process for discovery, collection, change detection, normalization, duplicate resolution, verification and recurring refresh. Preserve source provenance and usage rights. No source is assumed reusable until reviewed.


## V2-DEC-006 — Deeni Madaris included in data scope but hidden by default
- **Date:** 2026-11-12
- **Status:** Adopted — explicit owner requirement
- **Context:** The owner directed that V2 will work with Deeni Madaris as a distinct provider family, but they must not appear in the public listing at initial launch. The owner also requires an option to show or hide this category.
- **Decision:** Include Deeni Madaris in the underlying V2 provider/research scope as a separate institution category. Provide an authorized platform-configuration setting labelled **Show Deeni Madaris**, with the launch default **OFF**. When OFF, Deeni Madaris are excluded from public discovery/listing outputs; their underlying records and provenance are retained. An authorized administrator may enable the category through the setting. The exact administration UI and authorization roles are deferred to M2 design.
- **Consequences:** Data inclusion and public visibility are separate concerns. Visibility changes must not alter registration, recognition, affiliation or qualification-equivalence facts. Do not collect or expose sect/maslak as a general discovery attribute. No implementation is authorized by this product decision.
- **Review trigger:** Before M2 design/implementation, validate the setting's permissions, public-surface coverage, privacy implications and acceptance tests with the owner.


## M1-S03 TVET and QAB source verification

Official source routes for NAVTTC QABs, Punjab TEVTA/PSDA/TTB, Sindh STEVTA, KPTEVTA and B-TEVTA/BSIS are recorded in `../03-research/M1_S03_TVET_QAB_SOURCE_REVIEW_2026-11-12.md`. The review also notes TTB/TEVTA vocational training links involving some Deeni Madaris. This does not change the owner's default-hidden public listing requirement; visibility of separately registered vocational entities at a Madrasah location remains an M2 design question.
