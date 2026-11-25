# M3 A3 — Owner-led Legal, Privacy and Safeguarding Review — 2026-11-25

**Review owner:** Product Owner
**Assistant role:** evidence organization, technical analysis, documentation and remediation support; not a second reviewer or professional certification
**Review scope:** current M3 repository/local workstation/GitHub CI, synthetic-only and future access gates
**Disposition:** OWNER-LED REVIEW COMPLETED FOR DOCUMENTARY/SYNTHETIC SCOPE; TARGET-SPECIFIC AND USER-FACING GATES REMAIN OPEN

## 1. Governing decision

The Product Owner has decided that no second-party, independent, external or paid review is required as a project acceptance prerequisite. The Product Owner is the sole acceptance decision-maker. This A3 reconciliation applies that decision to the existing legal/privacy/safeguarding review records. Historical reviewer packs are preserved but their reviewer-engagement requirements are superseded for the current M3 roadmap.

This owner-led review is not legal advice, a legal compliance certification, a formal DPIA/PIA, independent safeguarding assessment, or a verification of an unprovisioned hosted target.

## 2. Scope and audience

- Current work remains repository/local workstation/GitHub CI and synthetic fixtures only.
- The recorded adult-only policy (18+) is the intended audience policy. The adult-only policy does not itself technically block minors.
- Current M3 remains non-user-facing. No public/user access, public registration, pilot or launch is authorized.
- No real student, child, guardian or other source/production data is allowed in current M3; use synthetic/fictional fixtures.
- No real account creation, participant activity, interviews, surveys or recruitment.
- Public UGC, reviews, ratings, reports and moderation remain disabled.
- Deeni Madaris remains default-OFF and absent from current M3 exposure.
- Existing discovery scope and exclusions remain as defined by the scope charter; no scope expansion is implied.

## 3. Owner review findings and disposition

| ID | Finding / risk | Current evidence | Owner-led disposition |
|---|---|---|---|
| A3-01 | Personal information may exist in developer/GitHub/commit/CI metadata even though synthetic fixtures are required. | Prior owner internal review recognizes identifiable account/commit/CI metadata. | ACCEPT for bounded development; minimize, avoid secrets/personal records, and do not claim zero personal data. |
| A3-02 | Account/session foundations exist, but effective runtime session settings and target configuration are unverified. | Source configuration and synthetic tests reviewed historically; no hosted target exists or was inspected. | DEFER target-specific acceptance; no user-facing access until target facts and configuration are reviewed by the owner. |
| A3-03 | Logging safeguards have partial local/CI implementation, but arbitrary message text, producer audit, path exposure, runtime overrides, access and backup copies remain unknown. | SEC-06 implementation/evidence record: local/CI controls; limitations explicitly recorded. | ACCEPT partial local/CI evidence only. Before any environment provisioning/access, review message content discipline, effective config, path/permissions, forwarding, access, retention and backup lifecycle. |
| A3-04 | Data-flow and lifecycle inventory is incomplete for any future hosted environment. | Environment unprovisioned; provider/region, runtime, roster, backups and deletion propagation unknown. | DEFER; no environment provisioning or real-data processing under this review. |
| A3-05 | Adult-only policy (18+) is a product policy, not technical age enforcement. | Owner decision expressly states enforcement not implemented/proven. | ACCEPT policy direction only; no user-facing access until an owner-approved proportionate access control is implemented and verified. No age-verification data collection is authorized now. |
| A3-06 | Public/source data rights, accuracy, correction/withdrawal and source authorization remain source-specific. | Existing provenance/data-rights governance and scope exclusions. | DEFER real-source acquisition/publication to its separately authorized agenda; this review does not authorize sources or collection. |
| A3-07 | Child/minor risk remains foreseeable if the service later becomes public, despite the adult-only policy. | Adult-only policy; no minor access or data in current scope. | ACCEPT prohibition for current scope; later user-facing access requires owner review of age control, foreseeable access and safeguards. |
| A3-08 | Legal applicability, provider roles, jurisdictional processing and cross-border facts cannot be conclusively assessed without verified operator/provider/environment facts. | Owner's initial Pakistan jurisdiction decision and existing uncertainty record; hosting target not inspected. | ACCEPT as disclosed limitation for repository-only work; no compliance certification. Revisit if facts or scope change. |
| A3-09 | Public repository exposure may reveal account/commit/CI metadata; secrets or confidential data must not be committed. | Public-during-development decision and existing repository hygiene restrictions. | ACCEPT current public development repository lifecycle; keep secrets/confidential data out and change repository visibility to private at development completion per existing owner decision. |
| A3-10 | Retention/deletion, incident/breach handling and backup-copy propagation are not fully evidenced for a hosted service. | Existing lifecycle/incident framework and deferred target facts. | DEFER user-facing/hosted acceptance; no actual hosted retention/deletion or recovery claim. |

## 4. Accepted controls and restrictions

For current repository/synthetic work:

- synthetic/fictional fixtures only;
- no real student/child/guardian/provider/institution/source/production records;
- no public/user-facing access, registration, pilot, launch or participation;
- no source acquisition, scraping, contact, external API/AI, new provider, dependency or spend;
- no V1/Hostinger/hPanel/production/hosted access, provisioning, database, deployment, migration or cutover;
- no public UGC/reviews/ratings/reporting/moderation;
- Deeni Madaris remains default-OFF;
- adult-only (18+) is policy, not an implemented access-control claim;
- keep credentials, secrets and confidential material out of public GitHub commits.

## 5. Required future owner gates — not blockers to current synthetic repository work

Before any user-facing/hosted activity, the Product Owner must review and accept evidence for:

1. Exact target, operator, hosting/provider, region, subprocessors and effective configuration.
2. Data-flow and inventory for account/session, audit, logs, telemetry, backups, exports and support records.
3. Log message hygiene, configuration, path/permissions, access, forwarding, retention and backup-copy treatment.
4. Retention/deletion and incident/breach procedures as implemented for the exact target.
5. Adult-only access restriction design and verification, with minimization and no unnecessary identity-data collection.
6. Source-specific rights/provenance/accuracy/correction/withdrawal for any future real institution data.
7. Security, accessibility, operations, isolation, recovery, release and execution gates independently of this A3 agenda.

These are future user-facing/hosted acceptance dependencies, not a demand for second-party review. This A3 record does not authorize their implementation or any activity outside current scope.

## 6. A3 exit disposition

- Existing owner internal privacy/data review and DP-01–DP-06 decisions: **RECONCILED; NOT REOPENED**.
- Adult-only (18+) policy: **PRESERVED; NOT TECHNICALLY VERIFIED**.
- Synthetic-only/no-real-child-student-guardian-data restriction: **PRESERVED**.
- SEC-06 local/CI logging evidence: **PARTIAL ACCEPTANCE; LIMITATIONS PRESERVED**.
- Hosted/environment/data lifecycle facts: **DEFERRED / UNKNOWN**.
- Independent reviewer requirement: **REMOVED / NOT REQUIRED** under the owner's decision.
- A3 documentary owner-led review: **COMPLETE WITH LIMITATIONS**.
- Overall M3: **OPEN / PARTIALLY COMPLETE**; no user-facing, hosted, pilot, release or production authorization.

## 7. Change record

This agenda reconciles existing owner decisions and repository evidence; it does not implement application changes, run tests, inspect a hosted target, provision an environment, or authorize real data. The owner-only review-model decision and this A3 report are added to the documentation PR.