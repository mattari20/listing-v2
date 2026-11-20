# M3-11 LPS-16 — GAP-01 Public Evidence, Source Attribution and Verification Transparency Framework

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `e5e9ceaa097c0c15a31fac209ea694f41baaf7d9` (main after LPS-15 / PR #373)  
**Agenda:** LPS-16 — GAP-01, Public Evidence, Source Attribution and Verification Transparency  
**Work type:** Repository-only policy/requirements framework and synthetic examples  
**Status:** **FRAMEWORK PREPARED — GAP-01 OPEN / NOT IMPLEMENTED / NOT CLOSED**

## 1. Purpose and authority boundary

LPS-16 translates the GAP-01 requirement into a future-facing, field-level transparency contract. It specifies what a listing may communicate about evidence, attribution, verification, uncertainty, freshness and correction without implying certainty that has not been established.

This is a design and documentation deliverable only. It does not implement UI, APIs, projections, public pages, source retrieval, verification operations or correction services. It does not approve any source, source link, field, publication, real-data processing or public launch. The existing M3-11 Option A / Option 1 private repository boundary remains controlling.

**Restrictions retained:** synthetic/fictional examples only; no V1/production/Hostinger/hPanel/hosted access; no live database or backup activity; no real institute/source/student/child/guardian/personal data; no source contact, access, browsing for collection, terms retrieval, copying, downloading, scraping, crawling or ingestion; no external APIs, AI/model/provider, crawler or live agent; no public complaints/UGC/reviews/ratings/appeals/moderation; no deployment, pilot, candidate, release or participant activity; no new dependency, paid service, hosting upgrade or additional spend. Deeni Madaris remains default-OFF/zero exposure in the current private acceptance scope.

## 2. Transparency principles

1. **Field-level, not blanket claims:** evidence and status attach to an individual field/value version, not to an entire institution by implication.
2. **Source-rights first:** attribution, canonical links, quotations and source descriptions may be displayed only when the source-specific rights decision permits that exact disclosure and use.
3. **Truthful verification language:** distinguish observed, attributed, corroborated and verified-within-scope; do not imply independent verification, endorsement, completeness or guarantee.
4. **Time-bounded evidence:** record when information was observed and when it must be reassessed; observation date is not proof of current truth.
5. **Visible uncertainty:** expose unknown, conflicted, stale, disputed and not-verifiable states where relevant rather than silently choosing a value.
6. **Minimal disclosure:** publish only approved, necessary factual fields and non-sensitive evidence metadata.
7. **Correctability:** provide a future correction path and preserve a traceable internal history without exposing private submissions or internal deliberations.
8. **No evidence laundering:** a synthetic fixture, automated check, source timestamp or internal note cannot be represented as a real-world verification result.

## 3. Field-level evidence record

A future implementation should associate each value version with a structured evidence record containing, at minimum:

| Attribute | Required meaning |
|---|---|
| `field_key` / `value_version_id` | Stable field identity and immutable value-version reference |
| `value_status` | Whether a value is present, absent, unknown, conflicted or suppressed |
| `source_record_id` | Internal reference to a separately assessed source record |
| `source_display_name` | Public source label, only if disclosure is permitted |
| `source_type` | Authority/register, institution-controlled, platform, directory, open dataset, submission or other controlled taxonomy |
| `source_authority_scope` | What the source can establish; must not overstate authority |
| `rights_decision_id` | Link to source-specific LPS-15 rights assessment and permitted-use decision |
| `observed_at` | Date/time the evidence was observed, with timezone/precision where available |
| `verification_state` | One of the controlled states in §4 |
| `verification_method` | Human/automated method and scope, described without exposing security-sensitive details |
| `corroboration_refs` | References to distinct corroborating evidence, if any and permitted |
| `confidence_or_limitations` | Defined basis and limitations; no fabricated numeric score |
| `freshness_policy_id` / `review_due_at` | Approved risk-based freshness rule and reassessment date |
| `conflict_or_dispute_id` | Internal case reference where applicable |
| `last_changed_at` | Date/time the field value or status last changed |
| `publication_eligibility` | Explicit allow/deny decision for the proposed audience and projection |
| `reviewer_role` | Role/method metadata; personal reviewer identity is not public by default |
| `withdrawal_or_expiry_state` | Whether evidence was withdrawn, expired, revoked or superseded |

Unknown values must remain explicitly unknown; optional fields may be null only with a documented reason. A missing source record or missing rights decision must fail closed for public attribution/publication where that control is required.

## 4. Controlled verification states

| State | Meaning | Permitted user-facing interpretation |
|---|---|---|
| `UNVERIFIED` | A value exists but has not undergone the defined verification process | “Not verified” |
| `SOURCE_ATTRIBUTED` | A permitted source is identified and the value is attributed to it; truth has not been independently established | “According to [permitted source]” |
| `CORROBORATED` | Two or more sufficiently independent, relevant evidence items support the value under a documented rule | “Corroborated by multiple sources” only when independence and relevance are established |
| `VERIFIED_WITHIN_SCOPE` | A documented competent process checked the value against an identified authority and defined scope | “Verified against [authority] on [date]”; never implies universal accuracy |
| `CONFLICTED` | Material evidence sources disagree and the conflict is unresolved | “Conflicting information; under review” |
| `STALE` | The approved freshness threshold has passed without reassessment | “May be out of date” |
| `DISPUTED` | A credible correction/dispute has been received and is awaiting resolution | “Disputed; not currently confirmed” |
| `WITHDRAWN` | The source/evidence was withdrawn or its use permission revoked | Suppress unsupported attribution/value as policy requires |
| `NOT_VERIFIABLE` | The field cannot be verified using the approved method/sources | “Unable to verify” |
| `EXPIRED` | The evidence or permission has reached its defined expiry | “Verification expired” or suppress, depending on field risk |

State transitions must be explicit, timestamped and attributable to a permitted process. A value must not move to `VERIFIED_WITHIN_SCOPE` merely because it has a source URL, was imported, passed schema validation, was previously verified, or was reviewed by an unqualified process. `CORROBORATED` requires genuinely distinct evidence, not duplicate copies of the same source.

## 5. Source attribution and rights linkage

- Public source name, source type, authority description, canonical link, access date, excerpt or quotation are separate disclosure decisions; one permission does not imply all others.
- Every public attribution must resolve to an LPS-15 source record and a current rights decision that explicitly covers the audience, purpose, method, attribution, linking, caching and redistribution involved.
- Where a link or source identity cannot lawfully or contractually be disclosed, do not expose it. Use an approved neutral disclosure such as “source details withheld” only if that statement is accurate and does not imply verification.
- Do not reproduce protected wording, logos, screenshots, images, database extracts or other source expression as a substitute for attribution.
- A source's authority is field-specific: a recognition register may support recognition status within its scope, but does not necessarily prove current fees, facilities, admission availability or teaching quality.
- User/institute submissions must be labeled as submissions until independently assessed; identity/authority checks are not proof that every submitted fact is true.
- Source permission expiry, withdrawal or changed terms must trigger reassessment and suppression/withdrawal according to the source-specific decision.

No source is assessed or approved by LPS-16.

## 6. Freshness and reassessment policy

No universal refresh interval is set by this framework. A future owner-approved schedule must assign each field a risk tier, source authority, volatility, harm if stale, review method, maximum age, expiry behavior and responsible role.

Suggested *design categories only* (intervals intentionally unset):

| Field family | Freshness considerations | Stale/expiry behavior to define |
|---|---|---|
| Recognition/registration status | Authority, effective date, revocation and scope | Prominent stale status; suppress definitive current-status claim when expired |
| Fees/scholarships | High volatility, academic session, fee components and effective date | Display “last checked” and stale warning; do not present as current price after expiry |
| Address/contact | Relocation, ownership and contact changes | Mark stale and provide correction route; suppress unsafe/unconfirmed contact details |
| Programs/subjects | Intake cycles, campus and program-specific scope | Show session/scope and stale state; do not infer availability |
| Admissions/deadlines | Time-sensitive, cohort-specific announcements | Expire at stated deadline; avoid carrying forward old dates |
| Hours/services/facilities | Seasonal and operational variability | Mark date checked and stale; do not claim currently available without current evidence |

The Product Owner and any required qualified reviewers must approve intervals and consequences before implementation or publication. The system must distinguish `observed_at`, `last_verified_at`, `review_due_at` and `published_at`; these timestamps are not interchangeable.

## 7. Conflict, dispute, correction and suppression

Future internal handling should follow a controlled sequence:

1. Receive a correction signal through an authorized channel (not activated by this agenda).
2. Assign a non-sensitive case ID; record field/value version, reason category, received date and evidence references.
3. Protect submitter identity and attachments; do not expose them in the public projection.
4. Triage credibility, urgency, safety, privacy and source-rights implications.
5. If material conflict or credible risk exists, move the affected field to `DISPUTED` or `CONFLICTED`, or suppress it pending review; do not silently retain a misleading definitive value.
6. Assess the evidence and source authority; record the decision, rationale, reviewer role, effective date and any appeal/escalation route.
7. Publish a corrected value/status only after authorized disposition and rights/privacy checks.
8. Preserve internal version history and a minimal public change indicator where approved; do not publish confidential deliberations.
9. Reassess related fields if the correction reveals a broader source or process issue.
10. Close only with recorded outcome, communication status, retention classification and audit reference.

LPS-16 does not activate intake, complaint handling, appeals, moderation, service-level commitments or named operational roles. GAP-04 remains separate.

## 8. Public projection and privacy/security boundary

A future public projection should use an allowlist, not a denylist. Each field and metadata element must be explicitly approved for the audience and purpose. The projection must exclude, unless a later exact review explicitly permits otherwise:

- personal contact details, submitter identity, private correspondence and attachments;
- student, child, guardian or other personal data;
- credentials, tokens, internal identifiers that expose system structure, access paths or security controls;
- confidential reviewer identities, legal advice, internal notes, risk deliberations and moderation signals;
- protected source content, non-public source URLs, restricted database material and unlicensed images/logos;
- internal fraud/abuse indicators, security events and investigation details.

Public output should disclose only the minimum helpful evidence metadata: field label/value, truthful status, permitted source attribution, checked/observed date, concise limitation/freshness note and approved correction route. A profile-level badge must not conceal field-level differences or suggest every field is verified.

## 9. Synthetic user-facing examples

All names and details below are fictional and must never be mistaken for source evidence.

**Example A — source-attributed, not independently verified**

> Annual tuition: PKR 120,000  
> Status: According to the institute's published fee notice  
> Checked: 12 October 2026  
> Note: The amount and applicable session are attributed to the notice; current availability has not been independently confirmed.

**Example B — verified within a narrow authority scope**

> Recognition status: Listed in the fictional Example Education Register  
> Status: Verified within the register's stated scope  
> Checked: 12 October 2026  
> Note: This does not verify fees, campus facilities, admissions or teaching quality.

**Example C — conflicting evidence**

> Campus address: Conflicting information  
> Status: Under review  
> Note: We are not presenting either address as confirmed while the discrepancy remains unresolved.

**Example D — stale information**

> Admissions deadline: 30 September 2026  
> Status: Out of date — last checked 10 August 2026  
> Note: The displayed date is historical and must not be treated as an open admission opportunity.

## 10. Required controls and acceptance criteria for future implementation

GAP-01 cannot be considered implemented until a separately authorized implementation and evidence package demonstrates all of the following:

1. A field disclosure matrix maps purpose, necessity, audience, source authority, rights decision, privacy class and public eligibility.
2. Every published value has immutable value-version and evidence lineage, including observed date, method, state and limitations.
3. Verification states and transitions are enforced consistently in domain logic, API/serialization and user interface.
4. Public attribution and links fail closed when source rights are missing, expired, withdrawn or insufficient for the proposed use.
5. Freshness rules are owner-approved, risk-based, testable and applied to the relevant field families.
6. Conflicted, disputed, stale, expired and withdrawn values cannot be represented as current verified facts.
7. Public projection uses an explicit allowlist and tests prove private/personal/security-sensitive/source-protected fields are absent.
8. Correction/suppression outcomes are traceable and do not leak submitter or internal reviewer information.
9. User comprehension testing and accessibility review establish that labels do not overstate certainty or imply endorsement.
10. Qualified privacy/legal/source-rights review and any required independent assurance are recorded for the exact proposed publication scope.
11. Synthetic tests cover state transitions, rights revocation, expiry, conflicts, corrections, privacy exclusions, projection leakage and audit history.
12. Product Owner accepts the completed evidence and a separate exact-scope authorization exists before any real-data or public activity.

**Not sufficient:** this document, a sample profile, schema validation, timestamps alone, synthetic fixtures alone, a source URL alone, or a CI pass.

## 11. Stop conditions

Stop and record the issue as unresolved if:
- a field lacks a necessity/purpose, audience or disclosure decision;
- source identity/authority or source-rights permission is unknown, expired or withdrawn;
- a public label could imply stronger verification than the evidence supports;
- sources materially conflict or a credible dispute is unresolved;
- freshness interval or expiry behavior is undefined for a time-sensitive field;
- a projection could expose personal, child, confidential, security-sensitive or protected source material;
- correction responsibility, decision authority or escalation is unassigned;
- a proposed activity requires real sources/data, public activation, external services, hosted access, deployment, pilot, new spend or scope expansion.

## 12. Relationship to prior agendas and gap register

- **LPS-11:** established the partial-evidence baseline and identified the public transparency gap.
- **LPS-12:** registered GAP-01 as P1 and required field-level disclosure, truthful verification states, rights-permitted attribution and projection tests.
- **LPS-13:** supplies the future change-impact governance model; material changes to fields, sources, statuses or public output require impact assessment and authorization.
- **LPS-14:** supplies data inventory, retention and deletion requirements; evidence lineage and dispute records must be included in the relevant future data inventory.
- **LPS-15:** supplies source-rights and qualified-review preparation; LPS-16 relies on source-specific rights decisions and does not replace them.
- **GAP-02, GAP-03, GAP-04 and GAP-06:** remain separate open workstreams and prerequisite blockers for relevant real-data, source, service or hosted activity.

## 13. Final disposition

- [x] Public evidence transparency principles documented.
- [x] Field-level provenance/evidence contract defined.
- [x] Verification states and user-facing meanings defined.
- [x] Attribution and LPS-15 rights linkage specified.
- [x] Risk-based freshness model defined without inventing intervals.
- [x] Conflict, dispute, correction and suppression sequence documented.
- [x] Privacy/security projection exclusions and allowlist principle documented.
- [x] Fictional examples and future implementation acceptance criteria included.
- [x] Stop conditions and prior-agenda dependencies recorded.
- [ ] Runtime/UI/API/projection implementation — not performed or authorized.
- [ ] Synthetic implementation test suite — not performed in this documentation agenda.
- [ ] Qualified legal/privacy/source-rights review — not received.
- [ ] Public profile/service activation — not authorized.

**Final disposition:** LPS-16 is COMPLETE as a repository-only transparency framework. **GAP-01 remains OPEN / DESIGNED / NOT IMPLEMENTED / NOT CLOSED.** No source has been approved; no real data, source access, public publication, service activation, hosted work or release authority is created. M3-11 remains BLOCKED / NOT ACCEPTED, all ten M3-11 gate dispositions remain unchanged, and overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
