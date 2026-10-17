# 06 File and Format Reference

This file expands `04-examples/format-notes.md` with measurements from the completed rooms in `output/` and the rules from real packets. Where the two disagree, the packet rules win. For example, `format-notes.md` lists "Advanced" as a difficulty, but the current label is **Expert**.

## Folder
```
<slug>/
  <slug>.php            theory page and task shell
  <slug>-practical.php  self-contained interactive lab
  <slug>-answers.csv    answer key
```

## `<slug>.php` sections (in order)
1. `$room_config`: id (= slug), title, description, icon (FontAwesome class, e.g. `fas fa-shield-halved`), banner (`../../assets/...png`), difficulty (Beginner, Intermediate or Expert), estimated_time (`"NN minutes"`), prerequisites[], learning_objectives[4].
2. `$answers_file = __DIR__ . '/<slug>-answers.csv';`
3. `$room_tasks`: sidebar list, `['id' => 'taskN', 'title' => '...']`.
4. `$js_config`: `storage_key` (`<slug_with_underscores>_progress`) and `instagram_takeaways` (4 strings starting with ✓).
5. `$task_questions_data`: `'taskN' => [ ['id' => 'qK', 'text' => '...'], ... ]`. q ids run continuously from q0.
6. `$task_contents[N] = <<<'HTML' ... HTML;`: content blocks with `content-block` div, `content-table` tables, `info-box` callouts, `<pre><code>` and inline SVG (each with an HTML comment explaining what it teaches). The Practical task has a `practical-launch-wrapper` link to `<slug>-practical.php` (target _blank).
7. Footer: `define('CYBRIXEN_ROOM_ENGINE', true); require_once '../../includes/room-engine.php';`

## `<slug>-practical.php`
- Starts with a PHP header setting `$page_title`, followed by one full HTML document with CSS and JS inline. No external JS libraries. Fonts: Inter and JetBrains Mono.
- Dark theme variables: `--bg-primary #0b0f1a`, `--bg-secondary #12182b`, `--bg-surface #161d36`, `--accent-primary #6ae3ff`, `--accent-secondary #8b7bff`, `--success #3dff9a`, `--error #ff5c5c`.
- Required parts: header with title and **View Tutorial** button, mission briefing card, tool area (tabs and panels, or a simulated app), submit or console area, flag area, and a tutorial overlay that opens on first visit (localStorage flag) and closes with Escape.
- The flag is sealed: an XOR byte array decoded with a key derived from the correct proof (see `02-templates/seal_flag.py`). The plain flag never appears in the source.

## `<slug>-answers.csv`
```
# FILENAME: <slug>-answers.csv
task1,q0,yes
taskN,qK,<answer>
...
taskP,qF,CBX{verb_noun}
taskLast,qZ,complete
```
There is no header row beyond the FILENAME comment, and no quotes unless the answer contains a comma (avoid that).

## Learning vs Challenge
| | Learning (Standard) | Challenge |
|---|---|---|
| Tasks | 5 to 9, usually 7: Introduction, 3 or 4 concepts, Practical, Conclusion | Exactly 3: Introduction, Investigation, Conclusion |
| Questions | 2 to 4 per concept task. Practical: 1 or 2 plus the flag | Investigation: 5 to 10, default 9 (Q9 = flag) |
| Typical CSV rows | about 14 to 17 (q0 to q15 in LIR-M03-R01) | 11 (q0 to q10) |
| Theory size (output/) | about 16 to 26 KB (format-notes: about 22 KB) | about 10 to 12 KB (format-notes: about 10 KB) |
| Practical size (output/) | about 38 to 69 KB (format-notes example: about 18 KB) | about 48 to 61 KB, up to 159 KB (format-notes: about 80 KB) |
| Practical shape | One simulated tool or decision console with a card deck | Multi-tab log analyser: tab per log source, filter bar, pagination, host inventory, inventory graph, response console |
| Est. time | 35 to 50 min | 60 to 90 min |
| Difficulty | Beginner or Intermediate (Expert possible) | Usually Expert |
| Example | linux-containment-eradication-and-recovery | zerologon-domain-takeover-investigation |

## Naming
- Slug: lowercase, hyphenated, matching the plan. Case rooms drop the `Case:` prefix (for example `Case: Zerologon Domain Takeover Investigation` becomes `zerologon-domain-takeover-investigation`).
- Room ID: `TRACK-Mxx-Ryy`.
- Flag: `CBX{verb_noun}`, lowercase.

## Synthetic data conventions
- Domain `cbx.lab`. Internal addresses come from RFC 1918, with a fresh /16 per room (for example 10.94.0.0/16). External addresses come from RFC 5737 (192.0.2.0/24, 198.51.100.0/24, 203.0.113.0/24).
- Neutral hostnames (srv##, ws##, prt##, or a real system name). No role words.
- All times in UTC. Ticket ids look like `IR-2026-NNNN`.
