# M3-11-05 — Status and Handoff

## Latest update — Hostinger database and PDO evidence captured (2026-11-18)

Owner-provided redacted hPanel screenshots now confirm a newly created dedicated MySQL database for Listing V2: database `u537436044_institutes`, user `u537436044_institutes_app`, host `srv1278.hstgr.io`, port `3306`, assigned/full access, 1 MB shown, created 2026-11-18, and external connections OFF. PHP Info explicitly confirms PHP Version `8.5.12` and the response header `X-Powered-By: PHP/8.5.12`. PDO drivers are `mysql, sqlite`; PDO MySQL is enabled; mysqlnd is `8.5.12`.

Detailed evidence and handling restrictions are recorded in [M3-11-05D Hostinger PHP and Dedicated Database Evidence](M3-11-05D_HOSTINGER_PHP_AND_DEDICATED_DATABASE_EVIDENCE_2026-11-18.md). The owner has selected the existing `/public_html/institutes-v2` folder for V2. Its File Manager listing shows `.htaccess` (289 B) and `.htpasswd` (116 B) as the only visible entries; their contents and actual protection coverage are unverified. No files were changed. The password is intentionally excluded. No database connection, external access enablement, migration, import, deployment, or hPanel configuration change has occurred.

**Dedicated V2 database created:** OBSERVED.  
**PDO MySQL:** OBSERVED ENABLED.  
**PHP version:** CONFIRMED — 8.5.12.\n**Owner-selected V2 directory:** `/public_html/institutes-v2` (observed in File Manager; contents and Laravel public-root mapping not verified).  
**Laravel hosted DB connection:** NOT TESTED.  
**Hosting plan/resource limits, document root, subfolder placement, static-file protection, filesystem/storage isolation and backup boundary:** NOT VERIFIED.  
**Hosted isolation acceptance:** BLOCKED / NOT ACCEPTED.  
**Provisioning/deployment:** NOT PERFORMED OR AUTHORIZED.

---



## Latest update — repository subfolder readiness delivered (2026-11-18)

Repository-side subfolder preparation is delivered through PRs #293, #294 and #295. PR #295 merged as `09ae3ff31462cb2bf85566c5f9963565c067a69f` from exact head `f8b50d7308f386be3768603f00717d53c875e1be`; FND-01 PHP 8.5 CI #496 and documentation validation #933 passed. The repository now supports a configurable MySQL connection, a V2-specific session cookie with configurable subfolder path and an opt-in global Laravel HTTP Basic preview gate. SQLite remains the local/CI default.

**Repository implementation:** DELIVERED.  
**Hostinger plan/PHP/PDO MySQL compatibility:** NOT VERIFIED.  
**V2 database/resource:** NOT CREATED.  
**V2 storage path/permissions:** NOT VERIFIED.  
**Hosting-level protection for static files and the full subfolder URL:** NOT VERIFIED.  
**Runtime/filesystem/configuration isolation:** NOT VERIFIED.  
**Hosted isolation evidence:** 0/18 items verified.  
**Provisioning, hPanel changes and deployment:** NOT PERFORMED / NOT AUTHORIZED.  
**M3-11-05:** BLOCKED / NOT ACCEPTED.

The unlinked URL is not access control. The Laravel gate only protects requests that enter Laravel; the web server must separately protect static files and the full V2 path before any hosted preview. Continue with read-only hosting capability verification and later exact-scope authorization; do not create resources or deploy under this package.

---


**Date:** 2026-11-17  
**Package:** Runtime and Environment Separation

## Delivered

- V2-only runtime/resource separation principles.
- Logical environment inventory and evidence requirements.
- Isolation verification sequence and stop conditions.
- 18-item isolation evidence checklist.
- Exact-scope authorization and evidence register.
- Explicit handoff and blocked status.

## Evidence-based status

**Repository preparation:** DELIVERED.  
**Environment target:** NOT IDENTIFIED.  
**Provisioning or hosted access:** NOT PERFORMED / NOT AUTHORIZED.  
**Isolation evidence:** 0/18 items verified; no target inspected.  
**Independent security review of hosted isolation:** NOT RECEIVED.  
**M3-11-05:** BLOCKED / NOT ACCEPTED.

## Required next input

The Product Owner must provide a separate exact-scope authorization identifying the V2-only target, resources, permitted actions, time window, cost/vendor decision and accountable human provisioner. Named operations, security and recovery owners must accept their roles. Only then may a separately bounded provision-and-verify step be considered.

## Handoff

No Hostinger/hPanel, production/V1, live database, DNS, deployment, migration, real data, external service, public ingress, participant activity or spend was used. No environment is claimed to exist or be isolated. This package does not authorize M3-11-06 recovery rehearsal or downstream release activity.


## Latest update — selected V2 folder contents inspected (2026-11-18)

The owner-provided File Manager screenshot of `/public_html/institutes-v2` shows two visible files: `.htaccess` (289 B) and `.htpasswd` (116 B), each last modified "an hour ago", with permission display `-rw-r--r--`. No Laravel application files/directories are visible in the listing. The folder is therefore not empty. The screenshot does not prove hidden-entry completeness or that password protection is active/correct or covers static assets; neither file's contents were inspected. Do not overwrite/delete these files. No Hostinger change was made.

**Selected folder:** OBSERVED.
**Visible folder contents:** TWO FILES OBSERVED.
**Password protection correctly configured / full-path coverage:** NOT VERIFIED.
**Laravel public-root mapping / rewrite behavior:** NOT VERIFIED.
**Deployment or file changes:** NOT PERFORMED / NOT AUTHORIZED.


## Latest update — Hostinger-generated Basic Authentication rule inspected (2026-11-18)

The owner-provided `.htaccess` screenshot shows Hostinger-generated marker comments plus `AuthType Basic`, `AuthName "Restricted Access"`, an `AuthUserFile` path pointing to `/home/u537436044/domains/estudent.pk/public_html/institutes-v2/.htpasswd`, and `Require valid-user`. This establishes that a Basic Authentication rule is configured in the file. It does not prove live enforcement, static-asset coverage, inheritance/no child overrides, or denial of direct `.htpasswd` retrieval. The `.htpasswd` contents/hash were not opened or recorded. Preserve the generated marker block; do not edit or delete it. No hosted request, credential use, file change or deployment occurred.

**Basic-auth directives present:** OBSERVED.
**Actual full-path enforcement / static-file challenge:** NOT YET VERIFIED.
**Direct `.htpasswd` HTTP denial and filesystem access safety:** NOT YET VERIFIED.
**M3-11-05 hosted isolation acceptance:** BLOCKED / NOT ACCEPTED.


## Latest update — Hostinger PHP configuration recorded (2026-11-18)

Owner-provided PHP Configuration screenshots show PHP 8.5 selected; the separate PHP Info screenshot identifies PHP 8.5.12. PDO, `nd_pdo_mysql`, `mysqlnd`, `nd_mysqli`, `pdo_sqlite`, and `sqlite3` are visibly enabled. PHP Info separately confirms PDO drivers `mysql, sqlite` and PDO MySQL client API `mysqlnd 8.5.12`. Other checked extensions are recorded in the M3-11-05D evidence document. No PHP version or extension settings were changed.

**PHP/PDO configuration evidence:** OBSERVED / SUITABLE AT CONFIGURATION LEVEL.
**Live Laravel MySQL connection and hosted subfolder runtime test:** NOT PERFORMED.
**Hosted isolation / M3-11-05 acceptance:** BLOCKED / NOT ACCEPTED.


## Product Owner decisions — current-stage controls (2026-11-18)

The Product Owner accepts the existing Hostinger directory password protection as the selected private-preview control and does not require a second IP restriction layer at this stage. The Product Owner accepts existing weekly automated backups as sufficient for the current development stage and does not approve a paid backup upgrade or increased frequency. The existing hosting plan is to be retained without additional spend.

These are owner decisions about the selected controls and cost/frequency policy. They do not establish successful live authentication enforcement, static-file coverage, V2-only restore capability, or production recovery objectives. M3-11-05 remains partially evidenced and is not technically accepted for hosted preview or deployment until the remaining safe isolation checks are completed.
