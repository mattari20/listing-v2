# M3-11-04 — Human Operations and Support Readiness Preparation

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Package status:** DOCUMENTATION PREPARATION DELIVERED; HUMAN OPERATIONS READINESS BLOCKED  
**Scope:** Option A / Option 1 private V2 acceptance candidate only

## 1. Purpose and boundary

Define the minimum accountable human operating model required before any private acceptance environment can be used and before any later release decision. This record is a repository-side preparation artifact. It does not appoint people, accept duties on their behalf, provide professional advice, execute an incident exercise, provision an environment or authorize participant, production or public activity.

All examples and workflows are procedural templates. No real person, institution, student, guardian, staff member, provider, source or incident data is required or permitted in this package.

## 2. Required roles — deliberately unassigned

| Role | Minimum accountability | Required evidence before acceptance |
|---|---|---|
| Product Owner / accountable decision-maker | Own scope, risk acceptance, gate disposition and final decisions | Named person; dated written acceptance; decision authority and availability |
| V2 Operations Lead | Own private V2 operational readiness, runbooks, service health and handovers | Named person; written role acceptance; coverage window and deputy |
| Incident Commander | Coordinate severity assessment, containment, escalation and incident closure | Named person; written acceptance; authority, contact route and backup |
| Support Lead | Own support intake, triage, response targets and escalation | Named person; written acceptance; scope, coverage and escalation path |
| Privacy / Data Protection Lead | Coordinate privacy incidents, data minimisation, access and retention decisions | Qualified/appropriate named person; written acceptance; escalation and decision boundaries |
| Safeguarding Lead | Own safeguarding escalation and stop decisions where minors or vulnerable people could be affected | Appropriately qualified named person; written acceptance; safe escalation route |
| Security Lead | Own security incident coordination, vulnerability triage and remediation verification | Competent named person; written acceptance; incident authority and coverage |
| Release / Change Operator | Execute only an expressly approved, exact release/change action | Named operator; separate action-specific authorization; tested rollback authority |
| Recovery Owner | Own backup/restore/rollback coordination and recovery evidence | Named person; written acceptance; independent evidence and recovery authority |

One person may hold multiple roles only if the Product Owner explicitly records the combination, competence, conflicts, workload and deputy coverage. Separation of duties is required where a role would otherwise approve its own high-risk action. Role labels do not prove competence or appointment.

## 3. Responsibility and escalation model

- Every operational action must have one accountable human owner, a defined executor, an evidence record and a stop/escalation route.
- The assistant may draft checklists and summarize supplied evidence; it is not an accountable operator, reviewer, incident commander, privacy officer, safeguarding lead or release approver.
- No support request may be used to collect real student/guardian data in this preparation stage.
- A privacy, safeguarding or security concern must be escalated to the designated human lead; if no lead is accepted or the safe route is unclear, stop the activity and refer to the Product Owner.
- Only the accountable human may determine incident severity and authorize containment actions within their accepted authority.
- No person may approve their own privileged access, security exception, data disclosure or release action without an independent approval path.

## 4. Synthetic-only incident severity guide

| Level | Example (fictional/synthetic only) | Required response |
|---|---|---|
| SEV-1 Critical | Confirmed cross-boundary access, exposed secret, suspected real personal-data exposure, or serious safeguarding risk | Stop affected activity; preserve minimal safe evidence; notify accountable human leads immediately; no restart without written clearance |
| SEV-2 High | Material authorization failure, suspected security compromise, significant privacy control failure or critical service unavailable | Contain within pre-authorized authority; notify Operations, Security and relevant Privacy/Safeguarding lead; document decision |
| SEV-3 Moderate | Reproducible functional defect, support backlog or non-critical control degradation | Log synthetic issue; assign owner and due date; verify fix before closure |
| SEV-4 Low | Cosmetic or informational issue with no material control impact | Record, prioritize and resolve through ordinary change control |

Severity examples are guidance only, not an executed classification or an assurance that monitoring exists.

## 5. Support intake and handling procedure

1. Receive only synthetic test reports during repository preparation; do not solicit public reports or real user information.
2. Record issue ID, timestamp, affected synthetic workflow, observed behaviour, expected behaviour, severity proposal and reporter-safe contact route.
3. Exclude credentials, secrets, real personal data, screenshots containing personal data and unnecessary payloads.
4. Assign a named accepted Support Lead and an accountable technical owner before any operational handling.
5. Route suspected privacy, safeguarding or security matters immediately to the relevant accepted lead.
6. Record acknowledgement, containment/decision, owner, target date, verification evidence and closure rationale.
7. Close only after the accountable human confirms the disposition and records any residual risk.

No response-time SLA is set here. It must be approved against actual human availability before any environment is opened.

## 6. Incident response lifecycle

**Detect → record minimally → classify → notify → contain → investigate safely → remediate → independently verify → approve recovery → close and learn.**

- Do not investigate against production, V1, real data or an unapproved hosted environment.
- Do not copy secrets or personal data into GitHub issues, PRs, logs or chat.
- Preserve only the minimum synthetic evidence needed to explain a defect.
- Any suspected real-data exposure, cross-environment access, safeguarding risk, uncontrolled external egress or loss of isolation triggers an immediate stop.
- Recovery/restart requires the accountable human incident lead and relevant specialist sign-off; a developer's fix alone is insufficient.

## 7. Coverage, handover and continuity requirements

Before any private acceptance activity, the role register must contain:
- Primary and deputy names for every required role.
- Explicit written acceptance and date for each role.
- Competence/qualification evidence appropriate to the role.
- Availability windows, response expectations and out-of-hours coverage.
- Contact/escalation sequence and an alternate if the primary is unavailable.
- Handover format: open incidents, active risks, pending decisions, changes, recovery status and evidence location.
- Conflict-of-interest and separation-of-duties declarations.
- A documented stop-work authority for every operator.

A role without an accepted primary and workable backup is unstaffed. No assumption of 24/7 coverage is permitted.

## 8. Stop conditions

Stop and do not proceed if:
- A required role is unnamed, unaccepted, unavailable or lacks authority.
- A privacy, safeguarding or security escalation route is missing.
- A report contains real personal data or secrets.
- An incident crosses the private V2 boundary or suggests V1/production exposure.
- The requested action exceeds the accepted role's authority.
- The operator cannot establish safe rollback/recovery ownership.
- The environment, scope or data class differs from the separately approved private V2 acceptance boundary.

## 9. Acceptance checklist — not yet satisfied

- [ ] Product Owner confirms accountable decision authority and deputies.
- [ ] Operations Lead and Incident Commander are named and accept in writing.
- [ ] Support Lead is named and accepts in writing.
- [ ] Privacy/Data Protection, Safeguarding and Security leads are named and accept in writing.
- [ ] Release Operator and Recovery Owner are named with separate action-specific authority.
- [ ] Availability, escalation, handover and coverage are evidenced.
- [ ] Conflicts and separation-of-duties are reviewed.
- [ ] Product Owner accepts the completed role register and residual gaps.

## 10. Disposition

Repository preparation is delivered. No human owner has been named or accepted in the evidence available for this package. Therefore **M3-11-04 remains BLOCKED for actual human operations/support readiness**. This document does not close the package's substantive gate and does not authorize a tabletop, environment access, pilot, production activity or release.

Related artifacts:
- [Role Acceptance and Coverage Register](M3-11-04_ROLE_ACCEPTANCE_AND_COVERAGE_REGISTER_2026-11-17.md)
- [Status and Handoff](M3-11-04_STATUS_AND_HANDOFF_2026-11-17.md)
