# M3-11-05A-06 — Five-city synthetic preview visual owner review

**Status:** Prepared; local owner visual review pending.  
**Implementation branch:** `feature/m3-11-public-governed-catalogue-display`  
**Related draft:** PR #306  
**Scope:** Manual review of a disposable local SQLite preview only. No hosted access, public activation, pilot, release or production activity.

## Why this review is required

Automated HTTP tests and PHP 8.5 CI passed for the implementation, but they do not establish how the pages render in a real browser. The original five-city seeder contained institutions only. The preview fixture has now been extended to include, for each city, one fictional campus, one fictional programme and one fictional admission offer, all created through the existing synthetic evidence, human-adjudication, publication and catalogue-materialization workflows.

## Synthetic preview matrix

| City | Institution | Campus | Programme | Offer |
|---|---|---|---|---|
| Lahore | Synthetic Crescent Learning Institute | Synthetic Lahore Campus | Synthetic Lahore Computing Programme | Synthetic 2027 Intake |
| Karachi | Synthetic Riverbend College | Synthetic Karachi Campus | Synthetic Karachi Computing Programme | Synthetic 2027 Intake |
| Peshawar | Synthetic Frontier Skills Academy | Synthetic Peshawar Campus | Synthetic Peshawar Computing Programme | Synthetic 2027 Intake |
| Quetta | Synthetic Makran Science College | Synthetic Quetta Campus | Synthetic Quetta Computing Programme | Synthetic 2027 Intake |
| Islamabad | Synthetic Capital Research Institute | Synthetic Islamabad Campus | Synthetic Islamabad Computing Programme | Synthetic 2027 Intake |

Every name and description is fictional. City and locality labels are used only as test geography. No real institution, student, child, guardian or staff data is included. No Deeni Madaris record is created.

## Safe local execution

Run only from a local V2 checkout of the implementation branch. Do not use Hostinger, V1, production, a shared database, or any remote database.

1. Fetch and switch to the implementation branch:
   ```bash
   git fetch origin feature/m3-11-public-governed-catalogue-display
   git switch feature/m3-11-public-governed-catalogue-display
   git pull --ff-only
   ```

2. Follow the exact isolated SQLite setup in [M3-11-05A local preview and test dataset](M3-11-05A_LOCAL_SYNTHETIC_PREVIEW_AND_TEST_DATASET.md). The configured database filename must be exactly `.local-preview.sqlite`, with `APP_ENV=local`, `DB_CONNECTION=sqlite`, and `LOCAL_PREVIEW_SEED=allow`.

3. Run the migrations and explicit local preview seeder exactly as documented there. Do not use `migrate:fresh`. The seeder refuses non-local environments, non-SQLite drivers, any other SQLite filename, and an absent explicit seed flag. It never deletes or overwrites an existing preview dataset.

4. Start the local Laravel server and inspect `http://127.0.0.1:8000/directory`.

## Visual review checklist

- [ ] Directory index loads without errors and presents the five fictional institutions.
- [ ] Search by each institution's distinctive name token returns the expected result.
- [ ] Locality filtering works for Gulberg, Gulshan, University Road, Jinnah Town and G-10.
- [ ] Each institution profile displays its correct fictional name, city and locality.
- [ ] Each institution profile displays its campus section and expected campus name.
- [ ] Each institution profile displays its programme section and expected programme name.
- [ ] Each institution profile displays the synthetic admission cycle and matching campus location.
- [ ] Campus and programme names do not appear as raw UUIDs or internal identifiers.
- [ ] No source evidence, internal notes, audit metadata, child/student/guardian/staff information or Deeni Madaris content is visible.
- [ ] Layout remains readable at desktop and narrow/mobile viewport widths; headings, lists and long text do not overlap or clip.
- [ ] Keyboard navigation reaches the skip link, main content, search/filter controls and profile content in a sensible order; focus is visible.
- [ ] No unexpected external requests or remote assets are required for the preview.

## Owner review record

| Review item | Result |
|---|---|
| Browser and OS | Pending owner entry |
| Date reviewed | Pending owner entry |
| Five-city index/search/filter | Pending |
| Five institution profiles | Pending |
| Campus/programme/offer rendering | Pending |
| Keyboard/focus and narrow viewport | Pending |
| Defects/screenshots | Pending owner evidence |
| Owner disposition | Pending — accept / return for correction |

Record only synthetic preview evidence. If any page is incorrect, capture the failing city/profile and the visible issue; do not edit data manually to make the screen pass.

## Limits and stop conditions

- This is owner-led visual inspection, not independent accessibility certification, formal WCAG conformance, privacy/legal approval, hosted isolation acceptance or release acceptance.
- No real/source data, live integrations, external APIs/AI, extra dependencies, paid services or spend.
- No Hostinger/hPanel, V1, production, hosted database, DNS, deployment, public activation, pilot, release candidate or merge.
- M3-11-05 hosted isolation and M3-11-06 recovery rehearsal remain separate blocked gates. M3-11-07 release-candidate readiness remains blocked.
