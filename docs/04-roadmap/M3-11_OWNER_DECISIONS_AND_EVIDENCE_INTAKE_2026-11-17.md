# M3-11 — Owner Decisions and Evidence Intake

**Date:** 2026-11-17  
**Status:** Blank intake worksheet; no person is appointed and no approval is recorded.

Use this worksheet to collect explicit human decisions. Do not fill a field by inference. Keep personal contact details and restricted reports outside this repository; store only non-sensitive evidence references here.

## A. Product Owner decisions required

| Decision ID | Decision requested | Required record | Current state |
|---|---|---|---|
| PO-01 | Confirm current Option A / Option 1 scope and exclusions | Dated written scope confirmation | Previously defined; reconfirm if changed |
| PO-02 | Approve named qualified legal/privacy/safeguarding reviewer(s) and their scope | Reviewer identity/qualification/independence and written engagement acceptance | NOT PROVIDED |
| PO-03 | Approve named independent security and qualified accessibility reviewer(s) | Reviewer identity/qualification/independence and written engagement acceptance | NOT PROVIDED |
| PO-04 | Name and approve human operations/support/release/incident/privacy/safeguarding/recovery roles | Role acceptance and coverage records | NOT PROVIDED |
| PO-05 | Select a proposed private V2-only environment and resource boundary | Environment proposal, cost/resource implications, no shared/V1/production impact | NOT PROVIDED |
| PO-06 | Separately authorize M3-11-05 provisioning/access after the proposal is reviewed | Exact target, permitted actions, people, limits, stop conditions and expiry | NOT AUTHORIZED |
| PO-07 | Approve recovery objectives (RPO/RTO) and rehearsal scope | Values, rationale, data boundary and authorized rehearsal plan | NOT SET |
| PO-08 | Separately authorize M3-11-06 synthetic-only recovery rehearsal | Exact V2-only target/source/destination, operator, verifier and stop conditions | NOT AUTHORIZED |
| PO-09 | After all gates pass, separately authorize creation of a release candidate | Exact source scope, branch/commit policy, build boundary and candidate verification | NOT AUTHORIZED |
| PO-10 | After candidate dossier is complete, issue M3-11-08 decision | Explicit GO/NO-GO/NOT DECIDED, exact candidate/environment/window, conditions and signatories | NOT DECIDED |
| PO-11 | If GO is issued, separately authorize M3-11-09 execution | Exact operation, target, operator, window, rollback, monitoring, limits and expiry | NOT AUTHORIZED |

## B. Human role acceptance intake

Complete one record per role. A nomination is not acceptance; acceptance is not proof of competence; role assignment does not replace independent review.

| Role | Named human | Competence/qualification evidence ref | Written acceptance ref/date | Availability/deputy | Independence/conflict check | Status |
|---|---|---|---|---|---|---|
| Product Owner / decision authority | NOT NAMED HERE | — | — | — | — | PENDING |
| Legal reviewer | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Privacy reviewer | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Safeguarding reviewer | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Independent security reviewer | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Accessibility reviewer | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Operations/release owner | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Incident/support owner | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Recovery owner | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Independent recovery verifier | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Environment provisioner | NOT ASSIGNED | — | — | — | — | BLOCKED |
| Environment isolation verifier | NOT ASSIGNED | — | — | — | — | BLOCKED |

## C. Reviewer intake checklist

For each proposed external reviewer:
- [ ] Scope and expected deliverable are defined.
- [ ] Relevant qualifications and experience are evidenced.
- [ ] Independence and conflicts of interest are declared.
- [ ] Access boundary and safe review method are agreed.
- [ ] No production/V1/Hostinger/live DB access is required.
- [ ] No real personal/student/provider/institution/source data or participants are required.
- [ ] Fees, if any, are explicitly approved before engagement; no spend is implied by this worksheet.
- [ ] Written report format, limitations, findings and retest expectations are agreed.
- [ ] Restricted report storage and access are agreed.

## D. Evidence intake record

| Field | Entry |
|---|---|
| Evidence ID | NOT ASSIGNED |
| Gate | NOT SELECTED |
| Accountable role | NOT ASSIGNED |
| Evidence source/reference | NOT PROVIDED |
| Exact scope/target/candidate | NOT PROVIDED |
| Date and method | NOT PROVIDED |
| Result/findings | NOT PROVIDED |
| Limitations | NOT PROVIDED |
| Remediation/retest reference | NOT PROVIDED |
| Human disposition and date | NOT PROVIDED |
| Restricted storage classification | NOT PROVIDED |

## E. Submission and status rules

- Do not send secrets, passwords, API keys, credentials, personal contact details or restricted reports into public repository files or ordinary chat.
- Use a restricted, approved channel for professional reports and personal information; reference only a non-sensitive evidence ID in this repository.
- A document being drafted, sent or received is not automatically accepted evidence.
- A reviewer report with unresolved blocking findings does not pass the gate.
- Only the accountable human can accept residual risk within their authority; mandatory legal/safeguarding/security/isolation/recovery gates cannot be waived by this template.
- Every approval is specific to its scope and expires or must be reconsidered if the scope, target, candidate or conditions materially change.

## F. Current disposition

No new reviewer, operator, provisioner, recovery owner or verifier is appointed by this worksheet. No environment, backup, recovery rehearsal, candidate, go/no-go, production action or spend is authorized. M3-11 remains BLOCKED / NOT ACCEPTED.


## Controlled acceptance/readiness evidence intake reconciliation — 2026-11-20

**Status:** INTAKE PROCESS RECONCILED; EXTERNAL / HUMAN GATE EVIDENCE NOT RECEIVED. M3-11 remains BLOCKED / NOT ACCEPTED.

This is an evidence-reconciliation update, not a request to repeat or reopen accepted Product Owner decisions. Previously accepted project-wide scope and policy decisions remain the baseline unless the Product Owner explicitly changes scope. The owner-led single-person model remains accepted for repository-only private synthetic development; it does not appoint or substitute for future hosted/release operational roles or qualified independent reviewers.

### Accepted decisions retained

- Option A / Option 1 remains the accepted private V2 scope and exclusions.
- Repository-only private development may continue under the accepted owner-led model, using synthetic/fictional fixtures.
- The existing hosting plan is retained; no additional spend or paid upgrade is approved.
- The existing weekly automated backup cadence is accepted for the current development stage; this is not evidence of a V2-only restore boundary or a completed recovery rehearsal.
- The selected V2 subfolder and existing preview-protection choice remain recorded as owner decisions, not as proof of hosted enforcement or isolation.
- SEC-06 bounded local/CI logging implementation is delivered and merged in PR #347; this does not close independent security/accessibility assessment or hosted controls.

### Consolidated evidence intake ledger

| Gate | Current verified evidence | Evidence still required / intake trigger | Disposition |
|---|---|---|---|
| M3-11-01 Scope and authority | Option A / Option 1 and exclusions accepted and recorded | Only revisit if the Product Owner explicitly changes scope or authority | CLOSED for scope definition |
| M3-11-02 Legal/privacy/safeguarding | Owner internal privacy review and safeguarding scope decision recorded; reviewer pack and response template prepared | Qualified reviewer identity/competence/independence, dated scoped assessment, findings/applicability/limitations/conditions, and separate Product Owner disposition | BLOCKED for qualified review |
| M3-11-03 Security/accessibility | Owner internal desk review recorded; bounded SEC-06 local/CI logging merged in PR #347 and evidence documented | For future hosted/release assurance: qualified independent security and accessibility reviewers, exact target/candidate scope, method, findings/severity, remediation/retest and limitations. Manual assistive-technology review remains unperformed; no WCAG conformance claim | CLOSED for current repository-only internal review; independent future assessment BLOCKED |
| M3-11-04 Human operations | Owner-led single-person model accepted for repository-only private synthetic development | Before hosted/reviewer/pilot/release activity: named human role holders, written acceptance, competence, availability, deputies/coverage and escalation; existing future operational register remains 0/9 accepted | CLOSED for current dev boundary; future operations staffing deferred |
| M3-11-05 Environment separation | Owner-selected subfolder and prior bounded resource/CLI evidence are recorded | Separate exact-scope authorization before any action; V2-only resource inventory and independently verified isolation evidence (0/18 accepted at last reconciliation). No further Hostinger/hPanel or hosted access is authorized by this intake record | BLOCKED; hosted isolation not accepted |
| M3-11-06 Recovery | Weekly backup policy accepted for current development | Approved RPO/RTO, named recovery owner/verifier, separately authorized V2-only rehearsal, integrity/consistency evidence, measured recovery results and independent verification. No backup/restore action authorized here | BLOCKED; no rehearsal; RPO/RTO not set or measured |
| M3-11-07 Release candidate | Candidate evidence register and prerequisites are documented | Only after all prerequisite gates pass: separate Product Owner candidate-creation authorization, immutable source/artifact identity and exact-candidate verification | NOT STARTED / BLOCKED; no candidate |
| M3-11-08 Go/no-go | Decision requirements and dossier structure are documented | Complete exact-candidate dossier and explicit signed Product Owner decision | BLOCKED / NOT DECIDED |
| M3-11-09 Execution | No execution authority recorded | Separate exact-scope execution authorization after valid candidate decision | NOT AUTHORIZED |
| M3-11-10 Monitoring/closure | No authorized operation exists | Begins only after validly authorized operation and named operations/incident owners | NOT STARTED |

### Intake acceptance rules

1. A submission receives a non-sensitive evidence ID and is mapped to one gate and one requirement; no approval is inferred from a chat statement, draft, empty template, merged PR or CI result unless that evidence is actually relevant to the requirement.
2. Record source/role, qualification and independence where required, exact scope/target/candidate, date, method, findings/result, limitations, remediation/retest, accountable human disposition and restricted-storage reference.
3. Keep confidential reports, legal advice, credentials, personal contact details, private data and exploit-sensitive details outside this repository and ordinary chat. Store only a non-sensitive reference and status here.
4. Distinguish RECEIVED from REVIEWED, ACCEPTED, REJECTED, CONDITIONAL and BLOCKED. Receipt alone never passes a gate. Only the accountable qualified human and Product Owner may make the relevant dispositions.
5. Do not use NOT APPLICABLE to bypass a mandatory gate. Any proposed scope change, target access, hosted action, backup/restore, candidate, public activation, deployment or spend requires its own exact-scope authorization.
6. Preserve accepted decisions. Do not request repeated approval for an unchanged decision; update this ledger only when new evidence arrives, a gate status legitimately changes, or the Product Owner changes scope.

### Current intake result

No new qualified reviewer report, signed role acceptance, exact-scope environment authorization, isolation evidence, recovery rehearsal evidence, candidate dossier or go/no-go decision was supplied with this reconciliation. No evidence has been fabricated or inferred. This closes the repository-side intake reconciliation/preparation task only; it does not close the external or operational gates and does not change M3-11 overall status.
