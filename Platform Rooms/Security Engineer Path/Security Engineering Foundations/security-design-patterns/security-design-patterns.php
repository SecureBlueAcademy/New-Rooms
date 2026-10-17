<?php
// security-design-patterns.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'security-design-patterns',
    'title'           => 'Security Design Patterns',
    'description'     => 'Learn reusable security solutions to recurring architecture problems, including the Secure Gateway, Broker, Intercepting Validator, Single Access Point, and Full Interception patterns.',
    'icon'            => 'fas fa-shield-halved',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic authentication concepts', 'Basic input validation concepts', 'Basic understanding of client server architecture'],
    'learning_objectives' => [
        'Explain what the Secure Gateway pattern protects and how it filters incoming traffic',
        'Describe how the Broker pattern removes direct communication between components',
        'Explain how the Intercepting Validator pattern centralizes input validation',
        'Describe how the Single Access Point pattern controls authentication entry',
        'Explain the Full Interception principle and why bypass paths are dangerous',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/security-design-patterns-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is a Secure Gateway?'],
    ['id' => 'task3', 'title' => 'The Broker Pattern'],
    ['id' => 'task4', 'title' => 'Intercepting Validator'],
    ['id' => 'task5', 'title' => 'Single Access Point'],
    ['id' => 'task6', 'title' => 'Full Interception'],
    ['id' => 'task7', 'title' => 'Practical: Architecture Doctor'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'security_design_patterns_progress',
    'instagram_takeaways'  => [
        '✓ The Secure Gateway pattern filters traffic through one controlled entry',
        '✓ The Broker pattern mediates communication between components',
        '✓ The Intercepting Validator centralizes input validation',
        '✓ The Single Access Point controls authentication through one door',
        '✓ Full Interception closes every bypass path, including internal ones',
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
        ['id' => 'q1', 'text' => 'What pattern centralizes access to a resource behind one controlled entry point that filters all incoming traffic?'],
        ['id' => 'q2', 'text' => 'What security control do gateways commonly enforce to limit how many requests a client can send in a given time?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What pattern uses a central component to mediate communication between services that do not talk to each other directly?'],
        ['id' => 'q4', 'text' => 'What term describes components that communicate directly with each other instead of through a mediating layer?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What pattern centralizes input validation in one place before requests reach business logic?'],
        ['id' => 'q6', 'text' => 'What category of attack does centralized input validation primarily defend against?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What pattern provides exactly one entry point for authentication into a system?'],
        ['id' => 'q8', 'text' => 'What acronym describes letting a user authenticate once to access multiple connected applications?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What principle requires that every request pass through security enforcement with no exceptions or bypass paths?'],
        ['id' => 'q10', 'text' => 'What term describes a hidden route that skips standard security checks?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Architecture Doctor lab.'],
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
    <p>Recurring security problems tend to get recurring bad fixes when every team invents its own answer from scratch. Security design patterns exist to break that cycle. They are proven, reusable solutions to problems that show up again and again in real architectures, such as too many entry points, direct calls between untrusted components, or validation logic scattered across an application.</p>

    <p>By the end of this room, you will be able to recognize five widely used security design patterns, explain what each one protects against, and know when to apply them. A hands-on practical is included where you diagnose a vulnerable architecture and apply the correct pattern to fix each weakness.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what the Secure Gateway pattern protects and how it filters incoming traffic.</li>
        <li>Describe how the Broker pattern removes direct communication between components.</li>
        <li>Explain how the Intercepting Validator pattern centralizes input validation.</li>
        <li>Describe how the Single Access Point pattern controls authentication entry.</li>
        <li>Explain the Full Interception principle and why bypass paths are dangerous.</li>
    </ul>
</div>
HTML;

// TASK 2: Secure Gateway
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Controlling the Front Door</h2>

    <p>A Secure Gateway centralizes access to a protected resource behind one controlled point instead of letting clients reach that resource directly. Every request passes through the gateway first, where it can be filtered, authenticated, and monitored before it ever touches the system behind it.</p>

    <p>Think of a building with a single staffed security desk at the entrance instead of every floor having its own unlocked door. Visitors still reach every floor they are permitted to visit, but they all pass one checkpoint first, and that checkpoint sees everything.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Real World Example</h4>
        <p>API gateways commonly enforce rate limiting and authentication before a request ever reaches a backend service, keeping that enforcement in one place instead of duplicated across every service.</p>
    </div>

    <h3>Direct Access vs Gateway Mediated Access</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Factor</th>
                <th>Direct Access</th>
                <th>Gateway Mediated Access</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Exposure</td>
                <td>Backend services are reachable directly from untrusted networks</td>
                <td>Backend services are hidden behind one controlled entry point</td>
            </tr>
            <tr>
                <td>Monitoring</td>
                <td>Each service must log and monitor its own traffic</td>
                <td>All traffic is visible and logged in one place</td>
            </tr>
            <tr>
                <td>Consistency</td>
                <td>Security checks vary between services</td>
                <td>The same checks apply to every request</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Secure Gateway flow
         Teaching purpose: show the learner that a Secure Gateway sits between
         untrusted clients and a protected resource, filtering all traffic through
         one point, which they would otherwise misunderstand as just a firewall. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Secure Gateway flow diagram">
            <!-- Client group -->
            <rect x="10" y="30" width="150" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10" y="70" width="150" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="50" text-anchor="middle" font-size="12" fill="var(--text-primary)">Web Client</text>
            <text x="85" y="90" text-anchor="middle" font-size="12" fill="var(--text-primary)">Mobile Client</text>
            <!-- Gateway box -->
            <rect x="300" y="20" width="170" height="100" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="385" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Secure Gateway</text>
            <text x="385" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Filters and authenticates</text>
            <!-- Protected resource -->
            <rect x="600" y="35" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="675" y="70" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Backend Service</text>
            <!-- Arrows -->
            <line x1="165" y1="45" x2="295" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="165" y1="85" x2="295" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="470" y1="70" x2="595" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>The gateway does not just forward traffic. It decides what is allowed to pass, which is what makes it a security control rather than a router.</p>
    </div>
</div>
HTML;

// TASK 3: The Broker Pattern
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Removing Direct Trust Between Components</h2>

    <p>The Broker pattern places a mediating component between services so they never communicate directly. Instead of each service trusting and calling every other service on its own, all communication is routed through the broker, which can apply consistent security checks, routing, and error handling.</p>

    <p>Picture a translator relaying messages between two parties who do not speak the same language and do not fully trust each other. Neither party deals with the other directly. Everything passes through the translator, who applies the same rules every time.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Without a Broker</h4>
        <p>Each service ends up duplicating its own security logic for every other service it talks to, which increases inconsistency and widens the attack surface as the system grows.</p>
    </div>

    <!-- SVG: Broker mediation
         Teaching purpose: show the learner that services never talk directly to
         each other and instead route through a central broker, which they would
         otherwise confuse with a simple load balancer. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Broker pattern mediation diagram">
            <rect x="20" y="10" width="140" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="20" y="60" width="140" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="20" y="110" width="140" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90" y="35" text-anchor="middle" font-size="12" fill="var(--text-primary)">Service A</text>
            <text x="90" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Service B</text>
            <text x="90" y="135" text-anchor="middle" font-size="12" fill="var(--text-primary)">Service C</text>

            <rect x="330" y="55" width="150" height="50" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="405" y="85" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Broker</text>

            <rect x="600" y="60" width="140" height="40" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="670" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Legacy Subsystem</text>

            <line x1="160" y1="30" x2="325" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="160" y1="80" x2="325" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="160" y1="130" x2="325" y2="95" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="480" y1="80" x2="595" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <p>A common real world case is a legacy inventory subsystem that many services depend on. Without a broker, each of those services ends up holding its own credentials and its own error handling for that one legacy system, and any weakness in one integration exposes the rest.</p>
</div>
HTML;

// TASK 4: Intercepting Validator
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Catching Bad Input Before It Spreads</h2>

    <p>The Intercepting Validator centralizes input validation in one place before any request reaches business logic, instead of trusting each part of the application to validate its own inputs separately.</p>

    <p>It works like an airport security checkpoint. Every passenger is screened once at a single checkpoint rather than each gate deciding on its own whether to trust the passengers who arrive.</p>

    <!-- SVG: Intercepting Validator layer
         Teaching purpose: show the learner that all input passes through one
         validation layer before reaching application logic, which they would
         otherwise misunderstand as just frontend form validation. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Intercepting Validator diagram">
            <rect x="10" y="20" width="130" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10" y="60" width="130" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10" y="100" width="130" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="75" y="40" text-anchor="middle" font-size="11" fill="var(--text-primary)">Search Form</text>
            <text x="75" y="80" text-anchor="middle" font-size="11" fill="var(--text-primary)">Checkout Form</text>
            <text x="75" y="120" text-anchor="middle" font-size="11" fill="var(--text-primary)">Login Form</text>

            <rect x="300" y="40" width="170" height="60" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="385" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Intercepting Validator</text>
            <text x="385" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Checks all input once</text>

            <rect x="610" y="45" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="680" y="75" text-anchor="middle" font-size="12" fill="var(--text-primary)">Business Logic</text>

            <line x1="140" y1="35" x2="295" y2="55" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="140" y1="75" x2="295" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="140" y1="115" x2="295" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="470" y1="70" x2="605" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>This pattern is what stops injection style attacks at the door rather than deep inside the system, where a missed check anywhere else no longer matters.</p>
    </div>

    <p>Search and checkout forms that pass user input straight to a database with no centralized filtering are a textbook case where this pattern is missing, leaving every form responsible for catching malicious input on its own.</p>
</div>
HTML;

// TASK 5: Single Access Point
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>One Guarded Door Instead of Many</h2>

    <p>The Single Access Point pattern provides exactly one entry point for authentication into a system, rather than several separate entry points that each apply their own inconsistent checks.</p>

    <p>It is the difference between a compound with one guarded front gate and a compound with several unlocked side doors. Even if the front gate is well guarded, an attacker only needs to find one weak side door to get in.</p>

    <!-- SVG: Single Access Point collapse
         Teaching purpose: show the learner multiple unguarded entry points
         collapsing into one guarded entry point, which they would otherwise
         confuse with simply having a login page. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Single Access Point diagram">
            <rect x="10" y="15" width="140" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10" y="55" width="140" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10" y="95" width="140" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="35" text-anchor="middle" font-size="11" fill="var(--text-primary)">Web Login</text>
            <text x="80" y="75" text-anchor="middle" font-size="11" fill="var(--text-primary)">Mobile API Login</text>
            <text x="80" y="115" text-anchor="middle" font-size="11" fill="var(--text-primary)">Partner Login</text>

            <rect x="320" y="40" width="160" height="60" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="400" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Single Access Point</text>
            <text x="400" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">One guarded gate</text>

            <rect x="610" y="45" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="680" y="75" text-anchor="middle" font-size="12" fill="var(--text-primary)">Authenticated Session</text>

            <line x1="150" y1="30" x2="315" y2="55" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="150" y1="70" x2="315" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="150" y1="110" x2="315" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="480" y1="70" x2="605" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Real World Example</h4>
        <p>Single Sign On implementations rely on this pattern architecturally, giving users one authentication flow to reach many connected applications.</p>
    </div>

    <p>A system where customers can log in through three separate endpoints, each with its own inconsistent authentication check, is a common example of this pattern being missing entirely.</p>
</div>
HTML;

// TASK 6: Full Interception
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>No Exceptions, Not Even for Staff</h2>

    <p>Full Interception is the principle that every request must pass through security enforcement with no bypass paths, including internal tools, debug routes, or paths considered trusted.</p>

    <p>Picture a security checkpoint with no back door, not even for staff. The moment one path is allowed to skip the checkpoint, the checkpoint no longer protects the system as a whole, because an attacker only needs to find that one path.</p>

    <!-- SVG: Full Interception with bypass closed
         Teaching purpose: show the learner a normal request path alongside a
         bypass path being closed off, which they would otherwise misunderstand
         as redundant since they already learned Single Access Point. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Full Interception diagram">
            <rect x="10" y="20" width="140" height="35" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="43" text-anchor="middle" font-size="12" fill="var(--text-primary)">Normal Request</text>

            <rect x="300" y="15" width="160" height="45" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="380" y="42" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Security Enforcement</text>

            <rect x="600" y="20" width="140" height="35" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="670" y="43" text-anchor="middle" font-size="12" fill="var(--text-primary)">Application Logic</text>

            <line x1="150" y1="37" x2="295" y2="37" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr6)"/>
            <line x1="460" y1="37" x2="595" y2="37" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr6)"/>

            <rect x="10" y="95" width="140" height="35" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="118" text-anchor="middle" font-size="12" fill="var(--text-primary)">Debug Endpoint</text>

            <line x1="150" y1="112" x2="360" y2="112" stroke="var(--error)" stroke-width="2" stroke-dasharray="6,4"/>
            <line x1="360" y1="112" x2="595" y2="55" stroke="var(--error)" stroke-width="2" stroke-dasharray="6,4"/>
            <text x="270" y="135" text-anchor="middle" font-size="11" fill="var(--error)">Bypass path, must be closed</text>

            <defs>
                <marker id="arr6" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Common Violation</h4>
        <p>Debug endpoints and internal admin tools are among the most common places this principle gets silently violated, since they are often built quickly and assumed to be trusted.</p>
    </div>

    <p>An admin panel with a debug endpoint that skips the standard request pipeline entirely is a direct example of a bypass path that violates Full Interception, no matter how well the rest of the system is protected.</p>
</div>
HTML;

// TASK 7: Practical - Architecture Doctor
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have been handed the architecture diagram of a live e-commerce platform. It has five known weak points, each caused by a missing security design pattern. Your job is to diagnose each weakness and select the pattern that fixes it.</p>

    <p>Click each marker on the diagram to review the weakness, then choose the correct pattern from the dropdown. Once all five weaknesses are patched, the system is secure and the flag will appear.</p>

    <div class="practical-launch-wrapper">
        <a href="security-design-patterns-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Architecture Doctor</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Security design patterns turn recurring architecture problems into solved problems. The Secure Gateway controls what reaches a resource, the Broker removes direct trust between components, the Intercepting Validator stops bad input at the door, the Single Access Point closes off extra entry ways, and Full Interception makes sure nothing skips the line, not even trusted internal paths.</p>

    <p>None of these patterns works well alone. Real systems combine them, and recognizing which one a given weakness is missing is the skill that lets you fix architecture problems instead of patching symptoms.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Secure Gateway centralizes and filters access to a protected resource.</li>
        <li>Broker mediates communication so components never trust each other directly.</li>
        <li>Intercepting Validator centralizes input validation before it reaches business logic.</li>
        <li>Single Access Point provides one guarded entry point for authentication.</li>
        <li>Full Interception requires every request to pass enforcement, with no bypass paths.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
