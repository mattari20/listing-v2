# M3-03 Agenda 8 — Transactional Outbox Reliability and Recovery Hardening

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Status:** Implementation candidate; exact-head validation and merge evidence pending  
**Authorization:** Product Owner explicitly authorized Agenda 8 in the current conversation.

## 1. Objective and bounded scope

Harden the existing synthetic/local transactional outbox seam delivered in Agenda 7. The goal is to make claim ownership, retry, stale-worker recovery, dead-letter disposition, event ordering and suppression behavior explicit and testable.

This agenda remains local/CI-only. It does not configure or operate a production queue, scheduler, worker fleet, cache, search index, external publisher or public endpoint.

## 2. Delivered candidate

- Additive migration adds a per-claim token and claim timestamp to the existing outbox; existing event payloads and idempotency keys are retained.
- Event claiming occurs in a short transaction, transitions eligible events to `processing`, increments attempts and assigns a unique claim token.
- A worker may only complete or fail an event while its claim token still matches, fencing a previous worker after lease reclamation.
- Events left in `processing` beyond the bounded lease are eligible for reclamation after a worker crash.
- Event application is isolated per event transaction so a failed event does not roll back successful neighboring events in the batch.
- Failed events record a bounded error message and receive capped exponential retry delay; the configured attempt limit moves a terminal failure to `dead_letter`.
- Unknown event types fail closed instead of being silently marked processed.
- Approval/restoration projection checks current snapshot lifecycle state and the latest snapshot for the same claim version, surface and audience. A delayed older event cannot overwrite a newer snapshot.
- Suppression projection is applied only while the authoritative snapshot remains suppressed; stale suppression events cannot undo a later restoration.
- A pending approval event cannot recreate a projection after the snapshot has been suppressed.
- Projection writes are keyed and idempotent; a duplicate event does not create duplicate projection rows.

## 3. Acceptance and synthetic verification

The Agenda 8 candidate adds tests for:
- Claim lease metadata migration.
- Recovery of a stale processing claim after a simulated worker crash.
- Failure capture, retry scheduling and claim release.
- Terminal dead-letter disposition.
- Pending approval versus emergency suppression ordering.
- Latest-snapshot-wins behavior when multiple snapshots are pending for the same surface/audience.
- Existing idempotent projection behavior and source-revocation/suppression regressions.

The repository's PHP 8.5 foundation CI and project documentation validation must pass on the exact PR head. Review threads must be clear and the exact head must be rechecked before merge. A completion record will capture the final head, CI run IDs, test assertion count, review state and merge SHA.

## 4. Explicit limitations

- SQLite `:memory:` tests verify deterministic state transitions, not production multi-process locking or database isolation behavior.
- A lease and claim token provide a bounded fencing/recovery design; they do not prove a production worker's crash, network partition, queue broker or downstream delivery behavior.
- No exactly-once external delivery is claimed. External effects require a separate idempotent consumer contract and reconciliation.
- Dead-letter inspection/replay tooling, alerting, operator UI, scheduler, production queue broker, metrics and runbooks remain future operational work.
- No public projection/read endpoint is introduced.

## 5. Safety boundary

No V1, Hostinger/hPanel, production/live database, real/source/institute/student/child/staff data, source retrieval, scraping, external API/AI, public endpoint, deployment, procurement, new spend, role provisioning or GitHub ruleset/protection change is included. The migration is additive and is validated only by disposable CI SQLite `:memory:` tests.

## 6. Agenda disposition

**Agenda 8:** In progress pending exact-head PHP 8.5 foundation CI, documentation validation, review reconciliation and merge.  
**M3-03 overall:** remains **IN PROGRESS**; no whole-step weighted completion percentage is claimed.
