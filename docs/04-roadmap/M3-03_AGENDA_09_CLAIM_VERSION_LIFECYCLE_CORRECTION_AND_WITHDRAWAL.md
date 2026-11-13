# M3-03 Agenda 9 — Claim Version Lifecycle, Correction and Withdrawal

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Status:** Implementation candidate — exact-head validation and closeout pending  
**Baseline:** M3-03 Agendas 1–8 merged on `main`

## 1. Objective

Complete the missing bounded claim-version lifecycle behavior required by the M3-03 exit criteria: temporal successor creation, immutable correction lineage, explicit disputed disposition, and audited withdrawal that suppresses every dependent publication snapshot/projection.

This agenda is limited to repository-local application code, fabricated synthetic fixtures and disposable SQLite `:memory:` verification. It does not activate real source handling or public delivery.

## 2. Delivered candidate

- Add a human-capability-gated correction command that creates a new immutable claim version, links it to its predecessor using `supersedes_version_id`, assigns the next version number, records a bounded effective-date interval and requires eligible synthetic evidence references.
- Preserve the predecessor's value and version row; reject a second successor and prevent publication of a superseded version through the existing publication guard.
- Bind correction idempotency keys to a stable command fingerprint; reject key reuse for changed correction content.
- Add a human-capability-gated withdrawal command with audited reason/rationale and idempotent command handling.
- Withdrawal changes the version disposition to `withdrawn`, records a suppression for each dependent snapshot, immediately freezes existing projections and queues suppression events so pending approval events cannot resurrect withdrawn content.
- Existing adjudication outcome `disputed` remains the explicit persisted conflict disposition; disputed versions cannot pass publication authorization.

## 3. Synthetic acceptance coverage

- Correction creates a new temporal successor and preserves predecessor content.
- Correction evidence links and audit lineage are persisted.
- Exact correction retries are idempotent; changed reuse of the key is rejected.
- Invalid or reversed effective-date ranges are rejected.
- A superseded predecessor cannot be published.
- Disputed adjudication remains explicit and cannot be published.
- Withdrawal is idempotent and suppresses a pending approval before projection.
- Withdrawal suppresses an already projected record and blocks restoration while the claim remains withdrawn.

## 4. Explicit limitations and deferrals

- No new conflict table or automated conflict-resolution process is introduced. Conflict remains a human adjudication outcome `disputed`; automated matching never resolves it.
- Effective dates are recorded on successor versions. This bounded increment does not invent a global temporal-overlap policy or rewrite predecessor validity.
- Evidence must already exist as an eligible synthetic evidence reference; no evidence content is fetched, copied or ingested.
- No real role/account provisioning, legal/privacy/source-rights/safeguarding/security sign-off, retention/deletion policy, public endpoint, production queue, deployment or launch is included.
- SQLite `:memory:` tests do not prove production locking, multi-process concurrency or downstream delivery guarantees.

## 5. Safety boundary

No V1, Hostinger/hPanel, production/live database, real/source/institute/student/child/staff data, source retrieval, scraping, external API/AI, public endpoint, deployment, procurement, new spend or GitHub ruleset/protection change is included. No persistent local database is created.

## 6. Acceptance and closeout

Exact-head PHP 8.5 foundation CI and Project documentation validation must both pass. Review threads must be clear, the exact PR head rechecked and merge guarded by the expected head SHA. The completion record must identify the validated head, checks, merge commit and any residual limitations.

**Agenda 9 remains in progress until those conditions are evidenced and merged. M3-03 overall remains in progress.**
