# M3-01 P05 — Legal, Privacy, Source-Rights, Safeguarding and Security Gate Assessment

**Date:** 2026-11-13  
**Status:** Owner-accepted planning deliverable; specialist legal/privacy/safeguarding/security and later operational gates remain open  
**Jurisdictional starting point:** Pakistan-first service; cross-border hosting/vendor implications to be assessed  
**Implementation authorization:** NOT ISSUED  
**Spend authorization:** NONE — no new spend  
**Data boundary:** Synthetic fixtures only; no V1 or real personal data

## 1. Purpose and limits

This assessment converts the accepted V2 principles into preconditions and a gate checklist for the initial bounded build and later public service. It is a risk and planning assessment, not legal advice, a privacy impact assessment signed by counsel, a penetration test, a safeguarding certification, or a claim of regulatory compliance.

No external institute/source family has been approved for collection or reuse. Public availability is not permission. All source families remain RESEARCH ONLY. No source access, scraping, downloads, ingestion, contact, republication or personal-data processing is authorized.

## 2. Pakistan legal and regulatory landscape — research snapshot

The official Ministry of IT legislation page currently lists Personal Data Protection Bill 2020 and Personal Data Protection Bill May 2023 as **Draft**, not approved legislation. The official National Cyber Crime Investigation Agency page lists PECA 2016 and the Prevention of Electronic Crimes (Amendment) Act 2025 among the relevant laws. The Gazette of Pakistan publishes the 2025 PECA amendment as Act No. II of 2025.

Sources reviewed:
- Ministry of IT and Telecommunication, legislation register: https://www.moitt.gov.pk/Legislations
- NCCIA, PECA laws register: https://nccia.gov.pk/laws.php
- Gazette of Pakistan, Prevention of Electronic Crimes (Amendment) Act 2025: https://na.gov.pk/uploads/documents/679b243193585_457.pdf
- Pakistan Code, PECA 2016 text: https://www.pakistancode.gov.pk/pdffiles/administrator6a061efe0ed5bd153fa8b79b8eb4cba7.pdf

This snapshot must be rechecked by qualified Pakistan counsel immediately before any real personal data, public user accounts, user-generated content or production operation. The absence of a single comprehensive data-protection statute must not be interpreted as absence of privacy, confidentiality, contractual, constitutional, consumer, education, cybercrime or other legal obligations. Cross-border processing, hosting location, vendor/subprocessor terms, retention, breach response, children's data and content moderation require specific legal review.

## 3. Gate assessment

| Area | Current design disposition | Required before initial synthetic foundation | Required before real data / public pilot / launch |
|---|---|---|---|
| Personal data / privacy | Anonymous-first; no student personal data in initial slice | Keep fixtures synthetic; no tracking identifiers beyond minimal test telemetry | Qualified privacy/legal review, data inventory, purpose/necessity, notices, rights/requests process, retention/deletion, incident response and cross-border/vendor review |
| Children / safeguarding | Children are a foreseeable audience; no child accounts or direct interaction initially | No child accounts, profiles, messaging, uploads, reviews, contact forms or targeted profiling | Qualified child-safeguarding review, age-appropriate UX, reporting/escalation, abuse response, content moderation, adult/child interaction boundaries and jurisdictional assessment |
| Source rights / licensing | Every source family remains RESEARCH ONLY | No external source access, scraping, collection, ingestion or reuse; synthetic fixtures only | Source-by-source permission/terms/license, attribution, database rights, copyright, robots/technical controls, personal-data basis, retention, redistribution and withdrawal process approved and recorded |
| Institute facts / reputational risk | Evidence-backed, time-aware facts; human approval for high-impact publication | Synthetic records only; no claims about real institutions | Verification standard, dispute/correction/appeal workflow, evidence retention, response SLAs and qualified legal review of defamation/misrepresentation risks |
| Cybersecurity / access | Least privilege, V2 isolation, secret boundaries, auditability | Threat model, secure defaults, dependency lifecycle, secret handling, CI checks and negative tests for visibility controls | Independent security review / penetration test proportionate to risk, incident response, vulnerability handling, access reviews and operational monitoring |
| Deeni Madaris suppression | Show Deeni Madaris default-OFF; zero public exposure across every surface | Automated negative tests across browse/search/counts/facets/API/direct IDs/cache/export/sitemap | Independent release-gate verification, configuration change authorization, audit and rollback tests; no inference of sect/maslak |
| AI / automated decisions | AI disabled; no agents/models/providers in initial slice | No AI code or API integration required | Separate AI activation decision, DPIA/risk assessment where applicable, evaluations, prompt-injection controls, evidence grounding, human review and cost/security approval |
| Hosting / cross-border | Existing Hostinger Premium, no new spend; Singapore server location shown in prior owner screenshot | No real data; keep V2 isolated and synthetic-only | Counsel review of transfer/hosting terms, vendor/subprocessor, access jurisdiction, backup location, breach duties and data residency commitments |
| Cookies / analytics / advertising | No unnecessary tracking in initial slice | No ad pixels, behavioural analytics or third-party trackers | Legal review of cookies/consent/notice and analytics necessity before activation |
| Accessibility / inclusion | Low-bandwidth, accessible, multilingual direction | Basic keyboard/semantic HTML and responsive smoke tests | Formal accessibility evaluation and user testing, including Urdu/RTL and assistive technology |

## 4. Initial foundation legal/security boundary

The following controls are mandatory even for the synthetic-only foundation:

1. Do not import, copy, transform, hash, pseudonymize or anonymize V1 data. Use fabricated fixtures created specifically for tests.
2. Do not fetch or store any real institute source material.
3. Do not collect student/child personal data or create student accounts.
4. Keep application secrets outside source control and public document roots.
5. Use least privilege for repository, CI and any later V2 runtime identity.
6. Keep the V2 code, public root, configuration, database/user, storage and logs isolated from V1.
7. Add automated negative tests for Deeni Madaris default-OFF non-exposure and direct-object access.
8. Use dependency lockfiles, supported versions, security advisories and reproducible CI.
9. Do not activate AI, external APIs, analytics, maps, geocoding, third-party trackers or paid services.
10. Do not deploy to Hostinger or create a V2 database/cron/subdomain as part of the foundation unless a separate scope explicitly authorizes it.

## 5. Source rights decision record

**Decision: NO SOURCE FAMILY APPROVED.**

All source families remain RESEARCH ONLY. A future source authorization package must identify the exact source owner, URL/system, terms and license, allowed purpose, fields, access method, collection frequency, storage, retention, attribution, redistribution, personal-data implications, withdrawal/objection route, security review and approving owner. No blanket authorization is permitted.

## 6. Children and safeguarding decision record

**Decision: NO DIRECT CHILD INTERACTION IN INITIAL SCOPE.**

The initial product is an anonymous public information directory. It must not provide child accounts, direct messaging, user-to-user contact, public child profiles, photo uploads, behavioural profiling or child-generated reviews. Any future interaction or collection involving children requires a separately approved safeguarding and legal assessment before design or implementation.

## 7. Security acceptance criteria for the first foundation

- Repository contains no credentials, production secrets, V1 data or real-source data.
- CI runs static/documentation validation and deterministic tests without production credentials.
- V2 configuration fails closed when required secrets are absent.
- Public entry point cannot expose source files, environment files, dependency internals, logs or private storage.
- Public routes are anonymous and do not reveal private evidence or suppressed records.
- Deeni Madaris suppression is centralized and tested across every current public surface.
- Dependency versions are pinned/locked and supported at the time of implementation.
- Audit events for privileged actions are designed before privileged workflows are introduced.
- No unsupported claim of legal compliance, security certification or independent review is made.

## 8. Outstanding qualified reviews and approvals

Before any real-data processing or public pilot, obtain:
- Pakistan-qualified legal review of applicable law, source rights, institute data, privacy notices, cross-border hosting and platform liability.
- Qualified child-safeguarding review for foreseeable child use and any future interaction.
- Privacy review/data protection impact assessment appropriate to the actual data and processing.
- Independent security assessment proportionate to the deployed feature set.
- Source-by-source written authorization and rights evidence.
- Product Owner approval of policies, retention, correction/appeal and incident response.

These reviews may require external professional services. No procurement or new spend is authorized; if required reviewers cannot be engaged within the existing no-spend constraint, the affected features and launch remain deferred.

## 9. P05 disposition

**Planning assessment:** DELIVERED.  
**Legal sign-off:** NOT OBTAINED.  
**Privacy sign-off:** NOT OBTAINED.  
**Source-family approval:** NONE.  
**Safeguarding sign-off:** NOT OBTAINED.  
**Independent security sign-off:** NOT OBTAINED.  
**Real data / source collection:** NOT AUTHORIZED.  
**Public pilot / launch:** NOT AUTHORIZED.

P05 can be marked as a completed planning deliverable only after owner review of this risk disposition; it must not be marked as legal/security compliance approval. The later production/pilot gates remain open and cannot be bypassed by completion of M3-01.

## 10. References and review note

The legal sources above are a dated research snapshot. The Ministry legislation register and official Gazette must be rechecked at the time of any future launch or data-processing decision. Qualified counsel must confirm current law, amendments, rules, regulatory status, territorial reach and contractual requirements.

**No implementation authorization is issued by this document.**


## 11. Product Owner review disposition — 2026-11-13

**Owner instruction:** The Product Owner instructed the project to proceed and complete P05 and P06. This is recorded as acceptance of the P05 planning assessment and its bounded risk/gate disposition only.

**P05 planning deliverable: ACCEPTED / CLOSED.**

Acceptance confirms that:
- The risk categories, synthetic-only foundation boundary, source-family RESEARCH ONLY status and no-direct-child-interaction initial scope are the accepted planning baseline.
- The listed legal, privacy, safeguarding, source-rights and independent-security reviews remain mandatory before the relevant later activity.
- No source family, real data, personal-data processing, pilot, launch or new spend is approved.

Acceptance does **not** constitute legal advice or counsel sign-off, a completed formal privacy impact assessment, safeguarding certification, source-owner permission, independent security assessment, or a declaration of legal compliance. These are external/later gates and remain OPEN.

The Product Owner is the final project decision-maker; qualified professionals must provide the specialist reviews described above. If a required review cannot be obtained within the no-new-spend constraint, the affected activity remains deferred.

**Implementation authorization: NOT ISSUED.**
