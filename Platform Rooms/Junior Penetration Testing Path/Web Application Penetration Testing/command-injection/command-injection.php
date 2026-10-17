<?php
// FILENAME: command-injection.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'command-injection',
    'title'           => 'Command Injection',
    'description'     => 'Learn how applications that pass user input directly to OS commands can be exploited, and practice exploiting one yourself.',
    'icon'            => 'fas fa-terminal',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic command line familiarity', 'Basic web application concepts'],
    'learning_objectives' => [
        'Explain how command injection vulnerabilities occur',
        'Identify PHP functions and code patterns that enable OS command execution',
        'Recognize shell operators used to chain malicious commands',
        'Apply a systematic method to test for and exploit an injection point',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/command-injection-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Command Injection?'],
    ['id' => 'task3', 'title' => 'How User Input Reaches OS Commands'],
    ['id' => 'task4', 'title' => 'Injection Operators and Command Chaining'],
    ['id' => 'task5', 'title' => 'Identifying and Testing Injection Points'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'command_injection_progress',
    'instagram_takeaways'  => [
        '✓ Command injection lets attackers run OS commands through vulnerable input',
        '✓ PHP functions like system() and shell_exec() are common execution points',
        '✓ Shell operators like ; && and | chain extra commands together',
        '✓ Systematic testing finds injection points before attackers do',
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
        ['id' => 'q1', 'text' => 'What is the general term for a vulnerability that lets an attacker execute arbitrary OS commands through an application?'],
        ['id' => 'q2', 'text' => 'What must user input undergo before being used in a system command, to prevent injection?'],
        ['id' => 'q3', 'text' => 'What is the general OWASP vulnerability category that includes both command injection and SQL injection?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'Which PHP function executes a shell command and outputs its result directly?'],
        ['id' => 'q5', 'text' => 'What programming practice of joining strings together is commonly used to build a vulnerable command from user input?'],
        ['id' => 'q6', 'text' => 'What type of validation, if relied on alone, fails to protect against command injection?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'Which shell operator executes a second command regardless of whether the first command succeeded?'],
        ['id' => 'q8', 'text' => 'Which shell operator executes a second command only if the first command succeeded?'],
        ['id' => 'q9', 'text' => 'Which shell operator sends the output of one command as input to another?'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'What is the term for a specially crafted input used to test or exploit a vulnerability?'],
        ['id' => 'q11', 'text' => 'What is the term for a location in an application where user input reaches a vulnerable operation?'],
    ],
    'task6' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the Network Diagnostics Tool.'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Command injection turns an ordinary input field into a direct line to a server's operating system. When an application passes user supplied data straight into a shell command, an attacker can piggyback on that trust and run their own instructions alongside it, often with the same level of access as the application itself.</p>

    <p>By the end of this room you will be able to recognize the code patterns that create command injection vulnerabilities, understand the operators attackers use to chain commands, and systematically test an input for this flaw. A hands on lab lets you exploit a simulated diagnostic tool to put this into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what command injection is and why it occurs.</li>
        <li>Identify PHP functions that execute OS commands.</li>
        <li>Recognize shell operators used to chain commands.</li>
        <li>Apply a systematic method to test for injection points.</li>
        <li>Exploit a simulated vulnerable tool to retrieve a hidden flag.</li>
    </ul>
</div>
HTML;

$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>When Input Becomes Instructions</h2>

    <p>Command injection is a vulnerability that lets an attacker execute arbitrary operating system commands through a vulnerable application. It happens when user supplied input is passed to a system shell without being checked or cleaned first.</p>

    <p>Think of a mail room clerk who processes every package exactly as instructed by the label attached to it. If a label says "deliver to accounting" the clerk complies without question. If someone tapes an extra instruction onto that same label, such as "then shred every file in the archive room", a clerk who blindly follows every instruction on the label will do that too. A vulnerable application behaves the same way with user input.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Command injection consistently ranks among the most severe web application vulnerabilities because a successful exploit can lead to full control of the underlying server, not just the application itself.</p>
    </div>

    <h3>Command Injection in Context</h3>
    <p>Command injection belongs to a broader family of flaws known as <strong>injection</strong> vulnerabilities. SQL injection targets a database, command injection targets the operating system shell, but both share the same root cause: untrusted input being treated as trusted instructions.</p>

    <!-- SVG: trust boundary diagram
         Teaching purpose: show the learner that the vulnerability appears specifically
         at the boundary where user input crosses into shell execution, which they would
         otherwise misunderstand as a general hacking concept unrelated to a specific code path. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 170" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Boundary where user input crosses into shell execution">
            <!-- User input box -->
            <rect x="20" y="60" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="85" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">User Input</text>
            <text x="100" y="103" text-anchor="middle" font-size="11" fill="var(--text-secondary)">e.g. hostname field</text>

            <!-- Arrow into app logic -->
            <line x1="180" y1="90" x2="255" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowA)"/>

            <!-- App logic box -->
            <rect x="260" y="60" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="340" y="85" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Application Logic</text>
            <text x="340" y="103" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Builds a command string</text>

            <!-- Trust boundary marker -->
            <line x1="440" y1="30" x2="440" y2="150" stroke="var(--warning)" stroke-width="2" stroke-dasharray="6,4"/>
            <text x="440" y="20" text-anchor="middle" font-size="11" fill="var(--warning)">Trust Boundary</text>

            <!-- Arrow into shell -->
            <line x1="440" y1="90" x2="515" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowA)"/>

            <!-- Shell box -->
            <rect x="520" y="60" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="85" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">OS Shell</text>
            <text x="600" y="103" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Executes the command</text>

            <defs>
                <marker id="arrowA" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>From a Text Box to a Shell Command</h2>

    <p>PHP applications rely on a handful of functions to run commands on the underlying operating system. Each one hands a string of text straight to the shell, and the shell has no way of knowing which part of that string came from your code and which part came from a user.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>PHP Function</th>
                <th>What It Does</th>
                <th>Common Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>system()</strong></td>
                <td>Executes a command and outputs the result directly.</td>
                <td>Running a quick system check with immediate output.</td>
            </tr>
            <tr>
                <td><strong>shell_exec()</strong></td>
                <td>Executes a command and returns the entire output as a string.</td>
                <td>Capturing command output for further processing.</td>
            </tr>
            <tr>
                <td><strong>exec()</strong></td>
                <td>Executes a command and returns the last line, with full output available in an array.</td>
                <td>Running a command when only the last line matters.</td>
            </tr>
            <tr>
                <td><strong>passthru()</strong></td>
                <td>Executes a command and streams raw output directly to the browser.</td>
                <td>Running commands that produce binary output.</td>
            </tr>
        </tbody>
    </table>

    <p>A vulnerable diagnostic tool might build its command like this, joining a fixed instruction with whatever the user typed:</p>

    <pre><code>$host = $_GET['host'];
$output = shell_exec("ping -c 4 " . $host);</code></pre>

    <p>This joining of strings is called <strong>concatenation</strong>. If the user types a plain hostname, the command runs as expected. If the user types a hostname followed by a chaining operator and another command, the shell happily runs both.</p>

    <!-- SVG: code flow diagram
         Teaching purpose: show the learner exactly where concatenation of untrusted
         input into a command string happens, which they would otherwise misunderstand
         as an abstract network level flaw rather than a specific line of vulnerable code. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Code flow from input to shell execution">
            <rect x="10" y="55" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="85" text-anchor="middle" font-size="12" font-family="monospace" fill="var(--text-primary)">$_GET['host']</text>

            <line x1="160" y1="80" x2="215" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowB)"/>

            <rect x="220" y="55" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="310" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">String Concatenation</text>

            <line x1="400" y1="80" x2="455" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowB)"/>

            <rect x="460" y="55" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="530" y="85" text-anchor="middle" font-size="12" font-family="monospace" fill="var(--text-primary)">shell_exec()</text>

            <line x1="600" y1="80" x2="650" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowB)"/>

            <text x="670" y="85" text-anchor="middle" font-size="12" font-weight="600" fill="var(--warning)">OS</text>

            <defs>
                <marker id="arrowB" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> A Common Mistake</h4>
        <p>Checking input in the browser with JavaScript does nothing to stop this. Client-side validation can always be bypassed, so the shell only ever sees whatever the attacker actually sends to the server.</p>
    </div>
</div>
HTML;

$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Turning One Command into Two</h2>

    <p>Shells support special characters called operators that let a user string multiple commands together on a single line. An application that forwards raw input to a shell inherits all of this behavior, whether it wants to or not.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Operator</th>
                <th>Shell</th>
                <th>Behavior</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>;</code></td>
                <td>Linux/Unix</td>
                <td>Runs the second command regardless of whether the first command succeeded.</td>
            </tr>
            <tr>
                <td><code>&amp;&amp;</code></td>
                <td>Linux/Unix</td>
                <td>Runs the second command only if the first command succeeded.</td>
            </tr>
            <tr>
                <td><code>||</code></td>
                <td>Linux/Unix</td>
                <td>Runs the second command only if the first command failed.</td>
            </tr>
            <tr>
                <td><code>|</code></td>
                <td>Linux/Unix</td>
                <td>Sends the output of the first command as input to the second.</td>
            </tr>
            <tr>
                <td><code>&amp;</code></td>
                <td>Windows</td>
                <td>Runs the second command after the first, similar to the semicolon on Linux.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: chained commands diagram
         Teaching purpose: show the learner visually how a chaining operator creates two
         independent commands, which they would otherwise misunderstand as one atomic
         operation typed into a single field. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Two commands joined by a chaining operator">
            <rect x="20" y="45" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="75" text-anchor="middle" font-size="12" font-family="monospace" fill="var(--text-primary)">ping 8.8.8.8</text>

            <text x="260" y="75" text-anchor="middle" font-size="18" font-weight="700" fill="var(--warning)">&amp;&amp;</text>

            <rect x="310" y="45" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="400" y="75" text-anchor="middle" font-size="12" font-family="monospace" fill="var(--text-primary)">whoami</text>

            <line x1="200" y1="70" x2="245" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowC)"/>
            <line x1="280" y1="70" x2="305" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowC)"/>

            <text x="255" y="120" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Two independent commands, not one</text>

            <defs>
                <marker id="arrowC" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Attacker Tip</h4>
        <p>Attackers often favor the pipe operator when they want to filter or redirect output, making it a common tool once a command injection has already been confirmed.</p>
    </div>
</div>
HTML;

$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Testing an Input Systematically</h2>

    <p>Not every input field is worth testing. Fields that feed diagnostic tools, file lookups, or other system utilities are the most likely candidates for command injection, since these features are often built directly on top of OS commands.</p>

    <p>A systematic approach starts small and escalates carefully. Begin by observing the normal behavior of a feature with harmless input, then introduce small changes to see if the application's behavior shifts in a way that suggests your input reached a shell.</p>

    <ul>
        <li>Submit a normal, expected value first and record the baseline output.</li>
        <li>Append a chaining operator followed by a harmless command such as <code>whoami</code>.</li>
        <li>Compare the new output against the baseline to check for unexpected results.</li>
        <li>If unexpected output appears, the input is very likely an injection point.</li>
    </ul>

    <div class="success-box">
        <h4><i class="fas fa-check-circle"></i> Quick Testing Checklist</h4>
        <p>Baseline first. Inject a harmless command second. Compare outputs third. Escalate only once a difference confirms the vulnerability.</p>
    </div>
</div>
HTML;

$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been asked to review a Network Diagnostics Tool used internally by IT staff to check server connectivity. Security has not reviewed this tool yet, and your job is to determine whether it properly handles user input before passing it to the system shell.</p>

    <p>Start by testing the tool with a normal hostname or IP address to see how it behaves. Then work out whether your input reaches a shell command unfiltered, and use that to retrieve the hidden flag.</p>

    <div class="practical-launch-wrapper">
        <a href="command-injection-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Network Diagnostics Tool</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Command injection occurs whenever an application passes user input directly into a system shell without checking it first. You have seen how this happens at the code level, the operators attackers use to chain commands, and a systematic way to test for the flaw before it becomes a real breach.</p>

    <p>These skills apply well beyond diagnostic tools. Any feature built on top of a system call, from file converters to network utilities, deserves the same scrutiny you practiced here.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Command injection happens when untrusted input reaches an OS shell unchecked.</li>
        <li>PHP functions like <code>system()</code> and <code>shell_exec()</code> are common execution points.</li>
        <li>Chaining operators such as <code>;</code>, <code>&amp;&amp;</code>, and <code>|</code> let attackers run extra commands.</li>
        <li>Testing systematically with a baseline and a harmless payload reveals injection points safely.</li>
        <li>Preventing command injection means validating input and avoiding shell execution wherever possible.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';