# RCV-B03 — Session-Only Shortlist and Like-for-Like Comparison Implementation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `7b3c65a6b9e3ab10a0996f315f03030cf7d90375`  
**Branch:** `feat/rcv-b03-session-shortlist-comparison`  
**Authorization:** Product Owner approved temporary session-only shortlist on 2026-11-20.  
**Status:** Implementation and synthetic tests in progress; exact-head CI pending.

## 1. Accepted first-slice decision

The first RCV-B03 slice uses Laravel session state only. It does not create persistent saved lists, shareable URLs, user accounts, notification subscriptions or new personal-data collection.

The initial configurable maximum is five options, within the provisional 3–5 product target. Mixed entity types are rejected. The state is cleared with the Laravel session lifecycle and is not stored in a dedicated shortlist table or attached to an account.

## 2. Implementation

- Add/remove public entity IDs using POST/DELETE routes with CSRF protection and throttling.
- Resolve every selected ID through `PublicDirectoryQueryService::find()`; unpublished, suppressed, revoked, ambiguous and Deeni Madaris records remain unavailable.
- Reject a selection if its entity type differs from the existing shortlist.
- Enforce the configured shortlist limit.
- Compare only selected entities of the same category.
- Build comparison rows only from facts already present in the approved anonymous public profile projection.
- Display absent values as “Not stated in approved public information”; preserve a literal zero as zero.
- Display evidence observation dates without inventing a freshness classification for fields whose public projection does not provide one.
- Keep programme offer facts separate by offer and admission cycle; do not merge unlike cycles or calculate totals.
- Use responsive, horizontally scrollable comparison tables with semantic headings and visible session-only disclosure.
- Configure file-backed sessions as the non-testing default; PHPUnit retains its explicit isolated array session driver.

## 3. Files in scope

- `app/Http/Controllers/PublicDirectoryController.php`
- `app/Services/Directory/PublicDirectoryComparisonService.php`
- `app/Services/Directory/PublicDirectoryQueryService.php` (programme-offer profile discriminator correction)
- `app/Services/Directory/PublicProgrammeOfferFactsQueryService.php` (retain delivery-location label and fact effective dates)
- `tests/Feature/ProgrammeOfferFactWorkflowTest.php` (offer location, cycle and effective-date assertions)
- `routes/web.php`
- `config/directory.php`
- `config/session.php`
- `resources/views/directory/index.blade.php`
- `resources/views/directory/show.blade.php`
- `resources/views/directory/compare.blade.php`
- `tests/Feature/PublicDirectoryTest.php`
- RCV-B03 scope/design and project traceability documentation.

## 4. Synthetic test coverage

- Add, remove and compare approved same-type options.
- Mixed category rejection.
- Configurable shortlist cap.
- Missing value remains “not stated”.
- Numeric zero remains zero.
- Session flush removes the shortlist and no saved-list table exists.
- Deeni Madaris cannot be selected.
- Existing RCV-B02 tests preserve offer isolation, admission-cycle identity, stale/unknown/conflicting states and zero-fee semantics.

## 5. Exclusions

No schema/migration, persistent storage, public sharing, account registration, personal/student information, real/source data, scraping, external API, AI, maps/geocoding, notification, UGC, ranking/scoring, paid placement influence, Hostinger/V1/production access, deployment, public activation or spend.

## 6. Validation

The final PR head must pass the PHP 8.5 FND-01 foundation CI and Project documentation validation. No previous or superseded branch result substitutes for exact-head checks. A green CI run is automated synthetic validation, not browser acceptance or production readiness.
