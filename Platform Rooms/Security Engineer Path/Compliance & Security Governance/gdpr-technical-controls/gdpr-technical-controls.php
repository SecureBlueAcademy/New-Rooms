<?php
// ============================================================
// gdpr-technical-controls.php — ROOM DATA FILE
// Topic: GDPR & Data Privacy Technical Controls
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'gdpr-technical-controls',
    'title'           => 'GDPR & Data Privacy Technical Controls',
    'description'     => 'Learn the technical controls that make GDPR compliance real, from data discovery to breach notification.',
    'icon'            => 'fas fa-user-lock',
    'banner'          => '../../assets/banner-privacy.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '70 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of databases'],
    'learning_objectives' => [
        'Apply the privacy by design and by default principle to real systems',
        'Distinguish pseudonymisation from anonymisation and apply encryption correctly',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/gdpr-technical-controls-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Data Discovery & Classification'],
    ['id' => 'task3', 'title' => 'Pseudonymisation & Anonymisation'],
    ['id' => 'task4', 'title' => 'Encryption of Personal Data'],
    ['id' => 'task5', 'title' => 'Access Logging & DSAR'],
    ['id' => 'task6', 'title' => 'Retention Enforcement'],
    ['id' => 'task7', 'title' => 'Breach Detection & Notification'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'gdpr_technical_controls_progress',
    'instagram_takeaways'  => [
        '✓ Privacy by design and by default, built in from the start',
        '✓ Pseudonymisation vs anonymisation, and why the difference matters',
        '✓ Encryption at rest and in transit for personal data',
        '✓ DSAR workflows and the 72 hour breach notification clock',
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
        ['id' => 'q1', 'text' => 'What principle requires privacy safeguards to be built into a system from the start, rather than added later?'],
        ['id' => 'q2', 'text' => 'Which GDPR category includes data such as health records or religious beliefs, requiring extra protection?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the term for personal data processed so it cannot identify someone without a separately held key?'],
        ['id' => 'q4', 'text' => 'What is the term for data processed so it can never be linked back to an individual?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What type of encryption protects data while it is stored on a server or database?'],
        ['id' => 'q6', 'text' => 'What type of encryption protects data while it moves across a network?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What is the standard deadline for responding to a Data Subject Access Request?'],
        ['id' => 'q8', 'text' => 'What acronym refers to a request from an individual to access their own personal data?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What GDPR principle states organizations should only keep personal data for as long as necessary?'],
        ['id' => 'q10', 'text' => 'What is the term for a policy that defines how long data is kept before deletion?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Within how many hours must a notifiable data breach be reported to the supervisory authority?'],
        ['id' => 'q12', 'text' => 'What GDPR article defines the breach notification requirement?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed by the DSAR Fulfillment Console.'],
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
    <p>Every GDPR compliance program eventually comes down to engineering. Policies and legal text describe what an organization must do, but it is technical controls, discovery tools, encryption, access logs, retention rules, and breach detection systems, that actually make those promises real. Without the engineering, GDPR is just paperwork.</p>

    <p>By the end of this room, you will be able to identify and explain the six technical control areas that underpin GDPR compliance, and recognize the privacy by design and by default principle that ties them all together. A hands on practical is included where you will fulfill a real Data Subject Access Request using these concepts.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why data discovery and classification come before any protection control.</li>
        <li>Apply the privacy by design and by default principle.</li>
        <li>Distinguish pseudonymisation from anonymisation.</li>
        <li>Identify where encryption at rest and in transit apply to personal data.</li>
        <li>Describe the access logging and Data Subject Access Request workflow.</li>
        <li>Explain data retention enforcement and the storage limitation principle.</li>
        <li>Understand breach detection and the 72 hour notification requirement.</li>
    </ul>
</div>
HTML;

// TASK 2: Data Discovery, Classification & Privacy by Design
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>You Cannot Protect What You Cannot Find</h2>

    <p>Before any encryption, access control, or retention rule can be applied, an organization has to know where personal data actually lives. Data discovery is the process of locating personal data across databases, file shares, backups, and third party systems. Classification is the step that follows, labeling each piece of data by its sensitivity and legal category.</p>

    <p>Think of a warehouse with thousands of unlabeled boxes. You cannot decide which boxes need a security guard, a fireproof safe, or a shredder until you have opened each one and identified what is inside. Data discovery and classification are that inventory step for personal data.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Privacy by Design and by Default</h4>
        <p>Article 25 of GDPR requires that data protection measures be built into a system from the earliest design stage, not bolted on afterward. By default, a system should only process the personal data necessary for its specific purpose, nothing more.</p>
    </div>

    <h3>Classifying Personal Data</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Definition</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Personal data</strong></td>
                <td>Any data that identifies or can identify a living individual.</td>
                <td>Name, email address, phone number.</td>
            </tr>
            <tr>
                <td><strong>Special category data</strong></td>
                <td>Personal data requiring extra protection due to its sensitivity.</td>
                <td>Health records, religious beliefs, biometric data.</td>
            </tr>
            <tr>
                <td>Pseudonymised data</td>
                <td>Data that cannot identify someone without a separately held key.</td>
                <td>A customer referenced only by a token in a support system.</td>
            </tr>
            <tr>
                <td>Anonymised data</td>
                <td>Data processed so it can never be linked back to an individual.</td>
                <td>An aggregated report showing average order value by region.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Discover to Classify to Protect flow
         Teaching purpose: show the learner that classification is a distinct
         step that must happen before protection, which they would otherwise
         misunderstand as a single combined action. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Discover, classify, protect sequential flow">
            <rect x="10"  y="20" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="20" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="590" y="20" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="170" y1="60" x2="295" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="460" y1="60" x2="585" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="90"  y="52" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Discover</text>
            <text x="90"  y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Find the data</text>
            <text x="380" y="52" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Classify</text>
            <text x="380" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Label its sensitivity</text>
            <text x="670" y="52" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Protect</text>
            <text x="670" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Apply controls</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Pseudonymisation & Anonymisation Engineering
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Two Techniques That Are Often Confused</h2>

    <p>Pseudonymisation replaces identifying fields with a token or reference, while keeping a separate key that can reverse the process. Anonymisation goes further, removing or transforming data so thoroughly that no key exists to reverse it and no individual can ever be re-identified.</p>

    <p>Imagine a locked filing cabinet holding a list that maps customer names to reference numbers. As long as that list exists, the reference numbers are pseudonymised, not anonymous. Now imagine shredding that list entirely. Once it is gone, the reference numbers can never be traced back to a name, and the data is truly anonymised.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>Pseudonymisation</th>
                <th>Anonymisation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Reversible</td>
                <td>Yes, with the separately held key.</td>
                <td>No, permanently irreversible.</td>
            </tr>
            <tr>
                <td>GDPR scope</td>
                <td>Still considered personal data.</td>
                <td>Falls outside GDPR scope entirely.</td>
            </tr>
            <tr>
                <td>Example technique</td>
                <td>Tokenization with a secure lookup table.</td>
                <td>Data aggregation with individual fields removed.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Mistake</h4>
        <p>Pseudonymised data is still personal data under GDPR. Teams sometimes treat it as safe to share freely, but the moment the key exists somewhere, the data remains fully in scope.</p>
    </div>
</div>
HTML;

// TASK 4: Encryption of Personal Data
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Encryption as a Required Control, Not an Extra</h2>

    <p>Encryption protects personal data by making it unreadable without the correct key. GDPR treats encryption as one of the standard technical measures organizations are expected to apply, not an optional upgrade.</p>

    <p>There are two distinct points where encryption applies. Encryption at rest protects data sitting in a database or file store, like a locked safe. Encryption in transit protects data while it moves across a network, like an armored car carrying cash between banks.</p>

    <!-- SVG: Data flow between database and user showing at-rest and in-transit points
         Teaching purpose: show the learner these are two distinct protection points,
         which they would otherwise treat as a single generic "encryption" concept. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Encryption at rest and in transit">
            <rect x="20" y="40" width="150" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Database</text>
            <text x="95" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Encrypted at rest</text>

            <line x1="175" y1="70" x2="580" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="6,4" marker-end="url(#arr3)"/>
            <text x="380" y="55" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Encrypted in transit</text>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <rect x="590" y="40" width="150" height="60" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="665" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">User Device</text>
            <text x="665" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Receives data</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Encryption Is One Control Among Several</h4>
        <p>Encrypting personal data does not, by itself, make a system GDPR compliant. It must be combined with discovery, classification, access controls, logging, and retention enforcement.</p>
    </div>
</div>
HTML;

// TASK 5: Access Logging & DSAR Workflows
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Proving Who Accessed What, and Answering Requests</h2>

    <p>Access logging records who accessed personal data, when, and from where. This is the evidence base an organization needs when investigating incidents or demonstrating accountability to a regulator.</p>

    <p>Access logs also support one of the most common individual rights requests under GDPR, the Data Subject Access Request, or DSAR. A DSAR asks an organization to provide a copy of all personal data it holds about the requester.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>DSAR Stage</th>
                <th>Standard Deadline</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Request received</td>
                <td>Day 0</td>
            </tr>
            <tr>
                <td>Identity verification</td>
                <td>As soon as practical after receipt</td>
            </tr>
            <tr>
                <td>Data compiled and reviewed</td>
                <td>Within the response window</td>
            </tr>
            <tr>
                <td>Response sent to requester</td>
                <td>One month, extendable by two further months for complex requests</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What a DSAR Response Should Exclude</h4>
        <p>A valid DSAR response includes only personal data belonging to the requester. It must exclude third party personal data and properly anonymised data, since anonymised data cannot be linked to any individual, including the requester.</p>
    </div>
</div>
HTML;

// TASK 6: Retention Enforcement
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Deleting Data Is as Important as Collecting It</h2>

    <p>Data minimisation does not end once data is collected responsibly. GDPR's storage limitation principle requires that personal data be kept only as long as necessary for the purpose it was collected for, then deleted.</p>

    <p>A retention policy defines exactly how long each type of data may be kept. Picture a filing cabinet with an automatic shredder built into a timer, documents are not reviewed manually for deletion, they are destroyed automatically once their retention period expires.</p>

    <!-- SVG: Data lifecycle timeline showing creation, retention period, and deletion
         Teaching purpose: show the learner that retention is a time-bound,
         automatically enforced process, which they otherwise assume is an
         occasional manual cleanup task. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 100" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Data retention timeline">
            <line x1="40" y1="50" x2="720" y2="50" stroke="var(--border)" stroke-width="2"/>
            <circle cx="60" cy="50" r="7" fill="var(--primary, var(--text-primary))"/>
            <text x="60" y="30" text-anchor="middle" font-size="12" fill="var(--text-primary)">Data Created</text>

            <circle cx="400" cy="50" r="7" fill="var(--text-secondary)"/>
            <text x="400" y="30" text-anchor="middle" font-size="12" fill="var(--text-primary)">Retention Period</text>

            <circle cx="700" cy="50" r="7" fill="var(--success, var(--text-primary))"/>
            <text x="700" y="30" text-anchor="middle" font-size="12" fill="var(--text-primary)">Automatic Deletion</text>
        </svg>
    </div>
</div>
HTML;

// TASK 7: Breach Detection & 72-Hour Notification
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Detecting a Breach and the Clock That Follows</h2>

    <p>Breach detection controls monitor systems for events that indicate personal data has been accessed, altered, or disclosed without authorization. Not every security anomaly is a notifiable breach, so detection must be paired with accurate classification of the event.</p>

    <p>Under Article 33, once an organization becomes aware of a notifiable breach, it has 72 hours to report it to the relevant supervisory authority. The clock starts at awareness of the incident, not once the investigation is fully confirmed.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Incident Type</th>
                <th>Notifiable Under Article 33?</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Unauthorized access to a customer database</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td>Lost laptop containing unencrypted personal data</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td>Failed login attempt blocked by existing controls</td>
                <td>No</td>
            </tr>
            <tr>
                <td>Internal test environment using anonymised sample data</td>
                <td>No</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The Clock Starts at Awareness</h4>
        <p>The 72 hour window begins the moment the organization becomes aware of the breach, not once every detail has been confirmed. Waiting for full certainty before starting the clock is a common and costly mistake.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Meridian Retail has received a Data Subject Access Request from a customer named Alina Cole. Her personal data is scattered across several internal systems, some in plain text, some behind a pseudonymised reference, and some mixed in with anonymised aggregate reports that do not belong in her response.</p>

    <p>Open the DSAR Fulfillment Console and locate every piece of data that genuinely belongs to Alina Cole across the available panels. Leave out anything that cannot be linked back to her, including properly anonymised data. Submit your response once you are confident the data set is complete and correct.</p>

    <div class="practical-launch-wrapper">
        <a href="gdpr-technical-controls-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch DSAR Fulfillment Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You now understand the technical controls that turn GDPR from a legal document into an operational reality. Discovery and classification tell an organization what it holds, pseudonymisation and anonymisation and encryption protect it, access logging and DSAR workflows answer to it, retention enforcement limits how long it is kept, and breach detection ensures problems are reported within the legal window. Privacy by design ties all of these together from the very start of a system's life.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Privacy by design and by default means safeguards are built in from the start, not added later.</li>
        <li>Data discovery and classification must happen before any protection control is applied.</li>
        <li>Pseudonymised data is still personal data under GDPR, only anonymised data falls outside its scope.</li>
        <li>Encryption at rest and in transit are both required, and neither alone equals compliance.</li>
        <li>DSAR responses must exclude third party and anonymised data, and are due within one month.</li>
        <li>Storage limitation requires retention policies with automatic, time-bound deletion.</li>
        <li>Notifiable breaches must be reported within 72 hours of awareness under Article 33.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
