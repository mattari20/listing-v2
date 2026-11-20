# M3-11 LPS-13 — GAP-05 Change-Impact Governance Framework

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Planning baseline:** `3980b468a2855b1b3e1aa4a5fef68218a466301b` (main after LPS-12 / PR #370)  
**Agenda type:** Repository-only governance design and documentation  
**Status:** **FRAMEWORK DEFINED — CHANGE CLASSES, IMPACT REVIEW, APPROVALS, TESTING, VERSIONING AND ROLLBACK REQUIREMENTS RECORDED; IMPLEMENTATION NOT AUTHORIZED**

## 1. Purpose and controlling principles

LPS-13 defines a common governance lifecycle for proposed changes to policies, fields, categories, sources, data processing, automation/AI, workflows, public-facing capabilities, security controls and operational/release boundaries. It responds to GAP-05 in LPS-12.

The framework is intended to prevent a narrow change (for example, adding a field or category) from silently changing collection, privacy, source-rights, child-safeguarding, publication, AI, security or operational exposure.

**Non-negotiable principles**
1. No change is authorized by being documented, classified, tested or technically possible.
2. No change may weaken, bypass or silently reinterpret an accepted safeguard or existing authorization boundary.
3. The change owner must identify affected requirements, policies, data classes, audiences, sources, systems, people, risks and dependent controls before implementation.
4. Approval must come from the appropriate accountable role(s); a technical implementer cannot approve their own high-impact change.
5. Material, external-facing or high-risk changes require qualified review where applicable and explicit new scope authorization.
6. Tests and evidence must match the actual change and its risk; synthetic tests do not prove real-world legality, source rights, safety or operational readiness.
7. Every activated change must be versioned, traceable, observable and reversible where technically feasible.
8. Emergency containment may reduce exposure, but it may not be used to expand scope or bypass approval for new capability.

This framework is a proposed governance control for future use. It does not change existing owner decisions or authorize implementation, real data, source activity, external services, hosted access, AI, pilot or release.

## 2. Current boundary carried forward

The present scope remains private repository/local/GitHub CI work with synthetic/fictional fixtures only. The following remain prohibited unless a separate exact authorization changes the boundary:
- V1, production, Hostinger, hPanel or hosted-system access/configuration;
- real institute, source, student, child, guardian, personal or other live data;
- source contact, access, copying, scraping, crawling, downloading or ingestion;
- external APIs, AI/model/provider, crawler, live agent or automated publication;
- child-directed features, child participation, student/guardian data or recruitment;
- public complaint/appeal intake, UGC, reviews, ratings or moderation activation;
- deployment, pilot, participant exercise, restore/recovery rehearsal, release-candidate creation or launch;
- new dependencies, paid services, hosting upgrades or additional spend.

Deeni Madaris remains default-OFF/zero exposure in the current private acceptance boundary. Future distinct-category inclusion is a product direction only; this framework does not activate it.

## 3. Scope of changes governed

The process applies to new, modified, removed, enabled, disabled or materially reinterpreted items in any of these domains:

| Domain | Examples of change | Mandatory impact questions |
|---|---|---|
| Policy / requirements | New policy, revised rule, changed acceptance threshold | Which accepted decisions or requirements change? Does the proposal conflict with a prior owner decision? |
| Data fields / schemas | Add/remove/rename field, change type, validation, visibility, privacy class, freshness | Is the field necessary? What data class, audience, storage, retention, deletion and migration effects arise? |
| Categories / taxonomy | Add category, merge/split types, alter eligibility or default visibility | Does it change who/what is represented, discoverability, safeguarding, moderation or institutional rights? |
| Sources / provenance | New source, new source method, changed terms/permission, source revocation | Who owns the content? What purpose, fields, method, territory, attribution, storage and redistribution are permitted? |
| Automation / AI | New model/provider, agent, prompt, tool, crawler, scheduled task or decision support | What data is sent, what actions can occur, what human approval is required, how are failures/injection/bias evaluated? |
| User-facing capability | Search, profile display, claim, correction, complaint, messaging, review, ranking, sponsored placement | Which audience is exposed? Does this create a new service, reliance, duty, or public interaction? |
| Security / privacy / retention | Roles, permissions, logs, secrets, sessions, retention, deletion, backup | Does it weaken least privilege, increase data exposure or alter deletion/recovery behavior? |
| Operations / hosting / release | Environment, deployment, backup, monitoring, support, incident process | Are named competent owners, isolation, recovery, independent review and release gates satisfied? |
| Dependencies / architecture | Package, framework, external service, storage or integration | What attack surface, license, data processor, cost, availability and exit dependency is added? |

Routine typo/formatting corrections that do not change meaning, controls, scope or executable artifacts may use the lightweight editorial path. If there is uncertainty, classify upward and obtain review.

## 4. Change classification and routing

Classification is based on the highest-impact consequence reasonably foreseeable, not the apparent size of the code diff. A one-line default, permission, privacy-class or visibility change can be high risk.

| Class | Description | Examples | Minimum route |
|---|---|---|---|
| **C0 — Editorial / non-substantive** | Corrects wording, links or formatting without changing meaning, requirements, control behavior or scope | Typo in a document; heading formatting | Author records rationale and confirms no semantic or control effect; normal documentation validation |
| **C1 — Bounded internal / synthetic** | Repository-only change inside already approved private synthetic scope; no new data class, audience, external dependency, permission or capability | Clarifying a test fixture; adding documentation for an already authorized behavior | Change record; technical owner review; focused synthetic tests; regression and exact-head CI |
| **C2 — Material internal capability/control** | Alters application behavior, schema, authorization, privacy, retention, security, governance workflow or operational control without necessarily crossing the external boundary | New field lifecycle behavior; permission change; retention implementation; migration | Full impact assessment; Product Owner decision; technical/security/privacy review as applicable; explicit implementation authorization; tests, rollback and evidence |
| **C3 — External / high-risk / scope-expanding** | Introduces real data/source, new audience, child exposure, public interaction, AI/provider, hosted environment, external processor, deployment, pilot or release activity | Live source ingestion; child-facing feature; public complaint intake; hosted preview; AI provider activation | **STOP pending separate exact authorization**; qualified legal/privacy/safeguarding/security review as applicable; operational role acceptance; prerequisite M3-11 gates; go/no-go and evidence approval |

**Classification rule:** multiple classes may apply. Use the highest class and list all affected domains. C3 is not made permissible by splitting it into smaller C1/C2 commits. An enabling prerequisite can itself be C2/C3 if it materially changes capability or exposure.

**Current authorization:** LPS-13 is C0 documentation design. It does not authorize any C1 implementation or C2/C3 activity. Existing separately approved synthetic work remains governed by its original exact authorization and controls.

## 5. Required change record

Every C1–C3 proposal must have a uniquely identifiable record before implementation. C0 editorial changes may use a concise commit/PR rationale where no substantive impact exists.

Required fields:

1. Change ID, title, date, status, proposer and accountable owner.
2. Problem statement, rationale, intended outcome and explicit non-goals.
3. Change class and reason; affected domains and systems.
4. Exact scope: files/components/data surfaces/environments/audiences affected and excluded.
5. Traceability: affected requirement IDs, accepted Product Owner decisions, LPS principles, roadmap gates and existing authorization.
6. Data assessment: data subjects/classes, purpose, necessity, collection, access, storage, transfer, retention, deletion, logs, backups and processors.
7. Source/rights assessment: source identity, authority, terms/permission, fields, methods, attribution, territory, transformation, redistribution, retention and revocation.
8. Privacy, security, child-safeguarding, accessibility, accuracy, fairness, abuse and operational impact as applicable.
9. Alternatives considered, risks, mitigations, residual risks and assumptions.
10. Dependencies, cost, service/provider/license implications and exit strategy.
11. Required reviewers/approvers and evidence of their decisions.
12. Implementation plan, test plan, migration/compatibility plan and rollback/containment plan.
13. Acceptance criteria, evidence locations, exact commit/PR/CI identifiers and verification results.
14. Activation decision, effective version/date, monitoring owner and review/expiry trigger.
15. Closure decision, unresolved issues, deferred items and follow-up owner.

Unknown facts must be marked **UNKNOWN / EVIDENCE REQUIRED**, not inferred. No real personal/source data should be copied into a change record.

## 6. Impact assessment checklist

For every C1–C3 proposal, assess the following dimensions and mark each **Affected / Not affected with rationale / Unknown**:

- **Requirements and decisions:** Does it alter a previously accepted requirement, owner decision, scope or deferral?
- **Purpose and necessity:** Is each new field/action necessary for a stated student or institutional purpose? Can a less intrusive alternative meet it?
- **Privacy and data lifecycle:** What new data enters, where does it flow, who can access it, how long is it kept and how is deletion propagated?
- **Source rights and provenance:** Is each source and processing method authorized for the exact purpose, fields, territory and redistribution?
- **Children and safeguarding:** Could children reasonably access or be affected? Does it introduce child data, child-directed interaction, contact or participant activity?
- **Accuracy and transparency:** How are evidence quality, authority, freshness, conflicts, uncertainty and public disclosure represented?
- **Institute rights and operations:** Are representation, correction, complaint, appeal, response, escalation and role ownership affected?
- **Security and abuse:** Are permissions, trust boundaries, secrets, attack surface, logging, abuse cases and incident response affected?
- **AI / automation:** Are models, prompts, tools, external processing, automated decisions, agent permissions or human review affected?
- **Accessibility and usability:** Does the change affect access, comprehension, assistive technology or equitable use?
- **Architecture and compatibility:** Are schemas, APIs, data contracts, migrations, dependencies, performance, backup or rollback affected?
- **Hosting and release:** Does it require an environment, deployment, public access, pilot, monitoring or support change?
- **Cost and vendor dependence:** Does it add spend, subscription, hosting capacity, external processor or lock-in?
- **Reversibility:** Can it be safely disabled/rolled back without losing audit lineage or corrupting data?

A “not affected” answer requires a short reason. Any UNKNOWN in a material domain blocks approval until resolved or explicitly accepted by the correct authority with a documented reason; legal, privacy, child-safeguarding or security uncertainties cannot be waived by a technical implementer.

## 7. Approval and separation-of-duties matrix

This matrix identifies decision roles, not appointed people. A role must be named, competent and available before it can discharge an operational or assurance duty. The current owner-led internal development model remains valid only for the existing private synthetic scope; it does not create independent assurance or future operational appointments.

| Change class / trigger | Product Owner | Technical owner | Security/privacy reviewer | Qualified professional | Operations / release owner |
|---|---|---|---|---|---|
| C0 | Informed for material roadmap docs; no new product decision | Author/editor verifies no semantic change | Not normally required | Not normally required | Not required |
| C1 | Confirms it fits existing exact scope where needed | Reviews design, tests and exact head; implementer cannot self-certify high-risk controls | Consult if security/privacy control is touched | Not normally required unless uncertainty surfaces | Not required |
| C2 | Explicitly approves requirement and bounded scope before implementation | Reviews architecture, test, migration and rollback | Required when security/privacy/data lifecycle is affected | Required when legal, source-rights, safeguarding or other professional judgement is implicated | Required if operations, hosted environment, recovery or release process changes |
| C3 | Separate explicit exact-scope authorization and later go/no-go as applicable | Technical readiness evidence | Independent assessment where required | Qualified legal/privacy/safeguarding/source-rights review as applicable | Named accepted roles, environment/recovery evidence and release approval required |

**Separation rules**
- Proposer, implementer, reviewer, adjudicator and release approver must be distinct where the risk or policy requires independence.
- A person may hold more than one low-risk role only when the change record explains why separation is not required and the Product Owner accepts that bounded arrangement.
- No person may approve their own legal, privacy, safeguarding or independent security assessment.
- AI assistance is not an accountable approver, qualified professional or independent reviewer.
- No reviewer appointment, acceptance or qualification is inferred from this role matrix.

## 8. Lifecycle and mandatory stage gates

1. **Intake:** record the proposal and current baseline; do not begin implementation.
2. **Triage:** identify whether it is editorial, within current authorization, or potentially scope-expanding.
3. **Classify:** assign C0–C3 using the highest reasonably foreseeable impact.
4. **Trace:** map requirements, Product Owner decisions, LPS policies, prior authorizations and M3-11 gates.
5. **Assess:** complete the impact checklist; mark unknowns and identify required professional/independent review.
6. **Decide scope:** Product Owner accepts, rejects, defers or requests revision; C2/C3 require exact written authorization before implementation/activity.
7. **Plan:** specify design, tests, evidence, migration, compatibility, rollback, monitoring and cost.
8. **Implement:** only within authorized files, environments, data and activity boundaries; stop if actual work exceeds scope.
9. **Verify:** run focused tests, negative tests, regression suite, security/privacy checks and exact-head CI as applicable.
10. **Review:** accountable reviewers inspect evidence and confirm acceptance criteria; independent/qualified reviews remain independent.
11. **Activate:** only the designated authority may approve activation after all prerequisites and release gates pass. Merge is not activation or deployment.
12. **Monitor and close:** record version, effective date, owner, review trigger, incidents, rollback readiness and final disposition.

Any change in facts, scope, affected data, audience, source permission, dependency or risk after approval returns the proposal to impact assessment and may require reclassification and re-authorization.

## 9. Testing and evidence standard

The test/evidence plan must be proportional to class and impact.

**C0:** document lint/links and confirmation that meaning is unchanged.

**C1:** focused synthetic tests, negative tests for forbidden actions/data, regression tests for adjacent controls, repository hygiene and exact-head CI.

**C2:** all C1 evidence plus design review, data/schema/migration and rollback tests where relevant, access-control/privacy/security tests, dependency/license review, compatibility and failure-mode evidence, and required qualified review before implementation/activation.

**C3:** all relevant C2 evidence plus exact-scope professional/independent assessments, V2-only environment and operational evidence, named role acceptance, recovery and release evidence, and explicit go/no-go.

Every test record must identify the tested commit, environment, fixture type, command/workflow, result, limitations and reviewer. Synthetic-only evidence must be labelled as such. A passing CI run cannot prove source permission, legal compliance, actual hosted isolation, operational coverage or real-world accuracy.

## 10. Versioning, audit and rollback

- Version policy, field, category, source-authorization, workflow and user-facing configuration changes with stable identifiers, effective dates and change-record references.
- Preserve prior approved versions and decision history; do not silently overwrite an accepted policy or historical evidence.
- Record proposer, reviewer, approver, implementer, commit, tests, activation, reason and rollback/withdrawal decisions.
- Use explicit supersession/revocation rather than destructive edits where historical traceability is needed.
- Define rollback triggers, responsible authority, technical procedure, data implications and evidence before implementation.
- Rollback must not re-enable revoked sources, restore prohibited data, expose default-OFF categories or bypass privacy/security safeguards.
- If rollback is unsafe, define a containment/disable path and stop condition before activation.
- Any migration or irreversible data transformation requires separate migration and recovery authorization and verified backup/recovery prerequisites.

## 11. Rejection, deferral and stop conditions

A proposal must be rejected, deferred or returned for revision when:
- it conflicts with an accepted Product Owner decision or current authorization;
- its purpose, necessity, audience, data class, source rights or affected system is unclear;
- required qualified/independent review is missing;
- it weakens a privacy, safeguarding, security, source-rights or human-oversight control;
- it creates an unapproved external dependency, data transfer, cost or operational duty;
- required test, evidence, rollback or accountable owner is missing;
- a C3 activity is proposed without exact scope authorization and prerequisites;
- implementation discovers a material scope difference or unexpected exposure.

**Immediate stop:** do not continue work or use a workaround to bypass a stop condition. Preserve the current safe state, document the discrepancy without including sensitive data, and return to the Product Owner for a new decision.

## 12. Reusable change-impact record template

Copy this template for each future C1–C3 proposal. Leave unknown fields explicitly marked; do not fabricate values.

```markdown
# Change Record — [CHANGE-ID] — [Short title]

- Date / status:
- Proposer / accountable owner:
- Baseline commit:
- Change class (C0/C1/C2/C3) and rationale:
- Decision / authorization reference:

## 1. Rationale and outcome
- Problem:
- Intended outcome:
- Non-goals:

## 2. Scope
- Included components/files/data surfaces:
- Excluded components/environments/audiences:
- Affected domains:
- Requirements / LPS / owner decisions / gates:

## 3. Impact assessment
For each: Affected / Not affected + rationale / UNKNOWN
- Purpose and necessity:
- Data classes, subjects, flows, access, retention and deletion:
- Source rights and provenance:
- Children and safeguarding:
- Accuracy, verification and transparency:
- Institute rights and operations:
- Security and abuse:
- AI / automation:
- Accessibility:
- Architecture, schema, dependencies and compatibility:
- Hosting, release and monitoring:
- Cost / vendors:
- Reversibility:

## 4. Risk and dependencies
- Risks / mitigations / residual risks:
- Assumptions / UNKNOWN evidence:
- Dependencies:
- Required qualified or independent reviewers:

## 5. Decision and approvals
- Product Owner decision:
- Technical review:
- Security/privacy review:
- Qualified professional review:
- Operations/release acceptance:
- Exact authorization and conditions:

## 6. Delivery and verification
- Implementation boundary:
- Test plan and acceptance criteria:
- Migration / compatibility plan:
- Rollback / containment plan:
- Exact commit / PR / CI:
- Results and limitations:

## 7. Activation and closure
- Activation decision / authority:
- Effective version/date:
- Monitoring owner / review trigger:
- Open issues / follow-up:
- Final disposition:
```

## 13. LPS-13 acceptance criteria and completion record

LPS-13 is accepted as a governance-design deliverable when:
1. All material change domains are covered.
2. C0–C3 classes and conservative classification rules are explicit.
3. A required change-record schema is defined.
4. Impact dimensions cover requirements, purpose, privacy, source rights, safeguarding, accuracy, operations, security, AI, accessibility, architecture, hosting, cost and reversibility.
5. Approval roles and separation-of-duties limits are explicit without inventing appointments.
6. The lifecycle includes intake through activation, monitoring and closure.
7. Testing, evidence, versioning, audit, rollback, rejection and stop conditions are defined.
8. The framework preserves accepted decisions, default-OFF safeguards and all current restrictions.
9. The document is indexed and progress/intake/master navigation is updated.
10. Documentation validation and exact-head FND-01 CI pass for the documentation-only PR.

**Current result:** criteria 1–9 are met by this framework. Criterion 10 is pending exact-head validation and must be recorded only after checks finish.

**Final disposition intended for this agenda:** LPS-13 complete as repository-only governance design. GAP-05 is **DESIGNED / NOT IMPLEMENTED**. This document does not create a universal runtime enforcement mechanism and does not close GAP-05 end-to-end. Any implementation of change-control tooling or runtime enforcement requires a separate bounded authorization and acceptance criteria.

## 14. Gate impact and explicit non-authorization

- M3-11-02 remains BLOCKED / NOT ACCEPTED.
- M3-11-03 independent security/accessibility assurance remains BLOCKED.
- M3-11-04 future operational readiness remains BLOCKED.
- M3-11-05 hosted isolation remains BLOCKED / NOT ACCEPTED.
- M3-11-06 recovery remains BLOCKED / NOT ACCEPTED.
- M3-11-07 candidate is not started; M3-11-08 go/no-go is not decided; M3-11-09 execution is not authorized; M3-11-10 monitoring is not started.
- Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.

No application code, tests, schema, migrations, dependencies, runtime enforcement, live data, source activity, external assessment/service, AI/API, hosted access/configuration, deployment, pilot, recovery rehearsal or additional spend is part of LPS-13.
