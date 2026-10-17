# 04 Room QA

QA receives the 3 files of a built room plus its approved packet. QA solves the room end to end and returns **either PASS or one complete fail list**.

## How to review
1. **Do one full pass.** Review everything in one pass and report every issue in one numbered list. Do not drip-feed issues over several rounds. A second round should only find problems the fixes introduced.
2. Solve the room as a learner: theory questions from the text, investigation questions from the panels, then the flag from the console.
3. Compare against the packet: answers, timeline, hosts, decoys, graded order, task count, difficulty.
4. Run the checklist below. Every failed item goes in the list with the file, the location and the expected fix.

## Checklist
### Structure and format
- [ ] Exactly 3 files: `<slug>.php`, `<slug>-practical.php`, `<slug>-answers.csv`. The CSV header is `# FILENAME: <slug>-answers.csv`.
- [ ] Learning: 5 to 9 tasks (usually 7) with Introduction ("yes"), concept tasks, Practical, Conclusion ("complete"). Challenge: exactly 3 tasks. The Investigation questions match the packet (default 9, Q9 = flag).
- [ ] The question ids in the PHP match the CSV rows. Each answer matches the packet and has one natural form, 1 to 3 words, with digits for counts. No answer repeats inside the room.
- [ ] Difficulty is Beginner, Intermediate or Expert, never Advanced.
- [ ] No Free or Paid wording. No `{{` placeholders left.

### Answer integrity
- [ ] **No single filter or search reveals an answer.** For each question, apply the obvious filter (an event ID, a rare value, a column sort). It must return at least one decoy alongside the real row. Values only the attacker has must not stand out from a single column.
- [ ] **Every key event has a decoy**, as the packet's Decoy Table specifies. The decoy is separated from the real event only by correlating 2 or more fields.
- [ ] **Decoy hashes, keys, SIDs and tokens differ in every character position** from the real values (no shared prefix or suffix to pattern-match). SIDs use the correct domain or local prefix. RIDs follow account creation order.
- [ ] Question text never contains an answer or a fact the learner should find.

### Technical realism
- [ ] Every event is possible on its host's **OS version and build** (event IDs, fields, features such as LAPS or Defender at that patch level).
- [ ] Message IDs, status codes, protocol values and event field names are correct for the source.
- [ ] **Event lineage holds.** Parent and child processes are right, SYSTEM children of SYSTEM services are right, and the Subject is the machine account where Windows records it that way.
- [ ] **A logon comes before subject actions.** Every session has its logon row (and a conn row where network logs exist) before the actions that use it. Zeek uids match across logs.
- [ ] Host counts and times agree across the brief, the intro, the inventory, the panels and the ticket.

### Data presentation
- [ ] The **AD or inventory graph is inventory only**: groups, hosts, OU membership. No session or logon edges.
- [ ] **No role-label hostnames** (no "attacker-pc", "dc-compromised", "evil"). Hostnames are neutral: srv##, ws## or a real system name.
- [ ] No notes or label columns, no label-like ids, no hint sentences in panels. Raw fields never say exploit, attack, malicious, payload or evil.
- [ ] **No row caps hide answers.** Every list is sorted by time and paginated with full navigation, and every row can be reached.

### Feedback and console
- [ ] Wrong submissions show plain **"Not yet."** No counters ("2 of 3 right"), no per-field marks, no Hint buttons, nothing that names a position, step or correct item.
- [ ] A **consequence line** (for example "Rebooting destroyed memory evidence") appears only for a taught order boundary. It never lists the correct sequence.
- [ ] **Every graded order boundary is taught** in the brief or a concept task. Cards inside one step are accepted in any order. Untaught order is accepted in any sequence.
- [ ] The console starts shuffled and includes trap steps. **Reset restores every card** and clears the proof and flag.

### Flag and polish
- [ ] **The flag is sealed** (XOR byte array plus check). The plain flag string does not appear in the source.
- [ ] The flag matches the packet and the CSV. It unlocks only with the right proof and plan, and every trap keeps it locked.
- [ ] **No em dashes** in any file.
- [ ] **Responsive widths.** The layout holds below 900px, tables scroll, and no fixed widths clip content.
- [ ] The tutorial opens on first visit and from its button. Escape closes it.



# QA Checklist

Standard checks for both content and challenge rooms:

•        No unnecessary or inconsistent colouring applied to text within rooms\.

•         Commands and command parameters should be in white color

•         Make sure all svgs are making sense and are not broken

•         Practical php should not show flag until the task is completed and flag should not be visible in the practical file code so user can't use the inspect element to get the flag without solving the practical

•         Practical files should not be accessible without authentication

•         Practical should be tough based on the room's difficulty level

•         Follow same coloring and theme in all the practical files

•         In PHP practical, the back screen must not be scrollable when tutorial is running\.

•         In PHP practical, the "next" button and "skip tutorial" button of the tooltip should always be accessible on the screen without any overlap to the other things

•         In PHP practical, the tutorial spotlight should always be perfect while the turorial is running 



Content Rooms Answer Checks

•        Answers must be short, maximum 2 to 3 words\.

•         Answers should not have comma \(,\) in them

•        No answer should be written as a full sentence or paragraph\.

•         Each task's questions should be strictly from that task's content\.



Challenge Rooms Answer Checks

•         All the answers should be strictly from the practical PHP file or file provided to download \(in case of challenges where a file is provided to analyze at the user's end\)

•         If a practical file is provided for download, such as a log file, make sure the questions of the challenge are strictly from the provided files





Functional Check \(UI\)

•        Test the static site from an end\-user perspective\.

•        Verify links, buttons, and navigation all work correctly\.

•        Confirm pages render as expected with no visual/layout breaks\.



## Verdict
- **PASS:** every checklist item holds and QA solved the room end to end. Post "PASS <Room ID>" in the group chat. The Content Engineer then uploads to Drive and sets the plan status to Completed.
- **FAIL:** post one numbered fail list. The plan status goes to **Revision Needed**. The Creator fixes every item and resubmits (In QA). The re-review checks every listed item plus anything the fixes touched.
- During QA the Planner adds only technical corrections the fail list missed, and otherwise stays quiet.
- If a fix needs a packet change (for example a wrong event ID in the packet), the Planner corrects and re-approves the packet first.
