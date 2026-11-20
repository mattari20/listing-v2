# M3-11 LPS-15 — GAP-03 Source Rights, Copyright, Privacy and Qualified Review Preparation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Planning baseline:** `c441d886978716647f6e744832040a94e029bebe` (main after LPS-14 / PR #372)  
**Agenda type:** Repository-only governance preparation and review-pack design  
**Status:** **PREPARATION PACK COMPLETE — SOURCE-BY-SOURCE REVIEW MODEL, RIGHTS REGISTER, EVIDENCE CHECKLIST AND QUALIFIED REVIEW HANDOFF DEFINED; GAP-03 NOT APPROVED / NOT CLOSED; NO SOURCE ACCESS OR COLLECTION AUTHORIZED**

## 1. Purpose and decision boundary

LPS-15 prepares the evidence and decision structure required by GAP-03 in LPS-12. It is intended to prevent the project from treating public availability, official status, search-engine visibility, an API endpoint, social-media access or an existing source-authorization code path as permission to acquire, store, transform, display, redistribute or commercially use source material.

This agenda creates a source-specific rights assessment pack and a qualified legal/privacy/safeguarding review handoff. It does not perform legal research on any particular source, contact a source owner, access a website or platform, inspect live terms, retrieve content, collect data, copy source material, test an API, scrape/crawl, publish, or decide that any source is lawful to use. No source is approved by this document.

**Current operating boundary remains unchanged:** private repository/local/GitHub CI work; synthetic/fictional fixtures only; no V1/production/Hostinger/hPanel/hosted access; no live database, migration, backup inspection or restore; no real institute/source/student/child/guardian/personal data; no source contact, access, browsing for collection, copying, downloading, scraping, crawling, API use or ingestion; no external API, AI/model/provider, crawler or live agent; no public complaint/UGC/review/rating/appeal activation; no deployment, pilot, release candidate or participant activity; no new dependency, paid service, hosting upgrade or additional spend. Deeni Madaris remains default-OFF/zero exposure.

## 2. Controlling principles

1. **Deny by default.** No source, dataset, API, social platform, directory or content collection method is approved unless its exact proposed use is separately assessed and authorized.
2. **Publicly accessible does not mean freely reusable.** Public visibility, official status, search indexing or technical accessibility does not by itself establish rights to copy, extract, store, transform, cache, display, redistribute or commercially reuse.
3. **Rights are use-specific.** A permission for access or research does not automatically permit republication, commercial use, bulk extraction, automation, derivative works, onward disclosure or long-term retention.
4. **Assess facts and expression separately.** A factual value, a source's wording, a photograph, a logo, a map tile, a document, a database compilation and a site's layout may engage different rights and restrictions. The reviewer must assess each proposed element; the project must not assume that all material on one page has the same status.
5. **One source, one use case, one decision record.** Do not bundle unrelated sources or use cases under a blanket approval. Approval must identify exact fields/material, purpose, method, territory, audience, storage, display, retention and expiry.
6. **Source terms and permissions are versioned.** Terms, licenses, permissions, ownership, endpoints, pricing and technical restrictions can change. Reassessment is required when a relevant condition changes or approval expires.
7. **Privacy is independent of copyright.** A copyright/reuse permission does not establish a lawful or appropriate basis to process personal information. A privacy basis does not grant copyright, database, trademark, contractual or platform rights.
8. **Child safeguarding is a separate gate.** No student, child, guardian or child-directed data/feature is authorized. Any future proposal requires a separate qualified safeguarding and privacy assessment.
9. **Human decision and provenance remain mandatory.** Source evidence is untrusted until validated. Automated extraction, if ever separately approved, cannot make final rights or publication decisions.
10. **No code path creates permission.** Existing synthetic source-authorization controls demonstrate bounded technical guardrails only; they do not establish actual rights, a valid license, permission from a source, or qualified legal clearance.

## 3. Source and material classification

The following categories are a planning taxonomy only. They are not evidence that any source has been accessed or approved.

| Source/material class | Examples in the future product concept | Main questions for qualified review | Default posture |
|---|---|---|---|
| Government / statutory / regulator sources | Recognition registers, official lists, notices and institution-level status | Does the body have authority for this exact fact? What is the legal status of the register? Are reuse, bulk extraction, attribution, update and commercial display terms stated? Are there restrictions or disclaimers? | NOT APPROVED |
| Institution-controlled sources | Institute website, prospectus, fee schedule, official notice or institution-provided record | Is the institution the rights holder or authorized publisher? Does its permission cover each field/material, storage, display, updates and commercial directory use? Does the content include third-party works or personal data? | NOT APPROVED |
| Social platforms / public pages | Public Facebook or other social-media pages/posts | Platform terms, account/page ownership, content rights, API restrictions, privacy expectations, embedded third-party content, extraction/automation restrictions and takedown obligations | NOT APPROVED |
| Maps / geospatial platforms | Map tiles, place records, coordinates, geocoding or route information | Separate rights for map imagery, database records, coordinates and geocoding results; display/attribution, caching, quotas, derivative use, storage, retention and commercial restrictions | NOT APPROVED |
| Third-party directories / aggregators | Education directories, commercial listings, search-result pages | Database rights, compilation investment, contractual restrictions, source provenance, accuracy, redistribution and restrictions on bulk extraction | NOT APPROVED |
| Open-data / openly licensed datasets | Dataset published under a stated open license | Exact license version, covered material, attribution, share-alike, non-commercial, no-derivatives, database and notice obligations; compatibility with intended use | NOT APPROVED |
| User / institution submissions | Submitted facts, documents, photographs or corrections | Submitter authority, rights grant, scope, warranties, third-party rights, privacy, consent where relevant, withdrawal, retention and moderation | NOT APPROVED; intake remains inactive |
| Software, icons, images and other assets | Packages, UI assets, logos, photographs and illustrations | Software license vs asset license; trademark, attribution, redistribution, modification, notices, copyleft and provenance | Separate component/asset review required |

For each source, identify the precise content type: raw facts, text/expression, photographs, logos/trademarks, maps/tiles, coordinates, tables, structured datasets, documents, metadata, user comments or mixed material. Mixed sources must be split into separately assessed components.

## 4. Source-specific rights register

Create a unique record for every proposed source and every materially different use. A blank field means UNKNOWN / NOT ASSESSED, never “permitted.”

| Field | Required record |
|---|---|
| Source ID and version | Stable ID, record version, preparation date, review date and status |
| Source owner / operator | Legal entity or person responsible for the source; identity and authority evidence |
| Source authority | Whether the source is official, statutory, institution-controlled, user-submitted, commercial or third-party; exact scope of authority |
| Canonical locator | Exact canonical URL, dataset identifier, API endpoint or document reference; only populate during a separately authorized assessment |
| Material / fields | Exact factual fields, expressive content, images, documents, metadata, geographic material or database subset proposed |
| Purpose and necessity | Specific student-discovery purpose for each field; why it is necessary and less intrusive alternatives |
| Intended audience / use | Internal verification, private admin, public profile, search result, comparison, analytics or other proposed use |
| Access method | Manual review, authorized download, API, licensed feed or automation; exact frequency and technical constraints |
| Rights basis | License, written permission, statutory provision or other counsel-assessed basis; exact document/version and scope |
| Rights covered | Access, extraction, reproduction, storage, normalization, adaptation, caching, display, attribution, distribution, commercial use and derivative use — each assessed separately |
| Restrictions | Non-commercial, attribution, share-alike, no-derivatives, rate limits, no bulk extraction, no caching, no redistribution, territory, expiry or other conditions |
| Attribution | Exact required credit, placement, wording, link, notices and any changes required by license |
| Personal data | Fields that identify or relate to a person, sensitive data risk, data-subject categories and minimization/exclusion controls |
| Children / safeguarding | Whether children/student/guardian information or child-facing exposure could arise; default exclusion and required qualified review |
| Privacy basis and transparency | Purpose, necessity, applicable basis, notice, rights handling and privacy-risk review; not inferred from copyright permission |
| Storage / processing | Proposed systems, regions, processors, access roles, transformation, logs, exports, caches and backups; unknown until evidenced |
| Retention / deletion | Trigger, approved period, deletion propagation, backup expiry, withdrawal and revocation handling; link to LPS-14 inventory |
| Accuracy / freshness | Authority for each fact, update cadence, observed date, conflicts, expiry and correction contact |
| Security / abuse | Threats, access limits, source credentials if any, rate limits, abuse prevention and incident handling |
| Qualified legal/privacy decision | Reviewer identity/qualification, scope, date, findings, limitations, conditions and expiry |
| Product Owner decision | Exact permitted scope, conditions, rejection or deferral; date and decision reference |
| Evidence references | Non-sensitive evidence IDs, exact version/date, restricted-storage reference and integrity/hash if appropriate |
| Status / reassessment trigger | Current state, owner, next review date and events requiring reassessment |

## 5. Rights and permission assessment checklist

For every proposed source/use, the reviewer must answer and document each item rather than recording a generic “public information” conclusion.

### 5.1 Ownership, authority and provenance
- Who owns or controls the source, database, page, content and relevant intellectual property?
- Does the named contact have authority to grant the proposed rights?
- Is the source an official record, and what exact facts is the source legally/administratively authoritative for?
- Is the material created by the source owner, licensed from another party, embedded, syndicated or user-generated?
- Can the project establish source identity, canonical version, date, scope and provenance?

### 5.2 Rights and terms
- What law, license, contract, platform terms, notice or permission governs the material and access method?
- Which exact rights are granted: access, extraction, reproduction, storage, normalization, adaptation, display, attribution, redistribution and commercial use?
- Are database extraction, substantial or repeated extraction, bulk access, caching or systematic collection restricted?
- Are there non-commercial, no-derivatives, share-alike, attribution, territory, duration, rate or onward-transfer conditions?
- Does the proposed use conflict with terms, technical controls, access restrictions or anti-circumvention rules?
- Are rights granted to the project entity/operator and do they cover its actual commercial model and intended audience?
- What happens when terms, permissions or licenses are changed, withdrawn or expire?

### 5.3 Facts versus source expression
- Can the student need be met by independently recording a minimal factual value rather than copying source wording, tables, images or documents?
- Is the value itself mixed with protected expression, a curated compilation, a database structure or third-party content?
- Would the proposed extraction reproduce a substantial part of a protected compilation or violate contractual/platform restrictions?
- Can source attribution and a link meet transparency needs without reproducing protected material?
- Are logos, photographs, maps, screenshots, prospectus pages and other creative assets excluded unless separately licensed/authorized?

### 5.4 Privacy and safeguarding
- Does the source contain names, personal phone numbers, personal email addresses, photographs, identifiable staff/student details, credentials, sensitive information or incidental personal data?
- Is each personal field necessary for institute discovery, or can it be excluded or replaced with an institutional contact channel?
- Could the material identify a child, student, guardian or vulnerable person directly or by combination?
- Does the intended use create profiling, contact, targeting, location or safety risks?
- What transparency, rights, retention, deletion and complaint obligations apply?
- Is a qualified privacy/safeguarding assessment required before any use?

### 5.5 Operational and lifecycle conditions
- What are the permitted collection frequency, storage region, recipients and processing services?
- Are credentials, tokens or account access involved, and how are they authorized and protected?
- What is the permitted retention period and deletion method for source copies, extracts, caches, logs and backups?
- How are source corrections, withdrawal, takedown, license expiry and rights revocation propagated?
- Can every stored value be traced to the source, exact rights record, purpose and approval?
- Can publication be suppressed promptly without leaving stale copies or exports exposed?

## 6. Rights decision model

Use these states for each source/use pair:

| State | Meaning | Permitted activity |
|---|---|---|
| NOT ASSESSED | No adequate rights/terms evidence has been reviewed | No source access or use under this agenda |
| RESEARCH-ONLY / NOT AUTHORIZED | Source may be named as a candidate in planning records only | No access, collection, copying, storage or publication |
| EVIDENCE PACK PREPARED | Non-sensitive review pack is ready for a qualified reviewer | No source use |
| QUALIFIED REVIEW PENDING | Reviewer has not completed or signed the scoped assessment | No source use |
| CONDITIONALLY ACCEPTED | Qualified reviewer has defined explicit conditions; accountable owner has not yet completed them | No use until all conditions and approvals are evidenced |
| APPROVED — LIMITED USE | Qualified assessment and Product Owner authorization cover the exact source/use/method/fields/period/environment | Only the expressly approved activity, not adjacent uses |
| REJECTED / PROHIBITED | Rights, privacy, safety or terms are unacceptable or cannot be established | No use |
| EXPIRED / REASSESSMENT REQUIRED | Terms, law, source, purpose, fields, method or environment changed, or approval expired | Stop affected use until reassessed |
| REVOKED / WITHDRAWAL IN PROGRESS | Permission or rights basis withdrawn, expired or invalidated | Stop acquisition/publication and execute scoped withdrawal/deletion controls |

**No automatic promotion:** completion of a template, source discovery, public availability, a successful test, or an existing technical authorization record cannot move a source into APPROVED — LIMITED USE.

## 7. Source-specific review pack — reusable template

Prepare one pack per proposed source/use. Do not fill unknowns by assumption.

### A. Proposal summary
- Source ID and source owner/operator:
- Proposed source material and exact fields:
- Product purpose and student need:
- Proposed audience and display:
- Proposed access method/frequency:
- Proposed storage/processing location:
- Commercial context:
- Requested decision and scope:
- Explicit exclusions:

### B. Evidence index
- Exact terms/license/permission document and version/date:
- Source ownership/authority evidence:
- API/download/automation terms if relevant:
- Attribution/notice requirements:
- Rights to store/transform/cache/display/redistribute/commercially use:
- Privacy notice/basis and data inventory references:
- Security/data-flow/processor references:
- Retention/deletion and withdrawal references:
- Source correction/takedown contact:
- Evidence limitations and unresolved facts:

### C. Risk and impact assessment
- Copyright/database/contract/platform rights risks:
- Personal data/privacy risks:
- Child/student/guardian/safeguarding risks:
- Accuracy, authority and freshness risks:
- Security, credentials, access and abuse risks:
- Retention, deletion, backup and downstream risks:
- Cross-border, vendor and jurisdiction risks:
- LPS-13 change class and impact record:
- Mitigations and residual risks:
- Stop conditions:

### D. Qualified reviewer opinion
- Reviewer name and organization:
- Qualification, professional standing and relevant experience:
- Independence/conflict declaration:
- Jurisdictions and exact subject matter reviewed:
- Materials and versions reviewed:
- Applicable legal/contractual issues identified:
- Findings and reasoning:
- Conditions, exclusions and limitations:
- Review date, validity period and reassessment triggers:
- Signature or independently verifiable approval reference:
- Restricted evidence location/reference:

### E. Product Owner disposition
- Decision: ACCEPT LIMITED SCOPE / CONDITIONAL / REJECT / DEFER
- Exact approved source, fields, purpose, method, territory, audience and environment:
- Explicit prohibited uses:
- Conditions and accountable owners:
- Expiry/review date:
- Separate implementation/source-access authorization reference:
- Decision date and audit reference:

## 8. Qualified review and accountability requirements

The existing M3-00 T07 register remains controlling: qualified Pakistan legal/privacy review and other jurisdictional counsel where the actual scope requires it; qualified safeguarding review before any child exposure; independent security review for relevant technical/security gates. This agenda does not appoint reviewers or presume a qualification.

The qualified legal/privacy review request must include:
1. Exact proposed V2 purpose, audiences, fields and exclusions.
2. Source/use register and source-specific terms/permission evidence for every candidate.
3. Data inventory and lifecycle framework from LPS-14, including primary/derived/log/export/cache/backup/processor surfaces.
4. Proposed access method and technical restrictions, without performing that method.
5. Commercial model, attribution, display and redistribution plan.
6. Privacy and safeguarding boundary, including explicit child/student/guardian exclusions.
7. Jurisdictions, hosting/processing locations and any proposed transfer.
8. Correction, withdrawal, retention, deletion and incident-handling model.
9. LPS-13 change-impact record and relevant owner decisions.
10. Specific questions requiring advice, known uncertainties and proposed no-go conditions.

**Required reviewer outputs:** written scoped assessment; applicable law/terms and rights analysis; source-by-source findings; conditions and exclusions; unresolved risks; required changes; review validity/expiry; and a clear recommendation (approve limited scope, conditional, reject or further evidence required). A verbal assurance or generic website statement is insufficient for gate closure.

**Role separation:** the person proposing or implementing a source integration must not self-approve the legal rights assessment. ChatGPT assistance is not a qualified reviewer and cannot sign or substitute for the required human professional. Product Owner acceptance follows, rather than replaces, qualified review.

## 9. No-go and reassessment conditions

Do not access, collect, copy, ingest, store or publish a source/use if any of the following applies:
- ownership, authority, applicable terms, license or permission is unknown, ambiguous, expired or withdrawn;
- rights to the exact method, fields, storage, transformation, display, attribution, redistribution or commercial use are not established;
- a source prohibits or restricts the proposed extraction, caching, automation or onward use;
- personal or child-related data is unnecessary, excessive, unexpected or lacks an approved privacy/safeguarding plan;
- source material contains third-party content or user-generated content whose rights cannot be established;
- source provenance, correction, withdrawal, deletion or auditability cannot be maintained;
- data location, processors, cross-border transfers or retention/deletion obligations are unknown or unacceptable;
- qualified reviewer findings are missing, unresolved or outside the reviewer’s competence;
- the proposed use exceeds exact scope, approval period, audience, method, fields or commercial conditions;
- the activity would cross any standing restriction or require new spend, external services, production access or deployment.

Reassessment is mandatory when source ownership/operator, terms/license, endpoint, material, data fields, purpose, audience, access method/frequency, commercial model, jurisdiction, processor, retention, product feature or applicable legal requirements change.

## 10. Relationship to existing controls and agendas

- **T07:** the M3-00 Legal, Privacy, Source-Rights and Security Gate Register remains the controlling baseline. LPS-15 operationalizes its source-specific approval record and qualified-review handoff; it does not replace or pass T07 gates.
- **LPS-03:** source-content protection remains PARTIAL. Synthetic source authorization is a technical guard, not actual source-rights evidence.
- **LPS-04:** children’s safeguarding remains PARTIAL and child/student/guardian data and child-directed features remain outside the current scope.
- **LPS-09:** no AI/provider, crawler or live agent is approved. Any future AI use requires a separate source/data rights and provider assessment.
- **LPS-11:** repository evidence mapping remains partial and does not establish real source rights.
- **LPS-12:** GAP-03 remains P0. LPS-15 prepares the source-specific assessment pack and review process; qualified assessment and actual permission evidence remain prerequisites before source access/acquisition or real-data activity.
- **LPS-13:** any future source, field, method, purpose, rights basis, processor or audience change must follow the C0–C3 change-impact framework.
- **LPS-14:** any future source data use must map into the data inventory, retention and deletion lifecycle; source permission does not waive privacy or lifecycle requirements.

## 11. Acceptance criteria for this preparation agenda

LPS-15 preparation is complete when:
1. Source/material classes and the facts-versus-expression distinction are recorded.
2. A source-specific rights register captures ownership, authority, purpose, method, fields, rights, restrictions, attribution, privacy, retention and revocation.
3. The assessment checklist separately covers copyright/database/contract/platform rights, privacy, safeguarding, security and lifecycle risks.
4. A clear deny-by-default decision model and no-go/reassessment rules are documented.
5. A reusable source-specific review pack and evidence index are available.
6. Qualified reviewer competence, independence, scope and required written outputs are defined.
7. Existing T07, LPS-11, LPS-12, LPS-13 and LPS-14 relationships are reconciled without changing accepted policy.
8. Project records and documentation catalog are updated.
9. Exact-head documentation validation and PHP 8.5 foundation CI pass for the repository-only change.
10. No source access, collection, contact, copying, API call, external research, implementation or authorization expansion occurs.

## 12. Final disposition

**LPS-15 agenda: COMPLETE as repository-only source-rights and qualified-review preparation.**  
**GAP-03: REVIEW PACK PREPARED / QUALIFIED ASSESSMENT NOT RECEIVED / SOURCE RIGHTS NOT APPROVED / OPEN.**  
**M3-11-02: BLOCKED pending qualified legal/privacy/safeguarding assessment and other applicable evidence.**  
**M3-11 overall: BLOCKED / NOT ACCEPTED.**  
**Overall M3: OPEN / PARTIALLY COMPLETE — NOT CLOSED.**

No particular source has been assessed or approved. No source was accessed or contacted; no terms were fetched; no content was copied, scraped, crawled, downloaded, ingested or published. No real data, external API, AI/provider, processor, production/Hostinger environment, deployment, pilot, release or additional spend is authorized.

---
