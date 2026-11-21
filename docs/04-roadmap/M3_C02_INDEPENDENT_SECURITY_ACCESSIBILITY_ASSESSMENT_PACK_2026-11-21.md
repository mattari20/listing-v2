# M3-C02 — Independent Security and Accessibility Assessment Pack — 2026-11-21

**Repository:** `mattari20/listing-v2`  
**Baseline main:** `a0596731a662e251db1571fa69d74891e35dd256`  
**Work type:** Repository-only assessment-scope and evidence-pack preparation  
**Disposition:** **ASSESSMENT PACK PREPARATION COMPLETE / INDEPENDENT ASSESSMENT NOT PERFORMED / M3-11-03 REMAINS BLOCKED FOR FUTURE ASSURANCE**

## 1. Purpose and relationship to existing evidence

This agenda consolidates the future independent security and accessibility assessment requirements into an execution-oriented pack. It reuses, rather than overrides, the existing:
- `M3-11_LPS18_GAP06_HOSTED_ISOLATION_INDEPENDENT_ASSURANCE_RECOVERY_FRAMEWORK_2026-11-20.md`, which defines future target isolation, security and accessibility assurance, recovery dependencies and gate criteria;
- `M3-12_A08_ACCESSIBILITY_USABILITY_EVIDENCE_RECONCILIATION_2026-11-20.md`, which records current-main static source observations and selected palette calculations while explicitly retaining all nine manual review areas as NOT PERFORMED;
- `RCV-B05_MANUAL_ACCESSIBILITY_REVIEW_CHECKLIST_2026-11-20.md`, identified by A08 as the existing manual checklist;
- existing internal repository/CI evidence, which is not independent certification or a substitute for human assessment.

C02 closes only the repository-side preparation substage. It does not conduct an audit, test a live target, appoint an assessor, establish WCAG conformance, or promote M3-11-03.

## 2. Assessment tracks and target definition

The assessor must not combine different assurance questions into an ambiguous blanket approval.

### Track S — security

The assessor's written scope must identify the exact source revision, target/environment (if one is later separately authorized), interfaces, roles, trust boundaries, data classes, configuration evidence, test methods, permitted tools, exclusions and assessment window.

For the current authorized repository-only work, no hosted target exists for testing. Any future dynamic testing, penetration testing, hosted configuration inspection or access to a non-local target requires separate exact-scope Product Owner authorization before activity.

### Track A — accessibility

The assessor must identify exact user journeys, pages/components, language/direction variants, browser/device and assistive-technology combinations, test methods, applicable standard and version, sampling, limitations and whether the assessment is source-only, rendered/manual, or both.

A future hosted target is not required for a carefully bounded local/synthetic accessibility assessment, but any browser/device/assistive-technology session or external assessor engagement must be separately planned and authorized as needed. No participant research or student recruitment is included.

## 3. Assessor competence and independence

Before engagement, the Product Owner must verify and record outside the public repository:
- assessor identity and organization;
- demonstrable competence and relevant experience in application security and/or accessibility, as appropriate to each track;
- applicable professional qualifications/certifications where relevant, without treating a certificate alone as proof of competence;
- independence and conflict-of-interest declaration, including prior development, advisory, financial or personal relationships;
- ability to assess the exact target, methods and limitations;
- written acceptance of scope, exclusions, confidentiality, deliverables and any fee;
- whether separate security and accessibility specialists are required.

One individual must not be assumed competent in both domains. The same assessor must not certify their own implementation or rely solely on developer/AI assertions. No person is identified, selected, contacted or appointed by this repository agenda.

## 4. Track S — minimum security assessment coverage

The assessor should tailor the method and depth to the approved target and threat model. At minimum, the scope should address:

| Domain | Assessment questions / evidence |
|---|---|
| Architecture and trust boundaries | Exact components, entry points, data flows, trust boundaries and excluded systems |
| Authentication and sessions | Login/session lifecycle, cookie attributes, session fixation, expiry, revocation and cross-application separation |
| Authorization | Deny-by-default behavior, object/parent scope, role separation, privilege escalation and reviewer/representative boundaries |
| Input and output handling | Validation, encoding, injection classes, mass assignment, unsafe deserialization and error disclosure |
| File and storage controls | Upload validation, path traversal, private artifact exposure, storage ACLs and executable content |
| Secrets and configuration | Secret handling, repository/CI exposure, environment separation, least privilege and rotation evidence |
| Dependencies and build integrity | Dependency inventory, known vulnerabilities, lockfile/build provenance, CI permissions and artifact integrity |
| Data protection and logging | Sensitive data minimization, log redaction/access/retention, export/cache/session exposure |
| Abuse and resilience | Rate/abuse controls, resource exhaustion, workflow abuse and safe failure behavior |
| Security operations | Auditability, incident evidence, alert ownership, response/rollback readiness and unresolved operational dependencies |

The report must distinguish a code review from dynamic testing and must not imply that untested attack surfaces passed.

## 5. Track A — minimum accessibility assessment coverage

The assessment should use the existing RCV-B05 checklist and A08 evidence as inputs, not as proof of completion. It must explicitly address:

1. Keyboard-only completion of key journeys, visible focus, focus order, focus trapping and skip navigation.
2. Screen-reader landmarks, headings, names/roles/values, labels, validation errors, status announcements and comparison-table navigation.
3. Zoom and text resizing, including 200% and relevant reflow behavior.
4. Narrow viewport/mobile reflow, overflow and usable comparison interactions.
5. Contrast across text, controls, borders, focus, hover, active, error, disabled and dynamic states.
6. Urdu RTL layout, reading order, focus order and mirrored interaction behavior.
7. Mixed-direction Urdu UI containing English institution names, URLs, numerals and source-language facts.
8. Representative browser/device/assistive-technology combinations and documented test versions.
9. Human usability inspection of critical journeys and a qualified assessor's findings, limitations and conclusion.

The assessor must distinguish source-level inspection, automated checks, manual browser testing and assistive-technology testing. Selected CSS contrast ratios are not a complete contrast audit. No WCAG 2.2 AA claim may be made unless the assessor defines the applicable conformance scope and provides sufficient evidence against every applicable success criterion.

## 6. Required evidence and report format

Each finding/evidence item must be traceable to:
- unique evidence or finding ID;
- track (S or A), requirement and affected page/component/asset;
- exact commit, build and target/configuration revision where applicable;
- collection date, assessor, method and tools;
- reproducible steps or evidence reference, safely redacted;
- severity/impact and rationale;
- scope, sampling, assumptions and limitations;
- remediation owner, due date, objective acceptance criteria and retest;
- residual risk and accountable human disposition.

Each track's signed report must state:
- assessor identity, qualifications/experience and independence/conflict declaration;
- exact scope, revision, target, exclusions and test window;
- methods, tools, standards/versions and evidence examined;
- tests performed and not performed;
- findings with severity and reproducible references;
- remediation and retest results;
- material limitations and unavailable evidence;
- explicit conclusion: APPROVE, APPROVE WITH CONDITIONS, DO NOT APPROVE or UNABLE TO CONCLUDE;
- non-waivable blockers, reassessment triggers, report date and sign-off.

A checklist, automated scan, CI pass, unsigned note or generic statement of comfort is not an independent assessment report.

## 7. Findings severity and closure protocol

The assessor must explain the severity model used. The Product Owner must not downgrade a professional finding by editing the assessor's report. Record owner disposition separately.

- Critical/high security findings, critical accessibility barriers in essential journeys, unknown critical trust boundaries or evidence integrity failures block the relevant future gate.
- Medium/low findings require documented remediation or an explicit risk disposition by the properly accountable party; no silent waiver.
- Every remediated finding requires evidence of retest by a suitably competent person.
- Material changes to target, scope, data class, source revision or user journey trigger reassessment.
- Confidential reports and exploit-sensitive details must remain in an approved restricted location; the public repository should contain only non-sensitive references and dispositions.

## 8. Current evidence versus outstanding evidence

| Evidence | Current position |
|---|---|
| Internal source/code and CI security controls | Existing repository evidence only; not independent assurance |
| LPS-18 future security and accessibility assurance framework | Prepared |
| A08 source-level accessibility/localization and selected contrast reconciliation | Prepared; static/source-only |
| RCV-B05 manual accessibility checklist | Exists; A08 reports all nine manual areas NOT PERFORMED |
| Independent security assessor appointed | NOT RECEIVED |
| Independent security assessment report | NOT RECEIVED |
| Manual keyboard/browser/screen-reader/assistive-technology assessment | NOT PERFORMED |
| Independent accessibility assessor appointed | NOT RECEIVED |
| Independent accessibility report / WCAG conformance conclusion | NOT RECEIVED |
| Findings remediation and independent retest | NOT STARTED |

## 9. Authority and safety boundary

This agenda is documentation-only. It does not authorize:
- Hostinger/hPanel, V1, production or hosted access;
- live database, migrations, backup inspection, restore or recovery rehearsal;
- real/source/student/child/guardian/personal data;
- source contact, collection, scraping or publication;
- external API, AI/model/provider, crawler or agent;
- public UGC/reviews/ratings/moderation or participant activity;
- penetration testing, vulnerability scanning against a hosted/non-local target, intrusive probes or third-party testing;
- deployment, pilot, release candidate, public launch or DNS/cutover;
- procurement, paid assessment, new dependency, hosting upgrade or additional spend.

Any assessor engagement, fee, dynamic/hosted testing, browser/assistive-technology session, or external activity requires the Product Owner to approve the exact scope, person, method, target and cost before it occurs. Repository work remains local/GitHub CI and synthetic fixtures only.

## 10. C02 exit decision

**Repository-side assessment pack: COMPLETE.** Existing LPS-18 and A08 evidence have been reconciled into a clear two-track assessment scope, assessor qualification/independence requirements, coverage matrix, report contract, findings protocol and current evidence ledger.

**End-to-end independent assurance: NOT COMPLETE.** No independent assessor is appointed; no security or accessibility assessment has been performed; all nine manual accessibility areas remain outstanding; no WCAG conformance conclusion is made.

**M3-11-03:** internal repository-only review remains closed for its stated boundary; independent security/accessibility assurance for future target/release remains BLOCKED / NOT ACCEPTED.  
**M3-11:** BLOCKED / NOT ACCEPTED.  
**Overall M3:** OPEN / PARTIALLY COMPLETE — NOT CLOSED.

No gate is promoted by this pack. The next eligible event is a Product Owner decision to engage suitably qualified independent assessors under a separately approved exact scope, or to keep the assurance work deferred and the gate blocked.
