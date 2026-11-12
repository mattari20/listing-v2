# M2-S01 — Quality Attribute Scenarios and Targets

**Status:** Proposed design baseline. Numeric service targets are intentionally not finalized until M2-S09 capacity, cost and operational analysis.

## 1. Quality model reference

Use ISO/IEC 25010:2023 as a completeness prompt for product-quality characteristics, adapted to V2's student, data-integrity, safety and operational needs. It is a reference model, not a certification claim. For accessibility, use W3C WCAG 2.2 as the current design reference; a conformance level is proposed below and requires owner acceptance.

## 2. Priority quality attributes

| Attribute | V2 concern | Design direction |
|---|---|---|
| Functional suitability | Students need correct, scoped education facts and useful discovery | Evidence-backed capabilities and explicit unknown/missing states |
| Security and privacy | Student/minor data, privileged controls and source credentials | Least privilege, data minimization, trust boundaries, audit and threat modelling |
| Reliability and recoverability | Stale or conflicting facts can mislead; service failures can interrupt access | Preserve history, graceful degradation, backup/restore and reversible publication |
| Performance efficiency | Mobile users and low-bandwidth networks | Text-first experience, bounded payloads, caching strategy evaluated later |
| Interaction capability / accessibility | Diverse devices, abilities and language direction | Keyboard/screen-reader support, readable forms, responsive layouts and RTL-safe design |
| Compatibility / interoperability | Many heterogeneous source formats and authority systems | Explicit source adapters/contracts only after rights approval; normalize without losing original meaning |
| Maintainability / flexibility | National coverage and source patterns evolve | Clear domain boundaries, documented decisions and replaceable adapters |
| Safety | Incorrect recognition/admissions/fees or unsafe user-generated content can cause harm | High-impact human review, moderation and clear uncertainty |
| Cost sustainability | New paid services and excessive operational complexity create risk | Cost-aware options evaluation; no paid commitment without approval |

## 3. Quality scenarios

| ID | Stimulus / condition | Required system response | Verification concept | Target status |
|---|---|---|---|---|
| QS-01 | A visitor declines precise device location | Manual province/district/city/locality search remains usable; no forced location permission | Browser permission-denial test; inspect network/storage for unnecessary coordinates | Behavioural requirement fixed; latency target S09 |
| QS-02 | A student searches for a programme at a multi-campus institution | Results distinguish institution, campus and programme; no unsupported campus inference | Domain/search fixture tests with separate campus offers | Required; search latency S09 |
| QS-03 | A source provides a new high-impact recognition/admission/fee assertion | It is not publicly published until rights, authority, scope, freshness and required human review pass | Workflow state-transition and negative publication tests | Required; review SLA S07/S09 |
| QS-04 | Two sources conflict on a material fact | Both assertions and provenance remain visible to reviewers; no silent overwrite | Conflict injection and history/audit tests | Required |
| QS-05 | A source page contains prompt-injection or instruction-like text | Content is treated as untrusted evidence, never as agent instruction | Adversarial document test; prompt/data boundary inspection | Required |
| QS-06 | Show Deeni Madaris is OFF | No Deeni Madaris record is returned or counted by any public discovery surface/API; source records remain retained internally | Cross-surface negative test matrix: search, browse, map, recommendation, counts, sitemap, export, public API | Required; zero exposure invariant |
| QS-07 | A user attempts a privileged visibility change without permission | Change is denied; attempt is logged; current setting is unchanged | Authorization matrix and audit-log test | Required; S08 |
| QS-08 | A user browses or compares without an account | Publicly eligible facts remain accessible; sensitive account fields are not requested | Anonymous journey and privacy review | Required |
| QS-09 | A user attempts to submit a review before launch or without authentication | Review submission is unavailable until launch gate and authentication/eligibility policy are satisfied | Feature flag/state and authorization tests | Required; post-launch |
| QS-10 | Map/geocoding or messaging provider is unavailable | Core text search, profiles and official contact information remain usable; optional feature degrades clearly | Dependency outage/fallback test | Required; provider selection pending |
| QS-11 | User accesses on small screen and constrained bandwidth | Core discovery is text-first and does not require autoplay media or map-only interaction | Responsive, throttled-network and payload tests | Required; numeric budgets S09 |
| QS-12 | User requires assistive technology or keyboard-only navigation | Core discovery and forms remain perceivable and operable; errors and status changes are programmatically exposed | WCAG 2.2 AA candidate audit and assistive-technology tests | Proposed target; owner approval required |
| QS-13 | A user changes preferred language or uses RTL content | Layout, search and text direction remain coherent; Unicode is preserved end-to-end | Unicode, mixed-direction and RTL tests | Capability required; launch language scope open |
| QS-14 | A publication or integration process fails partway | Prior approved public version remains available or can be restored; partial state is not silently treated as success | Failure injection, transaction/recovery tests | Required; mechanism and RPO/RTO S09 |
| QS-15 | A source authorization expires or is revoked | Further retrieval is blocked; downstream data is quarantined/withdrawn according to approved rights and retention policy | Revocation and downstream impact tests | Required; detailed policy S05/S07 |
| QS-16 | Public coverage is incomplete or data is stale | User sees the applicable coverage, as-of, missing/stale/disputed state; absence is not interpreted as non-existence | Fixture tests and content review | Required |
| QS-17 | Review abuse or credible safety/privacy report occurs | Report is triaged under documented policy; reviewer private data is protected; appeal and evidence trail retained | Abuse-case and moderation tabletop tests | Required; post-launch |
| QS-18 | Traffic or data volume grows beyond initial assumptions | Architecture can scale within approved cost/operational envelope without loss of provenance or access control | Load/capacity test at targets selected in S09 | Target pending |
| QS-19 | Service or operator error requires recovery | Approved backup can be restored and verified within owner-approved RPO/RTO | Restore rehearsal and evidence review | RPO/RTO pending S09 |
| QS-20 | Source/provider claims are updated or corrected | Prior versions and reviewer decisions remain auditable; correction propagates to affected public surfaces | End-to-end lineage and cache/index invalidation test | Required; mechanism S05/S06 |

## 4. Proposed accessibility baseline

Recommend designing toward **WCAG 2.2 Level AA** for core public journeys, forms and administration interfaces, subject to owner acceptance and later audit. This is a proposed quality target, not a legal conclusion or claim of conformance. M2-S08/S09 and M11 must define scope, test methods, exceptions and acceptance evidence.

## 5. Targets deliberately deferred

Do not invent numeric targets before the system's expected scale and budget are understood. M2-S09 must propose and justify:
- Search/profile/API p50 and p95 latency budgets.
- Availability and maintenance expectations.
- Peak concurrent users and growth assumptions.
- Page weight and low-bandwidth loading budgets.
- Background processing and data refresh service targets (only for approved sources).
- Backup frequency, RPO and RTO.
- Monitoring/alert thresholds and incident response expectations.
- Cost envelope and operational staffing burden.

## 6. References

- ISO/IEC 25010:2023, Product quality model: https://www.iso.org/standard/78176.html
- W3C WCAG 2.2 Recommendation: https://www.w3.org/TR/wcag/
- W3C WCAG overview and recommendation history: https://www.w3.org/WAI/standards-guidelines/wcag/

These standards are design references. Their use does not imply certification, legal compliance or a completed accessibility audit.
