<?php
// ============================================================
// security-controls-mapping-practical.php
// Audit Readiness Console — standalone static practical
// No backend logic, no database, no sessions, no external APIs.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Audit Readiness Console</title>
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
        min-height: 100vh;
    }

    .page-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 24px 20px 60px 20px;
    }

    /* ===== 1. Header ===== */
    header.top-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }
    header.top-header h1 {
        font-size: 1.6rem;
        margin: 0 0 6px 0;
        color: var(--text-primary);
    }
    header.top-header p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.95rem;
        max-width: 640px;
    }
    #tutorial-btn {
        flex-shrink: 0;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        color: var(--accent-primary);
        padding: 10px 18px;
        border-radius: 8px;
        font-family: inherit;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: box-shadow 0.2s ease;
    }
    #tutorial-btn:hover { box-shadow: var(--glow-accent); }

    /* ===== 2. Description ===== */
    .briefing {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 26px;
    }
    .briefing h2 {
        margin: 0 0 10px 0;
        font-size: 1.05rem;
        color: var(--accent-primary);
    }
    .briefing p {
        margin: 0 0 8px 0;
        color: var(--text-secondary);
        font-size: 0.92rem;
        line-height: 1.5;
    }
    .briefing p:last-child { margin-bottom: 0; }

    /* Audit status bar */
    #audit-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 22px;
        font-family: "JetBrains Mono", monospace;
        font-size: 0.9rem;
    }
    #audit-status.passed {
        border-color: var(--success);
        box-shadow: 0 0 14px rgba(61,255,154,0.15);
    }
    #audit-status .status-label { color: var(--text-secondary); }
    #audit-status .status-value { color: var(--warning); font-weight: 600; }
    #audit-status.passed .status-value { color: var(--success); }

    /* ===== 3. Main interactive environment ===== */
    .matrix-builder {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 26px;
    }
    @media (max-width: 720px) {
        .matrix-builder { grid-template-columns: 1fr; }
    }
    .panel {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 18px;
    }
    .panel h3 {
        margin: 0 0 14px 0;
        font-size: 0.95rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 10px;
        font-size: 0.87rem;
        color: var(--text-secondary);
        cursor: pointer;
        transition: border-color 0.15s ease, transform 0.15s ease, background 0.15s ease;
    }
    .card:hover:not(.matched):not(.disabled) {
        border-color: var(--accent-primary);
        transform: translateY(-1px);
    }
    .card.selected {
        border-color: var(--accent-secondary);
        box-shadow: 0 0 0 1px var(--accent-secondary);
        color: var(--text-primary);
    }
    .card.matched {
        border-color: var(--success);
        color: var(--text-muted);
        cursor: default;
        opacity: 0.55;
    }
    .card.wrong {
        animation: shake 0.35s ease;
        border-color: var(--error);
        color: var(--error);
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .control-card .fw-ref {
        display: block;
        margin-top: 4px;
        font-family: "JetBrains Mono", monospace;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Instruction strip */
    #match-instruction {
        text-align: center;
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin: -6px 0 20px 0;
    }

    /* ===== 4. Feedback / status area ===== */
    #feedback-area {
        min-height: 24px;
        text-align: center;
        font-size: 0.88rem;
        margin-bottom: 18px;
        color: var(--text-secondary);
    }
    #feedback-area.correct { color: var(--success); }
    #feedback-area.incorrect { color: var(--error); }

    .completed-matrix {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 26px;
    }
    .completed-matrix h3 {
        margin: 0 0 14px 0;
        font-size: 0.95rem;
    }
    table.matrix-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
    }
    table.matrix-table th, table.matrix-table td {
        text-align: left;
        padding: 10px 12px;
        border-bottom: 1px solid var(--border-default);
        color: var(--text-secondary);
    }
    table.matrix-table th {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    table.matrix-table td.req-col { color: var(--text-primary); }
    table.matrix-table tr.row-in { animation: rowIn 0.3s ease; }
    @keyframes rowIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== 5. Flag reveal area ===== */
    #flag-reveal-area {
        display: none;
        background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
        border: 1px solid var(--success);
        border-radius: 12px;
        padding: 26px;
        text-align: center;
        box-shadow: 0 0 24px rgba(61,255,154,0.15);
    }
    #flag-reveal-area.show { display: block; }
    #flag-reveal-area h3 {
        margin: 0 0 10px 0;
        color: var(--success);
        font-size: 1.1rem;
    }
    #flag-reveal-area p {
        margin: 0 0 14px 0;
        color: var(--text-secondary);
        font-size: 0.88rem;
    }
    .flag-value {
        display: inline-block;
        font-family: "JetBrains Mono", monospace;
        font-size: 1.05rem;
        background: var(--bg-primary);
        border: 1px solid var(--success);
        color: var(--success);
        padding: 12px 22px;
        border-radius: 8px;
        letter-spacing: 0.02em;
        user-select: all;
    }

    /* ===== Tutorial spotlight system ===== */
    #spotlight {
        position: fixed;
        pointer-events: none;
        border-radius: 10px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        transition: top 0.25s ease, left 0.25s ease, width 0.25s ease, height 0.25s ease;
        z-index: 9998;
        display: none;
    }
    #tutorial-tooltip {
        position: fixed;
        max-width: 300px;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px 18px;
        font-size: 0.85rem;
        color: var(--text-secondary);
        z-index: 9999;
        display: none;
        box-shadow: var(--glow-accent);
    }
    #tutorial-tooltip .tt-title {
        color: var(--accent-primary);
        font-weight: 600;
        margin: 0 0 8px 0;
        font-size: 0.85rem;
    }
    #tutorial-tooltip .tt-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
    }
    #tutorial-tooltip button {
        font-family: inherit;
        font-size: 0.8rem;
        border-radius: 6px;
        padding: 7px 14px;
        cursor: pointer;
        border: 1px solid var(--border-default);
        background: transparent;
        color: var(--text-secondary);
    }
    #tutorial-tooltip button.primary {
        background: var(--accent-primary);
        border-color: var(--accent-primary);
        color: #0b0f1a;
        font-weight: 600;
    }

    /* Completion modal */
    #tutorial-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
    #tutorial-modal-backdrop.show { display: flex; }
    #tutorial-modal {
        background: var(--bg-secondary);
        border: 1px solid var(--accent-primary);
        border-radius: 14px;
        padding: 30px;
        max-width: 380px;
        text-align: center;
    }
    #tutorial-modal h3 { margin: 0 0 10px 0; color: var(--accent-primary); }
    #tutorial-modal p { color: var(--text-secondary); font-size: 0.88rem; margin: 0 0 18px 0; }
    #tutorial-modal button {
        font-family: inherit;
        background: var(--accent-primary);
        border: none;
        color: #0b0f1a;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.88rem;
    }
</style>
</head>
<body>
<div class="page-wrap">

    <!-- 1. TOP HEADER -->
    <header class="top-header">
        <div>
            <h1>Audit Readiness Console</h1>
            <p>You are the control owner for a system entering its first formal audit. Build the controls matrix by matching each requirement to the control and framework reference that satisfies it.</p>
        </div>
        <button id="tutorial-btn">View Tutorial</button>
    </header>

    <!-- 2. DESCRIPTION SECTION -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This console represents the working matrix for a system with six unmapped security requirements. Nothing has been linked yet. Your goal is to map every requirement to the correct control before the audit clock runs out.</p>
        <p>Click a requirement card, then click the control card you believe satisfies it. A correct match locks both cards together and adds a row to your completed matrix below. An incorrect match resets instantly with no penalty, so investigate freely.</p>
    </div>

    <div id="audit-status">
        <span class="status-label">Audit Status:</span>
        <span class="status-value" id="status-text">In Progress (0/6 mapped)</span>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <p id="match-instruction">Select one requirement, then select the control that satisfies it.</p>

    <div class="matrix-builder">
        <div class="panel" id="requirements-panel">
            <h3><i>📋</i> Requirements</h3>
            <div id="requirements-list"></div>
        </div>
        <div class="panel" id="controls-panel">
            <h3><i>🛡️</i> Candidate Controls</h3>
            <div id="controls-list"></div>
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div id="feedback-area">Select a requirement to begin.</div>

    <div class="completed-matrix">
        <h3>Completed Matrix</h3>
        <table class="matrix-table">
            <thead>
                <tr>
                    <th>Requirement</th>
                    <th>Control</th>
                    <th>Framework Reference</th>
                </tr>
            </thead>
            <tbody id="completed-matrix-body">
                <!-- rows inserted as matches are made -->
            </tbody>
        </table>
    </div>

    <!-- 5. FLAG REVEAL AREA -->
    <div id="flag-reveal-area">
        <h3>Audit Passed</h3>
        <p>Every requirement is mapped. Your controls matrix is complete and the audit has been marked passed.</p>
        <span class="flag-value" id="flag-value">CBX{matrix_mapped}</span>
    </div>

</div>

<!-- Tutorial elements -->
<div id="spotlight"></div>
<div id="tutorial-tooltip">
    <div class="tt-title" id="tt-title"></div>
    <div id="tt-body"></div>
    <div class="tt-actions">
        <button id="tt-skip">Skip Tutorial</button>
        <button id="tt-next" class="primary">Next</button>
    </div>
</div>
<div id="tutorial-modal-backdrop">
    <div id="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Build the matrix, requirement by requirement.</p>
        <button id="tt-start">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    "use strict";

    // ---------- Data ----------
    var pairs = [
        { req: "Prevent unauthorized password guessing", control: "Account Lockout", fw: "NIST 800-53 AC-7" },
        { req: "Restrict access to only what is needed for the job", control: "Least Privilege", fw: "CIS Control 6" },
        { req: "Encrypt sensitive data at rest", control: "Data Encryption", fw: "ISO 27001 A.8.24" },
        { req: "Detect and respond to security incidents in real time", control: "Continuous Monitoring", fw: "NIST 800-53 SI-4" },
        { req: "Ensure only approved changes reach production systems", control: "Change Management", fw: "ISO 27001 A.8.32" },
        { req: "Maintain records proving who accessed what and when", control: "Audit Logging", fw: "CIS Control 8" }
    ];

    // Shuffle a copy of the controls so they don't line up visually with requirements
    function shuffle(arr) {
        var a = arr.slice();
        for (var i = a.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var tmp = a[i]; a[i] = a[j]; a[j] = tmp;
        }
        return a;
    }

    var reqOrder = pairs.map(function (p, i) { return i; });
    var ctrlOrder = shuffle(pairs.map(function (p, i) { return i; }));

    var reqListEl = document.getElementById("requirements-list");
    var ctrlListEl = document.getElementById("controls-list");
    var feedbackEl = document.getElementById("feedback-area");
    var statusTextEl = document.getElementById("status-text");
    var statusBarEl = document.getElementById("audit-status");
    var matrixBodyEl = document.getElementById("completed-matrix-body");
    var flagAreaEl = document.getElementById("flag-reveal-area");

    var matchedCount = 0;
    var selectedReqIndex = null;

    reqOrder.forEach(function (idx) {
        var div = document.createElement("div");
        div.className = "card req-card";
        div.dataset.index = idx;
        div.textContent = pairs[idx].req;
        reqListEl.appendChild(div);
    });

    ctrlOrder.forEach(function (idx) {
        var div = document.createElement("div");
        div.className = "card control-card";
        div.dataset.index = idx;
        div.innerHTML = pairs[idx].control + '<span class="fw-ref">' + pairs[idx].fw + '</span>';
        ctrlListEl.appendChild(div);
    });

    function reqCards() { return Array.prototype.slice.call(reqListEl.querySelectorAll(".card")); }
    function ctrlCards() { return Array.prototype.slice.call(ctrlListEl.querySelectorAll(".card")); }

    function setFeedback(msg, cls) {
        feedbackEl.textContent = msg;
        feedbackEl.className = cls || "";
    }

    reqListEl.addEventListener("click", function (e) {
        var card = e.target.closest(".card");
        if (!card || card.classList.contains("matched") || card.classList.contains("disabled")) return;

        reqCards().forEach(function (c) { c.classList.remove("selected"); });
        card.classList.add("selected");
        selectedReqIndex = parseInt(card.dataset.index, 10);
        setFeedback("Now select the control that satisfies this requirement.", "");
    });

    ctrlListEl.addEventListener("click", function (e) {
        var card = e.target.closest(".card");
        if (!card || card.classList.contains("matched") || card.classList.contains("disabled")) return;
        if (selectedReqIndex === null) {
            setFeedback("Select a requirement first, then choose its control.", "");
            return;
        }

        var ctrlIndex = parseInt(card.dataset.index, 10);

        if (ctrlIndex === selectedReqIndex) {
            var reqCard = reqListEl.querySelector('.card[data-index="' + selectedReqIndex + '"]');
            reqCard.classList.remove("selected");
            reqCard.classList.add("matched");
            card.classList.add("matched");

            addMatrixRow(pairs[ctrlIndex]);
            matchedCount++;
            updateStatus();
            setFeedback("Correct match. Row added to the matrix.", "correct");
            selectedReqIndex = null;

            if (matchedCount === pairs.length) {
                revealFlag();
            }
        } else {
            card.classList.add("wrong");
            var wrongReq = reqListEl.querySelector('.card[data-index="' + selectedReqIndex + '"]');
            wrongReq.classList.add("wrong");
            setFeedback("That control does not satisfy this requirement. Try again.", "incorrect");
            setTimeout(function () {
                card.classList.remove("wrong");
                wrongReq.classList.remove("wrong", "selected");
            }, 350);
            selectedReqIndex = null;
        }
    });

    function addMatrixRow(pair) {
        var tr = document.createElement("tr");
        tr.className = "row-in";
        tr.innerHTML = "<td class=\"req-col\">" + pair.req + "</td><td>" + pair.control + "</td><td>" + pair.fw + "</td>";
        matrixBodyEl.appendChild(tr);
    }

    function updateStatus() {
        statusTextEl.textContent = (matchedCount === pairs.length ? "Passed (" : "In Progress (") + matchedCount + "/6 mapped)";
        if (matchedCount === pairs.length) {
            statusBarEl.classList.add("passed");
        }
    }

    function revealFlag() {
        setFeedback("All requirements mapped. Audit passed.", "correct");
        flagAreaEl.classList.add("show");
        flagAreaEl.scrollIntoView({ behavior: "smooth", block: "center" });
    }

    // ---------- Tutorial system ----------
    var steps = [
        { targetId: "requirements-panel", title: "Requirements Panel", body: "These are real security requirements pulled from the system's requirements document. Every one of them needs a control that satisfies it." },
        { targetId: "controls-panel", title: "Candidate Controls Panel", body: "Each card here is a control already tagged with its framework reference. One of these belongs to each requirement on the left." },
        { targetId: "match-instruction", title: "How to Match", body: "Click a requirement, then click the control you believe satisfies it. Think about what mechanism would actually stop or detect the behavior described." },
        { targetId: "feedback-area", title: "Feedback", body: "A correct match locks both cards together and turns them green. An incorrect match resets instantly so you can try again with no penalty." },
        { targetId: "audit-status", title: "Audit Status", body: "This bar tracks your progress toward a passed audit, exactly like a real compliance dashboard would." },
        { targetId: "flag-reveal-area", title: "Flag Reveal", body: "Once every requirement is mapped, your completed matrix appears above and confirmation of the passed audit appears here." }
    ];

    var currentStep = 0;
    var spotlight = document.getElementById("spotlight");
    var tooltip = document.getElementById("tutorial-tooltip");
    var ttTitle = document.getElementById("tt-title");
    var ttBody = document.getElementById("tt-body");
    var modalBackdrop = document.getElementById("tutorial-modal-backdrop");

    function positionOn(el) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlight.style.top = (rect.top - pad) + "px";
        spotlight.style.left = (rect.left - pad) + "px";
        spotlight.style.width = (rect.width + pad * 2) + "px";
        spotlight.style.height = (rect.height + pad * 2) + "px";
        spotlight.style.display = "block";

        var tooltipWidth = 300;
        var top = rect.bottom + 14;
        var left = rect.left;

        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 160 > window.innerHeight) {
            top = rect.top - 170;
        }
        tooltip.style.top = Math.max(10, top) + "px";
        tooltip.style.left = Math.max(10, left) + "px";
        tooltip.style.display = "block";
    }

    function showStep(index) {
        var step = steps[index];
        var el = document.getElementById(step.targetId);
        if (!el) { nextStep(); return; }

        var rect = el.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        ttTitle.textContent = step.title;
        ttBody.textContent = step.body;

        if (!inView) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
            setTimeout(function () { positionOn(el); }, 300);
        } else {
            positionOn(el);
        }
    }

    function nextStep() {
        currentStep++;
        if (currentStep >= steps.length) {
            endTutorial();
            return;
        }
        showStep(currentStep);
    }

    function startTutorial() {
        currentStep = 0;
        showStep(currentStep);
    }

    function endTutorial() {
        spotlight.style.display = "none";
        tooltip.style.display = "none";
        modalBackdrop.classList.add("show");
    }

    document.getElementById("tt-next").addEventListener("click", nextStep);
    document.getElementById("tt-skip").addEventListener("click", function () {
        spotlight.style.display = "none";
        tooltip.style.display = "none";
    });
    document.getElementById("tt-start").addEventListener("click", function () {
        modalBackdrop.classList.remove("show");
    });
    document.getElementById("tutorial-btn").addEventListener("click", startTutorial);

    window.addEventListener("resize", function () {
        if (tooltip.style.display === "block") {
            var step = steps[currentStep];
            var el = document.getElementById(step.targetId);
            if (el) positionOn(el);
        }
    });

    // Auto-start tutorial on first load
    window.addEventListener("load", function () {
        setTimeout(startTutorial, 400);
    });
})();
</script>
</body>
</html>
