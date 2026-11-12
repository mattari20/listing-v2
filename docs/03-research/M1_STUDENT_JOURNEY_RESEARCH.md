# M1-S01 — Student and User Journey Research

**Status:** Desk-research and requirements baseline complete; prepared for owner acceptance. Primary participant validation is explicitly deferred during platform construction and has not been conducted.  
**Research scope:** Pakistan, with a student-first discovery and education decision-support product.  
**Research baseline date:** 2026-11-11  
**Inputs:** Direct V2 owner direction and the independent sources listed below. No legacy project materials were used.

## 1. Purpose

Establish a defensible student journey and a primary-research plan before detailed product requirements, architecture or technology choices are finalized.

This document separates:
- **Source findings:** facts or findings explicitly supported by cited sources.
- **Product hypotheses:** V2 assumptions to validate with students, parents/guardians and other users.
- **Open questions:** matters that primary research or further independent evidence must resolve.

Desk research is not a substitute for interviews, surveys or usability testing. No primary participants have been recruited or interviewed for this baseline.

## 2. Source-derived findings

### 2.1 Education transitions and levels

Pakistan Bureau of Statistics (PBS), citing Pakistan Institute of Education estimates for 2022–23, reports enrolment at pre-primary, primary (grades 1–5), middle (grades 6–8), secondary (grades 9–10) and higher secondary/intermediate levels. PBS describes a 12-year school structure comprising 8 years of elementary education, 2 years of secondary education and 2 years of higher secondary/intermediate education. The same page describes the broader system as six levels, although the visible explanation is truncated after the intermediate level; V2 should not infer the missing detail from that page alone.

The PBS page reports the following 2022–23 enrolment estimates: pre-primary 12.09 million; primary 24.04 million; middle approximately 9.1 million; secondary 4.6 million; higher secondary/intermediate 2.3 million. These are historical estimates for 2022–23, not current live enrolment counts.

Source: [PBS — Social Statistics, Education FAQs](https://www.pbs.gov.pk/docs/social-statistics/).

### 2.2 Admission and transition procedures are not uniform

The Punjab Higher Education Department's Student Affairs page describes different procedures for board registration, private candidates, college admission after SSC results, transfers and equivalence for foreign qualifications. It states that Punjab matriculation/intermediate examinations are conducted by nine declared boards and describes admission timing for government colleges after SSC results.

This is evidence that a student journey can include board-specific registration, result publication, application windows, transfer rules and qualification equivalence. It is Punjab-specific evidence and must not be generalized to every province, territory, institution or programme.

Source: [Higher Education Department, Government of Punjab — Student Affairs](https://hed.punjab.gov.pk/student-affairs).

### 2.3 University choice factors require more than a single ranking

A 2021 Pakistan-focused study of 200 business students reports that degree value, field/programme availability, department size, faculty reputation, programme structure, research opportunities and postgraduate job placement influenced university choice. Its population is limited to business students and should not be treated as nationally representative.

Source: [Naveed and Khurshid (2021), Hamdard Islamicus](https://www.hamdardislamicus.com.pk/index.php/hi/article/view/46).

A 2014 study of university choice in Pakistan, published as a New York Fed Staff Report, examined expected earnings, non-pecuniary factors and financial constraints. It reports that financial constraints affected a substantial portion of the study sample and that non-pecuniary factors also mattered. Its date and study design mean it is supporting context, not a current population estimate.

Source: [Delavande and Zafar (2014), Federal Reserve Bank of New York Staff Report 683](https://www.newyorkfed.org/research/staff_reports/sr683.html).

### 2.4 Higher education pathway terminology

The HEC Annual Report 2023–24 presents higher-education levels and examples including associate degrees, bachelor's programmes, master's/MS/MPhil and doctoral qualifications. This is useful reference material for the vocabulary students may encounter, but the report is not a complete admission guide for every discipline or institution.

Source: [HEC — Annual Report 2023–24](https://www.hec.gov.pk/english/news/AnnualReports/Annual-Report-2023-24.pdf).

### 2.5 Digital access and the limits of a digital-only journey

The Pakistan Bureau of Statistics' HIES 2024–25 release reports household internet access of approximately 70% and individual internet use of approximately 57%. These are household/population indicators, not student-specific usage rates; they do not establish that every student has a personal smartphone, private device access or uninterrupted connectivity.

The Pakistan Institute of Education's *Pakistan Education Statistics 2023–24* reports that only 4% of public schools provide internet connectivity specifically for students' pedagogical use nationally, with substantial regional variation. This is a school-infrastructure indicator, not a direct measure of students' home connectivity or ability to use an independent discovery platform.

**Product implication:** mobile-friendly and low-bandwidth access should be treated as important design requirements to test, while the service must not assume that every learner has continuous internet, a personal device or school-based connectivity. A manual locality-search route and text-first results should remain available. These figures do not justify excluding desktop users or making assumptions about any individual learner.

Sources:
- [PBS — HIES 2024–25 publication page](https://www.pbs.gov.pk/household-integrated-economic-survey-hies-2024-25/) (published 2 January 2026; includes final report and social report).
- [Pakistan Institute of Education — Pakistan Education Statistics 2023–24](https://pie.gov.pk/SiteImage/Publication/PES%202024.pdf), especially technology indicators and school internet access (pp. 47–49).
- [PBS — HIES 2024–25 launch summary](https://pid.gov.pk/site/press_detail/31490), 1 January 2026.

## 3. Initial V2 student segments — hypotheses, not validated personas

| Segment hypothesis | Transition / job to be done | Likely questions to validate |
|---|---|---|
| Middle-school learner and family | Understand possible secondary-school options | Which nearby schools offer the required level, subjects, language and safe travel arrangements? |
| Matric/SSC student and family | Choose an intermediate, college, technical or other next pathway | Which groups/programmes are available, what are eligibility rules, fees, deadlines and board requirements? |
| Intermediate/HSSC student | Choose a degree, associate, vocational or professional pathway | Which programmes match marks, subjects, interests, budget, location and recognition requirements? |
| University student / transfer applicant | Compare continuation, transfer or postgraduate options | What is the programme structure, transfer eligibility, recognition, cost and schedule? |
| Skills / vocational learner | Find a relevant skills or technical provider | Which course is available, duration, credential/recognition, practical training and employment relevance? |
| Parent / guardian | Support and verify a student's decision | Is the institution credible, affordable, reachable, safe and suitable? |
| Adult / returning learner | Resume or change education pathway | What prior learning is recognized, what flexible schedules exist and what are the costs? |

These segments are deliberately provisional. Research must establish which are distinct, which overlap and which should be prioritized for the initial release.

## 4. Provisional end-to-end journey

1. **Recognize a transition:** student or family identifies a need to select a school, college, programme, vocational course or further study.
2. **Clarify the learner's position:** current class/qualification, board or curriculum where relevant, subjects, interests and intended next step.
3. **Discover options:** search by area, education level, programme, institution type/sector and travel range.
4. **Check eligibility and availability:** verify entry requirements, current admissions, deadlines, board/qualification equivalence and campus-level offering.
5. **Understand total cost and access:** tuition and additional fees, scholarships, transport, hostel, schedule and accessibility where published.
6. **Assess trust:** recognition/affiliation evidence, source freshness, institution identity, campus accuracy and clearly labelled student feedback.
7. **Compare a shortlist:** compare like-for-like programmes/campuses using transparent fields; expose missing or stale facts.
8. **Take action:** contact the institution or follow its official admission/application process.
9. **Track and revisit:** save options and revisit admission status or deadline information, if the student opts in.
10. **Correct and contribute:** submit corrections or experience-based feedback under privacy and moderation controls.

This is a V2 journey hypothesis derived from owner direction, official process examples and desk research. It is not yet a validated user journey.

## 5. Research questions

### Student context and transitions
- What decision triggers a search, and how early does the student begin?
- Who participates in the decision: student, parent/guardian, teacher, counsellor or peer?
- Which transition points create the most confusion or risk of missing a deadline?
- How do pathways differ by province/territory, board, public/private sector, curriculum and education level?

### Discovery and evaluation
- Where do students currently discover institutions and programmes?
- Which sources do they trust, and how do they verify claims?
- How important are distance, transport, safety, gender-related policies, language, facilities and schedule?
- Which information is difficult to obtain or compare?

### Affordability and access
- How do students understand total cost, fee periods and additional charges?
- How are scholarships and financial assistance discovered?
- How do internet access, device constraints, language and accessibility affect the search?

### Decision and application
- What makes a student shortlist, reject or contact an institution?
- What official application steps are most confusing?
- What information must be current before a student can act?
- What follow-up or reminders are useful without becoming intrusive?

### Trust, privacy and safety
- What evidence makes recognition, affiliation or a programme claim trustworthy?
- What should be visible when information is unverified, disputed or stale?
- What personal information is strictly necessary?
- What protections are needed when the user is a minor?

## 6. Primary research plan

### Participant groups
Recruit a varied, opt-in sample across:
- Students at transition points (middle-to-secondary, SSC-to-HSSC, HSSC-to-tertiary/skills).
- Current university/college students.
- Vocational/technical learners.
- Parents/guardians.
- Where feasible, teachers or counsellors as supporting stakeholders.

Do not claim statistical representation from a small qualitative sample. Define the sample size and recruitment approach after confirming available channels and consent safeguards.

### Methods
1. Semi-structured interviews to understand real decision stories and vocabulary.
2. Short survey to test frequency and relative importance of discovered needs after exploratory interviews.
3. Journey-mapping sessions to identify actors, steps, evidence, delays and pain points.
4. Prototype/usability sessions only after a low-fidelity flow exists; no technology stack is implied by this plan.

### Ethics and privacy
- Obtain informed, voluntary consent and explain purpose, recording and retention.
- For minors, use age-appropriate assent and appropriate parent/guardian consent; do not recruit or collect sensitive data without an approved safeguarding process.
- Do not collect CNIC, B-Form, student roll numbers, marksheets, contact lists or other identifiers unless a later approved research protocol proves they are necessary.
- Use pseudonymous participant IDs; store contact/consent records separately from research notes.
- Allow withdrawal and define retention/deletion before recruitment.
- Do not publish identifiable quotes or participant-level information.

## 7. Research evidence register

| ID | Evidence | What it supports | Limitation | Status |
|---|---|---|---|---|
| M1S01-E01 | PBS Social Statistics / PIE estimates (2022–23) | Broad school-level transitions and historical enrolment context | Historical year; national aggregate; not student-choice research | Reviewed |
| M1S01-E02 | Punjab HED Student Affairs | Example of board registration, SSC-to-college admission and equivalence steps | Punjab-specific; not a national rulebook | Reviewed |
| M1S01-E03 | Naveed & Khurshid (2021) | Candidate university-choice factors | 200 business students; limited population | Reviewed |
| M1S01-E04 | Delavande & Zafar (2014) | Financial constraints and non-pecuniary factors in university choice | Older study; not current prevalence | Reviewed |
| M1S01-E05 | HEC Annual Report 2023–24 | Higher-education qualification terminology | Not a comprehensive student-facing pathway guide | Reviewed |
| M1S01-E06 | PBS HIES 2024–25 | National household internet access and individual internet-use context | Population/household indicators, not student-level device ownership, reliability or usage | Reviewed — contextual only |
| M1S01-E07 | Pakistan Education Statistics 2023–24, PIE | Public-school student internet access and regional digital infrastructure gaps | Public-school infrastructure indicator; not a measure of home connectivity or all education sectors | Reviewed — contextual only |
| M1S01-E08 | IBCC equivalence FAQs | Equivalence as a distinct pathway step for qualifications from different boards | Operational requirements vary by qualification and admission context; current process must be checked with IBCC | Reviewed — process reference only |

Primary interviews, surveys and usability evidence: **not collected and deferred by owner during platform construction**. Draft adult-only research instruments are maintained separately in [M1 Student Research Instruments](M1_STUDENT_RESEARCH_INSTRUMENTS.md); they are archived preparation material only and must not be distributed or activated.

## 8. Desk-research implications and provisional requirements

The following are evidence-informed V2 requirements or hypotheses. They are not validated personas or evidence of actual feature preference:

- Begin with an optional education-stage/current-qualification and intended-next-step route, while retaining direct search for users who already know an institution or programme.
- Model the decision at institution, campus and programme level where the underlying facts differ; do not imply that every campus offers every programme.
- Present eligibility, admission status, deadlines, total fees, scholarships, duration and recognition only when evidence exists and the applicable source, as-of date and verification state can be shown.
- Support manual locality search without requiring location permission; location-based discovery must be opt-in.
- Allow comparison of selected options and make missing, stale or incomparable values visible instead of silently filling gaps.
- Treat official source facts, provider-submitted claims, AI-discovered candidates, estimates and student opinions as distinct information classes.
- Include student and parent/guardian roles in requirements, but do not assume they have identical goals or decision authority.
- Use mobile-friendly, low-bandwidth and text-first design as a design requirement to validate. HIES and school connectivity statistics are context, not proof of an individual student's access.
- Evaluate English and Urdu language needs, accessibility and device-sharing patterns in later research/design; do not claim a language preference without evidence.
- Preserve privacy by default, especially for minors; do not require personal identifiers to browse or compare.
- Authenticated ratings/reviews are a post-launch product feature, not a substitute for pre-launch research and not a reason to conduct a survey during construction.

## 9. M1-S01 acceptance criteria — desk-research construction baseline

M1-S01 is a documentation/research baseline step. Under the owner's 2026-11-12 direction, primary interviews, surveys, recruitment and research outreach are deferred during platform construction. They are not required to close this construction-stage baseline and must not be represented as completed or validated.

The step is ready for owner acceptance when:
1. The independent desk-research register includes dated sources, the specific claim each source supports and limitations that prevent overgeneralization.
2. Student and supporting-user segments are explicitly labeled as hypotheses rather than validated personas.
3. At least one end-to-end journey identifies actors, stages, decisions, information needs, trust checks, action points and unresolved questions.
4. Student discovery requirements have stable IDs and measurable, implementation-neutral acceptance criteria.
5. Requirements trace to source evidence or explicit owner decisions; unsupported assumptions and unresolved design questions are separated.
6. Privacy, location consent, accessibility, digital access and minor-safeguarding constraints are documented without collecting participant data.
7. Product Vision and Student Discovery Requirements are reconciled with the journey baseline.
8. Primary research is clearly marked deferred; the draft instruments remain archived and inactive.
9. The owner reviews and explicitly accepts the resulting desk-research baseline.

**Not claimed by this closeout:** validated personas, representative student preferences, field-tested usability, statistical estimates of student demand, or final UX/architecture decisions.

## 10. Deferred validation backlog and handoff

After platform construction, and before treating the provisional segments/journey as validated, the owner may authorize a separate research phase. That phase must first approve recruitment channels, adult/minor scope, consent and safeguarding, data minimization, storage/access, retention/deletion, incentives (if any), and budget. The archived draft kit is not approved for distribution.

Future validation should test which transition segments are distinct; student versus parent/guardian decision roles; actual search channels, language, device-sharing and connectivity patterns; importance of cost, transport, safety, accessibility, recognition, programme fit and admission timing; and whether comparison, save/shortlist and update features solve observed problems.

No recruitment, interview, survey, outreach or usability test is authorized by this document. Continue strict V2/legacy non-interference for all future inputs.
