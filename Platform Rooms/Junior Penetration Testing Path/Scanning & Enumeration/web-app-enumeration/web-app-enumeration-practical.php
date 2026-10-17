<?php
// ============================================================
// web-app-enumeration-practical.php
// Standalone static practical: Endpoint Scanner
// No backend logic. HTML, CSS, and vanilla JS only.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Endpoint Scanner - corptech-portal.local</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

.mono { font-family: 'JetBrains Mono', monospace; }

.page-wrap {
    max-width: 960px;
    margin: 0 auto;
    padding: 30px 20px 60px 20px;
    position: relative;
}

/* ===== Header ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 20px;
}
.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.9rem;
    color: var(--accent-primary);
}
.header p {
    margin: 0;
    color: var(--text-secondary);
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover { border-color: var(--accent-primary); }

/* ===== Description ===== */
.description-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 26px;
}
.description-box h3 {
    margin-top: 0;
    color: var(--text-primary);
    font-size: 1rem;
}
.description-box p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.92rem;
}

/* ===== Main environment ===== */
.env-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px;
}
.panel h3 {
    margin: 0 0 14px 0;
    font-size: 0.95rem;
    color: var(--accent-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}

.scan-controls {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
#wordlist-input {
    flex: 1;
    min-width: 220px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-muted);
    padding: 10px 14px;
    border-radius: 8px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
}
#scan-button {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
}
#scan-button:hover { box-shadow: var(--glow-accent); }
#scan-button:disabled { opacity: 0.5; cursor: not-allowed; }

#request-log {
    margin-top: 16px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    height: 180px;
    overflow-y: auto;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
}
.log-line { padding: 3px 0; color: var(--text-muted); }
.log-status-200 { color: var(--success); }
.log-status-403 { color: var(--warning); }
.log-status-404 { color: var(--text-muted); }

#discovered-panel {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.discovered-empty {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-style: italic;
}
.discovered-item {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}
.discovered-item:hover { border-color: var(--accent-primary); }
.discovered-item.inspected { border-color: var(--success); }
.discovered-item .path { font-family: 'JetBrains Mono', monospace; color: var(--text-primary); font-size: 0.85rem; }
.discovered-item .status-tag {
    font-size: 0.7rem;
    padding: 2px 8px;
    border-radius: 12px;
    background: rgba(61,255,154,0.12);
    color: var(--success);
}
.discovered-item.flag-item .status-tag {
    background: rgba(139,123,255,0.15);
    color: var(--accent-secondary);
}

#path-inspector {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    min-height: 90px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
#path-inspector .inspector-title {
    color: var(--accent-primary);
    font-weight: 600;
    margin-bottom: 8px;
    font-family: 'JetBrains Mono', monospace;
}

/* ===== Status area ===== */
#status-area {
    margin-top: 6px;
    font-size: 0.85rem;
    color: var(--text-secondary);
    min-height: 20px;
}

/* ===== Flag reveal ===== */
#flag-area {
    display: none;
    margin-top: 20px;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(106,227,255,0.05));
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 20px 24px;
    text-align: center;
}
#flag-area h3 { color: var(--success); margin-top: 0; }
#flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.15rem;
    color: var(--text-primary);
    background: var(--bg-primary);
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    border: 1px solid var(--border-default);
    margin-top: 8px;
    user-select: all;
}

/* ===== Tutorial ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: none;
    z-index: 9998;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    flex: 1;
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid var(--border-default);
    background: var(--bg-primary);
    color: var(--text-primary);
    cursor: pointer;
    font-size: 0.8rem;
}
.tooltip-actions .btn-next {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    font-weight: 600;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 30px;
    max-width: 360px;
    text-align: center;
}
.modal-box h3 { color: var(--accent-primary); margin-top: 0; }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; }
.modal-box button {
    margin-top: 10px;
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .scan-controls { flex-direction: column; }
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="header">
        <div>
            <h1>Endpoint Scanner</h1>
            <p>Target: <span class="mono">corptech-portal.local</span></p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="description-box">
        <h3>Mission Briefing</h3>
        <p>This environment simulates a directory enumeration tool pointed at a fictional target, corptech-portal.local. The wordlist below is fixed and represents a typical set of common directory and file names.</p>
        <p>Run the scan, watch the request log, then open every entry in the Discovered Paths panel to see what each one exposes. Fully mapping the target's surface will reveal a hidden final path.</p>
    </div>

    <div class="env-grid">

        <div class="panel">
            <h3><i class="fas fa-list"></i> Scanner Controls</h3>
            <div class="scan-controls">
                <input type="text" id="wordlist-input" class="mono" readonly
                    value="wp-admin, private, admin, backup.zip, config.php.bak, api/v1/users, old-site, test">
                <button id="scan-button">Run Scan</button>
            </div>
            <div id="request-log"></div>
        </div>

        <div class="panel">
            <h3><i class="fas fa-folder-open"></i> Discovered Paths</h3>
            <div id="discovered-panel">
                <div class="discovered-empty">Run the scan to populate this panel.</div>
            </div>
        </div>

        <div class="panel">
            <h3><i class="fas fa-magnifying-glass"></i> Path Inspector</h3>
            <div id="path-inspector">Click a discovered path to inspect it.</div>
        </div>

    </div>

    <div id="status-area"></div>

    <div id="flag-area">
        <h3>Target Fully Mapped</h3>
        <p>You have uncovered the full exposed surface of corptech-portal.local.</p>
        <div id="flag-value">CBX{endpoints_mapped}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="skip-btn">Skip Tutorial</button>
        <button class="btn-next" id="next-btn">Next</button>
    </div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// Simulated scan dataset (fixed)
// ============================================================
const scanResults = [
    { path: '/wp-admin', status: 404 },
    { path: '/private', status: 403 },
    { path: '/admin', status: 200, discovered: true, name: 'Admin Panel' },
    { path: '/backup.zip', status: 200, discovered: true, name: 'Backup File' },
    { path: '/config.php.bak', status: 200, discovered: true, name: 'Config File' },
    { path: '/api/v1/users', status: 200, discovered: true, name: 'API Route' },
    { path: '/old-site', status: 404 },
    { path: '/test', status: 404 }
];

const inspectionContent = {
    '/admin': {
        title: '/admin - Admin Panel',
        html: 'A login screen labeled "CorpTech Admin Console" appears. No credentials are provided in this simulation, but a real attacker would now attempt default or common passwords here.'
    },
    '/backup.zip': {
        title: '/backup.zip - Backup File',
        html: 'The archive contains two files: <span class="mono">database_dump.sql</span> and <span class="mono">users_export.csv</span>. Both would normally be highly sensitive.'
    },
    '/config.php.bak': {
        title: '/config.php.bak - Config File',
        html: 'The leaked source reveals a database hostname of <span class="mono">db.corptech-portal.local</span> and a placeholder credential string, exactly the kind of leak a real config backup causes.'
    },
    '/api/v1/users': {
        title: '/api/v1/users - API Route',
        html: 'The endpoint returns a JSON array of sample user objects, confirming an active API surface that is not linked from any visible page.'
    }
};

let inspectedCount = 0;
const requiredInspections = 4;
let scanHasRun = false;

const requestLog = document.getElementById('request-log');
const discoveredPanel = document.getElementById('discovered-panel');
const pathInspector = document.getElementById('path-inspector');
const statusArea = document.getElementById('status-area');
const scanButton = document.getElementById('scan-button');
const flagArea = document.getElementById('flag-area');

scanButton.addEventListener('click', runScan);

function runScan() {
    if (scanHasRun) return;
    scanHasRun = true;
    scanButton.disabled = true;
    requestLog.innerHTML = '';
    discoveredPanel.innerHTML = '';
    statusArea.textContent = 'Scanning corptech-portal.local ...';

    scanResults.forEach((entry, i) => {
        setTimeout(() => {
            const line = document.createElement('div');
            line.className = 'log-line';
            const statusClass = entry.status === 200 ? 'log-status-200' : (entry.status === 403 ? 'log-status-403' : 'log-status-404');
            line.innerHTML = 'GET ' + entry.path + ' -> <span class="' + statusClass + '">' + entry.status + '</span>';
            requestLog.appendChild(line);
            requestLog.scrollTop = requestLog.scrollHeight;

            if (entry.discovered) {
                addDiscovered(entry);
            }

            if (i === scanResults.length - 1) {
                statusArea.textContent = 'Scan complete. Inspect every discovered path.';
                scanButton.disabled = false;
            }
        }, i * 450);
    });
}

function addDiscovered(entry) {
    if (discoveredPanel.querySelector('.discovered-empty')) {
        discoveredPanel.innerHTML = '';
    }
    const item = document.createElement('div');
    item.className = 'discovered-item';
    item.dataset.path = entry.path;
    item.innerHTML = '<span class="path">' + entry.path + '</span><span class="status-tag">' + entry.name + '</span>';
    item.addEventListener('click', () => inspectPath(entry.path, item));
    discoveredPanel.appendChild(item);
}

function inspectPath(path, itemEl) {
    const data = inspectionContent[path];
    if (!data) return;
    pathInspector.innerHTML = '<div class="inspector-title">' + data.title + '</div><div>' + data.html + '</div>';

    if (!itemEl.classList.contains('inspected')) {
        itemEl.classList.add('inspected');
        inspectedCount++;
        checkCompletion();
    }
}

function checkCompletion() {
    if (inspectedCount >= requiredInspections) {
        statusArea.textContent = 'Full surface mapped. One more path has appeared.';
        setTimeout(revealFlagPath, 500);
    }
}

let flagPathAdded = false;
function revealFlagPath() {
    if (flagPathAdded) return;
    flagPathAdded = true;
    const item = document.createElement('div');
    item.className = 'discovered-item flag-item';
    item.innerHTML = '<span class="path">/.flag</span><span class="status-tag">Hidden File</span>';
    item.addEventListener('click', () => {
        flagArea.style.display = 'block';
        flagArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        statusArea.textContent = 'Flag revealed.';
    });
    discoveredPanel.appendChild(item);
}

// ============================================================
// Spotlight tutorial system
// ============================================================
const tutorialSteps = [
    { targetId: 'wordlist-input', text: 'This is the wordlist, a list of common directory and file names that enumeration tools try one by one against a target. Think of it as a list of doors to knock on.' },
    { targetId: 'scan-button', text: 'Click here to start the scan. Real tools like gobuster or dirbuster automate exactly this process, sending one request per wordlist entry.' },
    { targetId: 'request-log', text: 'Watch this log as it fills up. Each line is one attempt against the target and the status code it returned.' },
    { targetId: 'discovered-panel', text: 'Every path that returned a real response lands here. These are your findings, worth investigating further.' },
    { targetId: 'path-inspector', text: 'Click a discovered path to inspect it. This is where you find out what each exposed path actually reveals.' }
];

let currentStep = 0;
const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltip-card');
const tooltipText = document.getElementById('tooltip-text');
const completeModal = document.getElementById('complete-modal');

function startTutorial() {
    currentStep = 0;
    spotlight.style.display = 'block';
    tooltipCard.style.display = 'block';
    showStep(currentStep);
}

function showStep(index) {
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetId);
    if (!el) { nextStep(); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el, step.text), 300);
    } else {
        positionSpotlight(el, step.text);
    }
}

function positionSpotlight(el, text) {
    const rect = el.getBoundingClientRect();
    const pad = 8;

    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    tooltipText.textContent = text;

    let top = rect.bottom + 16;
    let left = rect.left;

    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left + 300 > window.innerWidth) {
        left = window.innerWidth - 320;
    }
    if (left < 10) left = 10;
    if (top < 10) top = 10;

    tooltipCard.style.top = top + 'px';
    tooltipCard.style.left = left + 'px';
}

document.getElementById('next-btn').addEventListener('click', nextStep);
document.getElementById('skip-btn').addEventListener('click', endTutorial);

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        completeModal.style.display = 'flex';
    } else {
        showStep(currentStep);
    }
}

function endTutorial() {
    spotlight.style.display = 'none';
    tooltipCard.style.display = 'none';
}

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    completeModal.style.display = 'none';
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (tooltipCard.style.display === 'block' && tutorialSteps[currentStep]) {
        const el = document.getElementById(tutorialSteps[currentStep].targetId);
        if (el) positionSpotlight(el, tutorialSteps[currentStep].text);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</body>
</html>
