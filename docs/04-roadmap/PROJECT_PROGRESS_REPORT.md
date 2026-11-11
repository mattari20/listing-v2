# Project Progress Report

**As of:** 2026-11-11  
**Current milestone:** M1  
**Current phase:** M0 accepted; beginning independent student research

## Verified V2 repository facts
- Repository: `mattari20/listing-v2`
- Visibility: Public, selected by the owner on 2026-11-11.
- Default branch: `main`
- Founding documentation PR [#1](https://github.com/mattari20/listing-v2/pull/1) merged as `0f2165f3d18e43f10cf6d6f717f145d3433769a4`.
- Documentation catalogue PR [#2](https://github.com/mattari20/listing-v2/pull/2) merged as `975cd672378e8d30982d44d54d12e195e9c57d5d`; required check passed on exact head `9ad0d3b361d6641dca2e94c3c9a52ac2fb4d1597` ([run #43057131618](https://github.com/mattari20/listing-v2/actions/runs/43057131618)).
- M0 consistency and workflow record PR [#3](https://github.com/mattari20/listing-v2/pull/3) merged as `035503a3c0772f7b542d2986b3fa66b3fce970d6`; required check passed on exact head `6571c678a5fdeff456257a01c6fc38576367a506` ([run #43058113045](https://github.com/mattari20/listing-v2/actions/runs/43058113045)).
- Repository auto-merge is enabled (`allow_auto_merge=true`).
- Active `main` ruleset ID `27043221` requires pull requests, conversation resolution, linear history and `Validate project control documents`; bypass list is empty.
- M0 delivery workflow was demonstrated by PR #2 using the exact-head required check and protected squash merge. Automatic merge execution itself has not yet been independently demonstrated.

## M0 acceptance
- M0-S01 through M0-S07 are recorded as accepted/complete in the step register.
- Founding control documents were reviewed for project consistency and the strict legacy non-interference requirement.
- The initial review found and corrected stale README/Decision Register language that could imply legacy knowledge may influence V2, and an outdated private-repository statement.
- The legacy exclusion audit is explicitly a targeted metadata-only inventory, not an exhaustive scan of the legacy repository.
- The documentation catalogue is the owner-facing delivery and acceptance register.
- M0 closeout PR [#4](https://github.com/mattari20/listing-v2/pull/4) merged as `4d1122d182961f3842803036f917ce39cd11b4c6`; required check passed on exact head `64da261546b034129af3aebfa38fb91f939732b6` ([run #43058607549](https://github.com/mattari20/listing-v2/actions/runs/43058607549)). M0 is accepted and closed.

## Scope still outstanding (M1 and later)
- Student/user research and measurable journey requirements.
- Institution taxonomy and geographic/sector coverage.
- Official and private provider research, including access, data rights and freshness.
- Programme/admissions information research.
- Independent open-source and dataset candidate assessment.
- Final data-agent, trust, moderation and comparison requirements.
- Architecture and technology choices remain unapproved until M1 research is accepted.
- No application code, database schema or migrations have been approved or started.

## Strict legacy non-interference
No legacy source code, schema, data, architecture, requirements, historical findings, workflows, configuration or operational patterns may influence V2. Legacy production access or modification remains prohibited. V2 inputs must come from direct V2 owner requirements, independent research and independently validated V2 decisions.

## Next authorized step
**M1-S01 — Student/user research and journey.** Establish a research plan and evidence register before changing product requirements. Do not begin architecture or technology selection before M1 acceptance.

## Reporting rule
After every documentation PR update and merge, reconcile the documentation catalogue, index, controller, step register, traceability matrix and progress report. Record exact PR, head SHA, required check and merge SHA. Never infer acceptance from a merge alone.
