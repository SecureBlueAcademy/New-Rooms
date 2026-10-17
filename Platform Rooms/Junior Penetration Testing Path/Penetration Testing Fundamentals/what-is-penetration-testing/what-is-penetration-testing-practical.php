<?php
// what-is-penetration-testing-practical.php
// CYBRIXEN Practical - Scope Analyser
// Room: What is Penetration Testing?
// Flag: CBX{scope_defined}
// PHP is used for structure only. All logic is vanilla JavaScript.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scope Analyser | CYBRIXEN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ========== ROOT PALETTE ========== */
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
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ========== HEADER ========== */
        .page-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-default);
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent-primary);
            letter-spacing: 0.02em;
        }

        .header-left .subtitle {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .tutorial-btn {
            background: transparent;
            border: 1px solid var(--accent-primary);
            color: var(--accent-primary);
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .tutorial-btn:hover {
            background: rgba(106,227,255,0.08);
            box-shadow: var(--glow-accent);
        }

        /* ========== MAIN LAYOUT ========== */
        .main-container {
            max-width: 960px;
            margin: 0 auto;
            padding: 32px 24px 80px;
        }

        /* ========== MISSION BRIEFING ========== */
        .mission-section {
            background: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-left: 3px solid var(--accent-primary);
            border-radius: 10px;
            padding: 24px 28px;
            margin-bottom: 28px;
        }

        .mission-section h2 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent-primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }

        .mission-section p {
            color: var(--text-secondary);
            font-size: 0.92rem;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .mission-section p:last-child { margin-bottom: 0; }

        /* ========== PROGRESS TRACKER ========== */
        .progress-bar-container {
            background: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-radius: 10px;
            padding: 16px 24px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .progress-label {
            font-size: 0.82rem;
            color: var(--text-muted);
            white-space: nowrap;
            font-weight: 600;
        }

        .progress-track {
            flex: 1;
            height: 8px;
            background: var(--border-default);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 4px;
            width: 0%;
            transition: width 0.5s ease;
        }

        .progress-pct {
            font-size: 0.82rem;
            color: var(--accent-primary);
            font-weight: 700;
            min-width: 36px;
            text-align: right;
        }

        /* ========== STAGE PANELS ========== */
        .stage {
            background: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-radius: 10px;
            margin-bottom: 24px;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .stage.active { border-color: rgba(106,227,255,0.3); }
        .stage.completed { border-color: rgba(61,255,154,0.3); }
        .stage.locked { opacity: 0.5; pointer-events: none; }

        .stage-header {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid var(--border-default);
        }

        .stage-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--bg-primary);
            border: 2px solid var(--border-default);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-muted);
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .stage.active .stage-number {
            border-color: var(--accent-primary);
            color: var(--accent-primary);
        }

        .stage.completed .stage-number {
            border-color: var(--success);
            color: var(--success);
            background: rgba(61,255,154,0.1);
        }

        .stage-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .stage-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .stage-badge {
            margin-left: auto;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .stage-badge.pending { background: rgba(124,131,182,0.15); color: var(--text-muted); }
        .stage-badge.active-badge { background: rgba(106,227,255,0.12); color: var(--accent-primary); }
        .stage-badge.done { background: rgba(61,255,154,0.12); color: var(--success); }

        .stage-body { padding: 24px; }

        /* ========== ENGAGEMENT PACKAGE ========== */
        .engagement-doc {
            background: var(--bg-primary);
            border: 1px solid var(--border-default);
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.82rem;
            line-height: 1.8;
            color: var(--text-secondary);
        }

        .engagement-doc .doc-heading {
            color: var(--accent-primary);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.88rem;
            letter-spacing: 0.05em;
        }

        .engagement-doc .doc-line {
            display: flex;
            gap: 12px;
            margin-bottom: 4px;
        }

        .engagement-doc .doc-key {
            color: var(--text-muted);
            min-width: 190px;
            flex-shrink: 0;
        }

        .engagement-doc .doc-val {
            color: var(--text-primary);
        }

        .engagement-doc .doc-divider {
            border: none;
            border-top: 1px solid var(--border-default);
            margin: 12px 0;
        }

        /* ========== QUIZ QUESTIONS ========== */
        .quiz-question {
            margin-bottom: 20px;
        }

        .quiz-question p {
            font-size: 0.92rem;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-weight: 500;
        }

        .quiz-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .quiz-option {
            background: var(--bg-primary);
            border: 1px solid var(--border-default);
            border-radius: 7px;
            padding: 11px 16px;
            cursor: pointer;
            font-size: 0.88rem;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: inherit;
            text-align: left;
            width: 100%;
        }

        .quiz-option:hover:not([disabled]) {
            border-color: rgba(106,227,255,0.3);
            color: var(--text-primary);
            background: rgba(106,227,255,0.04);
        }

        .quiz-option.correct {
            border-color: var(--success);
            background: rgba(61,255,154,0.07);
            color: var(--success);
        }

        .quiz-option.wrong {
            border-color: var(--error);
            background: rgba(255,92,92,0.07);
            color: var(--error);
        }

        .quiz-option .option-letter {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            background: var(--bg-surface);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .quiz-feedback {
            margin-top: 10px;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            display: none;
        }

        .quiz-feedback.correct-fb {
            background: rgba(61,255,154,0.08);
            border: 1px solid rgba(61,255,154,0.2);
            color: var(--success);
        }

        .quiz-feedback.wrong-fb {
            background: rgba(255,92,92,0.08);
            border: 1px solid rgba(255,92,92,0.2);
            color: var(--error);
        }

        /* ========== STAGE SUBMIT BUTTON ========== */
        .stage-submit-btn {
            background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
            border: 1px solid var(--accent-primary);
            border-radius: 8px;
            color: var(--accent-primary);
            padding: 12px 28px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .stage-submit-btn:hover:not([disabled]) {
            box-shadow: var(--glow-accent);
            transform: translateY(-1px);
        }

        .stage-submit-btn[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ========== STATUS / FEEDBACK AREA ========== */
        .status-area {
            background: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-radius: 10px;
            padding: 18px 24px;
            margin-bottom: 24px;
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-icon {
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .status-message {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* ========== FLAG REVEAL ========== */
        .flag-reveal {
            display: none;
            background: linear-gradient(135deg, rgba(61,255,154,0.05), rgba(106,227,255,0.05));
            border: 1px solid rgba(61,255,154,0.3);
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            margin-top: 8px;
        }

        .flag-reveal h2 {
            font-size: 1.1rem;
            color: var(--success);
            margin-bottom: 8px;
        }

        .flag-reveal p {
            color: var(--text-secondary);
            font-size: 0.88rem;
            margin-bottom: 20px;
        }

        .flag-value {
            display: inline-block;
            background: var(--bg-primary);
            border: 1px solid rgba(61,255,154,0.4);
            border-radius: 8px;
            padding: 14px 32px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--success);
            letter-spacing: 0.05em;
            box-shadow: 0 0 20px rgba(61,255,154,0.15);
        }

        /* ========== SPOTLIGHT TUTORIAL ========== */
        #spotlight-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9000;
            pointer-events: none;
        }

        #spotlight-overlay.active { display: block; }

        #spotlight-box {
            position: fixed;
            border-radius: 10px;
            pointer-events: none;
            box-shadow: 0 0 0 9999px rgba(0,0,0,0.78);
            z-index: 9001;
            transition: all 0.25s ease;
        }

        #tutorial-tooltip {
            position: fixed;
            z-index: 9002;
            background: var(--bg-surface);
            border: 1px solid var(--accent-primary);
            border-radius: 10px;
            padding: 18px 22px;
            max-width: 320px;
            pointer-events: all;
            box-shadow: var(--glow-accent);
        }

        #tutorial-tooltip h4 {
            font-size: 0.9rem;
            color: var(--accent-primary);
            margin-bottom: 8px;
            font-weight: 700;
        }

        #tutorial-tooltip p {
            font-size: 0.84rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .tooltip-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .tooltip-skip {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            cursor: pointer;
            font-family: inherit;
            padding: 4px 8px;
        }

        .tooltip-next {
            background: var(--accent-primary);
            color: var(--bg-primary);
            border: none;
            border-radius: 6px;
            padding: 7px 18px;
            font-size: 0.84rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
        }

        /* ========== TUTORIAL COMPLETE MODAL ========== */
        #modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 9500;
            align-items: center;
            justify-content: center;
        }

        #modal-overlay.active { display: flex; }

        .modal-card {
            background: var(--bg-surface);
            border: 1px solid var(--accent-primary);
            border-radius: 14px;
            padding: 36px 40px;
            max-width: 420px;
            text-align: center;
            box-shadow: var(--glow-accent);
        }

        .modal-card h2 {
            font-size: 1.1rem;
            color: var(--accent-primary);
            margin-bottom: 10px;
        }

        .modal-card p {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .modal-start-btn {
            background: var(--accent-primary);
            color: var(--bg-primary);
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
        }

        /* ========== UTILITY ========== */
        .check-icon { color: var(--success); }
        .hidden { display: none !important; }
    </style>
</head>
<body>

<!-- ====== HEADER ====== -->
<header class="page-header">
    <div class="header-left">
        <h1>Scope Analyser</h1>
        <div class="subtitle">Penetration Testing Engagement Review</div>
    </div>
    <button class="tutorial-btn" id="view-tutorial-btn" onclick="startTutorial()">View Tutorial</button>
</header>

<!-- ====== MAIN CONTENT ====== -->
<main class="main-container">

    <!-- MISSION BRIEFING -->
    <section class="mission-section" id="mission-section">
        <h2>Mission Briefing</h2>
        <p>You have just received a new client engagement package from the Meridian Bank Group. Before the pentest begins, your team lead wants you to review the scope and engagement documents, classify each item correctly, and confirm you understand the legal and methodological boundaries of this engagement.</p>
        <p>Work through all three stages below. Each stage tests a different aspect of what you have learned. Complete all three stages correctly to retrieve the engagement flag.</p>
    </section>

    <!-- PROGRESS -->
    <div class="progress-bar-container" id="progress-container">
        <span class="progress-label">PROGRESS</span>
        <div class="progress-track">
            <div class="progress-fill" id="progress-fill"></div>
        </div>
        <span class="progress-pct" id="progress-pct">0%</span>
    </div>

    <!-- STATUS AREA -->
    <div class="status-area" id="status-area">
        <span class="status-icon">💼</span>
        <span class="status-message" id="status-message">Review the engagement package and complete each stage to proceed.</span>
    </div>

    <!-- ====== STAGE 1: SCOPE CLASSIFICATION ====== -->
    <div class="stage active" id="stage1">
        <div class="stage-header">
            <div class="stage-number" id="s1-num">1</div>
            <div>
                <div class="stage-title">Stage 1: Scope Classification</div>
                <div class="stage-subtitle">Review the engagement package and classify each item</div>
            </div>
            <span class="stage-badge active-badge" id="s1-badge">Active</span>
        </div>
        <div class="stage-body" id="stage1-body">
            <div class="engagement-doc" id="engagement-doc">
                <div class="doc-heading">MERIDIAN BANK GROUP: PENTEST ENGAGEMENT PACKAGE</div>
                <hr class="doc-divider">
                <div class="doc-line"><span class="doc-key">Engagement Type:</span><span class="doc-val">Grey Box</span></div>
                <div class="doc-line"><span class="doc-key">Authorised By:</span><span class="doc-val">CTO, Meridian Bank Group</span></div>
                <div class="doc-line"><span class="doc-key">Testing Window:</span><span class="doc-val">Mon–Fri, 08:00–20:00 BST</span></div>
                <hr class="doc-divider">
                <div class="doc-heading">IN-SCOPE TARGETS</div>
                <div class="doc-line"><span class="doc-key">Web Application:</span><span class="doc-val">app.meridianbank.co.uk</span></div>
                <div class="doc-line"><span class="doc-key">API Endpoint:</span><span class="doc-val">api.meridianbank.co.uk</span></div>
                <div class="doc-line"><span class="doc-key">IP Range:</span><span class="doc-val">185.22.47.0/24</span></div>
                <hr class="doc-divider">
                <div class="doc-heading">EXPLICITLY OUT OF SCOPE</div>
                <div class="doc-line"><span class="doc-key">Domain:</span><span class="doc-val">partner.meridianbank.co.uk</span></div>
                <div class="doc-line"><span class="doc-key">System:</span><span class="doc-val">Legacy SWIFT infrastructure</span></div>
                <div class="doc-line"><span class="doc-key">Action:</span><span class="doc-val">Any denial-of-service testing</span></div>
                <hr class="doc-divider">
                <div class="doc-heading">PRIOR KNOWLEDGE PROVIDED</div>
                <div class="doc-line"><span class="doc-key">Credentials:</span><span class="doc-val">Standard user account: test_user / T3stP@ss!</span></div>
                <div class="doc-line"><span class="doc-key">Architecture:</span><span class="doc-val">Network topology diagram (attached)</span></div>
            </div>

            <!-- Quiz questions for Stage 1 -->
            <div class="quiz-question" id="q1-wrap">
                <p>Q1. During the test, you discover that 185.22.47.88 runs an unpatched service. Can you test it?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q1','A')" id="q1A" data-q="q1" data-v="A">
                        <span class="option-letter">A</span>Yes, it is within the authorised IP range.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q1','B')" id="q1B" data-q="q1" data-v="B">
                        <span class="option-letter">B</span>No, you need separate written authorisation for each IP.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q1','C')" id="q1C" data-q="q1" data-v="C">
                        <span class="option-letter">C</span>Only if the test would not cause downtime.
                    </button>
                </div>
                <div class="quiz-feedback" id="q1-feedback"></div>
            </div>

            <div class="quiz-question" id="q2-wrap">
                <p>Q2. While testing the API, you find a path that redirects to partner.meridianbank.co.uk. What do you do?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q2','A')" id="q2A" data-q="q2" data-v="A">
                        <span class="option-letter">A</span>Follow the redirect and test the partner domain too.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q2','B')" id="q2B" data-q="q2" data-v="B">
                        <span class="option-letter">B</span>Stop, document the redirect as a finding, and report it to the client without testing the out-of-scope domain.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q2','C')" id="q2C" data-q="q2" data-v="C">
                        <span class="option-letter">C</span>Test only the redirect mechanism, not the destination.
                    </button>
                </div>
                <div class="quiz-feedback" id="q2-feedback"></div>
            </div>

            <div class="quiz-question" id="q3-wrap">
                <p>Q3. The engagement package provides a user account and a network diagram. What engagement type is this?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q3','A')" id="q3A" data-q="q3" data-v="A">
                        <span class="option-letter">A</span>Black box
                    </button>
                    <button class="quiz-option" onclick="checkQ('q3','B')" id="q3B" data-q="q3" data-v="B">
                        <span class="option-letter">B</span>White box
                    </button>
                    <button class="quiz-option" onclick="checkQ('q3','C')" id="q3C" data-q="q3" data-v="C">
                        <span class="option-letter">C</span>Grey box
                    </button>
                </div>
                <div class="quiz-feedback" id="q3-feedback"></div>
            </div>

            <button class="stage-submit-btn" id="s1-submit" onclick="submitStage(1)" disabled>Complete Stage 1</button>
        </div>
    </div>

    <!-- ====== STAGE 2: PHASE IDENTIFICATION ====== -->
    <div class="stage locked" id="stage2">
        <div class="stage-header">
            <div class="stage-number" id="s2-num">2</div>
            <div>
                <div class="stage-title">Stage 2: Phase Identification</div>
                <div class="stage-subtitle">Match each tester activity to the correct pentest phase</div>
            </div>
            <span class="stage-badge pending" id="s2-badge">Locked</span>
        </div>
        <div class="stage-body" id="stage2-body">
            <div class="engagement-doc">
                <div class="doc-heading">MERIDIAN BANK GROUP: TESTER ACTIVITY LOG (DAY 1)</div>
                <hr class="doc-divider">
                <div class="doc-line"><span class="doc-key">08:14</span><span class="doc-val">Queried WHOIS records and DNS entries for meridianbank.co.uk</span></div>
                <div class="doc-line"><span class="doc-key">09:02</span><span class="doc-val">Ran Nmap port scan across 185.22.47.0/24, identified 14 open services</span></div>
                <div class="doc-line"><span class="doc-key">10:45</span><span class="doc-val">Exploited SQL injection in the login form, gained database read access</span></div>
                <div class="doc-line"><span class="doc-key">12:30</span><span class="doc-val">Used DB access to pivot to internal admin panel at 185.22.47.51</span></div>
                <div class="doc-line"><span class="doc-key">16:00</span><span class="doc-val">Compiled findings with screenshots, CVSS scores, and remediation steps</span></div>
            </div>

            <div class="quiz-question" id="q4-wrap">
                <p>Q4. The 08:14 activity (WHOIS and DNS queries) belongs to which pentest phase?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q4','A')" id="q4A" data-q="q4" data-v="A">
                        <span class="option-letter">A</span>Scanning
                    </button>
                    <button class="quiz-option" onclick="checkQ('q4','B')" id="q4B" data-q="q4" data-v="B">
                        <span class="option-letter">B</span>Reconnaissance
                    </button>
                    <button class="quiz-option" onclick="checkQ('q4','C')" id="q4C" data-q="q4" data-v="C">
                        <span class="option-letter">C</span>Exploitation
                    </button>
                </div>
                <div class="quiz-feedback" id="q4-feedback"></div>
            </div>

            <div class="quiz-question" id="q5-wrap">
                <p>Q5. The 10:45 activity (SQL injection exploitation) belongs to which phase?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q5','A')" id="q5A" data-q="q5" data-v="A">
                        <span class="option-letter">A</span>Scanning
                    </button>
                    <button class="quiz-option" onclick="checkQ('q5','B')" id="q5B" data-q="q5" data-v="B">
                        <span class="option-letter">B</span>Post-Exploitation
                    </button>
                    <button class="quiz-option" onclick="checkQ('q5','C')" id="q5C" data-q="q5" data-v="C">
                        <span class="option-letter">C</span>Exploitation
                    </button>
                </div>
                <div class="quiz-feedback" id="q5-feedback"></div>
            </div>

            <div class="quiz-question" id="q6-wrap">
                <p>Q6. The 12:30 activity (pivoting from DB to admin panel) belongs to which phase?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q6','A')" id="q6A" data-q="q6" data-v="A">
                        <span class="option-letter">A</span>Post-Exploitation
                    </button>
                    <button class="quiz-option" onclick="checkQ('q6','B')" id="q6B" data-q="q6" data-v="B">
                        <span class="option-letter">B</span>Exploitation
                    </button>
                    <button class="quiz-option" onclick="checkQ('q6','C')" id="q6C" data-q="q6" data-v="C">
                        <span class="option-letter">C</span>Scanning
                    </button>
                </div>
                <div class="quiz-feedback" id="q6-feedback"></div>
            </div>

            <button class="stage-submit-btn" id="s2-submit" onclick="submitStage(2)" disabled>Complete Stage 2</button>
        </div>
    </div>

    <!-- ====== STAGE 3: ATTACKER MINDSET ====== -->
    <div class="stage locked" id="stage3">
        <div class="stage-header">
            <div class="stage-number" id="s3-num">3</div>
            <div>
                <div class="stage-title">Stage 3: Attacker Mindset</div>
                <div class="stage-subtitle">Apply the attacker mindset to real scenarios</div>
            </div>
            <span class="stage-badge pending" id="s3-badge">Locked</span>
        </div>
        <div class="stage-body" id="stage3-body">
            <div class="engagement-doc">
                <div class="doc-heading">MERIDIAN BANK APP: OBSERVATIONS FROM MANUAL REVIEW</div>
                <hr class="doc-divider">
                <div class="doc-line"><span class="doc-key">Finding A:</span><span class="doc-val">The transfer form only accepts values between 1 and 10000. Client says "validation is handled server-side."</span></div>
                <div class="doc-line"><span class="doc-key">Finding B:</span><span class="doc-val">Transaction URLs contain: /transaction?id=4471. Client says "users can only see their own transactions."</span></div>
                <div class="doc-line"><span class="doc-key">Finding C:</span><span class="doc-val">The admin panel lives at /admin. It is not linked from any public page.</span></div>
            </div>

            <div class="quiz-question" id="q7-wrap">
                <p>Q7. Regarding Finding A, what would an attacker do next?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q7','A')" id="q7A" data-q="q7" data-v="A">
                        <span class="option-letter">A</span>Accept the client's statement and move on.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q7','B')" id="q7B" data-q="q7" data-v="B">
                        <span class="option-letter">B</span>Intercept the request and manually modify the transfer value to test whether server-side validation actually exists.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q7','C')" id="q7C" data-q="q7" data-v="C">
                        <span class="option-letter">C</span>Run a port scan on the form's endpoint.
                    </button>
                </div>
                <div class="quiz-feedback" id="q7-feedback"></div>
            </div>

            <div class="quiz-question" id="q8-wrap">
                <p>Q8. Regarding Finding B (transaction IDs in the URL), what is the correct attacker approach?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q8','A')" id="q8A" data-q="q8" data-v="A">
                        <span class="option-letter">A</span>Change the transaction ID to another number and observe whether a different user's record is returned.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q8','B')" id="q8B" data-q="q8" data-v="B">
                        <span class="option-letter">B</span>Attempt to brute-force the login page instead.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q8','C')" id="q8C" data-q="q8" data-v="C">
                        <span class="option-letter">C</span>Accept the client's assurance and document it as a low-risk finding.
                    </button>
                </div>
                <div class="quiz-feedback" id="q8-feedback"></div>
            </div>

            <div class="quiz-question" id="q9-wrap">
                <p>Q9. Regarding Finding C (unlisted admin panel), what does the attacker mindset say?</p>
                <div class="quiz-options">
                    <button class="quiz-option" onclick="checkQ('q9','A')" id="q9A" data-q="q9" data-v="A">
                        <span class="option-letter">A</span>Security through obscurity is sufficient; skip this endpoint.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q9','B')" id="q9B" data-q="q9" data-v="B">
                        <span class="option-letter">B</span>Being unlisted does not mean being protected; test the panel directly for authentication weaknesses.
                    </button>
                    <button class="quiz-option" onclick="checkQ('q9','C')" id="q9C" data-q="q9" data-v="C">
                        <span class="option-letter">C</span>Report it to the client without testing, as it was not explicitly listed in scope.
                    </button>
                </div>
                <div class="quiz-feedback" id="q9-feedback"></div>
            </div>

            <button class="stage-submit-btn" id="s3-submit" onclick="submitStage(3)" disabled>Complete Stage 3</button>
        </div>
    </div>

    <!-- FLAG REVEAL -->
    <div class="flag-reveal" id="flag-reveal">
        <h2>Engagement Complete</h2>
        <p>You have correctly classified the scope, matched all phases, and demonstrated the attacker mindset. The engagement flag has been unlocked. Copy it and enter it back in the room.</p>
        <div class="flag-value" id="flag-display">CBX{scope_defined}</div>
    </div>

</main>

<!-- ====== SPOTLIGHT TUTORIAL ====== -->
<div id="spotlight-overlay">
    <div id="spotlight-box"></div>
</div>
<div id="tutorial-tooltip">
    <h4 id="tooltip-title">Tutorial</h4>
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button class="tooltip-skip" onclick="skipTutorial()">Skip Tutorial</button>
        <button class="tooltip-next" onclick="nextTutorialStep()">Next</button>
    </div>
</div>

<!-- ====== TUTORIAL COMPLETE MODAL ====== -->
<div id="modal-overlay">
    <div class="modal-card">
        <h2>Tutorial Complete</h2>
        <p>You are ready to start. Work through each stage in order. All three stages must be completed correctly to reveal the flag.</p>
        <button class="modal-start-btn" onclick="closeTutorialModal()">Start Challenge</button>
    </div>
</div>

<script>
// ============================================================
// ANSWER KEY (correct option letters per question)
// ============================================================
const ANSWERS = {
    q1: 'A',
    q2: 'B',
    q3: 'C',
    q4: 'B',
    q5: 'C',
    q6: 'A',
    q7: 'B',
    q8: 'A',
    q9: 'B',
};

const FEEDBACK = {
    q1: { A: 'Correct. The IP falls within the authorised range 185.22.47.0/24. You may test it.', B: 'Not quite. The scope document covers the entire IP range. Each individual IP does not need separate authorisation.', C: 'Not quite. Downtime risk is a practical concern but not what determines scope. The IP range in the document is the determining factor.' },
    q2: { A: 'Incorrect. Testing an out-of-scope domain without written authorisation is a legal breach, regardless of how you arrived there.', B: 'Correct. You stop at the scope boundary, document the redirect path as a finding, and report it to the client without testing the destination.', C: 'Incorrect. Even testing the redirect mechanism toward an out-of-scope target could be considered unauthorised access. Stop and report.' },
    q3: { A: 'Not quite. A black box engagement gives the tester no prior information at all.', B: 'Not quite. A white box engagement provides complete system knowledge: source code, all credentials, full architecture.', C: 'Correct. Grey box provides partial knowledge, such as a standard user account and a network topology diagram, without full system access.' },
    q4: { A: 'Not quite. Scanning involves actively sending packets to enumerate live hosts and open ports. WHOIS and DNS queries are passive information gathering.', B: 'Correct. Querying WHOIS and DNS records is passive reconnaissance: gathering publicly available information before any active interaction.', C: 'Not quite. Exploitation involves actively attempting to leverage a discovered vulnerability. DNS and WHOIS queries are far earlier in the process.' },
    q5: { A: 'Not quite. Scanning maps open services and vulnerabilities. The SQL injection has already been discovered at this point; this activity is actively using it.', B: 'Not quite. Post-exploitation happens after initial access is gained. This entry is the moment of gaining that access.', C: 'Correct. Actively exploiting the SQL injection flaw to gain database read access is textbook Exploitation phase.' },
    q6: { A: 'Correct. Using the database access to pivot into a different internal system is lateral movement, which is a core Post-Exploitation activity.', B: 'Not quite. Exploitation is the initial compromise. Pivoting from one compromised system into another is Post-Exploitation.', C: 'Not quite. Scanning maps the surface before exploitation. Pivoting between systems after initial access is Post-Exploitation.' },
    q7: { A: 'Not quite. The attacker mindset never accepts verbal assurances. Every claim must be verified through testing.', B: 'Correct. An attacker intercepts and modifies the request directly, bypassing client-side validation. If the server does not re-validate, the transfer goes through with an arbitrary value.', C: 'Not quite. Port scanning the endpoint would not reveal whether the server validates the transfer amount. The correct move is to manipulate the parameter directly.' },
    q8: { A: 'Correct. Incrementing or changing the transaction ID tests for Insecure Direct Object Reference (IDOR), one of the most common and impactful web vulnerabilities.', B: 'Not quite. Brute-forcing the login page is unrelated to this specific finding. The issue here is a potentially exploitable ID in the URL.', C: 'Not quite. Client assurances do not replace evidence. An attacker tests the claim directly rather than accepting it.' },
    q9: { A: 'Not quite. Security through obscurity is not a security control. An attacker who discovers the path through enumeration or guessing can still access it.', B: 'Correct. The attacker mindset recognises that an unlisted path is not a protected one. The admin panel must be tested for authentication flaws, default credentials, and access control weaknesses.', C: 'Not quite. The admin panel lives on an in-scope domain (app.meridianbank.co.uk), so testing it is legitimate. The path being unlisted does not remove it from scope.' },
};

// ============================================================
// STATE
// ============================================================
const state = {
    s1: { q1: false, q2: false, q3: false, complete: false },
    s2: { q4: false, q5: false, q6: false, complete: false },
    s3: { q7: false, q8: false, q9: false, complete: false },
};

function getProgress() {
    const done = [state.s1.complete, state.s2.complete, state.s3.complete].filter(Boolean).length;
    return Math.round((done / 3) * 100);
}

function updateProgress() {
    const pct = getProgress();
    document.getElementById('progress-fill').style.width = pct + '%';
    document.getElementById('progress-pct').textContent = pct + '%';
}

// ============================================================
// ANSWER CHECKING
// ============================================================
function checkQ(qid, selected) {
    const correct = ANSWERS[qid];
    const isCorrect = selected === correct;

    // Disable all buttons for this question
    ['A','B','C'].forEach(letter => {
        const btn = document.getElementById(qid + letter);
        if (btn) {
            btn.disabled = true;
            if (letter === correct) btn.classList.add('correct');
            else if (letter === selected && !isCorrect) btn.classList.add('wrong');
        }
    });

    // Show feedback
    const fb = document.getElementById(qid + '-feedback');
    fb.textContent = FEEDBACK[qid][selected];
    fb.className = 'quiz-feedback ' + (isCorrect ? 'correct-fb' : 'wrong-fb');
    fb.style.display = 'block';

    // Update state
    const stageMap = { q1:'s1', q2:'s1', q3:'s1', q4:'s2', q5:'s2', q6:'s2', q7:'s3', q8:'s3', q9:'s3' };
    const stageKey = stageMap[qid];
    if (isCorrect) state[stageKey][qid] = true;

    // Check if stage submit should be enabled
    checkStageReady(stageKey);
}

function checkStageReady(stageKey) {
    const stageQuestions = { s1: ['q1','q2','q3'], s2: ['q4','q5','q6'], s3: ['q7','q8','q9'] };
    const submitId = { s1: 's1-submit', s2: 's2-submit', s3: 's3-submit' };
    const allCorrect = stageQuestions[stageKey].every(q => state[stageKey][q]);
    if (allCorrect) {
        document.getElementById(submitId[stageKey]).disabled = false;
    }
}

// ============================================================
// STAGE SUBMISSION
// ============================================================
function submitStage(num) {
    const stageKey = 's' + num;
    const stageEl = document.getElementById('stage' + num);
    const numEl = document.getElementById('s' + num + '-num');
    const badgeEl = document.getElementById('s' + num + '-badge');

    // Mark complete
    state[stageKey].complete = true;
    stageEl.classList.remove('active');
    stageEl.classList.add('completed');
    numEl.textContent = '✓';
    badgeEl.textContent = 'Complete';
    badgeEl.className = 'stage-badge done';

    // Disable submit button
    document.getElementById('s' + num + '-submit').disabled = true;

    updateProgress();

    // Update status message
    const messages = {
        1: 'Stage 1 complete. Scope classification confirmed. Unlocking Phase Identification.',
        2: 'Stage 2 complete. Phase mapping confirmed. Unlocking Attacker Mindset.',
        3: 'All stages complete. Retrieving engagement flag...',
    };
    setStatus('✅', messages[num]);

    // Unlock next stage or reveal flag
    if (num < 3) {
        const next = num + 1;
        const nextEl = document.getElementById('stage' + next);
        const nextBadge = document.getElementById('s' + next + '-badge');
        nextEl.classList.remove('locked');
        nextEl.classList.add('active');
        nextBadge.textContent = 'Active';
        nextBadge.className = 'stage-badge active-badge';
        document.getElementById('s' + next + '-num').style.borderColor = 'var(--accent-primary)';
        document.getElementById('s' + next + '-num').style.color = 'var(--accent-primary)';
    } else {
        // All done: reveal flag
        setTimeout(() => {
            document.getElementById('flag-reveal').style.display = 'block';
            document.getElementById('flag-reveal').scrollIntoView({ behavior: 'smooth', block: 'center' });
            setStatus('🏁', 'Engagement complete. Flag has been revealed below.');
        }, 600);
    }
}

function setStatus(icon, msg) {
    document.querySelector('#status-area .status-icon').textContent = icon;
    document.getElementById('status-message').textContent = msg;
}

// ============================================================
// TUTORIAL SYSTEM
// ============================================================
const tutorialSteps = [
    {
        targetId: 'mission-section',
        title: 'Mission Briefing',
        text: 'This is your mission briefing. It describes your role and objective. In a real engagement, this would be your client kickoff document. Read it before starting any stage.',
    },
    {
        targetId: 'progress-container',
        title: 'Progress Tracker',
        text: 'This bar tracks how many of the three stages you have completed. It fills as you finish each stage. You need all three at 100% to unlock the flag.',
    },
    {
        targetId: 'status-area',
        title: 'Status Area',
        text: 'This area shows feedback about what just happened. When you complete a stage or make a mistake, the message here updates to guide you.',
    },
    {
        targetId: 'stage1',
        title: 'Stage 1: Scope Classification',
        text: 'This is your first stage. Read the engagement package document above the questions carefully, then answer each question. All three questions must be correct before you can complete the stage.',
    },
    {
        targetId: 'engagement-doc',
        title: 'Engagement Package',
        text: 'The engagement package is your reference document. It shows the scope boundaries, authorised targets, out-of-scope restrictions, and prior knowledge provided. In a real pentest, this is the document you would refer back to constantly.',
    },
    {
        targetId: 'stage2',
        title: 'Stage 2: Phase Identification',
        text: 'This stage unlocks after Stage 1 is complete. You will read a tester activity log and match each action to the correct phase of the penetration test methodology.',
    },
    {
        targetId: 'stage3',
        title: 'Stage 3: Attacker Mindset',
        text: 'This is the final stage. You will review a set of observations about the target application and choose the response that best demonstrates the attacker mindset.',
    },
];

let tutorialStep = 0;

function startTutorial() {
    tutorialStep = 0;
    showTutorialStep(tutorialStep);
    document.getElementById('spotlight-overlay').classList.add('active');
    document.getElementById('tutorial-tooltip').style.display = 'block';
}

function showTutorialStep(stepIndex) {
    const step = tutorialSteps[stepIndex];
    const target = document.getElementById(step.targetId);
    if (!target) { nextTutorialStep(); return; }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => { positionSpotlight(target, step); }, 320);
}

function positionSpotlight(target, step) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    const box = document.getElementById('spotlight-box');
    box.style.top    = (rect.top    - pad) + 'px';
    box.style.left   = (rect.left   - pad) + 'px';
    box.style.width  = (rect.width  + pad * 2) + 'px';
    box.style.height = (rect.height + pad * 2) + 'px';

    // Position tooltip
    const tip = document.getElementById('tutorial-tooltip');
    document.getElementById('tooltip-title').textContent = step.title;
    document.getElementById('tooltip-text').textContent  = step.text;
    tip.style.display = 'block';

    const tipH = 160;
    const tipW = 320;
    const viewH = window.innerHeight;
    const viewW = window.innerWidth;

    let tipTop  = rect.bottom + pad + 12;
    let tipLeft = rect.left;

    if (tipTop + tipH > viewH - 20) tipTop = rect.top - tipH - pad - 12;
    if (tipTop < 10) tipTop = 10;
    if (tipLeft + tipW > viewW - 16) tipLeft = viewW - tipW - 16;
    if (tipLeft < 10) tipLeft = 10;

    tip.style.top  = tipTop  + 'px';
    tip.style.left = tipLeft + 'px';
}

function nextTutorialStep() {
    tutorialStep++;
    if (tutorialStep >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    showTutorialStep(tutorialStep);
}

function skipTutorial() { endTutorial(); }

function endTutorial() {
    document.getElementById('spotlight-overlay').classList.remove('active');
    document.getElementById('tutorial-tooltip').style.display = 'none';
    document.getElementById('modal-overlay').classList.add('active');
}

function closeTutorialModal() {
    document.getElementById('modal-overlay').classList.remove('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

window.addEventListener('resize', () => {
    if (document.getElementById('spotlight-overlay').classList.contains('active')) {
        const step = tutorialSteps[tutorialStep];
        if (!step) return;
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target, step);
    }
});

// ============================================================
// AUTO-START TUTORIAL ON FIRST LOAD
// ============================================================
window.addEventListener('load', () => {
    setTimeout(startTutorial, 400);
});
</script>
</body>
</html>
