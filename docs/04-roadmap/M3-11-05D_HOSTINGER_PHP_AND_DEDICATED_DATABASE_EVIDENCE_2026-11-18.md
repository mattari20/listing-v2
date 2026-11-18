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

The supplied hPanel PHP Info screenshot shows:

- PDO support: enabled.
- PDO drivers: `mysql, sqlite`.
- PDO Driver for MySQL: enabled.
- MySQL client API: `mysqlnd 8.5.12`.
- The PHP configuration screenshot shows the `pdo` and `nd_pdo_mysql` extensions selected.
- The PHP include path contains `/opt/alt/php85`, which is consistent with the PHP 8.5 runtime path.

The screenshot set does not include the PHP Info page's top-level PHP Version row or the PHP version selector itself. Therefore, record the PHP 8.5 identification as **strongly indicated, not fully confirmed** until a screenshot of the selected version/top of PHP Info is captured.

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
