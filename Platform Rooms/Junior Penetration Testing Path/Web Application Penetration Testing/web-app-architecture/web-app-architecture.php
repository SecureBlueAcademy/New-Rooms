<?php
// ============================================================
// web-app-architecture.php — CYBRIXEN ROOM DATA FILE
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'web-app-architecture',
    'title'           => 'Web Application Architecture',
    'description'     => 'Explains how web applications work: the HTTP request/response cycle, client-server model, cookies, sessions, and databases, and where a pentester\'s attack surface exists across the stack.',
    'icon'            => 'fas fa-sitemap',
    'banner'          => '../../assets/banner-webapp.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic internet browsing experience'],
    'learning_objectives' => [
        'Explain the client-server model and the HTTP request/response cycle',
        'Describe how cookies and sessions maintain state across requests',
        'Explain the role of databases in a typical web application',
        'Identify where a pentester\'s attack surface exists across the web stack',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/web-app-architecture-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Client-Server Model and HTTP'],
    ['id' => 'task3', 'title' => 'Cookies and Sessions'],
    ['id' => 'task4', 'title' => 'The Role of Databases'],
    ['id' => 'task5', 'title' => 'Where a Pentester Fits'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'web_app_architecture_progress',
    'instagram_takeaways'  => [
        '✓ The client-server model and the HTTP request/response cycle',
        '✓ How cookies and sessions keep stateless HTTP feeling continuous',
        '✓ The role databases play behind almost every dynamic page',
        '✓ Where a pentester\'s attack surface sits across the whole stack',
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
        ['id' => 'q1', 'text' => 'What HTTP method is used to submit form data to a server?'],
        ['id' => 'q2', 'text' => 'What HTTP status code indicates a page was not found?'],
        ['id' => 'q3', 'text' => 'What term describes HTTP\'s inability to remember previous requests?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What HTTP header does a server use to issue a cookie?'],
        ['id' => 'q5', 'text' => 'What is the term for the unique identifier stored in a cookie that ties a request back to a specific user?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What language is used to query and retrieve data from a database?'],
        ['id' => 'q7', 'text' => 'What type of attack exploits unsanitized user input sent to a database?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What term describes all the possible points where an attacker could attempt to gain access to a system?'],
        ['id' => 'q9', 'text' => 'What is the term for stealing a valid session cookie to impersonate a user?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Enter the flag revealed by the Request Inspector.'],
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
    <p>Every website you visit is powered by an invisible machine underneath it. A browser sends a request, a server sends back a response, a cookie quietly keeps you logged in, and a database somewhere stores the data that makes the page feel personal. None of this is magic, it is a small set of predictable building blocks working together, and once you understand them you will never look at a URL the same way again.</p>

    <p>By the end of this room you will be able to explain how a browser and a server communicate, how websites remember who you are between page loads, and where a database sits behind the content you see. A hands on practical is included so you can trace a real request and response for yourself.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the client-server model and the HTTP request/response cycle.</li>
        <li>Describe how cookies and sessions maintain state across requests.</li>
        <li>Explain the role of databases in a typical web application.</li>
        <li>Identify where a pentester's attack surface exists across the web stack.</li>
        <li>Trace a real browser action through request, response, and stored state.</li>
    </ul>
</div>
HTML;

// TASK 2: The Client-Server Model and the HTTP Request/Response Cycle
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Machines Having a Conversation</h2>

    <p>Every time you open a website, two machines are talking to each other. Your device, the <strong>client</strong>, sends a message asking for something. A remote machine, the <strong>server</strong>, sends back a response. This exchange is called the HTTP request and response cycle, and it happens every time you load a page, click a link, or submit a form.</p>

    <p>Think of it like ordering food at a restaurant. You tell the kitchen what you want, the kitchen prepares it, and a plate comes back to your table. You never see how the kitchen works internally, you only see the order you placed and the plate you received.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> HTTP Is Stateless</h4>
        <p>Each HTTP request stands completely on its own. The server has no built in memory of who you are or what you did a moment ago. Keep this in mind, it becomes important in the next task.</p>
    </div>

    <h3>Common HTTP Status Codes</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Meaning</th>
                <th>Real World Trigger</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>200</td>
                <td>OK</td>
                <td>The page loaded normally.</td>
            </tr>
            <tr>
                <td>301</td>
                <td>Moved Permanently</td>
                <td>An old link redirects you to its new location.</td>
            </tr>
            <tr>
                <td>404</td>
                <td>Not Found</td>
                <td>You mistyped a URL or a page was removed.</td>
            </tr>
            <tr>
                <td>500</td>
                <td>Internal Server Error</td>
                <td>Something broke on the server while handling your request.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Request/response flow
         Teaching purpose: show the learner that a page load is two separate
         messages travelling in opposite directions, which they would
         otherwise misunderstand as a single instant action. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="HTTP request and response flow">
            <!-- Client and server boxes -->
            <rect x="20" y="40" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="520" y="40" width="160" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="75" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Browser</text>
            <text x="100" y="95" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Client</text>
            <text x="600" y="75" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Web Server</text>
            <text x="600" y="95" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Server</text>

            <!-- Request arrow -->
            <line x1="180" y1="55" x2="515" y2="55" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead)"/>
            <text x="350" y="45" text-anchor="middle" font-size="12" fill="var(--text-secondary)">GET /index.html</text>

            <!-- Response arrow -->
            <line x1="515" y1="105" x2="180" y2="105" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead)"/>
            <text x="350" y="135" text-anchor="middle" font-size="12" fill="var(--text-secondary)">200 OK + page content</text>

            <defs>
                <marker id="arrHead" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Cookies and Sessions
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Faking a Continuous Conversation</h2>

    <p>You just learned that HTTP is stateless, each request stands alone. So how does a website keep you logged in as you move from page to page? The answer is a small piece of data called a <strong>cookie</strong>.</p>

    <p>When you log in, the server sends back a response containing a <strong>Set-Cookie</strong> header. Your browser stores this value and automatically attaches it to every future request to that site. The stored value usually includes a <strong>session ID</strong>, a unique identifier the server uses to look up who you are.</p>

    <p>It works a lot like a coat check ticket. You hand over your coat once and receive a ticket. You do not need to describe your coat again, the ticket alone proves it is yours when you come back.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> A Cookie Is a Key</h4>
        <p>If someone steals a valid session cookie, they can present it to the server and be treated as the logged in user, without ever knowing the password. This is why protecting cookies matters as much as protecting passwords.</p>
    </div>

    <!-- SVG: Cookie issuance and reuse
         Teaching purpose: show the learner that the cookie is sent automatically
         on every later request, which they would otherwise misunderstand as
         something that only happens once at login. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Cookie issued at login and reused on later request">
            <!-- Row 1: login -->
            <rect x="20" y="20" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="530" y="20" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Browser</text>
            <text x="605" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Server</text>
            <line x1="170" y1="35" x2="525" y2="35" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead2)"/>
            <text x="350" y="25" text-anchor="middle" font-size="11" fill="var(--text-secondary)">POST /login</text>
            <line x1="525" y1="65" x2="170" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead2)"/>
            <text x="350" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Set-Cookie: session_id=abc123</text>

            <!-- Row 2: later request -->
            <rect x="20" y="150" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="530" y="150" width="150" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="185" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Browser</text>
            <text x="605" y="185" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Server</text>
            <line x1="170" y1="165" x2="525" y2="165" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead2)"/>
            <text x="350" y="155" text-anchor="middle" font-size="11" fill="var(--text-secondary)">GET /account</text>
            <text x="350" y="215" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Cookie: session_id=abc123 (sent automatically)</text>

            <defs>
                <marker id="arrHead2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 4: The Role of Databases in Web Apps
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Where the Data Actually Lives</h2>

    <p>Most pages you visit are not hand written files sitting on the server. They are built on the fly using information pulled from a <strong>database</strong>, a structured store of information the application can search and update.</p>

    <p>When your browser asks for a page, the application server does not memorize the answer, it sends a <strong>query</strong> written in a language called <strong>SQL</strong> to the database, receives back a set of rows, and uses that data to build the page you see.</p>

    <p>It works a lot like a library card catalog. The librarian does not memorize the location of every book, they look it up in the catalog and hand you the result.</p>

    <h3>What Databases Typically Store</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Data Type</th>
                <th>Why It Matters</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>User credentials</td>
                <td>Verifying who is allowed to log in.</td>
            </tr>
            <tr>
                <td>Product or content listings</td>
                <td>Powering the pages users browse.</td>
            </tr>
            <tr>
                <td>Order and transaction history</td>
                <td>Tracking what a user has done over time.</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> A High Value Target</h4>
        <p>Because databases hold the application's most valuable information, the boundary where user input reaches a database query is one of the most targeted points in real attacks.</p>
    </div>

    <!-- SVG: Three tier flow
         Teaching purpose: show the learner that a page request passes through
         an application server to a database and back, which they would
         otherwise misunderstand as the server "just knowing" the data. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Three tier request flow from browser to database">
            <rect x="10"  y="20" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="290" y="20" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="570" y="20" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="190" y1="60" x2="285" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead3)"/>
            <line x1="470" y1="60" x2="565" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHead3)"/>
            <defs>
                <marker id="arrHead3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="100" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Browser</text>
            <text x="100" y="75" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Requests a page</text>
            <text x="380" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">App Server</text>
            <text x="380" y="75" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Builds a query</text>
            <text x="660" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Database</text>
            <text x="660" y="75" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Returns rows</text>
        </svg>
    </div>
</div>
HTML;

// TASK 5: Where a Pentester Fits, Attack Surface Across the Stack
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Reading the Stack Like an Attacker</h2>

    <p>You now know the pieces: a browser and server exchanging requests, cookies keeping you logged in, and a database sitting behind the content. A pentester looks at this same stack and asks a different question at every layer, where could this be abused?</p>

    <p>Recognizing what normal traffic looks like is exactly what makes abnormal traffic visible. Every concept covered so far, the restaurant order, the coat check ticket, the library catalog, maps to a real category of risk.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Layer</th>
                <th>Example Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Browser and Client</td>
                <td>Cross site scripting</td>
            </tr>
            <tr>
                <td>HTTP Request/Response Cycle</td>
                <td>Parameter tampering</td>
            </tr>
            <tr>
                <td>Cookies and Sessions</td>
                <td>Session hijacking</td>
            </tr>
            <tr>
                <td>Database</td>
                <td>SQL injection</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Foundation Before Offense</h4>
        <p>Every attack technique you will learn later in this platform targets one of these same layers. Understanding how the layer is supposed to behave is what lets you spot when it does not.</p>
    </div>
</div>
HTML;

// TASK 6: Practical, Request Inspector
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have access to a live traffic inspector showing both sides of a conversation at once. A browser panel shows exactly what gets sent, a server panel shows exactly what comes back.</p>

    <p>Step through all five scenarios: loading a page, submitting a login, returning with a stored cookie, hitting a broken link, and an expired session. Read both panels carefully for each one, the flag appears once every scenario has been traced.</p>

    <div class="practical-launch-wrapper">
        <a href="web-app-architecture-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Request Inspector</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand the machinery behind every website you visit. A browser and server exchange requests and responses, cookies and sessions patch over the fact that HTTP forgets everything between requests, and a database sits quietly behind most of the content you see. Together these pieces form the stack a pentester learns to read.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>The client-server model splits work between a requesting browser and a responding server.</li>
        <li>HTTP is stateless, each request is handled independently.</li>
        <li>Cookies and session IDs let a website recognize you across multiple requests.</li>
        <li>Databases store the information behind most dynamic page content.</li>
        <li>Every layer of this stack, the browser, the request cycle, cookies, and the database, is a potential attack surface.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
