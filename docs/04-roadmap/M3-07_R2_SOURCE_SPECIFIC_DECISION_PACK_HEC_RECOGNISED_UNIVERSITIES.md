# M3-07 R2 — Source-Specific Decision Pack: HEC Recognised Universities/DAIs

**Prepared:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Work package:** M3-07 R2 — source-specific decision pack  
**Candidate:** GOV-04 / HEC Recognised Universities/DAIs  
**Status:** Assessment prepared; RESEARCH ONLY; no source access, reuse, retrieval or ingestion approval

## 1. Decision summary

This pack evaluates one exact candidate asset already documented in the accepted M1-S03 source research and consolidated by R1. The selected candidate is the Higher Education Commission (HEC) recognised universities/degree-awarding institutions (DAIs) public directory:

- **Publisher/authority:** Higher Education Commission of Pakistan
- **Canonical candidate asset:** https://www.hec.gov.pk/english/universities/pages/recognised.aspx
- **Source register:** GOV-04 in `M1_S03_OFFICIAL_PROVIDER_SOURCE_REGISTER_2026-11-12.md`
- **Jurisdiction:** Pakistan
- **Asset class:** HEC-controlled public institution-recognition directory
- **Decision purpose:** assess whether a narrowly scoped, institution-level recognition fact could be used in a future evidence-proposal workflow.

This is a desk assessment based on existing M1-S03 and R1 evidence. The source website was not accessed for this pack, no owner was contacted and no permission was requested. **The asset remains RESEARCH ONLY.**

## 2. Evidence already recorded

The M1-S03 register records HEC's mandate for recognition of universities/DAIs and separate recognised-campus, affiliation and approval routes. It describes public search/list pages with institution- and campus-level names/locations. It also records that recognition, campus recognition, college affiliation and programme accreditation are distinct concepts.

The R1 inventory records a limited public-page recheck on 2026-11-16 and cautions that page-displayed counts are snapshots, not a reconciled national census. The HEC campus page is a separate asset and is not included in this candidate.

**Evidence limitations:** the prior research does not provide a complete, current field-by-field capture specification for this exact directory page, a row-level data dictionary, a guaranteed update cadence, a record-level reuse license, or an approved retrieval method. Those unknowns remain unknown; this pack does not infer them.

## 3. Claim scope and exclusions

### Candidate claim

At most, a future verified record could support a claim of the form:

> HEC lists this named institution as a recognised university/DAI, according to the exact status and scope displayed by the approved source asset at the recorded observation time.

The claim must retain the source locator, observation time, any source-published effective/notification date, exact institution identity, the exact wording/status and the scope of HEC's recognition.

### Not supported by this asset alone

Do not infer or publish from this page alone:

- recognition of a separate campus, affiliated college, study centre or franchise;
- approval/accreditation of a particular programme, intake, batch or qualification;
- academic quality, ranking, teaching quality, outcomes or employability;
- current admissions, seats, eligibility, fees or programme availability;
- professional-council approval or examination-board affiliation;
- that every institution operating under a similar name is the listed legal entity;
- a complete national provider count or a complete list of all higher-education providers.

The HEC recognised-campus page, HEC Pakistan Qualification Register, accreditation council registers and university-controlled pages are separate assets with separate scopes and rights assessments.

## 4. Minimum field proposal — not an extraction instruction

The following is a proposed minimum schema for later human-reviewed mapping. It is **not** confirmation that every field is present on the current page.

| Proposed field | Rule |
|---|---|
| Institution identity/name | Preserve exact source text; resolve to an institution entity only with deterministic identity evidence and human review when ambiguous |
| Recognition category/object | Record only the exact category/object explicitly stated by HEC |
| Recognition status/wording | Preserve source wording; do not normalize ambiguous or historical labels into an active status |
| Source record locator | Store the approved page/record locator, not a guessed URL |
| Source observation timestamp | System observation time; never substitute it for source effective date |
| Source-published effective/notification date | Nullable; populate only when explicitly present |
| Jurisdiction/sector | Populate only if explicitly present and unambiguous |
| Evidence version/integrity reference | Metadata-only reference under an approved evidence-retention rule |

Do not collect personal contacts, principals' names, phone numbers, email addresses, staff records, student/applicant data, credentials or unrelated page content.

## 5. Rights and permitted-method assessment

| Question | Current evidence | Decision |
|---|---|---|
| Is the candidate publisher/authority identified? | HEC is identified as the authority in GOV-04 | Candidate identified; exact legal rights owner/terms still require qualified review |
| Is the exact asset identified? | Canonical recognised-universities page URL recorded above | G1 candidate asset identified |
| Is record-level reuse permission documented? | M1-S03 says no source-specific reuse license verified | **G2 BLOCKED** |
| Is commercial reuse/redistribution permission documented? | No | **G2 BLOCKED** |
| Is automated retrieval permission documented? | No | **G2 BLOCKED** |
| Is caching, transformation, retention and display permission documented? | No | **G2 BLOCKED** |
| Is attribution wording/placement settled? | Not source-specifically approved | **G2 BLOCKED** |
| Is a permitted access method approved? | No; public reachability is not permission | **G4/G9 BLOCKED** |

No owner outreach, permission request, login, scraping, bulk download, API call, browser automation or manual record verification is authorized by this pack.

## 6. Privacy, security and operational assessment

- **Data minimization:** institution-level recognition facts only, if later approved. Exclude all student/applicant/child/teacher/staff personal data and sensitive personal data.
- **Identity risk:** similarly named institutions and changes in legal names can cause false merges. Retain candidate alternatives and require human adjudication for ambiguity.
- **Status risk:** historical, suspended, stopped-admissions, upgraded or otherwise qualified entries must not be collapsed into a simple active/inactive flag without explicit source semantics.
- **Prompt injection:** any future page/document content is untrusted data, never instructions. It must not invoke tools, change policy or disclose secrets.
- **Retrieval security:** exact host/path allowlist, redirect revalidation, private/internal network blocking, bounded response size, content-type validation, isolated parsing, rate limits and kill switch are prerequisites, not active controls.
- **Freshness:** no source update cadence is approved. A page observation timestamp is not an effective date. Do not schedule polling or claim real-time freshness.
- **Evidence retention:** no source content retention is approved. Any future evidence reference requires an approved retention/deletion rule and source-rights clearance.

## 7. Conjunctive gate disposition

| Gate | Required before activation | R2 finding |
|---|---|---|
| G1 — exact source/asset | Exact authority, URL, object and field scope | Candidate named; row-level field scope incomplete |
| G2 — rights | License/permission for exact acts and commercial use | **BLOCKED** |
| G3 — privacy | Qualified field-level privacy review and retention/deletion | Partial minimization proposal only; **BLOCKED** |
| G4 — security/access | Approved retrieval architecture and method | Not assessed/approved for operation; **BLOCKED** |
| G5 — model/provider | Explicit model/provider and data-handling terms | Separate R2 model pack; no selection |
| G6 — cost/capacity | Zero-cost approach or approved ceiling and limits | No budget ceiling; no service spend |
| G7 — human governance | Named qualified reviewers and approvers | Not assigned; **BLOCKED** |
| G8 — evaluation | Synthetic adversarial and extraction evaluation | Test contract exists; no live-source evaluation |
| G9 — owner activation | Written source/asset/method/field/environment/expiry approval | **NOT AUTHORIZED** |

All gates are conjunctive. Passing one does not waive another.

## 8. Recommendation and next action

**Recommendation: retain GOV-04 HEC Recognised Universities/DAIs as the first source-specific candidate, but keep it RESEARCH ONLY.** It has a clearly described authority role and an institution-level claim boundary, while its reuse rights and retrieval method remain unverified.

The next decision must be made by the owner with qualified rights/privacy/security review: determine whether the exact asset can be licensed/used for the proposed institution-level fields and permitted method. Until that evidence exists, do not access or ingest records. If rights cannot be established, close the candidate as not approved and move to another source without relaxing the gates.

## 9. Non-interference

No source website/API was accessed for this pack. No permission request, owner contact, source retrieval, crawling, scraping, real-source data collection, model call, connector, scheduler, production/V1/Hostinger access, migration, deployment or spend occurred. Deeni Madaris remains hidden by default; no sect/maslak attribute is introduced.
