<?php
// security-audit-compliance-automation.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'security-audit-compliance-automation',
    'title'           => 'Security Audit & Compliance Automation',
    'description'     => 'Learn how policy-as-code and continuous monitoring automate compliance evidence collection and audit readiness.',
    'icon'            => 'fas fa-clipboard-check',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic cloud computing concepts', 'Basic understanding of IAM and resource configuration'],
    'learning_objectives' => [
        'Explain what policy-as-code is and why it replaces manual policy checks',
        'Describe how continuous control monitoring works',
        'Interpret a CIS benchmark compliance score',
        'Explain how automated audit evidence reduces audit burden',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/security-audit-compliance-automation-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Policy-as-Code?'],
    ['id' => 'task3', 'title' => 'Continuous Monitoring and CIS Benchmarks'],
    ['id' => 'task4', 'title' => 'Building Compliance Dashboards'],
    ['id' => 'task5', 'title' => 'Automating Audit Evidence'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'security_audit_compliance_automation_progress',
    'instagram_takeaways'  => [
        '✓ Policy-as-code turns compliance rules into automated checks',
        '✓ Continuous monitoring catches drift in real time',
        '✓ CIS benchmark scores summarize control compliance',
        '✓ Automated evidence collection reduces audit burden',
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
        ['id' => 'q1', 'text' => 'What term describes writing compliance rules as executable code? (three words)'],
        ['id' => 'q2', 'text' => 'What language does Open Policy Agent use to write rules?'],
        ['id' => 'q3', 'text' => 'What AWS service defines compliance rules for AWS resource configurations? (two words)'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What term describes monitoring compliance in real time rather than periodically? (two words)'],
        ['id' => 'q5', 'text' => 'What does the acronym CIS stand for?'],
        ['id' => 'q6', 'text' => 'What is the numeric summary of how many controls passed called? (two words)'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What term describes a single view showing compliance status across resources? (two words)'],
        ['id' => 'q8', 'text' => 'What should a failing control on a dashboard link to? (two words)'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What do we call automatically generated documentation proving compliance? (two words)'],
        ['id' => 'q10', 'text' => 'What property makes audit evidence trustworthy to auditors? (two words)'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'Enter the flag revealed in the CloudGuard Compliance Console.'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Manual compliance audits are slow, expensive, and outdated the moment they finish. An auditor checks a system once, signs off, and by the following week a configuration has already drifted out of policy. As organizations scale across cloud accounts and hundreds of resources, checking everything by hand becomes impossible to sustain.</p>

    <p>By the end of this room, you will be able to explain policy-as-code, understand how continuous control monitoring works, read a CIS benchmark compliance score, and describe how automated audit evidence collection works. A hands-on practical is included to put these ideas into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what policy-as-code is and why it replaces manual policy checks.</li>
        <li>Describe how continuous control monitoring works.</li>
        <li>Interpret a CIS benchmark compliance score.</li>
        <li>Explain how automated audit evidence reduces audit burden.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Policy-as-Code?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Turning Rules Into Code</h2>

    <p>Policy as code means writing compliance and security rules as executable code instead of as a written policy document that a human interprets manually. A rule engine evaluates every resource configuration against these rules automatically, every time something changes.</p>

    <p>Think of it like a spell checker that runs continuously in the background as you type, instead of a proofreader who only reviews your document once a month. The spell checker catches mistakes the moment they happen. Policy as code does the same for infrastructure.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Because policy-as-code rules are just code, they can be version-controlled, reviewed, and tested in the same way application code is. A change to a compliance rule goes through the same review process as any other code change.</p>
    </div>

    <p>For example, a simple rule might state that every S3 bucket must have encryption enabled. When a new bucket is created without encryption, the policy engine immediately evaluates the configuration and flags it as a violation, without waiting for a human to notice.</p>

    <h3>Common Policy-as-Code Tools</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Tool</th>
                <th>Ecosystem</th>
                <th>Rule Language</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Open Policy Agent (OPA)</td>
                <td>Cloud native, Kubernetes, general purpose</td>
                <td>Rego</td>
            </tr>
            <tr>
                <td>AWS Config Rules</td>
                <td>AWS</td>
                <td>Managed rules or Lambda-backed custom rules</td>
            </tr>
            <tr>
                <td>Azure Policy</td>
                <td>Azure</td>
                <td>JSON policy definitions</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Policy-as-code evaluation pipeline
         Teaching purpose: show the learner that policy-as-code is an automated evaluation pipeline,
         which they would otherwise misunderstand as a manual checklist. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 120" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Policy as code evaluation pipeline">
            <!-- Background boxes -->
            <rect x="10"  y="20" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="290" y="20" width="200" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="570" y="20" width="180" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="210" y1="60" x2="285" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="490" y1="60" x2="565" y2="60" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="110" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Resource Config</text>
            <text x="110" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">e.g. S3 bucket settings</text>
            <text x="390" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Policy Engine</text>
            <text x="390" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Evaluates rules automatically</text>
            <text x="660" y="52" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Pass or Fail</text>
            <text x="660" y="72" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Result recorded instantly</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Continuous Monitoring and CIS Benchmarks
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Watching Continuously, Not Once a Year</h2>

    <p>Traditional audits are point in time. An auditor checks a system on a given date and issues a report that describes the state of things on that day only. Continuous control monitoring instead re-evaluates every control constantly, catching problems the moment they appear rather than months later.</p>

    <p>This is the difference between a smoke detector and a fire inspector. A fire inspector visits once a year and checks that the building meets code that day. A smoke detector runs constantly and alerts the moment something goes wrong, regardless of when the last inspection happened.</p>

    <!-- SVG: Point in time audit versus continuous monitoring timeline
         Teaching purpose: show the learner the difference in monitoring frequency,
         which they would otherwise misunderstand as functionally equivalent. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Point in time audit versus continuous monitoring">
            <!-- Point in time audit row -->
            <text x="10" y="25" font-size="13" font-weight="600" fill="var(--text-primary)">Point in Time Audit</text>
            <line x1="10" y1="45" x2="750" y2="45" stroke="var(--border)" stroke-width="2"/>
            <circle cx="400" cy="45" r="7" fill="var(--primary)"/>
            <text x="400" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Single check, once a year</text>

            <!-- Continuous monitoring row -->
            <text x="10" y="105" font-size="13" font-weight="600" fill="var(--text-primary)">Continuous Monitoring</text>
            <line x1="10" y1="125" x2="750" y2="125" stroke="var(--border)" stroke-width="2"/>
            <circle cx="100" cy="125" r="6" fill="var(--success)"/>
            <circle cx="230" cy="125" r="6" fill="var(--success)"/>
            <circle cx="360" cy="125" r="6" fill="var(--success)"/>
            <circle cx="490" cy="125" r="6" fill="var(--success)"/>
            <circle cx="620" cy="125" r="6" fill="var(--success)"/>
            <circle cx="720" cy="125" r="6" fill="var(--success)"/>
            <text x="400" y="147" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Repeated checks, ongoing</text>
        </svg>
    </div>

    <p>CIS benchmarks are a widely used set of numbered security controls, organized into sections covering areas like identity, storage, and networking. Automated scoring evaluates every resource against each applicable control and aggregates the results into an overall compliance score, usually shown as a percentage of controls passed.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Watch Out</h4>
        <p>A high CIS compliance score does not mean an environment has zero risk. It only means the controls that were checked are passing. Risks outside the benchmark's scope are not reflected in the score.</p>
    </div>
</div>
HTML;

// TASK 4: Building Compliance Dashboards
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Seeing Compliance at a Glance</h2>

    <p>A compliance dashboard aggregates the results of every control check across every monitored resource into a single view. Instead of reading through hundreds of individual check results, a security team can see the overall picture in seconds.</p>

    <p>This works the same way as a car's dashboard. You do not need to inspect the engine yourself to know something is wrong. A warning light tells you at a glance, and you investigate further only when needed.</p>

    <h3>Example Dashboard Row</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Resource</th>
                <th>Control</th>
                <th>Status</th>
                <th>Last Checked</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>prod-customer-data</td>
                <td>CIS 2.1.1 - No public S3 read access</td>
                <td>Fail</td>
                <td>2 minutes ago</td>
            </tr>
            <tr>
                <td>db-server-02</td>
                <td>CIS 4.3 - Security group restricts SSH</td>
                <td>Pass</td>
                <td>2 minutes ago</td>
            </tr>
        </tbody>
    </table>

    <p>A row like this tells you immediately which resource is failing, which control it violates, and how current the information is. A dashboard that only shows a red or green icon without this context forces the team to go digging elsewhere for the details.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>A well designed dashboard links each failing control directly to remediation steps, so the team can act immediately instead of just knowing something is wrong.</p>
    </div>
</div>
HTML;

// TASK 5: Automating Audit Evidence
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Proving Compliance Without the Screenshots</h2>

    <p>Audit evidence is the documentation that proves a control was actually enforced, not just described in a policy. Historically, this meant a team member manually taking screenshots or writing down configuration values before an audit. That process is slow and easy to get wrong.</p>

    <p>Automated evidence collection instead generates timestamped logs and configuration snapshots continuously, as controls are checked. This is the difference between a security camera that records everything as it happens and someone jotting down notes from memory after the fact.</p>

    <p>For example, an automated evidence report entry might read: timestamp 2026-03-14 09:12 UTC, control CIS 2.1.1, result pass. That single line proves the control was checked and what the outcome was, without anyone needing to remember or recreate it later.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>For evidence to be trusted by auditors, it must be tamper evident, often through hashing or immutable storage. If evidence could be edited after the fact, it would no longer prove anything.</p>
    </div>

    <p>This is what makes continuous compliance monitoring so valuable for audits. Instead of scrambling to gather proof right before an audit, the evidence already exists, generated automatically the moment each check ran.</p>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You are stepping into the role of a compliance analyst using the CloudGuard Compliance Console. Continuous monitoring has flagged a violation of CIS Benchmark Control 2.1.1, which requires that no S3 bucket allow public read access.</p>

    <p>Review the monitored resources, find the one that violates this control, and confirm its remediation to close out the finding.</p>

    <div class="practical-launch-wrapper">
        <a href="security-audit-compliance-automation-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch CloudGuard Compliance Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how organizations move away from slow, manual audits toward continuous, automated compliance. Policy as code turns rules into executable checks, continuous monitoring catches drift as it happens, CIS benchmark scores summarize control coverage, dashboards make findings visible at a glance, and automated evidence collection removes the scramble that used to come before every audit.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Policy as code turns compliance rules into automated, version-controlled checks.</li>
        <li>Continuous monitoring catches drift in real time instead of waiting for annual audits.</li>
        <li>CIS benchmark scores summarize control compliance but do not guarantee zero risk.</li>
        <li>Compliance dashboards prioritize what needs attention at a glance.</li>
        <li>Automated evidence collection reduces manual audit burden and improves trust.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA - engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
