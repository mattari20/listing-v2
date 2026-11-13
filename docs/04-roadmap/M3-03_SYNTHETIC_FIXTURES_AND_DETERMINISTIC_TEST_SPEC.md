# M3-03 — Synthetic Fixtures and Deterministic Test Specification

**Agenda:** M3-03 Agenda 1 — Logical Domain Model and Provenance  
**Data classification:** Fabricated synthetic data only  
**Execution:** Specification and expected-result review; no application/database integration  
**Status:** Test specification prepared; runtime implementation intentionally excluded

## 1. Fixture safety

All identifiers and labels below are invented for test use. They are not intended to resemble real institutions, providers, authorities, people, addresses or source records. No URLs, phone numbers, emails, precise coordinates, student or staff attributes are included.

## 2. Synthetic fixture catalogue

| Fixture ID | Synthetic subject | Purpose |
|---|---|---|
| FX-001 | Provider `prov-synth-001` | Valid provider-to-institution relationship |
| FX-002 | Institution `inst-synth-001` | Basic institution subject |
| FX-003 | Site `site-synth-001` | Institution delivery-site relationship |
| FX-004 | Programme `prog-synth-001` | Programme delivered at a site |
| FX-005 | Authority `auth-synth-001` | Explicit authority relationship |
| FX-006 | Evidence reference `ev-synth-authorized-001` | Evidence metadata with synthetic active authorization |
| FX-007 | Evidence reference `ev-synth-revoked-001` | Evidence metadata whose authorization is revoked |
| FX-008 | Claim versions `claim-synth-name-v1/v2` | Versioning and supersession |
| FX-009 | Claim pair `claim-synth-status-a/b` | Incompatible overlapping assertions |
| FX-010 | Claim `claim-synth-stale-001` | Expired valid-time interval |
| FX-011 | Publication snapshot `pub-synth-001` | Approved allowlisted facts |
| FX-012 | Restricted category marker `category-synth-restricted-001` | Default-off suppression rule |
| FX-013 | Prohibited public field `private_contact_synth` | Privacy allowlist rejection |
| FX-014 | Audit event `audit-synth-001` | Required transition lineage |
| FX-015 | Correction/withdrawal event `withdraw-synth-001` | Removal from current public projection while retaining history |
| FX-016 | Qualification `qual-synth-001` and awarding body `award-synth-001` | Keep qualification distinct from programme and awarding body distinct from provider/regulator |
| FX-017 | Admission cycle `cycle-synth-001` | Scope offers, eligibility, deadlines and fees to a named cycle |
| FX-018 | Programme offer `offer-synth-001` | Bind one programme to one campus/site and one admission cycle |
| FX-019 | Fee component `fee-synth-001` | Preserve amount/period/effective interval as a scoped component |
| FX-020 | Scholarship offer `aid-synth-001` | Preserve eligibility, coverage and cycle-specific conditions |

## 3. Canonical synthetic input set

The machine-readable companion is `M3-03_SYNTHETIC_FIXTURES.json`. It contains fabricated entity references, claims, evidence metadata, policy flags and expected outcomes. It contains no source content or source locators.

## 4. Deterministic test cases

For every case, the same rule-set version and same fixture input must yield the same result. Tests must be side-effect-free and must not contact a database, network, filesystem outside the fixture bundle, external API or AI provider.

| Test ID | Input condition | Expected deterministic outcome |
|---|---|---|
| T-001 | Provider operates institution with compatible endpoint types and active interval | PASS |
| T-002 | Institution-site relationship references a missing institution | FAIL: missing_subject |
| T-003 | Relationship uses unknown predicate | FAIL: unknown_relationship_type |
| T-004 | Claim has valid-from later than valid-to | FAIL: invalid_valid_interval |
| T-005 | Two incompatible claims overlap in valid time for a single-valued predicate | CONFLICT: overlapping_incompatible_claims |
| T-006 | Same claims have non-overlapping valid intervals | PASS: temporal succession; no conflict |
| T-007 | Claim evidence uses revoked/out-of-scope authorization | FAIL: unauthorized_evidence |
| T-008 | Accepted claim has no admissible evidence path and no approved exception | FAIL: missing_admissible_provenance |
| T-009 | Evidence supports claim and integrity metadata is present | PASS: admissible evidence link |
| T-010 | Claim version supersedes prior version without deleting prior history | PASS: immutable version chain |
| T-011 | Newer recorded claim conflicts with older claim still valid in world time | CONFLICT: recorded-time recency does not auto-resolve valid-time conflict |
| T-012 | Validation passes but no human adjudication/publication decision exists | BLOCK: not_publishable |
| T-013 | Claim is disputed or stale | BLOCK: not_publishable |
| T-014 | Restricted category default-off flag is set | SUPPRESS: no public projection |
| T-015 | Public projection includes prohibited personal/contact field | FAIL: public_field_not_allowlisted |
| T-016 | Every published fact traces to accepted claim version and human publication decision | PASS |
| T-017 | Withdrawal event targets a currently published fact | PASS: remove from current projection; preserve prior snapshot and audit history |
| T-018 | Rollback selects a prior approved snapshot | PASS: create new rollback event; do not erase intervening events |
| T-019 | Material state transition has no audit event/reason | FAIL: missing_audit_lineage |
| T-020 | Repeated run with identical rule version and fixtures | PASS: byte-equivalent normalized findings and outcome |
| T-021 | Programme is linked to a qualification through a typed may-lead-to relationship | PASS: qualification remains distinct from programme |
| T-022 | A programme offer lacks a campus/site or admission-cycle scope | FAIL: incomplete_offer_scope |
| T-023 | Fee component is attached to an offer but omits currency, period or effective-time context | FAIL: incomplete_fee_scope; do not expose an unscoped total |
| T-024 | Awarding body is inferred from provider identity or regulator label without an explicit relationship | FAIL: unsupported_awarding_body_inference |

## 5. Test oracle and result semantics

- **PASS:** invariant holds for the fixture.
- **FAIL:** input violates a hard invariant; the finding is stable and named.
- **CONFLICT:** competing valid-time assertions are preserved and routed for human adjudication.
- **BLOCK:** data may be internally retained but cannot proceed to publication.
- **SUPPRESS:** policy prevents any public projection, independent of claim validity.
- **DEFER:** no decision is inferred when evidence or authority is insufficient.

Validation findings must include stable rule identifier, rule-set version, fixture/input identifier, outcome code and deterministic explanation. They must not contain invented personal data.

## 6. Expected-result review summary

The 24 test vectors above cover entity/relationship integrity, vocabulary, temporal validity, provenance authorization, immutable versioning, conflict detection, human decision separation, restricted-category suppression, public field allowlisting, audit completeness, correction/withdrawal, rollback and deterministic repeatability.

**Execution status:** specification-level expected results are defined. No application-level test code was added or run because the bounded authorization excludes persistence and application implementation. These are design acceptance vectors for a later separately authorized implementation test suite.

## 7. Implementation boundary

The fixture JSON and test cases are not database seed data. Do not import them into an application database. Do not use real or public-source records to “improve” the fixtures. Any runtime implementation or integration with Laravel, persistence, migrations, source acquisition or public output requires a separate authorization.
