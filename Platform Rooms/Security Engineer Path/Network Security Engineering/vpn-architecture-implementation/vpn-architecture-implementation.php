<?php
// ============================================================
// vpn-architecture-implementation.php
// CYBRIXEN Room Data File
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'vpn-architecture-implementation',
    'title'           => 'VPN Architecture & Implementation',
    'description'     => 'Explore site-to-site and remote access VPN architectures, IPSec versus TLS tunnels, split tunnelling risks, and how VPN design evolves under Zero Trust.',
    'icon'            => 'fas fa-network-wired',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of encryption'],
    'learning_objectives' => [
        'Differentiate site-to-site and remote access VPN architectures',
        'Compare IPSec and TLS based tunnelling approaches',
        'Explain the security risks introduced by split tunnelling',
        'Evaluate always-on VPN against per-application tunnelling',
        'Describe how VPN architecture must adapt within a Zero Trust model',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/vpn-architecture-implementation-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is a VPN Architecture?'],
    ['id' => 'task3', 'title' => 'IPSec vs TLS Tunnels'],
    ['id' => 'task4', 'title' => 'Split Tunnelling Risks'],
    ['id' => 'task5', 'title' => 'Always-On vs Per-App Tunnelling'],
    ['id' => 'task6', 'title' => 'Gateway Hardening & Zero Trust'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'vpn_architecture_implementation_progress',
    'instagram_takeaways'  => [
        '✓ Site-to-site vs remote access VPN architectures',
        '✓ IPSec vs TLS based tunnels and where they operate',
        '✓ Why split tunnelling introduces real security risk',
        '✓ Always-on VPN vs per-app tunnelling trade-offs',
        '✓ How VPN design evolves under Zero Trust',
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
        ['id' => 'q1', 'text' => 'What term describes a VPN that connects two entire networks together, such as branch offices?'],
        ['id' => 'q2', 'text' => 'What term describes a VPN that connects an individual user to a network?'],
        ['id' => 'q3', 'text' => 'What is the network device called that terminates VPN tunnels at the edge of a network?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'At which layer of the OSI model does IPSec primarily operate?'],
        ['id' => 'q5', 'text' => 'What type of VPN more easily traverses firewalls and NAT due to operating at a higher layer?'],
        ['id' => 'q6', 'text' => 'What is the name of the widely used open source software for TLS based VPN connections?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What term describes a VPN configuration where only some traffic is routed through the tunnel?'],
        ['id' => 'q8', 'text' => 'What term describes the configuration where all traffic is routed through the VPN tunnel?'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What term describes a VPN that remains active on a device whenever it has network connectivity?'],
        ['id' => 'q10', 'text' => 'What authentication method uses public and private key pairs instead of passwords for VPN access?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'What security model requires continuous verification of identity and device for every access request, rather than trusting users once inside the network?'],
        ['id' => 'q12', 'text' => 'What principle states that access should be limited to only what is strictly necessary?'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed after hardening the VPN gateway.'],
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
    <p>Every remote worker, branch office, and cloud connection depends on a VPN to move private traffic across a public network safely. Behind that simple padlock icon sits a set of architectural decisions that determine whether a company's data is genuinely protected or quietly exposed. Get those decisions wrong, and the VPN becomes the easiest way into the network rather than the barrier keeping attackers out.</p>

    <p>By the end of this room, you will be able to distinguish site-to-site and remote access architectures, choose between IPSec and TLS based tunnels, recognize the risks of split tunnelling, weigh always-on VPN against per-application tunnelling, and explain how VPN design must change under a Zero Trust model. A hands-on gateway hardening exercise is included to put these ideas into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Differentiate site-to-site and remote access VPN architectures.</li>
        <li>Compare IPSec and TLS based tunnelling approaches.</li>
        <li>Explain the security risks introduced by split tunnelling.</li>
        <li>Evaluate always-on VPN against per-application tunnelling.</li>
        <li>Describe how VPN architecture must adapt within a Zero Trust model.</li>
    </ul>
</div>
HTML;

// TASK 2: What is a VPN Architecture?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Ways to Build a VPN</h2>

    <p>A VPN creates an encrypted path across a network you do not fully trust, typically the public internet. But not every VPN connects the same things. There are two foundational architectures, and confusing them leads to the wrong design decisions later on.</p>

    <p>A <strong>site-to-site VPN</strong> connects two entire networks together, such as a company's head office and a branch location. Once established, it behaves like a permanent private bridge between the two sites, allowing devices on either side to reach each other as if they were on the same local network.</p>

    <p>A <strong>remote access VPN</strong> connects a single user's device to a network, typically so an employee working from home or travelling can reach internal resources. Unlike a site-to-site link, this connection is usually temporary, established only when the user needs access.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Most organizations run both architectures at the same time. Branch offices might connect through a permanent site-to-site tunnel, while individual staff connect through remote access VPN clients on their laptops. Each has its own gateway configuration, risk profile, and hardening requirements.</p>
    </div>

    <h3>Comparing the Two Architectures</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Architecture Type</th>
                <th>Connects</th>
                <th>Typical Use Case</th>
                <th>Example Scenario</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Site-to-site VPN</td>
                <td>Network to network</td>
                <td>Linking branch offices or data centers</td>
                <td>A retail chain connects every store's local network to head office</td>
            </tr>
            <tr>
                <td>Remote access VPN</td>
                <td>User to network</td>
                <td>Individual remote or travelling employees</td>
                <td>An employee working from a hotel connects to internal file servers</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Site-to-site vs remote access topology
         Teaching purpose: learners often conflate the two architectures. This diagram
         shows that one connects two networks while the other connects a single user to a network. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Site-to-site versus remote access VPN topology">
            <!-- Site-to-site group -->
            <text x="180" y="25" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Site-to-Site VPN</text>
            <rect x="20" y="45" width="120" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Office A</text>
            <rect x="220" y="45" width="120" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="280" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Office B</text>
            <line x1="140" y1="80" x2="220" y2="80" stroke="var(--primary)" stroke-width="2"/>
            <text x="180" y="70" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Encrypted tunnel</text>

            <!-- Divider -->
            <line x1="380" y1="20" x2="380" y2="200" stroke="var(--border)" stroke-width="1" stroke-dasharray="4,4"/>

            <!-- Remote access group -->
            <text x="580" y="25" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Remote Access VPN</text>
            <circle cx="440" cy="80" r="30" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="440" y="85" text-anchor="middle" font-size="11" fill="var(--text-primary)">User</text>
            <rect x="620" y="45" width="120" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="680" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Company Network</text>
            <line x1="470" y1="80" x2="620" y2="80" stroke="var(--primary)" stroke-width="2"/>
            <text x="545" y="70" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Encrypted tunnel</text>

            <!-- Bottom labels -->
            <text x="180" y="150" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Permanent, network to network</text>
            <text x="580" y="150" text-anchor="middle" font-size="11" fill="var(--text-secondary)">On demand, user to network</text>
        </svg>
    </div>

    <p>Consider a retail company with ten stores and two hundred remote sales staff. Each store connects to head office through a permanent site-to-site tunnel between gateway devices. Each sales employee instead runs a VPN client on their laptop, establishing a remote access connection whenever they need to reach internal systems.</p>
</div>
HTML;

// TASK 3: IPSec vs TLS Tunnels
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Two Ways to Build the Tunnel</h2>

    <p>Once you know which architecture you need, the next decision is which protocol will actually build the encrypted tunnel. The two dominant families are IPSec and TLS based VPNs, and they operate at different layers of the network stack.</p>

    <p><strong>IPSec</strong> operates at the network layer. It encrypts entire IP packets, which means it protects everything travelling between two endpoints regardless of the application generating the traffic. This makes it powerful, but it typically requires dedicated client software or built in operating system support, and it can struggle to pass through restrictive firewalls or NAT devices.</p>

    <p><strong>TLS based VPNs</strong>, such as OpenVPN, operate at a higher layer, closer to how a normal web browser connection works. Because TLS traffic looks similar to standard HTTPS traffic, these VPNs are far more likely to pass through firewalls and NAT without special configuration, which is one reason they became popular for remote work.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>When remote employees connect from hotels, cafes, or restrictive networks, a TLS based VPN is often more reliable simply because it blends in with normal web traffic. IPSec remains the stronger choice for permanent site-to-site links where both ends are under your control.</p>
    </div>

    <!-- SVG: IPSec vs TLS VPN relative to OSI layers
         Teaching purpose: learners often assume all VPNs work identically. This shows they sit at
         different layers, which is why one traverses firewalls more easily than the other. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="IPSec versus TLS VPN layer comparison">
            <rect x="40" y="20" width="260" height="160" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="170" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">IPSec</text>
            <rect x="70" y="60" width="200" height="30" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--border)"/>
            <text x="170" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Network Layer</text>
            <text x="170" y="115" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Encrypts whole IP packets</text>
            <text x="170" y="135" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Needs client or OS support</text>
            <text x="170" y="155" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Harder firewall traversal</text>

            <rect x="400" y="20" width="260" height="160" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="530" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">TLS Based VPN</text>
            <rect x="430" y="60" width="200" height="30" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--border)"/>
            <text x="530" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Transport / Application Layer</text>
            <text x="530" y="115" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Looks like HTTPS traffic</text>
            <text x="530" y="135" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Lightweight client</text>
            <text x="530" y="155" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Easier firewall traversal</text>
        </svg>
    </div>

    <h3>Feature Comparison</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Feature</th>
                <th>IPSec</th>
                <th>TLS Based VPN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>OSI Layer</td>
                <td>Network layer</td>
                <td>Transport / application layer</td>
            </tr>
            <tr>
                <td>Firewall Traversal</td>
                <td>Often blocked or filtered</td>
                <td>Blends in with HTTPS traffic</td>
            </tr>
            <tr>
                <td>Performance Overhead</td>
                <td>Lower, closer to native routing</td>
                <td>Slightly higher due to TLS handshake</td>
            </tr>
            <tr>
                <td>Client Requirement</td>
                <td>Dedicated client or OS support</td>
                <td>Lightweight client, sometimes browser based</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 4: Split Tunnelling Risks
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>When Not Everything Goes Through the Tunnel</h2>

    <p>A VPN connection does not automatically mean all of a device's traffic is protected. Administrators must decide between full tunnelling, where every packet travels through the VPN, and split tunnelling, where only some traffic is routed through the tunnel while the rest goes directly to the internet.</p>

    <p>Split tunnelling is often chosen for performance reasons. Sending video calls or general web browsing directly to the internet instead of routing it through a corporate gateway reduces latency and gateway load. But this convenience comes with a cost.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The Risk</h4>
        <p>When split tunnelling is enabled, the device sits on two networks at once: the corporate network through the tunnel, and the local network directly. If the local network is compromised, for example through an infected home IoT device, an attacker may be able to pivot through the device and reach the corporate network via the still active tunnel.</p>
    </div>

    <!-- SVG: Split tunnelling path diagram
         Teaching purpose: learners often assume "VPN on" means "all traffic protected." This shows
         the two-path reality where some traffic bypasses the tunnel entirely. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Split tunnelling traffic paths">
            <circle cx="80" cy="100" r="30" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="105" text-anchor="middle" font-size="11" fill="var(--text-primary)">Device</text>

            <line x1="110" y1="85" x2="330" y2="40" stroke="var(--primary)" stroke-width="2"/>
            <rect x="340" y="10" width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="430" y="35" text-anchor="middle" font-size="11" fill="var(--text-primary)">Corporate Network</text>
            <text x="430" y="52" text-anchor="middle" font-size="9" fill="var(--text-secondary)">via VPN tunnel</text>

            <line x1="110" y1="115" x2="330" y2="160" stroke="var(--error, #ff5c5c)" stroke-width="2"/>
            <rect x="340" y="130" width="180" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="430" y="155" text-anchor="middle" font-size="11" fill="var(--text-primary)">Open Internet</text>
            <text x="430" y="172" text-anchor="middle" font-size="9" fill="var(--text-secondary)">unprotected path</text>
        </svg>
    </div>

    <p>Consider a remote employee working on a laptop with split tunnelling enabled. A vulnerable smart device on their home network is compromised. Because the laptop is simultaneously connected to the local network and the corporate network through the active tunnel, the attacker gains a potential foothold that a fully tunnelled connection would have prevented.</p>
</div>
HTML;

// TASK 5: Always-On vs Per-App Tunnelling
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>How Much Access Should the Tunnel Grant?</h2>

    <p>Beyond protocol and tunnelling scope, engineers must also decide how broadly a VPN grants access once it is active. Two common approaches are always-on VPN and per-application tunnelling.</p>

    <p><strong>Always-on VPN</strong> keeps the tunnel active on a device whenever it has network connectivity, granting broad access to the corporate network for as long as the device is connected. <strong>Per-application tunnelling</strong> instead only routes traffic from specific approved applications through the tunnel, leaving everything else outside it. This model is common in mobile device management and modern Zero Trust deployments.</p>

    <h3>Comparing the Approaches</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Approach</th>
                <th>Scope</th>
                <th>Best Fit</th>
                <th>Trade-off</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Always-on VPN</td>
                <td>Entire device, whenever connected</td>
                <td>Managed corporate laptops</td>
                <td>Broad access increases impact if the device is compromised</td>
            </tr>
            <tr>
                <td>Per-app tunnelling</td>
                <td>Only specified applications</td>
                <td>Mobile devices and Zero Trust environments</td>
                <td>More configuration effort but far smaller attack surface</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Certificate-Based Authentication</h4>
        <p>Both approaches benefit from certificate-based authentication, where a device or user proves identity using a public and private key pair rather than a password or shared secret. Because there is no password to phish or guess, certificate-based authentication is significantly more resistant to credential theft.</p>
    </div>
</div>
HTML;

// TASK 6: Gateway Hardening & Zero Trust
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Hardening the Gateway and Rethinking Trust</h2>

    <p>A VPN gateway is only as secure as its configuration. Hardening typically means disabling legacy protocols, enforcing strong cipher suites, restricting the management interface so it is not reachable from the open internet, and keeping the gateway patched against known vulnerabilities.</p>

    <p>Traditional VPN architecture assumes that once a user is connected, they are broadly trusted on the internal network. Zero Trust challenges that assumption directly. Instead of trusting a device because it is inside the perimeter, Zero Trust requires continuous verification of identity and device posture for every request, regardless of network location.</p>

    <!-- SVG: Legacy VPN trust vs Zero Trust model
         Teaching purpose: learners often assume VPN alone satisfies Zero Trust. This shows the shift
         from one broad trust zone to per-resource verification with no implicit trust. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Legacy VPN trust versus Zero Trust model">
            <text x="170" y="25" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Legacy VPN Trust</text>
            <rect x="40" y="40" width="260" height="140" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="170" y="65" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Once past the gateway,</text>
            <text x="170" y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">broad internal access is granted</text>
            <rect x="70" y="100" width="60" height="40" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--border)"/>
            <rect x="150" y="100" width="60" height="40" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--border)"/>
            <rect x="230" y="100" width="40" height="40" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--border)"/>

            <text x="530" y="25" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Zero Trust Model</text>
            <rect x="400" y="40" width="260" height="140" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="530" y="65" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Every resource verifies identity</text>
            <text x="530" y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">and device posture independently</text>
            <rect x="430" y="100" width="60" height="40" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--primary)"/>
            <text x="460" y="123" text-anchor="middle" font-size="8" fill="var(--text-secondary)">verify</text>
            <rect x="510" y="100" width="60" height="40" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--primary)"/>
            <text x="540" y="123" text-anchor="middle" font-size="8" fill="var(--text-secondary)">verify</text>
            <rect x="590" y="100" width="40" height="40" rx="4" fill="var(--bg-secondary, #12182b)" stroke="var(--primary)"/>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Zero Trust does not eliminate VPN. Its role simply changes from being the perimeter itself to being one of several verified access paths, often layered with per-application tunnelling and certificate-based authentication.</p>
    </div>

    <p>Many organizations migrate gradually, layering certificate-based authentication and per-application tunnelling on top of their existing VPN infrastructure rather than replacing it outright, moving step by step toward continuous verification.</p>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You have been handed access to a live VPN gateway configuration panel for a mid-sized company. A recent security review flagged the gateway as misconfigured, and it is your job to correct every setting before the gateway can be considered hardened.</p>

    <p>Review each configuration card, identify what is wrong, and set it to the secure value. The gateway will confirm once every setting has been corrected.</p>

    <div class="practical-launch-wrapper">
        <a href="vpn-architecture-implementation-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch VPN Gateway Auditor</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have now covered the core architectural decisions behind any VPN deployment: choosing between site-to-site and remote access models, selecting IPSec or TLS based tunnels, deciding whether to allow split tunnelling, weighing always-on access against per-application tunnelling, and hardening the gateway itself. You also saw how Zero Trust reshapes the role VPN plays rather than replacing it outright.</p>

    <p>These decisions directly affect how much damage a single compromised device or credential can cause, which makes VPN architecture one of the highest leverage areas in network security design.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Site-to-site VPNs connect networks, remote access VPNs connect individual users.</li>
        <li>IPSec operates at the network layer, TLS based VPNs operate higher and traverse firewalls more easily.</li>
        <li>Split tunnelling improves performance but can expose the corporate network through an unprotected local path.</li>
        <li>Always-on VPN grants broad access, per-application tunnelling narrows the attack surface.</li>
        <li>Certificate-based authentication is more phishing resistant than passwords or shared keys.</li>
        <li>Zero Trust does not remove VPN, it changes VPN from being the perimeter to being one verified access path among several.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
