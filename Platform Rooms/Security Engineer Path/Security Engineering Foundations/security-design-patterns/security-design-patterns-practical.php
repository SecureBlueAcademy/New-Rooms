<?php
// security-design-patterns-practical.php
// Standalone static practical: HTML, CSS, and vanilla JS only. No backend logic.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Architecture Doctor</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
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

code, .mono { font-family: "JetBrains Mono", monospace; }

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 32px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    flex-wrap: wrap;
    gap: 12px;
}

.page-header h1 {
    margin: 0 0 4px 0;
    font-size: 1.6rem;
}

.page-header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    white-space: nowrap;
}

.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

.container {
    max-width: 960px;
    margin: 0 auto;
    padding: 28px 24px 60px 24px;
}

.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 28px;
}

.description-section h2 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--accent-primary);
}

.description-section p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

.env-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}

#progress-tracker {
    display: inline-block;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 20px;
    padding: 8px 18px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 18px;
}

#progress-tracker strong {
    color: var(--accent-primary);
}

#architecture-diagram {
    position: relative;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    height: 340px;
    overflow: hidden;
}

.diagram-label {
    position: absolute;
    color: var(--text-muted);
    font-size: 0.75rem;
    font-family: "JetBrains Mono", monospace;
}

.marker {
    position: absolute;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--bg-surface);
    border: 2px solid var(--error);
    color: var(--error);
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.15s ease, border-color 0.2s ease, color 0.2s ease;
    z-index: 2;
}

.marker:hover {
    transform: scale(1.08);
}

.marker.active {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

.marker.solved {
    border-color: var(--success);
    color: var(--success);
}

.marker.shake {
    animation: shake 0.4s ease;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}

.detail-panel {
    margin-top: 20px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
    display: none;
}

.detail-panel.visible {
    display: block;
}

.detail-panel h3 {
    margin-top: 0;
    font-size: 1rem;
    color: var(--text-primary);
}

.detail-panel .weakness-text {
    color: var(--text-secondary);
    font-size: 0.92rem;
    margin-bottom: 16px;
}

.detail-controls {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}

#pattern-dropdown {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 0.9rem;
    font-family: "Inter", sans-serif;
    min-width: 220px;
}

#diagnose-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 700;
    cursor: pointer;
    font-size: 0.9rem;
}

#diagnose-btn:hover {
    box-shadow: var(--glow-accent);
}

.feedback-area {
    margin-top: 14px;
    font-size: 0.9rem;
    min-height: 20px;
}

.feedback-area.correct { color: var(--success); }
.feedback-area.incorrect { color: var(--error); }

.flag-section {
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    display: none;
}

.flag-section.visible {
    display: block;
}

.flag-section h2 {
    color: var(--success);
    margin-top: 0;
}

.flag-value {
    display: inline-block;
    margin-top: 10px;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 12px 24px;
    border-radius: 8px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.05rem;
    letter-spacing: 0.02em;
}

/* Tutorial spotlight system */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}

.tutorial-tooltip {
    position: fixed;
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    font-size: 0.88rem;
    color: var(--text-primary);
    z-index: 9999;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
}

.tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}

.tutorial-tooltip button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 6px;
    padding: 7px 14px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.82rem;
}

.tutorial-tooltip .skip-btn {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default);
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

.modal-overlay.visible {
    display: flex;
}

.modal-box {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}

.modal-box h3 {
    margin-top: 0;
    color: var(--accent-primary);
}

.modal-box button {
    margin-top: 16px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-header">
    <div>
        <h1>Architecture Doctor</h1>
        <p>Diagnose a vulnerable e-commerce architecture and apply the right security design pattern to each weakness.</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</div>

<div class="container">

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>This diagram represents the live architecture of an e-commerce platform. Five weaknesses have been identified, each one caused by a missing security design pattern.</p>
        <p>Click each numbered marker, read the weakness, and select the pattern from the dropdown that fixes it. There is no penalty for a wrong guess, so investigate freely. Once all five are patched, the system is considered secure.</p>
    </div>

    <div class="env-section">
        <div id="progress-tracker"><strong id="progress-count">0</strong> of 5 vulnerabilities patched</div>

        <div id="architecture-diagram">
            <span class="diagram-label" style="top:14px; left:20px;">Client Layer</span>
            <span class="diagram-label" style="top:14px; left:330px;">Service Layer</span>
            <span class="diagram-label" style="top:14px; left:600px;">Legacy / Admin</span>

            <div class="marker" id="vuln-marker-1" style="top:70px; left:60px;" data-vuln="1">1</div>
            <div class="marker" id="vuln-marker-2" style="top:180px; left:150px;" data-vuln="2">2</div>
            <div class="marker" id="vuln-marker-3" style="top:120px; left:400px;" data-vuln="3">3</div>
            <div class="marker" id="vuln-marker-4" style="top:230px; left:420px;" data-vuln="4">4</div>
            <div class="marker" id="vuln-marker-5" style="top:80px; left:650px;" data-vuln="5">5</div>
        </div>

        <div class="detail-panel" id="detail-panel">
            <h3 id="detail-title">Weakness</h3>
            <p class="weakness-text" id="detail-text"></p>
            <div class="detail-controls">
                <select id="pattern-dropdown">
                    <option value="">Select a pattern</option>
                    <option value="Secure Gateway">Secure Gateway</option>
                    <option value="Broker Pattern">Broker Pattern</option>
                    <option value="Intercepting Validator">Intercepting Validator</option>
                    <option value="Single Access Point">Single Access Point</option>
                    <option value="Full Interception">Full Interception</option>
                </select>
                <button id="diagnose-btn">Diagnose</button>
            </div>
            <div class="feedback-area" id="feedback-area"></div>
        </div>
    </div>

    <div class="flag-section" id="flag-section">
        <h2>System Secured</h2>
        <p>All five weaknesses have been patched with the correct pattern. The architecture is now secure.</p>
        <div class="flag-value">CBX{blueprint_secured}</div>
    </div>

</div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're Ready to Start the Challenge</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const vulnerabilities = {
    1: {
        text: "Customers can log in through three separate unguarded endpoints (web, mobile API, partner integration), each with its own inconsistent authentication check.",
        answer: "Single Access Point"
    },
    2: {
        text: "Search and checkout forms pass user input straight to the database with no centralized filtering.",
        answer: "Intercepting Validator"
    },
    3: {
        text: "The legacy inventory subsystem is called directly by six different services, each with its own credentials and error handling, with no mediation layer between them.",
        answer: "Broker Pattern"
    },
    4: {
        text: "Internal microservices accept direct public internet connections with no filtering layer, relying on firewall rules alone.",
        answer: "Secure Gateway"
    },
    5: {
        text: "An admin panel has a debug endpoint that skips the standard request pipeline entirely, bypassing the checks applied to normal traffic.",
        answer: "Full Interception"
    }
};

let solvedCount = 0;
let activeVuln = null;
const solved = {};

const detailPanel = document.getElementById('detail-panel');
const detailTitle = document.getElementById('detail-title');
const detailText = document.getElementById('detail-text');
const dropdown = document.getElementById('pattern-dropdown');
const diagnoseBtn = document.getElementById('diagnose-btn');
const feedbackArea = document.getElementById('feedback-area');
const progressCount = document.getElementById('progress-count');
const flagSection = document.getElementById('flag-section');

document.querySelectorAll('.marker').forEach(marker => {
    marker.addEventListener('click', () => {
        const id = marker.dataset.vuln;
        activeVuln = id;
        document.querySelectorAll('.marker').forEach(m => m.classList.remove('active'));
        if (!solved[id]) {
            marker.classList.add('active');
        }
        detailTitle.textContent = 'Weakness #' + id;
        detailText.textContent = vulnerabilities[id].text;
        dropdown.value = '';
        feedbackArea.textContent = '';
        feedbackArea.className = 'feedback-area';
        detailPanel.classList.add('visible');
    });
});

diagnoseBtn.addEventListener('click', () => {
    if (!activeVuln) return;
    const chosen = dropdown.value;
    if (!chosen) {
        feedbackArea.textContent = 'Select a pattern before diagnosing.';
        feedbackArea.className = 'feedback-area';
        return;
    }
    const marker = document.getElementById('vuln-marker-' + activeVuln);
    if (chosen === vulnerabilities[activeVuln].answer) {
        if (!solved[activeVuln]) {
            solved[activeVuln] = true;
            solvedCount++;
            progressCount.textContent = solvedCount;
        }
        marker.classList.remove('active');
        marker.classList.add('solved');
        feedbackArea.textContent = 'Correct. ' + chosen + ' resolves this weakness.';
        feedbackArea.className = 'feedback-area correct';
        if (solvedCount === 5) {
            setTimeout(() => {
                flagSection.classList.add('visible');
                flagSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 400);
        }
    } else {
        feedbackArea.textContent = 'Not quite. Review the weakness and try a different pattern.';
        feedbackArea.className = 'feedback-area incorrect';
        marker.classList.add('shake');
        setTimeout(() => marker.classList.remove('shake'), 400);
    }
});

// ===== Tutorial spotlight system =====
const tutorialSteps = [
    { targetElementId: 'architecture-diagram', tooltipText: 'This is the current architecture of a live e-commerce platform. It has five known weak points marked in red.' },
    { targetElementId: 'vuln-marker-1', tooltipText: 'Click any marker to see what is wrong at that point in the system, like a doctor reviewing a chart.' },
    { targetElementId: 'pattern-dropdown', tooltipText: 'Choose the design pattern you believe fixes this weakness. Think about what the vulnerability actually needs: filtering, mediation, or a single controlled entry.' },
    { targetElementId: 'diagnose-btn', tooltipText: 'Confirm your diagnosis. If you are right, the marker locks in green. If not, you can try again.' },
    { targetElementId: 'progress-tracker', tooltipText: 'Track how many vulnerabilities you have patched. Once all five are fixed, the system is secure and the flag appears.' }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;
let tutorialActive = false;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight-box';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tutorial-tooltip';
    document.body.appendChild(tooltipEl);
}

function removeSpotlightElements() {
    if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
    if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
}

function positionSpotlight(targetEl) {
    const rect = targetEl.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    const tooltipWidth = 300;
    const viewportW = window.innerWidth;
    const viewportH = window.innerHeight;

    let top, left, placement = 'bottom';

    if (rect.bottom + 160 < viewportH) {
        placement = 'bottom';
    } else if (rect.top - 160 > 0) {
        placement = 'top';
    } else if (rect.right + tooltipWidth + 20 < viewportW) {
        placement = 'right';
    } else {
        placement = 'left';
    }

    if (placement === 'bottom') {
        top = rect.bottom + 16;
        left = Math.min(Math.max(rect.left, 10), viewportW - tooltipWidth - 10);
    } else if (placement === 'top') {
        top = rect.top - 160;
        left = Math.min(Math.max(rect.left, 10), viewportW - tooltipWidth - 10);
    } else if (placement === 'right') {
        top = Math.min(Math.max(rect.top, 10), viewportH - 180);
        left = rect.right + 16;
    } else {
        top = Math.min(Math.max(rect.top, 10), viewportH - 180);
        left = rect.left - tooltipWidth - 16;
    }

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function renderTutorialStep() {
    const step = tutorialSteps[currentStep];
    let targetEl = document.getElementById(step.targetElementId);
    if (!targetEl) return;

    const rect = targetEl.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const proceed = () => {
        positionSpotlight(targetEl);
        const isLast = currentStep === tutorialSteps.length - 1;
        tooltipEl.innerHTML =
            '<div>' + step.tooltipText + '</div>' +
            '<div class="tt-actions">' +
            '<button class="skip-btn" id="tt-skip">Skip Tutorial</button>' +
            '<button id="tt-next">' + (isLast ? 'Finish' : 'Next') + '</button>' +
            '</div>';
        document.getElementById('tt-next').addEventListener('click', nextTutorialStep);
        document.getElementById('tt-skip').addEventListener('click', endTutorial);
    };

    if (!inView) {
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(proceed, 300);
    } else {
        proceed();
    }
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    renderTutorialStep();
}

function startTutorial() {
    currentStep = 0;
    tutorialActive = true;
    createSpotlightElements();
    renderTutorialStep();
}

function endTutorial(completed) {
    tutorialActive = false;
    removeSpotlightElements();
    if (completed) {
        document.getElementById('tutorial-complete-modal').classList.add('visible');
    }
}

window.addEventListener('resize', () => {
    if (tutorialActive) {
        const step = tutorialSteps[currentStep];
        const targetEl = document.getElementById(step.targetElementId);
        if (targetEl) positionSpotlight(targetEl);
    }
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').classList.remove('visible');
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
