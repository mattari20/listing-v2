# M3-07 R1 — Pakistan National Education Source Master Inventory

**Prepared:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Branch:** `docs/m3-07-r1-national-source-inventory`  
**Work package:** R1 — National Source Master Inventory  
**Status:** Consolidated inventory v1 delivered for owner review; source-rights and collection activation remain blocked  
**Baseline:** Current `main` at `4b594e288999ee2f634320937886a2fca7ccc496`

## 1. Executive disposition

R1 consolidates the accepted M1-S03 official-source research into a national source-master view suitable for the M3-07 dynamic education-information platform.

The repository already contains:
- 48 source records, GOV-01 through GOV-48, in the M1-S03 Official Government and Regulator Provider Source Register;
- a seven-jurisdiction public/private school source matrix;
- national coverage and gap synthesis;
- dedicated professional-regulator, TVET/QAB, AJK, NFE/special-education, federal-data, FDE/FGEI and additional accreditation-council reviews; and
- an M1-S03 task acceptance audit recording owner acceptance on 2026-11-12.

The M1-S03 audit's 100% figure means completion of its **research tasks**, not 100% provider coverage, complete national census, legal clearance, permission to reuse, or permission to collect. R1 does not repeat or supersede that accepted research. It reconciles it into an operational inventory and records the additional source families needed for continuous institution-level updates.

**R1 outcome:** the national source-family map is sufficiently established for planning and source-specific G2 assessments to be prepared. It is not a source authorization register and it does not clear any source for ingestion.

## 2. Binding scope and safety boundary

This work package is desk-research and documentation only.

It does not authorize or perform:
- automated crawling, scraping, bulk download, API calls, connectors, scheduled monitoring or data ingestion;
- authenticated access, account creation, login, credential requests, access-control bypass or CAPTCHA/rate-limit circumvention;
- source-owner outreach, permission requests or legal representations;
- model/provider selection, live AI processing or agent activation;
- collection of student, applicant, child, teacher or staff personal data, CNIC/B-Form, private contact data, health/disability/therapy data, payroll or credentials;
- collection of sect/maslak information;
- production, V1, Hostinger/hPanel, live database, deployment, public release or additional spend.

All candidate sources remain **RESEARCH ONLY** unless a separate source/asset/method-specific authorization is recorded and all applicable G2-G9 gates pass. The only previously documented narrow exception is the SED Balochistan dashboard headline metrics and district aggregates with attribution and an as-of date; that exception does not extend to school-level records or other SED/EMIS content.

## 3. Inventory method and evidence standard

R1 uses the accepted M1-S03 source register and supporting research as the source of record for detailed authority findings. A limited public-page recheck on 2026-11-16 was used to identify material current-page observations; it was not a collection exercise.

Each source must be classified by what it actually establishes:

| Source class | What it can establish | What it does not automatically establish |
|---|---|---|
| Government ministry/department directory | Responsible body, jurisdiction, programme or public service route | Complete institution universe or reuse rights |
| Public-school EMIS/register | School identity and fields explicitly exposed by the relevant public route | Private-school coverage, current legal registration, permission to harvest or student/staff data use |
| Private-school regulator register | Registration/renewal status within the regulator's jurisdiction and published scope | Academic quality, programme approval or coverage outside that regulator |
| HEC / higher-education register | HEC recognition within its remit, recognised campus and qualification records | School/academy status, every college affiliation or programme-level accreditation |
| Professional regulator/accreditation register | The exact programme, batch, intake, institution, campus or qualification status within that body's remit | General institutional recognition or approval by another authority |
| TVET provider/QAB/accreditation source | Provider registration, partnership, QAB affiliation, trade/programme or accreditation status as specifically stated | Equivalence between provider registration, QAB affiliation and accreditation |
| Institution-controlled official source | The institution's own programmes, subjects, admissions, fees, policies, facilities and notices, subject to evidence and source identity | Its own legal recognition, regulatory approval or third-party affiliation unless the competent authority confirms it |
| Official social account/publication | A dated institutional announcement or corroborating statement if account identity is verified | Blanket authority for automated access or proof of regulator status |
| Map/location platform | Discovery and limited location corroboration under its own terms | Recognition, accreditation, programme facts or unrestricted copying into a permanent database |
| Third-party directory/search result | Discovery lead and potential cross-check | Primary authority, completeness or legal reuse permission |

A source record is not an institution record. A regulator, institution website, official social account, API, portal and individual publication are distinct source assets and may require distinct authorization.

## 4. National source-family inventory

### 4.1 Federal and national education authorities

| Inventory group | Existing evidence / primary routes | Coverage and role | Key limitations / R1 disposition |
|---|---|---|---|
| National education governance | MoFEPT authority map; PIE/NEMIS | Identifies federal and regional education bodies; national education statistics and EMIS coordination | Not a single national live provider register. Use statistics for benchmarking only, with year and methodology. |
| Higher education | HEC recognised universities/DAIs, recognised campuses, PQR, accreditation and affiliation policy pages | University/DAI recognition, campus recognition, qualifications and specific higher-education oversight | Keep institution, campus, affiliated college, study centre, programme, intake and accreditation separate. HEC is not the universal directory authority. |
| Examination and qualification bodies | IBCC, FBISE, provincial BISEs and technical boards | Board membership, examination and qualification-awarding relationships | Board affiliation or QAB status is not the same as provider recognition or automatic qualification equivalence. |
| Professional councils | GOV-20 through GOV-30 and GOV-43 through GOV-48; detailed professional-regulator and accreditation reviews | PM&DC, PCP, PNMC, PEC, NCEAC, NACTE, NBEAC, NTC, NCH, PBC, PVMC, PCATP, NCT, AHPC and NAEAC | Verify exact regulator remit and programme/campus/intake/batch/validity scope. Applicant lists are not approvals; stale or undated registers remain research-only. |
| TVET and skills | NAVTTC registration, partner-institute, QAB and accreditation routes; provincial TEVTAs and boards | National TVET ecosystem and qualification-awarding relationships | Registration, partnership, accreditation, QAB affiliation and trade certification are separate. Current page counts have different scopes and must not be combined. |
| Non-formal education | NFEMIS, BECS/ALP and jurisdiction-specific NFE routes | Non-formal centres and programmes | Dashboards and historical totals are not a complete current formal-school or provider register. Exclude learner/teacher/attendance data. |
| Special education | DGSE, Sindh DEPD, provincial/territorial education departments and GB sources | Special-education institutions, centres and services | Some lists mix education, rehabilitation and service centres; avoid disability/health/therapy and personal data. |
| Deeni Madaris | DGRE, IBCC QAB and HEC Deeni Asnad equivalence routes | Distinct provider and qualification pathways | Existing V2-DEC-006 remains binding: default public visibility OFF; no sect/maslak classification. Registration, QAB recognition and qualification equivalence are not interchangeable. |

Current public-page checks on 2026-11-16 reconfirmed the HEC recognised-university page, HEC campus page, HEC PQR, NAVTTC partner-institute directory and NAVTTC registration/affiliation routes. HEC's English campus page displays 151 campuses; this is a page-reported snapshot, not a reconciled national campus census. NAVTTC's partner directory and registration page display different headline counts and must be stored as different measures with their own definitions and dates.

### 4.2 Provincial and territorial school source inventory

| Jurisdiction | Public-school route | Private-school route | Current inventory assessment and open gap |
|---|---|---|---|
| Punjab | PMIU/OpenPunjab school service; SED; SIS | PEPRIS and District Education Authorities | Public-school discovery route is visible. SIS contains sensitive student/guardian/teacher fields and is not an approved data source for those fields. PEPRIS registration/search flows may require owner CNIC/mobile or login; no use of personal lookup flows or bulk extraction. Coverage/upload gaps remain. |
| Sindh | SE&LD/SEMIS Institution Checker; RSU | DIRPIS / private-school registration and census source family | Public institution checker is searchable by geography and school attributes. It is not evidence of private-school completeness. Current complete private-school register and reuse rights remain unresolved. |
| Khyber Pakhtunkhwa | KPESE/iEMIS | KP Private Schools Regulatory Authority (KPPSRA) district registers | KPPSRA provides a public registered-private-school route with distinct ACTIVE/BLOCKED/DORMANT/CLOSED states. Public iEMIS remains role-based in reviewed evidence; do not bypass. District-level pages do not prove full province-wide completeness. |
| Balochistan | SED/EMIS public School Profile Search and GIS | EMIS separate Private Schools route; regulator/authority research | Public school profile fields include BEMIS code, district, tehsil, level, gender, legal status and operating status. Private-school route exists but a complete current public register was not verified. Dashboard/GIS denominators differ; preserve as separate observations. |
| Islamabad Capital Territory | FDE and MoFEPT routes | ICT-PEIRA active/renewal registers | PEIRA publicly describes active valid registrations and a weekly update process, but renewal states and regulator scope must be preserved. FDE headline counts are not a record-level school directory. |
| Azad Jammu & Kashmir | E&SE dashboard; EMIS login route | E&SE private-institution list announcement; PEIRA portal | Dashboard reports an aggregate school count without a clear as-of date. EMIS/PEIRA are access-constrained; announced private list prompts sign-in. No public complete current school-level dataset was verified. |
| Gilgit-Baltistan | GB EMIS school-details route | No complete current public private-school register verified | Public details table exposes district, tehsil, cluster, school code/name and level but also administrative-office rows. Filter provider types and reconcile duplicates; summary dashboard zeroes are not valid counts. |

### 4.3 Colleges and higher-education provider coverage

The source master must combine, without collapsing:
- HEC recognised universities/DAIs and campuses;
- provincial HED public and private college lists;
- AJK HED degree, intermediate and educational college lists;
- GB Directorate of Education Colleges;
- university-specific constituent and affiliated college lists;
- examination-board affiliation sources;
- professional college/programme regulators; and
- official institution websites for current campus, course, subject, admission and fee facts.

Known gaps remain in private-college completeness and in reconciling institution/college/study-centre relationships across jurisdictions. AJK HED's official 178-versus-180 college totals remain an unresolved source discrepancy. Sindh's public college directory reports 376 functional government colleges, but that number is source-reported and date/scope must be retained. Punjab HED has public and private college routes; their presence does not establish a single reconciled private-college universe.

### 4.4 TVET, professional and specialist provider coverage

Use NAVTTC as a national framework/source family, not as the sole provider universe. Keep provincial sources distinct: Punjab TEVTA/PSDA/TTB; Sindh STEVTA; KPTEVTA and its technical/trade bodies; B-TEVTA and BSIS; and AJK TEVTA. A provider can deliver a course while another body examines or awards a qualification.

Professional councils are discipline-specific. A college may appear in an institution directory while its particular programme, intake or batch is not approved. The source master must preserve regulator, object type, programme, campus, session/intake, status, valid-from/to, notification date and exact evidence locator.

### 4.5 Academies, tuition, coaching and small/local providers

No single comprehensive official national registry for all academies, tuition centres, entry-test preparation, language centres, local IT training providers and small coaching businesses has been established in the accepted research.

R1 therefore records this as a **national source-coverage gap**, not an absence of providers. Potential discovery channels include:
- provider-controlled official websites and prospectuses;
- verified provider-controlled social accounts and dated notices;
- competent local/provincial registration authorities where a relevant regime exists;
- institution self-submission with identity and evidence checks; and
- manual discovery leads for later human verification.

Third-party directory entries, search snippets and map listings must not establish registration, recognition, quality or accreditation. Small/local providers must not be excluded solely because they lack a national profile; nor does their inclusion imply regulatory approval.

## 5. Institution-controlled source family — required for continuous updates

Government registers are not sufficient for the student-lifecycle information the product intends to maintain. Institution-controlled sources are required candidates for institution-specific facts, subject to source identity and authorization.

| Asset subtype | Potential student information | Evidence and governance rule |
|---|---|---|
| Official institution website | Identity, campuses, departments, courses, subjects, programmes, facilities, contacts | Verify domain-to-institution relationship. Each website/host and relevant subdomain is a distinct source asset. |
| Official admissions portal | Intake, eligibility, deadlines, application process, entry tests, seats and charges | Scope by programme, campus and admission cycle. Do not collect applicant accounts or personal application records. |
| Official prospectus / handbook / fee schedule | Course structure, subject lists, fee amounts, payment schedule, academic rules | Record document title/version, publication/effective date, page/section locator and supersession. |
| Official notices / circulars | Changes to courses, fees, admissions, calendar, policies or campus operations | Preserve issue date, effective date, session and superseded notice links. |
| Institution-controlled social account | Dated announcements and updates where no formal page exists | Account ownership/verification must be established; individual post is an asset. Social visibility is not blanket automated-access permission. |
| Official video/channel | Course or campus announcements and explanatory information | Discovery/corroboration only until exact source terms, evidence locator and reuse method are approved. |

The dynamic field registry must allow new fields to be proposed when institutions publish new information. The existence of a source attribute does not automatically create a public field, searchable filter or collection permission. New fields require definition, scope, privacy, validation, evidence, freshness and publication review.

## 6. Discovery-only and corroboration sources

Mapping platforms, open mapping datasets, search engines, third-party directories and public social/search results may help identify candidate providers or corroborate a location. They are not primary authorities for recognition, affiliation, accreditation, fees or programme approval.

In particular:
- Google Maps/Places content must not be scraped or exported into a permanent independent directory database. Any future use requires a separately approved product/API method and compliance with current platform terms, caching, attribution and retention restrictions.
- OpenStreetMap use requires an ODbL attribution and database-license assessment before any derived database is created or distributed.
- Search results and social snippets are leads, not evidence of current institutional status.
- No location/map source authorizes device geolocation, nearby search or coordinate ingestion; M3-06 geospatial capabilities remain separately deferred.

## 7. Coverage gap register

| Gap ID | Gap | Affected coverage | Required resolution before source activation |
|---|---|---|---|
| R1-G01 | Complete current private-school registers are not publicly verified in every jurisdiction | Sindh, Balochistan, AJK, GB and parts of Punjab/KP | Confirm regulator remit, current register scope, access class, update cadence and lawful access method. |
| R1-G02 | Public school records are not uniformly available through public unauthenticated routes | KP, AJK, ICT and other restricted systems | Do not bypass login. Use only a separately authorized official public export/API or documented lawful permission route. |
| R1-G03 | Private-college coverage and affiliation are fragmented | All jurisdictions | Map provincial HED, affiliating universities, boards and regulator sources; reconcile relationships and validity. |
| R1-G04 | Small academies/coaching providers lack a unified national register | National | Design a verified self-submission/manual discovery pathway and distinguish unverified directory inclusion from regulatory status. |
| R1-G05 | Institution-controlled websites and social accounts are not yet inventoried asset-by-asset | All provider categories | Build per-institution source asset records only after the institution identity and source ownership are verified; assess terms and permitted method. |
| R1-G06 | Professional programme/campus/intake statuses vary by council | National | Preserve exact regulated object and time scope; obtain current register and source-specific rights evidence. |
| R1-G07 | TVET provider, QAB, accreditation and assessment data are inconsistent across sources | National/provincial | Reconcile provider-to-QAB and provider-to-programme relationships; preserve source counts as separate measures. |
| R1-G08 | AJK, GB, special-education, NFE and Madaris coverage has unresolved register/freshness issues | Relevant territories/provider families | Maintain explicit gaps; do not infer completeness from aggregate counts, historical lists or login-only portals. |
| R1-G09 | Source-specific copyright, database rights, platform terms and reuse permission are not established for most assets | All candidate sources | Complete G2 assessment per source asset, field, method, purpose, retention, attribution, expiry and reviewer. |
| R1-G10 | No operational source owners/reviewers or publication approvers are assigned | All future collection workflows | Resolve G7 role/capacity and separation-of-duties before activation. |

## 8. Canonical source-master record contract for R2/G2

The operational source master should distinguish a **source family**, a **source asset**, an **access method**, and an **authorization manifest**. These are related but not interchangeable records.

Minimum source-family fields:
- stable source-family ID and display name;
- responsible authority/owner and jurisdiction;
- source class and provider categories in scope;
- legal/administrative remit and exact claim types it can support;
- parent/related source families;
- inventory status and research evidence references.

Minimum source-asset fields:
- stable asset ID and parent source-family ID;
- canonical URL/domain/account/document or portal identifier;
- asset subtype and owner/control evidence;
- applicable provider types, entities and fields;
- observed public/authenticated/access-restricted status;
- observation date and source-published/as-of date;
- data granularity, schema/visible fields and known exclusions;
- update cadence if explicitly published; otherwise unknown;
- known quality issues, scope limits and source-reported count definition;
- source terms/license/attribution references and last terms-review date.

Minimum authorization-manifest fields:
- immutable manifest ID/version and exact asset ID;
- approved purpose and exact field allowlist;
- permitted acts (manual viewing, API retrieval, download, transformation, caching, storage, republication) separately enumerated;
- exact access method, endpoint, credentials boundary and technical controls;
- terms/license/permission evidence and jurisdictional/legal review;
- privacy classification, excluded data, minimization and retention/deletion;
- rate, volume, bandwidth and schedule limits;
- attribution and downstream-display requirements;
- reviewer/approver identities and approval dates;
- effective-from, expiry/review date, revocation state and kill switch.

No default permission may be inferred from a blank field. Unknown terms, cadence, owner, retention or permitted acts must remain **UNKNOWN / BLOCKED**, not be filled by assumption.

## 9. Recommended source-evaluation sequence (not collection authorization)

1. **HEC source family:** validate the exact scope and semantics of universities/DAIs, campuses, PQR and relevant recognition/affiliation claims. Do not use it as a national all-provider source.
2. **Institution-controlled official sources:** define a repeatable method to verify the institution-domain relationship and inventory each website/admissions/prospectus asset. No crawling or bulk discovery is approved.
3. **Provincial school authorities:** resolve public/private school source gaps by jurisdiction, starting with the source routes already documented in M1-S03.
4. **College/affiliation sources:** map provincial HED and university/board relationships, including validity and campus scope.
5. **Professional councils and TVET:** validate exact regulated object, programme/session/validity and QAB/accreditation distinctions.
6. **Small-provider pathway:** design self-submission and manual review for academies and local providers without a complete public register.
7. **Discovery-only sources:** assess Maps/OSM/social/search separately and only if a concrete use case and compliant method are approved.

This order is for source-evaluation planning only. It does not authorize opening or retrieving source assets.

## 10. R1 completion and handoff

| Acceptance criterion | Result |
|---|---|
| Existing accepted M1-S03 research identified and reused rather than duplicated | **PASS** — 48 GOV records and supporting source reviews identified |
| Seven provincial/territorial school jurisdictions represented | **PASS** — Punjab, Sindh, KP, Balochistan, ICT, AJK and GB |
| National higher education, professional, TVET, NFE, special education and Madaris source families represented | **PASS** — with explicit authority/scope distinctions |
| Institution-controlled source family added for dynamic programmes, subjects, fees and admissions updates | **PASS** — source asset classes and evidence rules defined |
| Small/local academies and coaching coverage gap explicitly recorded | **PASS** |
| Source counts, conflicting totals, stale records and access constraints preserved as gaps | **PASS** — no unsupported national total inferred |
| Source-family, source-asset and authorization-manifest boundaries defined | **PASS** — proposed contract for R2/G2 |
| No collection, scraping, external access, contact, API, AI, production or spend performed | **PASS** — documentation/research only |
| Owner acceptance of this R1 consolidation | **PENDING** |
| G2 source/asset/method rights approval | **BLOCKED / NOT GRANTED** |
| G3 privacy, G4 security, G7 governance and G9 activation | **BLOCKED / NOT GRANTED** |

**R1 status:** research consolidation and source-master v1 are delivered for owner review. The research baseline is complete enough to proceed to R2 data-model design in planning, but no live source can be activated. Owner acceptance of this R1 document and each later source-specific authorization remain separate decisions.

## 11. Source-of-record documents

R1 deliberately reuses the following accepted repository evidence rather than duplicating 48 source records:
- `docs/03-research/M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md`
- `docs/03-research/M1_S03_TASK_ACCEPTANCE_EVIDENCE_AUDIT_2026-11-12.md`
- `docs/03-research/M1_S03_JURISDICTIONAL_SCHOOL_SOURCE_MATRIX_2026-11-12.md`
- `docs/03-research/M1_S02_CONSOLIDATED_NATIONAL_COVERAGE_GAP_MATRIX_2026-11-12.md`
- `docs/03-research/M1_S03_PROFESSIONAL_REGULATOR_SOURCE_REVIEW_2026-11-12.md`
- `docs/03-research/M1_S03_TVET_QAB_SOURCE_REVIEW_2026-11-12.md`
- `docs/03-research/M1_S03_AJK_EDUCATION_SOURCE_REVIEW_2026-11-12.md`
- `docs/03-research/M1_S03_NFE_SPECIAL_ED_GB_SOURCE_REVIEW_2026-11-12.md`
- `docs/03-research/M1_S03_FEDERAL_DATA_FBISE_SOURCE_REVIEW_2026-11-12.md`
- `docs/03-research/M1_S03_FDE_FGEI_SOURCE_REVIEW_2026-11-12.md`
- `docs/03-research/M1_S03_ADDITIONAL_ACCREDITATION_COUNCIL_REVIEW_2026-11-12.md`
- `docs/03-research/M1_SOURCE_RIGHTS_ACCESS_EVIDENCE_REGISTER.md`
- `docs/04-roadmap/M3-07_NATIONAL_EDUCATION_COVERAGE_AND_CONTINUOUS_AGENT_PLAN.md`
- `docs/04-roadmap/M3-07_STUDENT_DISCOVERY_PLATFORM_ARCHITECTURE_AND_DYNAMIC_FIELD_GOVERNANCE.md`

## 12. Public source routes rechecked on 2026-11-16

These public pages were consulted to confirm current route availability and selected visible descriptions. This list is not an authorization list:
- HEC recognised universities/DAIs: https://www.hec.gov.pk/english/universities/pages/recognised.aspx
- HEC recognised campuses: https://www.hec.gov.pk/english/universities/Pages/DAIs/HEC-recognized-Campuses.aspx
- HEC Pakistan Qualification Register: https://www.hec.gov.pk/english/services/universities/pqr/Pages/default.aspx
- Punjab OpenPunjab schools: https://openpunjab.pesrp.edu.pk/schools/
- Punjab SIS dashboard: https://sis.pesrp.edu.pk/dashboard/index
- Punjab PEPRIS: https://pepris.pesrp.edu.pk/
- Sindh institution checker: https://checker.sindheducation.gov.pk/ListInstitution.aspx
- KPPSRA registered schools: https://www.psra.gkp.pk/public/registers
- Balochistan EMIS school search: https://emis.gob.pk/views/Reports/Reports/SchoolSearchPublic.aspx
- ICT-PEIRA: https://peira.gov.pk/
- AJK E&SE: https://ese.gok.pk/
- GB EMIS school details: https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details
- NAVTTC partner institutes: https://navttc.gov.pk/partner-institutes/
- NAVTTC registration: https://navttc.gov.pk/registration/
- NAVTTC affiliation/QABs: https://navttc.gov.pk/affiliation/
- Punjab HED public colleges: https://hed.punjab.gov.pk/public_colleges_list
- Punjab HED private colleges: https://hed.punjab.gov.pk/private_col
- Sindh government colleges: https://college.sindh.gov.pk/government-colleges
- B-TEVTA directory: https://registration.btevta.gob.pk/portal/directory
- AJK TEVTA institutes: https://www.tevta.gok.pk/AJK%20TEVTA%20Institutes.html

**Review date:** 2026-11-16. Recheck before any future source authorization; public availability, counts, terms and page structure can change.
