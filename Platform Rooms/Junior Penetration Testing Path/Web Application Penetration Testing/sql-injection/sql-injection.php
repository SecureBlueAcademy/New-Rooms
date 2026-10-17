<?php
// Filename: sql-injection.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'sql-injection',
    'title'           => 'SQL Injection',
    'description'     => 'Learn how SQL injection breaks out of the intended query structure to manipulate a database, covering error-based, blind, and time-based techniques.',
    'icon'            => 'fas fa-database',
    'banner'          => '../../assets/banner-sql-injection.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic SQL knowledge', 'Basic web application concepts'],
    'learning_objectives' => [
        'Explain how user input can break out of the intended SQL query structure',
        'Identify error-based SQL injection and the risks of verbose error messages',
        'Understand how blind SQL injection extracts data without visible output',
        'Recognize time-based SQL injection and how response delays reveal data',
        'Apply SQL injection concepts to trace and exploit a vulnerable login system',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/sql-injection-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is SQL Injection?'],
    ['id' => 'task3', 'title' => 'Error-Based SQL Injection'],
    ['id' => 'task4', 'title' => 'Blind SQL Injection'],
    ['id' => 'task5', 'title' => 'Time-Based SQL Injection'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'sql_injection_progress',
    'instagram_takeaways'  => [
        '✓ How SQL injection breaks intended query structure',
        '✓ Error-based injection and information disclosure',
        '✓ Blind SQL injection and boolean oracles',
        '✓ Time-based injection using response delays',
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
        ['id' => 'q1', 'text' => 'What character is commonly used to break out of a SQL query\'s string logic?'],
        ['id' => 'q2', 'text' => 'What term describes inserting user input directly into a SQL query string instead of separating it?'],
        ['id' => 'q3', 'text' => 'What technique separates user input from query logic to prevent SQL injection?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What type of SQL injection relies on database error messages to reveal information?'],
        ['id' => 'q5', 'text' => 'What term describes information being unintentionally revealed through system output such as error messages?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What type of SQL injection is used when no error messages or query output are directly visible?'],
        ['id' => 'q7', 'text' => 'What type of blind SQL injection relies on true or false responses to infer data?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What type of blind SQL injection relies on response delays instead of visible output?'],
        ['id' => 'q9', 'text' => 'What SQL function is commonly used to introduce a deliberate delay for time-based injection?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Enter the flag you discovered in the Meridian Employee Portal.'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>SQL injection happens when user input is treated as part of a database command instead of just data. A login box, a search field, or a URL parameter can all become a way to rewrite the logic of a query, letting an attacker read, modify, or bypass data they were never meant to touch. It has remained one of the most exploited web vulnerabilities for over two decades.</p>

    <p>By the end of this room you will understand how a raw string of user input can reshape a SQL query, and how attackers use error messages, true or false responses, and timing delays to pull data out of a database that gives away nothing directly. A hands-on lab is included where you will trace a real login bypass through each of these stages yourself.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain how user input can break out of the intended SQL query structure.</li>
        <li>Identify error-based SQL injection and the risks of verbose error messages.</li>
        <li>Understand how blind SQL injection extracts data without visible output.</li>
        <li>Recognize time-based SQL injection and how response delays reveal data.</li>
        <li>Apply SQL injection concepts to trace and exploit a vulnerable login system.</li>
    </ul>
</div>
HTML;

// TASK 2: What is SQL Injection?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Breaking the Query</h2>

    <p>A web application often builds a SQL query by joining fixed text with whatever the user typed. If a login form checks a username with a query like <code>SELECT * FROM users WHERE username = 'INPUT'</code>, the application is trusting that the input will only ever be a plain username.</p>

    <p>The problem appears the moment a user includes a quote character. A single <strong>quote</strong> can close the string early, and anything typed after it is read by the database as part of the query itself, not as data. This is the core idea behind every SQL injection attack.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>SQL injection has appeared on the OWASP Top 10 for years and still shows up in real breaches today. A single unescaped input field can expose an entire database.</p>
    </div>

    <p>Consider a login form that takes a username and password. If the application builds this query directly from user input, typing <code>admin' -- </code> as the username can bypass the password check entirely, because everything after the double dash is treated as a comment and ignored by the database.</p>

    <h3>Two Ways to Handle the Same Input</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Approach</th>
                <th>How Input Is Handled</th>
                <th>Vulnerable to Injection?</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Concatenated Query</strong></td>
                <td>User input is joined directly into the query text as a string.</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td><strong>Parameterized Query</strong></td>
                <td>User input is passed separately and always treated as data, never as query code.</td>
                <td>No</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Query concatenation diagram
         Teaching purpose: show the learner exactly how a raw input string gets
         joined into the query text, which they would otherwise misunderstand as
         the database "understanding" the user's intent rather than blindly
         assembling text. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="User input concatenated into a SQL query">
            <!-- Input box -->
            <rect x="20" y="20" width="300" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="170" y="40" text-anchor="middle" font-size="12" fill="var(--text-secondary)">User Input (username field)</text>
            <text x="170" y="58" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)" font-family="monospace">admin' --</text>

            <!-- Arrow down -->
            <line x1="170" y1="70" x2="170" y2="105" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrDown)"/>
            <defs>
                <marker id="arrDown" markerWidth="8" markerHeight="8" refX="4" refY="6" orient="auto">
                    <path d="M0,0 L8,0 L4,6 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <!-- Resulting query box -->
            <rect x="20" y="110" width="720" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="35" y="132" font-size="12" fill="var(--text-secondary)">Resulting Query Sent to the Database</text>
            <text x="35" y="155" font-size="13" font-family="monospace" fill="var(--text-primary)">SELECT * FROM users WHERE username = 'admin' </text>
            <text x="35" y="172" font-size="13" font-family="monospace" fill="var(--text-secondary)">-- ' AND password = '...'   (ignored as a comment)</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>The database never sees "intent." It only sees text. If that text can be reshaped by user input, the query's logic can be reshaped too.</p>
    </div>
</div>
HTML;

// TASK 3: Error-Based SQL Injection
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Letting the Database Talk</h2>

    <p>Error-based SQL injection works by intentionally sending input that breaks the query's syntax. When the database fails to parse the broken query, it often returns a detailed error message describing exactly what went wrong.</p>

    <p>These messages are meant to help developers debug their code, but if they are shown to the public, they can leak table names, column names, or even the name of the database itself.</p>

    <!-- SVG: Error-based injection flow
         Teaching purpose: show the learner the path from malformed input to a
         broken query to a leaked error message, which they would otherwise
         misunderstand as a random bug rather than a deliberate, repeatable
         technique. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Error-based injection flow">
            <rect x="10"  y="20" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="270" y="20" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="530" y="20" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="230" y1="60" x2="265" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="490" y1="60" x2="525" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="120" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Malformed Input</text>
            <text x="120" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">A single stray quote</text>
            <text x="380" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Broken Query</text>
            <text x="380" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Syntax fails to parse</text>
            <text x="640" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Leaked Error</text>
            <text x="640" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Details exposed to user</text>
        </svg>
    </div>

    <p>For example, submitting a single quote into a search field might return an error such as:</p>
    <p><code>SQL Error: unterminated quoted string near "'" in query on database "meridian_hr"</code></p>
    <p>That one message just revealed the name of the underlying database, information the attacker never should have seen.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Defense</h4>
        <p>Disabling verbose error messages in production, and instead logging them privately, removes this entire attack path without changing how the application works.</p>
    </div>
</div>
HTML;

// TASK 4: Blind SQL Injection
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Extracting Data Without Seeing It</h2>

    <p>Not every vulnerable application shows errors or query output. Blind SQL injection is used when the attacker gets no direct feedback from the database, only a difference in how the application behaves.</p>

    <p>In boolean-based blind SQL injection, the attacker sends a condition that is either true or false, such as <code>' AND 1=1 -- </code> versus <code>' AND 1=2 -- </code>, and watches for any change in the response. This could be a different page, a missing element, or a subtle visual cue.</p>

    <p>This is similar to playing twenty questions. You never see the answer directly, but by asking a long sequence of yes or no questions, you can eventually work out the full picture one piece at a time.</p>

    <!-- SVG: Boolean oracle building an answer over time
         Teaching purpose: show the learner that a single true/false response
         reveals almost nothing, but many of them combined can reconstruct a
         full value, which they would otherwise misunderstand as instant data
         extraction. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Boolean blind injection building an answer over time">
            <text x="10" y="25" font-size="12" fill="var(--text-secondary)">Repeated true/false queries, one character at a time:</text>
            <g font-family="monospace" font-size="14">
                <rect x="10"  y="45" width="60" height="40" rx="6" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
                <text x="40" y="70" text-anchor="middle" fill="var(--text-primary)">A</text>
                <rect x="90" y="45" width="60" height="40" rx="6" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
                <text x="120" y="70" text-anchor="middle" fill="var(--text-primary)">D</text>
                <rect x="170" y="45" width="60" height="40" rx="6" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
                <text x="200" y="70" text-anchor="middle" fill="var(--text-primary)">M</text>
                <rect x="250" y="45" width="60" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="4 3"/>
                <text x="280" y="70" text-anchor="middle" fill="var(--text-secondary)">?</text>
                <rect x="330" y="45" width="60" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="4 3"/>
                <text x="360" y="70" text-anchor="middle" fill="var(--text-secondary)">?</text>
            </g>
            <text x="10" y="110" font-size="11" fill="var(--text-secondary)">Each confirmed letter came from many individual true/false checks against the database.</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why It Is Slower</h4>
        <p>Because each query only reveals a single true or false answer, extracting even a short piece of data can take hundreds of requests, far more than a single leaked error message.</p>
    </div>
</div>
HTML;

// TASK 5: Time-Based SQL Injection
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When Even True or False Is Invisible</h2>

    <p>Sometimes an application gives no visible difference at all between a true and a false condition, not even a subtle one. Time-based SQL injection solves this by making the database itself pause for a set number of seconds when a condition is true.</p>

    <p>A common payload uses a function like <code>SLEEP(5)</code> inside a conditional statement. If the page takes five extra seconds to respond, the condition was true. If it responds immediately, the condition was false. The timing itself becomes the signal.</p>

    <p>This is similar to knocking on a door and judging whether someone is home by how long it takes for nothing to happen. You are not seeing or hearing a direct answer, only measuring a delay.</p>

    <!-- SVG: Boolean-based vs time-based signal comparison
         Teaching purpose: show the learner the difference between a visible
         true/false signal and a timing-based signal, which they would
         otherwise treat as the same technique. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Boolean-based versus time-based blind injection">
            <rect x="20" y="20" width="340" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="190" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Boolean-Based</text>
            <text x="190" y="68" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Signal: visible response difference</text>
            <text x="190" y="86" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Read instantly from the page</text>

            <rect x="400" y="20" width="340" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="570" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Time-Based</text>
            <text x="570" y="68" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Signal: response delay</text>
            <text x="570" y="86" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Measured with a stopwatch, not sight</text>
        </svg>
    </div>

    <h3>Comparing the Three Techniques</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Technique</th>
                <th>Signal Used</th>
                <th>Speed</th>
                <th>Detectability</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Error-Based</strong></td>
                <td>Visible error message</td>
                <td>Fast</td>
                <td>High</td>
            </tr>
            <tr>
                <td><strong>Blind (Boolean)</strong></td>
                <td>True or false response</td>
                <td>Slow</td>
                <td>Medium</td>
            </tr>
            <tr>
                <td><strong>Time-Based</strong></td>
                <td>Response delay</td>
                <td>Slowest</td>
                <td>Low</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Still Effective</h4>
        <p>Time-based injection is slow and can generate a lot of traffic, but it works even against applications that give away nothing visible at all, making it a reliable last resort for an attacker.</p>
    </div>
</div>
HTML;

// TASK 6: Practical (Meridian Employee Portal)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>The Meridian Logistics employee portal has a known SQL injection vulnerability across several of its login and search fields. Your job is to work through three stages: bypass the login, trigger a database error to leak information, and use a true or false condition to confirm access to the admin session.</p>

    <p>Each stage builds on what you just learned. Complete them in order to reach the admin dashboard and retrieve the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="sql-injection-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Meridian Employee Portal</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how SQL injection turns user input into query logic, and how attackers escalate from a simple broken quote to a full login bypass. Error-based injection uses verbose messages to leak information directly, blind injection infers data through true or false differences, and time-based injection measures delays when nothing else is visible.</p>

    <p>These three techniques form a natural progression an attacker follows when probing an unfamiliar target, and recognizing each one is the first step toward defending against all of them.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>SQL injection happens when user input is treated as query code instead of data.</li>
        <li>Parameterized queries separate input from logic and prevent injection entirely.</li>
        <li>Error-based injection leaks information through verbose database error messages.</li>
        <li>Blind SQL injection extracts data using true or false responses when no output is visible.</li>
        <li>Time-based injection uses response delays as a signal when even true or false is invisible.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA. Engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
