# RCV-B09 — Public Reviews and Moderation Activation: Gate Preflight and Acceptance Pack

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Baseline main:** `ba492d785e62ba66961ddd0f1d18ffe95252e6d9`  
**Agenda:** RCV-B09 — Public reviews and moderation activation  
**Status:** Repository-only preflight COMPLETE; PUBLIC REVIEW / UGC / MODERATION ACTIVATION BLOCKED AND NOT AUTHORIZED.

## 1. Roadmap position and authority

RCV-01 lists RCV-B09 as a GATED package, post-launch only. Its scope includes review eligibility, abuse/reporting, appeals, moderation staffing, privacy and child-safeguarding controls. Preconditions are qualified reviews, accepted human operations and separate activation authorization.

This preflight is documentation and read-only repository inspection only. It is not an activation request approval, legal/privacy/safeguarding/security assessment, staff appointment, pilot charter, public launch decision or permission to collect user-generated content.

Binding boundaries remain: private V2 development/acceptance; synthetic/fictional fixtures only; no real accounts or personal/institution/source data; no participant recruitment/contact/research; no public reviews, ratings, reporting or moderation; no production/Hostinger/V1 access, deployment, hosted activity, vendor, external service or spend. Deeni Madaris remains default-OFF with zero public exposure.

## 2. Repository evidence inventory

### 2.1 Public review surface

- `routes/web.php` exposes anonymous directory search/profile/comparison, authenticated institution proposal/correction and authenticated institution editorial-review routes.
- No public review submission, rating, public report, public moderation, appeal intake, review edit/delete or public reply route is present.
- `tests/Feature/ModerationPrivacyBoundaryTest.php` asserts no public moderation, appeal or rating routes and requires authentication on the two institution editorial-review routes.
- The institution editorial-review workflow is a governed institution-fact proposal/correction process. It is not a public user review workflow and must not be reused as one without a separate design.

### 2.2 Synthetic moderation and appeal foundation

- PR #234 delivered `SyntheticModerationWorkflow`, moderation cases, appeals and state-transition event records for synthetic local/CI use only.
- `moderation_cases`, `moderation_appeals` and `moderation_events` contain bounded categories/states/reason codes, actor references and `synthetic:` references; they do not store review bodies, attachments, identity documents, birth dates, age, guardian consent, student status or phone fields.
- The workflow enforces exact scoped moderator capability, reporter/moderator separation, assigned-moderator resolution and independent appeal reviewer checks.
- No public intake, HTTP moderation route, dashboard, notification, review text, rating or user-generated content storage is implemented.
- PR #234 and its implementation record expressly disclaim public UGC activation, production readiness, qualified legal/privacy/safeguarding review, independent security review, moderation staffing and retention policy.

### 2.3 Product requirements

`docs/01-product/COMPARISON_REVIEWS_AND_TRUST.md` establishes:
- Public directory browsing remains anonymous; review submission requires an account.
- Account authentication alone does not prove attendance, study, alumni status or institutional affiliation.
- Review eligibility must be decided before implementation; do not use a 'verified student' label without proportionate privacy-preserving evidence.
- Rating dimensions, scale, weighting and average calculation remain product decisions; counts and context must accompany averages.
- Abuse controls must address duplicate, spam, coordinated, incentivized-without-disclosure, conflicted, impersonating and retaliatory submissions.
- Users need reporting, reasoned moderation, appeal and correction; institutions may have a right of reply but no unilateral deletion power.
- Do not collect unnecessary identity or enrollment documents.
- Reviews are post-launch only. No pre-launch survey, interview, participant recruitment or outreach is authorized.
- Minors and privacy require age/consent/safeguarding/legal applicability decisions before any UGC is implemented or released.

### 2.4 Current account and safeguarding boundary

- Current interactive authentication supports pre-provisioned active/verified accounts only; it does not establish review eligibility or verified student status.
- The Product Owner's M3-11-02 scope decision is private synthetic V2 only, with no real students, child/student/guardian records or child-directed features.
- The M3-11-02 repository review is not a legal applicability determination, formal privacy impact assessment or professional safeguarding assessment.
- No child, student, guardian or research participant may be recruited, contacted or asked to test under the current scope.

## 3. External and operational gate evidence

The current M3-10 readiness records remain authoritative. Their statuses have not been promoted by this preflight, previous code merges or automated CI.

| Gate | Current recorded status | RCV-B09 consequence |
|---|---|---|
| M10-G02 participant protocol / research deferral | NOT APPROVED | No human participant activity or research; review feature remains post-launch only |
| M10-G05 qualified legal/privacy review | REQUIRED / NOT EVIDENCED | No public review data processing or collection |
| M10-G06 child safeguarding | REQUIRED IF RELEVANT / NOT EVIDENCED | No minors or vulnerable participants; qualified applicability decision required before any scope change |
| M10-G07 independent security review | REQUIRED / NOT EVIDENCED | No public UGC/moderation exposure or activation |
| M10-G08 accountable operations/support | NOT ASSIGNED | No accepted privacy/data owner, security incident lead, support owner or coverage |
| M10-G09 moderation/appeals staffing | NOT STAFFED / DISABLED | Public UGC, reviews, ratings, reporting and moderation remain disabled |
| M10-G11 accessibility/capacity | PARTIAL / NOT ACCEPTED | No public UGC accessibility or service-level claim |
| M10-G13 pilot acceptance | NOT STARTED | No pilot or human usability activity |
| M10-G14 production launch | NOT AUTHORIZED | No launch, deployment or public feature activation |

Supporting records:
- `M3-10_FINAL_READINESS_GATE_RECONCILIATION.md`
- `M3-10_OWNER_DECISION_AND_QUALIFIED_REVIEW_PACK.md`
- `M3-10_EXTERNAL_REVIEW_RESPONSE_AND_GATE_RECONCILIATION.md`
- `M3-10_REVIEWER_HANDOFF_AND_DECISION_PREPARATION.md`
- `M3-11-02_CHILD_SAFEGUARDING_SENSITIVE_DATA_REVIEW_2026-11-18.md`
- `M3-11-02_OWNER_INTERNAL_DATA_PRIVACY_REVIEW_2026-11-18.md`
- `M3-11-03_PRODUCT_OWNER_INTERNAL_SECURITY_ACCESSIBILITY_DESK_REVIEW_2026-11-18.md`

Repository evidence reviewed for this preflight contains no subsequent dated qualified legal/privacy assessment, independent security report, qualified safeguarding determination, accepted human operations roster, staffed moderation/appeals team or Product Owner public-UGC activation go/no-go. This is a statement about the repository records inspected, not a claim about communications outside the repository.

## 4. Product and trust decisions still required before implementation

These decisions are not inferred from the research document and are not approved by this preflight.

1. **Eligibility:** whether reviews may be submitted by any authenticated adult account, by a person with a proportionate proof of experience, or by another narrowly defined group. No student/alumni verification mechanism is selected.
2. **Population and age:** applicable age boundary, treatment of minors/vulnerable users, consent and safeguarding applicability. Current scope authorizes no child/student/guardian data or participation.
3. **Review subject:** institution, campus, programme or another explicit unit; rules for affiliated entities, duplicate subjects and review period.
4. **Content policy:** allowed/disallowed content, personal data, allegations, threats, harassment, conflicts, incentivized reviews, impersonation and evidence requirements.
5. **Rating model:** dimensions, scale, weighting, aggregation, minimum sample disclosure, stale/removal/dispute handling and sponsorship separation.
6. **Abuse and integrity:** duplicate limits, rate controls, coordinated behavior, manipulation detection, disclosure and conflict-of-interest handling.
7. **Moderation operations:** report categories, triage, response expectations, escalation, reasoned decisions, evidence access, appeals and reviewer independence.
8. **Institution right of reply:** scope, identity/authority verification, reply moderation and prohibition on unilateral deletion or suppression.
9. **Privacy lifecycle:** data minimization, notice, lawful purpose, access, correction, deletion, retention, backup/log propagation and any verification-data disposal.
10. **Transparency:** public display name/alias, reviewer privacy, labels, counts, methodology, moderation notices and treatment of removed or disputed content.

## 5. Minimum gates for any future RCV-B09 implementation request

All applicable gates must have dated evidence before a new exact-scope implementation authorization is considered:

- Product Owner-approved review policy and eligibility model.
- Qualified written legal/privacy assessment for applicable jurisdictions, including purpose, notices, rights, retention/deletion and data roles.
- Qualified child-safeguarding applicability decision; no minors until a specific safe and lawful protocol is approved.
- Independent security review of account/session boundaries, abuse controls, public/private exposure, reporting, moderation and appeals.
- Accepted named human operations roster: moderation lead, independent appeal reviewer(s), support owner, privacy/data owner and security incident lead, with availability, backup and escalation.
- Written moderation policy, community standards, reporting taxonomy, reason codes, appeals, correction, institution right-of-reply and anti-retaliation controls.
- Data inventory and retention/deletion plan covering primary data, sessions, caches, backups, logs and any future queue.
- Accessibility review and capacity/abuse-load assessment appropriate to the proposed surface.
- Separate Product Owner activation decision and exact bounded implementation authorization. Any public launch, hosted environment, vendor or spend remains a separate gate.

## 6. Recommended sequence if the Product Owner later reopens RCV-B09

1. Obtain and validate actual qualified human reviews and written dispositions through an owner-approved process; do not contact or appoint reviewers through this task.
2. Resolve the pre-launch research deferral and confirm whether any future activity is post-launch product use or a separately governed pilot.
3. Decide review eligibility, population, rating model, disclosure and institution right-of-reply policy.
4. Accept a trained, independent moderation/appeals operations roster and service model.
5. Complete privacy, security, safeguarding and accessibility review and remediation.
6. Prepare a separate exact-file synthetic-only implementation authorization, with no public routes or real content until later separately approved.
7. Only after the appropriate launch gates, issue a separate explicit public-activation decision. No automatic transition from synthetic workflow to public intake.

## 7. Explicit non-authorization

- No application code, schema, migration, model, route, controller, view, job, notification or public review/UGC feature change.
- No public review/rating/report/appeal/moderation activation or public user-generated content.
- No review collection, surveys, interviews, participant recruitment/contact, consent or human usability session.
- No real student, guardian, staff, provider, institution or source data.
- No age/identity/enrollment document collection or verified-student claim.
- No external source, API, AI/model, connector, moderation vendor, paid service, new dependency or spend.
- No production/Hostinger/V1 access, hosted pilot, environment provisioning, deployment, release or launch.
- No change to anonymous directory behavior or Deeni Madaris default-OFF.

## 8. Current disposition

**RCV-B09 repository preflight: COMPLETE.**  
**Public reviews / UGC / reporting / ratings / moderation: DISABLED.**  
**M10-G05 legal/privacy: REQUIRED / NOT EVIDENCED.**  
**M10-G06 safeguarding: REQUIRED IF RELEVANT / NOT EVIDENCED.**  
**M10-G07 independent security: REQUIRED / NOT EVIDENCED.**  
**M10-G08 accountable operations: NOT ASSIGNED.**  
**M10-G09 moderation/appeals staffing: NOT STAFFED / DISABLED.**  
**M10-G13 pilot acceptance: NOT STARTED.**  
**M10-G14 production launch: NOT AUTHORIZED.**

RCV-B09 cannot be activated or represented as fully implemented under the current approvals. Its safe preflight deliverable is complete; the feature itself remains gated until the qualified reviews, human operating model and separate Product Owner authorization are genuinely evidenced.