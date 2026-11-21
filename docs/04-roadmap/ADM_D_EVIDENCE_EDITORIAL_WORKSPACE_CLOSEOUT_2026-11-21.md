# ADM-D — Evidence and Editorial Operations Workspace Closeout

**Date:** 2026-11-21  
**Baseline:** `dfd3ed1b4dccf321efba8194aa8b70b96d109dfe`  
**Implementation PR:** [#422](https://github.com/mattari20/listing-v2/pull/422)  
**Final tested head:** `a5486e31eb3bed7b77c7c163314dfeb6b90d8109`  
**Merge commit:** `4549f879532c53492a14fc09446bad0a6824778a`  
**Status:** Complete for the bounded university data-reviewer case-inspection and editorial-review surface.

## 1. Reviewer case route and access control

Added `GET /institutions/{institution}/editorial-cases/{case}`.

The route requires:
- An authenticated, active, verified human account.
- An active, non-revoked, unexpired `data_reviewer` assignment for the exact institution scope.
- The institution to be a university institution.
- Server-side `ScopedAuthorization` for `claim.review` on that exact institution.
- The editorial case to belong to the institution, including the existing exact parent relationship check for campus/delivery-site entities.

Case eligibility is rechecked by the query service:
- A submitter cannot inspect their own case.
- An actor who registered linked evidence cannot inspect that case.
- A submitted case can be inspected by an otherwise eligible reviewer.
- An `in_review` case can be inspected only by its assigned reviewer.

Unauthorized or ineligible case detail requests fail closed.

## 2. Case detail projection

The page shows:
- Institution/campus/delivery-site label and case reference.
- Proposal predicate and submitted value.
- Claim-version number, disposition and validity dates.
- Submission timestamp and current editorial status.
- Evidence-reference metadata.
- Editorial status history.
- Bounded immutable predecessor-version/correction history (up to ten predecessor versions).

The view is bilingual English/Urdu, uses RTL for Urdu, provides a skip link and visible keyboard focus, and is responsive.

## 3. Evidence metadata boundary

The reviewer-safe projection includes:
- Reference ID, reference kind and source type.
- Evidence-reference status and claim relationship.
- Whether evidence content was included.
- Observed and recorded timestamps.
- Source-authorization status, validity window and revoked/not-revoked indicator.

It explicitly does **not** return or render:
- Evidence bodies, documents, attachments or file content.
- Source URLs or live source access.
- Integrity digests.
- Full permitted-purpose/method/territory/scope payloads.
- Private actor identifiers.
- Raw audit metadata or arbitrary history metadata.

This is a metadata inspection surface, not an evidence viewer or source-verification service.

## 4. Editorial actions

The page exposes only the existing reviewer workflow:
- Start review for an eligible submitted case.
- Record one supported editorial outcome: `ready_for_adjudication`, `changes_requested` or `held`.

These actions reuse the existing controller/service routes and their server-side authorization and reviewer-independence checks. No new governance capability or direct persistence path was introduced.

Adjudication, publication, suppression, restoration, role management and direct catalogue editing remain separate and are not exposed.

## 5. Privacy and crawler controls

- Response cache policy is private/no-store.
- The global crawler policy explicitly returns `noindex, nofollow` for editorial case routes.
- No source content, raw evidence, digest or arbitrary audit metadata is rendered.
- The workspace remains private and is not a public directory route.

## 6. Verification

Final exact tested head: `a5486e31eb3bed7b77c7c163314dfeb6b90d8109`.

| Check | Result |
|---|---|
| FND-01 Foundation CI | PASS — run #802 |
| Project documentation validation | PASS — run #1353 |
| Composer manifest and locked dependencies | PASS |
| Dependency audit | PASS |
| PHP formatting | PASS |
| Laravel bootstrap and route validation | PASS |
| Synthetic feature suite | PASS — 23 tests, 1,797 assertions |
| Repository artifact hygiene | PASS |

The suite reported **308 warnings**, predominantly existing missing-`.env` fixture warnings. The result is not warning-free.

## 7. Known limitations and deferred scope

- The reviewer assignment model is limited to university data reviewers.
- The current queue lists direct university-institution cases; a unified queue for campus/delivery-site child cases remains future work.
- Case detail can resolve campus/delivery-site parent scope when the case is addressed through the authorised parent institution route.
- Evidence remains metadata-only; no source content, documents or URLs are accessible.
- This agenda does not prove a human reviewer has been appointed, staffed, trained or operationally accepted.
- No professional legal/privacy/security/accessibility review is completed by this work.
- No migrations or field-definition activations were made.
- No V1, Hostinger, production, hosted environment, live database, external AI/API, real/source/personal data, deployment, pilot, paid service or spend was accessed or used.
- Deeni Madaris remains default-OFF with zero public exposure.

## 8. Next agenda

**ADM-E — Correction, quality and operational handoff integration.** Audit how review outcomes, requested corrections, evidence status and accepted catalogue projections connect end-to-end; identify remaining gaps before adding further capabilities. Keep adjudication/publication separately governed and do not infer human operational readiness from repository tests.

**Disposition:** ADM-D complete for its bounded repository/synthetic scope. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
