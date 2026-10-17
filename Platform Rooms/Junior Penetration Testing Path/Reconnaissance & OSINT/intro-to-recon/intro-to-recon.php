<?php
// intro-to-recon.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'intro-to-recon',
    'title'           => 'Introduction to Reconnaissance',
    'description'     => 'Learn the difference between passive and active reconnaissance and how the intelligence cycle guides every engagement.',
    'icon'            => 'fas fa-binoculars',
    'banner'          => '../../assets/banner-recon.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '45 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic understanding of the internet'],
    'learning_objectives' => [
        'Define passive and active reconnaissance and explain how they differ',
        'Explain why security professionals start with passive techniques',
        'Describe the four stages of the intelligence cycle',
        'Apply the intelligence cycle to a realistic scenario',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/intro-to-recon-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Passive vs Active Reconnaissance'],
    ['id' => 'task3', 'title' => 'Why Professionals Start Passive'],
    ['id' => 'task4', 'title' => 'The Intelligence Cycle'],
    ['id' => 'task5', 'title' => 'Applying the Intelligence Cycle'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'intro_to_recon_progress',
    'instagram_takeaways'  => [
        '✓ Passive vs active reconnaissance',
        '✓ Why professionals start passive',
        '✓ The intelligence cycle: Plan, Collect, Process, Act',
        '✓ Applying the cycle to a real scenario',
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
        ['id' => 'q1', 'text' => 'What type of reconnaissance involves no direct contact with the target?'],
        ['id' => 'q2', 'text' => 'What type of reconnaissance involves direct interaction with the target?'],
        ['id' => 'q3', 'text' => 'Which reconnaissance type carries a higher risk of detection?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What must a tester have before conducting active reconnaissance?'],
        ['id' => 'q5', 'text' => 'What does starting with passive reconnaissance reduce the risk of?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What is the first stage of the intelligence cycle?'],
        ['id' => 'q7', 'text' => 'What stage of the intelligence cycle involves gathering data from sources?'],
        ['id' => 'q8', 'text' => 'What is the final stage of the intelligence cycle called?'],
    ],
    'task5' => [
        ['id' => 'q9', 'text' => 'Is the intelligence cycle a one-time process or a continuous process?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Enter the flag you discovered on the OSINT Recon Board.'],
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
    <p>Reconnaissance is the process of gathering information about a target before any other phase of an engagement begins. Every penetration test, red team exercise, and real-world attack starts here, because you cannot plan an approach against a system you do not yet understand.</p>

    <p>By the end of this room, you will be able to explain the difference between passive and active reconnaissance, describe why professionals begin with passive techniques, and walk through the four stages of the intelligence cycle. A hands-on exercise is included so you can practice gathering intelligence the way a real tester would.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Define passive and active reconnaissance and explain how they differ.</li>
        <li>Explain why security professionals start with passive techniques.</li>
        <li>Describe the four stages of the intelligence cycle.</li>
        <li>Apply the intelligence cycle to a realistic scenario.</li>
    </ul>
</div>
HTML;

// TASK 2: Passive vs Active Reconnaissance
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Ways to Learn About a Target</h2>
    <p>Before touching a single system, a tester needs to understand what they are working with. Reconnaissance is how that understanding is built, and it comes in two distinct forms: passive and active.</p>

    <p><strong>Passive reconnaissance</strong> gathers information without any direct contact with the target. Think of it as researching a company using only what is already public: its website, job postings, employee profiles, and domain records. The target never knows you are looking.</p>

    <p><strong>Active reconnaissance</strong> gathers information by interacting directly with the target's systems, such as sending network traffic to see what responds. This produces more precise data, but it also leaves a trace the target may notice.</p>

    <h3>Comparing the Two Approaches</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Definition</th>
                <th>Detection Risk</th>
                <th>Example Technique</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Passive</strong></td>
                <td>Gathering information without directly contacting the target.</td>
                <td>Very low</td>
                <td>Reading public job postings</td>
            </tr>
            <tr>
                <td><strong>Active</strong></td>
                <td>Gathering information by directly interacting with the target's systems.</td>
                <td>Higher</td>
                <td>Scanning open ports</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: passive vs active paths
         Teaching purpose: show the learner that passive and active are two
         distinct paths to the same target, one indirect and one direct,
         which they would otherwise misunderstand as interchangeable. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Passive versus active reconnaissance paths to a target">
            <!-- Tester box -->
            <rect x="20" y="80" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="115" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Tester</text>

            <!-- Target box -->
            <rect x="560" y="80" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="620" y="115" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Target</text>

            <!-- Passive path, curved and dashed, never touches target directly -->
            <path d="M140,90 C300,10 400,10 560,90" fill="none" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4,4" marker-end="url(#arrPassive)"/>
            <text x="350" y="35" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Passive: no direct contact</text>

            <!-- Active path, straight and solid, touches target directly -->
            <line x1="140" y1="130" x2="560" y2="130" stroke="var(--text-primary)" stroke-width="1.5" marker-end="url(#arrActive)"/>
            <text x="350" y="155" text-anchor="middle" font-size="12" fill="var(--text-primary)">Active: direct contact</text>

            <defs>
                <marker id="arrPassive" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arrActive" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-primary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Why Professionals Start Passive
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Look First, Touch Later</h2>
    <p>Imagine deciding whether to study a building you plan to visit. A careful person studies it from the street first: the entrances, the signage, the hours posted on the door. Only once they understand the layout would they consider walking up. Security testers work the same way.</p>

    <p>Passive reconnaissance builds a picture of the target with almost no risk. Nothing is sent to the target's systems, so there is nothing for the target to detect. Active reconnaissance changes that. The moment a tester sends traffic, runs a scan, or logs into a service, that action can appear in the target's logs.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Authorization Matters</h4>
        <p>Active reconnaissance must never be performed without explicit written authorization from the target. Passive reconnaissance carries far less legal and detection risk because it never touches the target directly.</p>
    </div>

    <p>Starting passive is not just a best practice. It is what allows a tester to plan an active phase intelligently instead of guessing.</p>
</div>
HTML;

// TASK 4: The Intelligence Cycle
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>A Repeating Process, Not a Checklist</h2>
    <p>Good reconnaissance does not happen in one pass. Professionals follow a repeating structure called the intelligence cycle, made up of four stages: Plan, Collect, Process, and Act.</p>

    <p>Each stage feeds directly into the next, and the final stage feeds back into the first. This is what separates disciplined reconnaissance from randomly searching the internet for anything interesting.</p>

    <h3>The Four Stages</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Stage</th>
                <th>Core Question</th>
                <th>What Happens</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Plan</strong></td>
                <td>What do we need to know?</td>
                <td>Define clear objectives before collecting anything.</td>
            </tr>
            <tr>
                <td><strong>Collect</strong></td>
                <td>Where do we gather it?</td>
                <td>Pull information from passive, and later authorized active, sources.</td>
            </tr>
            <tr>
                <td><strong>Process</strong></td>
                <td>What does it mean?</td>
                <td>Organize raw findings into categories and remove noise.</td>
            </tr>
            <tr>
                <td><strong>Act</strong></td>
                <td>What do we do next?</td>
                <td>Use the processed intelligence to plan the next phase of the engagement.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: intelligence cycle diagram
         Teaching purpose: show the learner that the four stages form a
         repeating loop, which they would otherwise misunderstand as a
         one-time linear checklist. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 420 430" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="The intelligence cycle repeating through four stages">
            <!-- Plan -->
            <rect x="150" y="10" width="120" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="210" y="43" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Plan</text>

            <!-- Collect -->
            <rect x="290" y="187" width="120" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="220" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Collect</text>

            <!-- Process -->
            <rect x="150" y="365" width="120" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="210" y="398" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Process</text>

            <!-- Act -->
            <rect x="10" y="187" width="120" height="55" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="70" y="220" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Act</text>

            <!-- Cyclical arrows -->
            <path d="M235,65 C300,95 320,140 345,182" fill="none" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrCycle)"/>
            <path d="M350,242 C335,285 300,325 265,362" fill="none" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrCycle)"/>
            <path d="M180,365 C120,335 90,295 72,245" fill="none" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrCycle)"/>
            <path d="M72,185 C95,140 125,95 185,65" fill="none" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrCycle)"/>

            <defs>
                <marker id="arrCycle" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 5: Applying the Intelligence Cycle
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Putting the Cycle to Work</h2>
    <p>Consider a tester assigned to assess a company called Meridian Logistics. Rather than searching randomly, they move through the intelligence cycle deliberately.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Scenario Walkthrough</h4>
        <p><strong>Plan:</strong> The tester decides what they need to know, such as the company's technology stack, key personnel, and any exposed infrastructure.</p>
        <p><strong>Collect:</strong> They check WHOIS records, public job postings, employee profiles, and DNS records, all without contacting Meridian's systems directly.</p>
        <p><strong>Process:</strong> They organize what they found into categories such as people, technology, and infrastructure.</p>
        <p><strong>Act:</strong> With a clear picture in hand, they decide what the next phase of the engagement should focus on, which starts the cycle again.</p>
    </div>

    <p>This is exactly the exercise you will complete next.</p>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You are about to research Meridian Logistics using only publicly available sources, the same way a professional tester would during the passive phase of an engagement.</p>

    <p>Open every source on the OSINT Recon Board, review what it reveals, and compile your findings into a recon summary. The flag will appear once your summary is complete.</p>

    <div class="practical-launch-wrapper">
        <a href="intro-to-recon-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch OSINT Recon Board</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Reconnaissance is where every security engagement begins. Knowing the difference between passive and active techniques, and understanding why passive comes first, keeps a tester's work deliberate and defensible. The intelligence cycle gives that work structure, turning scattered facts into a plan for what to do next.</p>

    <p>These are not abstract ideas. Every professional engagement, and every real attack, starts with someone quietly building a picture of the target before anything else happens.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Passive reconnaissance gathers information without contacting the target.</li>
        <li>Active reconnaissance requires direct contact and carries detection risk.</li>
        <li>Active reconnaissance always requires explicit authorization.</li>
        <li>The intelligence cycle has four stages: Plan, Collect, Process, Act.</li>
        <li>The cycle repeats, with each Act stage feeding the next Plan stage.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
