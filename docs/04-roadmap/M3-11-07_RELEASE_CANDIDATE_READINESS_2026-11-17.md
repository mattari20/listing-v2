# M3-11-07 — Release Candidate Readiness

**Date:** 2026-11-17  
**Repository:** `mattari20/listing-v2`  
**Baseline main at preparation:** `c77ad95a85ecce845d06c24eb629e368ac46be13`  
**Package disposition:** DOCUMENTATION PREPARATION DELIVERED; RELEASE CANDIDATE NOT CREATED; M3-11-07 NOT STARTED / BLOCKED.

## 1. Purpose and boundary

This record defines the evidence required before a V2 release candidate (RC) may be assembled, pinned, independently assessed or accepted. It is a readiness contract, not an RC, build artifact, release approval, pilot approval or go/no-go decision.

The owner-selected Option A / Option 1 scope remains limited to the existing M3-05 anonymous directory/search/profile surface and M3-06 manual text-locality discovery, in a future private V2-only acceptance environment for internal reviewers/operators and synthetic data. It does not authorize public access, a pilot, participants, production release or deployment.

The environment remains unprovisioned. M3-11-02 through M3-11-06 substantive gates remain blocked. Consequently no exact candidate commit, built artifact, artifact digest, dependency-lock digest, private-environment verification or acceptance record is supplied here.

## 2. Candidate identity contract — future use only

When and only when all prerequisite gates are independently satisfied and separately authorized, the candidate record must pin:

| Identity field | Required evidence | Current value |
|---|---|---|
| Candidate ID | Unique immutable identifier and creation timestamp | NOT CREATED |
| Source repository | Canonical repository and approved branch | `mattari20/listing-v2` |
| Source commit | Full 40-character commit SHA, verified against approved branch | NOT PINNED |
| Build workflow | Workflow name, run ID, attempt and exact source SHA | NOT RUN |
| Artifact | Immutable artifact name/location within approved private boundary | NOT BUILT |
| Artifact digest | SHA-256 (or explicitly approved stronger digest) of exact artifact bytes | NOT MEASURED |
| Dependency locks | SHA-256 for every applicable committed lockfile, captured from the exact source commit | NOT RECORDED |
| Build environment | Approved runtime/toolchain versions and reproducible build inputs | NOT APPROVED |
| Configuration profile | V2-only configuration inventory with secrets excluded | NOT APPROVED |
| Database/schema compatibility | Candidate-to-schema compatibility statement; no migration execution implied | NOT VERIFIED |
| Evidence bundle | Immutable index of test, review, privacy, accessibility, operations and recovery evidence | NOT ASSEMBLED |
| Candidate owner | Named accountable human and acceptance timestamp | NOT ASSIGNED |

A Git commit SHA is not an artifact digest. A successful CI run is not proof that a separately built artifact is byte-identical to the tested source unless the build/evidence chain explicitly establishes that relationship.

## 3. Entry gates — all mandatory

No candidate creation or candidate-specific verification may begin until each applicable item below has affirmative, dated evidence:

1. **M3-11-02 legal/privacy/safeguarding:** qualified written applicability assessment, data-flow and retention review, safeguarding/research determination, conditions and accepted owner dispositions.
2. **M3-11-03 security/accessibility:** independent written security assessment and qualified accessibility evaluation against the exact candidate and relevant environment; findings remediated/retested or formally dispositioned by accountable humans.
3. **M3-11-04 human operations:** named human release, operations, incident, support, privacy/data and applicable safeguarding owners; explicit acceptance, competence/coverage, escalation and separation-of-duties evidence.
4. **M3-11-05 environment:** separate exact-scope Product Owner authorization; identified private V2-only target; named provisioner; independently verified ingress, identity, data, storage, secrets, network, logging and V1/shared-resource isolation.
5. **M3-11-06 recovery:** separately authorized V2-only recovery rehearsal, accepted recovery owner/verifier, verified backup/restore/rollback evidence and Product Owner-approved measured RPO/RTO.
6. **M3-10 pilot/readiness disposition:** current M3-10 gates and any applicable pilot restrictions explicitly reconciled; no pilot or participant activity inferred.
7. **Scope/authority:** candidate scope remains within the owner-selected Option A / Option 1 boundary; any change requires a dated, explicit owner decision.
8. **Evidence integrity:** evidence is attributable to the exact candidate or clearly labeled as pre-candidate evidence; stale or unrelated results cannot satisfy a candidate-specific check.

If any entry gate is missing, contradictory, expired or not independently attributable, stop. Do not create a candidate and do not label the package ready.

## 4. Candidate verification matrix — future acceptance criteria

| Area | Minimum evidence for the pinned candidate | Current state |
|---|---|---|
| Source integrity | Exact source SHA; clean, reviewed change set; no untracked build inputs | NOT RUN |
| Build reproducibility | Recorded toolchain, deterministic inputs where supported, build run and artifact digest | NOT RUN |
| Required CI | All repository-required checks pass on the exact candidate SHA; run IDs and job conclusions retained | NOT RUN |
| Automated tests | Approved test suites and results tied to exact SHA; failures and skips explained | NOT RUN |
| Dependency hygiene | Lockfile identity, supported audit/hygiene results and documented findings; no new dependency without separate approval | NOT RUN |
| Configuration | V2-only configuration inventory, secure secret handling, debug/test defaults and environment separation | NOT VERIFIED |
| Public surface/privacy | Anonymous allowlist and data-minimization assertions; no private fields or test/debug routes exposed | NOT VERIFIED |
| Default-OFF controls | Public UGC/reviews/ratings/reporting/moderation remain disabled; Deeni Madaris remains default-OFF with zero public exposure | NOT VERIFIED |
| Functional smoke | Approved Option A flows in the authorized private environment using synthetic fixtures only | NOT RUN |
| Security | Independent candidate-specific findings, remediation and retest disposition | BLOCKED |
| Accessibility | Qualified candidate-specific human evaluation and accepted findings | BLOCKED |
| Recovery | Approved candidate/configuration rollback reference and independently verified V2-only recovery evidence | BLOCKED |
| Operations | Named operator, incident/support path, coverage, monitoring and stop conditions | BLOCKED |
| Evidence package | Indexed, immutable, dated evidence with source, owner, result and limitation | NOT ASSEMBLED |

Automated accessibility tools, unit tests, code scanning and successful CI are supporting evidence only; they do not replace qualified independent human assessments.

## 5. Scope-specific acceptance checks

The candidate, if eventually authorized, must demonstrate only the bounded Option A surface:

- Anonymous directory, search, category and profile behavior already implemented in M3-05.
- Manual text-locality discovery already implemented in M3-06.
- Existing approved public-field allowlist and privacy-safe unknown/stale semantics.
- No login-required or administrative surface exposed to anonymous visitors.
- No unapproved data, source, provider, institution or participant records.
- No coordinates, device geolocation, maps, distance/nearby search, geocoding or national gazetteer activation.
- No admissions/fees/scholarships/comparison capability represented as complete unless separately evidenced and authorized.
- No public UGC, reviews, ratings, reporting or moderation activation.
- Deeni Madaris remains default-OFF with zero public exposure.

This is not a new feature specification and does not authorize implementation or expansion.

## 6. Stop conditions

Stop candidate work immediately if:
- Any prerequisite gate is not satisfied or its evidence cannot be verified.
- The candidate includes changes outside the approved Option A scope.
- The build requires an unapproved vendor, dependency, API, connector, AI/model, external source or spend.
- Any action would access V1, Hostinger/hPanel, production, a live database, shared production configuration or a non-approved environment.
- Real personal/student/provider/institution/source data or participant activity is proposed.
- Public ingress, DNS, deployment, migration, release or URL cutover is proposed.
- Public UGC/reviews/moderation or Deeni Madaris exposure is enabled.
- A security, privacy, safeguarding, accessibility or recovery finding remains unresolved without an accountable, documented disposition.

Escalate to the Product Owner; do not self-waive a gate.

## 7. Decision and handoff

M3-11-07 may be considered complete only after:
- all entry gates are accepted;
- a separately authorized candidate is created and immutably pinned;
- exact-candidate verification is complete;
- independent findings and remediation are dispositioned;
- the evidence register is complete; and
- the Product Owner explicitly accepts the candidate for submission to M3-11-08 review.

Even then, candidate acceptance is not a go decision, deployment authorization or production release authorization. M3-11-08 remains a separate decision gate; M3-11-09 requires separate exact-scope execution authorization.

## 8. Current evidence-based disposition

- Repository-only checklist and evidence contract: PREPARED.
- Actual release candidate: NOT CREATED.
- Candidate commit/artifact/lock hashes: NOT PINNED.
- Candidate-specific CI, smoke, security, accessibility and operational verification: NOT RUN.
- M3-11-02–M3-11-06 substantive prerequisites: BLOCKED.
- M3-11-07: NOT STARTED / BLOCKED.
- M3-11 overall: BLOCKED / NOT ACCEPTED.

No production, V1, Hostinger/hPanel, live database, hosted environment, backup store, deployment, migration, external service, real data, participant activity or spend was accessed or used.


## Owner policy decisions received after initial preparation — 2026-11-18

The Product Owner accepts the existing weekly Hostinger automated backup cadence as sufficient for the current development stage, without paid upgrade or increased frequency. The Product Owner accepts the existing Hostinger directory password protection as the chosen private-preview control and does not require IP Manager as a second layer. The existing hosting plan is to be retained without additional spend.

These decisions clarify the intended current-stage operating choices. They do not satisfy the candidate entry gates that require verified V2-only environment isolation and recovery evidence. In particular, weekly backup policy acceptance is not proof of V2-only restore capability, backup retention, measured RPO/RTO, or candidate-linked rollback. The password-protection configuration evidence is not proof of live enforcement across nested paths and static assets. The candidate remains uncreated until all mandatory entry gates have current, attributable evidence and separate Product Owner authorization.
