# M3-11-05A — Local synthetic preview and test dataset

**Status:** Implementation delivered for review; local execution and visual owner review remain pending.  
**Scope:** Local-only, disposable SQLite preview. This is not hosted environment isolation (M3-11-05), backup/recovery (M3-11-06), pilot, release or production readiness.

## What is included

The explicit `Database\\Seeders\\LocalPreviewSeeder` creates five fictional institution profiles, five campus records, five programme records and five admission offers using the existing claim, evidence, adjudication, publication and catalogue-materialization workflows. The profiles cover Lahore, Karachi, Peshawar, Quetta and Islamabad so the existing directory can be inspected for:

- anonymous directory cards and direct institution profiles;
- name/overview search;
- province, district, city and locality display/filter behavior;
- approved publication projection behavior;
- institution profile sections for campuses, programmes and their admission offers.

All names and descriptions are invented. Geographic labels are real place names used only as test geography; they do not identify real institutions. No contact details are included. No child, student, guardian or staff records/fields are created. No Deeni Madaris records are created. No external source is fetched or represented as a real source.

The seeder is never called by the default `DatabaseSeeder`. It refuses to run unless all of these conditions hold:

1. `APP_ENV=local`;
2. active database driver is SQLite;
3. the configured SQLite database filename is exactly `.local-preview.sqlite`;
4. `LOCAL_PREVIEW_SEED=allow` is explicitly set;
5. no prior local preview marker records exist.

It never deletes, truncates or overwrites records. If it detects an existing preview dataset, use a new dedicated disposable database file rather than rerunning it.

## Local preview setup

Run from the V2 repository root in a local development checkout only. Do not run in Hostinger, production, V1, a shared environment or against any remote database.

1. Install the already-locked dependencies using the repository's normal setup.
2. Create an empty, untracked database file at `database/.local-preview.sqlite`.
3. In the local-only `.env`, set:

   ```dotenv
   APP_ENV=local
   APP_DEBUG=true
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/listing-v2/database/.local-preview.sqlite
   LOCAL_PREVIEW_SEED=allow
   ```

   Keep the absolute path local to your checkout. Do not commit `.env` or the SQLite file. Do not use `config:cache` for this one-off setup unless you have confirmed these values are loaded.

4. Run the migrations against that explicitly configured disposable SQLite file:

   ```bash
   php artisan config:clear
   php artisan migrate
   ```

5. Run the explicit preview seeder:

   ```bash
   php artisan db:seed --class='Database\\Seeders\\LocalPreviewSeeder'
   ```

6. Start the local Laravel server and open the directory:

   ```bash
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000/directory`. Open a fictional institution profile from a result card. Try searches such as `Crescent`, `Riverbend`, and locality filters `Lahore`, `Gulberg`, `Karachi`, and `Gulshan`. Open each of the five institution profiles and confirm its synthetic campus, programme and `Synthetic 2027 Intake` offer are shown.

## Reset and cleanup

The seeder deliberately does not reset an existing database. To start over, stop the local server, confirm that the configured file is exactly `database/.local-preview.sqlite`, delete only that dedicated local preview file, recreate an empty file at the same path, and rerun `php artisan migrate` followed by the explicit seeder command. Never use `migrate:fresh` against any non-disposable database.

When finished, stop the server and remove the dedicated preview database file if it is no longer needed. The file is local test data and must not be committed or uploaded.

## Validation and limits

The CI test verifies the seeder refuses the PHPUnit/testing environment. The standard FND-01 suite continues to use in-memory SQLite. A successful CI run does not mean a browser preview has been launched. The owner must run the local commands above to see the rendered pages. This package does not test hosted isolation, backups, restore, rollback, security headers at the hosted edge, accessibility with assistive technology, production load, or real-world data quality.
