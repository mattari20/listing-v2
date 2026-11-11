# Project Master Control

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Status:** M0 — accepted and closed; M1-S01 is the next authorized step  
**Last reconciled:** 2026-11-11

## Authoritative current position
- Public V2 repository visibility verified; owner selected public visibility on 2026-11-11.
- Repository auto-merge is enabled; active `main` ruleset requires the documentation validation check.
- Bootstrap README committed to `main`.
- Founding documentation PR #1 merged into `main` as `0f2165f3d18e43f10cf6d6f717f145d3433769a4`.
- Documentation Completion Catalogue: `../04-roadmap/DOCUMENTATION_CATALOG.md`; update after every documentation PR update and merge.
- No application code, database schema or migrations have been approved or started.
- Legacy repository inspection is read-only and limited to a metadata inventory for explicit exclusion.
- No connection to legacy production systems or data is permitted.
- No production deployment, URL cutover or replacement is authorized.

## Project objective
Build a student-first education discovery, admissions information and comparison platform, initially focused on Pakistan, supported by a lawful, multi-source, continuously refreshed and evidence-based education data catalogue.

## Documentation visibility
The Documentation Completion Catalogue is the owner-facing inventory of delivered, updated, accepted and planned documents. A merged PR records delivery, not automatic content acceptance. Every documentation PR update and merge must reconcile the catalogue, index, controller, step register, traceability and progress report.

## Current milestone
**M1 — Student requirements and independent research**

## M0 closeout
M0 was accepted after review of the founding controls, strict legacy non-interference boundary, project planning records, repository rules and the PR delivery workflow. Evidence is recorded in `../04-roadmap/DOCUMENTATION_CATALOG.md`, `../04-roadmap/PROJECT_PROGRESS_REPORT.md` and `../04-roadmap/IMPLEMENTATION_TRACEABILITY_MATRIX.md`. M0-S02 acceptance is limited to the documented metadata-only exclusion audit; it is not an exhaustive inventory of the legacy repository. Repository auto-merge is enabled, but automatic merge execution has not yet been independently demonstrated. Production access, deployment and cutover remain unauthorized.

## Strict legacy non-interference rule
Legacy work must not influence V2 in any style or form: no code, schema, migrations, APIs, data, architecture, technology choices, UI patterns, workflows, tests, fixes, deployment practices, historical statuses or operational workarounds may be copied, adapted, ported, treated as templates or used as implicit design inputs. Legacy access is read-only for exclusion/audit purposes. V2 decisions must originate from V2 owner requirements, independent research and V2 validation. See `../99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md`.

## Next-step operating rule
At the beginning of every work session, the AI must:
1. Read this file and the current milestone/step register.
2. Inspect V2 repository state, open PRs, latest main commit and relevant CI.
3. Identify the first eligible, incomplete V2 step whose dependencies are satisfied.
4. Continue existing V2 work rather than restart or duplicate it.
5. Work only within the step's documented scope.
6. Confirm all task inputs comply with the strict legacy non-interference rule.

At the end of each step, update this controller with status, evidence, progress and the exact next authorized V2 step. The next authorized step is M1-S01: student/user research and journey.

## Completion status
M0 is accepted and closed. Future milestones require their own evidence-based acceptance and closeout.

## Progress rules
Use weighted step progress as defined in `../04-roadmap/MILESTONE_STEP_REGISTER.md`. Progress percentages are planning indicators, not substitutes for acceptance. A milestone closes only when all mandatory acceptance criteria pass.

## Safety boundaries
- Do not modify `mattari20/estudent-listing`, its databases, hosting, credentials, workflows or the live `https://estudent.pk/institutes/` service.
- Do not transfer legacy artifacts or patterns into V2.
- No production reads requiring credentials, production writes, migrations, backfills, deployment or cutover without separate explicit authorization and documented safeguards.
- Never expose secrets, private student data or credentials in issues, PRs or logs.

## Change control
Only this controller and approved V2 decision records define the current V2 plan. Legacy documentation, historical reports and implementation results are excluded and do not silently override V2 requirements.
