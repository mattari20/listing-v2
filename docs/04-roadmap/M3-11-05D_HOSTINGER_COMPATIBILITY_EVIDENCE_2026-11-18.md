# M3-11-05D — Hostinger Compatibility Evidence (Initial hPanel Review)

**Evidence date:** 2026-11-18  
**Evidence source:** Product-owner-provided screenshots from the Hostinger hPanel for the existing `estudent.pk` website.  
**Repository status:** Evidence record only. Product-owner-operated password protection was enabled for the V2-only directory as documented below; no application deployment or database operation occurred.

## Purpose and limits

This record captures only what is visible in the supplied screenshots. It is not a hosting acceptance, deployment approval, security audit, or confirmation that the current plan is sufficient for V2. Account identifiers, database names, usernames, and credentials are intentionally omitted. Screenshots are not copied into the repository.

## Observed hosting and resource information

The hPanel dashboard identifies the plan as **Premium Web Hosting** and shows:

- PHP version selected for the website: **8.5**.
- Disk allocation: **25 GB**, with **9.47 GB** shown as used at capture time.
- Inodes: approximately **62.36K / 400K**.
- Websites: **2 / 25**.
- CPU usage: **26%** at the dashboard capture.
- Memory usage: **100 MB** at the dashboard capture.
- The resource values are point-in-time dashboard readings, not guaranteed V2 capacity or headroom.

The PHP Configuration page shows PHP 8.5 selected. Follow-up screenshots of the **PHP extensions** tab show the following relevant entries checked: `pdo`, `nd_pdo_mysql`, `mysqlnd`, `mbstring`, `fileinfo`, `openssl`, `curl`, `tokenizer`, `xml`, `ctype`, and `zip`. `pdo_sqlite` is also checked. The screenshots show the Hostinger extension label `nd_pdo_mysql`; they do not independently prove that the PHP runtime exposes the exact PDO MySQL driver name expected by Laravel (`pdo_mysql`). Runtime confirmation remains required. No extension selections were changed.

## Observed database inventory

The Databases page displays **three existing database entries**. All three show external connections **Off** and state **Assigned**. The displayed sizes are approximately **10 MB**, **1 MB**, and **852 MB**.

This is an inventory observation only. The screenshots do not establish the database engine/version, plan-level database quota, maximum database count, per-database size limit, host/grant details, or whether a separate V2 database can be provisioned. Existing database names and usernames are deliberately not recorded here.

## Observed File Manager layout

The File Manager screenshot is open at `public_html` and shows, among other entries:

- Existing `institutes` directory.
- Existing `cv-builder` and `cv-builder-v2` directories.
- WordPress directories `wp-admin`, `wp-content`, and `wp-includes`.
- A visible `.htaccess` file and a `.private` directory.

The directory listing shows directory permissions in the displayed `drwxr-xr-x` form and regular-file permissions in the displayed `-rw-r--r--` form for the visible entries.

**Security implication requiring verification:** the existing `institutes` directory is located under `public_html`, which is the visible web-root directory in this File Manager view. The screenshot does not prove whether that directory is publicly reachable, protected by rewrite/access rules, or mapped to a different document root. Do not place Laravel application source, `.env`, `vendor`, private storage, logs, backups, or secrets in a web-accessible location. Before any hosted V2 preview, verify the actual document-root mapping and direct HTTP access boundaries, including static files.

The screenshot does not show the contents of the `institutes` directory, the account home-directory layout outside `public_html`, symlinks, or server-level virtual-host configuration.

## V2 directory password protection — enabled by product owner

Follow-up hPanel screenshots show that the product owner selected the directory path `/institutes-v2`, entered a dedicated username, and successfully created a protected-directory entry. The subsequent protected-directories list displays `/institutes-v2` with the configured username. The username is intentionally not copied into this repository record; the password was masked in the supplied screenshot and is not recorded.

This is positive evidence that Hostinger's directory-protection feature accepted the V2 subfolder path and listed it as protected. It is **not yet proof** that the protection is enforced for every request path, all static assets, nested paths, alternate hostnames, or direct file URLs. A controlled verification must be performed later using only a harmless synthetic test file/request and the V2 path, without touching WordPress or existing V1 routes. The V2 directory is currently empty according to the product owner's statement. No application files have been deployed there.

The protected-directory setup is a real hPanel state change explicitly performed by the product owner. No other hosting setting was changed. The preview credential must remain private, be stored in the product owner's password manager, and never be committed to Git or sent in chat.

## Observed backup configuration

The Backups page shows:

- Automated backups: **Weekly**.
- Latest backup displayed: **2026-11-15 06:46**.
- Next backup displayed: **2026-11-22**.
- Manual backups are shown as **Locked**, with an upgrade prompt.
- The page states that website backups include website files and the database.
- The page also states that some files are excluded from backups, specifically backup-plugin archives, cache, and database export files.
- The restore/download interface exposes separate **Website backup**, **Files backup**, and **Database backup** selections.

These screenshots do not prove that a V2-only restore can be performed safely, that files and database can be restored independently without affecting V1, the retention period, restore duration, backup consistency, or whether the visible exclusions intersect with V2 data. No restore or download action was taken.

## Compatibility assessment

| Area | Evidence status | Assessment |
|---|---|---|
| Hosting plan and headline resources | Observed | Initial evidence only; available headroom for V2 is not established |
| PHP version | PHP 8.5 selected | Version observed; required extensions remain unverified |
| MySQL/PDO support | Not shown | Blocked pending extension and database details |
| Existing database inventory | Three entries; external connections Off | Separate V2 database capacity and engine compatibility unverified |
| V2 document-root isolation | Existing `institutes` folder under `public_html` | Security boundary unresolved |
| Private preview protection | hPanel protected-directories list displays `/institutes-v2` | Directory protection configured; full-path and static-asset enforcement still requires controlled verification |
| Backup/restore separation | Weekly backup; website/files/database choices visible | V2-only recovery boundary and retention unverified |
| No-extra-spend feasibility | No upgrade performed | Not established; do not purchase an upgrade |

## Safety and scope decisions

- Product owner enabled password protection specifically for `/institutes-v2`; no other hPanel setting was changed.
- No database was created, modified, connected to, or deleted.
- No files or directories were created, moved, renamed, edited, or deleted on Hostinger.
- No backup was restored or downloaded.
- No PHP version was changed.
- No deployment, DNS, public preview, or V1/production access was performed.
- No additional hosting spend was approved.
- Existing V1/WordPress service must remain untouched.
- V2 work remains repository-only and synthetic-only until a separately authorized hosted target and isolation plan exist.

## Remaining evidence required for M3-11-05D

1. **PHP runtime confirmation:** the PHP extensions tab has now been inspected. Confirm the actual runtime reports the PDO MySQL driver (for example through the hosting PHP Info page, without exposing configuration secrets). Do not change extension selections during evidence collection.
2. **Database plan limits and engine:** inspect the plan database quota/details and, if available without opening or exposing credentials, the database engine/version and limits. Do not create a database.
3. **Directory protection enforcement:** password protection is now configured for `/institutes-v2`. Verify it later with harmless synthetic requests for the directory, nested path, and static asset. Confirm the existing website and `/institutes` remain unaffected. Do not share or commit the preview password.
4. **Document-root and filesystem isolation:** determine whether V2 can keep application source and sensitive runtime paths outside the web root while serving only Laravel `public/`. Confirm permissions and storage separation without modifying files.
5. **Backup semantics:** establish retention and whether an isolated V2-only file/database recovery is possible without restoring or overwriting the existing website. Do not run a restore rehearsal on the current website.

After these facts are collected, update the compatibility decision. If the account cannot provide safe V2 isolation and a V2-only recovery boundary within the existing plan, record the limitation rather than weakening the security boundary or assuming an upgrade.

## Current disposition

**M3-11-05D remains IN PROGRESS / PARTIALLY VERIFIED / NOT ACCEPTED.** PHP extension configuration is partially evidenced and password protection is configured for `/institutes-v2`. Runtime driver confirmation, actual protection enforcement, document-root isolation, database limits, and V2-only recovery remain outstanding.
