<?php
// legal-ethical-framework-practical.php
// Engagement Review Console — standalone static practical
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Engagement Review Console | CYBRIXEN</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
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

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    min-height: 100vh;
    line-height: 1.6;
}

/* ========== LAYOUT ========== */
.page-wrapper {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 20px 60px;
}

/* ========== HEADER ========== */
.page-header {
    padding: 32px 0 24px;
    border-bottom: 1px solid var(--border-default);
    margin-bottom: 32px;
    position: relative;
}

.page-header h1 {
    font-size: 1.65rem;
    font-weight: 700;
    color: var(--accent-primary);
    letter-spacing: 0.01em;
}

.page-header .subtitle {
    font-size: 0.92rem;
    color: var(--text-secondary);
    margin-top: 6px;
}

.tutorial-btn {
    position: absolute;
    top: 32px;
    right: 0;
    background: transparent;
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
}

.tutorial-btn:hover {
    background: rgba(106,227,255,0.07);
    box-shadow: var(--glow-accent);
}

/* ========== MISSION BRIEFING ========== */
.mission-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-left: 3px solid var(--accent-secondary);
    border-radius: 10px;
    padding: 22px 26px;
    margin-bottom: 32px;
}

.mission-card h2 {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--accent-secondary);
    margin-bottom: 10px;
}

.mission-card p {
    font-size: 0.92rem;
    color: var(--text-secondary);
    line-height: 1.65;
}

.mission-card p + p {
    margin-top: 10px;
}

/* ========== PROGRESS TRACKER ========== */
.progress-tracker {
    display: flex;
    gap: 12px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.progress-step {
    flex: 1;
    min-width: 140px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 0.82rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 10px;
    transition: border-color 0.3s, color 0.3s;
}

.progress-step .step-num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 1.5px solid currentColor;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.78rem;
    font-weight: 600;
    flex-shrink: 0;
}

.progress-step.active {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}

.progress-step.done {
    border-color: var(--success);
    color: var(--success);
}

.progress-step.done .step-num {
    background: var(--success);
    color: var(--bg-primary);
    border-color: var(--success);
}

/* ========== PANELS ========== */
.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    margin-bottom: 28px;
    overflow: hidden;
    display: none;
}

.panel.active {
    display: block;
}

.panel-header {
    background: var(--bg-surface);
    border-bottom: 1px solid var(--border-default);
    padding: 16px 22px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.panel-tag {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 3px 9px;
    border-radius: 4px;
    background: rgba(106,227,255,0.1);
    color: var(--accent-primary);
}

.panel-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.panel-body {
    padding: 22px;
}

/* ========== DOCUMENT DISPLAY ========== */
.doc-section {
    margin-bottom: 22px;
}

.doc-section h4 {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid var(--border-default);
}

.doc-field {
    display: flex;
    gap: 16px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 0.88rem;
}

.doc-field:last-child { border-bottom: none; }

.doc-label {
    color: var(--text-muted);
    min-width: 160px;
    flex-shrink: 0;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.82rem;
}

.doc-value {
    color: var(--text-primary);
}

/* ========== SCOPE TABLE ========== */
.scope-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.87rem;
    margin-top: 6px;
}

.scope-table th {
    text-align: left;
    padding: 10px 14px;
    background: var(--bg-surface);
    color: var(--text-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 1px solid var(--border-default);
}

.scope-table td {
    padding: 10px 14px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    color: var(--text-secondary);
}

.scope-table tr:last-child td { border-bottom: none; }

.scope-table .in { color: var(--success); font-weight: 500; }
.scope-table .out { color: var(--error); font-weight: 500; }

/* ========== ACTION LOG ========== */
.log-entry {
    display: flex;
    gap: 14px;
    padding: 11px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 0.87rem;
    align-items: flex-start;
}

.log-entry:last-child { border-bottom: none; }

.log-time {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
    color: var(--text-muted);
    min-width: 90px;
    flex-shrink: 0;
    padding-top: 2px;
}

.log-desc { color: var(--text-secondary); flex: 1; }

.log-target {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.78rem;
    color: var(--accent-primary);
    min-width: 200px;
    flex-shrink: 0;
    padding-top: 2px;
}

/* ========== QUESTION BLOCK ========== */
.question-block {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 18px 20px;
    margin-top: 20px;
}

.question-block p {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 14px;
    line-height: 1.6;
}

.question-block strong {
    color: var(--text-primary);
}

.choice-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.choice-btn {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 7px;
    padding: 10px 16px;
    text-align: left;
    color: var(--text-secondary);
    font-size: 0.87rem;
    font-family: inherit;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s, color 0.2s;
}

.choice-btn:hover { border-color: var(--accent-primary); color: var(--text-primary); }
.choice-btn.selected-correct { border-color: var(--success); background: rgba(61,255,154,0.06); color: var(--success); }
.choice-btn.selected-wrong { border-color: var(--error); background: rgba(255,92,92,0.06); color: var(--error); }
.choice-btn:disabled { cursor: not-allowed; opacity: 0.7; }

.feedback-msg {
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 0.85rem;
    display: none;
}

.feedback-msg.show { display: block; }
.feedback-msg.ok { background: rgba(61,255,154,0.08); color: var(--success); border: 1px solid rgba(61,255,154,0.2); }
.feedback-msg.err { background: rgba(255,92,92,0.08); color: var(--error); border: 1px solid rgba(255,92,92,0.2); }

/* ========== CONTINUE BUTTON ========== */
.continue-btn {
    display: none;
    margin-top: 18px;
    padding: 10px 24px;
    background: transparent;
    border: 1px solid var(--accent-primary);
    border-radius: 7px;
    color: var(--accent-primary);
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
}

.continue-btn:hover { background: rgba(106,227,255,0.08); box-shadow: var(--glow-accent); }
.continue-btn.show { display: inline-flex; align-items: center; gap: 8px; }

/* ========== FLAG REVEAL ========== */
.flag-section {
    display: none;
    margin-top: 32px;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 30px 28px;
    text-align: center;
    box-shadow: 0 0 28px rgba(61,255,154,0.1);
}

.flag-section.show { display: block; }

.flag-section h2 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--success);
    margin-bottom: 8px;
}

.flag-section p {
    font-size: 0.88rem;
    color: var(--text-secondary);
    margin-bottom: 20px;
}

.flag-display {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--success);
    background: rgba(61,255,154,0.06);
    border: 1px solid rgba(61,255,154,0.25);
    border-radius: 8px;
    padding: 14px 28px;
    display: inline-block;
    letter-spacing: 0.05em;
    box-shadow: 0 0 18px rgba(61,255,154,0.15);
}

.flag-note {
    margin-top: 14px;
    font-size: 0.82rem;
    color: var(--text-muted);
    font-style: italic;
}

/* ========== STATUS BAR ========== */
.status-bar {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 18px;
    margin-bottom: 24px;
    font-size: 0.85rem;
    color: var(--text-secondary);
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--accent-primary);
    flex-shrink: 0;
}

/* ========== SPOTLIGHT TUTORIAL ========== */
#spotlight-overlay {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 9000;
    display: none;
}

#spotlight-overlay.active {
    display: block;
    pointer-events: auto;
}

#spotlight-box {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.78);
    pointer-events: none;
    z-index: 9001;
    transition: top 0.2s, left 0.2s, width 0.2s, height 0.2s;
}

#tutorial-tooltip {
    position: fixed;
    background: #1a2040;
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 18px 20px;
    max-width: 340px;
    z-index: 9002;
    box-shadow: var(--glow-accent), 0 8px 32px rgba(0,0,0,0.5);
    font-size: 0.87rem;
    color: var(--text-secondary);
    line-height: 1.6;
    pointer-events: auto;
}

#tutorial-tooltip h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--accent-primary);
    margin-bottom: 8px;
}

.tooltip-actions {
    display: flex;
    gap: 10px;
    margin-top: 14px;
    justify-content: flex-end;
}

.tt-skip {
    background: transparent;
    border: none;
    color: var(--text-muted);
    font-family: inherit;
    font-size: 0.82rem;
    cursor: pointer;
    padding: 6px 8px;
}

.tt-skip:hover { color: var(--text-secondary); }

.tt-next {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 6px;
    padding: 7px 18px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
}

.tt-next:hover { opacity: 0.9; }

/* ========== TUTORIAL COMPLETE MODAL ========== */
#tut-complete-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 9500;
    align-items: center;
    justify-content: center;
}

#tut-complete-modal.show { display: flex; }

.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 36px 40px;
    max-width: 420px;
    text-align: center;
    box-shadow: var(--glow-accent), 0 12px 48px rgba(0,0,0,0.6);
}

.modal-card h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--accent-primary);
    margin-bottom: 10px;
}

.modal-card p {
    font-size: 0.88rem;
    color: var(--text-secondary);
    margin-bottom: 24px;
    line-height: 1.6;
}

.modal-start-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    padding: 11px 30px;
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
}

.modal-start-btn:hover { opacity: 0.9; }
</style>
</head>
<body>
<div class="page-wrapper">

    <!-- HEADER -->
    <header class="page-header" id="page-header">
        <h1>Engagement Review Console</h1>
        <p class="subtitle">Simulated Penetration Testing Engagement — Authorisation Review</p>
        <button class="tutorial-btn" id="tutorial-restart-btn" onclick="startTutorial()">View Tutorial</button>
    </header>

    <!-- MISSION BRIEFING -->
    <section class="mission-card" id="mission-card">
        <h2>Mission Briefing</h2>
        <p>A penetration testing firm has received an engagement from a mid-sized e-commerce company called Hartfield Retail Ltd. You have been given access to the client brief, the agreed scope document, and the action log produced by the lead tester on the first day of work.</p>
        <p>Your task is to review all three documents in order. In the scope review, identify which systems are inside and outside the agreed boundaries. In the action log review, flag any tester actions that violate the scope. Finally, confirm the authorisation status of this engagement. Complete all three stages to retrieve the flag.</p>
    </section>

    <!-- STATUS BAR -->
    <div class="status-bar" id="status-bar">
        <div class="status-dot"></div>
        <span id="status-text">Stage 1 of 3: Review the Client Brief to proceed.</span>
    </div>

    <!-- PROGRESS TRACKER -->
    <div class="progress-tracker">
        <div class="progress-step active" id="step-1">
            <div class="step-num">1</div>
            <span>Client Brief</span>
        </div>
        <div class="progress-step" id="step-2">
            <div class="step-num">2</div>
            <span>Scope Review</span>
        </div>
        <div class="progress-step" id="step-3">
            <div class="step-num">3</div>
            <span>Action Log</span>
        </div>
    </div>

    <!-- ========== PANEL 1: CLIENT BRIEF ========== -->
    <div class="panel active" id="panel-1">
        <div class="panel-header">
            <span class="panel-tag">Stage 1</span>
            <h3>Client Brief — Hartfield Retail Ltd</h3>
        </div>
        <div class="panel-body">

            <div class="doc-section">
                <h4>Engagement Details</h4>
                <div class="doc-field"><span class="doc-label">Client</span><span class="doc-value">Hartfield Retail Ltd</span></div>
                <div class="doc-field"><span class="doc-label">Engagement Type</span><span class="doc-value">External Network and Web Application Penetration Test</span></div>
                <div class="doc-field"><span class="doc-label">Requested By</span><span class="doc-value">Sarah Okoye, Chief Information Officer</span></div>
                <div class="doc-field"><span class="doc-label">Authorisation Date</span><span class="doc-value">14 March 2025</span></div>
                <div class="doc-field"><span class="doc-label">NDA Signed</span><span class="doc-value">Yes — both parties, 10 March 2025</span></div>
                <div class="doc-field"><span class="doc-label">Statement of Work</span><span class="doc-value">Signed and countersigned, 13 March 2025</span></div>
                <div class="doc-field"><span class="doc-label">Testing Window</span><span class="doc-value">Weekdays 08:00 to 18:00 UTC, 17 March to 28 March 2025</span></div>
                <div class="doc-field"><span class="doc-label">Emergency Contact</span><span class="doc-value">IT Director: James Carlin, +44 7911 234567</span></div>
            </div>

            <div class="doc-section">
                <h4>Engagement Objective</h4>
                <div class="doc-field"><span class="doc-label">Primary Goal</span><span class="doc-value">Identify vulnerabilities in the publicly accessible web application and external network perimeter.</span></div>
                <div class="doc-field"><span class="doc-label">Report Deliverable</span><span class="doc-value">Technical findings report with CVSS scores and remediation recommendations, due within 5 business days of test completion.</span></div>
            </div>

            <div class="question-block" id="q-panel1">
                <p>After reviewing the brief, confirm your understanding: <strong>Who signed the authorisation to conduct this penetration test on behalf of Hartfield Retail Ltd?</strong></p>
                <div class="choice-group" id="cg-panel1">
                    <button class="choice-btn" onclick="checkPanel1(this, false)">James Carlin, IT Director</button>
                    <button class="choice-btn" onclick="checkPanel1(this, true)">Sarah Okoye, Chief Information Officer</button>
                    <button class="choice-btn" onclick="checkPanel1(this, false)">The penetration testing firm</button>
                    <button class="choice-btn" onclick="checkPanel1(this, false)">Both parties jointly with no single authoriser</button>
                </div>
                <div class="feedback-msg" id="fb-panel1"></div>
                <button class="continue-btn" id="cont-panel1" onclick="advanceToPanel(2)">Continue to Scope Review <span>&#8594;</span></button>
            </div>

        </div>
    </div>

    <!-- ========== PANEL 2: SCOPE REVIEW ========== -->
    <div class="panel" id="panel-2">
        <div class="panel-header">
            <span class="panel-tag">Stage 2</span>
            <h3>Scope Document — Hartfield Retail Ltd</h3>
        </div>
        <div class="panel-body">

            <div class="doc-section">
                <h4>In-Scope Systems</h4>
                <table class="scope-table" id="scope-table">
                    <thead>
                        <tr>
                            <th>Target</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Your Classification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>shop.hartfield-retail.co.uk</code></td>
                            <td>Primary customer-facing e-commerce platform</td>
                            <td class="in">IN SCOPE</td>
                            <td><button class="choice-btn" id="scope-btn-0" style="padding:5px 12px;font-size:0.8rem;" onclick="classifyScope(0, true)">Confirm In Scope</button></td>
                        </tr>
                        <tr>
                            <td><code>admin.hartfield-retail.co.uk</code></td>
                            <td>Internal admin portal (accessible externally via VPN only)</td>
                            <td class="in">IN SCOPE</td>
                            <td><button class="choice-btn" id="scope-btn-1" style="padding:5px 12px;font-size:0.8rem;" onclick="classifyScope(1, true)">Confirm In Scope</button></td>
                        </tr>
                        <tr>
                            <td><code>185.12.44.0/28</code></td>
                            <td>External IP range for Hartfield hosted services</td>
                            <td class="in">IN SCOPE</td>
                            <td><button class="choice-btn" id="scope-btn-2" style="padding:5px 12px;font-size:0.8rem;" onclick="classifyScope(2, true)">Confirm In Scope</button></td>
                        </tr>
                        <tr>
                            <td><code>payments.hartfield-retail.co.uk</code></td>
                            <td>Hosted by third-party processor PayVault Ltd — NOT owned by client</td>
                            <td class="out">OUT OF SCOPE</td>
                            <td><button class="choice-btn" id="scope-btn-3" style="padding:5px 12px;font-size:0.8rem;" onclick="classifyScope(3, false)">Flag as Out of Scope</button></td>
                        </tr>
                        <tr>
                            <td><code>mail.hartfield-retail.co.uk</code></td>
                            <td>Email gateway — managed by third-party provider MailEdge</td>
                            <td class="out">OUT OF SCOPE</td>
                            <td><button class="choice-btn" id="scope-btn-4" style="padding:5px 12px;font-size:0.8rem;" onclick="classifyScope(4, false)">Flag as Out of Scope</button></td>
                        </tr>
                        <tr>
                            <td><code>192.168.0.0/16</code></td>
                            <td>Internal RFC-1918 address space — internal network, not reachable externally</td>
                            <td class="out">OUT OF SCOPE</td>
                            <td><button class="choice-btn" id="scope-btn-5" style="padding:5px 12px;font-size:0.8rem;" onclick="classifyScope(5, false)">Flag as Out of Scope</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="doc-section">
                <h4>Permitted Techniques</h4>
                <div class="doc-field"><span class="doc-label">Allowed</span><span class="doc-value">Network scanning, web application testing, automated vulnerability scanning, manual exploitation of discovered vulnerabilities on in-scope targets only.</span></div>
                <div class="doc-field"><span class="doc-label">Prohibited</span><span class="doc-value">Social engineering of any kind, physical access attempts, denial-of-service testing, accessing out-of-scope systems even if reachable from in-scope targets.</span></div>
            </div>

            <div class="feedback-msg" id="fb-panel2"></div>
            <button class="continue-btn" id="cont-panel2" onclick="advanceToPanel(3)">Continue to Action Log <span>&#8594;</span></button>

        </div>
    </div>

    <!-- ========== PANEL 3: ACTION LOG ========== -->
    <div class="panel" id="panel-3">
        <div class="panel-header">
            <span class="panel-tag">Stage 3</span>
            <h3>Tester Action Log — Day 1 (17 March 2025)</h3>
        </div>
        <div class="panel-body">

            <div class="doc-section">
                <h4>Recorded Actions</h4>

                <div class="log-entry">
                    <span class="log-time">08:14 UTC</span>
                    <span class="log-desc">Nmap SYN scan, all ports, OS detection enabled.</span>
                    <span class="log-target">185.12.44.0/28</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">08:47 UTC</span>
                    <span class="log-desc">Nikto web vulnerability scan launched.</span>
                    <span class="log-target">shop.hartfield-retail.co.uk</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">09:23 UTC</span>
                    <span class="log-desc">Manual SQL injection testing on login form.</span>
                    <span class="log-target">shop.hartfield-retail.co.uk/login</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">10:05 UTC</span>
                    <span class="log-desc">Followed redirect from checkout page. Began port scan.</span>
                    <span class="log-target">payments.hartfield-retail.co.uk</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">10:38 UTC</span>
                    <span class="log-desc">Directory brute-force enumeration.</span>
                    <span class="log-target">admin.hartfield-retail.co.uk</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">11:15 UTC</span>
                    <span class="log-desc">Phishing email sent to IT staff to test awareness.</span>
                    <span class="log-target">staff@hartfield-retail.co.uk</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">12:02 UTC</span>
                    <span class="log-desc">Burp Suite active scan on all endpoints.</span>
                    <span class="log-target">shop.hartfield-retail.co.uk</span>
                </div>
                <div class="log-entry">
                    <span class="log-time">14:30 UTC</span>
                    <span class="log-desc">Discovered open port 8080 on mail server. Initiated web request to explore service.</span>
                    <span class="log-target">mail.hartfield-retail.co.uk</span>
                </div>
            </div>

            <div class="question-block" id="q-panel3">
                <p>Review the log above carefully. <strong>How many of the eight recorded actions violate the agreed scope or prohibited techniques?</strong> Count every action that targets an out-of-scope system or uses a prohibited method.</p>
                <div class="choice-group" id="cg-panel3">
                    <button class="choice-btn" onclick="checkPanel3(this, false)">1 violation</button>
                    <button class="choice-btn" onclick="checkPanel3(this, false)">2 violations</button>
                    <button class="choice-btn" onclick="checkPanel3(this, true)">3 violations</button>
                    <button class="choice-btn" onclick="checkPanel3(this, false)">4 violations</button>
                </div>
                <div class="feedback-msg" id="fb-panel3"></div>
                <button class="continue-btn" id="cont-panel3" onclick="completeReview()">Complete Review <span>&#8594;</span></button>
            </div>

        </div>
    </div>

    <!-- FLAG SECTION -->
    <div class="flag-section" id="flag-section">
        <h2>&#10003; Engagement Review Complete</h2>
        <p>You correctly identified the authorising party, classified all six scope entries accurately, and flagged the three log violations: an out-of-scope port scan (payments processor), a prohibited social engineering action (phishing email), and an out-of-scope service probe (mail gateway). Well done.</p>
        <div class="flag-display" id="flag-display">CBX{scope_confirmed}</div>
        <p class="flag-note">Copy this flag and return to the CYBRIXEN room to complete the practical task.</p>
    </div>

</div><!-- /page-wrapper -->

<!-- ========== TUTORIAL SYSTEM ========== -->
<div id="spotlight-overlay">
    <div id="spotlight-box"></div>
    <div id="tutorial-tooltip">
        <h4 id="tt-title"></h4>
        <p id="tt-body"></p>
        <div class="tooltip-actions">
            <button class="tt-skip" onclick="skipTutorial()">Skip Tutorial</button>
            <button class="tt-next" onclick="nextTutorialStep()">Next</button>
        </div>
    </div>
</div>

<div id="tut-complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You are ready to start the review. Work through all three stages in order. Flag any violations you find, and the flag will be revealed when you are done.</p>
        <button class="modal-start-btn" onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
// ========== STATE ==========
var state = {
    panel1Done: false,
    panel2Scores: [null, null, null, null, null, null],
    panel2Done: false,
    panel3Done: false
};

var tutStep = 0;
var tutActive = false;
var firstLoad = true;

// ========== TUTORIAL STEPS ==========
var tutSteps = [
    {
        id: 'mission-card',
        title: 'Mission Briefing',
        body: 'Start here. This briefing describes the engagement context: who the client is, what you are reviewing, and what you need to accomplish. Read it before moving forward.'
    },
    {
        id: 'progress-tracker',
        title: 'Progress Tracker',
        body: 'This shows your position across the three review stages. Each stage unlocks only after the previous one is completed correctly. You must work through them in order.'
    },
    {
        id: 'status-bar',
        title: 'Status Bar',
        body: 'This bar tells you what to do next. It updates after each correct action to guide you through the review. Check it whenever you are unsure what is expected.'
    },
    {
        id: 'panel-1',
        title: 'Stage 1: Client Brief',
        body: 'The client brief is your starting point. Read the engagement details carefully, particularly who signed the authorisation. Then answer the question at the bottom of this panel to unlock Stage 2.'
    }
];

// ========== TUTORIAL LOGIC ==========
function startTutorial() {
    tutStep = 0;
    tutActive = true;
    document.getElementById('spotlight-overlay').classList.add('active');
    document.getElementById('panel-1').classList.add('active');
    showTutStep();
}

function showTutStep() {
    if (tutStep >= tutSteps.length) {
        endTutorial();
        return;
    }
    var step = tutSteps[tutStep];
    var el = document.getElementById(step.id);
    if (!el) { tutStep++; showTutStep(); return; }

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(function() { positionSpotlight(el, step); }, 320);
}

function positionSpotlight(el, step) {
    var r = el.getBoundingClientRect();
    var pad = 8;
    var box = document.getElementById('spotlight-box');
    box.style.top = (r.top - pad) + 'px';
    box.style.left = (r.left - pad) + 'px';
    box.style.width = (r.width + pad * 2) + 'px';
    box.style.height = (r.height + pad * 2) + 'px';

    var tt = document.getElementById('tutorial-tooltip');
    document.getElementById('tt-title').textContent = step.title;
    document.getElementById('tt-body').textContent = step.body;

    var ttW = 340, ttH = 160, vW = window.innerWidth, vH = window.innerHeight;
    var top, left;

    if (r.bottom + pad + ttH + 16 < vH) {
        top = r.bottom + pad + 12;
    } else {
        top = r.top - pad - ttH - 12;
    }
    left = Math.max(12, Math.min(r.left, vW - ttW - 12));
    if (top < 12) top = 12;

    tt.style.top = top + 'px';
    tt.style.left = left + 'px';
}

function nextTutorialStep() {
    tutStep++;
    showTutStep();
}

function skipTutorial() {
    endTutorial();
}

function endTutorial() {
    document.getElementById('spotlight-overlay').classList.remove('active');
    tutActive = false;
    document.getElementById('tut-complete-modal').classList.add('show');
}

function closeTutorialModal() {
    document.getElementById('tut-complete-modal').classList.remove('show');
}

window.addEventListener('resize', function() {
    if (tutActive && tutStep < tutSteps.length) {
        var el = document.getElementById(tutSteps[tutStep].id);
        if (el) positionSpotlight(el, tutSteps[tutStep]);
    }
});

// ========== PANEL 1: CLIENT BRIEF ==========
function checkPanel1(btn, correct) {
    var btns = document.querySelectorAll('#cg-panel1 .choice-btn');
    btns.forEach(function(b) { b.disabled = true; });

    var fb = document.getElementById('fb-panel1');
    if (correct) {
        btn.classList.add('selected-correct');
        fb.textContent = 'Correct. Sarah Okoye, as CIO, holds the authority to commission penetration testing on behalf of the organisation. The IT Director is an emergency contact only and did not sign the authorisation.';
        fb.className = 'feedback-msg ok show';
        state.panel1Done = true;
        document.getElementById('cont-panel1').classList.add('show');
        setStatus('Stage 1 complete. Continue to review the scope document.');
    } else {
        btn.classList.add('selected-wrong');
        fb.textContent = 'Not quite. Review the Requested By and Emergency Contact fields in the brief. Only one person formally commissioned this engagement.';
        fb.className = 'feedback-msg err show';
        setTimeout(function() {
            btns.forEach(function(b) { b.disabled = false; });
            btn.classList.remove('selected-wrong');
        }, 1400);
    }
}

// ========== PANEL 2: SCOPE REVIEW ==========
var scopeAnswers = [true, true, true, false, false, false];

function classifyScope(idx, claimedInScope) {
    var correct = (claimedInScope === scopeAnswers[idx]);
    var btn = document.getElementById('scope-btn-' + idx);

    if (correct) {
        btn.classList.add('selected-correct');
        btn.disabled = true;
        btn.textContent = claimedInScope ? '✓ In Scope' : '✓ Out of Scope';
        state.panel2Scores[idx] = true;
        checkPanel2Complete();
    } else {
        btn.classList.add('selected-wrong');
        setTimeout(function() {
            btn.classList.remove('selected-wrong');
        }, 1000);
    }
}

function checkPanel2Complete() {
    if (state.panel2Scores.every(function(v) { return v === true; })) {
        state.panel2Done = true;
        var fb = document.getElementById('fb-panel2');
        fb.textContent = 'All six entries correctly classified. You identified both in-scope targets and the three out-of-scope systems: the third-party payment processor, the externally managed mail gateway, and the internal RFC-1918 range.';
        fb.className = 'feedback-msg ok show';
        document.getElementById('cont-panel2').classList.add('show');
        setStatus('Stage 2 complete. Continue to review the tester action log.');
    }
}

// ========== PANEL 3: ACTION LOG ==========
// Violations: 10:05 (payments - out of scope), 11:15 (phishing - prohibited), 14:30 (mail - out of scope)
function checkPanel3(btn, correct) {
    var btns = document.querySelectorAll('#cg-panel3 .choice-btn');
    btns.forEach(function(b) { b.disabled = true; });

    var fb = document.getElementById('fb-panel3');
    if (correct) {
        btn.classList.add('selected-correct');
        fb.textContent = 'Correct. There are exactly 3 violations: (1) the 10:05 port scan of payments.hartfield-retail.co.uk, a third-party system outside scope; (2) the 11:15 phishing email, which is explicitly prohibited social engineering; and (3) the 14:30 probe of mail.hartfield-retail.co.uk, also outside scope. The remaining five actions target in-scope systems with permitted techniques.';
        fb.className = 'feedback-msg ok show';
        state.panel3Done = true;
        document.getElementById('cont-panel3').classList.add('show');
        setStatus('Stage 3 complete. Finalise the review to retrieve the flag.');
    } else {
        btn.classList.add('selected-wrong');
        fb.textContent = 'Not quite. Count each action that either targets an out-of-scope system or uses a technique listed as prohibited in the scope document.';
        fb.className = 'feedback-msg err show';
        setTimeout(function() {
            btns.forEach(function(b) { b.disabled = false; });
            btn.classList.remove('selected-wrong');
            fb.className = 'feedback-msg';
        }, 2000);
    }
}

// ========== PANEL ADVANCE ==========
function advanceToPanel(num) {
    for (var i = 1; i <= 3; i++) {
        document.getElementById('panel-' + i).classList.remove('active');
        document.getElementById('step-' + i).classList.remove('active');
    }

    for (var j = 1; j < num; j++) {
        document.getElementById('step-' + j).classList.add('done');
    }

    document.getElementById('panel-' + num).classList.add('active');
    document.getElementById('step-' + num).classList.add('active');
    document.getElementById('panel-' + num).scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function completeReview() {
    for (var i = 1; i <= 3; i++) {
        document.getElementById('step-' + i).classList.remove('active');
        document.getElementById('step-' + i).classList.add('done');
    }
    document.getElementById('flag-section').classList.add('show');
    document.getElementById('flag-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
    setStatus('Review complete. All three stages passed. Retrieve your flag below.');
}

// ========== UTILITY ==========
function setStatus(msg) {
    document.getElementById('status-text').textContent = msg;
}

// ========== AUTO-START TUTORIAL ==========
window.addEventListener('load', function() {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
