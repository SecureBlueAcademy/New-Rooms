<?php
// ============================================================
// key-management-systems-practical.php — CYBRIXEN PRACTICAL FILE
// Envelope Encryption Workbench
// Static HTML/CSS/JS application. No backend logic.
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Envelope Encryption Workbench</title>
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

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.6;
    padding-bottom: 60px;
}

code, .mono { font-family: "JetBrains Mono", monospace; }

/* ===== HEADER ===== */
.header {
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    padding: 24px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-primary);
}
.header p {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-top: 4px;
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
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    background: rgba(106,227,255,0.1);
    box-shadow: var(--glow-accent);
}

/* ===== DESCRIPTION ===== */
.description {
    max-width: 900px;
    margin: 28px auto 0 auto;
    padding: 0 24px;
}
.description h2 {
    font-size: 1.15rem;
    margin-bottom: 8px;
    color: var(--accent-primary);
}
.description p {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-bottom: 8px;
}

/* ===== WORKBENCH ===== */
.workbench {
    max-width: 1100px;
    margin: 30px auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}
.stage-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: relative;
    transition: border-color 0.2s ease;
}
.stage-card.locked { opacity: 0.45; }
.stage-card.complete { border-color: var(--success); }
.stage-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
}
.stage-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--text-primary);
}
.stage-desc {
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.stage-output {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.78rem;
    color: var(--accent-primary);
    word-break: break-all;
    min-height: 20px;
}
.stage-btn {
    margin-top: auto;
    background: linear-gradient(135deg, #12182b, #1f2a4a);
    border: 1px solid var(--accent-secondary);
    color: var(--accent-secondary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.stage-btn:hover:not(:disabled) {
    background: rgba(139,123,255,0.12);
    box-shadow: 0 0 14px rgba(139,123,255,0.3);
}
.stage-btn:disabled { cursor: not-allowed; opacity: 0.5; }
.stage-icon {
    font-size: 1.4rem;
}

/* ===== STATUS / FEEDBACK ===== */
.status-area {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
}
.status-message {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-left: 3px solid var(--accent-primary);
    border-radius: 8px;
    padding: 14px 18px;
    font-size: 0.88rem;
    color: var(--text-secondary);
    margin-bottom: 16px;
}
.status-message.error {
    border-left-color: var(--error);
    color: var(--error);
}
.status-message.success {
    border-left-color: var(--success);
    color: var(--success);
}

/* ===== FLAG REVEAL ===== */
.flag-area {
    max-width: 1100px;
    margin: 30px auto;
    padding: 0 24px;
}
.flag-panel {
    background: linear-gradient(135deg, #0f2027, #12321f, #0f2027);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    display: none;
}
.flag-panel.visible {
    display: block;
    animation: fadeInFlag 0.6s ease forwards;
}
@keyframes fadeInFlag {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.flag-panel h3 {
    color: var(--success);
    margin-bottom: 12px;
    font-size: 1.1rem;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.3rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    border: 1px solid var(--success);
    letter-spacing: 0.03em;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9000;
}
.tooltip-card {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: var(--glow-accent);
    z-index: 9001;
    font-size: 0.85rem;
    color: var(--text-secondary);
}
.tooltip-card h4 {
    color: var(--accent-primary);
    font-size: 0.95rem;
    margin-bottom: 8px;
}
.tooltip-actions {
    margin-top: 14px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border-default) !important;
}
.tt-next {
    background: var(--accent-primary);
    color: #06121a;
}

/* ===== COMPLETION MODAL ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9500;
}
.modal-overlay.visible { display: flex; }
.modal-card {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 32px;
    max-width: 420px;
    text-align: center;
}
.modal-card h3 {
    color: var(--accent-primary);
    margin-bottom: 10px;
}
.modal-card p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 20px;
}
.modal-card button {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 640px) {
    .header { padding: 18px 20px; }
    .workbench { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<div class="header">
    <div>
        <h1>Envelope Encryption Workbench</h1>
        <p>Application server view: encrypt customer_records.csv without ever exposing the master key</p>
    </div>
    <button class="tutorial-btn" id="tutorial-btn">View Tutorial</button>
</div>

<div class="description">
    <h2>Mission Briefing</h2>
    <p>This environment simulates an application server that must encrypt a sensitive file. Your master key encryption key, the KEK, lives inside a KMS and must never leave it in plaintext.</p>
    <p>Work through all four stages in order: generate a data encryption key, encrypt the data, wrap the data key with the KEK, and store the final bundle. Completing all four stages correctly reveals your flag.</p>
</div>

<div class="status-area">
    <div class="status-message" id="status-message">Ready. Start with Stage 1: generate your data encryption key.</div>
</div>

<div class="workbench">
    <div class="stage-card" id="stage1-card">
        <span class="stage-icon">🖥️</span>
        <span class="stage-label">Stage 1 · Application Server</span>
        <span class="stage-title">Generate DEK</span>
        <p class="stage-desc">Create a fresh data encryption key that exists only in memory.</p>
        <div class="stage-output" id="dek-output">Not generated yet</div>
        <button class="stage-btn" id="generate-dek-btn">Generate Data Encryption Key</button>
    </div>

    <div class="stage-card locked" id="stage2-card">
        <span class="stage-icon">📄</span>
        <span class="stage-label">Stage 2 · customer_records.csv</span>
        <span class="stage-title">Encrypt Data with DEK</span>
        <p class="stage-desc">Use the DEK to encrypt the sensitive file so it is safe to store.</p>
        <div class="stage-output" id="data-output">customer_records.csv (plaintext)</div>
        <button class="stage-btn" id="encrypt-data-btn" disabled>Encrypt with DEK</button>
    </div>

    <div class="stage-card locked" id="stage3-card">
        <span class="stage-icon">🔒</span>
        <span class="stage-label">Stage 3 · KMS</span>
        <span class="stage-title">Wrap DEK with KEK</span>
        <p class="stage-desc">Send the DEK to the KMS. The KEK never leaves the vault.</p>
        <div class="stage-output" id="wrap-output">DEK not wrapped yet</div>
        <button class="stage-btn" id="wrap-dek-btn" disabled>Wrap DEK with KEK</button>
    </div>

    <div class="stage-card locked" id="stage4-card">
        <span class="stage-icon">🗄️</span>
        <span class="stage-label">Stage 4 · Storage Bucket</span>
        <span class="stage-title">Store Encrypted Bundle</span>
        <p class="stage-desc">Store the encrypted data alongside the wrapped DEK.</p>
        <div class="stage-output" id="bundle-output">No bundle stored yet</div>
        <button class="stage-btn" id="store-bundle-btn" disabled>Store Bundle</button>
    </div>
</div>

<div class="flag-area">
    <div class="flag-panel" id="flag-panel">
        <h3>Bundle Verified</h3>
        <p style="color: var(--text-secondary); margin-bottom: 16px;">Envelope encryption complete. The KEK never left the KMS boundary.</p>
        <div class="flag-value" id="flag-value">CBX{envelope_sealed}</div>
    </div>
</div>

<div class="modal-overlay" id="completion-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Work through all four stages in order.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    'use strict';

    // ============================
    // STATE
    // ============================
    var state = {
        dekGenerated: false,
        dataEncrypted: false,
        dekWrapped: false,
        bundleStored: false
    };

    var dekValue = null;
    var wrappedDekValue = null;

    function randomHex(bytes) {
        var chars = '0123456789abcdef';
        var out = '';
        for (var i = 0; i < bytes * 2; i++) {
            out += chars[Math.floor(Math.random() * chars.length)];
        }
        return out;
    }

    function setStatus(msg, type) {
        var el = document.getElementById('status-message');
        el.textContent = msg;
        el.className = 'status-message' + (type ? ' ' + type : '');
    }

    // ============================
    // STAGE 1: Generate DEK
    // ============================
    document.getElementById('generate-dek-btn').addEventListener('click', function() {
        dekValue = randomHex(16);
        document.getElementById('dek-output').textContent = 'DEK (plaintext, in memory only): ' + dekValue;
        state.dekGenerated = true;
        setStatus('Data encryption key generated. It exists only in memory right now.', 'success');

        document.getElementById('stage2-card').classList.remove('locked');
        document.getElementById('encrypt-data-btn').disabled = false;
    });

    // ============================
    // STAGE 2: Encrypt Data with DEK
    // ============================
    document.getElementById('encrypt-data-btn').addEventListener('click', function() {
        if (!state.dekGenerated) {
            setStatus('You need a DEK before you can encrypt any data.', 'error');
            return;
        }
        var fakeCiphertext = randomHex(24);
        document.getElementById('data-output').textContent = 'Encrypted Data (safe to store): ' + fakeCiphertext;
        state.dataEncrypted = true;
        setStatus('Data encrypted with the DEK. It is now unreadable without that key.', 'success');
        document.getElementById('stage2-card').classList.add('complete');

        document.getElementById('stage3-card').classList.remove('locked');
        document.getElementById('wrap-dek-btn').disabled = false;
    });

    // ============================
    // STAGE 3: Wrap DEK with KEK
    // ============================
    document.getElementById('wrap-dek-btn').addEventListener('click', function() {
        if (!state.dataEncrypted) {
            setStatus('Encrypt the data before wrapping the DEK.', 'error');
            return;
        }
        wrappedDekValue = randomHex(20);
        document.getElementById('wrap-output').textContent = 'Wrapped DEK: ' + wrappedDekValue;
        state.dekWrapped = true;
        setStatus('DEK wrapped by the KMS. The KEK itself never left the vault boundary.', 'success');
        document.getElementById('stage3-card').classList.add('complete');

        document.getElementById('stage4-card').classList.remove('locked');
        document.getElementById('store-bundle-btn').disabled = false;
    });

    // ============================
    // STAGE 4: Store Bundle
    // ============================
    document.getElementById('store-bundle-btn').addEventListener('click', function() {
        if (!state.dekWrapped) {
            setStatus('You cannot store the DEK in plaintext next to the data it encrypts.', 'error');
            return;
        }
        document.getElementById('bundle-output').textContent = 'Bundle stored: encrypted data + wrapped DEK';
        state.bundleStored = true;
        setStatus('Envelope encryption bundle stored successfully.', 'success');
        document.getElementById('stage4-card').classList.add('complete');
        document.getElementById('stage1-card').classList.add('complete');

        revealFlag();
    });

    function revealFlag() {
        var panel = document.getElementById('flag-panel');
        panel.classList.add('visible');
        panel.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // ============================
    // SPOTLIGHT TUTORIAL SYSTEM
    // ============================
    var tutorialSteps = [
        { id: 'stage1-card', text: 'This is your application server. It needs to encrypt sensitive data, but it should never handle your master key directly. First, it generates a Data Encryption Key (DEK), like a one time lockbox key made just for this file.' },
        { id: 'generate-dek-btn', text: 'Click here to generate the DEK. Think of this as minting a fresh key that exists only in memory, never written to disk yet.' },
        { id: 'stage2-card', text: 'Now the DEK encrypts your actual data. Once encrypted, this file is safe to store anywhere. Without the DEK, it is unreadable.' },
        { id: 'encrypt-data-btn', text: 'Encrypt the file with the DEK you just generated.' },
        { id: 'stage3-card', text: 'Here is the key insight of envelope encryption: the DEK itself needs protecting too. This is where the Key Encryption Key inside your KMS comes in.' },
        { id: 'wrap-dek-btn', text: 'Send the DEK to the KMS to be wrapped. Notice the KEK never leaves the KMS. Only a wrapped, encrypted version of the DEK comes back to you.' },
        { id: 'stage4-card', text: 'Finally, store the encrypted data alongside the wrapped DEK. Both are ciphertext now, so this bundle is safe even in public storage.' },
        { id: 'store-bundle-btn', text: 'Store the bundle to complete the envelope encryption pattern and reveal your flag.' }
    ];

    var currentStep = -1;
    var spotlightEl = null;
    var tooltipEl = null;

    function createOverlayElements() {
        if (!spotlightEl) {
            spotlightEl = document.createElement('div');
            spotlightEl.className = 'spotlight';
            document.body.appendChild(spotlightEl);
        }
        if (!tooltipEl) {
            tooltipEl = document.createElement('div');
            tooltipEl.className = 'tooltip-card';
            document.body.appendChild(tooltipEl);
        }
    }

    function removeOverlayElements() {
        if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
        if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
    }

    function positionSpotlight(target) {
        var rect = target.getBoundingClientRect();
        var pad = 8;
        spotlightEl.style.top = (rect.top - pad) + 'px';
        spotlightEl.style.left = (rect.left - pad) + 'px';
        spotlightEl.style.width = (rect.width + pad * 2) + 'px';
        spotlightEl.style.height = (rect.height + pad * 2) + 'px';

        var tooltipWidth = 300;
        var top, left;
        var spaceBelow = window.innerHeight - rect.bottom;

        if (spaceBelow > 160) {
            top = rect.bottom + 16;
            left = Math.min(Math.max(rect.left, 16), window.innerWidth - tooltipWidth - 16);
        } else if (rect.top > 200) {
            top = rect.top - 16;
            left = Math.min(Math.max(rect.left, 16), window.innerWidth - tooltipWidth - 16);
            tooltipEl.style.transform = 'translateY(-100%)';
        } else {
            top = Math.max(rect.top, 16);
            left = rect.right + 16 < window.innerWidth - tooltipWidth ? rect.right + 16 : Math.max(rect.left - tooltipWidth - 16, 16);
            tooltipEl.style.transform = 'none';
        }

        if (spaceBelow > 160 || rect.top <= 200) {
            tooltipEl.style.transform = 'none';
        }

        tooltipEl.style.top = top + 'px';
        tooltipEl.style.left = left + 'px';
    }

    function renderStep(index) {
        var step = tutorialSteps[index];
        var target = document.getElementById(step.id);
        if (!target) return;

        var rect = target.getBoundingClientRect();
        var isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function place() {
            positionSpotlight(target);
            tooltipEl.innerHTML =
                '<h4>Step ' + (index + 1) + ' of ' + tutorialSteps.length + '</h4>' +
                '<p>' + step.text + '</p>' +
                '<div class="tooltip-actions">' +
                    '<button class="tt-skip" id="tt-skip">Skip Tutorial</button>' +
                    '<button class="tt-next" id="tt-next">' + (index === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
                '</div>';

            document.getElementById('tt-skip').addEventListener('click', endTutorial);
            document.getElementById('tt-next').addEventListener('click', function() {
                if (index === tutorialSteps.length - 1) {
                    endTutorial(true);
                } else {
                    currentStep++;
                    renderStep(currentStep);
                }
            });
        }

        if (!isVisible) {
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(place, 300);
        } else {
            place();
        }
    }

    function startTutorial() {
        currentStep = 0;
        createOverlayElements();
        renderStep(currentStep);
    }

    function endTutorial(completed) {
        removeOverlayElements();
        if (completed) {
            document.getElementById('completion-modal').classList.add('visible');
        }
    }

    document.getElementById('tutorial-btn').addEventListener('click', startTutorial);
    document.getElementById('start-challenge-btn').addEventListener('click', function() {
        document.getElementById('completion-modal').classList.remove('visible');
    });

    window.addEventListener('resize', function() {
        if (spotlightEl && currentStep >= 0 && currentStep < tutorialSteps.length) {
            var step = tutorialSteps[currentStep];
            var target = document.getElementById(step.id);
            if (target) positionSpotlight(target);
        }
    });

    // Auto-start tutorial on first load
    window.addEventListener('load', function() {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>
