<?php
// ============================================================
// vpn-architecture-implementation-practical.php
// Standalone static practical: VPN Gateway Configuration Auditor
// No backend logic. No database. No flag submission input.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VPN Gateway Configuration Auditor</title>
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
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        min-height: 100vh;
    }

    .page-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 30px 20px 80px 20px;
    }

    /* ===== Header ===== */
    .top-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 16px;
        flex-wrap: wrap;
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
        max-width: 560px;
    }

    .tutorial-btn {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        color: var(--accent-primary);
        padding: 10px 18px;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .tutorial-btn:hover {
        box-shadow: var(--glow-accent);
        background: rgba(106,227,255,0.08);
    }

    /* ===== Description ===== */
    .briefing-box {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 20px 24px;
        margin-bottom: 30px;
    }

    .briefing-box h2 {
        font-size: 1.05rem;
        margin: 0 0 10px 0;
        color: var(--accent-primary);
    }

    .briefing-box p {
        color: var(--text-secondary);
        font-size: 0.92rem;
        line-height: 1.6;
        margin: 0 0 10px 0;
    }

    .briefing-box p:last-child { margin-bottom: 0; }

    /* ===== Config cards ===== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 18px;
        margin-bottom: 26px;
    }

    .config-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px 20px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .config-card.correct {
        border-color: var(--success);
        box-shadow: 0 0 14px rgba(61,255,154,0.15);
    }

    .config-card.incorrect {
        border-color: var(--error);
    }

    .config-card h3 {
        font-size: 0.95rem;
        margin: 0 0 4px 0;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-status-icon {
        font-size: 0.9rem;
    }

    .config-card .current-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .config-card select {
        width: 100%;
        background: var(--bg-primary);
        color: var(--text-primary);
        border: 1px solid var(--border-default);
        border-radius: 6px;
        padding: 9px 10px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.82rem;
        margin-bottom: 10px;
    }

    .card-feedback {
        font-size: 0.78rem;
        line-height: 1.5;
        min-height: 18px;
    }

    .card-feedback.correct { color: var(--success); }
    .card-feedback.incorrect { color: var(--error); }

    /* ===== Status panel ===== */
    .status-panel {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 20px 24px;
        margin-bottom: 26px;
    }

    .status-panel h3 {
        font-size: 0.95rem;
        margin: 0 0 12px 0;
        color: var(--text-primary);
    }

    .progress-track {
        width: 100%;
        height: 10px;
        background: var(--bg-primary);
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border-default);
    }

    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--accent-secondary), var(--accent-primary));
        transition: width 0.4s ease;
    }

    .progress-label {
        margin-top: 8px;
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-family: 'JetBrains Mono', monospace;
    }

    /* ===== Flag reveal ===== */
    .flag-area {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 24px;
        text-align: center;
        display: none;
    }

    .flag-area.revealed {
        display: block;
        border-color: var(--success);
        box-shadow: 0 0 18px rgba(61,255,154,0.18);
    }

    .flag-area h3 {
        color: var(--success);
        margin: 0 0 10px 0;
        font-size: 1.05rem;
    }

    .flag-readout {
        display: inline-block;
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.1rem;
        color: var(--accent-primary);
        background: var(--bg-primary);
        border: 1px solid var(--accent-primary);
        border-radius: 8px;
        padding: 12px 22px;
        letter-spacing: 0.02em;
    }

    /* ===== Tutorial spotlight ===== */
    .spotlight {
        position: fixed;
        border-radius: 8px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        pointer-events: none;
        transition: all 0.3s ease;
        z-index: 9998;
    }

    .tooltip-card {
        position: fixed;
        max-width: 300px;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px 18px;
        z-index: 9999;
        box-shadow: var(--glow-accent);
    }

    .tooltip-card p {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0 0 14px 0;
    }

    .tooltip-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tooltip-step-count {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-family: 'JetBrains Mono', monospace;
    }

    .tooltip-buttons button {
        background: transparent;
        border: 1px solid var(--border-default);
        color: var(--text-secondary);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.78rem;
        cursor: pointer;
        margin-left: 8px;
    }

    .tooltip-buttons button.primary {
        background: var(--accent-primary);
        border-color: var(--accent-primary);
        color: #06131c;
        font-weight: 600;
    }

    /* ===== Modal ===== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.75);
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
        box-shadow: var(--glow-accent);
    }

    .modal-box h3 {
        margin: 0 0 12px 0;
        color: var(--accent-primary);
        font-size: 1.1rem;
    }

    .modal-box p {
        color: var(--text-secondary);
        font-size: 0.88rem;
        margin: 0 0 20px 0;
    }

    .modal-box button {
        background: var(--accent-primary);
        border: none;
        color: #06131c;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.88rem;
    }

    @media (max-width: 600px) {
        .top-header { flex-direction: column; }
        .cards-grid { grid-template-columns: 1fr; }
    }
</style>
</head>
<body>

<div class="page-wrap">

    <!-- ===== Section 1: Top Header ===== -->
    <div class="top-header" id="dashboard-header">
        <div>
            <h1>VPN Gateway Configuration Auditor</h1>
            <p class="subtitle">A regional office gateway failed a routine security review. Correct every flagged setting to bring it up to standard.</p>
        </div>
        <button class="tutorial-btn" id="tutorial-restart-btn">View Tutorial</button>
    </div>

    <!-- ===== Section 2: Description ===== -->
    <div class="briefing-box">
        <h2>Mission Briefing</h2>
        <p>This panel represents the live configuration of a VPN gateway serving remote employees. An internal audit flagged five settings as insecure. Your task is to review each configuration card and set it to the value that matches secure VPN engineering practice.</p>
        <p>Each card can be corrected independently. Once every card shows a secure configuration, the gateway status will update and reveal a completion flag.</p>
    </div>

    <!-- ===== Section 3: Main Interactive Environment ===== -->
    <div class="cards-grid">

        <div class="config-card" id="card-protocol" data-correct="ipsec">
            <h3><span class="card-status-icon">🔧</span> Tunnel Protocol</h3>
            <p class="current-value">Current: PPTP</p>
            <select id="select-protocol">
                <option value="" selected disabled>Select a value</option>
                <option value="pptp">PPTP</option>
                <option value="ipsec">IPSec (IKEv2)</option>
                <option value="telnet-tunnel">Telnet Tunnel</option>
            </select>
            <p class="card-feedback" id="feedback-protocol"></p>
        </div>

        <div class="config-card" id="card-cipher" data-correct="aes256">
            <h3><span class="card-status-icon">🔧</span> Cipher Suite</h3>
            <p class="current-value">Current: DES-CBC</p>
            <select id="select-cipher">
                <option value="" selected disabled>Select a value</option>
                <option value="des">DES-CBC</option>
                <option value="rc4">RC4</option>
                <option value="aes256">AES-256-GCM</option>
            </select>
            <p class="card-feedback" id="feedback-cipher"></p>
        </div>

        <div class="config-card" id="card-auth" data-correct="cert">
            <h3><span class="card-status-icon">🔧</span> Authentication Method</h3>
            <p class="current-value">Current: Pre-Shared Key</p>
            <select id="select-auth">
                <option value="" selected disabled>Select a value</option>
                <option value="psk">Pre-Shared Key</option>
                <option value="password">Username and Password</option>
                <option value="cert">Certificate-Based</option>
            </select>
            <p class="card-feedback" id="feedback-auth"></p>
        </div>

        <div class="config-card" id="card-splittunnel" data-correct="disabled">
            <h3><span class="card-status-icon">🔧</span> Split Tunnelling</h3>
            <p class="current-value">Current: Enabled for all routes</p>
            <select id="select-splittunnel">
                <option value="" selected disabled>Select a value</option>
                <option value="enabled">Enabled for all routes</option>
                <option value="disabled">Disabled</option>
                <option value="partial">Enabled, admin subnet included</option>
            </select>
            <p class="card-feedback" id="feedback-splittunnel"></p>
        </div>

        <div class="config-card" id="card-management" data-correct="vlan">
            <h3><span class="card-status-icon">🔧</span> Management Interface</h3>
            <p class="current-value">Current: Exposed to WAN (0.0.0.0/0)</p>
            <select id="select-management">
                <option value="" selected disabled>Select a value</option>
                <option value="wan">Exposed to WAN (0.0.0.0/0)</option>
                <option value="vlan">Restricted to Management VLAN</option>
                <option value="lan-open">Open to Entire LAN</option>
            </select>
            <p class="card-feedback" id="feedback-management"></p>
        </div>

    </div>

    <!-- ===== Section 4: Feedback / Status Area ===== -->
    <div class="status-panel" id="status-panel">
        <h3>Gateway Hardening Progress</h3>
        <div class="progress-track">
            <div class="progress-fill" id="progress-fill"></div>
        </div>
        <p class="progress-label" id="progress-label">0 of 5 settings corrected</p>
    </div>

    <!-- ===== Section 5: Flag Reveal Area ===== -->
    <div class="flag-area" id="flag-area">
        <h3>Gateway Hardened</h3>
        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 16px;">Every flagged setting has been corrected. The gateway now meets secure configuration standards.</p>
        <div class="flag-readout" id="flag-readout">CBX{gateway_hardened}</div>
    </div>

</div>

<!-- ===== Tutorial Complete Modal ===== -->
<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Correct all five configuration cards to harden the gateway.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    const cardIds = ['card-protocol', 'card-cipher', 'card-auth', 'card-splittunnel', 'card-management'];
    const selectIds = ['select-protocol', 'select-cipher', 'select-auth', 'select-splittunnel', 'select-management'];
    const feedbackIds = ['feedback-protocol', 'feedback-cipher', 'feedback-auth', 'feedback-splittunnel', 'feedback-management'];

    const feedbackMessages = {
        'select-protocol': {
            correct: 'IKEv2 based IPSec provides strong, modern tunnel security.',
            incorrect: 'This protocol is outdated or insecure for a production gateway.'
        },
        'select-cipher': {
            correct: 'AES-256-GCM is a strong, modern cipher suite.',
            incorrect: 'This cipher is weak or deprecated and can be broken with modern tools.'
        },
        'select-auth': {
            correct: 'Certificate-based authentication resists credential theft and phishing.',
            incorrect: 'This method can be phished, guessed, or leaked more easily than a certificate.'
        },
        'select-splittunnel': {
            correct: 'Disabling split tunnelling ensures all traffic is protected by the tunnel.',
            incorrect: 'This configuration leaves a path for local network compromise to reach the corporate network.'
        },
        'select-management': {
            correct: 'Restricting management access to a dedicated VLAN prevents internet based attacks on the gateway itself.',
            incorrect: 'Exposing the management interface this broadly invites direct attacks on the gateway.'
        }
    };

    function checkAll() {
        let correctCount = 0;

        selectIds.forEach((selId, idx) => {
            const select = document.getElementById(selId);
            const card = document.getElementById(cardIds[idx]);
            const feedback = document.getElementById(feedbackIds[idx]);
            const correctValue = card.getAttribute('data-correct');

            if (!select.value) return;

            if (select.value === correctValue) {
                card.classList.add('correct');
                card.classList.remove('incorrect');
                feedback.textContent = feedbackMessages[selId].correct;
                feedback.className = 'card-feedback correct';
                correctCount++;
            } else {
                card.classList.add('incorrect');
                card.classList.remove('correct');
                feedback.textContent = feedbackMessages[selId].incorrect;
                feedback.className = 'card-feedback incorrect';
            }
        });

        const pct = Math.round((correctCount / selectIds.length) * 100);
        document.getElementById('progress-fill').style.width = pct + '%';
        document.getElementById('progress-label').textContent = correctCount + ' of ' + selectIds.length + ' settings corrected';

        if (correctCount === selectIds.length) {
            document.getElementById('flag-area').classList.add('revealed');
            document.getElementById('flag-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            document.getElementById('flag-area').classList.remove('revealed');
        }
    }

    selectIds.forEach(id => {
        document.getElementById(id).addEventListener('change', checkAll);
    });

    // ================================================
    // Tutorial System (Spotlight-Based)
    // ================================================
    const tutorialSteps = [
        { targetElementId: 'dashboard-header', tooltipText: 'This is your VPN Gateway Configuration Panel. Each card below represents a live setting on the gateway, similar to a real admin dashboard.' },
        { targetElementId: 'card-protocol', tooltipText: 'This card controls which tunnel protocol the gateway uses. Some protocols are outdated and no longer considered secure.' },
        { targetElementId: 'card-cipher', tooltipText: 'This controls the encryption cipher protecting tunnel traffic. Weak or old ciphers can be broken with modern computing power.' },
        { targetElementId: 'card-auth', tooltipText: 'This controls how remote users prove their identity to the gateway. Some methods are far easier to steal or guess than others.' },
        { targetElementId: 'card-splittunnel', tooltipText: 'This controls whether all traffic goes through the tunnel, or only some of it. Leaving gaps here can expose the corporate network.' },
        { targetElementId: 'card-management', tooltipText: 'This controls who can reach the gateway administrative interface. Leaving it open to the internet invites direct attacks.' },
        { targetElementId: 'status-panel', tooltipText: 'As you correct each setting, this status panel tracks your progress toward a fully hardened gateway.' }
    ];

    let currentStep = 0;
    let spotlightEl, tooltipEl;

    function createTutorialElements() {
        spotlightEl = document.createElement('div');
        spotlightEl.className = 'spotlight';
        document.body.appendChild(spotlightEl);

        tooltipEl = document.createElement('div');
        tooltipEl.className = 'tooltip-card';
        document.body.appendChild(tooltipEl);
    }

    function removeTutorialElements() {
        if (spotlightEl) spotlightEl.remove();
        if (tooltipEl) tooltipEl.remove();
        spotlightEl = null;
        tooltipEl = null;
    }

    function positionSpotlight(target) {
        const rect = target.getBoundingClientRect();
        const padding = 8;
        spotlightEl.style.top = (rect.top - padding) + 'px';
        spotlightEl.style.left = (rect.left - padding) + 'px';
        spotlightEl.style.width = (rect.width + padding * 2) + 'px';
        spotlightEl.style.height = (rect.height + padding * 2) + 'px';
    }

    function positionTooltip(target) {
        const rect = target.getBoundingClientRect();
        const tooltipWidth = 300;
        const margin = 14;

        let top = rect.bottom + margin;
        let left = rect.left;

        if (top + 150 > window.innerHeight) {
            top = rect.top - margin - 150;
        }
        if (left + tooltipWidth > window.innerWidth) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (left < 10) left = 10;
        if (top < 10) top = 10;

        tooltipEl.style.top = top + 'px';
        tooltipEl.style.left = left + 'px';
    }

    function renderStep() {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetElementId);

        if (!target) { nextStep(); return; }

        const rect = target.getBoundingClientRect();
        const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

        if (!isVisible) {
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => {
                positionSpotlight(target);
                positionTooltip(target);
            }, 300);
        } else {
            positionSpotlight(target);
            positionTooltip(target);
        }

        const isLast = currentStep === tutorialSteps.length - 1;
        tooltipEl.innerHTML = `
            <p>${step.tooltipText}</p>
            <div class="tooltip-actions">
                <span class="tooltip-step-count">${currentStep + 1} / ${tutorialSteps.length}</span>
                <div class="tooltip-buttons">
                    <button id="tutorial-skip-btn">Skip Tutorial</button>
                    <button class="primary" id="tutorial-next-btn">${isLast ? 'Finish' : 'Next'}</button>
                </div>
            </div>
        `;

        document.getElementById('tutorial-skip-btn').addEventListener('click', endTutorial);
        document.getElementById('tutorial-next-btn').addEventListener('click', () => {
            if (isLast) {
                endTutorial(true);
            } else {
                nextStep();
            }
        });
    }

    function nextStep() {
        currentStep++;
        if (currentStep >= tutorialSteps.length) {
            endTutorial(true);
        } else {
            renderStep();
        }
    }

    function startTutorial() {
        currentStep = 0;
        createTutorialElements();
        renderStep();
    }

    function endTutorial(completed) {
        removeTutorialElements();
        if (completed) {
            document.getElementById('tutorial-complete-modal').classList.add('active');
        }
    }

    document.getElementById('tutorial-restart-btn').addEventListener('click', startTutorial);
    document.getElementById('start-challenge-btn').addEventListener('click', () => {
        document.getElementById('tutorial-complete-modal').classList.remove('active');
    });

    window.addEventListener('resize', () => {
        if (spotlightEl && tooltipEl) {
            const step = tutorialSteps[currentStep];
            const target = document.getElementById(step.targetElementId);
            if (target) {
                positionSpotlight(target);
                positionTooltip(target);
            }
        }
    });

    // Auto-start tutorial on first load
    window.addEventListener('load', () => {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>
