<?php
// network-segmentation-dmz.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'network-segmentation-dmz',
    'title'           => 'Network Segmentation & DMZ Design',
    'description'     => 'Learn how to design network segments, security zones, and DMZ architectures that contain lateral movement and limit blast radius.',
    'icon'            => 'fas fa-diagram-project',
    'banner'          => '../../assets/banner-network-segmentation.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic firewall and IP addressing knowledge'],
    'learning_objectives' => [
        'Explain why network segmentation limits blast radius during a breach',
        'Describe the purpose of a DMZ and what belongs in it',
        'Compare the Purdue Model and the three tier enterprise model',
        'Identify VLAN based segmentation risks',
        'Recognize common segmentation anti patterns',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/network-segmentation-dmz-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What Is Network Segmentation?'],
    ['id' => 'task3', 'title' => 'DMZ Architecture'],
    ['id' => 'task4', 'title' => 'Tiered Network Models'],
    ['id' => 'task5', 'title' => 'VLAN Security'],
    ['id' => 'task6', 'title' => 'Segmentation Anti-Patterns'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'network_segmentation_dmz_progress',
    'instagram_takeaways'  => [
        '✓ Segmentation limits blast radius during a breach',
        '✓ The DMZ isolates public facing assets from the internal network',
        '✓ The Purdue Model and three tier model enforce tiered trust boundaries',
        '✓ VLANs need ACLs to actually enforce security boundaries',
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
        ['id' => 'q1', 'text' => 'What term describes the maximum extent of a network an attacker can reach after compromising one host?'],
        ['id' => 'q2', 'text' => 'What security principle limits each zone to only the access it needs?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What three letter acronym describes the buffer zone between the internet and the internal network?'],
        ['id' => 'q4', 'text' => 'What type of server commonly sits in a DMZ to handle public facing traffic?'],
        ['id' => 'q5', 'text' => 'What network zone should a compromised DMZ host never be allowed to directly reach?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What industrial control framework defines numbered levels from field devices up to enterprise IT?'],
        ['id' => 'q7', 'text' => 'What is the top layer of the three tier network model called?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What attack technique lets traffic escape its assigned VLAN using double tagging?'],
        ['id' => 'q9', 'text' => 'What is the term for VLANs that isolate individual hosts within the same broadcast domain?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What overly permissive firewall rule type effectively undoes segmentation?'],
        ['id' => 'q11', 'text' => 'What dedicated system should be used for admin access into a restricted zone instead of direct access?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered by completing the Zone Architect exercise.'],
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
    <p>Most network breaches do not stay contained to the system an attacker first compromises. On a flat network, one exposed web server or one careless click on a phishing email can give an attacker a direct path to payment systems, file servers, and industrial control equipment. Segmentation is the practice of dividing a network into zones so that a compromise in one area cannot freely spread into another.</p>

    <p>By the end of this room you will be able to design security zones, place assets correctly around a DMZ, and reason about which inter-zone traffic should be allowed or denied. A hands-on design exercise is included so you can apply these ideas directly rather than just reading about them.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why network segmentation limits blast radius during a breach.</li>
        <li>Describe the purpose of a DMZ and what belongs in it.</li>
        <li>Compare the Purdue Model and the three tier enterprise model.</li>
        <li>Identify VLAN based segmentation risks.</li>
        <li>Recognize common segmentation anti patterns.</li>
    </ul>
</div>
HTML;

// TASK 2: What Is Network Segmentation?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Dividing the Network Into Zones</h2>

    <p>Network segmentation splits a network into smaller zones, each with its own trust level and its own boundary controls. Instead of one large space where every device can reach every other device, each zone only allows the traffic it genuinely needs.</p>

    <p>Think of an office building. A building with one unlocked front door and no interior locks lets anyone who gets in wander anywhere, the server room, the finance office, the executive suite. A building with keyed access per floor limits an intruder to whichever floor they entered, even after the front door is breached. Network zones work the same way.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Blast Radius</h4>
        <p>Blast radius describes how far an attacker can reach after compromising a single host. Segmentation exists specifically to shrink that radius, not to improve network performance.</p>
    </div>

    <!-- SVG: Flat vs segmented network
         Teaching purpose: show the learner that segmentation limits how far an attacker can move,
         which they would otherwise misunderstand as segmentation only being about traffic separation. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Flat network versus segmented network">
            <!-- Flat network panel -->
            <rect x="10" y="10" width="350" height="240" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="35" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Flat Network</text>

            <circle cx="185" cy="130" r="16" fill="var(--error)"/>
            <text x="185" y="135" text-anchor="middle" font-size="10" fill="#0b0f1a">ATK</text>

            <circle cx="90" cy="80" r="14" fill="var(--text-secondary)"/>
            <circle cx="280" cy="80" r="14" fill="var(--text-secondary)"/>
            <circle cx="90" cy="190" r="14" fill="var(--text-secondary)"/>
            <circle cx="280" cy="190" r="14" fill="var(--text-secondary)"/>

            <line x1="185" y1="130" x2="90" y2="80" stroke="var(--error)" stroke-width="1.5"/>
            <line x1="185" y1="130" x2="280" y2="80" stroke="var(--error)" stroke-width="1.5"/>
            <line x1="185" y1="130" x2="90" y2="190" stroke="var(--error)" stroke-width="1.5"/>
            <line x1="185" y1="130" x2="280" y2="190" stroke="var(--error)" stroke-width="1.5"/>

            <text x="185" y="230" text-anchor="middle" font-size="11" fill="var(--text-secondary)">One host can reach every other host</text>

            <!-- Segmented network panel -->
            <rect x="400" y="10" width="350" height="240" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="575" y="35" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Segmented Network</text>

            <rect x="420" y="55" width="140" height="80" rx="8" fill="none" stroke="var(--border)" stroke-width="1"/>
            <text x="490" y="70" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Zone A</text>
            <circle cx="490" cy="105" r="16" fill="var(--error)"/>
            <text x="490" y="110" text-anchor="middle" font-size="10" fill="#0b0f1a">ATK</text>
            <circle cx="450" cy="120" r="12" fill="var(--text-secondary)"/>

            <rect x="590" y="55" width="140" height="80" rx="8" fill="none" stroke="var(--border)" stroke-width="1"/>
            <text x="660" y="70" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Zone B</text>
            <circle cx="660" cy="105" r="12" fill="var(--text-secondary)"/>
            <circle cx="700" cy="120" r="12" fill="var(--text-secondary)"/>

            <line x1="560" y1="95" x2="590" y2="95" stroke="var(--error)" stroke-width="2"/>
            <text x="575" y="88" text-anchor="middle" font-size="14" fill="var(--error)">x</text>

            <rect x="420" y="150" width="310" height="80" rx="8" fill="none" stroke="var(--border)" stroke-width="1"/>
            <text x="575" y="165" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Zone C (unreachable from Zone A)</text>
            <circle cx="500" cy="200" r="12" fill="var(--text-secondary)"/>
            <circle cx="575" cy="200" r="12" fill="var(--text-secondary)"/>
            <circle cx="650" cy="200" r="12" fill="var(--text-secondary)"/>

            <text x="575" y="248" text-anchor="middle" font-size="11" fill="var(--text-secondary)">The attacker is contained to Zone A</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: DMZ Architecture
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>The Buffer Zone Between Public and Private</h2>

    <p>A DMZ, short for demilitarized zone, is a network segment that sits between the internet and the internal network. It holds the systems that must be reachable from outside, while keeping those systems isolated from everything the business truly depends on.</p>

    <p>The DMZ is not a bridge that lets internet traffic pass through to the internal network. It is a dead end for public traffic. If a DMZ host is compromised, the goal of the design is to make sure that compromise cannot travel any further inward.</p>

    <h3>Common DMZ Assets</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Asset</th>
                <th>Why It Lives in the DMZ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Public web server</td>
                <td>Must accept connections from anonymous internet users.</td>
            </tr>
            <tr>
                <td>Public DNS server</td>
                <td>Resolves domain names for external visitors without exposing internal DNS records.</td>
            </tr>
            <tr>
                <td>Mail relay</td>
                <td>Handles inbound and outbound mail without giving external senders a path to internal mailboxes directly.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Internet, DMZ, Internal traffic paths
         Teaching purpose: show the learner that DMZ traffic is limited and one directional,
         which they would otherwise misunderstand as the DMZ being a full trust bridge. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Traffic paths between internet, DMZ, and internal zone">
            <rect x="10" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="75" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Internet</text>

            <rect x="290" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="75" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">DMZ</text>

            <rect x="570" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="660" y="75" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Internal</text>

            <line x1="190" y1="60" x2="285" y2="60" stroke="var(--success)" stroke-width="2"/>
            <text x="237" y="50" text-anchor="middle" font-size="10" fill="var(--success)">Allowed (443)</text>

            <line x1="475" y1="60" x2="565" y2="60" stroke="var(--error)" stroke-width="2"/>
            <text x="520" y="50" text-anchor="middle" font-size="10" fill="var(--error)">Denied</text>

            <line x1="190" y1="100" x2="565" y2="100" stroke="var(--error)" stroke-width="2" stroke-dasharray="6,4"/>
            <text x="380" y="120" text-anchor="middle" font-size="10" fill="var(--error)">Denied direct path (Internet to Internal)</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Tiered Network Models
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Enterprise and Industrial Tiering</h2>

    <p>Larger networks are rarely just two or three zones. Enterprises and industrial environments use formal tiered models so that trust boundaries are consistent and predictable, rather than improvised zone by zone.</p>

    <p>Industrial and operational technology environments follow the Purdue Model, which numbers levels from field devices up to enterprise IT. Enterprise IT networks commonly use a three tier model of core, distribution, and access layers.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Model</th>
                <th>Layer / Level</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3">Purdue Model</td>
                <td>Level 0-1</td>
                <td>Physical process and field devices such as sensors and PLCs.</td>
            </tr>
            <tr>
                <td>Level 2-3</td>
                <td>Supervisory control and site operations.</td>
            </tr>
            <tr>
                <td>Level 4-5</td>
                <td>Enterprise IT and business systems.</td>
            </tr>
            <tr>
                <td rowspan="3">Three Tier Model</td>
                <td>Access layer</td>
                <td>Where end user devices connect to the network.</td>
            </tr>
            <tr>
                <td>Distribution layer</td>
                <td>Applies policy and routes traffic between access segments.</td>
            </tr>
            <tr>
                <td>Core layer</td>
                <td>High speed backbone connecting distribution layers together.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Mixing IT and OT Without a DMZ</h4>
        <p>Connecting enterprise IT directly to Purdue Level 2-3 without an industrial DMZ in between gives an attacker who breaches office systems a direct path into physical process control.</p>
    </div>
</div>
HTML;

// TASK 5: VLAN Security
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>VLANs Are Not a Security Boundary by Themselves</h2>

    <p>A VLAN separates broadcast traffic into logical groups on the same physical switching infrastructure. This is useful for organizing traffic, but a VLAN by itself does not enforce security. Enforcement comes from access control lists applied at the boundary between VLANs.</p>

    <p>One well known weakness is VLAN hopping, where an attacker crafts a frame with two VLAN tags. A misconfigured trunk port strips the outer tag and forwards the frame as if it belonged to the second, inner VLAN, letting traffic cross a boundary it should never have reached.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Not a Security Boundary</h4>
        <p>Treat VLANs as traffic organization, not access control. Pair them with firewall rules or private VLANs whenever real isolation is required.</p>
    </div>

    <!-- SVG: VLAN hopping via double tagging
         Teaching purpose: show the learner how a misconfigured trunk lets traffic cross VLANs,
         which they would otherwise misunderstand as VLANs being an unbreakable boundary. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="VLAN hopping across a trunk link">
            <rect x="20" y="70" width="150" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="110" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Switch A</text>

            <rect x="590" y="70" width="150" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="665" y="110" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Switch B</text>

            <line x1="170" y1="105" x2="590" y2="105" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <text x="380" y="95" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Trunk link</text>

            <circle cx="60" cy="180" r="14" fill="var(--error)"/>
            <text x="60" y="185" text-anchor="middle" font-size="10" fill="#0b0f1a">ATK</text>
            <text x="60" y="205" text-anchor="middle" font-size="10" fill="var(--text-secondary)">VLAN 10 access port</text>

            <circle cx="700" cy="180" r="14" fill="var(--text-secondary)"/>
            <text x="700" y="205" text-anchor="middle" font-size="10" fill="var(--text-secondary)">VLAN 20 access port</text>

            <rect x="200" y="145" width="40" height="20" fill="var(--warning)"/>
            <rect x="245" y="145" width="40" height="20" fill="var(--error)"/>
            <text x="200" y="140" font-size="9" fill="var(--text-secondary)">Outer tag VLAN 10</text>
            <text x="245" y="180" font-size="9" fill="var(--text-secondary)">Inner tag VLAN 20</text>

            <line x1="60" y1="166" x2="60" y2="140" stroke="var(--error)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <line x1="60" y1="140" x2="700" y2="140" stroke="var(--error)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <line x1="700" y1="140" x2="700" y2="166" stroke="var(--error)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <text x="380" y="205" text-anchor="middle" font-size="10" fill="var(--error)">Double tagged frame lands on VLAN 20</text>
        </svg>
    </div>
</div>
HTML;

// TASK 6: Segmentation Anti-Patterns
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>False Confidence in a Segmented Design</h2>

    <p>Segmentation only works if the boundaries are actually enforced. Many networks look segmented on a diagram while giving an attacker an easy path across zones in practice. Recognizing these anti patterns matters as much as knowing the correct design.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Anti-Pattern</th>
                <th>Why It Fails</th>
                <th>Correct Approach</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>VLANs with no ACLs</td>
                <td>Traffic is logically separated but nothing actually blocks it at the boundary.</td>
                <td>Apply firewall rules or access control lists between every VLAN boundary.</td>
            </tr>
            <tr>
                <td>Any-any firewall rules</td>
                <td>A rule that allows all ports and protocols between zones removes the boundary entirely.</td>
                <td>Allow only the specific ports and protocols each zone genuinely requires.</td>
            </tr>
            <tr>
                <td>Shared services zone as a bridge</td>
                <td>A shared print or file service reachable from every zone becomes an unintentional path between them.</td>
                <td>Place shared services behind their own access controls, scoped per requesting zone.</td>
            </tr>
            <tr>
                <td>Missing jump host for admin access</td>
                <td>Direct administrative access into a restricted zone gives any compromised admin workstation a path in.</td>
                <td>Route all administrative access through a hardened, monitored jump host.</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have inherited a flat, unsegmented network for a mid-size company. A public web server, DNS server, mail relay, employee workstations, an internal file server, a payment terminal, and an industrial control system are all sitting on the same network with no boundaries between them.</p>

    <p>Redesign the network using proper zones and set the inter-zone traffic policy so that a compromise in one area cannot spread into the rest of the business.</p>

    <div class="practical-launch-wrapper">
        <a href="network-segmentation-dmz-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Zone Architect</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Segmentation, DMZ design, tiered models, and VLAN boundaries all serve the same underlying goal, containing a breach before it becomes a company-wide incident. None of these controls work in isolation. A DMZ without correct traffic policy, a tiered model without enforcement, or a VLAN without access control lists all quietly become the flat network you started with.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Segmentation limits blast radius, it does not prevent every breach.</li>
        <li>The DMZ isolates public facing assets from the internal network.</li>
        <li>The Purdue Model and three tier model both enforce tiered trust boundaries.</li>
        <li>VLANs organize traffic but need access control lists to actually enforce security.</li>
        <li>Anti patterns like any-any rules quietly undo segmentation's value.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
