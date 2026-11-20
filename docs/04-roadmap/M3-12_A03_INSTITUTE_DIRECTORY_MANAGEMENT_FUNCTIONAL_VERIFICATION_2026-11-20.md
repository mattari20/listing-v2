# M3-12 Agenda 03 — Institute Directory and Management Functional Verification

**Prepared:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Immutable review baseline:** 037e91a5e9348b8cc6d919a7aeccef441ecf6192  
**Review type:** Read-only implementation, route and synthetic feature-test evidence review  
**Status:** CORE INSTITUTE DIRECTORY AND MANAGEMENT WORKFLOWS HAVE STRONG SYNTHETIC SERVICE/FEATURE-TEST EVIDENCE; HUMAN, REAL-DATA, BROWSER AND HOSTED ACCEPTANCE REMAIN OUTSTANDING.

## 1. Purpose and safety boundary

This agenda verifies the existing institute directory and management foundation without duplicating delivered implementation. The review covers provider/institution identity and relationships, authority relationships, campuses and programme catalogues, dynamic field governance, university representative submissions/corrections, editorial review and the relevant public-directory safety boundary.

The review is limited to repository source, routes, documentation and existing synthetic tests on the immutable baseline above. No tests were executed as part of this read-only review; the test files and their current-main contents were inspected. No production or Hostinger/hPanel access, database connection, migration, source retrieval, real institution/student data, external service/AI, deployment, new dependency or spend occurred.

## 2. Evidence reviewed

| Capability | Current source/test evidence | Review result |
|---|---|---|
| Provider and institution identity/relationships | `ProviderInstitutionRelationshipService`; `ProviderInstitutionRelationshipTest` (17 test methods) | Strong synthetic service-level coverage |
| Regulatory, recognition, accreditation, licensing, affiliation and awarding relationships | `AuthorityRelationshipService`; `AuthorityRelationshipTest` (10 test methods) | Strong synthetic service-level coverage |
| Campus, delivery-site, programme, qualification and offer catalogue | `CampusProgrammeCatalogueService`; `CampusProgrammeCatalogueTest` (13 test methods) | Strong synthetic service-level coverage |
| Dynamic field definitions and lifecycle | `FieldDefinitionGovernanceService`; `FieldDefinitionGovernanceTest` (17 test methods) | Strong synthetic lifecycle and role-separation coverage |
| Exact-version registry reading and applicability | `FieldDefinitionRegistryReader`; `FieldDefinitionRegistryReaderTest` (10 test methods) | Exact-version and fail-closed coverage present |
| Typed field validation and privacy boundaries | `TypedFieldValueValidator`; `TypedFieldValueValidatorTest` (15 test methods) | Broad deterministic validation coverage |
| University representative submission/correction and review routes | `UniversityRepresentativeWorkflowController`; `UniversityRepresentativeWorkflowTest` (13 HTTP feature-test methods); `routes/web.php` | HTTP-level authorization and workflow coverage present |
| Editorial review/adjudication/publication boundary | `EditorialReviewService`; `EditorialReviewServiceTest` (5 test methods) | Synthetic service-flow coverage present |
| Public directory projection and exposure controls | `PublicDirectoryController`; `PublicDirectoryTest` (33 test methods) | Broad anonymous public-surface regression coverage |

Test-method counts above are source inventory counts, not a fresh execution result or a claim that every branch is covered.

## 3. Findings

### 3.1 Identity and relationships

- Provider and institution identities use a controlled entity-type vocabulary and idempotent registration.
- Provider-to-institution predicates are constrained; reversed/incompatible endpoints, reserved/unknown predicates, missing endpoints and missing evidence fail closed.
- Relationship materialization requires accepted human-governed claim state, admissible current evidence and a human capability; automated actors are rejected.
- Tests cover temporal validity, overlapping relationship prevention, distinct scopes/jurisdictions, idempotency, withdrawal, source-authorization revocation, supersession and audit-failure rollback.
- Authority relationships are typed by the authority's actual function. Recognition cannot be substituted by accreditation; each predicate has a specific authority-type contract. Scope, jurisdiction and temporal rules are tested.

**Disposition:** PASS for the inspected synthetic service contracts. This is not evidence that any real provider, institution or authority relationship is factually correct.

### 3.2 Campus and programme catalogue

- The catalogue distinguishes institutions, campuses, delivery sites, programmes, qualifications and programme offers rather than collapsing them into one record.
- Tests cover multiple distinct campuses, qualification/awarding-body links, explicit campus or delivery-site assignment, admission-cycle requirements, same-institution ownership and fail-closed identity/type validation.
- Materialized projections retain provenance and valid-time information; unadjudicated claims cannot be materialized.
- Claim withdrawal, source-authorization revocation and audit failure are tested against catalogue projections.

**Disposition:** PASS for the inspected synthetic catalogue and projection contracts. No real catalogue completeness, campus geocoding, fee accuracy or current admissions-cycle accuracy is established.

### 3.3 Dynamic field governance

- Field definitions are proposed, versioned, reviewed, approved and activated through separate lifecycle steps; proposer/reviewer/approver separation is tested.
- Exact definition versions are read without falling back to a newer version. Applicability is explicit by entity type, provider category and scope; inactive, future, expired, retired or mismatched definitions fail closed as specified.
- Typed validation covers bounded text, numeric/decimal/boolean/date values, URLs/contact formats, enumerations, language, money/duration context, bounded objects/collections, freshness and safe reason codes.
- Privacy rules prohibit sensitive personal data and internal-only fields from public audiences.
- Deeni Madaris remains restricted/default-OFF in the inspected validator and public surfaces.

**Disposition:** PASS for the inspected synthetic field-registry and validation contracts. This does not approve a new field, category, public exposure or live data-processing purpose.

### 3.4 University representative workflow

- The reviewed HTTP controller requires an authenticated, active, verified user with an exact institution-scoped authorization.
- Proposal submission is bounded by field/version, evidence-reference count, idempotency key and validity dates, and returns a submitted-for-editorial-review state rather than publishing.
- Corrections create immutable successors and re-enter editorial review.
- Reviewer scope and case/institution ownership are checked; the submitter cannot review their own case.
- Tests cover expired/revoked assignments, forged actor/capability/source fields, invalid/revoked evidence, changed-payload idempotency replay and atomic audit/status rollback.
- The reviewed route surface exposes representative submission, correction and editorial-review API endpoints; it does not establish a complete browser-based institution administration experience.

**Disposition:** PASS for the inspected synthetic HTTP authorization/workflow contract. Scope is specifically the implemented university-representative path, not a universal self-service workflow for every provider or institution type.

### 3.5 Editorial and public projection boundaries

- Editorial service tests exercise submission, independent review, separate adjudication and publication, with status history.
- Disputed review cannot proceed to publication approval.
- Public-directory tests verify anonymous search/profile allowlists, approved facts only, source-language preservation, manual locality, registry filters, pagination, unpublished/suppressed/revoked/expired fact exclusion, superseded-version handling, Deeni Madaris exclusion, safe URL rendering, HTML escaping and query-count stability.

**Disposition:** PASS for the inspected synthetic governance and public-surface regression contracts. These tests do not replace human editorial operations or an end-to-end accessibility/usability evaluation.

## 4. Residual gaps and acceptance limits

1. **No fresh test execution in this agenda.** The review inventories test methods and assertions from source. CI evidence must be tied to the exact delivery PR head before this agenda closes.
2. **No browser/end-to-end acceptance.** The reviewed tests establish service and HTTP behavior, but do not establish a complete real-browser journey for institute onboarding, catalogue administration or representative use.
3. **No real-world data validation.** No institute, campus, programme, affiliation, recognition, admissions or fee facts were retrieved or verified.
4. **No human operational acceptance.** The repository tests do not appoint or evidence actual institutional representatives, reviewers, adjudicators or support operators.
5. **No broad provider self-service claim.** The inspected representative controller is university-institution scoped; it is not evidence of an enabled self-service interface for all schools, colleges, academies, coaching centres or other provider categories.
6. **No hosted/production acceptance.** MySQL live compatibility, V2 hosting isolation, backups/restores, RPO/RTO, performance capacity, monitoring and production access remain separately gated.
7. **No legal, privacy, security or accessibility certification.** Independent/qualified assessments and manual accessibility review remain outstanding under M3-11.

## 5. Acceptance criteria and result

| Criterion | Result |
|---|---|
| Reconcile current institution/management capabilities against actual source and tests | MET |
| Identify identity, relationship, catalogue, field-governance and representative workflow controls | MET |
| Distinguish synthetic code evidence from real-world and human acceptance | MET |
| Record material gaps without duplicating or reopening accepted product decisions | MET |
| Preserve all M3-11 and project-wide safety boundaries | MET |
| Obtain exact-head PHP 8.5 foundation CI and documentation validation for the closeout record | PENDING PR VALIDATION |

**Agenda result before delivery validation:** Repository review COMPLETE; exact-head delivery validation PENDING. The agenda can be closed for the bounded repository-review scope only after both required checks pass and merge evidence is recorded.

## 6. Required follow-through

- Preserve the existing identity, provenance, claim, adjudication, field-registry and projection boundaries; do not create duplicate institution-management features.
- Treat browser acceptance, real-world data verification, representative participation, qualified reviews and hosted operations as separate gated work.
- Continue next with M3-12 Agenda 04 — Student Discovery Journey Functional Verification, using the existing directory, search/filter, locality, comparison, admissions facts, language and saved-items implementation evidence. Do not start new feature implementation unless a specific remaining gap is identified and separately authorized.

## 7. Explicit exclusions

No application or schema changes, migration execution, database connection, real/source/student/institute data, source retrieval, external API/AI/provider/connector, participant or representative contact, Hostinger/hPanel/V1/production access, backup/restore, deployment, public launch, new dependency/vendor or spend.

**Agenda 03 disposition:** COMPLETE for repository-level implementation and synthetic-test evidence review, subject to exact-head CI and documentation validation. No browser, real-data, human, hosted or production acceptance is claimed.
