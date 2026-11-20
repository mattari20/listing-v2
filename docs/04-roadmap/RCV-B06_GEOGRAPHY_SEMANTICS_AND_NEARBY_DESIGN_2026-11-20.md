# RCV-B06 — Geography Semantics and Optional Nearby Design

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Policy decision:** Product Owner approved 2026-11-20  
**Status:** Repository-only design proposal; not an implementation or authorization for real coordinates.

## 1. Purpose

Translate the approved RCV-B06 policy into a precise, reviewable domain contract before considering schema or application changes. This document uses no real institute coordinates, source records, device location, external service or vendor.

## 2. Product invariants

1. Manual province/district/city/locality search remains the primary discovery path.
2. Nearby discovery, if separately authorized and implemented, is optional and initiated by an explicit user action.
3. No user-origin coordinate is stored in an account, session record, application log, analytics event or institute record.
4. Institution, campus and delivery-site coordinates are distinct facts. A parent coordinate is never silently copied to a child entity.
5. Only approved, sufficiently precise and current entity coordinates may participate in nearby ranking.
6. A missing or unusable coordinate never hides an otherwise searchable institute.
7. Straight-line distance is an estimate, not travel distance, travel time, safety or suitability advice.
8. Maps, geocoding, routing, external location APIs and paid vendors are outside this design.

## 3. Entity ownership contract

A future coordinate fact must reference exactly one subject:

- **Institution:** a generalized point for the institution as a whole; not a substitute for a campus.
- **Campus:** a point representing that specific campus.
- **Delivery site:** a point representing that specific teaching/delivery location.

The subject type and subject identifier form the ownership boundary. The design must reject ambiguous ownership and prevent one entity's coordinate from being presented as another entity's location.

## 4. Coordinate quality contract

A future approved coordinate record should carry these semantic attributes:

| Attribute | Meaning | Rule |
|---|---|---|
| Latitude / longitude | WGS84 decimal-degree point | Internal precision must not be mistaken for source accuracy |
| Precision class | approximate, area_centroid, generalized, or exact_restricted | Public nearby ranking may use only an approved public-safe class |
| Confidence | Controlled class such as high, medium, low, unknown | low and unknown are ineligible for ranking |
| Provenance | Authorized source/reference and method | Must be traceable; no unsupported inference |
| Authorization | Recorded basis permitting use/publication | Missing or revoked authorization blocks publication |
| Observed date | When the location was observed or confirmed | Required for freshness evaluation |
| Verification state | unverified, verified, stale, conflicted, withdrawn | Only verified/current records may rank |
| Visibility | internal, public_generalized, suppressed | Public output must apply the visibility policy |
| Supersession | Link/relationship to corrected or replaced fact | Preserve auditability; never silently overwrite history |

These are proposed domain semantics, not approved database columns. Exact enumerations, retention and freshness thresholds require a separate implementation design and review.

## 5. Eligibility and fail-closed behavior

A future nearby query may consider an entity only when all conditions hold:

- Its entity type and identity are unambiguous.
- Its coordinate is authorized for the intended use and public visibility.
- Its precision class is permitted for public nearby ranking.
- Its confidence is above the approved minimum.
- Its verification state is current and non-conflicted.
- The institution/campus/delivery site is currently eligible for public discovery.
- The result passes existing publication, suppression and Deeni Madaris default-OFF controls.

Otherwise, the coordinate is excluded from nearby ranking. The institute remains available through ordinary text and locality search. No fallback may invent a coordinate, inherit a parent coordinate, or infer a location from a name/address without an approved source and method.

## 6. Request-time origin and privacy contract

If browser/device origin permission is separately approved in a later scope:

- Explain the purpose before prompting.
- Request location only after the user explicitly chooses the nearby action.
- Use the origin only in memory for the current request; do not persist it.
- Do not send it to analytics, logs, third-party services or external APIs.
- Provide a clear deny path and a way to clear/stop using the origin.
- On denial, timeout, unavailable permission or invalid coordinates, retain the normal manual search experience.
- Do not request location during page load, registration or onboarding.

This document does not authorize a browser geolocation prompt or any live origin collection.

## 7. Distance and ordering contract

If a future implementation is separately authorized, calculate a straight-line estimate between the request origin and an eligible entity point. The UI must label it as an approximate distance and disclose that it is not route distance or travel time.

The ranking contract must:
- Define a stable tie-breaker independent of database row order.
- Avoid false precision in displayed units/rounding.
- Keep entities with no eligible coordinate in normal search results.
- Avoid mixing coordinate confidence with institution quality or suitability.
- Preserve the existing filters, query terms, pagination and language state.
- Keep manual locality filtering available and independently testable.

No numeric distance thresholds, coordinate source, public precision or freshness interval is set by this design.

## 8. Synthetic test matrix for a future implementation

Only fictional fixtures may be used in local/CI tests:

| Scenario | Expected behavior |
|---|---|
| Manual locality search, no origin | Existing results unchanged |
| Nearby action not selected | No location permission request |
| User denies permission | Manual search remains usable |
| Origin unavailable or invalid | Fail back to manual search |
| Verified public approximate campus coordinate | Eligible for synthetic nearby ranking |
| Institution coordinate but no campus coordinate | Do not infer campus proximity |
| Low/unknown confidence | Exclude from nearby ranking |
| Stale, conflicted, withdrawn or unauthorized coordinate | Exclude from nearby ranking |
| Suppressed/default-OFF entity | Never exposed through nearby ranking |
| No coordinate on an otherwise public entity | Keep entity discoverable by ordinary search |
| Equal synthetic distances | Deterministic tie-break |
| Language set to Urdu | Nearby labels and direction follow approved locale behavior without translating source facts |

The matrix is a proposed test contract; no application tests or features are added by this document.

## 9. Deferred decisions and mandatory gates

The following require separate explicit approval before implementation or live use:

1. Real coordinate sources, data rights and source-specific authorization.
2. Public coordinate precision, confidence threshold, freshness interval and retention.
3. Browser/device geolocation permission and request-time collection.
4. Schema and application changes, including migrations and ranking activation.
5. Privacy/security assessment, threat model and operational logging review.
6. Maps, geocoding, routing, external APIs, vendors and any spend.
7. Production/Hostinger/V1 access, deployment, public activation or URL cutover.

## 10. Current disposition

The Product Owner policy is approved. This document completes a repository-only definition of entity ownership, quality, fail-closed eligibility, privacy principles, distance semantics and synthetic test expectations.

**Next safe step:** review this design against the existing V2 publication/evidence contracts and prepare a bounded implementation authorization request. Until that request is separately approved, do not change application code, schema, migrations, workflows or runtime configuration.

All existing V2-only, synthetic-only, no-production, no-V1, no-Hostinger, no-real/source/personal-data, no-external-service/AI, no-spend and Deeni Madaris default-OFF restrictions remain binding.
