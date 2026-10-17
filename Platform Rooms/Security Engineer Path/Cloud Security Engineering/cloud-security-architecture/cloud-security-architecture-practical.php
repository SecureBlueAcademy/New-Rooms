<?php
// cloud-security-architecture-practical.php
// Standalone static practical: Landing Zone Builder
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Landing Zone Builder</title>
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
}

.header {
    position: relative;
    padding: 28px 24px 20px 24px;
    background: linear-gradient(180deg, var(--bg-secondary), var(--bg-primary));
    border-bottom: 1px solid var(--border-default);
}
.header h1 {
    margin: 0 0 6px 0;
    font-size: 1.6rem;
    letter-spacing: 0.02em;
}
.header p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.95rem;
    max-width: 720px;
}
#tutorial-btn {
    position: absolute;
    top: 24px;
    right: 24px;
    background: var(--bg-surface);
    color: var(--accent-primary);
    border: 1px solid var(--accent-primary);
    padding: 9px 16px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
}
#tutorial-btn:hover { box-shadow: var(--glow-accent); }

.briefing {
    padding: 20px 24px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
}
.briefing h2 {
    font-size: 1.05rem;
    margin: 0 0 10px 0;
    color: var(--accent-primary);
}
.briefing p {
    margin: 0 0 8px 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    max-width: 800px;
    line-height: 1.5;
}

.workspace {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 0;
    min-height: 560px;
}
@media (max-width: 900px) {
    .workspace { grid-template-columns: 1fr; }
}

#account-palette {
    background: var(--bg-secondary);
    border-right: 1px solid var(--border-default);
    padding: 18px 14px;
}
#account-palette h3 {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin: 0 0 14px 0;
}
.palette-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 12px 10px;
    margin-bottom: 10px;
    cursor: grab;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--text-primary);
    user-select: none;
    transition: box-shadow 0.2s ease, opacity 0.2s ease;
}
.palette-card:hover { box-shadow: var(--glow-accent); }
.palette-card.used { opacity: 0.35; cursor: not-allowed; }
.palette-card .sub {
    display: block;
    font-weight: 400;
    color: var(--text-muted);
    font-size: 0.72rem;
    margin-top: 3px;
}

#guardrail-badge {
    margin-top: 20px;
    background: linear-gradient(135deg, #2a1f4a, #1a3a4a);
    border: 1px dashed var(--accent-secondary);
    border-radius: 8px;
    padding: 12px 10px;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--accent-secondary);
    cursor: grab;
    text-align: center;
    opacity: 0.4;
    pointer-events: none;
    transition: opacity 0.2s ease;
}
#guardrail-badge.enabled {
    opacity: 1;
    pointer-events: auto;
}
#guardrail-badge.attached {
    background: linear-gradient(135deg, #1a3a2a, #0f2a1f);
    border: 1px solid var(--success);
    color: var(--success);
    cursor: default;
    pointer-events: none;
}

#canvas-wrap { display: flex; flex-direction: column; }

.toolbar {
    display: flex;
    gap: 10px;
    align-items: center;
    padding: 12px 18px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-default);
}
.toolbar button {
    font-family: inherit;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 9px 16px;
    border-radius: 7px;
    cursor: pointer;
    border: 1px solid var(--border-default);
    background: var(--bg-surface);
    color: var(--text-primary);
    transition: all 0.2s ease;
}
#connect-mode-btn.active {
    background: var(--accent-secondary);
    color: #0b0f1a;
    border-color: var(--accent-secondary);
}
#validate-btn {
    background: var(--accent-primary);
    color: #0b0f1a;
    border-color: var(--accent-primary);
    margin-left: auto;
}
#validate-btn:hover { box-shadow: var(--glow-accent); }
.toolbar .hint {
    color: var(--text-muted);
    font-size: 0.78rem;
}

#canvas-area {
    position: relative;
    flex: 1;
    min-height: 460px;
    background:
        linear-gradient(var(--border-default) 1px, transparent 1px),
        linear-gradient(90deg, var(--border-default) 1px, transparent 1px);
    background-size: 40px 40px;
    background-color: var(--bg-primary);
    overflow: hidden;
}

.canvas-block {
    position: absolute;
    width: 150px;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 10px 10px;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--text-primary);
    cursor: grab;
    user-select: none;
    z-index: 3;
}
.canvas-block.bad { border-color: var(--error); box-shadow: 0 0 0 2px rgba(255,92,92,0.25); }
.canvas-block.connect-source { border-color: var(--accent-secondary); box-shadow: var(--glow-accent); }

#connection-svg {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 1;
}

.status-area {
    padding: 14px 18px;
    background: var(--bg-secondary);
    border-top: 1px solid var(--border-default);
    min-height: 20px;
    font-size: 0.85rem;
}
.status-area.ok { color: var(--success); }
.status-area.bad { color: var(--error); }
.status-area.neutral { color: var(--text-secondary); }

.flag-area {
    margin: 0 24px 24px 24px;
    padding: 20px;
    background: linear-gradient(135deg, #0f2a1f, #12182b);
    border: 1px solid var(--success);
    border-radius: 10px;
    display: none;
}
.flag-area.show { display: block; }
.flag-area h3 {
    margin: 0 0 8px 0;
    color: var(--success);
    font-size: 1rem;
}
.flag-value {
    font-family: "JetBrains Mono", monospace;
    font-size: 1.1rem;
    color: var(--accent-primary);
    background: var(--bg-primary);
    padding: 10px 14px;
    border-radius: 6px;
    display: inline-block;
    border: 1px solid var(--border-default);
}

/* Tutorial spotlight */
#spotlight {
    position: fixed;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.75);
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 1000;
    display: none;
}
#tooltip {
    position: fixed;
    max-width: 300px;
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 10px;
    padding: 16px;
    z-index: 1001;
    display: none;
    box-shadow: var(--glow-accent);
}
#tooltip p {
    margin: 0 0 12px 0;
    font-size: 0.85rem;
    color: var(--text-primary);
    line-height: 1.5;
}
#tooltip .tooltip-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
#tooltip button {
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}
#tooltip .next-btn { background: var(--accent-primary); color: #0b0f1a; }
#tooltip .skip-btn { background: transparent; color: var(--text-muted); }

#modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1002;
}
#modal-overlay.show { display: flex; }
.modal-box {
    background: var(--bg-surface);
    border: 1px solid var(--accent-primary);
    border-radius: 12px;
    padding: 28px;
    max-width: 380px;
    text-align: center;
}
.modal-box h3 { margin: 0 0 10px 0; color: var(--accent-primary); }
.modal-box p { color: var(--text-secondary); font-size: 0.9rem; margin: 0 0 18px 0; }
.modal-box button {
    background: var(--accent-primary);
    color: #0b0f1a;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="header">
    <h1>Landing Zone Builder</h1>
    <p>You are designing the account structure for a brand new cloud environment. Assemble the correct hierarchy, connect every account correctly, and attach the guardrail policy before deployment.</p>
    <button id="tutorial-btn">View Tutorial</button>
</div>

<div class="briefing">
    <h2>Mission Briefing</h2>
    <p>This environment represents an empty cloud organization awaiting its landing zone. Drag each account card from the palette onto the canvas, connect them into the correct parent child hierarchy using Connect Mode, then attach the Guardrail Policy badge to the Management Account so it cascades down to every child account.</p>
    <p>When your structure is complete, click Validate. Any incorrect placement or missing connection will be highlighted so you can fix it. Deploy successfully to reveal your flag.</p>
</div>

<div class="workspace">
    <div id="account-palette">
        <h3>Account Palette</h3>
        <div class="palette-card" draggable="true" data-type="management" id="management-block">
            Management Account
            <span class="sub">Root of the hierarchy</span>
        </div>
        <div class="palette-card" draggable="true" data-type="security">
            Security / Audit Account
            <span class="sub">Centralized guardrail audit</span>
        </div>
        <div class="palette-card" draggable="true" data-type="logarchive">
            Log Archive Account
            <span class="sub">Write-restricted log storage</span>
        </div>
        <div class="palette-card" draggable="true" data-type="sharedservices">
            Shared Services / Network Account
            <span class="sub">Hub for workload accounts</span>
        </div>
        <div class="palette-card" draggable="true" data-type="workloadprod">
            Workload Account (Production)
            <span class="sub">Live customer workloads</span>
        </div>
        <div class="palette-card" draggable="true" data-type="workloadnonprod">
            Workload Account (Non-Production)
            <span class="sub">Dev and test workloads</span>
        </div>

        <div id="guardrail-badge">
            🛡 Guardrail Policy
            <span class="sub" style="display:block;font-weight:400;font-size:0.7rem;margin-top:4px;">Drag onto Management Account</span>
        </div>
    </div>

    <div id="canvas-wrap">
        <div class="toolbar">
            <button id="connect-mode-btn">Connect Mode: Off</button>
            <span class="hint" id="connect-hint" style="display:none;">Click a parent account, then click its child account.</span>
            <button id="validate-btn">Validate Landing Zone</button>
        </div>
        <div id="canvas-area">
            <svg id="connection-svg"></svg>
        </div>
        <div class="status-area neutral" id="status-area">Place all six accounts on the canvas to begin building your hierarchy.</div>
    </div>
</div>

<div class="flag-area" id="flag-area">
    <h3>Deployment Successful</h3>
    <p style="color:var(--text-secondary); font-size:0.85rem; margin-bottom:14px;">Your landing zone hierarchy is correctly structured and guardrails are cascading from the Management Account. Flag revealed below.</p>
    <span class="flag-value" id="flag-value">CBX{landing_zone_deployed}</span>
</div>

<!-- Tutorial elements -->
<div id="spotlight"></div>
<div id="tooltip">
    <p id="tooltip-text"></p>
    <div class="tooltip-actions">
        <button class="skip-btn" id="skip-tutorial-btn">Skip Tutorial</button>
        <button class="next-btn" id="next-tutorial-btn">Next</button>
    </div>
</div>

<div id="modal-overlay">
    <div class="modal-box">
        <h3>Tutorial Complete</h3>
        <p>You're ready to start the challenge. Build your landing zone and deploy it to find the flag.</p>
        <button id="start-challenge-btn">Start Challenge</button>
    </div>
</div>

<script>
(function() {
    "use strict";

    // ---------- Data model ----------
    var REQUIRED_TYPES = ["management","security","logarchive","sharedservices","workloadprod","workloadnonprod"];
    var REQUIRED_CONNECTIONS = [
        ["management","security"],
        ["management","logarchive"],
        ["management","sharedservices"],
        ["sharedservices","workloadprod"],
        ["sharedservices","workloadnonprod"]
    ];
    var LABELS = {
        management: "Management Account",
        security: "Security / Audit Account",
        logarchive: "Log Archive Account",
        sharedservices: "Shared Services / Network Account",
        workloadprod: "Workload Account (Production)",
        workloadnonprod: "Workload Account (Non-Production)"
    };

    var placedBlocks = {}; // type -> {el, x, y}
    var connections = []; // [{parent, child, el}]
    var guardrailAttached = false;
    var connectMode = false;
    var connectSource = null;

    var canvas = document.getElementById("canvas-area");
    var svg = document.getElementById("connection-svg");
    var statusArea = document.getElementById("status-area");
    var connectBtn = document.getElementById("connect-mode-btn");
    var connectHint = document.getElementById("connect-hint");
    var validateBtn = document.getElementById("validate-btn");
    var guardrailBadge = document.getElementById("guardrail-badge");
    var flagArea = document.getElementById("flag-area");

    function setStatus(msg, kind) {
        statusArea.textContent = msg;
        statusArea.className = "status-area " + (kind || "neutral");
    }

    function nextDefaultPosition() {
        var count = Object.keys(placedBlocks).length;
        var col = count % 3;
        var row = Math.floor(count / 3);
        return { x: 40 + col * 190, y: 30 + row * 120 };
    }

    function createCanvasBlock(type, x, y) {
        var el = document.createElement("div");
        el.className = "canvas-block";
        el.textContent = LABELS[type];
        el.style.left = x + "px";
        el.style.top = y + "px";
        el.dataset.type = type;
        canvas.appendChild(el);
        placedBlocks[type] = { el: el, x: x, y: y };
        makeBlockDraggable(el);
        el.addEventListener("click", function(e) {
            if (connectMode) handleConnectClick(type, el);
        });
        return el;
    }

    function makeBlockDraggable(el) {
        var dragging = false, offsetX = 0, offsetY = 0;
        el.addEventListener("mousedown", function(e) {
            if (connectMode) return;
            dragging = true;
            var rect = el.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
            e.preventDefault();
        });
        document.addEventListener("mousemove", function(e) {
            if (!dragging) return;
            var canvasRect = canvas.getBoundingClientRect();
            var newX = e.clientX - canvasRect.left - offsetX;
            var newY = e.clientY - canvasRect.top - offsetY;
            newX = Math.max(0, Math.min(newX, canvas.clientWidth - el.offsetWidth));
            newY = Math.max(0, Math.min(newY, canvas.clientHeight - el.offsetHeight));
            el.style.left = newX + "px";
            el.style.top = newY + "px";
            var type = el.dataset.type;
            placedBlocks[type].x = newX;
            placedBlocks[type].y = newY;
            redrawConnections();
        });
        document.addEventListener("mouseup", function() {
            dragging = false;
        });
    }

    function handleConnectClick(type, el) {
        if (!connectSource) {
            connectSource = type;
            el.classList.add("connect-source");
            setStatus("Now click the child account to connect it to " + LABELS[type] + ".", "neutral");
            return;
        }
        if (connectSource === type) {
            // deselect
            el.classList.remove("connect-source");
            connectSource = null;
            return;
        }
        // create connection
        var exists = connections.some(function(c) {
            return (c.parent === connectSource && c.child === type) ||
                   (c.parent === type && c.child === connectSource);
        });
        if (!exists) {
            connections.push({ parent: connectSource, child: type });
            redrawConnections();
            setStatus("Connected " + LABELS[connectSource] + " to " + LABELS[type] + ".", "neutral");
        } else {
            setStatus("These accounts are already connected.", "neutral");
        }
        var srcEl = placedBlocks[connectSource].el;
        srcEl.classList.remove("connect-source");
        connectSource = null;
    }

    function redrawConnections() {
        svg.innerHTML = "";
        connections.forEach(function(c) {
            drawLine(c.parent, c.child, false);
        });
        if (guardrailAttached) {
            REQUIRED_CONNECTIONS.forEach(function(pair) {
                var hasParent = placedBlocks[pair[0]];
                var hasChild = placedBlocks[pair[1]];
                var isConnected = connections.some(function(c) {
                    return (c.parent === pair[0] && c.child === pair[1]);
                });
                if (hasParent && hasChild && isConnected) {
                    drawLine(pair[0], pair[1], true);
                }
            });
        }
    }

    function drawLine(typeA, typeB, dashed) {
        var a = placedBlocks[typeA], b = placedBlocks[typeB];
        if (!a || !b) return;
        var ax = a.x + a.el.offsetWidth / 2;
        var ay = a.y + a.el.offsetHeight / 2;
        var bx = b.x + b.el.offsetWidth / 2;
        var by = b.y + b.el.offsetHeight / 2;
        var line = document.createElementNS("http://www.w3.org/2000/svg", "line");
        line.setAttribute("x1", ax);
        line.setAttribute("y1", ay);
        line.setAttribute("x2", bx);
        line.setAttribute("y2", by);
        line.setAttribute("stroke", dashed ? "var(--accent-secondary)" : "var(--text-secondary)");
        line.setAttribute("stroke-width", dashed ? "2" : "1.5");
        if (dashed) line.setAttribute("stroke-dasharray", "5 4");
        svg.appendChild(line);
    }

    // ---------- Palette drag to place ----------
    document.querySelectorAll(".palette-card").forEach(function(card) {
        card.addEventListener("mousedown", function(e) {
            var type = card.dataset.type;
            if (placedBlocks[type]) return; // already placed
            var pos = nextDefaultPosition();
            createCanvasBlock(type, pos.x, pos.y);
            card.classList.add("used");
            checkGuardrailEnable();
            updateStatusOnPlacement();
        });
    });

    function updateStatusOnPlacement() {
        var count = Object.keys(placedBlocks).length;
        if (count < 6) {
            setStatus(count + " of 6 accounts placed. Click a palette card to add it to the canvas.", "neutral");
        } else {
            setStatus("All accounts placed. Use Connect Mode to build the hierarchy, then attach the guardrail policy.", "neutral");
        }
    }

    function checkGuardrailEnable() {
        if (placedBlocks["management"]) {
            guardrailBadge.classList.add("enabled");
        }
    }

    // ---------- Guardrail badge attach ----------
    guardrailBadge.addEventListener("mousedown", function(e) {
        if (!guardrailBadge.classList.contains("enabled") || guardrailAttached) return;
        if (!placedBlocks["management"]) return;
        guardrailAttached = true;
        guardrailBadge.classList.add("attached");
        guardrailBadge.querySelector(".sub").textContent = "Attached to Management Account";
        redrawConnections();
        setStatus("Guardrail policy attached to Management Account.", "neutral");
    });

    // ---------- Connect mode toggle ----------
    connectBtn.addEventListener("click", function() {
        connectMode = !connectMode;
        connectBtn.textContent = "Connect Mode: " + (connectMode ? "On" : "Off");
        connectBtn.classList.toggle("active", connectMode);
        connectHint.style.display = connectMode ? "inline" : "none";
        if (!connectMode && connectSource) {
            placedBlocks[connectSource].el.classList.remove("connect-source");
            connectSource = null;
        }
    });

    // ---------- Validate ----------
    validateBtn.addEventListener("click", function() {
        document.querySelectorAll(".canvas-block").forEach(function(el) {
            el.classList.remove("bad");
        });

        var placedTypes = Object.keys(placedBlocks);
        var missingTypes = REQUIRED_TYPES.filter(function(t) { return placedTypes.indexOf(t) === -1; });
        if (missingTypes.length > 0) {
            setStatus("Not all accounts are placed yet. Add every account from the palette to the canvas.", "bad");
            return;
        }

        var missingConnections = REQUIRED_CONNECTIONS.filter(function(pair) {
            return !connections.some(function(c) { return c.parent === pair[0] && c.child === pair[1]; });
        });
        if (missingConnections.length > 0) {
            missingConnections.forEach(function(pair) {
                if (placedBlocks[pair[0]]) placedBlocks[pair[0]].el.classList.add("bad");
                if (placedBlocks[pair[1]]) placedBlocks[pair[1]].el.classList.add("bad");
            });
            setStatus("Some accounts are not connected correctly. Check the highlighted accounts and their hierarchy.", "bad");
            return;
        }

        var extraConnections = connections.filter(function(c) {
            return !REQUIRED_CONNECTIONS.some(function(pair) { return pair[0] === c.parent && pair[1] === c.child; });
        });
        if (extraConnections.length > 0) {
            extraConnections.forEach(function(c) {
                if (placedBlocks[c.parent]) placedBlocks[c.parent].el.classList.add("bad");
                if (placedBlocks[c.child]) placedBlocks[c.child].el.classList.add("bad");
            });
            setStatus("Some connections do not match a valid landing zone hierarchy. Check the highlighted accounts.", "bad");
            return;
        }

        if (!guardrailAttached) {
            placedBlocks["management"].el.classList.add("bad");
            setStatus("The guardrail policy has not been attached to the Management Account yet.", "bad");
            return;
        }

        setStatus("Landing zone validated successfully.", "ok");
        flagArea.classList.add("show");
        flagArea.scrollIntoView({ behavior: "smooth", block: "center" });
    });

    // ---------- Tutorial spotlight system ----------
    var tutorialSteps = [
        { id: "account-palette", text: "This is your account palette. Each card represents an AWS or Azure account type you will use to build a secure landing zone." },
        { id: "canvas-area", text: "This is your landing zone canvas. Click an account card in the palette to place it here, then drag it into position." },
        { id: "management-block", text: "The Management Account is the root of every landing zone. It is where organization wide guardrails are defined and enforced." },
        { id: "connect-mode-btn", text: "Use Connect Mode to draw hierarchy lines between accounts, just like setting up organizational units in a real cloud account structure." },
        { id: "guardrail-badge", text: "This Guardrail Policy badge represents a Service Control Policy or Azure Policy. Attach it to the Management Account so it cascades down to every child account." },
        { id: "validate-btn", text: "When you think your landing zone is correctly structured, click Validate to check your work." },
        { id: "tutorial-btn", text: "You can replay this tutorial anytime using this button." }
    ];
    var currentStep = 0;
    var spotlight = document.getElementById("spotlight");
    var tooltip = document.getElementById("tooltip");
    var tooltipText = document.getElementById("tooltip-text");
    var modalOverlay = document.getElementById("modal-overlay");

    function startTutorial() {
        currentStep = 0;
        showStep(currentStep);
    }

    function showStep(index) {
        if (index >= tutorialSteps.length) {
            endTutorial();
            return;
        }
        var step = tutorialSteps[index];
        var el = document.getElementById(step.id);
        if (!el) { showStep(index + 1); return; }

        var rect = el.getBoundingClientRect();
        var inView = rect.top >= 0 && rect.bottom <= window.innerHeight;
        if (!inView) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
            setTimeout(function() { positionSpotlight(el, step); }, 300);
        } else {
            positionSpotlight(el, step);
        }
    }

    function positionSpotlight(el, step) {
        var rect = el.getBoundingClientRect();
        var pad = 8;
        spotlight.style.display = "block";
        spotlight.style.top = (rect.top - pad) + "px";
        spotlight.style.left = (rect.left - pad) + "px";
        spotlight.style.width = (rect.width + pad * 2) + "px";
        spotlight.style.height = (rect.height + pad * 2) + "px";

        tooltipText.textContent = step.text;
        tooltip.style.display = "block";

        var tw = 300;
        var spaceBelow = window.innerHeight - rect.bottom;
        var spaceRight = window.innerWidth - rect.right;
        var top, left;

        if (spaceBelow > 160) {
            top = rect.bottom + 14;
            left = Math.min(Math.max(rect.left, 10), window.innerWidth - tw - 10);
        } else if (rect.top > 160) {
            top = rect.top - 14;
            tooltip.style.transform = "translateY(-100%)";
            left = Math.min(Math.max(rect.left, 10), window.innerWidth - tw - 10);
        } else if (spaceRight > tw + 20) {
            top = Math.max(10, rect.top);
            left = rect.right + 14;
            tooltip.style.transform = "none";
        } else {
            top = Math.max(10, rect.top);
            left = Math.max(10, rect.left - tw - 14);
            tooltip.style.transform = "none";
        }
        if (spaceBelow > 160 || (!(rect.top > 160) && spaceRight <= tw + 20)) {
            tooltip.style.transform = "none";
        }
        tooltip.style.top = top + "px";
        tooltip.style.left = left + "px";
    }

    function endTutorial() {
        spotlight.style.display = "none";
        tooltip.style.display = "none";
        modalOverlay.classList.add("show");
    }

    document.getElementById("next-tutorial-btn").addEventListener("click", function() {
        currentStep++;
        showStep(currentStep);
    });
    document.getElementById("skip-tutorial-btn").addEventListener("click", function() {
        endTutorial();
    });
    document.getElementById("start-challenge-btn").addEventListener("click", function() {
        modalOverlay.classList.remove("show");
    });
    document.getElementById("tutorial-btn").addEventListener("click", function() {
        startTutorial();
    });
    window.addEventListener("resize", function() {
        if (spotlight.style.display === "block") {
            var step = tutorialSteps[currentStep];
            var el = step ? document.getElementById(step.id) : null;
            if (el) positionSpotlight(el, step);
        }
    });

    // Auto-start tutorial on load
    window.addEventListener("load", function() {
        setTimeout(startTutorial, 400);
    });
})();
</script>

</body>
</html>
