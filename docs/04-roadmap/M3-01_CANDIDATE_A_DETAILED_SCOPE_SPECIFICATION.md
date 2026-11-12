# Candidate A — Detailed Planning Specification

**Planning status:** In progress; owner-approved for detailed planning only  
**Implementation authorization:** NOT ISSUED  
**Decision reference:** M3-01 Candidate A owner decision, 2026-11-12  
**Planning baseline:** `main` at `9dee2923a65d8ad29bbf155059ce252d3e9d85ba`

## 1. Planning objective

Define the smallest independently governed V2 foundation that could later be submitted for a separate implementation authorization. The proposed slice is deliberately limited to repository/application scaffolding, reproducible local/CI verification and synthetic-only configuration boundaries. This document is a planning specification, not a technical design selection or build instruction.

## 2. Proposed work packages (planning decomposition)

| ID | Proposed package | Planning deliverable | Explicit non-deliverable now |
|---|---|---|---|
| A1 | Repository and governance boundary | Repository layout proposal, ownership boundaries, branch/PR rules, documentation map | No application source code or branch protection changes |
| A2 | Runtime/build boundary | Architecture-neutral requirements for deterministic local build and CI | No language/framework choice, package install or technical spike |
| A3 | Configuration and secrets boundary | Configuration inventory, classification, safe defaults and redaction requirements | No secrets, credentials, external service configuration or environment activation |
| A4 | Synthetic fixture boundary | Fixture policy, naming convention, fabrication rules and contamination checks | No real or copied institution/person/source records |
| A5 | Automated verification | Required documentation/static/unit/smoke check categories and evidence format | No executable test suite or CI workflow implementation |
| A6 | Security and privacy baseline | Threat/risk checklist, least-privilege requirements, dependency and artifact controls | No certification or qualified review claim |
| A7 | Operational reversibility | Proposed stop conditions, rollback model, recovery assumptions and incident ownership requirements | No deployment, backup operation or production operations |
| A8 | Authorization dossier | Exact scope, exclusions, named human roles, evidence, cost ceiling, environment and expiry checklist | No authorization granted by completing this dossier |

## 3. Proposed acceptance criteria for a future authorized Candidate A implementation

These criteria are planning targets and must be reviewed against the final approved stack and scope before implementation:

1. The V2 repository and build are demonstrably independent of legacy V1 assets and operational dependencies.
2. A clean checkout can reproduce the documented build using only approved, pinned dependencies.
3. Automated checks run without production credentials, real education data, external source retrieval or paid services.
4. Every fixture is fabricated, clearly marked synthetic and checked against prohibited real-data patterns.
5. Configuration defaults fail closed; secrets are never committed, printed or included in artifacts.
6. The build and tests are deterministic enough for reproducible CI evidence; exceptions are documented.
7. PR checks are required before merge, and changes are attributable to a reviewed commit.
8. No public route, public directory, user account, ingestion path, model integration or production database is introduced.
9. Deeni Madaris Show remains default-OFF; any future public surface must have zero-exposure negative tests before release.
10. Documentation maps each implemented requirement to a test, owner decision or explicit deferral.
11. A qualified human reviewer has reviewed the relevant security/privacy boundaries before any environment is activated.
12. A rollback/stop procedure exists for every authorized stateful operation; no unreviewed stateful operation is permitted.

## 4. Proposed repository and CI requirements (technology-neutral)

The final design should specify, without selecting a tool prematurely:

- separation of application source, configuration examples, synthetic fixtures, tests, documentation and CI definitions;
- dependency pinning, provenance and vulnerability review expectations;
- minimal permissions for CI jobs and no unnecessary write-capable tokens;
- no production or legacy credentials in developer or CI environments;
- restricted network egress by default; each exception requires explicit scope and owner approval;
- safe handling of logs, caches, artifacts and test reports;
- branch protection and review requirements consistent with repository capabilities;
- reproducible evidence tied to commit SHA and check identity;
- explicit distinction between CI success, security review, legal approval and release authorization.

No CI workflow or repository setting is changed by this specification.

## 5. Synthetic data contract

All data used in a future Candidate A implementation must be fabricated solely for tests:

- synthetic institution/provider/campus/programme names and identifiers;
- reserved or clearly fictitious contact and locality values;
- no real coordinates, addresses, phone numbers, emails or URLs;
- no student, parent, staff or other personal records;
- no copied, transformed, sampled or anonymized production/V1/public-source data;
- no sect/maslak inference or sensitive religious classification;
- synthetic fixtures carry explicit metadata identifying them as test-only.

If a fixture's synthetic status is uncertain, it must be excluded.

## 6. Security, privacy and safeguarding design questions

Before implementation authorization, the planning dossier must answer:

- What exact data can enter the repository, developer environment, CI logs and artifacts?
- How are credentials prevented from entering source, logs, caches and artifacts?
- What network access, if any, is technically necessary?
- Who reviews dependencies and security findings, and who can approve exceptions?
- How are accidental real-data contamination and secret exposure detected?
- How are minor-safeguarding requirements preserved even though no child data or accounts are in scope?
- How is the Deeni Madaris default-OFF rule represented as a non-bypassable future acceptance requirement?
- What is the incident escalation and evidence-preservation procedure?

Qualified reviewers and accountable humans are not yet named; these questions are open.

## 7. Proposed deliverables required before P07

P07 must not be drafted as an authorization request until all of the following exist:

- accepted Candidate A scope and explicit exclusions;
- named human implementer, maintainer, QA owner, independent security reviewer and operations owner;
- skills and availability evidence for those roles;
- approved technology and hosting decision, or a clearly bounded local-only plan that requires no account/service;
- documented cost model and explicit no-spend confirmation for the authorized work;
- applicable legal/privacy/safeguarding review and recorded determination;
- exact environment and credential/network boundary;
- test matrix, CI/merge controls, evidence retention and rollback/stop plan;
- defined start/end dates or authorization expiry;
- owner-approved scope-specific implementation authorization.

Any unresolved item must remain a blocker or be expressly excluded with a reason and compensating control accepted by the owner. ChatGPT assistance does not substitute for named human engineering or independent review.

## 8. Current decision and stop line

Candidate A is approved for detailed planning only. This specification may be refined as a document and reviewed by the Product Owner.

**No implementation is authorized.** Do not create application code, install dependencies, run a technical spike, activate CI/environment resources, access production or source systems, change databases, contact providers, procure services, incur costs, deploy, pilot or launch. Any such activity requires a separate explicit owner authorization after the applicable preconditions are evidenced.
