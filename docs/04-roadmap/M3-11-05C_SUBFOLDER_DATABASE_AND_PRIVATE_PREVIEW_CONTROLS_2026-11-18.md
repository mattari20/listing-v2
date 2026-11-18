# M3-11-05C — Subfolder Database and Private Preview Controls

**Date:** 2026-11-18  
**Package:** M3-11-05 runtime/environment separation  
**Status:** IMPLEMENTED IN BRANCH; CI VALIDATION PENDING

## 1. Scope

Implement repository-side preparation for the Product Owner's preferred V2 subfolder architecture:

- Preserve SQLite as the default for local development and CI.
- Add a configurable MySQL connection for a separately provisioned V2 database.
- Give the V2 session cookie a unique name and configurable subfolder path.
- Add an opt-in, global HTTP Basic access gate for all requests that enter Laravel.
- Add synthetic-only feature tests.

No Hostinger/hPanel access, V1/production access, provisioning, database creation, DNS, deployment, real data, external services or spend occurred.

## 2. Implementation

### 2.1 Database configuration

- `config/database.php` retains the existing SQLite connection and adds Laravel's MySQL connection using environment-driven host, port, database, username, password, socket, charset and collation.
- `.env.example` keeps SQLite as the local/CI default and documents the environment variables required to switch the hosted V2 instance to MySQL.
- No database credentials are committed.
- CI remains on disposable in-memory SQLite. No hosted database or external database service is used by tests.

**Important:** The MySQL configuration is not proof that Hostinger's database engine/version, grants, credentials or PHP PDO MySQL extension are compatible. Those still require evidence and a later disposable compatibility check before provisioning.

### 2.2 Subfolder session configuration

- The V2 session cookie default is now uniquely named `estudent-institutes-v2-session`.
- `SESSION_PATH` remains configurable and defaults to `/` for local root-path development.
- A hosted subfolder must set `SESSION_PATH` to the exact URL path, for example `/v2`, once that path is selected.
- Hosted sessions must use HTTPS-only cookies; the local example keeps this disabled to support local HTTP development.

This is cookie-path preparation only. Final redirect, asset, CSRF and route URL behavior must still be exercised using the selected hosted subfolder path.

### 2.3 Private preview gate

- Added `PrivatePreviewAccess` as global Laravel middleware alongside security headers.
- The gate is disabled by default.
- When enabled, every request handled by Laravel requires HTTP Basic credentials.
- If enabled but username/password are missing, the middleware returns 503 (fail closed).
- Missing or incorrect credentials return 401 with a Basic authentication challenge and no-store headers.
- Credentials are read from environment configuration and are not stored in source control.

Enable only on the intended private V2 preview after setting a unique username/password outside Git. Serve over HTTPS. Do not reuse V1 or personal account credentials.

**Boundary:** Global Laravel middleware cannot protect static files that the web server serves directly without invoking Laravel. Before any hosted preview, configure and verify the hosting/web-server access restriction for the entire V2 URL path, including static assets, and ensure only Laravel's `public/` directory is web-accessible. The unlinked URL remains discovery reduction, not access control.

### 2.4 Storage

No storage relocation or symlink creation is performed in this package. Keep `storage/`, `.env`, `vendor/`, logs, sessions, cache and backups outside the web document root where possible. Do not expose Laravel's private storage through a public symlink. Physical Hostinger paths and permissions remain unverified.

## 3. Tests added

- `PrivatePreviewAccessTest`:
  - gate disabled by default;
  - anonymous access denied for health, directory and session routes when enabled;
  - configured Basic credentials accepted;
  - missing credentials fail closed with 503;
  - incorrect credentials rejected.
- `SubfolderDatabaseConfigurationTest`:
  - SQLite remains the local/CI default;
  - MySQL connection accepts isolated synthetic configuration values;
  - V2 session cookie name and subfolder path are configurable.

These tests use only synthetic values and do not connect to MySQL or any hosted system.

## 4. Required hosted environment settings (illustrative only)

Do not copy these placeholders as real credentials. Use the actual owner-selected subfolder path and values generated/configured in the hosting account.

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://example.invalid/v2

DB_CONNECTION=mysql
DB_HOST=<V2 database host>
DB_PORT=3306
DB_DATABASE=<dedicated V2 database>
DB_USERNAME=<dedicated V2 database user>
DB_PASSWORD=<unique secret>

SESSION_COOKIE=estudent-institutes-v2-session
SESSION_PATH=/v2
SESSION_SECURE_COOKIE=true

PRIVATE_PREVIEW_ENABLED=true
PRIVATE_PREVIEW_USERNAME=<unique preview username>
PRIVATE_PREVIEW_PASSWORD=<unique preview password>
```

The example domain and credentials are placeholders, not selected deployment values. Store secrets only in the hosting environment's protected configuration, never in Git or chat.

## 5. Remaining acceptance work

1. Run and pass FND-01 PHP 8.5 CI on the exact PR head, including the complete synthetic SQLite suite.
2. Review exact PR diff and reconcile documentation catalogue/master status after merge.
3. Confirm Hostinger PHP version and PDO MySQL availability, database engine/version and dedicated-user grants using redacted evidence.
4. Confirm the V2 application document root points only to Laravel's `public/` directory and no V1 files/configuration are changed.
5. Confirm private storage, sessions, cache, logs and backups are outside public paths or have tested deny rules.
6. Confirm hosting-level access control protects both dynamic Laravel routes and static assets.
7. Test redirects, assets, CSRF, sessions and direct unauthenticated requests at the final subfolder path using synthetic fixtures only.
8. Keep all hosted provisioning/deployment separately gated by exact-scope authorization.

## 6. Disposition

- MySQL connection configuration: IMPLEMENTED; no live connection tested.
- SQLite local/CI path: RETAINED.
- V2 session cookie naming/path: IMPLEMENTED; final hosted path not selected.
- Laravel private-preview gate: IMPLEMENTED, opt-in, fail-closed for missing credentials.
- Static-file and web-server access restriction: HOSTING ACTION STILL REQUIRED AND UNVERIFIED.
- Hostinger compatibility: NOT VERIFIED.
- Provisioning/deployment: NOT PERFORMED OR AUTHORIZED.

**M3-11-05C status:** IMPLEMENTATION SUBMITTED FOR CI; HOSTED ACCEPTANCE REMAINS BLOCKED.
