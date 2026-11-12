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
