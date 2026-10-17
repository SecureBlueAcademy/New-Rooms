<?php
// ============================================================
// security-automation-fundamentals-practical.php
// Standalone practical: The Automation Triage Desk
// HTML / CSS / vanilla JS only. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Automation Triage Desk</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
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
    min-height: 100vh;
    padding: 24px;
}

.wrapper {
    max-width: 1000px;
    margin: 0 auto;
    position: relative;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    gap: 16px;
}

.header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
}

.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-top: 6px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    background: rgba(106,227,255,0.08);
}

/* ===== DESCRIPTION ===== */
.description-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
    line-height: 1.6;
}
.description-box strong { color: var(--text-primary); }

/* ===== MAIN ENVIRONMENT ===== */
.desk-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 20px;
}

@media (max-width: 800px) {
    .desk-layout { grid-template-columns: 1fr; }
}

.queue-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px;
}

.queue-panel h3 {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 12px;
}

.task-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}
.task-card:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.task-card.selected {
    border-color: var(--accent-secondary);
    box-shadow: 0 0 12px rgba(139,123,255,0.4);
}
.task-card.done {
    opacity: 0.35;
    pointer-events: none;
}

.bins-panel {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.bin {
    background: var(--bg-secondary);
    border: 1.5px dashed var(--border-default);
    border-radius: 10px;
    padding: 18px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.bin:hover {
    border-color: var(--accent-primary);
    background: rgba(106,227,255,0.04);
}
.bin h4 {
    font-size: 1rem;
    margin-bottom: 4px;
    color: var(--text-primary);
}
.bin p {
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* ===== FEEDBACK AREA ===== */
.feedback-area {
    margin-top: 20px;
    padding: 14px 18px;
    border-radius: 8px;
    font-size: 0.9rem;
    display: none;
}
.feedback-area.show { display: block; }
.feedback-area.correct {
    background: rgba(61,255,154,0.08);
    border: 1px solid var(--success);
    color: var(--success);
}
.feedback-area.incorrect {
    background: rgba(255,92,92,0.08);
    border: 1px solid var(--error);
    color: var(--error);
}

.score-panel {
    margin-top: 20px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 18px;
}
.score-panel h3 {
    font-size: 0.85rem;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 10px;
    letter-spacing: 0.05em;
}
.score-bar-track {
    background: var(--bg-surface);
    border-radius: 6px;
    height: 10px;
    overflow: hidden;
}
.score-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
    width: 0%;
    transition: width 0.4s ease;
}
.score-text {
    margin-top: 8px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* ===== FLAG REVEAL ===== */
.flag-area {
    margin-top: 24px;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    display: none;
}
.flag-area.show { display: block; }
.flag-area h3 {
    color: var(--success);
    margin-bottom: 10px;
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    color: var(--accent-primary);
    user-select: all;
}

/* ===== TUTORIAL SPOTLIGHT ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
    pointer-events: none;
    z-index: 999;
}

.tooltip-card {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    max-width: 280px;
    z-index: 1000;
    font-size: 0.85rem;
    color: var(--text-primary);
    box-shadow: var(--glow-accent);
}
.tooltip-card .tt-title {
    font-weight: 600;
    color: var(--accent-primary);
    margin-bottom: 6px;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.tooltip-card .tt-actions {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    gap: 8px;
}
.tooltip-card button {
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
.tt-next {
    background: var(--accent-primary);
    color: #06131a;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default) !important;
}

/* ===== MODAL ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1100;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 {
    color: var(--accent-primary);
    margin-bottom: 12px;
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 18px;
}
.modal-box button {
    background: var(--accent-primary);
    color: #06131a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="wrapper">
    <div class="header">
        <div>
            <h1>Automation Triage Desk</h1>
            <p class="subtitle">You are a SOC automation architect. Sort each incoming task into the correct automation tier.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </div>

    <div class="description-box">
        <p><strong>Mission briefing:</strong> This board represents a live queue of security operations tasks. Some are safe to fully automate, some need a human to approve before they run, and some should never be automated at all. Review each task, decide its correct tier, and place it in the matching bin. Sort all nine tasks correctly to reveal the flag.</p>
    </div>

    <div class="desk-layout">
        <div class="queue-panel" id="task-queue-panel">
            <h3>Task Queue</h3>
            <div id="queue-container"></div>
        </div>

        <div class="bins-panel">
            <div class="bin" id="bin-automate-full" data-bin="full">
                <h4>Automate Fully</h4>
                <p>High volume, low judgement, safe to reverse</p>
            </div>
            <div class="bin" id="bin-automate-approval" data-bin="approval">
                <h4>Automate with Approval</h4>
                <p>Automation acts, but a human confirms first</p>
            </div>
            <div class="bin" id="bin-manual" data-bin="manual">
                <h4>Keep Manual</h4>
                <p>Needs full human judgement</p>
            </div>

            <div class="feedback-area" id="feedback-area"></div>

            <div class="score-panel" id="score-panel">
                <h3>Maturity Score</h3>
                <div class="score-bar-track">
                    <div class="score-bar-fill" id="score-bar-fill"></div>
                </div>
                <div class="score-text" id="score-text">0 / 9 correct</div>
            </div>
        </div>
    </div>

    <div class="flag-area" id="flag-area">
        <h3>Triage Complete</h3>
        <p style="color: var(--text-secondary); margin-bottom: 12px;">All nine tasks correctly categorized. Flag revealed below.</p>
        <div class="flag-value" id="flag-value">CBX{automation_calibrated}</div>
    </div>
</div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
const tasks = [
    { id: 1, text: "Enrich a suspicious IP address with a threat intel lookup", bin: "full", reason: "High volume, no judgement required, zero risk if wrong." },
    { id: 2, text: "Deduplicate and correlate repeated low severity alerts from the same source", bin: "full", reason: "Repetitive, rule based, easily reversible." },
    { id: 3, text: "Auto-close alerts matching a verified, confirmed false positive pattern", bin: "full", reason: "The pattern is confirmed and stable, so there is no ambiguity." },
    { id: 4, text: "Isolate an endpoint reported as compromised by a VIP executive", bin: "approval", reason: "High business impact if wrong, needs human context first." },
    { id: 5, text: "Disable a user account flagged for anomalous access to sensitive files", bin: "approval", reason: "Moderate blast radius, some judgement on context needed." },
    { id: 6, text: "Block a vendor's entire IP range after suspicious activity is detected", bin: "approval", reason: "Could disrupt a legitimate business relationship." },
    { id: 7, text: "Respond to a request from law enforcement about an ongoing investigation", bin: "manual", reason: "Legal and procedural context that no automation can judge." },
    { id: 8, text: "Decide whether to notify customers of a data breach", bin: "manual", reason: "High stakes, legal and regulatory judgement required." },
    { id: 9, text: "Investigate an alert involving the CEO's executive assistant's account", bin: "manual", reason: "Requires nuanced human judgement and discretion." },
];

let selectedTaskId = null;
let correctCount = 0;
const solved = new Set();

function renderQueue() {
    const container = document.getElementById('queue-container');
    container.innerHTML = '';
    tasks.forEach(task => {
        const card = document.createElement('div');
        card.className = 'task-card';
        card.id = 'task-card-' + task.id;
        card.textContent = task.text;
        if (solved.has(task.id)) {
            card.classList.add('done');
        } else {
            card.onclick = () => selectTask(task.id);
        }
        container.appendChild(card);
    });
}

function selectTask(id) {
    document.querySelectorAll('.task-card').forEach(c => c.classList.remove('selected'));
    selectedTaskId = id;
    document.getElementById('task-card-' + id).classList.add('selected');
}

function handleBinClick(binName) {
    if (selectedTaskId === null) {
        showFeedback('Select a task card first, then choose a bin.', false);
        return;
    }
    const task = tasks.find(t => t.id === selectedTaskId);
    if (solved.has(task.id)) return;

    if (task.bin === binName) {
        solved.add(task.id);
        correctCount++;
        showFeedback('Correct. ' + task.reason, true);
        updateScore();
        selectedTaskId = null;
        renderQueue();
        if (correctCount === tasks.length) {
            revealFlag();
        }
    } else {
        showFeedback('Not quite. Consider the volume, judgement required, and impact if this action goes wrong.', false);
    }
}

function showFeedback(msg, correct) {
    const el = document.getElementById('feedback-area');
    el.textContent = msg;
    el.className = 'feedback-area show ' + (correct ? 'correct' : 'incorrect');
}

function updateScore() {
    document.getElementById('score-bar-fill').style.width = (correctCount / tasks.length * 100) + '%';
    document.getElementById('score-text').textContent = correctCount + ' / ' + tasks.length + ' correct';
}

function revealFlag() {
    document.getElementById('flag-area').classList.add('show');
}

document.querySelectorAll('.bin').forEach(bin => {
    bin.addEventListener('click', () => handleBinClick(bin.dataset.bin));
});

renderQueue();

// ===== TUTORIAL SYSTEM =====
const tutorialSteps = [
    { targetId: 'task-queue-panel', text: 'This is your task queue. Each card is a real SOC action waiting for a decision.' },
    { targetId: 'bin-automate-full', text: 'Click here if a task is high volume, repetitive, and carries no real risk if automated.' },
    { targetId: 'bin-automate-approval', text: 'Click here if automation should happen, but only after a human confirms it first.' },
    { targetId: 'bin-manual', text: 'Click here if a task needs full human judgement and should never be automated.' },
    { targetId: 'score-panel', text: 'Your maturity score updates as you go. Aim for all nine correct.' },
    { targetId: 'view-tutorial-btn', text: 'You can replay this tutorial anytime from here.' },
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function startTutorial() {
    currentStep = 0;
    buildOverlayElements();
    showStep(currentStep);
}

function buildOverlayElements() {
    removeOverlayElements();
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    document.body.appendChild(tooltipEl);
}

function removeOverlayElements() {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
}

function showStep(index) {
    const step = tutorialSteps[index];
    const target = document.getElementById(step.targetId);
    if (!target) { nextStep(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionOverlay(target, step), 300);
    } else {
        positionOverlay(target, step);
    }
}

function positionOverlay(target, step) {
    const rect = target.getBoundingClientRect();
    const pad = 8;

    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    tooltipEl.innerHTML =
        '<div class="tt-title">Step ' + (currentStep + 1) + ' of ' + tutorialSteps.length + '</div>' +
        '<div>' + step.text + '</div>' +
        '<div class="tt-actions">' +
        '<button class="tt-skip" onclick="endTutorial()">Skip Tutorial</button>' +
        '<button class="tt-next" onclick="nextStep()">' + (currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
        '</div>';

    let top = rect.bottom + 16;
    let left = rect.left;
    if (top + 140 > window.innerHeight) top = rect.top - 150;
    if (left + 280 > window.innerWidth) left = window.innerWidth - 300;
    if (left < 10) left = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
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
    removeOverlayElements();
    if (completed) {
        document.getElementById('tutorial-complete-modal').classList.add('show');
    }
}

function closeTutorialModal() {
    document.getElementById('tutorial-complete-modal').classList.remove('show');
}

window.addEventListener('resize', () => {
    if (spotlightEl && tooltipEl) {
        showStep(currentStep);
    }
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
