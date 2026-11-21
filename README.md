## Latest verified update — 21 November 2026 (ADM-E source audit)

- ADM-A through ADM-D are complete within their bounded repository/synthetic scopes; ADM-D merged as PR #422, main `4549f879532c53492a14fc09446bad0a6824778a`.
- ADM-E source audit is complete; its bounded implementation contract identifies child-entity reviewer queues, assigned in-review work, returned-correction handoff, case-level evidence-quality warnings and role-scoped next actions.
- No ADM-E application code or runtime behavior has changed yet. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
- See [ADM-E Correction, Quality and Operational Handoff Audit](docs/04-roadmap/ADM_E_CORRECTION_QUALITY_OPERATIONAL_HANDOFF_AUDIT_2026-11-21.md) and [M3 Project Progress Report](docs/04-roadmap/PROJECT_PROGRESS_REPORT.md).

---

## Latest verified update — 21 November 2026 (ADM-C institution and campus workflow)

- **Latest verified main at ADM-C implementation closeout:** `68c09dc938b2b6238b8a2a90888f836bfe66ba58` — PR [#420](https://github.com/mattari20/listing-v2/pull/420), governed institution and campus information workflow.
- PR #420 passed exact-head FND-01 Foundation CI and Project documentation validation.
- **ADM-A architecture and ADM-B read-only workspace remain complete. ADM-C is complete** for the bounded university institution, campus and delivery-site proposal/correction workflow.
- Authorised university institution representatives can read the current accepted campus/delivery-site projections and submit new campus or delivery-site information through exact active field-definition versions, evidence references, validity dates and idempotency keys.
- The parent institution scope is derived from the authorised route; client-supplied parent IDs are prohibited. Campus/delivery-site field definitions must explicitly permit the entity type, provider category and scope. Parent institution fields are never inherited.
- Returned campus/delivery-site claims can be corrected as immutable successor versions and returned to editorial review. Accepted projection updates require the successor to supersede the exact currently materialized claim version.
- No submission automatically publishes. Human editorial review, adjudication and separate publication controls remain in force.
- Exact-head Foundation CI: passed. Project documentation validation: passed. Synthetic suite: 23 passed, 1,775 assertions, 305 warnings; therefore not warning-free.
- **Limitations:** no governed campus/delivery-site field definitions are activated by this agenda; they must already exist and be explicitly approved in the registry. The endpoints are JSON workflows, not a complete browser editing console. Other provider categories and institute types remain future work.
- **M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.** M3-11 independent review, hosted isolation, recovery, operational readiness and release gates remain blocked.
- No production/V1/Hostinger access, live database activity, real/source/personal data, external AI/API, deployment, paid service or new spend is authorized. Synthetic-only and all existing safeguards remain in force.

See the [M3 Project Progress Report](docs/04-roadmap/PROJECT_PROGRESS_REPORT.md), [ADM-C Implementation Closeout](docs/04-roadmap/ADM_C_INSTITUTION_CAMPUS_WORKFLOW_CLOSEOUT_2026-11-21.md), and [ADM-B Workspace Closeout](docs/04-roadmap/ADM_B_WORKSPACE_IMPLEMENTATION_CLOSEOUT_2026-11-21.md).

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
