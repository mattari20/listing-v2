# M3 Security Policy-to-Implementation Reconciliation — 2026-11-21

**Repository:** `mattari20/listing-v2`  
**Baseline:** `3209e8ec6ed8b73a9ba2720d5d4727d251012d9f`  
**Review type:** Product Owner policy-to-source reconciliation; repository-only  
**Status:** PARTIAL SOURCE RECONCILIATION — NOT SECURITY ACCEPTANCE

## 1. Scope and evidence limits

This review compares the Product Owner decisions SEC-PO-07 (server-side deny-by-default) and SEC-PO-11 (secure uploads) with the current repository route/controller inventory and selected source/tests. It is not an independent security assessment, penetration test, complete threat model, formal source audit, or production/hosted review. No live system, database, personal data, external service, or hosted environment was accessed.

The source snapshot reviewed is the mainline baseline recorded above. This review does not prove runtime behavior beyond the checked-in tests and source-level observations.

## 2. SEC-PO-11 — Upload capability applicability

### Evidence inspected

- Complete recursive Git tree at the baseline: the only application route files are `routes/web.php` and `routes/console.php`; there is no `routes/api.php` or other route file.
- Complete `routes/web.php` route inventory.
- All eight files under `app/Http/Controllers/`.
- Controller search terms included upload handling, `UploadedFile`, `hasFile`, `storeAs`, and storage writes.

### Finding

No upload route, upload controller action, file-input handling, or upload storage operation was found in the current repository candidate. The checked-in route inventory is limited to ordinary GET/POST/PATCH/DELETE actions for sessions, workspace, directory, claims, editorial cases, campuses and delivery sites. The inspected controllers contain no upload handling.

**Disposition:** SEC-PO-11 is **NOT APPLICABLE to the current repository candidate** on the inspected baseline. No upload capability is evidenced in this candidate, so no upload implementation is authorized or needed as part of this reconciliation. If a future change introduces uploads, the recorded Option A requirements are mandatory before that capability can be accepted: disable uploads where not required; for retained uploads, validate type/content and size server-side, generate safe filenames, restrict storage and access, and prevent executable/unsafe content.

This is a repository inventory finding, not proof that no upload feature exists in any external/hosted/V1 system. No such system was accessed.

## 3. SEC-PO-07 — Server-side deny-by-default

### Positive source/test evidence

- `app/Authorization/ScopedAuthorization.php` returns false for a null actor, inactive actor, empty action/resource type, and any action not explicitly present in the role-action map.
- Non-administrator assignments require an exact resource type and resource ID match; revoked and expired assignments are excluded.
- The administrator exception is explicit and narrow: a global administrator assignment grants only `roles.manage` and `security.audit.read` in the current map. It does not grant publication or UGC moderation.
- `tests/Feature/ScopedAuthorizationTest.php` covers unknown actions, wrong resource scope, non-administrator global scope, expired/revoked assignments, self-review/self-publication, and the limited administrator capability set.
- The login controller requires an active, verified account, regenerates the session after login, and invalidates the session on logout.
- Workspace, editorial-case, institution-campus, and university-representative controllers contain active/verified account checks and/or explicit scoped authorization checks.

### Gap found and bounded remediation

The `/account/saved-items` route group was protected by Laravel authentication middleware and ownership-scoped queries, but its controller did not re-check whether an already-authenticated account had subsequently become inactive or unverified. The existing login check alone does not protect an already-open session after an account-status change.

A focused repository-only correction has been prepared on this agenda branch:
- Re-check active and verified account state server-side for saved-item list, create, and delete actions.
- Add synthetic feature tests asserting that inactive and unverified authenticated sessions receive HTTP 403 for all three actions.
- Preserve owner-only data scoping and existing behavior for active, verified users.

The bounded change was merged in PR #452 at `e4aa631fda080a77e7da20905eff6a499a90f0a1`. Exact-head PHP 8.5 foundation CI run #870 and project documentation validation run #1447 both passed. The synthetic test suite passed within run #870. This is repository-level verification only, not independent security acceptance.

## 4. Remaining evidence and limitations

- This review is a bounded source inspection, not an independent security assessment.
- The administrator global role remains a deliberate explicit global-scope exception; independent review must assess whether its two mapped capabilities and governance are appropriate.
- Route/controller review does not establish every domain-service call path, all future routes, runtime configuration, hosted session revocation, or operational controls.
- The synthetic tests must pass on the exact PR head.
- Independent security assessment and M3-11-03 remain BLOCKED / NOT ACCEPTED.
- Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.

## 5. Restrictions preserved

Synthetic fixtures only. No production/V1/Hostinger/hPanel access, live database, migrations, backup/recovery activity, hosted testing, external APIs/AI, deployment, pilot, release, public UGC activation, new spend, or scope expansion. Deeni Madaris remains default-OFF with zero public exposure.

**Final disposition:** SEC-PO-11 is not applicable to the inspected repository candidate; SEC-PO-07 is substantially represented in the inspected authorization service/tests, with the saved-items active/verified-session gap addressed in this bounded branch pending CI. No M3 security gate is closed by this document.
