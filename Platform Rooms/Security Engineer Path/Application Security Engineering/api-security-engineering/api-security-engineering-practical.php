<?php
// api-security-engineering-practical.php
// Standalone static practical: HTML, CSS, vanilla JS only. No backend logic.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>API Gateway Configuration Lab</title>
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

.wrap {
    max-width: 900px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== Header ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    gap: 16px;
}
.header h1 {
    font-size: 1.6rem;
    margin: 0 0 6px 0;
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
    max-width: 560px;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* ===== Description ===== */
.description {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.description strong { color: var(--text-primary); }

/* ===== Route Info ===== */
.route-info {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 24px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.9rem;
    color: var(--accent-primary);
}

/* ===== Status Strip ===== */
.status-strip {
    padding: 14px 20px;
    border-radius: 10px;
    margin-bottom: 24px;
    font-weight: 600;
    font-size: 0.95rem;
    text-align: center;
    border: 1px solid var(--error);
    color: var(--error);
    background: rgba(255,92,92,0.08);
    transition: all 0.25s ease;
}
.status-strip.hardened {
    border-color: var(--success);
    color: var(--success);
    background: rgba(61,255,154,0.08);
}

/* ===== Controls Panel ===== */
.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}
.control-group {
    margin-bottom: 22px;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid transparent;
}
.control-group.invalid {
    border-color: var(--error);
    box-shadow: 0 0 0 1px rgba(255,92,92,0.3);
}
.control-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}
.control-group select {
    width: 100%;
    max-width: 340px;
    padding: 10px 12px;
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.88rem;
}
.toggle-row {
    display: flex;
    align-items: center;
    gap: 12px;
}
.toggle-switch {
    position: relative;
    width: 52px;
    height: 28px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 14px;
    cursor: pointer;
    flex-shrink: 0;
}
.toggle-switch .knob {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--text-muted);
    transition: all 0.2s ease;
}
.toggle-switch.on {
    background: rgba(61,255,154,0.15);
    border-color: var(--success);
}
.toggle-switch.on .knob {
    left: 27px;
    background: var(--success);
}
.hint {
    font-size: 0.82rem;
    color: var(--error);
    margin-top: 8px;
    display: none;
}
.control-group.invalid .hint {
    display: block;
}

/* ===== Validate Button ===== */
.validate-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    border-radius: 8px;
    color: var(--accent-primary);
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.validate-btn:hover {
    box-shadow: var(--glow-accent);
}
.validate-btn.shake {
    animation: shake 0.4s ease;
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-6px); }
    40% { transform: translateX(6px); }
    60% { transform: translateX(-4px); }
    80% { transform: translateX(4px); }
}

/* ===== Feedback ===== */
.feedback {
    margin-top: 16px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    min-height: 20px;
}

/* ===== Flag Panel ===== */
.flag-panel {
    display: none;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 24px;
    margin-top: 10px;
    text-align: center;
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.flag-panel.show { display: block; }
.flag-panel h3 { color: var(--success); margin-top: 0; }
.flag-value {
    font-family: "JetBrains Mono", monospace;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 12px 16px;
    font-size: 1.05rem;
    color: var(--accent-primary);
    display: inline-block;
    margin-top: 10px;
    user-select: all;
}

/* ===== Tutorial ===== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 1000;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 1001;
    box-shadow: var(--glow-accent);
}
.tooltip-card .step-label {
    font-size: 0.72rem;
    color: var(--accent-primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 6px;
    font-weight: 600;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
.tooltip-actions button {
    background: none;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
}
.tooltip-actions .next-btn {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}

/* ===== Completion Modal ===== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    align-items: center;
    justify-content: center;
    z-index: 1002;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin-top: 0; }
.modal-box button {
    margin-top: 16px;
    padding: 10px 24px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>
<div class="wrap">

    <!-- 1. Top header -->
    <div class="header">
        <div>
            <h1>API Gateway Configuration Lab</h1>
            <p class="subtitle">You are hardening a live payment transfer route. Every control you set here has a real financial consequence.</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </div>

    <!-- 2. Description section -->
    <div class="description">
        <p><strong>What this environment represents:</strong> a simplified API gateway configuration console for one route. <strong>Your goal:</strong> set the rate limit, OAuth scope, and schema validation controls to the values that correctly protect this route, then validate your configuration to reveal the flag.</p>
    </div>

    <div class="route-info" id="route-info">
        POST /api/v1/payments/transfer
    </div>

    <div class="status-strip" id="statusStrip">Vulnerable Configuration</div>

    <!-- 3. Main interactive environment -->
    <div class="panel">

        <div class="control-group" id="rate-limit-control">
            <label>Rate Limit</label>
            <select id="rateLimitSelect">
                <option value="unlimited" selected>Unlimited</option>
                <option value="1000">1000 requests per minute</option>
                <option value="100">100 requests per minute</option>
                <option value="10">10 requests per minute</option>
            </select>
            <p class="hint">This setting still allows a known abuse pattern against this endpoint.</p>
        </div>

        <div class="control-group" id="scope-control">
            <label>OAuth Scope Required</label>
            <select id="scopeSelect">
                <option value="wildcard" selected>payments:*</option>
                <option value="read">payments:read</option>
                <option value="transfer">payments:transfer</option>
                <option value="both">payments:read payments:transfer</option>
            </select>
            <p class="hint">This setting still allows a known abuse pattern against this endpoint.</p>
        </div>

        <div class="control-group" id="schema-toggle">
            <label>Schema Validation</label>
            <div class="toggle-row">
                <div class="toggle-switch" id="schemaSwitch"><div class="knob"></div></div>
                <span id="schemaState" style="color: var(--text-secondary); font-size: 0.85rem;">Off</span>
            </div>
            <p class="hint">This setting still allows a known abuse pattern against this endpoint.</p>
        </div>

        <button class="validate-btn" id="validate-btn">Validate Configuration</button>

        <!-- 4. Feedback / status area -->
        <div class="feedback" id="feedback"></div>
    </div>

    <!-- 5. Flag reveal area -->
    <div class="flag-panel" id="flagPanel">
        <h3>Gateway Hardened</h3>
        <p>All three controls are correctly configured. The route is now protected.</p>
        <div class="flag-value" id="flagValue">CBX{gateway_hardened}</div>
    </div>

</div>

<!-- Tutorial overlay elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <div class="step-label" id="stepLabel">Step 1 of 5</div>
    <div id="tooltipText"></div>
    <div class="tooltip-actions">
        <button id="skipBtn">Skip Tutorial</button>
        <button class="next-btn" id="nextBtn">Next</button>
    </div>
</div>

<!-- Completion modal -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
// ===== State =====
const state = { rateLimit: 'unlimited', scope: 'wildcard', schemaOn: false };

const rateLimitSelect = document.getElementById('rateLimitSelect');
const scopeSelect = document.getElementById('scopeSelect');
const schemaSwitch = document.getElementById('schemaSwitch');
const schemaState = document.getElementById('schemaState');
const statusStrip = document.getElementById('statusStrip');
const validateBtn = document.getElementById('validate-btn');
const feedback = document.getElementById('feedback');
const flagPanel = document.getElementById('flagPanel');

const rateLimitGroup = document.getElementById('rate-limit-control');
const scopeGroup = document.getElementById('scope-control');
const schemaGroup = document.getElementById('schema-toggle');

rateLimitSelect.addEventListener('change', () => {
    state.rateLimit = rateLimitSelect.value;
    updateStatus();
});
scopeSelect.addEventListener('change', () => {
    state.scope = scopeSelect.value;
    updateStatus();
});
schemaSwitch.addEventListener('click', () => {
    state.schemaOn = !state.schemaOn;
    schemaSwitch.classList.toggle('on', state.schemaOn);
    schemaState.textContent = state.schemaOn ? 'On' : 'Off';
    updateStatus();
});

function isHardened() {
    return state.rateLimit === '100' && state.scope === 'transfer' && state.schemaOn === true;
}

function updateStatus() {
    if (isHardened()) {
        statusStrip.textContent = 'Gateway Hardened';
        statusStrip.classList.add('hardened');
    } else {
        statusStrip.textContent = 'Vulnerable Configuration';
        statusStrip.classList.remove('hardened');
    }
}

validateBtn.addEventListener('click', () => {
    const rateOk = state.rateLimit === '100';
    const scopeOk = state.scope === 'transfer';
    const schemaOk = state.schemaOn === true;

    rateLimitGroup.classList.toggle('invalid', !rateOk);
    scopeGroup.classList.toggle('invalid', !scopeOk);
    schemaGroup.classList.toggle('invalid', !schemaOk);

    if (rateOk && scopeOk && schemaOk) {
        feedback.textContent = 'All controls correctly configured.';
        flagPanel.classList.add('show');
    } else {
        feedback.textContent = 'One or more controls still leave this route exposed. Review the highlighted settings.';
        flagPanel.classList.remove('show');
        validateBtn.classList.remove('shake');
        void validateBtn.offsetWidth;
        validateBtn.classList.add('shake');
    }
});

// ===== Tutorial system =====
const tutorialSteps = [
    { targetId: 'route-info', text: 'This is the route you are protecting: a payment transfer endpoint. Think of it as the front door for moving customer money. Anything you get wrong here has real financial consequences.' },
    { targetId: 'rate-limit-control', text: 'This sets how many times a single client can call this endpoint per minute. Think of it as a bouncer counting how many times the same person can walk back through the door.' },
    { targetId: 'scope-control', text: 'This decides what OAuth scope a token must carry to use this route. A wildcard scope is like handing out a master key when someone only needed one specific room key.' },
    { targetId: 'schema-toggle', text: 'This turns on strict validation of the request body\'s shape. When it is off, the endpoint will accept fields it was never designed to receive.' },
    { targetId: 'validate-btn', text: 'Once you believe all three controls are set correctly, click here to check your work.' },
];

let currentStep = 0;
let tutorialActive = false;

const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltipCard');
const stepLabel = document.getElementById('stepLabel');
const tooltipText = document.getElementById('tooltipText');
const modalOverlay = document.getElementById('modalOverlay');

function startTutorial() {
    currentStep = 0;
    tutorialActive = true;
    spotlight.style.display = 'block';
    tooltipCard.style.display = 'block';
    showStep(currentStep);
}

function showStep(index) {
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetId);
    if (!el) return;

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const positionAll = () => {
        const r = el.getBoundingClientRect();
        const pad = 8;
        spotlight.style.top = (r.top - pad) + 'px';
        spotlight.style.left = (r.left - pad) + 'px';
        spotlight.style.width = (r.width + pad * 2) + 'px';
        spotlight.style.height = (r.height + pad * 2) + 'px';

        stepLabel.textContent = 'Step ' + (index + 1) + ' of ' + tutorialSteps.length;
        tooltipText.textContent = step.text;

        const tooltipWidth = 300;
        let top = r.bottom + 16;
        let left = r.left;

        if (top + 160 > window.innerHeight) {
            top = r.top - 160;
        }
        if (left + tooltipWidth > window.innerWidth) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (left < 10) left = 10;

        tooltipCard.style.top = top + 'px';
        tooltipCard.style.left = left + 'px';
    };

    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(positionAll, 300);
    } else {
        positionAll();
    }
}

document.getElementById('nextBtn').addEventListener('click', () => {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        modalOverlay.classList.add('show');
    } else {
        showStep(currentStep);
    }
});

document.getElementById('skipBtn').addEventListener('click', () => {
    endTutorial();
});

document.getElementById('startChallengeBtn').addEventListener('click', () => {
    modalOverlay.classList.remove('show');
});

function endTutorial() {
    tutorialActive = false;
    spotlight.style.display = 'none';
    tooltipCard.style.display = 'none';
}

document.getElementById('tutorialBtn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (tutorialActive) showStep(currentStep);
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>
</body>
</html>
