# RCV-B08-B — Private Account-Owned Saved Items: Bounded Implementation Authorization

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Base:** main at RCV-B08 preflight closeout  
**Branch:** feat/rcv-b08-private-saved-items  
**Status:** Product Owner approval inferred from explicit instruction to proceed and complete the next agenda after the recommended policy was presented. Exact bounded repository implementation is authorized.

## 1. Approved product policy

- First release supports only existing pre-provisioned active/verified accounts authenticated through the current web guard.
- Anonymous browsing and the existing session-only shortlist/comparison remain unchanged.
- Saved items are private to the authenticated account owner.
- Store only the user ID, directory entity ID and server-generated timestamps.
- Enforce uniqueness per user/entity and a bounded server-side maximum (default 50; configurable and capped at 100).
- Every save and every saved-list read resolves the entity through the current `PublicDirectoryQueryService::find` projection. Never copy names, claims, evidence, addresses, notes or restricted values into saved-item storage.
- Unavailable/withdrawn/suppressed/unpublished/Deeni Madaris entities are not displayed through saved items. A stale reference may be removed by its owner.
- Owner can remove an item at any time. Database foreign-key cascade removes saved items if the account row is deleted in a future approved lifecycle.
- No automatic inactivity expiry or retention duration is introduced.

## 2. Exact implementation files

- `database/migrations/2026_11_20_000001_create_saved_directory_items_table.php`
- `app/Http/Controllers/AccountSavedItemsController.php`
- `app/Models/User.php` (owner relation only)
- `config/directory.php` (bounded saved-item maximum)
- `routes/web.php` (authenticated, throttled saved-item routes)
- `resources/views/account/saved-items.blade.php`
- `resources/views/directory/index.blade.php` and `resources/views/directory/show.blade.php` (authenticated navigation/save control only)
- `lang/en/directory.php` and `lang/ur/directory.php` (UI strings)
- `tests/Feature/AccountSavedItemsTest.php`
- `docs/04-roadmap/RCV-B08_ACCOUNT_SAVED_ITEMS_AND_ALERTS_IMPLEMENTATION_RECORD_2026-11-20.md`
- `docs/README.md`, `docs/04-roadmap/DOCUMENTATION_CATALOG.md`, `docs/04-roadmap/IMPLEMENTATION_TRACEABILITY_MATRIX.md`, `docs/04-roadmap/PROJECT_PROGRESS_REPORT.md`

## 3. Security and acceptance requirements

1. All saved-item routes require the existing authenticated `web` session; guests cannot read, save or delete.
2. Ownership derives exclusively from the authenticated principal. No client-supplied user ID is accepted.
3. Every operation scopes by both authenticated user ID and entity ID; guessed IDs cannot cross account boundaries.
4. Save accepts only UUID entities that resolve in the current approved public anonymous directory projection.
5. Saved-list display re-resolves each entity through the public projection at request time. No stale or suppressed profile fields are returned.
6. Duplicate saves are idempotent; a database unique constraint protects `(user_id, entity_id)`.
7. The maximum is enforced server-side inside a transaction while locking the account row; the configured value is clamped to 1..100.
8. Owner deletion is available even when the referenced entity is no longer publicly available.
9. Saved-items page is private/no-store and explicitly noindex/nofollow.
10. English and Urdu controls are available; no personal details are included in logs or status messages.
11. Existing anonymous directory, shortlist, comparison, account sign-in/out, SEO policy and Deeni Madaris default-OFF behavior remain unchanged.

## 4. Explicit exclusions

- No public registration, email verification/recovery delivery, profile management, account closure UI or new account lifecycle.
- No share tokens, public share links, public saved lists or sitemap inclusion.
- No alert subscriptions, event watchers, notification inbox, email/SMS/WhatsApp/push delivery or messaging provider.
- No automatic retention expiry, data warehouse, tracking or inferred profile/preference.
- No production/Hostinger/V1 access, deployment, environment provisioning or real account data.
- No external API, AI, new dependency, vendor, paid service or spend.
- No modification to anonymous session shortlist behavior or Deeni Madaris suppression.

## 5. Validation and merge protocol

- Use synthetic-only tests and the existing disposable SQLite testing database.
- Exact-head FND-01 PHP 8.5 CI and Project documentation validation must pass.
- Verify migration, formatting, Composer, Laravel route/bootstrap, full suite and artifact hygiene.
- Automatically merge the PR after exact-head required checks pass; update all roadmap evidence and record final SHA/test evidence.

## 6. Deferred gates

- Public registration/account recovery/closure requires a separate lifecycle decision.
- Session cookie and log retention/configuration DP-02/DP-03 privacy gates remain required before target provisioning or real-user use.
- Share and alert stages require separate product/privacy/security decisions; external channels additionally require a separate vendor and spend approval.