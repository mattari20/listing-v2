# M3-01 — AI-Era Architecture Readiness Review

**Date:** 2026-11-12  
**Status:** Documentation proposal for M3-01 P04 evidence; owner decision required  
**Baseline:** `main` at `00bcdf3355c693d066cd24e924f5c640068c2a7b` (PR #123 merge)  
**Authority:** Accepted M2 architecture remains binding. This review does not reopen or amend M2 acceptance.  
**Implementation authorization:** NOT ISSUED

## 1. Executive decision

The accepted M2 architecture is a sound foundation for a modern education discovery platform: it separates public discovery, domain facts, evidence/provenance, human adjudication, publication, identity/reviews and operations. Its strongest long-term properties are anonymous-first access, low-bandwidth resilience, temporal honesty, source-rights gates, human approval of high-impact facts, privacy minimization and replaceable optional dependencies.

The review identifies additional architecture requirements needed to remain adaptable as AI systems, agent tooling, retrieval methods, security threats and interoperability standards evolve. These requirements should be incorporated as **capability and boundary requirements**, not as a mandate to deploy every technology now.

**Recommendation:** adopt the requirements in this review as M3-01 planning criteria, keep the stack decision open pending evidence, and evaluate a provider-independent, modular architecture. AI must remain optional, replaceable, observable, permission-constrained and incapable of publishing high-impact facts without human approval.

This is an architecture-readiness proposal, not a stack selection, legal/security clearance, procurement approval, implementation instruction or authorization to activate AI.

## 2. Scope, preserved decisions and explicit prohibitions

### 2.1 Preserved M2 decisions

This review supplements, and does not silently change:
- independent greenfield V2; no V1 code, schema, data, APIs, architecture, workflows, tests or operations reused;
- anonymous-first student discovery and useful operation without AI, precise location, maps or optional third-party services;
- HTML-first, accessible, low-bandwidth public experience;
- evidence lineage, source authorization, provenance, temporal validity, uncertainty and human adjudication;
- AI outputs are proposals; qualified human approval remains mandatory for high-impact facts and publication;
- no opaque universal institute score;
- V2-DEC-006: Deeni Madaris Show defaults OFF with zero exposure across all public surfaces and side channels; no sect/maslak filters or inference;
- source families remain RESEARCH ONLY until source-specific approval;
- no new spend without separate explicit approval.

### 2.2 Current work boundary

This review is documentation-only. It does not authorize:
- application code, technical spikes, package installation or environment activation;
- real or V1 data, production/source access, scraping, bulk collection or ingestion;
- external APIs, connectors, model calls, agents, MCP servers or other tool execution;
- database schema, migrations, production database access or data processing;
- cloud/hosting accounts, vendors, subscriptions, procurement or spend;
- personal/child data, user accounts, reviews, participant research, public pages, deployment, pilot or launch.

Candidate A remains isolated, synthetic-only and offline for any future scope that is separately authorized. All future external connectivity and AI activation require explicit scope-specific approval.

## 3. Target logical architecture

The following is a logical separation of responsibilities, not a deployment topology or a decision to create microservices.

1. **Experience and channel layer:** public web, future mobile clients, steward/admin interfaces and future partner interfaces. Public discovery remains useful anonymously and without AI.
2. **Core domain layer:** institution/provider/campus/programme concepts, relationships, temporal facts, comparison, geography and policy enforcement. Domain rules do not depend on a model provider.
3. **Evidence and governance layer:** source registry and authorization, evidence records, provenance, validation, conflict handling, human adjudication, publication state and immutable/auditable decision history.
4. **Search and retrieval capability layer:** deterministic structured search and filters first; lexical/fuzzy search; optional semantic retrieval/vector indexing only where measured relevance justifies it. Search results must preserve evidence references and freshness.
5. **AI capability layer:** provider/model gateway, task-specific model adapters, retrieval-augmented generation (RAG), prompt/configuration registry, evaluation harness and optional agent orchestration. This layer is replaceable and may be disabled.
6. **Controlled execution/integration layer:** permission-checked tools, scoped credentials, policy enforcement, asynchronous jobs where justified, human approval queues, audit events and explicit egress controls.
7. **Operations and assurance layer:** metrics, traces, cost/usage accounting, security events, backup/restore, incident response, dependency inventory and release/rollback controls.

A modular monolith is the preferred initial topology to evaluate. Logical module boundaries and stable contracts should permit later extraction only when measured scale, security isolation or independent deployment needs justify it. Do not begin with microservices or Kubernetes by default.

## 4. New architecture requirements and acceptance criteria

These requirements are proposed additions for M3-01 traceability. They are not implementation evidence.

| ID | Requirement | Minimum acceptance criteria |
|---|---|---|
| AI-ARCH-01 | Provider and model independence | Domain/application code calls a stable internal capability interface; provider-specific SDKs and response formats are isolated in adapters; provider/model can be replaced without changing domain rules or stored canonical facts. |
| AI-ARCH-02 | AI-optional operation | Core discovery, publication, source-of-truth reads and steward workflows have a documented non-AI path; provider outage, quota exhaustion or policy disablement does not make the public directory unavailable. |
| AI-ARCH-03 | Evidence-grounded RAG | Any future generated factual answer is grounded in authorized, current evidence; citations resolve to evidence/source records; freshness, uncertainty and conflicts are visible; unsupported claims are abstained from or clearly marked unknown. |
| AI-ARCH-04 | Retrieval strategy and vector optionality | Structured and lexical retrieval remain available; semantic/vector retrieval is an optional adapter; embeddings are versioned and rebuildable; no vector database is selected before relevance, privacy, cost and operational benchmarks justify it. |
| AI-ARCH-05 | Controlled agent execution | Agents, if later approved, run through a separate policy-enforced execution boundary; tools are allowlisted, least-privilege, input/output validated, time/resource bounded and audited; no unrestricted shell, database or arbitrary network access. |
| AI-ARCH-06 | Human approval and publication integrity | Model/agent output enters a proposal/quarantine state; no agent can approve its own evidence, change authorization policy or publish high-impact facts; accountable human actor, reason and timestamp are recorded. |
| AI-ARCH-07 | Prompt/configuration lifecycle | Prompts, system instructions, tool schemas and model parameters are versioned, reviewed, testable and rollback-capable; production activation is gated; secrets and personal data are excluded from prompt repositories. |
| AI-ARCH-08 | AI evaluation and regression | Evaluation datasets use synthetic or explicitly authorized data; tests cover factuality, citation validity, retrieval recall/precision, abstention, bias, multilingual behaviour, prompt injection and regression across model/prompt versions; thresholds are owner-approved before release. |
| AI-ARCH-09 | Agent and RAG threat protection | Treat retrieved documents, webpages, files and user inputs as untrusted; defend against prompt injection, tool abuse, privilege escalation, data exfiltration, poisoned retrieval and unsafe output; enforce policy outside model instructions. |
| AI-ARCH-10 | Observability and cost controls | Record privacy-minimized request/trace IDs, capability/model/prompt versions, latency, outcome, token/usage and estimated cost; redact secrets and personal data; define quotas, alerts and hard stop limits before paid activation. |
| AI-ARCH-11 | API and contract stability | Internal modules and future clients use documented, versioned contracts; validate inputs/outputs; define deprecation and compatibility policy; do not expose provider-specific model contracts as public platform APIs. |
| AI-ARCH-12 | Interoperability boundaries | Evaluate standards-based tool/context interoperability (including MCP where suitable) behind an explicit gateway; external tool servers are untrusted integrations, never implicitly trusted because they implement a standard. |
| AI-ARCH-13 | Asynchronous work and event discipline | Long-running ingestion/evaluation/agent tasks, if approved, use durable job state, idempotency, retries, dead-letter handling and audit correlation; do not add a broker until workload evidence requires one. |
| AI-ARCH-14 | Data portability and migration | Canonical domain/evidence records remain exportable in documented formats; avoid storing business-critical state only in vendor-specific prompt, vector or agent services; define provider exit and re-index/rebuild procedures. |
| AI-ARCH-15 | Multilingual and local-language readiness | Search and content contracts support English and Urdu, Unicode normalization, script variants and transliteration as separately testable capabilities; do not assume machine translation or transliteration is authoritative. |
| AI-ARCH-16 | Privacy and data minimization in AI flows | No child/student personal data or restricted source data is sent to a model by default; any future transfer requires purpose, legal basis, source permission, retention/training/region terms and explicit approval; minimize and redact inputs. |
| AI-ARCH-17 | Policy and tenant/context isolation | Authorization is enforced by application policy before retrieval and tool execution; retrieval cannot cross restricted scopes; Deeni Madaris default-OFF suppression applies before and after indexing, including vector, cache, API and export paths. |
| AI-ARCH-18 | Replaceable search and geospatial services | Search, geocoding, maps and tile dependencies remain behind adapters; manual locality and core content remain available if optional providers fail; no external provider is assumed free or unrestricted. |
| AI-ARCH-19 | Release, rollback and kill switch | AI/model/tool capabilities are disabled by default until separately approved; per-capability kill switches, version pinning, rollback and incident shutdown are designed before activation. |
| AI-ARCH-20 | Lifecycle and dependency governance | Model/provider, SDK, prompt, embedding and tool versions have ownership, support review, security review, upgrade and retirement plans; monitor model/provider terms and service lifecycle changes. |

## 5. AI data and trust flow

Any future AI-enabled evidence workflow should follow this controlled sequence:

1. **Authorize:** verify source-specific rights, purpose, allowed method, data class, retention and scope before retrieval or processing.
2. **Acquire:** retrieve only within an approved allowlist and bounded scope; retain source identity, timestamps and permitted evidence.
3. **Quarantine:** treat source content and user-provided material as untrusted data, never as executable instructions.
4. **Retrieve:** enforce authorization and Deeni Madaris suppression before any lexical/vector retrieval result is exposed to a model or user.
5. **Propose:** model produces structured candidate assertions with evidence references, uncertainty and model/prompt provenance.
6. **Validate:** deterministic rules check schema, source permissions, dates, entity scope, citations, contradictions and prohibited fields.
7. **Adjudicate:** qualified human reviews high-impact facts, conflicts and publication eligibility; record actor, decision, rationale and time.
8. **Publish:** only approved canonical facts enter the public projection; model output is never a public source of truth.
9. **Monitor and revoke:** monitor quality, incidents, cost and source/provider changes; disable capability and roll back versions when required.

## 6. Security, safety and governance controls

- **Prompt injection:** retrieved text, documents, source pages and user inputs are data, not instructions. Separate instruction channels from evidence; strip/encode where appropriate; never let source text grant tool permissions.
- **Tool permissions:** enforce authorization in deterministic application code at every call; use narrowly scoped service identities; deny by default; validate parameters and destinations; prohibit arbitrary network, filesystem, shell and unrestricted SQL.
- **Data exfiltration:** classify data; redact logs; prevent model/tool outputs from returning secrets or restricted records; test cross-scope and indirect retrieval paths.
- **Human control:** require explicit review for identity merges, recognition/accreditation status, legal/regulatory claims, high-impact facts, sensitive classifications and publication.
- **Deeni Madaris:** suppression is a core policy filter, not a UI-only setting. Test all direct and indirect surfaces including lexical/vector indexes, generated answers, caches, counts, exports and tool responses.
- **Children and privacy:** anonymous-first remains the default; do not create child profiles or send child/student personal data to AI services without a separately approved lawful and safeguarding design.
- **Audit:** record who/what initiated a task, tool and policy decisions, evidence IDs, model/prompt versions, human review and publication events. Keep logs privacy-minimized and access-controlled.
- **Resilience:** model/provider failure must degrade to deterministic search, approved facts and manual workflows. Never silently substitute an unreviewed provider or model.

## 7. Stack and technology implications — no selection

| Area | Current recommendation for evaluation | Decision rule |
|---|---|---|
| Application topology | Modular monolith with explicit module boundaries | Extract services only for measured isolation, scaling or deployment needs |
| Backend | Django/Python remains a strong candidate; Laravel/PHP and NestJS/TypeScript remain viable alternatives | Compare real owner skill fit, admin/workflow needs, security maintenance, deployment and lifecycle evidence; no framework selected |
| Primary database | PostgreSQL is the leading candidate; PostGIS is a likely geography extension | Confirm supported hosting, extension availability, backup/restore, data location, cost and synthetic performance evidence |
| Vector retrieval | pgvector is an optional candidate, not a baseline dependency | Benchmark authorized/synthetic corpus and compare quality, cost, isolation, backup and rebuild complexity before selection |
| Search | Database-native structured/lexical search first | Add dedicated search only when multilingual relevance, typo tolerance, filtering or scale tests demonstrate need |
| AI gateway | Internal provider-neutral adapter boundary | No provider, model, account, API or SDK selected; activation requires separate approval |
| RAG | Evidence-grounded retrieval capability | Build only after source rights, privacy, security and evaluation gates; citations and freshness are mandatory |
| Agent runtime | Separate permission-controlled execution boundary | Do not activate agents in Candidate A; select runtime only after threat model, tools and workload are approved |
| Interoperability | Versioned internal APIs; evaluate MCP for bounded tool interoperability | Standards do not replace authentication, authorization, validation or trust review |
| Background jobs | Framework-native durable jobs initially | Introduce external queue/broker only after workload, reliability and operations evidence |
| Frontend | HTML-first server rendering with progressive enhancement | Preserve SEO, accessibility and low-bandwidth performance; no mandatory SPA |
| Hosting | Unselected | Region, data residency, support, security, restore, latency and full cost evidence required; no account/trial/spend |

### 7.1 Explicitly avoid premature commitments

Do not begin with microservices, Kubernetes, a dedicated vector database, multiple autonomous agents, an expensive model stack, multiple search engines or paid orchestration platforms. Do not assume public map tiles, geocoding, embeddings or model APIs are free, unrestricted or suitable for student data.

## 8. Verification plan for later authorized stages

| Test family | Required future evidence |
|---|---|
| Provider substitution | Same contract and synthetic task evaluated against at least two adapters or a mock plus one approved provider; domain code unchanged |
| AI-off resilience | Public discovery and steward review work with model gateway disabled or unavailable |
| RAG grounding | Citation resolution, source permission, freshness, conflict and abstention tests |
| Retrieval quality | Reproducible bilingual synthetic benchmark with relevance metrics and documented limitations |
| Prompt injection | Adversarial source/user content cannot alter system policy, invoke unauthorized tools or expose restricted data |
| Tool authorization | Negative tests for privilege escalation, parameter tampering, cross-scope access and arbitrary destinations |
| Publication integrity | No model/agent route bypasses human approval or publishes unapproved assertions |
| Deeni Madaris suppression | Zero-exposure tests across structured, lexical, vector, generated, cached, exported and API surfaces |
| Privacy | No prohibited personal/child data in fixtures, prompts, logs, traces or model requests |
| Cost and operations | Usage limits, alerts, kill switch, timeout, retry and outage behaviour demonstrated in a separately approved test environment |
| Portability | Canonical facts/evidence export; model/prompt/vector indexes can be rebuilt or replaced without loss of authoritative records |
| Multilingual | English/Urdu/Unicode/transliteration test corpus; document failure modes and human correction path |

No such tests have been run by this review. Test targets and thresholds require later owner approval.

## 9. M3-01 decision impact and remaining gates

This review strengthens P04 evidence but does not complete P04 or select a stack. The following remain:

- **P02:** Candidate A remains approved for detailed planning only; the AI-era capabilities are future architecture requirements, not additions to Candidate A implementation scope.
- **P03:** solo-founder decision is accepted for the bounded synthetic/offline planning model; it is not independent security certification or production operations clearance.
- **P04:** framework/database/hosting/provider decisions remain open pending skill, cost, support, region, portability and proof-of-fit evidence.
- **P05:** applicable legal, privacy, source-rights, safeguarding and security reviews remain unperformed/unapproved.
- **P06:** test/release framework exists; no environment is selected or activated.
- **P07/P08:** authorization request and final M3-01 decision remain open. Implementation authorization remains NOT ISSUED.

## 10. Acceptance checklist for Product Owner

- [ ] Accept AI-ARCH-01 through AI-ARCH-20 as planning requirements, subject to later scope-specific implementation and verification.
- [ ] Confirm AI remains optional and provider/model independent.
- [ ] Confirm RAG, vector retrieval, agent runtime, MCP, queues and external search are capabilities to evaluate only when justified, not immediate infrastructure commitments.
- [ ] Confirm no autonomous high-impact decision or publication.
- [ ] Confirm no stack, hosting, model, vendor, API, account or spend is selected by this review.
- [ ] Confirm M2 remains accepted/closed and this review does not reopen it.
- [ ] Confirm Candidate A remains offline, synthetic-only and not authorized for implementation.
- [ ] Confirm P04–P08 remain subject to their existing evidence and owner decision gates.

**Disposition:** Recommended for owner review. This document does not constitute acceptance or implementation authorization.
