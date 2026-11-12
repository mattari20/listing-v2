# M1-S02 — Official Institution Source Coverage Matrix

**Status:** Independent source-discovery and coverage baseline; not a complete national inventory and not an approval to collect or republish source data.  
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
| Sindh school providers | No sufficiently verified, current public official school register was established in this research pass | Sindh; coverage not yet established | Explicit gap for balanced national coverage | Identify and verify the relevant School Education & Literacy Department / Directorate / regulator register and distinguish public from private schools |
| Islamabad Capital Territory school providers | No current source-level school register verified in this pass | ICT; coverage not yet established | Coverage gap | Identify federal/ICT authority sources and determine whether PEIRA records are publicly searchable and current |
| AJK and Gilgit-Baltistan school providers | No complete current official public register verified in this pass | AJK / GB; coverage not yet established | Coverage gap | Identify relevant education department and regulator sources; do not infer national completeness from federal sources |
| Technical and vocational training providers | NAVTTC TVET sector and affiliation material describes federal/provincial authorities, TEVTAs, technical boards, trade testing bodies and qualification-awarding bodies; Skilling Pakistan provides an institute inventory with ownership, type and district fields | National / provincial; institute, ownership, type and district | Helps separate training provider, affiliating/awarding body, assessment body and qualification | Skilling Pakistan is a discovery source, not automatic permission to republish; verify current authority registers, provincial TEVTA data, provider status and source rights |
| Non-formal, adult and alternative education | No sufficiently complete, current national official provider directory verified in this pass | National / provincial coverage uncertain | Identifies a likely inclusion gap for later research | Research provincial non-formal education departments, adult literacy programmes and community-provider registers; establish inclusion criteria first |
| Special education providers | No complete, current multi-jurisdiction public register verified in this pass | Provincial / regional coverage uncertain | Identifies a likely inclusion gap | Locate official provincial special-education department/directorate registers and determine public accessibility and update frequency |
| Professional / specialist providers beyond medicine, nursing and pharmacy | Separate councils and accreditation bodies exist by discipline; a consolidated authoritative cross-discipline inventory was not verified | Discipline-specific and jurisdiction-dependent | Supports a modular professional-approval model rather than one generic recognition flag | Research each relevant statutory council separately (for example engineering, architecture, teacher education and other regulated disciplines); verify programme/campus/session scope |

## 3. Research findings for V2 information modelling

1. **Provider, campus and programme are distinct.** HEC maintains separate university/DAI and campus recognition information; professional councils may approve individual programmes at specific institutions.
2. **Recognition is multi-dimensional.** Institutional charter/recognition, campus recognition, programme accreditation, professional council approval, affiliation, examination-board relationship and qualification-awarding authority must not be collapsed into one generic badge.
3. **Status is time-sensitive.** The PCP directory exposes examples such as active, stoppage of admissions and show-cause status; the V2 evidence model must preserve effective dates and last-verified timestamps.
4. **Geographic coverage is uneven.** Punjab, KP and Balochistan school sources were identified in this pass; Sindh, ICT, AJK and GB require additional verified source discovery. This is a research gap, not evidence that registers do not exist.
5. **Public accessibility is not a reuse license.** A public page, search interface or open-data label does not by itself settle copyright, terms, database rights, privacy, rate limits or permission for bulk reuse.

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
- NAVTTC, TVET Sector: https://navttc.gov.pk/tvet-sector/
- NAVTTC, Institute Affiliation: https://navttc.gov.pk/affiliation/
- Skilling Pakistan, Institutes: https://skillingpakistan.gov.pk/institutes

**Research date:** 2026-11-12. Source interfaces and registers can change; verify each record at the point of any future use.
