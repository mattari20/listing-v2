# M3-11 — Reviewer Scope and Sequencing Alignment

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Status:** DOCUMENTATION-ONLY CLARIFICATION — OWNER-AUTHORIZED  
**Applies to:** M3-11-02, M3-11-03, M3-11-05, M3-11-06, M3-11-07 and M3-11-08  
**Overall M3-11 status:** BLOCKED / NOT ACCEPTED

## 1. Purpose

This clarification resolves a sequencing ambiguity in the existing reviewer packs and gate-resolution plan: preliminary review can begin against a pinned repository source commit before a release candidate or private environment exists, while final candidate-specific and environment-specific verification necessarily occurs later.

The distinction prevents two opposite errors:
- blocking all useful independent review until a candidate exists, even though candidate creation itself depends on earlier gates; and
- treating a preliminary source/document review as final candidate assurance, hosted penetration testing, accessibility conformance or approval to proceed.

This document defines a two-stage evidence model. It changes no product requirements, scope, release target or gate acceptance criteria. It does not appoint reviewers or authorize any operational activity.

## 2. Binding scope and restrictions

The review target remains the owner-selected Option A / Option 1 bounded private V2-only acceptance scope: the existing anonymous directory browse/search/category/profile experience and manual text-locality discovery only.

All existing exclusions remain binding:
- Synthetic/fictional fixtures only; no real student, guardian, staff, provider, institution, source or production data.
- No participant research, recruitment, interviews, surveys, usability sessions or pilot activity. M3-10 pilot readiness remains NOT ACCEPTED and its research deferral remains binding.
- No V1 repository/application, Hostinger/hPanel, production/live database, shared production infrastructure, DNS, deployment, migration, URL cutover or public launch.
- No environment provisioning or access unless separately authorized under M3-11-05.
- No backup, snapshot, restore or rollback rehearsal unless separately authorized under M3-11-06.
- No external API, connector, AI/model service, new dependency, vendor, procurement or unapproved spend.
- No public UGC, reviews, ratings, reporting or moderation activation.
- Deeni Madaris remains default-OFF with zero public exposure.

Passing CI, a merged review pack, a reviewer nomination or this clarification is not a gate pass.

## 3. Stage 1 — preliminary source and design review (before candidate/environment)

### 3.1 Permitted review basis

A qualified reviewer may be given the existing repository documentation and a pinned source commit from the V2 repository for a bounded desk/source review. The review record must identify:
- exact repository and commit SHA;
- exact documents, code areas, routes or templates actually examined;
- review method, tools and sampling;
- reviewer qualification, relevant specialism/jurisdiction and independence/conflict declaration;
- evidence unavailable, assumptions and limitations;
- findings, severity, remediation owner and retest expectations.

No environment, runtime, database, secret, credential, production record or live service access is implied.

### 3.2 M3-11-02 legal/privacy/safeguarding preliminary work

Qualified reviewers may assess the defined product scope, intended processing, documented data flows, proposed privacy/safeguarding controls, jurisdictional questions, research deferral and unresolved assumptions using available design and repository evidence.

They must explicitly mark environment-dependent questions as **unknown / deferred**, including actual hosting region, controller/operator and processor identities where not established, runtime logs/telemetry, cookies, backups, retention/deletion behavior and deployed configuration.

The Stage 1 output is a preliminary written applicability/design assessment. It may identify non-waivable blockers and requirements that must be met before provisioning or access. It is not a final legal opinion on unknown facts, a DPIA/PIA completion claim, a child-safeguarding certification or approval to process data.

### 3.3 M3-11-03 security preliminary work

An independent security reviewer may perform a bounded repository/source-code and architecture review against the pinned commit: threat model, trust boundaries, route/middleware inventory, authentication/authorization implementation, dependency and configuration evidence available in the repository, data exposure boundaries and synthetic test coverage.

This is not an active penetration test, hosted scan, runtime configuration assessment, environment-isolation verification or complete security certification. No live target is authorized.

The Stage 1 security report must separate confirmed source findings from environment-dependent questions and identify the exact evidence needed for Stage 2.

### 3.4 M3-11-03 accessibility preliminary work

A qualified accessibility reviewer may inspect available templates, markup, semantics, labels, keyboard-related implementation and design evidence at the pinned source commit.

This is a preliminary source/markup review only. It cannot establish actual browser behavior, screen-reader usability, complete WCAG 2.2 AA conformance or human usability. The report must identify page/state coverage that requires Stage 2 browser and assistive-technology evaluation.

### 3.5 Stage 1 disposition

Stage 1 reports may close only the preliminary review substage. The Product Owner must record a dated disposition of each finding and all prerequisites for later work.

M3-11-02 and M3-11-03 remain **BLOCKED / INCOMPLETE** until their required Stage 2 supplements, retests and final Product Owner dispositions are complete. Stage 1 cannot be represented as a full gate pass.

## 4. Intervening gates — environment and recovery

After the preliminary reviews identify requirements, the remaining prerequisites proceed independently and in order:

1. M3-11-04: obtain real named human role holders, written acceptance, competence/authority evidence, availability, deputies, escalation and separation-of-duties coverage.
2. M3-11-05: obtain a separate exact-scope Product Owner authorization before any V2-only environment provisioning/access. Record the target/resource inventory, isolation design and all required positive and negative isolation evidence. An independent verifier must confirm the V2 boundary. No V1, Hostinger, production or shared-resource access is permitted.
3. M3-11-06: only after environment isolation is accepted, obtain a separate rehearsal authorization. Set and approve RPO/RTO first. Any rehearsal must be synthetic-only, V2-only, time-bounded and independently verified.

A reviewer may examine proposed architecture or plans before these gates, but must not claim the environment exists or is isolated until evidence proves it.

## 5. Stage 2 — exact candidate and authorized environment verification

Stage 2 occurs only after the prerequisites for candidate creation and environment access have been satisfied and the Product Owner has separately authorized the exact activities.

### 5.1 Candidate pinning

M3-11-07 candidate creation requires its own explicit authorization after the applicable preliminary review findings, M3-11-04 human coverage, M3-11-05 isolation and M3-11-06 recovery prerequisites have been accepted. Pin the exact source SHA, artifact/build identity, dependency lock hashes, configuration inventory (secrets removed), route/schema inventories and evidence references.

Candidate creation is not candidate acceptance.

### 5.2 Security verification

The independent security reviewer performs the approved, narrowly scoped candidate-specific verification. Active testing against an environment is permitted only if M3-11-05 is accepted and a separate written test plan authorizes the exact V2-only target, methods, intensity/rate limits, time window, stop contacts and abort/rollback controls.

No production scanning, third-party target testing, real data or unapproved network activity is permitted. Findings must be tied to the exact candidate and target, remediated under separately authorized implementation scope, and retested against the corrected candidate.

### 5.3 Accessibility verification

The qualified accessibility reviewer evaluates the exact candidate's included pages, templates and interaction states in an approved test context. The reviewer records actual browsers, operating systems, viewports, assistive technologies, manual keyboard and screen-reader checks, automated tool/version where used, sampling, exclusions, findings and retests.

Any conformance statement must be limited to the exact candidate, tested scope, standard/version/level and evidence. Automated scans or source inspection alone do not establish WCAG conformance. No participant usability study is authorized.

### 5.4 Legal/privacy/safeguarding final supplement

Qualified reviewers revisit environment- and candidate-dependent questions using verified facts now available: operator/controller/processor roles, hosting/data location, runtime configuration, cookies/sessions, logs/telemetry, access roster, backups, retention/deletion, incident handling and exact data flows.

The final report must identify facts still unknown and whether those unknowns block the intended private acceptance activity. No reviewer may infer that synthetic-only fixtures eliminate all personal-data risk from logs, identifiers or operational metadata.

### 5.5 Final gate disposition

M3-11-02 and M3-11-03 can be considered complete only after:
- required Stage 1 and Stage 2 reports are present and attributable to qualified, independent reviewers as applicable;
- exact candidate/target scope and evidence are identified;
- all blocking findings are remediated and independently retested, or remain explicit stop conditions;
- residual risks, limitations and non-waivable blockers are recorded;
- the Product Owner records a dated, scope-specific disposition.

Only then may the complete M3-11-08 decision dossier be assembled. A GO/NO-GO decision remains separate and does not itself authorize M3-11-09 execution.

## 6. Dependency sequence (clarified)

1. Identify/appoint qualified reviewers and accountable human role holders; obtain written acceptance and independence/competence evidence.
2. Conduct Stage 1 preliminary M3-11-02 and M3-11-03 source/design reviews; record findings and pre-provisioning conditions.
3. Complete M3-11-04 human role acceptance and coverage.
4. Obtain separate M3-11-05 authorization; provision only the specifically approved V2-only environment and independently verify isolation.
5. Obtain separate M3-11-06 authorization; approve RPO/RTO and complete the synthetic-only V2 recovery rehearsal with independent verification.
6. Reconcile M3-10 pilot/readiness disposition and all applicable pre-candidate gates. M3-10 remains separate; no pilot or participant activity is implied.
7. Obtain separate M3-11-07 candidate-creation authorization; create and pin the candidate.
8. Complete Stage 2 candidate/environment-specific M3-11-02 and M3-11-03 assessments, remediation and retests. If a blocker remains, stop; do not proceed to a release decision.
9. Assemble the exact-candidate M3-11-08 dossier and obtain a separate Product Owner GO/NO-GO/NOT DECIDED decision.
10. M3-11-09 remains NOT AUTHORIZED unless a separate exact-scope execution authorization is issued. M3-11-10 cannot begin until a validly authorized operation exists.

This staged model resolves the dependency loop without weakening any gate: preliminary review is a prerequisite; final candidate verification is a later prerequisite to the decision dossier.

## 7. Evidence records and privacy

Use the existing M3-11-02 and M3-11-03 response templates, adding an explicit **Stage 1 preliminary** or **Stage 2 candidate/environment** designation to each report. Maintain separate report versions/addenda where facts materially change.

Record only non-sensitive evidence identifiers in this repository. Keep confidential legal advice, personal contact details, credentials, secrets, raw personal data and security-sensitive exploit details in an approved restricted store. Never commit such material to public repository history or ordinary chat.

A change to source commit, artifact, configuration, environment, data, audience, jurisdiction or scope may invalidate part or all of a prior assessment and require review again.

## 8. Current status and stop conditions

This clarification is a process/documentation update only. It does not perform Stage 1 or Stage 2 reviews, appoint reviewers, create an environment, run tests, create a candidate, accept any gate or authorize release.

Current M3-11 disposition remains:
- M3-11-02: BLOCKED — review packs prepared; no qualified assessment evidenced.
- M3-11-03: BLOCKED — review packs prepared; no independent assessment evidenced.
- M3-11-04: BLOCKED — human roles unassigned/unaccepted.
- M3-11-05: BLOCKED — no approved or verified environment.
- M3-11-06: BLOCKED — no authorized rehearsal; RPO/RTO unset/unmeasured.
- M3-11-07: NOT STARTED / BLOCKED — no candidate.
- M3-11-08: BLOCKED / NOT DECIDED.
- M3-11-09: NOT AUTHORIZED.
- M3-11-10: NOT STARTED.
- M3-11 overall: **BLOCKED / NOT ACCEPTED**.

Stop and escalate to the Product Owner if a proposed review or activity requires real/personal/source data, participants, public pilot, V1/production/Hostinger/live database, unapproved environment access, backup/restore, external APIs/AI/vendors/dependencies, new spend, public UGC/moderation, Deeni Madaris exposure or scope expansion.

**No standing restriction is relaxed. No operational or production authority is created by this clarification.**
