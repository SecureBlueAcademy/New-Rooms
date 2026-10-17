<?php
// iac-security-practical.php
// Standalone static practical: Pipeline Security Gate
// No backend logic. PHP used only for file structure.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pipeline Security Gate</title>
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

.wrapper {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== HEADER ===== */
header.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 10px;
}

.title-block h1 {
    margin: 0 0 6px 0;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
}

.title-block p.subtitle {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.98rem;
}

#tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* ===== DESCRIPTION ===== */
.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin: 24px 0;
}
.description-section h2 {
    margin: 0 0 10px 0;
    font-size: 1.1rem;
    color: var(--accent-primary);
}
.description-section p {
    margin: 0 0 10px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.description-section p:last-child { margin-bottom: 0; }

/* ===== STATUS BAR ===== */
#pipeline-status {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--bg-surface);
    border: 1px solid var(--error);
    border-radius: 10px;
    padding: 14px 22px;
    margin: 24px 0;
    transition: border-color 0.4s ease, background 0.4s ease;
}
#pipeline-status.passed {
    border-color: var(--success);
}
#pipeline-status .status-label {
    font-family: "JetBrains Mono", monospace;
    font-weight: 600;
    font-size: 0.95rem;
    letter-spacing: 0.03em;
}
#pipeline-status.blocked .status-label { color: var(--error); }
#pipeline-status.passed .status-label { color: var(--success); }
#pipeline-status .status-count {
    font-family: "JetBrains Mono", monospace;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* ===== SCAN PANEL ===== */
#scan-panel {
    margin: 24px 0;
}
#scan-panel h2 {
    font-size: 1.15rem;
    color: var(--text-primary);
    margin-bottom: 14px;
}

.finding-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 16px;
    transition: border-color 0.3s ease;
}
.finding-card.resolved {
    border-color: var(--success);
}

.finding-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.finding-title {
    font-weight: 600;
    font-size: 1rem;
    color: var(--text-primary);
}
.severity-badge {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.03em;
}
.severity-critical {
    background: rgba(255, 92, 92, 0.12);
    color: var(--error);
    border: 1px solid rgba(255,92,92,0.4);
}
.severity-high {
    background: rgba(255, 211, 106, 0.12);
    color: var(--warning);
    border: 1px solid rgba(255,211,106,0.4);
}

.finding-desc {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 8px 0 14px 0;
}

.code-block {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    color: var(--text-secondary);
    overflow-x: auto;
    margin-bottom: 14px;
    white-space: pre;
}
.code-block .fixed-line {
    color: var(--success);
}

.fix-row {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

.apply-fix-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 9px 20px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.25s ease;
}
.apply-fix-btn:hover:not(:disabled) {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}
.apply-fix-btn:disabled {
    opacity: 0.5;
    cursor: default;
}

.resolved-tag {
    display: none;
    align-items: center;
    gap: 6px;
    color: var(--success);
    font-weight: 600;
    font-size: 0.88rem;
}
.finding-card.resolved .resolved-tag { display: inline-flex; }
.finding-card.resolved .apply-fix-btn { display: none; }

/* ===== FLAG AREA ===== */
#flag-area {
    margin-top: 30px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 26px;
    text-align: center;
    opacity: 0.4;
    pointer-events: none;
    transition: opacity 0.5s ease;
}
#flag-area.unlocked {
    opacity: 1;
    pointer-events: auto;
    border-color: var(--success);
    box-shadow: 0 0 24px rgba(61,255,154,0.15);
}
#flag-area h3 {
    margin: 0 0 10px 0;
    color: var(--text-primary);
    font-size: 1.05rem;
}
#flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 12px 20px;
    display: inline-block;
    letter-spacing: 0.02em;
}
#flag-area .flag-hint {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 12px;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
#spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.35s ease;
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
    z-index: 9999;
    box-shadow: 0 0 20px rgba(106,227,255,0.2);
    display: none;
}
#tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
#tutorial-skip {
    background: transparent;
    color: var(--text-muted);
}
#tutorial-next {
    background: var(--accent-primary);
    color: var(--bg-primary);
}

/* ===== MODAL ===== */
#tutorial-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
#tutorial-modal {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px 34px;
    max-width: 400px;
    text-align: center;
}
#tutorial-modal h3 {
    margin: 0 0 12px 0;
    color: var(--text-primary);
}
#tutorial-modal p {
    color: var(--text-secondary);
    font-size: 0.92rem;
    margin: 0 0 20px 0;
}
#tutorial-modal button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 640px) {
    header.page-header { flex-direction: column; }
    .finding-header { flex-direction: column; align-items: flex-start; }
}
</style>
</head>
<body>

<div class="wrapper">

    <!-- 1. TOP HEADER -->
    <header class="page-header">
        <div class="title-block">
            <h1>Pipeline Security Gate</h1>
            <p class="subtitle">A Terraform deployment is blocked. Resolve every scan finding to unlock it.</p>
        </div>
        <button id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </header>

    <!-- 2. DESCRIPTION SECTION -->
    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>This environment simulates a CI/CD pipeline gate running an automated IaC security scan against a pending Terraform plan, the same way tools like Checkov or tfsec would in a real pipeline.</p>
        <p>Your goal is to review each finding below and apply the correct fix. Once all three are resolved, the pipeline will unblock and your flag will be revealed.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div id="pipeline-status" class="blocked">
        <span class="status-label" id="status-label">BLOCKED</span>
        <span class="status-count" id="status-count">0 / 3 findings resolved</span>
    </div>

    <div id="scan-panel">
        <h2>Scan Results</h2>

        <div class="finding-card" id="finding-1" data-fixed="false">
            <div class="finding-header">
                <span class="finding-title">Security Group Open to the World</span>
                <span class="severity-badge severity-critical">Critical</span>
            </div>
            <p class="finding-desc">Inbound rule allows SSH access from any address on the internet. This exposes the instance to brute force and unauthorized access attempts from anywhere.</p>
            <div class="code-block" id="code-1">resource "aws_security_group_rule" "ssh_ingress" {
  type        = "ingress"
  from_port   = 22
  to_port     = 22
  protocol    = "tcp"
  cidr_blocks = ["0.0.0.0/0"]
}</div>
            <div class="fix-row">
                <button class="apply-fix-btn" onclick="applyFix(1)">Apply Fix</button>
                <span class="resolved-tag">✓ Resolved</span>
            </div>
        </div>

        <div class="finding-card" id="finding-2" data-fixed="false">
            <div class="finding-header">
                <span class="finding-title">S3 Bucket Without Encryption</span>
                <span class="severity-badge severity-high">High</span>
            </div>
            <p class="finding-desc">This storage bucket has no server side encryption configured. Data at rest is stored in plaintext, which violates most compliance baselines.</p>
            <div class="code-block" id="code-2">resource "aws_s3_bucket" "data_store" {
  bucket = "company-data-store"
  # no encryption configuration present
}</div>
            <div class="fix-row">
                <button class="apply-fix-btn" onclick="applyFix(2)">Apply Fix</button>
                <span class="resolved-tag">✓ Resolved</span>
            </div>
        </div>

        <div class="finding-card" id="finding-3" data-fixed="false">
            <div class="finding-header">
                <span class="finding-title">Publicly Accessible Database</span>
                <span class="severity-badge severity-critical">Critical</span>
            </div>
            <p class="finding-desc">This RDS instance is configured as publicly accessible, exposing the database directly to the internet instead of keeping it inside a private network.</p>
            <div class="code-block" id="code-3">resource "aws_db_instance" "primary" {
  engine                 = "postgres"
  publicly_accessible    = true
}</div>
            <div class="fix-row">
                <button class="apply-fix-btn" onclick="applyFix(3)">Apply Fix</button>
                <span class="resolved-tag">✓ Resolved</span>
            </div>
        </div>
    </div>

    <!-- 4. FEEDBACK HAPPENS VIA STATUS BAR ABOVE -->

    <!-- 5. FLAG REVEAL AREA -->
    <div id="flag-area">
        <h3>Pipeline Result</h3>
        <div id="flag-value">Resolve all findings to reveal the flag</div>
        <p class="flag-hint">This flag proves the pipeline gate has passed.</p>
    </div>

</div>

<!-- SPOTLIGHT ELEMENTS -->
<div id="spotlight"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tutorial-skip" onclick="skipTutorial()">Skip Tutorial</button>
        <button id="tutorial-next" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<!-- COMPLETION MODAL -->
<div id="tutorial-modal-overlay">
    <div id="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Review each finding and apply the fixes to unlock the pipeline.</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
let resolvedCount = 0;
const totalFindings = 3;

function applyFix(id) {
    const card = document.getElementById('finding-' + id);
    if (card.dataset.fixed === "true") return;

    card.dataset.fixed = "true";
    card.classList.add('resolved');

    const codeBlock = document.getElementById('code-' + id);
    if (id === 1) {
        codeBlock.innerHTML = 'resource "aws_security_group_rule" "ssh_ingress" {\n  type        = "ingress"\n  from_port   = 22\n  to_port     = 22\n  protocol    = "tcp"\n  <span class="fixed-line">cidr_blocks = ["10.0.0.0/16"]</span>\n}';
    } else if (id === 2) {
        codeBlock.innerHTML = 'resource "aws_s3_bucket" "data_store" {\n  bucket = "company-data-store"\n}\n\n<span class="fixed-line">resource "aws_s3_bucket_server_side_encryption_configuration" "data_store" {\n  rule {\n    sse_algorithm = "AES256"\n  }\n}</span>';
    } else if (id === 3) {
        codeBlock.innerHTML = 'resource "aws_db_instance" "primary" {\n  engine                 = "postgres"\n  <span class="fixed-line">publicly_accessible    = false</span>\n}';
    }

    resolvedCount++;
    updateStatus();
}

function updateStatus() {
    const statusBar = document.getElementById('pipeline-status');
    const statusLabel = document.getElementById('status-label');
    const statusCount = document.getElementById('status-count');

    statusCount.textContent = resolvedCount + ' / ' + totalFindings + ' findings resolved';

    if (resolvedCount >= totalFindings) {
        statusBar.classList.remove('blocked');
        statusBar.classList.add('passed');
        statusLabel.textContent = 'PASSED';
        unlockFlag();
    }
}

function unlockFlag() {
    const flagArea = document.getElementById('flag-area');
    const flagValue = document.getElementById('flag-value');
    flagArea.classList.add('unlocked');
    flagValue.textContent = 'CBX{pipeline_secured}';
}

/* ===== SPOTLIGHT TUTORIAL SYSTEM ===== */
const tutorialSteps = [
    { targetElementId: 'scan-panel', tooltipText: 'This is your scan panel. Real tools like Checkov and tfsec generate findings like these before any Terraform plan reaches production.' },
    { targetElementId: 'finding-1', tooltipText: 'Each finding shows the exact resource block that violates a security rule, along with its severity.' },
    { targetElementId: 'finding-2', tooltipText: 'Not every misconfiguration is a network issue. Missing encryption is just as critical.' },
    { targetElementId: 'finding-3', tooltipText: 'Public database access is one of the most common and dangerous cloud misconfigurations.' },
    { targetElementId: 'finding-1', tooltipText: 'Click Apply Fix on each card to remediate the finding. Watch how the resource definition changes.' },
    { targetElementId: 'pipeline-status', tooltipText: 'This bar reflects the pipeline gate. It stays blocked until every finding is resolved, exactly like a real CI/CD policy gate.' },
    { targetElementId: 'flag-area', tooltipText: 'Once the gate passes, your flag appears here.' },
];

let currentStep = 0;
let tutorialActive = false;

function startTutorial() {
    currentStep = 0;
    tutorialActive = true;
    showTutorialStep();
}

function showTutorialStep() {
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        return;
    }

    const step = tutorialSteps[currentStep];
    const target = document.getElementById(step.targetElementId);
    if (!target) {
        currentStep++;
        showTutorialStep();
        return;
    }

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => positionSpotlight(target, step), 300);
    } else {
        positionSpotlight(target, step);
    }
}

function positionSpotlight(target, step) {
    const rect = target.getBoundingClientRect();
    const padding = 8;

    const spotlight = document.getElementById('spotlight');
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - padding) + 'px';
    spotlight.style.left = (rect.left - padding) + 'px';
    spotlight.style.width = (rect.width + padding * 2) + 'px';
    spotlight.style.height = (rect.height + padding * 2) + 'px';

    const tooltip = document.getElementById('tutorial-tooltip');
    document.getElementById('tooltip-text').textContent = step.tooltipText;
    tooltip.style.display = 'block';

    let top = rect.bottom + 16;
    let left = rect.left;

    const tooltipWidth = 300;
    const tooltipHeightEstimate = 100;

    if (top + tooltipHeightEstimate > window.innerHeight) {
        top = rect.top - tooltipHeightEstimate - 16;
    }
    if (left + tooltipWidth > window.innerWidth) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (left < 10) left = 10;
    if (top < 10) top = 10;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';

    const nextBtn = document.getElementById('tutorial-next');
    nextBtn.textContent = (currentStep === tutorialSteps.length - 1) ? 'Finish' : 'Next';
}

function nextTutorialStep() {
    currentStep++;
    showTutorialStep();
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    tutorialActive = false;
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tutorial-tooltip').style.display = 'none';
    document.getElementById('tutorial-modal-overlay').style.display = 'flex';
}

function closeTutorialModal() {
    document.getElementById('tutorial-modal-overlay').style.display = 'none';
}

window.addEventListener('resize', function() {
    if (tutorialActive && currentStep < tutorialSteps.length) {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetElementId);
        if (target) positionSpotlight(target, step);
    }
});

window.addEventListener('load', function() {
    startTutorial();
});
</script>

</body>
</html>
