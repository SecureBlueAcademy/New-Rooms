<?php
// ============================================================
// applied-cryptography-for-engineers-practical.php
// Standalone practical: Crypto Mode Inspector
// Static PHP/HTML/CSS/JS only. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crypto Mode Inspector</title>
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
    padding-bottom: 60px;
}

.mono { font-family: "JetBrains Mono", monospace; }

/* ===== Top header ===== */
.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 28px 32px 20px 32px;
    border-bottom: 1px solid var(--border-default);
    background: var(--bg-secondary);
}
.top-header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
    font-weight: 700;
}
.top-header .subtitle {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

.container {
    max-width: 980px;
    margin: 0 auto;
    padding: 0 32px;
}

/* ===== Description section ===== */
.description-section {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 26px;
    margin-top: 26px;
}
.description-section h2 {
    margin-top: 0;
    font-size: 1.15rem;
}
.description-section p {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 8px 0;
}
.description-section ol {
    color: var(--text-secondary);
    font-size: 0.95rem;
    padding-left: 20px;
}

/* ===== Main environment ===== */
.environment {
    margin-top: 26px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 760px) {
    .environment { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 20px;
}
.panel h3 {
    margin: 0 0 12px 0;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tile-grid {
    display: grid;
    grid-template-columns: repeat(16, 1fr);
    gap: 1px;
    background: var(--border-default);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    overflow: hidden;
    aspect-ratio: 1 / 1;
}
.tile {
    aspect-ratio: 1 / 1;
    background: var(--bg-primary);
}

/* ===== Controls ===== */
.controls-panel {
    grid-column: 1 / -1;
}
.controls-row {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    align-items: flex-end;
}
.control-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.control-group label {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
select {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 10px 14px;
    font-family: inherit;
    font-size: 0.9rem;
    min-width: 160px;
}
select:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
.encrypt-btn {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 11px 26px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.encrypt-btn:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

/* ===== Feedback / status area ===== */
.status-row {
    margin-top: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 760px) {
    .status-row { grid-template-columns: 1fr; }
}
.reuse-check {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
    min-height: 40px;
}
.log-entries {
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 180px;
    overflow-y: auto;
}
.log-entry {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    padding: 8px 12px;
    border-radius: 6px;
    border-left: 3px solid var(--text-muted);
    background: rgba(255,255,255,0.03);
}
.log-entry.warning { border-left-color: var(--warning); color: var(--warning); }
.log-entry.success { border-left-color: var(--success); color: var(--success); }
.log-entry.info { border-left-color: var(--accent-primary); color: var(--text-secondary); }

/* ===== Flag reveal ===== */
.flag-panel {
    margin-top: 20px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 26px;
    text-align: center;
}
.flag-panel.locked .flag-value { display: none; }
.flag-panel.locked .lock-message { display: block; }
.flag-panel.unlocked .lock-message { display: none; }
.flag-panel.unlocked {
    border-color: var(--success);
    box-shadow: 0 0 24px rgba(61,255,154,0.15);
}
.lock-message {
    color: var(--text-muted);
    font-size: 0.9rem;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    color: var(--success);
    font-weight: 600;
    letter-spacing: 0.02em;
}
.progress-checklist {
    display: flex;
    justify-content: center;
    gap: 18px;
    margin-top: 10px;
    flex-wrap: wrap;
}
.checklist-item {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}
.checklist-item.done { color: var(--success); }
.checklist-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--text-muted);
}
.checklist-item.done .checklist-dot { background: var(--success); }

/* ===== Tutorial spotlight ===== */
#tutorialSpotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
    display: none;
}
#tutorialTooltip {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: 0 8px 30px rgba(0,0,0,0.5);
    display: none;
}
#tutorialTooltip p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-step-count {
    font-size: 0.75rem;
    color: var(--text-muted);
}
.tooltip-buttons {
    display: flex;
    gap: 8px;
}
.tooltip-buttons button {
    font-family: inherit;
    font-size: 0.8rem;
    padding: 6px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tooltip-buttons button.primary {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border-color: var(--accent-primary);
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
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 32px;
    max-width: 380px;
    text-align: center;
    box-shadow: 0 0 40px rgba(106,227,255,0.2);
}
.modal-box h3 {
    margin-top: 0;
    font-size: 1.15rem;
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.modal-box button {
    margin-top: 10px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 11px 28px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="top-header">
    <div>
        <h1>Crypto Mode Inspector</h1>
        <p class="subtitle">A simulated encryption tool with a dangerous default configuration. Find the settings that actually protect the data.</p>
    </div>
    <button class="tutorial-btn" id="viewTutorialBtn">View Tutorial</button>
</div>

<div class="container">

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>This environment represents a file encryption tool used inside a fictional company. It encrypts a block of image-like data using a configurable cipher mode and IV setting. Your job is to find out why the current default configuration is dangerous and identify the configuration that is actually secure.</p>
        <ol>
            <li>Run the tool in ECB mode and observe the ciphertext output.</li>
            <li>Switch to GCM mode with a static IV and encrypt the same data twice.</li>
            <li>Switch to GCM mode with a random IV and encrypt twice more.</li>
            <li>Once all three tests are complete, the secure output panel will unlock.</li>
        </ol>
    </div>

    <div class="environment">
        <div class="panel" id="plaintextPanel">
            <h3>Plaintext</h3>
            <div class="tile-grid" id="plaintextGrid"></div>
        </div>

        <div class="panel" id="ciphertextPanelWrap">
            <h3>Ciphertext Output</h3>
            <div class="tile-grid" id="ciphertextGrid"></div>
        </div>

        <div class="panel controls-panel">
            <h3>Configuration</h3>
            <div class="controls-row">
                <div class="control-group">
                    <label for="cipherModeSelect">Cipher Mode</label>
                    <select id="cipherModeSelect">
                        <option value="ecb">ECB</option>
                        <option value="gcm" selected>GCM</option>
                    </select>
                </div>
                <div class="control-group">
                    <label for="ivTypeSelect">IV Type</label>
                    <select id="ivTypeSelect">
                        <option value="static" selected>Static</option>
                        <option value="random">Random</option>
                    </select>
                </div>
                <button class="encrypt-btn" id="encryptBtn">Encrypt</button>
            </div>
        </div>
    </div>

    <div class="status-row">
        <div class="panel" id="reuseCheckPanel">
            <h3>Reuse Check</h3>
            <div class="reuse-check" id="reuseCheckText">Run an encryption to begin checking for output reuse.</div>
        </div>
        <div class="panel" id="configLogPanel">
            <h3>Configuration Log</h3>
            <div class="log-entries" id="logEntries"></div>
        </div>
    </div>

    <div class="flag-panel locked" id="secureOutputPanel">
        <div class="lock-message">
            <strong>Secure Output</strong><br>
            Complete all three tests below to unlock the flag.
            <div class="progress-checklist">
                <div class="checklist-item" id="checkEcb"><span class="checklist-dot"></span> ECB pattern leakage observed</div>
                <div class="checklist-item" id="checkStatic"><span class="checklist-dot"></span> Static IV reuse detected</div>
                <div class="checklist-item" id="checkRandom"><span class="checklist-dot"></span> Random IV verified secure</div>
            </div>
        </div>
        <div class="flag-value" id="flagValue"></div>
    </div>

</div>

<div id="tutorialSpotlight"></div>
<div id="tutorialTooltip">
    <p id="tooltipText"></p>
    <div class="tooltip-actions">
        <span class="tooltip-step-count" id="tooltipStepCount"></span>
        <div class="tooltip-buttons">
            <button id="tooltipSkipBtn">Skip Tutorial</button>
            <button class="primary" id="tooltipNextBtn">Next</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="completionModal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're Ready to Start the Challenge</p>
        <button id="startChallengeBtn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    const PALETTE = ['#6ae3ff', '#8b7bff', '#3dff9a', '#ffd36a', '#ff5c5c', '#e6e9f2'];
    const GRID_SIZE = 16;
    const TOTAL_TILES = GRID_SIZE * GRID_SIZE;
    const FLAG = 'CBX{semantic_security_achieved}';

    // ---- Build deterministic plaintext pattern (concentric diamond bands) ----
    const plaintextIndices = [];
    for (let r = 0; r < GRID_SIZE; r++) {
        for (let c = 0; c < GRID_SIZE; c++) {
            const dist = Math.abs(r - 7.5) + Math.abs(c - 7.5);
            let idx;
            if (dist < 3) idx = 2;
            else if (dist < 6) idx = 1;
            else if (dist < 9) idx = 3;
            else idx = 0;
            plaintextIndices.push(idx);
        }
    }

    function hashIndex(n, len) {
        let h = Math.sin(n * 12.9898) * 43758.5453;
        h = h - Math.floor(h);
        return Math.floor(h * len);
    }

    function encryptECB(plain) {
        return plain.map(p => hashIndex(p * 97 + 13, PALETTE.length));
    }

    function encryptGCM(plain, iv) {
        return plain.map((p, i) => hashIndex(p * 53 + i * 17 + iv * 31, PALETTE.length));
    }

    function arraysEqual(a, b) {
        if (!a || !b || a.length !== b.length) return false;
        for (let i = 0; i < a.length; i++) if (a[i] !== b[i]) return false;
        return true;
    }

    // ---- Render grids ----
    function renderGrid(container, indices) {
        container.innerHTML = '';
        const frag = document.createDocumentFragment();
        indices.forEach(idx => {
            const tile = document.createElement('div');
            tile.className = 'tile';
            tile.style.background = PALETTE[idx % PALETTE.length];
            frag.appendChild(tile);
        });
        container.appendChild(frag);
    }

    const plaintextGrid = document.getElementById('plaintextGrid');
    const ciphertextGrid = document.getElementById('ciphertextGrid');
    renderGrid(plaintextGrid, plaintextIndices);

    // ---- State ----
    let ecbRun = false;
    let lastStaticCipher = null;
    let staticReuseDetected = false;
    let lastRandomCipher = null;
    let randomRunCount = 0;
    let randomNoRepeatDetected = false;

    const STATIC_IV = 424242;

    const cipherModeSelect = document.getElementById('cipherModeSelect');
    const ivTypeSelect = document.getElementById('ivTypeSelect');
    const encryptBtn = document.getElementById('encryptBtn');
    const reuseCheckText = document.getElementById('reuseCheckText');
    const logEntries = document.getElementById('logEntries');
    const secureOutputPanel = document.getElementById('secureOutputPanel');
    const flagValue = document.getElementById('flagValue');
    const checkEcb = document.getElementById('checkEcb');
    const checkStatic = document.getElementById('checkStatic');
    const checkRandom = document.getElementById('checkRandom');

    function updateIvDisabled() {
        ivTypeSelect.disabled = cipherModeSelect.value === 'ecb';
    }
    cipherModeSelect.addEventListener('change', updateIvDisabled);
    updateIvDisabled();

    function addLog(message, type) {
        const entry = document.createElement('div');
        entry.className = 'log-entry ' + type;
        entry.textContent = message;
        logEntries.insertBefore(entry, logEntries.firstChild);
    }

    function checkUnlock() {
        checkEcb.classList.toggle('done', ecbRun);
        checkStatic.classList.toggle('done', staticReuseDetected);
        checkRandom.classList.toggle('done', randomNoRepeatDetected);

        if (ecbRun && staticReuseDetected && randomNoRepeatDetected) {
            secureOutputPanel.classList.remove('locked');
            secureOutputPanel.classList.add('unlocked');
            flagValue.textContent = FLAG;
        }
    }

    encryptBtn.addEventListener('click', function() {
        const mode = cipherModeSelect.value;
        let cipher;

        if (mode === 'ecb') {
            cipher = encryptECB(plaintextIndices);
            ecbRun = true;
            addLog('ECB Mode: Pattern leakage detected. Identical input blocks produce identical output blocks.', 'warning');
            reuseCheckText.textContent = 'ECB mode does not use an IV. The plaintext structure is visible directly in the ciphertext.';
        } else {
            const ivType = ivTypeSelect.value;
            if (ivType === 'static') {
                cipher = encryptGCM(plaintextIndices, STATIC_IV);
                if (lastStaticCipher && arraysEqual(cipher, lastStaticCipher)) {
                    staticReuseDetected = true;
                    addLog('IV reuse detected: confidentiality at risk. The same IV produced identical ciphertext twice.', 'warning');
                    reuseCheckText.textContent = 'Static IV: two runs produced identical ciphertext. This is a serious flaw for AEAD ciphers.';
                } else {
                    addLog('GCM + Static IV: Run again with the same settings to test for IV reuse.', 'info');
                    reuseCheckText.textContent = 'Static IV: awaiting a second run to compare outputs.';
                }
                lastStaticCipher = cipher;
            } else {
                cipher = encryptGCM(plaintextIndices, Math.floor(Math.random() * 1000000));
                randomRunCount++;
                if (lastRandomCipher && !arraysEqual(cipher, lastRandomCipher)) {
                    randomNoRepeatDetected = true;
                    addLog('GCM + Random IV: No repeats detected. Semantic security achieved.', 'success');
                    reuseCheckText.textContent = 'Random IV: consecutive runs produced different ciphertext, as expected.';
                } else if (lastRandomCipher) {
                    addLog('GCM + Random IV: Outputs matched unexpectedly, run again.', 'info');
                } else {
                    addLog('GCM + Random IV: Run again with the same settings to compare outputs.', 'info');
                    reuseCheckText.textContent = 'Random IV: awaiting a second run to compare outputs.';
                }
                lastRandomCipher = cipher;
            }
        }

        renderGrid(ciphertextGrid, cipher);
        checkUnlock();
    });

    // ============================================================
    // Tutorial spotlight system
    // ============================================================
    const steps = [
        { id: 'plaintextGrid', text: 'This is your plaintext, represented as tiles. Notice the repeating diamond pattern, similar to a simple image.' },
        { id: 'cipherModeSelect', text: 'Switch between ECB and GCM, two block cipher modes of operation. The mode determines how blocks of data are processed.' },
        { id: 'ivTypeSelect', text: 'GCM requires an Initialization Vector, or IV. Random IVs are required for security. Static IVs are a common and dangerous mistake.' },
        { id: 'encryptBtn', text: 'Click Encrypt to run the current configuration against the plaintext.' },
        { id: 'ciphertextGrid', text: 'This is your ciphertext. Watch closely: does the original pattern leak through?' },
        { id: 'reuseCheckPanel', text: 'This panel detects if encrypting the same data twice produces the same output, a sign of a serious flaw.' },
        { id: 'configLogPanel', text: 'Read the feedback here after each encryption attempt.' },
        { id: 'secureOutputPanel', text: 'Once you have tested all three configurations and reached a secure result, your flag will appear here.' }
    ];

    let currentStep = -1;
    let tutorialActive = false;

    const spotlight = document.getElementById('tutorialSpotlight');
    const tooltip = document.getElementById('tutorialTooltip');
    const tooltipText = document.getElementById('tooltipText');
    const tooltipStepCount = document.getElementById('tooltipStepCount');
    const tooltipNextBtn = document.getElementById('tooltipNextBtn');
    const tooltipSkipBtn = document.getElementById('tooltipSkipBtn');
    const completionModal = document.getElementById('completionModal');
    const startChallengeBtn = document.getElementById('startChallengeBtn');
    const viewTutorialBtn = document.getElementById('viewTutorialBtn');

    function positionSpotlightAndTooltip() {
        if (!tutorialActive || currentStep < 0 || currentStep >= steps.length) return;
        const target = document.getElementById(steps[currentStep].id);
        if (!target) return;

        const rect = target.getBoundingClientRect();
        const padding = 8;

        spotlight.style.display = 'block';
        spotlight.style.top = (rect.top - padding) + 'px';
        spotlight.style.left = (rect.left - padding) + 'px';
        spotlight.style.width = (rect.width + padding * 2) + 'px';
        spotlight.style.height = (rect.height + padding * 2) + 'px';

        tooltip.style.display = 'block';
        const tooltipWidth = 280;
        const spaceBelow = window.innerHeight - rect.bottom;
        const spaceAbove = rect.top;
        const spaceRight = window.innerWidth - rect.right;

        let top, left, placement;
        if (spaceBelow > 160) {
            placement = 'bottom';
            top = rect.bottom + 16;
            left = rect.left;
        } else if (spaceAbove > 160) {
            placement = 'top';
            top = rect.top - 16;
            left = rect.left;
        } else if (spaceRight > tooltipWidth + 20) {
            placement = 'right';
            top = rect.top;
            left = rect.right + 16;
        } else {
            placement = 'left';
            top = rect.top;
            left = rect.left - tooltipWidth - 16;
        }

        left = Math.max(12, Math.min(left, window.innerWidth - tooltipWidth - 12));
        if (placement === 'top') {
            tooltip.style.top = (top - tooltip.offsetHeight) + 'px';
        } else {
            tooltip.style.top = top + 'px';
        }
        tooltip.style.left = left + 'px';
    }

    function showStep(index) {
        currentStep = index;
        const step = steps[index];
        const target = document.getElementById(step.id);

        if (target) {
            const rect = target.getBoundingClientRect();
            const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
            if (!isVisible) {
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    tooltipText.textContent = step.text;
                    tooltipStepCount.textContent = 'Step ' + (index + 1) + ' of ' + steps.length;
                    positionSpotlightAndTooltip();
                }, 300);
                return;
            }
        }

        tooltipText.textContent = step.text;
        tooltipStepCount.textContent = 'Step ' + (index + 1) + ' of ' + steps.length;
        positionSpotlightAndTooltip();
    }

    function startTutorial() {
        tutorialActive = true;
        completionModal.style.display = 'none';
        showStep(0);
    }

    function endTutorial(showCompletion) {
        tutorialActive = false;
        spotlight.style.display = 'none';
        tooltip.style.display = 'none';
        if (showCompletion) {
            completionModal.style.display = 'flex';
        }
    }

    tooltipNextBtn.addEventListener('click', function() {
        if (currentStep >= steps.length - 1) {
            endTutorial(true);
        } else {
            showStep(currentStep + 1);
        }
    });

    tooltipSkipBtn.addEventListener('click', function() {
        endTutorial(false);
    });

    startChallengeBtn.addEventListener('click', function() {
        completionModal.style.display = 'none';
    });

    viewTutorialBtn.addEventListener('click', function() {
        startTutorial();
    });

    window.addEventListener('resize', function() {
        if (tutorialActive) positionSpotlightAndTooltip();
    });

    // Script runs at end of body, so the DOM is already parsed. Start immediately.
    startTutorial();
})();
</script>

</body>
</html>
