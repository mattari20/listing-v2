# M3-12 — Private Preview and Synthetic Dataset

**Date:** 2026-11-18  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `5e68ac4ba70db0461a902832cb6ed483640b9a4c`  
**Branch:** `feature/m3-12-private-preview-dataset`  
**Status:** Implementation prepared; exact-head CI and review pending.  
**Authorization:** Product Owner approved the bounded local-only synthetic preview package on 2026-11-18.

## 1. Purpose

Provide a repeatable, fictional dataset so the existing server-rendered directory and profile routes can be inspected in a local private preview. This package populates the existing governance/publication model; it does not bypass the approved projection query path.

## 2. Delivered scope

- Added `Database\Seeders\PrivatePreviewDirectorySeeder`.
- Seven fictional entities across all five supported public categories: provider (1), institution (2), campus (1), programme (2), qualification (1).
- Each example has a synthetic display name, clearly fictional overview and text-only locality fields.
- Each fact is created with synthetic evidence, an audit event, a human adjudication workflow, an explicit publication decision and the existing outbox projection process.
- Seeder is idempotent: a source-family marker causes a subsequent run to make no changes.
- Before writing, it refuses to run while unrelated outbox items are pending or leased; it requires all 42 expected synthetic publication events to be processed successfully inside the seed transaction.
- Evidence recorder, case opener, adjudicator and publisher actor identities are distinct for each synthetic fact.
- Added feature tests for category coverage, anonymous directory/profile rendering, idempotence and production-environment refusal.
- No changes to runtime routes, views, schema, dependencies or existing public query behavior.

## 3. Mandatory safety guards

The seeder throws before writing unless both conditions hold:
1. Laravel environment is `local` or `testing`.
2. Active database driver is `sqlite`.

It uses only fabricated records. No real institution/provider claims, source material, student data, contact details, physical addresses or live source references are included. No external services, APIs, AI models, new dependencies, spend or network calls are used.

Deeni Madaris is not represented or enabled. The dataset does not activate applications, admissions, fees, scholarships, UGC, ratings, reviews, public moderation, AI ingestion or geospatial discovery.

## 4. Local execution

Use a disposable/local SQLite database only. Confirm `.env` has `APP_ENV=local`, `DB_CONNECTION=sqlite` and a local SQLite database path. Then run:

```bash
php artisan migrate
php artisan db:seed --class='Database\Seeders\PrivatePreviewDirectorySeeder'
php artisan serve
```

Open `/directory` in the local development server. The seeder refuses production/staging environments and non-SQLite connections. Do not run it against Hostinger, V1, production or any shared/hosted database.

## 5. Acceptance evidence

| Criterion | Evidence |
|---|---|
| All five supported category types represented | Seeder fixture definition and feature test |
| Search/facets show seven synthetic records | `PrivatePreviewDirectorySeederTest` |
| Public profiles render via existing route | `PrivatePreviewDirectorySeederTest` |
| No duplicate records on repeated run | Idempotence feature test |
| Production environment fails closed | Production guard feature test |
| No schema, runtime route, dependency or production changes | PR diff review |
| Existing outbox work is not swept into preview processing | Pending/leased outbox preflight and exact 42-event completion check |

Exact-head PHP 8.5 foundation CI and documentation validation results must be added after the PR checks complete. A successful CI run is not a browser review or production acceptance.

## 6. Explicit non-goals and remaining gates

This is a local demonstration dataset, not a release candidate, hosted private environment, production readiness assessment, pilot or launch. M3-10 pilot readiness remains NOT ACCEPTED. M3-11 remains BLOCKED / NOT ACCEPTED pending qualified legal/privacy/safeguarding review, independent security/accessibility assessment, written human role acceptance, V2 environment isolation, recovery evidence, candidate verification and a human go/no-go decision.

No production access, V1 access, Hostinger/hPanel access, migrations on hosted systems, deployment, URL cutover, public pilot, participant research, real data, external source collection or spend is authorized.

## 7. PR and review status

PR number, exact head SHA, required check run IDs and review disposition are recorded in the PR and reconciled here after validation. This package is not merged by this record; merge requires separate Product Owner approval.
