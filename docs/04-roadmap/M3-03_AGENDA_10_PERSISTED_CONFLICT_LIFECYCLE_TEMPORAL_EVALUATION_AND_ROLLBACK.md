# M3-03 Agenda 10 — Persisted Conflict Lifecycle, Temporal Evaluation and Prior-Snapshot Rollback

**Date:** 2026-11-14  
**Status:** IMPLEMENTATION CANDIDATE — exact-head CI and review pending  
**Repository:** \`mattari20/listing-v2\`  
**Branch:** \`feature/m3-03-agenda-10-conflicts-rollback\`  
**Baseline:** PR #169 merge \`799adb9c64f6ad45739b847f4bab80e947f83752\`

## 1. Authorization and bounded scope

The Product Owner explicitly authorized the exact Agenda 10 scope proposed in the M3-03 exit reconciliation:

- Persisted first-class conflict and candidate records.
- Deterministic valid-time conflict evaluation while preserving recorded-time provenance.
- Human adjudication linkage; no automatic winner or recency-based resolution.
- Explicit rollback to a prior eligible approved publication snapshot.
- New audit and transactional outbox lineage for rollback.
- Current authorization/evidence/policy rechecks before rollback projection.
- Synthetic-only feature tests, exact-head PHP 8.5 foundation CI, Project documentation validation, review reconciliation and expected-head merge guard.

Hard exclusions remain: Listing V1; Hostinger/hPanel; production/live databases; real, source, personal, institute, student, child or staff data; source acquisition; external API/AI; real role provisioning; public endpoints; deployment; procurement; new spend; repository protection changes.

## 2. Delivered implementation candidate

### Persistence

Migration \`2026_11_14_000002_create_persisted_conflicts_and_rollbacks.php\` adds:

- \`claim_conflicts\`: claim-level conflict identity, kind, lifecycle status, deterministic fingerprint, idempotency key, human resolution candidate and adjudication linkage.
- \`claim_conflict_candidates\`: immutable candidate-version references with valid-time bounds, recorded time and value digest.
- \`publication_rollbacks\`: current/target snapshot lineage, human actor, policy version, reason, idempotency and timestamp.

Foreign keys restrict deletion so conflict candidates and rollback history cannot silently disappear with referenced records.

### Temporal conflict evaluation and resolution

\`PersistedConflictAndRollbackService\` accepts a set of claim-version IDs and requires a human actor with the \`evaluate_conflicts\` capability. It verifies that candidates exist, belong to one claim, contain incompatible values, have valid intervals and overlap pairwise in valid time. Non-overlapping assertions are treated as temporal succession and do not create a conflict record.

Recorded-time differences classify the persisted conflict as \`recorded_time_valid_time_overlap\`; they do not select a winning candidate. Every candidate is preserved. A separate human resolver with \`resolve_conflict\` must link a candidate-specific persisted accepted adjudication decision, provide rationale and differ from the adjudicator. Resolution does not delete or rewrite candidate history.

### Prior-snapshot rollback

\`rollbackPublication\` requires a human \`rollback_publication\` capability. It verifies that the target is an older approved snapshot in the same claim-version/surface/audience lineage, that a different current approved snapshot exists, that the rollback actor differs from the original publisher, and that the claim/evidence/source authorization remains eligible under current policy.

The command creates a distinct immutable rollback record, audit event and leased outbox event. The existing outbox worker handles the rollback event. Immediately before projection it rechecks current policy and refuses a stale rollback if the projection has changed since authorization. The historical snapshots remain intact; the projection is redirected to the selected earlier snapshot only through the outbox transaction.

## 3. Synthetic feature evidence added

\`PersistedConflictAndRollbackTest\` covers:

1. Overlapping incompatible assertions with different recorded times; both candidates persist.
2. Non-overlapping assertions; no conflict aggregate is created.
3. Human adjudication linkage and independent human conflict resolution; candidates remain preserved.
4. Automated conflict evaluation and automated rollback denial.
5. Audit failure atomicity for conflict and candidate persistence.
6. Prior approved snapshot rollback with idempotency, audit lineage and outbox projection.
7. Current source-authorization recheck at rollback event processing; revoked authorization prevents projection.

These tests are runtime evidence for the implemented bounded paths, not a claim that all 32 original T-vectors or all 32 GS policy cases are persisted end-to-end workflows.

## 4. Known boundaries and retained gates

- No automated conflict winner, latest-recorded-wins, fuzzy matching or global entity deduplication.
- Conflict evaluation is an explicit bounded service command over supplied claim-version IDs; no scheduler, ingestion, public endpoint or source discovery is introduced.
- No real identity/role provisioning. Capabilities are supplied by the existing synthetic service contract.
- Rollback is limited to an older snapshot in the same claim-version/surface/audience projection lineage. It does not rewrite claim versions, adjudication decisions or prior snapshots.
- Outbox retry/backoff behavior remains the existing bounded synthetic implementation; no production multi-process or external broker guarantee is claimed.
- The full deterministic oracle catalogue still requires traceability reconciliation. Agenda 10 closes the specific persisted conflict, temporal overlap and prior-snapshot rollback gaps identified as G-01 through G-03; G-04 remains a separate M3-03 exit-evidence task.
- M3-04 Provider Management remains blocked until M3-03 exit evidence is complete and accepted.

## 5. Verification and closeout protocol

Before merge:

1. Run PHP 8.5 foundation CI on the exact PR head.
2. Run Project documentation validation on the exact PR head.
3. Inspect test output, review submissions and all review threads.
4. Re-fetch PR head and base; compare exact changed paths and ensure no scope expansion.
5. Merge only with the exact expected head SHA after all required checks pass.
6. Verify merge commit and post-merge main state; record final evidence.

Until that protocol is complete, Agenda 10 is an implementation candidate, not closed.

No production, source data, external service/AI, public endpoint, deployment or spend was used.
