# M2-S09 — Performance, Operations, Hosting and Recovery Design

**Status:** Architecture design draft; targets are proposals for validation, not approved SLOs.  
**Scope:** Documentation only; no provider, deployment or production action.  
**M2 weight:** 6%.

## 1. Operational objectives
The platform should provide fast, resilient, low-bandwidth public discovery across Pakistan, tolerate optional external-provider outages, protect data integrity and recover from operational failure. Design for a small initial team and avoid premature distributed-system complexity. S03 logical boundaries remain; S04 stack/hosting candidates remain unselected.

## 2. Quality attributes and provisional targets
These are starting hypotheses for later load testing and owner approval, not contractual commitments.

| Attribute | Proposed initial target | Measurement |
|---|---|---|
| Public availability | 99.5% monthly for core public discovery, excluding agreed maintenance | Independent synthetic probes |
| Search latency | p95 <= 1.5 s for warm common queries; p99 <= 3 s | Server-side request metrics |
| Profile response | p95 <= 1.5 s for cached/common profiles | RUM and server metrics |
| Error rate | < 1% eligible public requests, excluding client cancellations | Structured request telemetry |
| Core page weight | Median initial HTML <= 150 KB compressed, excluding images | Real-page payload budget |
| Accessibility | WCAG 2.2 AA candidate baseline pending explicit approval | Automated + manual audits |
| Recovery point | RPO <= 24 hours for catalogue/configuration data | Backup/restore evidence |
| Recovery time | RTO <= 8 hours for core discovery | Timed restore exercise |
| Degraded mode | Manual locality and core published profiles remain usable if maps/geocoding/AI fail | Failure injection |
| Data freshness | Source-class-specific freshness objectives; no universal cadence | Staleness dashboard by fact class |

Targets must be adjusted after synthetic traffic model, hosting quotes, realistic workload, team capability and restore tests. Do not claim these as achieved.

## 3. Capacity and performance model
Model traffic by anonymous search, profile, compare, maps, admin review, source capture and background indexing. Establish baseline/peak requests per second, concurrency, data growth, index size, media volume, geographic distribution, bot load and expected seasonal admission peaks.

Performance principles:
- HTML-first and low-JavaScript public paths remain a conditional S04 direction.
- Cache only approved public projections; never cache restricted evidence or suppressed categories in public layers.
- Cache keys must include publication eligibility/configuration version; invalidate on source withdrawal, privacy change and Show Deeni Madaris setting change.
- Search indexes are rebuildable; preserve database/publication truth as authoritative.
- Use pagination, bounded queries, image optimization, compression and payload budgets.
- External map tiles/geocoding/AI are optional dependencies; degrade gracefully without blocking manual search.
- Apply per-source, per-user and per-workload rate limits; protect against scraping, bot spikes and cost exhaustion.

## 4. Environments and release design
Conceptual environment separation:
- local development: synthetic fixtures only;
- automated CI: deterministic tests, no production credentials or real personal data;
- preview/staging: synthetic or explicitly approved minimized test data; isolated secrets and outbound egress;
- production: separate approval, least-privilege identities, restricted access, monitored changes and documented rollback.

No production environment, hosting account, credentials or deployment target is approved or accessed in M2. Deployment topology and provider remain deferred. Infrastructure-as-code and release automation are M3 implementation choices after stack and cost decisions.

Release controls: reviewed change, required CI, dependency/security scan, migration review, backup/restore readiness, smoke checks, progressive rollout where feasible, rollback criteria and accountable release approver. No database migration or production deployment is authorized by this design.

## 5. Observability and incident response
Collect privacy-minimized operational telemetry:
- availability, latency, throughput, errors, saturation, queue age and external dependency health;
- search zero-result rate, stale-fact counts, publication lag and index rebuild status;
- authorization denials, review/moderation queue age, connector/model spend and rate limits;
- backup success, restore verification and audit integrity signals.

Logs must exclude credentials, full prompts containing personal data, sensitive user content and precise location. Use correlation IDs, structured events, retention by class and access controls. Establish alert severity, on-call ownership, escalation, incident timeline, evidence preservation, user/provider communication and post-incident review before launch.

## 6. Backup, recovery and continuity
Classify recoverable assets: authoritative approved facts/publication decisions, provenance/audit metadata, source authorization registry, user accounts/reviews, application configuration, search indexes and non-authoritative caches.

Design:
- encrypted, access-separated backups with integrity checks;
- backup cadence aligned to approved RPO and data change rate;
- restore runbooks for full service, data-only and point-in-time recovery where supported;
- periodic restore exercises in isolated environments;
- search/index/cache rebuild from authoritative approved state;
- documented recovery ordering and dependency map;
- backup retention and deletion aligned with rights/privacy/legal requirements;
- incident access, key recovery and immutable audit preservation.

Do not treat a successful backup job as proof of recoverability. Recovery is verified only by a timed restore exercise and reconciliation.

## 7. Hosting and total-cost evaluation
No hosting provider or region is selected. Compare candidate options using:
- total monthly/annual cost at baseline and peak (compute, database, storage, backup, bandwidth, CDN, logs, egress, support, taxes and FX);
- Pakistan user latency and regional connectivity;
- data location, transfer, subprocessors and contractual terms;
- database backup/PITR and restore guarantees;
- security controls, patching responsibility, access audit and incident support;
- capacity limits, portability, export and exit cost;
- team operating skill, support hours and failure recovery.

Do not commit to new spend or paid services without explicit owner approval. Use vendor-neutral cost worksheet with assumptions and sensitivity ranges before final selection.

## 8. Operational risks and controls
| Risk | Control |
|---|---|
| Hosting/provider outage | Graceful degradation, tested restore, documented communications |
| Search engine outage | Database/publication fallback or safe unavailable state; indexes rebuildable |
| Map/geocoder outage | Manual locality and list discovery continue |
| AI/model outage or cost spike | Pause queue, hard budget caps, no unsafe provider substitution |
| Stale or revoked source | Freshness alerts, source-specific expiry and withdrawal workflow |
| Cache/index leakage | Versioned eligibility policy, invalidation and negative tests |
| Backup corruption | Independent integrity verification and restore exercises |
| Small-team operational overload | Modular architecture, minimal managed dependencies, runbooks and alert budgets |

## 9. M3 prerequisites
Before implementation: approve S04 technology and hosting choices with team skills/cost evidence; establish realistic traffic/data assumptions; decide SLOs; define data retention and source-specific freshness; select incident owner and escalation coverage; approve backup retention, RPO/RTO; run proof-of-fit and restore tests; obtain legal/security review. No numeric target is approved by this draft.
 
## 10. Completion status
S09 T01-T04 drafted (80%); T05 cost/operations review, measurable assumptions and owner decision pending (20%). The design is complete enough to guide M2 synthesis but not an approved hosting, SLO, spend or deployment plan.
