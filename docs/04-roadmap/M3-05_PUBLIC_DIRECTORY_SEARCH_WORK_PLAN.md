# M3-05 — Public Directory and Search Work Plan

**Date:** 2026-11-14  
**Repository:** \`mattari20/listing-v2\`  
**Status:** Implementation in progress on an isolated branch; exact-head CI and merge pending  
**Baseline:** \`1dd0b89084a45c3b89ad2663760964522b5c6ff6\`  
**Authorization:** Product Owner authorized M3-05 implementation and closeout in the current conversation on 2026-11-14, bounded to synthetic local/CI implementation and the approved roadmap scope.

## 1. Outcome and scope

Deliver anonymous-first, server-rendered public directory browsing, text search, category filters and entity profile pages. Every displayed fact must originate from a current, accepted claim version and a current approved publication projection for surface \`directory\` and audience \`anonymous\`.

Included:
- Anonymous HTML directory landing/search page and UUID profile page.
- Provider, institution, campus, programme and qualification result types.
- Conservative Unicode substring search over an explicit public predicate allowlist.
- Category facets derived from the same eligible public result set.
- Current projection, approved decision, accepted/current claim version, active suppression, newer snapshot, evidence status and source-authorization checks.
- Unknown observation dates shown as unknown; no unsupported freshness threshold.
- Small server-rendered HTML with native forms, semantic landmarks, keyboard operation and no external scripts, fonts, map tiles or images.
- Synthetic tests for publication boundaries, privacy/visibility, search, filters, profile and suppression/revocation.

Excluded / separately gated:
- Real/source data, scraping, ingestion, source access, source-owner contact or external APIs.
- V1, Hostinger/hPanel, production database, production deployment, public release or URL cutover.
- External search engines, geocoding, maps, device location, ranking/recommendation, comparison, reviews, accounts, saved lists, alerts and admissions applications.
- Public Deeni Madaris visibility enablement; category remains excluded by default and is not configurable through this work.
- Final national taxonomy, locality facets, transliteration/fuzzy matching, ranking weights, analytics/query logging and formal accessibility conformance claims.
- No numeric latency/scale target is asserted; M3-09 remains the performance/operational hardening gate.

## 2. Public-field allowlist

Only these published claim predicates may be returned:
- Identity: \`display_name\`, \`common_name\`, \`official_name\`.
- Public description: \`overview\`.
- Public contact/location: \`official_website\`, \`public_contact_phone\`, \`public_contact_email\`, \`public_address\`.
- Education classification: \`education_level\`, \`provider_type\`, \`programme_title\`, \`programme_level\`.

Every other predicate is omitted even if an approved snapshot exists. Values must be scalar strings/numbers (or a scalar \`value\` member), non-empty and capped at 2,000 characters. Profile name is chosen conservatively from a single unambiguous display name, then common name, then official name; conflicting values in the selected name predicate suppress that entity from public results.

## 3. Eligibility contract

A result is visible only when:
1. Projection status is \`approved\`, surface \`directory\`, audience \`anonymous\`.
2. Snapshot status is \`projected\`, and its surface/audience match.
3. Publication decision is \`approved\` for the same surface/audience.
4. Claim version is \`accepted\`, has no successor, and its snapshot is the latest snapshot for that version/surface/audience.
5. No active suppression exists for the snapshot.
6. Every linked evidence reference remains \`eligible_for_review\`; every source authorization remains approved, unrevoked, within its validity window and permits publication for the directory purpose and approved-projection method.
7. Snapshot payload confirms the anonymous directory surface, the same predicate and \`is_deeni_madaris=false\`.
8. Entity type is one of provider, institution, campus, programme or qualification. Deeni Madaris and authority-only entities are not public result categories in this step.
9. The predicate is allowlisted and value safely serializable.

No raw evidence, unapproved claim, private metadata or unsupported entity label is returned.

## 4. User journeys and acceptance criteria

- Anonymous visitor can load \`/directory\` without login or location permission.
- Visitor can search by a name or allowlisted published fact using conservative Unicode substring matching.
- Visitor can filter by the five supported entity categories; category facets/counts are calculated from the same eligible population.
- Visitor can open an entity profile only when it has a current published, unambiguous public name.
- Direct UUID lookup for unpublished, suppressed, superseded, revoked-source, restricted-category or otherwise ineligible entity returns 404 with no identifying metadata.
- A non-allowlisted predicate never appears in search text, facets, profile HTML or links.
- Evidence observation dates are displayed when available; missing dates are explicitly identified and no stale/verified status is inferred.
- Search and profile pages use semantic HTML, labelled native controls, responsive layout and no external assets or mandatory JavaScript.
- Search results remain available without maps, geolocation, accounts or third-party services.
- Query length, pagination and request rate are bounded; no query content is persisted by this feature.

## 5. Architecture and implementation

Use a read-only \`PublicDirectoryQueryService\` over the existing authoritative publication/projection tables. No new physical table, migration, write workflow, search index or third-party service is required for this first database-native slice. A controller and Blade views provide anonymous HTML. Search is a conservative bounded database-backed read over eligible projections; a dedicated engine remains undecided.

## 6. Risks and limitations

- Public-field predicate names are a deliberately narrow first allowlist; adding a field requires rights/privacy review and tests.
- A source authorization is rechecked at read time. The current authorization model does not store a fact-specific public jurisdiction on every claim; publication approval remains the recorded scope decision.
- The current entity model has no dedicated source freshness threshold. The UI reports observation dates only and does not label data stale/current without a policy.
- No map, geography hierarchy, search ranking, fuzzy/transliteration matching, accessibility audit, load benchmark or operational SLA is claimed.
- Synthetic CI proves application logic against fabricated fixtures, not production data quality or legal/source-rights clearance.

## 7. Safety

No production, V1, Hostinger/hPanel, live database, real/source/provider/student/person data, source acquisition, external API/AI, map/geocoder, deployment, procurement or additional spend is included.
