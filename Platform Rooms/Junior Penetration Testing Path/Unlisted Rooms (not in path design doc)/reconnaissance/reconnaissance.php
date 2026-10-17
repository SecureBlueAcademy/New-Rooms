<?php
// Filename: reconnaissance.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'reconnaissance-osint',
    'title'           => 'Reconnaissance',
    'description'     => 'Investigate a real looking company footprint and uncover what open source intelligence can reveal before a single scan is run.',
    'icon'            => 'fas fa-binoculars',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of domains and DNS'],
    'learning_objectives' => [
        'Identify what information can be gathered through passive reconnaissance',
        'Interpret WHOIS and DNS records to reveal infrastructure details',
        'Recognize how employee behavior online can leak sensitive information',
        'Correlate multiple open source intelligence sources into a single target profile',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/reconnaissance-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'The Corporate OSINT Trail'],
    ['id' => 'task3', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'reconnaissance_progress',
    'instagram_takeaways'  => [
        '✓ Passive reconnaissance uses only public information',
        '✓ Job postings and social posts can leak internal tools and versions',
        '✓ WHOIS records expose registrar and registrant details',
        '✓ DNS records can reveal subdomains never linked publicly',
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
        ['id' => 'q1', 'text' => 'What year was Nexora Dynamics founded?'],
        ['id' => 'q2', 'text' => 'What city is Nexora Dynamics headquartered in?'],
        ['id' => 'q3', 'text' => 'What version of Jenkins is mentioned on the careers page?'],
        ['id' => 'q4', 'text' => 'What hosting provider does Nexora Dynamics use, according to the social feed?'],
        ['id' => 'q5', 'text' => 'What email naming convention do Nexora Dynamics employees use?'],
        ['id' => 'q6', 'text' => 'What VPN software is mentioned in an employee post?'],
        ['id' => 'q7', 'text' => 'What domain registrar is shown in the WHOIS record?'],
        ['id' => 'q8', 'text' => 'What subdomain was discovered in the DNS records that is not linked from the main website?'],
        ['id' => 'q9', 'text' => 'Enter the flag revealed after accessing the exposed staging subdomain.'],
    ],
    'task3' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Reconnaissance is the first phase of any security assessment, whether it is performed by an attacker planning an intrusion or a professional preparing an authorized penetration test. Passive reconnaissance relies entirely on information that is already public. No packets are sent to the target, no accounts are touched, and nothing is scanned. Yet a surprising amount can be learned this way.</p>

    <p>This room is challenge based. Instead of reading through theory first, you will step directly into an investigation. You will explore a company's public website, its employees' social media activity, its domain registration data, and its DNS records to uncover an exposed internal system, learning the concepts by applying them.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Identify what information can be gathered through passive reconnaissance</li>
        <li>Interpret WHOIS and DNS records to reveal infrastructure details</li>
        <li>Recognize how employee behavior online can leak sensitive information</li>
        <li>Correlate multiple open source intelligence sources into a single target profile</li>
    </ul>
</div>
HTML;

// TASK 2: The Corporate OSINT Trail
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Challenge Briefing</h2>
    <p>You have been hired as an external security consultant to perform authorized passive reconnaissance against Nexora Dynamics, a fintech company preparing for a planned penetration test. The client wants to understand how much of their attack surface is visible to a complete outsider using nothing but public information.</p>

    <p>No scanning, login attempts, or intrusion of any kind is permitted at this stage. Your job is limited to observation. Everything you need is already sitting in plain sight, spread across a company website, a handful of employee social media posts, and standard domain records.</p>

    <p>Your task is to piece these fragments together into a single profile of the organization, and in doing so, find something the company almost certainly does not know is exposed.</p>

    <h2>Objectives</h2>
    <ol>
        <li>Review the company website for organizational and technical details</li>
        <li>Review employee social media activity for unintentional information leaks</li>
        <li>Perform a WHOIS lookup on the domain</li>
        <li>Review DNS records for infrastructure not visible on the public site</li>
        <li>Locate and access any exposed subdomains</li>
    </ol>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What to Look For</h4>
        <ul>
            <li>Details about the company's history and location are usually found on the About page</li>
            <li>Job postings often reveal internal tools and the versions they run</li>
            <li>Employees sometimes mention software or internal systems in casual posts, without realizing it</li>
            <li>WHOIS records show who registered the domain and through which registrar</li>
            <li>DNS records can list subdomains that are never linked publicly anywhere</li>
        </ul>
    </div>

    <div class="practical-launch-wrapper">
        <a href="reconnaissance-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch OSINT Investigator</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 3: Conclusion
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <p>This challenge demonstrated how much information a target organization exposes without ever being directly attacked. A company website, a careless social media post, a WHOIS record, and a forgotten DNS entry combined to reveal an internal staging environment. This is the foundation that every real reconnaissance effort builds on.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Passive reconnaissance relies entirely on publicly available information</li>
        <li>Job postings and employee posts frequently leak internal tool names and versions</li>
        <li>WHOIS records expose registrar and registrant details tied to a domain</li>
        <li>DNS records can reveal subdomains and infrastructure never linked from the public site</li>
        <li>Combining multiple small details builds a complete target profile</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA. Engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
