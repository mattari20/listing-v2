# M3 Product-Wide Integration Verification — 2026-11-21

**Baseline:** `be95a411862e795072c107708c2867d904ef5bb9`  
**Merged main commit:** `fec6a4fa94ea902856baa76275c2a4369675f6d3`  
**Status:** COMPLETE for the bounded synthetic repository integration scope; exact-head CI passed.

## 1. Journey under verification

Institution discovery → institution profile → campus/delivery-site profile → programme profile → admission offer/location → separately governed programme-offer facts (fees, deadlines, eligibility and scholarships).

## 2. Existing integration boundaries inspected

### Public directory and catalogue projections
`PublicDirectoryQueryService` cross-checks public catalogue rows against their exact published claim versions, entity identity, parent institution, current validity and publication eligibility. Institution profiles include only eligible active campuses, delivery sites and programmes. Programme offer links require a matching published offer claim and a delivery location belonging to the programme's institution.

### Public navigation coverage
`PublicDirectoryTest::test_institution_profile_links_published_campuses_delivery_sites_programmes_and_offer_locations` verifies:
- Institution → campus and delivery-site links.
- Campus/delivery-site → parent institution links.
- Institution → programme links.
- Programme → admission-offer location links.
- Delivery-site discovery.
- Suppressed and tampered offer records are excluded.

### Programme-offer facts
`PublicProgrammeOfferFactsQueryService` returns only currently publishable fact projections tied to active programme-offer catalogue rows and exact public surface/audience decisions. It rechecks accepted human adjudication, publication state, evidence and source authorization, freshness, validity, suppression and supersession. Offer facts remain independently versioned from catalogue offer identity.

`ProgrammeOfferFactWorkflowTest` covers exact-offer fee binding, zero-value preservation, correction supersession, pending-successor retention, expiry, freshness, suppression, withdrawal and source-authorization revocation.

### ADM-F successor integration
`CatalogueSuccessorMaterializationTest` now covers programme, qualification-link and admission-offer successor projection replacement, stable projection identity, old projection retention until materialization, missing-predecessor rejection and persistence of the `programme_offer_facts` identity against the stable offer ID.

### ADM-G workspace integration
`AdministrationWorkspaceTest` now covers parent-scoped campus/delivery-site queues, assigned in-review visibility, reviewer exclusion for another reviewer's case, mismatched parent projection rejection and representative correction next-action guidance.

## 3. Cross-module invariants

- A proposed or accepted-but-unpublished successor does not replace the accepted catalogue projection. A successor must have its own approved directory/anonymous publication projection before exact-predecessor materialization may replace the row.
- Materialization requires a current accepted claim version, distinct human adjudicator/materializer, eligible supporting evidence and currently valid source authorization.
- Catalogue offer identity correction preserves the offer ID so existing offer-fact identities remain attached.
- Programme-offer fact correction remains within its separate fact-version/publication lifecycle.
- Public directory display remains gated by exact claim-to-projection agreement and approved publication.
- Administration queues remain private and role/parent scoped; editorial review does not equal adjudication, publication or verified truth.

## 4. Remaining verification limits

- Tests and source review do not constitute real-browser, assistive-technology, external security, legal/privacy, human operations, disaster recovery or production acceptance.
- No real institutional/source data or external source collection is used.
- No deployment, pilot, public launch, V1/Hostinger access or production database operation is included.
- The current public navigation integration test and offer-fact workflow tests cover separate public/profile and fact-governance boundaries; the new stable-offer identity regression bridges their catalogue relationship without introducing a live data dependency.

## 5. Exact-head validation

Final exact-head validation passed on `f9b76270fb546f52f13d7008134adea3ee13141d`: FND-01 PHP 8.5 Foundation CI SUCCESS; Project documentation validation SUCCESS; 349 synthetic tests passed with 1,947 assertions. The full integration regression suite, PHP formatting, Composer audit, Laravel bootstrap/routes and artifact hygiene passed. This does not replace human, legal, security, accessibility, operational, disaster-recovery or production acceptance.

**Disposition:** Product-wide integration review and regression mapping are complete for the bounded synthetic repository scope and merged in PR #437. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
