# M3-08C/D — Synthetic Moderation, Appeals and Privacy/Security Verification

**Repository:** `mattari20/listing-v2`  
**Authorization:** Product Owner explicitly authorized M3-08C/D on 2026-11-16 for synthetic-only local/CI implementation.  
**Branch:** `feat/m3-08cd-synthetic-moderation-security`  
**Base:** `9cf985b3e23c3794665349546dd1afa184f6f3af`  
**Status:** Implemented and merged in PR #234 as `42eabe8a5757e6b4c291baa52d1c01df4e08bb15`; exact PR head `80d7a4a659fa58b1da2542b9c1f429a951399dce`; FND-01 CI #43876036202 and Project documentation validation #43876036293 passed. No production-readiness or independent-review claim.

## 1. Authorized scope

This package implements internal, synthetic-only moderation and appeal workflow foundations plus privacy/security regression checks. It does not create a public intake path or enable user-generated content.

## 2. Implemented design

- Additive SQLite-compatible migration creates moderation cases, appeals and state-transition event records.
- Synthetic case/appeal references must use a strict `synthetic:` prefix and bounded character set.
- No report body, review text, attachments, identity documents, birth dates, phone numbers or free-form rationale are persisted.
- Case categories, case outcomes, appeal outcomes and reason codes are allowlisted.
- Case review requires an active moderator with exact `review` resource scope and prevents reporter self-moderation.
- Only the assigned moderator can resolve a case.
- Appeals are available only to the synthetic case reporter after an actioned/rejected decision, and only one appeal is allowed per case.
- Appeal review requires the scoped `ugc.appeal.review` capability and a reviewer distinct from the appellant and original moderator.
- Every transition writes a separate event record with actor, state transition and controlled reason code.
- No HTTP route, controller, public form, notification, review submission, rating, moderation dashboard or public UGC activation is added.

## 3. Privacy and safeguarding boundaries

- The persisted fields contain identifiers, bounded categories/states/reason codes and synthetic references only.
- No child age, consent, identity or enrollment document collection is implemented.
- No age eligibility or legal-policy decision is inferred.
- No user-generated content is accepted or stored.
- Existing anonymous public directory behavior and Deeni Madaris default-OFF behavior are unchanged; existing regression tests remain required.

## 4. Security verification added

Synthetic tests cover exact scope, inactive/unknown capability denial through the existing authorization service, reporter/moderator separation, assigned-reviewer-only resolution, duplicate appeal prevention, appeal independence, invalid state/outcome handling, metadata minimization and absence of public review/moderation routes. Existing directory, authorization, migration and Deeni Madaris suites remain part of full CI.

## 5. Exclusions and remaining external gates

No production or V1/Hostinger access, real personal data, source ingestion, external API, identity/email/SMS/moderation provider, new dependency, new spend, deployment, release or launch is included. No qualified legal/privacy/child-safeguarding review, independent security review, moderation staffing, retention policy or production operational assurance is claimed. Reviews and all public UGC remain post-launch and separately gated.

## 6. Validation

Exact-head validation passed on `80d7a4a659fa58b1da2542b9c1f429a951399dce` before squash merge. FND-01 foundation CI [#43876036202](https://github.com/mattari20/listing-v2/actions/runs/43876036202) and Project documentation validation [#43876036293](https://github.com/mattari20/listing-v2/actions/runs/43876036293) both passed. The full synthetic suite reported **15 passed, 916 assertions and 199 non-fatal warnings**. Warnings are the existing test-harness `file_get_contents` diagnostics caused by the intentionally absent local `.env`; no `.env` file was created. Pint, Composer manifest validation, locked dependency audit, Laravel bootstrap/route validation, disposable SQLite migration rollback/reinstall, foreign-key checks and artifact hygiene passed. PR #234 was squash-merged as `42eabe8a5757e6b4c291baa52d1c01df4e08bb15`.

The implementation is complete for the authorized synthetic/local/CI scope only. The broader M3-08 public-release gate is not closed: independent security review and qualified legal/privacy/child-safeguarding review, moderation staffing/operations, retention policy, and any later public UGC/review eligibility decisions remain open. No compliance or production-readiness claim is made.
