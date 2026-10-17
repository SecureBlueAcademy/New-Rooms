<?php
// xxe-ssrf-practical.php
// Standalone static practical: Document Parser Lab (XXE simulation)
// No backend logic, no database, no sessions. PHP used only for file structure.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resume Parser Pro | Document Parser Lab</title>
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
        min-height: 100vh;
    }

    code, .mono, textarea, .log-line {
        font-family: 'JetBrains Mono', monospace;
    }

    .page-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px 60px 20px;
    }

    /* ===== SECTION 1: HEADER ===== */
    .lab-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 20px;
    }
    .lab-header h1 {
        font-size: 1.7rem;
        margin: 0 0 6px 0;
        color: var(--text-primary);
    }
    .lab-header .subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        max-width: 640px;
    }
    #view-tutorial-btn {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        color: var(--accent-primary);
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    #view-tutorial-btn:hover {
        box-shadow: var(--glow-accent);
    }

    /* ===== SECTION 2: DESCRIPTION ===== */
    .briefing-box {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px 22px;
        margin-bottom: 26px;
    }
    .briefing-box h3 {
        margin-top: 0;
        font-size: 1rem;
        color: var(--accent-primary);
    }
    .briefing-box p {
        color: var(--text-secondary);
        font-size: 0.92rem;
        line-height: 1.6;
        margin: 8px 0;
    }

    /* ===== SECTION 3: MAIN ENVIRONMENT ===== */
    .lab-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 820px) {
        .lab-grid { grid-template-columns: 1fr; }
    }
    .panel {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .panel-header {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-default);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .panel-header h4 {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-primary);
    }
    .panel-body {
        padding: 16px;
        flex: 1;
    }

    #xml-editor {
        width: 100%;
        min-height: 260px;
        background: var(--bg-primary);
        color: var(--text-primary);
        border: 1px solid var(--border-default);
        border-radius: 8px;
        padding: 14px;
        font-size: 0.85rem;
        line-height: 1.5;
        resize: vertical;
    }

    .btn-row {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }
    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        border: 1px solid var(--border-default);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-primary {
        background: linear-gradient(135deg, #1a3a4a, #12242f);
        border-color: var(--accent-primary);
        color: var(--accent-primary);
    }
    .btn-primary:hover {
        box-shadow: var(--glow-accent);
    }
    .btn:hover {
        border-color: var(--text-secondary);
    }

    #output-panel {
        min-height: 260px;
        background: var(--bg-primary);
        border: 1px solid var(--border-default);
        border-radius: 8px;
        padding: 16px;
        font-size: 0.88rem;
        color: var(--text-secondary);
        white-space: pre-wrap;
        word-break: break-word;
    }
    .profile-card {
        border: 1px solid var(--border-default);
        border-radius: 8px;
        padding: 14px;
        background: var(--bg-secondary);
    }
    .profile-card .field-label {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 2px;
    }
    .profile-card .field-value {
        color: var(--text-primary);
        margin-bottom: 12px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85rem;
    }
    .leaked-value {
        color: var(--error);
    }

    /* ===== SECTION 4: STATUS AREA ===== */
    .status-area {
        margin-top: 20px;
        padding: 14px 18px;
        border-radius: 8px;
        font-size: 0.88rem;
        border: 1px solid var(--border-default);
        background: var(--bg-secondary);
        color: var(--text-secondary);
    }
    .status-area.status-error { border-color: var(--error); color: var(--error); }
    .status-area.status-success { border-color: var(--success); color: var(--success); }
    .status-area.status-warning { border-color: var(--warning); color: var(--warning); }

    /* ===== SECTION 5: FLAG REVEAL ===== */
    .flag-area {
        margin-top: 24px;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid var(--border-default);
        background: var(--bg-surface);
        display: none;
    }
    .flag-area.revealed {
        display: block;
        border-color: var(--success);
    }
    .flag-area h4 {
        margin: 0 0 10px 0;
        color: var(--success);
        font-size: 0.95rem;
    }
    .flag-value {
        display: inline-block;
        background: var(--bg-primary);
        border: 1px solid var(--success);
        color: var(--success);
        padding: 10px 16px;
        border-radius: 8px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 1rem;
        user-select: all;
    }

    /* ===== TUTORIAL SYSTEM ===== */
    .tutorial-spotlight {
        position: fixed;
        border-radius: 8px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        pointer-events: none;
        transition: all 0.2s ease;
        z-index: 9998;
    }
    .tutorial-tooltip {
        position: fixed;
        max-width: 300px;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px;
        z-index: 9999;
        box-shadow: 0 0 20px rgba(106,227,255,0.25);
    }
    .tutorial-tooltip p {
        margin: 0 0 12px 0;
        font-size: 0.88rem;
        color: var(--text-primary);
        line-height: 1.5;
    }
    .tutorial-tooltip .tt-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }
    .tutorial-tooltip .tt-actions button {
        font-size: 0.8rem;
        padding: 8px 12px;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 12px;
        padding: 30px;
        max-width: 380px;
        text-align: center;
    }
    .modal-box h3 {
        margin-top: 0;
        color: var(--accent-primary);
    }
    .modal-box p {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
</style>
</head>
<body>

<div class="page-wrap">

    <!-- SECTION 1: HEADER -->
    <div class="lab-header">
        <div>
            <h1>Resume Parser Pro</h1>
            <div class="subtitle">Document Parser Lab: submit XML formatted resumes and inspect how the parser handles them.</div>
        </div>
        <button id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- SECTION 2: DESCRIPTION -->
    <div class="briefing-box">
        <h3>Mission Briefing</h3>
        <p>This environment simulates a resume upload feature that parses XML formatted resumes and displays the extracted profile. The parser resolves external entities by default, which is exactly the kind of misconfiguration covered in this room.</p>
        <p>Your goal is to modify the XML in the editor so that the parser reveals the contents of an internal file it was never meant to expose. Watch the output panel closely after each submission.</p>
    </div>

    <!-- SECTION 3: MAIN INTERACTIVE ENVIRONMENT -->
    <div class="lab-grid">
        <div class="panel">
            <div class="panel-header">
                <h4>XML Input</h4>
            </div>
            <div class="panel-body">
                <textarea id="xml-editor" spellcheck="false"></textarea>
                <div class="btn-row">
                    <button class="btn" id="load-sample-btn">Load Sample XML</button>
                    <button class="btn btn-primary" id="parse-btn">Parse Resume</button>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h4>Parser Output</h4>
            </div>
            <div class="panel-body">
                <div id="output-panel">Submit a resume to see the parsed result here.</div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: STATUS AREA -->
    <div class="status-area" id="status-area">Ready. Load the sample resume or write your own XML.</div>

    <!-- SECTION 5: FLAG REVEAL -->
    <div class="flag-area" id="flag-area">
        <h4>Internal File Disclosed</h4>
        <p style="color: var(--text-secondary); font-size: 0.85rem;">The parser resolved your external entity and leaked the contents of an internal configuration file, including this flag:</p>
        <div class="flag-value" id="flag-value">CBX{config_leaked}</div>
    </div>

</div>

<!-- Tutorial completion modal -->
<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Good luck tracing the parser's behavior.</p>
        <button class="btn btn-primary" id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
    const SAMPLE_XML = `<?xml version="1.0"?>
<resume>
    <name>Jane Doe</name>
    <email>[email protected]</email>
    <skills>JavaScript, Python, Cloud Security</skills>
</resume>`;

    const INTERNAL_FILE_CONTENT =
`# Internal Configuration - DO NOT DISTRIBUTE
service: resume-parser-internal
env: production
admin_note: Legacy XML parser still allows external entities. Ticket SEC-4471 pending.
flag: CBX{config_leaked}`;

    const editor = document.getElementById('xml-editor');
    const outputPanel = document.getElementById('output-panel');
    const statusArea = document.getElementById('status-area');
    const flagArea = document.getElementById('flag-area');

    document.getElementById('load-sample-btn').addEventListener('click', () => {
        editor.value = SAMPLE_XML;
        setStatus('Sample resume loaded.', 'default');
    });

    document.getElementById('parse-btn').addEventListener('click', parseXML);

    function setStatus(message, type) {
        statusArea.textContent = message;
        statusArea.className = 'status-area' + (type && type !== 'default' ? ' status-' + type : '');
    }

    function escapeHtml(str) {
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function extractTag(xml, tag) {
        const match = xml.match(new RegExp('<' + tag + '>([\\s\\S]*?)<\\/' + tag + '>', 'i'));
        return match ? match[1].trim() : null;
    }

    function parseXML() {
        const xml = editor.value;

        if (!xml.trim()) {
            setStatus('No XML provided. Load the sample or write your own.', 'error');
            outputPanel.textContent = 'No input to parse.';
            return;
        }

        const nameRaw = extractTag(xml, 'name');
        const emailRaw = extractTag(xml, 'email');
        const skillsRaw = extractTag(xml, 'skills');

        if (nameRaw === null && emailRaw === null && skillsRaw === null) {
            setStatus('Parser error: could not locate expected resume fields.', 'error');
            outputPanel.textContent = 'ParserError: malformed XML or missing <name>, <email>, <skills> fields.';
            return;
        }

        // Detect a declared external entity: <!ENTITY name SYSTEM "value">
        const entityMatch = xml.match(/<!ENTITY\s+(\w+)\s+SYSTEM\s+["']([^"']+)["']\s*>/i);

        let leaked = false;
        let resolvedFields = { name: nameRaw, email: emailRaw, skills: skillsRaw };

        if (entityMatch) {
            const entityName = entityMatch[1];
            const entityTarget = entityMatch[2].toLowerCase();
            const targetsInternalFile = entityTarget.includes('file://') && entityTarget.includes('app-config');

            if (targetsInternalFile) {
                const refPattern = new RegExp('&' + entityName + ';');
                for (const field of ['name', 'email', 'skills']) {
                    if (resolvedFields[field] && refPattern.test(resolvedFields[field])) {
                        resolvedFields[field] = INTERNAL_FILE_CONTENT;
                        leaked = true;
                    }
                }
            }
        }

        if (leaked) {
            renderOutput(resolvedFields, true);
            setStatus('Parser resolved an external entity and returned file contents.', 'success');
            revealFlag();
        } else {
            renderOutput(resolvedFields, false);
            setStatus('Resume parsed successfully. No anomalies detected.', 'default');
        }
    }

    function renderOutput(fields, leaked) {
        const nameClass = fields.name === INTERNAL_FILE_CONTENT ? 'leaked-value' : '';
        const emailClass = fields.email === INTERNAL_FILE_CONTENT ? 'leaked-value' : '';
        const skillsClass = fields.skills === INTERNAL_FILE_CONTENT ? 'leaked-value' : '';

        outputPanel.innerHTML = `
            <div class="profile-card">
                <div class="field-label">Name</div>
                <div class="field-value ${nameClass}">${escapeHtml(fields.name || '')}</div>
                <div class="field-label">Email</div>
                <div class="field-value ${emailClass}">${escapeHtml(fields.email || '')}</div>
                <div class="field-label">Skills</div>
                <div class="field-value ${skillsClass}">${escapeHtml(fields.skills || '')}</div>
            </div>
        `;
    }

    function revealFlag() {
        flagArea.classList.add('revealed');
    }

    // ===================================================================
    // SPOTLIGHT TUTORIAL SYSTEM
    // ===================================================================
    const tutorialSteps = [
        {
            id: 'xml-editor',
            text: 'This is the XML editor, just like the input field a real resume upload API would receive. Try editing the XML directly.'
        },
        {
            id: 'load-sample-btn',
            text: 'Click here anytime to reset to a normal, valid resume XML and see what the parser expects.'
        },
        {
            id: 'parse-btn',
            text: 'This submits your XML to the parser, exactly like a candidate submitting a resume to a job application system.'
        },
        {
            id: 'output-panel',
            text: 'This shows what the parser actually processed. Watch closely, since it will reveal anything your XML successfully told it to resolve.'
        },
        {
            id: 'view-tutorial-btn',
            text: 'You can replay this tutorial anytime from here.'
        }
    ];

    let currentStep = 0;
    let spotlightEl = null;
    let tooltipEl = null;

    function buildTutorialElements() {
        spotlightEl = document.createElement('div');
        spotlightEl.className = 'tutorial-spotlight';
        document.body.appendChild(spotlightEl);

        tooltipEl = document.createElement('div');
        tooltipEl.className = 'tutorial-tooltip';
        document.body.appendChild(tooltipEl);
    }

    function removeTutorialElements() {
        if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
        if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
    }

    function positionSpotlight(targetEl) {
        const rect = targetEl.getBoundingClientRect();
        const pad = 8;
        spotlightEl.style.top = (rect.top - pad) + 'px';
        spotlightEl.style.left = (rect.left - pad) + 'px';
        spotlightEl.style.width = (rect.width + pad * 2) + 'px';
        spotlightEl.style.height = (rect.height + pad * 2) + 'px';
    }

    function positionTooltip(targetEl) {
        const rect = targetEl.getBoundingClientRect();
        const tooltipWidth = 300;
        let top = rect.bottom + 14;
        let left = rect.left;

        if (top + 140 > window.innerHeight) {
            top = rect.top - 150;
        }
        if (left + tooltipWidth > window.innerWidth) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (left < 10) left = 10;

        tooltipEl.style.top = top + 'px';
        tooltipEl.style.left = left + 'px';
    }

    function renderTooltipContent(step, stepIndex) {
        const isLast = stepIndex === tutorialSteps.length - 1;
        tooltipEl.innerHTML = `
            <p>${step.text}</p>
            <div class="tt-actions">
                <button class="btn" id="tt-skip">Skip Tutorial</button>
                <button class="btn btn-primary" id="tt-next">${isLast ? 'Finish' : 'Next'}</button>
            </div>
        `;
        document.getElementById('tt-skip').addEventListener('click', endTutorial);
        document.getElementById('tt-next').addEventListener('click', () => {
            if (isLast) {
                endTutorial(true);
            } else {
                currentStep++;
                showStep(currentStep);
            }
        });
    }

    function showStep(index) {
        const step = tutorialSteps[index];
        const targetEl = document.getElementById(step.id);
        if (!targetEl) return;

        const rect = targetEl.getBoundingClientRect();
        const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

        const doPosition = () => {
            positionSpotlight(targetEl);
            positionTooltip(targetEl);
            renderTooltipContent(step, index);
        };

        if (!isVisible) {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(doPosition, 300);
        } else {
            doPosition();
        }
    }

    function startTutorial() {
        currentStep = 0;
        buildTutorialElements();
        showStep(currentStep);
    }

    function endTutorial(showModal) {
        removeTutorialElements();
        if (showModal) {
            document.getElementById('tutorial-complete-modal').classList.add('active');
        }
    }

    window.addEventListener('resize', () => {
        if (spotlightEl && tooltipEl && tutorialSteps[currentStep]) {
            const targetEl = document.getElementById(tutorialSteps[currentStep].id);
            if (targetEl) {
                positionSpotlight(targetEl);
                positionTooltip(targetEl);
            }
        }
    });

    document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
    document.getElementById('start-challenge-btn').addEventListener('click', () => {
        document.getElementById('tutorial-complete-modal').classList.remove('active');
    });

    // Auto-load sample and auto-start tutorial on first load
    editor.value = SAMPLE_XML;
    window.addEventListener('load', () => {
        setTimeout(startTutorial, 400);
    });
</script>

</body>
</html>
