<?php
// ============================================================
// security-metrics-reporting.php — ROOM DATA FILE
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'security-metrics-reporting',
    'title'           => 'Security Metrics & Engineering Reporting',
    'description'     => 'Learn how to measure the effectiveness of security engineering work and communicate it clearly to technical and executive audiences.',
    'icon'            => 'fas fa-chart-line',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic security operations knowledge', 'Familiarity with incident response and vulnerability management'],
    'learning_objectives' => [
        'Explain MTTD and MTTR and how they are calculated',
        'Describe SLA adherence tracking for vulnerability remediation',
        'Calculate and interpret patch coverage',
        'Map detection coverage against ATT&CK tactics',
        'Build a KPI dashboard tailored to technical and executive audiences',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/security-metrics-reporting-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'MTTD & MTTR'],
    ['id' => 'task3', 'title' => 'Vulnerability Remediation SLA Adherence'],
    ['id' => 'task4', 'title' => 'Patch Coverage'],
    ['id' => 'task5', 'title' => 'Detection Coverage by ATT&CK Tactic'],
    ['id' => 'task6', 'title' => 'Building a Security KPI Dashboard'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'security_metrics_reporting_progress',
    'instagram_takeaways'  => [
        '✓ MTTD and MTTR: the two clocks that measure incident response',
        '✓ Vulnerability remediation SLA adherence by severity tier',
        '✓ Patch coverage across the estate',
        '✓ Mapping detection coverage to ATT&CK tactics',
        '✓ Building a KPI dashboard your audience actually understands',
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
        ['id' => 'q1', 'text' => 'What metric measures the time between an incident occurring and being detected?'],
        ['id' => 'q2', 'text' => 'What metric measures the time between detection and resolution of an incident?'],
        ['id' => 'q3', 'text' => 'Which statistical measure is less skewed by outliers than a mean, and is often reported alongside MTTR?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What term describes the percentage of vulnerabilities remediated within their committed timeframe?'],
        ['id' => 'q5', 'text' => 'Which severity tier typically has the shortest remediation SLA?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What metric measures the percentage of in-scope systems that have been patched?'],
        ['id' => 'q7', 'text' => 'What is the common term for systems past vendor support that can no longer receive patches?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What framework categorizes adversary behavior into tactics and techniques?'],
        ['id' => 'q9', 'text' => 'What tactic describes an attacker moving between systems within a network?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What type of metric looks good on a dashboard but does not reflect real security effectiveness?'],
        ['id' => 'q11', 'text' => 'Which audience typically prefers trend and risk framed metrics over granular technical detail?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the MTTD/MTTR Detective lab.'],
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
    <p>Security teams do a lot of work that is invisible unless it is measured. Detecting an intrusion in minutes instead of days, closing a critical vulnerability before it is exploited, patching a fleet of servers before an attacker finds the gap: none of this shows up unless someone tracks it and reports it clearly. Metrics turn security engineering from a set of activities into a program that can prove its own value and improve over time.</p>

    <p>By the end of this room you will be able to calculate the core metrics used to evaluate detection and response performance, track SLA adherence for vulnerability remediation, measure patch coverage, and map detection capability against real attacker behavior. You will then practice building a dashboard that tells the truth to both engineers and executives. A hands-on investigation is included to put these calculations into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain MTTD and MTTR and how they are calculated.</li>
        <li>Describe SLA adherence tracking for vulnerability remediation.</li>
        <li>Calculate and interpret patch coverage.</li>
        <li>Map detection coverage against ATT&CK tactics.</li>
        <li>Build a KPI dashboard tailored to technical and executive audiences.</li>
    </ul>
</div>
HTML;

// TASK 2: MTTD & MTTR
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>The Two Clocks That Matter</h2>

    <p>Every security incident has two clocks running. The first starts the moment the incident actually happens and stops the moment someone notices it. The second starts the moment it is noticed and stops the moment it is fully resolved. These two clocks are called <strong>MTTD</strong> and <strong>MTTR</strong>.</p>

    <p><strong>Mean Time To Detect (MTTD)</strong> is the average time between an incident occurring and it being detected. <strong>Mean Time To Respond (MTTR)</strong> is the average time between detection and full resolution. Treating these as one blended number hides where the real problem sits. A team can catch every incident almost instantly and still take hours to actually contain and resolve them.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Averages Alone Can Mislead</h4>
        <p>A single average can be dragged upward by one unusually slow incident, making a mostly healthy program look worse than it is, or downward by many small quiet ones, hiding a genuinely slow outlier. Reporting the median alongside the mean gives a more honest picture of typical performance.</p>
    </div>

    <h3>Formulas at a Glance</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>What It Measures</th>
                <th>Formula</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>MTTD</strong></td>
                <td>Speed of detection</td>
                <td>Detection time minus occurrence time, averaged across incidents</td>
            </tr>
            <tr>
                <td><strong>MTTR</strong></td>
                <td>Speed of response and resolution</td>
                <td>Resolution time minus detection time, averaged across incidents</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: MTTD/MTTR timeline
         Teaching purpose: show the learner that MTTD and MTTR are two distinct,
         sequential spans, which they would otherwise misunderstand as one combined "response time". -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="MTTD and MTTR timeline">
            <!-- Timeline base -->
            <line x1="40" y1="70" x2="720" y2="70" stroke="var(--border)" stroke-width="2"/>
            <!-- Points -->
            <circle cx="80" cy="70" r="6" fill="var(--text-primary)"/>
            <circle cx="380" cy="70" r="6" fill="var(--primary)"/>
            <circle cx="680" cy="70" r="6" fill="var(--success)"/>
            <!-- MTTD span -->
            <line x1="80" y1="40" x2="380" y2="40" stroke="var(--primary)" stroke-width="3"/>
            <text x="230" y="30" text-anchor="middle" font-size="13" font-weight="600" fill="var(--primary)">MTTD</text>
            <!-- MTTR span -->
            <line x1="380" y1="100" x2="680" y2="100" stroke="var(--success)" stroke-width="3"/>
            <text x="530" y="118" text-anchor="middle" font-size="13" font-weight="600" fill="var(--success)">MTTR</text>
            <!-- Labels -->
            <text x="80" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Occurred</text>
            <text x="380" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Detected</text>
            <text x="680" y="95" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Resolved</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Vulnerability Remediation SLA Adherence
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Are Vulnerabilities Fixed On Time?</h2>

    <p>Finding vulnerabilities is only half the job. The other half is closing them within a committed timeframe. <strong>SLA adherence</strong> measures the percentage of vulnerabilities that were remediated within their target window, out of all vulnerabilities that came due.</p>

    <p>Not every vulnerability carries the same urgency, so most programs use severity based tiers, each with its own remediation window. A critical vulnerability sitting unpatched for a month is a very different risk than a low severity one in the same state.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Severity Tier</th>
                <th>Target Remediation Window</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Critical</td>
                <td>7 days</td>
                <td>Remote code execution on an internet facing server</td>
            </tr>
            <tr>
                <td>High</td>
                <td>30 days</td>
                <td>Privilege escalation on an internal host</td>
            </tr>
            <tr>
                <td>Medium</td>
                <td>90 days</td>
                <td>Information disclosure requiring local access</td>
            </tr>
            <tr>
                <td>Low</td>
                <td>180 days</td>
                <td>Minor configuration weakness with limited impact</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Not All Misses Are Equal</h4>
        <p>A single missed critical SLA carries far more weight than several missed low severity ones. A useful dashboard reports adherence per tier rather than one blended percentage, so a strong low tier number cannot mask a weak critical tier number.</p>
    </div>
</div>
HTML;

// TASK 4: Patch Coverage
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>How Much of the Estate Is Actually Patched?</h2>

    <p><strong>Patch coverage</strong> measures the percentage of in-scope systems that have received a given patch, out of the total number of systems that should have received it. It answers a simple but important question: if a patch was released, how much of the environment is actually protected by it?</p>

    <p>Perfect coverage is rare in practice. Some systems are offline during a patch cycle, some require change control windows, and some cannot be patched at all. The goal is not always 100 percent, it is understanding exactly where the gaps are and why they exist.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Asset Group</th>
                <th>Systems Patched</th>
                <th>Systems Total</th>
                <th>Coverage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Employee laptops</td>
                <td>1,940</td>
                <td>2,000</td>
                <td>97%</td>
            </tr>
            <tr>
                <td>Production servers</td>
                <td>410</td>
                <td>450</td>
                <td>91%</td>
            </tr>
            <tr>
                <td>Legacy application servers</td>
                <td>12</td>
                <td>40</td>
                <td>30%</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Watch the Legacy Group</h4>
        <p>End of life systems, often shortened to <strong>EOL</strong>, are past vendor support and can no longer receive patches at all. A low coverage number in this group is not a performance failure, it is a signal that those systems need to be replaced or isolated.</p>
    </div>
</div>
HTML;

// TASK 5: Detection Coverage by ATT&CK Tactic
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Detection Coverage That Matches Attacker Behavior</h2>

    <p>Counting detection rules tells you very little on its own. What matters is whether those rules actually cover the stages an attacker moves through. The <strong>MITRE ATT&CK</strong> framework organizes attacker behavior into tactics, such as initial access, lateral movement, and exfiltration, and the specific techniques used within each one.</p>

    <p>Mapping detection coverage against these tactics reveals where the program is strong and where it is blind. A team can have excellent coverage for initial access and almost none for lateral movement, and a single average coverage figure would never reveal that imbalance.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Tactic</th>
                <th>Example Technique</th>
                <th>Detection Coverage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Initial Access</td>
                <td>Phishing attachment</td>
                <td>Full</td>
            </tr>
            <tr>
                <td>Execution</td>
                <td>Malicious script execution</td>
                <td>Full</td>
            </tr>
            <tr>
                <td>Lateral Movement</td>
                <td>Remote service exploitation</td>
                <td>Partial</td>
            </tr>
            <tr>
                <td>Exfiltration</td>
                <td>Data transfer to external server</td>
                <td>None</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: ATT&CK tactic coverage grid
         Teaching purpose: show the learner that coverage is uneven across the attack chain,
         which they would otherwise assume is uniform if only an average coverage figure is reported. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Detection coverage by tactic">
            <rect x="20"  y="30" width="160" height="60" rx="8" fill="var(--success)" opacity="0.6"/>
            <rect x="210" y="30" width="160" height="60" rx="8" fill="var(--success)" opacity="0.6"/>
            <rect x="400" y="30" width="160" height="60" rx="8" fill="var(--warning, #ffd36a)" opacity="0.6"/>
            <rect x="590" y="30" width="150" height="60" rx="8" fill="var(--border)" opacity="0.9"/>
            <text x="100" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Initial Access</text>
            <text x="290" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Execution</text>
            <text x="480" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Lateral Move</text>
            <text x="665" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Exfiltration</text>
            <text x="100" y="110" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Full</text>
            <text x="290" y="110" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Full</text>
            <text x="480" y="110" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Partial</text>
            <text x="665" y="110" text-anchor="middle" font-size="11" fill="var(--text-secondary)">None</text>
        </svg>
    </div>
</div>
HTML;

// TASK 6: Building a Security KPI Dashboard
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Telling the Truth to the Right Audience</h2>

    <p>A good security KPI dashboard is not one dashboard, it is two views of the same underlying data. Executives need trend lines and risk framed summaries they can act on in a few minutes. Engineers need the granular detail that shows exactly where the next fix needs to happen.</p>

    <p>Reporting the same handful of numbers to both audiences usually satisfies neither. Executives get overwhelmed by detail they cannot act on, and engineers get a summary too shallow to be useful for prioritizing work.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Audience</th>
                <th>Example Metrics Shown</th>
                <th>Framing Used</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Executives</td>
                <td>MTTR trend, SLA adherence by tier, overall risk posture</td>
                <td>Trend over time, tied to business risk</td>
            </tr>
            <tr>
                <td>Engineers</td>
                <td>Per incident timelines, coverage by ATT&CK tactic, patch gaps by asset group</td>
                <td>Granular detail, tied to specific fixes</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Avoid Vanity Metrics</h4>
        <p>A vanity metric looks impressive but does not reflect real effectiveness, such as counting total alerts generated rather than incidents actually resolved within SLA. Every metric on a dashboard should answer a question someone can act on.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have been handed six incident timeline logs from the past month. Each one records when the incident actually occurred, when it was detected, and when it was resolved. Your job is to calculate MTTD and MTTR for each incident, work out the averages, and check them against the team's committed SLA targets.</p>

    <p>The dashboard currently shows a single blended number that looks fine at a glance. Your investigation will reveal whether that number is hiding something.</p>

    <div class="practical-launch-wrapper">
        <a href="security-metrics-reporting-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch MTTD/MTTR Detective</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You now understand the core metrics that turn security engineering from invisible effort into a measurable, accountable program. MTTD and MTTR reveal detection and response speed as two separate signals. SLA adherence and patch coverage show whether known risks are actually being closed on time. Detection coverage by ATT&CK tactic shows whether the program's defenses match real attacker behavior, not just rule counts.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>MTTD and MTTR measure two distinct, sequential clocks and should be reported separately.</li>
        <li>SLA adherence should be tracked per severity tier, not as one blended percentage.</li>
        <li>Patch coverage reveals where the estate is protected and where legacy systems create risk.</li>
        <li>Detection coverage mapped to ATT&CK tactics exposes blind spots that raw rule counts hide.</li>
        <li>A KPI dashboard should present different views for executives and engineers, built from the same underlying data.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
