# M3-11-02 — Additional Product Owner Scope Decision: Child and Student Personal Data

**Decision date:** 2026-11-21  
**Decision type:** Product Owner internal scope decision  
**Status:** ACCEPTED — CURRENT M3 ACCEPTANCE SCOPE ONLY  
**Baseline:** `c15d9645c52496d7d191002951d4034a162181cb`

## 1. Question and accepted decision

The Product Owner was asked whether real student, child or guardian personal data may be used in the current M3 acceptance scope.

**Accepted answer: Option A — no real student, child or guardian personal data is collected or stored; synthetic/fictional data only.**

This decision applies to the current M3 repository/local workstation/GitHub CI and any separately authorized private V2 acceptance work. It does not authorize a private environment, access, data collection or participant activity.

## 2. Binding implications

- Use only synthetic/fictional student, child, guardian, institute and participant examples in fixtures, tests, demonstrations and acceptance evidence.
- Do not solicit, import, upload, paste, store, inspect or publish real student, child or guardian records or identifiers.
- No child, student, guardian or participant recruitment, contact, interview, survey or testing is included.
- Do not treat a synthetic example as a real record or use real personal records to validate a workflow.
- Any proposal to introduce real student, child or guardian data requires a new explicit Product Owner decision, qualified legal/privacy/safeguarding review, and separately authorized implementation/environment scope before activity begins.

## 3. Important distinction from other personal information

This decision is limited to real student, child and guardian personal data. It does **not** mean that all project activity contains zero personal information. The existing 2026-11-20 Product Owner internal review already recognizes that developer and reviewer account metadata, GitHub usernames, commit authorship, CI account metadata, and reviewer identity/contact details may identify people. Those categories remain subject to minimization, confidentiality and the existing repository visibility controls.

Likewise, publicly available institution information and source/publication rights remain governed by their separate approved scope, provenance and rights-review requirements. Option A does not authorize source acquisition or real institution data collection.

## 4. Reconciliation with existing decisions

This is an additional M3-specific scope confirmation, not a restart or replacement of the previously completed ten-question Product Owner internal review and Decisions 1–3. Existing decisions on public institution information, official-channel verification, disputed/unverified information, correction/removal requests, child safeguards and future moderated reviews remain in force as previously recorded. Public UGC/reviews/ratings/reporting/moderation remain disabled in current M3 scope; future parent/legal-age student review concepts are not activated by this decision.

## 5. Gate effect and limitations

This decision closes the Product Owner question for the current M3 scope only. It does not establish that the codebase, all prompts, logs, attachments, CI artifacts, or future environments have been independently audited for personal data. It is not legal advice, a formal PIA/DPIA, child-safeguarding certification, independent reviewer report or proof of legal compliance.

M3-11-02 / Gate 02 remains **BLOCKED** pending qualified independent legal/privacy and child-safeguarding assessment and required Product Owner dispositions. Overall M3 remains **OPEN / PARTIALLY COMPLETE — NOT CLOSED**.

## 6. Restrictions preserved

Synthetic/fictional fixtures only. No real/source/personal/student/child/guardian data, no V1/Hostinger/production/hosted access, no environment provisioning, no participant activity, no external APIs/AI, no new vendor or spend, no deployment, pilot or release. Deeni Madaris remains default-OFF with zero public exposure.
