# M3-07 I6 — Synthetic Agent Proposal Adapter Preflight

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `3f76f2758768ba331711de36bbc2dbe9b0aab17a`  
**Depends on:** M3-07 D1-D5; merged I1-I5; M3-03 claim/evidence/editorial/adjudication/publication governance  
**Status:** **SCOPE/DESIGN PREFLIGHT — COMPLETE; IMPLEMENTATION NOT AUTHORIZED**

## 1. Purpose and decision boundary

I6 is the sixth bounded M3-07 package: **Synthetic Agent Proposal Adapter**. Its purpose is to demonstrate one deterministic, offline, synthetic-only agent path that can prepare and submit a narrowly scoped institution-fact proposal into the existing human editorial-review workflow.

I6 is not a live AI agent, model integration, source connector, crawler, browser, retrieval workflow, scheduler or autonomous worker. The only adapter in scope is a deterministic fake backed by fabricated test fixtures. No model is selected or called.

This preflight records the current repository boundary, proposed architecture, exact touch-point limit, synthetic acceptance criteria and stop conditions. It authorizes documentation/design work only. A separate explicit Product Owner authorization is required before I6 application code or tests are changed.

## 2. Current-main baseline and evidence reviewed

The preflight starts from current `main` at `3f76f2758768ba331711de36bbc2dbe9b0aab17a`, the merged I5 documentation closeout (PR #217).

Inspected contracts and implementation include:

- M3-07 D1 field registry contract, D2 storage decision, D3 field-aware claim service boundary, D4 synthetic extensible-institution pilot, D5 staged implementation proposal and M3-07 readiness/work plan.
- M1-S08 AI Data-Agent workflow research and M2-S07 AI Data-Agent technical architecture.
- I3 `FieldAwareClaimProposalService`, `TypedFieldValueValidator`, `FieldDefinitionRegistryReader`, and `GovernanceCommandService`.
- `EditorialReviewService`, `GovernancePolicy`, `PersistedGovernanceWorkflowService`, and I5 correction/reinstatement/withdrawal integration.
- Existing feature tests for field-aware proposals, governance workflow, typed validation, editorial review and field-definition lifecycle.
- Existing migrations for core governance tables, evidence references, claim versions, editorial review cases, status history, audit and outbox.

## 3. Repository findings that constrain I6

### 3.1 Existing I3 proposal path

`FieldAwareClaimProposalService::propose()` currently:

- requires a human actor with `propose_field_value` and `submit_directory_proposal`;
- accepts only the exact synthetic processing context (`synthetic_test_only`, `fixture_reference`, `synthetic`);
- resolves an active exact field-definition version and governed provider category;
- enforces institution-level scope, typed/privacy/freshness validation, cardinality and evidence policy;
- requires existing metadata-only synthetic evidence references and a current source-authorization fixture for processing;
- writes a proposed claim version bound to the exact field-definition version, evidence links, an editorial review case, audit event and outbox event atomically;
- does not adjudicate or publish the proposal.

The existing `GovernanceCommandService` generic claim path rejects registry-managed and unknown predicates. I6 must preserve this bypass guard and must not create an alternate generic write path.

### 3.2 Existing editorial review boundary

`EditorialReviewService::submit()` and the subsequent review/adjudication/publication methods currently require human actors. Review requires a reviewer distinct from the proposal submitter and evidence submitters. Adjudication and publication have additional human separation-of-duties checks.

This is the principal integration gap for I6: D3 defines a narrow `submit_agent_field_proposal` capability, but the implemented I3 proposal and editorial submission entry points currently require human actors. I6 must add a dedicated agent-submission path without weakening the existing human-only path or any downstream review, adjudication, publication, correction or withdrawal method.

### 3.3 Existing persistence appears sufficient

The current schema already has:

- `editorial_review_cases.submitted_by_actor_id` (bounded string);
- `directory_status_history.actor_id` and `actor_class` (bounded strings);
- `audit_events.actor_class`, action, target and metadata;
- claim versions, evidence links, source authorization references and governance outbox.

The inspected migration definitions do not constrain `actor_class` to a human-only database enum. No new table or migration is currently proposed. The implementation preflight must verify the exact current schema and test this assumption again. If any new persistence, migration, backfill or schema alteration is required, stop and seek separate approval; do not add it under I6.

### 3.4 Existing scope limit

I3 currently accepts institution-level claims only. Campus and programme scopes are explicitly rejected by the existing proposal service. I6 therefore uses only an existing synthetic institution fixture and an already-active, institution-scoped field definition. Campus/programme proposals, taxonomy expansion and relationship resolution are out of scope.

## 4. Recommended I6 design

### 4.1 Deterministic fake adapter only

Add one `SyntheticAgentProposalAdapter` whose behavior is deterministic and offline. It maps a known synthetic fixture case to one bounded candidate assertion. It must not call a model, API, URL, parser, browser, filesystem source, external tool or network.

The adapter accepts a fixture identifier or typed synthetic fixture object, not a source URL, arbitrary source document, prompt, credential, model name or caller-supplied actor/capability list. It produces a strict, typed proposal envelope containing only:

- synthetic fixture case identifier;
- exact institution entity ID;
- exact field key and definition version;
- typed candidate value;
- pre-existing synthetic evidence-reference IDs;
- explicit validity dates where present in the fixture;
- deterministic idempotency key and fixture provenance identifier.

Unknown fields, action/tool instructions, URLs, raw source content, secrets, personal data, unbounded collections and unsupported value shapes are rejected. Instruction-like fixture text is treated only as inert test data and is never executed or elevated to policy.

### 4.2 One narrow submission capability

Use a server-assigned synthetic agent identity, for example `synthetic-agent-proposal-adapter-v1`, with actor class `agent` and exactly one capability: `submit_agent_field_proposal`.

The identity and capability are created inside the trusted adapter/submission service. They are not accepted from the adapter payload, test fixture, request caller or model output. The agent must not receive human capabilities such as `propose_field_value`, `submit_directory_proposal`, `review_directory_proposal`, `adjudicate_claim`, `authorize_publication`, `correct_claim`, `withdraw_claim`, `activate_field_definition` or `retire_field_definition`.

The adapter exposes one proposal-submission operation only. There is no generic agent command router, tool executor or arbitrary action dispatch.

### 4.3 Reuse I3 validation and persistence

The proposed submission path is:

1. Resolve the fixture identifier from a bounded synthetic fixture catalogue.
2. Create the fixed server-owned agent identity; reject caller-provided actor identity/capabilities.
3. Validate the envelope shape and fixture membership.
4. Call a dedicated I3 agent-proposal method that shares the existing field-aware validation, exact-version resolution, applicability, typed/privacy/freshness checks, evidence/source-authorization checks, cardinality, idempotency and transaction logic.
5. Persist only a proposed claim version, exact evidence links, a submitted editorial review case, audit event and identifier-only outbox event.
6. Return only opaque proposal/review identifiers and safe status/reason codes.

The existing human `propose()` method remains human-only. The new agent method must be a distinct, narrowly named entry point and must not accept an arbitrary actor object from an untrusted caller.

The editorial review integration adds a dedicated agent-submission operation for the fixed agent identity/capability. It must reuse the existing case/history/audit persistence. Existing human `submit()`, `startReview()`, `completeReview()`, `adjudicate()`, `approve()`, `suppress()`, `restore()` and all correction/withdrawal/definition-governance operations remain human-only and unchanged in authority.

### 4.4 Evidence and source boundary

I6 may reference only pre-existing, fabricated evidence fixtures. Each evidence reference must remain:

- `source_type = synthetic`;
- `content_included = false`;
- linked to an active synthetic source-authorization fixture;
- permitted for the exact synthetic processing context;
- eligible under the exact field definition's evidence policy.

The adapter cannot register evidence, fetch evidence, retrieve source material, follow URLs, create source permissions, change authorization scope or extend expiry. A public or official website is not an I6 fixture and is never accessed.

### 4.5 Human-review and publication boundary

An accepted agent proposal is only a `proposed` claim version with a `submitted` editorial review case. It is not a verified or accepted fact.

A human reviewer must be distinct from the fixed agent submitter and all evidence submitters. Existing human-only editorial review, adjudication, publication, correction, withdrawal, suppression and restoration controls remain mandatory. I6 must produce no adjudication decision, publication decision, public snapshot or public projection.

### 4.6 Denied action attempts and audit

D4 S17 requires attempted privileged actions to be denied and audited. I6 will test action-shaped or privilege-bearing synthetic adapter output for attempts to create/activate definitions, change taxonomy, review, adjudicate, publish, correct, withdraw, retire, restore or erase.

Such attempts must fail closed and produce only a metadata-minimal denial audit event with the fixed agent identity, bounded action/reason codes and idempotency reference. Do not log raw hostile text, source content, credentials, personal data or full candidate payloads. No privileged operation is invoked.

## 5. Proposed implementation touch-point boundary

Expected touch points, subject to a fresh exact-main inspection after implementation authorization:

**New files**
- `app/Services/Directory/SyntheticAgentProposalAdapter.php` — deterministic fixture-to-envelope adapter only.
- `app/Services/Directory/AgentFieldProposalSubmissionService.php` — fixed agent identity, narrow submission capability and safe orchestration.
- `tests/Feature/SyntheticAgentProposalAdapterTest.php` — synthetic end-to-end proposal and denial tests.
- `docs/04-roadmap/M3-07_I6_IMPLEMENTATION_RECORD.md` — delivery evidence after implementation.

**Existing files proposed for narrowly bounded changes**
- `app/Services/Directory/FieldAwareClaimProposalService.php` — dedicated agent submission entry point sharing the existing I3 validation/persistence path; retain the existing human-only method.
- `app/Services/Directory/EditorialReviewService.php` — dedicated agent case-submission path; all review/adjudication/publication methods remain human-only.
- `tests/Feature/FieldAwareClaimProposalTest.php` only if a focused regression is needed for the unchanged human path; prefer the new I6 test file for new scenarios.

No other application files are pre-approved. If the exact design requires changing `GovernancePolicy`, generic governance registration, migrations, models, public directory/query/projection code, definition governance, correction/withdrawal behavior or unrelated M3-03/M3-04 services, stop and present the precise reason and revised touch-point proposal for approval.

No migration, new table, schema change, backfill, dependency or Composer change is proposed.

## 6. Synthetic acceptance criteria

| ID | Acceptance requirement |
|---|---|
| I6-AC-01 | Same fixture and version produce the same normalized proposal envelope; no random or wall-clock-dependent candidate content. |
| I6-AC-02 | Adapter accepts only a known synthetic fixture identifier/object; unknown fixture IDs fail closed. |
| I6-AC-03 | Strict envelope schema rejects extra fields, tool/action instructions, URLs, raw source content, secrets, personal data and unsupported shapes. |
| I6-AC-04 | No external model, provider, API, network, source retrieval, browser, parser, connector, scheduler or filesystem source is called. |
| I6-AC-05 | Agent identity is fixed server-side, actor class is `agent`, and its only capability is `submit_agent_field_proposal`; caller-supplied actor/capabilities are ignored or rejected. |
| I6-AC-06 | Existing human I3 proposal method remains human-only and its capability contract is unchanged. |
| I6-AC-07 | Agent submission reuses exact active field version, institution scope, provider-category applicability, typed validation, privacy, freshness and cardinality rules. |
| I6-AC-08 | Only pre-existing metadata-only synthetic evidence references with current synthetic processing authorization can support a proposal. |
| I6-AC-09 | Valid submission creates one proposed claim version bound to the exact definition version, exact evidence links, submitted review case, audit and outbox records atomically. |
| I6-AC-10 | Idempotent retry returns the same proposal; reuse of the key with a different fixture, actor or payload is rejected. |
| I6-AC-11 | The editorial case records the fixed agent submitter identity and agent actor class in the status/audit history. |
| I6-AC-12 | A human reviewer distinct from the agent submitter and evidence submitters can start/complete review; agent review attempts fail. |
| I6-AC-13 | Agent cannot create/activate/retire field definitions, change taxonomy, edit/correct/withdraw/reinstate values, review, adjudicate, publish, suppress, restore or erase. |
| I6-AC-14 | D4 S17 privilege/action attempts fail closed and emit bounded denial audit metadata without storing hostile payload content. |
| I6-AC-15 | No adjudication decision, publication decision, snapshot or public projection is created by I6. |
| I6-AC-16 | Generic claim registration still rejects registry-managed and unknown predicates; no bypass or alternate value store is introduced. |
| I6-AC-17 | Restricted Deeni Madaris category remains default-OFF and cannot be made public or inferred by the adapter. |
| I6-AC-18 | Existing I1-I5 governance, correction, withdrawal, profile, search and legacy regression suites remain green. |
| I6-AC-19 | No migration, schema change, backfill, dependency, Composer change, route, controller, UI, queue, scheduler or production configuration is added. |
| I6-AC-20 | Exact-head PHP 8.5 FND-01 CI, Project documentation validation and artifact hygiene pass. |
| I6-AC-21 | PR diff contains only the approved I6 files and documented justifications; no unresolved review threads remain. |
| I6-AC-22 | Implementation record captures exact base/head, files, test commands/results, CI run IDs, merge SHA, limitations and any deviations. |

## 7. Validation plan after separate authorization

1. Reconfirm current `main` SHA, branch cleanliness and exact service/migration/test contents.
2. Implement the deterministic fixture adapter and narrow agent submission service only.
3. Add the dedicated agent path to I3 and editorial case submission without broadening existing human paths.
4. Run focused tests for valid/invalid fixture, exact field binding, authorization, idempotency, audit/outbox atomicity, human review separation and denied privileged actions.
5. Run the full existing synthetic suite and verify I1-I5 regressions.
6. Run the existing repository checks without modifying Composer scripts: `composer validate --strict`, `composer audit --locked`, `vendor/bin/pint --test`, Laravel bootstrap/route validation and `php artisan test` using disposable SQLite `:memory:`.
7. Run exact-head FND-01 PHP 8.5 foundation CI and Project documentation validation.
8. Review the full diff, changed-file list, check runs, comments and mergeability; merge only after every acceptance gate passes.
9. Record implementation and update project trackers. I7 remains a separate agenda and is not included in I6.

## 8. Non-goals and binding exclusions

I6 does not include:

- any live or hosted AI model/provider, prompt service, model account, credential or inference;
- any real source, institution, provider, student, applicant, child or staff data;
- source browsing, retrieval, scraping, downloads, OCR, parsing of real documents, owner contact or permission requests;
- source manifest approval or changes to source authorization;
- generic autonomous agent framework, tool execution, shell, browser, arbitrary code, connectors, queues, workers, cron or scheduler;
- campus/programme scope expansion, identity merge, provider taxonomy changes or bulk proposal batches;
- automatic review, adjudication, approval, publication, correction, withdrawal, restoration or definition lifecycle;
- new database tables, migrations, backfills, dependencies, Composer changes or infrastructure;
- public routes/API/UI, real role provisioning, production, V1, Hostinger/hPanel, deployment, release, procurement or spend.

G2-G9 remain conjunctive blocking gates for real source access and live agent activation. Completion of I6 does not approve or activate any live source/model/agent.

## 9. Stop conditions

Stop and seek a new explicit decision if:

- a live model/provider, external API, network or real source is needed to demonstrate the adapter;
- the adapter requires raw evidence content or a fetchable URL rather than a pre-existing synthetic reference;
- an agent submission requires bypassing or weakening field-aware validation, source authorization, evidence eligibility, human review or publication gates;
- a generic agent actor/capability input, generic command router or privilege escalation surface is required;
- existing persistence cannot record the agent submitter safely without schema change;
- any migration, backfill, dependency, Composer change, route/UI, scheduler, queue or new service is required beyond the approved touch-point boundary;
- a campus/programme or taxonomy change is needed;
- any real data, production/V1/Hostinger, deployment, procurement or spend is proposed.

Do not resolve a stop condition by impersonating a human, granting broad capabilities, weakening human separation or silently expanding I6.

## 10. Product Owner authorization required for implementation

The following is a decision template only. It is not implied by a general request to continue the roadmap or by completion of this preflight.

> I explicitly authorize only M3-07 I6 — Synthetic Agent Proposal Adapter — in `mattari20/listing-v2`, from the then-current verified `main`, limited to the deterministic offline synthetic fixture adapter, fixed server-owned agent identity with only `submit_agent_field_proposal`, the dedicated I3 field-aware agent submission path, the dedicated editorial case-submission path, metadata-minimal denied-action audit, synthetic-only tests and the I6 implementation record described in this preflight. Existing human proposal, review, adjudication, publication, correction, withdrawal, restoration and field-definition governance controls must remain unchanged in authority. No migrations/schema changes, backfills, dependencies, Composer changes, routes/UI, campus/programme expansion, real/source data, source access, live AI/model/provider, external APIs/connectors/schedulers, production/V1/Hostinger, deployment, release, procurement, spend, I7 or scope expansion is authorized. Any deviation requires a new explicit approval.

## 11. Preflight disposition

**I6 scope/design preflight: COMPLETE.**  
**I6 application implementation: NOT AUTHORIZED / NOT STARTED.**  
**I7: separately gated.**  
**G2-G9: remain blocked for live source access and agent activation.**

No application code, schema, migration, test behavior, database, source, model/provider, production environment or runtime has been changed by this preflight.
