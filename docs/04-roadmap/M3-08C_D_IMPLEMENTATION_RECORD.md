# M3-08C/D — Synthetic Moderation, Appeals and Privacy/Security Verification

**Repository:** `mattari20/listing-v2`  
**Authorization:** Product Owner explicitly authorized M3-08C/D on 2026-11-16 for synthetic-only local/CI implementation.  
**Branch:** `feat/m3-08cd-synthetic-moderation-security`  
**Base:** `9cf985b3e23c3794665349546dd1afa184f6f3af`  
**Status:** Implementation candidate; exact-head CI and documentation validation pending. No production-readiness or independent-review claim.

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

Pending exact-head FND-01 foundation CI and Project documentation validation. Test counts and warnings must be reconciled from actual CI results before closeout.
