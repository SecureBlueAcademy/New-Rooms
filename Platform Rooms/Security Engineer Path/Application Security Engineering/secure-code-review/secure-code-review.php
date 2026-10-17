<?php
// secure-code-review.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'secure-code-review',
    'title'           => 'Secure Code Review',
    'description'     => 'Learn the methodology for reviewing code for security vulnerabilities, spotting high risk patterns, and scaling review with SAST tools.',
    'icon'            => 'fas fa-code',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic understanding of reading source code', 'Familiarity with common web application concepts'],
    'learning_objectives' => [
        'Explain the goal of manual secure code review and how it differs from scanning and pentesting',
        'Read an unfamiliar codebase efficiently by tracing entry points and data flow',
        'Identify high risk patterns in input handling, authentication, cryptography, and serialization',
        'Describe how SAST tools like Semgrep and CodeQL scale review across large codebases',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/secure-code-review-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Secure Code Review Methodology'],
    ['id' => 'task3', 'title' => 'Reading Unfamiliar Codebases Efficiently'],
    ['id' => 'task4', 'title' => 'High Risk Patterns'],
    ['id' => 'task5', 'title' => 'Scaling Review with SAST Tools'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'secure_code_review_progress',
    'instagram_takeaways'  => [
        '✓ Manual code review vs automated scanning vs pentesting',
        '✓ Tracing entry points and data flow through unfamiliar code',
        '✓ High risk patterns: input handling, auth, crypto, serialization',
        '✓ Scaling review with Semgrep and CodeQL',
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
        ['id' => 'q1', 'text' => 'What term describes the boundary where code decides whether to trust incoming data or not?'],
        ['id' => 'q2', 'text' => 'What is the untrusted point where data enters an application called?'],
        ['id' => 'q3', 'text' => 'Besides manual review and automated scanning, what testing approach simulates a real attacker?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What term describes tracing user input as it flows through a program?'],
        ['id' => 'q5', 'text' => 'What is the dangerous function or operation where tainted data is finally used called?'],
        ['id' => 'q6', 'text' => 'What command line tool is commonly used to search source code for risky functions quickly?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What vulnerability results from concatenating user input directly into a SQL query?'],
        ['id' => 'q8', 'text' => 'What is the security flaw called when a loose comparison operator allows type coercion to bypass an authentication check?'],
        ['id' => 'q9', 'text' => 'What vulnerability occurs when untrusted data is passed directly to unserialize()?'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'What term describes a SAST result that is not an actual vulnerability?'],
        ['id' => 'q11', 'text' => 'Which SAST tool uses dataflow based semantic queries to trace complex vulnerabilities, developed by GitHub?'],
        ['id' => 'q12', 'text' => 'Which SAST tool is known for fast, lightweight, pattern based rule matching?'],
    ],
    'task6' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the Vulnerable Login Portal review.'],
    ],
    'task7' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Automated scanners and penetration tests are good at finding what they already know to look for, but they routinely miss the flaws that only become visible when a human reads the logic itself. Secure code review fills that gap. It is the practice of reading source code with the specific goal of finding security weaknesses before an attacker does, and it remains one of the most reliable ways to catch broken authentication, injection points, and unsafe data handling that never trigger an alert.</p>

    <p>By the end of this room, you will be able to approach an unfamiliar codebase methodically, trace how untrusted data moves through an application, recognize the patterns that consistently produce vulnerabilities, and understand how tools like Semgrep and CodeQL help scale review across large repositories. A hands on simulation is included where you will review real PHP code and find the flaws hiding inside it.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the goal of manual secure code review and how it differs from scanning and pentesting.</li>
        <li>Read an unfamiliar codebase efficiently by tracing entry points and data flow.</li>
        <li>Identify high risk patterns in input handling, authentication, cryptography, and serialization.</li>
        <li>Describe how SAST tools like Semgrep and CodeQL scale review across large codebases.</li>
    </ul>
</div>
HTML;

// TASK 2: Secure Code Review Methodology
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Reviewing Code Like an Inspector, Not a Detector</h2>

    <p>A metal detector at an airport catches anything that matches its programmed signature and nothing else. A building inspector walks the structure, checks the wiring, tests the load bearing walls, and notices problems no detector was ever built to find. Manual secure code review plays the inspector's role: it catches the logic flaws, business rule failures, and design weaknesses that automated tools are simply not built to reason about.</p>

    <p>Good review follows a repeatable sequence rather than reading files start to finish in whatever order they happen to sit in a folder. You identify where data enters the application, trace how it moves through the code, assess whether trust boundaries are respected at each step, and document what you find as you go.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Key Point</h4>
        <p>The strongest security programs combine manual review, automated scanning, and penetration testing together. Each approach catches things the other two miss.</p>
    </div>

    <h3>Three Approaches, Three Blind Spots</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Approach</th>
                <th>What It Finds</th>
                <th>Limitation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Manual Code Review</strong></td>
                <td>Logic flaws, broken auth, business rule failures</td>
                <td>Slow, does not scale well to huge codebases alone</td>
            </tr>
            <tr>
                <td><strong>Automated SAST Scanning</strong></td>
                <td>Known unsafe patterns across an entire repository quickly</td>
                <td>Misses logic flaws it was not written to detect</td>
            </tr>
            <tr>
                <td><strong>Penetration Testing</strong></td>
                <td>Real exploitability from an attacker's point of view</td>
                <td>Time boxed, only tests what the tester thinks to try</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: methodology flow diagram
         Teaching purpose: show the learner that review is a repeatable sequential process,
         which they would otherwise misunderstand as randomly browsing files. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 800 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Secure code review methodology flow">
            <!-- Background boxes -->
            <rect x="10"  y="30" width="175" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="210" y="30" width="175" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="410" y="30" width="175" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="610" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="185" y1="70" x2="205" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="385" y1="70" x2="405" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="585" y1="70" x2="605" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="97"  y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Identify Entry</text>
            <text x="97"  y="82" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Points</text>
            <text x="297" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Trace Data</text>
            <text x="297" y="82" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Flow</text>
            <text x="497" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Assess Trust</text>
            <text x="497" y="82" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Boundaries</text>
            <text x="700" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Document</text>
            <text x="700" y="82" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Findings</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Reading Unfamiliar Codebases Efficiently
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Follow the Data, Not the File Order</h2>

    <p>Reading every line of an unfamiliar codebase top to bottom is like reading every page of a novel to understand a single character's story. A far faster approach is to start from the places where the outside world touches the application, then follow that data wherever it goes.</p>

    <p>Those starting points, called entry points, include HTTP parameters, cookies, file uploads, and API request bodies. Anything a user or external system can control counts as an entry point worth tracing. Once you find one, you trace its data flow, which is simply the path that value travels through functions and variables until it reaches a sink, the place where it finally gets used in a way that could be dangerous, such as a database query or a file system call.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Practical Tip</h4>
        <p>Use your editor's global search for terms like <code>$_GET</code>, <code>$_POST</code>, <code>$_COOKIE</code>, or <code>unserialize</code> before reading anything in depth. This surfaces every entry point in seconds instead of hours.</p>
    </div>

    <h3>Common Entry Points</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Entry Point Type</th>
                <th>Example</th>
                <th>Why It Matters</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HTTP Parameters</td>
                <td><code>$_GET</code>, <code>$_POST</code> values</td>
                <td>Fully attacker controlled on every request</td>
            </tr>
            <tr>
                <td>Cookies</td>
                <td><code>$_COOKIE</code> values</td>
                <td>Easy to modify in the browser or with a proxy tool</td>
            </tr>
            <tr>
                <td>File Uploads</td>
                <td>Uploaded file name or contents</td>
                <td>Can carry malicious payloads or path traversal attempts</td>
            </tr>
            <tr>
                <td>API Endpoints</td>
                <td>JSON request bodies</td>
                <td>Often skipped by reviewers who only check web forms</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: entry point to sink diagram
         Teaching purpose: show the learner why tracing data flow matters more than reading
         files sequentially, which they would otherwise misunderstand as "just read everything carefully." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 800 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Entry point to sink data flow diagram">
            <rect x="10"  y="25" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="290" y="25" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="570" y="25" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="230" y1="65" x2="285" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="510" y1="65" x2="565" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="120" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Entry Point</text>
            <text x="120" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">e.g. $_POST value</text>
            <text x="400" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Data Flow</text>
            <text x="400" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">passed through functions</text>
            <text x="680" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Sink</text>
            <text x="680" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">e.g. SQL query, unserialize</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: High Risk Patterns
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Four Places Vulnerabilities Consistently Hide</h2>

    <p>Certain categories of code produce the overwhelming majority of real world vulnerabilities. Learning to recognize these patterns on sight lets you focus your limited review time where it matters most, instead of spreading attention evenly across a codebase where most of it is low risk.</p>

    <h3>High Risk Pattern Categories</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Pattern Category</th>
                <th>What to Look For</th>
                <th>Example Red Flag</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Input Handling</strong></td>
                <td>User input reaching a query, command, or file path</td>
                <td>String concatenated SQL built from <code>$_POST</code></td>
            </tr>
            <tr>
                <td><strong>Authentication</strong></td>
                <td>How identity and session tokens are checked</td>
                <td>Loose <code>==</code> comparison on a password or token</td>
            </tr>
            <tr>
                <td><strong>Cryptography</strong></td>
                <td>Algorithm choice, key handling, randomness source</td>
                <td>Hardcoded encryption keys or weak hash functions</td>
            </tr>
            <tr>
                <td><strong>Serialization</strong></td>
                <td>Where untrusted data is decoded back into objects</td>
                <td>Calling <code>unserialize()</code> on a user supplied cookie</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Flag These On Sight</h4>
        <p>String concatenated SQL queries, <code>==</code> used to compare passwords or tokens, <code>unserialize()</code> called on anything user controlled, and hardcoded keys or secrets anywhere in the source. Each of these has produced real breaches across countless applications.</p>
    </div>
</div>
HTML;

// TASK 5: Scaling Review with SAST Tools
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Reviewing Millions of Lines Instead of Hundreds</h2>

    <p>Manual review works well on a small application, but it cannot realistically cover a codebase with millions of lines spread across hundreds of services. Static Application Security Testing tools, known as SAST, close that gap by scanning source code automatically for known unsafe patterns, giving a reviewer a prioritized starting point instead of a blank repository.</p>

    <p>Two tools dominate this space for different reasons. Semgrep matches lightweight, custom rules against code very quickly, which makes it ideal for enforcing a team's own secure coding rules. CodeQL treats source code as a queryable database and traces data flow semantically, which makes it better suited to finding complex, multi step vulnerabilities across a large codebase.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Tool</th>
                <th>Approach</th>
                <th>Best For</th>
                <th>Limitation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Semgrep</strong></td>
                <td>Fast, pattern based rule matching</td>
                <td>Custom lightweight rules, quick CI checks</td>
                <td>Limited semantic understanding of complex flows</td>
            </tr>
            <tr>
                <td><strong>CodeQL</strong></td>
                <td>Semantic, dataflow based querying</td>
                <td>Tracing complex vulnerabilities across large repos</td>
                <td>Slower, steeper learning curve to write queries</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Practical Tip</h4>
        <p>Every SAST result needs a human decision: true positive or false positive. Triaging tool output well is itself a core review skill, and it is exactly what you will practice next.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been handed a small PHP login and profile application to review. Somewhere inside its five files are three real vulnerabilities, alongside files that follow secure practices and exist only to test whether you can tell the difference.</p>

    <p>Open each file, trace the data flow, and flag the lines you believe are genuinely vulnerable, choosing the correct category for each one. Submit your review once you believe you have found all three.</p>

    <div class="practical-launch-wrapper">
        <a href="secure-code-review-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Vulnerable Login Portal</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the review and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now have a working methodology for secure code review: identify entry points, trace data flow, assess trust boundaries, and document what you find. You have practiced spotting the four pattern categories responsible for most real world vulnerabilities, and you understand how tools like Semgrep and CodeQL let that same discipline scale across codebases far larger than any one person could read alone.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Manual review, automated scanning, and penetration testing each catch different things.</li>
        <li>Start from entry points and trace data flow instead of reading files in order.</li>
        <li>Input handling, authentication, cryptography, and serialization produce the most vulnerabilities.</li>
        <li>Semgrep excels at fast custom pattern matching, CodeQL at tracing complex data flows.</li>
        <li>Triaging true positives from false positives is a core review skill in its own right.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
