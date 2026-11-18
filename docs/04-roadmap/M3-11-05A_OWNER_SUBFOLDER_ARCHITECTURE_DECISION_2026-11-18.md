# M3-11-05A — Owner Architecture Decision: Subfolder Deployment Proposal

**Date:** 2026-11-18  
**Package:** M3-11-05 runtime/environment separation  
**Status:** OWNER PREFERENCE RECORDED; TECHNICAL FEASIBILITY AND ISOLATION NOT VERIFIED

## 1. Owner-provided decisions

The Product Owner has supplied the following intended hosting shape:

- Use a V2 application subfolder under the existing hosting/domain structure; do not use a subdomain.
- Create a separate database for V2.
- Keep V2 file storage in a dedicated directory associated with the V2 subfolder.
- Do not publish or link the V2 URL from the public website during private development.

These are recorded as architecture preferences and intended actions. They are not evidence that the hosting plan supports the design, that resources have been created, or that hosted isolation has been achieved.

## 2. Security interpretation and required controls

### 2.1 Unlinked URL is not access control

A URL that is not linked from the public website may still be reachable by anyone who knows or discovers it. It must be treated as potentially public unless an actual access-control mechanism is configured and verified.

Before any hosted acceptance use, choose and verify a suitable control supported by the hosting plan, such as authenticated HTTP access, application-level authentication with deny-by-default authorization, or a hosting-supported network/IP restriction. Do not claim private ingress merely because the URL is unlisted.

### 2.2 Subfolder does not imply runtime isolation

A subfolder can share the parent site's web server, PHP runtime, process identity, filesystem permissions, configuration, deployment path, and domain routing. The design must establish which of these are shared and whether the shared boundary is acceptable. No V1 files, configuration, secrets, writable paths, or deployment actions may be changed as part of this work.

### 2.3 Separate database

A dedicated V2 database and unique V2 database user/credentials are required. The V2 application must not reuse V1/production credentials or connect to V1/production databases. Database host/account ownership and grants must be evidenced with secret values redacted.

### 2.4 Storage directory

A V2-only storage directory is required. Prefer a location outside the web document root if the hosting layout permits it. If the only feasible location is under a web-served subfolder, direct HTTP access must be explicitly denied and verified; sensitive files, logs, sessions, backups, and uploads must not be exposed. Directory naming alone is not protection.

### 2.5 Other state and configuration

The assessment must identify runtime/configuration sharing, environment variables and secrets, sessions, cache, queues, logs, backups, scheduled jobs, mail/notifications, outbound network access, and file permissions. Any shared writable state or reused secret is a stop condition until separately resolved.

## 3. Proposed topology (not yet approved for provisioning)

| Component | Owner preference | Required verification |
|---|---|---|
| URL/application | V2 subfolder; no subdomain | Exact document-root mapping; no V1 rewrite/config changes; reachability controls |
| Database | Separate V2 database to be created | Dedicated database identity/user/grants; unique credentials; no V1 connection |
| File storage | Dedicated V2 directory in/associated with subfolder | Prefer outside web root; otherwise deny direct HTTP access; filesystem permissions |
| Runtime | Existing hosting account is implied, exact boundary unknown | PHP/runtime sharing, process identity, configuration and deployment isolation |
| Access | URL not linked publicly | This is not authentication; verify a real access-control mechanism or treat as public |
| Integrations | None authorized | Mail, SMS, payment, external APIs, AI, webhooks and outbound integrations disabled |
| Data | Synthetic fixtures only | Verify no real or production data; retain existing no-child-data scope |

## 4. Decisions still required before provisioning

1. Confirm exact hosting plan and whether it supports the required subfolder, separate database/user, filesystem permissions, and access-control method without extra spend.
2. Establish exact V2 path and document-root mapping without changing V1.
3. Establish whether storage can be outside the web root; otherwise define and test deny rules.
4. Identify whether V2 can have independent configuration, secrets, sessions, cache, logs and backups under this hosting model.
5. Select a genuine access-control mechanism; an unlisted URL alone is insufficient.
6. Record the exact resource identifiers, human operator/owner responsibilities, time window, stop/rollback method and evidence plan in the authorization register.

No account credentials or secrets should be sent in chat. Any required account inspection must be separately scoped and read-only unless a later explicit authorization says otherwise.

## 5. Current boundary and disposition

- Subfolder architecture: OWNER PREFERENCE RECORDED.
- Separate V2 database: OWNER INTENDS TO CREATE; NOT CREATED OR VERIFIED.
- V2 storage directory: OWNER PREFERENCE RECORDED; NOT CREATED OR VERIFIED.
- URL not linked publicly: RECORDED AS A DISCOVERY-REDUCTION MEASURE ONLY, NOT AS PRIVATE ACCESS CONTROL.
- Hosting plan compatibility: NOT VERIFIED.
- Runtime/filesystem/configuration isolation: NOT VERIFIED.
- Access control/private ingress: NOT VERIFIED.
- Provisioning, hPanel changes, DNS, deployment and hosted tests: NOT PERFORMED OR AUTHORIZED.
- Isolation evidence: remains 0/18 verified until traceable evidence is received and assessed.

**Disposition:** Continue repository-only design and compatibility preparation. Do not provision or deploy. M3-11-05 remains BLOCKED / NOT ACCEPTED pending verified hosting capabilities, exact resource scope, access controls and separate authorization.
