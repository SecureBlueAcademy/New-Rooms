<?php
// dns-security-engineering.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'dns-security-engineering',
    'title'           => 'DNS Security Engineering',
    'description'     => 'Learn how DNSSEC, DoH/DoT, RPZ, and split-horizon architecture turn DNS into a security control surface, and how attackers abuse DNS for command and control and data exfiltration.',
    'icon'            => 'fas fa-server',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic DNS resolution concepts', 'Basic networking and firewall concepts'],
    'learning_objectives' => [
        'Explain how attackers abuse DNS for command and control and data exfiltration',
        'Describe how DNSSEC establishes a chain of trust for DNS responses',
        'Compare DNS over HTTPS and DNS over TLS and their visibility tradeoffs',
        'Explain how Response Policy Zones enforce DNS-layer blocking',
        'Describe how split-horizon DNS reduces external reconnaissance surface',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/dns-security-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'DNS as an Attack Surface'],
    ['id' => 'task3', 'title' => 'DNSSEC Fundamentals'],
    ['id' => 'task4', 'title' => 'Encrypting DNS: DoH and DoT'],
    ['id' => 'task5', 'title' => 'RPZ: Response Policy Zones'],
    ['id' => 'task6', 'title' => 'Split Horizon DNS Architecture'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'dns_security_engineering_progress',
    'instagram_takeaways'  => [
        '✓ DNS is a plaintext, often unmonitored attack surface',
        '✓ DNSSEC builds a chain of trust to stop spoofing',
        '✓ DoH and DoT encrypt DNS, but change enterprise visibility',
        '✓ RPZ turns a resolver into a policy enforcement point',
        '✓ Split horizon DNS hides internal infrastructure from attackers',
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
        ['id' => 'q1', 'text' => 'What term describes malware generating many random looking domain names to reach its command and control server?'],
        ['id' => 'q2', 'text' => 'What is the term for hiding stolen data inside DNS queries to smuggle it out of a network?'],
        ['id' => 'q3', 'text' => 'What port does DNS traditionally use, which is often left open on firewalls?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What DNSSEC record type contains the digital signature used to validate a response?'],
        ['id' => 'q5', 'text' => 'Does DNSSEC primarily verify the authenticity or the confidentiality of a DNS response? (one word)'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What port does DNS over TLS (DoT) use?'],
        ['id' => 'q7', 'text' => 'What protocol encrypts DNS queries by tunneling them inside HTTPS traffic? (acronym)'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What does the acronym RPZ stand for? (three words)'],
        ['id' => 'q9', 'text' => 'What action does RPZ take against a known malicious domain query? (one word)'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What is the term for a DNS setup that returns different answers depending on whether a query comes from inside or outside the network?'],
        ['id' => 'q11', 'text' => 'What is hidden from external users in a split horizon DNS setup? (two words)'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Enter the flag revealed after neutralizing all threats in the DNS Firewall Console.'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every time a device looks up a website, connects to a cloud service, or checks for updates, it relies on DNS to translate a name into an address. That makes DNS one of the most heavily used protocols on any network, and one of the most overlooked when it comes to security. Attackers know this, and they routinely use DNS to smuggle stolen data out of networks and to keep malware in contact with its controllers, often through traffic that looks completely ordinary.</p>

    <p>This room treats DNS as a security control surface rather than just a lookup service. You will learn how DNSSEC authenticates responses, how DNS over HTTPS and DNS over TLS encrypt queries, how Response Policy Zones block known threats at the resolver, and how split-horizon architecture limits what attackers can learn from the outside. A hands-on practical lets you apply these ideas by operating a live DNS firewall console.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain how attackers abuse DNS for command and control and data exfiltration.</li>
        <li>Describe how DNSSEC establishes a chain of trust for DNS responses.</li>
        <li>Compare DNS over HTTPS and DNS over TLS and their visibility tradeoffs.</li>
        <li>Explain how Response Policy Zones enforce DNS-layer blocking.</li>
        <li>Describe how split-horizon DNS reduces external reconnaissance surface.</li>
    </ul>
</div>
HTML;

// TASK 2: DNS as an Attack Surface
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Why DNS Is a Security Problem</h2>

    <p>DNS was designed in an era when trust was assumed rather than verified. Queries and responses travel in plaintext, resolvers rarely question who is asking, and most firewalls allow DNS traffic through by default so ordinary browsing keeps working. That combination makes DNS an attractive channel for attackers who already have a foothold inside a network.</p>

    <p>Two techniques stand out. The first is using DNS as a command and control channel: malware generates a stream of domain names, often through a Domain Generation Algorithm (DGA), and contacts whichever ones happen to be registered by the attacker. The second is DNS tunneling, where stolen data is encoded into the subdomain portion of a query and sent out one lookup at a time.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Oversight</h4>
        <p>Port 53 is frequently left open on outbound firewall rules because blocking it breaks normal browsing. Attackers rely on exactly this assumption.</p>
    </div>

    <h3>Legitimate vs Malicious DNS Use</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>Legitimate DNS Use</th>
                <th>Malicious DNS Use</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Domain naming</td>
                <td>Human readable, registered, stable</td>
                <td>Random or algorithmically generated, short lived</td>
            </tr>
            <tr>
                <td>Query volume</td>
                <td>Occasional, tied to user activity</td>
                <td>Frequent, automated, constant beaconing</td>
            </tr>
            <tr>
                <td>Subdomain content</td>
                <td>Short, descriptive labels</td>
                <td>Long, encoded looking strings carrying data</td>
            </tr>
            <tr>
                <td>Purpose</td>
                <td>Resolve a name to an address</td>
                <td>Reach a controller or move stolen data</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: DNS exfiltration bypassing a firewall
         Teaching purpose: show that DNS traffic still flows even when other ports
         are blocked, which learners would otherwise assume firewalls fully stop. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="DNS exfiltration through a firewall that blocks other ports">
            <!-- Internal host -->
            <rect x="20" y="70" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90" y="105" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Infected Host</text>

            <!-- Firewall -->
            <rect x="300" y="30" width="160" height="140" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Firewall</text>
            <text x="380" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Blocks most ports</text>
            <text x="380" y="110" text-anchor="middle" font-size="11" fill="var(--success)">Allows port 53</text>

            <!-- External attacker server -->
            <rect x="600" y="70" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="670" y="105" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attacker Server</text>

            <!-- Blocked path -->
            <line x1="160" y1="50" x2="300" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4 4"/>
            <text x="230" y="42" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Other ports: blocked</text>

            <!-- DNS path allowed -->
            <line x1="160" y1="100" x2="300" y2="100" stroke="var(--text-primary)" stroke-width="2" marker-end="url(#arr2)"/>
            <line x1="460" y1="100" x2="600" y2="100" stroke="var(--text-primary)" stroke-width="2" marker-end="url(#arr2)"/>
            <text x="530" y="90" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Port 53: allowed</text>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-primary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: DNSSEC Fundamentals
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Proving a DNS Response Is Authentic</h2>

    <p>Without protection, a resolver has no way to know whether a DNS response actually came from the real authoritative server or was forged along the way. This gap allows cache poisoning, where an attacker plants a fake record that redirects users to a malicious address while the domain name looks completely normal.</p>

    <p>DNSSEC solves this with digital signatures rather than encryption. Each zone signs its own records, and each level of the DNS hierarchy vouches for the level below it, forming a chain of trust from the root down to the specific domain being resolved.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>DNSSEC proves a response has not been tampered with. It does not hide the response from anyone watching the network.</p>
    </div>

    <h3>Core DNSSEC Record Types</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Record Type</th>
                <th>Plain Language Purpose</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>DNSKEY</strong></td>
                <td>Holds the public key a zone uses to sign its records.</td>
            </tr>
            <tr>
                <td><strong>RRSIG</strong></td>
                <td>The digital signature attached to a set of records, checked against the DNSKEY.</td>
            </tr>
            <tr>
                <td><strong>DS</strong></td>
                <td>Placed in the parent zone, it vouches for the child zone's DNSKEY, extending the chain of trust.</td>
            </tr>
            <tr>
                <td><strong>NSEC</strong></td>
                <td>Proves a name does not exist, so an attacker cannot fake an empty response either.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: DNSSEC chain of trust
         Teaching purpose: show validation is a chain of checks across levels,
         which learners would otherwise misunderstand as one single blanket check. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="DNSSEC chain of trust from root to zone">
            <rect x="10" y="30" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="30" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="590" y="30" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <line x1="170" y1="70" x2="295" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="460" y1="70" x2="585" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <text x="90" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Root Zone</text>
            <text x="90" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Vouches for TLD</text>

            <text x="380" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">TLD Zone</text>
            <text x="380" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Vouches for domain</text>

            <text x="670" y="65" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Domain Zone</text>
            <text x="670" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Signs its own records</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Encrypting DNS - DoH and DoT
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Keeping DNS Queries Private</h2>

    <p>DNSSEC proves a response is authentic, but the query and response still travel in plaintext by default. Anyone positioned on the network path, from a coffee shop router to an internet service provider, can see exactly which domains a device is resolving.</p>

    <p>Two protocols address this by encrypting DNS traffic. DNS over TLS (DoT) wraps DNS queries in TLS encryption on a dedicated port. DNS over HTTPS (DoH) goes further and tunnels DNS inside ordinary HTTPS traffic, making it far harder to tell apart from normal web browsing.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Enterprise Tradeoff</h4>
        <p>Because DoH blends in with regular web traffic on port 443, it can bypass corporate DNS filtering and RPZ policies unless the organization centrally manages or inspects it.</p>
    </div>

    <h3>DoT vs DoH</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Protocol</th>
                <th>Port</th>
                <th>Transport</th>
                <th>Enterprise Visibility Impact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>DNS (plaintext)</strong></td>
                <td>53</td>
                <td>UDP/TCP</td>
                <td>Fully visible and easy to monitor</td>
            </tr>
            <tr>
                <td><strong>DoT</strong></td>
                <td>853</td>
                <td>TLS</td>
                <td>Identifiable as DNS traffic on its own port, encrypted content</td>
            </tr>
            <tr>
                <td><strong>DoH</strong></td>
                <td>443</td>
                <td>HTTPS</td>
                <td>Blends with normal web traffic, hardest to distinguish</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: plaintext DNS vs DoT vs DoH paths
         Teaching purpose: show where encryption applies and why DoH is harder to inspect,
         which learners would otherwise assume is equivalent to DoT for network visibility. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Comparison of plaintext DNS, DoT, and DoH data paths">
            <text x="20" y="30" font-size="13" font-weight="600" fill="var(--text-primary)">Plaintext DNS (port 53)</text>
            <rect x="20" y="40" width="120" height="30" rx="6" fill="var(--surface)" stroke="var(--border)"/>
            <text x="80" y="60" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Client</text>
            <line x1="140" y1="55" x2="260" y2="55" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <rect x="260" y="40" width="140" height="30" rx="6" fill="var(--surface)" stroke="var(--border)"/>
            <text x="330" y="60" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Resolver (visible)</text>

            <text x="20" y="105" font-size="13" font-weight="600" fill="var(--text-primary)">DoT (port 853)</text>
            <rect x="20" y="115" width="120" height="30" rx="6" fill="var(--surface)" stroke="var(--border)"/>
            <text x="80" y="135" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Client</text>
            <line x1="140" y1="130" x2="260" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <rect x="260" y="115" width="140" height="30" rx="6" fill="var(--surface)" stroke="var(--border)"/>
            <text x="330" y="135" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Resolver (encrypted, identifiable)</text>

            <text x="20" y="180" font-size="13" font-weight="600" fill="var(--text-primary)">DoH (port 443)</text>
            <rect x="20" y="190" width="120" height="30" rx="6" fill="var(--surface)" stroke="var(--border)"/>
            <text x="80" y="210" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Client</text>
            <line x1="140" y1="205" x2="260" y2="205" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <rect x="260" y="190" width="140" height="30" rx="6" fill="var(--surface)" stroke="var(--border)"/>
            <text x="330" y="210" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Resolver (hidden in HTTPS)</text>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 5: RPZ
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Turning a Resolver Into a Firewall</h2>

    <p>Response Policy Zones, or RPZ, let a DNS resolver enforce security policy at the moment of resolution. Instead of returning the real answer for a known malicious domain, the resolver consults an RPZ feed, usually built from threat intelligence, and returns a blocked or redirected response instead.</p>

    <p>This connects directly back to the DGA and command and control problem from earlier. If malware tries to resolve a known-bad domain, RPZ can stop the connection before it ever leaves the network, without touching a single endpoint.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>RPZ does not have to hard block every match. Many organizations redirect blocked queries to an internal warning page instead, which helps with user awareness.</p>
    </div>

    <!-- SVG: RPZ intercepting a malicious query
         Teaching purpose: show RPZ acts at the resolution step itself,
         which learners would otherwise misunderstand as a separate, unrelated firewall layer. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="RPZ intercepting a malicious DNS query at the resolver">
            <rect x="20" y="60" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90" y="90" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Client Query</text>

            <rect x="300" y="20" width="180" height="120" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="390" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Resolver + RPZ</text>
            <text x="390" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Checks threat feed</text>
            <text x="390" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">before answering</text>

            <rect x="600" y="20" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="675" y="50" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Blocked response</text>

            <rect x="600" y="90" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="675" y="120" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Real answer if clean</text>

            <line x1="160" y1="85" x2="295" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="480" y1="55" x2="595" y2="45" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="480" y1="100" x2="595" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <p>In the practical that follows, you will operate a console just like this, deciding which incoming queries to block using RPZ.</p>
</div>
HTML;

// TASK 6: Split Horizon DNS
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Showing Different Answers to Different Audiences</h2>

    <p>Split-horizon DNS, also called split-brain DNS, serves different answers for the same domain name depending on where the query comes from. An internal employee resolving a company hostname might reach an internal server address, while someone querying from the public internet is given a different, public-facing address or nothing at all.</p>

    <p>This limits what an outside attacker can learn simply by querying DNS. Internal hostnames, internal service names, and internal IP ranges never need to be exposed externally, which shrinks the reconnaissance surface available before an attack even begins.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Worth Noting</h4>
        <p>Split horizon DNS reduces attack surface, but it adds operational complexity. Keeping internal and external zone views consistent requires careful maintenance to avoid configuration drift.</p>
    </div>

    <!-- SVG: internal vs external resolver views
         Teaching purpose: show that differing answers for the same name can be legitimate,
         which learners would otherwise misread as spoofing or misconfiguration. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Split horizon DNS returning different answers internally and externally">
            <rect x="280" y="15" width="200" height="40" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="40" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">app.company.com</text>

            <rect x="40" y="100" width="200" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="140" y="122" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Internal Query</text>
            <text x="140" y="140" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Returns internal address</text>

            <rect x="520" y="100" width="200" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="620" y="122" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">External Query</text>
            <text x="620" y="140" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Returns public address</text>

            <line x1="330" y1="55" x2="180" y2="98" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="430" y1="55" x2="600" y2="98" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You are operating the DNS Firewall Console for a company resolver. A live batch of recent DNS queries has been captured, and some of them are malware attempting DGA-style command and control callbacks or data exfiltration disguised as ordinary lookups.</p>

    <p>Review each query and decide whether to Block it using RPZ or Allow it to resolve normally. Blocking a legitimate domain by mistake causes real outages, so look for the same indicators covered earlier: entropy, unusual TLDs, and encoded-looking subdomains. Neutralize every threat to reveal the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="dns-security-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch DNS Firewall Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>DNS security engineering is not a single control but a layered strategy. DNSSEC proves responses are authentic, DoT and DoH protect queries from eavesdropping, RPZ enforces policy at the resolver, and split-horizon architecture limits what attackers can learn from the outside in the first place. Together these controls turn a service that was once assumed to be trustworthy by default into a deliberately engineered part of the security stack.</p>

    <p>The DGA and tunneling techniques you studied are still widely used today precisely because DNS is so easy to overlook. Recognizing those patterns, and knowing which control addresses which risk, is what separates a resolver that is merely running from one that is actively defending the network.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>DNS is plaintext and often unmonitored by default, making it attractive for command and control and exfiltration.</li>
        <li>DNSSEC authenticates DNS responses through a chain of trust, but does not encrypt them.</li>
        <li>DoT encrypts DNS on a dedicated port; DoH hides DNS inside HTTPS, complicating enterprise monitoring.</li>
        <li>RPZ lets a resolver block or redirect known malicious domains at the point of resolution.</li>
        <li>Split horizon DNS reduces external reconnaissance by serving different answers based on query origin.</li>
    </ul>
</div>
HTML;

// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
