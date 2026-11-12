# M1-S02 — National Institution Coverage Synthesis

**Status:** Draft synthesis of the current independent official-source discovery baseline; review pending. This is not a complete national provider inventory, a final approved taxonomy, legal advice, or authorization to collect or republish data.  
**Prepared:** 2026-11-12  
**Inputs:** `M1_INSTITUTION_TAXONOMY_RESEARCH.md`, `M1_OFFICIAL_INSTITUTION_SOURCE_COVERAGE_MATRIX.md`, and `M1_SOURCE_RIGHTS_ACCESS_EVIDENCE_REGISTER.md`.  
**Independence:** Prepared from V2 owner requirements and independently reviewed public official sources. No legacy repository artifacts, data, implementation patterns or historical findings were used.

## 1. Purpose and decision boundary

This synthesis consolidates the current M1-S02 source-discovery work into a national view of institution sectors, jurisdiction coverage, authority relationships and evidence gaps. It is intended to support owner review and later M1 synthesis. It does not define an implementation schema or approve a source for ingestion.

A source being publicly visible does not prove completeness, current operating status, recognition, campus approval, programme approval, reuse permission or commercial-use rights. All candidate sources remain **RESEARCH ONLY** unless a separate, source-specific rights and owner-approval process is completed.

## 2. National sector and source-family view

| Sector / family | Identified official source families | Current evidence position | Main unresolved coverage questions |
|---|---|---|---|
| Universities and degree-awarding institutions | HEC recognised universities/DAIs, recognised campuses and affiliated-college information | National source family identified; university, campus and affiliated-college relationships are distinct | Current record-level status, campus identifiers, affiliated-college register completeness, effective dates, update cadence and directory-specific reuse terms |
| Medical and dental education | PM&DC recognised institutions and qualifications | National institution/programme source family identified | Current college/campus/session approval, seat validity, status history, correction route and reuse terms |
| Nursing and midwifery | PNMC recognised-institutes and programme routes | National source family identified; separate adverse/fake-institute information is visible | Record freshness, current programme approval, status definitions, source terms and separation from individual professional registration data |
| Pharmacy education | Pharmacy Council of Pakistan institution directory | National source family identified; examples of differing statuses are exposed | Meaning/effective dates of active, admission-stoppage and show-cause statuses; update cadence and reuse terms |
| Other professional education | PEC, NCEAC, NACTE and NCH source families | Official programme-specific accreditation or recognised-college sources identified | Other discipline councils remain to be researched; programme/campus/intake scope, validity dates, status semantics and terms require verification |
| Schools — Punjab | PEPRIS/private-school registration source | Official private-school source family identified | Public-school coverage requires separate sources; current status, district completeness, field-level freshness and reuse terms |
| Schools — Khyber Pakhtunkhwa | KP-PSRA regulator portal and district-register leads | Official private-school regulatory source family identified; mandate reviewed | Canonical current register, public-school coverage, district completeness, per-record freshness and reuse terms |
| Schools — Sindh | RSU/SEMIS, school profiles, annual school census and geotagging routes | Official source family identified; portal navigation reviewed | Public/private coverage, dataset-level access, coordinate precision, update date and reuse terms |
| Schools — Balochistan | SED/EMIS school search and open-data leads | Official source family identified | Exact canonical dataset, license, public/private coverage, field dictionary and freshness |
| Schools — ICT | ICT-PEIRA registered-institutions list and renewal-pending category | Official private-school register identified; weekly publication cadence stated by PEIRA | Weekly publication statement is not a per-record timestamp; public-school coverage, renewal-pending semantics and reuse terms |
| Schools — AJK | AJK E&SE private-institute/census source leads; BECS community-school list | Official source families identified for private and community-school segments | Complete public-school register and all-district coverage remain unverified; do not infer comprehensive coverage from BECS |
| Schools — Gilgit-Baltistan | GB EMIS school-details dashboard | Official school-level source identified with district/tehsil/cluster fields | Public/private scope, all-district coverage, data dictionary, record freshness and reuse terms |
| TVET and vocational providers | NAVTTC TIS/NSIS/NVQF routes, NAC-TVS accreditation, provincial TEVTAs, QABs and Trade Testing Board Punjab | National and provincial source routes identified; provider registration, accreditation, QAB affiliation and assessment/certification are separate relationships | Validate each production directory, all provincial authorities, provider/trade-level status, assessment and awarding relationships, update cadence and source-specific reuse rights |
| Non-formal and alternative education | BECS/ALP and MoFEPT NFEMIS resource routes | Official programme/source leads identified | NFEMIS dataset access, geographic coverage, programme status, update cadence and whether the source represents a complete provider universe |
| Special education | Punjab Special Education Department and Sindh DEPD directories | Official institution/centre source families identified in two provinces | Other provincial/territorial sources remain unverified; distinguish institutions, centres and offices; minimize direct staff/personal contact data |

## 3. Cross-cutting modelling conclusions for owner review

1. **Provider, campus, centre and programme are separate entities.** A parent institution's status must not automatically be inherited by every campus, centre, branch or programme.
2. **Recognition and quality assurance are multi-dimensional.** Charter/registration, regulator recognition, campus recognition, programme accreditation, professional approval, affiliation, examination-board relationship, QAB affiliation, assessment authority and qualification-awarding authority must remain distinguishable.
3. **Status must be time-bound and source-attributed.** Preserve the exact status wording, issuing authority, scope (provider/campus/programme/trade/intake), effective/expiry dates where published, source URL and last-checked date. Do not normalize ambiguous states into a single “recognized” flag.
4. **Jurisdiction coverage is not yet complete.** All provincial/territorial school source families have at least an initial lead, but public/private completeness and current registers are not verified. Special-education discovery currently has only Punjab and Sindh source families.
5. **Sector coverage is uneven.** Professional education has several discipline-specific source families, but no complete cross-council inventory. TVET sources expose different registration, accreditation, affiliation, assessment and qualification relationships.
6. **Source discovery is not a lawful reuse decision.** Public access, a government mandate, an RTI request route or a searchable portal does not itself establish permission for automated collection, caching, normalization, republication or commercial reuse.
7. **Sensitive application and personal data is out of scope.** Institution discovery must not collect CNICs, personal identity documents, individual professional registration records, student records or applicant dossiers merely because they appear in a source workflow.

## 4. Source-quality and evidence confidence

| Evidence dimension | Current assessment | Acceptance work still required |
|---|---|---|
| Official-source identity | Several primary government/regulator source families identified | Confirm the current authoritative endpoint and source owner for each individual dataset |
| Geographic breadth | Initial leads exist for all provinces/territories in school education | Verify complete district coverage, public/private scope and separate sector registers |
| Sector breadth | Higher education, professional education, schools, TVET, non-formal and two special-education jurisdictions have leads | Close missing councils, special-education jurisdictions and provider-type gaps |
| Status semantics | Important distinctions have been identified in HEC, professional councils, PEIRA and TVET | Record exact status definitions, effective dates, expiry, appeals/renewal and record history source by source |
| Freshness | PEIRA states a weekly list publication cadence; NAVTTC publishes accreditation validity/renewal criteria | Obtain per-source/per-record timestamps or a defensible update schedule; do not infer freshness from page crawl dates |
| Rights and access | Dated public-terms reviews exist for selected sources; no directory-specific reuse permission has been established | Complete source-by-source terms, privacy, access, attribution and written-permission assessment; owner/legal decision remains necessary |
| Data quality and correction | Public directories vary in formatting, scope and aggregate consistency | Identify data dictionaries, correction channels, duplicate handling and conflicting-record resolution rules |

## 4A. Verification updates — 2026-11-12

The official-source review now confirms additional programme-level and jurisdiction evidence:

- HEC's current campus page displays 151 recognized campuses (96 public, 55 private) and separate institution, campus, affiliation, unaccredited and illegal/unrecognized routes. The aggregate is page-reported, not an independently audited national census.
- HEC's accreditation-council page identifies a broad professional/programme authority landscape. NCEAC explicitly accredits programmes, not institutions; PEC exposes engineering programme levels and intake; NACTE exposes teacher-education programme validity dates; NBEAC exposes session and status categories; NTC publishes programme accreditation criteria.
- PM&DC publishes public/private medical and dental college tables with seat allocations. PNMC's recognized-institute page appears old/irregular and requires freshness verification. PCP displays programme/seat/status data but search results include apparent geography anomalies requiring source confirmation. NCH's college list contains closed entries and personal principal contact details, which must not be republished.
- Punjab public-school discovery has a distinct OpenPunjab/PMIU route described as free/open/real-time and tied to School Census 2024–25; PEPRIS is a separate private e-license register with one-year license validity. KPPSRA district lists expose ACTIVE, BLOCKED and DORMANT statuses. Sindh RSU publishes annual school census profiles through 2024–25. Balochistan EMIS separates public-school search, private schools and NFE navigation.
- NAVTTC's production site distinguishes institute registration, QAB affiliation and NAC-TVS accreditation. Staging/test “representative sample” directory content is excluded as authoritative coverage evidence.

Additional professional-source checks identified Pakistan Bar Council recognized affiliated-college and recognized-university lists, and PVMC accredited/recognized institution/programme information. PBC records expose affiliation and recognition dates plus annual fee-status fields; PVMC displays programme periods and personal staff contacts. The latter must be excluded from institution discovery, and historical programme notes require current verification. PCATP, NCT, NAEAC and AHPC remain HEC-listed source-family leads without a verified complete current public register in this review. Sources: https://www.pakistanbarcouncil.org/legal-education/affiliated_colleges; https://www.pakistanbarcouncil.org/legal-education/pakistani_universities; https://www.pvmc.gov.pk/Detail/Y2I2YzBjMDItNTRiZS00NzE0LThhODYtMmQyM2U2ZWNkN2U0.

These observations increase confidence in source-family discovery, not in completeness or reuse rights. Every source remains research-only; page-level claims and aggregate totals are not treated as per-record freshness or permission.

## 5. Priority unresolved gaps

1. Verify the exact HEC campus and affiliated-college registers, including effective dates and current status.
2. Complete professional-council research beyond PM&DC, PNMC, PCP, PEC, NCEAC, NACTE and NCH; verify current programme/session status semantics.
3. Confirm public-school coverage and canonical source registers for every province/territory, with particular attention to AJK and public/private separation.
4. Expand special-education source discovery beyond Punjab and Sindh and establish institution-versus-centre definitions.
5. Validate each provincial TVETA, QAB and assessment/awarding relationship against its own current official source.
6. Identify exact NFEMIS and other non-formal dataset scope, geography, update date and access conditions.
7. Complete source-specific rights, privacy, freshness, correction and reuse assessment. No permission request or data collection is implied by this research.
8. Obtain owner review of the provisional taxonomy and national coverage gaps before marking M1-S02 accepted.

## 6. M1-S02 acceptance status

This document is a **draft national coverage synthesis** and supports the S02-C08 work item. It does not complete S02-C08 or S02-C09. S02 remains in progress until the evidence gaps above are addressed to the extent reasonably possible, the coverage matrix and source-rights register are reconciled, and the owner explicitly reviews and accepts the taxonomy, limitations and unresolved gaps.

## 7. Explicit exclusions

- No student survey, interview, recruitment or outreach; owner deferred pre-launch participant research.
- No scraping, bulk download, automated collection, connector activation, ingestion, population or republication.
- No source is approved for manual verification, bulk collection or commercial reuse by this synthesis.
- No application code, architecture selection, database schema/migrations, production access, deployment or cutover.
- No legacy repository material, data, architecture or process pattern is used.


## 7. Supplemental coverage and data-quality update — 2026-11-12

The supplemental source review adds a dated AJK private-institution register announcement and 2024–25 census guidance; clarifies Balochistan EMIS search fields and separate private-school/NFE navigation; and identifies NFEMIS as a national non-formal education dashboard/inventory source family. NFEMIS currently displays 20,862 schools on its dashboard while the 2026-09-21 inventory categories sum to 20,864. This two-record discrepancy must be reconciled and neither value is an independently verified national total. GB EMIS summary metrics currently display zero values, so no coverage count should be inferred from that dashboard. HEC PQR and its allied-health NOC list provide qualification-level and programme-specific evidence distinct from institution recognition. Historical KP special-education material is retained only as a lead, not as current register evidence.

The remaining national gaps are therefore narrower but still material: current public-school source coverage and record freshness in AJK; validated record-level coverage in Balochistan; functioning, dated GB EMIS records; current special-education directories across all jurisdictions; professional council registers and programme status; and source-specific terms/permissions. This supplement does not complete S02-C08 or authorize reuse. See [M1-S02 Supplemental Official-Source Coverage Review](M1_S02_SUPPLEMENTAL_SOURCE_COVERAGE_REVIEW_2026-11-12.md).


## 8. Professional-council and special-education update — 2026-11-12

The additional council review improves evidence for PCATP, NCT, AHPC and NTC. PCATP's 2025 annual report distinguishes programme states (accredited, pending NOC, on hold, revoked and closed); its September 2025 NOC-application list must not be mistaken for approval. NCT's FTJ and BEMS pages are separate recognition routes, with a disputed FTJ entry and personal contact data. AHPC's December 2025 public PDF is an applications list, not proof of recognition granted. NTC publishes zero/interim programme and intake-batch visit information; neither establishes final/current accreditation by itself. NAEAC remains a council identified by HEC, but a complete current public register was not verified.

The Ministry of Human Rights confirms DGSE's ICT-level special-education mandate, but the reviewed page is not an institute register. KP evidence remains historical; current complete registers for Balochistan, AJK and GB remain unverified. The new findings and source links are recorded in M1_S02_SUPPLEMENTAL_PROFESSIONAL_COUNCIL_SPECIAL_EDUCATION_REVIEW_2026-11-12.md. These additions do not complete S02-C03/C06/C07 or authorize source reuse.

## 9. Deep jurisdiction, special-education and TVET synthesis — 2026-11-12

New evidence strengthens special-education source discovery in Punjab (category counts and district centre list), Sindh (DEPD regional institution list) and GB (directorate mandate/facility leads), while revealing important limitations: Punjab service categories may overlap; detailed pages expose personal contacts; Sindh list requires province-wide completeness and freshness checks; GB location statements and event references need reconciliation; and Balochistan's 2026 Turbat/Zhob items are proposals rather than operational centres. A current complete special-education facility register remains unverified for Balochistan, AJK and ICT.

TVET evidence now includes KP-TEVTA's 33-institute aggregate and provider-type distinctions, STEVTA's region/district filter-driven institute list, a Punjab TEVTA 2024 PDF, and B-TEVTA's 16-record public directory. NAVTTC's overview cites 80+ B-TEVTA institutes, so the discrepancy requires scope reconciliation. NAVTTC's staging NAC-TVS directory explicitly uses representative sample data and is excluded from all evidence/counts. HEC Digital Library and PASTIC are secondary discovery sources, not recognition registers. Full source links, status semantics and rights limitations are in M1_S02_DEEP_JURISDICTION_SPECIAL_ED_TVET_REVIEW_2026-11-12.md.

These additions strengthen S02-C04/C05/C06 but do not prove national provider completeness, current record-level status, source reuse permission or owner acceptance.

## 10. ICT private education and Deeni Madaris coverage — 2026-11-12

ICT-PEIRA provides a paginated active-registration register for private educational institutions up to higher-secondary/equivalent level, with distinct active, renewal-in-process, renewal-awaited and unregistered statuses and a PEI-submitted-data disclaimer. This materially improves ICT private-school source coverage, while leaving independent verification and reuse rights unresolved. DGRE identifies a nationwide Deeni Madaris registration mandate with 16 regional offices, but the public regional lists located are dated March 2024 and require current freshness confirmation. IBCC recognizes specified QABs and madaris/wafaqs but explicitly says QAB recognition does not make every qualification automatically equivalent. Deeni Madaris are a distinct provider family; provider registration, awarding-body recognition and credential equivalence must remain separate. The DGRE maslak field is excluded from V2 institution discovery. See `M1_S02_ICT_PEIRA_MADARIS_QAB_REVIEW_2026-11-12.md`.

## 11. Examination boards, PMF and DGRE jurisdiction synthesis — 2026-11-12

IBCC's forum-member list identifies BISE, technical and other examination/assessment bodies; Punjab HED identifies nine provincial BISE boards; FBISE's older brochure illustrates cross-territorial jurisdiction but requires current legal confirmation. Punjab Medical Faculty publishes separate affiliated-institute lists for private, public under SHC&ME and other public providers. DGRE's regional jurisdiction map and 2024 registered-Madaris pages cover multiple territories, but their shared 2024 date, cross-province record anomalies and incomplete rows prevent a current complete-national-register claim. Add board jurisdiction, institution-board affiliation and PMF affiliation as distinct relationships; do not infer accreditation or equivalence from them. Full detail is in `M1_S02_EXAMINATION_BOARDS_PMF_DGRE_JURISDICTION_REVIEW_2026-11-12.md`.

## 12. HEC affiliation, study-centre and health-programme status synthesis — 2026-11-12

HEC's 2024 affiliation policy applies to affiliated colleges and approved study centres (including regular-class and MoU centres) and requires continuation to be notified by the respective DAI after HEC desk review. This requires explicit time-bounded relationships rather than deriving college approval from parent university recognition. HEC's affiliated-college PDF has apparent duplicate/variant rows and needs reconciliation. PM&DC seat allocations/court-order admission notes, PCP Active/Stoppage of Admissions statuses and PNMC's stale/irregular programme list demonstrate that admission permission, programme approval, seat allocation and institute listing are separate. Current session and legal basis must be retained. See the examination-board/PMF/DGRE review supplement.

## 13. National rights and privacy context — 2026-11-12

The data-rights review finds no blanket national open-data permission applicable to all education directories. MoITT's official register lists the National Data Governance Policy 2026 and Personal Data Protection Bill May 2023 as drafts. RTI is a record-access mechanism, not a universal reuse license. Copyright protection in a compilation and rights in underlying source material require separate consideration. PBS's explicit open license is limited to specified PBS products/tiers and does not extend to HEC, PEIRA, provincial EMIS, councils or TVET directories. Privacy minimization excludes learner/student, staff, personal contact, health/disability and unnecessary religious classification data. See `M1_S02_DATA_RIGHTS_PRIVACY_FRAMEWORK_REVIEW_2026-11-12.md`.

## 14. AJK, GB, Sindh and Punjab school coverage synthesis — 2026-11-12

AJK now has an official 6,019-school dashboard aggregate and distinct public/private census guidance, plus a private register dated November 2025; public record-level completeness and private registration status still need verification. GB source families are now separated into government-school EMIS details, BECS community schools (776, June 2025) and public colleges; the EMIS detail table also includes offices, while the summary dashboard's zero values remain unreliable for counts. Sindh's institution checker supports regional-to-UC filtering and detailed type/status fields, but no complete exported record set or reuse terms were established. Punjab PEPRIS lists valid eLicensed schools but its support page warns DEA-registered records may not yet be uploaded and describes CNIC/mobile search flows that must not be used for V2 data collection. Do not sum these unlike systems or infer completeness. See `M1_S02_AJK_GB_SINDH_SCHOOL_REGISTER_REVIEW_2026-11-12.md`.

## 15. Sindh private-school and KP registration status synthesis — 2026-11-12

Sindh private-school registration through DIRPIS/SPEI-EMIS is a separate provider stream from the public-school institution checker; older official criteria/TOR documents describe registered and unregistered providers and an explicit need for data updating, so current completeness remains unproven. KPPSRA's district register distinguishes ACTIVE, BLOCKED, DORMANT and CLOSED providers; these states must not be flattened to a binary active flag. Province-wide coverage requires all district routes and update scope verification. See the AJK/GB/Sindh school-register review.

## 16. School regulator status and source-terms synthesis — 2026-11-12

KPPSRA's current portal and 2026–27 notices establish active regulation of private schools, including registration/renewal and BISE de-affiliation notices; preserve registration separately from board affiliation. Sindh DIRPIS October 2026 safety notices are current regulatory activity, not a complete private-school register; older census documentation notes registered/unregistered providers and data-update needs. HEC Digital Library publisher-license terms are scoped to subscribed resources, not HEC institution directories. NAVTTC's 650+ accredited, 900+ quality-assured and 3,500+ ecosystem claims have different/unclear scopes and cannot be used as a single count. See `M1_S02_SCHOOL_REGULATOR_STATUS_TERMS_REVIEW_2026-11-12.md`.