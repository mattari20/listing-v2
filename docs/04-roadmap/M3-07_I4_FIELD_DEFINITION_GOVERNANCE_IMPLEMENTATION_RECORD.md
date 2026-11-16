# M3-07 I4 — Field Definition Governance Lifecycle Implementation Record

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Branch:** `feature/m3-07-i4-field-definition-governance`  
**Authorization:** Explicit owner authorization received 2026-11-16 for the exact scope in the I4 proposal  
**Status:** Implementation prepared; exact-head validation pending

## 1. Authorized scope

I4 implements the bounded human-governed lifecycle for dynamic field definitions already persisted by I1. It is limited to:
- two additive field-definition review workflow tables;
- `FieldDefinitionGovernanceService`;
- human-only capabilities and proposer/reviewer/approver/activator separation;
- proposal, independent review, approval, separate activation, deprecation, retirement and restoration through a new version;
- transactional audit and identifier-only outbox events;
- synthetic-only feature tests and this implementation record.

No UI, public route/API, real role provisioning, claim-value changes, projection changes, live source access, model/provider, connectors, scheduler, production/V1/Hostinger, deployment or spend is included.

## 2. Implementation delivered on branch

| File | Change |
|---|---|
| `database/migrations/2026_11_16_000001_create_field_definition_review_workflows.php` | Adds `field_definition_review_cases` and append-only `field_definition_review_decisions`, with FK restrictions, unique idempotency keys and review indexes |
| `app/Services/Directory/FieldDefinitionGovernanceService.php` | Adds bounded definition validation and human-governed lifecycle commands |
| `app/Services/Governance/PersistedGovernanceWorkflowService.php` | Adds fail-closed integrity validation for I4 lifecycle outbox events; events are no-op checkpoints only |
| `tests/Feature/FieldDefinitionGovernanceTest.php` | Adds synthetic tests for schema, proposal, idempotency, actor separation, review, approval, activation, succession, retirement, restoration, outbox and rollback |

## 3. Lifecycle and controls

- A proposal creates a stable field identity if new, an immutable version row, explicit institution/provider applicability, a review case and an initial decision in one transaction.
- Stable field keys cannot be recycled. A successor must reference the latest version of the same key.
- Only the assigned human reviewer may review. Proposer cannot review or approve their own proposal.
- Approval requires an independent human distinct from proposer and reviewer. Activation is a separate command by a human distinct from proposer and approver.
- Only one active version per stable field key is permitted. Activation locks the parent field identity before checking the active version.
- Changes-requested edits are restricted to the original proposer while the version remains proposed; the stable key cannot change. The case is resubmitted and reviewer assignment is cleared.
- Deprecation effective boundaries are parsed and compared as date values; the future-effective fixture uses a normalized timestamp to avoid string/object comparison ambiguity.
- Approved semantic content cannot be edited through the service. Semantic changes require a successor version.
- Deprecation and retirement make a definition unavailable to I3's active-only reader. Retirement preserves all existing claims and claim-version history.
- Restoration creates a new monotonically numbered version and a new review case; it never reactivates a retired version in place.
- Every transition writes an append-only decision, audit event and identifier-only outbox event in the same transaction.
- The existing outbox processor validates event type, target version, review case, decision, actor and monotonic lifecycle progression. It does not create claims, retrieve sources, adjudicate, publish or modify projections.
- Restricted provider categories remain excluded from I4 applicability.

## 4. Synthetic acceptance coverage

The feature suite currently contains 17 I4 test methods covering:
- table and contract presence;
- atomic proposal, review-case, audit and outbox creation;
- command idempotency and changed-payload rejection;
- automated actor denial;
- duplicate key, invalid definition and restricted-category rejection;
- independent reviewer/approver/activator separation;
- changes-requested edit and resubmission;
- rejection and future-effective activation guard;
- one-active-version invariant and successor sequencing;
- claim history preservation and new-version restoration;
- outbox integrity failure and transactional rollback;
- deprecation and retirement.

The exact-head CI run will establish actual pass/fail and assertion totals. Any failure will be diagnosed and corrected only within this approved I4 scope.

## 5. Validation and merge evidence

Pending at record creation:
- Project documentation validation;
- PHP 8.5 FND-01 foundation CI;
- migration up/down on disposable CI SQLite;
- PHP formatting, dependency audit, Laravel bootstrap/routes, full synthetic suite and artifact hygiene;
- review-thread check and exact-head reconciliation.

Final run IDs, suite counts, warnings, merge SHA and acceptance status will be appended after exact-head CI/review.

## 6. Non-interference

No production/V1/Hostinger/hPanel, live database, real institution/provider/student/applicant/child/staff data, external source, model/provider, API, connector, crawler, scheduler, deployment or additional spend was accessed or used. The additive migration is tested only by the repository's disposable local/CI database workflow. I5-I7 remain separately gated.
