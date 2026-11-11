# AI Execution Protocol

## Purpose
Enable high-autonomy, resumable delivery while keeping scope, quality, security and production boundaries controlled.

## Start-of-session procedure
1. Read `PROJECT_MASTER_CONTROL.md`, roadmap, step register, relevant specifications and decisions.
2. Inspect current GitHub state: main SHA, branches, PRs, checks and outstanding review comments.
3. Detect existing work before creating a branch or task. Never duplicate or restart active work.
4. Select the exact next eligible step from the register.
5. Confirm dependencies and authorization boundaries.

## Execution cycle
1. State the step ID and intended scope in the branch/PR.
2. Read all relevant requirements and acceptance criteria.
3. Implement the smallest coherent change.
4. Add or update tests and documentation.
5. Run applicable checks and inspect failures.
6. Open a focused PR with requirement/step IDs, changed files, tests, risks and evidence.
7. Verify checks apply to the latest PR head SHA.
8. Merge automatically only when the repository's approved protection and merge policy actually permit it.
9. Verify merged state and commit SHA.
10. Update step status, traceability, progress, changelog and master controller.
11. Record the exact next eligible step.

## Autonomy permitted
- Read and analyze repository documentation and code.
- Create/update approved documentation.
- Implement approved tasks and tests.
- Fix ordinary in-scope defects.
- Create focused branches and PRs.
- Update project registers and reports.
- Merge eligible PRs only under the configured policy.

## Stop and request explicit authorization
- Material scope or product direction changes.
- Architecture decisions designated for owner approval.
- New paid services or material recurring costs.
- Destructive data changes.
- Production database access or operations.
- Production deployment, public URL cutover or replacement.
- Security exceptions, unclear data rights or unresolved high-severity risks.

## Integrity rules
Never claim tests passed without evidence. Never call a step complete before its acceptance criteria and evidence are satisfied. Never bypass failing checks, branch protections or review requirements. Never overwrite concurrent work. Never invent source data, licenses, repository results or approvals. If blocked, record the blocker and do not silently skip dependencies.

## Reporting
At each step boundary report: step ID, status, PR, latest commit, checks and exact SHA, evidence, remaining work, milestone progress, blockers and next step.
