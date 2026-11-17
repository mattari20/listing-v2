# M3-10 — University Workflow Adversarial Hardening Record

**Repository:** `mattari20/listing-v2`  
**Baseline main:** `929dd9c89711219ba52e405857a431720dad817f`  
**Scope:** synthetic-only V2 feature tests and SQLite fault injection  
**Status:** MERGED AND VALIDATED — synthetic adversarial tests complete; pilot readiness NOT ACCEPTED

## 1. Authorization and boundary

This work follows the separate owner authorization for M3-10 University Workflow Adversarial Hardening. It is limited to synthetic and fictional fixtures in local/CI tests. It does not access V1, production, Hostinger/hPanel, live databases, external sources, APIs, connectors, AI/model services, real institution/student/staff data or participants. No dependency, vendor, procurement or spend was added.

No public UGC, reviews, ratings, reporting, public moderation, public publication or Deeni Madaris exposure is enabled. No pilot, participant research, real-data processing, hosted activity, deployment, release, launch or M3-11 work is authorized.

## 2. Adversarial coverage added

The existing `UniversityRepresentativeWorkflowTest` suite now adds synthetic feature coverage for:

- **Revoked and expired role assignments:** both fail closed at the authenticated HTTP boundary and create no claims or editorial cases.
- **Forged request fields:** caller-supplied actor ID/class, capabilities, scope, source context, publication decision and public visibility cannot override server-derived identity, exact scope, fixed synthetic source context or the no-publication boundary.
- **Invalid evidence:** unknown evidence references and evidence whose source authorization has been revoked are rejected without persisted claims.
- **Idempotency conflict:** reusing a proposal idempotency key with a changed value is rejected and does not create duplicate claims, versions or editorial cases.
- **Atomic rollback:** a disposable SQLite trigger injects a synthetic audit insert failure during editorial review completion; the status update and status-history insert roll back together.
- **Audit integrity:** a successful editorial transition has matching status-history and audit records with the expected actor, entity and outcome.

The rollback trigger is created and dropped inside the isolated test and is SQLite-only. The test explicitly skips on a non-SQLite driver; no production or hosted database is involved.

## 3. Validation evidence

- PR #250: [University workflow adversarial hardening](https://github.com/mattari20/listing-v2/pull/250).
- Added six tests to the existing feature suite; no application runtime code, migration, route, dependency or public surface was changed.
- PR #250 exact head: `f34e132b392792e5f981d7ebef79e9e6329d9085`.
- PR #250 merge commit / main after merge: `8f04a0b4ddf6fd30052426a9a695a2e89611832e`.
- Exact-head PHP 8.5 FND-01 CI run #416 / run `43996067166`: **SUCCESS**.
- Exact-head Project documentation validation run #812 / run `43996067122`: **SUCCESS**.
- Code-only intermediate head `3a50daa4cc918a5d9e7f08c71bd02436eb08d350` also passed FND-01 run #413 and documentation validation run #809; the final PR head was revalidated after all documentation changes.
- No review threads or review submissions were present; merge used `expected_head_sha` and squash because merge commits are disabled in the repository.
- Synthetic suite summary: **15 passed, 1,044 assertions, 218 warnings**. The warning count includes the repository's existing non-fatal missing-local-`.env` diagnostics; no `.env` was created.
- Formatting, Composer advisory check, Laravel bootstrap/routes, synthetic test suite, artifact hygiene and documentation link validation passed.

The CI result validates only the bounded synthetic tests. It is not an independent security audit, legal/privacy/safeguarding/accessibility approval, pilot go/no-go, operational acceptance or production-readiness finding.

## 4. Remaining limits and disposition

The added cases verify the current role expiry/revocation, server-derived actor/source context, evidence authorization, idempotency, transaction and audit contracts. They do not authorize additional workflow capabilities, real data, external sources, participant activity, public UGC, publication activation, hosted environments or launch.

**Adversarial test implementation:** COMPLETE — PR #250 merged and final exact-head checks passed.  
**M3-10 pilot readiness:** NOT ACCEPTED.  
**Human/participant activity and real-data processing:** NOT AUTHORIZED.  
**M3-11 production launch:** NOT AUTHORIZED.
