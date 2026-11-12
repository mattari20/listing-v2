# M2 Architecture Decision Register

| ADR | Topic | Status | Step |
|---|---|---|---|
| ADR-0001 | Architecture documentation and decision-record method | Adopted for M2 documentation process only | S00 |
| ADR-0002 | Application architecture style and module boundaries | Proposed modular-monolith direction; owner decision pending | S04 |
| ADR-0003 | Backend technology | Options evaluated; owner decision pending | S04 |
| ADR-0004 | Frontend technology | HTML-first recommendation; owner decision pending | S04 |
| ADR-0005 | Primary data store | PostgreSQL/PostGIS preferred proof-of-fit candidate; not selected | S04 |
| ADR-0006 | Search and geospatial approach | Options evaluated; benchmark/provider decision pending | S04/S06 |
| ADR-0007 | Hosting and environment approach | Deferred pending hosting/cost/operability evidence | S04/S09 |
| ADR-0008 | AI orchestration and model boundary | Not started | S07 |
| ADR-0009 | Identity and authorization approach | Not started | S08 |
| ADR-0010 | Data publication and high-impact review gates | S05 governance baseline drafted; S07 refinement pending | S05/S07 |

An ADR status is not implementation authorization. ADR-0001 concerns documentation method only; it does not select application technology or topology.


**Decision status note (2026-11-12):** S04-S06 option comparisons and logical governance designs are proposals for owner review. No backend/frontend/database/search/map/hosting provider is selected, no spend is approved, and no implementation is authorized. ADR status records evaluation progress, not procurement or deployment approval.

## M2-S04/S05/S06 owner acceptance — 2026-11-12

S04-S06 evaluation and logical governance/discovery baselines are accepted and closed at 100%. Acceptance does not select a stack, vendor, host, model, map/geocoder provider, source or spend. ADR-0002 through ADR-0007 remain proposals/deferred decisions; no implementation authorization is implied.

## M2-S07/S08/S09/S10 decision disposition — 2026-11-12

| ADR | Topic | Current disposition |
|---|---|---|
| ADR-0008 | AI orchestration/model boundary | S07 proposal-only architecture drafted; model/provider/orchestration unselected; no connector/agent activation |
| ADR-0009 | Identity and authorization | S08 identity classes and least-privilege policy drafted; identity provider/protocol deferred |
| ADR-0010 | Data publication and high-impact review gates | Human adjudication and publication controls accepted as design constraints; implementation remains gated |
| ADR-0011 | Privacy, minors and review moderation | S08 design baseline drafted; legal applicability, age assurance, moderation policy/staffing require owner/legal decision |
| ADR-0012 | Operational objectives and recovery | S09 provisional targets only; hosting, RPO/RTO and SLOs require workload/cost/restore evidence and owner approval |

No ADR authorizes procurement, source access, production access, implementation, deployment or launch.
