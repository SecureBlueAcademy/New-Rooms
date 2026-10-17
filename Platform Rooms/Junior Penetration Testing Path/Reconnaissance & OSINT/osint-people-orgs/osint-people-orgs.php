<?php
// ============================================================
// osint-people-orgs.php — ROOM DATA FILE
// Topic: OSINT on People & Organisations
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'osint-people-orgs',
    'title'           => 'OSINT on People & Organisations',
    'description'     => 'Learn how LinkedIn, GitHub, job postings, and breach databases expose employees and organisations to targeted attacks.',
    'icon'            => 'fas fa-user-secret',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic networking concepts'],
    'learning_objectives' => [
        'Explain what open source intelligence is and how it differs from active reconnaissance',
        'Identify how LinkedIn profiles expose organisational structure and employee details',
        'Recognise how GitHub repositories and commit history leak sensitive secrets',
        'Extract infrastructure and tooling clues from job postings',
        'Understand the risk of leaked credentials and password reuse in breach databases',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/osint-people-orgs-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is OSINT?'],
    ['id' => 'task3', 'title' => 'LinkedIn and Employee Profiling'],
    ['id' => 'task4', 'title' => 'GitHub and Code Exposure'],
    ['id' => 'task5', 'title' => 'Job Postings as Intelligence'],
    ['id' => 'task6', 'title' => 'Breach Databases and Leaked Credentials'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'osint_people_orgs_progress',
    'instagram_takeaways'  => [
        '✓ OSINT gathers exposed intelligence without touching the target',
        '✓ LinkedIn profiles reveal org structure and phishing pretexts',
        '✓ GitHub history keeps secrets alive even after they are removed',
        '✓ Job postings and breach data expose infrastructure and reused passwords',
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
        ['id' => 'q1', 'text' => 'What does the acronym OSINT stand for?'],
        ['id' => 'q2', 'text' => 'What term describes reconnaissance that gathers information without directly interacting with the target?'],
        ['id' => 'q3', 'text' => 'What term describes reconnaissance that directly engages the target and carries a higher risk of detection?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What professional networking platform is most commonly used to map an organisation\'s employees?'],
        ['id' => 'q5', 'text' => 'What social engineering technique relies on a fabricated scenario to gain trust or information?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What term describes credentials or keys accidentally committed into source code?'],
        ['id' => 'q7', 'text' => 'What term describes using GitHub\'s search syntax to find sensitive exposed data across repositories?'],
        ['id' => 'q8', 'text' => 'Deleting a secret in a new commit removes it from the latest code but not from what?'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What do job postings often unintentionally reveal about a company\'s IT environment?'],
        ['id' => 'q10', 'text' => 'What internal detail might a job posting reveal that helps an attacker craft a convincing phishing pretext?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'What attack technique uses leaked username and password pairs to try logging into other services?'],
        ['id' => 'q12', 'text' => 'What poor security habit increases the risk of credential stuffing across multiple accounts?'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Enter the flag you discovered in the GitHub Leak Trail.'],
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
    <p>Every employee who posts a job update, pushes code, or reuses a password is unintentionally handing an attacker a piece of a puzzle. Open source intelligence, or OSINT, is the practice of collecting these public fragments and assembling them into a detailed picture of a person or an organisation, all without ever touching their systems.</p>

    <p>By the end of this room, you will be able to identify how LinkedIn profiles, GitHub repositories, job postings, and breach databases each leak a different piece of organisational intelligence, and how attackers combine them into a single profile before an attack even begins. A hands-on investigation is included to put these skills into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what open source intelligence is and how it differs from active reconnaissance.</li>
        <li>Identify how LinkedIn profiles expose organisational structure and employee details.</li>
        <li>Recognise how GitHub repositories and commit history leak sensitive secrets.</li>
        <li>Extract infrastructure and tooling clues from job postings.</li>
        <li>Understand the risk of leaked credentials and password reuse in breach databases.</li>
    </ul>
</div>
HTML;

// TASK 2: What is OSINT?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Intelligence From Public Sources</h2>

    <p><strong>OSINT</strong> stands for Open Source Intelligence. It refers to any information collected from publicly available sources such as social media, code repositories, job boards, and even data that has previously leaked in a breach.</p>

    <p>Reconnaissance generally falls into two categories. Passive reconnaissance gathers information without any direct interaction with the target, so there is nothing for the target to detect. Active reconnaissance involves direct engagement, such as scanning a network or calling a company help desk, which carries a real risk of being noticed.</p>

    <p>Almost all OSINT work is passive. An attacker can read a public GitHub repository or a LinkedIn profile without the target ever knowing it happened.</p>

    <h3>Passive vs Active Reconnaissance</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>Target Awareness</th>
                <th>Example</th>
                <th>Risk of Detection</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Passive Reconnaissance</td>
                <td>No interaction with target</td>
                <td>Reading a public LinkedIn profile</td>
                <td>Very low</td>
            </tr>
            <tr>
                <td>Active Reconnaissance</td>
                <td>Direct interaction with target</td>
                <td>Port scanning a company network</td>
                <td>High</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Four OSINT sources converging into one target profile
         Teaching purpose: show the learner that separate public sources combine into a
         single composite exposure picture, which they would otherwise treat as four
         unrelated, low-risk data points. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Four OSINT sources converging into a target profile">
            <!-- Source boxes -->
            <rect x="0"   y="20" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="200" y="20" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="400" y="20" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="600" y="20" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Target profile box -->
            <rect x="300" y="150" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <!-- Converging lines -->
            <line x1="80"  y1="80" x2="365" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="280" y1="80" x2="375" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="480" y1="80" x2="405" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="680" y1="80" x2="415" y2="148" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <!-- Labels -->
            <text x="80"  y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">LinkedIn</text>
            <text x="280" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">GitHub</text>
            <text x="480" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Job Postings</text>
            <text x="680" y="55" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Breach Data</text>
            <text x="380" y="185" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Target Profile</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: LinkedIn and Employee Profiling
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Mapping an Organisation Through Its Employees</h2>

    <p>LinkedIn is often the first stop for an attacker profiling a company. Job titles reveal the org chart, skills sections reveal the technology in use, and public posts reveal who recently joined, changed roles, or is under pressure during a company transition.</p>

    <p>None of this requires hacking anything. It is simply reading what people have chosen to publish about their own work.</p>

    <h3>What a Profile Reveals</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Data Point</th>
                <th>What It Tells an Attacker</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Job title and department</td>
                <td>Where the person sits in the org chart and what systems they likely access</td>
            </tr>
            <tr>
                <td>Listed skills and endorsements</td>
                <td>Which technologies and vendors the company relies on</td>
            </tr>
            <tr>
                <td>Recent activity or new role</td>
                <td>A good time to impersonate IT or HR, since new employees expect unfamiliar contacts</td>
            </tr>
            <tr>
                <td>Connections and colleagues</td>
                <td>Who to impersonate to make a phishing message feel credible</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Real-World Pattern</h4>
        <p>An attacker notices a profile change to "IT Support Specialist" at a target company. Days later, employees receive a password reset email that appears to come from that same person. The pretext only works because the title was public.</p>
    </div>
</div>
HTML;

// TASK 4: GitHub and Code Exposure
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>What Code Repositories Give Away</h2>

    <p>Developers sometimes commit sensitive values directly into their code, things like API keys, database passwords, or internal hostnames. These are called <strong>hardcoded secrets</strong>, and once pushed to a public repository, they are exposed to anyone who looks.</p>

    <p>Attackers also use <strong>GitHub dorking</strong>, which means using GitHub's own search syntax to hunt for exposed secrets across many repositories at once, rather than searching one repository at a time.</p>

    <p>The most overlooked risk is commit history. Deleting a secret in a new commit only removes it from the current version of the file. The secret still exists in every earlier commit, and anyone can view that history.</p>

    <!-- SVG: A secret added in commit 2, then "removed" in commit 3
         Teaching purpose: show the learner that deleting a secret from the latest code
         does not remove it from history, which they would otherwise assume means the
         secret is gone entirely. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 170" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Secret persisting across commit history">
            <!-- Commit boxes -->
            <rect x="20"  y="20" width="200" height="80" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="280" y="20" width="200" height="80" rx="8" fill="var(--surface)" stroke="var(--warning, #ffd36a)" stroke-width="2"/>
            <rect x="540" y="20" width="200" height="80" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows between commits -->
            <line x1="220" y1="60" x2="275" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="480" y1="60" x2="535" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="120" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Commit 1</text>
            <text x="120" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Initial commit</text>
            <text x="380" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Commit 2</text>
            <text x="380" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">API key added</text>
            <text x="640" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Commit 3</text>
            <text x="640" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Key removed from file</text>
            <!-- Note pointing back to commit 2 -->
            <line x1="640" y1="100" x2="380" y2="115" stroke="var(--text-secondary)" stroke-width="1" stroke-dasharray="4,4"/>
            <text x="380" y="140" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Still readable in commit 2 history</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> The Fix Is Rotation, Not Deletion</h4>
        <p>Once a secret is exposed, deleting it from the code is not enough. The value must be rotated, meaning a new key is issued and the old one is revoked. Automated secret scanning tools help catch these leaks before they reach a public repository.</p>
    </div>
</div>
HTML;

// TASK 5: Job Postings as Intelligence
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>What a Job Listing Really Says</h2>

    <p>Job postings are written to attract qualified candidates, which means they often describe the exact tools, cloud providers, and internal systems a company uses. A phrase like "experience with our internal deployment pipeline on AWS" tells an attacker precisely where to focus.</p>

    <p>Postings can also reveal team size, seniority gaps, and internal tool names, all of which help an attacker choose the right pretext and the right target.</p>

    <h3>Reading Between the Lines</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Job Posting Excerpt</th>
                <th>What It Reveals</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>"Experience with our internal VPN gateway on AWS us-east-1"</td>
                <td>Cloud provider, region, and remote access technology in use</td>
            </tr>
            <tr>
                <td>"Familiarity with Okta and our custom ticketing tool, Helpdesk-X"</td>
                <td>Identity provider and the name of an internal, otherwise unknown tool</td>
            </tr>
            <tr>
                <td>"Join our growing 3-person DevOps team"</td>
                <td>Small team size, likely limited security monitoring capacity</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 6: Breach Databases and Leaked Credentials
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>When Old Leaks Become New Attacks</h2>

    <p>When a website is breached, the leaked usernames and passwords often end up in public or underground breach databases. Attackers take those pairs and try them against other services in an attack called <strong>credential stuffing</strong>, betting that people reuse the same password everywhere.</p>

    <p>This works because <strong>password reuse</strong> is extremely common. A password leaked from an unrelated personal account can end up granting access to a corporate email or VPN if the employee used it in both places.</p>

    <p>Security researchers and defenders use legitimate breach-lookup services to check whether an organisation's email addresses appear in known breaches, so they can force a reset before an attacker gets there first.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Stay on the Legal Side</h4>
        <p>Only use lawful, reputable breach-lookup services for this kind of check. Purchasing or trading stolen credentials on underground markets is illegal, regardless of the intent behind it.</p>
    </div>
</div>
HTML;

// PRACTICAL TASK
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Vantix Corp has flagged a public GitHub repository belonging to one of its DevOps engineers. Someone on the security team suspects a sensitive value was pushed to the repository at some point and needs it confirmed before the account is locked down.</p>

    <p>Investigate the repository's file tree and commit history, cross-reference the committer's identity against their public profile, and check whether their email appears in any known breach. Compile your findings to close the case.</p>

    <div class="practical-launch-wrapper">
        <a href="osint-people-orgs-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch GitHub Leak Trail</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// CONCLUSION TASK
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have now seen how four ordinary, public sources combine into a real security risk. LinkedIn reveals who works where and what they do, GitHub exposes secrets that never truly disappear from history, job postings describe the infrastructure behind the scenes, and breach data shows where reused passwords create an open door.</p>

    <p>None of these sources require any technical exploit to access. That is exactly what makes OSINT so effective, and why organisations must think carefully about what they publish.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>OSINT is intelligence gathered from public sources without directly interacting with the target.</li>
        <li>Passive reconnaissance carries far less risk of detection than active reconnaissance.</li>
        <li>LinkedIn profiles expose org structure and provide material for convincing pretexts.</li>
        <li>Secrets committed to GitHub remain recoverable in commit history even after deletion.</li>
        <li>Job postings often reveal internal tooling and infrastructure details unintentionally.</li>
        <li>Password reuse turns an old, unrelated breach into a path for credential stuffing.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
