<?php
// security-audit-compliance-automation-practical.php
// Standalone static practical: CloudGuard Compliance Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CloudGuard Compliance Console</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.mono { font-family: "JetBrains Mono", monospace; }

.page-wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 25px;
}
.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 600px;
}
.tutorial-btn {
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
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* DESCRIPTION */
.description-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 25px;
}
.description-box h3 {
    margin-top: 0;
    font-size: 1rem;
    color: var(--accent-primary);
}
.description-box p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.92rem;
}

/* MISSION BRIEF */
.mission-brief {
    background: linear-gradient(135deg, rgba(139,123,255,0.12), rgba(106,227,255,0.08));
    border: 1px solid var(--accent-secondary);
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 25px;
}
.mission-brief h4 {
    margin: 0 0 6px 0;
    color: var(--accent-secondary);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.mission-brief p {
    margin: 0;
    font-size: 0.95rem;
    color: var(--text-primary);
}

/* RESOURCE GRID */
.resource-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 14px;
    margin-bottom: 25px;
}
.resource-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px;
    cursor: pointer;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.resource-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.35);
}
.resource-card .name {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-primary);
    margin-bottom: 6px;
    word-break: break-word;
}
.resource-card .type {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 10px;
}
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.03em;
}
.badge.pass {
    background: rgba(61,255,154,0.12);
    color: var(--success);
    border: 1px solid rgba(61,255,154,0.3);
}
.badge.fail {
    background: rgba(255,92,92,0.12);
    color: var(--error);
    border: 1px solid rgba(255,92,92,0.3);
}

/* STATUS / FEEDBACK AREA */
.status-area {
    min-height: 20px;
    margin-bottom: 20px;
}
.status-message {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px 18px;
    font-size: 0.9rem;
}
.status-message.info { border-color: var(--border-default); color: var(--text-secondary); }
.status-message.violation { border-color: var(--error); color: var(--text-primary); }

/* REMEDIATION PANEL */
.remediation-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--error);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
}
.remediation-panel h4 {
    margin: 0 0 10px 0;
    color: var(--error);
    font-size: 0.95rem;
}
.remediation-panel p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 14px;
}
.confirm-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: opacity 0.2s ease;
}
.confirm-btn:hover { opacity: 0.85; }

/* FLAG REVEAL */
.flag-area {
    display: none;
    background: rgba(61,255,154,0.08);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px;
    margin-top: 10px;
}
.flag-area.show { display: block; }
.flag-area h4 {
    margin: 0 0 10px 0;
    color: var(--success);
    font-size: 1rem;
}
.flag-value {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.05rem;
    color: var(--success);
    letter-spacing: 0.02em;
    user-select: all;
}

/* SPOTLIGHT TUTORIAL */
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
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
.tooltip-next {
    background: var(--accent-primary);
    color: var(--bg-primary);
    font-weight: 700;
}
.tooltip-skip {
    background: transparent;
    color: var(--text-muted);
}

/* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 {
    margin-top: 0;
    color: var(--accent-primary);
}
.modal-box button {
    margin-top: 14px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 600px) {
    .header { flex-direction: column; }
}
</style>
</head>
<body>

<div class="page-wrap">
    <div class="header">
        <div>
            <h1>CloudGuard Compliance Console</h1>
            <div class="subtitle">Continuous compliance monitoring dashboard for a simulated production cloud environment.</div>
        </div>
        <button class="tutorial-btn" id="viewTutorialBtn">View Tutorial</button>
    </div>

    <div class="description-box">
        <h3>What This Environment Represents</h3>
        <p>This console represents a live cloud compliance dashboard, similar to what a security team monitors continuously in a real organization. Each resource card below shows the current pass or fail status of an automated control check.</p>
        <p>Your goal is to find the resource that violates the control described in the mission brief, then confirm its remediation to close out the finding.</p>
    </div>

    <div class="mission-brief" id="missionBrief">
        <h4>Mission Brief</h4>
        <p>CIS Benchmark Control 2.1.1 requires that no S3 bucket allow public read access. Continuous monitoring has flagged one violation. Find it and open its remediation panel.</p>
    </div>

    <div class="resource-grid" id="resourceGrid">
        <!-- Resource cards injected by JS -->
    </div>

    <div class="status-area" id="statusArea"></div>

    <div class="flag-area" id="flagArea">
        <h4>Audit Confirmed</h4>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Remediation confirmed. The finding has been logged and closed. Your flag:</p>
        <div class="flag-value" id="flagValue">CBX{drift_remediated}</div>
    </div>
</div>

<!-- Tutorial complete modal -->
<div class="modal-overlay" id="completeModal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p style="color: var(--text-secondary);">You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// RESOURCE DATA
// ============================================================
const resources = [
    { id: 'prod-customer-data', type: 'S3 Bucket', status: 'fail', control: 'CIS 2.1.1', detail: 'Public read access enabled on bucket ACL, violates CIS 2.1.1.' },
    { id: 'static-website-assets', type: 'S3 Bucket', status: 'pass', control: 'CIS 2.1.1', detail: 'Bucket ACL restricts public read access as required.' },
    { id: 'web-server-01', type: 'EC2 Instance', status: 'pass', control: 'CIS 4.3', detail: 'Security group correctly restricts inbound SSH access.' },
    { id: 'db-server-02', type: 'EC2 Instance', status: 'pass', control: 'CIS 4.3', detail: 'Security group correctly restricts inbound SSH access.' },
    { id: 'root-account', type: 'IAM Role', status: 'pass', control: 'CIS 1.5', detail: 'MFA is enforced on the root account.' },
    { id: 'deploy-service-account', type: 'IAM Role', status: 'pass', control: 'CIS 1.12', detail: 'Service account credentials rotated within policy window.' },
    { id: 'sg-web-prod', type: 'Security Group', status: 'pass', control: 'CIS 4.1', detail: 'No unrestricted ingress rules detected.' },
    { id: 'customer-orders-db', type: 'RDS Instance', status: 'pass', control: 'CIS 2.3.1', detail: 'Storage encryption is enabled.' }
];

const grid = document.getElementById('resourceGrid');
const statusArea = document.getElementById('statusArea');
const flagArea = document.getElementById('flagArea');

resources.forEach((res, idx) => {
    const card = document.createElement('div');
    card.className = 'resource-card';
    card.id = 'resource-card-' + idx;
    card.innerHTML = `
        <div class="name mono">${res.id}</div>
        <div class="type">${res.type}</div>
        <span class="badge ${res.status}">${res.status === 'pass' ? 'PASS' : 'FAIL'}</span>
    `;
    card.addEventListener('click', () => handleCardClick(res, idx));
    grid.appendChild(card);
});

function handleCardClick(res, idx) {
    document.querySelectorAll('.remediation-panel').forEach(el => el.remove());

    if (res.status === 'pass') {
        statusArea.innerHTML = `<div class="status-message info">${res.id} (${res.type}): ${res.detail}</div>`;
        return;
    }

    statusArea.innerHTML = `<div class="status-message violation">Violation detected on ${res.id}. Open the remediation panel below.</div>`;

    const panel = document.createElement('div');
    panel.className = 'remediation-panel';
    panel.id = 'remediation-panel';
    panel.innerHTML = `
        <h4>Remediation Required: ${res.id}</h4>
        <p>${res.detail}</p>
        <button class="confirm-btn" id="confirmRemediationBtn">Confirm Remediation</button>
    `;
    statusArea.insertAdjacentElement('afterend', panel);

    document.getElementById('confirmRemediationBtn').addEventListener('click', () => {
        flagArea.classList.add('show');
        flagArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
}

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetElementId: 'missionBrief',
        tooltipText: 'This is your mission brief. It tells you which CIS control to check and what kind of violation you are hunting for. Real auditors get briefs like this before every review.'
    },
    {
        targetElementId: 'resourceGrid',
        tooltipText: 'This grid shows every cloud resource being continuously monitored. Each card shows a live pass or fail status, just like a real compliance dashboard would.'
    },
    {
        targetElementId: 'resource-card-0',
        tooltipText: 'Click any card to see its compliance details. Look for the one that fails the control mentioned in your brief.'
    }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    tooltipEl.innerHTML = `
        <p id="tooltipText"></p>
        <div class="tooltip-actions">
            <button class="tooltip-skip" id="skipTutorialBtn">Skip Tutorial</button>
            <button class="tooltip-next" id="nextStepBtn">Next</button>
        </div>
    `;
    document.body.appendChild(tooltipEl);

    document.getElementById('skipTutorialBtn').addEventListener('click', endTutorial);
    document.getElementById('nextStepBtn').addEventListener('click', nextStep);
}

function positionSpotlight(targetEl) {
    const rect = targetEl.getBoundingClientRect();
    const padding = 8;
    spotlightEl.style.top = (rect.top - padding) + 'px';
    spotlightEl.style.left = (rect.left - padding) + 'px';
    spotlightEl.style.width = (rect.width + padding * 2) + 'px';
    spotlightEl.style.height = (rect.height + padding * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 16;
    let left = rect.left;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left < 10) left = 10;
    if (top < 10) top = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function showStep(index) {
    const step = tutorialSteps[index];
    const targetEl = document.getElementById(step.targetElementId);
    if (!targetEl) { nextStep(); return; }

    const rect = targetEl.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!isVisible) {
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(targetEl), 300);
    } else {
        positionSpotlight(targetEl);
    }

    document.getElementById('tooltipText').textContent = step.tooltipText;
    document.getElementById('nextStepBtn').textContent = (index === tutorialSteps.length - 1) ? 'Finish' : 'Next';
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    showStep(currentStep);
}

function endTutorial(completed) {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
    if (completed) {
        document.getElementById('completeModal').classList.add('show');
    }
}

function startTutorial() {
    currentStep = 0;
    createSpotlightElements();
    showStep(currentStep);
}

document.getElementById('viewTutorialBtn').addEventListener('click', startTutorial);
document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (spotlightEl && tutorialSteps[currentStep]) {
        const targetEl = document.getElementById(tutorialSteps[currentStep].targetElementId);
        if (targetEl) positionSpotlight(targetEl);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
