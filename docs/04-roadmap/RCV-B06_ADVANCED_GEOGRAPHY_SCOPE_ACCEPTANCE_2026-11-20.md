# RCV-B06 — Advanced Geography: Scope and Acceptance Decision Pack

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `74e355ef1e3d04b32c35391a37bc73badd56d898`  
**Agenda:** RCV-B06 — Advanced Geography  
**Status:** Repository-only scope preparation; no application implementation is authorized.

## 1. Why this is next

RCV-01 lists RCV-B06 as the next P2 residual package after language/accessibility. It covers coordinate/precision/confidence semantics, nearby ranking, maps, geocoding and authoritative locality sources. The RCV-01 preconditions require separate data-rights, privacy, security, cost and Product Owner approvals; no map/location vendor is presumed.

## 2. Current V2 capability inspected

- `PublicDirectoryQueryService` uses approved published `province`, `district`, `city` and `locality` facts for manual locality substring matching.
- `PublicDirectoryTest::test_manual_locality_filter_uses_only_approved_public_geography_facts` verifies locality matching and exclusion of private notes using synthetic fixtures.
- Campus and delivery-site records have a `location_label`; the inspected campus/programme migration does not define latitude/longitude, coordinate precision or confidence fields.
- The current directory controller and views do not expose device-location permission, nearby/distance sorting, maps or geocoding.
- No coordinate/geospatial model, geocoder integration or map provider is present in the inspected V2 tree.
- The existing manual locality search remains available without precise device location.

These are repository observations only. No external geography source or service was accessed.

## 3. Recommended staged approach

### Stage A — Define safe geography semantics (documentation/design only)

Before any schema or code change, decide:
- Which entity receives a coordinate: institution, campus or delivery site. Do not silently use an institution coordinate for every campus.
- Whether a public coordinate is exact, approximate, area-centroid or otherwise generalized.
- Required coordinate provenance, source authorization, observed/verified date, confidence class and precision band.
- How uncertain, stale, conflicting or absent coordinates are represented.
- Which coordinate precision may be shown publicly, and which fields remain internal-only.
- How location changes and closures affect coordinate freshness and publication.
- How a location query is kept distinct from a student/guardian's personal location.

### Stage B — Optional nearby discovery contract

Recommended user experience, subject to a separate decision:
- Manual locality search remains available and works without device permission.
- Nearby discovery is an optional enhancement, never a required onboarding step.
- If later approved, device coordinates are used only for the current request/session and are not stored in a user profile or directory record.
- Distance is described as an estimate, with the origin/coordinate precision made clear. Do not imply travel time, route distance or suitability.
- Results without approved coordinates remain discoverable through ordinary search and locality filters; they are not silently treated as far away.
- No coordinate or ranking is activated until its source, precision, publication policy and test contract are approved.

### Stage C — Maps/geocoding/vendor decision (separate)

Interactive maps, geocoding, tile hosting, routing and third-party location APIs are separate decisions. Each would require a named provider, data-processing/privacy review, security assessment, rate/usage limits, cost estimate, fallback plan and explicit spend authorization. No provider, API, key, trial or paid plan is selected or activated by this pack.

## 4. Acceptance criteria for a future implementation proposal

1. Entity-coordinate relationship is explicit and distinguishes institution, campus and delivery site.
2. Coordinate precision, confidence, provenance, authorization, observed date and publication visibility are defined.
3. No student, guardian or staff home/current-location data is collected or stored.
4. Manual locality discovery continues to work without device permission or coordinates.
5. Nearby permission is optional, explained, request-time only and has a clear deny/clear path.
6. Distance semantics distinguish straight-line estimate from route distance or travel time.
7. Missing, uncertain, stale and conflicting coordinate states are transparent; no false precision or inferred proximity.
8. Search and filter behavior is tested with synthetic coordinate fixtures, including boundary, missing and low-confidence cases.
9. Deeni Madaris remains suppressed/default-OFF unless separately approved.
10. Data rights, privacy, security, retention, vendor and cost approvals are recorded before any real coordinates or external service are used.
11. No public launch, map integration or geolocation permission is implied by synthetic CI.

## 5. Explicit exclusions

- No access to or collection from Google Maps, government gazetteers, OpenStreetMap, institutional websites or any other source.
- No coordinate scraping, reverse geocoding, map tiles, route APIs, external services or vendor selection.
- No browser/device geolocation permission or persistent personal location storage.
- No real institution coordinates, user location or personal data.
- No migration, schema, application code, new dependency, deployment, Hostinger/V1/production access or spend.
- No map, nearby or distance feature activation.
- Existing manual locality search remains unchanged.

## 6. Product Owner decision requested

Recommended starting policy:

**Keep manual locality search as the default. If nearby discovery is later implemented, make it optional and request-time only, use approved approximate institution/campus/delivery-site coordinates with explicit precision/confidence/provenance, do not store a user's device location, and defer maps/geocoding/vendor APIs to a separate cost/privacy approval.**

Please approve or amend this policy before any RCV-B06 implementation scope is prepared. Approval of this scope pack would not authorize real source access, coordinates, device geolocation, schema changes, external services or spend.

## 7. Current agenda disposition

| Work item | Status |
|---|---|
| RCV-01 identifies RCV-B06 as next P2 residual package | COMPLETE |
| Current locality implementation and campus schema inspected | COMPLETE |
| Coordinate/geospatial capability inventory | COMPLETE |
| Safe staged approach prepared | PREPARED |
| Product Owner decision on optional nearby policy | REQUIRED |
| Application implementation | NOT STARTED / NOT AUTHORIZED |
| Source, privacy, security, vendor and cost approvals | NOT REQUESTED / NOT APPROVED |

All existing V2-only, synthetic-only, no-production, no-V1, no-Hostinger, no-real/source/personal-data, no-external-service/AI, no-spend and Deeni Madaris default-OFF restrictions remain binding.
