# M3-03 Agenda 6 — Governance Service Contract Implementation

**Date:** 2026-11-13  
**Repository:** `mattari20/listing-v2`  
**Status:** Implementation delivered to PR #160; exact-head CI and merge evidence pending  
**Authorization:** Product Owner authorized local/CI-only synthetic service-contract implementation and testing using the approved Agenda 5 defaults.

## 1. Authorized scope

This agenda implements the first bounded executable governance contract layer on top of the existing Agenda 4 eight-table schema.

- Repository-only: `mattari20/listing-v2`.
- Fabricated synthetic identifiers and values only.
- Existing local/CI SQLite `:memory:` test configuration only.
- No new migrations or database tables.
- No real/source/institute/student/child/staff data or source content.
- No source retrieval, scraping, bulk download, source-owner outreach or permission request.
- No V1, Hostinger, hPanel, production/live database, hosting or deployment.
- No external APIs, connectors, AI providers, public endpoints, pilot, procurement, new spend or GitHub protection changes.

## 2. Implemented service contracts

### GovernancePolicy

The policy boundary provides executable decisions for:

- exact source authorization status, validity window, revocation, purpose, method, territory and independent action scopes;
- least-privilege capability checks;
- human-only adjudication, with high-impact evidence submitter separation;
- human-only publication, requiring accepted disposition, admissible evidence, current claim version, distinct adjudicator and evidence submitter, explicit surface/audience and policy version;
- evidence admissibility (only `eligible_for_review` can support acceptance);
- conflict detection that preserves incompatible candidates without latest-wins;
- Deeni Madaris default-OFF visibility;
- approved-projection-only anonymous reads;
- separate restoration and evidence-withdrawal capability gates.

Unknown or missing values deny or suppress.

### GovernanceCommandService

Two transactional commands are implemented against existing tables:

1. `registerEvidenceReference`
   - requires the `register_evidence` capability;
   - rechecks current source authorization for the acquisition action and exact purpose/method/territory;
   - accepts metadata only, hard-sets source type to synthetic, and creates the evidence reference in `quarantined` state with `content_included=false`;
   - writes the audit event in the same database transaction;
   - uses a stable idempotency key bound to a command fingerprint.

2. `registerProposedClaim`
   - requires the `register_claim` capability;
   - verifies the subject and evidence references exist;
   - creates a new proposed claim version and explicit evidence links;
   - preserves quarantine; registration does not accept, adjudicate or publish the claim;
   - writes the audit event in the same transaction and binds idempotency to the command fingerprint.

Audit failure aborts the associated transaction. Reuse of an idempotency key for a different command payload is rejected.

## 3. Synthetic verification

`tests/Feature/GovernanceServiceContractTest.php` adds tests for scoped authorization, capability checks, separation of duties, publication gates, restricted-category defaults, metadata-only evidence intake, quarantine, proposed claim registration, idempotency, audit-failure rollback, application entry-point persistence boundaries and a GS-001–GS-032 policy acceptance matrix.

The GS matrix is a policy-level synthetic verification matrix. Existing Agenda 4 tests continue to cover physical schema and version-lineage integrity. It is not represented as 32 end-to-end workflow tests.

## 4. Explicitly not implemented

The current eight-table persistence foundation has no adjudication-case/decision, publication-decision/snapshot, projection/outbox, suppression-propagation or restoration records. Agenda 6 therefore does not invent new tables or claim those workflows are persisted or operational.

The following remain later, separately scoped work:
- persisted human adjudication and appeal/reconsideration workflow;
- persisted publication authorization, immutable snapshots and approved projection delivery;
- transactional outbox, retry/dead-letter and downstream suppression/revocation reconciliation;
- persistent emergency suppression and dual-controlled restoration;
- full runtime tests for concurrency, stale projections, delayed revocation and all 32 end-to-end scenarios;
- Product Owner-approved real role/permission matrix and qualified legal/privacy/source-rights/safeguarding/security review.

No real roles or users are provisioned. The policy layer is not a legal/security clearance or production-ready authorization system.

## 5. Validation and merge gate

PR [#160](https://github.com/mattari20/listing-v2/pull/160) contains the implementation.

Required before merge:
- exact-head PHP 8.5 foundation CI passes, including Pint, Laravel bootstrap, dependency audit, SQLite in-memory tests and artifact hygiene;
- exact-head Project documentation validation passes;
- no unresolved review threads;
- code and test review confirms transaction rollback, metadata-only quarantine, payload-bound idempotency and fail-closed policy decisions.

As of this record, CI status has not yet been returned by the available GitHub status interface. Do not claim checks passed or merge until the exact PR head has verifiable successful results.

## 6. Agenda disposition

**Implementation files:** delivered to PR #160.  
**Policy-level synthetic acceptance matrix:** included.  
**Exact-head CI:** pending evidence.  
**PR merge:** pending.  
**Agenda 6 closeout:** pending successful validation and post-merge reconciliation.  
**M3-03 overall:** remains in progress; no whole-step completion percentage is claimed.

No production/source access, real data, external service/AI, public surface, deployment, procurement or spend occurred.
