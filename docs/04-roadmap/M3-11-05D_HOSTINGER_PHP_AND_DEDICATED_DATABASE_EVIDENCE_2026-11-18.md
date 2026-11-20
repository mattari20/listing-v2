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


## 7. `.htaccess` authentication directives — observed (2026-11-18)

The owner-provided screenshot of `/public_html/institutes-v2/.htaccess` shows Hostinger-generated password-protection marker comments and these Apache directives:

```apache
AuthType Basic
AuthName "Restricted Access"
AuthUserFile /home/u537436044/domains/estudent.pk/public_html/institutes-v2/.htpasswd
Require valid-user
```

The marker comments instruct that the generated marker lines and lines below/above them must not be removed. Preserve the Hostinger-generated block; do not manually edit or delete it during this evidence phase.

**What this establishes:** the folder's `.htaccess` is configured to request HTTP Basic Authentication and require a valid user, using the `.htpasswd` file at the displayed absolute path. This is direct evidence of an authentication rule in the directory configuration.

**What remains unverified:** whether the rule is active on the live web-server path; whether all requests under `/institutes-v2` including static assets are challenged; whether child `.htaccess` files override/inherit the rule; whether the `.htpasswd` file is denied from direct HTTP retrieval; and whether the configured authentication file has suitably restrictive filesystem access. The File Manager earlier displayed `.htpasswd` permissions as `-rw-r--r--`; do not infer HTTP readability from that display alone, but treat direct-file exposure and filesystem access as explicit verification items. The `.htpasswd` contents/hash were not opened or recorded.

No request was made to the hosted path, no credentials were used, and no Hostinger setting or file was changed. Before any preview upload, obtain a controlled owner-run check that unauthenticated requests to the V2 directory and a harmless static test file are challenged, and that direct access to `.htpasswd` is denied. Do not expose credentials or hashes in screenshots. This does not authorize deployment or hosted application testing.


## 8. PHP runtime and extension configuration — observed (2026-11-18)

Owner-provided Hostinger PHP Configuration screenshots show PHP **8.5 selected** (the separate PHP Info screenshot identifies the actual runtime as **PHP 8.5.12**). No version change was made during evidence collection.

### Built-in extensions shown enabled

`bz2`, `calendar`, `core`, `ctype`, `curl`, `date`, `exif`, `filter`, `ftp`, `gettext`, `hash`, `iconv`, `json`, `lexbor`, `libxml`, `openssl`, `pcntl`, `pcre`, `random`, `readline`, `reflection`, `session`, `shmop`, `simplexml`, `spl`, `standard`, `tokenizer`, `uri`, `sqlite3`, `xml`, `Zend OPcache`, `zlib`.

### Additional extensions visibly checked

`bcmath`, `dom`, `fileinfo`, `gd`, `gmp`, `igbinary`, `imagick`, `imap`, `intl`, `mbstring`, `mysqlnd`, `nd_mysqli`, `nd_pdo_mysql`, `pdo`, `pdo_sqlite`, `phar`, `posix`, `soap`, `sockets`, `sysvmsg`, `sysvsem`, `sysvshm`, `tidy`, `timezonedb`, `xmlreader`, `xmlrpc`, `xmlwriter`, `xsl`, `zip`.

The PHP Info screenshot separately confirms PDO is enabled with drivers `mysql, sqlite`, and PDO MySQL is enabled (client API shown as `mysqlnd 8.5.12`). This is strong configuration evidence for the Laravel MySQL PDO requirement and local SQLite test support. It does **not** establish a successful application connection to the newly created database, nor does it prove every Laravel/runtime requirement under the final subfolder deployment. Do not toggle extensions or change PHP version as part of evidence collection. Re-check after any Hostinger PHP configuration change or platform/runtime update.

### Verification record

- PHP version selector: PHP 8.5 selected — observed.
- PHP Info runtime: PHP 8.5.12 — observed.
- PDO driver list: `mysql, sqlite` — observed.
- PDO MySQL module: enabled — observed.
- PHP extension checkbox state: recorded from screenshots; no settings changed.
- Live Laravel boot / database connection / hosted subfolder smoke test: not performed; remains deferred and unauthorized in this evidence-only phase.


## Product Owner decisions recorded — 2026-11-18

- Existing Hostinger directory password protection is the chosen private-preview access-control layer for this stage. No additional IP Manager restriction is required by the Product Owner. This decision does not itself prove live HTTP enforcement, nested/static-file coverage, or .htpasswd denial; those remain untested.
- Existing weekly automated backups are accepted by the Product Owner as sufficient for the current development stage. No backup upgrade, extra service, or increased frequency is required or approved. Restore-boundary and recovery-time claims remain unverified; this is not a production RPO/RTO acceptance.
- The existing Hostinger plan is to be retained; no upgrade or additional hosting spend is approved.

These decisions remove any requirement to add a second access-control layer or purchase enhanced backup frequency for the current stage. They do not waive the need to keep unverified technical boundaries accurately documented. No hPanel changes, backup actions, restore, deployment, or live hosted tests were performed as part of recording these decisions.


## Superseding PHP runtime status — 2026-11-20

The earlier status line “Exact PHP version: NOT FULLY CONFIRMED” is superseded. The owner-provided PHP Info evidence in §2 explicitly identifies PHP `8.5.12`, and the later 2026-11-19 bounded resource/CLI closeout independently observed Hostinger CLI PHP `8.5.12`. PDO MySQL availability is also observed. This confirms the runtime version and extension availability only; it does not prove hosted Laravel HTTP boot, database connection, full V2/V1 isolation, Basic Auth/static-file enforcement, private storage separation or M3-11-05 acceptance. No additional hosting access is authorized by this correction.