=== ROOM PACKET START ===
Room ID: {{ROOM_ID}}
Room Type: Challenge
Topic Title: Case: {{TOPIC_TITLE}}
Slug: {{SLUG}}
Difficulty: {{DIFFICULTY}}
Estimated Time: {{EST_TIME}} minutes
Prerequisites: {{PREREQUISITE_ROOM_TITLE}}

Existing Catalog Awareness:
- {{Position of this room in its track and module, and what the case proves (one or two sentences).}}
- {{Earlier rooms in the same module and what they cover (operations, event IDs, hosts, answers). State that none of those are reused here.}}
- {{Related rooms in other tracks and how this room differs (skills referenced, not retaught).}}
- {{Existing platform rooms on the same theme (from existing-rooms.txt) and why this is not a duplicate.}}
- Hosts, addresses and identifiers are new: site subnet {{SUBNET}}, {{HOST_1 (IP, role in case)}}, {{HOST_2}}, {{DECOY_HOST}}, external address {{RFC5737_ADDRESS}}. No address or hostname from output/ or earlier packets ({{LIST_REUSED_RANGES_TO_AVOID}}) is reused.

Learning Objectives:
- Triage and scope the {{TOPIC_TITLE}} scenario using only the supplied artefacts
- Establish entry vector, affected assets and attacker objectives from evidence
- Execute containment and eradication decisions that preserve forensic value
- Submit a CBX flag that encodes the decisive investigative proof

Host Inventory:
| Hostname | IP | OS | Build / patch level | Notes for realism |
|---|---|---|---|---|
| {{srv01}} | {{10.x.x.x}} | {{Windows Server 2019}} | {{17763.xxxx, update state}} | {{features present at this build, e.g. LAPS, Defender}} |
| {{ws41}} | {{10.x.x.x}} | {{Windows 11 23H2}} | {{22631.xxxx}} | |

Task Outline:
Task 1 (Introduction): Brief: ticket {{TICKET_ID}} opened {{DATE}} at {{HH:MM}} after {{TRIGGER}}. Evidence pack: {{LIST EVERY PANEL}}, a host inventory, an inventory graph (read-only, groups and hosts only) and a response console. Teaches the response rules the console grades: {{ORDER_RULES}}. States that all times are UTC. Question: Type "yes".
Task 2 ({{INVESTIGATION_TASK_TITLE}}): Single investigation task with 9 questions:
  Q1. {{QUESTION}} ({{ANSWER}})
  Q2. {{QUESTION}} ({{ANSWER}})
  Q3. {{QUESTION}} (username only, for example j.doe) ({{ANSWER}})
  Q4. {{QUESTION}} ({{ANSWER}})
  Q5. {{QUESTION}} ({{ANSWER}})
  Q6. {{QUESTION}} (HH:MM:SS, UTC) ({{ANSWER}})
  Q7. {{QUESTION}} ({{ANSWER}})
  Q8. {{QUESTION}} (answer in digits: {{N}})
  Q9. Enter the flag shown after the {{PROOF_NAME}} and response plan are accepted.
Task 3 (Conclusion): Recap the lifecycle: {{ATTACK_CHAIN_AND_EVIDENCE}}, how decoys were separated, and the response sequence. Question: Type "complete".

Practical Concept:
Scenario: {{Full narrative with exact timestamps, hosts, accounts and artefacts. Every key event happens on a host whose OS and build can produce it.}}
Interaction: Browser-only PHP simulation (log data embedded as JS, no live capture) with tabs for {{PANEL_1 (raw fields)}}, {{PANEL_2 (raw fields)}}, the host inventory, the read-only inventory graph and a response console. All lists sorted by time, paginated with full navigation, never capped, so every row (including answer rows) is reachable. Benign decoys for every key event (see Decoy Table). Raw fields carry no labels such as exploit, attack, malicious, payload or evil; no notes columns, label-like uids or ids, and no hint sentences in any panel. The inventory graph shows inventory only with no session or logon edges. The console requires a proof ({{PROOF_FIELDS}}) and an ordered response plan built from a shuffled step list that includes trap steps ({{TRAP_STEPS}}) and a Reset button.

Attack Timeline (UTC):
| Time | Host | Source | Event | Key fields |
|---|---|---|---|---|
| {{HH:MM:SS}} | {{host}} | {{log source}} | {{event}} | {{fields}} |

Decoy Table:
| Answer (Q#) | Real event | Benign look-alike | Fields correlated to separate them (2 or more) |
|---|---|---|---|
| Q1 {{ANSWER}} | {{real}} | {{decoy}} | {{field A + field B}} |
| Q2 {{ANSWER}} | {{real}} | {{decoy}} | {{field A + field B}} |

Plan Cards and Graded Order:
| Step group | Cards (any order inside a group) | Taught where |
|---|---|---|
| 1 | {{evidence collection}} | Task 1 brief, rule 1 |
| 2 | {{contain A}}, {{contain B}} | Task 1 brief, rule 2 |
| 3 | {{eradicate}} | Task 1 brief, rule 3 |
| Traps | {{trap 1}}, {{trap 2}} | n/a (keep flag locked) |

Flag Reveal Logic: The flag is sealed client-side (XOR-encoded byte array, never present in plain source) and decoded only when the proof matches {{PROOF_VALUES}} and the plan places {{GROUP ORDER IN WORDS}}. Any trap step, or any change before evidence collection, keeps it locked. Wrong submissions show plain "Not yet."

Flag Value: {{FLAG}}   (format CBX{verb_noun}, lowercase, for example CBX{remove_printdriver})

Notes for Creator:
- Challenge room with exactly 3 tasks: Introduction, {{INVESTIGATION_TASK_TITLE}} (9 questions), Conclusion. Delivery is PHP simulation (browser-only PHP plus JS).
- Difficulty label is {{DIFFICULTY}}. Never use "Advanced".
- Answers are 1 to 3 words and each has one natural form. No two questions accept the same answer ({{LIST ALL ANSWERS}}). Accepted variants: {{case-insensitivity, optional domain prefix, required extension}}.
- Question wording must not give away facts the learner should find.
- Count clarity: Q8 counts {{EXACT DEFINITION}}. Keep Q8 wording exactly.
- Technical accuracy (verified against {{SOURCES}}): {{protocol values, event IDs and fields, default privileges, patch history}}.
- Timeline consistency: keep the times above identical across every panel, the brief and the ticket.
- All data synthetic (cbx.lab, RFC 1918 and RFC 5737 addresses). Decoy hashes, keys, SIDs and tokens differ from the real ones in every character position.
- Pre-QA checklist:
  - Every key event type has at least one benign decoy, so no single filter or search solves any question.
  - No notes or label columns in the source data; no label-like uids, ids or hint sentences in panels.
  - The inventory graph is inventory-only (groups, hosts, OU membership), with no session or logon edges. Hostnames carry no role words.
  - Every key event exists on that host's OS and build; every session has a logon row (and a conn row where network logs exist) before subject actions; Zeek uids match; process lineage holds.
  - Account names are technically correct (SYSTEM children, machine accounts as Subject where Windows records them, sAMAccountName format).
  - No row caps or truncated tables hide answer rows; all lists are paginated and fully reachable.
  - Each answer has 1 to 3 words, one natural form, digits for counts, is unique across questions, and question wording matches the task text.
  - Wrong-answer feedback is plain "Not yet." and never names a position, a step or the correct item; no counters, per-field marks or Hint buttons.
  - The ordering console starts shuffled, includes trap steps and has a Reset button that restores all cards.
  - Every graded order boundary is taught in the brief; either order is accepted wherever the room does not teach one.
  - The flag logic requires evidence collection before any change.
  - Lists are sorted by time, and briefs, host counts, times and tickets are consistent.
  - No em dashes anywhere.

Module: {{MODULE}}
Track: {{TRACK}}
Coverage Summary: {{ONE PARAGRAPH: level, what is found, how decoys are separated, response order.}}
=== ROOM PACKET END ===
