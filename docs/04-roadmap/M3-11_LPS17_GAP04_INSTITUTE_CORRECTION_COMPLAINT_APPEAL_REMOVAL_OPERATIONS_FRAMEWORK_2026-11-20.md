# M3-11 LPS-17 — GAP-04 Institute Correction, Complaint, Appeal and Removal Operations Framework

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `d3b88ffb0208bb1a042ae015879eb7b32d3aa7a4` (main after LPS-16 / PR #374)  
**Agenda:** LPS-17 — GAP-04 Institute Correction, Complaint, Appeal and Removal Operations  
**Work type:** Repository-only operating-policy and requirements framework; synthetic examples only  
**Status:** **FRAMEWORK PREPARED — GAP-04 OPEN / DESIGNED / NOT IMPLEMENTED / NOT CLOSED**

## 1. Purpose and authority boundary

LPS-17 defines the future operational controls needed to receive, assess, decide and communicate institute-related corrections, complaints, appeals and removal requests. It is designed to protect students and the public from inaccurate listings while giving institutions a fair, traceable way to challenge incorrect or misleading information.

This is not an activated service, legal opinion, staffing appointment, service-level commitment or implementation authorization. No public intake, email address, telephone number, portal, form, complaint queue, moderation function or appeal channel is created. No institution or person is contacted. No real evidence or identity document is collected.

The current M3-11 Option A / Option 1 private boundary remains controlling: synthetic/fictional fixtures only; no V1/production/Hostinger/hPanel/hosted access; no live database, backup or migration; no real institute/source/student/child/guardian/personal data; no source contact, access, collection, copying, scraping, crawling or ingestion; no external APIs, AI/model/provider, crawler or live agent; no public complaint/UGC/review/rating/appeal/moderation activation; no deployment, pilot, candidate, release or participant activity; no new dependency, paid service, hosting upgrade or additional spend. Deeni Madaris remains default-OFF/zero exposure in the current private acceptance scope.

## 2. Operating principles

1. **Fairness and neutrality:** evaluate claims against evidence and published policy, not the identity, status, influence or commercial relationship of the requester.
2. **No automatic entitlement:** an institute's request does not automatically establish that a listing is wrong or require removal; equally, a request must not be dismissed merely because the requester is not an institute representative.
3. **Proportionate verification:** request only the minimum information needed to establish authority and assess the specific claim.
4. **Evidence-led decisions:** separate identity/authority verification from factual verification; both are distinct from rights to publish.
5. **Safety-first interim action:** credible risk of harm, exposed personal data, impersonation, fraud or unlawful disclosure requires prompt triage and proportionate restriction/suppression pending review.
6. **Separation of duties:** intake, identity/authority verification, factual assessment, decision, appeal and publication should not be concentrated in one person for a future operational service where independent review is required.
7. **Privacy by design:** do not expose requester identity, identity documents, private correspondence, attachments or internal deliberations.
8. **Traceability and correction:** retain a controlled internal history of the challenged value, evidence, decision, effective date and resulting publication state, subject to approved retention/deletion rules.
9. **No retaliation or preferential treatment:** correction rights are not a paid feature and do not provide preferential ranking, endorsement or suppression of truthful adverse facts.
10. **Accessible communication:** future instructions and decisions must be understandable, accessible and available through approved channels without requiring public disclosure of sensitive information.

## 3. Request taxonomy and scope

A future authorized service should classify requests before assigning a workflow.

| Request type | Description | Initial handling |
|---|---|---|
| Factual correction | Claim that a field such as name, address, contact, fee, program or status is inaccurate | Identify exact field/value and evidence needed |
| Institute identity/authority claim | Requester claims to represent or control an institution/campus | Verify identity and authority separately |
| Duplicate/relationship dispute | Claim that campuses, branches, affiliations or similarly named entities were conflated | Preserve distinct entity records pending evidence |
| Source/attribution challenge | Claim that source attribution, link, content or use is inaccurate or not permitted | Restrict challenged attribution if credible; refer to LPS-15 rights process |
| Privacy/personal-data concern | Claim that personal or sensitive information is exposed or processed improperly | Priority privacy triage; restrict exposure where appropriate |
| Safety, fraud or impersonation complaint | Claim involving deception, impersonation, threats, abuse or material risk | Urgent specialist escalation and proportionate containment |
| Misleading representation complaint | Claim that a listing implies endorsement, recognition, accreditation or services not established | Review wording, authority and evidence scope |
| Removal/suppression request | Request to remove a listing or particular field | Determine authority, basis, public-interest and legal/policy constraints |
| Appeal | Request to reconsider a prior decision based on error, new evidence or process failure | Independent reviewer where feasible; preserve original decision history |
| General feedback / out of scope | Opinion, promotion, rating, review, advertising or unrelated dispute | Do not convert into public UGC/review capability; route or decline under future policy |

This taxonomy does not authorize public reviews, ratings, user-generated content, public accusations or open discussion threads.

## 4. Requester identity and institutional authority verification

Identity verification and authority verification are separate questions.

### 4.1 Minimum-necessary verification

A future approved procedure must:
- identify the exact institution and, where relevant, campus/branch/legal entity being represented;
- determine the requester's claimed role and scope of authority (e.g., owner, authorized officer, principal, registrar, delegated representative);
- use a proportionate verification method approved for the jurisdiction and service risk;
- prefer low-data verification and avoid collecting identity-document copies unless a documented necessity and lawful basis are established;
- record the verification outcome, method category, date, verifier role and limitations, not unnecessary identity-document contents;
- confirm whether authority covers the specific requested action, such as correcting a fee field or requesting removal;
- record delegation expiry and re-verification triggers;
- provide a safe alternative route for an institution that cannot use the default verification method.

### 4.2 Verification states

| State | Meaning | Allowed consequence |
|---|---|---|
| `NOT_STARTED` | No check performed | No authority-based change |
| `PENDING` | Minimum information received; check incomplete | Acknowledge only; no privileged edit |
| `VERIFIED_LIMITED` | Identity/role and a defined authority scope verified | Handle only claims within scope |
| `VERIFIED_DELEGATE` | Delegation verified for defined actions and period | Handle only delegated actions |
| `UNABLE_TO_VERIFY` | Evidence is insufficient or method unavailable | Offer approved alternative; no privileged change |
| `REJECTED` | Material mismatch, invalid authority or suspected impersonation | Do not grant privileged access; escalate credible abuse |
| `EXPIRED` | Previously verified authority has expired or become unreliable | Reverify before further privileged action |
| `REVOKED` | Authority withdrawn or invalidated | Remove privileged authority and reassess open cases |

A verified representative is not automatically correct about the underlying facts. Verification must never be used as a blanket endorsement of an institution or its claims.

## 5. Evidence and claim assessment

Each case should identify:
- case ID, request type, affected institute/entity and exact field/value version;
- precise claim and requested outcome;
- evidence items, origin, date, integrity/provenance and limitations;
- source-rights status under LPS-15 for any proposed source use or disclosure;
- current verification state and public impact under LPS-16;
- relevant policy/field definition and applicable effective date;
- whether the evidence is first-hand, authoritative, corroborative, derivative, disputed or unverifiable;
- conflict-of-interest declaration for assigned reviewers;
- decision rationale and unresolved uncertainty.

Evidence must be assessed for relevance, authority, currency, independence and integrity. A screenshot or document supplied by a requester is a lead, not automatically conclusive proof. Duplicate copies of one source are not independent corroboration. Do not ask for student records, child data, medical information, private staff information or unrelated personal documents to resolve an institute listing dispute.

If a claim requires professional legal, privacy, safeguarding or source-rights judgment, the case must be held or escalated for qualified review; internal administrative handling cannot substitute for that review.

## 6. Case lifecycle and controlled states

Recommended future case states:

`RECEIVED` → `TRIAGE` → `AUTHORITY_CHECK` (if relevant) → `EVIDENCE_REVIEW` → `DECISION_PENDING` → `DECIDED` → `COMMUNICATION_PENDING` → `CLOSED`

Additional controlled states:
- `ACKNOWLEDGED`: receipt communicated; no merits decision implied.
- `NEEDS_INFORMATION`: a specific minimum item is required; pause/clock behavior must be defined.
- `URGENT_RESTRICTED`: field or listing temporarily restricted due to credible urgent risk.
- `CONFLICTED`: evidence materially conflicts; no definitive disputed claim presented as settled.
- `REFERRED`: sent to a competent authorized reviewer or specialist.
- `DECLINED`: request is outside scope, unsupported, abusive or lacks authority after a fair opportunity to clarify.
- `WITHDRAWN_BY_REQUESTER`: requester withdrew; record whether any independent safety/privacy action remains necessary.
- `APPEAL_OPEN`: timely/accepted appeal is under review.
- `REOPENED`: material new evidence or process defect warrants reconsideration.
- `SUPPRESSED_PENDING_REVIEW`: public field/listing hidden while a material issue is assessed.
- `CLOSED_NO_CHANGE`: no change made, with reasons communicated where possible.
- `CLOSED_CORRECTED`: correction published after approval.
- `CLOSED_REMOVED`: listing or field removed after authorized decision.
- `CLOSED_PARTIAL`: only specified fields changed or suppressed.

Every transition must have an authorized actor role, timestamp, reason code, evidence reference and next action. No state transition may silently erase prior decisions or evidence history. A case must not be closed merely because a response deadline has elapsed.

## 7. Triage, priority and interim protection

A future triage model should consider:
- immediate exposure of personal or child-related data;
- credible threats, impersonation, fraud or physical safety risk;
- materially false recognition/accreditation or official-status claims;
- incorrect contact/location information that may direct students to an unsafe or unrelated party;
- source-rights withdrawal or potentially unlawful disclosure;
- time-sensitive admissions/fee information;
- ordinary factual correction or non-urgent feedback.

Priority labels may be `P0_URGENT`, `P1_HIGH`, `P2_NORMAL`, `P3_LOW`, but response times must be approved from actual staffing, risk and applicable obligations before service activation. This framework deliberately sets no numerical service-level target.

Interim measures must be proportionate and reversible where possible: hide a field, mark it disputed, remove a link, suppress a profile or preserve a minimal warning. The case record must explain why the measure was taken, who authorized it, its review point and what evidence is needed to lift it. Interim restriction is not a final finding against the institute or requester.

## 8. Decision framework and outcomes

A decision record must answer:
1. What exact claim and field/value version were reviewed?
2. Was requester authority relevant, and what was verified?
3. What evidence was considered and what were its limitations?
4. Which source-rights, privacy, accuracy and transparency rules apply?
5. What conflicts, uncertainty or missing evidence remain?
6. What outcome is proportionate and why?
7. What will change in the public record, if anything?
8. What can be appealed, by whom, on what grounds and through what approved channel?

Possible outcomes:
- `CORRECT`: replace a demonstrably inaccurate field with a supported value.
- `PARTIAL_CORRECT`: update only supported fields.
- `ANNOTATE_LIMITATION`: retain a value with a truthful limitation or status where publication remains appropriate.
- `MARK_DISPUTED`: disclose unresolved dispute status where safe and approved.
- `TEMPORARY_SUPPRESSION`: restrict a field/listing pending further evidence or review.
- `REMOVE_FIELD`: remove a field where publication is not justified or permitted.
- `REMOVE_LISTING`: remove the listing where the decision criteria support it.
- `NO_CHANGE`: retain the current value with reasoned findings.
- `DECLINE_OUT_OF_SCOPE`: decline a request outside the service mandate, with safe referral guidance if available.
- `REFER_FOR_QUALIFIED_REVIEW`: do not make a professional determination internally.

A requester’s preference, commercial relationship or lack of cooperation does not alone determine the outcome. Equally, public-interest or student-utility value does not override source rights, privacy, safety or a binding legal requirement.

## 9. Appeal and reconsideration

A future appeal process should:
- explain appeal eligibility, scope, grounds, submission method and any approved time limit in the original decision;
- accept grounds such as material new evidence, factual error, misapplied policy, conflict of interest, procedural unfairness or disproportionate outcome;
- distinguish an appeal from repeating the same unsupported assertion;
- assign a reviewer who did not make the original decision where feasible and required by risk;
- preserve the original case and decision; link the appeal as a separate record;
- reassess interim restrictions if the risk profile changes;
- provide a reasoned appeal outcome and any further external route required by applicable law or policy;
- record whether the original decision is upheld, varied, set aside or remitted for fresh review.

No numerical appeal window or statutory rights statement is created here. Any deadlines, external remedies and jurisdiction-specific statements require qualified legal review before publication.

## 10. Removal, suppression and restoration

Removal is not a single undifferentiated action. Future policy must distinguish:
- field-level removal;
- temporary field suppression;
- profile-level suppression;
- permanent listing removal;
- source-attribution/link withdrawal;
- account/representative privilege revocation;
- removal required by a binding legal or safety determination.

Before removal, assess authority, evidence, public/student impact, source rights, privacy, retention obligations, related campuses/records and risk of mistaken identity. Preserve only the minimum lawful internal audit evidence under the approved LPS-14 retention schedule. Do not retain a hidden duplicate indefinitely as an undocumented workaround.

Restoration requires a new documented decision, current source-rights and verification checks, and review of any related fields. A removed listing must not silently reappear through imports, caches, backups or derivative projections. Any future technical implementation must test suppression/deletion propagation against the LPS-14 lifecycle matrix.

## 11. Roles, accountability and separation of duties

The following are **role definitions, not appointments**:

| Role | Responsibility | Minimum control |
|---|---|---|
| Intake coordinator | Register, classify and acknowledge cases | No unilateral factual adjudication |
| Identity/authority verifier | Assess requester identity/authority | Access only to minimum verification data |
| Evidence reviewer | Assess claim and evidence | Conflict declaration; documented rationale |
| Decision owner | Approve correction, suppression or removal | Authority and decision scope recorded |
| Appeal reviewer | Reconsider disputed decision | Independent of original decision where feasible |
| Privacy/safety escalation owner | Handle urgent privacy/safety risk | Competence and escalation coverage |
| Source-rights/legal reviewer | Assess legal/source-rights issues | Qualified, scoped review where required |
| Publication operator | Apply approved outcome | Cannot alter decision or evidence |
| Records/retention owner | Apply retention and deletion controls | LPS-14 schedule and evidence |

For current repository-only development, the accepted owner-led single-person model remains unchanged. This framework does not appoint a team, deputy, external reviewer or operational service owner. Before real service activation, named primary and deputy role holders, competence, availability, conflict controls, coverage, escalation and written acceptance must be evidenced. Where the same person must perform multiple roles in a small operation, risk-based compensating review must be specified and accepted; high-risk professional decisions cannot be self-certified by an unqualified operator.

## 12. Privacy, security, abuse prevention and recordkeeping

A future service must:
- collect only information necessary to identify the listing, claim and authority;
- avoid public uploads and public case discussion;
- separate identity/authority evidence from factual case evidence and restrict access by role;
- never request student/child/guardian records for ordinary institute listing corrections;
- use approved secure channels and retention periods only after LPS-14 inventory and qualified review;
- define deletion, legal hold, access logging, breach response and data-subject request handling;
- protect against impersonation, forged documents, malicious mass requests, harassment, threats, extortion and attempts to suppress truthful information;
- rate-limit and deduplicate abusive patterns only through separately reviewed implementation;
- avoid disclosing whether a confidential person submitted a complaint when that disclosure could create risk;
- record access, decisions, changes, reasons and evidence references in a tamper-evident or otherwise controlled audit mechanism;
- ensure retention is not indefinite and deletion is propagated to derived records and backups according to approved policy.

No security mechanism, retention duration or operational SLA is implemented by this document.

## 13. Communication templates

These are wording templates only. They do not create a contact channel or promise a response time.

**A. Receipt acknowledgement**

> We have recorded your request under reference [CASE-ID]. This confirms receipt only; it is not a finding that the information is incorrect or that the requested change will be made. We will assess the specific claim and any necessary authority or evidence checks under the applicable process.

**B. Request for minimum additional information**

> We cannot yet assess [CLAIM/FIELD] because [SPECIFIC REASON]. Please provide only [MINIMUM REQUIRED ITEM]. Do not send student, child, guardian, staff or other unrelated personal records. The request remains pending while the necessary information is assessed.

**C. Decision — correction accepted**

> We accepted the request for [FIELD] based on [GENERAL EVIDENCE CATEGORY]. The listing was updated on [DATE]. The decision applies only to [DEFINED SCOPE] and does not imply endorsement or verification of other fields.

**D. Decision — no change**

> We reviewed the request and the evidence available for [FIELD]. We are not changing the listing because [REASONED, NON-CONFIDENTIAL BASIS]. The decision is limited to the evidence and scope reviewed. You may request reconsideration on [ELIGIBLE GROUNDS] through the approved process.

**E. Interim restriction**

> The affected information is temporarily restricted while a material concern is reviewed. This is a precautionary measure, not a final finding against any party.

**F. Appeal outcome**

> The appeal was [UPHELD / VARIED / SET ASIDE / REMITTED] because [REASONED BASIS]. The resulting action is [ACTION]. The appeal review considered [SCOPE] and does not determine matters outside that scope.

**G. Out-of-scope request**

> This process handles factual listing, authority, privacy and related institute-record concerns. It does not provide public reviews, ratings, advertising disputes or a forum for personal allegations. Your request is [DECLINED / REFERRED] because [REASON].

## 14. Synthetic case scenarios

All cases below are fictional and are not evidence about any real institution.

1. **Fee correction:** a fictional verified delegate challenges a fee value and supplies a fictional dated notice. Authority is checked separately; the notice is assessed for scope/date/rights; only the fee field may be corrected.
2. **Unauthorized requester:** a person claims to be a principal but cannot demonstrate authority. The request may still be assessed as a factual tip, but no privileged account or authority-based change is granted.
3. **Campus conflation:** two fictional campuses share similar names. Both records are held from automatic merging until distinct identity and location evidence is assessed.
4. **Privacy exposure:** a listing contains a staff member's personal phone number. The field is restricted pending privacy review; no identity or student records are requested.
5. **Recognition dispute:** an institute challenges a recognition statement. The case is referred to the relevant qualified/authoritative review; a requester assertion alone does not determine status.
6. **Source withdrawal:** a source's permitted use is withdrawn. Attribution/link and affected values are reviewed under LPS-15/LPS-16; the system must not continue presenting the source as approved.
7. **Appeal with new evidence:** a decision is appealed with material new fictional evidence. A separate reviewer reassesses it and records whether the original decision is upheld or varied.
8. **Abusive mass requests:** repeated unsupported requests target unrelated listings. The service applies a documented abuse policy while preserving a fair route for genuine corrections.

## 15. Future implementation acceptance criteria

GAP-04 cannot be marked implemented until a separately authorized implementation and evidence package demonstrates:

1. Published, understandable scope and eligibility rules; no public UGC/reviews/ratings by implication.
2. Secure, accessible and privacy-reviewed intake with data minimization and safe alternatives.
3. Separate identity/authority verification states, scope, expiry and revocation.
4. Evidence lineage tied to the exact field/value version and LPS-16 verification state.
5. Case state machine with authorized transitions, reason codes, timestamps and audit history.
6. Risk-based triage, documented interim restrictions and review points.
7. Decision outcomes for correction, partial correction, no change, suppression, removal and referral.
8. Fair appeal/reconsideration route with independence controls and reasoned outcomes.
9. Role register with named primary/deputy owners, competence, coverage, conflicts and written acceptance.
10. Privacy, security, abuse, retention, deletion, legal-hold and breach handling aligned to LPS-14.
11. Source-rights review and qualified legal/privacy/safeguarding escalation aligned to LPS-15 and applicable jurisdiction.
12. Public projection updates aligned to LPS-16, including stale/disputed/withdrawn states and no overstatement.
13. Synthetic tests for authorized/unauthorized representatives, delegation expiry, impersonation, conflicts, privacy exclusions, escalation, appeals, partial corrections, removal, restoration and audit integrity.
14. User comprehension/accessibility evaluation and documented remediation.
15. Product Owner acceptance of exact evidence and separate exact-scope authorization before real service activation.

A policy document, sample template, synthetic fixture or CI pass alone is not proof of operational readiness.

## 16. Stop conditions

Stop, restrict or refer rather than make an unsupported decision if:
- requester authority is unclear and the action requires privileged authority;
- evidence is insufficient, contradictory, stale or potentially fabricated;
- a claim concerns recognition, legal rights, child safeguarding, privacy or source rights beyond internal competence;
- the case includes child/student/guardian information or unnecessary personal records;
- there is credible immediate safety, impersonation, fraud, threat or unlawful disclosure risk;
- a decision-maker has a conflict of interest or required independent review is unavailable;
- retention, deletion, secure handling or auditability cannot be demonstrated;
- a requested action would suppress truthful information without a justified basis;
- the work requires real institute contact/data, public intake activation, hosted access, external services, deployment, pilot, new spend or scope expansion.

## 17. Relationship to prior agendas and gap register

- **LPS-11/LPS-12:** GAP-04 was identified as an operational correction/complaint/appeal gap, not merely a CRUD feature.
- **LPS-13:** material changes to request scope, decision rules, roles, field behavior or publication require change-impact assessment.
- **LPS-14:** case evidence, identity/authority data, audit records, attachments, exports and backups must be included in the future data inventory, retention and deletion schedule.
- **LPS-15:** source-rights disputes and proposed source uses require source-specific rights decisions and qualified review.
- **LPS-16:** corrections must update field-level provenance, verification state, freshness and public disclosure consistently.
- **GAP-01/02/03/05/06:** remain separate workstreams; LPS-17 does not close them or satisfy their prerequisites.

## 18. Final disposition

- [x] Request taxonomy and service boundaries documented.
- [x] Identity and institutional authority verification separated and defined.
- [x] Evidence assessment and provenance requirements documented.
- [x] Case lifecycle, states, triage and interim protections defined.
- [x] Decision outcomes, appeal and reconsideration framework defined.
- [x] Field/listing removal, suppression and restoration controls defined.
- [x] Role definitions, separation of duties and future staffing evidence defined.
- [x] Privacy, security, abuse prevention and recordkeeping requirements documented.
- [x] Communication templates and synthetic case scenarios included.
- [x] Future implementation acceptance criteria and stop conditions recorded.
- [ ] Real intake channel, operational staffing or service-level commitments — not created.
- [ ] Runtime workflow/UI/API implementation and synthetic implementation tests — not performed in this documentation agenda.
- [ ] Qualified legal/privacy/safeguarding review — not received.
- [ ] Public complaint, appeal, correction or removal service activation — not authorized.

**Final disposition:** LPS-17 is COMPLETE as a repository-only operating framework. **GAP-04 remains OPEN / DESIGNED / NOT IMPLEMENTED / NOT CLOSED.** No institution or person was contacted; no real data or evidence was received; no public service was activated. M3-11 remains BLOCKED / NOT ACCEPTED, all ten M3-11 gate dispositions remain unchanged, and overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
