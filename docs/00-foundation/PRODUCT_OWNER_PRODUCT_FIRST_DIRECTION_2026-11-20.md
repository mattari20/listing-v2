# Product Owner Direction — Finish the Student Institute Discovery Product

**Date:** 2026-11-20  
**Repository:** `mattari20/listing-v2`  
**Status:** Accepted product direction; governs prioritisation of ordinary product-development agendas.

## Product Owner's direction

The primary objective is to finish a usable institute-discovery application for students in the user's neighbourhood, city and surrounding areas, connected to eStudent.pk.

The product should make it easy for students to discover and understand:

- Which educational institutes are available and where they are located.
- Which courses, subjects and programmes each institute offers.
- Which facilities and services an institute describes as available.
- Admission information and the next steps for a student interested in applying.
- The original institute website or relevant source page where the student can verify details and continue their enquiry.

The application is a student-facing discovery and navigation service. It organises useful institute information and directs students to the original institute sources. It is not intended to replace institute websites or present unsupported claims as verified facts.

## Product-first working direction

1. Prioritise implementation and completion of the application over repeatedly reopening already discussed legal, safeguarding, policy or approval topics during ordinary development.
2. Treat the Product Owner's stated acceptance of the prior discussions and decisions as the working direction. Do not repeatedly ask the Product Owner to restate that acceptance.
3. Produce a working product that the Product Owner can inspect. The Product Owner will review the actual application, identify changes and decide when it is ready for public release.
4. Defer launch-specific review and release decisions until there is a sufficiently complete product to review. Do not use future launch-readiness work as a reason to stop ordinary product implementation.
5. Keep the work agenda-led. Pull requests, commits and CI are delivery and verification mechanisms; they are not substitutes for completing the product agendas.
6. When an implementation is ready and its required exact-head checks pass, follow the standing project delivery direction to merge it without requiring the Product Owner to repeat the instruction.

## Immediate product priorities

1. Complete institute profiles and the linked campus, programme, course and admission-offer experience.
2. Complete student-facing institute discovery, search, filters and useful comparisons.
3. Complete administration and institute-information management workflows.
4. Integrate the main journeys, run the relevant tests and fix defects and warnings that affect product quality.
5. Present the working application for Product Owner review and incorporate the resulting product feedback.

## Information presentation principles

- Make source links visible and useful so students can open the institute's own website or relevant page for further details.
- Keep institute information structured, searchable and easy to update as published details change.
- Distinguish information supplied by an institute from platform-generated descriptions or system metadata.
- Do not invent course, fee, facility, admission or campus details where the source does not provide them.

## Existing project boundaries

This note records the Product Owner's product direction and prioritisation. It does not silently change technical access permissions or authorize production/V1/Hostinger access, deployment, public launch, paid services, external API activation, or real-world data collection where those actions remain outside the currently approved development scope. Continue implementation within the currently approved environment and data boundaries; revisit any separate authorization only if a future task actually requires it.

## Completion objective

The next meaningful milestone is a coherent, usable institute-discovery application that the Product Owner can operate and review—not another round of repeating the same preliminary discussions.