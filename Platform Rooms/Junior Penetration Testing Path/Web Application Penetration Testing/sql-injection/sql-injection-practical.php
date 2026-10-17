<?php
// Filename: sql-injection-practical.php
// Standalone static HTML/CSS/JS practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meridian Employee Portal</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 20px;
}

.page-wrap {
    max-width: 920px;
    margin: 0 auto;
    position: relative;
}

.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    padding: 24px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 14px;
    margin-bottom: 20px;
}

.top-header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
    color: var(--accent-primary);
}

.top-header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    background: rgba(106,227,255,0.08);
}

.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 20px;
}
.description-section h2 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--text-primary);
}
.description-section p {
    color: var(--text-secondary);
    font-size: 0.92rem;
    line-height: 1.6;
    margin: 8px 0;
}

.stage-progress {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}
.stage-pill {
    flex: 1;
    text-align: center;
    padding: 10px;
    border-radius: 8px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 600;
    transition: all 0.3s ease;
}
.stage-pill.active {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.stage-pill.done {
    border-color: var(--success);
    color: var(--success);
}

.environment {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 14px;
    padding: 24px;
    margin-bottom: 20px;
}

.stage-block {
    display: none;
    animation: none;
}
.stage-block.visible {
    display: block;
}

.stage-block h3 {
    margin-top: 0;
    color: var(--text-primary);
    font-size: 1.05rem;
}
.stage-hint {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 16px;
}

.field-group {
    margin-bottom: 14px;
}
.field-group label {
    display: block;
    font-size: 0.82rem;
    color: var(--text-secondary);
    margin-bottom: 6px;
}
.field-group input {
    width: 100%;
    padding: 11px 14px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    color: var(--text-primary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.9rem;
}
.field-group input:focus {
    outline: none;
    border-color: var(--accent-primary);
}

.submit-btn {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #0b0f1a;
    border: none;
    padding: 11px 22px;
    border-radius: 8px;
    font-weight: 700;
    font-family: inherit;
    font-size: 0.9rem;
    cursor: pointer;
    margin-top: 4px;
}
.submit-btn:hover {
    filter: brightness(1.08);
}

.response-panel {
    margin-top: 18px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    min-height: 48px;
    white-space: pre-wrap;
    word-break: break-word;
}
.response-panel.empty { color: var(--text-muted); }
.response-panel.success { color: var(--success); border-color: var(--success); }
.response-panel.error { color: var(--warning); border-color: var(--warning); }

.session-panel {
    margin-top: 18px;
    padding: 16px;
    border-radius: 8px;
    border: 2px solid var(--border-default);
    background: var(--bg-primary);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.session-panel.true-state {
    border-color: var(--success);
    box-shadow: 0 0 16px rgba(61,255,154,0.25);
    color: var(--success);
}
.session-panel.false-state {
    border-color: var(--error);
    box-shadow: 0 0 16px rgba(255,92,92,0.25);
    color: var(--error);
}

.flag-area {
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    display: none;
}
.flag-area.revealed { display: block; }
.flag-area h2 {
    color: var(--success);
    margin-top: 0;
}
.flag-value {
    display: inline-block;
    margin-top: 10px;
    padding: 14px 28px;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    color: var(--success);
    letter-spacing: 0.03em;
}

/* Spotlight tutorial */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
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
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-primary);
    line-height: 1.5;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    padding: 7px 14px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
}
.btn-skip {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default) !important;
}
.btn-next {
    background: var(--accent-primary);
    color: #0b0f1a;
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
.modal-overlay.visible { display: flex; }
.modal-card {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 { color: var(--accent-primary); margin-top: 0; }
.modal-card p { color: var(--text-secondary); font-size: 0.9rem; }
.modal-card button {
    margin-top: 10px;
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #0b0f1a;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="top-header">
        <div>
            <h1>Meridian Employee Portal</h1>
            <p>A simulated internal login system for Meridian Logistics. Something in this system does not validate input the way it should.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </div>

    <div class="description-section">
        <h2>Your Objective</h2>
        <p>This environment represents an employee login portal with three separate SQL injection weaknesses. Work through each stage in order: bypass the login, force a database error to leak information, then confirm a true condition on the admin session check.</p>
        <p>Nothing here is a real database. All responses are simulated in your browser to demonstrate exactly how a vulnerable backend would behave.</p>
    </div>

    <div class="stage-progress" id="stage-progress-indicator">
        <div class="stage-pill active" id="pill-1">1. Login Bypass</div>
        <div class="stage-pill" id="pill-2">2. Error Leak</div>
        <div class="stage-pill" id="pill-3">3. Session Check</div>
    </div>

    <div class="environment">

        <!-- STAGE 1 -->
        <div class="stage-block visible" id="stage-1">
            <h3>Stage 1: Authentication Bypass</h3>
            <p class="stage-hint">The login query is built by joining your input directly into the SQL text. Try breaking out of the intended query logic in the username field.</p>

            <div class="field-group">
                <label for="username-field">Username</label>
                <input type="text" id="username-field" placeholder="Enter username" autocomplete="off">
            </div>
            <div class="field-group">
                <label for="password-field">Password</label>
                <input type="text" id="password-field" placeholder="Enter password" autocomplete="off">
            </div>
            <button class="submit-btn" id="login-submit-btn" onclick="attemptLogin()">Log In</button>

            <div class="response-panel empty" id="server-response-panel">Server response will appear here.</div>
        </div>

        <!-- STAGE 2 -->
        <div class="stage-block" id="stage-2">
            <h3>Stage 2: Error-Based Leak</h3>
            <p class="stage-hint">This employee search field also builds its query by concatenation. Submit input that breaks the query syntax to force a verbose error.</p>

            <div class="field-group">
                <label for="search-field">Search Employee Records</label>
                <input type="text" id="search-field" placeholder="Enter a search term" autocomplete="off">
            </div>
            <button class="submit-btn" onclick="attemptSearch()">Search</button>

            <div class="response-panel empty" id="search-response-panel">Server response will appear here.</div>
        </div>

        <!-- STAGE 3 -->
        <div class="stage-block" id="stage-3">
            <h3>Stage 3: Blind Session Verification</h3>
            <p class="stage-hint">This session check gives no error text, only a visual state change. Submit a condition and watch the panel below react.</p>

            <div class="field-group">
                <label for="session-field">Verify Admin Session</label>
                <input type="text" id="session-field" placeholder="' AND 1=1 -- " autocomplete="off">
            </div>
            <button class="submit-btn" onclick="attemptSession()">Verify</button>

            <div class="session-panel" id="session-response-panel">Awaiting condition...</div>
        </div>

    </div>

    <div class="flag-area" id="flag-area">
        <h2>Admin Dashboard Unlocked</h2>
        <p>All three stages confirmed. The following flag was retrieved from the compromised session:</p>
        <div class="flag-value">CBX{database_compromised}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight-box" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button class="btn-skip" onclick="skipTutorial()">Skip Tutorial</button>
        <button class="btn-next" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Work through each stage in order to reach the flag.</p>
        <button onclick="closeCompleteModal()">Start Challenge</button>
    </div>
</div>

<script>
let stageComplete = { 1: false, 2: false, 3: false };

function setPillState(stageNum, state) {
    const pill = document.getElementById('pill-' + stageNum);
    pill.classList.remove('active', 'done');
    if (state) pill.classList.add(state);
}

function goToStage(stageNum) {
    document.querySelectorAll('.stage-block').forEach(el => el.classList.remove('visible'));
    document.getElementById('stage-' + stageNum).classList.add('visible');
    for (let i = 1; i <= 3; i++) {
        if (stageComplete[i]) setPillState(i, 'done');
        else if (i === stageNum) setPillState(i, 'active');
        else setPillState(i, null);
    }
}

function attemptLogin() {
    const user = document.getElementById('username-field').value;
    const panel = document.getElementById('server-response-panel');
    const pattern = /'.*(\bor\b).*'.*=.*'/i;
    if (pattern.test(user) || /'\s*or\s*1\s*=\s*1/i.test(user) || /'--/.test(user) || /'\s*or\s*'1'\s*=\s*'1/i.test(user)) {
        panel.textContent = 'ACCESS GRANTED. Welcome, admin.\nThe WHERE clause evaluated to true regardless of the password.';
        panel.className = 'response-panel success';
        stageComplete[1] = true;
        setTimeout(() => goToStage(2), 900);
    } else {
        panel.textContent = 'ACCESS DENIED. Invalid username or password.';
        panel.className = 'response-panel error';
    }
}

function attemptSearch() {
    const term = document.getElementById('search-field').value;
    const panel = document.getElementById('search-response-panel');
    if (term.includes("'") && !term.includes("--")) {
        panel.textContent = 'SQL Error: unterminated quoted string near "\'" in query on database "meridian_hr"';
        panel.className = 'response-panel error';
        stageComplete[2] = true;
        setTimeout(() => goToStage(3), 1200);
    } else {
        panel.textContent = 'No records found matching "' + term + '".';
        panel.className = 'response-panel empty';
    }
}

function attemptSession() {
    const cond = document.getElementById('session-field').value.toLowerCase().replace(/\s+/g, '');
    const panel = document.getElementById('session-response-panel');
    const trueMatch = cond.includes("1=1") || cond.includes("'or'1'='1");
    const falseMatch = cond.includes("1=2");

    if (trueMatch) {
        panel.textContent = 'SESSION STATE: TRUE (green)';
        panel.className = 'session-panel true-state';
        stageComplete[3] = true;
        setPillState(3, 'done');
        setTimeout(revealFlag, 900);
    } else if (falseMatch) {
        panel.textContent = 'SESSION STATE: FALSE (red)';
        panel.className = 'session-panel false-state';
    } else {
        panel.textContent = 'No recognizable condition submitted.';
        panel.className = 'session-panel';
    }
}

function revealFlag() {
    document.getElementById('flag-area').classList.add('revealed');
    document.getElementById('flag-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// ===================== Tutorial System =====================
const tutorialSteps = [
    { id: 'username-field', text: 'This is the username field. Real login forms insert whatever you type directly into a database query behind the scenes.' },
    { id: 'password-field', text: 'The password field works the same way. If input is not sanitized, both fields can be exploited.' },
    { id: 'login-submit-btn', text: 'Submit your payload here. Watch the Server Response panel to see how the backend reacts.' },
    { id: 'server-response-panel', text: 'This panel simulates what the real database would return. Error messages here can leak sensitive information.' },
    { id: 'stage-progress-indicator', text: 'Track your progress through the three attack stages here. Each stage unlocks the next.' },
    { id: 'view-tutorial-btn', text: 'You can replay this tutorial anytime from this button.' },
];
let currentStep = 0;
let tutorialActive = false;

function startTutorial() {
    currentStep = 0;
    tutorialActive = true;
    goToStage(1);
    showStep();
    window.addEventListener('resize', repositionCurrentStep);
}

function showStep() {
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    const step = tutorialSteps[currentStep];
    const el = document.getElementById(step.id);
    if (!el) { currentStep++; showStep(); return; }

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => positionSpotlight(el, step.text), 320);
}

function positionSpotlight(el, text) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    const spotlight = document.getElementById('spotlight');
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    const tooltip = document.getElementById('tooltip-card');
    const tooltipText = document.getElementById('tooltip-text');
    tooltipText.textContent = text;
    tooltip.style.display = 'block';

    const tooltipRect = tooltip.getBoundingClientRect();
    let top = rect.bottom + 16;
    let left = rect.left;

    if (top + tooltipRect.height > window.innerHeight) {
        top = rect.top - tooltipRect.height - 16;
    }
    if (left + tooltipRect.width > window.innerWidth) {
        left = window.innerWidth - tooltipRect.width - 20;
    }
    if (left < 10) left = 10;
    if (top < 10) top = 10;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';

    window._lastTutorialTarget = el;
    window._lastTutorialText = text;
}

function repositionCurrentStep() {
    if (tutorialActive && window._lastTutorialTarget) {
        positionSpotlight(window._lastTutorialTarget, window._lastTutorialText);
    }
}

function nextTutorialStep() {
    currentStep++;
    showStep();
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    tutorialActive = false;
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tooltip-card').style.display = 'none';
    window.removeEventListener('resize', repositionCurrentStep);
    document.getElementById('complete-modal').classList.add('visible');
}

function closeCompleteModal() {
    document.getElementById('complete-modal').classList.remove('visible');
}

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
