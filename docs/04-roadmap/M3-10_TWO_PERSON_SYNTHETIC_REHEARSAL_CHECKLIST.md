# M3-10 — Two-Person Synthetic University Workflow Rehearsal Checklist

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Work type:** Non-human tabletop / documentation exercise only  
**Status:** PREPARED — NOT EXECUTED  
**Scenario:** `SYN-LHR-UNI-001`  
**Baseline main:** `a51e6654119af45c053cc5a1c3ff8e59926f55ef`

## 1. Purpose

Give the Product Owner and one ordinary-experience administrative assistant a simple way to walk through the already documented V2 university representative proposal/correction workflow, identify unclear instructions and record questions. This is a paper-based tabletop rehearsal using fictional information only.

This is not a software test, browser usability test, user research session, pilot, security audit, legal/privacy review or approval. It does not require either person to access the application, create accounts, use credentials, contact institutions or interact with real users.

## 2. People and responsibilities

| Person | Tabletop role | What they do |
|---|---|---|
| Product Owner | Facilitator / decision owner | Reads each scenario, explains the intended project boundary, decides whether an answer is clear or needs technical/specialist follow-up, and may stop the exercise. |
| Administrative Assistant (ordinary experience) | Checklist reader / note-taker | Reads the prompts, records unclear wording and questions, checks that the expected evidence is identified, and escalates anything uncertain to the Product Owner. |

The assistant is not expected to assess code, approve security, decide legal/privacy matters, adjudicate institution claims or certify accessibility. The two people may discuss what the documents say, but must not present this as independent expert review.

## 3. Synthetic-only scenario card

Use only these fixed fictional values:

| Field | Synthetic value |
|---|---|
| Scenario ID | `SYN-LHR-UNI-001` |
| Locality label | Lahore, Punjab, Pakistan (scenario label only) |
| Category | `university` |
| Synthetic institution ID | `syn-inst-lhr-uni-001` |
| Synthetic display name | `Synthetic University Lahore One` |
| Example field | `display_name` |
| Proposed synthetic value | `Synthetic University Lahore One — Updated` |
| Evidence reference | `SYN-EVIDENCE-001` (fabricated metadata-only reference; not a URL or source) |

Do not replace these values with a real institution, real address, real website, real source, personal name, contact detail, document or credential. Do not infer that any real institution exists or has any particular recognition or status.

## 4. Before starting

- [ ] Confirm both people understand that this is a paper tabletop, not a live pilot or application test.
- [ ] Open only the approved V2 project documents listed below.
- [ ] Use the synthetic scenario card above; do not add real-world information.
- [ ] Keep a simple notes sheet with scenario step, result (clear / unclear / blocked), question and follow-up owner.
- [ ] Do not sign into any hosted or production system, create accounts, access secrets or run commands.
- [ ] Confirm no recruitment, participant contact, consent, recording or data collection is taking place.
- [ ] Confirm no spending, vendor, dependency, external service or source access is involved.

**Reference documents:**
- [University Representative Workflow Implementation Record](M3-10_UNIVERSITY_REPRESENTATIVE_WORKFLOW_IMPLEMENTATION_RECORD.md)
- [University Workflow Adversarial Hardening Record](M3-10_UNIVERSITY_WORKFLOW_ADVERSARIAL_HARDENING_RECORD.md)
- [Two-Person Administrative Roles and Readiness Checklist](M3-10_TWO_PERSON_ADMIN_AND_REVIEW_TASK_CHECKLIST.md)
- [University Synthetic Workflow Tabletop and Acceptance Evidence](M3-10_UNIVERSITY_SYNTHETIC_WORKFLOW_TABLETOP.md) — earlier scenario design; route-absence statements in that historical record are superseded by PR #248's later API implementation record.

## 5. Rehearsal steps

For each step, the facilitator reads the situation. The assistant reads the expected outcome and records whether the documentation makes the rule understandable. Do not perform actual HTTP requests or change application data.

| Step | Fictional situation | Expected answer to identify | Record |
|---|---|---|---|
| R01 | A synthetic university representative wants to submit a profile correction. | Only an authenticated, verified, active representative with the exact institution scope and university category may submit. Actor and source context must be server-derived. | [ ] Clear [ ] Unclear |
| R02 | The representative proposes the synthetic display-name value using `SYN-EVIDENCE-001`. | The proposal is recorded for review; the evidence reference is synthetic metadata only. No direct publication occurs. | [ ] Clear [ ] Unclear |
| R03 | The same person tries to review their own submission. | Separation of duties blocks self-review; the submitter cannot act as the independent reviewer for that case. | [ ] Clear [ ] Unclear |
| R04 | An independent, eligible reviewer requests changes. | The case moves to the changes-requested path; the original submitter may then submit a correction. | [ ] Clear [ ] Unclear |
| R05 | A different person attempts to submit the correction on behalf of the original submitter. | The correction route is limited to the original submitter and exact institution/case scope; unauthorized actors are denied. | [ ] Clear [ ] Unclear |
| R06 | The original submitter corrects the proposed value. | A new immutable successor is created; the prior version remains preserved; a new review case is created; audit/supersession history is retained. | [ ] Clear [ ] Unclear |
| R07 | A revoked, expired or inactive representative attempts another action. | The action fails closed; no unauthorized claim or transition is created. | [ ] Clear [ ] Unclear |
| R08 | A request contains forged actor, capability, institution scope, source or public-publication fields. | Client-supplied authority and publication fields are ignored or rejected; server-side identity and scope controls remain authoritative. | [ ] Clear [ ] Unclear |
| R09 | A retry reuses an idempotency key with a changed payload. | Conflicting replay is rejected; it must not create a duplicate successor or review case. | [ ] Clear [ ] Unclear |
| R10 | Audit persistence fails during a transition. | The operation rolls back atomically; no partial status/history state is accepted. | [ ] Clear [ ] Unclear |
| R11 | Someone asks whether the approved correction is now publicly published. | This workflow has no adjudication/publication endpoint. Do not claim publication or expose the proposal publicly. | [ ] Clear [ ] Unclear |
| R12 | Someone suggests using a real Lahore institution to make the exercise realistic. | Stop that suggestion. Keep the exercise entirely synthetic; no real institution or source data is allowed. | [ ] Clear [ ] Unclear |

## 6. How to record findings

Use one row per issue. Do not record personal information.

| Step | Result | What was unclear / issue | Follow-up owner | Status |
|---|---|---|---|---|
| R__ | Clear / Unclear / Blocked |  | Product Owner / technical follow-up / qualified reviewer | Open / Closed |

Rules:
- “Clear” means the two readers understood what the governing document says; it does not prove the software works.
- “Unclear” means the document or role boundary needs clarification; record the exact question.
- “Blocked” means a stop condition occurred or the answer would require unauthorized access, data or expertise. Stop rather than improvising.
- The assistant may record issues but must not declare a security, legal, privacy, safeguarding or accessibility issue resolved.
- Any code defect discovered from a separate authorized synthetic CI run must be handled under its own implementation authorization and exact-head validation.

## 7. Stop conditions

Stop immediately and notify the Product Owner if:
1. Real personal, student, guardian, staff, institution or source information appears.
2. Anyone proposes participant recruitment, contact, consent, interview, survey or human usability sessions.
3. Anyone requests production, V1, Hostinger/hPanel, live database, hosted environment, deployment or release access.
4. Any external source, URL verification, scraping, connector, external API, AI/model service or network access is proposed.
5. A credential, secret, private field or unexpected data is exposed.
6. Public UGC, reviews, ratings, reporting, moderation or publication is proposed for activation.
7. Deeni Madaris is exposed or its default-OFF restriction is questioned.
8. New spending, vendor, procurement, dependency or paid service is proposed.
9. A decision requires specialist competence or accountable human operations that neither person has.
10. The discussion drifts from a paper tabletop into actual user testing or live operation.

A stop is a recorded blocked result, not permission to work around the restriction.

## 8. Completion record — fill only after the tabletop actually occurs

- Exercise date: **Not recorded — not yet executed**
- Scenario: `SYN-LHR-UNI-001`
- Product Owner facilitator: **Not recorded**
- Administrative assistant: **Not recorded**
- Steps completed: **Not recorded**
- Findings: **Not recorded**
- Stop conditions triggered: **Not recorded**
- Follow-up actions: **Not recorded**
- Product Owner acknowledgement: **Pending**

Do not mark this checklist executed or complete until an actual paper tabletop has been conducted and the record is filled in. No participant names or personal details are required in this repository record.

## 9. What this rehearsal can and cannot establish

It can help two project administrators understand the written workflow, locate missing instructions and organize follow-up questions. It cannot establish technical correctness, independent security, legal/privacy compliance, safeguarding, accessibility, operational readiness, human usability or pilot success.

Existing PR #248 implementation and PR #250 adversarial test evidence remain bounded synthetic engineering evidence. This paper exercise creates no new test result and does not replace exact-head CI.

## 10. Final authority and status

This checklist is a preparation aid for a non-human tabletop only. It does not approve the pilot charter, resolve the pre-launch student research deferral, appoint specialist reviewers or operational owners, authorize participant contact, process real data, provision an environment, activate a feature, deploy, release, spend or authorize M3-11.

**Current status:** Checklist prepared; tabletop NOT EXECUTED; pilot readiness NOT ACCEPTED; no pilot go/no-go issued; M3-11 NOT AUTHORIZED.
