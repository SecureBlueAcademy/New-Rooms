<?php
// ============================================================
// devsecops-engineering-practical.php
// Pipeline Gate Simulator - standalone static practical
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pipeline Gate Simulator</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 24px 80px 24px;
}

/* ===== HEADER ===== */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}

.header-text h1 {
    margin: 0 0 6px 0;
    font-size: 1.9rem;
    font-weight: 700;
}

.header-text p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 1rem;
    max-width: 640px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION ===== */
.briefing-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 28px;
}
.briefing-box h2 {
    margin: 0 0 10px 0;
    font-size: 1.1rem;
    color: var(--accent-primary);
}
.briefing-box p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.briefing-box p:last-child { margin-bottom: 0; }

/* ===== MAIN ENVIRONMENT ===== */
.panels-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 18px;
    margin-bottom: 28px;
}

.scanner-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px;
}

.scanner-panel h3 {
    margin: 0 0 4px 0;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.scanner-panel .panel-sub {
    margin: 0 0 14px 0;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.finding {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
}
.finding:last-child { margin-bottom: 0; }

.finding-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
}

.finding-name {
    font-size: 0.88rem;
    font-weight: 500;
}

.sev-badge {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 5px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    white-space: nowrap;
}
.sev-critical { background: rgba(255,92,92,0.15); color: var(--error); }
.sev-high     { background: rgba(255,211,106,0.15); color: var(--warning); }
.sev-medium   { background: rgba(139,123,255,0.18); color: var(--accent-secondary); }
.sev-low      { background: rgba(122,131,182,0.18); color: var(--text-muted); }

.finding-detail {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 8px;
}

.finding-status {
    font-size: 0.78rem;
    font-weight: 600;
}
.status-open { color: var(--error); }
.status-resolved { color: var(--success); }
.status-logged { color: var(--text-muted); }

.remediate-btn {
    background: transparent;
    border: 1px solid var(--accent-secondary);
    color: var(--accent-secondary);
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.remediate-btn:hover {
    background: var(--accent-secondary);
    color: var(--bg-primary);
}
.remediate-btn:disabled {
    opacity: 0.4;
    cursor: default;
    border-color: var(--border-default);
    color: var(--text-muted);
}

/* ===== GATE CONFIG ===== */
.gate-config-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 20px;
}
.gate-config-section h3 {
    margin: 0 0 14px 0;
    font-size: 1.05rem;
}
.gate-options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.gate-option {
    flex: 1 1 220px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 16px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.gate-option:hover {
    border-color: var(--accent-primary);
}
.gate-option.selected {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
    background: rgba(106,227,255,0.06);
}
.gate-option .opt-title {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 4px;
}
.gate-option .opt-sub {
    font-size: 0.78rem;
    color: var(--text-muted);
}

.run-pipeline-btn {
    margin-top: 18px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    padding: 14px 28px;
    border-radius: 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.25s ease;
}
.run-pipeline-btn:hover {
    box-shadow: 0 0 26px rgba(106,227,255,0.35);
    transform: translateY(-2px);
}

/* ===== FEEDBACK / STATUS ===== */
.status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 20px;
    min-height: 60px;
}
.status-area h3 {
    margin: 0 0 12px 0;
    font-size: 1.05rem;
}
.status-message {
    font-size: 0.9rem;
    padding: 10px 14px;
    border-radius: 8px;
    margin-bottom: 8px;
}
.status-message:last-child { margin-bottom: 0; }
.status-message.pending { color: var(--text-muted); }
.status-message.fail { background: rgba(255,92,92,0.1); color: var(--error); }
.status-message.pass { background: rgba(61,255,154,0.1); color: var(--success); }

.pipeline-stages {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 14px;
}
.stage-chip {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 6px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-muted);
}
.stage-chip.active { color: var(--accent-primary); border-color: var(--accent-primary); }
.stage-chip.done { color: var(--success); border-color: var(--success); }

/* ===== FLAG REVEAL ===== */
.flag-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    display: none;
}
.flag-area.revealed {
    display: block;
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.flag-area h3 {
    color: var(--success);
    margin: 0 0 12px 0;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    border: 1px solid var(--success);
    letter-spacing: 0.03em;
}

/* ===== TUTORIAL SPOTLIGHT ===== */
.spotlight-box {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 9998;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: 0 0 20px rgba(106,227,255,0.2);
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 7px 14px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-muted);
}
.tooltip-actions .next-btn {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}
.tooltip-actions .next-btn:hover {
    background: var(--accent-primary);
    color: var(--bg-primary);
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
.modal-overlay.show { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 {
    margin: 0 0 12px 0;
    color: var(--accent-primary);
}
.modal-card p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 20px 0;
}
.modal-card button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    font-family: inherit;
    font-weight: 700;
    padding: 10px 24px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
}

@media (max-width: 640px) {
    .header-bar { flex-direction: column; }
    .tutorial-btn { align-self: flex-start; }
}
</style>
</head>
<body>

<div class="wrapper">

    <!-- 1. HEADER -->
    <div class="header-bar">
        <div class="header-text">
            <h1>Pipeline Gate Simulator</h1>
            <p>A build just ran against four security scanners. Configure a gate policy, remediate what matters, and get it deployed.</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn" onclick="startTutorial()">
            <span>🔄</span> View Tutorial
        </button>
    </div>

    <!-- 2. DESCRIPTION -->
    <div class="briefing-box">
        <h2>Mission Briefing</h2>
        <p>This environment represents a CI/CD pipeline dashboard right after a build has finished scanning. Four scanners have reported findings below: Secret Detection, SAST, SCA, and DAST.</p>
        <p>Your goal: review every finding, choose the gate threshold that blocks real risk without over blocking, remediate everything at or above that threshold, then run the pipeline. A correctly configured and remediated build will deploy successfully and reveal a flag.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="panels-grid">

        <div class="scanner-panel" id="secret-panel">
            <h3>🔑 Secret Detection</h3>
            <p class="panel-sub">Scans commits for hardcoded credentials</p>

            <div class="finding" data-severity="critical" data-id="s1">
                <div class="finding-top">
                    <span class="finding-name">Hardcoded AWS secret key</span>
                    <span class="sev-badge sev-critical">Critical</span>
                </div>
                <div class="finding-detail">deploy_config.py, line 14</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>

            <div class="finding" data-severity="low" data-id="s2">
                <div class="finding-top">
                    <span class="finding-name">Placeholder API key in test fixture</span>
                    <span class="sev-badge sev-low">Low</span>
                </div>
                <div class="finding-detail">mock_keys.py, line 3</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>
        </div>

        <div class="scanner-panel" id="sast-panel">
            <h3>🧩 SAST</h3>
            <p class="panel-sub">Reads source code for risky patterns</p>

            <div class="finding" data-severity="critical" data-id="s3">
                <div class="finding-top">
                    <span class="finding-name">SQL Injection</span>
                    <span class="sev-badge sev-critical">Critical</span>
                </div>
                <div class="finding-detail">user_search.php, line 41</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>

            <div class="finding" data-severity="high" data-id="s4">
                <div class="finding-top">
                    <span class="finding-name">MD5 used for password hashing</span>
                    <span class="sev-badge sev-high">High</span>
                </div>
                <div class="finding-detail">auth.py, line 88</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>
        </div>

        <div class="scanner-panel" id="sca-panel">
            <h3>📦 SCA</h3>
            <p class="panel-sub">Checks dependencies against CVE databases</p>

            <div class="finding" data-severity="high" data-id="s5">
                <div class="finding-top">
                    <span class="finding-name">requests==2.6.0 remote code execution</span>
                    <span class="sev-badge sev-high">High</span>
                </div>
                <div class="finding-detail">requirements.txt</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>

            <div class="finding" data-severity="low" data-id="s6">
                <div class="finding-top">
                    <span class="finding-name">flask-cors==3.0.0 CORS misconfiguration</span>
                    <span class="sev-badge sev-low">Low</span>
                </div>
                <div class="finding-detail">requirements.txt</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>
        </div>

        <div class="scanner-panel" id="dast-panel">
            <h3>🌐 DAST</h3>
            <p class="panel-sub">Attacks the running staging application</p>

            <div class="finding" data-severity="medium" data-id="s7">
                <div class="finding-top">
                    <span class="finding-name">Reflected XSS</span>
                    <span class="sev-badge sev-medium">Medium</span>
                </div>
                <div class="finding-detail">/search endpoint</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>

            <div class="finding" data-severity="medium" data-id="s8">
                <div class="finding-top">
                    <span class="finding-name">Missing HTTP security headers</span>
                    <span class="sev-badge sev-medium">Medium</span>
                </div>
                <div class="finding-detail">staging environment</div>
                <div class="finding-bottom" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="finding-status status-open">Open</span>
                    <button class="remediate-btn" onclick="remediate(this)">Remediate</button>
                </div>
            </div>
        </div>

    </div>

    <!-- GATE CONFIG -->
    <div class="gate-config-section" id="gate-config-section">
        <h3>Configure Gate Policy</h3>
        <div class="gate-options">
            <div class="gate-option" data-threshold="critical" onclick="selectGate(this)">
                <div class="opt-title">Block Critical only</div>
                <div class="opt-sub">Only stops deployment for the most severe findings</div>
            </div>
            <div class="gate-option" data-threshold="high" onclick="selectGate(this)">
                <div class="opt-title">Block Critical and High</div>
                <div class="opt-sub">Stops deployment for anything seriously exploitable</div>
            </div>
            <div class="gate-option" data-threshold="medium" onclick="selectGate(this)">
                <div class="opt-title">Block Medium and above</div>
                <div class="opt-sub">Stops deployment for almost everything found</div>
            </div>
        </div>
        <button class="run-pipeline-btn" id="run-pipeline-btn" onclick="runPipeline()">
            <span>▶</span> Run Pipeline
        </button>
    </div>

    <!-- 4. FEEDBACK / STATUS -->
    <div class="status-area">
        <h3>Pipeline Status</h3>
        <div id="statusMessages">
            <div class="status-message pending">Waiting for gate configuration and remediation.</div>
        </div>
        <div class="pipeline-stages" id="pipelineStages"></div>
    </div>

    <!-- 5. FLAG REVEAL -->
    <div class="flag-area" id="flagArea">
        <h3>Build Passed. Deployment Approved.</h3>
        <div class="flag-value">CBX{gate_secured}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight-box" id="spotlightBox" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <p id="tooltipText"></p>
    <div class="tooltip-actions">
        <button onclick="skipTutorial()">Skip Tutorial</button>
        <button class="next-btn" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<div class="modal-overlay" id="completeModal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Configure the gate, remediate the blocking findings, and run the pipeline.</p>
        <button onclick="closeModal()">Start Challenge</button>
    </div>
</div>

<script>
// ================= STATE =================
const findings = {
    s1: 'critical', s2: 'low',
    s3: 'critical', s4: 'high',
    s5: 'high', s6: 'low',
    s7: 'medium', s8: 'medium'
};
let resolvedIds = new Set();
let selectedThreshold = null;

function remediate(btn) {
    const findingEl = btn.closest('.finding');
    const statusEl = findingEl.querySelector('.finding-status');
    statusEl.textContent = 'Resolved';
    statusEl.classList.remove('status-open');
    statusEl.classList.add('status-resolved');
    btn.disabled = true;
    resolvedIds.add(findingEl.dataset.id);
}

function selectGate(el) {
    document.querySelectorAll('.gate-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    selectedThreshold = el.dataset.threshold;
}

function severityAtOrAbove(sev, threshold) {
    const order = { low: 0, medium: 1, high: 2, critical: 3 };
    const thresholdOrder = { critical: 3, high: 2, medium: 1 };
    return order[sev] >= thresholdOrder[threshold];
}

function runPipeline() {
    const statusBox = document.getElementById('statusMessages');
    const stagesBox = document.getElementById('pipelineStages');
    statusBox.innerHTML = '';
    stagesBox.innerHTML = '';

    if (!selectedThreshold) {
        statusBox.innerHTML = '<div class="status-message fail">No gate policy selected. Choose a threshold before running the pipeline.</div>';
        return;
    }

    // Findings that should block under this threshold and are still open
    const blocking = Object.keys(findings).filter(id =>
        severityAtOrAbove(findings[id], selectedThreshold) && !resolvedIds.has(id)
    );

    // Best practice check: threshold must be "high" (Critical and High)
    // and every critical/high finding must be resolved.
    const criticalHighIds = Object.keys(findings).filter(id => findings[id] === 'critical' || findings[id] === 'high');
    const allCriticalHighResolved = criticalHighIds.every(id => resolvedIds.has(id));

    const stages = ['Build', 'Secret Scan', 'SAST', 'SCA', 'DAST', 'Gate Check', 'Deploy'];
    stages.forEach((s, i) => {
        const chip = document.createElement('span');
        chip.className = 'stage-chip';
        chip.textContent = s;
        stagesBox.appendChild(chip);
    });

    if (blocking.length > 0) {
        statusBox.innerHTML = `<div class="status-message fail">Pipeline failed at Gate Check. ${blocking.length} finding(s) at or above your threshold are still unresolved.</div>`;
        [...stagesBox.children].forEach((chip, i) => {
            if (i < 5) chip.classList.add('done');
            else if (i === 5) chip.classList.add('active');
        });
        return;
    }

    if (selectedThreshold !== 'high' || !allCriticalHighResolved) {
        statusBox.innerHTML = '<div class="status-message fail">Pipeline failed at Gate Check. Your policy does not match best practice for this build. Reconsider which severities should block deployment.</div>';
        [...stagesBox.children].forEach((chip, i) => {
            if (i < 5) chip.classList.add('done');
            else if (i === 5) chip.classList.add('active');
        });
        return;
    }

    // Success
    [...stagesBox.children].forEach(chip => chip.classList.add('done'));
    statusBox.innerHTML = '<div class="status-message pass">All stages passed. Build deployed successfully.</div>';
    document.getElementById('flagArea').classList.add('revealed');
    document.getElementById('flagArea').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// ================= TUTORIAL =================
const tutorialSteps = [
    { id: 'secret-panel', text: 'This is your Secret Detection scanner. It works like a pre-commit hook, catching hardcoded credentials before they ever reach the repository.' },
    { id: 'sast-panel', text: 'This is your SAST scanner. It reads the source code itself, without running it, looking for risky patterns like injection flaws.' },
    { id: 'sca-panel', text: 'This is your SCA scanner. It checks every third-party package your app depends on against known vulnerability databases.' },
    { id: 'dast-panel', text: 'This is your DAST scanner. It attacks the running staging application the way a real attacker would, from the outside in.' },
    { id: 'gate-config-section', text: 'This is where you define your gate policy. Choose which severities are serious enough to block deployment.' },
    { id: 'run-pipeline-btn', text: 'Once your gate is configured and blocking findings are resolved, run the pipeline to see your policy in action.' }
];
let currentStep = -1;

function startTutorial() {
    currentStep = -1;
    nextTutorialStep();
}

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    const spotlight = document.getElementById('spotlightBox');
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    const tooltip = document.getElementById('tooltipCard');
    tooltip.style.display = 'block';
    let top = rect.bottom + 16;
    let left = rect.left;

    const tooltipWidth = 300;
    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 140 > window.innerHeight) {
        top = rect.top - 160;
    }
    if (top < 10) top = 10;
    if (left < 10) left = 10;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

function nextTutorialStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        showCompleteModal();
        return;
    }
    const step = tutorialSteps[currentStep];
    const el = document.getElementById(step.id);
    if (!el) { nextTutorialStep(); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    document.getElementById('tooltipText').textContent = step.text;

    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el), 320);
    } else {
        positionSpotlight(el);
    }
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    document.getElementById('spotlightBox').style.display = 'none';
    document.getElementById('tooltipCard').style.display = 'none';
}

function showCompleteModal() {
    document.getElementById('completeModal').classList.add('show');
}
function closeModal() {
    document.getElementById('completeModal').classList.remove('show');
}

window.addEventListener('resize', () => {
    if (currentStep >= 0 && currentStep < tutorialSteps.length) {
        const step = tutorialSteps[currentStep];
        const el = document.getElementById(step.id);
        if (el) positionSpotlight(el);
    }
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
