# RCV-B05 — Language and Accessibility Completion: Scope and Acceptance Decision Pack

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `6ba18b907c51ac4c24af571cfb1b07899d0ada74`  
**Agenda:** RCV-B05 — Language and Accessibility Completion  
**Status:** Product Owner approved the recommended English/Urdu interface and original-approved-language fact policy on 2026-11-20. Bounded synthetic implementation merged in PR #327 as `74e355ef1e3d04b32c35391a37bc73badd56d898`; exact-head FND-01 #44649774054 and documentation validation #44649774060 passed on `a9a8b746c5c2195e51487e09360ef86d50378f38` (15 tests passed, 1,318 assertions).

## 1. Why this is next

RCV-01 identifies RCV-B05 as the next residual product package. It records SR-12 as partial: Unicode-aware search and semantic server-rendered pages exist, but Urdu localization/RTL content and qualified WCAG evaluation are not evidenced. AR-021–AR-022 likewise record text-first/Unicode foundations while full language and accessibility acceptance remains open.

## 2. Current V2 baseline inspected

The current public UI consists of:
- `resources/views/directory/index.blade.php`
- `resources/views/directory/show.blade.php`
- `resources/views/directory/compare.blade.php`

Observed existing accessibility foundations:
- Server-rendered pages with semantic headings, labels and form controls.
- Visible keyboard focus styles for links and controls.
- Skip links on directory results and profile pages.
- Status/error messages use `role=status` and `role=alert` in relevant workflows.
- Comparison table uses column/row headers and a keyboard-focusable labelled horizontal-scroll region.
- Responsive layout rules exist for the search/profile views.
- Public values use `dir=auto` in several locations to avoid forcing left-to-right rendering on mixed-language values.
- At the inspected baseline all three pages declared `lang="en"`; there was no language selector or translation catalogue.
- At the inspected baseline the comparison page lacked the skip link present on index/profile.
- Existing automated tests are not a screen-reader, keyboard-only, contrast, zoom/reflow or qualified WCAG audit.

These are repository observations, not a conformance finding.

## 3. Recommended bounded first slice

### 3.1 Language strategy

Recommended product default:
- Provide English and Urdu interface language choices.
- Keep institute names, official names, addresses, programme titles and other source-backed values in the language in which they were approved/published; do not machine-translate source facts.
- Translate first-party interface labels, navigation, help text, form labels, empty states, validation/status messages and comparison labels.
- Set the document `lang` and page direction from the selected interface language (`en`/LTR or `ur`/RTL).
- Keep individual public fact values direction-aware (`dir=auto`) because a page may contain mixed Urdu, English, numerals, URLs and official names.
- Persist the language choice only in the current browsing session or URL, not in a user profile; preserve it through search, facets, pagination, profiles and comparison.
- Unsupported language values fail back to English. No external translation service or AI is used.

### 3.2 Accessibility implementation

- Add a skip link to the comparison page and ensure each page has one clear main landmark and a logical heading structure.
- Verify every visible control has a programmatic label, grouped filters have legends, and validation/status messages are announced appropriately.
- Ensure focus remains visible and is not obscured; provide keyboard access to comparison scrolling and all actions.
- Check text/background contrast against the chosen design tokens, including focus, links, disabled controls, notices and active-filter state.
- Verify responsive reflow at narrow widths and at 200% zoom without loss of content or function; comparison tables may use a labelled horizontal scroll region where two-dimensional content genuinely requires it.
- Do not rely on color alone to communicate active, missing, stale or error states.
- Keep motion minimal; no animation is required for this first slice.

### 3.3 Qualified assessment boundary

Automated tests and code inspection can catch regressions but cannot establish WCAG conformance. A qualified human accessibility assessment and remediation review remain separate release evidence. Do not publish an accessibility certification or WCAG conformance claim based only on repository CI.

## 4. Acceptance criteria

1. Product Owner records the language strategy and content translation boundary.
2. English and Urdu interface strings are stored in first-party translation resources; no external translation API or AI is called.
3. Language selection updates document `lang` and page direction correctly.
4. Approved public facts remain in their approved/source language and render with direction isolation/auto-detection; they are not machine-translated.
5. Language selection survives search submission, category facets, locality/registry filters, pagination, profile navigation and comparison.
6. Invalid language input fails back to English.
7. All three directory views have skip links, main landmarks, logical headings and visible focus styles.
8. All form fields and filter groups have accessible labels; status/error announcements are preserved.
9. Keyboard-only operation covers search, filters, shortlist add/remove, comparison and pagination.
10. Synthetic feature tests cover language selection/fallback, URL/session persistence, page language/direction, mixed-direction public values, and accessible landmarks/skip links.
11. Manual checklist records keyboard, zoom/reflow, contrast and screen-reader review status without claiming formal conformance.
12. Deeni Madaris suppression, anonymous-only approved projections and RCV-B03 session-only shortlist remain unchanged.
13. No real data, source retrieval, external service, AI, new dependency, migration, production access, deployment or spend is introduced.

## 5. Explicit exclusions

- Automatic translation of institute facts or source content.
- Machine translation, AI translation, transliteration or language-model calls.
- New external accessibility, translation or analytics services.
- Formal WCAG certification/conformance claims without qualified assessment.
- Real institution/student/guardian/staff/source data.
- Hostinger, V1, production DB, deployment, public activation or new spend.
- Any change to Deeni Madaris default-OFF suppression.

## 6. Product Owner decision and authorization

**APPROVED 2026-11-20.** The Product Owner said: “ok approve as u stated above and move further to next agenda”. This approves the Section 3.1 strategy unchanged: **English and Urdu interface; preserve approved institute facts in their original approved language; no automatic translation; language choice remains session/URL scoped.**

Implementation is limited to the local workstation/GitHub CI and synthetic fixtures. The separate qualified accessibility assessment remains a later human review and is not included in the code implementation.

## 7. Current agenda disposition

| Work item | Status |
|---|---|
| RCV-01 identifies RCV-B05 | COMPLETE |
| Current public view baseline inspected | COMPLETE |
| Existing accessibility foundations and gaps recorded | COMPLETE |
| Bounded bilingual/RTL recommendation prepared | COMPLETE |
| Product Owner language/content decision | APPROVED 2026-11-20 |
| Application implementation | COMPLETE AND MERGED in PR #327 |
| Manual accessibility checklist | CREATED; all manual checks remain NOT PERFORMED |
| Qualified accessibility assessment | NOT PERFORMED; separate human review required |

Existing V2-only, synthetic-only, no-production, no-V1, no-Hostinger, no-real/source/personal-data, no-external-service/AI, no-spend and Deeni Madaris default-OFF restrictions remain binding.
