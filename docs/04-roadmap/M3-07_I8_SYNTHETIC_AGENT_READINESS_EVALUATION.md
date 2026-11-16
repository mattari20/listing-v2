# M3-07 I8 — Synthetic AI Data-Agent Readiness and Evaluation

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Implementation base:** `252e33e15d023985e180ea225996c0953af316b4`  
**Branch:** `test/m3-07-i8-synthetic-agent-readiness`  
**Authorization:** Product Owner explicitly authorized I8-A — Synthetic-Only AI Data-Agent Readiness and Evaluation on 2026-11-16.  
**Status:** Initial exact-head PHP 8.5 CI and documentation validation passed; final evidence reconciliation is being validated on the updated PR head. No live AI/source activation.

## 1. Objective and decision boundary

I8-A evaluates whether the existing fixed synthetic proposal adapter and its governed I3 submission path fail closed when source authorization is absent, expired, revoked or outside its exact permitted scope.

This is a deterministic contract evaluation of the existing synthetic adapter. It is **not** an LLM extraction benchmark, a source-coverage test, a model/provider approval or evidence that a live AI agent is ready to activate.

The I8 scope is limited to:
- synthetic-only tests under `tests/Feature/**`;
- this I8 evaluation record and the project-control documentation needed to index and report it;
- local/GitHub CI validation against disposable test databases only.

No application/runtime code, migration/schema, Composer/dependency, PHPUnit configuration, CI workflow, route/UI, real/source/provider/student/applicant data, external URL/API/model/provider/connector/scheduler, production/V1/Hostinger, deployment, release, procurement or additional spend is included.

## 2. Evaluation subject

The existing I6 adapter is deliberately fixed to:
- fixture: `synthetic-institution-alpha-v1`;
- institution label: `Synthetic Institute Alpha`;
- server-owned actor: `synthetic-agent-proposal-adapter-v1`;
- sole capability: `submit_agent_field_proposal`;
- field: institution-level `institution_display_name`, definition version 1;
- candidate value: the fixed synthetic institution label;
- evidence: existing metadata-only synthetic fixture references.

The adapter does not accept caller-supplied candidate values, actor identities, capabilities, source context, field definitions or privileged actions. It can submit a proposal and a human-review case only. Review, adjudication, publication, correction, withdrawal, reinstatement and field-definition governance remain human-controlled.

## 3. I8 implementation

Added one focused evaluation method to `tests/Feature/SyntheticAgentProposalAdapterTest.php`:

`test_i8_source_authorization_evaluation_denies_unapproved_expired_and_scope_mismatched_evidence`

The method isolates and evaluates eight negative authorization cases against the same deterministic synthetic evidence reference. Before each case, the authorization row is reset to the known valid synthetic baseline so each negative condition is independently tested.

| Case | Adversarial authorization state | Expected result |
|---|---|---|
| I8-E01 | Status is `research_only` | Deny |
| I8-E02 | Authorization has a revocation timestamp | Deny |
| I8-E03 | Validity starts in the future | Deny |
| I8-E04 | Authorization has expired | Deny |
| I8-E05 | Processing scope is not permitted | Deny |
| I8-E06 | Requested purpose is not permitted | Deny |
| I8-E07 | Requested method is not permitted | Deny |
| I8-E08 | Requested territory is not permitted | Deny |

For every case the test asserts that no claim, claim version, editorial review case, publication decision or public projection is created. After all cases it also asserts that no successful proposal audit event or proposal outbox event exists.

The existing I6 synthetic tests remain the positive controls: a correctly scoped synthetic fixture can create one deterministic proposal and review case; retries return the same result; the agent cannot review or publish; and a distinct human reviewer can perform the review transition.

## 4. Evaluation contract and acceptance thresholds

The deterministic authorization-gate acceptance threshold is **100% fail-closed** for all eight negative cases:
- denied cases: 8 of 8;
- unauthorized claim writes: 0;
- unauthorized claim-version writes: 0;
- unauthorized editorial cases: 0;
- publication decisions: 0;
- public projections: 0;
- successful proposal audit events: 0;
- proposal outbox events: 0.

The positive synthetic control remains the existing I6 contract test; it is not counted as a real-world extraction success.

No precision, recall, hallucination rate, entity false-merge rate, model confidence calibration, throughput or cost-per-accepted-change score is claimed. Those metrics require a separately approved evaluation corpus, a selected and approved model/provider or approved offline model, and qualified reviewer-defined thresholds. No model is called in I8.

## 5. Security and governance disposition

| Control | I8 disposition |
|---|---|
| Source rights and authorization | Eight independent denied states evaluated; G2-G4 remain live-activation blockers |
| Model/provider and data handling | None selected or called; G5 remains blocked |
| Cost and capacity | No external service or spend; G6 remains blocked |
| Human governance | Agent proposal-only; human review/adjudication/publication boundary retained; G7 remains blocked pending named qualified reviewers |
| Synthetic evaluation | Eight negative source-authorization cases added; exact-head CI pending |
| Owner activation | No live activation; G9 remains blocked |
| Privacy/minimization | Synthetic metadata-only references; no real or personal data |
| Deeni Madaris | Existing default-OFF and public-surface exclusions unchanged |

GOV-04 and all candidate source families remain RESEARCH ONLY. No source contact, permission request, manual source verification, retrieval, scraping, ingestion or republication is authorized. G2-G9 remain conjunctive gates and cannot be satisfied by passing synthetic tests.

## 6. Exact scope exclusions and stop conditions

If a test reveals an application defect, do not modify application code or schema under I8-A. Preserve the reproduction and request separate corrective authorization. Do not weaken the gate or change expected outcomes to make CI pass.

No live model, model credentials, prompts to external providers, source content, external network access, connector, crawler, scheduler, production database or paid service is used. No production/V1/Hostinger access, deployment, release or additional spend is authorized.

## 7. Acceptance evidence

The I8 package is accepted only after:
1. the focused test passes on the exact PR head;
2. the full FND-01 PHP 8.5 synthetic suite passes;
3. Project documentation validation passes on the exact PR head;
4. changed-file review confirms the test-only and I8 documentation boundary;
5. project progress, milestone register, master plan, roadmap, documentation catalogue and index are reconciled.

Initial exact-head validation on PR #228 head `e50eb6a7a4515481aede723ddb5a106daa7a22f4` passed: FND-01 PHP 8.5 foundation CI run [#43856909227](https://github.com/mattari20/listing-v2/actions/runs/43856909227) and Project documentation validation run [#43856909213](https://github.com/mattari20/listing-v2/actions/runs/43856909213). The full suite reported **15 passed, 803 assertions and 169 warnings**. Warnings are the existing missing-local-`.env` test-harness warnings; no `.env` file was created or modified. The focused I8 method passed as part of the suite. These results apply to the stated exact head; the evidence-reconciliation commit must also pass both required checks before merge. No merge SHA is recorded until GitHub confirms it.

## 8. Final I8 disposition

I8-A can close for its bounded synthetic authorization-evaluation scope once the exact-head checks above pass. It does **not** complete the live AI Data-Agent milestone. M3-07 remains blocked from live source/model activation until exact source/asset rights, model/provider/data-handling, qualified privacy/security/operational review, cost/capacity and explicit owner activation gates are independently satisfied.

**Next project step after I8-A closeout:** prepare the M3-07 bounded synthetic implementation acceptance/closeout record with the live-activation blockers carried forward. M3-08 remains a separate roadmap step and requires its own readiness and authorization controls.
