<?php
// introduction-to-scanning-practical.php
// Standalone practical: Live Scan Console
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Live Scan Console</title>
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
        line-height: 1.6;
    }

    .page-wrap {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 20px 80px 20px;
    }

    /* HEADER */
    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 20px;
    }
    .header-bar h1 {
        margin: 0 0 6px 0;
        font-size: 1.8rem;
        color: var(--accent-primary);
    }
    .header-bar .subtitle {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }
    .tutorial-btn {
        flex-shrink: 0;
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
    }
    .tutorial-btn:hover { background: rgba(106,227,255,0.1); }

    /* DESCRIPTION */
    .briefing {
        background: var(--bg-secondary);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 20px 22px;
        margin-bottom: 24px;
    }
    .briefing h2 {
        margin-top: 0;
        font-size: 1.1rem;
        color: var(--text-primary);
    }
    .briefing p { color: var(--text-secondary); margin: 8px 0; font-size: 0.95rem; }

    /* TARGET DISPLAY */
    #target-display {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        font-family: 'JetBrains Mono', monospace;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    #target-display .label { color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    #target-display .value { color: var(--accent-primary); font-size: 1.05rem; font-weight: 600; }

    /* COMMAND REFERENCE */
    #command-reference {
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 10px;
        padding: 18px 20px;
        margin-bottom: 20px;
    }
    #command-reference h3 {
        margin: 0 0 12px 0;
        font-size: 0.95rem;
        color: var(--text-primary);
    }
    #command-reference table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85rem;
    }
    #command-reference td {
        padding: 6px 8px;
        border-bottom: 1px solid var(--border-default);
        color: var(--text-secondary);
    }
    #command-reference td:first-child { color: var(--accent-secondary); white-space: nowrap; }

    /* CONSOLE */
    .console-wrap {
        background: #05070d;
        border: 1px solid var(--border-default);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: var(--glow-accent);
    }
    .console-titlebar {
        background: var(--bg-surface);
        padding: 8px 14px;
        font-size: 0.75rem;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-default);
        font-family: 'JetBrains Mono', monospace;
    }
    #console-output {
        height: 320px;
        overflow-y: auto;
        padding: 16px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85rem;
        color: var(--text-secondary);
        white-space: pre-wrap;
    }
    #console-output .line-open { color: var(--success); }
    #console-output .line-closed { color: var(--error); }
    #console-output .line-filtered { color: var(--warning); }
    #console-output .line-system { color: var(--accent-primary); }
    #console-output .line-prompt { color: var(--accent-secondary); font-weight: 600; }

    .console-input-row {
        display: flex;
        align-items: center;
        border-top: 1px solid var(--border-default);
        padding: 10px 14px;
        background: var(--bg-secondary);
    }
    .console-input-row .prompt-symbol {
        color: var(--accent-primary);
        font-family: 'JetBrains Mono', monospace;
        margin-right: 8px;
    }
    #console-input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        color: var(--text-primary);
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.9rem;
    }

    /* PROGRESS / STATUS */
    #progress-indicator {
        display: flex;
        gap: 14px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .progress-chip {
        flex: 1;
        min-width: 180px;
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    .progress-chip.done {
        border-color: var(--success);
        color: var(--success);
    }
    .progress-chip .chip-title {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--text-muted);
        margin-bottom: 4px;
    }
    .progress-chip.done .chip-title { color: var(--success); }

    /* FLAG PANEL */
    #flag-panel {
        display: none;
        background: linear-gradient(135deg, #0f2b1f, #123a26);
        border: 1px solid var(--success);
        border-radius: 10px;
        padding: 22px;
        text-align: center;
        box-shadow: 0 0 20px rgba(61,255,154,0.25);
    }
    #flag-panel.revealed { display: block; }
    #flag-panel h3 {
        margin: 0 0 10px 0;
        color: var(--success);
        font-size: 1rem;
    }
    #flag-panel .flag-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.2rem;
        color: var(--text-primary);
        background: rgba(0,0,0,0.3);
        padding: 10px 18px;
        border-radius: 8px;
        display: inline-block;
        letter-spacing: 0.02em;
    }

    /* SPOTLIGHT TUTORIAL */
    #spotlight-box {
        position: fixed;
        border-radius: 8px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
        transition: none;
        z-index: 9998;
        pointer-events: none;
    }
    #tutorial-tooltip {
        position: fixed;
        max-width: 300px;
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 10px;
        padding: 16px 18px;
        z-index: 9999;
        font-size: 0.88rem;
        color: var(--text-secondary);
        box-shadow: 0 0 20px rgba(106,227,255,0.3);
    }
    #tutorial-tooltip h4 {
        margin: 0 0 8px 0;
        color: var(--accent-primary);
        font-size: 0.95rem;
    }
    .tooltip-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 14px;
    }
    .tooltip-actions button {
        background: var(--accent-primary);
        color: #04121a;
        border: none;
        padding: 7px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
    }
    .tooltip-actions .skip-btn {
        background: transparent;
        color: var(--text-muted);
        text-decoration: underline;
        padding: 7px 0;
    }

    #tutorial-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }
    #tutorial-modal-overlay.active { display: flex; }
    .tutorial-modal {
        background: var(--bg-surface);
        border: 1px solid var(--accent-primary);
        border-radius: 12px;
        padding: 30px;
        max-width: 380px;
        text-align: center;
    }
    .tutorial-modal h3 { color: var(--accent-primary); margin-top: 0; }
    .tutorial-modal p { color: var(--text-secondary); font-size: 0.9rem; }
    .tutorial-modal button {
        margin-top: 14px;
        background: var(--accent-primary);
        color: #04121a;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .header-bar { flex-direction: column; }
        #target-display { flex-direction: column; align-items: flex-start; }
    }
</style>
</head>
<body>

<div class="page-wrap">

    <!-- 1. HEADER -->
    <div class="header-bar">
        <div>
            <h1>Live Scan Console</h1>
            <p class="subtitle">Investigate a target host using two TCP scan types and determine which one completes the handshake.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <!-- 2. DESCRIPTION -->
    <div class="briefing">
        <h2>Mission Briefing</h2>
        <p>This console simulates a real scanning session against a single target host. You will run a SYN scan and a Connect scan against the same set of ports and watch exactly what happens at the packet level.</p>
        <p>Your goal is to work out which of the two scan types actually completes the TCP three way handshake, then answer the console's final question to reveal your flag.</p>
    </div>

    <!-- TARGET -->
    <div id="target-display">
        <div>
            <span class="label">Target Host</span><br>
            <span class="value">scanme.cybrixen.lab</span>
        </div>
        <div>
            <span class="label">IP Address</span><br>
            <span class="value">10.10.44.7</span>
        </div>
    </div>

    <!-- COMMAND REFERENCE -->
    <div id="command-reference">
        <h3>Available Commands</h3>
        <table>
            <tr><td>scan -sS &lt;target&gt;</td><td>Run a SYN scan against the target</td></tr>
            <tr><td>scan -sT &lt;target&gt;</td><td>Run a Connect scan against the target</td></tr>
            <tr><td>results</td><td>Show a summary of the most recent scan</td></tr>
            <tr><td>compare</td><td>Compare both scans (available once both have run)</td></tr>
            <tr><td>clear</td><td>Clear the console output</td></tr>
            <tr><td>help</td><td>List all available commands</td></tr>
        </table>
    </div>

    <!-- 3. MAIN INTERACTIVE ENVIRONMENT -->
    <div class="console-wrap">
        <div class="console-titlebar">scanconsole@cybrixen:~</div>
        <div id="console-output"></div>
        <div class="console-input-row">
            <span class="prompt-symbol">&gt;</span>
            <input type="text" id="console-input" autocomplete="off" spellcheck="false" placeholder="Type a command and press Enter">
        </div>
    </div>

    <!-- 4. FEEDBACK / STATUS -->
    <div id="progress-indicator">
        <div class="progress-chip" id="chip-ss">
            <span class="chip-title">SYN Scan</span>
            <span class="chip-status">Not run yet</span>
        </div>
        <div class="progress-chip" id="chip-st">
            <span class="chip-title">Connect Scan</span>
            <span class="chip-status">Not run yet</span>
        </div>
    </div>

    <!-- 5. FLAG REVEAL -->
    <div id="flag-panel">
        <h3>Challenge Complete</h3>
        <div class="flag-value">CBX{handshake_avoided}</div>
    </div>

</div>

<!-- TUTORIAL ELEMENTS -->
<div id="spotlight-box" style="display:none;"></div>
<div id="tutorial-tooltip" style="display:none;"></div>
<div id="tutorial-modal-overlay">
    <div class="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Run both scan types against the target and answer the console's final question.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    "use strict";

    var ports = [
        { port: 22,   state: 'open' },
        { port: 80,   state: 'open' },
        { port: 443,  state: 'open' },
        { port: 3306, state: 'closed' },
        { port: 8080, state: 'filtered' }
    ];

    var hasRunSS = false;
    var hasRunST = false;
    var awaitingAnswer = false;
    var lastScanType = null;
    var lastScanSummary = { sS: null, sT: null };

    var outputEl = document.getElementById('console-output');
    var inputEl = document.getElementById('console-input');
    var chipSS = document.getElementById('chip-ss');
    var chipST = document.getElementById('chip-st');
    var flagPanel = document.getElementById('flag-panel');

    function printLine(text, cls) {
        var div = document.createElement('div');
        if (cls) div.className = cls;
        div.textContent = text;
        outputEl.appendChild(div);
        outputEl.scrollTop = outputEl.scrollHeight;
    }

    function printBlank() {
        var div = document.createElement('div');
        div.innerHTML = '&nbsp;';
        outputEl.appendChild(div);
    }

    function classForState(state) {
        if (state === 'open') return 'line-open';
        if (state === 'closed') return 'line-closed';
        return 'line-filtered';
    }

    function runScan(type) {
        var label = type === 'sS' ? 'SYN scan (-sS)' : 'Connect scan (-sT)';
        printLine('Starting ' + label + ' against 10.10.44.7 ...', 'line-system');
        printBlank();

        var openCount = 0, closedCount = 0, filteredCount = 0;

        ports.forEach(function(p) {
            var cls = classForState(p.state);
            var line;
            if (p.state === 'open') {
                openCount++;
                if (type === 'sS') {
                    line = 'Port ' + p.port + ': SYN sent -> SYN-ACK received -> RST sent (connection aborted) [OPEN]';
                } else {
                    line = 'Port ' + p.port + ': SYN sent -> SYN-ACK received -> ACK sent (connection established) -> FIN sent [OPEN]';
                }
            } else if (p.state === 'closed') {
                closedCount++;
                line = 'Port ' + p.port + ': SYN sent -> RST received [CLOSED]';
            } else {
                filteredCount++;
                line = 'Port ' + p.port + ': SYN sent -> no response (timed out) [FILTERED]';
            }
            printLine(line, cls);
        });

        printBlank();
        printLine('Scan complete. ' + openCount + ' open, ' + closedCount + ' closed, ' + filteredCount + ' filtered.', 'line-system');
        printBlank();

        var summary = { open: openCount, closed: closedCount, filtered: filteredCount, completedHandshake: type === 'sT' };

        if (type === 'sS') {
            hasRunSS = true;
            lastScanSummary.sS = summary;
            chipSS.classList.add('done');
            chipSS.querySelector('.chip-status').textContent = 'Complete';
        } else {
            hasRunST = true;
            lastScanSummary.sT = summary;
            chipST.classList.add('done');
            chipST.querySelector('.chip-status').textContent = 'Complete';
        }

        lastScanType = type;

        if (hasRunSS && hasRunST && !flagPanel.classList.contains('revealed')) {
            askCompletionQuestion();
        }
    }

    function askCompletionQuestion() {
        awaitingAnswer = true;
        printLine('Both scan types have been run.', 'line-system');
        printLine('Which scan type completes the full TCP handshake? Type sT or sS.', 'line-prompt');
        printBlank();
    }

    function printResults() {
        if (!lastScanType) {
            printLine('No scan has been run yet. Run scan -sS or scan -sT first.', 'line-filtered');
            return;
        }
        var s = lastScanType === 'sS' ? lastScanSummary.sS : lastScanSummary.sT;
        printLine('Last scan type: ' + lastScanType, 'line-system');
        printLine('Open: ' + s.open + '   Closed: ' + s.closed + '   Filtered: ' + s.filtered, 'line-system');
        printLine('Handshake completed: ' + (s.completedHandshake ? 'yes' : 'no'), 'line-system');
        printBlank();
    }

    function printCompare() {
        if (!hasRunSS || !hasRunST) {
            printLine('Run both scan -sS and scan -sT before comparing.', 'line-filtered');
            return;
        }
        printLine('SYN scan (-sS):     handshake completed = no   packets per open port = 3', 'line-system');
        printLine('Connect scan (-sT): handshake completed = yes  packets per open port = 4', 'line-system');
        printBlank();
        if (!flagPanel.classList.contains('revealed')) {
            askCompletionQuestion();
        }
    }

    function printHelp() {
        printLine('Commands:', 'line-system');
        printLine('  scan -sS <target>   Run a SYN scan');
        printLine('  scan -sT <target>   Run a Connect scan');
        printLine('  results             Show summary of last scan');
        printLine('  compare             Compare both scans');
        printLine('  clear               Clear the console');
        printLine('  help                Show this list');
        printBlank();
    }

    function revealFlag() {
        flagPanel.classList.add('revealed');
        flagPanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function handleCommand(raw) {
        var cmd = raw.trim();
        if (cmd.length === 0) return;

        printLine('> ' + cmd, 'line-prompt');

        if (awaitingAnswer) {
            var answer = cmd.toLowerCase().replace(/[^a-z]/g, '');
            if (answer === 'st') {
                printLine('Correct. The Connect scan completes the full handshake with a final ACK.', 'line-open');
                printBlank();
                awaitingAnswer = false;
                revealFlag();
            } else if (answer === 'ss') {
                printLine('Not quite. A SYN scan sends an RST instead of the final ACK. Try again: sT or sS?', 'line-filtered');
                printBlank();
            } else {
                printLine('Please answer with sT or sS.', 'line-filtered');
                printBlank();
            }
            return;
        }

        var lower = cmd.toLowerCase();

        if (lower === 'help') {
            printHelp();
        } else if (lower === 'clear') {
            outputEl.innerHTML = '';
        } else if (lower === 'results') {
            printResults();
        } else if (lower === 'compare') {
            printCompare();
        } else if (lower.indexOf('scan -ss') === 0) {
            if (lower.indexOf('10.10.44.7') === -1 && lower.indexOf('scanme.cybrixen.lab') === -1) {
                printLine('Unknown target. Try: scan -sS 10.10.44.7', 'line-filtered');
            } else {
                runScan('sS');
            }
        } else if (lower.indexOf('scan -st') === 0) {
            if (lower.indexOf('10.10.44.7') === -1 && lower.indexOf('scanme.cybrixen.lab') === -1) {
                printLine('Unknown target. Try: scan -sT 10.10.44.7', 'line-filtered');
            } else {
                runScan('sT');
            }
        } else {
            printLine('Unknown command. Type help for a list of commands.', 'line-filtered');
        }
        printBlank();
    }

    inputEl.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            var val = inputEl.value;
            inputEl.value = '';
            handleCommand(val);
        }
    });

    printLine('Welcome to the Live Scan Console.', 'line-system');
    printLine('Type help to see available commands.', 'line-system');
    printBlank();

    // ===================== SPOTLIGHT TUTORIAL =====================

    var tutorialSteps = [
        {
            targetId: 'target-display',
            text: 'This is your target for today. In a real engagement this would be the first thing you confirm before scanning: the exact host you are authorized to test.'
        },
        {
            targetId: 'command-reference',
            text: 'These are your available commands. Notice there are two scan types, -sS and -sT. You will run both against the same target and compare what happens.'
        },
        {
            targetId: 'console-input',
            text: 'Type your commands here, exactly like a real terminal. Start with scan -sS 10.10.44.7.'
        },
        {
            targetId: 'console-output',
            text: 'Watch this closely. Every line represents one packet being sent or received. This is the handshake happening in real time.'
        },
        {
            targetId: 'progress-indicator',
            text: 'This tracks which scan types you have completed. Once both are done, the console will ask you one final question before revealing your flag.'
        }
    ];

    var currentStep = 0;
    var spotlightBox = document.getElementById('spotlight-box');
    var tooltip = document.getElementById('tutorial-tooltip');
    var modalOverlay = document.getElementById('tutorial-modal-overlay');
    var tutorialActive = false;

    function positionSpotlight(el) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlightBox.style.top = (rect.top - pad) + 'px';
        spotlightBox.style.left = (rect.left - pad) + 'px';
        spotlightBox.style.width = (rect.width + pad * 2) + 'px';
        spotlightBox.style.height = (rect.height + pad * 2) + 'px';
    }

    function positionTooltip(el) {
        var rect = el.getBoundingClientRect();
        var tw = 300;
        tooltip.style.width = tw + 'px';

        var top = rect.bottom + 14;
        var left = rect.left;

        if (top + 160 > window.innerHeight) {
            top = rect.top - 170;
        }
        if (left + tw > window.innerWidth - 20) {
            left = window.innerWidth - tw - 20;
        }
        if (left < 20) left = 20;
        if (top < 10) top = 10;

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
    }

    function renderStep() {
        var step = tutorialSteps[currentStep];
        var el = document.getElementById(step.targetId);
        if (!el) { nextStep(); return; }

        var rect = el.getBoundingClientRect();
        var visible = rect.top >= 0 && rect.bottom <= window.innerHeight;

        function place() {
            positionSpotlight(el);
            positionTooltip(el);
        }

        if (!visible) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(place, 300);
        } else {
            place();
        }

        tooltip.innerHTML =
            '<h4>Step ' + (currentStep + 1) + ' of ' + tutorialSteps.length + '</h4>' +
            '<p style="margin:0;">' + step.text + '</p>' +
            '<div class="tooltip-actions">' +
            '<button class="skip-btn" id="skip-tutorial-btn">Skip Tutorial</button>' +
            '<button id="next-step-btn">' + (currentStep === tutorialSteps.length - 1 ? 'Finish' : 'Next') + '</button>' +
            '</div>';

        document.getElementById('next-step-btn').addEventListener('click', nextStep);
        document.getElementById('skip-tutorial-btn').addEventListener('click', endTutorial);
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
        tutorialActive = true;
        currentStep = 0;
        spotlightBox.style.display = 'block';
        tooltip.style.display = 'block';
        renderStep();
    }

    function endTutorial(completed) {
        tutorialActive = false;
        spotlightBox.style.display = 'none';
        tooltip.style.display = 'none';
        if (completed) {
            modalOverlay.classList.add('active');
        }
    }

    document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);
    document.getElementById('start-challenge-btn').addEventListener('click', function() {
        modalOverlay.classList.remove('active');
        inputEl.focus();
    });

    window.addEventListener('resize', function() {
        if (tutorialActive) {
            var step = tutorialSteps[currentStep];
            var el = document.getElementById(step.targetId);
            if (el) {
                positionSpotlight(el);
                positionTooltip(el);
            }
        }
    });

    window.addEventListener('load', function() {
        setTimeout(startTutorial, 400);
    });

})();
</script>

</body>
</html>
