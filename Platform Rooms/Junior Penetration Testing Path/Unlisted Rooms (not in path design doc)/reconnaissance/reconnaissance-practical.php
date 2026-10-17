<?php
// Filename: reconnaissance-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OSINT Investigator - Nexora Dynamics</title>
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

.page-wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px 20px 60px 20px;
}

/* ===== HEADER ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 20px;
}

.top-header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}

.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
    max-width: 640px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    background: rgba(106,227,255,0.1);
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION ===== */
.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 24px;
}
.mission-briefing h2 {
    font-size: 1rem;
    margin: 0 0 8px 0;
    color: var(--accent-primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.mission-briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
.mission-briefing p:last-child { margin-bottom: 0; }

/* ===== TABS ===== */
.tab-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
}
.tab-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}
.tab-btn.active {
    color: var(--accent-primary);
    border-color: var(--accent-primary);
    background: rgba(106,227,255,0.08);
}
.tab-btn.visited::after {
    content: '✓';
    color: var(--success);
    font-size: 0.75rem;
}

/* ===== PANELS ===== */
.panel {
    display: none;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 22px;
    margin-bottom: 20px;
    animation: none;
}
.panel.active { display: block; }

.panel h3 {
    margin-top: 0;
    font-size: 1.05rem;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-default);
    padding-bottom: 10px;
}

.website-page {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px 18px;
    margin-bottom: 14px;
}
.website-page h4 {
    margin: 0 0 8px 0;
    color: var(--accent-primary);
    font-size: 0.9rem;
}
.website-page p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.88rem;
}

.social-post {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 12px;
}
.social-post .handle {
    font-family: "JetBrains Mono", monospace;
    color: var(--accent-secondary);
    font-size: 0.82rem;
    font-weight: 600;
}
.social-post .post-text {
    color: var(--text-primary);
    font-size: 0.9rem;
    margin-top: 6px;
}

pre.data-block {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.83rem;
    color: var(--text-primary);
    overflow-x: auto;
    line-height: 1.7;
}

.record-key { color: var(--accent-primary); }
.record-val { color: var(--success); }

/* ===== STAGING PANEL ===== */
.staging-locked {
    text-align: center;
    padding: 30px 20px;
    color: var(--text-muted);
}
.staging-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 14px 30px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.staging-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
.staging-btn:not(:disabled):hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

.staging-banner {
    background: var(--bg-primary);
    border: 1px solid var(--warning);
    border-radius: 8px;
    padding: 18px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--warning);
    margin-top: 16px;
    line-height: 1.7;
}

/* ===== STATUS AREA ===== */
.status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.status-area .progress-list {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-top: 8px;
}
.status-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
}
.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--text-muted);
}
.status-dot.done { background: var(--success); }

/* ===== FLAG REVEAL ===== */
.flag-area {
    display: none;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
    margin-top: 10px;
}
.flag-area.show { display: block; }
.flag-area h3 {
    color: var(--success);
    margin-top: 0;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 12px 20px;
    display: inline-block;
    color: var(--success);
    letter-spacing: 0.02em;
}

/* ===== TUTORIAL ===== */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
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
    font-size: 0.85rem;
    color: var(--text-primary);
    line-height: 1.5;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tooltip-actions .next-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    font-weight: 600;
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
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-card h3 {
    color: var(--accent-primary);
    margin-top: 0;
}
.modal-card button {
    margin-top: 14px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="top-header">
        <div>
            <h1>OSINT Investigator</h1>
            <p class="subtitle">Passive reconnaissance simulation against Nexora Dynamics, a fictional fintech company. Investigate every public source before you touch the target directly.</p>
        </div>
        <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
    </div>

    <div class="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>You have been engaged as an external consultant to map the public attack surface of Nexora Dynamics ahead of an authorized penetration test. You may only observe. No scanning or intrusion is permitted.</p>
        <p>Work through the Company Website, Employee Social Feed, WHOIS Lookup, and DNS Records panels. Once all four have been reviewed, the Staging Environment panel will unlock.</p>
    </div>

    <div class="status-area" id="statusArea">
        <div>Panels reviewed:</div>
        <div class="progress-list">
            <div class="status-item"><span class="status-dot" id="dot-website"></span> Website</div>
            <div class="status-item"><span class="status-dot" id="dot-social"></span> Social Feed</div>
            <div class="status-item"><span class="status-dot" id="dot-whois"></span> WHOIS</div>
            <div class="status-item"><span class="status-dot" id="dot-dns"></span> DNS Records</div>
        </div>
    </div>

    <div class="tab-bar">
        <button class="tab-btn active" id="tab-website" data-panel="panel-website">Company Website</button>
        <button class="tab-btn" id="tab-social" data-panel="panel-social">Employee Social Feed</button>
        <button class="tab-btn" id="tab-whois" data-panel="panel-whois">WHOIS Lookup</button>
        <button class="tab-btn" id="tab-dns" data-panel="panel-dns">DNS Records</button>
        <button class="tab-btn" id="tab-staging" data-panel="panel-staging">Staging Environment</button>
    </div>

    <div class="panel active" id="panel-website">
        <h3>Nexora Dynamics - Company Website</h3>
        <div class="website-page">
            <h4>About Us</h4>
            <p>Nexora Dynamics was founded in 2015 to modernize payment infrastructure for small businesses. Headquartered in Austin, Texas, we serve over 12,000 merchants across North America.</p>
        </div>
        <div class="website-page">
            <h4>Careers: Senior DevOps Engineer</h4>
            <p>Nexora Dynamics is hiring a Senior DevOps Engineer to maintain our CI/CD pipeline. Ideal candidates have hands on experience with Jenkins (we currently run Jenkins 2.361, migration to a newer version planned for next quarter), Docker, and AWS. You will also support our staging environment used for pre production testing.</p>
        </div>
    </div>

    <div class="panel" id="panel-social">
        <h3>Employee Social Feed</h3>
        <div class="social-post">
            <div class="handle">@schen_nexora - Sarah Chen</div>
            <div class="post-text">Three years at Nexora Dynamics today! Time flies. Still can't believe I get to work with such a great security team.</div>
        </div>
        <div class="social-post">
            <div class="handle">@mwebb_dev - Marcus Webb</div>
            <div class="post-text">Finally migrated our VPN client to GlobalProtect 5.2 after months of Nexora IT dragging their feet lol</div>
        </div>
        <div class="social-post">
            <div class="handle">@priya_p - Priya Patel</div>
            <div class="post-text">So excited for day one at Nexora Dynamics! My email is priya.patel@nexoradynamics.com if anyone wants to connect</div>
        </div>
        <div class="social-post">
            <div class="handle">@mwebb_dev - Marcus Webb</div>
            <div class="post-text">Debugging on staging.nexoradynamics.com all night, this old server really needs to be decommissioned</div>
        </div>
        <div class="social-post">
            <div class="handle">@schen_nexora - Sarah Chen</div>
            <div class="post-text">Shoutout to our hosting provider DigitalOcean for the fast support ticket resolution today</div>
        </div>
    </div>

    <div class="panel" id="panel-whois">
        <h3>WHOIS Lookup: nexoradynamics.com</h3>
        <pre class="data-block"><span class="record-key">Domain Name:</span>        <span class="record-val">NEXORADYNAMICS.COM</span>
<span class="record-key">Registrar:</span>          <span class="record-val">Namecheap, Inc.</span>
<span class="record-key">Registrant Org:</span>     <span class="record-val">Nexora Dynamics LLC</span>
<span class="record-key">Registrant Email:</span>   <span class="record-val">admin@nexoradynamics.com</span>
<span class="record-key">Creation Date:</span>      <span class="record-val">2015-03-12</span>
<span class="record-key">Name Servers:</span>       <span class="record-val">ns1.digitalocean.com, ns2.digitalocean.com</span></pre>
    </div>

    <div class="panel" id="panel-dns">
        <h3>DNS Records: nexoradynamics.com</h3>
        <pre class="data-block"><span class="record-key">A</span>     nexoradynamics.com          <span class="record-val">164.90.12.44</span>
<span class="record-key">A</span>     www.nexoradynamics.com      <span class="record-val">164.90.12.44</span>
<span class="record-key">A</span>     staging.nexoradynamics.com  <span class="record-val">164.90.203.17</span>
<span class="record-key">MX</span>    nexoradynamics.com          <span class="record-val">mail.nexoradynamics.com (priority 10)</span>
<span class="record-key">TXT</span>   nexoradynamics.com          <span class="record-val">"v=spf1 include:_spf.google.com ~all"</span>
<span class="record-key">NS</span>    nexoradynamics.com          <span class="record-val">ns1.digitalocean.com, ns2.digitalocean.com</span></pre>
    </div>

    <div class="panel" id="panel-staging">
        <h3>staging.nexoradynamics.com</h3>
        <div class="staging-locked" id="stagingLocked">
            <p>This subdomain was found in the DNS records but is never linked from the public website.</p>
            <button class="staging-btn" id="visitStagingBtn" disabled>Visit staging.nexoradynamics.com</button>
            <p style="font-size:0.8rem; margin-top:14px;">Review the Website, Social Feed, WHOIS, and DNS panels to unlock this button.</p>
        </div>
        <div class="staging-banner" id="stagingBanner" style="display:none;">
NexoraDesk Staging Environment - Internal Use Only<br>
Powered by Jenkins ver. 2.361<br>
Unauthorized access prohibited.
        </div>
    </div>

    <div class="flag-area" id="flagArea">
        <h3>Staging Environment Exposed</h3>
        <p>You traced an unlinked subdomain through DNS records and confirmed it exposes an internal build system.</p>
        <div class="flag-value">CBX{subdomain_exposed}</div>
    </div>

</div>

<div class="modal-overlay" id="completeModal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<div class="spotlight-box" id="spotlightBox" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <p id="tooltipText"></p>
    <div class="tooltip-actions">
        <button id="skipTutorialBtn">Skip Tutorial</button>
        <button class="next-btn" id="nextStepBtn">Next</button>
    </div>
</div>

<script>
const visited = { website: false, social: false, whois: false, dns: false };

const tabs = document.querySelectorAll('.tab-btn');
const panels = document.querySelectorAll('.panel');

function activatePanel(panelId, tabEl) {
    panels.forEach(p => p.classList.remove('active'));
    tabs.forEach(t => t.classList.remove('active'));
    document.getElementById(panelId).classList.add('active');
    tabEl.classList.add('active');
}

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const panelId = tab.dataset.panel;
        activatePanel(panelId, tab);

        const key = tab.id.replace('tab-', '');
        if (visited.hasOwnProperty(key) && !visited[key]) {
            visited[key] = true;
            tab.classList.add('visited');
            const dot = document.getElementById('dot-' + key);
            if (dot) dot.classList.add('done');
        }
        checkUnlock();
    });
});

function checkUnlock() {
    const allDone = visited.website && visited.social && visited.whois && visited.dns;
    const btn = document.getElementById('visitStagingBtn');
    if (allDone) {
        btn.disabled = false;
    }
}

document.getElementById('visitStagingBtn').addEventListener('click', () => {
    document.getElementById('stagingLocked').querySelector('p').textContent =
        'Access granted. Internal banner retrieved below.';
    document.getElementById('stagingBanner').style.display = 'block';
    document.getElementById('flagArea').classList.add('show');
    document.getElementById('flagArea').scrollIntoView({ behavior: 'smooth', block: 'center' });
});

/* ===== TUTORIAL SYSTEM ===== */
const tutorialSteps = [
    { targetElementId: 'tab-website', tooltipText: 'This is the Company Website panel. Browse it the way a recon analyst would when researching a target organization.' },
    { targetElementId: 'tab-social', tooltipText: 'This is the Employee Social Feed. People often post more than they realize. Read carefully for details a company would not want made public.' },
    { targetElementId: 'tab-whois', tooltipText: 'This is the WHOIS Lookup panel. It reveals registration details about the domain, including its registrar and registrant organization.' },
    { targetElementId: 'tab-dns', tooltipText: 'This is the DNS Records panel. DNS records can expose subdomains and infrastructure that are never linked anywhere on the public website.' },
    { targetElementId: 'tab-staging', tooltipText: 'Once you have reviewed every other panel, the visit button here will unlock. Visiting it will reveal your flag.' }
];

let currentStep = 0;
let tutorialActive = false;

const spotlightBox = document.getElementById('spotlightBox');
const tooltipCard = document.getElementById('tooltipCard');
const tooltipText = document.getElementById('tooltipText');

function positionSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlightBox.style.top = (rect.top - pad) + 'px';
    spotlightBox.style.left = (rect.left - pad) + 'px';
    spotlightBox.style.width = (rect.width + pad * 2) + 'px';
    spotlightBox.style.height = (rect.height + pad * 2) + 'px';
    spotlightBox.style.display = 'block';

    let tooltipTop = rect.bottom + 14;
    let tooltipLeft = rect.left;
    const tooltipWidth = 300;

    if (tooltipLeft + tooltipWidth > window.innerWidth - 20) {
        tooltipLeft = window.innerWidth - tooltipWidth - 20;
    }
    if (tooltipTop + 140 > window.innerHeight) {
        tooltipTop = rect.top - 150;
    }

    tooltipCard.style.top = tooltipTop + 'px';
    tooltipCard.style.left = tooltipLeft + 'px';
    tooltipCard.style.display = 'block';
}

function showStep(index) {
    const step = tutorialSteps[index];
    const el = document.getElementById(step.targetElementId);
    if (!el) return;

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        positionSpotlight(el);
        tooltipText.textContent = step.tooltipText;
        document.getElementById('nextStepBtn').textContent =
            (index === tutorialSteps.length - 1) ? 'Finish' : 'Next';
    }, 300);
}

function startTutorial() {
    tutorialActive = true;
    currentStep = 0;
    showStep(currentStep);
}

function endTutorial(showModal) {
    tutorialActive = false;
    spotlightBox.style.display = 'none';
    tooltipCard.style.display = 'none';
    if (showModal) {
        document.getElementById('completeModal').classList.add('show');
    }
}

document.getElementById('nextStepBtn').addEventListener('click', () => {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
    } else {
        showStep(currentStep);
    }
});

document.getElementById('skipTutorialBtn').addEventListener('click', () => {
    endTutorial(false);
});

document.getElementById('tutorialBtn').addEventListener('click', () => {
    startTutorial();
});

document.getElementById('startChallengeBtn').addEventListener('click', () => {
    document.getElementById('completeModal').classList.remove('show');
});

window.addEventListener('resize', () => {
    if (tutorialActive) {
        const step = tutorialSteps[currentStep];
        const el = document.getElementById(step.targetElementId);
        if (el) positionSpotlight(el);
    }
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>

</body>
</html>
