## Latest verified status — 17 November 2026 (M3-11-07 preparation)

- **Latest verified main at M3-11-07 start:** `c77ad95a85ecce845d06c24eb629e368ac46be13` (M3-11-06 closeout, PR #274).
- **M3-11-07:** repository-only release-candidate readiness documentation is being prepared; no release candidate exists and candidate-specific checks have not run.
- **M3-11 overall:** BLOCKED / NOT ACCEPTED. M3-11-02–M3-11-06 substantive gates remain blocked; the private environment is unprovisioned and recovery rehearsal/RPO/RTO evidence is absent.
- **Production access, deployment, release and URL cutover:** NOT AUTHORIZED.
- This preparation does not authorize candidate creation, M3-11-08 go/no-go, production execution, pilot activity or public feature activation.

---

# eStudent Institutes V2 — `listing-v2`

An independent, greenfield education discovery and decision-support platform for students in Pakistan.

## Current verified status — 17 November 2026

- **Repository:** `mattari20/listing-v2`
- **Milestone:** M3 — Mobilization and Controlled Implementation.
- **M3-00 through M3-09:** bounded planning, implementation and synthetic/local/CI packages delivered as recorded in the governing roadmap; remaining independent and operational gates are not implied complete.
- **M3-10:** authorized readiness-preparation agenda COMPLETE/CLOSED; pilot readiness NOT ACCEPTED; no pilot go/no-go; two-person tabletop NOT EXECUTED.
- **M3-11:** governance/release preflight COMPLETE for current repository evidence; residual owner, qualified-review, human-operations and environment gates remain BLOCKED / NOT ACCEPTED.
- **Production readiness:** BLOCKED / NOT ACCEPTED.
- **Production access, deployment, release and URL cutover:** NOT AUTHORIZED.
- **Latest verified main:** `a85908f0e64bca943593efbc246025dbc55fee15` (PR #266 post-merge evidence reconciliation; exact-head CI and documentation validation passed).

## Start here

1. Read [Project Master Control](docs/00-foundation/PROJECT_MASTER_CONTROL.md).
2. Read the [M3 Master Step Plan](docs/04-roadmap/M3_MASTER_STEP_PLAN.md).
3. Review the [Project Progress Report](docs/04-roadmap/PROJECT_PROGRESS_REPORT.md).
4. Use the [Documentation Index](docs/README.md) and [Documentation Completion Catalogue](docs/04-roadmap/DOCUMENTATION_CATALOG.md) for supporting records.
5. For current release gates, read [M3-11 Preflight](docs/04-roadmap/M3-11_CONTROLLED_PRODUCTION_LAUNCH_PREFLIGHT.md) and the [M3-11 Residual Gate Resolution Plan](docs/04-roadmap/M3-11_RESIDUAL_GATE_RESOLUTION_PLAN_2026-11-17.md).

## Purpose

Help students discover educational institutions, explore classes and academic programmes, understand admissions and costs, compare institutions, and eventually access trustworthy, governed information and post-launch trust features. Product capability status and remaining gaps are recorded in the requirements-to-capability reconciliation; planned features must not be represented as already implemented.

## Independence and safety

This is an independent V2 project. The legacy `mattari20/estudent-listing` repository and live eStudent.pk service must remain untouched. Do not access or change V1 systems, production databases, shared production configuration or legacy data.

No production connection, deployment, release, URL cutover or replacement of the live service is authorized by ordinary development work. Each requires separate exact-scope written approval and verified V2-only backup/recovery safeguards.

Current binding boundaries:
- Synthetic-only local/CI data for work authorized within repository scope.
- No participant recruitment/contact or pre-launch student research.
- No real student, guardian, staff, provider, institution or source data.
- No external-source retrieval, scraping, APIs, connectors or AI/model activation.
- No public UGC, reviews, ratings, reporting or moderation activation.
- Deeni Madaris remains default-OFF with zero public exposure.
- No new vendor, dependency, procurement or spend without separate approval.
- No Hostinger/hPanel, production or live-database access without separate exact authorization.

A merged PR or passing CI proves only the bounded repository checks it actually ran. It is not legal/privacy/security/accessibility certification, production recovery evidence, pilot acceptance or release approval.


## M3-11-04 update — 17 November 2026

- M3-11-04 repository preparation delivered; actual human operations/support readiness remains BLOCKED because 0/9 required roles have evidenced written acceptance or coverage.
- M3-11 overall remains BLOCKED / NOT ACCEPTED; no private environment, pilot, production access, deployment or release is authorized.
- Latest main at the start of this package: `2bd5fd0d1339f77a9c5fdde4d05d83b7ce2a85e9`; PR delivery evidence will be recorded after exact-head validation and merge.


## M3-11-04 / M3-11-05 delivery reconciliation — 17 November 2026

- PR [#272](https://github.com/mattari20/listing-v2/pull/272) merged as `30c04b00e3299993f7167f45b8410f82c5d8800e`; exact head `9062e5dfb739ed0c4a9dd36b61906c116f401b66`; FND-01 CI #444 and documentation validation #862 passed; main verified identical to merge commit.
- M3-11-04 repository preparation delivered; actual human readiness remains BLOCKED (0/9 role acceptances).
- M3-11-05 repository preparation delivered; target environment unidentified, no provisioning/access, 0/18 isolation items verified; separate authorization remains required.
- M3-11 overall remains BLOCKED / NOT ACCEPTED. No hosted environment, V1/production, DNS, database, deployment, pilot or release action occurred.


## M3-11-05 / M3-11-06 delivery reconciliation — 17 November 2026

- PR [#273](https://github.com/mattari20/listing-v2/pull/273) merged as `ef136e183d9cbcd14358004b634672c19710e387`; exact head `1cacdd17bd6340a9cf41de68f171f0bc62dc137a`; FND-01 CI #445 and documentation validation #864 passed; main verified identical to merge commit.
- M3-11-05 repository preparation delivered; environment target unidentified, no provisioning/access, 0/18 isolation evidence verified.
- M3-11-06 repository preparation delivered; no backup/restore/rollback performed, RPO/RTO unset and unmeasured.
- Both substantive gates remain BLOCKED / NOT ACCEPTED. No hosted environment, backup store, V1/production, live DB, deployment, pilot or release action occurred.
