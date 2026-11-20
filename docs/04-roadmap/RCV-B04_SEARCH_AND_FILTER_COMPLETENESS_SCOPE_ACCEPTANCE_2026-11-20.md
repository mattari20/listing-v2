# RCV-B04 — Search and Filter Completeness: Scope and Acceptance Decision Pack

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `56f9bba683c153d455ebe4b58e9433a09bbeb41a`  
**Agenda:** RCV-B04 — Search and Filter Completeness  
**Status:** Product Owner approved the bounded Sections 3–4 scope on 2026-11-20 in the follow-up project conversation. Implementation is delivered in PR #324; this document records the accepted boundary.

## 1. Why this is next

RCV-01 identifies RCV-B04 as the next residual product capability after RCV-B03. RCV-B02 admissions/programme decision facts and RCV-B03 session-only shortlist/comparison are now implemented and merged for their bounded synthetic V2 scopes.

The current directory already supports case-insensitive substring search over approved searchable names/facts, entity-type selection, text locality, registry-managed exact-value filters, and alphabetical default ordering. The controller exposes a maximum of six filter parameters. This is a useful base, but it does not yet demonstrate complete student-first subject/programme discovery, a deliberate filter catalogue, transparent facet behavior, or a complete acceptance matrix for unknown and non-comparable values.

## 2. Current behavior and gaps

### Existing behavior to preserve
- Search reads only current approved anonymous directory projections.
- Searchable entity names and approved facts are used; registry-managed facts must be marked searchable.
- Locality search uses published province, district, city and locality text; no device location is required.
- Dynamic filter options come only from registry-managed facts explicitly marked filterable.
- Entity types remain provider, institution, campus, programme and qualification.
- Default ordering is by name; no relevance score or recommendation ranking is claimed.
- Deeni Madaris remains excluded/default-OFF.
- The RCV-B03 shortlist and comparison behavior remains session-only and unchanged.

### Gaps to close
- Map accepted student search needs to the actual public searchable field keys, including subject and programme-related facts where approved.
- Define a small, understandable student-facing filter set rather than exposing every registry filter automatically without product grouping.
- Verify how entity-type facets and counts behave when other filters are selected.
- Define and test interactions among text query, category, locality and multiple facets.
- Ensure missing, unpublished, unknown, stale, conflicting and not-applicable facts are not treated as negative matches or silently converted to zero.
- Ensure fee filters, if included, compare only like units: currency, fee component and period must remain explicit. Do not add unlike components or infer totals.
- Document search limitations: current substring matching is not fuzzy relevance, transliteration, spelling correction or semantic search.

## 3. Recommended bounded first slice

The recommended first implementation is a deterministic, registry-backed search/filter enhancement using only the existing approved anonymous projection. No external search service, new vendor, AI or new data acquisition is needed.

### 3.1 Search fields
Include only public fields explicitly approved for anonymous display and marked searchable in the field registry. The proposed priority is:
1. Provider/institution/campus/programme/qualification names and approved common/official names.
2. Programme title/level and subject facts, where the field definition is applicable and searchable.
3. Education level and provider/institution type facts.
4. Published province, district, city and locality facts.

Keep current case-insensitive substring matching as the deterministic baseline. Do not claim fuzzy matching, transliteration, typo correction, semantic search or relevance ranking in this slice. Urdu/RTL localization is a separate RCV-B05 decision.

### 3.2 Student-facing filters
Proposed initial filter groups:
- Institution/provider category and entity type.
- Education level.
- Provider sector/type (for example, government/private only where those values are explicitly governed and published).
- Subject and programme level/title where governed and filterable.
- Province, district, city and locality.
- Admission status/cycle only where an approved public offer fact and a deterministic exact-value filter are available.

Fees and scholarships should not be added as generic filters in this first slice unless the public facts can be compared without mixing currencies, fee components, billing periods, admission cycles or unknown values. A later bounded fee-filter contract can handle numeric ranges and explicit units.

The UI should group filters into a small number of labelled sections, preserve selected values in the query string, provide a clear reset path, and display active filter state. A filter must not appear merely because a value exists; its field definition must explicitly permit anonymous display and filtering.

### 3.3 Results and facets
- Keep alphabetical ordering as the default and make no “best” or sponsored ranking claim.
- Category/facet counts must have a documented meaning and be tested against the active query/filter state.
- Preserve deterministic pagination and query parameters when moving between pages.
- Empty results should explain that no approved matches were found, not imply that an institution or fact does not exist.
- Sponsored placement remains separate from organic matching and comparison facts; this slice adds no paid placement or ranking behavior.

## 4. Acceptance criteria

1. A traceability map connects SR-01–SR-04 and relevant AR-003–AR-008 requirements to exact public field keys, UI controls, query behavior and tests.
2. Search uses only approved anonymous projections and registry fields explicitly marked searchable.
3. Subject and programme search works only for applicable, approved, searchable facts; no hidden or unpublished values influence results.
4. Filter options use only approved public facts explicitly marked filterable.
5. The proposed filter groups are bounded, labelled and understandable; unsupported groups are not shown.
6. Text query, entity type, locality and multiple filters compose deterministically.
7. Facet counts have a documented active-filter behavior and tests.
8. Pagination preserves the active query, category, locality and filters.
9. Missing, unknown, stale, conflicting, unpublished and not-applicable facts are never silently interpreted as zero, false or a negative match.
10. Fee facts are not range-filtered unless amount, currency, component and period are compatible and explicitly represented.
11. Alphabetical ordering remains the default; no relevance, quality, popularity, “best” or sponsored ranking is introduced.
12. Synthetic feature tests cover exact/substring matching, subject/programme facts, filter applicability, combined filters, facet counts, pagination, missing-value behavior, and Deeni Madaris exclusion.
13. No new dependency, external service, AI, source retrieval, real data, schema migration or spend is introduced unless separately authorized.
14. RCV-B03 session-only shortlist and like-for-like comparison regressions remain green.

## 5. Explicit exclusions

- Fuzzy search, typo correction, transliteration, semantic/vector search or relevance ranking.
- AI recommendations, personalization, user profiling or student-account tracking.
- Urdu/RTL localization and qualified accessibility conformance assessment (tracked separately under RCV-B05).
- Device geolocation, coordinates, distance sorting, maps, geocoding or external gazetteers.
- Fee aggregation, inferred totals, affordability scores or mixed-unit fee ranges.
- Sponsored placement, paid ranking, reviews, ratings, public UGC or moderation activation.
- Live source ingestion, scraping, external APIs, model/provider activation or connectors.
- Real institution/student/guardian/staff/source data.
- Hostinger, V1, production DB, deployment, public activation or additional spend.
- Any change to Deeni Madaris default-OFF suppression.

## 6. Product Owner decision and implementation authorization

**Decision: APPROVED.** The Product Owner said: “ok move toward next agenda and complete it soon.” This accepts the recommended bounded first slice in Sections 3–4, with the stated exclusions, for local workstation/GitHub CI using synthetic fixtures only.

If approved, implementation should:
- Reuse the existing query service and field registry.
- Avoid new dependencies and migrations unless a separately justified, explicitly approved need emerges.
- Update the requirements traceability and project documentation.
- Add deterministic synthetic tests and run exact-head PHP 8.5 foundation CI plus project documentation validation.
- Merge automatically when the exact current PR head is clean, in-scope, mergeable and all required checks pass, under the standing project merge protocol.

## 7. Current agenda disposition

| Work item | Status |
|---|---|
| RCV-01 residual backlog identifies RCV-B04 | COMPLETE |
| Current search/filter behavior inspected | COMPLETE |
| Search/filter gaps and exclusions documented | COMPLETE |
| Bounded implementation recommendation | PREPARED |
| Product Owner decision on proposed scope | APPROVED 2026-11-20 |
| Application implementation | Delivered in PR #324; exact-head checks pending at scope-pack update |
| Production, Hostinger, V1, real data, external services, AI, deployment or spend | NOT AUTHORIZED |

Existing V2-only, synthetic-only, no-production, no-V1, no-Hostinger, no-real/source/personal-data, no-external-service/AI, no-spend and Deeni Madaris default-OFF restrictions remain binding.
