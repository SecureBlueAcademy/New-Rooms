<?php
// password-attack-fundamentals-practical.php
// Standalone static practical: Attack Triage Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attack Triage Console</title>
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

.mono { font-family: 'JetBrains Mono', monospace; }

.wrapper {
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px 20px 80px 20px;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-default);
    margin-bottom: 24px;
}

.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.7rem;
    color: var(--accent-primary);
}

.header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 560px;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION ===== */
.description {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 28px;
}
.description h2 {
    margin: 0 0 8px 0;
    font-size: 1.05rem;
    color: var(--text-primary);
}
.description p {
    margin: 6px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}

/* ===== MAIN ENVIRONMENT ===== */
.console-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.artifact-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.artifact-card.solved {
    border-color: var(--success);
    box-shadow: 0 0 16px rgba(61,255,154,0.15);
}

.artifact-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    font-weight: 600;
}

.artifact-desc {
    font-size: 0.88rem;
    color: var(--text-primary);
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    line-height: 1.5;
}

.classify-controls {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.classify-btn {
    flex: 1 1 auto;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 8px 10px;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.classify-btn:hover {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}

.classify-btn.correct {
    background: rgba(61,255,154,0.12);
    border-color: var(--success);
    color: var(--success);
    cursor: default;
}

.classify-btn.correct:hover {
    box-shadow: none;
}

.hint-text {
    font-size: 0.78rem;
    color: var(--warning);
    min-height: 18px;
}

.result-panel {
    display: none;
    background: rgba(61,255,154,0.08);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 10px 12px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
    color: var(--success);
}

.result-panel.visible {
    display: block;
}

/* ===== FEEDBACK / STATUS ===== */
.status-bar {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 24px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.status-progress {
    font-family: 'JetBrains Mono', monospace;
    color: var(--accent-primary);
    font-weight: 600;
}

/* ===== FLAG REVEAL ===== */
.flag-panel {
    background: var(--bg-surface);
    border: 1px dashed var(--border-default);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
    color: var(--text-muted);
    transition: all 0.3s ease;
}

.flag-panel.unlocked {
    border: 1px solid var(--accent-primary);
    color: var(--text-primary);
    box-shadow: var(--glow-accent);
}

.flag-panel h3 {
    margin: 0 0 10px 0;
    font-size: 1rem;
    color: inherit;
}

.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--success);
    letter-spacing: 0.02em;
    user-select: all;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
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
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 0.85rem;
    color: var(--text-primary);
    box-shadow: var(--glow-accent);
    z-index: 9999;
}

.tooltip-card p {
    margin: 0 0 12px 0;
    color: var(--text-secondary);
}

.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}

.tooltip-btn {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

.tooltip-btn.primary {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    font-weight: 600;
}

/* ===== MODAL ===== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.modal-overlay.visible {
    display: flex;
}

.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 340px;
    text-align: center;
    box-shadow: var(--glow-accent);
}

.modal-box h3 {
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}

.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 18px 0;
}

.modal-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
</style>
</head>
<body>

<div class="wrapper">

    <!-- 1. HEADER -->
    <div class="header">
        <div>
            <h1>Attack Triage Console</h1>
            <p>You are reviewing three artifacts recovered during an incident investigation. Classify each one into the correct password attack category.</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION -->
    <div class="description">
        <h2>Mission Briefing</h2>
        <p>This console represents an incident responder's workstation. Each card below is an artifact pulled from a real investigation: a login page, a stolen hash file, and a leaked credential pair.</p>
        <p>Read each artifact carefully, then choose whether it enables an Online Attack, an Offline Attack, or Credential Reuse. A correct classification simulates the resulting attack. Classify all three correctly to reveal the flag.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="console-grid">

        <!-- Artifact 1 -->
        <div class="artifact-card" id="artifact-card-1">
            <div class="artifact-label">Artifact 01</div>
            <div class="artifact-desc">Corporate webmail login page discovered during recon. No account lockout or rate limiting was observed after repeated failed attempts.</div>
            <div class="classify-controls" id="classify-controls-1">
                <button class="classify-btn" data-artifact="1" data-answer="online">Online Attack</button>
                <button class="classify-btn" data-artifact="1" data-answer="offline">Offline Attack</button>
                <button class="classify-btn" data-artifact="1" data-answer="reuse">Credential Reuse</button>
            </div>
            <div class="hint-text" id="hint-1"></div>
            <div class="result-panel" id="result-panel-1">Attack executed. 50 login attempts sent. 3 succeeded before the account was locked.</div>
        </div>

        <!-- Artifact 2 -->
        <div class="artifact-card" id="artifact-card-2">
            <div class="artifact-label">Artifact 02</div>
            <div class="artifact-desc">File named shadow.bak exfiltrated from a compromised Linux server. Contains SHA-512 password hashes for all local accounts.</div>
            <div class="classify-controls" id="classify-controls-2">
                <button class="classify-btn" data-artifact="2" data-answer="online">Online Attack</button>
                <button class="classify-btn" data-artifact="2" data-answer="offline">Offline Attack</button>
                <button class="classify-btn" data-artifact="2" data-answer="reuse">Credential Reuse</button>
            </div>
            <div class="hint-text" id="hint-2"></div>
            <div class="result-panel" id="result-panel-2">Attack executed. Hashes cracked offline in 4 minutes using a GPU wordlist attack.</div>
        </div>

        <!-- Artifact 3 -->
        <div class="artifact-card" id="artifact-card-3">
            <div class="artifact-label">Artifact 03</div>
            <div class="artifact-desc">Username and password pair found in a public breach dump belonging to an unrelated forum site.</div>
            <div class="classify-controls" id="classify-controls-3">
                <button class="classify-btn" data-artifact="3" data-answer="online">Online Attack</button>
                <button class="classify-btn" data-artifact="3" data-answer="offline">Offline Attack</button>
                <button class="classify-btn" data-artifact="3" data-answer="reuse">Credential Reuse</button>
            </div>
            <div class="hint-text" id="hint-3"></div>
            <div class="result-panel" id="result-panel-3">Attack executed. Credential tested against 12 other services. Matched on 2.</div>
        </div>

    </div>

    <!-- 4. FEEDBACK / STATUS -->
    <div class="status-bar" id="statusBar">
        <span>Classify each artifact to simulate its matching attack.</span>
        <span class="status-progress" id="statusProgress">0 / 3 classified</span>
    </div>

    <!-- 5. FLAG REVEAL -->
    <div class="flag-panel" id="flagPanel">
        <h3>Flag Locked</h3>
        <p style="margin:0; font-size:0.85rem;">Classify all three artifacts correctly to unlock the flag.</p>
    </div>

</div>

<!-- Tutorial modal -->
<div class="modal-overlay" id="completeModal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button class="modal-btn" id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
const correctAnswers = { 1: 'online', 2: 'offline', 3: 'reuse' };
const solved = { 1: false, 2: false, 3: false };

const hintMessages = {
    online: {
        1: null,
        2: 'This artifact was not obtained through direct interaction with a live service. Reconsider.',
        3: 'This artifact was not obtained through direct interaction with a live service. Reconsider.'
    },
    offline: {
        1: 'This artifact came from a live service, not a stolen data file. Reconsider.',
        2: null,
        3: 'This artifact came from a live service, not a stolen data file. Reconsider.'
    },
    reuse: {
        1: 'This artifact was not a credential found in an unrelated breach. Reconsider.',
        2: 'This artifact was not a credential found in an unrelated breach. Reconsider.',
        3: null
    }
};

document.querySelectorAll('.classify-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const artifact = btn.dataset.artifact;
        const answer = btn.dataset.answer;
        const hintEl = document.getElementById('hint-' + artifact);

        if (solved[artifact]) return;

        if (answer === correctAnswers[artifact]) {
            solved[artifact] = true;
            hintEl.textContent = '';
            document.getElementById('result-panel-' + artifact).classList.add('visible');
            document.getElementById('artifact-card-' + artifact).classList.add('solved');
            document.querySelectorAll('#classify-controls-' + artifact + ' .classify-btn').forEach(b => {
                b.disabled = true;
                if (b === btn) b.classList.add('correct');
            });
            updateStatus();
        } else {
            hintEl.textContent = hintMessages[answer][artifact];
        }
    });
});

function updateStatus() {
    const count = Object.values(solved).filter(Boolean).length;
    document.getElementById('statusProgress').textContent = count + ' / 3 classified';

    if (count === 3) {
        document.getElementById('statusBar').querySelector('span').textContent = 'All artifacts classified. Investigation complete.';
        unlockFlag();
    }
}

function unlockFlag() {
    const panel = document.getElementById('flagPanel');
    panel.classList.add('unlocked');
    panel.innerHTML = '<h3>Flag Recovered</h3><div class="flag-value">CBX{triage_complete}</div>';
}

/* ================= SPOTLIGHT TUTORIAL ================= */
const tutorialSteps = [
    { targetId: 'artifact-card-1', text: 'This is a recovered artifact, like an evidence bag in an incident response case. Read it carefully before deciding what kind of attack it enables.' },
    { targetId: 'classify-controls-1', text: 'Choose the attack category this artifact belongs to. Get it right and the console will simulate the attack for you.' },
    { targetId: 'result-panel-1', text: 'Once classified correctly, the console shows you what the attack looks like in practice.' },
    { targetId: 'flagPanel', text: 'Classify all three artifacts correctly to unlock the flag.' }
];

let currentStep = 0;
let spotlightEl, tooltipEl;

function createTutorialElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    document.body.appendChild(tooltipEl);
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    let tooltipTop = rect.bottom + 14;
    let tooltipLeft = rect.left;

    if (tooltipTop + 140 > window.innerHeight) {
        tooltipTop = rect.top - 154;
    }
    if (tooltipLeft + 280 > window.innerWidth) {
        tooltipLeft = window.innerWidth - 300;
    }
    if (tooltipLeft < 10) tooltipLeft = 10;

    tooltipEl.style.top = tooltipTop + 'px';
    tooltipEl.style.left = tooltipLeft + 'px';
}

function renderTooltipContent() {
    const step = tutorialSteps[currentStep];
    const isLast = currentStep === tutorialSteps.length - 1;
    tooltipEl.innerHTML = `
        <p>${step.text}</p>
        <div class="tooltip-actions">
            <button class="tooltip-btn" id="skipTutorialBtn">Skip Tutorial</button>
            <button class="tooltip-btn primary" id="nextStepBtn">${isLast ? 'Finish' : 'Next'}</button>
        </div>
    `;
    document.getElementById('skipTutorialBtn').addEventListener('click', endTutorial);
    document.getElementById('nextStepBtn').addEventListener('click', nextStep);
}

function showStep(index) {
    const step = tutorialSteps[index];
    const target = document.getElementById(step.targetId);
    if (!target) { nextStep(); return; }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        positionSpotlight(target);
        renderTooltipContent();
    }, 300);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    showStep(currentStep);
}

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) createTutorialElements();
    spotlightEl.style.display = 'block';
    tooltipEl.style.display = 'block';
    showStep(currentStep);
}

function endTutorial(completed) {
    if (spotlightEl) spotlightEl.style.display = 'none';
    if (tooltipEl) tooltipEl.style.display = 'none';
    if (completed) {
        document.getElementById('completeModal').classList.add('visible');
    }
}

document.getElementById('tutorialBtn').addEventListener('click', startTutorial);
document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('visible');
});

window.addEventListener('resize', () => {
    if (spotlightEl && spotlightEl.style.display === 'block') {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
