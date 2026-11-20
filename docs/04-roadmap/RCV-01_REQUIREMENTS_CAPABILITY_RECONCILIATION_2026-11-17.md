# RCV-01 — Requirements-to-Capability Reconciliation and Residual Backlog

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Inspected main baseline:** `31236b49dbec3e90298e4bfc73999589da2d3f01`  
**Work type:** Repository documentation and source/test inventory; no application changes  
**Disposition:** **RCV-01 COMPLETE AND MERGED** for documentary requirements/capability reconciliation. New feature implementation is not authorized by this record. M3-11 remains BLOCKED / NOT ACCEPTED.

## 1. Purpose and method

RCV-01 closes the follow-on task left open by the Post-M3 Scope and Gap Reconciliation (PR #262): map accepted product and architecture requirements against the actual V2 application routes, controllers, services, migrations and synthetic feature tests; distinguish delivered foundations from partial or absent user-facing capabilities; and produce a non-duplicative residual backlog.

This is a bounded repository inspection of the V2 `main` tree at the baseline above. It inspected:
- Accepted M1-S01 requirement record and the SR-01–SR-14 rows in the implementation traceability matrix.
- M2-S01 system requirements and quality scenarios, M2-S02 domain vocabulary, and M2 requirements-to-architecture traceability.
- V2 routes, controllers, domain policies, services, models, migrations, and the tracked feature/unit test inventory.
- M3-04 P01–P04, M3-05, M3-06 and M3-10 representative workflow implementation records.

**Evidence limitation:** this is source/document inspection, not a fresh targeted feature test, browser/UX test, independent security/accessibility review, load test, source-rights review or production audit. The existing synthetic suite was run by PR #263 CI as a regression gate; that run does not convert this documentary inventory into a fresh manual functional audit. The repository's test fixtures are synthetic. No V1 content was inspected.

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


## 9. Exact-head validation and merge closeout

- PR [#263](https://github.com/mattari20/listing-v2/pull/263) — exact validated head `d555a18dddd138ca828cf4fa61307dda584f4449`.
- FND-01 PHP 8.5 foundation CI [run #44028817608](https://github.com/mattari20/listing-v2/actions/runs/44028817608) — **SUCCESS**. Composer validation/install, dependency advisory audit, Pint, Laravel bootstrap/routes, existing synthetic suite and artifact hygiene completed.
- Project documentation validation [run #44028817672](https://github.com/mattari20/listing-v2/actions/runs/44028817672) — **SUCCESS**.
- Existing synthetic suite: **15 passed, 1,044 assertions**; **218 non-fatal warnings** are the repository's existing attempts to read the intentionally absent local `.env`; no `.env` was created.
- Review threads: none unresolved; submitted reviews: none.
- PR #263 squash-merged with expected-head guard as `54045426067eb8cd48403e2829ceff0c4602dac1`.
- Verified `main` points to the merge commit `54045426067eb8cd48403e2829ceff0c4602dac1`.

**Final disposition:** RCV-01 is **CLOSED** for requirements-to-capability documentary reconciliation. This acceptance is not owner acceptance of every product requirement, a fresh manual functional audit, or permission to implement RCV-B02 onward. M3-11 remains BLOCKED / NOT ACCEPTED.


---

## 10. Current delivery reconciliation and controlled acceptance handoff — 2026-11-20

This dated addendum supersedes the 2026-11-17 *planning-only* status of the residual feature packages below where subsequent merged implementation and closeout evidence exists. It does not rewrite the original inspection baseline or convert bounded synthetic delivery into production acceptance.

### 10.1 Current residual-package disposition

| Package | Current repository evidence | Current disposition | Remaining boundary |
|---|---|---|---|
| RCV-B01 — requirement traceability | RCV-01 and subsequent traceability updates | Reconciled for the bounded repository evidence now recorded | Continue maintaining evidence; do not infer unimplemented capability |
| RCV-B02 — admissions, fees and scholarships | PR #318 implementation; PR #319 closeout | COMPLETE for approved synthetic offer-scoped admissions-fact governance | No live/source data, admissions application, applicant accounts, payments or notifications |
| RCV-B03 — shortlist and comparison | PR #320 scope decision; PR #322 implementation/closeout | COMPLETE for temporary session-only shortlist and like-for-like comparison | No persistent list in this slice, share links or alerts; separate RCV-B08 private saved-items slice is distinct |
| RCV-B04 — search and filter completeness | PR #324 implementation; PR #325 pagination/regression closeout; PR #326 documentation reconciliation | COMPLETE for bounded registry-backed search/filter and pagination behavior | No external search, semantic/fuzzy/transliteration search, recommendations or ranking |
| RCV-B05 — language and accessibility | PR #327 implementation; PR #328 closeout | COMPLETE for English/Urdu UI and bounded RTL/accessibility code/tests | Manual keyboard, screen-reader, contrast, zoom/reflow and qualified accessibility evaluation remain outstanding; no WCAG conformance claim |
| RCV-B06 — advanced geography | PR #329 design/policy; PR #331 synthetic domain proof; PR #332 closeout | COMPLETE for approved pure-domain synthetic proof only | No real coordinates, source rights, schema/persistence, public nearby integration, device geolocation, maps or geocoding |
| RCV-B07 — SEO and performance | PR #335 fail-closed SEO implementation; PR #337 synthetic performance harness and associated closeout evidence | COMPLETE for bounded fail-closed SEO controls and synthetic in-process measurement | Indexing remains disabled by default; no public sitemap/indexing activation, production URL, representative load/capacity evidence or numeric SLO |
| RCV-B08 — account saved items and alerts | PR #340 private saved-items implementation; PR #341 closeout | COMPLETE for private account-owned saved items for existing pre-provisioned active/verified accounts | Sharing, alert preferences/delivery, public registration/recovery/closure and automatic expiry remain deferred; DP-02/DP-03 target gates remain |
| RCV-B09 — public reviews and moderation | PR #342 preflight | PREFLIGHT COMPLETE ONLY | Public reviews, ratings, reports, moderation and appeals remain disabled; qualified review, staffing and separate activation approval absent |
| RCV-B10 — live source and AI activation | PR #343 preflight | PREFLIGHT COMPLETE ONLY | No source access, extraction, model/provider, agent, connector, crawler or scheduler activation |
| RCV-B11 — production readiness | PR #344 final gate reconciliation | DOCUMENTARY RECONCILIATION COMPLETE ONLY | M3-11 remains BLOCKED / NOT ACCEPTED; no candidate, go/no-go or production execution |

### 10.2 Current controlled acceptance position

The implementation backlog RCV-B02 through RCV-B08 has received its bounded repository implementation/closeout work. This is not a declaration that every SR-01–SR-14 requirement is fully satisfied or that every feature is ready for real users. The remaining product limitations above are explicit and remain visible.

**The next agenda is controlled acceptance/readiness evidence intake, not another speculative feature package.** Do not start a duplicate implementation agenda unless the Product Owner selects a specific remaining capability and approves its exact scope.

### 10.3 M3-11 current gate interpretation

| Gate | Current supported status | Next required evidence |
|---|---|---|
| M3-11-01 scope/authority | CLOSED for scope definition | New dated owner decision only if scope changes |
| M3-11-02 legal/privacy/safeguarding | Owner internal review delivered; qualified gate remains BLOCKED | Qualified written assessments where applicable and Product Owner dispositions |
| M3-11-03 security/accessibility | Internal repository desk review and bounded code remediation delivered; independent release assurance remains BLOCKED | Independent candidate/target security review and qualified accessibility evaluation, findings, remediation and retest |
| M3-11-04 operations/support | CLOSED for current repository-only private development under owner-led model | Before hosted acceptance, external reviewer access, real users, public support, pilot or release: identify applicable human roles and obtain acceptance, competence, availability and coverage |
| M3-11-05 environment separation | Resource/CLI readiness subtask complete; hosted isolation BLOCKED | Separate exact-scope authorization and accepted V2-only HTTP, filesystem, storage, identity and resource-isolation evidence; current isolation register remains 0/18 accepted |
| M3-11-06 recovery | Weekly backup cadence accepted as current-stage policy; recovery gate BLOCKED | Approved recovery objectives, named recovery owner/verifier, V2-only boundary and separately authorized restore/rollback rehearsal with measured RPO/RTO |
| M3-11-07 candidate | NOT STARTED / BLOCKED | All prerequisite gates plus separate candidate-creation authorization |
| M3-11-08 decision | BLOCKED / NOT DECIDED | Complete exact-candidate dossier and required accountable human decisions |
| M3-11-09 execution | NOT AUTHORIZED | Separate exact-scope written execution authorization |
| M3-11-10 monitoring/closure | NOT STARTED | Only after a validly authorized operation |

M3-10 pilot readiness remains NOT ACCEPTED and the two-person tabletop remains NOT EXECUTED. No signed GO, conditional GO or NO-GO is recorded. The current decision state is NOT DECIDED / BLOCKED.

### 10.4 Work permitted now

1. Keep repository records, requirement traceability and exact evidence references consistent.
2. Receive and reconcile actual reviewer reports, owner decisions and human role acceptances when supplied.
3. Continue only already-authorized synthetic local/CI maintenance that does not expand product or operational scope.
4. Reassess the next implementation agenda only after a concrete gap is selected and its scope/acceptance is approved.

### 10.5 Stop conditions

No V1 or production access; no additional Hostinger/hPanel or hosted environment activity; no live database, migration, backup download or restore; no deployment, DNS/URL cutover or public launch; no real/source/personal/student/guardian/child/staff data or participant activity; no external source, API, AI/model/provider, connector, crawler, scheduler, vendor or new dependency; no additional spend; no public UGC/reviews/ratings/reporting/moderation activation; Deeni Madaris remains default-OFF with zero public exposure.

Passing CI, merged documentation, the owner’s internal desk reviews or AI-assisted analysis must not be represented as independent professional assurance or production acceptance.

**Disposition:** RCV-01 current delivery status is reconciled for repository evidence. The next active agenda is controlled acceptance/readiness evidence intake. M3-11 production readiness remains BLOCKED / NOT ACCEPTED, and no production execution is authorized.
