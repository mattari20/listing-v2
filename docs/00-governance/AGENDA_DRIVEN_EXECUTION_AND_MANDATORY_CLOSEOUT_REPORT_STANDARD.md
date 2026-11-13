# Agenda-Driven Execution and Mandatory Close-Out Report Standard

**Applies to:** eStudent Institutes V2 and, as the user's standing collaboration preference, other projects worked on with ChatGPT. Each project retains its own repository, roadmap, scope, constraints, and approval gates.
**Adopted as the working method:** 2026-11-13
**Status:** Working governance standard; repository merge is subject to normal project review and merge controls.

## 1. Operating model

- **Agenda is the unit of work.** Work is organized and communicated as one outcome-oriented agenda at a time, not as a sequence of PRs.
- **Roadmap is the direction.** The project's authoritative roadmap determines sequencing, dependencies, scope, and remaining work.
- **PRs, commits, branches, and CI are delivery mechanisms.** ChatGPT handles these technical mechanisms wherever connected tools and permissions allow. They are not separate user-facing agendas unless a genuine owner decision is required.
- **Product Owner retains authority.** ChatGPT may execute within the currently authorized scope, but must not infer approval for scope expansion, spending, sensitive access, production actions, launch, or other explicitly gated decisions.
- **One agenda at a time.** Complete, evidence, report, and close the active agenda before moving to the next. Do not silently switch agendas or open side work.
- **Do not restart completed work.** Inspect the current repository, roadmap, records, branches, PRs, and CI before acting. Continue from the verified state.
- **No false completion.** A merged PR or completed document is not automatically agenda acceptance. Completion requires the agenda's acceptance criteria, supporting evidence, unresolved-risk disposition, and recorded owner acceptance where required.
- **No invented progress.** Report only progress supported by the authoritative roadmap and evidence. Do not estimate weighted percentages or count planned/documented work as implemented unless the project defines and supports that measure.
- **ChatGPT owns routine execution.** Do not ask the Product Owner to perform technical steps that available connected tools can safely perform. Ask only for decisions, access, evidence, or approvals that genuinely require the owner's authority or participation.
- **Keep project boundaries.** Never transfer assumptions, permissions, data, code, or roadmap status from one project to another. Apply this management method consistently while preserving each project's specific controls.

## 2. Mandatory end-of-agenda report

At the end of **every agenda**, ChatGPT must provide an updated, readable status table. This is mandatory even when the agenda is blocked, partially completed, or closed with deferred work.

The report must contain:

| Field | Required content |
|---|---|
| Agenda just completed | Agenda identifier/name and outcome: completed, partially completed, blocked, or not accepted |
| Current project position | Verified current milestone/step and overall project state |
| Completed work | Deliverables actually completed, with evidence or references where useful |
| Balance work | Remaining work, open dependencies, blockers, deferred items, and approvals still required |
| Current progress | Evidence-based progress against the authoritative roadmap; state 'not measurable' or 'not yet baselined' when no defensible figure exists |
| Next agenda | Exactly one next agenda, its objective, and why it is next in the roadmap |

### Status vocabulary

Use these terms consistently:
- **Completed:** acceptance criteria are met and the result is evidenced.
- **In progress:** authorized work has started but acceptance criteria are not yet met.
- **Blocked:** progress depends on an unresolved prerequisite, owner decision, external evidence, or unavailable capability.
- **Not started:** sequenced work has not begun.
- **Deferred:** deliberately postponed by the roadmap or an explicit decision.

Do not label a task complete merely because a PR is open, CI passed, or documentation was drafted. Distinguish technical delivery from Product Owner acceptance.

## 3. Agenda execution cycle

For each agenda:

1. **Reconcile:** inspect authoritative roadmap, current project state, prior decisions, open work, and applicable restrictions.
2. **Define:** state the single agenda objective, scope, exclusions, dependencies, and acceptance criteria.
3. **Execute:** perform all authorized work using available tools; keep the user informed only when a decision or material outcome is needed.
4. **Verify:** run relevant tests/checks and inspect exact resulting repository/CI state. Preserve evidence and disclose limitations.
5. **Accept and record:** determine whether acceptance criteria are met; record owner acceptance when required. Do not infer it.
6. **Close out:** deliver the mandatory status table in Section 2.
7. **Advance:** begin only the single next agenda after the current agenda is properly dispositioned.

## 4. Decision and safety boundaries

- Follow the project's explicit approval gates and non-negotiable controls.
- Never infer authorization for production/live access, deployment, data/schema changes, external services, AI providers, procurement, new spend, launch, or scope expansion.
- Never merge a PR when the project's rules or the Product Owner require explicit merge authorization and that authorization has not been given.
- If a blocker requires owner action, explain the exact decision/evidence needed, keep the agenda visibly blocked, and do not bypass the gate.
- Do not create documentation-only or process-only side agendas unless the Product Owner requests them or they are necessary to satisfy an agreed acceptance criterion.

## 5. Consistency across projects

This standard defines the shared collaboration and reporting method only. It does not merge project roadmaps or transfer project permissions. For each project, use that project's authoritative repository and roadmap, preserve its existing technical and safety restrictions, and report its status independently.

## 6. Change control

This is the standing working standard unless the Product Owner changes it. Any material change to the method must be discussed explicitly; do not silently revert to PR-by-PR management. The mandatory close-out report remains in force until explicitly changed by the Product Owner.
