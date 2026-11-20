# RCV-B08 — Account-Dependent Saved Items and Alerts: Scope and Acceptance Pack

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Baseline main:** c6cb7b679271efdfe5fd5d6be8b93cd428036f19  
**Agenda:** RCV-B08 — Account-Dependent Saved Items and Alerts  
**Status:** Product Owner policy approved by instruction to proceed on 2026-11-20; private saved-items slice implemented in PR branch `feat/rcv-b08-private-saved-items`; exact-head validation pending. Sharing, alerts and public account lifecycle remain deferred.

## 1. Why this agenda is next

RCV-01 identifies RCV-B08 as the next P2 residual package after RCV-B07. Its scope is account lifecycle, saved items, share controls, notification preferences, opt-in/opt-out and retention/deletion. Preconditions are a Product and privacy decision; no messaging vendor or spend is authorized.

## 2. Repository evidence inventory

### 2.1 Existing account and authentication foundation

- The users table contains normalized unique email, password hash, optional email_verified_at, is_active, remember token and timestamps.
- Sign-in accepts only pre-provisioned active accounts with a non-null verification timestamp. A service identity cannot use interactive login.
- Sign-in regenerates the session ID; sign-out invalidates the session and regenerates the CSRF token; account switching without sign-out is denied.
- Sign-in is throttled and unknown/wrong/inactive/unverified/service-identity cases share a generic failure response.
- The only account routes are POST /account/session and authenticated DELETE /account/session.
- No public registration, account creation, email verification delivery, password recovery/reset, user profile, account self-service, account closure or account deletion workflow is present.
- Login does not prove student status, attendance, alumni status, institutional affiliation or review eligibility.
- Identity/role/audit foundations were implemented in PR #232 for synthetic local/CI use only; the implementation record makes no production-readiness claim.

### 2.2 Existing shortlist and comparison

- Public directory shortlist add/remove and comparison routes already exist.
- The shortlist is stored under the Laravel session key directory_shortlist; the controller reads/writes entity IDs in the session and resolves the current public projection on each request.
- The initial shortlist limit is five, with a bounded configurable range; comparison is session-only and enforces like-for-like entity types.
- RCV-B03 explicitly approved temporary session-only shortlist for the first comparison slice. Persistent account-based saving, shareable links, reminders and notifications were deferred and require a separate privacy/retention and security contract.
- No saved-item model/table, account-to-entity relation, share token, notification preference, alert subscription, notification center or delivery job/route was found in the repository tree.

### 2.3 Session and privacy configuration

- Checked-in session configuration defaults to array driver, 120-minute lifetime, expire-on-close false, session encryption false, HTTP-only true and SameSite Lax. These values can be overridden by environment configuration.
- Secure-cookie behavior is environment-configurable; no actual target/runtime configuration has been accepted or verified.
- M3-11-02 privacy review recorded DP-02 as DEFER pending a separately authorized target/configuration review.
- M3-11-02 DP-03 requires a bounded log-field/retention/access decision before private environment provisioning or reviewer access. The checked-in default logging stack includes a single file channel without configured rotation; actual runtime destinations and retention are unknown.
- Privileged-action audit metadata is account-linkable; the current record does not claim database-owner tamper resistance or a completed retention policy.
- No production, hosting, real-user or external messaging configuration was inspected.

## 3. Capability gap

| Capability | Current evidence | Gap |
|---|---|---|
| Account authentication | Pre-provisioned verified account sign-in/out | No public account lifecycle or self-service |
| Anonymous shortlist | Temporary Laravel session shortlist | No persistent account-owned saved items |
| Sharing | No share route/token | No user-controlled share, expiry or revocation |
| Notification preferences | None found | No explicit opt-in/opt-out or channel preferences |
| Alerts/delivery | None found | No event source, delivery job, in-app inbox or channel |
| Retention/deletion | Session lifetime only for temporary shortlist | No saved-item retention, account closure or deletion contract |
| Privacy/logging | Partial synthetic account boundary and owner privacy review | Target session/logging configuration and retention gates remain open |

## 4. Recommended staged product policy — Product Owner decision required

### 4.1 Account lifecycle

- Keep public registration disabled in the first saved-items slice. Continue using pre-provisioned active/verified accounts for internal synthetic acceptance only.
- Treat public registration, email verification, recovery, profile management and account closure as a separate lifecycle decision; do not imply those capabilities exist because the sign-in endpoint exists.
- Never infer student status or institutional affiliation from account authentication.

### 4.2 Saved items

- Keep anonymous shortlist and comparison behavior unchanged.
- Add persistent saved items only for authenticated account owners, with private-by-default visibility and server-side owner checks on every read, add and delete.
- Persist only the user ID, eligible public entity ID and timestamps; no free-text notes, child/student attributes, precise location, application status or sensitive personal data.
- Enforce one saved-item row per user/entity pair and a configurable bounded maximum.
- At read time, resolve the current approved public projection and re-check visibility/suppression; never snapshot raw claims, evidence or restricted data into the saved list.
- Let the owner remove an item at any time. Account closure/deletion should remove saved items as part of the approved deletion workflow.

### 4.3 Sharing

- Keep saved lists private in the first implementation; do not create public share URLs or guessable IDs.
- Consider sharing only in a later separately authorized slice with high-entropy tokens, read-only public projection, expiry, revocation, abuse controls and clear disclosure of what the recipient can see.

### 4.4 Alerts and notification preferences

- Do not send email, SMS, WhatsApp, push or external messages in the first implementation.
- Keep notification subscriptions off by default. Any future alert requires explicit, channel-specific opt-in, clear event/frequency settings, easy opt-out and a recorded consent change.
- Do not select a messaging provider, add an external dependency or incur spend in this agenda without a separate decision.
- A future in-app alert center may be evaluated separately after the platform defines trustworthy change events, deduplication, freshness, delivery/read state and user deletion behavior.

### 4.5 Retention and deletion

- Saved items must be user-deletable at any time and removed when an account is closed/deleted, subject to a separately approved legal/audit exception.
- Do not invent an inactivity expiry or retention duration. Obtain Product Owner decision after the data class, account lifecycle and backup/log retention behavior are understood.
- Define how deletion propagates to primary data, sessions, caches, backups and any future notification queue before real accounts or a public environment are enabled.
- Do not retain share tokens or notification delivery payloads in this first slice because those features are excluded.

## 5. Candidate implementation slices — not authorized

| Slice | Candidate deliverable | Status |
|---|---|---|
| B08-A | Account lifecycle and saved-item privacy/retention policy | APPROVED for the bounded private saved-items slice; public account lifecycle deferred |
| B08-B | Private account-owned saved items with synthetic tests and public-projection revalidation | IMPLEMENTED in PR branch `feat/rcv-b08-private-saved-items`; exact-head validation pending |
| B08-C | Share tokens, expiry, revocation and read-only share surface | Deferred; separate authorization required |
| B08-D | Notification preferences, consent/opt-out lifecycle and event semantics | Deferred; separate authorization required |
| B08-E | Delivery channel/provider and operational retention | Not authorized; vendor/spend decision required |

## 6. Acceptance criteria for a future saved-item slice

1. Anonymous discovery and the existing session-only shortlist continue to work unchanged.
2. Only an authenticated account owner can create/read/delete their own saved items; cross-account IDOR tests deny access.
3. A saved item references only a currently eligible public directory entity; withdrawn, suppressed, unpublished or Deeni Madaris entities are not exposed through saved lists.
4. Repeated save requests are idempotent; duplicate user/entity pairs are prevented.
5. Saved-item maximum and validation are enforced server-side.
6. No notes, child/student status, precise location, contact data or other unnecessary personal attributes are stored.
7. Individual deletion works; account closure/deletion behavior is explicitly tested once authorized.
8. No public registration, share links, notifications, external delivery or vendor is introduced unless separately approved.
9. Session configuration, log fields/retention/access and data deletion/backup implications receive the required privacy/security review before any target provisioning or real account use.
10. Deeni Madaris remains default-OFF and zero-public-exposure.

## 7. Explicit exclusions

- No code, schema, migration, route, job, notification, account lifecycle or persistence implementation in this preflight.
- No real account/user/student/guardian/staff data; synthetic fixtures only.
- No public registration, email verification/recovery delivery, profile or account closure endpoint.
- No shareable URL, public list, email/SMS/WhatsApp/push delivery or notification provider.
- No production/Hostinger/V1 access, deployment, public launch or environment provisioning.
- No new dependency, external API, AI, paid service, procurement or spend.
- No change to the existing anonymous directory, session-only shortlist/comparison or Deeni Madaris default-OFF behavior.

## 8. Product Owner decisions requested

The Product Owner instructed the project to move forward and complete the agenda after this recommendation was presented; this is recorded as approval of the bounded first slice unchanged: private saved items for pre-provisioned active/verified accounts, no public registration, no share links, no message delivery, anonymous session shortlist unchanged, owner deletion supported and no automatic retention duration selected. The exact-file B08-B implementation authorization is recorded in `RCV-B08_BOUNDED_IMPLEMENTATION_AUTHORIZATION_2026-11-20.md`.

This approval does not authorize a public account lifecycle, notifications, a messaging vendor, external delivery, target provisioning or production use.

## 9. Current disposition

RCV-B08 repository inventory and privacy boundaries are complete. The approved B08-B private saved-items slice is implemented on `feat/rcv-b08-private-saved-items` and awaiting exact-head validation. B08-C sharing, B08-D alert preferences/event semantics, B08-E delivery/provider and public account lifecycle remain deferred; DP-02/DP-03 target privacy gates remain binding.