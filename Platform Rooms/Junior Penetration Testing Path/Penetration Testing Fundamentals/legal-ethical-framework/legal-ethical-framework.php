<?php
// ============================================================
// legal-ethical-framework.php — ROOM DATA FILE
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'legal-ethical-framework',
    'title'           => 'Legal and Ethical Framework',
    'description'     => 'Understand the legal boundaries of penetration testing, written authorisation requirements, and what happens when testers operate outside agreed scope.',
    'icon'            => 'fas fa-gavel',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic cybersecurity concepts', 'Understanding of what penetration testing is'],
    'learning_objectives' => [
        'Explain why written authorisation is non-negotiable before any penetration test',
        'Identify the key provisions of the Computer Misuse Act and the CFAA',
        'Define scope and explain the consequences of working outside it',
        'Describe the documents that legally protect both tester and client',
        'Recognise the difference between ethical and unethical testing behaviour',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/legal-ethical-framework-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Why Authorisation Matters'],
    ['id' => 'task3', 'title' => 'The Legal Framework'],
    ['id' => 'task4', 'title' => 'Scope and Rules of Engagement'],
    ['id' => 'task5', 'title' => 'Working Within Boundaries'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'         => 'legal_ethical_framework_progress',
    'instagram_takeaways' => [
        '✓ Written authorisation is the legal foundation of every penetration test',
        '✓ The Computer Misuse Act (UK) and CFAA (US) criminalise unauthorised access',
        '✓ Scope defines exactly what is and is not permitted during an engagement',
        '✓ Rules of Engagement and NDAs protect both tester and client',
        '✓ Operating outside agreed scope can make a tester criminally liable',
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
        ['id' => 'q1', 'text' => 'What is the term for a tester operating on systems without the owner\'s knowledge or permission?'],
        ['id' => 'q2', 'text' => 'What type of document legally protects a penetration tester by defining the agreed scope of their work? (two words)'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the name of the UK law that criminalises unauthorised access to computer systems? (three words)'],
        ['id' => 'q4', 'text' => 'What is the common abbreviation for the US law governing unauthorised computer access?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the term for the defined boundaries and targets agreed upon before a penetration test begins?'],
        ['id' => 'q6', 'text' => 'What document formalises the rules, targets, and limitations of a penetration test engagement? (three words)'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'How would you describe testing activity that targets systems or actions not covered in the agreed scope? (three words)'],
        ['id' => 'q8', 'text' => 'What legal agreement is typically signed before a test to protect sensitive information shared between client and tester? (abbreviation)'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Enter the flag you found in the Engagement Review Console.'],
    ],
    'task7' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Penetration testing is a licensed form of attack. The technical skills involved are identical to those used by real attackers, which means the only thing separating a professional tester from a criminal is permission. Understanding the legal and ethical framework that governs this work is not a formality, it is the foundation that makes the entire profession possible.</p>

    <p>This room covers the legislation that defines the legal boundaries of penetration testing, the documents required to keep a tester protected, and the real consequences of working outside agreed limits. A hands-on engagement review exercise is included to put these concepts into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why written authorisation is non-negotiable before any penetration test.</li>
        <li>Identify the key provisions of the Computer Misuse Act and the CFAA.</li>
        <li>Define scope and explain the consequences of working outside it.</li>
        <li>Describe the documents that legally protect both tester and client.</li>
        <li>Recognise the difference between ethical and unethical testing behaviour.</li>
    </ul>
</div>
HTML;

// TASK 2: Why Authorisation Matters
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>The Line Between Testing and Crime</h2>

    <p>A penetration tester and an attacker run many of the same tools against the same kinds of targets. What separates them legally and ethically is a single factor: <strong>authorisation</strong>. Without explicit, documented permission from the system owner, any access attempt, however well-intentioned, is a criminal act under the laws of most countries.</p>

    <p>This is not a technicality. Courts do not weigh intent when determining whether unauthorised access occurred. If you accessed a system you were not explicitly permitted to access, the law has been broken regardless of what you found or why you looked.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Misconception</h4>
        <p>Many new testers assume that finding a vulnerability "for free" and reporting it will be appreciated. In reality, accessing a system to discover that vulnerability, without prior written permission, is itself the offence. Good intentions are not a legal defence.</p>
    </div>

    <h3>What Authorisation Means in Practice</h3>

    <p>Authorisation must be written, explicit, and granted by the person or organisation that has legal authority over the target systems. A verbal agreement is not sufficient. An email from a junior employee is not sufficient. The permission must come from someone who actually owns or controls the systems in question and must specify what is permitted.</p>

    <p>Think of it like a building contractor. Before anyone starts drilling into walls, a signed contract is required that states exactly what work is permitted, in which rooms, and by whom. A penetration tester needs the same thing before a single packet is sent.</p>

    <!-- SVG: Teaching purpose: show the learner that the difference between legal testing
         and illegal access is purely the presence of written authorisation, which they
         would otherwise misunderstand as a matter of intent or outcome. -->
    <div style="margin: 24px 0;">
        <svg viewBox="0 0 720 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Authorisation divides legal testing from criminal access">
            <!-- Left box: no authorisation -->
            <rect x="10" y="20" width="220" height="120" rx="10" fill="var(--surface)" stroke="#ff5c5c" stroke-width="1.5"/>
            <text x="120" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="#ff5c5c">No Written Authorisation</text>
            <text x="120" y="76" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Same tools, same techniques</text>
            <text x="120" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">No legal protection</text>
            <text x="120" y="116" text-anchor="middle" font-size="11" fill="#ff5c5c">Criminal liability</text>

            <!-- Centre divider label -->
            <text x="360" y="86" text-anchor="middle" font-size="22" font-weight="700" fill="var(--text-secondary)">vs</text>

            <!-- Right box: with authorisation -->
            <rect x="490" y="20" width="220" height="120" rx="10" fill="var(--surface)" stroke="#3dff9a" stroke-width="1.5"/>
            <text x="600" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="#3dff9a">Written Authorisation</text>
            <text x="600" y="76" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Same tools, same techniques</text>
            <text x="600" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Defined scope and purpose</text>
            <text x="600" y="116" text-anchor="middle" font-size="11" fill="#3dff9a">Legal protection</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The Key Principle</h4>
        <p>Authorisation does not make hacking acceptable. It makes penetration testing legal. The permission, the scope it defines, and the identity of who granted it are what distinguish the two activities in a court of law.</p>
    </div>
</div>
HTML;

// TASK 3: The Legal Framework
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>The Laws That Govern Unauthorised Access</h2>

    <p>Penetration testers operate under the laws of the jurisdiction where the target systems are located, where the tester is physically present, and sometimes both simultaneously. Two pieces of legislation are foundational to understanding your legal exposure as a security professional.</p>

    <h3>The Computer Misuse Act (UK)</h3>

    <p>Enacted in 1990 and amended several times since, the <strong>Computer Misuse Act</strong> is the primary UK legislation governing computer crime. It establishes three core offences that any penetration tester must understand.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Section</th>
                <th>Offence</th>
                <th>Example</th>
                <th>Maximum Sentence</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Section 1</td>
                <td>Unauthorised access to computer material</td>
                <td>Logging into a system you have no permission to access</td>
                <td>2 years imprisonment</td>
            </tr>
            <tr>
                <td>Section 2</td>
                <td>Unauthorised access with intent to commit further offences</td>
                <td>Accessing a system to steal data or escalate privileges</td>
                <td>5 years imprisonment</td>
            </tr>
            <tr>
                <td>Section 3</td>
                <td>Unauthorised acts intended to impair a computer</td>
                <td>Deploying malware or causing a denial of service without permission</td>
                <td>10 years imprisonment</td>
            </tr>
        </tbody>
    </table>

    <p>The Act applies regardless of whether the tester is in the UK. If the target system is located in the UK, UK law applies. Written authorisation from the system owner is the only defence against a Section 1 charge.</p>

    <h3>The Computer Fraud and Abuse Act (US)</h3>

    <p>In the United States, the <strong>Computer Fraud and Abuse Act (CFAA)</strong> serves a similar purpose. Originally passed in 1986 and amended multiple times, the CFAA makes it a federal crime to access a computer without authorisation or to exceed authorised access.</p>

    <p>The CFAA is notably broad in its definition of "computer", covering essentially any device connected to the internet, and "damage", which includes not just physical harm but any impairment to data integrity or system availability. Penalties range from fines to multi-year federal prison sentences.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Exceeding Authorisation</h4>
        <p>Both the CMA and the CFAA penalise exceeding authorised access, not just accessing systems without any permission at all. A tester with a signed contract who then tests systems outside the agreed scope can still face criminal charges under both laws.</p>
    </div>

    <h3>Other Relevant Legislation</h3>

    <p>Beyond these two landmark laws, penetration testers must also be aware of data protection legislation. In the UK and EU, the General Data Protection Regulation (GDPR) applies if testing activities involve or expose personal data. In many countries, intercepting network traffic, even on systems the tester is permitted to access, may require additional authorisation under telecommunications laws.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Jurisdiction Complexity</h4>
        <p>A tester in Germany attacking a server in the United States that processes UK citizen data could simultaneously fall under three separate legal frameworks. Always consult legal counsel before cross-border engagements.</p>
    </div>
</div>
HTML;

// TASK 4: Scope and Rules of Engagement
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Defining the Boundaries of an Engagement</h2>

    <p>Authorisation tells you that you are permitted to test. <strong>Scope</strong> tells you exactly what you are permitted to test. These are two separate things, and both matter. A signed contract that permits testing without a defined scope is nearly as dangerous as no contract at all, because without clear boundaries, any action might later be contested as outside what was intended.</p>

    <h3>What Scope Covers</h3>

    <p>A well-defined scope document specifies targets precisely, typically including IP address ranges, domain names, application URLs, physical locations, and specific testing techniques that are either permitted or explicitly prohibited. It also states what is not in scope, which is often more important than what is.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Scope Element</th>
                <th>Description</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Target systems</td>
                <td>Specific IPs, ranges, or hostnames authorised for testing</td>
                <td>192.168.10.0/24, app.example.com</td>
            </tr>
            <tr>
                <td>Excluded systems</td>
                <td>Systems explicitly off-limits even if reachable</td>
                <td>Third-party payment processor at 10.0.5.12</td>
            </tr>
            <tr>
                <td>Permitted techniques</td>
                <td>Types of testing allowed</td>
                <td>Network scanning, web application testing, no social engineering</td>
            </tr>
            <tr>
                <td>Testing window</td>
                <td>When testing may occur</td>
                <td>Weekdays 09:00 to 17:00 UTC only</td>
            </tr>
            <tr>
                <td>Emergency contacts</td>
                <td>Who to call if something goes wrong</td>
                <td>IT Director mobile, SOC hotline</td>
            </tr>
        </tbody>
    </table>

    <h3>Rules of Engagement</h3>

    <p>The <strong>Rules of Engagement (RoE)</strong> is the document that formalises all of this. It is a binding agreement between the client and the testing team that goes beyond just listing targets. It establishes the ground rules for how the engagement will be conducted.</p>

    <p>A properly written RoE removes ambiguity. If a tester discovers a vulnerability on a system adjacent to the agreed target, the RoE tells them exactly what to do: stop, document, and notify the client before proceeding. Without this guidance, a tester making the wrong judgement call could unknowingly commit a crime.</p>

    <!-- SVG: Teaching purpose: show the learner that scope is a defined boundary surrounding
         only certain targets, which they would otherwise misunderstand as a general permission
         to test anything they can reach. -->
    <div style="margin: 24px 0;">
        <svg viewBox="0 0 680 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Scope boundary diagram showing in-scope and out-of-scope targets">
            <!-- Outer environment -->
            <rect x="10" y="10" width="660" height="180" rx="12" fill="none" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="6,4"/>
            <text x="340" y="30" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Client Network Environment</text>

            <!-- Scope boundary -->
            <rect x="40" y="45" width="320" height="130" rx="10" fill="var(--surface)" stroke="#6ae3ff" stroke-width="2"/>
            <text x="200" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="#6ae3ff">In Scope</text>

            <!-- In-scope targets -->
            <rect x="60" y="76" width="120" height="36" rx="6" fill="#12182b" stroke="#6ae3ff" stroke-width="1"/>
            <text x="120" y="94" text-anchor="middle" font-size="11" fill="var(--text-primary)">Web App</text>
            <text x="120" y="108" text-anchor="middle" font-size="10" fill="var(--text-secondary)">app.example.com</text>

            <rect x="220" y="76" width="120" height="36" rx="6" fill="#12182b" stroke="#6ae3ff" stroke-width="1"/>
            <text x="280" y="94" text-anchor="middle" font-size="11" fill="var(--text-primary)">Internal Network</text>
            <text x="280" y="108" text-anchor="middle" font-size="10" fill="var(--text-secondary)">192.168.10.0/24</text>

            <rect x="60" y="126" width="280" height="36" rx="6" fill="#12182b" stroke="#6ae3ff" stroke-width="1"/>
            <text x="200" y="144" text-anchor="middle" font-size="11" fill="var(--text-primary)">VPN Gateway</text>
            <text x="200" y="158" text-anchor="middle" font-size="10" fill="var(--text-secondary)">vpn.example.com</text>

            <!-- Out of scope targets -->
            <rect x="400" y="70" width="240" height="40" rx="8" fill="#12182b" stroke="#ff5c5c" stroke-width="1.5"/>
            <text x="520" y="87" text-anchor="middle" font-size="11" fill="#ff5c5c">Out of Scope</text>
            <text x="520" y="101" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Third-party payment processor</text>

            <rect x="400" y="125" width="240" height="40" rx="8" fill="#12182b" stroke="#ff5c5c" stroke-width="1.5"/>
            <text x="520" y="142" text-anchor="middle" font-size="11" fill="#ff5c5c">Out of Scope</text>
            <text x="520" y="156" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Partner company systems</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Practical Rule</h4>
        <p>If it is not explicitly listed as in scope, treat it as out of scope. Reaching a system does not mean you are authorised to test it.</p>
    </div>
</div>
HTML;

// TASK 5: Working Within Boundaries
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Staying Legal When Things Get Complicated</h2>

    <p>Real engagements rarely go exactly as planned. Networks are more interconnected than clients expect. Testing one system often exposes others. A tester who knows the rules in theory but does not apply them under pressure is still a liability, both for themselves and for their employer.</p>

    <h3>Scope Creep and Out-of-Scope Activity</h3>

    <p>Scope creep happens when a tester, intentionally or not, tests systems or performs actions that were not covered in the agreed scope. Even with the best intentions, this can result in criminal charges under the Computer Misuse Act or the CFAA.</p>

    <p>A common scenario: a tester scans the agreed IP range and discovers a router that then routes them into a network segment that was not in scope. Following that path and testing systems on the new segment is an out-of-scope action regardless of how naturally it arose. The correct response is to stop, document what was found, and contact the client before proceeding.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The "Just One Look" Trap</h4>
        <p>It is tempting to briefly explore a system just discovered, thinking no harm will be done. Any access to an out-of-scope system, even a single ping or port scan, may constitute unauthorised access under the law. Document it and stop.</p>
    </div>

    <h3>Protective Documents Every Engagement Needs</h3>

    <p>Beyond the Rules of Engagement, two additional documents protect both the tester and the client throughout an engagement.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Document</th>
                <th>Purpose</th>
                <th>Who It Protects</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Non-Disclosure Agreement (NDA)</strong></td>
                <td>Prevents the tester from disclosing confidential information encountered during the test, including vulnerabilities, data, and internal architecture.</td>
                <td>Primarily the client, but also the tester by clarifying confidentiality obligations</td>
            </tr>
            <tr>
                <td><strong>Statement of Work (SoW)</strong></td>
                <td>Defines deliverables, timelines, methodology, and payment. Creates a contractual record of what was agreed.</td>
                <td>Both parties</td>
            </tr>
        </tbody>
    </table>

    <h3>Responsible Disclosure</h3>

    <p>Sometimes a tester finds a vulnerability in a system they have no engagement for at all, perhaps a supplier's platform or a piece of open-source software used by many organisations. In these situations, responsible disclosure is the ethical path. This means notifying the affected vendor or maintainer privately, giving them reasonable time to produce a fix, and only releasing details publicly after a patch is available.</p>

    <p>Responsible disclosure is not a legal shield. Accessing a system without permission to discover a vulnerability is still potentially a crime. But in the context of security research, following established responsible disclosure frameworks demonstrates good faith and is far less likely to result in prosecution.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Bug Bounty Programmes</h4>
        <p>Many organisations now run formal bug bounty programmes that provide written authorisation for security researchers to test specific systems within defined rules. These programmes are the legitimate path for finding and reporting vulnerabilities in systems you do not own.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>A penetration testing firm has received a new engagement request. You have been given the client brief, the proposed scope document, and a tester's action log from the first day of work. Your job is to review all three documents, identify any actions that violate the agreed boundaries, and confirm the correct authorisation requirements for this engagement.</p>

    <p>Work through each section of the Engagement Review Console in order. Flag any out-of-scope actions you find and confirm the authorisation status of the engagement. The flag will be revealed once you have completed all three review stages.</p>

    <div class="practical-launch-wrapper">
        <a href="legal-ethical-framework-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Engagement Review Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>The technical skills of penetration testing are only half the profession. The legal and ethical framework covered in this room is what makes those skills legitimate. Written authorisation defines where legal testing begins. Scope defines where it ends. The laws of the relevant jurisdiction enforce both. Operating outside any of these boundaries, even briefly and even with good intentions, exposes a tester to serious criminal and civil liability.</p>

    <p>Understanding this framework is not about following rules for their own sake. It is about being a professional who can be trusted by clients, colleagues, and the wider security community to act with integrity in situations where the temptation to exceed boundaries can be real.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Written authorisation from the system owner is the single most important document in any penetration test.</li>
        <li>The Computer Misuse Act (UK) and the CFAA (US) both criminalise unauthorised access regardless of intent.</li>
        <li>Exceeding authorised access is an offence under both laws, not just accessing without permission at all.</li>
        <li>Scope defines what is permitted; the Rules of Engagement formalise how the test will be conducted.</li>
        <li>An NDA and a Statement of Work protect both the tester and the client throughout an engagement.</li>
        <li>Out-of-scope discoveries must be stopped, documented, and escalated to the client before any further action is taken.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// These two lines must always be last, in this order.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
