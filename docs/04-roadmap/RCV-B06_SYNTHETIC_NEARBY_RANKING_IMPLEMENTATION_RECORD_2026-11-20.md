# RCV-B06 — Synthetic Nearby Ranking Implementation Record

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Authorization:** Product Owner approval recorded 2026-11-20 in this conversation, limited to the synthetic-only pure-domain proof-of-concept in the publication/evidence review authorization request.  
**Status:** Implementation prepared; exact-head CI and merge pending.

## 1. Delivered scope

A pure PHP domain proof-of-concept was added under `app/Domain/Geography`:

- `NearbyOrigin` — immutable request-origin value object that rejects non-finite or out-of-range coordinates.
- `NearbyCoordinateCandidate` — immutable candidate carrying entity identity, declared institution ownership, ownership-verification flag, coordinate, publication eligibility, Deeni Madaris suppression flag, source authorization, public visibility, precision, confidence, verification state and synthetic provenance marker.
- `SyntheticNearbyRankingService` — filters candidates fail-closed, calculates Haversine straight-line distance using the mean Earth radius (6,371.0088 km), rounds displayed estimates to two decimal places, and orders by unrounded distance with deterministic entity-type and entity-ID tie-breaks.

A unit test suite was added at `tests/Unit/SyntheticNearbyRankingServiceTest.php`.

## 2. Fail-closed eligibility rules

A candidate is considered by this synthetic ranking component only when:

1. Entity type is institution, campus or delivery site and identity is non-empty.
2. Institution ownership is present and structurally consistent; institution subjects identify themselves as their owning institution.
3. Campus/delivery-site ownership is explicitly marked verified and does not reuse the subject ID as the institution ID.
4. Latitude/longitude are present, finite and within WGS84 numeric bounds.
5. The candidate is marked publication-eligible and not Deeni Madaris.
6. Source authorization is explicitly true.
7. Visibility is exactly `public_generalized`.
8. Precision is approximate, area-centroid or generalized; exact-restricted is rejected.
9. Confidence is high or medium; low/unknown are rejected.
10. Verification state is exactly `verified_current`.
11. Provenance reference begins with `synthetic:`.

The ownership-verification flag is an explicit synthetic input contract, not an independent proof of a real parent-child relationship. In a later governed integration, the ownership relationship must be verified from the authoritative accepted entity relationship/public projection, not trusted from a caller-supplied flag alone.

## 3. Distance semantics

- Uses the Haversine great-circle formula over WGS84 latitude/longitude numeric values.
- Output field is named `distance_km_approx`.
- Distance is a straight-line estimate only; it is not route distance, travel time, suitability, safety or a service-quality indicator.
- Sorting uses the unrounded distance; the displayed estimate is rounded to two decimal places.
- Equal distances use entity type and entity ID as deterministic tie-breakers.
- No radius threshold or user-facing nearby behavior is introduced.

## 4. Test coverage

Synthetic unit tests cover:

- Nearer/farther ordering.
- Stable ordering for equal-distance fixtures independent of input order.
- Authorization, publication eligibility and Deeni Madaris fail-closed behavior.
- Internal visibility and restricted precision rejection.
- Low/unknown confidence rejection.
- Stale, conflicted and withdrawn state rejection.
- Missing or non-synthetic provenance rejection.
- Missing, non-finite and out-of-range candidate coordinates.
- Missing/malformed subject identity and ownership mismatch/unverified ownership.
- Invalid/non-finite origin rejection.
- Coordinate boundary and zero-distance cases.
- Institution coordinate identity remaining an institution point rather than being re-labelled as a campus point.

All fixture identifiers, coordinates and provenance markers are fictional synthetic values. No real institute, source or personal location is represented.

## 5. Explicit non-integration

This proof-of-concept is not wired to:

- `PublicDirectoryQueryService`, database models, migrations or persistent storage;
- public routes, controllers, views, search filters, facets or ranking;
- browser/device geolocation, user profiles, sessions, cookies, analytics or logs;
- maps, geocoding, routing, external APIs, vendors or AI.

Existing manual locality search and Deeni Madaris policy/configuration are unchanged. The component cannot independently establish a real publication decision, source-rights authorization, coordinate ownership or freshness; its boolean/state inputs are synthetic proof fixtures only.

## 6. Validation and release boundary

Required exact-head validation:

- Project documentation validation.
- FND-01 PHP 8.5 foundation CI, including PHP formatting, Laravel bootstrap/routes and the synthetic-only test suite.

A passing CI result validates only this isolated code and synthetic fixtures. It does not approve real coordinates, coordinate sources, schema/persistence, integration, user-origin collection, privacy/security, external services, production or public activation.

## 7. Remaining gates

Separate explicit approval is still required for real coordinate sources and rights, public precision/freshness policy, schema and application integration, browser/device geolocation, privacy/security assessment, maps/geocoding/routing/vendors/spend, and any production/Hostinger/V1 access or deployment.

## 8. Completion disposition

The bounded synthetic code and unit tests are prepared. The agenda is not marked merged/validated until exact-head workflows complete successfully and the PR is merged. No excluded activity has been performed.
