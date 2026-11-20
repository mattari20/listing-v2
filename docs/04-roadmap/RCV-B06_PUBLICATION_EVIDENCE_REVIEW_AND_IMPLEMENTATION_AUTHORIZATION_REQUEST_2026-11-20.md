# RCV-B06 — Publication/Evidence Review and Bounded Implementation Authorization Request

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Review baseline:** main after RCV-B06 policy/design merge  
**Status:** Evidence review COMPLETE; implementation authorization REQUESTED, not granted

## 1. Decision requested

Approve or decline one narrowly bounded, repository-only synthetic proof-of-concept:

- Add a pure, in-memory nearby-ranking domain component that accepts already-approved synthetic entity-coordinate candidates and a synthetic request origin.
- Validate coordinate quality and publication eligibility metadata supplied to the component; fail closed for missing, unauthorized, non-public, low/unknown-confidence, stale, conflicted, withdrawn or otherwise ineligible candidates.
- Calculate straight-line distance using a documented geodesic formula, return an explicitly approximate distance, and use a deterministic tie-break independent of input/database order.
- Add unit tests using fictional coordinates only, including invalid ranges, boundary cases, deterministic ties, missing coordinates, entity ownership mismatches, and fail-closed quality states.
- Do not connect the component to the directory query, database, routes, controllers, views, browser geolocation, maps or any external service in this stage.

This is a technical proof only. It does not activate nearby discovery or change public behaviour. A later integration stage would require a separate implementation scope and approval.

## 2. Repository evidence reviewed

### 2.1 Public directory publication gate

`app/Services/Directory/PublicDirectoryQueryService.php` builds its anonymous directory from the current public projection chain. The query requires:

- projection status `approved`, surface `directory`, audience `anonymous`, and `is_deeni_madaris = false`;
- snapshot status `projected`, with matching directory/anonymous scope;
- matching approved publication decision for the snapshot's claim version;
- claim-version disposition `accepted` and an allowed directory entity type;
- no superseding claim version, no newer snapshot for the same claim/surface/audience, and no active publication suppression.

The service then validates registry-managed fields against the exact field-definition version and requires both visibility and privacy classes to be `public_eligible`. Legacy predicates are limited to an explicit public-field allowlist. Snapshot payload scope, audience, claim-version ID, Deeni Madaris flag, predicate and value are checked before a fact is exposed.

**Design consequence:** a future production nearby query must not read raw claims, catalogue rows or evidence directly as a shortcut. It must consume the same currently eligible public projection contract and preserve its suppression, supersession and field-visibility gates.

### 2.2 Evidence and source authorization

For each projected claim version, the directory query requires linked evidence. Evidence must remain `eligible_for_review`. The associated source authorization is evaluated through `GovernancePolicy::authorizeSourceAction` for purpose `directory_publication`, method `approved_projection`, the authorized territory, validity dates and revocation state. Missing evidence, missing territory or a failed authorization check excludes the fact.

The directory projection exposes approved scalar facts and limited display fields; raw evidence and unpublished assertions are not returned to the public view.

**Design consequence:** coordinate provenance must be attached to a governed claim/evidence lineage. A coordinate cannot become eligible merely because a value exists or was placed in a campus table. The future policy must separately establish that the source authorization covers the coordinate's intended use and public precision.

### 2.3 Campus and delivery-site identity

`CampusProgrammeCatalogueService` materializes campus and delivery-site records only from current accepted claim versions, with distinct human adjudication, admissible linked evidence, active source authorization and typed subject identity. Both catalogue records retain a typed entity ID, owning institution ID, optional `location_label`, status, validity dates and claim-version reference.

The programme-offer path requires an explicit campus or delivery-site identity and verifies that it belongs to the programme's institution. It does not infer a delivery location from an institution or programme.

The campus/programme migration defines no latitude/longitude, coordinate precision, confidence, coordinate provenance or geospatial index.

**Design consequence:** preserve institution, campus and delivery-site ownership as separate subjects. Never copy or inherit a parent institution coordinate into a child campus or delivery-site record. The existing `location_label` is descriptive text, not a verified coordinate.

### 2.4 Deeni Madaris suppression

The public-directory query explicitly excludes projections and payloads marked as Deeni Madaris. `DeeniMadarisVisibilityPolicy` defaults `directory.deeni_madaris_public` to `false`; unit tests verify both default-off and unset/null fail-closed behavior.

**Design consequence:** any future public discovery integration must retain the existing default-OFF suppression and test that no nearby result, count, facet or secondary projection bypasses it. The synthetic proof must not modify this policy or add Deeni Madaris fixtures as eligible results.

### 2.5 Existing manual locality behavior

The directory query uses only approved public `province`, `district`, `city` and `locality` facts for manual locality matching. The existing feature test proves synthetic locality matching and confirms that a private notes field is not exposed. Manual locality search does not require device permission or coordinates.

**Design consequence:** manual locality search remains the baseline and must remain untouched by the proposed proof-of-concept.

## 3. Review findings and unresolved gates

| Area | Finding | Required treatment |
|---|---|---|
| Public projection | Current approved anonymous projection has explicit decision, audience, surface, supersession and suppression gates | Reuse later; do not bypass |
| Evidence rights | Source authorization is evaluated at publication time for a defined purpose/method/territory | Coordinate-specific purpose/scope still needs approval |
| Coordinate ownership | Campus and delivery site are distinct typed entities with institution ownership | No parent-to-child coordinate inheritance |
| Coordinate schema | No coordinate/precision/confidence fields exist in the inspected campus migration | No schema change in this proof |
| Deeni Madaris | Default OFF and explicit projection exclusion | Preserve unchanged |
| Manual locality | Existing approved public-fact filtering works | Keep independent and unchanged |
| User origin | No current geolocation flow exists | No browser permission or real origin collection |
| Maps/geocoding/vendors | No provider is selected or integrated | Outside scope; separate privacy/cost approval |

## 4. Proposed proof-of-concept boundaries

### Included only if this request is approved

- A pure PHP domain component with no database, network, filesystem or framework service dependency.
- Explicit typed input for a synthetic origin and synthetic candidate points.
- Entity subject type (`institution`, `campus`, `delivery_site`) and subject ID carried together so a candidate cannot be silently re-labelled as another entity.
- Quality metadata sufficient for a fail-closed decision: authorization state, public visibility class, precision class, confidence class, verification/freshness state and provenance reference marker. Test markers must be synthetic and must not masquerade as real sources.
- Straight-line distance calculation and deterministic ordering.
- Unit tests only, with clearly fictional fixtures and no real institute names or coordinates.
- Documentation of formula, units, rounding and limitations.

### Explicitly excluded

- Any database schema or migration; persistence or model changes.
- Any real coordinates, addresses, source records, institutional websites, government gazetteers, maps, OpenStreetMap or Google Maps access.
- Browser/device geolocation, user-origin collection, cookies/session storage, analytics or logs containing coordinates.
- Public routes, controllers, views, filters, nearby UI, search integration, ranking activation or directory output changes.
- Map tiles, geocoding, routing, external APIs, AI, vendors, dependencies requiring new spend or paid plans.
- Hostinger, V1, production, deployment, public launch or configuration changes.
- Any change to Deeni Madaris visibility/suppression or existing manual locality behavior.

## 5. Acceptance criteria if approved

1. The component has no database, network, filesystem, browser or external-service dependency.
2. All test coordinates and provenance markers are fictional, deterministic and documented as synthetic.
3. Invalid latitude/longitude, missing subject identity, mismatched entity ownership, unauthorized source, non-public visibility, low/unknown confidence, stale/conflicted/withdrawn state and missing provenance all fail closed.
4. No candidate can be made eligible by inheriting coordinates from its institution or another entity.
5. Distance is explicitly straight-line and approximate; it is never described as road distance, route, travel time, safety or suitability.
6. Equal distances produce stable deterministic ordering using an explicit tie-break key.
7. No-coordinate and ineligible candidates are excluded from nearby ranking but the component makes no decision to hide them from ordinary directory search.
8. Tests prove no persistence, public-route integration or user-location capture is introduced.
9. Existing manual locality and Deeni Madaris behavior remain unchanged.
10. Exact-head project documentation validation and FND-01 PHP 8.5 foundation CI pass before merge. Any new test workflow required by the repository must also pass on the exact head.
11. A successful synthetic CI run is not evidence of source rights, coordinate accuracy, privacy approval, production readiness or permission to activate nearby discovery.

## 6. Subsequent approvals remain separate

Even if this proof-of-concept is approved and merged, the following remain unapproved and require their own explicit authorization:

- Real coordinate sources, rights, access methods and coordinate-specific permitted purposes.
- Public precision policy, confidence thresholds, freshness rules, retention and correction/withdrawal handling.
- Schema, migrations, persistence and integration with governed public projections.
- Browser/device geolocation and request-time origin collection.
- Privacy/security threat model, logging and operational controls.
- Maps, geocoding, routing, vendors, external APIs and any spend.
- Production/Hostinger/V1 access, deployment, public activation or URL cutover.

## 7. Product Owner response

**Requested decision:** approve the synthetic-only, pure-domain proof-of-concept exactly as bounded in Sections 1, 4 and 5, or decline/amend it.

Approval of this request would authorize only the listed repository-local synthetic component and tests. It would not authorize any excluded item or any subsequent integration stage.

Until approval is recorded, do not add application code, tests, schema, migrations, workflows or runtime configuration for RCV-B06.

## 8. Review completion

The repository publication/evidence/suppression review is complete. The bounded proof-of-concept request is prepared for Product Owner decision. The existing public directory and manual locality implementation remain unchanged.
