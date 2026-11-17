# M3-10 — Option B: Narrowly Bounded Pilot Proposal (For Review Only)

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-17  
**Baseline main:** `db26269288f47e4beba85cbe78a3d0868e0c3bca`  
**Status:** PROPOSAL ONLY — NOT APPROVED, NOT AUTHORIZED TO CONDUCT

## 1. Executive proposal

Following the Product Owner's selection of Option B, this document prepares a conservative candidate for separate owner and qualified-review consideration.

**Candidate:** a future, adult-only, invitation-based usability evaluation of one V2 institution/university profile review-and-correction workflow, using fabricated synthetic records in an isolated non-production environment, but only after a user-facing workflow is separately authorized and implemented.

**Current implementation qualification (repository verification 2026-11-17):** the V2 service-layer correction, editorial review and publication controls exist, and the controlled provider-category vocabulary includes `university`; however, the current HTTP surface has no authenticated university profile correction/review route or representative-facing interface. The current candidate therefore cannot be run as a user-facing usability evaluation. The permitted immediate work is repository-only verification and a non-human synthetic tabletop. Any UI/route implementation requires separate explicit authorization. See [M3-10 University Workflow Verification Record](M3-10_UNIVERSITY_WORKFLOW_VERIFICATION_RECORD.md).

This candidate is intentionally narrower than a live directory pilot:
- one future authenticated V2 university profile submission/correction workflow, after separate implementation authorization and end-to-end route/permission verification;
- one adult user role, provisionally an authorized institution/provider representative;
- one proposed locality — Lahore, Punjab, Pakistan — and one proposed provider category — universities and degree-awarding institutions — selected by the Product Owner for proposal preparation only;
- synthetic records only; no real institution, student, guardian, staff, provider or source data;
- no minors, students, guardians or vulnerable participants;
- no public listings, UGC, ratings, reviews, reporting or public moderation;
- no external sources, scraping, ingestion, AI/model services or connectors;
- no hosted environment, production, V1, Hostinger/hPanel, deployment, release or URL cutover;
- no vendor, dependency, procurement or spend.

The proposal does not resolve or override the existing pre-launch student research deferral. Any future human session remains prohibited until that deferral is explicitly resolved and all approvals and a separate activity authorization are recorded.

## 2. Candidate purpose and hypotheses

**Problem to examine:** whether an adult institutional representative can understand the selected V2 profile review/correction workflow and identify what information requires correction, without relying on real institutional or personal data.

**Candidate hypotheses for later approval:**
1. The workflow communicates the distinction between a proposed correction and an approved/published change.
2. The user can identify the evidence and status information required by the workflow.
3. The user can complete the bounded synthetic task without crossing role or publication boundaries.
4. The interface provides understandable validation and recovery from ordinary user errors.

These are hypotheses only. They are not approved success criteria. The Product Owner and qualified reviewers must define measurable thresholds, evidence collection, permitted observations and stop conditions before any human activity.

**Out of scope:** national coverage, source completeness, real-world data accuracy, student discovery outcomes, institutional verification at scale, public trust, model/agent performance, moderation effectiveness, production capacity, security certification and launch readiness.

## 3. Proposed scope and unresolved owner choices

| Dimension | Candidate boundary | Required decision / status |
|---|---|---|
| Product | V2 only | Confirmed by existing M3-10 boundary |
| Workflow | Future authenticated university profile submission/correction workflow | Service-layer controls exist; user-facing route/interface is absent and requires separate implementation authorization |
| User role | Adult authorized institution/provider representative | Owner must confirm role and eligibility; NOT APPROVED |
| Geography | Lahore, Punjab, Pakistan | Selected by Product Owner for proposal preparation only; not approval to conduct |
| Provider category | Universities and degree-awarding institutions | Selected by Product Owner for proposal preparation only; not approval to conduct |
| Participants | Adults only; no students, minors, guardians or vulnerable populations | Population and eligibility protocol require qualified review; NOT APPROVED |
| Cohort size | Not proposed | Owner and qualified reviewer must determine; no number inferred |
| Duration | Short, fixed, time-limited window | Dates and support coverage not set |
| Environment | Isolated non-production V2 environment | Not provisioned or authorized; no hosted activity permitted now |
| Data | Deterministic fabricated records only | No real/personal/source data |
| Evidence | Pre-approved task outcomes and issue observations only | Method and retention require review |
| Cost | Zero additional spend | No vendor or new dependency; if zero-cost fit cannot be proven, stop |
| Exit | Stop, revoke access, preserve minimal synthetic diagnostics and close out | Detailed operator and deletion responsibilities unassigned |

The proposed locality and provider category are now specified: Lahore, Punjab, Pakistan; universities and degree-awarding institutions. Cohort size, duration, success threshold, retention period, SLO, RPO/RTO and budget remain unresolved and are not invented in this proposal.

## 4. Proposed participant and safeguarding boundary

If a future human evaluation is separately approved:
- participants must be adults acting in a relevant professional capacity;
- no student, minor, guardian or vulnerable-user recruitment or participation;
- no identity documents, birth dates, student records, guardian details or sensitive personal information;
- no compensation or incentives unless separately assessed and approved;
- no audio/video recording, screenshots of personal accounts, or collection of unnecessary demographic data proposed;
- participation must be voluntary, with clear information, consent, withdrawal and complaint routes approved by qualified reviewers;
- no recruitment, contact, interviews, surveys, observation or sessions may begin under this proposal.

The existing student research deferral remains binding. Qualified legal/privacy and safeguarding reviewers must determine whether the proposed activity constitutes research, usability testing or another regulated/controlled activity and what approvals are required. This document makes no legal determination.

## 5. Data and evidence design

**Allowed in current preparation:** fabricated, deterministic fixtures and documentation examples only.

**Not allowed:** real institution/provider records, student/guardian/staff data, participant contact details, source extracts, scraped/public data, credentials, private screenshots or production logs.

Candidate evidence, only after separate approval:
- task completion outcome (pass/fail or owner-approved rubric);
- workflow errors and usability issues, recorded without personal identifiers;
- synthetic record identifiers only;
- severity and reproducibility of defects;
- participant feedback only if a qualified protocol explicitly approves the questions, method and handling.

Before any future activity, an approved data/evidence schedule must specify purpose, necessity, exact fields, collection method, access, storage location, retention, deletion, correction, export and incident handling. No retention period or lawful basis is asserted here.

## 6. Proposed operating model

No operational roles are currently assigned. Before activity, named humans must accept these responsibilities:

| Role | Responsibility | Status |
|---|---|---|
| Product Owner / sponsor | Approve exact charter, thresholds and stop/resume decisions | Decision required |
| Pilot lead | Session coordination, scope control and daily stop authority | Not assigned |
| Technical operator | Isolated V2 environment, access control, reset and evidence integrity | Not assigned |
| Privacy/data owner | Data minimization, access, retention and deletion | Not assigned |
| Safeguarding contact | Qualified advice and safe escalation, if applicable | Not assigned |
| Security incident lead | Incident triage and independent escalation | Not assigned |
| Support contact | Participant support and complaint routing, if applicable | Not assigned |

ChatGPT cannot fill these roles, provide independent approval or serve as an emergency contact. A single builder does not constitute a staffed operations or safeguarding function.

## 7. Review gates before any human or data-bearing activity

All applicable items below must be completed with written evidence and conditions:

1. Product Owner approves exact locality, provider category, role, workflow, duration, cohort and success/stop criteria.
2. Exact V2 routes, authorization policy and synthetic workflow are verified against current main.
3. Existing research deferral is explicitly resolved by the appropriate owner; deferred instruments remain inactive until then.
4. Qualified legal/privacy reviewer approves the activity classification, notices/consent, data schedule and retention/deletion design.
5. Qualified safeguarding reviewer determines applicability and approves safeguards; minors remain excluded from this candidate.
6. Independent security reviewer approves threat model, isolation, access, exposure and incident controls.
7. Named human pilot, technical, privacy, security and support roles accept duties and coverage.
8. Accessibility review and defect disposition are complete for the proposed workflow.
9. Isolated non-production environment, restore/reset procedure and access revocation are independently checked. No hosted environment may be created under current authorization.
10. Zero-cost feasibility is evidenced. Any new cost, vendor or dependency requires separate approval.
11. A separate written authorization explicitly permits the exact activity after all prerequisites pass.

A missing, expired, conditional or adverse review blocks the activity. Silence is not approval.

## 8. Proposed success, stop and exit contract

**Success measures:** intentionally not quantified. The Product Owner must set thresholds before activity, using the approved task rubric and a justified evidence method.

**Immediate stop triggers:**
- any minor/vulnerable participant or unauthorized participant contact;
- unexpected personal, student, guardian, institutional or source data;
- any access to V1, production, Hostinger or a live database;
- any external network/API, connector, AI/model service or source retrieval;
- any public exposure, UGC/review/report activation or Deeni Madaris leakage;
- any secret, private data or suppressed-field exposure;
- any unapproved cost, vendor, dependency or environment;
- missing operator, support or safeguarding coverage;
- any security, privacy, legal or safeguarding concern;
- scope drift or an unapproved change to data, role, workflow or environment.

On stop: cease the activity, revoke only the separately approved pilot access, preserve minimal non-sensitive evidence, notify the named accountable human owner, and do not retry or broaden permissions without a new written decision.

**Exit:** close access, reconcile defects, remove temporary synthetic accounts/data, document evidence and limitations, confirm deletion/reset, record unresolved risks and obtain owner sign-off. No real-data deletion process is implied because real data is excluded.

## 9. Current authorization matrix

| Activity | Current status |
|---|---|
| Prepare this proposal and documentation | ALLOWED |
| Synthetic-only local/CI review of the candidate workflow | ALLOWED within existing M3-10 scope |
| Non-human tabletop using fictional scenarios | ALLOWED within existing M3-10 scope |
| Resolve route/permission details by repository-only inspection | ALLOWED |
| Recruit or contact participants | NOT AUTHORIZED |
| Conduct interviews, surveys or human usability sessions | NOT AUTHORIZED |
| Collect consent or participant data | NOT AUTHORIZED |
| Use real institutional, student or source data | NOT AUTHORIZED |
| Access external sources or AI/model services | NOT AUTHORIZED |
| Provision hosted preview/pilot or access Hostinger/production/V1 | NOT AUTHORIZED |
| Enable public UGC/reviews/moderation | NOT AUTHORIZED |
| Deploy, release, launch, spend or add vendors/dependencies | NOT AUTHORIZED |

## 10. Owner decision record

The Product Owner's Option B selection authorizes preparation of this proposal only. It does not mean the candidate scope is approved.

| Decision | Status |
|---|---|
| Accept candidate purpose/hypotheses | OWNER DECISION REQUIRED |
| Select proposed locality | SELECTED: Lahore, Punjab, Pakistan — proposal scope only; conduct remains unauthorized |
| Select proposed provider category | SELECTED: universities and degree-awarding institutions — proposal scope only; conduct remains unauthorized |
| Confirm adult professional role | OWNER DECISION REQUIRED |
| Confirm future workflow | SERVICE-LAYER CONTRACT VERIFIED; user-facing route/interface absent; implementation requires separate authorization |
| Set cohort size and duration | OWNER + QUALIFIED REVIEW REQUIRED |
| Approve success/stop thresholds | OWNER DECISION REQUIRED |
| Resolve research deferral | NOT RESOLVED |
| Legal/privacy review | NOT EVIDENCED |
| Safeguarding review | NOT EVIDENCED |
| Independent security review | NOT EVIDENCED |
| Assign accountable human operators | NOT ASSIGNED |
| Approve isolated environment and recovery | NOT AUTHORIZED / NOT EVIDENCED |
| Authorize any human/data-bearing activity | NOT AUTHORIZED |
| M3-11 production launch | NOT AUTHORIZED |

## 11. Recommendation

Proceed only with repository-only verification and a non-human synthetic tabletop for the service-layer workflow. Do not describe or conduct a user-facing usability evaluation until a university representative route/interface is separately authorized, implemented and end-to-end verified. Continue seeking the owner decisions and qualified reviews listed above; keep the candidate proposal provisional until every applicable gate is evidenced.

**M3-10 remains IN PROGRESS. Pilot readiness remains NOT ACCEPTED. No live pilot is approved or underway. M3-11 remains separately gated and NOT AUTHORIZED.**
