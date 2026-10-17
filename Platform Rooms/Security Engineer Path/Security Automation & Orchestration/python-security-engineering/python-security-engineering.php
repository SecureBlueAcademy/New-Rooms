<?php
// ============================================================
// python-security-engineering.php — CYBRIXEN ROOM DATA FILE
// Generated per room-data-template.php canonical format.
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'python-security-engineering',
    'title'           => 'Python for Security Engineering',
    'description'     => 'Script API integrations, parse logs, automate evidence collection, and write safe, production ready security tooling in Python.',
    'icon'            => 'fab fa-python',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic Python syntax', 'Basic security operations concepts'],
    'learning_objectives' => [
        'Explain why Python is widely used in security engineering',
        'Call and parse data returned from a security API',
        'Extract and interpret fields from raw log lines',
        'Describe evidence collection and integrity practices',
        'Identify unsafe scripting practices and their safer alternatives',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/python-security-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Why Python for Security Engineering'],
    ['id' => 'task3', 'title' => 'Talking to Security APIs'],
    ['id' => 'task4', 'title' => 'Log Parsing and Analysis'],
    ['id' => 'task5', 'title' => 'Automated Evidence Collection'],
    ['id' => 'task6', 'title' => 'Writing Safe, Maintainable Scripts'],
    ['id' => 'task7', 'title' => 'Log Triage Console'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'python_security_engineering_progress',
    'instagram_takeaways'  => [
        '✓ Python as the connective layer across security tools',
        '✓ Calling and parsing security API responses',
        '✓ Parsing raw logs into structured, actionable fields',
        '✓ Writing safe scripts: secrets, logging, and error handling done right',
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
        ['id' => 'q1', 'text' => 'What Python library is most commonly used to make HTTP requests to an API?'],
        ['id' => 'q2', 'text' => 'What term describes using code to handle repetitive security tasks instead of doing them manually?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the common name for the secret credential sent with an API request to prove identity?'],
        ['id' => 'q4', 'text' => 'What data format do most modern security APIs return their responses in?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What term describes the technique of using patterns to extract specific fields from a log line?'],
        ['id' => 'q6', 'text' => 'What is the general term for converting a raw log line into structured, named fields?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What cryptographic technique is used to prove that collected evidence has not been altered?'],
        ['id' => 'q8', 'text' => 'What is the term for the documented record proving who handled a piece of evidence and when?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'Where should API keys and credentials be stored instead of hardcoding them directly in a script?'],
        ['id' => 'q10', 'text' => 'What Python module is the recommended way to record script activity instead of using print statements?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Log Triage Console.'],
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
    <p>Security teams run on tools that rarely talk to each other out of the box. A SIEM holds the logs, an EDR holds endpoint activity, a threat intel platform holds context, and a human is usually stuck stitching the three together by hand. Python is the language most security engineers reach for to close that gap, because it is quick to write, easy to read months later, and has libraries for almost every integration a security team needs.</p>

    <p>By the end of this room you will be able to call a security API and parse its response, pull structured fields out of raw log lines, understand how automated evidence collection preserves integrity, and write scripts that fail loudly instead of silently. A hands-on log triage console is included so you can apply these ideas directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why Python is widely used in security engineering.</li>
        <li>Call and parse data returned from a security API.</li>
        <li>Extract and interpret fields from raw log lines.</li>
        <li>Describe evidence collection and integrity practices.</li>
        <li>Identify unsafe scripting practices and their safer alternatives.</li>
    </ul>
</div>
HTML;

// TASK 2: Why Python for Security Engineering
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>The Glue Language of Security Operations</h2>

    <p>Security engineering involves constant repetition: pulling the same report, checking the same feed, formatting the same evidence. Python removes that repetition by letting an engineer write a script once and run it whenever needed, instead of clicking through the same dashboard steps every time.</p>

    <p>Think of Python as a universal adapter. A SIEM speaks one format, an EDR speaks another, and a threat intel feed speaks a third. Rather than learning three separate manual workflows, an engineer writes one Python script per tool and lets the language handle the translation between them.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Python complements security tools, it does not replace them. Its job is to connect and automate what already exists.</p>
    </div>

    <!-- SVG: Hub and spoke diagram
         Teaching purpose: show the learner that Python acts as a single connective
         hub across security tools, which they would otherwise misunderstand as
         needing separate custom integration code for every tool pair. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 340" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Python as central integration hub">
            <!-- Center node -->
            <circle cx="350" cy="170" r="60" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="350" y="165" text-anchor="middle" font-size="16" font-weight="600" fill="var(--text-primary)">Python</text>
            <text x="350" y="183" text-anchor="middle" font-size="11" fill="var(--text-secondary)">script</text>

            <!-- Spoke nodes -->
            <rect x="30" y="30" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="105" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">SIEM</text>
            <text x="105" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Alerts and logs</text>

            <rect x="520" y="30" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="595" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">EDR</text>
            <text x="595" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Endpoint activity</text>

            <rect x="275" y="250" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="280" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Threat Intel</text>
            <text x="350" y="298" text-anchor="middle" font-size="11" fill="var(--text-secondary)">IP and hash context</text>

            <!-- Connecting lines -->
            <line x1="180" y1="80" x2="300" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="520" y1="80" x2="400" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="350" y1="230" x2="350" y2="250" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Talking to Security APIs (SIEM, EDR, Threat Intel)
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Requesting Data From Security Platforms</h2>

    <p>Most security platforms expose a REST API. A script sends a request, usually a GET to fetch data or a POST to submit it, and the platform sends back a response. Almost every request needs an authentication header proving the script is allowed to ask.</p>

    <p>Think of an API like a reception desk. You show your credentials, ask a specific question, and get back a specific answer. You do not get to wander into the back office and take whatever you want, the platform only returns what your credentials and your request are scoped to see.</p>

    <h3>Common Security API Sources</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Platform Type</th>
                <th>Example Data Returned</th>
                <th>Common Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>SIEM</strong></td>
                <td>Correlated alerts, raw log events</td>
                <td>Pulling recent alerts for triage</td>
            </tr>
            <tr>
                <td><strong>EDR</strong></td>
                <td>Process trees, file hashes, endpoint events</td>
                <td>Investigating a suspicious endpoint</td>
            </tr>
            <tr>
                <td><strong>Threat Intel</strong></td>
                <td>Reputation scores, known malicious indicators</td>
                <td>Checking if an IP or hash is already known bad</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Request and response flow
         Teaching purpose: show the learner that an API call is a distinct
         sequence of steps, which they would otherwise misunderstand as one
         instant, automatic action. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="API request and response flow">
            <rect x="10"  y="35" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Python Script</text>
            <text x="85" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">sends request</text>

            <rect x="305" y="10" width="150" height="50" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="40" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Auth Header</text>

            <rect x="305" y="80" width="150" height="50" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="110" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Security API</text>

            <rect x="600" y="35" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="675" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">JSON Response</text>
            <text x="675" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">parsed by script</text>

            <line x1="160" y1="60" x2="300" y2="35" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="160" y1="80" x2="300" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="455" y1="70" x2="595" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Look Ahead</h4>
        <p>The credential used in that auth header should never be typed directly into a script. Task 6 covers exactly why, and what to do instead.</p>
    </div>
</div>
HTML;

// TASK 4: Log Parsing and Analysis
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Turning Raw Text Into Usable Fields</h2>

    <p>A log line on its own is just a string of text. Parsing is the process of pulling structured, named fields out of that text so a script can reason about them, compare them, and act on them.</p>

    <p>Think of Python as a mail sorter. It does not care about the envelope as a whole, it looks for specific fields such as the sender, the destination, and the time, then routes the item based on rules built around those fields.</p>

    <h3>A Simple Parsing Example</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Raw Log Line</th>
                <th>Extracted Field</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3">2024-03-11 09:14:02 auth FAILED user=jsmith src=203.0.113.77</td>
                <td>Timestamp</td>
                <td>2024-03-11 09:14:02</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>jsmith</td>
            </tr>
            <tr>
                <td>Source IP</td>
                <td>203.0.113.77</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Parsing pipeline
         Teaching purpose: show the learner that log parsing is a multi-step
         pipeline, which they would otherwise misunderstand as a single
         black-box operation. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Log parsing pipeline">
            <rect x="10"  y="30" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="75" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Raw Log</text>

            <rect x="185" y="30" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="250" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Parse</text>

            <rect x="360" y="30" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="425" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Fields</text>

            <rect x="535" y="30" width="130" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="58" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Rule Check</text>
            <text x="600" y="75" text-anchor="middle" font-size="10" fill="var(--text-secondary)">is_suspicious()</text>

            <text x="745" y="55" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Alert</text>
            <text x="745" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-secondary)">Ignore</text>

            <line x1="140" y1="60" x2="180" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="315" y1="60" x2="355" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="490" y1="60" x2="530" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="665" y1="60" x2="710" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Test parsing logic against sample log data before trusting it in production. A rule that misreads one field silently misreads every log that follows.</p>
    </div>
</div>
HTML;

// TASK 5: Automated Evidence Collection
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Collecting Evidence Without Losing Trust In It</h2>

    <p>During an investigation, a script might pull process trees, file hashes, and timestamps from a compromised endpoint. That data only has value if it can be trusted, which means proving it has not been altered since collection.</p>

    <p>Think of a crime scene technician bagging physical evidence. Each item is logged, sealed, and timestamped the moment it is collected. Automated evidence collection in security engineering follows the same idea, just with hashes instead of tamper tape.</p>

    <!-- SVG: Evidence collection pipeline
         Teaching purpose: show the learner that integrity verification is a
         required step in evidence collection, which they would otherwise
         misunderstand as implied simply by copying files off a host. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Evidence collection pipeline">
            <rect x="10"  y="30" width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Collect</text>

            <rect x="260" y="30" width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Hash</text>

            <rect x="510" y="30" width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Store</text>

            <line x1="190" y1="60" x2="255" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="440" y1="60" x2="505" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Mistake</h4>
        <p>Copying evidence before hashing it creates a gap where tampering cannot be proven or disproven. Hash immediately at the point of collection, not afterward.</p>
    </div>
</div>
HTML;

// TASK 6: Writing Safe, Maintainable Security Scripts
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Scripts That Fail Loudly, Not Silently</h2>

    <p>A security script that fails without telling anyone is worse than no script at all, because it creates false confidence that something is being monitored when it is not. Three habits separate a safe security script from a risky one: how it stores secrets, how it logs activity, and how it handles errors.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Practice</th>
                <th>Risky Approach</th>
                <th>Safer Approach</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Secrets</strong></td>
                <td>API key typed directly into the script</td>
                <td>Stored in an environment variable or secret manager</td>
            </tr>
            <tr>
                <td><strong>Logging</strong></td>
                <td>Using print statements, or nothing at all</td>
                <td>Using the logging module with clear log levels</td>
            </tr>
            <tr>
                <td><strong>Error Handling</strong></td>
                <td>A bare except that silently continues</td>
                <td>Catching specific exceptions and logging them</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Why This Matters</h4>
        <p>A script that silently swallows an error can mean a missed alert for days before anyone notices the monitoring stopped working.</p>
    </div>
</div>
HTML;

// PRACTICAL TASK: Log Triage Console
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Meridian Retail Co's log stream shows signs of an active intrusion. You have been given access to a Python-driven log triage console pulling in the raw authentication and firewall events from the last hour.</p>

    <p>Run the parser, use the filter and grouping controls to isolate the pattern, and identify both the attacking IP address and the account it compromised.</p>

    <div class="practical-launch-wrapper">
        <a href="python-security-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Log Triage Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// CONCLUSION TASK
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Python earns its place in security engineering by connecting tools that were never designed to talk to each other. You have now called a security API and parsed its response, extracted structured fields out of raw log lines, seen why evidence must be hashed at the point of collection, and learned what separates a safe script from a risky one.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Python acts as a connective automation layer across SIEM, EDR, and threat intel tools.</li>
        <li>API calls require authentication and return structured data, usually JSON, that must be parsed.</li>
        <li>Logs must be parsed methodically into fields, not read informally line by line.</li>
        <li>Evidence must be hashed immediately at collection to preserve its integrity.</li>
        <li>Secrets belong in environment variables, and errors must be logged, never swallowed silently.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
