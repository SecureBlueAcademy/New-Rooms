<?php
// introduction-to-scanning.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'introduction-to-scanning',
    'title'           => 'Introduction to Scanning',
    'description'     => 'Learn the difference between network, port, and vulnerability scanning, and the TCP mechanics scanners rely on.',
    'icon'            => 'fas fa-satellite-dish',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic TCP/IP knowledge'],
    'learning_objectives' => [
        'Distinguish between network scanning, port scanning, and vulnerability scanning',
        'Describe the three steps of the TCP three way handshake',
        'Explain the purpose of the SYN, ACK, RST, and FIN flags',
        'Explain how SYN scanning uses incomplete connections to detect open ports',
        'Compare a SYN scan and a full connect scan using a live console',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/introduction-to-scanning-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Types of Scanning'],
    ['id' => 'task3', 'title' => 'The TCP Three Way Handshake'],
    ['id' => 'task4', 'title' => 'TCP Flags'],
    ['id' => 'task5', 'title' => 'How Scanners Exploit Incomplete Connections'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'introduction_to_scanning_progress',
    'instagram_takeaways'  => [
        '✓ Network, port, and vulnerability scanning each answer a narrower question',
        '✓ The TCP handshake needs SYN, SYN-ACK, and ACK to fully connect',
        '✓ TCP flags signal connection state inside the packet header',
        '✓ SYN scanning never finishes the handshake, making it fast and quiet',
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
        ['id' => 'q1', 'text' => 'What type of scanning discovers live hosts on a network?'],
        ['id' => 'q2', 'text' => 'What type of scanning identifies open ports on a specific host?'],
        ['id' => 'q3', 'text' => 'What type of scanning checks services for known security weaknesses?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the name of the first packet sent to initiate a TCP connection?'],
        ['id' => 'q5', 'text' => 'How many packets are exchanged to complete the TCP three way handshake?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What TCP flag is used to abruptly reset a connection?'],
        ['id' => 'q7', 'text' => 'What TCP flag indicates that no more data will be sent?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What is the name for a scan that never completes the TCP handshake?'],
        ['id' => 'q9', 'text' => 'What term describes a connection left incomplete after the SYN-ACK is received?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Enter the flag you discovered in the Live Scan Console.'],
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
    <p>Scanning is the reconnaissance phase of almost every security assessment. Before anyone can defend or attack a system, they first need to know what exists, what is reachable, and what might be vulnerable.</p>

    <p>By the end of this room, you will be able to distinguish scanning types, understand the TCP three way handshake, and explain how scanners use incomplete connections to detect open ports. Hands on practice with a live scan console is included.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Distinguish between network scanning, port scanning, and vulnerability scanning</li>
        <li>Describe the three steps of the TCP three way handshake</li>
        <li>Explain the purpose of the SYN, ACK, RST, and FIN flags</li>
        <li>Explain how SYN scanning uses incomplete connections to detect open ports</li>
        <li>Compare a SYN scan and a full connect scan using a live console</li>
    </ul>
</div>
HTML;

// TASK 2: Types of Scanning
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Three Questions, Three Scan Types</h2>

    <p>Not every scan asks the same question. A <strong>network scan</strong> asks which hosts are alive on a network. A <strong>port scan</strong> asks which ports on one of those hosts are open. A <strong>vulnerability scan</strong> asks whether the services running on those ports have known weaknesses.</p>

    <p>Think of it like checking a street of houses. A network scan is knocking on every door to see who answers. A port scan is checking which doors and windows on one house are unlocked. A vulnerability scan is checking whether those locks are a known faulty model that can be picked easily.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Scanning without authorization is illegal in most jurisdictions. Always operate within a signed scope of engagement before running any of these scans against a real target.</p>
    </div>

    <h3>Comparing the Three Scan Types</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Scan Type</th>
                <th>Question It Answers</th>
                <th>What It Finds</th>
                <th>Example Tool</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Network scanning</strong></td>
                <td>Which hosts are alive?</td>
                <td>A list of active IP addresses on a network segment.</td>
                <td>Nmap host discovery</td>
            </tr>
            <tr>
                <td><strong>Port scanning</strong></td>
                <td>Which ports are open?</td>
                <td>Open, closed, and filtered ports on a specific host.</td>
                <td>Nmap port scan</td>
            </tr>
            <tr>
                <td><strong>Vulnerability scanning</strong></td>
                <td>Are any services weak?</td>
                <td>Known misconfigurations or unpatched software.</td>
                <td>Nessus, OpenVAS</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: scanning funnel diagram
         Teaching purpose: show the learner that scanning narrows in stages from an entire network
         down to individual weaknesses, which they would otherwise misunderstand as three unrelated techniques. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Scanning funnel from network to vulnerability">
            <!-- Stage boxes, narrowing left to right -->
            <rect x="10"  y="30" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="280" y="35" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="550" y="40" width="200" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="212" y1="70" x2="276" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrfunnel)"/>
            <line x1="482" y1="70" x2="546" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrfunnel)"/>
            <defs>
                <marker id="arrfunnel" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="110" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Network Scan</text>
            <text x="110" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Which hosts are alive?</text>
            <text x="380" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Port Scan</text>
            <text x="380" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Which ports are open?</text>
            <text x="650" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Vulnerability Scan</text>
            <text x="650" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Are any services weak?</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Each scan type narrows the focus of the last one. You rarely run a vulnerability scan before you know a port is even open.</p>
    </div>
</div>
HTML;

// TASK 3: The TCP Three Way Handshake
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Establishing a Connection</h2>

    <p>Before two computers can exchange any real data over TCP, they must agree to talk. This agreement happens through a three step exchange called the <strong>three way handshake</strong>.</p>

    <p>It works like a phone call. The caller says "can you hear me?" The receiver replies "yes, can you hear me?" The caller confirms "yes, let's talk." Only after all three lines have been spoken does the actual conversation begin.</p>

    <!-- SVG: TCP handshake sequence diagram
         Teaching purpose: show the learner the exact order and direction of the three handshake steps,
         which they would otherwise misunderstand as instantaneous or a single step. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 640 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="TCP three way handshake sequence">
            <!-- Actor boxes -->
            <rect x="40"  y="10" width="140" height="40" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="35" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Client</text>
            <rect x="460" y="10" width="140" height="40" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="530" y="35" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Server</text>
            <!-- Lifelines -->
            <line x1="110" y1="50" x2="110" y2="200" stroke="var(--border)" stroke-width="1"/>
            <line x1="530" y1="50" x2="530" y2="200" stroke="var(--border)" stroke-width="1"/>
            <!-- Step 1: SYN -->
            <line x1="110" y1="80" x2="530" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrhs)"/>
            <text x="320" y="72" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">1. SYN</text>
            <!-- Step 2: SYN-ACK -->
            <line x1="530" y1="120" x2="110" y2="120" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrhs)"/>
            <text x="320" y="112" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">2. SYN-ACK</text>
            <!-- Step 3: ACK -->
            <line x1="110" y1="160" x2="530" y2="160" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrhs)"/>
            <text x="320" y="152" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">3. ACK</text>
            <text x="320" y="190" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Connection established</text>
            <defs>
                <marker id="arrhs" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>No application data moves until all three steps complete. A scanner can exploit this by never sending that final step, which you will see in a later task.</p>
    </div>
</div>
HTML;

// TASK 4: TCP Flags
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Signals Inside the Packet</h2>

    <p>A TCP flag is a single bit inside the TCP header. It is not a separate packet type. Flags tell the receiving computer what state the connection is in or what should happen to it next.</p>

    <p>Multiple flags can be set in the same packet. A SYN-ACK packet, for example, carries both the SYN bit and the ACK bit at once.</p>

    <h3>The Core Flags</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Flag</th>
                <th>Full Name</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>SYN</strong></td>
                <td>Synchronize</td>
                <td>Requests a new connection and synchronizes sequence numbers.</td>
            </tr>
            <tr>
                <td><strong>ACK</strong></td>
                <td>Acknowledgment</td>
                <td>Confirms that data or a connection request was received.</td>
            </tr>
            <tr>
                <td><strong>RST</strong></td>
                <td>Reset</td>
                <td>Abruptly terminates a connection, often because a port is closed.</td>
            </tr>
            <tr>
                <td><strong>FIN</strong></td>
                <td>Finish</td>
                <td>Signals that the sender has no more data and wants to close gracefully.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Scanners read these flags to decide whether a port is open, closed, or filtered, without ever needing to see any application data.</p>
    </div>
</div>
HTML;

// TASK 5: How Scanners Exploit Incomplete Connections
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Stopping Short on Purpose</h2>

    <p>A full connect scan completes the entire three way handshake, just like a normal application would. A <strong>SYN scan</strong> does something different. It sends the SYN, waits for a SYN-ACK or RST, and then deliberately never sends the final ACK.</p>

    <p>This leaves the connection half open. Because the handshake never finishes, many services never log the attempt at all, which makes SYN scanning both faster and quieter than a full connect scan.</p>

    <!-- SVG: SYN scan vs connect scan side by side
         Teaching purpose: show the learner exactly where the SYN scan interrupts the handshake compared
         to a connect scan, which they would otherwise misunderstand as identical to a full scan. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SYN scan compared to connect scan">
            <!-- SYN scan column -->
            <text x="150" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">SYN Scan</text>
            <line x1="50"  y1="35" x2="50"  y2="180" stroke="var(--border)" stroke-width="1"/>
            <line x1="250" y1="35" x2="250" y2="180" stroke="var(--border)" stroke-width="1"/>
            <line x1="50" y1="60" x2="250" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrsc1)"/>
            <text x="150" y="52" text-anchor="middle" font-size="11" fill="var(--text-primary)">SYN</text>
            <line x1="250" y1="95" x2="50" y2="95" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrsc1)"/>
            <text x="150" y="87" text-anchor="middle" font-size="11" fill="var(--text-primary)">SYN-ACK</text>
            <line x1="50" y1="130" x2="250" y2="130" stroke="var(--error, #ff5c5c)" stroke-width="1.5" marker-end="url(#arrsc2)"/>
            <text x="150" y="122" text-anchor="middle" font-size="11" fill="var(--text-primary)">RST</text>
            <text x="150" y="160" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Handshake abandoned</text>

            <!-- Connect scan column -->
            <text x="600" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Connect Scan</text>
            <line x1="500" y1="35" x2="500" y2="180" stroke="var(--border)" stroke-width="1"/>
            <line x1="700" y1="35" x2="700" y2="180" stroke="var(--border)" stroke-width="1"/>
            <line x1="500" y1="60" x2="700" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrsc1)"/>
            <text x="600" y="52" text-anchor="middle" font-size="11" fill="var(--text-primary)">SYN</text>
            <line x1="700" y1="95" x2="500" y2="95" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrsc1)"/>
            <text x="600" y="87" text-anchor="middle" font-size="11" fill="var(--text-primary)">SYN-ACK</text>
            <line x1="500" y1="130" x2="700" y2="130" stroke="var(--success, #3dff9a)" stroke-width="1.5" marker-end="url(#arrsc1)"/>
            <text x="600" y="122" text-anchor="middle" font-size="11" fill="var(--text-primary)">ACK</text>
            <text x="600" y="160" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Handshake completed</text>

            <defs>
                <marker id="arrsc1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arrsc2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--error, #ff5c5c)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <h3>SYN Scan vs Connect Scan</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Property</th>
                <th>SYN Scan</th>
                <th>Connect Scan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Stealth</td>
                <td>Higher, often unlogged</td>
                <td>Lower, usually logged</td>
            </tr>
            <tr>
                <td>Speed</td>
                <td>Faster</td>
                <td>Slower</td>
            </tr>
            <tr>
                <td>Logging footprint</td>
                <td>Minimal</td>
                <td>Full connection recorded</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Note</h4>
        <p>Real SYN scanning requires raw socket access. This is why tools like Nmap need elevated privileges to run this scan type.</p>
    </div>
</div>
HTML;

// TASK 6: Practical (Live Scan Console)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have console access to a target host, scanme.cybrixen.lab, and need to determine which of its two supported scan types actually completes the TCP handshake. Run both scan types, compare the results, and answer the console's final question to reveal the flag.</p>

    <p>Use the commands shown in the console to run a SYN scan and a Connect scan against the target, then review the packet exchange for each port.</p>

    <div class="practical-launch-wrapper">
        <a href="introduction-to-scanning-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Live Scan Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how scanning narrows from an entire network down to individual vulnerabilities, and how the TCP three way handshake underlies every one of those scans. Knowing how SYN scanning interrupts that handshake explains why it remains the industry standard for stealthy reconnaissance.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Network, port, and vulnerability scanning each answer a narrower question</li>
        <li>The TCP handshake requires SYN, SYN-ACK, and ACK to fully establish a connection</li>
        <li>TCP flags signal connection state within the packet header</li>
        <li>SYN scanning never completes the handshake, making it faster and quieter than a connect scan</li>
        <li>Understanding the handshake explains why some scans are logged and others are not</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
