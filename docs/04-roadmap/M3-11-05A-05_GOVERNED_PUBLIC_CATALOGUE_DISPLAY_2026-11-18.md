# M3-11-05A-05 — Governed public campus, programme and offer display

**Status:** Implementation submitted for exact-head CI review.  
**Scope:** Synthetic-only implementation and automated tests for the private V2 directory code. This does not activate a public or hosted directory.

## Delivered in this change

- Institution profiles can display active campus records, published programme records, and published admission offers.
- Catalogue records are included only when the exact linked claim version has a current approved anonymous-directory projection.
- The publication check retains the existing controls for accepted/current claim versions, latest snapshots, active suppressions, source-authorization scope and validity, evidence eligibility, and the explicit is_deeni_madaris = false projection flag.
- Campus, programme and offer table values are checked against the corresponding approved projection payload before display. A mismatched catalogue row fails closed.
- Programme offers are displayed only when the programme and linked campus also have current eligible public profiles. Offers tied to a location without a public campus profile remain withheld.
- Views receive only display labels, public names, admission-cycle text and location names; internal IDs, evidence references, raw claim payloads and query-permission flags are not passed to the template.
- Existing directory search, profile allowlisting, suppression, and Deeni Madaris default-OFF behavior remain in force.

## Synthetic regression coverage

The public-directory feature test creates fictional institution, campus and programme records and verifies:
- a current published campus is displayed;
- a current published programme is displayed;
- a current published offer and its campus location are displayed;
- a suppressed offer is omitted;
- a catalogue row whose admission cycle differs from its approved claim payload is omitted.

Existing catalogue materialization tests remain the separate contract for accepted-claim materialization, human adjudication, source evidence, idempotency and rollback.

## Explicit limitations

- No real institution, provider, source or student data is used.
- Delivery-site-only offers remain withheld; this change does not add a public delivery-site category.
- This is automated feature-test evidence, not browser visual acceptance, owner visual acceptance, manual accessibility testing, hosted isolation evidence, security certification, legal/privacy approval, or release acceptance.
- No schema/migration, dependency, route, hosting, production, V1, Hostinger, deployment, public activation, pilot, external API/AI, paid feature or additional spend is included.
- M3-11-05 hosted isolation, M3-11-06 recovery and M3-11-07 release-candidate readiness remain blocked and require their separate gates and authorizations.
