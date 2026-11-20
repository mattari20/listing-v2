# M3-12 Agenda 07 — Functional Integration and Regression Evidence Consolidation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline main:** `106ee260f32b621d8688fd6b7446cc4dd0ea1ca3`  
**Work type:** Current-main test/workflow inventory and exact-head GitHub CI evidence reconciliation  
**Status:** COMPLETE for repository-level integration/regression evidence consolidation; CI warnings remain an explicit quality follow-up.

## 1. Purpose and boundary

Consolidate evidence that the existing student discovery, institution management, editorial governance, saved-items, privacy and synthetic preview capabilities integrate within the current V2 repository. Confirm that exact-head CI exercises the current foundation without creating a second test framework or duplicating feature work.

This is a repository and CI evidence review. It does not constitute a separate independent test campaign, browser/E2E acceptance, real-data validation, hosted performance/security testing or production readiness assessment.

## 2. Integration surface reconciled

| Integration area | Current implementation/test evidence | Result |
|---|---|---|
| Public discovery and safe projections | `PublicDirectoryController`, `PublicDirectoryQueryService`, `PublicDirectoryTest`, `DirectorySeoMetadataTest` | Synthetic route, query, projection, suppression, pagination and metadata regression coverage present |
| Programme and admissions facts | `PublicProgrammeOfferFactsQueryService`, `ProgrammeOfferFactWorkflowTest` | Offer/cycle isolation, unknown versus zero, stale facts, correction and withdrawal coverage present |
| Shortlist, comparison and saved items | `PublicDirectoryComparisonService`, `AccountSavedItemsController`, `PublicDirectoryTest`, `AccountSavedItemsTest`, `AccountSessionTest` | Session shortlist and private owner-scoped saved-item regression coverage present |
| Institution and catalogue governance | Provider/authority relationship and campus/programme catalogue services; corresponding feature tests | Synthetic identity, scope, provenance, temporal and rollback coverage present |
| Representative and editorial workflows | `UniversityRepresentativeWorkflowTest`, `EditorialReviewServiceTest`, `FieldDefinitionGovernanceTest`, `FieldDefinitionRegistryReaderTest`, `TypedFieldValueValidatorTest` | Authorization, exact-version, typed/privacy validation and review separation coverage present |
| Security and moderation boundaries | `SecurityHeadersTest`, `ScopedAuthorizationTest`, `ModerationPrivacyBoundaryTest`, `SyntheticModerationWorkflowTest` | Existing synthetic negative-boundary tests present; public UGC/moderation remains disabled |
| Persistence and recovery behavior | `I7DisposableSqliteMigrationTest`, `CoreGovernancePersistenceTest`, `PersistedGovernanceWorkflowTest`, `PersistedConflictAndRollbackTest` | Disposable SQLite migration, persistence, idempotency, rollback and outbox coverage present |
| Private synthetic preview | `PrivatePreviewAccessTest`, `PrivatePreviewDirectorySeederTest`, `LocalPreviewSeederTest` | Local/CI-only preview and synthetic fixture guards present |

The table maps existing source and test files; it does not claim every possible cross-feature scenario or branch has been tested.

## 3. Exact-head CI evidence

Two consecutive documentation-only delivery heads were validated after the A04–A06 package:

| Delivery | Exact head | PHP 8.5 foundation CI | Documentation validation |
|---|---|---|---|
| PR #355 — A04–A06 agenda package | `efe36f69a4c4c9ada7e65c47e26c65bff903d325` | Run #44681875232 — SUCCESS | Run #44681875222 — SUCCESS |
| PR #356 — A04–A06 delivery closeout | `958c7c7e90110fd446c9aaf2bd5d1eb53b894aeb` | Run #44682076798 — SUCCESS | Run #44682076783 — SUCCESS |

The PHP 8.5 workflow completed the following steps successfully on both exact heads:

- PHP 8.5 and Composer 2 toolchain and disposable SQLite driver verification.
- Strict Composer manifest validation and locked dependency installation.
- Composer dependency advisory audit.
- PHP formatting check with Pint.
- Laravel bootstrap/configuration and route-list validation.
- Synthetic-only test suite using in-memory SQLite and foreign keys.
- Repository artifact hygiene, including the absence of a tracked or generated `.env`, database or log artifact.
- Documentation validator: 15 required control documents, relative Markdown links and strict legacy non-interference controls passed.

### 3.1 Test output quality caveat

Both PHP 8.5 runs completed successfully, but the test output was not warning-free:

- **20 passed**
- **1,501 assertions**
- **282 warnings**

The job logs include repeated `file_get_contents(.../.env)` missing-file warnings. The CI intentionally keeps `.env` absent and its artifact-hygiene step requires that no `.env` file be present. This agenda did not identify and isolate every warning producer to a single test or shared helper. No `.env` file was created to suppress warnings, and no warning was reclassified as a test failure without evidence.

The workflow also reports a GitHub Actions runtime deprecation notice: the pinned checkout action targets Node.js 20 while the runner forces Node.js 24. This is CI maintenance debt, not an application test failure.

**Disposition:** PASS for exact-head workflow success and the reported synthetic test assertions; PARTIAL for test-output hygiene because 282 warnings remain unresolved. No claim of a warning-free regression baseline is made.

## 4. Integration gaps not covered by this evidence

1. No browser/E2E journey across discovery, profile, comparison, account saved items and administration was run.
2. No live MySQL connection, hosted database, concurrent production-like load, query-plan or capacity/SLO exercise was performed.
3. No real institution/source/student facts or source freshness validation was used.
4. No independent security assessment, penetration test, hosted runtime verification or qualified accessibility review was performed.
5. No operational recovery, backup restore, RPO/RTO or staffed support rehearsal was performed.
6. Public registration, applications, messaging/alerts, public reviews and public moderation remain absent, deferred or disabled as documented.

## 5. Acceptance criteria and result

| Criterion | Result |
|---|---|
| Map the current cross-feature integration and regression surface | MET |
| Verify exact-head PHP 8.5 foundation CI and documentation validation | MET |
| Confirm synthetic-only SQLite and repository hygiene boundary | MET |
| Preserve warning counts and CI runtime maintenance caveat | MET |
| Establish warning-free tests, browser E2E, hosted or operational acceptance | NOT ESTABLISHED |

**Agenda disposition:** COMPLETE for repository-level functional integration and regression evidence consolidation. The 282-warning CI result remains a tracked quality issue; it does not invalidate the successful workflow exit, but it prevents a clean/warning-free claim.

## 6. Explicit exclusions

No production/V1/Hostinger/hPanel access, live database, real/source/student/institute data, external API/AI, deployment, public activation, browser/participant testing, backup/restore, schema change, new dependency, vendor or spend.

**Final result:** EXACT-HEAD SYNTHETIC CI PASSED; REGRESSION OUTPUT HAS 282 WARNINGS AND REMAINS PARTIAL FOR TEST HYGIENE.
