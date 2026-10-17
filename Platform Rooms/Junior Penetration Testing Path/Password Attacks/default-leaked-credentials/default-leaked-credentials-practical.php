<?php
// ============================================================
// default-leaked-credentials-practical.php
// Standalone practical simulation: Network Access Panel
// Static HTML/CSS/JS only. No backend logic, no database.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Network Access Panel</title>
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

    * { box-sizing: border-box; }

    body {
        margin: 0;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        min-height: 100vh;
        padding: 30px 20px 60px 20px;
    }

    .wrapper {
        max-width: 1000px;
        margin: 0 auto;
        position: relative;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 10px;
    }
    .header h1 {
        font-size: 1.8rem;
        margin: 0 0 6px 0;
    }
    .header p {
        color: var(--text-secondary);
        margin: 0;
        max-width: 600px;
    }

    .tutorial-btn {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        color: var(--accent-primary);
        padding: 10px 18px;
        border-radius: 8px;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    .tutorial-btn:hover { box-shadow: var(--glow-accent); }

    /* Description section */
    .description-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 20px 24px;
        margin: 24px 0;
    }
    .description-section h3 {
        margin-top: 0;
        font-size: 1.05rem;
        color: var(--accent-primary);
    }
    .description-section p {
        color: var(--text-secondary);
        margin: 6px 0;
    }

    /* Progress tracker */
    #progress-tracker {
        display: inline-block;
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 8px;
        padding: 10px 18px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.95rem;
        margin: 14px 0 24px 0;
        color: var(--accent-primary);
    }

    /* Device grid */
    .device-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }
    .device-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: border-color 0.2s ease, transform 0.15s ease;
    }
    .device-card:hover {
        border-color: var(--accent-primary);
        transform: translateY(-2px);
    }
    .device-card.granted {
        border-color: var(--success);
        background: rgba(61,255,154,0.06);
    }
    .device-icon { font-size: 1.6rem; margin-bottom: 8px; }
    .device-brand { font-weight: 700; font-size: 1.05rem; }
    .device-model { color: var(--text-secondary); font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; margin: 4px 0 12px 0; }
    .device-status {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        padding: 4px 10px;
        border-radius: 6px;
        background: rgba(255,255,255,0.06);
        color: var(--text-muted);
    }
    .device-card.granted .device-status {
        background: rgba(61,255,154,0.15);
        color: var(--success);
    }

    .shake {
        animation: shakeAnim 0.35s;
    }
    @keyframes shakeAnim {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-6px); }
        75% { transform: translateX(6px); }
    }

    /* Lookup tool */
    .lookup-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 22px 24px;
        margin-bottom: 30px;
    }
    .lookup-section h3 {
        margin-top: 0;
        color: var(--accent-secondary);
    }
    #lookup-search {
        width: 100%;
        padding: 12px 14px;
        border-radius: 8px;
        border: 1px solid var(--border-default);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.95rem;
        margin-bottom: 16px;
    }
    #lookup-search:focus { outline: none; border-color: var(--accent-primary); }

    table.lookup-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85rem;
    }
    table.lookup-table th, table.lookup-table td {
        padding: 8px 10px;
        text-align: left;
        border-bottom: 1px solid var(--border-default);
    }
    table.lookup-table th {
        color: var(--text-muted);
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    /* Login modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        z-index: 500;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .login-modal {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 28px;
        width: 340px;
        max-width: 90vw;
    }
    .login-modal h4 { margin-top: 0; }
    .login-modal input {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 12px;
        border-radius: 8px;
        border: 1px solid var(--border-default);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'JetBrains Mono', monospace;
    }
    .login-modal input:focus { outline: none; border-color: var(--accent-primary); }
    .modal-buttons { display: flex; gap: 10px; margin-top: 6px; }
    .modal-buttons button {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        border: none;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-submit { background: var(--accent-primary); color: #06121a; }
    .btn-cancel { background: transparent; border: 1px solid var(--border-default) !important; color: var(--text-secondary); }
    .modal-feedback { min-height: 20px; font-size: 0.85rem; margin-bottom: 8px; }
    .modal-feedback.error { color: var(--error); }
    .modal-feedback.success { color: var(--success); }

    /* Flag reveal */
    #flag-section {
        display: none;
        background: var(--bg-secondary);
        border: 1px solid var(--success);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        margin-top: 20px;
    }
    #flag-section.revealed { display: block; }
    #flag-section h3 { color: var(--success); margin-top: 0; }
    .flag-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.3rem;
        background: var(--bg-primary);
        border: 1px solid var(--success);
        border-radius: 8px;
        padding: 14px;
        display: inline-block;
        color: var(--success);
        letter-spacing: 0.02em;
    }

    /* Spotlight tutorial */
    .spotlight {
        position: fixed;
        border-radius: 10px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        z-index: 900;
        pointer-events: none;
        transition: all 0.25s ease;
    }
    .tooltip-card {
        position: fixed;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px 18px;
        max-width: 280px;
        z-index: 901;
        box-shadow: var(--glow-accent);
    }
    .tooltip-card p { color: var(--text-secondary); margin: 0 0 12px 0; font-size: 0.9rem; }
    .tooltip-actions { display: flex; justify-content: space-between; gap: 10px; }
    .tooltip-actions button {
        padding: 8px 14px;
        border-radius: 6px;
        border: none;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.85rem;
    }
    .tt-next { background: var(--accent-primary); color: #06121a; }
    .tt-skip { background: transparent; border: 1px solid var(--border-default) !important; color: var(--text-muted); }

    .tut-complete-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.75);
        z-index: 950;
        align-items: center;
        justify-content: center;
    }
    .tut-complete-overlay.active { display: flex; }
    .tut-complete-card {
        background: var(--bg-secondary);
        border: 1px solid var(--success);
        border-radius: 12px;
        padding: 30px;
        max-width: 360px;
        text-align: center;
    }
    .tut-complete-card button {
        margin-top: 16px;
        background: var(--success);
        color: #06121a;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-family: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .header { flex-direction: column; }
    }
</style>
</head>
<body>

<div class="wrapper">

    <!-- 1. Top header -->
    <div class="header">
        <div>
            <h1>Network Access Panel</h1>
            <p>A small office network with four devices still displaying their factory login screens.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. Description section -->
    <div class="description-section">
        <h3>Mission Briefing</h3>
        <p>This panel represents four devices on a simulated office network: a router, an IP camera, a printer, and a NAS box. None of them have had their factory login changed.</p>
        <p>Your goal is to use the Default Credential Lookup tool below to find the correct username and password for each device, then log in to all four. Once every device shows ACCESS GRANTED, the flag will appear.</p>
    </div>

    <div id="progress-tracker">0 / 4 Devices Accessed</div>

    <!-- 3. Main interactive environment -->
    <div class="device-grid" id="device-grid">
        <div class="device-card" id="device-card-router" data-device="router">
            <div class="device-icon">📡</div>
            <div class="device-brand">Trentix</div>
            <div class="device-model">R400 Router</div>
            <div class="device-status">DEFAULT LOGIN ACTIVE</div>
        </div>
        <div class="device-card" id="device-card-camera" data-device="camera">
            <div class="device-icon">📷</div>
            <div class="device-brand">ClearView</div>
            <div class="device-model">IPC-200 IP Camera</div>
            <div class="device-status">DEFAULT LOGIN ACTIVE</div>
        </div>
        <div class="device-card" id="device-card-printer" data-device="printer">
            <div class="device-icon">🖨️</div>
            <div class="device-brand">PrintMaster</div>
            <div class="device-model">LX-800 Printer</div>
            <div class="device-status">DEFAULT LOGIN ACTIVE</div>
        </div>
        <div class="device-card" id="device-card-nas" data-device="nas">
            <div class="device-icon">💾</div>
            <div class="device-brand">DataVault</div>
            <div class="device-model">NS-210 NAS</div>
            <div class="device-status">DEFAULT LOGIN ACTIVE</div>
        </div>
    </div>

    <div class="lookup-section">
        <h3>Default Credential Lookup</h3>
        <input type="text" id="lookup-search" placeholder="Search by brand or model, e.g. Trentix or R400">
        <table class="lookup-table" id="lookup-table">
            <thead>
                <tr><th>Brand</th><th>Model</th><th>Default Username</th><th>Default Password</th></tr>
            </thead>
            <tbody id="lookup-table-body"></tbody>
        </table>
    </div>

    <!-- 4. Feedback / status area (per-device feedback shown inside modal) -->

    <!-- 5. Flag reveal area -->
    <div id="flag-section">
        <h3>Access Panel Fully Compromised</h3>
        <p>All four devices were accessed using their factory default credentials.</p>
        <div class="flag-value" id="flag-value">CBX{credentials_exposed}</div>
    </div>

</div>

<!-- Login modal -->
<div class="modal-overlay" id="login-modal-overlay">
    <div class="login-modal" id="login-form">
        <h4 id="modal-device-title">Device Login</h4>
        <input type="text" id="modal-username" placeholder="Username">
        <input type="password" id="modal-password" placeholder="Password">
        <div class="modal-feedback" id="modal-feedback"></div>
        <div class="modal-buttons">
            <button class="btn-submit" id="modal-submit-btn">Log In</button>
            <button class="btn-cancel" id="modal-cancel-btn">Cancel</button>
        </div>
    </div>
</div>

<!-- Tutorial complete modal -->
<div class="tut-complete-overlay" id="tut-complete-overlay">
    <div class="tut-complete-card">
        <h3>Tutorial Complete</h3>
        <p style="color: var(--text-secondary);">You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA
// ============================================================
const lookupDatabase = [
    { brand: 'Trentix',    model: 'R400 Router',   username: 'admin', password: 'admin' },
    { brand: 'ClearView',  model: 'IPC-200',       username: 'root',  password: '12345' },
    { brand: 'PrintMaster',model: 'LX-800',        username: 'admin', password: '(blank)' },
    { brand: 'DataVault',  model: 'NS-210',        username: 'admin', password: 'datavault' },
    { brand: 'NetLync',    model: 'WR100',         username: 'admin', password: 'password' },
    { brand: 'SecuCam',    model: 'SC50',          username: 'root',  password: 'admin123' },
    { brand: 'OfficePro',  model: 'MFC-220',       username: 'admin', password: '(blank)' },
    { brand: 'Vantix',     model: 'VX-9 Router',   username: 'root',  password: 'vantix1' },
    { brand: 'Guardline',  model: 'GL-Cam4',       username: 'admin', password: 'guard4you' },
    { brand: 'Coldstore',  model: 'CS-NAS1',       username: 'admin', password: 'coldstore' },
    { brand: 'PixelWorks', model: 'PW-P100',       username: 'admin', password: 'pixel100' },
    { brand: 'Fenwick',    model: 'FW-R2',         username: 'admin', password: 'fenwick2' }
];

const devices = {
    router:  { username: 'admin', password: 'admin',      granted: false },
    camera:  { username: 'root',  password: '12345',      granted: false },
    printer: { username: 'admin', password: '(blank)',    granted: false },
    nas:     { username: 'admin', password: 'datavault',  granted: false }
};

const deviceTitles = {
    router:  'Trentix R400 Router Login',
    camera:  'ClearView IPC-200 Login',
    printer: 'PrintMaster LX-800 Login',
    nas:     'DataVault NS-210 Login'
};

let activeDevice = null;

// ============================================================
// LOOKUP TABLE RENDER + SEARCH
// ============================================================
function renderLookupTable(filter) {
    const tbody = document.getElementById('lookup-table-body');
    tbody.innerHTML = '';
    const term = (filter || '').toLowerCase();
    lookupDatabase
        .filter(row => row.brand.toLowerCase().includes(term) || row.model.toLowerCase().includes(term))
        .forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${row.brand}</td><td>${row.model}</td><td>${row.username}</td><td>${row.password}</td>`;
            tbody.appendChild(tr);
        });
}
renderLookupTable('');
document.getElementById('lookup-search').addEventListener('input', (e) => {
    renderLookupTable(e.target.value);
});

// ============================================================
// DEVICE CARD CLICK -> OPEN LOGIN MODAL
// ============================================================
document.querySelectorAll('.device-card').forEach(card => {
    card.addEventListener('click', () => {
        const key = card.getAttribute('data-device');
        if (devices[key].granted) return;
        activeDevice = key;
        document.getElementById('modal-device-title').textContent = deviceTitles[key];
        document.getElementById('modal-username').value = '';
        document.getElementById('modal-password').value = '';
        document.getElementById('modal-feedback').textContent = '';
        document.getElementById('modal-feedback').className = 'modal-feedback';
        document.getElementById('login-modal-overlay').classList.add('active');
    });
});

document.getElementById('modal-cancel-btn').addEventListener('click', () => {
    document.getElementById('login-modal-overlay').classList.remove('active');
});

document.getElementById('modal-submit-btn').addEventListener('click', () => {
    const uname = document.getElementById('modal-username').value.trim();
    const pass = document.getElementById('modal-password').value.trim();
    const correct = devices[activeDevice];
    const feedback = document.getElementById('modal-feedback');

    if (uname === correct.username && (pass === correct.password || (correct.password === '(blank)' && pass === ''))) {
        correct.granted = true;
        feedback.textContent = 'Access granted.';
        feedback.className = 'modal-feedback success';
        updateDeviceCard(activeDevice);
        updateProgress();
        setTimeout(() => {
            document.getElementById('login-modal-overlay').classList.remove('active');
        }, 700);
    } else {
        feedback.textContent = 'Access denied.';
        feedback.className = 'modal-feedback error';
        const modal = document.getElementById('login-form');
        modal.classList.remove('shake');
        void modal.offsetWidth;
        modal.classList.add('shake');
    }
});

function updateDeviceCard(key) {
    const card = document.getElementById('device-card-' + key);
    card.classList.add('granted');
    card.querySelector('.device-status').textContent = 'ACCESS GRANTED';
}

function updateProgress() {
    const grantedCount = Object.values(devices).filter(d => d.granted).length;
    document.getElementById('progress-tracker').textContent = grantedCount + ' / 4 Devices Accessed';
    if (grantedCount === 4) {
        document.getElementById('flag-section').classList.add('revealed');
    }
}

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetId: 'lookup-search',
        text: 'This is the Default Credential Lookup tool. Real world testers use databases exactly like this to find factory set logins for known device models.'
    },
    {
        targetId: 'device-card-router',
        text: 'Each device card shows the brand and model, just like the login banner on a real router or camera. Use this information to search the lookup tool.'
    },
    {
        targetId: 'progress-tracker',
        text: 'Track your progress here. You need to access all four devices to complete the challenge.'
    },
    {
        targetId: 'flag-section',
        text: 'Once all four devices are accessed, the flag will appear in this area.'
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
        <p id="tooltip-text"></p>
        <div class="tooltip-actions">
            <button class="tt-skip" id="tt-skip-btn">Skip Tutorial</button>
            <button class="tt-next" id="tt-next-btn">Next</button>
        </div>
    `;
    document.body.appendChild(tooltipEl);

    document.getElementById('tt-next-btn').addEventListener('click', nextTutorialStep);
    document.getElementById('tt-skip-btn').addEventListener('click', endTutorial);
}

function positionSpotlight(targetId) {
    const target = document.getElementById(targetId);
    if (!target) { nextTutorialStep(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const doPosition = () => {
        const r = target.getBoundingClientRect();
        const pad = 8;
        spotlightEl.style.top = (r.top - pad) + 'px';
        spotlightEl.style.left = (r.left - pad) + 'px';
        spotlightEl.style.width = (r.width + pad * 2) + 'px';
        spotlightEl.style.height = (r.height + pad * 2) + 'px';

        document.getElementById('tooltip-text').textContent =
            tutorialSteps[currentStep].text;

        let tooltipTop = r.bottom + 16;
        let tooltipLeft = r.left;
        if (tooltipTop + 140 > window.innerHeight) {
            tooltipTop = r.top - 150;
        }
        if (tooltipLeft + 300 > window.innerWidth) {
            tooltipLeft = window.innerWidth - 310;
        }
        if (tooltipLeft < 10) tooltipLeft = 10;

        tooltipEl.style.top = tooltipTop + 'px';
        tooltipEl.style.left = tooltipLeft + 'px';
    };

    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(doPosition, 300);
    } else {
        doPosition();
    }
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    positionSpotlight(tutorialSteps[currentStep].targetId);
}

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) createTutorialElements();
    spotlightEl.style.display = 'block';
    tooltipEl.style.display = 'block';
    positionSpotlight(tutorialSteps[0].targetId);
}

function endTutorial() {
    if (spotlightEl) spotlightEl.style.display = 'none';
    if (tooltipEl) tooltipEl.style.display = 'none';
    document.getElementById('tut-complete-overlay').classList.add('active');
}

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tut-complete-overlay').classList.remove('active');
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (spotlightEl && spotlightEl.style.display === 'block') {
        positionSpotlight(tutorialSteps[currentStep].targetId);
    }
});

// Auto start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
