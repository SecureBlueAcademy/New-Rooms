<?php
// ============================================================
// detection-engineering-lifecycle.php
// Room: Detection Engineering Lifecycle (SE-DET-M01-R01)
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'detection-engineering-lifecycle',
    'title'           => 'Detection Engineering Lifecycle',
    'description'     => 'Take one detection from requirement to production: write a spec, test it against true positive and near miss cases, run it in shadow mode, tune it narrowly and version every change.',
    'icon'            => 'fas fa-flask-vial',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '35 minutes',
    'prerequisites'   => ['Security Engineering Principles'],
    'learning_objectives' => [
        'Sequence the detection lifecycle stages from requirement to production and state what each stage produces',
        'Write a detection spec that ties one threat behaviour to a data source, test cases and success criteria',
        'Validate detection logic against true positive and near miss test cases, and re-run them after every change',
        'Version and document a tuning change in a changelog before promoting the detection to production',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/detection-engineering-lifecycle-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'The Detection Lifecycle and the Requirement'],
    ['id' => 'task3', 'title' => 'Writing the Detection Spec'],
    ['id' => 'task4', 'title' => 'Building and Testing Against Test Cases'],
    ['id' => 'task5', 'title' => 'Deploy, Tune and Version'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'detection_engineering_lifecycle_progress',
    'instagram_takeaways'  => [
        '✓ Six lifecycle stages: requirement, spec, build, test, deploy, tune',
        '✓ Test first with true positive and near miss cases, then regression after every change',
        '✓ Shadow mode on live telemetry before production alerting',
        '✓ Narrow exclusions, MAJOR.MINOR.PATCH versions and a changelog for every change',
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
        ['id' => 'q1', 'text' => 'Which stage of the lifecycle comes immediately after Deploy? (one word, the stage name as shown in the lifecycle diagram)'],
        ['id' => 'q2', 'text' => 'What type of value, such as a single file hash or IP address, should a requirement avoid relying on by itself? (one word)'],
        ['id' => 'q3', 'text' => 'Which ATT&CK technique ID covers transferring tools or files from an external system into an environment? (format T followed by four digits)'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'Which Sysmon event ID records process creation? (answer in digits)'],
        ['id' => 'q5', 'text' => 'Which Sysmon process creation field still identifies a binary after it has been renamed on disk? (field name exactly as Sysmon writes it)'],
        ['id' => 'q6', 'text' => 'Which spec field states the measurable conditions a detection must meet before it can be promoted? (two words)'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What is a benign test case called when it shares the binary, a switch or a keyword with the target behaviour? (two words)'],
        ['id' => 'q8', 'text' => 'Which operator should a condition use when the value can appear anywhere inside the command line? (one word)'],
        ['id' => 'q9', 'text' => 'What is re-running the whole test suite after every rule change called? (two words)'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'Which deployment mode runs a rule on live telemetry and records its matches without sending alerts to analysts? (two words)'],
        ['id' => 'q11', 'text' => 'In this room\'s versioning scheme, which part of the version number rises when only the description or references change? (one word)'],
        ['id' => 'q12', 'text' => 'Which record lists every change to a detection with its date, version and reason? (one word)'],
    ],
    'task6' => [
        ['id' => 'q13', 'text' => 'Which parent process launched every false positive that version 1.0.0 raised during the shadow week? (file name with extension)'],
        ['id' => 'q14', 'text' => 'Enter the flag shown after the proof and the lifecycle record are accepted.'],
    ],
    'task7' => [
        ['id' => 'q15', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<style>.task-body code, .task-body pre, .task-body pre code { color: #ffffff; }</style>
<style>.task-body pre { white-space: pre-wrap; word-break: break-word; overflow-x: auto; background: rgba(0,0,0,0.35); border: 1px solid var(--border); border-radius: 8px; padding: 14px 16px; margin: 15px 0; font-size: 0.85rem; line-height: 1.55; } .task-body pre code { background: none; padding: 0; } .dl-scroll { overflow-x: auto; margin: 20px 0; } .dl-scroll .content-table { margin: 0; } .dl-figure { margin: 22px 0; }</style>
<div class="content-block">
    <p>Purple team exercise <strong>PT-2026-09</strong> ended with an uncomfortable finding. On two exercise hosts the red team downloaded its tools with the built-in Windows certificate utility, <code>certutil.exe</code>: once under its own name and once as a renamed copy. Nothing alerted. Finding F-03 became requirement <strong>REQ-0412</strong>, and you are the detection engineer who must turn it into a production detection, <strong>DET-0217</strong>, across the 11 hosts of <code>cbx.lab</code> (7 workstations and 4 servers).</p>

    <p>The quick fix is to type a search for "certutil" straight into the production alert queue. That rule will either miss the renamed copy or flood analysts with alerts from every legitimate certutil job. Detection engineering treats a detection like a small piece of software: it starts from a written requirement, is specified before it is built, is tested against known cases, runs quietly on live data before it alerts anyone, and every later change gets a version and a written reason.</p>

    <p>This room teaches that lifecycle for one detection: requirement, spec, build, test, deploy and tune. The practical, the Detection Spec Workbench, lets you write the spec and test cases for DET-0217, build its logic, test it, run it for a simulated shadow week, tune it and promote it.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Out of scope, and where to find it</h4>
        <p>Sigma rule syntax is taught in <strong>Writing Effective Sigma Rules</strong>. Generating fresh telemetry with Atomic tests is taught in <strong>Atomic Red Team for Detection Validation</strong>. Correlation rules and the outcome definitions (true positive, false positive, false negative, true negative) are taught in <strong>SIEM Engineering &amp; Detection Rule Writing</strong>. This room uses those outcome terms without redefining them.</p>
    </div>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Sequence the detection lifecycle stages from requirement to production and state what each stage produces.</li>
        <li>Write a detection spec that ties one threat behaviour to a data source, test cases and success criteria.</li>
        <li>Validate detection logic against true positive and near miss test cases, and re-run them after every change.</li>
        <li>Version and document a tuning change in a changelog before promoting the detection to production.</li>
    </ul>
</div>
HTML;

// TASK 2: The Detection Lifecycle and the Requirement
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Six Stages, Each With an Output</h2>
    <p>Every detection moves through the same six stages. Each stage produces something you can point at, and the next stage works from that output. The lifecycle always starts with the requirement: nothing is specified or built until someone has written down what must be detected and why.</p>

    <!-- SVG purpose: teaches the six lifecycle stages in order (Requirement, Spec, Build, Test, Deploy, Tune), the output each stage produces, and that Tune follows Deploy and loops back to Test for every change. -->
    <div class="dl-figure">
    <svg viewBox="0 0 880 250" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Detection lifecycle: Requirement, Spec, Build, Test, Deploy, Tune, with Tune looping back to Test">
        <defs>
            <marker id="dlArrow" markerWidth="10" markerHeight="10" refX="8" refY="4" orient="auto">
                <path d="M0,0 L0,8 L9,4 z" fill="#8b7bff"/>
            </marker>
        </defs>
        <text x="660" y="26" text-anchor="middle" font-size="13" fill="#b8c2cc">changes from shadow or production results loop back to Test</text>
        <path d="M 805 92 C 805 40, 512 40, 512 88" fill="none" stroke="#8b7bff" stroke-width="2" stroke-dasharray="6 4" marker-end="url(#dlArrow)"/>
        <rect x="10" y="95" width="118" height="54" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="158" y="95" width="118" height="54" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="306" y="95" width="118" height="54" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="454" y="95" width="118" height="54" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="602" y="95" width="118" height="54" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="750" y="95" width="118" height="54" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <line x1="128" y1="122" x2="152" y2="122" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow)"/>
        <line x1="276" y1="122" x2="300" y2="122" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow)"/>
        <line x1="424" y1="122" x2="448" y2="122" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow)"/>
        <line x1="572" y1="122" x2="596" y2="122" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow)"/>
        <line x1="720" y1="122" x2="744" y2="122" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow)"/>
        <text x="69" y="127" text-anchor="middle" font-size="15" font-weight="600" fill="#ffffff">1 Requirement</text>
        <text x="217" y="127" text-anchor="middle" font-size="15" font-weight="600" fill="#ffffff">2 Spec</text>
        <text x="365" y="127" text-anchor="middle" font-size="15" font-weight="600" fill="#ffffff">3 Build</text>
        <text x="513" y="127" text-anchor="middle" font-size="15" font-weight="600" fill="#ffffff">4 Test</text>
        <text x="661" y="127" text-anchor="middle" font-size="15" font-weight="600" fill="#ffffff">5 Deploy</text>
        <text x="809" y="127" text-anchor="middle" font-size="15" font-weight="600" fill="#ffffff">6 Tune</text>
        <text x="69" y="178" text-anchor="middle" font-size="12" fill="#b8c2cc">written need:</text>
        <text x="69" y="194" text-anchor="middle" font-size="12" fill="#b8c2cc">behaviour, scope, why</text>
        <text x="217" y="178" text-anchor="middle" font-size="12" fill="#b8c2cc">detection spec</text>
        <text x="217" y="194" text-anchor="middle" font-size="12" fill="#b8c2cc">document</text>
        <text x="365" y="178" text-anchor="middle" font-size="12" fill="#b8c2cc">the rule logic</text>
        <text x="513" y="178" text-anchor="middle" font-size="12" fill="#b8c2cc">test cases run,</text>
        <text x="513" y="194" text-anchor="middle" font-size="12" fill="#b8c2cc">results recorded</text>
        <text x="661" y="178" text-anchor="middle" font-size="12" fill="#b8c2cc">shadow mode first,</text>
        <text x="661" y="194" text-anchor="middle" font-size="12" fill="#b8c2cc">then production</text>
        <text x="809" y="178" text-anchor="middle" font-size="12" fill="#b8c2cc">changes from shadow</text>
        <text x="809" y="194" text-anchor="middle" font-size="12" fill="#b8c2cc">or production results</text>
        <text x="440" y="232" text-anchor="middle" font-size="12" fill="#7c83b6">Output of each stage shown under its box</text>
    </svg>
    </div>

    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Stage</th><th>What it produces</th></tr></thead>
        <tbody>
            <tr><td><strong>Requirement</strong></td><td>A written need: the behaviour to detect, the scope (which hosts) and why it matters.</td></tr>
            <tr><td><strong>Spec</strong></td><td>The detection spec document that every later stage works from (Task 3).</td></tr>
            <tr><td><strong>Build</strong></td><td>The rule logic itself.</td></tr>
            <tr><td><strong>Test</strong></td><td>Test cases run against the logic, with the results recorded.</td></tr>
            <tr><td><strong>Deploy</strong></td><td>The rule running on live telemetry: shadow mode first, then production alerting.</td></tr>
            <tr><td><strong>Tune</strong></td><td>Changes based on shadow or production results. Every change loops back to Test.</td></tr>
        </tbody>
    </table>
    </div>
    <p>The stage after Deploy is Tune, and tuning never ends the loop: a tuned rule goes back through Test before it is trusted again. When a detection no longer serves any requirement it is retired; that governance step is covered in Use Case Development Lifecycle.</p>

    <h3>Where requirements come from</h3>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Source</th><th>Example</th></tr></thead>
        <tbody>
            <tr><td>Threat intelligence report</td><td>A report describes a group abusing a built-in tool to fetch its second stage.</td></tr>
            <tr><td>Incident lessons learned</td><td>A post-incident review notes that the first malicious step was seen in logs but never alerted.</td></tr>
            <tr><td>Purple team finding</td><td>PT-2026-09 finding F-03: certutil downloads on exercise hosts raised no alert. This is where REQ-0412 comes from.</td></tr>
            <tr><td>Hunt result</td><td>A threat hunt finds a technique in historical data that no rule covers.</td></tr>
        </tbody>
    </table>
    </div>

    <h3>Describe a behaviour, not an indicator</h3>
    <p>A good requirement describes what the adversary <em>does</em>. An <strong>indicator</strong> is a single value such as an IP address or a file hash. Indicators are useful for blocking and for searching history, but a requirement that relies on one by itself breaks as soon as the adversary moves to new infrastructure.</p>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Written as</th><th>Example</th><th>Durability</th></tr></thead>
        <tbody>
            <tr><td><strong>Behaviour</strong></td><td>certutil downloading a file from a web address</td><td>Survives new infrastructure: the next campaign still has to run the tool the same way.</td></tr>
            <tr><td><strong>Indicator</strong></td><td>IP address <code>203.0.113.58</code></td><td>Changes with each campaign.</td></tr>
            <tr><td><strong>Indicator</strong></td><td>File hash of <code>sv.bin</code></td><td>Changes with each campaign, or with one changed byte.</td></tr>
        </tbody>
    </table>
    </div>

    <h3>Map the behaviour to one ATT&amp;CK technique</h3>
    <p>Tag the requirement with the MITRE ATT&amp;CK technique it covers so others can see what the detection is for. certutil appears in several techniques, so pick the one that matches the behaviour, not just the binary.</p>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Technique</th><th>Name</th><th>certutil example</th><th>In REQ-0412?</th></tr></thead>
        <tbody>
            <tr><td><strong>T1105</strong></td><td>Ingress Tool Transfer: transferring tools or files from an external system into an environment</td><td><code>certutil -urlcache -split -f &lt;URL&gt; &lt;file&gt;</code> (certutil is a listed procedure)</td><td>Yes, this is the behaviour</td></tr>
            <tr><td>T1140</td><td>Deobfuscate/Decode Files or Information</td><td><code>certutil -decode &lt;in&gt; &lt;out&gt;</code></td><td>No</td></tr>
            <tr><td>T1553.004</td><td>Subvert Trust Controls: Install Root Certificate</td><td><code>certutil -addstore -f Root &lt;cert&gt;</code></td><td>No</td></tr>
        </tbody>
    </table>
    </div>
    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> REQ-0412 in one line</h4>
        <p>Detect certutil (under any file name, including from a scheduled task) downloading a file from a web address, on all 11 Windows hosts. Certificate checks, hash checks, cache maintenance and other download tools are outside this requirement.</p>
    </div>
</div>
HTML;

// TASK 3: Writing the Detection Spec
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>The Spec Is the Contract</h2>
    <p>The detection spec is the contract every later stage works from. The builder reads it to know what to match, the tester reads it to know what must and must not fire, the analyst reads it to know what to do with an alert. The field list below follows the idea of the Alerting and Detection Strategy (ADS) framework: write down the goal, the technical context, the blind spots, the known false positives, how it is validated and how to respond, before the rule goes live.</p>

    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Spec field</th><th>What it holds (DET-0217 example)</th></tr></thead>
        <tbody>
            <tr><td><strong>Detection ID</strong></td><td>DET-0217</td></tr>
            <tr><td><strong>Title</strong></td><td>A short name, for example "certutil web download"</td></tr>
            <tr><td><strong>Version</strong></td><td>0.1.0 while in draft (versioning is in Task 5)</td></tr>
            <tr><td><strong>Status</strong></td><td>draft, shadow, production or retired</td></tr>
            <tr><td><strong>Owner</strong></td><td>The team that maintains it: Detection Engineering</td></tr>
            <tr><td><strong>Behaviour and ATT&amp;CK technique</strong></td><td>certutil downloading a file from a web address, T1105</td></tr>
            <tr><td><strong>Data source and required fields</strong></td><td>The log and the fields the logic needs (below)</td></tr>
            <tr><td><strong>Logic summary</strong></td><td>The logic in plain language, so a reviewer can check it without reading rule syntax</td></tr>
            <tr><td><strong>Known benign activity</strong></td><td>Legitimate jobs that look similar, filled in as you learn them</td></tr>
            <tr><td><strong>Test cases</strong></td><td>One row per test event: ID, event, expected result (Alert or No alert)</td></tr>
            <tr><td><strong>Success criteria</strong></td><td>The measurable conditions the detection must meet before it can be promoted</td></tr>
            <tr><td><strong>Response notes</strong></td><td>What an analyst does when it fires</td></tr>
            <tr><td><strong>Changelog</strong></td><td>Every change with its date, version and reason (Task 5)</td></tr>
        </tbody>
    </table>
    </div>

    <h3>Choosing the data source</h3>
    <p>A process creation behaviour needs a process creation log. Two Windows sources record it, and they do not record the same fields. Sysmon, the System Monitor service, writes process creation as <strong>Event ID 1</strong> in its own channel. Windows Security auditing writes event <strong>4688</strong>.</p>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th></th><th>Sysmon Event ID 1 (Process creation)</th><th>Security event 4688</th></tr></thead>
        <tbody>
            <tr><td><strong>Binary path</strong></td><td><code>Image</code></td><td><code>NewProcessName</code></td></tr>
            <tr><td><strong>Parent</strong></td><td><code>ParentImage</code> (and parent command line)</td><td><code>ParentProcessName</code>, only on Windows 10 and Server 2016 and later</td></tr>
            <tr><td><strong>Command line</strong></td><td><code>CommandLine</code>, always recorded</td><td><code>CommandLine</code> only when the policy "Include command line in process creation events" is enabled</td></tr>
            <tr><td><strong>Original file name</strong></td><td><code>OriginalFileName</code></td><td>No such field</td></tr>
            <tr><td><strong>Also records</strong></td><td><code>User</code>, <code>IntegrityLevel</code>, hashes, process GUIDs and more</td><td>Subject account, token elevation</td></tr>
        </tbody>
    </table>
    </div>
    <p>Other Sysmon events do not record process creation: Event ID 3 is a network connection and Event ID 11 is a file create. For DET-0217 the spec names Sysmon Event ID 1 and the required fields <code>Image</code>, <code>OriginalFileName</code>, <code>CommandLine</code>, <code>ParentImage</code>, <code>User</code> and <code>IntegrityLevel</code>.</p>

    <h3>Why OriginalFileName matters</h3>
    <p><code>OriginalFileName</code> is read from the version information embedded inside the PE file itself. Copying a binary to another name changes the path on disk, so <code>Image</code> shows the new path, but the version information travels with the file, so <code>OriginalFileName</code> still reads <code>CertUtil.exe</code>.</p>

    <!-- SVG purpose: teaches that renaming a copy of certutil changes the Image field but not OriginalFileName, because OriginalFileName comes from the PE version information inside the binary. -->
    <div class="dl-figure">
    <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="A renamed copy of certutil keeps OriginalFileName CertUtil.exe while Image shows the new path">
        <defs>
            <marker id="dlArrow2" markerWidth="10" markerHeight="10" refX="8" refY="4" orient="auto">
                <path d="M0,0 L0,8 L9,4 z" fill="#8b7bff"/>
            </marker>
        </defs>
        <rect x="10" y="20" width="320" height="160" rx="10" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="430" y="20" width="320" height="160" rx="10" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <line x1="334" y1="100" x2="424" y2="100" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow2)"/>
        <text x="379" y="88" text-anchor="middle" font-size="12" fill="#b8c2cc">copy and</text>
        <text x="379" y="124" text-anchor="middle" font-size="12" fill="#b8c2cc">rename</text>
        <text x="170" y="48" text-anchor="middle" font-size="14" font-weight="600" fill="#ffffff">Original binary</text>
        <text x="28" y="84" font-size="12" fill="#b8c2cc">Image</text>
        <text x="28" y="104" font-size="12" fill="#ffffff">C:\Windows\System32\certutil.exe</text>
        <text x="28" y="136" font-size="12" fill="#b8c2cc">OriginalFileName</text>
        <text x="28" y="156" font-size="12" fill="#ffffff">CertUtil.exe</text>
        <text x="590" y="48" text-anchor="middle" font-size="14" font-weight="600" fill="#ffffff">Renamed copy</text>
        <text x="448" y="84" font-size="12" fill="#b8c2cc">Image (path on disk: changes)</text>
        <text x="448" y="104" font-size="12" fill="#ffffff">C:\Users\Public\notes.exe</text>
        <text x="448" y="136" font-size="12" fill="#b8c2cc">OriginalFileName (version info: stays)</text>
        <text x="448" y="156" font-size="12" fill="#ffffff">CertUtil.exe</text>
    </svg>
    </div>

    <h3>Success criteria for DET-0217</h3>
    <p>Test cases describe single events. The <strong>success criteria</strong> field describes the whole detection: the measurable conditions it must meet before it can be promoted. They are checked at promotion time, not on each test run.</p>
    <ol>
        <li>Every test case marked Alert fires.</li>
        <li>No test case marked No alert fires.</li>
        <li>Every shadow mode alert is reviewed and no unexplained false positive remains.</li>
        <li>The full test suite passes again after every change.</li>
    </ol>
</div>
HTML;

// TASK 4: Building and Testing Against Test Cases
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Test First</h2>
    <p>Test cases and their expected results are written in the spec <strong>before any logic is built</strong>. That way the tests describe the requirement, not the rule. If you build first and then pick tests, you tend to pick events the rule already handles, and the suite proves nothing. The order is: write the spec with its test cases, then build the logic, then run the suite.</p>

    <h3>Three kinds of test case</h3>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Type</th><th>What it is</th><th>certutil examples</th><th>Expected</th></tr></thead>
        <tbody>
            <tr><td><strong>True positive sample</strong></td><td>One per known variant of the behaviour</td><td>Plain name; a renamed copy; slash switch syntax such as <code>/urlcache</code>; a process running as SYSTEM from a scheduled task</td><td>Alert</td></tr>
            <tr><td><strong>Near miss</strong></td><td>A benign event that shares the binary, a switch or a keyword with the behaviour</td><td><code>certutil -urlcache * delete</code> clearing the URL cache; <code>certutil -verify -urlfetch</code> checking a certificate chain; <code>findstr</code> searching a log export for the word urlcache</td><td>No alert</td></tr>
            <tr><td><strong>Out-of-scope case</strong></td><td>Related activity that a different requirement covers</td><td>Another download tool such as <code>curl.exe</code>; <code>certutil -decode</code> (T1140)</td><td>No alert</td></tr>
        </tbody>
    </table>
    </div>
    <p>True positive samples can come from an emulation exercise such as a purple team run; generating them on demand with Atomic tests is the subject of Atomic Red Team for Detection Validation. A test passes when the <strong>actual result equals the expected result</strong>: a case marked No alert passes when the rule stays silent, and a case marked Alert passes only when the rule fires.</p>

    <h3>Rule logic: field, operator, value</h3>
    <p>This room uses a generic rule builder rather than any query language. Turning this logic into Sigma is the next room, Writing Effective Sigma Rules.</p>
    <ul>
        <li>A <strong>condition</strong> is a field, an operator and a value, for example <code>OriginalFileName equals CertUtil.exe</code>.</li>
        <li><strong>All conditions must match</strong> for the rule to fire.</li>
        <li>Matching is <strong>case-insensitive</strong>, so <code>certutil.exe</code> and <code>CertUtil.exe</code> are the same value.</li>
    </ul>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Operator</th><th>Matches when the value</th><th>Typical use</th></tr></thead>
        <tbody>
            <tr><td><strong>equals</strong></td><td>is the whole field</td><td><code>OriginalFileName equals CertUtil.exe</code></td></tr>
            <tr><td><strong>contains</strong></td><td>appears anywhere inside the field</td><td>a switch word somewhere inside a long <code>CommandLine</code></td></tr>
            <tr><td><strong>starts with</strong></td><td>is at the start of the field</td><td>a folder prefix of <code>Image</code></td></tr>
            <tr><td><strong>ends with</strong></td><td>is at the end of the field</td><td><code>ParentImage ends with \explorer.exe</code></td></tr>
        </tbody>
    </table>
    </div>

    <h3>Make the logic robust</h3>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Fragile</th><th>Robust</th><th>Why</th></tr></thead>
        <tbody>
            <tr><td><code>Image ends with \certutil.exe</code></td><td><code>OriginalFileName equals CertUtil.exe</code></td><td>A renamed copy changes <code>Image</code> but not <code>OriginalFileName</code>.</td></tr>
            <tr><td><code>CommandLine contains -urlcache</code></td><td><code>CommandLine contains urlcache</code></td><td>certutil accepts both <code>-</code> and <code>/</code> option prefixes, so <code>/urlcache</code> works too. Match the switch word, not one prefix.</td></tr>
        </tbody>
    </table>
    </div>
    <p>Check every robust condition against your near miss cases too: a condition that is broad enough to catch every variant may also catch a near miss, and then you need one more condition that separates them.</p>

    <h3>A test case entry in the spec</h3>
<pre><code>Test case   TC-xx
Event       Sysmon Event ID 1 on &lt;host&gt;.cbx.lab
            OriginalFileName CertUtil.exe
            CommandLine      certutil -urlcache * delete
Type        near miss (same binary and switch word, no download)
Expected    No alert
Result      (recorded at each run)</code></pre>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Never change a test to make the suite pass</h4>
        <p>If a test case fails, fix the logic. Never edit or delete a test case just so the suite passes: the deleted case was a variant of the behaviour, and the suite would no longer cover it.</p>
    </div>

    <h3>Regression testing</h3>
    <p><strong>Regression testing</strong> means re-running the whole test suite after every rule change, including every tuning change, not only the test case the change was meant for. A new exclusion can silently suppress a true positive sample; only a full re-run shows it. Regression testing uses the recorded test events; shadow mode review (Task 5) uses live telemetry.</p>
</div>
HTML;

// TASK 5: Deploy, Tune and Version
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Deploy in Two Steps</h2>
    <p>Nothing deploys until every test case passes. Deployment then happens in two steps:</p>
    <ol>
        <li><strong>Shadow mode</strong>: the rule runs on live telemetry and records its matches for the engineer to review, but sends nothing to the analyst queue. It runs for a fixed window; for DET-0217 the window is 7 days.</li>
        <li><strong>Production alerting</strong>: after review, tuning and a passing regression run, the rule is promoted and its alerts go to the analyst queue.</li>
    </ol>
    <p>Reviewing shadow results means classifying each match using the outcome terms from SIEM Engineering &amp; Detection Rule Writing. Live telemetry always contains activity that the test capture did not, so expect matches you have to explain.</p>

    <h3>Tune with the narrowest exclusion</h3>
    <p>Tuning works from the shadow results. When matches are explained false positives, add the narrowest exclusion that removes them. An exclusion is a block of conditions; an event that matches every condition of one exclusion block is suppressed. Use at least two fields together, for example the parent process and the URL host, so that only the explained activity is removed.</p>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Exclusion</th><th>Verdict</th><th>Why</th></tr></thead>
        <tbody>
            <tr><td><code>ParentImage ends with \backupagent.exe</code> AND <code>CommandLine contains srv08.cbx.lab/share/</code></td><td>Narrow</td><td>Two fields: only that agent fetching from that internal host is removed.</td></tr>
            <tr><td><code>User equals NT AUTHORITY\SYSTEM</code></td><td>Too broad</td><td>Removes a whole account class. True positives can run as SYSTEM too, for example a scheduled task.</td></tr>
            <tr><td><code>Computer equals &lt;host&gt;.cbx.lab</code></td><td>Too broad</td><td>Removes a whole host. The next true positive may come from that same host.</td></tr>
        </tbody>
    </table>
    </div>
    <p>After any tuning change, re-run the full test suite (regression testing) before anything else is promoted.</p>

    <h3>Versioning: MAJOR.MINOR.PATCH for detections</h3>
    <p>This room adapts Semantic Versioning to detections. The meaning of each part below is this room's convention:</p>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Part</th><th>Raise it when</th><th>Example</th></tr></thead>
        <tbody>
            <tr><td><strong>MAJOR</strong></td><td>The behaviour or the data source changes</td><td>Moving from Security 4688 to Sysmon Event ID 1: 1.4.2 becomes 2.0.0</td></tr>
            <tr><td><strong>MINOR</strong></td><td>The logic changes but the behaviour stays the same: a new condition or a new exclusion</td><td>Adding an exclusion: 2.3.1 becomes 2.4.0</td></tr>
            <tr><td><strong>PATCH</strong></td><td>Only metadata changes (description, references, typos); the logic does not</td><td>Fixing a typo in the description: 2.4.0 becomes 2.4.1</td></tr>
        </tbody>
    </table>
    </div>
    <ul>
        <li>Drafts use <code>0.x</code> versions, for example 0.1.0.</li>
        <li>The first deployed version is <code>1.0.0</code>.</li>
        <li>Raising one part resets the parts to its right to 0.</li>
        <li>Promotion changes the <strong>Status</strong> field (shadow to production), not the version.</li>
    </ul>

    <h3>The changelog</h3>
    <p>The <strong>changelog</strong> is the record that lists every change to a detection. Each entry has these fields:</p>
<pre><code>Date      2026-06-03
Version   2.4.0
Author    Detection Engineering
Change    MINOR: exclude backup agent fetches from srv08.cbx.lab/share/
Reason    4 shadow false positives from the backup agent
Test      full suite re-run on 2.4.0: passed</code></pre>

    <h3>The order from requirement to production</h3>
    <!-- SVG purpose: teaches the graded promotion order: requirement, spec with tests, build, suite passes, shadow deploy 1.0.0, exclusion and version with changelog (either order), regression run, promote. -->
    <div class="dl-figure">
    <svg viewBox="0 0 800 250" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Eight step promotion flow from requirement to production">
        <defs>
            <marker id="dlArrow3" markerWidth="10" markerHeight="10" refX="8" refY="4" orient="auto">
                <path d="M0,0 L0,8 L9,4 z" fill="#8b7bff"/>
            </marker>
        </defs>
        <rect x="10" y="20" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="213" y="20" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="416" y="20" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="619" y="20" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="10" y="160" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="213" y="160" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#8b7bff" stroke-width="1.6" stroke-dasharray="6 4"/>
        <rect x="416" y="160" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#6ae3ff" stroke-width="1.6"/>
        <rect x="619" y="160" width="170" height="70" rx="9" fill="#1a1f2e" stroke="#3dff9a" stroke-width="1.6"/>
        <line x1="180" y1="55" x2="207" y2="55" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <line x1="383" y1="55" x2="410" y2="55" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <line x1="586" y1="55" x2="613" y2="55" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <path d="M 704 90 L 704 125 L 95 125 L 95 154" fill="none" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <line x1="180" y1="195" x2="207" y2="195" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <line x1="383" y1="195" x2="410" y2="195" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <line x1="586" y1="195" x2="613" y2="195" stroke="#8b7bff" stroke-width="2" marker-end="url(#dlArrow3)"/>
        <text x="95" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">1 Record the</text>
        <text x="95" y="68" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">requirement</text>
        <text x="298" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">2 Spec with test</text>
        <text x="298" y="68" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">cases and expected</text>
        <text x="501" y="59" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">3 Build the logic</text>
        <text x="704" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">4 Run the suite until</text>
        <text x="704" y="68" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">every case passes</text>
        <text x="95" y="190" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">5 Deploy 1.0.0</text>
        <text x="95" y="208" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">in shadow mode</text>
        <text x="298" y="182" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">6 Narrow exclusion</text>
        <text x="298" y="200" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">+ version, changelog</text>
        <text x="298" y="218" text-anchor="middle" font-size="11" fill="#b8c2cc">(either order)</text>
        <text x="501" y="190" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">7 Re-run the full</text>
        <text x="501" y="208" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">suite (regression)</text>
        <text x="704" y="190" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">8 Promote with owner</text>
        <text x="704" y="208" text-anchor="middle" font-size="13" font-weight="600" fill="#ffffff">and response notes</text>
    </svg>
    </div>
    <ol>
        <li>Record the requirement: behaviour, scope and ATT&amp;CK technique.</li>
        <li>Write the spec with test cases and expected results.</li>
        <li>Build the logic.</li>
        <li>Run the test suite until every case passes.</li>
        <li>Deploy version 1.0.0 in shadow mode.</li>
        <li>Add the narrow exclusion for the explained shadow false positives, and raise the version with a changelog entry. These two may happen in either order.</li>
        <li>Re-run the full test suite on the new version.</li>
        <li>Promote to production with owner and response notes, only after that regression run passes.</li>
    </ol>

    <div class="warning-box">
        <h4><i class="fas fa-ban"></i> Never do</h4>
        <ul>
            <li>Deploy straight to production alerting: analysts would get alerts from a rule that has never run on live telemetry.</li>
            <li>Delete a failing test case so the suite passes.</li>
            <li>Exclude all SYSTEM activity (or a whole host) to remove false positives.</li>
            <li>Edit a live rule without a new version and changelog entry: there is no record and nothing to roll back to.</li>
            <li>Write the logic first and then pick test cases it already passes.</li>
        </ul>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>The Detection Spec Workbench holds requirement REQ-0412 and the draft spec for DET-0217 (version 0.1.0). You set the expected result for each of the 10 events in the test capture from PT-2026-09, choose the data source, build the rule from conditions, and run the suite. When the suite passes you deploy to shadow mode, and the workbench replays a recorded shadow week of Sysmon process creation events from the production hosts.</p>

    <p>Review what the rule matched during the shadow week, tune it narrowly, record the change in the changelog, re-run the suite and promote. Then build the lifecycle record in the right order and submit three proof values. The flag appears only when the proof, the lifecycle record and the rule itself are all right; anything else shows "Not yet.".</p>

    <div class="practical-launch-wrapper">
        <a href="detection-engineering-lifecycle-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Detection Spec Workbench</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You took DET-0217 from a purple team finding to a production detection. A requirement described the behaviour, not an indicator. The spec fixed the data source, the test cases and the success criteria before any logic existed. The logic was proven against true positive and near miss cases, ran quietly in shadow mode, was tuned with a narrow exclusion, versioned, re-tested and only then promoted.</p>

    <h3>Recap</h3>
    <ul>
        <li><strong>Six stages:</strong> Requirement (written need), Spec (the contract), Build (logic), Test (recorded results), Deploy (shadow, then production), Tune (changes that loop back to Test).</li>
        <li><strong>Spec fields:</strong> ID, title, version, status, owner, behaviour and technique, data source, logic summary, known benign activity, test cases, success criteria, response notes, changelog.</li>
        <li><strong>Test first:</strong> true positive samples for each variant and near miss cases that share the binary, a switch or a keyword; regression testing after every change.</li>
        <li><strong>Shadow mode before production;</strong> narrow exclusions with two or more fields; MAJOR.MINOR.PATCH and a changelog entry for every change.</li>
    </ul>

    <h3>Reusable detection spec template</h3>
    <div class="dl-scroll">
    <table class="content-table">
        <thead><tr><th>Field</th><th>Value</th></tr></thead>
        <tbody>
            <tr><td>Detection ID</td><td></td></tr>
            <tr><td>Title</td><td></td></tr>
            <tr><td>Version</td><td></td></tr>
            <tr><td>Status (draft, shadow, production, retired)</td><td></td></tr>
            <tr><td>Owner</td><td></td></tr>
            <tr><td>Behaviour and ATT&amp;CK technique</td><td></td></tr>
            <tr><td>Data source and required fields</td><td></td></tr>
            <tr><td>Logic summary</td><td></td></tr>
            <tr><td>Known benign activity</td><td></td></tr>
            <tr><td>Test cases (ID, event, expected result)</td><td></td></tr>
            <tr><td>Success criteria</td><td></td></tr>
            <tr><td>Response notes</td><td></td></tr>
            <tr><td>Changelog</td><td></td></tr>
        </tbody>
    </table>
    </div>

    <h3>Promotion checklist</h3>
    <ul>
        <li>The full test suite passes on the current version.</li>
        <li>Every shadow mode match has been reviewed and explained.</li>
        <li>Every exclusion uses two or more fields.</li>
        <li>The version has been raised and the changelog entry written.</li>
        <li>Owner and response notes are set.</li>
    </ul>

    <div class="success-box">
        <h4><i class="fas fa-route"></i> Next rooms</h4>
        <p>Writing Effective Sigma Rules turns logic like DET-0217 into portable Sigma rules. Atomic Red Team for Detection Validation then shows how to generate new true positive samples on demand.</p>
    </div>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Start from a written requirement that describes a behaviour, mapped to one ATT&amp;CK technique.</li>
        <li>Write test cases and expected results in the spec before building any logic.</li>
        <li>Run shadow mode on live telemetry before any analyst sees an alert.</li>
        <li>Tune narrowly, raise the version, write the changelog and re-run the full suite before promotion.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
