# Cybrixen Room Creation Kit: Overview

This kit has what you need to plan, specify, build, QA and ship Cybrixen rooms from scratch. It is maintained by the Content Engineer (Office Mine).

## Contents
| Folder | What it holds |
|---|---|
| `01-plan/` | `last_100_rooms.csv`: the last 100 rooms of the master plan, including the new AI Learning track. `README.md` lists the rooms that were replaced and the AI track inventory. |
| `02-templates/` | Room file templates (theory PHP, practical PHP, answers CSV) for Learning and Challenge rooms, Room Packet templates for both types, and `seal_flag.py`. |
| `03-docs/` | This documentation set (00 to 07). |
| `04-examples/` | A real Learning packet, the real Challenge packet NTI-M01-R03, `format-notes.md`, and a description of the layout of a completed output folder. |
| `MANIFEST.txt` | Every file in the kit. |

## Reading order
1. `01-room-planning.md`: master plan columns, statuses, planning rules.
2. `02-room-packet-spec.md`: the Room Packet format, field by field.
3. `03-room-creation.md`: how a Creator turns an approved packet into 3 files.
4. `04-room-qa.md`: the QA checklist and PASS / Revision Needed rules.
5. `05-pipeline-end-to-end.md`: roles, handoffs, in-flight caps, Drive upload, status updates.
6. `06-file-and-format-reference.md`: exact file shapes and sizes.
7. `07-team-workflows.md`: the Room Planner, Room Creator and QA workflows, step by step.

## End-to-end in 8 steps
1. **Pick rows.** The Content Engineer picks Planned rows from the master plan (`Cybrixen_Room_Plan.xlsx`, sheet `New Rooms (...)`) or from `01-plan/last_100_rooms.csv`.
2. **Write the packet.** The Room Planner fills in `02-templates/room-packet-learning.template.md` or `room-packet-challenge.template.md`. Plan status: Packet Issued.
3. **Approve the packet.** The Planner fully reviews and fixes the packet (technical accuracy, OS realism, decoy table, graded order) and sends it to the Creator with an explicit "approved".
4. **Build the room.** The Creator copies the three file templates, renames them to the slug, fills them in, seals the flag with `seal_flag.py` and self-checks. Plan status: In Creation.
5. **QA.** QA does one full pass and returns a single list of every issue. Plan status: In QA. If there are issues, the status goes to Revision Needed and the room returns to the Creator.
6. **PASS.** After a PASS, the 3 files are uploaded to Drive at `Platform Rooms > Track > Module > room-slug > 3 files`.
7. **Update the plan.** The plan row is set to Completed. If the room is stuck, it is set to Blocked with a reason.
8. **Repeat.** Repeat within the in-flight cap until Office Mine's target or stop instruction.

## Fixed rules (apply everywhere)
- Difficulty is Beginner, Intermediate or Expert. Never "Advanced". `format-notes.md` still lists Advanced. The packet rule overrides it.
- Practical delivery is PHP simulation: browser-only PHP plus JS, with no live targets.
- Flags are `CBX{verb_noun}`, lowercase, and sealed client-side.
- Access (Free or Paid) lives only in the plan and CSV. Never in packets or room files.
- No em dashes in packets or room files.
- Wrong-answer feedback is plain "Not yet."
