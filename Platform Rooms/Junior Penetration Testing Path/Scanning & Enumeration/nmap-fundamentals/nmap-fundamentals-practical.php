<?php
// ============================================================
// nmap-fundamentals-practical.php — Port Scanner Console
// Standalone static HTML/CSS/JS practical. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Port Scanner Console</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}
.wrap { max-width: 1000px; margin: 0 auto; padding: 24px 20px 80px; position: relative; }

header.top { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; padding-bottom: 18px; border-bottom: 1px solid var(--border-default); margin-bottom: 20px; }
header.top h1 { margin: 0 0 6px 0; font-size: 1.6rem; }
header.top p { margin: 0; color: var(--text-secondary); font-size: 0.95rem; }

#tutorialBtn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
#tutorialBtn:hover { box-shadow: var(--glow-accent); }

.section { background: var(--bg-secondary); border: 1px solid var(--border-default); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
.section h2 { margin-top: 0; font-size: 1.1rem; }
.section h3 { font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 8px; }

.desc-section p { color: var(--text-secondary); font-size: 0.92rem; margin: 6px 0; }

.host-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-top: 10px; }
.host-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px;
    cursor: pointer;
    transition: border-color 0.2s ease;
}
.host-card:hover { border-color: var(--accent-primary); }
.host-card.selected { border-color: var(--accent-primary); box-shadow: var(--glow-accent); }
.host-card .name { font-weight: 600; font-size: 0.95rem; }
.host-card .ip { font-family: "JetBrains Mono", monospace; color: var(--accent-secondary); font-size: 0.85rem; margin: 4px 0; }
.host-card .role { color: var(--text-muted); font-size: 0.8rem; }

.config-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 14px; }
.config-field label { display: block; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; }
.config-field select, .config-field input[type=range] { width: 100%; }
select {
    background: var(--bg-surface);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    padding: 8px 10px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.9rem;
}
input[type=range] { accent-color: var(--accent-primary); }
.timing-label { display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; font-family: "JetBrains Mono", monospace; }

.toggle-row { display: flex; align-items: center; gap: 10px; margin-top: 6px; }
.toggle-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 8px 14px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.85rem;
    cursor: pointer;
}
.toggle-btn.active { color: var(--bg-primary); background: var(--accent-primary); border-color: var(--accent-primary); }

#runScanBtn {
    margin-top: 18px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 28px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
}
#runScanBtn:hover { box-shadow: var(--glow-accent); }
#runScanBtn:disabled { opacity: 0.5; cursor: not-allowed; }

#outputPanel {
    margin-top: 16px;
    background: #060a12;
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    white-space: pre-wrap;
    color: var(--text-secondary);
    min-height: 60px;
}
#outputPanel .line { padding: 2px 4px; border-radius: 4px; cursor: pointer; }
#outputPanel .line:hover { background: rgba(106,227,255,0.08); color: var(--text-primary); }
#outputPanel .placeholder { color: var(--text-muted); font-style: italic; }

.alert-banner {
    margin-top: 12px;
    background: rgba(255,92,92,0.12);
    border: 1px solid var(--error);
    color: var(--error);
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    display: none;
}
.alert-banner.show { display: block; }

.line-explain {
    margin-top: 10px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 0.85rem;
    color: var(--text-secondary);
    display: none;
}
.line-explain.show { display: block; }

.progress-list { list-style: none; padding: 0; margin: 10px 0 0 0; display: grid; gap: 8px; }
.progress-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.progress-list li.done { color: var(--success); border-color: rgba(61,255,154,0.3); }
.check-dot { width: 18px; height: 18px; border-radius: 50%; border: 2px solid var(--text-muted); flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; }
.progress-list li.done .check-dot { border-color: var(--success); background: var(--success); color: var(--bg-primary); }

#flagArea { display: none; text-align: center; }
#flagArea.show { display: block; }
#flagArea .flag-value {
    display: inline-block;
    margin-top: 12px;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 14px 24px;
    border-radius: 8px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    letter-spacing: 0.02em;
}

/* Tutorial */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}
.tooltip-card {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card h4 { margin: 0 0 8px 0; color: var(--accent-primary); font-size: 0.9rem; }
.tooltip-card .tt-actions { display: flex; justify-content: space-between; margin-top: 12px; }
.tooltip-card button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
}
.tooltip-card .skip-btn { background: none; color: var(--text-muted); }

.modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.8);
    display: none; align-items: center; justify-content: center; z-index: 10000;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface); border: 1px solid var(--accent-primary);
    border-radius: 12px; padding: 28px; max-width: 360px; text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-box h3 { margin-top: 0; color: var(--accent-primary); }
.modal-box button {
    margin-top: 14px; background: var(--accent-primary); color: var(--bg-primary);
    border: none; padding: 10px 22px; border-radius: 8px; font-family: inherit;
    font-weight: 600; cursor: pointer;
}
</style>
</head>
<body>
<div class="wrap">

    <!-- Top header -->
    <header class="top">
        <div>
            <h1>Port Scanner Console</h1>
            <p>ACME Corporate Network &middot; Scan simulation environment</p>
        </div>
        <button id="tutorialBtn">View Tutorial</button>
    </header>

    <!-- Description section -->
    <div class="section desc-section">
        <h2>Mission Briefing</h2>
        <p>This console simulates a scanning workstation with reach into three ACME hosts. Select a target, configure your scan type and timing template, then run the scan to see how your choices shape the result.</p>
        <p>Work through the progress tracker below. Once every milestone is checked off, the full scan report unlocks along with your flag.</p>
    </div>

    <!-- Main interactive environment -->
    <div class="section" id="targetSection">
        <h2>1. Select a Target</h2>
        <div class="host-grid" id="targetList">
            <div class="host-card" data-ip="10.10.14.10">
                <div class="name">ACME-DC01</div>
                <div class="ip">10.10.14.10</div>
                <div class="role">Domain Controller</div>
            </div>
            <div class="host-card" data-ip="10.10.14.22">
                <div class="name">ACME-WEB01</div>
                <div class="ip">10.10.14.22</div>
                <div class="role">Web Server</div>
            </div>
            <div class="host-card" data-ip="10.10.14.35">
                <div class="name">ACME-DB01</div>
                <div class="ip">10.10.14.35</div>
                <div class="role">Database Server</div>
            </div>
        </div>
    </div>

    <div class="section" id="configSection">
        <h2>2. Configure the Scan</h2>
        <div class="config-grid">
            <div class="config-field" id="scanTypeField">
                <label for="scanTypeSelect">Scan Type</label>
                <select id="scanTypeSelect">
                    <option value="sS">-sS (SYN Scan)</option>
                    <option value="sT">-sT (TCP Connect Scan)</option>
                    <option value="sU">-sU (UDP Scan)</option>
                </select>
            </div>
            <div class="config-field" id="timingField">
                <label for="timingSlider">Timing Template</label>
                <input type="range" id="timingSlider" min="0" max="5" value="3" step="1">
                <div class="timing-label"><span>T0</span><span>T1</span><span>T2</span><span>T3</span><span>T4</span><span>T5</span></div>
            </div>
            <div class="config-field" id="outputField">
                <label>Output Format</label>
                <div class="toggle-row">
                    <button class="toggle-btn active" data-mode="normal">Console</button>
                    <button class="toggle-btn" data-mode="oN">-oN Saved File</button>
                </div>
            </div>
        </div>
        <button id="runScanBtn" disabled>Run Scan</button>
    </div>

    <div class="section" id="outputSection">
        <h2>3. Scan Result</h2>
        <div class="alert-banner" id="idsAlert">IDS ALERT: Aggressive scan detected from 10.10.14.5</div>
        <div id="outputPanel"><span class="placeholder">Select a target and run a scan to see output here.</span></div>
        <div class="line-explain" id="lineExplain"></div>
    </div>

    <div class="section" id="progressSection">
        <h2>Progress Tracker</h2>
        <ul class="progress-list" id="progressTracker">
            <li data-key="synAll"><span class="check-dot"></span> Run a SYN scan against all three targets</li>
            <li data-key="udpDb"><span class="check-dot"></span> Run a UDP scan against ACME-DB01 to discover the SNMP port</li>
            <li data-key="idsAlert"><span class="check-dot"></span> Trigger an IDS alert using T4 or T5 timing</li>
            <li data-key="viewON"><span class="check-dot"></span> View the -oN saved output format</li>
        </ul>
    </div>

    <!-- Flag reveal area -->
    <div class="section" id="flagArea">
        <h2>Scan Report Complete</h2>
        <p style="color: var(--text-secondary);">Every milestone has been completed. Here is your flag.</p>
        <div class="flag-value">CBX{network_mapped}</div>
    </div>

</div>

<!-- Tutorial modal -->
<div class="modal-overlay" id="completeModal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
// ---------------- Data ----------------
const HOSTS = {
    "10.10.14.10": {
        name: "ACME-DC01", role: "Domain Controller",
        tcp: [
            { port: 53,  state: "open", service: "domain",       version: "" },
            { port: 88,  state: "open", service: "kerberos-sec", version: "" },
            { port: 389, state: "open", service: "ldap",         version: "" },
            { port: 445, state: "open", service: "microsoft-ds", version: "" }
        ],
        udp: []
    },
    "10.10.14.22": {
        name: "ACME-WEB01", role: "Web Server",
        tcp: [
            { port: 22,   state: "open",     service: "ssh",   version: "OpenSSH 8.2p1" },
            { port: 80,   state: "open",     service: "http",  version: "Apache 2.4.41" },
            { port: 443,  state: "open",     service: "https", version: "" },
            { port: 3306, state: "filtered", service: "mysql", version: "" }
        ],
        udp: []
    },
    "10.10.14.35": {
        name: "ACME-DB01", role: "Database Server",
        tcp: [
            { port: 22,   state: "open", service: "ssh",        version: "OpenSSH 8.2p1" },
            { port: 5432, state: "open", service: "postgresql", version: "" }
        ],
        udp: [
            { port: 161, state: "open|filtered", service: "snmp", version: "" }
        ]
    }
};

const LINE_EXPLANATIONS = {
    flags: "This line shows the exact scan type and timing template used to produce this output, the same information you would see in a real Nmap command.",
    timing: "This summary reflects how long the scan took. Faster timing templates finish quickly but are easier for monitoring systems to notice.",
    port: "Each row shows a single port: its number, its state, the service listening on it, and a version string when Nmap could identify one."
};

// ---------------- State ----------------
let selectedIp = null;
let outputMode = "normal";
const progress = { synAll: false, udpDb: false, idsAlert: false, viewON: false };
const synScannedHosts = new Set();

// ---------------- Elements ----------------
const targetList = document.getElementById('targetList');
const runScanBtn = document.getElementById('runScanBtn');
const outputPanel = document.getElementById('outputPanel');
const idsAlert = document.getElementById('idsAlert');
const lineExplain = document.getElementById('lineExplain');
const flagArea = document.getElementById('flagArea');
const scanTypeSelect = document.getElementById('scanTypeSelect');
const timingSlider = document.getElementById('timingSlider');

// ---------------- Target selection ----------------
targetList.querySelectorAll('.host-card').forEach(card => {
    card.addEventListener('click', () => {
        targetList.querySelectorAll('.host-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        selectedIp = card.dataset.ip;
        runScanBtn.disabled = false;
    });
});

// ---------------- Output format toggle ----------------
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        outputMode = btn.dataset.mode;
    });
});

// ---------------- Run scan ----------------
runScanBtn.addEventListener('click', () => {
    if (!selectedIp) return;
    const host = HOSTS[selectedIp];
    const scanType = scanTypeSelect.value;
    const timing = parseInt(timingSlider.value, 10);

    idsAlert.classList.remove('show');
    lineExplain.classList.remove('show');

    let rows = [];
    let scanLabel = "";
    let stealthNote = "";

    if (scanType === "sS") {
        rows = host.tcp;
        scanLabel = "SYN Scan (-sS)";
        stealthNote = "half-open scan, stealthy";
        synScannedHosts.add(selectedIp);
        if (synScannedHosts.size === 3) {
            progress.synAll = true;
        }
    } else if (scanType === "sT") {
        rows = host.tcp;
        scanLabel = "TCP Connect Scan (-sT)";
        stealthNote = "full TCP handshake, likely logged";
    } else {
        rows = host.udp;
        scanLabel = "UDP Scan (-sU)";
        stealthNote = "connectionless, slower to complete";
        if (selectedIp === "10.10.14.35" && rows.length > 0) {
            progress.udpDb = true;
        }
    }

    if (timing >= 4) {
        idsAlert.classList.add('show');
        progress.idsAlert = true;
    }

    if (outputMode === "oN") {
        progress.viewON = true;
    }

    renderOutput(host, scanLabel, stealthNote, timing, rows, outputMode);
    updateProgressUI();
});

function renderOutput(host, scanLabel, stealthNote, timing, rows, mode) {
    outputPanel.innerHTML = "";

    const flagsLine = document.createElement('div');
    flagsLine.className = 'line';
    flagsLine.dataset.explain = 'flags';
    flagsLine.textContent = `# Scan: ${scanLabel} against ${host.name} (${selectedIp})`;
    outputPanel.appendChild(flagsLine);

    const timingLine = document.createElement('div');
    timingLine.className = 'line';
    timingLine.dataset.explain = 'timing';
    timingLine.textContent = `# Timing: T${timing}  |  ${stealthNote}`;
    outputPanel.appendChild(timingLine);

    outputPanel.appendChild(document.createElement('br'));

    if (mode === "oN") {
        const header = document.createElement('div');
        header.textContent = `# Nmap scan report saved to scan.txt (-oN)`;
        header.style.color = "var(--accent-secondary)";
        outputPanel.appendChild(header);
    }

    if (rows.length === 0) {
        const empty = document.createElement('div');
        empty.textContent = "No ports found for this scan type on this host.";
        empty.className = "placeholder";
        outputPanel.appendChild(empty);
    } else {
        rows.forEach(r => {
            const line = document.createElement('div');
            line.className = 'line';
            line.dataset.explain = 'port';
            const proto = (r.service === 'snmp') ? 'udp' : 'tcp';
            line.textContent = `${r.port}/${proto}  ${r.state.padEnd(14)}  ${r.service}${r.version ? '  ' + r.version : ''}`;
            outputPanel.appendChild(line);
        });
    }

    outputPanel.querySelectorAll('.line').forEach(line => {
        line.addEventListener('click', () => {
            const key = line.dataset.explain;
            lineExplain.textContent = LINE_EXPLANATIONS[key];
            lineExplain.classList.add('show');
        });
    });
}

function updateProgressUI() {
    document.querySelectorAll('#progressTracker li').forEach(li => {
        const key = li.dataset.key;
        if (progress[key]) {
            li.classList.add('done');
            li.querySelector('.check-dot').textContent = '✓';
        }
    });
    if (Object.values(progress).every(v => v)) {
        flagArea.classList.add('show');
        flagArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// ---------------- Tutorial system ----------------
const tutorialSteps = [
    { id: 'targetSection', text: 'This is your target list, the hosts reachable on this network. Think of it like a phonebook of everything you can scan.' },
    { id: 'scanTypeField', text: 'Choose how Nmap probes each port. SYN is fast and stealthy, Connect completes the full handshake, UDP checks connectionless services.' },
    { id: 'timingField', text: 'Timing controls how aggressively packets are sent. Slower is stealthier, faster risks detection.' },
    { id: 'outputField', text: 'Switch between a live console view and a saved file style output, just like using -oN on a real scan.' },
    { id: 'runScanBtn', text: 'Executes the scan with your chosen options against the selected target.' },
    { id: 'outputSection', text: 'This is your scan result. Click any line for an explanation of what it means.' },
    { id: 'progressSection', text: 'Tracks the milestones you need to complete before the full report unlocks.' },
    { id: 'flagArea', text: 'Appears once every milestone is complete. This is where your flag will be revealed.' }
];
let tutorialIndex = 0;
let spotlightEl = null;
let tooltipEl = null;

function startTutorial() {
    tutorialIndex = 0;
    showTutorialStep();
}

function showTutorialStep() {
    removeTutorialElements();
    if (tutorialIndex >= tutorialSteps.length) {
        document.getElementById('completeModal').classList.add('show');
        return;
    }
    const step = tutorialSteps[tutorialIndex];
    const target = document.getElementById(step.id);
    if (!target) { tutorialIndex++; showTutorialStep(); return; }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => positionSpotlight(target, step.text), 300);
}

function positionSpotlight(target, text) {
    const rect = target.getBoundingClientRect();
    const pad = 8;

    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    tooltipEl.innerHTML = `
        <h4>Step ${tutorialIndex + 1} of ${tutorialSteps.length}</h4>
        <p>${text}</p>
        <div class="tt-actions">
            <button class="skip-btn" id="skipTutBtn">Skip Tutorial</button>
            <button id="nextTutBtn">Next</button>
        </div>
    `;
    document.body.appendChild(tooltipEl);

    let top = rect.bottom + 16;
    let left = rect.left;
    const ttRect = { width: 280, height: 140 };
    if (top + ttRect.height > window.innerHeight) top = rect.top - ttRect.height - 16;
    if (left + ttRect.width > window.innerWidth) left = window.innerWidth - ttRect.width - 20;
    if (left < 10) left = 10;
    if (top < 10) top = 10;
    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';

    document.getElementById('nextTutBtn').addEventListener('click', () => {
        tutorialIndex++;
        showTutorialStep();
    });
    document.getElementById('skipTutBtn').addEventListener('click', endTutorial);
}

function removeTutorialElements() {
    if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
    if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
}

function endTutorial() {
    removeTutorialElements();
    document.getElementById('completeModal').classList.remove('show');
}

document.getElementById('tutorialBtn').addEventListener('click', startTutorial);
document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (spotlightEl && tutorialIndex < tutorialSteps.length) {
        const step = tutorialSteps[tutorialIndex];
        const target = document.getElementById(step.id);
        if (target) positionSpotlight(target, step.text);
    }
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>
</body>
</html>
