# M1-S02 — AJK, Gilgit-Baltistan and Sindh School Register Deep Review

**Review date:** 2026-11-12  
**Scope:** Official public-source desk research only. No scraping, bulk downloads, personal-data collection, external contacts, permission requests or implementation.  
**Status:** Research-only; no source reuse or S02 acceptance is implied.

## 1. Azad Jammu & Kashmir — separate public and private school census streams

AJK E&SE currently displays aggregate dashboard indicators of 6,019 total schools, 31,795 teachers and 506,851 enrolled students. Its official News & Notifications page lists:
- a registered private educational institutions list dated 5 November 2025;
- first-ever private-sector institution census guidance dated 21 September 2024;
- public-sector school census guidance dated 21 September 2024; and
- a 2026 Education Package notification.

This materially improves AJK school source evidence: private and public sectors have separate census streams, and the private list is more recent than the census guidance. However, the dashboard aggregate is not a record-level reconciled school census, the public-sector 2024–25 census guidance is not a current list, and the private registered list requires district/tehsil coverage, current registration status and duplicate/branch review. Do not infer that all 6,019 schools are active, public/private-complete or reusable.

Sources:
- https://ese.gok.pk/
- https://www.ese.gok.pk/news-and-notifications

## 2. Gilgit-Baltistan — EMIS school details and BECS community-school register

### GB EMIS school details
The GB EMIS school-details page exposes a record table with district, tehsil, cluster, school name/code and level. The retrieved rows include primary, middle, high and higher-secondary schools, but also administrative offices and directorates marked with level "Office". Therefore, any later use must filter school records from administrative offices and validate whether the displayed table is complete, current and limited to public-sector schools. The earlier GB EMIS summary dashboard's zero-valued aggregates remain a warning; the details route is a more useful record-level lead but does not by itself validate totals.

Source:
- https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details

### BECS community schools
The federal Directorate General of Basic Education Community Schools publishes a GB-specific list showing **776 schools, updated June 2025**, with school code, teacher name, district, address, tehsil/UC, establishment date and GPS. This is a valuable distinct community-school provider family, not a substitute for the GB government-school EMIS register or private-school regulator data. Teacher names are personal/staff data and are excluded from V2 institution attributes. The count and list require current freshness and duplicate/location validation before use.

Source:
- https://www.becs.gov.pk/Detail/MWIxN2E2NzMtZTZlMS00NzcyLThhZmMtOWRmMjgwZDMwNDBk

### GB public colleges
The Directorate of Education Colleges GB publishes a list of public-sector government colleges with institution names and official institutional email addresses. This provides a separate higher-secondary/college-level government source family. It does not establish private-college coverage or HEC/professional programme recognition.

Source:
- https://doecgb.gov.pk/institutions

## 3. Sindh — school checker and institution-level filters

Sindh School Education & Literacy Department's institution checker provides region, district, tehsil, UC, status, level, gender, ADP, type, adopter, shift, location, SEMIS ID/DDO code/institution-name filters. Its instructions state that institutions can be searched at regional, district, tehsil and UC level and that records are continually being updated; it asks users to report discrepancies through the department's proper channel.

This is a stronger operational school-register lead than an annual census alone. However, the visible checker requires interactive search; this review did not establish a complete exported record set, publication timestamp, exact public/private scope or reuse license. The checker includes monitoring/admin-related dimensions, which should not be mistaken for institution recognition. Preserve SEMIS ID as a source identifier only after source terms and data quality are reviewed.

Source:
- https://checker.sindheducation.gov.pk/ListInstitution.aspx

## 4. Punjab — PEPRIS access and public-school census context

Punjab PEPRIS parent-corner page lists valid e-licensed private schools with school name, level, gender, registration number, license-valid-until date, district, tehsil and address. Its support page says a parent-facing search flow may ask for CNIC or registered mobile number, and schools registered with a District Education Authority may be missing from the PEPRIS public view until data is uploaded. Therefore, PEPRIS is a current valid-eLicense source lead but not necessarily a complete record of every private school or a complete historic registration register. Do not collect CNIC/mobile identifiers or use a personal-identity search flow for V2 discovery.

Punjab public-school pages expose school-census and proactive-disclosure navigation, while OpenPunjab/PMIU public-school data remains a separate source family. Public-school source completeness and exact license terms must be verified independently.

Sources:
- https://www.pepris.pesrp.edu.pk/parent_corner
- https://www.pepris.pesrp.edu.pk/support
- https://schools.punjab.gov.pk/schools
- https://schools.punjab.gov.pk/pro-active-disclosure
- https://openpunjab.pesrp.edu.pk/schools/

## 5. Coverage implications and quality controls

- AJK: distinct public/private census guidance and a dated private register are now confirmed; public record-level list and complete current status remain unverified.
- GB: separate government-school EMIS details, BECS community-school list and public college list exist; EMIS includes administrative offices in the same details table, and the earlier dashboard aggregate is zero-valued. Private-school coverage remains unverified.
- Sindh: institution checker supports district-to-UC filters and rich status/type dimensions; a full current export and terms remain unverified.
- Punjab: PEPRIS valid eLicense records may omit DEA-registered schools not yet uploaded; CNIC/mobile search paths are excluded from V2 discovery.
- Do not combine public EMIS, private regulators, community schools, non-formal centres and colleges into a single undifferentiated "school" count.
- Do not collect teacher names, personal mobile numbers, CNICs, student profiles or student/health records.
- Public access is not a reuse license. No source-specific license or written permission was established.

## 6. Effect on M1-S02

- **S02-C04:** materially strengthened AJK public/private source mapping, GB government/BECS/college sources, Sindh checker and Punjab PEPRIS completeness caveats.
- **S02-C06:** BECS community schools remain distinct from government formal schools and NFEMIS non-formal centres.
- **S02-C07:** source rights and privacy cautions are explicit; no reuse permission established.
- **S02-C08:** national synthesis must distinguish jurisdiction, provider family and data-system type, and must not sum unlike datasets.
- **S02-C09:** remains owner-only; no acceptance is inferred.

All candidate sources remain RESEARCH ONLY.


## 7. Sindh private-school registration — separate regulator and data system

Sindh School Education & Literacy Department publishes a 12 September 2023 registration-criteria notification for private schools under the Sindh Private Educational Institutions (Regulation & Control) Ordinance, 2001 (as amended 2003). A separate procurement/terms-of-reference document describes the Directorate of Inspection and Registration of Private Institutions Sindh (DIRPIS) and a private-school census/management information system (SPEI-EMIS). The document explicitly notes that registered and unregistered private institutions both exist and that the private-school dataset needed updating. This is important: Sindh's public-school institution checker is not sufficient for private-school coverage, and private-school registration/census must be treated as a separate source family. The retrieved TOR is older and is not evidence of a current complete register or current reuse rights.

Sources:
- https://www.sindheducation.gov.pk/Contents/Notifications/86125%20Criteria%20for%20Registration%20of%20Private%20Schools.PDF
- https://www.sindheducation.gov.pk/Contents/Notifications/Bidding%20Documents%20for%20Procurement%20of%20Non-Consultant%20Services.pdf
- https://www.sindheducation.gov.pk/notifications?id=0&key=Private+institutions&pageNumber=1

## 8. KP private-school registration statuses — explicit state model

KPPSRA's district register returns institution name, level, registration number and status. Current visible examples include **ACTIVE**, **BLOCKED**, **DORMANT** and **CLOSED**. These are distinct provider-registration states and must be preserved verbatim with source date and district scope; a blocked/dormant/closed school must not be presented as currently active. The directory is district-driven, so province-wide completeness requires checking all district selections and any pagination/omitted districts; a single district endpoint is not a national or provincial census. The register is useful for private-school coverage, but no source-specific reuse license was established.

Sources:
- https://www.psra.gkp.pk/registers
- https://www.psra.gkp.pk/district/get-schools?district_id=1
- https://www.psra.gkp.pk/district/get-schools?district_id=18
- https://www.psra.gkp.pk/district/get-schools?district_id=2

## 9. Updated provincial school-source interpretation

- **Sindh:** public-school institution checker and private-school DIRPIS/SPEI-EMIS registration/census are separate streams; the older TOR explicitly notes registered and unregistered private providers and a need for data updating.
- **KP:** district-based private-school register has multiple meaningful status values; do not treat directory presence as active registration.
- **Punjab:** PEPRIS valid eLicense list and DEA data-upload caveat remain separate from public-school EMIS.
- **AJK:** public and private census streams remain distinct.
- **GB:** government EMIS, BECS community schools, colleges and special education are separate source families.
