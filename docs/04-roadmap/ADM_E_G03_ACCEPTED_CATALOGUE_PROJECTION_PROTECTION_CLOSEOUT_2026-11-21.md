# ADM-E-G03 — Accepted Catalogue Projection Protection Closeout

**Date:** 2026-11-21  
**Status:** **COMPLETE — MERGED, SYNTHETIC REGRESSION EVIDENCE**  
**Implementation PR:** [#429](https://github.com/mattari20/listing-v2/pull/429)  
**Merge commit:** `a85a183815d18bf01b96b31e904c4ae857211199`  
**Final tested head:** `e86beb305884b012e86712f5fc6de7e31e6ec4dc`

## Confirmed issue

The correction path previously marked active P02 projections as `superseded` as soon as a successor claim version was created. The public directory and private campus-information queries also treated the existence of any successor as sufficient reason to hide the previously accepted version. This could remove an accepted value from the returned catalogue before its successor had completed acceptance and publication/materialization.

The dedicated programme-offer-fact query had the same premature successor-hiding behavior.

## Delivered safeguards

### P02 accepted projections

- Claim correction no longer changes active rows in `directory_campuses`, `directory_delivery_sites`, `programme_catalogue_entries`, `programme_qualification_links` or `programme_offers`.
- The private institution campus/delivery-site query now treats the active projection row and its accepted claim version as the source of current materialized state; the existence of a proposed successor alone does not hide it.
- The existing governed location materialization path still requires an accepted successor and exact predecessor projection identity before updating a campus or delivery-site row.

### Public directory projections

- A prior approved public claim remains visible while a later version is proposed, returned, held, disputed, or merely accepted without publication.
- A prior public value is superseded in query results only when a later version for the same claim has been accepted and has its own projected/suppressed publication snapshot and matching surface/audience public-projection record.
- This preserves the existing approved value during the gap between claim acceptance and separate publication/outbox projection.

### Programme-offer facts

- The public offer-fact query now applies the same principle: a prior accepted/published fact remains visible until a later accepted version has its own projected/suppressed public snapshot and matching projection for the same surface/audience.
- Existing latest-published-successor behavior remains covered.

## Synthetic regression coverage

- Cross-table P02 matrix proves that correction leaves active campus, delivery-site, programme, programme-qualification-link and programme-offer projection rows tied to the accepted predecessor.
- Campus information remains on the old accepted campus while a successor is proposed, then moves to the successor only after separate acceptance and governed materialization.
- Public directory keeps the old published value while the successor is proposed and after acceptance alone; it switches after successor publication/outbox projection.
- Programme-offer facts keep the old published amount while the successor is proposed and after acceptance alone; they switch after successor publication.

## Validation

On exact head `e86beb305884b012e86712f5fc6de7e31e6ec4dc`:
- PHP 8.5 Foundation CI: **success**.
- Project documentation validation: **success**.
- PHP formatting and Laravel route validation: **success**.
- Synthetic-only suite: **23 passed, 1,857 assertions, 319 warnings**.
- Repository artifact hygiene: **success**.

Warnings remain and are not considered resolved by G03.

## Limitations

G03 protects existing accepted projections; it does not add new programme/qualification/offer successor materialization workflows. The existing campus and delivery-site materialization path supports exact predecessor replacement. Programme catalogue successor materialization remains a separate future implementation/acceptance item. This work does not change the separate authorization required for adjudication, publication or catalogue materialization.

Withdrawal and source-revocation paths retain their separately governed suppression/quarantine behavior. No migration, new route, role, capability, public intake path, real/source/personal data, V1/Hostinger/production/hosted access, external AI/API, deployment, pilot, release, new dependency or spend was introduced.

**ADM-E-G03: CLOSED for accepted-projection non-mutation and publication/materialization visibility behavior in the tested synthetic scopes.** G04 reviewer-safe evidence/history verification remains open. No M3 gate is promoted; M3-11 remains BLOCKED / NOT ACCEPTED and overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
