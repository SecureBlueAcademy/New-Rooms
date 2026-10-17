<?php
// web-app-architecture-practical.php
// Standalone static practical: Request Inspector
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request Inspector</title>
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

* { box-sizing: border-box; }

body {
    margin: 0;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    padding: 24px;
}

.mono { font-family: "JetBrains Mono", monospace; }

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1100px;
    margin: 0 auto 20px auto;
}

.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.7rem;
}

.header p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 640px;
}

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    white-space: nowrap;
}

.tutorial-btn:hover { box-shadow: var(--glow-accent); }

.description-section {
    max-width: 1100px;
    margin: 0 auto 24px auto;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 22px;
}

.description-section h3 {
    margin-top: 0;
    color: var(--accent-primary);
    font-size: 1rem;
}

.description-section p {
    color: var(--text-secondary);
    margin: 6px 0;
    line-height: 1.5;
}

.main-env {
    max-width: 1100px;
    margin: 0 auto;
}

#scenario-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.scenario-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 12px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 500;
    flex: 1 1 150px;
    text-align: center;
    transition: border-color 0.2s ease;
}

.scenario-btn.active {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    box-shadow: var(--glow-accent);
}

.scenario-btn.viewed::after {
    content: " ✓";
    color: var(--success);
}

#progress-tracker {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.progress-pill {
    font-size: 0.8rem;
    color: var(--text-muted);
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    padding: 6px 12px;
    border-radius: 20px;
}

.progress-pill.done {
    color: var(--success);
    border-color: var(--success);
}

.panels {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 24px;
}

@media (max-width: 720px) {
    .panels { grid-template-columns: 1fr; }
}

.panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px;
    min-height: 220px;
}

.panel h4 {
    margin: 0 0 12px 0;
    color: var(--accent-secondary);
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.line {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
    padding: 6px 8px;
    border-radius: 4px;
    margin-bottom: 4px;
    cursor: pointer;
    color: var(--text-secondary);
    border: 1px solid transparent;
}

.line:hover {
    background: rgba(106,227,255,0.06);
    border-color: var(--border-default);
    color: var(--text-primary);
}

.status-line {
    font-weight: 600;
    color: var(--text-primary);
}

.popover {
    display: none;
    background: var(--bg-primary);
    border: 1px solid var(--accent-primary);
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 6px;
    font-family: "Inter", sans-serif;
}

.popover.open { display: block; }

.feedback-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 24px;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.flag-reveal-area {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 24px;
    text-align: center;
}

.flag-reveal-area.locked .flag-value { display: none; }
.flag-reveal-area.locked .lock-msg { display: block; }
.flag-reveal-area:not(.locked) .lock-msg { display: none; }

.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.3rem;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid var(--success);
    display: inline-block;
    padding: 12px 22px;
    border-radius: 8px;
    margin-top: 10px;
}

.lock-msg {
    color: var(--text-muted);
}

/* Spotlight tutorial */
#spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 998;
    display: none;
}

#tutorial-tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 999;
    display: none;
    box-shadow: var(--glow-accent);
}

#tutorial-tooltip p {
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin: 0 0 12px 0;
}

.tooltip-actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}

.tooltip-actions button {
    font-family: inherit;
    border-radius: 6px;
    padding: 8px 14px;
    cursor: pointer;
    font-size: 0.8rem;
    border: 1px solid var(--border-default);
}

#tt-next {
    background: var(--accent-primary);
    color: var(--bg-primary);
    font-weight: 600;
    border: none;
}

#tt-skip {
    background: transparent;
    color: var(--text-muted);
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    max-width: 360px;
}

.modal-box h3 {
    margin-top: 0;
    color: var(--accent-primary);
}

.modal-box p {
    color: var(--text-secondary);
}

.modal-box button {
    margin-top: 12px;
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}
</style>
</head>
<body>

<div class="top-bar">
    <div class="header">
        <h1>Request Inspector</h1>
        <p>A live traffic inspector showing both sides of an HTTP conversation. Step through five real scenarios and watch the exact request and response for each.</p>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</div>

<div class="description-section">
    <h3>What This Environment Represents</h3>
    <p>This panel simulates a browser and a web server sitting side by side. Every time you pick a scenario below, you will see the exact HTTP request the browser sends and the exact response the server sends back, including headers you would normally never see.</p>
    <p>Your goal is to trace all five scenarios. Click on any header line to see a plain language explanation of what it does. Once every scenario has been viewed, your flag will appear at the bottom of the page.</p>
</div>

<div class="main-env">
    <div id="scenario-selector">
        <button class="scenario-btn" data-scenario="0">Load Homepage (GET)</button>
        <button class="scenario-btn" data-scenario="1">Submit Login (POST)</button>
        <button class="scenario-btn" data-scenario="2">Return Visit (Cookie Sent)</button>
        <button class="scenario-btn" data-scenario="3">Broken Link (404)</button>
        <button class="scenario-btn" data-scenario="4">Expired Session</button>
    </div>

    <div id="progress-tracker">
        <span class="progress-pill" data-p="0">Load Homepage</span>
        <span class="progress-pill" data-p="1">Submit Login</span>
        <span class="progress-pill" data-p="2">Return Visit</span>
        <span class="progress-pill" data-p="3">Broken Link</span>
        <span class="progress-pill" data-p="4">Expired Session</span>
    </div>

    <div class="panels">
        <div class="panel" id="browser-panel">
            <h4>Browser Panel (Request)</h4>
            <div id="browser-content"></div>
        </div>
        <div class="panel" id="server-panel">
            <h4>Server Panel (Response)</h4>
            <div id="server-content"></div>
        </div>
    </div>

    <div class="feedback-area" id="feedback-area">
        Select a scenario above to begin tracing the HTTP conversation.
    </div>

    <div class="flag-reveal-area locked" id="flag-reveal-area">
        <p class="lock-msg">Trace all five scenarios to reveal your flag.</p>
        <div class="flag-value" id="flag-value">CBX{request_traced}</div>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 10px;">Full HTTP request/response cycle traced, including stateful cookie handling.</p>
    </div>
</div>

<div id="spotlight"></div>
<div id="tutorial-tooltip">
    <p id="tt-text"></p>
    <div class="tooltip-actions">
        <button id="tt-skip">Skip Tutorial</button>
        <button id="tt-next">Next</button>
    </div>
</div>

<div class="modal-overlay" id="complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const scenarios = [
    {
        request: [
            { line: 'GET /index.html HTTP/1.1', note: 'The browser asks for the homepage using the GET method, used any time you simply want to retrieve a page.' },
            { line: 'Host: example.com', note: 'Tells the server which website is being requested, since one server can host many domains.' },
            { line: 'User-Agent: Mozilla/5.0', note: 'Identifies the browser and operating system making the request.' }
        ],
        response: [
            { line: 'HTTP/1.1 200 OK', line2: 'status-line', note: 'The request succeeded and the page was found.' },
            { line: 'Content-Type: text/html', note: 'Tells the browser the response body is an HTML page so it knows how to render it.' }
        ],
        feedback: 'A plain page load. One request out, one response back, no state involved yet.'
    },
    {
        request: [
            { line: 'POST /login HTTP/1.1', note: 'POST is used when the browser is sending data to the server, here a username and password.' },
            { line: 'Host: example.com', note: 'Tells the server which website is being requested.' },
            { line: 'Content-Type: application/x-www-form-urlencoded', note: 'Tells the server the request body contains form field data.' }
        ],
        response: [
            { line: 'HTTP/1.1 200 OK', line2: 'status-line', note: 'The login was processed successfully.' },
            { line: 'Set-Cookie: session_id=8f2a91c3', note: 'The server issues a session cookie. The browser will now attach this to every future request automatically.' }
        ],
        feedback: 'Notice the Set-Cookie header. This is the moment the server starts remembering you.'
    },
    {
        request: [
            { line: 'GET /account HTTP/1.1', note: 'The browser requests a page that requires the user to be logged in.' },
            { line: 'Host: example.com', note: 'Tells the server which website is being requested.' },
            { line: 'Cookie: session_id=8f2a91c3', note: 'The browser automatically attaches the cookie it received earlier, no login form was needed this time.' }
        ],
        response: [
            { line: 'HTTP/1.1 200 OK', line2: 'status-line', note: 'The server recognized the session ID and returned the account page.' },
            { line: 'Content-Type: text/html', note: 'The response body is the rendered account page.' }
        ],
        feedback: 'This is why you stay logged in as you browse. The cookie does the work silently on every request.'
    },
    {
        request: [
            { line: 'GET /old-page.html HTTP/1.1', note: 'The browser requests a page that no longer exists at this address.' },
            { line: 'Host: example.com', note: 'Tells the server which website is being requested.' }
        ],
        response: [
            { line: 'HTTP/1.1 404 Not Found', line2: 'status-line', note: 'The server could not find anything matching the requested path.' },
            { line: 'Content-Type: text/html', note: 'The response body is a human readable error page.' }
        ],
        feedback: 'A broken link produces a 404. The request cycle still completes, it simply reports failure.'
    },
    {
        request: [
            { line: 'GET /account HTTP/1.1', note: 'The browser requests the account page again, some time later.' },
            { line: 'Cookie: session_id=8f2a91c3', note: 'The old cookie is still attached, but the server no longer honors it.' }
        ],
        response: [
            { line: 'HTTP/1.1 401 Unauthorized', line2: 'status-line', note: 'The server has expired this session ID and no longer trusts it.' },
            { line: 'Location: /login', note: 'The server redirects the browser back to the login page.' }
        ],
        feedback: 'Sessions do not last forever. Once expired, the same cookie is no longer enough.'
    }
];

const viewed = new Set();

function renderScenario(i) {
    document.querySelectorAll('.scenario-btn').forEach(b => b.classList.remove('active'));
    document.querySelector(`.scenario-btn[data-scenario="${i}"]`).classList.add('active');

    const s = scenarios[i];
    const bc = document.getElementById('browser-content');
    const sc = document.getElementById('server-content');
    bc.innerHTML = '';
    sc.innerHTML = '';

    s.request.forEach((item, idx) => {
        bc.appendChild(makeLine(item, `b${i}-${idx}`));
    });
    s.response.forEach((item, idx) => {
        sc.appendChild(makeLine(item, `s${i}-${idx}`, item.line2 === 'status-line'));
    });

    document.getElementById('feedback-area').textContent = s.feedback;

    viewed.add(i);
    document.querySelector(`.scenario-btn[data-scenario="${i}"]`).classList.add('viewed');
    document.querySelector(`.progress-pill[data-p="${i}"]`).classList.add('done');

    checkComplete();
}

function makeLine(item, id, isStatus) {
    const wrap = document.createElement('div');
    const line = document.createElement('div');
    line.className = 'line' + (isStatus ? ' status-line' : '');
    line.textContent = item.line;
    line.addEventListener('click', () => {
        pop.classList.toggle('open');
    });
    const pop = document.createElement('div');
    pop.className = 'popover';
    pop.textContent = item.note;
    wrap.appendChild(line);
    wrap.appendChild(pop);
    return wrap;
}

function checkComplete() {
    if (viewed.size === scenarios.length) {
        document.getElementById('flag-reveal-area').classList.remove('locked');
    }
}

document.querySelectorAll('.scenario-btn').forEach(btn => {
    btn.addEventListener('click', () => renderScenario(parseInt(btn.dataset.scenario)));
});

/* ===================== Tutorial System ===================== */
const tutorialSteps = [
    { id: 'scenario-selector', text: 'These buttons represent different actions a browser might take. Click through them one at a time to see exactly what gets sent and returned, just like clicking around a real website.' },
    { id: 'browser-panel', text: 'This is the Browser panel. It shows the real HTTP request being built, the same kind your browser sends every time you visit a page.' },
    { id: 'server-panel', text: 'This is the Server panel. It shows the response coming back, including the status code and any headers the server includes.' },
    { id: 'progress-tracker', text: 'Each scenario you view gets checked off here. View all five to unlock your result.' },
    { id: 'flag-reveal-area', text: 'Once every scenario has been traced, your flag appears right here.' }
];

let tutorialIndex = 0;
const spotlight = document.getElementById('spotlight');
const tooltip = document.getElementById('tutorial-tooltip');
const ttText = document.getElementById('tt-text');

function positionTutorial() {
    const step = tutorialSteps[tutorialIndex];
    const el = document.getElementById(step.id);
    if (!el) return;

    const rect = el.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
    if (!isVisible) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => placeSpotlight(el), 300);
    } else {
        placeSpotlight(el);
    }
}

function placeSpotlight(el) {
    const rect = el.getBoundingClientRect();
    const pad = 8;
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    ttText.textContent = tutorialSteps[tutorialIndex].text;
    tooltip.style.display = 'block';

    let top = rect.bottom + 14;
    let left = rect.left;
    if (top + 140 > window.innerHeight) top = rect.top - 154;
    if (left + 300 > window.innerWidth) left = window.innerWidth - 320;
    if (left < 10) left = 10;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

function startTutorial() {
    tutorialIndex = 0;
    positionTutorial();
}

function endTutorial() {
    spotlight.style.display = 'none';
    tooltip.style.display = 'none';
    document.getElementById('complete-modal').style.display = 'flex';
}

document.getElementById('tt-next').addEventListener('click', () => {
    tutorialIndex++;
    if (tutorialIndex >= tutorialSteps.length) {
        endTutorial();
    } else {
        positionTutorial();
    }
});

document.getElementById('tt-skip').addEventListener('click', () => {
    spotlight.style.display = 'none';
    tooltip.style.display = 'none';
});

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('complete-modal').style.display = 'none';
});

document.getElementById('view-tutorial-btn').addEventListener('click', startTutorial);

window.addEventListener('resize', () => {
    if (tooltip.style.display === 'block') positionTutorial();
});

window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>

</body>
</html>
