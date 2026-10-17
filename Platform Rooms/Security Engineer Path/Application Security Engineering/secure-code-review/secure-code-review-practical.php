<?php
// secure-code-review-practical.php
// Standalone static simulation. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vulnerable Login Portal | Code Review Simulation</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
    --bg-primary: #0b0f1a;
    --bg-secondary: #12182b;
    --bg-surface: #161d36;
    --text-primary: #e6e9f2;
    --text-secondary: #aab0d6;
    --text-muted: #7c83b6;
    --accent-primary: #6ae3ff;
    --accent-secondary: #8b7bff;
    --success: #3dff9a;
    --error: #ff5c5c;
    --warning: #ffd36a;
    --border-default: rgba(255,255,255,0.08);
    --glow-accent: 0 0 12px rgba(106,227,255,0.35);
}

* { box-sizing: border-box; }

body {
    margin: 0;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

code, .mono {
    font-family: "JetBrains Mono", monospace;
}

.page-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 20px 60px 20px;
}

/* HEADER */
.top-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
}

.top-header h1 {
    margin: 0 0 6px 0;
    font-size: 1.8rem;
}

.top-header .subtitle {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

/* DESCRIPTION */
.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.description-section strong { color: var(--text-primary); }

/* MAIN ENVIRONMENT */
.environment {
    display: grid;
    grid-template-columns: 220px 1fr 280px;
    gap: 16px;
    min-height: 420px;
}

@media (max-width: 900px) {
    .environment { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px;
}

.panel h3 {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
}

/* FILE TREE */
#file-tree .file-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 4px;
    transition: background 0.15s ease, color 0.15s ease;
}
#file-tree .file-item:hover {
    background: rgba(255,255,255,0.04);
    color: var(--text-primary);
}
#file-tree .file-item.active {
    background: rgba(106,227,255,0.08);
    color: var(--accent-primary);
    border: 1px solid rgba(106,227,255,0.25);
}
#file-tree .file-item .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--text-muted);
    flex-shrink: 0;
}
#file-tree .file-item.flagged-file .dot {
    background: var(--warning);
}

/* CODE VIEWER */
#code-viewer {
    overflow-x: auto;
}
.code-filename {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--accent-primary);
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border-default);
}
.code-line {
    display: flex;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    white-space: pre;
}
.line-number {
    width: 34px;
    flex-shrink: 0;
    text-align: right;
    padding-right: 12px;
    color: var(--text-muted);
    cursor: pointer;
    user-select: none;
    border-right: 1px solid var(--border-default);
    margin-right: 12px;
}
.line-number:hover {
    color: var(--accent-primary);
    background: rgba(106,227,255,0.06);
}
.line-number.is-flagged {
    color: var(--bg-primary);
    background: var(--warning);
    border-radius: 3px;
}
.line-content {
    color: var(--text-secondary);
    padding: 1px 0;
}
.line-content .kw { color: var(--accent-secondary); }
.line-content .str { color: var(--success); }
.line-content .fn { color: var(--accent-primary); }
.line-content .cm { color: var(--text-muted); font-style: italic; }

/* CATEGORY POPOVER */
.category-popover {
    margin: 4px 0 10px 46px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 8px;
    padding: 10px;
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}
.category-popover select {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 6px 8px;
    font-family: inherit;
    font-size: 0.85rem;
}
.category-popover button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    font-weight: 700;
    font-size: 0.8rem;
    cursor: pointer;
}
.category-popover .cancel-flag {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default);
}

/* FINDINGS PANEL */
#findings-panel .finding-item {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 8px;
    font-size: 0.82rem;
}
#findings-panel .finding-item .f-file {
    color: var(--accent-primary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.78rem;
}
#findings-panel .finding-item .f-cat {
    color: var(--text-primary);
    font-weight: 600;
    margin-top: 4px;
}
#findings-panel .finding-item .f-remove {
    float: right;
    color: var(--error);
    cursor: pointer;
    font-size: 0.75rem;
}
#findings-panel .empty-note {
    color: var(--text-muted);
    font-size: 0.82rem;
}

#submit-review-btn {
    width: 100%;
    margin-top: 14px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
}
#submit-review-btn:hover {
    box-shadow: var(--glow-accent);
}

/* FEEDBACK AREA */
#feedback-area {
    margin-top: 18px;
    min-height: 20px;
}
.feedback-msg {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 0.88rem;
    margin-bottom: 8px;
}
.feedback-msg.info {
    background: rgba(106,227,255,0.08);
    border: 1px solid rgba(106,227,255,0.25);
    color: var(--accent-primary);
}
.feedback-msg.warn {
    background: rgba(255,211,106,0.08);
    border: 1px solid rgba(255,211,106,0.3);
    color: var(--warning);
}
.feedback-msg.err {
    background: rgba(255,92,92,0.08);
    border: 1px solid rgba(255,92,92,0.3);
    color: var(--error);
}

/* FLAG REVEAL */
#flag-reveal-area {
    display: none;
    margin-top: 22px;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
}
#flag-reveal-area.visible { display: block; }
#flag-reveal-area h2 {
    color: var(--success);
    margin: 0 0 10px 0;
}
#flag-reveal-area .flag-value {
    display: inline-block;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 18px;
    border-radius: 8px;
    letter-spacing: 0.02em;
}

/* SPOTLIGHT TUTORIAL */
#tutorial-spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: top 0.25s ease, left 0.25s ease, width 0.25s ease, height 0.25s ease;
    z-index: 9998;
    display: none;
}
#tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
    display: none;
}
#tutorial-tooltip h4 {
    margin: 0 0 8px 0;
    color: var(--accent-primary);
    font-size: 0.95rem;
}
#tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.tutorial-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tutorial-actions button {
    font-family: inherit;
    font-size: 0.82rem;
    border-radius: 6px;
    padding: 7px 12px;
    cursor: pointer;
    border: none;
}
#tutorial-next-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    font-weight: 700;
}
#tutorial-skip-btn {
    background: transparent;
    color: var(--text-muted);
}

/* MODAL */
.tutorial-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.tutorial-modal-overlay.visible { display: flex; }
.tutorial-modal {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.tutorial-modal h3 {
    color: var(--accent-primary);
    margin-top: 0;
}
.tutorial-modal button {
    margin-top: 14px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="top-header">
        <div>
            <h1>Vulnerable Login Portal</h1>
            <p class="subtitle">You are reviewing a small PHP login and profile application before it ships. Somewhere inside these five files are three real vulnerabilities, hiding among code that looks perfectly reasonable at a glance.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="description-section">
        This environment represents a real pull request review. Click through each file in the tree on the left, read the code carefully, and flag any line you believe introduces a security vulnerability. For each flag, choose the specific category of flaw. Not every file is guilty, some are here to test whether you can tell secure code from insecure code. Submit your review once you are confident you have found all three real vulnerabilities.
    </div>

    <div class="environment">
        <div class="panel" id="file-tree">
            <h3>Files</h3>
            <div class="file-item active" data-file="login.php"><span class="dot"></span>login.php</div>
            <div class="file-item" data-file="auth.php"><span class="dot"></span>auth.php</div>
            <div class="file-item" data-file="profile.php"><span class="dot"></span>profile.php</div>
            <div class="file-item" data-file="search.php"><span class="dot"></span>search.php</div>
            <div class="file-item" data-file="index.php"><span class="dot"></span>index.php</div>
        </div>

        <div class="panel" id="code-viewer">
            <h3>Code Viewer</h3>
            <div class="code-filename" id="current-filename">login.php</div>
            <div id="code-lines"></div>
        </div>

        <div class="panel" id="findings-side">
            <div id="findings-panel">
                <h3>Findings</h3>
                <div id="findings-list">
                    <p class="empty-note">No lines flagged yet. Click a line number in the code viewer to flag it.</p>
                </div>
            </div>
            <button id="submit-review-btn">Submit Review</button>
        </div>
    </div>

    <div id="feedback-area"></div>

    <div id="flag-reveal-area">
        <h2>Review Complete</h2>
        <p>You correctly identified all three vulnerabilities. Here is your flag:</p>
        <div class="flag-value">CBX{vulnerabilities_flagged}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div id="tutorial-spotlight"></div>
<div id="tutorial-tooltip">
    <h4 id="tutorial-tooltip-title"></h4>
    <p id="tutorial-tooltip-text"></p>
    <div class="tutorial-actions">
        <button id="tutorial-skip-btn">Skip Tutorial</button>
        <button id="tutorial-next-btn">Next</button>
    </div>
</div>

<div class="tutorial-modal-overlay" id="tutorial-complete-modal">
    <div class="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// FILE DATA
// Each file is an array of { code, kw (keyword spans optional) }
// We store raw HTML-escaped lines with light manual highlighting.
// ============================================================
const files = {
    "login.php": {
        lines: [
            "<?php",
            "// login.php - handles user authentication",
            "require_once 'db.php';",
            "",
            "if ($_SERVER['REQUEST_METHOD'] === 'POST') {",
            "    $username = $_POST['username'];",
            "    $password = $_POST['password'];",
            "",
            "    // Look up the user record",
            "    $query = \"SELECT * FROM users WHERE username = '\" . $username .",
            "              \"' AND password = '\" . $password . \"'\";",
            "    $result = $conn->query($query);",
            "",
            "    if ($result && $result->num_rows === 1) {",
            "        $_SESSION['user'] = $result->fetch_assoc();",
            "        header('Location: /profile.php');",
            "    } else {",
            "        echo 'Invalid credentials';",
            "    }",
            "}"
        ],
        vulnLine: 10,
        vulnCategory: "sqli"
    },
    "auth.php": {
        lines: [
            "<?php",
            "// auth.php - verifies admin API access",
            "",
            "function isAdminRequest($token) {",
            "    $adminSecret = \"admin-2024-secret\";",
            "",
            "    // Compare the provided token against the admin secret",
            "    if ($token == $adminSecret) {",
            "        return true;",
            "    }",
            "",
            "    return false;",
            "}",
            "",
            "$providedToken = $_GET['token'] ?? '';",
            "if (isAdminRequest($providedToken)) {",
            "    echo 'Admin access granted';",
            "}"
        ],
        vulnLine: 8,
        vulnCategory: "auth"
    },
    "profile.php": {
        lines: [
            "<?php",
            "// profile.php - loads saved user preferences",
            "",
            "if (isset($_COOKIE['user_data'])) {",
            "    $rawCookie = $_COOKIE['user_data'];",
            "",
            "    // Restore the user object from their saved cookie",
            "    $userObject = unserialize($rawCookie);",
            "",
            "    echo 'Welcome back, ' . $userObject->name;",
            "} else {",
            "    echo 'No saved profile found';",
            "}"
        ],
        vulnLine: 8,
        vulnCategory: "deserialization"
    },
    "search.php": {
        lines: [
            "<?php",
            "// search.php - searches the product catalog",
            "require_once 'db.php';",
            "",
            "$term = $_GET['term'] ?? '';",
            "",
            "$stmt = $conn->prepare('SELECT * FROM products WHERE name LIKE ?');",
            "$likeTerm = '%' . $term . '%';",
            "$stmt->bind_param('s', $likeTerm);",
            "$stmt->execute();",
            "$results = $stmt->get_result();",
            "",
            "foreach ($results as $row) {",
            "    echo $row['name'] . '<br>';",
            "}"
        ],
        vulnLine: null,
        vulnCategory: null
    },
    "index.php": {
        lines: [
            "<?php",
            "// index.php - simple front controller",
            "",
            "$page = $_GET['page'] ?? 'home';",
            "$allowedPages = ['home', 'login', 'profile', 'search'];",
            "",
            "if (in_array($page, $allowedPages, true)) {",
            "    require_once $page . '.php';",
            "} else {",
            "    require_once 'home.php';",
            "}"
        ],
        vulnLine: null,
        vulnCategory: null
    }
};

const categoryLabels = {
    sqli: "SQL Injection",
    auth: "Broken Authentication",
    deserialization: "Insecure Deserialization",
    none: "Not Vulnerable"
};

let currentFile = "login.php";
let flags = {}; // key: "filename:lineIndex" -> category
let activePopoverLine = null;

const codeLinesEl = document.getElementById('code-lines');
const filenameEl = document.getElementById('current-filename');
const findingsListEl = document.getElementById('findings-list');
const feedbackArea = document.getElementById('feedback-area');
const flagRevealArea = document.getElementById('flag-reveal-area');

function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function renderFile(filename) {
    currentFile = filename;
    filenameEl.textContent = filename;
    document.querySelectorAll('#file-tree .file-item').forEach(el => {
        el.classList.toggle('active', el.dataset.file === filename);
    });

    const fileData = files[filename];
    codeLinesEl.innerHTML = '';
    activePopoverLine = null;

    fileData.lines.forEach((lineText, idx) => {
        const lineWrap = document.createElement('div');
        lineWrap.className = 'code-line';

        const lineNum = document.createElement('div');
        lineNum.className = 'line-number';
        lineNum.textContent = idx + 1;
        lineNum.dataset.line = idx;

        const key = filename + ':' + idx;
        if (flags[key]) {
            lineNum.classList.add('is-flagged');
        }

        if (filename === 'login.php' && idx === fileData.vulnLine) {
            lineNum.id = 'line-number-flag';
        }

        lineNum.addEventListener('click', () => onLineNumberClick(filename, idx, lineNum));

        const lineContent = document.createElement('div');
        lineContent.className = 'line-content';
        lineContent.innerHTML = escapeHtml(lineText);

        lineWrap.appendChild(lineNum);
        lineWrap.appendChild(lineContent);
        codeLinesEl.appendChild(lineWrap);

        if (activePopoverLine === idx) {
            codeLinesEl.appendChild(buildPopover(filename, idx));
        }
    });
}

function onLineNumberClick(filename, idx, lineNumEl) {
    const key = filename + ':' + idx;
    if (flags[key]) {
        delete flags[key];
        renderFile(filename);
        renderFindings();
        return;
    }
    activePopoverLine = idx;
    renderFile(filename);
}

function buildPopover(filename, idx) {
    const wrap = document.createElement('div');
    wrap.className = 'category-popover';

    const select = document.createElement('select');
    ['sqli', 'auth', 'deserialization', 'none'].forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat;
        opt.textContent = categoryLabels[cat];
        select.appendChild(opt);
    });

    const confirmBtn = document.createElement('button');
    confirmBtn.textContent = 'Flag Line';
    confirmBtn.id = 'category-dropdown-confirm';
    confirmBtn.addEventListener('click', () => {
        const key = filename + ':' + idx;
        flags[key] = select.value;
        activePopoverLine = null;
        renderFile(filename);
        renderFindings();
    });

    const cancelBtn = document.createElement('button');
    cancelBtn.textContent = 'Cancel';
    cancelBtn.className = 'cancel-flag';
    cancelBtn.addEventListener('click', () => {
        activePopoverLine = null;
        renderFile(filename);
    });

    select.id = 'category-dropdown';
    wrap.appendChild(select);
    wrap.appendChild(confirmBtn);
    wrap.appendChild(cancelBtn);
    return wrap;
}

function renderFindings() {
    const keys = Object.keys(flags);
    if (keys.length === 0) {
        findingsListEl.innerHTML = '<p class="empty-note">No lines flagged yet. Click a line number in the code viewer to flag it.</p>';
        updateFileTreeDots();
        return;
    }

    findingsListEl.innerHTML = '';
    keys.forEach(key => {
        const [filename, idx] = key.split(':');
        const category = flags[key];
        const item = document.createElement('div');
        item.className = 'finding-item';
        item.innerHTML = `<span class="f-remove" data-key="${key}">remove</span>
            <div class="f-file">${filename}, line ${parseInt(idx) + 1}</div>
            <div class="f-cat">${categoryLabels[category]}</div>`;
        findingsListEl.appendChild(item);
    });

    findingsListEl.querySelectorAll('.f-remove').forEach(el => {
        el.addEventListener('click', () => {
            delete flags[el.dataset.key];
            renderFindings();
            if (files[currentFile]) renderFile(currentFile);
        });
    });

    updateFileTreeDots();
}

function updateFileTreeDots() {
    document.querySelectorAll('#file-tree .file-item').forEach(el => {
        const filename = el.dataset.file;
        const hasFlag = Object.keys(flags).some(k => k.startsWith(filename + ':'));
        el.classList.toggle('flagged-file', hasFlag);
    });
}

function showFeedback(message, type) {
    feedbackArea.innerHTML = `<div class="feedback-msg ${type}">${message}</div>`;
}

document.getElementById('submit-review-btn').addEventListener('click', () => {
    const requiredCorrect = [
        { filename: 'login.php', line: files['login.php'].vulnLine, category: 'sqli' },
        { filename: 'auth.php', line: files['auth.php'].vulnLine, category: 'auth' },
        { filename: 'profile.php', line: files['profile.php'].vulnLine, category: 'deserialization' }
    ];

    let correctCount = 0;
    requiredCorrect.forEach(req => {
        const key = req.filename + ':' + req.line;
        if (flags[key] === req.category) {
            correctCount++;
        }
    });

    const decoyFlags = Object.keys(flags).filter(k =>
        k.startsWith('search.php:') || k.startsWith('index.php:')
    );

    if (decoyFlags.length > 0 && correctCount < 3) {
        showFeedback('Some flagged lines belong to files that follow secure practices. This file follows secure practices, keep looking at the others.', 'warn');
    }

    if (correctCount === 3) {
        showFeedback('All three vulnerabilities correctly identified and categorized.', 'info');
        flagRevealArea.classList.add('visible');
        flagRevealArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        showFeedback(`You have correctly identified ${correctCount} of 3 real vulnerabilities so far. Keep reviewing.`, 'err');
    }
});

document.querySelectorAll('#file-tree .file-item').forEach(el => {
    el.addEventListener('click', () => renderFile(el.dataset.file));
});

// Initial render
renderFile('login.php');

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetId: 'file-tree',
        title: 'The Codebase',
        text: "This is the codebase you're reviewing, a small login and profile application. Real reviews often start exactly like this: a repo you've never seen before."
    },
    {
        targetId: 'code-viewer',
        title: 'Code Viewer',
        text: 'Click any file in the tree to open it here. Line numbers on the left let you reference and flag specific lines, just like commenting on a pull request.'
    },
    {
        targetId: 'line-number-flag',
        title: 'Flagging a Line',
        text: 'Click a line number to flag it as a potential vulnerability. This is how reviewers mark risky code for discussion.'
    },
    {
        targetId: 'category-dropdown',
        title: 'Choosing a Category',
        text: 'Once flagged, choose the vulnerability category. Being specific about the flaw type is what separates a useful finding from a vague one.'
    },
    {
        targetId: 'findings-panel',
        title: 'Findings Panel',
        text: 'Every flag you make appears here so you can track your review progress across all the files.'
    },
    {
        targetId: 'submit-review-btn',
        title: 'Submit Your Review',
        text: 'When you believe you have found all the real vulnerabilities, submit your review to see the results.'
    }
];

let currentStep = 0;
const spotlightEl = document.getElementById('tutorial-spotlight');
const tooltipEl = document.getElementById('tutorial-tooltip');
const tooltipTitle = document.getElementById('tutorial-tooltip-title');
const tooltipText = document.getElementById('tutorial-tooltip-text');
const completeModal = document.getElementById('tutorial-complete-modal');

function getStepTarget(step) {
    let el = document.getElementById(step.targetId);
    if (!el && step.targetId === 'category-dropdown') {
        // Force the popover open on the tutorial's target flag line so the dropdown exists
        activePopoverLine = files['login.php'].vulnLine;
        renderFile('login.php');
        el = document.getElementById('category-dropdown');
    }
    return el;
}

function positionSpotlight(step) {
    const el = getStepTarget(step);
    if (!el) {
        nextTutorialStep();
        return;
    }

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => drawSpotlight(el, step), 300);
    } else {
        drawSpotlight(el, step);
    }
}

function drawSpotlight(el, step) {
    const rect = el.getBoundingClientRect();
    const padding = 8;

    spotlightEl.style.display = 'block';
    spotlightEl.style.top = (rect.top - padding) + 'px';
    spotlightEl.style.left = (rect.left - padding) + 'px';
    spotlightEl.style.width = (rect.width + padding * 2) + 'px';
    spotlightEl.style.height = (rect.height + padding * 2) + 'px';

    tooltipTitle.textContent = step.title;
    tooltipText.textContent = step.text;
    tooltipEl.style.display = 'block';

    const tooltipWidth = 300;
    const spaceBelow = window.innerHeight - rect.bottom;
    const spaceRight = window.innerWidth - rect.right;

    let top, left;
    if (spaceBelow > 160) {
        top = rect.bottom + 16;
        left = Math.min(rect.left, window.innerWidth - tooltipWidth - 20);
    } else if (spaceRight > tooltipWidth + 40) {
        top = Math.max(20, rect.top);
        left = rect.right + 16;
    } else {
        top = Math.max(20, rect.top - 160);
        left = Math.max(20, rect.left);
    }
    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    positionSpotlight(tutorialSteps[currentStep]);
}

function startTutorial() {
    currentStep = 0;
    activePopoverLine = null;
    renderFile('login.php');
    positionSpotlight(tutorialSteps[0]);
}

function endTutorial(completed) {
    spotlightEl.style.display = 'none';
    tooltipEl.style.display = 'none';
    if (completed) {
        completeModal.classList.add('visible');
    }
}

document.getElementById('tutorial-next-btn').addEventListener('click', nextTutorialStep);
document.getElementById('tutorial-skip-btn').addEventListener('click', () => endTutorial(false));
document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    completeModal.classList.remove('visible');
});

window.addEventListener('resize', () => {
    if (tooltipEl.style.display === 'block' && tutorialSteps[currentStep]) {
        positionSpotlight(tutorialSteps[currentStep]);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
