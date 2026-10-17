<?php
// ============================================================
// xxe-ssrf.php
// Room data file for CYBRIXEN room engine.
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'xxe-ssrf',
    'title'           => 'XXE & Server-Side Request Forgery (SSRF)',
    'description'     => 'Learn how XML parsers can be tricked into leaking files and how servers can be abused to reach internal resources.',
    'icon'            => 'fas fa-network-wired',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic understanding of XML', 'Basic knowledge of HTTP requests', 'Basic web application concepts'],
    'learning_objectives' => [
        'Explain what an XXE vulnerability is and why parsers are affected',
        'Describe common XXE exploitation techniques including blind and out of band attacks',
        'Explain what SSRF is and why it abuses server trust',
        'Describe common SSRF exploitation techniques including internal scanning and metadata access',
        'Identify where XXE and SSRF commonly appear in real applications',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/xxe-ssrf-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is XXE?'],
    ['id' => 'task3', 'title' => 'XXE Exploitation Techniques'],
    ['id' => 'task4', 'title' => 'What is SSRF?'],
    ['id' => 'task5', 'title' => 'SSRF Exploitation Techniques'],
    ['id' => 'task6', 'title' => 'Where These Vulnerabilities Appear'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'xxe_ssrf_progress',
    'instagram_takeaways'  => [
        '✓ XXE lets attackers abuse XML parsers to read local files',
        '✓ Blind and out of band XXE exfiltrate data without direct output',
        '✓ SSRF tricks a trusted server into reaching internal resources',
        '✓ Cloud metadata endpoints are a prime SSRF target',
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
        ['id' => 'q1', 'text' => 'What does the acronym XXE stand for?'],
        ['id' => 'q2', 'text' => 'What keyword declares a custom entity inside a DTD?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What term describes XXE where the application gives no direct output back to the attacker?'],
        ['id' => 'q4', 'text' => 'What technique is commonly used to exfiltrate data in blind XXE attacks?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What does SSRF stand for?'],
        ['id' => 'q6', 'text' => 'What type of network location is the primary target of most SSRF attacks?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What cloud service endpoint is a common SSRF target used to steal temporary credentials?'],
        ['id' => 'q8', 'text' => 'What is the term for using SSRF to map internal hosts and open ports?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What file format, often mistaken for an image, can carry an XXE payload during upload?'],
        ['id' => 'q10', 'text' => 'What common office document format is XML based and can introduce XXE risk when uploaded?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Document Parser Lab.'],
    ],
    'task8' => [
        ['id' => 'q12', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Two of the most common vulnerabilities found in modern web applications come from a simple source: the server trusting input it should not. XML External Entity (XXE) attacks abuse XML parsers that resolve external references, allowing an attacker to read files they were never meant to see. Server-Side Request Forgery (SSRF) abuses a server's ability to make its own requests, tricking it into reaching internal systems that are normally out of an attacker's reach.</p>

    <p>By the end of this room you will be able to explain how both attacks work, recognize the parser and application behaviors that make them possible, and identify where they commonly hide in real features like file uploads and URL fetching tools. A hands on lab is included so you can exploit a simulated vulnerable parser yourself.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what an XXE vulnerability is and why parsers are affected.</li>
        <li>Describe common XXE exploitation techniques including blind and out of band attacks.</li>
        <li>Explain what SSRF is and why it abuses server trust.</li>
        <li>Describe common SSRF exploitation techniques including internal scanning and metadata access.</li>
        <li>Identify where XXE and SSRF commonly appear in real applications.</li>
    </ul>
</div>
HTML;

// TASK 2: What is XXE?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Entities, DTDs, and a Dangerous Default</h2>

    <p>XML documents can define their own custom shortcuts called entities. An entity is declared inside a Document Type Definition (DTD) using the <strong>ENTITY</strong> keyword, and once declared, it can be referenced anywhere in the document using an ampersand and a semicolon, like <code>&amp;xxe;</code>.</p>

    <p>Think of an entity like a mail merge field in a document template. Normally it gets replaced with a small piece of text, such as a name or a date. The danger appears when an entity is declared as <strong>SYSTEM</strong>, pointing at an external resource such as a file path. Many XML parsers will happily fetch and insert whatever is at that location, including the contents of a local file on the server.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Dangerous Default</h4>
        <p>Many XML libraries historically resolved external entities automatically unless a developer explicitly disabled the feature. This single default setting is responsible for a huge number of real-world XXE vulnerabilities.</p>
    </div>

    <!-- SVG: Entity resolution flow
         Teaching purpose: show the learner that a declared entity is resolved against
         an actual file path by the parser, which they would otherwise misunderstand
         as harmless text substitution. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="XML entity resolution flow">
            <rect x="10"  y="30" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="290" y="30" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="570" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="210" y1="70" x2="285" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrow1)"/>
            <line x1="490" y1="70" x2="565" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrow1)"/>
            <defs>
                <marker id="arrow1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="110" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">XML with DOCTYPE</text>
            <text x="110" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">ENTITY xxe SYSTEM</text>
            <text x="110" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">"file:///path"</text>
            <text x="390" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Parser Resolves</text>
            <text x="390" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Entity Reference</text>
            <text x="390" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">&amp;xxe; found in body</text>
            <text x="660" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">File Contents</text>
            <text x="660" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Returned to</text>
            <text x="660" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Parsed Output</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: XXE Exploitation Techniques
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>From File Reads to Blind Exfiltration</h2>

    <p>The most direct form of XXE is classic file disclosure, where the parser output shows the contents of a requested file right in the response. Not every application is this forgiving. When the response never reflects the resolved entity back to the attacker, the attack is called <strong>blind XXE</strong>.</p>

    <p>Blind XXE does not mean the attack failed. It means the attacker needs a different way to see the result. That is where <strong>out of band</strong> techniques come in, using an externally hosted DTD to smuggle data out through a separate channel the attacker controls.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Technique</th>
                <th>How It Works</th>
                <th>When It's Used</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Classic file disclosure</td>
                <td>Entity resolves to a file, contents appear directly in the response.</td>
                <td>When parser output reflects field values back to the user.</td>
            </tr>
            <tr>
                <td>Blind XXE</td>
                <td>Entity resolves, but nothing is reflected in the response.</td>
                <td>When output is hidden, logged only, or processed silently.</td>
            </tr>
            <tr>
                <td>Out of band (OOB)</td>
                <td>An external DTD triggers a request to an attacker controlled server carrying the stolen data.</td>
                <td>When blind XXE prevents any in-page confirmation of success.</td>
            </tr>
            <tr>
                <td>Error based XXE</td>
                <td>A malformed entity reference causes an error message that leaks file contents.</td>
                <td>When verbose error handling is enabled on the server.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Out of band exfiltration flow
         Teaching purpose: show data leaving through an attacker controlled listener rather
         than appearing directly in the response, which learners would otherwise confuse
         with normal in-page output. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Out of band XXE exfiltration flow">
            <rect x="10"  y="30" width="220" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="540" y="30" width="210" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="230" y1="70" x2="535" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="6,4" marker-end="url(#arrow2)"/>
            <defs>
                <marker id="arrow2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="380" y="55" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Out of band request</text>
            <text x="380" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">carrying stolen data</text>
            <text x="120" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Vulnerable Server</text>
            <text x="120" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Fetches external DTD</text>
            <text x="120" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">No output shown to user</text>
            <text x="645" y="62" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attacker Listener</text>
            <text x="645" y="80" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Receives leaked data</text>
            <text x="645" y="96" text-anchor="middle" font-size="11" fill="var(--text-secondary)">via server log or request</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Typical XXE file disclosure targets include configuration files, credential files, and application source code, since these often sit in predictable locations on the server.</p>
    </div>
</div>
HTML;

// TASK 4: What is SSRF?
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Abusing a Server's Trusted Position</h2>

    <p>Many applications include a feature that fetches a URL on the user's behalf, such as generating a link preview, validating a webhook, or downloading a remote image. This means the server itself makes an outbound request, not the user's browser.</p>

    <p>SSRF happens when an attacker supplies a URL that points somewhere the server can reach but the attacker cannot reach directly, such as an internal service or the local machine itself. The server acts like a mail room clerk holding master keys. A visitor at the front desk cannot walk into a restricted office, but the clerk can be tricked into delivering something there on their behalf.</p>

    <!-- SVG: SSRF trust boundary
         Teaching purpose: show the request routed through a trusted server into the
         internal network, which the learner would otherwise misunderstand as the
         attacker connecting directly to the internal resource. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SSRF trust boundary diagram">
            <rect x="10"  y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="290" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="570" y="30" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="190" y1="70" x2="285" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrow3)"/>
            <line x1="470" y1="70" x2="565" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrow3)"/>
            <defs>
                <marker id="arrow3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="100" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Attacker</text>
            <text x="100" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Submits crafted URL</text>
            <text x="380" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Trusted Server</text>
            <text x="380" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Makes request on</text>
            <text x="380" y="97" text-anchor="middle" font-size="11" fill="var(--text-secondary)">attacker's behalf</text>
            <text x="660" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Internal Resource</text>
            <text x="660" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Normally unreachable</text>
            <text x="660" y="97" text-anchor="middle" font-size="11" fill="var(--text-secondary)">from outside</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Common Vulnerable Features</h4>
        <p>URL preview tools, webhook validators, image or document fetchers, and PDF generators frequently include this kind of server side fetch functionality, making them common SSRF entry points.</p>
    </div>
</div>
HTML;

// TASK 5: SSRF Exploitation Techniques
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Reaching What Should Be Out of Reach</h2>

    <p>Once an attacker can influence the server's outbound requests, several targets become possible. Internal services that were never meant to face the internet suddenly become reachable, simply because the request originates from inside the trusted network.</p>

    <p>Attackers also use SSRF to bypass filters, using techniques like redirect chains or alternate ways of writing an IP address to slip past basic blocklists that only check the URL as typed.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Target</th>
                <th>Example</th>
                <th>Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Cloud metadata service</td>
                <td>A special internal address that returns instance credentials.</td>
                <td>Temporary cloud credentials can be stolen and reused.</td>
            </tr>
            <tr>
                <td>Internal admin panels</td>
                <td>Management interfaces only meant to be reached from inside the network.</td>
                <td>Full administrative access without any authentication barrier.</td>
            </tr>
            <tr>
                <td>Internal APIs and databases</td>
                <td>Services that trust any request coming from inside the network.</td>
                <td>Direct data access or unauthorized actions performed on the backend.</td>
            </tr>
            <tr>
                <td>Localhost services</td>
                <td>Services bound only to the server's own loopback address.</td>
                <td>Access to debugging tools or services never meant to be exposed.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Cloud Metadata Risk</h4>
        <p>Cloud metadata services are one of the most common and most damaging SSRF targets, since the credentials they return can often be reused far beyond the original application.</p>
    </div>
</div>
HTML;

// TASK 6: Where These Vulnerabilities Appear
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Real Features, Real Risk</h2>

    <p>XXE and SSRF are not rare edge cases. They hide inside ordinary features that developers add without realizing what they enable. Recognizing these patterns is often the fastest way to spot risk during a review.</p>

    <p>File formats that look harmless can carry XML underneath. Document formats built on XML, and features that fetch remote content, are the two most common entry points for these vulnerabilities.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Feature</th>
                <th>Vulnerability Type</th>
                <th>Why It's Risky</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>File upload accepting SVG</td>
                <td>XXE</td>
                <td>SVG is XML based and often overlooked as an image only format.</td>
            </tr>
            <tr>
                <td>File upload accepting DOCX or other office formats</td>
                <td>XXE</td>
                <td>These formats are XML documents packaged inside a zip container.</td>
            </tr>
            <tr>
                <td>API accepting XML payloads</td>
                <td>XXE</td>
                <td>Parsers may resolve external entities by default.</td>
            </tr>
            <tr>
                <td>URL preview or webhook validation</td>
                <td>SSRF</td>
                <td>The server fetches a URL supplied directly by the user.</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Defenses</h4>
        <p>Disabling external entity resolution in XML parsers and allow-listing outbound destinations for any server side fetch feature address the root cause of both vulnerability classes.</p>
    </div>
</div>
HTML;

// TASK 7: Practical — Document Parser Lab
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Resume Parser Pro accepts XML formatted resumes and displays the parsed profile back to the applicant. The development team assumed the XML content was harmless since it only contained personal details like a name, email, and a skills list.</p>

    <p>Your task is to craft an XML payload that abuses the parser's default entity resolution to read a hidden internal configuration file. Use the editor to modify the sample resume, submit it, and inspect the output panel closely.</p>

    <div class="practical-launch-wrapper">
        <a href="xxe-ssrf-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Document Parser Lab</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You now understand how XXE and SSRF both stem from the same underlying issue, an application trusting input more than it should. XXE abuses an XML parser's willingness to resolve external references, while SSRF abuses a server's trusted position on the internal network. Both are frequently found in ordinary features like file uploads and URL fetching tools.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>XXE exploits XML parsers that resolve external entities by default.</li>
        <li>Blind XXE requires out of band techniques to confirm success without direct output.</li>
        <li>SSRF tricks a trusted server into making requests to internal or restricted resources.</li>
        <li>Cloud metadata endpoints are a high value SSRF target for stealing credentials.</li>
        <li>Both vulnerabilities commonly hide inside file upload and remote fetch features.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
