# M3-10 — Owner Decision and Qualified Review Pack

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-16  
**Baseline main:** `c26cd00c8caf0cc57c372a2ab1b5aaba86fe9b7a`  
**Status:** DECISION REQUEST — no owner decisions or specialist approvals are implied by this document

## 1. Purpose and authority boundary

This pack converts the outstanding M3-10 readiness blockers into explicit decisions and evidence requests. It is a decision aid, not an approval, legal opinion, privacy assessment, safeguarding assessment, security certification, staffing assignment or pilot authorization.

The existing M3-10 authorization remains limited to documentation, repository reconciliation and synthetic-only local/CI or non-human tabletop work. No participant recruitment/contact, human research, real or personal data, external-source access, public UGC/reviews/moderation, hosted pilot, production/V1/Hostinger access, deployment, release, launch, vendor, dependency or spend is authorized. Deeni Madaris remains default-OFF with zero public exposure. The pre-launch student research deferral remains binding.

## 2. Product Owner — choose the current M3-10 path

Record one decision. Silence is not approval.

| Option | Decision | Consequence |
|---|---|---|
| A | **Continue synthetic-only readiness; defer any human/data-bearing pilot** | Continue documentation, synthetic local/CI tests and non-human tabletop exercises. M3-10 remains in progress; no real-world pilot or launch-readiness claim. |
| B | **Request a separately reviewed, narrowly bounded pilot proposal** | This is permission to prepare a proposal only. It does not authorize recruitment, participants, data processing, source access, hosted activity, feature activation, deployment or spend. All applicable reviews and a separate explicit authorization are still required before activity. |

**Owner decision:** OPTION B SELECTED — prepare a narrowly bounded future pilot proposal for separate review only.  
**Decision date:** 2026-11-17.  
**Exact option and scope:** Adult-only, invitation-based future evaluation proposal for one V2 institution/university profile review-and-correction workflow, using fabricated synthetic records in an isolated non-production environment; proposal descriptors are Lahore, Punjab, Pakistan and category university.  
**Conditions / exclusions:** Proposal preparation only. No recruitment, contact, participants, consent, human sessions, real/personal/source data, external sources, hosted activity, feature activation, deployment, release, spend or M3-11. Existing pre-launch research deferral remains binding.  
**Owner identity and authority:** Product Owner decision communicated in the project conversation; this pack does not record personal identity details.

## 3. Charter decisions (only if Option B is selected)

The Product Owner must specify each field before a proposal can be assessed. Do not enter personal or participant information in this repository.

| Decision field | Required bounded answer | Current status |
|---|---|---|
| Problem and purpose | Assess whether an adult institutional representative can understand one V2 profile review/correction workflow; no accuracy, coverage, student-discovery or launch hypothesis | PROPOSAL ONLY; not approved for activity |
| Pilot type | Future adult-only invitation-based usability evaluation; synthetic records only; isolated non-production environment not provisioned | PROPOSAL ONLY; human activity not authorized |
| Geography | Lahore, Punjab, Pakistan | PROPOSAL DESCRIPTOR ONLY |
| Institution/provider scope | University category only | PROPOSAL DESCRIPTOR ONLY |
| Product surfaces | Authenticated university representative proposal/correction HTTP routes and independent editorial-review routes; no adjudication/publication route; no browser UI acceptance evidenced | API workflow implemented; pilot surface not approved |
| Population | Adults only; no students, minors, guardians or vulnerable participants | PROPOSAL ONLY; eligibility/research deferral and qualified review unresolved |
| Duration | Start/end window, review cadence and automatic expiry | OPEN |
| Success criteria | Owner-defined measurable outcomes and evidence method | OPEN |
| Stop criteria | Defect, safety, privacy, security, support and scope-change triggers | OPEN |
| Cost | Confirm zero-cost fit or submit a separate cost proposal | NO NEW SPEND AUTHORIZED |
| Exit | Closeout, access revocation, deletion and unresolved-issue handling | OPEN |

No numeric target, sample size, retention period, SLO, RPO/RTO or budget is inferred. If the proposal cannot remain within the existing no-spend and no-hosted-activity boundaries, it must stop for separate authorization.

## 4. Required human accountability assignments

Assignments must be named, accepted by the individuals, and include authority, availability, backup and escalation route. ChatGPT is not an accountable human operator or independent approver.

| Role | Minimum evidence | Status |
|---|---|---|
| Product Owner / pilot sponsor | Option B proposal-only decision recorded; no pilot sponsor authorization or operational duty accepted | PROPOSAL DECISION RECORDED; PILOT ROLE NOT ASSIGNED |
| Pilot accountable lead | Named human, authority, availability and backup | NOT ASSIGNED |
| Technical operations | Named V2-only operator, access boundary and coverage | NOT ASSIGNED |
| Security incident lead | Named responder and independent escalation | NOT ASSIGNED |
| Privacy/data owner | Purpose, access, correction, deletion and retention authority | NOT ASSIGNED |
| Safeguarding lead (if relevant) | Qualified human, safe escalation/referral process | NOT ASSIGNED |
| Support owner (if relevant) | Channel, hours, response/closure process and backup | NOT ASSIGNED |
| Moderation/appeals (only if separately approved) | Trained independent roles and coverage | NOT STAFFED; PUBLIC UGC DISABLED |

## 5. Qualified review requests

Reviewers must be appropriately qualified and independent where required. Their written outputs, scope, date, limitations and conditions must be retained in the approved project record. This pack does not substitute for those reviews.

| Review | Reviewer required | Questions to resolve | Current status |
|---|---|---|---|
| Legal/privacy | Qualified reviewer for applicable Pakistan and other relevant jurisdictions | Purpose, lawful basis, notices, roles, processor/location, data subject rights, retention/deletion, cross-border issues | REQUIRED — NOT EVIDENCED |
| Child safeguarding | Qualified safeguarding reviewer if any minor/vulnerable population is proposed | Population risk, eligibility, guardian/consent requirements, safe contact, escalation and referral | REQUIRED IF RELEVANT — NOT EVIDENCED; no minors approved |
| Independent security | Reviewer independent of implementation | Threat model, access boundaries, secrets, isolation, public/private exposure, incident and recovery controls | REQUIRED — NOT EVIDENCED |
| Accessibility | Qualified human review | Applicable accessibility standard, assistive-technology findings and remediation | PARTIAL AUTOMATED EVIDENCE ONLY |
| Recovery/operations | Accountable V2 operator and reviewer | V2 environment-specific backup/restore, rollback, access revocation, continuity and measured recovery | NOT EVIDENCED; local SQLite test is not hosted recovery |

## 6. Evidence register required before any future pilot decision

For every applicable item, record the artifact link, version/hash, reviewer/owner, date, outcome, limitations and expiry/conditions.

- Approved bounded charter and explicit owner authorization.
- Approved participant protocol and consent/withdrawal process, if people are ever proposed; existing research deferral must first be formally resolved.
- Field-level data inventory, purpose/necessity, source authority and lifecycle, if data-bearing scope is ever proposed.
- Written qualified legal/privacy and safeguarding outcomes as applicable.
- Written independent security review and closed/high-risk exception disposition.
- Named and accepted human operational roles and coverage.
- Environment-specific recovery/rollback evidence for the exact proposed environment.
- Accessibility review and owner-approved success/stop thresholds.
- Cost/vendor assessment and separate approval if any cost or third party is proposed.
- Final acceptance report and explicit go/no-go by the accountable owner.

## 7. Decision and approval record

| Item | Decision / evidence | Owner or reviewer | Date | Status |
|---|---|---|---|---|
| Product Owner path (A or B) | Option B selected for proposal preparation only; no pilot activity authorized | Product Owner | 2026-11-17 | RECORDED — PROPOSAL ONLY |
| Bounded charter | Not supplied | Product Owner | — | OPEN |
| Legal/privacy review | Not supplied | Qualified reviewer | — | NOT EVIDENCED |
| Child-safeguarding review | Not supplied | Qualified reviewer, if applicable | — | NOT EVIDENCED |
| Independent security review | Not supplied | Independent reviewer | — | NOT EVIDENCED |
| Human operations roster | Not supplied | Accountable human owners | — | NOT ASSIGNED |
| Pilot acceptance / go-no-go | Not applicable | Product Owner and accountable reviewers | — | NOT STARTED |
| M3-11 launch authorization | Separate written authorization absent | Product Owner | — | NOT AUTHORIZED |

## 8. Current decision

**Option B is recorded as selected for bounded proposal preparation only. The proposal is not an approved pilot charter. No pilot activity is approved. No specialist review is evidenced. No human operations roster is assigned. M3-10 remains IN PROGRESS; pilot readiness remains NOT ACCEPTED; M3-11 remains NOT AUTHORIZED.**

The remaining owner decisions are the exact pilot charter, scope, thresholds and any later activity authorization. Qualified reviewers and accountable human owners must provide their own independent written decisions. Until all applicable gates pass and separate activity authorization is issued, continue only documentation and synthetic-only local/CI work.
