# M3-01 Candidate A — Owner Decision Record

**Decision date:** 2026-11-12  
**Decision:** APPROVED FOR DETAILED PLANNING ONLY  
**Implementation authorization:** NOT ISSUED  
**Baseline:** `main` at `9dee2923a65d8ad29bbf155059ce252d3e9d85ba`

## 1. Explicit owner decision

The Product Owner explicitly approved Candidate A for M3-01 detailed planning only:

> “Approve Candidate A for M3-01 detailed planning only. Do not authorize implementation.”

This decision resolves the P02 planning-scope choice sufficiently to develop the detailed scope, boundaries, acceptance criteria, dependencies, risks and authorization prerequisites for Candidate A. It does not approve implementation or close M3-01.

## 2. Candidate A planning boundary

Candidate A is the proposed isolated V2 foundation, using fabricated synthetic fixtures only. Detailed planning may specify:

- the independent V2 repository/application foundation at a requirements and design level;
- a proposed non-production, isolated, synthetic-only development boundary;
- reproducible build and CI requirements, without activating an environment or creating application code;
- configuration and secret-handling requirements;
- documentation, static-check and automated-test expectations that do not require external network access or paid services;
- synthetic-only smoke-test and evidence requirements;
- scope-specific acceptance criteria, stop conditions, rollback expectations and unresolved decisions.

This approval does not select a language, framework, database, hosting provider, cloud region, vendor, identity provider or external service.

## 3. Explicit exclusions remain binding

The following remain out of scope and unauthorized:

- application coding, technical spikes, package installation or environment activation;
- real institution/provider/student/person data, production data or legacy V1 data;
- legacy V1 code, schema, APIs, architecture, workflows, tests, CI, deployment or operational practices;
- production access, database access, schema changes, migrations or any DDL/DML;
- scraping, source access, bulk downloads, ingestion, connectors, crawlers, schedulers or outreach;
- external APIs, models, agents, geocoders, maps, search services, analytics or identity services;
- personal-data processing, user accounts, reviews, moderation operations, participant research or recruitment;
- hosting/cloud account creation, procurement, contracts, paid trials, subscriptions or any new spend;
- public pages, deployment, DNS/URL changes, pilot, launch or production operations.

All source families remain RESEARCH ONLY. Deeni Madaris Show remains default-OFF across every public surface and side channel. Existing privacy, minor-safeguarding, security, evidence/provenance, human-review and independent-V2 requirements remain binding.

## 4. Preconditions still required before any implementation authorization

Candidate A planning must not imply that the following gaps are resolved:

1. Named human implementer and maintainer with demonstrated relevant skills and availability.
2. Named QA owner and independent qualified security reviewer.
3. Named operations/accountability owner for environment, secrets, recovery and incident handling.
4. Evidence-based stack and hosting decision, including region/data-location, support, security lifecycle and recovery implications.
5. Explicit no-new-spend confirmation for the proposed scope; any future spend requires separate approval.
6. Qualified legal/privacy/safeguarding review where applicable, including confirmation that the synthetic-only scope does not introduce unreviewed personal-data or child-safeguarding exposure.
7. Exact environment, CI, test, release, rollback and stop-condition plan.
8. A scope-specific written implementation authorization with named accountable humans, permitted actions, exact environment, exclusions, budget ceiling and expiry.

No approval, assignment, legal clearance, security certification, source permission, vendor selection or spend ceiling is inferred by this decision.

## 5. M3-01 task status effect

- P02: Candidate A selected for detailed planning; detailed planning and owner acceptance of the final plan remain outstanding.
- P01: Previously delivered for owner review; no acceptance is inferred here.
- P06: Synthetic-only test/release framework remains delivered for review; no environment activated.
- P03–P05: Remain blocked pending named human accountability and required evidence.
- P07: Implementation authorization request is not ready and must not be issued.
- P08: Final M3-01 owner review/decision remains pending.

No M3-01 weighted completion percentage is claimed by this decision. M3 overall weighted progress remains 5% based on the accepted M3-00 closeout.

## 6. Authorization statement

**IMPLEMENTATION AUTHORIZATION: NOT ISSUED.**

This record is a planning decision only. No person or automated agent may interpret it as permission to code, run technical experiments, activate environments, access production or external sources, change databases, procure services, spend money, deploy, pilot or launch. Any future implementation requires a separate explicit written owner authorization after all applicable preconditions are evidenced and reviewed.
