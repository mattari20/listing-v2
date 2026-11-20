# RCV-B07 — Synthetic Performance Measurement Record

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Branch:** feat/rcv-b07-synthetic-performance-harness  
**Status:** Harness submitted for exact-head validation; no SLO or capacity claim.

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

Pending exact-head PHP 8.5 CI and project documentation validation. After CI, append the exact head, run IDs, test count/assertions/warnings and a captured sample summary.