# Project Master Roadmap

All milestones are planned outcomes. Step-level scope and acceptance criteria are detailed in `MILESTONE_STEP_REGISTER.md`. Milestones may be refined through documented decisions; dependencies must not be bypassed.

| Milestone | Outcome | Status |
|---|---|---|
| M0 | Independent repository, documentation, governance and delivery controls | Accepted — PR #4 closeout |
| M1 | Student requirements, provider discovery, data rights and open-source research | **Accepted and Closed — M1-S01 through M1-S10 accepted; 100%; primary research deferred** |
| M2 | Architecture, domain model, technology evaluation, security and data design | **Accepted and Closed — 100%** |
| M3 | Mobilization, bounded V2 implementation, verification and controlled release governance | M3-00–M3-10 bounded planning/implementation/readiness work recorded; M3-12 repository verification A01–A09 closed; final M3 acceptance exercise F01–F06 active; M3-11 production readiness BLOCKED / NOT ACCEPTED pending qualified human gates, accepted operations, V2 isolation/recovery evidence and exact release approval |
| M4 | Institution, campus and programme management | Planned |
| M5 | Nearby discovery, search, filters and maps | Planned |
| M6 | Institution profiles and verified information presentation | Planned |
| M7 | Admissions, eligibility, fees and scholarships | Planned |
| M8 | Student shortlist and institution/programme comparison | Planned |
| M9 | Ratings, reviews, moderation and trust | Planned |
| M10 | AI data collection, reconciliation, verification and refresh | Planned |
| M11 | SEO, accessibility, performance and public experience hardening | Planned |
| M12 | Full acceptance, security/recovery readiness and controlled release planning | Planned |

## Owner-approved research timing\n- No student survey, interviews, participant recruitment or research outreach during construction.\n- Authenticated ratings and reviews are a post-launch product feature, not a pre-launch research survey.\n\n## Planning rules
- M1 research must inform M2 architecture.
- Do not select a technology stack or begin production application modules before M2 approval.
- Data connectors are not activated until rights and source review pass.
- Production release/cutover is a separate authorization gate, not an automatic consequence of M12 completion.
- Each milestone requires its own acceptance record and closeout.


## M1 closeout decision — 2026-11-12
M1 is formally accepted and closed as a research/documentation milestone. M2 remains Planned and requires separate explicit owner authorization; this closeout does not authorize implementation.


## M1 final closeout delivery evidence — 2026-11-12

PR [#83](https://github.com/mattari20/listing-v2/pull/83) recorded owner acceptance of S10 and M1 closure. Exact PR head `30d5c7ecfc929cd680c3da8d076774904ec2d67a` passed Project documentation validation (run [#43175799695](https://github.com/mattari20/listing-v2/actions/runs/43175799695)); merged as `af88a88693e66e9fb0a459d14ba1028e5fd3f97d`. M1 is Accepted and Closed. M2 remains Planned and requires separate explicit owner authorization.


## M2 authorization and active delivery — 2026-11-12

The owner authorized M2 architecture/design. The milestone is active and governed by `../05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md` and `../05-architecture/M2_STEP_PLAN.md`. M2-S00 is first; M2-S01 through S10 follow the documented dependencies and weights.

This authorization covers architecture research and documentation only. M3 implementation remains gated until M2 is complete and separately accepted. Production access, schema changes, source ingestion, connector activation, new spend and deployment require separate approval.


## M2 authorization and active delivery — 2026-11-12

The owner authorized M2 architecture/design. The milestone is active and governed by `../05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md` and `../05-architecture/M2_STEP_PLAN.md`. M2-S00 is first; M2-S01 through S10 follow the documented dependencies and weights.

This authorization covers architecture research and documentation only. M3 implementation remains gated until M2 is complete and separately accepted. Production access, schema changes, source ingestion, connector activation, new spend and deployment require separate approval.


## M2-S00 completion evidence — 2026-11-12

M2-S00 is complete at 100% task completion. PR [#85](https://github.com/mattari20/listing-v2/pull/85) merged as `17a2e3ad43ba1fd5ca3cb7a163670a2f19dd3783`; exact PR head passed required Project documentation validation (run [#43180488082](https://github.com/mattari20/listing-v2/actions/runs/43180488082)). M2-S01 — System Requirements and Architecture Boundaries — is the next eligible step.


## M3 roadmap — authoritative detailed sequence (2026-11-12)

The [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md) is the authoritative detailed sequence and supersedes the earlier high-level M3-M12 outline in this file where the two differ. The superseded outline is historical context, not a parallel active roadmap. M0, M1 and M2 are accepted and closed; M3-00 is the current documentation/planning step.

| Step | Name | Weight | Status |
|---|---|---:|---|
| M3-00 | Mobilization and Decision Closure | 5% | Accepted and closed; approved deferrals retained |
| M3-01 | Implementation Planning and Authorization | 7% | Closed as planning/authorization milestone; later steps separately gated |
| M3-02 | Platform Foundation | 10% | Accepted as Laravel platform foundation only |
| M3-03 | Core Data and Governance | 12% | Complete for bounded synthetic local/CI scope |
| M3-04 | Provider Management | 8% | P01–P04 complete for bounded synthetic local/CI scope |
| M3-05 | Public Directory and Search | 10% | Complete for bounded synthetic local/CI scope — PR #189 |
| M3-06 | Geography and Discovery | 7% | Complete for bounded synthetic local/CI scope — PR #192 |
| M3-07 | AI Data-Agent | 10% | I1-I8-A bounded synthetic/local/CI packages delivered, exact-head validated and merged; live source/model activation remains blocked by G2-G9 |
| M3-08 | Identity, Reviews and Security | 10% | A/B/C/D bounded synthetic/local/CI foundations delivered in PRs #232 and #234; independent release reviews remain open; reviews post-launch only |
| M3-09 | Quality and Operational Hardening | 8% | Complete for authorized synthetic-only local/CI scope; production/independent gates remain open |
| M3-10 | Pilot and Launch Readiness | 7% | Readiness framework and authorized synthetic/documentation work delivered; pilot readiness NOT ACCEPTED pending owner charter, qualified reviews and accepted human operations; no pilot/go-no-go |
| M3-11 | Controlled Production Launch | 6% | Conditional; separate production/launch approval |

Weights total 100%. They are planning allocations, not authorization to spend, access sources, use production, deploy or launch.

## M3-07 I5 closeout — 2026-11-16

I5-A through I5-C and the historical-definition regression are delivered and merged in PRs #213–#216. The final exact-head PHP 8.5 FND-01 suite passed 15 tests and 647 assertions; documentation validation passed on all four PR heads. See [M3-07 I5 Implementation Record](M3-07_I5_IMPLEMENTATION_RECORD.md).

I5 completion closes only the bounded synthetic/local/CI value correction, withdrawal/reinstatement and registry-aware public profile agenda. It does not complete or activate the live AI Data-Agent. Candidate sources remain RESEARCH ONLY; G2-G9 rights, privacy, security, model/provider and activation gates remain blocked. No source access, agent, model, connector, scheduler, production operation, deployment or spend is authorized.

**I6 scope/design preflight complete — 2026-11-16:** See [M3-07 I6 Synthetic Agent Proposal Adapter Preflight](M3-07_I6_SYNTHETIC_AGENT_PROPOSAL_ADAPTER_PREFLIGHT.md). The preflight was merged in PR #218. The Product Owner subsequently authorized the exact deterministic offline synthetic adapter scope.

**I6 implementation delivered — 2026-11-16:** [PR #220](https://github.com/mattari20/listing-v2/pull/220) implements one synthetic fixture, fixed server-owned agent identity with only `submit_agent_field_proposal`, a dedicated I3 field-aware path and a dedicated editorial submission path. It reuses exact-version validation and existing evidence/source-authorization/audit/outbox controls; the result remains a proposed claim with a submitted human-review case. Existing human-only review, adjudication, publication, correction, withdrawal, restoration and definition-governance controls remain unchanged. Five focused synthetic feature-test methods cover the bounded path. Exact-head FND-01 PHP 8.5 CI #43838997569 and Project documentation validation #43838997658 passed on PR head `6c09122c2223cc093393023019c3d9dc927fedf7`; test output was 15 passed, 688 assertions and 164 warnings including the existing missing-local-`.env` harness warnings. See [I6 Implementation Record](M3-07_I6_IMPLEMENTATION_RECORD.md).

No migration, schema change, backfill, dependency, Composer change, route/UI, real/source data, model/provider, external API, connector, scheduler, production operation, deployment or spend occurred. **I6 implementation is delivered, exact-head validated and merged in PR #220 as `8acf05082187f854597aa6dd2d852d64e01e5581`. I7's test-only implementation is now delivered and merged in PRs #224–#225.** G2-G9 continue to block live source access and live agent activation.


## M3-07 I7 — Full Regression and Hardening preflight (2026-11-16)

D5's canonical staged plan defines I7 as a test-only suite for adversarial, concurrency, migration, rollback, privacy, performance and regression coverage. This is not a new search/profile scope; I5 already delivered registry-aware public profiles/projection integration.

Preflight completed from verified main 1b4b58442807336bcf9905722b2a59a7a36606c1. Reviewed 19 test source files, 11 migrations and the existing PHP 8.5/SQLite in-memory and documentation CI workflows. The I7 preflight maps existing I1-I6 coverage and identifies hardening opportunities in adversarial payload/redaction, multi-connection contention evidence, complete disposable-SQLite migration rollback/reinstall, cross-phase no-side-effect checks and deterministic query-count baselines.

See [I7 Full Regression and Hardening Preflight](M3-07_I7_FULL_REGRESSION_HARDENING_PREFLIGHT.md). The implementation boundary is test and documentation files only. Any application/schema/migration defect discovered by tests must be separately authorized before correction. **I7 preflight is complete and merged in PR #222 as `beaf5598fcfb21320023ae063c6b1d1a6e03a290`; exact-head FND-01 CI #43844490560 and documentation validation #43844490593 passed. Test implementation was not yet authorized at preflight close.** This is the historical preflight-time status and is superseded by the I7 implementation closeout section below. G2-G9 continue to block live source access and live model/agent activation.


## M3-07 I7 — Full Regression and Hardening implementation closeout (2026-11-16)

I7's separately authorized synthetic-only test implementation is delivered and merged:

- PR [#224](https://github.com/mattari20/listing-v2/pull/224), exact head `cd4a21c790b933f99567a6760260d914c4a09983`, merge `6efd9a4d29067c3e0dea11ada8ae01266f2d33b2`; FND-01 CI #43850465461 and documentation validation #43850465611 passed.
- PR [#225](https://github.com/mattari20/listing-v2/pull/225), exact head `a31a78141b93bc5da2545ff49991d166f56c5f50`, merge/latest main `167ec4cad05926569bebda6aadac207166782235`; FND-01 CI #43850848377 and documentation validation #43850848331 passed.
- Final test suite: 15 passed, 761 assertions, 168 missing-local-`.env` harness warnings.
- All 11 migrations passed fresh-install, full rollback and reinstall on a disposable SQLite file; foreign-key checks passed.
- Independent SQLite connections passed idempotency uniqueness and deterministic writer-lock contention checks.
- Public-surface adversarial, agent proposal-only, privacy/Deeni default-OFF and deterministic query-count tests passed.

Only test files and the I7 implementation record changed. No application, schema/migration, dependency, PHPUnit, CI workflow, route/UI, real/source data, external service, production, deployment or spend changes occurred. SQLite database-level checks do not prove simultaneous application service-command safety or row-lock semantics on another database engine. **I7 is closed for the approved synthetic/local/CI scope.** G2-G9 remain blocking for live source access and live model/agent activation; I7 does not authorize I8 or live activation.


## M3-07 I8-A — Synthetic readiness evaluation (2026-11-16)

The Product Owner authorized I8-A — Synthetic-Only AI Data-Agent Readiness and Evaluation. The bounded test addition independently exercises eight denied source-authorization states against the fixed I6 synthetic fixture and asserts zero proposal/publication side effects. The evaluation record is `M3-07_I8_SYNTHETIC_AGENT_READINESS_EVALUATION.md`.

PR [#228](https://github.com/mattari20/listing-v2/pull/228) merged as `6574d0654a9e5237568872ba4b3682c3260ae712` from exact validated head `518e25cd2f1cc9c8a80b2556bb570f02afc3c5b4`. On that exact head, FND-01 PHP 8.5 foundation CI [#43857206046](https://github.com/mattari20/listing-v2/actions/runs/43857206046) and Project documentation validation [#43857206017](https://github.com/mattari20/listing-v2/actions/runs/43857206017) passed. The full suite reported **15 passed, 803 assertions, 169 warnings**; warnings are the existing missing-local-`.env` test-harness warnings. No `.env` file was created or modified. I8-A closes only the synthetic readiness-evaluation scope; live source/model activation remains blocked by G2-G9.

I8-A evaluates deterministic policy enforcement only; it does not evaluate an LLM or establish real-world extraction accuracy. GOV-04 and candidate sources remain RESEARCH ONLY. G2-G9 continue to block live source/model activation. M3-07 is not complete for live AI Data-Agent activation.


## M3-08 preflight — historical snapshot (2026-11-16)

M3-08 A/B/C/D bounded synthetic/local/CI identity, authorization, moderation and privacy/security foundations are delivered in PRs #232 and #234. M3-09 Q01–Q06 is complete for authorized synthetic/local/CI scope in PR #237. M3-10 is now in progress for readiness planning only under the [M3-10 work plan](M3-10_PILOT_AND_LAUNCH_READINESS_WORK_PLAN.md); no participant, data-bearing, hosted or live pilot is approved. M3-11 remains conditional and requires separate explicit production/launch authorization.


## M3-08A/B implementation closeout — 2026-11-16

M3-08A/B first-party session identity and scoped authorization foundations were implemented and merged in [PR #232](https://github.com/mattari20/listing-v2/pull/232) as `a693b2c701adb5328e755156e1900771400b1dca`. Exact PR head `751add37d59e42c43acadcdbffd9f81d174123cb` passed FND-01 CI #378 and Project documentation validation #757. The synthetic suite passed with 15 tests and 863 assertions; 188 existing missing-`.env` diagnostics remain visible. The package is a bounded local/CI foundation only; it does not activate registration, verification/recovery delivery, role administration UI, reviews, UGC, moderation endpoints, production or deployment.

M3-08C moderation/appeals foundations and M3-08D privacy/safeguarding/security verification remain separately gated and require their own authorization. Reviews remain post-launch only.


## M3-10 governance reconciliation — 2026-11-17

The current M3-10 records are reconciled in [M3-10 Governance Ledger and Roadmap Reconciliation](M3-10_GOVERNANCE_LEDGER_AND_ROADMAP_RECONCILIATION.md). Option B remains proposal preparation only. M10-G01–G14 retain their evidence-backed blocked/open states; pilot readiness is NOT ACCEPTED. M3-11 remains conditional and is NOT AUTHORIZED. The next eligible action is intake of actual Product Owner and qualified human review evidence, not production or pilot implementation.


## M3-10 two-person synthetic rehearsal preparation — 2026-11-17

The [Two-Person Synthetic University Workflow Rehearsal Checklist](M3-10_TWO_PERSON_SYNTHETIC_REHEARSAL_CHECKLIST.md) is prepared as a paper-based, non-human tabletop aid for the Product Owner and ordinary-experience administrative assistant. It uses only the existing fictional `SYN-LHR-UNI-001` scenario, defines the expected representative submission/correction and reviewer boundaries, and provides a findings log and stop conditions. The tabletop has NOT been executed; this document creates no new test, usability, specialist-review or pilot evidence. All M10-G01–G14 dispositions remain unchanged; pilot readiness NOT ACCEPTED; M3-11 NOT AUTHORIZED.


## M3-10 R13 documentary desk review and authorized agenda closeout — 2026-11-17

The R13 repository desk review assessed all twelve scenarios (R01–R12) in the two-person synthetic university workflow checklist against the merged representative API implementation, adversarial hardening evidence and governance records. Result: **12 CLEAR, 0 UNCLEAR, 0 BLOCKED** for documentary clarity only. No new application execution, software test, human usability evidence or specialist approval is claimed. See [M3-10 R13 Desk Review and Final Agenda Closeout](M3-10_R13_DESK_REVIEW_AND_FINAL_AGENDA_CLOSEOUT.md).

**Authorized M3-10 readiness-preparation agenda: COMPLETE / CLOSED** for the repository-only, synthetic/local/CI and documentation scope authorized to date. The two-person tabletop remains NOT EXECUTED; M10-G01–G14 retain their existing open/blocked dispositions; pilot readiness remains NOT ACCEPTED; no pilot go/no-go is issued; human/participant activity and real-data processing remain NOT AUTHORIZED; M3-11 remains NOT AUTHORIZED. No standing restriction is relaxed.


## M3-11 controlled production launch preflight — 2026-11-17

The Product Owner explicitly instructed ChatGPT to start and complete M3-11. This is recorded as authorization to begin the M3-11 agenda and complete repository-only governance/release-preflight work. The [M3-11 Controlled Production Launch Preflight and Authorization Record](M3-11_CONTROLLED_PRODUCTION_LAUNCH_PREFLIGHT.md) defines M11-01–M11-10, evidence requirements, stop conditions and current blockers.

**M3-11 status:** INITIATED — GOVERNANCE / RELEASE PREFLIGHT ONLY. The preflight document is complete for current repository evidence. **Production readiness remains BLOCKED / NOT ACCEPTED.** The instruction does not satisfy missing qualified reviews, human owner acceptances, M3-10 pilot readiness, V2 environment/isolation proof, backup/restore/RPO/RTO evidence or a complete release candidate. No production/Hostinger/live database access, provisioning, deployment, migration, release, URL cutover, participant activity, real-data processing, external source/API/AI, new dependency/vendor or spend occurred or is authorized by this preflight. Existing V1 exclusion, public UGC/reviews/moderation disablement and Deeni Madaris default-OFF rule remain binding.

M3-11 production execution and closure require all applicable gates, qualified human decisions and exact-scope release authorization. No production go/no-go is issued.


## Current M3 status superseding the historical opening summary — 2026-11-20

The opening M3 row above is now reconciled to the authoritative `M3_MASTER_STEP_PLAN.md` and current `PROJECT_PROGRESS_REPORT.md`. M3-12 A01–A09 is closed for bounded repository verification only. The final M3 acceptance exercise is active. M3-11 remains BLOCKED / NOT ACCEPTED; no pilot, release candidate, go/no-go, production execution, deployment or public launch is authorized. The earlier M3-00–M3-11 roadmap table remains the planning sequence; M3-12 and F01–F06 are later verification/acceptance work, not new production authority.

## Final M3 acceptance and closure recommendation — 2026-11-20

The F01–F06 final acceptance exercise is complete. M3-12 A01–A09 is closed for repository-level verification only. M3-11 remains BLOCKED / NOT ACCEPTED; M3-10 pilot readiness remains NOT ACCEPTED. The overall M3 milestone remains OPEN / PARTIALLY COMPLETE — NOT CLOSED. Close the acceptance exercise, not the overall M3 milestone. See `M3_FINAL_ACCEPTANCE_F06_FINAL_REPORT_AND_CLOSURE_RECOMMENDATION_2026-11-20.md`.