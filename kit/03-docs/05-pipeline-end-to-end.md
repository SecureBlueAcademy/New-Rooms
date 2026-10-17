# 05 Pipeline End to End

## Roles
| Role | Owns | Hands off to |
|---|---|---|
| **Content Engineer** (Office Mine) | Master plan, row selection, statuses, targets and stop points, Drive upload after PASS | Planner (rows), Drive (files) |
| **Room Planner** | Room Packets: catalog check, packet writing, full technical review, explicit approval | Creator (approved packet) |
| **Room Creator** | The 3 room files built from the approved packet, plus a self-check | QA (3 files) |
| **QA** | One full-pass review, PASS or a single fail list | Content Engineer (PASS) or Creator (fail list) |

Step-by-step workflows for each role are in `07-team-workflows.md`.

## Flow
```
Plan row (Planned)
  -> Planner writes packet, reviews, fixes, says "approved"     [Packet Issued]
  -> Creator builds 3 files, self-checks, submits               [In Creation]
  -> QA single-pass review                                      [In QA]
       -> fail list -> Creator fixes -> QA                      [Revision Needed -> In QA]
       -> PASS
  -> Content Engineer uploads to Drive, updates the plan        [Completed]
(stuck at any point -> Blocked, with the reason)
```

## Group chat handoffs
All handoffs happen in the team group chat so everyone sees the state. Suggested convention: each message starts with the Room ID.
| Message | From | Meaning |
|---|---|---|
| `<ID> packet` + full packet | Content Engineer or Planner | Packet text for review |
| `<ID> approved` + final packet | Planner | The Creator may start |
| `<ID> started` | Creator | Building |
| `<ID> submitted` + 3 files | Creator | Ready for QA |
| `<ID> FAIL` + numbered list | QA | Revision Needed |
| `<ID> PASS` | QA | Ready to ship |
| `<ID> uploaded` | Content Engineer | On Drive. Plan set to Completed. |
| `<ID> blocked: <reason>` | Anyone | Status Blocked |

## In-flight caps
- **At most 3 rooms in flight** across the pipeline. Building, waiting for QA, in QA and in revision all count. **QA counts as in flight.**
- The Planner checks the Creator's status every 5 minutes. If the Creator is idle and fewer than 3 rooms are in flight, the Planner asks the Content Engineer for more packets.
- Packets are approved just in time. Do not stockpile approved packets far ahead of creation.

## Stop and resume
- **Stop** at Office Mine's target count or stop instruction. Finish the room you are on (do not abandon half-written files), report its state, and start nothing new.
- **Resume** only when Office Mine says so. Read the plan statuses and the group chat to rebuild state: rooms In Creation or Revision Needed continue first, then Packet Issued, then new rows.
- A room interrupted mid-QA goes back through QA in full.

## Drive upload after PASS
- Upload only after PASS. Path: `Platform Rooms > <Track> > <Module> > <room-slug> > 3 files`.
- Upload exactly the files QA passed. If a file changes after PASS, it needs QA again.
- Then set the plan Status to Completed and post `<ID> uploaded`.

## Plan status updates
- The Content Engineer updates the Status column at each transition (see `01-room-planning.md`).
- Keep Summary counts accurate when tracks or rows change. Record structural changes in the Dup Check sheet notes and in `01-plan/README.md`.
