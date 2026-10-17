<?php
// google-dorking-osint.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'google-dorking-osint',
    'title'           => 'Google Dorking & Search Engine OSINT',
    'description'     => 'Learn advanced search operators to uncover exposed login panels, sensitive files, and employee data indexed by search engines.',
    'icon'            => 'fas fa-magnifying-glass',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '45 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic understanding of search engines'],
    'learning_objectives' => [
        'Explain what a search operator is and how search engines index content',
        'Construct dorks using site:, filetype:, inurl:, and intitle:',
        'Identify the kinds of sensitive data commonly exposed through search engines',
        'Recognize Google dorking as a legitimate defensive audit technique',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/google-dorking-osint-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Google Dorking?'],
    ['id' => 'task3', 'title' => 'Locating Files and Directories'],
    ['id' => 'task4', 'title' => 'Narrowing the Search'],
    ['id' => 'task5', 'title' => 'The Real World Risk of Exposure'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'google_dorking_osint_progress',
    'instagram_takeaways'  => [
        '✓ Google dorking uses public search operators, not hacking tools',
        '✓ site: and filetype: narrow results to a domain or file type',
        '✓ inurl: and intitle: hunt for login panels and directory listings',
        '✓ Indexed does not mean intended, audit your own exposure',
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
        ['id' => 'q1', 'text' => 'What term describes a special keyword used to refine a search engine query?'],
        ['id' => 'q2', 'text' => 'What is the term for the automated program that indexes web pages for a search engine?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'Which operator restricts search results to a single domain?'],
        ['id' => 'q4', 'text' => 'Which operator restricts search results to a specific file extension?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'Which operator searches for text within a page\'s URL?'],
        ['id' => 'q6', 'text' => 'Which operator searches for text within a page\'s title?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What is the industry term for gathering information from publicly available sources, including search engines?'],
        ['id' => 'q8', 'text' => 'What should you obtain before using dorking techniques against a system you do not own?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Enter the flag you discovered in the Dork Console.'],
    ],
    'task7' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Search engines index far more than the average person realizes. Every day, crawlers sweep across the internet cataloging pages, documents, and directories, often including files their owners never intended to be publicly reachable. Google dorking is the practice of using advanced search operators to surface this hidden layer of exposed data.</p>

    <p>By the end of this room, you will be able to construct precise search queries that locate specific file types, restricted directories, and exposed login pages using nothing but a standard search engine. A hands on lab is included where you will use these techniques to uncover exposed assets belonging to a fictional company.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what a search operator is and how search engines index content.</li>
        <li>Construct dorks using site:, filetype:, inurl:, and intitle:.</li>
        <li>Identify the kinds of sensitive data commonly exposed through search engines.</li>
        <li>Recognize Google dorking as a legitimate defensive audit technique.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Google Dorking?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Searching Beyond the First Page</h2>

    <p>A search operator is a special keyword or symbol added to a query that changes how a search engine interprets it. Instead of matching general keywords, an operator tells the engine to filter results by a specific property, such as the domain a page belongs to or the type of file it is.</p>

    <p>Google dorking simply means combining these operators to find content that a normal keyword search would never surface. It uses entirely public, legitimate search functionality. No hacking tools or unauthorized access are involved at any point.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Public Search, Not Hacking</h4>
        <p>Dorking only retrieves what a search engine has already indexed and made publicly searchable. The technique does not bypass any security control on its own.</p>
    </div>

    <h3>How Content Ends Up Indexed</h3>
    <p>Think of a search engine's index as a library card catalog that lists every book on every shelf, including ones the librarian forgot were there. A crawler is the automated program that walks through websites, follows links, and adds anything it finds into that catalog. If a file or folder is reachable by a link or a direct path, a crawler can find and index it, whether or not the owner meant for it to be public.</p>

    <!-- SVG: Crawler indexing flow
         Teaching purpose: show the learner that a crawler indexes everything reachable,
         including forgotten or unlinked files, which they would otherwise misunderstand
         as "only intentional pages get indexed." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 800 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Crawler indexing flow from company server to public search results">
            <!-- Background boxes -->
            <rect x="10"  y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="220" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="430" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="620" y="30" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="180" y1="70" x2="215" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowhead)"/>
            <line x1="390" y1="70" x2="425" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowhead)"/>
            <line x1="600" y1="70" x2="615" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrowhead)"/>
            <defs>
                <marker id="arrowhead" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="95"  y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Company Server</text>
            <text x="95"  y="83" text-anchor="middle" font-size="10" fill="var(--text-secondary)">public and forgotten files</text>
            <text x="305" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Crawler</text>
            <text x="305" y="83" text-anchor="middle" font-size="10" fill="var(--text-secondary)">follows every reachable link</text>
            <text x="515" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Search Index</text>
            <text x="515" y="83" text-anchor="middle" font-size="10" fill="var(--text-secondary)">catalog of everything found</text>
            <text x="705" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Search Results</text>
            <text x="705" y="83" text-anchor="middle" font-size="10" fill="var(--text-secondary)">visible to anyone</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Locating Files and Directories
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Narrowing Results With site: and filetype:</h2>

    <p>The site: operator restricts results to a single domain. It is like searching only one specific shelf in a library instead of the entire building. The filetype: operator restricts results to a particular file extension, similar to asking a librarian for only paperbacks rather than every book on the shelf.</p>

    <p>Combined together, these two operators let you ask a very specific question: does this domain have any publicly indexed files of this type?</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Operator</th>
                <th>What It Does</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>site:</strong></td>
                <td>Limits results to a single domain.</td>
                <td>site:example.com</td>
            </tr>
            <tr>
                <td><strong>filetype:</strong></td>
                <td>Limits results to a specific file extension.</td>
                <td>filetype:pdf</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> A Common Oversight</h4>
        <p>Many organizations unintentionally leave internal PDFs, spreadsheets, and backup files publicly indexed. A single combined query like site:example.com filetype:pdf can reveal them in seconds.</p>
    </div>
</div>
HTML;

// TASK 4: Narrowing the Search
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Hunting Pages With inurl: and intitle:</h2>

    <p>The inurl: operator searches for text that appears inside a page's URL. It is like checking the label on a filing cabinet drawer before opening it. The intitle: operator searches for text inside a page's title tag, similar to reading the cover of a folder before you look through its contents.</p>

    <p>Both operators are commonly used to hunt for login panels, admin pages, and exposed directory listings, since these pages tend to follow predictable naming patterns.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Operator</th>
                <th>What It Does</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>inurl:</strong></td>
                <td>Finds pages with a keyword inside the URL.</td>
                <td>inurl:admin</td>
            </tr>
            <tr>
                <td><strong>intitle:</strong></td>
                <td>Finds pages with a keyword inside the page title.</td>
                <td>intitle:"index of"</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Chaining Operators</h4>
        <p>Operators can be combined in a single query for far more precision. For example, site:example.com inurl:admin narrows the search to admin related pages on one specific domain only.</p>
    </div>
</div>
HTML;

// TASK 5: The Real World Risk of Exposure
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>What Actually Gets Exposed</h2>

    <p>These operators are simple, but the consequences of what they uncover are not. Exposed login panels, leaked internal documents, employee contact information, and forgotten backup files are all regularly discovered this way, not by breaking into a system, but by searching for what was already public.</p>

    <p>It is a bit like leaving a filing cabinet unlocked in a public hallway. Technically nobody broke in, but anyone walking by can read what is inside.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Exposure Type</th>
                <th>Example Dork Pattern</th>
                <th>Real World Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Login panels</td>
                <td>site:example.com inurl:login</td>
                <td>Reveals attack surface and internal system names.</td>
            </tr>
            <tr>
                <td>Sensitive files</td>
                <td>site:example.com filetype:xlsx</td>
                <td>May contain financial or credential data.</td>
            </tr>
            <tr>
                <td>Directory listings</td>
                <td>intitle:"index of" site:example.com</td>
                <td>Exposes raw backups, configs, and source files.</td>
            </tr>
            <tr>
                <td>Employee data</td>
                <td>site:example.com filetype:pdf</td>
                <td>Leaks names, emails, and org structure.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Use Responsibly</h4>
        <p>Google dorking should be used for authorized security assessments and for auditing your own organization's exposure, never for targeting third parties without permission.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been brought in to run a search exposure audit on a fictional company, Solvex Industries. Your task is to use the Dork Console to construct valid search queries and uncover any sensitive assets the company has unintentionally left publicly indexed.</p>

    <p>Apply the operators from this room, site:, filetype:, inurl:, and intitle:, to locate exposed files and pages. Once you have found every planted asset, a final combined query will reveal the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="google-dorking-osint-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Dork Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how search engines index far more than most people realize, and how a handful of operators can reveal it. Authentication and security controls only matter if content is not already sitting in a public index waiting to be found. That is exactly the gap Google dorking exposes.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Search operators refine what a search engine matches, they do not bypass any security control.</li>
        <li>site: and filetype: narrow results to a domain and a specific file extension.</li>
        <li>inurl: and intitle: locate pages based on their URL or title text.</li>
        <li>Indexed does not mean intended, organizations frequently expose data without realizing it.</li>
        <li>Dorking should only be used for authorized audits, including auditing your own exposure.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
