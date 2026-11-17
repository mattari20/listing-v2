# M3-11 M11-01 — Option A Controlled Limited V2 Release Scope Charter

**Decision date:** 2026-11-17  
**Decision owner:** Product Owner (decision recorded from the owner's selection of Option A in the project conversation)  
**Repository:** `mattari20/listing-v2`  
**Status:** OWNER-SELECTED SCOPE DIRECTION — CHARTER DETAILS PARTIAL; NOT A RELEASE APPROVAL

## 1. Owner decision

The Product Owner selected **Option A: a controlled, limited V2 release containing only the approved core discovery features**. This replaces an undecided release-scope choice with a bounded product direction. It does not waive any existing safety restriction or downstream M3-10/M3-11 gate.

## 2. Proposed included product surface

The release-scope baseline is limited to the already implemented, bounded M3-05/M3-06 anonymous discovery experience:

- Anonymous, server-rendered directory landing and browse/search page.
- Conservative text search over the explicit public-field allowlist.
- The existing five supported public result categories: provider, institution, campus, programme and qualification.
- Category facets/filters derived only from eligible public results.
- Public entity profile pages for eligible, unambiguous published entities.
- Manual text locality filtering and display for approved province, district, city and locality facts.
- Read-only presentation of current approved anonymous-directory publication projections, with existing evidence, source-authorization, supersession and suppression checks enforced.
- Explicit unknown observation/freshness states; no inferred verification or freshness claims.

This is a scope reuse decision, not authorization to add features or change the implemented behavior. The M3-05 and M3-06 work plans and implementation records remain the detailed feature contracts.

## 3. Excluded from this limited release

Unless a later dated owner decision and all applicable reviews explicitly authorize otherwise, exclude:

- Admissions/application submission, eligibility engines, deadlines, fee calculations, scholarship/aid workflows and payment.
- Shortlists, saved items, comparison, sharing tokens, alerts, notifications and accounts-dependent discovery.
- Ranking, recommendations, sponsored placement, personalization, fuzzy/transliteration search and advanced subject/pathway journeys.
- Coordinates, nearby/distance search, device geolocation, maps, map tiles, geocoding, reverse geocoding and external geography services.
- Live source acquisition, scraping, external source/API access, model/AI agent activation or autonomous publication.
- Public reviews, ratings, UGC, reporting, appeals and public moderation.
- Deeni Madaris public discovery; it remains default-OFF with zero public exposure.
- Student research, interviews, surveys, recruitment or participant activity.
- V1 reuse/access/change, shared production resources, production database inspection, migration, deployment, URL cutover or public launch under this charter.

## 4. Audience, geography and data-class limits

The intended experience is anonymous public discovery, not an authenticated student service. The initial geography model is limited to manually published Pakistan-first text facts (province, district, city and locality) already supported by M3-06; it does not assert complete national coverage or authoritative administrative boundaries.

The only permitted display data class for this scope is the existing narrow, approved, anonymous-directory projection and its allowlisted scalar public facts. No real/source data acquisition or new processing is authorized by this charter. Any eventual real-world data publication requires source-specific rights, provenance, privacy and qualified review before use. No student, guardian, staff or other personal/sensitive data is in scope.

## 5. Release conditions and unresolved charter details

This owner selection establishes the product-scope direction but does not yet provide a complete release charter. Before M11-01 can be accepted, the Product Owner must still confirm in a dated record:

1. The exact initial release geography and any coverage exclusions (Pakistan-first text locality is the proposed baseline, not a claim of nationwide completeness).
2. The intended public audience and any age/minor-specific safeguards or audience restrictions.
3. The permitted source/data classes and the source-rights review process for any real published facts.
4. The exact public surface/host and whether the scope is a private acceptance environment, limited public pilot, or public production release. No environment or audience activation is authorized by this document.
5. The explicit disposition of the still-binding pre-launch student-research deferral and M3-10 pilot-not-accepted status. No pilot or participant activity is approved here.

Until these details and all other gates are satisfied, M11-01 remains PARTIAL and M3-11 remains BLOCKED / NOT ACCEPTED.

## 6. Mandatory controls carried forward

- Anonymous read-only discovery only; no account or write action is added by this scope.
- Only current approved anonymous-directory projections and allowlisted public predicates may be displayed.
- No raw evidence, internal notes, private metadata, unapproved claims, superseded claims or suppressed projections.
- Deeni Madaris remains default-OFF and absent from all public surfaces, counts, facets, maps, APIs, exports and direct public lookup.
- No V1 access/change, Hostinger/hPanel or production/live database access, deployment, migration, DNS/URL cutover or production release.
- No real student/provider/institution/source data, participant activity, external APIs/connectors/AI, new dependency/vendor or additional spend.
- Public UGC/reviews/ratings/reporting/moderation remain disabled.

## 7. M3-11 status and acceptance

| Work package | Disposition after Option A selection |
|---|---|
| M11-01 — Authority and scope | PARTIAL — scope direction selected; remaining charter particulars and formal acceptance outstanding |
| M11-02 — Legal/privacy/safeguarding | BLOCKED — qualified written reviews absent |
| M11-03 — Independent security/accessibility | BLOCKED — independent assessments absent |
| M11-04 — Human operations/support | BLOCKED — named human owners and explicit role acceptances absent |
| M11-05 — Runtime/environment separation | BLOCKED — separately authorized V2-only environment evidence absent |
| M11-06 — Backup/restore/rollback | BLOCKED — V2-specific rehearsal and measured RPO/RTO absent |
| M11-07 — Release candidate | NOT STARTED — no candidate authorized |
| M11-08 — Go/no-go | BLOCKED — evidence pack and accountable approvals absent |
| M11-09 — Production execution | NOT AUTHORIZED |
| M11-10 — Monitored operation/closure | NOT STARTED |

This charter is accepted only as a record of the owner's selected product-scope direction. It is not a legal/privacy/security/accessibility approval, pilot go/no-go, production go/no-go, deployment instruction, release authorization or permission to relax any standing restriction.

## 8. Source contracts

- [M3-05 Public Directory and Search Work Plan](M3-05_PUBLIC_DIRECTORY_SEARCH_WORK_PLAN.md)
- [M3-06 Geography and Discovery Work Plan](M3-06_GEOGRAPHY_AND_DISCOVERY_WORK_PLAN.md)
- [RCV-01 Requirements-to-Capability Reconciliation](RCV-01_REQUIREMENTS_CAPABILITY_RECONCILIATION_2026-11-17.md)
- [M3-11 Controlled Production Launch Preflight](M3-11_CONTROLLED_PRODUCTION_LAUNCH_PREFLIGHT.md)
