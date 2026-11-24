# Hostinger V2 root 403 and Laravel public entry-point evidence — 2026-11-19

## Owner-supplied browser evidence

The owner supplied an Incognito browser screenshot for:

`https://estudent.pk/institutes-v2/`

The visible response is Hostinger/Apache-style `403 Forbidden` with the message "Access to this resource on the server is denied!". No HTTP Basic Authentication browser prompt is visible in that screenshot.

The owner also supplied a Hostinger File Manager screenshot for:

`public_html/institutes-v2/public/`

The visible contents include:

- `.htaccess`
- `index.php`
- `robots.txt`

The earlier owner-supplied repository-root listing for `public_html/institutes-v2/` showed Laravel project directories and root files, but no root-level `index.php` or root-level `.htaccess` was visible in the listing. The project entry point is therefore visibly located under `public/`, not at the deployed repository root.

## Assessment

The most likely routing explanation for the root URL's 403 is that the URL maps to the repository root, where no root index file is present, while directory listing is disabled. Laravel's actual front controller is under `public/index.php`.

This is a strong evidence-based diagnosis, not a definitive server-side root-cause confirmation. A 403 can also be produced by host access rules, filesystem permissions, password-protection configuration or other Apache rules. The screenshot alone does not identify which rule emitted the response.

The absence of a Basic Authentication prompt in the screenshot means the owner has not yet demonstrated a successful HTTP Basic challenge. The hPanel protected-directory listing is configuration evidence only; runtime enforcement remains unverified.

## Intended correction

Keep Laravel's normal application structure unchanged. The preferred deployment configuration is for the web server document root to point directly to:

`public_html/institutes-v2/public`

If Hostinger Git deployment requires the repository root to remain the deployment directory, a carefully tested repository-root front-controller/rewrite arrangement can route requests to the existing `public/index.php` and map public assets. Do not move Laravel's `index.php` out of `public/` or duplicate the full framework bootstrap without a specific tested reason.

The candidate root `.htaccess` in this PR is a proposed compatibility arrangement only. Its filesystem path assumptions and effective behavior must be verified on the actual Hostinger account before deployment.

## Current state and required verification

- Hostinger auto-deployment was shown disabled by the owner.
- No new PR commit has been deployed to Hostinger.
- PR #313 remains draft and unmerged.
- No Hostinger files were changed by the assistant.
- The root 403 is observed; the exact emitting rule remains undetermined.
- The root-level routing candidate needs CI and review against actual Hostinger path semantics.
- A controlled verification must establish:
  1. unauthenticated request behavior (expect a genuine authentication challenge if directory password protection is active);
  2. authenticated V2 root response;
  3. public asset delivery under `/institutes-v2/`;
  4. denial of private file paths without exposing response contents;
  5. no effect on the main eStudent.pk site.

Keep auto-deployment disabled and do not merge until these checks are complete.
