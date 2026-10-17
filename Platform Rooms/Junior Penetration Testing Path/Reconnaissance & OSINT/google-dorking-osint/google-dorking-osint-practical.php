<?php
// google-dorking-osint-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dork Console | Solvex Industries Search Exposure Audit</title>
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
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.6;
    min-height: 100vh;
    padding-bottom: 60px;
}

.mono { font-family: 'JetBrains Mono', monospace; }

/* ===== HEADER ===== */
.top-header {
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
    padding: 24px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.top-header h1 {
    font-size: 1.5rem;
    color: var(--accent-primary);
}
.top-header .subtitle {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-top: 4px;
}
.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* ===== CONTAINER ===== */
.container { max-width: 1000px; margin: 0 auto; padding: 28px 24px; }

/* ===== DESCRIPTION ===== */
.description-section {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 26px;
    margin-bottom: 28px;
}
.description-section h2 {
    font-size: 1.1rem;
    color: var(--text-primary);
    margin-bottom: 10px;
}
.description-section p { color: var(--text-secondary); font-size: 0.92rem; margin-bottom: 8px; }
.description-section p:last-child { margin-bottom: 0; }

/* ===== MAIN ENVIRONMENT ===== */
.environment {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 26px;
    margin-bottom: 24px;
}

#operator-reference {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 22px;
}
#operator-reference h3 { font-size: 0.95rem; color: var(--accent-secondary); margin-bottom: 10px; }
.op-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
.op-item {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.82rem;
    color: var(--text-secondary);
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 6px;
    padding: 8px 10px;
}
.op-item span { color: var(--accent-primary); font-weight: 700; }

.search-row {
    display: flex;
    gap: 10px;
    margin-bottom: 6px;
}
#search-bar {
    flex: 1;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px 16px;
    color: var(--text-primary);
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.95rem;
}
#search-bar:focus { outline: none; border-color: var(--accent-primary); box-shadow: var(--glow-accent); }
#search-button {
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
    color: var(--bg-primary);
    border: none;
    border-radius: 8px;
    padding: 0 26px;
    font-weight: 700;
    cursor: pointer;
    font-size: 0.9rem;
    transition: opacity 0.2s ease;
}
#search-button:hover { opacity: 0.88; }

.search-hint { color: var(--text-muted); font-size: 0.78rem; margin-bottom: 20px; }

#results-panel {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 10px;
    padding: 18px 20px;
    min-height: 90px;
}
.result-item {
    border-bottom: 1px solid var(--border-default);
    padding: 12px 0;
}
.result-item:last-child { border-bottom: none; }
.result-title { color: var(--accent-primary); font-size: 0.95rem; font-weight: 600; margin-bottom: 4px; }
.result-url { color: var(--success); font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; margin-bottom: 6px; }
.result-snippet { color: var(--text-secondary); font-size: 0.85rem; }
.no-results { color: var(--text-muted); font-size: 0.88rem; font-style: italic; }

/* ===== ASSET TRACKER (feedback / status area) ===== */
#asset-tracker {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 26px;
    margin-bottom: 24px;
}
#asset-tracker h3 { font-size: 0.95rem; color: var(--text-primary); margin-bottom: 12px; }
.tracker-count { color: var(--accent-primary); font-weight: 700; }
.asset-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
.asset-chip {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.82rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 8px;
}
.asset-chip.found { color: var(--success); border-color: var(--success); }
.asset-chip .dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--text-muted);
}
.asset-chip.found .dot { background: var(--success); }

#final-hint {
    display: none;
    margin-top: 16px;
    background: rgba(255, 211, 106, 0.08);
    border: 1px solid var(--warning);
    border-radius: 8px;
    padding: 14px 16px;
    color: var(--warning);
    font-size: 0.85rem;
}

/* ===== FLAG REVEAL ===== */
#flag-area {
    display: none;
    background: linear-gradient(135deg, rgba(61,255,154,0.08), rgba(106,227,255,0.06));
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 24px 26px;
    text-align: center;
}
#flag-area h3 { color: var(--success); margin-bottom: 12px; font-size: 1.1rem; }
#flag-value {
    display: inline-block;
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    color: var(--success);
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 10px 20px;
    letter-spacing: 0.03em;
}
#copy-flag-btn {
    display: block;
    margin: 14px auto 0 auto;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 8px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.8rem;
    font-weight: 600;
}

/* ===== SPOTLIGHT TUTORIAL ===== */
#spotlight-overlay {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    z-index: 9998;
    pointer-events: none;
    transition: all 0.25s ease;
    display: none;
}
#tutorial-tooltip {
    position: fixed;
    z-index: 9999;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 18px 20px;
    max-width: 300px;
    box-shadow: var(--glow-accent);
    display: none;
}
#tutorial-tooltip p { color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 14px; }
.tooltip-actions { display: flex; justify-content: space-between; gap: 10px; }
.tooltip-actions button {
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
}
#tutorial-next-btn { background: var(--accent-primary); color: var(--bg-primary); }
#tutorial-skip-btn { background: transparent; color: var(--text-muted); }

#tutorial-complete-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px 34px;
    text-align: center;
    max-width: 360px;
}
.modal-box h3 { color: var(--accent-primary); margin-bottom: 10px; }
.modal-box p { color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 18px; }
.modal-box button {
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
    color: var(--bg-primary);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}

@media (max-width: 600px) {
    .top-header { padding: 18px 20px; }
    .search-row { flex-direction: column; }
    #search-button { padding: 12px; }
}
</style>
</head>
<body>

<div class="top-header">
    <div>
        <h1>Dork Console</h1>
        <div class="subtitle">Solvex Industries Search Exposure Audit</div>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
</div>

<div class="container">

    <!-- DESCRIPTION SECTION -->
    <div class="description-section">
        <h2>Mission Briefing</h2>
        <p>This console simulates a real search engine. You have been asked to run a search exposure audit on Solvex Industries, a fictional company, to see what has been unintentionally left publicly indexed.</p>
        <p>Use search operators such as site:, filetype:, inurl:, and intitle: to construct valid dorks against solvex-industries.com. Every correctly formed dork that matches a real exposed asset will return a result. Find all four planted assets to unlock the final challenge.</p>
    </div>

    <!-- MAIN INTERACTIVE ENVIRONMENT -->
    <div class="environment">
        <div id="operator-reference">
            <h3>Operator Reference</h3>
            <div class="op-grid">
                <div class="op-item"><span>site:</span>domain.com</div>
                <div class="op-item"><span>filetype:</span>pdf</div>
                <div class="op-item"><span>inurl:</span>keyword</div>
                <div class="op-item"><span>intitle:</span>"exact phrase"</div>
            </div>
        </div>

        <div class="search-row">
            <input type="text" id="search-bar" class="mono" placeholder="site:solvex-industries.com filetype:pdf" autocomplete="off">
            <button id="search-button">Search</button>
        </div>
        <div class="search-hint">Target domain: solvex-industries.com</div>

        <div id="results-panel">
            <div class="no-results">Run a query to see results here.</div>
        </div>
    </div>

    <!-- FEEDBACK / STATUS AREA -->
    <div id="asset-tracker">
        <h3>Discovered Assets: <span class="tracker-count"><span id="found-count">0</span>/4</span></h3>
        <div class="asset-list">
            <div class="asset-chip" id="chip-1"><span class="dot"></span>Employee directory PDF</div>
            <div class="asset-chip" id="chip-2"><span class="dot"></span>Admin login portal</div>
            <div class="asset-chip" id="chip-3"><span class="dot"></span>Exposed backup directory</div>
            <div class="asset-chip" id="chip-4"><span class="dot"></span>HR salary spreadsheet</div>
        </div>
        <div id="final-hint">Rumor has it Solvex hides something behind a secured admin panel. Combine what you have learned into one final query.</div>
    </div>

    <!-- FLAG REVEAL AREA -->
    <div id="flag-area">
        <h3>Secure Admin Panel Located</h3>
        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 14px;">solvex-industries.com/secure/admin_panel.php</p>
        <div id="flag-value" class="mono">CBX{admin_exposed}</div>
        <button id="copy-flag-btn">Copy Flag</button>
    </div>

</div>

<div id="spotlight-overlay"></div>
<div id="tutorial-tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tutorial-skip-btn">Skip Tutorial</button>
        <button id="tutorial-next-btn">Next</button>
    </div>
</div>

<div id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Locate all four exposed assets, then chain everything you've learned into one final query.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    const TARGET = 'solvex-industries.com';

    const assets = [
        {
            key: 'chip-1',
            found: false,
            matches: q => q.includes('site:' + TARGET) && q.includes('filetype:pdf'),
            title: 'Solvex_Industries_Employee_Directory_2024.pdf',
            url: 'solvex-industries.com/files/Solvex_Industries_Employee_Directory_2024.pdf',
            snippet: 'Internal directory listing employee names, departments, and email addresses across all Solvex offices...'
        },
        {
            key: 'chip-2',
            found: false,
            matches: q => q.includes('site:' + TARGET) && q.includes('inurl:admin'),
            title: 'Admin Login Portal',
            url: 'solvex-industries.com/admin/login.php',
            snippet: 'Sign in to the Solvex Industries administrative dashboard. Authorized personnel only...'
        },
        {
            key: 'chip-3',
            found: false,
            matches: q => q.includes('intitle:"index of"') && q.includes('site:' + TARGET),
            title: 'Index of /backup/',
            url: 'solvex-industries.com/backup/',
            snippet: 'db_backup.sql, config.php.bak, site_export_2024.tar.gz'
        },
        {
            key: 'chip-4',
            found: false,
            matches: q => q.includes('site:' + TARGET) && q.includes('filetype:xlsx'),
            title: 'employee_salaries_2024.xlsx',
            url: 'solvex-industries.com/hr/employee_salaries_2024.xlsx',
            snippet: 'Confidential HR Records, salary bands, and compensation notes for all departments...'
        }
    ];

    const finalDork = {
        matches: q => q.includes('site:' + TARGET) && q.includes('intitle:"admin panel"') && q.includes('inurl:secure'),
        title: 'SECURE ADMIN PANEL',
        url: 'solvex-industries.com/secure/admin_panel.php',
        snippet: 'Restricted panel. Flag: CBX{admin_exposed}'
    };

    const searchBar = document.getElementById('search-bar');
    const searchButton = document.getElementById('search-button');
    const resultsPanel = document.getElementById('results-panel');
    const foundCountEl = document.getElementById('found-count');
    const finalHint = document.getElementById('final-hint');
    const flagArea = document.getElementById('flag-area');
    let allFound = false;
    let flagRevealed = false;

    function normalize(raw) {
        return raw.trim().toLowerCase().replace(/\s+/g, ' ');
    }

    function renderResult(title, url, snippet) {
        resultsPanel.innerHTML =
            '<div class="result-item">' +
                '<div class="result-title">' + title + '</div>' +
                '<div class="result-url">' + url + '</div>' +
                '<div class="result-snippet">' + snippet + '</div>' +
            '</div>';
    }

    function renderNoResults() {
        resultsPanel.innerHTML = '<div class="no-results">No indexed results match this query. Check your operator syntax.</div>';
    }

    function updateTracker() {
        const foundCount = assets.filter(a => a.found).length;
        foundCountEl.textContent = foundCount;
        assets.forEach(a => {
            const chip = document.getElementById(a.key);
            if (a.found) chip.classList.add('found');
        });
        if (foundCount === 4 && !allFound) {
            allFound = true;
            finalHint.style.display = 'block';
        }
    }

    function revealFlag() {
        if (flagRevealed) return;
        flagRevealed = true;
        renderResult(finalDork.title, finalDork.url, finalDork.snippet);
        flagArea.style.display = 'block';
        flagArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function runSearch() {
        const raw = searchBar.value;
        if (!raw.trim()) return;
        const q = normalize(raw);

        if (allFound) {
            if (finalDork.matches(q)) {
                revealFlag();
                return;
            }
        }

        for (const asset of assets) {
            if (asset.matches(q)) {
                asset.found = true;
                renderResult(asset.title, asset.url, asset.snippet);
                updateTracker();
                return;
            }
        }

        renderNoResults();
    }

    searchButton.addEventListener('click', runSearch);
    searchBar.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') runSearch();
    });

    document.getElementById('copy-flag-btn').addEventListener('click', function () {
        navigator.clipboard.writeText('CBX{admin_exposed}').then(function () {
            const btn = document.getElementById('copy-flag-btn');
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(function () { btn.textContent = original; }, 1500);
        });
    });

    // ===== SPOTLIGHT TUTORIAL SYSTEM =====
    const steps = [
        { targetId: 'search-bar', text: 'This is your search console. Type a dork here just like you would in a real search engine, using operators like site: and filetype:.' },
        { targetId: 'operator-reference', text: 'Not sure of the syntax? This reference panel lists every operator you will need for this challenge.' },
        { targetId: 'search-button', text: 'Press Search to run your query. A well formed dork against the right target will surface a result. A malformed or unrelated one will not.' },
        { targetId: 'results-panel', text: 'Results appear here, just like a real search engine results page. Read the snippets carefully, they often contain useful details.' },
        { targetId: 'asset-tracker', text: 'Every planted asset you uncover gets logged here. Find all of them to unlock the final challenge.' }
    ];

    let currentStep = 0;
    const overlay = document.getElementById('spotlight-overlay');
    const tooltip = document.getElementById('tutorial-tooltip');
    const tooltipText = document.getElementById('tooltip-text');
    const completeModal = document.getElementById('tutorial-complete-modal');

    function positionSpotlight(el) {
        const rect = el.getBoundingClientRect();
        const pad = 8;
        overlay.style.top = (rect.top - pad) + 'px';
        overlay.style.left = (rect.left - pad) + 'px';
        overlay.style.width = (rect.width + pad * 2) + 'px';
        overlay.style.height = (rect.height + pad * 2) + 'px';
        overlay.style.display = 'block';

        let top = rect.bottom + 14;
        let left = rect.left;
        const tooltipWidth = 300;

        if (left + tooltipWidth > window.innerWidth - 20) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (top + 140 > window.innerHeight) {
            top = rect.top - 150;
        }
        if (left < 10) left = 10;

        tooltip.style.top = top + 'px';
        tooltip.style.left = left + 'px';
        tooltip.style.display = 'block';
    }

    function showStep(index) {
        if (index >= steps.length) {
            endTutorial(true);
            return;
        }
        const step = steps[index];
        const el = document.getElementById(step.targetId);
        if (!el) { currentStep++; showStep(currentStep); return; }

        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(function () {
            tooltipText.textContent = step.text;
            positionSpotlight(el);
        }, 300);
    }

    function startTutorial() {
        currentStep = 0;
        showStep(currentStep);
    }

    function endTutorial(completed) {
        overlay.style.display = 'none';
        tooltip.style.display = 'none';
        if (completed) {
            completeModal.style.display = 'flex';
        }
    }

    document.getElementById('tutorial-next-btn').addEventListener('click', function () {
        currentStep++;
        showStep(currentStep);
    });

    document.getElementById('tutorial-skip-btn').addEventListener('click', function () {
        endTutorial(false);
    });

    document.getElementById('start-challenge-btn').addEventListener('click', function () {
        completeModal.style.display = 'none';
    });

    document.getElementById('view-tutorial-btn').addEventListener('click', function () {
        startTutorial();
    });

    window.addEventListener('resize', function () {
        if (overlay.style.display === 'block' && currentStep < steps.length) {
            const step = steps[currentStep];
            const el = document.getElementById(step.targetId);
            if (el) positionSpotlight(el);
        }
    });

    // Auto start tutorial on first load
    window.addEventListener('load', function () {
        setTimeout(startTutorial, 500);
    });
})();
</script>

</body>
</html>
