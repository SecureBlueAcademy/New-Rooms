<?php
// ============================================================
// security-metrics-reporting-practical.php — PRACTICAL FILE
// Standalone static HTML/CSS/JS application. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MTTD/MTTR Detective</title>
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

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    min-height: 100vh;
    padding: 24px;
}

.wrapper { max-width: 980px; margin: 0 auto; position: relative; }

header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

header h1 {
    font-size: 1.7rem;
    font-weight: 700;
    color: var(--accent-primary);
}

header p {
    color: var(--text-secondary);
    margin-top: 6px;
    max-width: 560px;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

.brief-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
}
.brief-box h2 {
    font-size: 1.05rem;
    color: var(--accent-secondary);
    margin-bottom: 10px;
}
.brief-box p { color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 8px; }
.brief-box p:last-child { margin-bottom: 0; }

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
}
.panel h2 {
    font-size: 1.1rem;
    color: var(--text-primary);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
th, td {
    text-align: left;
    padding: 9px 10px;
    border-bottom: 1px solid var(--border-default);
    white-space: nowrap;
}
th { color: var(--accent-primary); font-weight: 600; font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em; }
td { color: var(--text-secondary); font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; }

.calc-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
    margin-top: 16px;
}
.calc-row {
    display: grid;
    grid-template-columns: 90px 1fr 110px 110px;
    gap: 10px;
    align-items: center;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
}
.calc-row label {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: 'JetBrains Mono', monospace;
}
.calc-row input {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    padding: 8px 10px;
    font-size: 0.85rem;
    width: 100%;
}
.calc-row input:focus { outline: none; border-color: var(--accent-primary); }
.calc-row .inc-id { color: var(--accent-secondary); font-weight: 600; font-size: 0.85rem; font-family: 'JetBrains Mono', monospace; }

.aggregate-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}
.agg-field label {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 6px;
    font-family: 'JetBrains Mono', monospace;
}
.agg-field input {
    width: 100%;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    padding: 12px;
    font-size: 0.95rem;
}
.agg-field input:focus { outline: none; border-color: var(--accent-primary); }

.sla-targets {
    display: flex;
    gap: 20px;
    margin-top: 16px;
    flex-wrap: wrap;
}
.sla-chip {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 16px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.sla-chip strong { color: var(--warning); }

.check-btn {
    margin-top: 18px;
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #05121a;
    border: none;
    border-radius: 8px;
    padding: 12px 26px;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.check-btn:hover { box-shadow: var(--glow-accent); }

.status-area {
    margin-top: 16px;
    padding: 14px 16px;
    border-radius: 8px;
    font-size: 0.9rem;
    display: none;
}
.status-area.show { display: block; }
.status-area.error { background: rgba(255,92,92,0.1); border: 1px solid var(--error); color: var(--error); }
.status-area.success { background: rgba(61,255,154,0.1); border: 1px solid var(--success); color: var(--success); }

.flag-area {
    background: var(--bg-secondary);
    border: 1px dashed var(--border-default);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
}
.flag-area.unlocked { border-color: var(--success); }
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.2rem;
    color: var(--success);
    margin-top: 10px;
    letter-spacing: 0.02em;
}
.flag-locked-text { color: var(--text-muted); font-size: 0.9rem; }

.finding-note {
    margin-top: 10px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* Spotlight tutorial */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
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
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tooltip-card .tt-actions {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-card button {
    background: var(--accent-primary);
    color: #05121a;
    border: none;
    border-radius: 6px;
    padding: 7px 14px;
    font-weight: 600;
    font-size: 0.82rem;
    cursor: pointer;
}
.tooltip-card .skip-btn {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default);
}

.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 32px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { color: var(--accent-primary); margin-bottom: 10px; }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 18px; }
.modal-box button {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #05121a;
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 640px) {
    .calc-row { grid-template-columns: 70px 1fr; }
    .calc-row .inc-id { grid-column: 1 / 2; }
    .calc-row label { grid-column: 2 / 3; }
    .calc-row input { grid-column: 1 / 3; }
}
</style>
</head>
<body>

<div class="wrapper">
    <header>
        <div>
            <h1>MTTD/MTTR Detective</h1>
            <p>The dashboard shows one blended resolution number. Investigate the raw incident log and find out what it's hiding.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-btn">View Tutorial</button>
    </header>

    <div class="brief-box">
        <h2>Mission Briefing</h2>
        <p>Six incidents were logged last month. Each has three timestamps: when it occurred, when it was detected, and when it was resolved.</p>
        <p>Calculate MTTD and MTTR for every incident, work out the averages, and compare them against the team's committed SLA targets. Your finding unlocks once your averages are confirmed correct.</p>
    </div>

    <div class="panel" id="incident-log-table">
        <h2><i class="tbl-icon">📋</i> Incident Timeline Log</h2>
        <table>
            <thead>
                <tr>
                    <th>Incident</th>
                    <th>Occurred</th>
                    <th>Detected</th>
                    <th>Resolved</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>INC-2201</td><td>03/02 01:14</td><td>03/02 01:52</td><td>03/02 05:22</td></tr>
                <tr><td>INC-2202</td><td>03/04 09:05</td><td>03/04 09:41</td><td>03/04 11:11</td></tr>
                <tr><td>INC-2203</td><td>03/07 14:00</td><td>03/07 15:12</td><td>03/07 19:42</td></tr>
                <tr><td>INC-2204</td><td>03/10 22:30</td><td>03/10 22:58</td><td>03/11 00:28</td></tr>
                <tr><td>INC-2205</td><td>03/13 06:15</td><td>03/13 07:29</td><td>03/13 10:59</td></tr>
                <tr><td>INC-2206</td><td>03/15 18:00</td><td>03/15 18:22</td><td>03/15 19:52</td></tr>
            </tbody>
        </table>
    </div>

    <div class="panel" id="calc-panel">
        <h2><i class="tbl-icon">🧮</i> Calculation Panel</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">Enter MTTD and MTTR in minutes for each incident.</p>
        <div class="calc-grid">
            <div class="calc-row"><span class="inc-id">INC-2201</span><label>minutes</label><input type="number" class="mttd-input" data-answer="38" placeholder="MTTD"><input type="number" class="mttr-input" data-answer="210" placeholder="MTTR"></div>
            <div class="calc-row"><span class="inc-id">INC-2202</span><label>minutes</label><input type="number" class="mttd-input" data-answer="36" placeholder="MTTD"><input type="number" class="mttr-input" data-answer="90" placeholder="MTTR"></div>
            <div class="calc-row"><span class="inc-id">INC-2203</span><label>minutes</label><input type="number" class="mttd-input" data-answer="72" placeholder="MTTD"><input type="number" class="mttr-input" data-answer="270" placeholder="MTTR"></div>
            <div class="calc-row"><span class="inc-id">INC-2204</span><label>minutes</label><input type="number" class="mttd-input" data-answer="28" placeholder="MTTD"><input type="number" class="mttr-input" data-answer="90" placeholder="MTTR"></div>
            <div class="calc-row"><span class="inc-id">INC-2205</span><label>minutes</label><input type="number" class="mttd-input" data-answer="74" placeholder="MTTD"><input type="number" class="mttr-input" data-answer="210" placeholder="MTTR"></div>
            <div class="calc-row"><span class="inc-id">INC-2206</span><label>minutes</label><input type="number" class="mttd-input" data-answer="22" placeholder="MTTD"><input type="number" class="mttr-input" data-answer="90" placeholder="MTTR"></div>
        </div>
    </div>

    <div class="panel" id="aggregate-panel">
        <h2><i class="tbl-icon">📊</i> Aggregate Summary</h2>
        <div class="aggregate-grid">
            <div class="agg-field">
                <label>Average MTTD (minutes)</label>
                <input type="number" id="avg-mttd-input" placeholder="e.g. 45">
            </div>
            <div class="agg-field">
                <label>Average MTTR (minutes)</label>
                <input type="number" id="avg-mttr-input" placeholder="e.g. 160">
            </div>
        </div>

        <div class="sla-targets" id="sla-target-display">
            <div class="sla-chip">MTTD target: <strong>&le; 60 min</strong></div>
            <div class="sla-chip">MTTR target: <strong>&le; 150 min</strong></div>
        </div>

        <button class="check-btn" id="check-results-btn">Check Results</button>

        <div class="status-area" id="status-area"></div>
    </div>

    <div class="panel flag-area" id="flag-reveal-area">
        <div id="flag-locked">
            <p class="flag-locked-text">Complete your investigation to unlock the finding.</p>
        </div>
        <div id="flag-unlocked" style="display:none;">
            <p style="color: var(--text-secondary);">Finding: detection is fast, but response is quietly missing its SLA.</p>
            <div class="flag-value" id="flag-text"></div>
            <p class="finding-note">MTTD averaged 45 min (within target). MTTR averaged 160 min (10 min over target).</p>
        </div>
    </div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    var FLAG = "CBX{mttr_sla_missed}";

    var tutorialSteps = [
        { id: "incident-log-table", text: "This is your raw incident data. Every metric starts here. Notice three timestamps per incident: when it happened, when it was caught, and when it was closed." },
        { id: "calc-panel", text: "Use this panel to work out MTTD and MTTR for each incident. MTTD is detection minus occurrence. MTTR is resolution minus detection." },
        { id: "aggregate-panel", text: "Once every incident is calculated, enter the average MTTD and average MTTR here." },
        { id: "sla-target-display", text: "These are the team's committed SLA targets. Your job is to check the averages against them." },
        { id: "check-results-btn", text: "Submit your averages to see whether the team is meeting its commitments." },
        { id: "flag-reveal-area", text: "Once your calculations are confirmed correct, your finding unlocks here." }
    ];

    var stepIndex = 0;
    var spotlightEl, tooltipEl;

    function createOverlayEls() {
        spotlightEl = document.createElement("div");
        spotlightEl.className = "spotlight";
        document.body.appendChild(spotlightEl);

        tooltipEl = document.createElement("div");
        tooltipEl.className = "tooltip-card";
        document.body.appendChild(tooltipEl);
    }

    function removeOverlayEls() {
        if (spotlightEl) spotlightEl.remove();
        if (tooltipEl) tooltipEl.remove();
        spotlightEl = null;
        tooltipEl = null;
    }

    function positionOverlay(target) {
        var rect = target.getBoundingClientRect();
        var pad = 8;
        spotlightEl.style.top = (rect.top - pad) + "px";
        spotlightEl.style.left = (rect.left - pad) + "px";
        spotlightEl.style.width = (rect.width + pad * 2) + "px";
        spotlightEl.style.height = (rect.height + pad * 2) + "px";

        var tooltipWidth = 300;
        var top = rect.bottom + 16;
        var left = rect.left;

        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 140 > window.innerHeight) {
            top = rect.top - 160;
        }
        if (top < 10) top = 10;

        tooltipEl.style.top = top + "px";
        tooltipEl.style.left = left + "px";
    }

    function renderStep() {
        var step = tutorialSteps[stepIndex];
        var target = document.getElementById(step.id);
        if (!target) { nextStep(); return; }

        var rect = target.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
        if (!inView) {
            target.scrollIntoView({ behavior: "smooth", block: "center" });
            setTimeout(function () {
                positionOverlay(target);
                fillTooltip(step);
            }, 300);
        } else {
            positionOverlay(target);
            fillTooltip(step);
        }
    }

    function fillTooltip(step) {
        var isLast = stepIndex === tutorialSteps.length - 1;
        tooltipEl.innerHTML =
            '<div>' + step.text + '</div>' +
            '<div class="tt-actions">' +
                '<button class="skip-btn" id="tt-skip">Skip Tutorial</button>' +
                '<button id="tt-next">' + (isLast ? "Finish" : "Next") + '</button>' +
            '</div>';
        document.getElementById("tt-next").onclick = nextStep;
        document.getElementById("tt-skip").onclick = endTutorial;
    }

    function nextStep() {
        stepIndex++;
        if (stepIndex >= tutorialSteps.length) {
            endTutorial(true);
            return;
        }
        renderStep();
    }

    function endTutorial(completed) {
        removeOverlayEls();
        if (completed) {
            document.getElementById("complete-modal").classList.add("show");
        }
    }

    function startTutorial() {
        stepIndex = 0;
        createOverlayEls();
        renderStep();
    }

    window.addEventListener("resize", function () {
        if (spotlightEl && tutorialSteps[stepIndex]) {
            var target = document.getElementById(tutorialSteps[stepIndex].id);
            if (target) positionOverlay(target);
        }
    });

    document.getElementById("tutorial-btn").addEventListener("click", startTutorial);
    document.getElementById("start-challenge-btn").addEventListener("click", function () {
        document.getElementById("complete-modal").classList.remove("show");
    });

    window.addEventListener("load", function () {
        setTimeout(startTutorial, 400);
    });

    // Challenge logic
    document.getElementById("check-results-btn").addEventListener("click", function () {
        var mttdInputs = document.querySelectorAll(".mttd-input");
        var mttrInputs = document.querySelectorAll(".mttr-input");
        var statusArea = document.getElementById("status-area");

        var allCorrect = true;
        mttdInputs.forEach(function (inp) {
            if (parseInt(inp.value, 10) !== parseInt(inp.dataset.answer, 10)) allCorrect = false;
        });
        mttrInputs.forEach(function (inp) {
            if (parseInt(inp.value, 10) !== parseInt(inp.dataset.answer, 10)) allCorrect = false;
        });

        var avgMttd = parseInt(document.getElementById("avg-mttd-input").value, 10);
        var avgMttr = parseInt(document.getElementById("avg-mttr-input").value, 10);

        if (avgMttd !== 45 || avgMttr !== 160) allCorrect = false;

        statusArea.classList.remove("error", "success");
        statusArea.classList.add("show");

        if (!allCorrect) {
            statusArea.classList.add("error");
            statusArea.textContent = "Some values are incorrect. Recheck each incident's MTTD and MTTR, then recalculate the averages.";
            return;
        }

        statusArea.classList.add("success");
        statusArea.textContent = "All calculations confirmed. MTTD is within target. MTTR is over target.";

        document.getElementById("flag-locked").style.display = "none";
        document.getElementById("flag-unlocked").style.display = "block";
        document.getElementById("flag-text").textContent = FLAG;
        document.getElementById("flag-reveal-area").classList.add("unlocked");
    });
})();
</script>

</body>
</html>
