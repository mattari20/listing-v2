# ADM-G — Administration Queue and Operational Handoff Integration

**Date:** 2026-11-21  
**Baseline main:** `be95a411862e795072c107708c2867d904ef5bb9`  
**Status:** Implementation and synthetic regression tests added; exact-head CI pending.

## 1. Purpose

ADM-G closes the remaining role-scoped workspace integration gaps after ADM-E. It does not add new roles, permissions, editorial outcomes, adjudication, publication or direct catalogue editing.

## 2. Confirmed source gaps

- Representative submissions were filtered to direct institution entity IDs, omitting campus and delivery-site child cases.
- Reviewer queue showed only `submitted` cases and omitted `in_review` cases assigned to the current reviewer.
- Queue scope was not presented as a unified parent institution worklist for child-entity cases.
- Workspace entries showed raw workflow status but did not explain the next action for submitters or reviewers.

## 3. Implemented changes

### Parent-scoped case resolution
- Representative and reviewer queues now include institution cases and campus/delivery-site cases whose submitted `institution_entity_id` is in the user's eligible university institution scopes.
- If a campus/delivery-site projection exists, its persisted parent must agree with the submitted claim value. A mismatch fails closed.
- Child records display their own entity label and parent institution; case links use the parent institution route, where the existing server-side scope check is repeated.

### Reviewer queue ownership
- New `submitted` cases remain eligible for scoped reviewers, excluding self-submitted cases and cases where the reviewer registered linked evidence.
- `in_review` cases appear only when `reviewer_actor_id` exactly matches the current reviewer.
- Cases assigned to another reviewer are not surfaced.
- Existing case-detail authorization continues to enforce assignment and parent scope.

### Role-specific next-action guidance
- Representative status guidance distinguishes correction/resubmission, successor submitted, awaiting review, under review, separate adjudication, held and withdrawn states.
- Reviewer guidance distinguishes starting a new review from continuing the review assigned to that reviewer.
- Guidance is derived from persisted workflow state and is informational; it does not perform a workflow action or imply acceptance/publication.

### Accessibility and privacy
- Existing private/no-store, noindex, authentication, active assignment, exact scope and evidence-contributor restrictions remain.
- English and Urdu labels, RTL behavior, semantic headings, keyboard navigation and visible focus remain in place.
- No evidence body, source URL, private actor identifier or raw audit metadata is added to the queue.

## 4. Synthetic regression coverage added

- Campus and delivery-site child cases appear only under their exact assigned university parent.
- A persisted child projection whose parent disagrees with the submitted parent claim is excluded.
- A reviewer sees new submissions and only their own assigned in-review cases.
- An in-review case assigned to another reviewer is excluded.
- Representatives see their own returned campus correction and the correct next action, not another institution's child case.
- Existing self-submission, evidence-contributor, assignment-expiry, role-scope and privacy tests remain.

## 5. Acceptance and verification

1. Exact institution parent scoping for direct and child-entity cases.
2. Fail-closed mismatch behavior between proposed parent and materialized parent.
3. Assigned-only in-review queue visibility.
4. Continued exclusion of submitters and evidence contributors from review.
5. Correct role-specific next-action wording in English and Urdu.
6. Private/no-store/noindex and existing route authorization invariants unchanged.
7. Exact-head FND-01 PHP 8.5 Foundation CI and Project documentation validation pass.

**Current verification:** Project documentation validation passed on an earlier head; FND-01 previously stopped at Pint due to a PHP namespace parse error in the new ADM-F test class. That test file was corrected. A fresh exact-head CI result is pending. No pass is claimed until the corrected head completes.

## 6. Scope and exclusions

Synthetic fixtures and repository/GitHub CI only. No real/source/personal data, external APIs/AI, new dependencies, migrations, new roles/capabilities/routes, production/V1/Hostinger/hosted access, live database operations, deployment, pilot, public release or new spend. Adjudication and publication remain separate. Deeni Madaris remains default-OFF.

**Disposition:** ADM-G implementation is present; closeout remains conditional on exact-head CI and review. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
