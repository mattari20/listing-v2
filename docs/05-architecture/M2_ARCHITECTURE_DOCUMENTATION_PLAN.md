# M2 Architecture Documentation Plan

## Structure
| Location | Purpose |
|---|---|
| `docs/05-architecture/` | Architecture narrative, index and controls |
| `diagrams/` | Mermaid/text-based context, domain, runtime, data-flow and deployment-neutral views |
| `decisions/` | Append-only ADR history |
| `evaluations/` | Technology options, criteria, costs and evidence |
| `security/` | Threat model, trust boundaries, privacy and safeguarding |
| `data/` | Conceptual data, provenance and lifecycle models |
| `operations/` | Quality scenarios, deployment, observability and recovery |

## Views and audiences
1. System context — stakeholders, users, external parties and system boundary.
2. Container — technical team; deployable/runnable responsibilities and communication paths.
3. Component — only complex or high-risk areas.
4. Domain — concepts, identity, relationships and temporal semantics.
5. Runtime — discovery, admin configuration, evidence review and publication scenarios.
6. Data-flow/trust — data origin, transformation, access and exposure.
7. Deployment/operations — proposed environments, resilience and recovery, without production configuration.

## Quality rules
- Give each diagram a title, scope, abstraction level and explanatory note.
- Identify responsibilities, interfaces, dependencies, failure cases and data ownership.
- Label external systems as proposed, research-only, approved or excluded.
- Show source-rights authorization, provenance, validation and human approval on ingestion/publication paths.
- Do not include secrets, production hostnames, credentials or personal data.
- Avoid physical database tables, migrations, code classes, executable infrastructure or deployable API payloads in M2.
- Mark designs and decisions as proposed, accepted, approved for implementation, deferred, rejected or superseded.
