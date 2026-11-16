# M3-08A/B — Identity, Session Authentication and Scoped Authorization Implementation Record

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Base:** `4e453520b86fefc322a168de85f58d3cfddf18f1` (M3-08 preflight PR #231 merge)  
**Branch:** `feat/m3-08a-identity-authz-foundation`  
**Status:** Exact-head FND-01 CI and Project documentation validation passed on `a09f17d4ef2a5e1e31a43c7735be2106db09e301` (PR #232 head at validation). PR #232 remains open pending final merge. Not production-ready.  
**Authority:** Product Owner explicitly approved the interim first-party Laravel session-authentication design and additive synthetic-only SQLite schema for users, role assignments and privileged-action audit records on 2026-11-16.

## 1. Authorized scope

This package implements only the bounded M3-08A identity/session foundation and M3-08B scoped authorization/role-audit foundation:

- First-party Laravel session guard; password hashes use Laravel's configured password hasher.
- Minimal account persistence: normalized unique email, password hash, optional verification timestamp, active flag, remember token and timestamps.
- Sign-in is restricted to pre-provisioned, active accounts with a non-null verification timestamp. There is no public account creation or verification mechanism.
- Session ID is regenerated after sign-in; logout invalidates the session and regenerates the CSRF token. An already authenticated session cannot silently switch accounts.
- Sign-in is throttled. Unknown, inactive, unverified, service-identity and wrong-password cases share a generic authentication failure response.
- Server-side deny-by-default role/action/resource-scope authorization. Every grantable non-administrator role requires an exact resource type and identifier; global grants are not available through the service.
- Role grants/revocations run transactionally and write bounded audit metadata with controlled reason codes.
- Self-grant, self-revocation, self-review/self-publication, incompatible privileged-role combinations, interactive login by service identities, unknown capabilities, inactive targets, unknown roles and application-level administrator grants are denied.
- Additive migration creates only the new identity/role/audit tables. Migration up/down/reinstall is tested only on a disposable SQLite database.

## 2. Explicitly disabled or excluded

The following remain disabled or absent:

- Public registration/account creation.
- Email verification routes, email/SMS delivery, password reset/recovery routes and credential delivery.
- User-facing account/profile UI and role-administration endpoints.
- Review submission, review/rating pages, reports, moderation UI/endpoints and appeals.
- Any claim that authentication proves student status, attendance, alumni status or institutional affiliation.
- Age-document collection, identity-document proofing, provider identity service or external authentication.
- Third-party packages, external APIs, production/V1/Hostinger access, deployment, release and additional spend.
- Real account/user/student/provider data.

The session endpoint can authenticate only a pre-provisioned synthetic or otherwise separately authorized verified account. No public workflow currently creates such accounts. The email verification timestamp is a prerequisite flag, not proof that a verification workflow exists.

## 3. Persistence contract

Migration `2026_11_16_000002_create_identity_and_authorization_tables.php` adds:

| Table | Purpose | Key safety properties |
|---|---|---|
| `users` | Minimal private account credential state | Unique normalized email; password hash only; verification timestamp; active flag; no public profile, phone, birth date or student-status fields |
| `role_assignments` | Role grants with exact resource scope | Grantor, expiry and revocation metadata; indexes support active/scope checks |
| `privileged_action_audits` | Role grant/revocation audit trail | Actor, action, subject, scope, controlled reason code and role-only metadata; no credential/token fields |

The migration is additive and has a reverse migration for disposable-database rollback. The existing I7 migration regression now validates all 12 migrations and checks that the three identity tables are created, removed on full rollback and recreated on reinstall. It does not alter existing directory/governance tables. No migration was run against a live or production database.

## 4. Authorization contract

The `ScopedAuthorization` service requires an active authenticated user, a known action, and an active non-expired role assignment. Domain roles authorize only the exact resource type and identifier; a global or null-scoped domain assignment fails closed. Only the separately controlled global administrator role can carry global role-management/audit capabilities. Unknown actions and roles fail closed.

| Role | Implemented capability boundary |
|---|---|
| Provider representative | Submit a provider claim within assigned provider scope |
| Data reviewer | Review evidence/claims within assigned resource scope |
| Publisher | Publish assertions/institution facts within assigned scope, with self-approval denial |
| Moderator | Reserved UGC moderation/appeal capability only; no route or UGC feature is enabled |
| Administrator | Global role management and audit-read capability only; no direct institutional publication or moderation capability; grant/revocation excluded from application service |
| Service identity | Exact-scoped non-human identity; no interactive session or broad human role capability |

Registered-user account ownership is handled by the session identity only; no profile or review action is exposed in this package. Resource scope is checked server-side, not inferred from client/UI state.

Role changes are exposed only through the internal service contract, not an HTTP administration route. The service prevents an actor from granting/revoking their own assignment, rejects unknown reason codes, requires exact resource scope, avoids duplicate active grants, rejects incompatible privileged-role combinations, and writes the audit record in the same transaction. Administrator grants/revocations are deliberately excluded from the service and require a future separately designed, independently controlled break-glass process. No break-glass mechanism is implemented here.

The audit model is append-only by application convention in this package; database-owner tamper resistance, external audit export and retention policy are not claimed.

## 5. Synthetic test coverage added

- Session sign-in for an active, verified synthetic account; email normalization; session authentication and logout invalidation.
- Denial of unverified/inactive accounts, service-identity interactive login, and account switching without signing out.
- Identical generic failure responses for unknown accounts and wrong passwords.
- Exact resource-scope authorization, cross-scope denial and rejection of null-scoped non-administrator roles.
- Deny unknown action and role capability.
- Administrator capability isolation and self-review/self-publication denial.
- Expired/revoked role denial.
- Transactional scoped role grant, duplicate grant idempotency and audit evidence.
- Immediate role revocation, including inactive target accounts, with audit evidence.
- Incompatible role combination, self-grant, non-admin grant, global grant, administrator grant and invalid reason-code denial.

All fixtures use fabricated `.example.test` identities and synthetic credentials. The existing anonymous directory and Deeni Madaris zero-exposure suites remain part of the full CI regression gate.

## 6. Validation evidence

Exact-head GitHub validation passed for commit `dd332743be3f3cd53939c5f03c8d6744dd5e178e`:

| Check | Result |
|---|---|
| Composer manifest validation | Passed |
| Locked dependency advisory audit | Passed; no advisories reported |
| Pint formatting | Passed |
| Laravel bootstrap and route listing | Passed |
| Full synthetic PHPUnit suite | Passed — 15 passed, 856 assertions; 185 warnings remain from existing missing-`.env` test diagnostics |
| Disposable SQLite migration rollback/reinstall | Passed as part of the full suite; 12 migrations and identity tables included |
| Repository artifact hygiene | Passed; no `.env` or database artifact created/tracked |
| Project documentation validation | Passed on the exact same head |

FND-01 CI run #374 and Project documentation validation run #753 are the exact-head checks for this commit. The warnings are existing test-harness diagnostics for absent `.env`; no `.env` was created to suppress them. Both checks passed on the same PR head. No merge or production-readiness claim is made here.

## 7. Remaining M3-08 work

M3-08A/B are bounded foundations only. M3-08C moderation/appeals state foundations and M3-08D privacy/safeguarding/security verification remain separate work packages and must preserve post-launch review timing and zero public UGC until separately authorized. Account eligibility, age assurance, verification delivery, recovery, retention/deletion, moderation staffing and qualified legal/privacy/child-safeguarding review remain open decisions. M3-09 through M3-11 remain future roadmap steps.
