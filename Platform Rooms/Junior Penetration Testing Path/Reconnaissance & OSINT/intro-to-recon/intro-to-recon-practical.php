<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OSINT Recon Board</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.6;
}

.header {
    position: relative;
    padding: 32px 24px 24px 24px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    text-align: center;
}

.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.7rem;
    color: var(--accent-primary);
}

.header .subtitle {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.tutorial-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 8px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.tutorial-btn:hover {
    background: rgba(106,227,255,0.1);
    box-shadow: var(--glow-accent);
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px;
}

.description-section {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 24px;
}

.description-section p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.tab-btn {
    flex: 1;
    min-width: 140px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 12px 14px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.tab-btn:hover {
    color: var(--text-primary);
    border-color: var(--accent-primary);
}

.tab-btn.active {
    background: rgba(106,227,255,0.08);
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}

.tab-btn.viewed::after {
    content: '✓';
    position: absolute;
    top: 6px;
    right: 8px;
    color: var(--success);
    font-size: 0.75rem;
}

.panel {
    display: none;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    animation: none;
}

.panel.active {
    display: block;
}

.panel h3 {
    margin-top: 0;
    color: var(--accent-primary);
    font-size: 1.05rem;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
}

.data-table td {
    padding: 8px 10px;
    border-bottom: 1px solid var(--border-default);
    vertical-align: top;
}

.data-table td:first-child {
    color: var(--text-muted);
    width: 200px;
}

.job-posting {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    font-size: 0.9rem;
}

.job-posting h4 {
    margin: 0 0 10px 0;
    color: var(--text-primary);
}

.job-posting code {
    font-family: 'JetBrains Mono', monospace;
    background: var(--bg-surface);
    padding: 2px 6px;
    border-radius: 4px;
    color: var(--accent-secondary);
}

.employee-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.employee-list li {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--border-default);
    font-size: 0.9rem;
}

.employee-list li:last-child {
    border-bottom: none;
}

.employee-list .role {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.dns-list {
    list-style: none;
    margin: 0;
    padding: 0;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.88rem;
}

.dns-list li {
    padding: 9px 0;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-secondary);
}

.dns-list li:last-child {
    border-bottom: none;
}

.dns-list .flag-note {
    color: var(--warning);
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    display: block;
    margin-top: 3px;
}

.status-area {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 20px;
    text-align: center;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.summary-section {
    text-align: center;
    margin-bottom: 24px;
}

.compile-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 14px 32px;
    border-radius: 10px;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.compile-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.compile-btn:not(:disabled):hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-2px);
}

.summary-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
    text-align: left;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.summary-card h4 {
    color: var(--text-primary);
    margin-top: 0;
}

.summary-card ul {
    margin: 8px 0;
    padding-left: 20px;
}

.flag-area {
    background: rgba(61,255,154,0.06);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
    margin-bottom: 24px;
}

.flag-area h3 {
    margin: 0 0 10px 0;
    color: var(--success);
}

.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.15rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    border: 1px solid var(--success);
}

.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 1000;
    transition: all 0.3s ease;
}

.tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 1001;
    font-size: 0.88rem;
    box-shadow: var(--glow-accent);
}

.tooltip p {
    margin: 0 0 12px 0;
    color: var(--text-secondary);
}

.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.tooltip-actions button {
    flex: 1;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 8px 10px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.8rem;
    cursor: pointer;
}

.tooltip-actions .next-btn {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border-color: var(--accent-primary);
    font-weight: 600;
}

.modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1002;
}

.modal-content {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    max-width: 360px;
}

.modal-content h3 {
    color: var(--accent-primary);
    margin-top: 0;
}

.modal-content button {
    margin-top: 16px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .tab-btn { min-width: 100%; }
    .data-table td:first-child { width: 130px; }
}
</style>
</head>
<body>

<div class="header">
    <h1>OSINT Recon Board</h1>
    <p class="subtitle">Investigate Meridian Logistics using only public sources</p>
    <button id="tutorial-btn" class="tutorial-btn">View Tutorial</button>
</div>

<div class="container">

    <div class="description-section">
        <p>This environment simulates the public footprint of a fictional company, Meridian Logistics. Review every public source available, exactly as a tester would during the passive phase of an engagement, then compile what you learn into a recon summary.</p>
    </div>

    <div id="source-tabs" class="tabs">
        <button class="tab-btn active" data-panel="whois">WHOIS Lookup</button>
        <button class="tab-btn" data-panel="jobs">Job Postings</button>
        <button class="tab-btn" data-panel="employees">Employee Directory</button>
        <button class="tab-btn" data-panel="dns">DNS Records</button>
    </div>

    <div id="whois-panel" class="panel active">
        <h3>WHOIS Lookup: meridianlogix.com</h3>
        <table class="data-table">
            <tr><td>Domain</td><td>meridianlogix.com</td></tr>
            <tr><td>Registrar</td><td>NameStorm Registrar LLC</td></tr>
            <tr><td>Registrant Organization</td><td>Meridian Logistics Inc.</td></tr>
            <tr><td>Registration Date</td><td>2014-03-11</td></tr>
            <tr><td>Name Servers</td><td>ns1.meridianlogix.com, ns2.meridianlogix.com</td></tr>
            <tr><td>Registrant Country</td><td>United States</td></tr>
        </table>
    </div>

    <div id="jobs-panel" class="panel">
        <h3>Public Job Posting</h3>
        <div class="job-posting">
            <h4>Senior DevOps Engineer, Meridian Logistics</h4>
            <p>We are looking for a Senior DevOps Engineer to join our growing infrastructure team. You will work daily with <code>AWS</code>, <code>Kubernetes</code>, and <code>Jenkins</code> to manage our deployment pipelines. Familiarity with <code>Zendesk</code> for internal ticketing and <code>Cisco AnyConnect</code> for remote VPN access is a plus.</p>
        </div>
    </div>

    <div id="employees-panel" class="panel">
        <h3>Employee Directory</h3>
        <ul class="employee-list">
            <li><span>Sarah Chen</span><span class="role">IT Systems Administrator</span></li>
            <li><span>Marcus Webb</span><span class="role">Network Security Engineer</span></li>
            <li><span>Priya Anand</span><span class="role">Head of Human Resources</span></li>
            <li><span>Daniel Osei</span><span class="role">DevOps Team Lead</span></li>
        </ul>
    </div>

    <div id="dns-panel" class="panel">
        <h3>Public DNS Records</h3>
        <ul class="dns-list">
            <li>vpn.meridianlogix.com</li>
            <li>mail.meridianlogix.com</li>
            <li>portal.meridianlogix.com</li>
            <li>dev.meridianlogix.com
                <span class="flag-note">A staging subdomain, likely not intended to be public.</span>
            </li>
        </ul>
    </div>

    <div class="status-area" id="status-area">
        Sources reviewed: <span id="viewed-count">0</span> / 4
    </div>

    <div class="summary-section">
        <button id="compile-btn" class="compile-btn" disabled>Compile Recon Summary</button>
        <div id="summary-card" class="summary-card" style="display:none;"></div>
    </div>

    <div id="flag-area" class="flag-area" style="display:none;">
        <h3>Flag Retrieved</h3>
        <p class="flag-value" id="flag-value">CBX{intel_compiled}</p>
    </div>

</div>

<div id="spotlight" class="spotlight" style="display:none;"></div>
<div id="tooltip" class="tooltip" style="display:none;"></div>

<div id="tutorial-complete-modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    var viewedPanels = new Set();
    var totalSources = 4;

    var tabButtons = document.querySelectorAll('.tab-btn');
    var panels = document.querySelectorAll('.panel');
    var viewedCountEl = document.getElementById('viewed-count');
    var compileBtn = document.getElementById('compile-btn');
    var summaryCard = document.getElementById('summary-card');
    var flagArea = document.getElementById('flag-area');

    function showPanel(panelName) {
        tabButtons.forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.panel === panelName);
        });
        panels.forEach(function (panel) {
            panel.classList.toggle('active', panel.id === panelName + '-panel');
        });
        viewedPanels.add(panelName);
        document.querySelector('.tab-btn[data-panel="' + panelName + '"]').classList.add('viewed');
        viewedCountEl.textContent = viewedPanels.size;
        if (viewedPanels.size >= totalSources) {
            compileBtn.disabled = false;
        }
    }

    tabButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            showPanel(btn.dataset.panel);
        });
    });

    // First panel counts as viewed on load since it starts active
    viewedPanels.add('whois');
    document.querySelector('.tab-btn[data-panel="whois"]').classList.add('viewed');
    viewedCountEl.textContent = viewedPanels.size;

    compileBtn.addEventListener('click', function () {
        summaryCard.innerHTML =
            '<h4>Recon Summary: Meridian Logistics</h4>' +
            '<ul>' +
            '<li><strong>Infrastructure:</strong> Domain registered 2014-03-11, name servers ns1/ns2.meridianlogix.com</li>' +
            '<li><strong>Technology:</strong> AWS, Kubernetes, Jenkins, Zendesk, Cisco AnyConnect</li>' +
            '<li><strong>People:</strong> 4 employees identified across IT, security, HR, and DevOps</li>' +
            '<li><strong>Exposed Systems:</strong> vpn, mail, portal, and an undocumented staging subdomain (dev.meridianlogix.com)</li>' +
            '</ul>';
        summaryCard.style.display = 'block';
        compileBtn.disabled = true;
        flagArea.style.display = 'block';
        flagArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // ================= TUTORIAL SYSTEM =================
    var tutorialSteps = [
        { id: 'source-tabs', text: 'These tabs represent different public sources you can check without ever contacting the target directly.' },
        { id: 'whois-panel', text: 'WHOIS is like checking public property records. Anyone can see who registered a domain.' },
        { id: 'jobs-panel', text: 'Job postings often leak more than intended. Companies describe their tools without realizing it helps an attacker.' },
        { id: 'employees-panel', text: 'Public employee profiles reveal names, roles, and organizational structure, all without saying a word to anyone.' },
        { id: 'dns-panel', text: 'DNS records are public by design. They can reveal systems the company forgot were exposed.' },
        { id: 'compile-btn', text: 'Once you have reviewed every source, compile what you have learned into a single recon summary.' },
        { id: 'flag-area', text: 'Your completed summary confirms the recon phase is done. The flag appears here.' }
    ];

    var currentStep = 0;
    var spotlight = document.getElementById('spotlight');
    var tooltip = document.getElementById('tooltip');
    var tutorialBtn = document.getElementById('tutorial-btn');
    var completeModal = document.getElementById('tutorial-complete-modal');
    var startChallengeBtn = document.getElementById('start-challenge-btn');

    function panelForStep(step) {
        var map = { 'whois-panel': 'whois', 'jobs-panel': 'jobs', 'employees-panel': 'employees', 'dns-panel': 'dns' };
        return map[step.id];
    }

    function positionSpotlight(el) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlight.style.top = (rect.top - pad) + 'px';
        spotlight.style.left = (rect.left - pad) + 'px';
        spotlight.style.width = (rect.width + pad * 2) + 'px';
        spotlight.style.height = (rect.height + pad * 2) + 'px';
        spotlight.style.display = 'block';

        var tooltipTop = rect.bottom + 14;
        var tooltipLeft = rect.left;
        if (tooltipLeft + 300 > window.innerWidth) {
            tooltipLeft = window.innerWidth - 320;
        }
        if (tooltipTop + 140 > window.innerHeight) {
            tooltipTop = rect.top - 150;
        }
        tooltip.style.top = tooltipTop + 'px';
        tooltip.style.left = tooltipLeft + 'px';
        tooltip.style.display = 'block';
    }

    function renderStep() {
        var step = tutorialSteps[currentStep];
        var panelName = panelForStep(step);
        if (panelName) {
            showPanel(panelName);
        }
        var target = document.getElementById(step.id);

        var rect = target.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function doPosition() {
            positionSpotlight(target);
            tooltip.innerHTML =
                '<p>' + step.text + '</p>' +
                '<div class="tooltip-actions">' +
                '<button id="tutorial-skip">Skip Tutorial</button>' +
                '<button class="next-btn" id="tutorial-next">' + (currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
                '</div>';
            document.getElementById('tutorial-skip').addEventListener('click', endTutorial);
            document.getElementById('tutorial-next').addEventListener('click', nextStep);
        }

        if (!inView) {
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(doPosition, 300);
        } else {
            doPosition();
        }
    }

    function nextStep() {
        currentStep++;
        if (currentStep >= tutorialSteps.length) {
            endTutorial(true);
        } else {
            renderStep();
        }
    }

    function endTutorial(completed) {
        spotlight.style.display = 'none';
        tooltip.style.display = 'none';
        if (completed) {
            completeModal.style.display = 'flex';
        }
    }

    function startTutorial() {
        currentStep = 0;
        renderStep();
    }

    tutorialBtn.addEventListener('click', startTutorial);
    startChallengeBtn.addEventListener('click', function () {
        completeModal.style.display = 'none';
    });

    window.addEventListener('resize', function () {
        if (spotlight.style.display === 'block' && tutorialSteps[currentStep]) {
            var target = document.getElementById(tutorialSteps[currentStep].id);
            if (target) positionSpotlight(target);
        }
    });

    // Auto-start on first load
    window.addEventListener('load', function () {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>
