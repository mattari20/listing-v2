# M3-11-01 — Scope and Authority Closeout

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Decision owner:** Product Owner  
**Status:** **CLOSED — SCOPE / AUTHORITY DEFINITION ONLY**  
**Overall M3-11 status:** BLOCKED / NOT ACCEPTED

## 1. Naming convention

To prevent confusion with other M3 milestones and numbered agenda steps, all ten M3-11 work packages use the full identifiers **M3-11-01 through M3-11-10**. The shorter M11-01…M11-10 labels are superseded in current M3-11 control records.

## 2. Owner decisions recorded

1. **Option A:** controlled, limited V2 scope containing only the already implemented M3-05 anonymous directory/search/category/profile experience and M3-06 manual text-locality discovery.
2. **Option 1:** private acceptance environment only. No public pilot, public production release, launch or URL cutover.
3. **Audience:** no public audience, students, guardians, research participants or recruited users. Any future access is limited to specifically named and authorized internal reviewers/operators after the relevant role, security and environment gates are satisfied. No individuals are appointed by this record.
4. **Geography:** Pakistan-first text locality using the existing province/district/city/locality facts where available. No claim of nationwide coverage or authoritative administrative boundaries.
5. **Data:** synthetic/fictional test fixtures only. No real institution, provider, student, guardian, staff, source or production data; no personal data; no external source acquisition.
6. **Research/pilot:** student research, interviews, surveys, recruitment, participant activity and the M3-10 pilot remain deferred/not accepted. No pilot is part of Option 1.
7. **Target environment category:** an isolated, private V2-only acceptance environment. Its host, path, runtime, database, credentials, secrets, access roster and isolation evidence remain unspecified and unprovisioned. Separate M3-11-05 authorization and evidence are required before environment creation or access.

## 3. Included discovery scope

- Anonymous, read-only server-rendered directory browse and text search.
- Existing supported provider, institution, campus, programme and qualification result categories and category facets.
- Eligible published entity profiles.
- Manual text locality search/display for approved province, district, city and locality facts.
- Existing approved anonymous-directory projection, public-field allowlist, evidence/source-authorization, current-version and suppression controls.
- Explicit unknown observation/freshness states; no inferred verification.

No feature implementation or behavior change is authorized by this closeout.

## 4. Excluded scope

Admissions/application submission, eligibility, deadlines, fees, scholarships, payments, shortlist/save/compare/share/alerts, accounts-dependent discovery, ranking/recommendations/sponsored placement, fuzzy/transliteration search, maps/geolocation/coordinates/geocoding, live source ingestion, external APIs/connectors/AI, public reviews/ratings/UGC/reporting/moderation, Deeni Madaris public exposure, student research/participants, V1 access/change, production database access, Hostinger/hPanel, migrations, deployment, DNS/URL cutover, public pilot and public launch remain excluded.

Deeni Madaris remains default-OFF with zero public exposure.

## 5. Package disposition

| Package | Status | Meaning |
|---|---|---|
| **M3-11-01 — Authority and scope** | **CLOSED** | Owner's limited discovery scope, private acceptance target category, audience, geography/data limits and pilot deferral explicitly recorded |
| M3-11-02 — Legal/privacy/safeguarding | BLOCKED | Qualified written review and owner disposition absent |
| M3-11-03 — Independent security/accessibility | BLOCKED | Independent security and qualified accessibility assessments absent |
| M3-11-04 — Human operations/support | BLOCKED | Named human owners and explicit role acceptances absent |
| M3-11-05 — Runtime/environment separation | BLOCKED | Private V2-only environment not provisioned; isolation/access evidence and separate authorization absent |
| M3-11-06 — Backup/restore/rollback | BLOCKED | V2-specific rehearsal and measured RPO/RTO absent |
| M3-11-07 — Release candidate | NOT STARTED | No candidate authorized |
| M3-11-08 — Change/go-no-go | BLOCKED | Evidence pack and accountable approvals absent |
| M3-11-09 — Production execution | NOT AUTHORIZED | Outside private acceptance-only scope |
| M3-11-10 — Monitored operation/closure | NOT STARTED | No authorized release or operation |

## 6. Acceptance evidence and limitations

M3-11-01 is complete when this decision record and the owner charter are merged, indexed and validated on the exact PR head. This is a documentary scope/authority closure only. It does not mean that a private acceptance environment exists, has been security-reviewed, is ready for users, or has been approved for access.

Repository CI proves only the changed repository/documentation checks. It does not provide legal/privacy/safeguarding advice, independent security/accessibility review, human role acceptance, runtime/environment isolation, recovery rehearsal, release candidate approval or a go/no-go.

## 7. Binding stop conditions

- No V1 access/change; no Hostinger/hPanel or production/live database access.
- No environment provisioning or access until separately authorized under M3-11-05.
- No deployment, migration, DNS/URL cutover, public pilot or launch.
- No real/source/personal data or participant activity.
- No external source/API/AI/model/connector; no new dependency/vendor/spend.
- No public UGC/reviews/ratings/reporting/moderation; Deeni Madaris remains default-OFF.

**Final disposition:** **M3-11-01 CLOSED** for scope/authority definition. **M3-11 overall remains BLOCKED / NOT ACCEPTED** until all remaining independent gates are satisfied. No private environment creation/access or production action is authorized by this record.


## Repository visibility clarification — Product Owner decision, 2026-11-20

The Product Owner clarified that the GitHub source repository `mattari20/listing-v2` is intentionally **PUBLIC during the development phase** and will be changed to **PRIVATE when development is complete**; this is the binding future visibility transition in this decision record. This is distinct from the restricted/private V2 acceptance-environment target and does not authorize public application access, public pilot, release, production operation, real-data processing, source acquisition or participant activity. No credentials, secrets, personal records or confidential reviewer materials may be placed in the public repository. All existing M3-11 scope, environment, data and stop restrictions remain unchanged.