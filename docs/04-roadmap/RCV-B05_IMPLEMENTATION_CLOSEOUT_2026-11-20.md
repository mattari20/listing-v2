# RCV-B05 — Language and Accessibility: Implementation Closeout

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Implementation PR:** #327  
**Merge commit:** `74e355ef1e3d04b32c35391a37bc73badd56d898`  
**Validated implementation head:** `a9a8b746c5c2195e51487e09360ef86d50378f38`

## 1. Delivered

- First-party English and Urdu translation catalogues in `lang/en/directory.php` and `lang/ur/directory.php`.
- Session-scoped language selection using `directory_locale`; English is LTR and Urdu is RTL.
- Language selection is preserved across directory search, filters, pagination, profiles, temporary shortlist actions and comparison.
- Unsupported explicit language values fall back to English.
- First-party UI, common type/filter labels, shortlist messages and validation feedback are translated. Registry field labels are translated only when an explicit first-party mapping exists; otherwise the existing label is retained.
- Approved institution/provider/campus/programme names, addresses, admission-cycle labels, source-backed facts and values are not machine-translated. Mixed-language content uses direction auto-detection where appropriate.
- All three directory pages now have skip links and a main landmark; comparison page skip navigation was added.
- Existing labels and fieldset/legend controls remain; error summaries and status messages use accessible announcement roles.
- Visible keyboard focus, readable disabled controls, logical RTL positioning and direction-aware comparison table alignment were improved.

## 2. Exact-head validation

Validated implementation head: `a9a8b746c5c2195e51487e09360ef86d50378f38`.

- FND-01 PHP 8.5 foundation CI run #44649774054 — **SUCCESS**.
- Project documentation validation run #44649774060 — **SUCCESS**.
- Synthetic suite: **15 passed, 1,318 assertions**; **254 non-fatal warnings** from existing checks that attempt to read the intentionally absent local `.env`.
- Composer validation and locked dependency install, dependency advisory checks, PHP formatting, Laravel bootstrap/routes, synthetic suite and repository artifact hygiene passed.
- PR #327 was squash-merged with expected-head guard as `74e355ef1e3d04b32c35391a37bc73badd56d898`; `main` was verified at this commit.

## 3. Manual accessibility review remains open

The repository checklist `RCV-B05_MANUAL_ACCESSIBILITY_REVIEW_CHECKLIST_2026-11-20.md` records keyboard-only operation, focus visibility, screen-reader semantics, 200% zoom, reflow, contrast, RTL/mixed-direction behavior and browser/device checks. All manual checks remain **NOT PERFORMED**.

This PR's automated tests and code-level changes do not establish WCAG conformance. A qualified human accessibility review and remediation evidence remain separate. No WCAG conformance or certification claim is made.

## 4. Boundaries preserved

No automatic/machine/AI translation, external service, real/source/student/guardian/staff data, new dependency, migration, paid service or spend. No Hostinger, V1, production, deployment, public activation or URL cutover. Deeni Madaris remains suppressed/default-OFF. RCV-B03 remains temporary session-only; no persistent saved lists or share links.
