# M3-08A/B — Identity, Session Authentication and Scoped Authorization Implementation Record

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Base:** `4e453520b86fefc322a168de85f58d3cfddf18f1` (M3-08 preflight PR #231 merge)  
**Branch:** `feat/m3-08a-identity-authz-foundation`  
**Status:** Implementation candidate submitted for exact-head CI and review; not merged or production-ready.  
**Authority:** Product Owner explicitly approved the interim first-party Laravel session-authentication design and additive synthetic-only SQLite schema for users, role assignments and privileged-action audit records on 2026-11-16.

## 1. Authorized scope

This package implements only the bounded M3-08A identity/session foundation and M3-08B scoped authorization/role-audit foundation:

- First-party Laravel session guard; password hashes use Laravel's configured password hasher.
- Minimal account persistence: normalized unique email, password hash, optional verification timestamp, active flag, remember token and timestamps.
- Sign-in is restricted to pre-provisioned, active accounts with a non-null verification timestamp. There is no public account creation or verification mechanism.
- Session ID is regenerated after sign-in; logout invalidates the session and regenerates the CSRF token.
- Sign-in is throttled. Unknown, inactive, unverified and wrong-password cases share a generic authentication failure response.
- Server-side deny-by-default role/action/resource-scope authorization.
- Role grants/revocations run transactionally and write bounded audit metadata with controlled reason codes.
- Self-grant, self-revocation, self-review/self-publication, incompatible privileged-role combinations, interactive login by service identities, unknown capabilities, inactive targets, unknown roles and application-level administrator grants are denied.
- Additive migration creates only the new identity/role/audit tables. Validation is expected only on disposable SQLite in CI.

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
| `role_assignments` | Role grants with optional exact resource scope | Grantor, expiry and revocation metadata; indexes support active/scope checks |
| `privileged_action_audits` | Role grant/revocation audit trail | Actor, action, subject, scope, controlled reason code and role-only metadata; no credential/token fields |

The migration is additive and has a reverse migration for disposable-database rollback. It does not alter existing directory/governance tables. No migration was run against a live or production database.

## 4. Authorization contract

The `ScopedAuthorization` service requires an active authenticated user, a known action, and an active non-expired role assignment. A role assignment grants access only globally or to the exact resource type and identifier. A scoped assignment cannot authorize another resource. Unknown actions and roles fail closed.

| Role | Implemented capability boundary |
|---|---|
| Provider representative | Submit a provider claim within assigned provider scope |
| Data reviewer | Review evidence/claims within assigned resource scope |
| Publisher | Publish assertions/institution facts within assigned scope, with self-approval denial |
| Moderator | Reserved UGC moderation/appeal capability only; no route or UGC feature is enabled |
| Administrator | Role management and audit-read capability only; no direct institutional publication or moderation capability |
| Service identity | No interactive session or broad human role capability |

Registered-user account ownership is handled by the session identity only; no profile or review action is exposed in this package. Resource scope is checked server-side, not inferred from client/UI state.

Role changes are exposed only through the internal service contract, not an HTTP administration route. The service prevents an actor from granting/revoking their own assignment, rejects unknown reason codes, avoids duplicate active grants, and writes the audit record in the same transaction. Administrator grants/revocations are deliberately excluded from the service and require a future separately designed, independently controlled break-glass process. No break-glass mechanism is implemented here.

The audit model is append-only by application convention in this package; database-owner tamper resistance, external audit export and retention policy are not claimed.

## 5. Synthetic test coverage added

- Session sign-in for an active, verified synthetic account.
- Email normalization, session authentication, logout invalidation.
- Denial of unverified/inactive accounts.
- Identical generic failure responses for unknown accounts and wrong passwords.
- Exact resource-scope authorization and cross-scope denial.
- Denial of incompatible privileged-role combinations and interactive service-identity sign-in.
- Deny unknown action and role capability.
- Administrator capability isolation.
- Self-review/self-publication denial.
- Expired/revoked role denial.
- Transactional role grant, duplicate grant idempotency and audit evidence.
- Immediate role revocation and audit evidence.
- Self-grant, non-admin role grant, administrator grant and invalid reason-code denial.

All fixtures use fabricated `.example.test` identities and synthetic credentials. The existing anonymous directory suite remains part of the full CI regression gate.

## 6. Validation and acceptance gates

At the time this record was authored, the code has been committed to the implementation branch, but exact-head CI has not yet been observed. No test count, passing result, merge or completion claim is made until GitHub reports the exact PR-head workflow results.

Required validation:
1. Composer manifest and locked dependency audit remain clean; no new package is introduced.
2. Laravel bootstrap and route listing succeed.
3. Pint formatting succeeds.
4. Full existing and new synthetic PHPUnit suite passes on PHP 8.5 with disposable in-memory SQLite.
5. Migration up/down/reinstall behavior remains clean on disposable SQLite.
6. Existing public directory anonymous access and Deeni Madaris zero-exposure regressions remain passing.
7. Documentation validation succeeds on the exact PR head.
8. Review confirms no public registration, verification/recovery route, UGC endpoint, role-admin route, provider integration or production operation has slipped into scope.

SQLite success is not evidence of MySQL locking/concurrency behavior. This package does not establish production readiness, legal compliance, age assurance, operational identity recovery, independent security review or a public launch decision.

## 7. Remaining M3-08 work

M3-08A/B are bounded foundations only. M3-08C moderation/appeals state foundations and M3-08D privacy/safeguarding/security verification remain separate work packages and must preserve post-launch review timing and zero public UGC until separately authorized. Account eligibility, age assurance, verification delivery, recovery, retention/deletion, moderation staffing and qualified legal/privacy/child-safeguarding review remain open decisions. M3-09 through M3-11 remain future roadmap steps.
