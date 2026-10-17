# Path QA audit, round 1: threat-modelling

- **Room:** Threat Modelling (`threat-modelling`)
- **Folder:** `Platform Rooms/Security Engineer Path/Security Engineering Foundations/threat-modelling/`
- **Path / module:** Security Engineer Path, module 1 "Security Engineering Foundations", room 3 of 6
- **Difficulty (config):** Intermediate. Learning room, 8 tasks, 14 questions, flag `CBX{register_prioritized}` (task7 q12)
- **Date:** 2026-10-17
- **Auditor:** Path QA (under the QA lead)
- **Scope note:** per the orchestrator's update, the side-by-side check is limited to the Security Engineer Path (the Junior Penetration Testing Path is out of scope for now).
- **Verdict:** FAIL.

## Tool summary
- `lint_room.py`: 8 FAIL, 8 WARN. FAIL: em dash (theory lines 3 and 381); CSV header is `task1,q0,yes` instead of `# FILENAME: threat-modelling-answers.csv`; q6 answer `seven` is a count in words; plain flag in practical (line 328); flag body in source; flag not sealed (no CHECK_HASH / SEALED_FLAG_HEX); no `Not yet.` feedback. WARN: 5 learning objectives and 5 takeaways (kit: 4); answer string in q2 (`design`) and q7 (`business risk`) question text; no auth guard; no Escape close; no first-visit flag; no max-width media query.
- `check_theory.cjs`: 0 fail, 0 warn. All 8 tasks render; text colours are body grey, white and the engine's cyan chrome only (the room has no `<code>`, so the white-command rule has nothing to apply to). Engine wrong-answer text is `Incorrect. Try again.`. Completion modal works.
- `check_practical.cjs`: 13 FAIL. Opens without login (HTTP 200). Plain flag and flag body in served source. Desktop and phone: page behind the tutorial scrolls (scrollY 712 / 1084), tutorial reopens after it was finished, Escape does not close it. Phone: Skip and Next are off screen on step 1, Skip and Finish are off screen on step 5.
- Screenshots read: `/tmp/cbx-shots/threat-modelling/theory/theory-task3.png`, `theory-task5.png`, `/tmp/cbx-shots/threat-modelling/practical/tutorial-desktop-step3.png`, `tutorial-desktop-step5.png`, `tutorial-phone-step1.png`, `tutorial-phone-step3.png`, `tutorial-phone-step5.png`, `practical-phone.png`. Seen: desktop step 3 and step 5 spotlight cut-out is offset from its target and the tooltip sits on top of the spotlighted area; phone step 1 tooltip is clipped above the top edge; phone step 5 tooltip is clipped below the bottom edge; phone step 3 spotlight is offset by about one card. The phone layout of the page itself holds (rows wrap, no horizontal scroll). Theory SVGs render cleanly.
- Engine check (`platform/includes/room-engine.php` line 99): answers are compared with `strcasecmp` after `trim`, so spelling must match exactly.

## Learner solve (for reference)
- Theory: yes, threat modeling, design, spoofing, information disclosure, repudiation, seven, business risk, AND, goal, trust boundary, likelihood, flag, complete.
- Practical: stage 1 Process, Process, Process, Data Store, External Entity, Process; stage 2 tick b1, b3, b4; stage 3 t1 DoS, t2 EoP, t3 Repudiation, t4 Information Disclosure, t5 Tampering, t6 Spoofing, t7 Spoofing, t8 Information Disclosure; stage 4 sort by the Impact x Likelihood product printed on each card (20, 16, 15, 12, 10, 9, 6, 4). All correct values and the final order (with scores) are readable in the JS (lines 353 to 385), and the flag is in the HTML at line 328.

## Issues

### A. Practical (`threat-modelling-practical.php`)

1. **hard rule [mechanical]** lines 1 to 4. No auth guard; the page opens logged out (HTTP 200). Expected: the standard guard from room-creator.md as the first PHP lines (`require_once __DIR__ . '/../../includes/auth.php';` then redirect to login if not logged in). Note: no live room has this guard yet (see shared list).

2. **hard rule [planner]** line 328 (`<div class="flag-value">CBX{register_prioritized}</div>`). Plain flag and flag body sit in the HTML, so View Source or Ctrl+F gives the flag without solving; the flag is not sealed. Expected: Planner defines proof fields from the solve (for example the three boundary ids and the top-ranked threat id), seals with `kit/02-templates/seal_flag.py`, and the flag element is built only after the proof check passes. No plain flag or body anywhere in the file.

3. **hard rule [planner]** lines 353 to 385 (`components[].correct`, `boundaries[].correct`, `threats[].category`, `correctOrder` and the comment on line 384 listing the order with every score). The whole answer key is in client JS, so the practical can be solved from Inspect Element without doing any modelling. Expected: verification derived from the sealed proof (hash compare), no `correct`/`category` fields or ordered answer list in the source; remove the line 384 comment.

4. **hard rule [mechanical]** verify handler, lines 488 to 517. Wrong submissions list which stages failed ("Component classification has one or more errors.", "Trust boundaries are not fully correct.", "One or more STRIDE assignments are incorrect.", "Register order is not correctly prioritised by risk."). This is per-field marking: it lets the learner brute-force one stage at a time (stage 2 is only C(6,3) = 20 combinations). Expected: any wrong submission shows plain `Not yet.` and nothing else.

5. **hard rule [planner]** stage 1 (lines 293 to 296, 353 to 360). The learner must classify components as Process, Data Store or External Entity, but the theory never teaches data flow diagram elements: "External Entity" and "Data Flow" do not appear anywhere in `threat-modelling.php`, and "Process"/"Data Store" appear only as two SVG labels in task 3. Expected: a theory task (task 6 is the natural place) teaches the four DFD elements (external entity, process, data store, data flow) plus trust boundaries as the overlay, with one sentence on how to tell each apart; the practical then grades only what was taught.

6. **hard rule [planner]** stage 2 boundaries (lines 362 to 369) and threat t4 (line 377). The lab gives no architecture or data flow diagram of MedLink, so where the trust boundaries lie can only be guessed. It also contradicts itself: "Patient Web Portal to API Gateway" is graded as NOT a boundary, yet t4 says an attacker intercepts unencrypted traffic on that exact link (which only makes sense if it crosses an untrusted network), and task 7 calls the portal "public facing" while "Internet to API Gateway" is the graded boundary. "Appointment Service to Patient Records Database" (process to the PHI data store) is graded as not a boundary, which many practitioners would mark. Expected: Planner adds a MedLink DFD panel (zones, components, flows) from which each boundary follows unambiguously, and rewrites t4 or the boundary list so they agree.

7. **quality [planner]** whole lab, difficulty vs Intermediate. Stage 3 categories are given away by the verbs in each threat ("floods" = DoS, "escalate privileges" = EoP, "tampers" = Tampering, "no log entry" = Repudiation, "lookalike domain" = Spoofing). Stage 4 is trivial sorting because each card prints Impact and Likelihood and every product is distinct. Threats are handed to the learner, so the design-doc step "enumerating threats against each component" is never practised, and attack trees and PASTA (2 of the 3 named methods) are not exercised at all. Expected: Planner raises the lab to Intermediate: learner enumerates or selects threats per DFD element from a larger pool with plausible decoys (threats that are out of scope or sit on a non-boundary flow), threat wording that does not echo the category name, a tie or a near tie in risk that needs a stated tie-break rule, and one stage that uses an attack tree (pick the cheapest path) to cover the third method.

8. **hard rule [mechanical]** tutorial auto-start, lines 601 to 604. The tutorial opens on every load (no first-visit flag), so it reopens after it was finished and after reload. Expected: `localStorage` first-visit flag (wrapped in try/catch); auto-open only when absent; View Tutorial always replays.

9. **hard rule [mechanical]** Escape handling. No `keydown` listener, so Escape does not close the tutorial or the "Tutorial Complete" modal. Expected: Escape ends the tutorial (spotlight and tooltip hidden, no completion modal).

10. **hard rule [mechanical]** scroll lock, `startTutorial` / `endTutorial` (lines 565 to 585). The page behind the tutorial scrolls (desktop scrollY 712, phone 1084). Because the spotlight is `position: fixed` and only re-positioned on `resize`, any scroll leaves the cut-out pointing at the wrong place. Expected: lock background scroll (`document.documentElement`/`body` overflow hidden) while the tutorial or completion modal is open, restore it on close.

11. **hard rule [mechanical]** tooltip placement, `positionSpotlight` (lines 544 to 549). For tall targets the fallback `top = rect.top - 170` goes negative and the bottom placement goes past the viewport, so on phone step 1 Skip and Next are above the screen and on step 5 Skip and Finish are below it. Expected: clamp the tooltip inside the viewport (for example `top = Math.max(12, Math.min(top, innerHeight - tooltipHeight - 12))`, using the tooltip's real height) and also clamp `left >= 12`, so Next and Skip are always on screen and never cover the target's key controls.

12. **hard rule [mechanical]** spotlight accuracy, `showStep` (lines 559 to 562). The spotlight is measured 300 ms after a smooth `scrollIntoView` starts, before scrolling settles, so the cut-out is offset (desktop step 3 and 5, phone step 3) and the tooltip lands on top of the highlighted stage (desktop step 3 hides the stage 3 heading and the first threat row; desktop step 5 tooltip sits inside the spotlight above the Verify button). Stage 3 and stage 4 are taller than the viewport, so a full-element spotlight cannot be accurate. Expected: scroll with `behavior: 'auto'` (or wait for `scrollend`) before measuring, spotlight the stage header plus first row for tall stages (or a dedicated anchor element), and place the tooltip beside, not over, the cut-out.

13. **quality [mechanical]** line 555. Dead code: `const el = ...` is computed and never used. Expected: remove.

14. **quality [mechanical]** CSS. No max-width media query. The phone screenshot holds today because rows use `flex-wrap`, but the 300px tooltip and `left = innerWidth - 320` give a negative left below 332px. Expected: add a `@media (max-width: 600px)` rule for the tooltip width (`max-width: calc(100vw - 24px)`) as part of item 11.

### B. Theory (`threat-modelling.php`)

15. **hard rule [mechanical]** lines 3 and 381. Em dash (U+2014) in the header comment and the end-of-data comment. Expected: replace with a hyphen or rewrite.

16. **hard rule [planner]** task2 q1 answer `threat modeling` (CSV line 2). The room spells it "threat modelling" everywhere (title, slug, every paragraph), and the engine compares exactly, so a learner who types the term as taught (`threat modelling`) is marked wrong. The question also gives the answer away, since it is the room's own title and task 1 defines it in the same words. Expected: ask something the task actually teaches and the title does not reveal (for example "Threat modelling is built around how many core questions?" with a digit answer, or the name of the practice of reviewing a design on paper), and keep one spelling consistent with the room.

17. **hard rule [planner]** task2 q2 (`design`), line 70. "Is it generally cheaper to fix a security flaw during design or after deployment?" contains the answer and is a 50/50 guess. Expected: reword so the answer is not in the question (for example "At which stage is a design flaw cheapest to fix?").

18. **hard rule [planner]** task4 q7 (`business risk`), line 79. "Is the PASTA methodology primarily technical or business risk focused?" contains the answer and is a 50/50 guess. Expected: reword (for example "PASTA starts from which kind of objectives before it reaches technical threats?" answer `business objectives`, or ask for the name of stage 1).

19. **hard rule [mechanical]** task4 q6 answer `seven` (CSV line 7). Count in words. Expected: `7`.

20. **hard rule [planner]** task6 q11 (`likelihood`), line 87. "Risk score is typically calculated as impact times what?" The formula is never stated in task 6 (it says only "an impact and likelihood score, the resulting risk score"); it appears only in the practical (stage 4 text) and in the later risk-driven-security-engineering room. Expected: task 6 states "Risk score = Impact x Likelihood" with the scale used (for example 1 to 5 each), or the question changes to something task 6 states.

21. **hard rule [planner]** task3 SVG (lines 214 to 230). The STRIDE-per-element mapping is wrong: a Process is exposed to all six categories (S, T, R, I, D, E), but the SVG shows "S, T, R, D, E" (Information Disclosure missing). It also shows only two of the four element types, so the claim "different component types are exposed to different threat categories" has no External Entity (S, R) or Data Flow (T, I, D). Data Store (T, R, I, D, with R applying to stores that hold logs) is correct. Expected: show all four elements with the standard Microsoft STRIDE-per-element mapping.

22. **quality [planner]** task3 STRIDE table (lines 172 to 212). The table never names the security property each category violates (Spoofing / authentication, Tampering / integrity, Repudiation / non-repudiation, Information Disclosure / confidentiality, Denial of Service / availability, Elevation of Privilege / authorization). That mapping is the core of how STRIDE is used at Intermediate level and is what differentiates this room from the shorter STRIDE table in ssdlc (see the ssdlc overlap note under "Shared across the paths"). Expected: add a "Property violated" column; optionally one question on it (one-word answer).

23. **quality [planner]** task5 key point (line 308) and attack-tree text (line 273). "The cheapest path ... is the path with the fewest AND conditions" is a heuristic, not how attack trees are evaluated: leaves carry a cost or difficulty, an OR node takes the cheapest child, an AND node sums its children. A single OR leaf can be the most expensive path (for example a zero-day). The SVG has no leaf values, so the learner cannot actually find a cheapest path from it, though the learning objective promises "identify the most viable attacker path". Expected: add leaf costs to the SVG (and Schneier as the origin, optional), state the OR = min / AND = sum rule, and keep the AND/OR question.

24. **quality [planner]** task2 text (line 124). "Three questions" is Shostack's framework minus its fourth question ("Did we do a good enough job?"), which is what makes threat modelling the repeatable process the info box describes. Expected: list four questions, or say "three of the four".

25. **quality [planner]** task6 example register (lines 332 to 334). The three example rows (API Gateway DoS 20, Records Database EoP 16, Admin Console Repudiation 15) are exactly the practical's top three threats with the same assets, categories and scores, so the theory hands over a third of stage 3 and the top of stage 4. Expected: use a different example system in the theory.

26. **quality [planner]** scope vs design doc ("decomposing a system into components, identifying trust boundaries, enumerating threats against each component"). Decomposition and DFD elements are not taught (item 5), threat enumeration is not taught as a step (STRIDE-per-element is the method; item 21), and risk scoring is mentioned only in passing (item 20). DREAD is not covered; it is not in the design doc, but since the room scores risk, one sentence on DREAD and why Microsoft dropped it (subjective, inconsistent scores between assessors) would place Impact x Likelihood in context. Expected: Planner decides the task 6 rewrite (DFD elements, STRIDE-per-element enumeration, scoring formula and scale) and whether to add the DREAD note.

27. **quality [planner]** config and conclusion. 5 learning objectives and 5 takeaways (kit expects 4), and the task 8 Key Takeaways list has 6 bullets that do not match the 5 `instagram_takeaways`. Expected: align objectives, takeaways and the conclusion list (4 each per kit).

28. **quality [planner]** spelling. The room is in British spelling ("modelling", "prioritised", "categorisation") but q1's answer is `threat modeling`, q4 says "unauthorized", and the flag says `prioritized`. Expected: one spelling throughout (British, matching the slug); see item 16 for the graded effect and item 29 for the flag.

29. **quality [user]** flag `CBX{register_prioritized}` (CSV line 13, practical line 328). The house format is `CBX{verb_noun}`; this is noun_verb and in US spelling, unlike the rest of the room. Changing a live flag value needs the owner's approval. Expected: owner decides whether to keep it or change it (for example `CBX{prioritise_register}`) when it is sealed in item 2.

### C. CSV (`threat-modelling-answers.csv`)

30. **hard rule [mechanical]** line 1. No header; file starts `task1,q0,yes`. Expected: first line `# FILENAME: threat-modelling-answers.csv` (the engine skips lines starting with `#`).

### D. Platform issues (report only, do not fix in the room)

31. **[platform]** `room-engine.php` returns `correct_answer` in the JSON reply even on a wrong answer. Concretely: posting any text for task7 q12 returns `CBX{register_prioritized}`, so the flag can be read without opening the practical, and every theory answer is readable the same way.

32. **[platform]** the engine placeholder shows word count and word lengths. Concretely: q8's placeholder `***` vs the two candidates AND/OR, and q2's `******` vs "design"/"deployment", give the answer away by length on the two-choice questions; q1's 8-star second word tells the learner the expected spelling is "modeling", not "modelling". Room-level mitigation is items 16 to 18 (no two-choice questions, one spelling). The `/` alternative rule and blue `<code>` have no effect here (no answer uses `/`; no `<code>` in the room), but any rewrite must avoid `/`.

## Counts
- 32 numbered items. By severity: 19 hard rule, 11 quality, 2 platform notes (items 31 and 32).
- By tag: [mechanical] 12 (items 1, 4, 8, 9, 10, 11, 12, 13, 14, 15, 19, 30); [planner] 17 (items 2, 3, 5, 6, 7, 16, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28); [user] 1 (item 29); [platform] 2 (items 31, 32).

## Shared across the paths
Scope: Security Engineer Path only. Ran `lint_room.py --json` over all 6 Security Engineering Foundations rooms plus the two rooms elsewhere in the path that teach threat modelling or risk scoring (ssdlc, risk-scoring-prioritisation): 8 rooms. Theme is identical in every practical (`--bg-primary #0b0f1a`, `--accent-primary #6ae3ff`, Inter + JetBrains Mono, same spotlight tutorial structure), so no theme or colour drift.

- **Flag never sealed, answer key in JS (8/8, hard rule [planner]):** plain flag and flag body in every practical (risk-driven line 441, security-architecture-frameworks 353, security-controls-mapping 430, security-design-patterns 426, security-engineering-principles 400, ssdlc 356, risk-scoring-prioritisation 515).
- **No `Not yet.` feedback (8/8, hard rule):** stage-by-stage or coaching messages instead.
- **No auth guard, no Escape close, no first-visit flag (8/8, [mechanical]):** all auto-reopen the tutorial on load. Scroll lock and tooltip clamping should be checked on each with `check_practical.cjs` when batched; the same `positionSpotlight` pattern (measure 300 ms after a smooth scroll, unclamped tooltip) is likely shared.
- **Skip wiring differs:** threat-modelling, security-architecture-frameworks, security-design-patterns, security-engineering-principles (via `tt-skip` / `skipBtn` -> `endTutorial`) and ssdlc (`endTutorial(false)`) close without the completion modal; check the others when batched so all behave the same.
- **Wrong CSV header (8/8, [mechanical]):** 7 start with `task1,q0,yes`; security-design-patterns uses `# security-design-patterns-answers.csv` (missing `FILENAME:`).
- **Em dashes (5/8, hard rule [mechanical]):** threat-modelling, security-architecture-frameworks, security-controls-mapping (theory and practical), security-design-patterns, security-engineering-principles (theory and practical).
- **Answer string in question text (6/8, [planner]):** threat-modelling q2/q7, risk-driven q4, security-architecture-frameworks q3/q4/q7/q8/q11, security-controls-mapping q2/q3/q4/q6/q7/q9/q10, ssdlc q7.
- **Answer-form defects ([planner]):** answers over 3 words in security-engineering-principles (`single point of failure`) and risk-scoring-prioritisation (`Exploit Prediction Scoring System`); hyphenated non-cmdlet answers in security-engineering-principles (`fail-secure`, `fail-open`), security-controls-mapping (`many-to-many`), risk-scoring-prioritisation (2); count in words in threat-modelling (`seven`); repeated answer in security-architecture-frameworks (q10 = q2).
- **Objectives/takeaways not 4 (6/8, [planner]):** threat-modelling 5/5, security-design-patterns 5/5, security-architecture-frameworks 6, security-engineering-principles 6, risk-scoring-prioritisation 6, ssdlc 5.
- **ID mismatch (hard rule [mechanical]):** risk-scoring-prioritisation PHP lacks task5 q7 that the CSV has.
- **Mixed US/British spelling across the module:** "threat modeling" (threat-modelling q1, ssdlc text), "defense in depth" (security-engineering-principles q1), "prioritized" (this flag) vs British slugs and titles. One convention should be set for the path.
- **Shared generic banner:** `banner-tcpip.png` is used by 4 of 6 Foundations rooms (threat-modelling, risk-driven, security-design-patterns, security-engineering-principles); only frameworks and controls-mapping have their own. Asset decision for the owner.

**Content overlap and contradiction within the Security Engineer Path:**
- **ssdlc (module 4) duplicates this room's core.** ssdlc task 4 "Threat Modelling" teaches the same STRIDE table (question and example columns), the same trust boundary definition, the same blueprint analogy, a DFD SVG, and its practical is a STRIDE-per-component mapping exercise. Its q6 answer is `trust boundary` (same as threat-modelling q10, near-identical question) and its q7 "Which STRIDE category corresponds to unauthorized access to sensitive data?" is almost word for word threat-modelling q4 (`Information Disclosure`). No factual contradiction, but the learner answers the same questions twice. Recommendation for the batch: this room keeps the full method (DFD elements, STRIDE-per-element, property violated, PASTA, attack trees, register); ssdlc keeps "where threat modelling sits in the SDLC" and points back to this room, and its q6/q7 are reworded so answers do not repeat across the path.
- **risk-driven-security-engineering (room 5)** teaches Risk = Likelihood x Impact (q3 "What two factors are multiplied together to produce a risk score?"), which threat-modelling q11 already asks without teaching it (item 20). Consistent formula, duplicated question. Once task 6 teaches the formula, risk-driven should build on it (FAIR, residual risk) rather than ask it again.
- **security-design-patterns, security-engineering-principles, security-architecture-frameworks, security-controls-mapping:** no threat modelling or STRIDE content; no overlap or contradiction. secure-code-review mentions trust boundaries in its review method, consistent with this room's definition. network-segmentation-dmz uses "trust boundaries" for zone tiers, also consistent.
- **risk-scoring-prioritisation (module 9):** vulnerability scoring (CVSS, EPSS, SSVC); no conflict with this room's Impact x Likelihood register.
- **Scope vs design doc:** threat-modelling matches its title line (STRIDE, PASTA, Attack Trees, trust boundaries, prioritised register) but under-delivers on "decomposing a system into components" and "enumerating threats against each component" (items 5, 7, 21, 26). Difficulty is below the doc's audience ("mid-level practitioners ready to move from operating security tools to engineering them") in both theory (recall and two-choice questions) and practical (item 7).
