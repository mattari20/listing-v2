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
| Technical and vocational training providers | NAVTTC TVET-sector page identifies provincial TEVTAs; NAVTTC affiliation page lists approved Qualification Awarding Bodies (QABs); Sindh STEVTA publishes an institute directory; Punjab TEVTA publishes vocational-institute lists; B-TEVTA has a public institutional registration/accredited-directory portal; Skilling Pakistan and Balochistan skills information system provide additional discovery routes | National / provincial; institute, ownership, type, district, trade and QAB relationship where published | Supports a distinct model for training provider, campus, affiliating authority, QAB, assessment body, accreditation status and qualification | Verify each province's current directory and legal authority; QAB list and provider accreditation are not interchangeable; do not treat staging NAVTTC portals or inconsistent B-TEVTA portal totals as authoritative without confirmation; verify source rights, refresh dates and public/private coverage |
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

## 5. Priority research gaps and next tasks

| Task | Required output | Acceptance evidence | Status |
|---|---|---|---|
| S02-C01 | Verify HEC university, campus and affiliated-college source scope | Dated source notes, relationship model and source limitations | In progress |
| S02-C02 | Verify PMDC, PNMC and PCP programme-level status semantics | Dated source notes; distinguish institution, programme, campus, session and status | In progress |
| S02-C03 | Complete school-source discovery for Sindh, ICT, AJK and GB | Official source URLs or documented unsuccessful verification attempts and escalation paths | Not started |
| S02-C04 | Expand provincial school-source coverage beyond Punjab, KP and Balochistan | Public/private scope and district-level coverage matrix | In progress |
| S02-C05 | Expand TVET provider and awarding-body source register | NAVTTC, provincial TEVTAs, boards and QAB relationship map | In progress |
| S02-C06 | Research non-formal, adult-learning and special-education source families | Official register/source inventory and inclusion gaps | Not started |
| S02-C07 | Research remaining professional councils by discipline | Council register, approval granularity and status semantics | Not started |
| S02-C08 | Verify rights, terms, update cadence and access for each shortlisted source | Completed source-evidence records; no ingestion without a rights decision | Not started |
| S02-C09 | Synthesize national coverage and unresolved gaps | Reviewed coverage matrix and M1-S02 acceptance recommendation | Not started |

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

**Research date:** 2026-11-12. Follow-up research identified additional AJK, non-formal, special-education and professional-programme source families. These are discovery leads, not complete inventories or permission to reuse data. Source interfaces and registers can change; verify each record at the point of any future use.


## 5. TVET provider and awarding-body research (2026-11-12)

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

## 6. Selected source-term and freshness clarifications (2026-11-12)

- **KP-PSRA:** The KP E&SE Department describes PSRA's statutory/administrative role in registration, regulation and supervision of private schools; the current public portal is a source-discovery route. No directory-specific reuse terms or bulk-access permission were located in the dated review. Public accessibility is not permission.
- **ICT-PEIRA:** The official site states that the active/valid private-institution list is updated every weekend pending auto-update, and distinguishes institutions whose renewal applications are under process. This cadence is not a per-record timestamp or a guarantee of record freshness. Preserve the distinct status if any later authorized use occurs.
- **Sindh RSU/SEMIS:** The official RSU portal advertises SEMIS, school profiles, annual school census and geotagging sections. These navigation entries do not prove public/private completeness, dataset-level license, bulk export rights or geospatial reuse permission.
- **PBS policy boundary:** PBS's data dissemination policy is relevant only to PBS-produced statistical products within the policy's scope and tier. It is not a blanket license for provincial EMIS or regulator directories.

All source families remain research-only pending source-specific rights, privacy, freshness and owner review.
