<?php
// network-scanning-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Terminal Recon | CYBRIXEN</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
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
    line-height: 1.6;
}

.wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 20px 60px 20px;
    position: relative;
}

/* HEADER */
.header {
    text-align: center;
    margin-bottom: 30px;
    position: relative;
}
.header h1 {
    font-size: 2rem;
    margin: 0 0 8px 0;
    color: var(--accent-primary);
}
.header p {
    color: var(--text-secondary);
    margin: 0;
    font-size: 1rem;
}

.view-tutorial-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 500;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--glow-accent);
}
.view-tutorial-btn:hover {
    background: rgba(106,227,255,0.08);
}

/* DESCRIPTION */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 26px;
    margin-bottom: 26px;
}
.mission-briefing h2 {
    margin-top: 0;
    font-size: 1.15rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

/* MAIN ENVIRONMENT */
.terminal-shell {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 26px;
}

.tab-bar {
    display: flex;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    flex-wrap: wrap;
}
.tab-btn {
    flex: 1;
    min-width: 150px;
    padding: 14px 16px;
    background: transparent;
    border: none;
    color: var(--text-muted);
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: color 0.2s ease, border-color 0.2s ease;
}
.tab-btn.active {
    color: var(--accent-primary);
    border-bottom: 3px solid var(--accent-primary);
}
.tab-btn .visited-dot {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--success);
    margin-left: 6px;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.tab-btn.visited .visited-dot {
    opacity: 1;
}

.tab-panel {
    display: none;
    padding: 20px;
}
.tab-panel.active {
    display: block;
}

/* Command history list */
.cmd-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.cmd-item {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 16px;
    cursor: pointer;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-primary);
    transition: border-color 0.2s ease, background 0.2s ease;
}
.cmd-item:hover {
    border-color: var(--accent-primary);
}
.cmd-item.selected {
    border-color: var(--accent-secondary);
    background: rgba(139,123,255,0.08);
}
.cmd-item .cmd-num {
    color: var(--text-muted);
    margin-right: 10px;
}
.cmd-item .cmd-purpose {
    display: block;
    margin-top: 4px;
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    color: var(--text-muted);
}
.cmd-item.opened::after {
    content: 'read';
    float: right;
    color: var(--success);
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Output panel */
.output-box {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
    white-space: pre-wrap;
    min-height: 140px;
    margin-top: 16px;
}
.output-box .placeholder {
    color: var(--text-muted);
    font-style: italic;
    font-family: 'Inter', sans-serif;
}
.output-box .highlight {
    color: var(--accent-primary);
}
.output-box .highlight-warning {
    color: var(--warning);
}

/* Notes panel */
.notes-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 18px 20px;
    font-size: 0.9rem;
    color: var(--text-secondary);
}
.notes-card .note-line {
    margin: 10px 0;
    padding-left: 14px;
    border-left: 2px solid var(--accent-secondary);
}
.notes-card .note-meta {
    color: var(--text-muted);
    font-size: 0.8rem;
}

/* STATUS AREA */
.status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 26px;
    font-size: 0.9rem;
    color: var(--text-secondary);
}
.status-area .progress-bar-track {
    background: var(--bg-primary);
    border-radius: 6px;
    height: 8px;
    margin-top: 10px;
    overflow: hidden;
}
.status-area .progress-bar-fill {
    background: var(--accent-primary);
    height: 100%;
    width: 0%;
    transition: width 0.3s ease;
}

/* FLAG AREA */
.flag-area {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
}
.flag-area.locked .flag-value {
    display: none;
}
.flag-area.unlocked {
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.flag-locked-msg {
    color: var(--text-muted);
    font-size: 0.9rem;
}
.flag-area.unlocked .flag-locked-msg {
    display: none;
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    border: 1px solid var(--success);
    margin-top: 10px;
}

/* SPOTLIGHT TUTORIAL */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    z-index: 900;
    pointer-events: none;
    transition: all 0.25s ease;
}
.tutorial-tooltip {
    position: fixed;
    z-index: 901;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    box-shadow: var(--glow-accent);
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
.tutorial-tooltip button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 7px 14px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.tutorial-tooltip .skip-btn {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default);
}

/* MODAL */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 950;
}
.modal-overlay.visible {
    display: flex;
}
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px 36px;
    text-align: center;
    max-width: 380px;
    box-shadow: var(--glow-accent);
}
.modal-card h3 {
    color: var(--accent-primary);
    margin-top: 0;
}
.modal-card button {
    margin-top: 16px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

@media (max-width: 600px) {
    .tab-bar { flex-direction: column; }
    .tab-btn { min-width: unset; }
}
</style>
</head>
<body>

<button class="view-tutorial-btn" id="view-tutorial-btn">View Tutorial</button>

<div class="wrapper">

    <div class="header">
        <h1>Terminal Recon</h1>
        <p>Meridian Logistics Q3 Assessment &mdash; reconstruct the scanning engagement from raw session history</p>
    </div>

    <div class="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>This environment holds a pentester's terminal session history from a scanning engagement against a small internal range. Nothing has been summarized for you.</p>
        <p>Work through the command history in order, open the saved output for every command, and read the analyst's notes. Once every command has been reviewed and the notes have been read, the flag will unlock.</p>
    </div>

    <div class="status-area" id="status-area">
        <span id="status-text">Progress: 0 of 10 items reviewed</span>
        <div class="progress-bar-track">
            <div class="progress-bar-fill" id="progress-bar-fill"></div>
        </div>
    </div>

    <div class="terminal-shell" id="terminal-shell">
        <div class="tab-bar" id="tab-bar">
            <button class="tab-btn active" id="tab-command-history" data-tab="history">Command History</button>
            <button class="tab-btn" id="tab-scan-output" data-tab="output">Scan Output</button>
            <button class="tab-btn" id="tab-notes" data-tab="notes">Analyst Notes<span class="visited-dot"></span></button>
        </div>

        <div class="tab-panel active" id="panel-history">
            <div class="cmd-list" id="cmd-list"></div>
        </div>

        <div class="tab-panel" id="panel-output">
            <div class="cmd-list" id="cmd-list-output"></div>
            <div class="output-box" id="output-box"><span class="placeholder">Select a command from the Command History tab to view its output here.</span></div>
        </div>

        <div class="tab-panel" id="panel-notes">
            <div class="notes-card">
                <p class="note-meta">Engagement: Meridian Logistics Q3 Assessment | Start time: 09:14</p>
                <div class="note-line">Target range is 10.50.60.0/24. Client asked us to focus on anything internet facing on the internal segment.</div>
                <div class="note-line">Host .12 is the one to flag hard in the report. Running vsftpd 2.3.4, which has a well known backdoor CVE from 2011. This is the critical finding.</div>
                <div class="note-line">Host .44 looks like a domain controller candidate based on OS fingerprint and open SMB and RDP ports. Worth a follow up assessment.</div>
                <div class="note-line">Recon phase is considered complete once every command's output has been reviewed. Nothing here should be skipped, some of the smaller findings matter just as much as the big one.</div>
            </div>
        </div>
    </div>

    <div class="flag-area locked" id="flag-area">
        <p class="flag-locked-msg" id="flag-locked-msg">Review every command's output and read the analyst notes to unlock the flag.</p>
        <div class="flag-value" id="flag-value">CBX{scan_reconstructed}</div>
    </div>

</div>

<div class="modal-overlay" id="completion-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const commands = [
    {
        id: 1,
        cmd: 'nmap -sn 10.50.60.0/24',
        purpose: 'Host discovery across the target range',
        output: 'Starting Nmap host discovery scan\nNmap scan report: 4 hosts up\n  10.50.60.5\n  10.50.60.12\n  10.50.60.18\n  10.50.60.44\nHost discovery complete in 3.2 seconds'
    },
    {
        id: 2,
        cmd: 'nmap -sS -p- 10.50.60.5',
        purpose: 'Full TCP port scan, host .5',
        output: 'Starting Nmap SYN scan on 10.50.60.5\nPORT     STATE SERVICE\n22/tcp   open  unknown\n80/tcp   open  unknown\n443/tcp  open  unknown\nScan complete, 3 open ports found'
    },
    {
        id: 3,
        cmd: 'nmap -sV -p 22,80,443 10.50.60.5',
        purpose: 'Version detection, host .5',
        output: 'PORT     STATE SERVICE  VERSION\n22/tcp   open  ssh      OpenSSH 8.2p1\n80/tcp   open  http     Apache httpd 2.4.41\n443/tcp  open  https    nginx 1.18.0\nService detection complete'
    },
    {
        id: 4,
        cmd: 'nmap -sS -p- 10.50.60.12',
        purpose: 'Full TCP port scan, host .12',
        output: 'Starting Nmap SYN scan on 10.50.60.12\nPORT     STATE SERVICE\n21/tcp   open  unknown\n3389/tcp open  unknown\nScan complete, 2 open ports found'
    },
    {
        id: 5,
        cmd: 'nmap -sV -p 21,3389 10.50.60.12',
        purpose: 'Version detection, host .12',
        output: 'PORT     STATE SERVICE       VERSION\n21/tcp   open  ftp           vsftpd 2.3.4\n3389/tcp open  ms-wbt-server Microsoft Terminal Services\nService detection complete'
    },
    {
        id: 6,
        cmd: 'nmap -sU -p 53,161 10.50.60.18',
        purpose: 'UDP scan, host .18',
        output: 'PORT     STATE         SERVICE  VERSION\n53/udp   open          domain   ISC BIND 9.16.1\n161/udp  open|filtered snmp\nUDP scan complete'
    },
    {
        id: 7,
        cmd: 'nmap -O 10.50.60.44',
        purpose: 'OS detection, host .44',
        output: 'Running: Microsoft Windows Server 2016\nOS details: Microsoft Windows Server 2016\nOS detection performed, please report any incorrect results'
    },
    {
        id: 8,
        cmd: 'nmap -sV -p 445,3389 10.50.60.44',
        purpose: 'Version detection, host .44',
        output: 'PORT     STATE SERVICE       VERSION\n445/tcp  open  microsoft-ds\n3389/tcp open  ms-wbt-server Microsoft Terminal Services\nService detection complete'
    },
    {
        id: 9,
        cmd: 'nmap --script vuln -p 21 10.50.60.12',
        purpose: 'Vulnerability script, host .12',
        output: 'PORT   STATE SERVICE\n21/tcp open  ftp\n| ftp-vsftpd-backdoor:\n|   VULNERABLE:\n|   vsftpd 2.3.4 backdoor\n|     State: VULNERABLE\n|     IDs: CVE-2011-2523\nScript scan complete'
    }
];

const reviewedItems = new Set();
const totalItemsToReview = commands.length + 1; // + notes tab
let notesVisited = false;

function renderCommandList(containerId, clickable) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    commands.forEach(c => {
        const item = document.createElement('div');
        item.className = 'cmd-item' + (reviewedItems.has(c.id) ? ' opened' : '');
        item.id = 'cmd-item-' + containerId + '-' + c.id;
        item.innerHTML = '<span class="cmd-num">#' + c.id + '</span>' + c.cmd + '<span class="cmd-purpose">' + c.purpose + '</span>';
        if (clickable) {
            item.style.cursor = 'pointer';
            item.addEventListener('click', () => selectCommand(c.id));
        }
        container.appendChild(item);
    });
}

function selectCommand(id) {
    const cmd = commands.find(c => c.id === id);
    if (!cmd) return;
    reviewedItems.add(id);
    document.getElementById('output-box').innerHTML = '<span class="highlight">$ ' + cmd.cmd + '</span>\n\n' + cmd.output;
    renderCommandList('cmd-list-output', true);
    document.querySelectorAll('#panel-output .cmd-item').forEach(el => el.classList.remove('selected'));
    const selectedEl = document.getElementById('cmd-item-cmd-list-output-' + id);
    if (selectedEl) selectedEl.classList.add('selected');
    updateProgress();
}

function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + (tabName === 'history' ? 'command-history' : tabName === 'output' ? 'scan-output' : 'notes')).classList.add('active');
    document.getElementById('panel-' + tabName).classList.add('active');
    if (tabName === 'notes') {
        notesVisited = true;
        document.getElementById('tab-notes').classList.add('visited');
        updateProgress();
    }
}

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => switchTab(btn.dataset.tab));
});

function updateProgress() {
    const total = reviewedItems.size + (notesVisited ? 1 : 0);
    const pct = Math.round((total / totalItemsToReview) * 100);
    document.getElementById('status-text').textContent = 'Progress: ' + total + ' of ' + totalItemsToReview + ' items reviewed';
    document.getElementById('progress-bar-fill').style.width = pct + '%';
    if (total >= totalItemsToReview) {
        unlockFlag();
    }
}

function unlockFlag() {
    const flagArea = document.getElementById('flag-area');
    flagArea.classList.remove('locked');
    flagArea.classList.add('unlocked');
}

renderCommandList('cmd-list', true);
document.getElementById('cmd-list').querySelectorAll('.cmd-item').forEach((el, idx) => {
    el.addEventListener('click', () => {
        switchTab('output');
        selectCommand(commands[idx].id);
    });
});
renderCommandList('cmd-list-output', true);

/* ================= SPOTLIGHT TUTORIAL SYSTEM ================= */
const tutorialSteps = [
    { id: 'tab-command-history', text: 'This is the command history. Every scan the analyst ran is listed here in order, like scrollback in a terminal window.' },
    { id: 'tab-scan-output', text: 'Click any command here to see its saved output. This is where the actual findings, open ports, and versions live.' },
    { id: 'tab-notes', text: 'The analyst\'s shorthand notes. They give context on which findings mattered most during the engagement.' },
    { id: 'view-tutorial-btn', text: 'You can replay this tutorial anytime from here.' }
];
let currentStep = 0;
let spotlightEl, tooltipEl;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight-box';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tutorial-tooltip';
    document.body.appendChild(tooltipEl);
}

function positionSpotlight(targetId) {
    const el = document.getElementById(targetId);
    if (!el) return;
    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => applySpotlight(el), 300);
    } else {
        applySpotlight(el);
    }
}

function applySpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    let tooltipTop = rect.bottom + 16;
    let tooltipLeft = rect.left;
    if (tooltipLeft + 300 > window.innerWidth) tooltipLeft = window.innerWidth - 320;
    if (tooltipTop + 140 > window.innerHeight) tooltipTop = rect.top - 150;

    tooltipEl.style.top = tooltipTop + 'px';
    tooltipEl.style.left = Math.max(10, tooltipLeft) + 'px';

    const step = tutorialSteps[currentStep];
    const isLast = currentStep === tutorialSteps.length - 1;
    tooltipEl.innerHTML = '<div>' + step.text + '</div>' +
        '<div class="tt-actions">' +
        '<button class="skip-btn" id="skip-tutorial-btn">Skip Tutorial</button>' +
        '<button id="next-tutorial-btn">' + (isLast ? 'Finish' : 'Next') + '</button>' +
        '</div>';

    document.getElementById('next-tutorial-btn').addEventListener('click', nextTutorialStep);
    document.getElementById('skip-tutorial-btn').addEventListener('click', endTutorial);
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    positionSpotlight(tutorialSteps[currentStep].id);
}

function endTutorial(completed) {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
    if (completed) {
        document.getElementById('completion-modal').classList.add('visible');
    }
}

function startTutorial() {
    currentStep = 0;
    createSpotlightElements();
    switchTab('history');
    positionSpotlight(tutorialSteps[0].id);
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('completion-modal').classList.remove('visible');
});

window.addEventListener('resize', () => {
    if (spotlightEl && tutorialSteps[currentStep]) {
        positionSpotlight(tutorialSteps[currentStep].id);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
