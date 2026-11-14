# M3-03 G-04 — Deterministic Oracle Traceability Reconciliation

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `c4b15995e5168fb935052f5b9c4fa9eff55422f4`  
**Status:** **TRACEABILITY RECONCILIATION DELIVERED — PRODUCT OWNER ACCEPTANCE PENDING**  
**Scope:** Repository evidence review and documentation only; no application code or test behavior changed.

## 1. Purpose and decision

This record maps every original Agenda 1 deterministic test vector (T-001–T-032) and every Agenda 5/6 governance service-contract case (GS-001–GS-032) to the current runtime test evidence, partial coverage or an explicit retained deferral.

**Decision:** G-04's traceability deliverable is prepared. It does not claim that all 64 specifications are complete runtime workflows. Runtime evidence is strongest for source authorization, evidence registration, adjudication/publication, claim correction/withdrawal, conflict lifecycle and rollback. Entity relationship validation, public field allowlisting, deterministic normalized validator output, identity merge/split and programme-offer/fee semantics remain unimplemented or unverified in the current bounded runtime scope.

M3-03 remains **IN PROGRESS** pending Product Owner review/acceptance of this reconciliation and the remaining step-level exit evidence. M3-04 Provider Management remains blocked.

## 2. Evidence baseline inspected

- Original oracle specification: `docs/04-roadmap/M3-03_SYNTHETIC_FIXTURES_AND_DETERMINISTIC_TEST_SPEC.md` (32 vectors; specification-only origin).
- Logical model: `docs/04-roadmap/M3-03_LOGICAL_DOMAIN_MODEL_AND_GOVERNANCE.md`.
- Policy/service contract tests: `tests/Feature/GovernanceServiceContractTest.php`.
- Persisted adjudication/publication/outbox tests: `tests/Feature/PersistedGovernanceWorkflowTest.php`.
- Persisted conflict/rollback tests: `tests/Feature/PersistedConflictAndRollbackTest.php`.
- Agenda 9 implementation record: `docs/04-roadmap/M3-03_AGENDA_09_COMPLETION_AND_EVIDENCE_RECORD.md`.
- Agenda 10 implementation record: `docs/04-roadmap/M3-03_AGENDA_10_PERSISTED_CONFLICT_LIFECYCLE_TEMPORAL_EVALUATION_AND_ROLLBACK.md`.
- Agenda 10 exact-head PHP 8.5 foundation CI: run [#43531770613](https://github.com/mattari20/listing-v2/actions/runs/43531770613), success.
- Agenda 10 exact-head Project documentation validation: run [#43531770710](https://github.com/mattari20/listing-v2/actions/runs/43531770710), success.
- Agenda 10 synthetic suite: 209 assertions, no failures; 50 non-fatal missing-local-`.env` harness warnings.

**Interpretation rule:** a test is marked *covered* only where a runtime test exercises the material oracle behavior. *Partial* means an adjacent invariant is tested but the full stated oracle is not. *Deferred* means no matching runtime test or implementation was found in the inspected repository baseline. Policy-only assertions are never represented as persisted end-to-end workflows.

## 3. T-001–T-032 runtime traceability

| Oracle | Runtime evidence / disposition | Assessment |
|---|---|---|
| T-001 provider operates institution with compatible typed endpoints and active interval | No runtime relationship/cardinality/interval validator test identified. | **Deferred** — logical model only |
| T-002 institution-site relationship references missing institution | No runtime relationship endpoint integrity oracle identified. | **Deferred** — logical model only |
| T-003 relationship uses unknown predicate | No runtime relationship-vocabulary validator test identified. | **Deferred** — logical model only |
| T-004 claim valid-from is later than valid-to | `PersistedGovernanceWorkflowTest::test_claim_correction_rejects_invalid_temporal_ranges_and_reused_keys` checks invalid correction intervals; this is narrower than a general claim validator. | **Partial** |
| T-005 incompatible single-valued claims overlap in valid time | `PersistedConflictAndRollbackTest::test_overlapping_incompatible_assertions_persist_both_candidates_and_recorded_time_conflict`. | **Covered** — bounded supplied-candidate set |
| T-006 different assertions have non-overlapping valid intervals | `PersistedConflictAndRollbackTest::test_non_overlapping_different_assertions_are_temporal_succession_not_a_conflict`. | **Covered** — bounded supplied-candidate set |
| T-007 evidence uses revoked/out-of-scope authorization | `GovernanceServiceContractTest::test_source_authorization_fails_closed_for_missing_expired_revoked_or_out_of_scope_grants`; `test_evidence_registration_denies_unapproved_scope_and_content_payloads`; persisted revocation test in workflow suite. | **Covered** — synthetic policy/workflow paths |
| T-008 accepted claim lacks admissible evidence and approved exception | `GovernanceServiceContractTest::test_gs_001_through_gs_032_synthetic_acceptance_contract_matrix` asserts `canAcceptClaim([])` is false; no complete persisted accepted-claim-without-evidence workflow is separately exercised. | **Partial** |
| T-009 evidence supports claim and integrity metadata is present | `GovernanceServiceContractTest::test_evidence_registration_is_metadata_only_quarantined_audited_and_idempotent` checks integrity metadata/quarantine; `test_claim_registration_is_proposed_and_audited_with_quarantined_evidence_linked` checks the evidence link. The evidence remains quarantined, not accepted as proof. | **Partial** |
| T-010 claim version supersedes prior version without deleting history | `PersistedGovernanceWorkflowTest::test_claim_correction_creates_immutable_temporal_successor_with_audit_and_idempotency`. | **Covered** — bounded correction path |
| T-011 newer recorded assertion conflicts with older still-valid assertion; no recency winner | `PersistedConflictAndRollbackTest::test_overlapping_incompatible_assertions_persist_both_candidates_and_recorded_time_conflict` uses different recorded times and preserves both candidates. | **Covered** — explicit candidate set |
| T-012 validation passes but no human adjudication/publication decision exists | `GovernanceServiceContractTest::test_publication_requires_distinct_human_approval_after_adjudication`; `PersistedGovernanceWorkflowTest::test_publication_creates_immutable_snapshot_and_outbox_projection_is_idempotent` requires persisted adjudication before publication. | **Covered** — bounded publication command |
| T-013 claim is disputed or stale | `PersistedGovernanceWorkflowTest::test_disputed_claim_version_is_persisted_and_cannot_be_published`; stale disposition is denied in the GS matrix. Date-expiry evaluation is not separately established. | **Partial** — disputed/stale disposition covered, temporal staleness not fully covered |
| T-014 restricted category default-off suppresses public projection | `GovernanceServiceContractTest::test_restricted_category_visibility_defaults_to_suppressed`; `PersistedGovernanceWorkflowTest::test_deeni_madaris_publication_remains_default_off`. | **Covered** — policy/internal projection boundary, no public endpoint |
| T-015 prohibited personal/contact field appears in public projection | No runtime public-field allowlist/projection payload rejection test identified. | **Deferred** — no public read surface |
| T-016 every published fact traces to accepted claim version and human publication decision | `PersistedGovernanceWorkflowTest::test_publication_creates_immutable_snapshot_and_outbox_projection_is_idempotent` verifies persisted decision, snapshot digest and projection; it does not exhaustively inspect every field's claim provenance. | **Partial** |
| T-017 withdrawal of currently published fact removes current projection and preserves snapshot/audit history | `PersistedGovernanceWorkflowTest::test_claim_withdrawal_suppresses_pending_publication_and_is_idempotent`; `test_withdrawal_of_projected_claim_suppresses_projection_and_blocks_restoration`. | **Covered** — bounded withdrawal/suppression path |
| T-018 rollback selects prior approved snapshot without erasing intervening events | `PersistedConflictAndRollbackTest::test_rollback_creates_new_audit_and_outbox_lineage_to_prior_approved_snapshot`. | **Covered** — bounded same-lineage rollback |
| T-019 material transition missing audit event/reason | Audit failure atomicity is tested by `GovernanceServiceContractTest::test_audit_failure_rolls_back_the_authoritative_evidence_registration` and `PersistedConflictAndRollbackTest::test_conflict_and_candidate_records_roll_back_when_audit_write_fails`; a universal missing-reason rejection oracle is not demonstrated. | **Partial** |
| T-020 repeated identical run yields byte-equivalent normalized findings/outcome | Idempotency is tested in evidence, correction, conflict and rollback commands; no deterministic validator output serialization/repeatability test identified. | **Deferred** — command idempotency is not the specified oracle |
| T-021 programme links to qualification through typed may-lead-to relationship | No programme/qualification runtime model or relationship test identified. | **Deferred** — logical model only |
| T-022 programme offer lacks campus/site or admission-cycle scope | No programme-offer runtime contract/test identified. | **Deferred** — logical model only |
| T-023 fee component omits currency, period or effective-time context | No fee-component runtime contract/test identified. | **Deferred** — logical model only |
| T-024 awarding body inferred from provider/regulator identity without explicit relationship | No awarding-body inference/runtime relationship test identified. | **Deferred** — logical model only |
| T-025 active authorization purpose does not cover requested processing purpose | `GovernanceServiceContractTest::test_gs_001_through_gs_032_synthetic_acceptance_contract_matrix`, GS-004 assertion; also the source-authorization fail-closed test. | **Covered** — policy-level |
| T-026 authorization does not permit requested method | Same GS matrix, GS-003 assertion; source-authorization fail-closed test. | **Covered** — policy-level |
| T-027 authorization territory does not cover requested activity | Same GS matrix, GS-005 assertion; source-authorization fail-closed test. | **Covered** — policy-level |
| T-028 authorization revoked after accepted claim is published | `PersistedGovernanceWorkflowTest::test_source_authorization_revocation_quarantines_evidence_and_freezes_every_dependent_projection`; rollback recheck also tested by `PersistedConflictAndRollbackTest::test_rollback_outbox_rechecks_current_source_authorization_before_projection`. | **Covered** — bounded revocation/suppression workflow |
| T-029 restricted-category flag missing/unknown fails closed | `GovernanceServiceContractTest::test_gs_001_through_gs_032_synthetic_acceptance_contract_matrix`, GS-031 assertion; `test_restricted_category_visibility_defaults_to_suppressed`. | **Covered** — policy-level/internal boundary |
| T-030 identity candidates are retained separately absent human resolution | No identity-candidate persistence or merge-resolution runtime test identified. | **Deferred** — identity resolution workflow not implemented |
| T-031 human-approved identity merge later reversed/split with lineage retained | No identity merge/split event or reversal runtime test identified. | **Deferred** — identity resolution workflow not implemented |
| T-032 stale, withdrawn or superseded version cannot be selected for new publication | Superseded version denial in `PersistedGovernanceWorkflowTest::test_claim_correction_creates_immutable_temporal_successor_with_audit_and_idempotency`; withdrawn denial in `test_withdrawal_of_projected_claim_suppresses_projection_and_blocks_restoration`; stale disposition denial in GS matrix. | **Partial** — superseded/withdrawn/stale disposition guards; no full temporal freshness evaluator |

## 4. GS-001–GS-032 policy/runtime traceability

All GS cases are currently concentrated in one method: `GovernanceServiceContractTest::test_gs_001_through_gs_032_synthetic_acceptance_contract_matrix`. The method contains grouped assertions and is **policy-level verification**, not 32 separate test methods or 32 persisted end-to-end workflows.

| GS cases | Assertion mapping in the matrix | Runtime meaning / limitation |
|---|---|---|
| GS-001 | Line 240: missing authorization rejected | Policy-level deny-by-default |
| GS-002 | Line 241: expired authorization rejected | Policy-level time check |
| GS-003 | Line 242: disallowed method rejected | Policy-level method scope |
| GS-004 | Line 243: mismatched purpose rejected | Policy-level purpose scope |
| GS-005 | Line 244: mismatched territory rejected | Policy-level territory scope |
| GS-006 | Line 245: publication scope denied | Policy-level separate permission |
| GS-007 | Line 248: quarantined evidence cannot support a claim | Policy-level evidence admissibility |
| GS-008 | Line 249: quarantined evidence cannot be accepted | Policy-level claim acceptance |
| GS-009 | Line 250: proposed claim cannot be published | Policy-level publication gate |
| GS-010 | Line 251: two different values produce a conflict candidate result | Deterministic policy helper only; not persisted lifecycle |
| GS-011 | Line 254: empty evidence set cannot be accepted | Policy-level missing-provenance check |
| GS-012 | Line 257: actor without capability is denied | Policy-level capability check |
| GS-013 | Line 258: publisher cannot also be listed as the collector | Policy-level separation check |
| GS-014 | Line 259: automated actor cannot publish | Policy-level human-only gate |
| GS-015 | Line 260: publisher cannot be the adjudicator | Policy-level separation check |
| GS-016 | Line 261: non-current version cannot be published | Policy-level version-current guard |
| GS-017 | Line 262: empty surface is rejected | Policy-level publication context |
| GS-018 | Line 263: empty policy version is rejected | Policy-level policy traceability |
| GS-019 | Line 264: inadmissible evidence blocks publication | Policy-level evidence gate |
| GS-020 | Line 267: old/new differing values are detected as a conflict | Deterministic policy helper only; persisted temporal behavior is separately tested in Agenda 10 |
| GS-021 | Line 268: eligible-for-review evidence may pass acceptance policy | Policy-level positive case |
| GS-022 | Line 269: stale claim disposition blocks publication | Policy-level stale-state guard |
| GS-023 | Line 270: non-current version blocks publication | Policy-level supersession guard |
| GS-024 | Line 271: revoked authorization blocks acquisition | Policy-level revocation check |
| GS-025 | Line 274: restricted category false is not public | Policy-level suppression |
| GS-026 | Line 275: same suppressor cannot restore | Policy-level actor separation |
| GS-027 | Line 276: distinct human can restore when policy allows | Policy-level positive restoration case |
| GS-028 | Line 277: evidence withdrawal denied without required retention/authority state | Policy-level withdrawal guard |
| GS-029 | Line 278: public read denied when projection is not approved | Policy-level read boundary |
| GS-030 | Line 279: public read allowed when projection is approved | Policy-level positive read case |
| GS-031 | Line 280: unknown restricted-category state is suppressed | Policy-level fail-closed behavior |
| GS-032 | Line 281: explicit false restricted-category state remains suppressed under restricted policy | Policy-level suppression |

The line references above are the current `main` file's source lines. If the test file changes, update these references in a later reconciliation.

## 5. Explicit deferrals and non-claims

The following are retained as deferred or partial; they are not silently treated as passed:

1. Entity/relationship endpoint and predicate validation (T-001–T-003).
2. General temporal claim validation beyond correction command range checks (T-004 partial).
3. Complete accepted-claim provenance path and admissible evidence promotion (T-008/T-009 partial).
4. Full temporal staleness evaluation and exhaustive per-field publication provenance (T-013/T-016/T-032 partial).
5. Public payload field allowlisting (T-015).
6. Universal audit reason/event enforcement (T-019 partial).
7. Deterministic validator finding serialization and byte-equivalent rerun output (T-020).
8. Programme/qualification/offer/fee/awarding-body runtime contracts (T-021–T-024).
9. Identity candidate/merge/split/reversal lifecycle (T-030/T-031).
10. Any public HTTP/API read surface, production queue behavior, real identity/role provisioning, real source data or production database behavior.

No new application tests were added because G-04 was authorized as a traceability reconciliation, not an implementation expansion. Any conversion of deferred vectors into runtime behavior requires a separately scoped authorization and must preserve M3-04's entry gate.

## 6. Remaining risk and exit assessment

| Item | Status | Required next action |
|---|---|---|
| G-01 persisted conflict lifecycle | Closed for bounded synthetic scope | No further work in this agenda |
| G-02 temporal conflict evaluation | Closed for bounded synthetic scope | No further work in this agenda |
| G-03 prior-snapshot rollback | Closed for bounded synthetic scope | No further work in this agenda |
| G-04 deterministic-oracle traceability | **Reconciliation delivered; Product Owner acceptance pending** | Review this matrix and explicitly accept, reject or request additional scoped tests |
| M3-03 step exit | **IN PROGRESS** | Complete final exit review after owner disposition of G-04 and retained partial/deferred risks |
| M3-04 Provider Management | **BLOCKED / NOT STARTED** | Do not begin until M3-03 is accepted and separate M3-04 authorization is recorded |

**Recommendation:** accept G-04 as a completed traceability deliverable with the partial/deferred statuses above, subject to Product Owner review. Do not interpret this recommendation as acceptance of the deferred requirements or authorization to implement them.

## 7. Safety and execution boundary

This reconciliation inspected only V2 repository documentation and synthetic test source. No test suite was rerun as part of this documentation-only pass. No code, schema, migration, fixtures, test assertions, workflow, branch protection or repository settings were changed.

No Listing V1, Hostinger/hPanel, production/live database, real/source/personal/institute/student/child/staff data, source acquisition, external API/AI, real role provisioning, public endpoint, deployment, procurement or new spend was accessed or authorized.

## 8. Product Owner decision record

**Owner decision:** Pending.  
**Decision requested:** accept the G-04 traceability record as complete with the explicit partial/deferred cases above, or identify which deferred cases should be separately scoped for implementation before M3-03 exit.  
**M3-03 acceptance:** not granted by this document.  
