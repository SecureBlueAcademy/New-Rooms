<?php
// ============================================================
// federation-sso-engineering-practical.php
// SAML Assertion Forensics — standalone static practical
// No backend logic. No database. No sessions. No external APIs.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SAML Assertion Forensics</title>
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
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
}

.page-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 24px 20px 60px;
}

/* ===== HEADER ===== */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 28px;
}
.header-bar h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    font-weight: 700;
}
.header-bar .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    color: var(--accent-primary);
    border: 1px solid var(--border-default);
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== DESCRIPTION ===== */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 26px;
}
.mission-briefing h3 {
    margin: 0 0 8px 0;
    font-size: 1rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    margin: 6px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}

/* ===== MAIN ENVIRONMENT ===== */
.environment {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
@media (max-width: 860px) {
    .environment { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.panel h3 {
    margin: 0 0 12px 0;
    font-size: 0.95rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.round-badge {
    font-size: 0.75rem;
    background: rgba(106,227,255,0.1);
    color: var(--accent-primary);
    padding: 3px 10px;
    border-radius: 20px;
    font-family: "JetBrains Mono", monospace;
}

#xml-panel {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    white-space: pre-wrap;
    word-break: break-word;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    max-height: 420px;
    overflow-y: auto;
}
.xml-tag { color: var(--accent-secondary); }
.xml-attr { color: var(--accent-primary); }
.xml-value { color: var(--warning); }

.checklist {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.check-option {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 12px 14px;
    border-radius: 8px;
    text-align: left;
    font-size: 0.88rem;
    cursor: pointer;
    transition: border-color 0.15s ease, background 0.15s ease;
}
.check-option:hover {
    border-color: var(--accent-primary);
}
.check-option.selected {
    border-color: var(--accent-primary);
    background: rgba(106,227,255,0.08);
}

.submit-diagnosis-btn {
    margin-top: 14px;
    width: 100%;
    padding: 12px;
    background: var(--accent-secondary);
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
}
.submit-diagnosis-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.submit-diagnosis-btn:hover:not(:disabled) {
    box-shadow: var(--glow-accent);
}

/* ===== FEEDBACK / STATUS ===== */
.status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
}
#feedback-panel {
    font-size: 0.9rem;
    min-height: 24px;
}
#feedback-panel.correct { color: var(--success); }
#feedback-panel.incorrect { color: var(--error); }

.progress-tracker {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}
.progress-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
}
.progress-dot.done { background: var(--success); border-color: var(--success); }
.progress-dot.active { border-color: var(--accent-primary); box-shadow: var(--glow-accent); }

/* ===== FLAG REVEAL ===== */
.flag-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
    display: none;
}
.flag-area.revealed { display: block; }
.flag-area h3 {
    margin: 0 0 10px 0;
    color: var(--success);
    font-size: 1rem;
}
.root-cause-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    font-size: 0.82rem;
}
.root-cause-table th, .root-cause-table td {
    border: 1px solid var(--border-default);
    padding: 8px 10px;
    text-align: left;
    color: var(--text-secondary);
}
.root-cause-table th { color: var(--text-primary); }
.flag-box {
    font-family: "JetBrains Mono", monospace;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 14px 18px;
    border-radius: 8px;
    font-size: 1.1rem;
    letter-spacing: 0.02em;
    user-select: all;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
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
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 9999;
    box-shadow: var(--glow-accent);
    display: none;
}
#tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 12px;
}
#tooltip-card button {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
}
#tooltip-card button.primary {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    font-weight: 600;
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
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 { margin-top: 0; color: var(--accent-primary); }
.modal-card button {
    margin-top: 16px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <!-- ===== 1. TOP HEADER ===== -->
    <div class="header-bar">
        <div>
            <h1>SAML Assertion Forensics</h1>
            <div class="subtitle">Five flagged assertions. One planted flaw each. You are the SP-side engineer deciding what should have been rejected.</div>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- ===== 2. DESCRIPTION SECTION ===== -->
    <div class="mission-briefing">
        <h3>Mission Briefing</h3>
        <p>Your SP's monitoring system flagged five SAML assertions received over the last hour. Each one is otherwise well-formed, but each hides exactly one flaw that a properly configured validation pipeline should catch.</p>
        <p>Read the raw assertion on the left. Decide which validation check on the right should have failed it. Submit your diagnosis to move to the next round.</p>
    </div>

    <!-- ===== 3. MAIN INTERACTIVE ENVIRONMENT ===== -->
    <div class="environment">
        <div class="panel">
            <h3>Raw Assertion <span class="round-badge" id="round-indicator">Round 1 of 5</span></h3>
            <div id="xml-panel"></div>
        </div>
        <div class="panel">
            <h3>Validation Checklist</h3>
            <div class="checklist" id="validation-checklist"></div>
            <button class="submit-diagnosis-btn" id="submit-diagnosis-btn" disabled>Submit Diagnosis</button>
        </div>
    </div>

    <!-- ===== 4. FEEDBACK / STATUS AREA ===== -->
    <div class="status-area">
        <div id="feedback-panel">Select a validation check and submit your diagnosis.</div>
        <div class="progress-tracker" id="progress-tracker"></div>
    </div>

    <!-- ===== 5. FLAG REVEAL AREA ===== -->
    <div class="flag-area" id="flag-area">
        <h3>Root Cause Report</h3>
        <table class="root-cause-table">
            <thead>
                <tr><th>Round</th><th>Flaw</th><th>Check That Catches It</th></tr>
            </thead>
            <tbody id="root-cause-body"></tbody>
        </table>
        <div class="flag-box" id="flag-box"></div>
    </div>

</div>

<!-- Spotlight tutorial elements -->
<div id="spotlight"></div>
<div id="tooltip-card">
    <div id="tooltip-text"></div>
    <div class="tt-actions">
        <button id="tt-skip">Skip Tutorial</button>
        <button id="tt-next" class="primary">Next</button>
    </div>
</div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA: five rounds, each with a raw assertion and the correct check
// ============================================================
const CHECKS = [
    { id: 'sig-scope', label: 'Signature Scope Validation' },
    { id: 'audience', label: 'Audience Restriction Validation' },
    { id: 'validity-window', label: 'Assertion Validity Window (Conditions)' },
    { id: 'xsw', label: 'XML Canonicalization / Wrapping Check' },
    { id: 'recipient', label: 'SubjectConfirmation Recipient Validation' },
];

const ROUNDS = [
    {
        title: 'Round 1',
        flawLabel: 'Signature Reference covers only the inner Assertion element',
        correct: 'sig-scope',
        xml:
`<samlp:Response ID="_resp001" IssueInstant="2026-07-08T10:15:00Z">
  <saml:Issuer>https://idp.example.com</saml:Issuer>
  <saml:Assertion ID="_assert001" IssueInstant="2026-07-08T10:15:00Z">
    <saml:Issuer>https://idp.example.com</saml:Issuer>
    <ds:Signature>
      <ds:SignedInfo>
        <ds:Reference URI="#_assert001">
          <ds:DigestValue>c3RyaXBwZWQ=</ds:DigestValue>
        </ds:Reference>
      </ds:SignedInfo>
      <ds:SignatureValue>c2lnbmVkX2NvcnJlY3RseQ==</ds:SignatureValue>
    </ds:Signature>
    <saml:Subject>
      <saml:NameID>jsmith@example.com</saml:NameID>
      <saml:SubjectConfirmation Method="urn:oasis:names:tc:SAML:2.0:cm:bearer">
        <saml:SubjectConfirmationData Recipient="https://sp.example.com/acs" NotOnOrAfter="2026-07-08T10:20:00Z"/>
      </saml:SubjectConfirmation>
    </saml:Subject>
    <saml:Conditions NotBefore="2026-07-08T10:10:00Z" NotOnOrAfter="2026-07-08T10:20:00Z">
      <saml:AudienceRestriction>
        <saml:Audience>https://sp.example.com</saml:Audience>
      </saml:AudienceRestriction>
    </saml:Conditions>
  </saml:Assertion>
</samlp:Response>`,
        feedbackCorrect: 'Correct. The signature Reference URI only covers the Assertion element, not the enclosing Response. An attacker can alter fields in the outer Response without invalidating the signature.',
        feedbackIncorrect: 'Not quite. Look at what the ds:Reference URI actually points to, and compare that to which element the SP is expected to trust.',
    },
    {
        title: 'Round 2',
        flawLabel: 'AudienceRestriction is missing from Conditions',
        correct: 'audience',
        xml:
`<samlp:Response ID="_resp002" IssueInstant="2026-07-08T11:02:00Z">
  <saml:Issuer>https://idp.example.com</saml:Issuer>
  <saml:Assertion ID="_assert002" IssueInstant="2026-07-08T11:02:00Z">
    <saml:Issuer>https://idp.example.com</saml:Issuer>
    <ds:Signature>
      <ds:SignedInfo>
        <ds:Reference URI="#_assert002">
          <ds:DigestValue>ZnVsbERpZ2VzdA==</ds:DigestValue>
        </ds:Reference>
      </ds:SignedInfo>
      <ds:SignatureValue>c2lnbmVkX2NvcnJlY3RseQ==</ds:SignatureValue>
    </ds:Signature>
    <saml:Subject>
      <saml:NameID>agarcia@example.com</saml:NameID>
      <saml:SubjectConfirmation Method="urn:oasis:names:tc:SAML:2.0:cm:bearer">
        <saml:SubjectConfirmationData Recipient="https://sp.example.com/acs" NotOnOrAfter="2026-07-08T11:07:00Z"/>
      </saml:SubjectConfirmation>
    </saml:Subject>
    <saml:Conditions NotBefore="2026-07-08T10:57:00Z" NotOnOrAfter="2026-07-08T11:07:00Z">
    </saml:Conditions>
  </saml:Assertion>
</samlp:Response>`,
        feedbackCorrect: 'Correct. There is no AudienceRestriction element at all inside Conditions. Nothing stops this exact assertion from being replayed against a completely different SP.',
        feedbackIncorrect: 'Not quite. Look closely inside the Conditions element for a child that restricts which SP may accept this assertion.',
    },
    {
        title: 'Round 3',
        flawLabel: 'NotOnOrAfter is set before the assertion was even issued',
        correct: 'validity-window',
        xml:
`<samlp:Response ID="_resp003" IssueInstant="2026-07-08T12:30:00Z">
  <saml:Issuer>https://idp.example.com</saml:Issuer>
  <saml:Assertion ID="_assert003" IssueInstant="2026-07-08T12:30:00Z">
    <saml:Issuer>https://idp.example.com</saml:Issuer>
    <ds:Signature>
      <ds:SignedInfo>
        <ds:Reference URI="#_assert003">
          <ds:DigestValue>dmFsaWREaWdlc3Q=</ds:DigestValue>
        </ds:Reference>
      </ds:SignedInfo>
      <ds:SignatureValue>c2lnbmVkX2NvcnJlY3RseQ==</ds:SignatureValue>
    </ds:Signature>
    <saml:Subject>
      <saml:NameID>rkhan@example.com</saml:NameID>
      <saml:SubjectConfirmation Method="urn:oasis:names:tc:SAML:2.0:cm:bearer">
        <saml:SubjectConfirmationData Recipient="https://sp.example.com/acs" NotOnOrAfter="2026-07-08T12:35:00Z"/>
      </saml:SubjectConfirmation>
    </saml:Subject>
    <saml:Conditions NotBefore="2026-07-08T12:20:00Z" NotOnOrAfter="2026-07-08T09:00:00Z">
      <saml:AudienceRestriction>
        <saml:Audience>https://sp.example.com</saml:Audience>
      </saml:AudienceRestriction>
    </saml:Conditions>
  </saml:Assertion>
</samlp:Response>`,
        feedbackCorrect: 'Correct. The Conditions NotOnOrAfter timestamp is earlier than the assertion IssueInstant. This assertion is already expired the moment it is issued and should never be accepted.',
        feedbackIncorrect: 'Not quite. Compare the assertion IssueInstant to the NotOnOrAfter value inside Conditions.',
    },
    {
        title: 'Round 4',
        flawLabel: 'A second, unsigned Assertion element carries different attributes',
        correct: 'xsw',
        xml:
`<samlp:Response ID="_resp004" IssueInstant="2026-07-08T13:45:00Z">
  <saml:Issuer>https://idp.example.com</saml:Issuer>
  <saml:Assertion ID="_assert004" IssueInstant="2026-07-08T13:45:00Z">
    <saml:Issuer>https://idp.example.com</saml:Issuer>
    <ds:Signature>
      <ds:SignedInfo>
        <ds:Reference URI="#_assert004">
          <ds:DigestValue>b3JpZ2luYWxEaWdlc3Q=</ds:DigestValue>
        </ds:Reference>
      </ds:SignedInfo>
      <ds:SignatureValue>c2lnbmVkX2NvcnJlY3RseQ==</ds:SignatureValue>
    </ds:Signature>
    <saml:Subject><saml:NameID>tomlin@example.com</saml:NameID></saml:Subject>
    <saml:AttributeStatement>
      <saml:Attribute Name="role"><saml:AttributeValue>guest</saml:AttributeValue></saml:Attribute>
    </saml:AttributeStatement>
  </saml:Assertion>
  <saml:Assertion ID="_assert004_dup" IssueInstant="2026-07-08T13:45:00Z">
    <saml:Issuer>https://idp.example.com</saml:Issuer>
    <saml:Subject><saml:NameID>tomlin@example.com</saml:NameID></saml:Subject>
    <saml:AttributeStatement>
      <saml:Attribute Name="role"><saml:AttributeValue>admin</saml:AttributeValue></saml:Attribute>
    </saml:AttributeStatement>
  </saml:Assertion>
</samlp:Response>`,
        feedbackCorrect: 'Correct. This is an XML Signature Wrapping pattern. A second, unsigned Assertion with a different role attribute rides alongside the legitimately signed one, hoping the SP reads the wrong copy.',
        feedbackIncorrect: 'Not quite. Count the Assertion elements in this Response, and notice that only one of them has a Signature.',
    },
    {
        title: 'Round 5',
        flawLabel: 'Recipient points to a different SP than the one that received it',
        correct: 'recipient',
        xml:
`<samlp:Response ID="_resp005" IssueInstant="2026-07-08T14:12:00Z">
  <saml:Issuer>https://idp.example.com</saml:Issuer>
  <saml:Assertion ID="_assert005" IssueInstant="2026-07-08T14:12:00Z">
    <saml:Issuer>https://idp.example.com</saml:Issuer>
    <ds:Signature>
      <ds:SignedInfo>
        <ds:Reference URI="#_assert005">
          <ds:DigestValue>dmFsaWREaWdlc3Q1</ds:DigestValue>
        </ds:Reference>
      </ds:SignedInfo>
      <ds:SignatureValue>c2lnbmVkX2NvcnJlY3RseQ==</ds:SignatureValue>
    </ds:Signature>
    <saml:Subject>
      <saml:NameID>lperez@example.com</saml:NameID>
      <saml:SubjectConfirmation Method="urn:oasis:names:tc:SAML:2.0:cm:bearer">
        <saml:SubjectConfirmationData Recipient="https://partner-sp.example.com/acs" NotOnOrAfter="2026-07-08T14:17:00Z"/>
      </saml:SubjectConfirmation>
    </saml:Subject>
    <saml:Conditions NotBefore="2026-07-08T14:07:00Z" NotOnOrAfter="2026-07-08T14:17:00Z">
      <saml:AudienceRestriction>
        <saml:Audience>https://sp.example.com</saml:Audience>
      </saml:AudienceRestriction>
    </saml:Conditions>
  </saml:Assertion>
</samlp:Response>
<!-- Received at: https://sp.example.com/acs -->`,
        feedbackCorrect: 'Correct. The Recipient in SubjectConfirmationData points to https://partner-sp.example.com/acs, but this response arrived at https://sp.example.com/acs. The assertion was meant for a different SP entirely.',
        feedbackIncorrect: 'Not quite. Compare the Recipient attribute inside SubjectConfirmationData to the ACS URL that actually received this response, noted in the comment at the bottom.',
    },
];

const FLAG = 'CBX{forgery_detected}';

// ============================================================
// STATE
// ============================================================
let currentRound = 0;
let selectedCheckId = null;
const results = [];

// ============================================================
// SIMPLE XML HIGHLIGHTER
// ============================================================
function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function highlightXml(raw) {
    const escaped = escapeHtml(raw);
    return escaped
        .replace(/(&lt;!--.*?--&gt;)/gs, '<span style="color:var(--text-muted)">$1</span>')
        .replace(/(&lt;\/?[a-zA-Z0-9:._-]+)/g, '<span class="xml-tag">$1</span>')
        .replace(/([a-zA-Z0-9:._-]+)(=)(&quot;|")/g, '<span class="xml-attr">$1</span>$2$3')
        .replace(/(=")([^"]*)(")/g, '$1<span class="xml-value">$2</span>$3');
}

// ============================================================
// RENDERING
// ============================================================
function renderRound() {
    const round = ROUNDS[currentRound];
    document.getElementById('round-indicator').textContent = `Round ${currentRound + 1} of ${ROUNDS.length}`;
    document.getElementById('xml-panel').innerHTML = highlightXml(round.xml);

    const checklist = document.getElementById('validation-checklist');
    checklist.innerHTML = '';
    selectedCheckId = null;
    CHECKS.forEach(check => {
        const btn = document.createElement('button');
        btn.className = 'check-option';
        btn.textContent = check.label;
        btn.dataset.checkId = check.id;
        btn.addEventListener('click', () => {
            document.querySelectorAll('.check-option').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            selectedCheckId = check.id;
            document.getElementById('submit-diagnosis-btn').disabled = false;
        });
        checklist.appendChild(btn);
    });

    document.getElementById('submit-diagnosis-btn').disabled = true;
    document.getElementById('submit-diagnosis-btn').textContent = 'Submit Diagnosis';
    const fb = document.getElementById('feedback-panel');
    fb.className = '';
    fb.textContent = 'Select a validation check and submit your diagnosis.';

    renderProgress();
}

function renderProgress() {
    const tracker = document.getElementById('progress-tracker');
    tracker.innerHTML = '';
    for (let i = 0; i < ROUNDS.length; i++) {
        const dot = document.createElement('div');
        dot.className = 'progress-dot';
        if (i < currentRound) dot.classList.add('done');
        if (i === currentRound) dot.classList.add('active');
        tracker.appendChild(dot);
    }
}

function advanceRound() {
    currentRound++;
    document.querySelectorAll('.check-option').forEach(b => b.style.pointerEvents = 'auto');

    if (currentRound >= ROUNDS.length) {
        revealFlag();
        return;
    }
    renderRound();
    const btn = document.getElementById('submit-diagnosis-btn');
    btn.removeEventListener('click', advanceRound);
    btn.addEventListener('click', submitHandler);
}

function submitHandler() {
    const round = ROUNDS[currentRound];
    const fb = document.getElementById('feedback-panel');
    const isCorrect = selectedCheckId === round.correct;

    if (isCorrect) {
        fb.className = 'correct';
        fb.textContent = round.feedbackCorrect;
        results.push({
            title: round.title,
            flaw: round.flawLabel,
            check: CHECKS.find(c => c.id === round.correct).label,
        });
        document.getElementById('submit-diagnosis-btn').textContent = 'Next Round';
        const btn = document.getElementById('submit-diagnosis-btn');
        btn.removeEventListener('click', submitHandler);
        btn.addEventListener('click', advanceRound);
        document.querySelectorAll('.check-option').forEach(b => b.style.pointerEvents = 'none');
    } else {
        fb.className = 'incorrect';
        fb.textContent = round.feedbackIncorrect;
    }
}

document.getElementById('submit-diagnosis-btn').addEventListener('click', submitHandler);

function revealFlag() {
    const area = document.getElementById('flag-area');
    const body = document.getElementById('root-cause-body');
    body.innerHTML = '';
    results.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.title}</td><td>${r.flaw}</td><td>${r.check}</td>`;
        body.appendChild(tr);
    });
    document.getElementById('flag-box').textContent = FLAG;
    area.classList.add('revealed');
    area.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const TUTORIAL_STEPS = [
    { targetId: 'xml-panel', text: 'This is the raw SAML assertion your SP just received from the IdP, decoded and formatted. This is exactly what a real SP parses on every login.' },
    { targetId: 'round-indicator', text: 'You will review five separate assertions, one at a time. Each one has a single planted flaw.' },
    { targetId: 'validation-checklist', text: 'These are the validation checks a compliant SP must run on every assertion it receives.' },
    { targetId: 'submit-diagnosis-btn', text: 'Once you have identified which check should catch the flaw, submit your diagnosis here.' },
    { targetId: 'feedback-panel', text: 'This tells you if you are right, and explains the real consequence if this check were skipped in production.' },
    { targetId: 'progress-tracker', text: 'This tracks how many of the five rounds you have completed.' },
    { targetId: 'view-tutorial-btn', text: 'You can replay this tutorial at any time from here.' },
];

let tutorialStepIndex = 0;

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    const spotlight = document.getElementById('spotlight');
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    const tooltip = document.getElementById('tooltip-card');
    tooltip.style.display = 'block';

    // Decide placement: prefer bottom, fall back to top, then right, then left
    const ttRect = tooltip.getBoundingClientRect();
    let top, left;
    const spaceBelow = window.innerHeight - rect.bottom;
    const spaceAbove = rect.top;

    if (spaceBelow > ttRect.height + 20) {
        top = rect.bottom + pad + 8;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - ttRect.width - 10);
    } else if (spaceAbove > ttRect.height + 20) {
        top = rect.top - ttRect.height - pad - 8;
        left = Math.min(Math.max(rect.left, 10), window.innerWidth - ttRect.width - 10);
    } else if (window.innerWidth - rect.right > ttRect.width + 20) {
        top = Math.min(Math.max(rect.top, 10), window.innerHeight - ttRect.height - 10);
        left = rect.right + pad + 8;
    } else {
        top = Math.min(Math.max(rect.top, 10), window.innerHeight - ttRect.height - 10);
        left = rect.left - ttRect.width - pad - 8;
    }

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

function showTutorialStep(index) {
    if (index >= TUTORIAL_STEPS.length) {
        endTutorial();
        showCompleteModal();
        return;
    }
    tutorialStepIndex = index;
    const step = TUTORIAL_STEPS[index];
    const el = document.getElementById(step.targetId);
    if (!el) { showTutorialStep(index + 1); return; }

    document.getElementById('tooltip-text').textContent = step.text;
    document.getElementById('tt-next').textContent = (index === TUTORIAL_STEPS.length - 1) ? 'Finish' : 'Next';

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(el), 320);
    } else {
        positionSpotlight(el);
    }
}

function startTutorial() {
    document.getElementById('spotlight').style.display = 'block';
    document.getElementById('tooltip-card').style.display = 'block';
    showTutorialStep(0);
}

function endTutorial() {
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tooltip-card').style.display = 'none';
}

function showCompleteModal() {
    document.getElementById('tutorial-complete-modal').classList.add('show');
}

document.getElementById('view-tutorial-btn').addEventListener('click', () => {
    tutorialStepIndex = 0;
    startTutorial();
});

document.getElementById('tt-next').addEventListener('click', () => {
    showTutorialStep(tutorialStepIndex + 1);
});

document.getElementById('tt-skip').addEventListener('click', () => {
    endTutorial();
});

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').classList.remove('show');
});

window.addEventListener('resize', () => {
    const tooltipVisible = document.getElementById('tooltip-card').style.display === 'block';
    if (tooltipVisible && TUTORIAL_STEPS[tutorialStepIndex]) {
        const el = document.getElementById(TUTORIAL_STEPS[tutorialStepIndex].targetId);
        if (el) positionSpotlight(el);
    }
});

// ============================================================
// INIT
// ============================================================
renderRound();
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
