# M3 A4 — Owner-led Security and Risk Review — 2026-11-25

**Review authority:** Product Owner (owner-only model)
**Technical support:** ChatGPT evidence organization and analysis; not independent assurance
**Scope:** Repository/source/test-record review, bounded synthetic/local/CI evidence and future gates
**Disposition:** DOCUMENTARY OWNER-LED REVIEW COMPLETE WITH LIMITATIONS; target-dependent security acceptance remains deferred

## 1. Scope and boundary
This is an owner-led security and risk agenda, not penetration testing, an independent security assessment, a certification, or verification of a hosted target. This agenda does not access Hostinger, V1, production, a live database, a deployed target, or real data. No tests were newly executed in this review. Findings below are reconciled from recorded repository work and existing evidence descriptions; fresh exact-source inspection and test reruns are not represented.

The Product Owner is the sole reviewer/acceptance authority. Independent review is not required. This does not waive operational, hosted-isolation, recovery, access-control, age-restriction, release or execution gates.

## 2. Security evidence reviewed/reconciled
- **Authentication/session foundation:** previously delivered first-party session identity and scoped authorization foundations, with synthetic/local coverage. Actual hosted configuration, session lifetime/rotation, cookie flags and target behavior remain unverified.
- **Scoped authorization:** server-side ScopedAuthorization and institution-scoped reviewer-workspace rules were recorded in earlier implementation closeouts. Scope-level synthetic tests are evidence for those tested paths only, not a universal authorization audit.
- **Privileged workflow controls:** governed editorial, successor, evidence/correction and review flows have bounded synthetic coverage in ADM-A–ADM-G records. No fresh exhaustive inventory of all privileged actions/endpoints was performed here.
- **Public directory and publication boundary:** projection/allowlist and publication workflow evidence is recorded. Route enumeration, response-level exposure and disabled/hidden surfaces must be rechecked against a pinned future candidate.
- **Logging (SEC-06):** local/CI safeguards and synthetic tests exist. Historical implementation summary reports 20 tests passed, 1,175 assertions and 230 warnings on the noted run; this is not a fresh run and does not prove hosted log path, permissions, forwarding, effective settings, arbitrary message hygiene or backup lifecycle.
- **Repository/dependencies:** prior Foundation CI records Composer audit and repository artifact hygiene checks in specific runs. No fresh dependency audit or full source review was executed in this agenda.
- **Security headers/accessibility regressions:** prior implementation records include security-header regression and accessibility contrast/focus checks; these narrow checks are not a comprehensive browser, security or WCAG assessment.
- **V2 deployment preparation:** documented subfolder templates and bounded historical synthetic Hostinger probes were not re-performed here. Shared-hosting subfolder layout is not private filesystem isolation; the deployment remains unaccepted and un-deployed.

## 3. Risk register and owner disposition

| ID | Risk | Evidence/limitations | Owner-led disposition / next control |
|---|---|---|---|
| A4-01 | Authentication/session configuration may differ in a future target. | Source/local synthetic foundations; effective hosted settings not verified. | DEFER target acceptance; before access, review cookie scope, secure/HTTP-only/SameSite, expiry, invalidation, CSRF and session handling for the exact configuration. |
| A4-02 | Authorization or scope leakage may occur in untested routes/actions. | ScopedAuthorization and bounded regression tests exist; no exhaustive route/action audit performed. | ACCEPT bounded test evidence only; require exact-candidate route/action inventory and owner review of positive/negative scope tests before user-facing activity. |
| A4-03 | Privileged/editorial workflow misuse or bypass. | Governed workflows and synthetic coverage documented; complete privileged-action inventory not newly verified. | DEFER comprehensive candidate review; enumerate privileged actions, deny-by-default behavior, server-side guards and immutable/auditable transitions. |
| A4-04 | Public response/projection may expose fields or surfaces beyond intended allowlist. | Publication/projection evidence exists; fresh endpoint/browser enumeration not performed. | DEFER; pinned-candidate response inspection and tests for excluded fields, hidden routes and disabled features required. |
| A4-05 | Logs may expose secrets, identifiers, message content or path details; retention/permissions may vary. | SEC-06 local/CI evidence partial; target and backup behavior unknown. | ACCEPT local/CI controls only; review effective config, producers, message hygiene, access, path, retention and backups before provisioning or access. |
| A4-06 | Dependency vulnerabilities or unsafe repository artifacts may arise after recorded checks. | Earlier Composer audit/hygiene checks are commit/run-specific, not current fresh results. | ACCEPT historical evidence only; rerun exact-head dependency and artifact checks for any candidate. |
| A4-07 | Hosted shared-subfolder arrangement may not isolate V2 from V1 or other hosted resources. | Historical probes prove only exact tested paths; no private filesystem isolation or full runtime proof. | BLOCK hosted acceptance until separately authorized V2-only target evidence establishes boundaries; no probing V1/production. |
| A4-08 | Abuse, scraping, denial-of-service or misuse of anonymous discovery endpoints. | No fresh rate/volume, abuse or load verification. | DEFER; no public activation. Future owner review should consider abuse limits, caching, resource controls and monitoring within budget. |
| A4-09 | Future minor/child access despite adult-only policy. | 18+ is policy, not proven technical restriction. | BLOCK user-facing activity until proportionate access restriction is implemented and owner-verified; no age-data collection now. |
| A4-10 | UGC, reporting, moderation or Deeni Madaris surfaces could be activated beyond scope. | Features/scope are excluded or default-OFF; no exhaustive live-target verification. | PRESERVE exclusion; no activation or public exposure. |
| A4-11 | Secrets/confidential information may be exposed through public repository, commits, CI or artifacts. | Public repository during development; prior hygiene checks exist but no fresh exhaustive scan. | ACCEPT current development boundary; keep secrets out, inspect exact candidate artifacts and honor the previously recorded visibility change to private at development completion. |
| A4-12 | Backup/recovery/incident response could be insufficient in a hosted environment. | Target-specific backup, restore, incident and access evidence not established by this agenda. | DEFER; remains a distinct future operational/recovery gate. |

## 4. Priority remediation and acceptance agenda
**Priority A — before any target access or user-facing activity**
1. Owner review of exact target/operator/provider/region, effective configuration and V2/V1 boundary evidence (separate authorization required).
2. Candidate-specific route/endpoint and privileged-action inventory; verify server-side authorization and deny paths.
3. Session, cookie, CSRF, password/authentication and account lifecycle settings for the exact target.
4. Publication response and public projection field/route exposure inspection.
5. Effective logging controls, sensitive-message hygiene, access/permissions, forwarding, retention and backup copy treatment.
6. Adult-only technical restriction design and verification (separate gate).
7. Recovery, incident/operations and release/execution evidence (separate gates).

**Priority B — before candidate acceptance**
- Exact-head Foundation CI and documentation validation.
- Fresh dependency audit and repository artifact/secrets hygiene checks.
- Synthetic authorization, route, publication, session, logging and exclusion regressions for changed/exposed paths.
- Owner-led accessibility and browser review where applicable; no conformance claim without evidence.

**Priority C — ongoing**
- Reassess security risks after any material change in scope, routes, data, dependency, provider, environment or visibility.
- Preserve the fail-closed boundaries, synthetic-only work and no-spend constraint.

## 5. Restrictions preserved
No production/V1/Hostinger/hosted access or change, no live database, no real/source/student/child/guardian/personal data, no source acquisition or contact, no external API/AI, no new dependency/provider/spend, no deployment/migration/cutover, no pilot/public launch, no user-facing activation, no UGC/reviews/reporting/moderation, and Deeni Madaris remains default-OFF. No action beyond repository documentation is authorized by this report.

## 6. A4 exit disposition
- Owner-led documentary/synthetic security-risk review: **COMPLETE WITH LIMITATIONS**.
- Fresh tests or exhaustive source/route audit in this agenda: **NOT PERFORMED**.
- Independent security assessment: **NOT REQUIRED** under owner-only review decision; no independent assurance claim.
- Target-specific, hosted and candidate acceptance: **DEFERRED / NOT ACCEPTED**.
- Remediation priority register: **RECORDED**.
- M3 overall: **OPEN / PARTIALLY COMPLETE**; no user-facing, hosted, pilot, release or production authorization.

