# 01-plan: Last 100 rooms and the AI Learning track

File: `last_100_rooms.csv`. Header matches the 22 columns of the master plan sheet `New Rooms (585)` in `Cybrixen_Room_Plan.xlsx`. It has exactly 100 data rows: the last 100 rooms by sheet order (GRC-OPS-M02-R07 to PT-FOUND-M05-R01), after the AI Learning track was inserted. Dates are written as YYYY-MM-DD.

## What changed (2026-10-17)

12 trailing Planned rooms in the last-100 slice were replaced by a 12-room AI Learning track (track code AI-LEARN). The rooms chosen were the last non-PT-FOUND, non-Completed rooms counted back from the end of the slice. All 12 were Status Planned in Tier D (defer first). PT-FOUND rooms were not touched.

The same replacement was made in the live workbook `/workspace/rooms-project/Cybrixen_Room_Plan.xlsx`, in the same row positions, so plan and CSV match. The total stays at 585 new rooms. A copy of the workbook from before the change is at `Cybrixen_Room_Plan_v6_before_ai_track.xlsx`.

### Rooms replaced (removed from the plan)

| Room ID | Title | Type | Difficulty | Status |
|---|---|---|---|---|
| PROF-M01-R03 | Incident War-Room Facilitation | Learning | Intermediate | Planned |
| PROF-M01-R04 | Case: Deliver Bad News to Leadership | Challenge | Expert | Planned |
| PROF-M01-R05 | Case: Facilitate a Cross-Team Incident Sync | Challenge | Expert | Planned |
| PROF-M02-R01 | Cybersecurity Ethics Scenarios | Learning | Beginner | Planned |
| PROF-M02-R02 | Computer Crime Law Essentials (Comparative) | Learning | Beginner | Planned |
| PROF-M02-R03 | Responsible Disclosure Practice | Learning | Intermediate | Planned |
| PROF-M02-R04 | Case: Ethical Dilemma Judgment Lab | Challenge | Expert | Planned |
| PROF-M02-R05 | Case: Handle a Vulnerability Disclosure | Challenge | Expert | Planned |
| PROF-M03-R01 | Building a Personal Security Lab | Learning | Beginner | Planned |
| PROF-M03-R02 | Git and Version Control for Security Work | Learning | Beginner | Planned |
| PROF-M03-R03 | Building a Cybersecurity Portfolio | Learning | Intermediate | Planned |
| PROF-M03-R04 | Security Mentorship and Knowledge Sharing | Learning | Expert | Planned |

PROF keeps only Security Communication (PROF-M01-R01 and PROF-M01-R02). Modules PROF-M02 (Ethics, Law & Disclosure) and PROF-M03 (Lab Craft & Careers) no longer exist. If those topics are wanted later, plan them again in a future batch.

### AI Learning track inventory

Track: **AI Learning** | Domain: AI Security | Delivery: PHP simulation | Batch 24 (2026-11-07) | Status: Planned

| Room ID | Module | Title | Slug | Type | Difficulty | Est. min | Access | Flag theme |
|---|---|---|---|---|---|---|---|---|
| AI-LEARN-M01-R01 | AI Security Fundamentals | Machine Learning System Attack Surface | machine-learning-system-attack-surface | Learning | Beginner | 35 | Free | CBX{map_surface} |
| AI-LEARN-M01-R02 | AI Security Fundamentals | Prompt Injection Concepts | prompt-injection-concepts | Learning | Beginner | 35 | Free | CBX{spot_injection} |
| AI-LEARN-M01-R03 | AI Security Fundamentals | Training Data Poisoning Basics | training-data-poisoning-basics | Learning | Beginner | 40 | Free | CBX{trace_poison} |
| AI-LEARN-M01-R04 | AI Security Fundamentals | Model Extraction and Theft Basics | model-extraction-and-theft-basics | Learning | Intermediate | 40 | Paid | CBX{detect_extraction} |
| AI-LEARN-M02-R01 | Attacking & Defending AI Apps | Direct and Indirect Prompt Injection Lab | direct-and-indirect-prompt-injection-lab | Learning | Intermediate | 45 | Paid | CBX{isolate_instructions} |
| AI-LEARN-M02-R02 | Attacking & Defending AI Apps | RAG Pipeline Data Leakage | rag-pipeline-data-leakage | Learning | Intermediate | 45 | Paid | CBX{filter_retrieval} |
| AI-LEARN-M02-R03 | Attacking & Defending AI Apps | Insecure LLM Tool and Plugin Use | insecure-llm-tool-and-plugin-use | Learning | Intermediate | 50 | Paid | CBX{scope_tools} |
| AI-LEARN-M02-R04 | Attacking & Defending AI Apps | Case: Jailbreak Testing an LLM Support Bot | jailbreak-testing-an-llm-support-bot | Challenge | Expert | 75 | Paid | CBX{seal_jailbreak} |
| AI-LEARN-M03-R01 | AI for Defenders | Using AI Assistants Safely in SOC and IR | using-ai-assistants-safely-in-soc-and-ir | Learning | Beginner | 40 | Paid | CBX{redact_prompts} |
| AI-LEARN-M03-R02 | AI for Defenders | Detecting AI-Assisted Phishing and Attacks | detecting-ai-assisted-phishing-and-attacks | Learning | Intermediate | 45 | Paid | CBX{flag_lure} |
| AI-LEARN-M03-R03 | AI for Defenders | LLM Application Logging and Abuse Detection | llm-application-logging-and-abuse-detection | Learning | Intermediate | 45 | Paid | CBX{alert_abuse} |
| AI-LEARN-M03-R04 | AI for Defenders | Case: Investigating a Compromised AI Chat Assistant | investigating-a-compromised-ai-chat-assistant | Challenge | Expert | 90 | Paid | CBX{revoke_plugin} |

Mix: 10 Learning and 2 Challenge. Difficulty: 4 Beginner, 6 Intermediate, 2 Expert (Challenge cases). Free: the first 3 rooms. Paid: the other 9. Access is recorded only in the plan and CSV. It never goes in a packet.

### Duplication check
Existing platform rooms on AI: *AI and ML in Cybersecurity*, *AI Model Security*, *AI Threat Detection System*, *Generative AI Security Risks*. Planned GRC-RISK-M05 rooms: AI Governance Framework Essentials, EU AI Act Compliance Overview, Model Risk Management for AI Systems, Generative AI Acceptable Use Policy Design, two AI governance Case rooms. No AI-LEARN title or slug matches any of them, and no new title or slug duplicates any title or slug in the plan. The new rooms are hands-on simulated labs at junior and intermediate level (attack surface mapping, injection labs, RAG leakage, tool scoping, SOC use and detection). They do not repeat the existing theory overviews or the governance and policy rooms. Packet authors should name these existing rooms in Existing Catalog Awareness.

### Workbook sheets updated
- New Rooms (585): rows 566 to 577 replaced. Autofilter widened to A1:V586.
- Summary: counts recomputed (Learning 420, Challenge 165, ratio 28.2%, 27 tracks, 109 modules). AI Learning row and AI Security domain added. The difficulty label "Advanced" was corrected to "Expert" to match the data. Week 4 Learning and Challenge figures were adjusted. The pre-existing week-by-week "576" totals were stale before this change (they leave out PT-FOUND) and were not rebuilt.
- Tracks & Modules: PROF module rows reduced to M01 (2 rooms). 3 AI-LEARN module rows added.
- Batch Schedule: batch 24 is now 14 Learning and 9 Challenge (32 effort units), with AI-LEARN modules listed.
- Capacity & Risks: AI-LEARN added to Tier D.
- Dup Check: a note row was added that records this change.
- `Cybrixen_Room_Plan.md` (markdown mirror) was already stale (576 rooms) and was not regenerated.
