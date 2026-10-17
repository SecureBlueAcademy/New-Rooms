<?php
// ============================================================
// scoping-roe.php — CYBRIXEN ROOM DATA FILE
// Topic: Scoping & Rules of Engagement
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'scoping-roe',
    'title'           => 'Scoping & Rules of Engagement',
    'description'     => 'Learn to read and interpret a Statement of Work and Rules of Engagement before any penetration test.',
    'icon'            => 'fas fa-file-contract',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic understanding of penetration testing concepts', 'Familiarity with networking fundamentals'],
    'learning_objectives' => [
        'Explain the purpose of a Statement of Work and Rules of Engagement in a penetration test',
        'Distinguish in-scope assets from out-of-scope assets using a real SOW',
        'Identify the key clauses that define legal authorization for testing',
        'Recognise how poorly defined scope creates legal and operational risk',
        'Locate testing windows and emergency contacts within an engagement document',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/scoping-roe-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Scoping?'],
    ['id' => 'task3', 'title' => 'Reading the SOW'],
    ['id' => 'task4', 'title' => 'Rules of Engagement'],
    ['id' => 'task5', 'title' => 'Legal Risk & Scope Creep'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'         => 'scoping_roe_progress',
    'instagram_takeaways' => [
        '✓ A SOW defines what, when, and how testing is permitted',
        '✓ In-scope vs out-of-scope: the line between legal and criminal',
        '✓ Rules of Engagement set the boundaries every tester must follow',
        '✓ Testing windows and emergency contacts are non-negotiable clauses',
        '✓ Scope creep can turn authorized testing into a criminal offense',
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
        ['id' => 'q1', 'text' => 'What document defines the boundaries and objectives of a penetration test engagement?'],
        ['id' => 'q2', 'text' => 'What term describes the set of rules that governs how a tester may conduct an engagement?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What section of a SOW defines which systems, IPs, and services a tester is permitted to target?'],
        ['id' => 'q4', 'text' => 'What is the term for assets or systems the client explicitly lists as forbidden to test?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the term for the agreed window during which testing is permitted to occur?'],
        ['id' => 'q6', 'text' => 'What type of contact is listed in an RoE to halt all testing immediately in an emergency?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What legal concept makes unauthorized testing a criminal offense even when targeting a company\'s own infrastructure?'],
        ['id' => 'q8', 'text' => 'What is the term for accidental testing of systems not covered by the agreed scope?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Enter the flag you found in the SOW Review Console.'],
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
    <p>Before a single packet is sent, before a single port is scanned, a penetration tester must understand exactly what they are allowed to do. That permission comes from two documents: a <strong>Statement of Work</strong> and a <strong>Rules of Engagement</strong> document. Together they define the legal boundary between authorized security testing and criminal intrusion. Without them, no test should begin.</p>

    <p>This room walks through how to read and interpret both documents, what each clause means in practice, and how ambiguous or missing scope language puts both the tester and the client at serious legal and operational risk. A hands-on SOW Review Console is included so you can apply these skills directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the purpose of a Statement of Work and Rules of Engagement in a penetration test.</li>
        <li>Distinguish in-scope assets from out-of-scope assets using a real SOW.</li>
        <li>Identify the key clauses that define legal authorization for testing.</li>
        <li>Recognise how poorly defined scope creates legal and operational risk.</li>
        <li>Locate testing windows and emergency contacts within an engagement document.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Scoping?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Defining the Playing Field</h2>

    <p>Scoping is the process of agreeing exactly what will be tested, how it will be tested, and when. It happens before any technical work begins and produces two formal documents that both parties sign: the <strong>Statement of Work</strong> (SOW) and the <strong>Rules of Engagement</strong> (RoE).</p>

    <p>Think of it like a building permit. A construction crew has every skill needed to demolish a wall, but without a signed permit specifying exactly which wall, they are breaking the law. A penetration tester has every skill needed to compromise a server, but without a signed SOW specifying exactly which server, that activity is a criminal offense regardless of intent.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Two Documents?</h4>
        <p>The SOW defines the commercial agreement: objectives, deliverables, timelines, and payment. The RoE defines the technical agreement: what methods are permitted, what systems are in scope, and what happens if something goes wrong. A tester needs both before touching anything.</p>
    </div>

    <h3>The Two Core Documents</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Document</th>
                <th>Primary Purpose</th>
                <th>Key Contents</th>
                <th>Who Uses It</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Statement of Work (SOW)</strong></td>
                <td>Defines the commercial and technical scope of the engagement</td>
                <td>Objectives, deliverables, timeline, in-scope systems, out-of-scope systems, costs</td>
                <td>Client, management, legal team, tester</td>
            </tr>
            <tr>
                <td><strong>Rules of Engagement (RoE)</strong></td>
                <td>Governs how the tester may conduct the test</td>
                <td>Permitted techniques, testing windows, emergency contacts, escalation procedures, forbidden actions</td>
                <td>Tester, technical lead, client security team</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: SOW and RoE relationship
         Teaching purpose: show the learner that the SOW and RoE are separate but linked documents,
         which they would otherwise misunderstand as a single interchangeable contract. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SOW and RoE document relationship">
            <!-- SOW box -->
            <rect x="20" y="20" width="220" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- RoE box -->
            <rect x="520" y="20" width="220" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Centre connector label -->
            <rect x="310" y="48" width="140" height="44" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <!-- Arrows -->
            <line x1="240" y1="70" x2="308" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowRoe)"/>
            <line x1="452" y1="70" x2="518" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowRoe)"/>
            <defs>
                <marker id="arrowRoe" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- SOW labels -->
            <text x="130" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Statement of Work</text>
            <text x="130" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">What &amp; When</text>
            <text x="130" y="86" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Objectives &amp; Deliverables</text>
            <text x="130" y="102" text-anchor="middle" font-size="11" fill="var(--text-secondary)">In / Out of Scope</text>
            <!-- Connector label -->
            <text x="380" y="67" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-secondary)">Both signed</text>
            <text x="380" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">before testing</text>
            <!-- RoE labels -->
            <text x="630" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Rules of Engagement</text>
            <text x="630" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">How &amp; Who</text>
            <text x="630" y="86" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Permitted Methods</text>
            <text x="630" y="102" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Emergency Contacts</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Both documents must be signed by an authorized representative of the client before testing begins. A verbal agreement or an email thread is not sufficient legal protection for the tester.</p>
    </div>
</div>
HTML;

// TASK 3: Reading the SOW
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Dissecting a Statement of Work</h2>

    <p>A Statement of Work is a formal contract. Every clause in it has meaning, and a skilled tester reads it the same way a lawyer would: looking for what is explicitly permitted, what is explicitly forbidden, and what is dangerously ambiguous.</p>

    <p>The most critical section is the <strong>scope</strong>. This lists the exact systems, IP ranges, domains, and applications the tester is authorized to interact with. Anything not listed here is off-limits, even if the client mentions it casually during a meeting.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The Golden Rule</h4>
        <p>If it is not in the signed SOW, it is not in scope. No exceptions. A verbal addition to scope mid-engagement is worthless without a signed amendment.</p>
    </div>

    <h3>Anatomy of a Scope Section</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Clause</th>
                <th>What It Specifies</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>In-Scope Assets</strong></td>
                <td>Systems, IPs, domains, and services the tester may target</td>
                <td>192.168.10.0/24, app.client.com, VPN gateway</td>
            </tr>
            <tr>
                <td><strong>Out-of-Scope Assets</strong></td>
                <td>Systems explicitly forbidden, even if reachable from in-scope systems</td>
                <td>HR database server, payment processing system, third-party SaaS</td>
            </tr>
            <tr>
                <td><strong>Test Type</strong></td>
                <td>Black box, grey box, or white box engagement</td>
                <td>Grey box: tester given standard user credentials only</td>
            </tr>
            <tr>
                <td><strong>Engagement Dates</strong></td>
                <td>Start and end dates for the entire engagement</td>
                <td>14 July 2025 to 18 July 2025</td>
            </tr>
            <tr>
                <td><strong>Deliverables</strong></td>
                <td>What the tester must produce at the end</td>
                <td>Executive summary, technical findings report, remediation recommendations</td>
            </tr>
        </tbody>
    </table>

    <h3>Reading In-Scope vs Out-of-Scope</h3>
    <p>The in-scope list tells you what you can test. The out-of-scope list tells you what you must never touch, even if your testing naturally leads you toward it. For example: if you compromise an in-scope web server and find a database connection string pointing to an out-of-scope HR server, you stop there. You document the finding but you do not follow that connection.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Third-Party Systems</h4>
        <p>Shared infrastructure, cloud providers, and SaaS tools used by the client are almost always out of scope. Testing them without their own written authorization is a separate legal violation against the third party, not just the client engagement.</p>
    </div>
</div>
HTML;

// TASK 4: Rules of Engagement
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>How You Are Allowed to Test</h2>

    <p>The Rules of Engagement document gets more specific than the SOW. Where the SOW answers "what can be tested", the RoE answers "how can it be tested". It sets the operational boundaries that a tester must follow throughout the engagement, not just at the start.</p>

    <p>Two of the most important elements in any RoE are the <strong>testing window</strong> and the <strong>emergency contact</strong>. Missing or ignoring either one can result in serious operational damage to the client and serious legal exposure for the tester.</p>

    <!-- SVG: RoE key clauses diagram
         Teaching purpose: show the learner that an RoE contains multiple distinct operational clauses,
         which they would otherwise misunderstand as a single generic "permission to test" statement. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Rules of Engagement key clauses">
            <!-- Central node -->
            <rect x="290" y="75" width="180" height="50" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="96" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Rules of</text>
            <text x="380" y="113" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Engagement</text>
            <!-- Clause boxes -->
            <rect x="10"  y="10"  width="170" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <rect x="580" y="10"  width="170" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <rect x="10"  y="140" width="170" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <rect x="580" y="140" width="170" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1"/>
            <!-- Connector lines -->
            <line x1="180" y1="35"  x2="290" y2="90"  stroke="var(--border)" stroke-width="1.2"/>
            <line x1="580" y1="35"  x2="470" y2="90"  stroke="var(--border)" stroke-width="1.2"/>
            <line x1="180" y1="165" x2="290" y2="110" stroke="var(--border)" stroke-width="1.2"/>
            <line x1="580" y1="165" x2="470" y2="110" stroke="var(--border)" stroke-width="1.2"/>
            <!-- Clause labels -->
            <text x="95" y="32"  text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Testing Window</text>
            <text x="95" y="50"  text-anchor="middle" font-size="11" fill="var(--text-secondary)">When testing may occur</text>
            <text x="665" y="32"  text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Permitted Techniques</text>
            <text x="665" y="50"  text-anchor="middle" font-size="11" fill="var(--text-secondary)">What methods are allowed</text>
            <text x="95" y="162" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Emergency Contact</text>
            <text x="95" y="180" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Who halts the test</text>
            <text x="665" y="162" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Forbidden Actions</text>
            <text x="665" y="180" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Hard stops regardless of scope</text>
        </svg>
    </div>

    <h3>Testing Windows</h3>
    <p>A testing window defines the exact hours and days during which active testing is permitted. This is not a suggestion. Testing outside the agreed window, even for a few minutes, can trigger incident response procedures, create noise in client monitoring systems, and potentially void the legal authorization entirely.</p>

    <p>Common window types include business hours only, out-of-hours only (to reduce production impact), or a specific date range. Always verify the window in the RoE before starting each session, not just at the start of the engagement.</p>

    <h3>Emergency Contacts</h3>
    <p>An emergency contact is a named individual at the client organization who has the authority to immediately halt all testing. This person must be reachable throughout the testing window, not just during business hours. If testing causes unexpected system instability or a business-critical service is affected, the emergency contact is called before anything else.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> No Contact, No Testing</h4>
        <p>If you cannot reach the emergency contact at the start of a testing session and something goes wrong during that session, you have no recourse. Many experienced testers will not begin a session unless they have confirmed the emergency contact is available.</p>
    </div>

    <h3>Permitted and Forbidden Techniques</h3>
    <p>The RoE specifies which testing techniques are allowed. A client may permit vulnerability scanning and manual exploitation but forbid denial-of-service testing against production systems. Some clients forbid social engineering entirely. Some forbid physical access testing. Each restriction has a business reason, and testers must respect them even if the restriction limits what findings are possible.</p>
</div>
HTML;

// TASK 5: Legal Risk & Scope Creep
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When Testing Becomes a Crime</h2>

    <p>Penetration testing occupies a narrow legal corridor. On one side is authorized, contracted security work. On the other side is unauthorized access to computer systems, which is a criminal offense in virtually every jurisdiction. What separates the two is a single word: <strong>authorization</strong>. A signed SOW and RoE are the legal proof that authorization exists.</p>

    <p>This is not theoretical. Testers have faced criminal prosecution for testing systems they believed were in scope but were not explicitly listed in the signed documents. The burden of proof for authorization lies with the tester, not the client.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Real Consequence</h4>
        <p>Laws such as the Computer Fraud and Abuse Act (USA), the Computer Misuse Act (UK), and equivalent legislation in most countries carry criminal penalties for unauthorized system access. "My client said it was fine" is not a legal defense without a signed document to back it up.</p>
    </div>

    <h3>Understanding Scope Creep</h3>
    <p><strong>Scope creep</strong> is what happens when testing activity drifts beyond the defined boundaries, often unintentionally. It is one of the most common and dangerous mistakes in penetration testing. A classic example: a tester exploits an in-scope web application, pivots to an internal network segment, and begins scanning hosts on that segment without checking whether those hosts are listed in the SOW. The pivot itself may have been permitted. The subsequent scanning of unlisted hosts was not.</p>

    <p>Scope creep is not always the tester's fault. Clients sometimes add targets verbally mid-engagement, assume adjacent systems are covered, or provide vague IP ranges that include unintended systems. The tester's responsibility is to stop, verify, and get written confirmation before proceeding.</p>

    <h3>Common Scope Creep Scenarios</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Scenario</th>
                <th>The Risk</th>
                <th>Correct Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Client verbally adds a new server to scope mid-engagement</td>
                <td>No written authorization for that server</td>
                <td>Stop. Request a signed SOW amendment before testing it.</td>
            </tr>
            <tr>
                <td>Pivot from in-scope host reveals an unlisted subnet</td>
                <td>Scanning the subnet is unauthorized</td>
                <td>Document the pivot point. Do not scan. Report it as a finding.</td>
            </tr>
            <tr>
                <td>In-scope application shares infrastructure with a third-party service</td>
                <td>Third party has no knowledge of the test</td>
                <td>Treat the third-party boundary as a hard stop.</td>
            </tr>
            <tr>
                <td>Testing window ends but an active exploit chain is still running</td>
                <td>Activity outside the authorized window</td>
                <td>Stop all activity. Resume only at the next authorized window.</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Practical Rule</h4>
        <p>When in doubt, stop and ask. A five-minute email to the client contact is always better than an unauthorized action that cannot be undone.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been handed a Statement of Work and Rules of Engagement for an upcoming penetration test. Before testing begins, your team lead requires you to review both documents and confirm that you understand the engagement boundaries. Your job is to work through the SOW Review Console, identify the correct answers to each checkpoint, and confirm your review.</p>

    <p>Read each document panel carefully. Locate the in-scope assets, identify what is out of scope, confirm the testing window, and find the emergency contact. The flag is released once all checkpoints are completed correctly.</p>

    <div class="practical-launch-wrapper">
        <a href="scoping-roe-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch SOW Review Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Scoping and Rules of Engagement are not administrative formalities. They are the legal foundation that makes penetration testing legitimate. Every tester must be able to read these documents critically, identify ambiguities before testing begins, and stop immediately when activity approaches a boundary that is not explicitly covered. The most technically skilled tester in the room is useless, and potentially dangerous, if they cannot operate within a defined and documented scope.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>A Statement of Work defines what will be tested, the objectives, deliverables, and engagement timeline.</li>
        <li>A Rules of Engagement document defines how testing may be conducted, including permitted techniques, testing windows, and emergency procedures.</li>
        <li>Both documents must be signed by an authorized client representative before any testing begins.</li>
        <li>In-scope assets are explicitly listed; anything not listed is out of scope regardless of verbal agreements.</li>
        <li>Scope creep, even unintentional, can transform authorized testing into a criminal act.</li>
        <li>The testing window and emergency contact are non-negotiable clauses that must be verified before every session.</li>
        <li>Authorization is the single legal concept that separates a penetration tester from an intruder.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// These two lines must always be last, in this order.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
