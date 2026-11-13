# M3-02 Phase D — Evidence Reconciliation and Isolation Disposition

**Prepared:** 2026-11-13  
**Repository:** `mattari20/listing-v2`  
**Reconciliation baseline:** `main` at `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`  
**Related evidence:** PR #143 (merged); PR #144 (open draft; checks passed); Product Owner-provided Codespaces command output  
**Scope:** Evidence reconciliation only; documentation-only  
**Decision:** **Phase D reconciliation prepared; M3-02 remains NOT READY FOR ACCEPTANCE OR CLOSURE**

## 1. Executive result

Phase D reconciles the repository-only Phase A review, the V2-only isolation plan, and the local/Codespaces Phase B checks completed in the existing user-controlled workspace.

This report is deliberately limited to evidence that was actually observed:

- PR #143, which adds the V2-only non-production isolation plan, is merged into `main` as `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`.
- PR #144 records the Phase A static isolation review. It remains an open draft PR, not merged. Both exact-head checks passed: `PHP 8.5 foundation checks` and `Validate project control documents`.
- Phase B was run in the existing Codespaces workspace on branch `m3-02-phase-b-verification`, at commit `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`. The user-provided outputs show successful local prerequisites, PHP syntax checks, Composer platform checks, PHPUnit assertions and a local-only HTTP health response.
- The local workspace was returned to a clean Git state. The temporary local server was stopped, the two identified generated view-cache files were removed, and `composer.json` / `composer.lock` remained unchanged.

These results improve the local/CI evidence but do not establish hosting/runtime isolation, document-root mapping, capacity, recovery, or full GitHub branch-protection enforcement.

## 2. Phase A and Phase B evidence

### 2.1 Phase A — repository-only static review

PR #144: https://github.com/mattari20/listing-v2/pull/144

- Head: `2c54a8fe4a6754933725a1a9f2431a2ac2da8d97`
- Base: `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`
- State: open, draft, unmerged
- Exact-head checks:
  - `PHP 8.5 foundation checks`: success (run #43420173206)
  - `Validate project control documents`: success (run #43420173024)

The review records no tracked `.env`, `config/database.php`, `database/` directory, database artifact, or obvious direct V1 runtime reference in the inspected snapshot. The Laravel front controller is in `public/`, but actual hosting document-root mapping is not observable from repository files. Optional database-backed framework configuration templates exist but are not selected by the reviewed local/test defaults. This static review is limited to the current repository snapshot and does not prove runtime isolation or exhaustively audit history.

### 2.2 Phase B — local/Codespaces verification

**Workspace identity reported by the user**

- Repository directory: `/workspaces/listing-v2`
- Branch: `m3-02-phase-b-verification`
- HEAD: `1479fbba6edbf10e668ab57bcdf3a6bdd49f1ae2`
- Final `git status --short`: empty

**Toolchain and dependency evidence**

- PHP: `8.4.27`
- Composer: `2.10.3`
- Manifest requirement: PHP `^8.3`; local PHP satisfies the declared constraint.
- CI workflow uses PHP 8.5; exact local/CI runtime parity was therefore not established.
- `composer validate --no-check-publish`: passed.
- `composer check-platform-reqs --lock`: passed.
- Composer install used the existing lockfile with `--no-interaction --prefer-dist --no-progress --no-scripts --no-plugins`, after explicit user authorization. It installed 110 packages, with zero updates and zero removals. Composer manifest and lockfile remained unchanged.
- 21 tracked PHP files passed `php -l`.

**Test evidence**

- PHPUnit executed 5 test methods and 17 assertions, with no failed assertions or test errors.
- PHPUnit reported 5 warnings because Laravel's optional `.env` lookup caused a warning when the file was absent. The warning was traced to the vendor Dotenv reader. No `.env` file was created and no vendor file was modified.
- The warning is retained as a qualification; this report does not describe the test run as warning-free.

**HTTP smoke evidence**

The local server was bound to `127.0.0.1:18765` and started with synthetic environment values, including a synthetic `APP_KEY`. The local `GET /health` response was:

```json
{
  "status": "ok",
  "application": "estudent-institutes-v2",
  "foundation": "fnd-01"
}
```

The earlier HTTP 500 was caused by the standalone local server lacking an application key; the retry with synthetic environment variables succeeded. No `.env` file was created.

**Cleanup and no-change evidence**

- Remaining local server process on port 18765 was stopped.
- Only the two identified generated Laravel view-cache files were removed.
- Final `git status --short` was empty.
- `git diff --exit-code -- composer.json composer.lock` passed.
- No application source, tracked configuration, dependencies, or Git history were changed by the local verification.

## 3. ISO-01 through ISO-12 evidence register

| ID | Evidence area | Reconciled disposition | Basis / limitation |
|---|---|---|---|
| ISO-01 | Repository and commit identity | **Pass for repository/local scope** | V2 remote/workspace identity and exact main/workspace SHA recorded. |
| ISO-02 | Tracked paths and configuration review | **Pass for inspected current snapshot** | Phase A static review found no tracked `.env`, database config/directory/artifact, or obvious direct V1 runtime reference. Not a historical or runtime attestation. |
| ISO-03 | Local runtime/toolchain | **Pass with parity qualification** | PHP 8.4.27 and Composer 2.10.3 recorded; manifest and lock platform checks passed. CI uses PHP 8.5, so exact parity is not established. |
| ISO-04 | Synthetic environment defaults | **Pass for local/test defaults; runtime hosting unknown** | PHPUnit and local HTTP test used synthetic values; no `.env` was created. Static config review supports safe local defaults. |
| ISO-05 | Database-free tests | **Pass with warning qualification** | PHPUnit: 5 test methods / 17 assertions, no failures/errors, 5 benign missing-`.env` warnings. CI foundation checks passed on PR #144 exact head. No database command or connection was used. |
| ISO-06 | V2 document-root separation | **Not verified** | Repository places front controller in `public/`; actual host document-root mapping was not inspected. |
| ISO-07 | Runtime config/secrets separation | **Not verified at hosting runtime** | No hosting secrets/config were accessed. Local synthetic key was process-only and not saved to `.env`. |
| ISO-08 | Storage/session/cache/queue/log separation | **Partial — local defaults only** | Local/test defaults and generated view-cache location were observed inside the V2 workspace. Hosting and shared-resource boundaries remain unverified. |
| ISO-09 | Routing/health | **Pass for local-only smoke test** | Local `GET /health` returned the exact expected response on loopback. No hosted endpoint was tested. |
| ISO-10 | Capacity | **Not verified** | No hosting/runtime capacity metadata or load test was collected. |
| ISO-11 | Recovery readiness | **Not verified** | No runtime backup ownership, restore evidence or recovery exercise was performed. |
| ISO-12 | No-impact attestation | **Pass for this Phase A/B activity only** | No V1, Hostinger, production, SSH, hPanel, DNS, deployment or database access occurred; no production writes or new spend. Composer package installation was limited to the authorized local lockfile install. |

## 4. M3-02 exit criteria — updated disposition

| Exit criterion | Updated evidence | Status |
|---|---|---|
| Reproducible local/CI build | CI checks and local Composer/platform/syntax/test evidence | **Met for foundation scope, with local PHP-version and PHPUnit-warning qualifications** |
| Protected PR checks | Existing ruleset audit; PHP foundation CI runs but is not yet confirmed as a required ruleset check | **Partial / open** |
| Configuration and secret boundaries | Repository, PHPUnit and synthetic local process environment reviewed | **Met for local/CI scope only** |
| Environment isolation | Phase A and B establish repository/local boundaries, not host/runtime separation | **Partial / open** |
| Smoke tests | CI and local loopback `GET /health` evidence | **Met for local/CI foundation scope** |
| Reviewed architecture conformance | Step 3 review recorded as PARTIAL / FOUNDATION-ONLY | **Reviewed; downstream architecture remains assigned to later roadmap work** |
| Minimal observability/diagnostics | Local/CI warning-level logging baseline | **Met only for local/CI diagnostics; production observability deferred** |

## 5. Remaining blockers and owner decisions

### BLOCK-01 — Required PHP foundation check

The read-only ruleset audit found that the active main ruleset requires the project documentation validation check but does not require `FND-01 foundation CI`. The Product Owner previously authorized adding that exact check while preserving all other rules. The connected GitHub integration has no ruleset-write action, so the setting has not been changed by this process.

**Next action:** apply the already-authorized exact required-check change through GitHub's ruleset UI, or use an authorized administration integration if one becomes available. Preserve all other rules. Then perform a read-only verification. This is the only owner-operated settings step currently identified; do not ask for new authorization for the exact previously approved change.

### BLOCK-02 — Runtime isolation

ISO-06, ISO-07, ISO-08 hosting boundaries, ISO-10 and ISO-11 remain unverified. Phase C remains outside the authorization granted so far.

**Next action:** keep the criterion open. If a distinct V2-only non-production target is later made available and explicitly authorized, automate evidence collection through a narrowly scoped, read-only workflow where technically possible. If it cannot be proven without touching shared/V1/production resources or exceeding the no-spend boundary, record it as deferred rather than claiming a pass.

### BLOCK-03 — Observability scope

Accept only the minimal local/CI diagnostics baseline for M3-02. Production metrics, traces, alerts, retention and incident operations remain deferred to a later operational-readiness milestone.

### BLOCK-04 — Architecture scope

Accept the foundation-only conformance boundary for M3-02, provided the partial findings are assigned to their correct downstream roadmap steps and the Deeni Madaris default-OFF invariant remains a release gate before any public discovery surfaces are implemented.

## 6. Automation operating model

To reduce routine Product Owner effort, subsequent work should use this execution pattern:

1. Use connected GitHub read actions to inspect repository state, PRs, checks, workflow runs, files and rulesets before asking the user for terminal output.
2. Use GitHub Actions for repeatable repository/CI validation when an existing workflow can safely perform it.
3. Create focused documentation/code branches and PRs directly through the connected GitHub integration when supported; keep PRs unmerged unless merge authority is explicit.
4. Report only genuine decision points to the Product Owner. Do not ask the owner to run a command that an available connected tool can execute or verify.
5. Keep approval boundaries for merges, repository protection changes beyond the already authorized exact check, hosting/runtime access, production, databases, external services and spend.
6. If a tool cannot perform an action, state the precise capability gap and offer the smallest owner action needed; do not imply that the user must operate the entire workflow.

This operating model does not grant new production, hosting, database, deployment, repository-administration or spend permissions.

## 7. Final Phase D decision

**Phase D — evidence reconciliation: COMPLETE as a documentation/evidence deliverable.**

**M3-02 Platform Foundation: NOT ACCEPTED / NOT CLOSED.**

The local/Codespaces evidence strengthens the build, test, configuration-default and smoke-test portions of the milestone. Protected-check enforcement and hosting/runtime isolation remain unresolved. No weighted completion percentage is assigned.

No merge, ruleset mutation, hosting access, V1/production access, database operation, deployment, external API/AI integration, telemetry integration or new spend is performed or authorized by this report.
