# M3-03 Agenda 2 — Logical Model Review and Governance Decision Record

**Project:** eStudent Institutes V2  
**Repository:** `mattari20/listing-v2`  
**Agenda:** M3-03 Agenda 2 — Logical Model Review and Governance Decision Closure  
**Review baseline:** main at the Agenda 1 delivery baseline containing PR #151 and PR #152  
**Review mode:** repository-document review only; synthetic fixtures and accepted M1/M2 documents; no application execution  
**Disposition:** Review completed; design baseline acceptance is **pending Product Owner decision**  
**Scope boundary:** no schema, migrations, persistence, application code, real/source/personal data, source acquisition, external services/AI, hosting, deployment or spend

## 1. Executive result

The Agenda 1 model is directionally consistent with the accepted M1/M2 architecture. Its strongest controls are the separation of entity identity from claims, evidence from truth, validation from human adjudication, claim acceptance from publication approval, and internal records from public projection. Temporal validity, immutable claim history, source-specific authorization, privacy minimization, and Deeni Madaris default-OFF are explicit.

The review did **not** find a reason to discard or restart the model. It did identify several ambiguities that should be resolved before treating the model as a stable design baseline for later physical design. The current 24 test vectors are useful design oracles but do not cover every material invariant.

**Recommendation:** retain the model as the working logical baseline, make the clarifications below, then record explicit Product Owner acceptance. This recommendation is not itself owner acceptance and grants no implementation authority.

## 2. Review findings

| ID | Finding | Evidence / impact | Recommended disposition |
|---|---|---|---|
| R-01 | Provider–Institution cardinality wording is internally inconsistent | The glossary says Provider 1 to 0..N Institutions, while also allowing an Institution to have 0..N provider relationships over time. These statements imply different minimum cardinalities and do not clearly express the relationship as a time-bounded association. | Define Provider–Institution as a typed, time-bounded relationship; state whether an institution may exist without a provider relationship and whether multiple concurrent providers are permitted. |
| R-02 | Claim status vocabulary is not fully normalized | The claim status list includes proposed, needs_evidence, under_review, accepted, rejected, disputed, stale and withdrawn; the lifecycle also uses deferred, while the temporal/version rules refer to superseded. Implementers could encode these as competing states or conflate lifecycle with events. | Separate current disposition/status from immutable lifecycle events and version relationships. Publish one canonical enum/state-transition table including deferred, superseded and withdrawn semantics. |
| R-03 | Identity resolution and ambiguous-merge governance is only referenced, not specified | The traceability refinement says identity candidates and ambiguous merges require human review, but no dedicated concept, candidate lifecycle, merge/split event or rollback rule is defined in the glossary. | Add a logical identity-candidate/match decision concept or explicitly defer it to a named later agenda; prohibit automated merge and preserve reversible merge/split lineage. |
| R-04 | Authority relationship types need a canonical controlled vocabulary | The model correctly distinguishes awarding body, regulator, recognizing authority and affiliation, but the examples and traceability text do not provide a complete vocabulary or define whether recognition, accreditation, licensing, examination and affiliation are distinct predicates with scope/effective dates. | Define the minimum relationship vocabulary and scope semantics, or record a deliberate deferral with a no-inference rule. |
| R-05 | Source authorization revocation semantics need an explicit downstream rule | Authorization is scoped and revocable, and validation rejects revoked/out-of-scope evidence. The model does not fully state how revocation affects already accepted claims, current publication snapshots, cached projections, retention and audit lineage. | Specify immediate quarantine/revalidation and publication review behavior; distinguish authorization to acquire, retain, process, reuse and publish; preserve only legally/operationally permitted audit lineage. |
| R-06 | Separation-of-duties is principle-based, not yet a role/permission matrix | The model names collector and editorial roles and says publication approval is separate, but does not define minimum role capabilities, incompatible combinations, emergency suppression authority or independent review thresholds. | Keep detailed roles as a later governance gate, but state the minimum separation invariant and require a role/permission matrix before any real workflow or public release. |
| R-07 | Test vectors leave material edge cases uncovered | Existing tests cover 24 core cases. Missing explicit oracles include expired authorization, purpose/method/territory mismatch, authorization revocation after publication, restricted category with missing/unknown flag, identity merge/split, relationship interval conflict, and stale/superseded claim entering a new snapshot. | Extend the synthetic test specification before implementation authorization; retain all fixtures fabricated. |

## 3. Cross-document consistency and traceability

The reviewed logical model, fixture catalogue, deterministic test specification and Agenda 1 evidence record agree on the bounded design-only nature of the work. The fixture integrity evidence is internally consistent: 11 entities, 11 relationships, 5 claims, 2 evidence references, 2 synthetic authorization records and 24 test IDs. All relationship endpoints and provenance references were reported resolved by the Agenda 1 structural check.

The focused M1 SR-01–SR-14 / relevant G-control / M2 AR-001–AR-025 crosswalk is present. It is appropriately described as a focused design crosswalk, not proof that all requirements are implemented.

The M3 master plan and progress report contain historical status snapshots that need a current Agenda 2 reconciliation. In particular, their earlier top-level summaries predate the M3-03 Agenda 1 delivery and should not be read as the current project status. This review record is the Agenda 2 review evidence; it does not replace the canonical M1/M2 acceptance records.

## 4. Decisions reserved to the Product Owner

| Decision | Recommendation | Owner decision |
|---|---|---|
| D-01 — Accept the Agenda 1 logical model as the working baseline, subject to R-01 through R-07 being resolved or explicitly deferred | Accept conditionally as a design baseline only; no physical implementation authority | **Pending** |
| D-02 — Identity resolution and merge/split | Require human decision and reversible lineage; detailed implementation may be deferred | **Pending** |
| D-03 — Authority relationship vocabulary | Keep recognition, accreditation, licensing, examination/awarding and affiliation distinct; prohibit inference by name similarity | **Pending** |
| D-04 — Authorization revocation consequence | Require revalidation and publication review; immediate suppression where continued use/publication is no longer authorized | **Pending** |
| D-05 — Detailed role/permission matrix timing | Require before any real editorial workflow, source handling or public release; not a prerequisite to this documentation review | **Pending** |

The Product Owner may accept the recommendations, request changes, or defer individual decisions. Silence or PR merge is not acceptance.

## 5. Required design clarifications before baseline acceptance

1. Correct the Provider–Institution relationship/cardinality wording.
2. Normalize claim disposition, lifecycle events and version relationships.
3. Either specify identity candidate/merge/split governance or explicitly defer it with a clear no-automated-merge invariant.
4. Define or explicitly defer the controlled authority relationship vocabulary.
5. Define authorization revocation consequences across claims and publication.
6. Record the minimum separation-of-duties invariant and the later role-matrix gate.
7. Add synthetic expected-result cases for the edge conditions in R-07, or record each omission as an explicit later implementation acceptance test.

These are documentation/design clarifications only. No physical schema, Laravel implementation, migrations or runtime tests are part of this agenda.

## 6. Explicit exclusions and gate preservation

This review did not access or modify V1, Hostinger, hPanel, SSH, production, DNS or deployment. It did not connect to or provision a database, create schema/migrations, implement persistence, use real institutions or source records, collect or download evidence, contact people, activate external APIs/AI/connectors/telemetry, incur spend, or initiate a pilot or launch.

P04 V2 runtime/isolation/capacity/recovery evidence, P05 specialist clearances and P06 hosted execution/recovery remain independent gates. Deeni Madaris cross-surface enforcement remains unimplemented and must be evidenced before any public surface exists. No later physical design or implementation is authorized by this review.

## 7. Agenda disposition and next action

**Review activity:** completed.  
**Design-baseline acceptance:** blocked pending Product Owner decisions D-01 through D-05 and resolution/deferment of R-01 through R-07.  
**M3-03 overall:** In progress.  
**Next action:** Product Owner decision on the review recommendations. Do not begin Agenda 3, physical design, schema, migrations or persistence until the design baseline is accepted and the exact next scope is separately authorized.


## 8. Product Owner decision and acceptance record — 2026-11-13

The Product Owner explicitly accepted D-01 through D-05 as recommended:

- **D-01 — Accepted:** Agenda 1 logical model accepted as the working design baseline, subject to the recorded clarifications below. This is design acceptance only.
- **D-02 — Accepted:** identity resolution requires human decisions; merge/split lineage is preserved and reversible; automated merge is prohibited.
- **D-03 — Accepted:** authority relationship types remain distinct and are not inferred from name similarity.
- **D-04 — Accepted:** authorization revocation triggers quarantine, revalidation and publication review; suppression applies where continued publication is not authorized or safety/privacy requires it.
- **D-05 — Accepted:** minimum separation of duties is binding; a detailed role/permission matrix is required before real source handling, editorial workflow or public release.

The seven findings R-01–R-07 are resolved at the logical design/specification level in the revised model and companion synthetic test specification. R-01–R-06 are incorporated as explicit invariants; R-07 is addressed by extending the deterministic specification from 24 to 32 cases (T-025–T-032). These changes are design clarification only, not application implementation.

**Owner acceptance:** accepted as the M3-03 logical design baseline on 2026-11-13.  
**Implementation authorization:** not granted.  
**Physical schema/migrations/persistence:** not authorized.  
**Real/source/personal data, source acquisition, external services/AI, hosting, deployment, pilot, launch or spend:** not authorized.

## 9. Agenda disposition

Agenda 2 Product Owner decision and design-baseline acceptance is complete once the accepted clarifications, revised fixture manifest, 32-vector specification and this decision record are merged and validated. M3-03 as a whole remains In progress. A subsequent agenda must be separately scoped and authorized; no physical implementation follows automatically from this acceptance.
