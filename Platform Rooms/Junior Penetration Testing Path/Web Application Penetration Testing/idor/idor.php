<?php
// idor.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'idor-broken-access-control',
    'title'           => 'Insecure Direct Object References (IDOR)',
    'description'     => 'Learn to identify and exploit IDOR vulnerabilities where changing a parameter grants access to another user\'s data.',
    'icon'            => 'fas fa-folder-open',
    'banner'          => '../../assets/banner-web.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic web browsing knowledge', 'Basic understanding of user accounts'],
    'learning_objectives' => [
        'Explain what Insecure Direct Object References are',
        'Distinguish horizontal from vertical privilege escalation',
        'Identify how missing access checks lead to data exposure',
        'Apply basic IDOR testing methodology',
        'Recognize common fixes for broken access control',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/idor-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Broken Access Control?'],
    ['id' => 'task3', 'title' => 'Horizontal Privilege Escalation'],
    ['id' => 'task4', 'title' => 'Vertical Privilege Escalation'],
    ['id' => 'task5', 'title' => 'Finding and Preventing IDOR'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'idor_progress',
    'instagram_takeaways'  => [
        '✓ Insecure Direct Object References (IDOR) explained',
        '✓ Horizontal vs Vertical privilege escalation',
        '✓ How broken access control exposes data',
        '✓ Testing and preventing IDOR vulnerabilities',
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
        ['id' => 'q1', 'text' => 'What is the general security category that IDOR falls under?'],
        ['id' => 'q2', 'text' => 'What term describes a parameter that points directly at an internal object with no ownership check?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the term for accessing another user\'s data at the same privilege level?'],
        ['id' => 'q4', 'text' => 'What term describes an identifier that is easy to guess because it follows a simple sequence?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the term for accessing data or functionality meant for a higher privilege level?'],
        ['id' => 'q6', 'text' => 'Which type of privilege escalation is generally considered more severe, horizontal or vertical?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'Where must ownership checks always be performed to prevent IDOR?'],
        ['id' => 'q8', 'text' => 'What technique replaces predictable IDs with non-guessable references to prevent IDOR?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Enter the flag you discovered in the CloudDocs File Manager.'],
    ],
    'task7' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Insecure Direct Object References, or IDOR, occur when an application exposes internal objects such as files, records, or accounts directly through parameters like an ID number, and fails to check whether the person requesting that object is actually allowed to see it. It is one of the most common vulnerabilities in web applications today, and one of the easiest to test for once you know what to look for.</p>

    <p>By the end of this room you will be able to identify how a missing access check turns a simple parameter into a security hole, tell the difference between horizontal and vertical privilege escalation, and apply a basic testing method to find these issues yourself. A hands-on lab using a simulated file management portal is included.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what Insecure Direct Object References are.</li>
        <li>Distinguish horizontal from vertical privilege escalation.</li>
        <li>Identify how missing access checks lead to data exposure.</li>
        <li>Apply basic IDOR testing methodology.</li>
        <li>Recognize common fixes for broken access control.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Broken Access Control?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>When Permission Checks Go Missing</h2>

    <p>Access control is the set of rules that decide who can see or do what inside a system. Broken access control happens when those rules are missing, incomplete, or can be bypassed, and IDOR is one of the most common ways this shows up in real applications.</p>

    <p>A <strong>direct object reference</strong> is simply a value, usually an ID number, that points straight at an internal object such as a file, an invoice, or a user account. On its own a direct object reference is not a problem. The vulnerability appears when the system trusts that reference without checking whether the requester actually owns it.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What Is a Direct Object Reference?</h4>
        <p>A direct object reference is any parameter, such as doc_id or account_id, that maps directly to a specific record. If changing that value lets you view someone else's data, the system is not checking ownership.</p>
    </div>

    <p>Think of a hotel where every room shares the same type of key card reader. If the reader never checks which room your key card is actually for, typing in any room number opens that door. The lock exists, but the check behind it does not.</p>

    <!-- SVG: Secure vs vulnerable request flow
         Teaching purpose: show the learner that the difference between a safe
         system and a vulnerable one is the presence of an ownership check, not
         the parameter itself, which they would otherwise misunderstand as
         "any changeable parameter is automatically a vulnerability". -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Secure system versus vulnerable system request flow">
            <!-- Secure system column -->
            <rect x="20" y="10" width="330" height="200" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="185" y="35" text-anchor="middle" font-size="14" font-weight="600" fill="var(--success)">Secure System</text>

            <rect x="45" y="55" width="280" height="35" rx="6" fill="none" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="77" text-anchor="middle" font-size="12" fill="var(--text-primary)">Request: doc_id=205</text>

            <line x1="185" y1="90" x2="185" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrA)"/>

            <rect x="45" y="118" width="280" height="35" rx="6" fill="none" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="140" text-anchor="middle" font-size="12" fill="var(--text-primary)">Ownership check runs</text>

            <line x1="185" y1="153" x2="185" y2="178" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrA)"/>

            <rect x="45" y="181" width="280" height="30" rx="6" fill="none" stroke="var(--success)" stroke-width="1.5"/>
            <text x="185" y="201" text-anchor="middle" font-size="12" fill="var(--success)">Access denied, not the owner</text>

            <!-- Vulnerable system column -->
            <rect x="410" y="10" width="330" height="200" rx="10" fill="var(--surface)" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="575" y="35" text-anchor="middle" font-size="14" font-weight="600" fill="var(--error, #ff5c5c)">Vulnerable System</text>

            <rect x="435" y="55" width="280" height="35" rx="6" fill="none" stroke="var(--border)" stroke-width="1.5"/>
            <text x="575" y="77" text-anchor="middle" font-size="12" fill="var(--text-primary)">Request: doc_id=205</text>

            <line x1="575" y1="90" x2="575" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrA)"/>

            <rect x="435" y="118" width="280" height="35" rx="6" fill="none" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="4 4"/>
            <text x="575" y="140" text-anchor="middle" font-size="12" fill="var(--text-secondary)">No ownership check</text>

            <line x1="575" y1="153" x2="575" y2="178" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrA)"/>

            <rect x="435" y="181" width="280" height="30" rx="6" fill="none" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="575" y="201" text-anchor="middle" font-size="12" fill="var(--error, #ff5c5c)">Data returned anyway</text>

            <defs>
                <marker id="arrA" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Horizontal Privilege Escalation
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Reaching Sideways Into Someone Else's Data</h2>

    <p>Horizontal privilege escalation happens when a user accesses another user's data at the exact same permission level. Both accounts have identical privileges, the only difference is whose records are being viewed.</p>

    <p>It is like two neighbors with identical mailboxes on the same street. If the mailbox numbers are easy to guess and nothing stops you from opening any box, you can read someone else's mail even though neither of you has more authority than the other.</p>

    <h3>Common Horizontal Escalation Scenarios</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Scenario</th>
                <th>Who Is Affected</th>
                <th>What Is Exposed</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Online banking app</td>
                <td>Another customer</td>
                <td>Account balance and transaction history</td>
            </tr>
            <tr>
                <td>Cloud file storage</td>
                <td>Another employee</td>
                <td>Private documents</td>
            </tr>
            <tr>
                <td>Healthcare portal</td>
                <td>Another patient</td>
                <td>Medical records</td>
            </tr>
            <tr>
                <td>Support ticket system</td>
                <td>Another customer</td>
                <td>Support conversation history</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 4: Vertical Privilege Escalation
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Reaching Upward Into Higher Privilege</h2>

    <p>Vertical privilege escalation happens when a regular user gains access to data or functionality that should only be available to a higher privilege level, such as an administrator.</p>

    <p>Imagine an employee badge that opens your own office door. Vertical escalation is like that same badge, through a missing check, also opening the door to the manager's office upstairs.</p>

    <!-- SVG: Horizontal vs vertical escalation direction
         Teaching purpose: show the learner that horizontal escalation moves
         sideways between equal users while vertical escalation moves upward
         into higher privilege, which they would otherwise misunderstand as
         two names for the same category of risk. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Horizontal versus vertical privilege escalation">
            <!-- User boxes, same level -->
            <rect x="60" y="180" width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="130" y="212" text-anchor="middle" font-size="13" fill="var(--text-primary)">User A</text>

            <rect x="300" y="180" width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="370" y="212" text-anchor="middle" font-size="13" fill="var(--text-primary)">User B</text>

            <line x1="200" y1="207" x2="295" y2="207" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrB)" marker-start="url(#arrB)"/>
            <text x="248" y="190" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Horizontal</text>

            <!-- Admin box, higher level -->
            <rect x="300" y="30" width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--warning, #ffd36a)" stroke-width="1.5"/>
            <text x="370" y="62" text-anchor="middle" font-size="13" fill="var(--warning, #ffd36a)">Administrator</text>

            <line x1="370" y1="175" x2="370" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrB)"/>
            <text x="440" y="130" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Vertical</text>

            <defs>
                <marker id="arrB" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Higher Severity</h4>
        <p>Vertical privilege escalation is generally considered more severe than horizontal escalation, since it can expose administrative functions, system settings, or data belonging to every user rather than just one.</p>
    </div>
</div>
HTML;

// TASK 5: Finding and Preventing IDOR
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Testing for and Fixing the Gap</h2>

    <p>Testing for IDOR starts with finding parameters that reference an object directly, such as an ID number in a link or request. Once you find one, try adjacent or predictable values and observe whether the system returns data it should not.</p>

    <p>If access is granted without any check on who owns the resource, the application has an IDOR vulnerability. The fix is never a client side restriction. Every request must be verified on the server.</p>

    <h3>Problem and Fix</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Problem</th>
                <th>Fix</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>No ownership check</td>
                <td>Verify server side that the requester owns the resource</td>
            </tr>
            <tr>
                <td>Predictable sequential IDs</td>
                <td>Use non-guessable identifiers or an indirect reference map</td>
            </tr>
            <tr>
                <td>Trusting client input</td>
                <td>Never rely on the client to enforce access control</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>The core defense against IDOR is simple. Always verify on the server that the logged in user is allowed to access the specific object being requested, every single time.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have employee access to CloudDocs, an internal file portal used across the company. Your manager mentions a rumor that some employees have been able to view files that are not theirs simply by changing a link.</p>

    <p>Open the CloudDocs File Manager below and investigate. Start with your own document, then see how far the exposure goes.</p>

    <div class="practical-launch-wrapper">
        <a href="idor-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch CloudDocs File Manager</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have now seen how Insecure Direct Object References turn a simple parameter into a serious security gap. The vulnerability is never the ID itself. It is the missing check that should confirm the requester actually owns the object being requested.</p>

    <p>Horizontal escalation exposes data belonging to equal users, while vertical escalation reaches into higher privilege data and functionality. Both come from the same root cause, and both are fixed the same way, with real ownership verification enforced on the server.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>IDOR happens when an application trusts a parameter without checking ownership.</li>
        <li>Horizontal escalation exposes another user's data at the same privilege level.</li>
        <li>Vertical escalation exposes higher privilege data or functionality.</li>
        <li>Fixing IDOR always requires server side authorization checks, never client side trust.</li>
        <li>Predictable identifiers make IDOR easier to discover and exploit.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
