<?php
// windows-os-hardening-practical.php
// Static standalone practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hardening Console | WIN-SRV-04</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
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

.page {
    max-width: 980px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* ===== Header ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 24px;
}
.header h1 {
    font-size: 1.6rem;
    margin: 0 0 6px 0;
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: box-shadow 0.2s ease;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== Description ===== */
.description-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 26px;
    font-size: 0.92rem;
    color: var(--text-secondary);
}
.description-box strong { color: var(--text-primary); }

/* ===== Risk Score Panel ===== */
#risk-score-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 22px;
    margin-bottom: 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.risk-left { display: flex; align-items: center; gap: 18px; }
.risk-number {
    font-family: "JetBrains Mono", monospace;
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--error);
    transition: color 0.3s ease;
}
.risk-number.mid { color: var(--warning); }
.risk-number.low { color: var(--success); }
.risk-label { color: var(--text-secondary); font-size: 0.85rem; }
#status-badge {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 20px;
    background: rgba(255,92,92,0.12);
    color: var(--error);
    border: 1px solid rgba(255,92,92,0.3);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
#status-badge.partial { background: rgba(255,211,106,0.12); color: var(--warning); border-color: rgba(255,211,106,0.3); }
#status-badge.hardened { background: rgba(61,255,154,0.12); color: var(--success); border-color: rgba(61,255,154,0.3); }

/* ===== Controls Grid ===== */
.controls-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 26px;
}
@media (max-width: 700px) {
    .controls-grid { grid-template-columns: 1fr; }
}
.control-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.control-card.active {
    border-color: var(--success);
    box-shadow: 0 0 0 1px rgba(61,255,154,0.15);
}
.control-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 8px;
}
.control-name {
    font-weight: 600;
    font-size: 0.95rem;
}
.control-desc {
    color: var(--text-secondary);
    font-size: 0.82rem;
    margin: 6px 0 10px 0;
}
.control-mitigation {
    font-size: 0.78rem;
    color: var(--success);
    font-family: "JetBrains Mono", monospace;
    display: none;
}
.control-mitigation.visible { display: block; }

/* Toggle switch */
.toggle-switch {
    position: relative;
    width: 46px;
    height: 26px;
    flex-shrink: 0;
    cursor: pointer;
}
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    transition: background 0.2s ease;
}
.toggle-slider::before {
    content: '';
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    top: 3px;
    background: var(--text-secondary);
    border-radius: 50%;
    transition: transform 0.2s ease, background 0.2s ease;
}
.toggle-switch input:checked + .toggle-slider {
    background: rgba(61,255,154,0.25);
}
.toggle-switch input:checked + .toggle-slider::before {
    transform: translateX(20px);
    background: var(--success);
}

/* ===== Feedback / status area ===== */
#status-feed {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 26px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.8rem;
    color: var(--text-muted);
    min-height: 60px;
}
#status-feed .feed-line { margin: 4px 0; color: var(--text-secondary); }
#status-feed .feed-line.new { color: var(--success); }

/* ===== Flag reveal ===== */
#flag-panel {
    display: none;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(106,227,255,0.05));
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 26px;
    text-align: center;
}
#flag-panel.visible { display: block; }
#flag-panel h3 {
    margin: 0 0 12px 0;
    color: var(--success);
}
#flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 20px;
    display: inline-block;
    color: var(--accent-primary);
    letter-spacing: 0.02em;
    user-select: all;
}

/* ===== Tutorial spotlight ===== */
#spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 999;
}
#tooltip {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 1000;
    box-shadow: var(--glow-accent);
}
#tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
}
#tooltip button {
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 7px 14px;
    cursor: pointer;
    border: none;
}
#tt-next { background: var(--accent-primary); color: #0b0f1a; }
#tt-skip { background: transparent; color: var(--text-muted); }

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 1001;
    align-items: center;
    justify-content: center;
}
.modal-overlay.visible { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { color: var(--success); margin-top: 0; }
.modal-box button {
    margin-top: 18px;
    background: var(--success);
    color: #0b0f1a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>
<div class="page">

    <div class="header">
        <div>
            <h1>Hardening Console</h1>
            <p class="subtitle">Endpoint: WIN-SRV-04 &middot; Flagged as Unhardened</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="description-box">
        <p style="margin:0;">This console represents the security configuration of a single Windows Server endpoint. <strong>WIN-SRV-04</strong> has none of its hardening controls enabled. Work through each control below to bring the endpoint's Risk Score down to zero and reveal the flag.</p>
    </div>

    <div id="risk-score-panel">
        <div class="risk-left">
            <div>
                <div class="risk-number" id="risk-number">100</div>
                <div class="risk-label">Risk Score</div>
            </div>
        </div>
        <div id="status-badge">Unhardened</div>
    </div>

    <div class="controls-grid">

        <div class="control-card" id="control-card-smb" data-points="17">
            <div class="control-top">
                <div>
                    <div class="control-name">Disable SMBv1 &amp; Legacy Services</div>
                </div>
                <label class="toggle-switch" id="control-toggle-smb-wrap">
                    <input type="checkbox" id="control-toggle-smb">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="control-desc">Removes the outdated SMBv1 file sharing protocol and other unused legacy services from the endpoint.</div>
            <div class="control-mitigation" id="mitigation-smb">Mitigated: worm style lateral movement via SMBv1 exploits</div>
        </div>

        <div class="control-card" id="control-card-defender" data-points="17">
            <div class="control-top">
                <div>
                    <div class="control-name">Enable Defender &amp; ASR Rule</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="control-toggle-defender">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="control-desc">Turns on Windows Defender real time protection and enforces the ASR rule blocking Office apps from spawning child processes.</div>
            <div class="control-mitigation" id="mitigation-defender">Mitigated: malicious macro launching PowerShell</div>
        </div>

        <div class="control-card" id="control-card-wdac" data-points="17">
            <div class="control-top">
                <div>
                    <div class="control-name">Enable WDAC Enforcement</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="control-toggle-wdac">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="control-desc">Switches application control from audit mode to enforcement, blocking any unapproved executable from running.</div>
            <div class="control-mitigation" id="mitigation-wdac">Mitigated: unsigned malicious binary execution</div>
        </div>

        <div class="control-card" id="control-card-clm" data-points="16">
            <div class="control-top">
                <div>
                    <div class="control-name">Set PowerShell to Constrained Language Mode</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="control-toggle-clm">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="control-desc">Restricts PowerShell to a limited subset of language features, blocking arbitrary .NET and API access.</div>
            <div class="control-mitigation" id="mitigation-clm">Mitigated: post exploitation PowerShell tooling</div>
        </div>

        <div class="control-card" id="control-card-credguard" data-points="16">
            <div class="control-top">
                <div>
                    <div class="control-name">Enable Credential Guard</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="control-toggle-credguard">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="control-desc">Isolates credential material in a protected, virtualization based memory region separate from the OS.</div>
            <div class="control-mitigation" id="mitigation-credguard">Mitigated: in memory credential extraction</div>
        </div>

        <div class="control-card" id="control-card-lsa" data-points="17">
            <div class="control-top">
                <div>
                    <div class="control-name">Enable LSA Protection</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="control-toggle-lsa">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="control-desc">Marks the LSASS process as protected so that even administrative tools cannot attach and read its memory.</div>
            <div class="control-mitigation" id="mitigation-lsa">Mitigated: direct LSASS memory access</div>
        </div>

    </div>

    <div id="status-feed">
        <div class="feed-line">Awaiting configuration changes...</div>
    </div>

    <div id="flag-panel">
        <h3>Hardening Complete</h3>
        <p style="color: var(--text-secondary); margin-bottom: 16px;">WIN-SRV-04 is now fully hardened. Risk Score: 0.</p>
        <div id="flag-value">CBX{endpoint_hardened}</div>
    </div>

</div>

<div id="spotlight" style="display:none;"></div>
<div id="tooltip" style="display:none;"></div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p style="color: var(--text-secondary);">You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    const controls = ['smb', 'defender', 'wdac', 'clm', 'credguard', 'lsa'];
    const pointsPer = Math.floor(100 / controls.length);
    const riskNumberEl = document.getElementById('risk-number');
    const statusBadge = document.getElementById('status-badge');
    const statusFeed = document.getElementById('status-feed');
    const flagPanel = document.getElementById('flag-panel');

    const mitigationText = {
        smb: 'Legacy protocols removed. SMBv1 based lateral movement is no longer possible.',
        defender: 'Defender active. Office macro to PowerShell chains are now blocked.',
        wdac: 'WDAC enforcing. Unsigned and unapproved binaries can no longer execute.',
        clm: 'PowerShell constrained. Post exploitation scripts lose access to .NET and API calls.',
        credguard: 'Credentials isolated. LSASS memory scraping can no longer expose them.',
        lsa: 'LSASS protected. Administrative tools can no longer attach to the process.'
    };

    let enabledCount = 0;

    function updateRisk() {
        const risk = Math.max(0, 100 - (enabledCount * pointsPer));
        riskNumberEl.textContent = risk;
        riskNumberEl.classList.remove('mid', 'low');
        if (risk === 0) {
            riskNumberEl.classList.add('low');
        } else if (risk <= 66) {
            riskNumberEl.classList.add('mid');
        }

        statusBadge.classList.remove('partial', 'hardened');
        if (enabledCount === 0) {
            statusBadge.textContent = 'Unhardened';
        } else if (enabledCount < controls.length) {
            statusBadge.textContent = 'Partially Hardened';
            statusBadge.classList.add('partial');
        } else {
            statusBadge.textContent = 'Fully Hardened';
            statusBadge.classList.add('hardened');
        }

        if (enabledCount === controls.length) {
            flagPanel.classList.add('visible');
            flagPanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            flagPanel.classList.remove('visible');
        }
    }

    function addFeedLine(text) {
        const line = document.createElement('div');
        line.className = 'feed-line new';
        line.textContent = text;
        statusFeed.appendChild(line);
        statusFeed.scrollTop = statusFeed.scrollHeight;
    }

    controls.forEach(function (key) {
        const toggle = document.getElementById('control-toggle-' + key);
        const card = document.getElementById('control-card-' + key);
        const mitigation = document.getElementById('mitigation-' + key);

        toggle.addEventListener('change', function () {
            if (toggle.checked) {
                enabledCount++;
                card.classList.add('active');
                mitigation.classList.add('visible');
                addFeedLine('[+] ' + mitigationText[key]);
            } else {
                enabledCount--;
                card.classList.remove('active');
                mitigation.classList.remove('visible');
                addFeedLine('[-] Control disabled. Risk reintroduced.');
            }
            updateRisk();
        });
    });

    updateRisk();

    // =========================================================
    // Spotlight Tutorial System
    // =========================================================
    const tutorialSteps = [
        {
            targetId: 'risk-score-panel',
            text: "This is your endpoint's Risk Score. Right now it's at maximum because none of the hardening controls below are active. Think of it as an attacker's odds of success."
        },
        {
            targetId: 'control-card-smb',
            text: "Each card below is a hardening control. This one disables SMBv1 and legacy services, protocols attackers commonly abuse for lateral movement, like in the WannaCry outbreak."
        },
        {
            targetId: 'control-toggle-smb-wrap',
            text: "Click this toggle to enable a control. Watch how the Risk Score reacts."
        },
        {
            targetId: 'status-badge',
            text: "This badge tracks your overall hardening status. It updates as you enable more controls."
        },
        {
            targetId: 'control-card-lsa',
            text: "The last control here is LSA Protection. This is often the final piece of the puzzle, it stops attackers from dumping credentials straight out of memory."
        },
        {
            targetId: 'view-tutorial-btn',
            text: "You can replay this tutorial anytime using this button. Now, harden all six controls to reveal your flag."
        }
    ];

    let currentStep = 0;
    const spotlight = document.getElementById('spotlight');
    const tooltip = document.getElementById('tooltip');
    const tutorialBtn = document.getElementById('view-tutorial-btn');
    const completeModal = document.getElementById('complete-modal');
    const startChallengeBtn = document.getElementById('start-challenge-btn');

    function positionSpotlight(el) {
        const rect = el.getBoundingClientRect();
        const pad = 8;
        spotlight.style.top = (rect.top - pad) + 'px';
        spotlight.style.left = (rect.left - pad) + 'px';
        spotlight.style.width = (rect.width + pad * 2) + 'px';
        spotlight.style.height = (rect.height + pad * 2) + 'px';
    }

    function positionTooltip(el) {
        const rect = el.getBoundingClientRect();
        const ttRect = tooltip.getBoundingClientRect();
        let top = rect.bottom + 14;
        let left = rect.left;

        if (top + ttRect.height > window.innerHeight) {
            top = rect.top - ttRect.height - 14;
        }
        if (left + 280 > window.innerWidth) {
            left = window.innerWidth - 300;
        }
        if (left < 10) left = 10;
        if (top < 10) top = rect.bottom + 14;

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
    }

    function renderTooltipContent(step) {
        tooltip.innerHTML =
            '<div>' + step.text + '</div>' +
            '<div class="tt-actions">' +
                '<button id="tt-skip">Skip Tutorial</button>' +
                '<button id="tt-next">' + (currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
            '</div>';
        document.getElementById('tt-skip').addEventListener('click', endTutorial);
        document.getElementById('tt-next').addEventListener('click', nextStep);
    }

    function showStep(index) {
        const step = tutorialSteps[index];
        const el = document.getElementById(step.targetId);
        if (!el) { nextStep(); return; }

        const rect = el.getBoundingClientRect();
        const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function place() {
            positionSpotlight(el);
            renderTooltipContent(step);
            positionTooltip(el);
        }

        if (!inView) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(place, 300);
        } else {
            place();
        }
    }

    function startTutorial() {
        currentStep = 0;
        spotlight.style.display = 'block';
        tooltip.style.display = 'block';
        showStep(currentStep);
    }

    function nextStep() {
        currentStep++;
        if (currentStep >= tutorialSteps.length) {
            endTutorial(true);
            return;
        }
        showStep(currentStep);
    }

    function endTutorial(completed) {
        spotlight.style.display = 'none';
        tooltip.style.display = 'none';
        if (completed) {
            completeModal.classList.add('visible');
        }
    }

    startChallengeBtn.addEventListener('click', function () {
        completeModal.classList.remove('visible');
    });

    tutorialBtn.addEventListener('click', startTutorial);

    window.addEventListener('resize', function () {
        if (spotlight.style.display === 'block') {
            const step = tutorialSteps[currentStep];
            const el = document.getElementById(step.targetId);
            if (el) {
                positionSpotlight(el);
                positionTooltip(el);
            }
        }
    });

    // Auto start tutorial on first load
    window.addEventListener('load', function () {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>
