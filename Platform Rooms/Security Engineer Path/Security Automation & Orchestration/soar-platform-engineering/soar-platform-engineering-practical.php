<?php
// ============================================================
// soar-platform-engineering-practical.php — PRACTICAL FILE
// Trigger Configuration Console
// Standalone static HTML/CSS/JS. PHP used for structure only.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trigger Configuration Console</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.page-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== HEADER ===== */
.console-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-default);
}

.console-header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}

.console-header p {
    margin: 0;
    color: var(--text-secondary);
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
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    background: var(--bg-secondary);
}

/* ===== DESCRIPTION SECTION ===== */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px 24px;
    margin-bottom: 30px;
}
.mission-briefing h2 {
    font-size: 1.05rem;
    margin: 0 0 10px 0;
    color: var(--text-primary);
}
.mission-briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.mission-briefing p:last-child { margin-bottom: 0; }

/* ===== STATUS PANEL ===== */
.status-panel {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bg-surface);
    border: 1px solid var(--error);
    border-radius: 10px;
    padding: 18px 24px;
    margin-bottom: 30px;
    transition: border-color 0.4s ease, box-shadow 0.4s ease;
}
.status-panel.operational {
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.status-panel .status-label {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}
.status-panel .status-value {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--error);
}
.status-panel.operational .status-value {
    color: var(--success);
}
.status-flag {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.05rem;
    color: var(--success);
    background: rgba(61,255,154,0.08);
    border: 1px solid rgba(61,255,154,0.3);
    padding: 8px 16px;
    border-radius: 6px;
    display: none;
}
.status-panel.operational .status-flag {
    display: block;
}

/* ===== EVENT CARDS ===== */
.event-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    margin-bottom: 20px;
}

.event-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px 22px;
    transition: border-color 0.3s ease;
}
.event-card.correct {
    border-color: var(--success);
}
.event-card.incorrect {
    border-color: var(--error);
}

.event-card .event-title {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 6px;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}

.event-card .event-desc {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 14px;
}

.event-controls {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}

.event-controls select {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 8px 12px;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
}

.validate-btn {
    background: var(--accent-secondary);
    color: #0b0f1a;
    border: none;
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: opacity 0.2s ease;
}
.validate-btn:hover { opacity: 0.85; }

.result-icon {
    font-size: 1.1rem;
}

.hint-box {
    margin-top: 12px;
    padding: 10px 14px;
    background: rgba(255,92,92,0.08);
    border: 1px solid rgba(255,92,92,0.3);
    border-radius: 6px;
    color: var(--error);
    font-size: 0.85rem;
    display: none;
}
.hint-box.visible { display: block; }

/* ===== SPOTLIGHT TUTORIAL ===== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 9998;
    transition: all 0.3s ease;
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
    margin: 0 0 14px 0;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.tooltip-actions .next-btn {
    background: var(--accent-primary);
    color: #0b0f1a;
    padding: 7px 16px;
    border-radius: 6px;
    font-weight: 600;
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
.modal-overlay.visible { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 32px;
    text-align: center;
    max-width: 380px;
}
.modal-box h3 {
    margin: 0 0 12px 0;
    color: var(--accent-primary);
}
.modal-box p {
    color: var(--text-secondary);
    margin: 0 0 20px 0;
    font-size: 0.9rem;
}
.modal-box button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 640px) {
    .console-header { flex-direction: column; }
    .event-controls { flex-direction: column; align-items: stretch; }
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="console-header" id="console-header">
        <div>
            <h1>Trigger Configuration Console</h1>
            <p>SOAR Platform Engineering, Practical Lab</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>This SOAR platform has four incoming events queued and no triggers configured. Nothing will run until every event is mapped to the trigger type that matches how it actually originates.</p>
        <p>Read each event description, choose Alert-driven, Scheduled, Event-driven, or Manual, and validate your choice. The platform comes online once all four are correct.</p>
    </div>

    <div class="status-panel" id="status-panel">
        <div>
            <div class="status-label">Platform Status</div>
            <div class="status-value" id="status-value">Misconfigured</div>
        </div>
        <div class="status-flag" id="status-flag">CBX{trigger_configured}</div>
    </div>

    <div class="event-grid">

        <div class="event-card" id="event-card-1" data-correct="alert-driven">
            <div class="event-title"><span>Event 1</span></div>
            <div class="event-desc">Multiple failed logins followed by a successful login from a new geographic location, detected by the SIEM.</div>
            <div class="event-controls">
                <select id="trigger-select-1">
                    <option value="">Select trigger type</option>
                    <option value="alert-driven">Alert-driven</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="event-driven">Event-driven</option>
                    <option value="manual">Manual</option>
                </select>
                <button class="validate-btn" id="validate-btn-1" onclick="validateCard(1)">Validate</button>
                <span class="result-icon" id="result-icon-1"></span>
            </div>
            <div class="hint-box" id="hint-1">This originates from a security alert generated by the SIEM, not a fixed schedule or external event.</div>
        </div>

        <div class="event-card" id="event-card-2" data-correct="scheduled">
            <div class="event-title"><span>Event 2</span></div>
            <div class="event-desc">A threat intelligence feed sync job that must pull new IOC data every 60 minutes.</div>
            <div class="event-controls">
                <select id="trigger-select-2">
                    <option value="">Select trigger type</option>
                    <option value="alert-driven">Alert-driven</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="event-driven">Event-driven</option>
                    <option value="manual">Manual</option>
                </select>
                <button class="validate-btn" id="validate-btn-2" onclick="validateCard(2)">Validate</button>
                <span class="result-icon" id="result-icon-2"></span>
            </div>
            <div class="hint-box" id="hint-2">This runs on a fixed time interval regardless of alerts or events, not in response to one.</div>
        </div>

        <div class="event-card" id="event-card-3" data-correct="event-driven">
            <div class="event-title"><span>Event 3</span></div>
            <div class="event-desc">A new ticket created in the ticketing system tagged "phishing-reported".</div>
            <div class="event-controls">
                <select id="trigger-select-3">
                    <option value="">Select trigger type</option>
                    <option value="alert-driven">Alert-driven</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="event-driven">Event-driven</option>
                    <option value="manual">Manual</option>
                </select>
                <button class="validate-btn" id="validate-btn-3" onclick="validateCard(3)">Validate</button>
                <span class="result-icon" id="result-icon-3"></span>
            </div>
            <div class="hint-box" id="hint-3">This fires because an external system generated an event, a new ticket, not because a person clicked something or a clock ticked.</div>
        </div>

        <div class="event-card" id="event-card-4" data-correct="manual">
            <div class="event-title"><span>Event 4</span></div>
            <div class="event-desc">An analyst manually starts an account lockdown workflow during an active incident.</div>
            <div class="event-controls">
                <select id="trigger-select-4">
                    <option value="">Select trigger type</option>
                    <option value="alert-driven">Alert-driven</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="event-driven">Event-driven</option>
                    <option value="manual">Manual</option>
                </select>
                <button class="validate-btn" id="validate-btn-4" onclick="validateCard(4)">Validate</button>
                <span class="result-icon" id="result-icon-4"></span>
            </div>
            <div class="hint-box" id="hint-4">This is initiated directly by a human action, not by an alert, schedule, or external event.</div>
        </div>

    </div>

</div>

<!-- Tutorial completion modal -->
<div class="modal-overlay" id="tutorial-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Configure each event with the correct trigger type to bring the platform online.</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
const correctState = { 1: false, 2: false, 3: false, 4: false };

function validateCard(n) {
    const select = document.getElementById('trigger-select-' + n);
    const card = document.getElementById('event-card-' + n);
    const hint = document.getElementById('hint-' + n);
    const icon = document.getElementById('result-icon-' + n);
    const correctValue = card.getAttribute('data-correct');

    if (!select.value) {
        return;
    }

    if (select.value === correctValue) {
        card.classList.remove('incorrect');
        card.classList.add('correct');
        hint.classList.remove('visible');
        icon.textContent = '✓';
        icon.style.color = 'var(--success)';
        correctState[n] = true;
        select.disabled = true;
    } else {
        card.classList.remove('correct');
        card.classList.add('incorrect');
        hint.classList.add('visible');
        icon.textContent = '✗';
        icon.style.color = 'var(--error)';
        correctState[n] = false;
    }

    checkAllComplete();
}

function checkAllComplete() {
    const allCorrect = Object.values(correctState).every(v => v === true);
    const panel = document.getElementById('status-panel');
    const statusValue = document.getElementById('status-value');

    if (allCorrect) {
        panel.classList.add('operational');
        statusValue.textContent = 'Operational';
    } else {
        panel.classList.remove('operational');
        statusValue.textContent = 'Misconfigured';
    }
}

/* ===== SPOTLIGHT TUTORIAL SYSTEM ===== */
const tutorialSteps = [
    {
        targetId: 'console-header',
        text: 'This is the SOAR Trigger Configuration Console. Every automated security response starts with a trigger, the signal that tells the platform to run a playbook. Think of it as the control room where incoming signals get routed to the right process.'
    },
    {
        targetId: 'event-card-1',
        text: 'Each card describes a real incoming event. Read it carefully. It tells you where the event comes from and how it happens.'
    },
    {
        targetId: 'trigger-select-1',
        text: 'Use this dropdown to choose which trigger type fits the event above: Alert-driven, Scheduled, Event-driven, or Manual.'
    },
    {
        targetId: 'validate-btn-1',
        text: 'Click Validate to check your answer for this card. If it is wrong, you will get a hint explaining why, so you can reconsider.'
    },
    {
        targetId: 'status-panel',
        text: 'This panel shows the platform overall status. It stays Misconfigured until every trigger is correctly mapped, then switches to Operational.'
    },
    {
        targetId: 'view-tutorial-btn',
        text: 'You can replay this tutorial anytime using this button in the top right.'
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
    tooltipEl.innerHTML = '<p id="tooltip-text"></p><div class="tooltip-actions"><button onclick="skipTutorial()">Skip Tutorial</button><button class="next-btn" onclick="nextTutorialStep()">Next</button></div>';
    document.body.appendChild(tooltipEl);
}

function positionSpotlight(targetId) {
    const target = document.getElementById(targetId);
    if (!target) { nextTutorialStep(); return; }

    const rect = target.getBoundingClientRect();
    const inViewport = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!inViewport) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => placeSpotlightAndTooltip(target), 300);
    } else {
        placeSpotlightAndTooltip(target);
    }
}

function placeSpotlightAndTooltip(target) {
    const rect = target.getBoundingClientRect();
    const padding = 8;

    spotlightEl.style.top = (rect.top - padding) + 'px';
    spotlightEl.style.left = (rect.left - padding) + 'px';
    spotlightEl.style.width = (rect.width + padding * 2) + 'px';
    spotlightEl.style.height = (rect.height + padding * 2) + 'px';

    document.getElementById('tooltip-text').textContent = tutorialSteps[currentStep].text;

    let top = rect.bottom + 16;
    let left = rect.left;

    const tooltipWidth = 300;
    const estimatedHeight = 140;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + estimatedHeight > window.innerHeight - 20) {
        top = rect.top - estimatedHeight - 16;
    }
    if (top < 10) {
        top = 10;
    }

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) createSpotlightElements();
    spotlightEl.style.display = 'block';
    tooltipEl.style.display = 'block';
    positionSpotlight(tutorialSteps[currentStep].targetId);
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    positionSpotlight(tutorialSteps[currentStep].targetId);
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    if (spotlightEl) spotlightEl.style.display = 'none';
    if (tooltipEl) tooltipEl.style.display = 'none';
    document.getElementById('tutorial-modal').classList.add('visible');
}

function closeTutorialModal() {
    document.getElementById('tutorial-modal').classList.remove('visible');
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', function() {
    if (spotlightEl && spotlightEl.style.display === 'block') {
        positionSpotlight(tutorialSteps[currentStep].targetId);
    }
});

window.addEventListener('load', function() {
    startTutorial();
});
</script>

</body>
</html>
