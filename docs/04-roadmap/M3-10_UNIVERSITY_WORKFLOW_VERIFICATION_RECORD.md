# M3-10 — University Workflow Verification and Synthetic Tabletop Record

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Verification date:** 2026-11-17  
**Verified baseline:** `54aae352c012b1534d0db4d14cb5ca30a895da42`  
**Scope:** repository-only inspection; no application changes, live activity or external access  
**Status:** REPOSITORY VERIFICATION COMPLETE — USER-FACING WORKFLOW NOT PRESENT

## 1. Purpose and authorization

This record verifies whether the selected Option B candidate can currently be exercised as a university profile review/correction workflow.

The Product Owner selected Lahore, Punjab, Pakistan and the `university` provider category for proposal preparation only. These are scope descriptors for a future proposal; they do not authorize participant recruitment, human sessions, real institutional data, source retrieval, hosted activity, feature activation, deployment, release or spend.

This verification is limited to the V2 GitHub repository at the exact baseline above. No V1, production, Hostinger/hPanel, live database, external source, institution website, API, connector or AI/model service was accessed.

## 2. Executive finding

**The underlying service-layer governance and correction capabilities exist, and the controlled provider-category vocabulary includes `university`. However, the current application does not expose a user-facing institution/university profile correction or editorial-review route.**

The current HTTP surface has read-only public directory routes plus account-session endpoints. The editorial review and field-aware correction classes are internal services, not HTTP controllers. The existing feature tests exercise those services with synthetic actors and fabricated fixtures; they do not demonstrate an end-to-end university representative interface.

Consequently:

- Repository-level service-contract verification and non-human synthetic tabletop work can proceed within M3-10.
- A participant-facing usability evaluation cannot currently be performed against a university correction UI because that UI/route is not present.
- The future adult-only usability candidate must remain conditional on a separately authorized interface/workflow implementation and all applicable approvals.
- No pilot readiness or launch-readiness acceptance is implied.

## 3. Repository evidence

### 3.1 HTTP route inventory

Inspected `routes/web.php` at the verified baseline.

| Route | Method | Controller / behavior | Finding |
|---|---|---|---|
| `/health` | GET | Health response | Diagnostic only |
| `/account/session` | POST | Account session creation | Session endpoint; not a university workflow |
| `/account/session` | DELETE | Account session destruction | Session endpoint |
| `/directory` | GET | `PublicDirectoryController::index` | Read-only public directory search |
| `/directory/{entity}` | GET | `PublicDirectoryController::show` | Read-only public profile; UUID-constrained |

No authenticated route for submitting, editing, reviewing, correcting, adjudicating or publishing an institution/university profile was present in this route file.

### 3.2 Controller boundary

`PublicDirectoryController` exposes only `index` and `show`. It validates read/search parameters and calls `PublicDirectoryQueryService`; it does not accept profile changes or invoke the editorial review service.

### 3.3 Service-layer capabilities

The repository contains:

- `EditorialReviewService`: proposal submission, independent review, correction after changes are requested, adjudication, publication approval, suppression and restoration. Its capability matrix is explicit. The service has no HTTP/controller references.
- `FieldAwareClaimCorrectionService`: registry-bound institution claim correction. It requires a human actor with correction/submission capabilities, exact field-definition binding, typed validation, applicability and metadata-only synthetic evidence context. Its accepted source context is restricted to `synthetic_test_only`, `fixture_reference`, and `synthetic`.
- `ProviderCategoryAssignmentService`: human-governed assignment to a controlled vocabulary of `private_school`, `college`, `academy`, and `university`. It assigns categories only to institution entities and audits the assignment.
- `PublicDirectoryQueryService`: assembles approved anonymous projections. Public directory access remains a read path and does not create or edit assertions.

### 3.4 Authorization integration limitation

`ScopedAuthorization` defines account-role actions such as `provider.claim.submit`, `claim.review` and `institution.publish`, with resource scoping and self-review/self-publication denial.

The editorial services separately accept capability-bearing actor records and enforce governance capabilities at the service boundary. The inspected route/controller surface does not connect an authenticated university representative to these service operations. This record therefore does not claim that the proposed representative workflow is end-to-end wired or ready for a user.

### 3.5 Synthetic test evidence inspected

Existing feature tests include:

- `EditorialReviewServiceTest`: synthetic submission idempotency, submitter/reviewer separation, automated actor denial, independent adjudication and publication, dispute denial and status history.
- `FieldAwareClaimProposalTest`: exact definition binding, typed correction, immutable predecessor, idempotent successor and re-entry into editorial review; tests also assert no publication decision or public projection is created by correction.
- `ProviderCategoryAssignmentTest`: controlled category vocabulary, institution-only assignment, human capability, idempotency and audit history.
- `ScopedAuthorizationTest`: scoped roles, self-review/self-publication denial, expiry/revocation and incompatible role boundaries.
- `PublicDirectoryTest`: approved anonymous projection only, suppression/supersession handling, exact registry definition and visibility, independent search/filter/sort flags, hostile-value handling and Deeni Madaris exclusion.

These test files were inspected as repository evidence. This verification did not execute the test suite and does not represent a new CI run.

## 4. University category disposition

The controlled provider-category vocabulary explicitly includes `university`. Category assignment applies to an existing `institution` entity, is human-capability gated and audited. The assignment service does not infer category from an entity label.

For this proposal, “universities and degree-awarding institutions” maps to the existing `university` category only as a proposed synthetic classification. It does not establish that any real Lahore institution is in scope, recognized, verified or eligible. No real university names, addresses, contacts, source records or claims are introduced.

## 5. Non-human synthetic tabletop scenario

The following is a documentation-only rehearsal scenario. It does not create accounts, execute a workflow, collect data or contact anyone.

**Scenario ID:** `SYN-LHR-UNI-001`  
**Synthetic subject:** `Synthetic University LHR-001`  
**Category:** `university`  
**Locality label:** `Lahore (synthetic scenario label only)`  
**Data:** fabricated values and metadata-only synthetic evidence references

| Step | Synthetic event | Expected control / outcome |
|---|---|---|
| 1 | Human taxonomy steward assigns `university` to the synthetic institution | Only the controlled category is accepted; assignment is audited and idempotent |
| 2 | Synthetic editor proposes a registry-bound display-name claim | Exact definition version, typed value, applicability and synthetic evidence authorization are required |
| 3 | A different synthetic human reviewer starts review | Submitter cannot review own proposal; automated actors cannot review |
| 4 | Reviewer requests a correction | Only the original submitter may correct the returned proposal |
| 5 | Editor submits a corrected value | Immutable successor is created, predecessor remains unchanged, exact definition binding is retained, and successor re-enters review |
| 6 | A distinct adjudicator records acceptance | Reviewer/submitter separation remains enforced; disputed/rejected claims cannot proceed to publication |
| 7 | A distinct publisher authorizes anonymous directory publication | Publication requires accepted adjudication and separate publisher; no correction action publishes directly |
| 8 | A suppression event is recorded | Public projection is suppressed; stale events cannot revive a withdrawn/superseded value |
| 9 | A reinstatement is proposed after withdrawal | It must be a new successor with fresh eligible synthetic evidence and a new review; the withdrawn version is not revived |

The scenario is a control walkthrough derived from the inspected service and test contracts. It is not proof that a browser UI, representative account journey or complete HTTP workflow exists.

## 6. Acceptance and gap register

| ID | Requirement | Current finding | Disposition |
|---|---|---|---|
| UWF-01 | `university` is in controlled category vocabulary | Present in `ProviderCategoryAssignmentService` | Verified by inspection |
| UWF-02 | Category assignment is institution-only, human-gated and audited | Present in service and feature-test coverage | Verified by inspection |
| UWF-03 | Field-aware correction is synthetic-only and definition-bound | Present in correction service and tests | Verified by inspection |
| UWF-04 | Review/adjudication/publication enforce distinct actors | Present in editorial service and tests | Verified by inspection |
| UWF-05 | Public directory route is read-only | Routes/controller inspected | Verified by inspection |
| UWF-06 | Authenticated university representative correction route exists | No route/controller found in inspected HTTP surface | **Gap — not delivered** |
| UWF-07 | Browser-facing correction/review interface exists | No such interface found in inspected controller surface | **Gap — not delivered** |
| UWF-08 | Account-role authorization is wired end-to-end to editorial services | No route/controller adapter found | **Gap — not delivered** |
| UWF-09 | End-to-end HTTP feature tests cover representative workflow | Existing tests exercise services, not a representative HTTP journey | **Gap — not delivered** |
| UWF-10 | Human usability evaluation can be run now | No user-facing workflow; all human activity remains unauthorized | **Not ready / not authorized** |

## 7. Required next work before any usability proposal can be operationalized

Any future user-facing workflow implementation requires its own explicit scope and authorization. Before it can be considered for a usability evaluation, the project must:

1. Define the intended university representative account, identity proofing and institution-scoped permissions without collecting unnecessary personal data.
2. Design an authenticated, institution-scoped submission/correction interface and its HTTP boundary; do not expose editorial review, adjudication or publication capabilities to the submitter.
3. Connect account-role authorization to service capabilities with fail-closed resource scoping and independent-role enforcement.
4. Add synthetic HTTP feature tests for authorized submission, unauthorized institution scope, self-review denial, correction, idempotency, validation failure, no direct publication, privacy-safe responses and Deeni Madaris non-exposure.
5. Complete accessibility, privacy, security and recovery review for the exact interface and environment.
6. Obtain a separate explicit implementation authorization before any application changes outside currently authorized documentation/repository-only work.
7. Keep any later human usability evaluation blocked until the existing research deferral is formally resolved, qualified reviews are complete, named human operators are assigned and a separate activity authorization is recorded.

No implementation, hosting, participant work, real data, source access, deployment, new dependency or spend is authorized by this record.

## 8. Final disposition

- PR #244 merged as `54aae352c012b1534d0db4d14cb5ca30a895da42`; its exact-head FND-01 foundation CI and Project documentation validation passed.
- Lahore and `university` are recorded as proposal scope choices only.
- Repository inspection confirms service-layer governance/correction capabilities and a controlled `university` category.
- A user-facing university correction/review workflow is **not present** in the inspected HTTP surface.
- Synthetic non-human tabletop preparation is within current M3-10 authorization.
- No participant usability evaluation, pilot, readiness acceptance or launch go/no-go is approved.

**M3-10 remains IN PROGRESS. Pilot readiness remains NOT ACCEPTED. Human activity and real-data processing remain NOT AUTHORIZED. M3-11 remains NOT AUTHORIZED.**
