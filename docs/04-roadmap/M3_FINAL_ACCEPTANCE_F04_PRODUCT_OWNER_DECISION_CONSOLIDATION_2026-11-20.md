# M3 Final Acceptance Exercise — F04 Product Owner Decision Consolidation

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `71ff484de7edd09653d02235993bb71f15861506` (F03 merge)  
**Scope:** Consolidation of previously recorded Product Owner decisions. No new product approval, implementation authorization, source access, hosting access, production activity, participant activity or spend is created by this record.

## 1. Purpose and decision rule

F04 consolidates prior Product Owner decisions so the final M3 assessment does not repeatedly ask the owner to approve unchanged scope. An accepted decision remains accepted unless the owner explicitly changes it. A decision may be accepted while its implementation, verification, qualified review, hosted operation or release evidence remains incomplete.

This record distinguishes:
- **Owner decision:** the Product Owner has selected or accepted a policy, requirement, option or bounded work package.
- **Implementation authorization:** exact work is separately permitted within a repository/environment and activity boundary.
- **Implementation evidence:** code/configuration/documentation exists and has passed the applicable checks.
- **Operational/release acceptance:** exact human, qualified, hosted, recovery, candidate and go/no-go evidence exists.

A decision in the first category does not automatically satisfy the other categories.

## 2. Consolidated Product Owner decision ledger

| ID / decision family | Consolidated accepted decision | Scope and binding limitation | Implementation / acceptance distinction |
|---|---|---|---|
| R1.1 — Option A / Option 1 | **APPROVED unchanged** | This is the R1 requirements/decision sequence's Option A / Option 1 choice. It is distinct from the later M3-11 Option A and must not be conflated with it. | Approval is retained; it does not by itself authorize external, hosted or release activity. |
| R1.2 — student discovery and institutional requirements | **APPROVED as the provisional long-term baseline, with three clarifications** | Preserve the three clarifications attached to the original approval; do not silently broaden, delete or reinterpret them. | The exact wording of those three clarifications is not independently reproduced in a canonical current-main decision file. This record therefore preserves the approved decision by reference rather than inventing a paraphrase. |
| R1.3–R1.17 | **APPROVED** | The user approved the sequence, with flexibility for future updates. No unchanged item is to be reopened for repeated approval. | Each requirement still needs its own implementation/evidence disposition in F05; approval does not prove delivery. |
| R1.18 | **APPROVED** | Retain the accepted outcome. | Implementation/evidence remains separately assessed. |
| M3-00 T07 | **ACCEPTED for planning/control framework only** | Deny-by-default legal/privacy/source-rights/security gate framework accepted. Qualified reviews, source rights, vendor/service approvals and substantive clearances remain unperformed or blocked. | M3-00 is closed as planning work; this is not legal/security/safeguarding clearance. |
| M3-00 T08 | **ACCEPTED for planning framework only** | Scope/test/release/authorization framework accepted. Exact implementation authorization remains separate. | M3-00 closure does not authorize implementation, spend, production, deployment or launch. |
| M3-DEC-001 — owner-led delivery | **ACCEPTED** | User is Product Owner/final decision-maker; ChatGPT assists with planning, architecture, documentation, code drafting only after separate authorization, test design, review support and reporting. | Owner-led model is accepted for private repository-only synthetic development; ChatGPT is not an independent operator, reviewer or professional approver. |
| M3-DEC-002 — owner availability | **CONFIRMED** | 10–15 hours/week is a flexible planning baseline for owner participation; reviews/approvals are demand-led. | This is not a staffed engineering, QA, security or operations capacity claim. |
| M3-00 budget / cost | **NO NEW SPEND** | No new hosting, infrastructure, vendor, API, subscription, model or paid-service spend is approved. Existing plan is retained; no numeric lifetime budget ceiling is inferred. | A zero-spend posture does not prove a service is technically suitable or authorize a purchase. |
| Existing hosting plan | **RETAIN CURRENT HOSTINGER PLAN** | No upgrade or additional hosting spend. Owner-selected V2 subfolder and dedicated V2 database facts remain recorded. | Selected location/database and observed PHP/PDO/CLI readiness do not establish V2/V1 isolation, HTTP protection, private storage, database connectivity or hosted acceptance. No additional hPanel access is authorized by F04. |
| Backup cadence | **WEEKLY AUTOMATED BACKUPS ACCEPTED for current development stage** | No paid upgrade or increased frequency required. | This is a policy decision only. It does not establish a V2-only backup boundary, retention, integrity, RPO/RTO, recovery owner or restore rehearsal. |
| Owner-led internal review | **ACCEPTED for current private development** | Product Owner may conduct internal review with AI-assisted explanation and repository evidence; no external reviewer appointment is required merely to continue current repository-only work. | It is not an independent professional review, legal opinion, penetration test, accessibility audit or release certification. |
| RCV-B02 — admissions/programme facts | **SELECTED as first residual product capability and approved for its bounded synthetic implementation** | Cycle/offer-scoped facts, evidence/provenance, human adjudication/publication and public allowlisting; no source collection or real data. | PR #318 implementation is merged; source/real-data and production gates remain separate. |
| RCV-B03 — shortlist/comparison | **APPROVED temporary session-only shortlist** | Anonymous session shortlist/comparison; no persistent save/share in that first slice. | Later RCV-B08 separately approved a narrow private saved-items capability; that does not convert the anonymous shortlist into persistent or shareable state. |
| RCV-B04 — search/filter completeness | **APPROVED bounded local/CI scope** | Registry-governed filters and approved searchable public facts; no external search service, AI, real data or production. | Implementation merged in PRs #324/#325; production/public data acceptance remains separate. |
| RCV-B05 — language/content | **APPROVED** | English and Urdu interface; preserve institute facts in their original approved/source language; no automatic translation; language choice is session/URL scoped. | Synthetic implementation merged in PR #327; manual accessibility/qualified conformance review remains outstanding. |
| RCV-B06 — geography | **APPROVED policy and bounded synthetic proof-of-concept** | Manual locality remains default. Future nearby discovery must be optional/request-time only, use approved approximate institution/campus/delivery-site coordinates with explicit precision, confidence and provenance, and never store a student's/guardian's device location. Maps/geocoding/vendor APIs require separate cost/privacy/security approval. | Synthetic nearby ranking merged in PR #331. Real coordinates, device geolocation, maps, geocoding, schema change and vendor activation remain unauthorized. |
| RCV-B07 — SEO/crawl/performance | **APPROVED policy decisions** | No indexing until a public origin/release is separately approved; later index only stable approved directory/profile pages; noindex search/filter/pagination/compare. Sitemap waits for approved origin and safe enumeration. Numeric SLOs require representative evidence and separate owner approval. | Fail-closed crawl controls and synthetic performance measurement merged; no public indexing, sitemap activation, public origin or production SLO is accepted. |
| RCV-B08 — private saved items | **APPROVED bounded private saved-items slice** | Pre-provisioned active/verified accounts only; no public registration, sharing, alerts or external message delivery; anonymous session shortlist unchanged; owner deletion supported; no automatic retention duration selected. | PR #340 implementation merged; public account lifecycle, sharing and alerts remain deferred. |
| RCV-B09 — public reviews/moderation | **RETAIN DISABLED / POST-LAUNCH** | Public UGC, ratings, reviews, reporting, appeals and moderation activation remain disabled. | Synthetic moderation foundations do not authorize public UGC or staffed moderation operations. |
| RCV-B10 — live source and AI | **RETAIN DISABLED / RESEARCH-ONLY** | No live source access/collection, source-owner contact, model/provider, external API, connector, scheduler, agent activation or spend. Deterministic fake adapter is for synthetic local/CI tests only. | Source-rights, privacy, security, provider, cost, human-governance and activation gates remain blocked. |
| M3-10 — Option B | **SELECTED for future pilot proposal preparation only** | A narrowly bounded future pilot proposal may be prepared for separate review. It does not authorize pilot charter execution, participant contact/recruitment/consent, human usability sessions, real data or hosted activity. | M3-10 readiness-preparation agenda is closed; pilot readiness remains NOT ACCEPTED and no pilot go/no-go exists. |
| M3-11 — Option A / Option 1 | **SELECTED limited V2 product scope; private acceptance environment only** | Existing anonymous directory/search/profile and manual text-locality scope; internal named reviewers/operators only if separately authorized and accepted; synthetic fixtures; no public audience, participants, real/source/personal data, pilot, public launch or production execution. | M3-11-01 scope/authority is closed. M3-11-02–10 remain independently gated; M3-11 overall remains BLOCKED / NOT ACCEPTED. |
| No child/student/guardian data | **ACCEPTED binding restriction** | No child/student/guardian accounts, profiles, personal records, child-directed features, participation or child-related data collection in the current private scope. | No legal/safeguarding certification is implied. |
| Pre-launch research deferral | **ACCEPTED binding deferral** | No interviews, surveys, recruitment, outreach or participant testing under the current authorization. | Research deferral remains a pilot prerequisite, not waived by synthetic testing. |
| V1/V2 separation | **ACCEPTED binding restriction** | No V1 inspection/use or V1/production database/resource modification in current M3 scope. | Repository-only and synthetic CI work do not require V1 access. |
| Automatic PR merge | **ACCEPTED workflow policy** | Eligible PRs merge after required checks pass on the exact latest head SHA and all review/conflict/branch/policy conditions are satisfied. | This is why PRs #361–#363 were merged after exact-head PHP 8.5 and documentation checks passed. Destructive data, production, deployment/cutover and security exceptions remain separately gated. |

## 3. Deeni Madaris — dated future-inclusion clarification

The original V2-DEC-006 remains historically valid for the initial default-hidden implementation: Deeni Madaris is a distinct underlying provider category, and its public visibility was originally set to OFF by default, with no sect/maslak as a general discovery attribute.

A later Product Owner clarification on 2026-11-19 amended the **future product direction**:
- Deeni Madaris is to be included in the future directory as a distinct, clearly identified category.
- Relevant institution details should be available for future student/parent discovery; the earlier “OFF” posture is not a permanent exclusion from the long-term product.
- This future-inclusion decision does **not** authorize current M3-11 private-acceptance publication, public exposure or activation.
- The current M3-11 Option A / Option 1 private acceptance boundary continues to suppress Deeni Madaris with zero exposure until a separate scope amendment and all applicable source-rights, privacy, safeguarding, security, data-governance and publication controls are accepted.
- Do not collect, infer or expose sect/maslak as a general discovery attribute.

This is a temporal/scope distinction, not a contradiction: future product inclusion is accepted; current private-release exposure remains OFF. The original V2-DEC-006 is preserved and amended below in the decision register; the M3-11 Option A charter remains the controlling current private-acceptance exclusion.

## 4. R1 approval sequence — traceability limitation

The prior Product Owner approval sequence R1.1–R1.18 is carried forward as accepted:
- R1.1: Option A / Option 1 accepted unchanged.
- R1.2: student discovery and institutional requirements accepted as the provisional long-term baseline with three clarifications.
- R1.3–R1.17: approved, with flexibility for future updates.
- R1.18: approved.

The current main repository does not contain a canonical item-by-item decision record for the full R1.1–R1.18 sequence or the exact wording of the three R1.2 clarifications. This F04 record does not invent missing descriptions. The approvals remain accepted and are not reopened; F05 may only map each item to a requirement where its exact text is available in the source requirement/decision record. Any missing text is a traceability/documentation gap, not a reason to ask the Product Owner to approve the same decisions again.

**Do not confuse this sequence with M3-07 R1 — Pakistan National Education Source Master Inventory.** M3-07 R1 is a separate source-research deliverable; its owner acceptance and G2–G9 source/AI activation gates are distinct.

## 5. Decisions intentionally not inferred

The following have not been approved merely by the decisions above:
- Qualified legal/privacy/safeguarding assessment or independent security/accessibility assurance.
- Live source access, source reuse, scraping, retrieval, ingestion or publication.
- Model/provider/connector/scheduler/agent activation or external API use.
- Public indexing, sitemap generation, canonical public origin, production SLO or public launch.
- Hosted V2 isolation acceptance, database connection/migration, backup/restore, recovery rehearsal or RPO/RTO.
- Human reviewer/operations role appointments, candidate creation, GO/NO-GO, production execution or monitoring.
- New paid services, hosting upgrades, infrastructure, vendor commitments or additional spend.
- Any change to current M3-11 private acceptance exclusions.

## 6. F04 outcome

**F04 COMPLETE — previously approved Product Owner decisions consolidated without reopening unchanged approvals.**

The decision register amendment and current-scope charter clarification are recorded separately. All accepted decisions remain binding within their stated scope; implementation and external/operational evidence remain independently classified in F05. M3-11 remains BLOCKED / NOT ACCEPTED.
