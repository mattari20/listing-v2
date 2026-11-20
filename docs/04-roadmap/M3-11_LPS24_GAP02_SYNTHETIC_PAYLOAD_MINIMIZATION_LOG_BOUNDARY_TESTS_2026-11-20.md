# M3-11 LPS-24 — GAP-02 Synthetic Payload Minimization and Log Leakage Boundary Tests

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `3e3417d4377e8015d2dfcf1bf7ece0fb8506c999` (main after LPS-23 merge)  
**Agenda:** LPS-24 — synthetic payload minimization and log leakage boundary tests  
**Status:** **TESTS ADDED — CI VALIDATION PENDING**

## 1. Purpose

LPS-24 addresses a bounded subset of GAP-02 DLR-06: ensure the existing structured log-context processor discards unapproved payload-bearing context and accepts only its explicitly allowlisted correlation metadata. The tests use fictional marker strings only.

This agenda does not claim that all application payload persistence, log messages, exception traces, external log channels, queues, caches, files or runtime stores are safe. It does not implement a universal data-loss-prevention filter.

## 2. Implementation

Added `tests/Unit/SafeLogPayloadBoundaryTest.php` with three focused tests:

1. **Nested and unapproved context removal:** supplies synthetic claim values, publication snapshot payload, outbox payload, last-error text, rationale, audit metadata and request-body markers; verifies that only valid `event_code` and `correlation_id` survive the processor.
2. **Allowlist bounds:** verifies that overlong event codes and malformed correlation identifiers are discarded, and arbitrary keys are not retained.
3. **Message boundary:** explicitly verifies that the processor does not rewrite log message text. This is an important limitation: callers must author messages without secrets, personal data or copied source payloads. Passing this test is not evidence that message text is sanitized.

The implementation relies on the existing `App\Logging\SafeLogContextProcessor`; no production behavior, dependencies, configuration, retention values or runtime services were changed.

## 3. Validation and evidence

- Synthetic-only test fixtures; no real data.
- No database or migration execution.
- No log files, session contents, cache, queue, storage, backups or hosted systems inspected.
- No external API, AI/model/provider, source retrieval, deployment or additional spend.
- GitHub Foundation CI and documentation validation must both pass on the exact PR head before merge.

The test source is present in the PR. **Execution result remains PENDING until exact-head CI completes.** No local test execution is asserted.

## 4. Known limits and follow-up

- The processor filters structured context only; it intentionally does not sanitize the message string.
- The current test does not prove every log channel uses this processor, nor that runtime configuration selects the expected channel.
- It does not inspect exceptions, framework request logging, reverse-proxy/access logs, external telemetry or provider copies.
- It does not prove that database JSON/text payloads are minimized at write time.
- Separate LPS-25 call-site mapping and LPS-26 synthetic lifecycle verification remain required.

## 5. Acceptance disposition

- [x] Synthetic payload markers supplied in structured context are discarded by the existing processor.
- [x] Allowlisted correlation metadata bounds and format are tested.
- [x] Message-text limitation is explicitly tested and documented.
- [ ] Exact-head Foundation CI passes.
- [ ] Exact-head documentation validation passes.
- [ ] GAP-02 payload minimization is complete end-to-end — NOT ESTABLISHED.
- [ ] GAP-02 closure — NOT ACCEPTED.

**Final disposition:** LPS-24 is complete as a bounded test addition only after exact-head checks pass. GAP-02 remains OPEN / NOT CLOSED. M3-11 Gate 02 remains BLOCKED / NOT ACCEPTED. All other M3-11 gate dispositions remain unchanged. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
