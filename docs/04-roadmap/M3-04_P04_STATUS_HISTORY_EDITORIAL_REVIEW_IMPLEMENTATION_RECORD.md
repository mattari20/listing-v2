# M3-04 P04 — Status History and Editorial Review Implementation Record

**Date:** 2026-11-14  
**Repository:** `mattari20/listing-v2`  
**Work package:** M3-04 P04  
**Status:** IMPLEMENTATION CANDIDATE — exact-head validation and merge pending  
**Base:** `e29eaa3439e5baa977ad923b75bd2eeed742b22a`  
**Branch:** `feature/m3-04-p04-status-editorial-review`

## 1. Authorization and boundaries

The Product Owner separately authorized P04 in the current conversation on 2026-11-14. Scope is limited to repository-local code, fabricated synthetic fixtures and local/CI validation. No Listing V1, Hostinger/hPanel, production/live database, real institution/person/student/child/staff data, source acquisition, external API/AI, public route/projection, deployment, procurement, real account/role provisioning or additional spend is included.

## 2. Delivered design

- `editorial_review_cases` links a directory entity and its claim version to an editorial workflow, recording submitter, assigned reviewer, adjudication lineage, publication decision and idempotency fingerprint.
- `directory_status_history` is append-only and records each editorial state transition, actor/class, reason, previous/current state, linked entity/claim/review case, command fingerprint and occurrence time.
- `EditorialReviewService` coordinates submission, independent review, correction, adjudication, publication approval, suppression and restoration.
- Existing `PersistedGovernanceWorkflowService` remains the authority for claim adjudication, publication, suppression and restoration. P04 does not create a parallel approval or publication mechanism.
- Status-history and audit writes occur in the same transaction as the editorial case transition.

## 3. Capability and separation-of-duties matrix

| Action | Capability | Required separation |
|---|---|---|
| Submit | `submit_directory_proposal` | Human actor; claim subject must equal the directory entity |
| Edit returned proposal | `edit_directory_proposal` plus `correct_claim` | Original submitter only; corrected claim version is resubmitted as a new case |
| Review | `review_directory_proposal` | Human reviewer differs from submitter and all evidence submitters |
| Adjudicate | `adjudicate_claim` | Human adjudicator differs from submitter and assigned reviewer; existing evidence-author separation still applies |
| Approve | `authorize_publication` | Human publisher differs from submitter, reviewer and adjudicator; existing publication policy remains authoritative |
| Suppress | `suppress_publication` | Human action scoped to the case's own publication snapshot |
| Restore | `restore_publication` | Human actor distinct from suppressor; existing current-policy/evidence checks remain authoritative |

Review outcomes are `ready_for_adjudication`, `changes_requested` and `held`. Only accepted adjudication can proceed to approval. Disputed and rejected outcomes remain non-publishable. Automated actors are denied for all editorial actions.

## 4. Files added/changed

- `database/migrations/2026_11_14_000006_create_editorial_review_and_status_history.php`
- `app/Services/Directory/EditorialReviewService.php`
- `tests/Feature/EditorialReviewServiceTest.php`
- `docs/04-roadmap/M3-04_P04_STATUS_HISTORY_EDITORIAL_REVIEW_IMPLEMENTATION_RECORD.md`
- M3-04 work plan, progress report, documentation catalogue, documentation README and M3 master plan status reconciliation.

## 5. Synthetic test coverage

The new feature suite covers table/capability contract, idempotent submission, submitter self-review denial, automated reviewer denial, reviewer/adjudicator separation, complete independent submit-review-adjudicate-approve-suppress-restore flow, status-history/audit records and disputed-claim publication denial. All fixtures are synthetic and use no real institutional or personal data.

## 6. Limits and deferred decisions

- Synthetic actor identifiers are not real account provisioning, staffing or proof of operational reviewer coverage.
- Identity merge/split and contested identity resolution remain separately gated; this work does not infer a winner.
- No user-facing editorial UI, public endpoint, public projection or production workflow is delivered.
- SQLite/local CI cannot prove production concurrency, authorization-provider integration or operational staffing.
- Retention/deletion policy, legal/privacy/source-rights/safeguarding review and production operational controls remain separate gates.

## 7. Validation and merge evidence

Pending. This record will be reconciled after exact-head PHP 8.5 foundation CI, Project documentation validation, review-thread inspection and expected-head SHA merge. No validation or merge success is claimed in this candidate record.

## 8. Safety declaration

No V1, Hostinger/hPanel, production/live database, real/source/institution/person/student/child/staff data, source acquisition, external API/AI, deployment, procurement, paid service or additional spend was used.
