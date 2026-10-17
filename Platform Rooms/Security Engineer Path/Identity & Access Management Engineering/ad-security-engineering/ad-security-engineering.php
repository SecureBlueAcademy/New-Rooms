<?php
// ============================================================
// ad-security-engineering.php : CYBRIXEN ROOM DATA FILE
// Topic: Active Directory Security Engineering
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'ad-security-engineering',
    'title'           => 'Active Directory Security Engineering',
    'description'     => 'Harden an Active Directory environment against Kerberoasting, Pass-the-Hash, DCSync, and Golden Ticket attacks using tiered administration, Protected Users, fine-grained password policies, and LDAP hardening.',
    'icon'            => 'fas fa-sitemap',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Expert',
    'estimated_time'  => '75 minutes',
    'prerequisites'   => ['Windows domain fundamentals', 'Basic Kerberos and NTLM authentication concepts'],
    'learning_objectives' => [
        'Explain why Active Directory is the highest value target in most enterprise breaches',
        'Describe how Kerberoasting and Pass-the-Hash attacks obtain and reuse credentials',
        'Describe how DCSync and Golden Ticket attacks achieve domain persistence',
        'Implement a tiered administration model to contain credential exposure',
        'Apply Protected Users membership and fine-grained password policies to privileged accounts',
        'Configure LDAP signing, channel binding, and audit logging for detection and prevention',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/ad-security-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'The AD Attack Surface'],
    ['id' => 'task3', 'title' => 'Kerberoasting and Pass-the-Hash'],
    ['id' => 'task4', 'title' => 'DCSync and Golden Ticket'],
    ['id' => 'task5', 'title' => 'Tiered Administration Model'],
    ['id' => 'task6', 'title' => 'Protected Users and FGPP'],
    ['id' => 'task7', 'title' => 'LDAP Signing and Audit Logging'],
    ['id' => 'task8', 'title' => 'Harden the Domain'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'ad_security_engineering_progress',
    'instagram_takeaways'  => [
        '✓ How Kerberoasting and Pass-the-Hash attacks steal credentials',
        '✓ How DCSync and Golden Ticket attacks achieve domain persistence',
        '✓ The tiered administration model and Protected Users',
        '✓ LDAP signing, channel binding, and audit logging',
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
        ['id' => 'q1', 'text' => 'What Active Directory object holds all domain trust and authentication data, making it the highest value target in most breaches?'],
        ['id' => 'q2', 'text' => 'What security philosophy assumes an attacker will eventually gain a foothold, shifting focus to limiting blast radius rather than only preventing entry?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What must be registered on a service account for it to be a Kerberoasting target?'],
        ['id' => 'q4', 'text' => 'What type of attack lets an attacker authenticate using only a captured NTLM hash, without knowing the plaintext password?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the name of the attack that abuses domain replication permissions to request password data directly from a domain controller?'],
        ['id' => 'q6', 'text' => 'What AD account\'s password hash must be stolen to forge a Golden Ticket?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What is the term for the security model that separates administrative accounts into Tier 0, Tier 1, and Tier 2 to prevent credential exposure?'],
        ['id' => 'q8', 'text' => 'In the tiered admin model, which tier contains domain controllers and the accounts that manage them?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'What built-in AD security group blocks its members from authenticating via NTLM and from having credentials cached in memory?'],
        ['id' => 'q10', 'text' => 'What AD object type allows a stricter password policy to be applied to specific accounts without changing the domain wide default policy?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What LDAP security setting prevents directory traffic from being tampered with or relayed on the network?'],
        ['id' => 'q12', 'text' => 'What audit policy category must be enabled to generate the log evidence needed to detect a DCSync attack?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed once the Domain Security Score reaches 100%.'],
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
    <p>Active Directory sits underneath almost every login, file share, and application in a typical enterprise network. When it is compromised, an attacker does not just gain access to one machine, they gain the keys to the entire domain. This is why AD is the single most targeted system in modern breaches, from ransomware operators to advanced persistent threat groups.</p>

    <p>This room walks through the four attack techniques responsible for most real-world AD compromises, then covers the concrete engineering controls used to stop them. A hands-on domain hardening exercise is included so you can apply every control directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why Active Directory is the highest value target in most enterprise breaches.</li>
        <li>Describe how Kerberoasting and Pass-the-Hash attacks obtain and reuse credentials.</li>
        <li>Describe how DCSync and Golden Ticket attacks achieve domain persistence.</li>
        <li>Implement a tiered administration model to contain credential exposure.</li>
        <li>Apply Protected Users membership and fine-grained password policies to privileged accounts.</li>
        <li>Configure LDAP signing, channel binding, and audit logging for detection and prevention.</li>
    </ul>
</div>
HTML;

// TASK 2: The AD Attack Surface
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>One Directory, Every System</h2>

    <p>Active Directory is not just a server that authenticates logins. It is the trust store that every joined workstation, file server, and application relies on to decide who is allowed to do what. A domain controller does not host one service, it hosts the identity backbone for the entire network.</p>

    <p>This centralization is exactly what makes AD so valuable to defend and so attractive to attack. Compromise a single domain controller, or steal the right credential, and an attacker inherits trust across every system that trusts that domain.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>In most enterprise ransomware incidents, Active Directory compromise is the turning point between a contained infection and a full network takeover. Understanding the attack surface is the first step toward closing it.</p>
    </div>

    <!-- SVG: AD as the central trust store
         Teaching purpose: show the learner that every system in the domain depends on
         the domain controller for authentication, which they would otherwise misunderstand
         as AD being just another server to patch alongside the rest. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 320" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Active Directory as central trust store">
            <!-- Domain Controller (center) -->
            <rect x="290" y="130" width="120" height="60" rx="10" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="350" y="155" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Domain</text>
            <text x="350" y="172" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Controller</text>

            <!-- Connected systems -->
            <rect x="40"  y="20"  width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="52" text-anchor="middle" font-size="12" fill="var(--text-primary)">Workstations</text>

            <rect x="480" y="20"  width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="550" y="52" text-anchor="middle" font-size="12" fill="var(--text-primary)">File Servers</text>

            <rect x="40"  y="245" width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="277" text-anchor="middle" font-size="12" fill="var(--text-primary)">Applications</text>

            <rect x="480" y="245" width="140" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="550" y="277" text-anchor="middle" font-size="12" fill="var(--text-primary)">Email Systems</text>

            <!-- Connecting lines -->
            <line x1="180" y1="47"  x2="295" y2="140" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="480" y1="47"  x2="405" y2="140" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="180" y1="272" x2="295" y2="180" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="480" y1="272" x2="405" y2="180" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Kerberoasting and Pass-the-Hash
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Stealing and Reusing Credentials</h2>

    <p>Kerberoasting targets service accounts. Any account with a Service Principal Name registered can be asked, by any authenticated domain user, for a service ticket. That ticket is encrypted with the service account's own password hash, so an attacker can request it, take it offline, and try to crack the password with no further interaction with the domain.</p>

    <p>Pass-the-Hash works differently. Instead of cracking a password, the attacker captures an NTLM hash directly, often from memory on a compromised machine, and uses that hash to authenticate as the account without ever knowing the plaintext password.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Attack</th>
                <th>Target</th>
                <th>Mechanism</th>
                <th>Primary Defense</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Kerberoasting</strong></td>
                <td>Service accounts with an SPN</td>
                <td>Request a TGS ticket, crack it offline</td>
                <td>Long random service account passwords</td>
            </tr>
            <tr>
                <td><strong>Pass-the-Hash</strong></td>
                <td>Any account with a cached NTLM hash</td>
                <td>Authenticate using the hash directly</td>
                <td>Protected Users, disabling NTLM</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Kerberoasting flow
         Teaching purpose: show the learner that Kerberoasting is an offline cracking attack
         that starts with a legitimate ticket request, which they would otherwise misunderstand
         as requiring direct theft of the account's password. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Kerberoasting attack flow">
            <rect x="10"  y="50" width="150" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Attacker requests</text>
            <text x="85" y="100" text-anchor="middle" font-size="12" fill="var(--text-primary)">TGS for an SPN</text>

            <rect x="275" y="50" width="150" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">DC returns ticket</text>
            <text x="350" y="100" text-anchor="middle" font-size="12" fill="var(--text-primary)">encrypted with hash</text>

            <rect x="540" y="50" width="150" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="615" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Cracked offline,</text>
            <text x="615" y="100" text-anchor="middle" font-size="12" fill="var(--text-primary)">no domain contact</text>

            <line x1="160" y1="80" x2="270" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="425" y1="80" x2="535" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Weakness</h4>
        <p>Service accounts are frequently created once and forgotten, often with short, static passwords that never rotate. This makes them the easiest Kerberoasting targets in most environments.</p>
    </div>
</div>
HTML;

// TASK 4: DCSync and Golden Ticket
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Persistence at the Domain Level</h2>

    <p>DCSync abuses the same replication permissions that domain controllers use to synchronize with each other. If an attacker compromises an account holding those permissions, they can request password data directly from a domain controller by impersonating another domain controller, with no need to ever log into one.</p>

    <p>A Golden Ticket goes further. It requires the password hash of the krbtgt account, the account that signs every Kerberos ticket in the domain. With that hash, an attacker can forge a valid ticket for any user, including one that does not exist, and grant themselves domain admin rights that persist even after passwords are changed.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Attack</th>
                <th>Requirement</th>
                <th>Result</th>
                <th>Detection Method</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>DCSync</strong></td>
                <td>Replication permissions on an account</td>
                <td>Retrieves any account's password hash</td>
                <td>Directory Service Access auditing</td>
            </tr>
            <tr>
                <td><strong>Golden Ticket</strong></td>
                <td>krbtgt account password hash</td>
                <td>Forged tickets with any privilege level</td>
                <td>Anomalous ticket lifetimes and krbtgt usage</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: DCSync impersonation flow
         Teaching purpose: show the learner that DCSync works by impersonating a domain
         controller over replication, which they would otherwise misunderstand as requiring
         direct compromise of a physical domain controller. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="DCSync impersonation flow">
            <rect x="10"  y="50" width="180" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Attacker holds</text>
            <text x="100" y="100" text-anchor="middle" font-size="12" fill="var(--text-primary)">replication rights</text>

            <rect x="290" y="50" width="180" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Requests GetNCChanges</text>
            <text x="380" y="100" text-anchor="middle" font-size="12" fill="var(--text-primary)">as a fake DC</text>

            <rect x="570" y="50" width="120" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="630" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Receives</text>
            <text x="630" y="100" text-anchor="middle" font-size="12" fill="var(--text-primary)">password hashes</text>

            <line x1="190" y1="80" x2="285" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="470" y1="80" x2="565" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Critical Response Step</h4>
        <p>If a Golden Ticket attack is suspected, the krbtgt password must be reset twice in sequence. A single reset is not sufficient because the account keeps its previous password valid for compatibility.</p>
    </div>
</div>
HTML;

// TASK 5: Tiered Administration Model
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Containing Credential Exposure</h2>

    <p>The tiered administration model separates administrative accounts into three tiers. Tier 0 covers domain controllers and the accounts that manage them. Tier 1 covers servers and the applications running on them. Tier 2 covers standard workstations and end user support.</p>

    <p>The model exists because of one repeated pattern in real breaches: a high privilege credential logs into a lower tier machine, and an attacker who already controls that machine captures the credential. From there, they walk straight up to full domain control.</p>

    <!-- SVG: Tier boundary violation
         Teaching purpose: show the learner that tiering is a security boundary, not an
         org chart, which they would otherwise misunderstand as a purely administrative
         grouping with no real enforcement consequence. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Tiered administration boundaries">
            <rect x="20" y="10"  width="660" height="55" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="1.5"/>
            <text x="350" y="43" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Tier 0: Domain Controllers and Domain Admins</text>

            <rect x="20" y="85"  width="660" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="118" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Tier 1: Servers and Applications</text>

            <rect x="20" y="160" width="660" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="193" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Tier 2: Workstations and End User Support</text>

            <!-- Violation arrow -->
            <line x1="600" y1="65" x2="600" y2="155" stroke="var(--warning, #ffb020)" stroke-width="2" stroke-dasharray="5,4" marker-end="url(#arr5)"/>
            <text x="612" y="115" font-size="11" fill="var(--warning, #ffb020)">violation</text>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--warning, #ffb020)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>A credential from a higher tier should never be entered on a lower tier machine. This one rule, enforced consistently, stops most real-world lateral movement paths before they start.</p>
    </div>
</div>
HTML;

// TASK 6: Protected Users and Fine-Grained Password Policies
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Hardening Privileged Accounts Directly</h2>

    <p>Protected Users is a built-in group that changes how its members are allowed to authenticate. Membership blocks NTLM authentication entirely, prevents the account from using weaker encryption types, and stops credentials from being cached in memory on the machines it logs into.</p>

    <p>Fine-Grained Password Policies solve a different problem. By default, every account in a domain follows one password policy. A Password Settings Object lets a stricter policy, such as a longer minimum length and shorter maximum age, apply only to the privileged accounts that need it.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Protection</th>
                <th>Standard Account</th>
                <th>Protected Users Member</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>NTLM authentication</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
            <tr>
                <td>Credential caching in memory</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
            <tr>
                <td>Weak Kerberos encryption (DES, RC4)</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
            <tr>
                <td>Delegation</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Rollout Note</h4>
        <p>Protected Users can break authentication for legacy applications that depend on NTLM or weak encryption. Roll it out to a small group of privileged accounts first and test thoroughly before wider adoption.</p>
    </div>
</div>
HTML;

// TASK 7: LDAP Signing, Channel Binding, and Audit Logging
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Closing the Network and Detection Gaps</h2>

    <p>LDAP signing ensures that directory traffic cannot be silently modified in transit. Without it, an attacker positioned on the network can tamper with or relay LDAP requests between a client and a domain controller.</p>

    <p>Channel binding closes a gap that signing alone does not cover. Even with TLS in use, a session can potentially be relayed to a different destination unless the LDAP session is cryptographically bound to its underlying TLS channel.</p>

    <p>Neither of these controls matters if nobody is watching. The Directory Service Access audit category is what actually generates the event log entries that reveal replication abuse, including DCSync activity, as it happens.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Control</th>
                <th>Protects Against</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>LDAP Signing</strong></td>
                <td>Tampering with directory traffic</td>
                <td>Does not fully stop relay over TLS</td>
            </tr>
            <tr>
                <td><strong>LDAP Channel Binding</strong></td>
                <td>Relaying an authenticated TLS session</td>
                <td>Required in addition to signing</td>
            </tr>
            <tr>
                <td><strong>Directory Service Access Auditing</strong></td>
                <td>Undetected replication abuse</td>
                <td>Generates the event ID needed to catch DCSync</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Misconception</h4>
        <p>Enabling LDAP signing alone is often assumed to be sufficient. Without channel binding, a signed session can still be relayed, leaving the domain exposed to the same class of attack.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have been given access to a live Domain Security Console for a partially hardened domain. Several of the controls covered in this room, tiered OU placement, Protected Users membership, fine-grained password policy assignment, LDAP signing, channel binding, and audit logging, are currently misconfigured.</p>

    <p>Work through each control, correct its state, and watch the Domain Security Score rise. The flag will appear once every control has been hardened and the score reaches 100%.</p>

    <div class="practical-launch-wrapper">
        <a href="ad-security-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Domain Security Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You now understand the four attacks responsible for most real-world Active Directory compromises, and the concrete engineering controls that stop them. Kerberoasting and Pass-the-Hash steal and reuse credentials directly. DCSync and Golden Ticket turn a single stolen secret into long-term domain persistence. Tiered administration, Protected Users, fine-grained password policies, LDAP hardening, and audit logging close the gaps these attacks depend on.</p>

    <p>None of these controls work well in isolation. A hardened domain applies all of them together, consistently, across every privileged account and every domain controller.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>AD is the highest value target in most breaches because it is the trust store for the entire domain.</li>
        <li>Kerberoasting targets service accounts with an SPN, cracking their ticket offline.</li>
        <li>Pass-the-Hash reuses a captured NTLM hash without ever needing the plaintext password.</li>
        <li>DCSync abuses replication permissions, and Golden Ticket abuses the krbtgt hash, for domain level persistence.</li>
        <li>Tiered administration, Protected Users, fine-grained password policies, and LDAP hardening close these attack paths at the source.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA. Engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
