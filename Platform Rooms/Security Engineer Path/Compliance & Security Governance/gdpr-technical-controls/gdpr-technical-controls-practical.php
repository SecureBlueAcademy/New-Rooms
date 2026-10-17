<?php
// gdpr-technical-controls-practical.php
// Standalone static practical: DSAR Fulfillment Console
// No backend logic, no database, no sessions. PHP used only for file structure.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DSAR Fulfillment Console</title>
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

.container {
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
    margin-bottom: 8px;
}

.header h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}

.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.98rem;
    margin: 0;
    max-width: 640px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION SECTION ===== */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 22px;
    margin: 24px 0;
}
.briefing h2 {
    font-size: 1.1rem;
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}
.briefing p {
    margin: 0 0 10px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.briefing p:last-child { margin-bottom: 0; }

/* ===== MAIN ENVIRONMENT ===== */
.console {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 24px;
}

.tabs {
    display: flex;
    flex-wrap: wrap;
    border-bottom: 1px solid var(--border-default);
    background: var(--bg-surface);
}

.tab-btn {
    background: transparent;
    border: none;
    color: var(--text-secondary);
    padding: 14px 18px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
}
.tab-btn.active {
    color: var(--accent-primary);
    border-bottom: 2px solid var(--accent-primary);
}

.panel {
    display: none;
    padding: 20px;
}
.panel.active { display: block; }

.panel h3 {
    margin-top: 0;
    font-size: 1rem;
    color: var(--text-primary);
}

table.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
    margin-top: 10px;
}
table.data-table th, table.data-table td {
    text-align: left;
    padding: 10px 12px;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-secondary);
}
table.data-table th {
    color: var(--text-muted);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
table.data-table td.mono, table.data-table th.mono { font-family: "JetBrains Mono", monospace; }

.row-select {
    width: 18px;
    height: 18px;
    accent-color: var(--accent-primary);
    cursor: pointer;
}

.aggregate-block {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* ===== SUBMIT AREA ===== */
.submit-area {
    padding: 18px 20px;
    border-top: 1px solid var(--border-default);
    display: flex;
    justify-content: flex-end;
}

.submit-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 26px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
}
.submit-btn:hover { box-shadow: var(--glow-accent); }

/* ===== FEEDBACK ===== */
.feedback {
    min-height: 20px;
    margin: 4px 0 20px 0;
    font-size: 0.9rem;
}
.feedback.error { color: var(--error); }
.feedback.success { color: var(--success); }

/* ===== FLAG REVEAL ===== */
.flag-area {
    display: none;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 20px 22px;
    text-align: center;
}
.flag-area.revealed { display: block; }
.flag-area h3 {
    color: var(--success);
    margin: 0 0 10px 0;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.15rem;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 16px;
    display: inline-block;
    letter-spacing: 0.02em;
}

/* ===== TUTORIAL SPOTLIGHT ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 9998;
    transition: all 0.25s ease;
}

.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
}
.tooltip-card p {
    margin: 0 0 14px 0;
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
    border-radius: 6px;
    padding: 8px 14px;
    cursor: pointer;
    border: none;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
}
.tt-next {
    background: var(--accent-primary);
    color: #0b0f1a;
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
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin-top: 0; color: var(--accent-primary); }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; }
.modal-box button {
    margin-top: 10px;
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="container">

    <!-- 1. HEADER -->
    <div class="header">
        <div>
            <h1>DSAR Fulfillment Console</h1>
            <p class="subtitle">Meridian Retail internal data system. Locate and compile a Data Subject Access Request for customer Alina Cole.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION / MISSION BRIEFING -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This console represents four internal Meridian Retail systems: customer records, support tickets, marketing analytics, and access logs. A customer named Alina Cole has submitted a Data Subject Access Request.</p>
        <p>Your job is to review each panel, identify every row that is genuinely personal data belonging to Alina Cole, and select it. Some data in this system is pseudonymised and requires cross referencing. Some data is anonymised and does not belong to any individual, including Alina. Select only what truly belongs to her, then submit your response.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="console">
        <div class="tabs">
            <button class="tab-btn active" id="tab-customer-records" data-panel="panel-customer-records">Customer Records</button>
            <button class="tab-btn" id="tab-support-tickets" data-panel="panel-support-tickets">Support Tickets</button>
            <button class="tab-btn" id="tab-marketing-analytics" data-panel="panel-marketing-analytics">Marketing Analytics</button>
            <button class="tab-btn" id="tab-access-logs" data-panel="panel-access-logs">Access Logs</button>
        </div>

        <div id="dsar-checkbox-group">

            <!-- CUSTOMER RECORDS PANEL -->
            <div class="panel active" id="panel-customer-records">
                <h3>Customer Records</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Loyalty ID</th>
                            <th class="mono">Support Token</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="alina" data-source="customer"></td>
                            <td class="mono">CUST-1042</td>
                            <td>Alina Cole</td>
                            <td>alina.cole@fakemail.com</td>
                            <td>14 Birchwood Lane, Bristol</td>
                            <td class="mono">LP-58231</td>
                            <td class="mono">TKN-7f3a1</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="marcus" data-source="customer"></td>
                            <td class="mono">CUST-2091</td>
                            <td>Marcus Reed</td>
                            <td>marcus.reed@fakemail.com</td>
                            <td>9 Alder Court, Leeds</td>
                            <td class="mono">LP-60214</td>
                            <td class="mono">TKN-9c2d4</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="priya" data-source="customer"></td>
                            <td class="mono">CUST-3350</td>
                            <td>Priya Shah</td>
                            <td>priya.shah@fakemail.com</td>
                            <td>2 Maple Row, Glasgow</td>
                            <td class="mono">LP-71190</td>
                            <td class="mono">TKN-4b8e2</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- SUPPORT TICKETS PANEL -->
            <div class="panel" id="panel-support-tickets">
                <h3>Support Tickets</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Tickets reference customers by token only. Match the token against the Support Token column in Customer Records.</p>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Ticket ID</th>
                            <th class="mono">Token</th>
                            <th>Subject</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="alina" data-source="ticket"></td>
                            <td class="mono">TCK-501</td>
                            <td class="mono">TKN-7f3a1</td>
                            <td>Late delivery complaint</td>
                            <td>2026-03-11</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="marcus" data-source="ticket"></td>
                            <td class="mono">TCK-502</td>
                            <td class="mono">TKN-9c2d4</td>
                            <td>Refund request</td>
                            <td>2026-02-20</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="priya" data-source="ticket"></td>
                            <td class="mono">TCK-503</td>
                            <td class="mono">TKN-4b8e2</td>
                            <td>Account login issue</td>
                            <td>2026-01-15</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MARKETING ANALYTICS PANEL (distractor, anonymised) -->
            <div class="panel" id="panel-marketing-analytics">
                <h3>Marketing Analytics</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem;">This report is aggregated across all customers in the region. No individual identifiers are present.</p>
                <div class="aggregate-block">
                    Region: South West England<br>
                    Reporting period: Q1 2026<br>
                    Customer count: 1,204<br>
                    Average order value: $54.30<br>
                    Repeat purchase rate: 38%
                </div>
                <table class="data-table" style="margin-top: 16px;">
                    <thead>
                        <tr><th></th><th>Row</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="none" data-source="marketing"></td>
                            <td>Q1 2026 South West England aggregate summary</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ACCESS LOGS PANEL -->
            <div class="panel" id="panel-access-logs">
                <h3>Access Logs</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Account</th>
                            <th>Timestamp</th>
                            <th class="mono">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="alina" data-source="log"></td>
                            <td>alina.cole@fakemail.com</td>
                            <td>2026-03-10 14:22</td>
                            <td class="mono">82.14.201.9</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="marcus" data-source="log"></td>
                            <td>marcus.reed@fakemail.com</td>
                            <td>2026-02-19 09:05</td>
                            <td class="mono">91.203.4.117</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="alina" data-source="log"></td>
                            <td>alina.cole@fakemail.com</td>
                            <td>2026-03-11 08:47</td>
                            <td class="mono">82.14.201.9</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="row-select" data-owner="priya" data-source="log"></td>
                            <td>priya.shah@fakemail.com</td>
                            <td>2026-01-14 17:31</td>
                            <td class="mono">45.88.16.203</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="submit-area">
            <button class="submit-btn" id="submit-dsar-btn">Submit DSAR Response</button>
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div class="feedback" id="feedback-area"></div>

    <!-- 5. FLAG REVEAL AREA -->
    <div class="flag-area" id="flag-area">
        <h3>DSAR Fulfilled</h3>
        <p style="color: var(--text-secondary);">The response package for Alina Cole has been correctly compiled and submitted.</p>
        <div class="flag-value">CBX{dsar_fulfilled}</div>
    </div>

</div>

<!-- Tutorial completion modal -->
<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ===== TAB SWITCHING =====
const tabButtons = document.querySelectorAll('.tab-btn');
tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        tabButtons.forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(btn.dataset.panel).classList.add('active');
    });
});

// ===== SUBMIT LOGIC =====
const submitBtn = document.getElementById('submit-dsar-btn');
const feedbackArea = document.getElementById('feedback-area');
const flagArea = document.getElementById('flag-area');

submitBtn.addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('.row-select');
    let correct = true;

    checkboxes.forEach(cb => {
        const shouldBeChecked = cb.dataset.owner === 'alina';
        if (cb.checked !== shouldBeChecked) {
            correct = false;
        }
    });

    if (correct) {
        feedbackArea.textContent = 'Response package verified. All rows correctly identified.';
        feedbackArea.className = 'feedback success';
        flagArea.classList.add('revealed');
    } else {
        feedbackArea.textContent = 'The response package is incomplete or includes data that does not belong to the requester. Review each panel and try again.';
        feedbackArea.className = 'feedback error';
        flagArea.classList.remove('revealed');
    }
});

// ===== TUTORIAL SPOTLIGHT SYSTEM =====
const tutorialSteps = [
    { targetElementId: 'tab-customer-records', tooltipText: 'This tab holds direct customer data. This is where most DSARs begin, since names and emails live here in plain text.' },
    { targetElementId: 'tab-support-tickets', tooltipText: 'Support systems often store pseudonymised references instead of names. You will need to match a token back to the requester using the customer record lookup.' },
    { targetElementId: 'tab-marketing-analytics', tooltipText: 'Aggregated analytics data is often anonymised, meaning it cannot be traced back to any individual. Not everything in a system belongs in a DSAR response.' },
    { targetElementId: 'tab-access-logs', tooltipText: 'Access and login logs are personal data too, since they can identify when and how a person accessed a service.' },
    { targetElementId: 'dsar-checkbox-group', tooltipText: 'Select every row that is genuinely personal data belonging to the requester. Leave out anything that cannot be linked back to them.' },
    { targetElementId: 'submit-dsar-btn', tooltipText: 'Once you believe you have identified the complete and correct data set, submit the DSAR response.' },
];

let currentStep = 0;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tooltip-card';
    tooltipEl.innerHTML = `
        <p id="tooltip-text"></p>
        <div class="tooltip-actions">
            <button class="tt-skip" id="tt-skip-btn">Skip Tutorial</button>
            <button class="tt-next" id="tt-next-btn">Next</button>
        </div>
    `;
    document.body.appendChild(tooltipEl);

    document.getElementById('tt-skip-btn').addEventListener('click', endTutorial);
    document.getElementById('tt-next-btn').addEventListener('click', advanceTutorial);
}

function positionSpotlight() {
    const step = tutorialSteps[currentStep];
    let target = document.getElementById(step.targetElementId);
    if (!target) return;

    // If element is the customer records tab and not currently visible panel, switch to it
    if (step.targetElementId === 'tab-support-tickets' || step.targetElementId === 'tab-marketing-analytics' || step.targetElementId === 'tab-access-logs') {
        // just highlight the tab button itself, do not force switch
    }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });

    setTimeout(() => {
        const rect = target.getBoundingClientRect();
        const padding = 8;

        spotlightEl.style.top = (rect.top - padding) + 'px';
        spotlightEl.style.left = (rect.left - padding) + 'px';
        spotlightEl.style.width = (rect.width + padding * 2) + 'px';
        spotlightEl.style.height = (rect.height + padding * 2) + 'px';

        document.getElementById('tooltip-text').textContent = step.tooltipText;

        // Decide placement: prefer bottom, fallback top
        let top = rect.bottom + 16;
        let left = rect.left;

        if (top + 140 > window.innerHeight) {
            top = rect.top - 150;
        }
        if (left + 300 > window.innerWidth) {
            left = window.innerWidth - 320;
        }
        if (left < 10) left = 10;

        tooltipEl.style.top = top + 'px';
        tooltipEl.style.left = left + 'px';

        const nextBtn = document.getElementById('tt-next-btn');
        nextBtn.textContent = currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next';
    }, 300);
}

function advanceTutorial() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        finishTutorial();
    } else {
        positionSpotlight();
    }
}

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) createSpotlightElements();
    spotlightEl.style.display = 'block';
    tooltipEl.style.display = 'block';
    positionSpotlight();
}

function endTutorial() {
    if (spotlightEl) spotlightEl.style.display = 'none';
    if (tooltipEl) tooltipEl.style.display = 'none';
}

function finishTutorial() {
    endTutorial();
    document.getElementById('tutorial-complete-modal').classList.add('show');
}

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').classList.remove('show');
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (spotlightEl && spotlightEl.style.display === 'block') {
        positionSpotlight();
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
