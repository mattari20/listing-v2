# M3-01 Candidate A — Risk and Verification Matrix

**Status:** Detailed planning artifact; owner review required  
**Scope authority:** Candidate A approved for detailed planning only  
**Implementation authorization:** NOT ISSUED  
**Baseline:** `main` at `f016e714420553f5c90de0696208c78f2c31f721`

## 1. Purpose and boundary

This matrix makes the material risks, proposed verification evidence, stop conditions and unresolved decisions explicit for Candidate A: an independent V2 foundation using fabricated synthetic fixtures only.

It does not authorize code, technical spikes, package installation, environment activation, production/source access, database changes, external network integrations, procurement, spend, deployment, pilot or launch. It does not select a language, framework, database, hosting provider, region or vendor.

## 2. Risk register

| ID | Risk | Required preventive control | Proposed verification evidence | Owner / current disposition |
|---|---|---|---|---|
| CA-R01 | Legacy V1 contamination through code, schema, data, workflows, tests or operational patterns | Strict repository and artifact independence; no V1 imports or copied artifacts | Repository/dependency scan; explicit provenance review of every initial artifact | Human reviewer not assigned; open |
| CA-R02 | Synthetic fixtures resemble real institutions, people or records | Fabricated names, IDs, locations and attributes; fixture labels; no copied source records | Fixture review and automated prohibited-pattern checks | QA owner not assigned; open |
| CA-R03 | Secrets or credentials enter source, logs or artifacts | No secrets required for offline foundation; secret scanning and redaction if later approved | Secret-scan report; artifact/log inspection | Security reviewer not assigned; open |
| CA-R04 | Excessive CI token permissions or untrusted workflow execution | Least-privilege permissions; pin/approve actions; restrict write-capable contexts | Workflow permission review and negative permission tests | Security reviewer not assigned; open |
| CA-R05 | Unintended network egress or third-party service calls | Offline-by-default build and tests; explicit allowlist only after separate approval | Network-isolation test and dependency/network inventory | Technical owner not assigned; open |
| CA-R06 | Dependency supply-chain, license or maintenance risk | No stack/dependency selection until evidence review; minimize and pin approved dependencies | Dependency inventory, license review, vulnerability/support evidence | Implementer and reviewer not assigned; open |
| CA-R07 | Hosting, data location, recurring cost or vendor lock-in is implicitly committed | No hosting/provider/account/trial selection or activation in Candidate A planning | Decision record showing no provider selected; later evidence pack before any selection | Product Owner decision pending; no spend |
| CA-R08 | Planning scope expands into domain/product functionality | Enforce Candidate A boundary and exclusions; separate owner decision for scope change | PR scope review against this matrix and approved scope specification | Product Owner controls scope; open |
| CA-R09 | Deeni Madaris default-OFF control leaks through public or indirect surfaces | No real/public data or public surfaces in Candidate A; retain binding zero-exposure requirement for later work | Future negative tests across search, direct IDs, counts, facets, maps, recommendations, sitemap, exports, caches and APIs | Policy owner/reviewer not assigned; requirement binding |
| CA-R10 | Personal data, child data or safeguarding exposure | No real user/provider data, participant research, accounts or personal-data processing | Synthetic-only fixture audit; data-flow review before any later scope adds data | Qualified privacy/safeguarding reviewers not assigned; open |
| CA-R11 | CI success is mistaken for legal, privacy, source-rights or security clearance | State that automated checks prove only their tested assertions | Documentation consistency check; decision-gate review | Product Owner; open |
| CA-R12 | No accountable human can maintain, review, recover or operate the result | Name qualified implementer, maintainer, QA, independent security reviewer and operations owner before authorization | Named responsibility matrix, skills/availability evidence and continuity plan | Not assigned; blocking |

## 3. Proposed verification matrix

These are acceptance requirements for a future, separately authorized Candidate A implementation. They are not evidence that implementation or tests have occurred.

| Test ID | Verification objective | Expected result | Evidence required |
|---|---|---|---|
| CA-T01 | V2 independence | No V1 code, schema, data, workflow, dependency or operational artifact is imported | Repository and provenance review |
| CA-T02 | Reproducible offline build | Build succeeds from documented clean setup without external service dependency | Reproducible build log and CI run |
| CA-T03 | Synthetic-only fixtures | All fixtures are fabricated, labelled and free of real personal/source records | Fixture inventory and review |
| CA-T04 | Secret hygiene | No credentials or sensitive values in tracked files, logs or artifacts | Secret scan and artifact review |
| CA-T05 | Least-privilege CI | Workflow permissions are minimal and untrusted contexts cannot write | Permission review and negative tests |
| CA-T06 | Network isolation | Build and tests do not make unapproved external requests | Network policy/test evidence |
| CA-T07 | Dependency governance | Dependencies are explicitly selected, pinned and reviewed for support, vulnerabilities and licenses | Dependency and license report |
| CA-T08 | Fail-closed configuration | Missing/invalid authorization or required configuration stops execution safely | Negative configuration tests |
| CA-T09 | Requirement traceability | Each in-scope requirement maps to a test or an explicit, owner-accepted exclusion | Traceability report |
| CA-T10 | Deeni Madaris zero exposure | Any later public-surface test proves default-OFF produces zero exposure across all listed surfaces and side channels | Comprehensive negative test report; not applicable to a non-public foundation except as a retained invariant |
| CA-T11 | Accessibility and resilience | Any later user-facing surface meets the approved accessibility and degraded-mode criteria | Accessibility and resilience test evidence; no target is assumed approved here |
| CA-T12 | Reversibility and operations | Changes can be stopped/reverted; ownership, recovery and incident procedures are documented | Named operations owner, rollback/restore evidence and runbook review |

## 4. Mandatory stop conditions

Stop and return to the Product Owner before proceeding if any of the following occurs:

1. A proposed change imports, copies or depends on V1 artifacts or production data.
2. A fixture may contain or reproduce real personal, institutional or source data.
3. A secret, credential, unexpected network call or third-party service dependency is detected.
4. A proposed action requires a paid service, account, contract, procurement or new spend.
5. A proposed action touches production, a production database, a physical schema, migration, DNS or deployment.
6. A proposal adds public pages, domain workflows, real data, source collection, AI/model/agent activation, accounts, reviews or personal-data processing.
7. Any Deeni Madaris default-OFF control cannot be demonstrated or is weakened.
8. Required human implementer, reviewer, privacy/security/legal or operations accountability is absent.
9. Required validation fails, is missing, or does not correspond to the exact PR head.
10. Scope, authorization or expiry is ambiguous.

## 5. Decisions still required before P07 authorization can be prepared

| Decision | Current state | Required next evidence |
|---|---|---|
| P02 Candidate A detailed scope | Candidate A approved for detailed planning only; detailed scope and this matrix are planning artifacts | Product Owner acceptance of the complete bounded scope and exclusions |
| P03 human accountability | Blocked | Named human implementer, maintainer, QA, independent security reviewer, and operations owner; skills, availability and continuity |
| P04 stack, hosting and cost | Blocked; no stack/provider/region selected; no new spend | Evidence-based comparison, actual human skill fit, hosting/data-location/support/cost evidence, explicit owner decision |
| P05 legal/privacy/source/safeguarding/security | Blocked; no qualified reviews or source-specific clearance | Qualified reviewers, defined scope/data flows and recorded decisions; source rights only if a later scope requires sources |
| P06 environment/test/release | Framework and this risk matrix drafted; no environment selected or activated | Owner review, approved stack/scope, named test/release/operations accountability and scope-matched acceptance criteria |
| P07 authorization request | Not ready; NOT ISSUED | P02–P06 gates resolved or explicitly excluded with owner acceptance; exact activities, branch, environment, spend, tests, stop conditions and expiry |
| P08 final M3-01 decision | Pending | Explicit dated Product Owner decision; implementation authorization must be a separate explicit decision |

## 6. No-go statement

This matrix is planning evidence only. It does not clear any legal, privacy, safeguarding, security, source-rights, staffing, hosting, budget or operational gate. It does not authorize implementation. No code, technical spike, package installation, environment activation, external access, data collection, schema/migration, procurement, spend, deployment, pilot or launch is authorized.

**Implementation authorization: NOT ISSUED.**


## M3-01 AI-era risk and verification extension — 2026-11-12

The AI-era review adds cross-cutting risks that must be retained for any future AI-enabled scope. These risks do not expand Candidate A.

| ID | Risk | Required preventive control | Future verification | Current disposition |
|---|---|---|---|---|
| AI-R13 | Provider/model lock-in or provider outage | Stable internal capability contract; provider adapters; AI-off deterministic fallback; no silent substitution | Provider replacement and AI-off outage tests | Planning proposal; owner review pending |
| AI-R14 | Unsupported or stale generated factual claims | Evidence-grounded RAG; source authorization; citations, freshness and uncertainty; abstention | Citation resolution, freshness, contradiction and abstention suite | Planning proposal; owner review pending |
| AI-R15 | Prompt injection or malicious retrieved content | Treat retrieved content as untrusted data; enforce policy outside model; isolate instructions and evidence | Adversarial source/user tests | Planning proposal; owner review pending |
| AI-R16 | Agent/tool privilege escalation or arbitrary egress | Allowlisted tools, least privilege, deterministic authorization, parameter validation and bounded execution | Negative tool permission, destination and cross-scope tests | Planning proposal; owner review pending |
| AI-R17 | Sensitive/child/restricted data leakage to models or logs | No personal/child data to models by default; minimization, redaction and approved data-flow/terms review | Synthetic privacy and log/prompt inspection | Planning proposal; owner review pending |
| AI-R18 | AI publication bypass or false high-impact decisions | Proposal/quarantine state; human adjudication; no model-controlled publication | Workflow and audit tests proving no bypass | Planning proposal; owner review pending |
| AI-R19 | Hidden AI spend, quota exhaustion or poor observability | Usage/cost metering, quotas, alerts, hard limits and kill switch before activation | Usage accounting and hard-stop tests in an approved environment | Planning proposal; owner review pending |
| AI-R20 | Deeni Madaris leakage via semantic/vector/generated surfaces | Enforce policy before and after retrieval/indexing and across cache/API/export/tool paths | Zero-exposure negative tests across all derived surfaces | Binding policy; future verification pending |
| AI-R21 | Unportable canonical data or stale embeddings/prompts | Canonical records remain exportable; versioned/rebuildable indexes and provider exit plan | Export/rebuild/provider-exit exercise | Planning proposal; owner review pending |
| AI-R22 | Multilingual retrieval inequity or normalization errors | English/Urdu Unicode, RTL, script-variant and transliteration evaluation; human correction | Bilingual synthetic relevance and normalization suite | Planning proposal; owner review pending |
| AI-R23 | Unmaintained model/SDK/tool or unsafe interoperability server | Version inventory, lifecycle review, bounded gateway and explicit trust review | Dependency lifecycle and hostile-server tests | Planning proposal; owner review pending |

AI-specific tests are future obligations only. No model, agent, vector store, external tool, network egress or paid service is approved or activated by this matrix.
