# M1-S02 — Balochistan Private-School Registration, GIS Map and BEF Coverage Review

**Review date:** 2026-11-12  
**Scope:** Official 2022 provincial Act, SED GIS/analytics, BEF school list and EMIS sources. No data downloads, scraping, source-owner contact, permission request or implementation.  
**Status:** Research-only except the narrow SED dashboard aggregate license previously documented.

## 1. Current legal registration framework — 2022 Act repeals 2015 Act

The Provincial Assembly of Balochistan published the **Balochistan Private Educational Institutions Registration, Regulation and Promotion Act, 2022 (Act No. XXVIII of 2022)** after passage on 24 September 2022 and Governor assent on 3 October 2022. Section 13 expressly repeals the Balochistan Private Educational Institution Registration and Regulation Authority Act, 2015.

The 2022 Act defines registering authorities by provider type:
- Primary, middle, secondary and higher-secondary schools: Director Education (Schools), Balochistan.
- Intermediate/degree colleges and academies: Director (Colleges), Balochistan.
- Monotechnic/polytechnic institutes, colleges of technology and technical colleges: Director Technical Education, Balochistan.
- Pre-service teacher-training institutions: Director, Bureau of Curriculum and Extension Centre.

The Act requires institutions operating in Balochistan, including those registered under another law, to register under the 2022 Act. It provides district inspection committees, registration certificates, suspension/cancellation and appeal processes. Registration conditions include affiliation with BAEC, BBISE or a Balochistan university commensurate with institution level. A separate inspection committee is defined for Deeni Madaris; do not infer from this alone that all madaris are included in the Act's defined "institution" category or that DGRE registration is replaced.

**Important source conflict:** SED Balochistan's August 2026 legal-framework page still describes the older 2016/2015 BPEIRRA arrangement as housed with BEF. The 2022 Act itself expressly repeals the 2015 Act and names the registering authorities by provider type. Treat the statute as the primary legal text; the SED web summary appears stale or inconsistent and requires legal/departmental confirmation of current implementation and rules.

Sources:
- https://pabalochistan.gov.pk/storage/4280/2022-10-12_11_26_43_bea88.pdf
- https://www.sed.gob.pk/legal-framework.html
- https://www.balochistancode.gob.pk/pdfviewer.aspx?pdffile=a4964e7c-c623-4773-ae4c-1a4e09a143fc.pdf

## 2. SED GIS map — separate public, private, BEF and ALP layers

SED Balochistan's GIS School Map has separate dataset filters for **Schools**, **ALP**, **BEF**, **Private** and potential ALP sites. Its legend identifies magenta pins as registered private schools, teal pins as BEF community/fellowship/foundation-supported schools and red pins as ALP centres. This is the first current official public-facing evidence in this review of a separate private-school map layer in Balochistan.

The map also states:
- 12,980 of 14,709 schools in the map's 30 July 2026 official-list denominator have valid GPS coordinates.
- 1,729 schools without valid GPS are not plotted.
- The map allows search by school name/BEMIS, district, tehsil, level, gender and enrollment.

However, the SED statistics dashboard reports **15,368 public schools** from the same 30 July 2026 SED School List and identifies 14,709 as the previous value. The map's 14,709 denominator therefore appears to be stale/previous or differently scoped, not the current public-school total. The 659 difference (15,368 minus 14,709) must be reconciled. The map exposes a private-school filter but the retrieved public page does not state the private-school count, export format, exact coverage or license for the school-level pins. Do not treat the map as a complete private-school register or infer the number of registered private schools from pin visibility.

Sources:
- https://www.sed.gob.pk/map.html?bef=1
- https://www.sed.gob.pk/data-reports.html
- https://www.sed.gob.pk/

## 3. Balochistan Education Foundation — current community/fellowship school list

SED's BEF Schools page reports a consolidated BEF school list dated **September 2026**:
- **2,795 BEF schools** across 39 districts.
- 2,734 have usable GPS coordinates; 61 are not plotted.
- Programmes: New Community (1,909), New Fellowship (168), Old Community & Fellowship (669), Foundation Supported (49).
- 144,225 reported enrolments, which are not required for institution discovery and should not be stored in the V2 provider directory.

The map's in-view BEF analytics shows 2,734, which is the geolocated subset, while the BEF page reports the full 2,795 school list. This is a known denominator distinction, not a contradiction once GPS coverage is accounted for. BEF schools are a separate public-private/community partnership provider family and should not be collapsed into government schools or private schools registered under the 2022 Act without source-supported legal status.

Source:
- https://www.sed.gob.pk/bef-schools.html

## 4. Rights and access

- SED's scoped open license for dashboard headline metrics/district breakdowns remains limited to those aggregates and attribution/as-of date conditions.
- No explicit reuse license was identified for the GIS private-school pins, underlying BEMIS/DDO school-level records, BEF record-level school list or individual private-school registration records.
- Public map visibility is not permission for automated extraction, republication or commercial reuse.
- Do not collect learner counts, teacher names, staff contacts or student records from the map or BEF source for institution profiles.

## 5. Effect on M1-S02

- **S02-C04:** Balochistan now has a current official GIS source with separate Schools/Private/BEF/ALP layers; private-school record-level count, completeness and license remain unverified.
- **S02-C05:** 2022 Act establishes distinct registering authorities for schools, colleges, technical providers and teacher-training institutions; preserve those provider-specific registration relationships.
- **S02-C06:** BEF community/fellowship/foundation-supported schools are a strong current provider-family source (2,795, September 2026); ALP centres remain a separate NFE layer.
- **S02-C07:** dashboard aggregate reuse remains scoped; map pins and school-level records remain RESEARCH ONLY.
- **S02-C08:** reconcile 15,368 current public schools vs 14,709 map denominator; distinguish 2,795 BEF total vs 2,734 geolocated subset.
- **S02-C09:** remains owner-only.

All school-level records remain RESEARCH ONLY until source-specific rights and access terms are verified.
