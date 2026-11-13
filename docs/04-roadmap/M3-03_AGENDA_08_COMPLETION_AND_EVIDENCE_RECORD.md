# M3-03 Agenda 8 — Completion and Evidence Record

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Agenda:** M3-03 Agenda 8 — Transactional Outbox Reliability and Recovery Hardening  
**Disposition:** **COMPLETED** for the bounded, authorized local/CI synthetic implementation scope

## 1. Owner authorization and scope

The Product Owner explicitly authorized Agenda 8 in the current conversation. Work continued from the merged Agenda 7 baseline. The scope was limited to additive outbox lease metadata, local application-service behavior and synthetic SQLite `:memory:` verification.

## 2. Merged implementation

- Pull request [#165](https://github.com/mattari20/listing-v2/pull/165) merged by squash.
- Validated PR head: `e11abda10ed8a2aefe69e66c9740544c9bdb4d2a`.
- Merge commit on `main`: `3f547ca7b925c5445c296c5a6311bac2fa7d744d`.
- Change set: eight files — one service update, one additive migration, one feature-test update, the Agenda 8 scope record and four project-control/index documents.
- No CI workflow, repository ruleset or protection setting was changed.

## 3. Delivered reliability controls

- Added nullable claim-token and claim-timestamp metadata plus a claim lookup index.
- Claims are acquired in a short transaction, transition the event to `processing`, increment attempts and assign a unique fencing token.
- Completion/failure updates require the same active claim token; a reclaimed worker's stale token cannot complete the event.
- Stale processing leases can be reclaimed after the bounded lease interval, covering a worker crash between claim and completion.
- Each event is applied in its own transaction so a failing event does not roll back other events in the batch.
- Failures record bounded error evidence, release the claim and schedule capped exponential retry.
- Events reaching the configured attempt limit move to `dead_letter`; exhausted stale claims are also terminalized.
- Unsupported event types fail closed rather than being silently marked processed.
- Approval/restoration projection processing checks the authoritative snapshot lifecycle and latest snapshot for the same claim-version/surface/audience key.
- Delayed older snapshot events cannot overwrite a newer snapshot.
- A pending approval event cannot resurrect a suppressed snapshot; delayed suppression events do not override a later restored lifecycle state.
- Projection writes remain idempotent under the deterministic projection key.

## 4. Exact-head validation evidence

All validation below applies to exact PR head `e11abda10ed8a2aefe69e66c9740544c9bdb4d2a`.

| Check | Run | Result |
|---|---:|---|
| PHP 8.5 foundation CI | [Run #43527123064](https://github.com/mattari20/listing-v2/actions/runs/43527123064) | **Success** |
| Project documentation validation | [Run #43527123066](https://github.com/mattari20/listing-v2/actions/runs/43527123066) | **Success** |

PHP 8.5 foundation CI completed every configured step successfully: toolchain/SQLite verification, Composer validation and locked install, project documentation validation, dependency audit, Pint formatting, Laravel bootstrap/routes, synthetic-only test suite and repository artifact hygiene. The test step completed successfully. The run summary available for reconciliation did not expose the assertion total, so no assertion count is claimed here.

Project documentation validation passed on the same exact PR head. Review-thread inspection found no unresolved inline threads; no review submissions were present. PR head `e11abda10ed8a2aefe69e66c9740544c9bdb4d2a` was rechecked and merged with an expected-head SHA guard.

## 5. Explicit technical and operational limitations

Agenda 8 does not deliver or claim:
- Production multi-process concurrency or database isolation proof. SQLite `:memory:` tests verify deterministic state transitions only.
- A production queue broker, scheduler, worker fleet, cache, search index, external publisher, metrics, alerting or operator UI.
- Exactly-once external delivery, distributed transaction guarantees or downstream consumer idempotency.
- Production crash recovery, network-partition handling, dead-letter replay tooling or operational reconciliation.
- Public APIs/read endpoints, live directory behavior or deployment.
- Legal/privacy/source-rights/safeguarding/security clearance, retention/deletion approval or real human coverage.
- Production readiness, compliance certification or launch authorization.

The lease/token design is a bounded local implementation seam; production adoption requires database-specific locking/isolation tests, operational ownership, monitoring, dead-letter runbooks, idempotent downstream consumers and separate approval.

## 6. Safety boundary observed

No V1, Hostinger/hPanel, production/live database, real/source/institute/student/child/staff data, source retrieval, scraping, external API/AI, public endpoint, deployment, procurement, new spend, role provisioning or GitHub ruleset/protection change occurred. The migration is additive and validated only through disposable CI SQLite `:memory:` tests.

## 7. Agenda disposition

**Agenda 8:** **COMPLETED** for its bounded authorized local/CI synthetic reliability and recovery scope.  
**M3-03 overall:** remains **IN PROGRESS**; no whole-step weighted completion percentage is claimed.  
**Remaining gates:** production queue/worker operations, multi-process database verification, downstream delivery/reconciliation, real role and human coverage, retention/deletion, specialist legal/privacy/source-rights/safeguarding/security review, public surfaces and deployment remain separate and require their own approvals.
