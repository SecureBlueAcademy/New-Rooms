<?php
// scoping-roe-practical.php — SOW Review Console
// CYBRIXEN Practical — Scoping & Rules of Engagement
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SOW Review Console | CYBRIXEN</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<style>
:root {
    --bg-primary:      #0b0f1a;
    --bg-secondary:    #12182b;
    --bg-surface:      #161d36;
    --text-primary:    #e6e9f2;
    --text-secondary:  #aab0d6;
    --text-muted:      #7c83b6;
    --accent-primary:  #6ae3ff;
    --accent-secondary:#8b7bff;
    --success:         #3dff9a;
    --error:           #ff5c5c;
    --warning:         #ffd36a;
    --border-default:  rgba(255,255,255,0.08);
    --glow-accent:     0 0 12px rgba(106,227,255,0.35);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    min-height: 100vh;
    line-height: 1.6;
}

/* ===== HEADER ===== */
.page-header {
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    padding: 18px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
}
.header-title h1 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--accent-primary);
    letter-spacing: 0.04em;
}
.header-title p {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 2px;
}
.tutorial-btn {
    background: transparent;
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    font-family: inherit;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
    letter-spacing: 0.03em;
}
.tutorial-btn:hover {
    background: rgba(106,227,255,0.08);
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION SECTION ===== */
.mission-briefing {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 24px 28px;
    margin: 28px auto;
    max-width: 960px;
}
.mission-briefing h2 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--accent-primary);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 12px;
}
.mission-briefing p {
    font-size: 0.93rem;
    color: var(--text-secondary);
    margin-bottom: 10px;
}
.mission-briefing p:last-child { margin-bottom: 0; }

/* ===== MAIN LAYOUT ===== */
.main-container {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 24px 60px;
}

/* ===== TABS ===== */
.tab-nav {
    display: flex;
    gap: 4px;
    border-bottom: 1px solid var(--border-default);
    margin-bottom: 24px;
}
.tab-btn {
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    color: var(--text-muted);
    font-family: inherit;
    font-size: 0.88rem;
    font-weight: 500;
    padding: 12px 20px;
    cursor: pointer;
    transition: color 0.2s, border-color 0.2s;
    position: relative;
    bottom: -1px;
}
.tab-btn:hover { color: var(--text-secondary); }
.tab-btn.active {
    color: var(--accent-primary);
    border-bottom-color: var(--accent-primary);
}
.tab-btn.completed::after {
    content: ' ✓';
    color: var(--success);
    font-size: 0.8rem;
}
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* ===== DOCUMENT CARD ===== */
.doc-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 28px 32px;
    margin-bottom: 20px;
}
.doc-card h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border-default);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-family: 'JetBrains Mono', monospace;
}
.doc-section {
    margin-bottom: 20px;
}
.doc-section h4 {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--accent-secondary);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 8px;
}
.doc-section p, .doc-section li {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 4px;
}
.doc-section ul { padding-left: 20px; }
.doc-section li { margin-bottom: 3px; }
.doc-highlight {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--accent-primary);
    background: rgba(106,227,255,0.07);
    border: 1px solid rgba(106,227,255,0.15);
    border-radius: 4px;
    padding: 2px 6px;
    display: inline-block;
}
.doc-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
    margin-top: 8px;
}
.doc-table th {
    background: var(--bg-secondary);
    color: var(--text-secondary);
    font-weight: 600;
    padding: 10px 14px;
    text-align: left;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: 1px solid var(--border-default);
}
.doc-table td {
    padding: 9px 14px;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    vertical-align: top;
}
.doc-table td.in-scope { color: var(--success); font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; }
.doc-table td.out-scope { color: var(--error); font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; }
.doc-table tr:nth-child(even) td { background: rgba(255,255,255,0.015); }

/* ===== CHECKPOINT FORM ===== */
.checkpoint-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 24px 28px;
    margin-top: 24px;
}
.checkpoint-card h3 {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--warning);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 18px;
}
.checkpoint {
    margin-bottom: 18px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--border-default);
}
.checkpoint:last-child { margin-bottom: 0; border-bottom: none; padding-bottom: 0; }
.checkpoint label {
    display: block;
    font-size: 0.88rem;
    color: var(--text-secondary);
    margin-bottom: 8px;
    font-weight: 500;
}
.checkpoint-row {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}
.checkpoint input {
    flex: 1;
    min-width: 180px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.88rem;
    padding: 9px 14px;
    outline: none;
    transition: border-color 0.2s;
}
.checkpoint input:focus { border-color: var(--accent-primary); }
.checkpoint input.correct { border-color: var(--success); background: rgba(61,255,154,0.05); }
.checkpoint input.incorrect { border-color: var(--error); background: rgba(255,92,92,0.05); }
.check-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    font-family: inherit;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 9px 18px;
    border-radius: 6px;
    cursor: pointer;
    transition: border-color 0.2s, color 0.2s;
    white-space: nowrap;
}
.check-btn:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
.checkpoint-feedback {
    font-size: 0.82rem;
    margin-top: 6px;
    min-height: 18px;
}
.checkpoint-feedback.ok { color: var(--success); }
.checkpoint-feedback.bad { color: var(--error); }

/* ===== STATUS BAR ===== */
.status-bar {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}
.status-bar p {
    font-size: 0.85rem;
    color: var(--text-muted);
}
.progress-pips {
    display: flex;
    gap: 8px;
    margin-left: auto;
}
.pip {
    width: 28px;
    height: 8px;
    border-radius: 4px;
    background: var(--border-default);
    transition: background 0.3s;
}
.pip.done { background: var(--success); }

/* ===== FLAG REVEAL ===== */
.flag-area {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 36px 28px;
    text-align: center;
    margin-top: 32px;
    display: none;
}
.flag-area.visible { display: block; }
.flag-area h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--success);
    margin-bottom: 10px;
}
.flag-area p {
    font-size: 0.88rem;
    color: var(--text-secondary);
    margin-bottom: 20px;
}
.flag-display {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--success);
    background: rgba(61,255,154,0.07);
    border: 1px solid rgba(61,255,154,0.25);
    border-radius: 8px;
    padding: 14px 28px;
    display: inline-block;
    letter-spacing: 0.04em;
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}

/* ===== TUTORIAL OVERLAY ===== */
#tutorial-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9000;
    pointer-events: none;
}
#tutorial-overlay.active { display: block; }
#spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.78);
    transition: top 0.25s ease, left 0.25s ease, width 0.25s ease, height 0.25s ease;
    pointer-events: none;
    z-index: 9001;
}
#tutorial-tooltip {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 18px 22px;
    max-width: 320px;
    z-index: 9010;
    pointer-events: all;
    box-shadow: 0 4px 24px rgba(0,0,0,0.6), var(--glow-accent);
}
#tutorial-tooltip h4 {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--accent-primary);
    margin-bottom: 8px;
}
#tutorial-tooltip p {
    font-size: 0.83rem;
    color: var(--text-secondary);
    line-height: 1.55;
    margin-bottom: 14px;
}
.tooltip-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}
.btn-next {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 8px 18px;
    cursor: pointer;
}
.btn-skip {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-muted);
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.82rem;
    padding: 8px 14px;
    cursor: pointer;
}

/* ===== TUTORIAL COMPLETE MODAL ===== */
#tut-complete-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.78);
    z-index: 9500;
    align-items: center;
    justify-content: center;
}
#tut-complete-modal.active { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 36px 40px;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 0 40px rgba(106,227,255,0.15);
}
.modal-card h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--accent-primary);
    margin-bottom: 12px;
}
.modal-card p {
    font-size: 0.88rem;
    color: var(--text-secondary);
    margin-bottom: 22px;
    line-height: 1.6;
}
.modal-card button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 700;
    padding: 12px 28px;
    cursor: pointer;
}

/* ===== PRACTICAL LAUNCH BUTTON ===== */
.practical-launch-wrapper { text-align: center; margin: 35px 0 25px 0; }
.practical-launch-btn {
    display: inline-flex; align-items: center; gap: 12px;
    padding: 16px 36px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary, #00d4ff);
    border-radius: 10px; color: var(--accent-primary, #00d4ff);
    font-size: 1.05rem; font-weight: 600; text-decoration: none;
    letter-spacing: 0.03em; position: relative; overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 0 18px rgba(0,212,255,0.2), inset 0 0 20px rgba(0,212,255,0.03);
}
.practical-launch-btn:hover {
    background: linear-gradient(135deg, #0f2027, #1f4a5e, #0f2027);
    box-shadow: 0 0 30px rgba(0,212,255,0.4), inset 0 0 25px rgba(0,212,255,0.06);
    transform: translateY(-2px); color: #33ddff;
}
.launch-note { margin-top: 12px; font-size: 0.85rem; color: var(--text-secondary); font-style: italic; }
</style>
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="page-header">
    <div class="header-title">
        <h1>SOW REVIEW CONSOLE</h1>
        <p>Scoping &amp; Rules of Engagement — Pre-Engagement Review</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn" onclick="startTutorial()">View Tutorial</button>
</header>

<!-- ===== DESCRIPTION / MISSION BRIEFING ===== -->
<div class="main-container">
    <div class="mission-briefing" id="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>You are a penetration tester at CybrAxis Security. A new engagement has been assigned: an external and internal network assessment for Meridian Financial Group. Before your team begins any testing, your team lead has asked you to review the signed Statement of Work and Rules of Engagement documents.</p>
        <p>Your task is to work through each document panel, answer the four checkpoint questions correctly, and confirm your review. The engagement authorization code (your flag) will be released once all checkpoints pass.</p>
        <p>Read carefully. Scope documents always hide the details that matter most in the fine print.</p>
    </div>

    <!-- STATUS BAR -->
    <div class="status-bar" id="status-bar">
        <p id="status-text">Checkpoints completed: <strong>0 / 4</strong></p>
        <div class="progress-pips">
            <div class="pip" id="pip-1"></div>
            <div class="pip" id="pip-2"></div>
            <div class="pip" id="pip-3"></div>
            <div class="pip" id="pip-4"></div>
        </div>
    </div>

    <!-- ===== TABS ===== -->
    <div class="tab-nav" id="tab-nav">
        <button class="tab-btn active" id="tab-btn-sow"    onclick="switchTab('sow')">Statement of Work</button>
        <button class="tab-btn"        id="tab-btn-roe"    onclick="switchTab('roe')">Rules of Engagement</button>
        <button class="tab-btn"        id="tab-btn-scope"  onclick="switchTab('scope')">Scope Table</button>
        <button class="tab-btn"        id="tab-btn-checks" onclick="switchTab('checks')">Checkpoints</button>
    </div>

    <!-- ===== TAB: STATEMENT OF WORK ===== -->
    <div class="tab-panel active" id="panel-sow">
        <div class="doc-card" id="sow-card">
            <h3>Statement of Work — Meridian Financial Group</h3>

            <div class="doc-section">
                <h4>Client</h4>
                <p>Meridian Financial Group Ltd, 14 Alder Court, London, EC2V 8RF</p>
                <p>Authorized signatory: <span class="doc-highlight">Eleanor Voss</span>, Chief Information Security Officer</p>
            </div>

            <div class="doc-section">
                <h4>Service Provider</h4>
                <p>CybrAxis Security Ltd, 9 Forge Lane, Manchester, M1 2XY</p>
                <p>Authorized signatory: Daniel Reeves, Managing Director</p>
            </div>

            <div class="doc-section">
                <h4>Engagement Type</h4>
                <p>Grey box external and internal network penetration test. The client will provide tester accounts with standard employee access privileges only. No administrative credentials will be provided in advance.</p>
            </div>

            <div class="doc-section">
                <h4>Engagement Dates</h4>
                <p>Start date: <span class="doc-highlight">Monday 7 July 2025</span></p>
                <p>End date: Friday 11 July 2025</p>
                <p>Report delivery: Wednesday 16 July 2025</p>
            </div>

            <div class="doc-section">
                <h4>Deliverables</h4>
                <ul>
                    <li>Executive summary report (non-technical, suitable for board review)</li>
                    <li>Technical findings report with CVSS scores and evidence</li>
                    <li>Remediation recommendations with priority ratings</li>
                    <li>Retest confirmation letter (issued within 30 days of report delivery)</li>
                </ul>
            </div>

            <div class="doc-section">
                <h4>Commercial Terms</h4>
                <p>Total engagement value: £18,500 (exclusive of VAT). 50% due on signing, 50% due on report delivery. Payment terms: 30 days from invoice date.</p>
            </div>
        </div>
    </div>

    <!-- ===== TAB: RULES OF ENGAGEMENT ===== -->
    <div class="tab-panel" id="panel-roe">
        <div class="doc-card" id="roe-card">
            <h3>Rules of Engagement — Meridian Financial Group</h3>

            <div class="doc-section">
                <h4>Testing Window</h4>
                <p>All active testing activity is permitted only during the following window:</p>
                <p><span class="doc-highlight">08:00 to 18:00 BST, Monday to Friday</span></p>
                <p>No testing of any kind may occur outside this window without a written amendment signed by the client CISO. This includes automated scanning, manual exploitation, and passive reconnaissance against in-scope assets.</p>
            </div>

            <div class="doc-section">
                <h4>Emergency Contact</h4>
                <p>In the event of any system instability, unintended outage, or activity requiring immediate cessation of testing, the tester must contact:</p>
                <p><strong>Name:</strong> <span class="doc-highlight">Marcus Okafor</span></p>
                <p><strong>Title:</strong> Head of IT Infrastructure</p>
                <p><strong>Mobile:</strong> +44 7712 334 891 (available during testing window)</p>
                <p>If Marcus Okafor is unreachable, escalate to Eleanor Voss (CISO) at +44 7890 112 456. Do not continue testing if neither contact can be reached.</p>
            </div>

            <div class="doc-section">
                <h4>Permitted Techniques</h4>
                <ul>
                    <li>Port scanning and service enumeration against in-scope IP ranges</li>
                    <li>Vulnerability scanning using industry-standard tools (Nessus, OpenVAS)</li>
                    <li>Manual exploitation of identified vulnerabilities</li>
                    <li>Credential testing using supplied tester accounts only</li>
                    <li>Internal network pivoting from compromised in-scope hosts</li>
                    <li>Password cracking against captured hashes (offline only)</li>
                </ul>
            </div>

            <div class="doc-section">
                <h4>Forbidden Actions</h4>
                <ul>
                    <li>Denial-of-service or any testing designed to disrupt service availability</li>
                    <li>Testing of any out-of-scope system, even if reachable from an in-scope host</li>
                    <li>Social engineering of Meridian Financial Group staff</li>
                    <li>Physical access testing of any client premises</li>
                    <li>Data exfiltration of live client data beyond minimal proof-of-concept evidence</li>
                    <li>Any testing outside the agreed testing window without written amendment</li>
                </ul>
            </div>

            <div class="doc-section">
                <h4>Escalation Procedure</h4>
                <p>If the tester discovers evidence of an active third-party intrusion or an ongoing incident during the engagement, testing must stop immediately and the emergency contact must be notified within 15 minutes of discovery.</p>
            </div>
        </div>
    </div>

    <!-- ===== TAB: SCOPE TABLE ===== -->
    <div class="tab-panel" id="panel-scope">
        <div class="doc-card" id="scope-card">
            <h3>Scope Definition — Meridian Financial Group</h3>

            <div class="doc-section">
                <h4>In-Scope Assets</h4>
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>Asset / Range</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="in-scope">10.10.0.0/24</td>
                            <td>Internal subnet</td>
                            <td>Primary office LAN, workstations and printers</td>
                        </tr>
                        <tr>
                            <td class="in-scope">10.10.1.0/24</td>
                            <td>Internal subnet</td>
                            <td>Server VLAN, application and file servers</td>
                        </tr>
                        <tr>
                            <td class="in-scope">185.24.77.0/28</td>
                            <td>External IP range</td>
                            <td>Public-facing web and mail infrastructure</td>
                        </tr>
                        <tr>
                            <td class="in-scope">portal.meridianfg.co.uk</td>
                            <td>Web application</td>
                            <td>Client-facing investment portal</td>
                        </tr>
                        <tr>
                            <td class="in-scope">vpn.meridianfg.co.uk</td>
                            <td>VPN gateway</td>
                            <td>Remote access endpoint</td>
                        </tr>
                        <tr>
                            <td class="in-scope">mail.meridianfg.co.uk</td>
                            <td>Mail server</td>
                            <td>External SMTP/IMAP endpoint only</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="doc-section">
                <h4>Out-of-Scope Assets</h4>
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>Asset / Range</th>
                            <th>Type</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="out-scope">10.10.2.0/24</td>
                            <td>Internal subnet</td>
                            <td>Payment processing VLAN — PCI DSS restricted, requires separate authorization</td>
                        </tr>
                        <tr>
                            <td class="out-scope">hr.meridianfg.internal</td>
                            <td>Internal host</td>
                            <td>HR system containing employee PII — explicitly excluded</td>
                        </tr>
                        <tr>
                            <td class="out-scope">backup.meridianfg.internal</td>
                            <td>Internal host</td>
                            <td>Tape backup controller — critical infrastructure, do not touch</td>
                        </tr>
                        <tr>
                            <td class="out-scope">*.salesforce.com</td>
                            <td>Third-party SaaS</td>
                            <td>Salesforce infrastructure — third-party authorization required separately</td>
                        </tr>
                        <tr>
                            <td class="out-scope">aws.amazon.com (shared)</td>
                            <td>Cloud provider</td>
                            <td>Shared AWS environment — not owned by client, not authorized</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="doc-section">
                <h4>Pivoting Rules</h4>
                <p>If internal pivoting from a compromised in-scope host reveals connectivity to <span class="doc-highlight">10.10.2.0/24</span> or any out-of-scope host, the tester must stop at that boundary, document the finding, and report reachability as a network segmentation issue. No active testing of out-of-scope hosts is permitted under any circumstances.</p>
            </div>
        </div>
    </div>

    <!-- ===== TAB: CHECKPOINTS ===== -->
    <div class="tab-panel" id="panel-checks">
        <div class="checkpoint-card" id="checkpoint-card">
            <h3>Pre-Engagement Review Checkpoints</h3>

            <!-- Checkpoint 1 -->
            <div class="checkpoint" id="cp-wrap-1">
                <label for="cp1">1. What is the name of the client's emergency contact who must be called to halt testing?</label>
                <div class="checkpoint-row">
                    <input type="text" id="cp1" placeholder="First and last name" autocomplete="off"/>
                    <button class="check-btn" onclick="checkAnswer(1)">Check</button>
                </div>
                <div class="checkpoint-feedback" id="fb-1"></div>
            </div>

            <!-- Checkpoint 2 -->
            <div class="checkpoint" id="cp-wrap-2">
                <label for="cp2">2. Which internal subnet is out of scope due to PCI DSS restrictions?</label>
                <div class="checkpoint-row">
                    <input type="text" id="cp2" placeholder="e.g. 10.x.x.x/xx" autocomplete="off"/>
                    <button class="check-btn" onclick="checkAnswer(2)">Check</button>
                </div>
                <div class="checkpoint-feedback" id="fb-2"></div>
            </div>

            <!-- Checkpoint 3 -->
            <div class="checkpoint" id="cp-wrap-3">
                <label for="cp3">3. What are the permitted testing hours? (format: HH:MM to HH:MM)</label>
                <div class="checkpoint-row">
                    <input type="text" id="cp3" placeholder="HH:MM to HH:MM" autocomplete="off"/>
                    <button class="check-btn" onclick="checkAnswer(3)">Check</button>
                </div>
                <div class="checkpoint-feedback" id="fb-3"></div>
            </div>

            <!-- Checkpoint 4 -->
            <div class="checkpoint" id="cp-wrap-4">
                <label for="cp4">4. Which domain is in scope for testing as the client-facing investment portal?</label>
                <div class="checkpoint-row">
                    <input type="text" id="cp4" placeholder="e.g. sub.domain.co.uk" autocomplete="off"/>
                    <button class="check-btn" onclick="checkAnswer(4)">Check</button>
                </div>
                <div class="checkpoint-feedback" id="fb-4"></div>
            </div>
        </div>

        <!-- FLAG AREA -->
        <div class="flag-area" id="flag-area">
            <h3>Review Complete — Engagement Authorized</h3>
            <p>All four checkpoints passed. Your pre-engagement review is confirmed. The authorization code for this engagement has been released.</p>
            <div class="flag-display" id="flag-display">CBX{scope_confirmed}</div>
            <p style="margin-top:14px; font-size:0.82rem; color:var(--text-muted);">Copy this flag and enter it in the CYBRIXEN room to complete the task.</p>
        </div>
    </div>
</div>

<!-- ===== TUTORIAL OVERLAY ===== -->
<div id="tutorial-overlay">
    <div id="spotlight"></div>
    <div id="tutorial-tooltip">
        <h4 id="tt-title">Tutorial</h4>
        <p id="tt-body">Welcome to the tutorial.</p>
        <div class="tooltip-actions">
            <button class="btn-skip" onclick="skipTutorial()">Skip Tutorial</button>
            <button class="btn-next" id="btn-next" onclick="nextStep()">Next</button>
        </div>
    </div>
</div>

<!-- ===== TUTORIAL COMPLETE MODAL ===== -->
<div id="tut-complete-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You are ready to begin your pre-engagement review. Work through each document tab carefully before answering the checkpoint questions.</p>
        <button onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
// ===== STATE =====
const completed = { 1: false, 2: false, 3: false, 4: false };

// Accepted answers (case-insensitive, trimmed)
const answers = {
    1: ['marcus okafor', 'okafor', 'marcus'],
    2: ['10.10.2.0/24', '10.10.2.0'],
    3: ['08:00 to 18:00', '08:00-18:00', '8:00 to 18:00', '8:00-18:00', '08:00 to 18:00 bst'],
    4: ['portal.meridianfg.co.uk']
};

// ===== TABS =====
function switchTab(id) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('panel-' + id).classList.add('active');
    document.getElementById('tab-btn-' + id).classList.add('active');
}

// ===== CHECKPOINTS =====
function checkAnswer(n) {
    const input = document.getElementById('cp' + n);
    const fb    = document.getElementById('fb-' + n);
    const val   = input.value.trim().toLowerCase();

    if (answers[n].includes(val)) {
        input.classList.remove('incorrect');
        input.classList.add('correct');
        input.disabled = true;
        fb.textContent = 'Correct.';
        fb.className = 'checkpoint-feedback ok';
        document.getElementById('tab-btn-checks').classList.add('completed');
        completed[n] = true;
        updateProgress();
    } else {
        input.classList.remove('correct');
        input.classList.add('incorrect');
        fb.textContent = 'Incorrect. Review the documents and try again.';
        fb.className = 'checkpoint-feedback bad';
    }
}

function updateProgress() {
    const done = Object.values(completed).filter(Boolean).length;
    document.getElementById('status-text').innerHTML =
        'Checkpoints completed: <strong>' + done + ' / 4</strong>';
    for (let i = 1; i <= 4; i++) {
        document.getElementById('pip-' + i).classList.toggle('done', completed[i]);
    }
    if (done === 4) {
        document.getElementById('flag-area').classList.add('visible');
        document.getElementById('flag-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// ===== TUTORIAL STEPS =====
const tutorialSteps = [
    {
        targetId: 'mission-briefing',
        title: 'Mission Briefing',
        body: 'This section describes your role in the challenge. You are a penetration tester reviewing engagement documents before testing begins. Read this carefully before touching anything else.'
    },
    {
        targetId: 'tab-nav',
        title: 'Document Tabs',
        body: 'The console is divided into four tabs. The first two contain the Statement of Work and Rules of Engagement documents. The Scope Table tab shows all in-scope and out-of-scope assets in one view. Always read these before answering.'
    },
    {
        targetId: 'sow-card',
        title: 'Statement of Work',
        body: 'The SOW is the formal contract. It tells you who the client is, what dates the engagement covers, what you must deliver, and the commercial terms. The engagement dates and authorized signatory are always worth noting.'
    },
    {
        targetId: 'tab-btn-roe',
        title: 'Rules of Engagement Tab',
        body: 'Click this tab to read the RoE. It contains the testing window, emergency contact details, permitted techniques, and forbidden actions. These are the operational rules you must follow throughout the engagement.'
    },
    {
        targetId: 'tab-btn-scope',
        title: 'Scope Table Tab',
        body: 'Click this tab to see the full scope definition. In-scope assets are shown in cyan and out-of-scope assets in red. Anything red is off-limits even if you can reach it from an in-scope system.'
    },
    {
        targetId: 'tab-btn-checks',
        title: 'Checkpoints Tab',
        body: 'Once you have read all three document tabs, come here to answer the four checkpoint questions. Each answer comes directly from the documents. Type your answer and click Check to submit it.'
    },
    {
        targetId: 'status-bar',
        title: 'Progress Tracker',
        body: 'The four pips here light up green as you complete each checkpoint. All four must be correct before the engagement authorization code (your flag) is released.'
    }
];

let currentStep = 0;
let tutorialActive = false;

function startTutorial() {
    switchTab('sow');
    currentStep = 0;
    tutorialActive = true;
    document.getElementById('tutorial-overlay').classList.add('active');
    renderStep();
}

function renderStep() {
    const step = tutorialSteps[currentStep];
    document.getElementById('tt-title').textContent = step.title;
    document.getElementById('tt-body').textContent  = step.body;

    const isLast = currentStep === tutorialSteps.length - 1;
    document.getElementById('btn-next').textContent = isLast ? 'Finish' : 'Next';

    const el = document.getElementById(step.targetId);
    if (!el) { nextStep(); return; }

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => positionSpotlight(el), 300);
}

function positionSpotlight(el) {
    const rect    = el.getBoundingClientRect();
    const pad     = 8;
    const sl      = document.getElementById('spotlight');
    const tt      = document.getElementById('tutorial-tooltip');

    sl.style.top    = (rect.top    - pad) + 'px';
    sl.style.left   = (rect.left   - pad) + 'px';
    sl.style.width  = (rect.width  + pad * 2) + 'px';
    sl.style.height = (rect.height + pad * 2) + 'px';

    // Tooltip placement: prefer below, fall back to above
    const ttHeight = 170;
    const ttWidth  = 320;
    let top  = rect.bottom + pad + 10;
    let left = rect.left;

    if (top + ttHeight > window.innerHeight - 20) {
        top = rect.top - ttHeight - 10;
    }
    if (left + ttWidth > window.innerWidth - 20) {
        left = window.innerWidth - ttWidth - 20;
    }
    if (left < 10) left = 10;
    if (top  < 10) top  = 10;

    tt.style.top  = top  + 'px';
    tt.style.left = left + 'px';
}

function nextStep() {
    if (currentStep < tutorialSteps.length - 1) {
        currentStep++;
        renderStep();
    } else {
        endTutorial(true);
    }
}

function skipTutorial() {
    endTutorial(false);
}

function endTutorial(showModal) {
    tutorialActive = false;
    document.getElementById('tutorial-overlay').classList.remove('active');
    if (showModal) {
        document.getElementById('tut-complete-modal').classList.add('active');
    }
}

function closeTutorialModal() {
    document.getElementById('tut-complete-modal').classList.remove('active');
}

window.addEventListener('resize', () => {
    if (!tutorialActive) return;
    const step = tutorialSteps[currentStep];
    const el   = document.getElementById(step.targetId);
    if (el) positionSpotlight(el);
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>
</body>
</html>
