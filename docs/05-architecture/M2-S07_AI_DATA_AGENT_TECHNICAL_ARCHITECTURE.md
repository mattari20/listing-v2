# M2-S07 — AI Data-Agent Technical Architecture

**Status:** Architecture design draft; no agent, connector, model or source is activated.  
**Scope:** Documentation only; technology- and vendor-neutral.  
**M2 weight:** 10%.

## 1. Purpose and governing principles
Define a controlled AI-assisted evidence workflow for maintaining a lawful, current and explainable education catalogue. AI may discover candidate evidence only within an expressly authorized source scope, extract candidate assertions, classify uncertainty and recommend entity matches. AI is not an authority, source-rights decision-maker, factual adjudicator or publication actor.

The design follows the risk lifecycle framing of NIST AI RMF (Govern, Map, Measure, Manage) and the Generative AI Profile, while treating those as voluntary design references rather than claims of legal compliance. See [NIST AI RMF](https://www.nist.gov/itl/ai-risk-management-framework), [NIST AI 600-1](https://doi.org/10.6028/NIST.AI.600-1) and the current [OWASP GenAI security project](https://genai.owasp.org/).

Principles:
1. Deny by default: no source, connector, account, credential, network destination or tool use without a recorded authorization decision.
2. Least privilege and bounded execution: read-only, scoped, rate-limited, time-limited capabilities; no shell, arbitrary code execution or general-purpose browser autonomy in the approved design baseline.
3. Evidence before assertion: every proposed fact retains source identity, location, retrieval/capture time, applicable rights decision, content hash where lawful, extraction version and confidence/uncertainty.
4. Separate AI proposal from human decision: AI outputs are candidates; publication requires an authorized human decision and a separate publication control.
5. Reversible and auditable: corrections, withdrawals, source revocations and publication rollbacks preserve history.
6. Fail closed: uncertainty, rights expiry, policy failure, identity ambiguity, validation failure or audit failure blocks publication.

## 2. Logical architecture and trust boundaries
Logical stages/components (not deployable services):
- **Policy and authorization registry:** approved source scope, permitted method, fields, purpose, jurisdiction, cadence, retention, attribution, redistribution, security conditions, expiry and approver.
- **Connector boundary:** narrow adapter interface; disabled until explicit source-specific approval. Credentials are external secrets, never prompts or logs.
- **Capture/evidence vault:** immutable or append-only evidence references and minimal captured material only where lawful; retention follows source-specific rights and approved purpose.
- **Untrusted-content quarantine:** fetched text, HTML, PDFs, spreadsheets, metadata and OCR are data, never instructions. Active content, scripts, macros and embedded links are not executed.
- **Extraction and normalization:** bounded model/task produces typed candidate assertions with evidence spans and provenance.
- **Deterministic validation:** schema/type checks, controlled vocabularies, dates, jurisdiction, required evidence, policy checks and cross-field invariants.
- **Entity resolution:** candidate matches, duplicate/split signals and affiliation suggestions; ambiguous/high-impact cases go to human adjudication.
- **Review workbench:** role-gated queues with side-by-side evidence, prior assertions, source quality, uncertainty, conflicts and decision history.
- **Publication gate/projection:** separately authorized publication decision; approved projections feed public search and profiles.
- **Audit and monitoring:** append-only decision events, model/tool/source versions, failures, access and publication events.

No component has a direct path from model output to public publication. The model cannot change authorization policy, grant itself access, create credentials, alter review roles or bypass deterministic validation.

## 3. Twelve-stage workflow mapping
| Stage | Activity | Required controls / output |
|---|---|---|
| 1. Source candidate | Identify a potential official/provider source | Candidate only; no access or collection permission |
| 2. Source assessment | Authority, ownership, terms, privacy, security, coverage, freshness | Source-specific legal/security/privacy assessment and named approval |
| 3. Authorization | Define permitted endpoints/methods/fields/purpose/cadence/retention | Explicit allowlist, expiry and revocation; default deny |
| 4. Bounded capture | Connector retrieves only approved scope | Read-only, rate-limited, logged, size/time limits; no crawling beyond scope |
| 5. Quarantine | Treat content as adversarial/untrusted | Strip active content; no instruction following; isolated parsing |
| 6. Extraction | Propose typed assertions with verbatim evidence anchors | Structured output; model/version/prompt provenance; uncertainty and abstention |
| 7. Deterministic validation | Validate types, dates, jurisdiction, source authority and policy | Invalid or unsupported candidates rejected/held |
| 8. Entity resolution | Suggest provider/institution/campus/programme/qualification matches | Confidence bands; no automatic merge/split for consequential ambiguity |
| 9. Conflict analysis | Compare current and historical assertions | Preserve disagreement, valid-time and observed-time; flag stale/conflicting evidence |
| 10. Human adjudication | Qualified reviewer accepts, rejects, edits or requests evidence | Role separation; rationale and identity recorded; high-impact fields require human review |
| 11. Publication decision | Authorized publisher approves an eligible assertion set | Independent policy check; preview, scope, timestamp and rollback reference |
| 12. Monitoring/withdrawal | Recheck freshness, source changes, complaints and revocation | Expiry/review schedule, incident path, withdrawal/retraction and audit history |

This mapping is conceptual and does not authorize execution of any stage.

## 4. Assertion and evidence contract
Each proposed assertion must carry, at minimum:
- subject candidate and domain type; attribute name and typed candidate value;
- exact evidence locator/span or a documented reason why a span is unavailable;
- source registry ID and authorization-decision ID;
- source owner/authority classification, jurisdiction and applicable scope;
- capture/observation timestamp, valid-from/to where evidenced, and publication-time distinction;
- retrieval/capture method, content fingerprint where lawful, parser/OCR version, model/provider/version and prompt/workflow version;
- confidence as a calibrated workflow signal, not a probability of truth unless empirically calibrated; explicit unknown/ambiguous states;
- deterministic validation results, conflict references, reviewer decision and publication status.

Do not convert absence of evidence into a negative fact. Do not infer current recognition, admission availability, fees, accreditation or programme status from unrelated or historical evidence. Distinguish provider registration, campus operation, affiliation, programme approval, awarding authority and qualification equivalence.

## 5. Human review and publication policy
Human review is mandatory for:
- institution identity merges/splits and affiliation/recognition changes;
- admissions availability, fees, scholarships, accreditation/recognition and qualification claims;
- sensitive provider classification or any fact with material student impact;
- low-confidence, conflicting, stale, incomplete or source-ambiguous evidence;
- corrections, complaints, takedowns and reinstatement.

Lower-risk routine facts may be eligible for future sampling-based review only after owner approval, measured error rates, legal review and documented risk acceptance. This exception is not approved in M2. AI may never autonomously publish or silently overwrite a previously published high-impact assertion.

## 6. Security and abuse controls
Threats include prompt injection in source content, malicious files, data poisoning, model hallucination, extraction drift, entity confusion, unauthorized tool use, credential leakage, cross-tenant/context leakage, denial-of-wallet, supply-chain compromise and audit tampering.

Required design controls:
- source text is never elevated to system/developer instruction; explicit separation of instructions and data;
- no secrets in model context; scoped secret broker at runtime only if later approved;
- egress allowlist, per-source rate/size/time budgets and kill switch;
- parser sandboxing and file-type validation; no macros/scripts/embedded link execution;
- output schema validation and deterministic allowlists; reject extra tool/action fields;
- model access has no publication, authorization-admin or identity-admin privilege;
- model/provider outage or refusal results in queue/hold, not unsafe fallback;
- model changes require evaluation, version pinning, regression set and rollback;
- log redaction, retention controls, audit integrity and incident response.

Map controls to current OWASP LLM/Agentic risk material during implementation planning; recheck the current edition at that time because these resources evolve.

## 7. Evaluation and acceptance measures
Before any activation, define and test:
- extraction precision/recall by fact class and jurisdiction; evidence-span validity;
- false merge/split rate and human override rate;
- unsupported assertion and hallucination rate;
- source authorization bypass tests (must be zero);
- prompt-injection/tool-use adversarial suite (no privilege escalation or publication);
- provenance completeness and reproducibility;
- reviewer agreement, queue ageing and correction/withdrawal latency;
- cost per accepted assertion and worst-case source/model spend.

No numeric threshold is approved here; S09/M3 must baseline realistic targets and the owner must approve them. Zero unauthorized source access and zero AI-only publication of high-impact facts are hard invariants, not target metrics.

## 8. Failure and degraded modes
- Authorization missing/expired/revoked: connector disabled; retain prior lawful publication only if rights allow, otherwise withdraw/hold.
- Model unavailable or rate-limited: queue work; no alternate provider without approval.
- Extraction invalid or evidence missing: reject/hold candidate.
- Conflict or identity ambiguity: human queue; do not guess.
- Audit/provenance store unavailable: stop capture/publication.
- Publication projection failure: preserve prior known-good state or remove affected item according to policy; never expose partially authorized content.
- Security incident: disable affected connector/model workflow, preserve incident evidence lawfully, notify designated owner and follow response plan.

## 9. Cost, privacy and legal gates
No provider/model is selected. Before procurement or activation, compare data residency/transfer, retention/training use, subprocessors, security certifications, indemnity, rate limits, API pricing, context/token cost, model drift, exit/export and deletion guarantees. Personal data and minors' data are minimized and excluded from prompts unless a separately justified, lawful and approved need exists. External source terms and copyright are assessed source by source. Public availability alone is not permission.

## 10. Decisions and exit evidence
S07 deliverables: 12-stage mapping; logical architecture/trust boundaries; assertion/provenance contract; review/publication policy; threat/control matrix; evaluation plan; failure/cost/privacy gates.

**Draft completion:** T01-T04 complete (85%); T05 threat/cost/failure review and cross-step validation pending (15%). S07 is not owner-accepted. No connector, agent, source, model or spend is authorized.
