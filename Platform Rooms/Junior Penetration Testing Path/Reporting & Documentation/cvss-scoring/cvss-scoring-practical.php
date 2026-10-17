<?php
// cvss-scoring-practical.php
// Standalone practical: Vulnerability Triage Console
// Static HTML/CSS/vanilla JS only. No backend logic.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vulnerability Triage Console</title>
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

* { box-sizing: border-box; }

body {
    margin: 0;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.mono { font-family: "JetBrains Mono", monospace; }

/* ===== Header ===== */
.page-header {
    padding: 28px 32px 20px 32px;
    border-bottom: 1px solid var(--border-default);
    position: relative;
    background: var(--bg-secondary);
}
.page-header h1 {
    margin: 0 0 6px 0;
    font-size: 1.7rem;
    font-weight: 700;
}
.page-header p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 720px;
}

#tutorialBtn {
    position: absolute;
    top: 24px;
    right: 32px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 8px 16px;
    border-radius: 8px;
    font-family: "Inter", sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
#tutorialBtn:hover {
    background: rgba(106,227,255,0.1);
    box-shadow: var(--glow-accent);
}

/* ===== Description ===== */
.mission-briefing {
    margin: 20px 32px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
}
.mission-briefing h3 {
    margin: 0 0 8px 0;
    font-size: 1rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}

/* ===== Main Layout ===== */
.console {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 20px;
    margin: 20px 32px;
}
@media (max-width: 900px) {
    .console { grid-template-columns: 1fr; }
}

.queue-panel, .scoring-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.queue-panel h3, .scoring-panel h3 {
    margin-top: 0;
    font-size: 0.95rem;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.vuln-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.vuln-card:hover {
    border-color: var(--accent-primary);
}
.vuln-card.active {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.vuln-card.correct {
    border-color: var(--success);
    background: rgba(61,255,154,0.06);
}
.vuln-card-title {
    font-weight: 600;
    font-size: 0.92rem;
    margin-bottom: 4px;
}
.badge {
    display: inline-block;
    font-size: 0.7rem;
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 600;
    letter-spacing: 0.03em;
}
.badge.unscored { background: rgba(255,211,106,0.15); color: var(--warning); }
.badge.correct { background: rgba(61,255,154,0.15); color: var(--success); }
.badge.incorrect { background: rgba(255,92,92,0.15); color: var(--error); }

.vuln-description {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 16px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}

.metric-group {
    margin-bottom: 14px;
}
.metric-group label {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.metric-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.metric-btn {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 0.82rem;
    cursor: pointer;
    font-family: "Inter", sans-serif;
    transition: all 0.15s ease;
}
.metric-btn:hover {
    border-color: var(--accent-secondary);
}
.metric-btn.selected {
    background: rgba(139,123,255,0.15);
    border-color: var(--accent-secondary);
    color: var(--accent-secondary);
    font-weight: 600;
}

.score-display {
    display: flex;
    align-items: center;
    gap: 18px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px 18px;
    margin: 16px 0;
}
.score-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 2rem;
    font-weight: 700;
    color: var(--accent-primary);
}
.score-rating {
    font-weight: 700;
    font-size: 1rem;
    padding: 5px 14px;
    border-radius: 20px;
}
.rating-none, .rating-low { background: rgba(61,255,154,0.15); color: var(--success); }
.rating-medium { background: rgba(255,211,106,0.15); color: var(--warning); }
.rating-high, .rating-critical { background: rgba(255,92,92,0.15); color: var(--error); }

.confirm-btn {
    background: var(--accent-secondary);
    color: #0b0f1a;
    border: none;
    padding: 12px 22px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.confirm-btn:hover {
    filter: brightness(1.1);
    box-shadow: 0 0 18px rgba(139,123,255,0.4);
}
.confirm-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ===== Feedback ===== */
.status-area {
    margin: 0 32px 20px 32px;
    min-height: 24px;
    font-size: 0.9rem;
    font-weight: 600;
}
.status-area.status-correct { color: var(--success); }
.status-area.status-incorrect { color: var(--error); }

/* ===== Flag Reveal ===== */
.flag-panel {
    margin: 20px 32px 40px 32px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 24px 28px;
    display: none;
}
.flag-panel.visible { display: block; }
.flag-panel h3 {
    margin: 0 0 10px 0;
    color: var(--success);
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    background: rgba(0,0,0,0.3);
    padding: 10px 16px;
    border-radius: 8px;
    display: inline-block;
    color: var(--accent-primary);
    letter-spacing: 0.03em;
}

/* ===== Tutorial Spotlight ===== */
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
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
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
    align-items: center;
}
.tooltip-actions button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.8rem;
    cursor: pointer;
}
.tooltip-skip {
    background: none !important;
    color: var(--text-muted) !important;
    font-weight: 500 !important;
    padding: 0 !important;
}

.tut-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.tut-modal-overlay.visible { display: flex; }
.tut-modal {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
}
.tut-modal h3 { margin-top: 0; color: var(--accent-primary); }
.tut-modal button {
    margin-top: 16px;
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-header">
    <h1>Vulnerability Triage Console</h1>
    <p>Score five unscored vulnerability reports using the CVSS v3.1 Base metric group before the patch review meeting.</p>
    <button id="tutorialBtn">View Tutorial</button>
</div>

<div class="mission-briefing">
    <h3>Mission Briefing</h3>
    <p>Five vulnerability reports have arrived from different sources and none of them have a severity rating yet. Read each description, select the Base metric values that match what is described, and confirm your score. All five must be scored correctly to complete triage.</p>
</div>

<div class="console">
    <div class="queue-panel" id="queuePanel">
        <h3>Vulnerability Queue</h3>
        <div id="cardList"></div>
    </div>

    <div class="scoring-panel" id="scoringPanel">
        <h3 id="activeTitle">Select a vulnerability</h3>
        <div class="vuln-description" id="activeDescription">Choose a vulnerability from the queue on the left to begin scoring.</div>

        <div id="metricSelectors" style="display:none;">
            <div class="metric-group">
                <label>Attack Vector (AV)</label>
                <div class="metric-options" data-metric="AV">
                    <button class="metric-btn" data-value="N">Network</button>
                    <button class="metric-btn" data-value="A">Adjacent</button>
                    <button class="metric-btn" data-value="L">Local</button>
                    <button class="metric-btn" data-value="P">Physical</button>
                </div>
            </div>
            <div class="metric-group">
                <label>Attack Complexity (AC)</label>
                <div class="metric-options" data-metric="AC">
                    <button class="metric-btn" data-value="L">Low</button>
                    <button class="metric-btn" data-value="H">High</button>
                </div>
            </div>
            <div class="metric-group">
                <label>Privileges Required (PR)</label>
                <div class="metric-options" data-metric="PR">
                    <button class="metric-btn" data-value="N">None</button>
                    <button class="metric-btn" data-value="L">Low</button>
                    <button class="metric-btn" data-value="H">High</button>
                </div>
            </div>
            <div class="metric-group">
                <label>User Interaction (UI)</label>
                <div class="metric-options" data-metric="UI">
                    <button class="metric-btn" data-value="N">None</button>
                    <button class="metric-btn" data-value="R">Required</button>
                </div>
            </div>
            <div class="metric-group">
                <label>Scope (S)</label>
                <div class="metric-options" data-metric="S">
                    <button class="metric-btn" data-value="U">Unchanged</button>
                    <button class="metric-btn" data-value="C">Changed</button>
                </div>
            </div>
            <div class="metric-group">
                <label>Confidentiality Impact (C)</label>
                <div class="metric-options" data-metric="C">
                    <button class="metric-btn" data-value="N">None</button>
                    <button class="metric-btn" data-value="L">Low</button>
                    <button class="metric-btn" data-value="H">High</button>
                </div>
            </div>
            <div class="metric-group">
                <label>Integrity Impact (I)</label>
                <div class="metric-options" data-metric="I">
                    <button class="metric-btn" data-value="N">None</button>
                    <button class="metric-btn" data-value="L">Low</button>
                    <button class="metric-btn" data-value="H">High</button>
                </div>
            </div>
            <div class="metric-group">
                <label>Availability Impact (A)</label>
                <div class="metric-options" data-metric="A">
                    <button class="metric-btn" data-value="N">None</button>
                    <button class="metric-btn" data-value="L">Low</button>
                    <button class="metric-btn" data-value="H">High</button>
                </div>
            </div>

            <div class="score-display">
                <div class="score-value" id="scoreValue">--</div>
                <div class="score-rating" id="scoreRating">Incomplete</div>
            </div>

            <button class="confirm-btn" id="confirmBtn" disabled>Confirm Score</button>
        </div>
    </div>
</div>

<div class="status-area" id="statusArea"></div>

<div class="flag-panel" id="flagPanel">
    <h3>Triage Complete</h3>
    <p>All five vulnerabilities have been scored correctly. Your flag is below.</p>
    <div class="flag-value">CBX{severity_triaged}</div>
</div>

<div class="tut-modal-overlay" id="tutModalOverlay">
    <div class="tut-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <p id="tooltipText"></p>
    <div class="tooltip-actions">
        <button class="tooltip-skip" id="skipTutBtn">Skip Tutorial</button>
        <button id="nextTutBtn">Next</button>
    </div>
</div>

<script>
// ============================================================
// VULNERABILITY DATA
// ============================================================
const vulnerabilities = [
    {
        id: 1,
        title: "Unpatched Order Portal",
        description: "An attacker with no account and no prior access can send a single crafted request over the internet to the order portal and immediately run arbitrary commands on the server, gaining full read, write, and takeover capability.",
        correct: { AV:"N", AC:"L", PR:"N", UI:"N", S:"U", C:"H", I:"H", A:"H" }
    },
    {
        id: 2,
        title: "Local Admin Escalation",
        description: "An employee who already has a low level account on a shared workstation can run a small script, with no further clicks needed, to gain full administrator control over that machine, reading, changing, and disabling anything on it.",
        correct: { AV:"L", AC:"L", PR:"L", UI:"N", S:"U", C:"H", I:"H", A:"H" }
    },
    {
        id: 3,
        title: "Comment Box Script Injection",
        description: "A visitor can post a comment containing a hidden script. When another logged in user later views that comment, the script quietly runs in that victim's browser and can read some of their session data, but cannot affect the server or take the site offline.",
        correct: { AV:"N", AC:"L", PR:"N", UI:"R", S:"C", C:"L", I:"L", A:"N" }
    },
    {
        id: 4,
        title: "Guest Wifi Config Peek",
        description: "Someone physically connected to the same office guest wifi network, without any account, can view a single low sensitivity configuration file that broadcasts briefly at unpredictable intervals, requiring precise timing to capture. Nothing else on the network is exposed.",
        correct: { AV:"A", AC:"H", PR:"N", UI:"N", S:"U", C:"L", I:"N", A:"N" }
    },
    {
        id: 5,
        title: "Backup Job Overload",
        description: "An attacker on the internet, without any account, can repeatedly trigger a resource heavy backup job with a single request, eventually making the service unresponsive for all users, though no data is exposed or altered.",
        correct: { AV:"N", AC:"L", PR:"N", UI:"N", S:"U", C:"N", I:"N", A:"H" }
    }
];

let activeVulnId = null;
let selections = {};
let scoredCorrect = {};

// ============================================================
// CVSS v3.1 BASE SCORE CALCULATION
// ============================================================
const WEIGHTS = {
    AV: { N: 0.85, A: 0.62, L: 0.55, P: 0.2 },
    AC: { L: 0.77, H: 0.44 },
    PR_U: { N: 0.85, L: 0.62, H: 0.27 },
    PR_C: { N: 0.85, L: 0.68, H: 0.5 },
    UI: { N: 0.85, R: 0.62 },
    CIA: { N: 0, L: 0.22, H: 0.56 }
};

function roundUp(input) {
    const intInput = Math.round(input * 100000);
    if (intInput % 10000 === 0) {
        return intInput / 100000;
    }
    return (Math.floor(intInput / 10000) + 1) / 10;
}

function calculateScore(m) {
    if (!m.AV || !m.AC || !m.PR || !m.UI || !m.S || !m.C || !m.I || !m.A) {
        return null;
    }
    const iss = 1 - ((1 - WEIGHTS.CIA[m.C]) * (1 - WEIGHTS.CIA[m.I]) * (1 - WEIGHTS.CIA[m.A]));
    let impact;
    if (m.S === "U") {
        impact = 6.42 * iss;
    } else {
        impact = 7.52 * (iss - 0.029) - 3.25 * Math.pow(iss - 0.02, 15);
    }
    if (impact <= 0) return { score: 0, rating: "None" };

    const prWeights = m.S === "U" ? WEIGHTS.PR_U : WEIGHTS.PR_C;
    const exploitability = 8.22 * WEIGHTS.AV[m.AV] * WEIGHTS.AC[m.AC] * prWeights[m.PR] * WEIGHTS.UI[m.UI];

    let base;
    if (m.S === "U") {
        base = roundUp(Math.min(impact + exploitability, 10));
    } else {
        base = roundUp(Math.min(1.08 * (impact + exploitability), 10));
    }

    let rating;
    if (base === 0) rating = "None";
    else if (base < 4.0) rating = "Low";
    else if (base < 7.0) rating = "Medium";
    else if (base < 9.0) rating = "High";
    else rating = "Critical";

    return { score: base, rating: rating };
}

// ============================================================
// RENDERING
// ============================================================
function renderQueue() {
    const list = document.getElementById("cardList");
    list.innerHTML = "";
    vulnerabilities.forEach(v => {
        const card = document.createElement("div");
        card.className = "vuln-card" + (v.id === activeVulnId ? " active" : "") + (scoredCorrect[v.id] ? " correct" : "");
        card.id = "card-" + v.id;
        const status = scoredCorrect[v.id] ? "correct" : "unscored";
        const label = scoredCorrect[v.id] ? "Scored" : "Unscored";
        card.innerHTML = `<div class="vuln-card-title">${v.title}</div><span class="badge ${status}">${label}</span>`;
        card.addEventListener("click", () => selectVuln(v.id));
        list.appendChild(card);
    });
}

function selectVuln(id) {
    activeVulnId = id;
    selections[id] = selections[id] || {};
    const v = vulnerabilities.find(x => x.id === id);
    document.getElementById("activeTitle").textContent = v.title;
    document.getElementById("activeDescription").textContent = v.description;
    document.getElementById("metricSelectors").style.display = "block";
    renderQueue();
    renderMetricButtons();
    updateScoreDisplay();
    document.getElementById("statusArea").textContent = "";
    document.getElementById("statusArea").className = "status-area";
}

function renderMetricButtons() {
    document.querySelectorAll(".metric-options").forEach(group => {
        const metric = group.getAttribute("data-metric");
        const current = selections[activeVulnId] ? selections[activeVulnId][metric] : null;
        group.querySelectorAll(".metric-btn").forEach(btn => {
            btn.classList.toggle("selected", btn.getAttribute("data-value") === current);
        });
    });
}

function updateScoreDisplay() {
    const m = selections[activeVulnId] || {};
    const result = calculateScore(m);
    const scoreEl = document.getElementById("scoreValue");
    const ratingEl = document.getElementById("scoreRating");
    const confirmBtn = document.getElementById("confirmBtn");

    if (!result) {
        scoreEl.textContent = "--";
        ratingEl.textContent = "Incomplete";
        ratingEl.className = "score-rating";
        confirmBtn.disabled = true;
        return;
    }

    scoreEl.textContent = result.score.toFixed(1);
    ratingEl.textContent = result.rating;
    ratingEl.className = "score-rating rating-" + result.rating.toLowerCase();
    confirmBtn.disabled = false;
}

document.querySelectorAll(".metric-options").forEach(group => {
    const metric = group.getAttribute("data-metric");
    group.querySelectorAll(".metric-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            if (activeVulnId === null) return;
            selections[activeVulnId] = selections[activeVulnId] || {};
            selections[activeVulnId][metric] = btn.getAttribute("data-value");
            renderMetricButtons();
            updateScoreDisplay();
        });
    });
});

document.getElementById("confirmBtn").addEventListener("click", () => {
    if (activeVulnId === null) return;
    const v = vulnerabilities.find(x => x.id === activeVulnId);
    const m = selections[activeVulnId];
    const isCorrect = Object.keys(v.correct).every(k => m[k] === v.correct[k]);
    const statusArea = document.getElementById("statusArea");

    if (isCorrect) {
        scoredCorrect[activeVulnId] = true;
        statusArea.textContent = "Correct. This vulnerability has been triaged.";
        statusArea.className = "status-area status-correct";
        renderQueue();
        checkCompletion();
    } else {
        statusArea.textContent = "Not quite. Re-read the description and adjust your metric selections.";
        statusArea.className = "status-area status-incorrect";
    }
});

function checkCompletion() {
    const allDone = vulnerabilities.every(v => scoredCorrect[v.id]);
    if (allDone) {
        document.getElementById("flagPanel").classList.add("visible");
    }
}

renderQueue();

// ============================================================
// TUTORIAL SYSTEM (SPOTLIGHT BASED)
// ============================================================
const tutorialSteps = [
    { targetId: "queuePanel", text: "This is your queue of unscored vulnerability reports, just like triaging tickets in a real vulnerability management tool. Click a card to load it." },
    { targetId: "activeDescription", text: "Read the report carefully. It describes real behavior, not CVSS letters. Your job is to translate the description into metric values." },
    { targetId: "scoringPanel", text: "Attack Vector answers how close an attacker needs to be. Network is the most exposed, Physical the least. Work through each metric group the same way." },
    { targetId: "scoringPanel", text: "The Confidentiality, Integrity, and Availability selectors answer what the attacker can actually do: read data, change data, or take the system down." },
    { targetId: "scoringPanel", text: "Your selections calculate a real CVSS Base Score live, exactly like the official CVSS calculator." },
    { targetId: "confirmBtn", text: "Lock in your answer once you are confident. A correct severity band turns the card green in the queue." },
    { targetId: "flagPanel", text: "Once all five vulnerabilities are scored correctly, your triage report unlocks here with the flag." }
];
let tutStep = 0;
let tutActive = false;

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const spotlight = document.getElementById("spotlight");
    const pad = 8;
    spotlight.style.display = "block";
    spotlight.style.top = (rect.top - pad) + "px";
    spotlight.style.left = (rect.left - pad) + "px";
    spotlight.style.width = (rect.width + pad * 2) + "px";
    spotlight.style.height = (rect.height + pad * 2) + "px";

    const tooltip = document.getElementById("tooltipCard");
    tooltip.style.display = "block";
    let top = rect.bottom + 16;
    let left = rect.left;
    if (top + 140 > window.innerHeight) {
        top = rect.top - 160;
    }
    if (left + 300 > window.innerWidth) {
        left = window.innerWidth - 320;
    }
    if (left < 10) left = 10;
    tooltip.style.top = top + "px";
    tooltip.style.left = left + "px";
}

function showTutorialStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    tutStep = index;
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetId);
    if (!el) { showTutorialStep(index + 1); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    document.getElementById("tooltipText").textContent = step.text;

    if (!inView) {
        el.scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => positionSpotlight(el), 300);
    } else {
        positionSpotlight(el);
    }
}

function startTutorial() {
    tutActive = true;
    document.getElementById("tutModalOverlay").classList.remove("visible");
    showTutorialStep(0);
}

function endTutorial() {
    tutActive = false;
    document.getElementById("spotlight").style.display = "none";
    document.getElementById("tooltipCard").style.display = "none";
}

document.getElementById("nextTutBtn").addEventListener("click", () => showTutorialStep(tutStep + 1));
document.getElementById("skipTutBtn").addEventListener("click", endTutorial);
document.getElementById("startChallengeBtn").addEventListener("click", startTutorial);

document.getElementById("tutorialBtn").addEventListener("click", () => {
    document.getElementById("tutModalOverlay").classList.add("visible");
});

window.addEventListener("resize", () => {
    if (tutActive) {
        const step = tutorialSteps[tutStep];
        const el = document.getElementById(step.targetId);
        if (el) positionSpotlight(el);
    }
});

// Auto-start tutorial on first load
window.addEventListener("load", () => {
    document.getElementById("tutModalOverlay").classList.add("visible");
});
</script>
</body>
</html>
