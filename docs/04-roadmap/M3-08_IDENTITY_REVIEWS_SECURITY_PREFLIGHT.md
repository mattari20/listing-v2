# M3-08 — Identity, Reviews and Security Scope / Architecture Preflight

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Verified base:** `a65027a673f4ba0d9a68fe4275151806bf50bc1e`  
**Branch:** `docs/m3-08-identity-security-preflight`  
**Status:** Preflight complete; implementation is NOT authorized by this record.  
**Authority:** Product Owner instruction to proceed to the next agenda and complete its preflight. This record does not expand that instruction into application implementation.

## 1. Purpose and decision

M3-08 is the next M3 roadmap step: Identity, Reviews and Security (10% planning weight). The purpose of this preflight is to reconcile the accepted M2-S08 architecture and product requirements with the current main-branch application, identify the implementation gap, propose a dependency-ordered bounded work package, and define acceptance tests and stop conditions.

**Decision:** M3-08 is ready for a separately authorized, staged implementation plan. It is not ready for public review collection or production identity use. No application code, schema, migration, dependency, route, UI, account, review, moderation or security control was changed in this preflight.

Reviews remain post-launch only. No pre-launch survey, interview, participant recruitment, review collection or outreach is authorized. Login is not proof of attendance, student status, alumni status or institutional affiliation.

## 2. Baseline and inspection evidence

The inspection used the verified `main` baseline `a65027a673f4ba0d9a68fe4275151806bf50bc1e`. It was repository-only and read-only.

| Area | Observed evidence | Preflight finding |
|---|---|---|
| Public routing | `routes/web.php` defines `/health`, `/directory` and UUID `/directory/{entity}`; directory routes use `throttle:60,1` | Current public experience is anonymous-first and limited to read-only directory browsing |
| Middleware bootstrap | `bootstrap/app.php` has an empty application middleware configuration closure | No application-specific authentication/authorization middleware is registered in the inspected bootstrap |
| User identity model | `app/Models/User.php` was not present at the inspected path | No project User model was found at the conventional Laravel path |
| Authentication configuration | `config/auth.php` was not present at the inspected path | No project auth configuration was found at the conventional Laravel path |
| User persistence | The conventional default users migration path `database/migrations/0001_01_01_000000_create_users_table.php` was not present | No conventional users-table migration was found at the inspected path |
| API routing | `routes/api.php` was not present at the inspected path | No API route file was found at the conventional path |
| Dependencies | `composer.json` requires PHP `^8.3`, Laravel Framework `^13.17` and Laravel Tinker; no separate authentication, role/permission or moderation package is declared | No auth vendor or moderation dependency has been selected |
| Existing domain controls | M3-03/M3-04/M3-07 deliver governed institution facts, editorial cases, source authorization and proposal-only synthetic agent paths | These domain/editorial roles are not end-user account identity; do not conflate them |
| Product review requirement | `docs/01-product/COMPARISON_REVIEWS_AND_TRUST.md` requires authenticated review submission, anonymous public browsing, no unsupported “verified student” label, moderation, appeal and provider right-of-reply | Review policy decisions remain open; review feature is post-launch only |
| Accepted security design | `docs/05-architecture/M2-S08_IDENTITY_AUTHORIZATION_REVIEWS_PRIVACY_SECURITY.md` defines role/action authorization, scoped access, separation of duties, privacy/minor safeguards and security tests | This is the governing design baseline; it is not implementation evidence |

The absent-path findings above are limited to the conventional paths explicitly inspected. They are not a claim that every possible alternative implementation or third-party mechanism was exhaustively searched.

## 3. Governing architecture and invariants

M2-S08 and the M2-S07/S08/S09 joint validation remain binding. M3-08 must preserve:

1. **Anonymous-first discovery:** no account required for public directory search, profiles or comparisons.
2. **Least privilege and deny by default:** every protected action is authorized server-side against both action and resource scope; UI hiding is never a security boundary.
3. **Separation of duties:** source authorization, evidence review, publication, moderation and role administration remain distinct capabilities.
4. **No self-approval:** users cannot moderate their own cases; provider representatives cannot overwrite or approve their own factual submissions; high-impact publication remains independently adjudicated.
5. **Identity is not proof:** authentication proves control of an account only. It does not prove attendance, student/alumni status, affiliation or review authenticity.
6. **Privacy by design:** minimize account data; do not publicly expose email, phone, legal name, precise birth date, account IDs or a minor's identity/contact/location.
7. **Minor safeguarding:** no direct adult-to-minor messaging in the initial scope; age-appropriate safe defaults, reporting/escalation and qualified review are prerequisites before user-generated content is exposed.
8. **Review timing:** reviews are post-launch only. No pre-launch collection, surveys, interviews, recruitment or outreach.
9. **Fair moderation:** reasoned decisions, notice, reporting, appeal/reconsideration, audit, correction and provider right-of-reply; no unilateral institution deletion.
10. **Deeni Madaris default-OFF:** retain V2-DEC-006 across public search, direct lookup, browse, recommendations, facets, counts, sitemap, exports, caches and APIs; no sect/maslak discovery filters or inference.
11. **No unapproved legal claims:** this work does not establish compliance with Pakistani or foreign law. Qualified legal/privacy/child-safeguarding review is required for the actual operating model before launch.
12. **No unapproved service or spend:** no identity vendor, SMS/email provider, moderation vendor, paid security product or new spend is selected or authorized.

## 4. Role and capability boundary

The following is the proposed logical matrix carried forward from M2-S08. It is a design contract, not a grant of live permissions.

| Identity class | Permitted logical scope | Must remain prohibited |
|---|---|---|
| Anonymous visitor | Eligible public directory read/search/profile/compare | Account data, submissions, admin or restricted records |
| Registered user | Own account lifecycle; own eligible post-launch review submission/edit request | Publish institutional facts, moderate own case, impersonate or inspect another account |
| Provider representative | Submit correction/evidence request for explicitly verified provider scope; labelled right-of-reply where later approved | Direct fact overwrite, self-approval, suppressing criticism or moderation decisions |
| Data reviewer | Assigned evidence and review-case assessment within explicit scope | Change source rights, administer roles or publish without a separate grant |
| Publisher/adjudicator | Approve eligible assertions/publication within assigned scope | Alter audit history or self-approve own high-impact evidence |
| Moderator | Report triage, hide/restore user-generated content, reasoned moderation and appeal handling | Change institutional facts or adjudicate own case |
| Administrator | Role/configuration administration with strong controls and audited privileged actions | Unlogged access, unrestricted content editing or self-granting operational authority |
| Service identity | Explicitly allowlisted, non-interactive workload capability | Human login, shared credentials, broad admin or inherited human roles |

Implementation must use resource-level scope and explicit action checks, not role-name checks alone. Role grants/revocations must be auditable and effective immediately for subsequent authorization decisions.

## 5. Proposed staged implementation work packages

These are proposed work packages for a future, separately authorized M3-08 implementation. No package is authorized by this preflight.

### M3-08A — Identity and account lifecycle
- Decide the authentication method/provider only after checking the accepted stack, account data minimization, recovery security, hosting fit and cost.
- Define account creation, verification, sign-in, session expiry/revocation, recovery, credential rotation, closure and rate limiting.
- Prevent account enumeration in recovery and verification flows.
- Keep public discovery usable without authentication.
- Do not add age-document collection or identity-document verification by default.

### M3-08B — Scoped authorization and privileged audit
- Implement a server-side deny-by-default role/action/resource-scope policy contract.
- Separate provider, evidence reviewer, publisher, moderator, administrator and service identities.
- Enforce separation-of-duties and prohibit self-approval.
- Record bounded audit metadata for role grants, revocations and privileged actions; never log credentials, tokens or unnecessary personal data.
- Ensure revocation and role changes invalidate stale authority and relevant sessions/caches.

### M3-08C — Moderation and appeals foundations (synthetic-only; feature disabled)
- Specify review/report/moderation/appeal state transitions, reasons, notices, evidence retention and provider right-of-reply.
- Use synthetic fixtures only for tests.
- Keep review submission, public review pages, rating aggregates and collection endpoints disabled until post-launch and separate approval.
- Do not invent review eligibility, verification labels, rating dimensions, thresholds, service levels or retention periods.

### M3-08D — Privacy, safeguarding and security verification
- Define data-class inventory, purpose, minimization, visibility, retention/deletion and redaction requirements.
- Specify safeguarding escalation boundaries and operational ownership before any user-generated content is enabled.
- Test privacy leakage through responses, logs, search, caches, exports and error handling.
- Preserve Deeni Madaris zero-exposure behavior across all public surfaces and side channels.

## 6. Synthetic acceptance and adversarial test plan

A future implementation proposal must include, at minimum:

| Test family | Required synthetic assertions |
|---|---|
| Authentication lifecycle | unauthenticated denial, verified/unverified state, session expiry, explicit revocation, account closure and recovery response non-enumeration |
| Authorization matrix | each role × action × resource scope allow/deny matrix; deny unknown roles, actions and scopes |
| Horizontal access | account A cannot read/change account B's private profile, review draft, report or appeal |
| Vertical escalation | registered user/provider representative cannot call reviewer, publisher, moderator or administrator actions |
| Separation of duties | submitter cannot self-review/self-publish; moderator cannot alter institution facts; provider cannot delete criticism |
| Role changes | grant/revoke takes effect on the next request; stale session/cache does not retain removed authority |
| Abuse controls | bounded rate limits and deterministic handling for credential stuffing, duplicate submissions, spam and coordinated abuse |
| Moderation/appeals | reason required, notice recorded, appeal independent, reviewer/moderator audit retained, institution right-of-reply labelled |
| Privacy/minors | no public contact/location/account identifiers; sensitive values redacted from logs and errors; no direct adult-minor messaging surface |
| Deeni Madaris | zero public exposure in search, direct lookup, facets, counts, recommendations, sitemap, exports, caches and APIs when default-OFF |
| Regression | all existing I1-I8 governance, publication, provenance, source-authorization and anonymous-directory tests remain passing |

Tests must use fabricated accounts, roles, review text and institutions only. No real student, child, provider representative, credential, identity document or review content may be used. SQLite-only evidence must not be represented as proof of another database engine's row-lock semantics.

## 7. Decisions and evidence required before implementation or public activation

| Gate | Required owner/reviewer decision or evidence | Default while open |
|---|---|---|
| Identity method/provider | Protocol, session model, verification channel, recovery model, security support and data terms | No vendor/provider selected or activated |
| Account eligibility | Minimum age/age assurance, adult/guardian handling and account eligibility | No age-document collection; no public user-generated content |
| Review eligibility | Whether any account may review or whether experience evidence is required; acceptable evidence and privacy limits | No “verified student” claims; review feature disabled |
| Review rubric | Dimensions, scale, target entity, period/context, missing/disputed handling and anti-manipulation | No rating aggregate or score |
| Publication thresholds | Minimum sample, aggregation rules, suppression and recalculation | No public review aggregates |
| Moderation operations | Named qualified moderator coverage, escalation owner, service levels, conflict handling and appeal independence | No live review collection |
| Retention and deletion | Per-data-class purpose, retention, deletion, legal hold and audit exceptions | No arbitrary retention period invented |
| Legal/privacy/safeguarding | Qualified review of Pakistan and any applicable foreign obligations, minors, consent, notices, data transfers and escalation | No compliance claim; public UGC remains disabled |
| Cost/capacity | Email/SMS, identity, security and moderation operating costs; owner-approved spend ceiling | No new spend |
| Production readiness | Independent security review, incident response, recovery, monitoring and explicit release approval | No production access, deployment or launch |

Gates are conjunctive where applicable. A passing synthetic suite cannot replace qualified legal/privacy/security review, human moderation staffing or owner activation approval.

## 8. Explicit exclusions and stop conditions

This preflight does not authorize:
- application/runtime code, migrations, schema, database creation or persistence changes;
- authentication, account registration, sign-in, review or moderation endpoints/UI;
- review collection, rating publication, participant research, surveys, interviews, recruitment or outreach;
- real student/child/provider/person data or identity documents;
- identity, email, SMS, moderation, analytics or security vendors and external APIs;
- legal opinions, certification or claims of statutory compliance;
- source access, AI/model/provider activation, connectors or schedulers;
- production/V1/Hostinger/hPanel/SSH/live database access;
- deployment, public release, URL cutover, procurement or new spend.

Stop and seek separate authorization if implementation reveals a schema change, new dependency/provider, data collection, external service, legal decision, production dependency or change to an accepted M1/M2 invariant. Do not weaken a test or silently choose an unresolved policy to make implementation pass.

## 9. Preflight disposition and next gate

**Preflight status: COMPLETE.** The current repository is a public, anonymous directory foundation with no conventional Laravel user model/auth configuration/users migration or API route found at the inspected paths. M3-08 therefore begins as a new identity/authorization capability, not as a review feature layered onto existing accounts.

**Implementation status: NOT AUTHORIZED.** The next decision is a separate Product Owner authorization for a precisely bounded M3-08A/B implementation package, after the owner resolves the identity method and minimum account-policy inputs. M3-08C/D user-generated-content and safeguarding activation remains separately gated; reviews stay post-launch only.

M3-09 quality/operational hardening, M3-10 pilot readiness and M3-11 production launch remain future steps with their own dependencies and approvals. No M3-08 preflight result authorizes them.
