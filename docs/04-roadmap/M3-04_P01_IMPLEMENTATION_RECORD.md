# M3-04 P01 — Provider/Institution Implementation Record

**Status:** Implementation validated on PR #176; final documentation commit is undergoing the same exact-head checks  
**Architecture decision:** Reuse the existing claim/version, evidence-link, human adjudication and audit workflow. The entity relationship row is a governed projection, not an approval record.  
**Scope:** Provider → Institution predicates: operates, owns, administers.

## Selected integration

P01 uses the existing claim/version governance workflow. A proposal is a proposed provider_institution_relationship claim version containing structured source, target, predicate, scope and jurisdiction values, inclusive valid-time bounds, and evidence links. The existing adjudication workflow remains the sole acceptance authority.

A relationship projection is created only after a persisted human accepted adjudication, a current accepted claim version, and currently admissible, unrevoked evidence. It stores a unique claim_version_id reference. Projection creation and its audit event share one transaction. Materialization requires a human actor with the materialize_relationship capability, distinct from the adjudicator and evidence submitters, and uses audit-backed idempotency. Active overlapping assertions with the same endpoints, predicate, scope and jurisdiction are rejected; non-overlapping historical periods and explicitly distinct scopes remain representable.

The controlled entity vocabulary recognizes provider, institution, campus, delivery_site, programme, qualification, authority and awarding_body; identity registration is human-capability-gated, audited and idempotent. P01 relationship endpoint compatibility is strictly Provider → Institution. Unknown and reserved predicates fail closed. The only enabled predicates are operates, owns and administers. Authority, Campus, Programme, Qualification, Awarding Body and Delivery Site relationship workflows remain reserved for later packages.

## Lifecycle propagation

- Legacy relationship rows default to unverified.
- Accepted governed materialization creates an active projection.
- Source authorization revocation suppresses linked active projections.
- Claim withdrawal changes the linked projection to withdrawn.
- Claim correction changes the prior projection to superseded.
- The original claim versions and relationship rows remain for historical lineage.

## Files changed

- app/Domain/Directory/ProviderInstitutionRelationshipPolicy.php
- app/Services/Directory/ProviderInstitutionRelationshipService.php
- app/Services/Governance/GovernanceCommandService.php
- app/Services/Governance/PersistedGovernanceWorkflowService.php
- database/migrations/2026_11_14_000003_link_relationship_projections_to_claim_versions.php
- tests/Feature/ProviderInstitutionRelationshipTest.php

## Synthetic test coverage

The feature test file currently contains 17 focused tests covering controlled entity types and registration idempotency, Provider → Institution direction and endpoint compatibility, enabled/reserved predicates, evidence requirement and admissibility, human adjudication gating, inclusive/open-ended intervals, non-overlapping history, same-scope overlap rejection, distinct scopes, no implicit identity merge, audit rollback, and withdrawal/correction/revocation propagation. This is bounded feature coverage, not a claim that all 22 proposed P01-R01–R22 cases are individually implemented; the broader design matrix retains deferred cases explicitly.

## Exact-head validation evidence

Implementation code head: `d4a92a82b3882912cdddc57baca077d626989618`.

- PHP 8.5 foundation CI: run [#43547829025](https://github.com/mattari20/listing-v2/actions/runs/43547829025) — **passed**, including Composer validation/audit, Pint formatting, Laravel bootstrap/routes, synthetic-only tests and artifact hygiene.
- Project documentation validation: run [#43547829164](https://github.com/mattari20/listing-v2/actions/runs/43547829164) — **passed**.
- Synthetic test suite: **240 assertions, no failures**. The suite reports 67 warnings caused by the intentionally absent `.env` file; these warnings also occur across the pre-existing test suite and do not fail CI.
- PR reviews, inline comments and conversation comments: none outstanding at the time of reconciliation.

## Deferred scope

Identity merge/split and duplicate-candidate adjudication are not implemented; similar labels remain separate identities. P02/P03 predicates, relationship-specific public publication surfaces, public read endpoints, production operations and deployment remain excluded.

All fixtures are fabricated and synthetic. No V1, Hostinger/hPanel, production/live database, source acquisition, real institutional records, external API/AI, real role provisioning, deployment or new spend is included.
