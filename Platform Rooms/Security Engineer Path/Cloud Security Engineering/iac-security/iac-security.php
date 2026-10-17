<?php
// ============================================================
// iac-security.php — ROOM DATA FILE
// Topic: Infrastructure as Code Security
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'iac-security',
    'title'           => 'Infrastructure as Code Security',
    'description'     => 'Learn how to secure Terraform and CloudFormation pipelines with scanning, policy as code, drift detection, and automated guardrails.',
    'icon'            => 'fas fa-shield-halved',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '50 minutes',
    'prerequisites'   => ['Basic Terraform or CloudFormation knowledge', 'Basic cloud infrastructure concepts', 'Familiarity with CI/CD pipelines'],
    'learning_objectives' => [
        'Explain why security scanning of IaC should happen before deployment',
        'Describe how policy as code enforces custom organizational rules with tools like OPA',
        'Identify configuration drift and explain why it is dangerous',
        'Design guardrails that block non-compliant infrastructure automatically',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/iac-security-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Scanning IaC for Misconfigurations'],
    ['id' => 'task3', 'title' => 'Policy as Code with OPA'],
    ['id' => 'task4', 'title' => 'Detecting Configuration Drift'],
    ['id' => 'task5', 'title' => 'Guardrails and Pipeline Enforcement'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'iac_security_progress',
    'instagram_takeaways'  => [
        '✓ Shift left: scan Terraform and CloudFormation before deployment',
        '✓ Policy as code with Open Policy Agent and Rego',
        '✓ Configuration drift and why live infrastructure can silently diverge',
        '✓ Guardrails that block non-compliant infrastructure automatically',
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
        ['id' => 'q1', 'text' => 'What term describes catching security issues early in the development pipeline, before deployment?'],
        ['id' => 'q2', 'text' => 'What type of analysis examines Terraform code without executing it?'],
        ['id' => 'q3', 'text' => 'What is the general term for tools like Checkov and tfsec that scan IaC for security issues?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the name of the open source policy engine used for policy as code?'],
        ['id' => 'q5', 'text' => 'What language does OPA use to write policies?'],
        ['id' => 'q6', 'text' => 'What term describes writing security and compliance rules as code rather than relying on manual review?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What term describes live infrastructure no longer matching its IaC definition?'],
        ['id' => 'q8', 'text' => 'What Terraform command is commonly used to detect drift by comparing state to real infrastructure?'],
        ['id' => 'q9', 'text' => 'What is the term for changes made directly in the cloud console rather than through IaC?'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'What term describes automated, non-bypassable controls that block non-compliant deployments?'],
        ['id' => 'q11', 'text' => 'What is the term for a required automated check that must pass before code can be merged or deployed?'],
    ],
    'task6' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the Pipeline Security Gate.'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every cloud breach that starts with a misconfiguration begins the same way: a resource gets defined with too much access, too little encryption, or too open a network path, and nobody catches it until it is already running in production. Infrastructure as Code turns servers, networks, and permissions into version controlled files, which means those same mistakes can be caught and fixed before a single resource is ever created.</p>

    <p>By the end of this room, you will be able to scan Terraform and CloudFormation for security issues, enforce custom rules with policy as code, detect when live infrastructure has drifted from what was declared, and build guardrails that block bad deployments automatically instead of relying on someone remembering to check. A hands on practical is included to put these ideas into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why security scanning of IaC should happen before deployment.</li>
        <li>Describe how policy as code enforces custom organizational rules with tools like OPA.</li>
        <li>Identify configuration drift and explain why it is dangerous.</li>
        <li>Design guardrails that block non-compliant infrastructure automatically.</li>
        <li>Understand how scanning, policy, drift detection, and guardrails work together as one strategy.</li>
    </ul>
</div>
HTML;

// TASK 2: Scanning IaC for Misconfigurations
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Catching Mistakes Before They Deploy</h2>

    <p>Terraform and CloudFormation files describe infrastructure the same way source code describes an application. That means they can carry the same kinds of mistakes: an open port, a missing encryption setting, a database exposed to the internet. The difference is that a mistake in IaC does not stay theoretical. Running it builds the thing it describes.</p>

    <p>Static analysis tools read this code without ever running it, checking each resource block against a library of known security rules. This is the same idea as a spellchecker for infrastructure. It flags the mistake while you are still writing, long before it becomes a live, exploitable resource.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why Shift Left Matters</h4>
        <p>A misconfiguration caught in a pull request costs a few minutes to fix. The same misconfiguration caught after deployment can mean an incident response, a forensic review, and possibly a real breach. Shifting security earlier in the pipeline is not a convenience, it changes the cost of a mistake by orders of magnitude.</p>
    </div>

    <h3>Common Scanning Tools</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Tool</th>
                <th>Language Coverage</th>
                <th>Output Format</th>
                <th>Typical Use</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Checkov</strong></td>
                <td>Terraform, CloudFormation, Kubernetes, Dockerfiles</td>
                <td>CLI, JSON, SARIF</td>
                <td>Broad multi framework scanning in CI</td>
            </tr>
            <tr>
                <td><strong>tfsec</strong></td>
                <td>Terraform only</td>
                <td>CLI, JSON, SARIF</td>
                <td>Fast, Terraform focused local and CI scanning</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Scan position in pipeline
         Teaching purpose: show the learner that scanning happens before terraform apply,
         which they would otherwise misunderstand as a post deploy audit step. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Scanning positioned before deployment">
            <!-- Pipeline stages -->
            <rect x="10"  y="30" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="220" y="30" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--accent)" stroke-width="2"/>
            <rect x="430" y="30" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="600" y="30" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="160" y1="65" x2="215" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="370" y1="65" x2="425" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="580" y1="65" x2="595" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="85"  y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Write IaC</text>
            <text x="85"  y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Terraform code</text>
            <text x="295" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Scan</text>
            <text x="295" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Checkov, tfsec</text>
            <text x="505" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Plan</text>
            <text x="505" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">terraform plan</text>
            <text x="675" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Apply</text>
            <text x="675" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">terraform apply</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Policy as Code with OPA
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Enforcing Your Own Rules, Not Just Vendor Rules</h2>

    <p>Scanning tools like Checkov and tfsec check IaC against a fixed set of well known security rules. That covers common mistakes well, but every organization also has its own rules that no generic scanner knows about, such as which regions are approved or which resource tags are mandatory.</p>

    <p>Policy as code closes that gap. The Open Policy Agent, usually shortened to OPA, is a general purpose policy engine that evaluates any structured input, including a Terraform plan, against rules written in a language called Rego. Instead of a report of findings, OPA returns a decision: allow or deny.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> A Simple Policy Example</h4>
        <p>A Rego policy might say that any storage resource must have encryption enabled, or that no security group may allow inbound traffic from every address on the internet. When a Terraform plan is evaluated against that policy, OPA returns deny if the rule is violated, blocking the deployment before it happens.</p>
    </div>

    <h3>Scanning vs Policy as Code</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>IaC Scanning</th>
                <th>Policy as Code</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rule source</td>
                <td>Fixed, vendor maintained ruleset</td>
                <td>Custom rules written by your organization</td>
            </tr>
            <tr>
                <td>Flexibility</td>
                <td>Limited to what the tool supports</td>
                <td>Fully customizable to internal requirements</td>
            </tr>
            <tr>
                <td>Enforcement point</td>
                <td>Usually a CI report of findings</td>
                <td>An allow or deny decision at the gate</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Policy engine as a gate decision
         Teaching purpose: show policy enforcement as a binary allow/deny decision,
         which learners otherwise confuse with a scanning report of findings. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Policy engine gate decision">
            <rect x="20"  y="35" width="160" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="300" y="20" width="180" height="100" rx="10" fill="var(--surface)" stroke="var(--accent)" stroke-width="2"/>
            <rect x="600" y="15" width="150" height="45" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <rect x="600" y="80" width="150" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="180" y1="70" x2="295" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="480" y1="50" x2="595" y2="38" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="480" y1="90" x2="595" y2="102" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="100" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Terraform Plan</text>
            <text x="100" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Proposed changes</text>
            <text x="390" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">OPA Policy Engine</text>
            <text x="390" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Evaluates against Rego rules</text>
            <text x="675" y="43" text-anchor="middle" font-size="12" font-weight="600" fill="var(--success)">Allow</text>
            <text x="675" y="107" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Deny</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Detecting Configuration Drift
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>When Reality Stops Matching the Code</h2>

    <p>Infrastructure as Code assumes that the code is always the single source of truth. In practice, someone occasionally makes a manual change directly in the cloud console: opening a port for a quick test, or changing an instance type during an incident. When that happens, the live infrastructure no longer matches what the code declares, and the environment has drifted.</p>

    <p>Drift is dangerous because it is invisible by default. The change did not go through code review, was not scanned, and was not evaluated by any policy engine. It simply exists, quietly, until something breaks or an audit finds it.</p>

    <h3>Common Causes of Drift</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Cause</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Manual console edits</td>
                <td>An engineer opens a port directly in the AWS console to debug an issue</td>
            </tr>
            <tr>
                <td>Emergency hotfixes</td>
                <td>A change is applied by hand during an incident and never reflected back in code</td>
            </tr>
            <tr>
                <td>Expired temporary changes</td>
                <td>A temporary rule is added for testing and never removed</td>
            </tr>
            <tr>
                <td>Third party automation</td>
                <td>Another tool or script modifies a resource outside the IaC workflow</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Desired state vs actual state
         Teaching purpose: show drift as a measurable gap between two states,
         which learners otherwise misunderstand as simply "someone made a change." -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Desired state versus actual state showing drift">
            <rect x="20" y="20" width="320" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="420" y="20" width="320" height="100" rx="10" fill="var(--surface)" stroke="var(--warning, #ffd36a)" stroke-width="2"/>
            <text x="180" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Desired State</text>
            <text x="180" y="65" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Declared in Terraform code</text>
            <text x="180" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Security group: port 443 only</text>
            <text x="580" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Actual State</text>
            <text x="580" y="65" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Live in the cloud account</text>
            <text x="580" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Security group: port 443 and 22</text>
            <line x1="345" y1="70" x2="415" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4,4" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="380" y="140" text-anchor="middle" font-size="12" font-weight="600" fill="var(--warning, #ffd36a)">Drift detected</text>
        </svg>
    </div>
</div>
HTML;

// TASK 5: Guardrails and Pipeline Enforcement
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Making Enforcement Automatic</h2>

    <p>Scanning, policy as code, and drift detection are only useful if something actually acts on their results. If a scan produces a report that a human has to remember to read, a bad deployment can still slip through. Guardrails remove that dependency on memory by wiring these checks directly into the pipeline as mandatory gates.</p>

    <p>A guardrail blocks a non-compliant plan automatically, the same way a locked turnstile stops someone without a ticket. There is no step where a person has to notice the problem and choose to act. The pipeline simply will not proceed until the checks pass.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Guardrails vs Manual Gatekeeping</h4>
        <p>A gatekeeper who manually reviews every change does not scale, gets tired, and can be skipped under deadline pressure. A guardrail is a required, automated status check. Common implementations include pre-commit hooks, required CI checks that must pass before merge, and admission controls that reject non-compliant resources outright.</p>
    </div>

    <!-- SVG: Automatic gate blocking non-compliant plan
         Teaching purpose: show enforcement as automatic and mandatory,
         which learners otherwise misunderstand as an optional advisory step. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Guardrail automatically blocking non-compliant deployment">
            <rect x="20"  y="35" width="180" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="320" y="20" width="150" height="100" rx="10" fill="var(--surface)" stroke="var(--accent)" stroke-width="2"/>
            <rect x="600" y="35" width="150" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="5,4"/>
            <line x1="200" y1="70" x2="315" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr5)"/>
            <line x1="470" y1="70" x2="595" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="3,3" marker-end="url(#arr5)"/>
            <defs>
                <marker id="arr5" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="110" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Non-compliant Plan</text>
            <text x="110" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Open ingress rule</text>
            <text x="395" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Guardrail</text>
            <text x="395" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Required CI check</text>
            <text x="395" y="95" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Blocks automatically</text>
            <text x="675" y="65" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Production</text>
            <text x="675" y="83" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Never reached</text>
        </svg>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>A Terraform plan is sitting in the pipeline, ready to deploy, but the security gate has blocked it. Three findings from an automated scan need to be reviewed and remediated before the deployment can proceed.</p>

    <p>Open the Pipeline Security Gate, review each finding, and apply the fix for all three. Once every finding is resolved, the gate will unlock and reveal your flag.</p>

    <div class="practical-launch-wrapper">
        <a href="iac-security-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Pipeline Security Gate</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Securing Infrastructure as Code is not one tool or one step. Scanning catches known misconfiguration patterns before deployment, policy as code enforces the rules specific to your organization, drift detection catches changes that bypassed the process entirely, and guardrails make sure all of this is enforced automatically instead of depending on manual review.</p>

    <p>Together these four practices move security to the earliest and cheapest point in the pipeline, catching problems in code review instead of in an incident report.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Static analysis tools like Checkov and tfsec catch misconfigurations before Terraform ever applies them.</li>
        <li>Policy as code with OPA and Rego enforces custom organizational rules as an allow or deny decision.</li>
        <li>Configuration drift happens when live infrastructure diverges from the declared IaC state, often through manual changes.</li>
        <li>Guardrails turn scanning, policy, and drift checks into mandatory, automated gates rather than optional advice.</li>
        <li>Preventing misconfigurations at the source is more effective and far cheaper than fixing them after deployment.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
