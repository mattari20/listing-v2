# M3-00 — Budget and Cost Scenarios

**Status:** Planning framework prepared; numeric budget ceiling and paid-service permission remain unapproved  
**Related task:** M3-00 T04 — Budget and cost ceiling  
**Decision register:** M3-D03  
**Scope:** Documentation and planning only

## 1. Purpose and decision boundary

This document turns the M3-00 cost categories into a controlled comparison framework. It does not set a price, approve a budget, authorize a purchase, start a paid trial, engage a contractor, activate a service or permit implementation.

**Current authorization: no new project spend is approved.** Any paid service, subscription, contract, specialist engagement, procurement or recurring commitment requires a separate explicit owner approval before commitment. A zero-spend authorization state is not the same as an agreed lifetime budget ceiling.

Currency baseline for future estimates: PKR, with the quote date, billing currency, taxes, foreign-exchange assumptions and renewal terms recorded for each quote.

## 2. Cost categories and estimate basis

| Category | One-time cost evidence | Recurring cost evidence | Required assumptions |
|---|---|---|---|
| Development labour / contracting | Scope, role, day/hour rate, delivery estimate | Retainer/support, if any | Named role, hours, deliverables, ownership, tax and contract terms |
| Hosting / compute | Setup, migration or environment setup | Instance, bandwidth/egress, storage, backups, monitoring | Region, workload, availability, scaling, support and tax |
| Database / storage / backups | Initial setup or migration | Database tier, storage, retention, backup and restore | Data volume, growth, retention, recovery objectives |
| Email / SMS / identity | Integration/setup | Message volume, verification, authentication and provider fees | Monthly active users, delivery geography, abuse controls |
| Maps / geocoding / tiles | Integration/setup | Requests, tiles, geocoding and overage | Pakistan coverage, caching terms, limits, attribution and privacy |
| AI / model / API | Evaluation/setup | Tokens, requests, storage, retrieval and support | Workload, data terms, retention, quality gates and hard caps |
| Search / monitoring / security | Setup and integration | Usage, seats, retention, alerting and support | Query volume, log retention, incident coverage |
| Legal / privacy / security review | Initial assessment | Periodic review or retainer | Qualified reviewer, jurisdiction, scope and written quote |
| Contingency / tax / FX | N/A | N/A | Explicit percentage/amount, tax basis and exchange-rate date |

Do not invent or extrapolate vendor prices. Attach dated public pricing or written quotes only when a later research/approval task explicitly permits vendor evaluation. Distinguish estimates, quotes, taxes, foreign-exchange exposure and actual invoices.

## 3. Planning scenarios (not approved budgets)

| Scenario | Planning description | Cost posture | Dependencies / exclusions |
|---|---|---|---|
| A — No-new-spend planning | Continue documentation, architecture decisions and owner reviews using already available capabilities | No new spend authorized; no paid commitments | Does not fund application engineering, hosting, paid APIs, contractors or specialist reviews |
| B — Open-source / low-fixed-cost implementation candidate | Prefer mature open-source components and minimal managed infrastructure where evidence supports it | Costs unknown; requires itemized hosting, operations, backup, security and support estimates | Not a zero-cost claim; requires skills, operational ownership and support evidence |
| C — Managed services / specialist-supported delivery | Consider paid managed hosting, selected APIs and qualified specialist reviews only where justified | Costs unknown; requires dated quotes and an owner-approved cap | No procurement, paid trial, contract or activation authorized |

Scenario A is the only currently permitted planning posture because it requires no new commitment. Scenarios B and C are comparison cases, not approvals or recommendations to purchase.

## 4. Cost calculation rules

For each candidate, calculate:

- One-time total = setup + migration (if separately authorized) + initial review + contingency.
- Monthly recurring total = compute + database/storage/backups + bandwidth + email/SMS/identity + maps/geocoding + AI/API + search/monitoring/security + support.
- Annual recurring total = monthly recurring total × 12, with annual discounts, taxes, FX and renewal changes shown separately.
- First-year total = one-time total + 12 × monthly recurring total + explicit taxes/FX/contingency.
- Unit economics where relevant = cost per verified institution, search session, active user or other agreed workload unit.

All formulas must show the assumptions and source date. Do not compare unlike scopes or omit operations, backup, security, support, taxes or exit costs.

## 5. Mandatory spend controls

1. No new spend is authorized by M3-00 documentation or this framework.
2. No paid evaluation, free-trial activation requiring payment details, contract, subscription, contractor engagement or procurement without separate explicit owner approval.
3. Every proposed commitment must state the one-time cap, recurring cap, billing currency, renewal date, cancellation terms, overage behavior and named owner.
4. Set provider usage limits and alerts before activation where available; do not rely on alerts as a hard spend cap.
5. Prefer exportability and a documented exit path; include termination, data export and migration costs.
6. Any budget approval is limited to its named scope and period; it does not authorize production data access, source reuse, schema changes, deployment or launch.

## 6. Owner decisions and open evidence

| Decision / evidence | Current position |
|---|---|
| One-time setup/development ceiling | Pending owner decision |
| Maximum recurring monthly spend | Pending owner decision |
| Annual ceiling / contingency | Pending owner decision |
| Currency, tax and FX basis | PKR comparison baseline; actual tax/FX assumptions pending dated estimates |
| Paid evaluation services | Not authorized |
| Paid production services | Not authorized |
| Open-source / zero-cost-first preference | Candidate planning principle only; owner confirmation pending |
| Dated provider and specialist quotes | Not collected; procurement/paid outreach not authorized |
| Cost owner and invoice approver | Owner is final decision-maker; named operational invoice owner pending |

The owner has not supplied a numeric ceiling. Do not infer one from the 10–15 hours/week owner availability or from a preference to proceed quickly.

## 7. T04 acceptance criteria

T04 may be submitted for owner review when:

- All cost categories have comparable one-time and recurring estimate fields.
- At least two explicitly scoped scenarios are compared without fabricated prices.
- All unknowns, assumptions, quote dates, taxes and FX exposures are visible.
- The owner records a one-time ceiling, recurring ceiling and paid-service policy, or explicitly defers them and accepts the resulting blockers.
- The spend-control and approval rules are incorporated into the M3 decision register and project controller.

Until these conditions are met, T04 remains **In progress** and M3-00 progress is not increased.

## 8. Explicit non-authorizations

No purchase, paid trial, subscription, contract, hiring, contractor engagement, source access, connector/model activation, production access, application coding, schema/migration, deployment, pilot or launch is authorized.
