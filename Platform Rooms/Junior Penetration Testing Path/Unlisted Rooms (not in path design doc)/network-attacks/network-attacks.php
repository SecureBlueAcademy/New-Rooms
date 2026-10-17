<?php
// ============================================================
// network-attacks.php — ROOM DATA FILE
// Type B Challenge Room: The Intrusion Trace
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'network-attacks-intrusion-trace',
    'title'           => 'Network Attacks: The Intrusion Trace',
    'description'     => 'Investigate a real intrusion by tracing an attacker through network traffic, authentication logs, and firewall rules.',
    'icon'            => 'fas fa-network-wired',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '45 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Familiarity with IP addresses and ports'],
    'learning_objectives' => [
        'Recognize the signature of a port scan in raw network traffic',
        'Correlate traffic data with authentication logs to identify a compromised account',
        'Identify a misconfigured firewall rule that enabled unauthorized access',
        'Reconstruct a full attack path from initial scan to system access',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/network-attacks-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'The Intrusion Trace'],
    ['id' => 'task3', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'network_attacks_progress',
    'instagram_takeaways'  => [
        '✓ Port scans leave a clear pattern across many ports from one source',
        '✓ Cross referencing traffic logs and auth logs reveals compromised accounts',
        '✓ Temporary firewall exceptions are a common real world breach cause',
        '✓ Reconstructing an attack path takes multiple independent data sources',
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
        ['id' => 'q1', 'text' => 'What is the IP address of the attacking host?'],
        ['id' => 'q2', 'text' => 'What type of scan did the attacker perform against the server?'],
        ['id' => 'q3', 'text' => 'How many distinct ports were scanned before the attacker found one open?'],
        ['id' => 'q4', 'text' => 'What username did the attacker successfully compromise?'],
        ['id' => 'q5', 'text' => 'What port did the attacker use to gain remote access?'],
        ['id' => 'q6', 'text' => 'What remote access protocol did the attacker exploit?'],
        ['id' => 'q7', 'text' => 'Which firewall rule ID allowed the malicious traffic through?'],
        ['id' => 'q8', 'text' => 'Enter the flag revealed in the Investigation Summary.'],
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
    <p>Network attacks rarely start with a dramatic exploit. They usually start with something small: a scan across a range of ports, a login attempt that eventually succeeds, or a firewall rule left open after maintenance. Learning to read the trail these actions leave behind is one of the most valuable skills in defensive security.</p>

    <p>This room is built entirely around one investigation. Instead of reading through theory first, you will step directly into the role of an incident responder and work through real captured data to reconstruct exactly how an attacker broke into a server.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Recognize the signature of a port scan in raw network traffic</li>
        <li>Correlate traffic data with authentication logs to identify a compromised account</li>
        <li>Identify a misconfigured firewall rule that enabled unauthorized access</li>
        <li>Reconstruct a full attack path from initial scan to system access</li>
    </ul>
</div>
HTML;

// TASK 2: The Intrusion Trace (Challenge Task)
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Challenge Briefing</h2>
    <p>DB SERVER 01 has been flagged by the overnight monitoring sensor. Somewhere between 2 and 3 AM, the server received a burst of unusual connection attempts, followed by a successful remote login from an account that should not have been active at that hour.</p>

    <p>You have been assigned as the incident responder. Security has pulled three independent data sources from the affected systems: the network sensor capture, the authentication service log, and the current firewall rule table.</p>

    <p>Your job is to piece these three sources together, in order, to answer a simple question: how did the attacker get in? Nothing in this task is guesswork. Every answer exists somewhere in the data you are about to open.</p>

    <h3>Objectives</h3>
    <ol>
        <li>Identify the source of the suspicious traffic and the scanning technique used</li>
        <li>Determine which account was targeted and ultimately compromised</li>
        <li>Identify which port and protocol were used to gain access</li>
        <li>Locate the firewall rule that should have blocked the connection but did not</li>
    </ol>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What to Look For</h4>
        <ul>
            <li>Look closely at timestamps across all three panels. They line up.</li>
            <li>A single external IP address appears in more than one panel. Find it first.</li>
            <li>Not every firewall rule follows the same access restriction. One stands out from the pattern of its neighbors.</li>
            <li>You must open every panel before the Investigation Summary will unlock.</li>
        </ul>
    </div>

    <div class="practical-launch-wrapper">
        <a href="network-attacks-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Intrusion Trace Lab</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the investigation and return here to answer the questions below.</p>
    </div>
</div>
HTML;

// TASK 3: Conclusion
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <p>This investigation walked through a complete attack chain: reconnaissance through scanning, a targeted attempt against a single account, and a successful breach enabled by a forgotten firewall exception. Scan, target, exploit a misconfiguration is one of the most common ways real networks are compromised.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Port scans generate a recognizable pattern of rapid connection attempts across many ports from one source</li>
        <li>Correlating traffic logs with authentication logs reveals which accounts were actually targeted</li>
        <li>Temporary firewall exceptions are a common and dangerous source of real breaches</li>
        <li>Reconstructing an attack path requires cross referencing multiple independent data sources</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
