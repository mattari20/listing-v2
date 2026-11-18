# M3-11-05D — Hostinger PHP/PDO and Dedicated V2 Database Evidence

**Evidence date:** 2026-11-18  
**Source:** Product Owner-provided redacted hPanel screenshots for `estudent.pk`.  
**Purpose:** Preserve the observed hosting/database facts for later V2 configuration. This record is not authorization to deploy, migrate, expose, or connect to the hosted database.

## 1. Dedicated V2 database — observed

| Setting | Observed value |
|---|---|
| Provider/service | Hostinger MySQL |
| Database | `u537436044_institutes` |
| Database user | `u537436044_institutes_app` |
| Host | `srv1278.hstgr.io` |
| Port | `3306` |
| Access shown | Full access for the assigned database user |
| External connections | Off; no external connections configured |
| Size at capture | 1 MB |
| Created | 2026-11-18 |
| State | Assigned |

The owner created this database after deleting the prior empty/dummy `Institutes` database. The new database is intended to be reserved for `mattari20/listing-v2`. The existing CV Builder database and the large `cz7OP` database are separate and must not be used or modified for this V2 work.

**Credential handling:** The database password is deliberately not recorded in this document, Git, issues, or chat. The owner must retain it in a password manager or protected hosting configuration and enter it only into the eventual protected V2 environment. Never ask the owner to paste it into chat.

## 2. PHP/PDO evidence — observed

The owner-provided hPanel PHP Info screenshots confirm:

- **PHP Version: `8.5.12`**, explicitly displayed at the top of PHP Info.
- The response header also displays `X-Powered-By: PHP/8.5.12`.
- PDO support: enabled.
- PDO drivers: `mysql, sqlite`.
- PDO Driver for MySQL: enabled.
- MySQL client API: `mysqlnd 8.5.12`.
- The PHP configuration screenshot shows the `pdo` and `nd_pdo_mysql` extensions selected.
- The PHP include path contains `/opt/alt/php85`, consistent with the confirmed PHP 8.5 runtime.

**PHP runtime compatibility evidence:** PHP 8.5.12 and PDO MySQL availability are confirmed by the supplied screenshots. This confirms extension availability, not a successful Laravel connection to the newly created database.

## 3. Important safety and configuration notes

- Do not enable external database connections for this work. The application must use only a verified supported hosting-side connection path.
- Do not change database access, reset passwords, import data, run migrations, or connect an application as part of this evidence capture.
- The dedicated V2 database is currently empty/new at the time of capture (1 MB shown); this is not a verified schema or application connection.
- The database username is shown with full access to this dedicated database. No cross-database grant inspection was performed.
- The V2 Laravel MySQL configuration is already implemented in the repository, while SQLite remains the local/CI default. A hosted connection has not been tested.
- The final V2 subfolder, document-root mapping, storage separation, full-path hosting-level access protection, filesystem permissions, backups, and V2-only restore boundary remain unverified.
- Do not place database credentials in `.env.example`, source code, documentation, commits, screenshots, or chat. Use protected environment configuration only when separately authorized.
- This evidence does not authorize Hostinger changes, V1/production access, DNS changes, deployment, public ingress, real data, or spend.

## 4. Remaining read-only evidence needed

1. Capture the selected PHP version and the top of PHP Info to confirm the exact PHP version.
2. Capture the hosting plan name and relevant resource/database limits.
3. Inspect the website document root and safe V2 subfolder placement options.
4. Inspect password-protection/IP-restriction capability covering the complete V2 path, including static assets.
5. Inspect file ownership/permissions and whether Laravel private storage, logs, sessions, cache and backups can remain outside the web root.
6. Inspect backup scope and whether a V2-only restore boundary is available.

No changes are to be made in hPanel while collecting these facts.

## 5. Status

- Dedicated V2 database created: **OBSERVED**.
- Host and port recorded: **OBSERVED**.
- PDO MySQL enabled: **OBSERVED**.
- Exact PHP version: **NOT FULLY CONFIRMED**.
- Hosted Laravel-to-MySQL connection: **NOT TESTED**.
- Full hosting/runtime isolation: **NOT VERIFIED**.
- Provisioning/deployment/migration: **NOT PERFORMED OR AUTHORIZED**.
- M3-11-05 hosted acceptance: **BLOCKED / NOT ACCEPTED**.


## 4. V2 subfolder location — owner-selected, observed

The owner-provided Hostinger File Manager screenshot for `public_html` shows the following directory entries at the time of capture (2026-11-18):

- `cv-builder`
- `cv-builder-v2`
- `institutes`
- `institutes-v2`
- `wp-admin`
- `wp-content`
- `wp-includes`
- hidden entries `.private` and `.tmb`

The screenshot shows `institutes-v2` directly inside `public_html`, with its last-modified display reading "a few seconds ago". The owner explicitly selected this existing folder as the intended Listing V2 location.

**Owner-selected intended directory:** `/public_html/institutes-v2`  
**Intended public path:** `/institutes-v2` (subject to confirming the actual web-server mapping and rewrite behavior).  
**Observed directory permissions display:** `drwxr-xr-x` for the listed directories in this view.  
**Folder contents — subsequently inspected from the owner-provided File Manager screenshot (2026-11-18):**

| Entry | Size shown | Last modified shown | Permission display |
|---|---:|---|---|
| `.htaccess` | 289 B | an hour ago | `-rw-r--r--` |
| `.htpasswd` | 116 B | an hour ago | `-rw-r--r--` |

These are the only two entries visible in the folder listing. The screenshot does not establish whether hidden entries are omitted by the File Manager view, nor does it expose either file's contents. Their presence is consistent with a password-protection configuration, but **does not prove** that protection is correctly configured, enabled, or covers every request including static assets. Do not read, disclose, copy, or change the `.htpasswd` contents. The `.htaccess` rules must be inspected in a controlled, read-only way before making any claim about routing or protection coverage. No content was changed.  
**Document-root / Laravel public-directory mapping:** NOT VERIFIED.  
**Protection coverage for static assets and the entire subfolder:** NOT VERIFIED.

No files or folders were created, moved, renamed, deleted, or edited during this inspection. Existing WordPress, Institutes V1, and CV Builder folders are out of scope and must remain untouched. The owner-selected folder is a location decision only; it is not authorization to upload code, change permissions, configure rewrites, or deploy.


## 6. Selected V2 folder contents — observed

The owner-provided File Manager screenshot opened `/public_html/institutes-v2`. At capture time (2026-11-18), the listing showed exactly two visible entries:

- `.htaccess` — 289 B, last modified "an hour ago", permission display `-rw-r--r--`.
- `.htpasswd` — 116 B, last modified "an hour ago", permission display `-rw-r--r--`.

No application directories or Laravel files are visible in this listing. This means the folder is **not empty**; it currently contains two access/configuration files. The screenshot does not prove there are no hidden or omitted entries.

The presence of `.htaccess` and `.htpasswd` suggests a password-protection setup may have been created. Their contents were not inspected, so no claim is made that authentication is enabled, correct, or covers the full V2 path and static assets. Do not overwrite or delete these files. Before any deployment plan, obtain a safe read-only review of the `.htaccess` directives without exposing `.htpasswd` hashes or credentials.

**Observed conclusion:** `/public_html/institutes-v2` is the selected V2 folder and currently shows only these two visible files. Laravel document-root mapping, rewrite behavior, actual password-protection coverage, and hidden-entry completeness remain unverified. No Hostinger files were changed.
