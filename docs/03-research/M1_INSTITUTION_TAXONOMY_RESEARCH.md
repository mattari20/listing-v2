# M1-S02 — Pakistan Institution Taxonomy and Coverage Research

**Status:** Initial independent desk-research baseline; not an approved final taxonomy.  
**Prepared:** 2026-11-12  
**Scope:** Institution/provider categories and geographic coverage for eStudent Institutes V2.  
**Independence:** This work is based on current V2 requirements and independently consulted public sources. No legacy repository material, data or implementation patterns were used.

## 1. Purpose

Establish a defensible starting classification for education providers that students may need to discover and compare in Pakistan. The taxonomy must distinguish the provider itself, its campuses, the education/programme level it offers, and the body that recognizes, regulates, examines, accredits or awards its qualifications. These are related but are not interchangeable concepts.

## 2. Source-derived landscape

- The Ministry of Federal Education and Professional Training lists distinct national bodies and departments including HEC, FDE, FBISE, IBCC, PEIRA and NAVTTC. This supports treating school education, higher education, board coordination, ICT private-school regulation and technical/vocational training as distinct parts of the landscape. [MoFEPT — Organizations/Departments](https://www.mofept.gov.pk/Detail/NWNmYmVjMmQtODM1Yy00Y2RjLWE1YjEtYjYwZjVkODBlYWU4)
- NAVTTC describes a TVET ecosystem involving federal and provincial authorities, technical education boards, trade testing boards and qualification-awarding bodies. Its affiliation information makes clear that an institute and the body awarding/assessing a qualification may be different entities. [NAVTTC — TVET Sector](https://navttc.gov.pk/tvet-sector/) · [NAVTTC — Institute Affiliation](https://navttc.gov.pk/affiliation/)
- Skilling Pakistan publishes a searchable institute inventory with fields including ownership, institute type and district, and describes geographic and public/private distribution. This is a useful independent source for testing coverage fields, not automatic authorization to copy or republish its data. [Skilling Pakistan — Institutes](https://skillingpakistan.gov.pk/institutes)
- Nuffic's Pakistan education-system overview distinguishes schools, examination boards, universities, degree-awarding institutions and affiliated colleges. It also notes that an affiliated college may teach students while a university awards the qualification. Its board recognition list is dated and must not be treated as a current complete register. [Nuffic — Educational institutions and study programmes](https://www.nuffic.nl/en/education-systems/pakistan/educational-institutions-and-study-programmes)
- The Ministry's overview describes federal coordination alongside provincial/area responsibilities, which cautions against assuming a single national operational regulator for every provider category. [MoFEPT — Overview](https://www.mofept.gov.pk/Overview)

## 3. Provisional provider taxonomy

The following is a V2 research proposal for classification and discovery. It is not a claim that every category has one national regulator or one uniform recognition process.

| Top-level category | Candidate subtypes | Qualification / level examples | Key distinction to preserve |
|---|---|---|---|
| School education | Primary, middle, secondary/high, higher-secondary school | Primary to grade 12; SSC and HSSC pathways | School/provider is distinct from the examination board |
| College and intermediate | Intermediate college, degree college, commerce college, affiliated college | HSSC, associate or undergraduate pathways where authorized | Teaching campus/provider may be affiliated to a separate degree-awarding university |
| University and degree-awarding | Public/private university, degree-awarding institute, specialized university | Undergraduate, postgraduate and research degrees | Institution recognition and campus/programme status must be separately evidenced |
| Technical and vocational | Technical institute, polytechnic, vocational training institute, skills centre, trade training provider | Certificates, diplomas, competency-based and trade qualifications | Record relevant provincial authority, QAB, assessment and certification relationships separately |
| Professional and specialized | Medical/health sciences, engineering, teacher education, agriculture, arts/design and other specialist providers | Professional or specialist qualifications | Relevant professional council/accreditor may be separate from HEC or an examination board |
| Non-formal and alternative | Non-formal basic education, adult literacy, community learning, distance/open learning | Basic learning, equivalency or flexible pathways | Recognition, equivalency and provider status require category-specific verification |

### Cross-cutting attributes

Do not encode these as mutually exclusive institution types:

- **Ownership/sector:** public, private, non-profit/charitable, other/unknown.
- **Gender access:** boys/male, girls/female, co-educational, other/unknown; use only when reliably sourced.
- **Delivery mode:** on-campus, distance/online, blended, multiple/unknown.
- **Geography:** country, province/territory/administrative area, district, city/locality, address and coordinates where verified.
- **Education stage:** primary, middle, secondary, higher-secondary, undergraduate, postgraduate, technical/vocational, professional, non-formal.
- **Institution relationship:** independent provider, constituent campus, affiliated college, branch campus, franchise/partner or other relationship; only assert when evidenced.

## 4. Recognition, affiliation and awarding-body model

V2 should represent distinct relationships rather than one ambiguous “recognized” flag:

1. **Provider identity:** the organization operating the institute.
2. **Campus identity:** a physical or online delivery location belonging to, or affiliated with, a provider.
3. **Regulatory/registration relationship:** authority and registration status, scope, effective dates and evidence.
4. **Affiliation relationship:** the institution/campus and the affiliating university, board or awarding body.
5. **Programme approval/accreditation:** the exact programme, campus, mode and applicable period.
6. **Examination/assessment relationship:** body conducting examinations or competency assessment.
7. **Awarding relationship:** entity issuing the qualification.

A provider may have different relationships for different campuses and programmes. Never infer approval of every programme or campus from recognition of the parent institution. Store the evidence source, checked date, validity period where published, and unresolved status. Use labels such as “not yet verified” rather than implying unrecognized when evidence is merely missing.

## 5. Geographic coverage proposal

- Model Pakistan-wide coverage while allowing phased onboarding by province/territory and district.
- Keep administrative geography separate from free-text postal address.
- Store source-provided district/city labels and a normalized geographic reference only after validation.
- Treat coordinates as optional, source-attributed and subject to quality checks.
- Report coverage by provider category, ownership, province/territory and district; show missing coverage instead of implying no providers exist.
- Do not claim comprehensive national coverage until a dated, source-backed coverage assessment supports it.

## 6. Initial V2 inclusion principles

Include a provider in the discovery model when there is sufficient evidence of an identifiable education or training service and a location or delivery mode relevant to learners. Maintain separate status for:
- Listed candidate — identity/location evidence exists.
- Officially registered/recognized — authoritative evidence found for the relevant scope and date.
- Affiliated — relationship and scope evidenced.
- Programme verified — programme-specific evidence found.
- Under review — conflicting, incomplete or stale evidence.
- Excluded/closed — reliable evidence supports exclusion or closure.

Do not convert a directory listing into a recognition claim. Do not merge similarly named providers without identity evidence. Keep source records and provenance for every material claim.

## 7. Open questions for further independent research

- Exact current school and college subtypes and the relevant provincial/territorial registration systems.
- Current HEC institution and campus recognition records and their update semantics.
- Professional councils and programme-level accreditation by discipline.
- Provincial/territorial TVET authorities, QABs and qualification frameworks, including current scope.
- Non-formal, religious, distance and international curriculum providers: inclusion and verification rules.
- Administrative geography reference and source licensing for national district/city coverage.
- Legal and contractual rights for reuse, storage, display and refresh of each candidate source.

## 8. Limitations and next evidence

This is an initial desk-research baseline, not a complete national inventory or legal opinion. Public webpages can change; some sources publish only part of the provider landscape. Nuffic's board list is historical and used only to illustrate structural distinctions. NAVTTC's current pages are useful for the TVET relationship model but do not establish the full scope of every provincial provider. Before finalizing the taxonomy, create a source-by-source register with access method, coverage, update cadence, rights, provenance and verification procedure.

## 9. Acceptance criteria

- [ ] Owner-approved provider categories and inclusion/exclusion boundaries.
- [ ] Provider, campus, programme, regulator, affiliation, assessment and awarding-body concepts remain distinct.
- [ ] Coverage dimensions and normalization rules are defined.
- [ ] Current official source inventory is verified for each category and jurisdiction.
- [ ] Rights and provenance are assessed before any data ingestion or republication.
- [ ] Gaps, stale sources and uncertain recognition claims are explicitly represented.
- [ ] No legacy-derived taxonomy, data or implementation pattern is used.
