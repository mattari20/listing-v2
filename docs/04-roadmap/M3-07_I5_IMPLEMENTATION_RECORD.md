# M3-07 I5 — Value Correction, Withdrawal and Profile Integration Implementation Record

**Repository:** `mattari20/listing-v2`  
**Status:** I5-A, I5-B and I5-C delivered, merged and exact-head CI validated  
**Owner authorization:** Product Owner authorized the bounded I5-A through I5-C implementation and closeout on 2026-11-16  
**Final main commit:** `304fce61641471c6b0afdfd8b9efff27ff21955e`

## 1. Scope delivered

I5 completes the bounded value lifecycle and registry-aware public profile integration described in the [I5 preflight](M3-07_I5_VALUE_CORRECTION_WITHDRAWAL_PROFILE_INTEGRATION_PREFLIGHT.md).

The implementation is limited to synthetic/local/CI behavior and existing persistence. It does not enable live source collection, external AI, an agent, connectors, schedulers or production operations.

### I5-A — Field-aware correction

Delivered in [PR #213](https://github.com/mattari20/listing-v2/pull/213).

- Adds a registry-aware correction orchestration service for institution claims bound to a field definition version.
- Requires the exact predecessor `field_definition_version_id` and matching predicate/field key; it cannot silently rebind a claim to a different definition version.
- Reuses typed value validation, applicability, cardinality, privacy and synthetic evidence authorization checks.
- Delegates immutable successor persistence to the existing governance workflow.
- Preserves the predecessor version and routes the successor into a new human editorial review case.
- Uses idempotent correction and editorial-review submission keys.
- Legacy unbound correction behavior remains separate; a legacy claim cannot be rebound through this field-aware path.

### I5-B — Withdrawal and controlled reinstatement

Delivered in [PR #214](https://github.com/mattari20/listing-v2/pull/214).

- Reconciles every editorial review case attached to a withdrawn claim version to an explicit `withdrawn` state, with status history and audit evidence.
- Reuses an existing active publication suppression instead of creating duplicates, while ensuring the snapshot and any projection remain suppressed.
- Prevents stale publication and field-proposal outbox events from reviving withdrawn or superseded values.
- Adds field-aware reinstatement only as a new successor version of the withdrawn predecessor.
- Requires the exact original field-definition version, fresh eligible metadata-only synthetic evidence not previously linked to that claim history, typed validation and a new editorial review case.
- Reinstatement does not restore or publish a projection; the successor remains proposed pending human review and a separate adjudication/publication cycle.

### I5-C — Registry-aware public profile integration

Delivered in [PR #215](https://github.com/mattari20/listing-v2/pull/215), with historical-version regression coverage in [PR #216](https://github.com/mattari20/listing-v2/pull/216).

- Retains the finite legacy `PUBLIC_FIELDS` allowlist for unbound legacy claim versions.
- Adds a separate registry-managed profile path joined through the exact `claim_versions.field_definition_version_id`.
- Requires exact definition-version identity, matching predicate/field key, `public_eligible` visibility and `public_eligible` privacy, plus safe presentation metadata.
- Unknown, malformed, mismatched, restricted, internal, unbound dynamic and unsupported compound values fail closed.
- Uses bounded scalar formatting and safe public labels/sections; URLs are rendered only when they pass the existing HTTP(S) safety check.
- Enforces `searchable`, `filterable` and `sortable` independently. Profile visibility alone grants none of those capabilities.
- Keeps the existing approved anonymous projection, evidence, source-authorization, suppression, supersession and Deeni Madaris exclusion checks.
- Uses the exact historical definition version attached to a claim; a newer definition version cannot reinterpret an older claim. Retiring the original definition version does not silently hide an already-approved public fact.

## 2. Merge and exact-head CI evidence

Every implementation PR was merged only after exact-head PHP 8.5 foundation CI and Project documentation validation passed.

| Slice | PR / merge commit | Exact PR head | PHP 8.5 FND-01 CI | Documentation validation | Synthetic suite |
|---|---|---|---|---|---|
| I5-A | [#213](https://github.com/mattari20/listing-v2/pull/213) — `6988c972ce0caa2a571f822fd51dfd5cc48fd3ae` | `2c0426c234708d79bb7c221d9e0314647db160da` | [#43827732139](https://github.com/mattari20/listing-v2/actions/runs/43827732139) — success | #43827732147 — success | 15 passed; 602 assertions; 150 non-fatal test-harness warnings |
| I5-B | [#214](https://github.com/mattari20/listing-v2/pull/214) — `fa5695b594704df0847c6578ea3e9857a522f6b4` | `8daa1057eb76b71384171c49d52963babc7438d7` | [#43828931673](https://github.com/mattari20/listing-v2/actions/runs/43828931673) — success | #43828931770 — success | 15 passed; 623 assertions; 154 non-fatal test-harness warnings |
| I5-C | [#215](https://github.com/mattari20/listing-v2/pull/215) — `570c8b8e8ef2bcac8142a03ec2f90198d3ffc307` | `0c14a0edaad4ce8a9522fb1152b42e0145d4e3e5` | [#43829934934](https://github.com/mattari20/listing-v2/actions/runs/43829934934) — success | #43829934803 — success | 15 passed; 645 assertions; 157 non-fatal test-harness warnings |
| I5-C historical definition regression | [#216](https://github.com/mattari20/listing-v2/pull/216) — `304fce61641471c6b0afdfd8b9efff27ff21955e` | `4c9ea82355a9fdc46d86e56a5358ad3e220c9ea7` | [#43830429377](https://github.com/mattari20/listing-v2/actions/runs/43830429377) — success | #43830429327 — success | 15 passed; 647 assertions; 157 non-fatal test-harness warnings |

The warning counts are non-fatal missing-local-`.env` test-harness warnings; they are not test failures. The final exact-head run passed formatting, dependency advisory checks, Laravel bootstrap/routes, the synthetic-only suite and repository artifact hygiene.

## 3. Acceptance disposition

| Acceptance area | Result |
|---|---|
| Exact field-definition binding preserved on correction successors | Delivered and tested |
| Typed correction validation, applicability and cardinality | Delivered and tested |
| Immutable predecessor history and new editorial review on correction | Delivered and tested |
| Value-specific withdrawal and editorial-case reconciliation | Delivered and tested |
| Idempotent suppression for already-suppressed snapshots | Delivered and tested |
| Stale publication/proposal outbox events cannot revive withdrawn values | Delivered and tested |
| Reinstatement is a new successor with fresh evidence and new review | Delivered and tested |
| Public profile uses exact definition-version visibility/privacy | Delivered and tested |
| Legacy allowlist remains intact | Delivered and regression-tested |
| Search, filter and sort flags remain independent | Delivered and tested |
| Retired historical definition remains exact; newer private version cannot reinterpret it | Delivered and tested in PR #216 |
| No schema/migration/backfill or new dependency | Confirmed by PR file scopes |
| Synthetic-only, exact-head CI and documentation validation | Passed for all four PR heads |

### Deliberate limitations

- The I5 correction/reinstatement path retains the exact original field-definition version. Rebinding to another definition version is not supported; any future compatibility migration requires a separate explicit decision and evidence.
- Public registry profiles currently render only bounded supported scalar types. Compound/unknown value types fail closed rather than being serialized as raw JSON.
- The optional filter/sort service contract does not add public routes, controller parameters or UI controls.
- I5 does not authorize source ingestion, live AI extraction, automatic publication or any new public-data collection.

## 4. Non-interference and exclusions

No migrations, schema changes, database backfills, guessed historical data, new dependencies, routes/controllers/UI, real/source/provider/student/applicant data, external URLs/APIs/models/providers/connectors/schedulers, production/V1/Hostinger/hPanel operations, deployment, release, procurement or spend were performed.

The existing Deeni Madaris default-OFF and fail-closed behavior remains unchanged. Public projections continue to require the existing human adjudication/publication and source/evidence eligibility chain.

## 5. I5 closeout and next gate

**I5-A, I5-B and I5-C are delivered, merged and CI validated. I5 is closed as a bounded synthetic/local/CI implementation agenda.**

This closeout does not mark the full M3-07 AI Data-Agent step complete. GOV-04 and other candidate sources remain research-only; G2-G9 rights, privacy, security, model/provider, operational and activation gates remain blocking. No agent, model, connector, scheduler or live source access is enabled.

I6 and I7 remain separate agendas and are not authorized by I5 completion. The next step is an I6 scope/design preflight against the current main branch, followed by a separate implementation authorization if required by its documented gate.
