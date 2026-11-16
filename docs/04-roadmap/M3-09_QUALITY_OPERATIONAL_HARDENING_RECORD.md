# M3-09 — Quality and Operational Hardening Record

**Repository:** `mattari20/listing-v2`  
**Authorized scope:** Q01–Q06, synthetic-only local/GitHub CI  
**Baseline main:** `ef87027355ee7e6a072bf82f0531695ac075a29a`  
**Authorization:** Product Owner explicit authorization, 2026-11-16  
**Status:** In progress — package evidence is recorded below; final acceptance remains contingent on exact-head CI and merge evidence.

## 1. Binding execution boundary

All work is confined to synthetic fixtures, repository code/tests/docs and GitHub CI. No Hostinger, V1, production or live database access; no deployment, release, launch, external API, AI provider, connector, new dependency, new spend or real user data. Anonymous public directory behavior remains unchanged. Public UGC, reviews and moderation activation remain disabled; reviews remain post-launch only. Deeni Madaris remains default-OFF with zero public exposure. Existing tests must not be weakened.

This record is engineering evidence, not independent security certification, legal/privacy/child-safeguarding review, production backup validation or launch approval.

## 2. Q01 — Baseline and coverage inventory

Baseline inspected at `ef87027355ee7e6a072bf82f0531695ac075a29a`.

The repository has 22 feature-test files and one unit-test file at baseline. Coverage is grouped as follows:

- Public directory: anonymous search/profile, allowlisted approved facts, locality filters, suppression, source-authorization revocation, supersession, ambiguous names and Deeni Madaris exclusion.
- Governance: persistence, evidence/proposal validation, review/adjudication, publication, suppression, correction, revocation, audit/outbox and rollback.
- Provider domain: provider/institution relationships, authority relationships, campuses and programme catalogue.
- Identity/security: session lifecycle, login failure non-enumeration, scoped authorization, role grant/revocation, self-approval denial, moderation/appeal lifecycle and privacy boundary.
- Database: complete disposable SQLite migration/reinstall, foreign-key checks, independent-connection idempotency and writer contention.
- Foundation: health endpoint and environment defaults.

Baseline CI has two workflows: PHP 8.5 foundation CI (Composer validation/audit, Pint, Laravel bootstrap/routes, synthetic PHPUnit suite, artifact hygiene) and project documentation validation (required documents and relative Markdown links).

Known evidence gaps at baseline: no automated browser/assistive-technology audit; no representative production-like load test; no numeric SLO/RPO/RTO approved; no independent security review; no real environment backup/restore rehearsal authorized; no production monitoring or alert integration. These remain limitations, not implied passes.

## 3. Q02 — Functional and accessibility hardening

Added a regression test for the anonymous directory's language declaration, primary heading, explicitly associated search/category/locality labels, and results landmark/heading relationship. Added a no-script/no-remote-asset regression test. This is source-level semantic markup verification only; it is not a WCAG conformance claim or substitute for keyboard, screen-reader and human accessibility evaluation.

## 4. Q03 — Performance regression guard

Added a deterministic empty-directory database query-count ceiling of eight queries. This guards against accidental query multiplication on the empty-index path. It is not a latency benchmark, representative dataset/load test, capacity result or approved SLO. Existing I7 query-count comparison remains the synthetic multi-result baseline. No numeric service-level target is adopted.

## 5. Q04 — Security and privacy regression

Added a first-party response middleware that sets:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: camera=(), microphone=(), geolocation=()`

Added an HTTP regression test for these headers. Existing M3-08 session, exact-scope authorization, moderation/appeal separation, privacy-boundary and Deeni Madaris tests remain in the full suite. These headers are a baseline only; CSP, HSTS, external penetration testing and independent security review are not claimed.

## 6. Q05 — Resilience and disposable recovery

Added a disposable SQLite backup/restore regression: migrate a fresh temporary database, write a synthetic probe row, copy the database file, mutate the row, restore the copy, and verify restored data, schema presence, SQLite integrity and foreign-key integrity. Existing full migration rollback/reinstall and SQLite independent-connection tests remain.

This proves only a local disposable SQLite file-copy exercise. It does not validate Hostinger, MySQL, production backups, off-site retention, encryption, point-in-time recovery, disaster recovery or any RPO/RTO.

## 7. Q06 — Operational exercise and runbook

### Synthetic CI failure triage
1. Record repository, PR, exact head SHA, workflow/run ID, job and failing step.
2. Reproduce only in the repository's synthetic CI/local environment.
3. Classify as code, test fixture, environment/toolchain, documentation or external service dependency.
4. Do not introduce credentials, external services, live datasets or new dependencies to make the check pass.
5. Correct the root cause, add/retain a regression test and rerun the exact PR head.
6. Treat pending, skipped, cancelled and failed checks as non-passing.
7. Preserve logs/links and update the risk register; do not claim a pass from a rerun of a different SHA.

### Disposable SQLite recovery exercise
1. Use a fresh temporary file created by the test; never point the test at a developer or production database.
2. Run the repository migration sequence on that disposable file.
3. Create only a synthetic probe record and a temporary backup copy.
4. Simulate loss by modifying the disposable file after the backup.
5. Restore the copy and verify the probe value, required table presence, `PRAGMA integrity_check` and `PRAGMA foreign_key_check`.
6. Purge database connections and remove both temporary files in a `finally` cleanup path.
7. Record the CI run and exact SHA. Do not extrapolate to a live backup/restore capability.

### Incident tabletop (synthetic scenario)
Scenario: a CI run detects that a supposedly private field is rendered in an anonymous directory response.
- Stop the affected PR; do not merge or deploy.
- Preserve exact-head logs and synthetic reproduction.
- Identify the projection/query/view boundary that leaked the field.
- Add a regression test that proves the field is absent from search, facets and direct profile output.
- Fix the narrowest boundary and rerun the full suite plus documentation validation.
- Escalate unresolved privacy/security risk for independent review; no real user notification or incident response is simulated.

### Operational limitations
There is no production telemetry, alert delivery, staffed on-call rotation, incident communications channel, approved retention schedule, production backup, or disaster-recovery environment in this scope. Those are open operational/release prerequisites and must not be represented as complete.

## 8. Risk register

| Risk | Current disposition | Evidence / next action |
|---|---|---|
| Accessibility is not independently audited | Open | Automated semantic assertions only; human keyboard/screen-reader review remains required |
| Performance capacity is unknown | Open | Deterministic query-count ceiling only; no representative load test or approved SLO |
| Security posture is not independently certified | Open | Baseline headers and synthetic regression tests only; independent security review remains required |
| Live backup/restore is unverified | Open | Disposable SQLite file-copy exercise only; separate engine/environment rehearsal required before production |
| Operational alerting/on-call not established | Open | Synthetic incident tabletop/runbook only; staffing and monitoring decisions remain open |
| External legal/privacy/child-safeguarding reviews remain open | Open | Qualified independent review required; no compliance claim |

## 9. Acceptance checklist

- [ ] Q01 baseline and gap inventory reviewed.
- [ ] Q02 semantic accessibility and functional regressions pass.
- [ ] Q03 deterministic query-count regression passes.
- [ ] Q04 security-header and existing privacy/authorization regressions pass.
- [ ] Q05 disposable SQLite backup/restore, integrity and foreign-key checks pass.
- [ ] Q06 runbooks and synthetic incident tabletop documented.
- [ ] Full PHP 8.5 CI and documentation validation pass on the exact final PR head.
- [ ] PR merged and post-merge documentation validation passes.
- [ ] Residual risks remain explicit; no production-readiness or certification claim.

## 10. Final delivery evidence

To be completed only after CI, review, merge and post-merge validation. Record exact PR number, branch, head SHA, merge SHA, workflow run IDs, test summary and remaining warnings here.
