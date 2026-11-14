# M3-04 P02 — Campus, Delivery Site and Programme Catalogue Implementation Record

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Work package:** M3-04 P02  
**Status:** Implemented on isolated branch; exact-head CI and review pending  
**Base:** `a51860e904dc57ea47702ed75a2d44c612ac9b2f`  
**Branch:** `feature/m3-04-p02-campus-programme-catalogue`

## 1. Authorization and boundaries

The Product Owner authorized proceeding with the P02 model on 2026-11-14. This implementation is limited to fabricated synthetic fixtures and local/CI execution. It does not access production, V1, Hostinger/hPanel, real institution/source/person/student/child/staff data, external APIs or AI, public routes, deployment, procurement or paid services.

P03 authority/recognition relationships and P04 editorial capability/lifecycle work remain out of scope.

## 2. Implemented domain model

- **Campus:** a distinct directory identity with an explicit owning institution, optional location label, status, valid-time and accepted claim-version provenance.
- **Delivery site:** a separate identity and table, also institution-owned. It is not silently treated as a campus.
- **Programme catalogue entry:** a distinct programme identity, owned by an institution and carrying catalogue title, optional description/level, status and accepted claim-version provenance.
- **Qualification:** remains a separate identity; it is not the programme.
- **Awarding body:** remains a separate identity; it is not inferred from the provider, institution or regulator.
- **Programme–qualification link:** explicit and separately records the programme, qualification and awarding body.
- **Programme offer:** an explicit programme/location/admission-cycle assertion. It is the only P02 record that represents a programme being offered at a specific campus or delivery site for a particular cycle.

A programme catalogue entry by itself does not imply campus availability, current admissions or an offer. Existing governance correction, withdrawal and source-authorization revocation workflows propagate superseded, withdrawn and suppressed states to the P02 projection tables.

## 3. Governance and fail-closed rules

Every P02 materialization requires:
- a current, accepted claim version that has not been superseded;
- a persisted human acceptance decision by an actor distinct from the materializer;
- at least one eligible evidence reference with an approved, current, unrevoked source authorization;
- an evidence submitter distinct from the materializer;
- a human `materialize_catalogue_record` capability and a non-empty idempotency key;
- a transaction that writes both the catalogue projection and audit event atomically.

The claim subject identity type must match the P02 predicate. Campus/site parent references must be institution identities. Programme catalogue entries must reference an institution. Qualification links require existing programme catalogue, qualification and awarding-body identities. Offers require an existing programme catalogue entry, an existing campus or delivery site belonging to the same institution, and an explicit admission cycle. Invalid dates, invalid entity types, missing evidence, stale claims and missing human adjudication fail closed.

Similar names remain separate identities; there is no fuzzy matching, automatic deduplication, merge or split behavior in P02.

## 4. Files changed

- `database/migrations/2026_11_14_000004_create_campus_programme_catalogue.php`
- `app/Services/Directory/CampusProgrammeCatalogueService.php`
- `app/Services/Governance/PersistedGovernanceWorkflowService.php` — correction, withdrawal and source-authorization revocation propagate status changes to P02 projections
- `tests/Feature/CampusProgrammeCatalogueTest.php`
- `docs/04-roadmap/M3-04_PROVIDER_MANAGEMENT_WORK_PLAN.md`
- `docs/04-roadmap/M3-04_P02_IMPLEMENTATION_RECORD.md`
- `docs/04-roadmap/DOCUMENTATION_CATALOG.md`

No existing public route, API, V1 file, Hostinger configuration, production database or CI workflow was changed.

## 5. Synthetic test coverage

The feature test suite covers:
1. Multiple campuses under one institution.
2. A delivery site distinct from campus.
3. Similar campus labels retained as separate identities.
4. Programme catalogue distinct from qualification and offer.
5. Explicit programme/qualification/awarding-body association.
6. Campus and delivery-site offers scoped to distinct admission cycles.
7. Wrong institution identity type rejected.
8. Missing admission cycle rejected.
9. Cross-institution campus offer rejected.
10. Unadjudicated claim rejected.
11. Audit failure rolls back catalogue projection.
12. Claim withdrawal propagates to the campus catalogue projection.

Tests use fabricated identifiers, labels, dates, actors, evidence and authorization rows only.

## 6. Known limitations and follow-on work

- No user-facing management UI, public read API or public search is introduced.
- No source acquisition, source ingestion, real institutional data or production role provisioning is included.
- P03 must implement authority identity and distinct regulatory/accreditation/recognition/affiliation semantics.
- P04 must complete the wider status-history, editorial review and capability matrix.
- Identity merge/split and general temporal conflict evaluation remain deferred.
- Exact-head PHP 8.5 foundation CI and project documentation validation must pass before P02 can be accepted as complete.
- This implementation record is not a production-readiness or deployment approval.

## 7. Acceptance checklist

| Criterion | Evidence | Status |
|---|---|---|
| Campus identity is institution-owned | Campus profile table and typed service validation | Implemented |
| Delivery site remains distinct from campus | Separate entity type and profile table | Implemented |
| Similar names do not auto-merge | Separate UUID identities; synthetic test | Implemented |
| Campus status/location retain claim provenance and valid-time | Claim-version FK, valid dates, audit | Implemented |
| Programme catalogue is distinct from qualification | Separate programme identity and explicit link table | Implemented |
| Awarding body is explicit | Required typed awarding-body reference in qualification link | Implemented |
| Catalogue does not imply availability | Separate cycle-scoped offer table | Implemented |
| Offer location belongs to programme institution | Service-level ownership validation | Implemented |
| Human adjudication/evidence/audit preserved | Fail-closed materialization service | Implemented |
| Synthetic tests and exact-head CI | Feature tests authored; GitHub CI pending | Pending validation |

**P02 completion decision:** Implementation is prepared on the isolated branch. Final acceptance is conditional on exact-head CI, documentation validation, review reconciliation and merge guard. No claim of passing CI or merged completion is made in this record until GitHub reports those results.
