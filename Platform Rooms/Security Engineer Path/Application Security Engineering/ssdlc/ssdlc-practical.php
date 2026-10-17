<?php
// Filename: ssdlc-practical.php
// Standalone static practical: Threat Model Table
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Threat Model Table | CYBRIXEN</title>
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
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 24px;
}
.container { max-width: 960px; margin: 0 auto; position: relative; }

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    gap: 16px;
    flex-wrap: wrap;
}
.header h1 { font-size: 1.6rem; font-weight: 700; margin-bottom: 6px; }
.header .subtitle { color: var(--text-secondary); font-size: 0.95rem; max-width: 560px; }
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* Description */
.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.6;
}
.description-section strong { color: var(--text-primary); }

/* Architecture diagram */
#architecture-diagram {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 28px 20px;
    margin-bottom: 24px;
    position: relative;
}
.diagram-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.component-node {
    flex: 1;
    min-width: 130px;
    background: var(--bg-surface);
    border: 2px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 12px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.15s ease;
    position: relative;
}
.component-node:hover { border-color: var(--accent-primary); transform: translateY(-2px); }
.component-node .node-icon { font-size: 1.6rem; margin-bottom: 8px; display: block; }
.component-node .node-label { font-size: 0.85rem; font-weight: 600; }
.component-node .node-status {
    margin-top: 8px;
    font-size: 0.72rem;
    font-family: "JetBrains Mono", monospace;
    color: var(--text-muted);
}
.component-node.status-correct { border-color: var(--success); box-shadow: 0 0 14px rgba(61,255,154,0.25); }
.component-node.status-incorrect { border-color: var(--error); box-shadow: 0 0 14px rgba(255,92,92,0.25); }
.component-node.status-correct .node-status { color: var(--success); }
.component-node.status-incorrect .node-status { color: var(--error); }

.diagram-arrow {
    color: var(--text-muted);
    font-size: 1.3rem;
    padding: 0 4px;
}

/* STRIDE selector panel (modal) */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    z-index: 500;
    align-items: center;
    justify-content: center;
}
.modal-overlay.active { display: flex; }
#stride-selector-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    width: 90%;
    max-width: 420px;
}
#stride-selector-panel h3 { font-size: 1.05rem; margin-bottom: 4px; }
#stride-selector-panel .panel-sub { color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 16px; }
.stride-option {
    display: block;
    width: 100%;
    text-align: left;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 12px 14px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.88rem;
    cursor: pointer;
    margin-bottom: 8px;
    transition: border-color 0.2s ease;
}
.stride-option:hover { border-color: var(--accent-secondary); }
.stride-option.selected { border-color: var(--accent-primary); background: rgba(106,227,255,0.08); }
.panel-close-btn {
    margin-top: 10px;
    background: transparent;
    border: none;
    color: var(--text-muted);
    font-size: 0.8rem;
    cursor: pointer;
}

/* Feedback / status area */
#feedback-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 24px;
    font-size: 0.88rem;
    color: var(--text-secondary);
    min-height: 24px;
}
#feedback-area.has-error { border-color: var(--error); color: var(--error); }
#feedback-area.has-success { border-color: var(--success); color: var(--success); }

/* Validate button */
#validate-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 28px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    margin-bottom: 24px;
    transition: box-shadow 0.2s ease;
}
#validate-btn:hover { box-shadow: var(--glow-accent); }

/* Flag reveal area */
#flag-reveal-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    display: none;
}
#flag-reveal-area.revealed { display: block; border-color: var(--success); }
#flag-reveal-area h3 { color: var(--success); margin-bottom: 12px; font-size: 1.1rem; }
#flag-value {
    display: inline-block;
    font-family: "JetBrains Mono", monospace;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 1rem;
    letter-spacing: 0.02em;
}

/* Spotlight tutorial system */
#spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    z-index: 900;
    pointer-events: none;
    transition: top 0.25s ease, left 0.25s ease, width 0.25s ease, height 0.25s ease;
}
#tutorial-tooltip {
    position: fixed;
    z-index: 901;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    font-size: 0.85rem;
    color: var(--text-primary);
    box-shadow: var(--glow-accent);
}
#tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
    gap: 10px;
}
#tutorial-tooltip button {
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
#tt-next-btn { background: var(--accent-primary); color: #06121c; }
#tt-skip-btn { background: transparent; color: var(--text-muted); }

/* Completion modal */
#tutorial-complete-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 950;
    align-items: center;
    justify-content: center;
}
#tutorial-complete-modal.active { display: flex; }
.complete-modal-card {
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 32px;
    text-align: center;
    max-width: 360px;
}
.complete-modal-card h3 { color: var(--success); margin-bottom: 10px; }
.complete-modal-card p { color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 18px; }
#start-challenge-btn {
    background: var(--success);
    color: #06301c;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 600px) {
    .diagram-row { flex-direction: column; }
    .diagram-arrow { transform: rotate(90deg); }
}
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h1>Threat Model Table</h1>
            <p class="subtitle">Architecture review for a fictional web application. Map each component to its primary STRIDE threat before the build phase begins.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="description-section">
        <p><strong>What this represents:</strong> the architecture diagram of a new web application under security review. <strong>Your task:</strong> assign the single most applicable STRIDE category to each of the four components. <strong>Your goal:</strong> get all four components correct to unlock the completed threat model.</p>
    </div>

    <div id="architecture-diagram">
        <div class="diagram-row">
            <div class="component-node" id="component-frontend" data-component="frontend">
                <span class="node-icon">🖥️</span>
                <span class="node-label">Web Client</span>
                <span class="node-status" data-status="frontend">Not assigned</span>
            </div>
            <span class="diagram-arrow">→</span>
            <div class="component-node" id="component-auth" data-component="auth">
                <span class="node-icon">🔑</span>
                <span class="node-label">Auth Service</span>
                <span class="node-status" data-status="auth">Not assigned</span>
            </div>
            <span class="diagram-arrow">→</span>
            <div class="component-node" id="component-api" data-component="api">
                <span class="node-icon">⚙️</span>
                <span class="node-label">API</span>
                <span class="node-status" data-status="api">Not assigned</span>
            </div>
            <span class="diagram-arrow">→</span>
            <div class="component-node" id="component-database" data-component="database">
                <span class="node-icon">🗄️</span>
                <span class="node-label">Database</span>
                <span class="node-status" data-status="database">Not assigned</span>
            </div>
        </div>
    </div>

    <button id="validate-btn">Validate Threat Model</button>

    <div id="feedback-area">Assign a STRIDE category to all four components, then validate your threat model.</div>

    <div id="flag-reveal-area">
        <h3>Threat Model Approved</h3>
        <p style="color: var(--text-secondary); margin-bottom: 14px;">Every component has been correctly mapped to its primary threat. Your flag:</p>
        <span id="flag-value">CBX{threats_modeled}</span>
    </div>
</div>

<!-- STRIDE selector modal -->
<div class="modal-overlay" id="modal-overlay">
    <div id="stride-selector-panel">
        <h3 id="panel-title">Assign a Threat</h3>
        <p class="panel-sub" id="panel-sub">Pick the STRIDE category that best fits this component.</p>
        <button class="stride-option" data-value="Spoofing">Spoofing</button>
        <button class="stride-option" data-value="Tampering">Tampering</button>
        <button class="stride-option" data-value="Repudiation">Repudiation</button>
        <button class="stride-option" data-value="Information Disclosure">Information Disclosure</button>
        <button class="stride-option" data-value="Denial of Service">Denial of Service</button>
        <button class="stride-option" data-value="Elevation of Privilege">Elevation of Privilege</button>
        <button class="panel-close-btn" id="panel-close-btn">Close</button>
    </div>
</div>

<!-- Tutorial spotlight elements -->
<div id="spotlight" style="display:none;"></div>
<div id="tutorial-tooltip" style="display:none;">
    <div id="tt-text"></div>
    <div class="tt-actions">
        <button id="tt-skip-btn">Skip Tutorial</button>
        <button id="tt-next-btn">Next</button>
    </div>
</div>

<!-- Tutorial complete modal -->
<div id="tutorial-complete-modal">
    <div class="complete-modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Assign STRIDE categories to each component and validate your threat model.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    // ---------- Data ----------
    var correctAnswers = {
        frontend: "Spoofing",
        auth: "Elevation of Privilege",
        api: "Tampering",
        database: "Information Disclosure"
    };
    var assignments = {};
    var activeComponent = null;

    var nodeEls = {
        frontend: document.getElementById("component-frontend"),
        auth: document.getElementById("component-auth"),
        api: document.getElementById("component-api"),
        database: document.getElementById("component-database")
    };
    var labels = {
        frontend: "Web Client",
        auth: "Auth Service",
        api: "API",
        database: "Database"
    };

    var modalOverlay = document.getElementById("modal-overlay");
    var panelTitle = document.getElementById("panel-title");
    var panelSub = document.getElementById("panel-sub");
    var strideOptions = document.querySelectorAll(".stride-option");
    var panelCloseBtn = document.getElementById("panel-close-btn");
    var feedbackArea = document.getElementById("feedback-area");
    var validateBtn = document.getElementById("validate-btn");
    var flagArea = document.getElementById("flag-reveal-area");

    function openPanel(component) {
        activeComponent = component;
        panelTitle.textContent = "Assign a Threat: " + labels[component];
        panelSub.textContent = "Pick the STRIDE category that best fits this component's main exposure.";
        strideOptions.forEach(function (opt) {
            opt.classList.toggle("selected", assignments[component] === opt.getAttribute("data-value"));
        });
        modalOverlay.classList.add("active");
    }
    function closePanel() {
        modalOverlay.classList.remove("active");
        activeComponent = null;
    }

    Object.keys(nodeEls).forEach(function (key) {
        nodeEls[key].addEventListener("click", function () { openPanel(key); });
    });
    panelCloseBtn.addEventListener("click", closePanel);
    modalOverlay.addEventListener("click", function (e) {
        if (e.target === modalOverlay) closePanel();
    });

    strideOptions.forEach(function (opt) {
        opt.addEventListener("click", function () {
            if (!activeComponent) return;
            assignments[activeComponent] = opt.getAttribute("data-value");
            var statusEl = document.querySelector('[data-status="' + activeComponent + '"]');
            statusEl.textContent = opt.getAttribute("data-value");
            nodeEls[activeComponent].classList.remove("status-correct", "status-incorrect");
            closePanel();
        });
    });

    validateBtn.addEventListener("click", function () {
        var allAssigned = Object.keys(correctAnswers).every(function (key) { return assignments[key]; });
        if (!allAssigned) {
            feedbackArea.className = "has-error";
            feedbackArea.textContent = "Assign a threat category to every component before validating.";
            return;
        }

        var allCorrect = true;
        Object.keys(correctAnswers).forEach(function (key) {
            var isCorrect = assignments[key] === correctAnswers[key];
            nodeEls[key].classList.remove("status-correct", "status-incorrect");
            nodeEls[key].classList.add(isCorrect ? "status-correct" : "status-incorrect");
            if (!isCorrect) allCorrect = false;
        });

        if (allCorrect) {
            feedbackArea.className = "has-success";
            feedbackArea.textContent = "All four components correctly mapped. Threat model approved.";
            flagArea.classList.add("revealed");
        } else {
            feedbackArea.className = "has-error";
            feedbackArea.textContent = "One or more components do not match their primary exposure. Reconsider what each component's main risk actually is, then revalidate.";
            flagArea.classList.remove("revealed");
        }
    });

    // ---------- Tutorial spotlight system ----------
    var tutorialSteps = [
        { targetId: "architecture-diagram", text: "This is the architecture for our fictional app: a web client, an auth service, an API, and a database. Think of it like a floor plan, before you can secure a building you need to know where every room is." },
        { targetId: "component-frontend", text: "Click any component to open its threat options. Let's start with the Web Client. This is where the user first interacts with the system." },
        { targetId: "stride-selector-panel", text: "These six categories are STRIDE, the standard threat modeling framework. Pick the one that best describes this component's main risk.", requiresModal: true },
        { targetId: "validate-btn", text: "Once you've assigned a threat to all four components, click here to check your work, like a security architect signing off on the design." },
        { targetId: "feedback-area", text: "Incorrect assignments turn red with a hint. You can change your answer and revalidate as many times as you need." },
        { targetId: "flag-reveal-area", text: "Once every component is correctly mapped, your completed threat model unlocks here, along with your flag." }
    ];
    var currentStep = -1;

    var spotlightEl = document.getElementById("spotlight");
    var tooltipEl = document.getElementById("tutorial-tooltip");
    var ttText = document.getElementById("tt-text");
    var ttNextBtn = document.getElementById("tt-next-btn");
    var ttSkipBtn = document.getElementById("tt-skip-btn");
    var completeModal = document.getElementById("tutorial-complete-modal");
    var viewTutorialBtn = document.getElementById("view-tutorial-btn");
    var startChallengeBtn = document.getElementById("start-challenge-btn");

    function positionSpotlight(targetEl) {
        var rect = targetEl.getBoundingClientRect();
        var pad = 8;
        spotlightEl.style.top = (rect.top - pad) + "px";
        spotlightEl.style.left = (rect.left - pad) + "px";
        spotlightEl.style.width = (rect.width + pad * 2) + "px";
        spotlightEl.style.height = (rect.height + pad * 2) + "px";
        spotlightEl.style.display = "block";

        var tooltipWidth = 300;
        var top, left;
        var spaceBelow = window.innerHeight - rect.bottom;
        if (spaceBelow > 160) {
            top = rect.bottom + 14;
            left = Math.min(Math.max(rect.left, 10), window.innerWidth - tooltipWidth - 10);
        } else {
            top = Math.max(rect.top - 160, 10);
            left = Math.min(Math.max(rect.left, 10), window.innerWidth - tooltipWidth - 10);
        }
        tooltipEl.style.top = top + "px";
        tooltipEl.style.left = left + "px";
        tooltipEl.style.display = "block";
    }

    function showStep(index) {
        if (index >= tutorialSteps.length) {
            endTutorial(true);
            return;
        }
        currentStep = index;
        var step = tutorialSteps[index];

        if (step.requiresModal && !modalOverlay.classList.contains("active")) {
            openPanel("frontend");
        }

        var targetEl = document.getElementById(step.targetId);
        if (!targetEl) { showStep(index + 1); return; }

        var rect = targetEl.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
        if (!inView) {
            targetEl.scrollIntoView({ behavior: "smooth", block: "center" });
            setTimeout(function () {
                positionSpotlight(targetEl);
                ttText.textContent = step.text;
            }, 300);
        } else {
            positionSpotlight(targetEl);
            ttText.textContent = step.text;
        }
    }

    function startTutorial() {
        closePanel();
        showStep(0);
    }

    function endTutorial(showCompleteModal) {
        spotlightEl.style.display = "none";
        tooltipEl.style.display = "none";
        closePanel();
        currentStep = -1;
        if (showCompleteModal) {
            completeModal.classList.add("active");
        }
    }

    ttNextBtn.addEventListener("click", function () { showStep(currentStep + 1); });
    ttSkipBtn.addEventListener("click", function () { endTutorial(false); });
    viewTutorialBtn.addEventListener("click", startTutorial);
    startChallengeBtn.addEventListener("click", function () { completeModal.classList.remove("active"); });

    window.addEventListener("resize", function () {
        if (currentStep >= 0 && currentStep < tutorialSteps.length) {
            var step = tutorialSteps[currentStep];
            var targetEl = document.getElementById(step.targetId);
            if (targetEl) positionSpotlight(targetEl);
        }
    });

    window.addEventListener("load", function () {
        setTimeout(startTutorial, 400);
    });
})();
</script>
</body>
</html>
