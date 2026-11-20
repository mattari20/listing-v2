# M3-11 — Public Development Repository Visibility Clarification

**Decision date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Decision owner:** Product Owner  
**Status:** BINDING PRODUCT OWNER DECISION RECORDED — FUTURE TRANSITION PENDING DEVELOPMENT COMPLETION

## 1. Owner decision

The Product Owner fixes the GitHub source-repository visibility lifecycle as a binding baseline decision:

- **During development:** the `mattari20/listing-v2` source repository remains PUBLIC.
- **After development is complete:** the repository WILL be changed to PRIVATE when development is complete. This is already decided; no second approval of the visibility choice is required.

The repository was verified as public on `main` at commit `2fe4831327043c0fba8c375fe4f3bfaeeb64a2a1` when this clarification was prepared.

## 2. Separation from product and runtime scope

Public GitHub source visibility is not the same as public access to the Listing V2 application.

This decision does not change or authorize:
- a public application launch, public pilot, release candidate or production operation;
- provisioning or access to any hosted/acceptance environment;
- V1, Hostinger, hPanel, production or live database access;
- real personal, student, child, guardian, staff, institute or source data;
- source contact, access, collection, copying, scraping, crawling, ingestion or publication;
- external APIs, AI/model/provider integrations, connectors or live agents;
- participant activity, public submissions, reviews, ratings, moderation or appeals;
- new dependencies, paid services, hosting upgrades or additional spending.

The existing restricted/private acceptance-environment boundary and all M3-11 gates remain unchanged.

## 3. Public-repository safeguards

While the repository is public:
- do not commit credentials, passwords, tokens, private keys, secrets or environment files;
- do not commit real personal records, private contact details, identity documents or confidential legal/reviewer materials;
- keep reviewer reports and confidential evidence outside the public repository in an agreed restricted channel;
- review proposed public commits and CI output for accidental disclosure;
- if a secret or confidential item is exposed, stop and follow the appropriate incident/credential-rotation process rather than assuming that deleting the latest file removes prior exposure.

## 4. Future transition to private

The transition to private is a mandatory future development-completion action. It must not be performed before development is complete. At completion, record that the development-completion condition has been met, review repository history, forks/copies, public artifacts, workflow logs and any prior exposure, and then execute and verify the visibility change. No second Product Owner approval of the public-to-private decision is required. Changing repository visibility must not be represented as proof that previously accessible copies or data have been erased.

## 5. Effect on existing records

This clarification supersedes only statements that characterize the GitHub source repository itself as private. It does not supersede:
- the restricted/private V2 acceptance-environment target;
- the current synthetic/fictional-only development and acceptance restrictions;
- any exclusion, stop condition, independent-review requirement or M3-11 gate;
- the LPS-29 requirement for a qualified independent assessment and separate Product Owner disposition.

The reviewer must be told that the development source repository is public and must assess that actual fact. This owner clarification is not a legal/privacy/security certification and does not close Gate 02.
