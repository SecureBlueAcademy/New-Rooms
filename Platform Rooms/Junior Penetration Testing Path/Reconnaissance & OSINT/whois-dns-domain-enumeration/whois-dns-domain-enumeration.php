<?php
// Filename: whois-dns-domain-enumeration.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'whois-dns-enum',
    'title'           => 'WHOIS, DNS & Domain Enumeration',
    'description'     => 'Learn how WHOIS lookups and DNS records reveal infrastructure details that attackers pivot into during recon.',
    'icon'            => 'fas fa-network-wired',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic networking concepts'],
    'learning_objectives' => [
        'Explain what a WHOIS record reveals about a domain and its owner',
        'Identify the purpose of A, MX, NS, TXT, CNAME, and PTR DNS records',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/whois-dns-domain-enumeration-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'WHOIS Lookups'],
    ['id' => 'task3', 'title' => 'DNS Record Types'],
    ['id' => 'task4', 'title' => 'Zone Transfer Vulnerabilities'],
    ['id' => 'task5', 'title' => 'Subdomain Enumeration'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'whois_dns_enum_progress',
    'instagram_takeaways'  => [
        '✓ Reading WHOIS records for registration and ownership data',
        '✓ What A, MX, NS, TXT, CNAME, and PTR records each reveal',
        '✓ Why unauthenticated zone transfers leak internal infrastructure',
        '✓ Active vs passive subdomain enumeration techniques',
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
        ['id' => 'q1', 'text' => 'What term describes hiding a registrant\'s personal details in WHOIS records?'],
        ['id' => 'q2', 'text' => 'What organization manages a domain\'s registration and renewal?'],
        ['id' => 'q3', 'text' => 'What WHOIS field shows when a domain will lapse unless renewed?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'Which DNS record type maps a domain name to an IPv4 address?'],
        ['id' => 'q5', 'text' => 'Which DNS record type specifies a domain\'s mail server?'],
        ['id' => 'q6', 'text' => 'Which DNS record type stores arbitrary text data, often used for verification?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What does the acronym AXFR stand for?'],
        ['id' => 'q8', 'text' => 'What replication process allows a secondary nameserver to copy an entire zone from a primary?'],
        ['id' => 'q9', 'text' => 'What can a leaked zone file expose beyond public records?'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'What type of enumeration systematically guesses subdomains using a list of common names?'],
        ['id' => 'q11', 'text' => 'What publicly logged records unintentionally expose subdomains used in SSL certificates?'],
        ['id' => 'q12', 'text' => 'What term describes enumeration that gathers subdomains without directly interacting with the target\'s servers?'],
    ],
    'task6' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the Domain Recon Console.'],
    ],
    'task7' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every attacker and every defender begins the same way: by mapping what a target's domain actually reveals to the outside world. WHOIS records and DNS entries are public by design, and together they expose registration details, infrastructure hostnames, and mail routing information without a single exploit being used. Reconnaissance built on this data is quiet, legal to look up, and often the most valuable phase of an entire assessment.</p>

    <p>By the end of this room you will be able to read a WHOIS record, identify what each DNS record type reveals, explain why a misconfigured zone transfer is dangerous, and describe how subdomains are discovered when the obvious paths are closed. A hands on lab lets you run these lookups yourself against a simulated target and uncover a hidden flag through the same recon path a real attacker would follow.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what a WHOIS record reveals about a domain and its owner.</li>
        <li>Identify the purpose of A, MX, NS, TXT, CNAME, and PTR DNS records.</li>
        <li>Describe why an unauthenticated zone transfer is a serious misconfiguration.</li>
        <li>Differentiate active and passive subdomain enumeration techniques.</li>
        <li>Apply WHOIS and DNS lookups to trace a domain's infrastructure.</li>
    </ul>
</div>
HTML;

// TASK 2: WHOIS Lookups
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Reading a WHOIS Record</h2>

    <p>A WHOIS lookup is one of the oldest reconnaissance techniques on the internet, older than modern DNS itself. It queries a public registry and returns the administrative details tied to a domain name: who registered it, which company manages that registration, and when it expires.</p>

    <p>Think of WHOIS as a public listing for a domain, similar to how a business license lists a company's registered address. Anyone can look it up, and the information was never meant to be secret, though many owners now hide their personal details behind a privacy service.</p>

    <h3>What a WHOIS Record Tells You</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Field</th>
                <th>What It Tells You</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Registrar</strong></td>
                <td>The company the domain was registered through.</td>
            </tr>
            <tr>
                <td>Creation Date</td>
                <td>When the domain was first registered.</td>
            </tr>
            <tr>
                <td>Expiry Date</td>
                <td>When the domain must be renewed or it lapses.</td>
            </tr>
            <tr>
                <td>Registrant Organization</td>
                <td>The person or company that owns the registration.</td>
            </tr>
            <tr>
                <td>Name Server</td>
                <td>Which servers are authoritative for the domain's DNS.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> WHOIS Privacy</h4>
        <p>GDPR and similar privacy laws pushed most registrars to redact personal registrant details by default. This is called <strong>WHOIS privacy</strong>, and it means a lookup today often returns a registrar's proxy details instead of the real owner.</p>
    </div>
</div>
HTML;

// TASK 3: DNS Record Types
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>One Domain, Many Record Types</h2>

    <p>DNS is often described as the internet's phonebook, but that undersells it. A single domain can hold many different record types at once, each answering a completely different question. Confusing these types is one of the most common mistakes beginners make when reading DNS output.</p>

    <h3>Common DNS Record Types</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Record Type</th>
                <th>Purpose</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>A</strong></td>
                <td>Maps a domain to an IPv4 address.</td>
                <td>cybrixen-corp.local &rarr; 192.168.50.10</td>
            </tr>
            <tr>
                <td><strong>MX</strong></td>
                <td>Specifies where email for the domain should be delivered.</td>
                <td>mail.cybrixen-corp.local</td>
            </tr>
            <tr>
                <td><strong>NS</strong></td>
                <td>Lists the authoritative nameservers for the domain.</td>
                <td>ns1.cybrixen-corp.local</td>
            </tr>
            <tr>
                <td><strong>TXT</strong></td>
                <td>Stores arbitrary text, often used for verification or policy.</td>
                <td>SPF and domain verification records</td>
            </tr>
            <tr>
                <td><strong>CNAME</strong></td>
                <td>Points one hostname to another as an alias.</td>
                <td>www &rarr; cybrixen-corp.local</td>
            </tr>
            <tr>
                <td><strong>PTR</strong></td>
                <td>Maps an IP address back to a hostname, the reverse of an A record.</td>
                <td>192.168.50.10 &rarr; cybrixen-corp.local</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: shows one domain holding several coexisting record types
         Teaching purpose: correct the beginner misconception that DNS only
         maps a domain name to a single IP address. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="One domain with multiple DNS record types">
            <!-- Central domain node -->
            <rect x="300" y="10" width="160" height="50" rx="8" fill="var(--primary)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="40" text-anchor="middle" font-size="13" font-weight="600" fill="#fff">cybrixen-corp.local</text>

            <!-- Record boxes -->
            <rect x="10"  y="150" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="140" y="150" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="270" y="150" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="400" y="150" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="530" y="150" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="640" y="150" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <!-- Connecting lines -->
            <line x1="380" y1="60" x2="65"  y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="195" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="325" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="455" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="585" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="380" y1="60" x2="695" y2="145" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <!-- Labels -->
            <text x="65"  y="175" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">A</text>
            <text x="65"  y="193" text-anchor="middle" font-size="10" fill="var(--text-secondary)">IPv4 address</text>
            <text x="195" y="175" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">MX</text>
            <text x="195" y="193" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Mail server</text>
            <text x="325" y="175" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">NS</text>
            <text x="325" y="193" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Nameservers</text>
            <text x="455" y="175" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">TXT</text>
            <text x="455" y="193" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Text data</text>
            <text x="585" y="175" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">CNAME</text>
            <text x="585" y="193" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Alias</text>
            <text x="695" y="175" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">PTR</text>
            <text x="695" y="193" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Reverse lookup</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Zone Transfer Vulnerabilities
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>When Replication Becomes a Leak</h2>

    <p>A zone transfer, technically called AXFR, is how a secondary nameserver copies an entire zone file from the primary so it can serve the same records if the primary goes down. This replication is a normal and necessary part of how DNS stays reliable.</p>

    <p>The danger appears when a nameserver is configured to accept an AXFR request from anyone, not just its authorized secondary servers. That single misconfiguration can hand over a complete map of every subdomain the organization uses, including ones that were never meant to be public.</p>

    <!-- SVG: contrasts an authorized zone transfer with an attacker exploiting
         an open one. Teaching purpose: correct the assumption that zone
         transfers are always safe internal traffic that a stranger cannot request. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Authorized versus misconfigured zone transfer">
            <!-- Authorized transfer -->
            <text x="190" y="25" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Authorized Transfer</text>
            <rect x="20"  y="45" width="130" height="55" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="85" y="77" text-anchor="middle" font-size="12" fill="var(--text-primary)">Primary NS</text>
            <rect x="220" y="45" width="130" height="55" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="285" y="77" text-anchor="middle" font-size="12" fill="var(--text-primary)">Secondary NS</text>
            <line x1="150" y1="72" x2="215" y2="72" stroke="var(--success)" stroke-width="1.5" marker-end="url(#arrGood)"/>
            <text x="182" y="62" text-anchor="middle" font-size="10" fill="var(--success)">AXFR (allowed)</text>

            <!-- Misconfigured transfer -->
            <text x="570" y="25" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Misconfigured Transfer</text>
            <rect x="410" y="45" width="130" height="55" rx="8" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <text x="475" y="77" text-anchor="middle" font-size="12" fill="var(--text-primary)">Attacker</text>
            <rect x="610" y="45" width="130" height="55" rx="8" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <text x="675" y="72" text-anchor="middle" font-size="12" fill="var(--text-primary)">Secondary NS</text>
            <text x="675" y="88" text-anchor="middle" font-size="9" fill="var(--error)">accepts any request</text>
            <line x1="540" y1="72" x2="605" y2="72" stroke="var(--error)" stroke-width="1.5" marker-end="url(#arrBad)"/>
            <text x="572" y="62" text-anchor="middle" font-size="10" fill="var(--error)">AXFR (allowed)</text>

            <defs>
                <marker id="arrGood" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--success)"/>
                </marker>
                <marker id="arrBad" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--error)"/>
                </marker>
            </defs>

            <!-- Result -->
            <rect x="20"  y="140" width="330" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="165" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Only the intended secondary</text>
            <text x="185" y="182" text-anchor="middle" font-size="11" fill="var(--text-secondary)">receives the zone data.</text>

            <rect x="410" y="140" width="330" height="60" rx="8" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <text x="575" y="165" text-anchor="middle" font-size="11" fill="var(--error)">The full internal zone leaks</text>
            <text x="575" y="182" text-anchor="middle" font-size="11" fill="var(--error)">to an unauthenticated requester.</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Real World Impact</h4>
        <p>A leaked zone file has revealed internal only hostnames such as VPN gateways, staging environments, and admin panels in real breaches. Treat an open zone transfer as a critical finding, not a curiosity.</p>
    </div>
</div>
HTML;

// TASK 5: Subdomain Enumeration Techniques
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Finding What Zone Transfers Won't Give You</h2>

    <p>When zone transfers are locked down, which is the majority of the modern internet, subdomains have to be discovered rather than requested outright. Two broad approaches exist: active enumeration, which sends traffic directly to the target, and passive enumeration, which pulls information from sources that already collected it.</p>

    <p>Brute force enumeration tries a large wordlist of common subdomain names against the target, checking which ones resolve. Certificate transparency logs take a different route: every publicly trusted SSL certificate is logged permanently, and searching those logs often reveals subdomains the owner never intended to advertise.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Tooling Categories</h4>
        <p>Wordlist based brute forcers and certificate transparency search tools are both freely available and require no special access to use. Neither technique touches the target's zone file directly, which is exactly why they work even when zone transfers are blocked.</p>
    </div>
</div>
HTML;

// TASK 6: Practical (Domain Recon Console)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have access to a simulated reconnaissance console pointed at <strong>cybrixen-corp.local</strong>. Start with a WHOIS lookup, then work through the standard DNS record types before attempting to identify the domain's nameservers.</p>

    <p>One of those nameservers is misconfigured. Once you find it, you can attempt a zone transfer against it directly from the console. A successful transfer will dump the organization's full internal zone, flag included.</p>

    <div class="practical-launch-wrapper">
        <a href="whois-dns-domain-enumeration-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Domain Recon Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>WHOIS and DNS reconnaissance require no exploitation and no special access, yet they routinely hand attackers a working map of an organization's infrastructure. A registrant's name, a mail server hostname, or a single misconfigured nameserver can be the first thread that unravels an entire assessment.</p>

    <p>The instinct to check the boring public records before reaching for anything more advanced is what separates thorough reconnaissance from guesswork, and it is a habit worth building early.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>WHOIS records expose registrar, ownership, and registration dates, though privacy services often redact personal details.</li>
        <li>A, MX, NS, TXT, CNAME, and PTR records each answer a different question about a domain's infrastructure.</li>
        <li>A zone transfer replicates an entire zone between nameservers and must never be accepted from unauthorized requesters.</li>
        <li>Brute force wordlists and certificate transparency logs both reveal subdomains without needing a zone transfer.</li>
        <li>Careful DNS and WHOIS enumeration often uncovers infrastructure attackers can pivot into later.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
