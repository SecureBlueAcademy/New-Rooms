<?php
// ============================================================
// cloud-iam-privesc.php - ROOM DATA FILE
// Topic: Cloud IAM & Privilege Escalation Prevention
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'cloud-iam-privesc',
    'title'           => 'Cloud IAM & Privilege Escalation Prevention',
    'description'     => 'Learn how cloud IAM roles, policy attachments, and workload identity can be chained into privilege escalation, and how to design least privilege access that stays usable.',
    'icon'            => 'fas fa-user-shield',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic cloud computing concepts', 'Familiarity with IAM roles and policies'],
    'learning_objectives' => [
        'Explain why cloud IAM is the primary control plane for cloud security',
        'Identify how policy attachment permissions can be chained into privilege escalation',
        'Explain PassRole and AssumeRole abuse patterns',
        'Design cross-account access using trust policies and conditions safely',
        'Distinguish types of workload identity and apply least privilege principles that remain operationally usable',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/cloud-iam-privesc-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Cloud IAM Fundamentals'],
    ['id' => 'task3', 'title' => 'Privilege Escalation via Policy Attachments'],
    ['id' => 'task4', 'title' => 'PassRole and AssumeRole Abuse'],
    ['id' => 'task5', 'title' => 'Cross-Account Access Design'],
    ['id' => 'task6', 'title' => 'Workload Identity and Least Privilege'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'cloud_iam_privesc_progress',
    'instagram_takeaways'  => [
        '✓ IAM is the primary security boundary in the cloud',
        '✓ Policy attachment permissions can be chained into privilege escalation',
        '✓ PassRole and AssumeRole abuse lets identities act through other roles',
        '✓ Least privilege must stay operationally usable',
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
        ['id' => 'q1', 'text' => 'What element of an IAM policy statement defines who is being granted or denied access?'],
        ['id' => 'q2', 'text' => 'What term describes the scope of resources and permissions exposed when a policy is overly permissive?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the general term for gaining higher privileges than originally granted?'],
        ['id' => 'q4', 'text' => 'Which IAM permission allows an identity to attach a policy to a user?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What IAM permission allows a user to assign an IAM role to a service they control?'],
        ['id' => 'q6', 'text' => 'What action allows an identity to take on the permissions of another IAM role?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What condition key is used in a trust policy to prevent the confused deputy problem?'],
        ['id' => 'q8', 'text' => 'What is the name of the security problem where a trusted entity is tricked into misusing its permissions on behalf of an attacker?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What term describes an identity attached to a non-human workload such as a server or function?'],
        ['id' => 'q10', 'text' => 'What AWS mechanism assigns an IAM role to an EC2 instance without storing static credentials on it?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag revealed after correctly refactoring the policy to least privilege.'],
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
    <p>Cloud environments have no physical perimeter to fall back on. There is no locked server room, no badge reader, no network firewall separating the outside world from your data by default. In the cloud, Identity and Access Management is the entire security boundary. Every action a user, service, or workload takes is either allowed or denied by an IAM policy, and nothing else stands in the way.</p>

    <p>This room walks through the unique IAM challenges that show up in cloud environments: how overly permissive roles get created, how seemingly ordinary permissions can be chained into full account takeover, how cross-account access needs to be designed carefully, and how workloads themselves get identity. By the end, you will be able to design least privilege IAM policies that are secure without slowing teams down, and you will practice this directly in a hands-on lab.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why cloud IAM is the primary control plane for cloud security.</li>
        <li>Identify how policy attachment permissions can be chained into privilege escalation.</li>
        <li>Explain PassRole and AssumeRole abuse patterns.</li>
        <li>Design cross-account access using trust policies and conditions safely.</li>
        <li>Distinguish types of workload identity and apply least privilege principles that remain operationally usable.</li>
    </ul>
</div>
HTML;

// TASK 2: Cloud IAM Fundamentals and the Overly Permissive Role Problem
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>IAM Is the Only Wall You Have</h2>

    <p>In an on premises data center, a would be attacker has to get past physical security, network segmentation, and access control lists before reaching sensitive data. In the cloud, all of that collapses into a single question: does the IAM policy allow this action? If the answer is yes, the action happens, regardless of where the request came from.</p>

    <p>Every IAM policy is built from a small set of parts. The <strong>Principal</strong> defines who the policy applies to, the <strong>Action</strong> defines what operations are covered, the <strong>Resource</strong> defines what the action applies to, and an optional <strong>Condition</strong> narrows when the policy applies. Understanding this structure is the foundation for everything else in this room.</p>

    <!-- SVG: IAM policy anatomy
         Teaching purpose: show the learner that a policy has defined structural parts,
         which they would otherwise misread as an unstructured block of JSON. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="IAM policy statement anatomy">
            <rect x="10" y="10" width="740" height="180" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="30" y="35" font-size="13" fill="var(--text-secondary)" font-family="monospace">"Statement": [</text>

            <rect x="50" y="50" width="660" height="30" rx="4" fill="var(--bg-primary, #12182b)" stroke="var(--primary)" stroke-width="1"/>
            <text x="60" y="70" font-size="12" fill="var(--text-primary)" font-family="monospace">"Principal": "arn:aws:iam::111122223333:user/analyst"</text>
            <text x="720" y="70" font-size="11" fill="var(--primary)" text-anchor="start">Who</text>

            <rect x="50" y="90" width="660" height="30" rx="4" fill="var(--bg-primary, #12182b)" stroke="var(--primary)" stroke-width="1"/>
            <text x="60" y="110" font-size="12" fill="var(--text-primary)" font-family="monospace">"Action": "s3:GetObject"</text>
            <text x="720" y="110" font-size="11" fill="var(--primary)" text-anchor="start">What</text>

            <rect x="50" y="120" width="660" height="30" rx="4" fill="var(--bg-primary, #12182b)" stroke="var(--primary)" stroke-width="1"/>
            <text x="60" y="140" font-size="12" fill="var(--text-primary)" font-family="monospace">"Resource": "arn:aws:s3:::reports-input/*"</text>
            <text x="720" y="140" font-size="11" fill="var(--primary)" text-anchor="start">On what</text>

            <rect x="50" y="150" width="660" height="30" rx="4" fill="var(--bg-primary, #12182b)" stroke="var(--primary)" stroke-width="1"/>
            <text x="60" y="170" font-size="12" fill="var(--text-primary)" font-family="monospace">"Condition": { "IpAddress": { "aws:SourceIp": "10.0.0.0/8" } }</text>
            <text x="700" y="170" font-size="11" fill="var(--primary)" text-anchor="start">When</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Misconfigured IAM permissions are consistently cited as one of the leading causes of cloud data breaches. A single wildcard added to unblock a deployment can quietly turn into an open door.</p>
    </div>

    <p>The most common failure pattern is the overly permissive role. Under deadline pressure, an engineer adds a wildcard action or resource to stop getting access denied errors, intending to narrow it later. Later rarely comes. The result is a role with far more reach than the workload actually needs, expanding the <strong>blast radius</strong> if that role or its credentials are ever compromised.</p>
</div>
HTML;

// TASK 3: Privilege Escalation via Policy Attachments
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>When Permissions Grant More Permissions</h2>

    <p><strong>Privilege escalation</strong> in cloud IAM does not always require exploiting a vulnerability. Often it only requires a handful of permissions that let an identity modify its own access, or someone else's. These are sometimes called self escalation permissions, because holding them is functionally equivalent to holding much broader access.</p>

    <p>The danger is that these permissions look administrative in nature but get granted casually, often bundled into a broad "IAM management" role for a team that only needed to manage a few resources.</p>

    <h3>Common Escalation Permissions</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Permission</th>
                <th>What It Allows</th>
                <th>Escalation Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>AttachUserPolicy</strong></td>
                <td>Attach any managed policy to a user</td>
                <td>Attach an admin policy to yourself</td>
            </tr>
            <tr>
                <td><strong>PutUserPolicy</strong></td>
                <td>Add an inline policy to a user</td>
                <td>Inline an admin permission set directly</td>
            </tr>
            <tr>
                <td><strong>CreatePolicyVersion</strong></td>
                <td>Create a new version of an existing managed policy</td>
                <td>Rewrite a policy already attached to you with broader access</td>
            </tr>
            <tr>
                <td><strong>SetDefaultPolicyVersion</strong></td>
                <td>Change which policy version is active</td>
                <td>Roll back to a previously broader version</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: escalation chain
         Teaching purpose: show the learner that escalation can start from limited access,
         which they would otherwise assume requires already having broad permissions. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Privilege escalation chain">
            <rect x="10" y="25" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Low privilege user</text>
            <text x="110" y="73" text-anchor="middle" font-size="11" fill="var(--text-secondary)">has AttachUserPolicy</text>

            <line x1="215" y1="60" x2="290" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <rect x="295" y="25" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="395" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attaches admin policy</text>
            <text x="395" y="73" text-anchor="middle" font-size="11" fill="var(--text-secondary)">to their own account</text>

            <line x1="500" y1="60" x2="575" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <rect x="580" y="25" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="665" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Full admin access</text>
            <text x="665" y="73" text-anchor="middle" font-size="11" fill="var(--text-secondary)">without ever being granted it</text>

            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Audit This First</h4>
        <p>During access reviews, treat any identity holding policy attachment or policy versioning permissions as a potential fast path to full admin, even if their other permissions look limited.</p>
    </div>
</div>
HTML;

// TASK 4: PassRole and AssumeRole Abuse Chains
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Handing Off Permissions Through a Middleman</h2>

    <p>Not every escalation path involves modifying your own permissions directly. Some work through indirection, by handing your access to something else and letting it act on your behalf. This is exactly what <strong>PassRole</strong> abuse looks like.</p>

    <p>Imagine a guard whose job is to check a note before letting someone into a secure area. If the guard trusts any note handed over without verifying who wrote it, anyone can walk in by simply presenting the right piece of paper. PassRole works similarly: a user with the permission can pass an IAM role to a service they control, such as an EC2 instance or a Lambda function, and that service then operates with whatever permissions the role holds.</p>

    <!-- SVG: PassRole chain
         Teaching purpose: show the learner the indirection step, that the user never
         directly holds the escalated permission, which is otherwise missed entirely. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="PassRole abuse chain">
            <rect x="10" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">User</text>
            <text x="95" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">has iam:PassRole</text>

            <line x1="185" y1="70" x2="255" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>

            <rect x="260" y="35" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="360" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">EC2 instance</text>
            <text x="360" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">launched with an admin role</text>

            <line x1="465" y1="70" x2="535" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>

            <rect x="540" y="35" width="210" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="645" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Instance assumes role</text>
            <text x="645" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">acts with admin permissions</text>

            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <p>A related pattern is <strong>AssumeRole</strong> abuse. If a role's trust policy allows any identity to assume it, or the condition checks are missing, an attacker who compromises even a low privilege identity can assume their way into a far more powerful role.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>PassRole and AssumeRole abuse are among the most frequently reported findings in real world cloud penetration tests, precisely because the indirection makes them easy to overlook during manual review.</p>
    </div>
</div>
HTML;

// TASK 5: Cross-Account Access Design
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Trust Between Accounts Is Still Trust</h2>

    <p>Organizations often split workloads across multiple cloud accounts for isolation, but workloads still need to talk to each other. This is handled through cross account roles, where one account's role trusts another account to assume it.</p>

    <p>A trust policy defines exactly who can assume a role. If that trust policy is written too loosely, for example trusting an entire account rather than a specific role within it, any identity in the trusting account inherits the ability to assume the role, whether that was intended or not.</p>

    <h3>Same-Account vs Cross-Account Roles</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th></th>
                <th>Trust Principal</th>
                <th>Typical Use</th>
                <th>Key Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Same-account role</strong></td>
                <td>Users or services in the same account</td>
                <td>Internal service to service access</td>
                <td>Overly broad internal permissions</td>
            </tr>
            <tr>
                <td><strong>Cross-account role</strong></td>
                <td>An entire external account or specific role</td>
                <td>Third party integrations, multi-account architectures</td>
                <td>Confused deputy if trust is too broad</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: cross-account trust
         Teaching purpose: show the learner how trust flows between accounts,
         which is otherwise treated as an opaque black box. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Cross account trust relationship">
            <rect x="20" y="20" width="220" height="110" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="130" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Account A</text>
            <text x="130" y="65" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Vendor account</text>
            <text x="130" y="100" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Requests to assume role</text>

            <line x1="245" y1="75" x2="315" y2="75" stroke="var(--success)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <text x="280" y="65" text-anchor="middle" font-size="10" fill="var(--success)">with ExternalId</text>

            <rect x="320" y="20" width="220" height="110" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="430" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Account B</text>
            <text x="430" y="65" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Trust policy scoped</text>
            <text x="430" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">to specific role + condition</text>

            <line x1="545" y1="75" x2="615" y2="75" stroke="var(--error, #ff5c5c)" stroke-width="1.5" stroke-dasharray="4,3" marker-end="url(#arr4)"/>
            <text x="580" y="65" text-anchor="middle" font-size="10" fill="var(--error, #ff5c5c)">no condition</text>

            <rect x="620" y="20" width="130" height="110" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="685" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Account C</text>
            <text x="685" y="65" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Unintended</text>
            <text x="685" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">access path</text>

            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The Confused Deputy Problem</h4>
        <p>A <strong>confused deputy</strong> occurs when a trusted entity is manipulated into misusing its own legitimate permissions on behalf of an attacker. Adding an <strong>ExternalId</strong> condition to a cross account trust policy ensures the role can only be assumed by someone who also knows a shared secret value, closing this gap.</p>
    </div>
</div>
HTML;

// TASK 6: Workload Identity and Engineering Usable Least Privilege
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Machines Need Identity Too</h2>

    <p>Not every identity in a cloud account belongs to a human. Servers, containers, and functions all need to authenticate to call other services, and cloud providers give this a name: <strong>workload identity</strong>. Instead of embedding long lived credentials inside application code, the workload is granted an identity that automatically provides short lived, rotated credentials.</p>

    <h3>Workload Identity Mechanisms</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Cloud</th>
                <th>Workload Identity Mechanism</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>AWS</td>
                <td>Instance profile</td>
                <td>An IAM role attached to an EC2 instance</td>
            </tr>
            <tr>
                <td>Google Cloud</td>
                <td>Service account</td>
                <td>A dedicated identity attached to a Compute Engine VM</td>
            </tr>
            <tr>
                <td>Azure</td>
                <td>Managed identity</td>
                <td>An identity automatically managed for an Azure resource</td>
            </tr>
        </tbody>
    </table>

    <p>Granting the right amount of access to these identities is where least privilege becomes an engineering discipline rather than a one time checklist. The goal is a policy narrow enough to limit damage if compromised, but complete enough that the workload never breaks in production.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> A Practical Least Privilege Checklist</h4>
        <p>Scope resources to specific ARNs instead of wildcards. Add conditions where possible, such as source IP or time of day. Iterate using real access logs to see which permissions are actually used. Apply permission boundaries as a hard ceiling that no policy attached later can exceed.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>A data processing service in your account currently has a policy that grants it unrestricted S3 access across the entire account. It only needs to read incoming report files from one bucket and write processed results to another.</p>

    <p>Open the Least Privilege Refactor lab, review what the workload actually requires, and rebuild its policy so that it can do its job and nothing more. Submit your policy to see whether it is too broad, too narrow, or correctly scoped.</p>

    <div class="practical-launch-wrapper">
        <a href="cloud-iam-privesc-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Least Privilege Refactor</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Cloud IAM is not just another security control, it is the control. You have seen how overly permissive roles form under pressure, how ordinary looking permissions can be chained into full privilege escalation, how PassRole and AssumeRole let identities act through other roles, and how workload identity requires the same careful scoping as human access.</p>

    <p>None of this is about locking everything down until nothing works. It is about designing access that matches what a workload or person actually needs, and continuously verifying that it stays that way as systems evolve.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>IAM policies are the primary security boundary in cloud environments.</li>
        <li>Certain policy attachment permissions can be chained into privilege escalation.</li>
        <li>PassRole and AssumeRole abuse let identities act through intermediary services or roles.</li>
        <li>Cross-account trust policies need ExternalId and conditions to prevent confused deputy attacks.</li>
        <li>Workload identity mechanisms each require deliberate least privilege scoping.</li>
        <li>Least privilege must remain operationally usable, not just theoretically minimal.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA - engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
