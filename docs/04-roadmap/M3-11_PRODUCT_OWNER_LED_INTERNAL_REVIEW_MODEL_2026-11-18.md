# M3-11 — Product Owner-Led Internal Review Model

**Date:** 2026-11-18  
**Repository:** `mattari20/listing-v2`  
**Applies to:** M3-11-02 through M3-11-08 internal project review and governance  
**Owner direction:** The Product Owner has stated that no external reviewer is required at this time and that they will perform the project's internal review.  
**Status:** Review model accepted as the current working approach; substantive gate reviews and operational evidence remain pending.

## 1. Decision and scope

For the current development stage, the Product Owner is the sole internal reviewer and final internal acceptance authority. The project will not pause solely to appoint external reviewers.

The Product Owner may review project requirements, product/privacy/security/safeguarding checklists, code, tests, documentation, synthetic evidence and readiness records with AI-assisted explanation and analysis. The assistant may identify risks, perform permitted repository inspection, propose remediation and record the owner's decisions. AI analysis is supporting material, not a human approval or professional certification.

This decision changes the review workflow only. It does not create legal opinions, regulatory compliance certification, independent penetration-test assurance, formal accessibility conformance, or an exemption from any mandatory legal or operational requirement. No such claim may be made.

## 2. Review roles and accountability

| Role | Current assignment | Boundary |
|---|---|---|
| Product Owner / final internal reviewer | Project owner | Reviews evidence and records accept / reject / defer decisions |
| Engineering implementation and test support | AI-assisted, under owner direction | May inspect and change authorized repository scope; cannot approve its own work as an independent reviewer |
| Legal/privacy/safeguarding professional reviewer | Not appointed; deferred for current internal development stage | No professional or legal certification is claimed |
| Independent security/accessibility reviewer | Not appointed; deferred for current internal development stage | No independent penetration-test or WCAG conformance claim is made |
| Operations, incident, recovery, provisioner and verifier roles | Not appointed as separate people | Single-owner role concentration is recorded as a limitation; no live operation is authorized |

The Product Owner may hold multiple internal project roles during development. This concentration must be disclosed in every relevant review record. It is not equivalent to independent separation of duties and is not accepted as sufficient staffing for a public or production operation.

## 3. Required Product Owner review method

For each review area, the assistant prepares a bounded evidence pack and explains each item in plain language. The Product Owner records a dated disposition for every finding:

- **ACCEPTED — internal:** reviewed and accepted for the stated development scope only.
- **REQUIRES CORRECTION:** remediation is required before the relevant internal gate can pass.
- **DEFERRED:** not reviewed or not required for the current stage; downstream activities depending on it remain blocked.
- **NOT APPLICABLE:** supported by a written scope rationale, not assumption.

Each finding must include its evidence reference, scope/version, risk and impact, limitations, decision, remediation owner and retest evidence where applicable. Silence, a merged PR, passing CI or AI-generated analysis is not acceptance.

### Review workstreams

1. **Legal, privacy and safeguarding (M3-11-02):** Review the bounded product scope, data categories, source rights/provenance, retention/deletion, user rights, minors/children risks, sensitive affiliation risks, contact/UGC risks, advertising and future launch conditions. Record unresolved jurisdiction-specific legal questions as deferred blockers; do not state legal compliance.
2. **Security and accessibility (M3-11-03):** Review threat model, authorization boundaries, input validation, privacy/public-surface tests, dependency and secret hygiene, accessibility requirements, keyboard/semantic behavior and automated test evidence. Record that this is an internal review, not an independent penetration test or formal accessibility audit.
3. **Human operations (M3-11-04):** Record the current single-owner model, unavailable deputies, incident escalation limitations and role conflicts. Internal development can continue; live operations remain blocked until appropriate coverage is available or the scope is explicitly limited to an authorized private activity.
4. **Environment isolation (M3-11-05):** Review a proposed V2-only boundary and evidence checklist. No environment provisioning, Hostinger/hPanel access, DNS, production/V1/shared resource access or spend is authorized by this review model.
5. **Recovery (M3-11-06):** Review recovery objectives and a proposed synthetic-only rehearsal design. RPO/RTO remain unset until the Product Owner explicitly decides them. No backup, snapshot, restore or rollback action is authorized by this document.
6. **Candidate and decision (M3-11-07/08):** Continue to require a pinned candidate, complete evidence and a separate explicit Product Owner decision. Internal review does not itself create a candidate or issue GO.

## 4. Current owner decisions

| Decision | Current disposition |
|---|---|
| External legal/privacy/safeguarding reviewer appointment | DEFERRED — none required at this time for internal development |
| External security/accessibility reviewer appointment | DEFERRED — none required at this time for internal development |
| Product Owner as sole internal reviewer | ACCEPTED as the current working model |
| AI assistance | PERMITTED as analysis and implementation support, never as independent approval |
| Single-person operations coverage | LIMITATION RECORDED; not accepted as production/live-operations coverage |
| Environment provisioning or access | NOT AUTHORIZED |
| Recovery rehearsal / backup / restore | NOT AUTHORIZED |
| Release candidate creation | NOT AUTHORIZED by this decision |
| GO / public pilot / deployment / production execution | NOT AUTHORIZED |

## 5. Existing safety boundaries retained

The following restrictions remain in force unless separately and explicitly changed by the Product Owner in a scope-specific authorization:

- No production, V1, live database, Hostinger/hPanel, DNS or shared-production access.
- No deployment, public launch, pilot, real-user/participant activity or real personal/student/provider data.
- No external API, AI vendor, third-party service, new dependency or unapproved spend.
- No source ingestion or publication without source-specific rights and provenance approval.
- Deeni Madaris remains excluded, default-OFF and without public exposure.
- No backup, snapshot, restore, rollback, migration or data write outside the specifically authorized synthetic local/CI scope.
- No release candidate, GO decision or production execution from this document.

## 6. Gate status after this governance decision

This addendum changes who conducts the current internal review; it does not claim that the reviews or operational gates have been completed.

- M3-11-01: CLOSED for scope/authority definition.
- M3-11-02: Product Owner-led internal review model established; substantive owner review and dispositions PENDING. External professional review DEFERRED. No legal-compliance claim.
- M3-11-03: Product Owner-led internal review model established; substantive owner review and dispositions PENDING. Independent security/accessibility review DEFERRED. No certification claim.
- M3-11-04: Single-owner limitation documented; operational coverage remains BLOCKED.
- M3-11-05: BLOCKED / NOT AUTHORIZED; no environment or isolation evidence.
- M3-11-06: BLOCKED / NOT AUTHORIZED; no recovery rehearsal and RPO/RTO unset.
- M3-11-07: NOT STARTED / BLOCKED; no release candidate.
- M3-11-08: NOT DECIDED; no candidate-specific GO/NO-GO dossier.
- M3-11-09: NOT AUTHORIZED.
- M3-11-10: NOT STARTED.
- M3-11 overall: IN PROGRESS — INTERNAL REVIEW MODEL SET; NOT ACCEPTED FOR RELEASE OR OPERATIONS.

## 7. Next execution sequence

1. Present M3-11-02 owner checklist to the Product Owner, one section at a time; record decisions and unresolved questions.
2. Present M3-11-03 internal security/accessibility checklist and map findings to existing code/tests; fix permitted repository issues.
3. Complete the M3-11-04 single-owner operations risk assessment and document what cannot be covered.
4. Continue only the permitted, synthetic-only local/CI work already authorized elsewhere.
5. Reconcile M3-11-05 onward only when their exact prerequisites and separate authorizations exist.

**No gate is passed merely by merging this addendum.**
