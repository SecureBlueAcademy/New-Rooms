# Cybrixen Room Creation Kit

Prepared by Office Mine (Content Engineer), 2026-10-17. Everything needed to create Cybrixen rooms from scratch.

## Start here
1. Read `03-docs/00-README.md` for the overview and the 8-step pipeline.
2. Read `03-docs/07-team-workflows.md` for the Room Planner, Room Creator and QA workflows.
3. Pick a row from `01-plan/last_100_rooms.csv`.
4. Planner: fill in a packet template from `02-templates/`, then approve it.
5. Creator: copy the 3 file templates from `02-templates/`, build, seal the flag (`seal_flag.py`), self-check.
6. QA: run `03-docs/04-room-qa.md`, then PASS or a single fail list.
7. After PASS: upload to Drive at `Platform Rooms > Track > Module > room-slug > 3 files` and set the plan to Completed.

## Layout
```
README.md                  this file
MANIFEST.txt               every file in the kit
01-plan/                   last_100_rooms.csv (100 rows + header) and README (AI Learning track, replaced rooms)
02-templates/              Learning and Challenge room templates, answer CSV templates, packet templates, seal_flag.py
03-docs/                   00 overview, 01 planning, 02 packet spec, 03 creation, 04 QA, 05 pipeline, 06 format reference, 07 team workflows
04-examples/               real packets (Challenge NTI-M01-R03, Learning LIR-M03-R01), format-notes.md, example answer CSVs, output layout
```

## House rules
Difficulty is Beginner, Intermediate or Expert (never Advanced). Delivery is PHP simulation. Flags are CBX{verb_noun}, lowercase and sealed. No Access (Free/Paid) in packets or room files. No em dashes. Feedback is plain "Not yet." Every answer has a decoy, and no single filter gives an answer away.
