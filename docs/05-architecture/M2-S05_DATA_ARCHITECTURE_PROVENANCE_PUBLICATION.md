# M2-S05 — Data Architecture, Provenance and Publication Governance

**Status:** Conceptual data-governance design; owner acceptance pending  
**Depends on:** Accepted S02/S03; S04 evaluation in progress  
**Scope:** Logical data domains, lineage, rights gates, retention principles, validation, publication and correction. No physical schema, data collection or ingestion is authorized.

## 1. Design objectives and invariants

The platform must explain where a public fact came from, what it means, when it was valid, when it was observed, who reviewed it, why it was published, and how it can be corrected or withdrawn. Evidence, normalized assertions and public representations are separate layers. A source record is not automatically true; extraction is not verification; verification is not publication; publication is not permanent truth.

Invariants:
- Every public high-impact fact must be traceable to one or more evidence items and a publication decision.
- No source is accessed or copied before source-specific rights/security/privacy/method approval.
- Evidence rights may prohibit storing a source copy; preserve a permitted reference and minimum metadata instead.
- Source-native wording and identifiers are retained when permitted; normalized values never erase provenance.
- Conflicts coexist until an authorized review disposition; “newest wins” is not a policy.
- Corrections supersede earlier assertions; they do not silently overwrite history.
- Public projections expose only approved, audience-eligible facts and never raw private evidence.
- Deeni Madaris suppression is applied before public projection and all downstream indexes/aggregates.

## 2. Logical data domains

| Domain | Responsibility | Example concepts |
|---|---|---|
| Identity and reference | Stable entities, aliases and source-scoped identifiers | Provider, institution, campus, authority, programme, qualification |
| Source registry and authorization | Publisher identity, authority, terms, purpose, permitted method, approval and expiry | Source, rights assessment, access grant, review date |
| Evidence and capture metadata | Material that supports a claim and its integrity/context | Evidence item, URI/reference, checksum where lawful, capture method, observation time |
| Assertion and fact history | Normalized claims, subject/property/value, temporal validity and confidence/uncertainty | Recognition, affiliation, fee, admission deadline, address |
| Review and adjudication | Validation, conflict, correction and delegated approval | Review task, reviewer, decision, rationale, appeal |
| Publication and distribution | Audience/surface-scoped publication decisions and derived views | Public profile, search document, map point, API projection |
| Operational/audit | Attributable activity, job execution, access and policy changes | Audit event, correlation ID, job result, revocation event |

These are logical domains, not database schemas or deployment services.

## 3. Provenance and lineage model

A claim's lineage is:

```mermaid
flowchart LR
  Source[Registered source] --> Gate[Rights and access authorization]
  Gate --> Evidence[Evidence item / permitted reference]
  Evidence --> Extract[Extracted source-native claim]
  Extract --> Normalize[Normalized assertion]
  Normalize --> Validate[Validation and conflict assessment]
  Validate --> Review[Human review / adjudication]
  Review --> Decision[Publication decision]
  Decision --> Projection[Public profile / search / map / API projection]
  Projection --> Correct[Correction / withdrawal / expiry]
  Correct --> History[Retained decision and lineage history]
```

### Minimum provenance envelope (conceptual)
- Source identity and source-scoped record identifier, where available.
- Source owner/publisher and jurisdiction/authority.
- Source type and authority classification relevant to the particular fact.
- Source URL or lawful locator, access method and rights/authorization record reference.
- Capture/observation time, source-native effective date and last-seen time.
- Evidence integrity metadata (e.g. digest) only where lawful and useful.
- Original source wording/value and normalized assertion, kept distinguishable.
- Transformation/extraction method and version, including human or AI assistance.
- Reviewer/decision actor, decision timestamp, rationale and confidence/uncertainty.
- Supersession, retraction, dispute and publication lineage.
- Permitted audience, surfaces, purpose, retention and deletion/withdrawal obligations.

Never store credentials, tokens, unnecessary personal data or restricted source content in provenance metadata.

## 4. Rights, security and privacy gates

### Source authorization state
`unassessed → assessed → approved_for_defined_purpose_and_method` or `denied / expired / suspended / revoked`.

An approval must identify the source, dataset/record scope, purpose, access method, copying/storage permissions, transformation/derivative rights, attribution, redistribution/publication limits, personal-data implications, retention/deletion terms, review date and accountable approver. Approval for one source or method does not extend to another source, endpoint, format, purpose or automated agent.

Before retrieval:
1. Identify the actual source owner and applicable terms.
2. Assess copyright/database rights, contract/robots/API terms and jurisdiction.
3. Assess privacy, security, minors and sensitive data exposure.
4. Define minimum necessary fields and whether a source copy may be retained.
5. Record approval and expiry; deny by default when unclear.
6. Reassess on terms, purpose, endpoint or ownership changes.

Public accessibility is not permission. No source owner outreach, permission request, scraping, bulk download, connector activation or ingestion is included in this milestone.

### Data minimization and retention
- Collect only fields necessary for a documented platform purpose.
- Prefer non-personal institutional facts; keep student/user data separate from education-provider facts.
- Define retention by data class, legal basis, rights terms and operational need; do not invent a universal retention duration.
- Separate source-copy retention from assertion/history retention. A lawful obligation to delete a source copy must not be defeated by retaining its full content elsewhere.
- Retain audit evidence only for a justified period and restrict access.
- Provide correction, deletion, access restriction and source-revocation workflows where applicable.
- Use privacy-safe logs, short-lived access tokens and explicit redaction.
- Any legal obligations under Pakistani law and any other applicable jurisdiction require specialist legal review before launch.

Reference principle: purpose limitation, data minimization, accuracy and storage limitation are established in GDPR Article 5 as a useful design reference where applicable; this document does not claim GDPR applies to every V2 processing activity. [European Commission GDPR principles](https://commission.europa.eu/law/law-topic/data-protection/information-business-and-organisations/principles-gdpr_en) · [GDPR Article 5](https://eur-lex.europa.eu/eli/reg/2016/679/oj/eng/)

## 5. Validation and conflict handling

Validation layers:
1. **Structural:** required fields, type, format, source scope and schema/version.
2. **Semantic:** domain relationships, valid values, programme/campus/cycle scope and authority jurisdiction.
3. **Temporal:** effective periods, observed dates, stale/expired status and chronology.
4. **Provenance:** evidence exists, source is authorized, transformation is traceable and rights allow intended use.
5. **Identity:** subject resolution is sufficiently certain; ambiguous merges require human adjudication.
6. **Cross-source:** corroboration and contradiction assessed using fact-specific source authority, not recency alone.
7. **Publication:** audience, privacy, source restrictions, visibility category and completeness policy pass.

Conceptual assertion states: proposed, normalized, awaiting evidence, under review, corroborated, disputed, approved, rejected, superseded, retracted, stale. Preserve source-native status separately.

Conflict resolution records:
- competing assertions and their evidence;
- authority/scope analysis;
- temporal applicability;
- reviewer identity and delegated permission;
- decision rationale and confidence/limitations;
- appeal or reconsideration route;
- publication impact and correction notice if needed.

High-impact facts (recognition, affiliation, eligibility, fees, deadlines and current admissions availability) require qualified human review before public publication. AI extraction/classification may propose values only.

## 6. Publication governance and rollback

A publication decision is explicit, versioned and scoped by:
- target assertion/entity;
- public or restricted audience;
- permitted surfaces (profile, search, browse, map, comparison, API, export);
- effective/publish/expiry time;
- reviewer and delegated authority;
- evidence/rights basis;
- policy checks and any redactions;
- superseded decision and rollback target.

### Publish sequence
1. Commit approved assertion and decision to authoritative history.
2. Generate a versioned public projection from eligible decisions.
3. Apply audience, privacy, source-rights and category visibility policy.
4. Update search/map/count/sitemap/API projections through a controlled, idempotent process.
5. Verify policy propagation and record projection version.
6. If any critical policy check fails, keep the affected data unpublished (fail closed).

### Correction / withdrawal
- Freeze the affected projection when material rights, accuracy or privacy risk is identified.
- Record the correction/withdrawal decision with reason and actor.
- Remove or replace affected public projections and invalidate caches/indexes.
- Verify all public surfaces and exports; retain only lawful minimal audit lineage.
- Notify affected parties where required by policy/law.
- Re-publish only after fresh approval.

A rollback restores a prior approved publication state; it must not delete evidence of the intervening error or conceal who made the change.

## 7. Freshness and source revocation

Freshness is fact-specific. Each source class requires an owner-approved refresh expectation and a public stale/unknown state. No universal refresh interval is assumed. A source's authorization expiry/revocation blocks new retrieval immediately; it also triggers review of previously captured content and derivative/publication rights. Do not assume a previously public page remains licensed for indefinite republication.

## 8. Access separation and audit

Separate source acquisition authorization, evidence validation, high-impact review, publication, moderation and system administration where practical. A person may hold multiple roles only under explicit least-privilege policy and compensating review. Record source access attempts, rights changes, assertion edits, review outcomes, publication/withdrawal, visibility-setting changes and privileged access. Audit records must be tamper-evident, time-correlated and free of secrets.

## 9. Requirements trace and open design

Maps AR-005–AR-007, AR-013–AR-015, AR-019, AR-023–AR-025 and M1 G02/G03/G05/G08/G09/G14/G16/G17/G20. S07 will refine the AI data-agent pipeline; S08 will refine personal data and identity controls; S09 will set operational retention, backup and recovery objectives.

Open: source-specific rights matrix; legal retention schedule; exact evidence-copy rules; fact-specific authority hierarchy; source refresh cadences; review staffing and delegation; event/index consistency strategy. These require owner/legal/security decisions and do not block this conceptual baseline.

## 10. S05 exit checklist

- Logical data domains and provenance lineage are explicit.
- Source-specific rights approval precedes access and copying.
- Assertion, evidence, validation and publication are separate.
- Conflict, correction, withdrawal, retention and revocation are governed.
- High-impact facts require human approval.
- Public projections enforce audience, privacy and category visibility.
- No physical schema, source collection or ingestion is authorized.
