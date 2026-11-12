# Institution, Campus and Programme Requirements

## Institution profile
Candidate fields include official/common names, aliases, sector (government/private/other), institution type, education levels served, operating status, overview, founding details when sourced, contact channels, official website, facilities, accessibility, images with rights, source provenance and verification/freshness metadata.

## Campus model
A multi-campus institution has one institution identity and separate campus records. Address, coordinates, contact details, facilities, offered programmes and admission availability may differ by campus. Do not merge campuses merely because names are similar.

## Programme catalogue
Programme/qualification records should support:
- Name, aliases, level and category.
- Awarding/affiliating authority.
- Duration, subjects/curriculum and delivery mode where evidenced.
- Eligibility, prerequisites and required documents.
- Campus-specific availability and academic session.
- Admission status, opening/closing dates and application method.
- Tuition, admission, examination, laboratory, transport, hostel and other fees where published, with currency, period and effective date.
- Scholarships and financial assistance with eligibility and deadline.
- Career/pathway information, clearly labelled as guidance rather than guaranteed outcomes.

## Data accuracy
Every time-sensitive item (fees, deadlines, programme availability, seats, scholarships) must carry source, observed date, effective period where known and confidence/verification state. Unknown is not zero; unavailable is not unavailable-to-apply; old is not current.

## Recognition and affiliation
Record regulator/board/university, scope, campus/programme coverage, validity dates and evidence. Never infer recognition from an institution name or an unrelated affiliation.


## Deeni Madaris — inclusion and launch visibility requirement

**Owner decision:** Deeni Madaris are part of the underlying V2 institution/provider scope as a distinct category. They will **not be shown in the public listing by default at initial launch**.

### Required configurable behaviour
- Provide a platform-level setting labelled **Show Deeni Madaris**.
- Default value at launch: **OFF**.
- The setting is changed only through an authorized administration/configuration path. The exact screen, roles and implementation are deferred to M2 design.
- When OFF, Deeni Madaris must not appear in public search results, category/browse listings, maps, recommendations, public counts, public sitemaps or public discovery/API responses. The underlying provider records, source provenance and verification history remain retained.
- When ON, eligible Deeni Madaris may appear as a clearly separate category, with their source-backed registration and qualification/awarding relationships shown accurately. Do not merge them into ordinary school/college categories.
- Toggling visibility must not delete records or change a provider's DGRE registration, IBCC QAB relationship, qualification-specific equivalence, or any other regulatory status.
- Do not collect or use sect/maslak as a general discovery, filter, ranking or display attribute.

This is a product requirement and owner decision, not an implementation authorization. The setting's administration UI, roles, audit logging, search-index behaviour and detailed acceptance tests must be finalized during M2 design before coding.
