# RCV-B02 — Offer-Scoped Admissions Facts Implementation Design

**Date:** 2026-11-18  
**Repository:** `mattari20/listing-v2`  
**Implementation baseline:** `main` at `0dfca8d998550c2aa52325c3b5bd90088fd77b44`  
**Branch:** `feat/rcv-b02-offer-scoped-admissions-facts`  
**Authorization:** Product Owner's subsequent explicit RCV-B02 implementation authorization, including necessary in-scope schema changes. This supersedes the earlier pre-authorization wording in the documentation-only RCV-B02 scope pack / PR #304.  
**Work type:** V2-only, synthetic local/CI implementation.

## 1. Decision

Use a dedicated offer-scoped governed assertion path. Do not widen the institution-only claim/field-registry scope and do not reuse entity-level publication snapshots as if they identified an offer.

Every fact is anchored to exactly one existing `programme_offers.id`. The offer already identifies one programme, one institution-owned delivery location and one explicit admission cycle.

The new path uses dedicated fact identity, immutable fact versions, evidence links, human adjudication, human publication decisions, immutable snapshots, public projections and suppression records. Existing `evidence_references`, `source_authorizations` and `GovernancePolicy` are reused only through explicit checks. Existing claim, adjudication and publication tables/services remain unchanged.

The implementation migration creates:
- `programme_offer_fact_freshness_policies`: immutable, owner-approved, category-specific freshness policies with a positive day limit, owner identity and policy version.
- `programme_offer_facts` and `programme_offer_fact_versions`: offer-bound fact identity, version number, typed JSON value, state, disposition, observation/validity and freshness policy snapshot, successor and idempotency.
- `programme_offer_fact_evidence_links`: version-to-existing-evidence references.
- Dedicated fact adjudication case/decision tables.
- Dedicated fact publication decision/snapshot/projection/suppression tables.

The separate `ProgrammeOfferFactWorkflowService` owns submission, owner policy approval, adjudication, publication, correction, withdrawal and suppression. `PublicProgrammeOfferFactsQueryService` resolves only approved projections through the exact offer, programme and delivery location, rechecks current source authorization and evidence, and derives stale state at read time.

## 2. Initial fact categories

- `eligibility`
- `deadline`
- `fee`
- `scholarship`

A stable `fact_key` identifies a fact within one offer. Multiple fee components or eligibility criteria use distinct keys; no silent aggregation or calculated total is introduced.

## 3. Fact states and temporal rules

Supported states: `known`, `unknown`, `not_stated`, `not_applicable`, `conflicting`, `withdrawn`; `stale` is derived at read time.

- `known` requires a non-null typed JSON value and admissible evidence.
- Non-known states carry no asserted value. In particular, zero is a valid known numeric amount and is not an unknown marker.
- `stale` is derived, not an assertion state: a known fact is stale when its owner-approved, category-specific freshness policy has elapsed. A current label is permitted only when a field-specific policy key matches an immutable approved policy record and positive day limit. No universal freshness interval is assumed.
- The public query can show stale facts with an explicit warning, but never labels them current. Unknown, not-stated, not-applicable and conflicting states remain distinct; conflicting output contains no selected value.
- Valid-time bounds are explicit and checked. No deadline is inferred or calculated.

## 4. Governance lifecycle

1. A human with `submit_offer_fact` capability submits a proposed version and links existing evidence references.
2. A separate human opens a fact adjudication case.
3. A human with `adjudicate_claim` capability decides the case. Existing `GovernancePolicy::authorizeAdjudication` enforces human adjudication and separation from evidence submitters.
4. A different human with `authorize_publication` capability publishes only a current accepted known version with admissible, currently authorized evidence. Existing source authorization is checked for the synthetic/publication purpose and method.
5. A publication snapshot contains the offer ID, cycle, fact key/category, safe value, state, observation/validity and freshness metadata. Projection is offer/version-specific.
6. Supersession, withdrawal, evidence/source revocation or suppression must prevent the older assertion from appearing current.

The new workflow is deliberately separate from `PersistedGovernanceWorkflowService`, whose current publication contract is claim-version/entity scoped.

## 5. Anonymous public contract

Public admissions facts are returned only from approved projections and must be joined through the snapshot to the exact offer and fact version. Public output is a strict allowlist. It must not expose evidence IDs/content, source authorization data, internal actor IDs, audit metadata, idempotency keys or private rationale.

Facts are attached to the public programme profile, grouped by the existing offer cycle and delivery location. No write route, application submission, applicant account, upload, payment, notification, recommendation, shortlist or comparison is introduced.

## 6. Safety and exclusions

- Synthetic/fictional fixtures only; disposable SQLite in tests.
- V2 repository only; no V1 inspection, reuse or adaptation.
- No real institution, source, student, applicant, child, guardian or staff data.
- No source collection, scraping, connectors, external APIs, model/provider calls or AI activation.
- No production, Hostinger, live database, deployment, DNS, public launch or URL cutover.
- No new dependency, vendor, paid service, procurement or spend.
- Deeni Madaris remains default-OFF and excluded.
- Public UGC, ratings, reviews, reporting and moderation remain disabled.
- RCV-B03, RCV-B05 and M3-11 remain separate; this work does not close or authorize them.

## 7. Acceptance evidence required

- Offer isolation across different offers, locations and cycles.
- Strict category/key/value/state validation, including known zero vs unknown.
- Explicit freshness policy and stale/current derivation.
- Evidence admissibility, source authorization and human separation-of-duties tests.
- Idempotency and immutable version/snapshot tests.
- Withdrawal, supersession, conflict, source revocation and suppression tests.
- Public allowlist and no cross-offer leakage.
- Deeni Madaris exclusion and no new write/application routes.
- Full exact-head PHP 8.5 foundation CI and documentation validation before merge consideration.

**Status:** implementation branch created; migration, workflow service, public query, profile integration and initial synthetic feature tests committed. Exact-head CI and final implementation review remain pending. No production or external activity.
