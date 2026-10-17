<?php
// wordlist-attacks-practical.php
// Standalone static practical: Password Cracker Console
// No backend logic, no database, no sessions. Pure HTML/CSS/JS.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Cracker Console</title>
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
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    min-height: 100vh;
    padding: 24px;
}

.page-wrap {
    max-width: 960px;
    margin: 0 auto;
    position: relative;
}

.tutorial-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 500;
    background: var(--bg-surface);
    color: var(--accent-primary);
    border: 1px solid var(--border-default);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: "Inter", sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--glow-accent);
}
.tutorial-btn:hover { border-color: var(--accent-primary); }

header.top-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border-default);
}
header.top-header h1 {
    font-size: 1.7rem;
    font-weight: 700;
    color: var(--text-primary);
}
header.top-header p {
    color: var(--text-secondary);
    margin-top: 6px;
    font-size: 0.95rem;
}

.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
}
.description-section h2 {
    font-size: 1rem;
    color: var(--accent-secondary);
    margin-bottom: 8px;
}
.description-section p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 8px;
}
.description-section p:last-child { margin-bottom: 0; }

.console-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
@media (max-width: 760px) {
    .console-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 18px;
}
.panel h3 {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 10px;
}

#target-hash {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.95rem;
    color: var(--accent-primary);
    word-break: break-all;
    background: var(--bg-primary);
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid var(--border-default);
}

.wordlist-box {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
    background: var(--bg-primary);
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid var(--border-default);
    line-height: 1.7;
    max-height: 160px;
    overflow-y: auto;
}

.rule-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}
.rule-btn {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 8px 12px;
    border-radius: 6px;
    font-family: "Inter", sans-serif;
    font-size: 0.82rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.rule-btn:hover { border-color: var(--accent-secondary); color: var(--text-primary); }
.rule-btn.active {
    background: rgba(139,123,255,0.15);
    border-color: var(--accent-secondary);
    color: var(--accent-secondary);
    box-shadow: 0 0 10px rgba(139,123,255,0.25);
}

.preview-line {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--warning);
    background: var(--bg-primary);
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid var(--border-default);
}

.run-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-top: 16px;
    padding: 12px 26px;
    background: linear-gradient(135deg, #142033, #1f3350, #142033);
    border: 1px solid var(--accent-primary);
    border-radius: 8px;
    color: var(--accent-primary);
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--glow-accent);
    transition: all 0.25s ease;
}
.run-btn:hover { transform: translateY(-1px); box-shadow: 0 0 20px rgba(106,227,255,0.45); }
.run-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

.output-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 16px;
}
.output-log {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    background: var(--bg-primary);
    border-radius: 6px;
    border: 1px solid var(--border-default);
    padding: 12px;
    min-height: 160px;
    max-height: 220px;
    overflow-y: auto;
    color: var(--text-secondary);
}
.output-log .line { margin-bottom: 4px; }
.output-line-fail { color: var(--text-muted); }
.output-line-match { color: var(--success); font-weight: 600; }
.status-line {
    margin-top: 10px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
}
.status-fail { color: var(--error); }
.status-success { color: var(--success); }

.flag-panel {
    display: none;
    background: rgba(61,255,154,0.08);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 18px 20px;
    text-align: center;
    margin-bottom: 20px;
}
.flag-panel.show { display: block; }
.flag-panel h3 {
    color: var(--success);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 10px 20px;
    border-radius: 6px;
    border: 1px solid var(--success);
}

/* Spotlight tutorial */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 900;
    transition: all 0.25s ease;
}
.tooltip-card {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 14px 16px;
    z-index: 901;
    box-shadow: var(--glow-accent);
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.tooltip-card h4 { color: var(--accent-primary); font-size: 0.85rem; margin-bottom: 6px; }
.tooltip-actions { display: flex; justify-content: space-between; margin-top: 12px; }
.tooltip-actions button {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
}
.tooltip-actions .next-btn { border-color: var(--accent-primary); color: var(--accent-primary); }

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 950;
    align-items: center;
    justify-content: center;
}
.modal-overlay.show { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 30px;
    text-align: center;
    max-width: 340px;
}
.modal-card h3 { color: var(--accent-primary); margin-bottom: 10px; }
.modal-card p { color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 18px; }
.modal-card button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>
<button class="tutorial-btn" id="tutorial-btn">View Tutorial</button>

<div class="page-wrap">
    <header class="top-header">
        <h1>Password Cracker Console</h1>
        <p>A simulated Hashcat style environment. Crack the captured hash using the wordlist and a mutation rule.</p>
    </header>

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>Your team captured a password hash during a simulated penetration test. A short wordlist of candidate passwords was also recovered from the target's environment.</p>
        <p>Run the wordlist as it is first. If it fails, apply a mutation rule and run the attack again. Keep going until the console reports a match.</p>
    </div>

    <div class="console-grid">
        <div class="panel" id="panel-hash">
            <h3>Target Hash</h3>
            <div id="target-hash">a2f9e8cd105b8f9f6e2d84a1b6d3c9de</div>
        </div>
        <div class="panel" id="panel-wordlist">
            <h3>Wordlist</h3>
            <div class="wordlist-box">
                dragon<br>sunshine<br>princess<br>football<br>monkey<br>shadow<br>baseball<br>master
            </div>
        </div>
    </div>

    <div class="panel" id="panel-rules" style="margin-bottom:16px;">
        <h3>Mutation Rule</h3>
        <div class="rule-buttons">
            <button class="rule-btn active" data-rule="none">Raw Wordlist (No Rule)</button>
            <button class="rule-btn" data-rule="year">Append Year (2011)</button>
            <button class="rule-btn" data-rule="capitalize">Capitalize First Letter</button>
            <button class="rule-btn" data-rule="leet">Leetspeak Substitution</button>
        </div>
        <div class="preview-line" id="preview-line">Preview: dragon &rarr; dragon</div>
        <button class="run-btn" id="run-btn">&#9889; Run Attack</button>
    </div>

    <div class="output-panel" id="panel-output">
        <h3 style="font-size:0.85rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:10px;">Output Log</h3>
        <div class="output-log" id="output-log">
            <div class="line" style="color:var(--text-muted);">Console ready. Select a rule and run the attack.</div>
        </div>
        <div class="status-line" id="status-line"></div>
    </div>

    <div class="flag-panel" id="flag-panel">
        <h3>Hash Cracked</h3>
        <div class="flag-value">CBX{hash_cracked}</div>
    </div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const wordlist = ["dragon","sunshine","princess","football","monkey","shadow","baseball","master"];
const targetPassword = "dragon2011";
let selectedRule = "none";
let hasFailedRun = false;
let cracked = false;

function applyRule(word, rule) {
    switch(rule) {
        case "year": return word + "2011";
        case "capitalize": return word.charAt(0).toUpperCase() + word.slice(1);
        case "leet": return word.replace(/a/g,"4").replace(/e/g,"3").replace(/o/g,"0");
        default: return word;
    }
}

const ruleButtons = document.querySelectorAll(".rule-btn");
const previewLine = document.getElementById("preview-line");
const runBtn = document.getElementById("run-btn");
const outputLog = document.getElementById("output-log");
const statusLine = document.getElementById("status-line");
const flagPanel = document.getElementById("flag-panel");

function updatePreview() {
    const mutated = applyRule(wordlist[0], selectedRule);
    previewLine.innerHTML = "Preview: " + wordlist[0] + " &rarr; " + mutated;
}

ruleButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        ruleButtons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        selectedRule = btn.dataset.rule;
        updatePreview();
    });
});

updatePreview();

runBtn.addEventListener("click", () => {
    if (cracked) return;
    runBtn.disabled = true;
    outputLog.innerHTML = "";
    statusLine.textContent = "";
    statusLine.className = "status-line";

    let i = 0;
    let matched = false;
    let matchedWord = "";

    function step() {
        if (i < wordlist.length) {
            const candidate = applyRule(wordlist[i], selectedRule);
            const isMatch = candidate === targetPassword;
            const line = document.createElement("div");
            line.className = "line " + (isMatch ? "output-line-match" : "output-line-fail");
            line.textContent = "Trying \"" + candidate + "\" ... " + (isMatch ? "MATCH" : "no match");
            outputLog.appendChild(line);
            outputLog.scrollTop = outputLog.scrollHeight;
            if (isMatch) { matched = true; matchedWord = candidate; }
            i++;
            setTimeout(step, 220);
        } else {
            finishRun(matched, matchedWord);
        }
    }
    step();
});

function finishRun(matched, matchedWord) {
    runBtn.disabled = false;
    if (matched) {
        statusLine.textContent = "Match found: " + matchedWord;
        statusLine.classList.add("status-success");
        if (hasFailedRun) {
            cracked = true;
            flagPanel.classList.add("show");
        } else {
            // matched on the very first try without a prior failed attempt
            // still counts as success, but we only reveal after a genuine attempt sequence
            cracked = true;
            flagPanel.classList.add("show");
        }
    } else {
        statusLine.textContent = "Exhausted, 0/" + wordlist.length + " matches";
        statusLine.classList.add("status-fail");
        hasFailedRun = true;
    }
}

// ============ Spotlight Tutorial System ============
const tutorialSteps = [
    { targetId: "panel-hash", text: "This is the hash you are trying to crack. You cannot reverse a hash directly, but you can hash guesses and compare them against it." },
    { targetId: "panel-wordlist", text: "This is your wordlist, a list of real candidate passwords, just like the ones covered in the room." },
    { targetId: "panel-rules", text: "Rules mutate each wordlist entry into likely variations, the same way real cracking tools do. Try selecting a different rule and watch the preview change." },
    { targetId: "panel-output", text: "This simulates the tool hashing every candidate and checking it against the target. Watch here to see which candidates were tried and whether any matched." }
];
let currentStep = 0;
let spotlightEl, tooltipEl;

function createSpotlightElements() {
    spotlightEl = document.createElement("div");
    spotlightEl.className = "spotlight";
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement("div");
    tooltipEl.className = "tooltip-card";
    document.body.appendChild(tooltipEl);
}

function positionSpotlight(targetId, text, stepIndex, totalSteps) {
    const el = document.getElementById(targetId);
    if (!el) return;
    el.scrollIntoView({ behavior: "smooth", block: "center" });
    setTimeout(() => {
        const rect = el.getBoundingClientRect();
        const pad = 8;
        spotlightEl.style.top = (rect.top - pad) + "px";
        spotlightEl.style.left = (rect.left - pad) + "px";
        spotlightEl.style.width = (rect.width + pad * 2) + "px";
        spotlightEl.style.height = (rect.height + pad * 2) + "px";

        let tooltipTop = rect.bottom + 14;
        let tooltipLeft = rect.left;
        if (tooltipTop + 160 > window.innerHeight) {
            tooltipTop = rect.top - 170;
        }
        if (tooltipLeft + 280 > window.innerWidth) {
            tooltipLeft = window.innerWidth - 300;
        }
        tooltipEl.style.top = tooltipTop + "px";
        tooltipEl.style.left = tooltipLeft + "px";

        tooltipEl.innerHTML = "<h4>Step " + (stepIndex + 1) + " of " + totalSteps + "</h4><p>" + text + "</p>" +
            "<div class='tooltip-actions'>" +
            "<button id='skip-tutorial-btn'>Skip Tutorial</button>" +
            "<button class='next-btn' id='next-step-btn'>" + (stepIndex === totalSteps - 1 ? "Finish" : "Next") + "</button>" +
            "</div>";

        document.getElementById("skip-tutorial-btn").addEventListener("click", endTutorial);
        document.getElementById("next-step-btn").addEventListener("click", nextStep);
    }, 300);
}

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) createSpotlightElements();
    spotlightEl.style.display = "block";
    tooltipEl.style.display = "block";
    showStep();
}

function showStep() {
    const step = tutorialSteps[currentStep];
    positionSpotlight(step.targetId, step.text, currentStep, tutorialSteps.length);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        showStep();
    }
}

function endTutorial(completed) {
    if (spotlightEl) spotlightEl.style.display = "none";
    if (tooltipEl) tooltipEl.style.display = "none";
    if (completed) {
        document.getElementById("complete-modal").classList.add("show");
    }
}

document.getElementById("tutorial-btn").addEventListener("click", startTutorial);
document.getElementById("start-challenge-btn").addEventListener("click", () => {
    document.getElementById("complete-modal").classList.remove("show");
});

window.addEventListener("resize", () => {
    if (spotlightEl && spotlightEl.style.display === "block") {
        showStep();
    }
});

window.addEventListener("load", () => {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
