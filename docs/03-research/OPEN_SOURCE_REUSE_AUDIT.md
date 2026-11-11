# GitHub Open-Source and Dataset Reuse Audit

**Status:** Research plan; no external repository or dataset is approved for integration by this document.

## Objective
Find maintained, secure, compatible open-source components and lawful datasets that can reduce development effort without copying code or data unlawfully.

## Search categories
- Web crawling and scraping frameworks.
- Browser automation and JavaScript rendering.
- Data extraction, validation and schema tooling.
- Entity resolution, deduplication and record linkage.
- Geospatial search, geocoding and mapping.
- Search indexing and ranking.
- Workflow orchestration, queues and scheduling.
- Moderation, identity and anti-abuse components.
- Pakistan-specific education datasets and public registers.
- Global education taxonomies and reference datasets.

## Candidate assessment template
Repository/dataset name; canonical URL; owner; description; license; copyright notices; maintenance/release activity; security advisories; dependencies; language/runtime; architecture fit; community health; data provenance; commercial use; attribution obligations; copyleft/network-copyleft obligations; modification/redistribution obligations; privacy/security concerns; integration cost; decision; reviewer; checked date.

## License policy
Do not assume public visibility means permission to copy. Verify the exact license file and version, repository ownership, subcomponent licenses, dataset license and source terms. Flag AGPL/GPL and other copyleft obligations for legal/architecture review where relevant. Do not remove notices or misrepresent authorship. Prefer dependency reuse over copying source code where appropriate.

## Initial research candidates (unapproved)
- Scrapy — https://github.com/scrapy/scrapy
- Playwright — https://github.com/microsoft/playwright
- Crawlee — https://github.com/apify/crawlee
- Crawl4AI — https://github.com/unclecode/crawl4ai
- Firecrawl — https://github.com/firecrawl/firecrawl

These are discovery candidates only. Their current licenses, versions, maintenance, security posture and fit must be checked at assessment time. A tool's license does not authorize reuse of scraped website content.

## Required outcome
Produce a comparative scorecard and ADR for selected/rejected candidates. Record dataset rights separately from software rights. No dependency or dataset becomes approved merely by appearing in this register.
