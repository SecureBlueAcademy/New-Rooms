<?php
// firewall-architecture-rule-engineering.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'firewall-architecture-rule-engineering',
    'title'           => 'Firewall Architecture & Rule Engineering',
    'description'     => 'Learn stateful and next-generation firewall architecture, rule base design, and how to keep a rule set clean and auditable over time.',
    'icon'            => 'fas fa-fire',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of ACLs'],
    'learning_objectives' => [
        'Distinguish stateful firewall inspection from next-generation firewall (NGFW) inspection',
        'Apply core rule base design principles including least privilege',
        'Explain rule ordering, first match evaluation, and how shadow rules occur',
        'Identify overly permissive ACL patterns and their risks',
        'Describe a change management process that prevents rule base degradation',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/firewall-architecture-rule-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Stateful vs Next-Generation Firewalls'],
    ['id' => 'task3', 'title' => 'Rule Base Design Principles'],
    ['id' => 'task4', 'title' => 'Rule Ordering and Shadow Rules'],
    ['id' => 'task5', 'title' => 'Overly Permissive ACLs'],
    ['id' => 'task6', 'title' => 'Firewall Change Management'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'firewall_architecture_rule_engineering_progress',
    'instagram_takeaways'  => [
        '✓ Stateful inspection vs NGFW application awareness',
        '✓ Rule base design and the principle of least privilege',
        '✓ First match evaluation and shadow rules',
        '✓ Spotting overly permissive ACLs before they become breaches',
        '✓ Change management that keeps a rule base clean over time',
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
        ['id' => 'q1', 'text' => 'What type of firewall inspection tracks the state of active connections?'],
        ['id' => 'q2', 'text' => 'What term describes a firewall\'s ability to inspect traffic at the application layer?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What security principle states that access should be limited to only what is necessary?'],
        ['id' => 'q4', 'text' => 'What is the default rule that should exist at the bottom of a firewall rule base?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What term describes a rule that never triggers because an earlier rule already matches all its traffic?'],
        ['id' => 'q6', 'text' => 'In rule base evaluation, what determines which rule is applied to a packet?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What do you call a rule that grants far more access than required?'],
        ['id' => 'q8', 'text' => 'What is the term for unauthorized movement between systems inside a network after initial access?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What is the term for the formal process of reviewing, approving, and documenting firewall rule changes?'],
        ['id' => 'q10', 'text' => 'What practice involves periodically reviewing existing rules to remove unnecessary or outdated ones?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Rule Base Audit.'],
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
    <p>Firewalls are often treated as a one time setup: write some rules, deploy them, move on. In reality, a firewall's rule base is a living document. Every exception added under pressure, every "temporary" broad rule that never gets removed, and every new service added without review slowly pushes the rule base toward a state nobody fully understands anymore. That gap between what a rule base looks like and what it actually does is where real breaches happen.</p>

    <p>By the end of this room, you will be able to explain how stateful and next generation firewalls inspect traffic differently, apply sound rule design principles, reason about rule ordering and shadow rules, spot overly permissive access control entries, and describe a change management process that keeps a rule base clean over time. A hands on rule base audit is included so you can apply these skills directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Distinguish stateful firewall inspection from next generation firewall (NGFW) inspection.</li>
        <li>Apply core rule base design principles including least privilege.</li>
        <li>Explain rule ordering, first match evaluation, and how shadow rules occur.</li>
        <li>Identify overly permissive ACL patterns and their risks.</li>
        <li>Describe a change management process that prevents rule base degradation.</li>
    </ul>
</div>
HTML;

// TASK 2: Stateful vs Next-Generation Firewalls
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Ways of Watching Traffic</h2>

    <p>A stateful firewall does not look at packets in isolation. It keeps a state table that tracks every active connection passing through it: source, destination, port, and connection status. Once a connection is established as legitimate, the firewall allows the matching return traffic automatically without re-evaluating every packet against the full rule base.</p>

    <p>A next generation firewall (NGFW) builds on top of that same stateful foundation, but adds visibility into what is actually happening inside the traffic. Instead of only asking "is this connection allowed," it can inspect the application and content riding on top of it.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What a State Table Tracks</h4>
        <p>A typical state table entry records the source and destination IP, source and destination port, protocol, and current connection state (such as established or closing). This lets the firewall recognize return traffic instantly instead of treating it as a brand new, unverified request.</p>
    </div>

    <h3>Stateful vs NGFW at a Glance</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Capability</th>
                <th>Stateful Firewall</th>
                <th>Next Generation Firewall</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>OSI layers inspected</td>
                <td>Layer 3 and 4</td>
                <td>Layer 3 through 7</td>
            </tr>
            <tr>
                <td>Connection state awareness</td>
                <td>Yes</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td>Application awareness</td>
                <td>No</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td>Example capability</td>
                <td>Allow return traffic for an established TCP session</td>
                <td>Block a specific app even if it tunnels over an allowed port</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: stateful vs NGFW inspection layering
         Teaching purpose: show the learner that NGFW builds on top of stateful
         inspection rather than replacing it, which they would otherwise
         misunderstand as two unrelated competing technologies. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Stateful inspection as the foundation of NGFW">
            <!-- Base layer: stateful inspection -->
            <rect x="60" y="130" width="580" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="155" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Stateful Inspection</text>
            <text x="350" y="175" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Tracks connection state, Layer 3 and 4</text>

            <!-- Upper layer: NGFW additions -->
            <rect x="60" y="40" width="580" height="60" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="1.5"/>
            <text x="350" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">NGFW Additions</text>
            <text x="350" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Application awareness, deep packet inspection, Layer 7</text>

            <!-- Connector arrow showing NGFW sits on top of stateful -->
            <line x1="350" y1="100" x2="350" y2="128" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="350" y="118" text-anchor="middle" font-size="10" fill="var(--text-secondary)">built on top of</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Every NGFW is still doing stateful inspection underneath. The difference is the extra visibility layered on top, not a replacement of the underlying mechanism.</p>
    </div>
</div>
HTML;

// TASK 3: Rule Base Design Principles
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Designing a Rule Base You Can Actually Maintain</h2>

    <p>A firewall rule base is like a rulebook for a building's security desk. A well organized rulebook lists clear, specific instructions in a logical order. A neglected one turns into a junk drawer of exceptions nobody remembers writing, each one a little more permissive than the last.</p>

    <p>Good rule base design is not about cleverness. It is about discipline: grant only what is needed, be specific, group related rules together, and document why each rule exists.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Principle</th>
                <th>Description</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Least privilege</td>
                <td>Grant only the access required for a legitimate business purpose, nothing broader.</td>
                <td>Allow one server to reach one destination on one required port, not an entire subnet on any port.</td>
            </tr>
            <tr>
                <td>Default deny</td>
                <td>Traffic that does not match an explicit allow rule is blocked by default.</td>
                <td>A final catch all deny rule at the bottom of the rule base.</td>
            </tr>
            <tr>
                <td>Rule specificity</td>
                <td>Prefer narrow, precise rules over broad ones that happen to cover the needed case.</td>
                <td>Allow a single host and port instead of an entire /16 network.</td>
            </tr>
            <tr>
                <td>Logical grouping</td>
                <td>Related rules are kept together and ordered consistently, making the rule base easier to read and audit.</td>
                <td>All rules for the finance subnet grouped in one section rather than scattered throughout the list.</td>
            </tr>
            <tr>
                <td>Documentation</td>
                <td>Every rule records its owner, business justification, and creation date.</td>
                <td>A rule comment noting who requested it and why.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-times-circle"></i> Poorly Designed Rule</h4>
        <p>ALLOW 10.10.20.0/24 to ANY on ANY port, with no comment explaining why. It is broad, undocumented, and impossible to safely remove later since nobody knows what depends on it.</p>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-check-circle"></i> Well Designed Rule</h4>
        <p>ALLOW 10.10.20.5 to 198.51.100.20 on port 443/tcp, commented "Finance reporting API, requested by J. Alvarez, reviewed quarterly." It is specific, justified, and easy to audit.</p>
    </div>
</div>
HTML;

// TASK 4: Rule Ordering and Shadow Rules
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Order Determines Behavior</h2>

    <p>Most firewalls evaluate rules top to bottom and stop at the first match. This is called first match evaluation. Once a packet matches a rule, whether that rule allows or denies it, the firewall stops checking. Every rule below that point is simply never reached for that traffic.</p>

    <p>Think of a sign in sheet with multiple instructions listed for different visitors. If an early instruction already covers a visitor's situation, the guard follows that one and never reads further down the sheet, even if a more specific instruction exists lower down.</p>

    <!-- SVG: first match evaluation stopping point
         Teaching purpose: show the learner that firewalls stop checking after
         the first match, which they would otherwise misunderstand as all
         rules being evaluated cumulatively for every packet. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="First match rule evaluation">
            <text x="350" y="20" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Incoming Packet</text>
            <line x1="350" y1="28" x2="350" y2="45" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <rect x="150" y="50" width="400" height="30" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="360" y="70" font-size="12" fill="var(--text-primary)">Rule 1</text>

            <rect x="150" y="85" width="400" height="30" fill="var(--success)" fill-opacity="0.15" stroke="var(--success)" stroke-width="1.5"/>
            <text x="360" y="105" font-size="12" font-weight="600" fill="var(--text-primary)">Rule 2: matches here, evaluation stops</text>

            <rect x="150" y="120" width="400" height="30" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" opacity="0.4"/>
            <text x="360" y="140" font-size="12" fill="var(--text-secondary)" opacity="0.7">Rule 3: never reached</text>

            <rect x="150" y="155" width="400" height="30" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" opacity="0.4"/>
            <text x="360" y="175" font-size="12" fill="var(--text-secondary)" opacity="0.7">Rule 4: never reached</text>
        </svg>
    </div>

    <p>A shadow rule is a rule that can never trigger because an earlier rule in the list already matches all of the traffic it was written for. The shadowed rule still exists in the configuration, but it has no real effect at all.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The False Sense of Security</h4>
        <p>Shadow rules are dangerous precisely because they look like protection. An administrator sees a specific deny rule in the list and assumes it is working, without realizing a broader rule above it already made the decision for that traffic.</p>
    </div>
</div>
HTML;

// TASK 5: Overly Permissive ACLs
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When a Rule Grants Too Much</h2>

    <p>An overly permissive rule grants far more access than the situation actually requires. The most extreme version is an ANY source, ANY destination, ANY port allow rule, but the pattern shows up in smaller ways too: an entire subnet allowed out on all ports, or a service opened to the whole internet when only a handful of partner IPs actually need it.</p>

    <p>These rules act like a master key that opens every door in a building when only one specific door needed to be unlocked. If that key is misused or an account behind it is compromised, the attacker inherits all of that unnecessary access at once.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Overly Permissive Rule</th>
                <th>Risk</th>
                <th>Tightened Alternative</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ALLOW 10.10.20.0/24 to ANY on ANY port</td>
                <td>Any host on the subnet can reach anywhere on any service, enabling lateral movement and data exfiltration.</td>
                <td>ALLOW specific host to specific destination on the required port only.</td>
            </tr>
            <tr>
                <td>ALLOW ANY to internal web app on port 22</td>
                <td>SSH exposed to the entire internet invites brute force and unauthorized administrative access.</td>
                <td>ALLOW only the management jump host IP to port 22.</td>
            </tr>
            <tr>
                <td>ALLOW ANY to database subnet on ANY port</td>
                <td>Database services become reachable from anywhere, bypassing intended network segmentation.</td>
                <td>ALLOW only the application server IPs to the specific database port.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Temporary Rules That Never Leave</h4>
        <p>A broad rule added under time pressure to "just get something working" is rarely revisited once the immediate problem is solved. Months later it is still there, now treated as a permanent fixture nobody wants to touch. This is one of the most common ways lateral movement becomes possible after an initial compromise.</p>
    </div>
</div>
HTML;

// TASK 6: Firewall Change Management
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Keeping the Rule Base Under Control</h2>

    <p>Rule base decay is not caused by any single bad rule. It happens gradually, one unreviewed change at a time. A firewall change management process exists to make sure every new rule is requested, reviewed, tested, and documented before it goes live, the same way a building requires a permit before anyone alters a structural wall.</p>

    <p>A mature process also includes periodic rule audits, where existing rules are reviewed to confirm they are still needed, still correctly scoped, and still owned by someone accountable for them.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Stage</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Change request</td>
                <td>The requester documents what access is needed and the business justification for it.</td>
            </tr>
            <tr>
                <td>Review and approval</td>
                <td>A second party evaluates whether the request follows least privilege before it is approved.</td>
            </tr>
            <tr>
                <td>Testing</td>
                <td>The change is validated in a non production environment where possible to confirm it behaves as intended.</td>
            </tr>
            <tr>
                <td>Documentation</td>
                <td>The rule is tagged with an owner, justification, and review or expiration date.</td>
            </tr>
            <tr>
                <td>Rollback plan</td>
                <td>A clear path exists to reverse the change quickly if it causes unexpected issues.</td>
            </tr>
            <tr>
                <td>Periodic rule audit</td>
                <td>Existing rules are reviewed on a schedule to remove ones that are no longer needed or accurate.</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Why This Matters</h4>
        <p>A firewall with a disciplined change management process stays lean and auditable for years. Without one, even a well designed rule base slowly accumulates shadow rules and overly permissive exceptions until nobody can confidently explain what it actually does.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have been handed the rule base for a corporate firewall protecting a public web server and a finance subnet. Somewhere in this rule base, one rule grants far more access than it should, and a second rule has been silently rendered useless by the rules above it.</p>

    <p>Use the packet tracer to see exactly which rule matches different sample connections, then mark the two problem rules with the correct issue type to complete the audit.</p>

    <div class="practical-launch-wrapper">
        <a href="firewall-architecture-rule-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Rule Base Audit</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Firewall architecture and rule engineering come down to one connected discipline. Stateful and next generation inspection determine what a firewall can see, rule design and ordering determine what it actually does with that visibility, and change management determines whether that behavior stays correct over time. None of these pieces protects a network on its own.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Stateful inspection tracks connection state; NGFW adds application layer visibility on top of it.</li>
        <li>Rule bases should follow least privilege, default deny, and clear documentation from the start.</li>
        <li>Firewalls evaluate rules in order and stop at the first match, which is how shadow rules occur.</li>
        <li>Overly permissive rules act like a master key and are a common path for lateral movement.</li>
        <li>A formal change management process, including periodic audits, is what keeps a rule base clean over time.</li>
    </ul>
</div>
HTML;

// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
