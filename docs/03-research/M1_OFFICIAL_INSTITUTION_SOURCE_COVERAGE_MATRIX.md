# M1-S02 — Official Institution Source Coverage Matrix

**Status:** Independent source-discovery and coverage baseline, with selected 2026-11-12 source-term/freshness clarifications; not a complete national inventory and not an approval to collect or republish source data.  
**Prepared:** 2026-11-12  
**Research basis:** Publicly accessible official regulator, government and education-sector sources consulted independently for V2.  
**Independence:** No legacy repository artifacts, data, implementation patterns or historical findings were used.

## 1. Purpose and decision boundary

This matrix records which official source families can support institution discovery, what each source appears to cover, and what must be verified before V2 relies on it. It is a research register, not a production ingestion specification.

A source listing is not proof that every campus, programme, intake, affiliation or qualification is currently authorized. Recognition must be represented at the correct level (provider, campus, programme, intake/session, qualification or professional approval), with the source and check date preserved.

## 2. Source coverage matrix

| Sector / institution family | Official source and observed coverage | Geography / granularity visible | V2 research value | Limitations and follow-up |
|---|---|---|---|---|
| Universities and degree-awarding institutions | HEC recognised universities/DAIs directory; searchable by sector, chartering body, discipline, province and city | National; institution-level records with province/city filters | Core source for higher-education provider identity and recognition status | Verify update cadence, record-level status history, legal reuse terms, and whether directory output includes all relevant institution types |
| University campuses and study centres | HEC recognised campuses page; explicitly lists campuses recognized by HEC | National; parent institution and campus location | Demonstrates that parent institution and campus must be separate records | Verify campus identifiers, current status and treatment of study centres; do not infer campus recognition from parent recognition |
| Affiliated colleges | HEC accreditation section identifies recognised affiliated colleges of public-sector HEIs and the 2024 affiliation policy | National / institution-specific | Supports explicit affiliation relationships between a college and a university/DAI | Obtain and verify current affiliated-college register and effective dates; policy scope must not be generalized to private affiliations |
| Medical and dental colleges | PMDC recognised institutions and qualifications pages include undergraduate college lists by public/private sector, province and city | National; institution, city, sector and seat allocation | Professional programme and institution verification for medicine/dentistry | Confirm exact current approval status, programme, session, seat count and campus; avoid relying on third-party mirrors or stale snapshots |
| Nursing and midwifery institutions | PNMC recognised institutes directory lists institutes by province/city, ownership and programmes; page also contains a separate fake-institute list | National; institute, province, city, ownership, programme | Strong example of programme-specific professional recognition and adverse-status data | Page shows legacy-looking records and irregular formatting; verify update date, current programme approvals and status before use |
| Pharmacy education | Pharmacy Council of Pakistan official institutions directory exposes institution, province, city, seats, programme and status (including active / stoppage of admissions / show-cause examples) | National; institution, programme, province, city and status | Useful model for programme-level status and intake/seat information | Verify status definitions, update cadence, source terms and whether historical or provisional records are mixed with active approvals |
| Punjab private schools | Punjab School Education Department PEPRIS public parent-corner page lists valid e-licensed private schools with level, gender, registration number, validity, district, tehsil and address | Punjab; school-level and district/tehsil | A concrete model for registration validity and school location coverage | Search and display access constraints need testing; public listing may cover private registered schools only, not all public schools or all education providers |
| Khyber Pakhtunkhwa private schools | KP Private Schools Regulatory Authority registered-school registers and district results show name, level, registration number and status | KP; district-level school records | Useful source for school registration and active status | Confirm completeness across districts, update schedule, access terms and public/private scope |
| Balochistan public schools | Government of Balochistan School Education Department public education record exposes GIS, school map, open-data links and a dated school-list extract with district coverage | Balochistan; school and district-oriented data | Evidence of a government school inventory and open-data discovery route | Determine exact downloadable dataset, field dictionary, license, refresh cycle and whether private schools are covered |
| Sindh school providers | Sindh Education Management Information System (SEMIS), operated through the Reform Support Unit / School Education & Literacy Department, provides a school search by SEMIS code or name and links to school profile, annual school census and geotagging information | Sindh; searchable by school identity; additional census/geotagging resources advertised | Official starting point for school identity and government school-information coverage | RSU portal currently advertises SEMIS, school profiles, annual school census and geotagging sections. Verify whether search results include public and private schools, data fields, currentness, bulk access, dataset terms and geospatial reuse rights; confirm whether registration/recognition status is represented. Sources: https://rsusindh.gov.pk/ and https://rsusindh.gov.pk/programs/search_bk2.php |
| Islamabad Capital Territory school providers | ICT-PEIRA publishes lists of private educational institutions with active/valid registration and a registered-institutions report showing EMIS number, institution name, address, sector and educational level | ICT; private institutions, record-level register | Official private-school registration source; includes a published update statement and registration status | PEIRA states its active/valid list is updated every weekend pending auto-update and separately lists institutions with renewal applications under process. This is a publication cadence statement, not a per-record timestamp or freshness guarantee. Verify renewal-pending semantics, source-specific terms and private-only scope (up to higher-secondary); public-sector schools need a separate source. Sources: https://peira.gov.pk/ and https://psms.peira.gov.pk/admin/rpt_registered_peis.php?page=1 |
| AJK school providers | AJK Elementary & Secondary Education Department lists registered private educational institutes and maintains school-census/EMIS update information; federal BECS separately publishes a community-school list for AJK | AJK; private institution registration/census portal and a narrower community-school list | Official starting points for private-school and community-school coverage | Verify current downloadable/list records, public-school register, data fields, update cadence, legal reuse terms and whether all districts are covered. Sources: https://ese.gok.pk/ and https://becs.gov.pk/Detail/YTQ4ODBkMTYtNTYzNS00ZmU3LTk0MTAtZTA5ODRjOWM1Mzcx |
| Gilgit-Baltistan school providers | GB Education Management Information System publishes school details with district, tehsil, cluster, school name and level fields | GB; school-level records with district/tehsil/cluster geography | Official school inventory source for GB public education coverage | Verify record freshness, public/private scope, download/API access, terms and whether all districts/levels are represented. Source: https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details |
| Technical and vocational training providers | NAVTTC's production site links to Training Institute Search (TIS), the National Skills Information System (NSIS) and the NVQF Registry; its institute-registration portal describes institute onboarding, while the production accreditation-process page describes NAC-TVS accreditation. NAVTTC's official sector/QAB pages identify provincial TEVTAs and approved QAB categories. Sindh STEVTA, Punjab TEVTA and B-TEVTA publish separate institute-directory routes; Trade Testing Board Punjab publishes affiliation material. | National / provincial; provider, ownership, type, district, trade, QAB/assessment relationship and accreditation validity where published | Supports separate provider registration, institute identity, QAB affiliation, competency assessment/certification, qualification registry and NAC-TVS quality-accreditation concepts. NAVTTC states NAC-TVS accreditation is valid for three years, with renewal application at least six months before expiry and a minimum 700/1000 assessment score. | Verify that each linked production directory is authoritative and accessible for the intended query; do not use NAVTTC staging/test subdomains as evidence of production coverage. Registration is not accreditation; QAB affiliation is not proof that every provider or trade is currently approved. Public registration forms request sensitive institutional/individual documents (including head-of-institute identity evidence); exclude those from discovery research. Verify terms, rights, update dates, public/private scope and status semantics for each agency; do not infer bulk reuse from RTI access routes. Sources: https://navttc.gov.pk/; https://navttc.gov.pk/accreditation-process/; https://reg.navttc.gov.pk/; https://tms.navttc.gov.pk/nsis/institute_help/info; https://tevta.gop.pk/right-to-information/; https://stevta.gos.pk/; https://btevta.gob.pk/ |
| Non-formal, adult and alternative education | Federal Directorate General of Basic Education Community Schools (BECS), under MoFEPT, publishes lists of Basic Education Community Schools and Accelerated Learning Programme centres across ICT, Sindh, AJK and GB; MoFEPT also lists a Non-Formal Education Management Information System (NFEMIS) resource | Multi-jurisdiction but programme-specific; community schools and ALP centres | Official source family for non-formal/community education discovery | BECS is not a complete register of all non-formal/adult providers; verify NFEMIS access, dataset scope, currentness, programme status and reuse terms. Sources: https://becs.gov.pk/ and https://www.mofept.gov.pk/Download |
| Punjab special education providers | Punjab Special Education Department publishes category-specific institute lists, centre directories, devolved-institute lists and contact/location details | Punjab; institute and centre-level, with districts and disability/service categories | Official starting source for special education provider discovery and service-category dimensions | Verify current operating status, complete district coverage, public/private scope, update dates, source terms and privacy handling; public pages include direct contact details that should not be republished without a lawful basis. Sources: https://sed.punjab.gov.pk/institutes and https://sed.punjab.gov.pk/centres |
| Sindh special education providers | Sindh Department of Empowerment of Persons with Disabilities publishes a list of institutions, centres and regional offices | Sindh; institution/centre and regional office-level | Official starting source for special education and vocational rehabilitation provider discovery | Verify completeness, current operation, institution vs office distinctions, public/private scope, update date and reuse terms. Source: https://depd.sindh.gov.pk/institutions/ |
| Special education providers in other jurisdictions | No complete, current multi-jurisdiction public register verified in this pass | KP, Balochistan, ICT, AJK and GB coverage uncertain | Identifies remaining geographic gaps | Locate official provincial/regional special-education department/directorate registers; verify public accessibility, coverage and update frequency |
| Engineering programmes | Pakistan Engineering Council (PEC) publishes accreditation programme levels, accreditation procedures, curricula and related programme information | National; programme-level accreditation, with level/schedule distinctions | Official programme-level accreditation source for engineering education | Verify programme, institution/campus, intake/session, accreditation level, effective dates and current status; distinguish accreditation from institution recognition. Sources: https://www.pec.org.pk/accreditation-new/ and https://www.pec.org.pk/faqs/ |
| Computing degree programmes | National Computing Education Accreditation Council (NCEAC) provides region-wise institution status and explains that accreditation applies to specific degree programmes, not institutions | National; institution and specific computing programme, region-wise | Official computing-programme accreditation source; makes programme-level status distinction explicit | Verify current programme list, accreditation cycle, zero-visit/interim status, campus and intake scope, and update date. Sources: https://nceac.org.pk/ and https://nceac.org.pk/accreditation/NCEAC_Accreditation |
| Teacher education programmes | National Accreditation Council for Teacher Education (NACTE) publishes currently accredited programmes with institute, programme, shift, level, province, validity date and code | National; programme-level, province and institute | Official teacher-education programme accreditation source with visible validity dates | Verify currentness and validity at point of use; understand formal/zero accreditation and programme-specific scope. Sources: https://www.nacte.org.pk/Accreditation/AccreditedPrograms and https://www.nacte.org.pk/Accreditation |
| Homoeopathic medical colleges | National Council for Homoeopathy (NCH) publishes recognised homoeopathic medical colleges and a separate list of degree-awarding institutions/programmes | National; college and degree-awarding programme lists | Official professional education provider source for homoeopathic education | Page formatting and numbering are irregular and may include closed institutions; independently verify current recognition, degree-awarding authority, programme and status before any listing. Source: https://www.nchpakistan.gov.pk/Colleges.html |
| Other professional / specialist providers | Separate councils and accreditation bodies exist by discipline; a consolidated authoritative cross-discipline inventory was not verified | Discipline-specific and jurisdiction-dependent | Supports a modular professional-approval model rather than one generic recognition flag | Continue council-by-council research (including architecture, business education, allied health and other regulated disciplines); verify programme/campus/session scope |

## 3. Research findings for V2 information modelling

1. **Provider, campus and programme are distinct.** HEC maintains separate university/DAI and campus recognition information; professional councils may approve individual programmes at specific institutions.
2. **Recognition is multi-dimensional.** Institutional charter/recognition, campus recognition, programme accreditation, professional council approval, affiliation, examination-board relationship and qualification-awarding authority must not be collapsed into one generic badge.
3. **Status is time-sensitive.** The PCP directory exposes examples such as active, stoppage of admissions and show-cause status; the V2 evidence model must preserve effective dates and last-verified timestamps.
4. **Geographic coverage is uneven but improving.** School-source families have been identified for all provinces and territories, but completeness and public/private scope are not verified. Special-education sources are currently identified for Punjab and Sindh only; other jurisdictions remain gaps.
5. **Professional accreditation is discipline- and programme-specific.** PEC, NCEAC and NACTE describe accreditation at programme level, while NCH publishes recognised college and degree-awarding lists. V2 must not convert programme approval into blanket institution recognition.
6. **Public accessibility is not a reuse license.** A public page, search interface or open-data label does not by itself settle copyright, terms, database rights, privacy, rate limits or permission for bulk reuse.

## 4. Minimum source-evidence fields

For every source and any future dataset, record:

- Source ID, issuing authority, official title and canonical URL
- Institution sector and category covered
- Geographic coverage and record granularity
- Fields exposed and field definitions
- Access method (download, API, search interface, publication or manual verification)
- Publication/update date, observed last-modified date and V2 last-checked date
- Terms of use, license, permission status and evidence of allowed reuse
- Personal-data and sensitive-data risk
- Known omissions, duplicate risks, stale-record risks and status ambiguities
- Verification owner, review interval and escalation/contact route
- Decision: research only / approved for manual verification / approved for ingestion / rejected / pending

Do not populate production data or activate a connector as a result of this research document.

## 5. Relationship to the authoritative S02 task register

The weighted task breakdown and acceptance criteria are governed only by `docs/04-roadmap/MILESTONE_STEP_REGISTER.md`. This matrix records supporting evidence; it is not a second or conflicting task register.

| Register task | Evidence in this matrix | Remaining acceptance gate |
|---|---|---|
| S02-C01 Taxonomy and entity distinctions | Provisional provider taxonomy, inclusion/exclusion boundaries and distinct recognition/affiliation/assessment/awarding relationships | Owner review and approval |
| S02-C02 Higher education and campuses | HEC recognized institution, campus, affiliated-college and adverse/unaccredited source routes; campus page count recorded with caveat | Record-level status, freshness, campus/study-centre distinctions and source rights |
| S02-C03 Professional council sources | HEC council map; PM&DC, PNMC, PCP, PEC, NCEAC, NACTE, NBEAC, NTC and NCH programme/status evidence | Remaining relevant councils and current per-programme/campus/intake status and rights verification |
| S02-C04 School-source jurisdiction coverage | Punjab public/private, KP private, Sindh ASC, Balochistan EMIS, ICT, AJK and GB source leads | Full district coverage, public/private scope, canonical current datasets and source rights across all jurisdictions |
| S02-C05 TVET and awarding relationships | NAVTTC production routes, QAB map, provincial TEVTA leads and registration/affiliation/accreditation distinctions | Complete provincial provider coverage, current QAB/trade scope, freshness and rights |
| S02-C06 Non-formal and special education | BECS/NFEMIS, Balochistan NFE and Punjab/Sindh special-education source leads | Other jurisdictions, current centre/programme status, coverage and privacy/rights review |
| S02-C07 Source rights and access | Expanded source-by-source public-access, status, privacy and freshness observations; no reuse permission established | Applicable terms/licenses, unresolved owner clarifications, permission where needed and owner/legal review |
| S02-C08 National coverage synthesis | Draft synthesis updated with expanded sector and jurisdiction evidence | Final gap reconciliation after C02–C07 and owner review |
| S02-C09 Owner review and step acceptance | Decision-ready taxonomy and gap summary prepared | Explicit owner approval; AI cannot self-approve this gate |

## 6. Sources consulted

- HEC, Recognised Universities and Degree Awarding Institutions: https://www.hec.gov.pk/english/universities/pages/recognised.aspx
- HEC, Recognised Campuses: https://www.hec.gov.pk/english/universities/Pages/DAIs/HEC-recognized-Campuses.aspx
- HEC, Accreditation Section and affiliated-college policy references: https://www.hec.gov.pk/english/universities/Pages/Accreditation.aspx
- PMDC, Recognised Institutions and Qualifications / undergraduate colleges: https://hospitals-inspections.pmdc.pk/Colleges/PublicDentalColleges
- PNMC, Recognised Institutes: https://pnmc.gov.pk/recognized-institutes/
- Pharmacy Council of Pakistan, Institutions Directory: https://www.pcpisb.gov.pk/institutions
- Punjab School Education Department, PEPRIS public register: https://www.pepris.pesrp.edu.pk/parent_corner
- KP Private Schools Regulatory Authority, district register: https://www.psra.gkp.pk/district/get-schools?district_id=1
- Government of Balochistan School Education Department: https://www.sed.gob.pk/
- Government of Balochistan EMIS School Profile Search: https://emis.gob.pk/views/Reports/Reports/SchoolSearchPublic.aspx
- Sindh Reform Support Unit / SEMIS: https://rsusindh.gov.pk/ and https://rsusindh.gov.pk/programs/search_bk2.php
- ICT-PEIRA active registered institutions: https://psms.peira.gov.pk/admin/rpt_registered_peis.php?page=1
- Gilgit-Baltistan EMIS school details: https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details
- AJK Elementary & Secondary Education Department: https://ese.gok.pk/
- Federal BECS AJK community-school list: https://becs.gov.pk/Detail/YTQ4ODBkMTYtNTYzNS00ZmU3LTk0MTAtZTA5ODRjOWM1Mzcx
- Federal Directorate General of BECS and jurisdiction lists: https://becs.gov.pk/
- MoFEPT downloads (including NFEMIS resource): https://www.mofept.gov.pk/Download
- Punjab Special Education Department institute directory: https://sed.punjab.gov.pk/institutes
- Punjab Special Education Department centres: https://sed.punjab.gov.pk/centres
- Sindh Department of Empowerment of Persons with Disabilities institution list: https://depd.sindh.gov.pk/institutions/
- Pakistan Engineering Council accreditation: https://www.pec.org.pk/accreditation-new/ and https://www.pec.org.pk/faqs/
- National Computing Education Accreditation Council: https://nceac.org.pk/ and https://nceac.org.pk/accreditation/NCEAC_Accreditation
- National Accreditation Council for Teacher Education: https://www.nacte.org.pk/Accreditation/AccreditedPrograms and https://www.nacte.org.pk/Accreditation
- National Council for Homoeopathy recognised colleges: https://www.nchpakistan.gov.pk/Colleges.html
- NAVTTC, TVET Sector: https://navttc.gov.pk/tvet-sector/
- NAVTTC, Institute Affiliation: https://navttc.gov.pk/affiliation/
- Skilling Pakistan, Institutes: https://skillingpakistan.gov.pk/institutes

- Punjab PMIU/OpenPunjab public-school search and census: https://openpunjab.pesrp.edu.pk/schools/
- PEPRIS private-school valid e-license register and support: https://pepris.pesrp.edu.pk/parent_corner and https://pepris.pesrp.edu.pk/support
- Sindh Annual School Census profiles: https://rsusindh.gov.pk/asc.php
- NBEAC accredited business schools: https://nbeac.org.pk/index.php/accredited-business-schools
- National Technology Council accreditation process: https://www.ntc-hec.org.pk/accreditation.php
- HEC Accreditation Councils: https://www.hec.gov.pk/english/services/universities/qaa/pages/accreditation-councils.aspx

**Research date:** 2026-11-12. Follow-up research identified additional AJK, non-formal, special-education and professional-programme source families. These are discovery leads, not complete inventories or permission to reuse data. Source interfaces and registers can change; verify each record at the point of any future use.


## 7. TVET provider and awarding-body research (2026-11-12)

### 5.1 Provider and regulator discovery

- NAVTTC's official TVET-sector page identifies provincial authorities, including Punjab TEVTA, Sindh STEVTA, KP TEVTA, Balochistan B-TEVTA, AJK TEVTA and GB TEVTA. The page's headline provider/enrolment figures are not treated as a verified, record-level institution inventory.
- Sindh STEVTA publishes an institute directory with region and district filters and institute-level entries.
- Punjab TEVTA publishes a vocational-institute list; the Trade Testing Board Punjab page separately links to TEVTA and non-TEVTA/private institute lists.
- B-TEVTA operates a government-hosted institutional registration/accreditation portal and public directory. Search results showed inconsistent aggregate counts across portal pages (for example, directory counts and landing-page totals differ); do not use these aggregate counts as a national or provincial baseline until reconciled with the authority.
- Skilling Pakistan remains a discovery/data-context source; verify the source owner, dataset date, coverage and terms before relying on it.

### 5.2 Qualification-awarding and assessment relationships

NAVTTC's official affiliation page identifies approved Qualification Awarding Bodies, including provincial technical boards and trade-testing bodies. The page names PBTE, SBTE, KP-BT&CE, TTB Punjab, TTB Sindh, TTB KPK, TTB Balochistan, AJK technical education/board bodies, NAVTTC direct assessment, PVTC and other bodies. The official list must be checked at the time of any future record verification; do not assume the set is static. The Trade Testing Board Punjab describes institutional affiliation as a formal relationship for trainee assessment and certification and links to separate lists of TEVTA and non-TEVTA/private institutes.

**V2 modelling implication:** A training provider's registration, its affiliation to a QAB, the QAB's authority to assess/certify a trade, and any separate quality accreditation are different claims. Record each relationship with scope, trade/qualification, jurisdiction, effective date and evidence. Never infer that a provider is nationally accredited merely because it appears in a QAB list, or that all programmes offered by a provider are covered by one affiliation.

### 5.3 Source links

- NAVTTC TVET sector: https://navttc.gov.pk/tvet-sector/
- NAVTTC institute affiliation and QAB list: https://navttc.gov.pk/affiliation/
- Sindh STEVTA institute directory: https://stevta.gos.pk/institutes.aspx
- Punjab TEVTA vocational institutes: https://tevta.gop.pk/list-of-vocational-institutes/
- Trade Testing Board Punjab institutional affiliation: https://ttbp.edu.pk/institutional-affiliation/
- B-TEVTA public directory: https://registration.btevta.gob.pk/portal/directory
- Balochistan skills provider discovery: https://bsis.btevta.gob.pk/institute-list

## 8. Selected source-term and freshness clarifications (2026-11-12)

- **KP-PSRA:** The KP E&SE Department describes PSRA's statutory/administrative role in registration, regulation and supervision of private schools; the current public portal is a source-discovery route. No directory-specific reuse terms or bulk-access permission were located in the dated review. Public accessibility is not permission.
- **ICT-PEIRA:** The official site states that the active/valid private-institution list is updated every weekend pending auto-update, and distinguishes institutions whose renewal applications are under process. This cadence is not a per-record timestamp or a guarantee of record freshness. Preserve the distinct status if any later authorized use occurs.
- **Sindh RSU/SEMIS:** The official RSU portal advertises SEMIS, school profiles, annual school census and geotagging sections. These navigation entries do not prove public/private completeness, dataset-level license, bulk export rights or geospatial reuse permission.
- **PBS policy boundary:** PBS's data dissemination policy is relevant only to PBS-produced statistical products within the policy's scope and tier. It is not a blanket license for provincial EMIS or regulator directories.

All source families remain research-only pending source-specific rights, privacy, freshness and owner review.


## 9. Expanded official-source verification — 2026-11-12

The following observations are based on official regulator/government pages surfaced in the current independent desk review. They improve source-family coverage but do not certify every listed institution or programme. Directory records must be rechecked at the point of any future authorized use.

### 7.1 Higher education and professional programme authorities

- **HEC institutional recognition and campus scope:** HEC maintains separate recognised university/DAI, recognised campus, affiliated-college, unaccredited and fake/illegal/unrecognised institution routes. Its current campus page reports a combined 151 listed public/private campuses (96 public and 55 private); this is the page's displayed count, not an independently reconciled national campus census. HEC's affiliation policy page says the 2024 policy applies to public-sector universities/DAIs only; do not generalize it to private affiliations. Sources: https://www.hec.gov.pk/english/universities/Pages/DAIs/HEC-recognized-Campuses.aspx and https://www.hec.gov.pk/english/universities/Pages/Accreditation.aspx.
- **HEC-recognized accreditation/professional bodies:** HEC's Accreditation Councils page names PBC, PCATP, PMDC, PEC, PNMC (shown in some older HEC material as PNC), PCP, PVMC, NCH, NCT and Allied Health Professionals Council, and HEC-established NACTE, NAEAC, NCEAC, NBEAC and NTC. This is a discovery map, not a statement that all councils regulate identical provider types or publish a complete public directory. Source: https://www.hec.gov.pk/english/services/universities/qaa/pages/accreditation-councils.aspx.
- **PM&DC:** Its official undergraduate college portal publishes separate public/private medical and dental college tables with province, city and seat allocation. These are institution/programme-specific facts; verify session, campus, allowed intake and current recognition separately. Source: https://hospitals-inspections.pmdc.pk/Colleges/PublicDentalColleges.
- **PNMC:** The recognized-institutes page contains institution, province, city, public/private ownership and programme columns, plus programme abbreviations and a correction contact. The search result is timestamped as an older page (about four years); visible records include legacy/closed programme labels and irregular formatting. Treat it as a candidate register requiring record-level freshness confirmation, not a live current approval assertion. Exclude individual nurse registration data and do not republish personal direct-contact details. Source: https://pnmc.gov.pk/recognized-institutes/.
- **Pharmacy Council of Pakistan:** The official Pharm-D recognized-institutions route shows institution, province, city, morning/evening seats, programme and status, including Active and Stoppage of Admissions. The broader All Institutions route also includes technician qualifications. Search output showed apparent geography/record anomalies (for example, an institution name/address context that did not align cleanly with the displayed province); resolve source records with the council before treating them as verified. Source: https://www.pcpisb.gov.pk/institutions?type=Recognized and https://pcpisb.gov.pk/institutions.
- **PEC:** The accreditation section exposes Level-I and Level-II programme lists, allowed intake information, engineering curricula and policy material. PEC's FAQ explains that programme accreditation is a peer-review assessment and distinguishes First Schedule Level-I/II and Second Schedule foreign qualifications. Preserve programme, campus, intake and accreditation level; do not infer whole-university accreditation. Sources: https://www.pec.org.pk/accreditation-new/ and https://www.pec.org.pk/faqs/.
- **NCEAC:** The council explicitly states computing accreditation is for specific degree programmes, not institutions, and distinguishes accreditation from certification. It describes zero visits for new programmes and accreditation visits for graduating batches; intake change can require a change-of-scope visit. This is a strong reason to model programme/batch/intake scope separately. Source: https://nceac.org.pk/accreditation/NCEAC_Accreditation.
- **NACTE:** Its public accredited-programmes table exposes institute, programme, shift, level, province, programme code and valid-until date, and currently describes 113 accredited programmes. Treat each programme/shift/validity record as separate evidence; recheck dates and status. Source: https://www.nacte.org.pk/Accreditation/AccreditedPrograms.
- **NBEAC:** Its accredited-business-schools table exposes institute, department, programmes, session, sector, chartered region and status. The visible categories include accredited, reaccreditation, under process and expired. Do not flatten these into a binary institutional recognition field; retain the exact programme/session and accreditation category. Source: https://nbeac.org.pk/index.php/accredited-business-schools.
- **NTC:** The National Technology Council describes programme-level accreditation criteria for technology-related degree programmes and a process with an application lead time of at least six months before a new programme or re-accreditation. The current public page is process-focused; a complete current institution/programme directory and source reuse terms remain to be verified. Source: https://www.ntc-hec.org.pk/accreditation.php.
- **NCH:** The public recognized homoeopathic-colleges page includes college names and addresses, direct principal names/telephone numbers, irregular numbering and explicit closed-college entries; it separately lists degree-awarding institutions. This is not a clean current structured register. Verify active status and legal authority with NCH; exclude personal principal contact data from V2 discovery. Source: https://www.nchpakistan.gov.pk/Colleges.html.

### 7.2 School education — stronger jurisdiction evidence

- **Punjab public schools:** PMIU/OpenPunjab describes a public-school data service as free, open and real-time, searchable by EMIS code, and displays School Census 2024–2025 totals. This is a stronger public-sector discovery route than PEPRIS, which is a separate private-school registration system. Confirm the precise open-data license, allowed reuse, data fields and update semantics before any use. Sources: https://openpunjab.pesrp.edu.pk/schools/ and https://www.pepris.pesrp.edu.pk/parent_corner.
- **Punjab private schools:** PEPRIS parent-corner publishes a list of private schools with valid e-licenses and fields including level, gender, registration number, validity, district, tehsil and address. PEPRIS support states an e-license validity period of one year (1 January to 31 December) and describes the renewal process. The provider-registration portal requests owner CNIC and mobile details; those fields are not necessary for public institution discovery and must not be collected. Sources: https://pepris.pesrp.edu.pk/parent_corner and https://pepris.pesrp.edu.pk/support.
- **Khyber Pakhtunkhwa private schools:** KPPSRA's district register exposes school name, level, registration number and status, with observed values including ACTIVE, BLOCKED and DORMANT. District-specific endpoints exist; sample pages show the need to test district coverage and pagination/record completeness rather than assuming one page is exhaustive. Public schools require a separate EMIS/department source. Sources: https://www.psra.gkp.pk/registers and https://www.psra.gkp.pk/district/get-schools?district_id=1.
- **Sindh public-school census:** RSU's Annual School Census page publishes profiles through 2024–25 and explains that ASC and school profiling data inform education decisions. This provides dated annual-census evidence, but not a blanket assertion that the SEMIS search covers every public/private institution or that underlying data may be reused. Source: https://rsusindh.gov.pk/asc.php.
- **Balochistan:** Government EMIS exposes a public School Profile Search with BEMIS code, district, tehsil, level, gender, legal status and school status filters; the department portal also exposes separate Private Schools and NFE areas. Keep public, private and NFE sub-registers distinct and verify the exact export/license and record date. Sources: https://emis.gob.pk/views/Reports/Reports/SchoolSearchPublic.aspx and https://emis.gob.pk/.
- **AJK and Gilgit-Baltistan:** Existing AJK E&SE and GB EMIS leads remain identified, but this review did not establish complete current public/private coverage, an authoritative downloadable inventory or dataset reuse permission. Do not infer absence of schools from missing public records.
- **ICT:** PEIRA's active/valid private-school list and renewal-under-process category remain separate regulatory states; its weekly publication statement is not a per-record timestamp. Public-sector ICT schools need a distinct FDE/EMIS source.

### 7.3 Non-formal and special education

- **Balochistan NFE:** The Balochistan EMIS portal exposes a distinct NFE navigation area. It is a discovery lead, not yet a verified, current NFE centre register. Confirm dataset owner, fields, geography, active status and update cycle.
- **Punjab special education:** The department's institute page lists separate institution categories (visual, intellectual, hearing and physical disability service groups) and describes the number and type of institutes. Treat these as institution/service categories, not data about an individual child; verify the underlying directory and current centre status. Source: https://sed.punjab.gov.pk/institutes.
- **Sindh special education:** The existing DEPD institution list remains a source lead. Distinguish service centres from administrative offices and avoid staff personal contacts. Other provincial/territorial special-education sources remain an open coverage gap.
- **BECS/NFEMIS:** Federal BECS community-school lists and MoFEPT NFEMIS resource leads remain separate from provincial public-school EMIS and from private-school registration. Verify current programme status, dataset date and coverage before treating them as an active provider inventory.

### 7.5 Additional professional councils — law and veterinary education

- **Pakistan Bar Council (PBC):** The official Legal Education pages publish recognized affiliated-college lists grouped by affiliating university, with college location, affiliation, recognition date and annual fee-status fields; a separate recognized-universities page is also published. This is an affiliation/recognition register for legal education, not a general university directory. Annual fee status is not the same as programme accreditation or current admission availability. Verify exact college/programme and the applicable legal education rules. Sources: https://www.pakistanbarcouncil.org/legal-education/affiliated_colleges and https://www.pakistanbarcouncil.org/legal-education/pakistani_universities.
- **Pakistan Veterinary Medical Council (PVMC):** Its official site publishes an Accredited/Recognized Institutions page with institution, accredited programme and accreditation-period information. The visible table also includes named staff contacts and direct phone/email details; V2 should retain institution/programme evidence only and exclude personal contacts. Some programme-period entries are historical (for example, programmes merged into DVM in 2000), so current scope must be checked with PVMC before presenting current recognition. Sources: https://www.pvmc.gov.pk/ and https://www.pvmc.gov.pk/Detail/Y2I2YzBjMDItNTRiZS00NzE0LThhODYtMmQyM2U2ZWNkN2U0.
- **Remaining HEC-listed councils:** HEC's accreditation-council page also identifies PCATP, NCT, NAEAC and Allied Health Professionals Council. Their existence is confirmed as source-family leads, but this review has not established a current, complete public institution/programme register and source-specific reuse terms for each. Keep these as explicit verification gaps rather than inventing a directory or assuming HEC recognition alone resolves professional approval.

### 7.4 TVET production-route caution

NAVTTC's current production home page describes institute registration, affiliation to NAVTTC-approved QABs and NAC-TVS quality accreditation as three separate stages. Its public pages link Training Institute Search (TIS), NSIS and the NVQF Registry. A staging/test subdomain exposes a purported accreditation directory with a “representative sample data” disclaimer and conflicting regional labels; it is expressly excluded as authoritative evidence. B-TEVTA's government-hosted public registry is a useful source lead, but displayed totals and district claims require reconciliation. Sources: https://navttc.gov.pk/; https://navttc.gov.pk/tvet-sector/; https://tms.navttc.gov.pk/nsis/institute_help/info; https://registration.btevta.gob.pk/portal/directory.

## 10. S02 task alignment and current evidence

The authoritative weighted task breakdown is in `MILESTONE_STEP_REGISTER.md`. The earlier exploratory gap list in this matrix is not a second task register. Current status:

| Register task | Evidence added in this review | Remaining acceptance gate |
|---|---|---|
| S02-C01 Taxonomy and entity distinctions | Expanded provisional taxonomy and separate provider/campus/programme/authority/affiliation/assessment/awarding relationships | Explicit owner review/approval |
| S02-C02 Higher education and campuses | HEC separate recognised institutions, campuses, affiliated colleges, unaccredited and illegal/unrecognised routes; current campus-page count recorded with caveat | Record-level status/freshness and complete source/rights assessment |
| S02-C03 Professional councils | HEC accreditation-council map; PM&DC, PNMC, PCP, PEC, NCEAC, NACTE, NBEAC, NTC and NCH evidence; status granularity and stale/anomalous records noted | Remaining discipline councils, current per-programme status and source rights/freshness review |
| S02-C04 School jurisdictions | Punjab public OpenPunjab + private PEPRIS, KPPSRA district register, Sindh ASC 2024–25, Balochistan EMIS public search/private/NFE, plus existing ICT/AJK/GB leads | Verify full district coverage, public/private scope and source rights/freshness in all jurisdictions |
| S02-C05 TVET | NAVTTC TIS/NSIS/NVQF and registration/affiliation/accreditation separation; provincial authority and QAB map; B-TEVTA registry caution | Current provincial directory coverage, QAB scope, status/freshness and rights |
| S02-C06 Non-formal and special education | Balochistan NFE portal lead, BECS/NFEMIS, Punjab special institutes and Sindh DEPD | Full jurisdiction/source inventory, programme/centre status and privacy/rights review |
| S02-C07 Source rights and access | Expanded source-specific access, field, privacy, freshness and terms findings; no permission requests sent | Complete applicable terms/license assessment, unresolved source-owner clarifications, and owner/legal decision |
| S02-C08 National coverage synthesis | Updated synthesis cross-referenced to this evidence | Incorporate final verification and unresolved gaps after C02–C07 close |
| S02-C09 Owner review and acceptance | Prepared decision-ready recommendation and unresolved-gaps list | Owner's explicit approval; AI cannot self-approve this gate |

**Research boundary:** All candidate sources remain RESEARCH ONLY. This review did not scrape, download, bulk-query, register, contact source owners, activate connectors, or collect records. Search-engine-rendered public page evidence is used only to document discovery and observed page semantics.


## 6. Supplemental official-source review — 2026-11-12

The supplemental review is recorded in [M1-S02 Supplemental Official-Source Coverage Review](M1_S02_SUPPLEMENTAL_SOURCE_COVERAGE_REVIEW_2026-11-12.md). Key changes to the evidence position:

- AJK E&SE now advertises a dated registered-private-institution list (2025-11-05) and private-institution census guidance for 2024–25. This improves the private-school lead but does not prove public-school coverage, record freshness or reuse rights. Sources: https://ese.gok.pk/ and https://www.ese.gok.pk/news-and-notifications.
- Balochistan EMIS exposes BEMIS code, legal status, school status, district, tehsil, level and gender filters, plus separate Private Schools and NFE routes. Completeness and permitted access remain unverified. Sources: https://www.emis.gob.pk/views/Reports/Reports/SchoolSearchPublic.aspx and https://emis.gob.pk/.
- NFEMIS publishes a national NFE dashboard and dated inventory. Dashboard school total (20,862) differs by two from the 20,864 sum of the 2026-09-21 inventory categories. Treat both as dashboard-reported and reconcile before using totals. Sources: https://www.nfemis.net/Dashboard.aspx and https://www.nfemis.net/.
- GB EMIS currently displays zero-valued school/staff/student summary metrics; do not use these as coverage counts. Sources: https://emis2.gilgitbaltistan.gov.pk/ and https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details.
- HEC PQR and the HEC allied-health NOC list add qualification-level and programme/NOC evidence layers. They must remain distinct from institution-wide recognition. Sources: https://www.hec.gov.pk/english/services/universities/pqr/Pages/default.aspx and https://www.hec.gov.pk/english/universities/Pages/DAIs/NOC-AHS.aspx.
- KP special-education parliamentary material is historical (2020–21) and is not accepted as a current register; current multi-jurisdiction coverage remains unverified. Source: https://www.pakp.gov.pk/wp-content/uploads/2024/04/14398.pdf.

These findings strengthen discovery but do not close S02-C04/C06/C08 or change the research-only source-use boundary.

## 7. Professional-council and special-education supplement — 2026-11-12

A second supplement is recorded in [M1-S02 Supplemental Professional-Council and Special-Education Review](M1_S02_SUPPLEMENTAL_PROFESSIONAL_COUNCIL_SPECIAL_EDUCATION_REVIEW_2026-11-12.md). PCATP's 2025 annual report distinguishes accredited, pending NOC, on-hold, revoked and closed architecture programmes and reports all five listed town-planning programmes accredited; its separate September 2025 NOC-application PDF is not proof of approval. NCT publishes separate FTJ and BEMS recognition pages; the FTJ page contains a disputed entry and personal contact data. AHPC's public PDF is a list of institutions that applied for recognition/accreditation, not proof of granted recognition. NTC publishes zero/interim programme and accreditation-visit/intake-batch routes; neither a zero/interim phase nor a visit alone proves final accreditation. NAEAC remains an identified HEC council with no complete current public register verified in this pass.

For special education, the Ministry of Human Rights confirms DGSE's ICT-level mandate, but the reviewed page is not a current institution register. KP evidence remains historical (2020–21); current complete registers for Balochistan, AJK and GB remain unverified. Personal staff/principal contact data and student/health/disability-level data remain excluded. All sources remain research-only; no reuse permission is established.

## 8. Deep jurisdiction, special-education and TVET review — 2026-11-12

The dedicated [deep jurisdiction, special-education and TVET review](M1_S02_DEEP_JURISDICTION_SPECIAL_ED_TVET_REVIEW_2026-11-12.md) adds several important source-family findings:

- Punjab Special Education publishes category counts (including 172 centres) and a district centre list; categories may overlap and must not be summed. Its detailed list exposes personal head mobile numbers, which are excluded from V2 attributes.
- Sindh DEPD publishes a regional centre/institution list, but it includes personal staff names and mobile contacts and requires province-wide completeness/freshness checks.
- GB Special Education describes complexes in Gilgit/Skardu and centres in Ghizer/Diamer, while event/news references Chilas and Gahkuch. This internal scope/location discrepancy requires a reconciled current facility register.
- Balochistan's 2026 PDWP notice concerns proposed complexes at Turbat and Zhob, not proof of operational institutions. A historical PIE publication is not a current directory.
- KP-TEVTA reports 33 institutes and distinguishes GCT, GPI, GTVC and employment exchange categories. STEVTA provides region/district filters. Punjab TEVTA's surfaced institute PDF is dated 2024. B-TEVTA's public directory shows 16 while NAVTTC's sector page states 80+; scope must be reconciled.
- NAVTTC's surfaced NAC-TVS directory is on a staging subdomain and explicitly representative sample data; it is excluded from evidence/counts.
- HEC Digital Library and PASTIC institution databases are secondary discovery sources, not recognition registers or a national census.

These findings strengthen S02-C04/C05/C06 but do not establish full jurisdiction completeness, current record-level status or reuse rights.

## 9. ICT PEIRA, Deeni Madaris and IBCC QAB evidence — 2026-11-12

The new [ICT PEIRA, Madaris and QAB review](M1_S02_ICT_PEIRA_MADARIS_QAB_REVIEW_2026-11-12.md) establishes PEIRA as the statutory ICT private-education regulator up to higher-secondary/equivalent level, with a paginated register and separate active, renewal-in-process, renewal-awaited and unregistered states. Its records are PEI-submitted and carry a discrepancy disclaimer. DGRE identifies a nationwide Deeni Madaris registration mandate and 16 regional offices; surfaced regional lists are dated 26 March 2024 and therefore require freshness verification. IBCC lists recognized QABs and Deeni Madaris/wafaqs but explicitly distinguishes QAB recognition from qualification equivalence. Deeni Madaris should be represented as a distinct provider family; DGRE registration, awarding-body recognition and credential equivalence remain separate relationships. Exclude the maslak/sect field from general institution discovery. These findings strengthen S02-C01/C04/C05/C07 but do not resolve current nationwide madaris register freshness or reuse rights.

## 10. Examination-board and PMF/DGRE jurisdiction review — 2026-11-12

The [examination boards, PMF and DGRE jurisdiction review](M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md) adds IBCC's forum-member roster (BISE, technical and other boards), Punjab's nine BISE network, Punjab Medical Faculty's separate public/private affiliated-institute lists, and DGRE's regional jurisdiction/district map. DGRE regional Madaris pages are located for Islamabad, Sindh, KP, Balochistan, AJK and GB, all surfaced with a 26 March 2024 date; record anomalies include cross-province district/address text and incomplete rows. These records require current freshness and record-level verification. Board membership is not proof of a provider's affiliation; examination-board jurisdiction is not institutional accreditation or ownership.