<?php
// ============================================================
// mfa-engineering.php — CYBRIXEN ROOM DATA FILE
// Topic: Multi-Factor Authentication Engineering
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'mfa-engineering',
    'title'           => 'Multi-Factor Authentication Engineering',
    'description'     => 'Learn how TOTP, FIDO2/WebAuthn, push, hardware tokens, and SMS work, how attackers bypass them, and how to design a secure MFA rollout.',
    'icon'            => 'fas fa-key',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of authentication'],
    'learning_objectives' => [
        'Explain the three authentication factor categories and why combining them matters',
        'Describe how TOTP, FIDO2/WebAuthn, push, hardware tokens, and SMS each work',
        'Identify why SMS-based MFA is considered weak',
        'Explain MFA fatigue attacks, SIM swapping, and real-time phishing',
        'Design a conditional access policy and a low-friction MFA rollout',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/mfa-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is MFA & Authentication Factors'],
    ['id' => 'task3', 'title' => 'TOTP & Software-Based MFA'],
    ['id' => 'task4', 'title' => 'FIDO2/WebAuthn & Hardware Tokens'],
    ['id' => 'task5', 'title' => 'Push Notification & SMS'],
    ['id' => 'task6', 'title' => 'Bypass Attacks'],
    ['id' => 'task7', 'title' => 'Deployment & Conditional Access'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'mfa_engineering_progress',
    'instagram_takeaways'  => [
        '✓ The three authentication factor categories: know, have, are',
        '✓ How TOTP, FIDO2/WebAuthn, push, and hardware tokens work',
        '✓ Why SMS based MFA is considered weak',
        '✓ MFA fatigue, SIM swapping, and real time phishing',
        '✓ Designing conditional access policies and low friction rollouts',
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
        ['id' => 'q1', 'text' => 'What is the term for an authentication factor based on something you physically possess?'],
        ['id' => 'q2', 'text' => 'What is the term for an authentication factor based on a physical trait such as a fingerprint?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What does TOTP stand for?'],
        ['id' => 'q4', 'text' => 'What cryptographic function do TOTP codes commonly use to generate a code from the shared secret?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the modern passwordless credential used in FIDO2/WebAuthn commonly called?'],
        ['id' => 'q6', 'text' => 'What WebAuthn security property prevents a credential from being used on a fraudulent look alike site?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What attack technique lets an attacker intercept SMS codes by taking control of a victim\'s phone number?'],
        ['id' => 'q8', 'text' => 'What telecom signaling protocol has known vulnerabilities sometimes exploited to intercept SMS messages?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What is the term for bombarding a victim with push approval requests until one is accidentally approved?'],
        ['id' => 'q10', 'text' => 'What type of phishing attack uses a proxy to relay credentials and session tokens in real time?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What is the term for an account deliberately excluded from strict conditional access policies to prevent total lockout?'],
        ['id' => 'q12', 'text' => 'What is the term for requiring extra authentication only for high risk or privileged actions, rather than every login?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed by deploying all conditional access policies correctly.'],
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
    <p>Passwords alone have never been enough. A single leaked, guessed, or phished password hands an attacker full access to an account, and breach data consistently shows stolen credentials as one of the leading causes of unauthorized access. Multi-factor authentication exists to close that gap by requiring more than one piece of proof before granting access.</p>

    <p>By the end of this room you will understand how the major MFA methods actually work under the hood, including TOTP, FIDO2/WebAuthn, push notifications, hardware tokens, and SMS, why some of these are far stronger than others, and how attackers bypass the weaker ones. You will then apply this knowledge in a hands on practical where you configure conditional access policies for a company's login traffic.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the three authentication factor categories and why combining them matters.</li>
        <li>Describe how TOTP, FIDO2/WebAuthn, push, hardware tokens, and SMS each work.</li>
        <li>Identify why SMS based MFA is considered weak.</li>
        <li>Explain MFA fatigue attacks, SIM swapping, and real time phishing.</li>
        <li>Design a conditional access policy and a low friction MFA rollout.</li>
    </ul>
</div>
HTML;

// TASK 2: What is MFA & Authentication Factors
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Three Categories, Not Three Passwords</h2>
    <p>Multi-factor authentication requires proof from at least two different categories of evidence before granting access. Entering two passwords is not MFA, since both pieces of evidence come from the same category: something you know.</p>

    <p>Think of a bank vault that only opens when a manager enters a code, inserts a physical key, and passes a fingerprint scan. Stealing the code alone gets an attacker nowhere, because the vault demands proof from categories the attacker does not control at the same time.</p>

    <h3>The Three Factor Categories</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Example</th>
                <th>Common Weakness</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Knowledge</strong></td>
                <td>Password, PIN, security question</td>
                <td>Can be guessed, phished, or leaked in a breach</td>
            </tr>
            <tr>
                <td><strong>Possession</strong></td>
                <td>Phone, hardware token, authenticator app</td>
                <td>Can be lost, stolen, or cloned if not hardware backed</td>
            </tr>
            <tr>
                <td><strong>Inherence</strong></td>
                <td>Fingerprint, face scan, iris scan</td>
                <td>Cannot be changed if the biometric data is ever leaked</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Three factor categories
         Teaching purpose: show MFA requires evidence from different categories,
         which learners would otherwise misunderstand as simply using two passwords. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Three authentication factor categories">
            <!-- Category boxes -->
            <rect x="20"  y="30" width="220" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="270" y="30" width="220" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="520" y="30" width="220" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Labels -->
            <text x="130" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Something you know</text>
            <text x="130" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Password / PIN</text>
            <text x="130" y="102" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Knowledge factor</text>

            <text x="380" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Something you have</text>
            <text x="380" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Phone / token</text>
            <text x="380" y="102" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Possession factor</text>

            <text x="630" y="60" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Something you are</text>
            <text x="630" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Fingerprint / face</text>
            <text x="630" y="102" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Inherence factor</text>

            <text x="380" y="150" text-anchor="middle" font-size="12" font-style="italic" fill="var(--text-secondary)">MFA requires at least two categories at once, not two examples from one</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Common Misconception</h4>
        <p>A password plus a security question is still single factor authentication. Both are knowledge, so both can be phished or guessed together.</p>
    </div>
</div>
HTML;

// TASK 3: TOTP & Software-Based MFA
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>A Code That Expires Every 30 Seconds</h2>
    <p>Time based One Time Password, or TOTP, generates a short numeric code that changes on a fixed interval, usually every 30 seconds. Apps like Google Authenticator or Authy implement this standard.</p>

    <p>When a user enables TOTP, the server and the authenticator app both receive the same secret key during setup. From that point on, neither side needs to communicate to produce the current code. Picture two clocks set to the exact same time in two different rooms. Because they started in sync, they will always show the same time without ever talking to each other.</p>

    <p>Each device combines the shared secret with the current time step and runs it through an HMAC function to produce a short code. Since the server performs the identical calculation independently, it can verify the code without ever transmitting it over the network in advance.</p>

    <!-- SVG: TOTP generation flow
         Teaching purpose: show code generation happens independently on both sides using time and a shared secret,
         which learners would otherwise misunderstand as the app "calling home" to a server for each code. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="TOTP generation flow">
            <!-- Client side -->
            <rect x="30" y="20" width="300" height="140" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="180" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Authenticator App</text>
            <text x="180" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Shared secret (stored at setup)</text>
            <text x="180" y="92" text-anchor="middle" font-size="11" fill="var(--text-secondary)">+ current time step</text>
            <text x="180" y="114" text-anchor="middle" font-size="11" fill="var(--text-secondary)">↓ HMAC function</text>
            <text x="180" y="140" text-anchor="middle" font-size="13" font-weight="600" fill="var(--success)">Displays: 482 913</text>

            <!-- Server side -->
            <rect x="430" y="20" width="300" height="140" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="580" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Server</text>
            <text x="580" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Same shared secret (stored at setup)</text>
            <text x="580" y="92" text-anchor="middle" font-size="11" fill="var(--text-secondary)">+ current time step</text>
            <text x="580" y="114" text-anchor="middle" font-size="11" fill="var(--text-secondary)">↓ HMAC function</text>
            <text x="580" y="140" text-anchor="middle" font-size="13" font-weight="600" fill="var(--success)">Computes: 482 913</text>

            <text x="380" y="175" text-anchor="middle" font-size="12" font-style="italic" fill="var(--text-secondary)">Both sides calculate independently, no code is ever sent in advance</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>TOTP resists network interception since the code is never transmitted before login, but it does not resist real time phishing where an attacker relays the code the moment the user enters it.</p>
    </div>
</div>
HTML;

// TASK 4: FIDO2/WebAuthn & Hardware Tokens
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>A Key That Only Fits One Lock</h2>
    <p>FIDO2 and the WebAuthn standard replace shared secrets with public key cryptography. During registration, a hardware token or platform authenticator generates a unique key pair for that specific website. The private key never leaves the device.</p>

    <p>This is similar to cutting a key that is shaped to fit one specific lock and no other. Even a perfect looking copy of the front door will not open it, because the key was never built to match anything else.</p>

    <p>The credential this creates is often called a <strong>passkey</strong>. When logging in, the site sends a challenge, the device signs it with the private key, and the site verifies the signature with the stored public key. Critically, the browser binds this entire exchange to the real website's origin.</p>

    <!-- SVG: Origin binding handshake
         Teaching purpose: show why a phishing look-alike site cannot obtain a valid signed response,
         which learners would otherwise misunderstand as FIDO2 being "just another password step" a phishing page could still capture. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="WebAuthn origin binding">
            <rect x="30"  y="20" width="220" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="140" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Real Site</text>
            <text x="140" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">example.com</text>

            <rect x="30"  y="120" width="220" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="140" y="150" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Phishing Site</text>
            <text x="140" y="170" text-anchor="middle" font-size="11" fill="var(--text-secondary)">exarnple.com</text>

            <rect x="480" y="70" width="250" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="605" y="100" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Hardware Token</text>
            <text x="605" y="120" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Checks origin before signing</text>

            <line x1="250" y1="55"  x2="475" y2="95"  stroke="var(--success)" stroke-width="1.5" marker-end="url(#arrGreen)"/>
            <line x1="250" y1="155" x2="475" y2="115" stroke="var(--danger, #ff5c5c)" stroke-width="1.5" stroke-dasharray="5,4" marker-end="url(#arrRed)"/>

            <text x="360" y="45"  text-anchor="middle" font-size="11" fill="var(--success)">Origin matches, signs response</text>
            <text x="360" y="185" text-anchor="middle" font-size="11" fill="var(--danger, #ff5c5c)">Origin mismatch, refuses to sign</text>

            <defs>
                <marker id="arrGreen" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--success)"/>
                </marker>
                <marker id="arrRed" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--danger, #ff5c5c)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>Can Be Phished?</th>
                <th>Key Storage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TOTP</td>
                <td>Yes, via real time relay</td>
                <td>Shared secret on device</td>
            </tr>
            <tr>
                <td>FIDO2 / WebAuthn</td>
                <td>No, origin bound</td>
                <td>Private key never leaves device</td>
            </tr>
            <tr>
                <td>SMS</td>
                <td>Yes, easily</td>
                <td>No cryptographic key at all</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Passkeys</h4>
        <p>Passkeys are the consumer facing name for FIDO2 credentials, often synced across a user's devices through their platform account while remaining phishing resistant.</p>
    </div>
</div>
HTML;

// TASK 5: Push Notification & SMS
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>A Postcard Versus a Knock on the Door</h2>
    <p>Push notification MFA sends an approve or deny prompt directly to a registered app on the user's phone. The user simply taps approve, similar to someone knocking on your door and asking out loud whether it was really you who just tried the front gate.</p>

    <p>SMS based MFA instead sends a one time code as a text message. SMS was never designed with security in mind. It travels across telecom infrastructure much like a postcard travels through a postal system, readable by anyone positioned along the route who knows where to look.</p>

    <p>Two well known attack paths make SMS especially weak. In a <strong>SIM swap</strong>, an attacker convinces or bribes a mobile carrier into transferring the victim's phone number to a device the attacker controls, after which every SMS code goes straight to the attacker. Separately, flaws in the <strong>SS7</strong> signaling protocol that carriers use to route calls and texts have been exploited to intercept messages without ever touching the victim's phone.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>Delivery Channel</th>
                <th>Main Weakness</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Push Notification</td>
                <td>Dedicated authenticator app</td>
                <td>User can be tricked into approving a request they did not initiate</td>
            </tr>
            <tr>
                <td>SMS</td>
                <td>Telecom text message network</td>
                <td>SIM swapping and SS7 interception, no cryptographic protection</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Industry Guidance</h4>
        <p>Security agencies including NIST have discouraged relying on SMS as the sole factor for high assurance accounts, recommending it only as a fallback rather than a primary method.</p>
    </div>
</div>
HTML;

// TASK 6: Bypass Attacks
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>When MFA Succeeds and the Attacker Still Wins</h2>
    <p>Even strong looking MFA methods can be undermined, usually not by breaking the cryptography but by manipulating the human or the session around it.</p>

    <p><strong>MFA fatigue</strong>, also called push bombing, floods a victim with repeated push approval requests until they approve one just to make the notifications stop, similar to a doorbell rung constantly at 2am until someone finally answers out of exhaustion.</p>

    <p>SIM swapping, covered in the previous task, remains a common path for defeating SMS specifically. A third and more advanced technique targets protocols like TOTP directly: real time phishing using an adversary in the middle proxy.</p>

    <p>In this attack, the victim visits a convincing fake login page that silently forwards everything they type, including their password and their TOTP code, to the real site in real time. The proxy then captures the resulting session token, giving the attacker a valid logged in session even though MFA was technically completed correctly.</p>

    <!-- SVG: AiTM proxy relay
         Teaching purpose: show the attacker hijacks the live session after MFA succeeds,
         which learners would otherwise misunderstand as "MFA failed" rather than "the session was stolen after MFA passed." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Adversary in the middle phishing proxy">
            <rect x="20"  y="60" width="160" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="95" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Victim</text>

            <rect x="300" y="60" width="160" height="60" rx="10" fill="var(--surface)" stroke="var(--danger, #ff5c5c)" stroke-width="1.5"/>
            <text x="380" y="90" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Phishing Proxy</text>
            <text x="380" y="108" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Relays in real time</text>

            <rect x="580" y="60" width="160" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="660" y="95" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Real Site</text>

            <line x1="180" y1="90" x2="295" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="460" y1="90" x2="575" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="575" y1="115" x2="185" y2="145" stroke="var(--danger, #ff5c5c)" stroke-width="1.5" stroke-dasharray="5,4" marker-end="url(#arr3)"/>

            <text x="380" y="150" text-anchor="middle" font-size="11" fill="var(--danger, #ff5c5c)">Session token captured and reused by attacker</text>

            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--danger, #ff5c5c)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Mitigation</h4>
        <p>Number matching in push apps reduces MFA fatigue success, but only phishing resistant methods like FIDO2/WebAuthn fully prevent real time adversary in the middle attacks, since the credential itself refuses to sign for the wrong origin.</p>
    </div>
</div>
HTML;

// TASK 7: Deployment Architecture, Conditional Access & Rollout Design
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Not Every Login Deserves the Same Scrutiny</h2>
    <p>A well engineered MFA deployment does not treat every login attempt identically. A <strong>conditional access</strong> engine evaluates signals such as device health, location, network, and user role, then decides in real time whether to allow, challenge, or block the attempt.</p>

    <p>This works much like airport security lanes. Most travelers pass through standard screening, while a smaller group flagged by specific risk signals gets pulled aside for additional checks. Everyone still gets screened, but not everyone gets screened the same way.</p>

    <p>For especially sensitive actions such as changing a password or accessing a finance system, many organizations apply <strong>step up authentication</strong>, requiring an extra MFA challenge only at that specific moment rather than demanding it constantly throughout a session.</p>

    <!-- SVG: Conditional access decision pipeline
         Teaching purpose: show conditional access as an automated signal driven pipeline,
         which learners would otherwise misunderstand as one static MFA rule applied identically to everyone. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Conditional access decision pipeline">
            <rect x="10"  y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Signals In</text>
            <text x="95" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Device, location, role</text>

            <rect x="295" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Policy Engine</text>
            <text x="380" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Evaluates risk</text>

            <rect x="580" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="665" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Action Out</text>
            <text x="665" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Allow / MFA / Block</text>

            <line x1="180" y1="70" x2="290" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="465" y1="70" x2="575" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>

            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <h3>Phased Rollout</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Rollout Phase</th>
                <th>Goal</th>
                <th>Key Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pilot</td>
                <td>Validate the method with low risk</td>
                <td>Enroll a small volunteer group first</td>
            </tr>
            <tr>
                <td>Grace Period</td>
                <td>Reduce lockouts during transition</td>
                <td>Allow a temporary fallback method</td>
            </tr>
            <tr>
                <td>Full Enforcement</td>
                <td>Close remaining gaps</td>
                <td>Require MFA for all accounts and remove weak fallbacks</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Always keep one break glass account excluded from strict conditional access policies, so administrators are never fully locked out if a policy is misconfigured.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have joined Northgate Systems as an identity administrator. Several login attempts have come through the identity provider overnight, each with different device, location, and risk details attached. Your job is to configure the correct conditional access policy for each one.</p>

    <p>Review each scenario carefully and choose the policy action that matches what you learned about factor strength, risk signals, and phishing resistant methods. Deploy your policies to reveal the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="mfa-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Conditional Access Policy Builder</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You have now covered the full landscape of multi-factor authentication, from the three factor categories through the specific mechanics of TOTP, FIDO2/WebAuthn, push, hardware tokens, and SMS. You have also seen how attackers bypass weaker methods through MFA fatigue, SIM swapping, and real time phishing, and how conditional access and phased rollouts help balance security against user friction.</p>

    <p>These skills apply directly to real identity systems, where the choice of MFA method and the design of the rollout determine whether an organization is genuinely protected or only appears to be.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>MFA requires evidence from at least two different factor categories, not two examples of the same one.</li>
        <li>TOTP and FIDO2/WebAuthn both avoid transmitting a shared secret in advance, but only FIDO2/WebAuthn resists real time phishing through origin binding.</li>
        <li>SMS lacks cryptographic protection and is vulnerable to SIM swapping and SS7 interception.</li>
        <li>MFA fatigue and adversary in the middle phishing can defeat MFA even when every step appears to succeed.</li>
        <li>Conditional access and phased rollouts let organizations apply stronger requirements where risk is highest while minimizing friction elsewhere.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
