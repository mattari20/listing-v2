# M3-07 I6 — Synthetic Agent Proposal Adapter Implementation Record

**Date:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Implementation base:** `2d9e1c15df808c5e4679e0cd2d63d4fb98be2246`  
**Implementation branch:** `feature/m3-07-i6-synthetic-agent-proposal`  
**Pull request:** [#220 — feat(m3-07-i6): add synthetic agent proposal adapter](https://github.com/mattari20/listing-v2/pull/220)  
**Exact implementation head validated:** `17d8938a7715d8bd07950ef2039e5cc95f174cc7`  
**Status:** Implementation delivered on branch; exact-head validation passed; PR awaiting merge.

## 1. Authorized scope

The Product Owner explicitly authorized only M3-07 I6 from the latest verified `main`, limited to:

- deterministic offline synthetic fixture adapter;
- fixed server-owned agent identity with only `submit_agent_field_proposal`;
- dedicated I3 field-aware agent proposal path;
- dedicated editorial-case submission path;
- metadata-minimal denied-action audit;
- synthetic-only tests and this implementation record.

Human proposal, review, adjudication, publication, correction, withdrawal, restoration and field-definition governance authority had to remain unchanged.

All exclusions remain binding: no migration/schema change, backfill, dependency/Composer change, route/UI, campus/programme expansion, real/source data, source access, live AI/model/provider, external API/connector/scheduler, production/V1/Hostinger, deployment, release, procurement, spend, I7 or scope expansion.

## 2. Delivered implementation

### 2.1 Deterministic adapter

Added `SyntheticAgentProposalAdapter` with exactly one known fixture identifier: `synthetic-institution-alpha-v1`.

- Accepts only a synthetic institution entity ID and existing evidence-reference IDs.
- Rejects unknown fixture IDs, malformed identifiers, duplicate/oversized evidence lists, caller-supplied values, actor identities, capabilities, tools, commands and extra fields.
- Canonicalizes evidence-reference ordering before deriving the deterministic idempotency key.
- Does not read source documents, URLs or files and makes no network/model/provider call.

### 2.2 Fixed agent submission service

Added `AgentFieldProposalSubmissionService`.

- Accepts only the known fixture and bounded institution/evidence identifiers.
- Candidate field, exact version, candidate value, institution scope and synthetic processing context are fixed in the dedicated I3 entry point, not supplied by the caller.
- Reuses existing I3 validation, evidence/source-authorization policy, cardinality, transaction, idempotency, audit and outbox behavior.
- Denied action-shaped input maps to a bounded allowlisted action code or `unknown_privileged_action`; audit stores only the fixed agent ID, actor class, bounded action/reason code, one-way idempotency reference and fingerprint. Raw attempted text and rejected payload content are not persisted.

### 2.3 I3 field-aware submission integration

Updated `FieldAwareClaimProposalService`:

- Existing `propose()` still requires a human actor with both existing human capabilities.
- New `proposeForSyntheticAgent()` accepts no actor/capability argument and constructs the fixed agent identity internally.
- The agent entry point is hard-bound to the one synthetic institution label, `institution_display_name`, definition version 1, the fixed candidate value and institution scope.
- The shared private I3 implementation performs exact active definition resolution, entity/provider-category applicability, typed/privacy/freshness checks, cardinality, metadata-only synthetic evidence and current processing authorization checks, idempotency and atomic claim/evidence/editorial/audit/outbox persistence.
- The agent creates only a `proposed` claim version; it cannot adjudicate or publish.

### 2.4 Editorial submission integration

Updated `EditorialReviewService`:

- Existing human `submit()` remains human-only and retains its original capability contract.
- New `submitAgentProposal()` has no actor/capability input and creates the same fixed agent identity internally.
- The agent-specific path checks the exact synthetic institution, field key/version, proposed disposition and fixed candidate value, and rechecks that linked evidence is metadata-only synthetic with current synthetic processing authorization.
- Existing review, adjudication, publication, suppression, restoration and correction operations continue to require human actors. The agent's only capability cannot satisfy those human-only gates.
- A distinct human reviewer can begin and complete review of an agent-submitted case; the submitter/evidence separation checks remain in force.

## 3. Files changed

| File | Change |
|---|---|
| `app/Services/Directory/SyntheticAgentProposalAdapter.php` | New deterministic one-fixture adapter |
| `app/Services/Directory/AgentFieldProposalSubmissionService.php` | New bounded fixed-agent submission and denial-audit service |
| `app/Services/Directory/FieldAwareClaimProposalService.php` | Human-preserving wrapper plus fixed-agent I3 entry point and shared private validation/persistence path |
| `app/Services/Directory/EditorialReviewService.php` | Human-preserving submit wrapper plus fixed-agent editorial-case submission and exact fixture/evidence rechecks |
| `tests/Feature/SyntheticAgentProposalAdapterTest.php` | New synthetic-only acceptance and regression tests |

No other application files were changed. In particular, `GovernancePolicy`, generic governance registration, public projections, definition governance, correction/withdrawal services and migrations were not changed.

## 4. Acceptance evidence

| Acceptance area | Evidence |
|---|---|
| Fixed fixture and deterministic retry | Same fixture/evidence set returns the same proposal; evidence order is canonicalized |
| Exact claim binding | Claim version uses the exact field-definition version 1 and remains `proposed` |
| Synthetic evidence | Existing metadata-only synthetic references and current synthetic processing authorization are required; non-synthetic evidence is rejected |
| Atomic governance handoff | Claim, evidence links, submitted editorial case, audit and outbox are persisted through the existing I3 transaction |
| Fixed identity | Status history and audit identify `synthetic-agent-proposal-adapter-v1` as actor class `agent` |
| Least privilege | Fixed actor has exactly `submit_agent_field_proposal`; caller-supplied actor/capability data is rejected |
| Human separation | Agent review attempt is rejected; a distinct human reviewer can complete editorial review |
| Denied privileged actions | Action-shaped `publish` attempt is rejected and produces metadata-minimal, idempotent denial audit without raw payload |
| No autonomous publication | No adjudication decision, publication decision, snapshot or public projection is created |
| Human-path regression | Existing human I3 proposal path still records a human submitter and human actor class |
| Schema and scope | No migrations, schema changes, backfills, dependencies, Composer changes, routes, UI, queues, schedulers or external services |

The new feature test class contains five focused test methods covering valid submission/retry/human review, unknown and malformed fixture input, privileged-action denial audit, fixed I3 agent entry-point/idempotency behavior, synthetic evidence/entity rejection and the unchanged human proposal path.

## 5. Exact-head CI and test result

Validated exact head: `17d8938a7715d8bd07950ef2039e5cc95f174cc7`.

- FND-01 PHP 8.5 foundation CI: [run #43838413609](https://github.com/mattari20/listing-v2/actions/runs/43838413609) — **completed successfully**.
- Project documentation validation: [run #43838413686](https://github.com/mattari20/listing-v2/actions/runs/43838413686) — **completed successfully**.
- FND-01 checks completed: PHP 8.5/Composer toolchain, SQLite, Composer manifest, documentation, locked dependency install, dependency advisory check, Pint formatting, Laravel bootstrap/routes, synthetic test suite and artifact hygiene.
- `php artisan test` summary: **15 passed, 687 assertions, 164 warnings**; no failures. The warning output includes the repository's existing missing-local-`.env` test-harness warnings. No `.env` file was added or modified.
- `git diff --check` and artifact hygiene passed.

## 6. Scope and safety reconciliation

- No production, V1, Hostinger/hPanel or live database was accessed.
- No migration, schema change, backfill or database operation outside disposable CI tests was performed.
- No real/source institution/provider/student/applicant data or external source was accessed.
- No AI/model/provider, external API, connector, crawler, browser, parser, network, queue or scheduler was used.
- No route, controller, UI, public projection, publication snapshot or publication decision was added.
- No Deeni Madaris visibility behavior or default-OFF policy was changed.
- G2-G9 remain blocking for live source access and live agent/model activation. I7 remains separate and unauthorized.

## 7. PR disposition

PR #220 is open against `main`, based on `2d9e1c15df808c5e4679e0cd2d63d4fb98be2246`. The exact head above has passed both required workflows. Merge remains subject to final changed-file, review-thread, mergeability and exact-head checks.

**I6 implementation:** Delivered within the authorized branch scope; exact-head CI and documentation validation passed.  
**I6 merge/closeout:** Pending PR #220 merge and subsequent main verification.  
**Live AI Data-Agent/source activation:** Not authorized; G2-G9 remain blocking.  
**I7:** Not started and not authorized.
