# M3-11-03 — Directory Accessibility Contrast Evidence

**Date:** 2026-11-19  
**Status:** SOURCE-PALETTE CONTRAST CHECK RECORDED; AUTOMATED REGRESSION TEST ADDED; MANUAL ACCESSIBILITY REVIEW PENDING  
**Repository:** `mattari20/listing-v2`  
**Scope:** Existing anonymous directory search and profile templates only

## 1. Evidence inspected

- `resources/views/directory/index.blade.php`
- `resources/views/directory/show.blade.php`
- Existing skip navigation and `:focus-visible` declarations in both templates.
- Existing `tests/Feature/SecurityHeadersTest.php` (global four-header regression test already exists).

The two templates already contain a skip-to-main-content link, a focusable main target, explicit visible focus styling, English document language and responsive layout rules. This work does not duplicate or rewrite those controls.

## 2. Contrast calculation method

Contrast ratios were calculated from the actual hexadecimal CSS colors in the templates using the WCAG relative-luminance formula:

1. Convert each sRGB channel to the linear channel using the WCAG 0.04045 breakpoint.
2. Calculate relative luminance using 0.2126 R + 0.7152 G + 0.0722 B.
3. Divide the lighter luminance plus 0.05 by the darker luminance plus 0.05.

Thresholds used for this source-level check:
- Normal text: at least 4.5:1.
- Non-text UI component boundary: at least 3:1.

## 3. Measured palette

| Use | Foreground | Background | Ratio | Threshold | Result |
|---|---|---|---:|---:|---|
| Body text | `#172033` | `#f7f8fa` | 15.31:1 | 4.5:1 | PASS |
| Muted metadata | `#4b5563` | `#ffffff` | 7.56:1 | 4.5:1 | PASS |
| Links | `#174ea6` | `#ffffff` | 7.85:1 | 4.5:1 | PASS |
| Button text | `#ffffff` | `#172033` | 16.27:1 | 4.5:1 | PASS |
| Focus outline | `#005fcc` | `#ffffff` | 5.98:1 | 3:1 non-text / 4.5:1 where text | PASS |
| Focus outline on page background | `#005fcc` | `#f7f8fa` | 5.63:1 | 3:1 non-text / 4.5:1 where text | PASS |
| Form control border | `#8b95a5` | `#ffffff` | 3.03:1 | 3:1 | PASS, narrow margin |

The form-control border has a narrow margin above 3:1; avoid lightening it without recalculating. The card/container border `#d9dee7` is 1.35:1 against white and is not counted as an essential control boundary in this check. If the design relies on that border alone to identify an interactive component or meaningful region, a separate design review is required.

## 4. Automated regression

Added `tests/Feature/DirectoryAccessibilityTest.php` to:
- Assert both templates retain language declaration, skip link, main target and visible focus outline.
- Assert the tested palette declarations remain present.
- Recalculate and assert the above text/focus/control contrast thresholds.

The test is a regression guard for the listed source colors and markup. It is not a browser rendering test and does not prove every rendered state or user-agent behavior.

## 5. Limitations and remaining checks

Not assessed by this source-level check:
- Hover, active, disabled, validation-error and other dynamic states.
- Browser zoom/reflow at 200% and 400%, text spacing overrides or forced-colors/high-contrast modes.
- Keyboard-only operation in an actual browser, screen-reader announcements, touch target sizing or assistive-technology combinations.
- Contrast of generated Laravel pagination markup in every state.
- Manual visual inspection on desktop and mobile.

No WCAG 2.2 AA conformance claim is made. A browser-based accessibility review remains required after the GitHub–Hostinger deployment connection and private V2 deployment are established.

## 6. Security and scope boundary

The existing four global security response headers already have a dedicated synthetic feature regression in `tests/Feature/SecurityHeadersTest.php`; this work does not duplicate it. CSP/HSTS remain deferred to an HTTPS target-specific policy decision. SEC-06 logging policy is documented in PR #308; its separately authorized local/CI implementation is tracked in PR #312. Hosted logging configuration and runtime verification remain pending.

No dependency, application route, database/schema, logging configuration, external service or hosted setting was changed. No Hostinger/hPanel, V1/production, live database, real data, backup, migration, deployment, public activation, pilot, release candidate or spend occurred.

**Disposition:** Source-palette contrast evidence and automated regression added. Manual accessibility testing and hosted security/runtime verification remain pending.
