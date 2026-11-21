# Hostinger V2 subfolder deployment package (preparation only)

## Intended target

`public_html/institutes-v2/`

This package is designed for the owner-approved shared-hosting compromise. The Laravel application root is placed in `institutes-v2/_app/`; only the contents of Laravel's `public/` directory are published at the V2 URL.

This is **not** private filesystem isolation. The `_app/.htaccess` rule must be proven on the actual Hostinger LiteSpeed/Apache stack before application source, dependencies, or secrets are placed there.

## Package mapping

| Package path | Host path |
|---|---|
| `public/*` | `public_html/institutes-v2/*` |
| `_app/.htaccess` | `public_html/institutes-v2/_app/.htaccess` |
| Laravel non-public application files | `public_html/institutes-v2/_app/` |

The package does not contain Laravel source, Composer dependencies, or a real `.env` file. Those must not be copied until the HTTP denial and PHP include tests pass.

## Required host-side sequence

1. Confirm the V2 target is empty and Git auto-deployment remains OFF.
2. Create only the empty `_app` directory and install its deny rule.
3. Create a harmless synthetic marker file under `_app`.
4. Request the marker over HTTP and confirm access is denied (403 or another explicitly denied status).
5. Confirm a V2-root PHP test entry can read the marker through the filesystem while the HTTP request remains denied.
6. Probe `/_app/`, `/_app/.env`, `/_app/composer.json`, `/_app/vendor/autoload.php`, `/_app/app/`, and encoded/path-variant requests.
7. If any private-path request is served, stop. Do not copy Laravel source or secrets.
8. Remove only the synthetic test files after evidence is recorded.
9. Only after acceptance may a separate deployment authorization be considered.

Do not edit the WordPress root `.htaccess`. Do not touch the preserved backup, database, V1, DNS, or hosting configuration.

## Runtime front controller

`public/index.php` resolves the application root as `__DIR__.'/_app'`, then loads maintenance mode, Composer autoloading, and Laravel bootstrap from that path. This path mapping still requires a non-production boot test on Hostinger.

## Current status

Templates only. No Hostinger files have been created or changed. No Laravel source or secrets are included. No deployment or public activation is authorized.
