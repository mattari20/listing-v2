# M3-11-03 — Independent Security and Accessibility Review Pack

**Prepared:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Package:** M3-11-03 — Independent security and accessibility  
**Status:** **REVIEW PREPARATION DELIVERED — INDEPENDENT ASSESSMENTS NOT PERFORMED; GATE BLOCKED**  
**Target:** Option A / Option 1 — bounded discovery in a private V2-only acceptance environment  
**Decision owner:** Product Owner

## 1. Purpose and limitations

This pack defines the scope, evidence request, evaluation criteria and response process for independent security and accessibility reviewers. It does not perform a penetration test, vulnerability assessment, source-code audit, accessibility audit, usability study or certification. No reviewer has been appointed, no candidate/environment has been pinned for assessment, and no independent findings are evidenced by this record.

Do not mark M3-11-03 complete based on this pack, repository CI, automated scanners alone, a self-review by the implementer, or the absence of reported defects. Closure requires independent written assessments of the exact candidate and relevant operating context, documented remediation/retest, and a Product Owner disposition of all findings.

The bounded scope is governed by [M3-11-01 Scope and Authority Closeout](M3-11-01_SCOPE_AND_AUTHORITY_CLOSEOUT_2026-11-17.md), [M3-11-02 Legal, Privacy and Safeguarding Review Pack](M3-11-02_LEGAL_PRIVACY_SAFEGUARDING_REVIEW_PACK_2026-11-17.md) and the [Option A scope charter](M3-11_OPTION_A_CONTROLLED_LIMITED_V2_RELEASE_SCOPE_CHARTER_2026-11-17.md). Reviewers must state the exact commit, build/artifact, configuration, routes, data fixtures, environment facts and documents reviewed.

## 2. Binding review boundary

### In scope for future private acceptance assessment

- Existing M3-05 anonymous, read-only directory browse/search/category/profile experience.
- Existing M3-06 manual text-locality discovery.
- Existing published-projection/public-field allowlist and suppression/current-version behavior relevant to those surfaces.
- Existing identity/session and scoped authorization foundations insofar as they exist in the pinned candidate and are reachable by specifically authorized internal reviewers/operators.
- Server-rendered HTML, browser behavior, routes, middleware, authorization policies, configuration, dependencies, logging and relevant operational boundaries of the pinned candidate.
- Accessibility of the exact included discovery experience and any approved internal-only access/review flow in scope.

### Explicitly out of scope

- Public launch, public pilot, general public access or production release.
- Admissions, application submission, eligibility, deadlines, fees, scholarships, payments, accounts-dependent discovery, saved items, comparison/alerts, ranking/recommendations/advertising.
- Fuzzy/transliteration search, maps, coordinates, geolocation, geocoding or external search services.
- Live source ingestion, external APIs/connectors/AI/models, third-party scripts or new vendors/dependencies.
- Public reviews, ratings, UGC, report intake, moderation or appeals activation.
- Student, child, guardian or participant accounts/activity; recruitment, interviews, surveys or usability research.
- Real institution/provider/student/guardian/staff/source/production data or personal data. Synthetic/fictional fixtures only.
- V1 repository/application, Hostinger/hPanel, production/live database, shared production infrastructure, DNS/URL cutover, migrations, deployment or environment provisioning.
- Deeni Madaris public exposure; it remains default-OFF with zero public exposure.

The private V2 acceptance environment is not provisioned. Its host, path, runtime, database, credentials, secrets, isolation evidence and access roster remain unspecified. M3-11-05 must separately authorize and evidence environment isolation before any environment creation or reviewer access. This pack does not authorize active testing against any live or hosted target.

## 3. Independence and reviewer competence

The Product Owner should appoint reviewers who are independent of the implementation being assessed and competent for the specific workstream.

For security, request demonstrated application-security experience covering modern web applications, authorization, session management, secure coding, dependency/configuration review and controlled penetration testing. Require a written methodology, test boundaries, tooling, limitations and conflict-of-interest declaration.

For accessibility, request demonstrated accessibility audit experience using WCAG 2.2 AA as the proposed evaluation baseline, including manual keyboard and assistive-technology testing. The reviewer should identify the applicable standard/version and any jurisdictional requirements, explain sampling and assistive technology coverage, and disclose limitations. WCAG 2.2 AA is a proposed technical benchmark for evaluation, not a legal applicability conclusion or a claim of conformance.

One person may cover both only if independently qualified for both disciplines and the conflict/independence assessment supports that arrangement. Otherwise appoint separate reviewers. Do not invent reviewer names, credentials, availability, acceptance or findings.

## 4. Security assessment scope

### A. Architecture, attack surface and threat model

1. Pin the candidate commit and inventory all application routes, HTTP methods, middleware, controllers, services, policies, scheduled/background processes, storage, file handling and outbound network paths.
2. Draw trust boundaries and data flows for anonymous visitors, authenticated users, provider representatives, reviewers, publishers, moderators, administrators and service identities, but only where those identities/actions exist in the candidate.
3. Identify assets, threat actors, entry points, privilege boundaries, sensitive data classes, abuse cases and security assumptions.
4. Verify that the actual private acceptance environment is isolated V2-only and cannot affect V1/shared resources before any active testing. If not independently evidenced, do not test it.
5. Identify every externally reachable service and administrative surface in the approved target. No target is approved by this pack.

### B. Authentication, sessions and authorization

1. Test authentication lifecycle and session handling where implemented: cookie flags, secure transport assumptions, expiry, rotation, logout/revocation, fixation resistance, CSRF protections and recovery/verification behavior.
2. Independently evaluate role × action × resource-scope authorization. Attempt horizontal and vertical privilege escalation, identifier substitution, direct endpoint invocation, forged fields, stale/revoked role use and access through alternate routes.
3. Verify server-side deny-by-default behavior; UI hiding is not a security boundary.
4. Test separation of duties and self-approval restrictions for the implemented governance workflows.
5. Verify least privilege for service identities and secrets; no shared human/service credentials or self-granting privilege path.
6. Confirm error responses do not leak account existence, tokens, stack traces, internal identifiers or sensitive state.

### C. Application security and abuse resistance

1. Test input validation, output encoding, stored/reflected XSS, SQL/query injection, command/path injection and unsafe deserialization where relevant to the stack.
2. Test CSRF, clickjacking, content-type handling, security headers, cache behavior and cross-origin policy.
3. Review file upload/download behavior if present; verify type/size validation, storage isolation, authorization and safe rendering. If absent, record not applicable based on route inventory.
4. Assess SSRF and outbound request risks, open redirects, host-header trust and URL handling where applicable.
5. Test rate limits and abuse controls for authentication, directory search and sensitive endpoints; assess enumeration, resource exhaustion and denial-of-service exposure within a safe, pre-agreed test envelope.
6. Review dependency lockfiles, known advisories, dependency provenance, abandoned packages and build/install scripts. CI advisory checks are a signal, not a complete supply-chain assessment.
7. Review secret handling, environment configuration, debug mode, error reporting, logging, audit trails, backup/export exposure and repository artifact hygiene.
8. Review public directory projections, allowlists, suppression, current-version rules and Deeni Madaris default-OFF behavior across browse, direct lookup, search, facets, counts, cache and any export/API surface present.
9. Review privacy leakage through HTML/JSON responses, headers, logs, errors, cache keys, analytics/telemetry and metadata.
10. Verify that no public UGC/review/report/moderation surface is activated in the candidate.

### D. Security findings and retest

For every finding, record severity, reproducible steps, affected component/route, preconditions, impact, evidence that avoids personal data/secrets, remediation recommendation, owner, due date, retest result and residual risk. Identify whether a finding blocks environment provisioning, reviewer access, private acceptance, or any future release. Critical/high findings must not be waived by informal verbal agreement.

The reviewer must state the severity taxonomy and explain any departures from common industry practice. Include a concise executive summary and explicit approve / approve-with-conditions / do-not-approve / unable-to-conclude outcome.

## 5. Accessibility assessment scope

### A. Evaluation baseline and sample

Use WCAG 2.2 Level AA as the proposed technical evaluation baseline unless the qualified reviewer documents a different applicable requirement. Assess every included page template and interaction state in the pinned candidate, not only the home/search landing page.

At minimum, inspect:
- directory landing/browse;
- search with empty, valid, no-result and invalid/edge input states;
- category and locality filters/facets;
- entity profile pages;
- pagination or other result-navigation patterns if present;
- validation, loading, empty, error and suppressed/unknown/freshness states;
- responsive layouts and any internal reviewer access flow included in the approved scope.

### B. Manual and assistive-technology checks

1. Keyboard-only operation: logical tab order, visible focus, no keyboard traps, skip/navigation mechanisms and operability of all controls.
2. Screen-reader semantics: page title, landmarks, headings, labels, form instructions, accessible names, status/error announcements, table/list semantics and meaningful link text.
3. Focus behavior: focus order, focus visibility, focus not obscured, modal/dialog behavior if present and focus restoration after state changes.
4. Contrast and non-colour cues: text, controls, focus indicators, status and error states; information must not rely on colour alone.
5. Reflow/zoom/text resizing: narrow viewport, 200% text resizing and 400% zoom/reflow scenarios where applicable without loss of content/functionality.
6. Pointer/touch targets: target size/spacing and alternatives to dragging or complex gestures where applicable.
7. Forms and search: persistent labels, clear instructions, error identification/suggestions, required-field semantics and understandable result feedback.
8. Content and language: page language metadata, meaningful reading order, abbreviations, link purpose, consistent navigation and plain-language error/empty states.
9. Motion/animation: respect reduced-motion preferences and avoid flashing content if any motion exists.
10. Responsive and cross-browser coverage: record actual browsers, operating systems, viewport sizes and assistive technologies tested.

### C. Automated checks

Automated accessibility tooling may be used to find likely issues, but results must be manually validated. Automated scans alone cannot establish WCAG conformance. Record tool/version, pages/states scanned, exclusions, false positives and manual follow-up. Do not add a paid tool or dependency without separate owner approval.

### D. Accessibility findings and retest

For each issue, record the affected WCAG criterion/version/level, page/component/state, user impact, reproducible steps, assistive technology/browser context, severity, remediation owner, due date, retest evidence and any residual limitation. Distinguish a confirmed failure from an unverified potential issue.

The reviewer must state the exact conformance claim, if any, and its limits. Avoid blanket claims such as “fully accessible” without a scoped, evidence-backed conformance statement.

## 6. Evidence bundle and candidate pinning

The following is the minimum repository-side evidence to stage for independent review:

- M3-11-01 scope/authority closeout and Option A charter.
- M3-11-02 legal/privacy/safeguarding pack and status, plus qualified reviewer findings when received.
- M3-11 preflight and residual gate resolution plan.
- M3-08 identity/reviews/security preflight.
- M3-08A/B identity/session/scoped authorization implementation record.
- M3-08C/D synthetic moderation/appeals and privacy/security implementation record.
- M3-07 I7 full regression/hardening implementation record.
- RCV-01 requirements-to-capability reconciliation and relevant M3-05/M3-06 implementation records.
- Exact candidate commit and build/artifact hash, Composer lock hash, route/middleware inventory, schema/migration inventory, dependency/advisory output, configuration inventory with secrets removed, relevant tests and CI run links.
- Environment topology, isolation evidence, access roster and test authorization, but only after M3-11-05 is separately authorized and those facts actually exist.
- Accessibility page/state inventory, test matrix, browser/assistive-technology combinations and any prior accessibility issue log.

Do not provide credentials, tokens, personal data, raw production dumps, private keys or confidential incident material in repository history. Share sensitive evidence through a separately approved secure channel controlled by the owner. If evidence is missing, record it as a limitation/blocker rather than infer a pass.

## 7. Safe assessment protocol

1. The Product Owner identifies independent reviewers and confirms scope, confidentiality, independence and permitted evidence access.
2. The candidate is pinned by commit and artifact hashes; its route/configuration/data inventory is produced.
3. Before any active test, M3-11-05 must separately authorize the isolated private V2 target and provide independently reviewed proof that V1/shared resources cannot be affected.
4. The owner and environment operator approve a written test plan naming exact target, allowed test types, intensity/rate limits, time window, stop contacts, backup/restore posture and rollback/abort procedure.
5. Reviewers test only synthetic fixtures in the explicitly approved private target. No real data, public users, production systems or third-party targets.
6. Findings are submitted through the response template. Remediation is performed only within a separately authorized code scope; reviewers retest the exact changed candidate.
7. The Product Owner records the disposition and residual risk. No access, release or go/no-go is inferred from a reviewer report alone.

No active security testing, scanning against a hosted target, environment provisioning or reviewer access is authorized by this document.

## 8. Exit criteria for M3-11-03

M3-11-03 may be closed only when all applicable items are evidenced:

- Independent security reviewer(s) with recorded competence, independence and scope have assessed the exact pinned candidate and relevant authorized environment context.
- Independent accessibility reviewer(s) with recorded competence and scope have evaluated all included page templates/states against the declared baseline.
- Reports identify methods, tools, coverage, assumptions, limitations, exact candidate and explicit outcomes.
- Every critical/high finding is remediated and independently retested, or remains a hard blocker. Medium/low findings have accountable dispositions and due dates.
- Accessibility failures are remediated and retested or have a documented, accountable residual-risk decision that does not misrepresent conformance.
- Security/privacy/safeguarding overlaps are reconciled with M3-11-02 findings; no unresolved conflict is silently accepted.
- Product Owner has recorded a dated decision and any remaining prohibitions.

**Current exit status: NOT MET — M3-11-03 remains BLOCKED.**

## 9. Stop conditions

Stop if the proposed assessment requires V1, Hostinger/hPanel, production/live database, real/personal data, participants, public launch, public UGC, third-party targets, external APIs/AI, new vendors/dependencies/spend, deployment, migration or URL cutover. Seek separate explicit authorization before any scope change.

Do not create or access the private acceptance environment under this pack. M3-11-05 remains separately gated. Deeni Madaris remains default-OFF with zero public exposure; public UGC/reviews/ratings/reporting/moderation remain disabled.

## 10. Final disposition

**M3-11-03 preparation:** COMPLETE for repository-only documentation.  
**Independent security assessment:** NOT PERFORMED.  
**Independent accessibility assessment:** NOT PERFORMED.  
**M3-11-03 gate:** BLOCKED pending qualified independent reports, remediation/retest and owner disposition.  
**M3-11 overall:** BLOCKED / NOT ACCEPTED.  
**Environment provisioning/access, production action and release:** NOT AUTHORIZED.


## 9. Two-stage assessment protocol — effective 2026-11-17

This section applies the [M3-11 Reviewer Scope and Sequencing Alignment](M3-11_REVIEWER_SCOPE_AND_SEQUENCING_ALIGNMENT_2026-11-17.md) to this security/accessibility pack. It clarifies sequencing and does not relax reviewer independence, scope boundaries, environment authorization, active-test restrictions or M3-11-03 exit criteria.

### Stage 1 — preliminary repository/source and design review

Stage 1 may be conducted against an exact pinned repository source commit before environment provisioning or candidate creation. It is limited to evidence available in the repository and documented design:

- Security: threat model and trust boundaries; route/middleware/controller/service/policy inventory; authentication/session and scoped-authorization source; public projection/allowlist/suppression logic; dependency manifests/lockfiles; configuration examples with no secrets; storage/file/outbound-network code paths; logging/audit design; relevant synthetic tests and CI outputs.
- Accessibility: server-rendered templates/markup; semantic structure, headings, landmarks, labels, link names, form/error/status patterns, keyboard affordances visible in source, focus-related implementation and responsive/design evidence available in the repository.
- Both: record exact commit, paths, versions, inspection method, coverage, assumptions, limitations and evidence references. Separate confirmed source findings from questions requiring runtime/browser/assistive-technology evidence.

Stage 1 security review is not active penetration testing, dynamic scanning, hosted-target testing, runtime configuration verification or a complete security certification. Stage 1 accessibility review is not browser/assistive-technology testing, actual keyboard operation, screen-reader evaluation, user testing or WCAG 2.2 AA conformance. No live or hosted target is authorized.

The Stage 1 report must identify candidate/environment-dependent checks that remain **UNKNOWN / DEFERRED TO STAGE 2**, required test plans and pre-provisioning blockers. It may recommend controls and conditions but cannot certify the environment or close M3-11-03.

### Stage 2 — exact candidate and approved environment verification

Stage 2 requires separately completed human-role prerequisites, M3-11-05 environment authorization and independent isolation evidence, M3-11-06 authorized synthetic-only recovery rehearsal, and M3-11-07 separate candidate-creation authorization. Pin the exact candidate commit/artifact and verified target.

Security active testing is permitted only under a separate written test plan that identifies the exact V2-only target, allowed methods, intensity/rate limits, time window, stop contacts and abort/rollback controls. No production, V1, shared infrastructure or third-party target testing is permitted.

Accessibility evaluation must cover the exact candidate's included page templates and states using recorded browsers, operating systems, viewports and assistive technologies. Record manual keyboard and screen-reader checks, any automated tools and versions, sampling, exclusions, findings and retests. Any conformance statement must be limited to the exact tested candidate, scope, standard/version/level and evidence.

Stage 2 findings must be tied to the exact candidate and authorized target. Remediation requires separately authorized implementation scope; reviewers must retest the corrected candidate. The Product Owner must record a dated disposition of all findings.

### Evidence and gate rule

Use separate Stage 1 and Stage 2 reports or separately dated, attributable sections. Stage 1 must not invent candidate IDs, artifact hashes, environment identifiers, runtime results or browser/assistive-technology observations. Stage 2 evidence must not be backdated or represented as Stage 1 evidence.

M3-11-03 remains BLOCKED until both applicable stages, required remediation/retests and Product Owner disposition meet the existing exit criteria. This clarification authorizes no environment provisioning, reviewer access, active testing, hosted scanning, production access, participant activity, new dependency/service/spend or release.

