# ADM-A — Administration Information Architecture and Authorization Decision

**Date:** 2026-11-21  
**Baseline:** `633e57a19622cebfc4560a2fa8c671eb3c910d32`  
**Agenda:** Administration and Institute Information Management Completion  
**Status:** Architecture decision and implementation boundary — repository-only.

## 1. Decision

Build a role-aware administration workspace by composing the existing scoped authorization, claim, evidence and editorial services. Do not create a second authorization system or a generic super-admin content editor.

The interface must make a user's permitted work discoverable while keeping each write guarded by server-side authorization and the existing service-layer workflow. Hiding a button is not authorization.

## 2. Existing role/action model

The current `ScopedAuthorization` maps the following role families:

| Role | Existing capabilities | Scope / limitation |
|---|---|---|
| `provider_representative` | `provider.claim.submit` | Exact provider scope |
| `institution_representative` | `institution.claim.submit`, `institution.claim.correct` | Exact institution scope |
| `data_reviewer` | `evidence.review`, `claim.review` | Exact assigned resource scope; independent review |
| `publisher` | `assertion.publish`, `institution.publish` | Publication authority only |
| `administrator` | `roles.manage`, `security.audit.read` | Global role management and security audit; not catalogue editing or publication |
| `moderator` | UGC moderation/appeal actions | Must remain dormant while public UGC is disabled |
| `service_identity` | None in the current map | No human administration capability |

The existing `RoleAssignmentService` has a separate grantable-role allowlist, exact-scope requirement, incompatible-role checks, audit records and self-grant/self-revocation prohibitions. Administrator grants are deliberately excluded from the ordinary service and require a separate controlled process.

## 3. Existing workflow service capabilities and unresolved mapping

`EditorialReviewService` exposes service operations for submit, review, adjudication, approve, suppress and restore. Its capability matrix uses the service-level capabilities:
- `submit_directory_proposal`
- `edit_directory_proposal`
- `review_directory_proposal`
- `adjudicate_claim`
- `authorize_publication`
- `suppress_publication`
- `restore_publication`

The current `ScopedAuthorization` role-action map does not explicitly map all these service capabilities. Existing controller code bridges a subset of role actions to service capability arrays for institution representatives and reviewers. The complete adjudication and publication route surface is not present in `routes/web.php`.

**ADM-A control:** do not expose adjudication, approve, suppress or restore UI actions until a reviewed server-side role/action mapping and route-level authorization contract exist. Do not infer authority from a service capability string supplied by the client.

## 4. Workspace information architecture

The authenticated workspace is a role-aware landing page with independent modules. It must only show modules for which the server has established an authorized capability and relevant exact resource scope.

| Workspace module | Intended user | Initial scope |
|---|---|---|
| My institution/provider submissions | Provider/institution representative | Own exact assigned provider/institution scope |
| Returned corrections | Original submitter | Only own proposal returned for changes |
| Evidence and editorial review queue | Data reviewer | Only assigned/reviewable exact cases |
| Publication queue | Publisher | Only cases eligible under separately mapped publication authority; initially withheld pending mapping |
| Role assignments and security audit | Administrator | Existing role-management/audit capabilities; no content write authority |
| Field-definition governance | Separately authorized governance roles | Withheld until its capability mapping and route contract are reconciled |

## 5. Route and controller design constraints

- Keep all workspace routes behind authenticated, active, verified-human checks where applicable.
- Resolve the actor from the authenticated server-side user; never accept actor identity or capability arrays from request payloads.
- Resolve exact role assignment and resource scope on every read and write.
- Apply throttling and CSRF protection to state-changing browser routes.
- Use Form Requests or equivalent centralized validation for bounded input, evidence IDs, validity dates, reason codes and idempotency keys.
- Controllers orchestrate and render; domain services remain responsible for state transitions and transactional invariants.
- Do not add a generic CRUD endpoint that writes directly to catalogue tables.
- Cross-institution and cross-provider access must fail closed.
- The UI must show status, validation errors, evidence references, rationale, effective dates and immutable history without exposing restricted data.

## 6. Separation of duties

- Submitters cannot review their own proposal or evidence.
- Reviewers cannot adjudicate their own submissions or evidence.
- Adjudicators must be distinct from submitter and reviewer.
- Publishers act only after the accepted review/adjudication sequence and under explicit publication authorization.
- Global administrators do not gain content publication powers through the dashboard.
- Role changes remain audited and governed by the existing controlled grant/revoke service.
- Moderator and UGC workflows remain disabled; no public reviews, complaints, appeals or user-generated content are introduced.

## 7. Bilingual and usability requirements

- English and Urdu labels, validation messages and status names.
- Correct RTL layout and logical focus order.
- Responsive keyboard-accessible forms and queues.
- Clear distinction between draft/proposed, submitted, in review, changes requested, held, ready for adjudication, adjudicated, published, suppressed and restored states where the relevant state is supported.
- Missing or unapproved information must not be presented as verified facts.

## 8. ADM-A acceptance criteria

1. One documented role/action/resource matrix is the source for workspace visibility and server-side authorization.
2. Existing role scope and separation-of-duties protections are preserved.
3. No administrator content-publishing bypass is introduced.
4. No adjudication or publication UI is exposed before missing capability mappings and route contracts are implemented and tested.
5. No direct table writes bypass existing domain services.
6. Cross-scope access, expired/revoked role assignments, inactive/unverified users and self-review are denied.
7. English/Urdu and RTL requirements are part of each UI agenda.
8. All implementation and tests use synthetic fixtures only.

## 9. Next agenda

**ADM-B — Role-aware workspace shell and read-only queues.** Implement the shared authenticated layout and server-derived navigation for already-mapped capabilities. Add read-only views for authorized representative submissions and reviewer queues only where safe query scope is established. Do not yet expose adjudication/publication actions. Include authorization and synthetic feature tests.

ADM-C through ADM-E will add governed editing, evidence/review, adjudication/publication only after the action mapping gaps are resolved.

## 10. Explicit exclusions

No production/V1/Hostinger/hosted access, live database, real institute/student/source/personal data, external AI/API, deployment, pilot, release, new spend, paid service or unnecessary dependency. Deeni Madaris remains default-OFF with zero public exposure. Public UGC remains disabled.

**Disposition:** ADM-A architecture decision complete for repository planning. No application behavior or role permissions changed by this document. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
