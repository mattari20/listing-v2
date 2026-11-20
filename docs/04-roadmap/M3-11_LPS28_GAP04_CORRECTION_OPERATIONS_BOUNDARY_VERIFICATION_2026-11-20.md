# M3-11 LPS-28 — GAP-04 Institute Correction Operations and Public Intake Boundary Verification

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `81a0fda532e65c7a73f4e0392e8dd943b0719830` (main after LPS-27 merge)  
**Agenda:** LPS-28 — GAP-04 correction operations boundary and synthetic verification  
**Status:** **EXISTING CORRECTION WORKFLOW RECONCILED; PUBLIC INTAKE REMAINS OFF; ACCESS-BOUNDARY TEST ADDED; CI PENDING**

## 1. Purpose and authority boundary

LPS-28 advances GAP-04 only within the existing private synthetic repository scope. It reconciles the current institution representative proposal/correction and editorial review workflow with the LPS-17 operating framework, and adds a regression test that unauthenticated callers cannot submit a correction and that no public complaint/moderation/appeal route is registered.

This is not an activated institute correction service, public complaint channel, legal process, named operations appointment, response-time commitment or pilot. No real requester, institute, student, child, guardian or personal information is processed.

All standing exclusions remain binding: no V1/production/Hostinger/hosted access; no live DB/migrations/backups; no real data; no source access/contact/collection; no external API/AI/provider; no public complaint/UGC/review/rating/moderation/appeal activation; no deployment, pilot, release or participant activity; no new dependency or spend. Deeni Madaris remains default-OFF/zero exposure.

## 2. Existing repository workflow reconciliation

| Stage | Existing repository mechanism | Current evidence and limitation |
|---|---|---|
| Representative submission | Authenticated `POST /institutions/{institution}/claims` route; `UniversityRepresentativeWorkflowController::store` | Requires active, verified user and exact institution-scoped `institution.claim.submit` authorization; synthetic source context only |
| Correction request | Authenticated `POST /institutions/{institution}/claims/{claimVersion}/correction` route; `UniversityRepresentativeWorkflowController::correct` | Requires exact institution scope and correction capabilities; validates bounded evidence references, idempotency key, dates, reason code and rationale |
| Successor creation | `UniversityRepresentativeWorkflowService::correctReturnedProposal` and field-aware correction/governance services | Creates immutable successor and preserves predecessor; correction is not erasure |
| Editorial review | Authenticated start/complete review routes and `EditorialReviewService` | Separate scoped reviewer; submitter cannot review own case; records history/audit; no future operations team is appointed |
| Public publication | Separate adjudication/publication governance services | Representative submission/correction does not publish directly; publication is a separate authorized decision |
| Synthetic moderation/appeal fixture | `SyntheticModerationWorkflow` | Internal test-fixture entry point accepts a synthetic reference only, not report text, attachments, identity documents or arbitrary payloads; this is not a public complaint service |
| Public intake | No public complaint, moderation or appeal route in `routes/web.php` | No public channel is activated or advertised by this agenda |

## 3. New synthetic access-boundary regression test

Added `UniversityRepresentativeWorkflowTest::test_correction_requires_authenticated_scope_and_no_public_complaint_or_appeal_route_is_registered`.

The test:
1. Creates the existing fictional institution/evidence fixture.
2. Attempts to post a synthetic correction without authentication.
3. Expects an unauthorized response.
4. Confirms claim-version and editorial-case row counts are unchanged by the rejected request.
5. Inspects registered route names and asserts that no route name contains `complaint`, `moderation` or `appeal`.

This is a regression guard for the current route surface. It is not a general penetration test or proof of hosted routing, proxy behavior, authorization in an external environment or future route inventory.

## 4. Operational gaps deliberately not activated

The following remain future prerequisites, not work performed by LPS-28:

- Qualified local legal/privacy/safeguarding review and applicable jurisdictional requirements.
- Appointment of intake, identity/authority verification, factual review, decision, appeal and escalation roles.
- Approved requester verification methods and minimal evidence requirements.
- Publicly approved contact/channel and accessible acknowledgement/communication templates.
- Triage priorities, urgent safety escalation and service-level commitments based on actual capacity.
- Conflict-of-interest handling, independent appeal and reviewer separation arrangements.
- Approved retention, deletion, redaction and evidence/attachment handling.
- Source-specific rights assessment under LPS-15 for disputed source material.
- Real-data, hosted and operational authorization.

No numerical response time, staffing capacity, legal basis, identity-document collection method or retention period is invented.

## 5. Validation

- Synthetic-only feature test added.
- No new route, controller, public form, email, telephone, queue or public service activated.
- No real complaint text, attachments, identity documents or external source content used.
- Foundation CI and documentation validation must pass on the exact PR head.
- CI execution remains pending until GitHub Actions completes.

## 6. Acceptance disposition

- [x] Existing institution proposal/correction and editorial review paths mapped.
- [x] Correction route remains authenticated and institution-scoped.
- [x] Representative correction does not publish directly; separate governance approval remains required.
- [x] Existing moderation fixture is synthetic-reference-only and not public intake.
- [x] Regression test added for unauthenticated correction rejection and absence of public complaint/moderation/appeal routes.
- [ ] Exact-head Foundation CI passes.
- [ ] Exact-head documentation validation passes.
- [ ] Qualified legal/privacy/safeguarding assessment — NOT RECEIVED.
- [ ] Human operational roles and service channels — NOT APPOINTED / NOT AUTHORIZED.
- [ ] End-to-end correction/complaint/appeal/removal operations — NOT IMPLEMENTED.
- [ ] GAP-04 closure — NOT ACCEPTED.

**Final disposition:** LPS-28 is a repository-only correction-workflow reconciliation and access-boundary test addition. GAP-04 remains **PARTIALLY PREPARED / NOT OPERATIONALLY IMPLEMENTED / OPEN / NOT CLOSED**. M3-11 Gate 02 remains BLOCKED / NOT ACCEPTED; all other M3-11 gate dispositions remain unchanged. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
