<?php
// container-kubernetes-security-practical.php
// Standalone static practical: Pod Compliance Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pod Compliance Console</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    min-height: 100vh;
}

.page-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 20px 60px 20px;
}

/* Header */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.header-bar h1 {
    font-size: 1.6rem;
    margin: 0 0 6px 0;
}
.header-bar .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
    margin: 0;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* Description section */
.brief-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 24px;
}
.brief-box h2 {
    font-size: 1.05rem;
    margin: 0 0 8px 0;
}
.brief-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.55;
    margin: 0 0 8px 0;
}
.brief-box p:last-child { margin-bottom: 0; }

/* Status bar */
.status-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 22px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.progress-meter {
    display: flex;
    align-items: center;
    gap: 12px;
}
.progress-track {
    width: 220px;
    height: 10px;
    background: rgba(255,255,255,0.06);
    border-radius: 6px;
    overflow: hidden;
}
.progress-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, var(--accent-secondary), var(--accent-primary));
    transition: width 0.4s ease;
}
.progress-label {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.admission-badge {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 6px;
    background: rgba(255,92,92,0.12);
    color: var(--error);
    border: 1px solid rgba(255,92,92,0.35);
    transition: all 0.4s ease;
}
.admission-badge.admitted {
    background: rgba(61,255,154,0.12);
    color: var(--success);
    border-color: rgba(61,255,154,0.4);
    box-shadow: 0 0 16px rgba(61,255,154,0.25);
}

/* Main split layout */
.main-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 900px) {
    .main-layout { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.panel h3 {
    font-size: 0.95rem;
    margin: 0 0 12px 0;
    color: var(--text-primary);
}

/* YAML pane */
#yaml-pane {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    line-height: 1.7;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    white-space: pre;
    overflow-x: auto;
    color: var(--text-secondary);
}
#yaml-pane .yaml-key { color: var(--accent-primary); }
#yaml-pane .yaml-val { color: var(--text-primary); }
#yaml-pane .yaml-bad { color: var(--error); }
#yaml-pane .yaml-good { color: var(--success); }
#yaml-pane .yaml-comment { color: var(--text-muted); }
.yaml-line {
    display: block;
    transition: background 0.5s ease;
}
.yaml-line.patched {
    background: rgba(61,255,154,0.08);
    border-radius: 4px;
}

/* Compliance checks */
.check-row {
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    background: var(--bg-primary);
}
.check-row:last-child { margin-bottom: 0; }
.check-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}
.check-name {
    font-size: 0.88rem;
    font-weight: 600;
}
.check-badge {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    background: rgba(255,92,92,0.12);
    color: var(--error);
    border: 1px solid rgba(255,92,92,0.35);
    white-space: nowrap;
}
.check-badge.pass {
    background: rgba(61,255,154,0.12);
    color: var(--success);
    border-color: rgba(61,255,154,0.4);
}
.check-current {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 6px;
}
.fix-btn {
    margin-top: 10px;
    background: rgba(139,123,255,0.12);
    border: 1px solid rgba(139,123,255,0.4);
    color: var(--accent-secondary);
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
}
.fix-btn:hover { box-shadow: 0 0 10px rgba(139,123,255,0.3); }
.fix-btn:disabled {
    opacity: 0.4;
    cursor: default;
}
.options-row {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 10px;
}
.option-btn {
    text-align: left;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.75rem;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: transform 0.15s ease;
}
.option-btn:hover { border-color: var(--accent-primary); }
.option-btn.shake {
    animation: shake 0.35s ease;
    border-color: var(--error);
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}
.hint-text {
    font-size: 0.75rem;
    color: var(--warning);
    margin-top: 6px;
    display: none;
}
.hint-text.show { display: block; }

/* Flag reveal */
.flag-panel {
    margin-top: 24px;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 24px;
    text-align: center;
    display: none;
    box-shadow: 0 0 24px rgba(61,255,154,0.15);
}
.flag-panel.show { display: block; }
.flag-panel h3 {
    color: var(--success);
    margin: 0 0 10px 0;
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.2rem;
    font-weight: 600;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 20px;
    display: inline-block;
    color: var(--success);
    letter-spacing: 0.03em;
}

/* Spotlight tutorial */
#spotlight-overlay {
    position: fixed;
    border-radius: 8px;
    pointer-events: none;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.35s ease;
    z-index: 9000;
    display: none;
}
#tutorial-tooltip {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9001;
    box-shadow: 0 0 20px rgba(106,227,255,0.25);
    display: none;
}
#tutorial-tooltip p {
    font-size: 0.82rem;
    color: var(--text-secondary);
    margin: 0 0 12px 0;
    line-height: 1.5;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tooltip-actions .next-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border-color: var(--accent-primary);
}

/* Completion modal */
#tutorial-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 9500;
    display: none;
    align-items: center;
    justify-content: center;
}
#tutorial-modal {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
#tutorial-modal h3 { margin-top: 0; }
#tutorial-modal p { color: var(--text-secondary); font-size: 0.9rem; }
#tutorial-modal button {
    margin-top: 10px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    font-family: inherit;
    font-weight: 700;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="header-bar">
        <div>
            <h1>Pod Compliance Console</h1>
            <p class="subtitle">payments-api-pod.yaml is pending admission review against the Restricted Pod Security Standard.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="brief-box">
        <h2>Mission Briefing</h2>
        <p>This console represents an admission control review for a pod specification about to be deployed. The pod on the left currently fails every security check required for production.</p>
        <p>Work through each check on the right. Click Fix, then choose the option that genuinely closes the security gap. The pod is admitted only once all six checks pass.</p>
    </div>

    <div class="status-bar">
        <div class="progress-meter">
            <div class="progress-track"><div class="progress-fill" id="progress-fill"></div></div>
            <span class="progress-label" id="progress-label">0/6 Checks Passed</span>
        </div>
        <div class="admission-badge" id="admission-badge">PENDING - Not Admitted</div>
    </div>

    <div class="main-layout">
        <div class="panel" id="yaml-panel">
            <h3>payments-api-pod.yaml</h3>
            <div id="yaml-pane"><span class="yaml-line"><span class="yaml-key">apiVersion:</span> <span class="yaml-val">v1</span></span><span class="yaml-line"><span class="yaml-key">kind:</span> <span class="yaml-val">Pod</span></span><span class="yaml-line"><span class="yaml-key">metadata:</span></span><span class="yaml-line">  <span class="yaml-key">name:</span> <span class="yaml-val">payments-api</span></span><span class="yaml-line"><span class="yaml-key">spec:</span></span><span class="yaml-line">  <span class="yaml-key">containers:</span></span><span class="yaml-line">    <span class="yaml-val">- name: payments-api</span></span><span class="yaml-line">      <span class="yaml-key">securityContext:</span></span><span class="yaml-line" id="yaml-privileged">        <span class="yaml-key">privileged:</span> <span class="yaml-bad">true</span></span><span class="yaml-line" id="yaml-nonroot">        <span class="yaml-comment">runAsNonRoot: (not set)</span></span><span class="yaml-line" id="yaml-readonly">        <span class="yaml-key">readOnlyRootFilesystem:</span> <span class="yaml-bad">false</span></span><span class="yaml-line" id="yaml-privesc">        <span class="yaml-key">allowPrivilegeEscalation:</span> <span class="yaml-bad">true</span></span><span class="yaml-line" id="yaml-caps">        <span class="yaml-comment">capabilities: (not dropped)</span></span><span class="yaml-line" id="yaml-seccomp">        <span class="yaml-comment">seccompProfile: (not set)</span></span></div>
        </div>

        <div class="panel" id="compliance-panel">
            <h3>Pod Security Standards Compliance Panel</h3>
            <div id="checks-container"></div>
        </div>
    </div>

    <div class="flag-panel" id="flag-panel">
        <h3>Pod Admitted</h3>
        <p style="color: var(--text-secondary); font-size: 0.85rem;">All six checks now pass the Restricted profile. Your flag:</p>
        <div class="flag-value">CBX{pod_admitted}</div>
    </div>

</div>

<div id="spotlight-overlay"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tooltip-skip">Skip Tutorial</button>
        <button id="tooltip-next" class="next-btn">Next</button>
    </div>
</div>

<div id="tutorial-modal-backdrop">
    <div id="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Work through the compliance panel to admit the pod.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ==========================================================
// Compliance check data
// ==========================================================
const checks = [
    {
        id: 'privileged',
        name: 'Privileged Mode',
        current: 'privileged: true',
        yamlTarget: 'yaml-privileged',
        correctHtml: '<span class="yaml-key">privileged:</span> <span class="yaml-good">false</span>',
        options: [
            { text: 'privileged: false', correct: true },
            { text: 'privileged: true', correct: false, hint: 'That leaves the setting unchanged. Privileged containers can access host devices directly. Is that appropriate here?' },
            { text: 'remove the field entirely', correct: false, hint: 'Removing the field leaves the default behavior in place, which is not guaranteed to be safe. Set it explicitly.' }
        ]
    },
    {
        id: 'nonroot',
        name: 'Run as Non-Root',
        current: 'runAsNonRoot: (not set)',
        yamlTarget: 'yaml-nonroot',
        correctHtml: '<span class="yaml-key">runAsNonRoot:</span> <span class="yaml-good">true</span>',
        options: [
            { text: 'runAsUser: 0', correct: false, hint: 'User ID 0 is root. This would force the container to run as root, not prevent it.' },
            { text: 'runAsNonRoot: true', correct: true },
            { text: 'runAsNonRoot: false', correct: false, hint: 'Setting this to false explicitly permits the container to run as root.' }
        ]
    },
    {
        id: 'readonly',
        name: 'Read-Only Root Filesystem',
        current: 'readOnlyRootFilesystem: false',
        yamlTarget: 'yaml-readonly',
        correctHtml: '<span class="yaml-key">readOnlyRootFilesystem:</span> <span class="yaml-good">true</span>',
        options: [
            { text: 'leave as false', correct: false, hint: 'This leaves the filesystem writable, which many forms of malware rely on to persist.' },
            { text: 'remove the field entirely', correct: false, hint: 'Removing the field does not guarantee the filesystem becomes read-only by default.' },
            { text: 'readOnlyRootFilesystem: true', correct: true }
        ]
    },
    {
        id: 'privesc',
        name: 'Privilege Escalation',
        current: 'allowPrivilegeEscalation: true',
        yamlTarget: 'yaml-privesc',
        correctHtml: '<span class="yaml-key">allowPrivilegeEscalation:</span> <span class="yaml-good">false</span>',
        options: [
            { text: 'leave as true', correct: false, hint: 'This still allows a process to gain more privileges than its parent process had.' },
            { text: 'leave the field unset', correct: false, hint: 'An unset field does not guarantee the safe default is applied. Set it explicitly.' },
            { text: 'allowPrivilegeEscalation: false', correct: true }
        ]
    },
    {
        id: 'caps',
        name: 'Linux Capabilities',
        current: 'capabilities: (not dropped)',
        yamlTarget: 'yaml-caps',
        correctHtml: '<span class="yaml-key">capabilities:</span> <span class="yaml-good">drop: ["ALL"]</span>',
        options: [
            { text: 'add: ["ALL"]', correct: false, hint: 'This grants every capability instead of removing them, which widens the attack surface.' },
            { text: 'drop: ["NET_ADMIN"] only', correct: false, hint: 'This drops one dangerous capability but leaves several others still available.' },
            { text: 'drop: ["ALL"]', correct: true }
        ]
    },
    {
        id: 'seccomp',
        name: 'Seccomp Profile',
        current: 'seccompProfile: (not set)',
        yamlTarget: 'yaml-seccomp',
        correctHtml: '<span class="yaml-key">seccompProfile:</span> <span class="yaml-good">{ type: RuntimeDefault }</span>',
        options: [
            { text: 'type: Unconfined', correct: false, hint: 'Unconfined disables seccomp filtering entirely, allowing any syscall.' },
            { text: 'leave unset', correct: false, hint: 'An unset seccomp profile does not apply the syscall filtering the Restricted profile requires.' },
            { text: 'type: RuntimeDefault', correct: true }
        ]
    }
];

let passedCount = 0;

function shuffle(arr) {
    const a = [...arr];
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

function renderChecks() {
    const container = document.getElementById('checks-container');
    container.innerHTML = '';
    checks.forEach(check => {
        const row = document.createElement('div');
        row.className = 'check-row';
        row.id = 'check-' + check.id;
        row.innerHTML = `
            <div class="check-top">
                <span class="check-name">${check.name}</span>
                <span class="check-badge" id="badge-${check.id}">Fail</span>
            </div>
            <div class="check-current">Current: ${check.current}</div>
            <button class="fix-btn" id="fixbtn-${check.id}">Fix</button>
            <div class="options-row" id="options-${check.id}" style="display:none;"></div>
            <div class="hint-text" id="hint-${check.id}"></div>
        `;
        container.appendChild(row);
    });

    checks.forEach(check => {
        document.getElementById('fixbtn-' + check.id).addEventListener('click', () => showOptions(check));
    });
}

function showOptions(check) {
    const optionsDiv = document.getElementById('options-' + check.id);
    document.getElementById('fixbtn-' + check.id).style.display = 'none';
    optionsDiv.style.display = 'flex';
    optionsDiv.innerHTML = '';
    const shuffled = shuffle(check.options);
    shuffled.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'option-btn';
        btn.textContent = opt.text;
        btn.addEventListener('click', () => handleOptionClick(check, opt, btn, optionsDiv));
        optionsDiv.appendChild(btn);
    });
}

function handleOptionClick(check, opt, btn, optionsDiv) {
    if (opt.correct) {
        document.getElementById('badge-' + check.id).textContent = 'Pass';
        document.getElementById('badge-' + check.id).classList.add('pass');
        optionsDiv.style.display = 'none';
        document.getElementById('hint-' + check.id).classList.remove('show');

        const yamlLine = document.getElementById(check.yamlTarget);
        yamlLine.innerHTML = check.correctHtml;
        yamlLine.classList.add('patched');

        passedCount++;
        updateProgress();
    } else {
        btn.classList.add('shake');
        setTimeout(() => btn.classList.remove('shake'), 350);
        const hintEl = document.getElementById('hint-' + check.id);
        hintEl.textContent = opt.hint;
        hintEl.classList.add('show');
    }
}

function updateProgress() {
    document.getElementById('progress-fill').style.width = (passedCount / checks.length * 100) + '%';
    document.getElementById('progress-label').textContent = passedCount + '/' + checks.length + ' Checks Passed';

    if (passedCount === checks.length) {
        const badge = document.getElementById('admission-badge');
        badge.textContent = 'ADMITTED';
        badge.classList.add('admitted');
        document.getElementById('flag-panel').classList.add('show');
    }
}

renderChecks();

// ==========================================================
// Spotlight Tutorial System
// ==========================================================
const tutorialSteps = [
    { targetId: 'yaml-panel', text: 'This is the pod specification currently being evaluated for admission. It starts non-compliant with the Restricted Pod Security Standard.' },
    { targetId: 'compliance-panel', text: 'Each row here is one security check the pod must pass before Kubernetes will admit it.' },
    { targetId: 'check-privileged', text: 'A failing check shows red. Privileged mode gives a container almost full access to the host, similar to handing out a master key.' },
    { targetId: 'fixbtn-privileged', text: 'Click Fix to see the possible values for this field. Choose the one that actually closes the gap, not just any change.' },
    { targetId: 'progress-fill', text: 'This tracks how many of the 6 checks currently pass. You need all 6 green to reach admission.' },
    { targetId: 'admission-badge', text: 'This flips from PENDING to ADMITTED only once every check passes. That is your signal the pod is ready for production.' },
    { targetId: 'view-tutorial-btn', text: 'You can replay this walkthrough anytime from here.' }
];

let currentStep = 0;
const overlay = document.getElementById('spotlight-overlay');
const tooltip = document.getElementById('tutorial-tooltip');
const tooltipText = document.getElementById('tooltip-text');

function positionSpotlight(targetId) {
    const el = document.getElementById(targetId);
    if (!el) { advanceStep(); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const doPosition = () => {
        const r = el.getBoundingClientRect();
        const pad = 8;
        overlay.style.display = 'block';
        overlay.style.top = (r.top - pad) + 'px';
        overlay.style.left = (r.left - pad) + 'px';
        overlay.style.width = (r.width + pad * 2) + 'px';
        overlay.style.height = (r.height + pad * 2) + 'px';

        tooltip.style.display = 'block';
        let top = r.bottom + 16;
        let left = r.left;
        if (top + 140 > window.innerHeight) top = r.top - 150;
        if (left + 280 > window.innerWidth) left = window.innerWidth - 300;
        if (left < 10) left = 10;
        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
    };

    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(doPosition, 300);
    } else {
        doPosition();
    }
}

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    currentStep = index;
    const step = tutorialSteps[index];
    tooltipText.textContent = step.text;
    positionSpotlight(step.targetId);
}

function advanceStep() {
    showStep(currentStep + 1);
}

function endTutorial(completed) {
    overlay.style.display = 'none';
    tooltip.style.display = 'none';
    if (completed) {
        document.getElementById('tutorial-modal-backdrop').style.display = 'flex';
    }
}

document.getElementById('tooltip-next').addEventListener('click', advanceStep);
document.getElementById('tooltip-skip').addEventListener('click', () => endTutorial(false));
document.getElementById('view-tutorial-btn').addEventListener('click', () => showStep(0));
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-modal-backdrop').style.display = 'none';
});

window.addEventListener('resize', () => {
    if (overlay.style.display === 'block') {
        positionSpotlight(tutorialSteps[currentStep].targetId);
    }
});

window.addEventListener('load', () => {
    showStep(0);
});
</script>

</body>
</html>
