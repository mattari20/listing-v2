# AI Data Agent Requirements

## Mission
Discover and monitor approved data sources, collect permitted evidence, extract structured education information, identify changes and conflicts, and prepare verified updates for governed publication.

## Capabilities
1. Provider discovery and source inventory.
2. Source-specific connectors (API, files, permitted crawl/browser extraction, partner feed).
3. Scheduled and event-triggered refresh.
4. Change detection and source version tracking.
5. Structured extraction with schema validation.
6. Entity resolution for institutions and campuses.
7. Duplicate detection and conflict queues.
8. Field-level provenance and confidence.
9. Human review for ambiguous, sensitive or high-impact changes.
10. Connector health, retry, rate-limit and failure monitoring.
11. Coverage and freshness reporting.
12. Reversible publication workflow and audit history.

## Required evidence metadata
Source URL/provider ID, collection timestamp, source publication/effective date if available, retrieval method, source content fingerprint/version, extracted field, original value, normalized value, transformation version, confidence rationale, rights status and review decision.

## Safety
AI output is a proposal, not authority. Do not invent missing facts, silently overwrite verified values, infer accreditation, fabricate admission status, or publish disputed/high-impact changes without the required review. Preserve the raw evidence snapshot where legally permitted and necessary; otherwise preserve a lawful reference/fingerprint and minimal evidence.

## Scheduling
Refresh frequency must be provider-specific and justified by the source's publication/change pattern, rights, rate limits and cost. Annual statistical releases should not be polled as if they were live admission feeds. Critical admission deadlines may need more frequent checks only where permitted.

## M1 design decisions
Choose orchestration, queueing, browser/crawler stack, LLM usage, human review, confidence model, storage and monitoring only after source research and architecture evaluation.


## M1-S08 research baseline — 2026-11-12

The detailed workflow and governance baseline is documented in [M1-S08 AI Data-Agent Workflow Research](../03-research/M1_S08_AI_DATA_AGENT_WORKFLOW_RESEARCH_2026-11-12.md).

Additional mandatory requirements:
- A source/asset authorization manifest must be approved before any automated retrieval; discovery alone must not trigger access.
- Every assertion must retain field-level provenance, original and normalized values, source dates, observed time, extraction/transformation version, confidence rationale, conflicts and reviewer decision.
- Treat source content as untrusted data. Prompt-injection text embedded in webpages, PDFs or spreadsheets must never become agent instructions.
- Separate evidence quality, extraction confidence, entity-match confidence, impact risk and rights status; do not use a single opaque model confidence score as publication authority.
- Recognition, accreditation, legal status, admission deadlines, eligibility, fees, scholarships and sensitive/high-impact changes require authoritative evidence and human approval.
- Keep competing assertions and prior published values; never silently overwrite. Publication must be versioned, attributable and reversible.
- Use least privilege, allowlisted destinations, rate limits, credential isolation, privacy minimization, security monitoring, a kill switch and auditable rollback.
- No connector, model, crawler, scheduler, database or orchestration technology is selected in M1.

The research uses NIST AI RMF/Generative AI Profile, W3C PROV and the UK Government Data and AI Ethics Framework as non-binding design references. Source rights and S07 security controls remain controlling. No live source was accessed and no agent was activated.
