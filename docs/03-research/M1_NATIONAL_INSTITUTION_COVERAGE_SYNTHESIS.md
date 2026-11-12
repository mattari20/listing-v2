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
