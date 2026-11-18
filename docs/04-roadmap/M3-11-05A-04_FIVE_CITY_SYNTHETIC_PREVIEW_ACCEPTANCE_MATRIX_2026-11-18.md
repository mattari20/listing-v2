# M3-11-05A-04 — Five-city synthetic preview acceptance matrix

**Status:** Implementation delivered for exact-head CI review.  
**Scope:** Synthetic-only feature-test matrix for the existing local preview dataset. No browser or hosted environment activity.

## Coverage

The temporary-SQLite integration test now validates all five fictional profiles, rather than using one representative profile only:

| Fictional institution | Search token | Locality | City |
|---|---|---|---|
| Synthetic Crescent Learning Institute | Crescent | Gulberg | Lahore |
| Synthetic Riverbend College | Riverbend | Gulshan | Karachi |
| Synthetic Frontier Skills Academy | Frontier | University Road | Peshawar |
| Synthetic Makran Science College | Makran | Jinnah Town | Quetta |
| Synthetic Capital Research Institute | Capital | G-10 | Islamabad |

For each profile the test verifies:
- inclusion in the anonymous institution category result set;
- search by its distinct fictional name token;
- manual locality filter match;
- direct profile response with the expected fictional name, city and locality.

All requests execute against the temporary SQLite database that is migrated and seeded by the test and deleted during cleanup. No persistent preview database is created by CI.

## Acceptance limits

This is automated HTTP response coverage for the five synthetic fixtures. It is not browser rendering or visual acceptance, nor proof of nationwide geographic completeness, real-world institution accuracy, hosted isolation, security certification or release readiness. The planned owner visual review remains deferred until the implementation agenda is complete.

No child/student/guardian/staff data, Deeni Madaris records, real institutions or source content, external API/AI, new dependency, paid feature, spend, hosted access, deployment, pilot or release is introduced. M3-11-05 hosted isolation and M3-11-06 recovery remain blocked.
