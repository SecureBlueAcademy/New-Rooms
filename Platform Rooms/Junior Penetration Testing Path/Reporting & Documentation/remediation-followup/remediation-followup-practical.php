<?php
// remediation-followup-practical.php
// Standalone static practical: Remediation Ticket Simulator
// No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Remediation Ticket Simulator</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    padding: 24px;
}

.wrapper {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
}

/* HEADER */
header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
}

h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}

.subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
    max-width: 560px;
}

#tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* DESCRIPTION */
.description-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.description-panel strong { color: var(--text-primary); }

/* MAIN ENVIRONMENT */
#finding-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 18px;
}

#progress-tracker {
    display: inline-block;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 20px;
    padding: 6px 16px;
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: 'JetBrains Mono', monospace;
    margin-bottom: 14px;
}

.finding-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 8px 0;
}

.severity-badge {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 14px;
    font-family: 'JetBrains Mono', monospace;
}
.sev-critical { background: rgba(255,92,92,0.15); color: var(--error); border: 1px solid var(--error); }
.sev-high { background: rgba(255,211,106,0.15); color: var(--warning); border: 1px solid var(--warning); }
.sev-medium { background: rgba(106,227,255,0.12); color: var(--accent-primary); border: 1px solid var(--accent-primary); }
.sev-low { background: rgba(139,123,255,0.15); color: var(--accent-secondary); border: 1px solid var(--accent-secondary); }

.finding-context {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 20px;
    padding: 12px 14px;
    background: var(--bg-secondary);
    border-left: 3px solid var(--accent-primary);
    border-radius: 4px;
}

.select-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}

.select-item label {
    display: block;
    font-size: 0.78rem;
    color: var(--text-muted);
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

select {
    width: 100%;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 10px 12px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
}
select:focus {
    outline: none;
    border-color: var(--accent-primary);
}

#submit-finding-btn {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    border: none;
    color: #04121a;
    font-weight: 700;
    padding: 12px 26px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: transform 0.15s ease;
}
#submit-finding-btn:hover { transform: translateY(-1px); }
#submit-finding-btn:disabled { opacity: 0.5; cursor: not-allowed; }

#next-finding-btn {
    background: transparent;
    border: 1px solid var(--success);
    color: var(--success);
    font-weight: 600;
    padding: 12px 26px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    margin-left: 10px;
    display: none;
}

/* FEEDBACK */
#feedback-area {
    min-height: 24px;
    margin-top: 16px;
    font-size: 0.9rem;
    padding: 12px 14px;
    border-radius: 8px;
    display: none;
}
.feedback-correct {
    display: block !important;
    background: rgba(61,255,154,0.1);
    border: 1px solid var(--success);
    color: var(--success);
}
.feedback-incorrect {
    display: block !important;
    background: rgba(255,92,92,0.1);
    border: 1px solid var(--error);
    color: var(--error);
}

/* FLAG REVEAL */
#flag-reveal {
    display: none;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 26px;
    text-align: center;
    margin-top: 20px;
    box-shadow: 0 0 30px rgba(61,255,154,0.15);
}
#flag-reveal h2 {
    color: var(--success);
    margin: 0 0 10px 0;
}
#flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.2rem;
    background: var(--bg-secondary);
    padding: 12px 20px;
    border-radius: 8px;
    color: var(--accent-primary);
    display: inline-block;
    margin-top: 10px;
    border: 1px solid var(--border-default);
}

/* SPOTLIGHT TUTORIAL */
.spotlight-box {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 9998;
    transition: none;
}

.tooltip-card {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    border-radius: 6px;
    padding: 8px 14px;
    cursor: pointer;
    border: none;
}
#tt-next {
    background: var(--accent-primary);
    color: #04121a;
    font-weight: 700;
}
#tt-skip {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default) !important;
}

/* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 {
    color: var(--accent-primary);
    margin-top: 0;
}
.modal-box button {
    background: var(--accent-primary);
    color: #04121a;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 10px;
}

@media (max-width: 600px) {
    header { flex-direction: column; }
    .select-group { grid-template-columns: 1fr; }
}
</style>
</head>
<body>
<div class="wrapper">

    <header>
        <div>
            <h1>Remediation Ticket Simulator</h1>
            <p class="subtitle">You are reviewing five vulnerability findings that need to be classified and scheduled before the report ships.</p>
        </div>
        <button id="tutorial-btn" onclick="startTutorial()">View Tutorial</button>
    </header>

    <div class="description-panel">
        This environment represents a remediation queue used by a security team to finalize findings before a report is delivered to a client. For each finding, choose the correct <strong>classification</strong>, <strong>remediation window</strong>, and <strong>verification method</strong>. Submit each finding to get immediate feedback. Classify all five findings correctly to complete the exercise and reveal the flag.
    </div>

    <div id="progress-tracker">Finding 1 of 5</div>

    <div id="finding-card">
        <div id="severity-badge" class="severity-badge sev-critical">Critical</div>
        <h3 class="finding-title" id="finding-title">Loading finding...</h3>
        <div class="finding-context" id="finding-context"></div>

        <div class="select-group">
            <div class="select-item">
                <label for="classification-select">Classification</label>
                <select id="classification-select">
                    <option value="">Select...</option>
                    <option value="fix">Fix</option>
                    <option value="workaround">Workaround</option>
                    <option value="accepted_risk">Accepted Risk</option>
                </select>
            </div>
            <div class="select-item">
                <label for="window-select">Remediation Window</label>
                <select id="window-select">
                    <option value="">Select...</option>
                    <option value="7">7 days</option>
                    <option value="30">30 days</option>
                    <option value="90">90 days</option>
                    <option value="180">180 days</option>
                </select>
            </div>
            <div class="select-item">
                <label for="verification-select">Verification Method</label>
                <select id="verification-select">
                    <option value="">Select...</option>
                    <option value="retest">Re-test</option>
                    <option value="evidence">Evidence Review</option>
                    <option value="automated">Automated Scan</option>
                </select>
            </div>
        </div>

        <button id="submit-finding-btn" onclick="submitFinding()">Submit Classification</button>
        <button id="next-finding-btn" onclick="nextFinding()">Next Finding →</button>

        <div id="feedback-area"></div>
    </div>

    <div id="flag-reveal">
        <h2>Remediation Report Approved</h2>
        <p>All five findings were classified correctly. The remediation cycle is complete.</p>
        <div id="flag-value">CBX{remediation_verified}</div>
    </div>

</div>

<!-- Tutorial elements -->
<div class="spotlight-box" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip" style="display:none;">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tt-skip" onclick="skipTutorial()">Skip Tutorial</button>
        <button id="tt-next" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<div class="modal-overlay" id="completion-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button onclick="closeCompletionModal()">Start Challenge</button>
    </div>
</div>

<script>
const findings = [
    {
        title: "SQL injection in customer login form",
        severity: "Critical",
        sevClass: "sev-critical",
        context: "The endpoint is actively exploitable. No compensating controls are in place.",
        correctClass: "fix",
        correctWindow: "7",
        correctVerification: "retest",
        explanation: "An actively exploitable critical finding with no compensating controls requires a fix, a 7 day window, and re-testing to confirm it is resolved."
    },
    {
        title: "Missing rate limiting on password reset endpoint",
        severity: "Medium",
        sevClass: "sev-medium",
        context: "Engineering has confirmed they have capacity to patch this within the current sprint cycle.",
        correctClass: "fix",
        correctWindow: "90",
        correctVerification: "retest",
        explanation: "This is a medium severity finding being fully resolved, so it follows the standard medium window and is confirmed through re-testing."
    },
    {
        title: "Outdated TLS version enabled on legacy load balancer",
        severity: "Medium",
        sevClass: "sev-medium",
        context: "The business cannot upgrade due to a legacy client dependency. Network segmentation and monitoring are already in place.",
        correctClass: "accepted_risk",
        correctWindow: "90",
        correctVerification: "evidence",
        explanation: "With compensating controls already in place and no plan to change the configuration, this is an accepted risk, verified through evidence review rather than re-testing."
    },
    {
        title: "Default admin credentials on internal test server",
        severity: "High",
        sevClass: "sev-high",
        context: "The account has been disabled as a stopgap while a full credential overhaul is scheduled for next quarter.",
        correctClass: "workaround",
        correctWindow: "30",
        correctVerification: "retest",
        explanation: "Disabling the account is a temporary measure with a planned follow up, which makes this a workaround rather than a permanent fix."
    },
    {
        title: "Missing security headers on public marketing site",
        severity: "Low",
        sevClass: "sev-low",
        context: "The site has low business impact and holds no sensitive data.",
        correctClass: "fix",
        correctWindow: "180",
        correctVerification: "automated",
        explanation: "This low severity finding is being fully resolved on the standard low severity window and can be confirmed with an automated scan."
    }
];

let currentIndex = 0;
let correctCount = 0;

function renderFinding() {
    const f = findings[currentIndex];
    document.getElementById('progress-tracker').textContent = `Finding ${currentIndex + 1} of ${findings.length}`;
    document.getElementById('finding-title').textContent = f.title;
    document.getElementById('finding-context').textContent = f.context;
    const badge = document.getElementById('severity-badge');
    badge.textContent = f.severity;
    badge.className = 'severity-badge ' + f.sevClass;

    document.getElementById('classification-select').value = '';
    document.getElementById('window-select').value = '';
    document.getElementById('verification-select').value = '';

    const feedback = document.getElementById('feedback-area');
    feedback.className = '';
    feedback.style.display = 'none';
    feedback.textContent = '';

    document.getElementById('submit-finding-btn').disabled = false;
    document.getElementById('submit-finding-btn').style.display = 'inline-block';
    document.getElementById('next-finding-btn').style.display = 'none';
}

function submitFinding() {
    const f = findings[currentIndex];
    const cls = document.getElementById('classification-select').value;
    const win = document.getElementById('window-select').value;
    const ver = document.getElementById('verification-select').value;

    if (!cls || !win || !ver) {
        const feedback = document.getElementById('feedback-area');
        feedback.className = 'feedback-incorrect';
        feedback.textContent = 'Please select a value for all three fields before submitting.';
        return;
    }

    const feedback = document.getElementById('feedback-area');
    if (cls === f.correctClass && win === f.correctWindow && ver === f.correctVerification) {
        feedback.className = 'feedback-correct';
        feedback.textContent = 'Correct. ' + f.explanation;
        document.getElementById('submit-finding-btn').style.display = 'none';
        document.getElementById('next-finding-btn').style.display = 'inline-block';
        correctCount++;
    } else {
        feedback.className = 'feedback-incorrect';
        feedback.textContent = 'Not quite. Review the context above and try again.';
    }
}

function nextFinding() {
    currentIndex++;
    if (currentIndex >= findings.length) {
        document.getElementById('finding-card').style.display = 'none';
        document.getElementById('progress-tracker').style.display = 'none';
        document.getElementById('flag-reveal').style.display = 'block';
    } else {
        renderFinding();
    }
}

renderFinding();

// ================= SPOTLIGHT TUTORIAL SYSTEM =================
const tutorialSteps = [
    { id: 'finding-card', text: 'This is a vulnerability finding, just like one you would receive from a pentest report. Read the description and context carefully before deciding how to handle it.' },
    { id: 'classification-select', text: 'Choose how this finding will be handled. A Fix removes the vulnerability entirely. A Workaround reduces risk temporarily without fully resolving it. An Accepted Risk means the business has formally decided not to remediate.' },
    { id: 'window-select', text: 'Set the remediation window. This should reflect the severity of the finding and any business constraints mentioned in the context.' },
    { id: 'verification-select', text: 'Choose how this fix will be verified once complete. Re-testing confirms the vulnerability is gone. Evidence review is used when a fix cannot be directly re-tested, such as an accepted risk.' },
    { id: 'submit-finding-btn', text: 'Submit your classification. You will get immediate feedback and can adjust if needed.' },
    { id: 'progress-tracker', text: 'This tracks how many findings you have correctly classified. Complete all 5 to finish the exercise.' }
];

let tutorialIndex = 0;
let tutorialActive = false;

function startTutorial() {
    tutorialIndex = 0;
    tutorialActive = true;
    document.getElementById('spotlight').style.display = 'block';
    document.getElementById('tooltip').style.display = 'block';
    showTutorialStep();
}

function showTutorialStep() {
    const step = tutorialSteps[tutorialIndex];
    const el = document.getElementById(step.id);
    if (!el) { nextTutorialStep(); return; }

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => positionSpotlight(el, step.text), 300);
}

function positionSpotlight(el, text) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    const spotlight = document.getElementById('spotlight');
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    const tooltip = document.getElementById('tooltip');
    document.getElementById('tooltip-text').textContent = text;

    let top = rect.bottom + 16;
    let left = rect.left;

    tooltip.style.display = 'block';
    const ttRect = tooltip.getBoundingClientRect();

    if (top + ttRect.height > window.innerHeight) {
        top = rect.top - ttRect.height - 16;
    }
    if (left + ttRect.width > window.innerWidth) {
        left = window.innerWidth - ttRect.width - 16;
    }
    if (left < 16) { left = 16; }
    if (top < 16) { top = rect.bottom + 16; }

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';

    document.getElementById('tt-next').textContent = (tutorialIndex === tutorialSteps.length - 1) ? 'Finish' : 'Next';
}

function nextTutorialStep() {
    tutorialIndex++;
    if (tutorialIndex >= tutorialSteps.length) {
        endTutorial();
    } else {
        showTutorialStep();
    }
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    tutorialActive = false;
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tooltip').style.display = 'none';
    document.getElementById('completion-modal').style.display = 'flex';
}

function closeCompletionModal() {
    document.getElementById('completion-modal').style.display = 'none';
}

window.addEventListener('resize', () => {
    if (tutorialActive) {
        const step = tutorialSteps[tutorialIndex];
        const el = document.getElementById(step.id);
        if (el) positionSpotlight(el, step.text);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>
</body>
</html>
