# M1-S09 — Institution Comparison, Ratings, Reviews and Trust Research

**Status:** Research baseline delivered; owner acceptance pending  
**Prepared:** 2026-11-12  
**Repository:** `mattari20/listing-v2`  
**Scope:** Product research and policy requirements only. No review feature, account system, moderation console, scoring engine or public comparison UI was implemented.

## 1. Purpose and owner decisions retained

Help students and families make better-informed, comparable education choices while preventing misleading rankings, fake reviews, privacy harm, harassment and institutional manipulation.

Owner-approved constraints already established:
- Institution and programme comparison is a core product capability.
- The working shortlist target is 3–5 options; it remains provisional pending product validation.
- Ratings and written reviews are a post-launch product feature.
- Visitors may browse public information without an account, but must create an account or log in to submit a review.
- No pre-launch survey, interviews, recruitment or outreach.
- A login alone does not prove that someone attended or studied at an institution.
- No student documents or sensitive identity data should be collected without a necessary, proportionate and separately approved process.
- Deeni Madaris remain hidden from public discovery by default; no sect/maslak discovery filter or rating dimension.

## 2. Research basis and limitations

The research uses:
- **ISO 20488:2018**, current as confirmed in 2024, as a relevant international standard for collection, moderation and publication of online reviews. Its full text is not reproduced here; detailed conformity would require access to the standard and a formal review. https://www.iso.org/standard/68193.html
- **OECD (2019) Good Practice Guide on Online Consumer Ratings and Reviews**, covering fake/incentivized reviews, negative reviews and misleading moderation. https://www.oecd.org/en/publications/good-practice-guide-on-online-consumer-ratings-and-reviews_0f9362cf-en.html
- **European Commission Key Principles for Comparison Tools**, a comparative reference emphasizing transparent ranking methodology, scope/coverage disclosures, review authenticity and clear separation of paid placement. This is not a Pakistan legal standard. https://commission.europa.eu/document/download/4daaec50-817c-4506-8b47-621a5fb01df2_en?filename=key_principles_for_comparison_tools_en.pdf
- **Google Maps user-contributed content policies**, used as a practical anti-abuse reference for genuine experiences, conflict-of-interest and incentive bans, impersonation, harassment, off-topic content and personal information. V2 must define its own policy; Google policy is not V2 law or a direct template. https://support.google.com/contributionpolicy/answer/7400114
- **Pakistan PECA Amendment Act 2025** official Gazette and NCCIA law listing, relevant to legal review of online content and platform operations. This desk review does not interpret liability or determine what is defamatory/unlawful; counsel must assess current law and applicable provincial/federal rules before launch. https://na.gov.pk/uploads/documents/679b243193585_457.pdf and https://nccia.gov.pk/laws.php

## 3. Comparison product requirements

### 3.1 Comparable entity and context

Comparison must avoid comparing unlike things as if they were equivalent. The comparison unit should be selected explicitly:
- institution vs institution;
- campus vs campus;
- programme/qualification vs programme/qualification;
- admission offer/intake vs admission offer/intake.

For every compared row, retain education level, sector, campus, programme, awarding/affiliating authority, academic session, delivery mode and applicable student category where relevant. A university-wide fact must not be presented as a campus/programme fact without evidence.

### 3.2 Suggested comparison dimensions

| Dimension | Comparison treatment | Evidence and caveat |
|---|---|---|
| Location and distance | Address, map location and calculated distance from the user's selected reference point | State straight-line vs route distance and route mode; user location use must be opt-in and precise location should not be retained unnecessarily |
| Institution identity/type | Sector, provider type, level, campus and jurisdiction | Use controlled taxonomy; distinguish registered, recognized, affiliated and approved |
| Programme fit | Exact programme, award, duration, subjects, delivery mode and campus availability | Compare same or clearly related programme/award; do not equate different qualifications |
| Eligibility | Academic marks, subject prerequisites, equivalence and applicant category | Session-specific, source-linked and never a personalized admission guarantee |
| Admission | Current cycle, application route, opening/closing dates, entry test and status | Include last-checked date; no old deadline presented as open |
| Fees and total cost | Tuition, admission, recurring, exam, lab, transport, hostel, deposits and other known costs | Currency, billing period, session, one-time vs recurring; disclose components missing from total |
| Scholarships/aid | Named scheme, amount/range if published, eligibility, deadline and renewal conditions | No guarantee of eligibility or award |
| Recognition/affiliation | Competent authority, exact campus/programme/scope and validity dates | Never collapse recognition, registration, affiliation and equivalence into one badge |
| Facilities/accessibility | Hostel, transport, labs, library, disability access, student support | Source/date and availability by campus; unverified claims visibly marked |
| Reviews/experience | Review dimensions, average, distribution, count and recency | User-generated opinion, not official performance or proof of educational outcomes |

### 3.3 Fair comparison and presentation

- Keep the working target of 3–5 items per comparison as a provisional usability target.
- Allow students to select and remove items; do not auto-select a paid or preferred institution.
- Show side-by-side values with common units and the same academic session where possible.
- Mark missing, stale, disputed, estimated and not-applicable values distinctly; never convert unknown to zero.
- Show the source, effective date and last-checked date for material facts.
- Allow the user to choose distance reference point and route mode; do not silently use precise location.
- Avoid a single overall "best institution" score by default.
- If a score is introduced later, disclose dimensions, weights, normalization, sample size, missing-data treatment, data dates, exclusions and sensitivity; test for unfair outcomes across provider types and geographies.
- Separate sponsored placements from organic results, label them clearly and never allow payment to change an objective comparison metric.
- Explain coverage: a provider missing from the directory is not necessarily unregistered, inferior or closed.
- Provide print/share/export only with source/date context preserved and no private user details.

## 4. Ratings and reviews — collection policy

### 4.1 Account and eligibility

- Login is mandatory to submit a rating or review; public browsing remains available.
- A review is linked internally to an authenticated account, but public display must use a pseudonymous display identity or controlled display name and must not expose email, phone, CNIC, enrollment number or private account identifiers.
- Decide before implementation whether any account may review or whether a proportionate experience check is required.
- Do not label a reviewer "verified student", "alumnus" or "parent" unless a documented, privacy-preserving evidence method supports that exact label.
- Avoid collecting identity/enrollment documents by default. If later required, conduct a separate necessity, legal, security and retention assessment.
- Prevent duplicate or repeated reviews for the same entity/experience under a documented rule; allow a user to update their review without multiplying votes.
- Review scope (institution, campus, programme, or separate experiences) and eligibility period must be finalized during M2 design.

### 4.2 Rating dimensions

Candidate dimensions for later owner review:
- teaching and learning experience;
- faculty support;
- facilities and learning resources;
- administration and communication;
- fee transparency/value;
- student support and accessibility;
- campus environment and safety.

These are research candidates, not approved final dimensions. Do not ask for or infer protected/sensitive traits, sect/maslak, political affiliation, health status or other unnecessary personal data. Do not rate individual teachers/students by name. Do not imply a review score measures accreditation, learning outcomes or employment success.

Use a consistent, clearly labelled scale (candidate 1–5) only after owner approval. Preserve rating distribution and count, not just the mean. Explain whether each dimension has equal weight; do not choose weights without documented rationale and validation.

### 4.3 Genuine experience and conflicts

Prohibit:
- fabricated or AI-generated first-person experiences presented as real;
- paid, gifted, discounted or otherwise incentivized reviews intended to influence rating;
- review buying/selling, review gating or selective solicitation of positive reviews;
- reviews by institution owners, staff, contractors, competitors or close associates without clear disclosure and a policy decision;
- duplicate, coordinated, bot-generated or multi-account manipulation;
- threats, extortion, retaliation, impersonation or competitor attacks.

A user may be invited neutrally to leave honest feedback, but no benefit may depend on a positive rating, revision or deletion. Any unavoidable material relationship or incentive must be disclosed and reviewed; the default policy should prohibit incentives.

## 5. Moderation, complaints and institutional response

### 5.1 Moderation principles

- Publish community guidelines before enabling reviews.
- Use a combination of automated signals and human review; AI detection is a triage aid, not a final arbiter for contested speech.
- Apply the same rules to positive and negative reviews.
- Do not remove a review merely because an institution dislikes it, disputes its conclusion or asks for a higher rating.
- Do remove or restrict content that violates published rules, exposes personal data, contains credible threats/harassment, impersonation, spam, undisclosed manipulation or clearly unlawful material after appropriate review.
- Distinguish opinion from factual allegations. Ask for relevant context/evidence where serious allegations create legal or safety risk; do not publish private allegations as established facts.
- Preserve the original submission and moderation history with restricted access; publish only the minimum necessary explanation.
- Provide a reason category, notice and appeal route for content removal/restriction where safe and legally appropriate.
- Maintain emergency escalation for credible threats, child-safety issues and urgent privacy exposure.

### 5.2 Institution right of reply

- A verified institution representative may claim/manage the institution profile through a separately governed process.
- Institutions may post a public response under a clearly labelled official representative identity.
- An institution must not edit, suppress or unilaterally delete user reviews.
- A dispute may trigger fact-checking or moderation review, not automatic removal.
- Keep the response separate from the review and do not allow promotional content to masquerade as neutral evidence.

### 5.3 Complaints and appeals workflow

1. User or institution reports a specific review and selects a reason.
2. Platform acknowledges and creates a case ID.
3. Automated triage detects urgent privacy, threat, spam or manipulation signals.
4. Human moderator reviews the policy, content and available context.
5. Decision is recorded: keep, edit request, restrict, remove, escalate or request more information.
6. Notify affected parties with reason and appeal route, subject to safety/privacy limits.
7. A different reviewer handles material appeals where practical.
8. Close with a reasoned decision and retain a restricted audit record.

No institution gets a special moderation lane based on payment, advertising spend or commercial relationship.

## 6. Privacy, minors and safeguarding

- Do not display private account information or expose reviewer identity by default.
- Minimize collection of age, enrollment, contact and experience evidence.
- Before launch, obtain legal review of applicable age thresholds, consent/guardian requirements, safeguarding and data handling for minors.
- Provide a clear path to report grooming, threats, doxxing, personal information, bullying or coercion; define escalation and evidence-preservation controls.
- Do not invite minors to disclose exact class, timetable, dormitory, home address, phone number, personal identifiers or details that expose their routine/location.
- Do not solicit photographs/documents showing students or minors by default.
- Restrict moderator access to sensitive reports and establish retention/deletion schedules.
- Preserve Deeni Madaris default-OFF visibility; no religion/sect/maslak-based ratings, filters or profiling.

## 7. Trust signals and public explanations

Candidate trust signals:
- source-backed facts with authority, effective date and last checked;
- "institution representative" badge only after a defined ownership verification;
- "review from authenticated account" rather than "verified student" unless experience is actually verified;
- review count and rating distribution, with small-sample warning;
- moderation status and clear community rules;
- disclosed sponsored placement and advertising relationship;
- visible correction/appeal route;
- methodology and coverage statement.

Avoid trust badges that imply government endorsement or accreditation. A platform verification badge confirms only the stated verification process, not educational quality.

## 8. Legal and policy review requirements

Pakistan PECA Amendment Act 2025 is official law and is listed by NCCIA; this research does not interpret its application to any particular review or moderation scenario. Before launch, Pakistan-qualified counsel must review current federal/provincial consumer-protection, defamation, cybercrime, privacy, child-safety, intermediary/platform and advertising obligations, including procedural requirements for notices and takedowns. The legal framework must be rechecked at M2 and immediately before release. Comparative OECD, ISO, EU, FTC and Google materials inform policy design but are not assumed to apply as Pakistani law.

## 9. Open decisions for M2 / owner

1. Which entity is reviewable: institution, campus, programme, or a combination?
2. Can every authenticated account review, or must the platform verify an actual experience?
3. Which age groups may submit reviews and what guardian/consent safeguards apply?
4. Which rating dimensions and scale are approved?
5. Are reviews edited in place, versioned, or limited to one active review per entity per account?
6. What sample-size threshold, if any, is needed before displaying an aggregate score?
7. How are review recency, old reviews and changed institution status reflected?
8. What is the institution claim/representative verification method?
9. What are moderation response targets, appeals and legal escalation responsibilities?
10. Which ranking/comparison features, if any, are allowed, and how are sponsored placements separated?

No unresolved decision is silently converted into a product rule in this M1 baseline.

## 10. Weighted task register

| Task | Weight | Completion | Evidence / limitation |
|---|---:|---:|---|
| T01 Comparison purpose, entities and student use cases | 10% | 100% | Institution/campus/programme comparison units defined |
| T02 Comparison dimensions and data comparability | 15% | 100% | Programme, eligibility, admission, cost, recognition, facilities and review dimensions specified |
| T03 Ranking, sorting, sponsorship and transparency | 10% | 100% | Explainability, coverage, missing-data and paid-placement safeguards defined |
| T04 Review account and eligibility policy | 10% | 100% | Login requirement preserved; experience-verification decision left open |
| T05 Rating dimensions, authenticity and manipulation | 15% | 100% | Candidate dimensions and fake/incentivized/conflict rules documented |
| T06 Moderation, institution reply, complaints and appeals | 15% | 100% | Fair process, reasons, appeal and no unilateral institution deletion defined |
| T07 Privacy, minors, safeguarding and sensitive categories | 10% | 100% | Data minimization and legal review gates documented |
| T08 Trust signals, legal research and open decisions | 10% | 100% | Source-backed trust model and M2 decision register documented |
| T09 Owner review and step acceptance | 5% | 0% | Owner acceptance pending |
| **Total** | **100%** | **95%** | Research/documentation baseline; owner review pending |

## 11. Conclusion

V2 should help compare evidence, not declare a universal winner. Ratings and reviews should communicate genuine, contextual user experience without pretending to be official quality assurance. Login, fair moderation, transparent methodology, privacy safeguards, appeal rights and a strict separation between paid placement and organic evidence are essential trust requirements.

**No review feature or comparison engine has been implemented. No pre-launch participant research has been conducted or authorized.**
