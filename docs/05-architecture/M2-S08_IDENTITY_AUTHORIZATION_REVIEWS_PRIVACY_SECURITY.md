# M2-S08 — Identity, Authorization, Reviews, Privacy and Security Architecture

**Status:** Architecture design draft; technology/vendor-neutral.  
**Scope:** Documentation only.  
**M2 weight:** 10%.

## 1. Objectives and security posture
Define identity, role/action authorization, review integrity, moderation, privacy, safeguarding and security boundaries for a student-facing education discovery service. Apply least privilege, data minimization, secure defaults, separation of duties, privacy by design, accessible recovery and auditable privileged actions.

No identity vendor, authentication protocol implementation, moderation provider or security product is selected.

## 2. User and service identity classes
- Anonymous visitor: public search, browse, profiles and comparisons; no account required for core discovery.
- Registered user: account profile and permitted post-launch review functions.
- Provider representative: may submit correction/evidence requests; does not directly publish or edit authoritative facts.
- Content/data reviewer: evaluates evidence and proposed assertions within assigned scope.
- Publisher/adjudicator: approves high-impact facts and publication decisions; separate from AI proposal generation.
- Moderator: reviews user-generated content and appeals; cannot alter institutional facts without a separate evidence workflow.
- Administrator: manages configuration and access; privileged actions are logged and periodically reviewed.
- Service identity: narrow non-human identity for a future approved workload; no shared human credentials.

Identity proofing strength must be proportionate to action risk. Login confirms control of an account, not student status, attendance, institutional affiliation or review authenticity.

## 3. Authentication and account lifecycle
Future implementation must support secure sign-in, verification, session expiry/revocation, recovery, account closure, credential rotation and abuse-resistant rate limits. Prefer standards-based authentication and phishing-resistant options where practical; final protocol/provider decision is deferred to M3 after S04 stack/team evaluation.

Do not require an account for anonymous discovery. Collect only data necessary for the selected account function. Avoid public exposure of email, phone, legal name, precise birth date or account identifiers. Account recovery must not disclose whether an account exists and must resist takeover.

## 4. Authorization model
Use role-based permissions with resource scope and action-level policy checks (RBAC plus contextual constraints where needed). Deny by default. Every privileged action must be checked server-side; hiding a UI control is not authorization.

| Role | Allowed actions | Explicitly prohibited |
|---|---|---|
| Anonymous | Public eligible search/profile/compare | Private data, submission, admin |
| Registered user | Manage own account; submit/edit own eligible review | Publish facts, moderate own case, impersonate |
| Provider representative | Submit correction/evidence request for verified scope | Directly overwrite facts or approve own submission |
| Data reviewer | Inspect assigned evidence; propose adjudication | Change source rights or publish without grant |
| Publisher | Approve eligible assertions/publication within scope | Alter audit history; self-approve own high-impact evidence |
| Moderator | Hide/restore user-generated content; handle reports | Change factual provider data |
| Administrator | Manage roles/configuration with step-up controls | Unlogged access, unrestricted content editing |
| Service identity | Explicitly allowlisted workload actions | Interactive login, broad admin, human role inheritance |

Separate duties for source authorization, evidence review, publication, moderation and role administration. Require step-up authentication for sensitive actions if supported by the selected identity design. Permission grants are scoped, time-bounded where practical, reviewed and revoked on role change.

## 5. Reviews, ratings and moderation
Reviews/ratings are post-launch features. No pre-launch review collection or participant research is authorized. A user must authenticate to submit; authentication is not proof of attendance or verified student status.

Design requirements:
- clear review target (provider, campus, programme or service) and review period/context;
- disclose review eligibility basis and do not label a review “verified” without defensible verification;
- prevent duplicate/spam campaigns, brigading, coercion, impersonation and conflicts of interest;
- separate ratings from sponsored placements and institutional self-submissions;
- moderation reasons, user notice, appeal/reconsideration and reviewer/moderator audit;
- preserve evidence for abuse decisions while applying retention and privacy limits;
- allow report, hide, restore and correction workflows; avoid silent edits to user-authored content;
- publish aggregate scores only with minimum sample and anti-manipulation rules determined by evidence and owner decision.

Provider responses must be labelled as provider responses and cannot suppress legitimate criticism. Paid status must never improve organic rating or hide negative reviews.

## 6. Privacy, minors and safeguarding
The platform serves students and may be used by minors. Default to anonymous discovery and minimal account data. Do not collect precise date of birth, school attendance, identity documents, geolocation history or sensitive personal details without a documented necessity and separate approval.

Controls:
- privacy notice and purpose limitation at collection points;
- age-appropriate language and safe defaults; avoid direct messaging between adults and minors in the initial scope;
- no public profiles exposing a minor's identity/contact/location;
- no behavioral advertising/profiling design for minors in M2;
- location permission is optional; manual locality selection remains available; precise device location is not stored by default;
- review prompts discourage disclosure of names, phone numbers, schedules, health, religion, sect or other sensitive personal details;
- moderation escalation for threats, exploitation, doxxing, self-harm or imminent safety concerns with documented handling and legal review;
- retention schedule by data class and purpose; deletion/withdrawal paths, legal hold and audit exceptions documented;
- privacy impact and child-safeguarding review before launch.

No conclusion is made here about the applicability or status of any particular Pakistani or foreign privacy statute. Obtain qualified legal review of the actual operating model, hosting, user age groups, data flows and provider contracts before launch.

## 7. Deeni Madaris invariant
V2-DEC-006 remains binding. Show Deeni Madaris defaults OFF. When OFF, suppress their records from public search, direct identifier lookups, browse, recommendations, map pins, facets, counts, sitemap, exports, caches and public APIs. Internal restricted provider/evidence administration is separate and role-gated. No sect/maslak discovery filters or inference. Configuration changes require authorized approval, audit, preview, negative-test pass and controlled cache/index invalidation.

## 8. Threat model and controls
| Threat | Required control |
|---|---|
| Account takeover / credential stuffing | Secure auth, rate limits, anomaly signals, recovery protections |
| Privilege escalation / IDOR | Server-side resource/action authorization; deny-by-default tests |
| Insider misuse | Least privilege, separation of duties, immutable audit, periodic access review |
| Fake reviews / brigading | Abuse detection, rate limits, duplicate signals, moderation and appeal |
| Provider self-dealing | Scoped representative role; no self-approval or direct publication |
| Minor privacy exposure | Anonymous-first design, data minimization, no public contact/location, safeguarding |
| Prompt injection / malicious source | S07 quarantine, tool isolation, no model privileges |
| Data breach / secret leakage | Encryption design, secret management, redacted logs, incident response |
| Deeni Madaris leakage | Platform-wide negative tests, fail-closed publication/query filters |
| Admin/config abuse | Step-up, dual control for high-impact config, audit and rollback |

## 9. Security validation requirements
Before launch, test authentication and recovery abuse; authorization matrix and cross-account access; role changes and revocation; session invalidation; review manipulation; moderation/appeals; privacy leakage through logs/search/cache/export; location denial; minor safeguarding; Deeni Madaris zero-exposure; prompt-injection and connector isolation; incident response and backup restoration.

Conduct independent security review/penetration testing before public launch. Findings must be triaged with severity, owner, remediation and retest evidence. No security certification or legal compliance claim is made.

## 10. Completion status and deferred decisions
S08 task plan: T01 identity, T02 authorization, T03 reviews/moderation, T04 privacy/minors/safeguarding and T05 security validation. **Draft completion: T01-T04 complete (80%); T05 validation/consistency review pending.** Identity vendor/protocol, exact age assurance, legal obligations, review eligibility, minimum aggregate sample and moderation staffing require evidence and owner/legal decision. No implementation or user-data collection is authorized.
