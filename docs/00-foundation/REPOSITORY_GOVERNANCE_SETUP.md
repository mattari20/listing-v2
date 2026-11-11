# Repository Governance Setup

**Repository:** `mattari20/listing-v2`  
**Checked:** 2026-11-11  
**Status:** Partially configured; ruleset saved but not enforced; auto-merge unavailable.

## Verified repository settings
- Repository is Private.
- Default branch is `main`.
- Pull requests are enabled.
- Squash, merge-commit and rebase merge methods are enabled.
- Repository-level automatic merge is disabled (`allow_auto_merge=false`).
- The GitHub Settings → General screenshot showed **Allow auto-merge** greyed out.
- The owner created and saved a ruleset named `main`.
- The ruleset's target is **Default**, which GitHub resolves to exactly one target: `main`.
- The ruleset bypass list is empty.
- Selected rules include restrict deletions, require linear history, require a pull request, require conversation resolution, require status checks and require branches to be up to date, and block force pushes.
- No required status check has yet been added to the ruleset.
- The ruleset enforcement status remains **Disabled**. GitHub displayed a warning that rulesets will not be enforced on this private repository unless it is moved to a GitHub Team organization account.
- The earlier connected integration could not administer branch protection/rulesets. Do not interpret the saved-but-disabled ruleset as active protection.

## Required owner configuration / plan decision

Keep the repository Private. Do not make it public to unlock controls.

The owner can decide whether to move the repository into an appropriately licensed GitHub Team organization or retain the current private personal-repository arrangement. This is a plan/ownership decision and must not be made automatically.

Auto-merge remains unavailable until GitHub permits it and the repository setting is enabled. Do not claim it is configured.

## Intended main-branch safeguards

When the plan and repository ownership support enforcement, configure the ruleset for `main` with:
- Require pull requests before merging.
- Require at least one approval from someone other than the PR author when a second reviewer is available. Do not invent a second reviewer for a solo-maintained project; document the temporary exception.
- Require the actual latest-head CI check for project documentation validation.
- Require branches to be up to date before merging.
- Block force pushes and branch deletion.
- Do not allow bypass for ordinary project work.
- Do not enable administrator bypass as a routine convenience.

Do not add a required status-check name until GitHub exposes the actual check from a completed run and it has been verified.

## Interim manual safeguards

Until GitHub confirms active enforcement:
- Never commit directly to `main` for ordinary work.
- Use a focused branch and PR for every change.
- Verify the latest PR head SHA and successful required checks before merge.
- Inspect changed files and scope; reject unrelated or legacy-derived content.
- Record the merge SHA and acceptance evidence in the controller.
- Never merge with failed, missing, stale, skipped or cancelled checks.
- Do not use auto-merge while the repository setting remains disabled.
- Treat the saved ruleset as configuration intent only, not an effective control.

## Completion criteria

M0-S05 remains open until the owner-level plan/settings decision is resolved, active main-branch protection (or a formally accepted interim governance exception) is evidenced, the actual required CI check is identified, and the delivery workflow is verified. A successful Actions run or a saved-but-disabled ruleset alone does not establish branch protection or auto-merge configuration.
