<?php
// File: privileged-access-management-practical.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vault Console | PAM Practical</title>
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
    font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

.page-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 24px 20px 80px 20px;
    position: relative;
}

header.top-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
}

header.top-header h1 {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}

header.top-header p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 560px;
}

#tutorial-btn {
    flex-shrink: 0;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    color: var(--accent-primary);
    padding: 10px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
#tutorial-btn:hover {
    box-shadow: var(--glow-accent);
    border-color: var(--accent-primary);
}

.mission-briefing {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 24px;
}
.mission-briefing h2 {
    margin-top: 0;
    font-size: 1.05rem;
    color: var(--accent-primary);
}
.mission-briefing p {
    color: var(--text-secondary);
    margin: 8px 0;
    font-size: 0.95rem;
}

#vault-account-list {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}
#vault-account-list h2 {
    margin-top: 0;
    font-size: 1.1rem;
}

table.vault-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    margin-top: 10px;
}
table.vault-table th {
    text-align: left;
    color: var(--text-muted);
    font-weight: 600;
    padding: 10px 8px;
    border-bottom: 1px solid var(--border-default);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
table.vault-table td {
    padding: 12px 8px;
    border-bottom: 1px solid var(--border-default);
    color: var(--text-primary);
}
table.vault-table td.mono {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85rem;
}

.status-pill {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(61,255,154,0.12);
    color: var(--success);
}
.status-pill.checked-out {
    background: rgba(255,211,106,0.14);
    color: var(--warning);
}

.checkout-btn {
    background: var(--bg-primary);
    border: 1px solid var(--accent-primary);
    color: var(--accent-primary);
    padding: 7px 14px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.checkout-btn:hover:not(:disabled) {
    box-shadow: var(--glow-accent);
}
.checkout-btn:disabled {
    opacity: 0.35;
    cursor: not-allowed;
}

/* Modal */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    align-items: center;
    justify-content: center;
    z-index: 500;
    padding: 20px;
}
.modal-overlay.active { display: flex; }
.modal-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 24px;
    max-width: 420px;
    width: 100%;
}
.modal-card h3 {
    margin-top: 0;
    font-size: 1.05rem;
}
.modal-card p.hint {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 0;
}
#jit-justification-field {
    width: 100%;
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    color: var(--text-primary);
    padding: 10px 12px;
    font-family: inherit;
    font-size: 0.9rem;
    margin-bottom: 14px;
    resize: vertical;
    min-height: 70px;
}
.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.btn-primary {
    background: var(--accent-primary);
    color: var(--bg-primary);
    border: none;
    padding: 9px 18px;
    border-radius: 6px;
    font-family: inherit;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
}
.btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-ghost {
    background: transparent;
    border: 1px solid var(--border-default);
    color: var(--text-secondary);
    padding: 9px 18px;
    border-radius: 6px;
    font-family: inherit;
    font-size: 0.85rem;
    cursor: pointer;
}

/* Active session panel */
#active-session-panel {
    display: none;
    background: var(--bg-secondary);
    border: 1px solid var(--border-default);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}
#active-session-panel.active { display: block; }
.session-top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 14px;
}
#session-timer {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    color: var(--warning);
    background: rgba(255,211,106,0.1);
    padding: 6px 14px;
    border-radius: 8px;
}

#session-monitor-panel {
    background: var(--bg-primary);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 14px;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.82rem;
    color: var(--accent-primary);
    min-height: 130px;
    max-height: 200px;
    overflow-y: auto;
}
#session-monitor-panel .line {
    margin: 3px 0;
    color: var(--text-secondary);
}
#session-monitor-panel .line::before {
    content: "> ";
    color: var(--accent-primary);
}

.checkin-btn {
    margin-top: 14px;
    background: var(--accent-secondary);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
}
.checkin-btn:disabled { opacity: 0.4; cursor: not-allowed; }

/* Status / feedback area */
#status-area {
    min-height: 24px;
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 24px;
    padding: 0 4px;
}
#status-area .status-line {
    margin: 4px 0;
}
#status-area .status-success { color: var(--success); }

/* Flag reveal */
#flag-reveal {
    display: none;
    background: var(--bg-secondary);
    border: 1px solid var(--success);
    border-radius: 12px;
    padding: 22px;
    text-align: center;
}
#flag-reveal.active { display: block; }
#flag-reveal h2 {
    color: var(--success);
    margin-top: 0;
    font-size: 1.1rem;
}
#flag-reveal .flag-value {
    display: inline-block;
    margin-top: 8px;
    font-family: "JetBrains Mono", monospace;
    background: var(--bg-primary);
    border: 1px solid var(--success);
    color: var(--success);
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 1.05rem;
    letter-spacing: 0.02em;
}

/* Spotlight tutorial */
#spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    z-index: 900;
    transition: all 0.25s ease;
    display: none;
}
#tooltip-card {
    position: fixed;
    background: var(--bg-secondary);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px 18px;
    max-width: 300px;
    z-index: 901;
    display: none;
    box-shadow: var(--glow-accent);
}
#tooltip-card p {
    margin: 0 0 12px 0;
    color: var(--text-secondary);
    font-size: 0.88rem;
}
.tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tooltip-actions button {
    font-family: inherit;
    font-size: 0.8rem;
    cursor: pointer;
    border-radius: 6px;
    padding: 6px 12px;
}
#tooltip-next { background: var(--accent-primary); color: var(--bg-primary); border: none; font-weight: 700; }
#tooltip-skip { background: transparent; border: 1px solid var(--border-default); color: var(--text-muted); }

/* Completion modal */
#completion-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    align-items: center;
    justify-content: center;
    z-index: 950;
    padding: 20px;
}
#completion-modal.active { display: flex; }
#completion-modal .modal-card { text-align: center; max-width: 380px; }
#completion-modal h3 { color: var(--accent-primary); }

@media (max-width: 640px) {
    header.top-header { flex-direction: column; }
    table.vault-table { font-size: 0.8rem; }
}
</style>
</head>
<body>
<div class="page-wrap">

    <!-- SECTION 1: Top header -->
    <header class="top-header">
        <div>
            <h1>PAM Vault Console</h1>
            <p>Simulated privileged access management environment. Check out a credential, complete a monitored session, and check it back in.</p>
        </div>
        <button id="tutorial-btn" type="button">View Tutorial</button>
    </header>

    <!-- SECTION 2: Description / mission briefing -->
    <div class="mission-briefing">
        <h2>Mission Briefing</h2>
        <p>This console represents a PAM vault holding several privileged accounts. None of these passwords are visible to you directly, because that is the entire point of a vault.</p>
        <p>Your goal: check out one privileged credential, observe the live session recording while it is in use, then check the credential back in so the vault can automatically rotate its password. The flag appears only once that full cycle is complete.</p>
    </div>

    <!-- SECTION 3: Main interactive environment -->
    <div id="vault-account-list">
        <h2>Vault Account Registry</h2>
        <table class="vault-table">
            <thead>
                <tr>
                    <th>Account</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Last Rotated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="vault-table-body">
                <!-- rows injected by JS -->
            </tbody>
        </table>
    </div>

    <div id="active-session-panel">
        <div class="session-top-row">
            <div>
                <strong id="active-session-account">-</strong>
                <div style="color: var(--text-muted); font-size: 0.8rem;">Active privileged session</div>
            </div>
            <div id="session-timer">Session expires in: 00:20</div>
        </div>
        <div id="session-monitor-panel"></div>
        <button class="checkin-btn" id="checkin-btn" disabled>Check In Credential</button>
    </div>

    <!-- SECTION 4: Feedback / status area -->
    <div id="status-area"></div>

    <!-- SECTION 5: Flag reveal area -->
    <div id="flag-reveal">
        <h2>Session Closed and Recorded</h2>
        <p style="color: var(--text-secondary); margin-top: 0;">Credential returned. Password rotated automatically. Session log finalized.</p>
        <div class="flag-value">CBX{vault_credential_rotated}</div>
    </div>

</div>

<!-- Checkout / JIT justification modal -->
<div class="modal-overlay" id="checkout-modal">
    <div class="modal-card">
        <h3>Request Access</h3>
        <p class="hint">This is a Just-in-Time access request. State why you need this credential before it is released.</p>
        <textarea id="jit-justification-field" placeholder="Reason for access, e.g. investigating a failed backup job"></textarea>
        <div class="modal-actions">
            <button class="btn-ghost" id="checkout-cancel" type="button">Cancel</button>
            <button class="btn-primary" id="checkout-submit" type="button" disabled>Submit Request</button>
        </div>
    </div>
</div>

<!-- Tutorial spotlight elements -->
<div id="spotlight"></div>
<div id="tooltip-card">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button id="tooltip-skip" type="button">Skip Tutorial</button>
        <button id="tooltip-next" type="button">Next</button>
    </div>
</div>

<!-- Tutorial completion modal -->
<div id="completion-modal">
    <div class="modal-card">
        <h3>Tutorial Complete</h3>
        <p style="color: var(--text-secondary);">You're ready to start the challenge.</p>
        <button class="btn-primary" id="start-challenge-btn" type="button">Start Challenge</button>
    </div>
</div>

<script>
(function () {
    "use strict";

    var accounts = [
        { id: "acc-1", name: "CORP\\\\DomainAdmin01", type: "Domain Admin", lastRotated: "3 days ago", status: "available" },
        { id: "acc-2", name: "svc-sql-prod", type: "Service Account", lastRotated: "90 days ago", status: "available" },
        { id: "acc-3", name: "BKP-SVR02\\\\Administrator", type: "Local Admin", lastRotated: "14 days ago", status: "available" },
        { id: "acc-4", name: "root@LNX-WEB01", type: "Root", lastRotated: "7 days ago", status: "available" }
    ];

    var activeAccountId = null;
    var sessionTimerInterval = null;
    var sessionSecondsLeft = 20;
    var monitorLinesShown = 0;
    var monitorTimeout = null;
    var monitorFinished = false;
    var cycleCompletedOnce = false;

    var monitorLines = [
        "whoami",
        "net user /domain",
        "Get-ADUser -Filter * -Properties MemberOf",
        "Establishing recorded session stream...",
        "Session activity logged to vault audit trail"
    ];

    var tableBody = document.getElementById("vault-table-body");
    var statusArea = document.getElementById("status-area");
    var checkoutModal = document.getElementById("checkout-modal");
    var justificationField = document.getElementById("jit-justification-field");
    var checkoutSubmit = document.getElementById("checkout-submit");
    var checkoutCancel = document.getElementById("checkout-cancel");
    var sessionPanel = document.getElementById("active-session-panel");
    var sessionAccountLabel = document.getElementById("active-session-account");
    var sessionTimerLabel = document.getElementById("session-timer");
    var monitorPanel = document.getElementById("session-monitor-panel");
    var checkinBtn = document.getElementById("checkin-btn");
    var flagReveal = document.getElementById("flag-reveal");

    function renderTable() {
        tableBody.innerHTML = "";
        accounts.forEach(function (acc) {
            var tr = document.createElement("tr");

            var tdName = document.createElement("td");
            tdName.className = "mono";
            tdName.textContent = acc.name;
            tr.appendChild(tdName);

            var tdType = document.createElement("td");
            tdType.textContent = acc.type;
            tr.appendChild(tdType);

            var tdStatus = document.createElement("td");
            var pill = document.createElement("span");
            pill.className = "status-pill" + (acc.status === "checked-out" ? " checked-out" : "");
            pill.textContent = acc.status === "checked-out" ? "Checked Out" : "Available";
            tdStatus.appendChild(pill);
            tr.appendChild(tdStatus);

            var tdRotated = document.createElement("td");
            tdRotated.textContent = acc.lastRotated;
            tr.appendChild(tdRotated);

            var tdAction = document.createElement("td");
            var btn = document.createElement("button");
            btn.className = "checkout-btn";
            btn.textContent = "Check Out";
            btn.disabled = acc.status === "checked-out" || activeAccountId !== null;
            btn.setAttribute("data-account-id", acc.id);
            if (acc.id === "acc-1") {
                btn.id = "checkout-btn";
            }
            btn.addEventListener("click", function () {
                openCheckoutModal(acc.id);
            });
            tdAction.appendChild(btn);
            tr.appendChild(tdAction);

            tableBody.appendChild(tr);
        });
    }

    function addStatus(text, success) {
        var line = document.createElement("div");
        line.className = "status-line" + (success ? " status-success" : "");
        line.textContent = text;
        statusArea.appendChild(line);
        statusArea.scrollTop = statusArea.scrollHeight;
    }

    function openCheckoutModal(accountId) {
        activeAccountId = accountId;
        justificationField.value = "";
        checkoutSubmit.disabled = true;
        checkoutModal.classList.add("active");
    }

    justificationField.addEventListener("input", function () {
        checkoutSubmit.disabled = justificationField.value.trim().length < 5;
    });

    checkoutCancel.addEventListener("click", function () {
        checkoutModal.classList.remove("active");
        activeAccountId = null;
        renderTable();
    });

    checkoutSubmit.addEventListener("click", function () {
        checkoutSubmit.disabled = true;
        checkoutSubmit.textContent = "Approving...";
        addStatus("Access request submitted. Awaiting approval workflow...");
        setTimeout(function () {
            checkoutModal.classList.remove("active");
            checkoutSubmit.textContent = "Submit Request";
            approveCheckout();
        }, 2000);
    });

    function approveCheckout() {
        var acc = accounts.find(function (a) { return a.id === activeAccountId; });
        acc.status = "checked-out";
        addStatus("Request approved. Credential checked out to " + acc.name + ".", true);
        renderTable();

        sessionAccountLabel.textContent = acc.name;
        sessionPanel.classList.add("active");
        monitorPanel.innerHTML = "";
        monitorLinesShown = 0;
        monitorFinished = false;
        checkinBtn.disabled = true;
        sessionSecondsLeft = 20;
        updateTimerLabel();

        streamNextMonitorLine();

        if (sessionTimerInterval) clearInterval(sessionTimerInterval);
        sessionTimerInterval = setInterval(function () {
            sessionSecondsLeft -= 1;
            updateTimerLabel();
            if (sessionSecondsLeft <= 0) {
                clearInterval(sessionTimerInterval);
                if (acc.status === "checked-out") {
                    addStatus("Session window expired. Auto checking in credential...");
                    checkInCredential();
                }
            }
        }, 1000);
    }

    function updateTimerLabel() {
        var m = Math.floor(Math.max(sessionSecondsLeft, 0) / 60);
        var s = Math.max(sessionSecondsLeft, 0) % 60;
        sessionTimerLabel.textContent = "Session expires in: " + (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
    }

    function streamNextMonitorLine() {
        if (monitorLinesShown >= monitorLines.length) {
            monitorFinished = true;
            checkinBtn.disabled = false;
            return;
        }
        var lineEl = document.createElement("div");
        lineEl.className = "line";
        lineEl.textContent = monitorLines[monitorLinesShown];
        monitorPanel.appendChild(lineEl);
        monitorPanel.scrollTop = monitorPanel.scrollHeight;
        monitorLinesShown += 1;
        monitorTimeout = setTimeout(streamNextMonitorLine, 900);
    }

    checkinBtn.addEventListener("click", function () {
        checkInCredential();
    });

    function checkInCredential() {
        if (sessionTimerInterval) clearInterval(sessionTimerInterval);
        if (monitorTimeout) clearTimeout(monitorTimeout);

        var acc = accounts.find(function (a) { return a.id === activeAccountId; });
        if (!acc) return;

        acc.status = "available";
        acc.lastRotated = "just now";
        checkinBtn.disabled = true;

        addStatus("Credential checked in. Rotating password automatically...");
        setTimeout(function () {
            addStatus("Password rotated. Session recorded and closed.", true);
            sessionPanel.classList.remove("active");
            activeAccountId = null;
            cycleCompletedOnce = true;
            renderTable();
            revealFlag();
        }, 1400);
    }

    function revealFlag() {
        if (!monitorFinished) return;
        flagReveal.classList.add("active");
        flagReveal.scrollIntoView({ behavior: "smooth", block: "center" });
    }

    renderTable();

    // ================= SPOTLIGHT TUTORIAL SYSTEM =================
    var tutorialSteps = [
        { targetId: "vault-account-list", text: "This is the vault's account registry. Every privileged account here is stored and protected, similar to a safe deposit box registry at a bank. No one holds these credentials directly." },
        { targetId: "checkout-btn", text: "Clicking Check Out doesn't hand you a password. It submits a request to use one, the same way you'd sign out a key rather than being given a copy." },
        { targetId: "jit-justification-field", text: "This is a just-in-time access request. You must state why you need access before it's granted, and access is only ever granted for as long as the task requires.", needsModal: "checkout" },
        { targetId: "session-timer", text: "This countdown is your access window. Once it expires, access is automatically revoked, just like a visitor badge that stops working after your appointment ends.", needsPanel: true },
        { targetId: "session-monitor-panel", text: "Every action taken during this session is being recorded in real time, similar to a CCTV camera watching a server room door.", needsPanel: true },
        { targetId: "checkin-btn", text: "Checking in the credential immediately triggers an automatic password change, so the old password becomes useless the moment you're done.", needsPanel: true },
        { targetId: "flag-reveal", text: "The flag only appears once the session is fully closed and recorded. This models a real PAM system: access is never left open ended." }
    ];

    var currentStep = 0;
    var tutorialActive = false;
    var spotlight = document.getElementById("spotlight");
    var tooltipCard = document.getElementById("tooltip-card");
    var tooltipText = document.getElementById("tooltip-text");
    var tooltipNext = document.getElementById("tooltip-next");
    var tooltipSkip = document.getElementById("tooltip-skip");
    var tutorialBtn = document.getElementById("tutorial-btn");
    var completionModal = document.getElementById("completion-modal");
    var startChallengeBtn = document.getElementById("start-challenge-btn");

    function startTutorial() {
        tutorialActive = true;
        currentStep = 0;
        checkoutModal.classList.remove("active");
        sessionPanel.classList.remove("active");
        showStep();
    }

    function showStep() {
        var step = tutorialSteps[currentStep];
        if (!step) { finishTutorial(); return; }

        if (step.needsModal === "checkout") {
            checkoutModal.classList.add("active");
        }
        if (step.needsPanel) {
            checkoutModal.classList.remove("active");
            sessionPanel.classList.add("active");
        }
        if (!step.needsModal && !step.needsPanel && step.targetId !== "flag-reveal") {
            checkoutModal.classList.remove("active");
            sessionPanel.classList.remove("active");
        }

        if (step.targetId === "flag-reveal" && !cycleCompletedOnce) {
            flagReveal.style.display = "block";
        } else if (step.targetId !== "flag-reveal" && !cycleCompletedOnce) {
            flagReveal.style.display = "";
        }

        var el = document.getElementById(step.targetId);
        if (!el) { nextStep(); return; }

        var rect = el.getBoundingClientRect();
        if (rect.top < 0 || rect.bottom > window.innerHeight) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
            setTimeout(function () { positionSpotlight(el, step.text); }, 320);
        } else {
            positionSpotlight(el, step.text);
        }
    }

    function positionSpotlight(el, text) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlight.style.display = "block";
        spotlight.style.top = (rect.top - pad) + "px";
        spotlight.style.left = (rect.left - pad) + "px";
        spotlight.style.width = (rect.width + pad * 2) + "px";
        spotlight.style.height = (rect.height + pad * 2) + "px";

        tooltipText.textContent = text;
        tooltipCard.style.display = "block";

        var tooltipWidth = 300;
        var top = rect.bottom + 16;
        var left = rect.left;

        if (top + 140 > window.innerHeight) {
            top = rect.top - 160;
        }
        if (left + tooltipWidth > window.innerWidth) {
            left = window.innerWidth - tooltipWidth - 20;
        }
        if (left < 10) left = 10;
        if (top < 10) top = 10;

        tooltipCard.style.top = top + "px";
        tooltipCard.style.left = left + "px";
    }

    function nextStep() {
        currentStep += 1;
        if (currentStep >= tutorialSteps.length) {
            finishTutorial();
        } else {
            showStep();
        }
    }

    function finishTutorial() {
        tutorialActive = false;
        spotlight.style.display = "none";
        tooltipCard.style.display = "none";
        checkoutModal.classList.remove("active");
        sessionPanel.classList.remove("active");
        completionModal.classList.add("active");
    }

    function exitTutorial() {
        tutorialActive = false;
        spotlight.style.display = "none";
        tooltipCard.style.display = "none";
        checkoutModal.classList.remove("active");
        sessionPanel.classList.remove("active");
    }

    tooltipNext.addEventListener("click", nextStep);
    tooltipSkip.addEventListener("click", exitTutorial);
    tutorialBtn.addEventListener("click", startTutorial);
    startChallengeBtn.addEventListener("click", function () {
        completionModal.classList.remove("active");
    });

    window.addEventListener("resize", function () {
        if (!tutorialActive) return;
        var step = tutorialSteps[currentStep];
        if (!step) return;
        var el = document.getElementById(step.targetId);
        if (el) positionSpotlight(el, step.text);
    });

    // Auto start tutorial on first load
    window.addEventListener("load", function () {
        setTimeout(startTutorial, 500);
    });

})();
</script>
</body>
</html>
