# M3-04 P01 — Provider/Institution Implementation Record

**Status:** Implementation submitted for exact-head CI and review  
**Architecture decision:** Reuse the existing claim/version, evidence-link, human adjudication and audit workflow. The entity relationship row is a governed projection, not an approval record.  
**Scope:** Provider → Institution predicates: operates, owns, administers.

## Selected integration

P01 uses the existing claim/version governance workflow. A proposal is a proposed provider_institution_relationship claim version containing structured source, target, predicate, scope and jurisdiction values, inclusive valid-time bounds, and evidence links. The existing adjudication workflow remains the sole acceptance authority.

A relationship projection is created only after a persisted human accepted adjudication, a current accepted claim version, and currently admissible, unrevoked evidence. It stores a unique claim_version_id reference. Projection creation and its audit event share one transaction. Materialization requires a human actor with the materialize_relationship capability and uses audit-backed idempotency.

Unknown and reserved predicates fail closed. The only enabled predicates are operates, owns and administers. Authority, Campus, Programme, Qualification, Awarding Body and Delivery Site relationships remain reserved for later packages.

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

## Deferred scope

Identity merge/split and duplicate-candidate adjudication are not implemented; similar labels remain separate identities. P02/P03 predicates, relationship-specific public publication surfaces, public read endpoints, production operations and deployment remain excluded.

All fixtures are fabricated and synthetic. No V1, Hostinger/hPanel, production/live database, source acquisition, real institutional records, external API/AI, real role provisioning, deployment or new spend is included.
