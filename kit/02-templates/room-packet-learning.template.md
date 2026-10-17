=== ROOM PACKET START ===
Room ID: {{ROOM_ID}}
Room Type: Learning
Topic Title: {{TOPIC_TITLE}}
Slug: {{SLUG}}
Difficulty: {{DIFFICULTY}}
Estimated Time: {{EST_TIME}} minutes
Prerequisites: {{PREREQUISITE_ROOM_TITLE}}

Existing Catalog Awareness:
- {{Earlier rooms in this track and module: what they teach. State what this room assumes and does not reteach.}}
- {{Related rooms in other tracks (including existing platform rooms on the same theme) and how this room differs.}}
- {{The case or challenge room this lesson prepares for, and confirmation that hosts, addresses and answers differ from it.}}

Learning Objectives:
- {{Measurable objective 1 (verb first: Identify, Explain, Configure, Trace)}}
- {{Measurable objective 2}}
- {{Measurable objective 3}}
- {{Measurable objective 4}}

Task Outline:
Task 1 (Introduction): {{Scenario hook, why it matters, scope of the room.}} Question: Type "yes".
Task 2 ({{CONCEPT_TITLE}}): {{What is taught: concepts, commands, tables, diagrams.}} Questions ({{2 to 4}}): {{question}} (answer: {{ANSWER}}); {{question}} (answer: {{ANSWER}}).
Task 3 ({{CONCEPT_TITLE}}): {{What is taught. If the practical grades an order, teach that order here as an ordered list or SVG flow.}} Questions ({{2 to 4}}): {{...}}.
Task 4 ({{CONCEPT_TITLE}}): {{...}} Questions ({{2 to 4}}): {{...}}.
Task 5 ({{CONCEPT_TITLE}}, optional): {{...}} Questions ({{2 to 4}}): {{...}}.
Task 6 (Practical): Launch the {{PRACTICAL_TOOL_NAME}}. Questions (2): {{practical question}} (answer: {{ANSWER}}); enter the flag.
Task 7 (Conclusion): {{Recap and a reusable artefact such as a checklist or template.}} Question: Type "complete".

Practical Concept:
Scenario: {{What the learner faces in the lab. Synthetic hosts (cbx.lab), RFC 1918 and RFC 5737 addresses, neutral hostnames.}}
Interaction: Browser-only PHP simulation with {{panels / simulated tool / decision deck}}. Benign decoys in every category: {{list decoys}}. Feedback names the consequence of a chosen action only for taught order boundaries; it never lists the right sequence. Wrong submissions show plain "Not yet."
Flag Reveal Logic: The flag is sealed client-side (XOR-encoded byte array decoded only after validation, never present in plain source). It unlocks when {{exact conditions}}. {{What keeps it locked}}.

Host Inventory (if the lab shows hosts):
| Hostname | IP | OS | Build / patch level |
|---|---|---|---|
| {{srv01}} | {{10.x.x.x}} | {{OS}} | {{build}} |

Decoy Table:
| Answer | Real item | Benign look-alike | Fields that separate them |
|---|---|---|---|
| {{ANSWER}} | {{real}} | {{decoy}} | {{field A + field B}} |

Flag Value: {{FLAG}}   (format CBX{verb_noun}, lowercase, for example CBX{remove_printdriver})

Notes for Creator:
- Learning room, {{N}} tasks: Introduction, {{3 or 4}} concept tasks, Practical, Conclusion. Delivery is PHP simulation (browser-only PHP plus JS, no real shells, VMs or live models).
- Difficulty label is {{DIFFICULTY}}. Never use "Advanced".
- All hostnames, addresses and hashes are synthetic (cbx.lab, RFC 5737 ranges).
- Keep scope to {{scope}}; do not reteach {{topics covered earlier}}.
- Pre-QA checklist:
  - Every key event type has at least one benign decoy, so no single search solves it.
  - Each answer has one natural form: digits for counts, no hyphenated terms (except a real cmdlet name), and question wording that matches the task text.
  - Every answer is findable in the task text it belongs to; every graded order in the practical is taught in a concept task.
  - Wrong-answer feedback is plain "Not yet." and never reveals the correct set; distractors are plausible and similar in length.
  - Reset restores all cards; the tutorial button works; layout holds on narrow screens.
  - Lists are sorted by time, and briefs, times and tickets are consistent.
  - No em dashes anywhere.

Module: {{MODULE}}
Track: {{TRACK}}
Coverage Summary: {{ONE PARAGRAPH: level, what is taught, what the practical proves.}}
=== ROOM PACKET END ===
