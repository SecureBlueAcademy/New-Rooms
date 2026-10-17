<?php
// ============================================================
// auth-session-attacks-practical.php
// Nexus Corp Login Portal — standalone practical
// Static HTML/CSS/JS only. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nexus Corp Login Portal</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.6;
}

.mono { font-family: 'JetBrains Mono', monospace; }

.page-wrap {
    max-width: 860px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== Header ===== */
header.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 25px;
}

header.top-header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}

header.top-header p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 560px;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* ===== Description ===== */
.description-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 30px;
}
.description-box h3 {
    margin-top: 0;
    font-size: 1rem;
    color: var(--text-primary);
}
.description-box p {
    color: var(--text-secondary);
    margin: 6px 0;
    font-size: 0.92rem;
}

/* ===== Panels ===== */
.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 28px;
    margin-bottom: 25px;
    display: none;
}
.panel.active { display: block; }

.panel h2 {
    margin-top: 0;
    font-size: 1.2rem;
    color: var(--text-primary);
}

/* ===== Login form ===== */
.field-group {
    margin-bottom: 16px;
}
.field-group label {
    display: block;
    font-size: 0.85rem;
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
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9rem;
}
.field-group input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

.btn-primary {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #06111c;
    border: none;
    padding: 12px 26px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: transform 0.2s ease;
}
.btn-primary:hover { transform: translateY(-1px); }

.helpdesk-note {
    background: var(--bg-surface);
    border: 1px dashed var(--warning);
    border-radius: 8px;
    padding: 14px 18px;
    margin-top: 22px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.helpdesk-note strong { color: var(--warning); }

/* ===== Dashboard ===== */
.dashboard-badge {
    display: inline-block;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 18px;
}
.dashboard-badge.admin { color: var(--success); border-color: var(--success); }

.debug-panel, .directory-panel, .token-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
}
.debug-panel h4, .directory-panel h4, .token-panel h4 {
    margin: 0 0 10px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.token-value {
    font-family: 'JetBrains Mono', monospace;
    background: var(--bg-primary);
    padding: 10px 14px;
    border-radius: 6px;
    color: var(--accent-primary);
    word-break: break-all;
    font-size: 0.9rem;
    border: 1px solid var(--border-default);
}

table.dir-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}
table.dir-table th, table.dir-table td {
    text-align: left;
    padding: 8px 10px;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-secondary);
}
table.dir-table th { color: var(--text-primary); }

.token-input-row {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}
.token-input-row input {
    flex: 1;
    padding: 11px 14px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
}

/* ===== Status / feedback ===== */
.status-msg {
    margin-top: 16px;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    display: none;
}
.status-msg.show { display: block; }
.status-msg.error { background: rgba(255,92,92,0.12); border: 1px solid var(--error); color: var(--error); }
.status-msg.success { background: rgba(61,255,154,0.12); border: 1px solid var(--success); color: var(--success); }

/* ===== Flag reveal ===== */
.flag-reveal {
    margin-top: 20px;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(106,227,255,0.05));
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px 24px;
    display: none;
}
.flag-reveal.show { display: block; }
.flag-reveal h4 {
    margin: 0 0 10px 0;
    color: var(--success);
    font-size: 0.95rem;
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    color: var(--success);
    background: var(--bg-primary);
    padding: 12px 16px;
    border-radius: 6px;
    display: inline-block;
}

/* ===== Tutorial spotlight ===== */
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
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: 0 0 20px rgba(106,227,255,0.25);
    z-index: 9999;
    font-size: 0.85rem;
    color: var(--text-primary);
}
.tutorial-tooltip .tt-buttons {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tutorial-tooltip button {
    background: var(--accent-primary);
    color: #06111c;
    border: none;
    padding: 7px 14px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.78rem;
    cursor: pointer;
}
.tutorial-tooltip button.skip-btn {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-default);
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-overlay.show { display: flex; }
.modal-card {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 {
    color: var(--accent-primary);
    margin-top: 0;
}
.modal-card p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}
</style>
</head>
<body>

<div class="page-wrap">

    <header class="top-header">
        <div>
            <h1>Nexus Corp Login Portal</h1>
            <p>Internal audit environment. A temporary account from an old testing phase may still be active.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </header>

    <div class="description-box">
        <h3>Mission Briefing</h3>
        <p>This environment simulates the Nexus Corp employee portal ahead of its public launch. You have been asked to find a way to reach the administrator console without ever knowing the administrator password.</p>
        <p>Look carefully at everything on screen. Notes, panels, and directories are all part of the audit.</p>
    </div>

    <!-- ===== LOGIN PANEL ===== -->
    <div class="panel active" id="panel-login">
        <h2>Employee Login</h2>
        <form id="login-form" onsubmit="handleLogin(event)">
            <div class="field-group">
                <label for="username">Username</label>
                <input type="text" id="username" autocomplete="off">
            </div>
            <div class="field-group">
                <label for="password">Password</label>
                <input type="text" id="password" autocomplete="off">
            </div>
            <button type="submit" class="btn-primary">Log In</button>
        </form>

        <div class="helpdesk-note" id="helpdesk-note">
            <strong>IT Help Desk Notes:</strong> Reminder, the temporary guest account for the intern batch still uses username <span class="mono">guest</span>, password <span class="mono">guest123</span>. Please rotate before go-live.
        </div>

        <div class="status-msg" id="login-status"></div>
    </div>

    <!-- ===== GUEST DASHBOARD PANEL ===== -->
    <div class="panel" id="panel-guest">
        <span class="dashboard-badge">Guest Portal Dashboard</span>
        <h2>Welcome, guest</h2>

        <div class="debug-panel" id="session-debug-panel">
            <h4>Session Debug Panel</h4>
            <p style="margin-top:0; color: var(--text-secondary); font-size: 0.85rem;">Your session token is a base64 encoded value in the format <span class="mono">username:id</span>.</p>
            <div class="token-value" id="current-token-display">Z3Vlc3Q6MTAy</div>
        </div>

        <div class="directory-panel" id="employee-directory">
            <h4>Employee Directory</h4>
            <table class="dir-table">
                <thead>
                    <tr><th>Username</th><th>Role</th><th>ID</th></tr>
                </thead>
                <tbody>
                    <tr><td>admin</td><td>System Administrator</td><td>1</td></tr>
                    <tr><td>jsmith</td><td>Sales</td><td>45</td></tr>
                    <tr><td>guest</td><td>Guest Account</td><td>102</td></tr>
                </tbody>
            </table>
        </div>

        <div class="token-panel" id="token-input">
            <h4>Session Token</h4>
            <div class="token-input-row">
                <input type="text" id="token-field" value="Z3Vlc3Q6MTAy">
                <button class="btn-primary" onclick="applyToken()">Apply Token</button>
            </div>
        </div>

        <div class="status-msg" id="token-status"></div>
    </div>

    <!-- ===== ADMIN DASHBOARD PANEL ===== -->
    <div class="panel" id="panel-admin">
        <span class="dashboard-badge admin">Nexus Corp Admin Console</span>
        <h2>Welcome, administrator</h2>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Your forged session token decoded to <span class="mono">admin:1</span>, and the system trusted it without ever checking a password.</p>

        <div class="flag-reveal show" id="flag-reveal">
            <h4>Access Granted</h4>
            <div class="flag-value">CBX{session_forged}</div>
        </div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight-box" id="spotlight-box" style="display:none;"></div>
<div class="tutorial-tooltip" id="tutorial-tooltip" style="display:none;"></div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button class="btn-primary" onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
// ===== Page navigation =====
function showPage(pageName) {
    document.getElementById('panel-login').classList.remove('active');
    document.getElementById('panel-guest').classList.remove('active');
    document.getElementById('panel-admin').classList.remove('active');
    document.getElementById('panel-' + pageName).classList.add('active');
}

// ===== Login handling =====
function handleLogin(e) {
    e.preventDefault();
    const u = document.getElementById('username').value.trim();
    const p = document.getElementById('password').value.trim();
    const statusEl = document.getElementById('login-status');

    if (u === 'guest' && p === 'guest123') {
        statusEl.className = 'status-msg';
        showPage('guest');
    } else {
        statusEl.textContent = 'Invalid username or password.';
        statusEl.className = 'status-msg error show';
    }
}

// ===== Token forging =====
function applyToken() {
    const tokenVal = document.getElementById('token-field').value.trim();
    const statusEl = document.getElementById('token-status');
    let decoded = '';
    try {
        decoded = atob(tokenVal);
    } catch (err) {
        statusEl.textContent = 'Invalid or unrecognized session.';
        statusEl.className = 'status-msg error show';
        return;
    }

    if (decoded === 'admin:1') {
        statusEl.className = 'status-msg';
        showPage('admin');
    } else {
        statusEl.textContent = 'Invalid or unrecognized session.';
        statusEl.className = 'status-msg error show';
    }
}

// ===== Tutorial system =====
const tutorialSteps = [
    {
        targetId: 'login-form',
        page: 'login',
        text: 'This is the Nexus Corp employee login. Try to find valid credentials before assuming you need to guess randomly.'
    },
    {
        targetId: 'helpdesk-note',
        page: 'login',
        text: 'IT teams sometimes leave notes like this behind. Always read what is on screen before attacking a login form directly.'
    },
    {
        targetId: 'session-debug-panel',
        page: 'guest',
        text: 'Once logged in, your session is represented by this token. Look closely at how it is built.'
    },
    {
        targetId: 'employee-directory',
        page: 'guest',
        text: 'This directory shows real internal user IDs. Sessions are often just usernames and IDs in disguise.'
    },
    {
        targetId: 'token-input',
        page: 'guest',
        text: 'This field lets you view and edit your active session token directly.'
    }
];

let currentStep = 0;
let tutorialActive = false;

function startTutorial() {
    currentStep = 0;
    tutorialActive = true;
    showTutorialStep();
}

function showTutorialStep() {
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }

    const step = tutorialSteps[currentStep];
    showPage(step.page);

    const target = document.getElementById(step.targetId);
    if (!target) {
        currentStep++;
        showTutorialStep();
        return;
    }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });

    setTimeout(() => {
        positionSpotlight(target);
        showTooltip(target, step.text);
    }, 300);
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    const box = document.getElementById('spotlight-box');
    box.style.display = 'block';
    box.style.top = (rect.top - pad) + 'px';
    box.style.left = (rect.left - pad) + 'px';
    box.style.width = (rect.width + pad * 2) + 'px';
    box.style.height = (rect.height + pad * 2) + 'px';
}

function showTooltip(target, text) {
    const rect = target.getBoundingClientRect();
    const tooltip = document.getElementById('tutorial-tooltip');
    tooltip.style.display = 'block';

    const isLast = currentStep === tutorialSteps.length - 1;
    tooltip.innerHTML = '<div>' + text + '</div>' +
        '<div class="tt-buttons">' +
        '<button class="skip-btn" onclick="endTutorial(false)">Skip Tutorial</button>' +
        '<button onclick="nextTutorialStep()">' + (isLast ? 'Finish' : 'Next') + '</button>' +
        '</div>';

    let top = rect.bottom + 16;
    let left = rect.left;

    const tw = 300;
    if (left + tw > window.innerWidth - 20) {
        left = window.innerWidth - tw - 20;
    }
    if (top + 150 > window.innerHeight) {
        top = rect.top - 160;
    }
    if (left < 20) left = 20;
    if (top < 20) top = 20;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

function nextTutorialStep() {
    currentStep++;
    showTutorialStep();
}

function endTutorial(completed) {
    tutorialActive = false;
    document.getElementById('spotlight-box').style.display = 'none';
    document.getElementById('tutorial-tooltip').style.display = 'none';
    showPage('login');
    if (completed) {
        document.getElementById('tutorial-complete-modal').classList.add('show');
    }
}

function closeTutorialModal() {
    document.getElementById('tutorial-complete-modal').classList.remove('show');
}

window.addEventListener('resize', () => {
    if (tutorialActive && currentStep < tutorialSteps.length) {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetId);
        if (target) {
            positionSpotlight(target);
            showTooltip(target, step.text);
        }
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
