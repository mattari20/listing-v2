# RCV-B08 — Account Saved Items, Sharing and Alerts: Privacy/Architecture Design

**Date:** 2026-11-20  
**Repository:** mattari20/listing-v2  
**Baseline main:** c6cb7b679271efdfe5fd5d6be8b93cd428036f19  
**Status:** Design proposal only; Product Owner decision pending; no implementation authorization.

## 1. Design constraints inherited from existing decisions

- Core directory browsing and comparison remain anonymous.
- The first comparison implementation uses a temporary session shortlist. Do not silently convert that state into account persistence.
- Existing account authentication is pre-provisioned, active and verified only. Public registration, verification delivery, recovery and account self-service are absent.
- Account authentication does not establish student status, attendance, alumni status or institutional affiliation.
- Public UGC/reviews remain disabled; Deeni Madaris remains default-OFF.
- No real accounts, personal records, external messaging, vendor, new dependency or spend is approved.
- The owner privacy review's DP-02 session configuration gate and DP-03 logging policy condition remain binding before any target provisioning or reviewer access.

## 2. Proposed data boundaries for private saved items

If B08-B is approved, a minimal saved-item record should contain only:

| Field | Purpose | Constraint |
|---|---|---|
| id | Internal row identity | Opaque primary key; not exposed as a public share token |
| user_id | Owner account | Foreign key; owner-only authorization on every operation |
| entity_id | Saved directory subject | Reference only; must resolve through current eligible public projection |
| created_at | Save time | Server generated |
| updated_at | Optional state timestamp | Server generated; omit if not needed |

Add a unique constraint on (user_id, entity_id) and a server-side maximum. Avoid storing copied names, addresses, source facts, notes, rankings or private evidence; the current public projection remains authoritative and can change or be suppressed independently.

Potential lifecycle: save -> private owner view -> remove. Account closure/deletion should remove saved-item rows within the approved deletion workflow. No automatic inactivity expiry is specified until the owner selects a retention period.

## 3. Authorization and disclosure model

- Anonymous users continue to use the current session shortlist; no saved-item persistence is added for guests.
- Authenticated saved-item endpoints must verify ownership server-side using the current authenticated user ID, never a client-supplied user ID.
- Cross-account access, enumeration and IDOR attempts must return a non-disclosing denial/not-found response.
- Each saved entity must be re-resolved against the current approved anonymous directory projection at read time. Do not return a stale copy after withdrawal, suppression, restricted visibility or Deeni Madaris suppression.
- Saved lists are private by default. No institution, representative, moderator or other user can see a person's saved list through existing roles.
- Do not infer preferences, educational status, ability, religion, age or location from the saved list.

## 4. Sharing design — later stage only

If sharing is later approved, use a separate share resource rather than exposing the saved-list primary key:
- cryptographically random high-entropy token stored as a hash where feasible;
- read-only view with an explicit allowlist of public projection fields;
- owner-controlled creation, expiry and immediate revocation;
- no indexing, sitemap inclusion or public discovery;
- access rate limits, abuse monitoring with privacy-minimized logs, and no token leakage in referrers;
- disclosure text that explains exactly what the recipient can see;
- deletion/revocation propagation and retention rules.

No share token, public share route or shareable URL is part of the first slice.

## 5. Alerts and notification consent — later stage only

Before any alert subscription exists, define:
- what change events qualify (for example, a newly published admission-cycle fact versus a correction/withdrawal);
- event freshness and deduplication so stale or repeated claims do not create misleading alerts;
- whether notifications are in-app only or use email/SMS/push, with a separately approved provider and cost ceiling if external delivery is chosen;
- explicit per-category and per-channel opt-in, consent timestamp/version, confirmation where appropriate, and one-step opt-out;
- delivery frequency, quiet hours, retry/dead-letter policy, bounce/invalid-channel handling and abuse limits;
- what is logged, for how long, and how consent/queue data is deleted on account closure.

Do not create default subscriptions, send messages or choose a vendor in this agenda's first slice. An in-app alert center still needs event semantics, read/unread state and retention rules.

## 6. Account lifecycle dependencies

The current sign-in endpoint authenticates only pre-provisioned verified accounts. A public saved-items feature cannot be treated as a complete public product until the owner separately decides whether to introduce registration, verification, recovery, account closure and support processes.

Recommended order:
1. Decide the account lifecycle and whether first release remains internal/pre-provisioned only.
2. Approve saved-item ownership, privacy, deletion and retention policy.
3. Authorize a minimal private saved-item table and owner-scoped routes, with synthetic-only fixtures.
4. Separately design share tokens if sharing is desired.
5. Separately design alert events, consent, delivery and retention; approve any provider/spend before integration.
6. Reconcile session cookie/security settings and log policy before any target provisioning or real account use.

## 7. Test contract for a future B08-B implementation

- Owner can save and remove a currently eligible public entity.
- Repeated save is idempotent and uniqueness is enforced.
- User A cannot read, update or delete User B's saved item, even with a guessed row ID.
- Anonymous users cannot call account-saved-item endpoints.
- Mixed entity types are not relevant to saving but existing session comparison behavior remains unchanged.
- Withdrawn, superseded, unpublished, suppressed, restricted and Deeni Madaris records do not leak through saved lists.
- Current public projection changes are reflected without copying stale values into saved rows.
- Maximum saved-item count is enforced transactionally.
- Account deletion behavior and retention are tested only after explicit owner policy.
- No alert is sent without explicit active consent; opt-out blocks subsequent delivery in any future approved delivery stage.
- No personal data appears in logs or error messages.

## 8. Open owner decisions

Policy choices are listed in the companion RCV-B08 scope and acceptance pack. This design intentionally does not select a public registration model, retention duration, share-link policy, alert channel, notification cadence, vendor or spend.

## 9. Current disposition

Design is prepared for Product Owner review. No code, schema, migration, route, message, external service or target configuration has changed.