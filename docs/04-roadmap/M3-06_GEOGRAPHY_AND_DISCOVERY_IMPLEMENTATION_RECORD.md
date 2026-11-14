# M3-06 — Geography and Discovery Implementation Record

**Repository:** `mattari20/listing-v2`  
**Status:** Complete for bounded synthetic local/CI scope; implementation PR merged and exact-head CI passed  
**Implementation branch:** `feature/m3-06-locality-discovery`  
**Baseline main commit:** `e608ac30ceb03698f7f632433c01b7387e9b5f11`  
**Implementation PR:** [#192](https://github.com/mattari20/listing-v2/pull/192)  
**Exact PR head:** `9761e52747e0f2b15fbfee58ac2528ec4f96c57c`  
**Merge commit / verified main:** `e959adb578df6b60f2c308cd0b1f12391f6cb043`

## Delivered implementation

- Added four explicitly allowlisted public geography predicates: `province`, `district`, `city` and `locality`.
- Added a bounded manual locality query to anonymous `GET /directory`.
- Locality matching is Unicode-aware, case-insensitive substring matching and is restricted to the four geography facts; it cannot match general text or private/internal facts.
- Public profile pages display approved geography facts with their existing observation-date context.
- Directory result cards show available locality facts as text.
- Category facet links preserve the selected locality query.
- The existing M3-05 public-projection eligibility pipeline remains authoritative: accepted current claims, approved anonymous publication decisions/projections, latest snapshots, no active suppression, eligible evidence, current source authorization and restricted-category exclusion.
- Manual locality discovery does not request or store browser/device location and does not require JavaScript, maps, map tiles or external assets.

## Synthetic verification added

- Lahore/Punjab/Gulberg fixture matches a Lahore locality query.
- Karachi/Sindh/Gulshan fixture does not match the Lahore query.
- Private `internal_notes` cannot be used as a locality match or exposed.
- Approved province, district, city and locality facts render on the public profile.
- Deeni Madaris fixture remains excluded from locality-filtered results.
- Existing directory governance, source authorization, suppression, supersession, freshness, Unicode and safe-output tests remain in the suite.

## Explicitly deferred

No coordinates, coordinate accuracy/precision model, distance sorting, nearby search, device geolocation, maps, tile service, geocoder, reverse geocoder, authoritative locality gazetteer, boundary source or automatic place-name resolution was implemented. These require a separate data-quality, privacy, licensing, operational and owner-authorization decision. The current text filter is not an authoritative national geography hierarchy.

## Safety and non-interference

No production, V1, Hostinger/hPanel, live database, real/source/provider/student data, migrations, external APIs/AI, paid service, deployment, release, procurement or new spend was used or authorized. The implementation uses synthetic fixtures and existing approved-publication projections only.

## Exact-head verification and merge

- FND-01 PHP 8.5 foundation CI [run #43559187297](https://github.com/mattari20/listing-v2/actions/runs/43559187297): **SUCCESS** on exact PR head.
- Project documentation validation [run #43559187312](https://github.com/mattari20/listing-v2/actions/runs/43559187312): **SUCCESS** on exact PR head.
- Review threads: none unresolved; submitted reviews: none.
- PR #192 squash-merged with expected-head guard as `e959adb578df6b60f2c308cd0b1f12391f6cb043`.
- Implementation merge: `e959adb578df6b60f2c308cd0b1f12391f6cb043`.
- Documentation closeout PR [#193](https://github.com/mattari20/listing-v2/pull/193) merged as `f1c58a5405960cc86816d9c5aef77fee944987b0`.
- Verified `main` commit after documentation closeout: `f1c58a5405960cc86816d9c5aef77fee944987b0`.
- Complete synthetic-only FND-01 suite passed; no live or real/source data was used.
