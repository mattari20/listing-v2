# RCV-B07 — Bounded Synthetic Performance Measurement Authorization

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Baseline main:** 538259bb47475579722fc2b4877d94e9a5e9e8d4  
**Branch:** feat/rcv-b07-synthetic-performance-harness  
**Status:** Product Owner-approved measurement policy; this exact local/CI synthetic measurement slice is authorized.

## 1. Purpose

Produce a reproducible, low-cost baseline for the existing anonymous directory read paths using only the repository's existing fictional seven-entity SQLite preview fixture. The report is a diagnostic local/CI microbenchmark, not representative national traffic, Hostinger capacity, production performance or an SLO.

## 2. Exact authorized work

- Add a PHPUnit feature-level measurement harness using the existing PrivatePreviewDirectorySeeder in the disposable in-memory SQLite testing database only.
- Exercise stable synthetic HTTP GET scenarios: directory landing, text search, manual locality filter, category filter, later pagination page, one fictional profile and session-only comparison.
- Use a warm-up request and a fixed repeated sample count per scenario; measure in-process request elapsed time with a monotonic clock, SQL query count, HTTP status and rendered response byte count.
- Report p50/p95/p99 diagnostic quantiles, sample count, query-count median, response-byte median, fixture count, PHP version, database driver and exact Git revision when CI supplies it.
- Emit a machine-readable JSON summary to test output for CI log capture.
- Assert functional HTTP success and non-empty response only. Do not assert absolute timing, throughput or concurrency thresholds.
- Record the sample limitations and repeatability method in the implementation record.
- Keep the benchmark test in the normal PHP 8.5 synthetic CI suite so its report can be captured without a new service or dependency.

## 3. Dataset and workload limits

- Dataset available in this authorized slice: exactly seven fictional entities from PrivatePreviewDirectorySeeder (two institutions, two programmes, one provider, one campus and one qualification).
- Use no real institution names, source content, URLs, addresses, personal data or scraped/public data.
- This harness is sequential, single-process, warm-request measurement only. It does not measure concurrency, cold-cache behavior, CPU saturation, memory peaks, network latency or browser rendering.
- Medium/stress dataset tiers are not fabricated by multiplying preview records. They remain deferred until a separately reviewed fixture-expansion design proves safe, deterministic scaling.
- Percentiles from this small sample are descriptive only and must not be used as SLO thresholds.

## 4. Exact expected files

- tests/Feature/SyntheticDirectoryMeasurementTest.php — synthetic-only request measurement harness.
- docs/04-roadmap/RCV-B07_PERFORMANCE_MEASUREMENT_RECORD_2026-11-20.md — workload definition, limits and captured result.

No production application runtime behavior, routes, database schema or migrations are changed in this slice.

## 5. Explicit exclusions

- No production/Hostinger/V1 access, deployment, public URL, external load generator, network traffic, concurrent load or production telemetry.
- No new dependency, vendor, paid service, analytics, monitoring service or spend.
- No real/source/institution/student/guardian/staff data or external data acquisition.
- No numeric SLO adoption, capacity claim, hosting decision or infrastructure change.
- No changes to query service, database schema, cache configuration, publication eligibility, rate limits or public behavior.
- No sitemap generation or public indexing activation.

## 6. Validation

- Exact-head FND-01 PHP 8.5 CI and Project documentation validation must pass.
- The full suite must remain green; benchmark timing must not determine pass/fail.
- Capture the JSON report and record environment, exact head, fixture count, scenario sample count, timing quantiles, SQL counts and response bytes.
- Merge automatically after exact-head checks pass; update the roadmap and evidence catalogue after merge.

## 7. Interpretation

These measurements describe only a synthetic seven-entity SQLite in-memory test environment. They cannot be extrapolated to a shared host, production MySQL, real traffic, larger data volumes, concurrent users or service availability. Numeric SLOs remain unset pending a separately approved representative workload and capacity evidence.