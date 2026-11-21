# ADM-E-G04 — Reviewer-Safe Evidence and Correction History Closeout

**Date:** 2026-11-21  
**Status:** **COMPLETE — MERGED, SYNTHETIC REPOSITORY WORKSPACE**  
**Implementation PR:** [#431](https://github.com/mattari20/listing-v2/pull/431)  
**Merge commit:** `bf972ff1a67122f89577a93fbd2281e07f1574b0`  
**Final tested head:** `96d872944e986efd46a58e22b484e413a37b207c`

## Delivered

### Explicit authorization-window state

The reviewer evidence projection now computes and returns an explicit authorization-window classification at request time:

- `current`: approved, unrevoked and within a bounded validity interval.
- `expired`: current time is at or after the validity end.
- `not_yet_valid`: current time is before the validity start.
- `revoked`: a revocation timestamp exists.
- `not_approved`: authorization status is not the approved status.
- `unbounded`: either validity boundary is absent.
- `invalid_window`: dates cannot be parsed or the end is not later than the start.

The reviewer page displays the classification in English and Urdu alongside the status, revocation indicator and validity dates. This is a read-only explanation; it does not change evidence status or automatically quarantine a reference. The G01 decision-time guard remains responsible for failing closed before acceptance.

### Correction-history minimization

The correction-history projection remains bounded to ten predecessor versions with cycle protection. It now includes only:
- Immutable version number and disposition.
- Linked predecessor case status and timestamp.
- The prior review's reason code for a `changes_requested` outcome.
- The immutable correction reason code.

It deliberately does not expose free-text review rationale, arbitrary history metadata, private actor IDs or raw audit payloads.

### Evidence privacy boundary retained

The workspace continues to omit evidence digests, evidence content/files, source URLs, authorization purpose/method/scope payloads, revocation reasons, private actor IDs and arbitrary audit metadata. It exposes only the bounded evidence-reference metadata needed for reviewer triage.

## Synthetic regression coverage

Added coverage for:
- Current, expired, not-yet-valid, revoked, not-approved, unbounded and invalid validity windows.
- Explicit rendered labels for all authorization states.
- Safe reason-code visibility in correction history.
- No free-text rationale or arbitrary audit metadata leakage.
- No evidence digest, authorization scope, purpose, method, revocation reason or private actor identifier leakage.
- Existing submitter/evidence-contributor exclusion and private no-store/noindex response protections.

## Validation

On exact head `96d872944e986efd46a58e22b484e413a37b207c`:
- PHP 8.5 Foundation CI: **success**.
- Project documentation validation: **success**.
- PHP formatting and Laravel route validation: **success**.
- Synthetic-only suite: **23 passed, 1,890 assertions, 320 warnings**.
- Repository artifact hygiene: **success**.

Warnings remain outstanding and are not treated as resolved.

## Limitations and exclusions

The authorization classification is computed when the reviewer opens the page; this agenda does not add a background monitoring or automatic evidence-quarantine service. Evidence content and source material remain unavailable in the workspace. No reviewer staffing, human tabletop, qualified legal/privacy/security/accessibility assessment or operational readiness acceptance is implied.

No new route, role, capability, schema, migration, real/source/personal data, V1/Hostinger/production/hosted access, external API/AI, deployment, pilot, release, new dependency or spend was introduced. Adjudication and publication remain separately governed and are not exposed in the reviewer workspace.

**ADM-E-G04: CLOSED for reviewer-safe evidence-state and correction-history behavior in the synthetic repository scope. ADM-E: COMPLETE for the bounded repository/synthetic administration integration agenda.** This does not close M3-11 or establish operational readiness. M3-11 remains BLOCKED / NOT ACCEPTED and overall M3 remains OPEN / PARTIALLY COMPLETE — NOT CLOSED.
