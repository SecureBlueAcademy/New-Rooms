<?php
// digital-signatures-ca-operations-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CA Operations Console</title>
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
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 20px;
}
.mono { font-family: "JetBrains Mono", monospace; }

header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto 20px auto;
    flex-wrap: wrap;
    gap: 12px;
}
header h1 {
    font-size: 1.6rem;
    font-weight: 700;
}
header p.subtitle {
    color: var(--text-secondary);
    margin-top: 4px;
    max-width: 600px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    white-space: nowrap;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

.description-section {
    max-width: 1200px;
    margin: 0 auto 24px auto;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
}
.description-section h2 {
    font-size: 1.05rem;
    margin-bottom: 8px;
    color: var(--accent-primary);
}
.description-section p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.main-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 20px;
}
@media (max-width: 900px) {
    .main-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px;
}
.panel h3 {
    font-size: 0.95rem;
    color: var(--text-primary);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.panel h3 .badge {
    font-size: 0.7rem;
    background: var(--bg-surface);
    color: var(--text-muted);
    padding: 2px 8px;
    border-radius: 20px;
}

#csr-queue-panel .csr-item {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: border-color 0.15s ease;
}
#csr-queue-panel .csr-item:hover { border-color: var(--accent-primary); }
#csr-queue-panel .csr-item.selected { border-color: var(--accent-primary); box-shadow: var(--glow-accent); }
#csr-queue-panel .csr-item.done { opacity: 0.5; }
.csr-item .csr-cn {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-primary);
}
.csr-item .csr-status {
    font-size: 0.7rem;
    margin-top: 4px;
    color: var(--text-muted);
}
.csr-item .csr-status.issued { color: var(--success); }

#csr-detail-view {
    min-height: 140px;
}
#csr-detail-view .field {
    margin-bottom: 10px;
}
#csr-detail-view .field label {
    display: block;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 2px;
}
#csr-detail-view .field .value {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.88rem;
    color: var(--text-primary);
}
#csr-detail-view .empty-state {
    color: var(--text-muted);
    font-style: italic;
    font-size: 0.9rem;
}

#ca-hierarchy-tree .tree-node {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    padding: 6px 10px;
    border-radius: 6px;
    margin-bottom: 4px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
}
#ca-hierarchy-tree .tree-node.root { color: var(--accent-secondary); }
#ca-hierarchy-tree .tree-node.intermediate { margin-left: 18px; color: var(--accent-primary); }

#issuance-controls select {
    width: 100%;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 9px 10px;
    border-radius: 8px;
    font-family: inherit;
    margin-bottom: 12px;
    font-size: 0.88rem;
}
#issuance-controls label {
    display: block;
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin-bottom: 4px;
}
#issue-button {
    width: 100%;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    font-size: 0.9rem;
}
#issue-button:hover { box-shadow: var(--glow-accent); }
#issue-button:disabled { opacity: 0.4; cursor: not-allowed; }

#feedback-area {
    min-height: 20px;
    margin-top: 10px;
    font-size: 0.85rem;
    padding: 10px 12px;
    border-radius: 8px;
    display: none;
}
#feedback-area.show { display: block; }
#feedback-area.success { background: rgba(61,255,154,0.08); border: 1px solid var(--success); color: var(--success); }
#feedback-area.error { background: rgba(255,92,92,0.08); border: 1px solid var(--error); color: var(--error); }

#ca-operations-log {
    grid-column: 1 / -1;
    max-height: 220px;
    overflow-y: auto;
}
#ca-operations-log .log-line {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    padding: 6px 0;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-secondary);
}
#ca-operations-log .log-line.success { color: var(--success); }
#ca-operations-log .log-line.error { color: var(--error); }
#ca-operations-log .log-line.flag {
    color: var(--accent-primary);
    font-weight: 600;
}

#flag-reveal-area {
    max-width: 1200px;
    margin: 20px auto 0 auto;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px;
    display: none;
    text-align: center;
}
#flag-reveal-area.show { display: block; }
#flag-reveal-area h3 { color: var(--success); margin-bottom: 10px; }
#flag-reveal-area .flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 12px 20px;
    border-radius: 8px;
    display: inline-block;
    letter-spacing: 0.03em;
}

/* Spotlight tutorial system */
.spotlight-box {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 9998;
    transition: all 0.25s ease;
}
.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 14px 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tutorial-tooltip p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.5;
    margin-bottom: 12px;
}
.tutorial-tooltip .tt-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tutorial-tooltip button {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 6px 14px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.8rem;
    cursor: pointer;
}
.tutorial-tooltip button.primary {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}
.tutorial-tooltip .tt-skip {
    color: var(--text-muted);
    border: none;
    background: none;
}
.tutorial-tooltip .tt-step {
    font-size: 0.7rem;
    color: var(--text-muted);
}

.tutorial-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
}
.tutorial-modal-backdrop.show { display: flex; }
.tutorial-modal {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.tutorial-modal h3 { color: var(--accent-primary); margin-bottom: 10px; }
.tutorial-modal p { color: var(--text-secondary); margin-bottom: 18px; font-size: 0.9rem; }
.tutorial-modal button {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
}
</style>
</head>
<body>

<header>
    <div>
        <h1>Example Corp CA Operations Console</h1>
        <p class="subtitle">You are the CA operator on duty. Review each pending certificate signing request and issue it correctly for its intended purpose.</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</header>

<div class="description-section">
    <h2>Mission Briefing</h2>
    <p>This console represents the internal CA management system used to issue certificates across Example Corp. Six requests are waiting in the queue, each for a different system and purpose: public web servers, internal build tooling, internal email, and VPN client authentication.</p>
    <p>Your job is to inspect each request, choose the correct intermediate CA, certificate profile, and validity period, then issue it. Picking the wrong combination will be rejected with an explanation. Issue all six correctly to reveal the final audit entry in the operations log.</p>
</div>

<div class="main-grid">
    <div class="panel" id="csr-queue-panel">
        <h3>CSR Queue <span class="badge" id="queue-badge">0 / 6 issued</span></h3>
        <div id="csr-list"></div>
    </div>

    <div class="panel" id="csr-detail-view">
        <h3>Request Details</h3>
        <div id="detail-content">
            <p class="empty-state">Select a request from the queue to review its details.</p>
        </div>
    </div>

    <div class="panel" id="ca-hierarchy-tree" style="grid-column: 1;">
        <h3>CA Hierarchy</h3>
        <div class="tree-node root">Example Corp Root CA (offline)</div>
        <div class="tree-node intermediate">Server &amp; Client Auth Issuing CA</div>
        <div class="tree-node intermediate">Code Signing Issuing CA</div>
        <div class="tree-node intermediate">S/MIME Issuing CA</div>
    </div>

    <div class="panel" id="issuance-controls" style="grid-column: 2;">
        <h3>Issuance Controls</h3>
        <label for="intermediate-selector">Intermediate CA</label>
        <select id="intermediate-selector">
            <option value="">Select intermediate...</option>
            <option value="server-client">Server &amp; Client Auth Issuing CA</option>
            <option value="code-signing">Code Signing Issuing CA</option>
            <option value="smime">S/MIME Issuing CA</option>
        </select>

        <label for="profile-selector">Certificate Profile</label>
        <select id="profile-selector">
            <option value="">Select profile...</option>
            <option value="tls-server">TLS Server</option>
            <option value="code-signing">Code Signing</option>
            <option value="smime">S/MIME (Email Protection)</option>
            <option value="client-auth">Client Authentication</option>
        </select>

        <label for="validity-selector">Validity Period</label>
        <select id="validity-selector">
            <option value="">Select validity...</option>
            <option value="397">397 days</option>
            <option value="365">365 days</option>
            <option value="1095">1095 days</option>
            <option value="1825">1825 days</option>
        </select>

        <button id="issue-button" disabled>Issue Certificate</button>
        <div id="feedback-area"></div>
    </div>

    <div class="panel" id="ca-operations-log">
        <h3>CA Operations Log</h3>
        <div id="log-content">
            <div class="log-line">Console initialized. Awaiting issuance activity.</div>
        </div>
    </div>
</div>

<div id="flag-reveal-area">
    <h3>All Certificates Issued Correctly</h3>
    <p style="color: var(--text-secondary); margin-bottom: 14px;">The operations log has recorded a final audit entry.</p>
    <div class="flag-value" id="flag-value">CBX{chain_of_trust_verified}</div>
</div>

<div class="tutorial-modal-backdrop" id="tutorial-complete-modal">
    <div class="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Review each request, choose the correct intermediate, profile, and validity, then issue.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const csrData = [
    {
        id: 'csr-1',
        cn: 'www.example-corp.com',
        org: 'Example Corp',
        purpose: 'Public web server TLS',
        note: 'Requesting a certificate for the main public marketing site. Must be trusted by all major browsers.',
        correctIntermediate: 'server-client',
        correctProfile: 'tls-server',
        correctValidity: '397'
    },
    {
        id: 'csr-2',
        cn: 'build-agent-42',
        org: 'Example Corp Engineering',
        purpose: 'Sign internal build artifacts',
        note: 'Requesting a certificate to sign compiled binaries produced by the internal CI pipeline before distribution.',
        correctIntermediate: 'code-signing',
        correctProfile: 'code-signing',
        correctValidity: '1095'
    },
    {
        id: 'csr-3',
        cn: 'jsmith@example-corp.com',
        org: 'Example Corp Finance',
        purpose: 'Encrypt and sign internal email',
        note: 'Requesting a certificate for S/MIME to sign and encrypt sensitive internal email correspondence.',
        correctIntermediate: 'smime',
        correctProfile: 'smime',
        correctValidity: '365'
    },
    {
        id: 'csr-4',
        cn: 'vpn-client-laptop-114',
        org: 'Example Corp IT',
        purpose: 'Authenticate to internal VPN',
        note: 'Requesting a client certificate for a corporate laptop to authenticate against the internal VPN gateway.',
        correctIntermediate: 'server-client',
        correctProfile: 'client-auth',
        correctValidity: '365'
    },
    {
        id: 'csr-5',
        cn: 'api-internal.example-corp.local',
        org: 'Example Corp Platform',
        purpose: 'Internal API server TLS',
        note: 'Requesting a TLS certificate for an internal-only API gateway used by backend services.',
        correctIntermediate: 'server-client',
        correctProfile: 'tls-server',
        correctValidity: '397'
    },
    {
        id: 'csr-6',
        cn: 'finance-payroll-app',
        org: 'Example Corp Finance',
        purpose: 'Sign internal payroll application',
        note: 'Requesting a certificate to sign the internal payroll desktop application before it is distributed to employees.',
        correctIntermediate: 'code-signing',
        correctProfile: 'code-signing',
        correctValidity: '1095'
    }
];

let selectedCsrId = null;
let issuedCount = 0;

const intermediateLabels = {
    'server-client': 'Server & Client Auth Issuing CA',
    'code-signing': 'Code Signing Issuing CA',
    'smime': 'S/MIME Issuing CA'
};
const profileLabels = {
    'tls-server': 'TLS Server',
    'code-signing': 'Code Signing',
    'smime': 'S/MIME (Email Protection)',
    'client-auth': 'Client Authentication'
};

function renderQueue() {
    const list = document.getElementById('csr-list');
    list.innerHTML = '';
    csrData.forEach(csr => {
        const div = document.createElement('div');
        div.className = 'csr-item' + (csr.id === selectedCsrId ? ' selected' : '') + (csr.issued ? ' done' : '');
        div.onclick = () => selectCsr(csr.id);
        div.innerHTML = `
            <div class="csr-cn">${csr.cn}</div>
            <div class="csr-status ${csr.issued ? 'issued' : ''}">${csr.issued ? 'Issued' : 'Pending review'}</div>
        `;
        list.appendChild(div);
    });
    document.getElementById('queue-badge').textContent = issuedCount + ' / 6 issued';
}

function selectCsr(id) {
    selectedCsrId = id;
    const csr = csrData.find(c => c.id === id);
    renderQueue();

    const detail = document.getElementById('detail-content');
    detail.innerHTML = `
        <div class="field"><label>Common Name</label><div class="value">${csr.cn}</div></div>
        <div class="field"><label>Organization</label><div class="value">${csr.org}</div></div>
        <div class="field"><label>Requested Purpose</label><div class="value">${csr.purpose}</div></div>
        <div class="field"><label>Requester Note</label><div class="value" style="font-family: inherit; font-size: 0.85rem; color: var(--text-secondary);">${csr.note}</div></div>
    `;

    document.getElementById('intermediate-selector').value = '';
    document.getElementById('profile-selector').value = '';
    document.getElementById('validity-selector').value = '';
    document.getElementById('feedback-area').className = '';
    updateIssueButton();
}

function updateIssueButton() {
    const i = document.getElementById('intermediate-selector').value;
    const p = document.getElementById('profile-selector').value;
    const v = document.getElementById('validity-selector').value;
    const csr = csrData.find(c => c.id === selectedCsrId);
    document.getElementById('issue-button').disabled = !(selectedCsrId && i && p && v && csr && !csr.issued);
}

['intermediate-selector', 'profile-selector', 'validity-selector'].forEach(id => {
    document.getElementById(id).addEventListener('change', updateIssueButton);
});

function addLogLine(text, type) {
    const log = document.getElementById('log-content');
    const line = document.createElement('div');
    line.className = 'log-line' + (type ? ' ' + type : '');
    const time = new Date().toLocaleTimeString();
    line.textContent = `[${time}] ${text}`;
    log.appendChild(line);
    log.scrollTop = log.scrollHeight;
}

document.getElementById('issue-button').addEventListener('click', () => {
    const csr = csrData.find(c => c.id === selectedCsrId);
    const i = document.getElementById('intermediate-selector').value;
    const p = document.getElementById('profile-selector').value;
    const v = document.getElementById('validity-selector').value;

    const feedback = document.getElementById('feedback-area');
    feedback.classList.add('show');

    if (i !== csr.correctIntermediate) {
        feedback.className = 'show error';
        feedback.textContent = `Rejected: A certificate for "${csr.purpose}" cannot be issued from the ${intermediateLabels[i]}.`;
        addLogLine(`REJECTED ${csr.cn}: wrong intermediate (${intermediateLabels[i]})`, 'error');
        return;
    }
    if (p !== csr.correctProfile) {
        feedback.className = 'show error';
        feedback.textContent = `Rejected: The "${profileLabels[p]}" profile does not match the requested purpose "${csr.purpose}".`;
        addLogLine(`REJECTED ${csr.cn}: wrong profile (${profileLabels[p]})`, 'error');
        return;
    }
    if (v !== csr.correctValidity) {
        feedback.className = 'show error';
        feedback.textContent = `Rejected: ${v} days is not an appropriate validity period for this certificate type.`;
        addLogLine(`REJECTED ${csr.cn}: invalid validity period (${v} days)`, 'error');
        return;
    }

    csr.issued = true;
    issuedCount++;
    feedback.className = 'show success';
    feedback.textContent = `Issued: ${csr.cn} certificate signed by ${intermediateLabels[i]}, profile ${profileLabels[p]}, valid ${v} days.`;
    addLogLine(`ISSUED ${csr.cn} via ${intermediateLabels[i]} (${profileLabels[p]}, ${v}d)`, 'success');
    renderQueue();
    updateIssueButton();

    if (issuedCount === csrData.length) {
        setTimeout(() => {
            addLogLine('AUDIT: All pending requests processed. Chain integrity verified across all intermediates. CBX{chain_of_trust_verified}', 'flag');
            document.getElementById('flag-reveal-area').classList.add('show');
            document.getElementById('flag-reveal-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 400);
    }
});

renderQueue();

// ================= Tutorial system =================
const tutorialSteps = [
    { targetId: 'csr-queue-panel', text: 'This is your CSR queue, every certificate request waiting for review. Real-world analogy: an inbox of applications waiting for an approver.' },
    { targetId: 'csr-detail-view', text: 'Selecting a request shows its details. Check the requested purpose carefully. This is what a real CA operator reviews before issuing.' },
    { targetId: 'ca-hierarchy-tree', text: 'This is your CA hierarchy. The Root CA stays offline and never signs end-entity certificates directly. Intermediates do the actual issuing.' },
    { targetId: 'intermediate-selector', text: 'Choose which intermediate CA should sign this certificate. Each intermediate is scoped to a specific purpose.' },
    { targetId: 'profile-selector', text: 'Choose the certificate profile. This determines the key usage and extended key usage baked into the issued certificate.' },
    { targetId: 'validity-selector', text: 'Choose a validity period. Public TLS certificates have strict maximum lifetimes; internal certs have more flexibility.' },
    { targetId: 'issue-button', text: 'Issue the certificate. If anything does not match the request\'s purpose, you will get a rejection with the reason, so you can correct it.' },
    { targetId: 'ca-operations-log', text: 'Every issuance is logged here. Process all six requests correctly and watch this log for your final entry.' }
];
let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight-box';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tutorial-tooltip';
    document.body.appendChild(tooltipEl);
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 14;
    let left = rect.left;

    if (top + 140 > window.innerHeight) {
        top = rect.top - 14;
        tooltipEl.style.transform = 'translateY(-100%)';
    } else {
        tooltipEl.style.transform = 'none';
    }
    if (left + tooltipWidth > window.innerWidth) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (left < 10) left = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function renderTutorialStep() {
    const step = tutorialSteps[currentStep];
    const target = document.getElementById(step.targetId);
    if (!target) { nextStep(); return; }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        positionSpotlight(target);
        tooltipEl.innerHTML = `
            <p>${step.text}</p>
            <div class="tt-controls">
                <span class="tt-step">Step ${currentStep + 1} of ${tutorialSteps.length}</span>
                <div>
                    <button class="tt-skip" id="tt-skip-btn">Skip Tutorial</button>
                    <button class="primary" id="tt-next-btn">${currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next'}</button>
                </div>
            </div>
        `;
        document.getElementById('tt-next-btn').onclick = nextStep;
        document.getElementById('tt-skip-btn').onclick = endTutorial;
    }, 300);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        renderTutorialStep();
    }
}

function endTutorial(completed) {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
    if (completed) {
        document.getElementById('tutorial-complete-modal').classList.add('show');
    }
}

function startTutorial() {
    currentStep = 0;
    createSpotlightElements();
    renderTutorialStep();
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (spotlightEl && tooltipEl && tutorialSteps[currentStep]) {
        const target = document.getElementById(tutorialSteps[currentStep].targetId);
        if (target) positionSpotlight(target);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 500);
});
</script>

</body>
</html>
