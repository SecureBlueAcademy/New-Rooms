<?php
// risk-driven-security-engineering-practical.php
// Standalone static practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Risk Register Console</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
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
        max-width: 980px;
        margin: 0 auto;
        padding: 30px 20px 80px 20px;
        position: relative;
    }

    /* ===== HEADER ===== */
    header.top-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }
    header.top-header h1 {
        font-size: 1.8rem;
        margin: 0 0 6px 0;
        color: var(--text-primary);
    }
    header.top-header .subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        max-width: 620px;
    }
    #tutorial-restart-btn {
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
    }
    #tutorial-restart-btn:hover { box-shadow: var(--glow-accent); }

    /* ===== DESCRIPTION ===== */
    .briefing-box {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px 20px;
        margin-bottom: 28px;
    }
    .briefing-box h2 {
        margin: 0 0 8px 0;
        font-size: 1.05rem;
        color: var(--accent-primary);
    }
    .briefing-box p {
        margin: 0 0 8px 0;
        color: var(--text-secondary);
        font-size: 0.92rem;
    }
    .briefing-box p:last-child { margin-bottom: 0; }

    /* ===== MAIN ENVIRONMENT ===== */
    .console-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }
    @media (min-width: 860px) {
        .console-layout {
            grid-template-columns: 1.5fr 1fr;
        }
    }

    .findings-column {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .finding-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px;
        transition: border-color 0.2s ease;
    }
    .finding-card.correct {
        border-color: var(--success);
        box-shadow: 0 0 0 1px rgba(61,255,154,0.15);
    }
    .finding-card.incorrect {
        border-color: var(--error);
    }
    .finding-card h3 {
        margin: 0 0 8px 0;
        font-size: 0.95rem;
        color: var(--text-primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }
    .finding-card .check-icon {
        color: var(--success);
        font-size: 1.1rem;
        display: none;
    }
    .finding-card.correct .check-icon { display: inline; }

    .finding-card p.desc {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin: 0 0 14px 0;
    }

    .slider-group {
        margin-bottom: 14px;
    }
    .slider-group label {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .slider-group .value-label {
        color: var(--accent-primary);
        font-family: "JetBrains Mono", monospace;
    }
    input[type="range"] {
        width: 100%;
        accent-color: var(--accent-primary);
        cursor: pointer;
    }

    .score-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        font-size: 0.85rem;
    }
    .score-badge {
        font-family: "JetBrains Mono", monospace;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
    }
    .zone-low { background: rgba(61,255,154,0.15); color: var(--success); }
    .zone-medium { background: rgba(255,211,106,0.15); color: var(--warning); }
    .zone-high { background: rgba(255,140,60,0.18); color: #ff9a4d; }
    .zone-critical { background: rgba(255,92,92,0.18); color: var(--error); }

    /* ===== HEATMAP COLUMN ===== */
    .heatmap-panel {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px;
        align-self: start;
        position: sticky;
        top: 20px;
    }
    .heatmap-panel h3 {
        margin: 0 0 14px 0;
        font-size: 0.95rem;
    }
    #risk-matrix-heatmap {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(5, 1fr);
        gap: 3px;
        aspect-ratio: 1 / 1;
        margin-bottom: 10px;
        position: relative;
    }
    .heat-cell {
        border-radius: 4px;
        position: relative;
    }
    .heat-cell .dot {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--text-primary);
        border: 2px solid var(--bg-primary);
        display: none;
    }
    .axis-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .submit-btn {
        width: 100%;
        margin-top: 18px;
        padding: 14px;
        background: linear-gradient(135deg, #1a3a4a, #12182b);
        border: 1px solid var(--accent-primary);
        color: var(--accent-primary);
        font-family: inherit;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        cursor: pointer;
        transition: box-shadow 0.2s ease;
    }
    .submit-btn:hover { box-shadow: var(--glow-accent); }
    .submit-btn:disabled {
        opacity: 0.5;
        cursor: default;
        box-shadow: none;
    }

    /* ===== FEEDBACK AREA ===== */
    #status-area {
        margin-top: 20px;
        padding: 14px 16px;
        border-radius: 8px;
        font-size: 0.88rem;
        display: none;
    }
    #status-area.show { display: block; }
    #status-area.status-error {
        background: rgba(255,92,92,0.1);
        border: 1px solid var(--error);
        color: var(--error);
    }
    #status-area.status-success {
        background: rgba(61,255,154,0.1);
        border: 1px solid var(--success);
        color: var(--success);
    }

    /* ===== FLAG REVEAL ===== */
    #flag-reveal {
        display: none;
        margin-top: 26px;
        background: var(--bg-secondary);
        border: 1px solid var(--success);
        border-radius: 10px;
        padding: 22px;
        text-align: center;
    }
    #flag-reveal.show { display: block; }
    #flag-reveal h3 {
        margin: 0 0 10px 0;
        color: var(--success);
        font-size: 1.1rem;
    }
    #flag-reveal .flag-value {
        font-family: "JetBrains Mono", monospace;
        font-size: 1.15rem;
        background: var(--bg-primary);
        border: 1px solid var(--border-default);
        border-radius: 6px;
        padding: 12px 18px;
        display: inline-block;
        color: var(--accent-primary);
        letter-spacing: 0.02em;
    }

    /* ===== TUTORIAL SPOTLIGHT ===== */
    #spotlight-overlay {
        position: fixed;
        border-radius: 8px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        transition: all 0.25s ease;
        z-index: 9998;
        pointer-events: none;
        display: none;
    }
    #tutorial-tooltip {
        position: fixed;
        max-width: 300px;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px;
        z-index: 9999;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        display: none;
    }
    #tutorial-tooltip p {
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
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        border: none;
    }
    #tutorial-next-btn {
        background: var(--accent-primary);
        color: #0b0f1a;
    }
    #tutorial-skip-btn {
        background: transparent;
        color: var(--text-muted);
    }

    #tutorial-complete-modal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.75);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
    #tutorial-complete-modal.show { display: flex; }
    .modal-card {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 12px;
        padding: 30px;
        max-width: 360px;
        text-align: center;
    }
    .modal-card h3 {
        margin: 0 0 10px 0;
        color: var(--accent-primary);
    }
    .modal-card p {
        color: var(--text-secondary);
        font-size: 0.88rem;
        margin: 0 0 18px 0;
    }
    .modal-card button {
        background: var(--accent-primary);
        color: #0b0f1a;
        border: none;
        font-family: inherit;
        font-weight: 700;
        padding: 12px 22px;
        border-radius: 8px;
        cursor: pointer;
    }
</style>
</head>
<body>
<div class="page-wrap">

    <!-- 1. TOP HEADER -->
    <header class="top-header">
        <div>
            <h1>Risk Register Console</h1>
            <p class="subtitle">You are the risk analyst reviewing this quarter's security findings before they reach the leadership team.</p>
        </div>
        <button id="tutorial-restart-btn">View Tutorial</button>
    </header>

    <!-- 2. DESCRIPTION -->
    <div class="briefing-box">
        <h2>Mission Briefing</h2>
        <p>Five findings from a recent security review are listed below. Each one describes an exposure in plain terms. Your job is to read each description carefully and set the Likelihood and Impact sliders to the values that match what is described.</p>
        <p>As you adjust the sliders, the risk matrix on the right updates live to show where each finding lands. Once all five findings are classified correctly, submit the register for review.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="console-layout">
        <div class="findings-column" id="findings-column">
            <!-- Finding cards injected by JS -->
        </div>

        <div class="heatmap-panel">
            <h3>Risk Matrix</h3>
            <div id="risk-matrix-heatmap"></div>
            <div class="axis-labels">
                <span>Low Impact</span>
                <span>High Impact</span>
            </div>
            <button class="submit-btn" id="submit-register-btn">Submit Risk Register</button>
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div id="status-area"></div>

    <!-- 5. FLAG REVEAL AREA -->
    <div id="flag-reveal">
        <h3>Risk Register Approved</h3>
        <p>All five findings have been correctly classified. Your flag:</p>
        <div class="flag-value">CBX{risk_register_approved}</div>
    </div>

</div>

<!-- TUTORIAL ELEMENTS -->
<div id="spotlight-overlay"></div>
<div id="tutorial-tooltip">
    <p id="tutorial-tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tutorial-skip-btn">Skip Tutorial</button>
        <button id="tutorial-next-btn">Next</button>
    </div>
</div>
<div id="tutorial-complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    "use strict";

    // ===== DATA =====
    const likelihoodLabels = ["Rare", "Unlikely", "Possible", "Likely", "Almost Certain"];
    const impactLabels = ["Negligible", "Minor", "Moderate", "Major", "Severe"];

    const findings = [
        {
            id: 1,
            title: "Finding 1: Exposed Admin Panel",
            desc: "An admin panel is exposed directly to the public internet, still using default credentials, and controls the customer database.",
            correctLikelihood: 5,
            correctImpact: 5
        },
        {
            id: 2,
            title: "Finding 2: Legacy File Share",
            desc: "A legacy file share with no multi factor authentication is accessible to all employees over VPN and contains some HR records.",
            correctLikelihood: 4,
            correctImpact: 3
        },
        {
            id: 3,
            title: "Finding 3: Outdated VPN Client",
            desc: "An outdated VPN client has a known vulnerability, but exploiting it requires an attacker who is already authenticated on the internal network.",
            correctLikelihood: 2,
            correctImpact: 4
        },
        {
            id: 4,
            title: "Finding 4: Expired Scheduling Tool Certificate",
            desc: "A third party scheduling tool has an expired SSL certificate causing browser warnings, but it only handles internal meeting times, never sensitive data.",
            correctLikelihood: 3,
            correctImpact: 2
        },
        {
            id: 5,
            title: "Finding 5: Unencrypted Backup Server",
            desc: "An unencrypted backup server holds only public marketing files and sits in a locked server room with restricted badge access.",
            correctLikelihood: 1,
            correctImpact: 1
        }
    ];

    const state = {};
    findings.forEach(f => { state[f.id] = { likelihood: 3, impact: 3, locked: false }; });

    function zoneFor(score) {
        if (score <= 4) return { name: "Low", cls: "zone-low" };
        if (score <= 9) return { name: "Medium", cls: "zone-medium" };
        if (score <= 15) return { name: "High", cls: "zone-high" };
        return { name: "Critical", cls: "zone-critical" };
    }

    // ===== BUILD FINDING CARDS =====
    const findingsColumn = document.getElementById("findings-column");

    findings.forEach((f, idx) => {
        const card = document.createElement("div");
        card.className = "finding-card";
        card.id = "finding-card-" + f.id;

        card.innerHTML = `
            <h3><span>${f.title}</span><span class="check-icon">&#10003;</span></h3>
            <p class="desc">${f.desc}</p>
            <div class="slider-group">
                <label>Likelihood <span class="value-label" id="likelihood-label-${f.id}">Possible</span></label>
                <input type="range" min="1" max="5" value="3" id="likelihood-slider-${f.id}">
            </div>
            <div class="slider-group">
                <label>Impact <span class="value-label" id="impact-label-${f.id}">Moderate</span></label>
                <input type="range" min="1" max="5" value="3" id="impact-slider-${f.id}">
            </div>
            <div class="score-row">
                <span>Risk Score</span>
                <span class="score-badge zone-medium" id="risk-score-display-${f.id}">9 &middot; Medium</span>
            </div>
        `;
        findingsColumn.appendChild(card);
    });

    // Give the first card's score badge the generic id the tutorial refers to
    document.getElementById("risk-score-display-1").id = "risk-score-display";

    // ===== BUILD HEATMAP GRID =====
    const heatmap = document.getElementById("risk-matrix-heatmap");
    const zoneColors = {
        low: "rgba(61,255,154,0.25)",
        medium: "rgba(255,211,106,0.25)",
        high: "rgba(255,140,60,0.28)",
        critical: "rgba(255,92,92,0.3)"
    };
    // Build 5x5 grid, row = likelihood (5 top to 1 bottom), col = impact (1 to 5)
    for (let row = 5; row >= 1; row--) {
        for (let col = 1; col <= 5; col++) {
            const score = row * col;
            const zone = zoneFor(score);
            const cell = document.createElement("div");
            cell.className = "heat-cell";
            cell.style.background = zoneColors[zone.name.toLowerCase()];
            cell.dataset.likelihood = row;
            cell.dataset.impact = col;
            const dot = document.createElement("div");
            dot.className = "dot";
            dot.id = "heat-dot-" + row + "-" + col;
            cell.appendChild(dot);
            heatmap.appendChild(cell);
        }
    }

    function updateHeatmapDots() {
        document.querySelectorAll(".dot").forEach(d => d.style.display = "none");
        const seen = {};
        findings.forEach(f => {
            const s = state[f.id];
            const key = s.likelihood + "-" + s.impact;
            const dot = document.getElementById("heat-dot-" + key);
            if (dot) {
                dot.style.display = "block";
                if (seen[key]) {
                    dot.style.width = "16px";
                    dot.style.height = "16px";
                    dot.style.background = "var(--accent-primary)";
                }
                seen[key] = true;
            }
        });
    }

    // ===== SLIDER WIRING =====
    findings.forEach(f => {
        const likSlider = document.getElementById("likelihood-slider-" + f.id);
        const impSlider = document.getElementById("impact-slider-" + f.id);
        const likLabel = document.getElementById("likelihood-label-" + f.id);
        const impLabel = document.getElementById("impact-label-" + f.id);
        const scoreDisplay = document.getElementById(f.id === 1 ? "risk-score-display" : "risk-score-display-" + f.id);
        const card = document.getElementById("finding-card-" + f.id);

        function refresh() {
            const lik = parseInt(likSlider.value, 10);
            const imp = parseInt(impSlider.value, 10);
            state[f.id].likelihood = lik;
            state[f.id].impact = imp;
            likLabel.textContent = likelihoodLabels[lik - 1];
            impLabel.textContent = impactLabels[imp - 1];
            const score = lik * imp;
            const zone = zoneFor(score);
            scoreDisplay.textContent = score + " \u00b7 " + zone.name;
            scoreDisplay.className = "score-badge " + zone.cls;
            card.classList.remove("correct", "incorrect");
            updateHeatmapDots();
        }

        likSlider.addEventListener("input", refresh);
        impSlider.addEventListener("input", refresh);
        refresh();
    });

    // ===== SUBMIT LOGIC =====
    const statusArea = document.getElementById("status-area");
    const flagReveal = document.getElementById("flag-reveal");
    const submitBtn = document.getElementById("submit-register-btn");

    submitBtn.addEventListener("click", function () {
        let allCorrect = true;

        findings.forEach(f => {
            const s = state[f.id];
            const card = document.getElementById("finding-card-" + f.id);
            const correct = s.likelihood === f.correctLikelihood && s.impact === f.correctImpact;
            card.classList.remove("correct", "incorrect");
            card.classList.add(correct ? "correct" : "incorrect");
            if (!correct) allCorrect = false;
        });

        statusArea.classList.add("show");

        if (allCorrect) {
            statusArea.className = "show status-success";
            statusArea.textContent = "All five findings classified correctly. Register approved.";
            findings.forEach(f => {
                document.getElementById("likelihood-slider-" + f.id).disabled = true;
                document.getElementById("impact-slider-" + f.id).disabled = true;
            });
            submitBtn.disabled = true;
            flagReveal.classList.add("show");
        } else {
            statusArea.className = "show status-error";
            statusArea.textContent = "One or more findings are misclassified. Review the descriptions marked in red and adjust the sliders.";
        }
    });

    // ===== TUTORIAL SPOTLIGHT SYSTEM =====
    const tutorialSteps = [
        { targetId: "likelihood-slider-1", text: "This slider sets how likely this event is to occur. In FAIR terms, this reflects Threat Event Frequency and Vulnerability combined." },
        { targetId: "impact-slider-1", text: "This slider sets how severe the consequences would be if the event occurred. This reflects Loss Magnitude." },
        { targetId: "risk-matrix-heatmap", text: "As you adjust the sliders, this matrix highlights where the risk lands. The color and zone update live, just like a real risk register." },
        { targetId: "risk-score-display", text: "This is the calculated Risk Score, Likelihood multiplied by Impact, and the zone it falls into." },
        { targetId: "submit-register-btn", text: "Once all five findings are classified, submit the register for review to complete the exercise." }
    ];

    let currentStep = 0;
    const overlay = document.getElementById("spotlight-overlay");
    const tooltip = document.getElementById("tutorial-tooltip");
    const tooltipText = document.getElementById("tutorial-tooltip-text");
    const nextBtn = document.getElementById("tutorial-next-btn");
    const skipBtn = document.getElementById("tutorial-skip-btn");
    const completeModal = document.getElementById("tutorial-complete-modal");
    const restartBtn = document.getElementById("tutorial-restart-btn");
    const startChallengeBtn = document.getElementById("start-challenge-btn");

    function positionSpotlight(el) {
        const rect = el.getBoundingClientRect();
        const pad = 8;
        overlay.style.top = (rect.top - pad) + "px";
        overlay.style.left = (rect.left - pad) + "px";
        overlay.style.width = (rect.width + pad * 2) + "px";
        overlay.style.height = (rect.height + pad * 2) + "px";
        overlay.style.display = "block";

        let top = rect.bottom + 14;
        let left = rect.left;
        const tooltipWidth = 300;

        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 150 > window.innerHeight) {
            top = rect.top - 160;
        }
        if (top < 10) top = 10;
        if (left < 10) left = 10;

        tooltip.style.top = top + "px";
        tooltip.style.left = left + "px";
        tooltip.style.display = "block";
    }

    function showStep(index) {
        if (index >= tutorialSteps.length) {
            endTutorial(true);
            return;
        }
        const step = tutorialSteps[index];
        const el = document.getElementById(step.targetId);
        if (!el) { showStep(index + 1); return; }

        const rect = el.getBoundingClientRect();
        const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        if (!inView) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
            setTimeout(() => positionSpotlight(el), 300);
        } else {
            positionSpotlight(el);
        }

        tooltipText.textContent = step.text;
        nextBtn.textContent = (index === tutorialSteps.length - 1) ? "Finish" : "Next";
    }

    function startTutorial() {
        currentStep = 0;
        overlay.style.display = "block";
        tooltip.style.display = "block";
        showStep(currentStep);
    }

    function endTutorial(completed) {
        overlay.style.display = "none";
        tooltip.style.display = "none";
        if (completed) {
            completeModal.classList.add("show");
        }
    }

    nextBtn.addEventListener("click", function () {
        currentStep++;
        showStep(currentStep);
    });

    skipBtn.addEventListener("click", function () {
        endTutorial(false);
    });

    startChallengeBtn.addEventListener("click", function () {
        completeModal.classList.remove("show");
    });

    restartBtn.addEventListener("click", startTutorial);

    window.addEventListener("resize", function () {
        if (overlay.style.display === "block" && currentStep < tutorialSteps.length) {
            const step = tutorialSteps[currentStep];
            const el = document.getElementById(step.targetId);
            if (el) positionSpotlight(el);
        }
    });

    // Auto start on first load
    window.addEventListener("load", function () {
        setTimeout(startTutorial, 400);
    });

})();
</script>
</body>
</html>
