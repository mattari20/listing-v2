# M3-11-02 — Legal, Privacy and Safeguarding Review Pack

**Prepared:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Package:** M3-11-02 — Legal, privacy and safeguarding  
**Status:** **REVIEW PACK PREPARED — QUALIFIED HUMAN REVIEW NOT PERFORMED; GATE BLOCKED**  
**Decision owner:** Product Owner  
**Target:** Option A / Option 1 — public GitHub source repository during development; separate restricted/private V2-only acceptance environment target, not provisioned

## 1. Purpose and limits

This pack organizes the evidence and questions for qualified human legal, privacy and safeguarding reviewers. It is not legal advice, a privacy impact assessment, a child-safeguarding certification, a research-ethics determination, a regulatory opinion or an approval to process data.

No reviewer has been appointed or has returned findings in this record. Do not mark M3-11-02 complete until the applicable qualified reviewers have supplied dated written assessments, remediation conditions have owners, and the Product Owner has recorded a disposition. A blank template or repository CI result is not a review.

The review concerns the exact bounded development and restricted-acceptance scope recorded in [M3-11-01 Scope and Authority Closeout](M3-11-01_SCOPE_AND_AUTHORITY_CLOSEOUT_2026-11-17.md) and the [Option A scope charter](M3-11_OPTION_A_CONTROLLED_LIMITED_V2_RELEASE_SCOPE_CHARTER_2026-11-17.md). Reviewers must identify the exact documents, source commit and assumptions they reviewed.

## 2. Binding scope presented to reviewers

- Product scope: existing M3-05 anonymous directory/search/category/profile and M3-06 manual text-locality discovery only; no new feature or behavior is proposed by this pack.
- Acceptance type: private V2-only acceptance environment. The host, path, runtime, database, credentials, secrets, isolation evidence and access roster are unspecified and unprovisioned.
- Audience: no public audience, students, guardians, research participants or recruited users. Any future access requires named internal reviewers/operators, accepted roles and separate environment/security authorization.
- Data for the acceptance activity: synthetic/fictional fixtures only. No real institution, provider, student, guardian, staff, source or production records; no personal data or external source acquisition.
- Geography: Pakistan-first manual text locality using supported province/district/city/locality facts where present; no claim of nationwide coverage or authoritative boundaries.
- Research/pilot: student research, interviews, surveys, recruitment, participant activity and the M3-10 pilot remain deferred/not accepted.
- Exclusions: admissions/applications, eligibility, deadlines, fees, scholarships, payments, accounts-dependent discovery, saved items/comparison/alerts, ranking/recommendations/advertising, fuzzy/transliteration search, coordinates/maps/geolocation/geocoding, live source ingestion, external APIs/connectors/AI, public reviews/ratings/UGC/reporting/moderation, and public Deeni Madaris exposure.
- Deeni Madaris remains default-OFF with zero public exposure.
- No V1 access/change, Hostinger/hPanel or production/live database access, environment provisioning, migration, deployment, DNS/URL cutover, public pilot or launch is authorized.

If the reviewer believes the actual repository behavior or proposed processing exceeds this boundary, record the discrepancy as a blocking finding. Do not silently expand the review scope.

## 3. System and data-flow description to validate

The following is a scope-level description based on project records. It is not a substitute for inspecting the exact candidate and its implementation.

### 3.1 Current private acceptance activity

1. Engineering prepares synthetic/fictional fixture records in an isolated, separately authorized V2 acceptance environment. That environment does not yet exist in the evidence available to this pack.
2. Named internal reviewers/operators may access the environment only after M3-11-04 role acceptance and M3-11-05 environment/isolation authorization and evidence.
3. Reviewers exercise only the existing anonymous directory/search/category/profile and manual text-locality experience.
4. Results are inspected for expected public-field allowlisting, publication/suppression behavior and unknown/freshness states.
5. Findings are recorded in controlled review records. This pack does not authorize collecting user submissions, participant feedback, identity documents or real institution data.

### 3.2 Product data and publication path to validate

The established V2 governance model uses source/evidence provenance, source authorization, adjudication/publication controls, current-version/supersession handling and a restricted anonymous-directory projection. Public-facing discovery is intended to read only eligible published projections and allowlisted scalar facts, not raw evidence or internal notes. Reviewers must verify the exact implementation and determine whether any personal data, confidential data, third-party rights or re-identification risk can enter those paths.

### 3.3 Identity, logs and operational data to inspect

V2 has first-party session identity and scoped authorization foundations for pre-provisioned accounts. This pack does not assert that any reviewer account exists or that an acceptance environment is configured. Reviewers should inspect, in the exact candidate and configuration, account identifiers, session/cookie attributes, authentication events, authorization/audit metadata, application/server logs, error traces, backups, telemetry and support/incident records. Confirm which are present, their fields, access, storage locations, retention and deletion behavior. Do not assume logs are free of personal data.

### 3.4 Moderation and user-generated content boundary

Synthetic moderation/appeals metadata foundations exist for local/CI verification, but public review, rating, report-intake, UGC and moderation activation remain disabled. Reviewers should confirm that no public route, UI, notification, ingestion or data collection path has been enabled. No public UGC activity is authorized.

## 4. Review workstreams and questions

### A. Legal applicability and organizational roles

1. Identify the laws, regulations, regulator guidance and contractual duties actually applicable to the operator, hosting location, data subjects, intended audience and processing locations. State the assumptions and sources used; do not infer applicability solely from the Pakistan-first geography label.
2. Identify the accountable organization/person acting as controller or equivalent decision-maker, and any processor, subprocessor, hosting, analytics, email, support or other recipient roles. If these are not yet identifiable, record the missing facts and block the affected processing.
3. Assess terms of use, notices, source/publication rights, copyright/database rights, licenses, attribution, correction/withdrawal and permitted reuse for any eventual non-synthetic content. The current acceptance fixtures remain synthetic-only.
4. Identify cross-border transfer, localization, government-access, retention, breach-notification and recordkeeping obligations, if any, based on verified hosting and processing facts. Those facts are currently unspecified.
5. State which conclusions cannot be reached until the hosting provider, region, environment architecture, operator identity or data classes are pinned.

### B. Privacy and data protection

1. Produce or validate a data inventory and end-to-end flow map for account/session data, reviewer access, audit events, logs, error traces, backups, support records, source/evidence records and public directory projections.
2. For each data element, state purpose, necessity, lawful basis/authority where applicable, source, subject, recipients, storage location, access roles, retention period, deletion mechanism and evidence of deletion.
3. Determine whether any personal, sensitive, children's, education, location, inferred or otherwise protected data is collected or exposed. Confirm that the private acceptance fixtures contain no real personal data.
4. Review data minimization, purpose limitation, accuracy, provenance, transparency, correction, access, deletion, objection/complaint handling and rights-request workflow as applicable.
5. Review cookie/session behavior, identifiers, analytics, telemetry, IP addresses, user-agent data and security logs. Confirm whether third-party scripts, pixels, remote fonts, external assets or embedded services are present in the pinned candidate.
6. Assess backup copies, exports, caches, logs and derived data for retention/deletion propagation and restricted access.
7. Determine whether a DPIA/PIA or other formal assessment is required and define its scope and approval authority.
8. Define incident/breach triage, notification decision ownership, timelines and evidence preservation requirements.
9. Assess whether any real-world data publication could expose sensitive institution/person associations, confidential source information or small-group re-identification.

### C. Children, minors and safeguarding

1. Determine whether the intended public product, private acceptance activity or foreseeable use is directed to, likely to be accessed by, or likely to process data about children/minors. Distinguish the public product's eventual audience from the current internal-only acceptance audience.
2. Identify applicable age definitions, child-specific privacy obligations, parental/guardian involvement requirements and limits on consent as a legal basis, based on qualified jurisdictional analysis.
3. Assess whether the current product collects or infers age, student status, enrollment, school attendance, guardian identity/contact, precise location or other child-related data. Confirm absence/presence in the exact candidate rather than relying only on this scope statement.
4. Review risks of contact, grooming, impersonation, harassment, exposure of school/location associations, profiling, targeted advertising and unsafe direct communication. Identify controls required before any child-facing or public access.
5. Determine whether a child-safeguarding policy, designated safeguarding lead, reporting channel, escalation protocol, staff training, vetting or referral pathway is legally or operationally required for any later release.
6. Confirm that no child, student, guardian or participant is to be recruited, contacted, interviewed, surveyed or asked to test this private acceptance activity.
7. Review Deeni Madaris default-OFF/zero-public-exposure requirements and any heightened risk of sensitive religious affiliation inference; no such public exposure or inference is authorized.

### D. Research, participation and ethics

1. Confirm that no human-subject research, usability study, interview, survey, recruitment, observation of real users or participant activity is included in Option 1.
2. Determine whether any proposed future evaluation would constitute research, service evaluation or another regulated activity, and what ethics/consent approvals would be required before it begins.
3. Record that M3-10 pilot readiness remains NOT ACCEPTED and that this pack does not reopen or authorize it.

### E. Conditions, residual risk and approval

1. Separate legal requirements, recommended practice, unresolved assumptions and product-owner choices.
2. Rate each finding, identify affected scope, required remediation, evidence for closure, accountable owner and whether private acceptance may proceed before closure.
3. Identify non-waivable blockers and any residual risk requiring explicit accountable acceptance.
4. State whether the reviewer is qualified and independent for the workstream, the jurisdiction/specialism covered, limitations, conflicts and date of review.
5. Provide an explicit outcome: approve with conditions, not approve, or unable to conclude. Avoid an ambiguous general statement of compliance.

## 5. Minimum reviewer evidence bundle

Before substantive review, provide the reviewer with the pinned versions of:

- M3-11-01 scope/authority closeout and Option A charter.
- M3-11-02 review pack and blank response template.
- M3-11 preflight and residual gate resolution plan.
- M3-10 final readiness gate reconciliation and external-review intake procedure.
- M3-05 directory/search work plan and implementation record.
- M3-06 locality work plan and implementation record.
- M3-08 identity/reviews/security preflight and identity/authorization implementation record.
- M3-08C/D synthetic moderation/privacy-security implementation record.
- RCV-01 requirements-to-capability reconciliation.
- Exact candidate commit, configuration inventory, route inventory, data dictionary/schema inventory, relevant tests and environment/data-flow evidence, once separately authorized and available.

If an artifact is unavailable or the candidate is not pinned, record that limitation. Do not represent a document inventory as a live system audit.

## 6. Reviewer response and owner decision

Use [M3-11-02 Reviewer Response and Disposition Template](M3-11-02_REVIEWER_RESPONSE_TEMPLATE_2026-11-17.md) for each distinct review workstream or reviewer. Attach or link the reviewer's signed report through an approved repository process; do not place secrets, personal data, confidential legal advice or sensitive incident details in public repository history.

The Product Owner must record, for every finding:
- accepted / rejected with reason / deferred with explicit prohibition;
- remediation owner and due date;
- evidence required to close;
- residual risk and approving authority;
- whether the finding blocks any later private acceptance activity.

No reviewer response or owner disposition is currently recorded.

## 7. Exit criteria for M3-11-02

M3-11-02 may be considered complete only when all applicable criteria are met:

- Qualified human legal/privacy reviewer(s) have supplied dated written assessments for the exact bounded scope and identified jurisdictions/roles.
- Qualified child-safeguarding reviewer has supplied a written applicability/risk determination and required controls, or a reasoned determination that a specialist review is not applicable, accepted by the accountable owner.
- Research/participant status is explicitly confirmed as excluded for Option 1; any future research remains separately gated.
- Data-flow, data inventory, retention/deletion, cookies/logging, rights request and incident/breach obligations have been reviewed against the pinned candidate and actual environment facts available to reviewers.
- Every blocker has an owner, remediation evidence and a documented closure or explicit non-waivable prohibition.
- Product Owner has recorded a dated disposition without claiming that ChatGPT or CI supplied professional certification.

**Current exit status: NOT MET — M3-11-02 remains BLOCKED.**

## 8. Stop conditions

Stop and return for a new explicit owner decision if the review proposes or discovers any need for real student/provider/institution/source data, participant activity, public pilot, public UGC/reviews/moderation, external APIs/AI, new vendor/spend, V1 or Hostinger/production access, environment provisioning, deployment, migration or URL cutover. This pack authorizes none of those activities.

Deeni Madaris remains default-OFF with zero public exposure. No private acceptance environment may be provisioned or accessed under this pack; M3-11-05 remains separately gated.


## 9. Product Owner internal review and repository visibility reconciliation — 2026-11-20

The Product Owner has completed the internal ten-question review exercise and accepted Decisions 1–3. The consolidated owner dispositions are recorded in [M3-11-02 Product Owner Internal Data and Privacy Review](M3-11-02_OWNER_INTERNAL_DATA_PRIVACY_REVIEW_2026-11-18.md). Those decisions close the owner-answer exercise; they do not constitute an independent legal/privacy/safeguarding assessment, and they do not establish uninspected target-specific facts.

The source repository is PUBLIC during development and WILL be changed to PRIVATE when development is complete under the binding Product Owner decision recorded on 2026-11-20. This is distinct from the separate restricted/private V2 acceptance-environment target. The reviewer must assess the actual public-source-repository development facts, including public commit and CI artifact exposure, while preserving all existing restrictions on public application access, real data, source activity, hosted environment, participant activity and production.

**Current disposition:** owner internal decisions COMPLETE; this review pack remains prepared for any required qualified independent assessment; Gate 02 remains blocked pending the required assessment and Product Owner disposition. This status is not a request for the Product Owner to repeat already accepted decisions.

## 10. Additional Product Owner scope decision — 2026-11-21

The Product Owner has additionally accepted Option A for the current M3 scope: no real student, child or guardian personal data is collected or stored; synthetic/fictional data only. The decision is documented in [M3-11-02 Owner Decision — Child and Student Data Scope](M3-11-02_OWNER_DECISION_CHILD_STUDENT_DATA_SCOPE_2026-11-21.md).

This does not reopen the completed ten-question owner review, authorize real-data processing or participant activity, or establish that all developer/reviewer metadata is non-personal. The earlier owner review's recognition of potentially identifying GitHub, commit, CI and reviewer metadata remains applicable.

This scope decision is not an independent safeguarding applicability determination. A qualified child-safeguarding reviewer must still assess the eventual intended audience, foreseeable use, applicable child-specific obligations and controls. M3-11-02 remains BLOCKED pending the required qualified independent assessment and Product Owner disposition.


## 11. Product Owner Q2 intended-audience decision — 2026-11-21

The Product Owner selected **Option B: general student audience; minors may be among the intended users**. The decision is recorded in [M3-11-02 Owner Decision Q2 — General Student Audience](M3-11-02_OWNER_DECISION_Q2_GENERAL_STUDENT_AUDIENCE_2026-11-21.md).

This supersedes the earlier statement that children/minors are not an intended audience. The review scope must therefore assess the eventual general student audience, including foreseeable access by minors, rather than assuming an adult-only audience.

The current M3 activity remains restricted: synthetic/fictional fixtures only; no real student/child/guardian personal data; no child/student accounts, profiles, registration, messaging, direct contact, tracking or participant recruitment/contact/testing; no public access, pilot, hosted environment or release. Deeni Madaris remains default-OFF with zero public exposure. All no-production, no-V1/Hostinger, no-external-API/AI, no-new-spend and no-deployment restrictions remain in force.

The qualified independent reviewer must assess applicable age definitions and jurisdictional duties; foreseeable use and child-access risk; age-appropriate design; consent/guardian involvement where applicable; contact/grooming, harassment and location-association risks; reporting/escalation; operational roles/training; and objective controls required before any minor-facing access or participation. The reviewer must state evidence, assumptions, non-waivable blockers and an explicit outcome. No assumption is made that parental consent alone resolves all requirements.

**Gate effect:** Q2 closes the owner audience choice only. It is not an independent safeguarding determination or authorization to serve minors. M3-11-02 / Gate 02 remains BLOCKED pending qualified independent legal/privacy and child-safeguarding assessment and Product Owner disposition.


## 12. Superseding Product Owner Q2 audience decision — 2026-11-21

The Product Owner reversed the earlier Q2 Option B choice and selected **Option A: adult-only intended audience and access (18+)**. The superseding decision is recorded in [M3-11-02 Owner Decision Q2 — Adult-Only Audience and Access](M3-11-02_OWNER_DECISION_Q2_SUPERSEDING_ADULT_ONLY_AUDIENCE_2026-11-21.md). The earlier Option B decision is historical and superseded.

The current intended audience is adults aged 18 and over only. Minors are not permitted to visit, access, use or create accounts on Listing V2. The reviewer must assess the legal and safeguarding implications of this adult-only policy and the proportionate controls needed to enforce it. In particular, distinguish a policy prohibition from technical prevention: this decision does not prove that the current code blocks minors from opening a URL or making an unauthenticated request.

Before any user-facing access is proposed, assess a lawful, proportionate and privacy-preserving age-assurance approach, including necessity, data minimization, false declarations, circumvention, evidence retention and risk of collecting excessive identity information. Any age-assurance implementation or associated personal-data processing requires separate Product Owner approval and scope authorization. No public/user access, pilot or launch is authorized pending required review and evidence.

All current M3 restrictions remain: synthetic/fictional fixtures only; no real student/child/guardian data; no real account creation or participant activity; no hosted environment, V1/Hostinger/production access, external APIs/AI, new spend, deployment or release. Deeni Madaris remains default-OFF with zero public exposure. M3-11-02 / Gate 02 remains BLOCKED pending qualified independent assessment and Product Owner disposition.
