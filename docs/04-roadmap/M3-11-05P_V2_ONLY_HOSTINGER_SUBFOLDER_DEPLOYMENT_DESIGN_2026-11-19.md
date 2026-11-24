# M3-11-05P — V2-only Hostinger subfolder deployment design (2026-11-19)

## Decision and scope

The Product Owner selected the current Hostinger Premium Web Hosting plan and approved proceeding with V2 under the existing domain document root at:

`/home/u537436044/domains/estudent.pk/public_html/institutes-v2`

This is a shared-hosting compromise. It is not equivalent to private filesystem isolation because the Laravel application tree remains physically beneath the document root. The design therefore depends on tested web-server access denial for the private application directory.

This record supersedes the earlier assumption that deployment must wait for Hostinger to approve a private directory outside `public_html`. It does not supersede any release, security, legal, recovery, or activation gate.

## Explicit boundaries

- Work only in the new V2 target `public_html/institutes-v2`.
- Do not inspect, modify, secure, copy from, or deploy to the preserved `institutes-v2.000000` backup as part of this work.
- Do not change WordPress files, root `.htaccess`, V1, DNS, database, or hosting configuration.
- Keep Hostinger Git auto-deployment OFF.
- Do not run migrations, seeders, production Artisan commands, or database operations.
- Do not place secrets, real personal data, or production data in GitHub or this design record.
- No deployment, public activation, or copying to Hostinger is authorized by this design record.

## Verified account facts

Owner-provided SSH evidence confirms:
- Account home: `/home/u537436044`.
- Domain document root: `/home/u537436044/domains/estudent.pk/public_html`.
- New V2 target: `/home/u537436044/domains/estudent.pk/public_html/institutes-v2`.
- New V2 target was empty at the latest inspection.
- Shell `ln -s` worked in a temporary home-directory test, but PHP symlink support and web-server symlink following are not established.
- PHP CLI 8.5.12 and Composer 2.9.8 are available.
- Hostinger disables several PHP process functions; do not assume Composer scripts or shell execution from PHP.
- Root WordPress rewrite excludes existing physical directories via `!-d`; root `.htaccess` is to remain unchanged.

## Proposed V2-only filesystem layout

```text
public_html/
└── institutes-v2/
    ├── .htaccess                 # V2-only routing and deny rules
    ├── index.php                 # deployment-specific Laravel front controller
    ├── favicon.ico               # only if present in Laravel public/
    ├── robots.txt                # only if intentionally published
    ├── build/                    # public build output, if present
    ├── assets/                   # public assets, if present
    ├── css/                      # public assets, if present
    ├── js/                       # public assets, if present
    └── _app/
        ├── .htaccess             # deny all direct HTTP access
        ├── app/
        ├── bootstrap/
        ├── config/
        ├── database/
        ├── resources/
        ├── routes/
        ├── storage/
        ├── vendor/
        ├── .env                  # created only on host; never committed
        ├── artisan
        └── other non-public Laravel files
```

Only the contents of the repository's Laravel `public/` directory are candidates for publication into the V2 directory root. The Laravel application root is `_app/`. Do not publish `.git`, `.github`, tests, docs, scripts, Composer metadata, or other repository-root files.

## Front controller requirements

The V2-root `index.php` must:
- define `LARAVEL_START`;
- check maintenance mode at `__DIR__.'/_app/storage/framework/maintenance.php'`;
- require `__DIR__.'/_app/vendor/autoload.php'`;
- require `__DIR__.'/_app/bootstrap/app.php'`;
- handle the captured HTTP request through Laravel.

The repository's current `bootstrap/app.php` uses `dirname(__DIR__)` as its base path. When located at `_app/bootstrap/app.php`, that resolves to `_app`, which is the intended Laravel base path. This must be verified by a non-production boot test.

## Access-control requirements

Before placing source or secrets in `_app/`:
1. Add a directory-level `.htaccess` under `_app/` using a deny-all rule supported by the Hostinger LiteSpeed/Apache configuration.
2. Verify direct HTTP requests to representative files and directories under `_app/` are denied, including:
   - `_app/.env`
   - `_app/composer.json`
   - `_app/vendor/autoload.php`
   - `_app/app/`
   - `_app/storage/`
   - `_app/bootstrap/app.php`
3. Verify the V2 front controller can still include and execute files from `_app/`.
4. Verify no rewrite or static-file rule exposes `_app/`.
5. Verify a request for `/_app/` and encoded/path-variant probes are also denied.
6. If any private-path probe returns a successful response or the deny rule is ignored, stop. Do not put secrets or application source in that location; revisit the architecture with Hostinger.

A `.htaccess` deny rule is an HTTP access control only. It does not make `_app/` private to other local processes or equivalent to storage outside the document root.

## Routing and public assets

- Requests for real public asset files should resolve from the V2 directory root.
- Other requests should reach the V2-root `index.php`.
- Browser requests must not be able to access an internal `public/` path or `_app/` path.
- Keep V2 routing rules inside `institutes-v2/.htaccess`; do not edit the WordPress root `.htaccess`.
- Preserve Authorization and X-XSRF-Token headers where required by Laravel.
- Do not create a storage symlink. PHP symlink support is not confirmed and shell symlink success in `$HOME` does not establish the required behaviour. Public upload/storage publishing remains out of scope until a safe supported method is separately verified.

## Validation gates before any host copy

### Static/package validation
- Confirm exact source branch and commit.
- Review the public file inventory and ensure no secrets or private files are in the public package.
- Validate custom front controller paths.
- Validate root and `_app` deny rules syntactically.
- Run repository CI and targeted tests for deployment path assumptions.
- Verify PHP extensions and Composer platform requirements against Hostinger PHP 8.5.12 without installing packages on the live host.

### Isolated Hostinger validation
- Confirm target is still empty before the first controlled test.
- First test only harmless synthetic marker files and access-control files; do not copy application source or secrets yet.
- Verify deny rules using HTTP status checks for representative private paths.
- Verify public static-file serving and front-controller routing.
- Verify PHP can include a harmless file beneath `_app/` while HTTP clients cannot retrieve it.
- Verify V1/WordPress homepage and representative URLs remain unchanged.
- Keep auto-deployment OFF and perform no database operations.

### Activation gates
No public activation until security probes, Laravel boot, private-preview authentication, static assets, V1 isolation, recovery evidence, and the existing M3-11 release gates are independently accepted. A successful homepage response alone is not acceptance.

## Current status

- Owner-approved direction: use the current Hostinger Premium plan and the new V2 subfolder, accepting the shared-hosting compromise.
- New V2 target: confirmed empty at latest owner-provided inspection.
- Architecture: proposed, not yet implemented or tested.
- Old backup: intentionally out of scope and untouched.
- WordPress root: untouched.
- Auto-deployment: remains OFF.
- No Hostinger files changed; no deployment, secret creation, migration, database operation, DNS change, V1 change, or public activation performed.
