# M3-11-05R — Hostinger Web Runtime and V2 Subfolder Routing Evidence

Date: 2026-11-19  
Repository: `mattari20/listing-v2`  
Target: `https://estudent.pk/institutes-v2/`  
Hosting: Hostinger Premium Web Hosting, LiteSpeed  
Status: **PASS for the specific synthetic checks recorded below; NOT deployment approval**

## 1. Web PHP runtime verification

A temporary, non-sensitive PHP probe was created in the otherwise-empty V2 staging directory, requested once over HTTPS, and removed.

Observed response:
- HTTP status: `200`
- PHP version: `8.5.12`
- PHP SAPI: `litespeed`
- All checked extensions returned `true`: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `PDO`, `pdo_mysql`, `session`, `tokenizer`, `xml`, `zip`.
- Temporary probe cleanup was verified.

CLI environment previously observed:
- PHP CLI: `8.5.12`
- Composer: `2.9.8`

This verifies the listed extensions in the LiteSpeed web SAPI for this request. It does not establish every Composer platform requirement or prove Laravel application boot.

## 2. Synthetic V2 routing and HTTP-denial test

Temporary files and rules were created only inside the empty V2 staging directory:
- A synthetic public static marker.
- A synthetic internal marker under `_app/`.
- A synthetic hidden-file marker.
- A temporary `index.php` route marker.
- The proposed V2 public routing rules and proposed `_app` deny-all rules.

Observed results:

| Probe | HTTP result | Expected | Outcome |
|---|---:|---:|---|
| Public static marker | 200 | 200 | PASS |
| `_app` internal marker | 403 | 403 | PASS |
| Hidden-file marker | 403 | 403 | PASS |
| Non-existent route rewritten to temporary front controller | 200 | 200 | PASS |

The route response body was `V2_ROUTE_REWRITE_OK`; the public asset body was `V2_PUBLIC_STATIC_OK`.

All temporary files and directories were removed. The final shell cleanup assertion confirmed that `.htaccess`, `index.php`, `_app/`, and all marker files were absent and the V2 staging directory had returned to its original empty state.


## 3. Expanded synthetic HTTP-denial and path-variant test

A second temporary test set was run in the otherwise-empty V2 staging directory. It created only synthetic marker files under `_app/` and temporary V2-specific `.htaccess` rules. No real `.env`, Composer manifest, vendor package, Laravel source, credential, or application data was used.

Observed results:

| Probe | HTTP result | Outcome |
|---|---:|---|
| `/_app/` | 403 | PASS |
| `/_app/.env` | 403 | PASS |
| `/_app/composer.json` | 403 | PASS |
| `/_app/vendor/autoload.php` | 403 | PASS |
| `/_app/app/` | 403 | PASS |
| `/_app/app/__v2_probe_marker.txt` | 403 | PASS |
| `/%5Fapp/.env` | 403 | PASS |
| `/_app%2F.env` | 403 | PASS |
| `/%255Fapp/.env` | 403 | PASS |
| `/_app/../_app/.env` | 403 | PASS |

The response bodies were Hostinger denial-page HTML, not synthetic marker content. Cleanup was explicitly run and verified: the temporary root `.htaccess`, `index.php`, and `_app/` directory were absent afterwards.

These results demonstrate denial for these ten exact requests only. They do not prove every possible URL normalization, server configuration, or complete security.

## 4. CI on the recorded PR head

For commit `3eb23deb44c70d02c1b4ae69e6028fcc7cec3c50`, the GitHub Actions runs associated with the commit completed successfully:
- FND-01 foundation CI run #594: success.
- Project documentation validation run #1038: success.

These results apply to that exact commit; a later documentation commit requires its own fresh CI results.

## 5. Composer lock inventory (static inspection only)

The current branch's `composer.lock` was parsed without installing packages:
- 77 production packages.
- 33 development packages.
- Locked root platform requirement: PHP `^8.3`.
- `composer.json` also declares PHP `^8.3`.

Hostinger PHP CLI and LiteSpeed web SAPI were previously observed as PHP `8.5.12`, which is within the root PHP constraint. This is a static compatibility observation, not the result of `composer check-platform-reqs --lock`. The full locked extension/platform check remains outstanding; the earlier 15-extension web probe did not cover every platform requirement in the lock.

## 6. Updated deployment and release controls

All prior deployment exclusions remain in force:
- V2 staging target returned to empty after each synthetic test.
- Preserved backup was not modified.
- WordPress/V1 files and root `.htaccess` were not modified.
- Git auto-deployment remains OFF.
- No Composer install, Artisan command, migration, database change, DNS change, deployment, or public activation occurred.
- PR #313 remains draft and unmerged.


## 3. Scope and limitations

These results demonstrate that the tested LiteSpeed configuration enforced the tested URL denials and subfolder rewrite behaviour under synthetic conditions. They do not constitute a complete security assessment.

In particular:
- `_app/` is planned to remain physically under `public_html`; HTTP denial is not private filesystem isolation.
- A synthetic public PHP probe successfully included `_app/__v2_private_marker.php` and returned `V2_PRIVATE_INCLUDE_OK` (HTTP 200); direct HTTP access to that marker returned HTTP 403. Temporary files and `_app/` were removed and cleanup verified.
- The actual Laravel front controller and application have not been installed or booted on Hostinger.
- The exact locked Composer platform requirements have not yet been checked against the hosted runtime.
- The source `public/` directory was enumerated on the PR branch and contains exactly three top-level files: `.htaccess`, `index.php`, and `robots.txt`; no subdirectories were returned by the GitHub contents listing. Their intended handling is recorded in Section 4.
- Preview authentication, V1 isolation, and complete application-route behaviour remain unverified.
- No Laravel source, dependencies, `.env`, secrets, database configuration, or real data were placed on Hostinger.

## 4. Source public-directory inventory

The GitHub contents listing for `public/` on branch `fix/hostinger-v2-subfolder-webroot` returned exactly:

| Source path | Decision for V2 package | Reason |
|---|---|---|
| `public/.htaccess` | Do not copy verbatim; use the reviewed V2 subfolder-specific template | Source rules use root-relative front-controller assumptions and do not include the V2-specific `_app` denial rules |
| `public/index.php` | Do not copy verbatim; use `deployment/hostinger-v2/public/index.php` | Original assumes Laravel app is one directory above `public/`; deployment entry point must resolve `_app/` |
| `public/robots.txt` | Candidate to copy unchanged after final packaging review | Contains only `User-agent: *` and `Disallow:`; no other public files or subdirectories were listed |

The original source `public/index.php` and `.htaccess` were inspected. No files were copied to Hostinger. This inventory is based on the current PR branch listing and should be rechecked if the branch changes before packaging.

## 5. Deployment and release controls

- New V2 staging target remains empty after testing.
- Preserved backup was not modified.
- WordPress/V1 files and root `.htaccess` were not modified.
- Git auto-deployment remains OFF.
- No Composer install, Artisan command, migration, database change, DNS change, deployment, or public activation occurred.
- PR #313 remains draft and unmerged.

## 7. Next required gates

1. Complete the exact locked Composer platform check against the Hostinger runtime, including all required extensions and Composer runtime API.
2. Verify the deployment-specific front-controller path and actual Laravel boot without secrets or production data.
3. Verify preview authentication and V1 isolation.
4. Keep deployment and public activation blocked until all gates and separate M3-11 release requirements are accepted.
