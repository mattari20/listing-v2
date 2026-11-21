# ADM-E-G01 — Decision-Time Evidence Authorization Recheck Closeout

**Date:** 2026-11-21  
**Status:** **COMPLETE — MERGED, SYNTHETIC-ONLY DECISION-TIME GUARD**  
**Implementation PR:** [#425](https://github.com/mattari20/listing-v2/pull/425)  
**Merge commit:** `cb896552d7a16af8fa0af6a5ddaa368584356cee`  
**Final tested head:** `98f68b7780758561165a296d48f3f9f6de931daf`

## Delivered

The accepted adjudication path now rechecks every linked evidence reference against its source authorization at decision time. Before an `accepted` decision is persisted, each linked reference must:

- Have an admissible evidence status.
- Be explicitly marked synthetic.
- Resolve to an existing source authorization.
- Have a bounded `valid_from` and `valid_to` window.
- Have authorization status `approved_for_defined_purpose_and_method`.
- Have no revocation timestamp.
- Permit the `processing` action.
- Permit the established synthetic processing context: purpose `synthetic_test_only`, method `fixture_reference`, territory `synthetic`.

The guard uses the existing `GovernancePolicy::authorizeSourceAction` logic, so status, revocation, validity-window, action-scope, purpose, method and territory checks are centralized rather than reimplemented.

A missing authorization relation fails closed because the evidence/authorization join cannot produce an admissible linked reference; empty evidence also fails the existing admissibility check. Incomplete purpose/method/scope data fails the policy check. A missing validity boundary fails before policy evaluation.

The check runs before decision insertion, adjudication-case closure or claim-version disposition update. Regression tests verify that expired authorization rejection leaves the adjudication case open, no decision persisted, and the claim version still proposed.

## Synthetic regression coverage

Added coverage for:
- Current, bounded and correctly scoped synthetic authorization succeeds.
- Expired authorization is rejected with no decision or claim-state mutation.
- Revoked authorization is rejected.
- Processing scope denied is rejected.
- Incomplete purpose/method authorization context is rejected.
- Unbounded authorization is rejected.

Existing synthetic fixtures and local/private preview seeders were aligned to declare explicit bounded synthetic processing and publication scopes. This is fixture alignment, not production data or a migration.

## Validation

On exact head `98f68b7780758561165a296d48f3f9f6de931daf`:
- PHP 8.5 Foundation CI: **success**.
- Project documentation validation: **success**.
- PHP formatting: **success**.
- Laravel bootstrap and route validation: **success**.
- Synthetic-only suite: **23 passed, 1,805 assertions, 314 warnings**.
- Repository artifact hygiene: **success**.

Warnings remain and are not considered resolved by this agenda item.

## Important scope limitation

The current evidence-reference schema does not persist a per-reference purpose/method/territory context. This implementation therefore deliberately permits accepted adjudication only for the already-established synthetic fixture context. It does not invent or infer authorization context for real-source evidence and does not establish readiness for real-source processing.

A future real-source workflow would require a separately authorized design for capturing, validating and retaining the exact provenance context. No migration or schema change is included here.

## Exclusions and disposition

No new route, UI, role, capability, field definition, migration, source collection, real/source/personal data, V1/Hostinger/production/hosted access, external AI/API, deployment, pilot, release, dependency or spend was introduced. Adjudication and publication remain separately governed and are not exposed in the administration workspace.

**ADM-E-G01: CLOSED for the synthetic-only repository implementation and regression evidence.** ADM-E remains IN PROGRESS: G02 correction handoff, G03 accepted-projection non-mutation matrix and G04 reviewer-safe evidence/history verification remain open. No M3 gate is promoted; M3-11 remains BLOCKED / NOT ACCEPTED and overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
