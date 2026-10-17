<?php
// network-access-control.php
// CYBRIXEN Room Data File

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'network-access-control',
    'title'           => 'Network Access Control (NAC)',
    'description'     => 'Learn how NAC systems authenticate and authorize devices before granting network access, including 802.1X, RADIUS, posture assessment, and quarantine VLAN design.',
    'icon'            => 'fas fa-network-wired',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of AAA'],
    'learning_objectives' => [
        'Explain what Network Access Control does and why it is needed',
        'Describe the three roles in 802.1X architecture',
        'Explain how RADIUS is used to centralize authentication decisions',
        'Describe posture assessment and its role in continuous trust evaluation',
        'Explain quarantine VLAN design and how MAB supports legacy and IoT devices',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/network-access-control-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Network Access Control?'],
    ['id' => 'task3', 'title' => '802.1X Architecture'],
    ['id' => 'task4', 'title' => 'RADIUS and Authentication Decisions'],
    ['id' => 'task5', 'title' => 'Posture Assessment'],
    ['id' => 'task6', 'title' => 'Quarantine VLANs and Deployment Challenges'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'network_access_control_progress',
    'instagram_takeaways'  => [
        '✓ NAC evaluates devices before granting full network access',
        '✓ 802.1X: supplicant, authenticator, and authentication server',
        '✓ RADIUS centralizes authentication decisions',
        '✓ Posture assessment and quarantine VLANs handle risk',
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
        ['id' => 'q1', 'text' => 'What does NAC stand for?'],
        ['id' => 'q2', 'text' => 'What must a device successfully do before NAC grants it full network access?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the client device called in 802.1X terminology?'],
        ['id' => 'q4', 'text' => 'What is the switch or access point called in 802.1X terminology?'],
        ['id' => 'q5', 'text' => 'What protocol carries authentication messages between the authenticator and the authentication server?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What RADIUS message indicates a successful authentication?'],
        ['id' => 'q7', 'text' => 'What RADIUS message indicates a failed authentication?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What is the process of checking a device\'s health and compliance before granting access called?'],
        ['id' => 'q9', 'text' => 'What type of posture assessment relies on software installed on the endpoint itself?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What VLAN is used to isolate non-compliant devices for remediation?'],
        ['id' => 'q11', 'text' => 'What fallback authentication method uses a device\'s MAC address instead of a supplicant?'],
        ['id' => 'q12', 'text' => 'What term describes employees connecting personal devices to the corporate network?'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the RADIUS Authentication Console.'],
    ],
    'task8' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every device that touches a corporate network, a laptop, a badge reader, a security camera, a personal phone brought in by an employee, shows up on the same switch ports and the same Wi-Fi. A network cannot simply trust that whatever connects to it belongs there. Network Access Control exists to make that trust decision explicit instead of assumed.</p>

    <p>By the end of this room you will be able to explain how 802.1X, RADIUS, posture assessment, and quarantine VLANs work together to authenticate and authorize devices before they reach the rest of the network. A hands-on RADIUS console is included so you can practice making the same decisions a real access control system makes.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what Network Access Control does and why it is needed.</li>
        <li>Describe the three roles in 802.1X architecture.</li>
        <li>Explain how RADIUS is used to centralize authentication decisions.</li>
        <li>Describe posture assessment and its role in continuous trust evaluation.</li>
        <li>Explain quarantine VLAN design and how MAB supports legacy and IoT devices.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Network Access Control?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>A Checkpoint, Not an Open Door</h2>

    <p>Think of an office lobby. Anyone can walk through the front door, but a receptionist checks identification and issues a badge before letting a visitor past the lobby. An open network without NAC behaves like a building with no lobby at all: whatever connects to a switch port or joins the Wi-Fi is treated as trusted immediately.</p>

    <p>Network Access Control adds that lobby back. It sits between the moment a device physically connects and the moment it is allowed to reach production resources. A device must first prove who it is and, in more mature deployments, prove it meets a minimum health standard before it is granted access.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Open Network</th>
                <th>NAC Controlled Network</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Any device connecting to a port or SSID gets network access immediately.</td>
                <td>A device must authenticate before it reaches production resources.</td>
            </tr>
            <tr>
                <td>No verification of identity or device health.</td>
                <td>Identity is verified, and often device posture is checked too.</td>
            </tr>
            <tr>
                <td>An attacker with physical port access is instantly on the network.</td>
                <td>An unauthenticated device is placed in a restricted or quarantine segment.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: NAC checkpoint diagram
         Teaching purpose: show the learner that NAC sits between physical connection
         and network access, which they would otherwise misunderstand as access being
         granted the instant a cable is plugged in or Wi-Fi is joined. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="NAC checkpoint flow">
            <rect x="10" y="55" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="90" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Device Connects</text>

            <line x1="160" y1="85" x2="290" y2="85" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrow1)"/>

            <rect x="295" y="35" width="170" height="100" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="380" y="80" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">NAC Checkpoint</text>
            <text x="380" y="100" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Verify identity</text>
            <text x="380" y="115" text-anchor="middle" font-size="11" fill="var(--text-secondary)">and health</text>

            <line x1="465" y1="65" x2="600" y2="30" stroke="var(--success)" stroke-width="1.5" marker-end="url(#arrow2)"/>
            <line x1="465" y1="105" x2="600" y2="140" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrow3)"/>

            <rect x="600" y="5" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="675" y="35" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Production VLAN</text>

            <rect x="600" y="115" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="675" y="145" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Quarantine VLAN</text>

            <defs>
                <marker id="arrow1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="arrow2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--success)"/></marker>
                <marker id="arrow3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: 802.1X Architecture
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Three Roles, One Decision</h2>

    <p>802.1X is the standard that structures how a device proves its identity before a switch or wireless access point lets it onto the network. It defines three distinct roles, and understanding the boundary between them is the key to understanding NAC.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Role</th>
                <th>Real World Analogy</th>
                <th>Function</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Supplicant</strong></td>
                <td>The visitor at the door</td>
                <td>The client device requesting network access.</td>
            </tr>
            <tr>
                <td><strong>Authenticator</strong></td>
                <td>The receptionist</td>
                <td>The switch or access point that relays credentials and enforces the outcome.</td>
            </tr>
            <tr>
                <td><strong>Authentication Server</strong></td>
                <td>The security office checking the visitor's file</td>
                <td>The RADIUS server that makes the actual accept or reject decision.</td>
            </tr>
        </tbody>
    </table>

    <p>The supplicant sends its credentials over EAP encapsulated in EAPoL to the authenticator. The authenticator does not evaluate them. It forwards them to the authentication server over RADIUS and simply enforces whatever decision comes back.</p>

    <!-- SVG: 802.1X message flow
         Teaching purpose: show the learner that the switch never makes the authentication
         decision itself, which they would otherwise misunderstand as the switch being
         the thing that verifies identity. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="802.1X message flow">
            <rect x="10" y="45" width="150" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="78" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Supplicant</text>

            <rect x="300" y="45" width="150" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="375" y="78" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Authenticator</text>

            <rect x="590" y="45" width="160" height="55" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="670" y="78" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Auth Server</text>

            <line x1="160" y1="65" x2="295" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#a1)"/>
            <text x="227" y="55" text-anchor="middle" font-size="10" fill="var(--text-secondary)">EAPoL</text>

            <line x1="450" y1="65" x2="585" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#a2)"/>
            <text x="517" y="55" text-anchor="middle" font-size="10" fill="var(--text-secondary)">RADIUS</text>

            <line x1="585" y1="85" x2="450" y2="85" stroke="var(--success)" stroke-width="1.5" marker-end="url(#a3)"/>
            <text x="517" y="103" text-anchor="middle" font-size="10" fill="var(--success)">Accept / Reject</text>

            <defs>
                <marker id="a1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="a2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="a3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--success)"/></marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>The switch relays and enforces. It never decides. That decision belongs entirely to the authentication server.</p>
    </div>
</div>
HTML;

// TASK 4: RADIUS and Authentication Decisions
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Centralizing the Decision</h2>

    <p>RADIUS is the protocol that carries authentication, authorization, and accounting data between the authenticator and the authentication server. Instead of configuring credentials on every switch individually, an organization configures one RADIUS server and points every switch and access point at it.</p>

    <p>When a device attempts to authenticate, the authenticator sends an Access-Request to the RADIUS server. The server evaluates the credentials against its identity store and responds with one of a small set of standard messages.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Message</th>
                <th>Sent By</th>
                <th>Meaning</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Access-Request</td>
                <td>Authenticator</td>
                <td>Forwards the device's credentials for evaluation.</td>
            </tr>
            <tr>
                <td>Access-Accept</td>
                <td>RADIUS Server</td>
                <td>Authentication succeeded. Access is granted.</td>
            </tr>
            <tr>
                <td>Access-Reject</td>
                <td>RADIUS Server</td>
                <td>Authentication failed. Access is denied.</td>
            </tr>
            <tr>
                <td>Access-Challenge</td>
                <td>RADIUS Server</td>
                <td>Additional information is required before a decision can be made.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Centralize?</h4>
        <p>A large network may have hundreds of switches. Configuring identity checks on each one individually does not scale and creates inconsistent policy. A single RADIUS server lets every switch enforce the same rules from one source of truth.</p>
    </div>
</div>
HTML;

// TASK 5: Posture Assessment
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Proving You Are Healthy, Not Just Who You Are</h2>

    <p>Authentication answers one question: is this the device or user it claims to be. It does not answer a second, equally important question: is this device safe to trust on the network right now. That second question is what posture assessment evaluates.</p>

    <p>A posture check might confirm that antivirus software is running and up to date, that the operating system has recent security patches installed, and that a host based firewall is enabled. Think of it like a health screening before entering a hospital ward. Showing your ID gets you through the front door, but a fever check decides whether you are actually let onto the ward.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Authentication Is Not Enough</h4>
        <p>A device can authenticate successfully with perfectly valid credentials and still be a risk if it is unpatched or has security controls disabled. Posture assessment closes that gap.</p>
    </div>

    <p>Posture assessment can be agent based, where software installed on the endpoint reports its status directly, or agentless, where the network infrastructure inspects the device remotely without any installed software. Many deployments also reassess posture continuously rather than only at the moment of connection, since a device's health can change after it joins the network.</p>
</div>
HTML;

// TASK 6: Quarantine VLANs and Deployment Challenges
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>What Happens to the Devices That Do Not Fit</h2>

    <p>Not every device can run an 802.1X supplicant. Printers, IP cameras, and many IoT sensors have no software stack capable of it, and personal devices under a BYOD policy may not be configured for it either. A well designed NAC deployment does not simply block these devices. It routes them somewhere appropriate.</p>

    <p>MAC Authentication Bypass, or MAB, lets a device with no supplicant authenticate using its MAC address against a whitelist instead. It is weaker than certificate based authentication since MAC addresses can be spoofed, but it is the practical way to safely admit legacy hardware. Devices that fail authentication entirely, or that are not yet compliant with posture policy, are placed into a quarantine VLAN, a restricted network segment with just enough access to remediate the issue.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>Requires Supplicant</th>
                <th>Typical Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>802.1X</td>
                <td>Yes</td>
                <td>Corporate laptops and managed devices</td>
            </tr>
            <tr>
                <td>MAB</td>
                <td>No</td>
                <td>Printers, IP cameras, and other legacy or IoT hardware</td>
            </tr>
            <tr>
                <td>Guest Web Auth</td>
                <td>No</td>
                <td>Visitors and unmanaged personal devices</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: three way VLAN branching
         Teaching purpose: show the learner that non-compliant and supplicant-less devices
         are not simply blocked but routed to a separate quarantine VLAN, which they would
         otherwise misunderstand as NAC being a strict allow or deny gate with no middle
         ground. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 180" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="VLAN branching decision">
            <rect x="10" y="65" width="160" height="55" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="90" y="98" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">NAC Decision</text>

            <line x1="170" y1="75" x2="580" y2="25" stroke="var(--success)" stroke-width="1.5" marker-end="url(#b1)"/>
            <line x1="170" y1="92" x2="580" y2="92" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#b2)"/>
            <line x1="170" y1="110" x2="580" y2="160" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#b3)"/>

            <rect x="585" y="0" width="165" height="50" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="667" y="30" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Production VLAN</text>

            <rect x="585" y="67" width="165" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="667" y="97" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Quarantine VLAN</text>

            <rect x="585" y="135" width="165" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="667" y="165" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Guest VLAN</text>

            <defs>
                <marker id="b1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--success)"/></marker>
                <marker id="b2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="b3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Where Real Deployments Get Hard</h4>
        <p>Legacy equipment, IoT devices, and BYOD policy are where most NAC projects spend the majority of their engineering effort. Getting a managed corporate laptop through 802.1X is straightforward. Safely handling everything that cannot run a supplicant is the real work.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You are monitoring a live RADIUS authentication console for a mid size office network. Several devices are attempting to join at once, corporate laptops, IoT hardware, and personal devices among them. Your job is to review each authentication attempt and make the correct decision for it.</p>

    <p>Use what you have learned about EAP methods, certificate validity, and MAC Authentication Bypass to classify all six devices correctly.</p>

    <div class="practical-launch-wrapper">
        <a href="network-access-control-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch RADIUS Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Network Access Control brings authentication, 802.1X architecture, RADIUS, posture assessment, and VLAN design together into a single pipeline that decides who and what is allowed onto a network. None of these pieces work well alone. Identity without health checks is incomplete, and health checks mean nothing without a reliable way to verify identity first.</p>

    <p>Real networks are rarely made up of ideal, fully managed devices. Engineers who design NAC deployments have to account for legacy hardware, IoT sensors, and personal devices from day one, not as an afterthought.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>NAC evaluates devices before granting full network access, not after.</li>
        <li>802.1X separates the roles of supplicant, authenticator, and authentication server.</li>
        <li>RADIUS centralizes authentication decisions using Access-Request, Accept, Reject, and Challenge messages.</li>
        <li>Posture assessment checks device health and compliance, not just identity.</li>
        <li>Quarantine VLANs and MAB allow legacy, IoT, and BYOD devices to be handled safely instead of blocked outright.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
