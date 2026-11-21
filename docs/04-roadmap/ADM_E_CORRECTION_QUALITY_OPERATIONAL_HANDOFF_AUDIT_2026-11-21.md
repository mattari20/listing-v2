# ADM-E — Correction, Quality and Operational Handoff Audit

**Date:** 2026-11-21  
**Baseline main:** `4549f879532c53492a14fc09446bad0a6824778a` (PR #422)  
**Agenda:** Administration and Institute Information Management Completion  
**Status:** Source audit complete; implementation scope defined. No application behavior changed by this audit.

## 1. Purpose and audit method

This agenda audits the merged ADM-A through ADM-D workflow against the end-to-end path from institution/campus/delivery-site proposal, through evidence-backed submission and independent review, requested correction, immutable successor submission, accepted catalogue projection and operational handoff.

The audit used the current-main source for:
- `routes/web.php`
- `AdministrationWorkspaceController` and `AdministrationWorkspaceQueryService`
- `UniversityRepresentativeWorkflowController` and `UniversityRepresentativeWorkflowService`
- `InstitutionCampusWorkflowController`
- `EditorialCaseWorkspaceController`
- `EditorialReviewService` and `FieldAwareClaimCorrectionService`
- `workspace.index` and `workspace.case` views
- `AdministrationWorkspaceTest`, `UniversityRepresentativeWorkflowTest` and `InstitutionCampusWorkflowTest`

This is a focused source/contract audit, not an exhaustive security review, independent assessment, runtime test, browser test or operational acceptance.

## 2. End-to-end capabilities already present

### Submission and correction
- Institution representative submission is authenticated, active/verified-human and exact-institution scoped.
- Campus/delivery-site identity and proposal creation are transactional; parent institution identity is derived from the authorized route and client-supplied parent identity is prohibited.
- Evidence references, exact active field-definition versions, applicability, validity dates and bounded idempotency are required by the proposal services.
- A returned proposal can be corrected by its original submitter into an immutable successor claim version and resubmitted for editorial review.
- Campus/delivery-site correction scope is checked against the exact parent institution relationship.

### Independent editorial review
- Review start excludes the submitter and evidence contributors.
- Review completion is limited to the assigned reviewer and supported outcomes: `ready_for_adjudication`, `changes_requested` and `held`.
- Review status transitions are recorded in status history and audit events.
- The reviewer case page exposes evidence-reference metadata and authorization-window state, not evidence bodies, documents, source URLs, integrity digests, private actor IDs or arbitrary audit metadata.
- Case detail supports campus/delivery-site parent institution scope when accessed through the authorized institution route.

### Accepted projection
- Campus/delivery-site accepted projection materialization requires an exact currently materialized predecessor version and preserves the parent institution relationship.
- The institution information endpoint returns accepted current campus and delivery-site projections only.
- No direct catalogue-table editing route was identified in the audited workspace.

## 3. Confirmed integration gaps

| ID | Finding | Evidence in current source | Required disposition |
|---|---|---|---|
| ADM-E-01 | Reviewer queue only selects cases whose `entity_id` is one of the assigned institution IDs. | `AdministrationWorkspaceQueryService::reviewQueue` filters `cases.entity_id` with `whereIn` against institution IDs. | Include campus/delivery-site child cases only through their exact parent institution relationship. |
| ADM-E-02 | Reviewer queue lists only `submitted` cases. Assigned `in_review` work is not surfaced in the landing queue. | `reviewQueue` filters `cases.status = submitted`; case detail separately permits the assigned reviewer to inspect an `in_review` case. | Add an assigned-review worklist without exposing another reviewer's cases. |
| ADM-E-03 | Representative submissions are limited to direct institution entity IDs and do not provide a dedicated returned-correction handoff. | `representativeSubmissions` filters direct `cases.entity_id` values and the view renders a read-only list. | Surface the original submitter's `changes_requested` cases and successor submissions for institution/campus/delivery-site scope. |
| ADM-E-04 | Evidence quality is visible as individual reference status and authorization-window labels, but no bounded case-level quality summary or next-action guidance exists. | `editorialCaseDetails` computes per-reference authorization state; the view renders rows without a summarized quality state. | Add transparent warnings for missing references, ineligible evidence status, revoked/not-approved/expired/not-yet-valid/unbounded/invalid authorization windows. Do not label a case verified. |
| ADM-E-05 | Review completion checks assignment and workflow state but does not itself re-evaluate evidence quality at completion time. | `EditorialReviewService::completeReview` checks `in_review` and assigned reviewer before recording the supported outcome. | Define an explicit policy for warnings versus blocking conditions before changing transition behavior; do not silently add a new approval rule. |
| ADM-E-06 | Operational handoff is distributed across status history and APIs rather than presented as a unified next-action/status view. | Representative and reviewer modules are separate; the case view shows history but not an actionable handoff summary. | Add a read-only, role-scoped next-action summary derived from persisted status and assignment. |

## 4. ADM-E implementation contract

The next implementation increment may:
1. Extend representative and reviewer queues to include campus/delivery-site child entities only when the stored parent relationship matches the exact assigned university institution.
2. Surface cases currently assigned to the reviewer, while continuing to exclude self-submitted and evidence-contributor cases.
3. Add a returned-corrections view for the original submitter, including immutable predecessor/successor references and the new editorial case status.
4. Add a case-level evidence-quality summary with explicit non-verification wording and per-reference warnings.
5. Present next-action guidance derived from workflow status (submitter correction, assigned reviewer action, or separate adjudication/publication stage).
6. Preserve English/Urdu labels, RTL, keyboard access, private/no-store headers and noindex behavior.
7. Add synthetic feature tests for parent-scope isolation, queue ownership, reviewer assignment, correction lineage, quality warnings, privacy minimization and no-publication invariants.

## 5. Policy decisions and safeguards

- Evidence-quality indicators are descriptive workflow signals, not independent verification, source approval or legal conclusions.
- A missing, expired, revoked, unbounded or otherwise non-current authorization state must be visible as a warning. It must not be represented as current or verified.
- Whether a quality warning blocks a review outcome is a separate explicit policy decision; this audit does not change `EditorialReviewService::completeReview`.
- A correction always creates a successor version; prior versions and history are not overwritten.
- Only the original submitter may correct a returned proposal. Only the assigned independent reviewer may complete an in-review case.
- Adjudication, publication approval, suppression, restoration, role management and direct catalogue editing remain separate capabilities with their own authorization and separation-of-duties requirements.
- Current provider-category scope remains university-only. School, college, academy, coaching and other provider-category workflows are future work.
- Field-definition creation/activation remains separately governed and is not part of ADM-E.

## 6. Explicit exclusions

Synthetic fixtures and repository/GitHub CI only. No real institution, student, guardian, staff, provider or source data; no source retrieval or scraping; no external API, AI/model, connector or telemetry; no database migration or field-definition activation; no V1, Hostinger, hPanel, production or hosted environment access; no deployment, pilot, public activation, new dependency, paid service or additional spend. Deeni Madaris remains default-OFF with zero public exposure. Public UGC, complaints, appeals and moderation remain disabled.

## 7. Acceptance criteria for the implementation increment

1. Assigned university reviewers see only eligible direct and child-entity cases in their exact institution scopes.
2. A reviewer sees an in-review case only when assigned to that case.
3. Submitters see only their own returned corrections and successor cases.
4. Campus/delivery-site child records cannot be reached through a different institution's scope.
5. Evidence warnings accurately distinguish current, expired, not-yet-valid, revoked, not-approved, unbounded and invalid authorization windows, plus missing/ineligible references.
6. UI wording never equates editorial review with adjudication, publication or verified truth.
7. Corrections preserve immutable predecessor/successor lineage and idempotent retry behavior.
8. No new direct-publish, direct-edit or administrator bypass exists.
9. Exact-head FND-01 Foundation CI and Project documentation validation pass; warnings are reported, not hidden.
10. Documentation and tests state that the scope is synthetic/repository-only and does not establish human staffing or operational readiness.

**Disposition:** ADM-E source audit and bounded implementation contract are complete. Implementation remains the next work item; no application code, tests, schema, permissions or runtime behavior changed in this audit. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
