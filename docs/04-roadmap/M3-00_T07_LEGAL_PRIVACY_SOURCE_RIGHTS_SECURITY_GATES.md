# M3-00 T07 — Legal, Privacy, Source-Rights and Security Gate Register

**Project:** eStudent Institutes V2  
**Task:** M3-00 / T07 (15% of M3-00)  
**Status:** Documentation baseline prepared — review and qualified-owner assignment pending  
**Decision posture:** DENY BY DEFAULT; no external source, dataset, model, connector or vendor is approved by this register  
**Prepared:** 2026-11-12

## 1. Purpose and limits

This register defines the evidence and approval gates that must be satisfied before V2 uses external education data, personal data, third-party software/services, AI models or operational infrastructure. It converts the accepted M1 research and M2 architecture controls into M3 readiness checks.

This is a project-control document, not legal advice, a legal opinion, a privacy impact assessment, a penetration test, a security certification or a statement that V2 complies with any law. Applicable Pakistan and other jurisdictional requirements must be assessed by a qualified reviewer against the actual processing, users, vendors, data flows and deployment locations.

A public webpage, official government source, public API, open-source repository or available AI service does not by itself grant permission for V2's intended use.

## 2. Binding starting controls

The following controls remain mandatory and are not weakened by this register:

- V2 is greenfield and independent. Legacy Listing V1 code, schema, data, APIs, architecture, workflows and operational practices are excluded as design inputs.
- All M1 source and software research remains research-only unless a separate source- or component-specific approval is recorded.
- No student survey, interview, recruitment or research outreach during construction. Existing instruments remain unapproved and must not be distributed.
- Public discovery is anonymous-first. Account-based ratings/reviews are intended post-launch; eligibility, moderation, privacy and age safeguards must be resolved before implementation/release.
- Minimize personal data, especially data relating to children; do not collect student records, identity documents, individual professional registrations or unrelated personal/contact data for institution discovery.
- External evidence is quarantined, attributable and reviewable. AI outputs are proposals only; deterministic checks and authorized human adjudication precede publication.
- Least privilege, separation of duties, auditability, correction/withdrawal, retention limits, incident response and recovery remain required.
- Deeni Madaris suppression and all other accepted product restrictions remain binding across public and internal workflows.
- No production access, source ingestion, connector activation, paid service, procurement, deployment, pilot or launch is authorized by M3-00 documentation.

## 3. Gate lifecycle and decision vocabulary

Each gate must have an evidence record, a named accountable human owner, reviewer where required, decision date, scope, limitations and review/expiry trigger.

| State | Meaning |
|---|---|
| NOT ASSESSED | Required evidence has not been examined |
| EVIDENCE GATHERING | Documentation/research is being prepared without activating the subject |
| REVIEW REQUIRED | Evidence package is ready for qualified review |
| CONDITIONALLY ACCEPTED | A reviewer has accepted a tightly bounded condition; conditions must be satisfied before use |
| APPROVED — LIMITED SCOPE | Explicit approval for the named purpose, fields, method, period and environment only |
| REJECTED / PROHIBITED | The proposed use must not proceed |
| EXPIRED / REASSESSMENT REQUIRED | Terms, law, vendor, purpose, data fields or system conditions changed or approval period ended |

No approval is inherited across different sources, datasets, fields, purposes, vendors, environments or collection methods. Approval for manual lookup does not authorize automated collection; API access does not automatically authorize republication or commercial use; software license approval does not approve data rights.

## 4. Gate register

| ID | Gate | Minimum evidence required before approval | Required accountable review | Current status |
|---|---|---|---|---|
| T07-G01 | Applicable law and jurisdiction | Data-controller/processor roles; user and data-subject locations; processing purposes; hosting and transfer locations; applicable statutes/rules and effective dates; retention/deletion duties; regulator/complaint routes | Qualified Pakistan legal/privacy reviewer; other jurisdictional counsel if scope requires | REVIEW REQUIRED — reviewer not named |
| T07-G02 | Source identity and authority | Source owner/operator; official status and authority for each claimed field; canonical URL/API/dataset; source scope, coverage and freshness; correction contact | Data governance owner; legal reviewer for uncertain authority | EVIDENCE GATHERING — research-only |
| T07-G03 | Copyright, database and reuse rights | Exact terms/license version and date; rights to access, extract, store, normalize, cache, display, attribute, redistribute and commercially use each field/dataset; restrictions and permission evidence | Qualified legal reviewer plus Product Owner | NOT APPROVED — deny by default |
| T07-G04 | Permitted access method | Terms for manual access/API/download/automation; authentication, rate limits, robots/access rules, anti-circumvention restrictions and written permissions where needed | Security reviewer and legal reviewer | NOT APPROVED — no source access authorized |
| T07-G05 | Personal data and privacy | Data inventory; purpose and necessity; lawful basis; notices/transparency; minimization; data-subject rights; retention/deletion; processors; cross-border transfer; privacy risks and mitigations | Qualified privacy/legal reviewer; accountable data owner | REVIEW REQUIRED — assessment not performed |
| T07-G06 | Children and vulnerable users | Age-related risk assessment; no unnecessary child data; age-appropriate notices and controls; safe account/review eligibility; moderation/escalation; abuse reporting; retention and access limits | Qualified safeguarding/privacy reviewer; Product Owner | REVIEW REQUIRED — no child-data collection authorized |
| T07-G07 | Security architecture and threat model | Data-flow and trust-boundary diagrams; threat model; asset/risk inventory; authentication/authorization; secrets; encryption; logging; dependency and vulnerability controls; incident response | Independent qualified security reviewer | REVIEW REQUIRED — no security assurance claimed |
| T07-G08 | AI/model and automated processing | Model/provider identity and version; data-use/training/retention terms; input/output handling; prompt-injection controls; untrusted content isolation; evaluation; human review; cost limits; fallback and exit plan | Security/privacy reviewer; Product Owner; legal reviewer where data terms require | NOT APPROVED — no model/service activation |
| T07-G09 | Third-party software and supply chain | Exact component/version; license and obligations; provenance; maintainer health; vulnerabilities; transitive dependencies; build integrity; update/patch plan; data-flow and telemetry review | Engineering owner and independent security reviewer; legal review for license uncertainty | NOT APPROVED — no dependency adoption implied |
| T07-G10 | Vendor, hosting and cross-border processing | Contract/DPA; sub-processors; region and transfer route; data ownership; access/support; breach notification; deletion/return; backup/restore; audit rights; exit/portability; service limits | Qualified legal/privacy and security reviewers; operations owner; Product Owner | NOT APPROVED — no vendor/provider selected |
| T07-G11 | Publication, correction and withdrawal | Field-level provenance; verification standard; conflict/dispute handling; human publication authority; correction/appeal route; withdrawal propagation; audit trail | Data governance owner and Product Owner | DESIGN REQUIRED — no public data publication authorized |
| T07-G12 | Operational readiness and incident handling | Named incident owner; severity/escalation matrix; notification decision process; containment, evidence preservation, recovery, communication and post-incident review; tested backup/restore | Operations owner and independent security reviewer | OPEN — no operations owner named |

## 5. Source-specific approval record (mandatory)

Create one record per source/dataset/API and proposed use. Do not combine unrelated sources under a blanket approval.

Required fields:

1. Source ID, legal owner/operator, canonical location and source authority.
2. Exact dataset, fields, population, geography, date range and update cadence.
3. Proposed purpose and necessity for each field.
4. Exact access method and frequency (manual, API, download or automation).
5. Applicable terms/license version, retrieval date and evidence copy/reference.
6. Rights to store, transform, cache, display, attribute, redistribute and use commercially.
7. Personal/sensitive/child data presence and exclusion/minimization rules.
8. Data location, recipients, processors, transfers and retention/deletion.
9. Security assessment, access controls, incident route and correction/withdrawal process.
10. Qualified reviewer decision, limitations, approval expiry/review trigger and Product Owner authorization.

**Default disposition:** RESEARCH ONLY — NOT AUTHORIZED FOR ACCESS, COLLECTION, INGESTION, STORAGE, PUBLICATION OR COMMERCIAL REUSE.

## 6. Human review and accountability model

No person is presumed appointed merely because a role appears below. Names and qualifications must be supplied and recorded before the relevant gate can pass.

| Role | Accountability | Assignment |
|---|---|---|
| Product Owner / final decision-maker | Approves product purpose, risk acceptance within authority, scope and each required go/no-go decision | Owner role recorded; personal name not repeated in this control register |
| Data governance owner | Source register, field provenance, quality, adjudication and withdrawal controls | NOT ASSIGNED |
| Engineering/technical owner | Architecture, secure implementation, dependency and environment controls | NOT ASSIGNED |
| Privacy/legal reviewer | Applicable law, lawful basis, notices, rights, processor/transfer terms and source rights | Qualified reviewer NOT ASSIGNED |
| Security reviewer | Threat model, architecture/security review, testing and residual risk | Independent qualified reviewer NOT ASSIGNED |
| Safeguarding reviewer | Child/minor risks, account/review eligibility, moderation and escalation | Qualified reviewer NOT ASSIGNED |
| Operations owner | Hosting, access, backup/restore, monitoring, incident response and vendor operations | NOT ASSIGNED |

ChatGPT assistance is not a substitute for a qualified legal, privacy, security or safeguarding reviewer, nor does it assume a human implementation or operations role.

## 7. No-go conditions

Stop and do not activate the proposed source, dataset, model, software component or vendor if any of the following applies:

- Ownership, authority, terms, license or permitted use cannot be established.
- Required permission is absent, ambiguous, withdrawn or inconsistent with the proposed method/purpose.
- Personal or child data is unnecessary, excessive, unexpectedly exposed or lacks an approved lawful handling plan.
- Data transfers, subprocessors, retention, deletion or breach obligations are unknown or unacceptable.
- Security review identifies an unresolved critical/high risk or an unmitigated trust-boundary/prompt-injection issue.
- AI/provider terms permit incompatible retention, training, onward use or access.
- Provenance, correction, withdrawal or human publication control cannot be maintained.
- No accountable human owner or qualified reviewer is assigned where required.
- A proposed action would cross the separately authorized scope, spend, production or source-access boundary.

A no-go decision must record the reason, affected scope, evidence and conditions for reconsideration. Silence is not approval.

## 8. Change and re-review triggers

Reassessment is mandatory when the source terms/license, law, dataset fields, collection method, processing purpose, user population, model/provider, vendor/subprocessor, hosting region, data flow, security posture or retention period changes; when a permission expires or is withdrawn; or when an incident, complaint or material quality issue occurs.

Approval must be versioned and time-bounded where the reviewer requires it. Keep prior decisions for audit; do not silently overwrite them.

## 9. T07 completion criteria

T07 may be proposed for owner acceptance only when:

1. The gate register is reconciled with M1-S07, the source-rights register, M2 security/privacy architecture and current product requirements.
2. Each required human role has a named, suitably qualified accountable owner, or the owner explicitly accepts a documented dependency and keeps affected gates blocked.
3. The applicable-law/jurisdiction review scope is defined and qualified legal/privacy review is completed or explicitly deferred with no-go conditions.
4. Child/minor safeguarding, personal-data, source-rights, software-supply-chain, AI/vendor and operational-security controls have evidence and review outcomes.
5. Source-specific approval records exist for any source proposed for future use; otherwise all remain explicitly research-only.
6. Residual risks, exclusions, expiry dates and reassessment triggers are visible in the decision register.
7. No approval is inferred from document delivery, public availability, prior research acceptance or a PR merge.

T07 completion does not authorize any source access, software adoption, model activation, procurement, implementation, production processing or deployment. Those require separate scope-specific approvals.

## 10. Immediate next actions (documentation only)

1. Cross-reference this register against M1-S07 and M2-S08/S09; record any conflict as an open decision rather than silently changing accepted controls.
2. Prepare a reviewer brief for legal/privacy, security and safeguarding review, without contacting or appointing reviewers on the owner's behalf.
3. Add the T07 document to the documentation catalogue, index, M3-00 register and progress report.
4. Keep T07 open until the evidence, qualified review responsibilities and owner disposition satisfy the exit criteria.

## 11. Related V2 documents

- [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md)
- [M3-00 Mobilization and Decision Closure](M3-00_MOBILIZATION_AND_DECISION_CLOSURE.md)
- [Data Rights and Provenance Standard](../02-data-strategy/DATA_RIGHTS_AND_PROVENANCE.md)
- [M1 Source Rights, Access and Provenance Evidence Register](../03-research/M1_SOURCE_RIGHTS_ACCESS_EVIDENCE_REGISTER.md)
- [M1-S07 Source Rights and Security Assessment](../03-research/M1_S07_SOURCE_RIGHTS_SECURITY_ASSESSMENT_2026-11-12.md)
- [M2-S08 Identity, Authorization, Reviews, Privacy and Security](../05-architecture/M2-S08_IDENTITY_AUTHORIZATION_REVIEWS_PRIVACY_SECURITY.md)
- [M2-S09 Performance, Operations, Hosting and Recovery](../05-architecture/M2-S09_PERFORMANCE_OPERATIONS_HOSTING_RECOVERY.md)
