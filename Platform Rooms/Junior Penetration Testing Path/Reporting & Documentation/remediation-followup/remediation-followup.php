<?php
// ============================================================
// remediation-followup.php — CYBRIXEN ROOM DATA FILE
// Topic: Remediation Recommendations & Follow-Up
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'remediation-followup',
    'title'           => 'Remediation Recommendations & Follow-Up',
    'description'     => 'Learn to write actionable remediation guidance, set realistic remediation windows, and distinguish a fix from a workaround from an accepted risk.',
    'icon'            => 'fas fa-clipboard-check',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic vulnerability assessment knowledge', 'Familiarity with pentest reporting basics'],
    'learning_objectives' => [
        'Write remediation guidance an engineer can act on without guesswork',
        'Apply remediation windows based on severity and business context',
        'Distinguish a fix from a workaround from an accepted risk',
        'Explain the purpose of verification testing',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/remediation-followup-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Writing Actionable Remediation Guidance'],
    ['id' => 'task3', 'title' => 'Remediation Windows and Prioritization'],
    ['id' => 'task4', 'title' => 'Fix, Workaround, or Accepted Risk'],
    ['id' => 'task5', 'title' => 'Practical'],
    ['id' => 'task6', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'remediation_followup_progress',
    'instagram_takeaways'  => [
        '✓ Actionable remediation guidance names the fix, its location, and how it will be verified',
        '✓ Remediation windows scale with severity, not a one size fits all deadline',
        '✓ Fix, workaround, and accepted risk are three distinct outcomes for a finding',
        '✓ Verification testing confirms a fix actually worked',
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
        ['id' => 'q1', 'text' => 'What is the term for remediation advice that specifies the exact fix, its location, and how it will be verified?'],
        ['id' => 'q2', 'text' => 'What database technique is commonly recommended to prevent SQL injection?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the typical remediation window for a critical severity finding?'],
        ['id' => 'q4', 'text' => 'What factor primarily determines the length of a remediation window?'],
        ['id' => 'q5', 'text' => 'What can justify adjusting a remediation window without eliminating it entirely?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What term describes a temporary measure that reduces risk without fully resolving a vulnerability?'],
        ['id' => 'q7', 'text' => 'What term describes a formal business decision not to remediate a vulnerability?'],
        ['id' => 'q8', 'text' => 'What type of testing confirms a vulnerability has actually been resolved?'],
    ],
    'task5' => [
        ['id' => 'q9', 'text' => 'Enter the flag revealed after completing the Remediation Ticket Simulator.'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>A pentest report is only as useful as the remediation guidance it contains. A finding that simply says "fix this vulnerability" leaves the engineering team guessing about what to change, where to change it, and how to confirm the change actually worked. Strong remediation guidance closes that gap and turns a report into something a team can execute immediately.</p>

    <p>In this room you will learn how to write remediation recommendations that engineers can act on without guesswork, how to set a remediation window that reflects both severity and business context, and how to tell a fix apart from a workaround and an accepted risk. A hands on practical is included so you can apply these decisions to real findings.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Write remediation guidance an engineer can act on without guesswork.</li>
        <li>Apply remediation windows based on severity and business context.</li>
        <li>Distinguish a fix from a workaround from an accepted risk.</li>
        <li>Explain the purpose of verification testing.</li>
    </ul>
</div>
HTML;

// TASK 2: Writing Actionable Remediation Guidance
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>From Diagnosis to Prescription</h2>

    <p>A vulnerability finding describes a problem. Remediation guidance describes the solution. Naming the problem is not the same as telling engineering how to fix it, and the two are often confused in weak reports.</p>

    <p>Think of a doctor's visit. A diagnosis tells you what is wrong. A prescription tells you exactly what to do about it, including the dose and how long to take it. A remediation recommendation should read like a prescription, not a diagnosis.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What Good Remediation Guidance Includes</h4>
        <p>A strong recommendation names the specific change required, where in the system it applies, and how the fix will be verified once complete. Leaving out any one of these forces the engineering team to fill in the gaps themselves.</p>
    </div>

    <h3>Vague vs Actionable</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Vague Recommendation</th>
                <th>Actionable Recommendation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Fix the SQL injection</td>
                <td>Use parameterized queries for all database calls in the login and search modules</td>
            </tr>
            <tr>
                <td>Improve password security</td>
                <td>Enforce a minimum password length of 12 characters and block the 10,000 most common passwords at signup</td>
            </tr>
            <tr>
                <td>Patch the server</td>
                <td>Apply vendor security update KB-4521 to the web server and restart the service during the next maintenance window</td>
            </tr>
            <tr>
                <td>Restrict access</td>
                <td>Remove write permissions for the contractors group on the finance directory</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 3: Remediation Windows and Prioritization
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Setting the Clock</h2>

    <p>A remediation window is the amount of time an organization has to resolve a finding before it is considered overdue. Windows exist so that critical issues get urgent attention while lower risk issues do not consume resources that are better spent elsewhere.</p>

    <p>The length of a window is driven primarily by severity. A critical finding that is actively exploitable deserves days, not months. A low severity finding with limited impact can reasonably wait longer.</p>

    <h3>Typical Remediation Windows</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Severity</th>
                <th>Typical Window</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Critical</td><td>7 days</td></tr>
            <tr><td>High</td><td>30 days</td></tr>
            <tr><td>Medium</td><td>90 days</td></tr>
            <tr><td>Low</td><td>180 days</td></tr>
        </tbody>
    </table>

    <!-- SVG: severity to window timeline
         Teaching purpose: show the learner that remediation windows scale directly
         with severity, which they would otherwise misunderstand as a fixed,
         one size fits all deadline. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Severity mapped to remediation window">
            <!-- Timeline base -->
            <line x1="40" y1="70" x2="720" y2="70" stroke="var(--border)" stroke-width="2"/>
            <!-- Critical -->
            <circle cx="100" cy="70" r="8" fill="var(--primary)"/>
            <text x="100" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Critical</text>
            <text x="100" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">7 days</text>
            <!-- High -->
            <circle cx="280" cy="70" r="8" fill="var(--primary)"/>
            <text x="280" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">High</text>
            <text x="280" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">30 days</text>
            <!-- Medium -->
            <circle cx="470" cy="70" r="8" fill="var(--primary)"/>
            <text x="470" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Medium</text>
            <text x="470" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">90 days</text>
            <!-- Low -->
            <circle cx="660" cy="70" r="8" fill="var(--primary)"/>
            <text x="660" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Low</text>
            <text x="660" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">180 days</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Business Context Can Adjust, Not Erase</h4>
        <p>Compliance deadlines, active exploitation, or available compensating controls can justify shortening or lengthening a window. Business context never removes the window entirely for a finding that is being fixed or worked around.</p>
    </div>
</div>
HTML;

// TASK 4: Fix, Workaround, or Accepted Risk
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Three Ways to Close a Finding</h2>

    <p>Not every finding ends the same way. A fix removes the vulnerability. A workaround reduces the risk without fully resolving it. An accepted risk is a formal decision not to remediate at all.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Fix</th>
                <th>Workaround</th>
                <th>Accepted Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Removes the vulnerability entirely</td>
                <td>Reduces risk temporarily without resolving it</td>
                <td>Formal decision not to remediate</td>
            </tr>
            <tr>
                <td>Verified by re-testing</td>
                <td>Verified by re-testing</td>
                <td>Verified by evidence review</td>
            </tr>
            <tr>
                <td>Example: patch applied and service updated</td>
                <td>Example: account disabled while a full overhaul is scheduled</td>
                <td>Example: legacy protocol kept with compensating controls</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>A workaround is never the final state. It should always come with a follow up plan toward a full fix.</p>
    </div>

    <p>Consider a load balancer still running an outdated TLS version because a legacy client cannot be upgraded. Network segmentation and monitoring are already in place, and the business formally accepts the residual risk rather than pursuing a fix that would break the legacy client. This is an accepted risk, not a workaround, because there is no plan to change it.</p>
</div>
HTML;

// TASK 5: Practical
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <p>You are filling in for a security lead who needs five findings classified and scheduled before the report ships. Each finding includes a description, a severity rating, and business context.</p>

    <p>Review each finding and select its classification, remediation window, and verification method. You will get immediate feedback and can adjust before moving on to the next one.</p>

    <div class="practical-launch-wrapper">
        <a href="remediation-followup-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Remediation Ticket Simulator</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 6: Conclusion
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>Remediation guidance is where a pentest report either becomes useful or gets set aside. Actionable recommendations tell engineering exactly what to change and how it will be verified. Remediation windows keep urgency proportional to severity, and correctly classifying a finding as a fix, a workaround, or an accepted risk keeps everyone honest about what has actually been resolved.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Actionable guidance names the specific change, its location, and how it will be verified.</li>
        <li>Remediation windows scale with severity, from days for critical findings to months for low severity ones.</li>
        <li>Business context can adjust a window but should never eliminate it for a fix or workaround.</li>
        <li>A fix removes a vulnerability, a workaround reduces risk temporarily, and an accepted risk is a formal decision not to remediate.</li>
        <li>Verification testing confirms that a fix or workaround actually worked as intended.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
