# M3-03 Agenda 10 — Completion and Evidence Record

**Completed:** 2026-11-14  
**Status:** COMPLETED — bounded synthetic local/CI scope  
**Repository:** \`mattari20/listing-v2\`  
**Implementation PR:** [#170 — Persist temporal conflicts and prior-snapshot rollback](https://github.com/mattari20/listing-v2/pull/170)  
**Implementation branch:** \`feature/m3-03-agenda-10-conflicts-rollback\`  
**Validated PR head:** \`390bead3f28ccc64520d92b7c636455c08fd93a4\`  
**Merge commit:** \`1a4f37303913163a4866f660c469078802a7a4ed\`  
**Base:** \`799adb9c64f6ad45739b847f4bab80e947f83752\` (PR #169 reconciliation merge)

## 1. Owner authorization and scope

The Product Owner explicitly authorized the exact Agenda 10 scope proposed in the M3-03 exit reconciliation. Work remained limited to local/CI synthetic fixtures.

No Listing V1, Hostinger/hPanel, production/live database, real/source/personal/institute/student/child/staff data, source acquisition, external API/AI, real role provisioning, public endpoint, deployment, procurement, new spend or repository protection changes were used or introduced.

## 2. Delivered implementation

### Persisted conflict lifecycle

Migration \`2026_11_14_000002_create_persisted_conflicts_and_rollbacks.php\` adds:

- \`claim_conflicts\`: deterministic fingerprint, idempotency, conflict kind/status, human resolution candidate, adjudication linkage and resolution rationale.
- \`claim_conflict_candidates\`: immutable candidate version references, valid-time bounds, recorded time and value digest.
- \`publication_rollbacks\`: current/target snapshot lineage, human actor, policy version, reason, idempotency and event time.

The conflict service verifies that supplied candidates exist, belong to the same claim, contain incompatible values, have valid date intervals and overlap pairwise. Date bounds are inclusive and null bounds are open-ended. Non-overlapping assertions do not produce a conflict aggregate. Recorded-time differences are retained and classified, but never select a winner.

Conflict resolution requires a candidate-specific persisted accepted human adjudication, a separate human resolver with the required capability, and a rationale. Candidate history remains preserved. No automated winner selection or latest-recorded-wins policy was added.

### Prior-approved-snapshot rollback

Rollback is a distinct human-authorized command, not suppression restoration. It is restricted to an older approved snapshot in the same claim-version/surface/audience lineage. The command checks current claim/evidence/source-authorization eligibility and separation from the original publisher, then writes a rollback record, audit event and transactional outbox event.

The existing leased outbox worker handles the rollback event. Before changing the internal projection it rechecks current policy and verifies that the projection still points at the snapshot captured when rollback was authorized. Stale or newly ineligible rollback events fail closed. Historical snapshots and prior audit events are retained.

### Test-harness determinism

The pre-existing synthetic source-authorization fixture in \`GovernanceServiceContractTest\` expired at 2026-11-14 00:00 UTC and failed when CI crossed that midnight. Its valid-to date was extended by one day. This changes only a synthetic test fixture; it does not change application authorization policy.

## 3. Exact-head validation evidence

Both required checks passed on exact PR head \`390bead3f28ccc64520d92b7c636455c08fd93a4\`:

| Check | Run | Result |
|---|---:|---|
| FND-01 PHP 8.5 foundation CI | [#43531770613](https://github.com/mattari20/listing-v2/actions/runs/43531770613) | **SUCCESS** |
| Project documentation validation | [#43531770710](https://github.com/mattari20/listing-v2/actions/runs/43531770710) | **SUCCESS** |

Foundation CI passed toolchain/SQLite checks, Composer validation/install, dependency advisory audit, Pint formatting, Laravel bootstrap/routes, synthetic tests and repository artifact hygiene. No dependency vulnerability advisories were reported.

The complete synthetic suite reported **209 assertions with no failures**. It emitted **50 non-fatal warnings** from the existing test harness attempting to read an absent local \`.env\` file. No \`.env\`, database dump or other local runtime artifact was committed or created.

Project documentation validation confirmed all 15 required control documents exist, all relative Markdown links resolve and strict legacy non-interference controls are present.

## 4. Review and merge evidence

- No unresolved review threads were present.
- No review submissions were present.
- PR head and base were re-fetched before merge.
- The comparison was 19 commits ahead and 0 behind, with only the 11 intended application, migration, test and documentation files changed.
- PR #170 was merged using expected-head SHA \`390bead3f28ccc64520d92b7c636455c08fd93a4\`.
- Main merge commit: \`1a4f37303913163a4866f660c469078802a7a4ed\`.

## 5. Acceptance matrix

| Reconciliation gap | Agenda 10 outcome |
|---|---|
| G-01 — persisted conflict/candidate lifecycle | **Closed for bounded synthetic scope** — first-class records, candidate preservation, human adjudication linkage and independent resolution |
| G-02 — temporal conflict evaluation | **Closed for bounded synthetic scope** — pairwise valid-time overlap, non-overlap succession, recorded-time provenance and invalid-range rejection |
| G-03 — explicit rollback to prior approved snapshot | **Closed for bounded synthetic scope** — separate rollback record, audit/outbox lineage, current-policy recheck and stale-projection refusal |
| G-04 — complete deterministic oracle traceability | **Still open** — T-001–T-032 and GS-001–GS-032 remain specification/policy catalogues and must be mapped to actual runtime tests, partial coverage or explicit deferral |

Agenda 10 is **COMPLETED** for its authorized scope. It does not complete M3-03 as a whole.

## 6. Explicit limitations and remaining gates

- No automated conflict resolution, fuzzy matching, global entity deduplication or recency-based winner selection.
- Conflict evaluation is an explicit service command over supplied claim-version IDs; no scheduler, ingestion pipeline, source discovery or public endpoint was introduced.
- No production multi-process concurrency, external broker, real role provisioning, production retention/deletion controls, specialist sign-off or deployment is claimed.
- The full T/GS oracle traceability exercise (G-04) remains necessary before M3-03 can be considered exit-ready.
- M3-04 Provider Management remains blocked until G-04 is reconciled and the complete M3-03 exit criteria are reviewed and accepted.

**Final outcome:** Agenda 10 is closed. M3-03 remains **IN PROGRESS**. The next and only recommended activity is M3-03 G-04 deterministic-oracle traceability reconciliation; do not begin M3-04 implementation before M3-03 exit acceptance.
