<?php
// ============================================================
// service-version-detection-practical.php
// Nmap Version Scan Simulator — standalone static practical
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nmap Version Scan Simulator</title>
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
    min-height: 100vh;
    padding: 24px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
}

header.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}

header.top-header h1 {
    font-size: 1.7rem;
    margin: 0 0 6px 0;
}

header.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
    max-width: 600px;
}

#tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    background: rgba(106,227,255,0.08);
    box-shadow: var(--glow-accent);
}

.panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 20px;
}

.panel h2 {
    font-size: 1.05rem;
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}

.panel p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0 0 8px 0;
    font-size: 0.92rem;
}

#target-info {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    color: var(--text-primary);
    margin-top: 10px;
}
#target-info span.label {
    color: var(--text-muted);
    margin-right: 6px;
}

#run-scan-btn {
    margin-top: 16px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 12px 26px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
}
#run-scan-btn:hover:not(:disabled) {
    box-shadow: var(--glow-accent);
    transform: translateY(-1px);
}
#run-scan-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

#terminal-output {
    background: #05070d;
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 16px;
    margin-top: 16px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    line-height: 1.7;
    min-height: 60px;
    white-space: pre-wrap;
    color: #6ae37f;
}

#scan-results {
    margin-top: 16px;
    display: none;
}

.result-row {
    display: grid;
    grid-template-columns: 90px 70px 130px 1fr;
    gap: 10px;
    align-items: center;
    padding: 12px 14px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    transition: all 0.2s ease;
}
.result-row:hover {
    border-color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}
.result-row .port { color: var(--accent-secondary); }
.result-row .state { color: var(--success); }
.result-row .service { color: var(--text-primary); }
.result-row .version { color: var(--text-secondary); }

.result-row.correct-flash {
    border-color: var(--success);
    box-shadow: 0 0 14px rgba(61,255,154,0.35);
}
.result-row.incorrect-flash {
    border-color: var(--error);
}

#feedback-area {
    margin-top: 14px;
    min-height: 24px;
    font-size: 0.88rem;
}
#feedback-area.feedback-error { color: var(--error); }
#feedback-area.feedback-hint { color: var(--warning); }

#flag-reveal {
    display: none;
    margin-top: 10px;
}
#flag-reveal.visible { display: block; }

.flag-box {
    background: #05070d;
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 16px 20px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.05rem;
    color: var(--success);
    text-align: center;
    margin-top: 12px;
    box-shadow: 0 0 18px rgba(61,255,154,0.25);
}

/* Spotlight tutorial */
#spotlight-overlay {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 9998;
    display: none;
}

#tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 9999;
    display: none;
    box-shadow: var(--glow-accent);
}
#tutorial-tooltip p {
    color: var(--text-primary);
    font-size: 0.88rem;
    line-height: 1.5;
    margin: 0 0 12px 0;
}
.tooltip-buttons {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}
.tooltip-buttons button {
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: transparent;
    color: var(--text-secondary);
}
.tooltip-buttons button.primary {
    background: var(--accent-primary);
    color: #05070d;
    border-color: var(--accent-primary);
}

#tutorial-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
#tutorial-modal {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
#tutorial-modal h3 {
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}
#tutorial-modal p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 18px 0;
}
#tutorial-modal button {
    background: var(--accent-primary);
    color: #05070d;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 600px) {
    .result-row {
        grid-template-columns: 1fr;
        gap: 4px;
    }
    header.top-header {
        flex-direction: column;
    }
}
</style>
</head>
<body>

<div class="container">
    <header class="top-header">
        <div>
            <h1>Nmap Version Scan Simulator</h1>
            <p class="subtitle">Run a simulated version detection scan against a target host and identify the one service running a version with a known, documented vulnerability.</p>
        </div>
        <button id="tutorial-btn">View Tutorial</button>
    </header>

    <div class="panel">
        <h2>Mission Briefing</h2>
        <p>This environment simulates the output of an <code>nmap -sV</code> scan. Your job is to launch the scan, read the results carefully, and click on the service you believe carries the highest risk. The flag will appear once you identify it correctly.</p>
        <div id="target-info">
            <div><span class="label">Target:</span>192.168.14.22</div>
            <div><span class="label">Scan Type:</span>Version Detection (-sV)</div>
        </div>
    </div>

    <div class="panel">
        <h2>Scan Console</h2>
        <button id="run-scan-btn">Run Scan</button>
        <div id="terminal-output"></div>

        <div id="scan-results">
            <div class="result-row" data-port="21" data-correct="true">
                <span class="port">21/tcp</span>
                <span class="state">open</span>
                <span class="service">ftp</span>
                <span class="version">vsftpd 2.3.4</span>
            </div>
            <div class="result-row" data-port="22" data-correct="false">
                <span class="port">22/tcp</span>
                <span class="state">open</span>
                <span class="service">ssh</span>
                <span class="version">OpenSSH 8.9p1 Ubuntu</span>
            </div>
            <div class="result-row" data-port="80" data-correct="false">
                <span class="port">80/tcp</span>
                <span class="state">open</span>
                <span class="service">http</span>
                <span class="version">Apache httpd 2.4.49 (Unix)</span>
            </div>
            <div class="result-row" data-port="445" data-correct="false">
                <span class="port">445/tcp</span>
                <span class="state">open</span>
                <span class="service">netbios-ssn</span>
                <span class="version">Samba smbd 3.0.20-Debian</span>
            </div>
            <div class="result-row" data-port="3306" data-correct="false">
                <span class="port">3306/tcp</span>
                <span class="state">open</span>
                <span class="service">mysql</span>
                <span class="version">MySQL 5.5.9-log</span>
            </div>
            <div class="result-row" data-port="8080" data-correct="false">
                <span class="port">8080/tcp</span>
                <span class="state">open</span>
                <span class="service">http-proxy</span>
                <span class="version">Jenkins 2.46.1</span>
            </div>
        </div>

        <div id="feedback-area"></div>
    </div>

    <div class="panel" id="flag-reveal">
        <h2>Vulnerability Confirmed</h2>
        <p>The FTP service is running <strong>vsftpd 2.3.4</strong>, a version with a well documented backdoor vulnerability tracked as CVE-2011-2523. This is exactly why version detection matters: the port and service name alone would never have revealed this risk.</p>
        <div class="flag-box" id="flag-text">CBX{backdoor_identified}</div>
    </div>
</div>

<div id="spotlight-overlay"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-buttons">
        <button id="tooltip-skip">Skip Tutorial</button>
        <button id="tooltip-next" class="primary">Next</button>
    </div>
</div>

<div id="tutorial-modal-overlay">
    <div id="tutorial-modal">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Run the scan and find the vulnerable service.</p>
        <button id="tutorial-modal-close">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    const scanLines = [
"Starting Nmap 7.94 ( https://nmap.org )",
"Nmap scan report for 192.168.14.22",
"Host is up (0.0023s latency).",
"",
"PORT     STATE SERVICE     VERSION",
"21/tcp   open  ftp         vsftpd 2.3.4",
"22/tcp   open  ssh         OpenSSH 8.9p1 Ubuntu",
"80/tcp   open  http        Apache httpd 2.4.49 ((Unix))",
"445/tcp  open  netbios-ssn Samba smbd 3.0.20-Debian",
"3306/tcp open  mysql       MySQL 5.5.9-log",
"8080/tcp open  http-proxy  Jenkins 2.46.1",
"",
"Service detection performed.",
"Nmap done: 1 IP address (1 host up) scanned in 11.34 seconds"
    ];

    const runBtn = document.getElementById('run-scan-btn');
    const terminal = document.getElementById('terminal-output');
    const resultsBox = document.getElementById('scan-results');
    const feedback = document.getElementById('feedback-area');
    const flagPanel = document.getElementById('flag-reveal');
    let scanComplete = false;
    let flagRevealed = false;

    runBtn.addEventListener('click', function() {
        if (runBtn.disabled) return;
        runBtn.disabled = true;
        terminal.textContent = '';
        resultsBox.style.display = 'none';
        feedback.textContent = '';
        feedback.className = '';
        flagPanel.classList.remove('visible');
        flagRevealed = false;
        scanComplete = false;

        let i = 0;
        function typeLine() {
            if (i < scanLines.length) {
                terminal.textContent += scanLines[i] + "\n";
                i++;
                setTimeout(typeLine, 220);
            } else {
                scanComplete = true;
                resultsBox.style.display = 'block';
                runBtn.disabled = false;
                feedback.textContent = 'Scan complete. Click the result row you believe is the highest risk.';
                feedback.className = '';
            }
        }
        typeLine();
    });

    document.querySelectorAll('.result-row').forEach(function(row) {
        row.addEventListener('click', function() {
            if (!scanComplete || flagRevealed) return;
            const correct = row.getAttribute('data-correct') === 'true';
            document.querySelectorAll('.result-row').forEach(r => r.classList.remove('correct-flash','incorrect-flash'));

            if (correct) {
                row.classList.add('correct-flash');
                feedback.textContent = 'Correct. This version carries a known, documented vulnerability.';
                feedback.className = '';
                flagPanel.classList.add('visible');
                flagRevealed = true;
                flagPanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                row.classList.add('incorrect-flash');
                feedback.textContent = 'This version is current or not associated with a well known vulnerability. Keep looking.';
                feedback.className = 'feedback-error';
            }
        });
    });

    // ================= TUTORIAL SYSTEM =================
    const steps = [
        { id: 'target-info', text: 'This is your target. In a real engagement, this would be a host discovered during your port scan.' },
        { id: 'run-scan-btn', text: 'Click here to launch a simulated nmap -sV scan. This sends probes to each open port to identify the exact service and version running.' },
        { id: 'terminal-output', text: 'Watch the scan results stream in, just like a real terminal. Each line shows a port, its state, the service, and the detected version.' },
        { id: 'scan-results', text: 'Once the scan finishes, click on any result row. You are looking for a version with a well known, documented vulnerability.' },
        { id: 'flag-reveal', text: 'When you identify the correct high risk service, your findings will appear here.' }
    ];
    let stepIndex = 0;

    const overlay = document.getElementById('spotlight-overlay');
    const tooltip = document.getElementById('tutorial-tooltip');
    const tooltipText = document.getElementById('tooltip-text');
    const tutorialBtn = document.getElementById('tutorial-btn');
    const modalOverlay = document.getElementById('tutorial-modal-overlay');
    const modalClose = document.getElementById('tutorial-modal-close');
    const nextBtn = document.getElementById('tooltip-next');
    const skipBtn = document.getElementById('tooltip-skip');

    function positionSpotlight(el) {
        const rect = el.getBoundingClientRect();
        const pad = 8;
        overlay.style.display = 'block';
        overlay.style.top = (rect.top - pad) + 'px';
        overlay.style.left = (rect.left - pad) + 'px';
        overlay.style.width = (rect.width + pad * 2) + 'px';
        overlay.style.height = (rect.height + pad * 2) + 'px';

        let top = rect.bottom + 14;
        let left = rect.left;
        if (top + 140 > window.innerHeight) {
            top = rect.top - 150;
        }
        if (left + 300 > window.innerWidth) {
            left = window.innerWidth - 320;
        }
        if (left < 10) left = 10;

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
        tooltip.style.display = 'block';
    }

    function showStep(index) {
        if (index >= steps.length) {
            endTutorial();
            return;
        }
        const step = steps[index];
        const el = document.getElementById(step.id);
        if (!el) { stepIndex++; showStep(stepIndex); return; }

        if (step.id === 'scan-results' && resultsBox.style.display === 'none') {
            resultsBox.style.display = 'block';
        }

        const rect = el.getBoundingClientRect();
        const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
        if (!isVisible) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(function() {
                tooltipText.textContent = step.text;
                positionSpotlight(el);
            }, 300);
        } else {
            tooltipText.textContent = step.text;
            positionSpotlight(el);
        }
        nextBtn.textContent = (index === steps.length - 1) ? 'Finish' : 'Next';
    }

    function startTutorial() {
        stepIndex = 0;
        showStep(stepIndex);
    }

    function endTutorial() {
        overlay.style.display = 'none';
        tooltip.style.display = 'none';
        modalOverlay.style.display = 'flex';
    }

    nextBtn.addEventListener('click', function() {
        stepIndex++;
        showStep(stepIndex);
    });

    skipBtn.addEventListener('click', function() {
        overlay.style.display = 'none';
        tooltip.style.display = 'none';
    });

    modalClose.addEventListener('click', function() {
        modalOverlay.style.display = 'none';
    });

    tutorialBtn.addEventListener('click', startTutorial);

    window.addEventListener('resize', function() {
        if (overlay.style.display === 'block' && stepIndex < steps.length) {
            const step = steps[stepIndex];
            const el = document.getElementById(step.id);
            if (el) positionSpotlight(el);
        }
    });

    window.addEventListener('load', function() {
        setTimeout(startTutorial, 500);
    });
})();
</script>

</body>
</html>
