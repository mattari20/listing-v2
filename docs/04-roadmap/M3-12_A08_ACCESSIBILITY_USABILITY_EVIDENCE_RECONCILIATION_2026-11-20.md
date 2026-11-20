# M3-12 Agenda 08 — Accessibility and Usability Evidence Reconciliation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline main:** `106ee260f32b621d8688fd6b7446cc4dd0ea1ca3`  
**Work type:** Static source palette calculation and accessibility evidence/status reconciliation  
**Status:** COMPLETE for repository evidence reconciliation; manual, browser and qualified accessibility review remain NOT PERFORMED.

## 1. Purpose and boundary

Reconcile the accessibility and usability evidence available on current `main`, distinguish static source checks from actual rendered/browser and human assessment, and carry every outstanding item into the final M3-12 readiness disposition.

This agenda did not use a browser or assistive technology, did not recruit or contact participants, and did not perform a qualified independent audit. The source palette ratios below were independently calculated from the current-main CSS values using the WCAG relative-luminance formula. They are source-level calculations only, not a WCAG conformance assessment.

## 2. Current-main evidence

- Directory search: `resources/views/directory/index.blade.php`.
- Directory profile: `resources/views/directory/show.blade.php`.
- Comparison: `resources/views/directory/compare.blade.php`.
- Account saved items: `resources/views/account/saved-items.blade.php`.
- English and Urdu catalogues: `lang/en/directory.php`, `lang/ur/directory.php`.
- Existing manual checklist: `RCV-B05_MANUAL_ACCESSIBILITY_REVIEW_CHECKLIST_2026-11-20.md`.
- RCV-B05 implementation closeout and M3-11-03 independent security/accessibility review pack.

Static source evidence includes semantic page structure, skip links, main landmarks, form labels and field groups, status/error roles, focus-visible rules, responsive media queries, language/direction attributes and direction-aware fact values. These observations do not prove rendered behavior or assistive-technology compatibility.

## 3. Source palette contrast calculations

Ratios were calculated from the current-main hexadecimal values using the WCAG sRGB linearization and relative-luminance formula.

| Use and current-main source | Foreground | Background | Calculated ratio | Source-level result |
|---|---|---|---:|---|
| Body text — directory/profile/compare/saved-items | `#172033` | `#f7f8fa` | 15.31:1 | Above 4.5:1 |
| Muted metadata — directory/profile/compare/saved-items | `#4b5563` | `#ffffff` | 7.56:1 | Above 4.5:1 |
| Links — directory/profile/compare/saved-items | `#174ea6` | `#ffffff` | 7.85:1 | Above 4.5:1 |
| Primary button text — directory | `#ffffff` | `#172033` | 16.27:1 | Above 4.5:1 |
| Focus outline — white surface | `#005fcc` | `#ffffff` | 5.98:1 | Above 3:1 |
| Focus outline — page surface | `#005fcc` | `#f7f8fa` | 5.63:1 | Above 3:1 |
| Directory form control border | `#8b95a5` | `#ffffff` | 3.03:1 | Above 3:1, narrow margin |
| Compare/saved-item button border | `#667085` | `#ffffff` | 4.97:1 | Above 3:1 |
| Disabled button text | `#374151` | `#e5e7eb` | 8.33:1 | Above 4.5:1 |
| Comparison table header text | `#172033` | `#f1f4f8` | 14.75:1 | Above 4.5:1 |
| Active-filter text | `#172033` | `#eef3fa` | 14.59:1 | Above 4.5:1 |

The pale card/table separator `#d9dee7` against white is approximately 1.35:1. It appears as a visual separator in the inspected templates and is not treated here as an essential control boundary. If a user must rely on that separator alone to identify a control, state or meaningful region, it requires a design decision and separate review. The directory form border's 3.03:1 margin is narrow; do not lighten it without recalculation.

These measurements cover selected static color pairs only. They do not cover every text/background combination, opacity, overlays, browser anti-aliasing, images, dynamic states, generated pagination, forced-colors modes or user overrides.

## 4. Unmerged contrast regression work

Open draft PR [#309](https://github.com/mattari20/listing-v2/pull/309) contains a proposed `DirectoryAccessibilityTest` and a source-palette contrast evidence record for the directory search/profile templates. At this reconciliation:

- PR #309 is still open and marked draft.
- It is based on an older main SHA (`0dfca8d998550c2aa52325c3b5bd90088fd77b44`), not the current baseline.
- Its test and evidence are not present on current `main`.
- Its historical CI results do not validate the current-main head.

Accordingly, PR #309 is recorded as an unmerged work item and is not counted as current-main acceptance evidence. No change to that PR or its branch was made by this agenda.

## 5. Manual accessibility and usability status

The existing RCV-B05 manual checklist contains nine review areas. All remain **NOT PERFORMED**:

1. Keyboard-only operation and focus visibility.
2. Screen-reader landmarks, labels, announcements and comparison-table navigation.
3. 200% zoom.
4. Narrow viewport reflow and usable two-dimensional comparison scrolling.
5. Measured contrast across dynamic states, controls, notices and disabled states.
6. Urdu RTL layout and focus order.
7. Mixed-direction Urdu UI with English names, URLs, numerals and source-language facts.
8. Representative desktop/mobile browser and device combinations.
9. Human visual/usability inspection and qualified accessibility assessment.

No qualified independent accessibility reviewer is appointed. No participant usability test or WCAG 2.2 AA conformance assessment is evidenced.

## 6. M3-11-03 gate relationship

M3-11-03 remains closed only for the current repository-only internal review boundary. Independent security and accessibility assessment for any future hosted/release scope remains BLOCKED. The static source calculations in this agenda do not satisfy that gate, do not replace manual assistive-technology review and do not authorize a hosted target or deployment.

## 7. Acceptance criteria and result

| Criterion | Result |
|---|---|
| Reconcile current-main static accessibility/localization evidence | MET |
| Calculate selected current-main palette contrast ratios | MET — source-level only |
| Identify unmerged draft PR #309 and prevent it being counted as main evidence | MET |
| Reconcile all manual checklist items and qualified review status | MET — all retained as NOT PERFORMED |
| Establish browser, assistive-technology, participant or WCAG acceptance | NOT ESTABLISHED |

**Agenda disposition:** COMPLETE for accessibility/usability evidence reconciliation. Manual accessibility, browser/device and qualified independent review remain NOT PERFORMED and BLOCKED where required by M3-11.

## 8. Explicit exclusions

No browser/device/assistive-technology session, participant contact, qualified reviewer appointment, live or real data, Hostinger/hPanel/V1/production access, deployment, public activation, new dependency, external service or spend.

**Final result:** STATIC SOURCE EVIDENCE RECONCILED; MANUAL AND INDEPENDENT ACCESSIBILITY ACCEPTANCE REMAINS OPEN.
