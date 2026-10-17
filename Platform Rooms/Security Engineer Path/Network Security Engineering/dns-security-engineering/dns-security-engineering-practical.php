<?php
// dns-security-engineering-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DNS Firewall Console</title>
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
    line-height: 1.6;
}

.page-header {
    padding: 28px 24px 20px 24px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    position: relative;
}

.page-header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
    color: var(--accent-primary);
}

.page-header p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 720px;
}

#tutorial-btn {
    position: absolute;
    top: 24px;
    right: 24px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.85rem;
}

#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

.description-section {
    max-width: 900px;
    margin: 20px auto 0 auto;
    padding: 0 24px;
    color: var(--text-secondary);
}

.description-section .mission-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 20px;
}

.description-section .mission-box h3 {
    margin-top: 0;
    color: var(--text-primary);
    font-size: 1rem;
}

.main-env {
    max-width: 900px;
    margin: 24px auto;
    padding: 0 24px;
}

#query-log-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    overflow: hidden;
}

.query-row {
    display: grid;
    grid-template-columns: 1fr auto auto auto;
    gap: 12px;
    align-items: center;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border-default);
}

.query-row:last-child { border-bottom: none; }

.query-domain {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.9rem;
    color: var(--text-primary);
    word-break: break-all;
}

.query-meta {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.btn-decision {
    font-family: inherit;
    font-weight: 600;
    border-radius: 6px;
    padding: 8px 14px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
    font-size: 0.8rem;
}

.btn-block {
    border-color: var(--error);
    color: var(--error);
}
.btn-block.selected {
    background: var(--error);
    color: var(--bg-primary);
}

.btn-allow {
    border-color: var(--success);
    color: var(--success);
}
.btn-allow.selected {
    background: var(--success);
    color: var(--bg-primary);
}

.row-result {
    font-size: 0.75rem;
    min-width: 90px;
    text-align: right;
}

.row-result.correct { color: var(--success); }
.row-result.incorrect { color: var(--warning); }

#status-panel {
    max-width: 900px;
    margin: 0 auto 24px auto;
    padding: 16px 24px;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

#status-panel .status-line {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 18px;
}

#flag-area {
    max-width: 900px;
    margin: 0 auto 60px auto;
    padding: 0 24px;
}

.flag-box {
    display: none;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}

.flag-box.visible { display: block; }

.flag-box h3 {
    color: var(--success);
    margin-top: 0;
}

.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    color: var(--accent-primary);
    background: var(--bg-primary);
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    border: 1px solid var(--border-default);
    margin-top: 8px;
    user-select: all;
}

/* Spotlight tutorial */
#spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.25s ease;
    pointer-events: none;
    z-index: 9998;
    display: none;
}

#tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    display: none;
    box-shadow: var(--glow-accent);
}

#tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-primary);
}

.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}

.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}

.tooltip-actions .next-btn {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}

#tutorial-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

#tutorial-modal-overlay.visible { display: flex; }

.tutorial-modal {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}

.tutorial-modal h3 {
    margin-top: 0;
    color: var(--accent-primary);
}

.tutorial-modal button {
    margin-top: 14px;
    font-family: inherit;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    border: 1px solid var(--accent-primary);
    background: var(--accent-primary);
    color: var(--bg-primary);
    cursor: pointer;
}

@media (max-width: 600px) {
    .query-row { grid-template-columns: 1fr; }
    .row-result { text-align: left; }
}
</style>
</head>
<body>

<div class="page-header">
    <h1>DNS Firewall Console</h1>
    <p>Live query feed from the resolver. Review each domain and decide whether to block it with RPZ or allow it to resolve.</p>
    <button id="tutorial-btn">View Tutorial</button>
</div>

<div class="description-section">
    <div class="mission-box">
        <h3>Mission Briefing</h3>
        <p>A batch of 12 recent DNS queries has been captured from the network. Some are ordinary business traffic. Others are malware attempting DGA-style command and control callbacks or exfiltrating data through encoded subdomains. Classify every query correctly to neutralize the threat.</p>
    </div>
</div>

<div class="main-env">
    <div id="query-log-panel"></div>
</div>

<div id="status-panel">
    <div class="status-line" id="status-line">Malicious domains blocked: 0/6 &nbsp;|&nbsp; Misclassifications: 0</div>
</div>

<div id="flag-area">
    <div class="flag-box" id="flag-box">
        <h3>Threat Neutralized</h3>
        <p>Every malicious domain has been blocked via RPZ. The resolver is clean.</p>
        <div class="flag-value">CBX{policy_zone_enforced}</div>
    </div>
</div>

<div id="spotlight"></div>
<div id="tooltip-card">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button class="skip-btn" onclick="skipTutorial()">Skip Tutorial</button>
        <button class="next-btn" onclick="nextStep()">Next</button>
    </div>
</div>

<div id="tutorial-modal-overlay">
    <div class="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
const queries = [
    { id: 'q1', domain: 'xk29fj28fneiqm.com', meta: 'TTL 60s, high entropy', malicious: true },
    { id: 'q2', domain: 'www.google.com', meta: 'TTL 3600s', malicious: false },
    { id: 'q3', domain: 'qzpxlvbn7k3f.net', meta: 'TTL 45s, high entropy', malicious: true },
    { id: 'q4', domain: 'outlook.office365.com', meta: 'TTL 1800s', malicious: false },
    { id: 'q5', domain: 'update-security-check.info', meta: 'Uncommon TLD, mimics update service', malicious: true },
    { id: 'q6', domain: 'cdn.cloudflare.com', meta: 'TTL 3600s', malicious: false },
    { id: 'q7', domain: 'cdn-analytics-service.biz', meta: 'Mimics legitimate CDN naming', malicious: true },
    { id: 'q8', domain: 'api.github.com', meta: 'TTL 900s', malicious: false },
    { id: 'q9', domain: '8f3ndalkw9x.ru', meta: 'TTL 30s, high entropy', malicious: true },
    { id: 'q10', domain: 'www.wikipedia.org', meta: 'TTL 3600s', malicious: false },
    { id: 'q11', domain: 'aGVsbG93b3JsZA.telemetry-sync-data.top', meta: 'Long encoded subdomain', malicious: true },
    { id: 'q12', domain: 'login.microsoftonline.com', meta: 'TTL 1800s', malicious: false },
];

const decisions = {};

function renderQueries() {
    const panel = document.getElementById('query-log-panel');
    panel.innerHTML = '';
    queries.forEach((q, index) => {
        const row = document.createElement('div');
        row.className = 'query-row';
        row.setAttribute('data-id', q.id);
        row.innerHTML = `
            <div>
                <div class="query-domain">${q.domain}</div>
                <div class="query-meta">${q.meta}</div>
            </div>
            <button class="btn-decision btn-block" id="block-${q.id}" onclick="decide('${q.id}', true)">Block</button>
            <button class="btn-decision btn-allow" id="allow-${q.id}" onclick="decide('${q.id}', false)">Allow</button>
            <div class="row-result" id="result-${q.id}"></div>
        `;
        panel.appendChild(row);
    });
}

function decide(id, blocked) {
    decisions[id] = blocked;
    const q = queries.find(x => x.id === id);
    document.getElementById(`block-${id}`).classList.toggle('selected', blocked);
    document.getElementById(`allow-${id}`).classList.toggle('selected', !blocked);

    const resultEl = document.getElementById(`result-${id}`);
    const correct = blocked === q.malicious;
    resultEl.textContent = correct ? 'Correct' : 'Review this';
    resultEl.className = 'row-result ' + (correct ? 'correct' : 'incorrect');

    updateStatus();
}

function updateStatus() {
    const malicious = queries.filter(q => q.malicious);
    const blockedCorrectly = malicious.filter(q => decisions[q.id] === true).length;

    let misclassified = 0;
    queries.forEach(q => {
        if (decisions[q.id] !== undefined && decisions[q.id] !== q.malicious) {
            misclassified++;
        }
    });

    document.getElementById('status-line').textContent =
        `Malicious domains blocked: ${blockedCorrectly}/${malicious.length} | Misclassifications: ${misclassified}`;

    if (blockedCorrectly === malicious.length) {
        document.getElementById('flag-box').classList.add('visible');
    } else {
        document.getElementById('flag-box').classList.remove('visible');
    }
}

renderQueries();

// ===== Spotlight Tutorial System =====
const tutorialSteps = [
    { targetElementId: 'query-log-panel', tooltipText: 'This is your DNS query log console. Every query your resolver processes appears here, like a security guard\'s visitor log for a building.' },
    { targetElementId: 'block-q1', tooltipText: 'Look closely at this domain. Random looking characters and unusual length are signs of a DGA, commonly used by malware to reach command and control servers.' },
    { targetElementId: 'block-q1', tooltipText: 'Click Block to add a domain to your RPZ blocklist. This stops your resolver from ever returning a real answer for it again.' },
    { targetElementId: 'allow-q2', tooltipText: 'Click Allow if a query looks legitimate. Blocking real business traffic by mistake causes outages, so treat this like a real RPZ policy decision.' },
    { targetElementId: 'status-line', tooltipText: 'This tracks how many threats you\'ve correctly blocked and flags mistakes, similar to a SOC dashboard tracking policy enforcement in real time.' },
    { targetElementId: 'tutorial-btn', tooltipText: 'You can replay this tutorial anytime from here.' },
];

let currentStep = 0;

function getTarget(id) {
    if (id === 'query-log-panel') return document.getElementById('query-log-panel');
    if (id === 'status-line') return document.getElementById('status-panel');
    if (id === 'tutorial-btn') return document.getElementById('tutorial-btn');
    return document.getElementById(id);
}

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const padding = 8;
    const spotlight = document.getElementById('spotlight');
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - padding) + 'px';
    spotlight.style.left = (rect.left - padding) + 'px';
    spotlight.style.width = (rect.width + padding * 2) + 'px';
    spotlight.style.height = (rect.height + padding * 2) + 'px';

    const tooltip = document.getElementById('tooltip-card');
    tooltip.style.display = 'block';
    let top = rect.bottom + 16;
    let left = rect.left;

    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left + 300 > window.innerWidth) {
        left = window.innerWidth - 320;
    }
    if (left < 10) left = 10;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

function showStep(index) {
    const step = tutorialSteps[index];
    const el = getTarget(step.targetElementId);
    if (!el) { nextStep(); return; }

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionForStep(el, step), 300);
    } else {
        positionForStep(el, step);
    }
}

function positionForStep(el, step) {
    positionSpotlight(el);
    document.getElementById('tooltip-text').textContent = step.tooltipText;
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
    } else {
        showStep(currentStep);
    }
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tooltip-card').style.display = 'none';
    document.getElementById('tutorial-modal-overlay').classList.add('visible');
}

function closeTutorialModal() {
    document.getElementById('tutorial-modal-overlay').classList.remove('visible');
}

function startTutorial() {
    currentStep = 0;
    showStep(currentStep);
}

document.getElementById('tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    const tooltipVisible = document.getElementById('tooltip-card').style.display === 'block';
    if (tooltipVisible && tutorialSteps[currentStep]) {
        const el = getTarget(tutorialSteps[currentStep].targetElementId);
        if (el) positionForStep(el, tutorialSteps[currentStep]);
    }
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
