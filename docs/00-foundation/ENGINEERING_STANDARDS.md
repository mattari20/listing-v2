# Engineering Standards

These standards govern all V2 implementation work.

## 1. Greenfield isolation
No legacy application code, schema, migration history, deployment configuration or undocumented workaround is copied as a foundation. Keep V2 isolated from the legacy production environment.

## 2. Documentation first
Every feature has a requirement ID, user outcome, functional and non-functional requirements, design, data/security/privacy implications, dependencies, risks, acceptance criteria and tests.

## 3. One project controller
GitHub documentation is the durable source of truth for scope, decisions, milestones, tasks, blockers, PRs, evidence and next action.

## 4. Architecture before implementation
Define bounded contexts, ownership, interfaces, dependencies, data flows, authorization, error handling, observability and deployment boundaries. Record material choices as ADRs before implementation.

## 5. Database discipline
Design and review the conceptual/logical model before schema implementation. Use versioned, sequential migrations. Test fresh database creation, upgrades, constraints, indexes, foreign keys, rollback/recovery where supported and representative workflows. Never edit an already released migration as an untracked shortcut. No production schema changes without separate authorization and recovery safeguards.

## 6. Testing and quality
Use proportionate unit, integration, API, database, functional, regression, security, accessibility, performance and end-to-end tests. Critical business rules require explicit tests. Coverage targets must be meaningful and documented.

## 7. CI and merge gates
Required checks should include formatting/lint, static analysis/type checks where applicable, tests, clean database migration tests, dependency/security scanning, build validation and documentation/traceability checks. Checks must apply to the exact latest PR head. Failed, skipped, cancelled, pending and passed are distinct states.

## 8. Focused PRs
One PR should deliver one coherent step or tightly related task set. Include IDs, scope, implementation summary, tests, evidence, risks and limitations.

## 9. Security and privacy
Apply least privilege, secure authentication/authorization, validation, output encoding, CSRF protections where relevant, rate limits, secret management, secure file handling, auditability and data minimization. Treat student and reviewer information as sensitive personal data.

## 10. Environment separation
Local, CI, development, staging and production environments must use separate credentials and data stores. V2 must not connect to legacy production by default.

## 11. Release and recovery
Before any production release, require exact revision, passing CI, configuration review, migration impact analysis, backup, restore rehearsal, rollback/recovery plan, monitoring and separate authorization.

## 12. Defect process
Reproduce, record exact version and evidence, assess impact, identify root cause, implement minimal fix, add regression coverage, rerun relevant tests and record outcome. Repeated failures require systemic remediation.

## 13. Traceability
Maintain requirement → specification/decision → step/task → branch/PR → test/check → evidence → acceptance.

## 14. AI execution controls
AI must inspect existing work, follow the controller, respect scope, verify evidence, update documentation and stop at authorization boundaries. It must not fabricate success, bypass gates, duplicate tasks or silently change requirements.

## 15. Milestone acceptance
A milestone closes only when its scope, acceptance criteria, tests, security, documentation, evidence, blockers and dependencies have been reviewed and satisfied.

## 16. Automatic PR merging
The target policy is automatic merge for eligible PRs after all required checks pass on the latest head SHA, branch is current, conflicts are absent, required reviews are satisfied and repository rules permit it. Never bypass branch protection. GitHub repository settings and CI must be configured and tested before this policy is considered operational. High-risk or explicitly approval-gated changes remain excluded.
