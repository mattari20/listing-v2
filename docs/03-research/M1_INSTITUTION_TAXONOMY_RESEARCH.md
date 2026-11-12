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

## 3A. Expanded institution-family taxonomy and inclusion boundary (2026-11-12)

The provisional top-level taxonomy should be interpreted as a discovery taxonomy, not a regulatory classification. Add these explicit subfamilies:

- **Professional/regulated programmes:** medicine and dentistry; nursing and midwifery; pharmacy and pharmacy-technician education; engineering; computing; technology; teacher education; business education; architecture/town planning; veterinary education; allied health; homeopathy and Tibb; law and other council-regulated qualifications. The relevant council may approve a programme, institution, campus, intake or individual professional; those are different scopes.
- **School provider sub-registers:** government/public schools; private registered schools; community schools; special-education institutes; and non-formal/adult-literacy centres. Maintain source jurisdiction and provider type rather than merging them into one undifferentiated school list.
- **TVET:** technical colleges/polytechnics, vocational institutes, skills centres, apprenticeship/trade providers, assessment centres and QABs. A QAB or assessment body is not itself automatically a training provider.
- **Alternative/faith-based providers:** religious seminaries/madaris and international-curriculum schools may be considered only as separately classified provider families with an identified competent registration/recognition/board authority and a verifiable institution-level record. Do not assume that curriculum affiliation or a board list is equivalent to statutory registration or programme approval.
- **Distance/open learning:** distinguish the degree-awarding institution from study centres, examination centres, franchise/partner locations and online-only delivery. Do not infer HEC campus recognition for every study centre.

### Authority and status dimensions must not be collapsed

HEC's current accreditation-council list is a useful discovery map, but the listed councils have different legal mandates and evidence granularity. NCEAC explicitly accredits specific computing degree programmes rather than whole institutions; PEC's engineering programme schedules distinguish accreditation levels and intake; NACTE exposes programme/shift/validity records; NBEAC exposes session-level status categories such as accredited, reaccreditation, under process and expired. These examples demonstrate why one boolean `recognized` field is insufficient.

### Inclusion/exclusion rule

Include a candidate provider when a verifiable institution identity and an education/training service can be evidenced, even if recognition is not yet verified; display candidate/listed status separately from official recognition. Exclude or defer records that are only an individual professional registration, an applicant dossier, a student list, a staff personal contact list, an unverified marketing claim, a staging/test sample or a non-institutional authority body. Keep adverse statuses contextual, time-bound and source-linked; do not label a provider fake/illegal solely from a stale or ambiguous record.

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

- [ ] Owner-approved provider categories and inclusion/exclusion boundaries — proposed categories and boundaries are now documented; owner approval remains pending.
- [ ] Provider, campus, programme, regulator, affiliation, assessment and awarding-body concepts remain distinct.
- [ ] Coverage dimensions and normalization rules are defined.
- [ ] Current official source inventory is verified for each category and jurisdiction.
- [ ] Rights and provenance are assessed before any data ingestion or republication.
- [ ] Gaps, stale sources and uncertain recognition claims are explicitly represented.
- [ ] No legacy-derived taxonomy, data or implementation pattern is used.


## Supplemental taxonomy clarification — Deeni Madaris and qualification relationships

Add Deeni Madaris as a distinct provider family, with a separate provider-registration relationship (DGRE) and potentially separate examining/awarding-body relationships. Keep four concepts distinct: (1) provider registration, (2) qualification-awarding-body recognition, (3) equivalence of a specific qualification, and (4) institution/campus/programme recognition or accreditation. IBCC explicitly states that recognition of a QAB does not automatically make every qualification it offers equivalent. Do not infer an individual madrasa's status from a wafaq listing or infer credential equivalence from the awarding body's recognition. Exclude DGRE's maslak/sect field from V2 institution attributes and filters; it is unnecessary for general provider discovery. See `M1_S02_ICT_PEIRA_MADARIS_QAB_REVIEW_2026-11-12.md`.

## Supplemental relationship taxonomy — examination boards and medical-faculty affiliation

Add explicit relationship types for examination/assessment-board jurisdiction and institution affiliation to a technical/secondary board. These relationships are not institution ownership, provider registration, programme accreditation or HEC recognition. Add Punjab Medical Faculty as a provincial allied-health/paramedical affiliation authority; its affiliated institute lists are distinct from HEC-recognized universities and professional registration of individuals. See `M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md`.

## Supplemental taxonomy clarification — affiliation and study-centre scope

HEC Institutional Affiliation Policy 2024 applies to recognized public-sector HEI affiliated colleges and approved study centres where regular classes are conducted, including centres operated under MoUs. Represent the relationship with a time-bounded affiliation/approval record linked to the affiliating DAI, college/campus/study centre and programme. Do not infer current affiliation from parent-university recognition. Preserve separate campus recognition, affiliated-college continuation, study-centre approval and programme accreditation states.