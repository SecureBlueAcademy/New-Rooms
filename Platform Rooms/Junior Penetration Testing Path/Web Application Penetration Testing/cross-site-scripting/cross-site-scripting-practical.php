<?php
// ============================================================
// cross-site-scripting-practical.php
// Comment Board Injection Lab
// Standalone static practical: HTML, CSS, vanilla JS only.
// No backend logic, no database, no sessions, no external APIs.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Comment Board Injection Lab</title>
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
    padding: 24px;
}

.wrapper {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
}

/* ===== Header ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 8px;
}

.header h1 {
    font-size: 1.6rem;
    margin: 0 0 6px 0;
}

.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
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
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}

.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* ===== Description ===== */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin: 20px 0 28px 0;
}

.mission-briefing h2 {
    margin: 0 0 8px 0;
    font-size: 1.05rem;
    color: var(--accent-primary);
}

.mission-briefing p {
    margin: 6px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}

/* ===== Rounds ===== */
.round {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 24px;
    position: relative;
}

.round-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}

.round-number {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-secondary);
    flex-shrink: 0;
}

.round.complete .round-number {
    background: var(--success);
    border-color: var(--success);
    color: #06231a;
}

.round-header h3 {
    margin: 0;
    font-size: 1.05rem;
    flex-grow: 1;
}

.status-pill {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    background: var(--bg-surface);
    color: var(--text-muted);
    border: 1px solid var(--border-default);
    letter-spacing: 0.03em;
}

.round.complete .status-pill {
    background: rgba(61,255,154,0.12);
    color: var(--success);
    border-color: var(--success);
}

.round p.instructions {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 14px 0;
}

input[type="text"] {
    width: 100%;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.88rem;
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom: 10px;
}

input[type="text"]:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

.btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 9px 18px;
    border-radius: 8px;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
}

.btn:hover {
    box-shadow: var(--glow-accent);
}

.btn.secondary {
    border-color: var(--accent-secondary);
    color: var(--accent-secondary);
}

/* Round 1 output */
.reflect-output {
    margin-top: 10px;
    background: var(--bg-primary);
    border: 1px dashed var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    min-height: 20px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    word-break: break-word;
}

.sim-alert {
    margin-top: 10px;
    background: rgba(255, 92, 92, 0.1);
    border: 1px solid var(--error);
    color: var(--error);
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-family: "JetBrains Mono", monospace;
}

/* Round 2 comments */
.comments-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin: 12px 0;
}

.comment-item {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.87rem;
    font-family: "JetBrains Mono", monospace;
    word-break: break-word;
}

.comment-item .comment-author {
    color: var(--accent-secondary);
    font-weight: 700;
    margin-right: 6px;
    font-family: "Inter", sans-serif;
}

.visitor-note {
    margin-top: 10px;
    font-size: 0.85rem;
    color: var(--success);
    font-family: "JetBrains Mono", monospace;
}

/* Round 3 */
.cookie-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 999px;
    padding: 8px 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--warning);
    margin-bottom: 14px;
}

.attacker-log-panel {
    margin-top: 12px;
    background: #05070d;
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    color: var(--text-muted);
    min-height: 60px;
}

.attacker-log-panel .log-line {
    margin: 4px 0;
}

.attacker-log-panel .log-line.hit {
    color: var(--error);
}

/* ===== Feedback / status area ===== */
.status-area {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin: 10px 0 28px 0;
}

.status-chip {
    flex: 1;
    min-width: 160px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 0.82rem;
    color: var(--text-muted);
    text-align: center;
}

.status-chip.done {
    color: var(--success);
    border-color: var(--success);
}

/* ===== Flag reveal ===== */
.flag-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 26px;
    text-align: center;
}

.flag-area.locked .flag-icon {
    color: var(--text-muted);
}

.flag-area .flag-icon {
    font-size: 1.6rem;
    color: var(--success);
    margin-bottom: 8px;
}

.flag-area h3 {
    margin: 0 0 10px 0;
    font-size: 1rem;
}

.flag-value {
    display: inline-block;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    font-weight: 700;
    padding: 10px 22px;
    border-radius: 8px;
    letter-spacing: 0.02em;
}

.flag-area.locked .flag-value {
    display: none;
}

.flag-area .locked-note {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.flag-area:not(.locked) .locked-note {
    display: none;
}

/* ===== Spotlight tutorial ===== */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: none;
    z-index: 9998;
}

.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}

.tutorial-tooltip p {
    margin: 0 0 14px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tutorial-tooltip .tt-skip {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 0.8rem;
    cursor: pointer;
    font-family: inherit;
}

.tutorial-tooltip .tt-next {
    background: var(--accent-primary);
    color: #06131a;
    border: none;
    font-weight: 700;
    font-size: 0.8rem;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-family: inherit;
}

.tt-step-count {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin-bottom: 8px;
}

/* ===== Modal ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

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
    margin: 0 0 10px 0;
}

.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 18px 0;
}

@media (max-width: 640px) {
    .header { flex-direction: column; }
    .status-area { flex-direction: column; }
}
</style>
</head>
<body>
<div class="wrapper">

    <!-- ===== SECTION 1: Header ===== -->
    <div class="header">
        <div>
            <h1>Comment Board Injection Lab</h1>
            <p class="subtitle">A simulated blog comment system with three separate XSS weaknesses waiting to be exploited.</p>
        </div>
        <button class="tutorial-btn" id="viewTutorialBtn">View Tutorial</button>
    </div>

    <!-- ===== SECTION 2: Description ===== -->
    <div class="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>This page represents a small blog post with a live comment section. None of the input fields below check or clean what you type before showing it back to you, or to other visitors. Your job is to prove it by triggering three separate weaknesses, one for each type of XSS you learned about in the room.</p>
        <p>Work through the three rounds below in order. Each round unlocks a status marker when you succeed. Once all three are marked complete, a flag will appear at the bottom of the page.</p>
    </div>

    <!-- ===== SECTION 3: Interactive environment ===== -->

    <!-- Round 1: Reflected XSS -->
    <div class="round" id="round1">
        <div class="round-header">
            <div class="round-number">1</div>
            <h3>Reflected XSS: Search Comments</h3>
            <div class="status-pill" id="round1Status">Incomplete</div>
        </div>
        <p class="instructions">This search box immediately reflects whatever you type into the panel below it, exactly like an unsanitized server-side search feature would. Try entering something that looks like executable code.</p>
        <input type="text" id="reflectSearchBox" placeholder="Search comments...">
        <div class="reflect-output" id="reflectOutput">Your search reflection will appear here.</div>
        <div id="reflectAlertContainer"></div>
    </div>

    <!-- Round 2: Stored XSS -->
    <div class="round" id="round2">
        <div class="round-header">
            <div class="round-number">2</div>
            <h3>Stored XSS: Leave a Comment</h3>
            <div class="status-pill" id="round2Status">Incomplete</div>
        </div>
        <p class="instructions">This comment field saves whatever you submit and displays it below, just like a real blog. Submit a payload, then simulate a brand new visitor loading the page to see it fire without them typing anything.</p>
        <input type="text" id="commentInput" placeholder="Write a comment...">
        <button class="btn" id="submitBtn">Post Comment</button>
        <div class="comments-list" id="commentsList"></div>
        <div id="visitorButtonContainer"></div>
        <div id="visitorNoteContainer"></div>
    </div>

    <!-- Round 3: DOM-based XSS -->
    <div class="round" id="round3">
        <div class="round-header">
            <div class="round-number">3</div>
            <h3>DOM-based XSS: Session Theft</h3>
            <div class="status-pill" id="round3Status">Incomplete</div>
        </div>
        <p class="instructions">Below is your simulated session cookie. This page also runs a client-side script that reads whatever you type and inserts it directly into the page without checking it. Craft an input that would cause that script to read the cookie and send it somewhere.</p>
        <div class="cookie-badge" id="cookieBadge">
            <span>🍪</span>
            <span id="cookieValue">session_id=7f3ac9e2</span>
        </div>
        <input type="text" id="domPayloadInput" placeholder="Enter a client-side payload...">
        <div class="attacker-log-panel" id="attackerLogPanel">
            <div class="log-line">Listening for incoming requests...</div>
        </div>
    </div>

    <!-- ===== SECTION 4: Feedback / status area ===== -->
    <div class="status-area">
        <div class="status-chip" id="statusChip1">Round 1: Reflected XSS pending</div>
        <div class="status-chip" id="statusChip2">Round 2: Stored XSS pending</div>
        <div class="status-chip" id="statusChip3">Round 3: DOM-based XSS pending</div>
    </div>

    <!-- ===== SECTION 5: Flag reveal ===== -->
    <div class="flag-area locked" id="flagArea">
        <div class="flag-icon">🔒</div>
        <h3>Session Flag</h3>
        <p class="locked-note">Complete all three rounds above to unlock the flag.</p>
        <div class="flag-value" id="flagValue">CBX{cookie_exfiltrated}</div>
    </div>

</div>

<!-- Spotlight elements (created dynamically, container placeholders not required) -->

<script>
(function () {
    "use strict";

    // ---------------------------------------------------------
    // State
    // ---------------------------------------------------------
    var state = { round1: false, round2: false, round3: false };
    var comments = [];

    var round1El = document.getElementById('round1');
    var round2El = document.getElementById('round2');
    var round3El = document.getElementById('round3');

    var round1Status = document.getElementById('round1Status');
    var round2Status = document.getElementById('round2Status');
    var round3Status = document.getElementById('round3Status');

    var statusChip1 = document.getElementById('statusChip1');
    var statusChip2 = document.getElementById('statusChip2');
    var statusChip3 = document.getElementById('statusChip3');

    var flagArea = document.getElementById('flagArea');

    function looksLikePayload(value) {
        var v = value.toLowerCase();
        return v.indexOf('<script') !== -1 ||
               v.indexOf('onerror=') !== -1 ||
               v.indexOf('onload=') !== -1 ||
               v.indexOf('javascript:') !== -1;
    }

    function checkAllComplete() {
        if (state.round1 && state.round2 && state.round3) {
            flagArea.classList.remove('locked');
            flagArea.querySelector('.flag-icon').textContent = '🏁';
        }
    }

    // ---------------------------------------------------------
    // Round 1: Reflected XSS
    // ---------------------------------------------------------
    var reflectSearchBox = document.getElementById('reflectSearchBox');
    var reflectOutput = document.getElementById('reflectOutput');
    var reflectAlertContainer = document.getElementById('reflectAlertContainer');

    reflectSearchBox.addEventListener('input', function () {
        var val = reflectSearchBox.value;
        reflectOutput.textContent = val.length ? ('Results for: ' + val) : 'Your search reflection will appear here.';

        if (looksLikePayload(val) && !state.round1) {
            state.round1 = true;
            round1El.classList.add('complete');
            round1Status.textContent = 'Complete';
            statusChip1.textContent = 'Round 1: Reflected XSS complete';
            statusChip1.classList.add('done');

            var alertBox = document.createElement('div');
            alertBox.className = 'sim-alert';
            alertBox.textContent = 'Simulated execution: the server reflected your input directly into the page and the browser treated it as code, not text.';
            reflectAlertContainer.innerHTML = '';
            reflectAlertContainer.appendChild(alertBox);

            checkAllComplete();
        }
    });

    // ---------------------------------------------------------
    // Round 2: Stored XSS
    // ---------------------------------------------------------
    var commentInput = document.getElementById('commentInput');
    var submitBtn = document.getElementById('submitBtn');
    var commentsList = document.getElementById('commentsList');
    var visitorButtonContainer = document.getElementById('visitorButtonContainer');
    var visitorNoteContainer = document.getElementById('visitorNoteContainer');
    var storedPayloadSubmitted = false;

    function renderComments() {
        commentsList.innerHTML = '';
        comments.forEach(function (c) {
            var item = document.createElement('div');
            item.className = 'comment-item';
            var author = document.createElement('span');
            author.className = 'comment-author';
            author.textContent = c.author + ':';
            item.appendChild(author);
            var text = document.createElement('span');
            text.textContent = ' ' + c.text;
            item.appendChild(text);
            commentsList.appendChild(item);

            if (looksLikePayload(c.text)) {
                var flagLine = document.createElement('div');
                flagLine.className = 'sim-alert';
                flagLine.style.marginTop = '4px';
                flagLine.textContent = 'Simulated execution: this comment ran automatically when the page loaded.';
                commentsList.appendChild(flagLine);
            }
        });
    }

    submitBtn.addEventListener('click', function () {
        var val = commentInput.value.trim();
        if (!val) return;

        comments.push({ author: 'You', text: val });
        renderComments();
        commentInput.value = '';

        if (looksLikePayload(val) && !storedPayloadSubmitted) {
            storedPayloadSubmitted = true;
            var simBtn = document.createElement('button');
            simBtn.className = 'btn secondary';
            simBtn.id = 'simulateVisitorBtn';
            simBtn.textContent = 'Simulate: New Visitor Loads This Page';
            visitorButtonContainer.innerHTML = '';
            visitorButtonContainer.appendChild(simBtn);

            simBtn.addEventListener('click', function () {
                if (!state.round2) {
                    state.round2 = true;
                    round2El.classList.add('complete');
                    round2Status.textContent = 'Complete';
                    statusChip2.textContent = 'Round 2: Stored XSS complete';
                    statusChip2.classList.add('done');

                    var note = document.createElement('div');
                    note.className = 'visitor-note';
                    note.textContent = 'A new visitor just loaded this page and your saved payload executed automatically, with no link required.';
                    visitorNoteContainer.innerHTML = '';
                    visitorNoteContainer.appendChild(note);

                    renderComments();
                    checkAllComplete();
                }
            });
        }
    });

    // ---------------------------------------------------------
    // Round 3: DOM-based XSS and cookie theft
    // ---------------------------------------------------------
    var domPayloadInput = document.getElementById('domPayloadInput');
    var attackerLogPanel = document.getElementById('attackerLogPanel');
    var cookieValueText = 'session_id=7f3ac9e2';

    domPayloadInput.addEventListener('input', function () {
        var val = domPayloadInput.value.toLowerCase();
        if (val.indexOf('document.cookie') !== -1 && !state.round3) {
            state.round3 = true;
            round3El.classList.add('complete');
            round3Status.textContent = 'Complete';
            statusChip3.textContent = 'Round 3: DOM-based XSS complete';
            statusChip3.classList.add('done');

            attackerLogPanel.innerHTML = '';
            var lines = [
                'Incoming request from victim browser...',
                'GET /collect?c=' + encodeURIComponent(cookieValueText),
                'Cookie captured: ' + cookieValueText,
                'Session hijack ready, no password required.'
            ];
            lines.forEach(function (line, i) {
                var lineEl = document.createElement('div');
                lineEl.className = 'log-line' + (i >= 1 ? ' hit' : '');
                lineEl.textContent = line;
                attackerLogPanel.appendChild(lineEl);
            });

            checkAllComplete();
        }
    });

    // ---------------------------------------------------------
    // Spotlight tutorial system
    // ---------------------------------------------------------
    var tutorialSteps = [
        { id: 'reflectSearchBox', text: 'This search box reflects whatever you type straight back onto the page, just like a vulnerable search feature would. Try typing something unexpected.' },
        { id: 'reflectOutput', text: 'This is where your reflected input gets rendered. Watch what happens when your input looks like code instead of plain text.' },
        { id: 'commentInput', text: 'This is a real comment field. Whatever you submit here gets saved, just like a comment on a real blog.' },
        { id: 'commentsList', text: 'Submitted comments appear here for anyone who visits the page later, not just for you.' },
        { id: 'round2', text: 'After submitting a payload, look here for a button to simulate a brand new visitor loading the page and seeing the comments you saved.' },
        { id: 'cookieBadge', text: 'This represents your session cookie, the small piece of data a website uses to know you are logged in.' },
        { id: 'domPayloadInput', text: 'This field represents a script running entirely in your browser. See what happens when it processes untrusted input.' },
        { id: 'attackerLogPanel', text: 'This simulates an attacker\'s server. Watch what shows up here once your payload runs.' },
        { id: 'flagArea', text: 'Once all three rounds are complete, your flag will unlock here.' }
    ];

    var currentStep = 0;
    var spotlightBox = null;
    var tooltipBox = null;

    function removeTutorialElements() {
        if (spotlightBox && spotlightBox.parentNode) spotlightBox.parentNode.removeChild(spotlightBox);
        if (tooltipBox && tooltipBox.parentNode) tooltipBox.parentNode.removeChild(tooltipBox);
        spotlightBox = null;
        tooltipBox = null;
    }

    function positionTutorial() {
        if (currentStep >= tutorialSteps.length) return;
        var target = document.getElementById(tutorialSteps[currentStep].id);
        if (!target) { nextStep(); return; }

        var rect = target.getBoundingClientRect();
        var padding = 8;

        if (!spotlightBox) {
            spotlightBox = document.createElement('div');
            spotlightBox.className = 'spotlight-box';
            document.body.appendChild(spotlightBox);
        }
        spotlightBox.style.top = (rect.top - padding) + 'px';
        spotlightBox.style.left = (rect.left - padding) + 'px';
        spotlightBox.style.width = (rect.width + padding * 2) + 'px';
        spotlightBox.style.height = (rect.height + padding * 2) + 'px';

        if (!tooltipBox) {
            tooltipBox = document.createElement('div');
            tooltipBox.className = 'tutorial-tooltip';
            document.body.appendChild(tooltipBox);
        }

        tooltipBox.innerHTML = '';
        var stepCount = document.createElement('div');
        stepCount.className = 'tt-step-count';
        stepCount.textContent = 'Step ' + (currentStep + 1) + ' of ' + tutorialSteps.length;
        tooltipBox.appendChild(stepCount);

        var text = document.createElement('p');
        text.textContent = tutorialSteps[currentStep].text;
        tooltipBox.appendChild(text);

        var actions = document.createElement('div');
        actions.className = 'tt-actions';

        var skipBtn = document.createElement('button');
        skipBtn.className = 'tt-skip';
        skipBtn.textContent = 'Skip Tutorial';
        skipBtn.addEventListener('click', endTutorial);

        var nextBtn = document.createElement('button');
        nextBtn.className = 'tt-next';
        nextBtn.textContent = (currentStep === tutorialSteps.length - 1) ? 'Finish' : 'Next';
        nextBtn.addEventListener('click', nextStep);

        actions.appendChild(skipBtn);
        actions.appendChild(nextBtn);
        tooltipBox.appendChild(actions);

        // Position tooltip, preferring bottom placement, falling back to top.
        var tooltipRect = tooltipBox.getBoundingClientRect();
        var top = rect.bottom + 16;
        var left = rect.left;

        if (top + tooltipRect.height > window.innerHeight) {
            top = rect.top - tooltipRect.height - 16;
        }
        if (left + tooltipRect.width > window.innerWidth) {
            left = window.innerWidth - tooltipRect.width - 16;
        }
        if (left < 16) left = 16;
        if (top < 16) top = 16;

        tooltipBox.style.top = top + 'px';
        tooltipBox.style.left = left + 'px';
    }

    function showStep() {
        var target = document.getElementById(tutorialSteps[currentStep].id);
        if (!target) { nextStep(); return; }

        var rect = target.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        if (!inView) {
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(positionTutorial, 300);
        } else {
            positionTutorial();
        }
    }

    function nextStep() {
        currentStep++;
        if (currentStep >= tutorialSteps.length) {
            endTutorial(true);
        } else {
            showStep();
        }
    }

    function startTutorial() {
        currentStep = 0;
        showStep();
        window.addEventListener('resize', positionTutorial);
    }

    function endTutorial(completed) {
        removeTutorialElements();
        window.removeEventListener('resize', positionTutorial);
        if (completed) {
            showCompletionModal();
        }
    }

    function showCompletionModal() {
        var overlay = document.createElement('div');
        overlay.className = 'modal-overlay';

        var box = document.createElement('div');
        box.className = 'modal-box';

        var heading = document.createElement('h3');
        heading.textContent = 'Tutorial Complete';

        var text = document.createElement('p');
        text.textContent = "You're ready to start the challenge.";

        var startBtn = document.createElement('button');
        startBtn.className = 'btn';
        startBtn.textContent = 'Start Challenge';
        startBtn.addEventListener('click', function () {
            document.body.removeChild(overlay);
        });

        box.appendChild(heading);
        box.appendChild(text);
        box.appendChild(startBtn);
        overlay.appendChild(box);
        document.body.appendChild(overlay);
    }

    document.getElementById('viewTutorialBtn').addEventListener('click', function () {
        endTutorial(false);
        startTutorial();
    });

    // Auto-start tutorial on first load
    window.addEventListener('load', function () {
        setTimeout(startTutorial, 400);
    });

})();
</script>
</body>
</html>
