# M3-11-05D — Hostinger Evidence Record (2026-11-18)

## Purpose and handling

This record captures owner-supplied, redacted hPanel screenshots for repository planning. It contains no passwords, database credentials, account identifiers, or exact database/user names. Do not add secrets or unredacted account screenshots to this public repository.

Evidence is observational only. No hPanel settings, databases, files, DNS, or hosting resources were changed as part of this review.

## Verified from supplied screenshots

### Hosting and resource snapshot

- Hosting plan label shown: **Premium Web Hosting**.
- Dashboard resource snapshot: disk **9.47 GB / 25 GB**; inodes **62.35K / 400K**; websites **2 / 25**.
- Dashboard site-health panel reports **PHP 8.5**.
- Dashboard showed LiteSpeed and SSL active; CDN status appeared inactive.
- These are point-in-time dashboard readings, not guaranteed remaining capacity for a new application.

### PHP runtime and database drivers

- PHP selector showed PHP **8.5** selected.
- PDO support is enabled.
- PDO drivers reported: **mysql, sqlite**.
- PDO MySQL extension/driver reported enabled; client API reported **mysqlnd 8.5.12**.
- PDO SQLite is also available.
- The screenshots show the relevant extension checkboxes enabled. No extension settings were changed.
- This confirms driver availability only; it does not prove a Laravel V2 database connection or runtime compatibility.

### Existing database inventory (identifiers intentionally redacted)

- hPanel displayed **three** assigned databases.
- Displayed database sizes were **10 MB**, **1 MB**, and **852 MB**.
- External connections were **Off** for all three displayed entries.
- The 10 MB entry was labelled for Institutes; the 1 MB entry was labelled for CV Builder; the 852 MB entry was another existing database.
- Database names, usernames, hostnames, and credentials are intentionally excluded from this public record.
- The screenshot does not show the plan's maximum database count, remaining database quota, server engine/version, database host, or grants.
- No new database was created, and no existing database was opened, changed, deleted, or repurposed.

### V2 subfolder and ingress protection

- The File Manager screenshot showed the website's `public_html` containing an `institutes-v2` folder alongside existing website folders. The owner stated that `institutes-v2` was empty at the time of review.
- hPanel's Password Protect Directories screen showed a protection entry for `/institutes-v2`.
- The owner confirmed the password protection setup completed. The credential and username are not recorded here.
- This is useful evidence of a directory-level protection option, but coverage of every static file, rewrite behavior, and interaction with Laravel routes still requires controlled verification before any hosted preview.
- Do not add a second protection layer unless a later test demonstrates a gap; do not weaken or remove the existing protection during this evidence phase.

### Backups

- Backups screen showed **weekly** automated backups.
- Latest backup visible in the screenshot: **2026-11-15 06:46**.
- hPanel warned that some files are excluded from backups, including plugin archives, cache, and database export files.
- The restore/download UI distinguished website, files, and database backup views. The website-backup description said it includes website and database.
- Manual backups appeared locked on the displayed plan; daily backups were presented as a paid add-on.
- A V2-only backup/restore boundary and a V2-only restore rehearsal have **not** been demonstrated. Do not assume a whole-website restore can safely restore V2 independently.

## Assessment

**Positive evidence:** PHP 8.5 and PDO MySQL are available; a dedicated V2 subfolder exists; directory password protection has been configured; the dashboard shows current resource usage; three existing assigned databases are visible.

**Still unverified / blocked:**

1. Plan database quota and whether another database can be created without an upgrade.
2. MySQL/MariaDB server version, database host, grants, per-database limits, and actual V2 connection test.
3. Whether the host can serve only Laravel's `public/` directory while keeping application code, `.env`, `vendor/`, `storage/`, logs, sessions, cache, and backups outside the web root or reliably denied.
4. Whether directory password protection covers all static assets and all requests under the V2 URL, including rewrite behavior.
5. Exact subfolder `APP_URL`, session cookie path, HTTPS behavior, redirects, CSRF, and asset URLs.
6. V2-specific storage/cache/session separation and backup/restore isolation.
7. Backup exclusions, retention, recovery point/time objectives, and a safe V2-only restore rehearsal.

## Safety and next evidence request

- Keep V2 synthetic-only and private.
- Keep the existing `/institutes-v2` password protection in place; do not share its password.
- Do not create a database or change hosting settings until database quota and isolation requirements are understood and the owner gives explicit, scoped authorization.
- Next: open **View plan databases** in hPanel and provide a screenshot of the database limits/usage. Then inspect the existing Institutes database's non-secret metadata only (engine/version/host/grants if shown); do not expose credentials.
- No production/V1 access, deployment, DNS changes, new spend, or live data use is authorized by this evidence review.

## Status

M3-11-05D remains **IN PROGRESS / BLOCKED** pending the missing hosted facts above. The evidence supports PHP driver readiness, not full Hostinger compatibility acceptance.
