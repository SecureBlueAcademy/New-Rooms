<?php
// ============================================================
// email-security-engineering-practical.php
// DNS Record Auditor — standalone static practical (HTML/CSS/JS only)
// No backend logic, no database, no sessions.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DNS Record Auditor</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.6;
}

code, .mono { font-family: "JetBrains Mono", monospace; }

.page-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 80px;
    position: relative;
}

/* ===== Header ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 10px;
}
.top-header h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}
.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
    margin: 0;
    max-width: 600px;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* ===== Description ===== */
.mission-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin: 20px 0 30px;
}
.mission-box h2 {
    font-size: 1.05rem;
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}
.mission-box p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.mission-box p:last-child { margin-bottom: 0; }

/* ===== Domain Status Panel ===== */
#status-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    margin-bottom: 26px;
    text-align: center;
}
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 22px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 1rem;
    background: rgba(255, 92, 92, 0.12);
    color: var(--error);
    border: 1px solid rgba(255, 92, 92, 0.3);
    transition: all 0.3s ease;
}
.status-badge.authenticated {
    background: rgba(61, 255, 154, 0.12);
    color: var(--success);
    border-color: rgba(61, 255, 154, 0.3);
}
.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: currentColor;
}
#scan-btn {
    display: none;
    margin: 18px auto 0;
    background: linear-gradient(135deg, #12182b, var(--bg-surface));
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 28px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
#scan-btn:hover { box-shadow: var(--glow-accent); }
#scan-btn.visible { display: inline-block; }

.scan-checklist {
    margin-top: 18px;
    text-align: left;
    max-width: 320px;
    margin-left: auto;
    margin-right: auto;
    display: none;
}
.scan-checklist.visible { display: block; }
.scan-checklist .check-line {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 0;
    color: var(--text-muted);
    font-size: 0.9rem;
    opacity: 0;
    transition: opacity 0.3s ease, color 0.3s ease;
}
.scan-checklist .check-line.done {
    opacity: 1;
    color: var(--success);
}
.scan-checklist .check-icon {
    width: 18px;
    text-align: center;
}

/* ===== Zone panel / record cards ===== */
#zone-panel h2 {
    font-size: 1.1rem;
    color: var(--text-primary);
    margin-bottom: 4px;
}
#zone-panel .zone-sub {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 18px;
}
.record-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 18px;
}
.record-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}
.record-card.fixed {
    border-color: rgba(61, 255, 154, 0.4);
    box-shadow: 0 0 16px rgba(61, 255, 154, 0.08);
}
.record-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.record-card-header h3 {
    margin: 0;
    font-size: 1rem;
    color: var(--text-primary);
}
.record-status {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 999px;
    background: rgba(255, 92, 92, 0.12);
    color: var(--error);
    border: 1px solid rgba(255, 92, 92, 0.3);
}
.record-card.fixed .record-status {
    background: rgba(61, 255, 154, 0.12);
    color: var(--success);
    border-color: rgba(61, 255, 154, 0.3);
}
.record-value {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px;
    font-size: 0.8rem;
    color: var(--text-secondary);
    word-break: break-all;
    margin-bottom: 14px;
}
.diagnose-btn {
    width: 100%;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.diagnose-btn:hover:not(:disabled) {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}
.diagnose-btn:disabled {
    opacity: 0.4;
    cursor: default;
}

/* ===== Flag panel ===== */
#flag-panel {
    display: none;
    margin-top: 26px;
    background: var(--bg-secondary);
    border: 1px solid rgba(61, 255, 154, 0.35);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
}
#flag-panel.visible { display: block; }
#flag-panel h3 {
    color: var(--success);
    margin: 0 0 12px 0;
}
.flag-value {
    display: inline-block;
    background: var(--bg-primary);
    border: 1px solid rgba(61, 255, 154, 0.4);
    color: var(--success);
    padding: 12px 22px;
    border-radius: 8px;
    font-size: 1.1rem;
    letter-spacing: 0.02em;
}

/* ===== Modal ===== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    align-items: center;
    justify-content: center;
    z-index: 200;
    padding: 20px;
}
.modal-overlay.visible { display: flex; }
.modal-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 26px;
    max-width: 480px;
    width: 100%;
}
.modal-box h3 {
    margin: 0 0 6px 0;
    font-size: 1.05rem;
    color: var(--text-primary);
}
.modal-box .modal-sub {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 16px;
}
.modal-option {
    display: block;
    width: 100%;
    text-align: left;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 12px 14px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    cursor: pointer;
    margin-bottom: 10px;
    transition: all 0.2s ease;
}
.modal-option:hover {
    border-color: var(--accent-primary);
    color: var(--text-primary);
}
.modal-option.wrong {
    border-color: var(--error);
    color: var(--error);
}
.modal-option.correct {
    border-color: var(--success);
    color: var(--success);
}
.modal-feedback {
    font-size: 0.85rem;
    margin-top: 6px;
    min-height: 18px;
}
.modal-feedback.wrong { color: var(--error); }
.modal-feedback.correct { color: var(--success); }
.modal-close {
    margin-top: 14px;
    background: none;
    border: 1px solid var(--border-default);
    color: var(--text-muted);
    padding: 8px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.8rem;
    cursor: pointer;
}

/* ===== Spotlight tutorial ===== */
.spotlight-box {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 300;
}
.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 301;
    box-shadow: var(--glow-accent);
}
.tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.tutorial-tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tutorial-skip {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 0.8rem;
    cursor: pointer;
}
.tutorial-next {
    background: var(--accent-primary);
    border: none;
    color: var(--bg-primary);
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.8rem;
    cursor: pointer;
}
.tutorial-complete-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    align-items: center;
    justify-content: center;
    z-index: 400;
}
.tutorial-complete-modal.visible { display: flex; }
.tutorial-complete-box {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.tutorial-complete-box h3 {
    color: var(--accent-primary);
    margin: 0 0 10px 0;
}
.tutorial-complete-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 18px;
}
.tutorial-start-btn {
    background: var(--accent-primary);
    border: none;
    color: var(--bg-primary);
    font-weight: 700;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: inherit;
    cursor: pointer;
}

@media (max-width: 600px) {
    .top-header { flex-direction: column; }
}
</style>
</head>
<body>

<div class="page-wrap">

    <!-- 1. TOP HEADER -->
    <div class="top-header">
        <div>
            <h1>DNS Record Auditor</h1>
            <p class="subtitle">cybrixen-corp.com has a broken email authentication setup. Diagnose and repair each record.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-restart-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION / MISSION BRIEFING -->
    <div class="mission-box">
        <h2>Mission Briefing</h2>
        <p>This environment simulates the DNS zone for cybrixen-corp.com. Its SPF, DKIM, and DMARC records each contain a real world mistake that leaves the domain exposed to spoofing.</p>
        <p>Diagnose each record to identify its flaw, then select the corrected version. Once all three records are fixed, run a domain scan to confirm the domain is fully authenticated and reveal the flag.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->

    <!-- Domain Status Panel (also serves as feedback / status area) -->
    <div id="status-panel">
        <div class="status-badge" id="domain-status-badge">
            <span class="status-dot"></span>
            <span id="domain-status-text">Not Authenticated</span>
        </div>
        <div>
            <button id="scan-btn">Run Domain Scan</button>
        </div>
        <div class="scan-checklist" id="scan-checklist">
            <div class="check-line" id="check-spf"><span class="check-icon">○</span> SPF record valid</div>
            <div class="check-line" id="check-dkim"><span class="check-icon">○</span> DKIM record valid</div>
            <div class="check-line" id="check-dmarc"><span class="check-icon">○</span> DMARC record valid</div>
        </div>
    </div>

    <!-- Zone Records Panel -->
    <div id="zone-panel">
        <h2>DNS Zone Records</h2>
        <p class="zone-sub">cybrixen-corp.com &middot; TXT records</p>

        <div class="record-grid">

            <!-- SPF CARD -->
            <div class="record-card" id="spf-card" data-record="spf">
                <div class="record-card-header">
                    <h3>SPF</h3>
                    <span class="record-status" id="spf-status">Unfixed</span>
                </div>
                <div class="record-value mono" id="spf-value">v=spf1 include:_spf.google.com +all</div>
                <button class="diagnose-btn" onclick="openDiagnose('spf')">Diagnose</button>
            </div>

            <!-- DKIM CARD -->
            <div class="record-card" id="dkim-card" data-record="dkim">
                <div class="record-card-header">
                    <h3>DKIM</h3>
                    <span class="record-status" id="dkim-status">Unfixed</span>
                </div>
                <div class="record-value mono" id="dkim-value">Published at: s1._domainkey.cybrixen-corp.com<br>Outgoing header: DKIM-Signature ... s=mail; d=cybrixen-corp.com</div>
                <button class="diagnose-btn" onclick="openDiagnose('dkim')">Diagnose</button>
            </div>

            <!-- DMARC CARD -->
            <div class="record-card" id="dmarc-card" data-record="dmarc">
                <div class="record-card-header">
                    <h3>DMARC</h3>
                    <span class="record-status" id="dmarc-status">Unfixed</span>
                </div>
                <div class="record-value mono" id="dmarc-value">v=DMARC1; p=none;</div>
                <button class="diagnose-btn" onclick="openDiagnose('dmarc')">Diagnose</button>
            </div>

        </div>
    </div>

    <!-- 5. FLAG REVEAL AREA -->
    <div id="flag-panel">
        <h3>Domain Fully Authenticated</h3>
        <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 16px;">All three records are correctly configured. The flag below confirms the domain audit is complete.</p>
        <div class="flag-value mono" id="flag-value">CBX{domain_authenticated}</div>
    </div>

</div>

<!-- MODAL -->
<div class="modal-overlay" id="diagnose-modal">
    <div class="modal-box" id="diagnose-modal-box">
        <!-- populated dynamically -->
    </div>
</div>

<!-- TUTORIAL ELEMENTS -->
<div class="spotlight-box" id="spotlight-box" style="display:none;"></div>
<div class="tutorial-tooltip" id="tutorial-tooltip" style="display:none;">
    <p id="tutorial-tooltip-text"></p>
    <div class="tutorial-tooltip-actions">
        <button class="tutorial-skip" id="tutorial-skip-btn">Skip Tutorial</button>
        <button class="tutorial-next" id="tutorial-next-btn">Next</button>
    </div>
</div>

<div class="tutorial-complete-modal" id="tutorial-complete-modal">
    <div class="tutorial-complete-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button class="tutorial-start-btn" id="tutorial-start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// STATE
// ============================================================
const fixedState = { spf: false, dkim: false, dmarc: false };

// ============================================================
// RECORD DATA: diagnosis options and fix options
// ============================================================
const recordData = {
    spf: {
        label: 'SPF',
        diagnoseOptions: [
            { text: 'The record is missing an include mechanism for a mail provider.', correct: false },
            { text: 'The record ends in +all, which passes every sending server regardless of authorization.', correct: true },
            { text: 'The record uses an invalid DNS record type.', correct: false }
        ],
        fixOptions: [
            { text: 'v=spf1 include:_spf.google.com +all', correct: false },
            { text: 'v=spf1 include:_spf.google.com ~all', correct: false },
            { text: 'v=spf1 include:_spf.google.com -all', correct: true }
        ],
        fixedValue: 'v=spf1 include:_spf.google.com -all'
    },
    dkim: {
        label: 'DKIM',
        diagnoseOptions: [
            { text: 'The private key used to sign messages has expired.', correct: false },
            { text: 'The DKIM signature is missing entirely from outgoing mail.', correct: false },
            { text: 'The selector used to sign outgoing mail does not match the selector published in DNS.', correct: true }
        ],
        fixOptions: [
            { text: 'Publish the record at s1._domainkey.cybrixen-corp.com', correct: false },
            { text: 'Publish the record at mail._domainkey.cybrixen-corp.com', correct: true },
            { text: 'Publish the record at default._domainkey.cybrixen-corp.com', correct: false }
        ],
        fixedValue: 'Published at: mail._domainkey.cybrixen-corp.com<br>Outgoing header: DKIM-Signature ... s=mail; d=cybrixen-corp.com'
    },
    dmarc: {
        label: 'DMARC',
        diagnoseOptions: [
            { text: 'The policy is set to p=none with no rua tag, so it neither enforces anything nor reports failures.', correct: true },
            { text: 'The record is published under the wrong subdomain.', correct: false },
            { text: 'The record uses an unsupported DMARC version.', correct: false }
        ],
        fixOptions: [
            { text: 'v=DMARC1; p=none;', correct: false },
            { text: 'v=DMARC1; p=quarantine;', correct: false },
            { text: 'v=DMARC1; p=reject; rua=mailto:dmarc-reports@cybrixen-corp.com; pct=100;', correct: true }
        ],
        fixedValue: 'v=DMARC1; p=reject; rua=mailto:dmarc-reports@cybrixen-corp.com; pct=100;'
    }
};

let currentRecord = null;
let diagnoseStepPassed = false;

// ============================================================
// MODAL LOGIC
// ============================================================
function openDiagnose(recordKey) {
    currentRecord = recordKey;
    diagnoseStepPassed = false;
    renderDiagnoseStep();
    document.getElementById('diagnose-modal').classList.add('visible');
}

function closeDiagnose() {
    document.getElementById('diagnose-modal').classList.remove('visible');
    currentRecord = null;
}

function renderDiagnoseStep() {
    const data = recordData[currentRecord];
    const box = document.getElementById('diagnose-modal-box');
    let optionsHtml = data.diagnoseOptions.map((opt, i) =>
        `<button class="modal-option" data-index="${i}" onclick="selectDiagnose(${i})">${opt.text}</button>`
    ).join('');

    box.innerHTML = `
        <h3>Diagnose the ${data.label} Record</h3>
        <p class="modal-sub">Which explanation correctly describes the flaw in this record?</p>
        ${optionsHtml}
        <p class="modal-feedback" id="modal-feedback"></p>
        <button class="modal-close" onclick="closeDiagnose()">Close</button>
    `;
}

function selectDiagnose(index) {
    const data = recordData[currentRecord];
    const opt = data.diagnoseOptions[index];
    const buttons = document.querySelectorAll('#diagnose-modal-box .modal-option');
    const feedback = document.getElementById('modal-feedback');

    if (opt.correct) {
        buttons[index].classList.add('correct');
        feedback.textContent = 'Correct. That is exactly what is wrong with this record.';
        feedback.className = 'modal-feedback correct';
        buttons.forEach(b => b.onclick = null);
        setTimeout(() => renderFixStep(), 900);
    } else {
        buttons[index].classList.add('wrong');
        feedback.textContent = 'Not quite. Try another explanation.';
        feedback.className = 'modal-feedback wrong';
    }
}

function renderFixStep() {
    const data = recordData[currentRecord];
    const box = document.getElementById('diagnose-modal-box');
    let optionsHtml = data.fixOptions.map((opt, i) =>
        `<button class="modal-option mono" data-index="${i}" onclick="selectFix(${i})">${opt.text}</button>`
    ).join('');

    box.innerHTML = `
        <h3>Select the Corrected Record</h3>
        <p class="modal-sub">Only one of these fixes the flaw without breaking legitimate mail.</p>
        ${optionsHtml}
        <p class="modal-feedback" id="modal-feedback"></p>
        <button class="modal-close" onclick="closeDiagnose()">Close</button>
    `;
}

function selectFix(index) {
    const data = recordData[currentRecord];
    const opt = data.fixOptions[index];
    const buttons = document.querySelectorAll('#diagnose-modal-box .modal-option');
    const feedback = document.getElementById('modal-feedback');

    if (opt.correct) {
        buttons[index].classList.add('correct');
        feedback.textContent = 'Fixed. This record now provides real protection.';
        feedback.className = 'modal-feedback correct';
        buttons.forEach(b => b.onclick = null);
        markFixed(currentRecord);
        setTimeout(() => closeDiagnose(), 1000);
    } else {
        buttons[index].classList.add('wrong');
        feedback.textContent = 'That does not fully fix the flaw. Try again.';
        feedback.className = 'modal-feedback wrong';
    }
}

function markFixed(recordKey) {
    fixedState[recordKey] = true;
    const card = document.getElementById(recordKey + '-card');
    const status = document.getElementById(recordKey + '-status');
    const value = document.getElementById(recordKey + '-value');
    const btn = card.querySelector('.diagnose-btn');

    card.classList.add('fixed');
    status.textContent = 'Fixed';
    value.innerHTML = recordData[recordKey].fixedValue;
    btn.disabled = true;
    btn.textContent = 'Fixed';

    checkAllFixed();
}

function checkAllFixed() {
    if (fixedState.spf && fixedState.dkim && fixedState.dmarc) {
        document.getElementById('scan-btn').classList.add('visible');
    }
}

// ============================================================
// DOMAIN SCAN
// ============================================================
document.getElementById('scan-btn').addEventListener('click', runDomainScan);

function runDomainScan() {
    const scanBtn = document.getElementById('scan-btn');
    scanBtn.disabled = true;
    scanBtn.textContent = 'Scanning...';
    document.getElementById('scan-checklist').classList.add('visible');

    const lines = [
        { id: 'check-spf', delay: 500 },
        { id: 'check-dkim', delay: 1100 },
        { id: 'check-dmarc', delay: 1700 }
    ];

    lines.forEach(line => {
        setTimeout(() => {
            const el = document.getElementById(line.id);
            el.classList.add('done');
            el.querySelector('.check-icon').textContent = '✓';
        }, line.delay);
    });

    setTimeout(() => {
        const badge = document.getElementById('domain-status-badge');
        const text = document.getElementById('domain-status-text');
        badge.classList.add('authenticated');
        text.textContent = 'Fully Authenticated';
        scanBtn.style.display = 'none';
        document.getElementById('flag-panel').classList.add('visible');
    }, 2300);
}

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetElementId: 'zone-panel',
        tooltipText: 'This is the domain\'s DNS zone, the same records you would see running a DNS TXT lookup against a real domain. Everything you diagnose here maps directly to production DNS.'
    },
    {
        targetElementId: 'spf-card',
        tooltipText: 'This is the domain\'s SPF record. Click Diagnose to identify the flaw, then choose the corrected record from the options shown.'
    },
    {
        targetElementId: 'dkim-card',
        tooltipText: 'This is the domain\'s DKIM record. DKIM validity depends on the selector in DNS matching the selector used to sign outgoing mail.'
    },
    {
        targetElementId: 'dmarc-card',
        tooltipText: 'This is the domain\'s DMARC record. DMARC ties SPF and DKIM results together and tells receiving servers what to do on failure.'
    },
    {
        targetElementId: 'status-panel',
        tooltipText: 'Once all three records show Fixed, a Run Domain Scan button appears here. Click it to confirm the domain is fully authenticated.'
    },
    {
        targetElementId: 'flag-panel',
        tooltipText: 'This is where your flag appears once the domain passes the scan.'
    }
];

let currentStep = 0;
let resizeHandler = null;

function startTutorial() {
    currentStep = 0;
    document.getElementById('spotlight-box').style.display = 'block';
    document.getElementById('tutorial-tooltip').style.display = 'block';
    showStep(currentStep);
}

function showStep(index) {
    const step = tutorialSteps[index];
    let el = document.getElementById(step.targetElementId);
    if (!el) { nextStep(); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!inView) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el, step), 300);
    } else {
        positionSpotlight(el, step);
    }
}

function positionSpotlight(el, step) {
    const rect = el.getBoundingClientRect();
    const padding = 8;
    const spotlight = document.getElementById('spotlight-box');
    spotlight.style.top = (rect.top - padding) + 'px';
    spotlight.style.left = (rect.left - padding) + 'px';
    spotlight.style.width = (rect.width + padding * 2) + 'px';
    spotlight.style.height = (rect.height + padding * 2) + 'px';

    const tooltip = document.getElementById('tutorial-tooltip');
    document.getElementById('tutorial-tooltip-text').textContent = step.tooltipText;
    document.getElementById('tutorial-next-btn').textContent =
        currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next';

    // Placement: prefer below, fallback above, then right, then left
    tooltip.style.visibility = 'hidden';
    tooltip.style.display = 'block';
    const tw = tooltip.offsetWidth;
    const th = tooltip.offsetHeight;

    let top, left;
    if (rect.bottom + th + 20 < window.innerHeight) {
        top = rect.bottom + 14;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - tw - 10);
    } else if (rect.top - th - 20 > 0) {
        top = rect.top - th - 14;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - tw - 10);
    } else if (rect.right + tw + 20 < window.innerWidth) {
        top = Math.min(Math.max(rect.top, 10), window.innerHeight - th - 10);
        left = rect.right + 14;
    } else {
        top = Math.min(Math.max(rect.top, 10), window.innerHeight - th - 10);
        left = Math.max(rect.left - tw - 14, 10);
    }

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
    tooltip.style.visibility = 'visible';
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
    } else {
        showStep(currentStep);
    }
}

function endTutorial() {
    document.getElementById('spotlight-box').style.display = 'none';
    document.getElementById('tutorial-tooltip').style.display = 'none';
    document.getElementById('tutorial-complete-modal').classList.add('visible');
}

document.getElementById('tutorial-next-btn').addEventListener('click', nextStep);
document.getElementById('tutorial-skip-btn').addEventListener('click', () => {
    document.getElementById('spotlight-box').style.display = 'none';
    document.getElementById('tutorial-tooltip').style.display = 'none';
});
document.getElementById('tutorial-restart-btn').addEventListener('click', startTutorial);
document.getElementById('tutorial-start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').classList.remove('visible');
});

window.addEventListener('resize', () => {
    const spotlight = document.getElementById('spotlight-box');
    if (spotlight.style.display === 'block' && tutorialSteps[currentStep]) {
        const el = document.getElementById(tutorialSteps[currentStep].targetElementId);
        if (el) positionSpotlight(el, tutorialSteps[currentStep]);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
