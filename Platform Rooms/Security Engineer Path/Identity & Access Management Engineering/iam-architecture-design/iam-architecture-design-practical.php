<?php
// ============================================================
// iam-architecture-design-practical.php
// Standalone static practical: Meridian Financial Access Engine
// No backend logic, no database, no sessions. Pure HTML/CSS/JS.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meridian Financial | Access Request Engine</title>
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
    line-height: 1.55;
}

.wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px 20px 80px 20px;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-default);
    margin-bottom: 24px;
}
.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
    font-weight: 700;
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== DESCRIPTION ===== */
.description {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 28px;
}
.description h2 {
    margin: 0 0 8px 0;
    font-size: 1.05rem;
}
.description p {
    margin: 0 0 10px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
.description p:last-child { margin-bottom: 0; }

/* ===== PROGRESS TRACKER ===== */
.progress-tracker {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
}
.progress-slot {
    flex: 1;
    height: 8px;
    border-radius: 4px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    transition: background 0.2s ease, border-color 0.2s ease;
}
.progress-slot.done {
    background: var(--success);
    border-color: var(--success);
}

/* ===== MAIN ENVIRONMENT ===== */
.environment {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}
.queue-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.queue-label h3 {
    margin: 0;
    font-size: 1rem;
}
.queue-count {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.request-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
}
.request-detail-card .request-row {
    display: flex;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 0.92rem;
}
.request-detail-card .request-row:last-child { margin-bottom: 0; }
.request-detail-card .label {
    color: var(--text-muted);
    min-width: 110px;
    flex-shrink: 0;
}
.request-detail-card .value {
    color: var(--text-primary);
    font-weight: 500;
}
.request-detail-card .value.mono {
    font-family: "JetBrains Mono", monospace;
    color: var(--accent-primary);
}

.section-divider {
    border: none;
    border-top: 1px solid var(--border-default);
    margin: 20px 0;
}

.model-selector {
    display: flex;
    gap: 10px;
    margin-bottom: 18px;
}
.model-btn {
    flex: 1;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 12px 10px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.15s ease;
}
.model-btn:hover { border-color: var(--accent-primary); color: var(--text-primary); }
.model-btn.selected {
    background: rgba(106,227,255,0.1);
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

.config-panel {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 18px;
    min-height: 40px;
}
.config-option {
    text-align: left;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 12px 14px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.15s ease;
}
.config-option:hover { border-color: var(--accent-secondary); color: var(--text-primary); }
.config-option.selected {
    background: rgba(139,123,255,0.12);
    border-color: var(--accent-secondary);
    color: var(--text-primary);
    box-shadow: 0 0 12px rgba(139,123,255,0.25);
}
.config-placeholder {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-style: italic;
    padding: 8px 0;
}

.resolve-button {
    width: 100%;
    background: linear-gradient(135deg, #16203f, #1d2a52);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 13px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    font-size: 0.95rem;
    letter-spacing: 0.02em;
    cursor: pointer;
    transition: box-shadow 0.2s ease, transform 0.15s ease;
}
.resolve-button:hover:not(:disabled) {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}
.resolve-button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ===== FEEDBACK AREA ===== */
.feedback-area {
    min-height: 54px;
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 0.9rem;
    margin-bottom: 24px;
    display: none;
    border: 1px solid var(--border-default);
}
.feedback-area.show { display: block; }
.feedback-area.correct {
    background: rgba(61,255,154,0.08);
    border-color: var(--success);
    color: var(--success);
}
.feedback-area.incorrect {
    background: rgba(255,92,92,0.08);
    border-color: var(--error);
    color: var(--error);
}
.feedback-area .hint {
    display: block;
    color: var(--text-secondary);
    margin-top: 6px;
    font-size: 0.85rem;
}

/* ===== FLAG PANEL ===== */
.flag-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    text-align: center;
}
.flag-panel .status-line {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 0.95rem;
}
.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--text-muted);
}
.status-dot.online { background: var(--success); box-shadow: 0 0 10px var(--success); }
.flag-panel .status-sub {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 14px;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--accent-primary);
    background: var(--bg-primary);
    border: 1px solid var(--accent-primary);
    border-radius: 8px;
    padding: 12px 18px;
    display: none;
    user-select: all;
}
.flag-value.revealed { display: inline-block; }

/* ===== TUTORIAL ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9000;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9001;
    font-size: 0.88rem;
    color: var(--text-primary);
    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}
.tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
.tooltip-card button {
    font-family: inherit;
    border: none;
    border-radius: 6px;
    padding: 7px 14px;
    font-size: 0.82rem;
    cursor: pointer;
    font-weight: 600;
}
.tt-skip { background: transparent; color: var(--text-muted); }
.tt-next { background: var(--accent-primary); color: #0b0f1a; }

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9500;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin: 0 0 10px 0; }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; margin: 0 0 18px 0; }
.modal-box button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 600px) {
    .model-selector { flex-direction: column; }
    .header { flex-direction: column; }
}
</style>
</head>
<body>
<div class="wrap">

    <!-- ===== 1. HEADER ===== -->
    <div class="header">
        <div>
            <h1>Meridian Financial Access Engine</h1>
            <p class="subtitle">Access request queue, resolve every pending decision to bring the policy engine online.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-restart-btn">View Tutorial</button>
    </div>

    <!-- ===== 2. DESCRIPTION ===== -->
    <div class="description">
        <h2>Mission Briefing</h2>
        <p>This console represents Meridian Financial's access request queue. Five requests are waiting, each one from a real employee or contractor asking for access to a specific resource.</p>
        <p>For every request, choose the access control model that fits the scenario, configure the correct rule, and submit your decision. Resolve all five correctly to bring the policy engine online.</p>
    </div>

    <!-- Progress tracker -->
    <div class="progress-tracker" id="progress-tracker">
        <div class="progress-slot"></div>
        <div class="progress-slot"></div>
        <div class="progress-slot"></div>
        <div class="progress-slot"></div>
        <div class="progress-slot"></div>
    </div>

    <!-- ===== 3. MAIN INTERACTIVE ENVIRONMENT ===== -->
    <div class="environment" id="request-queue">
        <div class="queue-label">
            <h3>Access Request Queue</h3>
            <span class="queue-count" id="queue-count">Request 1 of 5</span>
        </div>

        <div class="request-card">
            <div class="request-detail-card" id="request-detail-card">
                <!-- populated by JS -->
            </div>

            <hr class="section-divider">

            <div class="model-selector" id="model-selector">
                <button class="model-btn" data-model="RBAC">RBAC</button>
                <button class="model-btn" data-model="ABAC">ABAC</button>
                <button class="model-btn" data-model="PBAC">PBAC</button>
            </div>

            <div class="config-panel" id="config-panel">
                <div class="config-placeholder">Select a model above to see configuration options.</div>
            </div>

            <button class="resolve-button" id="resolve-button" disabled>Resolve Request</button>
        </div>
    </div>

    <!-- ===== 4. FEEDBACK / STATUS AREA ===== -->
    <div class="feedback-area" id="feedback-area"></div>

    <!-- ===== 5. FLAG REVEAL AREA ===== -->
    <div class="flag-panel" id="flag-panel">
        <div class="status-line">
            <span class="status-dot" id="status-dot"></span>
            <span id="status-text">Policy Engine Status: Offline</span>
        </div>
        <p class="status-sub" id="status-sub">Resolve all 5 requests correctly to bring the engine online.</p>
        <div class="flag-value" id="flag-value">CBX{access_engine_calibrated}</div>
    </div>

</div>

<!-- Tutorial overlay elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;"></div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Resolve every access request to bring the policy engine online.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// DATA: Access requests
// ============================================================
const requests = [
    {
        requester: "Sarah Chen",
        role: "Sales Rep",
        resource: "Sales Dashboards",
        context: "No special conditions attached.",
        correctModel: "RBAC",
        correctConfig: "rbac-sales-rep",
        options: {
            RBAC: [
                { id: "rbac-sales-rep", label: "Assign role: Sales Rep" },
                { id: "rbac-manager", label: "Assign role: Manager" },
                { id: "rbac-auditor", label: "Assign role: Auditor" },
                { id: "deny", label: "Deny access, insufficient justification" }
            ],
            ABAC: [
                { id: "abac-time-loc", label: "Set condition: Time = 9am-5pm AND Location = Corporate Network" },
                { id: "abac-relationship", label: "Set condition: Relationship = Direct Report of Requester" },
                { id: "abac-department", label: "Set condition: Department = Finance" },
                { id: "deny", label: "Deny access, insufficient justification" }
            ],
            PBAC: [
                { id: "pbac-sox", label: "Apply Policy: SOX Annual Audit Access Policy" },
                { id: "pbac-gdpr", label: "Apply Policy: General Data Protection Policy" },
                { id: "pbac-vendor", label: "Apply Policy: Vendor Access Policy" },
                { id: "deny", label: "Deny access, insufficient justification" }
            ]
        },
        hint: "This is a standard, stable job function with no special conditions. Think about the model built for straightforward job-based access."
    },
    {
        requester: "Priya Nair",
        role: "Contractor",
        resource: "Customer CRM Records",
        context: "Requested access limited to 9am-5pm, corporate network only.",
        correctModel: "ABAC",
        correctConfig: "abac-time-loc",
        options: null, // reuse same option sets as request 1
        hint: "The request depends on time of day and network location. Neither of those is a fixed job role, they are conditions that change moment to moment."
    },
    {
        requester: "David Osei",
        role: "Auditor",
        resource: "Financial Audit Reports",
        context: "Access restricted to the annual audit window under company compliance policy.",
        correctModel: "PBAC",
        correctConfig: "pbac-sox",
        options: null,
        hint: "This access is governed by a formal, organization wide compliance requirement rather than a personal attribute or a simple role."
    },
    {
        requester: "Marcus Webb",
        role: "Manager",
        resource: "Payroll System",
        context: "Access should be scoped only to Marcus's direct reports.",
        correctModel: "ABAC",
        correctConfig: "abac-relationship",
        options: null,
        hint: "The scope depends on a relationship between the requester and specific employee records, not a static job title."
    },
    {
        requester: "Sarah Chen",
        role: "Sales Rep",
        resource: "Payroll System (Elevated Access)",
        context: "No policy or attribute in the system supports this request.",
        correctModel: null, // any model is acceptable as long as deny is selected
        correctConfig: "deny",
        options: null,
        hint: "No configuration should manufacture access that is not justified. Least privilege overrides every model when there is no legitimate basis for access."
    }
];

const optionSets = {
    RBAC: [
        { id: "rbac-sales-rep", label: "Assign role: Sales Rep" },
        { id: "rbac-manager", label: "Assign role: Manager" },
        { id: "rbac-auditor", label: "Assign role: Auditor" },
        { id: "deny", label: "Deny access, insufficient justification" }
    ],
    ABAC: [
        { id: "abac-time-loc", label: "Set condition: Time = 9am-5pm AND Location = Corporate Network" },
        { id: "abac-relationship", label: "Set condition: Relationship = Direct Report of Requester" },
        { id: "abac-department", label: "Set condition: Department = Finance" },
        { id: "deny", label: "Deny access, insufficient justification" }
    ],
    PBAC: [
        { id: "pbac-sox", label: "Apply Policy: SOX Annual Audit Access Policy" },
        { id: "pbac-gdpr", label: "Apply Policy: General Data Protection Policy" },
        { id: "pbac-vendor", label: "Apply Policy: Vendor Access Policy" },
        { id: "deny", label: "Deny access, insufficient justification" }
    ]
};

let currentIndex = 0;
let selectedModel = null;
let selectedConfig = null;
let resolvedCount = 0;

const detailCard = document.getElementById("request-detail-card");
const queueCount = document.getElementById("queue-count");
const modelSelector = document.getElementById("model-selector");
const configPanel = document.getElementById("config-panel");
const resolveBtn = document.getElementById("resolve-button");
const feedbackArea = document.getElementById("feedback-area");
const progressTracker = document.getElementById("progress-tracker");
const statusDot = document.getElementById("status-dot");
const statusText = document.getElementById("status-text");
const statusSub = document.getElementById("status-sub");
const flagValue = document.getElementById("flag-value");

function renderRequest() {
    const req = requests[currentIndex];
    queueCount.textContent = "Request " + (currentIndex + 1) + " of " + requests.length;

    detailCard.innerHTML =
        '<div class="request-row"><span class="label">Requester</span><span class="value">' + req.requester + '</span></div>' +
        '<div class="request-row"><span class="label">Role</span><span class="value">' + req.role + '</span></div>' +
        '<div class="request-row"><span class="label">Resource</span><span class="value mono">' + req.resource + '</span></div>' +
        '<div class="request-row"><span class="label">Context</span><span class="value">' + req.context + '</span></div>';

    selectedModel = null;
    selectedConfig = null;
    feedbackArea.className = "feedback-area";
    feedbackArea.innerHTML = "";

    document.querySelectorAll(".model-btn").forEach(btn => btn.classList.remove("selected"));
    configPanel.innerHTML = '<div class="config-placeholder">Select a model above to see configuration options.</div>';
    resolveBtn.disabled = true;
}

function renderConfigOptions(model) {
    const opts = optionSets[model];
    configPanel.innerHTML = "";
    opts.forEach(opt => {
        const btn = document.createElement("button");
        btn.className = "config-option";
        btn.textContent = opt.label;
        btn.dataset.optionId = opt.id;
        btn.addEventListener("click", () => {
            document.querySelectorAll(".config-option").forEach(b => b.classList.remove("selected"));
            btn.classList.add("selected");
            selectedConfig = opt.id;
            resolveBtn.disabled = false;
        });
        configPanel.appendChild(btn);
    });
}

modelSelector.addEventListener("click", (e) => {
    const btn = e.target.closest(".model-btn");
    if (!btn) return;
    document.querySelectorAll(".model-btn").forEach(b => b.classList.remove("selected"));
    btn.classList.add("selected");
    selectedModel = btn.dataset.model;
    selectedConfig = null;
    resolveBtn.disabled = true;
    renderConfigOptions(selectedModel);
});

resolveBtn.addEventListener("click", () => {
    const req = requests[currentIndex];
    let correct = false;

    if (selectedConfig === "deny") {
        correct = (req.correctConfig === "deny");
    } else {
        correct = (selectedModel === req.correctModel) && (selectedConfig === req.correctConfig);
    }

    if (correct) {
        feedbackArea.className = "feedback-area show correct";
        feedbackArea.innerHTML = "Correct. This request has been resolved appropriately.";

        if (!progressTracker.children[currentIndex].classList.contains("done")) {
            progressTracker.children[currentIndex].classList.add("done");
            resolvedCount++;
        }

        setTimeout(() => {
            if (currentIndex < requests.length - 1) {
                currentIndex++;
                renderRequest();
            }
            checkCompletion();
        }, 900);
    } else {
        feedbackArea.className = "feedback-area show incorrect";
        feedbackArea.innerHTML = "That configuration does not fit this request.<span class='hint'>Hint: " + req.hint + "</span>";
    }
});

function checkCompletion() {
    if (resolvedCount >= requests.length) {
        statusDot.classList.add("online");
        statusText.textContent = "Policy Engine Status: Online";
        statusSub.textContent = "All access requests resolved correctly. Flag unlocked below.";
        flagValue.classList.add("revealed");
    }
}

renderRequest();

// ============================================================
// TUTORIAL SYSTEM (spotlight based)
// ============================================================
const tutorialSteps = [
    { targetId: "request-queue", text: "This is your Access Request Queue. Each card is a real access request waiting for a decision, just like tickets in an enterprise IAM system." },
    { targetId: "request-detail-card", text: "This shows who is asking, their role, the resource they want, and any context like time or location. Read it carefully before deciding." },
    { targetId: "model-selector", text: "Choose the access control model that fits this request: RBAC for role based access, ABAC for attribute based conditions, or PBAC for formal organizational policy." },
    { targetId: "config-panel", text: "Configure the actual rule here. The options change depending on which model you picked." },
    { targetId: "resolve-button", text: "Submit your decision. You will get instant feedback if something does not fit." },
    { targetId: "progress-tracker", text: "Track how many requests you have resolved correctly. All 5 must be correct to complete the challenge." },
    { targetId: "flag-panel", text: "Once every request is resolved correctly, your flag appears right here." }
];

let tutorialStep = 0;
const spotlight = document.getElementById("spotlight");
const tooltipCard = document.getElementById("tooltip-card");
const tutorialModal = document.getElementById("tutorial-complete-modal");

function positionTutorial() {
    const step = tutorialSteps[tutorialStep];
    const el = document.getElementById(step.targetId);
    if (!el) return;

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!isVisible) {
        el.scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => placeSpotlight(el), 300);
    } else {
        placeSpotlight(el);
    }
}

function placeSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;

    spotlight.style.display = "block";
    spotlight.style.top = (rect.top - pad) + "px";
    spotlight.style.left = (rect.left - pad) + "px";
    spotlight.style.width = (rect.width + pad * 2) + "px";
    spotlight.style.height = (rect.height + pad * 2) + "px";

    tooltipCard.style.display = "block";
    tooltipCard.innerHTML =
        '<div>' + tutorialSteps[tutorialStep].text + '</div>' +
        '<div class="tt-actions">' +
        '<button class="tt-skip" id="tt-skip-btn">Skip Tutorial</button>' +
        '<button class="tt-next" id="tt-next-btn">' + (tutorialStep === tutorialSteps.length - 1 ? "Finish" : "Next") + '</button>' +
        '</div>';

    // Determine placement: prefer below, fallback above, then right, then left
    const tooltipWidth = 300;
    const tooltipHeightEstimate = 130;
    let top = rect.bottom + 14;
    let left = rect.left;

    if (top + tooltipHeightEstimate > window.innerHeight) {
        top = rect.top - tooltipHeightEstimate - 14;
    }
    if (top < 0) {
        top = Math.max(10, rect.top);
        left = rect.right + 14;
        if (left + tooltipWidth > window.innerWidth) {
            left = rect.left - tooltipWidth - 14;
        }
    }
    if (left + tooltipWidth > window.innerWidth) {
        left = window.innerWidth - tooltipWidth - 14;
    }
    if (left < 10) left = 10;

    tooltipCard.style.top = top + "px";
    tooltipCard.style.left = left + "px";

    document.getElementById("tt-skip-btn").addEventListener("click", endTutorial);
    document.getElementById("tt-next-btn").addEventListener("click", nextTutorialStep);
}

function nextTutorialStep() {
    tutorialStep++;
    if (tutorialStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        positionTutorial();
    }
}

function endTutorial(completed) {
    spotlight.style.display = "none";
    tooltipCard.style.display = "none";
    if (completed) {
        tutorialModal.classList.add("show");
    }
}

function startTutorial() {
    tutorialStep = 0;
    positionTutorial();
}

document.getElementById("tutorial-restart-btn").addEventListener("click", startTutorial);
document.getElementById("start-challenge-btn").addEventListener("click", () => {
    tutorialModal.classList.remove("show");
});

window.addEventListener("resize", () => {
    if (spotlight.style.display === "block") {
        positionTutorial();
    }
});

// Auto-start tutorial on first load
window.addEventListener("load", () => {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
