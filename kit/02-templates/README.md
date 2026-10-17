# 02-templates

Starter files for one Cybrixen room. Every room is a folder with 3 files: `<slug>.php`, `<slug>-practical.php`, `<slug>-answers.csv`.

| Template | Becomes | Room type |
|---|---|---|
| `learning-room-page.php.template` | `<slug>.php` | Learning: 7 tasks (Introduction, 3 or 4 concept tasks, Practical, Conclusion) |
| `learning-room-practical.php.template` | `<slug>-practical.php` | Learning: one-file lab with tutorial, brief, tool area, card deck, submit and sealed flag |
| `learning-room-answers.csv.template` | `<slug>-answers.csv` | Learning |
| `challenge-room-page.php.template` | `<slug>.php` | Challenge: 3 tasks (Introduction, Investigation with 9 questions, Conclusion) |
| `challenge-room-practical.php.template` | `<slug>-practical.php` | Challenge: multi-tab log analyser with filters, pagination, inventory, response console |
| `challenge-room-answers.csv.template` | `<slug>-answers.csv` | Challenge |
| `room-packet-learning.template.md` | packet text | Planner fills it in for Learning rooms |
| `room-packet-challenge.template.md` | packet text | Planner fills it in for Challenge rooms (modelled on NTI-M01-R03) |
| `seal_flag.py` | helper | Prints CHECK_HASH and SEALED_FLAG_HEX for the practical templates |

## Placeholders
`{{ROOM_ID}}`, `{{TITLE}}`, `{{SLUG}}`, `{{SLUG_UNDERSCORED}}` (slug with `_` in place of `-`), `{{DIFFICULTY}}` (Beginner, Intermediate or Expert), `{{EST_TIME}}` (minutes, digits), `{{FLAG}}` (CBX{verb_noun}, lowercase), and content placeholders in capitals. Before you submit, search the files for `{{`. There must be no matches.

## Sealing the flag
```
python3 seal_flag.py "CBX{verb_noun}" "<proof answer 1>" "<proof answer 2>" ...
```
Pass the proof answers in the same order as the input fields in the practical. The learning template has 2 fields (`ans-1`, `ans-2`). The challenge template has 4 (`p1` to `p4`). Change the number of fields in the JS if you need to. Paste the two output values into `CHECK_HASH` and `SEALED_FLAG_HEX`. The flag never appears in plain text in the source. Answers are matched after trimming, lower-casing and collapsing spaces. The round trip was tested with node and python3.

## Notes
- The templates are stubs. In the completed rooms under output/, Learning practicals are about 38 to 69 KB and Challenge practicals about 48 to 61 KB (one is 159 KB). The size comes from realistic data volume.
- The data in the practicals must be synthetic: cbx.lab, RFC 1918 internal ranges and RFC 5737 external ranges. No real secrets and no working exploit code.
- Never put Free or Paid wording in any room file or packet. Access lives only in the plan.
