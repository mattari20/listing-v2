# M2-S10 — Final Architecture Synthesis and M3 Roadmap

**Status:** Accepted and closed as part of M2 — 100% owner-accepted on 2026-11-12.  
**Scope:** Accepted architecture documentation. M3 implementation remains subject to separate M3-01 implementation-start authorization.  
**M2 weight:** 7%.

## 1. Executive architecture statement
eStudent Institutes V2 is a student-first, anonymous-first education discovery and decision-support platform supported by a governed, evidence-based catalogue. The architecture is logically modular, with distinct responsibilities for public discovery, domain facts, evidence/provenance, human adjudication, publication, identity/reviews, and operations. The implementation topology and stack remain unselected.

The public experience must remain useful on low-bandwidth connections and without precise location, maps, AI or optional third-party services. Published facts are time-aware, source-attributed and explicit about missingness, uncertainty and freshness. AI can propose; qualified humans decide high-impact facts and publication. Public projections are derived from approved publication state, not from raw evidence or model output.

## 2. Architecture baseline by step
| Step | Accepted design output | Qualification |
|---|---|---|
| S00 | Architecture documentation, ADR and traceability method | Documentation method only |
| S01 | AR-001–AR-025, actors, boundaries, quality scenarios | WCAG/SLO targets not approved |
| S02 | Conceptual domain, identity, temporal and uncertainty model | No physical schema/API |
| S03 | Logical application/integration/runtime boundaries | No deployment topology |
| S04 | Technology evaluation and conditional recommendation | No stack/vendor/hosting selected |
| S05 | Data domains, rights, provenance, publication and rollback | No source access/ingestion |
| S06 | Search/discovery/geography and default-OFF suppression | V2-DEC-006 binding |
| S07 | Governed AI evidence-agent workflow | No agent/model/connector activated |
| S08 | Identity, authorization, reviews, privacy and security | No identity vendor/legal compliance claim |
| S09 | Performance, operations, hosting and recovery | Targets provisional, not approved SLOs |

## 3. Cross-cutting invariants
1. **Independent V2:** no legacy implementation, schema, data, architecture, process or operational pattern is imported or used as design input.
2. **Source authorization:** source access and reuse are source-specific; public availability is not permission. All source families remain research-only until explicit rights/security/privacy assessment and approval.
3. **Evidence lineage:** every public fact is traceable to evidence, source authorization, assertion history, validation, human decision and publication event.
4. **Human accountability:** AI output is a proposal; high-impact facts and publication require qualified human approval.
5. **Temporal honesty:** current status is not inferred from stale or historical evidence; unknown remains unknown; conflicts are preserved and explained.
6. **Privacy and minors:** anonymous discovery, minimal collection, no unnecessary precise location, age-appropriate safeguards and pre-launch legal/security review.
7. **Deeni Madaris suppression:** Show Deeni Madaris default OFF; zero exposure across public search, browse, maps, suggestions, recommendations, counts, facets, sitemap, exports, caches and APIs; no sect/maslak filters.
8. **Reviews:** authenticated and post-launch only; login is not proof of attendance; moderation, appeal and anti-manipulation controls required.
9. **Resilience:** optional AI/maps/geocoding/search dependencies must fail safely; manual locality and core published content remain available.
10. **No premature commitment:** no procurement, spend, production access, migration, deployment or cutover without separate explicit approval.

## 4. Outstanding decisions and evidence gates
| Decision area | Required evidence | Gate |
|---|---|---|
| Backend/frontend/database/search | Team skills, proof-of-fit, performance/accessibility tests | Owner stack decision |
| Hosting/region | Cost worksheet, Pakistan latency, legal/data-transfer review, restore evidence | Owner procurement/hosting decision |
| AI/model/provider | Privacy/data terms, quality evaluation, security/adversarial tests, cost caps | Owner activation decision |
| Source access/reuse | Source-specific rights, terms, security, privacy and method review | Explicit source approval |
| Identity and age assurance | Risk assessment, legal review, usability and safeguarding design | Owner/legal approval |
| Reviews and moderation | Abuse model, eligibility, staffing, thresholds, appeal policy | Owner policy approval |
| Retention and freshness | Purpose/source rights, operational cost, legal requirements | Data governance approval |
| SLO/RPO/RTO | Workload assumptions, load and restore tests | Owner operations approval |
| Accessibility | WCAG audit and user/task evidence | Explicit target approval |
| Ranking and sponsorship | Transparent criteria, bias/quality evaluation | Owner product decision |

## 5. M3 implementation roadmap (conditional; not authorized)
M3 is a proposed sequence, not a start instruction.

1. **M3-00 — Mobilization and decisions:** confirm team capability, roles, budget, approved stack, hosting and legal/security review scope.
2. **M3-01 — Proof of fit:** build isolated technical spikes with synthetic data only; validate public HTML-first path, database/geography, search, authorization, observability and restore.
3. **M3-02 — Domain and publication foundation:** implement approved conceptual model, provenance, source registry, audit and human adjudication before public data ingestion.
4. **M3-03 — Public discovery vertical slice:** anonymous search, profile, comparison, manual locality, accessible low-bandwidth UI and clear unknown/stale states.
5. **M3-04 — Source authorization and controlled capture:** only source-by-source after rights/security/privacy approval; begin with narrow read-only scopes and synthetic fixtures until approved.
6. **M3-05 — AI-assisted evidence workflow:** extraction and validation in quarantine; human review; no autonomous high-impact publication; adversarial and quality evaluation.
7. **M3-06 — Identity and post-launch review foundation:** implement privacy-minimized accounts, authorization, moderation, appeal and safeguarding; no public reviews before policy and staffing approval.
8. **M3-07 — Search/maps and Deeni Madaris controls:** implement negative tests first, then indexes/maps; map/geocoder remain optional and replaceable.
9. **M3-08 — Operations and security readiness:** load, accessibility, security, backup/restore, incident, privacy and moderation readiness.
10. **M3-09 — Controlled launch decision:** separate launch approval, production backup/recovery evidence, monitoring and rollback plan. No URL cutover without separate explicit authorization.

Each phase requires its own acceptance evidence, owner decision and change control. Source-specific approvals remain independent and cannot be inferred from M2 acceptance.

## 6. Traceability and risk disposition
M1 G01-G20 remain binding and must be mapped to one or more of: architecture design, M3 implementation gate, owner decision, legal review, source-specific authorization, verification evidence or documented deferral. No gap is closed by omission. V2-DEC-006 is a non-negotiable cross-platform invariant.

The traceability matrix is maintained separately and must include AR-001–AR-025, source M1 requirements, architecture components, risk/control, M3 verification and disposition. Any unresolved or weakly supported mapping remains open.

## 7. Validation summary
Architecture validation must include:
- domain-to-component consistency and no duplicate source of truth;
- provenance and rights gates before capture and publication;
- AI quarantine, tool least privilege and human approval;
- authorization matrix and separation of duties;
- privacy/minor safeguarding and review abuse controls;
- Deeni Madaris negative exposure tests for every public surface and side channel;
- graceful degradation for location, map, geocoder, search, model and hosting failures;
- measurable quality, backup, restore and incident response scenarios;
- no hidden stack/vendor/hosting choice in diagrams or prose.

## 8. M2 completion status
The owner explicitly accepted S07-S10 and the integrated M2 architecture on 2026-11-12. S10 is 100% accepted/closed; M2 is 100% accepted/closed. The formal authority is `M2_FINAL_OWNER_ACCEPTANCE_RECORD_2026-11-12.md`. The M3 sequence in this document is superseded where it differs from `../04-roadmap/M3_MASTER_STEP_PLAN.md`. No M3 implementation is authorized by M2 acceptance.

## 9. Owner acceptance checklist
- [ ] Accept S07 AI-agent architecture as a governed proposal-only workflow with source-specific authorization and human publication gates.
- [ ] Accept S08 identity, review, privacy, minor-safeguarding and security baselines with legal/policy decisions carried forward.
- [ ] Accept S09 operational design as a planning baseline; provisional targets remain unapproved until evidence.
- [ ] Accept S10 integrated architecture synthesis, cross-cutting invariants and conditional M3 roadmap.
- [ ] Confirm unresolved stack, hosting, model, source, legal, privacy, review and SLO choices remain open and require separate decisions.
- [ ] Confirm no M3 implementation, source access, procurement, production access, deployment or launch is authorized by this acceptance request.

**Final owner decision:** ACCEPTED on 2026-11-12. M2 closed at 100%. The new M3 Master Step Plan is the authoritative M3 execution sequence; separate implementation, source, procurement, production and launch gates remain in force.
