<?php
// ids-ips-engineering-practical.php
// Standalone static practical: Sensor Placement Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sensor Placement Console</title>
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

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        min-height: 100vh;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        max-width: 1100px;
        margin: 0 auto 20px auto;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--accent-primary);
    }

    .page-header p {
        color: var(--text-secondary);
        margin-top: 6px;
        max-width: 640px;
    }

    .tutorial-btn {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        color: var(--accent-primary);
        padding: 10px 18px;
        border-radius: 8px;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    .tutorial-btn:hover { box-shadow: var(--glow-accent); }

    .description-section {
        max-width: 1100px;
        margin: 0 auto 24px auto;
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 18px 22px;
    }
    .description-section h2 {
        font-size: 1.05rem;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .description-section p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .main-env {
        max-width: 1100px;
        margin: 0 auto 24px auto;
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 24px;
    }

    #topology-map {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding: 20px 6px;
    }

    .node {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.75rem;
        width: 70px;
    }
    .node-icon {
        font-size: 1.4rem;
        margin-bottom: 4px;
    }

    .arrow {
        color: var(--text-muted);
        font-size: 1.2rem;
    }

    .placement-point {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 12px 10px;
        width: 130px;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        text-align: center;
    }
    .placement-point:hover {
        border-color: var(--accent-primary);
    }
    .placement-point.correct {
        border-color: var(--success);
        box-shadow: 0 0 14px rgba(61,255,154,0.25);
    }
    .placement-point .pp-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 6px;
    }
    .placement-point .pp-status {
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    .placement-point.correct .pp-status {
        color: var(--success);
    }

    .config-panel {
        margin-top: 24px;
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px;
        display: none;
    }
    .config-panel.active { display: block; }
    .config-panel h3 {
        font-size: 1rem;
        margin-bottom: 12px;
        color: var(--accent-primary);
    }
    .config-row {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }
    .config-group label {
        display: block;
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-bottom: 6px;
    }
    #sensor-type-select, #sensor-mode-select {
        background: var(--bg-primary);
        border: 1px solid var(--border-default);
        color: var(--text-primary);
        padding: 8px 12px;
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.85rem;
        min-width: 160px;
    }
    .apply-btn {
        background: var(--accent-secondary);
        border: none;
        color: #0b0f1a;
        font-weight: 600;
        padding: 9px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
        align-self: flex-end;
    }
    .apply-btn:hover { opacity: 0.9; }

    #coverage-meter {
        max-width: 1100px;
        margin: 0 auto 24px auto;
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 18px 22px;
    }
    .meter-track {
        background: var(--bg-primary);
        border-radius: 8px;
        height: 18px;
        overflow: hidden;
        border: 1px solid var(--border-default);
    }
    .meter-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--accent-primary), var(--success));
        transition: width 0.4s ease;
    }
    .meter-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-bottom: 8px;
    }

    #hint-panel {
        max-width: 1100px;
        margin: 0 auto 24px auto;
        min-height: 50px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 16px 22px;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    #hint-panel.warn {
        border-color: var(--warning);
        color: var(--warning);
    }
    #hint-panel.ok {
        border-color: var(--success);
        color: var(--success);
    }

    .flag-section {
        max-width: 1100px;
        margin: 0 auto;
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 20px 22px;
        text-align: center;
        display: none;
    }
    .flag-section.revealed { display: block; }
    .flag-section h2 {
        color: var(--success);
        margin-bottom: 10px;
    }
    .flag-value {
        font-family: "JetBrains Mono", monospace;
        background: var(--bg-primary);
        border: 1px solid var(--success);
        color: var(--success);
        display: inline-block;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 1.05rem;
        letter-spacing: 0.02em;
    }

    /* Spotlight tutorial */
    .spotlight {
        position: fixed;
        border-radius: 8px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 9998;
    }
    .tooltip-card {
        position: fixed;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px;
        max-width: 300px;
        z-index: 9999;
        font-size: 0.85rem;
        color: var(--text-primary);
        line-height: 1.5;
        box-shadow: var(--glow-accent);
    }
    .tooltip-card .tt-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 12px;
    }
    .tooltip-card button {
        background: var(--accent-primary);
        border: none;
        color: #0b0f1a;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
        font-size: 0.8rem;
    }
    .tooltip-card .skip-btn {
        background: transparent;
        color: var(--text-muted);
        font-weight: 500;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 12px;
        padding: 28px;
        max-width: 360px;
        text-align: center;
    }
    .modal-box h3 { color: var(--accent-primary); margin-bottom: 10px; }
    .modal-box p { color: var(--text-secondary); margin-bottom: 16px; font-size: 0.9rem; }
    .modal-box button {
        background: var(--accent-primary);
        border: none;
        color: #0b0f1a;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-family: inherit;
    }
</style>
</head>
<body>

<div class="page-header">
    <div>
        <h1>Sensor Placement Console</h1>
        <p>Design an IDS/IPS deployment across a live network path, from the internet edge down to the crown jewel database.</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</div>

<div class="description-section">
    <h2>Mission Briefing</h2>
    <p>You are the security engineer responsible for a network stretching from the internet edge to a sensitive internal database. Five candidate points along this path need a decision: what type of sensor belongs there, and if it is network based, whether it should sit inline or passive. Configure all five points correctly to complete the design.</p>
</div>

<div class="main-env">
    <div id="topology-map">
        <div class="node"><div class="node-icon">🌐</div>Internet</div>
        <div class="arrow">→</div>
        <div class="placement-point" id="point-1" data-point="1">
            <div class="pp-label">1. Perimeter Link</div>
            <div class="pp-status">Not configured</div>
        </div>
        <div class="arrow">→</div>
        <div class="placement-point" id="point-2" data-point="2">
            <div class="pp-label">2. DMZ Boundary</div>
            <div class="pp-status">Not configured</div>
        </div>
        <div class="arrow">→</div>
        <div class="placement-point" id="point-3" data-point="3">
            <div class="pp-label">3. Core Backbone</div>
            <div class="pp-status">Not configured</div>
        </div>
        <div class="arrow">→</div>
        <div class="placement-point" id="point-4" data-point="4">
            <div class="pp-label">4. Finance VLAN</div>
            <div class="pp-status">Not configured</div>
        </div>
        <div class="arrow">→</div>
        <div class="placement-point" id="point-5" data-point="5">
            <div class="pp-label">5. Database Server</div>
            <div class="pp-status">Not configured</div>
        </div>
    </div>

    <div class="config-panel" id="config-panel">
        <h3 id="config-title">Configure Point</h3>
        <div class="config-row">
            <div class="config-group">
                <label for="sensor-type-select">Sensor Type</label>
                <select id="sensor-type-select">
                    <option value="">Select type</option>
                    <option value="NIDS">NIDS (network based)</option>
                    <option value="HIDS">HIDS (host based)</option>
                </select>
            </div>
            <div class="config-group" id="mode-group">
                <label for="sensor-mode-select">Deployment Mode</label>
                <select id="sensor-mode-select">
                    <option value="">Select mode</option>
                    <option value="Inline">Inline</option>
                    <option value="Passive">Passive</option>
                </select>
            </div>
            <button class="apply-btn" id="apply-config-btn">Apply</button>
        </div>
    </div>
</div>

<div id="coverage-meter">
    <div class="meter-label">Design Coverage</div>
    <div class="meter-track"><div class="meter-fill" id="meter-fill"></div></div>
</div>

<div id="hint-panel">Select a placement point on the topology above to begin configuring your design.</div>

<div class="flag-section" id="flag-section">
    <h2>Design Complete</h2>
    <p>All five points are correctly configured. Your sensor placement design balances visibility, blocking power, and failure risk.</p>
    <div class="flag-value" id="flag-value">CBX{coverage_optimized}</div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Configure each point on the topology to build a sound sensor placement design.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA: correct configuration per point
// ============================================================
const correctConfig = {
    1: { type: 'NIDS', mode: 'Inline' },
    2: { type: 'NIDS', mode: 'Passive' },
    3: { type: 'NIDS', mode: 'Passive' },
    4: { type: 'NIDS', mode: 'Passive' },
    5: { type: 'HIDS', mode: null }
};

const hints = {
    1: {
        wrongType: "The perimeter link faces the open internet directly. A host based agent alone can't see traffic before it ever reaches a host.",
        wrongMode: "This is the highest risk boundary in the network. Passive visibility alone isn't enough here, active blocking is justified."
    },
    2: {
        wrongType: "The DMZ boundary is a network chokepoint, not a single host. Network based visibility fits here.",
        wrongMode: "Placing a second inline chokepoint immediately behind an already active perimeter adds risk without much added benefit. Visibility is enough here."
    },
    3: {
        wrongType: "The core backbone aggregates traffic from every internal VLAN. That calls for network based visibility, not a host agent.",
        wrongMode: "An inline failure here would take down all internal traffic, not just one segment. This is too central a point for inline risk."
    },
    4: {
        wrongType: "The Finance VLAN boundary is a segment chokepoint. Network based detection fits this location.",
        wrongMode: "This sensitive segment needs visibility, not another inline bottleneck. Passive keeps the risk proportional to the value gained."
    },
    5: {
        wrongType: "Only a host based agent can see file integrity and process level activity on this single high value server.",
        wrongMode: ""
    }
};

let currentPoint = null;
const pointStates = {1: false, 2: false, 3: false, 4: false, 5: false};

const configPanel = document.getElementById('config-panel');
const configTitle = document.getElementById('config-title');
const typeSelect = document.getElementById('sensor-type-select');
const modeSelect = document.getElementById('sensor-mode-select');
const modeGroup = document.getElementById('mode-group');
const hintPanel = document.getElementById('hint-panel');
const meterFill = document.getElementById('meter-fill');
const flagSection = document.getElementById('flag-section');

const pointNames = {
    1: 'Perimeter Link',
    2: 'DMZ Boundary',
    3: 'Core Backbone',
    4: 'Finance VLAN Segment',
    5: 'Database Server'
};

document.querySelectorAll('.placement-point').forEach(el => {
    el.addEventListener('click', () => {
        currentPoint = parseInt(el.dataset.point);
        configTitle.textContent = 'Configure Point ' + currentPoint + ': ' + pointNames[currentPoint];
        configPanel.classList.add('active');
        typeSelect.value = '';
        modeSelect.value = '';
        modeGroup.style.display = 'block';
    });
});

typeSelect.addEventListener('change', () => {
    if (typeSelect.value === 'HIDS') {
        modeGroup.style.display = 'none';
        modeSelect.value = '';
    } else {
        modeGroup.style.display = 'block';
    }
});

document.getElementById('apply-config-btn').addEventListener('click', () => {
    if (!currentPoint) return;
    const chosenType = typeSelect.value;
    const chosenMode = chosenType === 'HIDS' ? null : modeSelect.value;

    if (!chosenType || (chosenType === 'NIDS' && !chosenMode)) {
        hintPanel.className = '';
        hintPanel.textContent = 'Select a sensor type' + (chosenType === 'NIDS' ? ' and deployment mode' : '') + ' before applying.';
        return;
    }

    const correct = correctConfig[currentPoint];
    const typeOk = chosenType === correct.type;
    const modeOk = correct.mode === null ? true : chosenMode === correct.mode;

    const pointEl = document.getElementById('point-' + currentPoint);
    const statusEl = pointEl.querySelector('.pp-status');

    if (typeOk && modeOk) {
        pointEl.classList.add('correct');
        statusEl.textContent = chosenType + (chosenMode ? ' / ' + chosenMode : '');
        pointStates[currentPoint] = true;
        hintPanel.className = 'ok';
        hintPanel.textContent = 'Point ' + currentPoint + ' (' + pointNames[currentPoint] + ') is correctly configured.';
    } else {
        pointEl.classList.remove('correct');
        pointStates[currentPoint] = false;
        hintPanel.className = 'warn';
        if (!typeOk) {
            hintPanel.textContent = hints[currentPoint].wrongType;
        } else {
            hintPanel.textContent = hints[currentPoint].wrongMode;
        }
    }

    updateCoverage();
});

function updateCoverage() {
    const total = Object.keys(pointStates).length;
    const done = Object.values(pointStates).filter(Boolean).length;
    const pct = Math.round((done / total) * 100);
    meterFill.style.width = pct + '%';

    if (done === total) {
        flagSection.classList.add('revealed');
        hintPanel.className = 'ok';
        hintPanel.textContent = 'All five points are correctly configured. Scroll down to view your completed design.';
    } else {
        flagSection.classList.remove('revealed');
    }
}

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    { targetId: 'topology-map', text: 'This is the network you are responsible for securing, from the internet edge down to a critical internal server.' },
    { targetId: 'point-1', text: 'Each numbered point is a place you could put a sensor. Click one to configure it.' },
    { targetId: 'sensor-type-select', text: 'Choose whether this point gets a network based sensor (NIDS) or a host based agent (HIDS).' },
    { targetId: 'sensor-mode-select', text: 'If you chose NIDS, decide whether it sits inline (can block traffic) or passive (can only observe).' },
    { targetId: 'coverage-meter', text: 'This fills up as your choices form a sound, balanced design. It will not move for placements that create more risk than they remove.' },
    { targetId: 'hint-panel', text: 'If a choice creates a problem, this panel explains why, without telling you the right answer.' }
];

let tutorialStepIndex = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    document.body.appendChild(tooltipEl);
}

function removeSpotlightElements() {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    let top = rect.bottom + 14;
    let left = rect.left;
    if (left + 300 > window.innerWidth) left = window.innerWidth - 320;
    if (top + 160 > window.innerHeight) top = rect.top - 160;
    if (left < 10) left = 10;
    if (top < 10) top = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function showTutorialStep(index) {
    const step = tutorialSteps[index];
    const target = document.getElementById(step.targetId);
    if (!target) { advanceTutorial(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => renderTutorialStep(target, index), 300);
    } else {
        renderTutorialStep(target, index);
    }
}

function renderTutorialStep(target, index) {
    positionSpotlight(target);
    const isLast = index === tutorialSteps.length - 1;
    tooltipEl.innerHTML = '<div>' + tutorialSteps[index].text + '</div>' +
        '<div class="tt-buttons">' +
        '<button class="skip-btn" id="tt-skip">Skip Tutorial</button>' +
        '<button id="tt-next">' + (isLast ? 'Finish' : 'Next') + '</button>' +
        '</div>';

    document.getElementById('tt-next').addEventListener('click', advanceTutorial);
    document.getElementById('tt-skip').addEventListener('click', endTutorial);
}

function advanceTutorial() {
    tutorialStepIndex++;
    if (tutorialStepIndex >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        showTutorialStep(tutorialStepIndex);
    }
}

function endTutorial(completed) {
    removeSpotlightElements();
    if (completed) {
        document.getElementById('complete-modal').classList.add('active');
    }
}

function startTutorial() {
    tutorialStepIndex = 0;
    createSpotlightElements();
    showTutorialStep(0);
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('complete-modal').classList.remove('active');
});

window.addEventListener('resize', () => {
    if (spotlightEl && tutorialStepIndex < tutorialSteps.length) {
        const step = tutorialSteps[tutorialStepIndex];
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target);
    }
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
