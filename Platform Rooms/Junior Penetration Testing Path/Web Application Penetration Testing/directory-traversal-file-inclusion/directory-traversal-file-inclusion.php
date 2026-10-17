<?php
// Filename: directory-traversal-file-inclusion.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'directory-traversal-file-inclusion',
    'title'           => 'Directory Traversal & File Inclusion',
    'description'     => 'Learn how path traversal attacks allow reading files outside the web root and how LFI and RFI can lead to code execution.',
    'icon'            => 'fas fa-folder-open',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic understanding of URLs and web requests', 'Basic knowledge of file systems'],
    'learning_objectives' => [
        'Explain how path traversal allows access to files outside the web root',
        'Distinguish local file inclusion from remote file inclusion',
        'Describe how log poisoning can escalate LFI into code execution',
        'Apply these concepts by bypassing a filtered file parameter in the practical',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/directory-traversal-file-inclusion-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Path Traversal Fundamentals'],
    ['id' => 'task3', 'title' => 'Local File Inclusion (LFI)'],
    ['id' => 'task4', 'title' => 'Remote File Inclusion (RFI)'],
    ['id' => 'task5', 'title' => 'From LFI to Code Execution'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'directory_traversal_file_inclusion_progress',
    'instagram_takeaways'  => [
        '✓ Path traversal and how ../ sequences escape the web root',
        '✓ Local file inclusion vs remote file inclusion',
        '✓ How log poisoning turns LFI into code execution',
        '✓ Bypassing a naive traversal filter in a live lab',
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
        ['id' => 'q1', 'text' => 'What is the term for exploiting relative path sequences to access files outside a web application\'s intended directory?'],
        ['id' => 'q2', 'text' => 'What is the common name for the sequence used to move up one directory level in a traversal attack?'],
        ['id' => 'q3', 'text' => 'What is the term for the boundary a web application is intended to keep file access within?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What does LFI stand for?'],
        ['id' => 'q5', 'text' => 'Which PHP function is most commonly exploited to achieve local file inclusion?'],
        ['id' => 'q6', 'text' => 'What type of file is often targeted through LFI to steal sensitive credentials?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What does RFI stand for?'],
        ['id' => 'q8', 'text' => 'What protocol is typically used to fetch the remote file in an RFI attack?'],
    ],
    'task5' => [
        ['id' => 'q9', 'text' => 'What is the technique called that plants malicious code inside a log file so it executes when the file is later included?'],
        ['id' => 'q10', 'text' => 'Which HTTP request header is most commonly abused to inject code in a log poisoning attack?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Document Viewer lab.'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every web application decides which files it is allowed to serve. When that decision relies on user supplied input without proper validation, an attacker can step outside the intended folder and read files never meant to be public. This flaw, known as path traversal, has existed since the earliest web servers and still appears in modern applications today.</p>

    <p>By the end of this room you will understand how traversal sequences work, how local and remote file inclusion escalate that access into something far more dangerous, and how a single log file can become a foothold for code execution. A hands-on lab lets you exploit these weaknesses yourself in a simulated document portal.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain how path traversal allows access to files outside the web root.</li>
        <li>Distinguish local file inclusion from remote file inclusion.</li>
        <li>Describe how log poisoning can escalate LFI into code execution.</li>
        <li>Apply these concepts by bypassing a filtered file parameter in the practical.</li>
    </ul>
</div>
HTML;

// TASK 2: Path Traversal Fundamentals
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Climbing Out of the Web Root</h2>

    <p>A web application is normally meant to serve files from one specific folder, often called the web root. Inside that folder, everything is fair game. Outside of it, nothing should be reachable through the application at all.</p>

    <p>The problem starts when a file name or path comes from user input and gets used directly to locate a file on disk. If nothing checks where that path actually points, an attacker can supply a value that walks upward through the folder structure using a relative path sequence.</p>

    <p>Think of the web root as the lobby of a building. Visitors are meant to stay in the lobby and the rooms branching off it. Path traversal is the equivalent of finding an unlocked stairwell and walking up to floors that were never meant to be accessible to the public.</p>

    <!-- SVG: directory tree showing a path escaping the web root
         Teaching purpose: show the learner that ../ is genuine hierarchical
         navigation through real folders, which they would otherwise misunderstand
         as arbitrary or meaningless syntax. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 300" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Directory traversal escaping the web root">
            <!-- Server filesystem outer boundary -->
            <rect x="20" y="20" width="660" height="260" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="40" y="45" font-size="12" fill="var(--text-secondary)">Server File System</text>

            <!-- Web root boundary (dashed) -->
            <rect x="60" y="70" width="260" height="150" rx="8" fill="none" stroke="var(--primary)" stroke-width="1.5" stroke-dasharray="6,4"/>
            <text x="75" y="90" font-size="12" font-weight="600" fill="var(--primary)">Intended Web Root</text>

            <!-- public_docs folder inside web root -->
            <rect x="90" y="150" width="180" height="50" rx="6" fill="var(--bg-primary, #12182b)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="180" y="180" text-anchor="middle" font-size="13" fill="var(--text-primary)">public_docs/</text>

            <!-- restricted folder outside the boundary -->
            <rect x="450" y="150" width="180" height="50" rx="6" fill="var(--bg-primary, #12182b)" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="540" y="180" text-anchor="middle" font-size="13" fill="var(--text-primary)">restricted/</text>

            <!-- Arrow crossing the boundary -->
            <line x1="270" y1="175" x2="445" y2="175" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="357" y="160" text-anchor="middle" font-size="12" fill="var(--text-secondary)">../../</text>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> A Filter Is Not a Fix</h4>
        <p>Simply removing the literal sequence "../" once from user input is not enough. Later in this room you will see exactly why that kind of filtering can be bypassed.</p>
    </div>
</div>
HTML;

// TASK 3: Local File Inclusion (LFI)
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>When Reading Becomes Executing</h2>

    <p>Path traversal lets an attacker read a file. Local file inclusion, or LFI, goes a step further. Instead of simply displaying the contents of a file, the server actually treats that file as code and runs it.</p>

    <p>This usually happens when server side code uses a function like <code>include()</code> or <code>require()</code> with a path that comes from user input. If the included file contains executable code, the server will run it exactly as if it were part of the original application.</p>

    <p>Traversal is peeking at a recipe card left on a shelf. LFI is the kitchen actually cooking whatever is written on that card, no matter who left it there.</p>

    <!-- SVG: contrast raw file read vs executed file
         Teaching purpose: show the learner the difference between a server
         returning file content and a server executing that content, which
         they would otherwise misunderstand as the same outcome. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Traversal reads a file, LFI executes it">
            <rect x="20" y="20" width="300" height="160" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="170" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Traversal</text>
            <text x="170" y="100" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Server returns</text>
            <text x="170" y="118" text-anchor="middle" font-size="12" fill="var(--text-secondary)">raw file content</text>

            <rect x="380" y="20" width="300" height="160" rx="10" fill="var(--surface)" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="530" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">LFI</text>
            <text x="530" y="100" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Server executes</text>
            <text x="530" y="118" text-anchor="middle" font-size="12" fill="var(--text-secondary)">the file as code</text>
        </svg>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Vulnerability</th>
                <th>What Happens</th>
                <th>Typical Impact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Path Traversal</td>
                <td>Server returns the raw contents of a file outside the web root.</td>
                <td>Information disclosure.</td>
            </tr>
            <tr>
                <td>LFI</td>
                <td>Server includes and executes a local file as code.</td>
                <td>Credential theft or code execution.</td>
            </tr>
            <tr>
                <td>RFI</td>
                <td>Server fetches and executes a file hosted on a remote server.</td>
                <td>Full remote code execution.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Commonly Vulnerable Functions</h4>
        <p>In PHP, LFI usually traces back to functions such as <code>include()</code>, <code>include_once()</code>, <code>require()</code>, <code>require_once()</code>, or <code>file_get_contents()</code> being called with unvalidated user input.</p>
    </div>
</div>
HTML;

// TASK 4: Remote File Inclusion (RFI)
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Bringing In Code From Outside</h2>

    <p>Remote file inclusion, or RFI, extends the same idea as LFI but the included file does not even need to exist on the server. Instead, the vulnerable code fetches a file from a URL supplied by the attacker and executes it as if it were local.</p>

    <p>If LFI is the kitchen cooking a recipe already sitting on its own shelf, RFI is that same kitchen accepting a recipe mailed in by a complete stranger and cooking it without question.</p>

    <p>RFI generally requires the server to be configured to allow fetching remote URLs through inclusion functions, which is disabled by default on most modern PHP installations. This makes RFI far less common today than it once was, though it still appears on misconfigured systems.</p>

    <!-- SVG: request flow of fetching and executing a remote file
         Teaching purpose: show the learner that the malicious file lives on an
         attacker controlled server and travels over the network before execution,
         which they would otherwise confuse with LFI's purely local file access. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="RFI request flow">
            <rect x="20" y="40" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="85" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Vulnerable Server</text>

            <rect x="580" y="40" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="670" y="85" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attacker Server</text>

            <line x1="200" y1="65" x2="575" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <text x="387" y="55" text-anchor="middle" font-size="11" fill="var(--text-secondary)">1. Request remote file over HTTP</text>

            <line x1="575" y1="100" x2="200" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <text x="387" y="120" text-anchor="middle" font-size="11" fill="var(--text-secondary)">2. Malicious script returned and executed</text>

            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> A Configuration Dependent Attack</h4>
        <p>RFI only works when the server allows inclusion functions to fetch remote URLs. Most current PHP defaults disable this, which is why LFI and log poisoning remain the more common escalation path today.</p>
    </div>
</div>
HTML;

// TASK 5: From LFI to Code Execution
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Turning a Log File Into a Weapon</h2>

    <p>When RFI is not available, attackers often achieve code execution through LFI alone using a technique called log poisoning. Web servers routinely log details of every request, including the User-Agent header sent by the visitor's browser.</p>

    <p>If an attacker sends a request with PHP code placed inside the User-Agent header, that code gets written straight into the log file as plain text. On its own this is harmless, since the log file is just data. The danger appears the moment the vulnerable application includes that same log file through an LFI flaw.</p>

    <p>This is like planting a fake instruction inside a shared logbook that staff later read aloud without checking who wrote it. The moment they read the poisoned line, they carry out whatever instruction it contains.</p>

    <!-- SVG: sequence of log poisoning leading to execution
         Teaching purpose: show the learner that log poisoning is a two step
         chain of inject then include, which they would otherwise assume
         achieves code execution in a single action. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Log poisoning sequence">
            <rect x="10" y="30" width="220" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="120" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">1. Inject Code</text>
            <text x="120" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">via User-Agent header</text>

            <rect x="270" y="30" width="220" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">2. Include Log</text>
            <text x="380" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">via the LFI flaw</text>

            <rect x="530" y="30" width="220" height="90" rx="10" fill="var(--surface)" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="640" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">3. Code Executes</text>
            <text x="640" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">on the server</text>

            <line x1="230" y1="75" x2="265" y2="75" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="490" y1="75" x2="525" y2="75" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> The Chain in Short</h4>
        <p>Send a request with code hidden in the User-Agent header, then use the existing LFI flaw to include the log file that recorded it. The server reads the log as code and runs it.</p>
    </div>
</div>
HTML;

// TASK 6: Practical (Document Viewer)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been given access to a simulated Corporate Document Portal. The portal is only supposed to serve files from its public documents folder, but the file parameter in the address bar accepts any value you give it.</p>

    <p>Somewhere outside that public folder sits an old admin notes file. Your task is to work out how the portal filters your input, find a way around that filter, and read the restricted file to retrieve the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="directory-traversal-file-inclusion-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Document Viewer</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have now seen how a single unvalidated file parameter can grow from a minor information leak into full code execution. Path traversal exposes files outside the web root, LFI turns those files into executable code, RFI brings in code from an external server, and log poisoning shows how attackers can achieve the same result even when RFI is not available.</p>

    <p>The common thread across all of these is trust placed in user supplied input without proper validation. Strong input handling and strict allow lists for file access remain the most effective defense against every technique covered in this room.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Path traversal uses relative path sequences to escape the intended web root.</li>
        <li>A filter that removes a sequence only once can often be bypassed by doubling it.</li>
        <li>LFI executes a local file as code instead of simply displaying its contents.</li>
        <li>RFI fetches and executes a file from an attacker controlled server.</li>
        <li>Log poisoning combines an injected header with an LFI flaw to achieve code execution.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
