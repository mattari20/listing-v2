# M3-04 P01 — Provider/Institution Identity and Typed Relationship Contract

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Status:** **IMPLEMENTATION VALIDATED — PR #176**  
**Baseline:** `main` at `509f3c3150753c122467c50530f50347511bf6ab`  
**Work package:** M3-04 P01

## 1. Purpose and scope

P01 resolves the provider/institution identity and relationship-contract questions that must be settled before dependent Provider Management workflows are implemented. It carries forward G-04 oracle T-001, T-002 and T-003.

This is a design and test-contract artifact only. It does not change application code, schema, migrations, fixtures, test assertions or CI. A separate explicit Product Owner authorization must approve the exact implementation slice before any such change.

## 2. Current repository baseline

The current core migration creates:
- `directory_entities`: UUID, free-form `entity_type` (40 characters), label and timestamps.
- `entity_relationships`: UUID, foreign keys to `directory_entities` for both endpoints, free-form `relationship_type` (40 characters), optional scope/jurisdiction, optional `valid_from`/`valid_to`, timestamps and a composite uniqueness constraint.
- Foreign-key endpoint integrity is exercised by `CoreGovernancePersistenceTest::test_relationships_reject_missing_entity_endpoints`.

The current schema/test do **not** establish:
- controlled entity-type or relationship-predicate vocabularies;
- allowed source/target entity-type combinations;
- semantic cardinality and concurrency rules;
- rejection of unknown predicates;
- valid-time interval validation for relationships;
- evidence/adjudication linkage for relationship assertions;
- duplicate candidate and human merge/split lifecycle.

A foreign key proves that an endpoint row exists. It does not prove that a Provider is related to an Institution using a permitted predicate or that the relationship is valid for the stated period.

## 3. Identity type contract

The following identities must remain distinct:

| Entity type | Meaning | Must not be conflated with |
|---|---|---|
| `provider` | Legal, administrative or operating organization | Institution, regulator |
| `institution` | Education entity represented in the directory | Provider, campus |
| `campus` | Named branch/campus of an institution | Institution, general delivery site |
| `delivery_site` | Place where a programme is delivered that is not necessarily a campus | Campus, institution |
| `programme` | Structured course/catalogue entry | Qualification, programme offer |
| `qualification` | Credential/award or level | Programme |
| `authority` | Regulator, licensing, accrediting, examining or recognizing body | Provider, institution |
| `awarding_body` | Entity responsible for issuing a qualification | Teaching provider; may also carry an authority role but that role must be explicit |

The initial P01 runtime contract should validate the Provider and Institution types and may recognize the other types as endpoint categories without implementing their complete management workflows. P02/P03 will add their lifecycle behavior.

## 4. Relationship predicate and endpoint compatibility proposal

Relationship direction is semantic and must not be silently reversed.

| Predicate | Permitted source type | Permitted target type | Scope/meaning |
|---|---|---|---|
| `operates` | provider | institution | Provider operates institution |
| `owns` | provider | institution | Explicit ownership assertion; not inferred from operation |
| `administers` | provider | institution | Explicit administrative responsibility |
| `regulated_by` | institution, campus, programme | authority | Regulation under an identified authority |
| `licensed_by` | institution, campus, programme | authority | Licensing scope |
| `accredited_by` | institution, campus, programme | authority | Accreditation scope |
| `recognized_by` | institution, campus, programme, qualification | authority | Recognition scope; never inferred from affiliation |
| `examined_by` | programme, qualification | authority | Examination/assessment responsibility |
| `awarded_by` | qualification | awarding_body | Qualification issuer |
| `affiliated_with` | institution, campus | authority | Explicit affiliation |
| `delivers_at` | programme | campus, delivery_site | Delivery location; not a cycle-specific offer |

This matrix is a proposed controlled contract, not an assertion that every predicate is currently implemented. P01's first executable scope should implement and test the Provider–Institution subset (`operates`, `owns`, `administers`) and the global unknown-predicate rejection. The remaining rows are reserved for P02/P03 and must not be activated prematurely.

### Direction and endpoint invariants

- Provider–Institution relationship rows must use Provider as the source and Institution as the target.
- Reversed endpoint direction is invalid even if both endpoint rows exist.
- A relationship with an unsupported endpoint type is invalid.
- A relationship with an unknown predicate is invalid (fail closed).
- An institution may have zero, one or multiple provider relationships over time.
- Concurrent relationships are permitted only when each has an explicit, distinct type and scope supported by admissible evidence. Do not infer a single exclusive operator.
- An institution may have no provider relationship; this is not a validation failure.
- Campus and delivery-site relationships are not introduced as provider ownership shortcuts.

## 5. Temporal contract

Use the already implemented Agenda 10 date semantics for P01 relationship intervals:
- Date bounds are inclusive.
- A null `valid_from` or `valid_to` is an open bound.
- If both bounds exist, `valid_to` must not be earlier than `valid_from`.
- A relationship is active on a date only if that date is within its inclusive interval.
- Historical relationships remain available for lineage; changing an operator is a new/corrected, auditable assertion, not silent overwrite.
- Recorded time and valid time remain distinct. A later recorded relationship does not automatically supersede an older still-valid relationship.

The P01 contract should not implement automated conflict resolution. Competing incompatible assertions are preserved for human review.

## 6. Evidence, review and audit integration — selected decision

P01 selects option 1: represent the relationship as a claim/version through the existing claim, evidence-link, adjudication and audit workflow, with the entity_relationships row acting only as a governed projection/identity record.

A proposal remains proposed and cannot create an active relationship row. Materialization requires a current accepted claim version, a persisted human accepted adjudication, currently admissible evidence linked to unrevoked source authorization, a human actor with the materialize_relationship capability, and an audit event committed in the same transaction. Materialization is idempotent and rejects idempotency-key reuse with a different fingerprint.

The projection stores a unique claim_version_id. Source authorization revocation suppresses linked active projections; claim withdrawal marks them withdrawn; claim correction marks the prior projection superseded. The claim/version workflow remains authoritative. No second approval state machine is introduced.

Quarantined evidence is not admissible proof. Automated validation cannot approve a relationship or merge identities. The other predicates remain reserved and fail closed in P01.

## 7. Duplicate and identity resolution contract

- Similar names, addresses, abbreviations or shared premises create a possible-match candidate only.
- Do not merge Provider, Institution, Campus, Authority or Awarding Body records by string similarity alone.
- Preserve candidate identities separately while unresolved.
- A merge requires an explicit human decision, reason, evidence, audit event and stable redirect/lineage mapping.
- A split/reversal must preserve the pre-merge identities and relationship history; no destructive reassignment.
- Source-scoped identifiers, issuing authority and jurisdiction are stronger matching evidence than name similarity, but still require an approved matching policy and human decision for a merge.
- P01 may define duplicate candidate scoring inputs, but no autonomous merge threshold or production entity-resolution service is authorized.

## 8. Proposed synthetic test contract

All values must be fabricated and unmistakably synthetic. Suggested test IDs are P01-R01 onward; they are proposed cases, not existing tests.

| Test ID | Scenario | Expected result |
|---|---|---|
| P01-R01 | Provider `provider` operates Institution `institution` | Accepted relationship shape |
| P01-R02 | Provider owns/administers Institution with explicit predicate | Predicate-specific valid relationship |
| P01-R03 | Institution → Provider with `operates` | Reject reversed endpoint direction |
| P01-R04 | Provider → Campus using Provider–Institution-only predicate | Reject incompatible endpoint type |
| P01-R05 | Unknown relationship predicate | Reject; fail closed |
| P01-R06 | Missing source or target entity row | Foreign-key rejection |
| P01-R07 | Institution with no Provider relationship | Valid; no implicit provider |
| P01-R08 | Institution with two historical operators in non-overlapping intervals | Preserve both historical assertions |
| P01-R09 | Two concurrent provider relationships with distinct explicit type/scope | Permit only if policy/evidence contract is satisfied |
| P01-R10 | Concurrent duplicate same type/scope assertion | Idempotent duplicate or explicit conflict; never silent duplicate |
| P01-R11 | `valid_to` earlier than `valid_from` | Reject invalid interval |
| P01-R12 | Null interval bound | Treat as open-ended under documented temporal semantics |
| P01-R13 | Later recorded assertion overlaps earlier valid-time assertion | Preserve both; no latest-recorded-wins |
| P01-R14 | Relationship lacks admissible evidence | Cannot be accepted/activated |
| P01-R15 | Evidence authorization is revoked after acceptance | Re-evaluate/suppress dependent governed assertion under M3-03 policy |
| P01-R16 | Similar Provider and Institution names | Keep separate identities; no type collapse |
| P01-R17 | Duplicate-looking provider candidates | Preserve candidates pending human decision |
| P01-R18 | Merge attempt by automated actor | Deny |
| P01-R19 | Human merge with missing reason/evidence | Deny |
| P01-R20 | Audit write fails during relationship transition | Roll back authoritative transaction |
| P01-R21 | Relationship predicate is `affiliated_with` but target is another Provider | Reject incompatible endpoint type |
| P01-R22 | Relation corrected or withdrawn | Preserve previous version and audit lineage |

The 17 focused P01 feature tests cover the implemented core subset. They do not claim all 22 proposed cases are individually implemented; the broader design matrix retains deferred cases explicitly. Exact-head PHP 8.5 CI and documentation validation passed for PR #176.

## 9. Migration and service design questions to resolve before implementation

1. Entity type vocabulary: application enum/validator, database constraints, or both, with SQLite/MySQL portability evidence.
2. Predicate vocabulary: versioned registry and endpoint compatibility matrix; unknown values fail closed.
3. Relationship evidence: claim/version integration versus first-class relationship assertion/version table.
4. Relationship status: avoid duplicating M3-03 adjudication state; define the authoritative status source.
5. Temporal constraints: application validation plus database-level guard where portable.
6. Duplicate identity: candidate record, match evidence, human resolution, merge/split lineage.
7. Uniqueness: verify nullable-scope uniqueness behavior on SQLite and target MySQL/MariaDB before relying on the current composite unique index.
8. Audit atomicity: all authoritative relationship changes and audit events share one transaction.
9. Authorization: capability checks at the service boundary; no controller-only enforcement.
10. Idempotency: command key and deterministic duplicate behavior for retries.

No physical migration should be drafted as final until these choices and the target database compatibility boundary are approved.

## 10. Acceptance criteria for P01

P01 implementation is subject to exact-head CI and review. The selected architecture and implemented slice are recorded in M3-04_P01_IMPLEMENTATION_RECORD.md. The remaining criteria below are tracked as implementation or deferred scope:
- Provider/Institution identity boundaries and endpoint direction are unambiguous.
- The controlled predicate registry and endpoint matrix are owner-reviewed.
- Cardinality and concurrency rules preserve non-exclusive, time-bounded provider relationships.
- Inclusive/open-ended temporal semantics are explicit and consistent with Agenda 10.
- Evidence/adjudication integration has one selected design and no parallel weaker approval path.
- Duplicate candidates, human merge/split and audit lineage are defined.
- The proposed P01-R01–R22 test cases are mapped to exact acceptance criteria.
- Migration portability and nullable unique-index behavior have a test plan.
- The exact implementation files, schema changes, services, tests and non-goals are enumerated.
- A separate explicit Product Owner authorization names the approved implementation scope.

## 11. Safety and execution boundary

Implementation is limited to the synthetic local/CI slice described in the implementation record. No real or source-derived data was used. No Listing V1, Hostinger/hPanel, production/live DB, external API/AI, real role provisioning, public endpoint, deployment, procurement or new spend is included.

**Current disposition:** P01 implementation is submitted for exact-head CI and review. The implementation is limited to Provider–Institution predicates and synthetic local/CI evidence; P02–P04 remain unauthorized.


## 12. Implementation test coverage note

The first implementation adds synthetic feature coverage for enabled predicates, direction and endpoint compatibility, unknown/reserved predicate rejection, absent provider relationships, historical intervals, distinct scope/jurisdiction, date validation, admissible evidence, idempotent materialization, duplicate identity preservation, audit atomicity, withdrawal and source-revocation status propagation. The proposed R01–R22 matrix remains the broader acceptance contract; identity merge/split and candidate adjudication are explicitly deferred rather than represented as implemented.
