# eStudent Institutes V2 — `listing-v2`

An independent, greenfield education discovery and decision-support platform for students in Pakistan.

## Project status

- **Repository:** `mattari20/listing-v2`
- **Project phase:** M3 — Controlled Implementation; M0, M1, M2 and M3-00 accepted/closed
- **Application implementation:** FND-01 delivered and merged; bounded M3-02 local/CI foundation hardening in progress on `feature/m3-02-foundation-hardening`
- **Production connection or deployment:** Not authorized
- **Governing documentation:** Established in `docs/`; see the Documentation Index and Completion Catalogue

## Purpose

Help students discover nearby government and private educational institutions, explore classes and academic programmes, understand admissions and costs, compare institutions, and share trustworthy ratings and reviews.

The platform will also maintain a continuously refreshed, evidence-based education data catalogue using multiple lawful data providers and a governed AI-assisted collection process.

## Current milestone

M0, M1, M2 and M3-00 are accepted and closed. M3-01's bounded FND-01 package is delivered and merged; remaining M3-01 gates remain open. M3-02 has a separate bounded local/CI-only foundation hardening authorization; it does not authorize Hostinger/V1/production, database work, real data, external APIs/AI or deployment.

## Start here

Start with [`docs/README.md`](docs/README.md), then read [`PROJECT_MASTER_CONTROL.md`](docs/00-foundation/PROJECT_MASTER_CONTROL.md). The [`Documentation Completion Catalogue`](docs/04-roadmap/DOCUMENTATION_CATALOG.md) tracks delivery, review and acceptance.

## Independence and safety

This is a new project. The legacy `mattari20/estudent-listing` repository and the live eStudent.pk website must remain untouched by V2 development. No legacy requirements, knowledge, historical findings, implementation, data, architecture, workflows or processes may influence V2. Legacy material is excluded; V2 inputs must originate only from direct V2 owner requirements, independent research and independently validated V2 decisions.

No production database operation, production deployment, public URL cutover, or replacement of the live service is authorized by ordinary development work. Each requires separate explicit approval and verified backup/recovery safeguards.


## Current project status — M3

M0, M1 and M2 are accepted and closed; M2 is 100% complete. M3-00 — Mobilization and Decision Closure — is the current documentation/planning step. T01 is complete; T02-T06 are in progress; T07-T08 remain open. T04-T06 decision frameworks have been delivered, but final decisions and supporting evidence remain pending. No partial task percentages are claimed. M3-00 remains 10% pending remaining decisions and evidence. See [M3 Master Step Plan](docs/04-roadmap/M3_MASTER_STEP_PLAN.md) and [M3-00 Mobilization](docs/04-roadmap/M3-00_MOBILIZATION_AND_DECISION_CLOSURE.md). Application implementation remains unauthorized pending a separate explicit M3-01 start authorization. Production access, source ingestion, procurement, deployment and launch remain separately gated.


Latest M3-00 owner-input documentation: PR [#102](https://github.com/mattari20/listing-v2/pull/102) passed Project documentation validation (run #43198671760) and merged as `cc5a4966cca74df5e15de7f15277814ddb86d6d9`. T02/T03 are in progress; M3-00 remains 10%. No implementation or spend is authorized.


M3-00 T04 budget framework: PR [#104](https://github.com/mattari20/listing-v2/pull/104) passed required documentation validation (run #43199037952) and merged as `7b5c31af83bb18b2c5578ddb7cc3dd705f25d08e`. Numeric ceilings and paid-service permission remain undecided; no new spend is authorized.


M3-00 T05 technology framework: PR [#106](https://github.com/mattari20/listing-v2/pull/106) passed required documentation validation (run #43199371616) and merged as `04ba57a98e434d05069bd0cc4c0de3e05bcacac8`. No technology is selected; implementer skill fit and support/cost/hosting evidence remain open.


PR [#107](https://github.com/mattari20/listing-v2/pull/107) reconciled PR #106 technology-framework delivery; exact-head validation passed (run #43199505084) and merge commit is `137130caa046804fb02a42d9a98e01d855601401`. T05 remains in progress; no technology selected.


M3-00 T06 hosting framework: PR [#109](https://github.com/mattari20/listing-v2/pull/109) passed required documentation validation (run #43199827073) and merged as `5e55f1fe69dce25d0ab2357fef050b9120002579`. No hosting provider/region is selected; service support, costs, latency, data terms and operations ownership remain open.


Latest M3 delivery audit (2026-11-12): PRs #102–#110 are all closed and merged, and required documentation validation passed on each exact PR head. Latest merge PR #110: `a328a8272b086cac6270dc625d53ea6c3bbc1fa7`. Current task status: T01 complete; T02-T06 in progress; T07-T08 open. M3-00 remains 10%; M3 overall 0.5%. No implementation or new spend is authorized.


## FND-01 local foundation checks

The FND-01 Laravel 13 foundation is isolated to local development and GitHub CI. It does not connect to V1, Hostinger or production and does not require a database.

Requirements: PHP 8.5 and Composer 2.

\`\`\`sh
composer validate --strict
composer install --no-interaction --prefer-dist --no-progress --no-scripts
composer audit --locked
vendor/bin/pint --test
php artisan config:clear
php artisan route:list --except-vendor
php artisan test
python3 scripts/validate_project_docs.py
\`\`\`

The synthetic-only \`GET /health\` endpoint returns fixed status metadata. The Deeni Madaris visibility policy seam defaults to false. No migrations, database setup, deployment, Hostinger/V1 access or real data are part of FND-01. See [FND-01 implementation record](docs/05-implementation/FND-01_IMPLEMENTATION_RECORD.md).


## M3-02 foundation hardening — 2026-11-13

The bounded local/CI-only M3-02 hardening candidate is under review on `feature/m3-02-foundation-hardening`. It adds safe environment defaults, warning-level logging, deterministic PHPUnit environment checks and an environment/diagnostics policy. No new dependency, paid service, database, production secret, external telemetry or deployment is added. See [M3-02 implementation record](docs/05-implementation/M3-02_LOCAL_CI_FOUNDATION_HARDENING_IMPLEMENTATION_RECORD.md) and [environment/diagnostics baseline](docs/05-implementation/M3-02_ENVIRONMENT_CONFIGURATION_AND_DIAGNOSTICS.md). Exact-head CI and owner review are pending.
