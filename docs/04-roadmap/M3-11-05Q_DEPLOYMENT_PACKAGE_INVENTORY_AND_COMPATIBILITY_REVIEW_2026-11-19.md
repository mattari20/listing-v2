# M3-11-05Q — Deployment package inventory and compatibility review (2026-11-19)

## Scope

This record reviews the V2 Hostinger deployment templates on branch `fix/hostinger-v2-subfolder-webroot` after the successful GitHub CI runs for commit `6359df05e737c5faebda7c15a437376f98ed627c`.

This is a repository-side review only. It does not certify Hostinger web-server behaviour or a successful hosted Laravel boot.

## CI evidence

For commit `6359df05e737c5faebda7c15a437376f98ed627c`:

- FND-01 foundation CI run #590 completed successfully.
- PHP 8.5 foundation job passed toolchain checks, disposable SQLite driver check, Composer manifest validation, locked dependency installation, dependency advisory check, PHP formatting, Laravel bootstrap/routes validation, synthetic-only tests, and repository artifact hygiene.
- Project documentation validation run #1034 completed successfully.
- Both workflow runs completed with conclusion `success`.

These runs validate the repository's existing application foundation. They do not prove the Hostinger deployment templates have been exercised on Hostinger.

## Hostinger PHP / Composer compatibility

Owner-provided SSH evidence from the account:
- PHP CLI: 8.5.12.
- Composer: 2.9.8.
- `composer.json` declares PHP `^8.3`.
- `composer.lock` platform requirement declares PHP `^8.3`.

PHP 8.5.12 satisfies the declared PHP version constraint. This is a version-constraint comparison, not a complete extension/platform compatibility result.

The successful CI dependency installation under PHP 8.5 is useful evidence for the locked dependency set in CI. Hostinger extension availability is not yet fully evidenced in this record. Before installing dependencies or booting Laravel on Hostinger, run `composer2 check-platform-reqs --lock` in a controlled application copy that contains the exact `composer.lock`, and inspect the Hostinger PHP 8.5 extension list. Do not run Composer in the old backup or against a live application.

## Package inventory

The dedicated deployment template directory currently contains:

| Path | Intended role | Classification |
|---|---|---|
| `deployment/hostinger-v2/public/index.php` | Host-specific Laravel front controller | Public runtime entry point |
| `deployment/hostinger-v2/public/.htaccess` | V2 subfolder rewrite and public-path denial | Public web-server configuration |
| `deployment/hostinger-v2/_app/.htaccess` | Deny direct HTTP access to private app directory | Private-directory access control |
| `deployment/hostinger-v2/README.md` | Mapping and staged test procedure | Deployment documentation |

The deployment template directory intentionally does not contain:
- Laravel `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, or `storage/` source trees;
- Composer `vendor/`, `composer.json`, or `composer.lock`;
- `.env`, secrets, credentials, real data, or database dumps;
- `.git/`, `.github/`, tests, docs, scripts, or development tooling.

The repository's existing `public/` tree has not yet been converted into a fully enumerated deployment manifest in this record. Before packaging, enumerate every file and directory under the source `public/` directory, classify each as required public asset or excluded file, and copy only approved public assets alongside the deployment-specific `index.php` and `.htaccess`. Do not blindly copy the repository's original `public/index.php` or overwrite the deployment-specific front controller.

## Configuration and runtime path review

The custom front controller resolves:
`$appRoot = __DIR__.'/_app'`

It then loads:
- `_app/storage/framework/maintenance.php`;
- `_app/vendor/autoload.php`;
- `_app/bootstrap/app.php`.

The repository's current `bootstrap/app.php` calls `Application::configure(basePath: dirname(__DIR__))`. With the file located at `_app/bootstrap/app.php`, `dirname(__DIR__)` resolves to `_app`, which is the intended application base path.

This is a static path review only. It does not prove Laravel can boot on the Hostinger account.

## Access-control review — unresolved runtime gate

The proposed `_app/.htaccess` contains both Apache 2.4 `Require all denied` and legacy access-compat deny directives. The V2 root `.htaccess` separately denies `_app` URL paths and hidden files.

Do not assume these directives are enforced by the actual LiteSpeed/Apache configuration. Before placing source or secrets under `_app/`, test harmless synthetic files and confirm:
1. Direct HTTP requests to marker files and directory paths are denied.
2. Encoded and path-variant probes are denied.
3. A V2-root PHP test can read a harmless marker by filesystem path.
4. The marker remains inaccessible through HTTP.
5. No directory listing is available.

Any unexpected successful HTTP response is a stop condition.

## Known unresolved requirements

- Complete source `public/` file inventory and public-asset manifest.
- Hostinger PHP extension inventory and `composer2 check-platform-reqs --lock` result for the exact locked application package.
- Actual LiteSpeed/Apache enforcement of the deny rules.
- PHP filesystem include test from V2 root into `_app/`.
- Hosted Laravel boot and route test.
- Preview authentication and V1 isolation verification.
- M3-11 recovery, legal/privacy, security, and release acceptance gates.

## Current decision

Repository CI is green and the deployment templates are present. The package is not yet release-ready and must not be copied to Hostinger as an application deployment.

No Hostinger files were changed. The new V2 target remains owner-confirmed empty at the last SSH inspection. Auto-deployment remains OFF. The preserved backup and WordPress remain outside this work and untouched. No database, DNS, migration, secret, or public activation action occurred.
