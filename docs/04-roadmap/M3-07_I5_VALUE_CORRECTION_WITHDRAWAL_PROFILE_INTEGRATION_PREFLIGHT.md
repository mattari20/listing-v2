# M3-07 I5 — Value Correction, Withdrawal and Profile Integration Preflight

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `2d71c4e6d92bf9fa48ee80921778191e5b8dc739`  
**Depends on:** M3-07 D1-D5; merged I1-I4; M3-03 Agenda 9 claim-version lifecycle  
**Status:** **SCOPE/DESIGN PREFLIGHT COMPLETE — IMPLEMENTATION NOT AUTHORIZED**

## 1. Purpose and decision boundary

I5 is the fifth bounded M3-07 implementation package: **Value Correction, Withdrawal and Profile Integration**. This preflight reconciles the accepted design with the actual merged repository and defines the exact proposed implementation boundary, risks, acceptance criteria and owner decision required next.

This document authorizes and records repository-local documentation/design work only. It does not authorize application code, schema changes, migrations, database writes, public profile changes, search changes, deployment or live data operations. A separate explicit Product Owner authorization is required before I5 implementation begins.

I5 must reuse the existing claim, claim-version, evidence, editorial review, adjudication, publication, suppression, audit and outbox lifecycle. It must not create a second value store, evidence system, approval workflow or public data source.

## 2. Repository baseline and evidence reviewed

The preflight starts from the exact current `main` commit `2d71c4e6d92bf9fa48ee80921778191e5b8dc739`, which is the merged I4 documentation closeout (PR #211). The following current-main files and contracts were inspected:

- `M3-07_D1_FIELD_REGISTRY_CONTRACT.md`, D2 storage decision, D3 claim-service boundary, D4 synthetic pilot and D5 staged-package proposal.
- `M3-03_AGENDA_09_CLAIM_VERSION_LIFECYCLE_CORRECTION_AND_WITHDRAWAL.md` and its completion/evidence record.
- I3 implementation record and the merged I1-I4 implementation paths.
- `PersistedGovernanceWorkflowService`, `EditorialReviewService`, `FieldAwareClaimProposalService`, `TypedFieldValueValidator`, `PublicDirectoryQueryService`, the field-registry migrations and relevant synthetic tests.

Relevant merged foundations:

- I1 registry persistence and immutable read path — PR #198.
- I2 typed validation and applicability — PR #199.
- I3 provider-category and field-aware proposal/bypass guard — PR #203.
- I4 definition governance lifecycle — PR #210; documentation closeout PR #211.
- M3-03 Agenda 9 already provides human-gated immutable claim-version correction, disputed disposition and audited value withdrawal/snapshot suppression in its bounded synthetic scope.

No production, V1, Hostinger/hPanel or live database was accessed. No external source, real institution/student/applicant data, model/provider, API, connector, crawler or scheduler was used.

## 3. Existing behavior and concrete gaps

### 3.1 Claim correction exists, but registry binding is not preserved

`PersistedGovernanceWorkflowService::correctClaimVersion()` creates a successor `claim_versions` row, increments the version number, records `supersedes_version_id`, effective dates and correction reason, links eligible evidence and writes an audit event. It preserves the predecessor row and rejects a second successor.

**Observed gap:** the successor insert does not set `field_definition_version_id`. The I3 migration added this nullable binding for registry-managed claims, and I3 proposal creation populates it, but the generic correction path currently omits it. A correction of a registry-managed claim can therefore lose the exact definition-version binding that gives the value its type and meaning.

The correction path also does not itself invoke `TypedFieldValueValidator` or re-resolve the exact active/applicable definition version. Evidence status is checked, but a registry-aware correction must use the same field-aware validation and source-processing authorization boundary as a new field proposal.

**I5 requirement:** a corrected registry-managed value must create a new immutable successor claim version bound to an explicitly selected, exact, active and applicable field-definition version. By default it retains the predecessor's exact definition version. Changing to another definition version is permitted only through an explicit compatibility decision and must never silently reinterpret the old version. The successor must be typed-validated and re-enter independent editorial review/adjudication/publication.

Legacy non-registry predicates must retain their finite compatibility behavior; I5 must not broaden or weaken the generic claim-registration allowlist.

### 3.2 Value withdrawal exists; value restoration needs a distinct rule

`withdrawClaimVersion()` already requires a human capability, reason, rationale and idempotency key. It marks only the selected claim version withdrawn, updates dependent relationship projections, creates suppression records for its publication snapshots, marks snapshots/projections suppressed, queues suppression events and writes audit evidence. The withdrawal path also prevents a withdrawn version from being restored through the ordinary publication restoration path.

**I5 design decision:** withdrawal is value/version-specific, not field-wide and not entity-wide. It must not delete claim history, evidence, audit records or the field definition. A withdrawn value is not restored by changing the old version back to accepted or by removing its suppression. If the value is to return, a human must create a new successor claim version with fresh eligible evidence, typed validation and a new independent review/adjudication/publication cycle. The withdrawn predecessor remains withdrawn and historically traceable.

I5 must verify that stale pending publication events cannot resurrect a withdrawn or superseded version. It must also reconcile any associated open editorial case so the workflow cannot display an active review state for a withdrawn version.

### 3.3 Public profile assembly is currently legacy-allowlisted

`PublicDirectoryQueryService` reads only approved anonymous directory projections and applies useful safeguards: accepted claim disposition, approved publication decision, projected snapshot, no successor, no active suppression, current evidence/source-authorization checks, restricted-category exclusion and a fixed `PUBLIC_FIELDS` allowlist.

**Observed gap:** profile assembly currently uses a hard-coded legacy `PUBLIC_FIELDS` map. It does not join the claim version to its exact `field_definition_version_id` and does not use the registry's `visibility_class`, `searchable`, `filterable` or `sortable` policy for dynamic registry-managed facts. I3 intentionally stopped before adjudication/publication/projection; I4 governs definitions but does not integrate value lifecycle or profile rendering.

**I5 requirement:** retain the fixed legacy allowlist for existing legacy predicates, and add a separate registry-managed profile path. A registry-managed fact may appear only when its claim version has a valid exact definition binding, the predicate matches that definition's immutable field key, the value is accepted and currently publishable, an approved anonymous directory publication exists, the snapshot/projection is current and unsuppressed, evidence/source authorization remains eligible, and the exact definition version explicitly permits public visibility. Unknown, malformed, mismatched, internal, restricted or unbound registry fields fail closed.

The profile layer must use safe presentation metadata and typed formatting; it must never expose raw evidence, private metadata, arbitrary JSON keys, internal notes or unpublished assertions. Profile completeness must remain distinct from verification, confidence, recognition and approval.

### 3.4 Search/filter eligibility must remain separate from profile visibility

The current directory query searches values already admitted to the public fact list and has a separate locality-field set. I5 must not turn every public profile field into a search/facet/sort field.

A registry field is searchable, filterable or sortable only when the exact bound definition version explicitly enables that capability and a safe deterministic normalization/query contract exists. Internal/private values are never searchable. No arbitrary field key may become a SQL identifier or dynamic query fragment. A field can be visible on a profile but excluded from search and facets.

### 3.5 Schema and migration finding

The current schema already has the nullable `claim_versions.field_definition_version_id`, definition/version metadata, publication snapshots/projections, publication suppressions and governance outbox. The preflight has not identified a necessary new persistence table or migration for the proposed I5 behavior.

**Proposed default:** implement I5 through bounded service and profile-query changes plus synthetic tests, reusing current tables. If implementation proves that a new column/table, destructive data rewrite, backfill or non-disposable database operation is required, stop and seek a revised explicit authorization. Do not guess or backfill bindings for historical claims.

## 4. Proposed bounded I5 implementation scope

The following is the proposed implementation scope for a future, separately authorized I5 package.

### I5-A — Field-aware correction and successor lifecycle

- Add a field-aware correction boundary that resolves the predecessor claim/version and its exact field-definition binding.
- Reuse `TypedFieldValueValidator` and the same applicability, privacy, cardinality, temporal and evidence-policy rules used for new field proposals.
- Preserve the predecessor's exact definition-version binding by default; require an explicit compatibility decision for a new definition version.
- Recheck the definition, entity/provider applicability, predecessor currentness and evidence eligibility inside the transaction.
- Create a new immutable successor version with incremented version, lineage, effective dates, correction reason, exact definition binding and eligible evidence references.
- Re-enter the existing editorial review lifecycle. Correction never adjudicates or publishes by itself.
- Preserve idempotency, actor separation, audit/outbox atomicity and stale-predecessor publication denial.
- Keep legacy non-registry correction behavior bounded and regression-tested.

### I5-B — Value-specific withdrawal and controlled reinstatement

- Reuse the existing human-only withdrawal and suppression machinery; do not introduce a parallel withdrawal store.
- Ensure only the exact selected claim version and its dependent projections/snapshots are affected.
- Reconcile associated editorial review state and make suppression idempotent across already-suppressed snapshots.
- Verify queued approval/publication events cannot re-project withdrawn or superseded values.
- Preserve prior claim versions, evidence references and audit history; no hard deletion or evidence erasure is part of I5.
- Define reinstatement as a new successor claim version with fresh evidence and full review, not reversal of the withdrawn disposition or suppression record.
- Keep field retirement separate: retiring a definition stops new proposals according to policy but does not automatically withdraw every historical value.

### I5-C — Registry-aware public profile assembly

- Extend the existing public directory read boundary; do not add a separate public API, controller, route or admin UI in I5.
- Preserve the legacy fixed allowlist and its current safeguards.
- For registry-managed values, join through the claim version's exact definition-version ID and verify predicate/field-key identity.
- Require accepted/current claim version, approved human adjudication, approved anonymous publication, current projected snapshot, no active suppression and currently eligible evidence/source authorization.
- Require explicit public visibility on the exact definition version and a safe, bounded presentation contract.
- Keep profile display, search, filtering and sorting as independent permissions.
- Do not infer missing values as false, zero, empty or “not applicable”; do not equate profile completeness with verification.
- Keep historical interpretation attached to the exact definition version. A later definition version must not silently reinterpret or expose older claim versions.

## 5. Non-goals and binding exclusions

I5 does not authorize or include:

- Any real/source/provider/student/applicant/child/staff data or source retrieval.
- HEC, regulator or institution-site access, scraping, crawling, API calls or source-owner contact.
- AI/model/provider selection or activation, deterministic agent adapter, connectors, schedulers or background collection.
- New public routes, controllers, CRUD screens, admin UI, role/account provisioning or production publication.
- A new EAV store, arbitrary JSON profile, duplicate claim/evidence/adjudication/audit system or bulk legacy binding backfill.
- Search-engine deployment, new infrastructure, paid services, dependency upgrades or additional spend.
- Production, V1, Hostinger/hPanel, live database, deployment, public release or changes to environment/secrets.
- I6 or I7 implementation.

All verification must use fabricated fixtures and disposable local/CI databases. Existing Deeni Madaris default-OFF behavior remains unchanged.

## 6. Proposed synthetic acceptance matrix

A future I5 implementation is not acceptable unless the exact PR head passes all applicable checks below.

| ID | Acceptance requirement |
|---|---|
| I5-AC-01 | Registry-managed correction creates a successor; predecessor value/version remains unchanged. |
| I5-AC-02 | Successor retains the exact prior definition-version binding by default. |
| I5-AC-03 | Explicit definition-version change requires a compatible active version, exact applicability and a recorded decision; no silent remapping. |
| I5-AC-04 | Corrected value passes the same typed validator, privacy, scope, temporal and cardinality rules as a new proposal. |
| I5-AC-05 | Correction evidence is eligible and authorized for the defined synthetic purpose/method; no evidence content is fetched. |
| I5-AC-06 | Correction is idempotent; changed payload/actor reuse is rejected; stale or already-succeeded predecessors are rejected. |
| I5-AC-07 | Corrected claim re-enters editorial review; correction alone cannot adjudicate or publish. |
| I5-AC-08 | Legacy non-registry correction and finite generic predicate allowlist remain compatible. |
| I5-AC-09 | Withdrawal affects only the selected value/version and its dependent projections; unrelated values remain visible. |
| I5-AC-10 | Withdrawal creates durable audit/suppression/outbox evidence and is idempotent, including already-suppressed snapshots. |
| I5-AC-11 | Pending approval/publication events cannot resurrect withdrawn or superseded values. |
| I5-AC-12 | A withdrawn value can return only through a new successor proposal with fresh evidence and full review; the old version remains withdrawn. |
| I5-AC-13 | Registry-managed profile display requires exact binding, field-key match, accepted/current claim, approved anonymous publication, current unsuppressed projection and eligible evidence. |
| I5-AC-14 | Internal/restricted/unknown/unbound/malformed fields and raw evidence never appear in public profile output. |
| I5-AC-15 | Search/filter/sort flags are independently enforced; profile visibility does not imply search or facet eligibility. |
| I5-AC-16 | Definition-version changes do not reinterpret historical values; field retirement does not silently delete or withdraw them. |
| I5-AC-17 | Missing, unknown, not-applicable, pending, expired, disputed and withdrawn remain distinct from false, zero and empty. |
| I5-AC-18 | Existing public directory, search, locality, legacy profile and restricted-category tests remain green. |
| I5-AC-19 | Synthetic tests cover transaction rollback, idempotency, stale outbox events and projection rebuild/reconciliation. |
| I5-AC-20 | No real data, external network/API/model/connector/scheduler, production/V1/Hostinger, deployment or spend is used. |
| I5-AC-21 | Exact-head PHP 8.5 foundation CI, Project documentation validation and artifact hygiene pass. |
| I5-AC-22 | PR diff stays within the approved I5 file/touch-point boundary; any new schema requirement stops for approval. |

## 7. Proposed implementation touch-point boundary

Expected existing touch points, subject to fresh exact-main inspection after authorization:

- `app/Services/Governance/PersistedGovernanceWorkflowService.php` — exact definition binding on correction successor and existing withdrawal/suppression behavior.
- `app/Services/Directory/EditorialReviewService.php` — field-aware correction/review orchestration and editorial state reconciliation.
- `app/Services/Directory/FieldAwareClaimProposalService.php` and `TypedFieldValueValidator.php` — reuse validation/applicability/evidence policy; avoid duplicating policy.
- `app/Services/Directory/PublicDirectoryQueryService.php` — registry-aware profile assembly while preserving the legacy allowlist.
- Focused feature tests for field-aware correction, withdrawal, profile projection, search/privacy and existing regression behavior.
- A new I5 implementation record and narrowly scoped roadmap/index updates.

No migration is currently proposed. No existing migration may be edited. If the implementation requires additional persistence, changes to unrelated M3-03/M3-04 behavior, a new public route/UI, or any excluded touch point, stop and return a revised proposal.

## 8. Implementation sequence after separate authorization

1. Reconfirm `main` SHA, clean branch base, migration inventory and exact current service/test behavior.
2. Implement and test field-aware correction with exact version binding and review re-entry.
3. Harden value-specific withdrawal, editorial state reconciliation and stale-event non-resurrection.
4. Implement registry-aware profile assembly behind exact binding and public-visibility checks.
5. Add separate search/filter/sort enforcement tests; do not enable any new field for those capabilities by default.
6. Run focused tests, full synthetic suite, PHP formatting, Composer/dependency checks, Laravel bootstrap/routes, artifact hygiene and documentation validation.
7. Inspect the complete diff, run exact-head CI, reconcile review threads and prepare merge evidence.
8. Merge only after the exact approved scope and acceptance gates pass; update the implementation record and project trackers.

No I6 work begins automatically after I5. I6 and I7 remain separately gated.

## 9. Risks and stop conditions

Stop and seek a new explicit decision if:

- The current service contract cannot preserve exact definition binding without a broader claim lifecycle rewrite.
- A correction requires guessing field compatibility, source authorization or historical definition mapping.
- A profile field cannot be proven public-eligible from its exact definition version and publication decision.
- Search/filter behavior would expose a field not explicitly enabled for that capability.
- Pending outbox events can re-publish a withdrawn/superseded value and cannot be safely guarded within the approved scope.
- A new migration, backfill, new table, destructive rollback, public endpoint, real role provisioning or external service is required.
- Any test requires real/source data, production credentials or a non-disposable database.
- Any new dependency, paid service, hosting feature, deployment or spend is proposed.

## 10. Product Owner authorization required for implementation

The preflight recommends the bounded implementation described in Sections 4–8. The following statement is a decision template only; it is **not** implied by a general request to continue the roadmap or by acceptance of this preflight.

> I explicitly authorize only M3-07 I5 — Value Correction, Withdrawal and Profile Integration — in `mattari20/listing-v2`, from the then-current verified `main`, limited to the synthetic/local/CI implementation scope in the I5 preflight. This includes field-aware immutable correction with exact definition-version binding and re-review, value-specific withdrawal/suppression with safe new-successor reinstatement, and registry-aware allowlisted public profile assembly with separate search/filter/sort controls. Use existing persistence; additive schema work is not authorized unless separately approved. No legacy backfill, real/source data, source access, AI/model/provider, external API/connector/scheduler, UI/routes/API, role provisioning, production/V1/Hostinger, deployment, public release, new spend, I6/I7 or scope expansion is authorized. Any deviation requires a new explicit approval.

Record the authorization against the exact revision of this preflight and exact implementation base SHA before code changes.

## 11. Preflight disposition

**I5 scope/design preflight: COMPLETE.**  
**I5 application implementation: NOT STARTED / NOT AUTHORIZED.**  
**I6-I7: NOT AUTHORIZED.**  
**Live source and AI-agent activation gates G2-G9: remain blocked.**

The next valid step is Product Owner review and explicit authorization of the bounded I5 implementation scope above. No application code, schema, migration, test behavior or runtime has been changed by this preflight.
