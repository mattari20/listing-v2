# M3-10 — Pilot and Launch Readiness Work Plan

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Original planning baseline:** `60690f56ac1776a8320e5dffc70adf961b0219ca`  
**Latest reconciled main (2026-11-17):** `f7d83bda86430017885026c4069109d2ad6ce7fa`  
**Authorization:** Product Owner explicitly authorized moving into M3-10 on 2026-11-16  
**Current disposition:** IN PROGRESS — technical university workflow and synthetic adversarial hardening merged; proposal-only owner decision recorded; pilot readiness NOT ACCEPTED  
**Next step:** obtain explicit, bounded owner decisions and required qualified reviews before any participant, data-bearing, hosted or operational pilot activity

## 1. Purpose and interpretation of authorization

M3-10 prepares a bounded pilot and a defensible go/no-go decision. The Product Owner's authorization to move into M3-10 authorizes readiness planning, project-document reconciliation and synthetic-only local/CI/tabletop work within existing controls. It does **not** approve a pilot cohort, participant recruitment, student research, personal or institutional data processing, external-source access, public UGC/reviews, moderation activation, hosted preview, production access, deployment, launch or spend.

The roadmap requires the pilot's scope, participants, data and operational safeguards to be separately approved before the pilot is prepared or conducted. No such approvals are inferred from the M3-10 agenda authorization.

## 2. Binding boundaries

- V2 only. Do not inspect, use, copy, adapt or connect to V1 code, schema, data, systems or operations.
- Synthetic and fictional fixtures only for current work. No real student, guardian, staff, provider, institution or source records.
- No student interviews, surveys, recruitment or outreach during construction. Existing research instruments remain inactive.
- No real participants, participant contact, consent collection or human usability/research sessions are authorized by this work plan.
- No minors or vulnerable-user participation is approved. No age/identity documents or student-status proof may be collected.
- No external-source access, scraping, bulk download, permission requests, source ingestion, connector activation or AI/model service use.
- Public UGC, reviews, ratings, reporting and public moderation remain disabled. Reviews remain post-launch only. M3-08's internal synthetic moderation workflow is not a live moderation operation.
- Deeni Madaris remains default-OFF and must have zero public exposure across all public surfaces and side channels.
- No production/Hostinger/hPanel/live database access, deployment, release, URL cutover, hosted pilot or launch.
- No new dependency, vendor, external service, procurement or spend.
- No unapproved legal interpretation, numeric SLO, RPO/RTO, retention period, pilot success threshold or budget is to be represented as settled.
- Existing tests and controls must not be weakened. Exact-head CI and documentation validation remain required for every PR.
- ChatGPT is not an independent security, legal, privacy, safeguarding or operations approver and cannot assume accountable human staffing.

## 3. M3-10 package breakdown

| Package | Work | Deliverable | Current status |
|---|---|---|---|
| M10-01 | Pilot charter and scope boundary | Pilot charter template, decision fields, in/out scope and stop conditions | Planning can proceed; owner has not selected a pilot |
| M10-02 | Participants, eligibility and safeguarding | Participant/data minimization matrix, consent and safeguarding review gates; no recruitment | Blocked pending explicit owner decision and qualified review |
| M10-03 | Data, sources and privacy | Data inventory template, source-rights checks, retention/deletion and synthetic default | Synthetic-only planning; real data/source use not approved |
| M10-04 | Support, moderation and operational ownership | Role/coverage matrix, support escalation design and moderation boundary | Blocked: accountable operations/moderation owners and staffing not assigned |
| M10-05 | Incident, continuity, backup and rollback | Severity/stop matrix, tabletop scripts, recovery/rollback checklist | Synthetic tabletop/runbook only; live recovery not authorized or evidenced |
| M10-06 | Pilot acceptance and launch recommendation | Defect/exception log, acceptance report and go/no-go template | Template can be prepared; acceptance and launch recommendation cannot yet be issued |

These are planning work packages, not permission to implement live-facing features or begin fieldwork.

## 4. Pilot charter — decisions required before a pilot can be approved

| Decision | Required owner input / evidence | Current disposition |
|---|---|---|
| Pilot purpose and hypotheses | Specific user problem, what the pilot must validate, and what it will not validate | OPEN — not selected |
| Pilot type | Synthetic-only rehearsal, non-production usability activity, or data-bearing pilot; describe exact boundary | OPEN — no type approved |
| Geography and institution scope | Province/district/city, provider categories and inclusion/exclusion rules | OPEN — no cohort selected |
| Product surfaces | Exact pages, workflows, roles and capabilities to be exposed | OPEN — no pilot surface approved |
| Participants | Participant categories, number, eligibility, recruitment method and withdrawal route | NOT APPROVED — no recruitment or contact |
| Minors / vulnerable users | Qualified safeguarding assessment, eligibility controls and owner decision | NOT APPROVED — no minor participation |
| Data | Exact fields, source, sensitivity, purpose, collection method, storage, access, retention and deletion | SYNTHETIC ONLY by default; real data not approved |
| Source rights | Source-specific authority, permitted access/reuse method and written permission where required | RESEARCH ONLY / NOT APPROVED |
| Duration and dates | Start/end, support hours, review cadence and expiry | OPEN — no schedule |
| Success and stop thresholds | Owner-approved measurable thresholds, defect severity and tolerable exceptions | OPEN — no numeric thresholds inferred |
| Budget | One-time and recurring costs, including any hosting/vendor implications | NO NEW SPEND AUTHORIZED |
| Accountable operations | Named pilot owner, support owner, incident lead, security contact and backups | OPEN — no operational roster approved |
| Qualified reviews | Legal/privacy, child safeguarding and independent security review as applicable | REQUIRED; reviewers not assigned / approvals not evidenced |
| Exit and deletion | Closeout, participant communications if applicable, data export/deletion and access revocation | OPEN — no retention schedule approved |

A pilot charter is not complete until every applicable row has an evidence-backed disposition and the Product Owner approves the exact bounded scope in writing.

## 5. Participants, privacy and safeguarding gates (M10-02)

1. Do not revive or distribute the deferred student research instruments.
2. Do not recruit, contact, interview, survey or observe students or other participants under this agenda authorization.
3. If a future proposal includes people, first define the participant population, purpose, minimum sample, eligibility, recruitment channel, compensation (if any), consent/withdrawal process, support contact and complaint route.
4. A qualified legal/privacy and child-safeguarding reviewer must assess the proposed population, jurisdiction, notices, lawful basis, age-related risk, guardian/consent needs and data lifecycle. The owner must explicitly approve the protocol after review.
5. No minor participation is authorized by this plan. Do not infer an age threshold or substitute login for age, student status, attendance or affiliation proof.
6. Collect no identity documents, birth dates, student records, guardian records, phone numbers or other sensitive data merely to make a pilot convenient.
7. If no participant protocol is approved, the only permissible exercise remains synthetic-only local/CI or a non-human tabletop.

## 6. Data and source gates (M10-03)

The default dataset for any immediately permissible exercise is fabricated, deterministic synthetic data. A future data-bearing pilot requires a field-level inventory containing purpose, necessity, source/authority, access method, sensitivity, visibility, processor/location, access roles, retention, deletion, correction and export rules.

For every external source, the source-specific M3-00 T07 G02–G04 gates must be approved for the exact fields, purpose, access method, period and environment. Public availability is not reuse permission. All candidate source families remain research-only unless a separate approval record says otherwise.

Before any real or personal data is used, require qualified privacy/legal review, safeguarding review where relevant, security review, an accountable data owner and explicit owner approval. No data-bearing pilot may start while these are missing.

## 7. Support, moderation and operational ownership (M10-04)

| Function | Minimum readiness evidence | Current status |
|---|---|---|
| Pilot accountability | Named human owner with authority to stop the pilot | Not assigned in this record |
| User support | Support hours, channel, response expectations, escalation and closure procedure | Not defined / no live support channel |
| Technical operations | Named operator, access boundaries, change control and coverage | Not assigned |
| Security incident | Named incident lead and independent escalation contact | Not assigned |
| Safeguarding escalation | Qualified safeguarding owner, response protocol and safe referral route | Not assigned |
| Moderation | Named trained moderators, conflict-of-interest controls, appeal reviewer and coverage | Not staffed; no public moderation enabled |
| Data governance | Named data owner and correction/withdrawal/deletion authority | Not assigned |

No public review, rating, report intake, UGC or moderation activation is part of M3-10 readiness planning. If a later pilot requires any of these, it needs a separately authorized feature and operations scope, qualified review, staffing and acceptance tests before exposure.

The current project is owner-led and ChatGPT-assisted. This does not establish a staffed support desk, security on-call rotation, moderation team or accountable independent reviewer.

## 8. Incident, recovery and rollback readiness (M10-05)

### Severity and stop rules

- **Critical / immediate stop:** V1 access or interference; real personal data unexpectedly present; secret exposure; private or suppressed data publicly exposed; Deeni Madaris leakage; unauthorized source access; unexpected external network/API activity; unauthorized spend; production write/deployment; safety or safeguarding concern.
- **High / do not proceed:** unresolved high security/privacy defect; missing required reviewer; no accountable operator; failed restore evidence where data-bearing operation is proposed; unapproved scope or participant/data change.
- **Medium / disposition required:** material accessibility, usability, reliability, support or documentation defect. No severity may be waived silently.

On a critical trigger, stop the exercise, disable the affected synthetic workflow where possible, preserve minimal diagnostic evidence without secrets/personal data, notify the designated human owner through an already approved channel, and do not retry with broader permissions. No real incident notification or production containment is simulated by a tabletop.

### Current recovery evidence and limits

M3-09 Q05 proves a disposable local SQLite file-copy/restore exercise only. It does not prove Hostinger/MySQL/production backup, encryption, off-site retention, point-in-time recovery or disaster recovery. No RPO/RTO is approved. A future data-bearing pilot requires a V2-specific backup owner, access/encryption/retention/deletion decisions, isolated restore rehearsal, measured recovery evidence and proof that V1/shared resources cannot be affected. Those activities require separate environment and data authorization.

### Rollback checklist for a future separately approved pilot

1. Confirm exact pilot build, configuration, data stores and affected surfaces.
2. Stop new pilot activity and revoke pilot-only access.
3. Preserve required audit/evidence records without retaining unnecessary personal data.
4. Restore only from a verified V2-specific recovery point into the approved V2 target.
5. Revert only the approved V2 artifact/configuration; never touch V1 or shared settings.
6. Verify public/private boundaries, Deeni Madaris default-OFF and core directory behavior.
7. Reconcile data changes, corrections, deletion obligations and unresolved incidents.
8. Obtain human owner sign-off before any resumption.

This is a design checklist, not a tested production rollback.

## 9. Pilot acceptance and launch recommendation (M10-06)

A future pilot acceptance report must record:
- Approved charter version and owner authorization.
- Exact participant/data/product-surface scope and exclusions.
- Required qualified review outcomes and expiry/conditions.
- Build SHA, environment identity, test/CI evidence and known limitations.
- Participant/support/incident/moderation ownership and coverage.
- Defects by severity, reproducibility, disposition and any owner-approved exception.
- Privacy, safeguarding, security, accessibility and data-quality outcomes.
- Backup/restore and rollback evidence appropriate to the approved environment.
- Success/stop threshold results against owner-approved targets.
- Data deletion/retention and access revocation evidence at closeout.
- Explicit go/no-go decision, decision owner and date.

**No launch recommendation can be issued now.** The required pilot scope, participants, data, operational owners and qualified sign-offs are not approved/evidenced. M3-11 production launch remains a separate conditional step requiring separate explicit written authorization.

## 10. Current gate matrix

| Gate | Required state before relevant pilot activity | Current state | Blocks |
|---|---|---|---|
| M10-G01 Owner-approved pilot charter | APPROVED — LIMITED SCOPE | OPEN | Any pilot |
| M10-G02 Participant protocol / no-research deferral resolution | APPROVED — LIMITED SCOPE | NOT APPROVED | Human participants |
| M10-G03 Data inventory and lawful/authorized purpose | APPROVED — LIMITED SCOPE | SYNTHETIC ONLY | Real/personal data |
| M10-G04 Source rights and access method | APPROVED — LIMITED SCOPE | RESEARCH ONLY / NOT APPROVED | External-source data |
| M10-G05 Legal/privacy review | Qualified written review | REVIEW REQUIRED; reviewer not assigned | Personal/data-bearing pilot |
| M10-G06 Child safeguarding | Qualified written review and owner decision | REVIEW REQUIRED; reviewer not assigned | Any minor/vulnerable-user scope |
| M10-G07 Independent security review | Written review and disposition | REVIEW REQUIRED; reviewer not assigned | Hosted/data-bearing pilot and release |
| M10-G08 Operational ownership/support | Named, capable human owners and coverage | NOT ASSIGNED | Any operational pilot |
| M10-G09 Moderation/appeals staffing | Approved policy, trained independent roles and coverage if UGC exists | NOT STAFFED; UGC disabled | Any UGC/review scope |
| M10-G10 Recovery/rollback | Environment-specific tested evidence and owner-approved targets | LOCAL SQLITE TEST ONLY | Data-bearing/hosted pilot |
| M10-G11 Accessibility/capacity | Human accessibility review and representative evidence/approved targets | PARTIAL AUTOMATED CHECKS ONLY | Broad pilot / launch recommendation |
| M10-G12 Budget and third parties | Explicit no-cost fit or approved cost/vendor scope | NO NEW SPEND; NO VENDOR | Any spend/vendor |
| M10-G13 Pilot acceptance | Complete evidence and owner acceptance | NOT STARTED | M3-10 exit |
| M10-G14 Production launch | Separate M3-11 written authorization | NOT AUTHORIZED | Production release |

## 11. Work execution and stop point

The following can proceed under the current M3-10 agenda authorization:
- Prepare and maintain this readiness plan, charter template, decision matrix and acceptance template.
- Reconcile project documentation and traceability.
- Run synthetic-only local/CI tests and non-human tabletop exercises that do not touch production, external services or real participants.
- Identify defects and blockers from existing repository evidence without weakening tests or changing unrelated scope.

Stop before:
- Recruiting/contacting participants or distributing research instruments.
- Using real student, staff, provider or institution data, or external source data.
- Enabling public UGC, reviews, ratings, report intake or moderation.
- Creating a hosted pilot/preview, changing hosting, adding vendors or spending money.
- Production access, deployment, release, launch or URL cutover.

## 12. M3-10 exit decision

**M3-10 status:** IN PROGRESS — readiness framework and decision pack prepared; no pilot conducted and no launch recommendation issued.

M3-10 can only be accepted after the owner has separately approved a bounded pilot charter, all applicable participant/data/source/operational gates are satisfied, the approved pilot is conducted within scope, defects are closed or explicitly accepted, accountable human operations and qualified sign-offs are evidenced, and a complete pilot acceptance report supports a go/no-go recommendation.

If the owner chooses not to authorize human participants or real data, the agenda remains limited to synthetic readiness evidence and cannot be described as a real-world pilot or as launch-ready.

## 13. References

- [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md)
- [M3-00 T07 Legal, Privacy, Source-Rights and Security Gates](M3-00_T07_LEGAL_PRIVACY_SOURCE_RIGHTS_SECURITY_GATES.md)
- [M3-01 P06 Environment, Test, CI, Release and Rollback Plan](M3-01_P06_ENVIRONMENT_TEST_CI_RELEASE_ROLLBACK_PLAN_2026-11-13.md)
- [M3-07 D4 Synthetic Extensible-Institution Pilot Specification](M3-07_D4_SYNTHETIC_EXTENSIBLE_INSTITUTION_PILOT_SPECIFICATION.md)
- [M3-08C/D Synthetic Moderation, Appeals and Privacy/Security Record](M3-08C_D_IMPLEMENTATION_RECORD.md)
- [M3-09 Quality and Operational Hardening Record](M3-09_QUALITY_OPERATIONAL_HARDENING_RECORD.md)


## 14. Initial readiness framework delivery evidence

Readiness framework PR [#240](https://github.com/mattari20/listing-v2/pull/240) merged as `d733bca59e5cb519f0a3d74231145ee24d298ed4` from exact validated head `9248721ef7e50c0d68693c64a822866acc86d592`. FND-01 PHP 8.5 CI [#43893286963](https://github.com/mattari20/listing-v2/actions/runs/43893286963) and Project documentation validation [#43893048895](https://github.com/mattari20/listing-v2/actions/runs/43893048895) passed on that head. The full synthetic suite remained 15 passed / 953 assertions / 205 existing non-fatal missing-local-`.env` diagnostics; no `.env` was created. Post-merge documentation validation [#43893419189](https://github.com/mattari20/listing-v2/actions/runs/43893419189) passed on the merge commit.

This merge records delivery of the M3-10 readiness plan only. It does not record approval or execution of a pilot, participant protocol, real-data scope, hosted preview, production deployment, public UGC/reviews/moderation or launch. The M3-10 status remains IN PROGRESS and M3-11 remains separately gated.


## 15. Final readiness reconciliation update — 2026-11-17

This section is the current status addendum and supersedes earlier route-gap and owner-decision statements where they conflict with later merged evidence.

### Owner decision
The Product Owner selected **Option B** on 2026-11-17: prepare a narrowly bounded future pilot proposal for separate review only. The proposal describes an adult-only, invitation-based evaluation of one V2 university institution profile review/correction workflow, fabricated synthetic records, and a not-yet-provisioned isolated non-production environment. Lahore, Punjab, Pakistan and category university are proposal descriptors only. This decision is not pilot approval or permission for participant contact, consent, sessions, data processing, source access, hosted activity, deployment, spend or launch. The existing pre-launch research deferral remains binding.

### Technical evidence now available
- PR #248 merged university representative submission/correction and independent editorial-review HTTP routes, scoped to the exact university institution.
- PR #249 merged implementation evidence closeout.
- PR #250 merged six additional synthetic adversarial feature cases: revoked/expired roles, forged request fields, unknown/revoked-authority evidence, changed-payload idempotency replay, SQLite audit-failure rollback and audit integrity.
- PR #251 merged the final adversarial documentation closeout.
- Current main at reconciliation: `f7d83bda86430017885026c4069109d2ad6ce7fa`.

The HTTP workflow exists at the API/controller level. No adjudication or publication endpoint was added. This record does not claim a browser-facing UI, human usability acceptance, provisioned pilot environment or end-to-end human session.

### Updated package disposition
| Package | Current disposition |
|---|---|
| M10-01 — Pilot charter and scope | Proposal prepared; exact activity charter, thresholds, cohort, duration, cost and final owner approval remain OPEN |
| M10-02 — Participants, consent and safeguarding | BLOCKED; research deferral unresolved; no participants/contact/consent/sessions authorized |
| M10-03 — Data, sources and privacy | SYNTHETIC ONLY; no real/personal/institution/source data or source access authorized |
| M10-04 — Support, moderation and ownership | BLOCKED; accountable pilot, support, technical, incident, privacy/data and safeguarding owners not assigned; public UGC/moderation disabled |
| M10-05 — Incident, continuity and rollback | DESIGN / LIMITED SYNTHETIC EVIDENCE; disposable SQLite restore only; no hosted or production recovery evidence |
| M10-06 — Pilot acceptance and go/no-go | NOT ACCEPTED / NOT STARTED; no pilot activity, results, thresholds or qualified sign-offs |

### Gate disposition
M10-G01 remains OPEN for an owner-approved exact pilot charter. M10-G02 NOT APPROVED; G03 SYNTHETIC ONLY; G04 NOT APPROVED; G05 legal/privacy REQUIRED / NOT EVIDENCED; G06 safeguarding REQUIRED IF RELEVANT / NOT EVIDENCED; G07 independent security REQUIRED / NOT EVIDENCED; G08 operations/support NOT ASSIGNED; G09 moderation NOT STAFFED / PUBLIC UGC DISABLED; G10 recovery NOT SATISFIED FOR PILOT; G11 accessibility PARTIAL / NOT ACCEPTED; G12 NO NEW SPEND / NO VENDOR; G13 pilot acceptance NOT STARTED; G14 M3-11 NOT AUTHORIZED.

**Current decision:** readiness framework and authorized technical/documentation work are delivered; M3-10 pilot readiness remains **NOT ACCEPTED**; no pilot go/no-go is issued; human/participant activity and real-data processing remain **NOT AUTHORIZED**; M3-11 remains **NOT AUTHORIZED**.
