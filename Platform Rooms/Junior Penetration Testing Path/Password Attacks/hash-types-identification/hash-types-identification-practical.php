<?php
// ============================================================
// hash-types-identification-practical.php
// Standalone static practical: Breach Triage
// No backend logic. No sessions. No database.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Breach Triage | CYBRIXEN Lab</title>
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

.container {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
}

/* ===== HEADER ===== */
.header {
    text-align: center;
    padding: 30px 20px 20px 20px;
    position: relative;
}

.header h1 {
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--accent-primary);
    text-shadow: var(--glow-accent);
}

.header .subtitle {
    margin-top: 8px;
    color: var(--text-secondary);
    font-size: 1rem;
}

.tutorial-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 500;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    background: rgba(106,227,255,0.1);
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION ===== */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 26px;
    margin-bottom: 24px;
}
.briefing h2 {
    font-size: 1.1rem;
    color: var(--accent-primary);
    margin-bottom: 10px;
}
.briefing p {
    color: var(--text-secondary);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 8px;
}

/* ===== MAIN ENVIRONMENT ===== */
#hash-queue-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
}

.queue-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.queue-header h3 {
    font-size: 1rem;
    color: var(--text-primary);
}

#progress-tracker {
    font-size: 0.85rem;
    color: var(--text-muted);
    background: var(--bg-surface);
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid var(--border-default);
}

#hash-display {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 18px;
    margin-bottom: 20px;
    word-break: break-all;
    font-size: 0.95rem;
    color: var(--accent-secondary);
    text-align: center;
}

.step-label {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 10px;
}

#algo-select, #risk-select {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 18px;
}

.choice-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: "Inter", sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}
.choice-btn:hover:not(:disabled) {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}
.choice-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
.choice-btn.correct {
    background: rgba(61,255,154,0.12);
    border-color: var(--success);
    color: var(--success);
}
.choice-btn.incorrect {
    background: rgba(255,92,92,0.12);
    border-color: var(--error);
    color: var(--error);
}

.risk-btn.high {
    border-color: rgba(255,92,92,0.4);
}
.risk-btn.low {
    border-color: rgba(61,255,154,0.4);
}

/* ===== FEEDBACK ===== */
#feedback-panel {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px 18px;
    min-height: 60px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.5;
}
#feedback-panel.success-state {
    border-color: var(--success);
    color: var(--success);
}
#feedback-panel.error-state {
    border-color: var(--error);
    color: var(--error);
}

/* ===== REPORT / FLAG PANEL ===== */
#report-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 26px;
    margin-top: 24px;
    text-align: center;
    opacity: 0.4;
    pointer-events: none;
    transition: opacity 0.4s ease;
}
#report-panel.unlocked {
    opacity: 1;
    pointer-events: auto;
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
#report-panel h3 {
    color: var(--text-primary);
    margin-bottom: 10px;
    font-size: 1.05rem;
}
#report-panel .lock-msg {
    color: var(--text-muted);
    font-size: 0.9rem;
}
.flag-box {
    display: none;
    margin-top: 14px;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 16px;
    font-size: 1.1rem;
    color: var(--success);
    letter-spacing: 0.03em;
}
#report-panel.unlocked .flag-box { display: block; }
#report-panel.unlocked .lock-msg { display: none; }

.triage-table {
    width: 100%;
    margin-top: 16px;
    border-collapse: collapse;
    font-size: 0.85rem;
}
.triage-table th, .triage-table td {
    padding: 8px 10px;
    text-align: left;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-secondary);
}
.triage-table th {
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.72rem;
    letter-spacing: 0.05em;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
#tutorial-overlay {
    position: fixed;
    inset: 0;
    z-index: 900;
    pointer-events: none;
    display: none;
}
.spotlight-box {
    position: absolute;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
    pointer-events: none;
}
.tooltip-card {
    position: absolute;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    font-size: 0.88rem;
    color: var(--text-primary);
    box-shadow: 0 0 20px rgba(106,227,255,0.2);
    pointer-events: auto;
    z-index: 901;
}
.tooltip-card p { margin-bottom: 12px; line-height: 1.5; color: var(--text-secondary); }
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    background: none;
    border: none;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 600;
}
.skip-btn { color: var(--text-muted); }
.next-btn { color: var(--accent-primary); }

/* ===== MODAL ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 950;
}
.modal-overlay.active { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 { color: var(--accent-primary); margin-bottom: 12px; font-size: 1.15rem; }
.modal-card p { color: var(--text-secondary); margin-bottom: 20px; font-size: 0.9rem; }
.modal-card button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-family: "Inter", sans-serif;
}

@media (max-width: 600px) {
    .header h1 { font-size: 1.4rem; }
    .tutorial-btn { top: 10px; right: 10px; padding: 8px 12px; font-size: 0.75rem; }
}
</style>
</head>
<body>

<button class="tutorial-btn" id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>

<div class="container">

    <div class="header">
        <h1>Breach Triage</h1>
        <p class="subtitle">Security Analyst Console, Incident Response Desk</p>
    </div>

    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>Five password hashes were pulled from different compromised systems during last night's breach sweep. None of them are labeled with an algorithm name.</p>
        <p>For each hash, identify the algorithm that produced it, then classify it as High Risk or Low Risk based on how easily it could be cracked. Triage all five correctly to unlock the final breach report.</p>
    </div>

    <div id="hash-queue-panel">
        <div class="queue-header">
            <h3>Hash Queue</h3>
            <div id="progress-tracker">0 of 5 triaged</div>
        </div>

        <div id="hash-display" class="mono">Loading hash...</div>

        <div id="step-algo">
            <div class="step-label">Step 1: Identify the algorithm</div>
            <div id="algo-select"></div>
        </div>

        <div id="step-risk" style="display:none;">
            <div class="step-label">Step 2: Classify the risk</div>
            <div id="risk-select"></div>
        </div>

        <div id="feedback-panel">Select an algorithm to begin analyzing this hash.</div>
    </div>

    <div id="report-panel">
        <h3>Breach Report</h3>
        <p class="lock-msg">Locked. Triage all five hashes correctly to generate the final report.</p>
        <table class="triage-table" id="report-table" style="display:none;">
            <thead>
                <tr><th>#</th><th>Algorithm</th><th>Risk Level</th></tr>
            </thead>
            <tbody id="report-table-body"></tbody>
        </table>
        <div class="flag-box mono" id="flag-box"></div>
    </div>

</div>

<div id="tutorial-overlay">
    <div class="spotlight-box" id="spotlight"></div>
    <div class="tooltip-card" id="tooltip-card">
        <p id="tooltip-text"></p>
        <div class="tooltip-actions">
            <button class="skip-btn" onclick="skipTutorial()">Skip Tutorial</button>
            <button class="next-btn" onclick="nextTutorialStep()">Next →</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Work through each hash carefully and trust the patterns you learned.</p>
        <button onclick="closeModal()">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA: five unlabeled breach hashes
// ============================================================
const hashes = [
    {
        value: "5f4dcc3b5aa765d61d8327deb882cf99",
        algo: "MD5",
        risk: "High",
        clue: "32 hexadecimal characters is the classic MD5 length. MD5 is fast and has known collisions, making it a high risk choice for password storage."
    },
    {
        value: "5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8",
        algo: "SHA1",
        risk: "High",
        clue: "40 hexadecimal characters points to SHA1. SHA1 is considered cryptographically broken due to demonstrated collisions."
    },
    {
        value: "8846F7EAEE8FB117AD06BDD830B7586C",
        algo: "NTLM",
        risk: "High",
        clue: "32 uppercase hexadecimal characters pulled from a Windows domain controller identifies this as NTLM. It is fast enough to be cracked at scale."
    },
    {
        value: "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d",
        algo: "SHA256",
        risk: "High",
        clue: "64 hexadecimal characters identifies SHA256. It is not broken, but it is fast and unsalted here, which still makes it crackable at scale."
    },
    {
        value: "$2b$12$KIXQ4Yh6vG5x9zL8mF3n1O7wYtR2sVeUdCpNjBhGkLxTfMz1qWnKe",
        algo: "bcrypt",
        risk: "Low",
        clue: "The $2b$ prefix and embedded salt identify bcrypt. It is deliberately slow and salted, making large scale cracking impractical."
    }
];

const algoOptions = ["MD5", "SHA1", "SHA256", "NTLM", "bcrypt"];
const riskOptions = ["High", "Low"];

let currentIndex = 0;
let algoConfirmed = false;
const results = [];

const hashDisplay = document.getElementById('hash-display');
const algoSelect = document.getElementById('algo-select');
const riskSelect = document.getElementById('risk-select');
const stepRisk = document.getElementById('step-risk');
const feedbackPanel = document.getElementById('feedback-panel');
const progressTracker = document.getElementById('progress-tracker');
const reportPanel = document.getElementById('report-panel');
const reportTable = document.getElementById('report-table');
const reportTableBody = document.getElementById('report-table-body');
const flagBox = document.getElementById('flag-box');

function renderHash() {
    if (currentIndex >= hashes.length) {
        finishTriage();
        return;
    }
    algoConfirmed = false;
    const current = hashes[currentIndex];
    hashDisplay.textContent = current.value;
    progressTracker.textContent = `${currentIndex} of ${hashes.length} triaged`;

    algoSelect.innerHTML = "";
    algoOptions.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'choice-btn';
        btn.textContent = opt;
        btn.onclick = () => handleAlgoChoice(opt, btn);
        algoSelect.appendChild(btn);
    });

    stepRisk.style.display = "none";
    riskSelect.innerHTML = "";
    feedbackPanel.className = "";
    feedbackPanel.textContent = "Select an algorithm to begin analyzing this hash.";
}

function handleAlgoChoice(choice, btnEl) {
    if (algoConfirmed) return;
    const current = hashes[currentIndex];
    const allBtns = algoSelect.querySelectorAll('.choice-btn');

    if (choice === current.algo) {
        algoConfirmed = true;
        allBtns.forEach(b => b.disabled = true);
        btnEl.classList.add('correct');
        feedbackPanel.className = "success-state";
        feedbackPanel.textContent = `Correct. ${current.clue}`;
        renderRiskStep();
    } else {
        btnEl.classList.add('incorrect');
        feedbackPanel.className = "error-state";
        feedbackPanel.textContent = "Not quite. Check the character length and format again before choosing.";
        setTimeout(() => btnEl.classList.remove('incorrect'), 700);
    }
}

function renderRiskStep() {
    stepRisk.style.display = "block";
    riskSelect.innerHTML = "";
    riskOptions.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'choice-btn risk-btn ' + opt.toLowerCase();
        btn.textContent = opt + ' Risk';
        btn.onclick = () => handleRiskChoice(opt, btn);
        riskSelect.appendChild(btn);
    });
}

function handleRiskChoice(choice, btnEl) {
    const current = hashes[currentIndex];
    const allBtns = riskSelect.querySelectorAll('.choice-btn');

    if (choice === current.risk) {
        allBtns.forEach(b => b.disabled = true);
        btnEl.classList.add('correct');
        feedbackPanel.className = "success-state";
        feedbackPanel.textContent = `Correctly classified as ${current.risk} Risk. Moving to the next hash.`;
        results.push({ algo: current.algo, risk: current.risk });
        currentIndex++;
        setTimeout(renderHash, 1100);
    } else {
        btnEl.classList.add('incorrect');
        feedbackPanel.className = "error-state";
        feedbackPanel.textContent = "That risk level does not match this algorithm's real world cracking speed. Think about how fast it can be computed.";
        setTimeout(() => btnEl.classList.remove('incorrect'), 700);
    }
}

function finishTriage() {
    progressTracker.textContent = `${hashes.length} of ${hashes.length} triaged`;
    hashDisplay.textContent = "All hashes triaged.";
    document.getElementById('step-algo').style.display = "none";
    stepRisk.style.display = "none";
    feedbackPanel.className = "success-state";
    feedbackPanel.textContent = "Triage complete. Breach report unlocked below.";

    reportTableBody.innerHTML = "";
    results.forEach((r, i) => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${i + 1}</td><td>${r.algo}</td><td>${r.risk}</td>`;
        reportTableBody.appendChild(row);
    });
    reportTable.style.display = "table";
    flagBox.textContent = "CBX{breach_contained}";
    reportPanel.classList.add('unlocked');
}

renderHash();

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    { targetId: "hash-queue-panel", text: "This is your hash queue. Think of it like an inbox of intercepted credentials waiting to be reviewed." },
    { targetId: "hash-display", text: "Each hash appears here one at a time. Look closely at its length and character set before deciding." },
    { targetId: "step-algo", text: "Choose which algorithm produced this hash based on its format." },
    { targetId: "step-risk", text: "Once identified, decide if this hash is High Risk (fast, crackable) or Low Risk (properly protected)." },
    { targetId: "feedback-panel", text: "After each decision, this panel explains the clue you should have spotted and why the risk level matters." },
    { targetId: "progress-tracker", text: "Tracks how many hashes you have triaged so far." },
    { targetId: "report-panel", text: "Locked until all five hashes are triaged correctly. This is where your final breach report appears." }
];

let tutorialIndex = 0;
const overlay = document.getElementById('tutorial-overlay');
const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltip-card');
const tooltipText = document.getElementById('tooltip-text');

function startTutorial() {
    tutorialIndex = 0;
    overlay.style.display = "block";
    showTutorialStep();
}

function showTutorialStep() {
    if (tutorialIndex >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    const step = tutorialSteps[tutorialIndex];
    let el = document.getElementById(step.targetId);
    if (step.targetId === "step-risk" && el.style.display === "none") {
        el = document.getElementById('hash-queue-panel');
    }

    el.scrollIntoView({ behavior: "smooth", block: "center" });
    setTimeout(() => positionSpotlight(el, step.text), 300);
}

function positionSpotlight(el, text) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + "px";
    spotlight.style.left = (rect.left - pad) + "px";
    spotlight.style.width = (rect.width + pad * 2) + "px";
    spotlight.style.height = (rect.height + pad * 2) + "px";

    tooltipText.textContent = text;

    let top = rect.bottom + 16;
    let left = rect.left;
    if (top + 140 > window.innerHeight) {
        top = rect.top - 160;
    }
    if (left + 300 > window.innerWidth) {
        left = window.innerWidth - 320;
    }
    if (left < 10) left = 10;

    tooltipCard.style.top = top + "px";
    tooltipCard.style.left = left + "px";
}

function nextTutorialStep() {
    tutorialIndex++;
    showTutorialStep();
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    overlay.style.display = "none";
    document.getElementById('complete-modal').classList.add('active');
}

function closeModal() {
    document.getElementById('complete-modal').classList.remove('active');
}

window.addEventListener('resize', () => {
    if (overlay.style.display === "block" && tutorialIndex < tutorialSteps.length) {
        const step = tutorialSteps[tutorialIndex];
        let el = document.getElementById(step.targetId);
        if (step.targetId === "step-risk" && el.style.display === "none") {
            el = document.getElementById('hash-queue-panel');
        }
        positionSpotlight(el, step.text);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
