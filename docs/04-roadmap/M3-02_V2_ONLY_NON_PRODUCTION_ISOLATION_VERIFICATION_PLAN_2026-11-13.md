# M3-02 — V2-Only Non-Production Isolation Verification Plan

**Prepared:** 2026-11-13  
**Repository:** mattari20/listing-v2  
**Planning baseline:** `main` at `32400720778f7becf6bc2abb79b02b1dcc47fca4`  
**Status:** Plan prepared; execution on hosting is NOT authorized  
**Purpose:** Define a safe, no-spend method to collect objective evidence that a future V2 non-production runtime is isolated from V1 and production.

## 1. Authorization boundary

This document authorizes planning and repository-only documentation work. It does **not** authorize access to or changes in:

- Hostinger, hPanel, SSH, SFTP, DNS, hosting file manager, cron, deployment tools or live service endpoints;
- V1 application files, V1 configuration, V1 databases, shared hosting settings or production resources;
- any database server, database credentials, database configuration, schema, migrations, seeds, connections or database commands;
- production, staging connected to production, real users, or real/source/personal/student/child/institute/staff data;
- external APIs, AI/model providers, telemetry destinations, paid services, new infrastructure or spend.

No deployment, upload, DNS change, file write on hosting, service restart, migration, database access, or live smoke test is permitted by this plan. A later execution stage requires a separate, explicit Product Owner authorization that names the exact V2-only target, access method, allowed read/write actions, time window and stop conditions. Authorization for this plan is not that authorization.

## 2. Verification principles

1. **V2-only:** Every path, repository, environment variable, hostname, document root, process and artifact under review must be positively identified as belonging to V2. Ambiguous or shared resources are out of scope.
2. **Non-production:** Use only local development or an explicitly provisioned V2-only non-production environment. Never infer that a resource is non-production from its name.
3. **No V1 dependency:** V2 must not read, write, include, mount, query, authenticate against, or otherwise depend on V1 files, configuration, database, sessions, caches, queues, storage or secrets.
4. **No database:** The verification is deliberately database-free. Do not create or inspect database configuration or credentials, run database commands, or test a database connection. Any requirement that cannot be proved without a database remains open.
5. **Synthetic-only:** Fixtures must be fabricated, non-identifying and clearly marked synthetic. Do not copy production data or V1 data.
6. **No spend:** Prefer existing local/Codespaces and existing repository CI. No new hosting plan, add-on, domain, paid scanner, monitoring service or API.
7. **Evidence over assumption:** Record commands, exact target identity, sanitized output, timestamps and commit SHA. Redact secrets and personal data. A missing observation is “not verified”, never “passed”.
8. **Fail closed:** Stop if V2 identity, isolation boundary, access permission or non-production status is unclear.

## 3. Scope and phases

### Phase A — Repository-only static boundary review (permitted now)

Perform against the V2 repository and its Git history only:

- Record repository identity, default branch, exact commit SHA and working-tree state.
- Inventory tracked application paths, public/document-root assumptions, bootstrap and runtime entry points.
- Review configuration examples and documentation for environment-specific paths, hostnames, credentials, secrets, shared storage, shared cache/session/queue assumptions and accidental V1 references.
- Review CI workflows for permissions, secret usage, artifact handling and accidental deployment behavior.
- Confirm no production data, credentials, V1 configuration, database connection material or generated runtime artifacts are committed.
- Confirm default application behavior remains database-independent; do not add database configuration or probe framework/database services.
- Record any ambiguous path, shared-resource assumption or undocumented dependency as a finding, not as an assumption of isolation.

**Exit evidence:** a commit-pinned static inventory and findings list. This phase cannot prove runtime/document-root/host isolation.

### Phase B — Local/Codespaces non-production boundary verification (only within existing authorized local workspace)

This phase may be executed only in an existing local or Codespaces workspace that the user already controls, without touching hosting or V1:

- Confirm the checked-out directory and Git remote identify `mattari20/listing-v2`; record branch and commit.
- Confirm PHP and Composer versions against the repository's declared requirements.
- Install only dependencies already declared in the committed lockfile; do not add packages or use external services.
- Use synthetic local environment values only. Never copy any `.env`, secret or configuration from V1 or hosting.
- Inspect effective non-secret application configuration and verify debug, logging, session, cache, queue and filesystem defaults are appropriate for local testing.
- Confirm no networked service or database is required by the foundation test suite. Do not run commands that connect to, create, migrate, seed or inspect a database.
- Run the repository's documented database-free test and static validation commands only. Capture exit codes and sanitized output.
- Verify generated files remain within the V2 workspace and are not written to a V1 path or shared location.
- Verify no deployment workflow is triggered and no remote service is contacted.

**Exit evidence:** repeatable local command log, test results, exact commit and sanitized configuration assertions. This demonstrates only local/Codespaces isolation.

### Phase C — V2-only non-production runtime isolation (NOT AUTHORIZED; future separate approval required)

If and only if a distinct V2-only non-production runtime is later explicitly authorized, the proposed verification should be limited to that named target:

1. Positively identify the target as V2-only and non-production before inspection. If it shares an account, filesystem, document root, credentials, database, cache, sessions, queue, storage or runtime with V1, stop and report the boundary as unproven.
2. Confirm the V2 document root resolves only to the intended V2 public entry point. Confirm no V1 directory is an ancestor, alias, symlink target, include path or writable target.
3. Confirm V2 environment/configuration files are separate, not copied from V1, not web-accessible, and not stored in the repository. Do not reveal secret values; record only presence/absence and ownership/boundary metadata.
4. Confirm V2 session, cache, queue, file storage and log paths are distinct from V1 and production. If any service is shared or cannot be identified without database access, stop and mark the relevant criterion unverified.
5. Confirm V2 hostname/routing and TLS configuration do not point at or overwrite V1. No DNS change or deployment is part of this plan.
6. Perform only an explicitly approved, non-mutating health check against the named V2 non-production endpoint. Do not probe V1 or production. The existing `GET /health` response must not disclose secrets, environment details or personal data.
7. Check resource capacity using only available, non-invasive metadata for the V2 target. Do not run load tests, stress tests, benchmarks that can affect shared resources, or paid monitoring.
8. Document backup/recovery ownership and a no-write recovery procedure. Do not initiate backups, restore, failover or recovery actions under this plan.
9. Stop immediately on evidence of shared V1 resources, production routing, unexpected writes, database access, cost impact, or unclear ownership.

**Exit evidence:** target identity, V2-only path/routing evidence, isolated configuration/storage/cache/session/log boundaries, sanitized health response, capacity evidence, recovery procedure and a signed no-impact attestation. If any item cannot be collected safely, retain the blocker.

### Phase D — Evidence reconciliation

- Map each observation to the M3-02 environment-isolation criterion.
- Distinguish repository/local evidence from runtime/hosting evidence.
- List inaccessible or unverified boundaries explicitly.
- Record deviations and remediation options without implementing them.
- Update the M3-02 acceptance pack only after evidence is reviewed.
- Do not close M3-02 solely because the plan exists or local tests pass.

## 4. Required evidence register

| Evidence ID | Evidence required | Allowed source | Pass condition | If unavailable |
|---|---|---|---|---|
| ISO-01 | Repository and commit identity | V2 Git repository | Exact repository and SHA recorded | Stop; identity unproven |
| ISO-02 | Tracked path/configuration review | V2 repository | No V1/production path, secret or dependency found | Record finding; do not infer isolation |
| ISO-03 | Local runtime/toolchain | Existing local/Codespaces | Supported PHP/Composer versions recorded | Record as not verified |
| ISO-04 | Synthetic environment defaults | Local V2 workspace | No V1 values; safe local defaults | Stop and correct only under separate code-change scope |
| ISO-05 | Database-free tests | Existing V2 CI/local tests | Tests pass without database connection/configuration | Keep database-dependent criterion unverified; do not access DB |
| ISO-06 | V2 document-root separation | Named V2-only non-production target | Public root maps only to V2 public entry point | Requires separate target-specific authorization |
| ISO-07 | Config/secrets separation | Named V2-only target metadata | V2-only, non-web-accessible; no V1 reuse | Requires separate authorization; never expose values |
| ISO-08 | Storage/session/cache/queue/log separation | Named V2-only target metadata | No shared V1/production paths or services | Stop if shared or ambiguous |
| ISO-09 | Routing/health | Named V2-only target | Non-mutating health response from V2 only | Requires separate authorization |
| ISO-10 | Capacity | Non-invasive target metadata | Adequacy evidenced without load/stress testing or spend | Defer if unavailable |
| ISO-11 | Recovery readiness | Documented procedure and ownership | Recovery path documented; no restore executed | Defer; do not claim recoverability |
| ISO-12 | No-impact attestation | Evidence review | No V1/production/DB writes, deployment or spend | Any uncertainty blocks acceptance |

## 5. Stop conditions

Stop the activity immediately and do not attempt workarounds if:

- the target could be V1, production, or a shared resource;
- V2 cannot be positively distinguished from V1;
- a step requires database access, database credentials, migrations, seeds or DB configuration;
- a step requires SSH, hPanel, hosting, DNS, deployment or live access not separately authorized;
- a command may write outside the isolated V2 workspace or change shared settings;
- real/source/personal/student/child/institute/staff data or secrets appear;
- external APIs, AI providers, telemetry destinations, paid services or new spend are required;
- evidence is incomplete, ambiguous or cannot be safely collected.

Report the exact blocked evidence ID and reason. Do not bypass the restriction.

## 6. Acceptance rules for the M3-02 isolation criterion

The criterion may be marked **verified** only when all applicable evidence IDs ISO-01 through ISO-12 have objective, reviewable evidence for the agreed target. Repository-only and local/Codespaces evidence cannot substitute for runtime document-root, hosting configuration, capacity or recovery evidence.

If hosting/runtime evidence cannot be collected within the no-spend and no-V1 boundaries, the correct disposition is **deferred / not verified**, with an explicit Product Owner risk decision. Do not silently waive the criterion or call M3-02 closed.

## 7. Current status and next authorized action

- This document is a plan, not evidence that V2 is isolated.
- Phase A and Phase B are repository/local-only and remain subject to the user's normal workspace control.
- Phase C is not authorized.
- No Hostinger, V1, production, SSH, hPanel, DNS, deployment or database access has been performed or authorized.
- No infrastructure, service, external API or spend is introduced.
- M3-02 remains **in progress / not accepted / not closed** until the required-check governance issue and environment-isolation evidence or an explicit documented risk disposition are resolved, and the Product Owner records final acceptance.
