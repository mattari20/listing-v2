# M3-01 P07 — Narrow V2 Foundation Implementation Authorization Request

**Prepared:** 2026-11-13  
**Status:** REQUEST FOR EXPLICIT PRODUCT OWNER DECISION — NOT AUTHORIZED  
**Repository:** `mattari20/listing-v2`  
**Target branch after authorization:** `feature/m3-foundation-01` (create only after authorization)  
**Preferred stack direction:** Laravel 13 / PHP 8.5; Hostinger MySQL-compatible service is not used in this package  
**Execution environment:** Local workstation + GitHub CI only  
**Data:** Fabricated synthetic fixtures only  
**Spend:** None authorized  
**V1:** Strictly off-limits

## 1. Decision requested

The Product Owner is asked to authorize only the bounded work package in this document: **V2 Foundation Package FND-01**.

This request is deliberately not an implementation instruction. No branch for application code, package installation, runtime activation, application code, CI workflow, database, Hostinger change or deployment may be created or performed until the Product Owner explicitly approves the authorization statement in Section 13.

The approval, if granted, applies only to FND-01. It does not authorize M3-02 or any later product feature, production activity or pilot.

## 2. Planning inputs and unresolved prerequisites

| Input | Current disposition | Effect on FND-01 |
|---|---|---|
| P03 solo-founder operating model | Resolved for bounded synthetic/offline work | Product Owner is sole accountable owner; ChatGPT assists. No extra developer is assumed. |
| P04 preferred stack | Owner-approved direction: Laravel 13 / PHP 8.5 / existing Hostinger MySQL-compatible service | FND-01 uses Laravel 13/PHP 8.5 locally and in CI only. Hostinger is not touched. |
| P04 V2 runtime/isolation/capacity/recovery evidence | OPEN | No Hostinger deployment, DB, DNS, account or runtime changes. |
| P05 planning assessment | Owner-accepted / closed as planning deliverable | All legal/privacy/source-rights/safeguarding/security professional gates remain open as applicable. |
| P06 environment/test/release plan | Owner-accepted / closed as planning deliverable | FND-01 implements only the local/CI portion. No deployment or production release. |
| No-new-spend constraint | Binding | Use existing workstation and GitHub capabilities; stop if any paid service or upgrade is required. |
| V1 isolation | Binding prohibition | No V1 access, inspection, credentials, files, database, configuration or operational workflow. |

**Important P04 qualification:** the owner-approved stack direction is not evidence of Hostinger Laravel 13 compatibility. FND-01 can prove a local/CI foundation but cannot close P04's Hostinger-specific compatibility, isolation, capacity or recovery evidence.

## 3. Objective and measurable exit result

Create a reproducible, independently located Laravel 13 application foundation in `mattari20/listing-v2`, with:

1. A PHP 8.5 / Composer 2 local development baseline and committed dependency lockfile.
2. A minimal Laravel application booting locally without any Hostinger or V1 connection.
3. A minimal non-sensitive health endpoint.
4. A documented redacted environment template; no actual secrets committed.
5. Deterministic automated tests for application boot, health response, fail-closed configuration expectations and the initial default-OFF visibility policy seam using fabricated fixtures only.
6. A GitHub Actions CI workflow that runs on pull requests and pushes to the feature branch, using synthetic data and no production secrets.
7. Static/documentation checks, dependency/lifecycle review and an artifact hygiene check.
8. A concise README explaining local setup, test commands, safety boundaries and the fact that no production deployment exists.

The exit artifact is a reviewed, reproducible local/CI build. It is not a public directory, production-ready service, deployable Hostinger release or launch candidate.

## 4. Included scope

### 4.1 Repository and application foundation
- Work only in `mattari20/listing-v2`.
- Create one dedicated feature branch after approval.
- Add the minimal Laravel 13 application scaffold using PHP 8.5 and Composer 2.
- Commit `composer.json` and `composer.lock`; use locked dependency installation in CI.
- Keep application code as a modular-monolith foundation without implementing future business modules.
- Add one minimal health route returning only a fixed non-sensitive status and application identifier/version marker; it must not reveal environment, secrets, database status, filesystem paths, debug data or infrastructure details.
- Add a small policy seam/test fixture that demonstrates Deeni Madaris visibility is false by default. It must not implement public directory search, records or any public data surface.
- Add a redacted `.env.example` with safe placeholders only; ensure real `.env` is ignored.
- Document the approved local commands and boundaries.

### 4.2 CI and tests
- Add a single GitHub Actions workflow for pull requests and pushes to the FND-01 branch.
- Pin third-party actions to reviewed immutable commit SHAs; document their upstream identity and purpose.
- Configure PHP 8.5 and Composer 2.
- Install dependencies from the lockfile only; do not run dependency update.
- Run formatting/lint or equivalent static checks, Laravel configuration/bootstrap validation, unit/feature smoke tests, dependency advisory/lifecycle checks and documentation validation.
- Ensure CI has no Hostinger, production, V1, external source, AI-provider or paid API credentials.
- Verify the workflow does not deploy, migrate, create databases or contact any production host.
- Ensure artifacts and logs do not contain secrets, real personal data or private environment files.

### 4.3 Synthetic fixtures
- Use fabricated values clearly labelled synthetic.
- No real institution names/addresses/contacts or copied V1 data.
- No student, child, user or staff personal data, even pseudonymized.
- No external source snapshots, scraped material, imported datasets or production-like credentials.

## 5. Explicit exclusions — not authorized by FND-01

The following are excluded, even if technically convenient:

- Any access to, inspection of, or change to V1 website, V1 repository, V1 database, V1 hosting files, V1 configuration, V1 deployment, V1 credentials or V1 backups.
- Hostinger login, SSH, hPanel, account setting changes, PHP setting changes, file creation, subdomain/DNS changes, document-root changes, cron jobs, deployment or production commands.
- Creation of a Hostinger V2 database or database user; database schema design, migrations, migration execution or any database writes.
- Real institute records, source research collection, scraping, crawling, downloading, ingestion, republication or source-owner contact.
- Personal data, child data, student accounts, user profiles, staff accounts, identity, authentication workflows, public reviews, user-generated content, uploads, messaging, contact forms, admissions, payments or advertising.
- Public directory browse/search/profile pages, maps, geocoding, analytics, tracking pixels or recommendation systems.
- AI, LLMs, agents, MCP servers, model APIs, embeddings, vector search, external APIs or automated publication.
- Redis, queues, persistent workers, external search engines, container orchestration, paid services, hosting upgrades or new subscriptions.
- Production deployment, preview deployment, pilot, public launch, backups of live state, restore rehearsal, load/capacity testing against Hostinger or real-user testing.
- Any feature from M3-02 onward or any change to the product roadmap, accepted policies or governance invariants.

## 6. Allowed change surface

The implementation PR may add or modify only the following categories:

- Laravel application scaffold files required to boot the application.
- `composer.json` and `composer.lock`.
- Minimal application bootstrap, route and health endpoint files.
- Minimal isolated policy class and synthetic-only tests for default-OFF visibility.
- PHPUnit/Pest test configuration and test files, whichever is selected after checking current Laravel 13 defaults.
- `.env.example`, `.gitignore`, and narrowly required local-development configuration.
- One FND-01 GitHub Actions workflow under `.github/workflows/`.
- README/local setup documentation and one FND-01 implementation record under `docs/05-implementation/`.

No existing governance, roadmap, legal, privacy, source-rights, safeguarding, security, policy or M3 acceptance document may be silently rewritten to make implementation appear authorized. Any necessary documentation correction must be separately identified in the PR.

No database migration file may be created as an application feature. If the framework scaffold supplies unused default migration stubs, do not execute them; remove them if safe and explain the choice in the PR.

## 7. Allowed command classes after approval

Commands are limited to the local repository and approved CI runner:

- Git operations within `mattari20/listing-v2` and its feature branch.
- Read-only inspection of the V2 repository and local PHP/Composer versions.
- PHP 8.5 / Composer 2 application scaffold creation and dependency installation from public package registries, subject to the approved lockfile and no-cost constraint.
- Local PHP/Laravel bootstrap, lint, formatting, unit/feature tests and static/documentation checks.
- Local test-server execution bound to loopback only, if required for smoke testing.
- GitHub Actions execution for the FND-01 workflow.

Prohibited command classes include SSH/SFTP, Hostinger/hPanel operations, database clients, migration/seed commands, network calls to V1 or external source systems, deployment tools, DNS tools, paid APIs and any command requiring production credentials.

The exact concrete commands and resolved dependency versions must be listed in the implementation PR before merge. Do not run a command if its effects are ambiguous or broader than this allowlist.

## 8. Required acceptance tests and evidence

| ID | Acceptance evidence | Pass condition |
|---|---|---|
| FND-01 | Clean checkout + locked install | Reproducible dependency installation succeeds on PHP 8.5 / Composer 2 |
| FND-02 | Application bootstrap | App boots locally without Hostinger/V1/production configuration |
| FND-03 | Health route | Returns minimal fixed response; no secrets, debug details or infrastructure data |
| FND-04 | Environment hygiene | Real `.env`, keys, logs, caches and private files are ignored and absent from tracked artifacts |
| FND-05 | Default-OFF policy seam | Synthetic policy test proves Deeni Madaris visibility is false when unset/default |
| FND-06 | Synthetic-only test data | Fixtures are fabricated and contain no real or copied personal/institute data |
| FND-07 | CI isolation | Workflow has no production/Hostinger/V1 credentials, external data/API access, deployment or migrations |
| FND-08 | CI quality gates | Static checks, tests, dependency checks and documentation checks pass on exact PR head |
| FND-09 | Artifact hygiene | No secrets, real personal data, environment files, logs or private artifacts in repository/build output |
| FND-10 | Diff/scope review | Every changed file fits Section 6; no prohibited feature or scope expansion |
| FND-11 | Documentation | Local setup, test commands, dependency rationale, known limitations and no-deployment status documented |
| FND-12 | Final owner review | Product Owner reviews exact PR diff and CI evidence before merge |

A test for a feature that is not implemented must not be reported as passed. The default-OFF test in this package validates only the policy seam; it does not certify all future browse/search/API/map/export/cache surfaces. Those must be tested before those surfaces are built.

## 9. Human accountability and review

- **Product Owner:** sole human owner; approves the scope, resolves product decisions, reviews the complete PR diff and decides whether to merge.
- **ChatGPT:** implementation and debugging assistant only; not an independent reviewer, legal adviser, security approver or accountable release operator.
- **No additional developer is assumed** for this bounded synthetic foundation.
- No professional legal/privacy/safeguarding/security sign-off is required to create this offline synthetic scaffold, but none is claimed. Those qualified reviews remain mandatory before the later activities identified in P05.
- Any high-impact security or privacy uncertainty is a stop condition, not something the assistant may self-approve.

## 10. Stop conditions and expiry

Stop immediately, do not broaden permissions and report the blocker if:
- Laravel 13 cannot be installed or run on PHP 8.5 / Composer 2 without changing the approved stack.
- Any package requires payment, a new subscription, an unapproved license or a broader service integration.
- Any step requires Hostinger, V1, production, real data, credentials, DNS, a database or deployment access.
- A change could affect V1 or shared hosting configuration.
- Any real personal data, child data, institute source data or secret is encountered.
- CI requires privileged/production credentials or external network/API access beyond package installation.
- A dependency/action cannot be pinned, justified or safely maintained.
- Default-OFF policy behavior cannot be tested deterministically.
- The scope requires a database schema, authentication, user accounts, upload, external API or any excluded feature.
- A critical security/privacy issue, secret exposure or unexpected external activity occurs.

This request expires if the repository baseline changes materially, the approved stack direction changes, the scope needs expansion, or the Product Owner withdraws approval. Re-submit a revised request rather than assuming permission carries forward.

## 11. Delivery and merge protocol

1. Obtain explicit approval under Section 13.
2. Re-check `main` HEAD and open PRs; do not overwrite or restart existing work.
3. Create the single feature branch named in Section 1 from the then-current `main`.
4. Implement only FND-01 and maintain a concise command/change log.
5. Run all required checks locally and in GitHub CI.
6. Open one PR with complete scope summary, changed-file inventory, dependency/action pin rationale, commands executed, test results, exclusions and known limitations.
7. Require **Project documentation validation** and all FND-01 CI checks to pass on the exact PR head.
8. Product Owner reviews the exact diff and evidence; merge only after explicit owner merge approval.
9. Do not deploy, provision a database, run migrations or start M3-02 as part of this package.

## 12. Current decision and progress status

**P05:** owner-accepted planning deliverable; specialist and later operational gates remain open.  
**P06:** owner-accepted planning deliverable; execution and later release gates remain open.  
**P04:** preferred stack direction owner-approved; Hostinger compatibility/isolation/capacity/recovery evidence remains open.  
**P07:** authorization request prepared; Product Owner decision pending.  
**P08:** not complete.  
**M3-01:** not complete; no weighted completion credit claimed from this request alone.  
**M3 overall:** remains 5% until M3-01 is formally accepted and the weighted register is reconciled.

## 13. Explicit Product Owner authorization statement

**No authorization is active unless the Product Owner explicitly submits the approval statement below in a subsequent message. Silence, “move next”, acceptance of P05/P06, or approval of the preferred stack does not authorize implementation.**

To authorize only FND-01, the Product Owner must send:

> I explicitly authorize M3-01 P07 / FND-01 exactly as defined in `docs/04-roadmap/M3-01_P07_NARROW_FOUNDATION_IMPLEMENTATION_AUTHORIZATION_REQUEST_2026-11-13.md` in `mattari20/listing-v2`. I approve the local workstation and GitHub CI scope only, synthetic fixtures only, no new spend, no Hostinger/V1/production access or changes, no database or migrations, no real/source/personal data, no external APIs or AI, no deployment, and no scope expansion. All exclusions, stop conditions, PR review and exact-head CI requirements remain binding.

Any modification to the scope requires a revised request and separate approval.

**Implementation authorization status: NOT ISSUED — awaiting explicit Product Owner approval.**


## FND-01 merge and owner decision — 2026-11-13

The Product Owner issued the exact bounded FND-01 authorization on 2026-11-13. Implementation was delivered in PR [#136](https://github.com/mattari20/listing-v2/pull/136), whose exact head was `d9b8eb8bb04c394d2b08e1a451fcb2d338158662`. The required exact-head checks passed: **FND-01 foundation CI** (run [#43380176340](https://github.com/mattari20/listing-v2/actions/runs/43380176340)) and **Project documentation validation** (run [#43380176524](https://github.com/mattari20/listing-v2/actions/runs/43380176524)). Following the Product Owner's explicit approval, PR #136 was squash-merged into `main` as `f61b4d17492294d45518493337f3fcd58fd78487`; GitHub confirms `main` points to that merge commit and PR #136 is merged.

This records delivery and merge of FND-01 only. It does not claim Hostinger compatibility, V2 runtime isolation, capacity, backup/restore, legal/privacy/source-rights/safeguarding/security sign-off, production readiness or completion of M3-01 as a whole. No Hostinger/V1/production access, database work, migrations, real/source/personal data, external APIs/AI, deployment or new spend occurred. M3-02 and all later implementation remain separately gated and unauthorized.

## Final authorization and execution disposition — 2026-11-13

**Authorization:** ISSUED for FND-01 only, upon receipt of the Product Owner's exact Section 13 statement.  
**Implementation PR:** #136.  
**Exact PR head:** `d9b8eb8bb04c394d2b08e1a451fcb2d338158662`.  
**Required exact-head CI:** passed (FND-01 foundation CI run #43380176340; Project documentation validation run #43380176524).  
**Owner review/merge approval:** received; PR #136 squash-merged.  
**Main merge commit:** `f61b4d17492294d45518493337f3fcd58fd78487`.  
**FND-01 disposition:** delivered and merged.  
**M3-02 / subsequent implementation:** NOT AUTHORIZED by this approval.

This final disposition supersedes the historical pending/not-issued status text above only for the bounded FND-01 package. All exclusions, stop conditions, no-new-spend, no-Hostinger/V1/production, no-database/migrations, synthetic-only, no-external-API/AI and no-deployment restrictions remain binding.
