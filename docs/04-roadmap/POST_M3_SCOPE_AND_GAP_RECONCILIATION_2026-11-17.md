# Post-M3 Scope and Gap Reconciliation — M4 Planning Preflight

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Inspected baseline:** `9988dab035f5581b5e72ea877401cb8e29c8af1d`  
**Disposition:** Documentation-only reconciliation DELIVERED; M4 implementation NOT AUTHORIZED; M3-11 production readiness BLOCKED / NOT ACCEPTED.

## 1. Roadmap authority and interpretation

The [Project Master Roadmap](PROJECT_MASTER_ROADMAP.md) contains an older M4–M12 product-module outline. It expressly states that the [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md) supersedes that earlier high-level outline wherever they differ. M3 already includes implementation of provider/institution/campus/programme administration (M3-04), directory/search (M3-05), geography/discovery (M3-06), synthetic agent/governance (M3-07), identity/security foundations (M3-08) and hardening (M3-09).

Consequently **do not automatically begin a second M4 institution-management implementation**. Treat the historical M4 label as a candidate for roadmap re-baselining, not an active separately approved implementation package. No new milestone name, weights, percentage or acceptance status is approved by this document.

## 2. Existing implementation versus remaining gap

| Historical later milestone | Relevant existing M3 evidence | Remaining scope / decision | Classification |
|---|---|---|---|
| M4 Institution, campus and programme management | M3-03 governance; M3-04 P01–P04 provider/institution/campus/programme and editorial lifecycle; M3-10 representative submit/review/correction workflow | Review field-by-field against institution/programme requirements; avoid duplicating existing CRUD, claims, audit or review. Any new write workflow needs exact authorization and tests | Overlap / delta analysis needed |
| M5 Nearby discovery, search, filters and maps | M3-05 anonymous directory/search/filter/profile; M3-06 locality-aware discovery | Coordinates, distance ranking, maps, geocoding and national locality data deferred; rights, privacy, cost and external-service gates open | Partial; location-dependent features deferred |
| M6 Institution profiles and verified information | M3-05 public UUID profiles, allowlisted fields, publication and provenance guards; M3-07 I5 registry-aware projection | Real verified-source data, freshness operations, source clearance and human publication operations not authorized | Synthetic foundation delivered; live evidence blocked |
| M7 Admissions, eligibility, fees and scholarships | M1 research and M2 architecture; programme/domain foundation in M3 | Define a bounded first slice and requirements-to-code gap matrix before claiming functionality | Not demonstrated as a completed feature |
| M8 Shortlist and comparison | M1/M2 requirements and architecture | Exact product scope, persistence/privacy model, anonymous versus account behavior and acceptance tests | Not demonstrated as a completed feature |
| M9 Ratings, reviews, moderation and trust | M3-08 identity, moderation/appeals metadata and privacy/security foundations | Public UGC, reviews, ratings, reporting and public moderation remain disabled; qualified privacy/safeguarding, staffing and separate launch approval required | Foundation only; activation blocked |
| M10 AI collection, reconciliation and refresh | M3-07 I1–I8-A synthetic governance, deterministic fake adapter, tests | Source-specific reuse rights, model/provider, privacy/security/operations and explicit activation approval absent | Live agent/source activation blocked |
| M11 SEO, accessibility, performance and public experience | M3-05 server-rendered directory; M3-09 synthetic accessibility, query-count, security-header and recovery checks | Qualified accessibility/security reviews, representative load/SLO, SEO and real-world operational evidence still open | Partial |
| M12 Full acceptance and controlled release planning | M3-10 readiness framework and M3-11 production preflight | Human reviews, accepted owner roster, V2 production isolation, backup/restore/RPO/RTO, exact release candidate and go/no-go | Blocked |

The above is a **documentary traceability assessment**, not a fresh source-code audit, new test run, external review or owner acceptance.

## 3. Immediate no-duplication work package

1. Create a canonical feature inventory mapping each historical M4–M12 item to M3 evidence, with **implemented / partial / deferred / not demonstrated / blocked** statuses.
2. For the proposed next implementable slice, inspect exact routes, controllers, policies, schema and synthetic tests against accepted M1/M2 requirements before specifying changes.
3. Require a Product Owner decision whether to (a) retain historical milestone labels as a residual backlog, or (b) approve a new post-M3 sequence with new scopes and evidence-based weights. Neither option is presumed accepted.
4. Keep release governance separate from feature planning. M3-11 cannot be marked complete or bypassed by starting a new roadmap item.
5. Prepare only a narrow implementation authorization pack after the gap assessment; no new code is approved by this preflight.

## 4. M3-11 carried-forward blockers

- M3-10 pilot readiness NOT ACCEPTED; two-person paper tabletop NOT EXECUTED.
- No accepted owner-approved bounded pilot/release charter in the reconciled repository evidence.
- Qualified legal/privacy, safeguarding/research applicability, independent security and accessibility decisions absent.
- Accepted human release/incident/support/privacy-data operational roster absent.
- V2-only production environment isolation, backup/restore and approved RPO/RTO unverified.
- No exact release candidate, full production release verification or final dated go/no-go.
- No production access, Hostinger/hPanel, live DB, migration, deployment, public launch or cutover authorized by this preflight.

## 5. Stop conditions and safety

V2 only. Do not access V1. Synthetic/fictional local/CI inputs only. No real student, guardian, staff, institution or source data; no external sources, scraping, AI/model/API/connector activation; no procurement or new spend. Public UGC, reviews, ratings, reporting and public moderation remain disabled. Deeni Madaris remains default-OFF and absent from public exposure. No production, Hostinger/hPanel, live database, hosted pilot, deployment or release. Do not appoint or impersonate qualified human approvers.

## 6. Acceptance and reporting

This package is complete when the document is committed, the exact PR head passes required CI/documentation validation, and the PR is merged with its exact-head SHA verified. This is **planning-preflight completion only**. It does not complete M3-11, authorize M4 implementation, change any production or pilot gate, or justify a new numerical M3/project completion percentage.
