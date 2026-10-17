<?php
// digital-signatures-ca-operations.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'digital-signatures-ca-operations',
    'title'           => 'Digital Signatures & Certificate Authority Operations',
    'description'     => 'Learn how digital signatures work and how to operate a certificate authority, from issuance to compromise response.',
    'icon'            => 'fas fa-certificate',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Expert',
    'estimated_time'  => '75 minutes',
    'prerequisites'   => ['Basic PKI concepts', 'Understanding of public key cryptography', 'Familiarity with TLS'],
    'learning_objectives' => [
        'Explain what a digital signature mathematically guarantees',
        'Describe the structure and purpose of a CA hierarchy',
        'Issue certificates with the correct profile for a given use case',
        'Execute the correct order of operations during a CA compromise response',
        'Explain what Certificate Transparency does and does not guarantee',
        'Explain how ACME automates certificate issuance and how to design a low-burden enterprise CA',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/digital-signatures-ca-operations-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Digital Signatures Fundamentals'],
    ['id' => 'task3', 'title' => 'CA Hierarchy and Chain of Trust'],
    ['id' => 'task4', 'title' => 'Issuing Certificates for Different Use Cases'],
    ['id' => 'task5', 'title' => 'Cross-Signing and CA Compromise Response'],
    ['id' => 'task6', 'title' => 'Certificate Transparency'],
    ['id' => 'task7', 'title' => 'ACME and Enterprise CA Design'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'digital_signatures_ca_operations_progress',
    'instagram_takeaways'  => [
        '✓ What a digital signature actually guarantees',
        '✓ How a CA hierarchy limits blast radius',
        '✓ Issuing the right certificate for the right use case',
        '✓ Correct order of operations during a CA compromise',
        '✓ Certificate Transparency and ACME automation',
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
        ['id' => 'q1', 'text' => 'What key type does a signer use to create a digital signature?'],
        ['id' => 'q2', 'text' => 'What key type does a verifier use to check a digital signature?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What term describes a CA whose certificate is not signed by any other CA?'],
        ['id' => 'q4', 'text' => 'What type of CA actually issues end-entity certificates in most hierarchies?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What certificate extension specifies the purposes a certificate can be used for, such as TLS server or code signing?'],
        ['id' => 'q6', 'text' => 'What is the maximum validity period allowed for a publicly trusted TLS server certificate?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'When responding to a CA compromise, what should be revoked first, the intermediate or the leaf certificates?'],
        ['id' => 'q8', 'text' => 'What mechanism allows clients to check in real time whether a certificate has been revoked?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'What data structure do CT logs use to make entries publicly verifiable?'],
        ['id' => 'q10', 'text' => 'Does Certificate Transparency primarily provide prevention or detection of mis-issuance?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What ACME challenge type proves domain control by placing a file on a web server?'],
        ['id' => 'q12', 'text' => 'What ACME challenge type proves domain control using DNS records?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag from the CA Operations Console.'],
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
    <p>Every secure connection you make, every signed software update you install, and every encrypted email you send relies on a certificate authority somewhere having made a correct decision. Digital signatures prove that data came from a specific key holder and was not altered in transit, and certificate authorities are the organizations that vouch for who holds which key. When either piece breaks, trust on the internet breaks with it.</p>

    <p>By the end of this room you will be able to explain what a digital signature actually guarantees, structure a CA hierarchy that limits damage when something goes wrong, issue certificates with the correct profile for a given use case, and respond correctly to a CA compromise. A hands-on certificate authority console is included so you can practice issuing certificates exactly as a real CA operator would.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what a digital signature mathematically guarantees.</li>
        <li>Describe the structure and purpose of a CA hierarchy.</li>
        <li>Issue certificates with the correct profile for a given use case.</li>
        <li>Execute the correct order of operations during a CA compromise response.</li>
        <li>Explain what Certificate Transparency does and does not guarantee.</li>
        <li>Explain how ACME automates certificate issuance and how to design a low-burden enterprise CA.</li>
    </ul>
</div>
HTML;

// TASK 2: Digital Signatures Fundamentals
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>What a Signature Actually Proves</h2>

    <p>A digital signature is created with a private key and verified with the corresponding public key. This is the opposite direction of encryption for confidentiality, which is a common source of confusion. Signing does not hide the content of a message. It proves who created it and that it has not been altered.</p>

    <p>The signing process does not sign the entire document directly. It first runs the document through a cryptographic hash function, producing a fixed-length digest. That digest is what actually gets signed with the private key. Verification repeats the hash on the received document and checks it against the signature using the public key.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Misconception</h4>
        <p>Signing a document is not the same as encrypting it. A signed document can still be read by anyone. The signature only proves origin and integrity, not confidentiality.</p>
    </div>

    <h3>Signing vs Encryption</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Property</th>
                <th>Digital Signature</th>
                <th>Encryption</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Purpose</td>
                <td>Prove origin and integrity</td>
                <td>Protect confidentiality</td>
            </tr>
            <tr>
                <td>Key used to create output</td>
                <td>Sender's private key</td>
                <td>Recipient's public key</td>
            </tr>
            <tr>
                <td>Key used to reverse it</td>
                <td>Sender's public key (verify)</td>
                <td>Recipient's private key (decrypt)</td>
            </tr>
            <tr>
                <td>Who can read the content</td>
                <td>Anyone</td>
                <td>Only the intended recipient</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Sign vs verify pipeline
         Teaching purpose: show the learner that signing and verifying are two
         distinct pipelines using opposite keys, which they would otherwise
         misunderstand as a single symmetric-like operation. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Signing and verification pipelines">
            <!-- Signing pipeline -->
            <text x="20" y="25" font-size="13" font-weight="600" fill="var(--text-primary)">Signing (sender)</text>
            <rect x="20" y="35" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="65" text-anchor="middle" font-size="12" fill="var(--text-primary)">Document</text>
            <line x1="140" y1="60" x2="185" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <rect x="190" y="35" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="250" y="60" text-anchor="middle" font-size="12" fill="var(--text-primary)">Hash</text>
            <text x="250" y="76" text-anchor="middle" font-size="10" fill="var(--text-secondary)">function</text>
            <line x1="310" y1="60" x2="355" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <rect x="360" y="35" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="430" y="58" text-anchor="middle" font-size="12" fill="var(--text-primary)">Sign digest</text>
            <text x="430" y="74" text-anchor="middle" font-size="10" fill="var(--text-secondary)">with private key</text>
            <line x1="500" y1="60" x2="545" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <rect x="550" y="35" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="640" y="65" text-anchor="middle" font-size="12" fill="var(--text-primary)">Document + Signature</text>

            <!-- Verification pipeline -->
            <text x="20" y="130" font-size="13" font-weight="600" fill="var(--text-primary)">Verification (recipient)</text>
            <rect x="20" y="140" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="170" text-anchor="middle" font-size="12" fill="var(--text-primary)">Document + Signature</text>
            <line x1="200" y1="165" x2="245" y2="165" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <rect x="250" y="140" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="320" y="163" text-anchor="middle" font-size="12" fill="var(--text-primary)">Verify with</text>
            <text x="320" y="179" text-anchor="middle" font-size="10" fill="var(--text-secondary)">sender's public key</text>
            <line x1="390" y1="165" x2="435" y2="165" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <rect x="440" y="140" width="160" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="520" y="163" text-anchor="middle" font-size="12" fill="var(--text-primary)">Match confirmed</text>
            <text x="520" y="179" text-anchor="middle" font-size="10" fill="var(--text-secondary)">origin and integrity proven</text>

            <defs>
                <marker id="arr1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: CA Hierarchy and Chain of Trust
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Why No CA Issues Directly From the Root</h2>

    <p>A certificate authority hierarchy exists to limit the damage a single compromised key can cause. Think of a national passport office that never stamps a passport itself. Instead it authorizes regional offices to issue passports on its behalf, and can revoke that authorization if a regional office is compromised, without shutting down the entire national system.</p>

    <p>The root CA sits at the top of the hierarchy and is kept offline, often in a physical vault, used only rarely to sign new intermediate CA certificates. Intermediate CAs sit below the root and do the actual day to day work of issuing end-entity certificates to servers, users, and devices. A chain of trust is the sequence of certificates from a leaf certificate up through its intermediate to the root, and every link in that chain must validate for a certificate to be trusted.</p>

    <!-- SVG: Root/intermediate/leaf tree
         Teaching purpose: show the learner that certificates flow downward
         through intermediates, which they would otherwise misunderstand as
         the root signing end-entity certificates directly. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 240" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="CA hierarchy tree">
            <rect x="270" y="10" width="160" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="33" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Root CA</text>
            <text x="350" y="49" text-anchor="middle" font-size="10" fill="var(--text-secondary)">offline, rarely used</text>

            <line x1="350" y1="65" x2="180" y2="110" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="350" y1="65" x2="520" y2="110" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <rect x="100" y="115" width="160" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="180" y="138" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Intermediate CA</text>
            <text x="180" y="154" text-anchor="middle" font-size="10" fill="var(--text-secondary)">e.g. TLS issuing</text>

            <rect x="440" y="115" width="160" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="520" y="138" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Intermediate CA</text>
            <text x="520" y="154" text-anchor="middle" font-size="10" fill="var(--text-secondary)">e.g. code signing</text>

            <line x1="180" y1="170" x2="90" y2="210" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="180" y1="170" x2="270" y2="210" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <rect x="20" y="215" width="140" height="20" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <text x="90" y="229" text-anchor="middle" font-size="10" fill="var(--text-primary)">Leaf: web server</text>

            <rect x="200" y="215" width="140" height="20" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <text x="270" y="229" text-anchor="middle" font-size="10" fill="var(--text-primary)">Leaf: API server</text>

            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Why Keep the Root Offline</h4>
        <p>If an intermediate CA is compromised, you revoke that one intermediate and everything under it, while the root and every other branch of the hierarchy remain trustworthy. If the root itself were used daily and got compromised, the entire hierarchy would need to be rebuilt.</p>
    </div>
</div>
HTML;

// TASK 4: Issuing Certificates for Different Use Cases
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>One Certificate Type Does Not Fit All</h2>

    <p>Not every certificate serves the same purpose, and issuing the wrong type of certificate for a use case creates real security gaps. A certificate meant to authenticate a web server should never be usable to sign software, and a certificate meant to sign email should never be trusted to authenticate a VPN client. This is enforced through certificate profiles.</p>

    <p>Two extensions do most of the work here. Key Usage defines low level cryptographic operations the key is allowed to perform, such as digital signature or key encipherment. Extended Key Usage narrows this further into specific application purposes, such as TLS server authentication, code signing, or email protection. You will issue certificates against exactly these profiles in the practical for this room.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Consequence of the Wrong Profile</h4>
        <p>Issuing a code signing certificate from a TLS issuing intermediate, or granting a client authentication certificate TLS server rights it never needed, expands what a compromised key can be used for. Profiles exist to keep that blast radius as small as possible.</p>
    </div>

    <h3>Certificate Profiles by Use Case</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Use Case</th>
                <th>Extended Key Usage</th>
                <th>Typical Validity</th>
                <th>Key Usage Flags</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TLS web server</td>
                <td>Server Authentication</td>
                <td>397 days</td>
                <td>Digital Signature, Key Encipherment</td>
            </tr>
            <tr>
                <td>Code signing</td>
                <td>Code Signing</td>
                <td>1 to 3 years</td>
                <td>Digital Signature</td>
            </tr>
            <tr>
                <td>Email S/MIME</td>
                <td>Email Protection</td>
                <td>1 year</td>
                <td>Digital Signature, Key Encipherment</td>
            </tr>
            <tr>
                <td>Client authentication</td>
                <td>Client Authentication</td>
                <td>1 year</td>
                <td>Digital Signature</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 5: Cross-Signing and CA Compromise Response
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When Trust Needs a Bridge, and When It Breaks</h2>

    <p>Cross-signing lets a new CA be trusted immediately by having an already trusted CA sign its certificate, in addition to the new CA's own self-signed root. This is common during root transitions, allowing a new root to be trusted by older devices that have not yet updated their trust stores, while newer devices trust the new root directly.</p>

    <p>Compromise response is different, and the order of operations matters enormously. When an intermediate CA's private key is compromised, every certificate that intermediate ever issued is suspect, because an attacker holding that key could have issued fraudulent certificates that were never logged anywhere you can see.</p>

    <!-- SVG: Correct compromise response sequence
         Teaching purpose: show the learner the correct order of incident response
         steps, which they would otherwise misunderstand as revoking leaf
         certificates first. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="CA compromise response sequence">
            <rect x="10" y="30" width="170" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="55" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">1. Revoke</text>
            <text x="95" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">compromised intermediate</text>

            <line x1="180" y1="60" x2="215" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>

            <rect x="220" y="30" width="170" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="305" y="55" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">2. Publish</text>
            <text x="305" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">updated CRL</text>

            <line x1="390" y1="60" x2="425" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>

            <rect x="430" y="30" width="170" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="515" y="55" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">3. Update</text>
            <text x="515" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">OCSP responders</text>

            <line x1="600" y1="60" x2="635" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>

            <rect x="640" y="30" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="700" y="55" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">4. Notify</text>
            <text x="700" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">relying parties</text>

            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <p>Revoking the intermediate itself, rather than working through its leaf certificates one at a time, immediately invalidates every certificate beneath it in one action, including any fraudulent ones you do not yet know exist.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Real-World Case</h4>
        <p>The 2011 compromise of the Dutch CA DigiNotar led to fraudulent certificates being issued for major domains, and ultimately to DigiNotar being removed from every major browser's trust store entirely.</p>
    </div>
</div>
HTML;

// TASK 6: Certificate Transparency
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Making Mis-Issuance Impossible to Hide</h2>

    <p>Certificate Transparency, or CT, requires every publicly trusted certificate to be recorded in a public, append-only log before browsers will trust it. This does not stop a CA from mis-issuing a certificate. What it does is guarantee that if one is issued, a public record of it exists forever, where anyone can find it.</p>

    <p>CT logs use a Merkle tree structure, where each new entry is hashed together with previous entries to produce a single root hash. This makes it computationally infeasible to alter or remove a past entry without changing that root hash, which is publicly auditable. When a certificate is submitted, the log returns a Signed Certificate Timestamp, or SCT, proving the certificate was logged.</p>

    <!-- SVG: Simplified CT log flow
         Teaching purpose: show the learner that CT logging happens before trust
         is granted and produces a public record, which they would otherwise
         misunderstand as a mechanism that actively blocks mis-issuance. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Certificate transparency logging flow">
            <rect x="10" y="30" width="160" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90" y="53" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">CA issues cert</text>
            <text x="90" y="69" text-anchor="middle" font-size="10" fill="var(--text-secondary)">submitted to CT log</text>

            <line x1="170" y1="57" x2="215" y2="57" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>

            <rect x="220" y="30" width="180" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="310" y="53" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Log appends entry</text>
            <text x="310" y="69" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Merkle tree updated</text>

            <line x1="400" y1="57" x2="445" y2="57" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>

            <rect x="450" y="30" width="240" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="570" y="53" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Monitors and browsers</text>
            <text x="570" y="69" text-anchor="middle" font-size="10" fill="var(--text-secondary)">can detect unexpected certs</text>

            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Monitor Your Own Domains</h4>
        <p>Organizations can and should run their own CT monitoring to detect certificates issued for their domains that they never requested, which is often the first sign of a mis-issuance or a compromised account with a CA.</p>
    </div>
</div>
HTML;

// TASK 7: ACME and Enterprise CA Design
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Automating Trust Without Losing Control</h2>

    <p>ACME, the protocol behind Let's Encrypt, automates certificate issuance by having the CA challenge the requester to prove control over the domain before issuing a certificate. This replaced a world of manual CSR submission and email-based validation with a process that can run entirely unattended, which is a major reason short-lived certificates became practical at scale.</p>

    <p>ACME supports several challenge types depending on how domain control is proven. Choosing the right challenge type matters for automation, since some require web server access while others work through DNS providers with API access, useful for wildcard certificates or servers with no public web presence.</p>

    <h3>ACME Challenge Types</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Challenge Type</th>
                <th>What It Proves</th>
                <th>Typical Use</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HTTP-01</td>
                <td>Control of a web server on the domain</td>
                <td>Standard web servers with port 80 access</td>
            </tr>
            <tr>
                <td>DNS-01</td>
                <td>Control of the domain's DNS records</td>
                <td>Wildcard certificates, servers with no public HTTP</td>
            </tr>
            <tr>
                <td>TLS-ALPN-01</td>
                <td>Control of a TLS server on port 443</td>
                <td>Environments where port 80 is unavailable</td>
            </tr>
        </tbody>
    </table>

    <p>Designing an internal enterprise CA follows the same principle as the public web, applied internally. A single monolithic internal CA issuing every certificate type creates a single point of failure and an unmanageable trust burden. Scoping intermediates by purpose, automating renewal wherever possible, and keeping certificate lifetimes short all reduce how much damage any single compromised key can cause.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Enterprise CA Design Principles</h4>
        <p>Scope each intermediate to one purpose, automate issuance and renewal through ACME or an equivalent internal protocol wherever possible, keep certificate lifetimes as short as operationally reasonable, and keep the root offline and rarely touched.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have been given access to the Example Corp Certificate Authority Operations Console. A queue of certificate signing requests is waiting for review, each one requesting a different type of certificate for a different purpose across the organization.</p>

    <p>Review each request carefully, select the correct intermediate CA, certificate profile, and validity period, and issue it. An incorrect combination will be rejected with an explanation so you can correct it. Process every request correctly to reveal the flag in the operations log.</p>

    <div class="practical-launch-wrapper">
        <a href="digital-signatures-ca-operations-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch CA Operations Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You now understand how digital signatures prove origin and integrity, how a CA hierarchy limits the damage a single compromised key can cause, and how certificate profiles keep each certificate scoped to its intended purpose. You also know the correct order of operations when an intermediate CA is compromised, what Certificate Transparency actually guarantees, and how ACME automation makes short-lived certificates practical at scale.</p>

    <p>These are the same decisions real CA operators and PKI engineers make every day, whether running a public CA or designing an internal one for an enterprise that needs strong trust without an unmanageable operational burden.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>A digital signature is created with a private key and verified with a public key, proving origin and integrity, not confidentiality.</li>
        <li>Keeping the root CA offline and issuing through scoped intermediates limits the blast radius of any single compromise.</li>
        <li>Certificate profiles enforce that a certificate can only be used for its intended purpose.</li>
        <li>During a CA compromise, revoke the intermediate first, then update CRLs and OCSP, then notify relying parties.</li>
        <li>Certificate Transparency provides public detection of mis-issuance, not prevention of it.</li>
        <li>ACME automation and short certificate lifetimes reduce operational burden while keeping trust manageable.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
