<?php
// threat-modelling-practical.php
// Standalone static practical: Threat Register Builder (MedLink Patient Portal)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Threat Register Builder</title>
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
    line-height: 1.6;
}
.wrap { max-width: 1000px; margin: 0 auto; padding: 30px 20px 80px; }
header.top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 10px;
}
h1 { font-size: 1.7rem; margin: 0 0 6px 0; }
.subtitle { color: var(--text-secondary); font-size: 0.95rem; margin: 0; }
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }
.desc-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin: 20px 0 30px 0;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.desc-section strong { color: var(--text-primary); }
.stage {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 24px;
}
.stage h2 {
    font-size: 1.15rem;
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.stage-num {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-family: "JetBrains Mono", monospace;
}
.stage-desc { color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 16px; }

.component-row, .threat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 12px 14px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.component-row .name, .threat-row .name { font-weight: 500; flex: 1 1 220px; min-width: 200px; }
.threat-row .name { font-weight: 400; font-size: 0.9rem; }
select {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 8px 10px;
    font-family: inherit;
    font-size: 0.85rem;
}
.boundary-list label {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    margin-bottom: 8px;
    font-size: 0.9rem;
    cursor: pointer;
}
.boundary-list input { width: 16px; height: 16px; }

.register-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.register-card .info { flex: 1; font-size: 0.87rem; }
.register-card .il { color: var(--text-muted); font-family: "JetBrains Mono", monospace; font-size: 0.78rem; margin-top: 4px; }
.move-btns { display: flex; flex-direction: column; gap: 4px; }
.move-btns button {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    border-radius: 5px;
    width: 30px;
    height: 26px;
    cursor: pointer;
    font-size: 0.75rem;
}
.move-btns button:hover { box-shadow: var(--glow-accent); }

.verify-area { margin-top: 20px; text-align: center; }
.verify-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 14px 34px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}
.verify-btn:hover { box-shadow: var(--glow-accent); }

.status-area {
    margin-top: 18px;
    padding: 14px 18px;
    border-radius: 8px;
    font-size: 0.9rem;
    display: none;
}
.status-area.show { display: block; }
.status-area.error { background: rgba(255,92,92,0.08); border: 1px solid var(--error); color: var(--error); }
.status-area.success { background: rgba(61,255,154,0.08); border: 1px solid var(--success); color: var(--success); }

.flag-area {
    margin-top: 30px;
    padding: 24px;
    border-radius: 12px;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    text-align: center;
    display: none;
}
.flag-area.show { display: block; }
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.3rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 12px 22px;
    border-radius: 8px;
    margin-top: 10px;
    letter-spacing: 0.02em;
}

/* Spotlight tutorial */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.25s ease;
    pointer-events: none;
    z-index: 999;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 1000;
    font-size: 0.87rem;
    box-shadow: var(--glow-accent);
}
.tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
.tooltip-card button {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: inherit;
}
.tooltip-card button.primary { border-color: var(--accent-primary); color: var(--accent-primary); }

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1100;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin-top: 0; }
.modal-box button {
    margin-top: 16px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 26px;
    border-radius: 8px;
    font-size: 0.95rem;
    cursor: pointer;
    font-family: inherit;
}
</style>
</head>
<body>
<div class="wrap">

    <header class="top">
        <div>
            <h1>Threat Register Builder</h1>
            <p class="subtitle">MedLink Patient Portal &middot; Security Engineering Simulation</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </header>

    <div class="desc-section">
        <strong>Mission:</strong> MedLink is a patient portal built from six components. You have been brought in as the security engineer to threat model it end to end. Classify each component, mark the trust boundaries, assign a STRIDE category to each threat, and order the final register from highest risk to lowest. Verify your work to reveal the flag.
    </div>

    <!-- STAGE 1: Component Classification -->
    <div class="stage" id="stage1">
        <h2><span class="stage-num">1</span> Component Classification</h2>
        <p class="stage-desc">Classify each MedLink component as a Process, Data Store, or External Entity.</p>
        <div id="componentList"></div>
    </div>

    <!-- STAGE 2: Trust Boundaries -->
    <div class="stage" id="stage2">
        <h2><span class="stage-num">2</span> Trust Boundaries</h2>
        <p class="stage-desc">Check the three points where the level of trust actually changes between components.</p>
        <div class="boundary-list" id="boundaryList"></div>
    </div>

    <!-- STAGE 3: STRIDE Assignment -->
    <div class="stage" id="stage3">
        <h2><span class="stage-num">3</span> STRIDE Assignment</h2>
        <p class="stage-desc">Read each threat carefully and assign the correct STRIDE category.</p>
        <div id="threatList"></div>
    </div>

    <!-- STAGE 4: Risk Register -->
    <div class="stage" id="stage4">
        <h2><span class="stage-num">4</span> Risk Register</h2>
        <p class="stage-desc">Use the arrows to order the threats from highest risk score to lowest. Risk = Impact x Likelihood.</p>
        <div id="registerList"></div>
    </div>

    <div class="verify-area">
        <button class="verify-btn" id="verifyBtn">Verify Register</button>
    </div>

    <div class="status-area" id="statusArea"></div>

    <div class="flag-area" id="flagArea">
        <h3>Register Verified</h3>
        <p>Your threat model is complete and prioritised. Here is your flag:</p>
        <div class="flag-value">CBX{register_prioritized}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <div id="tooltipText"></div>
    <div class="tt-actions">
        <button id="skipBtn">Skip Tutorial</button>
        <button class="primary" id="nextBtn">Next</button>
    </div>
</div>

<div class="modal-overlay" id="completeModal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
// ================= DATA =================
const components = [
    { id: 'portal', name: 'Patient Web Portal', correct: 'process' },
    { id: 'gateway', name: 'API Gateway', correct: 'process' },
    { id: 'appt', name: 'Appointment Service', correct: 'process' },
    { id: 'db', name: 'Patient Records Database', correct: 'datastore' },
    { id: 'lab', name: 'Lab Results Integration', correct: 'external' },
    { id: 'admin', name: 'Admin Console', correct: 'process' },
];

const boundaries = [
    { id: 'b1', label: 'Internet to API Gateway', correct: true },
    { id: 'b2', label: 'API Gateway to Appointment Service', correct: false },
    { id: 'b3', label: 'Internal Network to Lab Results Integration', correct: true },
    { id: 'b4', label: 'Internal Network to Admin Console', correct: true },
    { id: 'b5', label: 'Appointment Service to Patient Records Database', correct: false },
    { id: 'b6', label: 'Patient Web Portal to API Gateway', correct: false },
];

const strideOptions = ['Spoofing', 'Tampering', 'Repudiation', 'Information Disclosure', 'Denial of Service', 'Elevation of Privilege'];

const threats = [
    { id: 't1', text: 'Attacker floods the API Gateway with requests, taking the portal offline during business hours.', category: 'Denial of Service', impact: 5, likelihood: 4 },
    { id: 't2', text: 'Attacker exploits an unpatched flaw in the Appointment Service to execute code and escalate privileges into the Records Database.', category: 'Elevation of Privilege', impact: 4, likelihood: 4 },
    { id: 't3', text: 'A privileged admin modifies patient records through the Admin Console and no log entry is created.', category: 'Repudiation', impact: 5, likelihood: 3 },
    { id: 't4', text: 'Attacker intercepts unencrypted traffic between the Patient Web Portal and API Gateway to steal login credentials.', category: 'Information Disclosure', impact: 4, likelihood: 3 },
    { id: 't5', text: 'Attacker tampers with lab result data in transit from the Lab Results Integration before it reaches the Records Database.', category: 'Tampering', impact: 5, likelihood: 2 },
    { id: 't6', text: 'Attacker registers a lookalike domain and phishes patients into entering credentials on a fake login page.', category: 'Spoofing', impact: 3, likelihood: 3 },
    { id: 't7', text: "Attacker uses a stolen session token to forge appointment requests as another patient.", category: 'Spoofing', impact: 2, likelihood: 3 },
    { id: 't8', text: "A low-privilege user queries the API Gateway directly and enumerates other patients' appointment records by guessing IDs.", category: 'Information Disclosure', impact: 2, likelihood: 2 },
];

// correct descending order by risk score (impact*likelihood): t1(20) t2(16) t3(15) t4(12) t5(10) t6(9) t7(6) t8(4)
const correctOrder = ['t1','t2','t3','t4','t5','t6','t7','t8'];

// ================= RENDER STAGE 1 =================
const componentList = document.getElementById('componentList');
components.forEach(c => {
    const row = document.createElement('div');
    row.className = 'component-row';
    row.id = 'comp-' + c.id;
    row.innerHTML = `
        <div class="name">${c.name}</div>
        <select data-id="${c.id}" class="comp-select">
            <option value="">Select classification</option>
            <option value="process">Process</option>
            <option value="datastore">Data Store</option>
            <option value="external">External Entity</option>
        </select>
    `;
    componentList.appendChild(row);
});

// ================= RENDER STAGE 2 =================
const boundaryList = document.getElementById('boundaryList');
boundaries.forEach(b => {
    const label = document.createElement('label');
    label.id = 'bound-' + b.id;
    label.innerHTML = `<input type="checkbox" data-id="${b.id}" class="bound-check"> ${b.label}`;
    boundaryList.appendChild(label);
});

// ================= RENDER STAGE 3 =================
const threatList = document.getElementById('threatList');
threats.forEach(t => {
    const row = document.createElement('div');
    row.className = 'threat-row';
    row.id = 'threat-' + t.id;
    const options = strideOptions.map(o => `<option value="${o}">${o}</option>`).join('');
    row.innerHTML = `
        <div class="name">${t.text}</div>
        <select data-id="${t.id}" class="stride-select">
            <option value="">Select category</option>
            ${options}
        </select>
    `;
    threatList.appendChild(row);
});

// ================= RENDER STAGE 4 (shuffled order) =================
let registerOrder = shuffle(threats.map(t => t.id));
function shuffle(arr) {
    const a = arr.slice();
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}
function renderRegister() {
    const registerList = document.getElementById('registerList');
    registerList.innerHTML = '';
    registerOrder.forEach((id, idx) => {
        const t = threats.find(x => x.id === id);
        const card = document.createElement('div');
        card.className = 'register-card';
        card.innerHTML = `
            <div class="move-btns">
                <button data-dir="up" data-id="${id}" ${idx === 0 ? 'disabled' : ''}>▲</button>
                <button data-dir="down" data-id="${id}" ${idx === registerOrder.length - 1 ? 'disabled' : ''}>▼</button>
            </div>
            <div class="info">
                ${t.text}
                <div class="il">Impact ${t.impact} &times; Likelihood ${t.likelihood}</div>
            </div>
        `;
        registerList.appendChild(card);
    });
    registerList.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const dir = btn.getAttribute('data-dir');
            const i = registerOrder.indexOf(id);
            if (dir === 'up' && i > 0) {
                [registerOrder[i - 1], registerOrder[i]] = [registerOrder[i], registerOrder[i - 1]];
            } else if (dir === 'down' && i < registerOrder.length - 1) {
                [registerOrder[i + 1], registerOrder[i]] = [registerOrder[i], registerOrder[i + 1]];
            }
            renderRegister();
        });
    });
}
renderRegister();

// ================= VERIFY =================
document.getElementById('verifyBtn').addEventListener('click', () => {
    const statusArea = document.getElementById('statusArea');
    const flagArea = document.getElementById('flagArea');
    const failures = [];

    // Stage 1 check
    let stage1ok = true;
    components.forEach(c => {
        const sel = document.querySelector(`.comp-select[data-id="${c.id}"]`);
        if (sel.value !== c.correct) stage1ok = false;
    });
    if (!stage1ok) failures.push('Component classification has one or more errors.');

    // Stage 2 check
    let stage2ok = true;
    boundaries.forEach(b => {
        const chk = document.querySelector(`.bound-check[data-id="${b.id}"]`);
        if (chk.checked !== b.correct) stage2ok = false;
    });
    if (!stage2ok) failures.push('Trust boundaries are not fully correct.');

    // Stage 3 check
    let stage3ok = true;
    threats.forEach(t => {
        const sel = document.querySelector(`.stride-select[data-id="${t.id}"]`);
        if (sel.value !== t.category) stage3ok = false;
    });
    if (!stage3ok) failures.push('One or more STRIDE assignments are incorrect.');

    // Stage 4 check
    const stage4ok = JSON.stringify(registerOrder) === JSON.stringify(correctOrder);
    if (!stage4ok) failures.push('Register order is not correctly prioritised by risk.');

    if (failures.length === 0) {
        statusArea.className = 'status-area show success';
        statusArea.textContent = 'All four stages verified. Register complete.';
        flagArea.classList.add('show');
        flagArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        statusArea.className = 'status-area show error';
        statusArea.textContent = failures.join(' ');
        flagArea.classList.remove('show');
    }
});

// ================= TUTORIAL SYSTEM =================
const tutorialSteps = [
    { target: 'stage1', text: 'This section lists every MedLink component. Classify each one as a Process, Data Store, or External Entity, the first step of any threat model.' },
    { target: 'stage2', text: 'A trust boundary is any point where trust changes, such as the internet meeting an internal network. Check only the boundaries that genuinely exist.' },
    { target: 'stage3', text: 'Each threat here is real. Read it carefully and assign the STRIDE category it belongs to using the dropdown.' },
    { target: 'stage4', text: 'Use the arrows to reorder these threats from highest risk score to lowest. Risk score is Impact multiplied by Likelihood, shown on each card.' },
    { target: 'verifyBtn', text: 'Once every stage is complete, click here to verify your full threat register and reveal your flag.' },
];
let currentStep = 0;
const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltipCard');
const tooltipText = document.getElementById('tooltipText');

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';
    spotlight.style.display = 'block';

    let top = rect.bottom + 14;
    let left = rect.left;
    if (top + 160 > window.innerHeight) top = rect.top - 170;
    if (left + 300 > window.innerWidth) left = window.innerWidth - 320;
    tooltipCard.style.top = top + 'px';
    tooltipCard.style.left = left + 'px';
    tooltipCard.style.display = 'block';
}

function showStep(i) {
    const step = tutorialSteps[i];
    const el = document.getElementById(step.target) || document.querySelector(`[id="${step.target}"]`) || document.getElementById(step.target);
    const targetEl = document.getElementById(step.target);
    tooltipText.textContent = step.text;
    document.getElementById('nextBtn').textContent = (i === tutorialSteps.length - 1) ? 'Finish' : 'Next';
    if (targetEl) {
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(targetEl), 300);
    }
}

function startTutorial() {
    currentStep = 0;
    showStep(currentStep);
}

document.getElementById('nextBtn').addEventListener('click', () => {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        document.getElementById('completeModal').classList.add('show');
    } else {
        showStep(currentStep);
    }
});

document.getElementById('skipBtn').addEventListener('click', endTutorial);

function endTutorial() {
    spotlight.style.display = 'none';
    tooltipCard.style.display = 'none';
}

document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('show');
});

document.getElementById('tutorialBtn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (spotlight.style.display === 'block') {
        const step = tutorialSteps[currentStep];
        const targetEl = document.getElementById(step.target);
        if (targetEl) positionSpotlight(targetEl);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
