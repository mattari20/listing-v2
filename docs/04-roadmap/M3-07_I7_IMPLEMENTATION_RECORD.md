# M3-07 I7 — Full Regression and Hardening Implementation Record

**Date:** 2026-11-16  
**Repository:** mattari20/listing-v2  
**Base:** `main` at `690d7d108af7bca2ea71e43c705a3c72db41c958`  
**Branch:** `test/m3-07-i7-regression-hardening`  
**Authorization:** Explicit Product Owner authorization received 2026-11-16 for synthetic-only tests under `tests/Feature/**`, `tests/Unit/**` and I7 implementation documentation.  
**Status:** Implemented, exact-head validated, merged in PRs #224 and #225, and reconciled across project control documents.

## 1. Authorized boundary

I7 follows the canonical D5 definition: **Full Regression and Hardening**, with test-only write capability.

The implementation is limited to:
- synthetic-only unit/feature tests;
- the I7 implementation record under `docs/04-roadmap/**`.

No application code, migration/schema, seeder/runtime fixture, Composer/dependency, PHPUnit configuration, CI workflow, route/UI, production/V1/Hostinger, real/source data, external API/model/provider/connector/scheduler, deployment, release, procurement or additional spend is included.

The new migration exercise creates a uniquely named temporary SQLite file under the system temporary directory, uses only that disposable file, and removes it in a `finally` block. No repository database artifact is created.

## 2. Baseline and repository inventory

- Base `main`: `690d7d108af7bca2ea71e43c705a3c72db41c958`.
- Existing test inventory at preflight: 19 test source files (18 feature, one unit); I7 adds one feature test file, for 20 total source files (19 feature, one unit).
- Verified migration inventory: 11 migration files (the preflight's initial count of 10 was corrected after the disposable migration test observed 11 applied migrations).
- Existing CI workflows: FND-01 PHP 8.5 foundation CI and project documentation validation.
- Existing test environment: SQLite in-memory with foreign keys enabled.
- No change to Composer files, PHPUnit configuration, migrations or CI workflows.

## 3. I7 additions

### 3.1 Public surface, hostile values and query-count regression

Updated `tests/Feature/PublicDirectoryTest.php` with:

- `test_public_html_is_escaped_and_hostile_registry_metadata_or_values_are_excluded`: uses synthetic HTML/script-shaped display data, hostile registry presentation metadata and a script-shaped long-text value. It asserts display escaping and exclusion of invalid registry label/value content.
- `test_public_directory_query_count_is_constant_as_synthetic_result_count_grows`: records database queries for a one-result synthetic directory and a five-result synthetic directory, then asserts equal query counts. This is a deterministic query-count comparison, not a wall-clock performance guarantee.

Existing coverage retained, including public allowlists, internal/restricted/mismatched/unbound fact exclusion, stale/suppressed/revoked/expired publication exclusion, exact definition-version presentation, and Deeni Madaris fail-closed behavior even when the enabling configuration is set true.

### 3.2 Agent boundary and adversarial bindings

Updated `tests/Feature/SyntheticAgentProposalAdapterTest.php` with:

- `test_malformed_nested_oversized_and_prompt_injection_bindings_fail_closed_and_are_not_audited_raw`: exercises oversized identifiers, nested evidence arrays, over-limit evidence lists, duplicate evidence IDs and prompt-injection-like action text. It verifies no claim/editorial/publication/projection writes and verifies that the denied-action audit stores only the bounded action code/reference, not the hostile raw text.

Existing I6 tests remain in place for the fixed fixture identity, fixed capability, caller-supplied actor/capability rejection, human-only review, proposal-only behavior and repeated denied-action handling.

### 3.3 Full disposable-SQLite migration cycle and independent connection check

Added `tests/Feature/I7DisposableSqliteMigrationTest.php`:

- creates a fresh disposable SQLite database file outside the repository;
- runs all 11 migrations and verifies the expected core tables and SQLite foreign-key integrity;
- opens a second independent PDO connection to the same disposable SQLite file and verifies the unique outbox idempotency key cannot be duplicated across those connections;
- holds an immediate SQLite write transaction on the first connection, sets the peer connection's busy timeout to zero, and verifies the peer write is rejected with a database-lock error and leaves no row behind;
- rolls back the complete migration batch, verifies the domain tables are absent and the migration ledger is empty;
- re-runs all migrations and repeats the schema/foreign-key checks;
- purges connections and removes the temporary database file in `finally`.

The cross-connection checks cover SQLite's unique-key enforcement and deterministic database-level writer-lock contention. They do **not** exercise simultaneous application service commands, establish row-lock correctness for another database engine or prove production-engine concurrency safety. No unsupported concurrency guarantee is claimed.

## 4. Acceptance-gate disposition

| Gate | I7 disposition |
|---|---|
| I7-AC-01 — approved path boundary | **Pass:** PR #224 changed only the I7 record and two existing test files plus one new feature test; PR #225 changed only that test and record. No excluded path changed |
| I7-AC-02 — complete I1-I6 regression | **Pass:** final exact-head suite 15 passed, 761 assertions |
| I7-AC-03 — adversarial/security inputs | **Pass:** hostile HTML/registry metadata, control/oversized text, SQL-like/path/null/bidi identifiers, nested/oversized/duplicate bindings and prompt-like action payloads all passed fail-closed/redaction assertions |
| I7-AC-04 — proposal-only agent/human governance | **Pass:** existing I6 proposal-only/human-review separation suite plus new hostile-binding regression passed |
| I7-AC-05 — idempotency and lineage | **Pass:** existing I1-I6 idempotency/audit/outbox regressions passed; independent SQLite connection confirms outbox idempotency-key uniqueness |
| I7-AC-06 — concurrency | **Supported SQLite checks pass:** independent connections verify unique-key enforcement and writer-lock contention. Simultaneous application service-command races and other-engine row-lock semantics remain explicitly open and unclaimed |
| I7-AC-07 — disposable migration rollback/reinstall | **Pass:** all 11 migrations fresh-install, full reset/rollback and re-install on a temporary SQLite file; expected tables and foreign-key checks passed |
| I7-AC-08 — privacy/public projection/Deeni default-OFF | **Pass:** existing public allowlist, suppression/revocation/expiry, internal/restricted facts and Deeni default-OFF tests passed; hostile rendering assertions passed |
| I7-AC-09 — deterministic query-count regression | **Pass:** one-result versus five-result query counts matched. No wall-clock or production-scale guarantee is claimed |
| I7-AC-10 — no production/source/external services/spend | **Pass:** no production/source/external service access or spend occurred |
| I7-AC-11 — exact-head CI | **Pass:** PR #224 and PR #225 both passed FND-01 PHP 8.5 CI and project documentation validation on their exact heads |
| I7-AC-12 — implementation evidence | **Pass:** exact base/head/merge SHAs, CI run IDs, test counts, warning disposition, changed-file scope and limitations are recorded below |
| I7-AC-13 — stop on excluded defect | **Pass:** no test required an excluded application/schema/dependency/workflow change; no excluded file was modified |

## 5. Known limitations and stop conditions

- SQLite's independent-connection checks establish unique-key enforcement and database-level writer-lock contention only. They do not establish simultaneous application service-command safety or row-lock semantics on another database engine. Those claims remain open.
- The query-count test compares two deterministic synthetic fixture sizes on the configured test connection. It does not establish latency, throughput, memory or production-scale capacity.
- Migration rollback/reinstall is scoped strictly to a temporary SQLite file. It is not evidence that rollback is safe against shared, staging, production or Hostinger databases.
- If any new test fails because application behavior violates the expected invariant, do not edit `app/**`, migrations, Composer, PHPUnit configuration or workflows under I7. Preserve the failing reproduction and request separate corrective authorization.
- Do not weaken a test to conceal a failure.
- G2-G9 remain blocking for live source access and live model/agent activation.

## 6. Exact-head validation and closeout

### PR #224 — initial I7 regression hardening

- URL: https://github.com/mattari20/listing-v2/pull/224
- Base: `690d7d108af7bca2ea71e43c705a3c72db41c958`
- Exact validated head: `cd4a21c790b933f99567a6760260d914c4a09983`
- Merge commit: `6efd9a4d29067c3e0dea11ada8ae01266f2d33b2`
- FND-01 PHP 8.5 CI [run #43850465461](https://github.com/mattari20/listing-v2/actions/runs/43850465461): **success**.
- Project documentation validation [run #43850465611](https://github.com/mattari20/listing-v2/actions/runs/43850465611): **success**.
- Suite: 15 passed, 759 assertions, 168 warnings.

### PR #225 — SQLite writer-lock contention extension

- URL: https://github.com/mattari20/listing-v2/pull/225
- Base: `6efd9a4d29067c3e0dea11ada8ae01266f2d33b2`
- Exact validated head: `a31a78141b93bc5da2545ff49991d166f56c5f50`
- Merge commit / verified main: `167ec4cad05926569bebda6aadac207166782235`
- FND-01 PHP 8.5 CI [run #43850848377](https://github.com/mattari20/listing-v2/actions/runs/43850848377): **success**.
- Project documentation validation [run #43850848331](https://github.com/mattari20/listing-v2/actions/runs/43850848331): **success**.
- Final suite: **15 passed, 761 assertions, 168 warnings**.
- Pint, Composer manifest validation, dependency audit, Laravel bootstrap/routes and repository artifact hygiene passed.
- All 11 migrations applied, fully rolled back and re-applied on the temporary SQLite file; foreign-key checks returned no violations. The independent-connection uniqueness and writer-lock contention assertions passed.

### Warning disposition

The 168 warnings are the test harness's missing-local-`.env` `file_get_contents` warnings. The preflight baseline showed 164 warnings of this class; the final run reports 168 after the four added test methods. No `.env` file was created, changed or committed. There were no test failures.

### Final scope and limitations

Across both PRs, the unique changed-file set is:
- `tests/Feature/PublicDirectoryTest.php`
- `tests/Feature/SyntheticAgentProposalAdapterTest.php`
- `tests/Feature/I7DisposableSqliteMigrationTest.php`
- `docs/04-roadmap/M3-07_I7_IMPLEMENTATION_RECORD.md`

No `app/**`, migration/schema, Composer/dependency, PHPUnit configuration, CI workflow, route/UI, production/V1/Hostinger, source data, external service, deployment or spend changes occurred. The migration test uses only a temporary SQLite file removed in `finally`.

The SQLite checks establish unique-key enforcement and database-level writer-lock contention only. They do not establish simultaneous application service-command safety or row-lock semantics on other database engines. Those unsupported claims remain open.

**Final disposition:** I7 is implemented, exact-head validated and merged for the approved synthetic/local/CI scope. All supported acceptance gates pass. The SQLite/application-level and cross-engine concurrency limitations remain explicit. G2-G9 continue to block live source access and live model/agent activation. I7 does not authorize I8, live activation, production work or scope expansion.
