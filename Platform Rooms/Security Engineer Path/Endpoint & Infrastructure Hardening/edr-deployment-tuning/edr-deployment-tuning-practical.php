<?php
// Filename: edr-deployment-tuning-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EDR Tuning Console</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.page-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== HEADER ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 25px;
}
.top-header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}
.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 620px;
}
#tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
}
#tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== DESCRIPTION ===== */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 28px;
}
.mission-briefing h3 {
    margin-top: 0;
    font-size: 1rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    color: var(--text-secondary);
    font-size: 0.92rem;
    margin: 8px 0;
}

/* ===== ALERT LIST ===== */
#alert-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 30px;
}
.alert-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 18px;
}
.alert-card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 14px;
    flex-wrap: wrap;
}
.alert-info h4 {
    margin: 0 0 4px 0;
    font-size: 1rem;
    color: var(--text-primary);
}
.alert-info .proc-path {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    color: var(--text-muted);
}
.alert-freq {
    font-size: 0.78rem;
    color: var(--text-secondary);
    white-space: nowrap;
}
.rep-toggle {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--accent-secondary);
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.78rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    margin-top: 8px;
}
.rep-panel {
    display: none;
    margin-top: 10px;
    padding: 10px 14px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    font-size: 0.82rem;
    color: var(--text-secondary);
    font-family: 'JetBrains Mono', monospace;
}
.rep-panel.open { display: block; }

.action-buttons {
    display: flex;
    gap: 8px;
    margin-top: 14px;
    flex-wrap: wrap;
}
.action-btn {
    flex: 1;
    min-width: 120px;
    padding: 9px 10px;
    border-radius: 7px;
    border: 1px solid var(--border-default);
    background: var(--bg-primary);
    color: var(--text-secondary);
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.action-btn:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
.action-btn.selected {
    background: var(--accent-secondary);
    border-color: var(--accent-secondary);
    color: #0b0f1a;
}

/* ===== SUBMIT / STATUS ===== */
.status-area {
    text-align: center;
    margin: 20px 0;
}
#submit-btn {
    background: linear-gradient(135deg, #1a3a4a, #12182b);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 14px 34px;
    border-radius: 9px;
    font-family: 'Inter', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    letter-spacing: 0.02em;
}
#submit-btn:hover { box-shadow: var(--glow-accent); }
#status-message {
    margin-top: 14px;
    font-size: 0.9rem;
    color: var(--warning);
    min-height: 1.2em;
}
#status-message.error { color: var(--error); }
#status-message.success { color: var(--success); }

/* ===== FLAG PANEL ===== */
#flag-panel {
    display: none;
    margin-top: 25px;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 24px;
    text-align: center;
}
#flag-panel.revealed { display: block; }
#flag-panel h3 { color: var(--success); margin-top: 0; }
#flag-panel .fp-rate {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 14px;
}
#flag-value {
    display: inline-block;
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 20px;
    border-radius: 7px;
    letter-spacing: 0.03em;
}

/* ===== TUTORIAL SPOTLIGHT ===== */
#spotlight {
    position: fixed;
    z-index: 9998;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    display: none;
}
#tooltip-card {
    position: fixed;
    z-index: 9999;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: var(--glow-accent);
    display: none;
}
#tooltip-card p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin: 0 0 12px 0;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 6px 14px;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    cursor: pointer;
}
.tooltip-step-count { font-size: 0.75rem; color: var(--text-muted); }

/* ===== MODAL ===== */
#tutorial-complete-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 10000;
    background: rgba(0,0,0,0.75);
    align-items: center;
    justify-content: center;
}
#tutorial-complete-modal.open { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { color: var(--accent-primary); margin-top: 0; }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; }
.modal-box button {
    margin-top: 10px;
    background: var(--accent-secondary);
    border: none;
    color: #0b0f1a;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="top-header" id="console-header">
        <div>
            <h1>EDR Tuning Console</h1>
            <div class="subtitle">Fleet alert volume is climbing. Triage each alert correctly to bring the false-positive rate down without opening a detection gap.</div>
        </div>
        <button id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </div>

    <div class="mission-briefing">
        <h3>Mission Briefing</h3>
        <p>This console represents the live alert feed from your organization's EDR sensors. Eight alerts are currently open. For each one, review the process, its file path, its frequency across the fleet, and its reputation data.</p>
        <p>Decide the correct action for each: <strong>Exclude</strong>, <strong>Detect-Only</strong>, or <strong>Leave in Prevent</strong>. Submit once all eight are set. Get every one correct to reveal your flag.</p>
    </div>

    <div id="alert-list"></div>

    <div class="status-area">
        <button id="submit-btn" onclick="submitTriage()">Submit Triage Decisions</button>
        <div id="status-message"></div>
    </div>

    <div id="flag-panel">
        <h3>Tuning Complete</h3>
        <div class="fp-rate">Fleet false-positive rate reduced from 34% to 2%.</div>
        <div id="flag-value">CBX{signal_tuned}</div>
    </div>

</div>

<div id="spotlight"></div>
<div id="tooltip-card">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <span class="tooltip-step-count" id="tooltip-step-count"></span>
        <div>
            <button onclick="skipTutorial()">Skip</button>
            <button onclick="nextTutorialStep()">Next</button>
        </div>
    </div>
</div>

<div id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're Ready to Start the Challenge</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
// ==========================================================
// ALERT DATA
// ==========================================================
const alerts = [
    {
        id: 'alert-1',
        name: 'BackupAgent.exe',
        path: 'C:\\Program Files\\CorpBackup\\BackupAgent.exe',
        freq: '4,812 endpoints, last 24 hours',
        rep: 'Signed by CorpBackup Inc. Hash matches known-good vendor database. Behavior: rapid sequential file reads across user profile folders during scheduled backup window.',
        correct: 'exclude'
    },
    {
        id: 'alert-2',
        name: 'update_helper.exe',
        path: 'C:\\Users\\Public\\update_helper.exe',
        freq: '1 endpoint',
        rep: 'Unsigned binary. No match in known-good or threat intel database. Spawned powershell.exe with a base64 encoded command line argument.',
        correct: 'prevent'
    },
    {
        id: 'alert-3',
        name: 'PsExec.exe',
        path: 'C:\\Windows\\Temp\\PsExec.exe',
        freq: '1 endpoint, 10:14 AM local time',
        rep: 'Signed by Microsoft (Sysinternals). Executed from IT-ADMIN-04, a known administrator workstation, during normal business hours.',
        correct: 'detect-only'
    },
    {
        id: 'alert-4',
        name: 'scan_engine.exe',
        path: 'C:\\Program Files\\SecureVendor\\scan_engine.exe',
        freq: '5,203 endpoints, continuous',
        rep: 'Signed by SecureVendor Ltd, a known security tooling publisher. Hash matches known-good database. High frequency file access consistent with fleet-wide scanning.',
        correct: 'exclude'
    },
    {
        id: 'alert-5',
        name: 'invoice_march.docm',
        path: 'C:\\Users\\jsmith\\Downloads\\invoice_march.docm',
        freq: '1 endpoint',
        rep: 'Macro-enabled Word document. No known-good match. Macro launched cmd.exe immediately after the document was opened.',
        correct: 'prevent'
    },
    {
        id: 'alert-6',
        name: 'lob_reporting.exe',
        path: 'C:\\LOBApps\\Reporting\\lob_reporting.exe',
        freq: '312 endpoints, finance department',
        rep: 'Unsigned internal line-of-business application. Hash matches an entry in the internal known-hash allow list. Self-unpacks additional code into memory at startup, a known and expected behavior for this app.',
        correct: 'exclude-hash-only'
    },
    {
        id: 'alert-7',
        name: 'rundll32.exe',
        path: 'C:\\Windows\\Temp\\cache_x92.dll',
        freq: '1 endpoint',
        rep: 'rundll32.exe loading a DLL from a Temp directory. No known-good match. Outbound network connection to an external IP immediately after load.',
        correct: 'prevent'
    },
    {
        id: 'alert-8',
        name: 'certutil.exe',
        path: 'C:\\Windows\\System32\\certutil.exe',
        freq: '1 endpoint, scheduled task "SysMaintenance"',
        rep: 'Signed by Microsoft. Invoked with -decode argument against a file dropped in a temp path minutes earlier, triggered by a scheduled task not present a week ago.',
        correct: 'prevent'
    }
];

// action button labels mapped to correct-value keys
// exclude-hash-only also counts as correct when learner picks "exclude" AND acknowledges hash scope via the same button (simplified to one exclude option for interaction clarity)
function normalizeCorrect(val) {
    if (val === 'exclude-hash-only') return 'exclude';
    return val;
}

// ==========================================================
// RENDER ALERTS
// ==========================================================
const alertListEl = document.getElementById('alert-list');
const selections = {};

alerts.forEach((a, idx) => {
    const card = document.createElement('div');
    card.className = 'alert-card';
    card.id = a.id;
    card.innerHTML = `
        <div class="alert-card-top">
            <div class="alert-info">
                <h4>${a.name}</h4>
                <div class="proc-path">${a.path}</div>
            </div>
            <div class="alert-freq">${a.freq}</div>
        </div>
        <button class="rep-toggle" onclick="toggleRep('${a.id}')">Expand Reputation Data</button>
        <div class="rep-panel" id="rep-${a.id}">${a.rep}</div>
        <div class="action-buttons" id="actions-${a.id}">
            <button class="action-btn" onclick="selectAction('${a.id}','exclude',this)">Exclude</button>
            <button class="action-btn" onclick="selectAction('${a.id}','detect-only',this)">Detect-Only</button>
            <button class="action-btn" onclick="selectAction('${a.id}','prevent',this)">Leave in Prevent</button>
        </div>
    `;
    alertListEl.appendChild(card);
});

function toggleRep(id) {
    document.getElementById('rep-' + id).classList.toggle('open');
}

function selectAction(id, action, btn) {
    selections[id] = action;
    const group = document.getElementById('actions-' + id);
    [...group.children].forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

function submitTriage() {
    const statusEl = document.getElementById('status-message');
    const total = alerts.length;
    let correctCount = 0;
    let answeredCount = 0;

    alerts.forEach(a => {
        const chosen = selections[a.id];
        if (chosen) answeredCount++;
        if (chosen && chosen === normalizeCorrect(a.correct)) correctCount++;
    });

    if (answeredCount < total) {
        statusEl.textContent = `Please classify all ${total} alerts before submitting. ${total - answeredCount} remaining.`;
        statusEl.className = 'error';
        return;
    }

    if (correctCount === total) {
        statusEl.textContent = 'All alerts correctly triaged.';
        statusEl.className = 'success';
        document.getElementById('flag-panel').classList.add('revealed');
        document.getElementById('flag-panel').scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        const wrong = total - correctCount;
        statusEl.textContent = `${wrong} of ${total} alerts still need reconsideration. Review the reputation data again.`;
        statusEl.className = 'error';
    }
}

// ==========================================================
// TUTORIAL SYSTEM (Spotlight-based)
// ==========================================================
const tutorialSteps = [
    { targetElementId: 'console-header', tooltipText: 'This is the fleet\'s live EDR alert console. Every alert your sensors generate lands here for triage, just like a SOC dashboard in a real environment.' },
    { targetElementId: 'alert-list', tooltipText: 'Each card below is one open alert. You will review all eight before submitting your decisions.' },
    { targetElementId: 'alert-1', tooltipText: 'Every alert shows the process name, its file path, and how often it has fired across the fleet.' },
    { targetElementId: 'rep-toggle-sample', tooltipText: 'Click "Expand Reputation Data" on any alert to see whether the file is signed and whether it matches a known-good or known-bad hash.' },
    { targetElementId: 'actions-alert-1', tooltipText: 'For each alert choose Exclude, Detect-Only, or Leave in Prevent. Think about how narrowly an exclusion should be scoped.' },
    { targetElementId: 'submit-btn', tooltipText: 'Once all eight alerts are set, submit your triage decisions here.' }
];

let currentStep = -1;
let resizeHandlerAttached = false;

function startTutorial() {
    currentStep = 0;
    document.getElementById('spotlight').style.display = 'block';
    document.getElementById('tooltip-card').style.display = 'block';
    showTutorialStep();
    if (!resizeHandlerAttached) {
        window.addEventListener('resize', () => { if (currentStep >= 0) positionSpotlight(); });
        resizeHandlerAttached = true;
    }
}

function getStepTarget(step) {
    // rep-toggle-sample points at the first alert's toggle button specifically
    if (step.targetElementId === 'rep-toggle-sample') {
        return document.querySelector('#alert-1 .rep-toggle');
    }
    return document.getElementById(step.targetElementId);
}

function showTutorialStep() {
    const step = tutorialSteps[currentStep];
    const target = getStepTarget(step);
    if (!target) { nextTutorialStep(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlightFor(target, step), 300);
    } else {
        positionSpotlightFor(target, step);
    }
}

function positionSpotlight() {
    if (currentStep < 0) return;
    const step = tutorialSteps[currentStep];
    const target = getStepTarget(step);
    if (target) positionSpotlightFor(target, step);
}

function positionSpotlightFor(target, step) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    const spotlight = document.getElementById('spotlight');
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    const tooltip = document.getElementById('tooltip-card');
    document.getElementById('tooltip-text').textContent = step.tooltipText;
    document.getElementById('tooltip-step-count').textContent = `Step ${currentStep + 1} of ${tutorialSteps.length}`;

    // Decide placement: prefer bottom, fall back to top, then right, then left
    tooltip.style.display = 'block';
    const tRect = tooltip.getBoundingClientRect();
    let top = rect.bottom + 16;
    let left = rect.left;

    if (top + tRect.height > window.innerHeight) {
        top = rect.top - tRect.height - 16;
    }
    if (top < 0) {
        top = Math.max(16, rect.top);
        left = rect.right + 16;
        if (left + tRect.width > window.innerWidth) {
            left = rect.left - tRect.width - 16;
        }
    }
    if (left + tRect.width > window.innerWidth) {
        left = window.innerWidth - tRect.width - 16;
    }
    if (left < 0) left = 16;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    showTutorialStep();
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tooltip-card').style.display = 'none';
    currentStep = -1;
    document.getElementById('tutorial-complete-modal').classList.add('open');
}

function closeTutorialModal() {
    document.getElementById('tutorial-complete-modal').classList.remove('open');
}

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
