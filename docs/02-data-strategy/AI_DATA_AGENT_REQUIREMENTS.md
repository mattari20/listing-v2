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
