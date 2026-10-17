<?php
// ============================================================
// sql-injection.php — ROOM DATA FILE
// Topic: SQL Injection Exploitation (Challenge Room)
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'sql-injection',
    'title'           => 'SQL Injection Exploitation',
    'description'     => 'Investigate a vulnerable search feature and extract hidden data using SQL injection techniques.',
    'icon'            => 'fas fa-database',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic SQL knowledge', 'Basic web application concepts'],
    'learning_objectives' => [
        'Identify a parameter vulnerable to SQL injection through observed application behavior',
        'Determine the number of columns in a vulnerable query using a UNION based technique',
        'Enumerate database schema information through a UNION SELECT injection',
        'Extract data from a table that was never intended to be publicly accessible',
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
    ['id' => 'task2', 'title' => 'Storefront Search Exploit'],
    ['id' => 'task3', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'sql_injection_progress',
    'instagram_takeaways'  => [
        '✓ How SQL injection lets input break a query\'s intended logic',
        '✓ Using UNION SELECT to confirm column count',
        '✓ Enumerating a database schema through injection',
        '✓ Extracting data from a table that was never meant to be public',
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
        ['id' => 'q1', 'text' => 'What HTTP parameter carries the search term to the server?'],
        ['id' => 'q2', 'text' => 'What is the name of the vulnerable database table storing the products?'],
        ['id' => 'q3', 'text' => 'How many columns does the vulnerable query select?'],
        ['id' => 'q4', 'text' => 'What is the name of the hidden table discovered through schema enumeration?'],
        ['id' => 'q5', 'text' => 'What username is stored in the admin_users table?'],
        ['id' => 'q6', 'text' => 'What password hash is stored for that account?'],
        ['id' => 'q7', 'text' => 'What email domain is used by the admin account?'],
        ['id' => 'q8', 'text' => 'Enter the flag revealed after extracting the admin table.'],
    ],
    'task3' => [
        ['id' => 'q9', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>SQL injection is one of the most common vulnerabilities in web applications, occurring when user supplied input is inserted directly into a database query without proper validation or escaping. A single unprotected input field, such as a search box or login form, can allow an attacker to alter the logic of a query and access data that was never meant to be exposed.</p>

    <p>This room is challenge based. Instead of working through separate theory tasks, you will investigate a simulated online storefront directly, discover the vulnerable search parameter, and work through the injection process step by step to extract hidden data and retrieve a flag.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Identify a parameter vulnerable to SQL injection through observed application behavior.</li>
        <li>Determine the number of columns in a vulnerable query using a UNION based technique.</li>
        <li>Enumerate database schema information through a UNION SELECT injection.</li>
        <li>Extract data from a table that was never intended to be publicly accessible.</li>
    </ul>
</div>
HTML;

// TASK 2: Storefront Search Exploit (Challenge Task)
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Challenge Briefing</h2>
    <p>Nova Threads is a fictional online clothing retailer. Their product search feature passes user input directly into a backend SQL query without sanitizing it first. You have been asked to assess this endpoint and determine how far the exposure goes.</p>

    <p>The storefront looks like any ordinary shop. A search box lets customers look up products by name. Behind the scenes, that search term is inserted straight into a SQL query, and the console in front of you gives visibility into exactly what that query looks like after every search.</p>

    <p>Your job is to work through the search console, confirm the injection point, and use it to enumerate the database and pull data from a table that customers were never supposed to see.</p>

    <h3>Objectives</h3>
    <ol>
        <li>Confirm that the search parameter reflects directly into a live SQL query.</li>
        <li>Trigger a syntax error to reveal the structure of the underlying table.</li>
        <li>Determine the exact number of columns returned by the query.</li>
        <li>Enumerate the database schema to discover tables beyond the products table.</li>
        <li>Extract data from the hidden table you discover.</li>
    </ol>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What to Look For</h4>
        <ul>
            <li>Watch the Request Inspector panel after every search. It shows the exact query built from your input.</li>
            <li>A single quote is often the fastest way to test whether input is escaped.</li>
            <li>A UNION SELECT will only succeed once your column count matches the original query exactly.</li>
            <li>The schema panel stays empty until a UNION SELECT correctly targets it.</li>
        </ul>
    </div>

    <div class="practical-launch-wrapper">
        <a href="sql-injection-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Search Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 3: Conclusion
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <p>This challenge showed how a single unescaped input field can expose an entire database. What began as a simple syntax error led to full schema enumeration and, ultimately, extraction of data from a table that was never meant to be public. This progression, confirming the flaw, mapping the query, then exploiting it, mirrors how real SQL injection attacks unfold against production systems.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Unsanitized input passed into SQL queries can break the intended query logic.</li>
        <li>Verbose error messages can unintentionally reveal table and column structure.</li>
        <li>A UNION SELECT requires matching column counts before it will succeed.</li>
        <li>Schema enumeration lets an attacker discover tables outside the intended scope.</li>
        <li>Parameterized queries and prepared statements are the standard defense against this entire attack class.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
