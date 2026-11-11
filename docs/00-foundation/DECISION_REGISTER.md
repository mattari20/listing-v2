# Decision Register

Decisions are recorded with ID, date, status, context, decision, consequences and review trigger. A proposal is not approved until its status is changed through a documented review.

## V2-DEC-001 — Independent greenfield rebuild
- **Date:** 2026-11-11
- **Status:** Adopted as project baseline
- **Decision:** Develop V2 independently in `mattari20/listing-v2`. Preserve approved legacy knowledge and source provenance, but do not copy legacy application code, database schema, migrations, deployment configuration or undocumented workarounds.
- **Consequences:** Architecture, schema, tests, CI and deployment approach are independently designed. Legacy and live production remain untouched.

## V2-DEC-002 — Automatic PR merge after verified checks
- **Date:** 2026-11-11
- **Status:** Policy adopted; repository configuration and end-to-end verification pending
- **Decision:** Eligible PRs should merge automatically after all required checks pass on the exact latest head SHA and all branch protection, review, conflict and policy conditions are satisfied.
- **Exceptions:** Architecture/scope approvals, destructive data operations, production database work, deployment/cutover and security exceptions require separate approval where specified.
- **Consequence:** Do not claim automation is active until repository settings and a test PR verify it.

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
