# RCV-01 — Requirements-to-Capability Reconciliation and Residual Backlog

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Inspected main baseline:** `31236b49dbec3e90298e4bfc73999589da2d3f01`  
**Work type:** Repository documentation and source/test inventory; no application changes  
**Disposition:** **RCV-01 COMPLETE** for documentary requirements/capability reconciliation. New feature implementation is not authorized by this record. M3-11 remains BLOCKED / NOT ACCEPTED.

## 1. Purpose and method

RCV-01 closes the follow-on task left open by the Post-M3 Scope and Gap Reconciliation (PR #262): map accepted product and architecture requirements against the actual V2 application routes, controllers, services, migrations and synthetic feature tests; distinguish delivered foundations from partial or absent user-facing capabilities; and produce a non-duplicative residual backlog.

This is a bounded repository inspection of the V2 `main` tree at the baseline above. It inspected:
- Accepted M1-S01 requirement record and the SR-01–SR-14 rows in the implementation traceability matrix.
- M2-S01 system requirements and quality scenarios, M2-S02 domain vocabulary, and M2 requirements-to-architecture traceability.
- V2 routes, controllers, domain policies, services, models, migrations, and the tracked feature/unit test inventory.
- M3-04 P01–P04, M3-05, M3-06 and M3-10 representative workflow implementation records.

**Evidence limitation:** this is source/document inspection, not a fresh execution of the test suite, browser/UX test, independent security/accessibility review, load test, source-rights review or production audit. Existing CI/test results are cited from implementation records where relevant; they are not re-run or upgraded by this document. The repository's test fixtures are synthetic. No V1 content was inspected.

## 2. Current V2 capability inventory

| Capability | Concrete V2 evidence inspected | Reconciliation status | Boundary / limitation |
|---|---|---|---|
| Core governance, claims, versions, evidence, adjudication, publication and audit | `GovernanceCommandService`, persisted governance services, core governance migrations and feature tests | **Implemented foundation** | Synthetic/local/CI evidence only; source rights and live data remain gated |
| Provider/institution identities and typed relationships | `ProviderInstitutionRelationshipService`, `ProviderInstitutionRelationshipTest`, M3-04 P01 record | **Implemented foundation** | Human adjudication remains required; identity merge/split is not an automatic capability |
| Campus, delivery site, programme catalogue, qualification/awarding-body links and cycle-scoped offers | `CampusProgrammeCatalogueService`, migration `2026_11_14_000004_create_campus_programme_catalogue.php`, `CampusProgrammeCatalogueTest`, M3-04 P02 record | **Implemented foundation** | Catalogue/offer structure is not a complete admissions, eligibility, fee or scholarship product |
| Authority and recognition/affiliation relationships | `AuthorityRelationshipService`, authority migration and `AuthorityRelationshipTest`, M3-04 P03 record | **Implemented foundation** | Relationship types and scope are governed; this does not prove real-world recognition or authorize source ingestion |
| Status history and editorial review | `EditorialReviewService`, status-history migration and `EditorialReviewServiceTest`, M3-04 P04 record | **Implemented foundation** | No public-facing administrative UI or actual staffed review operation is established |
| Anonymous public directory, profiles, search and category filters | `GET /directory`, `GET /directory/{entity}`, `PublicDirectoryController`, `PublicDirectoryQueryService`, `PublicDirectoryTest`, M3-05 record | **Implemented bounded experience** | Server-rendered read-only projection; supported fields only; not all discovery journeys are present |
| Manual locality discovery | Directory controller locality parameter, allowlisted locality facts, `PublicDirectoryTest`, M3-06 record | **Implemented bounded experience** | No coordinates, distance sorting, nearby search, device geolocation, maps, geocoder or authoritative national gazetteer |
| Institution representative proposal, review and correction | `UniversityRepresentativeWorkflowController`, `UniversityRepresentativeWorkflowService`, routes under `/institutions/{institution}`, `UniversityRepresentativeWorkflowTest`, M3-10 implementation record | **Implemented bounded workflow** | Authenticated, exact-institution scope; synthetic source context; proposal/correction returns to review; no adjudication or publication endpoint |
| First-party account session and scoped authorization | `AccountSessionController`, `ScopedAuthorization`, `RoleAssignmentService`, identity migrations and `AccountSessionTest` / `ScopedAuthorizationTest` | **Implemented foundation** | No public registration, email verification, password recovery, account self-service or production identity integration evidenced |
| Synthetic AI-agent proposal boundary | `SyntheticAgentProposalAdapter`, field registry/claim services and synthetic-agent tests | **Implemented synthetic adapter only** | No external model/provider, connector, live source retrieval or autonomous publication |
| Moderation and appeal state foundations | Synthetic moderation services/models/migration and `SyntheticModerationWorkflowTest` / `ModerationPrivacyBoundaryTest` | **Foundation only; activation blocked** | No public review, rating, report, appeal or UGC intake routes; no public moderation activation |
| Quality and operational hardening | M3-09 quality record and tests for security headers, query-count, disposable SQLite recovery and regression | **Implemented bounded local/CI checks** | Not a qualified production security/accessibility audit, representative load test, production restore or staffed on-call capability |

## 3. SR-01–SR-14 requirements-to-code reconciliation

Status meanings:
- **Implemented (bounded):** the inspected V2 route/service/test evidence supports the defined narrow behaviour.
- **Partial:** a related foundation exists, but one or more material parts of the requirement are absent or deferred.
- **Not demonstrated:** no matching user-facing feature/service/test was found in the inspected V2 inventory.
- **Deferred / gated:** intentionally excluded until separate scope, rights, qualified review or owner authorization.

| Requirement | Existing V2 implementation and tests | Status | Remaining gap |
|---|---|---|---|
| **SR-01 Pathway-led and direct search** | Direct search is available through `GET /directory`, `PublicDirectoryController` and `PublicDirectoryTest`. | **Partial** | No pathway wizard or optional guided next-step flow was found. Direct discovery exists. |
| **SR-02 Search institution, campus, programme, subject and locality** | Directory query supports text, entity type and manual locality; catalogue contains campus/programme records; `PublicDirectoryTest` and `CampusProgrammeCatalogueTest`. | **Partial** | Search UX does not demonstrate full subject/pathway semantics, ranking, fuzzy/transliteration matching or comprehensive campus/programme discovery journeys. |
| **SR-03 Nearby discovery with optional location permission** | Manual locality query is implemented and does not require device location; M3-06 synthetic locality tests. | **Partial / deferred** | Nearby/distance search, coordinates and optional device-location flow are absent; maps/geocoding remain separately gated. |
| **SR-04 Evidence-backed filters** | Public query is constrained to published projections and allowlisted/searchable/filterable facts; category and locality controls are exposed. | **Partial** | Full user-facing filter coverage for all accepted fields and transparent missing/stale/conflicting-value treatment needs a dedicated acceptance matrix. |
| **SR-05 Like-for-like shortlist comparison** | M1/M2 comparison design exists; no comparison or shortlist route/service/model/test was found in the inspected tree. | **Not demonstrated** | Define comparison dimensions, missing/incomparable values, sponsorship separation, persistence/privacy and share behavior before implementation. |
| **SR-06 Programme/admission facts and evidence** | Programme catalogue, qualification links and cycle-scoped programme-offer foundation exist; `CampusProgrammeCatalogueTest`. | **Partial** | Eligibility rules, admission deadlines, fee components, scholarships/aid, application-cycle lifecycle and source-backed public presentation are not demonstrated as complete features. |
| **SR-07 Distinguish official, provider, AI, estimate and opinion data** | Claim/evidence/source-authorization/provenance and publication controls exist; synthetic agent proposals remain proposal-only. | **Partial** | A consistent public-facing source/verification label and field-level display contract across all relevant facts is not fully demonstrated. No live AI/source data. |
| **SR-08 Official next action** | Public profiles allowlisted official website/contact facts; no V2 application submission route is present. | **Partial** | A safe, clearly attributed official application/admissions link and fallback/unknown-state presentation need explicit field and acceptance coverage. |
| **SR-09 Shortlist, sharing and opt-in updates** | No shortlist, saved-item, share-token, alert or notification route/service/model/test was found. | **Not demonstrated** | Requires product decision on anonymous vs account storage, privacy/retention, sharing controls and opt-in/opt-out lifecycle. |
| **SR-10 Corrections and post-launch authenticated reviews** | University representative claim proposal and correction workflow exists; moderation/appeal metadata foundations and privacy boundary tests exist. | **Partial; public reviews gated** | No public review/rating/reporting/UGC routes; review activation remains post-launch and separately gated. Correction capability is limited to the approved representative workflow, not a general public correction channel. |
| **SR-11 Constrained digital access** | Server-rendered text-first directory, no required JavaScript or external assets; M3-09 local/CI checks. | **Partial** | No representative low-bandwidth field validation, measured performance SLO, broad device/browser matrix or accepted production capacity target. |
| **SR-12 Language and accessibility evaluation** | Unicode-aware search and semantic server-rendered pages; existing synthetic accessibility regression checks. | **Partial** | Full Urdu localization/RTL content and qualified WCAG evaluation are not evidenced; no conformance claim is made. |
| **SR-13 Student personal-data minimization** | Anonymous browsing; moderation schema privacy boundary excludes sensitive student/guardian fields; `ModerationPrivacyBoundaryTest`. | **Implemented for current anonymous browse boundary; broader requirement partial** | Account and any future shortlist/review features require separate data inventory, minimization, retention and safeguarding decisions. |
| **SR-14 Discovery without precise location** | Manual province/district/city/locality facts and locality filter; no device-location permission required; M3-06 tests. | **Implemented (bounded)** | This does not imply nearby/distance capability or a complete authoritative geographic hierarchy. |

## 4. Additional M2 architecture/quality obligations

| Obligation | Evidence/status |
|---|---|
| AR-001 anonymous core discovery | Bounded directory routes exist; anonymous read path implemented |
| AR-002 optional pathway plus direct discovery | Direct discovery exists; guided pathway not demonstrated |
| AR-003 distinct provider/institution/campus/programme search scope | Domain distinctions and catalogue exist; complete search behavior partial |
| AR-004 manual locality without location permission | Implemented for text locality |
| AR-005 evidence-backed filters and unknown states | Publication/evidence gates exist; full UI/filter acceptance partial |
| AR-006 cycle-scoped programme/admission facts | Programme-offer foundation exists; full eligibility/fees/scholarship facts incomplete |
| AR-007 provenance, freshness and conflicts | Governance/provenance/history foundations exist; public field-level transparency partial |
| AR-008 comparison transparency | Not demonstrated in application |
| AR-009–AR-012 identity, official route, reviews and privacy | Identity foundation and official contact fields exist; reviews remain disabled; full official action journey partial |
| AR-013–AR-015 rights-first evidence and human approval | Synthetic governance controls implemented; source acquisition/live AI blocked |
| AR-016–AR-018 Deeni Madaris default OFF | Binding exclusion preserved in public directory and regression tests; do not broaden exposure |
| AR-019–AR-020 coverage and sponsored placement transparency | Not fully demonstrated; do not infer a ranking or sponsorship capability |
| AR-021–AR-022 low-bandwidth, Unicode/RTL and accessibility | Text-first/Unicode foundations; full language/accessibility acceptance remains open |
| AR-023–AR-025 audit, degraded mode and recovery | Audit and disposable SQLite checks exist; production recovery/operations remain unverified |

## 5. Non-duplicative residual backlog

The following backlog is a **planning recommendation**, not implementation authorization. Order is dependency-based; no numeric completion estimate or release date is assigned.

| ID | Priority | Residual package | Scope / acceptance evidence | Preconditions |
|---|---|---|---|---|
| RCV-B01 | P0 | Correct and maintain requirement traceability | Keep SR-01–SR-14 and AR-001–AR-025 mapped to actual code/tests/status; close stale "owner acceptance pending" labels only where owner records support closure | Documentation-only; this RCV-01 record is the reconciliation baseline |
| RCV-B02 | P1 | Admissions and programme decision facts | Define and then implement only authorized cycle-scoped eligibility, deadlines, fees, scholarship/aid facts, provenance, freshness and unknown states; add synthetic feature tests | Narrow owner-approved scope; no source collection or live data; schema change separately authorized if needed |
| RCV-B03 | P1 | Shortlist and comparison | Define like-for-like comparison, missing/incomparable values, sponsored placement separation, save/share and privacy/retention behavior; then implement a bounded slice | Owner product decision; privacy review and exact implementation authorization |
| RCV-B04 | P1 | Search and filter completeness | Map accepted search/filter requirements to public fields, facets, locality and unsupported states; add deterministic synthetic tests for exact/approximate and missing values | No new external search service; separate approval for ranking or recommendations |
| RCV-B05 | P1 | Language and accessibility completion | Urdu/RTL decision, localization content policy, keyboard/screen-reader checks, qualified accessibility assessment and remediation backlog | Qualified human accessibility review before any conformance claim |
| RCV-B06 | P2 | Advanced geography | Coordinates/precision/confidence, nearby ranking, maps, geocoding and authoritative locality sources | Separate data-rights, privacy, security, cost and owner approvals; no location or map vendor presumed |
| RCV-B07 | P2 | Public SEO and performance evidence | Metadata/canonical/sitemap strategy, crawl controls, representative load/capacity methodology and owner-approved SLO | No production URL/cutover; numeric SLO only after owner approval and capacity evidence |
| RCV-B08 | P2 | Account-dependent saved items and alerts | Account lifecycle, saved items, share controls, notification preferences, opt-in/opt-out and retention/deletion | Product and privacy decision; no messaging vendor or spend authorized |
| RCV-B09 | Gated | Public reviews and moderation activation | Review eligibility, abuse/reporting, appeals, moderation staffing, privacy and child-safeguarding controls | Post-launch only; qualified reviews, accepted human operations and separate activation authorization |
| RCV-B10 | Gated | Live source and AI activation | Source-specific rights/access, provider/model decision, privacy/security review, cost controls, human verification and kill switch | Every source and model/service separately approved; no current activation |
| RCV-B11 | Gated | M3-11 production readiness | Human approvals, accepted operational roster, V2 isolation, production backup/restore/RPO/RTO, release candidate and dated go/no-go | All M3-10/M3-11 gates and separate exact-scope production authorization |

## 6. Immediate sequencing recommendation

1. Treat provider/institution/campus/programme CRUD, relationship governance, directory profiles, manual locality and representative correction as **reuse-existing capabilities**, not new milestone implementation.
2. Ask the Product Owner to select the first product gap between RCV-B02 (admissions/fees/scholarships) and RCV-B03 (shortlist/comparison). Neither is started by RCV-01.
3. Before any code, prepare a narrow scope/acceptance pack for the selected gap, including exact routes/services/tables/tests likely to change, data classes, threat/privacy review, migration implications, and synthetic-only fixtures.
4. Keep RCV-B05 accessibility review and RCV-B11 release gates visible; they cannot be declared complete by repository desk review.
5. Re-baseline the old M4–M12 labels only through a separate owner decision. The detailed M3 plan remains authoritative where it supersedes that historical outline.

## 7. Binding exclusions and invariants

- V2 repository only; no V1 access, reuse, inspection or adaptation.
- Synthetic/fictional local/CI fixtures only; no real institution, student, guardian, staff or source data.
- No source acquisition, scraping, permission requests, connectors, external APIs, model/provider calls or AI activation.
- No production, Hostinger/hPanel, live DB, deployment, migration against hosted systems, public launch or URL cutover.
- No new dependency, vendor, paid service, procurement or spend.
- Public UGC, ratings, reviews, reporting and public moderation remain disabled.
- Deeni Madaris remains default-OFF with zero public exposure; no sect/maslak discovery.
- Student interviews, surveys, recruitment and outreach remain deferred.
- No legal/privacy/security/accessibility compliance or certification claim.
- No human reviewer, operator or specialist is appointed by this record.

## 8. RCV-01 closeout

**Completed:** source-tree inventory, SR-01–SR-14 reconciliation, AR-001–AR-025 summary, implementation/test evidence map, residual backlog, sequencing recommendation and binding-exclusion reconciliation.

**Not performed:** application changes, migrations, new tests, full test-suite execution, browser testing, external review, production operation or release.

**Acceptance basis:** merge this document and its progress/catalogue/traceability index updates only after exact-head FND-01 PHP 8.5 foundation CI and Project documentation validation both pass. The merged record closes RCV-01's documentary reconciliation scope only. It does not authorize RCV-B02 onward or complete M3-11.
