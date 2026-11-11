# Student Discovery Requirements

**Status:** Initial product requirements baseline; detailed acceptance criteria and UX design are M1 work.

## Nearby discovery
- Search using user-granted location or manually selected city/area.
- Radius and distance filters; map and list views.
- Filters for education level, government/private, institution type, programme, gender policy where institution publishes it, facilities and admission status where current evidence exists.
- Sort by distance, relevance and transparent user-selected criteria.
- Support region/city/locality search when location permission is denied.
- Never require location permission to use the directory.

## Search quality
- Search institution, campus, programme, qualification, subject and locality.
- Handle spelling variants, abbreviations and Urdu/English names as design goals.
- Show useful empty states and alternatives.
- Distinguish exact matches from approximate or AI-suggested matches.

## Maps and distance
- Store source-backed coordinates and geocoding provenance.
- Clearly label approximate locations.
- Do not infer a precise campus entrance from a town centroid.
- Distance calculation method and route provider are architecture decisions.

## Student utility
- Save/shortlist institutions and programmes.
- Share result links.
- Compare selected institutions.
- Show last updated, source and verification status on material facts.
- Provide correction/report-information flow.

## Acceptance themes
M1 must define measurable search relevance, filter correctness, location consent, accessibility, mobile performance, freshness display, and test cases for all education levels and administrative regions.
