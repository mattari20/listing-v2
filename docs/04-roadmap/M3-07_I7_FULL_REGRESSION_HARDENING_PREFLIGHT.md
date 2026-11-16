# M3-07 I7 — Full Regression and Hardening Preflight

**Date:** 2026-11-16  
**Repository:** mattari20/listing-v2  
**Preflight base:** main 1b4b58442807336bcf9905722b2a59a7a36606c1  
**Branch:** docs/m3-07-i7-regression-hardening-preflight  
**Status:** Scope/design preflight only; test implementation requires separate explicit Product Owner authorization.

## 1. Canonical I7 interpretation

The canonical staged-delivery definition in D5 — Implementation Readiness and Bounded Authorization Proposal, section 3, defines:

**I7 — Full regression and hardening**  
Scope: adversarial, concurrency, migration, rollback, privacy, performance and regression suite.  
Write capability: **test-only**.  
Gate: exact-head acceptance review.

This preflight follows that D5 definition. An older roadmap phrase, “Search and Projection Readiness,” is not the I7 package definition in D5; public profile/projection integration is already part of the delivered I5 scope. I7 must not reopen I5 or add new profile/search functionality.

I7 is a test-hardening package, not live AI-agent readiness, source collection, application feature development or production hardening.

## 2. Verified baseline

- Verified main: 1b4b58442807336bcf9905722b2a59a7a36606c1.
- I6 implementation PR #220 is merged as 8acf05082187f854597aa6dd2d852d64e01e5581.
- I6 documentation closeout PR #221 is merged as the current main commit above.
- PR #221 exact-head FND-01 PHP 8.5 CI #43839629491 and Project documentation validation #43839629559 passed.
- The FND-01 run reported 15 passed test groups, 688 assertions and 164 warnings. The warnings include the existing missing-local-.env test-harness warnings; no .env file is to be created to silence them.
- CI uses PHP 8.5, Composer 2, SQLite in-memory (:memory:) with foreign keys enabled, composer install --no-scripts, composer audit --locked, Pint, Laravel route/bootstrap validation, php artisan test and artifact hygiene.
- Current inventory: 19 test source files (18 feature files and one unit file), 10 migration files and two workflows (fnd-01-ci.yml and project-docs-validation.yml). No production database or Hostinger access was used.

## 3. Existing coverage map

| Area | Existing coverage observed | I7 hardening focus |
|---|---|---|
| I1 registry/read path | Exact-version lookup, unique keys/version numbers, lifecycle/effective dates, applicability, scope separation, reader non-mutation, I1-owned migration down/up | Full migration ordering/fresh-install/rollback coverage and cross-phase registry invariants |
| I2 typed validation | Strict primitive/structured types, bounds, dates, URLs/contact normalization, units, locale, freshness, privacy and fail-closed malformed schemas | Adversarial payload corpus, Unicode/control characters, oversized/nested structures and non-disclosure checks |
| I3 claim/evidence | Exact definition binding, evidence authorization, generic bypass prevention, proposal idempotency, audit/outbox atomicity, correction/withdrawal/reinstatement | Repeated/competing command interleavings, duplicate-key races and broader atomicity failure matrix |
| I4 definition governance | Independent proposer/reviewer/approver/activator, lifecycle, successor/retirement, audit/outbox failure rollback | Competing lifecycle transitions, duplicate approvals/activation attempts and append-only history under retries |
| I5 public profiles | Allowlisted public facts, internal/restricted fact exclusion, exact definition presentation, search/filter/sort flags, source revocation/expiry and Deeni default-OFF | Cross-surface privacy leakage, malicious display values, query growth and stale projection edge cases |
| I6 synthetic agent | Fixed fixture/identity/capability, caller-binding rejection, denied-action audit, human review separation | Expanded hostile/action-shaped input matrix, secret/payload redaction and repeated denied-action edge cases |
| Governance/outbox | Human authorization, publication snapshots, suppression/restore, source revocation, stale lease recovery, retry/backoff/dead-letter and audit rollback | Multi-connection lease/claim contention and more complete rollback/recovery interleavings |
| Conflict/publication rollback | Temporal conflict persistence, independent resolution, audit rollback, publication rollback lineage and current-source recheck | Concurrent resolution/rollback attempts and idempotent duplicate-command contention |
| M3-03/M3-04 | Authority relationships, campuses/programmes, provider assignment, health endpoint, restricted category policy | Cross-phase regression and explicit no-side-effect assertions |

### Observed gaps to close or disposition

1. Existing tests exercise idempotent retries and row-locking service paths, but no explicit multi-connection contention suite was found in the reviewed test inventory.
2. Current CI uses SQLite in-memory. SQLite does not prove the row-lock semantics of a different production database engine; I7 must not claim cross-engine concurrency safety from SQLite-only evidence.
3. The current registry test explicitly checks I1-owned migration down/up. A complete all-migration fresh-install/down/up/reinstall matrix was not found in the reviewed tests.
4. Existing validation and public-directory tests cover several unsafe values and privacy boundaries, but a systematic adversarial corpus spanning I1-I6 (HTML/SQL-like/path strings, Unicode controls, oversized/deep JSON, prompt-injection-like text and secret-bearing payloads) was not found.
5. Query-count/performance regression thresholds for directory search/profile, registry resolution and outbox batches are not documented as measurable CI acceptance budgets.
6. Cross-phase tests should explicitly verify that rejected/failed operations leave no claim, evidence, audit, outbox, publication or projection side effects beyond the specifically required denial audit.

These are preflight findings, not assertions that an application defect exists.

## 4. Exact proposed I7 implementation boundary

### Allowed files

- New or modified test files under tests/Feature/** and tests/Unit/**.
- One new I7 implementation/acceptance record under docs/04-roadmap/**.
- Narrow documentation-only updates to the M3 master step plan, milestone register, progress report, master roadmap, work plan, documentation catalogue, traceability matrix and docs/README.md.

### Explicitly excluded

- All app/** application code, including service/policy/controller/model changes.
- All database/migrations/**, schema, seeders, factories used by runtime, backfills and persistent data.
- composer.json, composer.lock, dependencies and package scripts.
- phpunit.xml, CI workflow files, GitHub Actions permissions and environment configuration.
- Routes, controllers, UI, public API, search/profile feature changes and production configuration.
- Real/provider/student/applicant data, source access, source-owner contact, external URLs, live model/provider, API, connectors, crawlers, browsers, parsers, schedulers, queues, production/V1/Hostinger, deployment, release, procurement or spend.

Test code may create and destroy only synthetic fixtures in disposable in-memory or explicitly temporary test databases. Temporary files must be outside the repository and removed by test teardown.

If a regression test exposes an application defect that requires changing any excluded file, stop. Record the failing reproduction and request a separate corrective authorization; do not change application code under I7's test-only gate.

## 5. I7 test workstreams and acceptance criteria

### A. Full I1-I6 regression

- Re-run the complete existing feature and unit suites, not a selected subset.
- Add cross-phase assertions for exact field-definition version binding, claim/evidence provenance, human separation of duties, immutable history, source authorization, public allowlists, outbox lineage and no autonomous agent publication.
- Verify Deeni Madaris remains default-OFF in policy, search, facets and direct profiles.
- Verify the legacy M3-03/M3-04 paths remain unchanged.
- Verify test fixtures remain synthetic and contain no live source URLs or real personal data.

### B. Adversarial/security input suite

Use only local literal synthetic strings and objects. Cover:

- SQL-like strings, HTML/script markup, unsafe URL schemes, path traversal strings, null bytes and control characters;
- Unicode normalization and malformed/oversized text;
- deeply nested, oversized and unexpected JSON/object/collection members;
- prompt-injection-like text asking the system/agent to ignore rules, invoke tools, publish, alter capabilities or disclose secrets;
- caller-supplied actor, role, capability, action, tool, URL, source payload and extra fields;
- repeated denied privileged actions and idempotency-key reuse with changed payloads.

Assertions must prove inputs are treated as untrusted data, rejected inputs do not create unauthorized writes, no tool/network/model action is possible, public rendering escapes unsafe content, and raw rejected payloads/secrets do not appear in audit metadata, logs, exception messages or public output.

### C. Authorization and separation-of-duties matrix

Exercise human, automated/agent and malformed actor classes against each relevant capability boundary. Verify that the I6 agent capability remains proposal-only and cannot review, adjudicate, publish, suppress, restore, withdraw, correct, alter provider taxonomy or govern field definitions. Verify reviewer, approver, activator, adjudicator and publisher separation remains enforced after duplicate/retried commands.

### D. Concurrency and idempotency

- Test identical duplicate commands, changed-payload key reuse, competing state transitions and outbox lease reclaim.
- Use two independent database connections and deterministic interleavings only where the supported disposable SQLite test setup can demonstrate the intended invariant.
- Do not claim real parallel or production-engine row-lock safety if the SQLite driver cannot prove it.
- No additional database service, driver, package, hosted runner or spend is included. If a true concurrency acceptance case cannot be validated under the approved CI environment, record it as a blocker/limitation and seek separate authorization rather than inventing a pass.

### E. Migration and rollback regression

- Verify all 10 existing migrations apply in order to an empty disposable SQLite database.
- Verify the resulting schema contains the expected tables, constraints, indexes and foreign keys without unexpected tables or modifications.
- Exercise full rollback and re-migration only against a fresh disposable test database; verify the database returns to the expected empty state and can be rebuilt.
- Preserve synthetic fixture/claim history assertions where the migration sequence supports them.
- Never use a shared, staging, production or Hostinger database. Do not edit migrations or claim that a rollback is safe outside the disposable test context.

### F. Privacy and public-surface regression

- Verify internal-only, restricted, stale, withdrawn, suppressed, expired-authorization, superseded, unbound and mismatched-definition facts do not leak through direct profiles, search, facets, filters, sorting, HTML, JSON or error output.
- Verify audit metadata stores only the permitted bounded metadata and does not retain raw secret-bearing or prompt-like payloads.
- Verify Deeni Madaris default-OFF remains fail-closed across every public surface.
- Verify source revocation and withdrawal preserve the existing suppression and audit lineage.

### G. Performance regression

- Use deterministic synthetic fixtures and query-count/iteration-count assertions for registry reads, directory search/profile projections and bounded outbox batches.
- Record baseline query counts on the exact CI environment before setting thresholds.
- Avoid wall-clock pass/fail thresholds that are unstable on shared CI runners.
- No real catalogue data, load-testing service, external benchmark service or paid infrastructure.

## 6. Proposed I7 acceptance gates

- **I7-AC-01:** PR diff is restricted to approved test and documentation paths.
- **I7-AC-02:** complete existing I1-I6 unit/feature regression suite passes.
- **I7-AC-03:** adversarial inputs fail closed without unauthorized writes, unsafe rendering or payload/secret disclosure.
- **I7-AC-04:** fixed I6 agent remains limited to proposal submission; all downstream governance remains human-only.
- **I7-AC-05:** repeated and conflicting idempotency/state-transition cases preserve one authoritative result and correct audit/outbox lineage.
- **I7-AC-06:** concurrency behavior is tested to the limit of the approved SQLite environment; unsupported engine-specific claims are explicitly excluded.
- **I7-AC-07:** all migrations pass fresh disposable SQLite up/down/reinstall checks without editing migration files or touching persistent data.
- **I7-AC-08:** privacy/public projection and Deeni Madaris default-OFF invariants pass across all public surfaces.
- **I7-AC-09:** query-count/performance checks use deterministic synthetic data and documented CI baselines, not arbitrary wall-clock thresholds.
- **I7-AC-10:** no production, real source, external network/model/provider/API/connector/scheduler or new spend is used.
- **I7-AC-11:** PHP 8.5 FND-01 CI and Project documentation validation pass on the exact PR head.
- **I7-AC-12:** implementation record contains exact base/head SHA, test inventory, commands, results, CI run IDs, warning disposition and limitations.
- **I7-AC-13:** any application/schema/dependency/workflow change required by a failing test is stopped and separately authorized, not smuggled into I7.

A failed acceptance criterion blocks I7 closeout. A test that cannot be proven with the current SQLite CI environment must be reported as an open limitation, not silently marked passed.

## 7. Stop conditions

Stop and seek new approval if:

- an application-code or migration change is required to make a regression pass;
- the tests require a different database engine, new dependency, hosted service, external API or additional spend;
- concurrency semantics cannot be validated with the approved local/CI setup;
- performance testing requires a live dataset or infrastructure beyond disposable synthetic fixtures;
- any test would access a real source, institution, student, applicant or provider record;
- a test change weakens or bypasses existing authorization, evidence, audit, publication, privacy or restricted-category controls;
- any production, V1, Hostinger/hPanel, deployment, release or persistent-database action becomes necessary.

## 8. Implementation authorization remains separate

This document authorizes only the I7 scope/design preflight. It does not authorize adding or changing tests yet. The exact test-only implementation boundary, acceptance criteria and limitations above require separate explicit Product Owner approval.

**Proposed authorization statement:**

> I explicitly authorize only M3-07 I7 — Full Regression and Hardening — in mattari20/listing-v2, from the latest verified main, limited to synthetic-only unit/feature tests and the I7 implementation record under tests/Feature/**, tests/Unit/** and docs/04-roadmap/**. The work must cover I1-I6 regression, adversarial/security inputs, capability and separation-of-duties boundaries, idempotency and supported disposable-SQLite concurrency checks, migration/rollback checks on disposable SQLite only, privacy/public-surface invariants, Deeni Madaris default-OFF behavior and deterministic query-count performance checks.

> No application-code, migration/schema, seeder/runtime fixture, dependency/Composer, PHPUnit configuration, CI workflow, route/UI, production/V1/Hostinger, real/source data, source access, external API/model/provider/connector/scheduler, deployment, release, procurement, spend or scope expansion is authorized. If a test exposes a defect requiring an excluded change, stop and request separate authorization. Any concurrency or performance claim that cannot be proven on the existing SQLite CI setup must remain explicitly open, not be reported as passed.

## 9. Preflight disposition

I7 is correctly identified as **Full Regression and Hardening**, a test-only package under D5. I5 already delivered registry-aware public profiles/projection integration; I7 does not add search/profile functionality. The test inventory shows broad existing coverage and clear hardening opportunities, especially systematic adversarial payload/redaction cases, multi-connection contention evidence, complete migration rollback verification and deterministic performance/query-count baselines.

**I7 scope/design preflight: complete.**  
**I7 test implementation: not authorized / not started.**  
**Live source/model/agent activation: remains blocked by G2-G9.**  
**Production/V1/Hostinger/deployment/spend: excluded.**
