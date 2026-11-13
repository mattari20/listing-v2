# M3-02 Step 3 — Architecture Conformance Review

**Prepared:** 2026-11-13  
**Repository:** mattari20/listing-v2  
**Review baseline:** main at a587f57a1c216b7173aa366368cef1723c3d7433  
**Review type:** Read-only architecture-to-implementation conformance assessment  
**Authority:** Owner-accepted M2 architecture; M3-01 AI-era architecture-readiness criteria; bounded FND-01 implementation record  
**Data boundary:** No real, source, personal, student, child, institute or staff data  
**Spend / integrations / deployment:** None

## 1. Executive conclusion

The current V2 repository is a narrow Laravel 13 foundation, not yet the implemented education-discovery platform described by the accepted M2 logical architecture. The delivered FND-01 slice is broadly consistent with the architecture's greenfield, synthetic-only, low-dependency starting constraints: it contains a minimal Laravel application, a fixed non-sensitive health endpoint, a default-OFF Deeni Madaris policy seam, focused tests and read-only CI workflows. No contradictory V1 dependency, external service integration, AI activation, source collection or database implementation was found in the reviewed tracked application surface.

**Overall conformance disposition: PARTIAL / FOUNDATION-ONLY.** The narrow foundation does not materially contradict the accepted architecture, but most domain, evidence, publication, discovery, identity, security and operations requirements are not implemented and cannot yet be verified. This is an expected scope limitation of FND-01, not evidence that those future capabilities conform.

Step 3 is complete as a documentation/review deliverable. It does **not** establish full M3-02 completion, final stack approval, production readiness, legal/security compliance, or acceptance of any future application feature.

## 2. Review method and evidence boundary

Compared the accepted M2 system context, requirements/boundaries, logical application/integration architecture, domain model, technology evaluation, data/provenance design, search/geography design, AI-agent architecture, identity/privacy/security architecture, operations/recovery design and requirements traceability against the current tracked V2 application, configuration, routes, tests and CI workflows.

Repository inspection was limited to tracked source and documentation at the stated main commit. No local Codespace, Hostinger, V1, production, database service, external source, vendor, model or live endpoint was accessed. No commands were run against a live system. The absence of a tracked file or implementation is recorded as 'not implemented/not evidenced in this repository snapshot', not as proof about external infrastructure.

Primary implementation evidence:
- app/Policies/DeeniMadarisVisibilityPolicy.php
- config/directory.php
- routes/web.php
- bootstrap/app.php
- composer.json and composer.lock
- tests/Unit/DeeniMadarisVisibilityPolicyTest.php
- tests/Feature/HealthEndpointTest.php
- tests/Feature/FoundationEnvironmentDefaultsTest.php
- .github/workflows/fnd-01-ci.yml
- .github/workflows/project-docs-validation.yml

Primary architecture baselines:
- docs/05-architecture/M2-S01_SYSTEM_CONTEXT.md and M2-S01_SYSTEM_REQUIREMENTS_AND_BOUNDARIES.md
- docs/05-architecture/M2-S02_CORE_DOMAIN_CONCEPTUAL_MODEL.md and M2-S03_APPLICATION_INTEGRATION_ARCHITECTURE.md
- docs/05-architecture/M2-S04_TECHNOLOGY_STACK_EVALUATION.md
- docs/05-architecture/M2-S05_DATA_ARCHITECTURE_PROVENANCE_PUBLICATION.md
- docs/05-architecture/M2-S06_SEARCH_DISCOVERY_GEOGRAPHY_ARCHITECTURE.md
- docs/05-architecture/M2-S07_AI_DATA_AGENT_TECHNICAL_ARCHITECTURE.md
- docs/05-architecture/M2-S08_IDENTITY_AUTHORIZATION_REVIEWS_PRIVACY_SECURITY.md
- docs/05-architecture/M2-S09_PERFORMANCE_OPERATIONS_HOSTING_RECOVERY.md
- docs/05-architecture/M2-S10_FINAL_ARCHITECTURE_SYNTHESIS_M3_ROADMAP.md
- docs/05-architecture/M3-01_AI_ERA_ARCHITECTURE_READINESS_REVIEW_2026-11-12.md

## 3. Conformance matrix

| Architecture requirement / boundary | Current repository evidence | Assessment | Gap / interpretation |
|---|---|---|---|
| Independent greenfield V2; no V1 reuse | Repository is listing-v2; reviewed tracked app is a small Laravel scaffold; no V1 code/data/API reference in the reviewed runtime files | Consistent in reviewed scope | Continue enforcing independent build; this review cannot attest to external hosting or deployment separation |
| Laravel/PHP foundation direction | composer.json requires Laravel Framework ^13.17 and PHP ^8.3; CI executes PHP 8.5 | Implemented for FND-01 | Does not by itself settle all M2 stack decisions or prove Hostinger web-runtime compatibility |
| Modular logical capability boundaries | Current app has only a small policy class and basic routes; no explicit domain/evidence/publication/discovery modules | Not implemented / not yet assessable | Preserve boundaries before adding domain features; do not prematurely split into services |
| Anonymous-first public discovery | Only fixed /health route exists; no public catalogue/search/profile journey | Not implemented | No evidence yet for anonymous browse, HTML-first UX, accessibility, SEO or low-bandwidth behavior |
| Domain identity and temporal education facts | No provider/institution/campus/programme domain model or temporal fact workflow found in reviewed app tree | Not implemented | M2-S02 semantics remain design-only; do not introduce schema or real records in this step |
| Evidence, source rights and provenance | No source registry, rights grant, evidence vault/reference, assertion history or provenance workflow found | Not implemented | Deny-by-default source rule remains binding; no source access/ingestion authorized |
| Human adjudication and publication | No review workbench, publication decision, correction/withdrawal or public projection pipeline found | Not implemented | AI or user-submitted facts must not be exposed; future implementation needs independent human publication controls |
| Deeni Madaris default-OFF policy | config/directory.php defaults DIRECTORY_DEENI_MADARIS_PUBLIC to false; policy class returns false when unset; two unit tests cover false/unset | Partially implemented seam | Policy is not wired into any public data/query surface because those surfaces do not yet exist; no zero-exposure proof across search/counts/maps/cache/API/export/sitemap/direct IDs is possible yet |
| Deeni Madaris policy change governance | Current seam reads an environment setting; no authorized admin workflow, audit, preview, cache/index invalidation or rollout gate exists | Not implemented | Keep value false; future enabling must not be treated as a routine environment toggle and requires the M2 policy controls plus explicit owner approval |
| Search, comparison and geography | No search/index/query, comparison, locality or map code found in reviewed app tree | Not implemented | Core discovery must remain useful without precise location, maps or external geocoding; no provider selection is implied |
| AI provider/model independence and AI-optional operation | No model SDK, AI provider, agent, MCP, vector store or external connector integration found in reviewed runtime files | Consistent with AI-disabled initial boundary | AI-era requirements are architectural criteria only; no AI activation or provider integration is authorized |
| AI quarantine, evidence grounding and human approval | No agent workflow exists | Not implemented / not applicable to current foundation | Must be designed and tested before any future AI capability; model output cannot publish or alter rights/policy |
| Identity, authorization and minor safeguards | No account/authentication, provider representative, steward, publisher, moderator or review workflow found | Not implemented | Anonymous discovery is not yet implemented either; no child accounts, reviews, messaging, uploads or personal-data collection in current scope |
| Health and smoke behavior | /health returns fixed status/application/foundation fields; exact JSON feature test; CI bootstraps Laravel and lists routes | Minimal foundation smoke evidence | Not an operational readiness probe; no dependency health, DB readiness or live service health claim |
| Environment and secret boundaries | FND-01/PR #139 tests and docs establish local/CI defaults and no tracked .env/database config; CI uses contents:read | Partially evidenced | No production environment, secret lifecycle, V2 deployment isolation or host-level permissions were inspected |
| Logging and diagnostics | Warning-level defaults, stack/single local log, deprecation channel null and trace false; tests verify defaults | Minimal local/CI baseline | No metrics, traces, alerting, retention, incident monitoring or production observability |
| External integrations and adapters | No external integration is configured in reviewed runtime source | Consistent with deny-by-default baseline | Maps, messaging, identity federation, source connectors and AI remain unselected/unapproved |
| CI and engineering quality | PHP foundation workflow validates Composer, audits dependencies, runs Pint, bootstrap/routes, synthetic tests and artifact hygiene; docs validation workflow checks project docs | Partially implemented | PHP CI currently runs on PRs but is not required by active main ruleset; docs workflow references mutable action tags rather than immutable SHAs |
| Performance, capacity and recovery | No load, cache/index, backup, restore, RPO/RTO or incident exercise implementation/evidence in reviewed app | Not implemented | M2-S09 targets are provisional; no numerical target is treated as approved or achieved |

## 4. Findings and risk ranking

### FND-ARCH-01 — Architecture remains a scaffold, not a modular application
**Severity:** High for milestone exit; no immediate runtime defect asserted.  
**Evidence:** The reviewed runtime contains a basic Laravel bootstrap, one fixed health route, one visibility policy class and environment configuration. The accepted architecture's domain, evidence, adjudication, publication and discovery responsibilities are not yet represented as application modules.  
**Required disposition:** Treat this as the next-stage implementation backlog, not a reason to introduce speculative modules in the foundation. Before M3-03 work, map each approved domain capability to an explicit module boundary and ownership contract.

### FND-ARCH-02 — Deeni Madaris policy is a default-off seam, not an enforced cross-surface invariant
**Severity:** High / release-blocking for any future public discovery surface.  
**Evidence:** The config default and policy unit tests fail closed when false/unset. No public discovery routes or projection/index surfaces exist, and the policy class is not currently invoked by a public query pipeline.  
**Required disposition:** Keep the flag false. Before any public directory surface is implemented, establish one authoritative server-side policy boundary and negative tests for direct IDs, browse, search, facets, counts, recommendations, maps, sitemap, exports, cache and APIs. A configuration change must require the M2 authorization, audit, preview, negative-test and controlled invalidation requirements.

### FND-ARCH-03 — Stack and hosting proof-of-fit remains incomplete
**Severity:** High for environment/operational readiness.  
**Evidence:** Laravel 13/PHP 8.5 is present in the repository/CI. The accepted M2 stack evaluation leaves final stack and hosting selection dependent on team/operability, cost and proof-of-fit evidence. The P04 Hostinger dossier is a conditional recommendation and explicitly says it does not prove V2 isolation, exact versions/limits, spare capacity, restore or Laravel runtime compatibility.  
**Required disposition:** Do not claim deployment compatibility. A separate authorization is required before any Hostinger/V2 environment inspection or technical proof. No V1 or production access is part of this review.

### FND-ARCH-04 — Required-check governance gap
**Severity:** Medium.  
**Evidence:** PHP foundation CI runs on PRs, but active main ruleset 27043221 requires only project-document validation. This was verified in the preceding Step 2 audit.  
**Required disposition:** Retain the recorded recommendation to consider requiring PHP foundation CI. No ruleset changes are made by this Step 3 review; obtain separate explicit owner authorization first.

### FND-ARCH-05 — Documentation workflow action pinning is weaker than foundation workflow pinning
**Severity:** Medium / supply-chain hardening observation.  
**Evidence:** .github/workflows/fnd-01-ci.yml pins checkout and setup-php actions to immutable commit SHAs. .github/workflows/project-docs-validation.yml uses actions/checkout@v4 and actions/setup-python@v5 tags.  
**Required disposition:** Decide separately whether to pin these actions to reviewed immutable SHAs, preserving approved versions. No workflow changes are made here.

### FND-ARCH-06 — Security, privacy, AI and operational controls remain design-only
**Severity:** High before relevant capabilities or launch.  
**Evidence:** No identity, authorization matrix enforcement, moderation, source access, AI quarantine, prompt/tool boundary, rate limiting, metrics, incident response or restore test is implemented in the reviewed app. P05 explicitly retains legal/security/source/safeguarding reviews and prohibits real data, source access and AI activation.  
**Required disposition:** Keep these capabilities gated. Complete specialist review and feature-specific verification before their activation; do not represent architecture documents as implementation or compliance evidence.

## 5. AI-era readiness disposition

The M3-01 AI-era review is consistent with the current foundation insofar as no model/provider/agent or vector dependency is present. The repository does not yet implement the proposed provider/model adapter, RAG evidence contract, evaluation harness, prompt/configuration lifecycle, policy-enforced tool execution boundary, egress controls, AI cost accounting or AI-specific observability.

These are **not defects in the bounded FND-01 foundation**. They are future acceptance requirements if and when AI-assisted evidence processing is separately authorized. Core discovery and governed publication must remain usable with AI disabled. No model, connector, MCP server, external API or agent should be added as a shortcut to satisfy architecture-readiness documentation.

## 6. Decision and implementation status

| Area | Disposition |
|---|---|
| FND-01 Laravel foundation | Delivered and merged; narrow scope conforms to its authorization |
| Accepted M2 logical architecture | Remains the binding target; not fully implemented |
| Final stack / hosting / database decisions | Not fully closed by this review; preserve existing owner decision records |
| Deeni Madaris suppression | Default-off seam exists; end-to-end invariant remains unverified and is a blocker before public surfaces |
| AI-era architecture | Requirements captured; AI remains disabled and unimplemented |
| Production / Hostinger / V1 isolation | Unverified; no access performed |
| M3-02 milestone | In progress; not formally accepted or closed |

## 7. Recommended next sequence

1. Close the M3-02 architecture review record with owner acknowledgement; do not equate this with full milestone acceptance.
2. Obtain a separate decision on PHP CI as a required main check and action-SHA pinning before changing GitHub governance/workflows.
3. Before M3-03, prepare a bounded synthetic-only domain foundation implementation plan that maps M2-S02/S03/S05 and V2-DEC-006 to module boundaries, contracts, testable invariants and explicit exclusions.
4. Keep physical schema/migrations, database connections, real/source data, external integrations, AI activation, Hostinger/V1/production access and deployment outside scope unless separately authorized.
5. Do not build public discovery surfaces until the Deeni Madaris cross-surface enforcement strategy and negative-test plan are ready.

## 8. Binding exclusions and limitations

No application code, package, dependency, workflow, repository setting, ruleset, branch protection, environment or hosting configuration was changed. No database config/connection/schema/migration/seed/write was created or used. No Hostinger, V1, production, SSH, hPanel, DNS, deployment, live service, external source, vendor, model, API, connector, MCP or telemetry destination was accessed or activated. No real/source/personal/student/child/institute/staff data was used. No new spend occurred.

This is a repository snapshot conformance review, not a penetration test, legal opinion, privacy impact assessment, performance test, host compatibility test, production isolation attestation or certification.

## 9. Step 3 completion

**M3-02 Step 3 — Architecture Conformance Review: COMPLETE as a read-only assessment and documentation deliverable.** The assessment is evidence-based and records partial/not-implemented/unverified areas without silently upgrading their status. Full M3-02 acceptance remains pending.