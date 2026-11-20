## Latest verified update — 20 November 2026 (M3-11 current-main reconciliation)

- **Latest verified main:** `355d0d6208e43b6221c520eeb728070f0d7b2125` — PR [#402](https://github.com/mattari20/listing-v2/pull/402), M3-11-08 current decision-gate reconciliation.
- PRs [#395–#402](https://github.com/mattari20/listing-v2/pulls?q=is%3Apr+is%3Amerged+395) were merged after exact-head verification. Their FND-01 / documentation-validation runs passed respectively: #742/#1266, #743/#1268, #744/#1270, #745/#1272, #746/#1274, #747/#1276, #748/#1278 and #749/#1280.
- DP-02 through DP-06 source/repository evidence was reconciled. These records do not establish effective hosted settings, independent professional assurance or production-grade controls.
- **M3-11-02:** Product Owner internal review and DP-01–DP-06 repository reconciliations are recorded; qualified independent legal/privacy/safeguarding assessment and target-specific evidence remain BLOCKED.
- **M3-11-03:** repository-only internal review is closed for current development and SEC-06 local/CI evidence is merged; independent security assessment and manual accessibility/WCAG evaluation remain BLOCKED.
- **M3-11-04:** repository preparation delivered; human operations readiness remains BLOCKED at 0/9 written role acceptances, with coverage/deputies not evidenced.
- **M3-11-05:** historical resource/runtime evidence is partial; private environment isolation remains NOT ACCEPTED, with 0/18 items fully verified.
- **M3-11-06:** weekly automated backup cadence is accepted for the current development stage only, with no extra spend. No V2-only recovery proof or rehearsal exists; RPO/RTO remain unset.
- **M3-11-07:** NOT STARTED / BLOCKED; no candidate ID, pinned candidate SHA, artifact or candidate-specific evidence exists.
- **M3-11-08:** BLOCKED / NOT DECIDED; no complete dossier and no GO, CONDITIONAL GO or NO-GO decision has been issued.
- **M3-11-09:** NOT AUTHORIZED. **M3-11-10:** NOT STARTED.
- **DP-05 scope discrepancy remains open:** saved-items and session shortlist/comparison routes and UI exist in source although these surfaces are excluded from the accepted private-acceptance activity. Any future candidate must prove the excluded surfaces inaccessible/disabled for that activity; no route or product behavior was changed in the reconciliation.
- **M3-10 pilot readiness remains NOT ACCEPTED. Production readiness remains BLOCKED / NOT ACCEPTED.** No pilot, public launch, deployment, URL cutover, production/V1 access, live database operation, private environment provisioning, backup/restore rehearsal, real-data use or participant activity is authorized.
- The source repository remains PUBLIC during development; the already accepted decision to make it PRIVATE when development is complete remains unchanged. Do not change visibility as part of this update.

See the [M3 Master Step Plan](docs/04-roadmap/M3_MASTER_STEP_PLAN.md), [Project Progress Report](docs/04-roadmap/PROJECT_PROGRESS_REPORT.md), [M3-11 Preflight](docs/04-roadmap/M3-11_CONTROLLED_PRODUCTION_LAUNCH_PREFLIGHT.md), [M3-11 Residual Gate Resolution Plan](docs/04-roadmap/M3-11_RESIDUAL_GATE_RESOLUTION_PLAN_2026-11-17.md), and the [M3-11-08 decision pack](docs/04-roadmap/M3-11-08_CHANGE_AND_GO_NO_GO_DECISION_PACK_2026-11-17.md).

---

## Latest verified update — 18 November 2026 (M3-11-05C subfolder database and private preview)

- PR [#295](https://github.com/mattari20/listing-v2/pull/295) merged as `09ae3ff31462cb2bf85566c5f9963565c067a69f`; exact-head FND-01 PHP 8.5 CI #496 and documentation validation #933 passed.
- V2 now has configurable MySQL connection support, while local/CI remains SQLite; the V2 session cookie can be scoped to the final subfolder path; and an opt-in global Laravel HTTP Basic gate protects requests entering Laravel.
- Hosting-level protection is still required for static files served directly by the web server. Hostinger plan compatibility, storage permissions and hosted isolation remain unverified; no hosted resource was created or deployed.
- See [M3-11-05C implementation record](docs/04-roadmap/M3-11-05C_SUBFOLDER_DATABASE_AND_PRIVATE_PREVIEW_CONTROLS_2026-11-18.md), [M3-11-05B compatibility assessment](docs/04-roadmap/M3-11-05B_SUBFOLDER_HOSTING_COMPATIBILITY_ASSESSMENT_2026-11-18.md) and [M3-11-05A owner architecture decision](docs/04-roadmap/M3-11-05A_OWNER_SUBFOLDER_ARCHITECTURE_DECISION_2026-11-18.md).

---

## Latest verified update — 18 November 2026 (M3-11-05A local synthetic preview)

- PR [#285](https://github.com/mattari20/listing-v2/pull/285) merged as `d3e554cd296d3edc23da52d9ffaefc01244c2cb4`; exact-head FND-01 CI #485 and documentation validation #912 passed.
- A guarded, explicit local-only seeder provides five fictional institution profiles for the first browser preview. Local execution and owner visual review are still pending; see [M3-11-05A runbook](docs/04-roadmap/M3-11-05A_LOCAL_SYNTHETIC_PREVIEW_AND_TEST_DATASET.md).
- Hosted environment isolation (M3-11-05), backup/recovery (M3-11-06), pilot, production, deployment and release remain blocked/not authorized.

---

## Latest verified status — 17 November 2026 (M3-11 gate coordination)

- PR #276 merged as `e226fdbef1f24314c2a0c4399403342ced158ef3`; exact-head PHP 8.5 foundation CI and documentation validation passed.
- M3-11 remains BLOCKED / NOT ACCEPTED. Current repository-only work provides a gate-resolution coordination plan and blank owner/evidence intake worksheet; no human appointments, professional reviews, environment authorization, recovery rehearsal, candidate or release decision is created.
- Production access, deployment, pilot and release remain NOT AUTHORIZED.

---

## Latest verified status — 17 November 2026 (M3-11-08 preparation)

- PR #275 merged as `c1e8c70cb3433773ac45e9e35c32c446a8bf1684`; exact-head PHP 8.5 foundation CI and documentation validation passed.
- M3-11-07 documentation preparation delivered; no release candidate exists and its substantive gate remains NOT STARTED / BLOCKED.
- M3-11-08 decision-pack preparation is documentation-only; no dossier or GO/NO-GO decision exists. M3-11-08 remains BLOCKED / NOT DECIDED.
- M3-11 overall remains BLOCKED / NOT ACCEPTED. Production access, deployment, pilot, release and URL cutover remain NOT AUTHORIZED.

---

## Latest verified status — 17 November 2026 (M3-11-07 preparation)

- **Latest verified main at M3-11-07 start:** `c77ad95a85ecce845d06c24eb629e368ac46be13` (M3-11-06 closeout, PR #274).
- **M3-11-07:** repository-only release-candidate readiness documentation is being prepared; no release candidate exists and candidate-specific checks have not run.
- **M3-11 overall:** BLOCKED / NOT ACCEPTED. M3-11-02–M3-11-06 substantive gates remain blocked; the private environment is unprovisioned and recovery rehearsal/RPO/RTO evidence is absent.
- **Production access, deployment, release and URL cutover:** NOT AUTHORIZED.
- This preparation does not authorize candidate creation, M3-11-08 go/no-go, production execution, pilot activity or public feature activation.

---

# eStudent Institutes V2 — `listing-v2`

An independent, greenfield education discovery and decision-support platform for students in Pakistan.

## Current verified status — 20 November 2026

- **Repository:** `mattari20/listing-v2`
- **Milestone:** M3 — Mobilization and Controlled Implementation.
- **M3-00 through M3-09:** bounded planning, implementation and synthetic/local/CI packages delivered as recorded in the governing roadmap; remaining independent and operational gates are not implied complete.
- **M3-10:** authorized readiness-preparation agenda COMPLETE/CLOSED; pilot readiness NOT ACCEPTED; no pilot go/no-go; two-person tabletop NOT EXECUTED.
- **M3-11:** repository governance and evidence reconciliation progressed through M3-11-08. M3-11-02–M3-11-06 still have substantive independent, human-operations, environment or recovery gates BLOCKED; M3-11-07 is NOT STARTED / BLOCKED; M3-11-08 is BLOCKED / NOT DECIDED.
- **Production readiness:** BLOCKED / NOT ACCEPTED.
- **Production access, deployment, release and URL cutover:** NOT AUTHORIZED.
- **Latest verified main:** `355d0d6208e43b6221c520eeb728070f0d7b2125` (PR #402 current decision-gate reconciliation; exact-head FND-01 CI and documentation validation passed).

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
