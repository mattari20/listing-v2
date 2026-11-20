# RCV-B07 — Synthetic Performance Measurement Record

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Branch:** feat/rcv-b07-synthetic-performance-harness  
**Status:** IMPLEMENTED AND MERGED in PR #337 as `049cb60fd8f60b6486450a88c9d4e8d8e176e656`; no SLO or capacity claim.

## 1. Authorization and purpose

This record implements the bounded synthetic measurement authorization. The purpose is to create a repeatable local/CI diagnostic baseline for existing public directory read paths without a paid service, external load generator, new dependency, real data or production access.

## 2. Dataset

- Existing PrivatePreviewDirectorySeeder only; exactly seven fictional entities: two institutions, two programmes, one provider, one campus and one qualification.
- The seeder runs in the disposable in-memory SQLite testing database under the testing environment.
- No additional fixture data is created, and no source/public institution data is used.
- Medium and stress tiers remain deferred. This sample must not be described as representative of national coverage or expected production scale.

## 3. Workload scenarios

1. Anonymous directory landing.
2. Text search.
3. Manual locality filter.
4. Category filter.
5. Page-two pagination request (empty page under the seven-entity fixture; exercises the page-two route/render path only).
6. Fictional institution profile read.
7. Session-only comparison of two fictional programme entries.

Each scenario uses one warm-up request followed by three measured sequential requests.

## 4. Captured metrics

- In-process HTTP-kernel elapsed time using PHP's monotonic high-resolution clock; p50/p95/p99 are nearest-rank descriptive quantiles.
- SQL query count per measured request and nearest-rank median.
- Uncompressed rendered HTML response bytes and nearest-rank median.
- HTTP status is asserted successful for every request.
- Report includes exact CI revision when GITHUB_SHA is present, PHP version, database driver, fixture count and concurrency (one sequential request at a time).

Timing, query and byte summaries are emitted as a machine-readable JSON line in the test log. The harness asserts only successful responses, non-empty HTML and report structure. It does not assert wall-clock thresholds.

## 5. Limitations

- This is a warm, sequential, in-process SQLite microbenchmark. It excludes network latency, TLS, reverse proxy, shared-host behavior, production MySQL, browser rendering, real user traffic, cold cache, concurrent load, CPU saturation, memory peaks and operational availability.
- Three samples per scenario are too small for contractual percentile targets. Reported p95/p99 are diagnostic only.
- The page-two case is empty because the fixture contains seven entities and the application page size is 20.
- No medium/stress dataset is available in this slice. Do not extrapolate these measurements to larger catalogues.
- No numeric SLO or production capacity statement is adopted. M2-S09 remains a proposal only.

## 6. Validation

PR #337 head `7648c4bf6916eec5290b8f997c0be35e5f1c2be8` merged as `049cb60fd8f60b6486450a88c9d4e8d8e176e656`. FND-01 PHP 8.5 CI #44654818077 and Project documentation validation #44654818021 passed. The CI job ran on generated PR merge ref `61d2d16be55b6d0897631dccbb15490efe717ee8`, which contains the exact PR head and base `538259bb47475579722fc2b4877d94e9a5e9e8d4`. Full suite: 15 passed, 1,419 assertions, 274 non-fatal warnings.

## 7. Captured diagnostic results

Environment: PHP 8.5.13, SQLite in-memory, seven fictional entities, one warm-up plus three measured requests per scenario, concurrency 1. Latency values are milliseconds; response bytes are uncompressed HTML. Quantiles use nearest-rank samples and are descriptive only.

| Scenario | p50 ms | p95 ms | p99 ms | Median SQL queries | Median HTML bytes |
|---|---:|---:|---:|---:|---:|
| Directory landing | 4.256 | 4.400 | 4.400 | 6 | 13,550 |
| Text search | 3.688 | 3.690 | 3.690 | 5 | 9,189 |
| Manual locality filter | 3.711 | 3.730 | 3.730 | 5 | 10,501 |
| Category filter | 4.508 | 5.063 | 5.063 | 6 | 8,423 |
| Page-two request | 4.062 | 4.077 | 4.077 | 6 | 10,589 |
| Profile read | 1.920 | 1.982 | 1.982 | 2 | 5,582 |
| Session comparison | 3.742 | 3.754 | 3.754 | 6 | 11,288 |

Machine-readable JSON was emitted in FND-01 run #665. The full suite passed. Existing rate limits were preserved; an initial larger sample run correctly hit HTTP 429, so the final harness uses a smaller throttle-safe sample count. No rate limit was bypassed or weakened.

These measurements are a tiny warm in-process SQLite diagnostic only. They are not production/Hostinger latency, not a concurrency/capacity test, not browser metrics and not an SLO. M2-S09 remains unapproved.