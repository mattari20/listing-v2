# M3-00 T08 — Implementation Scope, Test/Release Governance and M3-01 Authorization Pack

**Project:** eStudent Institutes V2  
**Task:** M3-00 / T08 (10% of M3-00)  
**Status:** Planning framework delivered — detailed owner decisions and acceptance remain open  
**Prepared:** 2026-11-12  
**Implementation authorization:** NOT GRANTED

## 1. Purpose and controlling rule

This pack defines what must be decided and evidenced before M3-00 can be submitted for owner acceptance and M3-01 can request a narrowly scoped implementation-start authorization.

M3-00 is mobilization and decision closure. M3-01 is implementation planning and authorization. Neither is permission to begin application coding by implication. Only a separate explicit owner authorization may permit the precisely named M3-02 or other implementation scope.

M2 is accepted and closed. This pack does not reopen M2, change accepted architecture, or authorize any implementation. M3 Master Step Plan and accepted M0/M1/M2 controls remain binding.

## 2. Non-negotiable project boundaries

- V2 remains greenfield and independent; legacy V1 artifacts are excluded as inputs.
- No application code, physical database schema, migrations, production credentials, production access or production data operations are authorized.
- No live source retrieval, scraping, bulk download, ingestion, connector/agent/model activation or source-owner outreach is authorized.
- No paid trial, procurement, subscription, contract, hiring or new spend is authorized.
- No deployment, public pilot, real-user research, launch or URL cutover is authorized.
- No student surveys, interviews, recruitment or research outreach during construction.
- AI-generated data/evidence remains proposal-only and cannot publish without approved rights, deterministic checks and human adjudication.
- Deeni Madaris suppression, anonymous-first discovery, data minimization, minor safeguards, auditability and human publication controls remain binding.

## 3. M3-01 readiness inputs

M3-01 must convert the M2 architecture and M3-00 decisions into an implementation-ready plan. The following must be completed or explicitly deferred with an owner-approved blocker and a safe no-go boundary.

| ID | Required decision/evidence | Owner / reviewer | Current status |
|---|---|---|---|
| T08-01 | Confirm M3-00 exit checklist and unresolved decision inventory | Product Owner | OPEN |
| T08-02 | Define exact first implementation slice and exclusions | Product Owner + technical owner | OPEN |
| T08-03 | Confirm human implementation, maintenance, QA, security and operations capacity | Product Owner | OPEN — named roles not assigned |
| T08-04 | Confirm stack and hosting decision or record bounded deferment | Product Owner + technical/operations owner | OPEN — T05/T06 decisions pending |
| T08-05 | Confirm numeric spend ceiling or explicit no-spend plan and cost assumptions | Product Owner | OPEN — T04 decision pending |
| T08-06 | Complete required legal/privacy/source-rights/security/safeguarding gates | Qualified reviewers + Product Owner | OPEN — T07 evidence/reviewers pending |
| T08-07 | Approve implementation environments, synthetic fixtures and secret boundaries | Technical/security owner | OPEN |
| T08-08 | Approve test strategy, quality gates, defect severity and acceptance evidence | QA/technical owner | OPEN |
| T08-09 | Approve release, rollback, incident and recovery strategy for non-production work | Operations/security owner | OPEN |
| T08-10 | Record exact implementation-start authorization, scope, limits, expiry and stop conditions | Product Owner | NOT ISSUED |

A missing role, quote, legal review or other dependency must be recorded as a blocker. Do not invent a named person, skill, approval, budget, provider or decision.

## 4. Proposed implementation backlog structure (planning only)

The following is a dependency-oriented planning outline, not an approved sprint backlog or instruction to code.

| Sequence | Work package | Planned outcome | Entry gate |
|---|---|---|---|
| P0 | Delivery controls and non-production foundation | Repository/CI controls, local development instructions, configuration and secret boundaries | M3-01 authorization explicitly includes foundation work |
| P1 | Core domain and provenance | Approved logical model, evidence lineage, temporal facts, audit and validation | P0 accepted; data/source boundaries approved |
| P2 | Human governance workflows | Review, adjudication, correction, withdrawal and publication controls | P1 acceptance and named governance roles |
| P3 | Provider/institution catalogue | Provider, institution, campus, programme and authority relationships | P2 acceptance |
| P4 | Anonymous discovery and search | Directory, filters, profiles, unknown/stale states and low-bandwidth behavior | P3 acceptance |
| P5 | Geography adapters | Approximate locality/distance and optional replaceable map/geocoder integration | P4 acceptance; privacy and vendor gates |
| P6 | AI evidence workflow | Quarantined proposal intake, deterministic checks and human adjudication | P1/P2 acceptance plus source-specific T07 and model/vendor approval |
| P7 | Identity/reviews/moderation | Least-privilege accounts and post-launch review/moderation capability | Security/privacy/safeguarding design and separate approval |
| P8 | Quality/operational hardening | Functional, accessibility, performance, security, recovery and operational evidence | Feature slices complete |
| P9 | Pilot readiness | Bounded pilot package and separate participant/data/operations approval | P8 accepted; separate pilot approval |
| P10 | Production launch | Production release and monitored operation | Separate explicit production/launch authorization |

No work package becomes authorized merely by appearing in this table. M3-01 authorization must identify the permitted package(s) and scope precisely.

## 5. Definition of ready for an implementation work item

Every proposed work item must include:

1. Unique ID, user/business outcome and traceability to accepted requirements/architecture.
2. Exact in-scope behavior and explicit exclusions.
3. Dependencies, assumptions and owner decisions.
4. Data classification, source rights and privacy/security impact.
5. Acceptance criteria with observable pass/fail outcomes.
6. Unit, integration, contract, regression, accessibility, security or performance tests as applicable.
7. Synthetic/test data requirements and prohibition on unapproved live/production data.
8. Logging, audit, error handling and failure/rollback behavior.
9. Documentation and operational handover requirements.
10. Named accountable implementer and reviewer, or a documented staffing blocker.

Work that lacks an approved source, lawful data basis, security boundary or named accountable owner is not ready.

## 6. Test strategy and evidence contract

The detailed M3-01 test plan must map every acceptance criterion to a reproducible test or review artifact.

| Test layer | Minimum purpose | Evidence expected |
|---|---|---|
| Static/code quality | Formatting, lint, type/static checks and policy checks | CI logs and versioned configuration |
| Unit | Deterministic domain rules, validation, normalization and permissions | Test report and coverage context |
| Integration | Persistence, service boundaries, queues/adapters where approved | Reproducible test results using isolated fixtures |
| Contract | Provider/API schemas and adapter failure behavior | Versioned contract fixtures and compatibility results |
| End-to-end | Priority student and administrator journeys | Repeatable scenario results |
| Data quality | Provenance, temporal validity, conflicts, duplicates and unknown/stale states | Fixture-based quality report |
| Privacy/security | Access control, minimization, secrets, injection, abuse and audit boundaries | Threat-model-linked verification and findings |
| Accessibility | Keyboard, semantics, contrast, responsive and assistive-technology checks | Automated and manual results |
| Performance/resilience | Agreed load, latency, degradation and recovery hypotheses | Measured results against owner-approved targets |
| Backup/restore | Only for environments and data stores explicitly in scope | Timed restore exercise and integrity evidence |

Pass criteria and thresholds must be defined before the relevant test is run. Do not claim security, accessibility, performance or compliance from an unexecuted checklist. Defects must be severity-classified, assigned, retested and closed or explicitly accepted by an authorized owner. Critical/high security or privacy findings are release blockers unless qualified review and the owner's documented risk authority establish a lawful alternative; no such exception is presumed.

## 7. CI, review and merge controls

- Work only on an explicitly authorized branch and scope.
- Every change is proposed through a pull request; no direct changes to protected main.
- Required Project documentation validation (for documentation changes) and all applicable code/test/security checks must pass on the exact PR head.
- Review threads must be resolved; changes after validation require revalidation of the updated exact head.
- Merge only after required checks and review conditions pass.
- A merge proves delivery, not product acceptance, production readiness or authorization for the next stage.
- Keep commits and artifacts traceable to requirement IDs, decision IDs and test evidence.
- Never store credentials, secrets, personal data or production exports in repository history or test fixtures.

## 8. Release and rollback governance

For every non-production release candidate, the M3-01 plan must identify:

- Target environment and explicit data classification.
- Version/build identifier and reproducible artifact provenance.
- Approved configuration and secret injection method.
- Pre-release checks, smoke tests and acceptance owner.
- Monitoring, logs, alert thresholds and named responder.
- Stop/abort conditions and decision authority.
- Rollback trigger, tested rollback steps, data compatibility and recovery point.
- Backup/restore scope and evidence where stateful components are involved.
- Incident escalation, communication and post-incident review.

No production deployment or public pilot is included in this approval pack. Production and pilot require separate written approvals and safeguards.

## 9. M3-01 authorization record — not yet issued

The eventual authorization must be a durable owner decision record and must include every item below. Blank fields mean authorization has not been granted.

| Authorization field | Required content | Current value |
|---|---|---|
| Decision ID and date | Unique ID and date | NOT ISSUED |
| Authorized stage | Exact M3 step/work package | NONE |
| Permitted repository/branch | Exact repository and permitted branch policy | NONE |
| Permitted activities | Explicit work allowed | NONE |
| Excluded activities | Production, source access, schema, spend, vendor, deployment and other exclusions | All remain excluded unless separately approved |
| Environment/data | Local/non-production environment and synthetic fixtures | NOT APPROVED |
| Named accountable humans | Implementer, reviewer, QA/security and operations roles | NOT ASSIGNED |
| Budget/spend ceiling | One-time/recurring cap and approved payment authority | NOT APPROVED |
| Legal/privacy/security gates | Evidence IDs and reviewer decisions | PENDING |
| Acceptance criteria | Exact completion evidence and tests | TO BE APPROVED |
| Stop conditions | Trigger and authority to halt | Must be explicit before authorization |
| Expiry/review | Date or event requiring reauthorization | NOT ISSUED |
| Owner authorization | Explicit written approval for the exact scope | NOT GRANTED |

**No authorization may be inferred from “continue”, approval of this roadmap, PR merge, CI success, M2 acceptance or approval of M3-00 documentation.**

## 10. T08 completion criteria

T08 may be proposed for owner acceptance only when:

1. The detailed M3-01 scope and exclusions are approved or explicitly deferred with blockers.
2. The work breakdown is traceable to accepted M2 architecture and M1 requirements without reopening them.
3. Roles, capacity, stack, hosting and budget decisions are resolved or bounded by explicit no-go deferrals.
4. T07 legal/privacy/source-rights/security/safeguarding dependencies are evidenced and qualified reviews recorded, or the affected implementation work is excluded.
5. Definition of Ready, Definition of Done, test layers, CI/review rules and evidence requirements are complete.
6. Release/rollback/incident/recovery controls and environment/data boundaries are documented.
7. The exact M3-01 implementation authorization form is complete but remains unissued until the owner explicitly approves it.
8. The Product Owner reviews and accepts the readiness package and outstanding risks.

T08 completion and M3-00 acceptance still do not start implementation. Only the separate M3-01 owner authorization can do that.

## 11. Immediate next actions (documentation only)

1. Reconcile the T08 framework with the M3 Master Step Plan, M2 architecture acceptance and T07 gate register.
2. Expand the first implementation slice into detailed work items only after the remaining T02–T06 decisions are either resolved or explicitly excluded.
3. Prepare the M3-00 owner acceptance checklist, listing each remaining blocker and the exact decision required.
4. Do not begin application coding or technical spikes while the authorization record remains NOT ISSUED.

## 12. Related V2 documents

- [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md)
- [M3-00 Mobilization and Decision Closure](M3-00_MOBILIZATION_AND_DECISION_CLOSURE.md)
- [M3-00 T07 Legal, Privacy, Source-Rights and Security Gate Register](M3-00_T07_LEGAL_PRIVACY_SOURCE_RIGHTS_SECURITY_GATES.md)
- [M2 Architecture Documentation Index](../05-architecture/README.md)
- [M2 Final Owner Acceptance and Closure Record](../05-architecture/M2_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md)
- [M2 Final Progress and Closeout Report](../05-architecture/M2_FINAL_PROGRESS_AND_CLOSEOUT_REPORT_2026-11-12.md)
- [Project Progress Report](PROJECT_PROGRESS_REPORT.md)
