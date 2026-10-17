<?php
// ============================================================
// authentication-session-attacks.php — ROOM DATA FILE
// Topic: Authentication & Session Attacks
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'auth-session-attacks',
    'title'           => 'Authentication & Session Attacks',
    'description'     => 'Learn how attackers break login systems through brute force, credential stuffing, default credentials, weak lockout policies, and insecure session tokens.',
    'icon'            => 'fas fa-user-lock',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic understanding of login systems', 'Basic web concepts'],
    'learning_objectives' => [
        'Explain the difference between brute force and credential stuffing attacks',
        'Identify default credentials as a common real world weakness',
        'Describe why account lockout and rate limiting policies matter',
        'Explain why encoding a session token is not the same as securing it',
        'Apply these concepts by compromising a vulnerable login portal',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/auth-session-attacks-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Brute Force Attacks'],
    ['id' => 'task3', 'title' => 'Credential Stuffing'],
    ['id' => 'task4', 'title' => 'Default Credentials'],
    ['id' => 'task5', 'title' => 'Weak Lockout Policies'],
    ['id' => 'task6', 'title' => 'Insecure Session Tokens'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'auth_session_attacks_progress',
    'instagram_takeaways'  => [
        '✓ Brute force attacks guess passwords through sheer volume',
        '✓ Credential stuffing reuses passwords leaked in other breaches',
        '✓ Default credentials remain a common real world entry point',
        '✓ Encoding a session token is not the same as securing it',
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
        ['id' => 'q1', 'text' => 'What term describes systematically trying every possible password until one works?'],
        ['id' => 'q2', 'text' => 'What is the term for the total number of possible password combinations an attacker must try?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the term for reusing leaked username and password pairs to log into other accounts?'],
        ['id' => 'q4', 'text' => 'What common user behavior makes credential stuffing attacks effective?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What term describes login credentials that are preset by a manufacturer or during setup and never changed?'],
        ['id' => 'q6', 'text' => 'What should be done to default credentials before a system goes into production?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What security control locks an account after repeated failed login attempts?'],
        ['id' => 'q8', 'text' => 'What is the name for a control that slows down repeated login attempts by adding delay between them?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'What is the term for converting data into a different format, such as base64, without providing any security?'],
        ['id' => 'q10', 'text' => 'What property must a secure session token have to prevent an attacker from guessing or forging it?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Nexus Corp Login Portal.'],
    ],
    'task8' => [
        ['id' => 'q12', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Authentication and session attacks target the login process itself, the entry point every attacker eventually needs to pass. These attacks exploit predictable behavior in real systems: weak passwords, reused credentials, unchanged defaults, and forgiving lockout logic. They succeed constantly in the real world because these weaknesses are common and often invisible until someone probes them.</p>

    <p>This room walks through five common weaknesses in authentication and session handling, then puts the concepts into practice against a vulnerable login portal. By the end, you will be able to recognize these weaknesses in a real system and understand why fixing all five matters more than fixing just one.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the difference between brute force and credential stuffing attacks.</li>
        <li>Identify default credentials as a common real world weakness.</li>
        <li>Describe why account lockout and rate limiting policies matter.</li>
        <li>Explain why encoding a session token is not the same as securing it.</li>
        <li>Apply these concepts by compromising a vulnerable login portal.</li>
    </ul>
</div>
HTML;

// TASK 2: Brute Force Attacks
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Guessing Your Way In</h2>

    <p>Brute force is the simplest attack against any login system. An attacker submits password after password until one succeeds, relying on volume rather than any real insight into the account.</p>

    <p>The size of the <strong>keyspace</strong>, the total number of possible passwords, determines how long this takes. A short password built from a small character set can be exhausted quickly. A longer password with a mix of character types can take years.</p>

    <h3>Password Strength vs Crack Time</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Password Length</th>
                <th>Character Set</th>
                <th>Approximate Time to Crack</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>4 characters</td>
                <td>Lowercase letters only</td>
                <td>Instant</td>
            </tr>
            <tr>
                <td>8 characters</td>
                <td>Lowercase letters only</td>
                <td>Minutes</td>
            </tr>
            <tr>
                <td>8 characters</td>
                <td>Mixed case and numbers</td>
                <td>Hours</td>
            </tr>
            <tr>
                <td>12 characters</td>
                <td>Mixed case, numbers, symbols</td>
                <td>Centuries</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Brute force guess loop
         Teaching purpose: show the learner that brute force is a repeating
         guess and check cycle, which they would otherwise misunderstand as
         one clever or lucky guess rather than a mechanical numbers game. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Brute force guess and check loop">
            <!-- Boxes -->
            <rect x="30" y="70" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="490" y="70" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Labels -->
            <text x="120" y="105" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Attacker</text>
            <text x="120" y="125" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Sends next guess</text>
            <text x="580" y="105" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Login System</text>
            <text x="580" y="125" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Checks password</text>
            <!-- Forward arrow -->
            <line x1="210" y1="95" x2="485" y2="95" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="350" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Try password</text>
            <!-- Return arrow -->
            <line x1="485" y1="130" x2="210" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="350" y="148" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Access denied</text>
            <!-- Loop label -->
            <text x="350" y="195" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Repeated thousands of times until one guess succeeds</text>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Warning</h4>
        <p>Short or simple passwords are the single biggest gift an attacker can receive. Length matters more than complexity alone.</p>
    </div>
</div>
HTML;

// TASK 3: Credential Stuffing
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Reusing What Was Already Stolen</h2>

    <p>Credential stuffing does not guess passwords, it reuses them. Attackers take real username and password pairs leaked from unrelated breaches and try them against a different system, betting that people reuse the same password everywhere.</p>

    <p>This attack does not need to break anything. It only needs one person, out of thousands tried, to have reused a password that already appears in a leaked list.</p>

    <h3>Brute Force vs Credential Stuffing</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th></th>
                <th>Source of Passwords</th>
                <th>Method</th>
                <th>Best Defense</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Brute Force</strong></td>
                <td>Generated or guessed</td>
                <td>Tries many passwords against one account</td>
                <td>Strong password policy and lockout</td>
            </tr>
            <tr>
                <td><strong>Credential Stuffing</strong></td>
                <td>Leaked from other breaches</td>
                <td>Tries real known pairs against many accounts</td>
                <td>Unique passwords per site, multi factor authentication</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 4: Default Credentials
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>The Password Nobody Changed</h2>

    <p>Every device and system ships with an initial account so an administrator can set it up. <strong>Default credentials</strong> are the username and password that come with that account before anyone changes them.</p>

    <p>The danger is not the existence of a default account, it is the assumption that someone will remember to change it before the system goes live.</p>

    <h3>Common Default Credential Pairs</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>System Type</th>
                <th>Example Username</th>
                <th>Example Password</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Home router</td>
                <td>admin</td>
                <td>admin</td>
            </tr>
            <tr>
                <td>Temporary test account</td>
                <td>guest</td>
                <td>guest123</td>
            </tr>
            <tr>
                <td>IoT camera</td>
                <td>admin</td>
                <td>12345</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Warning</h4>
        <p>Always audit every account on a system before it goes into production, including accounts that were only meant to be temporary.</p>
    </div>
</div>
HTML;

// TASK 5: Weak Lockout Policies
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Why Nothing Stopped the Guessing</h2>

    <p>Brute force and credential stuffing only work at scale because most systems allow unlimited login attempts. An <strong>account lockout</strong> policy locks an account after a set number of failed attempts, and <strong>rate limiting</strong> adds a delay between attempts. Both make large scale guessing impractical.</p>

    <p>Without either control in place, an attacker can submit thousands of attempts in minutes with nothing standing in the way.</p>

    <h3>Lockout Strength vs Attacker Impact</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Lockout Policy Strength</th>
                <th>Attacker Impact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>None</td>
                <td>Unlimited guesses, attack succeeds quickly</td>
            </tr>
            <tr>
                <td>Weak</td>
                <td>Long delay after many attempts, attack slowed but still possible</td>
            </tr>
            <tr>
                <td>Strong</td>
                <td>Account locked after few attempts, attack becomes impractical</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>This is the control that decides whether the attacks in the previous two tasks actually work. Strong lockout and rate limiting turn both into dead ends.</p>
    </div>
</div>
HTML;

// TASK 6: Insecure Session Tokens
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>The Wristband Problem</h2>

    <p>Once a user logs in, the system needs a way to remember who they are on every following request. This is done with a <strong>session token</strong>, a piece of data the browser sends back with each request.</p>

    <p>A session token must be unpredictable. If it can be decoded or guessed, anyone can construct a valid one without ever knowing a password.</p>

    <!-- SVG: Secure token vs insecure token
         Teaching purpose: show the learner that a random opaque token and an
         encoded readable token look similar on the surface, which they would
         otherwise misunderstand as both being equally safe. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Secure token compared to insecure encoded token">
            <!-- Secure token box -->
            <rect x="30" y="30" width="290" height="140" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="175" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Secure Token</text>
            <text x="175" y="90" text-anchor="middle" font-size="12" font-family="monospace" fill="var(--text-secondary)">f8a3c9e12b7d4f0a</text>
            <text x="175" y="130" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Random</text>
            <text x="175" y="148" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Reveals nothing when decoded</text>

            <!-- Insecure token box -->
            <rect x="380" y="30" width="290" height="140" rx="10" fill="var(--surface)" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="525" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Insecure Token</text>
            <text x="525" y="90" text-anchor="middle" font-size="12" font-family="monospace" fill="var(--text-secondary)">Z3Vlc3Q6MTAy</text>
            <text x="525" y="130" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Base64 encoded</text>
            <text x="525" y="148" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Decodes to guest:102</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Warning</h4>
        <p>Encoding a value, such as converting it to base64, only changes its format. It provides no protection. Randomness and proper protection are what make a token secure, not encoding.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have been asked to audit the Nexus Corp employee login portal ahead of its public launch. Rumor has it that a temporary account was never removed after an internal testing phase.</p>

    <p>Use what you have learned about default credentials and session tokens to find a way into the administrator console, without ever knowing the administrator password.</p>

    <div class="practical-launch-wrapper">
        <a href="auth-session-attacks-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Nexus Corp Login Portal</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Authentication and session security depend on more than one control working correctly. A strong password policy means little if default accounts are left unchanged, and a login form protected by lockout policies can still be undone by a session token that reveals its own contents.</p>

    <p>The weaknesses covered in this room appear constantly in real systems, often in combination, which is exactly why auditing all of them together matters more than fixing any single one in isolation.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Brute force attacks guess passwords through sheer volume, defeated mainly by password length and lockout policies.</li>
        <li>Credential stuffing reuses real passwords leaked elsewhere, defeated by unique passwords and multi factor authentication.</li>
        <li>Default credentials remain one of the most common entry points into real systems.</li>
        <li>Lockout policies and rate limiting are what make large scale guessing attacks impractical.</li>
        <li>Encoding a session token is not the same as securing it, tokens must be random and unpredictable.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
