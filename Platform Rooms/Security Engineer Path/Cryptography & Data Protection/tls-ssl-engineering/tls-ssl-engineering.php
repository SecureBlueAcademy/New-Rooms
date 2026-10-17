<?php
// Filename: tls-ssl-engineering.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'tls-ssl-engineering',
    'title'           => 'TLS/SSL Engineering',
    'description'     => 'Engineer resilient TLS configurations: handshake internals, certificate chain validation, mutual TLS, HSTS, OCSP stapling, and downgrade attack defenses.',
    'icon'            => 'fas fa-lock',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Expert',
    'estimated_time'  => '75 minutes',
    'prerequisites'   => ['Solid understanding of networking fundamentals', 'Basic public key cryptography concepts', 'Familiarity with HTTP and the OSI model'],
    'learning_objectives' => [
        'Explain the differences between TLS 1.2 and TLS 1.3 handshakes and cipher suite negotiation',
        'Validate a certificate chain and identify broken trust links',
        'Explain how mutual TLS authenticates both client and server',
        'Describe HSTS and OCSP stapling and their security purpose',
        'Identify and mitigate downgrade attacks such as BEAST and POODLE',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/tls-ssl-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'TLS 1.2 vs TLS 1.3: The Handshake Reengineered'],
    ['id' => 'task3', 'title' => 'Certificate Chain Validation'],
    ['id' => 'task4', 'title' => 'Mutual TLS for Service-to-Service Authentication'],
    ['id' => 'task5', 'title' => 'HSTS and HPKP'],
    ['id' => 'task6', 'title' => 'OCSP Stapling'],
    ['id' => 'task7', 'title' => 'Downgrade Attacks and Certificate Substitution'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'tls_ssl_engineering_progress',
    'instagram_takeaways'  => [
        '✓ TLS 1.3 cuts handshake round trips and drops static RSA key exchange',
        '✓ Certificate chains validate from leaf up to a trusted root',
        '✓ Mutual TLS authenticates both client and server, not just the server',
        '✓ HSTS and OCSP stapling harden real-world TLS deployments',
        '✓ Downgrade attacks like POODLE exploit legacy protocol fallback',
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
        ['id' => 'q1', 'text' => 'Which TLS 1.2 handshake message is eliminated in TLS 1.3?'],
        ['id' => 'q2', 'text' => 'What property of ECDHE key exchange does static RSA key exchange lack?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the term for the topmost, self-signed certificate in a chain of trust?'],
        ['id' => 'q4', 'text' => 'What is the general term for the CA-issued certificate positioned between the leaf and root certificate?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'In mutual TLS, which additional certificate is presented compared to standard TLS?'],
        ['id' => 'q6', 'text' => 'What security model commonly uses mTLS to authenticate services to each other?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What HTTP header forces browsers to only connect over HTTPS?'],
        ['id' => 'q8', 'text' => 'What certificate pinning mechanism has been deprecated and removed from modern browsers?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What protocol is used to check whether a certificate has been revoked?'],
        ['id' => 'q10', 'text' => 'What is the term for a server attaching a pre-fetched OCSP response to its TLS handshake?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What downgrade attack exploits a padding oracle vulnerability in SSLv3?'],
        ['id' => 'q12', 'text' => 'What TLS extension prevents protocol downgrade attacks by signaling a fallback attempt?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the TLS Handshake Inspector.'],
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
    <p>TLS secures nearly every sensitive connection on the internet today, from HTTPS traffic and mobile app APIs to internal service-to-service calls inside a data center. A single misconfiguration, an outdated cipher suite, a broken certificate chain, or a fallback to a legacy protocol, has been the root cause of real breaches and well known attacks like POODLE and BEAST.</p>

    <p>By the end of this room you will be able to engineer a TLS configuration that resists downgrade and certificate substitution attacks, validate a certificate chain by hand, and explain how mutual TLS authenticates both sides of a connection. A hands-on handshake dissection lab is included so you can see the protocol details you have just learned in action.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the differences between TLS 1.2 and TLS 1.3 handshakes and cipher suite negotiation.</li>
        <li>Validate a certificate chain and identify broken trust links.</li>
        <li>Explain how mutual TLS authenticates both client and server.</li>
        <li>Describe HSTS and OCSP stapling and their security purpose.</li>
        <li>Identify and mitigate downgrade attacks such as BEAST and POODLE.</li>
    </ul>
</div>
HTML;

// TASK 2: TLS 1.2 vs TLS 1.3
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Handshakes, One Goal</h2>

    <p>Every TLS session begins with a handshake: a negotiation where the client and server agree on a protocol version, a cipher suite, and a shared secret before any application data is exchanged. TLS 1.2 and TLS 1.3 both accomplish this, but TLS 1.3 does it in fewer steps and with fewer opportunities for a weak configuration to slip through.</p>

    <p>In TLS 1.2, the server can choose from a wide menu of cipher suites, including some that are no longer considered safe. TLS 1.3 removes that risk at the protocol level by deleting the weakest options entirely, including static RSA key exchange and any cipher suite without forward secrecy.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Static RSA key exchange lets an attacker who later steals the server's private key decrypt every past session that used it. ECDHE style exchanges generate a fresh key for each session, so a single stolen key cannot unlock past traffic. This property is called forward secrecy.</p>
    </div>

    <!-- SVG: TLS 1.2 vs TLS 1.3 handshake sequence
         Teaching purpose: show the learner that TLS 1.3 removes round trips and messages,
         which they would otherwise misread as just a version number increment. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 420" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="TLS 1.2 versus TLS 1.3 handshake comparison">
            <!-- Column headers -->
            <text x="170" y="30" text-anchor="middle" font-size="16" font-weight="700" fill="var(--text-primary)">TLS 1.2</text>
            <text x="530" y="30" text-anchor="middle" font-size="16" font-weight="700" fill="var(--text-primary)">TLS 1.3</text>

            <!-- TLS 1.2 message boxes -->
            <g font-size="12" fill="var(--text-primary)">
                <rect x="60" y="50"  width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="170" y="71" text-anchor="middle">ClientHello (cipher list)</text>

                <rect x="60" y="100" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="170" y="121" text-anchor="middle">ServerHello (cipher chosen)</text>

                <rect x="60" y="150" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="170" y="171" text-anchor="middle">Certificate</text>

                <rect x="60" y="200" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="170" y="221" text-anchor="middle">ServerKeyExchange</text>

                <rect x="60" y="250" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="170" y="271" text-anchor="middle">ClientKeyExchange</text>

                <rect x="60" y="300" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="170" y="321" text-anchor="middle">Finished (both sides)</text>
            </g>
            <line x1="170" y1="84" x2="170" y2="100" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="170" y1="134" x2="170" y2="150" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="170" y1="184" x2="170" y2="200" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="170" y1="234" x2="170" y2="250" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="170" y1="284" x2="170" y2="300" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="170" y="360" text-anchor="middle" font-size="12" fill="var(--text-secondary)">2 round trips before data</text>

            <!-- TLS 1.3 message boxes -->
            <g font-size="12" fill="var(--text-primary)">
                <rect x="420" y="50"  width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="530" y="71" text-anchor="middle">ClientHello + key_share</text>

                <rect x="420" y="100" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="530" y="121" text-anchor="middle">ServerHello + key_share</text>

                <rect x="420" y="150" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="530" y="171" text-anchor="middle">Encrypted Extensions</text>

                <rect x="420" y="200" width="220" height="34" rx="6" fill="var(--surface)" stroke="var(--border)"/>
                <text x="530" y="221" text-anchor="middle">Certificate + Finished</text>
            </g>
            <line x1="530" y1="84" x2="530" y2="100" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="530" y1="134" x2="530" y2="150" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="530" y1="184" x2="530" y2="200" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="530" y="360" text-anchor="middle" font-size="12" fill="var(--text-secondary)">1 round trip before data</text>
        </svg>
    </div>

    <h3>Cipher Suite Components</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Component</th>
                <th>TLS 1.2 example</th>
                <th>TLS 1.3 example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Key exchange</td>
                <td>ECDHE or static RSA</td>
                <td>ECDHE only</td>
            </tr>
            <tr>
                <td>Authentication</td>
                <td>RSA or ECDSA signature</td>
                <td>RSA or ECDSA signature</td>
            </tr>
            <tr>
                <td>Bulk encryption</td>
                <td>AES-CBC or AES-GCM</td>
                <td>AES-GCM or ChaCha20</td>
            </tr>
            <tr>
                <td>MAC / integrity</td>
                <td>HMAC-SHA</td>
                <td>Built into AEAD cipher</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 3: Certificate Chain Validation
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Following the Chain of Trust</h2>

    <p>A TLS certificate is rarely trusted on its own. It is validated as part of a chain: the server's leaf certificate is signed by an intermediate certificate authority, and that intermediate is signed by a root certificate authority that already lives in the client's trust store. Validation walks upward from the leaf to a trusted root, not the other way around.</p>

    <p>Each certificate in the chain contains a Subject field, identifying who the certificate belongs to, and an Issuer field, identifying who signed it. A valid chain forms an unbroken line where each certificate's Issuer matches the Subject of the certificate above it, ending at a root the client already trusts.</p>

    <!-- SVG: certificate chain of trust
         Teaching purpose: show the learner that validation flows upward from leaf to root,
         which they otherwise often assume flows downward from the root. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 500 320" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Certificate chain of trust">
            <rect x="150" y="230" width="200" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="250" y="255" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Leaf Certificate</text>
            <text x="250" y="273" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Subject: example.com</text>

            <rect x="150" y="140" width="200" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="250" y="165" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Intermediate CA</text>
            <text x="250" y="183" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Issues leaf certs</text>

            <rect x="150" y="50" width="200" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="250" y="75" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Root Certificate</text>
            <text x="250" y="93" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Self-signed, in trust store</text>

            <line x1="250" y1="230" x2="250" y2="200" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrup)"/>
            <line x1="250" y1="140" x2="250" y2="110" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrup)"/>
            <defs>
                <marker id="arrup" markerWidth="8" markerHeight="8" refX="4" refY="0" orient="auto">
                    <path d="M0,6 L4,0 L8,6 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="250" y="300" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Validation walks upward: leaf, then intermediate, then trusted root</text>
        </svg>
    </div>

    <h3>Common Chain Failures</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Failure type</th>
                <th>Cause</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Expired certificate</td>
                <td>Current date falls outside the certificate's validity window</td>
            </tr>
            <tr>
                <td>Missing intermediate</td>
                <td>Server fails to send the intermediate certificate needed to reach the root</td>
            </tr>
            <tr>
                <td>Untrusted root</td>
                <td>Root certificate authority is not present in the client's trust store</td>
            </tr>
            <tr>
                <td>Subject mismatch</td>
                <td>Issuer field of one certificate does not match the Subject of the certificate above it</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Mistake</h4>
        <p>Serving an incomplete chain, a leaf certificate without its intermediate, is one of the most frequent real-world TLS misconfigurations. Some browsers tolerate it by fetching the missing intermediate themselves, but many clients will simply fail the connection.</p>
    </div>
</div>
HTML;

// TASK 4: Mutual TLS
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Authenticating Both Sides of the Connection</h2>

    <p>Standard TLS only authenticates the server. The client verifies the server's certificate, but the server has no cryptographic proof of who the client is. Mutual TLS, often written mTLS, closes that gap by having the client present its own certificate during the handshake, so both sides authenticate each other.</p>

    <p>This matters most in service-to-service communication, where there is no human typing a password. A payment service calling an inventory service needs a way to prove its identity that does not rely on a shared secret sitting in a config file. mTLS provides that proof using the same certificate infrastructure already used for standard TLS.</p>

    <!-- SVG: standard TLS versus mTLS
         Teaching purpose: show the learner that mTLS adds a certificate exchange in the
         client to server direction, which they often mistake for just "extra secure regular TLS." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Standard TLS versus mutual TLS">
            <text x="170" y="30" text-anchor="middle" font-size="15" font-weight="700" fill="var(--text-primary)">Standard TLS</text>
            <rect x="40" y="60" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="100" y="90" text-anchor="middle" font-size="12" fill="var(--text-primary)">Client</text>
            <rect x="220" y="60" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="280" y="90" text-anchor="middle" font-size="12" fill="var(--text-primary)">Server</text>
            <line x1="220" y1="85" x2="165" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrleft)"/>
            <text x="192" y="75" text-anchor="middle" font-size="10" fill="var(--text-secondary)">server cert</text>
            <defs>
                <marker id="arrleft" markerWidth="8" markerHeight="8" refX="0" refY="3" orient="auto">
                    <path d="M8,0 L8,6 L0,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arrright" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <text x="530" y="30" text-anchor="middle" font-size="15" font-weight="700" fill="var(--text-primary)">Mutual TLS</text>
            <rect x="400" y="60" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="460" y="90" text-anchor="middle" font-size="12" fill="var(--text-primary)">Client</text>
            <rect x="580" y="60" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="640" y="90" text-anchor="middle" font-size="12" fill="var(--text-primary)">Server</text>
            <line x1="580" y1="80" x2="525" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrleft)"/>
            <text x="552" y="70" text-anchor="middle" font-size="10" fill="var(--text-secondary)">server cert</text>
            <line x1="525" y1="100" x2="580" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrright)"/>
            <text x="552" y="118" text-anchor="middle" font-size="10" fill="var(--text-secondary)">client cert</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Where mTLS Shows Up</h4>
        <p>mTLS is commonly enforced at API gateways and inside service mesh sidecars, where every internal request must present a valid service identity certificate before it is allowed through.</p>
    </div>
</div>
HTML;

// TASK 5: HSTS and HPKP
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Forcing the Secure Path</h2>

    <p>HTTP Strict Transport Security, HSTS, is a response header that tells the browser to never connect to a site over plain HTTP again, for a specified length of time. Once a browser has seen the header, it rewrites any future HTTP request to that domain into HTTPS before it ever leaves the machine, closing the window an attacker could use to intercept an initial insecure request.</p>

    <p>HTTP Public Key Pinning, HPKP, tried to solve a related problem: pinning a site to a specific set of public keys so a browser would reject any certificate that did not match, even one issued by a legitimate certificate authority. It was removed from modern browsers because a misconfigured pin could permanently lock legitimate users out of a site with no recovery path.</p>

    <h3>HSTS vs HPKP</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>HSTS</th>
                <th>HPKP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Purpose</td>
                <td>Force HTTPS-only connections</td>
                <td>Pin trusted public keys for a domain</td>
            </tr>
            <tr>
                <td>Mechanism</td>
                <td>Strict-Transport-Security header with max-age</td>
                <td>Public-Key-Pins header listing key hashes</td>
            </tr>
            <tr>
                <td>Current status</td>
                <td>Active, widely deployed, supports preload lists</td>
                <td>Deprecated, removed from major browsers</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Historical Context</h4>
        <p>HPKP is covered here for historical understanding only. It should not be deployed on new systems. Certificate Transparency monitoring is the modern replacement for detecting unauthorized certificates.</p>
    </div>
</div>
HTML;

// TASK 6: OCSP Stapling
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Proving a Certificate Has Not Been Revoked</h2>

    <p>A certificate can be compromised or issued in error after it has already been trusted. The Online Certificate Status Protocol, OCSP, lets a client ask a certificate authority's responder whether a given certificate has been revoked. Traditionally, every client made this query on its own, which leaked browsing information to the certificate authority and slowed down every connection.</p>

    <p>OCSP stapling moves that query to the server. The server periodically fetches a signed, time-stamped OCSP response for its own certificate and staples it directly to the TLS handshake it sends to clients. The client gets the revocation proof without ever contacting the certificate authority itself.</p>

    <!-- SVG: OCSP stapling flow
         Teaching purpose: show the learner that the server queries the OCSP responder,
         not each client individually, which learners often assume happens client-side. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="OCSP stapling flow">
            <rect x="30" y="80" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="100" y="110" text-anchor="middle" font-size="12" fill="var(--text-primary)">Client</text>

            <rect x="280" y="80" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="350" y="110" text-anchor="middle" font-size="12" fill="var(--text-primary)">Server</text>

            <rect x="530" y="20" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)"/>
            <text x="605" y="50" text-anchor="middle" font-size="12" fill="var(--text-primary)">OCSP Responder</text>

            <line x1="420" y1="60" x2="525" y2="45" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4 3" marker-end="url(#arrright)"/>
            <text x="475" y="45" text-anchor="middle" font-size="10" fill="var(--text-secondary)">periodic query</text>
            <defs>
                <marker id="arrright" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <line x1="170" y1="105" x2="275" y2="105" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrright)"/>
            <text x="222" y="125" text-anchor="middle" font-size="10" fill="var(--text-secondary)">TLS handshake</text>

            <line x1="275" y1="118" x2="170" y2="118" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrleft2)"/>
            <text x="222" y="150" text-anchor="middle" font-size="10" fill="var(--text-secondary)">certificate + stapled OCSP response</text>
            <defs>
                <marker id="arrleft2" markerWidth="8" markerHeight="8" refX="0" refY="3" orient="auto">
                    <path d="M8,0 L8,6 L0,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Stapling removes an extra network round trip for the client and stops the certificate authority from learning which sites a given client is visiting, since the client never contacts the responder directly.</p>
    </div>
</div>
HTML;

// TASK 7: Downgrade Attacks and Certificate Substitution
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>When Compatibility Becomes a Weakness</h2>

    <p>Downgrade attacks trick a client and server into negotiating a weaker, older protocol version than both actually support, then exploit a known flaw in that older version. BEAST targeted a weakness in how TLS 1.0 used CBC mode ciphers, allowing an attacker who could inject traffic to recover parts of encrypted data. POODLE went further, exploiting a padding oracle in SSLv3 itself, and became widely used to force a downgrade from TLS down to the vulnerable SSLv3.</p>

    <p>Certificate substitution attacks work differently. Instead of exploiting a protocol flaw, an attacker positioned as a man in the middle presents their own certificate to the client. If the client fails to properly validate the chain, or trusts a certificate authority it should not, it may accept the attacker's certificate as legitimate.</p>

    <h3>Attack Reference</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Attack</th>
                <th>Vulnerable mechanism</th>
                <th>Mitigation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>BEAST</td>
                <td>CBC mode cipher chaining in TLS 1.0</td>
                <td>Disable TLS 1.0, prefer AEAD ciphers</td>
            </tr>
            <tr>
                <td>POODLE</td>
                <td>Padding oracle in SSLv3</td>
                <td>Disable SSLv3 entirely, enforce TLS 1.2+</td>
            </tr>
            <tr>
                <td>Protocol downgrade dance</td>
                <td>Server accepting a lower version than both sides support</td>
                <td>TLS_FALLBACK_SCSV to detect forced downgrades</td>
            </tr>
            <tr>
                <td>Certificate substitution</td>
                <td>Incomplete or lenient chain validation on the client</td>
                <td>Strict chain validation, certificate pinning where appropriate</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Engineering Trade-off</h4>
        <p>Enabling legacy protocol fallback for the sake of older client compatibility reopens the exact downgrade risk these attacks rely on. A hardened configuration enforces a minimum protocol version rather than negotiating down to accommodate outdated clients.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have access to a live capture of two TLS handshakes for the same server, one negotiated over TLS 1.2 and one over TLS 1.3. Your job is to inspect every message in both handshakes, spot the deprecated cipher suite hiding in the TLS 1.2 ClientHello, and identify the handshake message that TLS 1.3 removes entirely.</p>

    <p>Expand every message card in both columns to unlock the analysis quiz, then answer both questions correctly to reveal your flag.</p>

    <div class="practical-launch-wrapper">
        <a href="tls-ssl-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch TLS Handshake Inspector</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You have now worked through TLS from the handshake level up. TLS 1.3 trims the handshake to a single round trip and removes weak key exchange options outright, certificate chains validate upward from leaf to a trusted root, and mutual TLS extends that trust in both directions for service-to-service communication. HSTS, OCSP stapling, and strict protocol enforcement round out a configuration that resists downgrade and substitution attacks.</p>

    <p>These are not academic details. Every one of them maps to a real configuration flag on a real server, and getting them right is what separates a TLS deployment that merely works from one that is actually resilient under attack.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>TLS 1.3 removes static RSA key exchange and unnecessary round trips found in TLS 1.2.</li>
        <li>Certificate chains validate from the leaf certificate up to a trusted root.</li>
        <li>Mutual TLS authenticates the client as well as the server, using the same certificate infrastructure.</li>
        <li>HSTS prevents insecure HTTP connections; OCSP stapling proves revocation status without an extra client round trip.</li>
        <li>Downgrade attacks like POODLE exploit legacy protocol fallback, which strict minimum version enforcement prevents.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA. Engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
