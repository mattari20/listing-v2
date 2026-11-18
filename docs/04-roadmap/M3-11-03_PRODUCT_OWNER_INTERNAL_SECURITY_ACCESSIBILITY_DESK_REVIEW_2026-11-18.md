# M3-11-03 — Product Owner Internal Security and Accessibility Desk Review

**Date:** 2026-11-18  
**Review type:** AI-assisted repository/code/test inspection; internal review only  
**Status:** PRELIMINARY INTERNAL EVIDENCE — OWNER DISPOSITIONS RECORDED WHERE NOTED; NO INDEPENDENT ASSESSMENT  
**Baseline inspected:** `main` at `5e68ac4ba70db0461a902832cb6ed483640b9a4c`  
**Scope:** Existing private V2 code and synthetic CI evidence; no live environment, production or real data

## 1. Purpose and limits

This record advances M3-11-03 through a Product Owner-led internal desk review of the current repository. It is not an independent penetration test, formal security audit, accessibility conformance audit, usability study or certification. No active scanning or testing against a hosted target occurred. No new environment was provisioned.

The current Product Owner boundary remains private V2 development/acceptance, synthetic fixtures only, no real student/institution/personal records, no public launch or participant testing, no child/student/guardian data or child-directed features, and Deeni Madaris default-OFF with zero public exposure.

## 2. Evidence inspected

- `routes/web.php`
- `bootstrap/app.php`
- `app/Http/Middleware/SecurityHeaders.php`
- `app/Authorization/ScopedAuthorization.php`
- `app/Http/Controllers/AccountSessionController.php`
- `tests/Feature/AccountSessionTest.php`
- `tests/Feature/ScopedAuthorizationTest.php`
- `tests/Feature/PublicDirectoryTest.php`
- `app/Services/Directory/PublicDirectoryQueryService.php`
- `config/session.php`
- `config/logging.php`
- `resources/views/directory/index.blade.php`
- `resources/views/directory/show.blade.php`
- `composer.json` and repository lockfile presence
- Existing M3-11-03 independent review preparation pack

## 3. Security observations and findings

### SEC-01 — Security response headers are partial (Medium)

The global `SecurityHeaders` middleware sets `X-Content-Type-Options: nosniff`, `X-Frame-Options: DENY`, `Referrer-Policy: strict-origin-when-cross-origin` and a restrictive `Permissions-Policy` disabling camera, microphone and geolocation. It is appended globally in the Laravel bootstrap.

No Content-Security-Policy or Strict-Transport-Security header is set by this middleware. HSTS depends on HTTPS deployment and host policy; CSP requires a deliberate compatibility policy. No dedicated security-header feature test was found in the inspected test tree.

**Internal disposition:** ACCEPT the existing four headers as partial baseline protection only. Defer CSP/HSTS target policy until exact private runtime and asset behavior are known. Add a dedicated header test before any environment acceptance; no configuration or code change is made by this review.

### SEC-02 — Session cookie security depends on environment (High for any hosted use)

The session configuration sets HTTP-only true, SameSite lax and JSON serialization. The secure-cookie setting is environment-controlled and has no hard-coded secure default in the inspected config. Session driver/lifetime also have environment-dependent/default values.

No effective runtime configuration was available because no target environment exists or was inspected.

**Internal disposition:** DEFER hosted-session acceptance. Before provisioning, record the exact effective private V2 settings and require HTTPS-only secure cookies, HTTP-only, appropriate SameSite, bounded lifetime and a non-production isolated session store. No environment is authorized.

### SEC-03 — Authentication boundary has useful synthetic negative tests (Partial / Medium)

The inspected route set has no public registration, password-reset or account-recovery route. Sign-in is rate-limited at 5 requests/minute and uses an account-session controller. Synthetic tests cover verified active account sign-in, unverified/inactive/service-identity denial, generic credential errors, account-switch conflict and logout.

The tests do not prove every browser cookie property, CSRF/browser behavior, brute-force behavior behind a real proxy, recovery lifecycle (which is not implemented), MFA, or runtime secret handling.

**Internal disposition:** ACCEPT as partial synthetic CI evidence only. No public registration/recovery or real accounts are authorized in this scope.

### SEC-04 — Scoped authorization is deny-by-default in the inspected service (Partial / Medium)

The authorization service denies null/inactive actors, empty actions/resource types, unknown actions, unscoped non-administrator roles, expired/revoked assignments and self-review/self-publication for specified review/publish actions. Administrator capability is narrowly listed for role management and security audit read. Tests cover resource scoping, expiry/revocation, self-review, idempotent grants, conflicting roles, exact scope, self-grant and unknown reason codes.

The self-review check is limited to the four explicit action names in the implementation. The tests and service review do not replace route-by-route authorization verification for every future action. The current human operating model remains single-owner and does not establish independent separation of duties in practice.

**Internal disposition:** ACCEPT as partial implementation/test evidence. Any new privileged action must add explicit policy and negative tests; do not infer operational role separation from code alone.

### SEC-05 — Route exposure and throttling are bounded in inspected routes (Partial / Low-Medium)

Inspected routes comprise health, account session create/destroy, authenticated institution claim/correction and editorial review routes, and anonymous read-only directory browse/profile. Mutating authenticated routes have scoped UUID route parameters and rate limits (20/minute or 30/minute); directory routes are limited to 60/minute; login is limited to 5/minute.

This is a source-code inventory, not an environment exposure scan. Proxy/IP trust, web server routes, debug endpoints, DNS, network ACLs and actual external reachability remain unknown.

**Internal disposition:** ACCEPT as repository route inventory only. No claim about hosted attack surface.

### SEC-06 — Logging and audit operations remain unresolved (High before environment provisioning)

The default logging channel resolves to stack/single file unless overridden. The single channel has no rotation limit; daily/monthly channels exist but are not the default. Actual runtime channel, log content, access, forwarding, retention and deletion are unknown. Application audit records do not prove database-owner tamper resistance or external audit retention.

**Internal disposition:** retain DP-03 prerequisite. A bounded logging policy is required before environment provisioning or reviewer access. External forwarding stays disabled by default. No logging code/configuration change is authorized here.

### SEC-07 — Public directory output has layered allowlisting and encoding (Partial / Medium)

The public query service requires approved anonymous directory projections, current snapshots, accepted claim versions, eligible source authorization and non-suppressed state. It independently excludes Deeni Madaris projection flags, requires the payload flag to be false, limits entity types, and requires registry-managed visibility and privacy classes to be public-eligible. Query-only flags are removed from the view projection. Blade output uses escaped interpolation and external links are limited to safe HTTP(S) URLs with `noopener noreferrer`.

Synthetic tests cover allowlisted approved facts, internal-note exclusion, categories/facets, locality behavior, HTML/URL handling, suppressed/revoked/expired facts and Deeni Madaris exclusion.

This does not prove every future field registry definition, every future route/export/cache, or any real dataset. No child/student/guardian data is in the accepted product scope.

**Internal disposition:** ACCEPT as bounded synthetic code/test evidence. Keep Deeni Madaris default-OFF and excluded. Continue synthetic-only institution/provider fixtures.

## 4. Accessibility observations and findings

### A11Y-01 — Semantic structure and form labels are present (Positive partial evidence)

The directory index has a document language declaration (`lang="en"`), a page title, a top-level heading, explicit labels for search/category/locality controls, a named category navigation landmark, a labelled results section and article/result headings. The profile page has a title, heading hierarchy, definition list for facts and a return link. The pages use responsive CSS breakpoints and text-first content.

**Internal disposition:** ACCEPT as positive source inspection evidence only; manual assistive-technology validation remains outstanding.

### A11Y-02 — Skip navigation and explicit focus treatment are not evident (Medium)

The inspected templates do not include a skip-to-main-content link. They do not define an explicit `:focus-visible` treatment. Browser default focus may remain, but that is not a verified, consistent focus design. The page also uses a results section and pagination output whose complete generated accessibility semantics were not inspected.

**Internal disposition:** record as an implementation improvement before accessibility acceptance. Do not claim keyboard conformance without manual testing.

### A11Y-03 — Contrast appears intentionally high but has not been measured (Unverified)

The templates use dark body text on a light background, dark button text contrast with white text, blue links and muted metadata. No automated contrast calculation or manual visual assessment at all states was performed. Border, focus, hover, disabled and error-state contrast is not established.

**Internal disposition:** require measured contrast and state coverage before any conformance claim.

### A11Y-04 — Manual keyboard and assistive-technology review is absent (High for conformance claim)

No evidence was found in this repository review of keyboard-only, screen-reader, zoom/reflow, high-contrast, touch-target, reduced-motion or browser/assistive-technology test execution. Automated CI does not establish WCAG 2.2 AA conformance.

**Internal disposition:** accessibility conformance remains NOT ASSESSED. A future internal review can prepare a repeatable test matrix, but it must not be labelled independent or certified.

## 5. Consolidated owner disposition

| ID | Disposition | Current limitation |
|---|---|---|
| SEC-01 | ACCEPT partial | CSP/HSTS target policy deferred; header test needed before environment acceptance |
| SEC-02 | DEFER | Effective session config and HTTPS environment unknown |
| SEC-03 | ACCEPT partial synthetic evidence | No public account lifecycle or real accounts |
| SEC-04 | ACCEPT partial implementation/test evidence | No claim of real-world separation of duties; new actions require tests |
| SEC-05 | ACCEPT repository inventory only | No hosted exposure or network review |
| SEC-06 | CONDITION BEFORE PROVISIONING | Bounded log policy prerequisite; no environment authorization |
| SEC-07 | ACCEPT bounded synthetic evidence | No real data; maintain Deeni Madaris exclusion |
| A11Y-01 | ACCEPT positive source evidence | Not a manual accessibility test |
| A11Y-02 | RECORD IMPROVEMENT | Skip link/focus design and generated pagination semantics need review |
| A11Y-03 | DEFER | Contrast not measured |
| A11Y-04 | NOT ASSESSED | No manual keyboard/AT/zoom/reflow testing or conformance claim |

## 6. Recommended next engineering-only actions

These are proposals for later bounded local/CI implementation, not changes made by this review:

1. Add synthetic feature tests asserting the four current security headers on representative public and authenticated responses.
2. Add a skip-to-main-content link and explicit visible `:focus-visible` styles to both directory templates; test that the target exists and is reachable.
3. Add a reproducible contrast-check record for normal text, muted text, links, button, borders and focus states; correct any measured failure.
4. Add static checks to ensure public directory templates retain explicit document language, page title, label/control associations and heading structure where practical.
5. Recheck exact route inventory and authorization policies whenever a route or privileged action is added.

No changes to application code, dependencies, runtime configuration or environment have been made. These implementation actions should be separately authorized as a narrow local/CI package before execution.

## 7. Explicit non-claims and blockers

- This is not an independent security review, penetration test, vulnerability certification or accessibility audit.
- No hosted environment, production/V1/Hostinger, live database, real data, participant or third-party target was accessed.
- No CSP/HSTS policy, logging policy, effective session configuration, hosting isolation, operational staffing, backup/recovery or deletion evidence is established.
- No WCAG 2.2 AA conformance claim is made.
- M3-11-03 remains IN PROGRESS / BLOCKED pending remediation of internal findings, a pinned candidate and any separately required assessment. Under the owner-led internal review model, the Product Owner may accept internal findings, but the implementer/AI does not independently certify its own work.
- M3-11 overall remains BLOCKED / NOT ACCEPTED. No environment provisioning, public pilot, deployment, production action or release is authorized.
