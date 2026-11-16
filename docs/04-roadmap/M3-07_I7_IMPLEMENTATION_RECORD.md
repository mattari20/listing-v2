# M3-07 I7 — Full Regression and Hardening Implementation Record

**Date:** 2026-11-16  
**Repository:** mattari20/listing-v2  
**Base:** `main` at `690d7d108af7bca2ea71e43c705a3c72db41c958`  
**Branch:** `test/m3-07-i7-regression-hardening`  
**Authorization:** Explicit Product Owner authorization received 2026-11-16 for synthetic-only tests under `tests/Feature/**`, `tests/Unit/**` and I7 implementation documentation.  
**Status:** Implementation prepared; exact-head CI and acceptance review pending.

## 1. Authorized boundary

I7 follows the canonical D5 definition: **Full Regression and Hardening**, with test-only write capability.

The implementation is limited to:
- synthetic-only unit/feature tests;
- the I7 implementation record under `docs/04-roadmap/**`.

No application code, migration/schema, seeder/runtime fixture, Composer/dependency, PHPUnit configuration, CI workflow, route/UI, production/V1/Hostinger, real/source data, external API/model/provider/connector/scheduler, deployment, release, procurement or additional spend is included.

The new migration exercise creates a uniquely named temporary SQLite file under the system temporary directory, uses only that disposable file, and removes it in a `finally` block. No repository database artifact is created.

## 2. Baseline and repository inventory

- Base `main`: `690d7d108af7bca2ea71e43c705a3c72db41c958`.
- Existing test inventory at preflight: 19 test source files (18 feature, one unit).
- Existing migration inventory: 10 migration files.
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
- runs all 10 migrations and verifies the expected core tables and SQLite foreign-key integrity;
- opens a second independent PDO connection to the same disposable SQLite file and verifies the unique outbox idempotency key cannot be duplicated across those connections;
- rolls back the complete migration batch, verifies the domain tables are absent and the migration ledger is empty;
- re-runs all migrations and repeats the schema/foreign-key checks;
- purges connections and removes the temporary database file in `finally`.

The independent-connection assertion is a sequential uniqueness/constraint check. It is **not** evidence of simultaneous command contention, row-lock correctness or production-engine concurrency safety. No unsupported concurrency guarantee is claimed.

## 4. Acceptance-gate disposition

| Gate | I7 disposition |
|---|---|
| I7-AC-01 — approved path boundary | Pending final PR diff review; intended diff is tests plus this record only |
| I7-AC-02 — complete I1-I6 regression | Pending exact-head PHP 8.5 CI |
| I7-AC-03 — adversarial/security inputs | Added hostile public output and agent binding tests; pending CI |
| I7-AC-04 — proposal-only agent/human governance | Existing I6 tests retained; additional hostile binding test added; pending CI |
| I7-AC-05 — idempotency and lineage | Existing I1-I6 idempotency/audit/outbox tests retained; SQLite cross-connection uniqueness added; pending CI |
| I7-AC-06 — concurrency | **Partially evidenced only:** independent SQLite connections verify a unique-key constraint. Simultaneous service-command contention and other-engine row-lock semantics remain open |
| I7-AC-07 — disposable migration rollback/reinstall | Full 10-migration temporary-SQLite test added; pending CI |
| I7-AC-08 — privacy/public projection/Deeni default-OFF | Existing tests retained; hostile output assertions added; pending CI |
| I7-AC-09 — deterministic query-count regression | One-result versus five-result equality assertion added; pending CI. No wall-clock or scale guarantee |
| I7-AC-10 — no production/source/external services/spend | No such access or spend authorized or included |
| I7-AC-11 — exact-head CI | Pending |
| I7-AC-12 — implementation evidence | This record; exact head, CI IDs and final warning disposition to be added after validation |
| I7-AC-13 — stop on excluded defect | No application/schema/dependency/workflow edits are authorized; any such defect remains a separate gate |

## 5. Known limitations and stop conditions

- SQLite's independent-connection uniqueness check does not establish true concurrent service-command safety, row-lock semantics or cross-engine behavior. Those claims remain open.
- The query-count test compares two deterministic synthetic fixture sizes on the configured test connection. It does not establish latency, throughput, memory or production-scale capacity.
- Migration rollback/reinstall is scoped strictly to a temporary SQLite file. It is not evidence that rollback is safe against shared, staging, production or Hostinger databases.
- If any new test fails because application behavior violates the expected invariant, do not edit `app/**`, migrations, Composer, PHPUnit configuration or workflows under I7. Preserve the failing reproduction and request separate corrective authorization.
- Do not weaken a test to conceal a failure.
- G2-G9 remain blocking for live source access and live model/agent activation.

## 6. Exact-head validation and closeout

To be completed after the implementation PR reaches its final head:
- PR number, URL, exact head SHA and merge SHA;
- changed-file path audit;
- PHP 8.5 FND-01 workflow run ID and result;
- project documentation validation run ID and result;
- complete test count, assertion count and warning disposition;
- any failed/open acceptance gates and explicit limitations.

**Current disposition:** I7 test additions and implementation record prepared within the approved scope. Exact-head CI and acceptance review are pending. I7 is not closed until all supported acceptance gates pass and the SQLite limitations above remain explicitly recorded.
