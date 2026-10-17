<?php
// ============================================================
// ad-security-engineering-practical.php
// Standalone practical: Domain Security Console
// Static HTML/CSS/JS only. No backend logic, no sessions.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Domain Security Console</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
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

.mono { font-family: 'JetBrains Mono', monospace; }

/* ===== HEADER ===== */
.header {
    padding: 28px 24px 20px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    position: relative;
}
.header h1 {
    margin: 0 0 6px;
    font-size: 1.6rem;
    font-weight: 700;
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 720px;
}
.tutorial-btn {
    position: absolute;
    top: 24px;
    right: 24px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 9px 16px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover { background: rgba(106,227,255,0.1); box-shadow: var(--glow-accent); }

/* ===== DESCRIPTION ===== */
.description {
    max-width: 900px;
    margin: 20px auto 0;
    padding: 0 24px;
    color: var(--text-secondary);
    font-size: 0.92rem;
    line-height: 1.6;
}

/* ===== MAIN ENVIRONMENT ===== */
.console {
    max-width: 1000px;
    margin: 24px auto;
    padding: 0 24px;
}

.score-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
    text-align: center;
}
.score-label {
    color: var(--text-muted);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 8px;
}
.score-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 2.6rem;
    font-weight: 600;
    color: var(--accent-primary);
    transition: color 0.3s ease;
}
.score-value.complete { color: var(--success); }
.score-bar-track {
    height: 8px;
    background: rgba(255,255,255,0.06);
    border-radius: 4px;
    margin-top: 14px;
    overflow: hidden;
}
.score-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, var(--accent-secondary), var(--accent-primary));
    border-radius: 4px;
    transition: width 0.4s ease;
}

.controls-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
}

.control-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.control-card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
}
.control-name {
    font-weight: 600;
    font-size: 0.95rem;
}
.control-state {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    padding: 3px 9px;
    border-radius: 20px;
    white-space: nowrap;
}
.control-state.insecure { background: rgba(255,92,92,0.15); color: var(--error); }
.control-state.hardened { background: rgba(61,255,154,0.15); color: var(--success); }

.control-current {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 12px;
}
.control-current .arrow { color: var(--text-secondary); margin: 0 6px; }
.control-current .target { color: var(--accent-primary); }

.toggle-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
}
.toggle-switch {
    position: relative;
    width: 46px;
    height: 24px;
    background: rgba(255,92,92,0.3);
    border-radius: 20px;
    cursor: pointer;
    transition: background 0.25s ease;
    flex-shrink: 0;
}
.toggle-switch.on { background: rgba(61,255,154,0.35); }
.toggle-knob {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    transition: left 0.25s ease;
}
.toggle-switch.on .toggle-knob { left: 25px; }
.toggle-caption { font-size: 0.82rem; color: var(--text-secondary); }

.control-hint {
    font-size: 0.82rem;
    color: var(--text-muted);
    line-height: 1.5;
    border-top: 1px solid var(--border-default);
    padding-top: 10px;
}

/* ===== FEEDBACK AREA ===== */
.feedback-area {
    margin-top: 24px;
    min-height: 30px;
    font-size: 0.9rem;
    color: var(--success);
    text-align: center;
    font-family: 'JetBrains Mono', monospace;
}

/* ===== FLAG REVEAL ===== */
.flag-panel {
    margin-top: 28px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 26px;
    text-align: center;
}
.flag-panel.locked .flag-value { color: var(--text-muted); }
.flag-panel.unlocked {
    border-color: var(--success);
    box-shadow: 0 0 24px rgba(61,255,154,0.15);
}
.flag-panel h3 {
    margin: 0 0 12px;
    font-size: 1rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--success);
    user-select: all;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
    pointer-events: none;
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
    box-shadow: var(--glow-accent);
    font-size: 0.85rem;
    line-height: 1.5;
    color: var(--text-primary);
}
.tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
}
.tt-skip {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.tt-next {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    padding: 7px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

/* ===== MODAL ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-box h2 {
    margin: 0 0 12px;
    font-size: 1.2rem;
}
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 20px; }
.modal-box button {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
</style>
</head>
<body>

<div class="header">
    <h1>Domain Security Console</h1>
    <p class="subtitle">A partially hardened Active Directory domain is loaded below. Correct each misconfiguration to raise the Domain Security Score.</p>
    <button class="tutorial-btn" id="tutorialBtn">View Tutorial</button>
</div>

<div class="description">
    <p>This console represents a live view into a domain's security posture. Six controls are currently shown in their default or misconfigured state, the same kind of gaps found in real environments. Toggle each control to its hardened state. Your goal is to bring the Domain Security Score to 100%.</p>
</div>

<div class="console">

    <div class="score-panel" id="security-score-display">
        <div class="score-label">Domain Security Score</div>
        <div class="score-value" id="scoreValue">0%</div>
        <div class="score-bar-track"><div class="score-bar-fill" id="scoreBar"></div></div>
    </div>

    <div class="controls-grid">

        <div class="control-card" id="control-tier0-ou">
            <div class="control-card-top">
                <div class="control-name">Tier 0 Admin OU Placement</div>
                <div class="control-state insecure" id="state-0">INSECURE</div>
            </div>
            <div class="control-current">DA-SvcAdmin in <span class="mono">Users</span><span class="arrow">→</span><span class="target">Tier 0 Admins OU</span></div>
            <div class="toggle-row">
                <div class="toggle-switch" data-control="0"><div class="toggle-knob"></div></div>
                <div class="toggle-caption">Move to Tier 0 Admins OU</div>
            </div>
            <div class="control-hint">Privileged accounts outside the tiered OU structure can be managed by lower-tier admins, breaking the tiering model.</div>
        </div>

        <div class="control-card" id="control-protected-users">
            <div class="control-card-top">
                <div class="control-name">Protected Users Group</div>
                <div class="control-state insecure" id="state-1">INSECURE</div>
            </div>
            <div class="control-current">DA-SvcAdmin <span class="arrow">→</span><span class="target">Add to Protected Users</span></div>
            <div class="toggle-row">
                <div class="toggle-switch" data-control="1"><div class="toggle-knob"></div></div>
                <div class="toggle-caption">Add account to Protected Users</div>
            </div>
            <div class="control-hint">Accounts outside Protected Users can authenticate with NTLM and cache credentials in memory, exposing them to Pass-the-Hash.</div>
        </div>

        <div class="control-card" id="control-fgpp">
            <div class="control-card-top">
                <div class="control-name">Fine-Grained Password Policy</div>
                <div class="control-state insecure" id="state-2">INSECURE</div>
            </div>
            <div class="control-current">No PSO <span class="arrow">→</span><span class="target">Apply Tier0-PSO</span></div>
            <div class="toggle-row">
                <div class="toggle-switch" data-control="2"><div class="toggle-knob"></div></div>
                <div class="toggle-caption">Apply Tier0-PSO to account</div>
            </div>
            <div class="control-hint">Without a PSO, privileged accounts follow the same weak domain-wide policy as standard users.</div>
        </div>

        <div class="control-card" id="control-ldap-signing">
            <div class="control-card-top">
                <div class="control-name">LDAP Server Signing</div>
                <div class="control-state insecure" id="state-3">INSECURE</div>
            </div>
            <div class="control-current">None <span class="arrow">→</span><span class="target">Require Signing</span></div>
            <div class="toggle-row">
                <div class="toggle-switch" data-control="3"><div class="toggle-knob"></div></div>
                <div class="toggle-caption">Set to Require Signing</div>
            </div>
            <div class="control-hint">Without signing, LDAP traffic can be tampered with or relayed by an attacker on the network.</div>
        </div>

        <div class="control-card" id="control-channel-binding">
            <div class="control-card-top">
                <div class="control-name">LDAP Channel Binding</div>
                <div class="control-state insecure" id="state-4">INSECURE</div>
            </div>
            <div class="control-current">Never <span class="arrow">→</span><span class="target">Always</span></div>
            <div class="toggle-row">
                <div class="toggle-switch" data-control="4"><div class="toggle-knob"></div></div>
                <div class="toggle-caption">Set to Always</div>
            </div>
            <div class="control-hint">Without channel binding, an LDAP session over TLS can still be relayed to a different destination.</div>
        </div>

        <div class="control-card" id="control-audit-policy">
            <div class="control-card-top">
                <div class="control-name">Advanced Audit Policy (DS Access)</div>
                <div class="control-state insecure" id="state-5">INSECURE</div>
            </div>
            <div class="control-current">Disabled <span class="arrow">→</span><span class="target">Enable Success/Failure</span></div>
            <div class="toggle-row">
                <div class="toggle-switch" data-control="5"><div class="toggle-knob"></div></div>
                <div class="toggle-caption">Enable auditing</div>
            </div>
            <div class="control-hint">Without this audit category enabled, a DCSync attack generating Event ID 4662 would go completely unlogged.</div>
        </div>

    </div>

    <div class="feedback-area" id="feedbackArea"></div>

    <div class="flag-panel locked" id="flag-reveal-panel">
        <h3>Flag</h3>
        <div class="flag-value" id="flagValue">Harden every control to reveal the flag</div>
    </div>

</div>

<!-- Tutorial spotlight elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltipCard" style="display:none;">
    <div id="tooltipText"></div>
    <div class="tt-actions">
        <button class="tt-skip" id="skipTutorialBtn">Skip Tutorial</button>
        <button class="tt-next" id="nextStepBtn">Next</button>
    </div>
</div>

<!-- Completion modal -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <h2>Tutorial Complete</h2>
        <p>You're ready to start the challenge. Toggle each control to its hardened state to raise the Domain Security Score to 100%.</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    const TOTAL_CONTROLS = 6;
    const controlState = [false, false, false, false, false, false];
    const FLAG = "CBX{domain_hardened}";

    const scoreValue = document.getElementById('scoreValue');
    const scoreBar = document.getElementById('scoreBar');
    const feedbackArea = document.getElementById('feedbackArea');
    const flagPanel = document.getElementById('flag-reveal-panel');
    const flagValue = document.getElementById('flagValue');

    const hints = [
        "Tier 0 Admin OU Placement hardened. This account can no longer be managed by lower-tier admins.",
        "Protected Users membership added. NTLM authentication and credential caching are now blocked.",
        "Fine-Grained Password Policy applied. This account now follows a stricter policy than the domain default.",
        "LDAP signing now required. Directory traffic can no longer be tampered with in transit.",
        "LDAP channel binding set to Always. Relayed sessions are no longer possible.",
        "Directory Service Access auditing enabled. DCSync activity will now generate log evidence."
    ];

    document.querySelectorAll('.toggle-switch').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const idx = parseInt(toggle.getAttribute('data-control'), 10);
            if (controlState[idx]) return; // already hardened, one-way toggle
            controlState[idx] = true;
            toggle.classList.add('on');

            const stateBadge = document.getElementById('state-' + idx);
            stateBadge.textContent = 'HARDENED';
            stateBadge.classList.remove('insecure');
            stateBadge.classList.add('hardened');

            feedbackArea.textContent = hints[idx];
            updateScore();
        });
    });

    function updateScore() {
        const hardenedCount = controlState.filter(Boolean).length;
        const pct = Math.round((hardenedCount / TOTAL_CONTROLS) * 100);
        scoreValue.textContent = pct + '%';
        scoreBar.style.width = pct + '%';

        if (pct === 100) {
            scoreValue.classList.add('complete');
            flagPanel.classList.remove('locked');
            flagPanel.classList.add('unlocked');
            flagValue.textContent = FLAG;
            feedbackArea.textContent = 'Domain hardened. All controls are now in their secure state.';
        }
    }

    // ===== TUTORIAL SYSTEM =====
    const steps = [
        { id: 'security-score-display', text: 'This is your Domain Security Score. It starts low because this domain has several real misconfigurations, the same kind seen in actual breaches. Fixing each control below raises this score.' },
        { id: 'control-tier0-ou', text: 'This account currently sits outside the tiered admin structure. In a real domain, that means a helpdesk admin could reset this account\'s password. Toggle it to move the account into the correct OU.' },
        { id: 'control-protected-users', text: 'Protected Users is a built-in group that blocks NTLM authentication and credential caching for its members. This account isn\'t in it yet.' },
        { id: 'control-fgpp', text: 'Fine-Grained Password Policies let you apply a stricter policy to privileged accounts without changing the policy for everyone else.' },
        { id: 'control-ldap-signing', text: 'LDAP signing stops an attacker on the network from tampering with directory traffic. This DC currently has it turned off.' },
        { id: 'control-channel-binding', text: 'Channel binding ties an LDAP session to its underlying TLS channel, closing a relay path that signing alone doesn\'t cover.' },
        { id: 'control-audit-policy', text: 'This audit category is what actually generates the log evidence needed to detect attacks like DCSync. Right now, nothing is being recorded.' },
        { id: 'flag-reveal-panel', text: 'Once every control above is hardened and your score hits 100%, your flag will appear right here.' }
    ];
    let currentStep = 0;
    let tutorialActive = false;

    const spotlight = document.getElementById('spotlight');
    const tooltipCard = document.getElementById('tooltipCard');
    const tooltipText = document.getElementById('tooltipText');
    const nextStepBtn = document.getElementById('nextStepBtn');
    const skipTutorialBtn = document.getElementById('skipTutorialBtn');
    const tutorialBtn = document.getElementById('tutorialBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const startChallengeBtn = document.getElementById('startChallengeBtn');

    function positionSpotlight(el) {
        const rect = el.getBoundingClientRect();
        const pad = 8;
        spotlight.style.top = (rect.top - pad) + 'px';
        spotlight.style.left = (rect.left - pad) + 'px';
        spotlight.style.width = (rect.width + pad * 2) + 'px';
        spotlight.style.height = (rect.height + pad * 2) + 'px';

        const tooltipWidth = 300;
        let top = rect.bottom + 14;
        let left = rect.left;

        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 160 > window.innerHeight) {
            top = rect.top - 170;
        }
        if (left < 10) left = 10;

        tooltipCard.style.top = top + 'px';
        tooltipCard.style.left = left + 'px';
    }

    function showStep(index) {
        const step = steps[index];
        const el = document.getElementById(step.id);
        if (!el) return;

        const rect = el.getBoundingClientRect();
        const inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function render() {
            spotlight.style.display = 'block';
            tooltipCard.style.display = 'block';
            tooltipText.textContent = step.text;
            nextStepBtn.textContent = (index === steps.length - 1) ? 'Finish' : 'Next';
            positionSpotlight(el);
        }

        if (!inView) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(render, 300);
        } else {
            render();
        }
    }

    function startTutorial() {
        tutorialActive = true;
        currentStep = 0;
        showStep(currentStep);
    }

    function endTutorial(showModal) {
        tutorialActive = false;
        spotlight.style.display = 'none';
        tooltipCard.style.display = 'none';
        if (showModal) {
            modalOverlay.classList.add('show');
        }
    }

    nextStepBtn.addEventListener('click', function () {
        currentStep++;
        if (currentStep >= steps.length) {
            endTutorial(true);
        } else {
            showStep(currentStep);
        }
    });

    skipTutorialBtn.addEventListener('click', function () {
        endTutorial(false);
    });

    tutorialBtn.addEventListener('click', function () {
        startTutorial();
    });

    startChallengeBtn.addEventListener('click', function () {
        modalOverlay.classList.remove('show');
    });

    window.addEventListener('resize', function () {
        if (tutorialActive) {
            const step = steps[currentStep];
            const el = document.getElementById(step.id);
            if (el) positionSpotlight(el);
        }
    });

    // Auto-start tutorial on first load
    window.addEventListener('load', function () {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>
