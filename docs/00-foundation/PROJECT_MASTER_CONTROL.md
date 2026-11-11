# Project Master Control

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Status:** M0 — founding documentation in progress  
**Last reconciled:** 2026-11-11

## Authoritative current position
- New, independent repository established.
- Initial README bootstrap committed to `main`.
- M0 founding-documentation PR is being prepared.
- No application code or database schema has been approved or started.
- No connection to the legacy production database is permitted.
- No production deployment, URL cutover or replacement is authorized.

## Project objective
Build a student-first education discovery, admissions information and comparison platform, initially focused on Pakistan, supported by a lawful, multi-source, continuously refreshed and evidence-based education data catalogue.

## Current milestone
**M0 — Repository, documentation and governance foundation**

## Next-step operating rule
At the beginning of every work session, the AI must:
1. Read this file and the current milestone/step register.
2. Inspect repository state, open PRs, latest main commit and relevant CI.
3. Identify the first eligible, incomplete step whose dependencies are satisfied.
4. Continue existing work rather than restart or duplicate it.
5. Work only within the step's documented scope.

At the end of each step, update this controller with status, evidence, progress and the exact next authorized step.

## Completion status
The founding documentation is being proposed in the current PR. M0 is not complete until all M0 steps, repository controls, automation verification and acceptance evidence are satisfied.

## Progress rules
Use weighted step progress as defined in `../04-roadmap/MILESTONE_STEP_REGISTER.md`. Progress percentages are planning indicators, not substitutes for acceptance. A milestone closes only when all mandatory acceptance criteria pass.

## Safety boundaries
- Keep `mattari20/estudent-listing` and the live `https://estudent.pk/institutes/` untouched during V2 development.
- Do not port legacy application code, migrations, schema or deployment configuration.
- No production reads requiring credentials, production writes, migrations, backfills, deployment or cutover without separate explicit authorization and documented safeguards.
- Never expose secrets, private student data or credentials in issues, PRs or logs.

## Change control
Only this controller and approved decision records define the current V2 plan. Chat conversation, old reports and unapproved proposals do not silently override repository documentation.
