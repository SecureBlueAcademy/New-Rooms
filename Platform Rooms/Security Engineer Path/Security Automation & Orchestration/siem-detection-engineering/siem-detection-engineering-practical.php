<?php
// ============================================================
// siem-detection-engineering-practical.php
// Detection Rule Workbench
// Standalone static PHP/HTML/CSS/JS practical. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detection Rule Workbench</title>
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
    line-height: 1.5;
}

.wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 24px 20px 60px 20px;
    position: relative;
}

/* ===== Header ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 8px;
}
.page-header h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}
.page-header p.subtitle {
    color: var(--text-secondary);
    margin: 0;
    max-width: 640px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    background: #1a2340;
}

/* ===== Description section ===== */
.briefing-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin: 20px 0 30px 0;
}
.briefing-box h2 {
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--accent-primary);
    margin: 0 0 10px 0;
}
.briefing-box p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.briefing-box p:last-child { margin-bottom: 0; }

/* ===== Main environment ===== */
.environment {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 20px;
}
@media (max-width: 850px) {
    .environment { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.panel h3 {
    margin: 0 0 12px 0;
    font-size: 0.95rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel h3 .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

/* Log stream panel */
#log-stream-panel {
    max-height: 480px;
    overflow-y: auto;
}
.log-line {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
    padding: 7px 10px;
    border-radius: 6px;
    margin-bottom: 5px;
    background: var(--bg-primary);
    border-left: 3px solid var(--border-default);
    color: var(--text-secondary);
}
.log-line.matched {
    border-left: 3px solid var(--accent-primary);
    color: var(--text-primary);
    background: rgba(106,227,255,0.06);
}
.log-line .log-time { color: var(--text-muted); margin-right: 8px; }
.log-line .log-type-fail { color: var(--error); }
.log-line .log-type-success { color: var(--success); }

/* Rule builder panel */
.field-group { margin-bottom: 16px; }
.field-group label {
    display: block;
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-bottom: 6px;
    font-weight: 500;
}
.field-group select,
.field-group input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 7px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
}
.field-group select:focus,
.field-group input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 7px;
    padding: 10px 12px;
}
.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
    background: var(--border-default);
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.2s ease;
    flex-shrink: 0;
}
.toggle-switch.on { background: var(--accent-secondary); }
.toggle-switch .knob {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: var(--text-primary);
    border-radius: 50%;
    transition: left 0.2s ease;
}
.toggle-switch.on .knob { left: 22px; }

/* Test results panel */
#test-results-panel {
    margin-top: 20px;
    grid-column: 1 / -1;
}
.results-summary {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.stat-chip {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.stat-chip strong {
    display: block;
    font-size: 1.2rem;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
}
.stat-chip.good strong { color: var(--success); }
.stat-chip.bad strong { color: var(--error); }

/* Flag reveal panel */
#flag-reveal-panel {
    margin-top: 24px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
}
#flag-reveal-panel.locked .flag-value { display: none; }
#flag-reveal-panel .lock-msg { color: var(--text-muted); font-size: 0.9rem; }
#flag-reveal-panel.unlocked {
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 12px 22px;
    border-radius: 8px;
    border: 1px solid var(--success);
    margin-top: 10px;
    letter-spacing: 0.03em;
}

/* ===== Tutorial spotlight ===== */
#tutorial-spotlight {
    position: fixed;
    border-radius: 10px;
    pointer-events: none;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
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
    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
    display: none;
}
#tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 7px 14px;
    cursor: pointer;
    border: none;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
}
.tt-next {
    background: var(--accent-primary);
    color: #05121a;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 { margin: 0 0 10px 0; color: var(--text-primary); }
.modal-card p { color: var(--text-secondary); margin: 0 0 18px 0; font-size: 0.9rem; }
.modal-card button {
    background: var(--accent-primary);
    color: #05121a;
    border: none;
    padding: 10px 22px;
    border-radius: 7px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
</style>
</head>
<body>

<div class="wrapper">

    <!-- 1. TOP HEADER -->
    <div class="page-header">
        <div>
            <h1>Detection Rule Workbench</h1>
            <p class="subtitle">A source IP is hammering a workstation with failed logons. Build the correlation rule that catches it cleanly.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION SECTION -->
    <div class="briefing-box">
        <h2>Mission Briefing</h2>
        <p>This environment simulates a live SIEM log feed from a small corporate network. Somewhere in the feed is a genuine brute force attack, mixed in with a full day of normal, benign logon activity.</p>
        <p>Your goal is to configure a single correlation rule on the right that fires exactly once, on the real attack, with zero false positives from the benign noise. Adjust the fields and watch the test results panel update live.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="environment">
        <div class="panel" id="log-stream-panel">
            <h3><span class="dot"></span>Log Stream</h3>
            <div id="log-lines"></div>
        </div>

        <div class="panel" id="rule-builder-panel">
            <h3><span class="dot"></span>Correlation Rule Builder</h3>

            <div class="field-group">
                <label for="event-type-select">Event Type</label>
                <select id="event-type-select">
                    <option value="Logon Failure">Logon Failure</option>
                    <option value="Process Create">Process Create</option>
                    <option value="Network Connection">Network Connection</option>
                </select>
            </div>

            <div class="field-group">
                <label for="threshold-input">Threshold (matching events required)</label>
                <input type="number" id="threshold-input" min="1" max="10" value="1">
            </div>

            <div class="field-group">
                <label for="time-window-input">Time Window (minutes)</label>
                <input type="number" id="time-window-input" min="1" max="60" value="1">
            </div>

            <div class="field-group">
                <label for="match-field-select">Match Field</label>
                <select id="match-field-select">
                    <option value="sourceIP">Source IP</option>
                    <option value="username">Username</option>
                    <option value="hostname">Hostname</option>
                </select>
            </div>

            <div class="field-group">
                <div class="toggle-row">
                    <label style="margin:0;" for="followed-by-toggle">Followed by Successful Logon</label>
                    <div class="toggle-switch" id="followed-by-toggle"><div class="knob"></div></div>
                </div>
            </div>
        </div>

        <div class="panel" id="test-results-panel">
            <h3><span class="dot"></span>Rule Test Results</h3>
            <div class="results-summary">
                <div class="stat-chip" id="chip-groups"><span>Matched Groups</span><strong id="val-groups">0</strong></div>
                <div class="stat-chip good" id="chip-tp"><span>True Positive Groups</span><strong id="val-tp">0</strong></div>
                <div class="stat-chip bad" id="chip-fp"><span>False Positives Caught</span><strong id="val-fp">0</strong></div>
            </div>
            <p id="results-message" style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">Adjust the rule fields to see how many log events this configuration would catch.</p>
        </div>
    </div>

    <!-- 4/5. FEEDBACK + FLAG REVEAL -->
    <div id="flag-reveal-panel" class="locked">
        <h3 style="margin-top:0;">Flag</h3>
        <p class="lock-msg">Configure a rule that catches the real attack with zero false positives to reveal the flag.</p>
        <div class="flag-value" id="flag-value">CBX{brute_force_correlated}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div id="tutorial-spotlight"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button class="tt-skip" id="tt-skip-btn">Skip Tutorial</button>
        <button class="tt-next" id="tt-next-btn">Next</button>
    </div>
</div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Build the rule, watch the results panel, and catch the attack.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ================================================================
// LOG DATA
// Format: [time in minutes since 00:00, eventType, sourceIP, username, hostname]
// ================================================================
const logData = [
    { t: 554.03, type: 'Logon Failure', ip: '203.0.113.45', user: 'admin',        host: 'WKSTN-14' },
    { t: 554.32, type: 'Logon Failure', ip: '203.0.113.45', user: 'administrator', host: 'WKSTN-14' },
    { t: 554.62, type: 'Logon Failure', ip: '203.0.113.45', user: 'root',         host: 'WKSTN-14' },
    { t: 554.97, type: 'Logon Failure', ip: '203.0.113.45', user: 'svc-admin',    host: 'WKSTN-14' },
    { t: 555.68, type: 'Logon Failure', ip: '203.0.113.45', user: 'backup',       host: 'WKSTN-14' },
    { t: 555.87, type: 'Logon Success', ip: '203.0.113.45', user: 'jsmith',       host: 'WKSTN-14' },

    { t: 482.18, type: 'Logon Failure', ip: '10.1.4.22', user: 'mrivera', host: 'WKSTN-02' },
    { t: 482.57, type: 'Logon Failure', ip: '10.1.4.22', user: 'mrivera', host: 'WKSTN-02' },
    { t: 482.83, type: 'Logon Success', ip: '10.1.4.22', user: 'mrivera', host: 'WKSTN-02' },
    { t: 611.08, type: 'Logon Failure', ip: '10.1.4.9',  user: 'svc-backup', host: 'SVC-BACKUP' },
    { t: 705.37, type: 'Logon Failure', ip: '10.1.4.45', user: 'tkoenig', host: 'WKSTN-07' },
    { t: 800.17, type: 'Logon Failure', ip: '10.1.4.61', user: 'plowe', host: 'WKSTN-11' },
    { t: 845.55, type: 'Logon Failure', ip: '10.1.4.18', user: 'ndiaz', host: 'WKSTN-03' },
    { t: 912.78, type: 'Logon Success', ip: '10.1.4.22', user: 'mrivera', host: 'WKSTN-02' },
    { t: 990.03, type: 'Logon Failure', ip: '10.1.4.77', user: 'kwalsh', host: 'WKSTN-19' },
    { t: 991.30, type: 'Logon Failure', ip: '10.1.4.77', user: 'kwalsh', host: 'WKSTN-19' },
    { t: 1022.15, type: 'Logon Success', ip: '10.1.4.5', user: 'agreen', host: 'WKSTN-01' },
    { t: 1065.00, type: 'Logon Failure', ip: '10.1.4.30', user: 'bharper', host: 'WKSTN-15' },
];

function formatTime(tMinutes) {
    const h = Math.floor(tMinutes / 60);
    const m = Math.floor(tMinutes % 60);
    const s = Math.round((tMinutes * 60) % 60);
    return String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
}

function renderLogs(matchedTimestamps) {
    const container = document.getElementById('log-lines');
    container.innerHTML = '';
    logData.forEach(entry => {
        const div = document.createElement('div');
        const isMatched = matchedTimestamps.has(entry.t);
        div.className = 'log-line' + (isMatched ? ' matched' : '');
        const typeClass = entry.type === 'Logon Failure' ? 'log-type-fail' : 'log-type-success';
        div.innerHTML = '<span class="log-time">' + formatTime(entry.t) + '</span>' +
            '<span class="' + typeClass + '">' + entry.type + '</span>' +
            ' | IP: ' + entry.ip + ' | user: ' + entry.user + ' | host: ' + entry.host;
        container.appendChild(div);
    });
}

// ================================================================
// RULE EVALUATION
// ================================================================
const fieldMap = { sourceIP: 'ip', username: 'user', hostname: 'host' };

function evaluateRule() {
    const eventType = document.getElementById('event-type-select').value;
    const threshold = parseInt(document.getElementById('threshold-input').value, 10) || 1;
    const windowMin = parseFloat(document.getElementById('time-window-input').value) || 1;
    const matchField = document.getElementById('match-field-select').value;
    const followedBy = document.getElementById('followed-by-toggle').classList.contains('on');
    const key = fieldMap[matchField];

    // Group matching events by the match field value
    const groups = {};
    logData.forEach(entry => {
        if (entry.type !== eventType) return;
        if (!groups[entry[key]]) groups[entry[key]] = [];
        groups[entry[key]].push(entry);
    });

    let matchedGroupsCount = 0;
    let tpCount = 0;
    let fpCount = 0;
    const matchedTimestamps = new Set();
    const attackerIdentifiers = ['203.0.113.45', 'WKSTN-14'];

    Object.keys(groups).forEach(groupKey => {
        const events = groups[groupKey].sort((a, b) => a.t - b.t);
        if (events.length < threshold) return;

        // Sliding window check: does any consecutive run of `threshold` events
        // fall within `windowMin` minutes of each other?
        let qualifyingRun = null;
        for (let i = 0; i + threshold - 1 < events.length; i++) {
            const first = events[i];
            const last = events[i + threshold - 1];
            if ((last.t - first.t) <= windowMin) {
                qualifyingRun = events.slice(i, i + threshold);
            }
        }
        if (!qualifyingRun) return;

        // Followed by successful logon check
        if (followedBy) {
            const lastEventTime = qualifyingRun[qualifyingRun.length - 1].t;
            const hasSuccessAfter = logData.some(e =>
                e.type === 'Logon Success' &&
                e[key] === groupKey &&
                e.t >= lastEventTime &&
                e.t <= lastEventTime + 5
            );
            if (!hasSuccessAfter) return;
        }

        matchedGroupsCount++;
        qualifyingRun.forEach(e => matchedTimestamps.add(e.t));
        if (followedBy) {
            const lastEventTime = qualifyingRun[qualifyingRun.length - 1].t;
            const successEvent = logData.find(e =>
                e.type === 'Logon Success' &&
                e[key] === groupKey &&
                e.t >= lastEventTime &&
                e.t <= lastEventTime + 5
            );
            if (successEvent) matchedTimestamps.add(successEvent.t);
        }

        if (attackerIdentifiers.includes(groupKey)) {
            tpCount++;
        } else {
            fpCount++;
        }
    });

    document.getElementById('val-groups').textContent = matchedGroupsCount;
    document.getElementById('val-tp').textContent = tpCount;
    document.getElementById('val-fp').textContent = fpCount;

    renderLogs(matchedTimestamps);

    const msgEl = document.getElementById('results-message');
    const flagPanel = document.getElementById('flag-reveal-panel');

    if (tpCount === 1 && fpCount === 0) {
        msgEl.textContent = 'This rule catches the real attack with zero false positives. Detection confirmed.';
        flagPanel.classList.remove('locked');
        flagPanel.classList.add('unlocked');
    } else {
        flagPanel.classList.remove('unlocked');
        flagPanel.classList.add('locked');
        if (matchedGroupsCount === 0) {
            msgEl.textContent = 'No groups matched. Try lowering the threshold or widening the time window.';
        } else if (fpCount > 0) {
            msgEl.textContent = 'This rule is also catching benign activity. Tighten the threshold or time window to cut the false positives.';
        } else {
            msgEl.textContent = 'Rule configuration does not isolate the real attack yet. Keep adjusting.';
        }
    }
}

['event-type-select', 'match-field-select'].forEach(id => {
    document.getElementById(id).addEventListener('change', evaluateRule);
});
['threshold-input', 'time-window-input'].forEach(id => {
    document.getElementById(id).addEventListener('input', evaluateRule);
});
document.getElementById('followed-by-toggle').addEventListener('click', function() {
    this.classList.toggle('on');
    evaluateRule();
});

// Initial render
evaluateRule();

// ================================================================
// TUTORIAL SPOTLIGHT SYSTEM
// ================================================================
const tutorialSteps = [
    { targetId: 'log-stream-panel', text: 'This is your raw log feed. Real SIEMs ingest thousands of these every second from endpoints and network devices.' },
    { targetId: 'rule-builder-panel', text: 'This is where you define a correlation rule: logic that links multiple events into one meaningful alert.' },
    { targetId: 'event-type-select', text: 'Choose which type of event this rule watches for. Start with what the attack actually generates.' },
    { targetId: 'threshold-input', text: 'How many matching events must occur before this counts as suspicious? Too low causes noise, too high misses attacks.' },
    { targetId: 'time-window-input', text: 'Events only count together if they happen within this window. This is what separates a real burst from unrelated events.' },
    { targetId: 'match-field-select', text: 'Choose what ties the events together: the same source IP, the same user, or the same host.' },
    { targetId: 'followed-by-toggle', text: 'Real brute force attempts often end in success. This adds that final condition to the rule.' },
    { targetId: 'test-results-panel', text: 'Watch this panel update live. It shows exactly what your rule would catch, and what it would miss.' },
    { targetId: 'flag-reveal-panel', text: 'Once your rule catches the real attack with zero false positives, your flag appears here.' },
];

let currentStep = 0;
const spotlight = document.getElementById('tutorial-spotlight');
const tooltip = document.getElementById('tutorial-tooltip');
const tooltipText = document.getElementById('tooltip-text');

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';
    spotlight.style.display = 'block';

    const tooltipWidth = 300;
    let top, left;
    const spaceBelow = window.innerHeight - rect.bottom;
    if (spaceBelow > 160) {
        top = rect.bottom + 16;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - tooltipWidth - 10);
    } else if (rect.top > 160) {
        top = rect.top - 150;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - tooltipWidth - 10);
    } else if (rect.left > tooltipWidth + 40) {
        top = rect.top;
        left = rect.left - tooltipWidth - 20;
    } else {
        top = rect.top;
        left = Math.min(rect.right + 20, window.innerWidth - tooltipWidth - 10);
    }
    tooltip.style.top = Math.max(10, top) + 'px';
    tooltip.style.left = left + 'px';
    tooltip.style.display = 'block';
}

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    currentStep = index;
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetId);
    tooltipText.textContent = step.text;

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el), 300);
    } else {
        positionSpotlight(el);
    }

    document.getElementById('tt-next-btn').textContent = (index === tutorialSteps.length - 1) ? 'Finish' : 'Next';
}

function startTutorial() {
    spotlight.style.display = 'block';
    tooltip.style.display = 'block';
    showStep(0);
}

function endTutorial(completed) {
    spotlight.style.display = 'none';
    tooltip.style.display = 'none';
    if (completed) {
        document.getElementById('tutorial-complete-modal').style.display = 'flex';
    }
}

document.getElementById('tt-next-btn').addEventListener('click', () => showStep(currentStep + 1));
document.getElementById('tt-skip-btn').addEventListener('click', () => endTutorial(false));
document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').style.display = 'none';
});

window.addEventListener('resize', () => {
    if (spotlight.style.display === 'block') {
        const step = tutorialSteps[currentStep];
        const el = document.getElementById(step.targetId);
        positionSpotlight(el);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
