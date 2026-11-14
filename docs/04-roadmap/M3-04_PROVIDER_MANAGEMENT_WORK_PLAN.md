# M3-04 — Provider Management Work Plan and Entry Preparation

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Status:** **PLANNING STARTED — IMPLEMENTATION NOT AUTHORIZED**  
**M3-03 dependency:** Owner-accepted and closed for its bounded synthetic local/CI scope  
**Baseline:** `main` at `eebfc20a1adac14d4911ed92175366af81cf2e43`

## 1. Purpose and authorization boundary

This work plan starts the next roadmap step, M3-04 Provider Management, at the planning and scope-definition level. It defines the initial bounded work packages, domain contracts, acceptance criteria, synthetic fixture approach, permission constraints and CI evidence expected before implementation.

The Product Owner's instruction on 2026-11-14 accepted the G-04 traceability reconciliation and authorized moving to the next work. The final M3-03 exit review is recorded separately. This plan does **not** authorize application code, schema changes, migrations, test changes or runtime behavior. A separate explicit authorization must name the exact M3-04 implementation slice before those changes begin.

## 2. M3-04 outcome

Deliver governed administration of:
- Provider identity — legal, administrative or operating organization.
- Institution identity — education entity represented in the directory.
- Campus and delivery-site identities — distinct locations/units, not inferred from similar names.
- Programme catalogue entries — distinct from qualifications and cycle-specific offers.
- Authority identities and typed relationships — regulator, accreditor, examining body, awarding body, recognition and affiliation are not interchangeable.
- Status history — proposed, verified, active, inactive, disputed, merged or split where supported by explicit human decisions.
- Editorial review — controlled proposals, evidence linkage, human review, adjudication and audit lineage.

M3-04 is an internal management/governance step. It does not deliver public directory routes, public search, production administration or source ingestion.

## 3. Binding domain rules

The accepted logical model and conceptual model remain authoritative:

1. Provider, institution, campus/delivery site, programme, qualification, awarding body and authority are distinct identities.
2. Provider–Institution is a typed, time-bounded relationship. Neither side is required to have exactly one counterpart; no exclusive operator is inferred.
3. Relationship predicates use a controlled vocabulary and typed endpoints. At minimum: `regulated_by`, `licensed_by`, `accredited_by`, `recognized_by`, `examined_by`, `awarded_by`, `affiliated_with`, `operates`, `owns`, `administers` and `delivers_at`.
4. Relationship scope, jurisdiction where relevant, valid-time interval and evidence are retained. Unknown predicates, invalid endpoints and reversed intervals fail closed.
5. Institution–Campus and Programme–Offer distinctions remain explicit. A programme catalogue entry is not evidence that it is offered at a campus in a particular admission cycle.
6. Programme, qualification and awarding body remain separate; recognition, accreditation, licensing and affiliation remain authority-scoped relationships.
7. Identity similarity may create a candidate for human review; it never authorizes an automatic merge. Merge/split decisions preserve prior identity and relationship lineage.
8. Conflicting, stale, disputed and unknown statuses remain distinguishable; no newest-recorded-wins shortcut.
9. Deeni Madaris remain a distinct underlying category with public visibility default OFF under V2-DEC-006. No sect/maslak attribute or discovery filter is introduced.
10. Claims and evidence continue through the M3-03 governance services. Provider-management commands must not bypass source authorization, evidence quarantine, adjudication, publication or audit controls.

## 4. Known domain/runtime gaps to reconcile in the first slice

The G-04 matrix records these honestly:
- **T-001:** typed Provider–Institution endpoint compatibility, relationship cardinality and active-interval semantics are not yet demonstrated by a runtime relationship validator.
- **T-002:** structural foreign-key endpoint integrity is tested; institution-specific relationship semantics are not established by that test.
- **T-003:** rejection of unknown relationship predicates is not yet demonstrated by a runtime vocabulary validator.

These are directly relevant to Provider Management. The first M3-04 implementation slice must therefore establish and test the typed relationship contract before dependent provider/institution editorial workflows are treated as complete. This is a scoped carry-forward, not a claim that the behavior already exists.

Other G-04 deferrals—public-field allowlisting, deterministic validator serialization, identity merge/split lifecycle and programme/offer/fee/awarding-body runtime contracts—remain separately visible. They may be sequenced into later M3-04 slices only after dependency review and explicit scope approval.

## 5. Proposed bounded work packages

### M3-04 P01 — Provider/Institution Identity and Typed Relationship Contract

Deliver:
- Provider and Institution identity boundaries and minimum required attributes.
- Provider–Institution relationship type, cardinality, scope and valid-time rules.
- Controlled relationship-predicate vocabulary and endpoint-type compatibility matrix.
- Campus versus delivery-site distinctions and Institution–Campus cardinality.
- Duplicate candidate policy and human merge/split decision requirements.
- Synthetic fixtures and negative/positive contract cases for T-001–T-003.
- Migration/service/test proposal, but no implementation until separately authorized.

Acceptance:
- Every relationship has valid typed endpoints and a recognized predicate.
- Reversed/empty temporal intervals are rejected.
- Concurrent provider relationships are allowed only when each has explicit distinct type/scope and valid evidence; no exclusivity is inferred.
- Unknown relationship types fail closed.
- Duplicate candidates remain separate pending a distinct human decision.
- Audit and lineage requirements are explicit for creation, correction, dispute, merge and split.

### M3-04 P02 — Campus, Delivery Site and Programme Catalogue

Deliver:
- Institution-owned campus identity and separately modeled delivery sites.
- Programme catalogue distinct from qualification.
- Explicit qualification and awarding-body links.
- No campus availability assertion without a cycle-scoped Programme Offer.
- Synthetic fixtures for multiple campuses, shared programme names and programme/qualification distinctions.

Acceptance:
- Similar campus names do not auto-merge.
- Campus-specific status and location assertions retain separate provenance and valid-time.
- Programme catalogue data cannot be mistaken for current campus availability.
- Awarding body is not inferred from provider or regulator identity.

### M3-04 P03 — Authority, Affiliation and Recognition Relationships

Deliver:
- Authority identity and authority type.
- Distinct relationship semantics for licensing, regulation, accreditation, recognition, examination, awarding and affiliation.
- Scope, jurisdiction, subject, evidence and effective dates.
- Negative fixtures proving that one relationship type cannot satisfy another.

Acceptance:
- Recognition/affiliation is never inferred from name similarity.
- A relationship is visible as unknown, reported, evidenced, effective, expired, suspended, withdrawn or disputed as appropriate.
- Authority scope and subject are explicit.

### M3-04 P04 — Status History and Editorial Review

Deliver:
- Entity lifecycle and status-history event model.
- Proposal/review/decision/audit transitions.
- Capability matrix for submit, edit, review, adjudicate, approve, suppress and restore.
- Incompatible-role and independent-review requirements.
- Synthetic actor fixtures only; no actual accounts or role provisioning.

Acceptance:
- Every material transition is auditable and idempotent where applicable.
- Submitter/collector, reviewer/adjudicator and publisher separation is enforced according to the approved capability model.
- Automated checks cannot adjudicate or publish.
- Disputed identity and relationship changes remain unpublished pending human resolution.
- No public route or public projection is added in M3-04.

## 6. Permission and human editorial coverage constraints

Before implementation authorization, define a complete action-to-capability matrix for:
- provider/institution creation and correction;
- campus/site and programme management;
- authority relationship submission and review;
- identity duplicate candidate review;
- adjudication and publication approval;
- emergency suppression and restoration;
- audit inspection and export.

Constraints:
- Synthetic actor identifiers only during local/CI implementation.
- No production identity provider, user account, credential, role assignment or real staff/student/person record.
- Automated matching/validation can propose candidates but cannot approve a merge, resolve a conflict or publish a fact.
- Human approval remains explicit and audited.
- If a workflow requires independent actors, the synthetic test actors must be distinct. Actual human staffing/coverage is a later operational gate and must not be represented as solved by test fixtures.
- Real source collection and source authorization are out of scope.

## 7. Synthetic fixture and test strategy

Use fabricated, clearly fictional identities and values only. Do not use real institution names, addresses, contact details, people, source URLs or source-derived content.

Required synthetic fixture families:
1. One provider operating multiple institutions.
2. One institution with multiple campuses and a separate non-campus delivery site.
3. One institution with no provider relationship.
4. Two concurrent Provider–Institution relationships with different explicit types/scopes.
5. Relationship with an invalid endpoint type.
6. Unknown relationship predicate.
7. Reversed and open-ended valid-time intervals.
8. Duplicate-looking provider/institution/campus identities that must remain separate pending human review.
9. Distinct regulator, accreditor, examining body, awarding body and affiliated authority.
10. Programme with multiple possible qualifications; offer scoped to one campus and one admission cycle.
11. Deeni Madaris category with default-OFF visibility invariant.
12. Disputed, expired, inactive, merged and split synthetic lifecycle examples.

Test layers:
- Unit/contract tests for vocabulary, endpoint compatibility, cardinality and temporal rules.
- SQLite in-memory feature tests for persistence, transactionality, audit and lineage.
- Service workflow tests for proposals, review, correction, dispute and human decision boundaries.
- Regression tests proving M3-03 governance services cannot be bypassed.
- No production database, network service, external API or third-party AI in CI.

## 8. CI and delivery gates

For each implementation PR, require:
- Exact-head FND-01 PHP 8.5 foundation CI.
- Exact-head Project documentation validation.
- Locked dependency audit, formatting, bootstrap/routes, synthetic-only test suite and artifact hygiene as configured in the existing workflow.
- Review-thread reconciliation and review disposition.
- Expected-head SHA merge guard.
- Updated work package, test evidence, progress report, documentation catalogue and decision/risk register.

Do not create new workflows or alter repository protections unless a specific gap is evidenced and separately approved.

## 9. Explicit exclusions

No Listing V1 changes; no Hostinger/hPanel or production access; no live database; no real/source/personal/institute/student/child/staff data; no source acquisition or ingestion; no external APIs or AI; no real identity/role provisioning; no public endpoints, public directory, search, deployment, launch, procurement, paid services or new spend. No physical migration or application code is authorized by this planning document.

## 10. Entry checklist and current decision

| Gate | Status | Evidence / next action |
|---|---|---|
| M3-03 exit accepted | **Accepted for bounded synthetic scope** | Owner accepted G-04; final exit review recorded in M3-03 closeout |
| Provider/institution domain gaps | **Scoped for P01** | T-001/T-003 and semantic portion of T-002 explicitly listed; P01 must resolve them before dependent workflows |
| M3-04 scope and acceptance criteria | **Prepared** | P01–P04 work packages above |
| Synthetic fixtures and CI strategy | **Prepared as plan** | Fixture families and exact-head CI requirements above |
| Permission and human editorial constraints | **Prepared as plan** | Capability matrix and independent-human decision rules above |
| Separate implementation authorization | **NOT ISSUED** | Requires a further explicit Product Owner approval naming P01 scope |

**Decision:** M3-04 planning is started. The next eligible activity is P01 detailed contract/fixture design and implementation proposal. Do not change application code, schema, migrations or tests until P01 is separately authorized. M3-04 implementation remains **BLOCKED pending explicit authorization**.

