# M2-S07/S08/S09 Joint Architecture Validation — 2026-11-12

**Status:** Design-level review completed; owner acceptance is reserved for the final S10 decision.  
**Scope:** Cross-step consistency and risk review only; no execution or implementation.

## 1. Review method
Reviewed the S07 AI data-agent design, S08 identity/privacy/security design, S09 operations/recovery design against accepted S01-S06 baselines, M1 G01-G20 and V2-DEC-006. The review checks logical consistency, trust boundaries, failure handling, decision ownership and future verification obligations. It is not a penetration test, load test, legal opinion, vendor assessment or implementation test.

## 2. Cross-step invariants verified in the design
- Source rights authorization (S05) precedes all connector capture (S07); S07 remains disabled by default and has no autonomous source discovery/crawl authority.
- Captured content is untrusted data (S07); model output is typed proposal material only and cannot grant privileges, change source authorization or publish.
- Human adjudication and publication controls (S05/S07) align with S08 role separation; reviewers, publishers, moderators and administrators have distinct duties.
- Identity does not imply student status, attendance, institutional affiliation or review verification (S08).
- Anonymous discovery and manual locality remain available; maps, geocoding and AI are optional dependencies (S06/S08/S09).
- Public projections are derived only from approved publication state; caches and indexes must respect current eligibility, rights, privacy and Show Deeni Madaris configuration (S05/S06/S08/S09).
- V2-DEC-006 remains fail-closed and applies to all public surfaces and side channels; no sect/maslak filters.
- Backups and recovery preserve approved facts, authorization decisions, provenance and audit history; indexes/caches are rebuildable (S05/S09).
- Model/provider/hosting outages do not trigger unsafe substitution or weaken approval gates (S07/S09).

## 3. Threat and failure review
| Scenario | Required response | Design status |
|---|---|---|
| Prompt injection in a source document | Quarantine; treat as data; no tool privilege; reject unauthorized actions | Covered in S07 |
| Connector used outside approved source scope | Deny, log, alert; source authorization remains separate from connector config | Covered in S07/S05 |
| Model produces plausible unsupported fact | Evidence-span and deterministic validation fail; hold for human review | Covered in S07 |
| Entity merge affects multiple campuses/programmes | Require human adjudication and reversible history | Covered in S02/S07 |
| Reviewer approves own submission | Separate duties; deny self-approval for high-impact claims | Covered in S07/S08 |
| Fake-review campaign or provider retaliation | Rate limits, moderation, appeal, provider response labels and audit | Covered in S08 |
| Minor shares contact/location details | Minimize, redact/remove under policy, escalate safeguarding case | Covered in S08 |
| Show Deeni Madaris toggled OFF but stale cache remains | Fail closed, invalidate projections/caches, run zero-exposure suite | Binding S06/S08/S09 |
| Map, geocoder, search or AI outage | Manual locality/list fallback; queue or pause optional work | Covered in S06/S07/S09 |
| Backup succeeds but cannot restore | Treat as unverified until isolated timed restore and reconciliation | Covered in S09 |
| Hosting or model cost spikes | Hard budget/usage alerts and pause switch; no silent paid fallback | Covered in S07/S09 |

## 4. Operational and cost evidence limitations
No hosting account, provider quote, traffic telemetry, production workload, team skills inventory, model contract, data residency terms or procurement budget was supplied or authorized in this design phase. Consequently:
- no host, model, database, search engine, identity vendor or region is selected;
- no numeric SLO/RPO/RTO is approved;
- all S09 numeric values are provisional hypotheses requiring workload modelling, vendor quotes and restore/load tests;
- S07 evaluation metrics and cost caps must be calibrated with synthetic test sets and actual candidate-provider terms before activation.

This is a deliberate decision deferral, not an omitted decision. The decision register and S10 roadmap carry these gates forward.

## 5. Security/privacy/legal boundary
The design does not establish compliance with Pakistani or foreign law. Qualified legal review must assess actual data flows, minors, hosting, cross-border transfers, source terms, retention, reviews and provider contracts. Independent security testing is required before launch. No real student data, source documents, production credentials or live connectors were used.

## 6. Task completion disposition
- S07 T05 threat/cost/failure review: complete at design level; open model/cost/authorization decisions explicitly carried forward. S07 design tasks total 100%.
- S08 T05 security and cross-step review: complete at design level; legal, age assurance and operational moderation decisions carried forward. S08 design tasks total 100%.
- S09 T05 cost/operations review: complete at design level with explicit evidence limitations and decision gates. S09 design tasks total 100%.
- S10 T01-T04: integrated traceability, consistency/threat, ADR/risk disposition and conditional M3 roadmap drafted. T05 final owner acceptance remains pending.

## 7. Result
S07, S08 and S09 are **design-complete at 100% task completion**, pending their incorporation into the final M2 owner acceptance decision. S10 remains 80% until the owner explicitly accepts the integrated architecture. Weighted M2 draft progress is **98.6%**. No implementation, source access, connector/agent activation, procurement, production access, deployment or launch is authorized.
