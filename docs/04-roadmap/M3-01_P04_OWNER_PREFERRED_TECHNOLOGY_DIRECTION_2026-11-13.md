# M3-01 P04 — Product Owner Preferred Technology Direction

**Date:** 2026-11-13  
**Decision authority:** Product Owner  
**Status:** Owner-approved preferred planning direction; final stack and hosting selection remain conditional  
**Implementation authorization:** NOT ISSUED  
**Spend authorization:** NONE — no new spend

## 1. Owner-confirmed development model

The Product Owner confirmed: “I mainly rely on ChatGPT for writing, understanding and debugging code.”

This is the owner's stated current development model. It must not be represented as hands-on proficiency in Python, Django, PHP, Laravel, TypeScript or NestJS. The project should therefore optimize for understandable, documented, testable and maintainable work that can be delivered in small increments with ChatGPT assistance and strong automated verification.

The Product Owner remains the sole human Product Owner and builder for the initial bounded V2 build. ChatGPT is an assistant, not an independent accountable engineer, security certifier, legal adviser or production operator.

## 2. Owner-approved preferred direction

The Product Owner agreed with the professional recommendation to use the following as the preferred planning direction:

| Area | Preferred direction | Qualification |
|---|---|---|
| Backend | Python / Django | Preferred candidate, not yet a final versioned framework selection |
| Primary database | PostgreSQL | Preferred candidate; major version subject to implementation-time support and host verification |
| Geography | PostGIS | Preferred extension, subject to target-host availability and restore/backup evidence |
| Application architecture | Modular monolith | Preferred; avoid premature microservices/Kubernetes |
| Public frontend | HTML-first, server-rendered templates with progressive enhancement | Preferred; no complex SPA requirement established |
| AI architecture | Provider-neutral capability boundary; AI-off core operation | Required planning direction; AI remains disabled and unactivated |
| Initial search | Database-native structured/lexical search | Preferred baseline; specialized/vector search benchmark-gated |
| Hosting/provider/region | Not selected | Requires compatibility, data terms, operational and cost evidence |

The backend recommendation is based on integrated application capabilities, Python's future data/AI ecosystem, and the proposed ChatGPT-assisted delivery model. It is not based on a claim that the Product Owner already knows Python or Django. Before any implementation authorization, the plan must explicitly account for the learning, review and maintenance burden of the selected stack.

## 3. Alternatives and decision rationale

Laravel/PHP and NestJS/TypeScript remain credible alternatives. They are not rejected as technically unsuitable. Django is the preferred candidate because the project values an integrated framework, coherent administration/workflow capabilities, a single manageable application and a useful future data/AI ecosystem.

The owner’s reliance on ChatGPT is not evidence that any framework will be automatically maintainable. The project must use small changes, explanatory documentation, automated tests, protected pull requests, dependency/lifecycle checks, explicit stop conditions and human approval for consequential actions.

## 4. Version and hosting gates

No Django release line, Python runtime, PostgreSQL major version, PostGIS version, operating system, hosting provider, region, vendor, managed-service plan or deployment topology is finally selected by this record.

Before implementation authorization:
- Re-check official framework/runtime/database support and security lifecycle.
- Evaluate Django's currently supported LTS option at the time of selection; do not freeze a release based on this planning snapshot.
- Confirm PostgreSQL and PostGIS availability, extension versions, backup/PITR, independent export and tested restore on any shortlisted host.
- Assess data location, cross-border terms, subprocessors, security controls, Pakistan user latency, portability, support and complete recurring costs.
- Prepare baseline and growth cost scenarios using dated vendor evidence; do not invent prices or assume a budget.
- Keep all paid services and new spend prohibited absent separate explicit approval and a numeric ceiling.

## 5. Boundaries retained

This decision is planning-only. It does not authorize:
- Application code, technical spikes, package installation or environment activation.
- Real/V1 data, production or external-source access, scraping, ingestion or personal-data processing.
- Database schemas, migrations, DDL/DML or data backfills.
- External APIs, AI models, agents, vector services, MCP servers or other integrations.
- Hosting/cloud accounts, paid trials, procurement, subscriptions, DNS changes, deployment, pilot or launch.

Candidate A remains isolated, offline, synthetic-only and no-spend. Deeni Madaris Show remains default-OFF with its existing non-exposure constraints. All other M0/M1/M2 and M3-00 controls remain binding.

## 6. P04 disposition

The owner has approved a preferred technology direction for planning. P04 is **advanced but not closed** because hosting/provider/region, database-extension support, backup/restore, data terms, full cost evidence and final version choices remain unresolved.

No M3-01 weighted completion percentage is claimed from this decision alone. P05/P06/P07/P08 retain their separate gates. Overall M3 remains 5% until the authoritative weighted register is updated on accepted evidence. Implementation authorization remains **NOT ISSUED**.
