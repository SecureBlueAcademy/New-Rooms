<?php
// idor-practical.php
// Standalone static practical: CloudDocs File Manager
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CloudDocs File Manager</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
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
    margin-bottom: 20px;
}

.header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}

.header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.user-badge {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 0.85rem;
    color: var(--text-secondary);
    white-space: nowrap;
}

.user-badge strong {
    color: var(--accent-secondary);
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 0.85rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    margin-left: 10px;
}

.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

.top-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ===== Description ===== */
.description {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}

.description strong {
    color: var(--text-primary);
}

/* ===== Environment ===== */
.environment {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.param-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 16px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9rem;
    flex-wrap: wrap;
}

.param-bar .url-static {
    color: var(--text-muted);
}

.param-bar input[type="number"] {
    background: var(--bg-primary);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    border-radius: 6px;
    padding: 6px 10px;
    width: 90px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9rem;
}

.load-button {
    background: linear-gradient(135deg, #1a2a4a, #223a5e);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    border-radius: 8px;
    padding: 12px 22px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    margin-top: 14px;
}

.load-button:hover {
    box-shadow: var(--glow-accent);
}

.doc-viewer {
    margin-top: 20px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 18px 20px;
    min-height: 140px;
}

.doc-viewer .doc-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 12px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.doc-viewer .doc-meta span strong {
    color: var(--text-primary);
}

.doc-viewer .doc-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--accent-primary);
    margin-bottom: 10px;
}

.doc-viewer .doc-body {
    font-size: 0.92rem;
    color: var(--text-primary);
    border-top: 1px solid var(--border-default);
    padding-top: 12px;
}

.doc-viewer.owner-mismatch {
    border-color: var(--warning);
}

.doc-viewer.not-found .doc-body {
    color: var(--text-muted);
    font-style: italic;
}

/* ===== Feedback ===== */
.status-area {
    min-height: 24px;
    margin-bottom: 20px;
    font-size: 0.88rem;
}

.status-area.warn { color: var(--warning); }
.status-area.ok { color: var(--success); }

/* ===== Flag reveal ===== */
.flag-panel {
    display: none;
    background: linear-gradient(135deg, #0f2a1f, #123a2a);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px 22px;
    text-align: center;
}

.flag-panel.revealed {
    display: block;
}

.flag-panel h3 {
    margin-top: 0;
    color: var(--success);
}

.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.15rem;
    background: var(--bg-primary);
    display: inline-block;
    padding: 10px 18px;
    border-radius: 6px;
    border: 1px solid var(--success);
    color: var(--success);
    margin-top: 8px;
}

/* ===== Tutorial spotlight ===== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: none;
    z-index: 9998;
}

.tooltip-card {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 9999;
    box-shadow: var(--glow-accent);
}

.tooltip-card .tt-title {
    color: var(--accent-primary);
    font-weight: 600;
    margin-bottom: 6px;
}

.tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}

.tooltip-card button {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

.tooltip-card button.primary {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

.modal-overlay.show {
    display: flex;
}

.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px 30px;
    max-width: 360px;
    text-align: center;
}

.modal-box h3 {
    color: var(--accent-primary);
    margin-top: 0;
}

.modal-box button {
    margin-top: 14px;
    background: linear-gradient(135deg, #1a2a4a, #223a5e);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    border-radius: 8px;
    padding: 10px 22px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .header { flex-direction: column; }
    .param-bar { flex-direction: column; align-items: stretch; }
}
</style>
</head>
<body>
<div class="wrapper">

    <!-- 1. HEADER -->
    <div class="header">
        <div>
            <h1>CloudDocs File Manager</h1>
            <p>Internal document portal. You are investigating a rumor of exposed employee files.</p>
        </div>
        <div class="top-controls">
            <div class="user-badge" id="user-badge">Logged in as: <strong>jsmith</strong></div>
            <button class="tutorial-btn" id="tutorial-restart">View Tutorial</button>
        </div>
    </div>

    <!-- 2. DESCRIPTION -->
    <div class="description">
        <strong>What this is:</strong> a simulated internal file portal. Each employee has documents identified by a numeric doc_id. <strong>Your goal:</strong> load your own document, then try changing the document ID to see what else you can access. Somewhere in another employee's file is a hint pointing toward a restricted record.
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="environment">
        <div class="param-bar" id="param-bar">
            <span class="url-static">clouddocs.local/view?doc_id=</span>
            <input type="number" id="doc-id-input" value="204">
        </div>

        <button class="load-button" id="load-button">Load Document</button>

        <div class="doc-viewer" id="doc-viewer">
            <div class="doc-meta">
                <span>Owner: <strong id="doc-owner">-</strong></span>
                <span>Date: <strong id="doc-date">-</strong></span>
            </div>
            <div class="doc-title" id="doc-title">No document loaded yet.</div>
            <div class="doc-body" id="doc-body">Enter a document ID above and click Load Document.</div>
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div class="status-area" id="status-area"></div>

    <!-- 5. FLAG REVEAL AREA -->
    <div class="flag-panel" id="flag-panel">
        <h3>Flag Discovered</h3>
        <p>You accessed a restricted administrative record with no ownership check in place.</p>
        <div class="flag-value" id="flag-value">CBX{document_exposed}</div>
    </div>

</div>

<!-- Tutorial completion modal -->
<div class="modal-overlay" id="tutorial-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ===================== DATA =====================
const docs = {
    204: {
        owner: 'jsmith',
        title: 'Q3 Budget Notes',
        date: 'Mar 14',
        body: 'Marketing spend held steady this quarter. No major changes needed to the software budget line.'
    },
    201: {
        owner: 'mchen',
        title: 'Performance Review Draft',
        date: 'Mar 09',
        body: 'Draft notes on team member performance. Confidential until finalized. Escalation records for HR review are filed under document ID 501.'
    },
    202: {
        owner: 'tpatel',
        title: 'Personal Leave Request',
        date: 'Mar 02',
        body: 'Requesting five days of personal leave starting next month. Reason: family matters.'
    },
    203: {
        owner: 'rwilliams',
        title: 'Salary Negotiation Letter',
        date: 'Feb 27',
        body: 'Draft letter requesting a salary adjustment based on market rate comparison. Please keep this confidential.'
    },
    205: {
        owner: 'agupta',
        title: 'Draft Resignation Letter',
        date: 'Feb 20',
        body: 'This is a draft. Not yet submitted. Planning to discuss with manager before finalizing.'
    },
    501: {
        owner: 'admin',
        title: 'HR Termination Records (Confidential)',
        date: 'Jan 30',
        body: 'Case file reference: CBX{document_exposed}. Access to this record is restricted to HR administrators only.'
    }
};

const currentUser = 'jsmith';

// ===================== INTERACTION =====================
const input = document.getElementById('doc-id-input');
const loadBtn = document.getElementById('load-button');
const viewer = document.getElementById('doc-viewer');
const titleEl = document.getElementById('doc-title');
const ownerEl = document.getElementById('doc-owner');
const dateEl = document.getElementById('doc-date');
const bodyEl = document.getElementById('doc-body');
const statusArea = document.getElementById('status-area');
const flagPanel = document.getElementById('flag-panel');

function loadDoc() {
    const id = input.value.trim();
    const doc = docs[id];

    viewer.classList.remove('owner-mismatch', 'not-found');
    statusArea.className = 'status-area';

    if (!doc) {
        titleEl.textContent = 'No document found.';
        ownerEl.textContent = '-';
        dateEl.textContent = '-';
        bodyEl.textContent = 'There is no document with that ID.';
        viewer.classList.add('not-found');
        statusArea.textContent = '';
        return;
    }

    titleEl.textContent = doc.title;
    ownerEl.textContent = doc.owner;
    dateEl.textContent = doc.date;
    bodyEl.textContent = doc.body;

    if (doc.owner !== currentUser) {
        viewer.classList.add('owner-mismatch');
        statusArea.classList.add('warn');
        statusArea.textContent = 'Warning: this document belongs to "' + doc.owner + '", not "' + currentUser + '". No access check stopped this request.';
    } else {
        statusArea.classList.add('ok');
        statusArea.textContent = 'This is your own document.';
    }

    if (String(id) === '501') {
        flagPanel.classList.add('revealed');
    }
}

loadBtn.addEventListener('click', loadDoc);
input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') loadDoc();
});

// ===================== TUTORIAL SYSTEM =====================
const tutorialSteps = [
    {
        targetId: 'param-bar',
        title: 'Document ID Parameter',
        text: 'This is the document ID parameter. In a real application this would sit in the URL of your browser. Try changing the number to see what happens.'
    },
    {
        targetId: 'load-button',
        title: 'Load Document',
        text: 'Click here to load whichever document ID is currently entered.'
    },
    {
        targetId: 'doc-viewer',
        title: 'Document Viewer',
        text: 'This panel shows the document that was loaded, including who owns it.'
    },
    {
        targetId: 'user-badge',
        title: 'Your Identity',
        text: 'This shows who you are logged in as. Compare this to the Owner field in the document you load. If they do not match, you should not be seeing this file.'
    }
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function clearTutorialUI() {
    if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
    if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
}

function positionTutorial() {
    if (currentStep >= tutorialSteps.length) return;
    const step = tutorialSteps[currentStep];
    const target = document.getElementById(step.targetId);
    if (!target) return;

    const doPosition = () => {
        const rect = target.getBoundingClientRect();
        const pad = 8;

        if (!spotlightEl) {
            spotlightEl = document.createElement('div');
            spotlightEl.className = 'spotlight';
            document.body.appendChild(spotlightEl);
        }
        spotlightEl.style.top = (rect.top - pad) + 'px';
        spotlightEl.style.left = (rect.left - pad) + 'px';
        spotlightEl.style.width = (rect.width + pad * 2) + 'px';
        spotlightEl.style.height = (rect.height + pad * 2) + 'px';

        if (!tooltipEl) {
            tooltipEl = document.createElement('div');
            tooltipEl.className = 'tooltip-card';
            document.body.appendChild(tooltipEl);
        }
        tooltipEl.innerHTML =
            '<div class="tt-title">' + step.title + '</div>' +
            '<div>' + step.text + '</div>' +
            '<div class="tt-actions">' +
                '<button id="tt-skip">Skip Tutorial</button>' +
                '<button id="tt-next" class="primary">' + (currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
            '</div>';

        const ttWidth = 280;
        let top = rect.bottom + 14;
        let left = rect.left;

        if (top + 140 > window.innerHeight) {
            top = rect.top - 150;
        }
        if (left + ttWidth > window.innerWidth) {
            left = window.innerWidth - ttWidth - 20;
        }
        if (left < 10) left = 10;

        tooltipEl.style.top = top + 'px';
        tooltipEl.style.left = left + 'px';

        document.getElementById('tt-next').addEventListener('click', nextStep);
        document.getElementById('tt-skip').addEventListener('click', endTutorial);
    };

    const rect = target.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(doPosition, 300);
    } else {
        doPosition();
    }
}

function nextStep() {
    clearTutorialUI();
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        showCompletionModal();
    } else {
        positionTutorial();
    }
}

function endTutorial() {
    clearTutorialUI();
    currentStep = tutorialSteps.length;
}

function startTutorial() {
    currentStep = 0;
    clearTutorialUI();
    positionTutorial();
}

function showCompletionModal() {
    document.getElementById('tutorial-modal').classList.add('show');
}

document.getElementById('start-challenge-btn').addEventListener('click', function () {
    document.getElementById('tutorial-modal').classList.remove('show');
});

document.getElementById('tutorial-restart').addEventListener('click', startTutorial);

window.addEventListener('resize', function () {
    if (currentStep < tutorialSteps.length && spotlightEl) {
        positionTutorial();
    }
});

window.addEventListener('load', function () {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
