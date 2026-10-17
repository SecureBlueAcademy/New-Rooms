<?php
// ============================================================
// siem-detection-engineering.php
// Room: SIEM Engineering & Detection Rule Writing
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'siem-detection-engineering',
    'title'           => 'SIEM Engineering & Detection Rule Writing',
    'description'     => 'Learn how to engineer detection content in a SIEM, from writing correlation rules to tuning false positives and measuring coverage against MITRE ATT&CK.',
    'icon'            => 'fas fa-shield-halved',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic security operations knowledge', 'Familiarity with the MITRE ATT&CK framework'],
    'learning_objectives' => [
        'Explain the detection engineering lifecycle from hypothesis to deployed rule',
        'Write a correlation rule using event type, threshold, time window, and match field',
        'Identify and reduce false positives without creating false negatives',
        'Describe what makes a SIEM dashboard actionable rather than a data dump',
        'Map detection rules to MITRE ATT&CK techniques to find coverage gaps',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/siem-detection-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Detection Engineering?'],
    ['id' => 'task3', 'title' => 'Writing Correlation Rules'],
    ['id' => 'task4', 'title' => 'Tuning and False Positives'],
    ['id' => 'task5', 'title' => 'Dashboards and Reporting'],
    ['id' => 'task6', 'title' => 'Measuring Coverage with ATT&CK'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'siem_detection_engineering_progress',
    'instagram_takeaways'  => [
        '✓ The detection engineering lifecycle: hypothesis to deployed rule',
        '✓ Writing correlation rules with thresholds and time windows',
        '✓ Tuning out false positives without creating false negatives',
        '✓ Measuring detection coverage against MITRE ATT&CK',
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
        ['id' => 'q1', 'text' => 'What is the term for the continuous cycle of building, testing, and refining detections?'],
        ['id' => 'q2', 'text' => 'What is the source material used to form new detection hypotheses based on adversary behavior?'],
        ['id' => 'q3', 'text' => 'What is the term for a specific attacker behavior a detection is designed to catch?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the term for a rule that combines multiple log events into a single meaningful alert?'],
        ['id' => 'q5', 'text' => 'What field defines how many matching events must occur before a rule fires?'],
        ['id' => 'q6', 'text' => 'What field limits correlated events to those occurring within a set period?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What term describes an alert incorrectly flagged as malicious when it is actually benign?'],
        ['id' => 'q8', 'text' => 'What term describes a real attack that a detection fails to catch?'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What metric measures the average time between an attack occurring and it being detected?'],
        ['id' => 'q10', 'text' => 'What metric measures the average time between detection and response?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'What is the name of the framework used to map adversary tactics and techniques?'],
        ['id' => 'q12', 'text' => 'What term describes a technique with no existing detection mapped to it?'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed by correctly correlating the attack.'],
    ],
    'task8' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Security teams today are flooded with alerts, but most of those alerts come from generic, out of the box rules that were never built with a specific attacker in mind. Detection engineering is the discipline of designing, testing, and maintaining detections that are purpose built to catch real adversary behavior instead of relying on default noise.</p>

    <p>In this room you will build a correlation rule from individual log events, tune a noisy detection down to a clean signal, understand what makes a SIEM dashboard genuinely useful, and map detections against the MITRE ATT&CK framework to find coverage gaps. A hands on practical is included to put these skills into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the detection engineering lifecycle from hypothesis to deployed rule.</li>
        <li>Write a correlation rule using event type, threshold, time window, and match field.</li>
        <li>Identify and reduce false positives without creating false negatives.</li>
        <li>Describe what makes a SIEM dashboard actionable rather than a data dump.</li>
        <li>Map detection rules to MITRE ATT&CK techniques to find coverage gaps.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Detection Engineering?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>From Raw Logs to Real Detections</h2>

    <p>A SIEM can ingest millions of log lines a day, but ingestion alone does not stop an attacker. Detection engineering is the practice of turning raw log data into targeted detections that catch specific adversary behavior, then keeping those detections accurate as the threat landscape changes.</p>

    <p>Think of a detection engineer as an immune system architect. A generic antibiotic works against many infections but poorly against all of them. A targeted antibody is built for one specific pathogen. A well engineered detection works the same way, built for one specific attacker technique rather than everything at once.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>New threat intelligence, such as a report describing a fresh attacker technique, is usually the trigger that starts a new detection <strong>hypothesis</strong>. Without that input, detection libraries quietly go stale.</p>
    </div>

    <h3>The Detection Engineering Lifecycle</h3>
    <p>Detection engineering is not a one time build task. It is a repeating cycle that keeps a detection accurate over time.</p>

    <!-- SVG: Detection engineering lifecycle
         Teaching purpose: show the learner detection engineering is a continuous loop,
         which they would otherwise misunderstand as a one time build task. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Detection engineering lifecycle">
            <!-- Stage boxes -->
            <rect x="10"  y="100" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="175" y="100" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="340" y="100" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="505" y="100" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="640" y="100" width="0"  height="0"/>
            <rect x="595" y="100" width="0" height="0"/>
            <rect x="620" y="100" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" transform="translate(-70,0)"/>
            <!-- Forward arrows -->
            <line x1="140" y1="130" x2="170" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="305" y1="130" x2="335" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="470" y1="130" x2="500" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="635" y1="130" x2="665" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <!-- Return arrow (Tune back to Hypothesis) -->
            <path d="M 705 100 C 705 30, 75 30, 75 95" fill="none" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="75"  y="135" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Hypothesis</text>
            <text x="240" y="135" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Develop</text>
            <text x="405" y="135" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Test</text>
            <text x="570" y="135" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Deploy</text>
            <text x="705" y="135" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Tune</text>
            <text x="390" y="20"  text-anchor="middle" font-size="11" fill="var(--text-secondary)">back to Hypothesis</text>
        </svg>
    </div>

    <h3>Engineered Detections vs Default Rules</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>Out of the Box Rule</th>
                <th>Engineered Detection</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Source</strong></td>
                <td>Vendor default</td>
                <td>Threat intelligence and hypothesis</td>
            </tr>
            <tr>
                <td><strong>Specificity</strong></td>
                <td>Generic across all environments</td>
                <td>Tailored to this environment</td>
            </tr>
            <tr>
                <td><strong>Maintenance</strong></td>
                <td>Rarely updated</td>
                <td>Actively tuned over time</td>
            </tr>
            <tr>
                <td><strong>Example</strong></td>
                <td>Generic multiple failed logons alert</td>
                <td>Rule tuned to a brute force pattern seen in this environment</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 3: Writing Correlation Rules
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Combining Events into Meaningful Alerts</h2>

    <p>A single failed login is normal. Five failed logins from the same source, within two minutes, followed by a successful login, is a different story. A <strong>correlation rule</strong> is logic that links multiple related log events across time into one meaningful alert.</p>

    <p>Think of a correlation rule as a recipe. The individual log lines are ingredients. Only the right combination, quantity, and order of those ingredients produces the finished dish, which in this case is an accurate alert rather than noise or a missed attack.</p>

    <!-- SVG: Isolated events combining into a correlated alert
         Teaching purpose: show the learner why single events look normal in isolation
         but the sequence together is malicious, which they would otherwise misunderstand
         as meaning any single failed logon should trigger an alert. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Events combining into a correlated alert">
            <rect x="20" y="20"  width="240" height="50" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="20" y="90"  width="240" height="50" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="20" y="160" width="240" height="50" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="140" y="40" text-anchor="middle" font-size="12" fill="var(--text-primary)">Failed logon 09:14:02</text>
            <text x="140" y="55" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Looks normal alone</text>
            <text x="140" y="110" text-anchor="middle" font-size="12" fill="var(--text-primary)">Failed logon 09:14:48</text>
            <text x="140" y="125" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Looks normal alone</text>
            <text x="140" y="180" text-anchor="middle" font-size="12" fill="var(--text-primary)">Successful logon 09:15:52</text>
            <text x="140" y="195" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Looks normal alone</text>
            <line x1="265" y1="45"  x2="410" y2="120" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="265" y1="115" x2="410" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="265" y1="185" x2="410" y2="140" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <rect x="420" y="95" width="260" height="70" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="2"/>
            <text x="550" y="125" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Correlated Alert</text>
            <text x="550" y="145" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Malicious pattern detected</text>
        </svg>
    </div>

    <h3>Building Blocks of a Correlation Rule</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Field</th>
                <th>Purpose</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Event Type</strong></td>
                <td>Which kind of event the rule watches for</td>
                <td>Logon failure</td>
            </tr>
            <tr>
                <td><strong>Match Field</strong></td>
                <td>What ties multiple events together</td>
                <td>Source IP address</td>
            </tr>
            <tr>
                <td><strong>Threshold</strong></td>
                <td>How many matching events are required</td>
                <td>5 events</td>
            </tr>
            <tr>
                <td><strong>Time Window</strong></td>
                <td>How close together the events must occur</td>
                <td>2 minutes</td>
            </tr>
            <tr>
                <td><strong>Sequence</strong></td>
                <td>Whether events must happen in a specific order</td>
                <td>Failures followed by a success</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 4: Tuning and False Positives
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Balancing Signal Against Noise</h2>

    <p>A smoke detector too sensitive to toast triggers constantly and gets ignored or unplugged. A smoke detector disabled entirely misses a real fire. Tuning a detection rule is the same balancing act: catch real attacks while filtering out the noise that causes alert fatigue.</p>

    <p>Every alert outcome falls into one of four categories. Understanding these categories is the foundation of tuning any detection.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Outcome</th>
                <th>Definition</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>True Positive</strong></td>
                <td>A real attack correctly detected</td>
                <td>Brute force alert fires during an actual attack</td>
            </tr>
            <tr>
                <td><strong>False Positive</strong></td>
                <td>Benign activity incorrectly flagged as malicious</td>
                <td>A user mistyping their password twice</td>
            </tr>
            <tr>
                <td><strong>False Negative</strong></td>
                <td>A real attack that the detection fails to catch</td>
                <td>An attacker's brute force attempt goes unnoticed</td>
            </tr>
            <tr>
                <td><strong>True Negative</strong></td>
                <td>Benign activity correctly ignored</td>
                <td>A normal successful logon generates no alert</td>
            </tr>
        </tbody>
    </table>

    <p>Tuning techniques include adding exclusions for known benign patterns, allowlisting trusted sources, adjusting thresholds, and enriching alerts with context such as asset criticality or user role.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Watch for Over-Tuning</h4>
        <p>Silencing noise by loosening a rule too far can quietly create a blind spot. A tuned rule should still catch the exact behavior it was designed for.</p>
    </div>
</div>
HTML;

// TASK 5: Dashboards and Reporting
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Making Detection Health Visible</h2>

    <p>A car dashboard does not display every measurement the engine produces. It shows a small set of gauges that answer the questions a driver actually needs answered: speed, fuel, and engine temperature. A SIEM dashboard should work the same way.</p>

    <p>Detection dashboards typically serve two audiences. Analysts need operational detail to work alerts. Leadership needs a higher level view of detection health and risk. The same underlying data can support both, but the widgets shown should differ.</p>

    <!-- SVG: Focused dashboard layout
         Teaching purpose: show what a purposeful, focused dashboard layout looks like,
         which the learner would otherwise misunderstand as meaning every available
         metric should be displayed. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 600 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Focused SIEM dashboard layout">
            <rect x="20"  y="20"  width="260" height="100" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="320" y="20"  width="260" height="100" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="20"  y="140" width="260" height="100" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="320" y="140" width="260" height="100" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="150" y="65"  text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Alert Volume Trend</text>
            <text x="450" y="65"  text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Top Firing Rules</text>
            <text x="150" y="185" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Mean Time to Detect</text>
            <text x="450" y="185" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Mean Time to Respond</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Vanity vs Actionable Metrics</h4>
        <p>Total number of logs ingested is a vanity metric. It looks impressive but drives no decision. Mean time to detect is an actionable metric because a rising trend tells the team exactly what to investigate.</p>
    </div>
</div>
HTML;

// TASK 6: Measuring Coverage with MITRE ATT&CK
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Mapping Detections to Adversary Techniques</h2>

    <p>The MITRE ATT&CK matrix catalogs known adversary tactics and techniques. Mapping each existing detection rule to the technique it covers reveals a coverage picture: which techniques have a working detection, and which have none at all.</p>

    <p>Think of the matrix as a building floor plan with security cameras. Mapping rules to techniques shows which rooms have a camera watching them and which rooms have no coverage at all.</p>

    <!-- SVG: Coverage heat map
         Teaching purpose: show the learner what an actual coverage gap looks like visually,
         which they would otherwise misunderstand as meaning having some detections
         means full coverage. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 640 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="MITRE ATT&CK coverage heat map">
            <rect x="20"  y="40" width="140" height="50" fill="var(--success)" opacity="0.35" stroke="var(--border)"/>
            <rect x="180" y="40" width="140" height="50" fill="var(--error, #ff5c5c)" opacity="0.35" stroke="var(--border)"/>
            <rect x="340" y="40" width="140" height="50" fill="var(--success)" opacity="0.35" stroke="var(--border)"/>
            <rect x="500" y="40" width="120" height="50" fill="var(--error, #ff5c5c)" opacity="0.35" stroke="var(--border)"/>
            <text x="90"  y="20" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Initial Access</text>
            <text x="250" y="20" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Persistence</text>
            <text x="410" y="20" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Exfiltration</text>
            <text x="560" y="20" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Impact</text>
            <text x="90"  y="70" text-anchor="middle" font-size="12" fill="var(--text-primary)">Covered</text>
            <text x="250" y="70" text-anchor="middle" font-size="12" fill="var(--text-primary)">Gap</text>
            <text x="410" y="70" text-anchor="middle" font-size="12" fill="var(--text-primary)">Covered</text>
            <text x="560" y="70" text-anchor="middle" font-size="12" fill="var(--text-primary)">Gap</text>
        </svg>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Technique</th>
                <th>Rule Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Brute Force (T1110)</td>
                <td>Brute Force Correlation Rule</td>
                <td>Covered</td>
            </tr>
            <tr>
                <td>Valid Accounts (T1078)</td>
                <td>None</td>
                <td>Gap</td>
            </tr>
            <tr>
                <td>Exfiltration Over C2 Channel (T1041)</td>
                <td>Large Outbound Transfer Rule</td>
                <td>Covered</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>A source IP has generated a burst of failed logons against a workstation, followed by a successful logon. Your job is to configure a correlation rule that catches this exact attack pattern while ignoring the unrelated benign activity happening in the same log feed.</p>

    <p>Use the Detection Rule Workbench to set the event type, match field, threshold, and time window. Watch the test results panel update as you adjust each field, and aim for a rule that catches the real attack with zero false positives.</p>

    <div class="practical-launch-wrapper">
        <a href="siem-detection-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Detection Rule Workbench</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You now understand what it takes to run a real detection engineering program. The lifecycle turns threat intelligence into hypotheses, hypotheses into correlation rules, and correlation rules into tuned, trusted detections. Dashboards make that health visible, and MITRE ATT&CK mapping shows exactly where coverage still needs work.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Detection engineering follows a repeatable lifecycle, not a one time build.</li>
        <li>Correlation rules combine event type, match field, threshold, and time window to catch patterns single events cannot show.</li>
        <li>Tuning balances false positives against the risk of creating false negatives.</li>
        <li>Effective dashboards answer specific questions rather than displaying every available metric.</li>
        <li>Mapping rules to MITRE ATT&CK reveals real coverage gaps to prioritize next.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
