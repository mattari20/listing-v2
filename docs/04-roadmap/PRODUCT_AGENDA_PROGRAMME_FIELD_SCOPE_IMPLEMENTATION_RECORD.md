# Product Agenda — Governed Programme Field Scope

Status: Implementation candidate; subject to exact-head CI and merge verification  
Repository: `mattari20/listing-v2`  
Base revision: `5e74ca3442a8ecd513dd04a8d56859a44a503dcd`

## Purpose

Extend the existing governed field registry and human-operated field-claim lifecycle to support explicitly programme-scoped definitions and values. This is a product agenda implementation record, not a new official M3 agenda identifier and not a rewrite of the historical M3-07 I3/I5/I6/I7/I8 records.

## Implemented boundary

- Field definitions may declare either `institution` or `programme` scope.
- Scope and subject applicability must match exactly: institution scope permits only the institution entity type; programme scope permits only the programme entity type.
- Provider-category applicability remains an explicit allowlist on each immutable field-definition version.
- An institution obtains its category only from its current human-governed provider-category assignment.
- A programme obtains category context only through one active `programme_catalogue_entries` relationship whose exact linked claim version is accepted, current (no successor), and whose claim subject/predicate and stored value match the programme and parent institution relationship.
- Parent category is applicability context only. Institution field definitions and values are not inherited by programmes.
- Human field-value proposal, correction and reinstatement services resolve the exact subject entity's category context through the registry reader.
- The synthetic agent proposal adapter remains fixed to its existing synthetic institution fixture. Programme scope does not authorize an AI/agent programme adapter.
- Existing exact definition-version binding, typed validation, evidence/source authorization checks, human editorial review, and separate publication decision/projection controls remain in force.

## Explicit exclusions

- Campus, admission-cycle, fee-schedule, scholarship, qualification, awarding-body or authority relationship field-value scope.
- Any schema migration or persistence redesign.
- Real institute/student/child/guardian/staff data, source browsing, collection, crawling, ingestion or institution contact.
- AI/provider activation, external APIs, schedulers, new dependencies, paid services or additional spend.
- Production/V1/Hostinger access, live database work, deployment, DNS changes, public launch or participant activity.
- Public reviews, ratings, user-generated content or moderation.
- Any change to Deeni Madaris default-OFF and zero-public-exposure controls.

## Synthetic acceptance coverage

- Programme definition proposal is accepted only when the declared scope and entity-type allowlist both identify `programme`.
- Institution/programme scope mismatch is rejected before persistence.
- Programme field-value proposal succeeds only when an active accepted catalogue relationship matches the programme entity, parent institution, title, description and level.
- Programme value proposal binds the exact immutable programme definition version and enters editorial review only; it does not publish.
- Programme field-value correction creates a proposed successor retaining the exact original definition version.
- A tampered catalogue relationship fails closed.
- Existing institution-level tests remain in place.

## Data and safety semantics

Programme category context is not a general-purpose inheritance mechanism and does not make institution claims applicable to programmes. A field definition must explicitly allow programme scope and programme entity type. A public-eligible field definition is not publication permission; existing claim adjudication, publication approval, evidence eligibility, suppression and anonymous projection controls remain independent.

## Completion criteria

This agenda is complete only after:
1. Exact-head Foundation CI passes.
2. Project documentation validation passes.
3. The pull request is reviewed against its exact head and all changed files.
4. Merge succeeds with an expected-head SHA.
5. The merged PR and resulting `main` revision are verified.

Historical test warnings, if present, must be reported accurately; passing tests must not be described as warning-free.
