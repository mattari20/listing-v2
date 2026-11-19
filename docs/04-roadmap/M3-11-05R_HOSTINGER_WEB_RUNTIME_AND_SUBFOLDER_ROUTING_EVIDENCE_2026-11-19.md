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

## 3. Scope and limitations

These results demonstrate that the tested LiteSpeed configuration enforced the tested URL denials and subfolder rewrite behaviour under synthetic conditions. They do not constitute a complete security assessment.

In particular:
- `_app/` is planned to remain physically under `public_html`; HTTP denial is not private filesystem isolation.
- PHP include/read access from the public front controller into `_app/` has not yet been verified.
- The actual Laravel front controller and application have not been installed or booted on Hostinger.
- The exact locked Composer platform requirements have not yet been checked against the hosted runtime.
- Source `public/` asset inventory and mapping have not yet been completed.
- Preview authentication, V1 isolation, and complete application-route behaviour remain unverified.
- No Laravel source, dependencies, `.env`, secrets, database configuration, or real data were placed on Hostinger.

## 4. Deployment and release controls

- New V2 staging target remains empty after testing.
- Preserved backup was not modified.
- WordPress/V1 files and root `.htaccess` were not modified.
- Git auto-deployment remains OFF.
- No Composer install, Artisan command, migration, database change, DNS change, deployment, or public activation occurred.
- PR #313 remains draft and unmerged.

## 5. Next required gates

1. Enumerate and review the exact repository source `public/` inventory.
2. Check exact locked Composer platform requirements in a controlled project workspace.
3. Prove PHP can include a harmless file from `_app/` while direct HTTP access remains denied.
4. Verify the actual Laravel front-controller path and app boot without secrets or production data.
5. Verify preview authentication and V1 isolation.
6. Obtain fresh CI results for the latest PR head.
7. Keep deployment and public activation blocked until all gates and separate M3-11 release requirements are accepted.
