# 07 Team Workflows

There are three team workflows: Room Planner, Room Creator and QA. The Room Planner section is the Planner's own posted workflow, reproduced verbatim and then mapped to this kit. The Creator and QA sections are compiled from pipeline practice and the other docs in this kit.

---

## A. Room Planner workflow (as posted by the Room Planner)

**1. Plan row to packet**
- Take the plan row (code, title, module, difficulty) and check the catalog so the topic isn't a repeat.
- Choose Standard or Challenge. Standard rooms have 5 to 9 tasks: intro, core lessons, practical, conclusion. Challenge rooms have exactly 3 tasks, with 5 to 10 investigation questions in Task 2.
- Fill the fixed packet template between === ROOM PACKET START === and === ROOM PACKET END ===: type, title, slug, difficulty, time, prerequisites, measurable objectives, task outline, practical concept (scenario, interaction, flag reveal logic, flag), notes for Creator, and catalog awareness.
- Every answer is 1 to 3 words, has one natural form, uses digits for counts and is unique across the room. The only hyphenated answer allowed is a real cmdlet name.
- Flag is CBX{verb_noun} tied to the practical. Packet contains no em dashes.

**2. Practical design that goes into every packet**
- Host inventory: hostname, IP, OS and build or patch level. Hostnames neutral (srv##, ws##, or real system name), no role words.
- Attack timeline with exact timestamps; every key event on a host whose OS can produce it.
- Decoy table: for each answer, real event, benign look-alike, and which two or more fields you correlate to tell them apart.
- Plan cards and graded order in the packet. Every graded boundary taught in the brief; untaught order accepted; console starts shuffled with trap cards and Reset.

**3. Checks before "approved"**
- Technical accuracy: protocol values, event IDs/fields, patch history, default privileges.
- OS reality: every event exists on that host OS/build; features like LAPS/Defender exist at that patch level.
- No single filter/column gives an answer (rare values only attacker has).
- Decoy hashes/keys/SIDs/tokens differ in every position; SIDs correct prefix; RIDs follow creation order.
- Every session has logon and conn row; Zeek uids match; process lineage holds.
- Host counts agree across brief/intro/inventory. No answer naming. Feedback plain "Not yet."

**4. What I send the Creator**
- Full corrected packet with decoy table and inventory, plus explicit "approved". Creator doesn't build until approved.
- During QA: only technical corrections the fail list missed; stay quiet otherwise.

**5. Pipeline duties (when creation is running)**
- Every 5 minutes check Creator status. If idle and fewer than 3 in flight, ask Content Engineer for more packets. QA counts as in flight.
- Stop at Office Mine's target/stop instruction.

### How the Planner workflow maps to this kit
| Planner step | Kit file |
|---|---|
| Catalog check | `01-room-planning.md` (Planning rules 1 and 2), plan sheets Existing and Dup Check, `existing-rooms.txt` |
| Standard or Challenge, task counts | `02-room-packet-spec.md` (Task shape). Standard = Learning in the plan's Type column. Challenge default is 9 questions within the 5 to 10 range. |
| Fixed packet template | `02-templates/room-packet-learning.template.md`, `02-templates/room-packet-challenge.template.md` |
| Host inventory, timeline, decoy table, plan cards | Sections of the same names in both packet templates |
| Checks before "approved" | `04-room-qa.md` (the same checks, applied again by QA after build) |
| Send to Creator, approval | `05-pipeline-end-to-end.md` (handoffs) |
| 5-minute status check, in-flight cap of 3, stop rule | `05-pipeline-end-to-end.md` (In-flight caps, Stop and resume) |

### Planner checklist (copy for each packet)
- [ ] The topic is not a repeat (existing rooms, planned titles, neighbouring tracks). Catalog Awareness is written.
- [ ] Type chosen. Learning: 5 to 9 tasks. Challenge: 3 tasks and 5 to 10 investigation questions (default 9).
- [ ] All template fields are filled. Objectives are measurable. No Access info. No em dashes.
- [ ] Answers: 1 to 3 words, one form, digits for counts, unique. Only a real cmdlet name may be hyphenated.
- [ ] Flag `CBX{verb_noun}` is tied to the decisive proof.
- [ ] Host inventory with OS and build. Neutral hostnames.
- [ ] Attack timeline with exact times. Every event is possible on its host OS and build.
- [ ] Decoy table: one row per answer with 2 or more separating fields.
- [ ] Plan cards, groups and traps listed. Every graded boundary is taught in the brief.
- [ ] Technical accuracy verified (protocol values, event IDs and fields, patch history, default privileges).
- [ ] No single filter or column gives an answer. Decoy hashes, keys, SIDs and tokens differ in every position. SID prefixes are correct. RIDs are in creation order.
- [ ] Each session has logon and conn rows. Zeek uids match. Lineage holds.
- [ ] Host counts agree across brief, intro and inventory. No answer is named in question text. Feedback is plain "Not yet."
- [ ] Explicit **"approved"** sent with the full corrected packet.

---

## B. Room Creator workflow
1. **Wait for approval.** Build only from a packet the Planner marked "approved". Post `<ID> started`.
2. **Set up.** Make the folder `<slug>/` and copy the 3 file templates for the room type from `02-templates/`.
3. **Theory page.** Fill in config, tasks, questions (worded exactly as in the packet) and content. Teach every graded order boundary and every answer in the text.
4. **Practical.** Build the inventory, panels and data from the packet's Host Inventory, Attack Timeline and Decoy Table. Lists are sorted by time and fully paginated. Build the console from Plan Cards and Graded Order, with shuffle, traps and Reset.
5. **Answers CSV.** Use the FILENAME header, ids matching the PHP, the flag row, then `complete`.
6. **Seal the flag** with `seal_flag.py`. Confirm the plain flag is not in the source.
7. **Solve-through and self-check.** Use the list in `03-room-creation.md`: no single-filter giveaways, decoys for every key event, OS realism, plain "Not yet.", no hints, no em dashes, difficulty Expert rather than Advanced, Reset works, responsive layout.
8. **Submit.** Post `<ID> submitted` with the 3 files. The room counts as in flight until PASS.
9. **Revision.** On a FAIL list, fix every item in one go, then re-run the self-check and resubmit. If an item needs a packet change, ask the Planner to correct and re-approve the packet first.
10. **Stop rule.** At Office Mine's stop instruction, finish the current file set, report its state, and do not start a new room.

---

## C. QA workflow
1. **Pick up.** Take a submitted room with its approved packet. The room stays in flight.
2. **Single full pass.** Solve the room end to end and run the whole checklist in `04-room-qa.md`.
3. **Report once.** Post either `<ID> PASS` or `<ID> FAIL` with one numbered list that covers every issue (file, location, expected fix).
4. **Re-review.** Check every listed item plus anything the fixes touched. Do not add new nitpicks that were present but unreported in the first pass, unless they break a hard rule.
5. **PASS hand-off.** The Content Engineer uploads to Drive (`Platform Rooms > Track > Module > room-slug > 3 files`) and sets the plan status to Completed.
6. **Planner during QA.** The Planner may add technical corrections the fail list missed and otherwise stays quiet.
