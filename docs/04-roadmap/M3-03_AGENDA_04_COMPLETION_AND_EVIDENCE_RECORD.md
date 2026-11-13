# M3-03 Agenda 4 — Completion and Evidence Record

**Date:** 2026-11-13  
**Repository:** `mattari20/listing-v2`  
**Agenda:** M3-03 Agenda 4 — Physical persistence foundation, Slices A and B  
**Status:** **Completed — bounded authorization exhausted**

## 1. Authorization and boundaries

The Product Owner explicitly authorized Slices A and B under these limits:

- V2 repository `mattari20/listing-v2` only.
- Local development and GitHub CI only.
- Fabricated synthetic values only.
- Disposable SQLite in-memory database (`:memory:`) only.
- No V1 inspection or modification; no Hostinger, hPanel, SSH, production or live database.
- No real/source/personal/institute data, source acquisition, external APIs/AI, public pages, deployment, procurement or new spend.
- No GitHub ruleset, branch-protection or required-check changes.

No work beyond Slices A and B is authorized by this record. Agenda 4 authorization expires at closeout.

## 2. Delivered implementation

PR [#157](https://github.com/mattari20/listing-v2/pull/157), titled **feat(m3-03): implement local synthetic persistence foundation**, adds:

1. A reversible Laravel migration creating eight tables:
   - `directory_entities`
   - `entity_relationships`
   - `source_authorizations`
   - `evidence_references`
   - `claims`
   - `claim_versions`
   - `claim_evidence_links`
   - `audit_events`
2. UUID primary/foreign keys and restrictive foreign-key delete behavior.
3. Typed relationship metadata, optional scope/jurisdiction and validity dates.
4. Separate authorization purpose/method/territory/scope fields, validity and revocation metadata.
5. Evidence-reference metadata only, defaulting to quarantined and `content_included=false`.
6. Claim disposition kept separate from version supersession lineage.
7. Audit actor/action/target/reason/time metadata.
8. SQLite configuration defaulting to `:memory:`; PHPUnit and CI explicitly use `:memory:`.
9. CI setup and verification for PHP 8.5, `sqlite3` and `pdo_sqlite`.
10. Artifact hygiene that allows migration source while continuing to prohibit committed database files, environment files, dependencies and logs.

The migration includes a reverse-order `down()`. No persistent SQLite file or hosted database connection is configured by default.

## 3. Synthetic persistence verification

The feature test suite verifies:

- Expected core tables exist after migration.
- Relationship rows reject missing entity endpoints through foreign-key enforcement.
- Authorization scopes remain separately represented and evidence references remain quarantined metadata-only records.
- Claim disposition and supersession lineage remain distinct.
- Audit events persist actor, action, target, reason and occurrence time.

All test values are fabricated. These tests validate the bounded persistence foundation; they do not establish complete governance workflows or production behavior.

## 4. Exact-head delivery evidence

- PR: [#157](https://github.com/mattari20/listing-v2/pull/157)
- Exact PR head: `a3636709a6a299e7e264b315c07a323fa4ff85d3`
- Project documentation validation: run #378, ID `43448575503` — **success**
- FND-01 foundation CI: run #64, ID `43448575509` — **success**
- Review threads: none outstanding at final pre-merge check
- Merge method: squash (repository does not permit merge commits)
- Merge commit on `main`: `1587cd9b2d05b033c18f0b0570b13d37b872bfce`
- GitHub PR state: merged

The successful foundation CI run included PHP 8.5 setup, SQLite/PDO SQLite driver verification, Composer manifest and dependency checks, formatting, Laravel bootstrap/routes, synthetic persistence tests and repository artifact hygiene.

## 5. Acceptance and limitations

**Accepted for Agenda 4:** The physical schema/migration contract and synthetic SQLite in-memory persistence tests have been implemented, validated on the exact PR head and merged.

**Not delivered / not implied:**

- Governance service layer or business workflows.
- Human adjudication, role/separation-of-duties enforcement or publication workflow.
- Identity merge/split implementation.
- Real-source authorization, source acquisition or evidence content ingestion.
- Public directory/search/API/maps or complete institute listing product.
- Legal, privacy, child-safeguarding, security or source-rights clearance.
- Hostinger/V2 hosted compatibility, production readiness, deployment, pilot or launch.

No claim is made that M3-03 as a whole is complete. No whole-step weighted percentage is assigned.

## 6. Closeout decision and next gate

Agenda 4 is **Completed and closed** for Slices A and B. Its authorization is exhausted. Any Agenda 5 or further implementation must be preceded by a new explicit Product Owner authorization defining exact scope, environment, data, acceptance criteria and exclusions.

The project remains at **M3-03 — In progress**. No next implementation agenda is automatically authorized.
