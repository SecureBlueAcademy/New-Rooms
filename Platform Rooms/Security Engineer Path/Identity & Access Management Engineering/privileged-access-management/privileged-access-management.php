<?php
// File: privileged-access-management.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'privileged-access-management',
    'title'           => 'Privileged Access Management (PAM)',
    'description'     => 'Learn how to engineer a PAM solution that vaults, provisions, monitors, and rotates access for administrative accounts.',
    'icon'            => 'fas fa-user-lock',
    'banner'          => '../../assets/banner-pam.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic Active Directory concepts', 'Basic IAM and access control knowledge'],
    'learning_objectives' => [
        'Explain why privileged accounts carry disproportionate risk compared to standard accounts',
        'Describe how credential vaulting protects and controls access to privileged accounts',
        'Explain the principle of Just-in-Time access and Zero Standing Privilege',
        'Describe how session recording supports monitoring and forensic investigation',
        'Explain automated password rotation and its role in reducing standing risk',
        'Describe tiered PAM architecture and the purpose of break-glass procedures',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/privileged-access-management-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is PAM?'],
    ['id' => 'task3', 'title' => 'Privileged Account Vaulting'],
    ['id' => 'task4', 'title' => 'Just-in-Time Access Provisioning'],
    ['id' => 'task5', 'title' => 'Session Recording and Monitoring'],
    ['id' => 'task6', 'title' => 'Password Rotation Automation'],
    ['id' => 'task7', 'title' => 'Tiered Architecture and Break-Glass'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'privileged_access_management_progress',
    'instagram_takeaways'  => [
        '✓ Privileged accounts carry outsized risk and need dedicated controls',
        '✓ Vaulting removes standing knowledge of privileged passwords',
        '✓ Just-in-Time access replaces standing privilege with time limited grants',
        '✓ Session recording and automated rotation close the loop on accountability',
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
        ['id' => 'q1', 'text' => 'What does PAM stand for in the context of access control? (three words)'],
        ['id' => 'q2', 'text' => 'What type of account is most commonly targeted by attackers seeking to move across a network?'],
        ['id' => 'q3', 'text' => 'What term describes an attacker moving between systems using compromised credentials?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the term for the secure storage system that holds privileged credentials?'],
        ['id' => 'q5', 'text' => 'What is the term for automatically changing a credential\'s password after use?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What does JIT stand for in access provisioning?'],
        ['id' => 'q7', 'text' => 'What principle states that no account should hold standing privileged access by default?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What is the term for the real time recording of a privileged user\'s session?'],
        ['id' => 'q9', 'text' => 'Which AAA component does session recording and monitoring map to?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What type of account is frequently excluded from rotation policies, creating long term risk?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What is the name of the Active Directory tier containing Domain Controllers and Domain Admins?'],
        ['id' => 'q12', 'text' => 'What is the term for the emergency access procedure used when standard admin access is unavailable?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the Vault Console.'],
    ],
    'task9' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every network has a small set of accounts that can do almost anything: create users, install software, access every file share, or reconfigure a firewall. These are privileged accounts, and they are the single most valuable target for any attacker, because compromising one is often the difference between a minor incident and a full network takeover.</p>

    <p>This room covers Privileged Access Management, the discipline of controlling, monitoring, and rotating access to those powerful accounts. You will learn how vaulting, Just-in-Time provisioning, session recording, and automated rotation work together, and how a tiered architecture keeps the most powerful credentials from ever touching the least trusted systems. A hands-on vault console practical is included to reinforce these ideas.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why privileged accounts carry disproportionate risk.</li>
        <li>Describe how credential vaulting protects privileged accounts.</li>
        <li>Explain Just-in-Time access and Zero Standing Privilege.</li>
        <li>Describe how session recording supports accountability.</li>
        <li>Explain automated password rotation.</li>
        <li>Describe tiered PAM architecture and break-glass procedures.</li>
    </ul>
</div>
HTML;

// TASK 2: What is PAM?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Why Privileged Accounts Are High Risk</h2>

    <p><strong>Privileged Access Management</strong> is the set of tools and processes used to control, monitor, and secure accounts that hold elevated permissions, such as Domain Admins, root accounts, and service accounts with broad system access.</p>

    <p>A standard user account is like a key to a single room in a building. A privileged account is closer to a master key that opens every door on every floor. If a standard account is compromised, the damage is usually contained. If a privileged account is compromised, an attacker can often move freely across the entire environment, a pattern known as lateral movement.</p>

    <h3>Standard vs Privileged Accounts</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Standard Account</th>
                <th>Privileged Account</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Scope of access</td>
                <td>Own files and applications</td>
                <td>Multiple systems, users, and configurations</td>
            </tr>
            <tr>
                <td>Risk if compromised</td>
                <td>Contained to one account</td>
                <td>Can lead to full domain or system compromise</td>
            </tr>
            <tr>
                <td>Typical examples</td>
                <td>Employee login</td>
                <td>Domain Admin, root, service accounts</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Access footprint comparison
         Teaching purpose: show the learner that a privileged account's access footprint spans many systems,
         which they would otherwise assume is only marginally more powerful than a standard account. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Access footprint comparison">
            <text x="140" y="30" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Standard Account</text>
            <circle cx="140" cy="120" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="140" y="125" text-anchor="middle" font-size="11" fill="var(--text-secondary)">User</text>
            <rect x="90" y="170" width="100" height="34" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="140" y="191" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Own Files</text>
            <line x1="140" y1="146" x2="140" y2="168" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <text x="580" y="30" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Privileged Account</text>
            <circle cx="580" cy="90" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="580" y="95" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Admin</text>
            <rect x="450" y="160" width="90" height="34" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="495" y="181" text-anchor="middle" font-size="10" fill="var(--text-secondary)">File Server</text>
            <rect x="555" y="160" width="90" height="34" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="181" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Domain Controller</text>
            <rect x="660" y="160" width="90" height="34" rx="6" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="705" y="181" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Firewall</text>
            <line x1="565" y1="112" x2="500" y2="157" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="580" y1="116" x2="600" y2="157" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="595" y1="112" x2="700" y2="157" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>The majority of major breaches investigated by security teams involve a compromised privileged credential at some stage of the attack. Protecting these accounts is one of the highest impact security investments an organization can make.</p>
    </div>
</div>
HTML;

// TASK 3: Privileged Account Vaulting
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Storing Credentials Safely</h2>

    <p>A <strong>vault</strong> is a secure, encrypted storage system that holds privileged credentials so that no human ever needs to know the actual password. Instead of memorizing or writing down a Domain Admin password, an administrator requests access through the vault, which releases the credential only for the duration needed.</p>

    <p>This is similar to a bank's safe deposit box system. You do not carry the vault key around with you. You request access, staff verify who you are, and every visit is logged. When you are finished, the box is sealed again.</p>

    <!-- SVG: Vault credential lifecycle
         Teaching purpose: show the learner that a vaulted credential moves through a defined lifecycle,
         which they would otherwise picture as a single static shared password. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Vault credential lifecycle">
            <rect x="10"  y="30" width="130" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="175" y="30" width="130" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="340" y="30" width="130" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="505" y="30" width="130" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="640" y="30" width="130" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="140" y1="65" x2="172" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="305" y1="65" x2="337" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="470" y1="65" x2="502" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="635" y1="65" x2="637" y2="65" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="75"  y="60" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Stored</text>
            <text x="75"  y="76" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Encrypted in vault</text>
            <text x="240" y="60" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Checked Out</text>
            <text x="240" y="76" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Released for use</text>
            <text x="405" y="60" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">In Use</text>
            <text x="405" y="76" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Session recorded</text>
            <text x="570" y="60" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Checked In</text>
            <text x="570" y="76" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Returned to vault</text>
            <text x="705" y="60" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Rotated</text>
            <text x="705" y="76" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Password changed</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Mistake</h4>
        <p>Hardcoding privileged credentials into scripts or configuration files bypasses the vault entirely. If that script is ever exposed, the credential is exposed with it.</p>
    </div>
</div>
HTML;

// TASK 4: Just-in-Time Access Provisioning
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Access Only When It Is Needed</h2>

    <p><strong>Just-in-Time</strong> access provisioning grants elevated permissions only for the specific window of time a task requires, rather than leaving that access available at all times. Once the task is done or the window expires, the elevated permission disappears automatically.</p>

    <p>Think of the difference between a permanent employee badge and a temporary visitor badge. A permanent badge works every day whether or not it is needed. A visitor badge is issued for a specific visit and stops working the moment that visit ends.</p>

    <!-- SVG: Standing access vs JIT access
         Teaching purpose: show the learner that standing access is available continuously while JIT access
         is granted only for a short window, which they would otherwise treat as functionally the same. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Standing access versus JIT access timeline">
            <text x="20" y="30" font-size="13" font-weight="600" fill="var(--text-primary)">Standing Access</text>
            <rect x="20" y="45" width="700" height="24" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="370" y="61" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Always available, every day</text>

            <text x="20" y="105" font-size="13" font-weight="600" fill="var(--text-primary)">Just-in-Time Access</text>
            <rect x="20" y="120" width="700" height="24" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="330" y="120" width="90" height="24" rx="4" fill="var(--text-secondary)" opacity="0.35"/>
            <text x="375" y="137" text-anchor="middle" font-size="10" fill="var(--text-primary)">Granted window</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Zero Standing Privilege</h4>
        <p>Zero Standing Privilege is the principle that no account should hold elevated access by default. Access is granted only when requested, only for as long as needed, then removed automatically.</p>
    </div>
</div>
HTML;

// TASK 5: Session Recording and Monitoring
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Watching What Happens During Access</h2>

    <p>Vaulting and Just-in-Time access control who can get in and for how long, but they do not tell you what happened once access was granted. That is the job of <strong>session recording</strong>, which captures the actions taken during a privileged session in real time.</p>

    <p>This is similar to a CCTV camera placed at the entrance to a server room. Everyone who enters is identified, and their activity is recorded, so that if anything unusual happens, there is a clear record to review afterward.</p>

    <!-- SVG: Session proxy diagram
         Teaching purpose: show the learner that a recording proxy sits between the administrator and the target
         system, which they would otherwise assume means direct, unmonitored access to the system. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Session recording proxy diagram">
            <rect x="10"  y="45" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="75" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Administrator</text>

            <rect x="280" y="35" width="140" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Session Proxy</text>
            <text x="350" y="83" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Records activity</text>

            <rect x="550" y="45" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="620" y="75" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Target System</text>

            <line x1="150" y1="70" x2="275" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="420" y1="70" x2="545" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Session recording maps directly to the Accounting leg of the AAA framework. It provides the evidence needed for forensic investigation, compliance audits, and troubleshooting after an incident.</p>
    </div>
</div>
HTML;

// TASK 6: Password Rotation Automation
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Making Old Credentials Useless</h2>

    <p><strong>Password rotation automation</strong> changes a privileged credential's password automatically, removing the risk of a password being reused or remaining valid long after it should have been retired. Rotation is usually triggered by the vault itself, not by a human remembering to do it.</p>

    <p>Picture a lock that changes automatically the instant a borrowed key is returned. Even if someone copied that key while they had it, the copy stops working the moment the original is handed back.</p>

    <h3>Common Rotation Triggers</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Trigger Type</th>
                <th>When It Happens</th>
                <th>Example Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>On check-in</td>
                <td>Immediately after a credential is returned to the vault</td>
                <td>An admin finishes a task and checks in a Domain Admin credential</td>
            </tr>
            <tr>
                <td>Scheduled</td>
                <td>At fixed intervals regardless of use</td>
                <td>A service account password rotated every 30 days</td>
            </tr>
            <tr>
                <td>On suspected compromise</td>
                <td>Triggered manually or by an alert</td>
                <td>A credential is rotated immediately after unusual activity is detected</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Mistake</h4>
        <p>Service accounts are often excluded from rotation policies because rotating them can break dependent applications. This makes them a long term target, since their passwords may never change.</p>
    </div>
</div>
HTML;

// TASK 7: Tiered Architecture and Break-Glass
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Keeping Powerful Credentials in Their Lane</h2>

    <p>Not all privileged accounts carry the same level of risk. The Active Directory tiering model divides systems and accounts into levels: <strong>Tier 0</strong> contains Domain Controllers and Domain Admin accounts, Tier 1 contains servers and server admins, and Tier 2 contains standard workstations and their local admins. The same separation applies to cloud environments through scoped IAM roles.</p>

    <p>The rule is simple: a credential from a higher tier should never be used to log into a lower tier system. Doing so exposes that powerful credential to a less trusted environment, similar to using a master key on a door with a broken lock.</p>

    <!-- SVG: Tier access flow
         Teaching purpose: show the learner that access should stay within or move down through controlled paths only,
         and that a high tier credential logging into a low tier system is a violation, which they would otherwise
         assume is a harmless convenience. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Tiered access flow diagram">
            <rect x="20"  y="15" width="660" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="42" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Tier 0: Domain Controllers, Domain Admins</text>

            <rect x="20"  y="78" width="660" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="105" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Tier 1: Servers, Server Admins</text>

            <rect x="20"  y="141" width="660" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="168" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Tier 2: Workstations, Local Admins</text>

            <line x1="670" y1="60" x2="670" y2="78" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr7)"/>
            <line x1="670" y1="123" x2="670" y2="141" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr7)"/>
            <defs>
                <marker id="arr7" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <p>When standard administrative access is unavailable during an incident, such as a lockout affecting every admin account, organizations rely on <strong>break-glass</strong> procedures: a tightly controlled emergency account that grants temporary access outside of normal workflows.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Critical Rule</h4>
        <p>Break-glass access must always trigger a mandatory post-use audit and immediate password rotation. It is an emergency exception, never a convenience.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have been given access to a simulated Vault Console managing several privileged accounts. Your job is to check out a privileged credential through the vault, observe the Just-in-Time session in progress, and check it back in to trigger automatic password rotation.</p>

    <p>Watch how the vault records the session and only reveals confirmation once the credential has been safely returned and rotated.</p>

    <div class="practical-launch-wrapper">
        <a href="privileged-access-management-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Vault Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You now understand how Privileged Access Management protects the most valuable accounts in any environment. Vaulting removes standing knowledge of passwords, Just-in-Time provisioning replaces permanent access with short controlled windows, session recording provides accountability, automated rotation closes the loop after every use, and tiered architecture keeps powerful credentials away from less trusted systems.</p>

    <p>Together these controls turn privileged access from a standing risk into a tightly managed, auditable process.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Privileged accounts carry far greater risk than standard accounts and require dedicated controls.</li>
        <li>Vaulting removes the need for humans to know privileged passwords directly.</li>
        <li>Just-in-Time access and Zero Standing Privilege limit access to only when it is needed.</li>
        <li>Session recording provides the audit trail needed for investigation and compliance.</li>
        <li>Automated rotation makes stolen or reused credentials worthless after each use.</li>
        <li>Tiered architecture and break-glass procedures keep the most powerful credentials contained and controlled.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
