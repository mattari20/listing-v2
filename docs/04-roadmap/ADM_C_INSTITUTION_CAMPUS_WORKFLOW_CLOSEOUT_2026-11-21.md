# ADM-C — Governed Institution and Campus Information Management Closeout

**Date:** 2026-11-21  
**Baseline:** `68c09dc938b2b6238b8a2a90888f836bfe66ba58`  
**Delivery:** PR [#420](https://github.com/mattari20/listing-v2/pull/420)  
**Status:** Complete for the bounded university institution, campus and delivery-site workflow.

## 1. Routes

- `GET /institutions/{institution}/information`
- `POST /institutions/{institution}/campuses`
- `POST /institutions/{institution}/delivery-sites`

All routes require authentication, a verified and active human account, an active scoped institution representative assignment and server-side `ScopedAuthorization` for the exact university institution. Requests are throttled. The information response is private/no-store and noindex/nofollow.

## 2. Proposal lifecycle

Campus and delivery-site submission:
1. Derives the parent institution from the route and authorizes the actor against that exact institution.
2. Prohibits a client-supplied `institution_entity_id`.
3. Registers the campus/delivery-site identity and submits its field-aware claim within one transaction.
4. Requires an exact active field-definition version, explicit entity-type/provider-category/scope applicability, at least one evidence reference, bounded validity dates and an idempotency key.
5. Uses the existing fixed synthetic-only source processing context. No live source acquisition or source-system access is introduced.
6. Creates an editorial review case. The response explicitly reports `publication: not_published`.

## 3. Field-registry and parent-scope rules

- Campus proposals require a `campus` field key and `campus` scope; delivery-site proposals require `delivery_site` and `delivery_site` scope.
- The field-definition version must explicitly list the exact entity type and university provider category.
- Parent institution category is used only to determine governed provider-category applicability.
- Parent institution field values are not inherited by campus/delivery-site records.
- A location claim must preserve the exact institution ID supplied by the trusted route context.

No field-definition record was activated, migrated or relaxed by ADM-C. If an active exact definition is absent, the workflow fails closed.

## 4. Corrections and projection integrity

- Returned location claims can be corrected through the existing representative correction workflow.
- Claim-version ownership is resolved against the exact campus/delivery-site parent institution, including pending proposals whose location projection has not yet been materialized.
- Corrections create immutable successor versions and return them to editorial review.
- Accepted projection materialization inserts an initial row only for an initial claim. For a correction, it updates only an existing projection whose stored claim version exactly matches the accepted successor's `supersedes_version_id` and whose institution parent remains unchanged.
- The entity display label and location label update only when the successor is accepted and materialized. A proposed correction does not change the existing projection.

## 5. Read endpoint

The information query service returns:
- Institution ID and display label.
- Accepted, active, current campus projections.
- Accepted, active, current delivery-site projections.

A projection with a superseded claim version is not represented as current. The endpoint does not return raw evidence content or unpublished proposal values.

## 6. Verification

On the final exact head `902eff39dade2fcf3c8b4f074fb460fc255fd7bd`:
- FND-01 Foundation CI: **passed**.
- Project documentation validation: **passed**.
- PHP formatting: passed.
- Laravel bootstrap and route validation: passed.
- Synthetic test suite: **23 passed, 1,775 assertions, 305 warnings**.
- Repository artifact hygiene: passed.
- Warnings remain and no warning-free claim is made.

## 7. Explicit exclusions and remaining product work

- No active field definitions were created or activated.
- No general browser-based editing form or complete administrator console.
- No provider self-service for school, college, academy, coaching or other provider categories.
- No review decision, adjudication or publication action was added.
- No real institute/source data, production/V1/Hostinger access, live database operation, external AI/API, deployment, paid service or spend.
- Deeni Madaris remains default-OFF with zero public exposure.

## 8. Next agenda

**ADM-D — Evidence and Editorial Operations Workspace.** Build a safe case-detail and evidence-reference inspection experience; verify independent reviewer eligibility and route-level role/action authorization; expose only permitted metadata and reference details; keep evidence content and source access governed; ensure reviewers cannot approve their own submissions or evidence contributions. Adjudication and publication remain separately authorized and must not be exposed by default.

**Disposition:** ADM-C complete for its bounded scope. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
