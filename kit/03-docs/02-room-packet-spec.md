# 02 Room Packet Specification

A Room Packet is the single source of truth a Creator builds from. It is plain text that sits between two fixed markers:

```
=== ROOM PACKET START ===
...
=== ROOM PACKET END ===
```
Templates: `02-templates/room-packet-learning.template.md` and `02-templates/room-packet-challenge.template.md`. Real examples: `04-examples/NTI-M01-R03.md` (Challenge) and `04-examples/LIR-M03-R01.packet.txt` (Learning).

## Fields (in this order)
| Field | Content | Rules |
|---|---|---|
| Room ID | From the plan | Exact match |
| Room Type | `Learning` or `Challenge` | Older packets say `Standard` (= Learning) |
| Topic Title | Display title | Case rooms start with `Case:` |
| Slug | lowercase-hyphenated | Must match the plan. All 3 file names use it. |
| Difficulty | Beginner, Intermediate or Expert | Never Advanced |
| Estimated Time | `NN minutes` | |
| Prerequisites | Room title(s) | |
| Existing Catalog Awareness | Bullets | Position in the track, sibling rooms and what they cover, cross-track overlaps, a statement of new identifiers (subnet, hosts, external address), and the ranges that must not be reused |
| Learning Objectives | 4 bullets | Measurable. Challenge rooms end with "Submit a CBX flag that encodes the decisive investigative proof" |
| Host Inventory | Table: hostname, IP, OS, build or patch level | Neutral hostnames. Every event must be possible on its host OS and build. |
| Task Outline | One entry per task with questions and answers in brackets | See "Task shape" |
| Practical Concept | Scenario, Interaction, Flag Reveal Logic | Scenario with exact timestamps. Interaction lists the panels and their raw fields, the decoys and the console design. |
| Attack Timeline | Table with exact UTC times | Must agree across all panels, the brief and the ticket |
| Decoy Table | Per answer: real event, benign look-alike, 2 or more separating fields | Required for every answer |
| Plan Cards and Graded Order | Groups of cards, traps, and where each boundary is taught | Untaught order is accepted in any sequence |
| Flag Value | `CBX{verb_noun}` | Lowercase. Linked to the decisive proof. |
| Notes for Creator | Type and task count, difficulty reminder, answer variants, technical accuracy notes with sources, timeline, synthetic data note, **Pre-QA checklist** | |
| Module / Track | From the plan | |
| Coverage Summary | One paragraph | |

Never include: Access (Free/Paid), em dashes, real organisation names, real secrets, or working exploit code.

## Task shape
### Learning (Standard)
- 5 to 9 tasks. The usual shape is 7: Introduction, 3 or 4 concept tasks, Practical, Conclusion.
- Task 1 question: Type "yes". Last task question: Type "complete".
- Each concept task has 2 to 4 short-answer questions. The Practical task has 1 or 2 questions plus the flag question.
- The practical is one interactive simulated tool. The flag unlocks on the decisive action or proof.

### Challenge
- Exactly 3 tasks: Introduction (brief, evidence pack, response rules, "yes"), one Investigation task, Conclusion ("complete").
- The Investigation task has 5 to 10 questions (the Planner's range). **Use 9 as the house default**, as in NTI-M01-R01 to R04: Q1 to Q8 are investigative and Q9 is the flag.
- The usual question order follows the attack chain: entry IP, operation or technique, account, artefact, follow-on process, time (HH:MM:SS UTC), impact, scope count (digits), flag.
- The practical is a multi-panel log analyser: one tab per log source, a filter bar, pagination, a host inventory, an inventory-only graph and a response console (proof fields and a shuffled ordered plan with trap steps and Reset).

## Answers
- 1 to 3 words, one natural form, digits for counts, unique across the room.
- The only hyphenated answer allowed is a real cmdlet name (for example `Get-ItemProperty`).
- Question text states the format: "(HH:MM:SS, UTC)", "(answer in digits)", "(username only, for example j.doe)".
- Question text never contains an answer or a fact the learner should find.
- List the accepted variants in Notes for Creator (case-insensitivity, optional domain prefix, required extension).

## Flag
- Format `CBX{verb_noun}`, lowercase, with words joined by underscores. Real examples: `CBX{remove_printdriver}`, `CBX{reset_machineaccount}`, `CBX{block_c2_egress}`.
- It is sealed client-side as an XOR-encoded byte array and is never in plain source. It is decoded only when the proof matches and the plan passes the graded order. Any trap, or any change before evidence collection, keeps it locked.

## Pre-QA checklist (from real packets: NTI-M01-R03, LIR-M03-R01)
Copy this list into Notes for Creator and adapt it:
- Every key event type has at least one benign decoy, so no single filter or search solves any question.
- No notes or label columns in the source data. No label-like uids, ids or hint sentences in panels. Raw fields never use words such as exploit, attack, malicious, payload or evil.
- The inventory graph is inventory only (groups, hosts, OU membership), with no session or logon edges.
- Account names are technically correct (SYSTEM child processes, the machine account as Subject where Windows records it, sAMAccountName format for domain users).
- No row caps or truncated tables hide answer rows. All lists are paginated and fully reachable.
- Each answer has 1 to 3 words, one natural form, digits for counts, is unique across questions, and the question wording matches the task text.
- Wrong-answer feedback is generic ("Not yet.") and never names a position, a step or the correct item. Distractors are plausible and similar in length.
- The ordering console starts shuffled, includes trap steps and has a Reset button.
- Either order is accepted wherever the room does not teach one.
- The flag logic requires evidence collection before any change.
- Lists are sorted by time, and briefs, times, host counts and tickets are consistent.
