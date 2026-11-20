# RCV-B08 — Private Account-Owned Saved Items: Implementation Record

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Branch:** feat/rcv-b08-private-saved-items  
**Status:** IMPLEMENTED AND MERGED in PR #340 as `d9d97ca15f31e6d0406090532b6fd63de9db42e7`; no production activation.

## 1. Product Owner decision and scope

The Product Owner instructed the project to move forward after the recommended RCV-B08 staged policy was presented. This is recorded as approval of the first bounded slice: private saved items for existing pre-provisioned active/verified accounts only. Anonymous session shortlist/comparison remains unchanged. Public registration, account recovery/closure UI, share links, alerts, external messaging, automatic retention expiry, production access, deployment, real account data and spend remain excluded.

## 2. Implementation

- Added `saved_directory_items` with a cascading account foreign key, cascading directory-entity foreign key, unique `(user_id, entity_id)` constraint and owner/created lookup index.
- Added the Eloquent `User::savedDirectoryItems()` relation and `SavedDirectoryItem` model.
- Added authenticated and throttled account routes for list, save and remove.
- Added owner-scoped controller operations; ownership always comes from the authenticated principal, never request input.
- Saving requires a current `PublicDirectoryQueryService::find()` result; a stale/unpublished/suppressed/Deeni Madaris entity cannot be newly saved.
- Saved-list reads re-resolve each entity through the current approved anonymous public projection. Stale references display only a generic unavailable notice and can still be removed.
- Save operations are idempotent and transactionally enforce a configurable maximum clamped to 1..100 (default 50).
- Added a private no-store/noindex saved-items page and save controls to authenticated directory/profile views.
- Added English and Urdu copy.
- Account deletion at database level cascades saved-item rows; no account-closure endpoint or workflow is introduced.

## 3. Privacy/security behavior

- No names, addresses, source facts, evidence, notes, preferences, student/guardian data or other profile fields are stored in the saved-item table.
- Cross-account reads/deletes are scoped to the authenticated account ID.
- Guest requests are denied by authentication middleware.
- The saved-items page emits `Cache-Control: private, no-store, max-age=0`, `Pragma: no-cache`, `X-Robots-Tag: noindex, nofollow` and a page robots noindex directive.
- The maximum is enforced server-side; the database unique constraint is the final duplicate guard.
- No new logs, analytics, notification subscriptions or delivery payloads are added.

## 4. Synthetic tests

Tests cover guest denial, owner save/list/remove, idempotent save, cross-account isolation, unpublished entity rejection, stale reference non-disclosure, saved-item maximum and account-row cascade deletion. Existing public directory and session-shortlist tests remain part of the full suite.

## 5. Validation and merge evidence

Exact-head FND-01 PHP 8.5 CI #44656958419 (run #676) and Project documentation validation #44656958556 (run #1145) passed on PR head `c11a439bfa6213801f0755a3b250e02036df3266`. Full synthetic suite: 15 passed, 1,462 assertions, 281 non-fatal warnings. Formatting, Composer validation, dependency advisories, Laravel bootstrap/routes, migration rollback/reinstall, and repository artifact hygiene passed. PR #340 merged as `d9d97ca15f31e6d0406090532b6fd63de9db42e7`.

The migration-sequence test now verifies 15 migrations and includes `saved_directory_items`; the existing anonymous shortlist and governance contracts remain green.

## 6. Remaining RCV-B08 stages

- B08-B private saved items: implemented in this PR.
- B08-C sharing: deferred; no token or public route.
- B08-D notification preferences and event semantics: deferred; no subscription or inbox.
- B08-E external delivery/provider: not authorized; no vendor or spend.
- Public registration/recovery/closure: separate lifecycle decision.
- DP-02 target session configuration and DP-03 log policy: remain gates before target provisioning or real-user use.
- No automatic retention expiry is set. User deletion is immediate; database foreign-key cascade handles future account-row deletion.

## 7. Current disposition

Only the private saved-items slice is implemented. No public account lifecycle, sharing, alerts, external messaging, production activation or deployment is included.