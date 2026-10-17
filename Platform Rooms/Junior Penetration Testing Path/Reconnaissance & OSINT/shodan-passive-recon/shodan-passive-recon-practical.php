<?php
// ============================================================
// shodan-passive-recon-practical.php — PRACTICAL FILE
// Shodan Recon Console
// Static HTML/CSS/JS simulation. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shodan Recon Console</title>
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
    min-height: 100vh;
}

.wrap { max-width: 1100px; margin: 0 auto; }

/* ===== Header ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
}
.top-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--accent-primary);
    text-shadow: var(--glow-accent);
}
.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-top: 6px;
    max-width: 640px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.2s ease;
}
.tutorial-btn:hover { background: rgba(106,227,255,0.1); }

/* ===== Description ===== */
.mission-brief {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 22px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.mission-brief strong { color: var(--text-primary); }

/* ===== Main environment ===== */
.console {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
@media (max-width: 860px) {
    .console { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.panel h2 {
    font-size: 1rem;
    color: var(--text-primary);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel h2 .count {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 400;
}

.search-row {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
}
#shodan-search-input {
    flex: 1;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 11px 14px;
    color: var(--text-primary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.88rem;
}
#shodan-search-input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.search-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    padding: 0 18px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}

.hint-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
}
.chip {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: border-color 0.2s ease, color 0.2s ease;
}
.chip:hover { border-color: var(--accent-primary); color: var(--accent-primary); }

#results-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 460px;
    overflow-y: auto;
}
.device-row {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    cursor: pointer;
    transition: border-color 0.2s ease, transform 0.15s ease;
}
.device-row:hover { border-color: var(--accent-primary); transform: translateX(2px); }
.device-row.selected { border-color: var(--accent-secondary); box-shadow: 0 0 0 1px var(--accent-secondary); }
.device-row .ip-line {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--accent-primary);
}
.device-row .meta-line {
    font-size: 0.78rem;
    color: var(--text-muted);
    margin-top: 3px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.no-results {
    color: var(--text-muted);
    font-size: 0.85rem;
    padding: 20px 0;
    text-align: center;
}

/* ===== Banner detail panel ===== */
#banner-detail-panel {
    min-height: 300px;
}
.banner-placeholder {
    color: var(--text-muted);
    font-size: 0.88rem;
    text-align: center;
    padding: 60px 10px;
}
.banner-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    color: var(--text-primary);
    white-space: pre-wrap;
    line-height: 1.7;
}
.banner-header-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.banner-header-line .ip {
    font-family: "JetBrains Mono", monospace;
    color: var(--accent-primary);
    font-size: 0.95rem;
}
.tag {
    display: inline-block;
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 5px;
    background: rgba(255,255,255,0.06);
    color: var(--text-secondary);
    margin-left: 6px;
}

/* ===== Status / feedback area ===== */
.status-bar {
    margin-top: 18px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* ===== Flag reveal ===== */
.flag-reveal {
    margin-top: 18px;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(61,255,154,0.02));
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 20px;
    display: none;
}
.flag-reveal.show { display: block; }
.flag-reveal h3 {
    color: var(--success);
    font-size: 1rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 6px;
    padding: 12px 14px;
    font-size: 1rem;
    color: var(--success);
    letter-spacing: 0.02em;
    user-select: all;
}

.warn-line { color: var(--warning); }
.err-line { color: var(--error); }

/* ===== Spotlight tutorial ===== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
}
.tooltip-card p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 12px;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    border-radius: 6px;
    padding: 7px 14px;
    cursor: pointer;
    border: none;
}
.tt-skip { background: transparent; color: var(--text-muted); }
.tt-next { background: var(--accent-primary); color: var(--bg-primary); font-weight: 600; }

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { color: var(--accent-primary); margin-bottom: 10px; }
.modal-box p { color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 18px; }
.modal-box button {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}
</style>
</head>
<body>

<div class="wrap">
    <div class="top-header">
        <div>
            <h1>Shodan Recon Console</h1>
            <p class="subtitle">A simulated device index. Twelve internet connected devices have been indexed. Somewhere among them is a database exposed without authentication.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="mission-brief">
        <strong>Mission:</strong> A retail company's infrastructure was swept up in a routine internet wide scan. Use search filters to narrow the twelve indexed devices down, then inspect banners until you find the one exposed database. Open its banner to complete the challenge.
    </div>

    <div class="console">
        <div class="panel">
            <h2>Search Results <span class="count" id="result-count">12 devices indexed</span></h2>
            <div class="search-row">
                <input type="text" id="shodan-search-input" placeholder="e.g. product:MongoDB country:US" autocomplete="off">
                <button class="search-btn" id="search-btn">Search</button>
            </div>
            <div class="hint-chips">
                <span class="chip" id="filter-hint-chip" data-query="product:MongoDB">product:MongoDB</span>
                <span class="chip" data-query="port:27017">port:27017</span>
                <span class="chip" data-query="country:US">country:US</span>
                <span class="chip" data-query="org:&quot;Global Retail Corp&quot;">org:"Global Retail Corp"</span>
            </div>
            <div id="results-list"></div>
        </div>

        <div class="panel">
            <h2>Banner Detail</h2>
            <div id="banner-detail-panel">
                <p class="banner-placeholder">Select a device from the results list to inspect its raw banner.</p>
            </div>
        </div>
    </div>

    <div class="status-bar" id="status-bar">
        Status: idle. Enter a filter query or click a device to begin.
    </div>

    <div class="flag-reveal" id="flag-reveal">
        <h3>🚩 Exposed Database Identified</h3>
        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 12px;">You located the unauthenticated MongoDB instance belonging to Global Retail Corp. This is exactly how attackers find databases like this, entirely without touching the target.</p>
        <div class="flag-value" id="flag-value">CBX{database_exposed}</div>
    </div>
</div>

<!-- Tutorial completion modal -->
<div class="modal-overlay" id="tutorial-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Build a query, inspect devices, and find the exposed database.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
// ==========================================================
// Dataset — 12 simulated Shodan results
// ==========================================================
const devices = [
    {
        ip: "203.0.113.10", port: 22, product: "OpenSSH", version: "8.2",
        country: "US", org: "Acme Hosting",
        banner: "SSH-2.0-OpenSSH_8.2\nProtocol: SSH2\nHost key type: ssh-rsa\nScan time: 2026-06-14 03:11 UTC"
    },
    {
        ip: "203.0.113.45", port: 80, product: "nginx", version: "1.18.0",
        country: "US", org: "Acme Hosting",
        banner: "HTTP/1.1 200 OK\nServer: nginx/1.18.0\nContent-Type: text/html\nScan time: 2026-06-14 03:12 UTC"
    },
    {
        ip: "198.51.100.22", port: 3389, product: "RDP", version: "10.0",
        country: "DE", org: "Berlin Cloud GmbH",
        banner: "RDP Negotiation Response\nProtocol: RDP\nSecurity: Enhanced\nScan time: 2026-06-13 22:40 UTC"
    },
    {
        ip: "198.51.100.87", port: 21, product: "vsftpd", version: "2.3.4",
        country: "FR", org: "Paris Net Services",
        banner: "220 (vsFTPd 2.3.4)\n221 Goodbye.\nScan time: 2026-06-13 19:05 UTC"
    },
    {
        ip: "192.0.2.14", port: 9200, product: "Elasticsearch", version: "6.4.0",
        country: "US", org: "DataWave Analytics",
        banner: "HTTP/1.1 200 OK\nname: node-1\ncluster_name: analytics-prod\nversion.number: 6.4.0\nScan time: 2026-06-14 01:22 UTC"
    },
    {
        ip: "192.0.2.55", port: 443, product: "Microsoft IIS", version: "8.5",
        country: "GB", org: "London Retail Ltd",
        banner: "HTTP/1.1 200 OK\nServer: Microsoft-IIS/8.5\nX-Powered-By: ASP.NET\nScan time: 2026-06-14 00:58 UTC"
    },
    {
        ip: "203.0.113.90", port: 27017, product: "MongoDB", version: "3.2.0",
        country: "US", org: "Global Retail Corp",
        banner: "MongoDB Server Info\nversion: 3.2.0\nauthentication: NONE REQUIRED\nWARNING: this instance accepts unauthenticated connections\n\nVisible collections:\n  users        { email, password_hash }\n  payments     { credit_card }\n\nScan time: 2026-06-14 02:47 UTC",
        isTarget: true
    },
    {
        ip: "198.51.100.33", port: 22, product: "OpenSSH", version: "7.4",
        country: "CA", org: "Northern Systems",
        banner: "SSH-2.0-OpenSSH_7.4\nProtocol: SSH2\nHost key type: ssh-ed25519\nScan time: 2026-06-13 20:15 UTC"
    },
    {
        ip: "192.0.2.101", port: 80, product: "Apache", version: "2.4.6",
        country: "US", org: "Acme Hosting",
        banner: "HTTP/1.1 200 OK\nServer: Apache/2.4.6 (CentOS)\nContent-Type: text/html\nScan time: 2026-06-14 03:09 UTC"
    },
    {
        ip: "203.0.113.150", port: 3306, product: "MySQL", version: "5.7.21",
        country: "US", org: "Global Retail Corp",
        banner: "MySQL Server Info\nversion: 5.7.21\nauthentication: required\nAccess denied for user 'anonymous'@'scanner'\nScan time: 2026-06-14 02:51 UTC"
    },
    {
        ip: "198.51.100.200", port: 8080, product: "Jenkins", version: "2.204",
        country: "US", org: "DevOps Solutions",
        banner: "HTTP/1.1 200 OK\nX-Jenkins: 2.204\nServer: Jetty\nScan time: 2026-06-13 23:33 UTC"
    },
    {
        ip: "192.0.2.199", port: 445, product: "SMB", version: "3.1.1",
        country: "US", org: "SmallBiz Networks",
        banner: "SMB Negotiate Response\nDialect: SMB 3.1.1\nSigning: enabled\nScan time: 2026-06-14 00:12 UTC"
    }
];

const resultsList = document.getElementById('results-list');
const resultCount = document.getElementById('result-count');
const searchInput = document.getElementById('shodan-search-input');
const searchBtn = document.getElementById('search-btn');
const bannerPanel = document.getElementById('banner-detail-panel');
const statusBar = document.getElementById('status-bar');
const flagReveal = document.getElementById('flag-reveal');

function parseQuery(raw) {
    const filters = {};
    const regex = /(\w+):("(?:[^"]+)"|\S+)/g;
    let match;
    let remaining = raw;
    while ((match = regex.exec(raw)) !== null) {
        let value = match[2];
        if (value.startsWith('"') && value.endsWith('"')) {
            value = value.slice(1, -1);
        }
        filters[match[1].toLowerCase()] = value.toLowerCase();
        remaining = remaining.replace(match[0], '');
    }
    return filters;
}

function matchesFilters(device, filters) {
    if (filters.product && !device.product.toLowerCase().includes(filters.product)) return false;
    if (filters.port && String(device.port) !== filters.port) return false;
    if (filters.country && device.country.toLowerCase() !== filters.country) return false;
    if (filters.org && !device.org.toLowerCase().includes(filters.org)) return false;
    if (filters.net) return true; // net filter accepted but not enforced in this simulation
    return true;
}

function renderResults() {
    const raw = searchInput.value.trim();
    const filters = raw ? parseQuery(raw) : {};
    const filtered = devices.filter(d => matchesFilters(d, filters));

    resultCount.textContent = filtered.length + (filtered.length === 1 ? ' device indexed' : ' devices indexed');
    resultsList.innerHTML = '';

    if (filtered.length === 0) {
        resultsList.innerHTML = '<div class="no-results">No devices match that query. Try a broader filter.</div>';
        return;
    }

    filtered.forEach((device, idx) => {
        const row = document.createElement('div');
        row.className = 'device-row';
        row.dataset.ip = device.ip;
        row.innerHTML = `
            <div class="ip-line">${device.ip}:${device.port}</div>
            <div class="meta-line">
                <span>${device.product} ${device.version}</span>
                <span>${device.country}</span>
                <span>${device.org}</span>
            </div>
        `;
        row.addEventListener('click', () => selectDevice(device, row));
        resultsList.appendChild(row);
    });
}

function selectDevice(device, rowEl) {
    document.querySelectorAll('.device-row').forEach(r => r.classList.remove('selected'));
    if (rowEl) rowEl.classList.add('selected');

    bannerPanel.innerHTML = `
        <div class="banner-header-line">
            <span class="ip">${device.ip}:${device.port}</span>
            <span class="tag">${device.country}</span>
        </div>
        <div class="banner-box">${device.banner}</div>
    `;

    statusBar.textContent = `Status: viewing banner for ${device.ip}:${device.port} (${device.product} ${device.version})`;

    if (device.isTarget) {
        statusBar.innerHTML = `<span style="color: var(--success);">Status: unauthenticated database identified. Flag revealed below.</span>`;
        flagReveal.classList.add('show');
        flagReveal.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

searchBtn.addEventListener('click', renderResults);
searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') renderResults();
});
document.querySelectorAll('.chip').forEach(chip => {
    chip.addEventListener('click', () => {
        searchInput.value = chip.dataset.query;
        renderResults();
    });
});

renderResults();

// ==========================================================
// Spotlight Tutorial System
// ==========================================================
const tutorialSteps = [
    {
        targetId: 'shodan-search-input',
        text: 'This is the Shodan style search bar. Real Shodan uses filters such as product:, port:, country:, and org: to narrow millions of indexed devices down to exactly what you need.'
    },
    {
        targetId: 'filter-hint-chip',
        text: 'Try a filter like product:MongoDB to see only devices running that service. Filters can be combined with spaces, like product:MongoDB country:US.'
    },
    {
        targetId: 'results-list',
        text: 'Each row is a simulated internet connected device: its IP, port, and the service banner Shodan captured during a routine scan. Nothing here was actively probed by you.'
    },
    {
        targetId: 'results-list',
        text: 'Click any device row to inspect its full banner, the same raw text a real scan would capture the instant it connected.'
    },
    {
        targetId: 'banner-detail-panel',
        text: 'This is the banner detail panel. Attackers read banners exactly like this to identify software, version numbers, and misconfigurations before ever touching the target directly.'
    }
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
        <p id="tt-text"></p>
        <div class="tooltip-actions">
            <button class="tt-skip" id="tt-skip">Skip Tutorial</button>
            <button class="tt-next" id="tt-next">Next</button>
        </div>
    `;
    document.body.appendChild(tooltipEl);

    document.getElementById('tt-skip').addEventListener('click', endTutorial);
    document.getElementById('tt-next').addEventListener('click', nextStep);
}

function positionSpotlight(target) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlightEl.style.top = (rect.top - pad) + 'px';
    spotlightEl.style.left = (rect.left - pad) + 'px';
    spotlightEl.style.width = (rect.width + pad * 2) + 'px';
    spotlightEl.style.height = (rect.height + pad * 2) + 'px';

    const tooltipWidth = 300;
    let top = rect.bottom + 14;
    let left = rect.left;

    if (left + tooltipWidth > window.innerWidth - 20) {
        left = window.innerWidth - tooltipWidth - 20;
    }
    if (top + 140 > window.innerHeight) {
        top = rect.top - 150;
    }
    if (left < 10) left = 10;

    tooltipEl.style.top = top + 'px';
    tooltipEl.style.left = left + 'px';
}

function showStep(index) {
    const step = tutorialSteps[index];
    let target = document.getElementById(step.targetId);
    if (!target) return;

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        document.getElementById('tt-text').textContent = step.text;
        document.getElementById('tt-next').textContent = (index === tutorialSteps.length - 1) ? 'Finish' : 'Next';
        positionSpotlight(target);
    }, 300);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial();
        document.getElementById('tutorial-modal').classList.add('show');
        return;
    }
    showStep(currentStep);
}

function startTutorial() {
    currentStep = 0;
    if (!spotlightEl) createSpotlightElements();
    spotlightEl.style.display = 'block';
    tooltipEl.style.display = 'block';
    showStep(0);
}

function endTutorial() {
    if (spotlightEl) spotlightEl.style.display = 'none';
    if (tooltipEl) tooltipEl.style.display = 'none';
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-modal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (spotlightEl && spotlightEl.style.display === 'block') {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target);
    }
});

// Auto start tutorial on first load
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
