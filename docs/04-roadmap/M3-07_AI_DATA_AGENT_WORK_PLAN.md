# M3-07 — AI Data-Agent Work Plan and Readiness Decision

**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-14  
**Baseline main:** `4775b9c0fbd50f264cb573253626e3786a6655ad`  
**Status:** Readiness review delivered; bounded synthetic I6 proposal-adapter implementation delivered, validated and merged; live agent/source activation remains BLOCKED pending source-specific, model/provider, privacy/security and operational approvals  
**Owner direction:** Proceed with M3-07 readiness review and prepare the next implementation gate. This does not waive any source, model, budget, legal, privacy or security approval.

## 1. Purpose

Prepare a controlled path for an AI-assisted evidence workflow that helps maintain the Pakistan education catalogue without making a model an independent source of truth. The intended agent may propose candidate sources, extract candidate assertions from authorized evidence, compare versions and prepare human-review cases. It must not autonomously publish material facts.

M3-07 is governed by the accepted M1-S08 workflow requirements, M1-S07 source-rights/security controls, M2 data/provenance/publication architecture, M3-03 evidence governance and the M3 master plan.

## 2. Current readiness finding

The current source-rights register explicitly states that all listed candidate sources remain **RESEARCH ONLY** and that no source is approved for manual verification or ingestion. It records that no permission request has been sent. The M1-S08 research baseline also states that no source was accessed or connected under that specification and that no automated collection or implementation was authorized.

The current project records do not select or approve an AI model/provider, model region, data-retention terms, training-use terms, credentials, connector, scheduler or paid service. The existing no-new-spend constraint remains binding.

Therefore:
- No source retrieval, scraping, bulk download, external API call, source-owner contact or connector activation is permitted.
- No external model call, model account, model credential, AI provider or paid inference service is permitted.
- No real/source/provider/student/applicant data may be used in tests.
- No production, V1, Hostinger/hPanel, live database, migration, deployment, public release or spend is permitted.
- Only the separately authorized deterministic synthetic I6 adapter implementation may proceed in local/CI scope. Live AI-agent, source retrieval and model/provider implementation remain blocked by the conjunctive gates.

## 3. Bounded objective once all gates pass

Only after separate written approvals, implement an isolated, least-privilege, proposal-only workflow:

1. Resolve an exact approved source manifest before any retrieval.
2. Schedule only approved work within source-specific cadence, rate and cost limits.
3. Retrieve only the approved asset by the approved method.
4. Preserve permitted evidence, timestamps, integrity references and provenance.
5. Extract candidate assertions while treating source content as hostile data, never instructions.
6. Apply deterministic schema, type, jurisdiction, date, scope and field-level checks.
7. Propose entity matches with alternatives; hold ambiguous matches for human review.
8. Compare current and previous assertions; preserve conflicts and history.
9. Route high-impact, sensitive, ambiguous, stale or conflicting facts to human review.
10. Require authorized human approval before any material publication change.
11. Preserve correction, withdrawal, rollback, audit and source-suspension paths.

AI outputs remain proposals. Model confidence is not evidence, legal authority or publication permission.

## 4. Mandatory gates — all are conjunctive

| Gate | Required evidence before implementation/activation | Current state |
|---|---|---|
| G1 — Exact source and asset | Named legal owner, canonical URL/API/file, asset identifier, covered fields and jurisdiction | BLOCKED — no source approved |
| G2 — Rights and permitted acts | Applicable license/terms or written permission covering the exact method and acts: access, retrieval, storage, transformation, caching, display, attribution, redistribution and commercial use as applicable | BLOCKED — no reuse grant established |
| G3 — Privacy and minimization | Field-level personal/sensitive-data screening, exclusions, lawful purpose, retention/deletion and incident route; qualified review where required | BLOCKED — source-specific review incomplete |
| G4 — Security and access | Destination allowlist, redirect/IP restrictions, authentication scope, read-only credentials, rate limits, file limits/scanning, secrets isolation, logging/redaction and kill switch | BLOCKED — no source access design approved |
| G5 — Model/provider | Explicit model/provider, version, region, data retention, training-use terms, subprocessors, security controls, data-processing terms and exit strategy | BLOCKED — none selected/approved |
| G6 — Cost and capacity | No-cost/local approach or explicit budget ceiling, usage caps, retry limits, human-review capacity and owner approval | BLOCKED — no model/service spend authorized |
| G7 — Human governance | Named source-rights approver, security/privacy reviewer, data reviewer and publication approver; separation-of-duties rules | BLOCKED — qualified reviewers not assigned |
| G8 — Test/evaluation | Synthetic-only adversarial suite, field-level extraction evaluation plan, entity-match false-merge controls, prompt-injection and rollback tests | PLANNED — criteria specified; implementation blocked |
| G9 — Owner activation decision | Written approval naming exact source, asset, method, fields, model/provider, environment, limits, reviewers and expiry | BLOCKED — no activation authorization |

A gate approval is scoped only to the exact asset, fields, method, purpose, environment and validity period stated. Approval for one source or asset does not approve another. A source being publicly reachable, robots-allowed, linked by an authority or available through an API does not establish reuse permission.

## 5. Source authorization manifest contract

Before enabling a source, its immutable versioned manifest must record:

- unique source and asset IDs; legal owner/publisher; competent authority for each claim type;
- canonical host, exact path/API/feed/file, allowed redirect destinations and covered fields;
- dated terms/license/permission evidence, permitted acts, prohibited acts and attribution;
- approved retrieval method, authentication scope, rate/volume limits and expiry;
- geography, sector, jurisdiction and coverage limitations;
- privacy classification, personal/sensitive field exclusions, retention and deletion rules;
- source publication cadence, observed freshness and correction/withdrawal route;
- named rights, privacy/security and operational reviewers; owner decision and review/expiry date;
- suspension conditions, incident response and source-owner withdrawal process.

The runtime must fail closed if the manifest is absent, expired, suspended, ambiguous, out of scope or inconsistent with the requested method/asset/fields. A source may be discovery-only (candidate URL proposal) without being retrieval-approved.

## 6. Model/provider approval contract

No model/provider is preselected. Before any external inference, the owner must review and explicitly approve:

- provider, exact model/version and intended tasks;
- processing region, retention/deletion, training-use policy and subprocessors;
- security, access, logging, data-processing and incident terms;
- whether source content or personal data would be sent; default is synthetic/minimized content only until separately approved;
- cost per request/token or equivalent, hard usage caps, retry limits and a kill switch;
- version-change notice, evaluation/revalidation and provider-exit plan.

No credentials may be placed in prompts, repository files, test fixtures or ordinary logs. Model input is limited to the minimum approved evidence. If no provider satisfies the approved constraints, the agent remains disabled; manual review continues.

## 7. Data classes and prohibited content

Permitted only after approval: institution-level public-interest facts within an approved source's exact rights and field scope, such as institution identity, campus, programme, authority relationship, status and dated admission/fee information.

Always excluded from this workflow unless a separate exceptional legal/privacy approval is obtained (and not part of this M3-07 scope): student/applicant records, CNIC/passport or identity documents, marksheets, credentials, child-level data, private staff contact details, individual practitioner records, personal health/disability data, private addresses and unrelated personal information.

Deeni Madaris default-OFF remains unchanged. No sect/maslak enrichment, filtering or inference is introduced.

## 8. Threat model and required controls

| Threat | Required control / fail-safe |
|---|---|
| Prompt injection in HTML/PDF/spreadsheet | Treat all source content as untrusted data; isolate it from system instructions; no tool invocation from content |
| SSRF, redirect or private-network access | Strict host/path allowlist, redirect revalidation, block private/internal IP ranges and unsafe schemes |
| Malicious or oversized file | MIME/signature validation, size limits, isolated parsing, malware scanning where authorized; reject macros/executables |
| Secret leakage | Credentials outside model context; scoped secrets; redacted logs; no secret-bearing prompts |
| False extraction / hallucination | Exact supporting passage and source location required; deterministic schema validation; reject unsupported fields |
| False entity merge | Stable identifier preference, alternatives and human adjudication for ambiguous matches |
| Stale or conflicting facts | Preserve all assertions, effective dates and conflicts; never silently overwrite |
| Rights expiry/withdrawal | Block new retrieval; suspend source; flag affected assertions for review/takedown as required |
| Personal/sensitive data capture | Field allowlist, minimization, redaction/rejection and privacy incident route |
| Autonomous publication | Agent has no publication permission; human approval is a separate capability and actor |
| Runaway polling/cost | Source-specific cadence, hard quotas, bounded retries, budget ceiling and kill switch |

## 9. Synthetic-only verification plan

When implementation is separately authorized, CI must use synthetic fixtures and a deterministic fake model adapter. It must not call a live model, external URL, real source or production service.

Required test families:
- unapproved, expired, suspended, scope-mismatched and method-mismatched manifests always block retrieval;
- candidate-source discovery cannot trigger retrieval;
- prompt-injection payloads cannot alter policy, reveal secrets or invoke tools;
- unsafe URLs, redirects, private IPs, file types and oversized files are rejected;
- source/model outputs lacking exact evidence are held or rejected;
- deterministic schema/date/jurisdiction checks reject invalid values;
- ambiguous entity matches remain unresolved and never auto-merge;
- conflicting sources preserve both assertions and create a human-review case;
- missing/stale evidence is not represented as current;
- sensitive/personal fields are excluded and trigger the defined privacy route;
- high-impact claims require human approval before publication;
- source withdrawal, correction, rollback and audit history are reproducible;
- Deeni Madaris remains excluded from every public surface;
- quotas, retry ceilings, kill switch and least-privilege capabilities are enforced.

Evaluation must report field-level precision/recall, unsupported-claim rate, entity false-merge rate, human override rate, stale/conflict routing and cost per accepted change. Thresholds are not invented here; the owner and qualified reviewers must approve them against a synthetic evaluation set before any live activation.

## 10. Deliverables and acceptance boundary

This readiness review can be accepted as a planning artifact when the work plan, gate register, source/model decision record, threat model, test contract and documentation traceability are reviewed and CI validated.

M3-07 AI Data-Agent/live-source implementation cannot be marked complete until:
- at least one exact source/asset has an approved, current, scoped permission manifest;
- model/provider and data-handling terms are explicitly approved, or a separately approved local/offline model is selected;
- privacy/security and operational gates are signed off by qualified reviewers;
- implementation is limited to the approved environment, source, model, fields and method;
- synthetic adversarial CI passes on the exact PR head;
- evidence extraction, entity matching, human approval, provenance, audit, correction and rollback acceptance criteria pass;
- owner accepts the implementation and remaining risks.

No blanket source authorization or blanket AI activation is created by this document.

## 11. Current next action — reconciled 2026-11-16

R1 and R2 are delivered in PRs #204 and #206. R3 is complete as a no-activation gate reconciliation: GOV-04 remains RESEARCH ONLY; no model/provider is selected; G2-G7 remain blocked and G9 is not authorized. See M3-07_R3_SOURCE_RIGHTS_AND_MODEL_FEASIBILITY_RECONCILIATION.md.

I1-I3 are merged for bounded synthetic local/CI scopes. I4 — Field Definition Governance Lifecycle — was delivered and merged through PR #210 as `88345f0cfaea66bbdd841b0c18222b83307efac3`. Exact-head Project documentation validation #43819885652 and PHP 8.5 FND-01 foundation CI #43819885671 passed. The synthetic suite had zero failures and 593 assertions; 148 non-fatal missing-local-`.env` warnings remain an existing test-harness condition. See `M3-07_I4_FIELD_DEFINITION_GOVERNANCE_IMPLEMENTATION_RECORD.md`. I4 owner acceptance remains a separate decision.

**I5 implementation and closeout:** the Product Owner authorized I5-A through I5-C on 2026-11-16. All three packages and the historical-definition regression are merged: PR #213 (I5-A) as `6988c972ce0caa2a571f822fd51dfd5cc48fd3ae`; PR #214 (I5-B) as `fa5695b594704df0847c6578ea3e9857a522f6b4`; PR #215 (I5-C) as `570c8b8e8ef2bcac8142a03ec2f90198d3ffc307`; and PR #216 (exact historical-definition test) as `304fce61641471c6b0afdfd8b9efff27ff21955e`. All exact-head PHP 8.5 foundation CI and Project documentation validation checks passed. The final suite passed 15 tests with 647 assertions; 157 non-fatal missing-local-`.env` warnings remain an existing test-harness condition. See `M3-07_I5_IMPLEMENTATION_RECORD.md` for scope, PR heads, acceptance evidence and limitations.

I5 closes the bounded value correction, withdrawal, reinstatement and registry-aware public profile agenda only. It does not complete or activate the AI Data-Agent. GOV-04 candidate sources remain RESEARCH ONLY; G2-G9 source rights, privacy, security, model/provider, operational and activation gates remain blocked. No source access, owner contact, permission request, external model/API, connector, scheduler, ingestion or spend is authorized.

**I6 scope/design preflight — 2026-11-16:** Completed against `main` `3f76f2758768ba331711de36bbc2dbe9b0aab17a`. The proposed bounded design is a deterministic offline synthetic fixture adapter, a fixed server-owned agent identity with only `submit_agent_field_proposal`, a dedicated I3 field-aware submission path and a dedicated editorial-case submission path. It reuses I3 validation/evidence/source-authorization/idempotency/audit/outbox controls and creates only proposed claim versions awaiting human review. The existing human proposal path and all human-only review, adjudication, publication, correction, withdrawal and definition-governance controls remain intact. No migration is proposed; the existing schema has bounded actor identity/class fields. See [I6 Synthetic Agent Proposal Adapter Preflight](M3-07_I6_SYNTHETIC_AGENT_PROPOSAL_ADAPTER_PREFLIGHT.md).

**I6 implementation — 2026-11-16:** The Product Owner explicitly authorized the exact bounded synthetic I6 scope. Implementation is delivered on `feature/m3-07-i6-synthetic-agent-proposal`; PR [#220](https://github.com/mattari20/listing-v2/pull/220) is open against `main` from base `2d9e1c15df808c5e4679e0cd2d63d4fb98be2246`, with exact validated head `17d8938a7715d8bd07950ef2039e5cc95f174cc7`. Exact-head FND-01 PHP 8.5 CI #43838413609 and Project documentation validation #43838413686 passed. The suite reported 15 passed, 687 assertions and 164 warnings, including the existing missing-local-`.env` test-harness warnings. See [I6 Implementation Record](M3-07_I6_IMPLEMENTATION_RECORD.md). The adapter is fixed to one deterministic synthetic institution fixture; it has only `submit_agent_field_proposal`, reuses I3 validation/evidence/source-authorization/audit/outbox controls, and creates only a proposed claim with a submitted editorial case. A distinct human remains responsible for review, adjudication and publication. No migration, schema change, backfill, dependency, Composer change, route/UI, real data/source, external service, production operation, deployment or spend occurred. I7 remains separately gated; G2-G9 remain blocking for live source access and live agent activation.

## 12. Binding non-interference

No V1 artifacts, schemas, data, workflows or operational practices are used. No real source, provider, student or applicant data is used. No production, Hostinger/hPanel, live database, migration, external API/AI, model, connector, procurement, paid service, deployment, release or new spend is performed or authorized by this readiness review.


## I7 — Full Regression and Hardening preflight (2026-11-16)

The canonical D5 package definition is test-only: adversarial, concurrency, migration, rollback, privacy, performance and regression coverage. The I7 preflight is complete on current main 1b4b58442807336bcf9905722b2a59a7a36606c1. It reviewed the 19 test source files, 11 migrations and existing CI environment, mapped I1-I6 coverage and documented the hardening matrix in M3-07_I7_FULL_REGRESSION_HARDENING_PREFLIGHT.md.

Only synthetic tests under `tests/Feature/**` and `tests/Unit/**` plus I7 implementation documentation were authorized. Application code, migrations/schema, Composer/dependencies, phpunit.xml, CI workflows, routes/UI, external services, production/source access and spend remained excluded. If a test exposed an application defect, implementation had to stop and seek separate authorization.

**I7 implementation closeout — 2026-11-16:** The Product Owner explicitly authorized the exact bounded I7 scope. PR [#224](https://github.com/mattari20/listing-v2/pull/224) merged as `6efd9a4d29067c3e0dea11ada8ae01266f2d33b2` (exact validated head `cd4a21c790b933f99567a6760260d914c4a09983`); PR [#225](https://github.com/mattari20/listing-v2/pull/225) merged as `167ec4cad05926569bebda6aadac207166782235` (exact validated head `a31a78141b93bc5da2545ff49991d166f56c5f50`). Exact-head FND-01 CI #43850465461/#43850848377 and documentation validation #43850465611/#43850848331 passed. Final suite: 15 passed, 761 assertions, 168 missing-local-`.env` harness warnings.

I7 verifies adversarial public/agent inputs, proposal-only and human-only governance, all 11 migrations on a disposable SQLite file through fresh install/full rollback/reinstall, SQLite independent-connection idempotency and writer-lock behavior, public privacy and Deeni Madaris default-OFF, and deterministic query-count equality for one versus five synthetic results. The SQLite tests do not prove simultaneous application service-command safety or other-engine row-lock semantics. See [I7 Implementation Record](M3-07_I7_IMPLEMENTATION_RECORD.md).

**I7: IMPLEMENTED, VALIDATED AND MERGED for the approved synthetic/local/CI scope.** G2-G9 remain blocking for live source access and live agent activation. I7 does not authorize I8, live source/model activation, production or deployment.


## 13. I8-A — Synthetic-only readiness and evaluation (2026-11-16)

The Product Owner explicitly authorized I8-A. The bounded test addition independently evaluates eight source-authorization denial states against the existing fixed synthetic proposal adapter: research-only status, revocation, future validity, expiry, missing processing scope, purpose mismatch, method mismatch and territory mismatch. Every case must fail closed and produce no claim/version/editorial case/publication decision/public projection or successful proposal audit/outbox write.

The detailed record is `M3-07_I8_SYNTHETIC_AGENT_READINESS_EVALUATION.md`; traceability is recorded in `IMPLEMENTATION_TRACEABILITY_MATRIX.md`. Existing I6 positive synthetic and human-review tests remain the positive governance control.

I8-A is a deterministic policy-contract evaluation, not an LLM extraction benchmark. It does not establish precision/recall, hallucination rate, false entity merge rate or live-source readiness. No model/provider is selected or called. Candidate sources remain RESEARCH ONLY and G2-G9 remain conjunctive blockers.

The implementation changes synthetic feature tests and I8/project documentation only. PR [#228](https://github.com/mattari20/listing-v2/pull/228) merged as `6574d0654a9e5237568872ba4b3682c3260ae712` from exact validated head `518e25cd2f1cc9c8a80b2556bb570f02afc3c5b4`. On that exact head, FND-01 PHP 8.5 foundation CI [#43857206046](https://github.com/mattari20/listing-v2/actions/runs/43857206046) and Project documentation validation [#43857206017](https://github.com/mattari20/listing-v2/actions/runs/43857206017) passed. The full suite reported **15 passed, 803 assertions, 169 warnings**; warnings are the existing missing-local-`.env` test-harness warnings. No `.env` file was created or modified. I8-A is closed for the bounded synthetic/local/CI evaluation scope. G2-G9 remain live-activation blockers. No source access, source-owner contact, permission request, external API/model, connector, scheduler, production/V1/Hostinger, deployment or additional spend is authorized.
