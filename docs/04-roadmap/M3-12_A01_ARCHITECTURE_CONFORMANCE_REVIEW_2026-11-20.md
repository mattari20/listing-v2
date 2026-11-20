# M3-12 Agenda 01 — Architecture Conformance Review

**Prepared:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Immutable review baseline:** b685bf75895b68180b4e0b8e4808183c8ee722eb  
**Review type:** Read-only repository architecture-to-implementation reconciliation  
**Status:** BOUNDED ARCHITECTURE CONFORMANCE EVIDENCED; DEFERRED CAPABILITIES AND EXTERNAL READINESS GATES REMAIN OPEN.

## 1. Purpose and authority

This agenda rechecks the current implementation against the owner-accepted M2 architecture. The older M3-02 Step 3 conformance review was performed against a much earlier foundation-only snapshot and must not be read as a description of today's application. This current-main review updates the evidence position; it does not replace or revise the accepted M2 architecture or authorize a new product scope.

The review is repository-only. It does not constitute an independent architecture certification, legal/privacy/security/accessibility assessment, browser usability review, production audit or deployment approval.

## 2. Evidence examined

- Accepted architecture: M2-S01 through M2-S10, including system boundaries, domain model, integration architecture, data/provenance/publication, discovery/geography, AI-agent, identity/security/privacy and operations/recovery design.
- Prior foundation assessment: M3-02 Step 3 architecture conformance review and FND-01 gap assessment, treated as historical baseline evidence rather than current implementation status.
- Current implementation inventory at the pinned commit: routes/web.php, controllers, app/Services/Directory, app/Services/Governance, app/Services/Identity, app/Services/Moderation, config, migrations and feature/unit tests.
- Current delivery records: RCV-B02 through RCV-B11, M3-12 private preview/synthetic dataset and M3-11 current readiness records.

No V1 or production repository was inspected. No Hostinger/hPanel, hosted application, live database, source website, external service or model/provider was accessed.

## 3. Architecture-to-implementation reconciliation

| Accepted architectural concern | Current repository evidence | Assessment | Remaining boundary |
|---|---|---|---|
| Independent V2 and logical modularity | Laravel application with separated Directory, Governance, Identity and Moderation service namespaces and bounded controllers | BOUNDED CONFORMANCE | A modular monolith, not independently deployed services; no microservice split is implied or needed by this review |
| Domain identity and catalogue | Entity/relationship governance, provider categories, campuses, delivery sites, programmes, qualifications, authority profiles and programme offers | IMPLEMENTED FOUNDATION | Real-world identities and source claims remain subject to source-rights and human evidence gates |
| Evidence, provenance and temporal facts | Source authorization records, evidence references, claim versions, programme-offer fact versions, freshness policies and evidence links | IMPLEMENTED FOUNDATION | Current fixtures are synthetic; no live source collection or source reuse approval follows |
| Human adjudication and publication | Persisted adjudication cases/decisions, publication decisions/snapshots, outbox projections, suppressions, restorations and rollback lineage | IMPLEMENTED FOUNDATION | No public data may bypass the approved publication path; human operational staffing remains separately gated |
| Anonymous-first directory and profiles | GET /directory, GET /directory/{entity}, public projection query service and public directory feature tests | IMPLEMENTED, BOUNDED | Read-only anonymous discovery; this is not public registration, participant research or a public launch |
| Search, filters and comparison | Deterministic search/facets, field-registry-driven filters, temporary shortlist and like-for-like comparison; RCV-B03/B04 evidence | IMPLEMENTED, BOUNDED | No external search service, AI ranking, recommendation engine or unsupported field inference |
| Locality and advanced geography | Manual text locality and synthetic nearby-ranking proof; RCV-B06 evidence | IMPLEMENTED, BOUNDED | No device geolocation, real coordinates, maps, geocoder, external geography source or distance claim |
| Programme/admission decision facts | Cycle-scoped programme offers and governed offer facts with evidence, adjudication and publication; RCV-B02 evidence | IMPLEMENTED, BOUNDED | Synthetic facts only; no live fees, eligibility, deadlines or institution claims are verified by this review |
| Identity and saved items | First-party account session, scoped role assignments, account-owned saved items and owner-isolation tests; RCV-B08 evidence | IMPLEMENTED, BOUNDED | No public registration, external identity provider, messaging or alert delivery is enabled |
| Language and accessibility | English/Urdu interface and RTL implementation records, skip/focus/security-header regression tests | CODE EVIDENCE PRESENT; EVALUATION PARTIAL | Manual keyboard/screen-reader/zoom review and qualified accessibility assessment remain outstanding; no WCAG conformance claim |
| AI and external integration independence | Deterministic synthetic proposal adapter; no live provider/model, connector or source retrieval | CONSISTENT WITH DENY-BY-DEFAULT ARCHITECTURE | No source, API, model, connector, crawler or scheduler activation is authorized |
| Reviews and moderation | Synthetic moderation/appeal persistence and privacy tests; no public UGC intake routes | FOUNDATION ONLY; ACTIVATION DISABLED | Public reviews, ratings, reports, appeals and moderation remain gated and disabled |
| Deeni Madaris visibility | Default-OFF configuration/policy and public-surface regression coverage | CONTROL PRESERVED IN CURRENT TESTED SURFACES | No enabling or scope expansion; no claim beyond inspected repository surfaces |
| Operations, performance and recovery | Local/CI quality, logging, synthetic measurement and disposable SQLite tests | PARTIAL | No representative capacity/SLO acceptance, hosted operations, backup/restore rehearsal, RPO/RTO or independent operational review |

## 4. Findings and disposition

1. The current implementation has moved materially beyond the original FND-01 scaffold. The directory, catalogue, governance, publication, identity, saved-items and synthetic preview slices are present and have dedicated implementation records/tests. The old foundation-only status is historical and should not be repeated as the current state.
2. The implementation remains a modular monolith. Service namespaces and domain boundaries are visible in the code; no evidence requires independent services or additional infrastructure. This is consistent with a low-dependency, cost-controlled starting topology.
3. The strongest conformance evidence is synthetic and repository-local. It demonstrates implemented contracts and regression behavior, not real-world data accuracy, source rights, live operations or production performance.
4. Accessibility and operational assurance remain incomplete. Code-level language/RTL and keyboard/focus evidence does not equal manual or qualified accessibility acceptance. Local/CI logging and tests do not equal hosted monitoring or recovery readiness.
5. Gated capabilities remain deliberately inactive. Live source/AI activation, public UGC/moderation, real geospatial services, production access and launch are not authorized.

**Overall result:** BOUNDED CONFORMANCE WITH ACCEPTED M2 ARCHITECTURE FOR THE IMPLEMENTED PRIVATE V2 REPOSITORY SCOPE. Deferred/partial capabilities are not counted as fully implemented. No M3-11 gate is passed by this review.

## 5. Required follow-through

- Preserve the accepted M2 architecture and existing service boundaries; avoid speculative microservices or new vendors.
- Continue feature work only within the already accepted product decisions and exact bounded implementation authorizations.
- Keep accessibility manual/qualified evaluation, source rights, independent security, human operations, hosted isolation and recovery visible as separate gates.
- Treat live source/AI, public UGC and release activation as disabled until their own conjunctive evidence and separate owner authorization exist.

## 6. Explicit exclusions

No code/schema/migration changes, no live database or MySQL connection, no source access, no real/source/personal/student/institute data, no external API/AI/provider/connector, no Hostinger/hPanel/V1/production access, no backup/restore, deployment, DNS/URL cutover, pilot, public launch, new dependency/vendor or spend.

**Agenda 01 disposition:** Repository architecture conformance review COMPLETE for the pinned private V2 source snapshot. It is not full platform acceptance or independent certification.


## 8. Delivery and exact-head verification

- Combined delivery PR [#350](https://github.com/mattari20/listing-v2/pull/350) merged as `e10b7f7e769e2f191bd521a56191c448666f3c31`.
- Exact PR head: `15cbf4796e5ff197213aad8173520aecf2026a52`.
- PHP 8.5 foundation CI #691 (run ID `44679014364`): SUCCESS.
- Project documentation validation #1170 (run ID `44679014390`): SUCCESS.
- Both checks ran on the exact PR head. The change was documentation-only; no application or database implementation was changed.
