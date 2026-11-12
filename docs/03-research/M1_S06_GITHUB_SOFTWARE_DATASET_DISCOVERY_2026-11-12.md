# M1-S06 — Independent GitHub Software and Dataset Discovery

**Status:** Research baseline delivered; owner acceptance pending  
**Prepared / checked:** 2026-11-12  
**Repository:** `mattari20/listing-v2`  
**Independence:** No Listing V1 or legacy repository, code, schema, data, operational findings or configuration was used.  
**Boundary:** Metadata/public documentation review only. No repositories were cloned, downloaded, executed, forked, imported or connected.

## 1. Purpose

Identify independent software and dataset projects that may inform Listing V2 product research, geographic reference data, institution discovery, programme/admissions presentation, data quality and future integration options.

Discovery is not endorsement. GitHub public visibility, stars, a README, a repository-level license, an API or a downloadable file does not by itself establish authenticity, security, completeness, currentness, accuracy, rights in upstream content or suitability for commercial use.

## 2. Findings at a glance

The search found useful comparative patterns but no independently verified, complete Pakistan-wide institution dataset or ready-to-adopt Pakistan education-directory application.

The strongest immediate research value is:
1. **UniSearch** — a useful university-discovery and admissions comparison product reference; its repository description emphasizes official-source provenance and program/applicant-cycle scope. Code is described as MIT-licensed, but data, names, images and other third-party materials require separate rights review.
2. **ASER Pakistan Data Explorer** — a Pakistan-specific example of page-cited education statistics, extraction validation and explicit comparability caveats. Its code is MIT, but the underlying ASER/ITA data and reports are expressly not covered by that code license.
3. **Pakistan Administrative Divisions** — a potentially useful geography reference under a declared CC BY 4.0 license, subject to independent verification of authority, boundaries, identifiers, coordinate provenance and accuracy before any use.
4. **Pakistan Open Data Portal mirror** — a discovery lead for education datasets, not an authoritative dataset source or approved connector. Its claimed portal/API and license metadata must be verified against the original publisher and each dataset.

India-focused projects are useful only as comparative patterns; they are not candidates for importing Pakistani institution records.

## 3. Candidate register

| ID | Candidate | Publicly described purpose / relevance | Initial disposition | Main limitations |
|---|---|---|---|---|
| SW-01 | [UniSearch](https://github.com/mukhammedsh/unisearch) | University discovery, map/list browse, comparison, programme/admission requirements, costs and funding; facts are described as tied to official university sources and applicant routes/cycles | **Pattern reference only; further review candidate** | Repository describes MIT code licensing, but this does not license university facts, logos, photographs, source documents or data supplied by third parties. No code audit or independent coverage verification performed. |
| SW-02 | [schoolfinder](https://github.com/sauravhathi/schoolfinder) | Next.js school finder for India with search by name, state and district | **Do not import at present** | Public repository listing showed no root LICENSE among the displayed files; license not established. India-only scope. No security, dependency or data provenance audit performed. |
| SW-03 | [Global-School-List](https://github.com/NanduBit/Global-School-List) | Manually assembled global list of 22,000+ institutions with names and domains | **Exclude from reuse pending rights and quality evidence** | No clear license surfaced; author describes manual collection and says the list is not complete. No provenance/verification or reuse authorization established. |
| DS-01 | [ASER Pakistan Data Explorer](https://github.com/lcrawfurd/aser-pakistan-explorer) | Pakistan learning/enrolment indicator explorer; page-cited values, validation checks, comparability notes and source links | **Statistical research reference only; no data import** | Repository says it is independent and not an official ITA/ASER product. The MIT code license does not cover ASER data or reports; raw child-level data is not used. Learning indicators are not an institution directory. |
| DS-02 | [Pakistan Administrative Divisions](https://github.com/open-admin-data/pakistan-administrative-divisions) | Bilingual administrative hierarchy with province/district/tehsil records, JSON/CSV/NDJSON, schema and geographic fields | **Conditional geography-reference candidate; not yet approved** | Repository declares CC BY 4.0 and an update date, but source lineage, official authority, boundary version, coordinate accuracy, postal-code coverage and corrections require independent verification. Third-party linked assets are separate. |
| DS-03 | [Pakistan Open Data Portal mirror](https://github.com/wishshery/pakistan-open-data-portal) | React/Vite catalogue mirror describing education datasets and daily metadata synchronization from data.gov.pk | **Discovery pointer only; not an authoritative source or connector** | Repository claims 34 education datasets and an API/license model; these claims were not verified against the original catalog, individual dataset metadata, API terms or source-owner rights. Small public footprint; no code/security review. |
| DS-04 | [ADS Schools Data](https://github.com/learnram/ads-schools-data) | Large versioned India school dataset combining UDISE+, Cambridge and IB school-finder entries; Apache 2.0 declared at repository level | **Exclude as V2 data source; comparative QA pattern only** | India-only. Dataset itself is a multi-source compilation; upstream rights and terms must be assessed separately. README documents overlaps, omissions, status removals and lack of independent verification against schools. |
| DS-05 | [Indian Institutions Data](https://github.com/arpitagarwala/indian-institutions-data) | India higher-education institution data in JSON/CSV, reportedly derived from AISHE | **Comparative reference only** | Jurisdiction mismatch; repository-level license does not settle rights/terms for source AISHE material. No code or data review performed. |
| SW-04 | [Pakistan Educational Dashboard](https://github.com/M-Hassan-Maqsood/Pakistan-Educational-Dashboard) | Pakistan education statistics dashboard and an XLSX dataset | **Do not reuse** | Small project footprint; dataset provenance, license, methodology, validation, recency and security not established. Aggregate education indicators are not institution-level listing records. |

## 4. What can be learned without copying code or data

- Keep software-code licensing separate from dataset, image, logo, document and database rights.
- Model programme/admission facts with source links, publication/effective dates, observation dates, academic cycle, applicant category and correction history.
- Treat missing or unknown values as unknown, not zero or false.
- Keep institution identity and geographic hierarchy distinct from aggregate education statistics.
- Preserve original source wording and the source's own scope/status; do not infer recognition, current operation or admission availability from a directory row.
- Use validation notes and comparability flags for statistical series rather than presenting every year/territory as directly comparable.
- Maintain a takedown/correction path and a source-by-source provenance record.
- Do not use India-specific records to fill Pakistan coverage gaps.

## 5. Research method and limits

Searches covered public GitHub repository descriptions/readmes for institution finders, university discovery/admissions comparison, Pakistan education datasets, administrative geography and education dashboards. Candidate descriptions and README claims are treated as unverified third-party statements unless separately confirmed.

This is not an exhaustive GitHub census, package-registry review, code audit, vulnerability scan, benchmark, license opinion or due-diligence certification. No repository was cloned or executed. No dependency manifests, commit history, release signatures, CI workflows, security advisories or runtime behavior were tested.

## 6. Weighted task register

| Task | Weight | Completion | Evidence / remaining limit |
|---|---:|---:|---|
| T01 Define discovery categories and screening criteria | 10% | 100% | Scope and relevance categories documented |
| T02 Discover institution-directory and search software | 20% | 100% | SW-01 to SW-04 screened at public metadata/README level |
| T03 Discover datasets and geography/statistics references | 20% | 100% | DS-01 to DS-05 screened at public metadata/README level |
| T04 Assess Pakistan relevance and transferability | 15% | 100% | Pakistan-specific vs comparative-only distinctions recorded |
| T05 Record source provenance, quality and coverage caveats | 15% | 100% | Candidate limitations and non-authoritative claims recorded |
| T06 Rank candidates and document exclusions | 10% | 100% | Dispositions and next-review conditions recorded |
| T07 Consolidate recommendations and owner review | 10% | 0% | Owner acceptance pending |
| **Total** | **100%** | **90%** | Weighted desk-research baseline; no implementation or import |

## 7. Recommendation

Do not adopt a third-party institution directory or copy its code/data as the foundation of V2. Use UniSearch and schoolfinder only as product-pattern references after a separate code/security/license assessment. Keep ASER as an optional future source of clearly attributed aggregate learning indicators only if ITA's data terms permit the intended use. Evaluate Pakistan Administrative Divisions as a low-priority geography reference after validating against competent official boundaries and confirming the dataset's provenance. Treat the Pakistan Open Data mirror as a catalogue discovery aid only; verify every dataset at its original publisher.

## 8. Research sources

- UniSearch repository: https://github.com/mukhammedsh/unisearch
- schoolfinder repository: https://github.com/sauravhathi/schoolfinder
- Global School List: https://github.com/NanduBit/Global-School-List
- ASER Pakistan Explorer: https://github.com/lcrawfurd/aser-pakistan-explorer
- Pakistan Administrative Divisions: https://github.com/open-admin-data/pakistan-administrative-divisions
- Pakistan Open Data Portal mirror: https://github.com/wishshery/pakistan-open-data-portal
- ADS Schools Data: https://github.com/learnram/ads-schools-data
- Indian Institutions Data: https://github.com/arpitagarwala/indian-institutions-data
- Pakistan Educational Dashboard: https://github.com/M-Hassan-Maqsood/Pakistan-Educational-Dashboard

**Checked:** 2026-11-12. Repository content, release state, licenses and source terms can change; re-check before any future decision.
