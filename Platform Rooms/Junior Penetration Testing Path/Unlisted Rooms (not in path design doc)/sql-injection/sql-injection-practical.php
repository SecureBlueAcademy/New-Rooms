<?php
// ============================================================
// sql-injection-practical.php
// Standalone practical: Nova Threads Search Console
// HTML / CSS / vanilla JS only. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nova Threads Search Console</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
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
    line-height: 1.5;
}

.wrapper {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ========== HEADER ========== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 20px;
}
.header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.98rem;
    margin: 0;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

/* ========== DESCRIPTION ========== */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 24px;
}
.briefing h2 {
    font-size: 1rem;
    margin: 0 0 8px 0;
    color: var(--accent-primary);
}
.briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
.briefing p:last-child { margin-bottom: 0; }

/* ========== TABS ========== */
.tabs {
    display: flex;
    gap: 4px;
    border-bottom: 1px solid var(--border-default);
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.tab-btn {
    background: transparent;
    border: none;
    color: var(--text-secondary);
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 500;
    padding: 12px 18px;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.2s ease;
}
.tab-btn:hover { color: var(--text-primary); }
.tab-btn.active {
    color: var(--accent-primary);
    border-bottom-color: var(--accent-primary);
}
.tab-status {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--text-muted);
}
.tab-status.done { background: var(--success); box-shadow: 0 0 6px rgba(61,255,154,0.6); }

.panel { display: none; }
.panel.active { display: block; }

/* ========== SEARCH INTERFACE ========== */
.search-row {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}
.search-row input {
    flex: 1;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 12px 14px;
    border-radius: 8px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.9rem;
}
.search-row input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.search-row button {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 0 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
}
.search-row button:hover { box-shadow: var(--glow-accent); }

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
}
.product-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
}
.product-card .name {
    font-weight: 600;
    font-size: 0.92rem;
    margin-bottom: 4px;
}
.product-card .meta {
    color: var(--text-muted);
    font-size: 0.8rem;
}
.empty-state {
    color: var(--text-muted);
    font-size: 0.88rem;
    padding: 20px 0;
    text-align: center;
}

/* ========== CODE / LOG STYLE PANELS ========== */
.code-block {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
    white-space: pre-wrap;
    word-break: break-word;
    margin-bottom: 14px;
}
.code-block .req-line { color: var(--accent-secondary); }
.code-block .sql-line { color: var(--accent-primary); }
.code-block .err-line { color: var(--error); }
.code-block .ok-line { color: var(--success); }

table.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}
table.data-table th, table.data-table td {
    border: 1px solid var(--border-default);
    padding: 8px 10px;
    text-align: left;
}
table.data-table th {
    background: var(--bg-surface);
    color: var(--accent-primary);
    font-family: "JetBrains Mono", monospace;
    font-weight: 600;
}
table.data-table td {
    font-family: "JetBrains Mono", monospace;
    color: var(--text-secondary);
}

/* ========== FEEDBACK AREA ========== */
.feedback-area {
    margin-top: 18px;
}
.status-msg {
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 0.88rem;
    margin-bottom: 10px;
    border: 1px solid var(--border-default);
}
.status-msg.error { color: var(--error); border-color: rgba(255,92,92,0.4); background: rgba(255,92,92,0.08); }
.status-msg.success { color: var(--success); border-color: rgba(61,255,154,0.4); background: rgba(61,255,154,0.08); }
.status-msg.info { color: var(--warning); border-color: rgba(255,211,106,0.4); background: rgba(255,211,106,0.08); }

/* ========== FLAG AREA ========== */
.flag-area {
    display: none;
    margin-top: 26px;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}
.flag-area.show { display: block; }
.flag-area h3 {
    color: var(--success);
    margin: 0 0 10px 0;
    font-size: 1rem;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px;
    display: inline-block;
    letter-spacing: 0.02em;
}

/* ========== TUTORIAL SPOTLIGHT ========== */
.spotlight-box {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 9998;
    transition: all 0.25s ease;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    box-shadow: var(--glow-accent);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    font-size: 0.87rem;
    color: var(--text-primary);
    transition: all 0.25s ease;
}
.tooltip-card h4 {
    margin: 0 0 8px 0;
    color: var(--accent-primary);
    font-size: 0.92rem;
}
.tooltip-card p { margin: 0 0 12px 0; color: var(--text-secondary); }
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
}
.tt-next {
    background: var(--accent-primary);
    color: #0b0f1a;
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.show { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 340px;
    text-align: center;
}
.modal-card h3 { color: var(--accent-primary); margin: 0 0 10px 0; }
.modal-card p { color: var(--text-secondary); margin: 0 0 18px 0; font-size: 0.9rem; }
.modal-card button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    font-family: inherit;
    font-weight: 700;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
}

@media (max-width: 600px) {
    .header { flex-direction: column; }
    .search-row { flex-direction: column; }
}
</style>
</head>
<body>
<div class="wrapper">

    <!-- ========== 1. TOP HEADER ========== -->
    <div class="header">
        <div>
            <h1>Nova Threads Search Console</h1>
            <p class="subtitle">Investigate a vulnerable product search and extract hidden data</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </div>

    <!-- ========== 2. DESCRIPTION / MISSION BRIEFING ========== -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This console simulates the product search feature of Nova Threads, a fictional online clothing retailer. The search box below sends your input straight into a backend SQL query with no sanitization.</p>
        <p>Your goal is to confirm the injection point, work out how many columns the query returns, enumerate the database schema, and extract data from a table that was never meant to be public.</p>
    </div>

    <!-- ========== 3. MAIN INTERACTIVE ENVIRONMENT ========== -->
    <div class="tabs">
        <button class="tab-btn active" id="tabBtnSearch" data-panel="panelSearch">Search Interface</button>
        <button class="tab-btn" id="tabBtnInspector" data-panel="panelInspector"><span class="tab-status" id="statusInspector"></span>Request Inspector</button>
        <button class="tab-btn" id="tabBtnSchema" data-panel="panelSchema"><span class="tab-status" id="statusSchema"></span>Database Schema</button>
        <button class="tab-btn" id="tabBtnData" data-panel="panelData"><span class="tab-status" id="statusData"></span>Extracted Data</button>
    </div>

    <div class="panel active" id="panelSearch">
        <div class="search-row">
            <input type="text" id="searchInput" placeholder="Search products (try: jacket)" autocomplete="off">
            <button id="searchBtn">Search</button>
        </div>
        <div class="product-grid" id="productGrid"></div>
    </div>

    <div class="panel" id="panelInspector">
        <div class="code-block" id="inspectorBlock">No requests sent yet. Run a search to see the request and query here.</div>
    </div>

    <div class="panel" id="panelSchema">
        <div id="schemaContent" class="empty-state">Schema not yet enumerated. Target information_schema.tables with a UNION SELECT to populate this panel.</div>
    </div>

    <div class="panel" id="panelData">
        <div id="dataContent" class="empty-state">No data extracted yet. Target the hidden table you discovered with a UNION SELECT.</div>
    </div>

    <!-- ========== 4. FEEDBACK / STATUS AREA ========== -->
    <div class="feedback-area" id="feedbackArea"></div>

    <!-- ========== 5. FLAG REVEAL AREA ========== -->
    <div class="flag-area" id="flagArea">
        <h3>Admin table fully extracted</h3>
        <div class="flag-value" id="flagValue">CBX{admin_table_dumped}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight-box" id="spotlightBox" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;"></div>

<div class="modal-overlay" id="completeModal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Work through the search console and find the flag.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA
// ============================================================
const products = [
    { id: 1, name: "Classic Denim Jacket", price: 89.00, category: "Outerwear" },
    { id: 2, name: "Cotton Crew Tee", price: 24.00, category: "Tops" },
    { id: 3, name: "Slim Fit Chinos", price: 62.00, category: "Bottoms" },
    { id: 4, name: "Wool Blend Overcoat", price: 145.00, category: "Outerwear" },
    { id: 5, name: "Canvas Weekender Bag", price: 78.00, category: "Accessories" },
    { id: 6, name: "Ribbed Knit Sweater", price: 54.00, category: "Tops" },
    { id: 7, name: "Tailored Trousers", price: 68.00, category: "Bottoms" },
    { id: 8, name: "Leather Belt", price: 32.00, category: "Accessories" },
    { id: 9, name: "Oxford Button Down", price: 46.00, category: "Tops" },
    { id: 10, name: "Quilted Vest", price: 71.00, category: "Outerwear" }
];

const schemaTables = ["products", "admin_users", "orders", "sessions"];

const adminRecord = {
    username: "nova_admin",
    password: "5f4dcc3b5aa765d61d8327deb882cf99",
    email: "admin@novathreads-internal.com"
};

const state = {
    columnCountConfirmed: false,
    schemaFound: false,
    dataExtracted: false
};

// ============================================================
// TAB SWITCHING
// ============================================================
const tabButtons = document.querySelectorAll('.tab-btn');
tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        tabButtons.forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(btn.dataset.panel).classList.add('active');
    });
});

// ============================================================
// HELPERS
// ============================================================
function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
}

function showFeedback(type, message) {
    const area = document.getElementById('feedbackArea');
    const div = document.createElement('div');
    div.className = 'status-msg ' + type;
    div.textContent = message;
    area.prepend(div);
    while (area.children.length > 4) {
        area.removeChild(area.lastChild);
    }
}

function renderProducts(list) {
    const grid = document.getElementById('productGrid');
    grid.innerHTML = '';
    if (list.length === 0) {
        grid.innerHTML = '<div class="empty-state">No products matched your search.</div>';
        return;
    }
    list.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `<div class="name">${escapeHtml(p.name)}</div><div class="meta">$${p.price.toFixed(2)} &middot; ${escapeHtml(p.category)}</div>`;
        grid.appendChild(card);
    });
}

function setInspector(html) {
    document.getElementById('inspectorBlock').innerHTML = html;
}

function markStatus(id) {
    document.getElementById(id).classList.add('done');
}

// ============================================================
// SEARCH HANDLING
// ============================================================
function handleSearch() {
    const raw = document.getElementById('searchInput').value;
    const trimmed = raw.trim();

    if (trimmed.length === 0) {
        showFeedback('info', 'Enter a search term first.');
        return;
    }

    // Detect UNION SELECT pattern
    const unionMatch = /union\s+select\s+(.+?)(?:--.*)?$/i.exec(trimmed);

    if (unionMatch) {
        handleUnion(trimmed, unionMatch[1]);
        return;
    }

    // Detect raw quote (syntax break) without UNION
    if (trimmed.includes("'")) {
        setInspector(
            `<span class="req-line">GET /search.php?q=${escapeHtml(raw)}</span>\n\n` +
            `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(raw)}%'</span>\n\n` +
            `<span class="err-line">Error: You have an error in your SQL syntax near '%${escapeHtml(raw)}%' at line 1</span>`
        );
        showFeedback('error', 'The query broke. The unescaped quote reached the database directly. Check the Request Inspector tab.');
        return;
    }

    // Normal search
    const term = trimmed.toLowerCase();
    const matches = products.filter(p => p.name.toLowerCase().includes(term));
    renderProducts(matches);

    setInspector(
        `<span class="req-line">GET /search.php?q=${escapeHtml(raw)}</span>\n\n` +
        `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(raw)}%'</span>\n\n` +
        `<span class="ok-line">${matches.length} row(s) returned.</span>`
    );
    showFeedback('info', 'Query executed normally. Check the Request Inspector tab to see how your input was inserted into the query.');
}

function handleUnion(fullInput, colsPart) {
    const cols = colsPart.split(',').map(c => c.trim()).filter(c => c.length > 0);
    const colCount = cols.length;

    if (colCount !== 4) {
        setInspector(
            `<span class="req-line">GET /search.php?q=${escapeHtml(fullInput)}</span>\n\n` +
            `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(fullInput)}%'</span>\n\n` +
            `<span class="err-line">Error: The used SELECT statements have a different number of columns (received ${colCount}, expected 4)</span>`
        );
        showFeedback('error', 'Column count mismatch. Adjust the number of columns in your UNION SELECT and try again.');
        return;
    }

    state.columnCountConfirmed = true;

    const targetsInfoSchema = /information_schema/i.test(fullInput);
    const targetsAdminUsers = /admin_users/i.test(fullInput);

    if (targetsAdminUsers) {
        if (!state.schemaFound) {
            setInspector(
                `<span class="req-line">GET /search.php?q=${escapeHtml(fullInput)}</span>\n\n` +
                `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(fullInput)}%'</span>\n\n` +
                `<span class="err-line">Error: Unknown table 'admin_users' in field list, or schema not yet confirmed</span>`
            );
            showFeedback('error', 'You referenced a table that has not been confirmed to exist yet. Enumerate the schema first.');
            return;
        }
        setInspector(
            `<span class="req-line">GET /search.php?q=${escapeHtml(fullInput)}</span>\n\n` +
            `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(fullInput)}%'</span>\n\n` +
            `<span class="ok-line">1 row returned from admin_users.</span>`
        );
        extractData();
        showFeedback('success', 'Data extracted from admin_users. Check the Extracted Data tab.');
        return;
    }

    if (targetsInfoSchema) {
        setInspector(
            `<span class="req-line">GET /search.php?q=${escapeHtml(fullInput)}</span>\n\n` +
            `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(fullInput)}%'</span>\n\n` +
            `<span class="ok-line">4 row(s) returned from information_schema.tables.</span>`
        );
        populateSchema();
        showFeedback('success', 'Schema enumerated successfully. Check the Database Schema tab.');
        return;
    }

    // Valid column count, generic union, no specific target yet
    setInspector(
        `<span class="req-line">GET /search.php?q=${escapeHtml(fullInput)}</span>\n\n` +
        `<span class="sql-line">SELECT id, name, price, category FROM products WHERE name LIKE '%${escapeHtml(fullInput)}%'</span>\n\n` +
        `<span class="ok-line">Query executed successfully. Column count confirmed: 4</span>`
    );
    showFeedback('success', 'Column count confirmed as 4. Now target information_schema.tables to enumerate the database.');
}

function populateSchema() {
    if (state.schemaFound) return;
    state.schemaFound = true;
    markStatus('statusSchema');
    const content = document.getElementById('schemaContent');
    let rows = schemaTables.map(t => `<tr><td>${escapeHtml(t)}</td></tr>`).join('');
    content.className = '';
    content.innerHTML = `
        <table class="data-table">
            <thead><tr><th>table_name</th></tr></thead>
            <tbody>${rows}</tbody>
        </table>
    `;
}

function extractData() {
    if (state.dataExtracted) return;
    state.dataExtracted = true;
    markStatus('statusData');
    const content = document.getElementById('dataContent');
    content.className = '';
    content.innerHTML = `
        <table class="data-table">
            <thead><tr><th>username</th><th>password</th><th>email</th></tr></thead>
            <tbody>
                <tr>
                    <td>${escapeHtml(adminRecord.username)}</td>
                    <td>${escapeHtml(adminRecord.password)}</td>
                    <td>${escapeHtml(adminRecord.email)}</td>
                </tr>
            </tbody>
        </table>
    `;
    document.getElementById('flagArea').classList.add('show');
    document.getElementById('flagArea').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

document.getElementById('searchBtn').addEventListener('click', handleSearch);
document.getElementById('searchInput').addEventListener('keydown', e => {
    if (e.key === 'Enter') handleSearch();
});

// ============================================================
// TUTORIAL SPOTLIGHT SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetId: 'searchInput',
        title: 'Search Box',
        text: 'This is the storefront search bar. Real applications often build SQL queries directly from input like this, which makes it a common starting point for injection testing.'
    },
    {
        targetId: 'searchBtn',
        title: 'Run Search',
        text: 'Submitting runs the simulated query behind the scenes. Watch the panels below after each search to see what happened.'
    },
    {
        targetId: 'tabBtnInspector',
        title: 'Request Inspector',
        text: 'This shows the raw query built from your search term, similar to a network inspector in a browser. This is where a broken query reveals structure.'
    },
    {
        targetId: 'tabBtnSchema',
        title: 'Database Schema',
        text: 'A successful UNION SELECT against the schema will populate this panel with the names of tables in the database.'
    },
    {
        targetId: 'tabBtnData',
        title: 'Extracted Data',
        text: 'Data pulled from a targeted hidden table appears here. This is the final stage of the challenge.'
    },
    {
        targetId: 'tutorialBtn',
        title: 'Replay Anytime',
        text: 'You can reopen this tutorial from this button whenever you need a refresher.'
    }
];

let currentStep = 0;

function getSpotlightRect(el) {
    const rect = el.getBoundingClientRect();
    const padding = 8;
    return {
        top: rect.top - padding,
        left: rect.left - padding,
        width: rect.width + padding * 2,
        height: rect.height + padding * 2
    };
}

function positionTutorial(step) {
    const el = document.getElementById(step.targetId);
    if (!el) return;

    const isVisible = el.getBoundingClientRect().top >= 0 &&
                       el.getBoundingClientRect().bottom <= window.innerHeight;

    const place = () => {
        const rect = getSpotlightRect(el);
        const spotlight = document.getElementById('spotlightBox');
        spotlight.style.display = 'block';
        spotlight.style.top = rect.top + 'px';
        spotlight.style.left = rect.left + 'px';
        spotlight.style.width = rect.width + 'px';
        spotlight.style.height = rect.height + 'px';

        const tooltip = document.getElementById('tooltipCard');
        tooltip.style.display = 'block';
        tooltip.innerHTML = `
            <h4>${escapeHtml(step.title)}</h4>
            <p>${escapeHtml(step.text)}</p>
            <div class="tooltip-actions">
                <button class="tt-skip" id="ttSkip">Skip Tutorial</button>
                <button class="tt-next" id="ttNext">${currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next'}</button>
            </div>
        `;

        const targetRect = el.getBoundingClientRect();
        let top = targetRect.bottom + 16;
        let left = targetRect.left;

        const tooltipWidth = 300;
        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 160 > window.innerHeight) {
            top = targetRect.top - 170;
        }
        if (top < 10) top = 10;
        if (left < 10) left = 10;

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';

        document.getElementById('ttNext').addEventListener('click', nextTutorialStep);
        document.getElementById('ttSkip').addEventListener('click', endTutorial);
    };

    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(place, 300);
    } else {
        place();
    }
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    positionTutorial(tutorialSteps[currentStep]);
}

function endTutorial(completed) {
    document.getElementById('spotlightBox').style.display = 'none';
    document.getElementById('tooltipCard').style.display = 'none';
    if (completed) {
        document.getElementById('completeModal').classList.add('show');
    }
}

function startTutorial() {
    currentStep = 0;
    tabButtons.forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tabBtnSearch').classList.add('active');
    document.getElementById('panelSearch').classList.add('active');
    positionTutorial(tutorialSteps[0]);
}

document.getElementById('tutorialBtn').addEventListener('click', startTutorial);
document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (document.getElementById('spotlightBox').style.display === 'block') {
        positionTutorial(tutorialSteps[currentStep]);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
