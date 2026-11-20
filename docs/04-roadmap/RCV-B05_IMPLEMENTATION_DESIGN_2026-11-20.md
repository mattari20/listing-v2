# RCV-B05 — Language and Accessibility: Implementation Design

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `6ba18b907c51ac4c24af571cfb1b07899d0ada74`  
**Implementation branch:** `feat/rcv-b05-urdu-localization-accessibility`  
**Scope:** Product Owner-approved English/Urdu interface; preserve approved facts in their approved/original language; no automatic translation.

## 1. Language behavior

- First-party translation catalogues are stored in `lang/en/directory.php` and `lang/ur/directory.php`.
- The public directory supports English (`en`, LTR) and Urdu (`ur`, RTL).
- A language link updates the `lang` query parameter while preserving the current page's query state. The selected locale is stored in the current Laravel browsing session under `directory_locale`; no user profile or persistent preference is created.
- Search forms, category links, profile links, shortlist actions, comparison navigation and pagination preserve the selected language.
- An explicit unsupported language value (including an empty or non-string value) falls back to English and updates the session.
- The controller applies the locale to the current request before rendering or generating shortlist status/error messages.
- Document `lang` and `dir` attributes are emitted as `en/ltr` or `ur/rtl`.

## 2. Translation boundary

- First-party navigation, labels, helper text, empty states, comparison states, validation feedback, status messages, metadata and common category/filter labels are translated.
- Known registry filter field labels are translated only where a first-party translation entry exists; otherwise the approved registry label is shown unchanged.
- Institute/provider/campus/programme/qualification names, addresses, admission-cycle labels, approved fact labels without a translation entry, and all approved public fact values remain unchanged.
- Individual public values and source-backed labels use `dir=auto` where appropriate so mixed Urdu, English, numerals, URLs and official names retain their natural direction.
- No automatic translation, transliteration, machine translation, AI or external translation service is used.

## 3. Accessibility implementation

- All three public directory views have a visible-on-focus skip link targeting a single main landmark with a programmatically focusable target.
- Heading hierarchy remains page-level `h1`, section `h2`, and result/offer `h3` where applicable.
- Existing explicit form labels and fieldset/legend groupings are retained; search validation errors are exposed in a labelled alert summary and status messages keep their live status roles.
- Keyboard focus has a high-contrast visible outline and focus targets receive scroll margin. Disabled controls use explicit readable colors rather than opacity reduction.
- Comparison table headers use proper row/column scopes; the horizontal comparison region remains labelled and keyboard focusable for two-dimensional content.
- Logical CSS positioning and start alignment support RTL without duplicating the layout.
- Mixed-language source values use direction auto-detection.
- This implementation is a code-level accessibility improvement, not a WCAG conformance finding or certification.

## 4. Test coverage

New synthetic feature tests verify:
1. Urdu selection emits `lang="ur"` and `dir="rtl"`.
2. Session locale carries from directory results to profile and comparison pages.
3. Search form includes the selected language and the comparison page keeps Urdu after shortlist POST actions.
4. Common UI/filter labels translate while the approved synthetic source fact/value remains unchanged.
5. Unsupported language input resets the session and document to English/LTR.
6. Skip links, main landmarks and labelled comparison region exist on the relevant pages.

Existing directory, admissions, shortlist/comparison, search/filter, Deeni Madaris suppression and pagination regression tests remain in the suite.

## 5. Manual accessibility review still required

Automated tests cannot assess screen-reader usability, actual keyboard interaction, contrast in rendered browsers, zoom/reflow behavior or assistive-technology compatibility. The separate manual checklist records these as **NOT PERFORMED** until a human review is actually completed. Do not claim WCAG conformance or certification from CI.

## 6. Boundaries

- No source acquisition, scraping, real institution/student/guardian/staff data or public activation.
- No external API, AI, machine translation, analytics or translation provider.
- No new dependency, migration, database schema change, paid service or spend.
- No V1, Hostinger, production DB, deployment or URL cutover.
- Deeni Madaris remains suppressed/default-OFF.
- RCV-B03 remains temporary session-only; no saved accounts or share links.
