<?php
// api-driven-security-operations-practical.php
// Standalone static practical: Webhook Response Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Webhook Response Console</title>
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
    padding: 24px;
}

.mono { font-family: 'JetBrains Mono', monospace; }

/* ===== Header ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto 20px auto;
}
.page-header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
}
.page-header p {
    color: var(--text-secondary);
    margin: 0;
    max-width: 640px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    white-space: nowrap;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== Description ===== */
.briefing {
    max-width: 1200px;
    margin: 0 auto 24px auto;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
}
.briefing h2 {
    font-size: 1rem;
    color: var(--accent-primary);
    margin: 0 0 8px 0;
}
.briefing p {
    color: var(--text-secondary);
    margin: 6px 0;
    font-size: 0.92rem;
}

/* ===== Main layout ===== */
.console-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 900px) {
    .console-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
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

/* ===== Webhook feed ===== */
#webhook-feed {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 480px;
    overflow-y: auto;
}
.event-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    cursor: pointer;
    transition: border-color 0.2s ease;
}
.event-card:hover { border-color: var(--accent-secondary); }
.event-card.active {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.event-card.done {
    opacity: 0.55;
}
.event-card .event-type {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    color: var(--accent-primary);
    margin-bottom: 6px;
}
.event-card .event-body {
    font-size: 0.82rem;
    color: var(--text-secondary);
    line-height: 1.5;
}
.event-card .event-status {
    margin-top: 8px;
    font-size: 0.75rem;
    font-weight: 600;
}
.status-pending { color: var(--text-muted); }
.status-correct { color: var(--success); }

/* ===== Action console ===== */
#action-console {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.action-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 14px 10px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.15s ease;
}
.action-btn:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.action-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
.action-btn.shake {
    animation: shakeAnim 0.35s ease;
    border-color: var(--error);
}
@keyframes shakeAnim {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-6px); }
    75% { transform: translateX(6px); }
}

.no-event-msg {
    color: var(--text-muted);
    font-size: 0.85rem;
    grid-column: 1 / -1;
    text-align: center;
    padding: 20px 0;
}

/* ===== Response log ===== */
#response-log-panel {
    max-width: 1200px;
    margin: 20px auto 0 auto;
}
#response-log {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-height: 160px;
    overflow-y: auto;
}
.log-entry {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
    padding: 6px 10px;
    border-radius: 6px;
    background: var(--bg-surface);
}
.log-correct { color: var(--success); }
.log-incorrect { color: var(--error); }
.log-empty { color: var(--text-muted); font-style: italic; }

/* ===== Flag panel ===== */
#flag-panel-wrapper {
    max-width: 1200px;
    margin: 20px auto 0 auto;
}
#flag-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 24px;
    text-align: center;
    transition: all 0.3s ease;
}
#flag-panel.locked {
    color: var(--text-muted);
}
#flag-panel.unlocked {
    border-color: var(--success);
    box-shadow: 0 0 24px rgba(61,255,154,0.25);
}
#flag-panel .flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    color: var(--success);
    margin-top: 10px;
    letter-spacing: 0.02em;
}
#flag-panel .flag-title {
    font-size: 0.95rem;
    font-weight: 600;
}

/* ===== Progress ===== */
.progress-note {
    text-align: center;
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-top: 10px;
}

/* ===== Tutorial spotlight ===== */
#spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 9000;
    display: none;
}
#tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9001;
    display: none;
    box-shadow: var(--glow-accent);
}
#tutorial-tooltip h4 {
    margin: 0 0 8px 0;
    font-size: 0.9rem;
    color: var(--accent-primary);
}
#tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.82rem;
    color: var(--text-secondary);
    line-height: 1.5;
}
.tutorial-controls {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tutorial-controls button {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-family: inherit;
    font-size: 0.78rem;
}
.tutorial-controls .next-btn {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    font-weight: 600;
}

/* ===== Modal ===== */
#tutorial-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9500;
}
#tutorial-modal {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
}
#tutorial-modal h3 {
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}
#tutorial-modal p {
    color: var(--text-secondary);
    font-size: 0.88rem;
    margin: 0 0 20px 0;
}
#tutorial-modal button {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}
</style>
</head>
<body>

<!-- ========== 1. HEADER ========== -->
<div class="page-header">
    <div>
        <h1>Webhook Response Console</h1>
        <p>You are the on call integration engineer. A simulated SIEM is pushing live webhook events into this console. Match each event to the correct automated response before the automation can be considered complete.</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</div>

<!-- ========== 2. DESCRIPTION ========== -->
<div class="briefing">
    <h2>Mission Briefing</h2>
    <p>This environment simulates a webhook driven security automation pipeline. Each card in the feed represents a real webhook payload your SIEM has just pushed. Your job is to read the payload, decide what happened, and trigger the correct automated response from the console.</p>
    <p>You must correctly action all six events before your automation is marked complete and the flag is revealed.</p>
</div>

<!-- ========== 3. MAIN INTERACTIVE ENVIRONMENT ========== -->
<div class="console-grid">
    <div class="panel">
        <h3><i></i>Webhook Event Feed</h3>
        <div id="webhook-feed"></div>
    </div>
    <div class="panel">
        <h3 id="action-console-heading">Automated Response Console</h3>
        <div id="action-console"></div>
    </div>
</div>

<!-- ========== 4. FEEDBACK / STATUS AREA ========== -->
<div id="response-log-panel" class="panel">
    <h3>Response Log</h3>
    <div id="response-log">
        <div class="log-entry log-empty">No actions taken yet. Select an event and choose a response.</div>
    </div>
    <div class="progress-note" id="progress-note">0 of 6 events triaged</div>
</div>

<!-- ========== 5. FLAG REVEAL AREA ========== -->
<div id="flag-panel-wrapper">
    <div id="flag-panel" class="locked">
        <div class="flag-title">Awaiting full triage</div>
        <div class="flag-value" id="flag-value" style="display:none;"></div>
    </div>
</div>

<!-- ===== Tutorial elements ===== -->
<div id="spotlight"></div>
<div id="tutorial-tooltip">
    <h4 id="tooltip-title"></h4>
    <p id="tooltip-text"></p>
    <div class="tutorial-controls">
        <button id="skip-tutorial-btn">Skip Tutorial</button>
        <button class="next-btn" id="next-tutorial-btn">Next</button>
    </div>
</div>

<div id="tutorial-modal-overlay">
    <div id="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Read each webhook event carefully and choose the response that matches it.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ========================
// DATA
// ========================
const events = [
    {
        id: 1,
        type: 'malware_detected',
        details: 'Host: WIN-DESKTOP-042\nFile Hash: 8f3a91c2b7e4...c12\nSeverity: High',
        correctAction: 'Isolate Host'
    },
    {
        id: 2,
        type: 'brute_force_attempt',
        details: 'Source IP: 203.0.113.55\nTarget: VPN Gateway\nFailed Logins: 47 in 10 minutes',
        correctAction: 'Block IP'
    },
    {
        id: 3,
        type: 'phishing_reported',
        details: 'Sender Domain: paypal-secure-login.com\nReported By: 3 employees\nAttachment: invoice.html',
        correctAction: 'Block Sender Domain'
    },
    {
        id: 4,
        type: 'privilege_escalation',
        details: 'Account: svc-backup\nAction: Escalated to Domain Admin\nRequested By: Unknown process',
        correctAction: 'Disable Account'
    },
    {
        id: 5,
        type: 'anomalous_api_usage',
        details: 'Integration Token: partner-sync-tok-88\nData Pulled: 4.1 GB\nGeolocation: Unrecognized region',
        correctAction: 'Revoke API Credentials'
    },
    {
        id: 6,
        type: 'ransomware_indicator',
        details: 'Process: suspicious.exe\nHost: FILESERVER-01\nBehavior: Mass file encryption detected',
        correctAction: 'Terminate Process'
    }
];

const actions = [
    'Isolate Host',
    'Block IP',
    'Block Sender Domain',
    'Disable Account',
    'Revoke API Credentials',
    'Terminate Process'
];

const FLAG = 'CBX{playbook_executed}';

let activeEventId = null;
let completedCount = 0;

// ========================
// RENDER FEED
// ========================
const feedEl = document.getElementById('webhook-feed');

function renderFeed() {
    feedEl.innerHTML = '';
    events.forEach(ev => {
        const card = document.createElement('div');
        card.className = 'event-card mono' + (ev.id === activeEventId ? ' active' : '') + (ev.solved ? ' done' : '');
        card.id = ev.id === activeEventId ? 'event-card-active' : '';
        card.dataset.eventId = ev.id;
        card.innerHTML = `
            <div class="event-type">"event_type": "${ev.type}"</div>
            <div class="event-body">${ev.details.replace(/\n/g, '<br>')}</div>
            <div class="event-status ${ev.solved ? 'status-correct' : 'status-pending'}">
                ${ev.solved ? '✓ Correctly actioned' : 'Awaiting response'}
            </div>
        `;
        card.addEventListener('click', () => {
            if (ev.solved) return;
            activeEventId = ev.id;
            renderFeed();
            renderActions();
        });
        feedEl.appendChild(card);
    });
}

// ========================
// RENDER ACTIONS
// ========================
const actionsEl = document.getElementById('action-console');

function renderActions() {
    actionsEl.innerHTML = '';
    if (activeEventId === null) {
        actionsEl.innerHTML = '<div class="no-event-msg">Select an event from the feed to choose a response.</div>';
        return;
    }
    const ev = events.find(e => e.id === activeEventId);
    actions.forEach(action => {
        const btn = document.createElement('button');
        btn.className = 'action-btn';
        btn.textContent = action;
        btn.addEventListener('click', () => handleActionClick(ev, action, btn));
        actionsEl.appendChild(btn);
    });
}

function handleActionClick(ev, action, btn) {
    if (action === ev.correctAction) {
        ev.solved = true;
        completedCount++;
        logEntry(`Event #${ev.id} (${ev.type}) -> ${action}`, true);
        activeEventId = null;
        renderFeed();
        renderActions();
        updateProgress();
        if (completedCount === events.length) {
            unlockFlag();
        }
    } else {
        logEntry(`Event #${ev.id} (${ev.type}) -> ${action} (incorrect)`, false);
        btn.classList.add('shake');
        setTimeout(() => btn.classList.remove('shake'), 350);
    }
}

// ========================
// RESPONSE LOG
// ========================
const logEl = document.getElementById('response-log');

function logEntry(text, correct) {
    if (logEl.querySelector('.log-empty')) logEl.innerHTML = '';
    const entry = document.createElement('div');
    entry.className = 'log-entry mono ' + (correct ? 'log-correct' : 'log-incorrect');
    entry.textContent = (correct ? '[OK] ' : '[RETRY] ') + text;
    logEl.prepend(entry);
}

function updateProgress() {
    document.getElementById('progress-note').textContent = `${completedCount} of ${events.length} events triaged`;
}

// ========================
// FLAG REVEAL
// ========================
function unlockFlag() {
    const panel = document.getElementById('flag-panel');
    panel.classList.remove('locked');
    panel.classList.add('unlocked');
    panel.querySelector('.flag-title').textContent = 'Automation Complete';
    const flagValueEl = document.getElementById('flag-value');
    flagValueEl.textContent = FLAG;
    flagValueEl.style.display = 'block';
}

renderFeed();
renderActions();

// ========================
// TUTORIAL SYSTEM (SPOTLIGHT)
// ========================
const tutorialSteps = [
    {
        targetId: 'webhook-feed',
        title: 'Webhook Event Feed',
        text: 'This is your live webhook feed. Your SIEM pushes an event here every time it detects something suspicious, the same way a real webhook integration works.'
    },
    {
        targetId: null, // resolved dynamically to the active card
        title: 'Event Payload',
        text: "Each card is the JSON payload your SIEM sent. Read it carefully. It tells you exactly what happened and where."
    },
    {
        targetId: 'action-console',
        title: 'Automated Response Console',
        text: 'Choose the automated response that matches this event. This is the trigger an action from a webhook pattern used in real security orchestration.'
    },
    {
        targetId: 'response-log-panel',
        title: 'Response Log',
        text: 'Every decision you make is logged here, just like an automation audit trail would be in production.'
    },
    {
        targetId: 'flag-panel-wrapper',
        title: 'Flag Panel',
        text: 'Once every event has been correctly actioned, your flag appears here.'
    }
];

let currentStep = 0;
const spotlight = document.getElementById('spotlight');
const tooltip = document.getElementById('tutorial-tooltip');
const tooltipTitle = document.getElementById('tooltip-title');
const tooltipText = document.getElementById('tooltip-text');

function getStepTarget(step) {
    if (step.targetId) return document.getElementById(step.targetId);
    // dynamic: first event card
    return document.querySelector('.event-card');
}

function positionSpotlight(el) {
    if (!el) return;
    const rect = el.getBoundingClientRect();
    const padding = 8;
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - padding) + 'px';
    spotlight.style.left = (rect.left - padding) + 'px';
    spotlight.style.width = (rect.width + padding * 2) + 'px';
    spotlight.style.height = (rect.height + padding * 2) + 'px';

    tooltip.style.display = 'block';
    const tooltipWidth = 300;
    let top = rect.bottom + 14;
    let left = rect.left;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 160 > window.innerHeight) {
        top = rect.top - 170;
    }
    tooltip.style.top = Math.max(10, top) + 'px';
    tooltip.style.left = Math.max(10, left) + 'px';
}

function showStep(index) {
    const step = tutorialSteps[index];
    if (!step) return endTutorial();
    let el = getStepTarget(step);
    if (!el) return;

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el), 300);
    } else {
        positionSpotlight(el);
    }

    tooltipTitle.textContent = step.title;
    tooltipText.textContent = step.text;
}

function startTutorial() {
    currentStep = 0;
    document.getElementById('tutorial-modal-overlay').style.display = 'none';
    showStep(currentStep);
}

function endTutorial() {
    spotlight.style.display = 'none';
    tooltip.style.display = 'none';
    document.getElementById('tutorial-modal-overlay').style.display = 'flex';
}

document.getElementById('next-tutorial-btn').addEventListener('click', () => {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        spotlight.style.display = 'none';
        tooltip.style.display = 'none';
        document.getElementById('tutorial-modal-overlay').style.display = 'flex';
    } else {
        showStep(currentStep);
    }
});

document.getElementById('skip-tutorial-btn').addEventListener('click', () => {
    spotlight.style.display = 'none';
    tooltip.style.display = 'none';
    document.getElementById('tutorial-modal-overlay').style.display = 'none';
});

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-modal-overlay').style.display = 'none';
});

document.getElementById('view-tutorial-btn').addEventListener('click', () => {
    startTutorial();
});

window.addEventListener('resize', () => {
    if (spotlight.style.display === 'block') {
        const step = tutorialSteps[currentStep];
        const el = getStepTarget(step);
        positionSpotlight(el);
    }
});

// Auto start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(() => startTutorial(), 500);
});
</script>

</body>
</html>
