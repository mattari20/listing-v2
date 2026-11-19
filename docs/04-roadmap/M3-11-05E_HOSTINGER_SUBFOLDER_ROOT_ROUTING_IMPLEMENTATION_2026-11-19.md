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
- map public assets into the existing `public/` tree;
- route other application requests to `public/index.php`;
- deny direct requests for environment, Composer, PHPUnit and Artisan files.

The public Laravel rewrite file remains unchanged.

## Important deployment assumptions and limitations

1. The asset mapping currently names the Hostinger subfolder
   `institutes-v2` in its filesystem check. Reconfirm this exact deployment
   path before using the file in another directory.
2. This configuration requires Apache `mod_rewrite`, `mod_authz_core`,
   and permission for `.htaccess` overrides. Hostinger's effective Apache
   configuration has not been inspected.
3. A repository-root rewrite file is not a substitute for an independent
   Hostinger directory password-protection rule. The screenshots supplied so
   far do not show an active root-level authentication rule or its coverage.
4. Do not assume that hiding application directories is equivalent to moving
   the document root to Laravel's `public/`. A dedicated web root pointing
   directly to `public/` remains the preferred layout where Hostinger permits
   it.
5. Do not deploy this branch yet. Auto-deployment was shown disabled on
   2026-11-19. No live server request, static-file denial test, authentication
   test, V1 isolation test, or browser verification has been performed.
6. Do not merge this branch to `main` until Apache path mapping, root
   authentication, private-file denial and recovery/rollback are verified.

## Validation still required

- Confirm Hostinger serves `public_html/institutes-v2` using Apache with the
  required rewrite and authorization modules.
- Confirm the filesystem mapping resolves to
  `public_html/institutes-v2/public` for assets.
- Confirm requests to `/.env`, `/.git/config`, `/vendor/`, `/storage/`,
  `/config/`, `/composer.json`, and `/artisan` are denied and do not return
  file contents.
- Confirm the private preview gate challenges unauthenticated requests,
  including static assets, at the hosting/web-server layer.
- Confirm normal routes and built assets work under `/institutes-v2`.
- Confirm the main eStudent.pk site is unchanged.
- Record exact tested URL, status, response evidence, date and tested commit.

No credentials, secrets, real user data, migrations, production database
changes, V1 changes, DNS changes or additional hosting spend are authorized by
this implementation branch.
