# M3-07 R2 — Model and Provider Decision Pack

**Prepared:** 2026-11-16  
**Repository:** `mattari20/listing-v2`  
**Work package:** M3-07 R2 — model/provider decision pack  
**Status:** Options assessed; no model/provider selected or approved; agent remains disabled

## 1. Decision summary

M3-07 requires a proposal-only workflow: candidate assertions must be evidence-linked, deterministically validated, and sent to an authorized human for review. A model is not a source of truth and cannot publish material facts.

The current project baseline has:
- no approved model/provider, version, region, account, credential or data-processing terms;
- no approved paid inference or external API spend;
- no owner-approved numeric budget ceiling;
- no qualified source-rights, privacy, security and operational reviewers assigned;
- no approved source/asset manifest for live retrieval.

**Decision:** do not select or activate a hosted model now. Keep the deterministic fake-model adapter as the only permitted CI mechanism. A future offline/local option may be evaluated after stack, hosting, compute capacity, data handling and security evidence is available. External hosted inference remains blocked pending separate explicit approval.

## 2. Options considered

| Option | Benefits | Constraints / risks | R2 disposition |
|---|---|---|---|
| Deterministic fake adapter in local/CI tests | Reproducible, no external data transfer, no inference cost, supports adversarial workflow tests | Does not provide real extraction quality or prove model performance | **APPROVED for synthetic CI only** |
| Deterministic non-AI/manual workflow | No model provider or model-data transfer; can validate source/evidence and human review process | More manual effort; does not satisfy automated extraction objective | Safe fallback while gates remain closed |
| Local/offline model on owner-controlled compute | Potentially avoids external provider transfer; can allow constrained processing | Compute/RAM/storage/latency, model license, provenance, patching, model supply-chain, retention and operational support are unknown; no capacity proof | Candidate for later proof-of-fit only; **not selected** |
| Hosted external model/API | Managed inference and potentially strong extraction capability | Sends approved evidence outside the project boundary; region, retention, training use, subprocessors, DPA, security, cost and vendor lock-in must be assessed; incurs potential spend | **NOT APPROVED** |
| ChatGPT-assisted manual analysis | Useful for planning and synthetic examples without integrating a runtime provider | Not a system integration, not a controlled production service, and must not receive unapproved real/source/personal data | Not a runtime provider option |

## 3. Selection criteria and evidence required

Any future provider/model comparison must use the same synthetic evaluation set and document:

1. Exact provider, model name/version and model-license terms.
2. Processing location/region, subprocessors and cross-border transfer implications.
3. Input/output retention, deletion controls, training-use policy and data-processing terms.
4. Security controls, tenant isolation, authentication, logging, incident notification and credential handling.
5. Supported data formats, context limits, file handling and resistance to malicious content.
6. Field-level extraction precision/recall, unsupported-claim rate and exact evidence-locator accuracy.
7. Entity-resolution false-merge rate and ability to preserve ambiguous alternatives.
8. Human override rate, conflict routing, stale-data handling and refusal/fail-closed behavior.
9. Latency, throughput, retry behavior, availability and operational support.
10. Cost per accepted change, hard usage caps, bounded retries, kill switch and exit strategy.

No quality threshold, price, latency, regional guarantee or provider capability is assumed by this pack. Those must be evidenced for the exact candidate and approved by the owner and qualified reviewers.

## 4. Data boundary

If an implementation is later authorized, model input must be limited to the minimum content permitted by the source-specific manifest and privacy review.

Excluded from this M3-07 workflow:
- student, applicant or child-level records;
- CNIC/B-Form, passport, identity documents or credentials;
- marksheets, attendance, application records or private contact data;
- private staff records, personal health/disability data or private addresses;
- sect/maslak data and inferred religious attributes.

Institution-level public-interest facts are not automatically cleared for model transfer: source rights, privacy classification and provider terms must all permit the exact processing.

## 5. Mandatory runtime architecture if later approved

- Provider adapter isolated behind a narrow interface; no provider SDK calls from domain services.
- Source manifest and permitted asset/field/method checked before any retrieval or model submission.
- Evidence content treated as hostile data; prompt injection cannot change system policy or invoke tools.
- No secrets in prompts, source content, fixtures or ordinary logs.
- Model response is an untrusted proposal with exact evidence locators; missing/unsupported evidence is rejected or held.
- Deterministic validation checks type, scope, jurisdiction, effective dates, applicability and allowed values.
- Ambiguous entity matches retain alternatives and route to human review; no automatic merge.
- Model has no publication capability. Human approval is a separate capability and actor.
- All actions are auditable and reversible through correction, withdrawal, suppression and rollback.
- Hard usage caps, bounded retries, source-specific cadence and an emergency kill switch are mandatory.
- Model/version changes require re-evaluation before use.

## 6. Cost and capacity position

The project constraint remains **no new spend**. There is no approved budget ceiling, and no current evidence proves that the existing hosting plan can safely run a local model. Do not assume Hostinger is suitable or purchase compute, API credits, subscriptions, GPU capacity or additional hosting.

A local/offline proof-of-fit must first document the existing approved compute environment, memory/storage headroom, CPU/GPU availability, expected throughput, isolation, monitoring, patching and failure recovery. If it cannot meet the approved requirements at zero additional spend, keep the agent disabled and continue with manual review.

## 7. Decision matrix

| Decision item | Current decision |
|---|---|
| Deterministic fake adapter | Allowed for synthetic local/CI tests only |
| Production/local model | Not selected; no runtime activation |
| Hosted API provider | Not selected; not authorized |
| Model/version/region | None |
| Source content sent to model | Prohibited until exact source and provider gates pass |
| Credentials/secrets | None provisioned |
| Budget/usage ceiling | Unresolved; no new spend |
| Named reviewers | Not assigned |
| Owner activation decision | Not granted |

## 8. Required approvals before selection or activation

The owner must approve the exact model/provider, version, region, task, environment, data classes, retention/training terms, security controls, evaluation thresholds, hard cost/usage limits, named reviewers and expiry. Qualified privacy/security and operational review must be completed. Source-specific G1-G4 rights/access gates must independently pass before source content can be sent to any model.

A local/offline model is not exempt from license, security, privacy, supply-chain, capacity or owner approval.

## 9. Recommendation

Maintain the current disabled-by-default posture. Continue synthetic-only testing with a deterministic fake adapter. Do not select a provider based on brand reputation or assumed free tiers. Revisit a local/offline candidate only after the unresolved stack/hosting and compute questions are evidenced; consider a hosted API only if the owner separately changes the no-new-spend decision and approves its exact data terms.

## 10. Non-interference

No model was downloaded, installed, called or activated. No provider account, key, connector, scheduler or paid service was created. No source or personal data was sent to a model. No production, V1, Hostinger/hPanel, deployment or spend occurred.
