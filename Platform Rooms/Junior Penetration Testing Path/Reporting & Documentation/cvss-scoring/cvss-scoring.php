<?php
// ============================================================
// cvss-scoring.php — ROOM DATA FILE
// Topic: CVSS Scoring & Risk Rating
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'cvss-scoring',
    'title'           => 'CVSS Scoring & Risk Rating',
    'description'     => 'Learn how the Common Vulnerability Scoring System turns vulnerability details into a ranked severity score using Base, Temporal, and Environmental metrics.',
    'icon'            => 'fas fa-chart-line',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic security concepts', 'Understanding of vulnerabilities and exploits'],
    'learning_objectives' => [
        'Explain the purpose of the Base, Temporal, and Environmental metric groups',
        'Identify the six Base exploitability and impact sub metrics',
        'Calculate a CVSS Base Score conceptually',
        'Map a CVSS score to its severity rating',
        'Apply CVSS scoring to real vulnerability reports',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/cvss-scoring-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is CVSS?'],
    ['id' => 'task3', 'title' => 'Base Metrics: Exploitability'],
    ['id' => 'task4', 'title' => 'Base Metrics: Impact and Scoring'],
    ['id' => 'task5', 'title' => 'Temporal Metrics'],
    ['id' => 'task6', 'title' => 'Environmental Metrics'],
    ['id' => 'task7', 'title' => 'Vulnerability Triage Console'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'cvss_scoring_progress',
    'instagram_takeaways'  => [
        '✓ CVSS turns vulnerability severity into a shared numeric language',
        '✓ Base metrics describe exploitability and impact',
        '✓ Temporal metrics only lower or maintain the Base Score over time',
        '✓ Environmental metrics adjust scoring to organizational context',
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
        ['id' => 'q1', 'text' => 'What does the acronym CVSS stand for?'],
        ['id' => 'q2', 'text' => 'Which CVSS metric group is always required to produce a score?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'Which Attack Vector value describes a vulnerability that can be exploited over the internet?'],
        ['id' => 'q4', 'text' => 'What CVSS metric measures whether an attacker needs prior account access to exploit a vulnerability?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What three letter acronym describes the impact metrics in CVSS Base scoring?'],
        ['id' => 'q6', 'text' => 'What severity rating applies to a CVSS score between 9.0 and 10.0?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'Which CVSS metric group reflects how a vulnerability\'s real world risk changes as time passes?'],
        ['id' => 'q8', 'text' => 'Can Temporal metrics ever raise a vulnerability\'s score above its Base Score?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Which CVSS metric group lets an organization adjust a score based on its own systems and priorities?'],
        ['id' => 'q10', 'text' => 'What word describes the customized versions of Base metrics used in Environmental scoring?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Vulnerability Triage Console.'],
    ],
    'task8' => [
        ['id' => 'q12', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every vulnerability report looks urgent when you read it in isolation. The real challenge for a security team is not finding vulnerabilities, it is deciding which ones to fix first. The Common Vulnerability Scoring System, known as CVSS, solves this by turning technical details into a single comparable number.</p>

    <p>By the end of this room you will be able to read a vulnerability description and translate it into a CVSS score, understand why two similar looking bugs can land in very different severity bands, and know when a score should be adjusted for your own organization. A hands on scoring exercise is included to put this into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the purpose of the Base, Temporal, and Environmental metric groups.</li>
        <li>Identify the six Base exploitability and impact sub metrics.</li>
        <li>Calculate a CVSS Base Score conceptually.</li>
        <li>Map a CVSS score to its severity rating.</li>
        <li>Apply CVSS scoring to real vulnerability reports.</li>
    </ul>
</div>
HTML;

// TASK 2: What is CVSS?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>A Shared Language for Severity</h2>

    <p>CVSS produces a score from 0.0 to 10.0 that describes how severe a vulnerability is. Because every vendor and researcher uses the same formula, a score from one organization means the same thing as a score from another. This is what makes CVSS useful for comparing and prioritizing across an entire vulnerability backlog.</p>

    <p>CVSS is made up of three metric groups, and they are not all used the same way. Only one of them is required every time a vulnerability is scored.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Metric Group</th>
                <th>Purpose</th>
                <th>When Used</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Base</strong></td>
                <td>Describes the intrinsic, unchanging severity of the vulnerability itself.</td>
                <td>Always. This is the score published with every CVE.</td>
            </tr>
            <tr>
                <td><strong>Temporal</strong></td>
                <td>Reflects how risk changes as exploit code, patches, or confidence in the report evolve.</td>
                <td>Optional, applied when current exploit and patch status is known.</td>
            </tr>
            <tr>
                <td><strong>Environmental</strong></td>
                <td>Adjusts the score to reflect the value and exposure of the affected system in a specific organization.</td>
                <td>Optional, applied by the organization scoring the vulnerability for its own context.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG teaching purpose: show the learner that Base is always required while Temporal
         and Environmental are optional refinements layered on top, which they would otherwise
         misunderstand as three groups that are always calculated together. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="CVSS metric group flow">
            <rect x="10"  y="30" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <rect x="290" y="30" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="6,4"/>
            <rect x="570" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="6,4"/>

            <line x1="210" y1="70" x2="285" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="490" y1="70" x2="565" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <text x="110" y="62" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Base</text>
            <text x="110" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Always required</text>
            <text x="390" y="62" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Temporal</text>
            <text x="390" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Optional refinement</text>
            <text x="660" y="62" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Environmental</text>
            <text x="660" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Optional refinement</text>

            <text x="380" y="130" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Dashed boxes are optional. Only Base is calculated every time.</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Base Metrics: Exploitability
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>How Reachable Is the Vulnerability?</h2>

    <p>Exploitability metrics describe how hard it is for an attacker to actually reach and trigger the vulnerability. Think of it like describing how hard it is to break into a house. Can it be done from the street, or does the attacker need to already be standing at the door? Do they need a key, or can they just turn the handle?</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>What It Asks</th>
                <th>Possible Values</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Attack Vector</td>
                <td>How close does the attacker need to be to the vulnerable system?</td>
                <td>Network, Adjacent, Local, Physical</td>
            </tr>
            <tr>
                <td>Attack Complexity</td>
                <td>Are there conditions outside the attacker's control that make exploitation harder?</td>
                <td>Low, High</td>
            </tr>
            <tr>
                <td>Privileges Required</td>
                <td>Does the attacker need an existing account before exploiting the vulnerability?</td>
                <td>None, Low, High</td>
            </tr>
            <tr>
                <td>User Interaction</td>
                <td>Does a victim need to take some action, like clicking a link, for the attack to succeed?</td>
                <td>None, Required</td>
            </tr>
            <tr>
                <td>Scope</td>
                <td>Does successful exploitation affect resources beyond the vulnerable component itself?</td>
                <td>Unchanged, Changed</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The Most Misunderstood Metric</h4>
        <p>Scope is often confused with impact. It does not ask how bad the damage is, it asks whether the vulnerability lets an attacker break out of the component's own security boundary into another one, such as a browser sandbox or a different application.</p>
    </div>
</div>
HTML;

// TASK 4: Base Metrics: Impact and Scoring
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>What Happens if It Is Exploited?</h2>

    <p>Impact metrics use the same Confidentiality, Integrity, and Availability triad you already know from general security concepts. Each one is rated None, Low, or High, describing how much the attacker can read, change, or disrupt if the vulnerability is successfully exploited.</p>

    <p>The Base Score combines exploitability and impact into a single number from 0.0 to 10.0. A vulnerability that is trivially easy to reach but only leaks a single non sensitive value will still score lower than one that is equally easy to reach but grants full control of the system.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Score Range</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>0.0</td><td>None</td></tr>
            <tr><td>0.1 to 3.9</td><td>Low</td></tr>
            <tr><td>4.0 to 6.9</td><td>Medium</td></tr>
            <tr><td>7.0 to 8.9</td><td>High</td></tr>
            <tr><td>9.0 to 10.0</td><td>Critical</td></tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Most teams act on the severity rating day to day, not the exact decimal score. Knowing whether something is High or Medium matters more in practice than the difference between 7.2 and 7.4.</p>
    </div>
</div>
HTML;

// TASK 5: Temporal Metrics
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Scoring Changes as Time Passes</h2>

    <p>A Base Score describes the vulnerability itself and never changes. But real world risk is not static. A vulnerability is most dangerous the day a working exploit becomes public and no vendor patch exists yet. It becomes progressively less urgent once a patch ships and organizations apply it.</p>

    <p>Temporal metrics capture this shifting picture without altering the underlying Base Score.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>What It Asks</th>
                <th>Possible Values</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Exploit Code Maturity</td>
                <td>How available and reliable is working exploit code?</td>
                <td>Not Defined, Unproven, Proof of Concept, Functional, High</td>
            </tr>
            <tr>
                <td>Remediation Level</td>
                <td>Is there an official fix, a temporary workaround, or nothing yet?</td>
                <td>Not Defined, Official Fix, Temporary Fix, Workaround, Unavailable</td>
            </tr>
            <tr>
                <td>Report Confidence</td>
                <td>How confident are researchers that the vulnerability exists and behaves as described?</td>
                <td>Not Defined, Unknown, Reasonable, Confirmed</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> One Direction Only</h4>
        <p>Temporal metrics can only lower a score or leave it unchanged. They never push a score higher than its original Base Score.</p>
    </div>
</div>
HTML;

// TASK 6: Environmental Metrics
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Adjusting the Score to Your Own Systems</h2>

    <p>The same technical vulnerability can matter very differently depending on where it lives. A stored cross site scripting bug on a public marketing page is a nuisance. The same bug on an internal payroll dashboard is a serious problem, even though the underlying flaw is identical.</p>

    <p>Environmental metrics let an organization apply this context on top of the Base Score.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>What It Adjusts</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Modified Base Metrics</td>
                <td>Lets any Base metric be re evaluated for the organization's actual deployment, such as a compensating control that raises Attack Complexity.</td>
            </tr>
            <tr>
                <td>Confidentiality Requirement</td>
                <td>How much the organization cares about protecting this system's confidentiality specifically.</td>
            </tr>
            <tr>
                <td>Integrity Requirement</td>
                <td>How much the organization cares about protecting this system's integrity specifically.</td>
            </tr>
            <tr>
                <td>Availability Requirement</td>
                <td>How much the organization cares about protecting this system's availability specifically.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Do Not Rely on Base Score Alone</h4>
        <p>A vulnerability with a low Base Score can still be a top priority once Environmental metrics are applied, if it sits on a system holding highly sensitive data.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Your security team has five unscored vulnerability reports piling up before this afternoon's patch review meeting. Nobody has assigned severity yet, and the meeting cannot start until every vulnerability has a Base Score and rating.</p>

    <p>Read each report carefully, select the Base metric values that match what is described, and confirm your score. Repeat until all five vulnerabilities are triaged correctly.</p>

    <div class="practical-launch-wrapper">
        <a href="cvss-scoring-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Vulnerability Triage Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>CVSS replaces gut feeling with a repeatable process. The Base Score captures the intrinsic severity of a vulnerability using exploitability and impact. Temporal metrics refine that score as exploit code and patches become known, and Environmental metrics adjust it to reflect what a specific system actually means to your organization.</p>

    <p>Scoring accurately is a skill that improves with practice. The more reports you translate into metrics, the faster you will recognize the patterns behind Critical, High, Medium, and Low severity.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>CVSS Base Score reflects the intrinsic severity of a vulnerability.</li>
        <li>Attack Vector, Attack Complexity, Privileges Required, and User Interaction describe exploitability.</li>
        <li>Confidentiality, Integrity, and Availability impact describe what happens if the vulnerability is exploited.</li>
        <li>Temporal metrics only lower a score over time, never raise it.</li>
        <li>Environmental metrics adjust scoring to reflect an organization's own context.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
