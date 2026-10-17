<?php
// ============================================================
// python-security-engineering-practical.php
// Standalone static practical: Log Triage Console
// HTML / CSS / vanilla JS only. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log Triage Console | Meridian Retail Co</title>
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

.mono { font-family: "JetBrains Mono", monospace; }

.page-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 20px 60px 20px;
}

/* ===== TOP HEADER ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 24px;
}
.top-header h1 {
    font-size: 1.6rem;
    margin: 0 0 6px 0;
    color: var(--accent-primary);
}
.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}
.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== DESCRIPTION SECTION ===== */
.briefing-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 24px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.briefing-box strong { color: var(--text-primary); }

/* ===== MAIN GRID ===== */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 20px;
}
@media (max-width: 900px) {
    .main-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.panel h3 {
    margin: 0 0 12px 0;
    font-size: 1rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Script panel */
#script-panel pre {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    font-size: 0.78rem;
    color: var(--text-secondary);
    overflow-x: auto;
    margin: 0 0 14px 0;
}
#script-panel .kw { color: var(--accent-secondary); }
#script-panel .fn { color: var(--accent-primary); }
#script-panel .str { color: var(--success); }
#script-panel .cm { color: var(--text-muted); }

.run-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    width: 100%;
}
.run-btn:hover { box-shadow: var(--glow-accent); }
.run-btn:disabled { opacity: 0.5; cursor: default; }

/* Console output panel */
#console-output {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px;
    height: 320px;
    overflow-y: auto;
    font-size: 0.75rem;
}
.log-line {
    padding: 4px 6px;
    border-radius: 4px;
    white-space: nowrap;
    color: var(--text-secondary);
}
.log-line.suspicious {
    background: rgba(255, 211, 106, 0.12);
    color: var(--warning);
}
.console-placeholder {
    color: var(--text-muted);
    font-size: 0.85rem;
    padding: 20px;
    text-align: center;
}

/* Filter panel */
#filter-controls .control-row {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 14px;
}
#filter-controls label {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 5px;
}
#filter-controls select {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 0.85rem;
    min-width: 180px;
}
.toggle-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 6px;
}
.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 20px;
    cursor: pointer;
}
.toggle-switch .knob {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 18px;
    height: 18px;
    background: var(--text-muted);
    border-radius: 50%;
    transition: left 0.2s ease, background 0.2s ease;
}
.toggle-switch.on .knob {
    left: 22px;
    background: var(--accent-primary);
}
#group-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
    margin-top: 10px;
    display: none;
}
#group-table th, #group-table td {
    border: 1px solid var(--border-default);
    padding: 6px 8px;
    text-align: left;
}
#group-table th { color: var(--text-muted); font-weight: 600; }
#group-table td.flagged { color: var(--warning); font-weight: 600; }

/* Root cause panel */
#root-cause-panel .control-row {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 14px;
}
#root-cause-panel select {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 0.85rem;
    min-width: 220px;
}
.confirm-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-secondary);
    color: var(--accent-secondary);
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
}
.confirm-btn:hover { box-shadow: 0 0 12px rgba(139,123,255,0.35); }

/* ===== FEEDBACK / STATUS AREA ===== */
#status-area {
    min-height: 26px;
    margin-bottom: 20px;
    font-size: 0.88rem;
}
.status-msg {
    padding: 10px 14px;
    border-radius: 8px;
    display: inline-block;
}
.status-msg.error { background: rgba(255,92,92,0.12); color: var(--error); border: 1px solid rgba(255,92,92,0.3); }
.status-msg.success { background: rgba(61,255,154,0.12); color: var(--success); border: 1px solid rgba(61,255,154,0.3); }

/* ===== FLAG REVEAL AREA ===== */
#flag-reveal {
    background: var(--bg-secondary);
    border: 1px dashed var(--border-default);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}
#flag-reveal.unlocked {
    border: 1px solid var(--success);
    box-shadow: 0 0 18px rgba(61,255,154,0.15);
}
#flag-reveal .flag-value {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--success);
    margin-top: 8px;
}
#flag-reveal .flag-placeholder {
    color: var(--text-muted);
    font-size: 0.9rem;
}

/* ===== TUTORIAL SYSTEM ===== */
#spotlight {
    position: fixed;
    z-index: 9998;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    display: none;
}
#tutorial-tooltip {
    position: fixed;
    z-index: 9999;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    font-size: 0.85rem;
    color: var(--text-primary);
    box-shadow: var(--glow-accent);
    display: none;
}
#tutorial-tooltip .tt-title {
    font-weight: 600;
    color: var(--accent-primary);
    margin-bottom: 6px;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
#tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
#tutorial-tooltip button {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
}
#tutorial-tooltip .tt-next {
    background: var(--accent-primary);
    color: #06202b;
    border: none;
    font-weight: 600;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    display: none;
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
.modal-box h3 { color: var(--accent-primary); margin-top: 0; }
.modal-box button {
    margin-top: 16px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <!-- 1. TOP HEADER -->
    <div class="top-header">
        <div>
            <h1>Log Triage Console</h1>
            <div class="subtitle">Meridian Retail Co, Security Operations. Trace an active intrusion through the authentication and firewall log stream.</div>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION SECTION -->
    <div class="briefing-box">
        This console represents a simplified SIEM front end. A partial Python parser reads Meridian Retail Co's live log stream. Your job is to run the parser, filter and group the results, and identify the source IP and the account it compromised. Once you confirm the correct root cause, the case is closed and a flag is revealed.
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="main-grid">
        <div class="panel" id="script-panel">
            <h3><i class="fas fa-code"></i> Parser Script</h3>
            <pre class="mono"><span class="kw">def</span> <span class="fn">parse_log_line</span>(line):
    <span class="cm"># split raw line into structured fields</span>
    <span class="kw">return</span> extract_fields(line)

<span class="kw">def</span> <span class="fn">is_suspicious</span>(entry):
    <span class="cm"># flag repeated failures followed by success,</span>
    <span class="cm"># or connections to uncommon ports</span>
    <span class="kw">if</span> entry.result == <span class="str">"FAILED"</span> <span class="kw">and</span> entry.repeat_count &gt;= 5:
        <span class="kw">return</span> <span class="kw">True</span>
    <span class="kw">if</span> entry.type == <span class="str">"firewall"</span> <span class="kw">and</span> entry.port <span class="kw">not in</span> (<span class="str">"80"</span>, <span class="str">"443"</span>):
        <span class="kw">return</span> <span class="kw">True</span>
    <span class="kw">return</span> <span class="kw">False</span></pre>
            <button class="run-btn" id="run-script-btn">Run Script</button>
        </div>

        <div class="panel" id="console-output-panel">
            <h3><i class="fas fa-terminal"></i> Console Output</h3>
            <div id="console-output">
                <div class="console-placeholder">Run the script to load the log stream.</div>
            </div>
        </div>
    </div>

    <div class="main-grid">
        <div class="panel" id="filter-controls">
            <h3><i class="fas fa-filter"></i> Filter and Group</h3>
            <div class="control-row">
                <div>
                    <label for="filter-ip">Source IP</label>
                    <select id="filter-ip">
                        <option value="all">All IPs</option>
                    </select>
                </div>
                <div>
                    <label for="filter-result">Result</label>
                    <select id="filter-result">
                        <option value="all">All Results</option>
                        <option value="FAILED">Failed</option>
                        <option value="SUCCESS">Success</option>
                        <option value="ALLOW">Firewall Allow</option>
                    </select>
                </div>
            </div>
            <div class="toggle-row">
                <div class="toggle-switch" id="group-toggle"><div class="knob"></div></div>
                <span>Group by IP</span>
            </div>
            <table id="group-table">
                <thead>
                    <tr><th>Source IP</th><th>User(s)</th><th>Failed</th><th>Success</th></tr>
                </thead>
                <tbody id="group-table-body"></tbody>
            </table>
        </div>

        <div class="panel" id="root-cause-panel">
            <h3><i class="fas fa-crosshairs"></i> Root Cause</h3>
            <div class="control-row">
                <div>
                    <label for="rc-ip">Suspicious IP</label>
                    <select id="rc-ip">
                        <option value="">Select an IP</option>
                        <option value="203.0.113.77">203.0.113.77</option>
                        <option value="10.0.4.12">10.0.4.12</option>
                        <option value="10.0.4.31">10.0.4.31</option>
                        <option value="10.0.4.45">10.0.4.45</option>
                    </select>
                </div>
                <div>
                    <label for="rc-user">Compromised Account</label>
                    <select id="rc-user">
                        <option value="">Select an account</option>
                        <option value="jsmith">jsmith</option>
                        <option value="amiller">amiller</option>
                        <option value="rpatel">rpatel</option>
                        <option value="ksingh">ksingh</option>
                    </select>
                </div>
            </div>
            <button class="confirm-btn" id="confirm-btn">Confirm Root Cause</button>
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div id="status-area"></div>

    <!-- 5. FLAG REVEAL AREA -->
    <div class="panel" id="flag-reveal">
        <h3 style="justify-content:center;"><i class="fas fa-flag"></i> Investigation Result</h3>
        <div class="flag-placeholder" id="flag-placeholder-text">Confirm the correct root cause above to reveal the flag.</div>
        <div class="flag-value mono" id="flag-value" style="display:none;"></div>
    </div>

</div>

<!-- Tutorial elements -->
<div id="spotlight"></div>
<div id="tutorial-tooltip">
    <div class="tt-title">Tutorial</div>
    <div id="tt-text"></div>
    <div class="tt-actions">
        <button id="tt-skip">Skip Tutorial</button>
        <button id="tt-next" class="tt-next">Next</button>
    </div>
</div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ================= DATA =================
const logData = [
    { ts: "09:14:02", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:08", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:14", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:20", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:26", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:32", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:38", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:44", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:50", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:14:56", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:15:02", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:15:08", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:15:14", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:15:20", type: "auth", result: "FAILED", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:15:26", type: "auth", result: "SUCCESS", user: "jsmith", ip: "203.0.113.77" },
    { ts: "09:15:40", type: "firewall", result: "ALLOW", user: "jsmith", ip: "203.0.113.77", port: "4444", dest: "198.51.100.204" },
    { ts: "09:05:11", type: "auth", result: "SUCCESS", user: "amiller", ip: "10.0.4.12" },
    { ts: "09:07:44", type: "firewall", result: "ALLOW", user: "amiller", ip: "10.0.4.12", port: "443", dest: "13.107.6.156" },
    { ts: "09:09:02", type: "auth", result: "SUCCESS", user: "rpatel", ip: "10.0.4.31" },
    { ts: "09:10:15", type: "firewall", result: "ALLOW", user: "rpatel", ip: "10.0.4.31", port: "80", dest: "142.250.72.14" },
    { ts: "09:11:30", type: "auth", result: "SUCCESS", user: "ksingh", ip: "10.0.4.45" },
    { ts: "09:12:02", type: "firewall", result: "ALLOW", user: "ksingh", ip: "10.0.4.45", port: "443", dest: "104.16.85.20" },
    { ts: "09:13:10", type: "auth", result: "SUCCESS", user: "amiller", ip: "10.0.4.12" },
    { ts: "09:16:05", type: "firewall", result: "ALLOW", user: "rpatel", ip: "10.0.4.31", port: "443", dest: "20.190.151.68" },
    { ts: "09:17:20", type: "auth", result: "SUCCESS", user: "ksingh", ip: "10.0.4.45" },
    { ts: "09:18:00", type: "firewall", result: "ALLOW", user: "amiller", ip: "10.0.4.12", port: "80", dest: "23.203.85.10" },
];

const CORRECT_IP = "203.0.113.77";
const CORRECT_USER = "jsmith";
const FLAG_VALUE = "CBX{intrusion_traced}";

let scriptHasRun = false;

// ================= HELPERS =================
function countFailuresForIp(ip) {
    return logData.filter(e => e.ip === ip && e.type === "auth" && e.result === "FAILED").length;
}

function isSuspicious(entry) {
    if (entry.type === "auth" && entry.result === "FAILED" && countFailuresForIp(entry.ip) >= 5) return true;
    if (entry.type === "firewall" && entry.port && entry.port !== "80" && entry.port !== "443") return true;
    return false;
}

function formatLine(entry) {
    if (entry.type === "auth") {
        return `${entry.ts} auth ${entry.result.padEnd(7)} user=${entry.user} src=${entry.ip}`;
    }
    return `${entry.ts} firewall ${entry.result.padEnd(7)} user=${entry.user} src=${entry.ip} dst=${entry.dest}:${entry.port}`;
}

// ================= RUN SCRIPT =================
document.getElementById("run-script-btn").addEventListener("click", function() {
    scriptHasRun = true;
    const consoleEl = document.getElementById("console-output");
    consoleEl.innerHTML = "";
    logData.forEach(entry => {
        const div = document.createElement("div");
        div.className = "log-line mono" + (isSuspicious(entry) ? " suspicious" : "");
        div.textContent = formatLine(entry);
        consoleEl.appendChild(div);
    });

    // Populate IP filter dropdown
    const ipSet = [...new Set(logData.map(e => e.ip))];
    const ipFilter = document.getElementById("filter-ip");
    ipFilter.innerHTML = '<option value="all">All IPs</option>';
    ipSet.forEach(ip => {
        const opt = document.createElement("option");
        opt.value = ip;
        opt.textContent = ip;
        ipFilter.appendChild(opt);
    });

    this.textContent = "Re-run Script";
});

// ================= FILTERING =================
function applyFilters() {
    if (!scriptHasRun) return;
    const ipVal = document.getElementById("filter-ip").value;
    const resultVal = document.getElementById("filter-result").value;
    const consoleEl = document.getElementById("console-output");
    consoleEl.innerHTML = "";
    const filtered = logData.filter(e => {
        const ipMatch = ipVal === "all" || e.ip === ipVal;
        const resultMatch = resultVal === "all" || e.result === resultVal;
        return ipMatch && resultMatch;
    });
    if (filtered.length === 0) {
        consoleEl.innerHTML = '<div class="console-placeholder">No log lines match this filter.</div>';
        return;
    }
    filtered.forEach(entry => {
        const div = document.createElement("div");
        div.className = "log-line mono" + (isSuspicious(entry) ? " suspicious" : "");
        div.textContent = formatLine(entry);
        consoleEl.appendChild(div);
    });
}
document.getElementById("filter-ip").addEventListener("change", applyFilters);
document.getElementById("filter-result").addEventListener("change", applyFilters);

// ================= GROUP BY IP =================
document.getElementById("group-toggle").addEventListener("click", function() {
    if (!scriptHasRun) return;
    this.classList.toggle("on");
    const table = document.getElementById("group-table");
    const isOn = this.classList.contains("on");
    table.style.display = isOn ? "table" : "none";
    if (isOn) {
        const groups = {};
        logData.forEach(e => {
            if (!groups[e.ip]) groups[e.ip] = { users: new Set(), failed: 0, success: 0 };
            groups[e.ip].users.add(e.user);
            if (e.result === "FAILED") groups[e.ip].failed++;
            if (e.result === "SUCCESS") groups[e.ip].success++;
        });
        const tbody = document.getElementById("group-table-body");
        tbody.innerHTML = "";
        Object.keys(groups).forEach(ip => {
            const g = groups[ip];
            const tr = document.createElement("tr");
            const flagged = g.failed >= 5;
            tr.innerHTML = `<td class="mono">${ip}</td><td>${[...g.users].join(", ")}</td>
                <td class="${flagged ? 'flagged' : ''}">${g.failed}</td><td>${g.success}</td>`;
            tbody.appendChild(tr);
        });
    }
});

// ================= ROOT CAUSE CONFIRMATION =================
document.getElementById("confirm-btn").addEventListener("click", function() {
    const ip = document.getElementById("rc-ip").value;
    const user = document.getElementById("rc-user").value;
    const statusArea = document.getElementById("status-area");

    if (!ip || !user) {
        statusArea.innerHTML = '<div class="status-msg error">Select both a suspicious IP and a compromised account before confirming.</div>';
        return;
    }

    if (ip === CORRECT_IP && user === CORRECT_USER) {
        statusArea.innerHTML = '<div class="status-msg success">Root cause confirmed. Case closed.</div>';
        const flagArea = document.getElementById("flag-reveal");
        flagArea.classList.add("unlocked");
        document.getElementById("flag-placeholder-text").style.display = "none";
        const flagValueEl = document.getElementById("flag-value");
        flagValueEl.textContent = FLAG_VALUE;
        flagValueEl.style.display = "block";
    } else {
        statusArea.innerHTML = '<div class="status-msg error">Findings incomplete, review the log groupings and try again.</div>';
    }
});

// ================= TUTORIAL SYSTEM =================
const tutorialSteps = [
    { id: "script-panel", text: "This is a partial Python log parser. is_suspicious() is the function you will rely on to flag risky lines." },
    { id: "run-script-btn", text: "Click Run to execute the parser against the live log stream." },
    { id: "console-output-panel", text: "Suspicious lines are highlighted. Read carefully, patterns matter more than single lines." },
    { id: "filter-controls", text: "Use these to isolate one IP or one result type at a time, just like filtering in a real SIEM." },
    { id: "group-toggle", text: "Grouping by IP reveals patterns like repeated failures followed by a single success." },
    { id: "root-cause-panel", text: "Once you have identified the attacking IP and the compromised account, select them here." },
    { id: "confirm-btn", text: "Confirm your findings to complete the investigation." },
    { id: "flag-reveal", text: "Your root cause report and confirmation flag will appear here once correct." },
];

let currentStep = 0;
const spotlight = document.getElementById("spotlight");
const tooltip = document.getElementById("tutorial-tooltip");
const ttText = document.getElementById("tt-text");

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.top = (rect.top - pad) + "px";
    spotlight.style.left = (rect.left - pad) + "px";
    spotlight.style.width = (rect.width + pad * 2) + "px";
    spotlight.style.height = (rect.height + pad * 2) + "px";
    spotlight.style.display = "block";

    let tooltipTop = rect.bottom + 14;
    let tooltipLeft = rect.left;
    const tooltipWidth = 300;

    if (tooltipLeft + tooltipWidth > window.innerWidth - 20) {
        tooltipLeft = window.innerWidth - tooltipWidth - 20;
    }
    if (tooltipTop + 150 > window.innerHeight) {
        tooltipTop = rect.top - 160;
    }
    if (tooltipTop < 10) tooltipTop = 10;

    tooltip.style.top = tooltipTop + "px";
    tooltip.style.left = tooltipLeft + "px";
    tooltip.style.display = "block";
}

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    const step = tutorialSteps[index];
    const el = document.getElementById(step.id);
    if (!el) { showStep(index + 1); return; }

    const rect = el.getBoundingClientRect();
    const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!inView) {
        el.scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => positionSpotlight(el), 300);
    } else {
        positionSpotlight(el);
    }
    ttText.textContent = step.text;
    document.getElementById("tt-next").textContent = (index === tutorialSteps.length - 1) ? "Finish" : "Next";
}

function startTutorial() {
    currentStep = 0;
    showStep(currentStep);
}

function endTutorial(completed) {
    spotlight.style.display = "none";
    tooltip.style.display = "none";
    if (completed) {
        document.getElementById("tutorial-complete-modal").style.display = "flex";
    }
}

document.getElementById("tt-next").addEventListener("click", function() {
    currentStep++;
    showStep(currentStep);
});
document.getElementById("tt-skip").addEventListener("click", function() {
    endTutorial(false);
});
document.getElementById("view-tutorial-btn").addEventListener("click", startTutorial);
document.getElementById("start-challenge-btn").addEventListener("click", function() {
    document.getElementById("tutorial-complete-modal").style.display = "none";
});

window.addEventListener("resize", function() {
    if (tooltip.style.display === "block") {
        const step = tutorialSteps[currentStep];
        if (step) {
            const el = document.getElementById(step.id);
            if (el) positionSpotlight(el);
        }
    }
});

// Auto-start tutorial on first load
window.addEventListener("load", function() {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
