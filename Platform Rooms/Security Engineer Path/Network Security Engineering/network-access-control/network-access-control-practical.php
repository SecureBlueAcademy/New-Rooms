<?php
// network-access-control-practical.php
// CYBRIXEN Practical: RADIUS Authentication Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RADIUS Authentication Console</title>
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
    padding: 24px;
    min-height: 100vh;
}

.mono { font-family: "JetBrains Mono", monospace; }

.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1000px;
    margin: 0 auto 20px auto;
    gap: 16px;
    flex-wrap: wrap;
}

.top-header h1 {
    font-size: 1.6rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}

.top-header p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 600px;
}

#tutorialBtn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease;
}
#tutorialBtn:hover { box-shadow: var(--glow-accent); }

.container { max-width: 1000px; margin: 0 auto; }

.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
}
.description-section h2 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--text-primary);
}
.description-section p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 0;
}

.score-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 14px 20px;
    margin-bottom: 24px;
}
.score-bar span { color: var(--text-secondary); }
.score-bar strong { color: var(--accent-primary); }

.log-console {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 24px;
}

.log-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.log-card.correct {
    border-color: var(--success);
    box-shadow: 0 0 14px rgba(61,255,154,0.15);
}

.log-card.shake {
    animation: shakeErr 0.35s ease;
    border-color: var(--error);
}

@keyframes shakeErr {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-6px); }
    75% { transform: translateX(6px); }
}

.log-card-head {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}

.log-card-head .device-name {
    font-weight: 600;
    font-size: 1.02rem;
}

.log-card-head .mac {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.log-fields {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 10px;
    margin-bottom: 14px;
}

.log-field {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 8px 12px;
}
.log-field .label {
    display: block;
    font-size: 0.72rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 3px;
}
.log-field .value {
    font-size: 0.9rem;
    color: var(--text-primary);
}

.decision-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.decision-btn {
    flex: 1;
    min-width: 120px;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid var(--border-default);
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.decision-btn:hover { border-color: var(--accent-primary); color: var(--accent-primary); }

.log-card.correct .decision-btn { pointer-events: none; opacity: 0.5; }
.log-card.correct .decision-btn.chosen {
    opacity: 1;
    border-color: var(--success);
    color: var(--success);
    background: rgba(61,255,154,0.08);
}

.explanation {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed var(--border-default);
    font-size: 0.88rem;
    color: var(--success);
    display: none;
}
.log-card.correct .explanation { display: block; }

.hint {
    margin-top: 10px;
    font-size: 0.83rem;
    color: var(--warning);
    display: none;
}
.hint.show { display: block; }

.flag-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    text-align: center;
    opacity: 0.4;
    transition: opacity 0.4s ease, border-color 0.4s ease;
}
.flag-section.unlocked {
    opacity: 1;
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.flag-section h3 {
    margin-top: 0;
    color: var(--text-primary);
}
.flag-value {
    display: inline-block;
    margin-top: 8px;
    padding: 12px 24px;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    color: var(--success);
    font-size: 1.1rem;
    letter-spacing: 0.02em;
}
.flag-placeholder {
    color: var(--text-muted);
    font-style: italic;
}

/* Spotlight tutorial */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    z-index: 9998;
    pointer-events: none;
    transition: all 0.25s ease;
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
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    font-family: inherit;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
}
.tt-next {
    background: var(--accent-primary);
    color: var(--bg-primary);
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 32px;
    text-align: center;
    max-width: 360px;
}
.modal-box h3 { margin-top: 0; color: var(--accent-primary); }
.modal-box p { color: var(--text-secondary); }
.modal-box button {
    margin-top: 10px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .decision-row { flex-direction: column; }
    .decision-btn { min-width: unset; }
}
</style>
</head>
<body>

<div class="top-header" id="pageHeader">
    <div>
        <h1>RADIUS Authentication Console</h1>
        <p>Live 802.1X authentication attempts hitting a network switch at a mid size office. Review each device and make the correct RADIUS decision.</p>
    </div>
    <button id="tutorialBtn">View Tutorial</button>
</div>

<div class="container">

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>Six devices are attempting to authenticate onto the network right now. Some will succeed, some will fail, and some have no supplicant at all and need MAC Authentication Bypass instead. Read each device's authentication method, certificate or credential status, and MAC whitelist status carefully, then choose Accept, Reject, or MAB Fallback. Classify all six correctly to reveal the flag.</p>
    </div>

    <div class="score-bar" id="scoreBar">
        <span>Devices classified correctly</span>
        <strong id="scoreText">0 / 6</strong>
    </div>

    <div class="log-console" id="logConsole">
        <!-- Cards injected by JS -->
    </div>

    <div class="flag-section" id="flagSection">
        <h3>Access Decision Log: Complete</h3>
        <p id="flagBody" class="flag-placeholder">Classify all six devices correctly to reveal the flag.</p>
    </div>

</div>

<script>
const devices = [
    {
        id: 'd1',
        name: 'Corporate Laptop - FIN-LT-04',
        mac: '3C:5A:B4:11:9F:02',
        method: 'EAP-TLS',
        credStatus: 'Certificate valid, expires in 340 days',
        whitelist: 'Not applicable (certificate based)',
        correct: 'accept',
        explanation: 'Valid, unexpired certificate over EAP-TLS. Correctly accepted.'
    },
    {
        id: 'd2',
        name: 'Employee Laptop - MKT-LT-11',
        mac: '00:1B:44:9C:2E:71',
        method: 'EAP-MSCHAPv2',
        credStatus: 'Incorrect password, 2 failed attempts',
        whitelist: 'Not applicable (credential based)',
        correct: 'reject',
        explanation: 'Repeated incorrect credentials. Correctly rejected.'
    },
    {
        id: 'd3',
        name: 'IP Security Camera - CAM-07',
        mac: 'A4:34:D9:22:6C:18',
        method: 'No Supplicant Detected',
        credStatus: 'No EAP credentials presented',
        whitelist: 'MAC matches approved device whitelist',
        correct: 'mab',
        explanation: 'No supplicant, but MAC is on the approved whitelist. Correctly handled with MAB.'
    },
    {
        id: 'd4',
        name: 'Personal Phone - Unregistered',
        mac: 'D8:BB:2C:5E:90:33',
        method: 'No Supplicant Detected',
        credStatus: 'No EAP credentials presented',
        whitelist: 'MAC not found on any whitelist',
        correct: 'reject',
        explanation: 'No supplicant and not on any whitelist. Correctly rejected.'
    },
    {
        id: 'd5',
        name: 'Networked Printer - PRT-02',
        mac: '58:8A:5A:7B:41:0F',
        method: 'EAP-TLS',
        credStatus: 'Certificate expired 14 days ago',
        whitelist: 'Not applicable (certificate based)',
        correct: 'reject',
        explanation: 'Certificate has expired. Correctly rejected regardless of past validity.'
    },
    {
        id: 'd6',
        name: 'IoT Temperature Sensor - SNSR-19',
        mac: 'F0:9F:C2:14:88:5A',
        method: 'No Supplicant Detected',
        credStatus: 'No EAP credentials presented',
        whitelist: 'MAC matches approved IoT whitelist',
        correct: 'mab',
        explanation: 'No supplicant, but MAC is on the approved IoT whitelist. Correctly handled with MAB.'
    }
];

const FLAG = 'CBX{session_authenticated}';
let correctCount = 0;
let wrongAttempts = {};

function renderCards() {
    const consoleEl = document.getElementById('logConsole');
    devices.forEach(dev => {
        const card = document.createElement('div');
        card.className = 'log-card';
        card.id = 'card-' + dev.id;

        card.innerHTML = `
            <div class="log-card-head">
                <span class="device-name">${dev.name}</span>
                <span class="mac mono">${dev.mac}</span>
            </div>
            <div class="log-fields">
                <div class="log-field"><span class="label">Method</span><span class="value mono">${dev.method}</span></div>
                <div class="log-field"><span class="label">Credential / Cert Status</span><span class="value">${dev.credStatus}</span></div>
                <div class="log-field"><span class="label">Whitelist</span><span class="value">${dev.whitelist}</span></div>
            </div>
            <div class="decision-row">
                <button class="decision-btn" data-choice="accept">Accept</button>
                <button class="decision-btn" data-choice="reject">Reject</button>
                <button class="decision-btn" data-choice="mab">MAB Fallback</button>
            </div>
            <p class="hint" id="hint-${dev.id}">Hint: check the certificate status and whitelist fields again closely.</p>
            <div class="explanation">${dev.explanation}</div>
        `;

        card.querySelectorAll('.decision-btn').forEach(btn => {
            btn.addEventListener('click', () => handleDecision(dev, btn, card));
        });

        consoleEl.appendChild(card);
    });
}

function handleDecision(dev, btn, card) {
    if (card.classList.contains('correct')) return;

    const choice = btn.dataset.choice;
    if (choice === dev.correct) {
        card.classList.add('correct');
        btn.classList.add('chosen');
        correctCount++;
        updateScore();
    } else {
        card.classList.add('shake');
        setTimeout(() => card.classList.remove('shake'), 350);
        wrongAttempts[dev.id] = (wrongAttempts[dev.id] || 0) + 1;
        if (wrongAttempts[dev.id] >= 2) {
            document.getElementById('hint-' + dev.id).classList.add('show');
        }
    }
}

function updateScore() {
    document.getElementById('scoreText').textContent = correctCount + ' / 6';
    if (correctCount === devices.length) {
        const flagSection = document.getElementById('flagSection');
        flagSection.classList.add('unlocked');
        document.getElementById('flagBody').outerHTML =
            '<div class="flag-value mono" id="flagBody">' + FLAG + '</div>';
    }
}

renderCards();

/* ================= Spotlight Tutorial System ================= */
const tutorialSteps = [
    {
        targetId: 'pageHeader',
        text: 'This is a RADIUS authentication console. It shows live 802.1X authentication attempts hitting a network switch, just like a real NAC deployment would log them.'
    },
    {
        targetId: 'card-d1',
        text: 'Each card represents one device trying to connect to the network. Read its method and credential status carefully before deciding.'
    },
    {
        targetId: 'card-d1',
        text: 'This is the evidence you need. A valid certificate, a correct password, or a whitelisted MAC address for MAB all change the correct outcome.'
    },
    {
        targetId: 'card-d1',
        text: 'Accept means the device authenticated successfully. Reject means it failed. MAB Fallback means the device has no supplicant but its MAC is authorized to bypass 802.1X.'
    },
    {
        targetId: 'scoreBar',
        text: 'This tracks how many devices you have correctly classified so far.'
    },
    {
        targetId: 'flagSection',
        text: 'Once every device is classified correctly, your flag will appear here automatically.'
    }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createTutorialElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    tooltipEl.innerHTML = `
        <p id="tooltipText"></p>
        <div class="tooltip-actions">
            <button class="tt-skip" id="ttSkip">Skip Tutorial</button>
            <button class="tt-next" id="ttNext">Next</button>
        </div>
    `;
    document.body.appendChild(tooltipEl);

    document.getElementById('ttSkip').addEventListener('click', endTutorial);
    document.getElementById('ttNext').addEventListener('click', nextStep);
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 16;
    let left = rect.left;

    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left + tooltipWidth > window.innerWidth) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (left < 10) left = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function showStep(index) {
    const step = tutorialSteps[index];
    const target = document.getElementById(step.targetId);
    if (!target) { nextStep(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(target), 300);
    } else {
        positionSpotlight(target);
    }

    document.getElementById('tooltipText').textContent = step.text;
    document.getElementById('ttNext').textContent = (index === tutorialSteps.length - 1) ? 'Finish' : 'Next';
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
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
    if (completed) showCompletionModal();
}

function showCompletionModal() {
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
        <div class="modal-box">
            <h3>Tutorial Complete</h3>
            <p>You're ready to start the challenge.</p>
            <button id="startChallengeBtn">Start Challenge</button>
        </div>
    `;
    document.body.appendChild(overlay);
    document.getElementById('startChallengeBtn').addEventListener('click', () => overlay.remove());
}

function startTutorial() {
    currentStep = 0;
    createTutorialElements();
    showStep(currentStep);
}

document.getElementById('tutorialBtn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (spotlightEl && tutorialSteps[currentStep]) {
        const target = document.getElementById(tutorialSteps[currentStep].targetId);
        if (target) positionSpotlight(target);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
