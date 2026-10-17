<?php
// ============================================================
// nmap-fundamentals.php — CYBRIXEN ROOM DATA FILE
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'nmap-fundamentals',
    'title'           => 'Nmap Fundamentals',
    'description'     => 'Learn the industry standard port scanner: scan types, timing templates, output formats, and the flags that tie them together.',
    'icon'            => 'fas fa-satellite-dish',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Familiarity with TCP/IP and ports'],
    'learning_objectives' => [
        'Explain the difference between SYN, TCP Connect, UDP, and stealth scans',
        'Describe how Nmap timing templates affect scan speed and detectability',
        'Identify common Nmap output formats and when to use each',
        'Apply essential Nmap flags to build a working scan command',
        'Interpret real scan results in a hands-on simulation',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/nmap-fundamentals-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Scan Types'],
    ['id' => 'task3', 'title' => 'Timing Templates'],
    ['id' => 'task4', 'title' => 'Output Formats'],
    ['id' => 'task5', 'title' => 'Common Flags and Syntax'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'nmap_fundamentals_progress',
    'instagram_takeaways'  => [
        '✓ SYN, TCP Connect, UDP, and stealth scanning explained',
        '✓ Timing templates from T0 to T5 and the speed vs stealth tradeoff',
        '✓ Nmap output formats: normal, XML, grepable, and all at once',
        '✓ The essential flags for building a real Nmap command',
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
        ['id' => 'q1', 'text' => 'What flag is used to perform a SYN scan?'],
        ['id' => 'q2', 'text' => 'What flag is used to perform a UDP scan?'],
        ['id' => 'q3', 'text' => 'Which scan type completes the full TCP three way handshake?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the default Nmap timing template?'],
        ['id' => 'q5', 'text' => 'Which timing template is the fastest?'],
        ['id' => 'q6', 'text' => 'What flag is used to set the timing template?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What flag saves scan output in XML format?'],
        ['id' => 'q8', 'text' => 'What flag saves output in all formats at once?'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What flag enables OS detection?'],
        ['id' => 'q10', 'text' => 'What flag enables service version detection?'],
        ['id' => 'q11', 'text' => 'What flag specifies which ports to scan?'],
    ],
    'task6' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the Port Scanner Console.'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Nmap is the tool security professionals reach for first when they need to understand what is actually running on a network. It sends carefully crafted packets to a target and reads the responses to determine which ports are open, which services are listening, and sometimes even which operating system is behind them. Every penetration test, every network audit, and most incident investigations start with a scan.</p>

    <p>By the end of this room, you will be able to choose the right scan type for a situation, control how loud or quiet your scan is with timing templates, save results in the format you actually need, and combine flags into a single working command. A hands on simulation lets you configure and run scans against a fictional network to see how each choice changes the result.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the difference between SYN, TCP Connect, UDP, and stealth scans.</li>
        <li>Describe how Nmap timing templates affect scan speed and detectability.</li>
        <li>Identify common Nmap output formats and when to use each.</li>
        <li>Apply essential Nmap flags to build a working scan command.</li>
        <li>Interpret real scan results in a hands on simulation.</li>
    </ul>
</div>
HTML;

// TASK 2: Scan Types
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Four Ways to Ask a Port a Question</h2>

    <p>Every Nmap scan is really just a different way of asking a port whether it is open. The scan type you choose determines how much of the conversation actually happens, and how visible that conversation is to anyone watching the network.</p>

    <p>Think of a SYN scan like knocking on a door and walking away the moment someone answers. A TCP Connect scan is knocking, walking in, shaking hands, and then leaving. A UDP scan is more like shouting through a closed door and waiting to see if anyone shouts back, since UDP has no handshake to confirm the door even opened.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why UDP Scans Take Longer</h4>
        <p>TCP has a built in handshake that quickly confirms whether a port is open. UDP does not. Nmap often has to wait for a timeout or a specific response to decide whether a UDP port is open, closed, or filtered, which makes UDP scans noticeably slower.</p>
    </div>

    <h3>Scan Types at a Glance</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Scan Type</th>
                <th>Flag</th>
                <th>How It Works</th>
                <th>Stealth Level</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>SYN Scan</strong></td>
                <td>-sS</td>
                <td>Sends a SYN packet and stops after the SYN-ACK, never completing the handshake.</td>
                <td>High</td>
            </tr>
            <tr>
                <td><strong>TCP Connect Scan</strong></td>
                <td>-sT</td>
                <td>Completes the full three way handshake, exactly like a real application would.</td>
                <td>Low</td>
            </tr>
            <tr>
                <td><strong>UDP Scan</strong></td>
                <td>-sU</td>
                <td>Sends UDP packets and interprets responses or timeouts, since no handshake exists.</td>
                <td>Low (slow)</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: SYN scan vs TCP Connect scan handshake comparison
         Teaching purpose: show the learner exactly where a SYN scan stops short of a full connection,
         which they would otherwise misunderstand as "all scans behave the same way on the wire". -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SYN scan versus TCP Connect scan handshake comparison">
            <!-- Column labels -->
            <text x="120" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Scanner</text>
            <text x="640" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Target</text>

            <!-- SYN scan row -->
            <text x="10" y="55" font-size="13" font-weight="600" fill="var(--text-primary)">SYN Scan</text>
            <line x1="120" y1="70" x2="640" y2="70" stroke="var(--border)" stroke-width="1"/>
            <line x1="120" y1="45" x2="120" y2="180" stroke="var(--border)" stroke-width="1"/>
            <line x1="640" y1="45" x2="640" y2="180" stroke="var(--border)" stroke-width="1"/>
            <line x1="120" y1="70" x2="620" y2="70" stroke="var(--primary)" stroke-width="1.5" marker-end="url(#arrHead)"/>
            <text x="380" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">SYN</text>
            <line x1="640" y1="95" x2="140" y2="95" stroke="var(--primary)" stroke-width="1.5" marker-end="url(#arrHead)"/>
            <text x="380" y="88" text-anchor="middle" font-size="11" fill="var(--text-secondary)">SYN-ACK</text>
            <text x="380" y="118" text-anchor="middle" font-size="11" font-style="italic" fill="var(--text-secondary)">Scanner drops the connection here</text>

            <!-- Connect scan row -->
            <text x="10" y="160" font-size="13" font-weight="600" fill="var(--text-primary)">TCP Connect Scan</text>
            <line x1="120" y1="180" x2="620" y2="180" stroke="var(--primary)" stroke-width="1.5" marker-end="url(#arrHead)"/>
            <text x="380" y="173" text-anchor="middle" font-size="11" fill="var(--text-secondary)">SYN</text>

            <defs>
                <marker id="arrHead" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--primary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Timing Templates
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>How Fast Should the Scan Run</h2>

    <p>Nmap lets you control how quickly it sends packets and how long it waits for a response using timing templates, numbered T0 through T5. Lower numbers introduce delays between probes, while higher numbers fire packets as fast as the network allows.</p>

    <p>This is a direct tradeoff between speed and detectability. Scanning quickly is convenient, but it produces a burst of traffic that intrusion detection systems are specifically built to notice. Scanning slowly blends in with normal background traffic but takes far longer to finish.</p>

    <p>It helps to think of it like driving. Sticking to the speed limit gets you there safely and without attracting attention. Racing through a school zone gets you there faster, but everyone notices, and something is very likely to flag it.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Aggressive Timing Has Consequences</h4>
        <p>The default timing template is T3. Using T4 or T5 on a real network can trigger IDS or IPS alerts, since the sudden spike in connection attempts is exactly the pattern these systems are designed to catch.</p>
    </div>

    <!-- SVG: T0 to T5 timing scale
         Teaching purpose: show the learner that speed and stealth move in opposite directions across the scale,
         which they would otherwise misunderstand as "a faster timing template is always the better choice". -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Nmap timing templates from T0 to T5">
            <line x1="60" y1="70" x2="700" y2="70" stroke="var(--border)" stroke-width="2"/>
            <!-- Tick marks and labels T0 to T5 -->
            <g font-size="12" fill="var(--text-primary)" text-anchor="middle">
                <circle cx="60"  cy="70" r="5" fill="var(--primary)"/><text x="60"  y="95">T0</text>
                <circle cx="188" cy="70" r="5" fill="var(--primary)"/><text x="188" y="95">T1</text>
                <circle cx="316" cy="70" r="5" fill="var(--primary)"/><text x="316" y="95">T2</text>
                <circle cx="444" cy="70" r="5" fill="var(--primary)"/><text x="444" y="95">T3</text>
                <circle cx="572" cy="70" r="5" fill="var(--primary)"/><text x="572" y="95">T4</text>
                <circle cx="700" cy="70" r="5" fill="var(--primary)"/><text x="700" y="95">T5</text>
            </g>
            <text x="60"  y="40" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Paranoid</text>
            <text x="700" y="40" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Insane</text>
            <text x="60"  y="120" text-anchor="middle" font-size="11" fill="var(--success)">Stealthy</text>
            <text x="700" y="120" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Fast</text>
            <text x="444" y="120" text-anchor="middle" font-size="11" font-style="italic" fill="var(--text-secondary)">Default</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Output Formats
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Saving Results You Can Actually Use</h2>

    <p>A scan is only useful if you can do something with the results afterward. Nmap can print output straight to the terminal, but it can also save that output in several formats depending on what you plan to do next.</p>

    <p>Choosing an output format is a lot like choosing between a printed receipt, a spreadsheet, or a searchable log file. Each one holds the same underlying information, but one of them is going to be far easier to work with depending on your next step.</p>

    <h3>Nmap Output Formats</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Flag</th>
                <th>Format Name</th>
                <th>Best Used For</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>-oN</td>
                <td>Normal</td>
                <td>Saving a human readable copy of the terminal output for notes or reports.</td>
            </tr>
            <tr>
                <td>-oX</td>
                <td>XML</td>
                <td>Feeding results into other tools or parsers in an automated workflow.</td>
            </tr>
            <tr>
                <td>-oG</td>
                <td>Grepable (legacy)</td>
                <td>Quickly searching results from the command line with tools like grep.</td>
            </tr>
            <tr>
                <td>-oA</td>
                <td>All formats</td>
                <td>Saving normal, XML, and grepable output at once with a single flag.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why XML Is So Common</h4>
        <p>The XML format is structured and predictable, which makes it the preferred choice when scan results need to be imported into another tool, such as a vulnerability scanner or a reporting dashboard.</p>
    </div>
</div>
HTML;

// TASK 5: Common Flags and Syntax
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Putting the Pieces Together</h2>

    <p>Everything covered so far comes together in a single Nmap command. Each flag adds one piece of meaning, the same way each word adds one piece of meaning to a sentence. Learning to read and build these commands is what turns theory into a usable skill.</p>

    <h3>Essential Flags</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Flag</th>
                <th>Meaning</th>
                <th>Example Use</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>-sS</td>
                <td>SYN scan</td>
                <td>nmap -sS 10.10.14.22</td>
            </tr>
            <tr>
                <td>-sT</td>
                <td>TCP Connect scan</td>
                <td>nmap -sT 10.10.14.22</td>
            </tr>
            <tr>
                <td>-sU</td>
                <td>UDP scan</td>
                <td>nmap -sU 10.10.14.35</td>
            </tr>
            <tr>
                <td>-p</td>
                <td>Specify ports to scan</td>
                <td>nmap -p 1-1000 10.10.14.22</td>
            </tr>
            <tr>
                <td>-sV</td>
                <td>Detect service versions</td>
                <td>nmap -sV 10.10.14.22</td>
            </tr>
            <tr>
                <td>-O</td>
                <td>Detect the operating system</td>
                <td>nmap -O 10.10.14.22</td>
            </tr>
            <tr>
                <td>-T&lt;0-5&gt;</td>
                <td>Set the timing template</td>
                <td>nmap -T4 10.10.14.22</td>
            </tr>
            <tr>
                <td>-oN</td>
                <td>Save normal output to a file</td>
                <td>nmap -oN scan.txt 10.10.14.22</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Reading a Full Command</h4>
        <p><code>nmap -sS -sV -O -T4 -p 1-1000 -oN scan.txt 10.10.14.22</code> runs a SYN scan with service and OS detection, uses the aggressive timing template, checks ports 1 through 1000, and saves the results to scan.txt. Each flag is independent, and the order rarely matters.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been handed console access to a scanning workstation on the ACME corporate network. Three hosts sit within reach: a domain controller, a web server, and a database server. Your job is to configure and run scans against each of them, using what you just learned about scan types, timing, and output formats.</p>

    <p>Select a target, choose your scan type and timing template, and run the scan to see how your choices shape the result. Complete every milestone in the progress tracker to unlock the full scan report and its flag.</p>

    <div class="practical-launch-wrapper">
        <a href="nmap-fundamentals-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Port Scanner Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how Nmap actually works under the hood. Scan types determine how much of a connection is completed, timing templates control the tradeoff between speed and detection, output formats determine how results move into the next stage of your workflow, and flags tie all of it together into a single working command.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>SYN scans are fast and stealthy because they never complete the handshake.</li>
        <li>TCP Connect scans complete the full handshake and are more likely to be logged.</li>
        <li>UDP scans take longer because UDP has no handshake to confirm state.</li>
        <li>Timing templates from T0 to T5 trade stealth for speed, with T3 as the default.</li>
        <li>Output formats like -oN, -oX, -oG, and -oA determine how scan results are saved and reused.</li>
        <li>A real Nmap command is simply a combination of scan type, timing, ports, and output flags.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
