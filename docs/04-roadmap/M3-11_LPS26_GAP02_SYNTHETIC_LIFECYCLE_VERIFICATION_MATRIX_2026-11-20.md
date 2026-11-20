# M3-11 LPS-26 — GAP-02 Synthetic Lifecycle Verification Matrix

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `6f8b6b9ca8a591915eb29a96899f30be0fb91003` (main after LPS-25 merge)  
**Agenda:** LPS-26 — synthetic lifecycle verification  
**Status:** **EXISTING COVERAGE RECONCILED; SUPPRESSED-ROLLBACK REGRESSION TEST ADDED; CI PENDING**

## 1. Purpose and boundary

LPS-26 consolidates the existing synthetic feature tests for correction, publication, suppression, withdrawal, projection visibility, rollback, outbox behavior and saved-item removal. It adds one regression test ensuring that a suppressed historical snapshot cannot be selected as a rollback target while a newer approved projection remains current.

All fixtures are synthetic and use the disposable test database. No live database, real record, source, hosted environment, backup, export, processor or external service was accessed. No retention schedule, deletion policy or real-data deletion implementation is created by this agenda.

## 2. Lifecycle verification matrix

| Lifecycle stage | Existing test evidence | LPS-26 disposition |
|---|---|---|
| Claim creation and evidence linking | `CoreGovernancePersistenceTest`, `PersistedGovernanceWorkflowTest` | Synthetic create/link paths covered |
| Claim correction | `PersistedGovernanceWorkflowTest::test_claim_correction_creates_immutable_temporal_successor_with_audit_and_idempotency`; `PublicDirectoryTest::test_superseded_claim_version_is_not_returned_even_before_successor_publication` | Successor lineage and stale public-value exclusion covered |
| Publication snapshot/projection | `PersistedGovernanceWorkflowTest::test_publication_creates_immutable_snapshot_and_outbox_projection_is_idempotent` | Snapshot/projection creation and idempotency covered |
| Suppression | `PersistedGovernanceWorkflowTest::test_suppression_freezes_projection_and_distinct_human_can_restore_after_recheck`; `PublicDirectoryTest::test_suppressed_projection_is_removed_from_search_and_direct_profile` | Suppression and public query exclusion covered; restoration is an explicit separate action |
| Source authorization revocation | `PersistedGovernanceWorkflowTest::test_source_authorization_revocation_quarantines_evidence_and_freezes_every_dependent_projection`; programme-fact revocation test | Synthetic revocation propagation into governed projection state covered |
| Pending outbox event after suppression | `PersistedGovernanceWorkflowTest::test_pending_approval_event_cannot_resurrect_a_suppressed_snapshot` | Stale pending projection event is prevented from resurrecting suppressed snapshot |
| Snapshot ordering | `PersistedGovernanceWorkflowTest::test_only_latest_snapshot_for_a_surface_is_projected_when_older_event_is_pending`; `PublicDirectoryTest::test_older_snapshot_is_hidden_while_a_newer_snapshot_is_not_yet_projected` | Older snapshot precedence covered |
| Rollback | `PersistedConflictAndRollbackTest::test_rollback_creates_new_audit_and_outbox_lineage_to_prior_approved_snapshot`; authorization recheck test | Approved historical rollback and revalidation covered; suppressed-target regression added in LPS-26 |
| Programme-fact correction | `ProgrammeOfferFactWorkflowTest::test_correction_supersedes_previous_public_value_for_the_same_offer_fact` | Synthetic fact successor and public value supersession covered |
| Programme-fact withdrawal | `ProgrammeOfferFactWorkflowTest::test_withdrawal_suppresses_an_existing_public_offer_fact` | Synthetic withdrawal/suppression path covered |
| Saved-item removal | `AccountSavedItemsTest::test_owner_can_save_view_and_remove_a_currently_published_entity_idempotently`; account cascade test | Narrow saved-row removal covered; not full account erasure |
| Outbox retries/dead-letter | `PersistedGovernanceWorkflowTest` retry/backoff/dead-letter tests | Workflow reliability metadata covered; not a retention/expiry policy |

## 3. New regression test

Added `test_suppressed_snapshot_cannot_become_a_rollback_target` to `tests/Feature/PersistedConflictAndRollbackTest.php`.

The synthetic scenario:
1. Creates a fictional claim with eligible metadata-only synthetic evidence.
2. Publishes two successive snapshots for the same directory surface.
3. Suppresses the older snapshot.
4. Verifies the newer snapshot remains the approved projection.
5. Attempts to roll back to the suppressed snapshot and expects a validation rejection.
6. Verifies no rollback record is created and the current projection remains unchanged.

This test checks a specific resurrection hazard. It does not prove all correction/deletion paths, external caches, exports, backups or other downstream systems are synchronized.

## 4. Important interpretation

- **Correction is not erasure:** predecessor claim/fact versions and governance history remain.
- **Suppression is not deletion:** records are status-marked and public query paths filter them; the underlying snapshot/payload remains stored.
- **Rollback is a visibility operation:** the new regression test prevents a suppressed snapshot from being a rollback target, but does not prove that all historical or duplicated copies are removed.
- **Saved-item removal is narrow:** it deletes one saved user/entity relation, not all account, session, cache, log or backup data.
- **Outbox dead-letter is not retention:** retry state and last-error fields still need an approved lifecycle policy.
- **Synthetic test success is not hosted evidence:** no production or hosted behavior is asserted.

## 5. Validation

- New test added to the existing feature suite; no dependencies or runtime configuration changed.
- Foundation CI and documentation validation must pass on the exact PR head.
- Test execution result remains pending until GitHub Actions reports success for this revision.
- No local test execution is claimed.

## 6. Acceptance disposition

- [x] Existing synthetic lifecycle tests reconciled against the LPS-23 schema inventory and LPS-25 call-site map.
- [x] Correction/supersession and public stale-value behavior mapped.
- [x] Suppression and public projection exclusion mapped.
- [x] Pending outbox resurrection guard mapped.
- [x] Programme-fact correction and withdrawal coverage mapped.
- [x] Saved-item removal scope bounded.
- [x] New suppressed-snapshot rollback rejection regression test added.
- [ ] Exact-head Foundation CI passes.
- [ ] Exact-head documentation validation passes.
- [ ] Complete deletion/erasure propagation established — NOT ESTABLISHED.
- [ ] Retention/backup expiry policy approved — NOT RECEIVED.
- [ ] GAP-02 closure — NOT ACCEPTED.

**Final disposition:** LPS-26 is complete as a synthetic lifecycle test reconciliation and targeted regression addition only after exact-head checks pass. GAP-02 remains **OPEN / NOT CLOSED**. M3-11 Gate 02 remains BLOCKED / NOT ACCEPTED; all other gate dispositions remain unchanged. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
