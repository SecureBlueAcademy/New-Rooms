<?php
// brute-force-credential-spraying-practical.php
// Standalone static practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The Lockout Trap</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.5;
    padding: 24px;
    min-height: 100vh;
}

.container {
    max-width: 920px;
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
    color: var(--accent-primary);
}

.header .subtitle {
    color: var(--text-secondary);
    margin-top: 6px;
    font-size: 0.95rem;
}

#tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* ===== DESCRIPTION ===== */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
}
.briefing h2 {
    font-size: 1rem;
    color: var(--text-primary);
    margin-bottom: 8px;
}
.briefing p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 8px;
}
.briefing p:last-child { margin-bottom: 0; }

/* ===== MAIN ENVIRONMENT ===== */
.environment {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 20px;
}

.status-row {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.status-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 18px;
    flex: 1;
    min-width: 180px;
}
.status-card .label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 6px;
}
.status-card .value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
}
.status-card.locked .value { color: var(--error); }
.status-card.ok .value { color: var(--success); }

#mode-toggle {
    display: flex;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 4px;
    margin-bottom: 20px;
    gap: 4px;
}
.mode-btn {
    flex: 1;
    padding: 12px;
    border: none;
    background: transparent;
    color: var(--text-secondary);
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    border-radius: 7px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.mode-btn.active {
    background: var(--bg-primary);
    color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

#username-panel {
    margin-bottom: 20px;
}
.panel-label {
    font-size: 0.8rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
}
.account-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
}
.account-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.account-card.selected {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.account-card.locked {
    border-color: var(--error);
    opacity: 0.6;
    cursor: not-allowed;
}
.account-card .uname {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9rem;
    color: var(--text-primary);
}
.account-card .meter {
    margin-top: 6px;
    font-size: 0.72rem;
    color: var(--text-muted);
}
.account-card.locked .meter { color: var(--error); }

.password-row {
    display: flex;
    gap: 10px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}
#password-input {
    flex: 1;
    min-width: 200px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9rem;
}
#password-input:focus { outline: none; border-color: var(--accent-primary); }

#launch-attempt-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 24px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
#launch-attempt-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}
#launch-attempt-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.spray-hint {
    font-size: 0.78rem;
    color: var(--text-muted);
    margin-top: -8px;
    margin-bottom: 18px;
}

/* ===== ATTEMPT LOG ===== */
#attempt-log {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    max-height: 220px;
    overflow-y: auto;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
}
.log-line {
    padding: 5px 0;
    color: var(--text-secondary);
    border-bottom: 1px solid var(--border-default);
}
.log-line:last-child { border-bottom: none; }
.log-line.fail { color: var(--error); }
.log-line.lock { color: var(--warning); }
.log-line.success { color: var(--success); }
.log-line .ts { color: var(--text-muted); margin-right: 8px; }

/* ===== FEEDBACK ===== */
#feedback-area {
    margin-top: 18px;
    min-height: 20px;
    font-size: 0.9rem;
}
#feedback-area.warn { color: var(--warning); }
#feedback-area.err { color: var(--error); }
#feedback-area.ok { color: var(--success); }

/* ===== FLAG REVEAL ===== */
#flag-area {
    display: none;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(61,255,154,0.02));
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 22px;
    text-align: center;
    margin-top: 20px;
}
#flag-area h3 {
    color: var(--success);
    font-size: 1.1rem;
    margin-bottom: 10px;
}
#flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.15rem;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 12px 18px;
    display: inline-block;
    letter-spacing: 0.02em;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
#spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
    pointer-events: none;
    z-index: 999;
}
#tutorial-tooltip {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 280px;
    z-index: 1000;
    box-shadow: var(--glow-accent);
    display: none;
}
#tutorial-tooltip p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 12px;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 8px 14px;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    cursor: pointer;
}
.tooltip-actions .next-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border-color: var(--accent-primary);
    font-weight: 600;
}

/* ===== MODAL ===== */
#tutorial-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 1100;
    align-items: center;
    justify-content: center;
}
#tutorial-modal {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    max-width: 360px;
}
#tutorial-modal h3 {
    color: var(--accent-primary);
    margin-bottom: 10px;
}
#tutorial-modal p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 18px;
}
#tutorial-modal button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

@media (max-width: 600px) {
    .header { flex-direction: column; }
    .status-row { flex-direction: column; }
}
</style>
</head>
<body>

<div class="container">

    <div class="header">
        <div>
            <h1>The Lockout Trap</h1>
            <p class="subtitle">Meridian Corp login portal, security assessment simulation</p>
        </div>
        <button id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </div>

    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>You have been given access to a simulated login portal for Meridian Corp. Six employee accounts are in scope for this assessment.</p>
        <p>Your goal is to gain access to one account without causing more than one lockout across the whole session. Choose your attack mode carefully and watch how the system responds.</p>
    </div>

    <div class="environment">

        <div class="status-row">
            <div class="status-card" id="lockout-meter">
                <div class="label">Lockout Threshold</div>
                <div class="value">3 attempts</div>
            </div>
            <div class="status-card" id="lockout-count-card">
                <div class="label">Lockouts Triggered</div>
                <div class="value" id="lockout-count">0</div>
            </div>
            <div class="status-card" id="mode-status-card">
                <div class="label">Current Mode</div>
                <div class="value" id="mode-status">Brute Force</div>
            </div>
        </div>

        <div id="mode-toggle">
            <button class="mode-btn active" id="brute-btn" onclick="setMode('brute')">Brute Force</button>
            <button class="mode-btn" id="spray-btn" onclick="setMode('spray')">Credential Spray</button>
        </div>

        <div id="username-panel">
            <div class="panel-label">Target Accounts</div>
            <div class="account-grid" id="account-grid"></div>
        </div>

        <div class="password-row">
            <input type="text" id="password-input" placeholder="Enter password guess" />
            <button id="launch-attempt-btn" onclick="submitAttempt()">Submit Attempt</button>
        </div>
        <p class="spray-hint" id="mode-hint">Brute Force mode targets only the selected account with every attempt.</p>

        <div class="panel-label">Attempt Log</div>
        <div id="attempt-log"></div>

        <div id="feedback-area"></div>
    </div>

    <div id="flag-area">
        <h3>Access Granted</h3>
        <p style="color: var(--text-secondary); margin-bottom: 14px;">Account kpatel authenticated successfully via credential spraying.</p>
        <div id="flag-value">CBX{spray_not_bruteforce}</div>
    </div>

</div>

<div id="spotlight"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button onclick="skipTutorial()">Skip Tutorial</button>
        <button class="next-btn" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<div id="tutorial-modal-overlay">
    <div id="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
// ===== ACCOUNT DATA =====
const accounts = [
    { username: 'jsmith', password: 'Th1s!sN0tGuess4ble', attempts: 0, locked: false, lockUntil: 0 },
    { username: 'mrodriguez', password: 'Xk9#mQ2vLp7z', attempts: 0, locked: false, lockUntil: 0 },
    { username: 'achen', password: 'Zt8&nRw3fJq1', attempts: 0, locked: false, lockUntil: 0 },
    { username: 'kpatel', password: 'Summer2024', attempts: 0, locked: false, lockUntil: 0 },
    { username: 'dwilliams', password: 'Bv6$hLm9cWe4', attempts: 0, locked: false, lockUntil: 0 },
    { username: 'tnguyen', password: 'Qp2@rTx5nDs8', attempts: 0, locked: false, lockUntil: 0 },
];

const LOCKOUT_THRESHOLD = 3;
const LOCKOUT_DURATION_MS = 30000;

let currentMode = 'brute';
let selectedAccount = 'jsmith';
let lockoutCount = 0;
let flagRevealed = false;

const gridEl = document.getElementById('account-grid');
const logEl = document.getElementById('attempt-log');
const feedbackEl = document.getElementById('feedback-area');

function renderAccounts() {
    gridEl.innerHTML = '';
    accounts.forEach(acc => {
        const now = Date.now();
        if (acc.locked && now >= acc.lockUntil) {
            acc.locked = false;
            acc.attempts = 0;
        }
        const card = document.createElement('div');
        card.className = 'account-card' + (acc.username === selectedAccount ? ' selected' : '') + (acc.locked ? ' locked' : '');
        card.onclick = () => { if (!acc.locked) { selectedAccount = acc.username; renderAccounts(); } };
        card.innerHTML = `
            <div class="uname">${acc.username}</div>
            <div class="meter">${acc.locked ? 'LOCKED' : acc.attempts + ' / ' + LOCKOUT_THRESHOLD + ' attempts'}</div>
        `;
        gridEl.appendChild(card);
    });
}

function addLog(text, cls) {
    const line = document.createElement('div');
    line.className = 'log-line' + (cls ? ' ' + cls : '');
    const ts = new Date().toLocaleTimeString();
    line.innerHTML = `<span class="ts">[${ts}]</span> ${text}`;
    logEl.prepend(line);
}

function setMode(mode) {
    currentMode = mode;
    document.getElementById('brute-btn').classList.toggle('active', mode === 'brute');
    document.getElementById('spray-btn').classList.toggle('active', mode === 'spray');
    document.getElementById('mode-status').textContent = mode === 'brute' ? 'Brute Force' : 'Credential Spray';
    document.getElementById('mode-hint').textContent = mode === 'brute'
        ? 'Brute Force mode targets only the selected account with every attempt.'
        : 'Credential Spray mode tries your password guess against every account in one pass.';
}

function submitAttempt() {
    const pw = document.getElementById('password-input').value.trim();
    if (!pw) {
        feedbackEl.textContent = 'Enter a password guess before submitting.';
        feedbackEl.className = 'warn';
        return;
    }

    if (currentMode === 'brute') {
        const acc = accounts.find(a => a.username === selectedAccount);
        const now = Date.now();
        if (acc.locked && now < acc.lockUntil) {
            feedbackEl.textContent = `${acc.username} is currently locked. Try again later or switch accounts.`;
            feedbackEl.className = 'err';
            return;
        }
        if (pw === acc.password) {
            handleSuccess(acc);
            return;
        }
        acc.attempts += 1;
        addLog(`Brute force attempt on ${acc.username}: FAILED (${acc.attempts}/${LOCKOUT_THRESHOLD})`, 'fail');
        if (acc.attempts >= LOCKOUT_THRESHOLD) {
            acc.locked = true;
            acc.lockUntil = now + LOCKOUT_DURATION_MS;
            lockoutCount += 1;
            document.getElementById('lockout-count').textContent = lockoutCount;
            addLog(`${acc.username} is now LOCKED for 30 seconds`, 'lock');
            feedbackEl.textContent = `${acc.username} has locked out after repeated failed attempts. This is the risk of brute forcing a single account.`;
            feedbackEl.className = 'err';
        } else {
            feedbackEl.textContent = `Attempt failed on ${acc.username}.`;
            feedbackEl.className = 'warn';
        }
    } else {
        // Spray mode: try this one password across every unlocked account
        let anySuccess = false;
        accounts.forEach(acc => {
            const now = Date.now();
            if (acc.locked && now >= acc.lockUntil) { acc.locked = false; acc.attempts = 0; }
            if (acc.locked) return;
            if (pw === acc.password) {
                anySuccess = true;
                addLog(`Spray attempt on ${acc.username}: SUCCESS`, 'success');
            } else {
                acc.attempts += 1;
                addLog(`Spray attempt on ${acc.username}: FAILED (${acc.attempts}/${LOCKOUT_THRESHOLD})`, 'fail');
                if (acc.attempts >= LOCKOUT_THRESHOLD) {
                    acc.locked = true;
                    acc.lockUntil = now + LOCKOUT_DURATION_MS;
                    lockoutCount += 1;
                    document.getElementById('lockout-count').textContent = lockoutCount;
                    addLog(`${acc.username} is now LOCKED for 30 seconds`, 'lock');
                }
            }
        });
        if (anySuccess) {
            const acc = accounts.find(a => a.password === pw);
            handleSuccess(acc);
            return;
        } else {
            feedbackEl.textContent = 'No account matched this password. Try another common password across all accounts.';
            feedbackEl.className = 'warn';
        }
    }

    renderAccounts();
    document.getElementById('password-input').value = '';
}

function handleSuccess(acc) {
    addLog(`Authentication successful on ${acc.username}`, 'success');
    renderAccounts();
    document.getElementById('password-input').value = '';

    if (currentMode === 'spray' && lockoutCount <= 1) {
        feedbackEl.textContent = `Access gained on ${acc.username} while staying under the lockout radar.`;
        feedbackEl.className = 'ok';
        revealFlag();
    } else if (currentMode === 'brute') {
        feedbackEl.textContent = `Access gained on ${acc.username}, but brute forcing a single account this way would normally trigger a lockout and an alert long before success. Try credential spraying instead to avoid detection.`;
        feedbackEl.className = 'warn';
    } else {
        feedbackEl.textContent = `Access gained on ${acc.username}, but too many lockouts were triggered along the way. Real engagements require staying under the radar. Try again with fewer failed attempts before spraying the right password.`;
        feedbackEl.className = 'warn';
    }
}

function revealFlag() {
    if (flagRevealed) return;
    flagRevealed = true;
    document.getElementById('flag-area').style.display = 'block';
    document.getElementById('flag-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// ===== TUTORIAL SYSTEM =====
const tutorialSteps = [
    { targetId: 'mode-toggle', text: 'This switch lets you choose between Brute Force, trying many passwords on one account, and Credential Spray, trying one password across many accounts.' },
    { targetId: 'lockout-meter', text: 'This shows how many failed attempts remain before an account locks. Real systems use this exact mechanism to slow down attackers.' },
    { targetId: 'username-panel', text: 'These are the accounts you can target. In a real engagement this list often comes from an earlier reconnaissance step.' },
    { targetId: 'attempt-log', text: 'Every login attempt appears here in real time, just like a defender watching authentication logs.' },
    { targetId: 'launch-attempt-btn', text: 'This button submits your current attempt. Watch how the lockout meter reacts differently depending on your mode.' },
];

let currentStep = 0;
const spotlightEl = document.getElementById('spotlight');
const tooltipEl = document.getElementById('tutorial-tooltip');
const tooltipTextEl = document.getElementById('tooltip-text');

function startTutorial() {
    currentStep = 0;
    document.getElementById('tutorial-modal-overlay').style.display = 'none';
    showStep(currentStep);
}

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    const step = tutorialSteps[index];
    const target = document.getElementById(step.targetId);
    if (!target) { nextTutorialStep(); return; }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => positionSpotlight(target, step.text), 300);
}

function positionSpotlight(target, text) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';
    spotlightEl.style.display = 'block';

    tooltipTextEl.textContent = text;
    tooltipEl.style.display = 'block';

    let top = rect.bottom + 16;
    let left = rect.left;
    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left + 280 > window.innerWidth) {
        left = window.innerWidth - 300;
    }
    if (left < 10) left = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function nextTutorialStep() {
    currentStep += 1;
    showStep(currentStep);
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    spotlightEl.style.display = 'none';
    tooltipEl.style.display = 'none';
    document.getElementById('tutorial-modal-overlay').style.display = 'flex';
}

function closeTutorialModal() {
    document.getElementById('tutorial-modal-overlay').style.display = 'none';
}

window.addEventListener('resize', () => {
    if (tooltipEl.style.display === 'block' && currentStep < tutorialSteps.length) {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target, step.text);
    }
});

// ===== INIT =====
renderAccounts();
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
