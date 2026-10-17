<?php
// ============================================================
// zero-trust-architecture-practical.php
// Standalone static practical: "Access Broker"
// No backend logic, no database, no sessions.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Access Broker Console</title>
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

/* ===== HEADER ===== */
.app-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 22px 28px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    position: relative;
}
.app-header h1 {
    margin: 0 0 4px 0;
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text-primary);
}
.app-header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
}
#tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    background: #1a2340;
}

/* ===== DESCRIPTION ===== */
.mission-briefing {
    max-width: 900px;
    margin: 24px auto 0 auto;
    padding: 0 28px;
}
.mission-briefing .brief-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
}
.mission-briefing h2 {
    margin: 0 0 8px 0;
    font-size: 1.05rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
.mission-briefing p:last-child { margin-bottom: 0; }

/* ===== MAIN CONTAINER ===== */
.main-container {
    max-width: 900px;
    margin: 24px auto;
    padding: 0 28px 60px 28px;
    display: grid;
    grid-template-columns: 1fr 260px;
    gap: 22px;
}
@media (max-width: 760px) {
    .main-container { grid-template-columns: 1fr; }
}

/* ===== REQUEST CARD ===== */
#request-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
}
.progress-tracker {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 14px;
}
.request-field {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border-default);
}
.request-field:last-of-type { border-bottom: none; }
.request-field .label {
    color: var(--text-muted);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    min-width: 130px;
}
.request-field .value {
    color: var(--text-primary);
    font-size: 0.92rem;
    text-align: right;
}
.decision-buttons {
    display: flex;
    gap: 14px;
    margin-top: 22px;
}
.decision-buttons button {
    flex: 1;
    padding: 14px;
    border-radius: 8px;
    border: none;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.15s ease;
}
.decision-buttons button:active { transform: scale(0.97); }
#allow-btn { background: rgba(61,255,154,0.15); color: var(--success); border: 1px solid var(--success); }
#allow-btn:hover { background: rgba(61,255,154,0.25); }
#deny-btn { background: rgba(255,92,92,0.15); color: var(--error); border: 1px solid var(--error); }
#deny-btn:hover { background: rgba(255,92,92,0.25); }

/* ===== FEEDBACK / STATUS AREA ===== */
#feedback-area {
    margin-top: 18px;
    padding: 14px 16px;
    border-radius: 8px;
    font-size: 0.88rem;
    display: none;
}
#feedback-area.correct {
    display: block;
    background: rgba(61,255,154,0.1);
    border: 1px solid var(--success);
    color: var(--success);
}
#feedback-area.incorrect {
    display: block;
    background: rgba(255,92,92,0.1);
    border: 1px solid var(--error);
    color: var(--error);
}
#feedback-area .explain { color: var(--text-secondary); display: block; margin-top: 6px; }

#next-btn {
    margin-top: 14px;
    display: none;
    padding: 10px 20px;
    border-radius: 8px;
    border: 1px solid var(--accent-primary);
    background: var(--bg-primary);
    color: var(--accent-primary);
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}

/* ===== POLICY LOG ===== */
#policy-log {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px;
    max-height: 560px;
    overflow-y: auto;
}
#policy-log h3 {
    margin: 0 0 12px 0;
    font-size: 0.9rem;
    color: var(--text-primary);
}
.log-entry {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    padding: 8px 0;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-secondary);
}
.log-entry:last-child { border-bottom: none; }
.log-entry .tag-allow { color: var(--success); font-weight: 600; }
.log-entry .tag-deny { color: var(--error); font-weight: 600; }

/* ===== SUMMARY / FLAG REVEAL ===== */
#summary-panel {
    display: none;
    max-width: 900px;
    margin: 24px auto 60px auto;
    padding: 0 28px;
}
#summary-panel .summary-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 28px;
    text-align: center;
}
#summary-panel h2 { margin-top: 0; color: var(--text-primary); }
#retry-btn {
    margin-top: 16px;
    padding: 12px 24px;
    border-radius: 8px;
    border: 1px solid var(--warning);
    background: rgba(255,211,106,0.1);
    color: var(--warning);
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}
#flag-reveal {
    margin-top: 20px;
    padding: 18px;
    border-radius: 8px;
    background: rgba(106,227,255,0.08);
    border: 1px solid var(--accent-primary);
}
#flag-reveal .flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    color: var(--accent-primary);
    margin-top: 8px;
    user-select: all;
}
.wrong-list {
    text-align: left;
    margin-top: 16px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.wrong-list li { margin-bottom: 6px; }

/* ===== TUTORIAL SPOTLIGHT ===== */
#spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.25s ease;
    pointer-events: none;
    z-index: 9000;
    display: none;
}
#tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9001;
    display: none;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}
#tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-primary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    flex: 1;
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}
#tt-skip { background: transparent; color: var(--text-muted); border: 1px solid var(--border-default); }
#tt-next { background: var(--accent-primary); color: var(--bg-primary); }

/* ===== MODAL ===== */
#modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 9500;
    align-items: center;
    justify-content: center;
}
#modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
#modal-box h3 { margin-top: 0; color: var(--text-primary); }
#modal-box p { color: var(--text-secondary); font-size: 0.9rem; }
#modal-start-btn {
    margin-top: 14px;
    padding: 12px 26px;
    border-radius: 8px;
    border: none;
    background: var(--accent-primary);
    color: var(--bg-primary);
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="app-header">
    <div>
        <h1>Access Broker Console</h1>
        <p>You are the Policy Decision Point. Evaluate every request before it reaches a resource.</p>
    </div>
    <button id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>
</div>

<div class="mission-briefing">
    <div class="brief-box">
        <h2>Mission Briefing</h2>
        <p>This console represents the Policy Decision Point in a Zero Trust network. A queue of ten access requests is waiting, each one carrying identity, device, location, and resource signals.</p>
        <p>Review every request the way a real policy engine would. Click Allow if every signal supports granting access. Click Deny if anything violates least privilege or looks anomalous. Get all ten correct to reveal the flag.</p>
    </div>
</div>

<div class="main-container">
    <div>
        <div id="request-card">
            <div class="progress-tracker" id="progress-tracker">Request 1 of 10</div>

            <div class="request-field">
                <span class="label">Identity</span>
                <span class="value" id="identity-field">-</span>
            </div>
            <div class="request-field">
                <span class="label">Device Posture</span>
                <span class="value" id="device-posture-field">-</span>
            </div>
            <div class="request-field">
                <span class="label">Location / Context</span>
                <span class="value" id="location-field">-</span>
            </div>
            <div class="request-field">
                <span class="label">Requested Resource</span>
                <span class="value" id="resource-field">-</span>
            </div>
            <div class="request-field">
                <span class="label">Time</span>
                <span class="value" id="time-field">-</span>
            </div>

            <div class="decision-buttons">
                <button id="allow-btn" onclick="decide('Allow')">Allow</button>
                <button id="deny-btn" onclick="decide('Deny')">Deny</button>
            </div>

            <div id="feedback-area"></div>
            <button id="next-btn" onclick="nextRequest()">Next Request →</button>
        </div>
    </div>

    <div id="policy-log">
        <h3>Policy Log</h3>
        <div id="log-entries"></div>
    </div>
</div>

<div id="summary-panel">
    <div class="summary-box">
        <h2 id="summary-title">Summary</h2>
        <p id="summary-text"></p>
        <ul class="wrong-list" id="wrong-list" style="display:none;"></ul>
        <div id="flag-reveal" style="display:none;">
            <div>Policy Enforcement Complete</div>
            <div class="flag-value mono">CBX{trust_nothing_verify_everything}</div>
        </div>
        <button id="retry-btn" style="display:none;" onclick="retryQueue()">Retry Queue</button>
    </div>
</div>

<!-- Tutorial spotlight elements -->
<div id="spotlight-box"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tt-skip" onclick="skipTutorial()">Skip Tutorial</button>
        <button id="tt-next" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<!-- Completion modal -->
<div id="modal-overlay">
    <div id="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Evaluate each request carefully and trust nothing by default.</p>
        <button id="modal-start-btn" onclick="closeModal()">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA: request queue
// ============================================================
const requests = [
    {
        identity: "j.romero (Employee)",
        device: "Compliant, disk encrypted",
        location: "Corporate office, known IP",
        resource: "HR Portal - read access",
        time: "09:14",
        correct: "Allow",
        explain: "A compliant device on a known corporate network requesting access within its role satisfies Zero Trust verification."
    },
    {
        identity: "t.walsh (Contractor)",
        device: "Unmanaged personal device, no MFA registered",
        location: "Unrecognized VPN exit node",
        resource: "Finance Database - read/write",
        time: "23:47",
        correct: "Deny",
        explain: "An unmanaged device with no MFA requesting write access to a sensitive database fails device posture and identity verification."
    },
    {
        identity: "a.kim (Employee)",
        device: "Compliant, disk encrypted",
        location: "New country, never seen before for this user",
        resource: "Corporate Email",
        time: "14:02",
        correct: "Deny",
        explain: "A sudden, unprecedented location change is an anomaly that requires step up verification before access is granted, even with a compliant device."
    },
    {
        identity: "svc-billing-api (Service Account)",
        device: "Compliant, scoped credentials",
        location: "Internal service network",
        resource: "Billing API - single scoped endpoint",
        time: "03:00",
        correct: "Allow",
        explain: "A service account requesting only the single API it is scoped for follows least privilege correctly."
    },
    {
        identity: "d.ferreira (Marketing, Employee)",
        device: "Compliant, disk encrypted",
        location: "Corporate office, known IP",
        resource: "Finance Database - read access",
        time: "10:30",
        correct: "Deny",
        explain: "This identity has no role based reason to access the Finance Database. Least privilege blocks access outside a user's actual role."
    },
    {
        identity: "m.oduya (Employee)",
        device: "Posture unknown, agent not reporting",
        location: "Corporate office, known IP",
        resource: "Internal Wiki - read access",
        time: "11:12",
        correct: "Allow",
        explain: "Device posture is uncertain, but the resource requested is low sensitivity. Zero Trust applies risk adjusted decisions rather than blanket denial."
    },
    {
        identity: "r.chen (Former Employee, terminated)",
        device: "Compliant, disk encrypted",
        location: "Home network",
        resource: "Corporate VPN",
        time: "19:20",
        correct: "Deny",
        explain: "A terminated identity should never be granted access regardless of how healthy the device appears."
    },
    {
        identity: "j.romero (Employee)",
        device: "Compliant, disk encrypted",
        location: "Corporate office, known IP",
        resource: "HR Portal - read access, same as yesterday",
        time: "09:20",
        correct: "Allow",
        explain: "Access is granted again, but only because every signal is re-verified now, not because it worked yesterday. Zero Trust never assumes standing trust."
    },
    {
        identity: "admin.systems (Admin)",
        device: "Compliant, disk encrypted",
        location: "Unusual location, 3am local time",
        resource: "Domain Controller - full access",
        time: "03:00",
        correct: "Deny",
        explain: "An elevated privilege account requesting sensitive access at an anomalous time and location requires step up verification before access is granted."
    },
    {
        identity: "l.novak (Contractor)",
        device: "Compliant managed device, MFA passed",
        location: "Corporate office, known IP",
        resource: "Project Folder - contracted scope only",
        time: "13:45",
        correct: "Allow",
        explain: "A verified device, passed MFA, and a request scoped exactly to the contracted project folder satisfies least privilege and explicit verification."
    }
];

let currentIndex = 0;
let results = [];
let awaitingNext = false;

const logEntries = document.getElementById('log-entries');
const feedbackArea = document.getElementById('feedback-area');
const nextBtn = document.getElementById('next-btn');
const allowBtn = document.getElementById('allow-btn');
const denyBtn = document.getElementById('deny-btn');

function renderRequest() {
    const r = requests[currentIndex];
    document.getElementById('progress-tracker').textContent = `Request ${currentIndex + 1} of ${requests.length}`;
    document.getElementById('identity-field').textContent = r.identity;
    document.getElementById('device-posture-field').textContent = r.device;
    document.getElementById('location-field').textContent = r.location;
    document.getElementById('resource-field').textContent = r.resource;
    document.getElementById('time-field').textContent = r.time;
    feedbackArea.className = '';
    feedbackArea.style.display = 'none';
    nextBtn.style.display = 'none';
    allowBtn.disabled = false;
    denyBtn.disabled = false;
    awaitingNext = false;
}

function decide(choice) {
    if (awaitingNext) return;
    const r = requests[currentIndex];
    const isCorrect = choice === r.correct;
    results.push({ index: currentIndex, choice, correct: isCorrect, expected: r.correct, resource: r.resource });

    feedbackArea.className = isCorrect ? 'correct' : 'incorrect';
    feedbackArea.style.display = 'block';
    feedbackArea.innerHTML = (isCorrect ? 'Correct decision.' : 'Incorrect decision.') +
        '<span class="explain">' + r.explain + '</span>';

    const entry = document.createElement('div');
    entry.className = 'log-entry';
    entry.innerHTML = `Req ${currentIndex + 1}: <span class="${choice === 'Allow' ? 'tag-allow' : 'tag-deny'}">${choice}</span> - ${r.resource}`;
    logEntries.appendChild(entry);
    logEntries.scrollTop = logEntries.scrollHeight;

    allowBtn.disabled = true;
    denyBtn.disabled = true;
    nextBtn.style.display = 'inline-block';
    awaitingNext = true;
}

function nextRequest() {
    currentIndex++;
    if (currentIndex >= requests.length) {
        showSummary();
    } else {
        renderRequest();
    }
}

function showSummary() {
    document.querySelector('.main-container').style.display = 'none';
    const panel = document.getElementById('summary-panel');
    panel.style.display = 'block';

    const wrongOnes = results.filter(r => !r.correct);
    const title = document.getElementById('summary-title');
    const text = document.getElementById('summary-text');
    const wrongList = document.getElementById('wrong-list');
    const flagReveal = document.getElementById('flag-reveal');
    const retryBtn = document.getElementById('retry-btn');

    if (wrongOnes.length === 0) {
        title.textContent = 'Policy Enforcement Complete';
        text.textContent = 'All ten requests were evaluated correctly. Access was granted only where every signal supported it, and denied wherever risk or least privilege was violated.';
        flagReveal.style.display = 'block';
        wrongList.style.display = 'none';
        retryBtn.style.display = 'none';
    } else {
        title.textContent = 'Review Required';
        text.textContent = `${wrongOnes.length} of 10 decisions did not match correct Zero Trust policy. Review the explanations below and retry the queue.`;
        wrongList.style.display = 'block';
        wrongList.innerHTML = '';
        wrongOnes.forEach(w => {
            const li = document.createElement('li');
            li.textContent = `Request ${w.index + 1} (${w.resource}): you chose ${w.choice}, correct answer was ${w.expected}.`;
            wrongList.appendChild(li);
        });
        flagReveal.style.display = 'none';
        retryBtn.style.display = 'inline-block';
    }
}

function retryQueue() {
    currentIndex = 0;
    results = [];
    logEntries.innerHTML = '';
    document.getElementById('summary-panel').style.display = 'none';
    document.querySelector('.main-container').style.display = 'grid';
    renderRequest();
}

renderRequest();

// ============================================================
// TUTORIAL: spotlight based
// ============================================================
const tutorialSteps = [
    { targetId: 'request-card', text: 'This is an incoming access request. In a Zero Trust model, every single request is evaluated like this, even from users you already trust.' },
    { targetId: 'identity-field', text: 'This shows who is asking. Identity alone is never enough to grant access.' },
    { targetId: 'device-posture-field', text: 'This shows the health of the requesting device. A compromised or unmanaged device is a major risk signal.' },
    { targetId: 'location-field', text: 'Location and network context help detect anomalies, like impossible travel or unrecognized networks.' },
    { targetId: 'resource-field', text: 'This is what the requester wants to access. Always ask: does this identity actually need this, right now?' },
    { targetId: 'allow-btn', text: 'Grant access only if every signal supports it. This is your Allow decision.' },
    { targetId: 'deny-btn', text: 'If anything looks risky or violates least privilege, deny. You can always re-verify later.' },
    { targetId: 'policy-log', text: 'Your decisions build a running audit log, just like Zero Trust accounting in the real world.' }
];

let tutorialStepIndex = 0;
let tutorialActive = false;

const spotlightBox = document.getElementById('spotlight-box');
const tooltip = document.getElementById('tutorial-tooltip');
const tooltipText = document.getElementById('tooltip-text');

function startTutorial() {
    tutorialStepIndex = 0;
    tutorialActive = true;
    spotlightBox.style.display = 'block';
    tooltip.style.display = 'block';
    showTutorialStep();
}

function showTutorialStep() {
    const step = tutorialSteps[tutorialStepIndex];
    const el = document.getElementById(step.targetId);
    if (!el) { nextTutorialStep(); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el, step), 300);
    } else {
        positionSpotlight(el, step);
    }
}

function positionSpotlight(el, step) {
    const rect = el.getBoundingClientRect();
    const pad = 8;

    spotlightBox.style.top = (rect.top - pad) + 'px';
    spotlightBox.style.left = (rect.left - pad) + 'px';
    spotlightBox.style.width = (rect.width + pad * 2) + 'px';
    spotlightBox.style.height = (rect.height + pad * 2) + 'px';

    tooltipText.textContent = step.text;

    // Choose placement: prefer bottom, fall back to top, then right, then left
    const tooltipWidth = 300;
    const tooltipHeightEstimate = 120;
    let top, left, placement = 'bottom';

    if (rect.bottom + tooltipHeightEstimate + 16 < window.innerHeight) {
        placement = 'bottom';
    } else if (rect.top - tooltipHeightEstimate - 16 > 0) {
        placement = 'top';
    } else if (rect.right + tooltipWidth + 16 < window.innerWidth) {
        placement = 'right';
    } else {
        placement = 'left';
    }

    if (placement === 'bottom') {
        top = rect.bottom + 16;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - tooltipWidth - 10);
    } else if (placement === 'top') {
        top = rect.top - tooltipHeightEstimate - 16;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - tooltipWidth - 10);
    } else if (placement === 'right') {
        top = Math.min(Math.max(rect.top, 10), window.innerHeight - tooltipHeightEstimate - 10);
        left = rect.right + 16;
    } else {
        top = Math.min(Math.max(rect.top, 10), window.innerHeight - tooltipHeightEstimate - 10);
        left = rect.left - tooltipWidth - 16;
    }

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
    tooltip.style.width = tooltipWidth + 'px';
}

function nextTutorialStep() {
    tutorialStepIndex++;
    if (tutorialStepIndex >= tutorialSteps.length) {
        endTutorial();
    } else {
        showTutorialStep();
    }
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    tutorialActive = false;
    spotlightBox.style.display = 'none';
    tooltip.style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal-overlay').style.display = 'none';
}

window.addEventListener('resize', () => {
    if (tutorialActive) {
        const step = tutorialSteps[tutorialStepIndex];
        const el = document.getElementById(step.targetId);
        if (el) positionSpotlight(el, step);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
