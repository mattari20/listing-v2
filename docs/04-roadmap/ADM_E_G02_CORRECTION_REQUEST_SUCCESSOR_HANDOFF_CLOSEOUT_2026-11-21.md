# ADM-E-G02 — Correction Request and Successor Handoff Closeout

**Date:** 2026-11-21  
**Status:** **COMPLETE — MERGED, SYNTHETIC REPOSITORY WORKFLOW**  
**Implementation PR:** [#427](https://github.com/mattari20/listing-v2/pull/427)  
**Merge commit:** `781559d2174d216864f8d83a7b93bbe9ff131fbc`  
**Final tested head:** `1899d4485995a23dc62e26390a2be5d4e3bce392`

## Delivered

The general `EditorialReviewService::correctProposal` path now executes as one database transaction across:
1. Verification that the original submitter is correcting a case in `changes_requested` (or an exact retry of its already-superseded state).
2. Creation of an immutable successor claim version using the existing correction/idempotency contract.
3. Submission of that successor as a new editorial review case.
4. Supersession of the predecessor editorial case with an explicit successor claim-version reference in status history.

The transaction prevents a failed successor submission or predecessor supersession from leaving an orphan successor claim version or partially transitioned predecessor case.

The method accepts a `superseded` predecessor only to permit retry of the same exact correction workflow. Replaying the same correction and submission idempotency keys returns the same successor case. Changed payload under the same correction key is rejected by the existing immutable correction fingerprint. A different submission key cannot silently create a duplicate successor case because predecessor supersession and the outer transaction reject and roll back that attempt.

## Correction request traceability

The reviewer’s `changes_requested` event already records the reason code and rationale in `directory_status_history`. The new tests verify that the rationale remains attached to the predecessor case. Supersession history records the exact `successor_claim_version_id`; the successor case is independently submitted and can re-enter review.

No new free-form or public intake channel was added. Existing reason/rationale fields remain the governed correction instruction mechanism.

## Synthetic regression coverage

Added feature coverage for:
- Reviewer correction rationale stored against the predecessor case.
- Failed successor submission rolls back the new claim version, audit event and predecessor transition.
- Successful correction creates an immutable successor and a new submitted editorial case.
- Predecessor case moves to `superseded` and records exact successor version ID.
- Same-command retry returns the same successor case without duplicate claim versions or editorial cases.
- Changed correction payload under the same idempotency key is rejected.
- Successor case can re-enter independent review and reach `ready_for_adjudication`.
- Correction before a reviewer requests changes is rejected.
- A different submitter cannot correct another actor's returned proposal.

## Validation

On exact head `1899d4485995a23dc62e26390a2be5d4e3bce392`:
- PHP 8.5 Foundation CI: **success**.
- Project documentation validation: **success**.
- PHP formatting and Laravel route validation: **success**.
- Synthetic-only suite: **23 passed, 1,822 assertions, 316 warnings**.
- Repository artifact hygiene: **success**.

Warnings remain and are not considered resolved by G02.

## Scope and exclusions

No route, role, capability, schema, migration, adjudication/publication UI, public complaint/appeal intake or catalogue write path was added. No real/source/personal data, V1/Hostinger/production/hosted access, external API/AI, deployment, pilot, release, new dependency or spend was used.

**ADM-E-G02: CLOSED for the synthetic repository correction and successor-handoff workflow.** G03 accepted-projection non-mutation matrix and G04 reviewer-safe evidence/history verification remain open. No M3 gate is promoted; M3-11 remains BLOCKED / NOT ACCEPTED and overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
