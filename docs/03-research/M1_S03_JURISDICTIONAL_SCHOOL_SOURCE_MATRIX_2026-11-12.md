# M1-S03 — Provincial and Territorial School Authority Source Matrix

**Review date:** 2026-11-12  
**Scope:** Public/private school authority, EMIS, regulator and public directory routes across Pakistan's provinces and territories, including ICT.  
**Status:** Source-mapping deliverable; M1-S03-C02 remains in progress pending final task audit.

## 1. Jurisdiction-by-jurisdiction source matrix

| Jurisdiction | Public-school authority/source | Private-school authority/source | Public route and visible coverage | Access/freshness/rights limitations |
|---|---|---|---|---|
| Punjab | School Education Department / PMIU — [Open Punjab Schools](https://openpunjab.pesrp.edu.pk/schools/) | PEPRIS — [provider portal](https://www.pepris.pesrp.edu.pk/) and [support/FAQ](https://pepris.pesrp.edu.pk/support) | PMIU portal describes data as free/open/real-time and displays 38,130 public schools for School Census 2024–25; EMIS search by code and monitoring data. PEPRIS supports new registration, renewal, e-license and registered-school search. | "Free/open" page wording is not, by itself, a verified legal reuse license. PEPRIS search asks for owner CNIC/mobile; some DEA-registered schools may be absent until uploaded; school details may require account/login. Do not collect owner identifiers. No source-specific institution-record license verified. |
| Sindh | School Education & Literacy Department — [Institution Checker](https://checker.sindheducation.gov.pk/ListInstitution.aspx) | Separate DIRPIS/SPEI-EMIS registration/census source; [2023 private-school registration criteria](https://www.sindheducation.gov.pk/Contents/Notifications/86125%20Criteria%20for%20Registration%20of%20Private%20Schools.PDF) | Public institution checker supports region, district, tehsil, UC, status, level, gender, type, shift, location and SEMIS/DDO/name filters. Private-school registration criteria describe application requirements but are not a complete public private-school register. | Checker says records are continuously updated but has no dataset-wide as-of date. Public-school checker and private-school DIRPIS are separate. Current complete private register and reuse rights not verified. |
| Khyber Pakhtunkhwa | Elementary & Secondary Education Department iEMIS — [official department](https://kpese.gov.pk/) | KP Private Schools Regulatory Authority (KPPSRA) — [authority page](https://kpese.gov.pk/private-schools-regulatory-authority-psra/) and district register routes | Public-school iEMIS is role-based in the reviewed material; KPPSRA district registers show private-school name, level, registration and status. | Do not bypass iEMIS login. KPPSRA status includes ACTIVE/BLOCKED/DORMANT/CLOSED; district results do not prove full province-wide coverage or current update date. No reuse license verified. |
| Balochistan | School Education Department / BEMIS — [school profile search](https://emis.gob.pk/views/Reports/Reports/SchoolSearchPublic.aspx) and [SED dashboard](https://sed.gob.pk/) | Separate GIS "Private" layer — [SED school map](https://sed.gob.pk/map.html) | Public school search offers BEMIS code, district, tehsil, level, gender, legal/operating status and facility filters. SED reports 15,368 public schools from a 30-Jul-2026 BEMIS/DDO extract. GIS map has separate Schools, Private, BEF and ALP layers. | Map denominator 14,709 differs from dashboard 15,368; 1,729 in the map denominator lack GPS. Private-layer count/export/terms not verified. Only SED headline/district aggregates have the previously documented narrow license; school-level records remain RESEARCH ONLY. |
| Islamabad Capital Territory (ICT) | Federal Directorate of Education (FDE) — [portal](https://www.fde.edu.pk/) and [2026–27 admissions](https://eadmissions.fde.gov.pk/portal) | Private Educational Institutions Regulatory Authority (PEIRA) — [registration/renewal](https://peira.gov.pk/registration_form.php) | FDE portal displays 432 ICT institutions; admissions portal supports session-specific institution selection and seat availability. PEIRA provides private-school registration/renewal routes. | FDE 432 is an aggregate, not a public complete school register; GIS EMIS contains staff/asset/transport modules and has unverified reuse terms. PEIRA is application/credential-oriented; do not use personal owner data or bypass login. |
| Azad Jammu & Kashmir (AJK) | E&SE Department — [portal](https://ese.gok.pk/) and [EMIS login](https://emis.ese.gok.pk/) | PEIRA E&SE private-institution portal — [portal](https://peira.ese.gok.pk/); official private-list announcement dated 5-Nov-2025 | E&SE homepage displays 6,019 schools; private-institution list announcement exists. | 6,019 aggregate has no clear as-of date; selected quick-overview cards display zero. EMIS/PEIRA require login; linked private-list PDF prompts Google sign-in. No public record-level register/reuse permission verified. |
| Gilgit-Baltistan (GB) | GB EMIS — [school details](https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details) | No current public private-school register verified | Public school-details table includes district, tehsil, cluster, school code/name and level; Directorate of Education Colleges has a separate [public college list](https://doecgb.gov.pk/institutions). BECS community schools are a separate provider family. | EMIS table includes administrative "Office" rows; summary dashboard may show zero despite populated details. Private register and complete special-education coverage remain unverified. No source-specific reuse license verified. |

## 2. Cross-jurisdiction modelling requirements

1. Preserve jurisdiction and source authority at record level; never infer a national regulator from a portal domain.
2. Keep public-school EMIS, private-school registration, school census, admissions portals, examination-board affiliation and programme accreditation as separate source types.
3. Preserve source as-of date, publication date, source identifier, status, access method and rights disposition. A dynamic "real-time" label does not remove the need to record a check timestamp.
4. A source that publishes aggregate counts is not a record-level directory. A private-school registration process is not necessarily a public searchable register.
5. A missing public register is an evidence/access gap, not evidence that no providers exist.
6. No CNIC/mobile owner identifiers, child/student records, teacher/staff profiles, payroll, health/disability/therapy data or other personal data are collected.
7. Except for the narrowly licensed SED Balochistan headline/district aggregates, all sources remain **RESEARCH ONLY** pending source-specific terms/permission review. The narrow license does not cover school-level data.

## 3. Outstanding jurisdiction gaps

- Punjab: validate the meaning/scope of the 38,130 PMIU snapshot and locate explicit license terms; reconcile PEPRIS/DEA upload completeness.
- Sindh: obtain a current public private-school register route or document that none is public; establish data freshness and rights.
- KP: no public unauthenticated government-school iEMIS route verified; validate KPPSRA district coverage and update dates.
- Balochistan: reconcile 15,368 versus 14,709 public-school denominators and verify private GIS scope/rights without harvesting.
- ICT: identify whether a public record-level FDE directory exists; keep FDE and PEIRA separate.
- AJK: obtain public unauthenticated access evidence for the 2025 private list and school EMIS; reconcile dashboard aggregate quality.
- GB: verify private-school register authority/route and reconcile school-details table with dashboard summary.

## 4. Source references reviewed

- Punjab PMIU/Open Punjab: https://openpunjab.pesrp.edu.pk/schools/
- Punjab PEPRIS: https://www.pepris.pesrp.edu.pk/
- Sindh Institution Checker: https://checker.sindheducation.gov.pk/ListInstitution.aspx
- Sindh private registration criteria: https://www.sindheducation.gov.pk/Contents/Notifications/86125%20Criteria%20for%20Registration%20of%20Private%20Schools.PDF
- KPPSRA: https://kpese.gov.pk/private-schools-regulatory-authority-psra/
- Balochistan EMIS: https://emis.gob.pk/views/Reports/Reports/SchoolSearchPublic.aspx
- Balochistan SED GIS: https://sed.gob.pk/map.html
- FDE: https://www.fde.edu.pk/
- ICT PEIRA: https://peira.gov.pk/registration_form.php
- AJK E&SE: https://ese.gok.pk/
- AJK EMIS: https://emis.ese.gok.pk/
- GB EMIS: https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details
- GB colleges: https://doecgb.gov.pk/institutions

Reviewed 2026-11-12. This is a source mapping and gap record, not a complete national institution census or authorization to reuse data.
