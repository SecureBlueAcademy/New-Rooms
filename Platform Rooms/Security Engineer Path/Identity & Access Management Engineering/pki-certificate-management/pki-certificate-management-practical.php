<?php
// pki-certificate-management-practical.php
// Standalone static practical: Certificate Chain Inspector
// No backend logic, no database, no sessions, no external APIs.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate Chain Inspector</title>
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
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 20px 80px 20px;
    position: relative;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 25px;
}
.header h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
}
.header p.subtitle {
    color: var(--text-secondary);
    margin: 0;
    font-size: 0.95rem;
}
#tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-family: "Inter", sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* DESCRIPTION */
.description-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 25px;
}
.description-box h3 {
    margin: 0 0 8px 0;
    font-size: 1rem;
    color: var(--accent-primary);
}
.description-box p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.description-box p:last-child { margin-bottom: 0; }

/* MAIN GRID */
.main-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}
@media (max-width: 800px) {
    .main-grid { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
}
.panel h3 {
    margin: 0 0 12px 0;
    font-size: 0.95rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel h3 .dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--accent-primary);
    display: inline-block;
}

/* CERT CARD */
.cert-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 10px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.78rem;
    color: var(--text-secondary);
}
.cert-card .cert-title {
    font-family: "Inter", sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}
.cert-card .field { margin-bottom: 4px; }
.cert-card .field span.label { color: var(--text-muted); }
.broken-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: var(--error);
    font-size: 0.85rem;
    font-weight: 600;
    margin: 10px 0;
    padding: 8px;
    border: 1px dashed var(--error);
    border-radius: 6px;
}

/* CANDIDATES */
.candidates-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
@media (max-width: 500px) {
    .candidates-grid { grid-template-columns: 1fr; }
}
.candidate-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.72rem;
    color: var(--text-secondary);
}
.candidate-card:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.candidate-card.selected {
    border-color: var(--accent-secondary);
    box-shadow: 0 0 12px rgba(139,123,255,0.4);
}
.candidate-card .cand-label {
    font-family: "Inter", sans-serif;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 6px;
    font-size: 0.82rem;
}

#submit-chain-btn {
    margin-top: 14px;
    width: 100%;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px;
    border-radius: 8px;
    font-family: "Inter", sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
#submit-chain-btn:hover {
    box-shadow: var(--glow-accent);
}
#submit-chain-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ROOT STORE */
#root-store-panel .cert-card {
    border-color: var(--success);
}

/* STATUS AREA */
.status-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 25px;
    font-size: 0.88rem;
    color: var(--text-secondary);
    min-height: 24px;
}
.status-area.status-error {
    border-color: var(--error);
    color: var(--error);
}
.status-area.status-success {
    border-color: var(--success);
    color: var(--success);
}

/* FLAG AREA */
.flag-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    opacity: 0.4;
    transition: all 0.4s ease;
}
.flag-area.unlocked {
    opacity: 1;
    border-color: var(--success);
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}
.flag-area h3 {
    margin: 0 0 10px 0;
    font-size: 1rem;
    color: var(--text-primary);
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.2rem;
    color: var(--success);
    background: var(--bg-primary);
    display: inline-block;
    padding: 10px 18px;
    border-radius: 6px;
    border: 1px solid var(--border-default);
    user-select: all;
}
.flag-placeholder {
    color: var(--text-muted);
    font-family: "JetBrains Mono", monospace;
    font-size: 0.95rem;
}

/* SPOTLIGHT TUTORIAL */
#spotlight {
    position: fixed;
    z-index: 9998;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    display: none;
}
#tooltip-card {
    position: fixed;
    z-index: 9999;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 0.85rem;
    color: var(--text-secondary);
    box-shadow: var(--glow-accent);
    display: none;
}
#tooltip-card .tt-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 6px;
    font-size: 0.9rem;
}
#tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 12px;
}
#tooltip-card button {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
    font-family: "Inter", sans-serif;
}
#tooltip-card button.primary {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
}
#tooltip-card button:hover {
    box-shadow: var(--glow-accent);
}

/* MODAL */
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
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 400px;
    text-align: center;
}
.modal-box h3 {
    margin: 0 0 10px 0;
    color: var(--text-primary);
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 18px 0;
}
.modal-box button {
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: "Inter", sans-serif;
}
</style>
</head>
<body>

<div class="page-wrap">

    <!-- 1. HEADER -->
    <div class="header">
        <div>
            <h1>Certificate Chain Inspector</h1>
            <p class="subtitle">secure-bank-demo.com has presented a certificate, but your browser cannot find a trusted path to a root.</p>
        </div>
        <button id="tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION -->
    <div class="description-box">
        <h3>Mission Briefing</h3>
        <p>This environment simulates a browser's certificate chain viewer. The presented leaf certificate is valid on its own, but the chain is broken, an intermediate certificate is missing.</p>
        <p>Inspect the leaf certificate's issuer field, examine each candidate intermediate certificate, and select the one that correctly and validly completes the chain back to the trusted root shown at the bottom.</p>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="main-grid">
        <div class="panel" id="presented-chain-panel">
            <h3><span class="dot"></span>Presented Chain</h3>
            <div class="cert-card" id="leaf-cert-card">
                <div class="cert-title">Leaf Certificate</div>
                <div class="field"><span class="label">Subject:</span> CN=secure-bank-demo.com, O=SecureBank Ltd</div>
                <div class="field"><span class="label">Issuer:</span> CN=SecureBank Issuing CA G2, O=SecureBank Ltd</div>
                <div class="field"><span class="label">Validity:</span> Jan 15 2026 to Jan 15 2027</div>
                <div class="field"><span class="label">Key Usage:</span> Digital Signature, Key Encipherment</div>
                <div class="field"><span class="label">Serial:</span> 04:3F:AA:12:9B</div>
            </div>
            <div class="broken-link">⚠ Missing intermediate certificate, chain incomplete</div>
        </div>

        <div class="panel" id="candidates-panel">
            <h3><span class="dot"></span>Candidate Intermediate CAs</h3>
            <div class="candidates-grid" id="candidates-grid">
                <div class="candidate-card" id="candidate-card" data-cand="A">
                    <div class="cand-label">Candidate A</div>
                    <div>Subject: CN=SecureBank Issuing CA G2, O=SecureBank Ltd</div>
                    <div>Issuer: CN=SecureBank Root CA, O=SecureBank Ltd</div>
                    <div>Validity: 2023 to 2033</div>
                    <div>Basic Constraints: CA:TRUE</div>
                    <div>Key Usage: Certificate Sign, CRL Sign</div>
                </div>
                <div class="candidate-card" data-cand="B">
                    <div class="cand-label">Candidate B</div>
                    <div>Subject: CN=SecureBank Issuing CA G1, O=SecureBank Ltd</div>
                    <div>Issuer: CN=SecureBank Root CA, O=SecureBank Ltd</div>
                    <div>Validity: 2019 to 2022 (expired)</div>
                    <div>Basic Constraints: CA:TRUE</div>
                    <div>Key Usage: Certificate Sign, CRL Sign</div>
                </div>
                <div class="candidate-card" data-cand="C">
                    <div class="cand-label">Candidate C</div>
                    <div>Subject: CN=SecureBank Issuing CA G2, O=SecureBank Holdings</div>
                    <div>Issuer: CN=SecureBank Root CA, O=SecureBank Ltd</div>
                    <div>Validity: 2023 to 2033</div>
                    <div>Basic Constraints: CA:TRUE</div>
                    <div>Key Usage: Certificate Sign, CRL Sign</div>
                </div>
                <div class="candidate-card" data-cand="D">
                    <div class="cand-label">Candidate D</div>
                    <div>Subject: CN=SecureBank Issuing CA G2, O=SecureBank Ltd</div>
                    <div>Issuer: CN=SecureBank Root CA, O=SecureBank Ltd</div>
                    <div>Validity: 2023 to 2033</div>
                    <div>Basic Constraints: CA:FALSE</div>
                    <div>Key Usage: Digital Signature</div>
                </div>
            </div>
            <button id="submit-chain-btn" disabled>Select Candidate First</button>
        </div>
    </div>

    <div class="panel" id="root-store-panel" style="margin-bottom: 25px;">
        <h3><span class="dot"></span>Trusted Root Store</h3>
        <div class="cert-card">
            <div class="cert-title">Trusted Root</div>
            <div class="field"><span class="label">Subject:</span> CN=SecureBank Root CA, O=SecureBank Ltd</div>
            <div class="field"><span class="label">Self-signed:</span> Yes</div>
            <div class="field"><span class="label">Status:</span> Pre-trusted in this environment</div>
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS AREA -->
    <div class="status-area" id="status-area">Select a candidate intermediate certificate, then submit to rebuild the chain.</div>

    <!-- 5. FLAG REVEAL AREA -->
    <div class="flag-area" id="flag-area">
        <h3>Chain Validation Result</h3>
        <div class="flag-placeholder" id="flag-placeholder">Flag will appear here once the chain is correctly validated.</div>
        <div class="flag-value" id="flag-value" style="display:none;"></div>
    </div>

</div>

<!-- Spotlight tutorial elements -->
<div id="spotlight"></div>
<div id="tooltip-card">
    <div class="tt-title" id="tt-title"></div>
    <div id="tt-body"></div>
    <div class="tt-actions">
        <button id="tt-skip">Skip Tutorial</button>
        <button id="tt-next" class="primary">Next</button>
    </div>
</div>

<!-- Completion modal -->
<div class="modal-overlay" id="modal-overlay">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're Ready to Start the Challenge</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    var selectedCandidate = null;
    var correctCandidate = 'A';
    var flagValue = 'CBX{chain_restored}';
    var chainValidated = false;

    var candidateCards = document.querySelectorAll('.candidate-card');
    var submitBtn = document.getElementById('submit-chain-btn');
    var statusArea = document.getElementById('status-area');
    var flagArea = document.getElementById('flag-area');
    var flagPlaceholder = document.getElementById('flag-placeholder');
    var flagValueEl = document.getElementById('flag-value');

    candidateCards.forEach(function(card) {
        card.addEventListener('click', function() {
            candidateCards.forEach(function(c) { c.classList.remove('selected'); });
            card.classList.add('selected');
            selectedCandidate = card.getAttribute('data-cand');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Validate Chain with Candidate ' + selectedCandidate;
            statusArea.className = 'status-area';
            statusArea.textContent = 'Candidate ' + selectedCandidate + ' selected. Click validate to check the chain.';
        });
    });

    submitBtn.addEventListener('click', function() {
        if (!selectedCandidate) return;

        if (selectedCandidate === correctCandidate) {
            statusArea.className = 'status-area status-success';
            statusArea.textContent = 'Issuer and Subject match, Basic Constraints is CA:TRUE, certificate is valid. Chain rebuilt: Leaf -> Intermediate -> Root.';
            chainValidated = true;
            flagArea.classList.add('unlocked');
            flagPlaceholder.style.display = 'none';
            flagValueEl.style.display = 'inline-block';
            flagValueEl.textContent = flagValue;
        } else {
            chainValidated = false;
            flagArea.classList.remove('unlocked');
            flagPlaceholder.style.display = 'block';
            flagValueEl.style.display = 'none';
            statusArea.className = 'status-area status-error';
            var reason = '';
            if (selectedCandidate === 'B') {
                reason = 'This candidate is expired. An expired certificate cannot be used to validate a chain.';
            } else if (selectedCandidate === 'C') {
                reason = 'The organization field does not exactly match the leaf certificate\'s issuer. Subject and Issuer must match precisely.';
            } else if (selectedCandidate === 'D') {
                reason = 'Basic Constraints is CA:FALSE on this candidate, meaning it is not permitted to sign other certificates.';
            }
            statusArea.textContent = 'Candidate ' + selectedCandidate + ' does not correctly complete the chain. ' + reason;
        }
    });

    // ================= SPOTLIGHT TUTORIAL SYSTEM =================
    var tutorialSteps = [
        {
            targetId: 'presented-chain-panel',
            title: 'Presented Chain',
            body: 'This shows the certificate the website presented to your browser. Notice the broken link, something is missing before we reach a trusted root.'
        },
        {
            targetId: 'leaf-cert-card',
            title: 'Leaf Certificate',
            body: 'This is the leaf certificate, issued directly to the website. Check its Issuer field carefully, that tells you which CA should come next.'
        },
        {
            targetId: 'candidates-panel',
            title: 'Candidate Intermediates',
            body: 'These are four candidate intermediate certificates. Only one correctly and validly completes the chain.'
        },
        {
            targetId: 'candidate-card',
            title: 'Inspect Each Candidate',
            body: 'Click any candidate to inspect its Subject, Issuer, Validity, and Basic Constraints.'
        },
        {
            targetId: 'submit-chain-btn',
            title: 'Validate the Chain',
            body: 'Once you have identified the correct intermediate, select it here to rebuild the trust chain.'
        },
        {
            targetId: 'root-store-panel',
            title: 'Trusted Root Store',
            body: 'This is your trusted root store. A valid chain must terminate here, at a root your system already trusts.'
        }
    ];

    var currentStep = 0;
    var spotlight = document.getElementById('spotlight');
    var tooltip = document.getElementById('tooltip-card');
    var ttTitle = document.getElementById('tt-title');
    var ttBody = document.getElementById('tt-body');
    var tutorialActive = false;

    function positionSpotlight(el) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlight.style.display = 'block';
        spotlight.style.top = (rect.top - pad) + 'px';
        spotlight.style.left = (rect.left - pad) + 'px';
        spotlight.style.width = (rect.width + pad * 2) + 'px';
        spotlight.style.height = (rect.height + pad * 2) + 'px';

        var ttWidth = 280;
        var top = rect.bottom + 14;
        var left = rect.left;

        if (left + ttWidth > window.innerWidth - 20) {
            left = window.innerWidth - ttWidth - 20;
        }
        if (top + 160 > window.innerHeight) {
            top = rect.top - 160;
        }
        if (top < 10) { top = 10; }
        if (left < 10) { left = 10; }

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
        tooltip.style.display = 'block';
    }

    function showStep(index) {
        if (index >= tutorialSteps.length) {
            endTutorial(true);
            return;
        }
        var step = tutorialSteps[index];
        var el = document.getElementById(step.targetId);
        if (!el) { currentStep++; showStep(currentStep); return; }

        var rect = el.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        ttTitle.textContent = step.title;
        ttBody.textContent = step.body;

        if (!inView) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(function() { positionSpotlight(el); }, 300);
        } else {
            positionSpotlight(el);
        }
    }

    function startTutorial() {
        tutorialActive = true;
        currentStep = 0;
        showStep(currentStep);
    }

    function endTutorial(completed) {
        tutorialActive = false;
        spotlight.style.display = 'none';
        tooltip.style.display = 'none';
        if (completed) {
            document.getElementById('modal-overlay').style.display = 'flex';
        }
    }

    document.getElementById('tt-next').addEventListener('click', function() {
        currentStep++;
        showStep(currentStep);
    });

    document.getElementById('tt-skip').addEventListener('click', function() {
        endTutorial(false);
    });

    document.getElementById('tutorial-btn').addEventListener('click', function() {
        startTutorial();
    });

    document.getElementById('start-challenge-btn').addEventListener('click', function() {
        document.getElementById('modal-overlay').style.display = 'none';
    });

    window.addEventListener('resize', function() {
        if (tutorialActive) {
            var step = tutorialSteps[currentStep];
            if (step) {
                var el = document.getElementById(step.targetId);
                if (el) positionSpotlight(el);
            }
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
