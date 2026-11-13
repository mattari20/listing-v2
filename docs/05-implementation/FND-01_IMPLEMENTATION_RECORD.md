# FND-01 — Laravel 13 Foundation Implementation Record

**Repository:** \`mattari20/listing-v2\`  
**Branch:** \`feature/m3-foundation-01\`  
**Authorization:** Product Owner statement received 2026-11-13; bounded local workstation and GitHub CI scope only  
**Status:** Implementation candidate — exact-head CI and Product Owner review pending

## Delivered in this slice

- Laravel 13 application scaffold with committed \`composer.json\` and \`composer.lock\`.
- PHP 8.5 / Composer 2 execution baseline.
- Fixed \`GET /health\` JSON response containing only a constant status, application identifier and FND-01 marker.
- Deeni Madaris visibility policy seam backed by \`config/directory.php\`, defaulting to false.
- Feature/unit tests for the health response and fail-closed default-OFF policy.
- GitHub Actions workflow for PRs to \`main\` and pushes to \`feature/m3-foundation-01\`.
- Immutable action pins: \`actions/checkout\` at \`11d5960a326750d5838078e36cf38b85af677262\` (v4.2.2); \`shivammathur/setup-php\` at \`eb7c497e18156a6bbabfef1d3a82760b9eda3962\` (2.40.0).
- Composer defaults for cache, session, queue and maintenance store use array/sync drivers so current foundation behavior does not require a database.
- PHPUnit configuration contains no SQLite or database connection settings.

## Reproducible local checks

Use PHP 8.5 and Composer 2:

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

The CI workflow runs the same core checks on the exact pull-request revision. CI has read-only repository permissions and no deployment, migration, database provisioning, production secret or external service credentials.

## Explicit exclusions and hygiene

- No migration files, database configuration file, SQLite file, schema, database creation, seeding or database writes.
- No Hostinger, V1, production, SSH, hPanel, DNS or deployment access.
- No real institute, source, personal, student, child or staff data. Tests contain no domain records; all fixtures are synthetic by construction.
- No authentication, directory pages, institute records, source ingestion, external APIs, AI, queues, Redis, payments, analytics or public data surface.
- No \`.env\`, vendor tree, Node dependencies, logs or generated runtime caches are committed.
- Laravel's framework \`/up\` health route remains framework-provided; the FND-01 contract is the separately tested \`/health\` route.

## Acceptance evidence status

| Acceptance ID | Evidence/status |
|---|---|
| FND-01 | Lockfile committed; locked install must pass on clean CI |
| FND-02 | Laravel bootstrap and route listing checked by CI |
| FND-03 | Fixed \`/health\` response has a feature test |
| FND-04 | \`.env\` ignored; workflow checks tracked artifact hygiene |
| FND-05 | Default-OFF policy seam and unset fail-closed tests added |
| FND-06 | Tests contain no real or copied domain data |
| FND-07 | CI is local/runner-only, read-only permissions; no deploy/database commands |
| FND-08 | Composer, Pint, Laravel tests, Composer audit and docs validator run in CI |
| FND-09 | Tracked artifact hygiene check added |
| FND-10 | Scope review required against the complete PR diff |
| FND-11 | Setup commands and limitations recorded here and in README |
| FND-12 | Product Owner exact-diff review remains pending |

## Known limitations

This is a local/CI foundation only. It does not establish Hostinger compatibility, runtime isolation, capacity, recovery, legal/privacy/source-rights/safeguarding/security approval, or production readiness. The visibility seam is not an authorization to publish or collect any records. No migration command has been run.
