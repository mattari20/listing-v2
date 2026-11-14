# M3-06 — Geography and Discovery Work Plan

**Repository:** `mattari20/listing-v2`  
**Status:** Implemented for bounded synthetic local/CI scope; architecture-level geospatial capabilities remain deferred  
**Authorization:** Product Owner instruction received 2026-11-14 to proceed with M3-06 within the previously stated boundaries  
**Dependency:** M3-05 Public Directory and Search merged and validated  
**Baseline:** `e608ac30ceb03698f7f632433c01b7387e9b5f11`

## 1. Purpose

Add locality-aware public directory discovery while preserving the accepted M2-S06 principles: anonymous search works without location permission; manual locality selection remains available; public results derive only from currently eligible approved projections; geography precision and uncertainty are not overstated; and Deeni Madaris remains excluded from every public discovery surface by default.

## 2. Bounded implementation scope

1. Extend the public predicate allowlist with four explicit text-only geography facts: `province`, `district`, `city` and `locality`.
2. Display approved geography facts on public profiles and concise locality context in result cards.
3. Add a manually entered locality query parameter to the existing anonymous directory search.
4. Match the locality filter only against the four geography predicates; general text search remains available independently.
5. Preserve the existing publication eligibility chain: accepted current claim version, approved decision and projection, latest snapshot, no active suppression, current eligible evidence and source authorization, and no restricted category.
6. Preserve evidence observation dates and show the existing explicit unknown-freshness state when observation dates are absent.
7. Add synthetic tests for province/district/city/locality filtering, non-matching locations, non-allowlisted private facts, profile display and Deeni Madaris exclusion.
8. Keep the interface HTML-first, responsive, keyboard-operable and usable without JavaScript, maps, device location or external assets.

## 3. Pakistan-first locality semantics

The initial supported vocabulary is a set of separately published text facts: province, district, city and locality. Search is case-insensitive Unicode substring matching over these approved public facts. This is a discovery aid, not an authoritative national administrative-boundary dataset.

The application does not infer parent-child geography, merge similarly named places, geocode addresses, infer campus coordinates from provider addresses, or treat missing geography as a negative fact. A result appears for a locality query only when at least one eligible approved geography fact matches.

## 4. Privacy, provenance and safety controls

- Manual locality search requires no browser/device location permission and collects no user location.
- No precise user location, exact home address, private coordinate, staff location or student personal data is collected or exposed.
- Geography values are rendered only from the same approved anonymous publication projections and evidence/authorization checks used by M3-05.
- Raw evidence, source URLs, internal notes, unapproved claims, superseded claims and suppressed projections remain excluded.
- Deeni Madaris remains excluded from results, profiles and facets; no category or sect/maslak geography filters are introduced.
- Geography facts retain their evidence observation dates; missing dates remain explicitly unknown.

## 5. Explicit non-goals and deferred decisions

This bounded delivery does **not** implement or authorize:
- latitude/longitude storage, coordinate precision/confidence models or public map pins;
- distance calculations, nearby sorting, route search or device geolocation;
- map tiles, a map renderer, geocoder, reverse geocoder or external geography API;
- a national locality gazetteer, boundary dataset, alias/transliteration corpus or authoritative hierarchy;
- automatic normalization/merging of duplicate or ambiguous locality names;
- external data collection, scraping, source outreach, source reuse or ingestion;
- production, V1, Hostinger/hPanel, live database, deployment, URL cutover, launch, paid service or additional spend.

These capabilities require a separate evidence-backed design/authorization decision. The core directory remains usable through manual text search if maps or location services are unavailable.

## 6. Acceptance criteria

| ID | Acceptance criterion | Evidence |
|---|---|---|
| GEO-001 | Search can be manually filtered by published province, district, city or locality text | Feature tests for Lahore/Gulberg and Karachi/Gulshan synthetic fixtures |
| GEO-002 | Locality filtering cannot match private/non-allowlisted facts | Synthetic internal-notes regression assertion |
| GEO-003 | Geography is displayed only from eligible approved anonymous projections | Existing publication/evidence/authorization checks plus profile tests |
| GEO-004 | Unknown geography remains absent; unknown observation dates are not fabricated | Existing missing-date test and no inference behavior |
| GEO-005 | Manual locality search works without device location, maps, JavaScript or external assets | Server-rendered GET form and text-only query contract |
| GEO-006 | Deeni Madaris remains absent from locality results and public profiles | Restricted synthetic fixture test |
| GEO-007 | Existing category facets and filters remain constrained to eligible public results | Existing M3-05 category/facet regression suite |
| GEO-008 | Search input is bounded and output safely escaped | Controller max-length validation and Blade escaping |

## 7. Verification and closeout

- Run the complete synthetic feature suite and required PHP 8.5 FND-01 CI on the exact PR head.
- Run Project documentation validation on the exact PR head.
- Review the exact diff, unresolved review threads and submitted reviews.
- Merge only with the exact expected PR head SHA after all required checks pass.
- Reconcile the M3 master plan, step register, progress report, traceability matrix, documentation catalogue, project controller and documentation index.
- Record merge SHA and exact-head CI evidence. A merge alone is not acceptance.

## 8. Binding project boundary

Synthetic/local/CI only. No production writes, migrations, live database changes, V1 or Hostinger/hPanel access, real/source/provider/student data, external APIs/AI, geocoding, maps, deployment, release, procurement or new spend. This work does not imply production readiness or launch approval.
