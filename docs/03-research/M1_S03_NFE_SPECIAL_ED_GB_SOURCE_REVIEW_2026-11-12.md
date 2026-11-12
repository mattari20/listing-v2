# M1-S03 — NFE, Special-Education and Gilgit-Baltistan Official Source Review

**Review date:** 2026-11-12  
**Scope:** Additional official source verification for non-formal education, special education/rehabilitation, and Gilgit-Baltistan school/college provider routes.  
**Status:** Supplemental research evidence; M1-S03 remains in progress.  
**Independence:** V2 owner requirements and independently reviewed official public sources only.

## 1. National Non-Formal Education Management Information System (NFEMIS)

**Official route:** [NFEMIS](https://www.nfemis.net/)

NFEMIS describes itself as a national online database for non-formal education, supporting data from national level to classroom management. Its public site provides province/region and district filters, public dashboard summaries, and separate login access. Its stated data domains include schools/centres, learners, teachers, learning achievement, attendance, learner tracking, out-of-school children, monitoring and procurement.

**Important boundaries and findings**
- NFEMIS is a source for non-formal education provider/centre research, not a formal-school register and not a substitute for provincial EMIS.
- The system contains sensitive learner and teacher data domains, including learner profiles, teacher registration, attendance, assessment and tracking. V2 public provider research must not access or copy those personal/learner-level records.
- Public dashboard counts observed in different page loads/search snapshots vary materially (for example, school counts have appeared around 18,345, 19,179 and 20,864). No single stable as-of date was consistently attached to those changing headline figures in the pages reviewed. Do not use these values as a reconciled national NFE count.
- The dashboard's "schools" label should not be treated as a clean institution count without a data dictionary and category definition; the inventory includes NFE/ALP, adult and other centre categories.
- The page includes references to B-Forms for exam/marksheet processing. V2 must not collect child identifiers, B-Forms, learner names, enrolment details or student records.
- The source is public for high-level research, but its login, underlying data and reuse rights are separate. No public API or license authorizing V2 reuse of centre-level records was verified.

**Assessment:** Official national NFE source route observed; aggregate dashboard is dynamic and quality-limited; record-level access and rights remain unverified. **RESEARCH ONLY**.

## 2. Federal Directorate General of Special Education (DGSE)

**Official routes:** [DGSE portal](https://dgse.gov.pk/) and [Ministry of Human Rights DGSE mandate page](https://www.mohr.gov.pk/Detail/MzYzY2VkMzctMGZjYi00YjRhLWFiNDktMTA3ZDdjNWJiMTM3).

The DGSE portal currently identifies itself as the Directorate General of Special Education under the Ministry of Federal Education and Professional Training. It publishes centre/institution pages and current admissions notices, including a 2026–27 HSSC-I admissions notice. The Ministry of Human Rights page describes DGSE as an attached department transferred to MoHR in August 2019 and says that, following the 18th Amendment, DGSE functions at ICT level only.

**Authority discrepancy:** These official government pages do not present the same ministry attribution. The MoHR page also explicitly limits DGSE jurisdiction to ICT. The current administrative/ministerial placement and any subsequent transfer must be reconciled against current official notifications before using the ministry name as a definitive legal authority field. Do not infer national jurisdiction from a federal website domain.

**Provider classification:** DGSE pages include education centres as well as rehabilitation, training, mobility, library/resource and other service units. Not every listed unit is a school. Keep education institutions separate from non-school service units.

**Privacy boundary:** Admissions and service pages may involve disability, health, assessment, therapy, child and guardian data. V2 may research public institution names, service categories and locations only where lawfully public; do not collect learner identities, disability/diagnosis, medical/therapy details, admission forms or staff personal contacts.

**Assessment:** Official ICT special-education/service source family observed; mandate attribution discrepancy and scope require clarification. **RESEARCH ONLY**.

## 3. Sindh Department of Empowerment of Persons with Disabilities (DEPD)

**Official route:** [DEPD institution list](https://depd.sindh.gov.pk/institutions/).

The department publishes a regional list of special-education and rehabilitation institutions across Karachi, Hyderabad, Shaheed Benazirabad, Larkana, Mirpurkhas and Sukkur regions. The list includes special-education centres, rehabilitation centres, vocational training, employment/rehabilitation facilities and some regional offices.

**Data-quality/privacy findings**
- This is a useful public provider/service-location source, but it mixes schools/centres with rehabilitation, vocational, employment and administrative office units. Provider subtype must be preserved; do not classify every row as a school.
- The page includes staff names and personal mobile numbers. Those fields are explicitly excluded from the V2 provider register and must not be copied into public listings or internal research datasets.
- The page does not provide a clear dataset-wide as-of date, update cadence or reuse license.
- Some records may refer to service centres rather than formal education institutions. Their inclusion in the platform should depend on a clearly labelled provider subtype and student-facing relevance.

**Assessment:** Official regional institution/service list observed; partial source coverage and mixed provider types; personal contacts excluded. **RESEARCH ONLY**.

## 4. Gilgit-Baltistan public-school EMIS and college directory

**Official routes:** [GB EMIS school details](https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details), [GB EMIS portal](https://emis.gilgitbaltistan.gov.pk/), [Directorate of Education Colleges institutions](https://doecgb.gov.pk/institutions).

### 4.1 School details
The public EMIS school-details table exposes district, tehsil, cluster, school name/code and level. It contains record-level entries across districts, including government schools and some programme-labelled providers such as SAP and mosque schools.

The table also includes administrative office and directorate rows labelled with level "Office". Those are not education providers and must be excluded from any institution count or public listing. School-level duplicates, cluster-parent relationships, institution code uniqueness and operational status require separate validation. The summary dashboard has displayed zero-valued totals in the reviewed route; those zero summary values must not override the populated school-details table.

**Assessment:** Public record-level school route observed, but requires row-type filtering, duplicate checks and reconciliation with dashboard totals. **RESEARCH ONLY**.

### 4.2 Public colleges
The Directorate of Education Colleges publishes a public-sector college list with institution names and admissions links. The page describes the Directorate as responsible for college/higher-level education in GB. It is a useful official public-college source, but it does not establish complete public/private college coverage, current operational status for each institution or reuse permission. The page has no clear dataset-wide as-of date.

**Assessment:** Official public-sector college list observed; private-sector coverage and freshness remain open. **RESEARCH ONLY**.

## 5. AJK and cross-jurisdiction carry-forward gaps

The existing M1-S02 evidence remains the authoritative starting point for AJK: the Higher Education Department's official aggregate pages conflict on 178 versus 180 colleges, and the private-institution list announcement dated 5 November 2025 links to a file that prompts sign-in in the public review. The PEIRA portal route is login-only. These are not verified public record-level registers.

No new evidence in this pass resolves AJK private-school access, a complete current AJK public-school register, or the GB private-school register. These remain explicit gaps, not claims that providers do not exist.

## 6. Source classification and next verification

| Source | Source type | Coverage observed | Main limitation | Current disposition |
|---|---|---|---|---|
| NFEMIS | National NFE MIS and dynamic dashboard | National/region/district aggregate and centre-management system | Fluctuating headline counts; sensitive learner/teacher domains; record-level rights unclear | RESEARCH ONLY |
| DGSE | Federal/ICT special-education and rehabilitation authority | Institution/service pages and admissions notices | Government pages conflict on ministry attribution; mixed school and non-school units; ICT-only jurisdiction stated by MoHR | RESEARCH ONLY |
| Sindh DEPD | Provincial special-education/rehabilitation department | Regional institution/service list | Mixed service types, staff personal contacts, no clear as-of date/license | RESEARCH ONLY |
| GB EMIS | Provincial/territorial school MIS | Public school details table | Office rows mixed with school rows; dashboard zeros conflict with populated details; duplicate/status checks needed | RESEARCH ONLY |
| GB Directorate of Education Colleges | Public college directory | Public-sector colleges in GB | No complete private-college coverage or clear as-of date/license | RESEARCH ONLY |
| AJK E&SE / HED | Education department and HED source family | Aggregate and announced list routes | 178/180 aggregate conflict; private list access prompts sign-in; no complete public record-level inventory verified | PARTIAL / RESEARCH ONLY |

Next work should verify source owner/mandate, current register route, source identifiers, update/as-of dates, status definitions, public fields, terms/license and privacy risk for each jurisdiction. Do not access authenticated systems, scrape, download bulk data, or contact source owners under this step.

## 7. Official source pages reviewed

- NFEMIS: https://www.nfemis.net/
- DGSE: https://dgse.gov.pk/
- Ministry of Human Rights DGSE mandate: https://www.mohr.gov.pk/Detail/MzYzY2VkMzctMGZjYi00YjRhLWFiNDktMTA3ZDdjNWJiMTM3
- Sindh DEPD institutions: https://depd.sindh.gov.pk/institutions/
- GB EMIS details: https://emis.gilgitbaltistan.gov.pk/dashboard/schools/details
- GB Directorate of Education Colleges: https://doecgb.gov.pk/institutions

All routes reviewed on 2026-11-12. This note is research, not legal advice or source reuse permission.
