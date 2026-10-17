# Path QA audit, round 1: command-injection

- **Room:** Command Injection (`command-injection`)
- **Folder:** `Platform Rooms/Junior Penetration Testing Path/Web Application Penetration Testing/command-injection/`
- **Path / module:** Junior Penetration Testing Path, module 4 "Web Application Penetration Testing", room 6 of 8
- **Difficulty (config):** Intermediate. Learning room, 7 tasks, 14 questions, flag `CBX{command_injected}` (task6 q12)
- **Date:** 2026-10-17
- **Auditor:** Path QA (under the QA lead)
- **Verdict:** FAIL.

## Tool summary
- `lint_room.py`: 7 FAIL, 10 WARN. FAIL: em dash (theory line 384); plain flag in practical (line 392); flag body in source; flag not sealed (no CHECK_HASH / SEALED_FLAG_HEX); no `Not yet.` feedback; Hint element (lines 384 and 385). WARN: hyphenated answer q6; answer strings inside q2, q3, q6 question text; no auth guard; no Escape close; no first-visit flag.
- `check_theory.cjs`: 0 fail, 12 warn. Every `<code>`/`<pre><code>` in tasks 3, 4, 5 and 7 renders blue `rgb(0,102,255)`, not white. Engine wrong-answer text is `Incorrect. Try again.`. Completion modal works.
- `check_practical.cjs`: 8 FAIL. Page opens without login (HTTP 200). Plain flag and flag body in served source. Desktop and phone: tutorial reopens after finishing and Escape does not close it. Phone: page behind tutorial scrolls (scrollY=265).
- Manual probe (Playwright, screenshots under `/tmp/cbx-shots/command-injection/practical/probe-*`): Skip Tutorial opens the "Tutorial Complete" modal; the solve accepts all five chaining operators with no filtering; enumeration commands return "Command not recognized"; the required file name must be guessed; once revealed the flag panel never hides again.
- Screenshots read: `/tmp/cbx-shots/command-injection/theory/*.png`, `/tmp/cbx-shots/command-injection/practical/*.png`.

## Learner solve (for reference)
- Theory: yes, command injection, sanitization, injection, system, concatenation, client-side validation, `;`, `&&`, `|`, payload, injection point, flag, complete.
- Practical: chain any extra command after the address using any supported operator; the required file name has to be guessed because enumeration does not work. Flag prints in the output and a reveal panel.

## Issues

### A. Practical (`command-injection-practical.php`)

1. **hard rule [mechanical]** lines 1 to 3. No auth guard; the page opens logged out. Expected: the standard `auth.php` require + `redirectToLogin()` guard as the first lines (per room-creator.md and CLAUDE.md). Orchestrator correction: no live room has this guard; secure-code-review only shows a simulated file named auth.php inside its lab.

2. **hard rule [planner]** line 392 (`flag-value` div) and line 468 (JS string). Plain flag and flag body sit in the DOM and JS, so View Source / Inspect Element / Ctrl+F reveals it without solving; the flag is not sealed. Expected: Planner defines proof fields from the solve, seals with `kit/02-templates/seal_flag.py`, and the reveal is built only after the proof check passes. No plain flag or body anywhere in the file.

3. **hard rule [mechanical]** `#hint-panel` (CSS lines 200 to 212; markup lines 384 to 386) and tutorial step 4 (lines 521 to 524). A permanent Hint panel states the solution method, and the tutorial spotlights it. Expected: remove the hint panel, its CSS and tutorial step 4; the tutorial should describe controls only.

4. **hard rule [planner]** output/status logic (lines 460 to 488). Simulated terminal output carries coaching labels and congratulatory sentences ("Unexpected output (chained command executed):", "What else might a file on this server contain?", "Congratulations..."). Expected: realistic shell output only, no labels; a neutral status line; wrong proof answered with plain `Not yet.`.

5. **quality [planner]** whole lab. Difficulty is below Intermediate: no input filtering at all, every operator accepted, and no working enumeration, so the only challenge is guessing a file name. Expected: Planner raises difficulty to match the module (a small simulated filesystem with working list/read commands, the secret on a non-obvious path, a filter that forces a taught bypass, decoys, proof-based sealing).

6. **hard rule [mechanical]** tutorial, `endTutorial` (lines 585, 602 to 608). Clicking Skip Tutorial calls `endTutorial` with no argument, but the finish button passes `true`; because the Skip handler is wired the same way as other siblings, Skip currently opens the "Tutorial Complete" modal. Expected: Skip closes the tutorial and does NOT open the completion modal.

7. **hard rule [mechanical]** tutorial reopen (lines 626 to 628). The tutorial auto-opens on every `load` with no first-visit flag, so it reopens after it was finished and after reload. Expected: set a `localStorage` first-visit flag; auto-open only when it is absent; the View Tutorial button always replays.

8. **hard rule [mechanical]** Escape handling (script block). No `keydown`/Escape listener, so Escape does not close the tutorial. Expected: Escape ends the tutorial (spotlight and tooltip hidden, no completion modal).

9. **hard rule [mechanical]** scroll lock (tutorial start/end). The page behind the tutorial scrolls (phone scrollY=265; `document.body` overflow stays `visible`). Expected: lock background scroll while the tutorial or completion modal is open and restore it on close.

10. **quality [mechanical]** phone spotlight/tooltip (observed on `probe-phone-step3/4`). On steps 3 and 4 the tooltip is pushed far below the spotlighted element after the smooth-scroll settles, so spotlight and tooltip are visually separated. Expected: tooltip anchored next to its target at phone width after scrolling completes.

11. **quality [planner]** flag panel never hides. Once `flag-reveal` gets `.visible` it stays; re-running a normal ping does not clear it. Expected: the reveal clears when input changes or a fresh non-solving check runs (consistent with "practical should not show flag until solved").

### B. Theory (`command-injection.php`)

12. **hard rule [mechanical]** line 384. Em dash (U+2014) in the end-of-data comment. Expected: replace with a hyphen or rewrite. (House rule: no em dashes anywhere.)

13. **hard rule [mechanical]** missing white-command style line. Task 1 content lacks the `<style>.task-body code, .task-body pre, .task-body pre code { color:#ffffff; }</style>` line, so all code in tasks 3, 4, 5, 7 renders `--primary` blue. Expected: add the style line in task 1 so commands and parameters render white.

14. **hard rule [planner]** task2 q2 (`sanitization`), question text at line 64. The text "What must user input undergo before being used in a system command, to prevent injection?" contains "system" (answer to q4) and "injection". Expected: reword so no answer string appears, e.g. "What processing must user input undergo before it is placed in a shell command?".

15. **hard rule [planner]** task2 q3 (`injection`), line 65. Question names "command injection and SQL injection", handing the one-word answer. Expected: reword, e.g. "Command injection and SQL injection both belong to which broad OWASP vulnerability class?".

16. **quality [planner]** task2 q3 answer `injection`. The OWASP Top 10 category is "Injection" (A03:2021); the one-word answer is acceptable but thin and duplicates the q1/q2 theme. Consider "A03 Injection" or similar so it is unambiguous and distinct.

17. **hard rule [planner]** task3 q6 (`client-side validation`), line 70. Text "What type of validation, if relied on alone, fails to protect against command injection?" repeats "command injection". Expected: reword to drop the phrase.

18. **quality [mechanical]** task3 q6 answer `client-side validation` is hyphenated; the house rule reserves hyphens for real cmdlet names. Expected: Planner picks a non-hyphenated form (e.g. "browser validation" or "client side validation") and updates CSV + question.

19. **quality [planner]** task4 answers `;`, `&&`, `|` (q7, q8, q9). These are symbol-only answers. The engine's placeholder masks only letters/digits, so the symbols show in the input box (visible in `theory-task4.png`) and the answer is given away; symbol-only answers also break the house answer rule. Expected: Planner reshapes q7 to q9 so answers are words (e.g. ask for the operator name: "semicolon", "logical AND", "pipe") with the symbols shown in the question, not as the answer.

20. **quality [planner]** learning objectives count. Config lists 4 objectives but task 1 body lists 5 (adds "Exploit a simulated vulnerable tool..."). Expected: align the two lists (siblings vary; the kit expects 4).

21. **quality [planner]** CSV has no FILENAME-less drift but note: flag stored as plaintext `CBX{command_injected}` in the CSV is correct for grading, but the same value must not also live in the practical source (see item 2).

### C. Platform issues (report only, do not fix in the room)

22. **[platform]** `room-engine.php` returns `correct_answer` in the JSON reply even on a wrong answer, so any theory answer (including the task6 flag) is readable with one request. Concretely for this room: q12 returns the flag without solving the lab. Needs a platform fix.

23. **[platform]** the engine placeholder masks only `[a-zA-Z0-9]`, so symbol answers render in the box. Concretely here this exposes q7/q8/q9 (`;`, `&&`, `|`). Because it cannot be fixed in the engine, it becomes the **[planner]** rewrite in item 19.

24. **[platform]** `rooms-style.css` renders `<code>` in `--primary` blue. This is the root cause behind item 13; the room-level fix is the white-command style line.

25. **[platform]** the engine treats `/` in an answer as alternatives. No current answer uses `/`, so no impact this room, but any rewrite (items 14 to 19) must avoid `/`.

## Counts
- By severity: 14 hard rule, 11 quality (25 numbered items; items 22 to 25 are the 4 platform notes).
- By tag: [mechanical] 9 (items 1, 3, 6, 7, 8, 9, 10, 12, 13, 18); [planner] 11 (items 2, 4, 5, 11, 14, 15, 16, 17, 19, 20, 21); [platform] 4 (items 22 to 25); [user] 0.

## Shared across the paths
Ran `lint_room.py --json` over all 8 Web Application Penetration Testing rooms and all 5 Application Security Engineering rooms (13 total). Theme is consistent everywhere (`--bg-primary #0b0f1a`, accents `#6ae3ff`/`#8b7bff`, Inter + JetBrains Mono, banner `banner-tcpip.png` on most). Shared defects, worth batching:

- **Flag never sealed (13/13, hard rule [planner]):** every practical in both modules ships the plain flag and flag body in source and lacks `seal_flag.py` output. Platform-wide remediation.
- **No `Not yet.` wrong-answer feedback (13/13, hard rule):** practicals either congratulate or coach instead of the plain `Not yet.`.
- **Tutorial: no Escape close and no first-visit flag (13/13, [mechanical]):** none of the 13 close on Escape or keep a first-visit flag; all auto-reopen.
- **No auth guard (13/13, [mechanical]):** none of these rooms has the guard (orchestrator correction: secure-code-review was a linter false positive on a simulated `auth.php` file in its lab; the linter is fixed). Use the guard from room-creator.md.
- **Skip opens completion modal ([mechanical]):** command-injection, cross-site-scripting, idor, xxe-ssrf and api-security-engineering share the `endTutorial` wiring where Skip triggers the "complete" modal.
- **Wrong CSV header (12/13, [mechanical]):** only command-injection uses the kit header `# FILENAME: command-injection-answers.csv`; the rest start with `task1,q0,yes` or a bare `# <slug>-answers.csv`. Command-injection is the correct convention here.
- **Answer string in question text (10/13, [planner]):** widespread; the lint flags the same pattern in command-injection q2/q3/q6.
- **Hyphenated non-cmdlet answers (7/13, [planner]):** command-injection `client-side validation`, plus cross-site-scripting, directory-traversal, sql-injection, web-app-architecture, xxe-ssrf, devsecops-engineering.
- **Em dashes (8/13, hard rule [mechanical]):** command-injection line 384 and 7 others.
- **4-vs-5 learning objectives / takeaways mismatch (several):** auth-session-attacks, idor, sql-injection, xxe-ssrf, ssdlc, api-security, container-k8s.
- **authentication-session-attacks slug mismatch:** theory file is `authentication-session-attacks.php` while the id/other files use `auth-session-attacks` (naming [mechanical]/[user] for the live file rename).

**Content overlap with secure-code-review (Security Engineer Path):** that room teaches the taint source -> sink model and lists SQL injection, type juggling and insecure deserialization as its high-risk patterns; it does NOT teach command injection or `system()`/`shell_exec()`. So there is no contradictory or duplicated command-injection teaching across the two paths. The overlap is only the shared "untrusted input reaching a dangerous sink" framing, which is complementary, not conflicting. The command-injection room matches its design-doc scope ("PHP-simulated ping utility vulnerable to command chaining, identify and test injection points systematically"), except the lab does not actually support the "systematic testing" it promises (item 5).
