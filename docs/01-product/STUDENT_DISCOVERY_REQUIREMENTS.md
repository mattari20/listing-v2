# Student Discovery Requirements

**Status:** M1-S01 desk-research requirements baseline; prepared for owner acceptance. Requirements are provisional product requirements derived from independent desk research and explicit V2 owner decisions. No participant validation is claimed.

## 1. Purpose and boundaries

Define the student-facing discovery and decision-support needs that must inform later UX and architecture work. This document does not select a technology stack, define database schemas, authorize source ingestion or establish a complete institution taxonomy. Institution, campus, programme and regulator distinctions are further specified in the M1-S02/S03 research records.

## 2. Users and decision contexts

- Learners exploring a next education or training step.
- Students comparing schools, colleges, universities, programmes or vocational options.
- Parents/guardians supporting a learner's decision.
- Adult or returning learners considering continuation or a new pathway.

These are provisional segments, not validated personas. The platform must not assume that the parent/guardian is the account holder or final decision-maker.

## 3. Student discovery requirements

| ID | Requirement | Desk-research / owner basis | Acceptance criteria |
|---|---|---|---|
| SR-01 | Support pathway-led and direct discovery | PBS education levels; HEC qualification terminology; owner student-first vision | A user can start with current stage/qualification and intended next step, or search directly by institution, campus, programme, subject or locality. Pathway inputs are optional; skipping them does not block search. |
| SR-02 | Search across education entities and localities | Owner product vision; M1 institution taxonomy baseline | Search scope distinguishes institution, campus and programme where available. Exact matches are distinguishable from approximate/AI-suggested candidates. |
| SR-03 | Nearby discovery with location consent | Owner product direction; privacy-by-default principle | Manual city/area search works without location permission. Location is requested only after a user action that needs it; denial does not block directory use. |
| SR-04 | Apply evidence-backed filters | Student journey hypothesis; institution and programme evidence requirements | Filters are limited to supported fields (e.g. level, provider type, sector, programme, locality/distance and current admission status). Missing or unverified data is not silently treated as a negative match. |
| SR-05 | Compare shortlisted options | Pakistan-focused university-choice research; owner comparison vision | Users can select options and compare like-for-like fields. Missing, stale or non-comparable values are visibly identified; no unsupported composite ranking is implied. |
| SR-06 | Explain material programme/admission facts | Punjab HED Student Affairs; IBCC equivalence guidance; HEC pathway terminology | Where verified data exists, the page can show campus/programme-specific eligibility, duration, admission status, deadlines, fees/additional costs, scholarships and recognition/affiliation scope. Each material fact exposes source and as-of/last-checked context. |
| SR-07 | Distinguish evidence and trust states | Owner evidence-first product principles; M1-S02/S03 source research | Official-source facts, provider-submitted claims, AI-discovered candidates, estimates and student opinions are visibly distinct. Unverified, stale, disputed or missing facts are not presented as confirmed. |
| SR-08 | Provide a clear next action | Punjab HED process example; owner product vision | Users can follow a verified official contact/application link or contact route. V2 does not claim to submit an application on the student's behalf unless separately designed and authorized. |
| SR-09 | Support shortlist, sharing and optional updates | Owner product vision | Users can save/shortlist and share a result. Any admission/deadline reminder is opt-in, can be changed or stopped, and is not presented as guaranteed if source freshness is unknown. |
| SR-10 | Support corrections and post-launch feedback | Owner decision: authenticated ratings/reviews after launch | A correction/report route is available in the product requirements. Ratings/reviews are a post-launch feature requiring login; they are not a pre-launch survey or research substitute. Eligibility, moderation and safeguards remain for M1-S09/M2 design. |
| SR-11 | Work under constrained digital access | PBS HIES 2024–25; Pakistan Education Statistics 2023–24 | Core discovery information is text-first and usable without autoplay media or map-only interaction. Mobile and low-bandwidth behaviour is explicitly tested in later UX/engineering acceptance. Do not assume every learner has a personal device or reliable connectivity. |
| SR-12 | Evaluate language and accessibility needs | Owner inclusivity principle; no representative user evidence yet | English and Urdu support, readable layouts, keyboard/screen-reader accessibility and other accessibility needs are assessed in later design. No unvalidated claim is made about preferred language or final conformance target. |
| SR-13 | Minimize student personal data | Owner privacy direction and minor-safeguarding requirements | Browsing and comparison do not require CNIC/B-Form, roll number, marksheet, exact home address or other sensitive identifiers. Collect only data justified by an approved feature and retention policy. |
| SR-14 | Keep discovery available without precise location | Privacy-by-default and manual locality route | A user who declines browser/device location can still search by province, district, city, locality or institution name. No precise location is exposed publicly by default. |

## 4. Cross-step owner decisions and constraints

- **Location:** permission is optional; manual locality search remains available. Exact geospatial storage, distance calculation and route providers are M2 architecture decisions.
- **Research timing:** no student survey, interview, recruitment or outreach during platform construction. Archived instruments are not approved for distribution.
- **Ratings and reviews:** authenticated and post-launch; not a pre-launch research survey.
- **Deeni Madaris:** underlying provider scope is retained, but public listing visibility defaults OFF under V2-DEC-006. The setting and its downstream public-surface behaviour are governed by the decision and M2 design, not changed by S01.
- **Source rights:** a public page or discoverable record is not automatic permission to reuse, republish, scrape or ingest it. M1-S02/S03 rights decisions remain controlling.

## 5. Measurable acceptance scenarios for later UX/implementation

1. **Pathway and direct search:** complete a search both with pathway inputs and with all pathway inputs skipped.
2. **Location denial:** deny location permission and successfully find results using a manually selected locality.
3. **Search scope:** search by institution, campus, programme, subject and locality; confirm entity type and approximate matches are not confused with exact matches.
4. **Filter integrity:** apply a filter when data exists and inspect a record where the field is missing; missing data must not be silently treated as a confirmed mismatch.
5. **Comparison integrity:** compare at least two options with different completeness; missing and stale values remain visible and are not fabricated.
6. **Evidence transparency:** inspect official, provider-submitted, AI-discovered and student-opinion fields; each is clearly identified with its applicable source/verification state.
7. **Admission action:** open an official contact/application route and verify that the destination is the institution or competent authority, not an unverified intermediary.
8. **Low-bandwidth/mobile:** complete discovery on a small-screen device without autoplay media or mandatory map interaction; detailed performance thresholds are set in M2/M11.
9. **Privacy:** browse and compare without supplying government ID, roll number, marksheet or exact home address.
10. **Feedback boundary:** ensure review submission requires an authenticated account and is not surfaced as a research survey before launch.

## 6. Open questions carried forward

- Which student segments and decision factors should be prioritized for initial release?
- What are the actual student/parent language, device-sharing, accessibility and connectivity needs?
- Which programme/admission fields are consistently available and legally reusable across provider types?
- Which filters are sufficiently complete and fresh to be safe to expose?
- What are the appropriate accessibility and low-bandwidth performance targets?
- What review eligibility, moderation, privacy and age safeguards are required?
- Which reminders are genuinely useful and how should opt-in/opt-out work?

These questions are not blockers to accepting the desk-research baseline. They must be resolved through later independent research, M1 follow-on steps or M2 design before the affected feature is implemented.

## 7. Traceability

Detailed source evidence and limitations are in [M1 Student Journey Research](../03-research/M1_STUDENT_JOURNEY_RESEARCH.md). The current source register includes:
- PBS Social Statistics / PIE education estimates (2022–23);
- Punjab Higher Education Department Student Affairs;
- Pakistan-focused university-choice research (2021 and 2019);
- HEC Annual Report 2023–24;
- PBS HIES 2024–25;
- Pakistan Education Statistics 2023–24, Pakistan Institute of Education;
- IBCC equivalence FAQs.

No primary participant evidence has been collected. Requirements remain a desk-research baseline until a separately authorized validation phase is completed.
