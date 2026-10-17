<?php
// network-segmentation-dmz-practical.php
// Standalone static practical. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Zone Architect</title>
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
    line-height: 1.5;
    padding-bottom: 60px;
}

code, .mono { font-family: 'JetBrains Mono', monospace; }

.wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 24px 20px 0 20px;
}

/* Header */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 10px;
}
.header-bar h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
}
.header-bar .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}
.tutorial-btn {
    flex-shrink: 0;
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
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* Description section */
.briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
    margin: 18px 0 26px 0;
}
.briefing h2 {
    font-size: 1.05rem;
    margin: 0 0 8px 0;
    color: var(--accent-primary);
}
.briefing p {
    margin: 6px 0;
    color: var(--text-secondary);
    font-size: 0.92rem;
}

/* Main environment */
.environment {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
@media (max-width: 800px) {
    .environment { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px;
}
.panel h3 {
    font-size: 0.95rem;
    margin: 0 0 12px 0;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}

.asset-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 10px;
    cursor: grab;
    font-size: 0.85rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.asset-card.selected {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.asset-card.placed { display: none; }

.zones-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}
@media (max-width: 500px) {
    .zones-grid { grid-template-columns: 1fr; }
}

.zone {
    background: var(--bg-surface);
    border: 2px dashed var(--border-default);
    border-radius: 10px;
    padding: 12px;
    min-height: 130px;
}
.zone.dragover { border-color: var(--accent-primary); }
.zone h4 {
    margin: 0 0 8px 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.zone.internet {
    opacity: 0.6;
    border-style: solid;
}
.zone-item {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 6px 8px;
    margin-bottom: 6px;
    font-size: 0.8rem;
}
.zone-item.correct { border-color: var(--success); }
.zone-item.incorrect { border-color: var(--error); }

.reason-note {
    font-size: 0.72rem;
    color: var(--error);
    margin-top: 2px;
}

/* Rule panel */
#rule-panel {
    margin-top: 20px;
}
.rule-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--border-default);
    flex-wrap: wrap;
}
.rule-row:last-child { border-bottom: none; }
.rule-label {
    font-size: 0.85rem;
    color: var(--text-secondary);
    flex: 1;
    min-width: 220px;
}
.rule-toggle {
    display: flex;
    gap: 6px;
}
.rule-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
}
.rule-btn.active-allow { background: rgba(61,255,154,0.15); border-color: var(--success); color: var(--success); }
.rule-btn.active-deny { background: rgba(255,92,92,0.15); border-color: var(--error); color: var(--error); }

/* Validate + status */
.validate-row {
    text-align: center;
    margin: 26px 0;
}
#validate-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 14px 34px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 0 18px rgba(0, 212, 255, 0.2);
}
#validate-btn:hover { box-shadow: 0 0 26px rgba(0,212,255,0.4); }

.status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 20px;
    margin: 0 0 24px 0;
    min-height: 40px;
    font-size: 0.88rem;
    color: var(--text-secondary);
}
.status-area ul { margin: 6px 0 0 18px; padding: 0; }
.status-area li { margin-bottom: 4px; }
.status-ok { color: var(--success); }
.status-bad { color: var(--error); }

/* Flag reveal */
#flag-reveal {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
}
#flag-reveal.locked .flag-value { display: none; }
#flag-reveal.locked .lock-message { display: block; }
#flag-reveal:not(.locked) .lock-message { display: none; }
.lock-message { color: var(--text-muted); font-size: 0.9rem; }
.flag-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.2rem;
    color: var(--success);
    background: rgba(61,255,154,0.08);
    border: 1px solid var(--success);
    display: inline-block;
    padding: 12px 22px;
    border-radius: 8px;
    margin-top: 6px;
}

/* Spotlight tutorial */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}
.tutorial-tooltip {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 14px 16px;
    z-index: 9999;
    font-size: 0.85rem;
    box-shadow: var(--glow-accent);
}
.tutorial-tooltip p { margin: 0 0 12px 0; color: var(--text-secondary); }
.tutorial-actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}
.tutorial-actions button {
    font-size: 0.78rem;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: var(--bg-primary);
    color: var(--text-secondary);
}
.tutorial-actions .next-btn {
    background: var(--accent-primary);
    color: #0b0f1a;
    border-color: var(--accent-primary);
    font-weight: 700;
}

.tut-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.tut-modal {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 360px;
    text-align: center;
}
.tut-modal h3 { margin-top: 0; color: var(--accent-primary); }
.tut-modal button {
    margin-top: 14px;
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>
<div class="wrap">

    <!-- 1. TOP HEADER -->
    <div class="header-bar">
        <div>
            <h1>Zone Architect</h1>
            <div class="subtitle">Redesign a flat, unsegmented network into properly isolated security zones and set the traffic policy between them.</div>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION SECTION -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This environment represents a mid-size company's network, currently flat, with every asset able to reach every other asset. Your job is to place each asset into the correct security zone, then set the traffic policy rules between zones.</p>
        <p>Drag each asset card into a zone, or tap a card to select it and then tap a zone to place it there. Once every asset is placed and every rule is set, click Validate. If your design correctly contains lateral movement, your flag will appear.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="environment">
        <div class="panel" id="asset-tray">
            <h3><i class="mono">::</i> Asset Tray</h3>
            <div class="asset-card" draggable="true" data-asset="web" data-zone="dmz">Public Web Server</div>
            <div class="asset-card" draggable="true" data-asset="dns" data-zone="dmz">Public DNS Server</div>
            <div class="asset-card" draggable="true" data-asset="mail" data-zone="dmz">Mail Relay Server</div>
            <div class="asset-card" draggable="true" data-asset="workstations" data-zone="internal">Employee Workstations</div>
            <div class="asset-card" draggable="true" data-asset="fileserver" data-zone="internal">Internal File Server</div>
            <div class="asset-card" draggable="true" data-asset="pos" data-zone="restricted">Payment Card Terminal (POS)</div>
            <div class="asset-card" draggable="true" data-asset="plc" data-zone="restricted">Industrial Control System (PLC)</div>
        </div>

        <div>
            <div class="zones-grid">
                <div class="zone internet" id="zone-internet">
                    <h4>Internet</h4>
                    <div class="zone-item">Reference only, not a drop target</div>
                </div>
                <div class="zone" id="zone-dmz" data-zone="dmz">
                    <h4>DMZ</h4>
                </div>
                <div class="zone" id="zone-internal" data-zone="internal">
                    <h4>Internal</h4>
                </div>
                <div class="zone" id="zone-restricted" data-zone="restricted">
                    <h4>Restricted</h4>
                </div>
            </div>

            <div class="panel" id="rule-panel">
                <h3><i class="mono">::</i> Traffic Policy</h3>
                <div class="rule-row" data-rule="r1">
                    <div class="rule-label">Internet &rarr; DMZ (inbound to Web Server, port 443)</div>
                    <div class="rule-toggle">
                        <button class="rule-btn" data-value="allow">Allow</button>
                        <button class="rule-btn" data-value="deny">Deny</button>
                    </div>
                </div>
                <div class="rule-row" data-rule="r2">
                    <div class="rule-label">DMZ &rarr; Internal (Web Server to File Server)</div>
                    <div class="rule-toggle">
                        <button class="rule-btn" data-value="allow">Allow</button>
                        <button class="rule-btn" data-value="deny">Deny</button>
                    </div>
                </div>
                <div class="rule-row" data-rule="r3">
                    <div class="rule-label">Internal &rarr; Restricted (Workstations to POS Terminal)</div>
                    <div class="rule-toggle">
                        <button class="rule-btn" data-value="allow">Allow</button>
                        <button class="rule-btn" data-value="deny">Deny</button>
                    </div>
                </div>
                <div class="rule-row" data-rule="r4">
                    <div class="rule-label">DMZ &rarr; Restricted (Web Server to PLC)</div>
                    <div class="rule-toggle">
                        <button class="rule-btn" data-value="allow">Allow</button>
                        <button class="rule-btn" data-value="deny">Deny</button>
                    </div>
                </div>
                <div class="rule-row" data-rule="r5">
                    <div class="rule-label">Restricted &rarr; Internet (PLC initiating outbound)</div>
                    <div class="rule-toggle">
                        <button class="rule-btn" data-value="allow">Allow</button>
                        <button class="rule-btn" data-value="deny">Deny</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="validate-row">
        <button id="validate-btn">Validate Design</button>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div class="status-area" id="status-area">Place every asset and set every rule, then click Validate.</div>

    <!-- 5. FLAG REVEAL AREA -->
    <div id="flag-reveal" class="locked">
        <div class="lock-message">The flag unlocks once every asset is correctly zoned and every traffic rule is correctly set.</div>
        <div class="flag-value mono">CBX{zones_secured}</div>
    </div>

</div>

<script>
// ---------- Data ----------
const correctZone = {
    web: 'dmz', dns: 'dmz', mail: 'dmz',
    workstations: 'internal', fileserver: 'internal',
    pos: 'restricted', plc: 'restricted'
};
const reasons = {
    web: { wrong: 'Public web servers belong in the DMZ, they must be reachable from the internet without exposing the internal network.' },
    dns: { wrong: 'Public DNS servers belong in the DMZ, keeping external name resolution separate from internal DNS records.' },
    mail: { wrong: 'Mail relays belong in the DMZ, they handle inbound and outbound mail without a direct path to internal mailboxes.' },
    workstations: { wrong: 'Employee workstations belong in the Internal zone, not exposed to the DMZ or Restricted zone.' },
    fileserver: { wrong: 'Internal file servers belong in the Internal zone, reachable only by trusted internal users.' },
    pos: { wrong: 'Payment terminals belong in the Restricted zone, they handle sensitive card data and need the strongest isolation.' },
    plc: { wrong: 'Industrial control systems belong in the Restricted zone, they should never be reachable from user workstations.' }
};
const correctRules = { r1: 'allow', r2: 'deny', r3: 'deny', r4: 'deny', r5: 'deny' };

const placements = {}; // asset -> zone chosen
const ruleChoices = {}; // rule -> allow/deny
let selectedAsset = null;

// ---------- Asset placement ----------
const assetCards = document.querySelectorAll('.asset-card');
const zoneTargets = document.querySelectorAll('.zone[data-zone]');
const statusArea = document.getElementById('status-area');

assetCards.forEach(card => {
    card.addEventListener('dragstart', e => {
        e.dataTransfer.setData('text/plain', card.dataset.asset);
    });
    card.addEventListener('click', () => {
        assetCards.forEach(c => c.classList.remove('selected'));
        if (selectedAsset === card.dataset.asset) {
            selectedAsset = null;
        } else {
            selectedAsset = card.dataset.asset;
            card.classList.add('selected');
        }
    });
});

zoneTargets.forEach(zone => {
    zone.addEventListener('dragover', e => {
        e.preventDefault();
        zone.classList.add('dragover');
    });
    zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('dragover');
        const asset = e.dataTransfer.getData('text/plain');
        placeAsset(asset, zone.dataset.zone);
    });
    zone.addEventListener('click', () => {
        if (selectedAsset) {
            placeAsset(selectedAsset, zone.dataset.zone);
            selectedAsset = null;
            assetCards.forEach(c => c.classList.remove('selected'));
        }
    });
});

function assetLabel(asset) {
    const card = document.querySelector(`.asset-card[data-asset="${asset}"]`);
    return card ? card.textContent : asset;
}

function placeAsset(asset, zoneName) {
    placements[asset] = zoneName;
    const card = document.querySelector(`.asset-card[data-asset="${asset}"]`);
    if (card) card.classList.add('placed');

    document.querySelectorAll(`.zone-item[data-asset="${asset}"]`).forEach(el => el.remove());

    const zoneEl = document.querySelector(`.zone[data-zone="${zoneName}"]`);
    const item = document.createElement('div');
    item.className = 'zone-item';
    item.dataset.asset = asset;

    const isCorrect = correctZone[asset] === zoneName;
    item.classList.add(isCorrect ? 'correct' : 'incorrect');
    item.innerHTML = assetLabel(asset);
    if (!isCorrect) {
        const note = document.createElement('div');
        note.className = 'reason-note';
        note.textContent = reasons[asset].wrong;
        item.appendChild(note);
    }
    zoneEl.appendChild(item);
}

// ---------- Rule toggles ----------
document.querySelectorAll('.rule-row').forEach(row => {
    const rule = row.dataset.rule;
    row.querySelectorAll('.rule-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            ruleChoices[rule] = btn.dataset.value;
            row.querySelectorAll('.rule-btn').forEach(b => {
                b.classList.remove('active-allow', 'active-deny');
            });
            btn.classList.add(btn.dataset.value === 'allow' ? 'active-allow' : 'active-deny');
        });
    });
});

// ---------- Validate ----------
document.getElementById('validate-btn').addEventListener('click', () => {
    const assetKeys = Object.keys(correctZone);
    const ruleKeys = Object.keys(correctRules);

    const missingAssets = assetKeys.filter(a => !placements[a]);
    const missingRules = ruleKeys.filter(r => !ruleChoices[r]);

    if (missingAssets.length || missingRules.length) {
        let msg = '<span class="status-bad">Design incomplete.</span><ul>';
        if (missingAssets.length) msg += `<li>${missingAssets.length} asset(s) still need to be placed.</li>`;
        if (missingRules.length) msg += `<li>${missingRules.length} traffic rule(s) still need to be set.</li>`;
        msg += '</ul>';
        statusArea.innerHTML = msg;
        return;
    }

    const wrongAssets = assetKeys.filter(a => placements[a] !== correctZone[a]);
    const wrongRules = ruleKeys.filter(r => ruleChoices[r] !== correctRules[r]);

    if (wrongAssets.length || wrongRules.length) {
        let msg = '<span class="status-bad">Design does not yet contain lateral movement.</span><ul>';
        if (wrongAssets.length) msg += `<li>${wrongAssets.length} asset(s) are in the wrong zone. Check the red items above.</li>`;
        if (wrongRules.length) msg += `<li>${wrongRules.length} traffic rule(s) are set incorrectly.</li>`;
        msg += '</ul>';
        statusArea.innerHTML = msg;
        return;
    }

    statusArea.innerHTML = '<span class="status-ok">Design validated. Every zone and every rule correctly limits lateral movement.</span>';
    const flagPanel = document.getElementById('flag-reveal');
    flagPanel.classList.remove('locked');
});

// ---------- Spotlight Tutorial ----------
const tutorialSteps = [
    { id: 'asset-tray', text: 'These are the assets you need to place. Think of each one as a real device sitting on your network right now, all mixed together.' },
    { id: 'zone-internet', text: "The Internet zone is untrusted by default. Nothing here is droppable, it's just your reference point for what's outside your perimeter." },
    { id: 'zone-dmz', text: 'The DMZ holds anything the public needs to reach directly, like a web server. It is exposed on purpose, but isolated from your internal network.' },
    { id: 'zone-internal', text: 'The Internal zone is where day to day business happens, workstations, internal file shares, things staff use.' },
    { id: 'zone-restricted', text: 'The Restricted zone holds your most sensitive systems, payment processing and industrial control systems. Almost nothing should be allowed to reach in here.' },
    { id: 'rule-panel', text: "Placing assets isn't enough. You also need to decide what traffic is allowed to cross between zones. Set each rule to Allow or Deny." },
    { id: 'validate-btn', text: 'Once every asset is placed and every rule is set, click Validate to check your design.' },
    { id: 'flag-reveal', text: 'If your design correctly contains lateral movement, your flag appears here.' }
];

let currentStep = 0;
let tutorialActive = false;
let spotlightEl = null;
let tooltipEl = null;

function createSpotlightElements() {
    spotlightEl = document.createElement('div');
    spotlightEl.className = 'spotlight-box';
    document.body.appendChild(spotlightEl);

    tooltipEl = document.createElement('div');
    tooltipEl.className = 'tutorial-tooltip';
    document.body.appendChild(tooltipEl);
}

function removeSpotlightElements() {
    if (spotlightEl) spotlightEl.remove();
    if (tooltipEl) tooltipEl.remove();
    spotlightEl = null;
    tooltipEl = null;
}

function positionSpotlight(targetId) {
    const target = document.getElementById(targetId);
    if (!target) return;

    const rect = target.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    const doPosition = () => {
        const r = target.getBoundingClientRect();
        const pad = 8;
        spotlightEl.style.top = (r.top - pad) + 'px';
        spotlightEl.style.left = (r.left - pad) + 'px';
        spotlightEl.style.width = (r.width + pad * 2) + 'px';
        spotlightEl.style.height = (r.height + pad * 2) + 'px';

        tooltipEl.innerHTML = `
            <p>${tutorialSteps[currentStep].text}</p>
            <div class="tutorial-actions">
                <button class="skip-btn">Skip Tutorial</button>
                <button class="next-btn">${currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next'}</button>
            </div>
        `;

        const tw = 280;
        let top = r.bottom + 14;
        let left = r.left;

        if (top + 140 > window.innerHeight) {
            top = r.top - 150;
        }
        if (left + tw > window.innerWidth) {
            left = window.innerWidth - tw - 20;
        }
        if (left < 10) left = 10;
        if (top < 10) top = 10;

        tooltipEl.style.top = top + 'px';
        tooltipEl.style.left = left + 'px';

        tooltipEl.querySelector('.next-btn').addEventListener('click', nextStep);
        tooltipEl.querySelector('.skip-btn').addEventListener('click', endTutorial);
    };

    if (!isVisible) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(doPosition, 300);
    } else {
        doPosition();
    }
}

function showStep() {
    positionSpotlight(tutorialSteps[currentStep].id);
}

function nextStep() {
    currentStep++;
    if (currentStep >= tutorialSteps.length) {
        endTutorial(true);
        return;
    }
    showStep();
}

function endTutorial(completed) {
    removeSpotlightElements();
    tutorialActive = false;
    if (completed) showCompletionModal();
}

function showCompletionModal() {
    const overlay = document.createElement('div');
    overlay.className = 'tut-modal-overlay';
    overlay.innerHTML = `
        <div class="tut-modal">
            <h3>Tutorial Complete</h3>
            <p>You're ready to start the challenge.</p>
            <button id="start-challenge-btn">Start Challenge</button>
        </div>
    `;
    document.body.appendChild(overlay);
    overlay.querySelector('#start-challenge-btn').addEventListener('click', () => overlay.remove());
}

function startTutorial() {
    tutorialActive = true;
    currentStep = 0;
    createSpotlightElements();
    showStep();
}

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (tutorialActive) showStep();
});

window.addEventListener('load', () => {
    startTutorial();
});
</script>
</body>
</html>
