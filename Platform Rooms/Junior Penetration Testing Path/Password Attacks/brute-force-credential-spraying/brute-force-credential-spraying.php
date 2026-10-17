<?php
// brute-force-credential-spraying.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'brute-force-credential-spraying',
    'title'           => 'Brute Force & Credential Spraying',
    'description'     => 'Distinguish exhaustive brute force attacks from targeted credential spraying, and learn why spraying is the preferred technique in real engagements.',
    'icon'            => 'fas fa-key',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of authentication'],
    'learning_objectives' => [
        'Define brute force and credential spraying attacks',
        'Explain how account lockout thresholds work',
        'Identify why spraying reduces detection and lockout risk',
        'Recognize defenses that mitigate both attack types',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/brute-force-credential-spraying-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'How Login Attempts Are Controlled'],
    ['id' => 'task3', 'title' => 'Brute Force vs Credential Spraying'],
    ['id' => 'task4', 'title' => 'Detecting and Defending Against These Attacks'],
    ['id' => 'task5', 'title' => 'The Lockout Trap'],
    ['id' => 'task6', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'brute_force_credential_spraying_progress',
    'instagram_takeaways'  => [
        '✓ Brute force tries many passwords on one account',
        '✓ Credential spraying tries few passwords across many accounts',
        '✓ Spraying stays under lockout thresholds to avoid detection',
        '✓ Layered defenses like MFA and rate limiting stop both attacks',
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
        ['id' => 'q1', 'text' => 'What is the term for temporarily blocking an account after too many failed login attempts?'],
        ['id' => 'q2', 'text' => 'What is the name for the maximum number of failed attempts allowed before that block occurs?'],
        ['id' => 'q3', 'text' => 'What technique slows down the rate of login attempts to reduce attack speed?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What type of attack tries many passwords against a single account?'],
        ['id' => 'q5', 'text' => 'What type of attack tries a small number of passwords across many accounts?'],
        ['id' => 'q6', 'text' => 'What does spraying help attackers avoid that brute force typically triggers?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What security control requires an additional verification step beyond a password?'],
        ['id' => 'q8', 'text' => 'What type of system flags unusual login patterns spread across many accounts?'],
    ],
    'task5' => [
        ['id' => 'q9', 'text' => 'Enter the flag you discovered in the Lockout Trap simulation.'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every login form on the internet faces the same threat: someone trying to guess their way past it. Attackers have two fundamentally different strategies for doing this, and the strategy they choose says a lot about how careful they are trying to be.</p>

    <p>By the end of this room you will be able to explain the difference between brute force and credential spraying, describe why spraying is the preferred approach in real engagements, and see this tradeoff play out firsthand in a hands on lockout simulation.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Define brute force and credential spraying attacks.</li>
        <li>Explain how account lockout thresholds work.</li>
        <li>Identify why spraying reduces detection and lockout risk.</li>
        <li>Recognize defenses that mitigate both attack types.</li>
    </ul>
</div>
HTML;

// TASK 2: How Login Attempts Are Controlled
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Slowing Down the Guessing Game</h2>

    <p>Every login system needs a way to stop someone from simply guessing passwords forever. The most common defense is the account lockout, a rule that temporarily blocks an account after too many failed attempts.</p>

    <p>Think of a bank card at an ATM. Enter the wrong PIN three times and the card locks, forcing you to call the branch. The bank is not preventing you from ever trying again, it is slowing down anyone who does not already know the correct PIN.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Lockout thresholds exist to protect users as much as systems. Without them, an attacker with a list of common passwords could try every one of them against your account in seconds.</p>
    </div>

    <h3>Key Terms</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Term</th>
                <th>Definition</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Lockout</strong></td>
                <td>Temporarily blocking an account from logging in after repeated failures.</td>
                <td>An account frozen for 30 seconds after 3 wrong passwords.</td>
            </tr>
            <tr>
                <td><strong>Threshold</strong></td>
                <td>The maximum number of failed attempts allowed before a lockout is triggered.</td>
                <td>A threshold of 3 attempts per account.</td>
            </tr>
            <tr>
                <td><strong>Rate Limiting</strong></td>
                <td>Slowing the speed at which login attempts can be submitted.</td>
                <td>Allowing only one login attempt per second from a given source.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Lockout counter cycle
         Teaching purpose: show the learner that a lockout is a temporary, threshold based
         state rather than a permanent ban, which they would otherwise misunderstand as
         the account being disabled for good. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Lockout counter cycle">
            <!-- Attempt boxes -->
            <rect x="20"  y="30" width="70" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="110" y="30" width="70" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="200" y="30" width="70" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="55"  y="72" text-anchor="middle" font-size="20" fill="var(--text-primary)">1</text>
            <text x="145" y="72" text-anchor="middle" font-size="20" fill="var(--text-primary)">2</text>
            <text x="235" y="72" text-anchor="middle" font-size="20" fill="var(--text-primary)">3</text>
            <text x="145" y="120" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Failed attempts</text>

            <!-- Arrow to lock state -->
            <line x1="280" y1="65" x2="345" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <!-- Lock state -->
            <rect x="355" y="20" width="150" height="90" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="430" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Locked</text>
            <text x="430" y="75" text-anchor="middle" font-size="11" fill="var(--text-secondary)">30 second timer</text>

            <!-- Arrow to reset -->
            <line x1="505" y1="65" x2="570" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <!-- Reset state -->
            <rect x="580" y="20" width="110" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="635" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Counter</text>
            <text x="635" y="78" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Resets</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Brute Force vs Credential Spraying
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Two Attacks, Two Shapes</h2>

    <p>Brute force and credential spraying both try to guess a working password, but they take opposite shapes. Brute force tries many passwords against one account. Credential spraying tries a small number of passwords across many accounts.</p>

    <p>Imagine a building with a hundred doors. Brute force is trying every key on your keyring against a single door until one works. Credential spraying is trying one common master key against every door in the building, one at a time.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Why Spraying Is Preferred</h4>
        <p>In real engagements, attackers favor spraying because it avoids triggering lockouts and generates far fewer alerts. A single account rarely sees more than one or two failed attempts, so it stays under the radar of both lockout thresholds and monitoring systems.</p>
    </div>

    <h3>Comparing the Two Approaches</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Attack Type</th>
                <th>Passwords Tried</th>
                <th>Accounts Targeted</th>
                <th>Lockout Risk</th>
                <th>Detection Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Brute Force</strong></td>
                <td>Many</td>
                <td>One</td>
                <td>High</td>
                <td>High</td>
            </tr>
            <tr>
                <td><strong>Credential Spraying</strong></td>
                <td>Few</td>
                <td>Many</td>
                <td>Low</td>
                <td>Low</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Attack shape comparison
         Teaching purpose: show the learner the structural difference between the two attack
         patterns, which they would otherwise misunderstand as variations of the same technique
         rather than fundamentally different strategies. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Brute force versus credential spraying shapes">
            <!-- Brute force side -->
            <text x="160" y="25" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Brute Force</text>
            <circle cx="160" cy="90" r="26" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="160" y="95" text-anchor="middle" font-size="11" fill="var(--text-primary)">Account</text>
            <line x1="80" y1="140" x2="140" y2="105" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="120" y1="150" x2="150" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="160" y1="155" x2="160" y2="118" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="200" y1="150" x2="170" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="240" y1="140" x2="180" y2="105" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="160" y="185" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Many passwords</text>
            <text x="160" y="200" text-anchor="middle" font-size="11" fill="var(--text-secondary)">one target</text>

            <!-- Divider -->
            <line x1="350" y1="10" x2="350" y2="210" stroke="var(--border)" stroke-width="1"/>

            <!-- Spraying side -->
            <text x="540" y="25" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Credential Spraying</text>
            <rect x="440" y="70" width="40" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="500" y="70" width="40" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="560" y="70" width="40" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="620" y="70" width="40" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="540" y1="150" x2="460" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="540" y1="150" x2="520" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="540" y1="150" x2="580" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="540" y1="150" x2="640" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <circle cx="540" cy="160" r="12" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="540" y="195" text-anchor="middle" font-size="11" fill="var(--text-secondary)">One password</text>
            <text x="540" y="210" text-anchor="middle" font-size="11" fill="var(--text-secondary)">many targets</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Detecting and Defending Against These Attacks
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Building a Layered Defense</h2>

    <p>No single defense stops both brute force and credential spraying on its own. Effective protection comes from combining several controls, each targeting a different part of the attack.</p>

    <p>Multi factor authentication, rate limiting, and monitoring for unusual login patterns each address a different weakness, and together they make both attack styles far harder to succeed at.</p>

    <h3>Common Defenses</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Defense</th>
                <th>How It Works</th>
                <th>Which Attack It Mitigates</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Multi Factor Authentication</strong></td>
                <td>Requires a second proof of identity beyond the password.</td>
                <td>Both. A correct password alone is no longer enough.</td>
            </tr>
            <tr>
                <td><strong>Rate Limiting</strong></td>
                <td>Restricts how quickly login attempts can be submitted.</td>
                <td>Mainly brute force, by slowing rapid guessing.</td>
            </tr>
            <tr>
                <td><strong>CAPTCHA</strong></td>
                <td>Requires proof of a human user before allowing more attempts.</td>
                <td>Mainly brute force, by blocking automated tools.</td>
            </tr>
            <tr>
                <td><strong>Anomaly Detection</strong></td>
                <td>Flags unusual login patterns spread across many accounts.</td>
                <td>Mainly credential spraying, which avoids single account thresholds.</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Defenders should assume attackers will avoid triggering a single account lockout. Detecting spraying requires looking across accounts, not just at any one account in isolation.</p>
    </div>
</div>
HTML;

// TASK 5: The Lockout Trap (practical)
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <p>Meridian Corp has given you access to a simulated login portal for a security assessment. Your job is to compromise an account without triggering repeated lockouts, the same tradeoff real attackers face in the field.</p>

    <p>Switch between Brute Force mode and Credential Spray mode, watch how the lockout meter responds to each, and find the weak account before your access is cut off.</p>

    <div class="practical-launch-wrapper">
        <a href="brute-force-credential-spraying-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch The Lockout Trap</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 6: Conclusion
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>Brute force and credential spraying both aim to guess a working password, but they take opposite approaches. Brute force trades speed for risk, quickly triggering lockouts and alerts. Credential spraying trades speed for stealth, spreading attempts thin to stay under detection thresholds.</p>

    <p>The Lockout Trap simulation showed this tradeoff directly. The same principles apply on the defensive side, where layered controls like multi factor authentication and cross account monitoring are needed to catch both attack styles.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Brute force tries many passwords against one account and quickly triggers lockouts.</li>
        <li>Credential spraying tries few passwords across many accounts to stay under lockout thresholds.</li>
        <li>Spraying is preferred in real engagements because it avoids detection and account lockouts.</li>
        <li>Defenders mitigate these attacks through MFA, rate limiting, and anomaly detection across accounts.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
