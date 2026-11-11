# Implementation Traceability Matrix

| Requirement ID | Requirement | Specification | Step | PR / commit | Test / evidence | Status |
|---|---|---|---|---|---|---|
| GOV-001 | Independent greenfield repository | Project Constitution | M0-S01 | Bootstrap commit; PR #1 merged as `0f2165f3d18e43f10cf6d6f717f145d3433769a4` | Repository metadata; founding documentation present | Delivered — acceptance review pending |
| GOV-002 | Documentation-driven execution and status tracking | AI Execution Protocol; Project Master Control; Documentation Catalogue | M0-S03 | PR #1 and PR #2 merged | Controller, step register, catalogue and progress-report links | Delivered — acceptance review pending |
| GOV-003 | Protected PR workflow and eligible automatic merging | Repository Governance Setup; Engineering Standards; DEC-002 | M0-S05/S06 | PR #1 merged; ruleset `main` ID 27043221 active | Required check `Validate project control documents`; auto-merge enabled; PR #2 required check passed on exact head; squash merge SHA `975cd672378e8d30982d44d54d12e195e9c57d5d`; auto-merge execution not independently tested | Configuration and protected-merge workflow verified; auto-merge execution untested |
| PROD-001 | Student-first discovery and decision support | Product Vision | M1-S01 | PR #1 merged | Requirements acceptance and new research | Delivered — research/acceptance pending |
| DATA-001 | Multi-source lawful data catalogue | Education Data Strategy | M1-S02–S08 | PR #1 merged | Provider/rights register requires source evidence expansion | Delivered — research/acceptance pending |
| OSS-001 | Lawful open-source and dataset reuse | Open-Source Reuse Audit | M1-S06/S07 | PR #1 merged | Candidate research and license/security scorecards pending | Delivered — research pending |
| TRUST-001 | Safe ratings and reviews | Comparison, Reviews and Trust | M1-S09 | PR #1 merged | Threat, moderation and privacy requirements review pending | Delivered — acceptance pending |

Add one row for every approved requirement. Do not mark accepted without verifiable evidence.

## Documentation catalogue maintenance

`DOCUMENTATION_CATALOG.md` is the owner-facing inventory for documentation delivery and acceptance. Reconcile it on every documentation PR update and merge. Keep delivery status separate from content acceptance; update PR/head/check/merge evidence and links.
