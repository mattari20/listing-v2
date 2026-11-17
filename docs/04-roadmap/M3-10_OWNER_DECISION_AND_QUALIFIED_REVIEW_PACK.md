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

**Owner decision:** [NOT RECORDED]  
**Decision date:** [NOT RECORDED]  
**Exact option and scope:** [OWNER TO COMPLETE]  
**Conditions / exclusions:** [OWNER TO COMPLETE]  
**Owner identity and authority:** [OWNER TO COMPLETE]

## 3. Charter decisions (only if Option B is selected)

The Product Owner must specify each field before a proposal can be assessed. Do not enter personal or participant information in this repository.

| Decision field | Required bounded answer | Current status |
|---|---|---|
| Problem and purpose | User problem, hypothesis and what is explicitly not being tested | OPEN |
| Pilot type | Exact activity and whether it remains synthetic-only | OPEN |
| Geography | Country/province/district/city and any exclusions | OPEN |
| Institution/provider scope | Categories and eligibility rules; no named participants | OPEN |
| Product surfaces | Exact V2 routes/workflows and capabilities in scope | OPEN |
| Population | Adult-only or other proposed population; justification and exclusions | NOT APPROVED |
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
| Product Owner / pilot sponsor | Written scope decision and stop authority | NOT RECORDED |
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
| Product Owner path (A or B) | Not supplied | Product Owner | — | OPEN |
| Bounded charter | Not supplied | Product Owner | — | OPEN |
| Legal/privacy review | Not supplied | Qualified reviewer | — | NOT EVIDENCED |
| Child-safeguarding review | Not supplied | Qualified reviewer, if applicable | — | NOT EVIDENCED |
| Independent security review | Not supplied | Independent reviewer | — | NOT EVIDENCED |
| Human operations roster | Not supplied | Accountable human owners | — | NOT ASSIGNED |
| Pilot acceptance / go-no-go | Not applicable | Product Owner and accountable reviewers | — | NOT STARTED |
| M3-11 launch authorization | Separate written authorization absent | Product Owner | — | NOT AUTHORIZED |

## 8. Current decision

**No owner path decision recorded. No pilot proposed or approved. No specialist review evidenced. No human operations roster assigned. M3-10 remains IN PROGRESS and synthetic-only. Pilot readiness remains NOT ACCEPTED. M3-11 production launch remains NOT AUTHORIZED.**

The next action requiring the Product Owner is to record Option A or Option B and, only if Option B is chosen, complete the bounded proposal fields. Qualified reviewers and accountable human owners must then provide their own written decisions. Until then, continue only the already-authorized synthetic-only readiness work.
