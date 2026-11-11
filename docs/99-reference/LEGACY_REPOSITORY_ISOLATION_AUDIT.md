# Legacy Repository Isolation Audit

**Audit date:** 2026-11-11  
**Source repository inspected:** `mattari20/estudent-listing`  
**Source branch:** `main`  
**Observed source commit:** `d363fad00c15d6892677e452d5b1f383cbe892de`  
**V2 destination:** `mattari20/listing-v2`

## Binding isolation rule

The legacy project must have **no operational, technical, architectural, implementation, data, workflow, or deployment influence** on V2. This is stricter than merely avoiding code copying.

The legacy repository was inspected only to identify and explicitly exclude its artifacts. Its contents are not a source of V2 design decisions. V2 requirements and decisions must be authored from the V2 project charter and direct V2 owner requirements, then independently researched and validated.

## Prohibited transfer or dependency

Do not copy, adapt, port, import, depend on, or treat as a template any of the following from the legacy project:
- Application source code, libraries, modules, or code patterns.
- Database schemas, table/column definitions, migrations, migration ledgers, SQL, triggers, indexes, constraints, seed data or production records.
- Existing API contracts, routes, payloads, authorization rules or internal interfaces.
- CI workflows, GitHub Actions, deployment scripts, hosting configuration, secrets, environment files or operational runbooks.
- Existing architecture diagrams, bounded-context definitions, domain models, technology choices, naming conventions or UI/UX patterns.
- Existing task breakdowns, milestone plans, acceptance decisions, test suites, diagnostics, workarounds, defect fixes or release processes.
- Historical status reports or production findings as evidence of V2 readiness.

No V2 runtime, test, CI or development environment may connect to the legacy repository's production systems or data.

## Independent work rule

Every V2 requirement must be traceable to a V2 owner requirement, a new V2 research result, a new V2 decision or a V2 test/acceptance result. Every technical choice must be evaluated for V2 on its own merits and recorded in a V2 ADR. Similarity to a legacy concept does not establish approval.

Publicly available external software and datasets may be assessed separately under the V2 open-source/data-rights audit. Such assessment is not permission to reuse legacy project artifacts.

## Inspection record — metadata only

The following source paths and blob SHAs were observed on the source commit above. They are recorded solely to identify the excluded legacy material; their contents are not copied into V2.

| Legacy source path | Observed blob SHA | V2 treatment |
|---|---|---|
| `docs/00-foundation/PROJECT_CONSTITUTION.md` | `8cc55e9c4d4e963defe63557371b568d73236b13` | Excluded; no import or adaptation |
| `docs/00-foundation/MASTER_PROJECT_INDEX.md` | `849a5a671079861e3024c4efd41266ac7d091995` | Excluded; no import or adaptation |
| `docs/01-architecture/SYSTEM_ARCHITECTURE.md` | `54716847888d6e7bc8c863e3d1ab8c0013e48414` | Excluded; architecture to be independently designed |
| `docs/01-architecture/DOMAIN_MODEL_AND_BOUNDED_CONTEXTS.md` | `6f54f016cefaa42f2ac960f16163a73a439b8791` | Excluded; domain model to be independently designed |
| `docs/01-architecture/DATA_ARCHITECTURE_AND_LIFECYCLE.md` | `5e702cf5fa4613201e4b9507dacc2f43019d7fcd` | Excluded; data architecture to be independently designed |
| `docs/02-modules/INSTITUTES_DIRECTORY_DATA_SOURCE_EVIDENCE_AND_VERIFICATION_GOVERNANCE.md` | `0188d2f3cab02927c696c615b8a10d3fd06ab9cb` | Excluded; V2 data controls independently specified |
| `docs/02-modules/INSTITUTES_DIRECTORY_GEOGRAPHY_AND_LOCATION_SPECIFICATION.md` | `10df6e5fbae7a8c495b8be1c302c7e84c70c646d` | Excluded; V2 geography requirements independently researched |
| `docs/INSTITUTES_DIRECTORY_REQUIREMENTS.md` | `bbd3e0a28bd692caf1a33303511a7b4b461cc283` | Excluded; V2 product requirements come from V2 owner direction and new research |
| `docs/AUTONOMOUS_STEP_EXECUTION_PROTOCOL.md` | `37b98b64dd44023dc0168eca7de9038ae81af504` | Excluded; V2 AI protocol is independently authored |
| `docs/IMPLEMENTATION_STATUS_AND_GAP_REGISTER.md` | `a17a7fd055f9f02e7842ec534f844bd944fd81d4` | Excluded; no legacy status or completion claims transferred |

This is a targeted metadata inventory, not a claim that every file in the legacy repository has been exhaustively enumerated.

## Verification requirements

Before any future V2 task:
1. Confirm its inputs come from V2 requirements, new research or approved V2 decisions.
2. Confirm no legacy code, schema, config, data, workflow or implementation pattern is being reused.
3. Record any independent external dependency and its license/security/data rights.
4. Add a traceability entry and tests appropriate to the V2 task.
5. If legacy material is discovered in a proposed change, stop, remove it and record the incident before proceeding.

## Non-interference guarantee

V2 work must not create, update, delete, configure, deploy to or otherwise modify anything in `mattari20/estudent-listing`, its databases, hosting, credentials or the live website. Legacy repository access is read-only for this audit. This policy applies to every future step and milestone.
