<?php
// ============================================================
// security-architecture-frameworks.php — ROOM DATA FILE
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'security-architecture-frameworks',
    'title'           => 'Security Architecture Frameworks',
    'description'     => 'Learn how SABSA, TOGAF security extensions, and the OSA pattern catalogue guide the design of secure systems from business requirements down to technical controls.',
    'icon'            => 'fas fa-drafting-compass',
    'banner'          => '../../assets/banner-security-architecture.png',
    'difficulty'      => 'Expert',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'General security fundamentals', 'Familiarity with enterprise IT environments'],
    'learning_objectives' => [
        'Explain the purpose and driving philosophy of SABSA, TOGAF security extensions, and OSA',
        'Describe SABSA\'s business attribute driven layered model',
        'Explain how TOGAF\'s ADM is extended with security checkpoints',
        'Describe how OSA\'s pattern catalogue supports reusable control design',
        'Select the appropriate framework for a given organizational context',
        'Trace a business requirement through to a concrete security control',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/security-architecture-frameworks-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'SABSA Fundamentals'],
    ['id' => 'task3', 'title' => 'TOGAF Security Extensions'],
    ['id' => 'task4', 'title' => 'OSA Pattern Catalogue'],
    ['id' => 'task5', 'title' => 'Choosing the Right Framework'],
    ['id' => 'task6', 'title' => 'Mapping Requirements to Controls'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'security_architecture_frameworks_progress',
    'instagram_takeaways'  => [
        '✓ SABSA drives architecture from business risk downward',
        '✓ TOGAF security extensions embed checkpoints into an existing ADM cycle',
        '✓ OSA provides a reusable catalogue of proven security patterns',
        '✓ Every control should trace back to a business requirement',
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
        ['id' => 'q1', 'text' => 'What is the name of the top layer in the SABSA model, where business requirements are captured?'],
        ['id' => 'q2', 'text' => 'What term describes a business driven security requirement in SABSA, such as "customer trust"?'],
        ['id' => 'q3', 'text' => 'Which SABSA layer defines the physical security mechanisms and technology used?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the name of TOGAF\'s core iterative process for developing enterprise architecture?'],
        ['id' => 'q5', 'text' => 'What term describes the security requirements injected into each phase of the ADM?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What does OSA provide as its core output, a library of reusable security ___?'],
        ['id' => 'q7', 'text' => 'OSA organizes its patterns by domain, including identity, network, application, and ___?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'Which framework is best suited when an organization needs to extend an existing enterprise architecture process with security checkpoints?'],
        ['id' => 'q9', 'text' => 'Which framework is best suited for quickly implementing proven, reusable security designs when no architecture team exists?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'In the traceability chain, what comes directly after a business requirement is defined?'],
        ['id' => 'q11', 'text' => 'What is the term for the documented expectation a control must satisfy, derived from a business attribute?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Enter the flag revealed in the Recommendation Report.'],
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
    <p>Every secure system eventually outgrows ad hoc decisions. A firewall rule added here, an access control tweak added there, works fine for a small environment, but it collapses once systems, regulations and stakeholders multiply. Security architecture frameworks exist to solve this by giving engineers a repeatable, defensible way to design security into a system from the very first requirement.</p>

    <p>This room introduces three of the most widely used frameworks: SABSA, TOGAF's security extensions, and the OSA pattern catalogue. You will learn what each framework is built to do, how to choose the right one for a real engagement, and how to trace a business requirement all the way down to a concrete technical control. A hands on practical lets you apply that selection skill directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the purpose and driving philosophy of SABSA, TOGAF security extensions, and OSA.</li>
        <li>Describe SABSA's business attribute driven layered model.</li>
        <li>Explain how TOGAF's ADM is extended with security checkpoints.</li>
        <li>Describe how OSA's pattern catalogue supports reusable control design.</li>
        <li>Select the appropriate framework for a given organizational context.</li>
        <li>Trace a business requirement through to a concrete security control.</li>
    </ul>
</div>
HTML;

// TASK 2: SABSA Fundamentals
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Architecture from the Business Down</h2>

    <p>SABSA (Sherwood Applied Business Security Architecture) is built on a single idea: every security control should exist because a real business need demands it. Rather than starting with technology, SABSA starts by asking what the business actually needs to protect and why.</p>

    <p>That need is captured as a <strong>business attribute</strong>, a specific, measurable quality the business cares about, such as availability, confidentiality or non repudiation. SABSA takes that attribute and works down through six layers until it reaches a physical, operational control.</p>

    <p>Think of SABSA like an architect's blueprint for a building. The client's vision of a home worth living in eventually becomes a foundation plan, wiring diagrams and finally an as built survey. Nothing in the final building exists without tracing back to that original vision.</p>

    <h3>The Six SABSA Layers</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Layer</th>
                <th>Key Question</th>
                <th>Focus</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Contextual</td><td>What is the business?</td><td>Business goals, risks and drivers</td></tr>
            <tr><td>Conceptual</td><td>What is the security strategy?</td><td>High level architecture and principles</td></tr>
            <tr><td>Logical</td><td>What are the specific requirements?</td><td>Logical services and information flows</td></tr>
            <tr><td>Physical</td><td>What technology enforces this?</td><td>Specific technologies and mechanisms</td></tr>
            <tr><td>Component</td><td>What products are used?</td><td>Product and tool selection</td></tr>
            <tr><td>Operational</td><td>How is it run day to day?</td><td>Operational procedures and monitoring</td></tr>
        </tbody>
    </table>

    <!-- SVG: SABSA layered stack
         Teaching purpose: show the learner that SABSA is a single traceable chain running from
         business context down to daily operations, which they would otherwise misunderstand as
         six separate, unrelated checklists. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 620 500" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SABSA six layer traceability stack">
            <!-- Six stacked layer boxes -->
            <rect x="30" y="10"  width="420" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="30" y="82"  width="420" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="30" y="154" width="420" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="30" y="226" width="420" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="30" y="298" width="420" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="30" y="370" width="420" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <!-- Layer labels -->
            <text x="240" y="45"  text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Contextual</text>
            <text x="240" y="117" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Conceptual</text>
            <text x="240" y="189" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Logical</text>
            <text x="240" y="261" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Physical</text>
            <text x="240" y="333" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Component</text>
            <text x="240" y="405" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Operational</text>

            <!-- Traceability arrow along the side -->
            <line x1="490" y1="25" x2="490" y2="425" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#downarrow)"/>
            <defs>
                <marker id="downarrow" markerWidth="8" markerHeight="8" refX="4" refY="6" orient="auto">
                    <path d="M0,0 L8,0 L4,8 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="510" y="230" font-size="12" fill="var(--text-secondary)" transform="rotate(90 510 230)" text-anchor="middle">Traceability</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What Is a Business Attribute?</h4>
        <p>A business attribute is a specific, testable quality the business needs, expressed in business language rather than technical language. For example, "confidential" becomes the attribute "customer data confidentiality", which SABSA then traces down to encryption standards and access controls at the technical layers.</p>
    </div>
</div>
HTML;

// TASK 3: TOGAF Security Extensions
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Adding Security Checkpoints to an Existing Cycle</h2>

    <p>TOGAF is a general purpose framework for planning, designing and governing enterprise IT, built around a repeatable cycle called the Architecture Development Method, or ADM. It was not written with security as its primary focus.</p>

    <p>TOGAF's security extensions do not replace the ADM. They add a set of security checkpoints into the phases that already exist, so an organization already running TOGAF gains security oversight without adopting an entirely new methodology.</p>

    <h3>Security Checkpoints Across the ADM</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>ADM Phase</th>
                <th>Security Checkpoint</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Architecture Vision</td><td>Confirm security stakeholders and high level risk appetite</td></tr>
            <tr><td>Business Architecture</td><td>Identify security related business requirements</td></tr>
            <tr><td>Information Systems Architectures</td><td>Define data classification and access requirements</td></tr>
            <tr><td>Technology Architecture</td><td>Select security technologies and controls</td></tr>
            <tr><td>Opportunities and Solutions</td><td>Assess security impact of proposed solutions</td></tr>
            <tr><td>Implementation Governance</td><td>Verify controls are implemented as designed</td></tr>
        </tbody>
    </table>

    <!-- SVG: TOGAF ADM cycle with checkpoint markers
         Teaching purpose: show the learner that TOGAF security extensions add checkpoints onto
         an existing generic process, which they would otherwise misunderstand as a standalone
         security methodology like SABSA. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 500 500" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="TOGAF ADM cycle with security checkpoints">
            <!-- Outer cycle -->
            <circle cx="250" cy="250" r="180" fill="none" stroke="var(--border)" stroke-width="2"/>
            <!-- Phase nodes around the circle -->
            <circle cx="250" cy="70"  r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <circle cx="390" cy="140" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <circle cx="430" cy="290" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <circle cx="340" cy="410" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <circle cx="160" cy="410" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <circle cx="70"  cy="290" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <circle cx="110" cy="140" r="26" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <text x="250" y="75"  text-anchor="middle" font-size="11" fill="var(--text-primary)">Vision</text>
            <text x="390" y="145" text-anchor="middle" font-size="11" fill="var(--text-primary)">Business</text>
            <text x="430" y="295" text-anchor="middle" font-size="10" fill="var(--text-primary)">Info Sys</text>
            <text x="340" y="415" text-anchor="middle" font-size="10" fill="var(--text-primary)">Tech Arch</text>
            <text x="160" y="415" text-anchor="middle" font-size="10" fill="var(--text-primary)">Opp/Sol</text>
            <text x="70"  y="295" text-anchor="middle" font-size="10" fill="var(--text-primary)">Migration</text>
            <text x="110" y="145" text-anchor="middle" font-size="9"  fill="var(--text-primary)">Impl Gov</text>

            <!-- Checkpoint markers on three phases -->
            <circle cx="250" cy="70"  r="6" fill="var(--primary)"/>
            <circle cx="430" cy="290" r="6" fill="var(--primary)"/>
            <circle cx="110" cy="140" r="6" fill="var(--primary)"/>

            <text x="250" y="250" text-anchor="middle" font-size="12" fill="var(--text-secondary)">ADM Cycle</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> TOGAF vs SABSA</h4>
        <p>TOGAF is a general enterprise architecture method that can be used with or without security in mind. SABSA is security specific from the start. Many organizations use both together, running TOGAF's ADM for the overall architecture while injecting SABSA's business attribute thinking at the security checkpoints.</p>
    </div>
</div>
HTML;

// TASK 4: OSA Pattern Catalogue
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Reusing Proven Security Designs</h2>

    <p>The Open Security Architecture project, known as OSA, is a free, community maintained catalogue of security patterns. Instead of designing a control from first principles every time, an engineer can look up a pattern that already solves a similar problem.</p>

    <p>Patterns are organized by domain, covering areas such as identity, network, application and data. Each pattern describes a recurring security problem along with a proven, documented way to solve it.</p>

    <h3>Example Pattern Categories</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Example Pattern</th>
                <th>What It Solves</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Identity</td><td>Federated single sign on</td><td>Consistent authentication across multiple systems</td></tr>
            <tr><td>Network</td><td>DMZ segmentation</td><td>Isolating public facing services from internal networks</td></tr>
            <tr><td>Application</td><td>Input validation gateway</td><td>Preventing injection attacks against web applications</td></tr>
            <tr><td>Data</td><td>Encryption at rest</td><td>Protecting stored data from unauthorized access</td></tr>
        </tbody>
    </table>

    <!-- SVG: OSA pattern hierarchy
         Teaching purpose: show the learner that OSA organizes security knowledge hierarchically
         from broad domain to specific implementable control, which they would otherwise
         misunderstand as a flat list of generic tips. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 600 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="OSA domain to pattern to control hierarchy">
            <!-- Domain node -->
            <rect x="240" y="10" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="300" y="40" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Domain</text>

            <!-- Pattern nodes -->
            <rect x="100" y="110" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="170" y="140" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Pattern</text>
            <rect x="360" y="110" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="430" y="140" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Pattern</text>

            <!-- Control nodes -->
            <rect x="30"  y="200" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90"  y="230" text-anchor="middle" font-size="12" fill="var(--text-primary)">Control</text>
            <rect x="200" y="200" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="260" y="230" text-anchor="middle" font-size="12" fill="var(--text-primary)">Control</text>

            <!-- Connecting lines -->
            <line x1="270" y1="60" x2="170" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="330" y1="60" x2="430" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="150" y1="160" x2="90"  y2="200" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="190" y1="160" x2="260" y2="200" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Reuse a Pattern?</h4>
        <p>Reusing a vetted pattern saves time and reduces risk compared to designing a control from scratch, because the pattern has already been reviewed, tested and used successfully in other environments.</p>
    </div>
</div>
HTML;

// TASK 5: Choosing the Right Framework
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Matching the Framework to the Engagement</h2>

    <p>No single framework is universally best. The right choice depends on the organization's existing architecture maturity, the pressure it is under from regulators, the size and capacity of its team, and what kind of outcome it actually needs.</p>

    <p>A useful way to decide is to ask what the primary driver is. Is the goal traceability from business risk down to a control? Is it fitting security into an architecture process that already exists? Or is it finding a proven design quickly?</p>

    <h3>Framework Comparison</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Framework</th>
                <th>Primary Driver</th>
                <th>Best Fit</th>
                <th>Typical Output</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SABSA</td>
                <td>Business risk traceability</td>
                <td>Organizations needing board level justification for controls</td>
                <td>Layered model from attribute to control</td>
            </tr>
            <tr>
                <td>TOGAF security extensions</td>
                <td>Existing enterprise architecture process</td>
                <td>Organizations with a mature ADM practice</td>
                <td>Security checkpoints embedded in the ADM</td>
            </tr>
            <tr>
                <td>OSA</td>
                <td>Fast, reusable technical design</td>
                <td>Teams with limited time or architecture capacity</td>
                <td>A selected pattern from the catalogue</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: framework selection decision flow
         Teaching purpose: show the learner that framework choice depends on answering a sequence
         of organizational questions, which they would otherwise misunderstand as picking one
         universally "best" framework. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 620 320" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Framework selection decision flow">
            <rect x="220" y="10" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="310" y="40" text-anchor="middle" font-size="12" fill="var(--text-primary)">Existing EA process?</text>

            <rect x="20" y="110" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="140" text-anchor="middle" font-size="12" fill="var(--text-primary)">Yes: TOGAF</text>

            <rect x="220" y="110" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="310" y="140" text-anchor="middle" font-size="12" fill="var(--text-primary)">No: need speed?</text>

            <rect x="420" y="110" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="510" y="140" text-anchor="middle" font-size="12" fill="var(--text-primary)">Yes: OSA</text>

            <rect x="220" y="220" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="310" y="250" text-anchor="middle" font-size="12" fill="var(--text-primary)">No: SABSA</text>

            <line x1="280" y1="60" x2="130" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="330" y1="60" x2="330" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="400" y1="135" x2="420" y2="135" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="310" y1="160" x2="310" y2="220" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Frameworks Are Not Mutually Exclusive</h4>
        <p>Real engagements often blend all three. A large enterprise might use SABSA for governance and business justification, TOGAF for the overall architecture process, and OSA patterns when it comes time to actually implement a specific control.</p>
    </div>
</div>
HTML;

// TASK 6: Mapping Business Requirements to Security Controls
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>From Requirement to Mechanism</h2>

    <p>Every framework eventually needs to answer the same question: how does a business requirement become a working technical control? SABSA makes this chain explicit, moving from a business requirement to a business attribute, to a control objective, to a specific control, and finally to the mechanism that implements it.</p>

    <p>Consider a trading platform that must remain available at all times. That requirement becomes the business attribute "continuous availability". The control objective is to eliminate any single point of failure. The control chosen is redundant infrastructure, implemented through the mechanism of automatic failover between data centers.</p>

    <h3>Worked Example</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Business Requirement</th>
                <th>Attribute</th>
                <th>Control Objective</th>
                <th>Example Control</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Must support 24/7 uptime for trading platform</td>
                <td>Continuous availability</td>
                <td>Eliminate single points of failure</td>
                <td>Redundant infrastructure with automatic failover</td>
            </tr>
            <tr>
                <td>Must prove non repudiation for financial transactions</td>
                <td>Non repudiation</td>
                <td>Ensure actions cannot be denied</td>
                <td>Digitally signed transaction logs</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: traceability chain
         Teaching purpose: show the learner the unbroken chain from business need to technical
         implementation, which they would otherwise misunderstand as controls being chosen
         independently of business needs. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Business requirement to mechanism traceability chain">
            <rect x="10"  y="30" width="130" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="165" y="30" width="130" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="320" y="30" width="130" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="475" y="30" width="130" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="630" y="30" width="130" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <text x="75"  y="60" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Business</text>
            <text x="75"  y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Requirement</text>
            <text x="230" y="70" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Attribute</text>
            <text x="385" y="60" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Control</text>
            <text x="385" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Objective</text>
            <text x="540" y="70" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Control</text>
            <text x="695" y="70" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Mechanism</text>

            <line x1="140" y1="65" x2="160" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="295" y1="65" x2="315" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="450" y1="65" x2="470" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="605" y1="65" x2="625" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Auditors Care</h4>
        <p>This traceability chain, from business requirement all the way to mechanism, is exactly what auditors and regulators expect to see documented. A control that cannot be traced back to a business requirement is difficult to justify during an audit.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You are acting as a security architecture consultant. Four client organizations have each described their situation, and each needs a recommendation for which framework fits their engagement.</p>

    <p>Read each brief carefully, choose the framework you believe fits best, and use the feedback to refine your reasoning. Once all four cases are matched correctly, your final recommendation report will unlock.</p>

    <div class="practical-launch-wrapper">
        <a href="security-architecture-frameworks-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Framework Selector</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>SABSA, TOGAF's security extensions and OSA each solve a different problem. SABSA gives you traceability from business risk to control. TOGAF's extensions embed security checkpoints into an architecture process that already exists. OSA gives you a library of proven patterns you can reuse instead of designing from scratch.</p>

    <p>Choosing correctly, and sometimes combining more than one, is what separates a defensible security architecture from a collection of disconnected controls. The skill you practiced here, matching a real situation to the right approach, is exactly what you will use in an actual engagement.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>SABSA drives architecture from business risk and business attributes downward.</li>
        <li>TOGAF security extensions inject security checkpoints into an existing enterprise architecture process.</li>
        <li>OSA provides a reusable pattern catalogue for common security problems.</li>
        <li>Framework choice depends on organizational context, not a single universal best option.</li>
        <li>Frameworks are frequently combined rather than used in isolation.</li>
        <li>Every control should trace back to a specific business requirement.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
