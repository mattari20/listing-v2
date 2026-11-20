# RCV-B02 — Admissions and Programme Decision Facts: Scope and Acceptance Pack

**Date:** 2026-11-18  
**Repository:** `mattari20/listing-v2`  
**Original inspection baseline:** `main` at `0dfca8d998550c2aa52325c3b5bd90088fd77b44`  
**Work type:** Requirements and architecture preflight; documentation only  
**Disposition:** Scope pack prepared as the original pre-implementation design record. A subsequent explicit Product Owner authorization for the bounded synthetic implementation, including necessary in-scope schema changes, is recorded in `RCV-B02_IMPLEMENTATION_DESIGN_2026-11-18.md` and its implementation delivery. This scope pack itself remains a historical requirements/acceptance record, not the source of implementation authorization.

## 1. Purpose and governing decision

The Product Owner selected RCV-B02 as the first residual product capability after RCV-01. This package defines the narrow scope for cycle-scoped admissions and programme decision facts. The later implementation authorization does not authorize source collection, real data, production activity, launch, or any change to the binding exclusions.

RCV-01 identifies the existing programme catalogue, qualification links and cycle-scoped programme offers as implemented foundations, while identifying eligibility rules, admission deadlines, fee components, scholarships/aid, application-cycle lifecycle and source-backed public presentation as incomplete. RCV-01 requires this scope/acceptance pack before code and states that a schema change requires separate authorization.

## 2. Inspected existing V2 foundations

The following current-main files were inspected:

- `database/migrations/2026_11_14_000004_create_campus_programme_catalogue.php`: `programme_offers` currently stores programme, campus/delivery-site, admission cycle, status, valid-from/to and claim-version linkage. It has no structured eligibility, fee, deadline or aid fields.
- `app/Services/Directory/CampusProgrammeCatalogueService.php`: catalogue materialization requires a current accepted claim version, a distinct human adjudicator, admissible/unrevoked evidence and idempotency; it validates typed programme/location relationships and records an audit event.
- `tests/Feature/CampusProgrammeCatalogueTest.php`: synthetic coverage exists for programme/qualification/offer separation, explicit admission cycle, location ownership, accepted claims, provenance, withdrawal, source-authorization revocation and audit rollback.
- `app/Services/Directory/PublicDirectoryQueryService.php`: anonymous public output is derived only from approved current publication snapshots, current accepted claims and admissible evidence. Registry-managed fields must be public-eligible, have valid registry metadata and pass scalar validation. Evidence publication authorization is rechecked. Deeni Madaris projections are explicitly excluded.
- `app/Http/Controllers/PublicDirectoryController.php` and `routes/web.php`: public directory currently exposes read-only `GET /directory` and `GET /directory/{entity}`; there is no admissions/application submission route.

**Important boundary:** this inspection did not establish that the current field registry can represent offer-specific, cycle-scoped structured facts. The current public directory projection is entity/claim oriented, whereas `programme_offers` is a separate record keyed by offer ID. Do not assume that adding ordinary programme fields will preserve offer/cycle scope.

## 3. Proposed functional scope

One programme offer, for one explicit admission cycle and one institution-owned campus/delivery site, may have governed decision facts in these categories:

1. **Eligibility:** bounded, human-readable eligibility statements or structured criteria, with an explicit unknown/not-provided state where no supported fact exists.
2. **Deadlines:** application-open and application-close dates where supported; no inferred or calculated deadline.
3. **Fees:** separately identified fee components and currency/amount representation; distinguish unknown, not stated, not applicable and known zero. Do not calculate total cost unless a separately accepted deterministic rule is defined.
4. **Scholarships and financial aid:** bounded availability/description facts; distinguish confirmed availability, not stated, not applicable and unknown. No promise of award, eligibility or amount beyond the governed fact.

All facts must remain linked to:
- exactly one existing programme offer and its admission cycle;
- a claim/version or equivalent governed assertion;
- evidence reference and source authorization metadata;
- observed/recorded time and valid-time bounds where applicable;
- human adjudication and publication decisions;
- freshness/unknown/conflict state.

No real institution, programme, admission, fee, scholarship or source data may be introduced in this phase. Fixtures must be unmistakably synthetic.

## 4. Data and presentation contract

The candidate public contract must make these distinctions visible without implying completeness or certainty:

- **Known and current:** a currently approved, published fact with admissible evidence and a valid observation/validity window.
- **Stale:** a previously observed fact outside its defined freshness window; do not present it as current.
- **Unknown / not verified:** no accepted fact is available.
- **Not stated:** the governed source explicitly does not state the fact.
- **Not applicable:** the fact category does not apply to this offer.
- **Conflicting:** more than one unresolved current assertion exists; do not choose one silently.
- **Withdrawn / suppressed:** remove from anonymous public output when governance or source authorization is withdrawn/revoked.

Freshness must not be inferred from a display date alone. A field-specific freshness policy and its owner must be explicit before a fact is labelled current or stale. Do not invent a universal expiry interval in implementation.

Public provenance should use a safe, bounded display label and observation date only where the existing publication contract permits it. Raw evidence content, private source locations, authorization documents, internal actor identifiers, audit metadata, credentials and personal data must never be exposed.

## 5. Candidate implementation surface (not final authorization)

| Area | Candidate files / surfaces | Expected treatment |
|---|---|---|
| Domain persistence | Existing `programme_offers`; likely a new offer-scoped fact projection/table and migration if the current claim/registry model cannot encode offer scope | **Decision required.** Do not add columns or tables yet. |
| Governance | `CampusProgrammeCatalogueService`, claim field registry/validation, persisted adjudication and publication workflow | Reuse accepted-claim, evidence, human adjudication, authorization, withdrawal/revocation and audit controls; do not bypass them. |
| Public read model | `PublicDirectoryQueryService`, public profile view(s) and possibly a dedicated offer detail read model | Only approved anonymous facts; preserve cycle and offer association; no raw claim/evidence access. |
| HTTP | Existing `GET /directory/{entity}` read-only profile; any additional read route requires exact review in implementation plan | No write, application, registration, upload or contact-submission route. |
| Tests | `CampusProgrammeCatalogueTest`, `PublicDirectoryTest`, and focused new feature tests if authorized | Synthetic-only, disposable SQLite; no live services or production database. |
| Documentation | RCV-B02 implementation record, traceability and roadmap/backlog references | Record exact accepted scope, schema decision, test evidence and exclusions. |

### 5.1 Persistence design gate

Two candidate approaches require a repository-level design decision before code:

- **A. Offer-scoped governed fact records:** introduce a dedicated offer-fact identity/projection linked to `programme_offers`, claim versions and evidence. This preserves the offer/cycle relationship explicitly but likely requires schema and claim-subject integration changes.
- **B. Extend existing registry-managed claims:** only viable if the existing field registry and claim model can enforce offer identity, cycle scope, typed values, unknown states, provenance and publication without ambiguity or denormalized scope leakage.

The inspected public query path alone does not prove option B is safe. The next technical preflight must inspect the current registry migrations, field definitions, claim validation and publication snapshot creation. If a new migration/table or changes to core claim semantics are necessary, stop and request separate explicit authorization before implementation.

## 6. Privacy and threat review

- No student, child, guardian, applicant, staff or representative personal data; no application records, documents, grades, identity numbers, contact details or account-linked preferences.
- No application submission, admissions portal, payment, messaging, notification, scholarship application or eligibility decision engine.
- No sensitive demographic, health, disability, religion/sect/maslak or other protected-trait inference.
- No scraping, source acquisition, external connectors, APIs, model/provider calls or real source access.
- No public assertion from proposed/unadjudicated claims; no automatic publication; no bypass of distinct human adjudication.
- No public leakage of evidence payloads, private provenance, internal IDs, authorization scopes, moderation data or audit metadata.
- Reject cross-institution offer linkage, mismatched programme/campus, invalid dates, malformed amounts/currency, duplicate/conflicting fact keys and stale/withdrawn/revoked evidence.
- Deeni Madaris remains default-OFF and excluded from all public surfaces. No new category, filter, route or fixture may weaken this exclusion.
- Public UGC, ratings, reviews, reporting and moderation remain disabled.

## 7. Synthetic acceptance matrix

| ID | Acceptance requirement | Required evidence |
|---|---|---|
| B02-01 | Every fact belongs to exactly one existing programme offer and admission cycle | Synthetic test rejects missing, mismatched and cross-offer scope |
| B02-02 | Programme and delivery location remain institution-consistent | Cross-institution programme/location tests fail closed |
| B02-03 | Eligibility facts support explicit unknown/not-stated/not-applicable distinctions | Typed validation and public rendering tests |
| B02-04 | Deadline values are valid calendar dates and respect cycle validity | Invalid dates, reversed dates and out-of-cycle values rejected |
| B02-05 | Fee components preserve currency, amount and component identity; known zero differs from unknown | Decimal/currency validation and rendering tests; no silent total |
| B02-06 | Scholarship/aid facts do not imply award or guaranteed eligibility | State and copy-boundary tests |
| B02-07 | Provenance, observation time, validity and freshness are retained | Synthetic evidence/valid-time/freshness tests |
| B02-08 | Only current, accepted, independently human-adjudicated, authorized facts can be materialized/published | Proposed/unadjudicated, revoked, expired and unauthorized cases fail closed |
| B02-09 | Withdrawal, supersession, conflict and suppression remove or qualify public facts safely | Governance transition and public regression tests |
| B02-10 | Anonymous output exposes only approved safe labels/values and no raw evidence/internal metadata | Public profile allowlist and privacy regression tests |
| B02-11 | Unknown or absent facts are not represented as negative claims or zero values | Missing/unknown/zero distinction tests |
| B02-12 | Deeni Madaris remains excluded and no public UGC or application submission is introduced | Existing exclusion suite plus route inventory assertion |
| B02-13 | All fixtures and tests are synthetic and use disposable SQLite only | Changed-file audit and exact-head CI |
| B02-14 | No production, hosted, external, paid or V1 activity occurs | Scope/diff review; no external integration or deployment changes |

## 8. Explicit non-goals

- No live source collection, real data entry, scraping, source rights requests or external research.
- No AI, model, provider, connector, geocoder, payment, messaging or notification service.
- No production or Hostinger access, live database, hosted migration, deployment, public preview or launch.
- No public admissions application workflow, applicant accounts or personal-data processing.
- No recommendation/ranking, sponsored placement, shortlist, comparison, saved items or sharing feature (RCV-B03 is separate).
- No new dependency, vendor, paid service, procurement or spend.
- No V1 access, reuse, inspection or adaptation.
- No browser visual preview in this agenda; visual review remains deferred until the planned implementation agendas are complete.

## 9. Work sequencing and authorization gates

1. **Completed by this pack:** owner selection recorded; existing foundations inspected; proposed scope, candidate surfaces, privacy/threat controls and synthetic acceptance matrix defined.
2. **Next technical preflight:** inspect the exact current field-registry migrations, field applicability/validation, claim version model, publication workflow and view contracts to choose between persistence options A and B.
3. **Separate schema authorization:** required if the chosen design adds a table/column, changes a migration, introduces a new claim subject type, or alters core claim/publication semantics. No schema work begins without that authorization.
4. **Implementation authorization:** after the design gate, prepare an exact changed-file list and implementation slice. Proceed only within the approved scope.
5. **Validation:** run focused synthetic feature tests and applicable full FND-01 PHP 8.5 CI plus documentation validation on the exact PR head; inspect the final diff and exact head before any merge decision.
6. **Release boundary:** RCV-B02 completion does not close RCV-B03, RCV-B05 or M3-11, and does not authorize production, pilot, launch or public data activation.

## 10. Binding restrictions

All RCV-01 exclusions remain binding: V2 only; synthetic local/CI only; no real/source/personal data; no external services or AI; no production, Hostinger, live DB, deployment or launch; no new spend; Deeni Madaris default-OFF with zero public exposure; public UGC/reviews/ratings/reporting/moderation disabled; no student interviews, surveys, recruitment or outreach; no legal/privacy/security/accessibility certification claim.

**Current status:** RCV-B02 scope pack prepared. Implementation is **NOT STARTED**. Schema design and any schema change remain gated by separate owner authorization where required.
