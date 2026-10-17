<?php
// ============================================================
// encryption-at-rest-in-transit-practical.php — PRACTICAL FILE
// Data Protection Console
// Fully static HTML/CSS/JS. No backend logic, no database, no sessions.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Protection Console</title>
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

.page-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
}

/* ===== TOP HEADER ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
    gap: 20px;
}

.top-header h1 {
    font-size: 1.9rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}

.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
    max-width: 640px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION SECTION ===== */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin: 24px 0;
}
.mission-briefing h2 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

/* ===== MAIN INTERACTIVE ENVIRONMENT ===== */
#console-header {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 30px 0 16px 0;
}

#asset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

.asset-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px;
    cursor: pointer;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.asset-card:hover {
    border-color: var(--accent-primary);
}
.asset-card.correct {
    border-color: var(--success);
    box-shadow: 0 0 14px rgba(61,255,154,0.2);
}
.asset-card.incorrect {
    border-color: var(--error);
    box-shadow: 0 0 14px rgba(255,92,92,0.2);
}

.asset-name {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 6px;
}
.asset-desc {
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin-bottom: 12px;
    min-height: 42px;
}
.badge-row {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.badge {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    padding: 3px 9px;
    border-radius: 20px;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
}
.badge.state { color: var(--accent-secondary); border-color: var(--accent-secondary); }
.badge.tier-restricted { color: var(--error); border-color: var(--error); }
.badge.tier-confidential { color: var(--warning); border-color: var(--warning); }
.badge.tier-internal { color: var(--accent-primary); border-color: var(--accent-primary); }
.badge.tier-public { color: var(--text-muted); border-color: var(--text-muted); }

.assigned-control {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.82rem;
    padding: 8px 10px;
    border-radius: 6px;
    background: var(--bg-primary);
    border: 1px dashed var(--border-default);
    color: var(--text-muted);
    text-align: center;
}
.assigned-control.filled {
    color: var(--accent-primary);
    border-style: solid;
    border-color: var(--accent-primary);
}

#control-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
}
#control-panel h3 {
    margin: 0 0 12px 0;
    font-size: 1rem;
    color: var(--text-primary);
}
.control-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.control-chip {
    font-family: 'JetBrains Mono', monospace;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 9px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}
.control-chip:hover {
    border-color: var(--accent-primary);
}
.control-chip.selected {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border-color: var(--accent-primary);
    font-weight: 600;
}

#validate-btn {
    display: block;
    width: 100%;
    margin-top: 8px;
    padding: 14px;
    background: linear-gradient(135deg, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}
#validate-btn:hover {
    box-shadow: var(--glow-accent);
}

/* ===== FEEDBACK / STATUS AREA ===== */
#status-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
#status-panel.status-success {
    border-color: var(--success);
    color: var(--success);
}
#status-panel.status-fail {
    border-color: var(--error);
    color: var(--error);
}

/* ===== FLAG REVEAL AREA ===== */
#flag-area {
    display: none;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 20px 24px;
    text-align: center;
    margin-top: 20px;
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
#flag-area h3 {
    margin-top: 0;
    color: var(--success);
}
#flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.15rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 18px;
    display: inline-block;
    color: var(--accent-primary);
    letter-spacing: 0.03em;
    user-select: all;
}

/* ===== TUTORIAL SYSTEM ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 9998;
}

.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tutorial-tooltip p {
    margin: 0 0 14px 0;
    color: var(--text-secondary);
}
.tutorial-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tutorial-actions button {
    font-family: inherit;
    font-size: 0.82rem;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tutorial-actions button.primary {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border-color: var(--accent-primary);
    font-weight: 600;
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 30px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-box h3 {
    margin-top: 0;
    color: var(--accent-primary);
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.modal-box button {
    margin-top: 10px;
    font-family: inherit;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .top-header { flex-direction: column; }
}
</style>
</head>
<body>

<div class="page-wrap">

    <!-- ===== TOP HEADER ===== -->
    <div class="top-header">
        <div>
            <h1>Data Protection Console</h1>
            <div class="subtitle">Assign the correct encryption control to six live data assets across your organization.</div>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- ===== DESCRIPTION SECTION ===== -->
    <div class="mission-briefing">
        <h2>What This Environment Represents</h2>
        <p>This console represents a live inventory of data assets pulled from a production environment. Each asset already has a known data state and sensitivity tier, but its encryption control has not yet been assigned.</p>
        <p>Your goal is to select the correct control for every asset and submit the policy for validation. Once every asset is correctly protected, the console will approve the policy and reveal a flag.</p>
    </div>

    <!-- ===== MAIN INTERACTIVE ENVIRONMENT ===== -->
    <div id="console-header">Data Assets</div>
    <div id="asset-grid"></div>

    <div id="control-panel">
        <h3>Available Controls</h3>
        <div class="control-list" id="control-list"></div>
        <button id="validate-btn">Check Policy</button>
    </div>

    <!-- ===== FEEDBACK / STATUS AREA ===== -->
    <div id="status-panel">Select a control, then click an asset card to assign it. Assign all six assets, then check your policy.</div>

    <!-- ===== FLAG REVEAL AREA ===== -->
    <div id="flag-area">
        <h3>Policy Approved</h3>
        <p>Every asset is correctly protected. Here is your flag:</p>
        <div id="flag-value" readonly>CBX{controls_mapped}</div>
    </div>

</div>

<!-- Tutorial completion modal -->
<div class="modal-overlay" id="tutorial-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA
// ============================================================
const assets = [
    { id: 1, name: 'Internal Support Chat', desc: 'Chat traffic between employee laptops connected via a site to site VPN tunnel', state: 'In Transit', tier: 'Internal', correct: 'IPSec' },
    { id: 2, name: 'Checkout API Requests', desc: 'Customer payment form data sent from the browser to the checkout API', state: 'In Transit', tier: 'Confidential', correct: 'TLS' },
    { id: 3, name: 'Customer Profile Database', desc: 'Database storing customer names, addresses, and account details', state: 'At Rest', tier: 'Confidential', correct: 'TDE' },
    { id: 4, name: 'Nightly Backup Archive', desc: 'Full nightly backup volume stored in cold storage', state: 'At Rest', tier: 'Restricted', correct: 'Disk Encryption' },
    { id: 5, name: 'Payment Card Vault', desc: 'Card number fields stored inside the payments database, alongside other order data', state: 'At Rest', tier: 'Restricted', correct: 'Field-Level Encryption' },
    { id: 6, name: 'Patient Analytics Job', desc: 'Cloud VM job that decrypts and processes patient records in memory to generate reports', state: 'In Use', tier: 'Restricted', correct: 'Secure Enclave / TEE' }
];

const controls = ['TLS', 'IPSec', 'Disk Encryption', 'TDE', 'Field-Level Encryption', 'Secure Enclave / TEE'];

let selectedControl = null;
const assignments = {};

// ============================================================
// RENDER ASSET GRID
// ============================================================
const grid = document.getElementById('asset-grid');
assets.forEach((asset, index) => {
    const card = document.createElement('div');
    card.className = 'asset-card';
    card.id = 'asset-card-' + asset.id;

    const tierClass = 'tier-' + asset.tier.toLowerCase();

    card.innerHTML = `
        <div class="asset-name">${asset.name}</div>
        <div class="asset-desc">${asset.desc}</div>
        <div class="badge-row">
            <span class="badge state">${asset.state}</span>
            <span class="badge ${tierClass}">${asset.tier}</span>
        </div>
        <div class="assigned-control" id="assigned-${asset.id}">No control assigned</div>
    `;

    card.addEventListener('click', () => {
        if (!selectedControl) {
            setStatus('Select a control from the panel below first.', null);
            return;
        }
        assignments[asset.id] = selectedControl;
        const label = document.getElementById('assigned-' + asset.id);
        label.textContent = selectedControl;
        label.classList.add('filled');
        card.classList.remove('correct', 'incorrect');
    });

    grid.appendChild(card);
});

// ============================================================
// RENDER CONTROL PANEL
// ============================================================
const controlList = document.getElementById('control-list');
controls.forEach(ctrl => {
    const chip = document.createElement('div');
    chip.className = 'control-chip';
    chip.textContent = ctrl;
    chip.addEventListener('click', () => {
        document.querySelectorAll('.control-chip').forEach(c => c.classList.remove('selected'));
        chip.classList.add('selected');
        selectedControl = ctrl;
        setStatus('Control selected: ' + ctrl + '. Now click an asset card to assign it.', null);
    });
    controlList.appendChild(chip);
});

// ============================================================
// STATUS HELPER
// ============================================================
function setStatus(message, state) {
    const panel = document.getElementById('status-panel');
    panel.textContent = message;
    panel.classList.remove('status-success', 'status-fail');
    if (state === 'success') panel.classList.add('status-success');
    if (state === 'fail') panel.classList.add('status-fail');
}

// ============================================================
// VALIDATION
// ============================================================
document.getElementById('validate-btn').addEventListener('click', () => {
    let allCorrect = true;
    let unassignedCount = 0;

    assets.forEach(asset => {
        const card = document.getElementById('asset-card-' + asset.id);
        const assigned = assignments[asset.id];

        if (!assigned) {
            unassignedCount++;
            allCorrect = false;
            return;
        }

        card.classList.remove('correct', 'incorrect');
        if (assigned === asset.correct) {
            card.classList.add('correct');
        } else {
            card.classList.add('incorrect');
            allCorrect = false;
        }
    });

    if (unassignedCount > 0) {
        setStatus('Assign a control to all six assets before checking the policy. ' + unassignedCount + ' remaining.', 'fail');
        return;
    }

    if (allCorrect) {
        setStatus('Policy approved. Every asset is correctly protected.', 'success');
        document.getElementById('flag-area').style.display = 'block';
        document.getElementById('flag-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        setStatus('Some assets are incorrectly protected. Check the highlighted cards and reconsider the data state and tier for each.', 'fail');
    }
});

// ============================================================
// TUTORIAL SYSTEM (spotlight-based)
// ============================================================
const tutorialSteps = [
    { targetId: 'console-header', text: 'This is the Data Protection Console. You will act as a security architect assigning the right protection control to each data asset below.' },
    { targetId: 'asset-grid', text: 'Each card here represents a real data asset in the company, along with its sensitivity tier and its current data state.' },
    { targetId: 'asset-card-1', text: 'Read the description and state badge carefully. This tells you whether the data is in transit, at rest, or in use, which determines which controls are even valid.' },
    { targetId: 'control-panel', text: 'These are your six available controls. Click a control, then click the asset card you want to assign it to.' },
    { targetId: 'validate-btn', text: 'Once you have assigned a control to every asset, click Check Policy to validate your choices.' },
    { targetId: 'status-panel', text: 'Feedback and your final flag will appear here once every asset is correctly protected.' }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tutorial-tooltip';
    document.body.appendChild(tooltipEl);
}

function removeSpotlightElements() {
    if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
    if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;

    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 16;
    let left = rect.left;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 160 > window.innerHeight) {
        top = rect.top - 16;
        tooltipEl.style.transform = 'translateY(-100%)';
    } else {
        tooltipEl.style.transform = 'none';
    }
    if (left < 20) left = 20;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function showStep(index) {
    currentStep = index;
    const step = tutorialSteps[index];
    const target = document.getElementById(step.targetId);
    if (!target) { nextStep(); return; }

    const rect = target.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const renderTooltip = () => {
        tooltipEl.innerHTML = `
            <p>${step.text}</p>
            <div class="tutorial-actions">
                <button id="tut-skip">Skip Tutorial</button>
                <button id="tut-next" class="primary">${index === tutorialSteps.length - 1 ? 'Finish' : 'Next'}</button>
            </div>
        `;
        positionSpotlight(target);
        document.getElementById('tut-next').addEventListener('click', nextStep);
        document.getElementById('tut-skip').addEventListener('click', endTutorial);
    };

    if (!isVisible) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(renderTooltip, 300);
    } else {
        renderTooltip();
    }
}

function nextStep() {
    if (currentStep < tutorialSteps.length - 1) {
        showStep(currentStep + 1);
    } else {
        endTutorial(true);
    }
}

function endTutorial(completed) {
    removeSpotlightElements();
    if (completed) {
        document.getElementById('tutorial-modal').style.display = 'flex';
    }
}

function startTutorial() {
    createSpotlightElements();
    showStep(0);
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-modal').style.display = 'none';
});

window.addEventListener('resize', () => {
    if (spotlightEl && tooltipEl) {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
