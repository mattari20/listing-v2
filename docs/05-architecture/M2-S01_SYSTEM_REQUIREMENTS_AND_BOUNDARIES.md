# M2-S01 — System Requirements and Architecture Boundaries

**Status:** In progress — architecture requirements baseline prepared for review  
**Milestone:** M2 — Architecture and Design  
**Source baseline:** Accepted M1 requirements, research, owner decisions and G01-G20  
**Scope:** System-level requirements and boundaries; no implementation or stack selection

## 1. Purpose

Define what the V2 system must do, who interacts with it, what sits inside/outside its boundary, and which quality and safety properties must shape later architecture. This document translates accepted M1 product requirements into architecture-level requirements; it does not claim participant validation.

## 2. Product and system outcome

eStudent Institutes V2 is a student-first, Pakistan-focused education discovery and decision-support platform. It helps learners and families discover education providers, campuses and programmes; understand source-backed admissions, eligibility, costs, scholarships and recognition information; compare options; and, after launch, contribute feedback under an authenticated and moderated review process.

The system also maintains a governed education evidence catalogue. Candidate-source discovery, collection, extraction and publication are separate stages. Only specifically authorized sources and approved publication workflows may supply public facts.

## 3. Stakeholders and actors

| Actor | Goals / interactions | Access principle |
|---|---|---|
| Public visitor | Browse/search institutions, campuses, programmes and public facts | Public read access; no account required for core discovery |
| Student / learner | Explore pathways, search, compare, shortlist, share, follow official application routes | Optional account only for account-dependent features |
| Parent / guardian | Support discovery and comparison | Public browsing; no assumption they are the account holder or final decision-maker |
| Institution representative | Propose/correct institution-owned information and respond to eligible reviews | Limited verified institutional role; cannot self-approve regulator facts or delete reviews |
| Data steward / verifier | Review source evidence, resolve conflicts, approve eligible facts | Least privilege; auditable decisions |
| Moderator | Handle reports, reviews, appeals and abuse | Separate moderation permissions; decisions reasoned and auditable |
| Platform administrator / owner | Manage configuration, users, policy and visibility settings | Strongly protected privileged access; critical changes logged |
| External source owner / regulator | Publishes source material; may or may not permit reuse | External party, not a V2 user or approved integration by default |
| External service provider | Potential map/geocoding, messaging, hosting or AI service | Candidate only; no provider selected or activated in M2-S01 |

Actor roles are logical responsibilities, not a final authentication or authorization model. M2-S08 will define detailed roles, separation of duties and controls.

## 4. System boundary

### Inside the V2 logical system

- Public discovery experience: browse, search, filters, profiles, programme/admission information, comparison and maps where supported.
- Account and user-preference capabilities for features that require identity.
- Institution/provider and campus information management.
- Education domain catalogue: provider, campus, programme, admission cycle, fees, scholarships, recognition and affiliation facts.
- Source registry, rights/authorization state, evidence/provenance, extraction and validation workflow.
- Human review, conflict resolution, publication, correction and rollback governance.
- Reviews, reporting, moderation and appeals (post-launch).
- Administration/configuration, including the Show Deeni Madaris visibility control.
- Audit, observability and operational support capabilities (design detailed in later M2 steps).

These are logical capabilities, not a chosen deployment topology or a claim that every capability ships in the first release.

### Outside the V2 system boundary

- Government/regulator and institution websites, portals, documents and registers.
- External map/geocoding, email/SMS/push, payment or AI/model providers.
- Identity federation providers, analytics/ad platforms and other third-party services.
- Official admission portals and institution application processes.
- Student devices, browsers and network access.

No external service is approved or connected by this document. Every source remains subject to M1 rights/security authorization; every vendor integration needs separate technical, privacy, security, cost and owner approval.

## 5. Architecture-level requirements

The following stable IDs are introduced for M2 traceability. The M1 SR-01–SR-14 requirements remain authoritative product requirements; these AR IDs express system-level obligations derived from them and the M1 decisions.

| ID | Requirement | Priority | Source / trace |
|---|---|---|---|
| AR-001 | Core public discovery and viewing of eligible public information must not require login. | Must | SR-01–SR-08 |
| AR-002 | Users can start with an optional education pathway or go directly to search; pathway inputs never block direct discovery. | Must | SR-01 |
| AR-003 | Search scope distinguishes provider/institution, campus and programme; exact matches are distinguishable from approximate candidates. | Must | SR-02; G04 |
| AR-004 | Manual locality search works without device location permission; precise location is requested only after an intentional user action and denial does not block discovery. | Must | SR-03, SR-14; G06 |
| AR-005 | Filters operate only on supported, evidence-backed attributes; missing, stale or disputed data is not silently treated as false or zero. | Must | SR-04, SR-07; G03, G05 |
| AR-006 | Material programme/admission facts are scoped to the applicable campus, programme and session/intake and expose source and relevant dates/status. | Must | SR-06; G03, G05 |
| AR-007 | Public factual assertions distinguish official-source evidence, provider-submitted claims, AI-discovered candidates, estimates and student opinions. | Must | SR-07; G08, G09 |
| AR-008 | Comparison is like-for-like, shows missing/stale/disputed values, and does not default to an opaque universal best-institution score. | Must | SR-05; G10 |
| AR-009 | Application/contact actions lead to a verified official provider or competent-authority route; V2 does not claim to submit an application unless separately authorized. | Must | SR-08 |
| AR-010 | Shortlist, share and reminders are designed as distinct capabilities; reminders are opt-in and revocable. | Should | SR-09 |
| AR-011 | Review submission requires authentication and remains a post-launch feature; login alone is not evidence of attendance or affiliation. | Must | SR-10; G12-G15 |
| AR-012 | Browsing and comparison do not require CNIC/B-Form, roll number, marksheet, exact home address or other unnecessary sensitive identifiers. | Must | SR-13; G15 |
| AR-013 | Source retrieval/ingestion is denied by default until source-specific rights, purpose, method, retention and security authorization is recorded. | Must | M1-S07/S08; G02, G16 |
| AR-014 | AI extraction is treated as a proposal; source content is untrusted; high-impact facts require authoritative evidence and human approval. | Must | M1-S08; G08, G09 |
| AR-015 | Conflicting assertions, original values, provenance and publication history are retained; material changes are not silently overwritten. | Must | M1-S08; G03, G08, G09 |
| AR-016 | Deeni Madaris remain in underlying provider scope, while public visibility is configurable and defaults OFF. | Must | V2-DEC-006; G07 |
| AR-017 | When Show Deeni Madaris is OFF, no such provider is exposed in public search, browse, maps, recommendations, counts, sitemaps, exports or public APIs; underlying records/provenance remain retained. | Must | V2-DEC-006; G07 |
| AR-018 | Sect/maslak is not used as a general discovery, filter, ranking, profiling or display attribute. | Must | V2-DEC-006; G07 |
| AR-019 | Public facts and coverage communicate missing, stale, disputed and partial-coverage states without implying a complete national census. | Must | SR-07; G01, G03 |
| AR-020 | Paid placements, if later introduced, are visibly distinguished and cannot alter objective evidence or review metrics. | Must | M1-S09; G11 |
| AR-021 | The system supports mobile-friendly, text-first and low-bandwidth discovery without requiring autoplay media or map-only interaction. | Must | SR-11 |
| AR-022 | Language and accessibility requirements are explicitly evaluated; architecture supports Unicode and does not hard-code a single language or left-to-right assumption. | Must | SR-12 |
| AR-023 | Administrative, verification, publication and moderation actions are attributable and auditable. | Must | M1-S07/S08/S09; G08, G14, G17 |
| AR-024 | Public discovery remains usable when optional external services (precise geolocation, maps, messaging) are unavailable or declined, with appropriate degraded behaviour. | Must | SR-03, SR-11, SR-14 |
| AR-025 | Operational design includes backup, recovery, monitoring, security incident and rollback capabilities before production release. | Must | G20; M2-S09/M3+ |

Priority meanings: Must = required by accepted owner/product constraints; Should = required unless an explicit owner-approved deferral is recorded. These priorities are design baselines, not an implementation backlog.

## 6. Key constraints and non-functional design drivers

1. **Rights before retrieval:** all M1 source families remain RESEARCH ONLY until separately authorized. A publicly reachable URL is not permission.
2. **No external activation:** no source connector, crawler, scheduler, model provider or paid API may be activated under M2-S01.
3. **No production action:** no production credentials/access, data operations, schema/migration or deployment.
4. **Privacy and minors:** minimize personal data; no identity-document collection by default; legal/safeguarding review required before user-generated content release.
5. **Deeni Madaris:** default-OFF is a cross-surface invariant, not a cosmetic filter.
6. **Evidence integrity:** fact-specific authority, provenance, effective/observed dates, conflict handling and human approval.
7. **No participant research during construction:** user journeys remain desk-research hypotheses until separately authorized validation.
8. **No technology assumptions:** stack, hosting, database, search, maps and AI orchestration remain open until M2-S04 and explicit owner decisions.

## 7. System capability groups

| Capability group | Responsibilities | Later design step |
|---|---|---|
| Public discovery | Browse, search, filter, profiles and locality | S03/S06 |
| Education catalogue | Provider, campus, programme, admissions, recognition and relationships | S02 |
| Evidence and source governance | Source authorization, provenance, validation, conflict and publication | S05/S07 |
| Comparison and shortlist | Comparable facts, missing-data states, share/save | S06 |
| Identity and trust | Accounts, roles, reviews, moderation, appeals | S08 |
| AI-assisted data workflow | Permitted retrieval, extraction, entity matching and human review | S07 |
| Administration and policy | Visibility controls, privileged configuration, audit | S08 |
| Operations and resilience | Monitoring, backup, recovery, cost and deployment design | S09 |

## 8. Open questions deliberately not resolved in S01

- Exact initial release feature cut and phasing.
- Validated student segments, language preference, device-sharing and accessibility needs.
- Final role/action matrix and institution representative verification.
- Reviewable entity, eligibility, scale, thresholds, moderation response targets and legal requirements.
- Source-specific rights and which integrations can lawfully be used.
- Technology stack, hosting, data stores, search/geospatial, maps, messaging and AI provider.
- Performance, availability, RPO/RTO and capacity targets.
- Whether a separately registered vocational provider at a Deeni Madaris location can be listed independently without exposing the Madaris record.

Each remains assigned to the appropriate M2 step or an explicit later owner/legal gate.

## 9. S01 acceptance criteria

S01 can be marked complete when:
1. Actors and system boundaries are explicit and consistent with the M1 product vision.
2. AR requirements have stable IDs, priorities and source traceability.
3. All SR-01–SR-14 requirements are mapped to one or more AR IDs or have a documented disposition.
4. M1 G01-G20 and V2-DEC-006 remain visible and are assigned to later design steps/gates.
5. External systems are marked candidate/research-only unless separately approved.
6. Quality scenarios are measurable or clearly marked pending a later target-setting step.
7. The system context and capability views are reviewed for consistency.
8. Documentation validation passes on the exact PR head and delivery evidence is reconciled.

## 10. References

- ISO/IEC 25010:2023, product quality model (published edition 2): https://www.iso.org/standard/78176.html
- W3C Web Content Accessibility Guidelines (WCAG) 2.2: https://www.w3.org/TR/wcag/
- Accepted V2 product requirements: `../../01-product/STUDENT_DISCOVERY_REQUIREMENTS.md`, `../../01-product/INSTITUTION_AND_PROGRAMME_REQUIREMENTS.md`, `../../01-product/COMPARISON_REVIEWS_AND_TRUST.md`.
- M1 final acceptance and G01-G20: `../../03-research/M1_S10_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`, `../../03-research/M1_S10_FINAL_SYNTHESIS_CLOSEOUT_REVIEW_2026-11-12.md`.

ISO/IEC and W3C references are design guidance, not a claim of certification or legal compliance.
