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
