# M1-S05 — Programme and Admissions Information Research

**Status:** Initial research and documentation baseline delivered; prepared for owner acceptance.  
**Prepared / checked:** 2026-11-12  
**Repository:** `mattari20/listing-v2`  
**Independence:** Research conducted for Listing V2; no legacy repository, dataset, implementation or production environment used.

## 1. Purpose and scope

M1-S05 identifies authoritative information sources and requirements for programme discovery and admissions decision support across Pakistan. It follows the provider-source baselines in M1-S02 through M1-S04.

The research covers:
- programme/qualification identity and level;
- awarding institution, teaching institution, campus and delivery mode;
- discipline, specialization, duration, intake and study calendar;
- academic and subject-specific eligibility;
- equivalence and prerequisite requirements;
- entry tests, interviews, auditions and other selection stages;
- admission cycle, application opening/closing dates, extensions, merit lists and joining dates;
- application method and official application route;
- application, admission, tuition, semester, examination, hostel, transport, laboratory and other charges;
- scholarships, grants, fee concessions and financial aid;
- source freshness, status, provenance and conflict handling.

**Research-only boundary:** A programme page or admission notice being public does not authorize scraping, bulk download, reuse, republication, commercial use, automated access or ingestion. No source owner was contacted, no records were scraped or bulk-downloaded, and no source was ingested. All sources below remain **RESEARCH ONLY** pending source-specific rights/access review in M1-S07.

## 2. Core research conclusion

Pakistan does not have one authoritative national source that contains all current programme, admission, eligibility, fee and scholarship information across schools, colleges, universities, professional education and TVET. The credible approach is a **federated evidence model**:
1. competent recognition/regulatory authorities establish provider, campus, qualification and programme approval context;
2. the institution or its officially designated admitting university publishes the actual programme offer, current prospectus, admission schedule, eligibility, fee and application instructions;
3. examination, equivalence and entry-test authorities establish relevant qualification/test rules;
4. scholarship authorities and participating institutions publish financial-aid rules and current application windows.

No single source should be treated as authoritative for every field. For example, HEC recognition does not itself prove that a specific campus is currently offering a programme or accepting applications; a provider prospectus does not itself prove legal recognition or professional accreditation.

## 3. Source inventory

| ID | Sector / jurisdiction | Official source and route | Information supported | Limitations / handling |
|---|---|---|---|---|
| ADM-01 | National — universities/DAIs | HEC recognised universities: https://www.hec.gov.pk/english/universities/pages/recognised.aspx | Institution identity, public/private sector, chartering body, discipline, province/city; recognition context | Recognition is not a live programme catalogue, admission notice, campus approval for every location or proof of current intake. Cross-check the exact campus and programme. |
| ADM-02 | National — recognized campuses | HEC recognized campuses: https://www.hec.gov.pk/english/universities/Pages/DAIs/HEC-recognized-Campuses.aspx | Campus-level recognition context and campus status notices | Campus recognition and programme/session availability are separate. Preserve status and date; do not infer that all programmes at a parent university operate at every campus. |
| ADM-03 | Punjab — public colleges | Online College Admissions System (OCAS): https://ocas.punjab.gov.pk/ | Centralized public-college applications for Intermediate and Bachelor/BS/ADP programmes; participating college lists, application tracking, application fee and help guides | Scope is public colleges participating in OCAS, not all Punjab public/private providers. Session pages and notices are time-bound; fee and application workflow must be checked for the relevant cycle. |
| ADM-04 | Punjab — university programmes | University of the Punjab admissions notices and portal: https://pu.edu.pk/home/admission_notice ; https://admissions.pu.edu.pk/ | Programme-specific notices, application windows, vacant-seat phases, merit/selection information and official application route | A notice is session/phase-specific. Record each programme and campus as separately scoped where the notice distinguishes them. Do not treat an old notice as currently open. |
| ADM-05 | Punjab — engineering and technology | UET Lahore admission portal and downloads: https://apply.uet.edu.pk/ ; https://admission.uet.edu.pk/downloads/ | Undergraduate programme/campus options, prospectus, admission categories, eligibility, entry-test/merit rules, fee schedules, merit lists and document instructions | The portal changes by session and phase. Fee schedules and category-specific subsidies are not safely reducible to one programme fee. Preserve the exact prospectus/version and effective session. |
| ADM-06 | Punjab — medical/dental admissions | University of Health Sciences (UHS): https://www.uhs.edu.pk/ | Punjab MBBS/BDS admission policy, prospectus, MDCAT notices/results, centralized application, merit/selection lists and deadlines | UHS is the admitting university for defined Punjab medical/dental admissions; the process is regulated and session-specific. Use current PM&DC policy and UHS notice, not stale prospectuses. |
| ADM-07 | National / armed-forces administered medical colleges | National University of Medical Sciences (NUMS): https://numspak.edu.pk/news-detail/centralized-admissions-mbbs-bds-session-2026-27 | Centralized MBBS/BDS admissions for NUMS constituent, affiliated and attached colleges; eligibility, test/merit weights, application fees, dates and college list | Applies to its stated college network and seat categories only. Do not merge with UHS/provincial processes or assume identical dates/eligibility. |
| ADM-08 | National — medical/dental rules | Pakistan Medical & Dental Council (PM&DC): https://www.pmdc.pk/Publication/LawsAndRegulations ; https://pmdc.pk/Home/FAQs | Current admissions regulations, MDCAT/subject rules, admission deadlines, merit principles and recognition context | PM&DC sets/updates regulatory requirements; admitting universities run the designated process. Preserve the dated policy and avoid hard-coding thresholds from a superseded cycle. |
| ADM-09 | National — professional qualification equivalence | IBCC equivalence: https://ibcc.edu.pk/equivalence-intro/british-system/ ; https://ibcc.edu.pk/faqs/equivalence-faqs/ ; https://ibcc.edu.pk/registered-qabs-foreign-examination-boards/ | O/A-Level and other qualification equivalence, subject-combination requirements, recognized awarding bodies and document requirements | Equivalence depends on qualification, subject combination, exam session and applicable rules. V2 must not calculate or guarantee equivalence without an approved authoritative rule set. Link to IBCC for official assessment. |
| ADM-10 | National — scholarship catalogue | HEC scholarships and grants: https://www.hec.gov.pk/english/scholarshipsgrants/pages/default.aspx | National/international scholarship programme discovery, category, programme-specific notices and links | The landing page aggregates different schemes with different eligibility, deadlines and participating institutions. Each scheme needs its own current official notice and eligibility source. |
| ADM-11 | National — need-based higher education aid | HEC Need Based Scholarships: https://www.hec.gov.pk/english/scholarshipsgrants/NBS/Pages/default.aspx ; eligibility: https://www.hec.gov.pk/english/scholarshipsgrants/NBS/Pages/Eligibility-Criteria.aspx | Participating public institutions, undergraduate scope, financial-need assessment and application through institutional Financial Aid Offices | Participation, slots, funding and eligibility are institution/year dependent. A scheme overview does not mean applications are currently open or a student is guaranteed funding. |
| ADM-12 | Punjab — scholarships | Punjab Educational Endowment Fund (PEEF): https://peef.org.pk/ ; Punjab university scholarship directory example: https://pu.edu.pk/scholar | Scholarship category and programme discovery, including merit, need, intermediate, bachelor and special categories | Eligibility and open windows vary by scheme, domicile, marks, income, institution and academic year. Verify each current PEEF notice; university directories may include legacy or institution-specific schemes. |
| ADM-13 | Punjab — private university admissions | University of Management and Technology (UMT): https://admissions.umt.edu.pk/Admissions-Schedule.aspx | Current institution-published programme groups, admission criteria, merit calculation, application steps, processing fee and fee/scholarship links | Institution-owned admissions information is the primary source for its own offer, but not independent recognition evidence. Verify programme/campus status separately and keep marketing claims distinct. |
| ADM-14 | Sindh — public university programmes | Sindh Agriculture University: https://www.sau.edu.pk/admissions.php | Programme categories, undergraduate/postgraduate and specialist programmes, application dates, entry tests, interview/merit stages, seat/fee breakups and admission policy links | Current notice and each attached policy/seat breakup must be captured together. Dates shown on the page apply only to the stated academic year and phase. |
| ADM-15 | Gilgit-Baltistan — public university programmes | University of Baltistan admission schedule: https://uobs.edu.pk/admissions/admission-schedule.php | Academic-year schedule, programme level, application deadlines, entry tests, merit lists, fee submission and commencement | Schedule page may contain inconsistent academic labels or dates; validate each event against the dated official notice and application portal before display. |
| ADM-16 | National — vocational and skills training | NAVTTC student/programmes pages: https://navttc.gov.pk/STUDENT/ ; https://navttc.gov.pk/programs/ | Trade/programme catalogue, training duration, open/closed programme flags, eligibility, application route, training institute search, assessment/certification context | Programme availability and eligibility are batch-specific. A programme catalogue or promotional summary does not guarantee a seat, job placement or universal free training. Verify the live batch notice and named institute. |
| ADM-17 | National — TVET qualifications | NAVTTC / NVQF: https://navttc.gov.pk/programs/ | Qualification framework levels, competency-based outcomes, trades and qualification pathway | A trade title does not prove every provider is registered or every course is currently available. Link the exact training institute and approved course/batch. |
| ADM-18 | National — training provider accreditation | NAVTTC / NAC-TVS: https://navttc.gov.pk/ | Provider registration and separate accreditation process, including institute search route | Registration, accreditation, course approval, funded programme participation and current batch availability are different facts. Keep each status and authority separate. |
| ADM-19 | National — qualification awarding bodies | IBCC registered QABs and foreign examination boards: https://ibcc.edu.pk/registered-qabs-foreign-examination-boards/ | Approved qualification awarding bodies, qualification names, equivalence groups and validity/renewal dates | Recognition of an awarding body/qualification does not by itself guarantee a particular institution's course recognition or student eligibility. Check the exact qualification and date. |
| ADM-20 | Provider-specific — private universities, colleges and schools | Official provider admissions pages, current prospectuses, programme catalogues, fee schedules and admission notices | Most current institution-specific programme offer, campus, delivery mode, eligibility, schedule, fees, scholarships and application steps | Provider material is first-party and may be promotional, incomplete or changed. Cross-check recognition, campus, programme approval and professional regulator status. Keep the source URL, version and checked date. |
| ADM-21 | Professional / specialist programmes | Competent professional regulators and councils already mapped in M1-S02/S03 (e.g. PM&DC, PEC, PNMC, Pharmacy Council, PCP, NCEAC, NACTE and other applicable bodies) | Programme/institution/campus recognition, accreditation, intake restrictions, approved seats or programme-specific requirements where published | Approval may be programme-, campus-, intake- or session-specific. The exact competent authority depends on the discipline. Do not infer approval from HEC university recognition or provider marketing. |
| ADM-22 | Examination and entry-test routes | Official admitting universities and designated testing bodies named in each admission notice (e.g. MDCAT admitting universities, NUMS and institution-specific entry tests) | Test registration, test date, syllabus, fee, admit card, results and score-validity rules | Test body, test score and admission authority may differ. Record who conducts the test, who owns admissions and which programme/session accepts the result. |

## 4. Programme and admissions evidence model

The research indicates that V2 should treat the following as distinct, versioned evidence objects. This is a requirements recommendation for later M2 design, not a database schema.

### 4.1 Programme offer

- Institution/provider and campus/site identity.
- Programme title as published and normalized title (without losing the source wording).
- Award/qualification title, level and awarding body.
- Discipline, subject group, specialization and field of study.
- Study mode (on-campus, online, distance, hybrid, weekend, evening) and delivery location.
- Duration, credit/semester structure where stated, and language where stated.
- Intake/capacity/seats only where an official source publishes them.
- Programme approval/accreditation source, scope, status and validity, when applicable.
- Source URL, publication/version date, observation date and evidence status.

### 4.2 Admission cycle and application

- Academic session, intake name and phase (e.g. Fall 2026, Spring 2027, vacant-seat phase).
- Application opening date/time and closing date/time, including timezone.
- Extension/revision/correction history and superseded notice relationship.
- Application route (official portal, institution office or authorized central portal).
- Processing/application fee, payment method and refundability.
- Required documents and submission format.
- Test/interview/audition dates, score validity, selection stages and merit-list publication dates.
- Selection list, offer acceptance, fee deposit and enrolment deadlines.
- Admission status: announced, upcoming, open, extended, closed, cancelled, paused, merit published, waitlist or completed — mapped from source evidence, not guessed.

### 4.3 Eligibility and merit

- Prior qualification level and accepted equivalent qualifications.
- Minimum marks/grades and subject combinations.
- Domicile, nationality, age, seat category, gender or other lawful criteria only where the official notice explicitly states them.
- Entry test, interview or portfolio requirements and minimum scores.
- Merit formula with exact weights, source and effective session.
- Equivalence/attestation prerequisites and competent authority.
- Exceptions, reserved-seat rules and conditions, with clear source and date.
- Eligibility statements must be programme + campus + session + category scoped. A general institution eligibility page cannot automatically apply to every programme.

### 4.4 Fees and financial aid

Keep separate line items for application/processing, admission/registration, tuition per semester/year/credit, examination, lab, library, technology, hostel, transport, security deposit, refundable deposits and other compulsory charges. Preserve currency, amount, billing unit, one-time/recurring status, effective session, category, source and whether the fee is estimated or officially published.

Scholarship records must include scheme owner, programme, participating institutions, eligible disciplines, domicile/nationality, merit/need criteria, income threshold if any, coverage (full/partial tuition, stipend, living costs), duration, renewal rules, exclusions, application channel, deadline, and whether the award is confirmed, advertised or merely described. Never imply that a scholarship is guaranteed or currently open from a general scheme page.

## 5. Freshness, status and conflict rules

1. **No single "current" field without provenance:** every programme, eligibility, fee and deadline assertion needs source URL, issuer, publication/effective date, observation date, academic session and scope.
2. **Use the competent source for each fact:** regulator for recognition/approval; admitting authority for centralized process and rules; institution for its programme offer and institution-specific fees; scholarship owner/participating institution for aid criteria.
3. **Preserve notice history:** a revised schedule supersedes only the affected earlier dates/conditions. Keep prior notice, revised notice and the reason/effective timestamp when available.
4. **Deadline precision:** store date, time and timezone if published. Do not turn a date-only deadline into an assumed midnight time. If source is ambiguous, show "time not stated" and link the notice.
5. **Admission status must be evidence-derived:** "Open now" requires a current official application window and confirmed portal status. A programme page, stale notice, cached search snippet or a future/past date alone is insufficient.
6. **Fees are session- and category-specific:** preserve fee schedule versions and all compulsory components; do not display a single amount if only tuition or a partial fee is known.
7. **Eligibility is not a prediction:** present source criteria and a checklist; do not promise admission, merit position, equivalence, scholarship or selection.
8. **Conflict handling:** if regulator, admitting university and institution notices conflict, preserve both, identify the authority hierarchy for the exact issue, mark the record conflicted/under review and avoid an unsupported resolution.
9. **Historical records:** retain closed admission cycles as history only; never surface them as open opportunities.
10. **AI-assisted extraction:** later agents may propose extracted facts and cite source passages, but must not silently publish or overwrite verified facts. Confidence, source lineage, reviewer decision and correction history are required in later design.
11. **No invented completeness:** missing fees, deadlines, eligibility or seat counts remain unknown/not published, not zero or "not applicable."
12. **No student profiling or sensitive inference:** do not infer disability, religion, ethnicity, financial status or other sensitive traits. Seat categories and scholarship criteria are included only as published, relevant eligibility information, with appropriate privacy minimization.

## 6. Product implications for later design

- Student-facing filters should distinguish programme level, subject/discipline, campus, study mode, duration, admission cycle/status and affordability signals.
- Students need comparison of the same programme across institutions, and different programmes within one institution, without conflating awards, levels or delivery sites.
- Admission opportunity cards should show the last checked date and exact source link beside any time-sensitive deadline or fee.
- Provide a clear "verify on official portal" path; V2 is an information and discovery service, not the admitting authority or payment processor.
- Alerting/reminders may be useful for a user's saved programme/deadline after a trustworthy current official date exists; do not generate reminders from stale/ambiguous dates.
- Fees and scholarships need transparent coverage labels (tuition-only vs total-cost, full vs partial, stipend vs fee waiver).
- Deeni Madaris visibility remains controlled by V2-DEC-006; M1-S05 does not expose Madaris in public search, programme results, maps, counts, sitemaps or APIs while the setting is OFF.

## 7. Open gaps and follow-up

1. Build a complete jurisdiction-by-jurisdiction map of intermediate/college centralized admission authorities, provincial admission systems and examination/entry-test bodies; the current OCAS evidence is Punjab-specific.
2. Verify current admission routes and programme catalogues for public/private universities in Sindh, KP, Balochistan, AJK, GB and ICT beyond the representative examples in this register.
3. Verify current fee and scholarship portals for each province/territory, including PEEF and other provincial schemes; do not infer from one university's directory.
4. Map professional-programme accreditation and intake approval to exact programme/campus/session for each relevant council in M1-S02/S03.
5. Verify whether TVET course/batch data and institute-level delivery locations can be publicly discovered through NAVTTC's current live portal; distinguish public programme pages from staging/sample data.
6. Define policy for private schools' class-level admissions, early-childhood providers, coaching/tuition and online short courses; not all publish structured admission cycles.
7. Establish a source-by-source freshness cadence and notice revision/correction handling in M1-S07/M2; do not promise real-time updates.
8. Review personal data fields in application pages and portals; V2 should link out and must not copy student applications, CNICs, test credentials or applicant records.
9. Carry forward source rights: all source families remain RESEARCH ONLY. M1-S07 must determine lawful access, terms, licenses, privacy and technical constraints before any reuse/collection.
10. Carry forward all M1-S04 coverage gaps; S05 does not claim a national programme or admissions census.

## 8. Evidence references and observation date

Public official routes were checked on 2026-11-12. Representative current source evidence includes:
- HEC recognised-university directory and recognized-campus listing.
- Punjab OCAS public-college portal and programme/session announcements.
- Punjab University admissions notices and application portal.
- UET Lahore admission portal, prospectus and detailed Fall 2026 fee schedule.
- UHS public notices and the current MBBS/BDS policy/prospectus route; NUMS centralized MBBS/BDS 2026–27 admissions.
- PM&DC's 2026 admissions/curriculum policy page and FAQs; admission processes and deadlines are regulated and time-sensitive.
- IBCC equivalence rules, recognized qualification awarding bodies and session-sensitive equivalence requirements.
- HEC scholarship catalogue and Need Based Scholarship eligibility; PEEF and institution scholarship routes.
- UMT, Sindh Agriculture University and University of Baltistan programme/admission pages as representative institution-owned source patterns.
- NAVTTC student, programme and institute registration/accreditation routes.

## 9. Conclusion

M1-S05 establishes that programme and admissions information must be assembled from a federated, time-aware set of regulatory, admitting-authority, institution, examination/equivalence and scholarship sources. The most important design requirement is to keep programme offer, campus, admission cycle, eligibility, fees and scholarship evidence separately scoped and versioned. This research is not a complete national programme catalogue, does not establish that any admission is currently open, and does not grant reuse rights or authorize collection/ingestion.
