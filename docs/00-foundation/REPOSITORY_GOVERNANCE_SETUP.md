# Repository Governance Setup

**Repository:** `mattari20/listing-v2`  
**Checked:** 2026-11-11  
**Status:** Configured; active main ruleset and repository auto-merge enabled.

## Verified repository settings
- Repository visibility is Public (owner-confirmed and verified through repository metadata). Public visibility is an owner decision; do not change it automatically.
- Default branch is `main`.
- Pull requests are enabled.
- Repository-level automatic merge is enabled (`allow_auto_merge=true`).
- Squash, merge-commit and rebase merge methods are enabled. Prefer squash for focused, traceable project PRs unless a V2 decision changes this policy.
- The owner created ruleset `main` (ID `27043221`), targeting the default branch, which resolves to `main`.
- Ruleset enforcement is **Active**, verified through the GitHub API.
- Bypass actor list is empty; current-user bypass is `never`.
- Rules require pull requests, conversation resolution, linear history, successful required status checks, branches up to date, deletion restriction and non-fast-forward/force-push restriction.
- Required status check is `Validate project control documents` (GitHub Actions integration).
- Required approving review count is 0 because this is currently a solo-maintained repository; do not fabricate a second reviewer. Revisit if a qualified independent reviewer becomes available.

## Required main-branch safeguards

The active ruleset currently enforces:
- Pull requests before merging.
- Required status check `Validate project control documents`.
- Branches up to date before merging.
- Conversation resolution.
- Linear history.
- Branch deletion restriction.
- Block force pushes.
- No bypass actors.

Do not weaken these safeguards for convenience. If new CI workflows are introduced, update required checks only after verifying their actual check names on successful runs.

## Automatic merge policy

Repository auto-merge is enabled. Auto-merge may be enabled on an individual PR only after:
1. The exact current PR head SHA has successful required checks.
2. The diff and changed-file scope have been reviewed.
3. All review threads are resolved.
4. The PR meets the active `main` ruleset.
5. The PR does not contain unapproved architecture, dependency, data-rights, security, production or other controlled decisions.

Auto-merge waits for GitHub's merge requirements; enabling it is not equivalent to immediate merge approval. Do not enable it on a PR with stale, missing, failed, skipped or cancelled required checks.

## Operating procedure

- Use a focused branch and PR for every ordinary change; do not commit directly to `main`.
- Verify the latest PR head SHA and required check result before enabling auto-merge.
- Inspect changed files and scope; reject unrelated or legacy-derived content.
- Record the PR number, head SHA, required checks, merge SHA and acceptance evidence in the controller, traceability matrix, progress report and documentation catalogue as applicable.
- Reconcile the documentation catalogue after every documentation PR update and merge.
- Never expose secrets, private student data or credentials in issues, PRs or logs.

## Completion criteria

M0-S05 repository workflow configuration is complete based on the active ruleset, configured required CI check, PR/issue templates and enabled repository auto-merge. M0-S06 still requires a separate end-to-end test PR demonstrating the workflow.
