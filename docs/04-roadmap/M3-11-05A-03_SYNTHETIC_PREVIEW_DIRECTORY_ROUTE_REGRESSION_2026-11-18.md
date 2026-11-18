# M3-11-05A-03 — Synthetic preview directory-route regression

**Status:** Implementation delivered for exact-head CI review.  
**Scope:** Automated HTTP feature tests against the temporary synthetic preview database; no browser launch or visual owner review.

## Purpose

Verify that the five-profile local synthetic dataset is usable through the existing anonymous V2 directory routes, not merely present in database tables.

## Added coverage

The positive local preview integration test now exercises the application after creating and publishing the fixtures in its isolated temporary SQLite database:

- anonymous `GET /directory?q=Crescent&type=institution` returns the fictional Crescent institution and excludes the unrelated Riverbend profile;
- anonymous `GET /directory?locality=Gulberg` returns the Lahore/Gulberg fixture and excludes the Karachi/Gulshan fixture;
- anonymous `GET /directory/{entity-uuid}` returns the fictional profile with its overview and approved Punjab/Lahore/Gulberg facts.

These checks run in the same test that migrates, seeds and validates the temporary database. The database is disconnected and deleted in `finally` cleanup.

## What this proves — and does not prove

This provides repeatable CI evidence for the synthetic fixture-to-public-projection-to-HTTP-route path. It verifies server responses and expected content. It is not a visual/browser review, accessibility audit, performance test, hosted isolation check, legal/privacy assessment or release acceptance. The owner visual preview remains intentionally deferred until the implementation agenda is complete.

No real institution or source content, child/student/guardian/staff data, Deeni Madaris records, external API/AI, new dependency, spend, hosted resource, deployment, pilot or release is introduced. M3-11-05 hosted environment isolation and M3-11-06 backup/recovery remain blocked.
