# M3-01 Detailed Planning Evidence Pack — P01, P02 and P06

**Status:** Documentation delivered for owner review; no implementation authorized  
**Baseline:** `main` at M3-00 closeout merge `67e03b5a8b01ca70e0756d4cd04a155068df73af`  
**Governing acceptance:** M3-00 Final Owner Acceptance and Closure Record, 2026-11-12  
**Current planning boundary:** synthetic evidence only; no application code, technical spike, source access, database change, procurement, spend or deployment.

## 1. Purpose and task disposition

This pack advances M3-01 through evidence-based planning, not implementation.

| Task | Weight | Current disposition | Completion interpretation |
|---|---:|---|---|
| P01 Baseline/dependency/blocker reconciliation | 10% | Reconciled in this pack | Delivered for owner review; acceptance pending |
| P02 First implementation slice/exclusions | 15% | Candidate scope and alternatives documented | Proposed only; not approved |
| P03 Human roles/capacity/security accountability | 15% | Gaps explicitly carried forward | Blocked pending named qualified humans |
| P04 Stack/hosting/cost decision evidence | 15% | Evidence requirements and no-go boundaries mapped | Blocked; no stack/host/cost approval |
| P05 Legal/privacy/source/safeguarding/security | 15% | Applicable gates mapped to candidate slice | Blocked pending qualified review and evidence |
| P06 Environment/test/CI/release/rollback | 15% | Synthetic-only verification framework drafted | Delivered for review; no environment activated |
| P07 Narrow implementation authorization request | 10% | Depends on P02–P06 decisions | Not ready; NOT ISSUED |
| P08 Final owner review and M3-01 decision | 5% | Depends on P01–P07 | Not started |

A delivered document is not an accepted task. No weighted M3-01 completion percentage is claimed in this pack.

## 2. P01 — baseline and dependency reconciliation

### 2.1 Governing baseline

- M0, M1 and M2 are accepted/closed. Do not reopen them or silently change accepted requirements.
- M3-00 is accepted/closed for bounded planning outputs only; its deferrals and carry-forward blockers remain binding.
- M3-01 is planning/authorization only. A separate, explicit, scope-specific owner authorization is required before any implementation.
- V2 must be independently built. No legacy V1 code, schema, data, APIs, architecture, technology decisions, workflows, tests, CI, deployment or operational practices may be reused or used as templates.
- No new spend is approved. No vendor, host, model, identity provider, geocoder, search service or external API is selected or activated.
- All external education source families remain RESEARCH ONLY until source-specific rights, privacy, security and operational assessment and separate authorization.
- V2-DEC-006 is binding: Show Deeni Madaris defaults OFF; no sect/maslak discovery filters or inference; no public leakage on any surface or side channel.
- Anonymous-first discovery, low-bandwidth/text-first access, privacy minimization and minor safeguarding are mandatory architecture constraints.
- AI output is a proposal; high-impact factual decisions and publication require qualified human review.
- No participant research, user recruitment, pre-launch reviews, production access, data collection or public deployment is implied.

### 2.2 Architecture-to-planning traceability

| Accepted requirement / decision | M3-01 planning consequence | Later verification / gate |
|---|---|---|
| AR-001/002 anonymous public discovery and optional pathways | Keep public read journey independent of authentication; no account prerequisite | Anonymous journey and direct-search acceptance tests |
| AR-003 provider/institution/campus/programme distinction | First vertical slice must not collapse entity types | Synthetic identity/relationship fixtures; duplicate and branch tests |
| AR-005–007 evidence-backed facts and explicit missing/stale/disputed states | Data contracts and UI acceptance criteria must preserve uncertainty | Missingness, freshness, source attribution and conflict tests |
| AR-006 cycle-scoped programme/admission/fee facts | Avoid generic unscoped “current” admissions claims | Synthetic intake/campus scoping tests |
| AR-008 like-for-like comparison | No opaque universal institution score | Comparable-field and missing-value tests |
| AR-009 official application routes | No claim that V2 submits applications | Link ownership and destination-verification acceptance |
| AR-011 post-launch authenticated reviews | Exclude reviews from any early slice | No review collection or pre-launch recruitment |
| AR-012–015 privacy, source rights, AI proposal, lineage | Synthetic fixtures only; no external source retrieval or user PII | Deny-by-default source tests, data-minimization review, lineage and audit tests |
| AR-016–018 / V2-DEC-006 | Default-OFF Madaris policy applied across every public surface | Zero-exposure negative tests for query, counts, facets, maps, recommendations, sitemap, export, cache, APIs and direct IDs |
| AR-021–024 low bandwidth, accessibility, manual locality, degraded operation | No mandatory maps, precise geolocation or third-party service | Keyboard/accessibility, text-only, location-denial and outage tests |
| AR-023/025 audit, recovery, operational safety | Include auditability, backup/restore and incident design before release | Audit integrity, restore exercise and incident tabletop before production gate |
| G01–G20 | Each control must map to an implementation task, test, owner decision, legal/source gate or explicit deferral | No closure by omission; maintain control traceability |

### 2.3 Dependency graph

1. M3-00 closeout → M3-01 planning.
2. P01 baseline/traceability informs P02 scope, P05 gates and P06 tests.
3. P02 scope cannot be finalized until the owner chooses a bounded slice and its exclusions.
4. P03 named human accountability is required before implementation authorization.
5. P04 stack/hosting/cost evidence is required before any environment or service is selected or activated.
6. P05 applicable qualified legal/privacy/security/safeguarding reviews and source-specific approvals must precede affected processing or release.
7. P06 test/environment/release plan must match the chosen scope and approved stack.
8. P07 authorization request can be issued only after P02–P06 blockers are resolved or explicitly excluded from the authorized slice.
9. P08 owner decision must be explicit, dated and scope-specific. M3-01 closure does not itself authorize broader M3-02+ activities.

### 2.4 P01 unresolved items carried forward

- Human implementer, maintainer, QA, independent security reviewer, legal/privacy/safeguarding reviewers and operations owner are not named.
- The 10–15 hours/week baseline describes Product Owner planning availability only; it is not engineering capacity.
- Numeric spend ceiling and paid-service policy remain unapproved; no new spend.
- Stack, hosting provider/region, identity, search, map/geocoder and model vendors remain unselected.
- No source-specific access or reuse rights are established.
- No legal compliance, privacy impact assessment, security certification or safeguarding clearance is claimed.
- Provisional performance, availability, recovery, retention and operational targets remain unapproved until evidence and owner decisions.

## 3. P02 — first implementation slice options

### 3.1 Options considered

| Option | Description | Benefit | Main blocker / risk | Status |
|---|---|---|---|---|
| A — synthetic foundation only | Isolated V2 repository/application skeleton, CI and configuration boundary using synthetic fixtures | Smallest reversible learning scope; no external data dependency | Still needs named human implementer/reviewer, stack/environment decision and explicit authorization | Preferred candidate for further planning; NOT APPROVED |
| B — synthetic domain vertical slice | Option A plus a minimal provider/institution/campus/programme model, provenance/audit and internal review states, all synthetic | Tests core conceptual architecture earlier | Greater scope and database/physical-schema decision; human review and stack blockers | Not recommended as first authorized slice |
| C — public directory slice | Anonymous public search and profiles with published facts | Visible product value | Requires publication policy, real approved data, source rights, security, hosting and release controls | Not eligible now |
| D — source/AI ingestion slice | External source retrieval, extraction, entity matching or model-assisted processing | Potentially accelerates catalogue growth | Rights, source permissions, privacy/security, vendor, cost and human-review blockers; explicitly prohibited now | Excluded |

### 3.2 Candidate A proposed boundaries — for owner review only

**Potentially in scope after separate authorization:**
- Independent V2 application/repository foundation only.
- A reproducible local/CI build and documentation for configuration boundaries.
- Synthetic, fabricated fixtures clearly labelled as test-only and not representing real institutions or people.
- Automated documentation, static checks and tests that do not require external network access or paid services.
- Minimal smoke tests and CI evidence.

**Explicitly out of scope:**
- Real institution/provider data, source access, scraping, bulk downloads, outreach, permissions requests, connectors, crawlers, schedulers or ingestion.
- LLM/model activation, AI agents, geocoding, map tiles, search SaaS, analytics, messaging, identity SaaS or any third-party service activation.
- Physical production schema, migrations, production DB access, legacy V1 inspection beyond already authorized exclusion metadata, data transfer or integration.
- User accounts, reviews, moderation operations, student research, recruitment or collection of personal data.
- Hosting account, cloud environment, paid trial, subscription, procurement, contract or new spend.
- Public pages, deployment, pilot, launch, DNS or URL cutover.

Candidate A is not a commitment to a particular language, framework, database, host or vendor. Do not install packages, run a technical spike or create application code while the candidate remains unapproved.

### 3.3 P02 acceptance questions

The Product Owner must approve or reject the candidate and confirm exact inclusions/exclusions. If not approved, retain P02 as proposed and do not infer consent from “continue M3”.

## 4. P03–P05 readiness and blockers

| Gate | Required evidence / accountable person | Current state | Consequence |
|---|---|---|---|
| Implementation and maintenance | Named human implementer and maintainer; skill and availability evidence | Not assigned | No coding authorization |
| QA | Named test owner and review independence | Not assigned | No implementation authorization |
| Security | Qualified independent reviewer and review scope | Not assigned | No security clearance |
| Legal/privacy/safeguarding | Qualified reviewers for actual jurisdiction, data flows, age groups and vendors | Not assigned; assessments not performed | No affected personal-data processing or release |
| Operations | Named owner for environments, backups, incidents, monitoring and recovery | Not assigned | No environment/production approval |
| Capacity | Human delivery capacity and continuity plan | Unknown; owner planning baseline only | No delivery commitment |
| Stack | Evidence-based evaluation against accepted M2 requirements and human skill fit | Unselected | No stack install/spike |
| Hosting | Provider/region, data location/transfer, security, support, latency and restore evidence | Unselected | No account/trial/deployment |
| Budget | Cost model, taxes/FX, recurring/variable costs and explicit ceiling | No new spend; numeric ceiling pending | No paid service/procurement |
| Sources | Source-specific rights, method, purpose, retention, privacy and security approvals | Research only | No collection or reuse |
| AI/vendor | Data terms, retention, training, region, security, evaluation and cost limits | No vendor/model approved | No activation |

No role, review, clearance, vendor approval or budget is implied by ChatGPT assistance or owner availability.

## 5. P06 — synthetic-only test and release planning framework

### 5.1 Test layers

1. **Documentation and traceability:** links resolve; requirement/control-to-test mappings are present; decisions and statuses are internally consistent.
2. **Unit/domain tests (future authorized implementation):** provider/institution/campus/programme distinctions; effective dates; missing vs zero; source-native status retention; cycle scoping; identity merge/split review.
3. **Workflow tests:** evidence proposal → deterministic validation → human adjudication → publication decision; no AI-to-publication bypass; attributable actor/time/reason.
4. **Security tests:** deny-by-default authorization; least privilege; cross-role access; IDOR; audit integrity; secret redaction; no unsafe tool privileges.
5. **Privacy/safeguarding tests:** no unnecessary PII in fixtures/logs; anonymous discovery; no public minor profile; location denial; no adult-minor direct messaging in initial scope.
6. **Deeni Madaris negative tests:** with Show Deeni Madaris OFF, assert zero public exposure across search, direct IDs, browse, map pins, recommendations, counts, facets, sitemap, exports, caches and APIs. Include fail-closed behaviour if policy state cannot be read.
7. **Accessibility/resilience tests:** keyboard operation, semantic HTML, responsive layout, text-only/low-bandwidth path, optional service outage and graceful degradation.
8. **Operations/release tests:** reproducible build, protected PR checks, configuration separation, secret handling, backup/restore evidence, rollback and incident runbook.

### 5.2 Synthetic fixture rules

- Use fabricated names, identifiers, addresses, coordinates and programme details; do not mirror real people or source records.
- Label fixtures synthetic in file names and test metadata.
- Do not use copied production, V1 or public-source records.
- Do not include real contact details, CNIC/B-Form, student identifiers, personal addresses, health/disability data or sect/maslak fields.
- Test adversarial and conflicting examples using invented content only.
- Do not connect tests to external APIs, services, models or websites.

### 5.3 CI and merge controls

- Every future implementation PR must pass required project checks on its exact head SHA.
- Require review before merge; no direct push to protected main.
- Add automated unit, integration, accessibility, security and dependency checks only within the separately approved scope.
- Fail closed on missing secrets, missing authorization state, failed tests or unavailable policy configuration.
- Do not expose secrets or real personal/source data in logs or artifacts.
- Maintain reproducible test evidence and link it to requirement IDs, risks and decisions.
- CI success proves only the checks run; it is not legal approval, source permission, security certification or release authorization.

### 5.4 Environment and release boundary

No environment is selected or activated by this plan. After explicit authorization, any allowed environment must be non-production, isolated, synthetic-only, least-privilege and free of production/legacy credentials. No internet egress or external integration unless explicitly listed and approved in the authorization. Rollback must be defined for every stateful change; if no approved rollback exists, do not execute the change.

## 6. Stop conditions

Stop the affected work package immediately if:
- a task requires real source or production data not explicitly authorized;
- any source rights, privacy, safeguarding or security gate is unclear or fails;
- a vendor, paid API, cloud account or spend is required but not approved;
- named accountable human review is absent;
- a test exposes personal data, unauthorized access or Deeni Madaris leakage;
- CI, secret handling, isolation, backup or rollback evidence fails;
- scope expands beyond the exact owner-authorized work package.

Record the finding, preserve safe evidence, do not bypass the gate, and return for owner decision.

## 7. Current M3-01 authorization status

**NOT ISSUED.** Candidate A remains a planning proposal. No branch/environment has been approved for application implementation. The owner’s general direction to continue M3 is not an implementation-start authorization.

M3-01 can advance through documentation and decision preparation. P03–P05 remain hard blockers until the required human assignments and evidence exist. P07/P08 must remain open until the exact scope and all relevant preconditions are reviewed and the Product Owner issues a separate written authorization or explicitly decides to defer/refuse implementation.


## M3-01 AI-era architecture planning update — 2026-11-12

PR #124 added `../05-architecture/M3-01_AI_ERA_ARCHITECTURE_READINESS_REVIEW_2026-11-12.md`, defining AI-ARCH-01–20 and future acceptance tests. This strengthens P04 architecture/stack evidence and adds future security and test obligations to P05/P06. It does **not** select a stack, provider, host, vector database, queue or agent runtime; it does not close P04; and it does not authorize implementation or AI activation.

Required future verification includes provider replacement, AI-off resilience, evidence/citation grounding, bilingual retrieval quality, prompt-injection and tool-permission tests, publication integrity, Deeni Madaris zero-exposure across derived surfaces, privacy/log redaction, cost controls, portability and rollback. None has been executed by the planning review. Candidate A remains offline, synthetic-only and no-spend. P03 remains resolved only for that bounded planning model; P04/P05/P06 evidence and owner decisions remain outstanding; P07/P08 remain not ready. No M3-01 weighted progress is claimed and M3 remains at 5%.
