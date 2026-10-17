<?php
// network-scanning.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'network-scanning',
    'title'           => 'Network Scanning',
    'description'     => 'Reconstruct a real scanning engagement by investigating command history, scan output, and analyst notes.',
    'icon'            => 'fas fa-satellite-dish',
    'banner'          => '../../assets/banner-scanning.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of TCP and UDP ports'],
    'learning_objectives' => [
        'Reconstruct a scanning engagement from raw command history and output data',
        'Identify open ports, running services, and versions from scan output',
        'Recognize how vulnerability scripts flag known weaknesses in outdated services',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/network-scanning-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Terminal Recon'],
    ['id' => 'task3', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'network_scanning_progress',
    'instagram_takeaways'  => [
        '✓ Host discovery finds which systems are alive',
        '✓ Full port scans reveal every open door on a target',
        '✓ Version detection identifies the software behind each port',
        '✓ Vulnerability scripts flag known weaknesses automatically',
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
        ['id' => 'q1', 'text' => 'How many hosts responded to the discovery scan?'],
        ['id' => 'q2', 'text' => 'Which port on 10.50.60.5 runs the encrypted web service?'],
        ['id' => 'q3', 'text' => 'What service and version is running on port 21 of 10.50.60.12?'],
        ['id' => 'q4', 'text' => 'What CVE is tied to the vulnerability found on the FTP service?'],
        ['id' => 'q5', 'text' => 'Which UDP port was found open for the DNS service on 10.50.60.18?'],
        ['id' => 'q6', 'text' => 'What operating system was identified on 10.50.60.44?'],
        ['id' => 'q7', 'text' => 'Which host has the most open TCP ports discovered?'],
        ['id' => 'q8', 'text' => 'Enter the flag revealed after completing the recon.'],
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
    <p>Network scanning is the process of systematically probing systems to discover which hosts are alive, which ports are open, and what services are running behind them. It is the first step of nearly every security assessment and every real intrusion, and the data it produces shapes every decision that follows.</p>

    <p>This is a challenge room. Instead of reading theory, you will reconstruct a real scanning engagement by digging through command history, scan output, and analyst notes left behind after an assessment. Everything you need to answer the questions exists inside the environment itself.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Reconstruct a scanning engagement from raw command history and output data</li>
        <li>Identify open ports, running services, and versions from scan output</li>
        <li>Recognize how vulnerability scripts flag known weaknesses in outdated services</li>
        <li>Understand how a scan progresses from host discovery to targeted enumeration</li>
    </ul>
</div>
HTML;

// TASK 2: Terminal Recon (Challenge Task)
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Challenge Briefing</h2>
    <p>You have been brought in to review a completed engagement against Meridian Logistics, a mid sized shipping company. The assessment covered a small internal range, 10.50.60.0/24, and the original analyst has already moved on to another project.</p>

    <p>All that remains is their terminal session history: the exact commands they ran, the raw output each command produced, and a short set of handwritten notes. Nothing has been summarized for you.</p>

    <p>Your job is to sit in the analyst's seat, work through that history in order, and rebuild a clear picture of what was found on the network. Every answer below exists somewhere in that history.</p>

    <h3>Objectives</h3>
    <ol>
        <li>Open the command history and read it from the first entry to the last</li>
        <li>Open the saved output for every command, not just the ones that look interesting</li>
        <li>Read the analyst's notes for context on which host mattered most</li>
        <li>Identify the operating system, services, and versions found on each host</li>
        <li>Locate the one finding tied to a known vulnerability</li>
        <li>Launch the environment and work through it fully to reveal the flag</li>
    </ol>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What to Look For</h4>
        <p>Pay attention to which scan type each command used. A discovery scan only tells you a host is alive, a full port scan tells you which ports are open, and a version scan tells you what software is behind each port. The vulnerability script output near the end ties a specific service to a known weakness. Read every output panel before answering, since some questions depend on details that are easy to skim past.</p>
    </div>

    <div class="practical-launch-wrapper">
        <a href="network-scanning-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Terminal Recon</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 3: Conclusion
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <p>You have now reconstructed a full scanning engagement from raw terminal history, the same way an analyst would piece together someone else's work. Host discovery told you what was alive, full port scans told you what was open, version detection told you what was running, and a vulnerability script tied one of those services to a known weakness.</p>

    <p>These are the exact steps that happen before any deeper assessment or exploitation can begin, and reading scan output carefully is a skill that transfers directly to real engagements.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Host discovery scans identify which systems are alive before deeper scanning begins</li>
        <li>Full port scans reveal every open port on a target</li>
        <li>Version detection identifies the specific software and version behind a port</li>
        <li>Vulnerability scripts can automatically flag known weaknesses tied to outdated software</li>
        <li>UDP scanning requires different techniques and interpretation than TCP scanning</li>
    </ul>
</div>
HTML;

// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
