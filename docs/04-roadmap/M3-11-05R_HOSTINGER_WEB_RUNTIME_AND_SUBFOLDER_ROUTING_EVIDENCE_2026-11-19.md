# M3-11-05R — Hostinger Web Runtime and V2 Subfolder Routing Evidence

Date: 2026-11-19  
Repository: `mattari20/listing-v2`  
Target: `https://estudent.pk/institutes-v2/`  
Hosting: Hostinger Premium Web Hosting, LiteSpeed  
Status: **PASS for the specific synthetic/runtime checks recorded below; NOT deployment approval**

## 1. Web and CLI runtime

A temporary, non-sensitive PHP probe was created in the otherwise-empty V2 staging directory, requested once over HTTPS, and removed.

Observed web response:
- HTTP status: `200`
- PHP version: `8.5.12`
- PHP SAPI: `litespeed`
- All checked extensions returned `true`: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `PDO`, `pdo_mysql`, `session`, `tokenizer`, `xml`, `zip`.
- Temporary probe cleanup was verified.

Hostinger CLI observations:
- PHP CLI: `8.5.12`
- Composer: `2.9.8`
- Composer Runtime API: `2.2.2`
- A separate CLI probe reported all 16 selected PHP extension checks as PASS.

The web and CLI observations are separate SAPI checks. The Composer platform verification below was run using the Hostinger CLI.

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

A synthetic public PHP probe also successfully included `_app/__v2_private_marker.php` and returned `V2_PRIVATE_INCLUDE_OK` (HTTP 200); direct HTTP access to that marker returned HTTP 403.

All temporary files and directories were removed. Cleanup assertions confirmed that the temporary root `.htaccess`, `index.php`, `_app/`, public probe, and marker files were absent and the V2 staging directory had returned to its original empty state.

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

## 4. Source public-directory inventory

The GitHub contents listing for `public/` on branch `fix/hostinger-v2-subfolder-webroot` returned exactly:

| Source path | Decision for V2 package | Reason |
|---|---|---|
| `public/.htaccess` | Do not copy verbatim; use the reviewed V2 subfolder-specific template | Source rules use root-relative front-controller assumptions and do not include the V2-specific `_app` denial rules |
| `public/index.php` | Do not copy verbatim; use `deployment/hostinger-v2/public/index.php` | Original assumes Laravel app is one directory above `public/`; deployment entry point must resolve `_app/` |
| `public/robots.txt` | Candidate to copy unchanged after final packaging review | Contains only `User-agent: *` and `Disallow:`; no other public files or subdirectories were listed |

The original source `public/index.php` and `.htaccess` were inspected. No files were copied to Hostinger. Recheck this inventory if the branch changes before packaging.

## 5. Composer manifest and exact locked platform verification

The dependency manifests were downloaded from the exact PR head commit `e60fd9402a1b5e5c55aae3601ee4680389ca8936` using raw GitHub URLs, into a temporary directory under `/tmp`. No application source or vendor packages were downloaded. The temporary directory was removed after the checks.

Observed results:
- `composer validate --no-check-publish`: `./composer.json is valid`.
- `composer check-platform-reqs --lock --no-dev`: all reported non-development requirements passed.
- `composer check-platform-reqs --lock`: all reported requirements, including development requirements, passed.

Production lock-platform output:

| Requirement | Detected | Result |
|---|---:|---|
| `composer-runtime-api` | 2.2.2 | success |
| `ext-ctype` | provided by `symfony/polyfill-ctype` | success |
| `ext-dom` | 20031129 | success |
| `ext-fileinfo` | 8.5.12 | success |
| `ext-filter` | 8.5.12 | success |
| `ext-hash` | 8.5.12 | success |
| `ext-iconv` | 8.5.12 | success |
| `ext-json` | 8.5.12 | success |
| `ext-libxml` | 8.5.12 | success |
| `ext-mbstring` | provided by `symfony/polyfill-mbstring` | success |
| `ext-openssl` | 8.5.12 | success |
| `ext-pcre` | 8.5.12 | success |
| `ext-session` | 8.5.12 | success |
| `ext-tokenizer` | 8.5.12 | success |
| `php` | 8.5.12 | success |

The full lock-platform check also passed the additional development requirements `ext-phar`, `ext-xml`, and `ext-xmlwriter` (all detected at 8.5.12).

Static lock inspection previously found 77 production packages and 33 development packages. The root PHP requirement in `composer.json` and `composer.lock` is `^8.3`; Hostinger PHP 8.5.12 satisfies that constraint.

This verifies the platform requirements reported by Composer for this exact lock file against the Hostinger CLI environment. It does not install dependencies or prove Laravel application boot. In particular, the Composer platform check does not establish web-SAPI parity for every CLI extension.

## 6. CI evidence

For commit `3eb23deb44c70d02c1b4ae69e6028fcc7cec3c50`, FND-01 foundation CI #594 and documentation validation #1038 completed successfully.

For commit `e60fd9402a1b5e5c55aae3601ee4680389ca8936`, documentation validation #1039 and FND-01 foundation CI #595 completed successfully.

The evidence update in this document creates a new commit; fresh CI results for that new commit must be checked separately.

## 7. Deployment controls, limitations and remaining gates

Verified controls:
- The V2 staging target returned to empty after each synthetic test.
- The preserved backup was not modified.
- WordPress/V1 files and the root `.htaccess` were not modified.
- Git auto-deployment remains OFF.
- No Composer install, Artisan command, migration, database change, DNS change, deployment, or public activation occurred.
- No Laravel source, dependencies, `.env`, secrets, database configuration, or real data were placed on Hostinger.
- PR #313 remains draft and unmerged.

Limitations:
- `_app/` is planned to remain physically under `public_html`; HTTP denial is not private filesystem isolation.
- The denial tests prove only the exact tested requests and do not constitute a complete security assessment.
- The actual Laravel front controller and application have not been installed or booted on Hostinger.
- Preview authentication, V1 isolation, and complete application-route behaviour remain unverified.
- Composer CLI platform success does not itself prove the application can boot or that the LiteSpeed web SAPI has identical platform capabilities.

Remaining gates:
1. Verify the deployment-specific front-controller path and actual Laravel boot without secrets or production data, only after separate authorization for that next step.
2. Verify preview authentication and V1 isolation.
3. Keep deployment and public activation blocked until all gates and separate M3-11 release requirements are accepted.

No merge, deployment, or public activation is authorized by this preparation work.
