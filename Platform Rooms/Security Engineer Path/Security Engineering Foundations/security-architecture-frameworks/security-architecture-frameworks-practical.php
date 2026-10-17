<?php
// ============================================================
// security-architecture-frameworks-practical.php
// Standalone static practical: Framework Selector
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Framework Selector</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: radial-gradient(circle at top, var(--bg-secondary), var(--bg-primary));
    color: var(--text-primary);
    min-height: 100vh;
    padding: 24px;
}

.wrapper { max-width: 900px; margin: 0 auto; position: relative; }

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}
.header h1 { font-size: 1.7rem; margin: 0 0 6px 0; }
.header p { color: var(--text-secondary); margin: 0; font-size: 0.95rem; }

.tutorial-btn {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    cursor: pointer;
    white-space: nowrap;
}
.tutorial-btn:hover { box-shadow: var(--glow-accent); }

/* Description */
.brief-panel {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
}
.brief-panel h2 { margin-top: 0; font-size: 1.1rem; }
.brief-panel p { color: var(--text-secondary); font-size: 0.92rem; line-height: 1.6; }

/* Progress */
#progress-indicator {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
}
.progress-dot {
    flex: 1;
    height: 6px;
    border-radius: 4px;
    background: var(--border-default);
}
.progress-dot.done { background: var(--success); }

/* Case cards */
.case-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 22px 24px;
    margin-bottom: 18px;
    display: none;
}
.case-card.active { display: block; }
.case-card.solved { border-color: var(--success); }

.case-title {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--accent-secondary);
    margin-bottom: 8px;
}
.case-brief { color: var(--text-primary); line-height: 1.65; font-size: 0.95rem; margin-bottom: 18px; }

.framework-buttons { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
.fw-btn {
    flex: 1;
    min-width: 140px;
    padding: 14px 12px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    color: var(--text-primary);
    font-family: inherit;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: border-color 0.2s ease;
}
.fw-btn:hover { border-color: var(--accent-primary); }
.fw-btn.correct { border-color: var(--success); color: var(--success); }
.fw-btn.incorrect { border-color: var(--error); color: var(--error); }

.feedback-area {
    min-height: 26px;
    font-size: 0.9rem;
    padding: 12px 14px;
    border-radius: 8px;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    display: none;
}
.feedback-area.show { display: block; }
.feedback-area.correct { color: var(--success); border-color: var(--success); }
.feedback-area.incorrect { color: var(--error); border-color: var(--error); }

.next-case-btn {
    margin-top: 14px;
    background: var(--accent-primary);
    color: #04121a;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
    display: none;
}
.next-case-btn.show { display: inline-block; }

/* Recommendation report */
#recommendation-report {
    display: none;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    margin-top: 10px;
    box-shadow: var(--glow-accent);
}
#recommendation-report.reveal { display: block; }
#recommendation-report h2 {
    margin-top: 0;
    font-family: "JetBrains Mono", monospace;
    letter-spacing: 0.04em;
    color: var(--accent-primary);
    font-size: 1.1rem;
}
.report-line {
    font-size: 0.88rem;
    color: var(--text-secondary);
    padding: 8px 0;
    border-bottom: 1px solid var(--border-default);
}
.report-line strong { color: var(--text-primary); }

.flag-box {
    margin-top: 20px;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    border-radius: 8px;
    padding: 16px 20px;
    font-family: "JetBrains Mono", monospace;
    font-size: 1.05rem;
    color: var(--success);
    text-align: center;
    letter-spacing: 0.02em;
}

/* Spotlight tutorial */
.spotlight {
    position: fixed;
    border-radius: 10px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 998;
}
.tooltip-card {
    position: fixed;
    max-width: 280px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    font-size: 0.85rem;
    color: var(--text-primary);
    z-index: 999;
    box-shadow: var(--glow-accent);
}
.tooltip-card .tt-buttons { display: flex; justify-content: space-between; margin-top: 12px; }
.tooltip-card button {
    background: var(--accent-primary);
    color: #04121a;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
}
.tooltip-card button.skip-btn {
    background: transparent;
    color: var(--text-muted);
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 30px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin-top: 0; color: var(--accent-primary); }
.modal-box button {
    margin-top: 16px;
    background: var(--accent-primary);
    color: #04121a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    cursor: pointer;
}
</style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div>
            <h1>Framework Selector</h1>
            <p>Consulting simulation: recommend a security architecture framework for four client engagements.</p>
        </div>
        <button class="tutorial-btn" id="view-tutorial-btn">View Tutorial</button>
    </div>

    <div class="brief-panel">
        <h2>Mission Briefing</h2>
        <p>You are a security architecture consultant. Four clients have described their organization and their goals. For each one, choose whether SABSA, TOGAF security extensions, or OSA is the best fit. Read carefully, since more than one framework may seem plausible at first glance. Once all four cases are correctly matched, your Recommendation Report will unlock along with a completion flag.</p>
    </div>

    <div id="progress-indicator">
        <div class="progress-dot" data-case="1"></div>
        <div class="progress-dot" data-case="2"></div>
        <div class="progress-dot" data-case="3"></div>
        <div class="progress-dot" data-case="4"></div>
    </div>

    <!-- Case 1 -->
    <div class="case-card active" id="case-card-1" data-answer="sabsa">
        <div class="case-title">Client Brief 1 of 4</div>
        <div class="case-brief">A global insurance group's board has mandated a formal, top down security program. Executives want every control traceable back to a named business risk and a named business attribute, such as "customer trust" or "regulatory confidence". There is no existing enterprise architecture practice to plug into.</div>
        <div class="framework-buttons" id="framework-buttons-1">
            <button class="fw-btn" data-fw="sabsa">SABSA</button>
            <button class="fw-btn" data-fw="togaf">TOGAF</button>
            <button class="fw-btn" data-fw="osa">OSA</button>
        </div>
        <div class="feedback-area" id="feedback-area-1"></div>
        <button class="next-case-btn" data-next="2">Next Case →</button>
    </div>

    <!-- Case 2 -->
    <div class="case-card" id="case-card-2" data-answer="togaf">
        <div class="case-title">Client Brief 2 of 4</div>
        <div class="case-brief">A manufacturing conglomerate already runs all IT initiatives through a mature TOGAF Architecture Development Method. The CISO has been asked to embed security checkpoints into that existing method without introducing a parallel methodology.</div>
        <div class="framework-buttons" id="framework-buttons-2">
            <button class="fw-btn" data-fw="sabsa">SABSA</button>
            <button class="fw-btn" data-fw="togaf">TOGAF</button>
            <button class="fw-btn" data-fw="osa">OSA</button>
        </div>
        <div class="feedback-area" id="feedback-area-2"></div>
        <button class="next-case-btn" data-next="3">Next Case →</button>
    </div>

    <!-- Case 3 -->
    <div class="case-card" id="case-card-3" data-answer="osa">
        <div class="case-title">Client Brief 3 of 4</div>
        <div class="case-brief">A fast growing fintech has no in house architecture team and needs to secure a new public API gateway quickly, using proven, well documented designs rather than building anything from scratch.</div>
        <div class="framework-buttons" id="framework-buttons-3">
            <button class="fw-btn" data-fw="sabsa">SABSA</button>
            <button class="fw-btn" data-fw="togaf">TOGAF</button>
            <button class="fw-btn" data-fw="osa">OSA</button>
        </div>
        <div class="feedback-area" id="feedback-area-3"></div>
        <button class="next-case-btn" data-next="4">Next Case →</button>
    </div>

    <!-- Case 4 -->
    <div class="case-card" id="case-card-4" data-answer="sabsa">
        <div class="case-title">Client Brief 4 of 4</div>
        <div class="case-brief">A regional hospital network merging IT systems after an acquisition must justify every security control to its board in terms of patient safety and regulatory risk, even though the technical team already has a small library of firewall and segmentation patterns they like reusing.</div>
        <div class="framework-buttons" id="framework-buttons-4">
            <button class="fw-btn" data-fw="sabsa">SABSA</button>
            <button class="fw-btn" data-fw="togaf">TOGAF</button>
            <button class="fw-btn" data-fw="osa">OSA</button>
        </div>
        <div class="feedback-area" id="feedback-area-4"></div>
        <button class="next-case-btn" data-final="true">View Report →</button>
    </div>

    <!-- Recommendation report -->
    <div id="recommendation-report">
        <h2>RECOMMENDATION REPORT // CONSULTING DELIVERABLE</h2>
        <div class="report-line"><strong>Client 1 (Insurance Group):</strong> SABSA, board level traceability from business risk to control.</div>
        <div class="report-line"><strong>Client 2 (Manufacturing Conglomerate):</strong> TOGAF, security checkpoints embedded into an existing ADM practice.</div>
        <div class="report-line"><strong>Client 3 (Fintech Startup):</strong> OSA, fast reuse of proven patterns with no architecture team.</div>
        <div class="report-line"><strong>Client 4 (Hospital Network):</strong> SABSA, board level justification outweighs the existing pattern library.</div>
        <div class="flag-box" id="flag-box">CBX{framework_selected}</div>
    </div>

</div>

<!-- Tutorial spotlight elements -->
<div class="spotlight" id="spotlight" style="display:none;"></div>
<div class="tooltip-card" id="tooltip-card" style="display:none;"></div>

<div class="modal-overlay" id="tutorial-complete-modal">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
const CORRECT_FEEDBACK = {
    1: "Correct. This is a business attribute driven engagement starting from board level risk, exactly what SABSA's layered traceability model is built for.",
    2: "Correct. The organization already has an EA practice in place, so extending it with security checkpoints is the TOGAF security extension use case.",
    3: "Correct. A small team needing proven, reusable designs for a specific technical problem is the pattern catalogue use case.",
    4: "Correct. Despite the existing pattern library, the requirement is board level traceability from risk to control, which is a SABSA driven need. The pattern library can still be used later during implementation."
};

const WRONG_FEEDBACK = {
    1: {
        togaf: "Not quite. TOGAF assumes an existing generic architecture process to extend, and this case has none.",
        osa: "Not quite. OSA gives reusable patterns, not a business risk traceability chain."
    },
    2: {
        sabsa: "Not quite. SABSA is a standalone method, not an extension layered onto an existing TOGAF cycle.",
        osa: "Not quite. OSA supplies patterns, not process checkpoints."
    },
    3: {
        sabsa: "Not quite. SABSA requires a business attribute exercise this team has no time or capacity for.",
        togaf: "Not quite. There is no existing EA process here to extend."
    },
    4: {
        osa: "Not quite. Patterns describe how to build a control, not why it is justified to the board.",
        togaf: "Not quite. No existing EA method is mentioned as needing extension."
    }
};

let solvedCases = { 1: false, 2: false, 3: false, 4: false };

document.querySelectorAll('.case-card').forEach(card => {
    const caseNum = parseInt(card.id.split('-')[2]);
    const correctAnswer = card.dataset.answer;
    const buttons = card.querySelectorAll('.fw-btn');
    const feedback = document.getElementById('feedback-area-' + caseNum);
    const nextBtn = card.querySelector('.next-case-btn');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (solvedCases[caseNum]) return;
            const chosen = btn.dataset.fw;
            if (chosen === correctAnswer) {
                buttons.forEach(b => b.classList.remove('incorrect'));
                btn.classList.add('correct');
                buttons.forEach(b => b.disabled = true);
                feedback.textContent = CORRECT_FEEDBACK[caseNum];
                feedback.className = 'feedback-area show correct';
                nextBtn.className = nextBtn.className.includes('next-case-btn') ? 'next-case-btn show' : nextBtn.className;
                nextBtn.classList.add('show');
                card.classList.add('solved');
                document.querySelector('.progress-dot[data-case="' + caseNum + '"]').classList.add('done');
                solvedCases[caseNum] = true;
            } else {
                btn.classList.add('incorrect');
                feedback.textContent = WRONG_FEEDBACK[caseNum][chosen];
                feedback.className = 'feedback-area show incorrect';
            }
        });
    });

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (nextBtn.dataset.next) {
                const nextCase = nextBtn.dataset.next;
                document.getElementById('case-card-' + nextCase).classList.add('active');
                card.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (nextBtn.dataset.final) {
                checkAllSolved();
            }
        });
    }
});

function checkAllSolved() {
    const allDone = Object.values(solvedCases).every(v => v === true);
    if (allDone) {
        const report = document.getElementById('recommendation-report');
        report.classList.add('reveal');
        report.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

/* ===================== Tutorial System ===================== */
const tutorialSteps = [
    { targetId: 'case-card-1', text: 'This is a case brief, a short description of a real client engagement. Read the context carefully before choosing a framework.' },
    { targetId: 'framework-buttons-1', text: 'Pick the framework you think best fits this case. Think of this like a consultant recommending a methodology to a client.' },
    { targetId: 'feedback-area-1', text: 'After you choose, feedback appears here explaining whether your pick fits the case and why. Use it to correct your reasoning if needed.' },
    { targetId: 'progress-indicator', text: 'This tracks how many cases you have correctly matched. All four must be correct before the report unlocks.' },
    { targetId: 'recommendation-report', text: 'Once every case is matched correctly, your final Recommendation Report unlocks here, along with the completion flag.' }
];

let currentStep = 0;
let tutorialActive = false;

const spotlight = document.getElementById('spotlight');
const tooltipCard = document.getElementById('tooltip-card');

function showStep(index) {
    if (index >= tutorialSteps.length) {
        endTutorial();
        return;
    }
    const step = tutorialSteps[index];
    let target = document.getElementById(step.targetId);
    if (!target) { currentStep++; showStep(currentStep); return; }

    // temporarily make hidden report visible for spotlighting on last step
    if (step.targetId === 'recommendation-report' && !target.classList.contains('reveal')) {
        target.style.display = 'block';
    }

    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => positionSpotlight(target, step.text), 300);
}

function positionSpotlight(target, text) {
    const rect = target.getBoundingClientRect();
    const pad = 8;
    spotlight.style.display = 'block';
    spotlight.style.top = (rect.top - pad) + 'px';
    spotlight.style.left = (rect.left - pad) + 'px';
    spotlight.style.width = (rect.width + pad * 2) + 'px';
    spotlight.style.height = (rect.height + pad * 2) + 'px';

    tooltipCard.style.display = 'block';
    tooltipCard.innerHTML = '<p>' + text + '</p><div class="tt-buttons"><button class="skip-btn" id="tt-skip">Skip Tutorial</button><button id="tt-next">Next</button></div>';

    let top = rect.bottom + 16;
    let left = rect.left;
    if (top + 140 > window.innerHeight) top = rect.top - 160;
    if (left + 300 > window.innerWidth) left = window.innerWidth - 310;
    if (left < 10) left = 10;
    tooltipCard.style.top = top + 'px';
    tooltipCard.style.left = left + 'px';

    document.getElementById('tt-next').addEventListener('click', () => {
        currentStep++;
        showStep(currentStep);
    });
    document.getElementById('tt-skip').addEventListener('click', endTutorial);
}

function endTutorial() {
    spotlight.style.display = 'none';
    tooltipCard.style.display = 'none';
    tutorialActive = false;
    const report = document.getElementById('recommendation-report');
    if (!Object.values(solvedCases).every(v => v === true)) {
        report.style.display = '';
    }
    document.getElementById('tutorial-complete-modal').classList.add('show');
}

document.getElementById('start-challenge-btn').addEventListener('click', () => {
    document.getElementById('tutorial-complete-modal').classList.remove('show');
});

document.getElementById('view-tutorial-btn').addEventListener('click', () => {
    currentStep = 0;
    tutorialActive = true;
    showStep(0);
});

window.addEventListener('resize', () => {
    if (tutorialActive) {
        const step = tutorialSteps[currentStep];
        const target = document.getElementById(step.targetId);
        if (target) positionSpotlight(target, step.text);
    }
});

window.addEventListener('load', () => {
    currentStep = 0;
    tutorialActive = true;
    showStep(0);
});
</script>
</body>
</html>
