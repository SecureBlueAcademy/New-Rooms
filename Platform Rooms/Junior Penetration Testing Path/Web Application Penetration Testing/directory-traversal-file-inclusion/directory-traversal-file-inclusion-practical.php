<?php
// Filename: directory-traversal-file-inclusion-practical.php
// Standalone static practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document Viewer | CYBRIXEN Practical</title>
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
}

.mono { font-family: "JetBrains Mono", monospace; }

.page-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== Top header ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 6px;
}
.top-header h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
}
.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    color: var(--accent-primary);
    border: 1px solid var(--border-default);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* ===== Description section ===== */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 22px;
    margin: 24px 0;
}
.briefing h2 {
    margin-top: 0;
    font-size: 1.1rem;
    color: var(--accent-primary);
}
.briefing p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

/* ===== Main interactive environment ===== */
.portal {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 0;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    overflow: hidden;
}
.portal-sidebar {
    background: var(--bg-surface);
    border-right: 1px solid var(--border-default);
    padding: 18px 14px;
}
.portal-sidebar h3 {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin: 0 0 12px 0;
}
.doc-link {
    display: block;
    width: 100%;
    text-align: left;
    background: transparent;
    border: none;
    color: var(--text-secondary);
    padding: 9px 10px;
    border-radius: 6px;
    font-size: 0.85rem;
    cursor: pointer;
    margin-bottom: 4px;
}
.doc-link:hover {
    background: rgba(106,227,255,0.08);
    color: var(--accent-primary);
}
.portal-main {
    padding: 20px 22px;
}
.url-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 14px;
}
.url-bar .url-prefix {
    color: var(--text-muted);
    font-size: 0.85rem;
    white-space: nowrap;
}
#url-bar-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--accent-primary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.9rem;
}
#load-button {
    background: var(--accent-primary);
    color: #061018;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
}
#load-button:hover {
    box-shadow: var(--glow-accent);
}
#document-display {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 18px;
    min-height: 160px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
    white-space: pre-wrap;
}

/* ===== Feedback / status area ===== */
#status-feedback {
    margin: 16px 0;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-family: "JetBrains Mono", monospace;
    border: 1px solid var(--border-default);
    background: var(--bg-secondary);
    color: var(--text-secondary);
}
#status-feedback.status-error { color: var(--error); border-color: var(--error); }
#status-feedback.status-success { color: var(--success); border-color: var(--success); }

/* ===== Flag reveal ===== */
.flag-reveal {
    display: none;
    margin-top: 24px;
    background: rgba(61,255,154,0.06);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 20px 22px;
    text-align: center;
}
.flag-reveal.visible { display: block; }
.flag-reveal h3 {
    margin-top: 0;
    color: var(--success);
}
.flag-value {
    display: inline-block;
    margin-top: 8px;
    padding: 10px 18px;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    color: var(--success);
    font-family: "JetBrains Mono", monospace;
    font-size: 1rem;
    letter-spacing: 0.02em;
}

/* ===== Tutorial spotlight ===== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.2s ease;
    z-index: 9998;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    background: var(--accent-primary);
    color: #061018;
    border: none;
    padding: 7px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
}
.tooltip-skip {
    background: transparent !important;
    color: var(--text-muted) !important;
    padding: 7px 4px !important;
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.visible { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin-top: 0; color: var(--accent-primary); }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; }
.modal-box button {
    margin-top: 14px;
    background: var(--accent-primary);
    color: #061018;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 640px) {
    .portal { grid-template-columns: 1fr; }
    .portal-sidebar { border-right: none; border-bottom: 1px solid var(--border-default); }
    .top-header { flex-direction: column; }
}
</style>
</head>
<body>
<div class="page-wrap">

    <!-- 1. Top header -->
    <div class="top-header">
        <div>
            <h1>Document Viewer</h1>
            <p class="subtitle">Corporate Document Portal, internal build. The file parameter below controls which document is displayed.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. Description section -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This portal is meant to serve documents only from its public documents folder. Somewhere outside that folder sits a restricted admin notes file that was never supposed to be reachable through this viewer.</p>
        <p>Change the value in the address bar to control which file is loaded. Watch the status area carefully. It tells you whether your input was blocked, silently altered, or accepted.</p>
    </div>

    <!-- 3. Main interactive environment -->
    <div class="portal">
        <div class="portal-sidebar" id="sidebar-docs">
            <h3>Public Documents</h3>
            <button class="doc-link" data-file="report_q1.pdf">report_q1.pdf</button>
            <button class="doc-link" data-file="report_q2.pdf">report_q2.pdf</button>
            <button class="doc-link" data-file="report_q3.pdf">report_q3.pdf</button>
            <button class="doc-link" data-file="employee_handbook.pdf">employee_handbook.pdf</button>
        </div>
        <div class="portal-main">
            <div class="url-bar">
                <span class="url-prefix mono">portal.php?file=</span>
                <input type="text" id="url-bar-input" class="mono" value="report_q3.pdf">
                <button id="load-button">Load</button>
            </div>
            <div id="document-display">Select a document or edit the file parameter, then click Load.</div>
        </div>
    </div>

    <!-- 4. Feedback / status area -->
    <div id="status-feedback">Ready.</div>

    <!-- 5. Flag reveal area -->
    <div class="flag-reveal" id="flag-reveal">
        <h3>Access Granted</h3>
        <p>The restricted file has loaded successfully. Your flag is below.</p>
        <div class="flag-value mono" id="flag-value">CBX{traversal_bypassed}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button class="tooltip-skip" id="tooltip-skip">Skip Tutorial</button>
        <button id="tooltip-next">Next</button>
    </div>
</div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Find a way to reach the restricted admin notes file.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ===================== Virtual file system =====================
const files = {
    "/app/data/public_docs/report_q1.pdf":
        "REPORT Q1\n\nRevenue summary for the first quarter. All figures within expected range.\nNo anomalies flagged by the finance team.",
    "/app/data/public_docs/report_q2.pdf":
        "REPORT Q2\n\nRevenue summary for the second quarter. Growth of 4 percent over Q1.\nMarketing spend increased in line with projections.",
    "/app/data/public_docs/report_q3.pdf":
        "REPORT Q3\n\nRevenue summary for the third quarter. Slight dip attributed to seasonal\nfactors. Full breakdown available on request.",
    "/app/data/public_docs/employee_handbook.pdf":
        "EMPLOYEE HANDBOOK\n\nWelcome to the company. This handbook covers leave policy, conduct\nguidelines, and IT usage rules.",
    "/app/data/restricted/admin_notes.txt":
        "ADMIN NOTES (RESTRICTED)\n\nReminder: the document portal filter only strips a single occurrence\nof a traversal sequence per request. This is not sufficient protection.\n\nFlag: CBX{traversal_bypassed}"
};

const BASE_SEGMENTS = ["app", "data", "public_docs"];

// Naive single pass filter, mirrors str_replace('../', '', $input)
function naiveFilter(input) {
    return input.split("../").join("");
}

// Resolve a relative path against the base directory
function resolvePath(relativeInput) {
    const segments = BASE_SEGMENTS.slice();
    const parts = relativeInput.split("/");
    for (const part of parts) {
        if (part === "" || part === ".") continue;
        if (part === "..") {
            segments.pop();
        } else {
            segments.push(part);
        }
    }
    return "/" + segments.join("/");
}

const urlInput = document.getElementById("url-bar-input");
const loadButton = document.getElementById("load-button");
const statusFeedback = document.getElementById("status-feedback");
const documentDisplay = document.getElementById("document-display");
const flagReveal = document.getElementById("flag-reveal");
const sidebar = document.getElementById("sidebar-docs");

function setStatus(message, type) {
    statusFeedback.textContent = message;
    statusFeedback.classList.remove("status-error", "status-success");
    if (type) statusFeedback.classList.add(type);
}

function loadFile() {
    const raw = urlInput.value.trim();
    const filtered = naiveFilter(raw);
    const resolved = resolvePath(filtered);

    if (Object.prototype.hasOwnProperty.call(files, resolved)) {
        documentDisplay.textContent = files[resolved];
        if (resolved === "/app/data/restricted/admin_notes.txt") {
            setStatus("200 OK. Restricted file resolved: " + resolved, "status-success");
            flagReveal.classList.add("visible");
        } else {
            setStatus("200 OK. File resolved: " + resolved, "status-success");
        }
    } else {
        documentDisplay.textContent = "No content to display.";
        setStatus("404. File not found after filtering: " + resolved, "status-error");
    }
}

loadButton.addEventListener("click", loadFile);
urlInput.addEventListener("keydown", function (e) {
    if (e.key === "Enter") loadFile();
});

sidebar.addEventListener("click", function (e) {
    const btn = e.target.closest(".doc-link");
    if (!btn) return;
    urlInput.value = btn.dataset.file;
    loadFile();
});

// ===================== Tutorial spotlight system =====================
const tutorialSteps = [
    { targetElementId: "url-bar-input", tooltipText: "This is the file parameter. The portal loads whatever file this value points to, just like a real query string parameter would." },
    { targetElementId: "sidebar-docs", tooltipText: "These are the documents you're meant to see. All of them live inside the public_docs folder." },
    { targetElementId: "load-button", tooltipText: "Click Load to send the current file parameter to the server and fetch the result." },
    { targetElementId: "status-feedback", tooltipText: "Watch this area closely. It tells you whether a request succeeded, was blocked, or simply returned nothing, and each of those means something different." },
    { targetElementId: "document-display", tooltipText: "The content of whatever file successfully loads appears here." }
];

let currentStep = 0;
const spotlight = document.getElementById("spotlight");
const tooltipCard = document.getElementById("tooltip-card");
const tooltipText = document.getElementById("tooltip-text");
const tutorialBtn = document.getElementById("tutorial-btn");
const tutorialCompleteModal = document.getElementById("tutorial-complete-modal");

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + "px";
    spotlight.style.left = (rect.left - pad) + "px";
    spotlight.style.width = (rect.width + pad * 2) + "px";
    spotlight.style.height = (rect.height + pad * 2) + "px";
    spotlight.style.display = "block";

    let tooltipTop = rect.bottom + 16;
    let tooltipLeft = rect.left;
    const tooltipWidth = 300;

    if (tooltipLeft + tooltipWidth > window.innerWidth - 20) {
        tooltipLeft = window.innerWidth - tooltipWidth - 20;
    }
    if (tooltipTop + 140 > window.innerHeight) {
        tooltipTop = rect.top - 150;
    }

    tooltipCard.style.top = tooltipTop + "px";
    tooltipCard.style.left = tooltipLeft + "px";
    tooltipCard.style.display = "block";
}

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial();
        tutorialCompleteModal.classList.add("visible");
        return;
    }
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetElementId);
    if (!el) { currentStep++; showStep(currentStep); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    tooltipText.textContent = step.tooltipText;

    if (!inView) {
        el.scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => positionSpotlight(el), 300);
    } else {
        positionSpotlight(el);
    }
}

function startTutorial() {
    currentStep = 0;
    document.getElementById("tooltip-next").textContent = tutorialSteps.length > 1 ? "Next" : "Finish";
    showStep(currentStep);
}

function endTutorial() {
    spotlight.style.display = "none";
    tooltipCard.style.display = "none";
}

document.getElementById("tooltip-next").addEventListener("click", function () {
    currentStep++;
    if (currentStep < tutorialSteps.length - 1) {
        document.getElementById("tooltip-next").textContent = "Next";
    } else {
        document.getElementById("tooltip-next").textContent = "Finish";
    }
    showStep(currentStep);
});

document.getElementById("tooltip-skip").addEventListener("click", function () {
    endTutorial();
});

document.getElementById("start-challenge-btn").addEventListener("click", function () {
    tutorialCompleteModal.classList.remove("visible");
});

tutorialBtn.addEventListener("click", startTutorial);

window.addEventListener("resize", function () {
    if (spotlight.style.display === "block" && currentStep < tutorialSteps.length) {
        const step = tutorialSteps[currentStep];
        const el = document.getElementById(step.targetElementId);
        if (el) positionSpotlight(el);
    }
});

window.addEventListener("load", function () {
    startTutorial();
});
</script>
</body>
</html>
