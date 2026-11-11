#!/usr/bin/env python3
"""Dependency-free structural validation for V2 project control documentation."""

from pathlib import Path
import re
import sys

ROOT = Path(__file__).resolve().parents[1]
REQUIRED = [
    "README.md",
    "docs/README.md",
    "docs/00-foundation/PROJECT_MASTER_CONTROL.md",
    "docs/00-foundation/PROJECT_CONSTITUTION.md",
    "docs/00-foundation/AI_EXECUTION_PROTOCOL.md",
    "docs/00-foundation/ENGINEERING_STANDARDS.md",
    "docs/00-foundation/DEFINITION_OF_DONE.md",
    "docs/00-foundation/DECISION_REGISTER.md",
    "docs/04-roadmap/PROJECT_MASTER_ROADMAP.md",
    "docs/04-roadmap/MILESTONE_STEP_REGISTER.md",
    "docs/04-roadmap/IMPLEMENTATION_TRACEABILITY_MATRIX.md",
    "docs/04-roadmap/PROJECT_PROGRESS_REPORT.md",
    "docs/99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md",
]

def fail(message: str) -> None:
    print(f"ERROR: {message}")
    sys.exit(1)

missing = [path for path in REQUIRED if not (ROOT / path).is_file()]
if missing:
    fail("Required project-control files are missing: " + ", ".join(missing))

# Validate relative Markdown links in Markdown files. External URLs and
# fragment-only anchors are intentionally not fetched or checked here.
link_pattern = re.compile(r"!?\[[^\]]*\]\(([^)]+)\)")
broken = []
for markdown in ROOT.rglob("*.md"):
    if any(part in {".git", ".github"} for part in markdown.parts):
        continue
    text = markdown.read_text(encoding="utf-8")
    for target in link_pattern.findall(text):
        target = target.strip().split()[0].strip("<>")
        if not target or target.startswith(("https://", "http://", "mailto:", "#")):
            continue
        target_path = target.split("#", 1)[0]
        if not target_path:
            continue
        resolved = (markdown.parent / target_path).resolve()
        try:
            resolved.relative_to(ROOT.resolve())
        except ValueError:
            broken.append(f"{markdown.relative_to(ROOT)} -> path escapes repository: {target}")
            continue
        if not resolved.exists():
            broken.append(f"{markdown.relative_to(ROOT)} -> missing target: {target}")

if broken:
    fail("Broken local Markdown links:\n- " + "\n- ".join(broken))

controller = (ROOT / "docs/00-foundation/PROJECT_MASTER_CONTROL.md").read_text(encoding="utf-8")
if "Strict legacy non-interference rule" not in controller:
    fail("Master controller must contain the strict legacy non-interference rule.")

audit = (ROOT / "docs/99-reference/LEGACY_REPOSITORY_ISOLATION_AUDIT.md").read_text(encoding="utf-8")
if "Non-interference guarantee" not in audit:
    fail("Legacy isolation audit must contain its non-interference guarantee.")

print(f"PASS: {len(REQUIRED)} required control documents exist.")
print("PASS: all relative Markdown links resolve within the repository.")
print("PASS: strict legacy non-interference controls are present.")
