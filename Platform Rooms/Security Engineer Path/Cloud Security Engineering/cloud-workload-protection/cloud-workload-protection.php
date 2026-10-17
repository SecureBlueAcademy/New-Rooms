<?php
// cloud-workload-protection.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'cloud-workload-protection',
    'title'           => 'Cloud Workload Protection',
    'description'     => 'Learn how CWPP secures VMs, containers, and serverless functions, and how CSPM keeps multi-cloud posture consistent.',
    'icon'            => 'fas fa-cloud-arrow-down',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '55 minutes',
    'prerequisites'   => ['Basic cloud computing concepts', 'Basic understanding of VMs and containers'],
    'learning_objectives' => [
        'Explain the difference between CWPP and CSPM',
        'Describe runtime protection for VMs, containers, and serverless functions',
        'Explain how file integrity monitoring detects unauthorized change',
        'Describe how vulnerability assessment prioritizes cloud workload risk',
        'Explain just-in-time VM access and policy-as-code for multi-cloud posture',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/cloud-workload-protection-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Runtime Protection'],
    ['id' => 'task3', 'title' => 'File Integrity Monitoring'],
    ['id' => 'task4', 'title' => 'Vulnerability Assessment'],
    ['id' => 'task5', 'title' => 'Just-in-Time VM Access'],
    ['id' => 'task6', 'title' => 'CSPM and Policy-as-Code'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'cloud_workload_protection_progress',
    'instagram_takeaways'  => [
        '✓ Runtime protection secures VMs, containers, and serverless workloads',
        '✓ File integrity monitoring detects unauthorized change through hash comparison',
        '✓ Vulnerability assessment prioritizes by exposure and exploitability, not just severity',
        '✓ Just-in-time access and policy-as-code keep multi-cloud posture consistent',
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
        ['id' => 'q1', 'text' => 'What is the general term for security that monitors workload behavior during execution rather than before deployment?'],
        ['id' => 'q2', 'text' => 'What is the term for a security approach that inspects code before it runs, as opposed to runtime protection?'],
        ['id' => 'q3', 'text' => 'Which cloud workload type is most time-constrained for runtime protection due to short execution windows?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What monitoring technique detects unauthorized changes to files by comparing current and baseline hashes?'],
        ['id' => 'q5', 'text' => 'Does file integrity monitoring prevent or detect unauthorized file changes?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What score is commonly used to rate the severity of a vulnerability?'],
        ['id' => 'q7', 'text' => 'What term describes whether a workload is reachable from the internet, a key factor in vulnerability prioritization?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What acronym describes granting VM access only for a limited, time-bound window instead of standing access?'],
        ['id' => 'q9', 'text' => 'What type of access, if left standing and unused, is a common target for lateral movement?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'What acronym describes tooling that continuously assesses cloud configuration posture across multiple cloud providers?'],
        ['id' => 'q11', 'text' => 'What term describes defining security policies as code rather than manual checklists?'],
    ],
    'task7' => [
        ['id' => 'q12', 'text' => 'Enter the flag you discovered in the Cloud Workload Console.'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Cloud workloads, virtual machines, containers, and serverless functions have become the primary attack surface in modern infrastructure. Traditional endpoint security tools were built for fixed servers with long uptimes, not for workloads that spin up, scale, and disappear in seconds.</p>

    <p>By the end of this room, you will be able to explain the four core capabilities of a Cloud Workload Protection Platform (CWPP) and understand how continuous posture assessment works across a multi-cloud environment using policy-as-code. A hands-on investigation is included to reinforce the theory.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain the difference between CWPP and CSPM.</li>
        <li>Describe runtime protection for VMs, containers, and serverless functions.</li>
        <li>Explain how file integrity monitoring detects unauthorized change.</li>
        <li>Describe how vulnerability assessment prioritizes cloud workload risk.</li>
        <li>Explain just-in-time VM access and policy-as-code for multi-cloud posture.</li>
    </ul>
</div>
HTML;

// TASK 2: Runtime Protection
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Watching Workloads While They Run</h2>

    <p>Runtime protection monitors what a workload actually does while it is executing: which processes it starts, which files it touches, and which network connections it opens. This is different from scanning a workload before it is deployed, which only checks what it might do.</p>

    <p>Think of the difference like a building inspector versus a security guard. The inspector checks the blueprint before construction finishes. The guard watches who enters and leaves once the building is open. Cloud workloads need both, but runtime protection is the guard that catches an active threat in the moment.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Serverless functions often run for only a few seconds. Runtime protection for these functions has to work within that tiny execution window, which makes it fundamentally more time-constrained than protecting a VM that stays online for months.</p>
    </div>

    <h3>Runtime Protection Across Workload Types</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Workload Type</th>
                <th>Primary Runtime Risk</th>
                <th>Protection Mechanism</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Virtual Machine</strong></td>
                <td>Long-lived process compromise, unexpected outbound connections</td>
                <td>Agent-based behavioral monitoring</td>
            </tr>
            <tr>
                <td><strong>Container</strong></td>
                <td>Unexpected child process spawned inside the container</td>
                <td>Syscall and process tree monitoring</td>
            </tr>
            <tr>
                <td><strong>Serverless Function</strong></td>
                <td>Malicious code execution during a short invocation window</td>
                <td>In-line execution monitoring tied to the function runtime</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Runtime protection watch points across workload types
         Teaching purpose: show the learner that these three workload types share one
         protection concept applied differently, which they would otherwise misunderstand
         as three separate unrelated products. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Runtime protection across VM, container, and serverless workloads">
            <!-- Workload boxes -->
            <rect x="20"  y="30" width="200" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="280" y="30" width="200" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="540" y="30" width="200" height="90" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Watch point indicators -->
            <circle cx="120" cy="45" r="6" fill="var(--primary)"/>
            <circle cx="380" cy="45" r="6" fill="var(--primary)"/>
            <circle cx="640" cy="45" r="6" fill="var(--primary)"/>
            <!-- Labels -->
            <text x="120" y="70" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Virtual Machine</text>
            <text x="120" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Long-lived monitoring</text>
            <text x="380" y="70" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Container</text>
            <text x="380" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Process tree monitoring</text>
            <text x="640" y="70" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Serverless Function</text>
            <text x="640" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">In-line execution monitoring</text>
            <!-- Bottom shared label -->
            <text x="380" y="145" text-anchor="middle" font-size="12" font-style="italic" fill="var(--text-secondary)">Same concept: watch behavior while it runs</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: File Integrity Monitoring
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Catching Unauthorized Change</h2>

    <p>File integrity monitoring (FIM) works by taking a trusted baseline hash of a file, a configuration, a binary, or a system file, and comparing it against the file's current hash at regular intervals. If the hashes no longer match, the file changed without authorization.</p>

    <p>FIM is like a wax seal on a letter. The seal does not stop someone from opening the letter. It only proves, after the fact, that someone did. That distinction matters when you decide what FIM can and cannot do for you.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>File integrity monitoring detects unauthorized change. It does not prevent it. Prevention requires a separate control, such as strict write permissions or runtime blocking.</p>
    </div>

    <!-- SVG: Baseline hash vs current hash comparison
         Teaching purpose: show the learner that FIM works through comparison, not
         blocking, which they would otherwise confuse with an active prevention control. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 150" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="File integrity monitoring hash comparison flow">
            <rect x="20" y="40" width="200" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="120" y="70" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Baseline Hash</text>
            <text x="120" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">a1f9c3...e02b</text>

            <rect x="480" y="40" width="200" height="70" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="580" y="70" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Current Hash</text>
            <text x="580" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">7d42e1...ff09</text>

            <line x1="225" y1="75" x2="475" y2="75" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrf)"/>
            <defs>
                <marker id="arrf" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="350" y="60" text-anchor="middle" font-size="12" fill="var(--text-secondary)">compare</text>
            <text x="350" y="130" text-anchor="middle" font-size="12" fill="var(--text-primary)" font-weight="600">Mismatch = unauthorized change detected</text>
        </svg>
    </div>
</div>
HTML;

// TASK 4: Vulnerability Assessment
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Prioritizing Real Risk</h2>

    <p>Vulnerability assessment scans cloud workloads for known CVEs and assigns them a severity rating using CVSS. A high CVSS score tells you how dangerous a vulnerability could be in theory, but it does not tell you how dangerous it is for your specific environment.</p>

    <p>Two workloads can share the exact same CVE and the same CVSS score, yet carry very different real risk. Exposure, whether the workload is reachable from the internet or only internally, and whether a working exploit exists in the wild both change the priority.</p>

    <h3>Same Score, Different Risk</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Workload</th>
                <th>CVSS Score</th>
                <th>Exposure</th>
                <th>Exploit Available</th>
                <th>Real Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>vm-web-01</td>
                <td>8.1</td>
                <td>Internet-facing</td>
                <td>Yes</td>
                <td><strong>Critical, patch first</strong></td>
            </tr>
            <tr>
                <td>vm-db-02</td>
                <td>8.1</td>
                <td>Internal only</td>
                <td>No</td>
                <td>Lower, schedule normally</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>Prioritization is not "patch everything with a high score." It is "patch what is actually reachable and actually exploitable first." Treating every high CVSS score identically wastes limited remediation time.</p>
    </div>
</div>
HTML;

// TASK 5: Just-in-Time VM Access
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Access Only When It Is Needed</h2>

    <p>Just-in-time (JIT) VM access grants administrative access to a virtual machine only for a limited, approved window of time, instead of leaving that access open permanently. Once the window closes, the access is automatically revoked.</p>

    <p>Standing access works like a master key that never expires. JIT access works like a hotel keycard that only opens the door during your stay. If the keycard is lost or stolen, it stops working the moment checkout happens.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Watch Out</h4>
        <p>Standing privileged access that nobody actively uses is one of the most common targets for lateral movement. An attacker who compromises one account can quietly reuse access nobody remembered to remove.</p>
    </div>
</div>
HTML;

// TASK 6: CSPM and Policy-as-Code
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Continuous Posture Across Multi-Cloud</h2>

    <p>Cloud Security Posture Management (CSPM) continuously checks the configuration of cloud resources against a defined set of security rules, across every cloud provider in use. Where CWPP watches what a running workload does, CSPM watches whether the environment around it is configured correctly.</p>

    <p>Policy-as-code means those rules are written and version-controlled as code, rather than kept as a manual checklist someone follows by hand. This lets the same policy be applied automatically and consistently across accounts, regions, and cloud providers, and any drift from that policy is flagged as soon as it happens.</p>

    <!-- SVG: CWPP vs CSPM scope comparison
         Teaching purpose: show the learner that CWPP and CSPM are complementary but
         distinct layers, which they would otherwise conflate as the same tool. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 170" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="CWPP versus CSPM scope comparison">
            <rect x="30"  y="30" width="290" height="110" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="380" y="30" width="290" height="110" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="175" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">CWPP</text>
            <text x="175" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Runtime behavior of a</text>
            <text x="175" y="94" text-anchor="middle" font-size="11" fill="var(--text-secondary)">single running workload</text>
            <text x="175" y="118" text-anchor="middle" font-size="11" fill="var(--text-secondary)">VMs, containers, functions</text>

            <text x="525" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">CSPM</text>
            <text x="525" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Configuration posture across</text>
            <text x="525" y="94" text-anchor="middle" font-size="11" fill="var(--text-secondary)">the whole cloud environment</text>
            <text x="525" y="118" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Accounts, regions, providers</text>

            <text x="350" y="160" text-anchor="middle" font-size="12" font-style="italic" fill="var(--text-secondary)">Complementary layers, not the same tool</text>
        </svg>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>CWPP</th>
                <th>CSPM</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Scope</td>
                <td>Individual running workload</td>
                <td>Entire cloud environment</td>
            </tr>
            <tr>
                <td>Focus</td>
                <td>Runtime behavior</td>
                <td>Configuration and posture</td>
            </tr>
            <tr>
                <td>Example capability</td>
                <td>Detecting an unexpected process</td>
                <td>Flagging an open storage bucket</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You are monitoring a small fleet of cloud workloads through a CWPP console. The alert feed shows recent activity across every workload, and one of them has been compromised. Your job is to investigate the runtime activity and file integrity status of each workload and correctly identify which one was breached and how.</p>

    <p>Use the Runtime Activity and File Integrity tabs inside each workload's detail panel to gather evidence before making your call.</p>

    <div class="practical-launch-wrapper">
        <a href="cloud-workload-protection-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Cloud Workload Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You now understand how Cloud Workload Protection Platforms secure workloads across their entire lifecycle. Runtime protection watches behavior as it happens, file integrity monitoring detects unauthorized change, vulnerability assessment prioritizes by real exposure and exploitability, and just-in-time access limits how much standing privilege exists to abuse. CSPM and policy-as-code tie all of this together with continuous, consistent posture across every cloud provider in use.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Runtime protection catches threats as they occur, across VMs, containers, and serverless functions.</li>
        <li>File integrity monitoring detects unauthorized change through hash comparison, it does not prevent it.</li>
        <li>Vulnerability assessment must weigh exposure and exploitability, not just CVSS severity.</li>
        <li>Just-in-time access limits standing privilege that attackers can quietly reuse.</li>
        <li>CSPM and policy-as-code keep multi-cloud posture consistent, auditable, and drift-free.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA, engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
