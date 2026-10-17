<?php
// ids-ips-engineering.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'ids-ips-engineering',
    'title'           => 'IDS/IPS Engineering',
    'description'     => 'Design and deploy Intrusion Detection and Prevention Systems: sensor placement, signature tuning, threshold calibration, and measuring real effectiveness.',
    'icon'            => 'fas fa-shield-halved',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Expert',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Networking fundamentals', 'Basic security operations concepts'],
    'learning_objectives' => [
        'Distinguish network-based (NIDS) and host-based (HIDS) intrusion detection',
        'Evaluate the tradeoffs between inline and passive deployment modes',
        'Apply a sound sensor placement strategy across a network topology',
        'Tune signatures, thresholds, and suppression rules to reduce alert noise',
        'Measure IDS/IPS effectiveness independent of vendor benchmarks',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/ids-ips-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'NIDS vs HIDS'],
    ['id' => 'task3', 'title' => 'Inline vs Passive Deployment'],
    ['id' => 'task4', 'title' => 'Sensor Placement Strategy'],
    ['id' => 'task5', 'title' => 'Tuning, Calibration, and Suppression'],
    ['id' => 'task6', 'title' => 'Measuring Effectiveness'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'ids_ips_engineering_progress',
    'instagram_takeaways'  => [
        '✓ NIDS watches the network, HIDS watches the host',
        '✓ Inline sensors can block, passive sensors can only observe',
        '✓ Good placement follows choke points, not raw coverage',
        '✓ Tuning turns alert noise into trustworthy signal',
        '✓ Real effectiveness is measured against your own environment',
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
        ['id' => 'q1', 'text' => 'What type of sensor monitors traffic at the network level rather than on an individual host?'],
        ['id' => 'q2', 'text' => 'What type of sensor monitors activity on an individual host, such as file integrity and running processes?'],
        ['id' => 'q3', 'text' => 'Which sensor type would you rely on to detect an unauthorized change to a file on a single server?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'Which deployment mode allows a sensor to actively block malicious traffic?'],
        ['id' => 'q5', 'text' => 'Which deployment mode can only alert on traffic and never block it?'],
        ['id' => 'q6', 'text' => 'What term describes an inline sensor that continues passing traffic without inspection after it fails?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What term describes a network location where traffic naturally converges, making it a strong candidate for sensor placement?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What is the term for adjusting an IDS\'s sensitivity level to control the tradeoff between false positives and false negatives?'],
        ['id' => 'q9', 'text' => 'What is the term for rules that silence known benign repeat alerts without disabling the underlying signature?'],
        ['id' => 'q10', 'text' => 'What process ensures signatures match the actual protocols and services running in an environment rather than generating irrelevant noise?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'What metric measures how long a threat remains undetected in an environment?'],
        ['id' => 'q12', 'text' => 'What rate measures the proportion of benign activity incorrectly flagged as malicious?'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the Sensor Placement Console.'],
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
    <p>Every network that connects to the outside world eventually faces the same question: how do you know when something has gone wrong, and can you stop it before it spreads? IDS/IPS engineering is the discipline of answering that question deliberately, through sensor placement, deployment mode, and tuning decisions, rather than by dropping a product onto the network and hoping it works.</p>

    <p>By the end of this room you will be able to choose between network based and host based detection, weigh the tradeoffs of inline versus passive deployment, place sensors where they actually matter, tune signatures so alerts stay trustworthy, and judge whether a deployment is truly effective instead of just well marketed. A hands on design exercise is included to put these decisions into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Distinguish network based (NIDS) and host based (HIDS) intrusion detection.</li>
        <li>Evaluate the tradeoffs between inline and passive deployment modes.</li>
        <li>Apply a sound sensor placement strategy across a network topology.</li>
        <li>Tune signatures, thresholds, and suppression rules to reduce alert noise.</li>
        <li>Measure IDS/IPS effectiveness independent of vendor benchmarks.</li>
    </ul>
</div>
HTML;

// TASK 2: NIDS vs HIDS
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Ways to Watch a System</h2>

    <p>A <strong>Network Intrusion Detection System (NIDS)</strong> inspects traffic as it moves across the network, typically by reading a copy of packets from a tap or a mirrored switch port. It sees everything that crosses the wire at its vantage point, but nothing that happens purely inside a single machine.</p>

    <p>A <strong>Host Intrusion Detection System (HIDS)</strong> runs as an agent on an individual host. It watches file integrity, running processes, local log activity, and system calls on that one machine. It has no visibility into traffic elsewhere on the network, but it can see things a network sensor never will, such as a file being modified on disk.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>NIDS</th>
                <th>HIDS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>What it sees</td>
                <td>Traffic crossing a network segment</td>
                <td>Activity on a single host</td>
            </tr>
            <tr>
                <td>Deployment point</td>
                <td>Network tap, SPAN port, or inline link</td>
                <td>Agent installed on the host itself</td>
            </tr>
            <tr>
                <td>Blind spot</td>
                <td>Anything happening inside a host with no network footprint</td>
                <td>Anything happening on hosts without the agent</td>
            </tr>
            <tr>
                <td>Typical use case</td>
                <td>Detecting scans, exploits, and command and control traffic</td>
                <td>Detecting file tampering, privilege escalation, local persistence</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: NIDS vs HIDS vantage point diagram
         Teaching purpose: show the learner that NIDS and HIDS operate at different layers,
         which they would otherwise misunderstand as two versions of the same tool. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="NIDS versus HIDS vantage points">
            <!-- NIDS side: network link with a tap -->
            <rect x="20" y="30" width="330" height="140" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">NIDS</text>
            <rect x="45" y="90" width="90" height="40" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="90" y="114" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Client</text>
            <rect x="235" y="90" width="90" height="40" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="280" y="114" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Server</text>
            <line x1="135" y1="110" x2="235" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <circle cx="185" cy="110" r="6" fill="var(--primary)"/>
            <text x="185" y="150" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Sensor reads a copy of the traffic</text>

            <!-- HIDS side: single host with internal activity -->
            <rect x="410" y="30" width="330" height="140" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="575" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">HIDS</text>
            <rect x="500" y="80" width="150" height="70" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="575" y="105" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Host</text>
            <text x="575" y="122" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Files, processes, logs</text>
            <circle cx="575" cy="140" r="6" fill="var(--primary)"/>
            <text x="575" y="163" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Agent watches activity on this host only</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Inline vs Passive Deployment
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Watching Versus Intervening</h2>

    <p>An <strong>inline</strong> sensor sits directly in the path of traffic. Every packet must pass through it, which means it can drop or block malicious traffic in real time. This is what turns a detection system into a prevention system.</p>

    <p>A <strong>passive</strong> sensor receives a copy of traffic, usually through a network tap or a switch port configured to mirror traffic. It can analyze everything it sees and raise alerts, but it has no ability to stop traffic, because it never sits in the actual path.</p>

    <p>Think of an inline sensor as a security guard standing in a doorway, able to physically stop someone from entering. A passive sensor is a camera watching the same doorway. It records everything, but it cannot step in front of anyone.</p>

    <!-- SVG: inline path vs mirrored tap diagram
         Teaching purpose: show the learner that passive sensors don't sit in the traffic path,
         which they'd otherwise assume blocks traffic just like inline does. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 190" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Inline versus passive traffic path">
            <text x="185" y="25" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Inline</text>
            <rect x="40" y="60" width="80" height="40" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="80" y="84" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Source</text>
            <rect x="160" y="60" width="90" height="40" rx="6" fill="var(--surface)" stroke="var(--primary)" stroke-width="1.5"/>
            <text x="205" y="84" text-anchor="middle" font-size="10" fill="var(--text-primary)">Sensor</text>
            <rect x="290" y="60" width="80" height="40" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="330" y="84" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Destination</text>
            <line x1="120" y1="80" x2="155" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="250" y1="80" x2="285" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="205" y="130" text-anchor="middle" font-size="11" fill="var(--text-secondary)">All traffic must pass through the sensor</text>

            <text x="575" y="25" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Passive</text>
            <rect x="430" y="60" width="80" height="40" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="470" y="84" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Source</text>
            <rect x="640" y="60" width="80" height="40" rx="6" fill="none" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="680" y="84" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Destination</text>
            <line x1="510" y1="80" x2="635" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <rect x="545" y="120" width="90" height="40" rx="6" fill="var(--surface)" stroke="var(--primary)" stroke-width="1.5"/>
            <text x="590" y="144" text-anchor="middle" font-size="10" fill="var(--text-primary)">Sensor</text>
            <line x1="575" y1="80" x2="575" y2="118" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <text x="590" y="175" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Sensor only sees a mirrored copy</text>

            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Fail Open vs Fail Closed</h4>
        <p>An inline sensor that fails open continues passing traffic without inspection, silently losing protection. One that fails closed blocks all traffic on failure, turning a sensor problem into an outage.</p>
    </div>
</div>
HTML;

// TASK 4: Sensor Placement Strategy
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Deciding Where Sensors Go</h2>

    <p>Choosing NIDS or HIDS, inline or passive, only matters once you know where a sensor should sit. Placement strategy is about identifying the points in a network where visibility or control is actually worth the cost of adding a sensor.</p>

    <p>Good placement starts with <strong>choke points</strong>, the locations where traffic naturally converges, such as a perimeter link, a core switch, or the boundary of a sensitive segment. These points give broad visibility from a single vantage. Placing sensors everywhere traffic exists creates redundant coverage and unnecessary cost without improving detection.</p>

    <ul>
        <li>Identify choke points where the most relevant traffic converges.</li>
        <li>Weigh the blast radius of an inline failure at that point against the value of blocking there.</li>
        <li>Reserve host based coverage for individual high value assets that network visibility alone cannot protect.</li>
        <li>Avoid placing multiple sensors where one already provides adequate visibility.</li>
    </ul>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Coverage Is Not Protection</h4>
        <p>A sensor watching traffic that never carries a real threat adds cost without adding value. Placement should follow risk and traffic significance, not just physical availability of a link to tap.</p>
    </div>
</div>
HTML;

// TASK 5: Tuning, Calibration, and Suppression
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Making Alerts Worth Trusting</h2>

    <p>An IDS/IPS deployed with default settings will generate far more alerts than any team can act on. Turning that raw output into something usable requires three related techniques.</p>

    <p><strong>Signature tuning</strong> aligns detection rules with what actually runs in the environment. A signature written for a service the organization does not use will only ever produce noise. <strong>Threshold calibration</strong> adjusts how sensitive a detection is, controlling the balance between missing real threats and drowning in false alarms. <strong>Alert suppression</strong> silences known benign repeat triggers, such as a vulnerability scanner the security team runs itself, without disabling the underlying signature for everyone else.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Technique</th>
                <th>What It Does</th>
                <th>Risk If Overused</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Signature tuning</td>
                <td>Matches detection rules to the real environment</td>
                <td>Disabling too much can create blind spots for real threats</td>
            </tr>
            <tr>
                <td>Threshold calibration</td>
                <td>Adjusts sensitivity to balance false positives and false negatives</td>
                <td>Set too loose, real attacks slip through undetected</td>
            </tr>
            <tr>
                <td>Alert suppression</td>
                <td>Silences known benign repeat alerts</td>
                <td>Overbroad rules can hide the early stage of a real attack</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>A well tuned IDS produces fewer, more trustworthy alerts, not simply fewer alerts. The goal is signal, not silence.</p>
    </div>
</div>
HTML;

// TASK 6: Measuring Effectiveness
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Judging a Deployment Honestly</h2>

    <p>Vendors commonly advertise detection rates near 99 percent, measured against a controlled lab dataset. That number says very little about how a deployment performs against the specific traffic, applications, and attackers an organization actually faces.</p>

    <p>More reliable indicators come from measuring the deployment against its own environment over time, rather than trusting a marketing claim measured somewhere else entirely.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>What It Tells You</th>
                <th>Why Vendor Numbers Can Mislead</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dwell time</td>
                <td>How long a threat remains undetected in the environment</td>
                <td>Lab benchmarks rarely reflect the messiness of real traffic</td>
            </tr>
            <tr>
                <td>False positive rate</td>
                <td>How often benign activity gets flagged as malicious in practice</td>
                <td>Vendor tests are tuned for their own sample data, not yours</td>
            </tr>
            <tr>
                <td>Sensor uptime</td>
                <td>How consistently the sensor was actually operating and inspecting traffic</td>
                <td>A benchmark assumes the sensor is always on, which is not guaranteed</td>
            </tr>
            <tr>
                <td>Real incident review</td>
                <td>Whether actual incidents were caught, missed, or caught late</td>
                <td>This is the only number that reflects real world performance</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Measure Your Own Environment</h4>
        <p>A vendor's 99 percent detection rate says nothing about your traffic or your attackers. Effectiveness has to be measured against your own environment and your own incident history.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have been handed a network topology stretching from the internet edge down to a sensitive internal database server. Your job is to decide, at each point, whether a sensor belongs there, what type it should be, and whether it should sit inline or passive.</p>

    <p>Configure all five placement points until the design reaches full, sound coverage. Poor choices will be flagged with a hint explaining the risk they introduce, not the correct answer.</p>

    <div class="practical-launch-wrapper">
        <a href="ids-ips-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Sensor Placement Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You now have a working model for engineering an IDS/IPS deployment rather than simply installing one. Choosing between NIDS and HIDS, deciding inline versus passive, placing sensors at real choke points, tuning signatures and thresholds, and measuring effectiveness against your own environment are the decisions that separate a deployment that actually protects a network from one that only looks like it does on paper.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>NIDS and HIDS see different things and neither replaces the other.</li>
        <li>Inline deployment trades blocking power for failure risk; passive trades intervention for safety.</li>
        <li>Placement should follow choke points and asset value, not raw coverage.</li>
        <li>Signature tuning, threshold calibration, and alert suppression turn noise into trustworthy signal.</li>
        <li>Real effectiveness is measured against your own environment, not a vendor's lab benchmark.</li>
    </ul>
</div>
HTML;

// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
