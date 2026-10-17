#!/usr/bin/env python3
"""Static checks for one Cybrixen room folder (the mechanical half of kit/03-docs/04-room-qa.md).

Usage:
  python3 tools/lint_room.py "<room folder>" [--json] [--proof "answer 1" "answer 2" ...]

The room folder holds <slug>.php, <slug>-practical.php and <slug>-answers.csv. The slug is taken
from the theory page file name. --proof re-derives the flag from CHECK_HASH / SEALED_FLAG_HEX with
the given proof answers (same normalisation as kit/02-templates/seal_flag.py) and checks it matches
the flag in the answers CSV.

Every finding is FAIL (breaks a hard rule) or WARN (QA must look at it and decide). Exit code 1 if
any FAIL. The QA agents still do the judgement checks (decoys, realism, teaching, visuals) by hand.
"""
import csv, io, json, os, re, subprocess, sys, xml.etree.ElementTree as ET

sys.path.insert(0, os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'kit', '02-templates'))
from seal_flag import cyrb53, norm  # noqa: E402

EM_DASH = '—'
DIFFICULTIES = {'Beginner', 'Intermediate', 'Expert'}
FLAG_RE = re.compile(r'^CBX\{[a-z0-9]+(_[a-z0-9]+)+\}$')
LABEL_WORDS = re.compile(r'\b(exploit|attack|malicious|payload|evil)\b', re.I)


class Report:
    def __init__(self):
        self.items = []

    def add(self, level, file, where, msg):
        self.items.append({'level': level, 'file': file, 'where': where, 'msg': msg})

    def fail(self, *a): self.add('FAIL', *a)
    def warn(self, *a): self.add('WARN', *a)


def line_of(text, idx):
    return text.count('\n', 0, idx) + 1


def php_block(src, var):
    """Return the source of `$var = [ ... ];` (bracket matched, quote aware)."""
    m = re.search(r'\$' + var + r'\s*=\s*\[', src)
    if not m:
        return None
    i, depth, q = m.end() - 1, 0, None
    while i < len(src):
        c = src[i]
        if q:
            if c == '\\':
                i += 1
            elif c == q:
                q = None
        elif c in '\'"':
            q = c
        elif c == '[':
            depth += 1
        elif c == ']':
            depth -= 1
            if depth == 0:
                return src[m.start():i + 1]
        i += 1
    return None


def php_str(s):
    return s.replace("\\'", "'").replace('\\\\', '\\')


def parse_questions(src):
    block = php_block(src, 'task_questions_data') or ''
    out = {}
    for tm in re.finditer(r"'(task\d+)'\s*=>\s*\[(.*?)\n\s*\],", block, re.S):
        out[tm.group(1)] = [(q.group(1), php_str(q.group(2))) for q in
                            re.finditer(r"'id'\s*=>\s*'(q\d+)'\s*,\s*'text'\s*=>\s*'((?:[^'\\]|\\.)*)'", tm.group(2))]
    return out


def config_value(src, key):
    m = re.search(r"'" + key + r"'\s*=>\s*'((?:[^'\\]|\\.)*)'", php_block(src, 'room_config') or '')
    return php_str(m.group(1)) if m else None


def html_bodies(src):
    return [(m.start(1), m.group(1)) for m in re.finditer(r"<<<'?HTML'?\n(.*?)\n\s*HTML;", src, re.S)]


def php_lint(path, rep, name):
    try:
        r = subprocess.run(['php', '-l', path], capture_output=True, text=True, timeout=30)
        if r.returncode != 0:
            rep.fail(name, '', 'PHP syntax error: ' + (r.stdout + r.stderr).strip().splitlines()[0])
    except FileNotFoundError:
        rep.warn(name, '', 'php not installed, syntax not checked')


def check_text_rules(text, name, rep):
    for m in re.finditer(EM_DASH, text):
        rep.fail(name, f'line {line_of(text, m.start())}', 'em dash (U+2014) found')
    for m in re.finditer(r'\{\{', text):
        rep.fail(name, f'line {line_of(text, m.start())}', 'template placeholder "{{" left in file')
    for m in re.finditer(r'\b(Free|Paid)\b', text):
        ctx = text[max(0, m.start() - 30):m.end() + 30].replace('\n', ' ')
        rep.warn(name, f'line {line_of(text, m.start())}', f'Free/Paid wording? "...{ctx}..."')
    for m in re.finditer(r'\bAdvanced\b', text):
        ctx = text[max(0, m.start() - 40):m.end() + 20].replace('\n', ' ')
        if re.search(r'(difficult|level|Level)', ctx):
            rep.fail(name, f'line {line_of(text, m.start())}', f'"Advanced" used as a level: "...{ctx}..."')


def check_svgs(src, name, rep):
    for m in re.finditer(r'<svg\b.*?</svg>', src, re.S):
        svg = m.group(0)
        ln = line_of(src, m.start())
        try:
            ET.fromstring(re.sub(r'&(?!amp;|lt;|gt;|quot;|apos;|#)', '&amp;', svg))
        except ET.ParseError as e:
            rep.fail(name, f'line {ln}', f'SVG is not well formed ({e})')
        if 'viewBox' not in svg:
            rep.warn(name, f'line {ln}', 'SVG has no viewBox, it will not scale at narrow widths')
        before = src[max(0, m.start() - 400):m.start()]
        if '<!--' not in before:
            rep.warn(name, f'line {ln}', 'SVG has no HTML comment saying what it teaches')


def main():
    args = sys.argv[1:]
    as_json = '--json' in args
    args = [a for a in args if a != '--json']
    proof = None
    if '--proof' in args:
        i = args.index('--proof')
        proof, args = args[i + 1:], args[:i]
    if len(args) != 1:
        print(__doc__)
        sys.exit(2)
    room = args[0].rstrip('/')
    rep = Report()
    files = sorted(f for f in os.listdir(room) if not f.startswith('.'))
    theory = [f for f in files if f.endswith('.php') and not f.endswith('-practical.php')]
    if len(theory) != 1:
        rep.fail('(folder)', '', f'expected exactly one theory .php, found {theory}')
        return finish(rep, as_json, room, None)
    slug = theory[0][:-4]
    cid = config_value(open(f'{room}/{theory[0]}', encoding='utf-8').read(), 'id')
    if cid and cid != slug and os.path.exists(f'{room}/{cid}-answers.csv'):
        rep.fail(theory[0], '', f'theory file is named "{theory[0]}" but the room id and other files use "{cid}"')
        slug = cid
    want = {f'{slug}.php', f'{slug}-practical.php', f'{slug}-answers.csv'}
    if set(files) != want:
        rep.fail('(folder)', '', f'files must be exactly {sorted(want)}; found {files}')
    if not re.fullmatch(r'[a-z0-9]+(-[a-z0-9]+)*', slug):
        rep.fail('(folder)', '', f'slug "{slug}" is not lowercase-hyphenated')
    if os.path.basename(room) != slug:
        rep.warn('(folder)', '', f'folder name "{os.path.basename(room)}" differs from slug "{slug}"')

    tpath, ppath = f'{room}/{theory[0]}', f'{room}/{slug}-practical.php'
    tsrc = open(tpath, encoding='utf-8').read()
    psrc = open(ppath, encoding='utf-8').read() if os.path.exists(ppath) else ''
    apath = f'{room}/{slug}-answers.csv'
    if not os.path.exists(apath):
        cand = [f for f in files if f.endswith('-answers.csv')]
        apath = f'{room}/{cand[0]}' if cand else None
    asrc = open(apath, encoding='utf-8').read() if apath else ''
    tname, pname, aname = os.path.basename(tpath), os.path.basename(ppath), os.path.basename(apath or 'answers.csv')

    php_lint(tpath, rep, tname)
    if psrc:
        php_lint(ppath, rep, pname)
    for text, name in [(tsrc, tname), (psrc, pname), (asrc, aname)]:
        check_text_rules(text, name, rep)

    # ---- answers CSV ----
    lines = asrc.splitlines()
    if not lines or lines[0].strip() != f'# FILENAME: {slug}-answers.csv':
        rep.fail(aname, 'line 1', f'header must be "# FILENAME: {slug}-answers.csv", found "{lines[0] if lines else ""}"')
    rows = []
    skip = 1 if lines and lines[0].startswith('#') else 0
    for n, row in enumerate(csv.reader(io.StringIO('\n'.join(lines[skip:]))), skip + 1):
        if not row:
            continue
        if len(row) != 3:
            rep.fail(aname, f'line {n}', f'row must be taskN,qK,answer (no commas in answers): {row}')
            continue
        rows.append((n, row[0].strip(), row[1].strip(), row[2].strip()))
    qids = [r[2] for r in rows]
    if qids != [f'q{i}' for i in range(len(qids))]:
        rep.fail(aname, '', f'question ids must run q0..q{len(qids) - 1} with no gaps: {qids}')
    if rows and rows[0][3].lower() != 'yes':
        rep.fail(aname, f'line {rows[0][0]}', 'first answer (task1,q0) must be "yes"')
    if rows and rows[-1][3].lower() != 'complete':
        rep.fail(aname, f'line {rows[-1][0]}', 'last answer must be "complete"')
    flags = [r for r in rows if r[3].startswith('CBX{')]
    flag = flags[0][3] if flags else None
    if len(flags) != 1:
        rep.fail(aname, '', f'expected exactly one CBX flag row, found {len(flags)}')
    elif not FLAG_RE.match(flag):
        rep.fail(aname, f'line {flags[0][0]}', f'flag "{flag}" is not CBX{{verb_noun}} lowercase with underscores')
    elif rows.index(flags[0]) != len(rows) - 2:
        rep.fail(aname, f'line {flags[0][0]}', 'flag row must come directly before the final "complete" row')
    seen = {}
    for n, task, q, ans in rows:
        if ans in ('yes', 'complete') or ans.startswith('CBX{'):
            continue
        words = ans.split()
        if len(words) > 3:
            rep.fail(aname, f'line {n}', f'{q} answer "{ans}" is more than 3 words')
        if '-' in ans:
            rep.warn(aname, f'line {n}', f'{q} answer "{ans}" is hyphenated (only a real cmdlet name may be)')
        if '/' in ans:
            rep.warn(aname, f'line {n}', f'{q} answer "{ans}" contains "/": room-engine.php splits on "/" as alternatives')
        if re.fullmatch(r'(zero|one|two|three|four|five|six|seven|eight|nine|ten)', ans, re.I):
            rep.fail(aname, f'line {n}', f'{q} answer "{ans}" is a count in words; use digits')
        key = ans.lower()
        if key in seen:
            rep.fail(aname, f'line {n}', f'{q} answer "{ans}" repeats {seen[key]}')
        seen[key] = q

    # ---- theory page ----
    diff = config_value(tsrc, 'difficulty')
    if diff not in DIFFICULTIES:
        rep.fail(tname, '$room_config', f'difficulty "{diff}" must be Beginner, Intermediate or Expert')
    if config_value(tsrc, 'id') != slug:
        rep.fail(tname, '$room_config', f'id "{config_value(tsrc, "id")}" must equal the slug "{slug}"')
    if not re.fullmatch(r'\d+ minutes', config_value(tsrc, 'estimated_time') or ''):
        rep.fail(tname, '$room_config', 'estimated_time must look like "NN minutes"')
    objectives = re.findall(r"^\s*'", (re.search(r"'learning_objectives'\s*=>\s*\[(.*?)\]", tsrc, re.S) or [None, ''])[1], re.M)
    if len(objectives) != 4:
        rep.warn(tname, '$room_config', f'expected 4 learning objectives, found {len(objectives)}')
    if f"'/{slug}-answers.csv'" not in tsrc.replace('"', "'"):
        rep.fail(tname, '$answers_file', f'must point at __DIR__ . \'/{slug}-answers.csv\'')
    want_key = slug.replace('-', '_') + '_progress'
    if f"'{want_key}'" not in tsrc:
        rep.fail(tname, '$js_config', f'storage_key must be "{want_key}"')
    takeaways = re.findall(r"'✓", php_block(tsrc, 'js_config') or '')
    if len(takeaways) != 4:
        rep.warn(tname, '$js_config', f'expected 4 instagram_takeaways starting with ✓, found {len(takeaways)}')
    if "define('CYBRIXEN_ROOM_ENGINE', true);" not in tsrc or "require_once '../../includes/room-engine.php';" not in tsrc:
        rep.fail(tname, 'footer', "must end with define('CYBRIXEN_ROOM_ENGINE', true); require_once '../../includes/room-engine.php';")
    tasks = re.findall(r"\['id'\s*=>\s*'(task\d+)'\s*,\s*'title'", php_block(tsrc, 'room_tasks') or '')
    ntask = len(tasks)
    challenge = ntask == 3
    if not (challenge or 5 <= ntask <= 9):
        rep.fail(tname, '$room_tasks', f'{ntask} tasks: Learning rooms need 5 to 9, Challenge rooms exactly 3')
    contents = sorted(int(x) for x in re.findall(r'\$task_contents\[(\d+)\]\s*=', tsrc))
    if contents != list(range(1, ntask + 1)):
        rep.fail(tname, '$task_contents', f'need $task_contents[1..{ntask}], found {contents}')
    qs = parse_questions(tsrc)
    php_pairs = [(t, q) for t in qs for q, _ in qs[t]]
    csv_pairs = [(r[1], r[2]) for r in rows]
    if php_pairs != csv_pairs:
        rep.fail(tname, '$task_questions_data', f'task/question ids differ from the CSV.\n      PHP: {php_pairs}\n      CSV: {csv_pairs}')
    if challenge and qs:
        inv = qs.get('task2', [])
        if not 5 <= len(inv) <= 10:
            rep.fail(tname, 'task2', f'Challenge investigation needs 5 to 10 questions, found {len(inv)}')
    elif qs:
        for t in tasks[1:-2]:
            n = len(qs.get(t, []))
            if not 2 <= n <= 4:
                rep.warn(tname, t, f'concept task has {n} questions (kit: 2 to 4)')
    answers_lc = {r[3].lower() for r in rows if r[3].lower() not in ('yes', 'complete') and len(r[3]) > 4}
    for t in qs:
        for q, text in qs[t]:
            plain = re.sub(r'<[^>]+>', '', text).lower()
            for a in answers_lc:
                if re.search(r'(?<![a-z0-9])' + re.escape(a) + r'(?![a-z0-9])', plain):
                    rep.warn(tname, f'{t} {q}', f'question text contains an answer string "{a}": "{plain[:90]}"')
    bodies = html_bodies(tsrc)
    for start, body in bodies:
        for m in re.finditer(r'style="[^"]*\bcolor\s*:[^"]*"', body):
            rep.warn(tname, f'line {line_of(tsrc, start + m.start())}', f'inline text colour {m.group(0)[:70]} (check for inconsistent colouring)')
        for m in re.finditer(r'<(font|span)[^>]*color', body):
            rep.warn(tname, f'line {line_of(tsrc, start + m.start())}', 'coloured span/font in content')
    check_svgs(tsrc, tname, rep)
    if f'{slug}-practical.php' not in tsrc:
        rep.fail(tname, 'practical task', f'no link to {slug}-practical.php')
    elif not re.search(r'href="' + re.escape(slug) + r'-practical\.php"[^>]*target="_blank"|target="_blank"[^>]*href="' + re.escape(slug) + r'-practical\.php"', tsrc):
        rep.warn(tname, 'practical task', 'practical link should open with target="_blank"')
    if flag and flag in tsrc:
        rep.fail(tname, '', 'plain flag appears in the theory page')

    # ---- practical ----
    if psrc:
        if flag and flag in psrc:
            rep.fail(pname, f'line {line_of(psrc, psrc.index(flag))}', 'plain flag appears in the practical source (must be sealed)')
        if flag and flag[4:-1] in psrc:
            rep.fail(pname, f'line {line_of(psrc, psrc.index(flag[4:-1]))}', f'flag body "{flag[4:-1]}" appears in source')
        hm = re.search(r"CHECK_HASH\s*=\s*'([0-9a-f]+)'", psrc)
        sm = re.search(r"SEALED_FLAG_HEX\s*=\s*'([0-9a-f]+)'", psrc)
        if not (hm and sm):
            rep.fail(pname, '', 'no CHECK_HASH / SEALED_FLAG_HEX: flag is not sealed with seal_flag.py')
        elif proof is not None:
            key = '|'.join(norm(a) for a in proof)
            if format(cyrb53(key, 7), 'x') != hm.group(1):
                rep.fail(pname, 'CHECK_HASH', 'proof answers given do not match CHECK_HASH')
            else:
                b = bytes.fromhex(sm.group(1))
                got = ''.join(chr(c ^ (cyrb53(key, i) % 256)) for i, c in enumerate(b))
                if got != flag:
                    rep.fail(pname, 'SEALED_FLAG_HEX', f'unseals to "{got}", CSV flag is "{flag}"')
        if 'Not yet.' not in psrc:
            rep.fail(pname, '', 'wrong-answer feedback "Not yet." not found')
        for m in re.finditer(r'\b(\d+|\$\{[^}]+\}|\'\s*\+\s*\w+\s*\+\s*\')\s*(of|/)\s*(\d+|\$\{[^}]+\})\s*(are|is)?\s*(right|correct)', psrc, re.I):
            rep.fail(pname, f'line {line_of(psrc, m.start())}', f'feedback counter "{m.group(0)}" (must be plain "Not yet.")')
        for m in re.finditer(r'>\s*(Show\s+)?Hints?\s*:?\s*<|id="hint', psrc, re.I):
            rep.fail(pname, f'line {line_of(psrc, m.start())}', 'Hint button or hint element')
        if not re.search(r'auth\.php', psrc):
            rep.warn(pname, 'top', 'no auth guard: practical can be opened without logging in')
        if 'Escape' not in psrc:
            rep.warn(pname, '', 'tutorial does not appear to close on Escape')
        if 'localStorage' not in psrc:
            rep.warn(pname, '', 'tutorial first-visit flag (localStorage) not found')
        if not re.search(r'@media[^{]*max-width', psrc):
            rep.warn(pname, '', 'no max-width media query: check layout below 900px')
        for m in re.finditer(r'<script[^>]+src="https?://', psrc):
            rep.fail(pname, f'line {line_of(psrc, m.start())}', 'external JS library (practicals must be self-contained)')
        for m in LABEL_WORDS.finditer(psrc):
            ctx = psrc[max(0, m.start() - 40):m.end() + 20].replace('\n', ' ')
            rep.warn(pname, f'line {line_of(psrc, m.start())}', f'label word "{m.group(0)}" (must not appear in raw data fields): "...{ctx}..."')
        for m in re.finditer(r'--(bg-primary|accent-primary)\s*:\s*(#[0-9a-fA-F]{6})', psrc):
            want = {'bg-primary': '#0b0f1a', 'accent-primary': '#6ae3ff'}[m.group(1)]
            if m.group(2).lower() != want:
                rep.warn(pname, f'line {line_of(psrc, m.start())}', f'--{m.group(1)} is {m.group(2)}, house theme is {want}')
    return finish(rep, as_json, room, {'slug': slug, 'tasks': ntask, 'type': 'Challenge' if challenge else 'Learning',
                                       'questions': len(rows), 'flag_in_csv': bool(flag), 'difficulty': diff})


def finish(rep, as_json, room, meta):
    fails = [i for i in rep.items if i['level'] == 'FAIL']
    if as_json:
        print(json.dumps({'room': room, 'meta': meta, 'fail': len(fails),
                          'warn': len(rep.items) - len(fails), 'items': rep.items}, indent=2))
    else:
        print(f'== {room}')
        if meta:
            print('   ' + ', '.join(f'{k}={v}' for k, v in meta.items()))
        for i in rep.items:
            print(f"   {i['level']}  {i['file']} {i['where']}: {i['msg']}")
        print(f'   -> {len(fails)} FAIL, {len(rep.items) - len(fails)} WARN')
    sys.exit(1 if fails else 0)


if __name__ == '__main__':
    main()
