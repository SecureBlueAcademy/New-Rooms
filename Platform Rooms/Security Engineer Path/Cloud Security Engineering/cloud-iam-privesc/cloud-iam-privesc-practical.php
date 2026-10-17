<?php
// cloud-iam-privesc-practical.php
// Standalone static practical: Least Privilege Refactor
// HTML / CSS / vanilla JS only. No backend logic, no database, no sessions.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Least Privilege Refactor</title>
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
    line-height: 1.6;
    padding: 0 0 60px 0;
}

code, .mono {
    font-family: 'JetBrains Mono', monospace;
}

.wrapper {
    max-width: 980px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ===== Header ===== */
.page-header {
    position: relative;
    padding: 40px 24px 30px 24px;
    border-bottom: 1px solid var(--border-default);
    background: linear-gradient(180deg, rgba(106,227,255,0.06), transparent);
}
.page-header-inner {
    max-width: 980px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
}
.page-header h1 {
    margin: 0 0 8px 0;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
}
.page-header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 1rem;
    max-width: 640px;
}

.tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    color: var(--accent-primary);
    border: 1px solid var(--accent-primary);
    border-radius: 8px;
    padding: 10px 18px;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.tutorial-btn:hover {
    background: rgba(106,227,255,0.1);
    box-shadow: var(--glow-accent);
}

/* ===== Description Section ===== */
.mission-briefing {
    margin: 28px 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
}
.mission-briefing h2 {
    margin: 0 0 10px 0;
    font-size: 1.1rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
}
.mission-briefing p:last-child { margin-bottom: 0; }

/* ===== Panels ===== */
.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    margin: 20px 0;
}
.panel h3 {
    margin: 0 0 14px 0;
    font-size: 1.05rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel h3 .tag {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 5px;
    background: rgba(255,92,92,0.12);
    color: var(--error);
    letter-spacing: 0.03em;
}
.panel h3 .tag.good {
    background: rgba(61,255,154,0.12);
    color: var(--success);
}

.req-list {
    margin: 0;
    padding-left: 20px;
    color: var(--text-secondary);
    font-size: 0.92rem;
}
.req-list li { margin-bottom: 6px; }
.req-list li:last-child { margin-bottom: 0; }

.policy-code {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px 18px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    color: var(--text-primary);
    overflow-x: auto;
    white-space: pre;
}
.policy-code .kw { color: var(--accent-secondary); }
.policy-code .danger { color: var(--error); font-weight: 600; }

/* ===== Action selector ===== */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 10px;
}
.check-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 14px;
    cursor: pointer;
    transition: border-color 0.2s ease;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
}
.check-item:hover { border-color: var(--accent-primary); }
.check-item input { accent-color: var(--accent-primary); width: 16px; height: 16px; }

/* ===== Resource scope selector ===== */
.radio-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.radio-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 14px;
    cursor: pointer;
}
.radio-item:hover { border-color: var(--accent-primary); }
.radio-item input { margin-top: 3px; accent-color: var(--accent-primary); width: 16px; height: 16px; }
.radio-item .radio-label { font-weight: 600; font-size: 0.92rem; }
.radio-item .radio-sub { font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }

/* ===== Submit ===== */
.submit-row { margin-top: 22px; text-align: center; }
.submit-btn {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #06121a;
    border: none;
    border-radius: 8px;
    padding: 14px 32px;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.submit-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 0 20px rgba(106,227,255,0.35);
}

/* ===== Feedback ===== */
.feedback-panel { min-height: 40px; }
.feedback-msg {
    border-radius: 8px;
    padding: 14px 18px;
    font-size: 0.92rem;
    margin-bottom: 10px;
}
.feedback-msg:last-child { margin-bottom: 0; }
.feedback-msg.bad {
    background: rgba(255,92,92,0.08);
    border: 1px solid rgba(255,92,92,0.35);
    color: var(--error);
}
.feedback-msg.warn {
    background: rgba(255,211,106,0.08);
    border: 1px solid rgba(255,211,106,0.35);
    color: var(--warning);
}
.feedback-msg.good {
    background: rgba(61,255,154,0.08);
    border: 1px solid rgba(61,255,154,0.35);
    color: var(--success);
}
.feedback-placeholder {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-style: italic;
}

/* ===== Flag reveal ===== */
.flag-area {
    margin: 24px 0 0 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    text-align: center;
}
.flag-area h3 {
    margin: 0 0 12px 0;
    color: var(--success);
    font-size: 1.05rem;
}
.flag-value {
    display: inline-block;
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid rgba(61,255,154,0.4);
    border-radius: 8px;
    padding: 12px 20px;
    letter-spacing: 0.02em;
}
.flag-locked {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-style: italic;
}

/* ===== Spotlight tutorial ===== */
.spotlight-box {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    transition: all 0.25s ease;
    pointer-events: none;
    z-index: 9998;
}
.tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    z-index: 9999;
    box-shadow: var(--glow-accent);
    transition: all 0.25s ease;
}
.tutorial-tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: var(--text-primary);
}
.tutorial-tooltip .tt-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tutorial-tooltip .tt-step {
    font-size: 0.75rem;
    color: var(--text-muted);
}
.tt-buttons { display: flex; gap: 8px; }
.tt-btn {
    background: var(--accent-primary);
    color: #06121a;
    border: none;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}
.tt-btn.secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-default);
}

/* ===== Modal ===== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px 32px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--glow-accent);
}
.modal-box h3 {
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}
.modal-box p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 18px 0;
}
.modal-box button {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
    color: #06121a;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    font-weight: 700;
    cursor: pointer;
}

.hidden { display: none !important; }
</style>
</head>
<body>

<div class="page-header">
    <div class="page-header-inner">
        <div>
            <h1>Least Privilege Refactor</h1>
            <p>A data processing service currently holds unrestricted S3 access. Rebuild its policy so it can do its job and nothing more.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>
</div>

<div class="wrapper">

    <div class="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>This environment simulates a cloud IAM console for a single service role attached to a report processing workload. The role currently has far more access than the workload requires.</p>
        <p>Your goal: review what the workload actually needs, then select the exact actions and resource scope required, nothing more and nothing less. Submit your policy to get feedback, and refine it until it is correctly scoped.</p>
    </div>

    <div class="panel" id="workload-requirements-panel">
        <h3>Workload Requirements <span class="tag good">Needed</span></h3>
        <ul class="req-list">
            <li>Read objects from the <code>reports-input</code> bucket</li>
            <li>List objects in the <code>reports-input</code> bucket</li>
            <li>Write objects to the <code>reports-output</code> bucket</li>
            <li>Nothing else. No deletes, no bucket policy changes, no other buckets, no other services.</li>
        </ul>
    </div>

    <div class="panel" id="current-policy-panel">
        <h3>Current Attached Policy <span class="tag">Overly Permissive</span></h3>
        <div class="policy-code">{
  "Effect": "Allow",
  "Action": <span class="danger">"s3:*"</span>,
  "Resource": <span class="danger">"*"</span>
}</div>
        <p style="margin-top:12px; color: var(--text-secondary); font-size: 0.88rem;">
            This grants every S3 action on every bucket in the account, including deleting buckets, changing bucket policies, and reading buckets that have nothing to do with this workload.
        </p>
    </div>

    <div class="panel" id="action-selector">
        <h3>Step 1: Select Actions</h3>
        <div class="checkbox-grid">
            <label class="check-item"><input type="checkbox" value="s3:GetObject"> s3:GetObject</label>
            <label class="check-item"><input type="checkbox" value="s3:PutObject"> s3:PutObject</label>
            <label class="check-item"><input type="checkbox" value="s3:ListBucket"> s3:ListBucket</label>
            <label class="check-item"><input type="checkbox" value="s3:DeleteObject"> s3:DeleteObject</label>
            <label class="check-item"><input type="checkbox" value="s3:PutBucketPolicy"> s3:PutBucketPolicy</label>
            <label class="check-item"><input type="checkbox" value="s3:*"> s3:*</label>
            <label class="check-item"><input type="checkbox" value="iam:*"> iam:*</label>
            <label class="check-item"><input type="checkbox" value="ec2:*"> ec2:*</label>
        </div>
    </div>

    <div class="panel" id="resource-scope-selector">
        <h3>Step 2: Select Resource Scope</h3>
        <div class="radio-group">
            <label class="radio-item">
                <input type="radio" name="resource-scope" value="wildcard">
                <div>
                    <div class="radio-label">Wildcard</div>
                    <div class="radio-sub">"Resource": "*"</div>
                </div>
            </label>
            <label class="radio-item">
                <input type="radio" name="resource-scope" value="scoped">
                <div>
                    <div class="radio-label">Scoped to the two buckets involved</div>
                    <div class="radio-sub">"Resource": ["arn:aws:s3:::reports-input", "arn:aws:s3:::reports-input/*", "arn:aws:s3:::reports-output/*"]</div>
                </div>
            </label>
        </div>

        <div class="submit-row">
            <button class="submit-btn" id="submit-policy-btn">Submit Policy</button>
        </div>
    </div>

    <div class="panel feedback-panel" id="feedback-panel">
        <h3>Feedback</h3>
        <div id="feedback-content">
            <p class="feedback-placeholder">Submit a policy above to see feedback here.</p>
        </div>
    </div>

    <div class="flag-area" id="flag-area">
        <h3>Flag</h3>
        <div id="flag-content">
            <p class="flag-locked">Locked. Submit a correctly scoped least privilege policy to reveal the flag.</p>
        </div>
    </div>

</div>

<div id="tutorial-modal-overlay" class="modal-overlay hidden">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Refine the policy until it matches exactly what the workload needs.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<div id="spotlight-box" class="spotlight-box hidden"></div>
<div id="tutorial-tooltip" class="tutorial-tooltip hidden">
    <p id="tooltip-text"></p>
    <div class="tt-actions">
        <span class="tt-step" id="tooltip-step"></span>
        <div class="tt-buttons">
            <button class="tt-btn secondary" id="tt-skip-btn">Skip Tutorial</button>
            <button class="tt-btn" id="tt-next-btn">Next</button>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    var CORRECT_ACTIONS = ['s3:GetObject', 's3:PutObject', 's3:ListBucket'];
    var FLAG = 'CBX{least_privilege_enforced}';

    // ===== Tutorial system =====
    var tutorialSteps = [
        { id: 'workload-requirements-panel', text: 'This shows what the workload actually needs to do. Real world IAM engineering always starts here, not with the policy.' },
        { id: 'current-policy-panel', text: 'This is the current policy attached to the service. Notice the wildcards. This is the overly permissive starting point you are going to fix.' },
        { id: 'action-selector', text: 'Select only the actions the workload needs. Think of this like handing out keys. Every extra key is a risk if the service is ever compromised.' },
        { id: 'resource-scope-selector', text: 'Now scope the resources. A wildcard resource means the permission applies everywhere. Specific ARNs limit the blast radius to just the buckets involved.' },
        { id: 'submit-policy-btn', text: 'Submit your policy. You will get feedback if it is too broad or too narrow, so you can refine it.' },
        { id: 'feedback-panel', text: 'This is where you will see whether your policy is correctly scoped, too permissive, or missing something the workload needs.' }
    ];

    var currentStep = 0;
    var spotlightBox = document.getElementById('spotlight-box');
    var tooltip = document.getElementById('tutorial-tooltip');
    var tooltipText = document.getElementById('tooltip-text');
    var tooltipStep = document.getElementById('tooltip-step');

    function positionSpotlight(el) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlightBox.style.top = (rect.top - pad) + 'px';
        spotlightBox.style.left = (rect.left - pad) + 'px';
        spotlightBox.style.width = (rect.width + pad * 2) + 'px';
        spotlightBox.style.height = (rect.height + pad * 2) + 'px';

        var tooltipWidth = 300;
        var top = rect.bottom + 16;
        var left = rect.left;

        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 140 > window.innerHeight) {
            top = rect.top - 150;
            if (top < 10) top = 10;
        }

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
        tooltip.style.width = tooltipWidth + 'px';
    }

    function showStep(index) {
        var step = tutorialSteps[index];
        var el = document.getElementById(step.id);
        if (!el) { nextStep(); return; }

        var rect = el.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function render() {
            spotlightBox.classList.remove('hidden');
            tooltip.classList.remove('hidden');
            positionSpotlight(el);
            tooltipText.textContent = step.text;
            tooltipStep.textContent = 'Step ' + (index + 1) + ' of ' + tutorialSteps.length;
        }

        if (!inView) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(render, 300);
        } else {
            render();
        }
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
        spotlightBox.classList.add('hidden');
        tooltip.classList.add('hidden');
        if (completed) {
            document.getElementById('tutorial-modal-overlay').classList.remove('hidden');
        }
    }

    function startTutorial() {
        currentStep = 0;
        showStep(currentStep);
    }

    document.getElementById('tt-next-btn').addEventListener('click', nextStep);
    document.getElementById('tt-skip-btn').addEventListener('click', function() { endTutorial(false); });
    document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
    document.getElementById('start-challenge-btn').addEventListener('click', function() {
        document.getElementById('tutorial-modal-overlay').classList.add('hidden');
    });

    window.addEventListener('resize', function() {
        if (!spotlightBox.classList.contains('hidden')) {
            var step = tutorialSteps[currentStep];
            var el = document.getElementById(step.id);
            if (el) positionSpotlight(el);
        }
    });

    // Auto-start tutorial on first load
    window.addEventListener('load', function() {
        setTimeout(startTutorial, 400);
    });

    // ===== Policy submission logic =====
    document.getElementById('submit-policy-btn').addEventListener('click', function() {
        var checked = Array.prototype.slice.call(document.querySelectorAll('#action-selector input[type=checkbox]:checked')).map(function(el) { return el.value; });
        var scopeEl = document.querySelector('input[name="resource-scope"]:checked');
        var scope = scopeEl ? scopeEl.value : null;

        var feedbackContent = document.getElementById('feedback-content');
        var messages = [];

        if (!scope) {
            messages.push({ type: 'warn', text: 'Select a resource scope before submitting.' });
            renderFeedback(messages);
            return;
        }

        var tooBroadActions = checked.filter(function(a) {
            return ['s3:*', 'iam:*', 'ec2:*', 's3:DeleteObject', 's3:PutBucketPolicy'].indexOf(a) !== -1;
        });

        if (tooBroadActions.length > 0) {
            messages.push({ type: 'bad', text: 'This policy grants more than the workload needs: ' + tooBroadActions.join(', ') + '. Remove any action the workload does not perform.' });
        }

        var missingActions = CORRECT_ACTIONS.filter(function(a) { return checked.indexOf(a) === -1; });
        if (missingActions.length > 0) {
            var breaks = missingActions.map(function(a) {
                if (a === 's3:ListBucket') return 'without s3:ListBucket the service can never detect new files in reports-input';
                if (a === 's3:GetObject') return 'without s3:GetObject the service cannot read report files';
                if (a === 's3:PutObject') return 'without s3:PutObject the service cannot write processed output';
                return a;
            });
            messages.push({ type: 'bad', text: 'This policy is too narrow: ' + breaks.join('; ') + '.' });
        }

        if (scope === 'wildcard') {
            messages.push({ type: 'bad', text: 'A wildcard resource applies this policy to every bucket in the account, not just the two the workload uses. Scope it to reports-input and reports-output only.' });
        }

        if (messages.length === 0) {
            messages.push({ type: 'good', text: 'Correctly scoped. This policy grants exactly what the workload needs: read and list on reports-input, write on reports-output, nothing more.' });
            renderFeedback(messages);
            revealFlag();
            return;
        }

        renderFeedback(messages);
    });

    function renderFeedback(messages) {
        var feedbackContent = document.getElementById('feedback-content');
        feedbackContent.innerHTML = '';
        messages.forEach(function(m) {
            var div = document.createElement('div');
            div.className = 'feedback-msg ' + m.type;
            div.textContent = m.text;
            feedbackContent.appendChild(div);
        });
    }

    function revealFlag() {
        var flagContent = document.getElementById('flag-content');
        flagContent.innerHTML = '<span class="flag-value">' + FLAG + '</span>';
    }
})();
</script>

</body>
</html>
