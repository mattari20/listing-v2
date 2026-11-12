# M1-S07 — Source Rights, Licensing, Privacy and Security Assessment

**Status:** Assessment baseline delivered; owner acceptance pending  
**Prepared / checked:** 2026-11-12  
**Repository:** `mattari20/listing-v2`  
**Relationship:** Joint research with M1-S06; this document assesses discovered GitHub candidates and establishes the project-wide gate for the M1-S02–S05 education-source registers.  
**Decision boundary:** No source is approved for collection, scraping, bulk download, republication, ingestion, connector activation or commercial reuse by this assessment.

## 1. Executive determination

The current evidence supports a **deny-by-default, source-and-asset-specific approval process**. A repository's public visibility, a source's public webpage, a robots.txt allowance, an API endpoint, a GitHub license badge, an open-data portal account or a third-party compilation does not by itself grant V2 the rights needed to collect, store, transform, display, redistribute or commercially exploit all included content.

The key distinction is between:
1. **software code** (repository license and dependency licenses);
2. **dataset/compilation** (dataset-specific license and database/compilation rights);
3. **underlying source content** (government, regulator, institution, publisher, examination board or private-provider rights);
4. **media and marks** (logos, photographs, prospectuses, brochures, maps and trademarks);
5. **personal/confidential information** (student/applicant/staff contact and identity data, credentials, restricted microdata); and
6. **access terms** (website terms, API terms, rate limits, authentication, permitted purposes and contractual restrictions).

A permissive code license does not automatically license the data packaged with the code. A license declared by a third-party data compiler does not necessarily bind upstream owners' data. A public record or RTI-accessible record is not automatically a blanket commercial reuse license.

## 2. Pakistan legal and policy context — desk research only

### 2.1 Copyright and compilations

The Copyright Ordinance, 1962 is the national copyright framework. The public text includes a distinction that copyright in a compilation does not extend to the underlying data or material itself, while expressly preserving any copyright that may subsist in the underlying data/material. Therefore, a repository compiler's license cannot be assumed to extinguish upstream rights in source documents, photographs, logos, text, or data.

Reference: Pakistan Code / Copyright Ordinance, 1962: https://pakistancode.gov.pk/pdffiles/administrator5d255d1f44b50b65d6a3e87a2e0d3fee.pdf and https://www.tipp.gov.pk/site/display/611

### 2.2 PBS data dissemination policy — narrow institutional scope

PBS's current data-dissemination webpage describes open licensing for specified PBS products and a four-tier access framework. It expressly concerns PBS-produced official statistics and related products; it must not be generalized to HEC, provincial EMIS, school regulators, universities, private institutions or other data owners. The linked August 2026 PDF is surfaced as a consultation draft by the search index and contains proposed approval stages; its formal adoption/status should be checked before treating every provision as binding. The published webpage and linked PDF therefore require status/version reconciliation.

PBS page: https://www.pbs.gov.pk/data-dissemination/  
Linked August 2026 PDF: https://www.pbs.gov.pk/wp-content/uploads/2020/07/policy.pdf

The PBS material also distinguishes open aggregate products/public-use files from licensed scientific-use files and non-disseminable assets, and flags block-level/geospatial/census operational data as restricted. This reinforces that access classification is product-specific and that precise coordinates or detailed records should not be assumed open.

### 2.3 Open Data Pakistan

Open Data Pakistan's own guidance says data should be legally and ethically acquired, properly sourced and explicitly licensed; its terms also describe privacy classifications and takedown handling for third-party data. These are useful governance principles, but ODP's portal terms or example license guidance do not grant rights over unrelated source datasets.

References:
- https://opendata.com.pk/pages/making-data-open-legally
- https://opendata.com.pk/pages/terms-of-service
- https://opendata.com.pk/pages/guidelines

### 2.4 No blanket permission inference

The following are explicitly rejected as sufficient permission:
- a source is visible without login;
- a source can be downloaded manually;
- a website has an API or public search page;
- a government body is subject to RTI;
- a third-party repository includes a LICENSE file;
- the source is described as open data by a different organization;
- an unrelated PBS or portal policy is published; or
- the source's robots.txt permits crawling.

Source-specific legal terms, authority, access conditions and data sensitivity must be established for the exact asset and intended use. This is a research assessment, not legal advice.

## 3. Candidate rights and security dispositions

| Candidate | Code/data license evidence | Upstream/source-rights issue | Security / quality status | Decision |
|---|---|---|---|---|
| UniSearch | Repository describes MIT for software code | University facts may be sourced from official sites; university names, logos, photos and source documents are separately owned/not covered by code license | No code audit, dependency review, provenance validation or current maintenance assessment performed | Pattern reference only. Do not copy code/data until full repository, dependency, asset and upstream review |
| schoolfinder | No clear license established from the displayed root listing | India source-data lineage and reuse terms not established | No dependency/security/maintenance audit | Do not import |
| Global-School-List | No clear license surfaced | Manually gathered global institution data; source-by-source rights/provenance unknown | Incomplete and unverified by the publisher's own description | Exclude from reuse |
| ASER Pakistan Explorer | Repository identifies MIT for code; its README explicitly says ASER/ITA data and reports are not covered by that license | ASER reports/data belong to ITA/ASER Pakistan; raw child-level data is not used by the explorer | Strongly documented extraction checks and comparability caveats in README, but independent project with small public footprint; no security audit | Do not import data. Link to official ASER publications or seek explicit ITA terms for any intended reuse |
| Pakistan Administrative Divisions | Repository declares CC BY 4.0 for its dataset | Need validate provenance and whether every embedded/linked asset is covered; do not infer official government endorsement | No independent validation of geographic correctness, boundaries, postal codes or coordinate provenance | Conditional candidate for non-sensitive administrative reference only after quality and rights confirmation |
| Pakistan Open Data Portal mirror | Repository claims MIT code and Open Government Data Licence Pakistan v1.0 for data | Must verify original data.gov.pk record, publisher, dataset-specific license, API terms and upstream rights; mirror's own claims are not conclusive | Small public footprint; no security audit or verification of daily sync/API claims | Discovery pointer only; no connector or dataset ingestion |
| ADS Schools Data | Repository declares Apache 2.0 | Dataset aggregates UDISE+, Cambridge and IB sources; the repository license does not establish upstream authority to relicense every record | README documents duplicates, missing records, status changes and no direct school-level verification | India-only; comparative QA pattern, not V2 source |
| Indian Institutions Data | Repository includes a LICENSE file, exact license not confirmed in this review | AISHE source terms and dataset rights require separate assessment | One-commit repository shown in search result; no security/quality review | Comparative-only; do not import |
| Pakistan Educational Dashboard | License not established | XLSX dataset provenance and rights unknown | Limited repository activity; no methodology, validation or security audit | Do not reuse |

## 4. Mandatory rights assessment record for every source asset

Before any future collection or display decision, create one record per source/asset with:

1. Source owner, publisher, competent authority and contact channel (recorded only from official public material).
2. Exact asset: webpage, directory, API, dataset, table, PDF, image, map, code repository or data export.
3. Canonical URL, access date, version/publication date and checksum/version identifier where lawfully obtained.
4. Legal basis and exact license/terms URL, version and effective date.
5. Whether license covers code, database/compilation, individual fields, documents, photos, logos and derived outputs separately.
6. Permitted acts: view, query, automated access, cache, download, store, normalize, geocode, transform, combine, display, attribute, redistribute, commercial use, API redistribution and AI processing.
7. Attribution, share-alike, notice, source-link, change-marking, non-endorsement, fee and sublicensing conditions.
8. Authentication, registration, API key, rate limits, anti-bot restrictions, contractual restrictions and withdrawal/takedown requirements.
9. Personal data, sensitive fields, minors, staff contacts, private addresses, exact coordinates and disclosure/re-identification risk.
10. Data provenance, upstream licensors, collection method, accuracy, completeness, freshness, correction mechanism and retention expectations.
11. Decision owner, reviewer, approval date, scope, conditions, expiry/review date and evidence links.

A rights decision must be asset-specific and purpose-specific. If terms are silent, contradictory, unclear, or do not cover the intended act, mark **HOLD — PERMISSION/LEGAL REVIEW REQUIRED**. Do not infer permission.

## 5. Mandatory software supply-chain review before any code reuse

For each software candidate or dependency considered for future adoption:

- Verify the canonical upstream repository and maintainer identity; distinguish official project from forks and mirrors.
- Inspect the exact license and notices, all direct/transitive dependencies, vendored code, generated assets and data files.
- Check maintenance recency, release history, issue/PR responsiveness, governance, bus factor and ownership transfer signals.
- Inspect package manifests and lockfiles; pin versions and hashes where feasible.
- Review CI workflows for untrusted pull-request execution, secret exposure, excessive token permissions, unsafe shell interpolation, dependency confusion and artifact tampering.
- Review installation scripts, build steps, binaries, obfuscated code, network calls and access to environment variables, credentials or filesystem secrets.
- Check vulnerability advisories, SBOM, dependency scanning, static analysis, tests, signed releases and build provenance/attestations.
- Evaluate authentication, authorization, input validation, output encoding, SQL/query safety, file upload handling, SSRF, CSRF, XSS, rate limiting, logging and privacy.
- Run tests and security analysis only in an isolated sandbox after explicit approval; never run unknown install/build scripts in a privileged or production environment.
- Record exceptions, mitigations, accepted residual risk and owner approval before inclusion.

OpenSSF's concise OSS evaluation guide recommends checking necessity, authenticity, version stability, dependency management, branch protection, security audits, malicious-code indicators and sandbox testing. OpenSSF Scorecard covers maintenance, vulnerabilities, license, security policy, CI, branch protection, code review, dangerous workflows, pinned dependencies and token permissions. GitHub's dependency review can expose dependency changes, vulnerabilities and license information. These are assessment aids, not a guarantee of safety.

References:
- https://github.com/ossf/wg-best-practices-os-developers/blob/main/docs/Concise-Guide-for-Evaluating-Open-Source-Software.md
- https://scorecard.dev/
- https://github.com/ossf/scorecard
- https://docs.github.com/en/code-security/concepts/supply-chain-security/dependency-review
- https://docs.github.com/en/code-security/tutorials/implement-supply-chain-best-practices/securing-code

## 6. V2 data privacy and security minimums

- Do not collect or store student/applicant personal data merely because a source exposes it.
- Exclude applicant identities, CNIC/passport, phone/email, home addresses, credentials, private staff contact details and uploaded documents from institution discovery unless a separately approved, necessary and lawful purpose is established.
- Avoid precise coordinates for private residences, staff, applicants, shelters or other sensitive sites; institution-level coordinates require source and disclosure-risk review.
- Treat records involving minors as high sensitivity; do not expose student-level or household-level data.
- Keep Deeni Madaris hidden from all public listing/search/map/recommendation/count/sitemap/API surfaces by default under V2-DEC-006. A future owner-controlled Show Deeni Madaris setting defaults OFF. Do not create sect/maslak discovery filters or expose sensitive religious affiliation attributes.
- Keep source credentials, API keys, private exports and restricted datasets out of Git, logs, prompts and public artifacts.
- Use least privilege, secret management, audit trails, data minimization, retention/deletion rules, incident response and source takedown/correction workflows.
- Do not activate AI agents or connectors to collect data until their permitted scope, credentials, rate limits, output handling, provenance, privacy controls and human approval gates are documented.

## 7. Project-wide source decision states

| State | Meaning | Permitted activity |
|---|---|---|
| DISCOVERED | Source or repository found in desk research | Public metadata/terms review only |
| RESEARCH ONLY | Relevant candidate, rights/security unresolved | Read public documentation manually; no bulk collection or reuse |
| HOLD — RIGHTS | License/terms/authority unclear or conflicting | No collection, storage, display, transformation or redistribution |
| HOLD — SECURITY | Software/source has not passed required security review | No execution, integration or dependency adoption |
| CONDITIONAL | Explicit permission/license exists for a narrow asset and use | Only the approved fields, purpose, method, geography, retention and display |
| APPROVED | Authorized owner/reviewer approved documented rights and security evidence | Only within the recorded scope and review period |
| SUSPENDED / REVOKED | Terms changed, incident, takedown or owner withdrawal | Stop affected processing; follow deletion/retention and incident rules |

No M1-S02–S06 source is upgraded to APPROVED by this document. The narrow SED Balochistan headline/district aggregate permission previously documented in the source register remains limited to its exact stated scope and is not extended to underlying records or other source families.

## 8. Weighted task register

| Task | Weight | Completion | Evidence / remaining limit |
|---|---:|---:|---|
| T01 Establish rights, access and asset taxonomy | 15% | 100% | Code/data/upstream/media/personal-data distinctions documented |
| T02 Review Pakistan legal and policy context | 15% | 100% | Copyright Ordinance, PBS and ODP references reviewed with scope caveats |
| T03 Assess S06 candidate license claims and upstream rights | 20% | 100% | Candidate dispositions recorded; unresolved items held |
| T04 Define source-by-source rights evidence record | 15% | 100% | Required metadata and approval fields specified |
| T05 Define software supply-chain/security assessment | 15% | 100% | OpenSSF/Scorecard/GitHub review controls documented |
| T06 Define privacy, sensitive data and source restrictions | 10% | 100% | V2 privacy and Deeni Madaris visibility controls reaffirmed |
| T07 Owner review and acceptance | 10% | 0% | Owner acceptance pending |
| **Total** | **100%** | **90%** | Assessment baseline complete; unresolved permissions remain HOLD |

## 9. Conclusions and next gates

1. No discovered third-party repository or dataset is approved for import.
2. UniSearch and schoolfinder may inform future product-pattern research only; software adoption requires a separate code/security review.
3. ASER data, private-provider directories, regulator records, institution prospectuses, photos/logos and maps require their own rights decisions.
4. Pakistan Administrative Divisions is a conditional low-risk geography reference, not a verified official boundary authority.
5. Pakistan Open Data mirror records are leads; validate each dataset at its original publisher and its own license.
6. No automated collection, scraping, bulk download, source-owner contact, permission request, connector activation or code execution was performed.
7. M1-S07 acceptance would approve the assessment framework and dispositions only. It would not authorize any source collection or use.

**Checked:** 2026-11-12. This is not a legal opinion, security audit, penetration test or certification.
