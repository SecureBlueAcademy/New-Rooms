<?php
// ============================================================
// email-security-engineering.php — ROOM DATA FILE
// Topic: Email Security Engineering (SPF, DKIM, DMARC, BIMI, MTA-STS)
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'email-security-engineering',
    'title'           => 'Email Security Engineering (SPF, DKIM, DMARC)',
    'description'     => 'Engineer a complete email authentication stack to prevent domain spoofing and phishing.',
    'icon'            => 'fas fa-envelope-open-text',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Expert',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Solid understanding of DNS records', 'Basic networking and SMTP concepts'],
    'learning_objectives' => [
        'Explain the roles of SPF, DKIM, and DMARC in preventing domain spoofing',
        'Write a correct SPF record and identify why +all defeats its purpose',
        'Generate DKIM keys and explain why regular rotation matters',
        'Progress a DMARC policy safely from monitor to quarantine to reject',
        'Describe how BIMI and MTA-STS extend a mature authentication deployment',
        'Identify gateway level controls that complement authentication',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/email-security-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Why Email Authentication Matters'],
    ['id' => 'task3', 'title' => 'SPF'],
    ['id' => 'task4', 'title' => 'DKIM'],
    ['id' => 'task5', 'title' => 'DMARC and Policy Progression'],
    ['id' => 'task6', 'title' => 'BIMI and MTA-STS'],
    ['id' => 'task7', 'title' => 'Email Gateway and Anti-Phishing Controls'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'email_security_engineering_progress',
    'instagram_takeaways'  => [
        '✓ SPF, DKIM, and DMARC and how they work together',
        '✓ Avoiding the +all SPF mistake',
        '✓ DKIM key rotation and selector alignment',
        '✓ Rolling out DMARC from monitor to reject',
        '✓ BIMI, MTA-STS, and gateway level anti-phishing controls',
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
        ['id' => 'q1', 'text' => 'What header does an attacker forge to spoof a sender\'s identity?'],
        ['id' => 'q2', 'text' => 'What is the term for an attack where a spoofed email tricks an employee into making a fraudulent payment?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What SPF qualifier causes a hard fail for unauthorized senders?'],
        ['id' => 'q4', 'text' => 'What SPF mechanism authorizes a third party sending service?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What type of cryptography does DKIM use for signing and verification?'],
        ['id' => 'q6', 'text' => 'What part of the DNS record location must match the value used to sign a message?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What DMARC tag specifies where aggregate reports are sent?'],
        ['id' => 'q8', 'text' => 'What is the strictest DMARC policy value that rejects failing mail?'],
        ['id' => 'q9', 'text' => 'What domain must SPF or DKIM align with for DMARC to pass?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What does BIMI display in the recipient\'s inbox?'],
        ['id' => 'q11', 'text' => 'What protocol does MTA-STS enforce for mail in transit?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'What term describes detonating attachments in an isolated environment to check for malware?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the DNS Record Auditor.'],
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
    <p>Email remains the single most common entry point for phishing and business email compromise, largely because the core SMTP protocol was never designed to verify who actually sent a message. Anyone can put any address in the From field, and without additional safeguards a receiving mail server has no way to tell a forged message from a genuine one.</p>

    <p>By the end of this room you will be able to design a complete email authentication stack: correctly written SPF records, properly rotated DKIM keys, and a DMARC policy taken safely from monitoring through to full enforcement, along with the BIMI and MTA-STS layers that build on top of it. A hands on lab lets you diagnose and repair a broken authentication setup on a simulated domain.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the roles of SPF, DKIM, and DMARC in preventing domain spoofing.</li>
        <li>Write a correct SPF record and identify why +all defeats its purpose.</li>
        <li>Generate DKIM keys and explain why regular rotation matters.</li>
        <li>Progress a DMARC policy safely from monitor to quarantine to reject.</li>
        <li>Describe how BIMI and MTA-STS extend a mature authentication deployment.</li>
        <li>Identify gateway level controls that complement authentication.</li>
    </ul>
</div>
HTML;

// TASK 2: Why Email Authentication Matters
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>A Protocol Built Without Identity Checks</h2>

    <p>SMTP was designed in an era when the network was assumed to be trustworthy. It has no built in mechanism to confirm that the sender named in a message is the party who actually sent it. An attacker can set the From address to any domain they choose, and the message will still be delivered unless something outside SMTP itself checks it.</p>

    <p>This gap is what makes domain spoofing possible. An attacker registers nothing, controls no infrastructure belonging to the victim domain, and can still send mail that appears to come from it. The recipient sees a familiar name and a familiar domain, with no visual difference from a genuine message.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The Real Cost</h4>
        <p>Business Email Compromise, spoofed messages that impersonate executives or suppliers to redirect payments, has cost organizations billions of dollars globally. A single convincing spoofed invoice email can bypass technical controls entirely by targeting human trust instead.</p>
    </div>

    <h3>The Same Path, Two Different Senders</h3>
    <p>Think of an unstamped envelope with a forged return address. The mail carrier delivers it without checking who really sent it, because nothing in the delivery process verifies the sender. Email works the same way unless authentication is added on top.</p>

    <!-- SVG: spoofed vs legitimate mail path
         Teaching purpose: show the learner that a spoofed email travels the exact same
         path as a legitimate one and looks identical on arrival, which they would
         otherwise misunderstand as "something in the mail system checks this automatically". -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Spoofed email delivery path">
            <rect x="10"  y="30" width="180" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="30" width="180" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="590" y="30" width="160" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="190" y1="65" x2="295" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="480" y1="65" x2="585" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="100" y="58" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attacker's Server</text>
            <text x="100" y="76" text-anchor="middle" font-size="11" fill="var(--text-secondary)">From: forged domain</text>
            <text x="390" y="58" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Receiving Server</text>
            <text x="390" y="76" text-anchor="middle" font-size="11" fill="var(--text-secondary)">no identity check</text>
            <text x="670" y="58" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Recipient Inbox</text>
            <text x="670" y="76" text-anchor="middle" font-size="11" fill="var(--text-secondary)">looks legitimate</text>
            <text x="390" y="130" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Without SPF, DKIM, or DMARC, this path is identical for real and forged mail.</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: SPF
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Authorizing Who Can Send</h2>

    <p>SPF, Sender Policy Framework, publishes a list of mail servers authorized to send email for a domain. Think of it as a guest list at a door: the receiving server checks whether the sending server's IP address appears on that list before accepting the mail as coming from that domain.</p>

    <p>An SPF record is a DNS TXT record made up of mechanisms and a qualifier at the end. Mechanisms like <strong>include</strong>, <strong>ip4</strong>, and <strong>mx</strong> define which servers are authorized. The final qualifier decides what happens when a sending server is not on the list.</p>

    <h3>SPF Qualifiers</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Qualifier</th>
                <th>Meaning</th>
                <th>Effect on Fail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>-all</strong></td>
                <td>Hard fail</td>
                <td>Unauthorized senders are rejected.</td>
            </tr>
            <tr>
                <td><strong>~all</strong></td>
                <td>Soft fail</td>
                <td>Unauthorized senders are marked suspicious but usually still delivered.</td>
            </tr>
            <tr>
                <td><strong>?all</strong></td>
                <td>Neutral</td>
                <td>No policy is asserted at all.</td>
            </tr>
            <tr>
                <td><strong>+all</strong></td>
                <td>Pass</td>
                <td>Every sender passes, authorized or not.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The +all Mistake</h4>
        <p>A record ending in <strong>+all</strong> tells receiving servers to accept mail from any host, regardless of whether it is actually authorized. This is sometimes added during testing and never removed. The result is an SPF record that provides no protection whatsoever.</p>
    </div>

    <!-- SVG: SPF evaluation flow
         Teaching purpose: show the learner that SPF checks the sending IP against a
         DNS record, which they would otherwise misunderstand as SPF checking the
         message content or the From address itself. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SPF evaluation flow">
            <rect x="10"  y="20" width="180" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="20" width="180" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="120" width="180" height="50" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="590" y="20" width="160" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="190" y1="50" x2="295" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="390" y1="80" x2="390" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="480" y1="50" x2="585" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="100" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Sending Server</text>
            <text x="100" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">connects with an IP</text>
            <text x="390" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Receiving Server</text>
            <text x="390" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">looks up SPF record</text>
            <text x="390" y="145" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">DNS TXT Record</text>
            <text x="390" y="160" text-anchor="middle" font-size="11" fill="var(--text-secondary)">authorized IP list</text>
            <text x="670" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Pass or Fail</text>
            <text x="670" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">based on qualifier</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: DKIM
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Proving the Message Wasn't Altered</h2>

    <p>DKIM, DomainKeys Identified Mail, adds a cryptographic signature to outgoing mail. It uses asymmetric cryptography: a private key signs the message when it is sent, and a matching public key, published in DNS, lets the receiving server verify that signature.</p>

    <p>Think of it as a wax seal on a letter. The DNS record is the public stamp used to verify that the seal really did come from the claimed sender, and that the contents were not altered along the way.</p>

    <h3>Selectors Matter</h3>
    <p>The public key is published at a specific DNS location: <strong>selector._domainkey.domain</strong>. The outgoing message's DKIM-Signature header names which selector was used to sign it. If the selector in the signature does not match a selector actually published in DNS, verification fails, even if a valid key exists somewhere else on the domain.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Why Rotation Matters</h4>
        <p>DKIM keys should be rotated on a regular schedule, typically every six to twelve months. Rotating limits the damage if a private key is ever exposed. A common practice is publishing the new selector alongside the old one briefly during rollover, so mail already queued with the old signature still verifies.</p>
    </div>

    <!-- SVG: DKIM signing and verification path
         Teaching purpose: show the learner that DKIM verifies message integrity
         through a private and public key pair, which they would otherwise
         misunderstand as DKIM verifying the sender's identity the way SPF does. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="DKIM signing and verification flow">
            <rect x="10"  y="20" width="200" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="280" y="20" width="200" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="280" y="120" width="200" height="50" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="560" y="20" width="190" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="210" y1="50" x2="275" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="380" y1="80" x2="380" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="480" y1="50" x2="555" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="110" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Sending Server</text>
            <text x="110" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">signs with private key</text>
            <text x="380" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Message Delivered</text>
            <text x="380" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">DKIM-Signature header attached</text>
            <text x="380" y="145" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">DNS Selector Record</text>
            <text x="380" y="160" text-anchor="middle" font-size="11" fill="var(--text-secondary)">publishes public key</text>
            <text x="655" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Receiving Server</text>
            <text x="655" y="63" text-anchor="middle" font-size="11" fill="var(--text-secondary)">verifies with public key</text>
        </svg>
    </div>
</div>
HTML;

// TASK 5: DMARC and Policy Progression
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Tying Authentication Together</h2>

    <p>DMARC, Domain based Message Authentication, Reporting and Conformance, sits on top of SPF and DKIM. It requires that at least one of them not only passes, but also aligns: the domain checked by SPF or DKIM must match the domain shown in the message's From header.</p>

    <p>DMARC also tells receiving servers what to do when a message fails alignment, and gives the domain owner visibility into what is happening through aggregate reports.</p>

    <h3>Policy Values</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Policy Value</th>
                <th>Behavior</th>
                <th>When to Use</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>p=none</strong></td>
                <td>Monitor only, no enforcement</td>
                <td>Initial rollout, while collecting reports</td>
            </tr>
            <tr>
                <td><strong>p=quarantine</strong></td>
                <td>Failing mail is sent to spam or junk</td>
                <td>Once reports show legitimate senders are aligned</td>
            </tr>
            <tr>
                <td><strong>p=reject</strong></td>
                <td>Failing mail is rejected outright</td>
                <td>Once quarantine shows no legitimate mail is affected</td>
            </tr>
        </tbody>
    </table>

    <p>Think of it like a building's security policy that starts in log only mode, then escalates to denying entry once you are confident no legitimate visitors are being turned away.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Do Not Skip the Reports</h4>
        <p>Jumping straight to p=reject without reviewing aggregate reports risks blocking legitimate mail from third party senders you did not realize were sending on your behalf, such as marketing or invoicing platforms.</p>
    </div>

    <!-- SVG: DMARC policy rollout
         Teaching purpose: show the learner that DMARC enforcement is a deliberate
         staged rollout, which they would otherwise misunderstand as a setting
         applied once and never revisited. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="DMARC policy rollout progression">
            <rect x="10"  y="30" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="280" y="30" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="550" y="30" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="210" y1="65" x2="275" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="480" y1="65" x2="545" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="110" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">p=none</text>
            <text x="110" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">monitor and collect reports</text>
            <text x="380" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">p=quarantine</text>
            <text x="380" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">failing mail goes to spam</text>
            <text x="650" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">p=reject</text>
            <text x="650" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">failing mail is rejected</text>
        </svg>
    </div>
</div>
HTML;

// TASK 6: BIMI and MTA-STS
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Building on a Mature Deployment</h2>

    <p>Once DMARC is enforced, two additional protocols extend what an authenticated domain can offer. BIMI adds a verified brand logo to messages in the recipient's inbox. MTA-STS ensures the mail itself is encrypted while it travels between servers.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Protocol</th>
                <th>Requires</th>
                <th>What It Adds</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>BIMI</strong></td>
                <td>DMARC at p=quarantine or p=reject</td>
                <td>A verified logo displayed in the inbox</td>
            </tr>
            <tr>
                <td><strong>MTA-STS</strong></td>
                <td>A published policy and valid TLS certificate</td>
                <td>Enforced TLS encryption for mail in transit</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> BIMI in Practice</h4>
        <p>BIMI will not display a logo unless the domain's DMARC policy is already enforcing at quarantine or reject. Think of it as a verified checkmark badge that only appears once the domain has proven it can be trusted.</p>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> MTA-STS Policy Modes</h4>
        <p>MTA-STS policies can run in <strong>testing</strong> mode, which reports failures without blocking delivery, or <strong>enforce</strong> mode, which requires TLS for delivery to succeed. A <strong>none</strong> mode disables the policy. Failures are reported through TLS-RPT, similar in spirit to DMARC's aggregate reports.</p>
    </div>
</div>
HTML;

// TASK 7: Email Gateway and Anti-Phishing Controls
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Layering Controls Beyond Authentication</h2>

    <p>Authentication confirms who is allowed to send on a domain's behalf, but it says nothing about what a message actually contains. Organizations pair SPF, DKIM, and DMARC with a secure email gateway that inspects mail more deeply before it reaches an inbox.</p>

    <p>Common gateway controls include attachment sandboxing, where attachments are opened in an isolated environment to check for malware before delivery, and URL rewriting, where links are scanned and checked again at the moment they are clicked rather than only at delivery time. Many gateways also add a banner warning recipients when a message originates from outside the organization.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Layered Defense</h4>
        <p>Authentication and gateway controls solve different problems. DMARC stops a forged domain from reaching the inbox at all. Gateway controls catch malicious content in mail that is technically authenticated but still harmful, such as a compromised partner account sending a real but malicious attachment.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have been given access to the DNS zone for cybrixen-corp.com, and its email authentication setup is broken. The SPF, DKIM, and DMARC records each contain a specific flaw that leaves the domain exposed to spoofing.</p>

    <p>Diagnose each record, select the corrected version, and once all three are fixed, run a scan to confirm the domain is fully authenticated.</p>

    <div class="practical-launch-wrapper">
        <a href="email-security-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch DNS Record Auditor</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You now have the tools to engineer a complete email authentication stack. SPF authorizes which servers can send for a domain, DKIM proves a message was not altered in transit, and DMARC ties both together, giving you a safe path from monitoring to full enforcement. BIMI and MTA-STS extend that foundation once it is mature, and gateway controls catch what authentication alone cannot.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>SPF authorizes sending servers, and a hard fail qualifier is required for it to mean anything.</li>
        <li>DKIM uses a public and private key pair, and the signing selector must match the one published in DNS.</li>
        <li>DMARC requires SPF or DKIM to align with the From domain, and should progress gradually from monitor to reject.</li>
        <li>BIMI and MTA-STS build on a domain that already enforces DMARC and TLS.</li>
        <li>Gateway controls like sandboxing and URL scanning catch threats that authentication alone does not.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
