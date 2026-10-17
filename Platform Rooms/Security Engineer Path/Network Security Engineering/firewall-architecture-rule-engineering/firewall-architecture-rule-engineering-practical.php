<?php
// firewall-architecture-rule-engineering-practical.php
// Static PHP/HTML/CSS/JS practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rule Base Audit - Firewall Practical</title>
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
    padding-bottom: 60px;
}

code, .mono { font-family: "JetBrains Mono", monospace; }

.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 28px 32px 20px 32px;
    border-bottom: 1px solid var(--border-default);
    background: var(--bg-secondary);
}

.top-header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
    color: var(--accent-primary);
}

.top-header .subtitle {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

.container {
    max-width: 980px;
    margin: 0 auto;
    padding: 28px 32px 0 32px;
}

.description-section {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px 24px;
    margin-bottom: 28px;
}
.description-section h2 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--text-primary);
}
.description-section p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--accent-primary);
    margin: 0 0 12px 0;
}

/* Rule table */
#rule-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 28px;
}
#rule-table th, #rule-table td {
    padding: 12px 14px;
    text-align: left;
    font-size: 0.85rem;
    border-bottom: 1px solid var(--border-default);
}
#rule-table th {
    background: rgba(255,255,255,0.03);
    color: var(--text-secondary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-size: 0.75rem;
}
#rule-table td.mono { color: var(--text-primary); }
#rule-table tr:last-child td { border-bottom: none; }

.action-allow { color: var(--success); font-weight: 600; }
.action-deny { color: var(--error); font-weight: 600; }

.rule-row.matched-highlight {
    background: rgba(106,227,255,0.10);
    box-shadow: inset 3px 0 0 var(--accent-primary);
}

.mark-select {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 6px 8px;
    font-family: inherit;
    font-size: 0.8rem;
}
.mark-select.correct {
    border-color: var(--success);
    box-shadow: 0 0 8px rgba(61,255,154,0.3);
}
.mark-select.incorrect {
    border-color: var(--error);
}

/* Packet tracer */
.tracer-section {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 22px 24px;
    margin-bottom: 28px;
}

#packet-tracer-input {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 16px;
}

.packet-btn {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 10px 14px;
    border-radius: 8px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.packet-btn:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.packet-btn.active {
    border-color: var(--accent-secondary);
    background: rgba(139,123,255,0.12);
}

#trace-result {
    min-height: 54px;
    background: var(--bg-primary);
    border: 1px dashed var(--border-default);
    border-radius: 8px;
    padding: 14px 16px;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
#trace-result.has-result {
    border-style: solid;
    border-color: var(--accent-primary);
    color: var(--text-primary);
}

/* Findings / status */
.status-area {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px 24px;
    margin-bottom: 28px;
}
#status-message {
    font-size: 0.92rem;
    color: var(--text-secondary);
}
#status-message.status-good { color: var(--success); }
#status-message.status-bad { color: var(--warning); }

#submit-findings-btn {
    margin-top: 14px;
    background: var(--accent-secondary);
    border: none;
    color: #0b0f1a;
    font-weight: 700;
    padding: 12px 22px;
    border-radius: 8px;
    font-family: inherit;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}
#submit-findings-btn:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* Flag reveal */
.flag-section {
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 24px;
    text-align: center;
    display: none;
}
.flag-section.revealed { display: block; }
.flag-section h2 {
    margin-top: 0;
    color: var(--success);
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.3rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 14px 20px;
    display: inline-block;
    color: var(--success);
    box-shadow: 0 0 18px rgba(61,255,154,0.25);
    user-select: all;
}

/* Spotlight tutorial */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
    border: 2px solid var(--accent-primary);
}

.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: 0 0 20px rgba(106,227,255,0.25);
    font-size: 0.85rem;
}
.tutorial-tooltip h4 {
    margin: 0 0 8px 0;
    color: var(--accent-primary);
    font-size: 0.95rem;
}
.tutorial-tooltip p {
    margin: 0 0 14px 0;
    color: var(--text-secondary);
}
.tutorial-controls {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}
.tutorial-controls button {
    font-family: inherit;
    font-size: 0.8rem;
    padding: 7px 12px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: var(--bg-primary);
    color: var(--text-primary);
}
.tutorial-controls .next-btn {
    background: var(--accent-primary);
    color: #0b0f1a;
    font-weight: 600;
    border: none;
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
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px 34px;
    max-width: 400px;
    text-align: center;
}
.modal-box h3 {
    color: var(--accent-primary);
    margin-top: 0;
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.modal-box button {
    margin-top: 10px;
    background: var(--accent-primary);
    border: none;
    color: #0b0f1a;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 8px;
    font-family: inherit;
    cursor: pointer;
}

@media (max-width: 700px) {
    .top-header { flex-direction: column; gap: 14px; }
    #rule-table { font-size: 0.75rem; }
    #rule-table th, #rule-table td { padding: 8px 6px; }
}
</style>
</head>
<body>

<div class="top-header">
    <div>
        <h1>Rule Base Audit</h1>
        <p class="subtitle">You are reviewing a live firewall rule base protecting a public web server and an internal finance subnet. Something in this rule base is not behaving the way it appears to.</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</div>

<div class="container">

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>This environment simulates the rule base of a corporate firewall. Rules are evaluated from top to bottom, and the first rule that matches a given connection is the one that decides its fate, no matter what other rules exist further down.</p>
        <p>Your goal: trace sample connections through the rule base to see which rule actually fires for each one, then mark the two rules that have a real problem. One rule grants far more access than it should. Another rule looks like it should be doing something, but never actually gets evaluated at all.</p>
    </div>

    <div>
        <div class="section-title">Firewall Rule Base</div>
        <table id="rule-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Action</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Port</th>
                    <th>Mark Issue</th>
                </tr>
            </thead>
            <tbody id="rule-table-body">
                <!-- rows injected by JS -->
            </tbody>
        </table>
    </div>

    <div class="tracer-section">
        <div class="section-title">Packet Tracer</div>
        <p style="color:var(--text-secondary); font-size:0.88rem; margin-top:-6px;">Select a sample connection below. The rule that actually matches it first will be highlighted in the table above.</p>
        <div id="packet-tracer-input"></div>
        <div id="trace-result">Select a sample packet above to trace it through the rule base.</div>
    </div>

    <div class="status-area">
        <div class="section-title">Audit Findings</div>
        <div id="status-message">Mark the rule you believe is Overly Permissive and the rule you believe is Shadowed, then submit your findings.</div>
        <button id="submit-findings-btn">Submit Audit Findings</button>
    </div>

    <div class="flag-section" id="flag-section">
        <h2>Audit Complete</h2>
        <p>You correctly identified both problem rules. Flag retrieved:</p>
        <div class="flag-value" id="flag-value">CBX{shadow_rule_exposed}</div>
    </div>

</div>

<div class="modal-overlay" id="completion-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're Ready to Start the Challenge</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// RULE BASE DATA
// ============================================================
const rules = [
    { num: 1, action: 'ALLOW', source: '10.10.20.0/24', dest: 'ANY', port: 'ANY', correctIssue: 'permissive' },
    { num: 2, action: 'DENY',  source: '10.10.20.5',     dest: '198.51.100.20', port: '3389/tcp', correctIssue: 'shadowed' },
    { num: 3, action: 'ALLOW', source: 'ANY',            dest: '203.0.113.10',  port: '443/tcp',  correctIssue: 'none' },
    { num: 4, action: 'ALLOW', source: 'ANY',            dest: '203.0.113.10',  port: '80/tcp',   correctIssue: 'none' },
    { num: 5, action: 'DENY',  source: 'ANY',             dest: '10.10.0.0/16', port: 'ANY',      correctIssue: 'none' },
    { num: 6, action: 'DENY',  source: 'ANY',             dest: 'ANY',          port: 'ANY',      correctIssue: 'none' },
];

const packets = [
    {
        id: 'A',
        label: 'A: 10.10.20.5 -> 198.51.100.20:3389',
        matchedRule: 1,
        explanation: 'This connection matches Rule 1 first, because the source falls inside 10.10.20.0/24 and that rule allows ANY destination on ANY port. Rule 2, which was written specifically to block this exact connection, is never reached.'
    },
    {
        id: 'B',
        label: 'B: 203.0.113.50 -> 203.0.113.10:443',
        matchedRule: 3,
        explanation: 'This is ordinary HTTPS traffic to the public web server. It matches Rule 3 as expected, no issue here.'
    },
    {
        id: 'C',
        label: 'C: 198.51.100.99 -> 10.10.5.20:22',
        matchedRule: 5,
        explanation: 'This inbound connection to the internal network matches Rule 5 and is correctly denied. This rule is working as intended.'
    },
    {
        id: 'D',
        label: 'D: 10.10.20.8 -> 8.8.8.8:53',
        matchedRule: 1,
        explanation: 'Another connection from the finance subnet, this time to an external DNS server. It also matches Rule 1 immediately, which shows just how broad that rule really is.'
    }
];

let tracedPackets = new Set();
let markings = {};

// ============================================================
// RENDER RULE TABLE
// ============================================================
const ruleTableBody = document.getElementById('rule-table-body');

function renderRuleTable() {
    ruleTableBody.innerHTML = '';
    rules.forEach(rule => {
        const tr = document.createElement('tr');
        tr.className = 'rule-row';
        tr.id = 'rule-row-' + rule.num;

        const actionClass = rule.action === 'ALLOW' ? 'action-allow' : 'action-deny';

        let markCell = '';
        if (rule.num === 1 || rule.num === 2) {
            markCell = `
                <select class="mark-select" data-rule="${rule.num}" id="mark-select-${rule.num}">
                    <option value="">-- select --</option>
                    <option value="permissive">Overly Permissive</option>
                    <option value="shadowed">Shadowed</option>
                    <option value="none">No Issue</option>
                </select>
            `;
        } else {
            markCell = '<span style="color:var(--text-muted); font-size:0.8rem;">-</span>';
        }

        tr.innerHTML = `
            <td class="mono">${rule.num}</td>
            <td class="${actionClass}">${rule.action}</td>
            <td class="mono">${rule.source}</td>
            <td class="mono">${rule.dest}</td>
            <td class="mono">${rule.port}</td>
            <td id="rule-mark-controls-${rule.num}">${markCell}</td>
        `;
        ruleTableBody.appendChild(tr);
    });

    document.querySelectorAll('.mark-select').forEach(sel => {
        sel.addEventListener('change', () => {
            markings[sel.dataset.rule] = sel.value;
            sel.classList.remove('correct', 'incorrect');
        });
    });
}
renderRuleTable();

// ============================================================
// PACKET TRACER
// ============================================================
const tracerInput = document.getElementById('packet-tracer-input');
const traceResult = document.getElementById('trace-result');

packets.forEach(pkt => {
    const btn = document.createElement('button');
    btn.className = 'packet-btn';
    btn.textContent = pkt.label;
    btn.addEventListener('click', () => {
        document.querySelectorAll('.packet-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        tracePacket(pkt);
    });
    tracerInput.appendChild(btn);
});

function tracePacket(pkt) {
    document.querySelectorAll('.rule-row').forEach(row => row.classList.remove('matched-highlight'));
    const matchedRow = document.getElementById('rule-row-' + pkt.matchedRule);
    if (matchedRow) matchedRow.classList.add('matched-highlight');

    traceResult.classList.add('has-result');
    traceResult.innerHTML = `<strong>Matched Rule ${pkt.matchedRule}.</strong> ${pkt.explanation}`;

    tracedPackets.add(pkt.id);
}

// ============================================================
// SUBMIT FINDINGS
// ============================================================
const submitBtn = document.getElementById('submit-findings-btn');
const statusMessage = document.getElementById('status-message');
const flagSection = document.getElementById('flag-section');

submitBtn.addEventListener('click', () => {
    const mark1 = markings['1'];
    const mark2 = markings['2'];

    const sel1 = document.getElementById('mark-select-1');
    const sel2 = document.getElementById('mark-select-2');

    if (!mark1 || !mark2) {
        statusMessage.textContent = 'Mark both Rule 1 and Rule 2 before submitting your findings.';
        statusMessage.className = 'status-bad';
        return;
    }

    const rule1Correct = mark1 === 'permissive';
    const rule2Correct = mark2 === 'shadowed';

    sel1.classList.toggle('correct', rule1Correct);
    sel1.classList.toggle('incorrect', !rule1Correct);
    sel2.classList.toggle('correct', rule2Correct);
    sel2.classList.toggle('incorrect', !rule2Correct);

    if (rule1Correct && rule2Correct) {
        statusMessage.textContent = 'Audit findings confirmed. Rule 1 is overly permissive and Rule 2 is shadowed by it.';
        statusMessage.className = 'status-good';
        flagSection.classList.add('revealed');
        flagSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        statusMessage.textContent = 'Not quite. Re-trace packets A and D to see which rule keeps firing first, then re-check your markings.';
        statusMessage.className = 'status-bad';
    }
});

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetElementId: 'rule-table',
        tooltipText: 'This is the firewall rule base. Rules are evaluated from top to bottom, and the first rule that matches a connection is the one that applies, like a checklist where only the first matching instruction is followed.'
    },
    {
        targetElementId: 'packet-tracer-input',
        tooltipText: 'Select a sample connection here to trace it through the rule base and see exactly which rule handles it.'
    },
    {
        targetElementId: 'trace-result',
        tooltipText: 'The highlighted rule above is the one that actually applies to that traffic. Every rule listed after it is never evaluated for that connection.'
    },
    {
        targetElementId: 'rule-mark-controls-1',
        tooltipText: 'Found a problem rule? Use this dropdown to mark it with the issue type you believe applies: Overly Permissive, Shadowed, or No Issue.'
    },
    {
        targetElementId: 'submit-findings-btn',
        tooltipText: 'Once you have marked both problem rules correctly, submit your audit to reveal the flag.'
    }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tutorial-tooltip';
    document.body.appendChild(tooltipEl);
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const padding = 8;
    spotlightEl.style.top = (rect.top - padding) + 'px';
    spotlightEl.style.left = (rect.left - padding) + 'px';
    spotlightEl.style.width = (rect.width + padding * 2) + 'px';
    spotlightEl.style.height = (rect.height + padding * 2) + 'px';
}

function positionTooltip(target) {
    const rect = target.getBoundingClientRect();
    const tooltipRect = tooltipEl.getBoundingClientRect();
    const margin = 14;

    let top, left;

    if (rect.bottom + margin + tooltipRect.height < window.innerHeight) {
        top = rect.bottom + margin;
        left = rect.left;
    } else if (rect.top - margin - tooltipRect.height > 0) {
        top = rect.top - margin - tooltipRect.height;
        left = rect.left;
    } else if (rect.right + margin + tooltipRect.width < window.innerWidth) {
        top = rect.top;
        left = rect.right + margin;
    } else {
        top = rect.top;
        left = Math.max(rect.left - margin - tooltipRect.width, 10);
    }

    left = Math.min(Math.max(left, 10), window.innerWidth - tooltipRect.width - 10);
    top = Math.min(Math.max(top, 10), window.innerHeight - tooltipRect.height - 10);

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function renderTutorialStep() {
    const step = tutorialSteps[currentStep];
    const target = document.getElementById(step.targetElementId);
    if (!target) { nextStep(); return; }

    const rect = target.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const doPosition = () => {
        positionSpotlight(target);
        tooltipEl.innerHTML = `
            <h4>Step ${currentStep + 1} of ${tutorialSteps.length}</h4>
            <p>${step.tooltipText}</p>
            <div class="tutorial-controls">
                <button id="skip-tutorial-btn">Skip Tutorial</button>
                <button class="next-btn" id="next-step-btn">${currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next'}</button>
            </div>
        `;
        positionTooltip(target);

        document.getElementById('next-step-btn').addEventListener('click', nextStep);
        document.getElementById('skip-tutorial-btn').addEventListener('click', endTutorial);
    };

    if (!isVisible) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(doPosition, 300);
    } else {
        doPosition();
    }
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        renderTutorialStep();
    }
}

function endTutorial(completed) {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;

    if (completed) {
        document.getElementById('completion-modal').classList.add('visible');
    }
}

function startTutorial() {
    currentStep = 0;
    createSpotlightElements();
    renderTutorialStep();
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('completion-modal').classList.remove('visible');
});

window.addEventListener('resize', () => {
    if (spotlightEl && tooltipEl && tutorialSteps[currentStep]) {
        const target = document.getElementById(tutorialSteps[currentStep].targetElementId);
        if (target) {
            positionSpotlight(target);
            positionTooltip(target);
        }
    }
});

// Auto-start tutorial on first page load
window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
