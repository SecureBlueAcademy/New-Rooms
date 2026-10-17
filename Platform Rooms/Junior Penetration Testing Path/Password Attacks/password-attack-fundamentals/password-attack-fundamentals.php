<?php
// password-attack-fundamentals.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'password-attack-fundamentals',
    'title'           => 'Password Attack Fundamentals',
    'description'     => 'Learn the three categories of password attacks and how attackers decide which one to use.',
    'icon'            => 'fas fa-key',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic understanding of logins and passwords'],
    'learning_objectives' => [
        'Explain the three categories of password attacks: online, offline, and credential reuse',
        'Apply a decision tree to determine which attack category applies to a given scenario',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/password-attack-fundamentals-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Why Complexity Alone Fails'],
    ['id' => 'task3', 'title' => 'Online Password Attacks'],
    ['id' => 'task4', 'title' => 'Offline Password Attacks'],
    ['id' => 'task5', 'title' => 'Credential Reuse and the Decision Tree'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'password_attack_fundamentals_progress',
    'instagram_takeaways'  => [
        '✓ Password attacks fall into three categories: online, offline, and credential reuse',
        '✓ Complexity policies alone do not stop reused or leaked passwords',
        '✓ Offline attacks remove the live system\'s rate limiting entirely',
        '✓ Attackers choose their attack based on what access they already have',
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
        ['id' => 'q1', 'text' => 'What is the term for using the same password across multiple accounts?'],
        ['id' => 'q2', 'text' => 'What term describes a password that meets complexity rules but is still frequently used and easily guessed?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What type of password attack sends login guesses directly to a live authentication service?'],
        ['id' => 'q4', 'text' => 'What security control limits the number of failed login attempts on a live service?'],
        ['id' => 'q5', 'text' => 'What technique tries every word from a predefined list against a login form?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What type of attack is performed on a stolen password hash without contacting the live system?'],
        ['id' => 'q7', 'text' => 'What hardware component significantly speeds up offline password cracking?'],
        ['id' => 'q8', 'text' => 'Name one modern password hashing algorithm designed to resist fast offline cracking.'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What automated attack tests large numbers of leaked username and password pairs against multiple services?'],
        ['id' => 'q10', 'text' => 'Besides using unique passwords, what additional control best protects against credential stuffing?'],
        ['id' => 'q11', 'text' => 'According to the decision tree, what artifact does an attacker need in hand to perform an offline attack?'],
    ],
    'task6' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the Attack Triage Console.'],
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
    <p>Password attacks are the most common way attackers gain access to a system, more common than exploiting software vulnerabilities. Every login page, every stored password database, and every reused credential is a potential entry point, and understanding how these attacks work is the foundation of both offense and defense.</p>

    <p>By the end of this room, you will be able to classify any password related scenario into the correct attack category and reason about which method an attacker would realistically choose. A hands on practical is included to put this classification skill into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the three categories of password attacks: online, offline, and credential reuse.</li>
        <li>Describe why password complexity policies alone do not prevent compromise.</li>
        <li>Apply a decision tree to determine which attack category applies to a given scenario.</li>
        <li>Classify real world artifacts into the correct attack category.</li>
    </ul>
</div>
HTML;

// TASK 2: Why Complexity Alone Fails
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Why Complexity Alone Fails</h2>

    <p>Most organizations require passwords with a mix of uppercase letters, numbers, and symbols, believing this alone keeps accounts safe. In reality, complexity rules only control what a password looks like. They do nothing to stop a password from being reused, phished, or exposed in a database breach.</p>

    <p>Attackers are not looking for the hardest password to crack. They are looking for the easiest path to a valid credential, and that path rarely runs through brute forcing a truly random password.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Complexity Is Not Strength</h4>
        <p>A password like "Password1!" satisfies most complexity policies while still being one of the most guessed passwords in existence. Complexity rules a character set, not a habit.</p>
    </div>

    <p>Think of a complexity requirement like a strong deadbolt on the front door. It does not matter how good that lock is if a spare key is left under the mat, or if the same key also opens the back door of a house two streets away.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Most real world breaches begin with a reused or leaked credential, not a cracked complex password.</p>
    </div>
</div>
HTML;

// TASK 3: Online Password Attacks
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Attacking a Live Service</h2>

    <p>An online password attack sends login guesses directly to a live authentication service, such as a website login form or a remote login service. Every guess is a real interaction with the target system.</p>

    <p>Because the target system is involved in every attempt, online attacks are constrained by whatever protections that system has in place, such as account lockouts, rate limiting, or CAPTCHA challenges. This makes them slower and much easier to detect than attacks performed elsewhere.</p>

    <!-- SVG: Online attack flow
         Teaching purpose: show the learner that online attacks are constrained by the target's own throttling,
         which they would otherwise misunderstand as unlimited guessing. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Online password attack flow">
            <!-- Attacker box -->
            <rect x="20" y="70" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="110" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Attacker</text>

            <!-- Live service box -->
            <rect x="520" y="60" width="160" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="98" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Live Login</text>
            <text x="600" y="116" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Service</text>

            <!-- Repeated attempt arrows -->
            <line x1="175" y1="90" x2="515" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrOnline)"/>
            <line x1="175" y1="105" x2="515" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrOnline)"/>
            <line x1="175" y1="120" x2="515" y2="120" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrOnline)"/>
            <defs>
                <marker id="arrOnline" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="345" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">login attempts</text>

            <!-- Lockout indicator -->
            <rect x="520" y="170" width="160" height="40" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="4 3"/>
            <text x="600" y="195" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Lockout after 5 attempts</text>
        </svg>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Technique</th>
                <th>Description</th>
                <th>Speed</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Brute Force</strong></td>
                <td>Systematically tries character combinations against the live login.</td>
                <td>Slow, limited by target throttling.</td>
            </tr>
            <tr>
                <td><strong>Dictionary Attack</strong></td>
                <td>Tries a curated list of common or leaked passwords against the live login.</td>
                <td>Faster, but still limited by the target.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Noisy by Nature</h4>
        <p>Online attacks tend to trigger alerts and account lockouts, which makes them one of the easiest attack categories to detect.</p>
    </div>
</div>
HTML;

// TASK 4: Offline Password Attacks
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Attacking a Stolen Hash</h2>

    <p>An offline password attack happens after an attacker has already obtained a copy of a password hash, usually from a compromised database or server. From that point on, the attack no longer touches the live system at all.</p>

    <p>Because the live target is no longer involved, there is no rate limiting, no lockout, and no logging to slow the attacker down. The only real limits are the attacker's hardware and the strength of the hashing algorithm used to protect the password.</p>

    <!-- SVG: Offline attack flow
         Teaching purpose: show the learner that offline attacks remove the live system's rate limit entirely,
         which they would otherwise conflate with the speed limits of online attacks. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Offline password attack flow">
            <!-- Server box -->
            <rect x="20" y="60" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="95" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Compromised</text>
            <text x="100" y="113" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Server</text>

            <!-- Attacker machine box -->
            <rect x="270" y="60" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="95" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attacker</text>
            <text x="350" y="113" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Machine (GPU)</text>

            <!-- Cracked password box -->
            <rect x="520" y="60" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="95" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Cracked</text>
            <text x="600" y="113" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Password</text>

            <!-- Arrows -->
            <line x1="185" y1="100" x2="265" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrOffline)"/>
            <line x1="435" y1="100" x2="515" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrOffline)"/>
            <defs>
                <marker id="arrOffline" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="225" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">hash file stolen</text>
            <text x="475" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">cracked offline</text>
        </svg>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>Online Attack</th>
                <th>Offline Attack</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Location</strong></td>
                <td>Runs against the live target system.</td>
                <td>Runs on the attacker's own hardware.</td>
            </tr>
            <tr>
                <td><strong>Speed limit</strong></td>
                <td>Limited by the target's response time and lockout policy.</td>
                <td>Limited only by hardware and the hashing algorithm.</td>
            </tr>
            <tr>
                <td><strong>Detectability</strong></td>
                <td>Often triggers alerts and account lockouts.</td>
                <td>Invisible to the target once the hash is stolen.</td>
            </tr>
            <tr>
                <td><strong>Requirement</strong></td>
                <td>Network access to the live service.</td>
                <td>A copy of the password hash database.</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Strong hashing algorithms such as bcrypt and Argon2 make offline cracking dramatically slower, even with powerful hardware.</p>
    </div>
</div>
HTML;

// TASK 5: Credential Reuse and the Decision Tree
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When One Breach Unlocks Another</h2>

    <p>Credential reuse means taking a username and password pair leaked from one breach and trying it against a completely different service. It works because so many people reuse the same password across multiple accounts.</p>

    <p>Credential stuffing automates this idea at scale, testing thousands of leaked username and password pairs against many services in a short amount of time. No password cracking is involved at all, since the password is already known in plain text.</p>

    <p>Think of it like finding a master key inside one building and trying it on the doors of a completely different building across town. The key was never picked or copied, it was simply reused somewhere it was never meant to work.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Fast and Automated</h4>
        <p>Credential stuffing tools can test thousands of accounts per hour, making this one of the highest volume password attacks in use today.</p>
    </div>

    <h3>Choosing the Right Attack</h3>
    <p>An attacker's choice of attack category depends entirely on what access or data they already have, not on personal preference.</p>

    <!-- SVG: Decision tree
         Teaching purpose: show the learner that attackers choose an attack category based on what access they already have,
         which they would otherwise misunderstand as attacks being chosen by preference rather than opportunity. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Password attack decision tree">
            <!-- Root -->
            <rect x="300" y="10" width="160" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="40" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">What do you have?</text>

            <!-- Branch lines -->
            <line x1="380" y1="60" x2="110" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="380" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="650" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <!-- Leaf 1 -->
            <rect x="20" y="110" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="140" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Live login access</text>
            <line x1="110" y1="160" x2="110" y2="190" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrTree)"/>
            <rect x="20" y="195" width="180" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="222" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Online Attack</text>

            <!-- Leaf 2 -->
            <rect x="290" y="110" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="140" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Captured hash file</text>
            <line x1="380" y1="160" x2="380" y2="190" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrTree)"/>
            <rect x="290" y="195" width="180" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="222" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Offline Attack</text>

            <!-- Leaf 3 -->
            <rect x="560" y="110" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="650" y="132" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Leaked credentials</text>
            <text x="650" y="148" text-anchor="middle" font-size="11" fill="var(--text-secondary)">from elsewhere</text>
            <line x1="650" y1="160" x2="650" y2="190" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrTree)"/>
            <rect x="560" y="195" width="180" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="650" y="222" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Credential Reuse</text>

            <defs>
                <marker id="arrTree" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 6: Practical (Attack Triage Console)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been handed three artifacts recovered during an incident investigation: a login page, a stolen hash file, and a leaked credential pair. Each one only works with a specific type of attack.</p>

    <p>Classify each artifact correctly to unlock its simulated attack result. Once all three are classified correctly, the flag will appear.</p>

    <div class="practical-launch-wrapper">
        <a href="password-attack-fundamentals-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Attack Triage Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand the three categories of password attacks and why they exist. Online attacks target a live service and are constrained by that service's own defenses. Offline attacks target a stolen hash and are limited only by hardware and hashing strength. Credential reuse exploits passwords repeated across services rather than any weakness in a single system.</p>

    <p>Complexity policies alone were never enough. Recognizing which category an attacker would use, based on what access they already have, is central to defending against all three.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Online attacks target a live service and are constrained by rate limiting and lockouts.</li>
        <li>Offline attacks target captured hashes and are limited only by hardware and algorithm strength.</li>
        <li>Credential reuse exploits passwords repeated across services, not weaknesses in any single system.</li>
        <li>Password complexity policies do not stop reuse, phishing, or offline cracking of weakly hashed passwords.</li>
        <li>The type of attack an adversary chooses depends on what access or data they already have.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
