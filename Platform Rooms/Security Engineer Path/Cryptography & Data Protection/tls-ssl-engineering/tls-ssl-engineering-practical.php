<?php
// Filename: tls-ssl-engineering-practical.php
// Standalone static practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TLS Handshake Inspector</title>
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

.wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ===== Header ===== */
.top-header {
    position: relative;
    background: linear-gradient(135deg, var(--bg-secondary), var(--bg-primary));
    border-bottom: 1px solid var(--border-default);
    padding: 28px 0;
}
.top-header .wrap { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; }
.top-header h1 { margin: 0 0 6px 0; font-size: 1.6rem; font-weight: 700; }
.top-header p { margin: 0; color: var(--text-secondary); font-size: 0.95rem; max-width: 640px; }

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover { background: rgba(106,227,255,0.08); box-shadow: var(--glow-accent); }

/* ===== Description ===== */
.brief {
    margin: 24px 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px 22px;
}
.brief h2 { margin: 0 0 8px 0; font-size: 1.05rem; }
.brief p { margin: 6px 0; color: var(--text-secondary); font-size: 0.92rem; }

/* ===== Progress ===== */
.progress-bar-row {
    display: flex;
    gap: 20px;
    margin: 20px 0;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    color: var(--text-muted);
    flex-wrap: wrap;
}
.progress-bar-row span.count { color: var(--accent-primary); font-weight: 700; }

/* ===== Handshake columns ===== */
.columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin: 10px 0 30px 0;
}
@media (max-width: 760px) {
    .columns { grid-template-columns: 1fr; }
}
.column {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.column h3 {
    margin: 0 0 14px 0;
    font-size: 1.05rem;
    text-align: center;
    color: var(--text-primary);
}
.msg-card {
    border: 1px solid var(--border-default);
    border-radius: 8px;
    margin-bottom: 10px;
    overflow: hidden;
    background: var(--bg-secondary);
}
.msg-card-head {
    padding: 12px 14px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.88rem;
    font-weight: 600;
    transition: background 0.2s ease;
}
.msg-card-head:hover { background: rgba(106,227,255,0.05); }
.msg-card.reviewed .msg-card-head { color: var(--success); }
.msg-card.reviewed .msg-card-head::after { content: "✓"; color: var(--success); font-weight: 700; }
.msg-card-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.25s ease, padding 0.25s ease;
    padding: 0 14px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    color: var(--text-secondary);
}
.msg-card.open .msg-card-body {
    max-height: 260px;
    padding: 0 14px 14px 14px;
}
.msg-card-body .field-line { margin: 4px 0; }
.msg-card-body .weak { color: var(--error); font-weight: 700; }
.msg-card-body .strong { color: var(--success); }
.chevron { color: var(--text-muted); font-size: 0.75rem; transition: transform 0.2s ease; }
.msg-card.open .chevron { transform: rotate(90deg); }

/* ===== Quiz panel ===== */
.quiz-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 22px;
    margin: 10px 0 30px 0;
    transition: opacity 0.3s ease;
}
.quiz-panel.locked {
    opacity: 0.4;
    pointer-events: none;
    position: relative;
}
.quiz-panel h3 { margin-top: 0; font-size: 1.05rem; }
.quiz-lock-note {
    font-size: 0.82rem;
    color: var(--warning);
    margin-bottom: 14px;
}
.quiz-q { margin: 18px 0; }
.quiz-q label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-primary); }
.quiz-q input[type="text"] {
    width: 100%;
    max-width: 420px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 10px 12px;
    color: var(--text-primary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
}
.quiz-q input[type="text"]:focus { outline: none; border-color: var(--accent-primary); }
.quiz-feedback { font-size: 0.82rem; margin-top: 6px; min-height: 18px; }
.quiz-feedback.correct { color: var(--success); }
.quiz-feedback.incorrect { color: var(--error); }

.check-btn {
    margin-top: 8px;
    background: var(--accent-primary);
    color: #06121c;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    transition: transform 0.15s ease;
}
.check-btn:hover { transform: translateY(-1px); }

/* ===== Status / flag area ===== */
.status-area { min-height: 20px; margin: 10px 0; font-size: 0.85rem; color: var(--text-muted); }

.flag-panel {
    display: none;
    background: linear-gradient(135deg, #0f2027, #16323e);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 26px;
    text-align: center;
    box-shadow: 0 0 24px rgba(61,255,154,0.15);
}
.flag-panel.show { display: block; }
.flag-panel h3 { margin: 0 0 6px 0; color: var(--success); }
.flag-panel p { color: var(--text-secondary); font-size: 0.88rem; margin: 6px 0 16px 0; }
.flag-value {
    display: inline-block;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--success);
    background: rgba(61,255,154,0.08);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 12px 24px;
    letter-spacing: 0.02em;
}

/* ===== Spotlight tutorial ===== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
    pointer-events: none;
    z-index: 998;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 999;
    box-shadow: var(--glow-accent);
    font-size: 0.86rem;
}
.tooltip-card p { margin: 0 0 14px 0; color: var(--text-secondary); }
.tooltip-actions { display: flex; justify-content: space-between; align-items: center; }
.tooltip-actions .step-count { font-size: 0.75rem; color: var(--text-muted); font-family: "JetBrains Mono", monospace; }
.tooltip-actions button {
    background: var(--accent-primary);
    color: #06121c;
    border: none;
    padding: 7px 16px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: inherit;
}
.tooltip-skip {
    background: transparent !important;
    color: var(--text-muted) !important;
    padding: 7px 8px !important;
    font-weight: 500 !important;
}

/* ===== Completion modal ===== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.show { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-card h3 { margin: 0 0 10px 0; }
.modal-card p { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 20px; }
.modal-card button {
    background: var(--accent-primary);
    color: #06121c;
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
}
</style>
</head>
<body>

<header class="top-header" id="page-header">
    <div class="wrap">
        <div>
            <h1>TLS Handshake Inspector</h1>
            <p>A side by side capture of a TLS 1.2 and a TLS 1.3 handshake against the same server. Inspect every message to find the deprecated cipher suite and the message TLS 1.3 removes entirely.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>
</header>

<div class="wrap">
    <div class="brief">
        <h2>Mission Briefing</h2>
        <p>This environment represents a packet capture review tool used to diagnose TLS handshake behavior. Your goal is to expand every handshake message in both the TLS 1.2 and TLS 1.3 columns, then answer two short analysis questions to reveal your flag.</p>
        <p>Click a message card to expand it and read the real field data inside. A checkmark appears once you have reviewed a card.</p>
    </div>

    <div class="progress-bar-row">
        <div>TLS 1.2 reviewed: <span class="count" id="progress-12">0 / 6</span></div>
        <div>TLS 1.3 reviewed: <span class="count" id="progress-13">0 / 4</span></div>
    </div>

    <div class="columns">
        <div class="column" id="tls12-column">
            <h3>TLS 1.2 Handshake</h3>

            <div class="msg-card" id="card-clienthello-tls12" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>ClientHello</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">version: TLS 1.2</div>
                    <div class="field-line">random: 8f3a...c412</div>
                    <div class="field-line">cipher_suites:</div>
                    <div class="field-line strong">&nbsp;&nbsp;TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256</div>
                    <div class="field-line strong">&nbsp;&nbsp;TLS_ECDHE_RSA_WITH_AES_256_GCM_SHA384</div>
                    <div class="field-line weak">&nbsp;&nbsp;TLS_RSA_WITH_RC4_128_SHA</div>
                    <div class="field-line">extensions: server_name, signature_algorithms</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>ServerHello</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">version: TLS 1.2</div>
                    <div class="field-line">cipher_suite chosen:</div>
                    <div class="field-line strong">&nbsp;&nbsp;TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256</div>
                    <div class="field-line">session_id: 4c9d...0021</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>Certificate</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">subject: CN=example.com</div>
                    <div class="field-line">issuer: CN=Example Intermediate CA</div>
                    <div class="field-line">signature_algorithm: sha256WithRSAEncryption</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>ServerKeyExchange</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">curve: secp256r1</div>
                    <div class="field-line">ephemeral_public_key: 04a1...9e3f</div>
                    <div class="field-line">signature: RSA over params</div>
                    <div class="field-line">note: only present when key exchange is negotiated separately from authentication</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>ClientKeyExchange</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">client_ephemeral_public_key: 04c7...2b10</div>
                    <div class="field-line">pre_master_secret derivation: ECDHE shared secret</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>Finished</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">verify_data (client): 3f2a...c9</div>
                    <div class="field-line">verify_data (server): 8b19...f4</div>
                    <div class="field-line">handshake_complete: true</div>
                </div>
            </div>
        </div>

        <div class="column" id="tls13-column">
            <h3>TLS 1.3 Handshake</h3>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>ClientHello + key_share</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">version: TLS 1.3</div>
                    <div class="field-line">key_share: x25519 4a7f...1c02</div>
                    <div class="field-line">cipher_suites:</div>
                    <div class="field-line strong">&nbsp;&nbsp;TLS_AES_128_GCM_SHA256</div>
                    <div class="field-line strong">&nbsp;&nbsp;TLS_CHACHA20_POLY1305_SHA256</div>
                    <div class="field-line">supported_versions: TLS 1.3</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>ServerHello + key_share</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">version: TLS 1.3</div>
                    <div class="field-line">key_share: x25519 9d3e...7a44</div>
                    <div class="field-line">cipher_suite chosen: TLS_AES_128_GCM_SHA256</div>
                    <div class="field-line">note: key exchange complete after this message</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>Encrypted Extensions</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">extensions sent encrypted, unlike TLS 1.2</div>
                    <div class="field-line">server_name acknowledged</div>
                    <div class="field-line">no separate ServerKeyExchange message needed</div>
                </div>
            </div>

            <div class="msg-card" data-msg>
                <div class="msg-card-head" onclick="toggleCard(this.parentElement)">
                    <span>Certificate + Finished</span>
                    <span class="chevron">▶</span>
                </div>
                <div class="msg-card-body">
                    <div class="field-line">subject: CN=example.com</div>
                    <div class="field-line">certificate_verify: signature over transcript hash</div>
                    <div class="field-line">finished (server): 7c11...9a</div>
                    <div class="field-line">finished (client): a2f0...3d</div>
                    <div class="field-line">handshake_complete: true, 1-RTT achieved</div>
                </div>
            </div>
        </div>
    </div>

    <div class="quiz-panel locked" id="quiz-panel">
        <p class="quiz-lock-note" id="quiz-lock-note">Expand every message card in both columns to unlock this quiz.</p>
        <h3>Handshake Analysis</h3>

        <div class="quiz-q">
            <label for="q1-input">1. Which TLS 1.2 handshake message is eliminated in TLS 1.3?</label>
            <input type="text" id="q1-input" autocomplete="off">
            <div class="quiz-feedback" id="q1-feedback"></div>
        </div>

        <div class="quiz-q">
            <label for="q2-input">2. Which cipher suite offered in the TLS 1.2 ClientHello is considered weak or deprecated?</label>
            <input type="text" id="q2-input" autocomplete="off">
            <div class="quiz-feedback" id="q2-feedback"></div>
        </div>

        <button class="check-btn" onclick="checkQuiz()">Check Answers</button>
        <div class="status-area" id="quiz-status"></div>
    </div>

    <div class="flag-panel" id="flag-panel">
        <h3>Handshake Analysis Complete</h3>
        <p>You correctly identified the removed handshake message and the deprecated cipher suite. TLS 1.3 folds key exchange into fewer messages and drops legacy ciphers at the protocol level.</p>
        <div class="flag-value">CBX{handshake_decoded}</div>
    </div>
</div>

<div class="modal-overlay" id="completion-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're Ready to Start the Challenge</p>
        <button onclick="closeCompletionModal()">Start Challenge</button>
    </div>
</div>

<script>
// ===== Card expand/collapse and progress tracking =====
function toggleCard(card) {
    const wasOpen = card.classList.contains('open');
    card.classList.toggle('open');
    if (!wasOpen) {
        card.classList.add('reviewed');
    }
    updateProgress();
}

function updateProgress() {
    const col12 = document.getElementById('tls12-column');
    const col13 = document.getElementById('tls13-column');
    const reviewed12 = col12.querySelectorAll('.msg-card.reviewed').length;
    const reviewed13 = col13.querySelectorAll('.msg-card.reviewed').length;
    const total12 = col12.querySelectorAll('.msg-card').length;
    const total13 = col13.querySelectorAll('.msg-card').length;

    document.getElementById('progress-12').textContent = reviewed12 + ' / ' + total12;
    document.getElementById('progress-13').textContent = reviewed13 + ' / ' + total13;

    const quizPanel = document.getElementById('quiz-panel');
    const lockNote = document.getElementById('quiz-lock-note');
    if (reviewed12 === total12 && reviewed13 === total13) {
        quizPanel.classList.remove('locked');
        lockNote.style.display = 'none';
    } else {
        quizPanel.classList.add('locked');
        lockNote.style.display = 'block';
    }
}

// ===== Quiz validation =====
let q1Correct = false;
let q2Correct = false;

function checkQuiz() {
    const q1val = document.getElementById('q1-input').value.trim().toLowerCase();
    const q2val = document.getElementById('q2-input').value.trim().toLowerCase();
    const q1fb = document.getElementById('q1-feedback');
    const q2fb = document.getElementById('q2-feedback');

    q1Correct = q1val.includes('serverkeyexchange');
    q2Correct = q2val.includes('rc4');

    q1fb.textContent = q1Correct ? 'Correct.' : 'Not quite. Look again at what appears in TLS 1.2 but not in TLS 1.3.';
    q1fb.className = 'quiz-feedback ' + (q1Correct ? 'correct' : 'incorrect');

    q2fb.textContent = q2Correct ? 'Correct.' : 'Not quite. Re-check the cipher suite list in the TLS 1.2 ClientHello.';
    q2fb.className = 'quiz-feedback ' + (q2Correct ? 'correct' : 'incorrect');

    const status = document.getElementById('quiz-status');
    if (q1Correct && q2Correct) {
        status.textContent = 'Both answers correct. Revealing flag.';
        document.getElementById('flag-panel').classList.add('show');
        document.getElementById('flag-panel').scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        status.textContent = 'Review your answers and try again.';
    }
}

// ===== Spotlight tutorial system =====
const tutorialSteps = [
    { id: 'page-header', text: 'Welcome to the TLS Handshake Inspector. You will compare a real TLS 1.2 handshake against TLS 1.3 side by side, message by message.' },
    { id: 'tls12-column', text: 'This column shows the TLS 1.2 handshake. Click any message card to expand its real field data.' },
    { id: 'tls13-column', text: 'This column shows the equivalent TLS 1.3 handshake. Notice it has fewer messages before encryption begins.' },
    { id: 'card-clienthello-tls12', text: 'Try clicking this card. Expanding it reveals the cipher suites the client is offering, including one that should not be used anymore.' },
    { id: 'quiz-panel', text: 'Once you have expanded every message in both columns, this quiz unlocks. Answer both questions to reveal your flag.' },
    { id: 'view-tutorial-btn', text: 'You can replay this tutorial anytime from this button.' }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) {
        spotlightEl = document.createElement('div');
        spotlightEl.className = 'spotlight';
        document.body.appendChild(spotlightEl);
    }
    if (!tooltipEl) {
        tooltipEl = document.createElement('div');
        tooltipEl.className = 'tooltip-card';
        document.body.appendChild(tooltipEl);
    }
    spotlightEl.style.display = 'block';
    tooltipEl.style.display = 'block';
    showStep(currentStep);
}

function showStep(index) {
    const step = tutorialSteps[index];
    const target = document.getElementById(step.id);
    if (!target) { nextStep(); return; }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(target, step, index), 320);
    } else {
        positionSpotlight(target, step, index);
    }
}

function positionSpotlight(target, step, index) {
    const rect = target.getBoundingClientRect();
    const pad = 8;

    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    tooltipEl.innerHTML =
        '<p>' + step.text + '</p>' +
        '<div class="tooltip-actions">' +
        '<span class="step-count">' + (index + 1) + ' / ' + tutorialSteps.length + '</span>' +
        '<div>' +
        '<button class="tooltip-skip" onclick="skipTutorial()">Skip</button> ' +
        '<button onclick="nextStep()">' + (index === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
        '</div></div>';

    let top = rect.bottom + pad + 12;
    let left = rect.left;
    const tooltipWidth = 300;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 140 > window.innerHeight) {
        top = rect.top - 160;
        if (top < 10) top = 10;
    }

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        showCompletionModal();
        return;
    }
    showStep(currentStep);
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    if (spotlightEl) spotlightEl.style.display = 'none';
    if (tooltipEl) tooltipEl.style.display = 'none';
}

function showCompletionModal() {
    document.getElementById('completion-modal').classList.add('show');
}
function closeCompletionModal() {
    document.getElementById('completion-modal').classList.remove('show');
}

window.addEventListener('resize', () => {
    if (spotlightEl && spotlightEl.style.display === 'block' && tutorialSteps[currentStep]) {
        const target = document.getElementById(tutorialSteps[currentStep].id);
        if (target) positionSpotlight(target, tutorialSteps[currentStep], currentStep);
    }
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('load', () => {
    updateProgress();
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
