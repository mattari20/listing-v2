# M3 Product Owner Security Review Decisions — 2026-11-21

**Repository:** `mattari20/listing-v2`  
**Review:** Product Owner internal security review  
**Status:** OWNER RESPONSES RECORDED — SECURITY ACCEPTANCE NOT GRANTED  
**Scope:** Existing M3 private, synthetic-only repository/development acceptance boundary  
**Decision owner:** Product Owner

## 1. Purpose and evidence boundary

This record captures the Product Owner's answers in the guided M3 security review. It records owner policy decisions only. It is not an independent security assessment, source-code audit, penetration test, environment-isolation assessment, accessibility assessment, or security certification.

The answers do not prove that controls are implemented, tested, effective, or accepted. They do not authorize hosted testing, environment provisioning, production/V1/Hostinger access, deployment, release, pilot, use of real/personal data, or scope expansion. Existing M3 authorizations and stop conditions remain binding.

The independent security assessment under M3-11-03 remains BLOCKED / NOT ACCEPTED pending qualified independent review, exact-candidate evidence, remediation/retest, and Product Owner disposition.

## 2. Recorded Product Owner decisions

| ID | Subject | Product Owner decision | Recorded requirement / boundary |
|---|---|---|---|
| SEC-PO-01 | Account and system access | A | Role-based access control, least privilege, secure authentication, and explicit authorization for sensitive actions. |
| SEC-PO-02 | Authentication by stage | B for current development/testing; A for final live system | Password-only authentication was selected for current development and synthetic testing. For the eventual live system, the owner selected strong passwords, mandatory MFA for privileged accounts, secure password storage, and protection against repeated login attempts. Development remains confined to authorized environments and synthetic data. |
| SEC-PO-03 | Password storage | A | Use Argon2id or another appropriately approved modern password-hashing algorithm, unique salts and appropriate parameters; passwords must not be recoverable by administrators. |
| SEC-PO-04 | Administrative activity logging | A | Record important administrative actions with timestamps and responsible account identifiers, including account, permission, data-change and security events. Do not log passwords, secrets or unnecessary personal information. |
| SEC-PO-05 | Secrets in logs and diagnostics | A | Exclude passwords, authentication tokens, secrets and session identifiers; redact sensitive values in diagnostic evidence. |
| SEC-PO-06 | Network transport | A | Use HTTPS/TLS wherever network communication occurs; do not transmit credentials or sensitive data insecurely. |
| SEC-PO-07 | Authorization default | A — revised and confirmed 2026-11-21 | Server-side deny-by-default: access is denied unless explicitly granted for the relevant role, action and resource scope. UI hiding alone is not authorization. |
| SEC-PO-08 | Dependency management | A | Maintain dependency lockfiles, review dependencies and address known security vulnerabilities before acceptance. |
| SEC-PO-09 | Error handling | A | Present safe user-facing errors; keep protected diagnostic details in restricted logs. Do not expose secrets, internal paths, database details or stack traces to ordinary users. |
| SEC-PO-10 | CSRF and cross-site actions | A | Protect state-changing browser requests using appropriate CSRF protection and secure cookie settings. |
| SEC-PO-11 | File upload security | B | Owner selected allowing common file types without additional validation. This is not accepted as a safe upload control. See conditional applicability and unresolved issue below. |
| SEC-PO-12 | Secrets and configuration | A | Keep secrets outside source control, restrict access, use safe configuration and rotate exposed secrets. |
| SEC-PO-13 | Login abuse protection | A | Apply rate limits, monitoring and appropriate temporary protections against repeated failed login attempts. |
| SEC-PO-14 | Session security | A | Apply secure session handling, including regeneration after login, expiration and invalidation on logout. |
| SEC-PO-15 | Input and output security | A | Validate inputs and use context-appropriate output encoding. |

## 3. Remaining security issue

### 3.1 SEC-PO-11 — File upload validation

The selected Option B does not establish sufficient protection for an upload feature. If the pinned M3 candidate contains any file upload route or upload-capable workflow, allowing common file types without additional validation leaves unresolved risks involving spoofed file types, oversized files, unsafe filenames, executable content, storage exposure and unauthorized access.

**Disposition:** OPEN — CONDITIONAL BLOCKER.

First establish from the exact pinned candidate's route and feature inventory whether file upload capability exists within the M3 acceptance scope. If no such capability exists, record it as not applicable with route-inventory evidence. If it exists, the control must be revised to require, at minimum, server-side type/content and size validation, safe generated filenames, restricted storage and access, and prevention of executable or unsafe content. No upload security pass is inferred from the owner response.

## 4. M3 status and next evidence

- Product Owner internal security responses: RECORDED.
- SEC-PO-07 owner-policy conflict: RESOLVED by the owner's revised Option A decision; implementation conformity still requires evidence.
- Implementation status of each control: NOT ESTABLISHED by this questionnaire.
- SEC-PO-11: OPEN pending applicability evidence and, if applicable, control revision.
- Independent security assessment: NOT PERFORMED.
- Exact candidate pin and independent test evidence: NOT PROVIDED by this record.
- M3-11-03: BLOCKED / NOT ACCEPTED.
- Overall M3: OPEN / PARTIALLY COMPLETE — NOT CLOSED.

The next work is evidence-led reconciliation of SEC-PO-11 and the deny-by-default policy against the current repository implementation and existing test evidence, within the authorized local/repository-only scope. Any code change requires its own bounded implementation scope and CI validation. Independent assurance remains separate and cannot be replaced by this owner review.

## 5. Continuing restrictions

No real student, child, guardian, institute-source or other personal data; synthetic fixtures only. No production/V1/Hostinger/hPanel access, live database, migrations, backup/recovery actions, deployment, public activation, pilot, release candidate, external APIs/AI, new spend, or scope expansion. Public reviews, ratings, comments, reporting and moderation remain OFF during M3. Deeni Madaris remains default-OFF with zero public exposure.

**Final disposition:** This document records Product Owner answers. It does not close any M3 gate or authorize any restricted activity.
