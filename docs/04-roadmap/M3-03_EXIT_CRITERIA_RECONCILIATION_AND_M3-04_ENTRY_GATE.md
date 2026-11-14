# M3-03 — Exit-Criteria Reconciliation and M3-04 Entry Gate

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Status:** **G-04 TRACEABILITY DELIVERED — PRODUCT OWNER ACCEPTANCE PENDING; M3-03 EXIT NOT YET ACCEPTED**  
**Baseline:** `main` at `82c215844766470859c1ddd2000ebd271d0f9cf7`

## 1. Purpose and decision

This record reconciles the M3-03 step-level exit evidence in `M3_MASTER_STEP_PLAN.md` against the accepted logical model, merged schema/service/workflow implementation and existing synthetic tests after Agenda 9.

The roadmap exit evidence requires tests for:
1. lineage;
2. temporal facts;
3. conflicts;
4. authorization;
5. auditability;
6. publication/withdrawal;
7. rollback;
8. no unauthorized source data.

**Decision:** M3-03 must remain **IN PROGRESS**. Agendas 1–9 are closed within their separately authorized scopes, but Agenda completion does not by itself satisfy every step-level exit criterion. In particular, conflict handling and rollback are not yet demonstrated as complete persisted application workflows. Temporal conflict behavior remains largely specification/policy-level rather than persisted end-to-end evidence.

This is a documentation and evidence reconciliation only. It does not authorize additional application code, migrations, source access, real data, production, external services, public endpoints, deployment or spend.

## 2. Evidence matrix

| M3-03 exit criterion | Existing evidence | Assessment |
|---|---|---|
| Lineage | Immutable claim-version successor creation and predecessor preservation in Agenda 9; adjudication appeal parent lineage in Agenda 7; immutable publication snapshots | **Covered for bounded implemented paths** |
| Temporal facts | Claim versions persist `valid_from`, `valid_to`, `recorded_at`; Agenda 9 validates date syntax and reversed ranges | **Partial** — no implemented persisted conflict evaluation for overlapping valid-time assertions, non-overlapping succession or recorded-time/valid-time conflict cases |
| Conflicts | Deterministic policy conflict detection and GS matrix; disputed adjudication outcome persists and blocks publication | **Partial** — no persisted first-class conflict/candidate aggregate or end-to-end workflow preserving competing claim versions through resolution |
| Authorization | Scoped source authorization checks; quarantined metadata-only evidence registration; revocation propagation to evidence/snapshots/projections | **Covered for bounded synthetic workflows** |
| Auditability | Material command audit records; audit and authoritative writes share transactions; synthetic audit-failure rollback test | **Covered for bounded implemented paths**; no claim of tamper-evident or production audit infrastructure |
| Publication/withdrawal | Human adjudication/publication, immutable snapshots, outbox projection, suppression/restoration, source-revocation suppression, claim withdrawal | **Covered for bounded synthetic workflows** |
| Rollback | Logical test vector T-018 specifies prior-snapshot rollback; suppression restoration exists | **Not covered as specified** — restoration from suppression is not equivalent to an explicit, persisted rollback-to-prior-approved-snapshot operation with audit lineage and synthetic end-to-end tests |
| No unauthorized source data | Synthetic fixture catalogue and tests only; no source content or real records used in the implementation | **Satisfied for the inspected repository work** |

## 3. Concrete gaps to close before M3-03 acceptance

### G-01 — Persisted conflict lifecycle

The physical schema currently has no dedicated conflict or conflict-candidate table. Conflict detection exists as a deterministic policy function and the adjudication workflow can persist a `disputed` outcome, but the repository does not yet demonstrate an end-to-end persisted conflict aggregate that:
- records the competing claim-version candidates and the rule/predicate context;
- preserves both sides without latest-recorded-wins behavior;
- records conflict status and human adjudication linkage;
- preserves the original conflict and decision lineage after correction or withdrawal.

A bounded synthetic-only scope should define the minimum persistence and service contract, then prove it with disposable SQLite feature tests. No automated conflict resolution is implied.

### G-02 — Temporal conflict evaluation

Claim-version rows store valid-time and recorded-time fields, and correction validates a basic date interval. The application tests do not yet prove the key logical-model oracles for overlapping incompatible assertions, non-overlapping temporal succession, and a newer recorded assertion that conflicts with an older still-valid fact.

The next scope must implement deterministic temporal conflict evaluation and route conflict outcomes to human review. It must not choose a winner by recency alone.

### G-03 — Explicit rollback to a prior approved snapshot

The specification includes T-018, but the persisted workflow currently supports suppression and restoration, not a distinct rollback operation. A rollback must create a new auditable event/decision referencing the selected prior approved snapshot, preserve intervening snapshots and audit history, verify that the target remains eligible under current authorization/policy, and update the internal projection through the outbox. It must not erase history or bypass current governance checks.

### G-04 — Runtime execution of the complete deterministic oracle set

The original T-001–T-032 specification is a design-level oracle catalogue. The GS-001–GS-032 matrix is policy-level verification, not 32 persisted end-to-end workflows. The completion evidence must clearly distinguish implemented feature tests from unexecuted specification vectors. Only the gap cases above are currently identified as blockers by this reconciliation; a future test plan should cross-reference each oracle to its actual runtime test or explicitly retained deferral.

## 4. Recommended next bounded agenda

**Recommended next activity:** M3-03 Agenda 10 — Persisted Conflict Lifecycle, Temporal Conflict Evaluation and Prior-Snapshot Rollback.

Proposed scope, subject to a separate explicit Product Owner authorization:
- local repository and GitHub CI only;
- fabricated synthetic fixtures only;
- disposable SQLite `:memory:` only;
- minimum conflict and candidate persistence needed for competing claim-version lineage;
- deterministic valid-time conflict evaluation, preserving recorded-time versus valid-time distinctions;
- human adjudication linkage for conflict resolution; no automated winner;
- explicit rollback to a prior eligible approved snapshot, with new audit/outbox lineage and current-policy rechecks;
- feature tests for overlap, non-overlap, recency conflict, preserved candidates, adjudication, rollback, idempotency, authorization failure and audit atomicity;
- exact-head PHP 8.5 foundation CI, Project documentation validation, review reconciliation and expected-head merge guard.

Explicit exclusions remain: V1, Hostinger/hPanel, production/live DB, real/source/personal/institute/student/child/staff data, source acquisition, external API/AI, real role provisioning, public endpoint, deployment, procurement, new spend and repository protection changes.

**This record is not implementation authorization.** No schema or application change for Agenda 10 may begin until the Product Owner explicitly approves the exact scope above or a narrower revised scope.

## 5. M3-04 entry gate

M3-04 Provider Management is the next roadmap step after M3-03, not the next executable implementation agenda today. Its defined scope is provider/institution identity, campuses/delivery sites, programmes, affiliation/authority relationships, status history, editorial review and role-appropriate management.

M3-04 entry remains blocked until:
1. M3-03 exit evidence is satisfied and accepted by the Product Owner;
2. any physical/domain-model gaps relevant to provider and institution identity are reconciled;
3. the M3-04 scope, acceptance criteria, synthetic fixtures and CI checks are defined;
4. permission and human editorial coverage constraints are explicit;
5. a separate implementation authorization is recorded.

No provider-management implementation is started by this reconciliation.

## 6. Final disposition

- M3-03 Agendas 1–9: **completed within their individual bounded scopes**.
- M3-03 step-level exit: **not yet satisfied**; G-01 through G-03 require implementation/evidence, and G-04 requires honest test-oracle traceability.
- This exit reconciliation: **completed and documented**.
- M3-04: **not started; entry gate remains closed**.
- Next eligible action: Product Owner authorization for the bounded Agenda 10 proposal in Section 4.

No production, live database, source acquisition, real data, external service/AI, public surface, deployment or new spend was used or authorized.


## 7. Product Owner authorization and Agenda 10 execution update — 2026-11-14

The Product Owner explicitly authorized the exact bounded Agenda 10 scope described in Section 4. PR #169 was merged as \`799adb9c64f6ad45739b847f4bab80e947f83752\` after both exact-head checks passed.

Agenda 10 implementation is now on \`feature/m3-03-agenda-10-conflicts-rollback\`. The implementation candidate adds first-class persisted conflicts/candidates, pairwise valid-time overlap evaluation, recorded-time provenance without recency winner selection, human adjudication linkage and independent resolution, and a separately audited prior-approved-snapshot rollback delivered through the existing transactional outbox with current-policy rechecks.

The candidate addresses G-01, G-02 and G-03 subject to passing exact-head CI. G-04 remains outstanding: the original T-001–T-032 and GS-001–GS-032 catalogues still require explicit runtime-test/deferral traceability and must not be described as 32 persisted end-to-end workflows. M3-03 remains **IN PROGRESS**; M3-04 remains blocked. Agenda 10 is not closed until its exact-head checks, review reconciliation and expected-head merge are complete.


## 8. Agenda 10 completion reconciliation — 2026-11-14

Agenda 10 is **COMPLETED** for the authorized bounded synthetic local/CI scope. PR [#170](https://github.com/mattari20/listing-v2/pull/170) merged as \`1a4f37303913163a4866f660c469078802a7a4ed\` from exact validated head \`390bead3f28ccc64520d92b7c636455c08fd93a4\`.

Exact-head FND-01 PHP 8.5 foundation CI [#43531770613](https://github.com/mattari20/listing-v2/actions/runs/43531770613) and Project documentation validation [#43531770710](https://github.com/mattari20/listing-v2/actions/runs/43531770710) passed. Synthetic suite: 209 assertions, no failures; 50 non-fatal missing-local-\`.env\` warnings. Review threads were clear, no review submissions were present, and the expected-head SHA merge guard was used.

**Gap disposition:**
- G-01 persisted conflict/candidate lifecycle: **closed** for bounded synthetic scope.
- G-02 valid-time overlap/non-overlap and recorded-time conflict evaluation: **closed** for bounded synthetic scope.
- G-03 explicit prior-approved-snapshot rollback with audit/outbox lineage and current-policy rechecks: **closed** for bounded synthetic scope.
- G-04 deterministic-oracle traceability: **open**. T-001–T-032 and GS-001–GS-032 still require explicit mapping to runtime tests, partial coverage or deferral; the catalogues are not 32 completed end-to-end workflows.

Therefore M3-03 remains **IN PROGRESS**. M3-04 Provider Management entry remains closed until G-04 is reconciled and the complete M3-03 exit criteria are reviewed and accepted. No M3-04 implementation or production/source/external/deployment activity is authorized by this closeout.


## 9. G-04 deterministic oracle traceability reconciliation — 2026-11-14

The full traceability matrix is delivered in [M3-03 G-04 Deterministic Oracle Traceability Reconciliation](M3-03_G04_DETERMINISTIC_ORACLE_TRACEABILITY_RECONCILIATION.md). It maps every T-001–T-032 vector and GS-001–GS-032 case to exact runtime test methods/assertion groups or an explicit partial/deferred disposition.

The matrix confirms that GS-001–GS-032 are grouped policy-level assertions in one test method, not 32 persisted end-to-end workflows. T vectors have mixed coverage: persisted evidence exists for temporal overlap/non-overlap/recorded-time conflict, immutable correction, human adjudication/publication, withdrawal/suppression and prior-snapshot rollback; other vectors are partial or deferred, including relationship validation, public field allowlisting, deterministic normalized validator output, identity merge/split and programme/offer/fee/awarding-body contracts.

**G-04 disposition:** traceability reconciliation delivered; Product Owner acceptance pending. The document recommends accepting the traceability deliverable with its partial/deferred statuses, without accepting the deferred behaviors as implemented. The owner may instead request a separately scoped runtime increment before M3-03 exit.

**M3-03 exit:** remains **IN PROGRESS / NOT ACCEPTED** until the owner explicitly decides the G-04 matrix and the final exit evidence is reviewed. M3-04 Provider Management remains **BLOCKED / NOT STARTED**. No M3-04 implementation is authorized.

No application code, schema, migration, fixture or test assertion changed in G-04. No test suite was rerun. No production, source data/acquisition, external services/AI, V1, Hostinger, public endpoint, deployment, procurement or spend was used or authorized.


## 10. G-04 PR #172 merge and exact-head validation — 2026-11-14

PR [#172](https://github.com/mattari20/listing-v2/pull/172) merged as `f8d9613eec6dca8356b0780ea871245104365736` from exact validated head `0f6f8a961133d1cf3bac5a4f1e0a62b228114c85`.

- Project documentation validation run [#43533801162](https://github.com/mattari20/listing-v2/actions/runs/43533801162): **success**.
- PHP 8.5 foundation CI run [#43533801164](https://github.com/mattari20/listing-v2/actions/runs/43533801164): **success**; 209 assertions, no failures and 50 non-fatal missing-local-`.env` warnings.
- Review threads and review submissions: none; expected-head SHA guard used.

The G-04 traceability deliverable is now merged and validated. This does not grant Product Owner acceptance of M3-03 or of the retained deferred behaviors. M3-03 remains **IN PROGRESS / NOT ACCEPTED** pending the owner's explicit decision and final exit review. M3-04 remains **BLOCKED / NOT STARTED**.
