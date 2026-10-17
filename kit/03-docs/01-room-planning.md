# 01 Room Planning

How the Content Engineer and the Room Planner turn the master plan into approved Room Packets.

## Roles in planning
- **Content Engineer (Office Mine):** owns the master plan workbook. Selects rows, keeps statuses current, adds or replaces tracks (for example the AI Learning track), resolves duplicates, and sets targets and stop points.
- **Room Planner:** turns one plan row into one Room Packet. Fully reviews and fixes it, then approves it before any Creator builds. The Planner's full workflow is in `07-team-workflows.md`.

## The master plan
File: `Cybrixen_Room_Plan.xlsx`. Room rows are on the sheet whose name starts with `New Rooms` (currently `New Rooms (585)`). Other sheets: Summary, Tracks & Modules, Dup Check, Existing (424), Batch Schedule, Capacity & Risks. Keep the Summary, Tracks & Modules and Batch Schedule sheets in step with any row change.

### Columns
| Column | Meaning | Rules |
|---|---|---|
| Room ID | `TRACKCODE-Mxx-Ryy`, e.g. `NTI-M01-R03`, `AI-LEARN-M02-R01` | Unique. Module and room numbers are 2 digits. |
| Track | Track name | Must exist in Tracks & Modules |
| Module | Module name | Must exist in Tracks & Modules |
| Module order / Room order | Integers | Prerequisite chains follow the room order |
| Room Title | Display title | Challenge cases start with `Case:`. No duplicate of an existing or planned title. |
| Slug | lowercase, hyphenated | Unique. Drop the `Case:` prefix. Used for all 3 file names. |
| Type | Learning or Challenge | Older packets say "Standard". Standard = Learning. |
| Difficulty | Beginner, Intermediate, Expert | Never Advanced. Case rooms are normally Expert. |
| Est. time | Minutes, digits | Learning 35 to 50, Challenge 60 to 90 |
| Prerequisites | Title of an earlier room | |
| Learning objectives | ` \| `-separated, about 4 | Measurable, verb first |
| Practical lab description | What the lab is and what the flag proves | |
| Scenario/evidence & flag theme | Evidence types and flag theme | The flag theme is `CBX{verb_noun}` |
| Practical delivery | PHP simulation (also Hybrid or Downloadable evidence pack on older rows) | New rows: PHP simulation. The Planner converts Hybrid to PHP simulation in the packet and notes it. |
| Cert alignment | CCDFA, CCPTA, CCSE, CCGP or None | |
| Domain | e.g. Incident Response, Penetration Testing, AI Security | |
| Batch / Target date | Schedule | Match the Batch Schedule sheet |
| Review owner/status | Free text | |
| Access | Free or Paid | **Plan and CSV only.** Never copied into a packet or room file. |
| Status | See below | |

### Statuses
```
Planned -> Packet Issued -> In Creation -> In QA -> Completed
                                  ^           |
                                  |           v
                                  +-- Revision Needed
Any stage -> Blocked (record the reason in Review owner/status)
```
| Status | Set when | Set by |
|---|---|---|
| Planned | The row exists and no packet has been written | Content Engineer |
| Packet Issued | The Planner has written and approved the packet | Content Engineer, on the Planner's "approved" |
| In Creation | The Creator has started building | Content Engineer |
| In QA | The Creator has submitted the 3 files | Content Engineer |
| Revision Needed | QA returned a fail list | Content Engineer |
| Completed | QA PASS and the files are uploaded to Drive | Content Engineer |
| Blocked | Stuck on a dependency, an SME question or a duplicate | Content Engineer |

## Planning rules
1. **No topic duplication.** Before you write a packet, check `existing-rooms.txt`, the Existing sheet, the Dup Check sheet and every planned title in the same track and in neighbouring tracks. Record the result in the packet's Existing Catalog Awareness. Reuse skills by reference. Never reteach them.
2. **New identifiers per room.** Each room uses its own subnet, hostnames, accounts, hashes and answers. Never reuse identifiers from `output/` or from earlier packets.
3. **Difficulty labels.** Beginner, Intermediate or Expert only.
4. **Delivery.** PHP simulation: browser-only PHP plus JS, with all data embedded. No VMs, live models, real shells or real malware.
5. **No Access in packets.** Free and Paid exist only in the plan and CSV.
6. **The Planner approves first.** The Planner fully reviews and fixes the packet and gives an explicit "approved" before the Creator builds. A Creator never starts from an unapproved packet.
7. **Decoys spelled out per answer.** Each packet has a Decoy Table. For every answer it lists the real event, its benign look-alike, and the 2 or more fields that separate them.
8. **Host OS realism.** Each packet has a host inventory (hostname, IP, OS and build or patch level). Every key event must be possible on that OS and build. Hostnames are neutral (srv##, ws## or a real system name), with no role words.
9. **Graded order is taught.** Every order boundary the console grades is taught in the brief or a concept task. Order that is not taught is accepted in any sequence.
10. **Answers.** 1 to 3 words, one natural form, digits for counts, unique within the room. The only hyphenated answer allowed is a real cmdlet name.
11. **Flag.** `CBX{verb_noun}`, lowercase, tied to the practical's decisive proof.

## Changing the plan (for example adding a track)
- Replace the least essential Planned rows first (Tier D, trailing rows). Never replace Completed rooms or rows that are in flight.
- Keep the total count sensible. Mirror every replacement in all sheets (Summary, Tracks & Modules, Batch Schedule, Dup Check note).
- Back up the workbook before you edit it. `01-plan/README.md` records the AI Learning change as a worked example.
