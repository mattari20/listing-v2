# M3-11 — Stage 1 Repository Review Baseline and Evidence Index

**Prepared:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Immutable review baseline:** `f1f9d779fa280e1c0a57618c301a535aad635a85`  
**Branch:** `main` at the time this index was prepared  
**Status:** REVIEW MATERIAL INDEX ONLY — NO INDEPENDENT REVIEW PERFORMED; M3-11-02 / M3-11-03 REMAIN BLOCKED WHERE INDEPENDENT ASSESSMENT IS REQUIRED.

## 1. Purpose

This index makes the existing Stage 1 repository/source review material easier to hand to qualified independent reviewers. Stage 1 is a source/design review against the immutable commit above. It is not an assessment, certification, approval, penetration test, accessibility audit, legal opinion or authorization to access a hosted environment.

The review baseline is the exact commit `f1f9d779fa280e1c0a57618c301a535aad635a85`. Reviewers must use that commit rather than silently substituting a later `main` head. If they review a later commit, they must identify it and explain the changed scope.

## 2. Existing review packs and response templates

- [M3-11-02 Legal, Privacy and Safeguarding Review Pack](M3-11-02_LEGAL_PRIVACY_SAFEGUARDING_REVIEW_PACK_2026-11-17.md)
- [M3-11-02 Reviewer Response and Owner Disposition Template](M3-11-02_REVIEWER_RESPONSE_TEMPLATE_2026-11-17.md)
- [M3-11-02 Child Safeguarding and Sensitive-Data Review](M3-11-02_CHILD_SAFEGUARDING_SENSITIVE_DATA_REVIEW_2026-11-18.md)
- [M3-11-02 Owner Internal Data Privacy Review](M3-11-02_OWNER_INTERNAL_DATA_PRIVACY_REVIEW_2026-11-18.md)
- [M3-11-03 Independent Security and Accessibility Review Pack](M3-11-03_INDEPENDENT_SECURITY_ACCESSIBILITY_REVIEW_PACK_2026-11-17.md)
- [M3-11-03 Independent Reviewer Response Template](M3-11-03_REVIEWER_RESPONSE_TEMPLATE_2026-11-17.md)
- [M3-11-03 Product Owner Internal Security and Accessibility Desk Review](M3-11-03_PRODUCT_OWNER_INTERNAL_SECURITY_ACCESSIBILITY_DESK_REVIEW_2026-11-18.md)
- [M3-11 Gate Resolution Coordination Plan](M3-11_GATE_RESOLUTION_COORDINATION_PLAN_2026-11-17.md)
- [M3-11 Owner Decisions and Evidence Intake](M3-11_OWNER_DECISIONS_AND_EVIDENCE_INTAKE_2026-11-17.md)

These documents are already present in the pinned repository baseline. This index does not replace them or imply that a reviewer has been selected.

## 3. Source review entry points

Reviewers should inspect the complete tree at the pinned commit and follow the application data flows, not rely on this short list as exhaustive.

| Area | Repository entry point | Review focus |
|---|---|---|
| HTTP entry and routes | `routes/`, `public/`, `app/Http/` | Reachable surfaces, middleware, authorization, request handling and default-deny behavior |
| Domain and publication | `app/Models/`, `app/Services/`, `app/Policies/` | Evidence provenance, adjudication, publication, suppression, freshness and public projection |
| Identity and sessions | `app/Http/Middleware/`, `config/session.php`, `config/auth.php` | Session boundaries, authentication assumptions, cookie configuration and access control |
| Data persistence | `database/migrations/`, `database/seeders/` | Data minimization, schema exposure, retention/deletion behavior and synthetic-only fixtures |
| Views and client assets | `resources/views/`, `resources/lang/`, `resources/css/`, `resources/js/` | Public output allowlists, language/RTL, keyboard/focus behavior and unintended disclosure |
| Runtime/configuration | `config/`, `bootstrap/`, `composer.json`, `composer.lock` | Secure defaults, environment dependence, dependencies and configuration assumptions |
| Automated evidence | `tests/`, `.github/workflows/` | What tests actually prove, gaps, false confidence and workflow provenance |
| Project controls | `docs/04-roadmap/M3-11-*`, `docs/04-roadmap/M3-10-*` | Scope, approvals, unresolved gates, operational assumptions and prohibited activity |

The source tree may contain files beyond these entry points. Reviewers must record the actual files, routes, configurations, dependencies and tests examined, and must state any omissions.

## 4. Required Stage 1 reviewer record

Each reviewer/workstream must provide a dated response using the relevant existing template and identify:

1. Reviewer identity, professional competence/qualification, organization and independence/conflict declaration.
2. Exact baseline commit `f1f9d779fa280e1c0a57618c301a535aad635a85`, documents and source files examined.
3. Method, tools, scope, assumptions, limitations and exclusions.
4. Findings with severity, evidence, affected component and required remediation.
5. Conditions before any future private acceptance environment provisioning or reviewer access.
6. Required retest/verification and what would invalidate the assessment.
7. Explicit outcome: approve, approve with conditions, do not approve, or unable to conclude.
8. Separate Product Owner disposition for each finding, including owner, due date and closure evidence.

Keep privileged legal advice, personal contact details, credentials, secrets and exploit-sensitive details outside the repository and ordinary chat. Record only a non-sensitive evidence reference and disposition here.

## 5. Stage 1 scope and stop conditions

The bounded intended scope remains existing anonymous directory browse/search/category/profile and manual text-locality discovery, with synthetic/fictional fixtures only. No participant activity, real institution/provider/student/guardian/staff/source data, public audience, public UGC, public Deeni Madaris exposure, live source ingestion, external API/AI/provider, new vendor/dependency/spend, V1 or production access is in scope.

A reviewer must stop and record a blocker if the pinned source behavior, available evidence or requested test would require any prohibited access or activity. This index does not authorize active testing against a hosted target, environment provisioning, Hostinger/hPanel, live databases, backups/restores, deployment, DNS/URL cutover, candidate creation or public launch.

## 6. Current gate disposition

- M3-11-02: review pack and internal owner review exist; qualified independent legal/privacy/safeguarding assessments and Product Owner dispositions remain outstanding where applicable.
- M3-11-03: internal repository desk review exists; independent security and qualified accessibility assessments remain outstanding for the future hosted/release scope. Manual accessibility checks and WCAG conformance are not claimed.
- M3-11-04: single-owner model is accepted only for private repository-only synthetic development; hosted/release operational roles remain deferred.
- M3-11-05/06: environment isolation and recovery remain blocked; this Stage 1 index does not advance either gate.
- M3-11-07/08: no release candidate or go/no-go decision is authorized.
- M3-11-09: production execution is not authorized.

**Final disposition:** Stage 1 source-review materials are indexed for handoff against an immutable repository baseline. No independent review has been performed by this record. M3-11 remains BLOCKED / NOT ACCEPTED.
