<?php
// FILENAME: command-injection-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Network Diagnostics Tool</title>
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

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    min-height: 100vh;
    padding: 30px 20px 80px 20px;
}

.page-wrap {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.header-text h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
}

.header-text p {
    color: var(--text-secondary);
    margin-top: 6px;
    font-size: 0.95rem;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

.description-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 20px 22px;
    margin-bottom: 24px;
}

.description-section h2 {
    font-size: 1rem;
    color: var(--accent-primary);
    margin-bottom: 10px;
}

.description-section p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 8px;
}

.tool-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 24px;
    margin-bottom: 20px;
}

.tool-panel h2 {
    font-size: 1rem;
    margin-bottom: 14px;
    color: var(--text-primary);
}

.input-row {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

#hostname-input {
    flex: 1;
    min-width: 200px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 12px 14px;
    border-radius: 8px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.9rem;
}

#hostname-input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

#ping-button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

#ping-button:hover {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}

#output-panel {
    background: #05070d;
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    min-height: 160px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-secondary);
    white-space: pre-wrap;
    overflow-x: auto;
}

#output-panel .placeholder {
    color: var(--text-muted);
    font-style: italic;
}

.output-line {
    color: var(--text-secondary);
    line-height: 1.6;
}

.unexpected-block {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed var(--warning);
}

.unexpected-block .label {
    color: var(--warning);
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
}

.unexpected-block .flag-line {
    color: var(--success);
    font-weight: 600;
}

#hint-panel {
    margin-top: 18px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px 16px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

#hint-panel strong {
    color: var(--accent-secondary);
}

.status-area {
    margin-top: 14px;
    font-size: 0.85rem;
    color: var(--text-muted);
    min-height: 20px;
}

.flag-reveal {
    display: none;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--success);
    border-radius: 10px;
    padding: 22px;
    text-align: center;
    box-shadow: 0 0 20px rgba(61,255,154,0.15);
}

.flag-reveal.visible {
    display: block;
}

.flag-reveal h3 {
    color: var(--success);
    margin-bottom: 10px;
    font-size: 1rem;
}

.flag-value {
    display: inline-block;
    background: #05070d;
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 18px;
    border-radius: 6px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1rem;
    letter-spacing: 0.02em;
    user-select: all;
}

/* ========== SPOTLIGHT TUTORIAL ========== */
.spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 9998;
}

.tooltip-card {
    position: fixed;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 280px;
    font-size: 0.85rem;
    color: var(--text-primary);
    box-shadow: var(--glow-accent);
    z-index: 9999;
}

.tooltip-card p {
    color: var(--text-secondary);
    margin-bottom: 12px;
    line-height: 1.5;
}

.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tooltip-actions button {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 0.8rem;
    cursor: pointer;
}

.tooltip-next {
    background: var(--accent-primary) !important;
    color: #0b0f1a !important;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 700;
}

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

.modal-overlay.visible {
    display: flex;
}

.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}

.modal-box h3 {
    color: var(--accent-primary);
    margin-bottom: 12px;
}

.modal-box p {
    color: var(--text-secondary);
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.modal-box button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 12px 26px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 600px) {
    .top-bar { flex-direction: column; gap: 14px; }
    .input-row { flex-direction: column; }
}
</style>
</head>
<body>

<div class="page-wrap">

    <div class="top-bar">
        <div class="header-text">
            <h1>Network Diagnostics Tool</h1>
            <p>Internal IT Connectivity Checker</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>This environment represents an internal tool used by IT staff to check whether a server or device is reachable on the network. It has not been security reviewed yet.</p>
        <p>Your goal is to test how the tool handles input, determine whether it forwards that input to a system shell, and use that weakness to uncover a hidden flag.</p>
    </div>

    <div class="tool-panel">
        <h2>Connectivity Check</h2>
        <div class="input-row">
            <input type="text" id="hostname-input" placeholder="e.g. 192.168.1.1" autocomplete="off">
            <button id="ping-button">Ping</button>
        </div>

        <div id="output-panel"><span class="placeholder">Output will appear here after you run a check.</span></div>

        <div class="status-area" id="status-area"></div>

        <div id="hint-panel">
            <strong>Hint:</strong> Try a normal address first. Then consider what character a shell uses to separate one command from another, and what might happen if you added a second command after your address.
        </div>
    </div>

    <div class="flag-reveal" id="flag-reveal">
        <h3>Unexpected File Contents Retrieved</h3>
        <p>The chained command returned the contents of a file that should never have been reachable.</p>
        <div class="flag-value" id="flag-value">CBX{command_injected}</div>
    </div>

</div>

<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;"></div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    var hostnameInput = document.getElementById('hostname-input');
    var pingButton = document.getElementById('ping-button');
    var outputPanel = document.getElementById('output-panel');
    var statusArea = document.getElementById('status-area');
    var flagReveal = document.getElementById('flag-reveal');
    var whoamiRevealed = false;

    function randomLatency() {
        return (Math.floor(Math.random() * 40) + 8);
    }

    function buildBaselineOutput(host) {
        var lines = [];
        lines.push('Pinging ' + host + ' with 32 bytes of data:');
        for (var i = 0; i < 4; i++) {
            lines.push('Reply from ' + host + ': bytes=32 time=' + randomLatency() + 'ms TTL=64');
        }
        lines.push('');
        lines.push('Ping statistics for ' + host + ':');
        lines.push('    Packets: Sent = 4, Received = 4, Lost = 0 (0% loss)');
        return lines.join('\n');
    }

    function parseInjection(raw) {
        var match = raw.match(/^([^;&|]*)([;&]{1,2}|\|)\s*(.+)$/);
        if (!match) {
            return null;
        }
        return {
            host: match[1].trim() || 'target',
            operator: match[2],
            command: match[3].trim()
        };
    }

    function runCheck() {
        var raw = hostnameInput.value.trim();
        if (!raw) {
            statusArea.textContent = 'Enter a hostname or IP address first.';
            return;
        }

        statusArea.textContent = 'Running check...';

        setTimeout(function() {
            var injection = parseInjection(raw);
            var baselineHost = injection ? injection.host : raw;
            var output = buildBaselineOutput(baselineHost);
            var html = '<span class="output-line">' + escapeHtml(output) + '</span>';

            if (injection) {
                var cmd = injection.command.toLowerCase();

                if (/cat\s+\.?\/?flag\.txt/.test(cmd)) {
                    html += '<div class="unexpected-block">' +
                        '<span class="label">Unexpected output (chained command executed):</span>' +
                        '<span class="output-line">Reading file: flag.txt</span>\n' +
                        '<span class="output-line flag-line">Congratulations, you chained a command successfully!</span>\n' +
                        '<span class="output-line flag-line">CBX{command_injected}</span>' +
                        '</div>';
                    flagReveal.classList.add('visible');
                    statusArea.textContent = 'Chained command executed. Flag retrieved above.';
                } else if (/whoami/.test(cmd)) {
                    html += '<div class="unexpected-block">' +
                        '<span class="label">Unexpected output (chained command executed):</span>' +
                        '<span class="output-line">webserver-admin</span>' +
                        '</div>';
                    whoamiRevealed = true;
                    statusArea.textContent = 'Interesting. The second command ran. What else might a file on this server contain?';
                } else {
                    html += '<div class="unexpected-block">' +
                        '<span class="label">Unexpected output (chained command executed):</span>' +
                        '<span class="output-line">Command not recognized in this environment.</span>' +
                        '</div>';
                    statusArea.textContent = 'The chaining worked, but that command produced nothing useful.';
                }
            } else {
                statusArea.textContent = 'Check complete.';
            }

            outputPanel.innerHTML = html;
        }, 500);
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    pingButton.addEventListener('click', runCheck);
    hostnameInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            runCheck();
        }
    });

    // ========== SPOTLIGHT TUTORIAL ==========
    var tutorialSteps = [
        {
            targetElementId: 'hostname-input',
            tooltipText: 'This is where you would normally enter a hostname or IP to test connectivity, just like the ping command in a terminal.'
        },
        {
            targetElementId: 'ping-button',
            tooltipText: 'Click here to run the diagnostic. Behind the scenes, this tool builds a shell command using exactly what you typed.'
        },
        {
            targetElementId: 'output-panel',
            tooltipText: 'Results appear here, styled like real terminal output, showing you what the server actually executed.'
        },
        {
            targetElementId: 'hint-panel',
            tooltipText: 'Stuck? This panel gives you a nudge about what kind of input this tool might not be filtering.'
        }
    ];

    var currentStep = 0;
    var spotlight = document.getElementById('spotlight');
    var tooltipCard = document.getElementById('tooltip-card');
    var viewTutorialBtn = document.getElementById('view-tutorial-btn');
    var completeModal = document.getElementById('complete-modal');
    var startChallengeBtn = document.getElementById('start-challenge-btn');

    function positionSpotlight(el) {
        var rect = el.getBoundingClientRect();
        var padding = 8;
        spotlight.style.top = (rect.top - padding) + 'px';
        spotlight.style.left = (rect.left - padding) + 'px';
        spotlight.style.width = (rect.width + padding * 2) + 'px';
        spotlight.style.height = (rect.height + padding * 2) + 'px';
        spotlight.style.display = 'block';
    }

    function positionTooltip(el) {
        var rect = el.getBoundingClientRect();
        var tooltipWidth = 280;
        var top, left;

        if (rect.bottom + 200 < window.innerHeight) {
            top = rect.bottom + 16;
        } else {
            top = rect.top - 180;
        }

        left = rect.left;
        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (left < 20) { left = 20; }

        tooltipCard.style.top = top + 'px';
        tooltipCard.style.left = left + 'px';
        tooltipCard.style.display = 'block';
    }

    function renderStep() {
        var step = tutorialSteps[currentStep];
        var el = document.getElementById(step.targetElementId);
        if (!el) { return; }

        el.scrollIntoView({ behavior: 'smooth', block: 'center' });

        setTimeout(function() {
            positionSpotlight(el);
            positionTooltip(el);

            var isLast = currentStep === tutorialSteps.length - 1;
            tooltipCard.innerHTML =
                '<p>' + step.tooltipText + '</p>' +
                '<div class="tooltip-actions">' +
                '<button id="skip-tutorial-btn">Skip Tutorial</button>' +
                '<button class="tooltip-next" id="next-step-btn">' + (isLast ? 'Finish' : 'Next') + '</button>' +
                '</div>';

            document.getElementById('skip-tutorial-btn').addEventListener('click', endTutorial);
            document.getElementById('next-step-btn').addEventListener('click', function() {
                if (isLast) {
                    endTutorial(true);
                } else {
                    currentStep++;
                    renderStep();
                }
            });
        }, 300);
    }

    function startTutorial() {
        currentStep = 0;
        renderStep();
    }

    function endTutorial(showComplete) {
        spotlight.style.display = 'none';
        tooltipCard.style.display = 'none';
        if (showComplete) {
            completeModal.classList.add('visible');
        }
    }

    window.addEventListener('resize', function() {
        if (spotlight.style.display === 'block') {
            var step = tutorialSteps[currentStep];
            var el = document.getElementById(step.targetElementId);
            if (el) {
                positionSpotlight(el);
                positionTooltip(el);
            }
        }
    });

    viewTutorialBtn.addEventListener('click', startTutorial);
    startChallengeBtn.addEventListener('click', function() {
        completeModal.classList.remove('visible');
    });

    window.addEventListener('load', function() {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>