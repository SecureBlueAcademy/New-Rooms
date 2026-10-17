<?php
// ============================================================
// mfa-engineering-practical.php
// Practical: Conditional Access Policy Builder
// Standalone static HTML/CSS/JS application, no backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Conditional Access Policy Builder | Northgate Systems</title>
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

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 980px;
    margin: 0 auto;
    position: relative;
}

/* ===== HEADER ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.page-header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
}

.page-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-top: 6px;
    max-width: 640px;
}

#tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    background: rgba(106,227,255,0.08);
}

/* ===== DESCRIPTION SECTION ===== */
.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
}
.description-section h2 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: var(--text-primary);
}
.description-section p {
    color: var(--text-secondary);
    font-size: 0.92rem;
    margin-bottom: 8px;
}
.description-section p:last-child { margin-bottom: 0; }

/* ===== MAIN INTERACTIVE ENVIRONMENT ===== */
.scenarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.scenario-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
}
.scenario-card.correct {
    border-color: var(--success);
    box-shadow: 0 0 0 1px var(--success);
}
.scenario-card.incorrect {
    border-color: var(--error);
    box-shadow: 0 0 0 1px var(--error);
}

.scenario-card .card-label {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    color: var(--accent-secondary);
    letter-spacing: 0.05em;
    margin-bottom: 6px;
}

.scenario-card p.scenario-text {
    font-size: 0.88rem;
    color: var(--text-primary);
    margin-bottom: 14px;
    min-height: 66px;
}

.scenario-card select {
    width: 100%;
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    cursor: pointer;
}
.scenario-card select:focus {
    outline: none;
    border-color: var(--accent-primary);
}

.card-feedback {
    margin-top: 10px;
    font-size: 0.8rem;
    font-family: 'JetBrains Mono', monospace;
    min-height: 18px;
}
.card-feedback.correct { color: var(--success); }
.card-feedback.incorrect { color: var(--error); }

#deploy-btn {
    display: block;
    margin: 0 auto 24px auto;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 14px 34px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
}
#deploy-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-2px);
}

/* ===== FEEDBACK / STATUS AREA ===== */
#status-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 24px;
    text-align: center;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
#status-panel.status-success {
    border-color: var(--success);
    color: var(--success);
}

/* ===== FLAG REVEAL AREA ===== */
#flag-panel {
    background: var(--bg-secondary);
    border: 1px dashed var(--border-default);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    color: var(--text-muted);
    font-size: 0.9rem;
}
#flag-panel.unlocked {
    border: 1px solid var(--success);
    color: var(--text-primary);
}
#flag-panel .flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    color: var(--success);
    margin-top: 10px;
    letter-spacing: 0.02em;
}

/* ===== TUTORIAL SPOTLIGHT ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}

.tooltip-card {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    font-size: 0.85rem;
    color: var(--text-primary);
    margin-bottom: 12px;
}
.tooltip-buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-buttons button {
    flex: 1;
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.tooltip-buttons button.primary {
    background: var(--accent-primary);
    color: #04121a;
    border-color: var(--accent-primary);
    font-weight: 600;
}

/* ===== MODAL ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-box h3 {
    margin-bottom: 12px;
    color: var(--text-primary);
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 20px;
}
.modal-box button {
    background: var(--accent-primary);
    color: #04121a;
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .page-header { flex-direction: column; }
    #tutorial-btn { align-self: flex-start; }
}
</style>
</head>
<body>

<div class="container">
    <div class="page-header">
        <div>
            <h1>Conditional Access Policy Builder</h1>
            <p class="subtitle">Northgate Systems identity console. Review each login attempt and assign the correct policy response.</p>
        </div>
        <button id="tutorial-btn">View Tutorial</button>
    </div>

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>You are the identity administrator on call. Overnight, six login attempts reached the identity provider, each carrying different device, location, and risk signals.</p>
        <p>Your task is to classify each one with the correct conditional access policy: Allow, Require MFA, Require Phishing-Resistant MFA, or Block Access. Read every detail carefully, since the correct answer depends on the specific risk signals present.</p>
    </div>

    <div class="scenarios-grid" id="scenarios-grid">
        <!-- Scenario 1 -->
        <div class="scenario-card" id="scenario-card-1" data-correct="allow">
            <div class="card-label">SCENARIO 01</div>
            <p class="scenario-text">Corporate managed laptop, connected from the on-site office network. Standard user account. Risk score: low.</p>
            <select id="policy-select-1">
                <option value="">Select a policy...</option>
                <option value="allow">Allow</option>
                <option value="mfa">Require MFA</option>
                <option value="phishing_resistant">Require Phishing-Resistant MFA</option>
                <option value="block">Block Access</option>
            </select>
            <div class="card-feedback" id="feedback-1"></div>
        </div>

        <!-- Scenario 2 -->
        <div class="scenario-card" id="scenario-card-2" data-correct="block">
            <div class="card-label">SCENARIO 02</div>
            <p class="scenario-text">Unrecognized device, new browser fingerprint. Login originates from a country the user has never logged in from before, nine minutes after a successful login from their home country.</p>
            <select id="policy-select-2">
                <option value="">Select a policy...</option>
                <option value="allow">Allow</option>
                <option value="mfa">Require MFA</option>
                <option value="phishing_resistant">Require Phishing-Resistant MFA</option>
                <option value="block">Block Access</option>
            </select>
            <div class="card-feedback" id="feedback-2"></div>
        </div>

        <!-- Scenario 3 -->
        <div class="scenario-card" id="scenario-card-3" data-correct="block">
            <div class="card-label">SCENARIO 03</div>
            <p class="scenario-text">Login attempt using a legacy mail protocol (IMAP4 basic auth) that cannot present a modern MFA challenge at all.</p>
            <select id="policy-select-3">
                <option value="">Select a policy...</option>
                <option value="allow">Allow</option>
                <option value="mfa">Require MFA</option>
                <option value="phishing_resistant">Require Phishing-Resistant MFA</option>
                <option value="block">Block Access</option>
            </select>
            <div class="card-feedback" id="feedback-3"></div>
        </div>

        <!-- Scenario 4 -->
        <div class="scenario-card" id="scenario-card-4" data-correct="phishing_resistant">
            <div class="card-label">SCENARIO 04</div>
            <p class="scenario-text">Global administrator account. Unregistered device. Connected over public wifi at a coffee shop.</p>
            <select id="policy-select-4">
                <option value="">Select a policy...</option>
                <option value="allow">Allow</option>
                <option value="mfa">Require MFA</option>
                <option value="phishing_resistant">Require Phishing-Resistant MFA</option>
                <option value="block">Block Access</option>
            </select>
            <div class="card-feedback" id="feedback-4"></div>
        </div>

        <!-- Scenario 5 -->
        <div class="scenario-card" id="scenario-card-5" data-correct="mfa">
            <div class="card-label">SCENARIO 05</div>
            <p class="scenario-text">Known device, known location. Five failed password attempts occurred in two minutes immediately before the successful login.</p>
            <select id="policy-select-5">
                <option value="">Select a policy...</option>
                <option value="allow">Allow</option>
                <option value="mfa">Require MFA</option>
                <option value="phishing_resistant">Require Phishing-Resistant MFA</option>
                <option value="block">Block Access</option>
            </select>
            <div class="card-feedback" id="feedback-5"></div>
        </div>

        <!-- Scenario 6 -->
        <div class="scenario-card" id="scenario-card-6" data-correct="mfa">
            <div class="card-label">SCENARIO 06</div>
            <p class="scenario-text">Personal unmanaged device, recognized location. Accessing a low sensitivity internal directory application.</p>
            <select id="policy-select-6">
                <option value="">Select a policy...</option>
                <option value="allow">Allow</option>
                <option value="mfa">Require MFA</option>
                <option value="phishing_resistant">Require Phishing-Resistant MFA</option>
                <option value="block">Block Access</option>
            </select>
            <div class="card-feedback" id="feedback-6"></div>
        </div>
    </div>

    <button id="deploy-btn">Deploy Policies</button>

    <div id="status-panel">Set a policy for every scenario, then click Deploy Policies to check your work.</div>

    <div id="flag-panel">
        <p>Flag locked. Deploy all six policies correctly to unlock it.</p>
    </div>
</div>

<script>
const CORRECT_MESSAGES = {
    allow: "Correct. Low risk signals across the board mean no additional friction is needed.",
    mfa: "Correct. Elevated risk signals justify a standard MFA challenge.",
    phishing_resistant: "Correct. A privileged account on an unregistered device over public wifi calls for a phishing resistant method.",
    block: "Correct. This pattern is too risky to allow through with any challenge."
};

const INCORRECT_HINTS = {
    1: "Consider how many risk signals are actually present here.",
    2: "Think about impossible travel between two logins minutes apart.",
    3: "Consider whether this protocol can even support an MFA challenge.",
    4: "Consider the sensitivity of the account combined with the network and device.",
    5: "Consider what the failed attempts suggest about risk, without treating it as extreme.",
    6: "Consider that sensitivity here is low, but the device is still unmanaged."
};

function checkPolicies() {
    let allCorrect = true;

    for (let i = 1; i <= 6; i++) {
        const card = document.getElementById('scenario-card-' + i);
        const select = document.getElementById('policy-select-' + i);
        const feedback = document.getElementById('feedback-' + i);
        const correctValue = card.getAttribute('data-correct');
        const chosen = select.value;

        card.classList.remove('correct', 'incorrect');
        feedback.classList.remove('correct', 'incorrect');

        if (chosen === correctValue) {
            card.classList.add('correct');
            feedback.classList.add('correct');
            feedback.textContent = CORRECT_MESSAGES[correctValue];
        } else {
            allCorrect = false;
            card.classList.add('incorrect');
            feedback.classList.add('incorrect');
            feedback.textContent = chosen === "" ? "No policy selected yet." : ("Not quite. " + INCORRECT_HINTS[i]);
        }
    }

    const statusPanel = document.getElementById('status-panel');
    const flagPanel = document.getElementById('flag-panel');

    if (allCorrect) {
        statusPanel.classList.add('status-success');
        statusPanel.textContent = "All policies deployed correctly. Northgate Systems identity perimeter is now enforced.";
        flagPanel.classList.add('unlocked');
        flagPanel.innerHTML = '<p>Policy deployment complete. Flag revealed:</p><div class="flag-value">CBX{access_policy_enforced}</div>';
    } else {
        statusPanel.classList.remove('status-success');
        statusPanel.textContent = "Some policies are incorrect. Review the highlighted cards and try again.";
        flagPanel.classList.remove('unlocked');
        flagPanel.innerHTML = '<p>Flag locked. Deploy all six policies correctly to unlock it.</p>';
    }
}

document.getElementById('deploy-btn').addEventListener('click', checkPolicies);

/* ===================================================
   TUTORIAL SPOTLIGHT SYSTEM
   =================================================== */
const tutorialSteps = [
    { targetId: 'tutorial-btn', text: 'Replay this tutorial anytime by clicking here.' },
    { targetId: 'scenario-card-1', text: 'Each card is a real login attempt, like an entry in a security log. Read the device, location, and role details before deciding.' },
    { targetId: 'policy-select-1', text: 'Choose the policy response for this login: Allow, Require MFA, Require Phishing-Resistant MFA, or Block Access.' },
    { targetId: 'deploy-btn', text: 'Once you have set a policy for every scenario, click here to deploy and check your work.' },
    { targetId: 'status-panel', text: 'Correct policies turn green. Incorrect ones turn red with a hint so you can fix them.' },
    { targetId: 'flag-panel', text: 'Once every policy is correctly deployed, your flag appears here.' }
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
    document.body.appendChild(tooltipEl);
}

function removeSpotlightElements() {
    if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
    if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const padding = 8;

    spotlightEl.style.top = (rect.top - padding) + 'px';
    spotlightEl.style.left = (rect.left - padding) + 'px';
    spotlightEl.style.width = (rect.width + padding * 2) + 'px';
    spotlightEl.style.height = (rect.height + padding * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 16;
    let left = rect.left;

    if (left + tooltipWidth > window.innerWidth) {
        left = window.innerWidth - tooltipWidth - 16;
    }
    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left < 10) left = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function renderStep() {
    const step = tutorialSteps[currentStep];
    const target = document.getElementById(step.targetId);
    if (!target) { nextStep(); return; }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });

    setTimeout(() => {
        positionSpotlight(target);

        const isLast = currentStep === tutorialSteps.length - 1;
        tooltipEl.innerHTML = `
            <p>${step.text}</p>
            <div class="tooltip-buttons">
                <button id="skip-tutorial-btn">Skip Tutorial</button>
                <button class="primary" id="next-step-btn">${isLast ? 'Finish' : 'Next'}</button>
            </div>
        `;

        document.getElementById('skip-tutorial-btn').addEventListener('click', endTutorial);
        document.getElementById('next-step-btn').addEventListener('click', nextStep);
    }, 300);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        renderStep();
    }
}

function endTutorial(completed) {
    removeSpotlightElements();
    if (completed) {
        showCompletionModal();
    }
}

function showCompletionModal() {
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
        <div class="modal-box">
            <h3>Tutorial Complete</h3>
            <p>You're ready to start the challenge. Review each scenario and deploy the correct policies.</p>
            <button id="start-challenge-btn">Start Challenge</button>
        </div>
    `;
    document.body.appendChild(overlay);
    document.getElementById('start-challenge-btn').addEventListener('click', () => {
        overlay.remove();
    });
}

function startTutorial() {
    currentStep = 0;
    createSpotlightElements();
    renderStep();
}

document.getElementById('tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (spotlightEl && tutorialSteps[currentStep]) {
        const target = document.getElementById(tutorialSteps[currentStep].targetId);
        if (target) positionSpotlight(target);
    }
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
