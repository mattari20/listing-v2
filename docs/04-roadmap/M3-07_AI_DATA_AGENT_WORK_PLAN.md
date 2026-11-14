# M3-07 — AI Data-Agent Work Plan and Readiness Decision

**Repository:** `mattari20/listing-v2`  
**Prepared:** 2026-11-14  
**Baseline main:** `4775b9c0fbd50f264cb573253626e3786a6655ad`  
**Status:** Readiness review delivered; agent implementation BLOCKED pending source-specific, model/provider, privacy/security and operational approvals  
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
- M3-07 application implementation remains blocked. This work plan/readiness review is documentation only.

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

M3-07 application implementation cannot be marked complete until:
- at least one exact source/asset has an approved, current, scoped permission manifest;
- model/provider and data-handling terms are explicitly approved, or a separately approved local/offline model is selected;
- privacy/security and operational gates are signed off by qualified reviewers;
- implementation is limited to the approved environment, source, model, fields and method;
- synthetic adversarial CI passes on the exact PR head;
- evidence extraction, entity matching, human approval, provenance, audit, correction and rollback acceptance criteria pass;
- owner accepts the implementation and remaining risks.

No blanket source authorization or blanket AI activation is created by this document.

## 11. Current next action

The next eligible action is to complete a source-specific decision pack for one proposed source and a model/provider decision pack without accessing the source or activating a model. The owner must identify the exact source/asset and intended institution-level fields; qualified rights/privacy/security reviewers must assess the evidence; and the model/provider terms and zero-new-spend constraint must be resolved. Until then, keep the agent and every connector disabled.

## 12. Binding non-interference

No V1 artifacts, schemas, data, workflows or operational practices are used. No real source, provider, student or applicant data is used. No production, Hostinger/hPanel, live database, migration, external API/AI, model, connector, procurement, paid service, deployment, release or new spend is performed or authorized by this readiness review.
