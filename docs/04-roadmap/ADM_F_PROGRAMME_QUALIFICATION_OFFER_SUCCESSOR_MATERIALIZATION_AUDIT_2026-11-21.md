# ADM-F — Programme, Qualification and Admission Offer Successor Materialization Audit

**Date:** 2026-11-21  
**Baseline main:** `be95a411862e795072c107708c2867d904ef5bb9` (PR #434 profile-navigation integration)  
**Agenda:** Administration and Institute Information Management Completion  
**Status:** COMPLETE — implementation and synthetic regression tests passed exact-head CI; merged in PR #437 as `fec6a4fa94ea902856baa76275c2a4369675f6d3`.

## 1. Purpose

ADM-F addresses the remaining catalogue-lifecycle limitation explicitly recorded by ADM-E-G03: programme, qualification-link and programme-offer successor claims do not yet have the exact-predecessor projection replacement behavior already implemented for campus and delivery-site records.

This audit distinguishes catalogue identity projections from programme-offer facts. The latter have their own versioned fact workflow and are not the same object as the `programme_offers` catalogue relationship.

## 2. Current implementation inspected

Current-main files:
- `app/Services/Directory/CampusProgrammeCatalogueService.php`
- `app/Services/Directory/InstitutionCampusInformationQueryService.php`
- `app/Services/Directory/PublicDirectoryQueryService.php`
- `app/Services/Directory/PublicProgrammeOfferFactsQueryService.php`
- `app/Services/Governance/PersistedGovernanceWorkflowService.php`
- `tests/Feature/InstitutionCampusWorkflowTest.php`
- `tests/Feature/PersistedGovernanceWorkflowTest.php`
- `tests/Feature/ProgrammeOfferFactWorkflowTest.php`

### Existing safeguards
- Materialization requires a current accepted claim version with no later successor.
- An accepted human adjudication is required and the materializer must be a distinct human from the adjudicator.
- Supporting evidence must remain eligible and its source authorization approved, unrevoked and within its validity window.
- Evidence submitters cannot materialize the catalogue record.
- Campus and delivery-site projections already support successor replacement only when the successor names the exact currently materialized predecessor and preserves the parent institution.
- ADM-E-G03 keeps accepted/public values visible while a successor is merely proposed or accepted-but-unpublished.
- Programme-offer facts are independently versioned and published through `ProgrammeOfferFactWorkflowService` and `PublicProgrammeOfferFactsQueryService`.

### Confirmed gap
In `CampusProgrammeCatalogueService::materializeAcceptedRecord`:
- `campus` and `delivery_site` delegate to `materializeLocationProjection`, which handles first materialization and exact-predecessor replacement.
- `programme` always inserts a new `programme_catalogue_entries` row.
- `programme_qualification` always inserts a new `programme_qualification_links` row with a new identity.
- `programme_offer` always inserts a new `programme_offers` row with a new identity.

The latter three branches do not yet update an existing projection by matching `claim_versions.supersedes_version_id` to the projection's exact `claim_version_id`. This is the specific remaining ADM-E-G03 limitation. A successor therefore has no safe, explicit stable-record replacement contract in those branches.

## 3. ADM-F implementation contract

Implement exact-predecessor successor materialization for:
1. Programme catalogue entries.
2. Programme-to-qualification/awarding-body links.
3. Programme admission-offer catalogue records.

For each projection type:
- First materialization is permitted only when no projection exists and the claim version has no predecessor.
- Successor materialization is permitted only when exactly one existing projection is found by the predecessor claim-version ID, its entity/parent relationships match, and the successor's `supersedes_version_id` equals that exact predecessor.
- Update the existing projection row in place and preserve its stable projection identity (especially programme-offer IDs referenced by offer facts).
- Fail closed for missing, duplicate, mismatched, cross-institution or stale predecessor projections.
- Keep the existing accepted/public projection unchanged until the successor has its own approved `directory` / `anonymous` publication snapshot and matching approved public projection; only then may exact-predecessor materialization replace the accepted catalogue row.
- Preserve current idempotency: retrying the same materialization command returns the same projection identity; changed command reuse is rejected.
- Keep programme-offer facts in their separate versioned fact workflow; do not rewrite fact history as a side effect of catalogue-offer identity correction.

## 4. Required synthetic regression matrix

- Initial programme, qualification-link and programme-offer materialization.
- Exact predecessor successor replacement for each of the three projection types.
- Stable row identity after successor materialization.
- Old projection remains unchanged while the successor is proposed, accepted-but-unpublished, or published-but-not-yet-materialized.
- Missing predecessor projection rejects a successor; it must not create a replacement row.
- Wrong predecessor, stale predecessor, duplicate predecessor match and wrong programme/institution reject without writes.
- Offer delivery location must remain a campus/delivery site belonging to the programme's exact institution.
- Same idempotency key/same command returns the same projection identity; changed command under the same key fails.
- Existing programme-offer facts remain attached to the stable offer ID and their own version/publication lifecycle remains unchanged.
- No publication, public projection, direct catalogue editing or authorization bypass is introduced.

## 5. Scope and exclusions

Repository/local/GitHub CI only, synthetic fixtures only, existing dependencies only, no additional spend. No real institution/student/source/personal data, source retrieval/contact/scraping, external API/AI/model, new role or route, migration, field-definition activation, V1/Hostinger/hPanel/production/hosted access, deployment, pilot, release or public activation. No changes to programme-offer fact governance. Deeni Madaris remains default-OFF with zero public exposure.

This agenda does not authorize adjudication/publication UI, alter role/action mappings, or imply human operational readiness. Existing separation of duties and evidence/source-authorization checks remain mandatory.

## 6. Acceptance criteria

1. Initial and successor materialization work for programme, qualification-link and offer projections.
2. Successor replacement requires the exact currently materialized predecessor version.
3. Stable projection IDs are preserved across successor replacement.
4. Missing, stale, duplicate, cross-scope and mismatched predecessor cases fail closed without changing existing rows.
5. Existing accepted/public projections remain unchanged until the successor has its own approved directory/anonymous public projection; publication must precede successor materialization.
6. Offer fact relationships and their independent versioning remain intact.
7. Synthetic feature coverage proves idempotency, rollback and no-publication-bypass invariants.
8. Exact-head FND-01 Foundation CI and Project documentation validation pass; warnings are reported accurately.
9. Closeout documentation distinguishes repository verification from human, legal, security, production and operational acceptance.

## 7. Implementation progress — 2026-11-21

The current agenda branch now implements exact-predecessor successor replacement for programme, qualification-link and programme-offer catalogue projections in `CampusProgrammeCatalogueService`. It validates that the successor references the immediately preceding version of the same claim, requires the successor's own approved directory/anonymous publication snapshot and matching approved public projection before replacement, updates the existing projection row in place, preserves stable projection IDs, and rejects missing/stale/mismatched predecessors and natural-key conflicts. No schema migration or new dependency was added.

Synthetic feature coverage was added in `tests/Feature/CatalogueSuccessorMaterializationTest.php` for programme, qualification-link and offer successor replacement, retention of the old projection before materialization, stable offer identity/fact identity and missing predecessor rejection.

Final exact-head validation passed on `f9b76270fb546f52f13d7008134adea3ee13141d`: FND-01 PHP 8.5 Foundation CI SUCCESS; Project documentation validation SUCCESS; 349 synthetic tests passed with 1,947 assertions. Composer audit, Pint, Laravel bootstrap/routes and repository artifact hygiene passed. The publication-order guard was exercised: an accepted but unpublished successor is rejected; after its approved directory/anonymous public projection exists, exact-predecessor materialization succeeds.

**Disposition:** ADM-F implementation and synthetic regression coverage are complete and merged in PR #437. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
