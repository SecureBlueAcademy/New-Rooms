# Cybrixen New-Rooms: pipeline playbook

This repository is where Cybrixen rooms are planned, built, QA'd and stored. Every agent reads this
file first. The source rules are the Room Creation Kit in `kit/` (start with `kit/03-docs/00-README.md`).

## Roles (agent definitions in `.claude/agents/`)
| Role | Agent | Does |
|---|---|---|
| Content Engineer | the main session (orchestrator) | Picks rows, runs the agents, keeps `plan/status.csv` and the path manifests current, moves PASSed rooms into `Platform Rooms/`, commits and pushes. Stops for the owner's approval where told. |
| Room Planner | `room-planner` | New rooms: approved Room Packet. Existing rooms: approved Fix Brief from a Path QA audit. |
| Creator 1 (main) | `room-creator` | Builds the 3 files of a new room from an approved packet. |
| QA lead | `room-qa` | Full-pass review, PASS or one fail list. Final verdict on new rooms and on fixed path rooms. |
| Path QA (under QA lead) | `path-qa` | Audits existing rooms of the two live paths side by side, routes `[planner]` items to the Planner, hands the brief to Creator 2, re-checks fixes. |
| Creator 2 | `room-fixer` | Applies audit + Fix Brief to an existing room in place, keeping its identity. |

## Flows
New room (plan row in `plan/master_plan.csv`):
```
Planned -> room-planner packet.md "APPROVED"            [Packet Issued]
        -> room-creator build/<slug>/ + solve.json       [In Creation]
        -> room-qa qa-rN.md: FAIL -> room-creator fixes  [In QA / Revision Needed]
                             PASS -> orchestrator moves build/<slug>/ to
                                     Platform Rooms/<Track>/<Module>/<slug>/   [Completed]
```
Existing path room (rows in `paths/*.csv`):
```
path-qa audit-rN.md -> room-planner fix-brief.md "APPROVED" -> room-fixer edits in place + fix-notes.md
  -> path-qa recheck-rN.md (open items go back to room-fixer) -> room-qa qa-final.md PASS
```
At most 3 rooms in flight across both flows (QA counts). Handoffs are one line each, appended to
`pipeline/log.md`: `<ID or slug> <event>` (packet approved, submitted, FAIL (n items), PASS,
audit ready, fix brief approved, fixed, ready for QA lead, uploaded, blocked: reason).

## Layout
```
plan/            master_plan.csv (new plan + 12 AI Learning rooms), new_plan.csv (as provided),
                 ai_learning_rooms.csv, status.csv (pipeline status per new room)
paths/           manifests of the two live paths (module, room, folder, QA status), design-docs/
Platform Rooms/  <Track>/<Module>/<room-slug>/{<slug>.php, <slug>-practical.php, <slug>-answers.csv}
                 New rooms land here only after PASS. The two live paths were imported here as-is;
                 fixes are applied in place so git history shows every change.
pipeline/new/<ROOM-ID>/          packet.md, build/<slug>/, solve.json, build-notes.md, qa-rN.md
pipeline/path-qa/<path>/<slug>/  audit-rN.md, fix-brief.md, fix-notes.md, solve.json, recheck-rN.md, qa-final.md
kit/             templates, docs, examples, seal_flag.py (from the Room Creation Kit)
platform/        room-engine.php, style.css, rooms-style.css: reference copies of the live platform,
                 used by the preview. Never edit these.
tools/           lint_room.py, preview.sh, check_theory.cjs, check_practical.cjs
```
Track and Module folder names are exactly as in the plan or path design document.

## Tools (run from the repo root)
```
python3 tools/lint_room.py "<room folder>" [--json] [--proof "<proof 1>" "<proof 2>" ...]
tools/preview.sh "<room folder>" ...         # serves rooms with the real engine; prints URLs
node tools/check_theory.cjs <theory url> "<answers csv>" <screenshot dir>
node tools/check_practical.cjs <practical url> <screenshot dir> --flag "CBX{...}" [--spec solve.json]
```
Screenshots go under `/tmp/cbx-shots/` (not committed). Agents Read the PNGs to review visuals.

## House rules (everything, always)
- Difficulty is Beginner, Intermediate or Expert. The plan's `Advanced` means Expert.
- Delivery is PHP simulation: browser-only PHP plus JS, all data embedded, no live targets.
- Flags are `CBX{verb_noun}`, lowercase, sealed with `kit/02-templates/seal_flag.py`. The plain flag
  and its body never appear in any source file.
- No Free or Paid wording in packets or room files. No em dashes (U+2014) anywhere.
- Wrong answers in practicals show plain `Not yet.`: no counters, per-field marks or Hint buttons.
- Every answer has a decoy; no single filter, search or column gives an answer away.
- Answers: 1 to 3 words, one natural form, digits for counts, unique, no commas, no `/`, not made
  only of symbols. Only a real cmdlet name may be hyphenated.
- Practicals start with the auth guard (`require_once __DIR__ . '/../../includes/auth.php';` then
  redirect to login if not logged in). Tutorial: opens on first visit, View Tutorial button, Escape
  closes, page behind cannot scroll, Next and Skip always on screen and uncovered, accurate spotlight.
- Commands and command parameters render white in theory pages (`<style>` line in task 1, see
  room-creator.md). No other ad hoc text colours. Same theme in every practical.
- Synthetic data only: `cbx.lab`, fresh RFC 1918 /16 per room, RFC 5737 external addresses, neutral
  hostnames, no real organisations, secrets or working exploit code.

## Known platform issues (report, do not fix inside rooms)
- `room-engine.php` returns `correct_answer` in the JSON reply even when the answer is wrong, so any
  answer (including the flag) can be read with one request. Needs a platform fix.
- The engine's input placeholder masks only letters and digits, so symbol answers (`;`, `&&`, `|`)
  are shown in the box. Avoid such answers.
- The engine treats `/` in an answer as alternatives.
- `rooms-style.css` renders `<code>` in `--primary` blue, which is hard to read on the dark theme.
