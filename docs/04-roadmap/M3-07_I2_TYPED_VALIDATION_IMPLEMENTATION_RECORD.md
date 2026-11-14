# M3-07 I2 — Typed Validation and Applicability Implementation Record

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Package:** I2 — Typed Validation and Applicability  
**Baseline:** I1 PR #198, branch `feature/m3-07-i1-field-registry`, validated head `b6036687c219f79234609d549669448ca84fb3a5`  
**Status:** Implementation and first exact-head CI validation passed; final PR metadata closeout pending.

## 1. Owner decision and bounded scope

The owner confirmed:
- accept the validated I1 implementation in PR #198 as the I2 baseline;
- adopt D1's lowercase ASCII `snake_case` field-key convention;
- proceed with I2 only.

I2 implements pure, deterministic validation for:
- field-key syntax;
- supported value types and bounded type schemas;
- field cardinality using caller-supplied counts;
- explicit entity type, provider category and exact scope;
- locale allowlists and locale syntax;
- controlled units and currency;
- ISO dates, date ranges and caller-supplied freshness timestamps;
- privacy classification, audience visibility and prohibited data classes.

## 2. Files

1. `app/Services/Directory/TypedFieldValueValidator.php` — pure validator; no persistence or framework/database dependency.
2. `tests/Feature/TypedFieldValueValidatorTest.php` — deterministic synthetic tests.
3. This implementation record.

No existing I1 files, migrations, claim services, provider services, governance workflows, public routes, projections or search code are modified.

## 3. Validation boundary

The validator:
- receives one exact definition snapshot and all context as arguments;
- performs no database reads or writes;
- does not infer provider category or parent/child applicability;
- requires explicit entity-type, provider-category and scope allowlists;
- uses caller-supplied existing-value counts and evaluation timestamps;
- returns stable reason codes and paths only, not submitted values;
- rejects unknown value types, malformed schemas, missing values, unbounded structures and unsupported policy states;
- does not resolve entity-reference existence; the future caller must use a governed entity resolver;
- does not grant source authorization, verify evidence, register claims, adjudicate, publish or materialize projections.

D1's restricted Deeni Madaris policy remains default-OFF. The pure validator rejects the reserved category aliases `deeni_madaris`, `madrasah` and `deeni_education`; no category is activated.

## 4. Supported value validation

The implementation covers D1's bounded type families:
- short/long text;
- integer, fixed-precision decimal and boolean;
- ISO date and explicitly inclusive/exclusive date range;
- HTTP(S) URL without embedded credentials;
- institutional email with an explicit allowed-domain list;
- normalized E.164 phone;
- allowlisted enum;
- money with decimal precision, ISO-shaped currency, allowlisted currency, period and component;
- duration with controlled units;
- allowlisted language code;
- UUID entity reference with permitted target entity types;
- bounded object with allowlisted properties, required keys, depth/key/byte limits;
- bounded collection with item schema and size limits.

The validator is deliberately conservative. A field whose policy/schema omits required constraints fails closed rather than receiving a guessed default.

## 5. Key-format reconciliation

D1 recommends lowercase ASCII `snake_case` keys, 3–80 characters, starting with a letter. The I2 validator enforces this convention.

D4's illustrative catalogue currently uses dotted example keys (for example, `institution.display_name`). Those examples are not treated as production identifiers and are incompatible with the now-confirmed D1 convention. Before any later fixture-seeding or I3 work, the D4 catalogue should be normalized to snake_case in a separately reviewed documentation update. I2 does not rewrite the I1 baseline or the D4 design PR.

## 6. Tests

The synthetic test suite covers:
- snake_case acceptance and dotted/uppercase/short-key rejection;
- explicit entity/provider/scope checks and restricted-category rejection;
- one, zero-or-one and bounded-many cardinality;
- text bounds, null/missing values and malformed schemas;
- integer, decimal, boolean, date and date-range validation;
- URL, institutional email and E.164 phone;
- enum, language and entity-reference allowlists;
- money/currency and duration/unit constraints;
- bounded object and bounded collection shape limits;
- locale allowlists and freshness windows with fixed timestamps;
- privacy restrictions and internal-only/public audience separation;
- stable safe error shape.

All fixtures are synthetic literals. No real provider/student data, URLs, source content or external services are used.

## 7. Explicit non-actions

I2 does not:
- add or modify migrations/tables/columns/indexes;
- write claims, claim versions, evidence links, audit events or outbox records;
- bind claim versions to field definitions;
- alter generic claim registration or add a bypass guard;
- create definition review/approval/activation workflows;
- change profiles, directory search, public projections or UI;
- implement an AI agent, source monitor, connector, API, scheduler or scraping;
- access production, V1, Hostinger/hPanel or any live database;
- deploy, publish, procure services or incur additional spend;
- authorize I3 or any later package.

## 8. Acceptance and validation record

I2 acceptance requires all of the following on the exact final PR head:
- [ ] only the three listed I2 files are changed;
- [ ] validator has no database/network/clock side effects;
- [ ] all D1 type families have deterministic bounded validation;
- [ ] malformed or unknown policy/schema fails closed;
- [ ] applicability is explicit and non-inheriting;
- [ ] locale, unit, temporal/freshness and privacy rules are covered;
- [ ] synthetic focused tests pass;
- [ ] full repository synthetic suite passes;
- [ ] PHP 8.5 foundation CI passes;
- [ ] project documentation validation passes;
- [ ] no I3 or excluded capability is introduced.

**Validated implementation head:** `e61a93f3ef66efe4dfcfe7a4222c1d48a2d1091d`  
**Focused/full test result:** 15 validator tests passed; full synthetic suite passed with 478 assertions and 118 pre-existing missing-`.env` warnings.  
**PHP 8.5 foundation CI run:** #43576235840 — SUCCESS  
**Documentation validation run:** #43576235849 — SUCCESS

The PR closeout commit will update this record and trigger a final exact-head rerun. The final head and its run IDs will also be recorded in the PR evidence comment.

A successful I2 PR does not authorize I3. I3 requires separate owner approval and a separate bounded package.
