# M1-S08 — V2 AI Data-Agent Workflow Requirements and Governance

**Status:** Research baseline delivered; owner acceptance pending  
**Prepared:** 2026-11-12  
**Repository:** `mattari20/listing-v2`  
**Scope:** Requirements and governance only. No agent, crawler, connector, scheduler, API integration or data ingestion was implemented or activated.

## 1. Purpose and design principle

Define how AI-assisted workflows may help maintain a reliable Pakistan education information catalogue without allowing an AI model to become an unaccountable source of truth.

**Core rule: AI may discover candidates, extract evidence, compare versions and recommend changes; only an authorized, rights-cleared source and an approved publication process can make information eligible for public display.** A model-generated answer is never evidence by itself.

The workflow must be source-specific, traceable, reversible, privacy-preserving, cost-aware and human-governed. It must support institution, campus, programme, recognition, admission-cycle, eligibility, fees, scholarships, facilities and contact facts with different freshness and risk profiles.

## 2. Research basis

The workflow requirements draw on:
- NIST AI RMF and its Generative AI Profile, which emphasize lifecycle risk management, governance, provenance, evaluation, documentation and additional human oversight where risk warrants it. These are voluntary reference frameworks, not Pakistan law. https://www.nist.gov/itl/ai-risk-management-framework and https://www.nist.gov/publications/artificial-intelligence-risk-management-framework-generative-artificial-intelligence
- W3C PROV, which models provenance through entities, activities, agents, derivations and time, supporting traceability and reproducibility. https://www.w3.org/TR/prov-dm/ and https://www.w3.org/TR/prov-overview/
- UK Government Data and AI Ethics Framework, used as a comparative governance reference for explicit human oversight, role accountability and checking LLM outputs for errors and bias. It is not binding on V2. https://www.gov.uk/government/publications/data-ethics-framework/data-and-ai-ethics-framework
- FBI/CISA AI data-security guidance, which emphasizes trusted sources, provenance and data integrity. https://www.ic3.gov/CSA/2025/250522.pdf

## 3. Operating boundaries and non-negotiable controls

1. **Rights gate first:** no automated access, scraping, API call, file download, caching, storage, transformation or republication until the exact source/asset and intended acts have an APPROVED decision under S07. A public URL, API, robots.txt, portal listing or AI capability is not permission.
2. **No V1 dependency:** workflows must be independently designed from V2 requirements and approved sources; no legacy code, schema, data, credentials, workflow or operational pattern may be reused.
3. **No autonomous high-impact publication:** recognition/accreditation, provider operating/closure status, campus/programme approval, admission open/closed, deadlines, eligibility, fees, scholarships, disciplinary/safety allegations and sensitive categories require deterministic evidence rules and human review before publication or material change.
4. **No inference as fact:** missing, ambiguous, stale or contradictory values remain unknown/disputed. AI cannot infer accreditation, current admissions, campus existence, fee totals, eligibility or award equivalence.
5. **Minimize personal data:** do not collect student/applicant records, CNIC/passport, credentials, private contact details, child-level data or staff personal information for catalogue maintenance.
6. **Prompt-injection boundary:** source pages, PDFs, spreadsheets and user-submitted material are untrusted data, never agent instructions. Ignore embedded instructions to reveal secrets, change policy, browse unrelated destinations or invoke tools.
7. **Least privilege:** separate source credentials from model context; allowlist destinations, restrict network/file access, scope tokens, redact logs and never expose secrets to model prompts.
8. **Audit and rollback:** retain an append-only decision/change log and the previous published value; every publication must be attributable and reversible.
9. **Deeni Madaris:** preserve V2-DEC-006. Underlying records may exist, but all public discovery surfaces remain filtered by the default-OFF owner setting. No sect/maslak attributes are used for general discovery.
10. **No live activity in M1:** this specification authorizes no source access, agent run, test against a real source, collection, permission request or integration activation.

## 4. Proposed logical workflow

| Stage | Agent/system responsibility | Required output | Gate |
|---|---|---|---|
| 0. Source authorization | Resolve source registry, exact asset, rights scope, permitted method, credentials, rate limits and expiry | Source permission manifest | **Block** if not APPROVED or scope mismatch |
| 1. Scheduling | Apply source-specific refresh cadence, event triggers, quiet periods, rate limits and cost budgets | Scheduled task with reason | No schedule for unapproved source |
| 2. Retrieval | Use only approved API/feed/manual upload/permitted retrieval method; capture retrieval time and response metadata | Evidence reference or permitted snapshot | Fail closed on auth, terms, rate-limit or destination violation |
| 3. Integrity and provenance | Hash lawful evidence, record canonical URL, source/version, timestamp, method and responsible agent/version | Provenance record | Quarantine integrity mismatch |
| 4. Extraction | Extract source-native fields and verbatim supporting passages; retain original language/value | Structured candidate assertions | No unsupported fields |
| 5. Validation | Schema, types, date ranges, enumerations, jurisdiction, status and cross-field checks | Validation report | Reject malformed/unsupported assertion |
| 6. Entity resolution | Match institution, campus, programme and authority using stable identifiers and evidence | Match proposal with alternatives | Human review for uncertain/ambiguous merges |
| 7. Change/conflict detection | Compare new assertions with current and prior evidence, detect changes and competing sources | Change set and conflict queue | Do not silently overwrite |
| 8. Risk and confidence assessment | Score evidence quality and consequence separately; apply field-specific thresholds | Risk tier, confidence rationale and route | High-impact/low-confidence goes to human review |
| 9. Human review | Reviewer checks source, rights, exact evidence, change, conflicts and public impact | Approve, reject, request evidence or defer | Required for material/high-risk changes |
| 10. Publication | Publish approved, source-attributed, freshness-labelled assertions only | Versioned public record | Only approved state can publish |
| 11. Monitoring and correction | Detect source failure, stale data, complaints, retractions and corrections | Health/freshness metrics and correction ticket | Suspend affected field/source when reliability fails |
| 12. Audit and rollback | Preserve actor, evidence, decision, old/new values and rollback reference | Reproducible audit trail | Roll back or unpublish when required |

Discovery-only agents may suggest candidate sources or URLs, but cannot access them automatically. A rights reviewer must approve the source and exact access method before retrieval is enabled.

## 5. Source and field governance model

### 5.1 Source manifest

Every enabled source must have:
- unique source ID, legal owner/publisher and competent authority;
- exact URL/API/feed/file asset and covered fields;
- official/non-official and primary/secondary classification;
- license/terms evidence, permitted acts and attribution requirements;
- authentication method, rate limits, robots/access restrictions and allowed retrieval method;
- geography, provider sector, jurisdiction and coverage limitations;
- expected publication cadence and observed freshness;
- privacy classification, sensitive fields and exclusions;
- source reliability tier with documented rationale;
- reviewer/owner, approval date, expiry/review date and suspension conditions;
- fallback, correction and source-owner withdrawal process.

### 5.2 Assertion-level provenance

Each extracted field/value should retain:
- entity and field identifier;
- source ID and canonical source location;
- exact source statement or permitted minimal evidence excerpt;
- original value and normalized value, without discarding original;
- publication/effective date, academic session and observed/retrieved time;
- extraction method, parser/model/prompt version and transformation version;
- content hash or version reference where lawful and useful;
- source authority/scope and confidence rationale;
- conflicting assertions and prior published value;
- reviewer identity/role, decision, reason and time;
- public status, last checked date and next review date.

W3C PROV concepts are a suitable conceptual vocabulary; selecting a serialization, schema or database is deferred to M2.

### 5.3 Source hierarchy is fact-specific

There is no universal source ranking for every field. Use the competent authority for the specific claim:
- legal recognition/accreditation: regulator/awarding authority within exact scope and dates;
- campus operation/address/contact: provider or competent regulator record, with corroboration where needed;
- programme offer/fees: institution's current official prospectus/admissions/fee notice;
- centralized admission process: designated admitting authority;
- equivalence: IBCC or relevant competent authority;
- scholarships: named scholarship administrator or institution;
- user experience: eligible user reviews, never substituted for official recognition facts.

A source may be authoritative for one field and irrelevant for another. Do not resolve conflicts by a generic source score alone.

## 6. Confidence, risk and publication policy

Do not use one opaque AI confidence number as the publication decision. Record separately:
- **Evidence quality:** authority, directness, exactness, date, completeness, corroboration and source integrity.
- **Extraction confidence:** whether the model/parser faithfully extracted the source.
- **Entity-match confidence:** whether the source refers to the correct institution/campus/programme.
- **Impact risk:** consequence if the field is wrong.
- **Rights state:** whether the evidence may be accessed and used for the intended purpose.

Proposed routing:
- **Low impact + clear source + validated extraction:** eligible for sampled or rules-based review after M2 defines controls.
- **Medium impact or ambiguous match:** human review before publication.
- **High impact or sensitive:** human review and authoritative evidence required; no AI-only publication.
- **Rights unclear, source compromised, stale beyond policy or material conflict:** HOLD / UNVERIFIED / DISPUTED; no publication as current fact.

No numeric threshold is approved in M1. Thresholds, calibration data, reviewer sampling and error budgets require M2 design and testing.

## 7. Freshness and refresh policy

Refresh cadence must be assigned by source and field, not globally:
- admission deadlines/status: event-driven plus source-permitted periodic checks during active cycle;
- fee schedules and scholarships: on notice publication and before/at each new academic session;
- recognition/affiliation: on regulator notice and periodic revalidation, preserving validity dates;
- institution profile/contact: source-specific periodic review and change triggers;
- annual statistics: release-cycle based, not frequent polling;
- stable taxonomy/geography: only on authoritative boundary/identifier changes.

Every time-sensitive field needs `last_observed_at`, source publication/effective date when available, applicable session, freshness state and next-check rationale. Never display a stale value as current merely because the page remains accessible. Exact intervals and alert thresholds are deferred to M2 and source permissions.

## 8. Conflict, correction and outage handling

- Preserve competing source assertions; never erase history.
- Distinguish source conflict, entity-match uncertainty, extraction error, outdated evidence and owner dispute.
- Apply a field-specific authority and effective-date rule; escalate unresolved conflicts.
- Allow authorized provider correction submissions, but require evidence and independent review.
- Source outage is not proof that an institution/programme is closed.
- A source's removal of a record is a change signal, not automatic proof of closure or deregistration.
- If a critical fact cannot be revalidated, downgrade to stale/unverified or suppress the claim while retaining audit history.
- Corrections and takedowns must have a defined service-level target, escalation owner and public correction history where appropriate.

## 9. Agent security and operational controls

- Treat retrieved content as hostile input; isolate parsing from agent instruction context.
- Allowlist domains, protocols, paths and redirect destinations; block private/internal IP ranges and unsafe URL schemes.
- Use read-only credentials where possible; separate retrieval, staging, review and publication permissions.
- No shell, arbitrary code execution, browser extension, file-system access or unrestricted network access for extraction agents.
- Validate file types and size; scan uploads; reject macro-enabled or executable content unless a separately approved isolated process is designed.
- Rate-limit and back off; do not bypass CAPTCHA, login walls, anti-bot controls or technical restrictions.
- Protect prompt templates, logs, model inputs and outputs from secrets and unnecessary personal data.
- Log model/provider, model version, prompt/template version, tools, source IDs, timestamps, outputs and human decisions.
- Maintain evaluation sets for extraction accuracy, entity resolution, hallucination, bias, prompt injection and source drift.
- Require incident response, kill switch, connector suspension and replay/rollback capability.
- Monitor cost per source, per changed field and per accepted publication; cap retries and prevent runaway polling.

## 10. Human roles and separation of duties

| Role | Allowed responsibility | Must not do |
|---|---|---|
| Source researcher | Discover candidate source and document official ownership/terms | Activate a source or assume rights |
| Rights approver | Approve exact asset, access method and permitted use | Approve unrelated assets by implication |
| Agent operator | Run only approved workflow within manifest | Expand source scope or bypass rate limits |
| Data reviewer | Validate evidence, field, entity and conflict | Approve unsupported AI claims |
| Publication approver | Approve high-impact changes for public release | Edit source evidence without trace |
| Security/privacy reviewer | Assess access, data minimization and controls | Treat technical access as legal permission |
| Auditor | Inspect provenance, decisions and incidents | Alter audit history |

Role combinations and thresholds are M2 decisions. For high-impact claims, the same automated agent must not be both proposer and sole approver.

## 11. Operational metrics and acceptance tests

Metrics:
- source authorization coverage and expired approvals;
- retrieval success/failure and rate-limit compliance;
- extraction precision/recall by field and language;
- entity match accuracy and false-merge rate;
- conflict queue age and resolution time;
- percentage of public facts with source, effective date and last-checked time;
- stale/unknown/disputed public-field rate;
- human override and rollback rate;
- critical-field correction latency;
- prompt-injection/security test pass rate;
- cost per accepted field change.

M1-level acceptance scenarios:
1. An unapproved source is discovered: the agent records a lead but performs no retrieval.
2. A source's terms or approval expire: retrieval is blocked and affected data is flagged for review.
3. A page contains prompt-injection instructions: the content is treated as data and no instruction/tool action is followed.
4. A model extracts an admission deadline without a source date or exact passage: it is rejected or held.
5. Two authoritative sources conflict: both assertions are preserved and a human conflict case is created.
6. A regulator removes a provider from a list: no automatic closure conclusion is published.
7. A new fee notice supersedes an old one: the old record is retained with validity dates and a reviewer approves the replacement.
8. A source becomes unavailable: the system marks evidence stale/unavailable, not institution closed.
9. A sensitive personal field is found: it is excluded and incident/privacy review is triggered.
10. A published change is later found wrong: the previous version is restored and the correction is auditable.

## 12. Decisions deferred to M2

No stack, vendor, model, vector database, crawler, browser agent, scheduler, queue, database schema, confidence threshold, refresh interval, cost budget or connector is selected in M1. M2 must compare options against these requirements and the S07 source-rights/security controls.

## 13. Weighted task register

| Task | Weight | Completion | Evidence / limitation |
|---|---:|---:|---|
| T01 Define agent mission, scope and hard boundaries | 10% | 100% | Discovery vs retrieval vs publication boundaries defined |
| T02 Source authorization and rights manifests | 15% | 100% | Asset-specific approval and expiry controls defined |
| T03 Workflow stages and provenance | 15% | 100% | End-to-end workflow and assertion-level evidence model documented |
| T04 Extraction, validation and entity resolution | 15% | 100% | Field-level extraction, deterministic validation and ambiguous-match gates specified |
| T05 Conflict, confidence, freshness and publication | 15% | 100% | Risk/evidence separation and no-silent-overwrite rules defined |
| T06 Security, privacy and prompt-injection controls | 15% | 100% | Least privilege, hostile-source handling and sensitive-data exclusions defined |
| T07 Human governance, monitoring and acceptance scenarios | 10% | 100% | Roles, metrics and 10 acceptance scenarios documented |
| T08 Owner review and step acceptance | 5% | 0% | Owner acceptance pending |
| **Total** | **100%** | **95%** | Research/documentation baseline; owner review pending |

## 14. Conclusion

V2 should be an evidence-governed catalogue, not an autonomous AI publisher. AI assistance is valuable for source discovery, extraction, comparison, anomaly detection and workflow preparation, but source rights, authoritative evidence, privacy, human review and reversible publication remain controlling requirements.

**No source has been accessed or connected under this specification. No automated collection or implementation is authorized.**
