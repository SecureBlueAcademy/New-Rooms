# Fix Brief: command-injection (Path QA round 1)

- **Room:** Command Injection (`command-injection`)
- **Folder:** `Platform Rooms/Junior Penetration Testing Path/Web Application Penetration Testing/command-injection/`
- **Files:** `command-injection.php`, `command-injection-practical.php`, `command-injection-answers.csv`
- **Input audit:** `audit-r1.md` (25 numbered items)
- **For:** Creator 2 (room-fixer). Apply in place. Do not change anything not listed here.
- **Planner:** Room Planner 2 | **Date:** 2026-10-17

## Identity that must NOT change
Keep every one of these exactly as they are now:
- Slug `command-injection`; file names all three; `$room_config['id'] = 'command-injection'`.
- Storage key `command_injection_progress`; tutorial first-visit key `command_injection_tutorial_seen`.
- Task ids `task1`..`task7`; question ids `q0`..`q13`; the flag value `CBX{command_injected}` (CSV q12).
- Difficulty stays `Intermediate`. Room title, banner, icon unchanged.
Answers change only where an item below says so. Everything else in the three files stays byte-for-byte unless an item names it.

---

# Part 1: Per-item instructions

## Item 1 - No auth guard [mechanical] -> not applied, platform
Not applied. Orchestrator correction in the audit: no live room in either path carries the auth guard, and the secure-code-review "finding" was a linter false positive on a simulated `auth.php` inside that room's lab. Do NOT add `require_once auth.php` to this live room. The guard that room-creator.md describes applies to new rooms only. Leave lines 1 to 3 as the plain `<?php // FILENAME ... ?>` header.

## Item 2 - Plain flag + no sealing [planner] -> apply per design below
The whole practical is redesigned (see Part 2). The flag `CBX{command_injected}` is sealed with `seal_flag.py` from two proof values and is never written in plain text or as a body fragment anywhere in either PHP file. Paste only:
- `CHECK_HASH = '103761911a42f0'`
- `SEALED_FLAG_HEX = 'd63b1b39c0f6a19ddc6b5f090e82d245158a9bceb6'`
Build the reveal element only after the proof check passes. Confirm with `grep -n "command_injected\|CBX{" command-injection-practical.php` returns nothing.

## Item 3 - Hint panel + tutorial step 4 [mechanical] -> apply as audited
Remove the Hint panel entirely: the `#hint-panel` and `#hint-panel strong` CSS rules (practical lines approx 200 to 212), the `<div id="hint-panel"> ... </div>` markup (approx 384 to 386), and the tutorial step that spotlights `hint-panel` (the 4th object in `tutorialSteps`, approx 521 to 524). The redesigned tutorial describes controls only (input, Run button, output, proof console); it never states a solution method.

## Item 4 - Coaching labels and congratulations in output [planner] -> apply per design below
Replace all output/status logic. The simulated terminal prints raw shell output only. No "Unexpected output (chained command executed):" label, no "What else might a file on this server contain?", no "Congratulations". The status line is neutral (for example "Done." or blank). Wrong proof in the proof console shows plain `Not yet.` and nothing else. Exact behaviour in Part 2.

## Item 5 - Difficulty below Intermediate [planner] -> apply per design below
This is the main redesign. Part 2 defines a simulated server filesystem with working `ls`, `ls -la`, `pwd`, `id`, `whoami`, `cat`; a naive input filter that blocks the obvious separators and forgets the pipe; decoy files with look-alike tokens; a non-obvious secret path; neutral output; and a proof console that unseals the flag from two values that can only be obtained by exploiting the tool.

## Item 6 - Skip opens the completion modal [mechanical] -> apply as audited (with the exact cause)
Cause: `document.getElementById('skip-tutorial-btn').addEventListener('click', endTutorial);` passes the click Event object as the first argument, so inside `endTutorial(showComplete)` the `showComplete` parameter is a truthy Event and the modal opens. Fix: wire Skip through a wrapper so no truthy value is passed:
```js
document.getElementById('skip-tutorial-btn').addEventListener('click', function () { endTutorial(false); });
```
Skip must close the tutorial (hide spotlight and tooltip, restore scroll) and must NOT open the completion modal. The Finish button keeps `endTutorial(true)`.

## Item 7 - Tutorial reopens, no first-visit flag [mechanical] -> apply as audited
On load, auto-open the tutorial only when `localStorage.getItem('command_injection_tutorial_seen')` is absent. When the tutorial ends (Finish, Skip, or Escape) set `localStorage.setItem('command_injection_tutorial_seen', '1')` inside a try/catch. The **View Tutorial** button always replays regardless of the flag. Use the key string exactly: `command_injection_tutorial_seen`.

## Item 8 - Escape does not close [mechanical] -> apply as audited
Add a `keydown` listener: when `e.key === 'Escape'` and the tutorial is open, call `endTutorial(false)` (close spotlight and tooltip, restore scroll, do NOT open the completion modal). If the completion modal is open, Escape also closes it and restores scroll.

## Item 9 - Background scrolls behind tutorial [mechanical] -> apply as audited
While the tutorial OR the completion modal is open, set `overflow: hidden` on both `document.documentElement` and `document.body`; restore the prior value on close. Verify on phone width that `scrollY` cannot change while the overlay is open.

## Item 10 - Phone spotlight/tooltip separated [mechanical] -> apply as audited (with precise detail)
At phone width (test 390px) the tooltip is pushed far below the spotlight after the smooth scroll settles. Position the spotlight and the tooltip only AFTER the scroll has finished, and anchor the tooltip to the element's post-scroll rect. Practical steps: increase the post-`scrollIntoView` delay (or listen for scroll end) before calling `positionSpotlight`/`positionTooltip`; in `positionTooltip`, when the tooltip would sit off-screen, clamp it to the viewport so the Next and Skip buttons are fully on screen and not covered at 390px and at 1366px. Reposition on `scroll` as well as `resize`.

## Item 11 - Flag panel never hides [planner] -> apply per design below
The reveal is bound to the proof console, not the terminal. Clear the reveal (remove `.visible`, empty its text) whenever either proof input changes (`input` event), whenever a new diagnostic check runs, and on Reset. The flag is shown only immediately after a passing proof submission.

## Item 12 - Em dash in theory [mechanical] -> apply as audited
Theory `command-injection.php`, the END OF DATA comment (approx line 384). Replace the em dash (U+2014) with a hyphen. Exact replacement line:
```php
// END OF DATA - engine renders everything from here.
```
Run `grep -nP "\x{2014}" command-injection.php` to confirm zero matches afterwards.

## Item 13 - Missing white-command style line [mechanical] -> apply as audited
Add the white-command style line as the FIRST line inside the `$task_contents[1]` heredoc, before `<div class="content-block">`. Exact text:
```html
<style>.task-body code, .task-body pre, .task-body pre code { color: #ffffff; }</style>
```
Add no other colour rules. This makes the code in tasks 3, 4, 5 and 7 render white instead of `--primary` blue.

## Item 14 - q2 question contains answer strings [planner] -> apply exact wording
q2 answer stays `sanitization`. Replace the q2 `text` with (no answer string, no "system", no "injection"):
> What processing must user input undergo before it is placed in a shell command?

Teach the term in task 2 (see Part 3 theory edits) so "sanitization" is taught before it is asked.

## Item 15 - q3 question hands the answer [planner] -> apply exact wording + new answer
See Item 16: q3 answer changes to `A03 injection`. Replace the q3 `text` with (contains no "injection", no "command injection", no "SQL injection", no "A03"):
> Two attacks that abuse untrusted input, one against the shell and one against the database, are grouped under which OWASP Top 10 2021 category? Answer with its code and name.

## Item 16 - q3 answer thin/duplicative [planner] -> change answer to `A03 injection`
Old answer `injection` duplicates the q1/q2 theme and is thin. New q3 answer: `A03 injection` (two words, no comma, no slash, no hyphen, letters and digits, unique in the room). Update the CSV row to `task2,q3,A03 injection`. Teach it in task 2 (Part 3).

## Item 17 - q6 question repeats "command injection" [planner] -> apply exact wording
Replace the q6 `text` with (drops the phrase "command injection"):
> Which kind of validation, when it is the only defense, can be bypassed by the attacker and therefore fails to stop this attack?

## Item 18 - q6 answer hyphenated [planner] -> change answer to `browser validation`
Old answer `client-side validation` is hyphenated (hyphens are reserved for real cmdlet names) and the hyphen/space form is ambiguous to type. New q6 answer: `browser validation` (two words, no hyphen, one natural form, unique). Update the CSV row to `task3,q6,browser validation`. Teach it in task 3 (Part 3): the warning box names browser validation explicitly.

## Item 19 - q7/q8/q9 symbol-only answers [planner] -> reshape to word answers
Symbols are shown in the question, the answer is the operator name in words. The symbols move into the question text, never the answer. New wording and answers:
- q7 answer `semicolon`. Text:
  > A shell operator written as `;` runs a second command regardless of whether the first command succeeds. What is the name of this operator, in words?
- q8 answer `logical and`. Text:
  > A shell operator written as `&&` runs a second command only when the first command succeeds. What is this operator called, in words?
- q9 answer `pipe`. Text:
  > A shell operator written as `|` sends the output of the first command into the second command as its input. What is this operator called?

Update CSV rows to `task4,q7,semicolon` / `task4,q8,logical and` / `task4,q9,pipe`. None is symbol-only, hyphenated, comma'd or slashed; each is 1 to 2 words and unique. The operator NAMES are taught in task 4 via a new Name column (Part 3). Note: `pipe` is the operator the lab filter forgets, so it is reinforced by both the theory and the practical; it is a CSV answer only, never a proof field, so there is no duplicate.

## Item 20 - Objectives count 4 vs 5 [planner] -> trim task 1 body to 4
`$room_config['learning_objectives']` lists 4. The task 1 body `<ul>` lists 5. Remove the 5th bullet so both lists hold the same 4 objectives. Replace the task 1 `<ul>` with exactly:
```html
    <ul>
        <li>Explain what command injection is and why it occurs.</li>
        <li>Identify PHP functions that execute OS commands.</li>
        <li>Recognize shell operators used to chain commands.</li>
        <li>Apply a systematic method to test for injection points.</li>
    </ul>
```
(The deleted line was "Exploit a simulated vulnerable tool to retrieve a hidden flag.") The task 7 Key Takeaways list is separate and was not flagged; leave its five bullets.

## Item 21 - Flag plaintext in CSV [planner] -> note only, no CSV change
Correct. The CSV keeps `task6,q12,CBX{command_injected}` for engine grading. The requirement is only that the same value never also lives in the practical source, which Item 2 handles. No action on the CSV flag row.

## Item 22 - Engine returns correct_answer on wrong answer [platform] -> not applied, platform
Not applied. Engine-level issue (q12 could be read without solving); needs a platform fix, cannot be fixed inside the room.

## Item 23 - Placeholder masks only alphanumerics [platform] -> not applied, platform
Not applied. The room-level remedy is the q7/q8/q9 rewrite in Item 19 (word answers, no symbol-only answers), which is applied.

## Item 24 - rooms-style.css renders code blue [platform] -> not applied, platform
Not applied. The room-level remedy is the white-command style line in Item 13, which is applied.

## Item 25 - engine treats "/" as alternatives [platform] -> not applied, platform
Not applied. No answer uses `/`. All rewritten answers in Items 14 to 19 avoid `/`.

---

# Part 2: Practical redesign (the `[planner]` core: Items 2, 4, 5, 11)

**Goal.** A realistic Intermediate command-injection lab: a simulated Network Diagnostics Tool whose "ping" feature concatenates user input into a shell command. The learner must notice a naive character filter, find the operator it forgot, enumerate a small server filesystem, read a secret from a non-obvious hidden file while ignoring decoy tokens, and then submit two proof values that unseal the flag.

Keep the page identity: title "Network Diagnostics Tool", header "Internal IT Connectivity Checker", the house dark theme variables already in the file, Inter + JetBrains Mono. Single self-contained PHP file, no external JS.

### 2.1 Simulated server (embedded JS data only)
The app "runs" as the service account **`svcdiag`** in working directory **`/var/www/netdiag`**. Model the filesystem as a small JS object so `ls`, `ls -la`, `pwd`, `id`, `whoami` and `cat <path>` return plausible output. Use these exact contents (synthetic only):

- `whoami` -> `svcdiag`
- `id` -> `uid=1012(svcdiag) gid=1012(svcdiag) groups=1012(svcdiag),27(sudo-denied)` (keep it plain; no coaching)
- `pwd` -> `/var/www/netdiag`
- `ls` (cwd) -> `config.php  index.php  ping.php  style.css  uploads`
- `ls -la` (cwd) -> a normal long listing of those entries plus `.` and `..` (no hidden secret in cwd)
- `ls /opt/netdiag` -> `backups  bin` (the `.env` is hidden, so plain `ls` does NOT show it)
- `ls -la /opt/netdiag` -> long listing that DOES include `.env` (this is how the learner discovers the secret file; justifies teaching `ls -la`)
- `ls /var/backups` -> `netdiag.bak`
- `cat /etc/passwd` -> several accounts so no single line stands out, e.g. lines for `root`, `daemon`, `www-data`, `backupsvc`, `deploy`, and `svcdiag` (the running account is identified cleanly by `whoami`/`id`, not by reading passwd)

Files and their contents (tokens are look-alikes on purpose):
- `config.php` (cwd, decoy) -> a short PHP snippet containing `$DB_TOKEN = "orion1193";` and a DB host line. This is a tempting but WRONG token (it is a database token, not the diagnostics API token).
- `/var/backups/netdiag.bak` (decoy) -> an older config dump containing `DIAG_API_TOKEN=orion1193` (same stale value as the DB decoy; a learner who stops at backups gets the wrong value).
- `/home/svcdiag/notes.txt` (decoy) -> `TODO: rotate DIAG_API_TOKEN before audit; staging value is orion8846`.
- `/opt/netdiag/.env` (**the real secret**, hidden dotfile) -> two lines:
  ```
  DIAG_ENV=production
  DIAG_API_TOKEN=orion5521
  ```
- `ping.php`, `index.php`, `style.css` -> plausible benign source/content, no tokens.

The real proof token is **`orion5521`**, reachable only by `cat /opt/netdiag/.env` after discovering the file with `ls -la /opt/netdiag`. Three look-alike `orion####` tokens live in decoy files, so `Ctrl+F "orion"` in the page source returns several and the learner must determine which file is authoritative. The flag never appears in any file content; files hold tokens only.

### 2.2 The naive filter and the forgotten operator
Before "running" the command, the tool screens the raw input. It rejects any input containing `;`, `&`, or a backtick `` ` ``. It does NOT screen the pipe `|`. So:
- `8.8.8.8; whoami` -> rejected
- `8.8.8.8 && whoami` -> rejected (contains `&`)
- `8.8.8.8 | whoami` -> accepted; `whoami` executes

Rejected input shows a neutral line only, no coaching: `Invalid characters in hostname. Use a hostname or IP address.` and the status line stays neutral. This is a realistic incomplete blacklist: the developer blocked the two "command chaining" operators and overlooked that the pipe is also a separator. The pipe is the taught bypass (it is in the task 4 operator table and is q9). Technically accurate: `ping <host> | whoami` still executes `whoami`; the pipe merely feeds ping's stdout to the second command's stdin, which `whoami`, `id`, `ls`, `pwd` and `cat <file>` all ignore, so each still produces its normal output.

### 2.3 Input handling and output rendering
Parse the trimmed raw input:
1. Empty -> status `Enter a hostname or IP address first.`, no output.
2. Contains a blacklisted character (`;`, `&`, `` ` ``) -> print the rejection line above; do not run anything.
3. Contains `|` -> split on the FIRST `|` into `hostPart` and `cmdPart`. Render the baseline ping block for `hostPart` (reuse the existing `buildBaselineOutput`, trimming the host), then on the next lines render the simulated output of `cmdPart` resolved against the filesystem in 2.1. Unknown command -> `bash: <cmd>: command not found`. `cat` of a missing path -> `cat: <path>: No such file or directory`.
4. No operator -> baseline ping only; status `Done.`

All output is plain terminal text in `#output-panel`. No `.unexpected-block`, no `.label`, no `.flag-line`, no congratulatory text. Remove those CSS rules and that branch. Keep `escapeHtml`. The terminal NEVER prints the flag.

### 2.4 Proof console (replaces the auto-reveal)
Add a small "Submit proof" card (reuse the house `.card` / input styles). Two text inputs in this order:
- Field 1 label: **Service account the diagnostic command runs as**  (id `proof-account`)
- Field 2 label: **DIAG_API_TOKEN value from the production environment file**  (id `proof-token`)

A **Submit** button and a **Reset** button. On Submit, normalise each field exactly as `seal_flag.py` does (trim, lowercase, collapse internal whitespace), join with `|`, and compare `cyrb53(key, 7).toString(16)` to `CHECK_HASH`. Use the cyrb53/unseal functions verbatim from `kit/02-templates/learning-room-practical.php.template`.
- Match -> set the reveal text to `unseal(SEALED_FLAG_HEX, key)` and show the reveal element. Status `Accepted.`
- No match -> feedback text exactly `Not yet.` in `--error`; reveal stays hidden. Nothing else (no per-field marks, no counts).

Reveal clears (remove `.visible`, empty text) on any `input` in either proof field, on any new diagnostic run, and on Reset (Item 11). Reset also clears both proof fields, the terminal output back to its placeholder, and the status line.

### 2.5 Honest limitation (state in fix-notes, not in the room)
Any browser-only lab can be reverse-engineered by a determined reader: the filesystem data and the mapping from command to output live in the embedded JS, so someone reading the source can trace which `cat` yields `orion5521` and can read `svcdiag`. The design goal is met regardless: the flag itself is never present in source in any form (it is XOR-sealed), and it cannot be produced without the exact proof pair, because that pair is the decryption key. The look-alike tokens and the hidden-dotfile path mean the values cannot be lifted from one obvious string; they must be resolved through the right commands.

---

# Part 3: Theory edits (`command-injection.php`), verbatim

### 3.1 Task 1 - add white-command style (Item 13) and trim objectives (Item 20)
Insert the style line (Item 13) as the first line inside the `$task_contents[1]` heredoc, immediately before `<div class="content-block">`:
```html
<style>.task-body code, .task-body pre, .task-body pre code { color: #ffffff; }</style>
```
Replace the task 1 `<ul>` with the 4-item list given in Item 20.

### 3.2 Task 2 - teach sanitization and the OWASP category (Items 14, 16)
In the paragraph that begins "Command injection is a vulnerability...", after "...without being checked or cleaned first.", append this sentence:
> This checking and cleaning of untrusted input before it is used is called <strong>sanitization</strong>.

Replace the "Command Injection in Context" paragraph with:
```html
    <p>Command injection belongs to a broader family of flaws known as <strong>injection</strong> vulnerabilities, where untrusted input is treated as trusted instructions. One kind targets the operating system shell and another targets a database query. In the OWASP Top 10 for 2021 these grouped flaws are ranked together as category <strong>A03 Injection</strong>.</p>
```
This teaches `sanitization` (q2) and `A03 injection` (q3) before they are asked, and it no longer contains the phrases "command injection" or "SQL injection" next to the answer.

### 3.3 Task 3 - teach browser validation (Item 18)
Replace the warning box paragraph that currently reads "Checking input in the browser with JavaScript does nothing to stop this. Client-side validation can always be bypassed..." with:
```html
        <p>Checking input only in the browser with JavaScript does nothing to stop this. Validation that runs only in the browser, known as <strong>browser validation</strong>, can always be bypassed, so the shell still receives whatever the attacker actually sends to the server.</p>
```
This teaches `browser validation` (q6) and removes the hyphenated term.

### 3.4 Task 4 - add a Name column so q7/q8/q9 are taught (Item 19)
Add a `Name` column to the operator table so each operator's word name is taught before q7 to q9 ask for it. Replace the table head and body with:
```html
        <thead>
            <tr>
                <th>Operator</th>
                <th>Name</th>
                <th>Shell</th>
                <th>Behavior</th>
            </tr>
        </thead>
        <tbody>
            <tr><td><code>;</code></td><td>semicolon</td><td>Linux/Unix</td><td>Runs the second command regardless of whether the first command succeeded.</td></tr>
            <tr><td><code>&amp;&amp;</code></td><td>logical AND</td><td>Linux/Unix</td><td>Runs the second command only if the first command succeeded.</td></tr>
            <tr><td><code>||</code></td><td>logical OR</td><td>Linux/Unix</td><td>Runs the second command only if the first command failed.</td></tr>
            <tr><td><code>|</code></td><td>pipe</td><td>Linux/Unix</td><td>Sends the output of the first command as input to the second.</td></tr>
            <tr><td><code>&amp;</code></td><td>ampersand</td><td>Windows</td><td>Runs the second command after the first, similar to the semicolon on Linux.</td></tr>
        </tbody>
```
Keep the existing "Attacker Tip" warning box about the pipe; it stays accurate and now supports the lab.

### 3.5 Task 5 - teach the systematic test and the bypass idea (Item 5 support)
Keep the existing systematic-testing checklist. After the existing `<ul>` of test steps, add one paragraph that teaches the filter-bypass concept WITHOUT naming the pipe as this lab's answer:
```html
    <p>Some tools try to defend themselves by rejecting a blacklist of known separator characters. Blacklists are fragile: if even one separator is left off the list, that operator still reaches the shell and the chaining works. When one operator is rejected, test the others one by one until you find the one the filter forgot.</p>
```
This teaches the learner to try each operator (the discovery the audit's "systematic testing" promise requires) without handing over which operator this tool missed.

### 3.6 Task 6 - practical brief wording (optional polish)
The existing task 6 brief is fine. Optionally tighten the second paragraph to match the new lab, but no answer or method may appear. Leave the launch button and note unchanged.

### 3.7 Item 12 - em dash
Fix the END OF DATA comment as in Item 12.

---

# Part 4: Complete new CSV (`command-injection-answers.csv`)
Replace the file contents with exactly:
```
# FILENAME: command-injection-answers.csv
task1,q0,yes
task2,q1,command injection
task2,q2,sanitization
task2,q3,A03 injection
task3,q4,system
task3,q5,concatenation
task3,q6,browser validation
task4,q7,semicolon
task4,q8,logical and
task4,q9,pipe
task5,q10,payload
task5,q11,injection point
task6,q12,CBX{command_injected}
task7,q13,complete
```
Changed rows: q3 (`injection` -> `A03 injection`), q6 (`client-side validation` -> `browser validation`), q7 (`;` -> `semicolon`), q8 (`&&` -> `logical and`), q9 (`|` -> `pipe`). All others unchanged. Every answer is 1 to 2 words, one natural form, no comma, no `/`, not symbol-only, no non-cmdlet hyphen, and unique in the room.

---

# Part 5: Proof fields, seal command, and solve.json

### 5.1 Proof field order and values
1. Service account the injected command runs as: **`svcdiag`**  (from `| whoami` or `| id`)
2. DIAG_API_TOKEN from the production environment file: **`orion5521`**  (from `| cat /opt/netdiag/.env`)

### 5.2 Exact seal command (run from repo root)
```
python3 kit/02-templates/seal_flag.py "CBX{command_injected}" "svcdiag" "orion5521"
```
Paste the result (already computed and verified by the Planner):
```
CHECK_HASH      = 103761911a42f0
SEALED_FLAG_HEX = d63b1b39c0f6a19ddc6b5f090e82d245158a9bceb6
```
Verified: key `svcdiag|orion5521` unseals to `CBX{command_injected}`; the decoy token `orion1193` fails the check and unseals to garbage.

### 5.3 solve.json (traps and expected solve)
Write `pipeline/path-qa/junior-penetration-testing-path/command-injection/solve.json` for `check_practical.cjs`. Encode:

**solve** (reveals the flag):
1. fill `#hostname-input` with `8.8.8.8 | whoami`, click Run -> output contains `svcdiag`.
2. fill `#hostname-input` with `8.8.8.8 | ls -la /opt/netdiag`, click Run -> output contains `.env`.
3. fill `#hostname-input` with `8.8.8.8 | cat /opt/netdiag/.env`, click Run -> output contains `orion5521`.
4. fill `#proof-account` with `svcdiag`, fill `#proof-token` with `orion5521`, click Submit.
   expectText `CBX{command_injected}`.

**traps** (flag must stay hidden, feedback `Not yet.`):
- "decoy token": proof `svcdiag` + `orion1193` (the config.php / backup value) -> hidden.
- "stale staging token": proof `svcdiag` + `orion8846` (the notes.txt value) -> hidden.
- "wrong account": proof `root` + `orion5521` -> hidden.
- "filtered operator": fill `#hostname-input` with `8.8.8.8; whoami`, click Run -> output contains `Invalid characters`, no `svcdiag`, flag hidden.

**reset** (after a solve): click `#proof-reset` (or the Reset button) -> `expectHidden` `CBX{command_injected}`; both proof fields and the terminal are cleared.

---

# Part 6: Planner checks
- **PHP exec functions (task 3 table).** Confirmed accurate and unchanged: `system()` executes via the shell and sends output straight to the output buffer (returns the last output line); `shell_exec()` executes via the shell and returns the entire output as a string (null on no output); `exec()` executes and returns only the last line, with full output available in the array argument, printing nothing by itself; `passthru()` executes and streams raw output directly to the browser. No change needed.
- **Operator semantics.** `;` sequential unconditionally; `&&` runs second only on success (exit 0); `||` runs second only on failure (non-zero exit); `|` pipes stdout to stdin; Windows cmd `&` runs the second command after the first unconditionally. The task 4 table (with the new Name column) matches this. The lab's claim that `ping host | whoami` still runs `whoami` is correct: the pipe delivers ping's stdout to the second command's stdin, which `whoami`, `id`, `ls`, `pwd` and `cat <file>` ignore, so each produces normal output.
- **Filter realism.** A blacklist of `;`, `&`, backtick that omits `|` is a realistic incomplete filter; the pipe bypass is taught (table + q9) and discoverable by systematic testing (task 5), matching the design-doc scope "identify and test injection points systematically."
- **No em dashes** in this brief (hyphens only). **No Free/Paid wording.** All data synthetic (`cbx.lab`-style, RFC 1918 host context, no real organisations or working exploit code). Flag sealed; plain flag and body absent from the practical after the fix.
- **Answers** all satisfy the house rules (checked in Part 4).

## Orchestrator amendments (Content Engineer, 2026-10-17). These override the sections above.

A1. Item 1 (auth guard) IS applied. The audit correction meant that no live room has the guard yet, not that it is a platform issue. Add the guard from `.claude/agents/room-creator.md` as the first PHP lines of `command-injection-practical.php`:
```php
<?php
// FILENAME: command-injection-practical.php
require_once __DIR__ . '/../../includes/auth.php';
if (!$auth->isLoggedIn()) { $auth->redirectToLogin(); }
?>
```

A2. Items 15 and 16 (q3). Do not use `A03 injection`: A03 is the 2021 numbering and Injection is A05 in the OWASP Top 10 2025, so a number will go stale. Replace the q3 question text with exactly: "Two attacks that abuse untrusted input, one against the shell and one against the database, are grouped under which OWASP Top 10 risk category? (one word)". Keep the CSV answer as `injection` (`task2,q3,injection`). In the task 2 teaching paragraph (section 3.2) replace the sentence "In the OWASP Top 10 for 2021 these grouped flaws are ranked together as category <strong>A03 Injection</strong>." with "The OWASP Top 10 groups these flaws into a single risk category named <strong>Injection</strong>." Make sure no other question text in the room contains the word "injection" next to q3's answer in a way that gives it away.

APPROVED by Room Planner 2026-10-17
