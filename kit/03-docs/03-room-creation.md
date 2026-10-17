# 03 Room Creation (Creator workflow)

The Creator builds one room from one **approved** packet. Never start from a packet that has no explicit "approved" from the Planner.

## Output: 3 files per room
| File | Purpose | Template |
|---|---|---|
| `<slug>.php` | Theory page and task shell: room_config, answers_file, room_tasks, js_config, task_questions_data, task_contents | `learning-room-page.php.template` / `challenge-room-page.php.template` |
| `<slug>-practical.php` | Self-contained interactive HTML lab: dark theme, tutorial button, brief, tool area, sealed flag | `learning-room-practical.php.template` / `challenge-room-practical.php.template` |
| `<slug>-answers.csv` | Header `# FILENAME: <slug>-answers.csv`, then rows `taskN,qN,answer` | `*-answers.csv.template` |

## Steps
1. Make the folder `<slug>/` and copy the three templates for the room type into it. Rename them to the slug.
2. **Theory page.** Fill in room_config from the packet (id = slug, title, difficulty, estimated time, prerequisites, 4 objectives). Build room_tasks from the Task Outline. Set js_config.storage_key to the slug with underscores plus `_progress`, and write 4 takeaways. Copy the questions exactly as the packet words them. Write task_contents as HTML heredocs with tables, code blocks and inline SVG, and give each SVG a comment that says what it teaches.
3. **Answers CSV.** One row per question, ids q0..qN running continuously across tasks. task1 q0 = `yes`. The flag row comes before the final `complete`.
4. **Practical.** Build the panels or tool from the packet's Interaction, Host Inventory, Attack Timeline and Decoy Table. All data is synthetic and embedded as JS. Lists are sorted by time and fully paginated. Build the console with the packet's plan cards, groups and traps.
5. **Seal the flag.** Run `python3 02-templates/seal_flag.py "CBX{verb_noun}" <proof answers...>` and paste CHECK_HASH and SEALED_FLAG_HEX into the practical. Search the source: the plain flag must not appear anywhere.
6. **Solve it yourself.** Answer every question from the room alone, then submit the proof and plan and check that the flag appears. Check that every trap keeps the flag locked.
7. Run the self-check below. Then submit the 3 files to QA and post in the group chat (see `05-pipeline-end-to-end.md`).

## Self-check before submit
- [ ] Exactly 3 files, named with the slug. The CSV header line matches the file name.
- [ ] The difficulty field and any text about level read Beginner, Intermediate or Expert, never "Advanced". Words like "Advanced" in module names are fine.
- [ ] Learning room: 5 to 9 tasks (usually 7). Challenge room: exactly 3 tasks, with the Investigation questions matching the packet (default 9, last is the flag).
- [ ] Question ids in the PHP and the CSV match one to one. Answers match the packet.
- [ ] **No single-filter giveaways.** For each answer, try the most obvious filter or search. It must return the decoy as well as the real event.
- [ ] **Decoys** exist for every key event, as the Decoy Table specifies. Decoy hashes, keys, SIDs and tokens differ from the real ones in every character position.
- [ ] **OS realism.** Every event is possible on its host's OS and build. Logon rows come before subject actions. Process lineage holds. Zeek uids match across logs.
- [ ] No label or notes columns, no hint sentences, no role-word hostnames, no row caps.
- [ ] Wrong answers show plain **"Not yet."**: no counters ("2 of 3"), no per-field ticks or crosses, no Hint buttons. A consequence line is allowed only for taught order boundaries.
- [ ] The console starts shuffled, has trap steps, and Reset restores every card.
- [ ] The flag is sealed. The plain flag is not in the source.
- [ ] **No em dashes** in any file. Search for the em dash character (U+2014).
- [ ] No Free or Paid wording anywhere.
- [ ] No `{{` placeholders left.
- [ ] The layout works at narrow widths (below 900px). Tables scroll instead of overflowing.
- [ ] The tutorial opens on first visit and from the button.

## Drive layout (after QA PASS only)
```
Platform Rooms/
  <Track>/
    <Module>/
      <room-slug>/
        <room-slug>.php
        <room-slug>-practical.php
        <room-slug>-answers.csv
```
Use the Track and Module names exactly as they appear in the plan.
