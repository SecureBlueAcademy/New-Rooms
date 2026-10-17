<?php
// ============================================================
// security-engineering-principles-practical.php
// Access Control Redesign Lab — standalone static practical
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Access Control Redesign Lab</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    min-height: 100vh;
}

.page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 24px 20px 60px 20px;
    position: relative;
}

/* HEADER */
.header {
    position: relative;
    text-align: center;
    padding: 20px 0 10px 0;
}
.header h1 {
    font-size: 2rem;
    margin: 10px 0 6px 0;
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 640px;
    margin: 0 auto;
}
#view-tutorial-btn {
    position: absolute;
    top: 8px;
    right: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 9px 16px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
#view-tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

/* DESCRIPTION */
.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin: 24px 0;
}
.description-section p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 8px 0;
    font-size: 0.95rem;
}
.description-section strong {
    color: var(--text-primary);
}

/* LAB CONTAINER */
.lab-container {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
@media (max-width: 820px) {
    .lab-container { grid-template-columns: 1fr; }
}

#architecture-diagram {
    background: var(--bg-secondary);
    border: 2px solid var(--border-default);
    border-radius: 14px;
    padding: 22px;
    transition: border-color 0.4s ease, box-shadow 0.4s ease;
}
#architecture-diagram.hardened {
    border-color: var(--success);
    box-shadow: 0 0 30px rgba(61,255,154,0.25);
}
.diagram-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 16px;
}

.weak-point {
    background: var(--bg-surface);
    border: 2px dashed rgba(255,92,92,0.4);
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 14px;
    transition: all 0.25s ease;
    min-height: 64px;
}
.weak-point.dragover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.weak-point.fixed {
    border-style: solid;
    border-color: var(--success);
    background: rgba(61,255,154,0.06);
}
.weak-point .wp-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-primary);
}
.weak-point .wp-problem {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 4px;
}
.weak-point .wp-fixed-tag {
    display: none;
    margin-top: 8px;
    font-size: 0.78rem;
    font-family: 'JetBrains Mono', monospace;
    color: var(--success);
}
.weak-point.fixed .wp-problem { display: none; }
.weak-point.fixed .wp-fixed-tag { display: block; }

/* CONTROLS TRAY */
#controls-tray {
    background: var(--bg-secondary);
    border: 2px solid var(--border-default);
    border-radius: 14px;
    padding: 22px;
    height: fit-content;
}
.tray-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 16px;
    color: var(--text-primary);
}
.control-item {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 12px;
    cursor: grab;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--accent-primary);
    transition: all 0.2s ease;
}
.control-item:active { cursor: grabbing; }
.control-item:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.control-item.placed { display: none; }

/* PROGRESS + STATUS */
#progress-tracker {
    text-align: center;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.95rem;
    color: var(--text-secondary);
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 16px;
}
#status-area {
    min-height: 24px;
    text-align: center;
    font-size: 0.88rem;
    color: var(--text-muted);
    margin-bottom: 16px;
}
#status-area.error { color: var(--error); }
#status-area.success { color: var(--success); }

/* FLAG AREA */
.flag-area {
    text-align: center;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(106,227,255,0.06));
    border: 2px solid var(--success);
    border-radius: 14px;
    padding: 28px 20px;
    margin-top: 10px;
}
.flag-area.hidden { display: none; }
.flag-area h2 {
    color: var(--success);
    margin: 0 0 12px 0;
}
.flag-value {
    display: inline-block;
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.15rem;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 20px;
    border-radius: 8px;
    letter-spacing: 0.02em;
}

/* SPOTLIGHT TUTORIAL */
.spotlight {
    position: fixed;
    z-index: 9998;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.3s ease;
    pointer-events: none;
}
.tooltip-card {
    position: fixed;
    z-index: 9999;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 16px 18px;
    max-width: 300px;
    box-shadow: var(--glow-accent);
    font-size: 0.88rem;
    color: var(--text-secondary);
    line-height: 1.5;
}
.tooltip-card .tt-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
}
.tooltip-card button {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 7px 14px;
    cursor: pointer;
    border: none;
}
.tt-skip {
    background: transparent;
    color: var(--text-muted);
}
.tt-next {
    background: var(--accent-primary);
    color: var(--bg-primary);
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-overlay.hidden { display: none; }
.modal-card {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 14px;
    padding: 28px 26px;
    max-width: 360px;
    text-align: center;
}
.modal-card h3 { margin-top: 0; color: var(--accent-primary); }
.modal-card p { color: var(--text-secondary); font-size: 0.9rem; }
.modal-card button {
    margin-top: 12px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="page">

    <div class="header">
        <button id="view-tutorial-btn">View Tutorial</button>
        <h1>Access Control Redesign Lab</h1>
        <p class="subtitle">MegaCorp's internal portal was built for convenience, not security. Fix the architecture before it becomes an incident report.</p>
    </div>

    <div class="description-section">
        <p>Below is a simplified diagram of <strong>MegaCorp's internal portal</strong>. Five weaknesses were introduced when the system was built quickly and never revisited.</p>
        <p>Drag each control from the tray on the right onto the weak point it fixes. A correct placement locks in and reveals the principle it demonstrates. The system is fully hardened once all five controls are correctly applied.</p>
    </div>

    <div class="lab-container">
        <div id="architecture-diagram">
            <div class="diagram-title">MegaCorp Internal Portal - Current Architecture</div>

            <div class="weak-point" id="dropzone-1" data-correct="control-1" data-principle="Defence in Depth">
                <div class="wp-label">Flat Network Zone</div>
                <div class="wp-problem">All servers sit on one unsegmented network with no internal boundaries.</div>
                <div class="wp-fixed-tag"></div>
            </div>

            <div class="weak-point" id="dropzone-2" data-correct="control-2" data-principle="Least Privilege">
                <div class="wp-label">Single Admin Account Node</div>
                <div class="wp-problem">One account has standing access to every system in the portal.</div>
                <div class="wp-fixed-tag"></div>
            </div>

            <div class="weak-point" id="dropzone-3" data-correct="control-3" data-principle="Fail-Secure Design">
                <div class="wp-label">Firewall Gate (Fails Open)</div>
                <div class="wp-problem">If the firewall service crashes, traffic passes through unfiltered.</div>
                <div class="wp-fixed-tag"></div>
            </div>

            <div class="weak-point" id="dropzone-4" data-correct="control-4" data-principle="Separation of Duties">
                <div class="wp-label">Transaction Approval Node</div>
                <div class="wp-problem">One person can both request and approve the same change.</div>
                <div class="wp-fixed-tag"></div>
            </div>

            <div class="weak-point" id="dropzone-5" data-correct="control-5" data-principle="Economy of Mechanism">
                <div class="wp-label">Tangled ACL Rule Box</div>
                <div class="wp-problem">Overlapping, contradictory access rules that nobody can fully explain.</div>
                <div class="wp-fixed-tag"></div>
            </div>
        </div>

        <div id="controls-tray">
            <div class="tray-title">Available Controls</div>
            <div class="control-item" id="control-item-1" draggable="true" data-control-id="control-1">Network Segmentation Layer</div>
            <div class="control-item" id="control-item-2" draggable="true" data-control-id="control-2">Role Based Access Control</div>
            <div class="control-item" id="control-item-3" draggable="true" data-control-id="control-3">Default Deny Rule</div>
            <div class="control-item" id="control-item-4" draggable="true" data-control-id="control-4">Dual Authorization Step</div>
            <div class="control-item" id="control-item-5" draggable="true" data-control-id="control-5">Simplified Access Policy</div>
        </div>
    </div>

    <div id="progress-tracker">0 of 5 principles applied</div>
    <div id="status-area"></div>

    <div id="flag-area" class="flag-area hidden">
        <h2>System Hardened</h2>
        <p>All five principles have been correctly applied. MegaCorp's portal is secure.</p>
        <div class="flag-value">CBX{architecture_hardened}</div>
    </div>

</div>

<div id="modal-overlay" class="modal-overlay hidden">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Drag each control onto the weak point it fixes.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    var fixedCount = 0;
    var totalNeeded = 5;

    var dropzones = document.querySelectorAll('.weak-point');
    var controls = document.querySelectorAll('.control-item');
    var progressTracker = document.getElementById('progress-tracker');
    var statusArea = document.getElementById('status-area');
    var diagram = document.getElementById('architecture-diagram');
    var flagArea = document.getElementById('flag-area');

    controls.forEach(function(item) {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', item.id);
            e.dataTransfer.effectAllowed = 'move';
        });
    });

    dropzones.forEach(function(zone) {
        zone.addEventListener('dragover', function(e) {
            e.preventDefault();
            if (!zone.classList.contains('fixed')) {
                zone.classList.add('dragover');
            }
        });
        zone.addEventListener('dragleave', function() {
            zone.classList.remove('dragover');
        });
        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            zone.classList.remove('dragover');
            if (zone.classList.contains('fixed')) return;

            var draggedId = e.dataTransfer.getData('text/plain');
            var draggedEl = document.getElementById(draggedId);
            if (!draggedEl) return;

            var draggedControlId = draggedEl.getAttribute('data-control-id');
            var correctControlId = zone.getAttribute('data-correct');

            if (draggedControlId === correctControlId) {
                zone.classList.add('fixed');
                var tag = zone.querySelector('.wp-fixed-tag');
                tag.textContent = 'Fixed: ' + zone.getAttribute('data-principle') + ' applied.';
                draggedEl.classList.add('placed');
                fixedCount++;
                progressTracker.textContent = fixedCount + ' of ' + totalNeeded + ' principles applied';
                statusArea.textContent = 'Correct. ' + zone.getAttribute('data-principle') + ' now protects this weak point.';
                statusArea.className = 'success';

                if (fixedCount === totalNeeded) {
                    diagram.classList.add('hardened');
                    flagArea.classList.remove('hidden');
                    statusArea.textContent = 'All weaknesses resolved. The architecture is fully hardened.';
                }
            } else {
                statusArea.textContent = 'That control does not fix this weakness. Try another one.';
                statusArea.className = 'error';
            }
        });
    });

    // ================= TUTORIAL SYSTEM =================
    var steps = [
        {
            targetId: 'architecture-diagram',
            text: 'This is MegaCorp\'s current system. It works, but it was built with convenience in mind, not security. Five weaknesses are hiding in here.'
        },
        {
            targetId: 'controls-tray',
            text: 'These are the security controls you will apply. Each one fixes exactly one weakness, the same way a locksmith chooses the right lock for the right door.'
        },
        {
            targetId: 'control-item-1',
            text: 'Drag a control from here directly onto the weak point it fixes. If it is the right fit, it will lock into place.'
        },
        {
            targetId: 'progress-tracker',
            text: 'This tracks how many of the five principles you have applied. You need all five to fully harden the system.'
        },
        {
            targetId: 'view-tutorial-btn',
            text: 'You can replay this tutorial any time from here.'
        }
    ];

    var currentStep = 0;
    var spotlightEl = null;
    var tooltipEl = null;

    function createOverlayElements() {
        spotlightEl = document.createElement('div');
        spotlightEl.className = 'spotlight';
        document.body.appendChild(spotlightEl);

        tooltipEl = document.createElement('div');
        tooltipEl.className = 'tooltip-card';
        tooltipEl.innerHTML =
            '<div class="tt-text"></div>' +
            '<div class="tt-actions">' +
            '<button class="tt-skip">Skip Tutorial</button>' +
            '<button class="tt-next">Next</button>' +
            '</div>';
        document.body.appendChild(tooltipEl);

        tooltipEl.querySelector('.tt-skip').addEventListener('click', endTutorial);
        tooltipEl.querySelector('.tt-next').addEventListener('click', nextStep);
    }

    function removeOverlayElements() {
        if (spotlightEl) { spotlightEl.remove(); spotlightEl = null; }
        if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
    }

    function positionOverlay(targetId) {
        var el = document.getElementById(targetId);
        if (!el) return;

        var rect = el.getBoundingClientRect();
        var isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function place() {
            var r = el.getBoundingClientRect();
            var pad = 8;
            spotlightEl.style.top = (r.top - pad) + 'px';
            spotlightEl.style.left = (r.left - pad) + 'px';
            spotlightEl.style.width = (r.width + pad * 2) + 'px';
            spotlightEl.style.height = (r.height + pad * 2) + 'px';

            var tooltipWidth = 300;
            var top, left;

            if (r.bottom + 160 < window.innerHeight) {
                top = r.bottom + 16;
                left = Math.min(r.left, window.innerWidth - tooltipWidth - 20);
            } else if (r.top - 160 > 0) {
                top = r.top - 160;
                left = Math.min(r.left, window.innerWidth - tooltipWidth - 20);
            } else {
                top = Math.max(20, r.top);
                left = r.right + 16 < window.innerWidth - tooltipWidth ? r.right + 16 : Math.max(20, r.left - tooltipWidth - 16);
            }

            left = Math.max(10, left);
            tooltipEl.style.top = top + 'px';
            tooltipEl.style.left = left + 'px';
        }

        if (!isVisible) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(place, 300);
        } else {
            place();
        }
    }

    function showStep(index) {
        var step = steps[index];
        tooltipEl.querySelector('.tt-text').textContent = step.text;
        var nextBtn = tooltipEl.querySelector('.tt-next');
        nextBtn.textContent = (index === steps.length - 1) ? 'Finish' : 'Next';
        positionOverlay(step.targetId);
    }

    function nextStep() {
        currentStep++;
        if (currentStep >= steps.length) {
            endTutorial(true);
        } else {
            showStep(currentStep);
        }
    }

    function startTutorial() {
        currentStep = 0;
        createOverlayElements();
        showStep(0);
    }

    function endTutorial(completed) {
        removeOverlayElements();
        if (completed) {
            document.getElementById('modal-overlay').classList.remove('hidden');
        }
    }

    document.getElementById('start-challenge-btn').addEventListener('click', function() {
        document.getElementById('modal-overlay').classList.add('hidden');
    });

    document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

    window.addEventListener('resize', function() {
        if (spotlightEl && tooltipEl) {
            positionOverlay(steps[currentStep].targetId);
        }
    });

    window.addEventListener('load', function() {
        startTutorial();
    });
})();
</script>

</body>
</html>
