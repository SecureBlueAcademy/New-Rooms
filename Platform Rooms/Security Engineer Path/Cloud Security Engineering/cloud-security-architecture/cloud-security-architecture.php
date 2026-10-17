<?php
// cloud-security-architecture.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'cloud-security-architecture',
    'title'           => 'Cloud Security Architecture',
    'description'     => 'Master the shared responsibility model and the core architectural patterns behind secure cloud environments.',
    'icon'            => 'fas fa-cloud',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic cloud computing knowledge', 'Familiarity with IaaS, PaaS, and SaaS concepts'],
    'learning_objectives' => [
        'Explain the shared responsibility model across IaaS, PaaS, and SaaS',
        'Design a segmented landing zone using account and subscription separation',
        'Describe hub-and-spoke and transit gateway network topologies',
        'Explain why centralized logging and monitoring is architecturally necessary',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/cloud-security-architecture-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'The Shared Responsibility Model'],
    ['id' => 'task3', 'title' => 'Landing Zone Design and Account Segmentation'],
    ['id' => 'task4', 'title' => 'Cloud Network Topology'],
    ['id' => 'task5', 'title' => 'Centralized Logging and Monitoring'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'cloud_security_architecture_progress',
    'instagram_takeaways'  => [
        '✓ The shared responsibility model across IaaS, PaaS, and SaaS',
        '✓ Landing zones and account segmentation',
        '✓ Hub-and-spoke and transit gateway network topology',
        '✓ Centralized logging and monitoring architecture',
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
        ['id' => 'q1', 'text' => 'Which service model gives the customer the most security responsibility?'],
        ['id' => 'q2', 'text' => 'Which service model gives the customer the least security responsibility?'],
        ['id' => 'q3', 'text' => 'What is the customer always responsible for classifying and protecting, regardless of service model?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the term for a pre-configured, secure multi-account baseline in cloud environments?'],
        ['id' => 'q5', 'text' => 'What account type sits at the root of a landing zone hierarchy and enforces guardrails?'],
        ['id' => 'q6', 'text' => 'What is the term for limiting blast radius by separating workloads into different accounts?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What network topology centralizes shared services in a single VPC that other VPCs connect to?'],
        ['id' => 'q8', 'text' => 'What service simplifies routing between multiple spoke VPCs without full mesh peering?'],
        ['id' => 'q9', 'text' => 'What networking pattern requires every VPC to connect directly to every other VPC?'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'What is the term for the dedicated account that stores logs separately from workload accounts?'],
        ['id' => 'q11', 'text' => 'What term describes ensuring log data cannot be denied or altered after the fact?'],
    ],
    'task6' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered by deploying the landing zone.'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Cloud environments distribute security responsibility differently than on premises systems. The provider secures parts of the stack, the customer secures other parts, and the boundary between them shifts depending on whether you are using IaaS, PaaS, or SaaS. Misunderstanding where that boundary sits is one of the most common causes of cloud breaches.</p>

    <p>By the end of this room you will be able to explain the shared responsibility model, design a segmented account structure, understand secure cloud network topology, and know why centralized logging matters. A hands on landing zone build is included so you can apply these ideas directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the shared responsibility model across IaaS, PaaS, and SaaS.</li>
        <li>Design a segmented landing zone using account and subscription separation.</li>
        <li>Describe hub and spoke and transit gateway network topologies.</li>
        <li>Explain why centralized logging and monitoring is architecturally necessary.</li>
    </ul>
</div>
HTML;

$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Who Secures What</h2>

    <p>The shared responsibility model splits security duties between the cloud provider and the customer. The provider secures the infrastructure the cloud runs on. The customer secures how they configure and use that infrastructure. This split is often described as security "of the cloud" versus security "in the cloud".</p>

    <p>Where exactly that line falls depends on the service model. In IaaS you manage almost everything above the physical hardware. In SaaS, the provider manages nearly the entire stack, leaving you responsible mainly for how you configure access and what data you put into it.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The One Constant</h4>
        <p>Regardless of service model, the customer always owns data classification and access management decisions. No provider contract removes this responsibility.</p>
    </div>

    <h3>Responsibility Split by Service Model</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Responsibility</th>
                <th>IaaS</th>
                <th>PaaS</th>
                <th>SaaS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Physical Security</td>
                <td>Provider</td>
                <td>Provider</td>
                <td>Provider</td>
            </tr>
            <tr>
                <td>Host / Hypervisor</td>
                <td>Provider</td>
                <td>Provider</td>
                <td>Provider</td>
            </tr>
            <tr>
                <td>OS Patching</td>
                <td>Customer</td>
                <td>Provider</td>
                <td>Provider</td>
            </tr>
            <tr>
                <td>Network Controls</td>
                <td>Customer</td>
                <td>Shared</td>
                <td>Provider</td>
            </tr>
            <tr>
                <td>Identity &amp; Access Management</td>
                <td>Customer</td>
                <td>Customer</td>
                <td>Customer</td>
            </tr>
            <tr>
                <td>Data Encryption / Classification</td>
                <td>Customer</td>
                <td>Customer</td>
                <td>Customer</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG teaching purpose: show the learner that the customer/provider boundary
         moves as service model changes, which they would otherwise misunderstand as
         a fixed line that stays the same across IaaS, PaaS, and SaaS. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Shifting responsibility boundary across service models">
            <!-- IaaS bar -->
            <text x="10" y="30" font-size="13" font-weight="600" fill="var(--text-primary)">IaaS</text>
            <rect x="90" y="14" width="480" height="26" rx="4" fill="var(--primary)" opacity="0.85"/>
            <rect x="570" y="14" width="90" height="26" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="330" y="32" text-anchor="middle" font-size="11" fill="#0a0a0a">Customer</text>
            <text x="615" y="32" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Provider</text>

            <!-- PaaS bar -->
            <text x="10" y="100" font-size="13" font-weight="600" fill="var(--text-primary)">PaaS</text>
            <rect x="90" y="84" width="260" height="26" rx="4" fill="var(--primary)" opacity="0.85"/>
            <rect x="350" y="84" width="310" height="26" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="220" y="102" text-anchor="middle" font-size="11" fill="#0a0a0a">Customer</text>
            <text x="505" y="102" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Provider</text>

            <!-- SaaS bar -->
            <text x="10" y="170" font-size="13" font-weight="600" fill="var(--text-primary)">SaaS</text>
            <rect x="90" y="154" width="110" height="26" rx="4" fill="var(--primary)" opacity="0.85"/>
            <rect x="200" y="154" width="460" height="26" rx="4" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="145" y="172" text-anchor="middle" font-size="11" fill="#0a0a0a">Customer</text>
            <text x="430" y="172" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Provider</text>

            <text x="90" y="205" font-size="11" fill="var(--text-secondary)">Customer responsibility narrows as more of the stack is managed for you.</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>The boundary moves. The customer's core duties around identity and data never disappear.</p>
    </div>
</div>
HTML;

$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Building a Secure Foundation</h2>

    <p>A single cloud account holding every workload, every environment, and every team is a common but dangerous starting point. If that one account is compromised, everything inside it is exposed. A landing zone solves this by providing a pre-configured, secure multi-account baseline before any workload is deployed.</p>

    <p>Think of a single account like one master key that opens every door in a building. A landing zone instead issues separate keys for separate zones, so losing one key does not expose the entire building.</p>

    <h3>The Core Account Structure</h3>
    <p>A typical landing zone separates accounts by function. A Management Account sits at the root and defines organization wide guardrails. Beneath it sit a Security and Audit Account, a Log Archive Account, and a Shared Services Account. Workload accounts, split between production and non production, connect beneath Shared Services so they inherit consistent networking and policy without being mixed together.</p>

    <!-- SVG teaching purpose: show the learner the correct landing zone hierarchy shape,
         which they would otherwise misunderstand as a flat list of unrelated accounts
         rather than a structured parent-child tree with policy inheritance. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Landing zone account hierarchy">
            <!-- Management account -->
            <rect x="290" y="10" width="120" height="46" rx="8" fill="var(--primary)" opacity="0.9"/>
            <text x="350" y="38" text-anchor="middle" font-size="12" font-weight="600" fill="#0a0a0a">Management</text>

            <!-- Connectors to level 2 -->
            <line x1="350" y1="56" x2="130" y2="100" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="350" y1="56" x2="350" y2="100" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="350" y1="56" x2="570" y2="100" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <!-- Level 2 accounts -->
            <rect x="60"  y="100" width="140" height="46" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="130" y="128" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Security / Audit</text>

            <rect x="280" y="100" width="140" height="46" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="128" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Log Archive</text>

            <rect x="500" y="100" width="140" height="46" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="570" y="122" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Shared Services</text>
            <text x="570" y="136" text-anchor="middle" font-size="10" fill="var(--text-secondary)">/ Network</text>

            <!-- Connectors to level 3 -->
            <line x1="570" y1="146" x2="470" y2="195" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="570" y1="146" x2="640" y2="195" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <!-- Level 3 workload accounts -->
            <rect x="380" y="195" width="150" height="46" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="455" y="223" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Workload (Prod)</text>

            <rect x="560" y="195" width="150" height="46" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="635" y="217" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Workload</text>
            <text x="635" y="230" text-anchor="middle" font-size="10" fill="var(--text-secondary)">(Non-Production)</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Mistake</h4>
        <p>Mixing production and non production workloads in the same account removes the isolation a landing zone is meant to provide. A mistake in a test environment can then directly affect production.</p>
    </div>
</div>
HTML;

$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Connecting Accounts Securely</h2>

    <p>Once workloads live in separate accounts, they still need to communicate. Connecting every account directly to every other account, known as full mesh peering, quickly becomes unmanageable and hard to inspect. Hub and spoke topology solves this by centralizing shared network services in one place.</p>

    <p>In a hub and spoke design, a central hub VPC or VNet holds shared services such as firewalls and traffic inspection. Workload VPCs act as spokes and route through the hub rather than connecting to each other directly. A transit gateway, or Virtual WAN in Azure, manages this routing so spokes do not need individual connections to every other spoke.</p>

    <p>An airport works the same way. Flights rarely go directly between two small cities. They route through a central hub, where security screening happens once, consistently, for everyone passing through.</p>

    <!-- SVG teaching purpose: show the learner that spokes route through the hub rather
         than talking to each other directly, which they would otherwise misunderstand as
         a flat network where every VPC can freely reach every other VPC. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Hub and spoke network topology">
            <!-- Hub -->
            <rect x="290" y="100" width="120" height="60" rx="8" fill="var(--primary)" opacity="0.9"/>
            <text x="350" y="126" text-anchor="middle" font-size="12" font-weight="600" fill="#0a0a0a">Hub VPC</text>
            <text x="350" y="142" text-anchor="middle" font-size="10" fill="#0a0a0a">Transit Gateway</text>

            <!-- Spokes -->
            <rect x="40"  y="20" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="50" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Spoke VPC A</text>

            <rect x="40"  y="190" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="220" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Spoke VPC B</text>

            <rect x="520" y="105" width="140" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="590" y="135" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Spoke VPC C</text>

            <!-- Connections through hub only -->
            <line x1="180" y1="45"  x2="288" y2="115" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrh)"/>
            <line x1="180" y1="215" x2="288" y2="145" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrh)"/>
            <line x1="410" y1="130" x2="518" y2="130" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrh)"/>
            <defs>
                <marker id="arrh" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <!-- Explicit "no direct link" note -->
            <line x1="110" y1="70" x2="110" y2="190" stroke="var(--error, #cc3333)" stroke-width="1.5" stroke-dasharray="4 4"/>
            <text x="120" y="132" font-size="10" fill="var(--text-secondary)">no direct spoke to spoke path</text>
        </svg>
    </div>

    <h3>Full Mesh Peering vs Hub and Spoke</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Factor</th>
                <th>Full Mesh Peering</th>
                <th>Hub and Spoke</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Scalability</td>
                <td>Poor, connections grow rapidly with each new VPC</td>
                <td>Good, new spokes attach to the existing hub</td>
            </tr>
            <tr>
                <td>Centralized Inspection</td>
                <td>Difficult, traffic bypasses any central point</td>
                <td>Built in, all traffic passes through the hub</td>
            </tr>
            <tr>
                <td>Management Overhead</td>
                <td>High, every peering pair must be maintained</td>
                <td>Low, routing is managed centrally</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Seeing Everything in One Place</h2>

    <p>A secure architecture is only useful if you can see what is happening inside it. Centralized logging means sending logs from every account, service, and network component to one dedicated Log Archive account rather than letting each workload account keep its own logs.</p>

    <p>This matters because if a workload account is compromised, an attacker with access to that account could otherwise delete or alter the very logs that would reveal what they did. A separate account with restricted write access keeps that evidence intact.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Why It Matters</h4>
        <p>A dedicated log archive account with restricted write access supports non repudiation, meaning actions cannot later be denied, and gives incident response teams a reliable, untampered record to investigate.</p>
    </div>

    <p>Centralized monitoring builds on this by aggregating activity logs, network flow logs, and application logs from across every account into one place, so a security team can detect unusual activity across the whole environment rather than one account at a time.</p>

    <p>A single security office reviewing camera footage from every building on a campus works the same way. If each building only reviewed its own tapes, a compromised building could simply erase its own evidence before anyone noticed.</p>
</div>
HTML;

$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been asked to design a secure landing zone for a new cloud environment. Your job is to assemble the correct account hierarchy, connect the accounts properly, and attach the guardrail policy so it cascades from the root of the structure.</p>

    <p>Use the Landing Zone Builder to place each account, connect them in the correct hierarchy, and attach the guardrail policy to the Management Account. Validate your structure once you believe it is correct.</p>

    <div class="practical-launch-wrapper">
        <a href="cloud-security-architecture-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Landing Zone Builder</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how cloud security architecture fits together. The shared responsibility model defines what the customer must always own, landing zones use account segmentation to limit blast radius, network topology centralizes inspection and simplifies routing, and centralized logging protects the integrity of your audit trail during an incident.</p>

    <p>These patterns apply across AWS, Azure, and GCP regardless of naming differences, and they matter more as organizations scale into multi account, multi region environments.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>The customer always retains responsibility for data and identity, regardless of service model.</li>
        <li>Landing zones use account segmentation to limit blast radius and centralize policy enforcement.</li>
        <li>Hub and spoke and transit gateway architectures centralize traffic inspection and simplify routing.</li>
        <li>Centralized, restricted access logging protects audit trail integrity during incidents.</li>
    </ul>
</div>
HTML;

// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
