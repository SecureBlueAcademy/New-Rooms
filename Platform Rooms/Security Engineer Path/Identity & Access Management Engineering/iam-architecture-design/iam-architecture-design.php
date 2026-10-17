<?php
// ============================================================
// iam-architecture-design.php : ROOM DATA FILE
// Topic: IAM Architecture & Design
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'iam-architecture-design',
    'title'           => 'IAM Architecture & Design',
    'description'     => 'Learn the core components of enterprise IAM architecture and how to choose between RBAC, ABAC, and PBAC.',
    'icon'            => 'fas fa-sitemap',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of authentication and authorization'],
    'learning_objectives' => [
        'Identify the four core components of an enterprise IAM architecture',
        'Explain how identity stores, authentication services, and authorization engines interact',
        'Differentiate RBAC, ABAC, and PBAC and know when each is appropriate',
        'Apply the correct access control model to a real access request scenario',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/iam-architecture-design-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'IAM Architecture Components'],
    ['id' => 'task3', 'title' => 'Role Based Access Control'],
    ['id' => 'task4', 'title' => 'Attribute Based Access Control'],
    ['id' => 'task5', 'title' => 'Policy Based Access Control'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'iam_architecture_design_progress',
    'instagram_takeaways'  => [
        '✓ The four components of enterprise IAM architecture',
        '✓ Role based access control and where it fits',
        '✓ Attribute based access control for dynamic decisions',
        '✓ Policy based access control for compliance driven access',
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
        ['id' => 'q1', 'text' => 'What component of an IAM system serves as the authoritative source of identity records?'],
        ['id' => 'q2', 'text' => 'Which IAM component evaluates whether an authenticated user is allowed to access a resource?'],
        ['id' => 'q3', 'text' => 'What term describes the ongoing process of provisioning, modifying, and deprovisioning user accounts?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What does RBAC stand for?'],
        ['id' => 'q5', 'text' => 'What is assigned to a role that determines what a user with that role can do?'],
        ['id' => 'q6', 'text' => 'What term describes the problem of having too many overlapping or redundant roles in a large organization?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What does ABAC stand for?'],
        ['id' => 'q8', 'text' => 'What type of attribute considers factors like time of day or network location in an access decision?'],
    ],
    'task5' => [
        ['id' => 'q9', 'text' => 'What does PBAC stand for?'],
        ['id' => 'q10', 'text' => 'What type of organizational requirement most commonly drives adoption of PBAC?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'Enter the flag revealed once all access requests are correctly resolved.'],
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
    <p>Every enterprise, no matter how small, has to answer one question over and over: who gets to access what, and why. IAM architecture is the deliberate design behind that decision, the identity stores, authentication services, authorization engines, and lifecycle workflows that turn access control into a repeatable system. Without a clear architecture, permissions sprawl, audits become guesswork, and every new hire or departing employee becomes a manual, error prone task.</p>

    <p>By the end of this room you will be able to describe how the core components of an IAM system fit together, and confidently choose between role-based, attribute-based, and policy-based access control depending on the situation in front of you. A hands on practical is included, where you will configure real access decisions for a fictional company.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Identify the four core components of an enterprise IAM architecture.</li>
        <li>Explain how identity stores, authentication services, and authorization engines interact.</li>
        <li>Differentiate RBAC, ABAC, and PBAC and know when each is appropriate.</li>
        <li>Apply the correct access control model to a real access request scenario.</li>
    </ul>
</div>
HTML;

// TASK 2: IAM Architecture Components
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>The Building Blocks of an IAM System</h2>

    <p>An enterprise identity and access management system is not one tool, it is a pipeline of four connected components working together. Each stage depends on the one before it, and a weakness in any single stage weakens the whole system.</p>

    <p>Think of an airport. Your passport record sits in a database long before you arrive, this is the identity store. At the gate, an officer checks that you are who your passport says you are, this is authentication. A separate check then determines whether your boarding pass lets you onto this specific flight, this is authorization. Finally, your ticket was issued when you booked and is invalidated the moment your journey ends, this is lifecycle management.</p>

    <h3>The Four Components</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Component</th>
                <th>Core Function</th>
                <th>Example Technology</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Identity Store</strong></td>
                <td>Stores authoritative identity records for every user and device.</td>
                <td>LDAP directory, Active Directory</td>
            </tr>
            <tr>
                <td><strong>Authentication Service</strong></td>
                <td>Verifies that a user is who they claim to be.</td>
                <td>Single sign-on service, multi-factor authentication provider</td>
            </tr>
            <tr>
                <td><strong>Authorization Engine</strong></td>
                <td>Decides what an authenticated identity is allowed to do.</td>
                <td>Policy decision point, access control list engine</td>
            </tr>
            <tr>
                <td><strong>Lifecycle Management</strong></td>
                <td>Provisions, updates, and removes access as roles change over time.</td>
                <td>Identity governance and administration platform</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: IAM pipeline diagram
         Teaching purpose: show the learner that the four components form a
         connected sequence, which they would otherwise misunderstand as four
         unrelated, independently operating systems. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 800 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="IAM architecture pipeline">
            <!-- Stage boxes -->
            <rect x="10"  y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="215" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="420" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="625" y="30" width="165" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="180" y1="70" x2="210" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="385" y1="70" x2="415" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="590" y1="70" x2="620" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="95"  y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Identity Store</text>
            <text x="95"  y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Who exists?</text>
            <text x="300" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Authentication</text>
            <text x="300" y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Who are you?</text>
            <text x="505" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Authorization</text>
            <text x="505" y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">What can you do?</text>
            <text x="707" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Lifecycle Mgmt</text>
            <text x="707" y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Does access still apply?</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Lifecycle Management Gets Overlooked</h4>
        <p>Orphaned accounts, access left behind after someone changes roles or leaves the company, are one of the most common findings in real security audits. A strong identity store and authorization engine mean little if nobody is removing access that should no longer exist.</p>
    </div>
</div>
HTML;

// TASK 3: Role Based Access Control
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Access Tied to Job Function</h2>

    <p>Role-based access control assigns permissions based on a user's job role rather than to the individual directly. A new hire on the sales team receives the "Sales Rep" role, and that role already carries the exact permissions a sales rep needs. Nobody configures access from scratch for every new person.</p>

    <p>This works well when job functions are stable and access needs are similar across everyone doing the same job. It is easy to audit, since reviewing access means reviewing a small set of roles rather than thousands of individual permission grants.</p>

    <p>Consider a hotel where every housekeeper carries an identical keycard that opens guest rooms on their assigned floor, and every manager carries a keycard that opens the entire building. Nobody hands out a custom keycard per employee, the role determines the access.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> When RBAC Breaks Down</h4>
        <p>Large organizations sometimes create a new role for every small exception, a manager who needs one extra permission, a temporary project team, a regional variation. Over time this produces role explosion, hundreds of near duplicate roles that are harder to audit than the individual permissions they were meant to simplify.</p>
    </div>
</div>
HTML;

// TASK 4: Attribute Based Access Control
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Access Driven by Attributes, Not Just Role</h2>

    <p>Attribute-based access control makes decisions using attributes describing the user, the resource, and the environment, rather than a single fixed role. A contractor might be granted access only during business hours and only from the corporate network, a decision that no static role could express on its own.</p>

    <p>This flexibility comes at a cost. ABAC policies are more complex to write and maintain than a simple role assignment, since a decision can depend on several attributes evaluated together at the moment of the request.</p>

    <p>A nightclub bouncer does not only check whether you hold a ticket. They also check your age, whether it is still within opening hours, and whether your name appears on tonight's guest list. Several attributes get evaluated together before a decision is made.</p>

    <!-- SVG: ABAC attribute categories diagram
         Teaching purpose: show the learner that ABAC combines three distinct
         categories of attributes into one decision, which they would otherwise
         misread as simply "a role with extra conditions attached." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="ABAC attribute categories feeding a policy decision">
            <rect x="10"  y="10"  width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10"  y="90"  width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="10"  y="150" width="180" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="470" y="70"  width="220" height="70" rx="10" fill="var(--surface)" stroke="var(--primary, var(--text-primary))" stroke-width="2"/>
            <text x="100" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">User Attributes</text>
            <text x="100" y="125" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Resource Attributes</text>
            <text x="100" y="177" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Environment Attributes</text>
            <text x="580" y="100" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Policy Decision</text>
            <text x="580" y="120" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Grant or deny</text>
            <line x1="190" y1="40"  x2="465" y2="95"  stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="190" y1="120" x2="465" y2="105" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="190" y1="172" x2="465" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> A Real World Example</h4>
        <p>A contractor granted CRM access only between 9am and 5pm, and only while connected to the corporate network, is a textbook ABAC decision. Time and location are environmental attributes, and neither one is captured by a simple job role.</p>
    </div>
</div>
HTML;

// TASK 5: Policy Based Access Control
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Access Governed by Organizational Policy</h2>

    <p>Policy-based access control applies centrally defined business or compliance rules across an organization, rather than leaving each decision to a role or a single attribute check. A compliance team might mandate that only auditors may access financial reports, and only during an approved audit window, applied uniformly with no individual exceptions.</p>

    <p>PBAC often incorporates roles and attributes underneath its policies, but the defining feature is that the policy itself, not a manager's discretion or a one off configuration, drives the decision.</p>

    <p>Consider a compliance rulebook published by a legal department that applies the same way to every employee regardless of team or manager. Nobody can grant an exception without changing the policy itself.</p>

    <h3>Comparing the Three Models</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Model</th>
                <th>Decision Basis</th>
                <th>Flexibility</th>
                <th>Best Fit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>RBAC</strong></td>
                <td>Job role</td>
                <td>Low</td>
                <td>Stable, well defined job functions</td>
            </tr>
            <tr>
                <td><strong>ABAC</strong></td>
                <td>User, resource, and environment attributes</td>
                <td>High</td>
                <td>Dynamic, contextual access needs</td>
            </tr>
            <tr>
                <td><strong>PBAC</strong></td>
                <td>Centrally defined business or compliance policy</td>
                <td>Medium</td>
                <td>Regulatory and organization wide governance requirements</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Real IAM systems rarely rely on only one model. A company might use RBAC for baseline access, then layer PBAC on top to satisfy a regulatory requirement, with ABAC handling the exceptions that need contextual judgment.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>Meridian Financial has just deployed a new access request queue, and five requests are waiting for a decision. Each request lists the requester, their role, the resource in question, and any relevant context.</p>

    <p>Your job is to select the correct access control model for each request, configure it correctly, and resolve all five before the policy engine can go live.</p>

    <div class="practical-launch-wrapper">
        <a href="iam-architecture-design-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Access Engine</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have now covered the four components that make up an enterprise IAM architecture, along with the three major access control models used to decide who gets access to what. Role-based, attribute-based, and policy-based access control are not competing approaches, they are different tools suited to different situations, and most real IAM systems draw on more than one.</p>

    <p>Being able to recognize which model fits a given scenario, and how identity stores, authentication, authorization, and lifecycle management connect, is one of the most practical skills you can bring into any security or infrastructure role.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Enterprise IAM architecture connects an identity store, authentication service, authorization engine, and lifecycle management.</li>
        <li>RBAC assigns access based on job role and works best for stable, well defined functions.</li>
        <li>ABAC evaluates user, resource, and environmental attributes for dynamic, contextual access.</li>
        <li>PBAC applies centrally defined business or compliance policies across the organization.</li>
        <li>Real world IAM systems often combine multiple models rather than relying on just one.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA. Engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
