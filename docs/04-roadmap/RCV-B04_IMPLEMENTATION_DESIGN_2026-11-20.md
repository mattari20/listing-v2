# RCV-B04 — Student Search and Filter Completeness: Implementation Design

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `56f9bba683c153d455ebe4b58e9433a09bbeb41a`  
**Scope:** Approved bounded RCV-B04 first slice  
**Implementation branch:** `feat/rcv-b04-student-search-filter-completeness`

## 1. Delivered behavior

- Retains deterministic case-insensitive substring search over approved anonymous directory projections.
- Registry-managed facts influence text search only when their exact published field-definition version marks them searchable; existing approved allowlisted non-registry facts retain their existing behavior.
- Adds explicit subject-search coverage using synthetic registry facts marked searchable and confirms an unsearchable fact does not produce a result.
- Groups available registry-backed filter controls into student-facing sections:
  - Academic options (education level, programme and subject keys)
  - Admissions (admission/intake/enrolment keys)
  - Institution details (provider/institution type and sector keys)
  - Additional approved filters (other approved filterable registry facts)
- Grouping is presentation-only and based on stable field-key conventions; it does not grant search, display or filter permission. Those permissions continue to come from the exact registry definition and approved anonymous projection.
- Allows up to 12 selected filter fields per request, while each selected value must still be present in the current approved filter-option catalogue.
- Displays active query, category, locality and selected field filters, with a one-click clear-all link.
- Documents the actual search limitations: substring matching only; no fuzzy matching, typo correction, transliteration, semantic search or relevance ranking.
- Clarifies category facet counts: they are calculated after text, locality and approved field filters, but before the selected category is applied. This keeps the other category counts visible and useful when one category is selected.
- Existing paginator query-string preservation remains in place; the controller passes the full request query to the paginator.
- Existing alphabetical default ordering, missing-value handling, Deeni Madaris suppression, and RCV-B03 session-only shortlist/compare behavior remain unchanged.

## 2. Safety and data boundary

The implementation continues to use only `PublicDirectoryQueryService` and its current approved anonymous directory projection. It does not read raw source material or unpublished claims. Searchable/filterable permissions are not inferred from labels or values. Unknown filter keys and values not present in the current public filter options are ignored by the controller.

No fee range, scholarship, affordability or mixed-unit filter is introduced. Programme-offer admissions facts remain in their separate offer/cycle read model; they are not flattened into generic directory facts or presented as filters without a specific approved contract.

Deeni Madaris remains suppressed/default-OFF. No changes were made to V1, Hostinger, production, deployment, public activation, external services, AI, source retrieval, real data, migrations, dependencies or spend.

## 3. Changed files

- `app/Services/Directory/PublicDirectoryQueryService.php` — student-facing filter group metadata derived from field-key conventions.
- `app/Http/Controllers/PublicDirectoryController.php` — bounded filter-count validation and grouped filter data for the view.
- `resources/views/directory/index.blade.php` — grouped controls, active search summary, clear-all link and transparent facet/search-limit explanations.
- `tests/Feature/PublicDirectoryTest.php` — synthetic subject-search, multi-filter composition/facet and grouped-control/active-state coverage.
- Scope, roadmap, progress, traceability and documentation indexes updated.

## 4. Validation required

- Exact-head FND-01 PHP 8.5 foundation CI.
- Exact-head project documentation validation.
- Synthetic feature suite includes the existing RCV-B02 and RCV-B03 regressions.
- No browser acceptance or production readiness is claimed by automated CI.
