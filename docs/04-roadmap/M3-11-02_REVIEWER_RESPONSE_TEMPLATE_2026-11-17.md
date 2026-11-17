# M3-11-02 — Reviewer Response and Owner Disposition Template

**Status:** BLANK TEMPLATE — NOT A REVIEW, APPROVAL OR SIGN-OFF  
**Related pack:** [M3-11-02 Legal, Privacy and Safeguarding Review Pack](M3-11-02_LEGAL_PRIVACY_SAFEGUARDING_REVIEW_PACK_2026-11-17.md)

> Complete one copy for each reviewer/workstream. Do not invent reviewer names, qualifications, findings or approval. Do not commit privileged legal advice, secrets, personal data or sensitive incident details to a repository with broader access than the reviewer has approved.

## 1. Reviewer and scope identification

- Workstream: [ ] Legal applicability  [ ] Privacy/data protection  [ ] Child safeguarding  [ ] Research/ethics  [ ] Combined
- Reviewer name / organization:
- Professional role, qualification and relevant jurisdiction/specialism:
- Independence / conflicts declaration:
- Date started:
- Date completed:
- Exact repository commit / candidate reviewed:
- Documents, routes, schemas, configuration and evidence reviewed:
- Evidence unavailable or assumptions:
- Review limitations and exclusions:

## 2. Executive determination

- Outcome: [ ] Approve  [ ] Approve with conditions  [ ] Do not approve  [ ] Unable to conclude
- Scope covered:
- Key conclusions:
- Non-waivable blockers:
- Conditions before private acceptance environment provisioning:
- Conditions before any internal reviewer access:
- Conditions before any future public/child-facing use (if assessed; not authorized here):
- Does this assessment determine that a separate DPIA/PIA, ethics review, safeguarding assessment or legal opinion is required? Explain.

## 3. Applicability and processing assessment

| Topic | Applicable / not applicable / unknown | Evidence and reasoning | Required action / owner |
|---|---|---|---|
| Applicable jurisdictions and laws | | | |
| Controller / operator / processor roles | | | |
| Hosting and data location | | | |
| Cross-border transfer | | | |
| Data inventory and purposes | | | |
| Lawful basis / authority | | | |
| Data minimization and retention | | | |
| Deletion, backups and derived copies | | | |
| Cookies, sessions, logs and telemetry | | | |
| Data subject rights and complaints | | | |
| Security incident / breach duties | | | |
| Source rights, licenses and publication | | | |
| Children/minors and education data | | | |
| Guardian involvement / consent | | | |
| Child safeguarding and escalation | | | |
| Research / human-participant ethics | | | |
| Deeni Madaris sensitive-affiliation risk | | | |

## 4. Findings register

| ID | Severity | Finding / affected scope | Evidence | Required remediation | Accountable owner | Due date | Closure evidence | Blocks next step? |
|---|---|---|---|---|---|---|---|---|
| F-01 | | | | | | | | |
| F-02 | | | | | | | | |
| F-03 | | | | | | | | |

Severity scale (reviewer may replace with their professional scheme): Critical / High / Medium / Low / Observation. Explain the scale and any mandatory stop conditions.

## 5. Residual risk and conditions

- Residual risks after proposed remediation:
- Risks not accepted:
- Conditions that must be satisfied before any environment provisioning:
- Conditions that must be satisfied before internal reviewer access:
- Required policies, notices, contracts, procedures or training:
- Required review/retest date or trigger:
- Events that invalidate this assessment (scope, data, jurisdiction, hosting, architecture or audience change):

## 6. Reviewer attestation

I confirm that this response accurately describes the scope I reviewed, my qualifications and limitations, evidence considered, findings and conditions. This attestation is limited to my stated professional scope and is not a blanket certification beyond it.

- Reviewer:
- Professional title / qualification:
- Organization:
- Signature / approved attestation method:
- Date:

## 7. Product Owner disposition — complete separately

- Decision owner:
- Date:
- Reviewer report/version:
- Finding IDs accepted:
- Finding IDs rejected and reasons:
- Finding IDs deferred and the prohibited activity while deferred:
- Remediation owners and due dates:
- Closure evidence references:
- Residual risks explicitly accepted and authority:
- Overall disposition: [ ] Accepted with conditions  [ ] Rejected  [ ] Deferred / BLOCKED
- Does M3-11-02 remain blocked?:
- Explicit statement of what remains prohibited:

**Important:** A Product Owner disposition does not replace a qualified reviewer assessment. A reviewer assessment does not authorize environment provisioning, participant activity, public launch or production access. M3-11-02 remains BLOCKED until its exit criteria are satisfied and recorded.


## 8. Stage designation and evidence boundary — 2026-11-17

Complete one response per reviewer and per stage. Select exactly one: **Stage 1 — preliminary source/design review** or **Stage 2 — candidate/environment-specific supplement**. If the reviewer performs both, submit two separately dated responses or clearly separated and independently attributable sections.

- Review stage: [ ] Stage 1 preliminary  [ ] Stage 2 candidate/environment supplement
- Exact repository source commit reviewed (required for Stage 1 and Stage 2):
- Exact documents and versions reviewed:
- Candidate ID / candidate commit / artifact hash: [Stage 2 only; leave blank for Stage 1]
- Environment identifier and separate authorization/evidence reference: [Stage 2 only; leave blank for Stage 1]
- Reviewer qualifications, jurisdiction/specialism and independence:
- Scope limitations and unavailable evidence:

### Stage 1 preliminary determination

- Preliminary legal/privacy/safeguarding applicability conclusions:
- Proposed processing/data classes and unresolved assumptions:
- Child/minor and safeguarding applicability; research/participant exclusion:
- Conditions that must be satisfied before environment provisioning:
- Conditions that must be satisfied before internal reviewer access:
- Questions explicitly marked UNKNOWN / DEFERRED TO STAGE 2:
- Non-waivable blockers / stop conditions:

### Stage 2 final supplement

- Verified candidate/environment facts reviewed:
- Stage 1 findings confirmed, changed or invalidated, with reasons:
- Runtime, hosting, operator/processor, logs, cookies, backups, retention/deletion and incident facts verified:
- Remaining unknowns and whether each blocks the proposed private acceptance activity:
- Remediation and independent/reviewer retest evidence:
- Final professional outcome and limitations:

**Stage 1 cannot be recorded as final gate approval.** A blank candidate or environment field in a Stage 1 response is intentional. Do not infer environment facts or approval from repository CI, documentation preparation or an AI-generated summary. M3-11-02 remains BLOCKED until the applicable two-stage evidence, remediation/retests and Product Owner disposition are complete.

