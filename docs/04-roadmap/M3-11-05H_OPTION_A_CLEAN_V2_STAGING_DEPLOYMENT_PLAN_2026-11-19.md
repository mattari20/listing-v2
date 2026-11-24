# M3-11-05H — Option A clean V2 staging deployment plan (2026-11-19)

## Authorization

The Product Owner explicitly authorized Option A on 2026-11-19:

- prepare a clean V2 deployment in a separate temporary directory;
- preserve the existing deployment and data;
- verify before switching;
- do not delete or deploy until safeguards are confirmed.

This is preparation-only authorization. It does not authorize a Hostinger deployment, file deletion, repository connection change, auto-deployment re-enable, DNS change, database migration, or production/V1 action.

## Hostinger facts from current official documentation

Hostinger's current Git deployment guide says:
- the Git integration supports selecting a repository, branch and root directory;
- the root directory is the folder into which repository files are deployed;
- a valid custom directory may be selected, with `public_html/my-project` as an example;
- a later deployment overwrites files in the selected target directory;
- changing repository or deployment target can overwrite existing data in that target.

Official source: https://www.hostinger.com/support/1583302-how-to-deploy-a-git-repository-in-hostinger/

Hostinger's current root-directory guide says the website home/document root on Web and Cloud hosting cannot simply be changed through the panel. It describes subdirectory hosting as an alternative.
Official source: https://www.hostinger.com/support/1583494-what-is-the-path-to-your-website-s-root-home-directory-and-how-to-change-it-in-hostinger/

Hostinger's current symlink guidance says symlinks are disabled by default on Web and Cloud hosting and must be enabled through disabled-PHP-functions settings; availability depends on plan.
Official sources:
- https://www.hostinger.com/support/which-file-transfer-and-server-access-options-are-supported-at-hostinger/
- https://www.hostinger.com/support/1583694-how-to-create-a-symlink-at-hostinger/

## Recommended target architecture

Preferred security architecture for staging:

1. Laravel application source, Composer vendor tree, configuration, storage, tests, Git metadata and runtime secrets live in a directory outside the public web root.
2. The public V2 URL maps only to Laravel's `public/` output.
3. The public front controller references the private Laravel bootstrap using a verified absolute filesystem path.
4. Public assets are delivered from the V2 public directory without exposing the private source tree.
5. Hostinger's directory password protection remains an independent outer access control until private preview acceptance is complete.

Do not assume a symlink is available. Hostinger documentation says it is disabled by default on Web/Cloud plans. A symlink-based design must not be selected until the plan supports it and the setting is confirmed. Avoid enabling a PHP function or changing hosting security settings without explicit review.

## Candidate staging topology

Illustrative only; exact account home path must be obtained from Hostinger File Manager/FTP Accounts:

- private source target: `<account-home>/listing-v2-stage-source`
- public staging target: `public_html/institutes-v2-stage`

Do not create either directory or deploy until the exact home path, empty-target status, Git integration behavior and public/private separation are verified.

A single Hostinger Git deployment of the full repository into a public directory is not an acceptable secure staging architecture. It reproduces the current exposure of application source directories under `public_html`.

## Required design decision before staging

Hostinger's standard Git integration deploys the repository into one selected root directory. It does not document a built-in selective `public/`-only deployment for a Laravel repository. Therefore determine one supported mechanism for publishing only public files while keeping the full application outside the document root:

A. Separate private-source and public-output deployment targets, if the account supports two independent Git deployment targets or an equivalent supported deployment flow; or
B. Private source deployment plus a separately controlled public-output sync process, only if available SSH/rsync/symlink capabilities and permissions are verified.

Do not use a public root containing the full Laravel repository and rely solely on .htaccess as the final security boundary.

## Required owner evidence before staging

1. Hostinger File Manager Home/root listing showing directories immediately above `public_html`, with account identifiers obscured.
2. Hostinger FTP Accounts page showing the website root path, with username/host identifiers obscured.
3. Hosting plan name/tier and confirmation whether the current account permits a private deployment directory outside `public_html`.
4. Whether symlink functionality is enabled/available (do not change it yet).
5. Whether a second Git deployment target can be configured without disconnecting or modifying the existing Git deployment. Do not press Deploy or Change repository.

## Preservation and rollback controls

- Keep existing `public_html/institutes-v2` untouched.
- Preserve existing `.env`, storage data, uploads, logs, session files, and Hostinger password-protection files.
- Do not copy secrets into GitHub, chat, screenshots, or staging repository files.
- Do not point staging at the current directory.
- Do not run migrations, seeders, cache-clearing commands or Artisan commands against the current hosted app.
- Do not enable auto-deployment.
- Record a pre-change inventory and a verified rollback path before any eventual switch.
- Test staging independently with synthetic data only.
- Confirm unauthenticated challenge, authenticated application response, static assets, denial of private-file probes and V1 isolation before switch.

## Current status

- Option A preparation authorized.
- Hostinger auto-deployment shown disabled by owner.
- Existing V2 deployment and data not changed by this work.
- No staging directory created.
- No deployment triggered.
- No deletion, database operation, DNS change or V1 change.
- Architecture is not yet deployable because the account's exact home path and supported private/public deployment mechanism are unknown.
