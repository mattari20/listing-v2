# Hostinger V2 subfolder deployment — repository-root web entry

## Observed deployment layout

The Hostinger screenshots supplied on 2026-11-19 show the Git repository deployed
at `public_html/institutes-v2`. The deployed directory contains Laravel source
directories (`app`, `bootstrap`, `config`, `database`, `resources`,
`routes`, `storage`, `tests`, `vendor`) alongside Laravel's `public/`
directory. The supplied `public/.htaccess` contains Laravel's standard
front-controller rewrite rules. The screenshots do not establish the contents
of a repository-root `.htaccess`, nor do they prove that private-preview
authentication is active.

## Proposed repository change

The root `.htaccess` in this branch is intended to:

- disable directory listings and MultiViews;
- deny requests for dotfiles, Git metadata and private Laravel source folders;
- internally map public assets into the existing `public/` tree;
- deny browser-originated direct URLs under `/institutes-v2/public/`;
- route the subfolder root and other application requests to
  `public/index.php`;
- deny direct requests for environment, Composer, PHPUnit and Artisan files.

The public Laravel rewrite file remains unchanged.

## Local Apache fixture validation

A disposable local Apache 2.4 fixture was created outside the repository with
synthetic marker files only. It used a document root containing a directory
named `institutes-v2`, matching the screenshot's relative layout. Apache
configuration syntax returned `Syntax OK`.

Observed fixture responses after adding the direct-public-path denial:

| Request | Result | Meaning |
|---|---:|---|
| `/institutes-v2/build.css` | 200 | Public asset mapping works |
| `/institutes-v2/app/private.txt` | 403 | Private application folder denied |
| `/institutes-v2/config/private.txt` | 403 | Private config folder denied |
| `/institutes-v2/vendor/private.txt` | 403 | Vendor folder denied |
| `/institutes-v2/.git/config` | 403 | Git metadata denied |
| `/institutes-v2/.env` | 403 | Environment file denied |
| `/institutes-v2/public/build.css` | 403 | Direct public-path URL denied |
| `/institutes-v2/not-a-route` | 200 | Request reaches synthetic front-controller marker |

The root request returned 404 in this fixture because it did not include a PHP
runtime/handler. Therefore this fixture does not validate Laravel boot, PHP
execution, the real root response, session behavior, authentication, or
application routes. It is a rewrite/access-control fixture, not Hostinger
acceptance evidence.

## Important deployment assumptions and limitations

1. The asset filesystem mapping names the Hostinger subfolder
   `institutes-v2`. Reconfirm this exact path before using the file elsewhere.
2. This configuration requires Apache `mod_rewrite`, `mod_authz_core`,
   and permission for `.htaccess` overrides. Hostinger's effective Apache
   configuration has not been inspected.
3. A repository-root rewrite file is not a substitute for an independent
   Hostinger directory password-protection rule. The screenshots supplied so
   far do not show an active root-level authentication rule or its coverage.
4. Hiding application directories is not equivalent to moving the document
   root to Laravel's `public/`. A dedicated web root pointing directly to
   `public/` remains the preferred layout where Hostinger permits it.
5. Auto-deployment was shown disabled by the owner on 2026-11-19. No live
   server file was changed and no Hostinger deployment was triggered.
6. Do not merge this branch to `main` until Hostinger path mapping, root
   authentication, private-file denial and recovery/rollback are verified.

## Hosted validation still required

- Confirm Hostinger serves `public_html/institutes-v2` using Apache with the
  required rewrite and authorization modules.
- Confirm the filesystem mapping resolves to
  `public_html/institutes-v2/public` for assets.
- Confirm requests to `/.env`, `/.git/config`, `/vendor/`, `/storage/`,
  `/config/`, `/composer.json`, `/artisan`, and `/public/` are denied
  without returning file contents.
- Confirm the private preview gate challenges unauthenticated requests,
  including static assets, at the hosting/web-server layer.
- Confirm normal Laravel routes and built assets work under `/institutes-v2`.
- Confirm the main eStudent.pk site is unchanged.
- Record exact tested URL, status, response evidence, date and tested commit.

No credentials, secrets, real user data, migrations, production database
changes, V1 changes, DNS changes or additional hosting spend are authorized by
this implementation branch.
