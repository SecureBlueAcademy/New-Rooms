<?php
// Filename: ssdlc.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'ssdlc',
    'title'           => 'Secure Software Development Lifecycle (SSDLC)',
    'description'     => 'Learn how to embed security into every phase of the SDLC, from design through post-deployment, and mature your process with BSIMM and OWASP SAMM.',
    'icon'            => 'fas fa-shield-halved',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic software development lifecycle knowledge', 'Familiarity with CI/CD concepts'],
    'learning_objectives' => [
        'Explain the difference between a traditional SDLC and an SSDLC',
        'Identify the security activities that belong in each phase of development',
        'Apply STRIDE based threat modeling to a system architecture',
        'Distinguish SAST from DAST and explain where each fits in a pipeline',
        'Explain how BSIMM and OWASP SAMM support security maturity',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/ssdlc-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is SSDLC?'],
    ['id' => 'task3', 'title' => 'Security Requirements and Design'],
    ['id' => 'task4', 'title' => 'Threat Modelling'],
    ['id' => 'task5', 'title' => 'SAST and DAST'],
    ['id' => 'task6', 'title' => 'Security Testing in QA'],
    ['id' => 'task7', 'title' => 'Vulnerability Management and Maturity'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'ssdlc_progress',
    'instagram_takeaways'  => [
        '✓ Shift left: security belongs in every SDLC phase, not just at the end',
        '✓ STRIDE threat modeling before a single line of code is built',
        '✓ SAST catches issues in source code, DAST catches them at runtime',
        '✓ BSIMM and OWASP SAMM both drive security maturity, one descriptive, one prescriptive',
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
        ['id' => 'q1', 'text' => 'What is the term for moving security activities earlier in the SDLC?'],
        ['id' => 'q2', 'text' => 'What is the term for a software development lifecycle that embeds security into every phase?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What principle states users should only be given the minimum access necessary to do their job?'],
        ['id' => 'q4', 'text' => 'What term describes designing a system so that failures default to a secure state?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What framework categorizes threats into six types, including Spoofing and Tampering?'],
        ['id' => 'q6', 'text' => 'What term describes the point where the trust level changes between two parts of a system?'],
        ['id' => 'q7', 'text' => 'Which STRIDE category corresponds to unauthorized access to sensitive data?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What type of security testing analyzes source code without executing it?'],
        ['id' => 'q9', 'text' => 'What type of security testing analyzes an application while it is running?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What is the term for scanning open source dependencies for known vulnerabilities?'],
        ['id' => 'q11', 'text' => 'What testing technique feeds invalid or random input into a system to find crashes or bugs?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'What framework is based on observed security practices at real organizations rather than a prescriptive standard?'],
        ['id' => 'q13', 'text' => 'What OWASP framework provides a prescriptive maturity model for software assurance?'],
    ],
    'task8' => [
        ['id' => 'q14', 'text' => 'Enter the flag you discovered by completing the threat model.'],
    ],
    'task9' => [
        ['id' => 'q15', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Most software teams still treat security as a final gate: a scan that runs right before release, or a review that happens after the architecture is already locked in. By the time issues surface, the code is written, the design is fixed, and fixing anything costs far more than it would have earlier. A Secure Software Development Lifecycle (SSDLC) changes this by building security into every phase of development instead of bolting it on at the end.</p>

    <p>By the end of this room, you will be able to map specific security activities to each phase of the SDLC, apply STRIDE based threat modeling to a system architecture, and explain how tools like SAST and DAST fit into a modern build pipeline. You will also see how frameworks like BSIMM and OWASP SAMM help organizations mature their security practices over time. A hands-on threat modeling exercise is included to put the theory into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the difference between a traditional SDLC and an SSDLC.</li>
        <li>Identify the security activities that belong in each phase of development.</li>
        <li>Apply STRIDE based threat modeling to a system architecture.</li>
        <li>Distinguish SAST from DAST and explain where each fits in a pipeline.</li>
        <li>Explain how BSIMM and OWASP SAMM support security maturity.</li>
    </ul>
</div>
HTML;

// TASK 2: What is SSDLC and Why Shift Left Matters
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Security as a Process, Not a Checkpoint</h2>

    <p>A traditional SDLC treats security as something that happens near the end: a penetration test before launch, or a scan the week before release. If problems are found at that point, the team faces an uncomfortable choice between delaying the release or shipping with known risk.</p>

    <p>An SSDLC instead treats security as a continuous thread running through every phase, from requirements gathering to post-deployment monitoring. This is often called <strong>shift left</strong>, because security work moves earlier in the timeline rather than staying parked at the end.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Industry research consistently shows that the cost of fixing a defect grows sharply the later it is discovered. A flaw caught during design review might take an hour to fix. The same flaw found in production could mean an incident response, a patch cycle, and reputational damage.</p>
    </div>

    <p>Think of it like proofreading an essay. Catching an awkward sentence while you are still writing costs you a few seconds. Catching it after the essay has been printed and bound into a hundred copies is a different problem entirely.</p>

    <h3>Traditional SDLC vs SSDLC</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>SDLC Phase</th>
                <th>Traditional Approach</th>
                <th>SSDLC Approach</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Requirements</td>
                <td>Functional requirements only</td>
                <td>Security requirements defined alongside functional ones</td>
            </tr>
            <tr>
                <td>Design</td>
                <td>Architecture reviewed for scalability only</td>
                <td>Threat modeling performed during architecture review</td>
            </tr>
            <tr>
                <td>Build</td>
                <td>Code compiled and merged with no automated checks</td>
                <td>SAST and dependency scans run in the pipeline</td>
            </tr>
            <tr>
                <td>Test</td>
                <td>Functional QA only</td>
                <td>Security test cases and DAST included in QA</td>
            </tr>
            <tr>
                <td>Deploy and Operate</td>
                <td>Security reviewed only if an incident occurs</td>
                <td>Continuous vulnerability management and monitoring</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Traditional pipeline vs shift-left pipeline
         Teaching purpose: contrast a pipeline where security is a single late gate against
         one where security activities run at every phase, since learners often assume
         SSDLC simply means adding one more test at the end. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Traditional pipeline compared to shift left pipeline">
            <!-- Traditional pipeline row -->
            <text x="10" y="20" font-size="13" font-weight="600" fill="var(--text-primary)">Traditional</text>
            <rect x="10"  y="30" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="150" y="30" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="290" y="30" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="430" y="30" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="570" y="30" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--text-secondary)" stroke-width="2"/>
            <text x="70"  y="60" text-anchor="middle" font-size="11" fill="var(--text-primary)">Requirements</text>
            <text x="210" y="60" text-anchor="middle" font-size="11" fill="var(--text-primary)">Design</text>
            <text x="350" y="60" text-anchor="middle" font-size="11" fill="var(--text-primary)">Build</text>
            <text x="490" y="60" text-anchor="middle" font-size="11" fill="var(--text-primary)">Test</text>
            <text x="645" y="55" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Security</text>
            <text x="645" y="68" text-anchor="middle" font-size="10" fill="var(--text-secondary)">(one late gate)</text>

            <!-- Shift left pipeline row -->
            <text x="10" y="120" font-size="13" font-weight="600" fill="var(--text-primary)">Shift Left (SSDLC)</text>
            <rect x="10"  y="130" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <rect x="150" y="130" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <rect x="290" y="130" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <rect x="430" y="130" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <rect x="570" y="130" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="70"  y="155" text-anchor="middle" font-size="11" fill="var(--text-primary)">Requirements</text>
            <text x="70"  y="172" text-anchor="middle" font-size="9" fill="var(--success)">+ security reqs</text>
            <text x="210" y="155" text-anchor="middle" font-size="11" fill="var(--text-primary)">Design</text>
            <text x="210" y="172" text-anchor="middle" font-size="9" fill="var(--success)">+ threat model</text>
            <text x="350" y="155" text-anchor="middle" font-size="11" fill="var(--text-primary)">Build</text>
            <text x="350" y="172" text-anchor="middle" font-size="9" fill="var(--success)">+ SAST</text>
            <text x="490" y="155" text-anchor="middle" font-size="11" fill="var(--text-primary)">Test</text>
            <text x="490" y="172" text-anchor="middle" font-size="9" fill="var(--success)">+ DAST</text>
            <text x="645" y="155" text-anchor="middle" font-size="11" fill="var(--text-primary)">Deploy</text>
            <text x="645" y="172" text-anchor="middle" font-size="9" fill="var(--success)">+ monitoring</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Security Requirements and Secure Design
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Building Security In From the Start</h2>

    <p>Security requirements are statements about how a system must behave to protect its data and users, and they deserve the same rigor as functional requirements. "The system must encrypt data at rest" or "only an authenticated admin may delete an account" are both testable requirements, not vague goals.</p>

    <p>Fire codes work the same way. A building's fire safety measures are specified before construction begins, not inspected for the first time once the building is already occupied. Waiting until the end to ask "is this secure?" is far too late to change the foundation.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>A security requirement only has value if it can be verified. "Make it secure" cannot be tested. "Passwords must be hashed with a salted algorithm before storage" can be.</p>
    </div>

    <h3>Core Secure Design Principles</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Principle</th>
                <th>Definition</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Least Privilege</strong></td>
                <td>Users and processes get only the access needed to do their job</td>
                <td>A reporting service can read sales data but cannot write to it</td>
            </tr>
            <tr>
                <td>Defense in Depth</td>
                <td>Multiple layers of security controls, so one failure does not expose the whole system</td>
                <td>A firewall, input validation, and encryption all protecting the same data</td>
            </tr>
            <tr>
                <td>Fail Securely</td>
                <td>When something breaks, the system defaults to a secure state rather than an open one</td>
                <td>An authentication service that denies access on error instead of allowing it</td>
            </tr>
            <tr>
                <td>Secure by Default</td>
                <td>The default configuration is the safest one, not the most permissive one</td>
                <td>A new user account starts with no admin rights until explicitly granted</td>
            </tr>
            <tr>
                <td>Separation of Duties</td>
                <td>No single person or process can complete a sensitive action alone</td>
                <td>Code changes require a second reviewer before merging to production</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 4: Threat Modelling at Architecture Review
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Finding Weaknesses Before a Single Line of Code Exists</h2>

    <p>Threat modeling is the practice of systematically identifying what could go wrong in a system's design before it is built. It happens during architecture review, using a data flow diagram of the proposed system rather than the finished product.</p>

    <p>It is much like a security review of a building's blueprint. Every door, window, and vent is identified and assessed before construction starts, because it is far cheaper to move a door on paper than to move a wall after the building is standing.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Trust Boundary</h4>
        <p>A <strong>trust boundary</strong> is any point in a system where the level of trust changes, for example where an external user's request crosses into an internal service. Threats concentrate at these boundaries.</p>
    </div>

    <h3>STRIDE</h3>
    <p>STRIDE is the most widely used framework for categorizing threats during modeling. Each letter represents a category of thing that can go wrong.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>STRIDE Category</th>
                <th>Question it Answers</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Spoofing</td>
                <td>Can someone pretend to be someone else?</td>
                <td>Using a stolen session token to impersonate a user</td>
            </tr>
            <tr>
                <td>Tampering</td>
                <td>Can someone alter data in transit or at rest?</td>
                <td>Modifying a request parameter before it reaches the API</td>
            </tr>
            <tr>
                <td>Repudiation</td>
                <td>Can someone deny having performed an action?</td>
                <td>No logs exist to prove who deleted a record</td>
            </tr>
            <tr>
                <td>Information Disclosure</td>
                <td>Can sensitive data be exposed to the wrong party?</td>
                <td>Unauthorized access to records in a database</td>
            </tr>
            <tr>
                <td>Denial of Service</td>
                <td>Can the system be made unavailable?</td>
                <td>Flooding a service with requests until it stops responding</td>
            </tr>
            <tr>
                <td>Elevation of Privilege</td>
                <td>Can someone gain more access than they should have?</td>
                <td>Bypassing an authorization check to reach admin functions</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Data flow diagram with a trust boundary
         Teaching purpose: show learners that threat modeling maps threats to specific trust
         boundaries rather than listing generic bad outcomes, since learners often misunderstand
         threat modeling as an unstructured brainstorm. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Data flow diagram with a trust boundary">
            <!-- Trust boundary line -->
            <line x1="220" y1="10" x2="220" y2="190" stroke="var(--text-secondary)" stroke-width="2" stroke-dasharray="6,4"/>
            <text x="225" y="20" font-size="11" fill="var(--text-secondary)">Trust Boundary</text>

            <!-- Untrusted zone -->
            <circle cx="100" cy="100" r="45" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="95" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">External</text>
            <text x="100" y="110" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">User</text>

            <!-- Arrow across boundary -->
            <line x1="145" y1="100" x2="290" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <!-- Trusted zone -->
            <rect x="290" y="60" width="120" height="80" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="105" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">API</text>

            <line x1="410" y1="100" x2="470" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>

            <rect x="470" y="60" width="120" height="80" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="530" y="105" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Database</text>
        </svg>
    </div>
</div>
HTML;

// TASK 5: SAST and DAST in the Build Pipeline
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Two Different Ways to Catch Vulnerabilities</h2>

    <p><strong>SAST</strong>, static application security testing, analyzes source code without running it. It scans the codebase directly, looking for known insecure patterns such as hardcoded credentials or unsafe string handling.</p>

    <p><strong>DAST</strong>, dynamic application security testing, analyzes a running application from the outside. It behaves like an attacker probing a live system, sending requests and observing how the application responds.</p>

    <p>SAST is like proofreading a manuscript before it goes to print, catching structural problems in the text itself. DAST is like test driving the finished car, checking how it actually behaves once it is built and moving.</p>

    <h3>SAST vs DAST</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th></th>
                <th>SAST</th>
                <th>DAST</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>What it Analyzes</td>
                <td>Source code, without execution</td>
                <td>A running application, from the outside</td>
            </tr>
            <tr>
                <td>When it Runs</td>
                <td>At commit or build time</td>
                <td>Against a staging or pre production environment</td>
            </tr>
            <tr>
                <td>Strengths</td>
                <td>Finds issues early, pinpoints exact code location</td>
                <td>Finds runtime and configuration issues SAST cannot see</td>
            </tr>
            <tr>
                <td>Limitations</td>
                <td>Cannot see issues that only appear at runtime</td>
                <td>Runs later in the pipeline, harder to trace to a code line</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: SAST and DAST placement in the pipeline
         Teaching purpose: show learners that SAST runs at commit and build stage while DAST
         runs later against staging, since learners often assume the two tools are interchangeable
         or run at the same point. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SAST and DAST placement in the pipeline">
            <rect x="10"  y="40" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="190" y="40" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="370" y="40" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="550" y="40" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <line x1="150" y1="70" x2="185" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="330" y1="70" x2="365" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="510" y1="70" x2="545" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <text x="80"  y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Commit</text>
            <text x="80"  y="82" text-anchor="middle" font-size="10" fill="var(--success)">SAST runs here</text>
            <text x="260" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Build</text>
            <text x="440" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Staging</text>
            <text x="440" y="82" text-anchor="middle" font-size="10" fill="var(--success)">DAST runs here</text>
            <text x="620" y="65" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Production</text>
        </svg>
    </div>
</div>
HTML;

// TASK 6: Security Testing in QA
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Testing for What Should Not Happen</h2>

    <p>Functional QA asks whether the application does what it is supposed to do. Security testing asks a different question: can the application be made to do something it should not. Both belong in the same QA process, not separate ones.</p>

    <p>This means QA plans need dedicated security test cases, not just an assumption that a scanner somewhere else will catch everything.</p>

    <ul>
        <li><strong>Manual Penetration Testing:</strong> a skilled tester actively attempts to break the application, simulating a real attacker.</li>
        <li><strong>Software Composition Analysis (SCA):</strong> scans third party and open source dependencies for known vulnerabilities.</li>
        <li><strong>Fuzz Testing:</strong> feeds invalid, unexpected, or random input into the application to see what breaks.</li>
        <li><strong>Security Regression Tests:</strong> confirm that a previously fixed vulnerability has not been reintroduced.</li>
    </ul>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Where Vulnerabilities Actually Live</h4>
        <p>Most real world vulnerabilities are found in third party and open source dependencies, not in an organization's own custom code. This is why SCA is not optional in a mature SSDLC.</p>
    </div>
</div>
HTML;

// TASK 7: Post-Deployment Vulnerability Management and Maturity Models
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Security Does Not End at Deployment</h2>

    <p>Once software ships, new vulnerabilities in its dependencies are discovered constantly. Vulnerability management is the ongoing process of monitoring for new CVEs affecting production systems, assessing their impact, and patching before they can be exploited.</p>

    <p>This connects directly to incident response. A well run vulnerability management process reduces how often incident response is even needed, because known issues get patched before an attacker finds them.</p>

    <h3>Maturing an Organization's SSDLC</h3>
    <p>Two frameworks are commonly used to measure and guide this maturity: BSIMM and OWASP SAMM.</p>

    <p>BSIMM is like a medical study measuring what real hospitals actually do in practice, built entirely from observed data across participating organizations. OWASP SAMM is more like a certification checklist a hospital follows to systematically improve its own practices.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Framework</th>
                <th>Type</th>
                <th>Approach</th>
                <th>Best Used For</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>BSIMM</strong></td>
                <td>Descriptive</td>
                <td>Measures what organizations actually do, based on observed data</td>
                <td>Benchmarking against industry practice</td>
            </tr>
            <tr>
                <td><strong>OWASP SAMM</strong></td>
                <td>Prescriptive</td>
                <td>Provides a self assessment roadmap to improve practices</td>
                <td>Planning and guiding maturity improvements</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Maturity is a journey, not a single audit. Moving from ad-hoc security practices to a structured SSDLC happens incrementally, one improved practice at a time.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have been handed the architecture diagram for a simple web application: a web client, an auth service, an API, and a database. Your job is to act as the security architect performing the threat modeling step of the architecture review, before any code is built.</p>

    <p>For each component, assign the STRIDE category that best describes its primary risk. Use what you learned about trust boundaries and the STRIDE framework to guide your choices.</p>

    <div class="practical-launch-wrapper">
        <a href="ssdlc-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Threat Model Table</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You now understand how security spans the entire software development lifecycle rather than living in a single late stage gate. Security requirements are defined alongside functional ones, threat modeling happens before a single line of code is written, SAST and DAST cover different stages of the pipeline, QA tests for what should not happen, and vulnerability management continues long after deployment.</p>

    <p>Frameworks like BSIMM and OWASP SAMM give organizations a way to measure and guide this maturity over time, moving from ad-hoc practices toward a structured, repeatable process.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Shift left means moving security activities earlier, reducing the cost of fixing issues.</li>
        <li>Security requirements must be specific and testable, not vague goals.</li>
        <li>STRIDE based threat modeling identifies risks at trust boundaries before build starts.</li>
        <li>SAST analyzes source code early, DAST analyzes a running application later in the pipeline.</li>
        <li>QA must include dedicated security test cases, not rely solely on scanners elsewhere.</li>
        <li>Vulnerability management continues after deployment through monitoring and patching.</li>
        <li>BSIMM is descriptive and observational, OWASP SAMM is prescriptive and roadmap driven.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
