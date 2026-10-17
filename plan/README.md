# plan/

| File | What it is |
|---|---|
| `master_plan.csv` | The working plan: every row of `new_plan.csv` (91 rooms) followed by the 12 AI Learning rooms (103 rows, 20 columns). |
| `new_plan.csv` | The new plan exactly as provided (2026-10-17). |
| `ai_learning_rooms.csv` | The 12 AI-LEARN rows kept from the kit's old `last_100_rooms.csv`, trimmed to the 20 columns of the new plan (Access and Status dropped). |
| `status.csv` | Pipeline status per room: Planned, Packet Issued, In Creation, In QA, Revision Needed, Completed, Blocked. Updated by the orchestrator. |

The kit's old plan (`last_100_rooms.csv`) was replaced: its other 88 rows are no longer planned.

Normalisations applied by the Planner when writing packets (the plan files stay as provided):
- Difficulty `Advanced` (37 rows) is written as `Expert`.
- Delivery `Hybrid` (48 rows) and `Downloadable evidence pack` (2 rows) are built as `PHP simulation`.
- Flag themes such as `CBX{...}` or `CBX{VENDOR-TIER0-EXIT}` become lowercase `CBX{verb_noun}`.
