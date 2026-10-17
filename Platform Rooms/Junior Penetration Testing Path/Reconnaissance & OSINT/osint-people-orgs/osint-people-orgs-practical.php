<?php
// ============================================================
// osint-people-orgs-practical.php
// Practical: The GitHub Leak Trail
// Standalone static HTML/CSS/JS practical. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The GitHub Leak Trail | CYBRIXEN</title>
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

code, .mono {
    font-family: "JetBrains Mono", monospace;
}

.wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 28px 20px 60px 20px;
    position: relative;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}
.header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
}
.header p.subtitle {
    color: var(--text-secondary);
    margin: 0;
    max-width: 640px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.tutorial-btn:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
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
    margin-top: 0;
    font-size: 1.05rem;
    color: var(--accent-primary);
}
.briefing p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

/* ===== MAIN LAYOUT ===== */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
}
@media (max-width: 860px) {
    .main-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
}
.panel h3 {
    margin-top: 0;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel h3 .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--accent-primary);
    display: inline-block;
}

/* Repo header */
.repo-title {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.05rem;
    color: var(--accent-primary);
}
.repo-meta {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 4px;
}

/* File tree */
.file-tree {
    list-style: none;
    padding: 0;
    margin: 10px 0 0 0;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.88rem;
}
.file-tree li {
    padding: 7px 10px;
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 8px;
}
.file-tree li:hover {
    background: var(--bg-surface);
    color: var(--text-primary);
}

/* Commit history */
.commit-list {
    list-style: none;
    padding: 0;
    margin: 10px 0 0 0;
}
.commit-item {
    padding: 10px 12px;
    border: 1px solid var(--border-default);
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: border-color 0.2s ease, background 0.2s ease;
}
.commit-item:hover {
    border-color: var(--accent-secondary);
    background: var(--bg-surface);
}
.commit-item.active {
    border-color: var(--accent-primary);
    background: var(--bg-surface);
}
.commit-item .commit-msg {
    font-weight: 600;
    font-size: 0.9rem;
}
.commit-item .commit-meta {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.78rem;
    color: var(--text-muted);
    margin-top: 3px;
}
.commit-item.flagged .commit-msg {
    color: var(--warning);
}

/* Diff viewer */
.diff-box {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    margin-top: 10px;
    white-space: pre-wrap;
    word-break: break-all;
    min-height: 60px;
}
.diff-removed {
    color: var(--error);
    text-decoration: line-through;
    display: block;
}
.diff-added {
    color: var(--success);
    display: block;
}
.diff-context {
    color: var(--text-muted);
    display: block;
}
.diff-placeholder {
    color: var(--text-muted);
    font-style: italic;
}

/* Profile card */
.profile-card {
    display: flex;
    gap: 14px;
    align-items: center;
    margin-top: 10px;
}
.profile-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: var(--bg-primary);
    flex-shrink: 0;
}
.profile-info .name {
    font-weight: 700;
    font-size: 1rem;
}
.profile-info .role {
    color: var(--text-secondary);
    font-size: 0.88rem;
}
.profile-info .meta {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-top: 4px;
}

/* Breach panel */
.breach-search {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}
.breach-search input {
    flex: 1;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 9px 12px;
    border-radius: 6px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
}
.breach-search button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 9px 16px;
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
}
.breach-result {
    margin-top: 12px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 0.87rem;
    display: none;
}
.breach-result.visible { display: block; }
.breach-result .label {
    color: var(--text-muted);
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.breach-result .value {
    font-family: "JetBrains Mono", monospace;
    color: var(--warning);
    margin-bottom: 8px;
}

/* Findings sidebar */
.findings-panel {
    position: sticky;
    top: 20px;
}
.findings-list {
    list-style: none;
    padding: 0;
    margin: 10px 0 0 0;
}
.findings-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid var(--border-default);
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.findings-list li:last-child { border-bottom: none; }
.check-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid var(--border-default);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: transparent;
    transition: all 0.25s ease;
}
.findings-list li.done .check-circle {
    background: var(--success);
    border-color: var(--success);
    color: var(--bg-primary);
}
.findings-list li.done { color: var(--text-primary); }

/* Status / feedback */
.status-area {
    text-align: center;
    color: var(--text-muted);
    font-size: 0.88rem;
    margin-top: 6px;
}

/* Flag reveal */
.flag-panel {
    margin-top: 20px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
    display: none;
}
.flag-panel.unlocked { display: block; }
.flag-panel h3 {
    margin-top: 0;
    color: var(--success);
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 12px 20px;
    display: inline-block;
    margin-top: 8px;
    color: var(--success);
    letter-spacing: 0.02em;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
.spotlight {
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
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
    transition: all 0.3s ease;
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.9rem;
    color: var(--text-secondary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}
.tooltip-actions .step-count {
    font-size: 0.78rem;
    color: var(--text-muted);
}
.tooltip-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 7px 16px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
}
.tooltip-skip {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 0.82rem;
    cursor: pointer;
    text-decoration: underline;
}

/* ===== MODAL ===== */
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
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-box h3 {
    margin-top: 0;
    color: var(--accent-primary);
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.modal-box button {
    margin-top: 10px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="wrapper">

    <!-- 1. HEADER -->
    <div class="header">
        <div>
            <h1>The GitHub Leak Trail</h1>
            <p class="subtitle">Investigate a public repository belonging to a Vantix Corp engineer and confirm what it exposed.</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This environment simulates a public GitHub repository belonging to a Vantix Corp DevOps engineer, along with two open source lookup tools: a professional profile card and a breach database search.</p>
        <p>Your goal is to trace a leaked secret back to its source, confirm the identity of the person who leaked it, and check whether their credentials have appeared in a known breach. Explore the repository, the profile, and the breach panel to build your case.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="main-grid">
        <div class="main-col">

            <!-- Repo Header -->
            <div class="panel" id="repoHeader">
                <h3><span class="dot"></span>Repository</h3>
                <div class="repo-title">dan-kowalski92 / vantix-infra-scripts</div>
                <div class="repo-meta">Internal deployment and infrastructure automation scripts &nbsp;|&nbsp; ★ 4 &nbsp;|&nbsp; ⑂ 1 &nbsp;|&nbsp; Public</div>
            </div>

            <!-- File Tree -->
            <div class="panel" id="fileTree">
                <h3><span class="dot"></span>Files</h3>
                <ul class="file-tree">
                    <li>📄 deploy.sh</li>
                    <li>📄 config.example.yml</li>
                    <li>📄 README.md</li>
                    <li>📄 .gitignore</li>
                </ul>
            </div>

            <!-- Commit History + Diff Viewer -->
            <div class="panel" id="commitHistory">
                <h3><span class="dot"></span>Commit History</h3>
                <ul class="commit-list">
                    <li class="commit-item" data-commit="1">
                        <div class="commit-msg">Initial commit</div>
                        <div class="commit-meta">a1c9e02 &nbsp;dan-kowalski92</div>
                    </li>
                    <li class="commit-item" data-commit="2">
                        <div class="commit-msg">Add deployment automation script</div>
                        <div class="commit-meta">f38b1d4 &nbsp;dan-kowalski92</div>
                    </li>
                    <li class="commit-item" data-commit="3">
                        <div class="commit-msg">Update README with setup instructions</div>
                        <div class="commit-meta">7e02aa9 &nbsp;dan-kowalski92</div>
                    </li>
                    <li class="commit-item flagged" data-commit="4">
                        <div class="commit-msg">Remove hardcoded credentials</div>
                        <div class="commit-meta">c94d701 &nbsp;dan-kowalski92</div>
                    </li>
                    <li class="commit-item" data-commit="5">
                        <div class="commit-msg">Fix typo in comments</div>
                        <div class="commit-meta">002fa3e &nbsp;dan-kowalski92</div>
                    </li>
                </ul>
                <div class="diff-box" id="diffBox">
                    <span class="diff-placeholder">Select a commit above to view its diff.</span>
                </div>
            </div>

            <!-- OSINT Profile Card -->
            <div class="panel" id="linkedinCard">
                <h3><span class="dot"></span>Public Profile Lookup</h3>
                <div class="profile-card">
                    <div class="profile-avatar">DK</div>
                    <div class="profile-info">
                        <div class="name">Daniel Kowalski</div>
                        <div class="role">DevOps Engineer at Vantix Corp</div>
                        <div class="meta">Austin, TX &nbsp;|&nbsp; Skills: AWS, Docker, Python, CI/CD</div>
                    </div>
                </div>
            </div>

            <!-- Breach Database Lookup -->
            <div class="panel" id="breachPanel">
                <h3><span class="dot"></span>Breach Database Lookup</h3>
                <div class="breach-search">
                    <input type="text" id="breachInput" class="mono" placeholder="Enter an email address to check...">
                    <button id="breachSearchBtn">Search</button>
                </div>
                <div class="breach-result" id="breachResult">
                    <div class="label">Breach Source</div>
                    <div class="value">DataStreamX 2022 Breach</div>
                    <div class="label">Exposed Password</div>
                    <div class="value">Vantix2022!</div>
                    <div class="label">Note</div>
                    <div class="value">Same password pattern observed reused across this user's known accounts.</div>
                </div>
                <div class="status-area" id="breachStatus"></div>
            </div>

        </div>

        <!-- Findings Sidebar -->
        <div>
            <div class="panel findings-panel">
                <h3><span class="dot"></span>Findings</h3>
                <ul class="findings-list" id="findingsList">
                    <li id="finding-key" data-key="key">
                        <span class="check-circle">✓</span>
                        Leaked API key found in commit diff
                    </li>
                    <li id="finding-identity" data-key="identity">
                        <span class="check-circle">✓</span>
                        Committer identity confirmed via profile card
                    </li>
                    <li id="finding-breach" data-key="breach">
                        <span class="check-circle">✓</span>
                        Password reuse confirmed via breach record
                    </li>
                </ul>
            </div>

            <!-- Flag Reveal -->
            <div class="flag-panel" id="caseClosedPanel">
                <h3>Case Closed</h3>
                <p style="color: var(--text-secondary); font-size: 0.88rem;">All findings confirmed. The dossier is complete.</p>
                <div class="flag-value">CBX{repo_secret_exposed}</div>
            </div>
        </div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <p id="tooltipText"></p>
    <div class="tooltip-actions">
        <span class="step-count" id="stepCount"></span>
        <div>
            <button class="tooltip-skip" id="skipBtn">Skip Tutorial</button>
            <button class="tooltip-btn" id="nextBtn">Next</button>
        </div>
    </div>
</div>

<!-- Completion Modal -->
<div class="modal-overlay" id="completeModal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Explore the repository, confirm the identity, and check the breach record.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// FINDINGS STATE
// ============================================================
const findings = { key: false, identity: false, breach: false };

function markFinding(key) {
    if (findings[key]) return;
    findings[key] = true;
    const el = document.getElementById('finding-' + key);
    if (el) el.classList.add('done');
    checkAllFindings();
}

function checkAllFindings() {
    if (findings.key && findings.identity && findings.breach) {
        document.getElementById('caseClosedPanel').classList.add('unlocked');
        document.getElementById('caseClosedPanel').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// ============================================================
// COMMIT DIFFS
// ============================================================
const diffs = {
    '1': '<span class="diff-context">+ Initial project structure created.</span>',
    '2': '<span class="diff-added">+ API_KEY = "vtx_live_8f3kA92ndKq1"</span>\n<span class="diff-context">  def deploy():</span>\n<span class="diff-context">      run_script("deploy.sh")</span>',
    '3': '<span class="diff-context">  README.md updated with setup instructions.</span>\n<span class="diff-context">  No credential changes in this commit.</span>',
    '4': '<span class="diff-removed">- API_KEY = "vtx_live_8f3kA92ndKq1"</span>\n<span class="diff-context">  def deploy():</span>\n<span class="diff-context">      run_script("deploy.sh")</span>\n<span class="diff-context">  # Note: still visible in commit f38b1d4 history</span>',
    '5': '<span class="diff-context">- # depoy the servrer</span>\n<span class="diff-added">+ # deploy the server</span>'
};

document.querySelectorAll('.commit-item').forEach(item => {
    item.addEventListener('click', () => {
        document.querySelectorAll('.commit-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        const id = item.getAttribute('data-commit');
        document.getElementById('diffBox').innerHTML = diffs[id];
        if (id === '4') {
            markFinding('key');
        }
    });
});

// ============================================================
// PROFILE CARD
// ============================================================
document.getElementById('linkedinCard').addEventListener('click', () => {
    markFinding('identity');
});

// ============================================================
// BREACH LOOKUP
// ============================================================
document.getElementById('breachSearchBtn').addEventListener('click', () => {
    const input = document.getElementById('breachInput').value.trim().toLowerCase();
    const status = document.getElementById('breachStatus');
    const result = document.getElementById('breachResult');
    if (input === 'dan.kowalski@vantix-corp.com') {
        result.classList.add('visible');
        status.textContent = '';
        markFinding('breach');
    } else if (input.length === 0) {
        status.textContent = 'Enter an email address first.';
        result.classList.remove('visible');
    } else {
        status.textContent = 'No breach record found for that address. Try the email tied to the commit history.';
        result.classList.remove('visible');
    }
});
document.getElementById('breachInput').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') document.getElementById('breachSearchBtn').click();
});

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    { targetId: 'repoHeader', text: 'This is the repository you are investigating. It belongs to a Vantix Corp employee, and it is fully public.' },
    { targetId: 'fileTree', text: 'Browse the files here just like you would on GitHub. Nothing is hidden, everything is visible to anyone.' },
    { targetId: 'commitHistory', text: 'Commit history often holds more than the current code. Look for a commit that mentions removing something sensitive, then check its diff.' },
    { targetId: 'linkedinCard', text: 'Cross-reference the commit author against public profile information to confirm who this person really is.' },
    { targetId: 'breachPanel', text: 'Search the employee email address against breach data to see if their credentials have been exposed before.' }
];

let currentStep = 0;
const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltipCard');
const tooltipText = document.getElementById('tooltipText');
const stepCount = document.getElementById('stepCount');

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    let tooltipTop = rect.bottom + 16;
    let tooltipLeft = rect.left;
    if (tooltipTop + 140 > window.innerHeight) {
        tooltipTop = rect.top - 160;
    }
    if (tooltipLeft + 300 > window.innerWidth) {
        tooltipLeft = window.innerWidth - 320;
    }
    if (tooltipLeft < 10) tooltipLeft = 10;

    tooltipCard.style.top = tooltipTop + 'px';
    tooltipCard.style.left = tooltipLeft + 'px';
}

function showStep(index) {
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetId);
    if (!el) return;

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            positionSpotlight(el);
        }, 300);
    } else {
        positionSpotlight(el);
    }

    tooltipText.textContent = step.text;
    stepCount.textContent = (index + 1) + ' of ' + tutorialSteps.length;
    spotlight.style.display = 'block';
    tooltipCard.style.display = 'block';
}

function startTutorial() {
    currentStep = 0;
    showStep(currentStep);
}

function endTutorial(showModal) {
    spotlight.style.display = 'none';
    tooltipCard.style.display = 'none';
    if (showModal) {
        document.getElementById('completeModal').classList.add('visible');
    }
}

document.getElementById('nextBtn').addEventListener('click', () => {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        showStep(currentStep);
    }
});

document.getElementById('skipBtn').addEventListener('click', () => {
    endTutorial(false);
});

document.getElementById('tutorialBtn').addEventListener('click', () => {
    startTutorial();
});

document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('visible');
});

window.addEventListener('resize', () => {
    if (spotlight.style.display === 'block') {
        const step = tutorialSteps[currentStep];
        const el = document.getElementById(step.targetId);
        if (el) positionSpotlight(el);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
