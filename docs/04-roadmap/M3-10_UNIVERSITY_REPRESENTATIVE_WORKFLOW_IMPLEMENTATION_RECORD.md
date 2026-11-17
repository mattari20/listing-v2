# M3-10 — University Representative Workflow Implementation Record

**Repository:** `mattari20/listing-v2`  
**Baseline:** `e5e161e2dc287fa42892f9014d0f98706c4658d5`  
**Scope:** owner-authorized, synthetic-only local/CI application implementation  
**Status:** implementation candidate; exact-head CI and PR review pending

## 1. Authorization and boundary

This implementation follows the separate owner authorization for the missing university representative workflow. It is restricted to V2 code and synthetic fixtures. It does not access V1, production, Hostinger/hPanel, hosted environments, live databases, external sources, APIs, connectors, AI/model services or real institution/student/staff data. It adds no dependency, vendor, procurement or spend.

The implementation does not authorize or conduct participant research, a pilot, public launch, public UGC, ratings, reviews, reporting or public moderation. Deeni Madaris remains default-OFF with no new route or exposure. The existing M3-10 pilot readiness disposition remains NOT ACCEPTED; M3-11 remains NOT AUTHORIZED.

## 2. Delivered HTTP surface

All endpoints are authenticated web-session routes, throttled, and constrained to UUID route identifiers:

| Method and path | Purpose | Required scoped capability |
|---|---|---|
| POST `/institutions/{institution}/claims` | Submit an institution field proposal | `institution.claim.submit` |
| POST `/institutions/{institution}/claims/{claimVersion}/correction` | Correct a proposal returned for changes | `institution.claim.correct` |
| POST `/institutions/{institution}/editorial-cases/{case}/review` | Start independent editorial review | `claim.review` |
| PATCH `/institutions/{institution}/editorial-cases/{case}/review` | Complete the assigned review | `claim.review` |

The controller verifies that the resource is an institution whose human-governed category is exactly `university`. It does not infer category from a label. Accounts must be active and email-verified.

## 3. Authorization and separation of duties

- A new `institution_representative` role is scoped to one exact `institution` resource ID and receives only submit/correct actions.
- The role is incompatible with provider representative, data reviewer, publisher, moderator and service identity roles under the existing role-grant separation-of-duties policy.
- Reviewers use the existing `data_reviewer` role scoped to the same institution. A representative role does not imply reviewer access.
- The editorial service enforces that the reviewer is distinct from the submitter and evidence actors, and only the assigned reviewer may complete the review.
- A correction endpoint is available only for the original submitter's case after a reviewer records `changes_requested`. The predecessor remains immutable; a new successor version is created, a new review case is submitted, and the old editorial case is audited as superseded.
- All actor IDs are derived from the authenticated account. Caller-supplied actor identity, capabilities, scope, source context and publication settings are not accepted.

## 4. Synthetic-only data and publication boundary

The controller injects a fixed source context:
- purpose: `synthetic_test_only`
- method: `fixture_reference`
- territory: `synthetic`

The existing field-aware proposal/correction services continue to enforce exact active field-definition version binding, typed validation, institution scope, eligible metadata-only synthetic evidence, source-authorization scope and idempotency. Evidence IDs supplied by a caller are not trusted merely because they are UUIDs.

No adjudication or publication HTTP endpoint is added. Submission/correction stops in editorial review or at the adjudication handoff. The workflow creates no public projection or publication decision. Existing public directory routes remain read-only.

## 5. Synthetic HTTP test coverage

The new feature suite covers:
- unauthenticated, unverified and unscoped representative denial;
- exact institution-scope enforcement and university-category restriction;
- successful synthetic proposal submission and absence of publication/public projections;
- correction only after an independent reviewer requests changes;
- immutable predecessor and successor version binding;
- superseding the returned editorial case and creating a new submitted case;
- idempotent correction retry without duplicate versions or review cases;
- separately scoped reviewer access, wrong-institution/case denial and self-review denial;
- role-grant support for the new representative role.

Existing service-level tests continue to cover field registry, evidence, correction, editorial lifecycle, role authorization and separation-of-duties behavior.

## 6. Files changed

- `app/Authorization/ScopedAuthorization.php`
- `app/Http/Controllers/UniversityRepresentativeWorkflowController.php`
- `app/Services/Directory/UniversityRepresentativeWorkflowService.php`
- `app/Services/Directory/EditorialReviewService.php`
- `app/Services/Identity/RoleAssignmentService.php`
- `routes/web.php`
- `tests/Feature/UniversityRepresentativeWorkflowTest.php`
- `tests/Feature/ModerationPrivacyBoundaryTest.php` — preserves the no-public-review rule while asserting internal editorial review routes require authentication.
- `docs/05-architecture/README.md`

No migration or dependency change is included.

## 7. Validation and acceptance

Exact-head PHP 8.5 FND-01 foundation CI and Project documentation validation are required before merge. This record does not claim tests passed before those runs complete.

Acceptance requires:
1. Exact-head PHP 8.5 foundation CI success, including synthetic feature tests, formatting, bootstrap/routes and artifact hygiene.
2. Exact-head documentation validation success.
3. No unresolved review blockers and an exact-head guarded merge.
4. Post-merge verification of the merged commit and documentation presence.

A green CI result validates the bounded synthetic implementation only. It is not a pilot go/no-go, legal/privacy/security/accessibility approval, human-operations acceptance, production readiness or launch authorization.
