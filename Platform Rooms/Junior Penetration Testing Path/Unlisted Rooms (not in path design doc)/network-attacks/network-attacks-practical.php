<?php
// ============================================================
// network-attacks-practical.php
// Standalone practical: The Intrusion Trace
// Static HTML/CSS/JS only. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The Intrusion Trace | CYBRIXEN Lab</title>
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
    line-height: 1.5;
}

.wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 20px 60px 20px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 25px;
    gap: 20px;
}
.header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}
.header p {
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
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* BRIEFING */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 25px;
}
.briefing h2 {
    margin: 0 0 10px 0;
    font-size: 1.05rem;
    color: var(--text-primary);
}
.briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.briefing p:last-child { margin-bottom: 0; }

/* TABS */
.tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.tab-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 12px 20px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.tab-btn.active {
    color: var(--accent-primary);
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.tab-btn .check {
    margin-left: 8px;
    color: var(--success);
    font-weight: 700;
}

/* PANELS */
.panel {
    display: none;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    margin-bottom: 25px;
}
.panel.active { display: block; }
.panel h3 {
    margin: 0 0 6px 0;
    font-size: 1rem;
    color: var(--accent-primary);
}
.panel .subtext {
    color: var(--text-muted);
    font-size: 0.82rem;
    margin: 0 0 16px 0;
}
.log-box {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px 18px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    color: var(--text-secondary);
    overflow-x: auto;
    white-space: pre;
    line-height: 1.7;
}
.log-box .flagline { color: var(--warning); }
.log-box .hitline { color: var(--error); font-weight: 700; }

table.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
    margin-top: 4px;
}
table.data-table th, table.data-table td {
    border: 1px solid var(--border-default);
    padding: 10px 12px;
    text-align: left;
}
table.data-table th {
    background: var(--bg-surface);
    color: var(--accent-secondary);
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
table.data-table td { color: var(--text-secondary); font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; }
tr.anomaly td { color: var(--warning); }

/* SUMMARY */
.summary-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
}
.summary-box h3 {
    margin: 0 0 14px 0;
    font-size: 1rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 10px;
}
.checklist {
    list-style: none;
    padding: 0;
    margin: 0 0 18px 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.checklist li {
    font-size: 0.85rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 10px;
}
.checklist li.done { color: var(--success); }
.dot {
    width: 9px; height: 9px; border-radius: 50%;
    background: var(--text-muted);
    display: inline-block;
}
.checklist li.done .dot { background: var(--success); }

.locked-state {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-muted);
    font-size: 0.9rem;
    padding: 14px;
    border: 1px dashed var(--border-default);
    border-radius: 8px;
}

.flag-reveal {
    display: none;
    margin-top: 6px;
    padding: 18px;
    background: rgba(61,255,154,0.06);
    border: 1px solid var(--success);
    border-radius: 8px;
}
.flag-reveal.show { display: block; }
.flag-reveal .case-closed {
    color: var(--success);
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 10px;
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 12px 16px;
    color: var(--accent-primary);
    font-size: 1rem;
    letter-spacing: 0.02em;
}

/* SPOTLIGHT TUTORIAL */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.25s ease;
    pointer-events: none;
    z-index: 998;
}
.tooltip-card {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 999;
    box-shadow: var(--glow-accent);
}
.tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
.tooltip-card button {
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tooltip-card button.primary {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.show { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 { margin: 0 0 10px 0; color: var(--accent-primary); }
.modal-card p { color: var(--text-secondary); font-size: 0.9rem; margin: 0 0 20px 0; }
.modal-card button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}

@media (max-width: 640px) {
    .header { flex-direction: column; }
    .tabs { flex-direction: column; }
}
</style>
</head>
<body>

<div class="wrapper">
    <div class="header">
        <div>
            <h1>The Intrusion Trace</h1>
            <p>DB SERVER 01 was compromised overnight. Trace the attacker through three independent data sources and reconstruct the full attack path.</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </div>

    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This environment simulates the evidence pulled from a compromised internal server. You are acting as the incident responder assigned to the case.</p>
        <p>Open each panel below in order. Read carefully. Every question in the room is answered directly by something in this data. Once you have opened all three panels, the Investigation Summary will unlock and reveal your case flag.</p>
    </div>

    <div class="tabs">
        <button class="tab-btn active" id="tab-traffic" onclick="openPanel('traffic')">Network Traffic Log <span class="check" id="check-traffic"></span></button>
        <button class="tab-btn" id="tab-auth" onclick="openPanel('auth')">Authentication Log <span class="check" id="check-auth"></span></button>
        <button class="tab-btn" id="tab-firewall" onclick="openPanel('firewall')">Firewall Rule Table <span class="check" id="check-firewall"></span></button>
    </div>

    <!-- PANEL: TRAFFIC -->
    <div class="panel active" id="panel-traffic">
        <h3>Network Traffic Log</h3>
        <p class="subtext">Target host: DB-SERVER-01 (10.0.0.15). Sensor flagged 8 distinct destination ports probed from a single source within 4 seconds, consistent with a SYN scan.</p>
        <div class="log-box">02:14:01  203.0.113.77 -> 10.0.0.15:21    SYN   closed
02:14:01  203.0.113.77 -> 10.0.0.15:22    SYN   closed
02:14:02  203.0.113.77 -> 10.0.0.15:23    SYN   closed
02:14:02  203.0.113.77 -> 10.0.0.15:25    SYN   closed
02:14:03  203.0.113.77 -> 10.0.0.15:80    SYN   closed
02:14:03  203.0.113.77 -> 10.0.0.15:443   SYN   closed
02:14:04  203.0.113.77 -> 10.0.0.15:3306  SYN   closed
<span class="hitline">02:14:04  203.0.113.77 -> 10.0.0.15:3389  SYN   open</span>
<span class="flagline">02:17:52  203.0.113.77 -> 10.0.0.15:3389  SYN-ACK  session established</span></div>
    </div>

    <!-- PANEL: AUTH -->
    <div class="panel" id="panel-auth">
        <h3>Authentication Log</h3>
        <p class="subtext">All login attempts recorded against DB-SERVER-01 during the incident window and the following morning.</p>
        <table class="data-table">
            <thead><tr><th>Time</th><th>Service</th><th>Username</th><th>Target</th><th>Result</th><th>Source</th></tr></thead>
            <tbody>
                <tr><td>02:15:10</td><td>RDP</td><td>svc_backup</td><td>10.0.0.15</td><td>FAILED</td><td>203.0.113.77</td></tr>
                <tr><td>02:15:41</td><td>RDP</td><td>svc_backup</td><td>10.0.0.15</td><td>FAILED</td><td>203.0.113.77</td></tr>
                <tr><td>02:16:22</td><td>RDP</td><td>svc_backup</td><td>10.0.0.15</td><td>FAILED</td><td>203.0.113.77</td></tr>
                <tr class="anomaly"><td>02:17:52</td><td>RDP</td><td>svc_backup</td><td>10.0.0.15</td><td>SUCCESS</td><td>203.0.113.77</td></tr>
                <tr><td>02:20:03</td><td>RDP</td><td>j.martinez</td><td>10.0.0.15</td><td>SUCCESS</td><td>10.0.0.42</td></tr>
                <tr><td>09:01:15</td><td>RDP</td><td>a.chen</td><td>10.0.0.15</td><td>SUCCESS</td><td>10.0.0.18</td></tr>
            </tbody>
        </table>
    </div>

    <!-- PANEL: FIREWALL -->
    <div class="panel" id="panel-firewall">
        <h3>Firewall Rule Table</h3>
        <p class="subtext">Active perimeter rules on DB-SERVER-01 at the time of the incident.</p>
        <table class="data-table">
            <thead><tr><th>Rule ID</th><th>Direction</th><th>Port</th><th>Source</th><th>Action</th><th>Note</th></tr></thead>
            <tbody>
                <tr><td>FW-101</td><td>Inbound</td><td>443</td><td>ANY</td><td>ALLOW</td><td>Public web service</td></tr>
                <tr><td>FW-102</td><td>Inbound</td><td>80</td><td>ANY</td><td>ALLOW</td><td>Public web service</td></tr>
                <tr><td>FW-110</td><td>Inbound</td><td>22</td><td>10.0.0.0/24</td><td>ALLOW</td><td>Internal SSH only</td></tr>
                <tr class="anomaly"><td>FW-114</td><td>Inbound</td><td>3389</td><td>ANY</td><td>ALLOW</td><td>TEMP, remove after maintenance window</td></tr>
                <tr><td>FW-120</td><td>Inbound</td><td>3306</td><td>10.0.0.0/24</td><td>ALLOW</td><td>Internal DB access only</td></tr>
            </tbody>
        </table>
    </div>

    <!-- INVESTIGATION SUMMARY -->
    <div class="summary-box" id="investigation-summary">
        <h3>Investigation Summary</h3>
        <ul class="checklist">
            <li id="cl-traffic"><span class="dot"></span> Traffic Log Reviewed</li>
            <li id="cl-auth"><span class="dot"></span> Auth Log Reviewed</li>
            <li id="cl-firewall"><span class="dot"></span> Firewall Table Reviewed</li>
        </ul>
        <div class="locked-state" id="lockedState">
            <span>&#128274;</span> Review all three panels above to unlock the case summary.
        </div>
        <div class="flag-reveal" id="flagReveal">
            <p class="case-closed">Case closed. Attacker traced from initial scan to unauthorized access via FW-114.</p>
            <div class="flag-value">CBX{intrusion_traced}</div>
        </div>
    </div>
</div>

<!-- TUTORIAL ELEMENTS -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <div id="tooltipText"></div>
    <div class="tt-actions">
        <button id="skipBtn">Skip Tutorial</button>
        <button class="primary" id="nextBtn">Next</button>
    </div>
</div>

<div class="modal-overlay" id="completeModal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
const visited = { traffic: false, auth: false, firewall: false };

function openPanel(name) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');

    if (!visited[name]) {
        visited[name] = true;
        document.getElementById('check-' + name).textContent = '✓';
        document.getElementById('cl-' + name).classList.add('done');
    }
    checkUnlock();
}

function checkUnlock() {
    if (visited.traffic && visited.auth && visited.firewall) {
        document.getElementById('lockedState').style.display = 'none';
        document.getElementById('flagReveal').classList.add('show');
    }
}

// ================= TUTORIAL SYSTEM =================
const steps = [
    { targetId: 'tab-traffic', text: 'This is the Network Traffic Log. It shows every connection attempt the sensor captured overnight. Start here, the same way a real analyst opens the packet capture first.' },
    { targetId: 'tab-auth', text: 'The Authentication Log records every login attempt across the network. Cross reference any suspicious IP you found in the traffic log against this panel.' },
    { targetId: 'tab-firewall', text: 'The Firewall Rule Table lists every active perimeter rule. One rule here is misconfigured and let the attacker straight through.' },
    { targetId: 'investigation-summary', text: 'Once you have reviewed all three panels, your Investigation Summary unlocks here and reveals the case flag.' }
];
let currentStep = 0;

const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltipCard');
const tooltipText = document.getElementById('tooltipText');

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';
    spotlight.style.display = 'block';

    let tooltipTop = rect.bottom + 14;
    let tooltipLeft = rect.left;
    if (tooltipLeft + 300 > window.innerWidth) {
        tooltipLeft = window.innerWidth - 320;
    }
    if (tooltipTop + 140 > window.innerHeight) {
        tooltipTop = rect.top - 150;
    }
    tooltipCard.style.top = tooltipTop + 'px';
    tooltipCard.style.left = tooltipLeft + 'px';
    tooltipCard.style.display = 'block';
}

function showStep(index) {
    if (index >= steps.length) {
        endTutorial(true);
        return;
    }
    const step = steps[index];
    const el = document.getElementById(step.targetId);
    if (!el) { showStep(index + 1); return; }

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        positionSpotlight(el);
        tooltipText.textContent = step.text;
    }, 300);
}

function startTutorial() {
    currentStep = 0;
    showStep(currentStep);
}

function endTutorial(completed) {
    spotlight.style.display = 'none';
    tooltipCard.style.display = 'none';
    if (completed) {
        document.getElementById('completeModal').classList.add('show');
    }
}

document.getElementById('nextBtn').addEventListener('click', () => {
    currentStep++;
    showStep(currentStep);
});
document.getElementById('skipBtn').addEventListener('click', () => endTutorial(false));
document.getElementById('tutorialBtn').addEventListener('click', startTutorial);
document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (tooltipCard.style.display === 'block') {
        const step = steps[currentStep];
        const el = document.getElementById(step.targetId);
        if (el) positionSpotlight(el);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 500);
});
</script>

</body>
</html>
