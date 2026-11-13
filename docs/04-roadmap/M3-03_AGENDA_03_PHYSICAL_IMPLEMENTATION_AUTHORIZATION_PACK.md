# M3-03 Agenda 3 — Physical Implementation Scope and Authorization Pack

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Agenda:** M3-03 Agenda 3 — Physical Implementation Scope and Authorization Pack  
**Status:** Proposal prepared; implementation authorization not issued  
**Baseline:** Product Owner-accepted M3-03 logical design baseline (Agenda 2)  
**Execution mode for this agenda:** documentation-only; no physical design or implementation

## 1. Purpose

Convert the accepted logical design baseline into a precise, reviewable authorization request for the first physical implementation increment. This agenda does not create a physical schema, migrations, models, repositories, services, database, fixtures-as-seed-data or application behavior.

The Product Owner's Agenda 2 acceptance is design acceptance only. It is not authorization to implement the physical model.

## 2. Recommended first implementation increment

**Recommendation:** authorize one local/CI-only, synthetic-data-only persistence foundation increment, delivered through a protected GitHub pull request. Keep it isolated from V1 and all hosted/production systems.

The increment should be split into independently reviewable sub-slices:

### Slice A — Physical schema and migration contract

After explicit authorization:
- Translate only the accepted logical entities and relationships needed for the first vertical slice into Laravel migrations.
- Define stable identifiers, typed foreign-key relationships, uniqueness/integrity constraints and temporal interval handling.
- Preserve claim/version immutability and explicit supersession lineage.
- Model source authorization as scoped permissions, not a blanket source flag.
- Store evidence references/metadata only; do not acquire or store external source content.
- Include audit lineage for material state transitions.
- Keep publication projection and public endpoints out of this first slice.

### Slice B — Synthetic persistence and invariant tests

After Slice A and within the same separately approved scope:
- Use fabricated fixtures only.
- Test migration up/down behavior in a disposable local/CI database.
- Test relationship integrity, temporal intervals, immutable claim versions, authorization scope/revocation behavior, restricted-category fail-closed behavior and audit lineage.
- Confirm no fixture or test path can access a live/hosted database.
- Record exact test commands, environment and results.

### Slice C — Governance service boundary (only if separately included)

A later bounded increment may implement deterministic validation and human decision service boundaries. It must not activate external sources, AI, public pages, ingestion or autonomous publication.

## 3. Explicit proposed boundaries

| Area | Proposed first-increment treatment |
|---|---|
| Repository | `mattari20/listing-v2` only |
| Branching/delivery | Feature branch, PR, exact-head CI, protected merge |
| Runtime | Local development and GitHub CI only |
| Data | Fabricated synthetic fixtures only |
| Database | Disposable local/CI test database only, after environment capability is verified |
| Schema/migrations | Only the explicitly approved Slice A entities/relationships |
| V1 | Prohibited; no inspection, copying, adaptation or dependency |
| Hostinger/hPanel/SSH | No access |
| Production/live database | No access or connection |
| Source acquisition | None; no scraping, fetching, downloading, outreach or reuse |
| Evidence content | None; metadata references only |
| AI/external APIs/connectors | None |
| Public surfaces | None; no search, browse, sitemap, API or publication endpoint |
| Deeni Madaris | Remains default-OFF; no public surface is created |
| Deployment | None |
| Spend/procurement | None; no new spend |
| Repository protections | No ruleset, branch protection, required-check or review-policy changes |

If the required disposable test database cannot be provisioned within existing local/CI capabilities without new spend or a prohibited service, stop and request a separate decision. Do not silently substitute a hosted database or weaken tests.

## 4. Preconditions before implementation

The following must be confirmed in the authorization record before any physical implementation starts:

1. The exact Slice A entities and relationships to include.
2. Whether Slice B synthetic persistence tests are included in the same authorization.
3. The disposable local/CI database engine and method, with no live credentials or hosted connectivity.
4. Exact acceptance criteria and required CI checks.
5. Confirmation that no V1, Hostinger, hPanel, production or live database access is permitted.
6. Confirmation that no source content, real institution records, personal data, AI or external APIs are permitted.
7. Confirmation that no new spend, deployment or public exposure is authorized.
8. Confirmation that the scope expires at the stated slice/PR closeout and does not authorize later M3-03 work.

The current repository CI has passed the existing PHP 8.5 foundation workflow, but that does not itself establish database-driver availability or authorize a database service. Verify capability only within the approved local/CI boundary after authorization.

## 5. Acceptance criteria proposed for the first increment

- Migrations are deterministic and reversible in a disposable test environment.
- Foreign-key and typed-relationship constraints reject invalid endpoints.
- Provider–Institution remains a typed, time-bounded association with the accepted cardinality semantics.
- Claim dispositions and immutable version lineage are separate.
- No automatic identity merge is implemented.
- Authorization purpose, method, territory, retention, processing, reuse and publication scopes are not conflated.
- Revocation blocks further unauthorized activity and triggers dependent-claim revalidation/publication review.
- Missing or unknown restricted-category state fails closed.
- Material state transitions have auditable reason and actor-class lineage.
- Synthetic-only tests prove the invariants; no application-level feature is claimed without actual execution.
- CI passes on the exact PR head; no protection bypass or repository ruleset change.
- Final closeout records evidence, residual risks and explicit next-step boundary.

## 6. Deferred items

The following are not part of the proposed first increment:
- Real source permissions, source collection or evidence-content storage.
- Automated source ingestion, scraping or AI-agent work.
- Public projection, public directory, search, maps, sitemaps or APIs.
- Provider/admin UI, accounts, reviews, moderation or user interaction.
- Production/hosted runtime, Hostinger configuration, deployment or DNS.
- Legal/privacy/safeguarding/security certification or any claim of compliance.
- P04 hosted runtime/isolation/capacity/recovery proof, P05 specialist clearances and P06 hosted backup/restore/deployment/recovery evidence.
- Any new spend, vendor, paid service or procurement.

## 7. Product Owner authorization request

**Requested decision:** authorize or defer the proposed local/CI-only, synthetic-only first implementation increment.

If authorized, the authorization must explicitly state:
- Slice A only, or Slice A plus Slice B;
- the disposable test database method permitted;
- the acceptance criteria in Section 5;
- the exclusions in Section 3;
- that the authorization ends at the agreed PR closeout and grants no further M3-03, hosted, production, source, public-release or spend authority.

No work requiring physical schema, migrations, persistence or database execution may begin until this authorization is explicit and recorded.

## 8. Current disposition

- Agenda 1 logical model/provenance package: delivered and merged.
- Agenda 2 review and Product Owner design-baseline acceptance: delivered and merged.
- Agenda 3 authorization pack: prepared as a documentation-only proposal.
- Physical implementation: **Not authorized**.
- M3-03 overall: **In progress**.
