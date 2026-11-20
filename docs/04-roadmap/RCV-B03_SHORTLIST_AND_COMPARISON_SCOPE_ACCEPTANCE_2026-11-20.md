# RCV-B03 — Shortlist and Comparison: Scope and Acceptance Decision Pack

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `main` at `19b4fd80c645b99085d7c4cd5329a043aaadd0e6`  
**Agenda:** RCV-B03 — Shortlist and Comparison  
**Status:** Scope/preflight only; implementation authorization has not yet been granted.

## 1. Why this is next

RCV-01 identifies RCV-B03 as the next residual product capability after RCV-B02. The Product Owner selected the sequence RCV-B02 first, then RCV-B03. RCV-B02 is now implemented and merged for its authorized synthetic V2 scope.

The inspected V2 repository has public directory search and profiles, offer-scoped admissions facts, and first-party session authentication foundations. It does not yet demonstrate a shortlist/comparison route, comparison service, saved-item model, share-token model or comparison feature tests.

This pack is limited to a focused product/privacy decision and acceptance boundary. It does not authorize application code, schema changes, migrations, routes, external services or production activity.

## 2. Product requirements carried forward

The existing V2 product requirements call for:
- A small, usable shortlist, with 3–5 options as a provisional target rather than a validated hard limit.
- Like-for-like comparison: institution with institution, campus with campus, programme with programme, and intake/offer with the same comparison unit.
- Clear display of missing, stale, disputed, conflicting and non-comparable values; missing must never be treated as zero.
- Comparison of published facts such as location, institution type/sector, education level, campus/programme availability, eligibility, duration, admission status, fees with period/effective date, recognition/affiliation, facilities, transport, hostel and scholarships where supported.
- Explainable treatment of any future ranking or scoring; no universal “best institution” score by default.
- Clear separation of paid placement from organic results and objective comparison facts.
- Shortlist saving and sharing as product goals, subject to privacy, retention and access-control decisions.

Ratings/reviews are not included in this agenda's first slice. They remain post-launch features and public UGC remains disabled.

## 3. Recommended first implementation slice

### 3.1 Comparison behaviour

- Let a visitor select a small number of public directory entities for side-by-side comparison.
- Require the selected entities to share the same comparison type. Do not compare an institution directly with a programme or campus.
- Use only the existing approved anonymous public projection and governed offer-fact read models.
- Display only fields that are relevant and supported for that comparison type.
- Show a consistent row for each comparison dimension, even when a selected entity has no value.
- Label values as current/observed, stale, unknown/not verified, not stated, not applicable, conflicting or not comparable where the underlying published data supports that distinction.
- Preserve currency, fee period, admission cycle and effective/observation dates. Do not calculate totals, infer deadlines or normalize unlike values without a separately approved deterministic rule.
- Do not introduce composite ranking, recommendation scores, AI suggestions, paid-result boosting or “best” labels.

### 3.2 Shortlist persistence and sharing — owner decision required

**Recommended low-risk first slice:** keep the shortlist temporary to the visitor's active session. Do not create persistent saved lists, shareable public URLs, reminder subscriptions or notifications in the first implementation.

Reasons:
- Public directory browsing is anonymous.
- Existing account/session work is a pre-provisioned identity foundation; public self-registration, verification and recovery are not demonstrated.
- Persistent saved items create retention, deletion, account lifecycle and access-control requirements.
- Share links create a separate public-disclosure surface requiring token entropy, expiry, revocation, access logging and clear user controls.

If persistent account-based saving or sharing is required from the start, those capabilities need a separately specified privacy/retention and security contract before implementation.

### 3.3 Privacy and safety boundary

- No CNIC/B-Form, roll number, marksheet, exact home address, child profile or sensitive personal information.
- Do not infer or store a student's education status from comparison selections.
- Do not expose a visitor's shortlist to institutions or other users.
- No account creation or registration flow is introduced by this agenda.
- No location permission is required; manual locality facts remain available.
- No public review/rating data is included.
- No real/source/student data, scraping, external APIs, AI, maps/geocoders, notification services or paid vendors.

## 4. Acceptance criteria for the first slice

1. A visitor can select and remove comparison candidates from the existing public directory/profile experience.
2. Comparison refuses mixed entity types and unsupported comparison units.
3. A maximum shortlist size is enforced by an owner-approved setting; the provisional 3–5 target is not hard-coded as final until accepted.
4. All displayed facts originate from approved anonymous public projections.
5. Missing, unknown, stale, conflicting and non-comparable values remain visibly distinct; none are silently converted to zero or a negative match.
6. Fees retain currency, amount, period and applicable effective/observation date.
7. Programme/admission comparisons preserve offer and admission-cycle identity.
8. No composite score, default “best” ranking or undisclosed sponsorship influence is introduced.
9. Temporary shortlist state expires with the visitor session if the recommended first slice is accepted.
10. Automated synthetic tests cover selection limits, mixed-type rejection, missing/stale values, like-for-like rows, fee semantics, Deeni Madaris exclusion and zero persistence after session expiry.
11. No new schema is added unless the selected persistence option demonstrably requires it and receives explicit authorization.
12. No production, Hostinger, V1, real data, external service or spend activity occurs.

## 5. Work explicitly not included

- Persistent account-based saved lists.
- Shareable links or public shortlist pages.
- Alerts, reminders, email/SMS or push notifications.
- AI ranking, recommendations or automated matching.
- Distance/geospatial calculations, maps or geocoding.
- Reviews, ratings, moderation, reporting or public UGC.
- Admissions application submission or applicant accounts.
- Live source ingestion or real institution data.

These remain separate product or release decisions.

## 6. Authorization and next gate

RCV-B03 is selected as the next agenda, but this document is not implementation authorization. Before code begins, the Product Owner must decide whether to accept the recommended temporary session-only shortlist with no persistent save/share in the first slice, or require persistent account-based saving/sharing from the beginning.

After that decision, a narrow implementation authorization can specify the exact files, data handling, tests and any schema implications. Existing no-V1, no-production, synthetic-only, no-external-service, no-spend and Deeni Madaris default-OFF restrictions remain binding.

## 7. Current agenda disposition

| Work item | Status |
|---|---|
| RCV-01 capability gap identified | COMPLETE |
| RCV-B02 prerequisite | COMPLETE for authorized synthetic V2 scope |
| Existing comparison implementation inventory | COMPLETE — no shortlist/comparison workflow found |
| RCV-B03 product/privacy scope | PREPARED |
| Persistence/share decision | AWAITING PRODUCT OWNER DECISION |
| Application implementation | NOT AUTHORIZED / NOT STARTED |
| Production, real data, external services or spend | NOT AUTHORIZED |
