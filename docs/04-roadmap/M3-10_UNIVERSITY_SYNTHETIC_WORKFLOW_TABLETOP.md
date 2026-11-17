# M3-10 — University Synthetic Workflow Tabletop and Acceptance Evidence

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-17  
**Baseline main:** `84701b9f4c2f903aabf576c529bc9f57202a9cee`  
**Scope:** documentation-only, non-human, synthetic tabletop design  
**Status:** TABLETOP SCENARIO AND EVIDENCE MATRIX PREPARED — NOT EXECUTED

## 1. Purpose and authorization boundary

This record defines a repeatable, non-human tabletop for the existing V2 university category, claim correction, editorial review, adjudication, publication suppression and withdrawal controls.

It follows the repository verification record and the Product Owner's Option B choice. Lahore and the `university` category are proposal descriptors only. The current HTTP surface has no authenticated university representative correction route or interface; therefore this is not a browser usability test and cannot be represented as an end-to-end participant journey.

Current authorization permits repository/documentation work and synthetic-only local/CI or non-human tabletop work. This record does not authorize:
- application implementation, interface or route activation;
- participant recruitment, contact, consent, interviews, surveys or human sessions;
- real university, student, provider, staff, guardian or source data;
- source access, scraping, ingestion, connectors, external APIs or AI/model services;
- hosted environments, production/V1/Hostinger/hPanel, deployment, release or launch;
- public UGC, reviews, ratings, reporting or moderation;
- new dependencies, vendors, procurement or spend.

The existing pre-launch student research deferral remains binding. Deeni Madaris remains default-OFF with zero public exposure.

## 2. Scenario and synthetic data contract

**Scenario ID:** `SYN-LHR-UNI-001`  
**Locality label:** Lahore, Punjab, Pakistan — synthetic scenario label only  
**Category:** `university`  
**Synthetic entity:** `syn-inst-lhr-uni-001`  
**Synthetic display name:** `Synthetic University Lahore One`  
**Synthetic actors:** taxonomy steward, submitter, reviewer, adjudicator, publisher, suppressor and restorer — non-account fixture identities only  
**Evidence:** fabricated metadata-only synthetic references; no document content, real URL, source or external record

All identifiers and values in any future fixture must be deterministic, unmistakably fictional and confined to disposable local/CI data. Do not seed real-world Lahore institution names or infer any institution's status, recognition, ownership or affiliation.

## 3. Tabletop sequence and expected controls

This is a designed walkthrough against the existing service/test contracts. Unless a row explicitly cites existing feature-test coverage, it is an expected control to rehearse in a future authorized synthetic local/CI exercise, not a claim of newly executed evidence.

| Step | Actor / event | Expected result | Existing evidence / limitation |
|---|---|---|---|
| T01 | Taxonomy steward assigns `university` to the synthetic institution | Accept only controlled category; institution subject, human capability, audit and idempotency enforced | `ProviderCategoryAssignmentTest` covers controlled vocabulary, human-only capability, institution-only subject, audit and idempotency |
| T02 | Automated/service actor attempts category assignment | Deny; no category assignment or success audit | Existing category feature test covers automated actor denial |
| T03 | Entity label resembles a university but no category is assigned | Do not infer category from label | Existing category test asserts no label inference |
| T04 | Synthetic editor submits a field-aware display-name proposal | Exact field-definition version, typed value, applicability and synthetic evidence context required | Field-aware proposal/correction tests exercise service contract; no HTTP submit route |
| T05 | Submitter attempts to start review of own proposal | Deny and preserve status history | Editorial review feature test covers submitter/reviewer separation |
| T06 | Automated actor attempts review | Deny | Editorial review feature test covers automated actor denial |
| T07 | Independent reviewer completes review | Only a distinct eligible reviewer can move case to adjudication-ready | Editorial review feature test covers full independent-role flow |
| T08 | Reviewer attempts to adjudicate own review | Deny; no adjudication decision | Editorial review feature test covers reviewer/adjudicator separation |
| T09 | Submitter corrects a returned field-aware proposal | Create immutable successor; preserve predecessor and exact definition binding; resubmit to editorial review | Field-aware correction test asserts idempotent successor, unchanged predecessor, exact binding and submitted review case |
| T10 | Correction request is retried with same idempotency key and fingerprint | Return same successor without duplicate review or claim version | Existing field-aware correction test covers idempotent retry |
| T11 | Correction uses invalid typed value or mismatched definition binding | Reject without creating a valid successor | Existing correction tests cover invalid typed values and exact binding constraints |
| T12 | Adjudicator records disputed outcome | No publication approval may follow | Editorial review feature test covers disputed publication denial |
| T13 | Distinct adjudicator accepts; distinct publisher authorizes publication | Only after required review/adjudication; publication is a separate capability | Editorial review feature test covers full flow and publication |
| T14 | Correction is submitted without publication capability | Correction remains proposed/review-bound; no direct public projection | Field-aware correction test asserts zero publication decisions and zero public projections immediately after correction |
| T15 | Suppressor suppresses an approved snapshot | Public output is suppressed and audit/history retained | Editorial review feature test covers suppression and restoration sequence |
| T16 | A withdrawn/superseded value receives stale publication/proposal outbox event | Stale event must not revive value or public projection | I5 implementation record describes the guard; no new test execution in this tabletop |
| T17 | Reinstatement is requested for a withdrawn field-aware claim | New successor only, same exact definition version, fresh eligible synthetic evidence and new review; no restoration of withdrawn version | I5 implementation record and existing field-aware proposal tests describe this contract |
| T18 | Deeni Madaris entity or category is accidentally introduced into public projection | Fail closed; zero public exposure | Public directory feature tests and I5 record retain Deeni Madaris exclusion; this tabletop does not execute new tests |
| T19 | Actor lacks scope, capability, is inactive/expired/revoked, or attempts self-review/publication | Deny at service/authorization boundary; do not rely on hidden UI controls | `ScopedAuthorizationTest` and service tests cover scoped roles and incompatible-role boundaries |
| T20 | Audit persistence fails during an authoritative transition | Transaction must roll back; no partial accepted state | Contract expectation; requires a dedicated fault-injection test if not already covered by current tests |

## 4. Stop and fail-closed conditions

Stop the scenario immediately and record a blocked result if any of the following occurs:

1. Any real person, institution, student, staff, guardian or source record appears.
2. A synthetic fixture contains a real website URL, personal contact detail, credential, secret or identifying information.
3. A route or control would expose submission, review, adjudication or publication beyond its authorized actor and resource scope.
4. Submitter/reviewer/adjudicator/publisher separation is bypassed.
5. A correction mutates its predecessor, rebinds to a different field definition version, bypasses typed validation or publishes directly.
6. A disputed, withdrawn, suppressed or superseded value becomes publicly visible through a stale event or retry.
7. Deeni Madaris data becomes visible on any public surface or side channel.
8. Any external network/API/model/source, connector, production/V1/Hostinger system, hosted environment, deployment or spend is involved.
9. A required human owner, qualified review, accountable operations role or authorization is assumed rather than evidenced.
10. The exercise drifts into recruitment, participant contact, interviews, surveys, consent collection or usability research.

A stop is a recorded exception, not permission to improvise a workaround or broaden scope.

## 5. Evidence ledger and honest acceptance status

| Evidence item | Evidence available at baseline | Status |
|---|---|---|
| Controlled university category and human assignment | Service and `ProviderCategoryAssignmentTest` inspected | Existing test coverage; not rerun by this tabletop |
| Field-aware correction and immutable successor | I5 service/test and implementation record inspected | Existing test coverage; not rerun by this tabletop |
| Editorial role separation and adjudication | Editorial review service/test inspected | Existing test coverage; not rerun by this tabletop |
| Public projection and suppression boundary | Public directory tests and I5 record inspected | Existing test coverage; not rerun by this tabletop |
| HTTP university representative journey | No authenticated correction/review route or UI found | Not delivered |
| End-to-end HTTP acceptance | No representative HTTP workflow test found in inspected surface | Not delivered |
| New tabletop execution transcript | No local/CI execution performed for this documentation agenda | Not executed |
| Qualified privacy/legal/security/accessibility review | No reviewer outputs supplied | Not evidenced |
| Human operations/support roster | No named accepted roster supplied | Not assigned |
| Pilot authorization and acceptance | Not supplied | Not authorized / not accepted |

This document is a prepared tabletop script and evidence map. It does not claim that the tabletop has been run, that all expected controls have been newly tested, or that a user-facing workflow exists.

## 6. Exit criteria for this documentation agenda

The documentation agenda may be considered complete when:
- the scenario uses only deterministic synthetic identities and metadata-only evidence references;
- each control is mapped to existing repository test/service evidence or explicitly marked as a gap;
- the absent HTTP/interface layer is not misrepresented as implemented;
- stop conditions and Deeni Madaris exclusion are explicit;
- the evidence ledger distinguishes inspected existing coverage, unexecuted scenarios, missing implementation and missing human approvals;
- catalogue and documentation index are reconciled;
- exact-head documentation validation and FND-01 CI pass before merge.

## 7. Separate future gates — not part of this agenda

A future authenticated university representative workflow requires separate implementation scope and explicit owner authorization. That scope would need resource-scoped account authorization, a representative submission/correction route, privacy-safe validation/errors, independent editorial roles, no submitter access to adjudication/publication, and synthetic HTTP feature tests.

A future human usability evaluation remains blocked until the existing research deferral is formally resolved, participant protocol and qualified legal/privacy/safeguarding/security/accessibility reviews are complete as applicable, named human operations/support owners accept responsibility, and a separate explicit activity authorization is recorded. No such approval is implied here.

## 8. Final disposition

- M3-10 University Workflow Verification Record is merged in PR #245.
- PR #245 exact-head PHP 8.5 FND-01 foundation CI and Project documentation validation passed.
- This agenda prepares a non-human synthetic tabletop and acceptance evidence map only.
- The tabletop has **not** been executed; no new test results are claimed.
- The university representative HTTP route/interface remains absent.
- Pilot readiness remains **NOT ACCEPTED**; no participant or real-data activity is authorized.
- M3-10 remains **IN PROGRESS**; M3-11 remains **NOT AUTHORIZED**.
