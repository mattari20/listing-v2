# M2-S04 / M2-S05 / M2-S06 Joint Validation and Owner Review — 2026-11-12

**Status:** Coordinated documentation package delivered for owner review; acceptance pending.  
**Method:** The three steps are authored jointly to align stack choices, data governance and discovery projections. Their task weights, decisions and closure gates remain separate.

## 1. Deliverables

- [M2-S04 Technology Stack Evaluation](M2-S04_TECHNOLOGY_STACK_EVALUATION.md) — criteria, backend/frontend/data/search/map/async options, release and licence evidence, conditional recommendation and owner decision boundary.
- [M2-S05 Data Architecture, Provenance and Publication Governance](M2-S05_DATA_ARCHITECTURE_PROVENANCE_PUBLICATION.md) — logical data domains, provenance lineage, source-rights gates, retention principles, validation, human review, publication and rollback.
- [M2-S06 Search, Discovery and Geography Architecture](M2-S06_SEARCH_DISCOVERY_GEOGRAPHY_ARCHITECTURE.md) — discovery journeys, query pipeline, indexes, relevance, geography, map/geocoder constraints and default-OFF negative requirements.
- [M2-S02/S03 Owner Acceptance Record](M2-S02-S03_OWNER_ACCEPTANCE_RECORD_2026-11-12.md) — explicit acceptance and closure of the preceding baseline.

## 2. Separate task progress

### S04 — Technology stack evaluation (10% M2 weight)

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Evaluation criteria | 15% | S04 section 2 | Complete — draft |
| T02 Backend/frontend options | 20% | S04 sections 3–4 | Complete — draft |
| T03 Data/search/maps/async options | 25% | S04 sections 5–6 | Complete — draft |
| T04 Hosting/cost/operability | 20% | S04 section 8 | Complete — draft |
| T05 Recommendation/owner decision | 20% | S04 section 9; owner decision pending | Pending |

**S04 draft completion: 80%.** No stack/vendor decision has been approved.

### S05 — Data architecture and governance (12% M2 weight)

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Data domains | 20% | S05 section 2 | Complete — draft |
| T02 Provenance | 25% | S05 section 3 | Complete — draft |
| T03 Rights/retention/privacy | 15% | S05 section 4 | Complete — draft |
| T04 Validation/publication/conflict/rollback | 25% | S05 sections 5–7 | Complete — draft |
| T05 Review | 15% | Joint consistency and owner review pending | Pending |

**S05 draft completion: 85%.** Source access and ingestion remain prohibited.

### S06 — Search, discovery and geography (8% M2 weight)

| Task | Weight | Evidence | Status |
|---|---:|---|---|
| T01 Discovery capabilities | 20% | S06 section 2 | Complete — draft |
| T02 Geo quality/privacy | 20% | S06 sections 6–7 | Complete — draft |
| T03 Indexing/freshness/relevance | 20% | S06 sections 3–5 and 9 | Complete — draft |
| T04 Deeni Madaris enforcement | 25% | S06 section 8 | Complete — draft |
| T05 Review | 15% | Joint consistency and owner review pending | Pending |

**S06 draft completion: 85%.** V2-DEC-006 remains binding and unmodified.

## 3. Cross-step consistency checks

- S04 candidate data/search/map capabilities support the logical S03 boundaries without imposing a service topology.
- S05 evidence/claim/publication separation consumes S02 temporal and identity semantics.
- S06 indexes and maps are rebuildable read projections, not systems of record.
- S05 rights and privacy gates precede any retrieval or publication.
- S06 public eligibility is controlled by S05 publication decisions and V2-DEC-006; the category suppression rule applies to every public surface and side channel.
- Map renderer, tile source and geocoder are separate contracts; public OSM services are not treated as unlimited or SLA-backed.
- No source collection, external provider activation, physical schema, API implementation, procurement or deployment is authorized.

## 4. Owner review checklist

- [ ] S04 criteria and option comparisons are sufficiently balanced and evidence-based.
- [ ] Conditional modular-monolith / HTML-first direction is acceptable as a recommendation, not an approved implementation choice.
- [ ] Backend framework options (Laravel, Django, NestJS) and data/search/geospatial options are adequately compared.
- [ ] S05 provenance, rights, retention, validation, publication and rollback controls are acceptable.
- [ ] S06 search, index, map, geolocation and privacy boundaries are acceptable.
- [ ] Deeni Madaris default-OFF behaviour is complete across public surfaces and side channels.
- [ ] Unresolved matters may be carried to S07-S10 and specific owner/legal decisions.

**Decision requested:** Accept S04-S06 as architecture/design baselines with unresolved stack/vendor, legal, operational and ranking choices carried forward. Acceptance of the evaluation does not approve a selected stack, spend, procurement, source access, implementation or deployment.
