<?php
// ============================================================
// security-engineering-principles.php — ROOM DATA FILE
// Topic: Security Engineering Principles
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'security-engineering-principles',
    'title'           => 'Security Engineering Principles',
    'description'     => 'Learn the core design principles that separate security engineering from security operations and administration.',
    'icon'            => 'fas fa-drafting-compass',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of security operations'],
    'learning_objectives' => [
        'Distinguish security engineering as a design discipline from security operations and administration',
        'Explain defence in depth and why layered controls compensate for individual failures',
        'Apply the principle of least privilege to scope access appropriately',
        'Describe fail-secure design and why systems should default to a safe state on failure',
        'Explain separation of duties and how dual control prevents fraud and error',
        'Explain economy of mechanism and why simplicity improves security and auditability',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/security-engineering-principles-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Defence in Depth'],
    ['id' => 'task3', 'title' => 'Least Privilege'],
    ['id' => 'task4', 'title' => 'Fail-Secure Design'],
    ['id' => 'task5', 'title' => 'Separation of Duties'],
    ['id' => 'task6', 'title' => 'Economy of Mechanism'],
    ['id' => 'task7', 'title' => 'Access Control Lab'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'security_engineering_principles_progress',
    'instagram_takeaways'  => [
        '✓ Defence in depth: layered controls that compensate for each other',
        '✓ Least privilege: scoping access to limit blast radius',
        '✓ Fail-secure design: defaulting to safe, not open, on failure',
        '✓ Separation of duties and economy of mechanism',
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
        ['id' => 'q1', 'text' => 'What is the term for using multiple layered security controls instead of relying on one?'],
        ['id' => 'q2', 'text' => 'What term describes a single control whose failure compromises the whole system?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What principle states that users should only have the minimum access needed to perform their role?'],
        ['id' => 'q4', 'text' => 'What term describes the scope of potential damage if a privileged account is compromised?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What term describes a system that defaults to a safe, locked-down state when it fails?'],
        ['id' => 'q6', 'text' => 'What is the opposite behavior called, where a system defaults to an accessible state on failure?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What principle requires more than one person to complete a sensitive process?'],
        ['id' => 'q8', 'text' => 'What is the term for a process requiring two separate individuals to approve an action?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What principle states that simpler systems are easier to secure and audit?'],
        ['id' => 'q10', 'text' => 'What term describes the total set of points where an attacker could try to enter a system?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Access Control Redesign Lab.'],
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
    <p>Security engineering is the discipline of designing systems that resist failure, misuse, and attack by default, rather than reacting to incidents after they happen. It differs from security operations, which monitors and responds to live systems, and from security administration, which configures and maintains them day to day. Engineering happens earlier, at the point where architectural decisions get made, and those decisions determine how much operations and administration teams have to compensate for later.</p>

    <p>By the end of this room you will be able to recognize five core principles engineers rely on when designing secure systems: defence in depth, least privilege, fail-secure design, separation of duties, and economy of mechanism. A hands-on lab is included where you will apply all five principles to redesign a flawed system architecture.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Distinguish security engineering as a design discipline from security operations and administration.</li>
        <li>Explain defence in depth and why layered controls compensate for individual failures.</li>
        <li>Apply the principle of least privilege to scope access appropriately.</li>
        <li>Describe fail-secure design and why systems should default to a safe state on failure.</li>
        <li>Explain separation of duties and how dual control prevents fraud and error.</li>
        <li>Explain economy of mechanism and why simplicity improves security and auditability.</li>
    </ul>
</div>
HTML;

// TASK 2: Defence in Depth
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>No Single Control Should Carry the Whole Burden</h2>

    <p>Defence in depth means layering several independent security controls so that if one fails or is bypassed, another still stands between an attacker and the target system. No individual control, whether it is a firewall, an antivirus tool, or a locked door, should be trusted as the only line of defence.</p>

    <p>The value does not come from adding more tools for their own sake. Each layer should fail in a different way, so a weakness in one layer does not automatically expose the next. A firewall might miss a crafted packet, but endpoint monitoring on the target machine can still catch the resulting malicious process.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Common Misconception</h4>
        <p>Defence in depth is not about buying more security products. Adding several tools that all fail the same way under the same conditions provides no real additional protection. The value comes from controls with different failure modes.</p>
    </div>

    <!-- SVG: Layered control flow
         Teaching purpose: show the learner that an attacker must pass through independent
         layers in sequence, which they would otherwise misunderstand as one strong
         perimeter control being enough on its own. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Attacker passing through three layered controls">
            <text x="20" y="25" font-size="12" font-weight="600" fill="var(--text-secondary)">Attacker</text>
            <text x="670" y="25" font-size="12" font-weight="600" fill="var(--text-secondary)">Protected System</text>

            <rect x="10"  y="45" width="190" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="295" y="45" width="190" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="580" y="45" width="190" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <line x1="200" y1="85" x2="290" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrdd)"/>
            <line x1="485" y1="85" x2="575" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrdd)"/>
            <defs>
                <marker id="arrdd" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <text x="105" y="80" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Perimeter Firewall</text>
            <text x="105" y="100" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Blocks known bad traffic</text>
            <text x="390" y="80" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Network Monitoring</text>
            <text x="390" y="100" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Flags unusual activity</text>
            <text x="675" y="80" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Endpoint Protection</text>
            <text x="675" y="100" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Stops malicious processes</text>
        </svg>
    </div>

    <p>In one real incident, an attacker crafted a packet that slipped past a perimeter firewall. The intrusion did not succeed, because endpoint detection software on the target server flagged the resulting process and isolated the machine before any data was accessed. The firewall failed. The layer behind it did not.</p>
</div>
HTML;

// TASK 3: Least Privilege
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Access Scoped to the Job, Not the Person</h2>

    <p>Least privilege means every account, process, or service receives only the access it needs to perform its function, nothing more. A payroll application does not need access to the customer database, and an intern account does not need administrative rights across the whole network.</p>

    <p>When access exceeds what a role requires, the risk of any single compromised account grows. Security engineers call the potential damage from one compromised identity its <strong>blast radius</strong>. Scoping access tightly keeps that radius small.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Setup</th>
                <th>Access Scope</th>
                <th>Risk if Compromised</th>
                <th>Audit Clarity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Over-privileged account</td>
                <td>Full access to all systems</td>
                <td>Entire environment exposed</td>
                <td>Difficult, unclear which access was actually used</td>
            </tr>
            <tr>
                <td>Least-privilege setup</td>
                <td>Access scoped to role</td>
                <td>Limited to that role's own systems</td>
                <td>Clear, each account's activity maps to a defined purpose</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Blast radius comparison
         Teaching purpose: show the learner that fewer accounts with broad access carries
         more risk than more accounts with narrow access, which they would otherwise
         misunderstand as "fewer accounts equals better security." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="One over-privileged account compared to three scoped accounts">
            <text x="150" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Over-privileged</text>
            <text x="630" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Least Privilege</text>

            <rect x="80" y="40" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="150" y="70" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Admin Account</text>

            <rect x="20" y="150" width="90" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="65" y="177" text-anchor="middle" font-size="10" fill="var(--text-secondary)">HR System</text>
            <rect x="125" y="150" width="90" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="170" y="177" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Finance DB</text>
            <rect x="230" y="150" width="90" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="275" y="177" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Customer DB</text>

            <line x1="120" y1="90" x2="65" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="150" y1="90" x2="170" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="180" y1="90" x2="275" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <rect x="490" y="40" width="90" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="535" y="70" text-anchor="middle" font-size="10" font-weight="600" fill="var(--text-primary)">HR Account</text>
            <rect x="595" y="40" width="90" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="640" y="70" text-anchor="middle" font-size="9" font-weight="600" fill="var(--text-primary)">Finance Account</text>
            <rect x="700" y="40" width="90" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="745" y="70" text-anchor="middle" font-size="9" font-weight="600" fill="var(--text-primary)">Marketing Account</text>

            <rect x="490" y="150" width="90" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="535" y="177" text-anchor="middle" font-size="10" fill="var(--text-secondary)">HR System</text>
            <rect x="595" y="150" width="90" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="640" y="177" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Finance DB</text>
            <rect x="700" y="150" width="90" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="745" y="177" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Customer DB</text>

            <line x1="535" y1="90" x2="535" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="640" y1="90" x2="640" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="745" y1="90" x2="745" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>

    <p>A marketing account at one company was compromised through a phishing email. Because that account had been granted administrative rights to the customer database years earlier for an unrelated project, the attacker was able to reach financial records the marketing team never needed to touch.</p>
</div>
HTML;

// TASK 4: Fail-Secure Design
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Defaulting to Safe When Things Break</h2>

    <p>Fail-secure design means a system moves to its safest state when it fails, rather than its most permissive one. A bank vault that stays locked during a power outage is fail-secure. A vault that swings open the moment power is lost is fail-open, and that default can be dangerous even though the system is technically still "working."</p>

    <p>The same choice applies to firewalls, authentication systems, and physical access controls. When a firewall crashes, should traffic be blocked by default, or allowed through? A fail-secure firewall blocks. A fail-open firewall waves everything past, including the traffic it was built to stop.</p>

    <div class="success-box">
        <h4><i class="fas fa-lock"></i> Applied Example</h4>
        <p>Many firewalls are configured with a default deny rule: any traffic not explicitly permitted is blocked. If the rule set fails to load correctly, the firewall denies everything rather than allowing everything, keeping the network protected until an engineer intervenes.</p>
    </div>

    <!-- SVG: Fail-secure vs fail-open gate
         Teaching purpose: show the learner that a gate's behavior during failure matters
         just as much as its behavior during normal operation, which they would otherwise
         misunderstand as both being equally safe as long as the system still functions. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Fail-secure gate compared to fail-open gate during power loss">
            <text x="180" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Fail-Secure Gate</text>
            <text x="590" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Fail-Open Gate</text>

            <rect x="80" y="40" width="200" height="120" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="160" y="70" width="40" height="60" rx="4" fill="var(--text-secondary)"/>
            <text x="180" y="180" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Power lost, gate stays locked</text>

            <rect x="490" y="40" width="200" height="120" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="500" y="70" width="15" height="60" rx="3" fill="var(--text-secondary)"/>
            <rect x="665" y="70" width="15" height="60" rx="3" fill="var(--text-secondary)"/>
            <text x="590" y="180" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Power lost, gate swings open</text>
        </svg>
    </div>
</div>
HTML;

// TASK 5: Separation of Duties
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>No Single Person Completes a Sensitive Process Alone</h2>

    <p>Separation of duties splits a sensitive process into steps that require more than one person to complete. If one employee can both create a vendor record and approve payment to that vendor, nothing stops them from creating a fake vendor and paying themselves.</p>

    <p>This is not about distrust of any individual employee. It is about removing the opportunity for unilateral abuse or an unnoticed mistake by requiring a second, independent check before a sensitive action completes.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Workflow</th>
                <th>Risk of Fraud</th>
                <th>Risk of Error</th>
                <th>Speed</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Single approver</td>
                <td>High, one person controls the entire process</td>
                <td>Higher, no second check exists</td>
                <td>Fast</td>
            </tr>
            <tr>
                <td>Dual approver</td>
                <td>Low, requires collusion between two people</td>
                <td>Lower, errors are more likely to be caught</td>
                <td>Slower</td>
            </tr>
        </tbody>
    </table>

    <p>At one company, an employee with authority to both add new vendors and approve their payments created a fictitious vendor and routed several payments to a personal account before the scheme was discovered. Requiring a second approver for new vendor payments would have stopped it on the first attempt.</p>
</div>
HTML;

// TASK 6: Economy of Mechanism
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Simplicity Is a Security Property</h2>

    <p>Economy of mechanism means keeping a system's design as simple as its requirements allow. Complexity is not just harder to use, it is harder to secure, because every additional rule, exception, and interaction is another place a mistake can hide.</p>

    <p>A house with three doors is easier to secure than one with fifteen. Each additional door is another lock to maintain, another hinge to inspect, and another chance for one of them to be left unlocked by mistake. Access control systems work the same way.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Common Misconception</h4>
        <p>More rules do not mean more security. A tangled set of overlapping, contradictory access rules often hides misconfigurations rather than preventing them, because no one can fully reason about what the combined rule set actually permits.</p>
    </div>

    <!-- SVG: Tangled rules vs simplified policy
         Teaching purpose: show the learner that an overlapping, contradictory rule set is
         harder to reason about than a clean minimal one, which they would otherwise
         misunderstand as "more rules equals more security." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Tangled access rules compared to a simplified access policy">
            <text x="180" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Tangled Rule Set</text>
            <text x="590" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Simplified Policy</text>

            <rect x="60" y="40" width="240" height="130" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="80" y1="60" x2="280" y2="150" stroke="var(--text-secondary)" stroke-width="1.2"/>
            <line x1="280" y1="60" x2="80" y2="150" stroke="var(--text-secondary)" stroke-width="1.2"/>
            <line x1="80" y1="105" x2="280" y2="105" stroke="var(--text-secondary)" stroke-width="1.2"/>
            <line x1="180" y1="55" x2="180" y2="160" stroke="var(--text-secondary)" stroke-width="1.2"/>
            <text x="180" y="185" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Overlapping, contradictory rules</text>

            <rect x="470" y="40" width="240" height="130" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="500" y="65" width="180" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <text x="590" y="85" text-anchor="middle" font-size="10" fill="var(--text-primary)">Allow: Role-based access</text>
            <rect x="500" y="105" width="180" height="30" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <text x="590" y="125" text-anchor="middle" font-size="10" fill="var(--text-primary)">Deny: Everything else</text>
            <text x="590" y="185" text-anchor="middle" font-size="11" fill="var(--text-secondary)">One clear, auditable rule set</text>
        </svg>
    </div>
</div>
HTML;

// TASK 7: PRACTICAL — Access Control Redesign Lab
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>MegaCorp's internal portal was built for convenience, not security, and it shows. A single admin account can reach every system, the network has no internal boundaries, and the access rules are so tangled that nobody can explain what they actually permit.</p>

    <p>Your job is to redesign the architecture by applying the five principles from this room. Drag each control onto the weakness it fixes. The system is hardened once all five are correctly placed.</p>

    <div class="practical-launch-wrapper">
        <a href="security-engineering-principles-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Access Control Redesign Lab</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Security engineering is what happens before an incident, not after one. Defence in depth, least privilege, fail-secure design, separation of duties, and economy of mechanism are not a checklist to satisfy an auditor. They are the design decisions that determine how much damage a single mistake, a single compromised account, or a single failed component can cause.</p>

    <p>These five principles reinforce each other. A system built with all five in mind fails safely, limits blast radius by default, and stays simple enough for engineers to actually reason about.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Defence in depth layers independent controls so no single failure exposes the whole system.</li>
        <li>Least privilege scopes access to what a role actually needs, limiting blast radius.</li>
        <li>Fail-secure design ensures systems default to a safe state, not an open one, when they fail.</li>
        <li>Separation of duties prevents any single person from completing a sensitive process alone.</li>
        <li>Economy of mechanism treats simplicity itself as a security property.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
