# Education Data Provider Register

**Status:** Initial research register; each entry requires verification before collection or reuse. This is not a claim that all listed providers offer downloadable data or API access.

| Provider/source family | Potential coverage | Region | Research required |
|---|---|---|---|
| Pakistan Institute of Education (PIE) / Pakistan Education Statistics | National education statistics and EMIS-derived reporting | Pakistan | Dataset granularity, methodology, year, license, download/API |
| Provincial/regional Education Management Information Systems (EMIS) | Public schools and education statistics | Each province/territory | Portal inventory, school-level access, update cycle, reuse terms |
| Punjab School Education Department / public school data portals | Public schools | Punjab | Current official endpoints/files, terms, completeness |
| Punjab PEPRIS | Private school registration/discovery information | Punjab | Public fields, access conditions, reuse permission |
| Provincial Higher Education Departments | Public colleges and related institutions | Province-specific | Official directories, campus/programme detail, update cycle |
| Higher Education Commission (HEC) | Recognized universities, campuses, degree-awarding institutions and qualification register | Pakistan | Recognition scope, current register format, reuse terms; see M1 official source coverage matrix |
| Boards of Intermediate and Secondary Education (BISEs) | Affiliation, examination and institution-related information | Board jurisdictions | Which fields are public and reusable |
| NAVTTC and provincial TEVTAs | Technical/vocational training providers and programmes | National/provincial | Provider registers, accreditation, current courses, data owner, reuse terms and province-specific update cadence |
| National/regional non-formal education MIS and departments | Non-formal/adult education centres | National/regional | Current authoritative sources and licensing |
| Special education departments/directorates | Special education institutions and centres; Punjab and Sindh source families identified | Provincial/regional | Official directories and data access; verify other jurisdictions, minimize direct personal contact fields and check reuse terms |
| Madaris boards/registrations where lawfully public | Religious education providers | Pakistan | Public register scope, sensitivity and reuse rights |
| Official institution websites | Institution-submitted programmes, admissions, fees and facilities | Institution-specific | Terms, copyright, refresh cadence, contact/permission |
| Licensed education associations/directories | Member institutions | Varies | Dataset license, completeness, conflicts of interest |

## Required fields for every researched provider
Provider ID; legal/official name; authority; URL; geography; education levels; sector; data fields; access method; license/terms URL; permission status; personal-data risk; update cadence; last checked; connector owner; reliability notes; known gaps; decision and evidence.

## Operating rule
Do not activate a connector until source access, rights, privacy and technical constraints have been reviewed and recorded in `DATA_RIGHTS_AND_PROVENANCE.md`.

## Specific official source leads identified in M1-S02

The following source families have been located independently and are documented with limitations in `../03-research/M1_OFFICIAL_INSTITUTION_SOURCE_COVERAGE_MATRIX.md`:

- HEC, PMDC, PNMC and Pharmacy Council of Pakistan.
- Provincial/regional school sources: PEPRIS, KP-PSRA, Balochistan SED/EMIS, Sindh SEMIS, ICT-PEIRA, AJK E&SE and GB EMIS.
- NAVTTC, Skilling Pakistan, BECS and NFEMIS.
- Punjab Special Education Department and Sindh DEPD.
- PEC, NCEAC, NACTE and NCH professional education sources.

Source discovery does not establish a right to collect or republish. See `../03-research/M1_SOURCE_RIGHTS_ACCESS_EVIDENCE_REGISTER.md`; every source remains research-only pending rights, privacy, access and owner review.


## M1-S03 official-source verification

The first source-specific verification pass is recorded in [M1-S03 Official Government and Regulator Provider Source Register](../03-research/M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md). It adds current evidence for PIE/NEMIS, MoFEPT, HEC, NAVTTC, IBCC, DGRE, HEC Deeni Asnad equivalence, Balochistan EMIS, Sindh institution checker, ICT-PEIRA, Punjab SED/PEPRIS and KPPSRA. The register distinguishes authority mandate, public directory, aggregate source, application portal and QAB/equivalence route. All records remain research-only unless source-specific reuse permission is documented.

Deeni Madaris remain a distinct underlying provider family. Per owner decision, public listing visibility is disabled by default and controlled by the future `Show Deeni Madaris` setting; this is a requirements decision, not an implemented feature.


## M1-S03 additional official-source findings

The M1-S03 source register now includes NFEMIS (national NFE), DGSE (special education, with mandate attribution discrepancy), Sindh DEPD (mixed education/rehabilitation provider list), GB EMIS school details and the GB Directorate of Education Colleges list. See `../03-research/M1_S03_NFE_SPECIAL_ED_GB_SOURCE_REVIEW_2026-11-12.md`. These are research-only source routes. No source-specific reuse permission is inferred; learner/teacher records, child identifiers, disability/health/therapy information and staff personal contacts remain excluded.


## M1-S03 professional regulator source routes

The official provider source register now includes PMDC, PCP, PNMC, NCEAC, NACTE, PEC, NTC, PVMC and PBC source-specific routes. Detailed scope, current-status semantics and limitations are in `../03-research/M1_S03_PROFESSIONAL_REGULATOR_SOURCE_REVIEW_2026-11-12.md`. All remain RESEARCH ONLY; programme/batch/validity and source rights require further verification.


## M1-S03 AJK source update — 2026-11-12

AJK E&SE and HED routes are now included in the official source register. The E&SE homepage displays a 6,019-school aggregate and an announcement for a registered-private-institution list, but the EMIS/PEIRA routes are login-only and the linked private-list PDF prompts sign-in. HED lists degree/inter/education colleges while its official aggregate pages conflict between 180 and 178. See `../03-research/M1_S03_AJK_EDUCATION_SOURCE_REVIEW_2026-11-12.md`. All remain research-only.


## M1-S03 TVET/QAB source review

- [M1-S03 TVET and QAB Source Review](../03-research/M1_S03_TVET_QAB_SOURCE_REVIEW_2026-11-12.md) — NAVTTC QABs, provincial TVET authorities, provider directories, B-TEVTA/BSIS discrepancies and Madaris vocational overlap; **Delivered — review pending; M1-S03 in progress.**
- [M1-S03 Official Government and Regulator Provider Source Register](../03-research/M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md) — updated with GOV-31 to GOV-35; **Updated — review pending.**


## Deeni Madaris and TVET source relationship — design note

Punjab TEVTA and TTB Punjab publicly list some Deeni Madaris as vocational-training centres or as partners attached to TEVTA institutes. These are training/assessment relationships and do not establish general academic recognition. Preserve the Madrasah provider, separate vocational provider/site (if independently established), programme/trade, TEVTA/TTB affiliation and QAB as distinct entities/relationships. The owner's default-hidden Deeni Madaris rule remains unchanged; public visibility of a separately registered vocational entity sharing the same address is an open M2 design question, not a decision inferred from source data.


## M1-S03 federal education statistics and examination-board sources

PIE/NEMIS source lineage, Pakistan Education Statistics 2024 coverage caveats, historical Deeni Madaris Wafaq-reporting limitations and FBISE's SSC/HSSC affiliated-institution register are recorded in `../03-research/M1_S03_FEDERAL_DATA_FBISE_SOURCE_REVIEW_2026-11-12.md`. FBISE affiliation is not institutional recognition or accreditation; historical Wafaq statistics are not a current Madaris register.


## M1-S03 federal provider network clarification

FDE and FGEI C/G are separate source families. FDE's 432-institution figure is an ICT aggregate and its admissions/GIS routes have separate scope and sensitive modules. FGEI C/G is a distinct directorate under IGT&E with an indexed 311-school/49-college network across cantonment/garrison regions; record-level access was limited in review. FBISE affiliation is a third, separate examination-board relationship. See `../03-research/M1_S03_FDE_FGEI_SOURCE_REVIEW_2026-11-12.md`.


## M1-S03 jurisdictional school-source matrix

The source register now has a consolidated jurisdictional matrix for public/private school authorities across Punjab, Sindh, KP, Balochistan, ICT, AJK and GB. See `../03-research/M1_S03_JURISDICTIONAL_SCHOOL_SOURCE_MATRIX_2026-11-12.md`. GOV-40 to GOV-42 add Punjab PMIU/PEPRIS, Sindh private-school registration and KP public iEMIS/KPPSRA. All source reuse remains subject to specific permission; no owner/student/teacher personal data is collected.


## M1-S03 additional accreditation council routes

The official source register now includes HEC's accreditation-council map, NBEAC, NCH, PCATP, AHPC and NAEAC. Detailed scope and status limitations are in `../03-research/M1_S03_ADDITIONAL_ACCREDITATION_COUNCIL_REVIEW_2026-11-12.md`. AHPC's published list is applicant-only; no approval is inferred. NCH personal contacts are excluded; PCATP/NAEAC complete current programme registers remain unverified.
