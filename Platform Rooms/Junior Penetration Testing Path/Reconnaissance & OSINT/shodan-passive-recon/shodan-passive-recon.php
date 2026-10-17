<?php
// ============================================================
// shodan-passive-recon.php — ROOM DATA FILE
// Topic: Shodan and Passive Infrastructure Discovery
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'shodan-passive-recon',
    'title'           => 'Shodan and Passive Infrastructure Discovery',
    'description'     => 'Learn how Shodan indexes internet connected devices and how attackers find exposed services without ever touching the target network.',
    'icon'            => 'fas fa-satellite-dish',
    'banner'          => '../../assets/banner-recon.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of client server architecture'],
    'learning_objectives' => [
        'Explain the difference between active and passive reconnaissance',
        'Use Shodan search filters to locate specific exposed services',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/shodan-passive-recon-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Shodan?'],
    ['id' => 'task3', 'title' => 'Shodan Search Filters'],
    ['id' => 'task4', 'title' => 'Reading Banners'],
    ['id' => 'task5', 'title' => 'From Exposure to CVE'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'shodan_passive_recon_progress',
    'instagram_takeaways'  => [
        '✓ Shodan indexes pre scanned internet connected devices',
        '✓ Passive recon never touches the target directly',
        '✓ Filters like product, port, country and org narrow results fast',
        '✓ Banners reveal service, version, and misconfiguration clues',
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
        ['id' => 'q1', 'text' => 'What is the term for reconnaissance that does not send traffic directly to the target?'],
        ['id' => 'q2', 'text' => 'What is the term for reconnaissance that sends traffic directly to a target?'],
        ['id' => 'q3', 'text' => 'What term describes the raw response data that Shodan collects from each device?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'Which Shodan filter narrows results to a specific software product?'],
        ['id' => 'q5', 'text' => 'Which Shodan filter narrows results to a specific network port?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What is the term for identifying a service and its version from its banner?'],
        ['id' => 'q7', 'text' => 'What kind of system might present a fake banner to mislead an attacker?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What does CVE stand for?'],
        ['id' => 'q9', 'text' => 'Which Shodan filter searches directly for known vulnerabilities?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Enter the flag you discovered in the Shodan Recon Console.'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every day, automated scanners crawl the entire public internet, connecting to open ports and recording whatever response comes back. Shodan turns that raw data into a searchable index, letting anyone look up exposed cameras, databases, industrial controllers, and web servers without sending a single packet to them directly. It is often called a search engine for devices rather than a search engine for web pages.</p>

    <p>By the end of this room you will be able to explain how passive reconnaissance differs from active scanning, build precise Shodan queries using real filters, read a raw service banner to identify software and version, and connect an exposed service to a known vulnerability. A hands on lab lets you put all of this into practice by tracking down a genuinely exposed database.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what Shodan indexes and how it differs from a normal search engine.</li>
        <li>Distinguish passive reconnaissance from active reconnaissance.</li>
        <li>Construct Shodan queries using product, port, country and org filters.</li>
        <li>Read a service banner to identify a product, version, and potential misconfiguration.</li>
        <li>Correlate an exposed service and version to a known CVE.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Shodan and Passive Reconnaissance
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>A Search Engine for Devices</h2>

    <p>Shodan continuously scans the public internet, connects to open ports, and stores whatever response each service sends back. That stored response is called a <strong>banner</strong>. Instead of indexing web page content like a traditional search engine, Shodan indexes the metadata of the devices themselves: their software, version, open ports, and location.</p>

    <p>Because the scanning already happened before you ever searched, querying Shodan does not send any traffic to the target at all. This is what makes it a tool for <strong>passive reconnaissance</strong>. Compare that to <strong>active reconnaissance</strong>, where a tool like a port scanner connects directly to the target and generates logs on that system in real time.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What Shodan Actually Indexes</h4>
        <p>Shodan stores banners and metadata, things like service headers, version strings, and open ports. It does not index file contents or credentials directly. Any sensitive data visible in a banner is simply what the exposed service chose to reveal on connection.</p>
    </div>

    <!-- SVG: Active vs Passive recon flow
         Teaching purpose: show the learner that querying Shodan never sends traffic to the target
         itself, which they would otherwise misunderstand as still requiring direct contact with the
         target network. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Active versus passive reconnaissance flow">
            <!-- Active recon path -->
            <text x="20" y="30" font-size="13" font-weight="600" fill="var(--text-primary)">Active Recon</text>
            <rect x="20" y="45" width="130" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="78" text-anchor="middle" font-size="13" fill="var(--text-primary)">You</text>
            <line x1="150" y1="72" x2="290" y2="72" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <text x="220" y="62" text-anchor="middle" font-size="10" fill="var(--text-secondary)">direct traffic</text>
            <rect x="290" y="45" width="150" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="365" y="72" text-anchor="middle" font-size="13" fill="var(--text-primary)">Target System</text>
            <text x="365" y="88" text-anchor="middle" font-size="10" fill="var(--text-secondary)">generates logs</text>

            <!-- Passive recon path -->
            <text x="20" y="135" font-size="13" font-weight="600" fill="var(--text-primary)">Passive Recon</text>
            <rect x="20" y="150" width="130" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="183" text-anchor="middle" font-size="13" fill="var(--text-primary)">You</text>
            <line x1="150" y1="177" x2="290" y2="177" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="220" y="167" text-anchor="middle" font-size="10" fill="var(--text-secondary)">query</text>
            <rect x="290" y="150" width="150" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="365" y="173" text-anchor="middle" font-size="13" fill="var(--text-primary)">Shodan Database</text>
            <text x="365" y="189" text-anchor="middle" font-size="10" fill="var(--text-secondary)">pre collected data</text>
            <line x1="440" y1="177" x2="580" y2="177" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4,4"/>
            <rect x="580" y="150" width="150" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" opacity="0.5"/>
            <text x="655" y="173" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Target</text>
            <text x="655" y="189" text-anchor="middle" font-size="10" fill="var(--text-secondary)">never contacted</text>

            <defs>
                <marker id="arr1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <h3>Active vs Passive Recon</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>Touches Target</th>
                <th>Detection Risk</th>
                <th>Example Tool</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Active Recon</strong></td>
                <td>Yes</td>
                <td>High</td>
                <td>Nmap</td>
            </tr>
            <tr>
                <td><strong>Passive Recon</strong></td>
                <td>No</td>
                <td>None</td>
                <td>Shodan</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 3: Shodan Search Filters
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Turning Millions of Results into One</h2>

    <p>Shodan indexes hundreds of millions of devices. Searching for a single keyword like "camera" would return an overwhelming, mostly useless list. Filters let you combine multiple conditions into one precise query, narrowing results down to exactly the kind of device you are looking for.</p>

    <p>Filters follow a simple <code>key:value</code> pattern and can be combined in a single search by separating them with spaces. A query like <code>product:MongoDB country:US</code> only returns MongoDB instances located in the United States.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Filter</th>
                <th>Matches</th>
                <th>Example Query</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>product:</code></td>
                <td>A specific software or service name</td>
                <td>product:MongoDB</td>
            </tr>
            <tr>
                <td><code>port:</code></td>
                <td>A specific network port</td>
                <td>port:27017</td>
            </tr>
            <tr>
                <td><code>country:</code></td>
                <td>Devices located in a specific country</td>
                <td>country:US</td>
            </tr>
            <tr>
                <td><code>org:</code></td>
                <td>Devices belonging to a specific organization</td>
                <td>org:"Global Retail Corp"</td>
            </tr>
            <tr>
                <td><code>net:</code></td>
                <td>Devices within an IP range or CIDR block</td>
                <td>net:192.168.1.0/24</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Viewing Is Not Authorization</h4>
        <p>Finding an exposed service through Shodan does not grant you permission to connect to it, log into it, or interact with it in any way. Passive discovery and unauthorized access are two very different things, legally and ethically.</p>
    </div>
</div>
HTML;

// TASK 4: Reading Banners and Service Fingerprints
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>What a Banner Actually Tells You</h2>

    <p>A banner is the raw response a service sends the moment a connection is made, before any authentication happens. A web server might return HTTP headers naming its software and version. An SSH server might return a single line identifying its implementation. Shodan simply captures and stores this text exactly as the service sent it.</p>

    <p>Reading a banner carefully lets you <strong>fingerprint</strong> a service, meaning you identify its exact product and version from that raw text alone. This is the same information an attacker uses to check whether a service is running outdated, vulnerable software, all without sending a single exploit attempt.</p>

    <!-- SVG: Annotated banner diagram
         Teaching purpose: show the learner which parts of a raw banner correspond to service name,
         version, and headers, which they would otherwise misunderstand as one undifferentiated
         block of text. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Annotated service banner">
            <rect x="20" y="20" width="500" height="160" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="35" y="50" font-family="monospace" font-size="13" fill="var(--text-primary)">SSH-2.0-OpenSSH_7.2</text>
            <text x="35" y="80" font-family="monospace" font-size="13" fill="var(--text-primary)">Server: nginx/1.14.0</text>
            <text x="35" y="110" font-family="monospace" font-size="13" fill="var(--text-primary)">X-Powered-By: PHP/5.6.40</text>
            <text x="35" y="140" font-family="monospace" font-size="13" fill="var(--text-primary)">Date: Fri, 03 Jul 2026 09:12:00 GMT</text>

            <!-- Callouts -->
            <line x1="180" y1="45" x2="600" y2="45" stroke="var(--text-secondary)" stroke-width="1"/>
            <text x="605" y="49" font-size="11" fill="var(--text-secondary)">Service name and version</text>

            <line x1="130" y1="75" x2="600" y2="90" stroke="var(--text-secondary)" stroke-width="1"/>
            <text x="605" y="94" font-size="11" fill="var(--text-secondary)">Web server software header</text>

            <line x1="220" y1="105" x2="600" y2="135" stroke="var(--text-secondary)" stroke-width="1"/>
            <text x="605" y="139" font-size="11" fill="var(--text-secondary)">Backend language and version</text>

            <line x1="260" y1="135" x2="600" y2="165" stroke="var(--text-secondary)" stroke-width="1"/>
            <text x="605" y="169" font-size="11" fill="var(--text-secondary)">Timestamp of the scan</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Banners Can Lie</h4>
        <p>Some systems intentionally present a fake or altered banner to mislead scanners, a setup known as a <strong>honeypot</strong>. Treat banner data as a strong signal rather than absolute proof of what a service really is.</p>
    </div>
</div>
HTML;

// TASK 5: From Exposure to CVE
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Connecting a Version to a Known Weakness</h2>

    <p>Once you have fingerprinted a service and its exact version, the next step is checking whether that version has any publicly documented vulnerabilities. These are catalogued as <strong>CVE</strong> entries, short for Common Vulnerabilities and Exposures, a standardized naming system used across the security industry.</p>

    <p>Shodan even provides a dedicated <code>vuln:</code> filter that searches directly for devices already flagged with a known CVE, skipping the manual lookup step entirely.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Service and Version</th>
                <th>CVE ID</th>
                <th>Risk Level</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Apache 2.4.49</td>
                <td>CVE-2021-41773</td>
                <td>Critical</td>
            </tr>
            <tr>
                <td>OpenSSH 7.2</td>
                <td>CVE-2016-0777</td>
                <td>Medium</td>
            </tr>
            <tr>
                <td>Microsoft IIS 6.0</td>
                <td>CVE-2017-7269</td>
                <td>Critical</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Banner to CVE flow
         Teaching purpose: show the learner that going from banner to CVE is a sequential lookup
         process, which they would otherwise misunderstand as one automatic step. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Banner to CVE lookup flow">
            <rect x="10" y="30" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90" y="65" text-anchor="middle" font-size="13" fill="var(--text-primary)">Banner</text>
            <line x1="170" y1="60" x2="205" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrb)"/>

            <rect x="205" y="30" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="285" y="65" text-anchor="middle" font-size="13" fill="var(--text-primary)">Version String</text>
            <line x1="365" y1="60" x2="400" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrb)"/>

            <rect x="400" y="30" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="480" y="65" text-anchor="middle" font-size="13" fill="var(--text-primary)">CVE Lookup</text>
            <line x1="560" y1="60" x2="595" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrb)"/>

            <rect x="595" y="30" width="155" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="672" y="65" text-anchor="middle" font-size="13" fill="var(--text-primary)">Patch or Mitigate</text>

            <defs>
                <marker id="arrb" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Defensive Value</h4>
        <p>Security teams run this exact process against their own infrastructure. Finding your own outdated, exposed services through Shodan before an attacker does is one of the simplest ways to close a real gap.</p>
    </div>
</div>
HTML;

// TASK 6: Practical — Shodan Recon Console
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>A retail company's infrastructure has been indexed by Shodan along with eleven other unrelated devices scattered across different countries and organizations. Somewhere in that list is a database that was deployed without authentication enabled, quietly leaking customer records to anyone who finds it.</p>

    <p>Use the search console below to build filter queries and narrow the results down. Click into any device to inspect its raw banner. Your goal is to identify the one exposed database and read its banner in full.</p>

    <div class="practical-launch-wrapper">
        <a href="shodan-passive-recon-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Shodan Recon Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how Shodan turns pre collected scan data into a searchable index of internet connected devices, and why querying it counts as passive reconnaissance rather than active scanning. You have built precise queries using product, port, country and org filters, read a raw banner to identify a service and its version, and traced that version forward to a known CVE.</p>

    <p>These same skills are used defensively every day, letting security teams discover their own exposed and outdated services before someone else does.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Shodan indexes banners and metadata from devices already scanned, never sending traffic to the target when you search.</li>
        <li>Passive reconnaissance carries no detection risk because the target is never directly contacted.</li>
        <li>Filters like product, port, country and org turn an overwhelming result set into a precise one.</li>
        <li>Banners reveal service name, version, and headers, but can be altered by honeypots.</li>
        <li>Matching a fingerprinted version to a CVE connects passive discovery to real, actionable risk.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
