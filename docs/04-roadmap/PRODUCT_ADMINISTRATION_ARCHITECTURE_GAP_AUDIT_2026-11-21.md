# Product Administration and Institute Information Management — Architecture Gap Audit

**Date:** 2026-11-21  
**Baseline:** `d560890f46d8c9d4329101824a99b26a86a27ee3` (main, PR #415)  
**Scope:** Repository source inventory and previously accepted M3-12 A05 verification.  
**Disposition:** Initial architecture/gap audit complete; implementation agenda defined.

## 1. Purpose

Establish what administration and institute-information-management capabilities already exist before building the missing product experience. This is a product-development audit, not an independent security assessment or production-readiness review.

## 2. Existing implementation inspected

- `routes/web.php`
- `app/Http/Controllers/UniversityRepresentativeWorkflowController.php`
- `app/Services/Directory/UniversityRepresentativeWorkflowService.php`
- `tests/Feature/UniversityRepresentativeWorkflowTest.php`
- `docs/04-roadmap/M3-12_A05_ADMINISTRATION_EDITORIAL_OPERATIONS_VERIFICATION_2026-11-20.md`

### Existing route families

| Route family | Current role |
|---|---|
| `/directory`, `/directory/{entity}` | Public discovery and profile |
| `/directory/compare`, shortlist endpoints | Student comparison/shortlisting |
| `/account/session` | Account session lifecycle |
| `/account/saved-items` | Authenticated saved items |
| `/institutions/{institution}/claims` | Authenticated university representative proposal submission |
| `/institutions/{institution}/claims/{claimVersion}/correction` | Scoped proposal correction |
| `/institutions/{institution}/editorial-cases/{case}/review` | Editorial review start/completion |

The representative controller returns JSON responses. It checks active and verified human identity, scoped authorization and university institution type; validates evidence references and idempotency; and submits proposals/corrections into editorial review. Its source context is explicitly synthetic-test-only. It is not a general browser-based administration console.

The service verifies institution ownership of claim versions and editorial cases and performs correction handling transactionally. The previously completed A05 verification also documents field-definition governance, typed value validation, editorial separation of duties and backend provider/institution relationship controls.

## 3. Gap register

| ID | Gap | Required product outcome |
|---|---|---|
| ADM-01 | No complete browser administration dashboard | Role-oriented dashboard, navigation, queues and status summaries |
| ADM-02 | Representative workflow limited to university scope | Governed provider workflows for approved institute categories, without weakening identity/scope checks |
| ADM-03 | No integrated institution/campus editor | Manage institution identity and campus/delivery locations through versioned, evidence-backed proposals |
| ADM-04 | No integrated programme/admission-offer editor | Manage programmes, delivery sites, cycles, deadlines and fee facts with strict scope validation |
| ADM-05 | No unified evidence workspace | Attach, inspect, assess and track source/evidence references and provenance |
| ADM-06 | No complete editorial/adjudication workspace | Review queues, reviewer assignment, decisions, changes requested, holds and adjudication |
| ADM-07 | No unified publication/suppression workspace | Human approval, publication state, withdrawal/suppression and auditable transitions |
| ADM-08 | No role-oriented audit/history views | Show who proposed, reviewed, adjudicated and published each version |
| ADM-09 | No established operational staffing model | Keep staffing, coverage and SLAs as separate M3-11 operational evidence requirements |

## 4. Target workflow

1. Authorized provider representative or internal editor opens the relevant institution record.
2. User selects an allowed institution, campus, programme or admission-cycle scope.
3. User submits a typed field change with evidence references, effective dates and rationale.
4. System validates scope, field definition version, permissions, evidence and idempotency.
5. Submission enters an editorial queue; submitters cannot review their own submissions.
6. Reviewer records a reasoned decision: changes requested, held, or ready for adjudication.
7. Authorized adjudicator/publisher makes the separately governed publication decision.
8. System preserves immutable history, provenance, actor, timestamps and version relationships.
9. Corrections create successor versions and return through review; no direct-publish bypass.

## 5. Implementation agenda

### ADM-A — Information architecture and authorization
- Define roles and capabilities for platform administrator, catalogue editor, provider representative, evidence reviewer, adjudicator and publisher.
- Map each action to existing scoped authorization primitives.
- Define route/controller boundaries and page-level access behavior.
- Preserve separation of duties and prevent self-review.

### ADM-B — Institution and campus management
- Search/select authorized institution.
- View identity, status, campus and delivery-site relationships.
- Submit evidence-backed proposals and corrections.
- Show version, review state and history.

### ADM-C — Programme and admission management
- Manage programme/qualification relationships.
- Manage delivery-site scope and admission cycle.
- Maintain approved offer facts, deadlines and fees with currency, effective period and historical state.
- Never inherit institution-level facts into programme scope without an explicit governed relationship.

### ADM-D — Evidence and editorial workspace
- Evidence reference inspection and provenance.
- Reviewer queues, assignment, rationale, hold and changes-requested states.
- Adjudication and publication decision surfaces.
- Audit trail and conflict/dispute handling.

### ADM-E — Integration and quality
- Bilingual English/Urdu labels and RTL support.
- Responsive layouts, keyboard/focus behavior and accessible validation messages.
- Synthetic authorization, workflow, regression and route tests.
- Browser verification after the local application is available and separately authorized.

## 6. Acceptance criteria

- Every write is authenticated, active, verified where required, capability-scoped and entity-scoped.
- Every field value is validated against the approved field definition and exact entity/programme/campus/cycle scope.
- Evidence references and rationale are required for governed submissions.
- No submitter can review or adjudicate their own submission.
- No provider or editor can bypass editorial approval and publication controls.
- Corrections create successor versions and preserve history.
- Every decision is attributable and auditable.
- Student-facing pages expose only approved/published facts and clearly identify missing information.
- Synthetic tests cover allowed and denied paths, cross-tenant access, invalid scope, idempotency, rollback and workflow transitions.
- No real/source/personal data or public UGC is introduced.

## 7. Explicit exclusions

- No V1, production, Hostinger/hPanel, hosted environment or live database access.
- No real institute/student data collection or source access.
- No external AI/API/vendor activation.
- No deployment, pilot, release candidate or public activation.
- No paid service, new spend or unnecessary dependency.
- No activation of public reviews, complaints, appeals or moderation.
- Deeni Madaris remains default-OFF with zero public exposure.

## 8. Conclusion

The repository already contains meaningful backend governance and a narrow university representative JSON workflow. It does not yet provide the integrated browser administration and institute-information-management experience required for a usable product. The next agenda is to implement ADM-A through ADM-E incrementally, reusing the existing governance services rather than creating a parallel publishing system.

This audit closes only the initial source-inventory task. It does not close M3-11 or overall M3.
