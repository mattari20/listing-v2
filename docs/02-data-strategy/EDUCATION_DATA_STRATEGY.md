# Education Data Strategy

## Objective
Build a national, multi-source catalogue of educational institutions, campuses, programmes and admission information, initially for Pakistan, with recurring refresh and auditable evidence.

## Coverage dimensions
- Geography: Punjab, Sindh, Khyber Pakhtunkhwa, Balochistan, Islamabad Capital Territory, Azad Jammu and Kashmir, Gilgit-Baltistan.
- Sector: government/public, private and other clearly classified providers.
- Levels/types: early childhood, primary, middle, secondary, higher secondary, colleges, universities/campuses, technical/vocational, teacher training, special education, non-formal/adult learning, madaris and other relevant recognized categories.
- Provider authority: federal/provincial/regional departments, regulators, boards, accreditation bodies, institution websites, authorized associations and licensed/open datasets.

## Source hierarchy (proposed)
1. Official regulator or responsible government authority.
2. Official institution/campus publication.
3. Authorized data partner or clearly licensed dataset.
4. Reputable secondary source for discovery or corroboration.
5. Community-submitted correction, pending verification.

The hierarchy is a starting policy; source reliability is field-specific and must be documented.

## Collection methods
Prefer official APIs, open data downloads and written data partnerships. Permitted crawling or browser extraction may be used only after reviewing terms, robots/access rules, copyright/database rights, privacy, rate limits and technical restrictions. Respect authentication and access controls; do not bypass CAPTCHAs or anti-bot measures.

## Lifecycle
Discover provider → rights review → connector specification → collect immutable source evidence → parse/normalize → match institution/campus → detect duplicates/conflicts → validate → human review where required → publish eligible fields → schedule refresh → monitor failures and staleness.

## Coverage integrity
Publish coverage metrics by region, level, sector and source. Clearly distinguish a complete authoritative register from partial coverage, estimates, samples and unverified discovery candidates. Missing data must remain missing, not be fabricated.
