# Project Master Roadmap

All milestones are planned outcomes. Step-level scope and acceptance criteria are detailed in `MILESTONE_STEP_REGISTER.md`. Milestones may be refined through documented decisions; dependencies must not be bypassed.

| Milestone | Outcome | Status |
|---|---|---|
| M0 | Independent repository, documentation, governance and delivery controls | Accepted — PR #4 closeout |
| M1 | Student requirements, provider discovery, data rights and open-source research | **Accepted and Closed — M1-S01 through M1-S10 accepted; 100%; primary research deferred** |
| M2 | Architecture, domain model, technology evaluation, security and data design | **In Progress — owner-authorized 2026-11-12; documentation/design only** |
| M3 | Application foundation, environments, CI, identity and authorization | In progress — M3-07 I1-I5 bounded synthetic/local/CI packages delivered; live AI Data-Agent/source activation remains blocked |
| M4 | Institution, campus and programme management | Planned |
| M5 | Nearby discovery, search, filters and maps | Planned |
| M6 | Institution profiles and verified information presentation | Planned |
| M7 | Admissions, eligibility, fees and scholarships | Planned |
| M8 | Student shortlist and institution/programme comparison | Planned |
| M9 | Ratings, reviews, moderation and trust | Planned |
| M10 | AI data collection, reconciliation, verification and refresh | Planned |
| M11 | SEO, accessibility, performance and public experience hardening | Planned |
| M12 | Full acceptance, security/recovery readiness and controlled release planning | Planned |

## Owner-approved research timing\n- No student survey, interviews, participant recruitment or research outreach during construction.\n- Authenticated ratings and reviews are a post-launch product feature, not a pre-launch research survey.\n\n## Planning rules
- M1 research must inform M2 architecture.
- Do not select a technology stack or begin production application modules before M2 approval.
- Data connectors are not activated until rights and source review pass.
- Production release/cutover is a separate authorization gate, not an automatic consequence of M12 completion.
- Each milestone requires its own acceptance record and closeout.


## M1 closeout decision — 2026-11-12
M1 is formally accepted and closed as a research/documentation milestone. M2 remains Planned and requires separate explicit owner authorization; this closeout does not authorize implementation.


## M1 final closeout delivery evidence — 2026-11-12

PR [#83](https://github.com/mattari20/listing-v2/pull/83) recorded owner acceptance of S10 and M1 closure. Exact PR head `30d5c7ecfc929cd680c3da8d076774904ec2d67a` passed Project documentation validation (run [#43175799695](https://github.com/mattari20/listing-v2/actions/runs/43175799695)); merged as `af88a88693e66e9fb0a459d14ba1028e5fd3f97d`. M1 is Accepted and Closed. M2 remains Planned and requires separate explicit owner authorization.


## M2 authorization and active delivery — 2026-11-12

The owner authorized M2 architecture/design. The milestone is active and governed by `../05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md` and `../05-architecture/M2_STEP_PLAN.md`. M2-S00 is first; M2-S01 through S10 follow the documented dependencies and weights.

This authorization covers architecture research and documentation only. M3 implementation remains gated until M2 is complete and separately accepted. Production access, schema changes, source ingestion, connector activation, new spend and deployment require separate approval.


## M2 authorization and active delivery — 2026-11-12

The owner authorized M2 architecture/design. The milestone is active and governed by `../05-architecture/M2_ARCHITECTURE_DESIGN_CHARTER.md` and `../05-architecture/M2_STEP_PLAN.md`. M2-S00 is first; M2-S01 through S10 follow the documented dependencies and weights.

This authorization covers architecture research and documentation only. M3 implementation remains gated until M2 is complete and separately accepted. Production access, schema changes, source ingestion, connector activation, new spend and deployment require separate approval.


## M2-S00 completion evidence — 2026-11-12

M2-S00 is complete at 100% task completion. PR [#85](https://github.com/mattari20/listing-v2/pull/85) merged as `17a2e3ad43ba1fd5ca3cb7a163670a2f19dd3783`; exact PR head passed required Project documentation validation (run [#43180488082](https://github.com/mattari20/listing-v2/actions/runs/43180488082)). M2-S01 — System Requirements and Architecture Boundaries — is the next eligible step.


## M3 roadmap — authoritative detailed sequence (2026-11-12)

The [M3 Master Step Plan](M3_MASTER_STEP_PLAN.md) is the authoritative detailed sequence and supersedes the earlier high-level M3-M12 outline in this file where the two differ. The superseded outline is historical context, not a parallel active roadmap. M0, M1 and M2 are accepted and closed; M3-00 is the current documentation/planning step.

| Step | Name | Weight | Status |
|---|---|---:|---|
| M3-00 | Mobilization and Decision Closure | 5% | Accepted and closed; approved deferrals retained |
| M3-01 | Implementation Planning and Authorization | 7% | Closed as planning/authorization milestone; later steps separately gated |
| M3-02 | Platform Foundation | 10% | Accepted as Laravel platform foundation only |
| M3-03 | Core Data and Governance | 12% | Complete for bounded synthetic local/CI scope |
| M3-04 | Provider Management | 8% | P01–P04 complete for bounded synthetic local/CI scope |
| M3-05 | Public Directory and Search | 10% | Complete for bounded synthetic local/CI scope — PR #189 |
| M3-06 | Geography and Discovery | 7% | Not started; separate scope review and authorization required |
| M3-07 | AI Data-Agent | 10% | I1-I5 bounded synthetic/local/CI packages delivered; I6 deterministic synthetic proposal adapter implemented and exact-head validated in PR #220 (awaiting merge); live source/model activation blocked by G2-G9 |
| M3-08 | Identity, Reviews and Security | 10% | Not started; reviews post-launch only |
| M3-09 | Quality and Operational Hardening | 8% | Not started |
| M3-10 | Pilot and Launch Readiness | 7% | Not started; separate pilot approval |
| M3-11 | Controlled Production Launch | 6% | Conditional; separate production/launch approval |

Weights total 100%. They are planning allocations, not authorization to spend, access sources, use production, deploy or launch.

## M3-07 I5 closeout — 2026-11-16

I5-A through I5-C and the historical-definition regression are delivered and merged in PRs #213–#216. The final exact-head PHP 8.5 FND-01 suite passed 15 tests and 647 assertions; documentation validation passed on all four PR heads. See [M3-07 I5 Implementation Record](M3-07_I5_IMPLEMENTATION_RECORD.md).

I5 completion closes only the bounded synthetic/local/CI value correction, withdrawal/reinstatement and registry-aware public profile agenda. It does not complete or activate the live AI Data-Agent. Candidate sources remain RESEARCH ONLY; G2-G9 rights, privacy, security, model/provider and activation gates remain blocked. No source access, agent, model, connector, scheduler, production operation, deployment or spend is authorized.

**I6 scope/design preflight complete — 2026-11-16:** See [M3-07 I6 Synthetic Agent Proposal Adapter Preflight](M3-07_I6_SYNTHETIC_AGENT_PROPOSAL_ADAPTER_PREFLIGHT.md). The preflight was merged in PR #218. The Product Owner subsequently authorized the exact deterministic offline synthetic adapter scope.

**I6 implementation delivered — 2026-11-16:** [PR #220](https://github.com/mattari20/listing-v2/pull/220) implements one synthetic fixture, fixed server-owned agent identity with only `submit_agent_field_proposal`, a dedicated I3 field-aware path and a dedicated editorial submission path. It reuses exact-version validation and existing evidence/source-authorization/audit/outbox controls; the result remains a proposed claim with a submitted human-review case. Existing human-only review, adjudication, publication, correction, withdrawal, restoration and definition-governance controls remain unchanged. Five focused synthetic feature-test methods cover the bounded path. Exact-head FND-01 PHP 8.5 CI #43838413609 and Project documentation validation #43838413686 passed; test output was 15 passed, 687 assertions and 164 warnings including the existing missing-local-`.env` harness warnings. See [I6 Implementation Record](M3-07_I6_IMPLEMENTATION_RECORD.md).

No migration, schema change, backfill, dependency, Composer change, route/UI, real/source data, model/provider, external API, connector, scheduler, production operation, deployment or spend occurred. **I6 implementation is delivered and exact-head validated; PR #220 awaits merge.** I7 remains separately gated. G2-G9 continue to block live source access and live agent activation.
