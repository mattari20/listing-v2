# M3-11-05A-02 — Local preview fixture integrity hardening

**Status:** Implementation delivered for exact-head CI review.  
**Scope:** Synthetic-only automated local/CI verification of the already approved M3-11-05A preview fixture. This does not run the browser preview or close hosted M3-11-05/M3-11-06.

## Work completed

The local preview seeder now wraps creation of all five institution entities, claims, evidence, adjudication decisions and publication projections in one database transaction. If any fixture or publication step fails, the database transaction rolls back the complete dataset instead of leaving a partially populated preview.

The feature test now covers both sides of the safety boundary:

- The seeder refuses the PHPUnit/testing environment before attempting fixture writes.
- A positive integration test creates a uniquely named temporary directory and a file named exactly `.local-preview.sqlite` inside the operating system temporary directory, migrates only that temporary SQLite file, invokes the explicit seeder with the local-only guard enabled, and checks the resulting synthetic publication state.

The positive test verifies:
- exactly five marked fictional institution entities;
- 30 claims and 30 publication snapshots from the six fictional facts per institution;
- 30 anonymous public projections, all with `is_deeni_madaris=false`;
- no Deeni Madaris projection;
- no child, student, guardian, staff, age, date-of-birth, consent or student-status predicates.

The test disconnects the temporary database and removes its database file and temporary directory in a `finally` block. It does not use the user's local preview database, Hostinger, V1, production, a remote database or any persistent hosted resource.

## Execution boundary

This is automated integration evidence only. It does not create an environment, set recovery objectives, take a backup, rehearse restore/rollback, or establish hosted isolation. The five preview profiles remain fictional test fixtures, not real-world institution listings. No real data, child/student/guardian/staff data, external source material, Deeni Madaris records, external API/AI, new dependency, paid feature or spend is introduced.

## Acceptance and remaining work

Exact-head FND-01 PHP 8.5 CI and project documentation validation must pass before merge. After merge, M3-11-05A fixture integrity hardening is complete for repository-only synthetic CI. Browser preview and visual owner review remain intentionally deferred until the planned implementation agendas are complete.

M3-11-05 hosted isolation remains blocked with no identified or authorized environment and 0/18 hosted isolation evidence items. M3-11-06 recovery remains blocked: no backup/restore rehearsal, no measured RPO/RTO and no accepted recovery ownership. No release candidate, go/no-go, deployment or production execution is authorized.
