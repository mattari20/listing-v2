# M3-04 P03 — Authority, Affiliation and Recognition Relationships Implementation Record

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Work package:** M3-04 P03  
**Status:** **IMPLEMENTED — exact-head CI/review pending**  
**Base:** `0e1ce7036b849460e2a636f15d24d77c1e09dcec`  
**Branch:** `feature/m3-04-p03-authority-recognition`

## 1. Authorization and boundaries

The Product Owner separately authorized P03 on 2026-11-14. Implementation is limited to synthetic local/CI fixtures. No production, V1, Hostinger/hPanel, live database, real institution/person/student/child/staff data, source collection, external API/AI, public route, deployment, procurement or paid service is included. P04 is not authorized by this P03 scope.

## 2. Authority identity contract

An authority remains a distinct `directory_entities.entity_type = authority` identity. Its `authority_profiles` row records one controlled type:
- `regulator`
- `licensing_authority`
- `accreditation_body`
- `recognition_authority`
- `examining_body`
- `affiliation_body`

Authority registration requires a human actor with `register_directory_entity`, a non-empty label, controlled type and idempotency key. Registration writes the identity, profile and audit event atomically. Similar names do not merge identities.

Awarding bodies remain separate `awarding_body` identities and are not silently converted into authority profiles.

## 3. Typed relationship matrix

| Predicate | Permitted subject types | Target | Required authority type |
|---|---|---|---|
| `regulated_by` | institution, campus, programme | authority | regulator |
| `licensed_by` | institution, campus | authority | licensing_authority |
| `accredited_by` | institution, campus, programme | authority | accreditation_body |
| `recognized_by` | institution, campus, programme, qualification | authority | recognition_authority |
| `examined_by` | programme, qualification | authority | examining_body |
| `awarded_by` | qualification | awarding_body | distinct awarding-body identity |
| `affiliated_with` | institution, campus | authority | affiliation_body |

Predicate semantics are not interchangeable. For example, an accreditation body cannot satisfy `recognized_by`; a regulator cannot satisfy `licensed_by`; a provider cannot be an authority endpoint. Direction is subject-to-authority/awarding-body and is not automatically reversed.

## 4. Governed relationship lifecycle

Each assertion is proposed as a claim with explicit subject, target, predicate, scope and jurisdiction. Materialization requires:
- current accepted claim version with no successor;
- persisted human accepted adjudication distinct from materializer;
- admissible evidence linked to approved, current and unrevoked source authorization;
- evidence submitter distinct from adjudicator and materializer;
- human `materialize_relationship` capability;
- explicit scope and jurisdiction;
- valid inclusive/open-ended valid-time interval;
- idempotency key and transactional relationship projection plus audit event.

The projection reuses `entity_relationships` and its `claim_version_id` link. Existing M3-03 correction, withdrawal and source-authorization revocation workflows therefore supersede, withdraw or suppress P03 relationship rows without creating a parallel approval state machine. Same subject/target/predicate/scope/jurisdiction assertions with overlapping active valid-time are rejected. Distinct scope or jurisdiction remains separately represented.

## 5. Changed files

- `app/Domain/Directory/AuthorityRelationshipPolicy.php`
- `app/Services/Directory/AuthorityRelationshipService.php`
- `database/migrations/2026_11_14_000005_create_authority_profiles.php`
- `tests/Feature/AuthorityRelationshipTest.php`
- `docs/04-roadmap/M3-04_PROVIDER_MANAGEMENT_WORK_PLAN.md`
- `docs/04-roadmap/M3-04_P03_IMPLEMENTATION_RECORD.md`
- `docs/04-roadmap/DOCUMENTATION_CATALOG.md`
- `docs/04-roadmap/PROJECT_PROGRESS_REPORT.md`
- `docs/README.md`

No new workflow, CI secret, package, external integration, public endpoint or V1/production configuration is introduced.

## 6. Synthetic test coverage

The P03 feature suite covers:
1. controlled authority type and idempotent registration;
2. each authority predicate paired with its required authority type;
3. recognition not satisfied by an accreditation body;
4. awarding body kept distinct from authority profile;
5. unknown predicates, reversed direction, wrong endpoint types and invalid types fail closed;
6. mandatory scope, jurisdiction and valid date intervals;
7. accepted human adjudication, distinct materializer and idempotent materialization;
8. overlapping duplicate assertion rejection;
9. claim withdrawal and source-authorization revocation propagation;
10. audit failure rolls back relationship projection.

Fixtures use synthetic names and synthetic jurisdiction/scope values only. The suite does not claim live authority verification or legal recognition status.

## 7. Limitations and deferred work

- This is an internal governed data-management projection, not a public recognition or accreditation directory.
- Authority type is a controlled profile label; the implementation does not establish legal powers, territory boundaries, statutory status or real-world recognition.
- Scope and jurisdiction are explicit strings, not yet normalized against a national jurisdiction taxonomy.
- Identity merge/split, authority succession and multi-role authority identity remain deferred to separately designed human workflows.
- No source is approved or ingested by this implementation.
- P04 status history/editorial review is not included.

## 8. Acceptance and delivery evidence

P03 is considered implementation-complete only after exact-head FND-01 PHP 8.5 foundation CI and Project documentation validation pass, review threads are reconciled, and the PR is merged with an expected-head SHA guard. Until those gates are recorded, this artifact remains **implementation delivered; validation/merge pending**.

## 9. Safety declaration

All implementation and test data are fabricated. No production or V1 access, Hostinger/hPanel operation, live database write, external API/AI, deployment, public route, paid service or additional spend occurred.
