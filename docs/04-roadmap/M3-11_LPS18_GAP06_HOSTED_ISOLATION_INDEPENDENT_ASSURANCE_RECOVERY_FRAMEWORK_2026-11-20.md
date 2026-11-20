# M3-11 LPS-18 — GAP-06 Hosted Isolation, Independent Assurance and Recovery Framework

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Baseline:** `c084500bc157e8578b77a262d0939e7d81d1b52d` (main after LPS-17 / PR #375)  
**Agenda:** LPS-18 — GAP-06 hosted isolation, independent assurance and recovery evidence  
**Work type:** Repository-only evidence specification and future assurance plan  
**Status:** **FRAMEWORK PREPARED — GAP-06 OPEN / NOT IMPLEMENTED / NOT EVIDENCED / NOT CLOSED**

## 1. Purpose and authority boundary

LPS-18 translates GAP-06 into a controlled evidence framework for any future proposal involving hosted V2 operation, environment isolation, independent security/accessibility assurance, backup protection, recovery objectives, restoration and rollback. It defines what evidence would be required, how it should be reviewed and what must block progression.

This agenda does not inspect or access any hosted environment, Hostinger/hPanel, V1, production, filesystems, databases, secrets, backups, DNS or deployment systems. It does not run a backup, restore, rehearsal, probe, penetration test, configuration change or production diagnostic. No external assessor is appointed and no assessment is claimed. No RPO/RTO value is invented or approved. No release candidate, pilot, deployment, public launch or execution authority is created.

Existing restrictions remain binding: repository/local/GitHub CI only; synthetic/fictional fixtures only; no real institute/source/student/child/guardian/personal data; no V1/production/Hostinger/hPanel/hosted access; no live database, migrations, backup inspection or restore; no external API, AI/model/provider, crawler or live agent; no public service activation; no deployment, pilot, candidate or release; no new dependency, paid service, hosting upgrade or additional spend. The existing weekly automated backup cadence remains accepted for current development only; it is not evidence of V2-only backup isolation, retention/deletion completeness, restore integrity, recovery time or recovery point.

## 2. Assurance principles

1. **Exact target:** evidence must identify the exact V2 environment, application revision, configuration version, storage/database boundaries and assessment period.
2. **No inferred isolation:** a subfolder choice, preview password, separate URL or repository configuration does not prove resource, filesystem, database, credential, backup, network or operational isolation.
3. **Independent assurance:** the assessor's competence, independence, scope, method, limitations and findings must be documented. Internal owner review and ChatGPT analysis are not independent certification.
4. **Least privilege:** access is role-scoped, time-limited, attributable, revocable and reviewed; secrets are not stored in ordinary repository evidence.
5. **Fail closed:** unknown or unverified boundaries, critical/high findings, missing evidence or failed recovery objectives block the relevant gate.
6. **Recovery is demonstrated:** a backup schedule or successful job status is not proof that the correct system can be restored consistently within approved objectives.
7. **No scope substitution:** a V2-only rehearsal cannot be inferred from a V1/production backup, and production evidence cannot be obtained under this agenda.
8. **Reproducibility:** evidence is dated, versioned, attributable, integrity-checked and linked to an exact scope and acceptance criterion.
9. **No gate promotion by paperwork:** templates and CI validate documentation, not real hosted isolation, security or recovery.

## 3. Future V2-only environment boundary inventory

A future separately authorized assessment must enumerate each boundary and its evidence without assuming that logical URL separation is sufficient.

| Boundary | Questions to resolve | Evidence expected |
|---|---|---|
| Hosting/account ownership | Which account, plan, tenant and control plane host V2? Who administers it? | Authorized account/resource inventory with sensitive identifiers redacted |
| Domain/subfolder/routing | What exact host/path routes to V2? Can aliases, rewrite rules or fallback paths expose another application? | Approved routing map, config revision and negative-path test results |
| Filesystem/document root | Which directories are web-accessible, writable and shared? Can V2 reach V1 files or secrets? | Directory/resource boundary map, permission evidence and traversal/access tests |
| Application runtime | Are runtime versions, process users, environment variables and writable paths isolated? | Runtime/config inventory and least-privilege review |
| Database | Is the database/schema/user isolated? What grants, network paths and credentials exist? | DB identity/grant inventory, connection-boundary tests and redacted evidence |
| Object/file storage | Are uploads, exports, temporary files and generated artifacts segregated? | Storage namespace, ACL and access test evidence |
| Secrets and credentials | Are secrets unique, scoped, rotated, protected and absent from source/logs? | Secret-management control evidence, rotation and leak-scan results without disclosing values |
| Sessions/authentication | Are cookies, session stores, keys, callback URLs and admin identities separated? | Cookie/config review, role tests and session-boundary evidence |
| Network/egress | Which inbound/outbound paths and internal services are reachable? | Authorized network map, allowlist and scoped test evidence |
| Logs/monitoring | Are logs separated, access-controlled, redacted and retained under policy? | Log routing/access/redaction/retention evidence linked to LPS-14 |
| Backups/recovery | Are backup jobs, storage, keys, retention and restore destinations V2-specific? | Backup scope/ACL/retention manifest and approved rehearsal evidence |
| CI/CD/deployment | Can CI or deployment credentials affect only the authorized V2 target? | Workflow permission review, environment protection and deployment-target evidence |
| Static/public artifacts | Can private files, source maps, dumps, logs or backups be served publicly? | Artifact inventory and negative-access test results |
| Administrative access | Are privileged actions attributable, reviewed and promptly revoked? | Role/access register, audit evidence and access recertification |

The future inventory must identify shared services explicitly. A shared account or plan is not automatically disallowed, but it requires evidence that the relevant resources and permissions are sufficiently separated for the approved risk model. If separation cannot be demonstrated, the gate remains blocked.

## 4. Threat and failure scenarios to assess

At minimum, a future scoped assessment should evaluate:
- V2 path traversal, rewrite or document-root misconfiguration exposing V1 or private files;
- cross-application database access, shared credentials or excessive database grants;
- session, cookie, authentication-key or admin-role crossover;
- secret exposure through repository history, CI logs, diagnostics, backups or error pages;
- unauthorized upload execution, file overwrite, export exposure or public storage access;
- privilege escalation, weak administrative separation, stale accounts and missing revocation;
- unintended network/egress access to internal services or prohibited external processors;
- leakage of personal, source-protected, child/student or confidential data through logs, caches, exports or backups;
- backup scope contamination, inaccessible encryption keys, corrupt/inconsistent backups or restore into the wrong target;
- incomplete deletion propagation and resurrection of removed data from backups/caches;
- CI/deployment token scope broader than the V2 target;
- monitoring gaps, unreviewed alerts, inadequate incident ownership or missing evidence preservation.

This is a threat checklist, not a finding that any vulnerability exists or has been tested.

## 5. Independent security and accessibility assurance

### 5.1 Assessor requirements

Before future assessment, record:
- assessor identity and organization in a restricted evidence store;
- relevant qualifications, experience, references and assessment competence;
- independence/conflict-of-interest declaration and relationship to the development team;
- exact application revision, environment, interfaces, roles and data classes in scope;
- methods, tools and standards selected by the qualified assessor;
- exclusions, assumptions, sampling limitations and test constraints;
- report date, evidence integrity, severity model and remediation/retest criteria;
- accountable human acceptance of findings and residual risks.

No specific certification, standard edition or legal conclusion is asserted by this framework. The Product Owner must approve the exact assessor and scope separately. An internal owner review or AI-generated checklist cannot substitute for independent assurance.

### 5.2 Security assurance scope

The future scope should consider architecture/configuration review, authentication/authorization, access control, input/output handling, file/storage exposure, secrets, dependency and build integrity, logging/monitoring, backup controls, abuse cases and incident response. Dynamic testing or penetration testing requires explicit target-specific authorization and must never extend to V1, production or third-party systems without separate authority.

Findings should include unique ID, affected asset/revision, severity and rationale, reproducible evidence reference, impact, exploitability, remediation owner, due date, retest result and residual-risk decision. Critical/high findings or unknown critical boundaries block the relevant gate; no finding may be silently waived by a CI pass.

### 5.3 Accessibility assurance scope

Future independent accessibility assessment should identify exact pages/components, user journeys, browser/assistive-technology combinations, test method, applicable standard/version, manual checks, automated checks and limitations. It should cover keyboard access, focus order/visibility, semantics and names, forms/errors, contrast, zoom/reflow, language/direction, dynamic updates, accessible authentication and relevant assistive-technology behavior.

Static source inspection and automated checks are useful evidence but do not establish complete conformance or usability. Manual assistive-technology testing and qualified independent assessment remain outstanding; no WCAG conformance claim is made by LPS-18.

## 6. Backup, retention and recovery control model

Backup/recovery evidence must be reconciled with LPS-14 data inventory, retention and deletion requirements.

A future backup register should identify:
- protected system/data classes and explicit exclusions;
- source environment and V2-only boundary;
- backup type, schedule, frequency and trigger;
- encryption in transit/at rest and key ownership/rotation;
- storage location, account/tenant, access roles and separation;
- integrity checks, catalog/manifest and job-failure alerts;
- retention period, expiry, legal hold and deletion propagation;
- immutable/offline protections if selected by the approved risk model;
- restore target, isolation controls and prevention of overwrite/crossover;
- backup owner, recovery operator, independent verifier and deputies;
- last successful test, evidence reference, exceptions and next review.

The existing weekly automated backup cadence is a development-stage policy decision only. It does not establish backup contents, V2-only separation, encryption, immutability, retention, successful restore, data consistency, measured RPO/RTO or operational readiness.

## 7. RPO/RTO definition and approval

No numerical RPO or RTO is set here. Before any recovery rehearsal, accountable human owners must propose and approve objectives based on service criticality, data-change rate, student/institute impact, dependency recovery, staffing and actual hosting capabilities.

| Objective | Required definition | Evidence to retain |
|---|---|---|
| RPO | Maximum tolerable data loss expressed as time between recoverable state and disruption | Approved value, rationale, data scope and measured rehearsal result |
| RTO | Maximum tolerable elapsed time to restore agreed service capability | Approved value, start/stop definition, scope and measured rehearsal result |
| Recovery scope | Which application, configuration, data and dependencies must return | Versioned recovery manifest and acceptance criteria |
| Integrity | How completeness, consistency and correctness are established | Checksums/manifests, synthetic reconciliation and verifier sign-off |
| Security | How secrets, permissions, isolation and access are re-established | Access-control verification and security review |
| Data lifecycle | How deletion/holds/retention remain correct after restore | LPS-14 reconciliation and post-restore deletion/expiry controls |

A target is not accepted merely because it is convenient or because a backup frequency appears similar. If the existing hosting plan cannot support an approved objective, the decision must be to revise the objective or keep the gate blocked—not to assume an upgrade or spend.

## 8. Future recovery rehearsal plan — not authorized or performed

A separately authorized rehearsal, if ever approved, must be a controlled exercise against a specifically approved V2-only isolated target using synthetic data and a defined source artifact. It must not use V1/production data or backups.

Proposed phases:
1. **Authorization:** exact target, scope, date/window, source artifact, synthetic dataset, roles, stop conditions and rollback plan approved in writing.
2. **Preflight:** confirm target identity and isolation, access permissions, source backup manifest, encryption/key availability and clean destination.
3. **Restore:** restore only the approved V2 synthetic backup/artifact into the isolated target; record start/end and all deviations.
4. **Integrity:** verify manifests/checksums, schema/configuration version, referential consistency, application bootstrap and synthetic workflow invariants.
5. **Security:** verify permissions, secret handling, session invalidation, public-file boundaries and absence of unintended V1/production connectivity.
6. **Lifecycle:** verify retention/deletion/hold controls and ensure removed synthetic records are not resurrected contrary to policy.
7. **Functional:** execute a predefined synthetic smoke/regression suite and confirm critical workflows.
8. **Measurement:** calculate actual RPO/RTO using approved definitions and timestamped evidence.
9. **Independent verification:** a competent verifier reviews results, anomalies, integrity and limitations.
10. **Disposition:** record PASS / CONDITIONAL / FAIL, remediation, retest and explicit human acceptance; do not change gate status automatically.

Stop immediately if target identity or isolation is uncertain, a non-synthetic dataset appears, the action could touch V1/production, credentials or backups are mis-scoped, destructive overwrite is possible, or evidence integrity is compromised.

## 9. Rollback and incident response

A future rollback plan must identify:
- exact approved artifact/configuration revision and known-good recovery point;
- decision authority and execution role;
- preconditions and data-consistency checks;
- rollback trigger, stop threshold and communication path;
- database/schema compatibility and forward-fix constraints;
- preservation of audit evidence and incident timeline;
- post-rollback security, access, integrity and functional checks;
- treatment of data created after the recovery point and reconciliation with RPO;
- residual risk and closure decision.

No rollback or incident-response exercise is conducted by LPS-18. A successful code rollback alone does not establish data recovery or service restoration.

## 10. Evidence package and acceptance ledger

Each future evidence item must carry:
- evidence ID and requirement/gate mapping;
- exact target, environment and application/configuration revision;
- collection date/time, method, assessor/operator role and authority;
- source integrity/hash or controlled reference;
- result, scope, limitations, exceptions and confidence;
- finding severity, remediation and retest linkage;
- reviewer and accountable human disposition;
- confidentiality classification and restricted storage reference;
- expiry/reassessment trigger.

| Evidence package | Required contents | Current status |
|---|---|---|
| E06-01 V2-only environment inventory | Resource, filesystem, database, storage, secrets, network, CI/CD and access boundaries | NOT RECEIVED |
| E06-02 Isolation verification | Exact-scope independent evidence and negative-path tests | NOT RECEIVED |
| E06-03 Independent security assessment | Qualified assessor, scoped report, findings and retests | NOT RECEIVED |
| E06-04 Independent accessibility assessment | Manual/assistive-technology evidence, scope and limitations | NOT RECEIVED |
| E06-05 Backup control register | V2-only scope, storage, encryption, access, retention and integrity | NOT RECEIVED |
| E06-06 Approved RPO/RTO | Owner-approved objectives and rationale | NOT SET |
| E06-07 Recovery rehearsal | Separately authorized isolated synthetic rehearsal, measurements and verifier sign-off | NOT AUTHORIZED / NOT PERFORMED |
| E06-08 Rollback/incident evidence | Candidate-linked rollback and incident process proof | NOT RECEIVED |
| E06-09 Role acceptance | Named owners, competence, coverage, deputies and written acceptance | NOT RECEIVED for future hosted/release scope |
| E06-10 Residual risk disposition | Findings closure, qualified review and Product Owner decision | NOT RECEIVED |

Evidence must be received and reviewed separately. A document, policy, workflow success or verbal assurance is not equivalent to observed control evidence.

## 11. Gate mapping and stop criteria

| M3-11 gate | LPS-18 relationship | Disposition after LPS-18 |
|---|---|---|
| 01 Scope/authority | Retains Option A / Option 1 and exclusions | CLOSED for scope definition; unchanged |
| 02 Legal/privacy/safeguarding | LPS-14/15 dependencies; LPS-18 does not provide qualified review | BLOCKED / NOT ACCEPTED |
| 03 Independent security/accessibility | Defines future independent assurance scope; no assessor/report | BLOCKED for independent future assessment |
| 04 Human operations | Defines future role evidence; appoints nobody | CLOSED only for repository-only development; future ops BLOCKED |
| 05 Hosted isolation | Defines exact V2-only evidence needs; no hosted inspection | BLOCKED / NOT ACCEPTED |
| 06 Recovery | Defines RPO/RTO and rehearsal requirements; no rehearsal | BLOCKED / NOT ACCEPTED |
| 07 Release candidate | Candidate prerequisites remain unmet | NOT STARTED / BLOCKED |
| 08 Go/no-go | No candidate dossier or decision | BLOCKED / NOT DECIDED |
| 09 Execution | No execution authority | NOT AUTHORIZED |
| 10 Monitoring/closure | No authorized operation | NOT STARTED |

Stop and preserve the blocked status if any required boundary, assessor, role, objective, backup control, integrity result, deletion behavior or authorization is unknown. Any proposed hosted inspection, external assessment, restore/rehearsal, deployment, candidate, public activation or additional spend requires its own exact-scope authorization and cannot be inferred from this framework.

## 12. Future implementation/assurance acceptance criteria

GAP-06 cannot be closed until all relevant criteria are evidenced for the exact proposed target:
1. Complete V2-only environment/resource boundary inventory with shared services explicitly mapped.
2. Independently verified filesystem, database, storage, secrets, session, network, CI/CD and administrative isolation.
3. Qualified independent security assessment with critical/high findings remediated and retested or formally dispositioned by the authorized accountable parties.
4. Qualified accessibility assessment with manual assistive-technology evidence, limitations and remediation; no unsupported conformance claim.
5. Backup scope, access, encryption, integrity, retention and deletion behavior verified against LPS-14.
6. Approved, feasible RPO/RTO values with clear measurement definitions.
7. Separately authorized isolated synthetic recovery rehearsal with integrity, functional, security and measured recovery results.
8. Rollback and incident-response evidence for the exact candidate/target where applicable.
9. Named operational, security, recovery and independent-verification roles with competence, availability, deputies and written acceptance.
10. All findings, exceptions and residual risks recorded with accountable human decisions.
11. Product Owner accepts the complete evidence dossier and issues separate exact-scope authorization for any next stage.

## 13. Relationship to prior LPS work

- **LPS-11/LPS-12:** GAP-06 was registered P0 as a prerequisite to hosted/release consideration.
- **LPS-13:** changes to environment, backup, recovery, assessor scope or release controls require change-impact governance.
- **LPS-14:** inventory, retention, deletion, backup expiry and restore behavior must be consistent with the data lifecycle framework.
- **LPS-15:** source rights/privacy/safeguarding obligations remain independent prerequisites for relevant real-data/source activity.
- **LPS-16:** public evidence projections and source metadata must remain protected through backup, recovery and restoration.
- **LPS-17:** correction/complaint records, suppression and deletion must be handled consistently after any future recovery.
- **M3-11:** no gate is promoted by LPS-18.

## 14. Final disposition

- [x] V2-only environment isolation evidence model defined.
- [x] Threat/failure scenarios and boundary inventory defined.
- [x] Independent security assessor requirements and scope defined.
- [x] Independent accessibility assurance scope defined.
- [x] Backup register and lifecycle linkage defined.
- [x] RPO/RTO definition and approval requirements defined without inventing values.
- [x] Future isolated synthetic recovery rehearsal plan documented but not executed.
- [x] Rollback, incident response and evidence acceptance criteria documented.
- [x] Gate mapping, stop criteria and dependencies recorded.
- [ ] Hosted environment inspected — NOT PERFORMED / NOT AUTHORIZED.
- [ ] Independent security/accessibility assessment — NOT RECEIVED.
- [ ] Backup contents/retention/isolation verified — NOT PERFORMED.
- [ ] RPO/RTO approved or measured — NOT SET / NOT MEASURED.
- [ ] Recovery rehearsal/restore/rollback — NOT AUTHORIZED / NOT PERFORMED.
- [ ] Future hosted operational roles appointed — NOT RECEIVED.
- [ ] GAP-06 implementation/assurance accepted — NOT CLOSED.

**Final disposition:** LPS-18 is COMPLETE as repository-only framework preparation. **GAP-06 remains OPEN / DESIGNED / NOT EVIDENCED / NOT CLOSED.** M3-11-05 and M3-11-06 remain BLOCKED / NOT ACCEPTED; all ten M3-11 gate dispositions remain unchanged. No hosted access, production action, backup inspection, restore, recovery rehearsal, deployment, release or additional spend occurred or is authorized. Overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
