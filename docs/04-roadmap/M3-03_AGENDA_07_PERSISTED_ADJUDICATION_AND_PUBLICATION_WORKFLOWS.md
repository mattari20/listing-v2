# M3-03 Agenda 7 — Persisted Adjudication and Publication Workflows

**Date:** 2026-11-13  
**Repository:** `mattari20/listing-v2`  
**Status:** COMPLETED for bounded authorized local/CI synthetic implementation  
**Authorization:** Product Owner explicitly authorized Agenda 7 in the current conversation.

## 1. Scope and boundaries

Implement persisted, local/CI-only governance workflows using synthetic fixtures and the existing SQLite `:memory:` test configuration. Extend the eight-table Agenda 4 foundation additively. No public HTTP route, production integration, source acquisition, real data, role provisioning or external delivery service is included.

## 2. Delivered implementation candidate

- Additive schema for adjudication cases, append-only adjudication decisions, appeal/reconsideration lineage, publication decisions, immutable snapshot payloads and SHA-256 digests, public-projection state, transactional outbox, suppression records and restoration records.
- Human adjudication service with capability gate, evidence admissibility checks, submitter/adjudicator separation, rationale and policy-version capture, case locking, decision history and same-transaction audit.
- Human publication approval requiring an accepted decision for the same claim version, current claim disposition, no successor version, admissible evidence, distinct adjudicator/evidence submitter/publisher, and source-specific publication scope.
- Snapshot payload and outbox intent created atomically with the publication decision. Snapshot payload is not overwritten by projection processing; successive publications for distinct surfaces/audiences receive monotonically increasing per-claim snapshot versions.
- Idempotency replay returns the original adjudication/publication decision only when the complete command identity and relevant fields match; changed case lineage, decision, surface, audience or policy under the same key is rejected.
- Outbox processing is idempotent at projection-key level. Suppression updates authoritative snapshot and any existing projection synchronously before outbox cleanup.
- Source-authorization revocation quarantines dependent evidence and suppresses all dependent snapshots/projections in the same transaction.
- Restoration is human-only, requires a distinct actor from the suppressor, and rechecks claim/evidence eligibility before queuing projection restoration.
- Synthetic tests cover workflow tables, adjudication and appeal lineage, publication snapshot integrity, outbox idempotency, suppression/restoration, source revocation, automated-actor denial, changed-command idempotency and multiple publication surfaces. New PHP files conform to the repository Pint formatter.

## 3. Separation-of-duties feasibility and approval gates

The implementation enforces capability boundaries and distinct actor IDs supplied by synthetic test actors. It deliberately does not create real accounts, assign actual staff, infer role eligibility or assert that a single operator can satisfy incompatible controls.

Before real workflows, source handling or any public surface, the Product Owner must approve a named role/permission matrix covering source authorization, acquisition, validation, adjudication, publication, suppression, restoration, administration, delegation, dual control, emergency/break-glass review and absence/recusal coverage. If staffing cannot satisfy separation, high-impact actions remain unavailable; no automatic self-approval or unreviewed compensating control is assumed.

## 4. Technical safeguards and limitations

- State transition, audit event and outbox intent are written in the same database transaction for the implemented commands.
- Publication snapshots retain immutable payload/digest fields; mutable lifecycle status is tracked separately.
- No public read endpoint consumes the projection table. The table is an internal synthetic projection target only.
- No concrete queue broker, scheduler, cache, search index, external publisher, retry/dead-letter operator or operational reconciliation UI is configured.
- Outbox processing is a deterministic synchronous test seam, not production queue delivery. Runtime concurrency, worker crash recovery and delayed external projection behavior require additional verification.
- Source revocation and emergency suppression freeze internal projection rows immediately; no real downstream systems exist to verify.
- Retention/deletion, audit tamper-evidence, specialist legal/privacy/source-rights/safeguarding/security review, and real human coverage remain open.
- Deeni Madaris remains default-OFF; no category enablement or public exposure is authorized.

## 5. Acceptance evidence

PR [#163](https://github.com/mattari20/listing-v2/pull/163) merged as `a16d6564e5f5190a841c5596ddb47638d1ec735c` from exact validated head `ede649e53878facd8906e19b6a57e2d5019caaed`.

- PHP 8.5 foundation CI run #111 (`43458056872`): **success**, all configured steps passed.
- Project documentation validation run #430 (`43458057006`): **success**.
- Synthetic tests: 137 assertions, no failures; 32 existing missing-local-`.env` warnings. No `.env` or database artifact was added.
- No unresolved review threads; exact-head rechecked before squash merge.
- Full closeout and evidence: `M3-03_AGENDA_07_COMPLETION_AND_EVIDENCE_RECORD.md`.

## 6. Exclusions

No V1, Hostinger, hPanel, production/live database, real/source/institute/student/child/staff data, source retrieval, scraping, external API/AI, public endpoint, deployment, procurement, new spend, role provisioning or GitHub ruleset/protection change. No legal compliance, source reuse permission, public launch or production readiness is claimed.

## 7. Agenda disposition

**Agenda 7:** **COMPLETED** for the bounded authorized local/CI synthetic implementation and validation scope.  
**M3-03 overall:** remains **IN PROGRESS**; no whole-step completion percentage is claimed.  
**Remaining gates:** production queue/recovery, real human coverage and role/permission matrix, retention/deletion, specialist legal/privacy/source-rights/safeguarding/security review, public projection/read surface and deployment each remain separate work requiring explicit authorization.
