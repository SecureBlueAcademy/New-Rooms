<?php
// Filename: edr-deployment-tuning.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'edr-deployment-tuning',
    'title'           => 'EDR Deployment & Tuning',
    'description'     => 'Learn how to deploy an EDR platform across an enterprise fleet and tune it to catch real attacks without drowning analysts in noise.',
    'icon'            => 'fas fa-shield-virus',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic endpoint security concepts', 'Basic SOC or blue team fundamentals'],
    'learning_objectives' => [
        'Explain what EDR does architecturally and how it differs from traditional antivirus',
        'Plan a phased sensor rollout across an enterprise fleet',
        'Design exclusion policies that are scoped as narrowly as possible',
        'Choose between detect-only and prevent mode appropriately',
        'Tune detection rules to reduce false positives without creating exploitable gaps',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/edr-deployment-tuning-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is EDR?'],
    ['id' => 'task3', 'title' => 'Deploying Sensors Across the Fleet'],
    ['id' => 'task4', 'title' => 'Designing Exclusion Policies'],
    ['id' => 'task5', 'title' => 'Detect-Only vs Prevent Mode'],
    ['id' => 'task6', 'title' => 'Tuning Detection Rules'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'edr_deployment_tuning_progress',
    'instagram_takeaways'  => [
        '✓ EDR is behavioral, not just signature based',
        '✓ Roll out sensors in validated waves, not all at once',
        '✓ Scope exclusions as narrowly as possible',
        '✓ Move groups from detect-only to prevent only after validation',
        '✓ Tune carefully, over-suppression creates detection gaps',
    ],
];

// ========================
// 5. QUESTIONS DATA
// ========================
$task_questions_data = [
    'task1' => [
        ['id' => 'q0', 'text' => 'Type <strong>"yes"</strong> to complete this task.'],
    ],
    'task2' => [
        ['id' => 'q1', 'text' => 'What does the acronym EDR stand for?'],
        ['id' => 'q2', 'text' => 'What type of detection method does traditional antivirus primarily rely on?'],
        ['id' => 'q3', 'text' => 'What do we call software installed directly on an endpoint that collects telemetry for EDR?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What term describes deploying a sensor to a small test group before the full fleet?'],
        ['id' => 'q5', 'text' => 'What do we call deploying software in successive stages to the fleet rather than all at once?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What security principle should guide how narrowly an exclusion is scoped?'],
        ['id' => 'q7', 'text' => 'Which exclusion type ties an exclusion to a file\'s cryptographic value rather than its location?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'Which EDR response mode logs an alert without blocking the action?'],
        ['id' => 'q9', 'text' => 'Which EDR response mode actively blocks or kills malicious activity?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What is the term for reducing alert noise by scoping down a detection rule rather than disabling it?'],
        ['id' => 'q11', 'text' => 'What do we call a blind spot created when a detection rule is suppressed too broadly?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the Tuning Console.'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Endpoint Detection and Response platforms watch what happens on a machine after something has already run, not just what a file looks like before it executes. That distinction is what separates a security team that catches an attacker mid-attack from one that only finds out after the damage is done. Deploying an EDR agent is easy. Deploying it well, across thousands of endpoints with different roles and risk levels, is what actually determines whether it works.</p>

    <p>By the end of this room you will be able to plan a phased sensor rollout across a fleet, design exclusion policies that do not leave the door wide open for attackers, choose between detect-only and prevent mode with confidence, and tune noisy detection rules without quietly creating gaps in coverage. A hands-on tuning console is included so you can practice these decisions directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what EDR does architecturally and how it differs from traditional antivirus.</li>
        <li>Plan a phased sensor rollout across an enterprise fleet.</li>
        <li>Design exclusion policies that are scoped as narrowly as possible.</li>
        <li>Choose between detect-only and prevent mode appropriately.</li>
        <li>Tune detection rules to reduce false positives without creating exploitable gaps.</li>
    </ul>
</div>
HTML;

// TASK 2: What is EDR?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Watching, Not Just Scanning</h2>

    <p>Traditional antivirus works mostly by checking files against a list of known bad signatures before letting them run. It is fast and cheap, but it only catches what it already recognizes. EDR takes a different approach: it continuously watches process behavior on the endpoint, sends that telemetry to a central console, and gives an analyst the ability to investigate and respond, even to attacks nobody has seen before.</p>

    <p>Think of traditional antivirus as a lock on the front door. It stops known intruders from walking straight in. EDR is more like a camera system paired with a guard who can act. It cannot always stop someone from getting inside, but it sees what they do once they are there and can intervene.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Most enterprises run EDR alongside antivirus rather than replacing it. Antivirus catches the easy, known threats cheaply. EDR catches the behaviors that slip past signatures entirely.</p>
    </div>

    <h3>EDR vs Traditional Antivirus</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>Traditional Antivirus</th>
                <th>EDR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Detection Method</td>
                <td>Signature matching against known malware</td>
                <td>Continuous behavioral monitoring</td>
            </tr>
            <tr>
                <td>Response Capability</td>
                <td>Block or quarantine on match</td>
                <td>Alert, investigate, isolate, kill process remotely</td>
            </tr>
            <tr>
                <td>Visibility</td>
                <td>Limited to scan events</td>
                <td>Full process, network, and file activity timeline</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: EDR architecture pipeline
         Teaching purpose: show the learner that data flows through a pipeline from sensor to console to analyst,
         which they would otherwise misunderstand as the sensor deciding and acting entirely on its own. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="EDR architecture pipeline from sensor to analyst">
            <rect x="10"  y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="305" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="600" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="180" y1="70" x2="300" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arredr)"/>
            <line x1="475" y1="70" x2="595" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arredr)"/>
            <defs>
                <marker id="arredr" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="95"  y="62" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Endpoint Sensor</text>
            <text x="95"  y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Collects telemetry</text>
            <text x="390" y="62" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Management Console</text>
            <text x="390" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Aggregates and correlates</text>
            <text x="685" y="62" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Analyst</text>
            <text x="685" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Investigates and responds</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Deploying Sensors Across the Fleet
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Rolling Out Without Breaking Things</h2>

    <p>Pushing an EDR sensor to every endpoint in the company on day one sounds efficient, but it is how outages happen. A rollout should move in waves, starting small and expanding only once each wave is validated.</p>

    <p>Deployment usually happens through existing management tooling such as Group Policy, Intune, or SCCM, which push the sensor silently in the background. A small pilot group goes first, typically IT and security staff who can quickly report problems. Only after that pilot is stable does the rollout expand to broader waves, and finally to the full fleet, including harder cases like legacy or often-offline machines.</p>

    <div class="info-box warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Common Mistake</h4>
        <p>Enabling full prevent mode fleet-wide before validation is a common cause of outages. A legacy application that behaves unusually can get blocked outright, taking a business-critical system down with it.</p>
    </div>

    <h3>Deployment Method Comparison</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>Best For</th>
                <th>Limitation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Group Policy</td>
                <td>Domain-joined Windows fleets</td>
                <td>Requires reboot or policy refresh cycle</td>
            </tr>
            <tr>
                <td>Intune / SCCM</td>
                <td>Mixed and remote fleets</td>
                <td>Depends on endpoint checking in regularly</td>
            </tr>
            <tr>
                <td>Manual Install</td>
                <td>Small pilot groups or isolated systems</td>
                <td>Does not scale to large fleets</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: rollout wave diagram
         Teaching purpose: show deployment as a validated progression through waves,
         which learners would otherwise misunderstand as a single one-time push. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Phased rollout wave progression">
            <rect x="10"  y="25" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="220" y="25" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="430" y="25" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="620" y="25" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="160" y1="60" x2="215" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrwave)"/>
            <line x1="370" y1="60" x2="425" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrwave)"/>
            <line x1="580" y1="60" x2="615" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrwave)"/>
            <defs>
                <marker id="arrwave" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="85"  y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Pilot Group</text>
            <text x="295" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Wave 1</text>
            <text x="505" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Wave 2</text>
            <text x="695" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Full Fleet</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Designing Exclusion Policies
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Every Exclusion is a Door</h2>

    <p>Exclusions exist for good reasons. Some legitimate software touches thousands of files quickly, or performs actions that look suspicious to a behavioral engine even though they are harmless. Excluding that activity reduces noise and protects performance. But every exclusion is also a path an attacker could walk through if they learn it exists.</p>

    <p>The safest exclusions are the narrowest ones. Excluding by hash covers exactly one specific file. Excluding by path or by process name covers far more ground than necessary, and an attacker who discovers an excluded folder can simply drop their tools there.</p>

    <div class="info-box warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Why Scope Matters</h4>
        <p>Attackers actively look for excluded paths once they gain a foothold. A broad, unscoped exclusion can turn into a permanent blind spot they can reuse indefinitely.</p>
    </div>

    <h3>Exclusion Type Comparison</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Precision</th>
                <th>Risk if Abused</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Hash</td>
                <td>Highest, covers one exact file</td>
                <td>Low, a changed file no longer matches</td>
            </tr>
            <tr>
                <td>Publisher</td>
                <td>Medium, covers all files signed by that publisher</td>
                <td>Moderate, depends on publisher trustworthiness</td>
            </tr>
            <tr>
                <td>Path</td>
                <td>Low, covers everything in that folder</td>
                <td>High, attacker can drop tools in the excluded path</td>
            </tr>
            <tr>
                <td>Process Name</td>
                <td>Low, covers any file using that name</td>
                <td>High, easy for an attacker to rename a tool to match</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 5: Detect-Only vs Prevent Mode
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Two Modes, Different Jobs</h2>

    <p>Detect-only mode logs and alerts on suspicious activity without taking any blocking action. Prevent mode actively stops the activity, killing a process or blocking a file from executing. Neither mode is permanently correct for every group of endpoints. The right choice depends on how well validated that group's behavior is.</p>

    <p>A newly deployed group should usually start in detect-only. This lets the team see what normal activity looks like on those machines without risking a false block breaking something important. Once that baseline is understood and confirmed safe, the group can graduate to prevent mode. Leaving a mature, well-understood group in detect-only indefinitely means real attacks there will only be logged, not stopped.</p>

    <h3>Detect-Only vs Prevent</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Mode</th>
                <th>Behavior</th>
                <th>Risk</th>
                <th>Best Used For</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Detect-Only</td>
                <td>Logs and alerts, takes no action</td>
                <td>Real attacks are not stopped, only recorded</td>
                <td>New or unvalidated endpoint groups</td>
            </tr>
            <tr>
                <td>Prevent</td>
                <td>Blocks or kills the malicious action</td>
                <td>Can break legitimate but unusual software</td>
                <td>Mature groups with a validated baseline</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: maturity path from detect-only to prevent
         Teaching purpose: show the two modes as stages in a validation path,
         which learners would otherwise misunderstand as a permanent either/or choice. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Response mode maturity path">
            <rect x="10"  y="25" width="180" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="25" width="180" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="590" y="25" width="180" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="190" y1="60" x2="295" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrmode)"/>
            <line x1="480" y1="60" x2="585" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrmode)"/>
            <defs>
                <marker id="arrmode" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="100" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">New Deployment</text>
            <text x="100" y="75" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Detect-Only</text>
            <text x="390" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Validation Period</text>
            <text x="390" y="75" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Baseline confirmed</text>
            <text x="680" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Mature Group</text>
            <text x="680" y="75" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Prevent Mode</text>
        </svg>
    </div>
</div>
HTML;

// TASK 6: Tuning Detection Rules
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Cutting Noise Without Cutting Coverage</h2>

    <p>False positives usually come from the same handful of causes: signed but unusual software, legitimate admin tools used the way admins actually use them, or a rule written too broadly in the first place. The fix is almost never to disable the rule outright. It is to scope it down so it stops firing on the specific known-good case while still catching everything else.</p>

    <p>Tuning too aggressively creates the opposite problem. If a rule is suppressed broadly enough, an attacker who mimics that exact known-good pattern can slip through completely undetected. A useful mental model is a smoke alarm. Turning the sensitivity down so it stops going off from toast also means it may stop catching a real fire.</p>

    <div class="info-box warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> The Hidden Cost of Over-Tuning</h4>
        <p>Suppressing a rule too broadly to silence noise can create a permanent detection gap for that exact technique, one that will not be visible again until it is exploited.</p>
    </div>

    <h3>Before and After Tuning</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Original Alert</th>
                <th>Incorrect Fix</th>
                <th>Correct Fix</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Backup software triggers on mass file access</td>
                <td>Disable the mass file access rule fleet-wide</td>
                <td>Exclude the backup software's exact hash only</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>The fleet's EDR console is generating a wave of alerts and the on-call analyst seat is yours. Eight live alerts are waiting for triage, each with a process name, file path, and reputation data attached.</p>

    <p>Review each alert carefully, check its reputation panel, and decide whether it should be excluded, left in detect-only, or left in full prevent mode. Get all eight right to reduce the fleet's false-positive rate and reveal the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="edr-deployment-tuning-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Tuning Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Deploying EDR well comes down to a series of deliberate decisions rather than a single install step. Rolling sensors out in validated waves protects the business from unnecessary outages. Scoping exclusions narrowly keeps legitimate performance fixes from becoming attacker hiding spots. Moving groups from detect-only to prevent only after validation balances safety with real protection. Tuning rules carefully keeps the noise down without opening the exact gaps attackers are hoping to find.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>EDR relies on continuous behavioral monitoring, not just signature matching.</li>
        <li>Sensor rollouts should move through validated waves, not a single fleet-wide push.</li>
        <li>Exclusions should be scoped as narrowly as possible, hash over path where feasible.</li>
        <li>Detect-only is a validation stage, prevent mode is the mature end state.</li>
        <li>Tuning should scope rules down carefully rather than disabling them outright.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
