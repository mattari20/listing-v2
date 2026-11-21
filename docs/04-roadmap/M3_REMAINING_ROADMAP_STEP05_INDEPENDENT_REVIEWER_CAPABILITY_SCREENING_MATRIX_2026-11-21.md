# M3 Remaining Roadmap Step 05 — Independent Reviewer Capability Screening Matrix

**Date:** 2026-11-21  
**Status:** DOCUMENTARY MATRIX COMPLETE — NO CANDIDATE SCREENED OR CONTACTED  
**Authority:** Repository-only, synthetic/fictional examples only.

## 1. Purpose and governing decision

This matrix operationalizes Product Owner Q5 Option B. A combined reviewer may cover more than one discipline only when competence, relevant experience and independence are evidenced and assessed separately for each assigned discipline. Separate conclusions are required for each discipline. No candidate is presumed qualified.

Priority order remains:
1. Legal, privacy and child safeguarding.
2. Security.
3. Accessibility.

The priority order is sequencing only; it does not waive or reduce any discipline.

## 2. Common screening controls

| Control | Minimum evidence required | Fail-closed outcome |
|---|---|---|
| Identity and affiliation | Identity and current professional/organizational affiliation verified through an approved, proportionate method at a later authorized stage | Do not treat an anonymous or unverifiable profile as screened |
| Scope acceptance | Written acceptance of exact questions, systems/materials, methods, exclusions and deliverables | No scope acceptance means no engagement |
| Competence | Verifiable qualifications, current relevant practice and discipline-specific work examples | Self-description alone is insufficient |
| Independence | Written conflict declaration covering prior involvement, financial/organizational relationships, incentives and other material conflicts | Unresolved material conflict means not independent for that discipline |
| Confidentiality | Approved written confidentiality terms and secure evidence channel, authorized separately | No confidential evidence sharing |
| Deliverables | Signed/dated report with author, scope, evidence/methods, findings, severity rationale, limitations, recommendations and retest needs | Incomplete report cannot support gate acceptance |
| Cost | Written confirmation of PKR 0 total cost, including fees, honoraria, travel, reimbursement, tools and indirect costs | Any cost or expense violates the current boundary; stop |
| Availability and willingness | Written confirmation for exact scope and schedule | No presumed availability or consent |
| Evidence provenance | Record source, date, validity, verification method and reviewer responsible for checking | Untraceable or stale evidence is not accepted |

## 3. Discipline-specific screening

### Track A — Legal, privacy and child safeguarding (first priority)

| Screening dimension | Required evidence / capability | Exclusions and fail-closed rule |
|---|---|---|
| Legal competence | Demonstrable qualification and current experience relevant to Pakistan law and the exact product/data context; ability to distinguish legal advice from general commentary | General technology experience or an unrelated law credential is insufficient |
| Privacy competence | Demonstrated privacy/data-protection assessment experience, data-flow and purpose/necessity analysis, minimization, retention/deletion, rights, security and processor/vendor review as applicable | Do not infer formal PIA/DPIA or legal opinion from an informal review |
| Child safeguarding competence | Demonstrable child-online-safety/safeguarding expertise relevant to age assurance, access restrictions, risks of contact/exposure, reporting and safeguarding controls | General privacy expertise alone does not establish safeguarding competence |
| Independence | Track-specific conflict disclosure and assessment, including prior design/implementation/advisory role | Material involvement in the system under review must be disclosed and evaluated; unresolved conflict fails |
| Separate outputs | Distinct legal, privacy and safeguarding findings or explicit statement that a sub-discipline is outside competence/scope | One blended statement must not conceal missing expertise |

**Mandatory question areas:** adult-only access policy versus enforceable restriction; proportionality and privacy risks of possible age-assurance approaches; data minimization; lawful basis and transparency; retention/deletion; child-safeguarding risks; incident/reporting responsibilities; public listing content and source provenance; limits of conclusions.

### Track S — Independent security (second priority)

| Screening dimension | Required evidence / capability | Exclusions and fail-closed rule |
|---|---|---|
| Technical competence | Verifiable application-security assessment experience relevant to the actual stack and architecture | Generic IT support or a certificate alone is insufficient |
| Method competence | Ability to define authorized test scope, safe methodology, severity, reproducibility and evidence handling | No testing until separate written authorization defines targets, methods, time window and stop conditions |
| Relevant experience | Comparable web application, authorization, data integrity, upload, workflow, API and deployment-boundary assessments as applicable | Claims without verifiable detail are insufficient |
| Independence | Separate conflict declaration; disclose development, code review, hosting, vendor or prior remediation involvement | Unresolved conflict fails |
| Separate outputs | Signed report with scope, methods, findings, severity rationale, limitations, evidence references and retest criteria | No penetration-test or security-certification claim without corresponding work |

**Mandatory question areas:** authentication/authorization boundaries; role and privilege escalation; workflow/state integrity; input/output and upload handling; sensitive-data exposure; auditability; dependency and configuration risks; abuse cases; remediation verification. Testing is not authorized by this matrix.

### Track A11y — Independent accessibility (third priority)

| Screening dimension | Required evidence / capability | Exclusions and fail-closed rule |
|---|---|---|
| Accessibility competence | Verifiable accessibility evaluation experience and current knowledge of relevant WCAG version/criteria and assistive technology | General UX/design experience alone is insufficient |
| Manual evaluation | Demonstrated manual keyboard, focus, semantics, screen-reader and interaction testing capability | Automated scans alone are insufficient |
| Assistive technology | Relevant experience with representative screen readers, browsers and input methods, with environments and limitations documented | Unsupported claims of broad compatibility fail |
| Independence | Separate conflict declaration, including prior design/build/audit involvement | Unresolved conflict fails |
| Separate outputs | Findings mapped to criteria, impact, affected flows, reproduction steps, barriers, limitations and retest requirements | Do not claim WCAG conformance from partial checks |

**Mandatory question areas:** keyboard-only operation; focus order/visibility; accessible names/roles/states; headings/landmarks; forms and validation; contrast and zoom/reflow; error/status announcements; responsive interactions; representative assistive-technology coverage. No manual accessibility testing is authorized by this matrix.

## 4. Combined reviewer decision rule

For each proposed reviewer, create a separate row/assessment per discipline. A combined assignment is permissible only if all of the following are true for every assigned discipline:

1. Identity and affiliation are verified.
2. Discipline-specific competence and relevant experience are supported by verifiable evidence.
3. Independence and conflicts are assessed separately and accepted.
4. The reviewer accepts a distinct scope and deliverable for that discipline.
5. The reviewer can produce a separate signed/dated conclusion and disclose limitations.
6. Confidentiality and evidence handling are approved before any evidence is shared.
7. The engagement remains within the PKR 0 total-cost ceiling and all other restrictions.
8. The Product Owner separately authorizes the exact engagement.

If one discipline fails, do not allow that failure to be masked by competence in another discipline. Narrow the assignment to the disciplines that pass, or leave the failed discipline unreviewed. No gate is accepted merely because a reviewer has been identified.

## 5. Candidate evidence register template

No real candidate data is populated. At a later separately authorized stage, use one record per candidate per discipline:

| Field | Entry |
|---|---|
| Candidate reference | Not populated |
| Discipline | Track A / Track S / Track A11y |
| Identity/affiliation evidence and verification date | Not assessed |
| Qualifications and validity | Not assessed |
| Relevant experience evidence | Not assessed |
| Scope-specific capability | Not assessed |
| Independence/conflicts declaration | Not assessed |
| Confidentiality/evidence-channel approval | Not authorized |
| Availability/willingness | Not assessed |
| Total cost including all expenses | Must be PKR 0; not assessed |
| Screening outcome | NOT SCREENED |
| Product Owner engagement authorization | NOT GRANTED |

## 6. Stop conditions

Stop and preserve the blocked status if:
- Identity, competence, experience or independence cannot be verified.
- A material conflict is unresolved.
- The proposed scope exceeds the reviewer's competence.
- Any fee, expense, reimbursement, paid tool or indirect cost is proposed.
- Confidential evidence would be sent through a public or unapproved channel.
- The request requires real/source/personal/student/child/guardian data, live systems, hosted/V1/Hostinger/production access, external AI/API or unauthorized testing.
- A reviewer asks to contact children, students, guardians or institutes, or conduct interviews/surveys/observation.
- A report overstates scope, assurance, legal effect, WCAG conformance, security certification or gate acceptance.

## 7. Current disposition and next dependency

**Step 05 documentary matrix: COMPLETE.** No candidate has been screened, verified, contacted, selected, appointed or engaged. No confidential evidence has been shared. The PKR 0/no-fee-only boundary remains. No reviewer workstream has started.

The next dependency is not another repository claim of readiness: it is a separately authorized Product Owner decision defining whether any candidate-screening activity may occur, how identity/competence/independence evidence may be verified, and what confidential channel (if any) is approved. Until that authority exists, the register remains blank and no outreach or evidence sharing occurs.

Gate 02 and independent Gate 03 assurance remain **BLOCKED / NOT ACCEPTED**. M3-11 remains **BLOCKED / NOT ACCEPTED**. Overall M3 remains **OPEN / PARTIALLY COMPLETE — NOT CLOSED**.
