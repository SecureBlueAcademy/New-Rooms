<?php
// Filename: whois-dns-domain-enumeration-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Domain Recon Console</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.wrapper {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 70px 20px;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
}
.header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: "Inter", sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    background: var(--accent-primary);
    color: var(--bg-primary);
}

/* Description */
.description {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.description strong { color: var(--text-primary); }

/* Main environment */
.environment {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
.environment h2 {
    font-size: 1.05rem;
    margin: 0 0 14px 0;
    color: var(--text-primary);
}

#command-panel {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 18px;
    padding: 14px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
}
.cmd-btn {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 9px 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.cmd-btn:hover:not(:disabled) {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.cmd-btn:disabled {
    color: var(--text-muted);
    border-color: var(--border-default);
    cursor: not-allowed;
    opacity: 0.5;
}
.cmd-btn.done {
    border-color: var(--success);
    color: var(--success);
}
.cmd-btn.axfr {
    border-color: var(--error);
    color: var(--error);
}

#terminal-output {
    background: #05070d;
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    color: var(--text-secondary);
    height: 320px;
    overflow-y: auto;
    white-space: pre-wrap;
}
#terminal-output .prompt { color: var(--accent-secondary); }
#terminal-output .cmd-line { color: var(--accent-primary); font-weight: 600; }
#terminal-output .leak { color: var(--error); }
#terminal-output .block { margin-bottom: 16px; }

/* Feedback / status */
#status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 20px;
    margin-bottom: 20px;
    font-size: 0.88rem;
    color: var(--text-secondary);
    min-height: 20px;
}
#status-area.warn { border-color: var(--warning); color: var(--warning); }
#status-area.ok { border-color: var(--success); color: var(--success); }

/* Flag reveal */
#flag-panel {
    display: none;
    background: linear-gradient(135deg, #0f2027, #12331f, #0f2027);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
}
#flag-panel.revealed { display: block; }
#flag-panel h3 {
    margin: 0 0 8px 0;
    color: var(--success);
    font-size: 1.05rem;
}
#flag-panel p {
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin: 0 0 14px 0;
}
#flag-value {
    display: inline-block;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 20px;
    border-radius: 8px;
    letter-spacing: 0.02em;
}

/* Spotlight tutorial */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}
.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
    font-size: 0.85rem;
}
.tutorial-tooltip p {
    margin: 0 0 14px 0;
    color: var(--text-secondary);
}
.tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tt-btn {
    font-family: "Inter", sans-serif;
    font-size: 0.8rem;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tt-btn.primary {
    background: var(--accent-primary);
    border-color: var(--accent-primary);
    color: var(--bg-primary);
    font-weight: 600;
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    z-index: 10000;
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
.modal-card h3 {
    color: var(--accent-primary);
    margin: 0 0 10px 0;
}
.modal-card p {
    color: var(--text-secondary);
    font-size: 0.88rem;
    margin: 0 0 20px 0;
}
.modal-card button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="wrapper">

    <div class="header">
        <div>
            <h1>Domain Recon Console</h1>
            <p class="subtitle">Simulated WHOIS and DNS reconnaissance against cybrixen-corp.local</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="description">
        This console represents a terminal environment used to run reconnaissance commands against a target domain, <strong>cybrixen-corp.local</strong>. Your goal is to gather WHOIS and DNS data, identify the domain's nameservers, then attempt a zone transfer against each one. One nameserver is misconfigured and will leak the full internal zone, including the flag.
    </div>

    <div class="environment">
        <h2>Command Panel</h2>
        <div id="command-panel">
            <button class="cmd-btn" id="btn-whois" data-cmd="whois">whois cybrixen-corp.local</button>
            <button class="cmd-btn" id="btn-a" data-cmd="a">dig A cybrixen-corp.local</button>
            <button class="cmd-btn" id="btn-mx" data-cmd="mx">dig MX cybrixen-corp.local</button>
            <button class="cmd-btn" id="btn-ns" data-cmd="ns">dig NS cybrixen-corp.local</button>
            <button class="cmd-btn" id="btn-txt" data-cmd="txt">dig TXT cybrixen-corp.local</button>
            <button class="cmd-btn" id="btn-cname" data-cmd="cname">dig CNAME www.cybrixen-corp.local</button>
            <button class="cmd-btn axfr" id="btn-axfr" data-cmd="axfr" disabled>dig AXFR @ns2.cybrixen-corp.local</button>
        </div>

        <h2>Terminal Output</h2>
        <div id="terminal-output"><span class="prompt">recon@console:~$</span> Awaiting commands...</div>
    </div>

    <div id="status-area">Run a command from the panel above to begin.</div>

    <div id="flag-panel">
        <h3>Zone Transfer Succeeded</h3>
        <p>ns2.cybrixen-corp.local accepted an unauthenticated AXFR request and leaked the full internal zone.</p>
        <div id="flag-value">CBX{zone_transferred}</div>
    </div>

</div>

<div class="modal-overlay" id="completion-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Work through the command panel and see what the domain reveals.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const commandData = {
    whois: {
        label: 'whois cybrixen-corp.local',
        output:
`Domain Name: CYBRIXEN-CORP.LOCAL
Registrar: NetRegistry Solutions
Creation Date: 2019-03-14
Registry Expiry Date: 2027-03-14
Registrant Organization: Cybrixen Corp
Name Server: NS1.CYBRIXEN-CORP.LOCAL
Name Server: NS2.CYBRIXEN-CORP.LOCAL`
    },
    a: {
        label: 'dig A cybrixen-corp.local',
        output: `cybrixen-corp.local.    3600    IN    A    192.168.50.10`
    },
    mx: {
        label: 'dig MX cybrixen-corp.local',
        output: `cybrixen-corp.local.    3600    IN    MX   10 mail.cybrixen-corp.local.`
    },
    ns: {
        label: 'dig NS cybrixen-corp.local',
        output:
`cybrixen-corp.local.    3600    IN    NS   ns1.cybrixen-corp.local.
cybrixen-corp.local.    3600    IN    NS   ns2.cybrixen-corp.local.`
    },
    txt: {
        label: 'dig TXT cybrixen-corp.local',
        output: `cybrixen-corp.local.    3600    IN    TXT  "v=spf1 include:_spf.cybrixen-corp.local ~all"`
    },
    cname: {
        label: 'dig CNAME www.cybrixen-corp.local',
        output: `www.cybrixen-corp.local.  3600  IN  CNAME  cybrixen-corp.local.`
    },
    axfr: {
        label: 'dig AXFR cybrixen-corp.local @ns2.cybrixen-corp.local',
        output:
`;; Zone transfer succeeded (ns2.cybrixen-corp.local allows unauthenticated AXFR)
cybrixen-corp.local.        3600  IN  SOA   ns1.cybrixen-corp.local. admin.cybrixen-corp.local.
cybrixen-corp.local.        3600  IN  NS    ns1.cybrixen-corp.local.
cybrixen-corp.local.        3600  IN  NS    ns2.cybrixen-corp.local.
cybrixen-corp.local.        3600  IN  A     192.168.50.10
mail.cybrixen-corp.local.   3600  IN  A     192.168.50.15
internal-admin.cybrixen-corp.local. 3600 IN A 192.168.50.99
vpn.cybrixen-corp.local.    3600  IN  A     192.168.50.44
; flag: CBX{zone_transferred}`,
        leak: true
    }
};

const requiredBeforeAxfr = ['whois', 'a', 'mx', 'ns', 'txt', 'cname'];
const ranCommands = new Set();

const terminal = document.getElementById('terminal-output');
const statusArea = document.getElementById('status-area');
const flagPanel = document.getElementById('flag-panel');
const axfrBtn = document.getElementById('btn-axfr');
const nsBtn = document.getElementById('btn-ns');

function appendToTerminal(cmd) {
    const data = commandData[cmd];
    const block = document.createElement('div');
    block.className = 'block';
    const leakClass = data.leak ? 'leak' : '';
    block.innerHTML = `<div class="cmd-line">recon@console:~$ ${data.label}</div><div class="${leakClass}">${data.output}</div>`;
    terminal.appendChild(block);
    terminal.scrollTop = terminal.scrollHeight;
}

document.querySelectorAll('.cmd-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const cmd = btn.dataset.cmd;
        if (btn.disabled) return;

        if (cmd === 'axfr') {
            const missing = requiredBeforeAxfr.filter(c => !ranCommands.has(c));
            if (missing.length > 0) {
                statusArea.className = 'warn';
                statusArea.textContent = 'Run the remaining standard lookups before attempting a zone transfer: ' + missing.join(', ').toUpperCase() + '.';
                return;
            }
            appendToTerminal('axfr');
            ranCommands.add('axfr');
            btn.classList.add('done');
            statusArea.className = 'ok';
            statusArea.textContent = 'Zone transfer succeeded. Scroll down to view the flag.';
            flagPanel.classList.add('revealed');
            return;
        }

        if (!ranCommands.has(cmd)) {
            ranCommands.add(cmd);
            appendToTerminal(cmd);
            btn.classList.add('done');
        }

        if (cmd === 'ns') {
            axfrBtn.disabled = false;
            statusArea.className = '';
            statusArea.textContent = 'Nameservers identified. You can now attempt a zone transfer against ns2.';
        } else if (!flagPanel.classList.contains('revealed')) {
            const remaining = requiredBeforeAxfr.filter(c => !ranCommands.has(c));
            statusArea.className = '';
            statusArea.textContent = remaining.length > 0
                ? 'Lookup recorded. Remaining: ' + remaining.join(', ').toUpperCase() + '.'
                : 'All standard lookups complete. Attempt the zone transfer above.';
        }
    });
});

/* ================= Spotlight Tutorial System ================= */
const tutorialSteps = [
    { targetElementId: 'command-panel', tooltipText: 'This is your command panel. Each button runs a real reconnaissance command against the target domain, cybrixen-corp.local, just like typing whois or dig at a real terminal.' },
    { targetElementId: 'btn-whois', tooltipText: 'Start here. WHOIS tells you who registered the domain and when, similar to checking a public business registry.' },
    { targetElementId: 'btn-ns', tooltipText: 'Nameserver lookups reveal which servers are authoritative for the domain. This is a critical step before attempting a zone transfer.' },
    { targetElementId: 'terminal-output', tooltipText: 'Every command\\'s output appears here, just like a real terminal session.' },
    { targetElementId: 'btn-axfr', tooltipText: 'Once you know the nameservers, you can attempt a zone transfer against each one. Some servers are misconfigured to allow this from anyone.' },
    { targetElementId: 'flag-panel', tooltipText: 'If the zone transfer succeeds, the full internal zone appears here, including your flag.' }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    if (!spotlightEl) {
        spotlightEl = document.createElement('div');
        spotlightEl.className = 'spotlight-box';
        document.body.appendChild(spotlightEl);
    }
    if (!tooltipEl) {
        tooltipEl = document.createElement('div');
        tooltipEl.className = 'tutorial-tooltip';
        document.body.appendChild(tooltipEl);
    }
}

function removeSpotlightElements() {
    if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
    if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
}

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 14;
    let left = rect.left;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 140 > window.innerHeight) {
        top = rect.top - 154;
        if (top < 10) top = 10;
    }
    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function renderStep() {
    createSpotlightElements();
    const step = tutorialSteps[currentStep];
    const target = document.getElementById(step.targetElementId);
    if (!target) { nextStep(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => paintStep(target, step), 300);
    } else {
        paintStep(target, step);
    }
}

function paintStep(target, step) {
    positionSpotlight(target);
    const isLast = currentStep === tutorialSteps.length - 1;
    tooltipEl.innerHTML = `
        <p>${step.tooltipText}</p>
        <div class="tt-actions">
            <button class="tt-btn" id="tt-skip">Skip Tutorial</button>
            <button class="tt-btn primary" id="tt-next">${isLast ? 'Finish' : 'Next'}</button>
        </div>
    `;
    document.getElementById('tt-skip').addEventListener('click', endTutorial);
    document.getElementById('tt-next').addEventListener('click', nextStep);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    renderStep();
}

function endTutorial(completed) {
    removeSpotlightElements();
    if (completed) {
        document.getElementById('completion-modal').classList.add('show');
    }
}

function startTutorial() {
    currentStep = 0;
    renderStep();
}

window.addEventListener('resize', () => {
    if (spotlightEl && tooltipEl && tutorialSteps[currentStep]) {
        const target = document.getElementById(tutorialSteps[currentStep].targetElementId);
        if (target) positionSpotlight(target);
    }
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('completion-modal').classList.remove('show');
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
