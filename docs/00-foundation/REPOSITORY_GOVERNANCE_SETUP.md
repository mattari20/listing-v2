# Repository Governance Setup

**Repository:** `mattari20/listing-v2`  
**Checked:** 2026-11-11  
**Status:** Partially configured; owner-level settings remain outstanding.

## Verified current settings
- Repository is Private.
- Default branch is `main`.
- Pull requests are enabled.
- Squash, merge-commit and rebase merge methods are enabled.
- GitHub Actions documentation validation workflow is present and has completed successfully on PR #1 head `ae0aae4f8681cf5845fd70bb496629dee1b3a69a` (run 43048595474).
- Automatic merge is disabled at repository level (`allow_auto_merge=false`).
- Main branch protection is disabled (`protected=false`).
- The connected integration could not read or change branch protection. GitHub returned a permission/plan restriction. Ruleset read returned a GitHub plan restriction for a private repository.

## Required owner configuration

Keep the repository Private. Do not make it public to unlock controls.

The repository owner must review GitHub **Settings → General → Pull Requests** and:
1. Select **Allow auto-merge** if available.
2. Prefer squash merging for focused, traceable PRs; disable merge commits and rebase merges if that matches the owner's preferred history policy.
3. Enable automatic deletion of head branches after merge.

Then review **Settings → Branches**. If the current GitHub plan does not support branch protection/rulesets for private repositories, do not change repository visibility. Keep the documented manual safeguards below until the plan supports required protections.

## Required main-branch safeguards

When supported by the plan, configure a ruleset or branch protection for `main`:
- Require pull requests before merging.
- Require at least one approval from someone other than the PR author when a second reviewer is available. Do not invent a second reviewer for a solo-maintained project; document the temporary exception.
- Require the latest `Project documentation validation / Validate project control documents` check.
- Require branches to be up to date before merging.
- Block force pushes and branch deletion.
- Do not allow bypass for ordinary project work.
- Do not enable administrator bypass as a routine convenience.

## Interim manual safeguards

Until GitHub enforces the rules:
- Never commit directly to `main` for ordinary work.
- Use a focused branch and PR for every change.
- Verify the latest PR head SHA and successful required checks before merge.
- Inspect changed files and scope; reject unrelated or legacy-derived content.
- Record the merge SHA and acceptance evidence in the controller.
- Never merge with failed, missing, stale, skipped or cancelled checks.
- Do not use auto-merge until repository-level settings and required-check behavior are verified.

## Completion criteria
This setup task remains open until the owner settings are verified and a test PR demonstrates the intended protected workflow. A successful Actions run alone does not establish branch protection or auto-merge configuration.
